/**
 * @file biblioteca.js
 * @brief Archivo que contiene las funciones para cargar los libros de la biblioteca.
 * @details Este archivo contiene las funciones necesarias para cargar los libros de la biblioteca, buscar libros, filtrar por precio y puntuación y ordenar por precio.
 * @version 1.0
 * @date 21-02-2024
 * @author Manuel Rodrigo Borriño
 */

// Variables de la biblioteca
let numTotalPaginas = 0;

// Funcion que calcula el numero total de paginas
function numeroTotalPaginas(busqueda = undefined, precioMax = undefined, precioMin = undefined, min = undefined, max = undefined, puntuacion=undefined) {
  if (busqueda === undefined && precioMax === undefined && precioMin === undefined && puntuacion === undefined) {
    // Fetch para obtener el número total de libros si no hay busqueda ni filtros
    fetch(
      "http://localhost/Tienda%20Online%20de%20Libros/api/totalLibros.php?totalPaginas=true"
    )
      .then((res) => res.text())
      .then((data) => {
        numTotalPaginas = Math.ceil(data / 9);
        // Llamar a la función que actualiza el número de páginas
        actualizarNumPaginas(numTotalPaginas);
      });
  } else if (precioMax === undefined && precioMin === undefined && puntuacion === undefined && busqueda !== undefined) {
    // Fetch para obtener el número total de libros si hay busqueda
    fetch(
      "http://localhost/Tienda%20Online%20de%20Libros/api/totalLibros.php?busqueda=" +
      busqueda
    )
      .then((res) => res.text())
      .then((data) => {
        if (data == 0) {
          document.getElementById("libros").classList.remove("libros-loader");
          document.getElementById("libros").classList.add("libros");
          document.getElementById("libros").innerHTML = "<h1 style='color:rgb(50, 50, 50)'>No existen libros con esta búsqueda</h1>";
        }else{
        numTotalPaginas = Math.ceil(data / 9);
        // Llamar a la función que actualiza el número de páginas
        actualizarNumPaginas(numTotalPaginas);
        }
      });
  }else if(precioMax !== undefined || precioMin !== undefined && busqueda === undefined && puntuacion === undefined){
    // Fetch para obtener el número total de libros si hay filtro de precio
    fetch(
      "http://localhost/Tienda%20Online%20de%20Libros/api/totalLibros.php?min=" + parseFloat(min) + "&max=" + parseFloat(max))
      .then((res) => res.text())
      .then((data) => {
        if (data == 0) {
          document.getElementById("libros").classList.remove("libros-loader");
          document.getElementById("libros").classList.add("libros");
          document.getElementById("libros").innerHTML = "<h1 style='color:rgb(50, 50, 50)'>No existen libros en este rango de precio</h1>";
        }else{
        numTotalPaginas = Math.ceil(data / 9);
        // Llamar a la función que actualiza el número de páginas
        actualizarNumPaginas(numTotalPaginas);
        }
      });
  }else if(precioMax === undefined || precioMin === undefined && busqueda === undefined && puntuacion !== undefined){
    // Fetch para obtener el número total de libros si hay filtro de puntuacion
    fetch(
      "http://localhost/Tienda%20Online%20de%20Libros/api/totalLibros.php?puntuacion=" + puntuacion)
      .then((res) => res.text())
      .then((data) => {
        if (data == 0) {
          document.getElementById("libros").classList.remove("libros-loader");
          document.getElementById("libros").classList.add("libros");
          document.getElementById("libros").innerHTML = "<h1 style='color:rgb(50, 50, 50)'>No existen libros con esta puntuación</h1>";
        }else{
        numTotalPaginas = Math.ceil(data / 9);
        // Llamar a la función que actualiza el número de páginas
        actualizarNumPaginas(numTotalPaginas);
        }
      });
  }

}

// Funcion que carga los libros de la biblioteca en la página al cargar la página
function cargarLibros(pagina = 1, orden) {
  // Limpiar contenido existente
  document.getElementById("libros").innerHTML = "";
  document.getElementById("libros").classList.remove("libros");
  document.getElementById("libros").classList.add("libros-loader");
  // Mostrar un spinner de carga
  document.getElementById("libros").innerHTML =
    '<span class="loader" id="loader"></span>';
  document.getElementById("loader").style.display = "inline-block";

  // Fetch para obtener los libros de la biblioteca
  fetch(
    "http://localhost/Tienda%20Online%20de%20Libros/api/cargarBiblioteca.php?pagina=" +
      pagina + "&orden=" + orden
  )
    .then((res) => res.text())
    .then((data) => {
      // Ocultar el spinner de carga y mostrar los libros
      if(document.getElementById('loader')){
        document.getElementById("loader").style.display = "none";
      }
      document.getElementById("libros").classList.remove("libros-loader");
      document.getElementById("libros").classList.add("libros");
      document.getElementById("libros").innerHTML = data;
      window.scrollTo(0, 0);
    })
    .catch((error) => console.log(error));
}

// Funcion que actualiza el número de páginas
function actualizarNumPaginas(totalPaginas, pagina = 1) {
  let paginas = document.getElementById("paginas");
  // Limpiar contenido existente
  paginas.innerHTML = "";

  // Agregar flecha de retroceso si no es la primera página
  if (pagina !== 1) {
    paginas.innerHTML += `<img src="./img/iconos/cambiarPagina.svg" alt="" width="25px" id="flechaMenos" style="cursor:pointer;">`;
  }

  // Mostrar las páginas
  for (let i = Math.max(1, pagina - 1); i <= Math.min(totalPaginas, pagina + 1); i++) {
    paginas.innerHTML += `<span class="pagina ${i === pagina ? 'seleccionada' : ''}" data-pagina="${i}">${i}</span>`;
  }

  // Agregar flecha de avance si no es la última página
  if (pagina !== totalPaginas) {
    paginas.innerHTML += `<img src="./img/iconos/cambiarPagina.svg" alt="" width="25px" style="transform: rotate(180deg); cursor: pointer;" id="flechaMas">`;
  }

  // Asignar evento a las páginas generadas
  let paginasGeneradas = document.querySelectorAll(".pagina");
  paginasGeneradas.forEach((paginaGenerada) => {
    paginaGenerada.addEventListener("click", () => {
      // Obtener el número de la página seleccionada
      let nuevaPagina = parseInt(paginaGenerada.getAttribute("data-pagina"));
      if (nuevaPagina !== pagina) {
        // Cambiar la página seleccionada y cargar los libros de la nueva página
        document.querySelector(".seleccionada").classList.remove("seleccionada");
        paginaGenerada.classList.add("seleccionada");

        if (document.getElementById("buscador").value === "" && document.getElementById('min').value === "" && document.getElementById('max').value === "" && puntuacion === undefined) {
          // Si no hay busqueda ni filtros, cargar los libros de la nueva página con la función de cargarLibros
          cargarLibros(nuevaPagina, orden);
          // Actualizar el número de páginas
          actualizarNumPaginas(totalPaginas, nuevaPagina);

        } else if(precioMax.value == "" && precioMin.value == "" && document.getElementById("buscador").value !== "" && puntuacion === undefined){
          // Si hay busqueda, cargar los libros de la nueva página con la funcion de buscar
          buscarLibro(document.getElementById("buscador").value, nuevaPagina);
          // Actualizar el número de páginas
          actualizarNumPaginas(totalPaginas, nuevaPagina);

        }else if((document.getElementById('min') != "" || document.getElementById('max').value != "") && document.getElementById("buscador").value === "" && puntuacion === undefined){
          // Si hay filtro de precio, cargar los libros de la nueva página con la funcion de filtrar
          filtrar(document.getElementById('min').value, document.getElementById('max').value, nuevaPagina);
          // Actualizar el número de páginas
          actualizarNumPaginas(totalPaginas, nuevaPagina);

      }else if(precioMax.value === "" || precioMin.value === "" && document.getElementById("buscador").value === "" && puntuacion !== undefined){
        // Si hay filtro de puntuacion, cargar los libros de la nueva página con la funcion de filtrarPuntuacion
        filtrarPuntuacion(puntuacion, nuevaPagina);
        // Actualizar el número de páginas
        actualizarNumPaginas(totalPaginas, nuevaPagina);
    }
    window.scrollTo(0, 0);
  }
    });
  });

  // Agregar eventos a las flechas de cambio de página
  let flechaMenos = document.getElementById("flechaMenos");
  let flechaMas = document.getElementById("flechaMas");

  if (flechaMenos) {
    // Si existe la flecha de retroceso, agregar evento
    flechaMenos.addEventListener("click", () => {
      let nuevaPagina = Math.max(1, pagina - 1);
      if (nuevaPagina !== pagina) {

        if (document.getElementById("buscador").value === "" && document.getElementById('min').value === "" && document.getElementById('max').value === "" && puntuacion === undefined) {
          console.log('entra');
          // Si no hay busqueda ni filtros, cargar los libros de la nueva página con la función de cargarLibros
          cargarLibros(nuevaPagina, orden);
          // Actualizar el número de páginas
          actualizarNumPaginas(totalPaginas, nuevaPagina);

        } else if(precioMax.value == "" && precioMin.value == "" && document.getElementById("buscador").value !== "" && puntuacion === undefined){
          console.log('entra1');
          // Si hay busqueda, cargar los libros de la nueva página con la funcion de buscar
          buscarLibro(document.getElementById("buscador").value, nuevaPagina);
          // Actualizar el número de páginas
          actualizarNumPaginas(totalPaginas, nuevaPagina);

        }else if((document.getElementById('min') != "" || document.getElementById('max').value != "") && document.getElementById("buscador").value === "" && puntuacion === undefined){
          console.log('entra2');
          // Si hay filtro de precio, cargar los libros de la nueva página con la funcion de filtrar
          filtrar(document.getElementById('min').value, document.getElementById('max').value, nuevaPagina);
          // Actualizar el número de páginas
          actualizarNumPaginas(totalPaginas, nuevaPagina);

      }else if(precioMax.value === "" || precioMin.value === "" && document.getElementById("buscador").value === "" && puntuacion !== undefined){
        console.log('entra3');
        // Si hay filtro de puntuacion, cargar los libros de la nueva página con la funcion de filtrarPuntuacion
        filtrarPuntuacion(puntuacion, nuevaPagina);
        // Actualizar el número de páginas
        actualizarNumPaginas(totalPaginas, nuevaPagina);
    }
      }
      window.scrollTo(0, 0);
    });
  }


  if (flechaMas) {
    // Si existe la flecha de avance, agregar evento
    flechaMas.addEventListener("click", () => {
      let nuevaPagina = Math.min(totalPaginas, pagina + 1);
      if (nuevaPagina !== pagina) {

        if (document.getElementById("buscador").value === "" && document.getElementById('min').value === "" && document.getElementById('max').value === "" && puntuacion === undefined) {
          console.log('entra');
          // Si no hay busqueda ni filtros, cargar los libros de la nueva página con la función de cargarLibros
          cargarLibros(nuevaPagina, orden);
          // Actualizar el número de páginas
          actualizarNumPaginas(totalPaginas, nuevaPagina);

        } else if(precioMax.value == "" && precioMin.value == "" && document.getElementById("buscador").value !== "" && puntuacion === undefined){
          console.log('entra1');
          // Si hay busqueda, cargar los libros de la nueva página con la funcion de buscar
          buscarLibro(document.getElementById("buscador").value, nuevaPagina);
          // Actualizar el número de páginas
          actualizarNumPaginas(totalPaginas, nuevaPagina);

        }else if((document.getElementById('min') != "" || document.getElementById('max').value != "") && document.getElementById("buscador").value === "" && puntuacion === undefined){
          console.log('entra2');
          // Si hay filtro de precio, cargar los libros de la nueva página con la funcion de filtrar
          filtrar(document.getElementById('min').value, document.getElementById('max').value, nuevaPagina);
          // Actualizar el número de páginas
          actualizarNumPaginas(totalPaginas, nuevaPagina);

      }else if(precioMax.value === "" || precioMin.value === "" && document.getElementById("buscador").value === "" && puntuacion !== undefined){
        console.log('entra3');
        // Si hay filtro de puntuacion, cargar los libros de la nueva página con la funcion de filtrarPuntuacion
        filtrarPuntuacion(puntuacion, nuevaPagina);
        // Actualizar el número de páginas
        actualizarNumPaginas(totalPaginas, nuevaPagina);
    }
      }
      window.scrollTo(0, 0);
    });
  }
}


const buscador = document.getElementById("buscador");

if (buscador.value === "") {
  // Si no hay busqueda, cargar los libros de la primera página
  cargarLibros();
  numeroTotalPaginas();
} else {
  // Si hay busqueda, cargar los libros que coincidan con la busqueda
  buscarLibro(buscador.value);
  numeroTotalPaginas(buscador.value);
}

buscador.addEventListener("input", () => {
  // Al escribir en el buscador, buscar los libros que coincidan con la busqueda
  let busqueda = buscador.value;
  if (busqueda === "") {
    cargarLibros();
    numeroTotalPaginas();
  } else {
    precioMax.value = "";
    precioMin.value = "";
    selectFiltro.value = "default";
    estrellasIconos.forEach((estrella)=>{
      estrella.classList.remove('activa');
      estrella.querySelector('svg polygon').style.fill = 'transparent';
    });
    buscarLibro(busqueda);
    numeroTotalPaginas(busqueda);
  }
});

// Funcion que busca los libros que coincidan con la busqueda
function buscarLibro(busqueda, pagina = 1) {
  if (busqueda !== "") {
    // Si hay busqueda, cargar los libros que coincidan con la busqueda
    if (!document.getElementById("loader")) {
      document.getElementById("paginas").innerHTML = "";
      document.getElementById("libros").classList.remove("libros");
      document.getElementById("libros").classList.add("libros-loader");
      document.getElementById("libros").innerHTML =
        '<span class="loader" id="loader"></span>';
      document.getElementById("loader").style.display = "inline-block";
    }

    // Fetch para obtener los libros que coincidan con la busqueda
    fetch(
      "http://localhost/Tienda%20Online%20de%20Libros/api/busqueda.php?busqueda=" +
        busqueda +
        "&pagina=" +
        pagina
    )
      .then((res) => res.text())
      .then((data) => {
        // Ocultar el spinner de carga y mostrar los libros
        if(document.getElementById('loader')){
          document.getElementById("loader").style.display = "none";
        }
        document.getElementById("libros").classList.remove("libros-loader");
        document.getElementById("libros").classList.add("libros");
        document.getElementById("libros").innerHTML = data;
        window.scrollTo(0, 0);
      })
      .catch((error) => console.log(error));
  }
}

// Variables de los filtros de precio
const precioMax = document.getElementById('max');
const precioMin = document.getElementById('min');

let min = 0;
let max = 1000;

// Al cambiar el valor del filtro de precio mínimo, filtrar los libros que coincidan con el filtro
precioMin.addEventListener('input', function() {
  if(precioMax.value == "" && precioMin.value == ""){
    // Si no hay filtro de precio, cargar los libros de la primera página
    cargarLibros();
    numeroTotalPaginas();
}else{
  // Si hay filtro de precio, filtrar los libros que coincidan con el filtro
    if(precioMin.value == ""){
      // Si el filtro de precio mínimo está vacío, asignarle el valor 0
        min = 0;
    } else{
      // Si el filtro de precio mínimo no está vacío, asignarle el valor del filtro
        min = precioMin.value;
    }
    // Limpiar el filtro de puntuacion
    estrellasIconos.forEach((estrella)=>{
      estrella.classList.remove('activa');
      estrella.querySelector('svg polygon').style.fill = 'transparent';
    });
    selectFiltro.value = "default";
    // Filtrar los libros que coincidan con el filtro
    filtrar(min, max);
    // Actualizar el número de páginas
    numeroTotalPaginas(undefined,precioMax, precioMin, min, max);
  }
});

// Al cambiar el valor del filtro de precio máximo, filtrar los libros que coincidan con el filtro
precioMax.addEventListener('input', function() {
  if(precioMax.value == "" && precioMin.value == ""){
    // Si no hay filtro de precio, cargar los libros de la primera página
      cargarLibros();
      numeroTotalPaginas();
  }else{
    // Si hay filtro de precio, filtrar los libros que coincidan con el filtro
    if(precioMax.value == ""){
      // Si el filtro de precio máximo está vacío, asignarle el valor 1000
      max = 1000;
  }else{
    // Si el filtro de precio máximo no está vacío, asignarle el valor del filtro
      max = precioMax.value;
  }
  // Limpiar el filtro de puntuacion
  estrellasIconos.forEach((estrella)=>{
    estrella.classList.remove('activa');
    estrella.querySelector('svg polygon').style.fill = 'transparent';
  });
  selectFiltro.value = "default";
  // Filtrar los libros que coincidan con el filtro
  filtrar(min, max);
  // Actualizar el número de páginas
  numeroTotalPaginas(undefined, precioMax, precioMin, min, max);
  }
});

// Fucnion que filtra los libros que coincidan con el filtro de precio
function filtrar(min, max, pagina = 1) {
    if (min >= 0 && max <= 1000) {
      // Si el filtro de precio es válido, filtrar los libros que coincidan con el filtro
        fetch('http://localhost/Tienda%20Online%20de%20Libros/api/filtrar.php?min=' + min + '&max=' + max + '&pagina=' + pagina)
            .then(response => response.text())
            .then(data => {
                document.getElementById('libros').classList.remove('libros-loader');
                document.getElementById('libros').classList.add('libros');
                document.getElementById('libros').innerHTML = data;
            });
    }
}

// Eventos de la puntuacion
const estrellasIconos  = document.querySelectorAll('.puntuacion .estrella');
let puntuacion = undefined;

// Recorrer las estrellas y asignarles un evento
estrellasIconos.forEach((estrella)=>{
  estrella.addEventListener('click', function(){
    // Al hacer click en una estrella, cambiar el color de relleno de las estrellas hasta la actual
    let numeroEstrellas = estrella.getAttribute('data-estrella');
    puntuacion = numeroEstrellas;
    // Reconocer la puntuacion seleccionada
    for(let i = 0; i < estrellasIconos.length; i++){
      estrellasIconos[i].classList.remove('activa');
      estrellasIconos[i].querySelector('svg polygon').style.fill = 'transparent';
    }
    // Asignar la puntuacion seleccionada
    for (var i = 0; i < numeroEstrellas; i++) {
        estrellasIconos[i].classList.add('activa');
        estrellasIconos[i].querySelector('svg polygon').style.fill = 'yellow';
    }

    // Eliminar los filtros de precio
    precioMax.value = "";
    precioMin.value = "";
    selectFiltro.value = "default";

    // Filtrar los libros que coincidan con el filtro de puntuacion
    filtrarPuntuacion(puntuacion);
    // Actualizar el número de páginas
    numeroTotalPaginas(undefined, undefined, undefined, undefined, undefined, puntuacion);
  });
})


// Funcion que filtra los libros que coincidan con el filtro de puntuacion
function filtrarPuntuacion(puntuacion, pagina = 1){
  // Si hay filtro de puntuacion, filtrar los libros que coincidan con el filtro
  fetch('http://localhost/Tienda%20Online%20de%20Libros/api/filtrar.php?puntuacion=' + puntuacion + '&pagina=' + pagina)
  .then(response => response.text())
  .then(data => {
      document.getElementById('libros').classList.remove('libros-loader');
      document.getElementById('libros').classList.add('libros');
      document.getElementById('libros').innerHTML = data;
  });
}


let orden = undefined;
// Al cambiar el valor del filtro de orden, ordenar los libros que coincidan con el filtro
const selectFiltro = document.getElementById('ordenar');
selectFiltro.addEventListener('change', function(){
  // Al cambiar el valor del filtro de orden, ordenar los libros que coincidan con el filtro
  orden = selectFiltro.value;
  precioMax.value = "";
  precioMin.value = "";
  estrellasIconos.forEach((estrella)=>{
    estrella.classList.remove('activa');
    estrella.querySelector('svg polygon').style.fill = 'transparent';
  });
  // Si hay un filtro de orden, ordenar los libros que coincidan con el filtro
  cargarLibros(1, orden);
  // Actualizar el número de páginas
  numeroTotalPaginas();
});