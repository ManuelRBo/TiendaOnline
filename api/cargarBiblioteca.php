<?php

require_once ('../Clases/Autoload.php');

if(isset($_GET['orden']) && $_GET['orden'] == "undefined"){
    $libros = Producto::librosPorPagina(isset($_GET['pagina']) ? $_GET['pagina'] : 1);
    echo $libros;
}else if(isset($_GET['orden']) && $_GET['orden'] == "0"){
    $ordenSQL = "ORDER BY libros.fecha_lanzamiento DESC";
    $libros = Producto::librosPorPagina(isset($_GET['pagina']) ? $_GET['pagina'] : 1, $ordenSQL);
    echo $libros;
}else if(isset($_GET['orden']) && $_GET['orden'] == "1"){
    $ordenSQL = "ORDER BY libros.fecha_lanzamiento ASC";
    $libros = Producto::librosPorPagina(isset($_GET['pagina']) ? $_GET['pagina'] : 1, $ordenSQL);
    echo $libros;
}else if(isset($_GET['orden']) && $_GET['orden'] == "2"){
    $ordenSQL = "ORDER BY libros.precio ASC";
    $libros = Producto::librosPorPagina(isset($_GET['pagina']) ? $_GET['pagina'] : 1, $ordenSQL);
    echo $libros;
}else if(isset($_GET['orden']) && $_GET['orden'] == "3"){
    $ordenSQL = "ORDER BY libros.precio DESC";
    $libros = Producto::librosPorPagina(isset($_GET['pagina']) ? $_GET['pagina'] : 1, $ordenSQL);
    echo $libros;
}