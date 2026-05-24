<?php
namespace GlpiPlugin\Aiticketrouter\Model;

class TechnicianModel {
    /**
     * Récupère la liste des techniciens avec leur charge de travail
     */
    public function getTechnicians(): array {
        global $DB;
        $rows = [];

        $users_it = $DB->request([
            'SELECT' => ['id', 'name', 'firstname', 'realname'],
            'FROM'   => 'glpi_users',
            'WHERE'  => [
                'is_active'  => 1,
                'is_deleted' => 0,
                ['NOT' => ['name' => ['glpi-system', 'post-only', 'normal', 'guest']]],
                ['id' => ['>', 1]],
            ],
            'ORDER' => 'name ASC',
        ]);

        foreach ($users_it as $user) {
            $count = $this->countOpenTickets((int)$user['id']);
            $fullname = trim($user['firstname'] . ' ' . $user['realname']) ?: $user['name'];
            $rows[] = [
                'id'           => $user['id'],
                'name'         => $user['name'],
                'display_name' => $fullname,
                'open_tickets' => $count,
            ];
        }

        usort($rows, function($a, $b) { 
            return $a['open_tickets'] <=> $b['open_tickets']; 
        });
        return $rows;
    }

    /**
     * Compte le nombre de tickets ouverts pour un technicien
     */
    public function countOpenTickets(int $user_id): int {
        global $DB;
        $count = 0;
        foreach ($DB->request([
            'COUNT'    => 'cnt',
            'FROM'     => 'glpi_tickets_users',
            'LEFT JOIN'=> [
                'glpi_tickets' => ['ON' => [
                    'glpi_tickets_users' => 'tickets_id',
                    'glpi_tickets'       => 'id',
                ]]
            ],
            'WHERE' => [
                'glpi_tickets_users.users_id' => $user_id,
                'glpi_tickets_users.type'     => 2,
                ['NOT' => ['glpi_tickets.status' => [5, 6]]],
                'glpi_tickets.is_deleted'     => 0,
            ],
        ]) as $c) { 
            $count = (int)$c['cnt']; 
        }
        return $count;
    }

    /**
     * Récupère les infos d'un technicien par ID
     */
    public function getTechnicianById(int $uid): ?array {
        global $DB;
        foreach ($DB->request([
            'SELECT' => ['id', 'name', 'firstname', 'realname'],
            'FROM'   => 'glpi_users',
            'WHERE'  => ['id' => $uid],
        ]) as $u) {
            return $u;
        }
        return null;
    }



    
   //what i addedd 
    /**
     * Get technicians with skills and workload for AI routing
     * Enhanced version for AI suggestion
     */
    public function getTechniciansForAI(): array {
        global $DB;
        $rows = [];

        $users_it = $DB->request([
            'SELECT' => ['id', 'name', 'firstname', 'realname', 'email'],
            'FROM'   => 'glpi_users',
            'WHERE'  => [
                'is_active'  => 1,
                'is_deleted' => 0,
                ['NOT' => ['name' => ['glpi-system', 'post-only', 'normal', 'guest']]],
                ['id' => ['>', 1]],
            ],
            'ORDER' => 'name ASC',
        ]);

        $maxTickets = PluginConfig::getTechMaxTickets();
        $excludeAbsents = PluginConfig::excludeAbsents();

        foreach ($users_it as $user) {
            $count = $this->countOpenTickets((int)$user['id']);
            
            // Skip overloaded technicians
            if ($count >= $maxTickets) {
                continue;
            }
            
            $fullname = trim($user['firstname'] . ' ' . $user['realname']) ?: $user['name'];
            
            $rows[] = [
                'id'              => $user['id'],
                'name'            => $user['name'],
                'display_name'    => $fullname,
                'email'           => $user['email'] ?? '',
                'open_tickets'    => $count,
                'max_tickets'     => $maxTickets,
                'available_slots' => $maxTickets - $count,
                'workload_score'  => $this->calculateWorkloadScore($count, $maxTickets),
                'skills'          => $this->getTechnicianSkills($user['id']),
                'experience'      => $this->getTechnicianExperience($user['id'])
            ];
        }

        // Sort based on selection mode
        $mode = PluginConfig::getTechSelectionMode();
        return $this->sortTechniciansForAI($rows, $mode);
    }
    
    /**
     * Get technician skills based on their resolved tickets history
     * Extracts keywords from categories they've worked on
     */
    public function getTechnicianSkills(int $userId): array {
        global $DB;
        
        $skills = [];
        
        // Get categories from resolved tickets
        $query = "SELECT DISTINCT LOWER(TRIM(c.name)) as skill_name, COUNT(*) as count
                  FROM glpi_tickets t
                  INNER JOIN glpi_itilcategories c ON c.id = t.itilcategories_id
                  INNER JOIN glpi_tickets_users tu ON tu.tickets_id = t.id
                  WHERE tu.users_id = $userId 
                  AND tu.type = 2
                  AND t.status IN (5, 6) -- CLOSED or SOLVED
                  AND t.is_deleted = 0
                  AND c.name IS NOT NULL
                  AND c.name != ''
                  GROUP BY c.id
                  ORDER BY count DESC
                  LIMIT 15";
        
        $result = $DB->query($query);
        if ($result) {
            while ($data = $DB->fetchAssoc($result)) {
                $skills[] = $data['skill_name'];
            }
        }
        
        // Also add based on user's group expertise
        $groupSkills = $this->getGroupSkills($userId);
        $skills = array_merge($skills, $groupSkills);
        
        return array_unique($skills);
    }
    
    /**
     * Get skills based on user's groups
     */
    private function getGroupSkills(int $userId): array {
        global $DB;
        
        $skills = [];
        
        $query = "SELECT DISTINCT LOWER(g.name) as skill
                  FROM glpi_groups_users gu
                  INNER JOIN glpi_groups g ON g.id = gu.groups_id
                  WHERE gu.users_id = $userId
                  AND g.is_active = 1";
        
        $result = $DB->query($query);
        if ($result) {
            while ($data = $DB->fetchAssoc($result)) {
                $skills[] = $data['skill'];
            }
        }
        
        return $skills;
    }
    
    /**
     * Get technician experience level based on ticket history
     */
    private function getTechnicianExperience(int $userId): array {
        global $DB;
        
        $experience = [
            'total_tickets' => 0,
            'total_resolved' => 0,
            'avg_resolution_time' => 0,
            'expertise_level' => 'junior'
        ];
        
        // Get total resolved tickets
        $query = "SELECT COUNT(*) as total, AVG(TIMESTAMPDIFF(HOUR, date, solvedate)) as avg_time
                  FROM glpi_tickets t
                  INNER JOIN glpi_tickets_users tu ON tu.tickets_id = t.id
                  WHERE tu.users_id = $userId
                  AND tu.type = 2
                  AND t.status IN (5, 6)
                  AND t.is_deleted = 0";
        
        $result = $DB->query($query);
        if ($result && $data = $DB->fetchAssoc($result)) {
            $experience['total_resolved'] = (int)$data['total'];
            $experience['avg_resolution_time'] = round($data['avg_time'] ?? 0, 1);
            
            // Determine expertise level
            if ($experience['total_resolved'] > 500) {
                $experience['expertise_level'] = 'expert';
            } elseif ($experience['total_resolved'] > 200) {
                $experience['expertise_level'] = 'senior';
            } elseif ($experience['total_resolved'] > 50) {
                $experience['expertise_level'] = 'intermediate';
            } else {
                $experience['expertise_level'] = 'junior';
            }
        }
        
        return $experience;
    }
    
    /**
     * Calculate workload score (0-1, higher means more available)
     */
    private function calculateWorkloadScore(int $currentTickets, int $maxTickets): float {
        if ($maxTickets <= 0) return 0;
        $score = 1 - ($currentTickets / $maxTickets);
        return round($score, 2);
    }
    
    /**
     * Sort technicians based on selection mode for AI
     */
    private function sortTechniciansForAI(array $technicians, string $mode): array {
        if (empty($technicians)) {
            return $technicians;
        }
        
        switch ($mode) {
            case 'less_loaded':
                // Sort by workload (less loaded first)
                usort($technicians, function($a, $b) {
                    return $b['workload_score'] <=> $a['workload_score'];
                });
                break;
                
            case 'most_experienced':
                // Sort by experience (more experienced first)
                usort($technicians, function($a, $b) {
                    $expA = $a['experience']['total_resolved'] ?? 0;
                    $expB = $b['experience']['total_resolved'] ?? 0;
                    return $expB <=> $expA;
                });
                break;
                
            case 'balanced':
                // Balance workload (60%) and experience (40%)
                usort($technicians, function($a, $b) {
                    $maxExp = max(
                        $a['experience']['total_resolved'] ?? 1,
                        $b['experience']['total_resolved'] ?? 1,
                        1
                    );
                    
                    $scoreA = ($a['workload_score'] * 0.6) + 
                              ((($a['experience']['total_resolved'] ?? 0) / $maxExp) * 0.4);
                    $scoreB = ($b['workload_score'] * 0.6) + 
                              ((($b['experience']['total_resolved'] ?? 0) / $maxExp) * 0.4);
                    
                    return $scoreB <=> $scoreA;
                });
                break;
                
            default: // less_loaded by default
                usort($technicians, function($a, $b) {
                    return $a['open_tickets'] <=> $b['open_tickets'];
                });
        }
        
        return $technicians;
    }
    
    /**
     * Get technician by ID with full details for AI
     */
    public function getTechnicianByIdForAI(int $uid): ?array {
        global $DB;
        
        foreach ($DB->request([
            'SELECT' => ['id', 'name', 'firstname', 'realname', 'email'],
            'FROM'   => 'glpi_users',
            'WHERE'  => ['id' => $uid],
        ]) as $u) {
            $count = $this->countOpenTickets($uid);
            $maxTickets = PluginConfig::getTechMaxTickets();
            
            return [
                'id'           => $u['id'],
                'name'         => $u['name'],
                'display_name' => trim($u['firstname'] . ' ' . $u['realname']) ?: $u['name'],
                'email'        => $u['email'] ?? '',
                'open_tickets' => $count,
                'skills'       => $this->getTechnicianSkills($uid),
                'experience'   => $this->getTechnicianExperience($uid),
                'workload_score' => $this->calculateWorkloadScore($count, $maxTickets)
            ];
        }
        
        return null;
    }
}

