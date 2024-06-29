<?php

/** 
 * Descripcion: Clase que gestiona los usuarios
 * Autor: Manuel Rodrigo Borriño
 * Fecha: 21 de febrero del 2024
 */

require_once('Autoload.php');

class Usuario{
    //Atributos
    private $nombre;
    private $apellidos;
    private $email;
    private $contraseña;
    private $usuario;

    //Constructor
    function __construct($nombre, $apellidos, $email, $contraseña, $usuario){
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->email = $email;
        $this->contraseña = $contraseña;
        $this->usuario = $usuario;
    }

    // Métodos

    // Registrar un nuevo usuario
    function registrar() {
        try {
            $conexion = Conexion::obtenerConexion();
            // Comenzar una transacción
            $conexion->beginTransaction();
            $consulta1 = "INSERT INTO usuarios (nombre, apellidos, email, usuario, contraseña) VALUES (:nombre, :apellidos, :email, :usuario, :contrasena)";
            $stmt = $conexion->prepare($consulta1);
            $stmt->bindParam(':nombre', $this->nombre);
            $stmt->bindParam(':apellidos', $this->apellidos);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':usuario', $this->usuario);
            $stmt->bindParam(':contrasena', $this->contraseña);
            $stmt->execute();

            $idUsuario = $conexion->lastInsertId();
            $cesta = new Cesta($idUsuario);
            $cesta->crearNuevaCesta();
            $cesta->actualizarIdCestaEnUsuario();
            if(isset($_COOKIE['cesta'])){
                // Si hay productos en la cesta se añaden a la base de datos
                $productos = json_decode($_COOKIE['cesta'], true);
                // Recorrer los productos y añadirlos a la cesta
                foreach($productos as $producto){
                    $cesta->anadirLibro($producto['id_libro'], $producto['cantidad']);
                }
                // Vaciar la cookie
                setcookie('cesta', '', time() - 3600, '/');
            }
            // Confirmar la transacción
            $conexion->commit();

            // Iniciar sesión
            session_start();
            $_SESSION['usuario'] = [
                'id' => $idUsuario,
                'nombre' => $this->nombre,
                'apellidos' => $this->apellidos,
                'email' => $this->email,
                'usuario' => $this->usuario
            ];
            return true;
        } catch (PDOException $e) {
            // Si existe un error deshacer la transacción y lanzar una excepción
            $conexion->rollBack();
            throw new Exception($e->getMessage());
            return false;
        }finally{
            $conexion = null;
        }
    }

    // Iniciar sesión
    static function inicarSesion($usuario, $contraseña){
        try{
            $conexion = Conexion::obtenerConexion();
            $consulta = "SELECT * FROM usuarios WHERE usuario = :usuario";
            $stmt = $conexion->prepare($consulta);
            $stmt->bindParam(':usuario', $usuario);
            $stmt->execute();
            $resultado = $stmt->fetch();
            if($resultado && password_verify($contraseña, $resultado['contraseña'])){
                // Si el usuario y la contraseña son correctos iniciar sesión
                session_start();
                $_SESSION['usuario'] = [
                    'id' => $resultado['id_usuario'],
                    'nombre' => $resultado['nombre'],
                    'apellidos' => $resultado['apellidos'],
                    'email' => $resultado['email'],
                    'usuario' => $resultado['usuario']
                ];
                if(isset($_COOKIE['cesta'])){
                    // Si hay productos en la cesta se añaden a la base de datos
                    $productos = json_decode($_COOKIE['cesta'], true);
                    $cesta = new Cesta($resultado['id_usuario']);
                    // Obtener la cesta del usuario
                    $cesta->obtenerCesta();
                    // Recorrer los productos y añadirlos a la cesta
                    foreach($productos as $producto){
                        $cesta->anadirLibro($producto['id_libro'], $producto['cantidad']);
                    }

                    // Vaciar la cookie
                    setcookie('cesta', '', time() - 3600, '/');
                }
                return true;
            }else{
                return false;
            }
        }catch(PDOException $e){
            return false;
        }finally{
            $conexion = null;
        }
    }

    // Comprobar si un usuario existe
    static function existeUsuario($usuario, $email){
        try{
            $conexion = Conexion::obtenerConexion();
            $consulta = "SELECT * FROM usuarios WHERE usuario = :usuario AND email = :email";
            $stmt = $conexion->prepare($consulta);
            $stmt->bindParam(':usuario', $usuario);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $resultado = $stmt->fetch();
            if($resultado){
                return true;
            }else{
                return false;
            }
        }catch(PDOException $e){
            return false;
        }finally{
            $conexion = null;
        }
    }
}