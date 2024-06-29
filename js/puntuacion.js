/**
 * @file puntuacion.js
 * @brief Archivo que contiene las funciones para cambiar los estilos de la puntuacion.
 * @details Este archivo contiene las funciones necesarias para cambiar los estilos de la puntuacion.
 * @version 1.0
 * @date 21-02-2024
 * @author Manuel Rodrigo Borriño
 */

// Variables de la puntuacion
var estrellas = document.querySelectorAll(".puntuacion .estrella");

// Eventos de la puntuacion

// Al pasar por encima de una estrella, se cambia el color de relleno de las estrellas hasta la actual
estrellas.forEach(function (estrella, index) {
  estrella.addEventListener("mouseover", function () {
    // Iterar sobre todas las estrellas hasta la actual y cambiar su color de relleno
    for (var i = 0; i <= index; i++) {
      estrellas[i].querySelector("svg polygon").style.fill = "#FFEC00";
      estrellas[i].querySelector("svg").style.transform = "scale(1.1)";
      estrellas[i].querySelector("svg").style.cursor = "pointer";
    }
  });

  // Al salir de una estrella, se vuelve al color original
  estrella.addEventListener("mouseout", function () {
    // Volver al color original para todas las estrellas
    estrellas.forEach(function (e) {
      if (!e.classList.contains("activa")) {
        e.querySelector("svg polygon").style.fill = "transparent";
        e.querySelector("svg").style.transform = "scale(1)";
      }
    });
  });
});
