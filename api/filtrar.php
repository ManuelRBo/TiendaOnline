<?php

require_once ('../Clases/Autoload.php');

if(isset($_GET['min']) && isset($_GET['max'])){
    $libros = Producto::filtroPrecio($_GET['min'], $_GET['max'], isset($_GET['pagina']) ? $_GET['pagina'] : 1);
    $librosHTML = '';
    foreach($libros as $libro){
        $librosHTML .= Producto::mostrarLibro($libro);
    }
    echo $librosHTML;
}else if(isset($_GET['puntuacion'])){
    $libros = Producto::filtroEstrellas($_GET['puntuacion'], isset($_GET['pagina']) ? $_GET['pagina'] : 1);
    $librosHTML = '';
    foreach($libros as $libro){
        $librosHTML .= Producto::mostrarLibro($libro);
    }
    echo $librosHTML;
}