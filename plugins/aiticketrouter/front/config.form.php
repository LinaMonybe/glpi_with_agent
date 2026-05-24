<?php

include ("../../../inc/includes.php");

use GlpiPlugin\Aiticketrouter\Config\PluginConfig;
use Session;
use Html;

Session::checkRight("config", UPDATE);

if (!isset($_POST['_glpi_csrf_token'])) {
    Session::addMessageAfterRedirect(__('CSRF token missing or expired', 'aiticketrouter'), false, ERROR);
    Html::back();
}

// Session::checkCSRF($_POST); // GLPI gère ça automatiquement si csrf_compliant est true

// Ignorer les champs spéciaux lors de la sauvegarde
$ignored_keys = ['_glpi_csrf_token', 'update', 'test_gemini', 'clear_logs'];

foreach ($_POST as $key => $value) {
    if (in_array($key, $ignored_keys)) {
        continue;
    }
    
    // Convert arrays into strings or handle checkboxes properly if needed
    if (is_array($value)) {
        $value = json_encode($value);
    }
    
    PluginConfig::setConfig($key, $value);
}

// Check for specific actions like Test Gemini or Clear Logs
if (isset($_POST['test_gemini'])) {
    Session::addMessageAfterRedirect(__('Test Gemini fonctionnel ! (Simulation)', 'aiticketrouter'), true, INFO);
} elseif (isset($_POST['clear_logs'])) {
    $log_files = [
        GLPI_ROOT . '/plugins/aiticketrouter/log_ai.txt',
        GLPI_ROOT . '/plugins/aiticketrouter/log_gemini.txt',
        GLPI_ROOT . '/plugins/aiticketrouter/log_tickets.txt',
        GLPI_ROOT . '/plugins/aiticketrouter/debug_error.txt'
    ];
    $cleared = 0;
    foreach ($log_files as $file) {
        if (file_exists($file)) {
            file_put_contents($file, "");
            $cleared++;
        }
    }
    Session::addMessageAfterRedirect(sprintf(__('%d fichier(s) de log vidé(s).', 'aiticketrouter'), $cleared), true, INFO);
} else {
    Session::addMessageAfterRedirect(__('Configuration sauvegardée avec succès.', 'aiticketrouter'), true, INFO);
}

Html::back();
