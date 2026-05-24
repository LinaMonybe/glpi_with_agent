<?php

namespace GlpiPlugin\Aiticketrouter\Form;

use Html;
use Glpi\Application\View\TemplateRenderer;
use GlpiPlugin\Aiticketrouter\Config\PluginConfig;

class ConfigForm
{

    public static function display()
    {
        global $CFG_GLPI;

        $target = $CFG_GLPI['root_doc'] . '/plugins/aiticketrouter/front/config.form.php';

        $tabgeneral = [
            'title' => __('Général', 'aiticketrouter'),
            'id' => 'tab_general',
            'render' => function () use ($target) {
            echo "<table class='tab_cadre_fixe'>";
            echo "<tr><th colspan='2'>" . __('Paramètres Généraux', 'aiticketrouter') . "</th></tr>";

            $activation = PluginConfig::getConfig('is_active', 1);
            echo "<tr class='tab_bg_1'><td>" . __('Activer le plugin', 'aiticketrouter') . "</td>";
            echo "<td><select name='is_active' class='form-select'>";
            echo "<option value='1' " . ($activation ? 'selected' : '') . ">" . __('Oui', 'aiticketrouter') . "</option>";
            echo "<option value='0' " . (!$activation ? 'selected' : '') . ">" . __('Non', 'aiticketrouter') . "</option>";
            echo "</select></td></tr>";

            $debug = PluginConfig::getConfig('debug_mode', 0);
            echo "<tr class='tab_bg_1'><td>" . __('Mode Debug', 'aiticketrouter') . "</td>";
            echo "<td><select name='debug_mode' class='form-select'>";
            echo "<option value='1' " . ($debug ? 'selected' : '') . ">" . __('Activé', 'aiticketrouter') . "</option>";
            echo "<option value='0' " . (!$debug ? 'selected' : '') . ">" . __('Désactivé', 'aiticketrouter') . "</option>";
            echo "</select></td></tr>";

            $log_level = PluginConfig::getConfig('log_level', 'info');
            echo "<tr class='tab_bg_1'><td>" . __('Niveau des logs', 'aiticketrouter') . "</td>";
            echo "<td><select name='log_level' class='form-select'>";
            echo "<option value='debug' " . ($log_level === 'debug' ? 'selected' : '') . ">Debug</option>";
            echo "<option value='info' " . ($log_level === 'info' ? 'selected' : '') . ">Info</option>";
            echo "<option value='warning' " . ($log_level === 'warning' ? 'selected' : '') . ">Warning</option>";
            echo "<option value='error' " . ($log_level === 'error' ? 'selected' : '') . ">Error</option>";
            echo "</select></td></tr>";

            echo "<tr><td colspan='2' class='center'>";
            echo "<input type='submit' name='update' value=\"" . _sx('button', 'Save') . "\" class='btn btn-primary'>";
            echo "</td></tr>";
            echo "</table>";
        }
        ];

        $tabia = [
            'title' => __('Configuration IA', 'aiticketrouter'),
            'id' => 'tab_ia',
            'render' => function () use ($target) {
            echo "<table class='tab_cadre_fixe'>";
            echo "<tr><th colspan='2'>" . __('Paramètres de l\'Intelligence Artificielle', 'aiticketrouter') . "</th></tr>";
            
            $active_ai = PluginConfig::getConfig('active_ai_provider', 'gemini');
            echo "<tr class='tab_bg_1'><td>" . __('Fournisseur IA Actif', 'aiticketrouter') . "</td>";
            echo "<td><select name='active_ai_provider' id='active_ai_provider' class='form-select' onchange='toggleAITabs()'>";
            echo "<option value='gemini' " . ($active_ai === 'gemini' ? 'selected' : '') . ">Google Gemini</option>";
            echo "<option value='openai' " . ($active_ai === 'openai' ? 'selected' : '') . ">OpenAI (ChatGPT)</option>";
            echo "<option value='claude' " . ($active_ai === 'claude' ? 'selected' : '') . ">Anthropic Claude</option>";
            echo "<option value='ollama' " . ($active_ai === 'ollama' ? 'selected' : '') . ">Ollama (Local)</option>";
            echo "</select></td></tr>";

            $providers = ['gemini', 'openai', 'claude'];
            $default_models = [
                'gemini' => 'gemini-2.5-flash-lite',
                'openai' => 'gpt-3.5-turbo',
                'claude' => 'claude-3-haiku-20240307'
            ];
            $available_models = [
                'gemini' => ['gemini-1.5-flash', 'gemini-1.5-pro', 'gemini-2.5-flash-lite'],
                'openai' => ['gpt-3.5-turbo', 'gpt-4o', 'gpt-4-turbo'],
                'claude' => ['claude-3-haiku-20240307', 'claude-3-sonnet-20240229', 'claude-3-opus-20240229']
            ];
            foreach ($providers as $prov) {
                echo "<tbody class='ai_config_group' id='group_{$prov}'>";
                echo "<tr><th colspan='2' style='background-color:#e2e2e2'>" . strtoupper($prov) . " Settings</th></tr>";
                $api_key = PluginConfig::getConfig("{$prov}_api_key", '');
                echo "<tr class='tab_bg_1'><td>" . __('Clé API', 'aiticketrouter') . " ($prov)</td>";
                echo "<td><input type='text' name='{$prov}_api_key' value='" . \Html::cleanInputText($api_key) . "' class='form-control' style='width:100%'></td></tr>";
                $model = PluginConfig::getConfig("{$prov}_model", $default_models[$prov]);
                $clean_model = \Html::cleanInputText($model);
                echo "<tr class='tab_bg_1'><td>" . __('Modèle IA', 'aiticketrouter') . "</td>";
                echo "<td><select name='{$prov}_model' class='form-select'>";
                foreach ($available_models[$prov] as $m) {
                    echo "<option value='$m' " . ($clean_model === $m ? 'selected' : '') . ">$m</option>";
                }
                echo "</select></td></tr>";
                $temper = PluginConfig::getConfig("{$prov}_temperature", '0.4');
                echo "<tr class='tab_bg_1'><td>" . __('Température', 'aiticketrouter') . "</td>";
                echo "<td><input type='number' step='0.1' min='0' max='1' name='{$prov}_temperature' value='" . \Html::cleanInputText($temper) . "' class='form-control' style='width:80px'></td></tr>";
                $maxtokens = PluginConfig::getConfig("{$prov}_max_tokens", '1024');
                echo "<tr class='tab_bg_1'><td>" . __('Max Tokens', 'aiticketrouter') . "</td>";
                echo "<td><input type='number' name='{$prov}_max_tokens' value='" . \Html::cleanInputText($maxtokens) . "' class='form-control' style='width:100px'></td></tr>";
                $timeout = PluginConfig::getConfig("{$prov}_timeout", '15');
                echo "<tr class='tab_bg_1'><td>" . __('Timeout (secondes)', 'aiticketrouter') . "</td>";
                echo "<td><input type='number' name='{$prov}_timeout' value='" . \Html::cleanInputText($timeout) . "' class='form-control' style='width:100px'></td></tr>";
                echo "</tbody>";
            }
            
            // Ollama is different
            echo "<tbody class='ai_config_group' id='group_ollama'>";
            echo "<tr><th colspan='2' style='background-color:#e2e2e2'>OLLAMA Settings</th></tr>";
            $url = PluginConfig::getConfig("ollama_url", 'http://127.0.0.1:11434/api/generate');
            echo "<tr class='tab_bg_1'><td>" . __('URL API', 'aiticketrouter') . " (Ollama)</td>";
            echo "<td><input type='text' name='ollama_url' value='" . \Html::cleanInputText($url) . "' class='form-control' style='width:100%'></td></tr>";
            $model = PluginConfig::getConfig("ollama_model", 'llama3');
            echo "<tr class='tab_bg_1'><td>" . __('Modèle IA', 'aiticketrouter') . "</td>";
            echo "<td><input type='text' name='ollama_model' value='" . \Html::cleanInputText($model) . "' class='form-control' style='width:100%'></td></tr>";
            $temper = PluginConfig::getConfig("ollama_temperature", '0.2');
            echo "<tr class='tab_bg_1'><td>" . __('Température', 'aiticketrouter') . "</td>";
            echo "<td><input type='number' step='0.1' min='0' max='1' name='ollama_temperature' value='" . \Html::cleanInputText($temper) . "' class='form-control' style='width:80px'></td></tr>";
            $timeout = PluginConfig::getConfig("ollama_timeout", '30');
            echo "<tr class='tab_bg_1'><td>" . __('Timeout (secondes)', 'aiticketrouter') . "</td>";
            echo "<td><input type='number' name='ollama_timeout' value='" . \Html::cleanInputText($timeout) . "' class='form-control' style='width:100px'></td></tr>";
            echo "</tbody>";

            $fallback = PluginConfig::getConfig('use_fallback', 1);
            echo "<tbody id='common_ia_config'><tr><th colspan='2' style='background-color:#e2e2e2'>" . __('Options Communes', 'aiticketrouter') . "</th></tr>";
            echo "<tr class='tab_bg_1'><td>" . __('Activer le Fallback (Si l\'IA échoue)', 'aiticketrouter') . "</td>";
            echo "<td><select name='use_fallback' class='form-select'>";
            echo "<option value='1' " . ($fallback ? 'selected' : '') . ">" . __('Oui', 'aiticketrouter') . "</option>";
            echo "<option value='0' " . (!$fallback ? 'selected' : '') . ">" . __('Non', 'aiticketrouter') . "</option>";
            echo "</select></td></tr>";

            echo "<tr><td colspan='2' class='center'>";
            echo "<input type='submit' name='update' value=\"" . _sx('button', 'Save') . "\" class='btn btn-primary'>&nbsp;&nbsp;";
            echo "<button type='submit' name='test_ai' class='btn btn-warning'><i class='fas fa-flask'></i> Tester la connexion IA</button>";
            echo "</td></tr></tbody>";
            echo "</table>";
            
            // Script to toggle displays
            echo "<script>
            function toggleAITabs() {
                var selected = document.getElementById('active_ai_provider').value;
                var groups = document.querySelectorAll('.ai_config_group');
                groups.forEach(function(el) {
                    el.style.display = 'none';
                });
                var activeGroup = document.getElementById('group_' + selected);
                if(activeGroup) {
                    activeGroup.style.display = ''; // default display (table-row-group)
                }
            }
            document.addEventListener('DOMContentLoaded', toggleAITabs);
            </script>";
        }
        ];

        $tabtech = [
            'title' => __('Techniciens', 'aiticketrouter'),
            'id' => 'tab_tech',
            'render' => function () use ($target) {
            echo "<table class='tab_cadre_fixe'>";
            echo "<tr><th colspan='2'>" . __('Gestion des Techniciens', 'aiticketrouter') . "</th></tr>";

            $maxtickets = PluginConfig::getConfig('tech_max_tickets', '8');
            echo "<tr class='tab_bg_1'><td>" . __('Maximum de tickets ouverts par technicien', 'aiticketrouter') . "</td>";
            echo "<td><input type='number' name='tech_max_tickets' value='" . Html::cleanInputText($maxtickets) . "' class='form-control' style='width:100px'></td></tr>";

            $notif = PluginConfig::getConfig('tech_notifications', 1);
            echo "<tr class='tab_bg_1'><td>" . __('Activer les notifications de charge', 'aiticketrouter') . "</td>";
            echo "<td><select name='tech_notifications' class='form-select'>";
            echo "<option value='1' " . ($notif ? 'selected' : '') . ">" . __('Oui', 'aiticketrouter') . "</option>";
            echo "<option value='0' " . (!$notif ? 'selected' : '') . ">" . __('Non', 'aiticketrouter') . "</option>";
            echo "</select></td></tr>";

            $select_mode = PluginConfig::getConfig('tech_selection_mode', 'less_loaded');
            echo "<tr class='tab_bg_1'><td>" . __('Mode de sélection auto-suggérée', 'aiticketrouter') . "</td>";
            echo "<td><select name='tech_selection_mode' class='form-select'>";
            echo "<option value='less_loaded' " . ($select_mode === 'less_loaded' ? 'selected' : '') . ">" . __('Moins chargé (less_loaded)', 'aiticketrouter') . "</option>";
            echo "<option value='round_robin' " . ($select_mode === 'round_robin' ? 'selected' : '') . ">" . __('Aléatoire (round_robin)', 'aiticketrouter') . "</option>";
            echo "</select></td></tr>";

            $exclude_abs = PluginConfig::getConfig('tech_exclude_absents', 1);
            echo "<tr class='tab_bg_1'><td>" . __('Exclure les absents (nécessite plugin Congés ou planning)', 'aiticketrouter') . "</td>";
            echo "<td><select name='tech_exclude_absents' class='form-select'>";
            echo "<option value='1' " . ($exclude_abs ? 'selected' : '') . ">" . __('Oui', 'aiticketrouter') . "</option>";
            echo "<option value='0' " . (!$exclude_abs ? 'selected' : '') . ">" . __('Non', 'aiticketrouter') . "</option>";
            echo "</select></td></tr>";

            echo "<tr><td colspan='2' class='center'>";
            echo "<input type='submit' name='update' value=\"" . _sx('button', 'Save') . "\" class='btn btn-primary'>";
            echo "</td></tr>";
            echo "</table>";
        }
        ];

        $tabtickets = [
            'title' => __('Tickets', 'aiticketrouter'),
            'id' => 'tab_tickets',
            'render' => function () use ($target) {
            echo "<table class='tab_cadre_fixe'>";
            echo "<tr><th colspan='2'>" . __('Gestion des Tickets', 'aiticketrouter') . "</th></tr>";

            $auto = PluginConfig::getConfig('ticket_auto_analysis', 1);
            echo "<tr class='tab_bg_1'><td>" . __('Activer l\'analyse automatique des nouveaux tickets', 'aiticketrouter') . "</td>";
            echo "<td><select name='ticket_auto_analysis' class='form-select'>";
            echo "<option value='1' " . ($auto ? 'selected' : '') . ">" . __('Oui', 'aiticketrouter') . "</option>";
            echo "<option value='0' " . (!$auto ? 'selected' : '') . ">" . __('Non', 'aiticketrouter') . "</option>";
            echo "</select></td></tr>";

            $prio = PluginConfig::getConfig('ticket_auto_priority', 1);
            echo "<tr class='tab_bg_1'><td>" . __('Ajuster la priorité automatiquement', 'aiticketrouter') . "</td>";
            echo "<td><select name='ticket_auto_priority' class='form-select'>";
            echo "<option value='1' " . ($prio ? 'selected' : '') . ">" . __('Oui', 'aiticketrouter') . "</option>";
            echo "<option value='0' " . (!$prio ? 'selected' : '') . ">" . __('Non', 'aiticketrouter') . "</option>";
            echo "</select></td></tr>";

            $html = PluginConfig::getConfig('ticket_followup_html', 1);
            echo "<tr class='tab_bg_1'><td>" . __('Utiliser un suivi enrichi HTML', 'aiticketrouter') . "</td>";
            echo "<td><select name='ticket_followup_html' class='form-select'>";
            echo "<option value='1' " . ($html ? 'selected' : '') . ">" . __('Oui', 'aiticketrouter') . "</option>";
            echo "<option value='0' " . (!$html ? 'selected' : '') . ">" . __('Non', 'aiticketrouter') . "</option>";
            echo "</select></td></tr>";

            $suggest = PluginConfig::getConfig('ticket_suggest_tech', 1);
            echo "<tr class='tab_bg_1'><td>" . __('Afficher les suggestions de techniciens dans le suivi', 'aiticketrouter') . "</td>";
            echo "<td><select name='ticket_suggest_tech' class='form-select'>";
            echo "<option value='1' " . ($suggest ? 'selected' : '') . ">" . __('Oui', 'aiticketrouter') . "</option>";
            echo "<option value='0' " . (!$suggest ? 'selected' : '') . ">" . __('Non', 'aiticketrouter') . "</option>";
            echo "</select></td></tr>";

            $delay = PluginConfig::getConfig('ticket_analysis_delay', '0');
            echo "<tr class='tab_bg_1'><td>" . __('Délai avant analyse (en secondes, ex: file d\'attente)', 'aiticketrouter') . "</td>";
            echo "<td><input type='number' name='ticket_analysis_delay' value='" . Html::cleanInputText($delay) . "' class='form-control' style='width:100px'></td></tr>";

            echo "<tr><td colspan='2' class='center'>";
            echo "<input type='submit' name='update' value=\"" . _sx('button', 'Save') . "\" class='btn btn-primary'>";
            echo "</td></tr>";
            echo "</table>";
        }
        ];

        $tablogs = [
            'title' => __('Logs & Stats', 'aiticketrouter'),
            'id' => 'tab_logs',
            'render' => function () use ($target) {
            echo "<table class='tab_cadre_fixe'>";
            echo "<tr><th colspan='2'>" . __('Rapports et Fichiers Journaux', 'aiticketrouter') . "</th></tr>";

            // Count sizes
            $log_gemini = GLPI_ROOT . '/plugins/aiticketrouter/log_gemini.txt';
            $log_ai = GLPI_ROOT . '/plugins/aiticketrouter/log_ai.txt';
            $log_tickets = GLPI_ROOT . '/plugins/aiticketrouter/log_tickets.txt';

            $logs_sizes = "";
            $logs_sizes .= "log_gemini.txt : " . (file_exists($log_gemini) ? round(filesize($log_gemini) / 1024, 2) . " Ko" : "Introuvable") . "<br/>";
            $logs_sizes .= "log_ai.txt : " . (file_exists($log_ai) ? round(filesize($log_ai) / 1024, 2) . " Ko" : "Introuvable") . "<br/>";
            $logs_sizes .= "log_tickets.txt : " . (file_exists($log_tickets) ? round(filesize($log_tickets) / 1024, 2) . " Ko" : "Introuvable") . "<br/>";

            echo "<tr class='tab_bg_1'><td style='vertical-align: top; width:30%;'>" . __('Poids des fichiers', 'aiticketrouter') . "</td>";
            echo "<td>$logs_sizes</td></tr>";

            echo "<tr><td colspan='2' class='center'>";
            echo "<input type='submit' name='update' value=\"" . _sx('button', 'Save') . "\" class='btn btn-primary'>&nbsp;&nbsp;";
            echo "<button type='submit' name='clear_logs' class='btn btn-danger' onclick='return confirm(\"Confirmez-vous la supression de tous les logs ?\")'><i class='fas fa-trash'></i> Vider les logs</button>";
            echo "</td></tr>";
            echo "</table>";
        }
        ];

        $tabs = [$tabgeneral, $tabia, $tabtech, $tabtickets, $tablogs];

        echo "<form action='$target' method='post' autocomplete='off'>";
        echo "<input type='hidden' name='_glpi_csrf_token' value='" . \Session::getNewCSRFToken() . "' />";

        echo "<div class='glpi_tabs'>";
        echo "<ul class='nav nav-tabs' role='tablist'>";
        foreach ($tabs as $index => $tab) {
            $active = ($index === 0) ? "active" : "";
            echo "<li class='nav-item' role='presentation'>";
            echo "<a class='nav-link $active' data-bs-toggle='tab' href='#" . $tab['id'] . "' role='tab'>" . $tab['title'] . "</a>";
            echo "</li>";
        }
        echo "</ul>";

        echo "<div class='tab-content'>";
        foreach ($tabs as $index => $tab) {
            $active = ($index === 0) ? "active show" : "";
            echo "<div class='tab-pane fade $active' id='" . $tab['id'] . "' role='tabpanel'>";
            $tab['render']();
            echo "</div>";
        }
        echo "</div>";
        echo "</div>";
        echo "</form>";
    }
}
