<?php

require_once('../Clases/Autoload.php');

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $nombre = htmlspecialchars(strtolower(trim($_POST['nombre'])));
    $apellidos = htmlspecialchars(strtolower(trim($_POST['apellidos'])));
    $emailIngresado = htmlspecialchars(strtolower(trim($_POST['email'])));
    $email = htmlspecialchars(strtolower(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)));
    $usuario = htmlspecialchars(strtolower(trim($_POST['usuario'])));
    $contraseña = htmlspecialchars(trim($_POST['contraseña']));
    $confirmarContraseña = htmlspecialchars(trim($_POST['confirmarContraseña']));

    $errores = [];
    if($contraseña != $confirmarContraseña){
        $errores['contraseñaConfirmacion'] = 'Las contraseñas no coinciden';
    }

    if(strlen($contraseña) < 8){
        $errores['contraseñaLongitud'] = 'La contraseña debe tener al menos 8 caracteres';
    }

    if(!preg_match('/[A-Z]/', $contraseña)){
        $errores['contraseñaMayuscula'] = 'La contraseña debe tener al menos una mayuscula';
    }

    if(!preg_match('/[0-9]/', $contraseña)){
        $errores['contraseñaNumero'] = 'La contraseña debe tener al menos un numero';
    }

    if($email === false || !preg_match('/@/', $email) || !preg_match('/\./', $email)){
        $errores['email'] = 'El email no es valido';
    }

    if(Usuario::existeUsuario($usuario, $email)){
        $errores['usuario'] = 'El usuario ya existe';
    }

    if(count($errores) > 0){
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
        $usuario = new Usuario($nombre, $apellidos, $email, password_hash($contraseña, PASSWORD_DEFAULT), $usuario);
        if($usuario->registrar()){
            header('Location: ../index.php');
        }else{
            header('Location: ../autenticar.php?error=registro');
        }
    }
}

