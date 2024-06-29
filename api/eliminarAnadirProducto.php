<?php

/** 
 * Descripcion: Añade o elimina un libro de la cesta
 * Autor: Manuel Rodrigo Borriño
 * Fecha: 21 de febrero del 2024
 */

require_once('../Clases/Autoload.php');
session_start();
$data = file_get_contents('php://input');
$libro = json_decode($data);

if($libro->accion == 'eliminar'){
    // Si la acción es eliminar, eliminar el libro de la cesta

    if (isset($_SESSION['usuario'])) {
        // Si el usuario está logueado, eliminar el libro de la cesta de la base de datos

        $id_usuario = $_SESSION['usuario']['id'];
        $cesta = new Cesta($id_usuario);
        // Obtener la cesta del usuario
        $cesta->obtenerCesta();
        // Eliminar el libro de la cesta
        $eliminar = $cesta->eliminarUnidadLibro($libro->id);
        // Obtener el precio del libro
        $libroProducto = Producto::obtenerLibro($libro->id);
        if ($eliminar) {
            // Responder con JSON indicando la cantidad, el precio, y el estado
            echo json_encode(array('cantidad' => $cesta->cantidadLibro($libro->id), 'precio' => $libroProducto['precio'],'status' => true));
        }
    } else {
        // Si el usuario no está logueado, eliminar el libro de la cesta de la cookie

        $cesta = [];
        // Obtener el precio del libro
        $precio = Producto::obtenerLibro($libro->id)['precio'];
        if (isset($_COOKIE['cesta'])) {
            // Si la cesta ya existe, obtener su contenido
            $cesta = json_decode($_COOKIE['cesta'], true);
            $cesta[$libro->id]['cantidad'] -= 1;
            $cantidad = $cesta[$libro->id]['cantidad'];
            if($cesta[$libro->id]['cantidad'] <= 0){
                // Si la cantidad es 0 o menor, eliminar el libro de la cesta
                unset($cesta[$libro->id]);
            }
        }

        // Actualizar la cookie con el nuevo contenido de la cesta
        setcookie('cesta', json_encode($cesta), time() + (60 * 60 * 24 * 365), '/');

        // Responder con JSON indicando la cantidad y el estado
        echo json_encode(['cantidad' => $cantidad, 'precio'=>$precio, 'status' => true]);
    }
}else if($libro->accion == 'añadir'){
    // Si la acción es añadir, añadir el libro a la cesta
    
    if (isset($_SESSION['usuario'])) {
        // Si el usuario está logueado, añadir el libro a la cesta de la base de datos
        $id_usuario = $_SESSION['usuario']['id'];
        $cesta = new Cesta($id_usuario);
        // Obtener la cesta del usuario
        $cesta->obtenerCesta();
        // Añadir el libro a la cesta
        $añadir = $cesta->anadirUnidadLibro($libro->id);
        // Obtener el precio del libro
        $libroProducto = Producto::obtenerLibro($libro->id);
        // Obtener el stock del libro
        $stock = Cesta::stockLibro($libro->id);
        if ($añadir) {
            // Responder con JSON indicando la cantidad, el stock, el precio, y el estado
            echo json_encode(array('cantidad' => $cesta->cantidadLibro($libro->id), 'stock'=>$stock, 'precio' => $libroProducto['precio'], 'status' => true));
        }
    } else {
        // Si el usuario no está logueado, añadir el libro a la cesta de la cookie
        $cesta = [];
        // Obtener el precio del libro
        $precio = Producto::obtenerLibro($libro->id)['precio'];
        // Obtener el stock del libro
        $stock = Cesta::stockLibro($libro->id);
        if (isset($_COOKIE['cesta'])) {
            // Si la cesta ya existe, obtener su contenido y sumar 1 a la cantidad
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