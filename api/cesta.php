<?php

/**
 * Descripcion: Añade un libro a la cesta
 * Autor: Manuel Rodrigo Borriño
 * Fecha: 21 de febrero del 2024
 */

require_once('../Clases/Autoload.php');
session_start();
$data = file_get_contents('php://input');
$libro = json_decode($data);

if (isset($_SESSION['usuario'])) {
    // Si el usuario está logueado, añadir el libro a la cesta de la base de datos
    $id_usuario = $_SESSION['usuario']['id'];
    $cesta = new Cesta($id_usuario);
    // Obtener la cesta del usuario
    $cesta->obtenerCesta();
    // Añadir el libro a la cesta
    $añadir = $cesta->anadirLibro($libro->id, $libro->cantidad);

    // Responder con JSON indicando la cantidad y el estado
    if ($añadir) {
        echo json_encode(array('cantidad' => $cesta->cantidadTotal($id_usuario), 'status' => true));
    } else {
        echo json_encode(array('cantidad' => $cesta->cantidadTotal($id_usuario), 'status' => false));
    }
} else {
    // Si el usuario no está logueado, añadir el libro a la cesta de la cookie
    $cesta = [];
    if (isset($_COOKIE['cesta'])) {
        // Si la cesta ya existe, obtener su contenido
        $cesta = json_decode($_COOKIE['cesta'], true);

        if (isset($cesta[$libro->id])) {
            // Si el libro ya está en la cesta, sumar la cantidad
            $cesta[$libro->id]['cantidad'] += $libro->cantidad;
        } else {
            // Si el libro no está en la cesta, añadirlo
            $cesta[$libro->id] = [
                'id_libro' => $libro->id,
                'cantidad' => $libro->cantidad
            ];
        }
    } else {
        // Si la cesta no existe, crearla
        $cesta = [
            $libro->id => [
                'id_libro' => $libro->id,
                'cantidad' => $libro->cantidad
            ]
        ];
    }

    // Actualizar la cookie con el nuevo contenido de la cesta
    setcookie('cesta', json_encode($cesta), time() + (60 * 60 * 24 * 365), '/');

    // Función de reducción para sumar las cantidades
    $sumarCantidades = function ($carry, $item) {
        return $carry + $item['cantidad'];
    };

    $total = array_reduce($cesta, $sumarCantidades, 0);

    // Responder con JSON indicando la cantidad y el estado
    echo json_encode(['cantidad' => $total, 'status' => true]);
}
