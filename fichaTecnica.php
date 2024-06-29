<?php

/**
 * Descripcion: Ficha tecnica de un libro
 * Autor: Manuel Rodrigo Borriño
 * Fecha: 21 de febrero del 2024
 */

require_once('Clases/Autoload.php');
session_start();
// Se guarda la ultima url visitada
$_SESSION['ultima_url'] = $_SERVER['REQUEST_URI'];

if($_GET['id'] <= 0|| $_GET['id'] > Producto::librosTotales()) {
  // Si el id no es valido se redirige a la biblioteca
    header('Location: ./biblioteca.php');
}else{
  // Si el id es valido se obtiene la ficha tecnica del libro
  $libro = Producto::fichaTecnica($_GET['id']);
}
// Se obtienen las categorias del libro
$categorias = explode(',', $libro['categorias']);
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./css/global.css" />
    <link rel="stylesheet" href="./css/header.css" />
    <link rel="stylesheet" href="./css/footer.css" />
    <link rel="stylesheet" href="./css/fichaTecnica.css" />
    <link rel="shortcut icon" href="./img/logo/logo-b&n.svg" type="image/x-icon">
    <title><?php echo strtoupper($libro['titulo']) ?></title>
  </head>
  <body>
    <?php include('./includes/header.php') ?>
    <div class="flechaAtras"><img src="./img/iconos/fechaAtras.svg" alt="Flecha atras" width="30px" id="flechaAtras"></div>
    <main>
      <section class="detalles-anadir">
        <div class="detalles">
            <img src="./img/LibrosPortadas/<?php echo $libro['imagen']?>.webp" alt="" width="300px">          
            <div class="titulo-genero-sinopsis">
            <h2><?php echo $libro['titulo']?></h2>
            <h3><?php echo $libro['nombreAutor']?></h3>
            <div class="generos">
              <?php 
              // Se recorren las categorias del libro
              foreach($categorias as $categoria){
                  echo "<p>$categoria</p>";
              }?>
            </div>
            <div class="sinopsis">
                <h3>Sinopsis</h3>
                <p>
                    <?php echo $libro['sinopsis']?>
                </p>
            </div>
          </div>
        </div>
        <div class="anadir">
            <div class="precio-cantidad">
                <div class="precio">
                    <p><?php echo $libro['precio']?>€</p>
                </div>
                <div class="cantidad">
                    <p>Cantidad</p>
                    <select name="stock" id="cantidad">
                        <?php for($i = 1; $i <= min(5, $libro['cantidad']); $i++){
                            echo "<option value='$i'>$i</option>";
                        }?>
                    </select>
                </div>
            </div>
            <div class="boton-anadir">
                <button class="fechaTecnica-comprar" data-libro="<?php echo $libro['id_libro']?>"><?php echo ($libro['fecha_lanzamiento'] > (new DateTime())->format('Y-m-d') ? "Reservar" : "Añadir a la cesta") ?></button>
            </div>
            <div class="envio">
                <img src="./img/iconos/envio.svg" alt="Icono de un camion" width="30px">
                <p>Envío en 24/48 horas laborales</p>
            </div>
            <div class="recogida">
                <img src="./img/iconos/recogida.svg" alt="Icono de una tienda" width="30px">
                <p>Recogida gratuita en todas nuestras tiendas</p>
            </div>
        </div>
      </section>
      <section class="fichaTecnica">
        <h2>Ficha Técnica</h2>
        <div class="ficha">
          <div class="numero-paginas infoFicha">
            <h3>Número de páginas:</h3>
            <p><?php echo $libro['numero_paginas'] ?></p>
          </div>
          <div class="idioma infoFicha">
            <h3>Idioma:</h3>
            <p><?php echo $libro['idioma'] ?></p>
          </div>
          <div class="editorial infoFicha">
            <h3>Editorial</h3>
            <p><?php echo $libro['editorial'] ?></p>
          </div>
          <div class="isbn infoFicha">
            <h3>ISBN</h3>
            <p><?php echo $libro['isbn'] ?></p>
          </div>
          <div class="fecha-lanzamiento infoFicha">
            <h3>Fecha de lanzamiento</h3>
            <p><?php 
            $fecha = new DateTime($libro['fecha_lanzamiento']);
            echo $fecha->format('d/m/Y');
            ?></p>
          </div>
          <div class="alto infoFicha">
            <h3>Alto</h3>
            <p><?php echo $libro['alto'] ?> cm</p>
          </div>
          <div class="formato infoFicha">
            <h3>Encuadernación</h3>
            <p><?php echo $libro['encuadernacion'] ?></p>
          </div>
          <div class="ancho infoFicha">
            <h3>Ancho</h3>
            <p><?php echo $libro['ancho'] ?> cm</p>
          </div>
        </div>
      </section>
    </main>
    <?php include('./includes/footer.php') ?>
    <script src="./js/fichaTecnica.js"></script>
  </body>
</html>
