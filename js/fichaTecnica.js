/**
 * @file fichaTecnica.js
 * @brief Archivo que contiene las funciones para volver atras desde la ficha técnica de un producto.
 * @details Este archivo contiene las funciones necesarias para volver atras desde la ficha técnica de un producto.
 * @version 1.0
 * @date 21-02-2024
 * @author Manuel Rodrigo Borriño
 */

// Eventos de la ficha técnica

// Al hacer click en la flecha de atrás, se vuelve a la página anterior
document.getElementById("flechaAtras").addEventListener("click", function () {
  window.history.back();
});
