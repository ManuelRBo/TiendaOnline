<?php

/** 
 * Descripcion: Carga los libros de la biblioteca
 * Autor: Manuel Rodrigo Borriño
 * Fecha: 21 de febrero del 2024
 */

require_once ('../Clases/Autoload.php');


if(isset($_GET['orden']) && $_GET['orden'] == "undefined"){
    //Si no se ha seleccionado ningun orden se cargan los libros por defecto
    $libros = Producto::librosPorPagina(isset($_GET['pagina']) ? $_GET['pagina'] : 1);
    echo $libros;
}else if(isset($_GET['orden']) && $_GET['orden'] == "0"){
    //Si se selecciona el orden 0 se cargan los libros por fecha de lanzamiento descendente
    $ordenSQL = "ORDER BY libros.fecha_lanzamiento DESC";
    $libros = Producto::librosPorPagina(isset($_GET['pagina']) ? $_GET['pagina'] : 1, $ordenSQL);
    echo $libros;
}else if(isset($_GET['orden']) && $_GET['orden'] == "1"){
    //Si se selecciona el orden 1 se cargan los libros por fecha de lanzamiento ascendente
    $ordenSQL = "ORDER BY libros.fecha_lanzamiento ASC";
    $libros = Producto::librosPorPagina(isset($_GET['pagina']) ? $_GET['pagina'] : 1, $ordenSQL);
    echo $libros;
}else if(isset($_GET['orden']) && $_GET['orden'] == "2"){
    //Si se selecciona el orden 2 se cargan los libros por precio ascendente
    $ordenSQL = "ORDER BY libros.precio ASC";
    $libros = Producto::librosPorPagina(isset($_GET['pagina']) ? $_GET['pagina'] : 1, $ordenSQL);
    echo $libros;
}else if(isset($_GET['orden']) && $_GET['orden'] == "3"){
    //Si se selecciona el orden 3 se cargan los libros por precio descendente
    $ordenSQL = "ORDER BY libros.precio DESC";
    $libros = Producto::librosPorPagina(isset($_GET['pagina']) ? $_GET['pagina'] : 1, $ordenSQL);
    echo $libros;
}