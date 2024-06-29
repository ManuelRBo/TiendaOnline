<?php

/**
 * Descripcion: Pagina de autenticacion
 * Autor: Manuel Rodrigo Borriño
 * Fecha: 21 de febrero del 2024
 */

session_start();

?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./css/global.css" />
    <link rel="stylesheet" href="./css/header.css" />
    <link rel="stylesheet" href="./css/footer.css" />
    <link rel="stylesheet" href="./css/autenticar.css" />
    <link rel="stylesheet" href="./css/libros.css" />
    <link rel="shortcut icon" href="./img/logo/logo-b&n.svg" type="image/x-icon">
    <title>Auntenticar</title>
  </head>
  <body>

   <?php include('./includes/header.php'); ?>

   <?php echo isset($_GET['error']) ? '<h1 style="text-align:center; background-color:red; color:white; width:200px; margin: 20px auto; padding: 10px">Error al registrarse</h1>' : ''?>

    <main>
      <section class="iniciarSesion">
        <h2>Iniciar Sesión</h2>
        <form action="./api/iniciarSesion.php" method="post" class="formulario" id="iniciarSesion">
          <input type="text" required placeholder="Usuario" name="usuario" value="<?php echo isset($_SESSION['errorIS']) ? $_SESSION['errorIS']['usuario'] : ''?>"/>
          <input type="password" required placeholder="Contraseña" name="contraseña" id="contraseñaIniciarSesion" value="<?php echo isset($_SESSION['errorIS']) ? $_SESSION['errorIS']['contraseña'] : ''?>"/>
          <img src="img/iconos/contraseñaOFF.svg" alt="" id="ojoIniciarSesion" width="20px">
          <input type="submit" value="Iniciar Sesión" />
        </form>
        <?php
          if(isset($_SESSION['errorIS'])){
            echo '<p class="error">Usuario o contraseña incorrectos</p>';
          }
        ?>
      </section>
      <section class="registrarse">
        <h2>Registrarse</h2>
        <form action="./api/registro.php" method="post" class="formulario" id="registro">
          <input type="text" required placeholder="Nombre" name="nombre" value="<?php echo isset($_SESSION['errorRegistro']) ? $_SESSION['errorRegistro']['nombre'] : ''?>"/>
          <input type="text" required placeholder="Apellidos" name="apellidos" value="<?php echo isset($_SESSION['errorRegistro']) ? $_SESSION['errorRegistro']['apellidos'] : ''?>"/>
          <input type="email" required placeholder="Correo electrónico" name="email" id="emailRegistro" value="<?php echo isset($_SESSION['errorRegistro']) ? $_SESSION['errorRegistro']['email'] : ''?>"/>
          <input type="text" required placeholder="Usuario" name="usuario" value="<?php echo isset($_SESSION['errorRegistro']) ? $_SESSION['errorRegistro']['usuario'] : ''?>"/>
          <div class="contraseñaRegistro">
            <input type="password" required placeholder="Contraseña" name="contraseña" id="contraseñaRegistro" value="<?php echo isset($_SESSION['errorRegistro']) ? $_SESSION['errorRegistro']['contraseña'] : ''?>"/>
            <img src="./img/iconos/contraseñaOFF.svg" alt="No ver contraseña" id="ojoRegistro" width="20px">
          </div>
          <div class="contraseñaConfirmacion">
            <input type="password" required placeholder="Repetir Contraseña" name="confirmarContraseña" id="contraseñaConfirmacion" value="<?php echo isset($_SESSION['errorRegistro']) ? $_SESSION['errorRegistro']['contraseñaConfirmacion'] : ''?>"/>
            <img src="./img/iconos/contraseñaOFF.svg" alt="No ver contraseña" id="ojoConfirmacion" width="20px">
          </div>
          <div class="requisitos">
            <p><img src="./img/iconos/error.svg" alt="" width="10px">La contraseña debe tener al menos 8 caracteres</p>
            <p><img src="./img/iconos/error.svg" alt="" width="10px">La contraseña debe tener al menos una mayuscula</p>
            <p><img src="./img/iconos/error.svg" alt="" width="10px">La contraseña debe tener al menos un numero</p>
          </div>

          <?php
            if(isset($_SESSION['errorRegistro']['errores'])){
              //Mostrar errores
              foreach($_SESSION['errorRegistro']['errores'] as $error){
                echo '<p class="error">'.$error.'</p>';
              }
            }
            ?>
          <input type="submit" value="Registrarse" id="botonRegistro"/>
        </form>
      </section>
    </main>

    <?php include('./includes/footer.php') ?>
    
    <script src="./js/autenticar.js"></script>
  </body>
</html>
