<?php

/**
 * Descripcion: Autocarga las clases
 * Autor: Manuel Rodrigo Borriño
 * Fecha: 21 de febrero del 2024
 */

class Autoloader
{
    // Registra el autoloader
    public static function register()
    {
        spl_autoload_register([__CLASS__, 'autoload']);
    }

    // Carga una clase
    public static function autoload($className)
    {
        // Puedes personalizar la lógica de carga aquí según tu estructura de archivos
        $classFile = __DIR__ . '/' . str_replace('\\', '/', $className) . '.php';

        if (file_exists($classFile)) {
            //Si el archivo existe, lo incluye
            require_once $classFile;
        }
    }
}

// Registra el autoloader
Autoloader::register();