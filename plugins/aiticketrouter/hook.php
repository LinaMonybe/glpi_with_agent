<?php
/**
 * AI Ticket Router - Hooks
 */

use GlpiPlugin\Aiticketrouter\Controller\TicketRoutingController;

// ================================================================
// INSTALLATION
// ================================================================
function plugin_aiticketrouter_install() {
    if (!is_dir(__DIR__ . '/ajax')) {
        mkdir(__DIR__ . '/ajax', 0755, true);
    }
    file_put_contents(__DIR__ . '/debug_install.txt',
        "Installé le " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
    return true;
}

// ================================================================
// DESINSTALLATION
// ================================================================
function plugin_aiticketrouter_uninstall() {
    // Supprimer ou nettoyer la configuration si nécessaire
    return true;
}

// ================================================================
// HOOK PRINCIPAL : CRÉATION D'UN TICKET
// ================================================================
function plugin_aiticketrouter_on_ticket_add(CommonDBTM $item) {
    error_log("AITR DEBUG: ticket update triggered");
    if (!defined('GLPI_ROOT')) return;
    $controller = new TicketRoutingController();
    $controller->onTicketAdd($item);
}

// ================================================================
// HOOK : BLOCAGE SI TECHNICIEN SURCHARGÉ
// ================================================================
function plugin_aiticketrouter_block_overloaded_tech(CommonDBTM $item) {
    error_log("AITR DEBUG: ticket update triggered");
    if (!defined('GLPI_ROOT')) return;
    $controller = new TicketRoutingController();
    $controller->blockOverloadedTech($item);
}



/**
 * Hook triggered when a new item is added
 */
function plugin_aiticketrouter_hook_item_add($item) {
    // Only process tickets
    if ($item->getType() != 'Ticket') {
        return;
    }
    
    // Check if auto-analysis is enabled
    if (!PluginConfig::isAIAnalysisEnabled()) {
        return;
    }
    
    // Small delay if configured
    $delay = PluginConfig::getAnalysisDelay();
    if ($delay > 0) {
        sleep($delay);
    }
    
    // Route the ticket
    $controller = new \GlpiPlugin\Aiticketrouter\Controller\TicketRoutingController();
    $result = $controller->routeTicket($item->getID());
    
    if ($result) {
        Toolbox::logInfo("AI Ticket Router: Ticket {$item->getID()} routed successfully");
    }
}