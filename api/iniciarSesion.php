<?php

require_once('../Clases/Autoload.php');
session_start();

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $usuario = htmlspecialchars(strtolower($_POST['usuario']));
    $contraseña = htmlspecialchars($_POST['contraseña']);

    if(Usuario::inicarSesion($usuario, $contraseña)){
        unset($_SESSION['errorIS']);
        header('Location: ' . $_SESSION['ultima_url']);
    }else{
        $_SESSION['errorIS'] = ['usuario' => $usuario, 'contraseña' => $contraseña];
        header('Location: ../autenticar.php');
    }    
}