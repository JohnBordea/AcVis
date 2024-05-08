<?php
define('BASE_PATH', dirname(__DIR__)."/rest");

spl_autoload_register(function ($class) {
    $directories = [
        BASE_PATH . '/app/models/',
        BASE_PATH . '/app/controllers/',
        BASE_PATH . '/app/',
    ];

    foreach ($directories as $directory) {
        $file = $directory . str_replace('\\', '/', $class) . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});