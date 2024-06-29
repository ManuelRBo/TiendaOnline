<?php

/**
 * Descripcion: Clase que gestiona los pedidos
 * Autor: Manuel Rodrigo Borriño
 * Fecha: 21 de febrero del 2024
 */

require_once('Autoload.php');

class Pedido{
    //Atributos
    private $idPedido;
    private $idUsuario;
    private $tipoPedido;
    private $totalPedido;

    //Constructor
    function __construct($idUsuario, $tipoPedido, $totalPedido){
        $this->idUsuario = $idUsuario;
        $this->tipoPedido = $tipoPedido;
        $this->totalPedido = $totalPedido;
    }

    // Métodos

    // Crear un nuevo pedido
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
        }finally{
            $conexion = null;
        }
    }

    // Insertar los detalles del pedido
    function insertarDetallesPedido($productos){
        try {
            $conexion = Conexion::obtenerConexion();
            $consulta = "INSERT INTO detalle_pedido (id_pedido, id_libro, estado_libro, cantidad, precio_unitario, subtotal) VALUES (:id_pedido, :id_libro, :estado_libro, :cantidad, :precio_unitario, :subtotal)";
            $stmt = $conexion->prepare($consulta);
            // Recorrer los productos y añadirlos a la tabla detalle_pedido
            foreach($productos as $producto){
                $stmt->bindParam(':id_pedido', $this->idPedido);
                $stmt->bindValue(':id_libro', $producto['id_libro']);
                $stmt->bindValue(':cantidad', $producto['cantidad']);
                // Obtener el precio del libro
                $libro = Producto::obtenerLibro($producto['id_libro']);
                $stmt->bindValue(':precio_unitario', $libro['precio']);
                $subotal = $libro['precio'] * $producto['cantidad'];
                $stmt->bindValue(':subtotal', $subotal);
                $stmt->bindValue(':estado_libro', $libro['fecha_lanzamiento'] > (new DateTime())->format('Y-m-d') ? "Reservado" : "Comprado");
                $stmt->execute();
                // Cambiar el stock del libro
                $this->cambiarStock($producto['id_libro'], $producto['cantidad']);
            }
            return true;
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
            return false;
        }finally{
            $conexion = null;
        }
    }

    // Cambiar el stock del libro
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
        }finally{
            $conexion = null;
        }
    }
}