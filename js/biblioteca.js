let numTotalPaginas = 0;



function numeroTotalPaginas(busqueda = undefined, precioMax = undefined, precioMin = undefined, min = undefined, max = undefined, puntuacion=undefined) {
  if (busqueda === undefined && precioMax === undefined && precioMin === undefined && puntuacion === undefined) {
    fetch(
      "http://localhost/Tienda%20Online%20de%20Libros/api/totalLibros.php?totalPaginas=true"
    )
      .then((res) => res.text())
      .then((data) => {
        numTotalPaginas = Math.ceil(data / 9);
        actualizarNumPaginas(numTotalPaginas);
      });
  } else if (precioMax === undefined && precioMin === undefined && puntuacion === undefined && busqueda !== undefined) {
    fetch(
      "http://localhost/Tienda%20Online%20de%20Libros/api/totalLibros.php?busqueda=" +
      busqueda
    )
      .then((res) => res.text())
      .then((data) => {
        numTotalPaginas = Math.ceil(data / 9);
        actualizarNumPaginas(numTotalPaginas);
      });
  }else if(precioMax !== undefined || precioMin !== undefined && busqueda === undefined && puntuacion === undefined){
    fetch(
      "http://localhost/Tienda%20Online%20de%20Libros/api/totalLibros.php?min=" + parseFloat(min) + "&max=" + parseFloat(max))
      .then((res) => res.text())
      .then((data) => {
        numTotalPaginas = Math.ceil(data / 9);
        actualizarNumPaginas(numTotalPaginas);
      });
  }else if(precioMax === undefined || precioMin === undefined && busqueda === undefined && puntuacion !== undefined){
    fetch(
      "http://localhost/Tienda%20Online%20de%20Libros/api/totalLibros.php?puntuacion=" + puntuacion)
      .then((res) => res.text())
      .then((data) => {
        console.log(data);
        numTotalPaginas = Math.ceil(data / 9);
        actualizarNumPaginas(numTotalPaginas);
      });
  }

}

function cargarLibros(pagina = 1, orden) {
  // Limpiar contenido existente
  document.getElementById("libros").innerHTML = "";
  document.getElementById("libros").classList.remove("libros");
  document.getElementById("libros").classList.add("libros-loader");
  document.getElementById("libros").innerHTML =
    '<span class="loader" id="loader"></span>';
  document.getElementById("loader").style.display = "inline-block";

  fetch(
    "http://localhost/Tienda%20Online%20de%20Libros/api/cargarBiblioteca.php?pagina=" +
      pagina + "&orden=" + orden
  )
    .then((res) => res.text())
    .then((data) => {
      document.getElementById("loader").style.display = "none";
      document.getElementById("libros").classList.remove("libros-loader");
      document.getElementById("libros").classList.add("libros");
      document.getElementById("libros").innerHTML = data;
      window.scrollTo(0, 0);
    })
    .catch((error) => console.log(error));
}

function actualizarNumPaginas(totalPaginas, pagina = 1) {
  let paginas = document.getElementById("paginas");
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
      let nuevaPagina = parseInt(paginaGenerada.getAttribute("data-pagina"));
      if (nuevaPagina !== pagina) {
        document.querySelector(".seleccionada").classList.remove("seleccionada");
        paginaGenerada.classList.add("seleccionada");

        if (document.getElementById("buscador").value === "" && document.getElementById('min').value === "" && document.getElementById('max').value === "" && puntuacion === undefined) {
          cargarLibros(nuevaPagina, orden);
          actualizarNumPaginas(totalPaginas, nuevaPagina);
        } else if(precioMax.value == "" && precioMin.value == "" && document.getElementById("buscador").value !== "" && puntuacion === undefined){
          buscarLibro(document.getElementById("buscador").value, nuevaPagina);
          actualizarNumPaginas(totalPaginas, nuevaPagina);
        }else if((document.getElementById('min') != "" || document.getElementById('max').value != "") && document.getElementById("buscador").value === "" && puntuacion === undefined){
          filtrar(document.getElementById('min').value, document.getElementById('max').value, nuevaPagina);
          actualizarNumPaginas(totalPaginas, nuevaPagina);
      }else if(precioMax.value === "" || precioMin.value === "" && document.getElementById("buscador").value === "" && puntuacion !== undefined){
        filtrarPuntuacion(puntuacion, nuevaPagina);
        actualizarNumPaginas(totalPaginas, nuevaPagina);
    }
  }
    });
  });

  // Agregar eventos a las flechas de cambio de página
  let flechaMenos = document.getElementById("flechaMenos");
  let flechaMas = document.getElementById("flechaMas");

  if (flechaMenos) {
    flechaMenos.addEventListener("click", () => {
      let nuevaPagina = Math.max(1, pagina - 1);
      if (nuevaPagina !== pagina) {
        cargarLibros(nuevaPagina);
        actualizarNumPaginas(totalPaginas, nuevaPagina);
      }
    });
  }

  if (flechaMas) {
    flechaMas.addEventListener("click", () => {
      let nuevaPagina = Math.min(totalPaginas, pagina + 1);
      if (nuevaPagina !== pagina) {
        cargarLibros(nuevaPagina);
        actualizarNumPaginas(totalPaginas, nuevaPagina);
      }
    });
  }
}


const buscador = document.getElementById("buscador");

if (buscador.value === "") {
  cargarLibros();
  numeroTotalPaginas();
} else {
  buscarLibro(buscador.value);
  numeroTotalPaginas(buscador.value);
}

buscador.addEventListener("input", () => {
  let busqueda = buscador.value;
  if (busqueda === "") {
    cargarLibros();
    numeroTotalPaginas();
  } else {
    buscarLibro(busqueda);
    numeroTotalPaginas(busqueda);
  }
});

function buscarLibro(busqueda, pagina = 1) {
  // Resto de la función buscarLibro
  if (busqueda !== "") {
    if (!document.getElementById("loader")) {
      document.getElementById("paginas").innerHTML = "";
      document.getElementById("libros").classList.remove("libros");
      document.getElementById("libros").classList.add("libros-loader");
      document.getElementById("libros").innerHTML =
        '<span class="loader" id="loader"></span>';
      document.getElementById("loader").style.display = "inline-block";
    }

    fetch(
      "http://localhost/Tienda%20Online%20de%20Libros/api/busqueda.php?busqueda=" +
        busqueda +
        "&pagina=" +
        pagina
    )
      .then((res) => res.text())
      .then((data) => {
        document.getElementById("loader").style.display = "none";
        document.getElementById("libros").classList.remove("libros-loader");
        document.getElementById("libros").classList.add("libros");
        document.getElementById("libros").innerHTML = data;
        window.scrollTo(0, 0);
      })
      .catch((error) => console.log(error));
  }
}

const precioMax = document.getElementById('max');
const precioMin = document.getElementById('min');

let min = 0;
let max = 1000;

precioMin.addEventListener('input', function() {
  if(precioMax.value == "" && precioMin.value == ""){
    cargarLibros();
    numeroTotalPaginas();
}else{
    if(precioMin.value == ""){
        min = 0;
    } else{
        min = precioMin.value;
    }
    estrellasIconos.forEach((estrella)=>{
      estrella.classList.remove('activa');
      estrella.querySelector('svg polygon').style.fill = 'transparent';
    });
    selectFiltro.value = "default";
    filtrar(min, max);
    numeroTotalPaginas(undefined,precioMax, precioMin, min, max);
  }
});

precioMax.addEventListener('input', function() {
  if(precioMax.value == "" && precioMin.value == ""){
      cargarLibros();
      numeroTotalPaginas();
  }else{
    if(precioMax.value == ""){
      max = 1000;
  }else{
      max = precioMax.value;
  }
  estrellasIconos.forEach((estrella)=>{
    estrella.classList.remove('activa');
    estrella.querySelector('svg polygon').style.fill = 'transparent';
  });
  selectFiltro.value = "default";
  filtrar(min, max);
  numeroTotalPaginas(undefined, precioMax, precioMin, min, max);
  }
});

function filtrar(min, max, pagina = 1) {
    if (min >= 0 && max <= 1000) {
        fetch('http://localhost/Tienda%20Online%20de%20Libros/api/filtrar.php?min=' + min + '&max=' + max + '&pagina=' + pagina)
            .then(response => response.text())
            .then(data => {
                document.getElementById('libros').innerHTML = data;
            });
    }
}

const estrellasIconos  = document.querySelectorAll('.puntuacion .estrella');
let puntuacion = undefined;

estrellasIconos.forEach((estrella)=>{
  estrella.addEventListener('click', function(){
    let numeroEstrellas = estrella.getAttribute('data-estrella');
    puntuacion = numeroEstrellas;
    for(let i = 0; i < estrellasIconos.length; i++){
      estrellasIconos[i].classList.remove('activa');
      estrellasIconos[i].querySelector('svg polygon').style.fill = 'transparent';
    }
    for (var i = 0; i < numeroEstrellas; i++) {
        estrellasIconos[i].classList.add('activa');
        estrellasIconos[i].querySelector('svg polygon').style.fill = 'yellow';
    }
    precioMax.value = "";
    precioMin.value = "";
    selectFiltro.value = "default";
    filtrarPuntuacion(puntuacion);
    numeroTotalPaginas(undefined, undefined, undefined, undefined, undefined, puntuacion);
  });
})

function filtrarPuntuacion(puntuacion, pagina = 1){
  fetch('http://localhost/Tienda%20Online%20de%20Libros/api/filtrar.php?puntuacion=' + puntuacion + '&pagina=' + pagina)
  .then(response => response.text())
  .then(data => {
      document.getElementById('libros').innerHTML = data;
  });
}


const selectFiltro = document.getElementById('ordenar');
let orden = undefined;
selectFiltro.addEventListener('change', function(){
  orden = selectFiltro.value;
  precioMax.value = "";
  precioMin.value = "";
  estrellasIconos.forEach((estrella)=>{
    estrella.classList.remove('activa');
    estrella.querySelector('svg polygon').style.fill = 'transparent';
  });
  cargarLibros(1, orden);
  numeroTotalPaginas();
});