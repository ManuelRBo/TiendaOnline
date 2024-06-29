<?php

/** 
 * Descripcion: Busca los libros que coincidan con la busqueda
 * Autor: Manuel Rodrigo Borriño
 * Fecha: 21 de febrero del 2024
*/

require_once ('../Clases/Autoload.php');
//Se obtiene la busqueda
$busqueda = $_GET['busqueda'];

//Se llama a la funcion buscarLibros de la clase Producto y se le pasa la busqueda y la pagina
$libros = Producto::buscarLibros($busqueda , isset($_GET['pagina']) ? $_GET['pagina'] : 1);
$librosHTML = "";

//Se recorren los libros y se van concatenando en la variable $librosHTML
foreach ($libros as $libro) {
    //Se llama a la funcion mostrarLibro de la clase Producto, devuelve el HTML de un libro
    $librosHTML .= Producto::mostrarLibro($libro);
}
echo $librosHTML;
?>

