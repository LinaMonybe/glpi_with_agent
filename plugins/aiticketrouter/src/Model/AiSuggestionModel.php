<?php
namespace GlpiPlugin\Aiticketrouter\Model;

class AiSuggestionModel
{
    private const TABLE = 'glpi_plugin_aiticketrouter_ai_suggestions';

    // ------------------------------------------------------------------
    // ÉCRITURE
    // ------------------------------------------------------------------

    /**
     * Enregistre ou met à jour une suggestion IA pour un ticket.
     *
     * Clés attendues dans $data :
     *   category           string
     *   urgency            int  (1-5)
     *   impact             int  (1-5)
     *   priority           int  (1-5)
     *   suggested          array|null  ['id', 'display_name', 'open_tickets']
     *   solutions          string  (HTML)
     *   ai_used            bool
     *   ai_provider        string|null
     *   detected_keywords  array
     *
     * @return int|false  ID de la ligne insérée/mise à jour, false en cas d'erreur
     */
    public function save(int $ticket_id, array $data)
    {
        global $DB;

        if (!$DB->tableExists(self::TABLE)) {
            return false;
        }

        $suggested     = $data['suggested']         ?? null;
        $solutions_raw = $data['solutions']          ?? null;
        $keywords      = $data['detected_keywords']  ?? [];

        // Normalise les solutions en chaîne
        $solutions_stored = is_array($solutions_raw)
            ? json_encode($solutions_raw, JSON_UNESCAPED_UNICODE)
            : (string)$solutions_raw;

        $row = [
            'tickets_id'          => $ticket_id,
            'category'            => (string)($data['category'] ?? ''),
            'urgency'             => (int)($data['urgency']     ?? 3),
            'impact'              => (int)($data['impact']      ?? 3),
            'priority'            => (int)($data['priority']    ?? 3),
            'suggested_tech_id'   => $suggested ? (int)$suggested['id']           : null,
            'suggested_tech_name' => $suggested ? (string)$suggested['display_name'] : null,
            'tech_open_tickets'   => $suggested ? (int)$suggested['open_tickets']  : 0,
            'solutions'           => $solutions_stored,
            'ai_used'             => (int)(bool)($data['ai_used']      ?? false),
            'ai_provider'         => $data['ai_provider']               ?? null,
            'detected_keywords'   => json_encode($keywords, JSON_UNESCAPED_UNICODE),
            'date_mod'            => date('Y-m-d H:i:s'),
        ];

        // Vérifie si une ligne existe déjà pour ce ticket
        $existing = $this->getByTicketId($ticket_id);

        if ($existing) {
            // Mise à jour
            $ok = $DB->update(self::TABLE, $row, ['id' => $existing['id']]);
            return $ok ? (int)$existing['id'] : false;
        }

        // Insertion
        $row['date_creation'] = date('Y-m-d H:i:s');
        $ok = $DB->insert(self::TABLE, $row);
        return $ok ? (int)$DB->insertId() : false;
    }

    // ------------------------------------------------------------------
    // LECTURE
    // ------------------------------------------------------------------

    /**
     * Récupère la suggestion pour un ticket donné.
     */
    public function getByTicketId(int $ticket_id): ?array
    {
        global $DB;

        if (!$DB->tableExists(self::TABLE)) {
            return null;
        }

        foreach ($DB->request([
            'FROM'  => self::TABLE,
            'WHERE' => ['tickets_id' => $ticket_id],
            'LIMIT' => 1,
        ]) as $row) {
            return $this->hydrate($row);
        }

        return null;
    }
public function getByTicket(int $ticket_id)
{
    global $DB;

    $sql = "SELECT *
            FROM glpi_plugin_aiticketrouter_ai_suggestions
            WHERE tickets_id = $ticket_id
            ORDER BY id DESC
            LIMIT 1";

    $res = $DB->query($sql);

    return $DB->fetchAssoc($res) ?: [];
}
    /**
     * Récupère toutes les suggestions (pour stats / dashboard).
     */
    public function getAll(int $limit = 50, int $offset = 0): array
    {
        global $DB;

        if (!$DB->tableExists(self::TABLE)) {
            return [];
        }

        $results = [];
        foreach ($DB->request([
            'FROM'  => self::TABLE,
            'ORDER' => 'date_creation DESC',
            'LIMIT' => $limit,
            'START' => $offset,
        ]) as $row) {
            $results[] = $this->hydrate($row);
        }

        return $results;
    }

    /**
     * Nombre total de suggestions enregistrées.
     */
    public function count(): int
    {
        global $DB;

        if (!$DB->tableExists(self::TABLE)) {
            return 0;
        }

        foreach ($DB->request(['COUNT' => 'cnt', 'FROM' => self::TABLE]) as $c) {
            return (int)$c['cnt'];
        }

        return 0;
    }

    /**
     * Statistiques globales (pour un futur dashboard).
     */
    public function getStats(): array
    {
        global $DB;

        if (!$DB->tableExists(self::TABLE)) {
            return [
                'total'         => 0,
                'ai_used'       => 0,
                'fallback_used' => 0,
                'by_provider'   => [],
                'by_category'   => [],
            ];
        }

        $total         = 0;
        $ai_used_count = 0;
        $by_provider   = [];
        $by_category   = [];

        foreach ($DB->request(['FROM' => self::TABLE]) as $row) {
            $total++;
            if ($row['ai_used']) {
                $ai_used_count++;
            }
            $prov = $row['ai_provider'] ?? 'inconnu';
            $by_provider[$prov] = ($by_provider[$prov] ?? 0) + 1;

            $cat = $row['category'] ?: 'Général';
            $by_category[$cat] = ($by_category[$cat] ?? 0) + 1;
        }

        return [
            'total'         => $total,
            'ai_used'       => $ai_used_count,
            'fallback_used' => $total - $ai_used_count,
            'by_provider'   => $by_provider,
            'by_category'   => $by_category,
        ];
    }

    // ------------------------------------------------------------------
    // SUPPRESSION
    // ------------------------------------------------------------------

    /**
     * Supprime la suggestion liée à un ticket.
     */
    public function deleteByTicketId(int $ticket_id): bool
    {
        global $DB;

        if (!$DB->tableExists(self::TABLE)) {
            return false;
        }

        return (bool)$DB->delete(self::TABLE, ['tickets_id' => $ticket_id]);
    }

    // ------------------------------------------------------------------
    // HYDRATATION
    // ------------------------------------------------------------------

    /**
     * Désérialise les champs JSON et retourne un tableau propre.
     */
    private function hydrate(array $row): array
    {
        // detected_keywords : toujours un tableau
        $row['detected_keywords'] = json_decode(
            $row['detected_keywords'] ?? '[]', true
        ) ?? [];

        // solutions : JSON valide → tableau, sinon on garde le HTML brut
        $decoded = json_decode($row['solutions'] ?? '', true);
        $row['solutions'] = (json_last_error() === JSON_ERROR_NONE && is_array($decoded))
            ? $decoded
            : ($row['solutions'] ?? '');

        // Casts sûrs
        $row['id']                = (int)$row['id'];
        $row['tickets_id']        = (int)$row['tickets_id'];
        $row['urgency']           = (int)$row['urgency'];
        $row['impact']            = (int)$row['impact'];
        $row['priority']          = (int)$row['priority'];
        $row['ai_used']           = (bool)$row['ai_used'];
        $row['tech_open_tickets'] = (int)($row['tech_open_tickets'] ?? 0);

        return $row;
    }
}