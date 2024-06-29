<?php

/** 
 * Descripcion: Registra un usuario
 * Autor: Manuel Rodrigo Borriño
 * Fecha: 21 de febrero del 2024
 */

require_once('../Clases/Autoload.php');

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    //Se obtienen los datos del formulario y se limpian
    $nombre = htmlspecialchars(strtolower(trim($_POST['nombre'])));
    $apellidos = htmlspecialchars(strtolower(trim($_POST['apellidos'])));
    $emailIngresado = htmlspecialchars(strtolower(trim($_POST['email'])));
    $email = htmlspecialchars(strtolower(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)));
    $usuario = htmlspecialchars(strtolower(trim($_POST['usuario'])));
    $contraseña = htmlspecialchars(trim($_POST['contraseña']));
    $confirmarContraseña = htmlspecialchars(trim($_POST['confirmarContraseña']));

    $errores = [];
    //Se validan los datos
    if($contraseña != $confirmarContraseña){
        //Si las contraseñas no coinciden se añade un error
        $errores['contraseñaConfirmacion'] = 'Las contraseñas no coinciden';
    }

    if(strlen($contraseña) < 8){
        //Si la contraseña tiene menos de 8 caracteres se añade un error
        $errores['contraseñaLongitud'] = 'La contraseña debe tener al menos 8 caracteres';
    }

    if(!preg_match('/[A-Z]/', $contraseña)){
        // Si la contraseña no tiene al menos una mayuscula se añade un error
        $errores['contraseñaMayuscula'] = 'La contraseña debe tener al menos una mayuscula';
    }

    if(!preg_match('/[0-9]/', $contraseña)){
        // Si la contraseña no tiene al menos un numero se añade un error
        $errores['contraseñaNumero'] = 'La contraseña debe tener al menos un numero';
    }

    if($email === false || !preg_match('/@/', $email) || !preg_match('/\./', $email)){
        //Si el email no es valido se añade un error
        $errores['email'] = 'El email no es valido';
    }

    if(Usuario::existeUsuario($usuario, $email)){
        //Si el usuario o el email ya existen se añade un error
        $errores['usuario'] = 'El usuario ya existe';
    }

    if(count($errores) > 0){
        //Si hay errores se redirige a la pagina de autenticacion con los datos del formulario y los errores
        session_start();
        $_SESSION['errorRegistro'] = [
            'nombre' => $nombre,
            'apellidos' => $apellidos,
            'email' => $emailIngresado,
            'usuario' => $usuario,
            'contraseña' => $contraseña,
            'contraseñaConfirmacion' => $confirmarContraseña,
            'errores' => $errores
        ];
        header('Location: ../autenticar.php');
    }else{
        //Si no hay errores se crea el usuario
        $usuario = new Usuario($nombre, $apellidos, $email, password_hash($contraseña, PASSWORD_DEFAULT), $usuario);
        if($usuario->registrar()){
            //Si el usuario se crea correctamente se redirige a la pagina de inicio
            header('Location: ../index.php');
        }else{
            //Si el usuario no se crea correctamente se redirige a la pagina de autenticacion con un error
            header('Location: ../autenticar.php?error=registro');
        }
    }
}

