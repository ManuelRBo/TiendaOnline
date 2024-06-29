<?php
require_once('Clases/Autoload.php');
if(isset($_SESSION['usuario'])){
    $cantidad = Cesta::cantidadTotal($_SESSION['usuario']['id']);
    if(!isset($cantidad)){
        $cantidad = 0;
    }
}else{
    if(isset($_COOKIE['cesta'])){
        $cesta = json_decode($_COOKIE['cesta'], true);
        $sumarCantidades = function ($carry, $item) {
            return $carry + $item['cantidad'];
        };
        $cantidad = array_reduce($cesta, $sumarCantidades, 0);
    }else{
        $cantidad = 0;
    }
}
?>

<header>
    <div class="contenedor-header">
        <div class="logo">
            <a href="index.php"><img src="./img/logo/logo-b&n.svg" alt="Logo de la tienda" width="70px"></a>
        </div>
        <nav>
            <div class="bienvenida">
                <a href="<?php echo isset($_SESSION['usuario']) ? "#" : "autenticar.php"?>"><img src="./img/iconos/cuenta.svg" alt="Mi cuenta" height="30px"></a>
                <?php echo isset($_SESSION['usuario']) ? "<p>¡ Hola, ". ucfirst($_SESSION['usuario']['nombre'])." !</p>" : ""?>
            </div>
            <div class="cesta">
                <a href="cesta.php" style="width: 100%; height:100%"><img src="./img/iconos/cesta.svg" alt="Cesta" height="30px">
                <p class="cantidad"><?php echo $cantidad?></p>
            </a>
            </div>
            <?php echo isset($_SESSION['usuario']) ? '<a href="./api/cerrarSesion.php"><img src="./img/iconos/cerrarSesion.svg" alt="Cerar Sesion" width="25px"></a>' : ''?>
        </nav>
    </div>
</header>