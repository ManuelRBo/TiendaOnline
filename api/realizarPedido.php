<?php

require_once('../Clases/Autoload.php');
session_start();

if(isset($_SESSION['usuario'])){
    $cesta = new Cesta($_SESSION['usuario']['id']);
    $cesta->obtenerCesta();
    $productos = $cesta->obtenerProductosCesta();
    $total = 0;
    foreach($productos as $producto){
        $libro = Producto::obtenerLibro($producto['id_libro']);
        $total += $libro['precio'] * $producto['cantidad'];
    }

    $mbd = Conexion::obtenerConexion();
    $mbd->beginTransaction();
    $pedido = new Pedido($_SESSION['usuario']['id'], "Envio", $total);
    if($pedido->crearNuevoPedido()){
        if($pedido->insertarDetallesPedido($productos)){
            $cesta->vaciarCesta();
            $mbd->commit();
            echo json_encode(['error' => false, 'mensaje' => "Pedido realizado con éxito"]);
        }else{
            $mbd->rollBack();
            echo json_encode(['error' => true, 'id' => 1, 'mensaje' => "Error al realizar el pedido"]);
        }
    }
}else{
    echo json_encode(['error' => true, 'id' => 2, 'mensaje' => "Inicia sesión o registrate para realizar un pedido"]);
}
