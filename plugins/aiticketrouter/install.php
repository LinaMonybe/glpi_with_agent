<?php
function plugin_aiticketrouter_install(): bool
{
    global $DB;

    // Table configs uniquement (déjà existante normalement)
    if (!$DB->tableExists('glpi_plugin_aiticketrouter_configs')) {
        $DB->queryOrDie(
            "CREATE TABLE `glpi_plugin_aiticketrouter_configs` (
                `id`    INT UNSIGNED NOT NULL AUTO_INCREMENT,
                `name`  VARCHAR(255) NOT NULL,
                `value` TEXT         DEFAULT NULL,
                PRIMARY KEY (`id`),
                UNIQUE KEY `uniq_name` (`name`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",
            "Création glpi_plugin_aiticketrouter_configs"
        );
    }

    if (!is_dir(__DIR__ . '/ajax')) {
        mkdir(__DIR__ . '/ajax', 0755, true);
    }

    file_put_contents(
        __DIR__ . '/debug_install.txt',
        "Installé le " . date('Y-m-d H:i:s') . "\n",
        FILE_APPEND
    );

    return true;
}

function plugin_aiticketrouter_uninstall(): bool
{
    global $DB;

    foreach ([
        'glpi_plugin_aiticketrouter_ai_suggestions',
        'glpi_plugin_aiticketrouter_configs',
    ] as $table) {
        if ($DB->tableExists($table)) {
            $DB->queryOrDie("DROP TABLE `$table`", "Suppression $table");
        }
    }

    return true;
}