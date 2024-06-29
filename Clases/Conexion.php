<?php


class Conexion{
    private static $conexion;

    public static function obtenerConexion() {
        if (!isset(self::$conexion)) {
            // Configuración de conexión a la base de datos
            $host = 'recursing-shaw.194-164-171-108.plesk.page:3306';
            $usuario = 'manuel';
            $contrasena = '@41Gajl01';
            $nombreDB = 'tiendaLibros';

            // Intentar establecer la conexión
            try {
                self::$conexion = new PDO("mysql:host=$host;dbname=$nombreDB", $usuario, $contrasena);
                // Configurar opciones de PDO según necesidades
                self::$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                // Manejar errores de conexión
                throw new Exception("Error de conexión a la base de datos: " . $e->getMessage());
            }
        }
        return self::$conexion;
    }
}