<?php

namespace GlpiPlugin\Aiticketrouter\Config;

use DBmysql;

class PluginConfig {
    
    private const TABLE = 'glpi_plugin_aiticketrouter_configs';

    /**
     * Récupère la valeur d'une configuration.
     *
     * @param string $name Nom du paramètre
     * @param mixed $default Valeur par défaut si non trouvée
     * @return mixed
     */
    public static function getConfig(string $name, $default = null) {
        global $DB;
        
        if (!$DB->tableExists(self::TABLE)) {
            return $default;
        }

        $iterator = $DB->request([
            'SELECT' => 'value',
            'FROM'   => self::TABLE,
            'WHERE'  => ['name' => $name]
        ]);

        if (count($iterator) > 0) {
            $row = $iterator->current();
            return $row['value'];
        }

        return $default;
    }

    /**
     * Définit ou met à jour la valeur d'une configuration.
     *
     * @param string $name Nom du paramètre
     * @param mixed $value Nouvelle valeur
     * @return bool
     */
    public static function setConfig(string $name, $value): bool {
        global $DB;

        if (!$DB->tableExists(self::TABLE)) {
            return false; // Impossible d'écrire si la table n'existe pas.
        }

        $iterator = $DB->request([
            'SELECT' => 'id',
            'FROM'   => self::TABLE,
            'WHERE'  => ['name' => $name]
        ]);

        if (count($iterator) > 0) {
            $row = $iterator->current();
            return $DB->update(
                self::TABLE,
                ['value' => $value],
                ['id' => $row['id']]
            );
        } else {
            return $DB->insert(
                self::TABLE,
                [
                    'name'  => $name,
                    'value' => $value
                ]
            );
        }
    }

    /**
     * Retourne la configuration condensée pour le provider actif.
     */
    public static function getActiveProviderConfig(): array {
        $provider = self::getConfig('active_ai_provider', 'gemini');
        return [
            'provider'    => $provider,
            'api_key'     => self::getConfig($provider . '_api_key', ''),
            'model'       => self::getConfig($provider . '_model', ''),
            'temperature' => self::getConfig($provider . '_temperature', 0.4),
            'max_tokens'  => self::getConfig($provider . '_max_tokens', 1024),
            'timeout'     => self::getConfig($provider . '_timeout', 15),
            'url'         => self::getConfig($provider . '_url', ''),
        ];
    }



    
// what i added 

    /**
     * Check if AI routing is enabled
     */
    public static function isAIAnalysisEnabled(): bool {
        return self::getConfig('ticket_auto_analysis', '1') == '1';
    }
    
    /**
     * Check if auto-assign suggestion is enabled
     */
    public static function isAutoSuggestionEnabled(): bool {
        return self::getConfig('ticket_suggest_tech', '1') == '1';
    }
    
    /**
     * Check if we should use fallback mechanism
     */
    public static function useFallback(): bool {
        return self::getConfig('use_fallback', '1') == '1';
    }
    
    /**
     * Get technician selection mode
     */
    public static function getTechSelectionMode(): string {
        return self::getConfig('tech_selection_mode', 'less_loaded');
    }
    
    /**
     * Get max tickets per technician
     */
    public static function getTechMaxTickets(): int {
        return (int)self::getConfig('tech_max_tickets', 12);
    }
    
    /**
     * Exclude absent technicians
     */
    public static function excludeAbsents(): bool {
        return self::getConfig('tech_exclude_absents', '1') == '1';
    }
    
    /**
     * Get ticket analysis delay
     */
    public static function getAnalysisDelay(): int {
        return (int)self::getConfig('ticket_analysis_delay', 0);
    }

}

