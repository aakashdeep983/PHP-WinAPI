<?php

spl_autoload_register(
    function ($className) {
        if (class_exists($className)) {
            return;
        }
        include_once __DIR__ . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';
    }
);

$application = new WinAPI\Application();