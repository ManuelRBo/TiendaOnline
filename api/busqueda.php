<?php

require_once ('../Clases/Autoload.php');
$busqueda = $_GET['busqueda'];

$libros = Producto::buscarLibros($busqueda , isset($_GET['pagina']) ? $_GET['pagina'] : 1);
$librosHTML = "";
foreach ($libros as $libro) {
    $librosHTML .= Producto::mostrarLibro($libro);
}
echo $librosHTML;
?>

