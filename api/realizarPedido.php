<?php

/**
 * Descripcion: Realiza un pedido
 * Autor: Manuel Rodrigo Borriño
 * Fecha: 21 de febrero del 2024
 */

require_once('../Clases/Autoload.php');
session_start();

if(isset($_SESSION['usuario'])){
    //Si el usuario ha iniciado sesion se obtiene la cesta y se realiza el pedido
    $cesta = new Cesta($_SESSION['usuario']['id']);
    $cesta->obtenerCesta();
    //Se obtienen los productos de la cesta
    $productos = $cesta->obtenerProductosCesta();
    $total = 0;
    //Se recorren los productos y se va sumando el total
    foreach($productos as $producto){
        $libro = Producto::obtenerLibro($producto['id_libro']);
        $total += $libro['precio'] * $producto['cantidad'];
    }

    //Se inicia la transaccion
    $mbd = Conexion::obtenerConexion();
    $mbd->beginTransaction();
    //Se crea el pedido
    $pedido = new Pedido($_SESSION['usuario']['id'], "Envio", $total);
    if($pedido->crearNuevoPedido()){
        //Si el pedido se crea correctamente se insertan los detalles del pedido
        if($pedido->insertarDetallesPedido($productos)){
            //Si los detalles se insertan correctamente se vacia la cesta y se confirma la transaccion
            $cesta->vaciarCesta();
            $mbd->commit();
            echo json_encode(['error' => false, 'mensaje' => "Pedido realizado con éxito"]);
        }else{
            //Si los detalles no se insertan correctamente se deshace la transaccion
            $mbd->rollBack();
            echo json_encode(['error' => true, 'id' => 1, 'mensaje' => "Error al realizar el pedido"]);
        }
    }
}else{
    echo json_encode(['error' => true, 'id' => 2, 'mensaje' => "Inicia sesión o registrate para realizar un pedido"]);
}
