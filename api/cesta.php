<?php

require_once('../Clases/Autoload.php');
session_start();
$data = file_get_contents('php://input');
$libro = json_decode($data);

if (isset($_SESSION['usuario'])) {
    $id_usuario = $_SESSION['usuario']['id'];
    $cesta = new Cesta($id_usuario);
    $cesta->obtenerCesta();
    $añadir = $cesta->anadirLibro($libro->id, $libro->cantidad);
    if ($añadir) {
        echo json_encode(array('cantidad' => $cesta->cantidadTotal($id_usuario), 'status' => true));
    } else {
        echo json_encode(array('cantidad' => $cesta->cantidadTotal($id_usuario), 'status' => false));
    }
} else {
    $cesta = [];
    if (isset($_COOKIE['cesta'])) {
        $cesta = json_decode($_COOKIE['cesta'], true);

        if (isset($cesta[$libro->id])) {
            $cesta[$libro->id]['cantidad'] += $libro->cantidad;
        } else {
            $cesta[$libro->id] = [
                'id_libro' => $libro->id,
                'cantidad' => $libro->cantidad
            ];
        }
    } else {
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
