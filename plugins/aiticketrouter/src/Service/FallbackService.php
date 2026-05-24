<?php
namespace GlpiPlugin\Aiticketrouter\Service;

class FallbackService {
    /**
     * Détecte la catégorie et calcule les priorités par mots-clés
     */
    public function analyzeTicket(string $texte_complet): array {
        // 1. Détection de la catégorie
        $cat_result = $this->detectCategory($texte_complet);
        $category = $cat_result['category'];
        $detected_keywords = $cat_result['keyword'] ? [$cat_result['keyword']] : [];
        
        // 2. Détection de l'urgence
        $urgency = 3;
        foreach ([
            5 => ['urgent','critique','grave','panne totale','down','planté','crash','immédiat'],
            4 => ['important','rapidement','bloqué','erreur','bug','problème','dépanner'],
            2 => ['question','aide','info','suggestion','tutoriel'],
        ] as $lvl => $kws) {
            foreach ($kws as $kw) {
                if (strpos($texte_complet, $kw) !== false) {
                    $urgency = $lvl; 
                    $detected_keywords[] = $kw; 
                    break 2;
                }
            }
        }
        
        // 3. Détection de l'impact
        $impact = 3;
        foreach ([
            5 => ['tout le monde','toute l equipe','plus personne','tous les postes','entreprise entière'],
            4 => ['plusieurs','toute l équipe','équipe','service','bureau','département'],
            2 => ['moi seul','mon poste','personnel','individuel'],
        ] as $lvl => $kws) {
            foreach ($kws as $kw) {
                if (strpos($texte_complet, $kw) !== false) {
                    $impact = $lvl; 
                    $detected_keywords[] = $kw; 
                    break 2;
                }
            }
        }
        
        // 4. Calcul de priorité matrice standard GLPI
        $pm = [
            1=>[1=>1,2=>1,3=>2,4=>3,5=>3], 2=>[1=>1,2=>2,3=>3,4=>4,5=>4],
            3=>[1=>2,2=>3,3=>3,4=>4,5=>5], 4=>[1=>3,2=>4,3=>4,4=>5,5=>5],
            5=>[1=>3,2=>4,3=>5,4=>5,5=>5],
        ];
        $priority = $pm[$urgency][$impact];

        return [
            'category'          => $category,
            'detected_keywords' => array_unique(array_filter($detected_keywords)),
            'urgency'           => $urgency,
            'impact'            => $impact,
            'priority'          => $priority,
        ];
    }

    private function detectCategory(string $texte): array {
        $categories = [
            'Matériel' => ['imprimante','écran','souris','clavier','ordinateur','pc','disque dur','ram','câble','usb'],
            'Réseau'   => ['réseau','wifi','internet','connexion','ethernet','switch','routeur','panne réseau','sans fil'],
            'Logiciel' => ['bug','erreur','logiciel','application','programme','windows','office','excel','word','crash'],
            'Sécurité' => ['mot de passe','accès','virus','piratage','sécurité','authentification','compte bloqué'],
        ];
        foreach ($categories as $cat => $kws) {
            foreach ($kws as $kw) {
                if (strpos($texte, $kw) !== false) {
                    return ['category' => $cat, 'keyword' => $kw];
                }
            }
        }
        return ['category' => 'Général', 'keyword' => ''];
    }

    /**
     * Retourne des pistes de résolution selon la catégorie
     */
    public function getSolutions(string $category, string $texte): array {
        $map = [
            'Réseau' => [
                "Vérifier que le câble Ethernet est bien branché, puis redémarrer le switch ou la box.",
                "Désactiver puis réactiver la carte réseau (Panneau de configuration → Réseau).",
                "Tester la connexion sur un autre appareil pour isoler le problème.",
                "Relancer le service DHCP côté serveur si plusieurs postes sont affectés.",
                "Vérifier les DEL du switch : une DEL orange fixe indique souvent un problème physique.",
            ],
            'Matériel' => [
                "Vérifier tous les branchements et câbles de l'équipement concerné.",
                "Redémarrer l'équipement et tester à nouveau.",
                "Tester avec un autre câble ou un autre port (USB, HDMI, VGA).",
                "Vérifier le Gestionnaire de périphériques pour un pilote en erreur.",
                "Si imprimante : vider la file d'attente et réinstaller le pilote.",
            ],
            'Logiciel' => [
                "Fermer et relancer l'application concernée.",
                "Vider le cache (dossier Temp / AppData\\Local\\Temp).",
                "Vérifier si une mise à jour du logiciel est disponible.",
                "Désinstaller puis réinstaller proprement l'application.",
                "Consulter l'Observateur d'événements Windows pour les logs d'erreur.",
            ],
            'Sécurité' => [
                "Réinitialiser le mot de passe depuis le portail IT ou via Active Directory.",
                "Vérifier si le compte est verrouillé (trop de tentatives échouées).",
                "Si suspicion de virus : scanner le poste avec l'antivirus à jour.",
                "Contacter immédiatement la sécurité informatique si suspicion de piratage.",
                "Vérifier les accès récents dans les journaux système.",
            ],
            'Général' => [
                "Redémarrer le poste de travail et tester à nouveau.",
                "Décrire précisément les étapes qui mènent au problème.",
                "Vérifier si le problème apparaît sur un autre compte utilisateur.",
            ],
        ];

        $solutions = $map[$category] ?? $map['Général'];

        if (strpos($texte, 'wifi') !== false || strpos($texte, 'sans fil') !== false) {
            $solutions[] = "Oublier le réseau WiFi et se reconnecter avec le bon mot de passe.";
        }
        if (strpos($texte, 'bloqué') !== false || strpos($texte, 'gelé') !== false) {
            $solutions[] = "Forcer la fermeture (Ctrl+Alt+Suppr → Gestionnaire des tâches → Fin de tâche).";
        }
        if (strpos($texte, 'lent') !== false) {
            $solutions[] = "Vérifier l'utilisation CPU/RAM dans le Gestionnaire des tâches.";
        }

        return $solutions;
    }





   //what i added
    
    /**
     * Suggest technician using keyword matching (fallback when AI fails)
     */
    public function suggestTechnician(array $ticketData, array $technicians): ?array {
        if (empty($technicians)) {
            return null;
        }
        
        // Extract keywords from ticket
        $keywords = $this->extractKeywords($ticketData);
        
        // Score each technician based on keyword matches and workload
        $scored = [];
        foreach ($technicians as $tech) {
            $score = $this->calculateMatchScore($tech, $keywords);
            $scored[] = [
                'technician_id' => $tech['id'],
                'score' => $score,
                'reason' => $this->generateReason($tech, $score, $keywords),
                'confidence' => min(85, round($score * 100)),
                'from_fallback' => true
            ];
        }
        
        // Sort by score descending
        usort($scored, function($a, $b) {
            return $b['score'] <=> $a['score'];
        });
        
        // Return best match if score > 0
        if (!empty($scored) && $scored[0]['score'] > 0.2) {
            return $scored[0];
        }
        
        // Return least loaded technician if no good match
        if (!empty($technicians)) {
            return [
                'technician_id' => $technicians[0]['id'],
                'reason' => 'No keyword matches found - assigned to least loaded technician',
                'confidence' => 40,
                'from_fallback' => true
            ];
        }
        
        return null;
    }
    
    /**
     * Extract keywords from ticket data
     */
    private function extractKeywords(array $ticketData): array {
        $keywords = [];
        
        $text = strtolower(
            $ticketData['name'] . ' ' . 
            $ticketData['content'] . ' ' . 
            $ticketData['category']
        );
        
        // Common IT keywords to look for
        $commonKeywords = [
            'network', 'server', 'database', 'email', 'printer', 'computer',
            'windows', 'linux', 'mac', 'vpn', 'wifi', 'router', 'switch',
            'backup', 'security', 'virus', 'password', 'account', 'access',
            'software', 'hardware', 'installation', 'update', 'configuration'
        ];
        
        foreach ($commonKeywords as $keyword) {
            if (strpos($text, $keyword) !== false) {
                $keywords[] = $keyword;
            }
        }
        
        return array_unique($keywords);
    }
    
    /**
     * Calculate match score between technician skills and ticket keywords
     */
    private function calculateMatchScore(array $technician, array $keywords): float {
        if (empty($keywords)) {
            // If no keywords, base score on workload only
            return $technician['workload_score'] ?? 0.5;
        }
        
        $techSkills = array_map('strtolower', $technician['skills'] ?? []);
        if (empty($techSkills)) {
            // No skills defined, base on workload
            return $technician['workload_score'] ?? 0.3;
        }
        
        $matches = 0;
        foreach ($keywords as $keyword) {
            foreach ($techSkills as $skill) {
                if (strpos($skill, $keyword) !== false || strpos($keyword, $skill) !== false) {
                    $matches++;
                    break;
                }
            }
        }
        
        $skillMatchScore = $matches / max(count($keywords), 1);
        
        // Combine skill match (70%) and workload (30%)
        $workloadScore = $technician['workload_score'] ?? 0.5;
        $finalScore = ($skillMatchScore * 0.7) + ($workloadScore * 0.3);
        
        return round($finalScore, 2);
    }
    
    /**
     * Generate human-readable reason for suggestion
     */
    private function generateReason(array $technician, float $score, array $keywords): string {
        $parts = [];
        
        if (!empty($keywords)) {
            $matchedSkills = [];
            $techSkills = array_map('strtolower', $technician['skills'] ?? []);
            
            foreach ($keywords as $keyword) {
                foreach ($techSkills as $skill) {
                    if (strpos($skill, $keyword) !== false) {
                        $matchedSkills[] = $keyword;
                        break;
                    }
                }
            }
            
            if (!empty($matchedSkills)) {
                $parts[] = "Skills match for: " . implode(', ', array_slice($matchedSkills, 0, 3));
            }
        }
        
        $parts[] = "Current workload: {$technician['open_tickets']}/{$technician['max_tickets']} tickets";
        
        if ($technician['experience']['total_resolved'] ?? 0 > 0) {
            $parts[] = "Experience: {$technician['experience']['total_resolved']} resolved tickets";
        }
        
        return implode(' | ', $parts);
    }

}


