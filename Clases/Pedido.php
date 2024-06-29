<?php

require_once('Autoload.php');

class Pedido{
    private $idPedido;
    private $idUsuario;
    private $tipoPedido;
    private $totalPedido;

    function __construct($idUsuario, $tipoPedido, $totalPedido){
        $this->idUsuario = $idUsuario;
        $this->tipoPedido = $tipoPedido;
        $this->totalPedido = $totalPedido;
    }

    function crearNuevoPedido(){
        try {
            $conexion = Conexion::obtenerConexion();
            $consulta = "INSERT INTO pedidos (id_usuario, tipo_pedido, total_pedido) VALUES (:id_usuario, :tipo_pedido, :total_pedido)";
            $stmt = $conexion->prepare($consulta);
            $stmt->bindParam(':id_usuario', $this->idUsuario);
            $stmt->bindParam(':tipo_pedido', $this->tipoPedido);
            $stmt->bindParam(':total_pedido', $this->totalPedido);
            $stmt->execute();
            $this->idPedido = $conexion->lastInsertId();
            return true;
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
            return false;
        }
    }

    function insertarDetallesPedido($productos){
        try {
            $conexion = Conexion::obtenerConexion();
            $consulta = "INSERT INTO detalle_pedido (id_pedido, id_libro, estado_libro, cantidad, precio_unitario, subtotal) VALUES (:id_pedido, :id_libro, :estado_libro, :cantidad, :precio_unitario, :subtotal)";
            $stmt = $conexion->prepare($consulta);
            foreach($productos as $producto){
                $stmt->bindParam(':id_pedido', $this->idPedido);
                $stmt->bindValue(':id_libro', $producto['id_libro']);
                $stmt->bindValue(':cantidad', $producto['cantidad']);
                $libro = Producto::obtenerLibro($producto['id_libro']);
                $stmt->bindValue(':precio_unitario', $libro['precio']);
                $subotal = $libro['precio'] * $producto['cantidad'];
                $stmt->bindValue(':subtotal', $subotal);
                $stmt->bindValue(':estado_libro', $libro['fecha_lanzamiento'] > (new DateTime())->format('Y-m-d') ? "Reservado" : "Comprado");
                $stmt->execute();
                $this->cambiarStock($producto['id_libro'], $producto['cantidad']);
            }
            return true;
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
            return false;
        }
    }

    function cambiarStock($idLibro, $cantidad){
        try {
            $conexion = Conexion::obtenerConexion();
            $consulta = "UPDATE stock SET cantidad = cantidad - :cantidad WHERE id_libro = :id_libro";
            $stmt = $conexion->prepare($consulta);
            $stmt->bindParam(':id_libro', $idLibro);
            $stmt->bindParam(':cantidad', $cantidad);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
            return false;
        }
    }
}