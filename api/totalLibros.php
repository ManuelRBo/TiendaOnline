<?php

/** 
 * Descripcion: Devuelve el total de libros
 * Autor: Manuel Rodrigo Borriño
 * Fecha: 21 de febrero del 2024
 */

require_once ('../Clases/Autoload.php');

if(isset($_GET['totalPaginas'])){
    //Si se recibe totalPaginas se devuelve el total de paginas
    echo Producto::librosTotales();
}else if(isset($_GET['busqueda'])){
    //Si se recibe busqueda se devuelve el total de libros que coinciden con la busqueda
    $busqueda = $_GET['busqueda'];
    echo Producto::totalBuscarLibros($busqueda);
}else if(isset($_GET['min']) && isset($_GET['max']) && !isset($_GET['busqueda'])){
    //Si se recibe un minimo y un maximo se devuelve el total de libros que coinciden con el filtro de precio
    echo Producto::totalFiltroPrecio($_GET['min'], $_GET['max']);
}else if(isset($_GET['puntuacion']) && !isset($_GET['busqueda']) && !isset($_GET['min']) && !isset($_GET['max'])){
    //Si se recibe una puntuacion se devuelve el total de libros que coinciden con el filtro de puntuacion
    echo Producto::totalFiltroEstrellas($_GET['puntuacion']);
}