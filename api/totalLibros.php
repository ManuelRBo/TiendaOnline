<?php

require_once ('../Clases/Autoload.php');

if(isset($_GET['totalPaginas'])){
    require_once ('../Clases/Autoload.php');
    echo Producto::librosTotales();
}else if(isset($_GET['busqueda'])){
    $busqueda = $_GET['busqueda'];
    echo Producto::totalBuscarLibros($busqueda);
}else if(isset($_GET['min']) && isset($_GET['max']) && !isset($_GET['busqueda'])){
    echo Producto::totalFiltroPrecio($_GET['min'], $_GET['max']);
}else if(isset($_GET['puntuacion']) && !isset($_GET['busqueda']) && !isset($_GET['min']) && !isset($_GET['max'])){
    echo Producto::totalFiltroEstrellas($_GET['puntuacion']);
}