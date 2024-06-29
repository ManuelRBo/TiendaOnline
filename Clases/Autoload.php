<?php

class Autoloader
{
    public static function register()
    {
        spl_autoload_register([__CLASS__, 'autoload']);
    }

    public static function autoload($className)
    {
        // Puedes personalizar la lógica de carga aquí según tu estructura de archivos
        $classFile = __DIR__ . '/' . str_replace('\\', '/', $className) . '.php';

        if (file_exists($classFile)) {
            require_once $classFile;
        }
    }
}

Autoloader::register();