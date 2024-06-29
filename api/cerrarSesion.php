<?php

/**
 * Descripcion: Cierra la sesión del usuario
 * Autor: Manuel Rodrigo Borriño
 * Fecha: 21 de febrero del 2024
 */

session_start();

// Destruir la sesión
session_destroy();

// Redirigir al usuario a la última URL visitada
header('Location: ' . $_SESSION['ultima_url']);