<?php
/**
 * AI Ticket Router - Plugin GLPI
 * Version: 2.1.0
 * Author: Douae, Lina & Hajar
 */

require_once __DIR__ . '/autoload.php';

define('PLUGIN_AITICKETROUTER_VERSION', '2.1.0');

function plugin_version_aiticketrouter() {
    return [
        'name'         => 'AI Ticket Router',
        'version'      => PLUGIN_AITICKETROUTER_VERSION,
        'author'       => 'Douae, Lina & Hajar',
        'license'      => 'GPLv3+',
        'homepage'     => '',
        'requirements' => ['glpi' => ['min' => '11.0.0']],
    ];
}

function plugin_aiticketrouter_check_prerequisites() { return true; }
function plugin_aiticketrouter_check_config()        { return true; }

function plugin_init_aiticketrouter() {
    global $PLUGIN_HOOKS, $CFG_GLPI;

    $PLUGIN_HOOKS['csrf_compliant']['aiticketrouter'] = true;

    // Page de configuration
    $PLUGIN_HOOKS['config_page']['aiticketrouter'] = 'front/config.php';

    // Hook création ticket
    $PLUGIN_HOOKS['item_add']['aiticketrouter'] = [
        'Ticket' => 'plugin_aiticketrouter_on_ticket_add'
    ];

    // Hook blocage assignation
    $PLUGIN_HOOKS['pre_item_update']['aiticketrouter'] = [
        'Ticket' => 'plugin_aiticketrouter_block_overloaded_tech'
    ];

    // ================================================================
    // Chargement du JS sur toutes les pages GLPI
    // Le fichier front/aitr.js.php sert le JS avec le bon Content-Type
    // ================================================================
    $PLUGIN_HOOKS['add_javascript']['aiticketrouter'] = [
        'front/aitr.js.php'
    ];
}