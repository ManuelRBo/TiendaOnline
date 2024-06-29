<?php

/**
 * Descripcion: Biblioteca de libros
 * Autor: Manuel Rodrigo Borriño
 * Fecha: 21 de febrero del 2024
 */

require_once('./Clases/Autoload.php');
session_start();
// Se guarda la ultima url visitada
$_SESSION['ultima_url'] = $_SERVER['REQUEST_URI'];
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="./css/global.css" />
  <link rel="stylesheet" href="./css/header.css" />
  <link rel="stylesheet" href="./css/footer.css" />
  <link rel="stylesheet" href="./css/biblioteca.css" />
  <link rel="stylesheet" href="./css/libros.css" />
  <link rel="shortcut icon" href="./img/logo/logo-b&n.svg" type="image/x-icon">
  <title>Biblioteca</title>
</head>

<body>
  <?php include('./includes/header.php') ?>
  <main>
    <div class="contenedor">
      <section class="busqueda">
        <input type="text" placeholder="Titulo, Autor, Genero literario ...." id="buscador" />
      </section>
      <div class="filtros-libros">
        <aside class="filtros">
          <h2>Filtros</h2>
          <div class="puntuacionFiltro">
            <h3>Puntuación</h3>
            <div class="puntuacion">
              <div class="estrella" data-estrella="1"><svg width="25" height="24" viewBox="0 0 25 24" fill="transparent" xmlns="http://www.w3.org/2000/svg">
                  <path d="M7.29077 20.2911L12.5008 17.1485L17.7109 20.3325L16.3463 14.3781L20.9362 10.4085L14.8991 9.87099L12.5008 4.24744L10.1025 9.82964L4.0655 10.3672L8.65531 14.3781L7.29077 20.2911ZM4.76844 23.7612L6.81938 14.9735L0 9.0655L8.9828 8.28812L12.5008 0L16.0189 8.28647L25 9.06384L18.1823 14.9719L20.2332 23.7595L12.5008 19.0953L4.76844 23.7612Z" fill="black" />
                  <polygon points="12.5 17.15 7.29 20.29 8.66 14.38 4.07 10.37 10.1 9.83 12.5 4.25 14.9 9.87 20.94 10.41 16.35 14.38 17.71 20.33 12.5 17.15" />
                </svg>
              </div>
              <div class="estrella" data-estrella="2"><svg width="25" height="24" viewBox="0 0 25 24" fill="transparent" xmlns="http://www.w3.org/2000/svg">
                  <path d="M7.29077 20.2911L12.5008 17.1485L17.7109 20.3325L16.3463 14.3781L20.9362 10.4085L14.8991 9.87099L12.5008 4.24744L10.1025 9.82964L4.0655 10.3672L8.65531 14.3781L7.29077 20.2911ZM4.76844 23.7612L6.81938 14.9735L0 9.0655L8.9828 8.28812L12.5008 0L16.0189 8.28647L25 9.06384L18.1823 14.9719L20.2332 23.7595L12.5008 19.0953L4.76844 23.7612Z" fill="black" />
                  <polygon points="12.5 17.15 7.29 20.29 8.66 14.38 4.07 10.37 10.1 9.83 12.5 4.25 14.9 9.87 20.94 10.41 16.35 14.38 17.71 20.33 12.5 17.15" />
                </svg>
              </div>
              <div class="estrella" data-estrella="3"><svg width="25" height="24" viewBox="0 0 25 24" fill="transparent" xmlns="http://www.w3.org/2000/svg">
                  <path d="M7.29077 20.2911L12.5008 17.1485L17.7109 20.3325L16.3463 14.3781L20.9362 10.4085L14.8991 9.87099L12.5008 4.24744L10.1025 9.82964L4.0655 10.3672L8.65531 14.3781L7.29077 20.2911ZM4.76844 23.7612L6.81938 14.9735L0 9.0655L8.9828 8.28812L12.5008 0L16.0189 8.28647L25 9.06384L18.1823 14.9719L20.2332 23.7595L12.5008 19.0953L4.76844 23.7612Z" fill="black" />
                  <polygon points="12.5 17.15 7.29 20.29 8.66 14.38 4.07 10.37 10.1 9.83 12.5 4.25 14.9 9.87 20.94 10.41 16.35 14.38 17.71 20.33 12.5 17.15" />
                </svg>
              </div>
              <div class="estrella" data-estrella="4"><svg width="25" height="24" viewBox="0 0 25 24" fill="transparent" xmlns="http://www.w3.org/2000/svg">
                  <path d="M7.29077 20.2911L12.5008 17.1485L17.7109 20.3325L16.3463 14.3781L20.9362 10.4085L14.8991 9.87099L12.5008 4.24744L10.1025 9.82964L4.0655 10.3672L8.65531 14.3781L7.29077 20.2911ZM4.76844 23.7612L6.81938 14.9735L0 9.0655L8.9828 8.28812L12.5008 0L16.0189 8.28647L25 9.06384L18.1823 14.9719L20.2332 23.7595L12.5008 19.0953L4.76844 23.7612Z" fill="black" />
                  <polygon points="12.5 17.15 7.29 20.29 8.66 14.38 4.07 10.37 10.1 9.83 12.5 4.25 14.9 9.87 20.94 10.41 16.35 14.38 17.71 20.33 12.5 17.15" />
                </svg>
              </div>
              <div class="estrella" data-estrella="5"><svg width="25" height="24" viewBox="0 0 25 24" fill="transparent" xmlns="http://www.w3.org/2000/svg">
                  <path d="M7.29077 20.2911L12.5008 17.1485L17.7109 20.3325L16.3463 14.3781L20.9362 10.4085L14.8991 9.87099L12.5008 4.24744L10.1025 9.82964L4.0655 10.3672L8.65531 14.3781L7.29077 20.2911ZM4.76844 23.7612L6.81938 14.9735L0 9.0655L8.9828 8.28812L12.5008 0L16.0189 8.28647L25 9.06384L18.1823 14.9719L20.2332 23.7595L12.5008 19.0953L4.76844 23.7612Z" fill="black" />
                  <polygon points="12.5 17.15 7.29 20.29 8.66 14.38 4.07 10.37 10.1 9.83 12.5 4.25 14.9 9.87 20.94 10.41 16.35 14.38 17.71 20.33 12.5 17.15" />
                </svg>
              </div>
            </div>
          </div>
          <div class="precioFiltro">
            <h3>Precio</h3>
            <div class="precios">
              <input type="number" placeholder="Min" min="0" max="100" id="min" />
              <input type="number" placeholder="Max" min="0" max="100" id="max" />
            </div>
          </div>
          <div id="orden">
            <h3>Orden</h3>
            <div>
              <select id="ordenar">
                <option value="default" selected disabled>Elige el orden</option>
                <option value="0">Más reciente</option>
                <option value="1">Más antiguo</option>
                <option value="2">Precio ascendente</option>
                <option value="3">Precio descendente</option>
              </select>
            </div>
          </div>
        </aside>
        <div id="libros">
          <span class="loader" id="loader"></span>
        </div>
      </div>
    </div>
    <div class="paginas" id="paginas">
    </div>
  </main>
  <?php include('./includes/footer.php') ?>
  <script src="./js/biblioteca.js"></script>
  <script src="./js/puntuacion.js"></script>
</body>

</html>