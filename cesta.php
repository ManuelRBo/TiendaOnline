<?php
  require_once('./Clases/Autoload.php');
  session_start();
  
  if(isset($_SESSION['usuario'])){
    $id_usuario = $_SESSION['usuario']['id'];
    $cesta = new Cesta($id_usuario);
    $cesta->obtenerCesta();
    $productos = $cesta->obtenerProductosCesta();
  }else{
    $productos = [];
    if(isset($_COOKIE['cesta'])){
      $productos = json_decode($_COOKIE['cesta'], true);
    }
  }

?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./css/global.css" />
    <link rel="stylesheet" href="./css/header.css" />
    <link rel="stylesheet" href="./css/footer.css" />
    <link rel="stylesheet" href="./css/cesta.css" />
    <link rel="stylesheet" href="./css/libros.css" />
    <title>Biblioteca</title>
  </head>
  <body>
    <?php include('./includes/header.php') ?>
    <main>
      <h1>Cesta</h1>
      <div class="contenedor-cesta">
        <section class="productos">
          <?php 
          if(empty($productos)):
            echo "<p class='vacia'>La cesta está vacía</p>";
          else:
          foreach($productos as $producto):
            $libro = Producto::obtenerLibro($producto['id_libro']);
            ?>
          <div class="producto" id="producto-<?php echo $producto['id_libro']?>">
            <div class="ultimo-libro">
              <img src="./img/LibrosPortadas/<?php echo $libro['imagen']?>.webp" alt="<?php echo $libro['titulo']?>" height="200px" width="135px">
              <div class="detalles">
                <p class="titulo"><?php echo $libro['titulo']?></p>
                <p class="autor"><?php echo $libro['nombreAutor']?></p>
                <a href="fichaTecnica.php?id=<?php echo $libro['id_libro']?>" class="ficha-tecnica">Ficha Tecnica</a>
              </div>
            </div>
            <div class="cantidad">
              <p><?php echo $libro['precio']?>€</p>
              <div class="numeroCantidad">
                <p class="eliminar" data-libro="<?php echo $producto['id_libro']?>">-</p>
                <p class="cantidadLibro"><?php echo $producto['cantidad']?></p>
                <p class="añadir" data-libro="<?php echo $producto['id_libro']?>">+</p>
              </div>
            </div>
          </div>
          <?php endforeach; endif;?>
        </section>
        <section class="totalCompra">
          <div class="subtotal">
            <p>Subtotal</p>
            <p id="subtotal"><?php
              if(empty($productos)){
                echo "0.00€";
              }else{
                $subtotal = 0;
                foreach($productos as $producto){
                  $libro = Producto::obtenerLibro($producto['id_libro']);
                  $subtotal += ($libro['precio'] * $producto['cantidad']);
                }
                echo number_format($subtotal, 2) . "€";
              }
            ?></p>
          </div>
          <div class="envio">
            <p>Envio</p>
            <p>0,00€</p>
          </div>
          <div class="total">
            <p>Total</p>
            <p id="total">
              <?php
              if(empty($productos)){
                echo "0.00€";}
              else{
                echo number_format($subtotal, 2) . "€";
              }
              ?>
            </p>
          </div>
          <a href="#" id="pedido">Comprar</a>
        </section>
      </div>
    </main>
    <?php include('./includes/footer.php') ?>
  </body>
</html>
