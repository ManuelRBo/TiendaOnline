/**
 * @file suscribete.js
 * @brief Archivo que contiene las funciones para comprobar si el email es válido.
 * @details Este archivo contiene las funciones necesarias para comprobar si el email es válido.
 * @version 1.0
 * @date 21-02-2024
 * @author Manuel Rodrigo Borriño
 */

// Variables del formulario
let formulario = document.getElementById("suscribete");

// Eventos del formulario

// Al enviar el formulario, se comprueba si el email es válido
formulario.addEventListener("submit", function (e) {
  // Evitar que se envíe el formulario
  e.preventDefault();

  // Obtener el email del formulario
  let email = new FormData(formulario).get("email");

  // Expresión regular para comprobar si el email es válido
  let expresion = /\w+@\w+\.[a-z]{2,4}/;

  if (expresion.test(email)) {
    // Si el email es válido, se muestra un mensaje de agradecimiento y se resetea el formulario
    formulario.reset();
    document.getElementById("mensaje").style.display = "block";
    document.getElementById("mensaje").innerHTML = "Gracias por suscribirte";
    document.getElementById("mensaje").style.color = "green";
    formulario.email.style.border = "1px solid green";
  } else {
    // Si el email no es válido, se muestra un mensaje de error
    document.getElementById("mensaje").style.display = "block";
    document.getElementById("mensaje").innerHTML = "Email no válido";
    document.getElementById("mensaje").style.color = "red";
    formulario.email.style.border = "1px solid red";
  }

  // Ocultar el mensaje después de 3 segundos
  setTimeout(() => {
    document.getElementById("mensaje").style.display = "none";
    document.getElementById("mensaje").innerHTML = "";
    formulario.email.style.border = "1px solid #C37338";
  }, 3000);
});
