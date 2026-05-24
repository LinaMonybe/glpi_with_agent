<?php
namespace GlpiPlugin\Aiticketrouter\Controller;

require_once dirname(__DIR__) . '/Model/AiSuggestionModel.php';

use GlpiPlugin\Aiticketrouter\Model\AiSuggestionModel;
use GlpiPlugin\Aiticketrouter\Model\TechnicianModel;
use GlpiPlugin\Aiticketrouter\Service\AI\ProviderFactory;
use GlpiPlugin\Aiticketrouter\Service\FallbackService;
use GlpiPlugin\Aiticketrouter\View\FollowupView;
use CommonDBTM;
use Exception;
use ITILFollowup;
use Session;
use Ticket;

class TicketRoutingController
{
    private $technicianModel;
    private $fallbackService;
    private $followupView;
    private $aiSuggestionModel;

    private const DEBUG_LOG = __DIR__ . '/../../debug_suggestion.txt';

    private function log(string $msg): void
    {
        file_put_contents(self::DEBUG_LOG, date('Y-m-d H:i:s') . " | $msg\n", FILE_APPEND);
    }

    public function __construct()
    {
        $this->technicianModel   = new TechnicianModel();
        $this->fallbackService   = new FallbackService();
        $this->followupView      = new FollowupView();
        $this->aiSuggestionModel = new AiSuggestionModel();
        $this->log("__construct OK");
    }

    public function onTicketAdd(CommonDBTM $item): void
    {
        if ($item->getType() !== 'Ticket') return;

        $ticket_id = $item->getID();
        if (!$ticket_id) return;

        $this->log("=== onTicketAdd — ticket #$ticket_id ===");

        $titre         = $item->fields['name']    ?? '';
        $contenu       = $item->fields['content'] ?? '';
        $texte_complet = strtolower(strip_tags($titre . ' ' . $contenu));

        // ----------------------------------------------------------------
        // 1. Analyse IA ou Fallback
        // ----------------------------------------------------------------
        $ai_used           = false;
        $ai_provider_name  = 'fallback';
        $category          = 'Général';
        $detected_keywords = [];
        $urgency           = 3;
        $impact            = 3;
        $priority          = 3;
        $aiProvider        = null;
        $ai_result         = null;

        try {
            $aiProvider = ProviderFactory::create();
            $ai_result  = $aiProvider->analyzeTicket($titre, $contenu);
        } catch (Exception $e) {
            $this->log("ProviderFactory ERROR : " . $e->getMessage());
        }

        if ($ai_result && isset($ai_result['category'])) {
            $category          = $ai_result['category'];
            $urgency           = $ai_result['urgency'];
            $impact            = $ai_result['impact'];
            $priority          = $ai_result['priority'];
            $detected_keywords = ['AI Classifié'];
            $ai_used           = true;
            $ai_provider_name  = \GlpiPlugin\Aiticketrouter\Config\PluginConfig::getConfig('active_ai_provider', 'gemini');
            $this->log("IA OK — cat=$category u=$urgency i=$impact p=$priority");

            file_put_contents(dirname(__DIR__, 2) . '/log_ai.txt',
                date('Y-m-d H:i:s') . " | Ticket #$ticket_id | IA | Catégorie: $category\n", FILE_APPEND);
        } else {
            $fallback          = $this->fallbackService->analyzeTicket($texte_complet);
            $category          = $fallback['category'];
            $detected_keywords = $fallback['detected_keywords'];
            $urgency           = $fallback['urgency'];
            $impact            = $fallback['impact'];
            $priority          = $fallback['priority'];
            $ai_used           = false;
            $ai_provider_name  = 'fallback';
            $this->log("Fallback — cat=$category u=$urgency i=$impact p=$priority");
        }

        // ----------------------------------------------------------------
        // SUPPRIMÉ : mise à jour automatique urgency/impact/priority
        // Ces valeurs sont maintenant uniquement SUGGÉRÉES dans le followup.
        // Le technicien peut les appliquer manuellement via le bouton "Appliquer".
        // ----------------------------------------------------------------

        // ----------------------------------------------------------------
        // 2. Solutions
        // ----------------------------------------------------------------
        $solutions_array = $this->fallbackService->getSolutions($category, $texte_complet);
        $solutions_html  = null;

        if ($aiProvider !== null) {
            try {
                $solutions_html = $aiProvider->getSolutions($category, $texte_complet);
            } catch (Exception $e) {
                $this->log("getSolutions ERROR : " . $e->getMessage());
            }
        }

        if ($solutions_html === null) {
            $solutions_html = '<ul><li>'
                . implode('</li><li>', array_map('htmlspecialchars', $solutions_array))
                . '</li></ul>';
        }

        // ----------------------------------------------------------------
        // 3. Technicien suggéré
        // ----------------------------------------------------------------
        $max_tickets = (int)\GlpiPlugin\Aiticketrouter\Config\PluginConfig::getConfig('tech_max_tickets', 8);
        $technicians = $this->technicianModel->getTechnicians();
        $available   = array_values(array_filter($technicians, fn($t) => $t['open_tickets'] < $max_tickets));
        $overloaded  = array_values(array_filter($technicians, fn($t) => $t['open_tickets'] >= $max_tickets));
        $suggested   = $available[0] ?? null;

        $this->log("Technicien : " . ($suggested
            ? "{$suggested['display_name']} (id={$suggested['id']})"
            : "aucun disponible"));

        // ----------------------------------------------------------------
        // 4. Sauvegarde dans ai_suggestions (suggestion seulement, pas le ticket)
        // ----------------------------------------------------------------
        try {
            $saved_id = $this->aiSuggestionModel->save($ticket_id, [
                'category'          => $category,
                'urgency'           => $urgency,
                'impact'            => $impact,
                'priority'          => $priority,
                'suggested'         => $suggested,
                'solutions'         => $solutions_html,
                'ai_used'           => $ai_used,
                'ai_provider'       => $ai_provider_name,
                'detected_keywords' => $detected_keywords,
            ]);
            $this->log($saved_id !== false
                ? "save() OK — id=$saved_id ✓"
                : "ERREUR save() retourné false");
        } catch (Exception $e) {
            $this->log("EXCEPTION save() : " . $e->getMessage());
        }

        // ----------------------------------------------------------------
        // 5. Followup — affiche les suggestions, le technicien clique Appliquer
        // ----------------------------------------------------------------
        $viewData = [
            'ticket_id'         => $ticket_id,
            'category'          => $category,
            'detected_keywords' => $detected_keywords,
            'urgency'           => $urgency,
            'impact'            => $impact,
            'priority'          => $priority,
            'ai_used'           => $ai_used,
            'suggested'         => $suggested,
            'all_techs'         => array_merge($available, $overloaded),
            'solutions'         => $solutions_html,
            'max_tickets'       => $max_tickets,
        ];

        $content = $this->followupView->render($viewData);

        try {
            $fu     = new ITILFollowup();
            $result = $fu->add([
                'itemtype'        => 'Ticket',
                'items_id'        => $ticket_id,
                'users_id'        => 0,
                'content'         => $content,
                'is_private'      => 0,
                'requesttypes_id' => 0,
                'date'            => date('Y-m-d H:i:s'),
            ]);
            if (!$result) throw new Exception("ITILFollowup::add() retourné false");
            $this->log("Followup ajouté OK");
        } catch (Exception $e) {
            global $DB;
            try {
                $DB->insert('glpi_itilfollowups', [
                    'itemtype'        => 'Ticket',
                    'items_id'        => $ticket_id,
                    'users_id'        => 0,
                    'content'         => $content,
                    'is_private'      => 0,
                    'requesttypes_id' => 0,
                    'date'            => date('Y-m-d H:i:s'),
                    'date_mod'        => date('Y-m-d H:i:s'),
                    'date_creation'   => date('Y-m-d H:i:s'),
                ]);
                $this->log("Followup inséré via DB->insert (fallback)");
            } catch (Exception $e2) {
                $this->log("EXCEPTION followup : " . $e2->getMessage());
                file_put_contents(dirname(__DIR__, 2) . '/debug_error.txt',
                    date('Y-m-d H:i:s') . " " . $e2->getMessage() . "\n", FILE_APPEND);
            }
        }

        $this->log("=== Fin onTicketAdd #$ticket_id ===\n");
    }

    public function blockOverloadedTech(CommonDBTM $item): void
    {
        if ($item->getType() !== 'Ticket') return;

        $input = $item->input;
        if (empty($input)) return;

        $tech_ids_to_assign = [];

        $actors_assign = $input['_actors']['assign'] ?? null;
        if (is_array($actors_assign)) {
            foreach ($actors_assign as $actor) {
                if (is_array($actor)
                    && isset($actor['items_id'], $actor['itemtype'])
                    && $actor['itemtype'] === 'User'
                ) {
                    $tech_ids_to_assign[] = (int)$actor['items_id'];
                }
            }
        }

        if (!empty($input['_users_id_assign'])) {
            $assign = $input['_users_id_assign'];
            if (is_array($assign)) {
                foreach ($assign as $uid) $tech_ids_to_assign[] = (int)$uid;
            } else {
                $tech_ids_to_assign[] = (int)$assign;
            }
        }

        if (empty($tech_ids_to_assign)) return;

        $max_tickets = (int)\GlpiPlugin\Aiticketrouter\Config\PluginConfig::getConfig('tech_max_tickets', 8);

        foreach ($tech_ids_to_assign as $uid) {
            if (!$uid) continue;
            $open_count = $this->technicianModel->countOpenTickets($uid);
            if ($open_count >= $max_tickets) {
                $tech_name = "ID $uid";
                $u = $this->technicianModel->getTechnicianById($uid);
                if ($u) {
                    $tech_name = trim($u['firstname'] . ' ' . $u['realname']) ?: $u['name'];
                }
                unset($item->input['_actors']);
                unset($item->input['_users_id_assign']);
                Session::addMessageAfterRedirect(
                    sprintf(
                        'AI Ticket Router — Assignation bloquée : %s a déjà %d tickets ouverts (maximum : %d). '
                        . 'Veuillez choisir un technicien moins chargé.',
                        $tech_name, $open_count, $max_tickets
                    ),
                    true, ERROR
                );
                file_put_contents(dirname(__DIR__, 2) . '/log_tickets.txt',
                    date('Y-m-d H:i:s') . " | BLOCAGE tech $tech_name (ID=$uid, tickets=$open_count, max=$max_tickets)\n",
                    FILE_APPEND);
                return;
            }
        }
    }

    
    //what i added

    
    
    
    /**
     * Route ticket to best technician
     */
    public function routeTicket(int $ticketId): ?array {
        // Check if routing is enabled
        if (!PluginConfig::getConfig('ticket_suggest_tech', '1')) {
            return null;
        }
        
        // Get ticket
        $ticket = new Ticket();
        if (!$ticket->getFromDB($ticketId)) {
            return null;
        }
        
        // Get available technicians
        $technicians = $this->technicianModel->getTechniciansForAI();
        if (empty($technicians)) {
            Toolbox::logInfo("No available technicians for ticket #$ticketId");
            return null;
        }
        
        // Extract ticket data
        $ticketData = $this->extractTicketData($ticket);
        
        // Get suggestion
        $suggestion = $this->getSuggestion($ticketData, $technicians);
        
        // Assign technician if suggested
        if ($suggestion && isset($suggestion['technician_id'])) {
            return $this->assignTechnician($ticketId, $suggestion);
        }
        
        return null;
    }
    
    /**
     * Extract ticket data for analysis
     */
    private function extractTicketData($ticket): array {
        global $DB;
        
        // Get category
        $category = '';
        if ($ticket->fields['itilcategories_id'] > 0) {
            $cat = new \ITILCategory();
            if ($cat->getFromDB($ticket->fields['itilcategories_id'])) {
                $category = $cat->fields['name'];
            }
        }
        
        return [
            'id' => $ticket->fields['id'],
            'name' => $ticket->fields['name'] ?? '',
            'content' => $ticket->fields['content'] ?? '',
            'category' => $category,
            'priority' => $ticket->fields['priority'] ?? 3
        ];
    }
    
    /**
     * Get technician suggestion (AI or fallback)
     */
    private function getSuggestion(array $ticketData, array $technicians): ?array {
        // Try AI if available
        if ($this->aiProvider) {
            try {
                $analysis = $this->aiProvider->analyzeTicket(
                    $ticketData['name'],
                    $ticketData['content'],
                    $ticketData['category']
                );
                
                if ($analysis) {
                    $suggestion = $this->aiProvider->suggestTechnician($analysis, $technicians);
                    if ($suggestion && isset($suggestion['technician_id'])) {
                        $suggestion['from_ai'] = true;
                        return $suggestion;
                    }
                }
            } catch (\Exception $e) {
                Toolbox::logError("AI suggestion failed: " . $e->getMessage());
            }
        }
        
        // Fallback
        if (PluginConfig::useFallback()) {
            $fallback = new FallbackService();
            return $fallback->suggestTechnician($ticketData, $technicians);
        }
        
        return null;
    }
    
    /**
     * Assign technician to ticket
     */
    private function assignTechnician(int $ticketId, array $suggestion): ?array {
        $ticket = new Ticket();
        
        $result = $ticket->update([
            'id' => $ticketId,
            'users_id_assign' => $suggestion['technician_id'],
            '_disablenotif' => false
        ]);
        
        if ($result) {
            $this->addFollowup($ticketId, $suggestion);
            Toolbox::logInfo("Ticket #$ticketId assigned to technician ID {$suggestion['technician_id']}");
            return $suggestion;
        }
        
        return null;
    }
    
    /**
     * Add followup with suggestion details
     */
    private function addFollowup(int $ticketId, array $suggestion): void {
        $followup = new TicketFollowup();
        
        $source = isset($suggestion['from_ai']) ? '🤖 AI Analysis' : '⚙️ Fallback System';
        $confidence = $suggestion['confidence'] ?? 75;
        $reason = $suggestion['reason'] ?? 'Best match based on skills and workload';
        
        $content = "<div style='background: #e8f5e9; padding: 12px; border-left: 4px solid #4caf50; margin: 10px 0;'>";
        $content .= "<strong>{$source} - Technician Suggestion</strong><br><br>";
        $content .= "<strong>Suggested Technician:</strong> ID #{$suggestion['technician_id']}<br>";
        $content .= "<strong>Reason:</strong> {$reason}<br>";
        $content .= "<strong>Confidence:</strong> {$confidence}%<br>";
        
        if (isset($suggestion['from_ai'])) {
            $content .= "<strong>Method:</strong> AI-powered skill matching<br>";
        } else {
            $content .= "<strong>Method:</strong> Keyword-based matching<br>";
        }
        
        $content .= "</div>";
        
        $followup->add([
            'tickets_id' => $ticketId,
            'content' => $content,
            'users_id' => 0,
            'date' => date('Y-m-d H:i:s'),
            'is_private' => 0
        ]);
    }

}