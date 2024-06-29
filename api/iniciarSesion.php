<?php

/**
 * Descripcion: Inicia la sesion del usuario
 * Autor: Manuel Rodrigo Borriño
 * Fecha: 21 de febrero del 2024
 */

require_once('../Clases/Autoload.php');
session_start();

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    //Se obtienen los datos del formulario y se limpian
    $usuario = htmlspecialchars(strtolower($_POST['usuario']));
    $contraseña = htmlspecialchars($_POST['contraseña']);

    if(Usuario::inicarSesion($usuario, $contraseña)){
        //Si el usuario y la contraseña son correctos se redirige a la ultima url visitada y se destruye el error
        unset($_SESSION['errorIS']);
        header('Location: ' . $_SESSION['ultima_url']);
    }else{
        //Si el usuario o la contraseña son incorrectos se redirige a la pagina de autenticacion con los datos del formulario
        $_SESSION['errorIS'] = ['usuario' => $usuario, 'contraseña' => $contraseña];
        header('Location: ../autenticar.php');
    }    
}