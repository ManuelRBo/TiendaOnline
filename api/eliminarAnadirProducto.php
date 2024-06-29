<?php

require_once('../Clases/Autoload.php');
session_start();
$data = file_get_contents('php://input');
$libro = json_decode($data);

if($libro->accion == 'eliminar'){

    if (isset($_SESSION['usuario'])) {
        $id_usuario = $_SESSION['usuario']['id'];
        $cesta = new Cesta($id_usuario);
        $cesta->obtenerCesta();
        $eliminar = $cesta->eliminarUnidadLibro($libro->id);
        $libroProducto = Producto::obtenerLibro($libro->id);
        if ($eliminar) {
            echo json_encode(array('cantidad' => $cesta->cantidadLibro($libro->id), 'precio' => $libroProducto['precio'],'status' => true));
        }
    } else {
        $cesta = [];
        $precio = Producto::obtenerLibro($libro->id)['precio'];
        if (isset($_COOKIE['cesta'])) {
            $cesta = json_decode($_COOKIE['cesta'], true);
            $cesta[$libro->id]['cantidad'] -= 1;
            $cantidad = $cesta[$libro->id]['cantidad'];
            if($cesta[$libro->id]['cantidad'] <= 0){
                unset($cesta[$libro->id]);
            }
        }

        // Actualizar la cookie con el nuevo contenido de la cesta
        setcookie('cesta', json_encode($cesta), time() + (60 * 60 * 24 * 365), '/');

        // Responder con JSON indicando la cantidad y el estado
        echo json_encode(['cantidad' => $cantidad, 'precio'=>$precio, 'status' => true]);
    }
}else if($libro->accion == 'añadir'){
    
    if (isset($_SESSION['usuario'])) {
        $id_usuario = $_SESSION['usuario']['id'];
        $cesta = new Cesta($id_usuario);
        $cesta->obtenerCesta();
        $añadir = $cesta->anadirUnidadLibro($libro->id);
        $libroProducto = Producto::obtenerLibro($libro->id);
        $stock = Cesta::stockLibro($libro->id);
        if ($añadir) {
            echo json_encode(array('cantidad' => $cesta->cantidadLibro($libro->id), 'stock'=>$stock, 'precio' => $libroProducto['precio'], 'status' => true));
        }
    } else {
        $cesta = [];
        $precio = Producto::obtenerLibro($libro->id)['precio'];
        $stock = Cesta::stockLibro($libro->id);
        if (isset($_COOKIE['cesta'])) {
            $cesta = json_decode($_COOKIE['cesta'], true);
            $cesta[$libro->id]['cantidad'] += 1;
            $cantidad = $cesta[$libro->id]['cantidad'];
        }

        // Actualizar la cookie con el nuevo contenido de la cesta
        setcookie('cesta', json_encode($cesta), time() + (60 * 60 * 24 * 365), '/');

        // Responder con JSON indicando la cantidad y el estado
        echo json_encode(['cantidad' => $cantidad, 'stock'=>$stock, 'precio'=>$precio, 'status' => true]);
    }
}