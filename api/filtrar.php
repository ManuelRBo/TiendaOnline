<?php

/** 
 * Descripcion: Filtra los libros por precio o puntuacion
 * Autor: Manuel Rodrigo Borriño
 * Fecha: 21 de febrero del 2024
 */

require_once ('../Clases/Autoload.php');

if(isset($_GET['min']) && isset($_GET['max'])){
    //Si se recibe un minimo y un maximo se filtran los libros por precio
    $libros = Producto::filtroPrecio($_GET['min'], $_GET['max'], isset($_GET['pagina']) ? $_GET['pagina'] : 1);
    $librosHTML = '';
    //Se recorren los libros y se van concatenando en la variable $librosHTML
    foreach($libros as $libro){
        //Se llama a la funcion mostrarLibro de la clase Producto, devuelve el HTML de un libro
        $librosHTML .= Producto::mostrarLibro($libro);
    }
    echo $librosHTML;
}else if(isset($_GET['puntuacion'])){
    //Si se recibe una puntuacion se filtran los libros por puntuacion
    $libros = Producto::filtroEstrellas($_GET['puntuacion'], isset($_GET['pagina']) ? $_GET['pagina'] : 1);
    $librosHTML = '';
    //Se recorren los libros y se van concatenando en la variable $librosHTML
    foreach($libros as $libro){
        //Se llama a la funcion mostrarLibro de la clase Producto, devuelve el HTML de un libro
        $librosHTML .= Producto::mostrarLibro($libro);
    }
    echo $librosHTML;
}