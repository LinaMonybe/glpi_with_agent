<?php
spl_autoload_register(function ($class) {
    if (strpos($class, 'GlpiPlugin\\Aiticketrouter\\') === 0) {
        $path = __DIR__ . '/src/' . str_replace('\\', '/', substr($class, 27)) . '.php';
        if (file_exists($path)) {
            require_once $path;
        }
    }
});
