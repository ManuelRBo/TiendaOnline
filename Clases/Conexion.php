<?php

/**
 * Descripcion: Clase que gestiona la conexión a la base de datos
 * Autor: Manuel Rodrigo Borriño
 * Fecha: 21 de febrero del 2024
 */


class Conexion{
    // Variable que almacena la conexión
    private static $conexion;

    // Método para obtener la conexión a la base de datos
    public static function obtenerConexion() {
        if (!isset(self::$conexion)) {
            // Configuración de conexión a la base de datos
            $host = 'localhost';
            $usuario = 'root';
            $contrasena = '';
            $nombreDB = 'tiendaonline';

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