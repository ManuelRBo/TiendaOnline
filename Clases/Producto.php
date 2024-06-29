<?php

/** 
 * Descripcion: Clase que gestiona los productos
 * Autor: Manuel Rodrigo Borriño
 * Fecha: 21 de febrero del 2024
 */

require_once('Autoload.php');

class Producto
{

    // Función que devuelve los últimos libros ordenados por fecha de lanzamiento
    static function ultimoLibros()
    {
        try{

        $conexion = Conexion::obtenerConexion();
        $consulta = $conexion->prepare("SELECT libros.id_libro, libros.titulo, libros.precio, libros.imagen, libros.puntuacion, libros.fecha_lanzamiento, autores.nombreAutor \n"

            . "FROM libros\n"

            . "LEFT JOIN libro_autor ON libros.id_libro = libro_autor.id_libro\n"

            . "LEFT JOIN autores ON libro_autor.id_autor = autores.id_autor\n"

            . "WHERE YEAR(libros.fecha_lanzamiento) = YEAR(CURRENT_DATE()) OR YEAR(libros.fecha_lanzamiento) = YEAR(CURRENT_DATE()) - 1 \n"

            . "ORDER BY libros.fecha_lanzamiento DESC\n"

            . "LIMIT 6;");
        $consulta->execute();
        $libros = $consulta->fetchAll(PDO::FETCH_ASSOC);
        // Se recorren los libros y se van mostrando
        foreach ($libros as $libro) {
            // Se llama a la función mostrarLibro que devuelve el HTML de un libro
            self::mostrarLibro($libro);
        }
    }catch(PDOException $e){
        echo "Error: " . $e->getMessage();
    }finally{
        $conexion = null;
    }
}

    // Función que muestra un libro
    static function mostrarLibro($libro)
    {
        $estrellas = '';
        // Se recorren las estrellas y se van concatenando
        for ($i = 0; $i < 5; $i++) {
            $estrellas .= '<div class="estrella"><svg width="25" height="24" viewBox="0 0 25 24" fill="' . (($i < $libro['puntuacion']) ? "yellow" : "transparent") . '" xmlns="http://www.w3.org/2000/svg">
           <path d="M7.29077 20.2911L12.5008 17.1485L17.7109 20.3325L16.3463 14.3781L20.9362 10.4085L14.8991 9.87099L12.5008 4.24744L10.1025 9.82964L4.0655 10.3672L8.65531 14.3781L7.29077 20.2911ZM4.76844 23.7612L6.81938 14.9735L0 9.0655L8.9828 8.28812L12.5008 0L16.0189 8.28647L25 9.06384L18.1823 14.9719L20.2332 23.7595L12.5008 19.0953L4.76844 23.7612Z" fill="black"/>
             <polygon points="12.5 17.15 7.29 20.29 8.66 14.38 4.07 10.37 10.1 9.83 12.5 4.25 14.9 9.87 20.94 10.41 16.35 14.38 17.71 20.33 12.5 17.15"/>
           </svg>
       </div>';
        }
        // Se muestra el HTML de un libro
        echo '<div class="ultimo-libro">
        <img src="./img/LibrosPortadas/' . $libro['imagen'] . '.webp" width="190px" height="290px">
        <div class="detalles">
            <div class="puntuacion">' . $estrellas . '</div>
            <p class="tituloLibro">' . $libro['titulo'] . '</p>
            <p class="autor">' . $libro['nombreAutor'] . '</p>
            <p class="precio">' . $libro['precio'] . '€</p>
            <a href="fichaTecnica.php?id=' . $libro['id_libro'] . '" class="ficha-tecnica">Ficha Técnica</a>
            <a class="comprar" data-libro="' . $libro['id_libro'] . '">' . ($libro['fecha_lanzamiento'] > (new DateTime())->format('Y-m-d') ? "Reservar" : "Añadir a la cesta") . '</a>
        </div>
    </div>'; {
        }
    }

    // Función que devuelve la ficha técnica de un libro
    static function fichaTecnica($id)
    {
        try{
        $conexion = Conexion::obtenerConexion();
        $consulta = $conexion->prepare("
     SELECT libros.*, autores.nombreAutor, stock.cantidad, GROUP_CONCAT(categorias.nombreCategoria) as categorias\n"
            . "FROM libros\n"
            . "LEFT JOIN libro_autor ON libros.id_libro = libro_autor.id_libro\n"
            . "LEFT JOIN autores ON libro_autor.id_autor = autores.id_autor\n"
            . "LEFT JOIN libro_categoria ON libros.id_libro = libro_categoria.id_libro\n"
            . "LEFT JOIN categorias ON libro_categoria.id_categoria = categorias.id_categoria\n"
            . "LEFT JOIN stock ON stock.id_stock = libros.id_libro\n"
            . "WHERE libros.id_libro = :id\n"
            . "GROUP BY libros.id_libro");
        $consulta->bindParam(':id', $id);
        $consulta->execute();
        $libro = $consulta->fetch(PDO::FETCH_ASSOC);
        return $libro;
    }catch(PDOException $e){
        echo "Error: " . $e->getMessage();
    }finally{
        $conexion = null;
    }
    }

    // Función que devuelve el número total de libros
    static function librosTotales()
    {
        try{
        $conexion = Conexion::obtenerConexion();
        $consulta = $conexion->prepare("SELECT COUNT(id_libro) as total FROM libros");
        $consulta->execute();
        $total = $consulta->fetch(PDO::FETCH_ASSOC);
        return $total['total'];
    }catch(PDOException $e){
        echo "Error: " . $e->getMessage();
    }finally{
        $conexion = null;
    }
}

    // Función que devuelve los libros por página y ordenados
    static function librosPorPagina($pagina, $orden = "")
    {
        try{
        $conexion = Conexion::obtenerConexion();
        $consulta = $conexion->prepare("SELECT libros.id_libro, libros.titulo, libros.precio, libros.imagen, libros.puntuacion, libros.fecha_lanzamiento, autores.nombreAutor \n"

            . "FROM libros\n"

            . "LEFT JOIN libro_autor ON libros.id_libro = libro_autor.id_libro\n"

            . "LEFT JOIN autores ON libro_autor.id_autor = autores.id_autor\n"

            // Se añade el orden a la consulta
            . $orden . "\n"

            . "LIMIT :indiceInicio, 9;");
        $indiceInicio = ($pagina - 1) * 9;
        $consulta->bindParam(':indiceInicio', $indiceInicio, PDO::PARAM_INT);
        $consulta->execute();
        $libros = $consulta->fetchAll(PDO::FETCH_ASSOC);
        // Se recorren los libros y se van mostrando
        foreach ($libros as $libro) {
            // Se llama a la función mostrarLibro que devuelve el HTML de un libro
            self::mostrarLibro($libro);
        }
    }catch(PDOException $e){
        echo "Error: " . $e->getMessage();
    }finally{
        $conexion = null;
    }
    }

    // Función que devuelve los libros más vendidos
    static function bestSeller()
    {
        try{
        $conexion = Conexion::obtenerConexion();
        $consulta = $conexion->prepare("SELECT libros.imagen FROM libros\n"

            . "RIGHT JOIN libros_populares ON libros.id_libro = libros_populares.id_libro\n"

            . "ORDER BY `libros_populares`.`popularidad` DESC\n"
            
            . "LIMIT 3;");
        $consulta->execute();
        $libros = $consulta->fetchAll(PDO::FETCH_ASSOC);
        return $libros;
    }catch(PDOException $e){
        echo "Error: " . $e->getMessage();
    }finally{
        $conexion = null;
    }
    }

    // Funcion que devuelve los libros y su autor
    static function obtenerLibro($id)
    {
        try{
        $conexion = Conexion::obtenerConexion();
        $consulta = $conexion->prepare("SELECT libros.*, autores.nombreAutor FROM libros\n"

            . "LEFT JOIN libro_autor ON libros.id_libro = libro_autor.id_libro\n"

            . "LEFT JOIN autores ON libro_autor.id_autor = autores.id_autor\n"

            . "WHERE libros.id_libro = :id");
        $consulta->bindParam(':id', $id);
        $consulta->execute();
        $libro = $consulta->fetch(PDO::FETCH_ASSOC);
        return $libro;
    }catch(PDOException $e){
        echo "Error: " . $e->getMessage();
    }finally{
        $conexion = null;
    }
    }

    // Función que busca los libros que coincidan con la búsqueda
    static function buscarLibros($busqueda, $pagina)
{
    try {
        $conexion = Conexion::obtenerConexion();
        // Consulta para obtener los resultados limitados a 9 por página
        $consulta = $conexion->prepare("
            SELECT
                libros.id_libro,
                libros.titulo,
                libros.precio,
                libros.imagen,
                libros.puntuacion,
                libros.fecha_lanzamiento,
                autores.nombreAutor,
                GROUP_CONCAT(categorias.nombreCategoria) as categorias
            FROM
                libros
                LEFT JOIN libro_autor ON libros.id_libro = libro_autor.id_libro
                LEFT JOIN autores ON libro_autor.id_autor = autores.id_autor
                LEFT JOIN libro_categoria ON libros.id_libro = libro_categoria.id_libro
                LEFT JOIN categorias ON libro_categoria.id_categoria = categorias.id_categoria
            WHERE
                REPLACE(LOWER(libros.titulo), ' ', '') LIKE REPLACE(LOWER(:busqueda), ' ', '')
                OR REPLACE(LOWER(autores.nombreAutor), ' ', '') LIKE REPLACE(LOWER(:busqueda), ' ', '')
                OR REPLACE(LOWER(categorias.nombreCategoria), ' ', '') LIKE REPLACE(LOWER(:busqueda), ' ', '')
                OR REPLACE(LOWER(libros.isbn), ' ', '') LIKE REPLACE(LOWER(:busqueda), ' ', '')
            GROUP BY libros.id_libro
            LIMIT :indiceInicio, 9;
        ");

        $busqueda = '%' . $busqueda . '%';
        $indiceInicio = ($pagina - 1) * 9;
        $consulta->bindParam(':busqueda', $busqueda, PDO::PARAM_STR);
        $consulta->bindParam(':indiceInicio', $indiceInicio, PDO::PARAM_INT);
        $consulta->execute();
        $libros = $consulta->fetchAll(PDO::FETCH_ASSOC);
        return $libros;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }finally{
        $conexion = null;
    }
}

    // Función que devuelve el número total de libros que coinciden con la búsqueda
    static function totalBuscarLibros($busqueda){
        try{
            $conexion = Conexion::obtenerConexion();
        
        // Consulta para obtener el número total de libros
        $consultaTotal = $conexion->prepare("
            SELECT COUNT(DISTINCT libros.id_libro) as totalLibros
            FROM libros
                LEFT JOIN libro_autor ON libros.id_libro = libro_autor.id_libro
                LEFT JOIN autores ON libro_autor.id_autor = autores.id_autor
                LEFT JOIN libro_categoria ON libros.id_libro = libro_categoria.id_libro
                LEFT JOIN categorias ON libro_categoria.id_categoria = categorias.id_categoria
            WHERE
                REPLACE(LOWER(libros.titulo), ' ', '') LIKE REPLACE(LOWER(:busqueda), ' ', '')
                OR REPLACE(LOWER(autores.nombreAutor), ' ', '') LIKE REPLACE(LOWER(:busqueda), ' ', '')
                OR REPLACE(LOWER(categorias.nombreCategoria), ' ', '') LIKE REPLACE(LOWER(:busqueda), ' ', '')
                OR REPLACE(LOWER(libros.isbn), ' ', '') LIKE REPLACE(LOWER(:busqueda), ' ', '')
        ");
        
        $busqueda = '%' . $busqueda . '%';
        $consultaTotal->bindParam(':busqueda', $busqueda, PDO::PARAM_STR);
        $consultaTotal->execute();
        $totalLibros = $consultaTotal->fetchColumn();
        return $totalLibros;
        }catch(PDOException $e){
            echo "Error: " . $e->getMessage();
        }finally{
            $conexion = null;
        }
    }

    // Función que devuelve los libros que coincidan con el filtro de precio
    static function filtroPrecio($min, $max, $pagina){
        try{
            $conexion = Conexion::obtenerConexion();
            $consulta = $conexion->prepare("
                SELECT
                    libros.id_libro,
                    libros.titulo,
                    libros.precio,
                    libros.imagen,
                    libros.puntuacion,
                    libros.fecha_lanzamiento,
                    autores.nombreAutor
                FROM libros
                LEFT JOIN libro_autor ON libros.id_libro = libro_autor.id_libro
                LEFT JOIN autores ON libro_autor.id_autor = autores.id_autor
                WHERE libros.precio BETWEEN :min AND :max
                GROUP BY libros.id_libro
                ORDER BY libros.precio ASC
                LIMIT :indiceInicio, 9;
            ");
            $indiceInicio = ($pagina - 1) * 9;
            $consulta->bindParam(':min', $min);
            $consulta->bindParam(':max', $max);
            $consulta->bindParam(':indiceInicio', $indiceInicio, PDO::PARAM_INT);
            $consulta->execute();
            $libros = $consulta->fetchAll(PDO::FETCH_ASSOC);
            return $libros;
        }catch(PDOException $e){
            echo "Error: " . $e->getMessage();
        }finally{
            $conexion = null;
        }
    }

    // Función que devuelve el número total de libros que coinciden con el filtro de precio
    static function totalFiltroPrecio($min, $max){
        try{
            $conexion = Conexion::obtenerConexion();
            $consulta = $conexion->prepare("
                SELECT COUNT(DISTINCT libros.id_libro) as totalLibros
                FROM libros
                LEFT JOIN libro_autor ON libros.id_libro = libro_autor.id_libro
                LEFT JOIN autores ON libro_autor.id_autor = autores.id_autor
                WHERE libros.precio BETWEEN :min AND :max
            ");
            $consulta->bindParam(':min', $min);
            $consulta->bindParam(':max', $max);
            $consulta->execute();
            $totalLibros = $consulta->fetchColumn();
            return $totalLibros;
        }catch(PDOException $e){
            echo "Error: " . $e->getMessage();
        }finally{
            $conexion = null;
        }
    }

    // Función que devuelve los libros que coincidan con el filtro de puntuación
    static function filtroEstrellas($puntuacion, $pagina){
        try{
            $conexion = Conexion::obtenerConexion();
            $consulta = $conexion->prepare("
                SELECT
                    libros.id_libro,
                    libros.titulo,
                    libros.precio,
                    libros.imagen,
                    libros.puntuacion,
                    libros.fecha_lanzamiento,
                    autores.nombreAutor
                FROM libros
                LEFT JOIN libro_autor ON libros.id_libro = libro_autor.id_libro
                LEFT JOIN autores ON libro_autor.id_autor = autores.id_autor
                WHERE libros.puntuacion = :puntuacion
                GROUP BY libros.id_libro
                ORDER BY libros.puntuacion DESC
                LIMIT :indiceInicio, 9;
            ");
            $indiceInicio = ($pagina - 1) * 9;
            $consulta->bindParam(':puntuacion', $puntuacion);
            $consulta->bindParam(':indiceInicio', $indiceInicio, PDO::PARAM_INT);
            $consulta->execute();
            $libros = $consulta->fetchAll(PDO::FETCH_ASSOC);
            return $libros;
        }catch(PDOException $e){
            echo "Error: " . $e->getMessage();
        }finally{
            $conexion = null;
        }
    }

    // Función que devuelve el número total de libros que coinciden con el filtro de puntuación
    static function totalFiltroEstrellas($puntuacion){
        try{
            $conexion = Conexion::obtenerConexion();
            $consulta = $conexion->prepare("
                SELECT COUNT(DISTINCT libros.id_libro) as totalLibros
                FROM libros
                LEFT JOIN libro_autor ON libros.id_libro = libro_autor.id_libro
                LEFT JOIN autores ON libro_autor.id_autor = autores.id_autor
                WHERE libros.puntuacion = :puntuacion
            ");
            $consulta->bindParam(':puntuacion', $puntuacion);
            $consulta->execute();
            $totalLibros = $consulta->fetchColumn();
            return $totalLibros;
        }catch(PDOException $e){
            echo "Error: " . $e->getMessage();
        }finally{
            $conexion = null;
        }
    }
}