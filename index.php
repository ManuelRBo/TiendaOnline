<?php 

    require('./Clases/Autoload.php');
    session_start();
    $_SESSION['ultima_url'] = $_SERVER['REQUEST_URI'];
    unset($_SESSION['errorIS']);
    unset($_SESSION['errorRegistro']);

    $bestSeller = Producto::bestSeller();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/global.css">
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/footer.css">
    <link rel="stylesheet" href="./css/libros.css">
    <title>Book</title>
</head>
<body>
    <?php include('./includes/header.php')?>
    <main>
        <section class="best-seller">
            <div class="titulo-libros">
                <div class="titulo">
                    <h1>Best Seller</h1>
                    <p>Top 3 libros más vendidos de la semana</p>
                </div>
                <div class="mejores-libros">
                    <?php foreach($bestSeller as $imagen){
                        echo '<img src="./img/LibrosPortadas/'.$imagen['imagen'].'.webp" class="mejor-libro libro-hover"></img>';
                    }?>
                </div>
            </div>
            <div class="estanteria">
                <img src="img/iconos/estanteria 2.png" alt="">
            </div>
        </section>
        <section class="ultimas-novedades">
            <h2>Ultimas Novedades</h2>
            <a href="biblioteca.php">Explora toda nuestra coleccion</a>
            <div class="ultimos-libros">
                <?php Producto::ultimoLibros();?>
                </div>
            </div>
        </section>
    </main>
    <?php include('./includes/footer.php') ?>
</body>
</html>