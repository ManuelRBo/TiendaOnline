<?php

/**
 * Descripcion: Clase que gestiona la cesta de la compra
 * Autor: Manuel Rodrigo Borriño
 * Fecha: 21 de febrero del 2024
 */

require_once('Autoload.php');

class Cesta
{
    // Atributos
    private $id;
    private $id_usuario;

    // Constructor
    function __construct($id_usuario)
    {
        $this->id_usuario = $id_usuario;
    }

    // Métodos

    // Crear una nueva cesta
    function crearNuevaCesta()
    {
        try {
            $conexion = Conexion::obtenerConexion();
            $consulta = "INSERT INTO cesta (id_cesta, id_usuario) VALUES (:id_cesta, :id_usuario)";
            $stmt = $conexion->prepare($consulta);
            $stmt->bindParam(':id_cesta', $this->id_usuario);
            $stmt->bindParam(':id_usuario', $this->id_usuario);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
            return false;
        }finally{
            $conexion = null;
        }
    }

    // Actualizar el ID de la cesta en la tabla de usuarios
    function actualizarIdCestaEnUsuario()
    {
        try {
            $conexion = Conexion::obtenerConexion();

            // Obtener el ID de la última cesta creada para el usuario
            $consulta = "SELECT id_cesta FROM cesta WHERE id_usuario = :id_usuario LIMIT 1";
            $stmt = $conexion->prepare($consulta);
            $stmt->bindParam(':id_usuario', $this->id_usuario);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($resultado) {
                $this->id = $resultado['id_cesta'];
                // Actualizar la tabla de usuarios con el ID de la cesta
                $consultaUpdate = "UPDATE usuarios SET id_cesta = :id_cesta WHERE id_usuario = :id_usuario";
                $stmtUpdate = $conexion->prepare($consultaUpdate);
                $stmtUpdate->bindParam(':id_cesta', $this->id);
                $stmtUpdate->bindParam(':id_usuario', $this->id_usuario);
                $stmtUpdate->execute();
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
            return false;
        }finally{
            $conexion = null;
        }
    }

    // Obtener la cesta del usuario
    function obtenerCesta()
    {
        try {
            $conexion = Conexion::obtenerConexion();
            $consulta = "SELECT id_cesta FROM cesta WHERE id_usuario = :id_usuario";
            $stmt = $conexion->prepare($consulta);
            $stmt->bindParam(':id_usuario', $this->id_usuario);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($resultado) {
                $this->id = $resultado['id_cesta'];
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
            return false;
        }finally{
            $conexion = null;
        }
    }

    // Obtener los productos de la cesta
    function obtenerProductosCesta()
    {
        try {
            $conexion = Conexion::obtenerConexion();
            $consulta = "SELECT id_libro, cantidad FROM productos_cesta WHERE id_cesta = :id_cesta";
            $stmt = $conexion->prepare($consulta);
            $stmt->bindParam(':id_cesta', $this->id);
            $stmt->execute();
            $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($resultado) {
                return $resultado;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
            return false;
        }finally{
            $conexion = null;
        }
    }

    // Añadir un libro a la cesta
    function anadirLibro($id_libro, $cantidad)
    {
        try {
            $conexion = Conexion::obtenerConexion();
            $consulta = "SELECT id_libro FROM productos_cesta WHERE id_cesta = :id_cesta AND id_libro = :id_libro";
            $stmt = $conexion->prepare($consulta);
            $stmt->bindParam(':id_cesta', $this->id);
            $stmt->bindParam(':id_libro', $id_libro);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($resultado) {
                // Si el libro ya está en la cesta, incrementar la cantidad
                $consulta = "UPDATE productos_cesta SET cantidad = cantidad + :cantidad WHERE id_cesta = :id_cesta AND id_libro = :id_libro";
                $stmt = $conexion->prepare($consulta);
                $stmt->bindParam(':id_cesta', $this->id);
                $stmt->bindParam(':id_libro', $id_libro);
                $stmt->bindParam(':cantidad', $cantidad);
                $stmt->execute();
                return true;
            } else {
                // Si el libro no está en la cesta, añadirlo
                $consulta = "INSERT INTO productos_cesta (id_cesta, id_libro, cantidad) VALUES (:id_cesta, :id_libro, :cantidad)";
                $stmt = $conexion->prepare($consulta);
                $stmt->bindParam(':id_cesta', $this->id);
                $stmt->bindParam(':id_libro', $id_libro);
                $stmt->bindParam(':cantidad', $cantidad);
                $stmt->execute();
                return true;
            }
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
            return false;
        }finally{
            $conexion = null;
        }
    }

    // Obtener la cantidad total de libros en la cesta
    static function cantidadTotal($id_usuario)
    {
        try {
            $conexion = Conexion::obtenerConexion();
            $consulta = "SELECT SUM(cantidad) as total FROM productos_cesta\n"
                . "JOIN cesta ON productos_cesta.id_cesta = cesta.id_cesta\n"
                . "WHERE cesta.id_usuario = :id_usuario\n"
                . "GROUP BY cesta.id_cesta";
            $stmt = $conexion->prepare($consulta);
            $stmt->bindParam(':id_usuario', $id_usuario);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($resultado && $resultado['total'] != NULL) {
                return $resultado['total'];
            } else if ($resultado) {
                return 0;
            }
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
            return false;
        }finally{
            $conexion = null;
        }
    }

    // Obtener la cantidad de un libro en la cesta
    function cantidadLibro($idLibro)
    {
        try {
            $conexion = Conexion::obtenerConexion();
            $consulta = "SELECT cantidad FROM productos_cesta WHERE id_cesta = :id_cesta AND id_libro = :id_libro";
            $stmt = $conexion->prepare($consulta);
            $stmt->bindParam(':id_cesta', $this->id);
            $stmt->bindParam(':id_libro', $idLibro);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($resultado && $resultado['cantidad'] > 0) {
                return $resultado['cantidad'];
            } else {
                return 0;
            }
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
            return false;
        }finally{
            $conexion = null;
        }
    }

    // Eliminar una unidad de un libro de la cesta
    function eliminarUnidadLibro($id_libro)
    {
        try {
            $conexion = Conexion::obtenerConexion();

            // Decrementar la cantidad del libro
            $consultaDecrementar = "UPDATE productos_cesta SET cantidad = cantidad - 1 WHERE id_cesta = :id_cesta AND id_libro = :id_libro";
            $stmtDecrementar = $conexion->prepare($consultaDecrementar);
            $stmtDecrementar->bindParam(':id_cesta', $this->id);
            $stmtDecrementar->bindParam(':id_libro', $id_libro);
            $stmtDecrementar->execute();

            // Verificar si la cantidad llegó a cero
            $cantidad = $this->cantidadLibro($id_libro);

            if ($cantidad <= 0) {
                // Si la cantidad es mayor que cero, eliminar el libro de la cesta
                $consultaEliminar = "DELETE FROM productos_cesta WHERE id_cesta = :id_cesta AND id_libro = :id_libro";
                $stmtEliminar = $conexion->prepare($consultaEliminar);
                $stmtEliminar->bindParam(':id_cesta', $this->id);
                $stmtEliminar->bindParam(':id_libro', $id_libro);
                $stmtEliminar->execute();
            }
            return true;
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
            return false;
        }finally{
            $conexion = null;
        }
    }


    // Añadir una unidad de un libro a la cesta
    function anadirUnidadLibro($id_libro)
    {
        try {
            $conexion = Conexion::obtenerConexion();
            $consulta = "UPDATE productos_cesta SET cantidad = cantidad + 1 WHERE id_cesta = :id_cesta AND id_libro = :id_libro";
            $stmt = $conexion->prepare($consulta);
            $stmt->bindParam(':id_cesta', $this->id);
            $stmt->bindParam(':id_libro', $id_libro);
            $stmt->execute();
            $cantidad = $this->cantidadLibro($id_libro);

            return ['cantidad' => $cantidad, 'status' => true];
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
            return false;
        }finally{
            $conexion = null;
        }
    }

    // Obtener el stock de un libro
    static function stockLibro($id_libro)
    {
        try {
            $conexion = Conexion::obtenerConexion();
            $consulta = "SELECT cantidad FROM stock WHERE id_libro = :id_libro";
            $stmt = $conexion->prepare($consulta);
            $stmt->bindParam(':id_libro', $id_libro);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($resultado) {
                return $resultado['cantidad'];
            } else {
                return 0;
            }
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
            return false;
        }finally{
            $conexion = null;
        }
    }

    // Vaciar la cesta
    function vaciarCesta()
    {
        try {
            $conexion = Conexion::obtenerConexion();
            $consulta = "DELETE FROM productos_cesta WHERE id_cesta = :id_cesta";
            $stmt = $conexion->prepare($consulta);
            $stmt->bindParam(':id_cesta', $this->id);
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
