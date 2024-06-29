
/**
 * @file autenticar.js
 * @brief Archivo que contiene las funciones para autenticar a un usuario.
 * @details Este archivo contiene las funciones necesarias para autenticar a un usuario en la aplicación.
 * @version 1.0
 * @date 21-02-2024
 * @author Manuel Rodrigo Borriño
 */

// Variables del formulario de inicio de sesión
let inputContraseñaIniciarSesion = document.getElementById('contraseñaIniciarSesion');
let ojoContraseñaIniciarSesion = document.getElementById('ojoIniciarSesion');


// Eventos del formulario de inicio de sesión

// Al hacer click en el ojo, se cambia el tipo de input de contraseña a texto y viceversa
ojoContraseñaIniciarSesion.addEventListener('click', function() {
    if(inputContraseñaIniciarSesion.type == 'password') {
        // Si el tipo de input es contraseña, se cambia a texto y se cambia la imagen del ojo
        inputContraseñaIniciarSesion.type = 'text';
        ojoContraseñaIniciarSesion.src = 'img/iconos/contraseñaON.svg';
    } else {
        // Si el tipo de input es texto, se cambia a contraseña y se cambia la imagen del ojo
        inputContraseñaIniciarSesion.type = 'password';
        ojoContraseñaIniciarSesion.src = 'img/iconos/contraseñaOFF.svg';
    }
});



// Variables del formulario de registro
let formularioRegistroCorrecto = false;
let inputEmail = document.getElementById('emailRegistro');
let ojoRegistro = document.getElementById('ojoRegistro');
let ojoContraseñaConfirmar = document.getElementById('ojoConfirmacion');
let inputContraseñaConfirmar = document.getElementById('contraseñaConfirmacion');

// Expresión regular para validar el email
let expresionEmail = /\w+@\w+\.+[a-z]{2,3}$/;

// Eventos del formulario de registro

// Al escribir en el input de email, se valida si el email es correcto
inputEmail.addEventListener('keyup', function() {
    if(expresionEmail.test(inputEmail.value)) {
        // Si el email es correcto, se pone el borde del input en verde
        inputEmail.style.border = '2px solid green';
        formularioRegistroCorrecto = true;
    } else {
        // Si el email no es correcto, se pone el borde del input en rojo
        inputEmail.style.border = '2px solid red';
        formularioRegistroCorrecto = false;
    }
});

// Al hacer click en el ojo de la contraseña, se cambia el tipo de input de contraseña a texto y viceversa
ojoRegistro.addEventListener('click', function() {
    if(inputContraseñaRegistro.type == 'password') {
        // Si el tipo de input es contraseña, se cambia a texto y se cambia la imagen del ojo
        inputContraseñaRegistro.type = 'text';
        ojoRegistro.src = 'img/iconos/contraseñaON.svg';
    } else {
        // Si el tipo de input es texto, se cambia a contraseña y se cambia la imagen del ojo
        inputContraseñaRegistro.type = 'password';
        ojoRegistro.src = 'img/iconos/contraseñaOFF.svg';
    }
});

// Al hacer click en el ojo de confirmar contraseña, se cambia el tipo de input de contraseña a texto y viceversa
ojoContraseñaConfirmar.addEventListener('click', function() {
    if(inputContraseñaConfirmar.type == 'password') {
        // Si el tipo de input es contraseña, se cambia a texto y se cambia la imagen del ojo
        inputContraseñaConfirmar.type = 'text';
        ojoContraseñaConfirmar.src = 'img/iconos/contraseñaON.svg';
    } else {
        // Si el tipo de input es texto, se cambia a contraseña y se cambia la imagen del ojo
        inputContraseñaConfirmar.type = 'password';
        ojoContraseñaConfirmar.src = 'img/iconos/contraseñaOFF.svg';
    }
});

// Al escribir en el input de confirmar contraseña, se valida si la contraseña es igual a la contraseña de registro
inputContraseñaConfirmar.addEventListener('keyup', function() {
    if(inputContraseñaConfirmar.value == inputContraseñaRegistro.value) {
        // Si la contraseña es igual a la de registro, se pone el borde del input en verde
        inputContraseñaConfirmar.style.border = '2px solid green';
        formularioRegistroCorrecto = true;
    } else {
        // Si la contraseña no es igual a la de registro, se pone el borde del input en rojo
        inputContraseñaConfirmar.style.border = '2px solid red';
        formularioRegistroCorrecto = false;
    }
});

// Variables del formulario de registro
let inputContraseñaRegistro = document.getElementById('contraseñaRegistro');
let expresionContraseña = /^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{8,16}$/;
let caracteres8 = /[a-zA-Z0-9]{8,16}/;
let caracteresMayuscula = /[A-Z]/;
let algunNumero = /[0-9]/;
let requisitosContraseña = document.getElementsByClassName('requisitos')[0];

// Eventos del formulario de registro

// Al hacer focus en el input de contraseña, se muestran los requisitos
inputContraseñaRegistro.addEventListener('focus', function() {
    requisitosContraseña.style.display = 'block';

    // Al escribir en el input de contraseña, se validan los requisitos
    inputContraseñaRegistro.addEventListener('keyup', function() {
    if(caracteres8.test(inputContraseñaRegistro.value)) {
        // Si la contraseña tiene 8 caracteres, se pone el texto en verde y se cambia la imagen
        requisitosContraseña.children[0].style.color = 'green';
        requisitosContraseña.children[0].children[0].src = 'img/iconos/tick.svg';
        requisitosContraseña.children[0].children[0].style.width = '15px';
        formularioRegistroCorrecto = true;
    } else {
        // Si la contraseña no tiene 8 caracteres, se pone el texto en rojo y se cambia la imagen
        requisitosContraseña.children[0].style.color = 'red';
        requisitosContraseña.children[0].children[0].src = 'img/iconos/error.svg';
        requisitosContraseña.children[0].children[0].style.width = '10px';
        formularioRegistroCorrecto = false;
    }

    if(caracteresMayuscula.test(inputContraseñaRegistro.value)) {
        // Si la contraseña tiene una mayúscula, se pone el texto en verde y se cambia la imagen
        requisitosContraseña.children[1].style.color = 'green';
        requisitosContraseña.children[1].children[0].src = 'img/iconos/tick.svg';
        requisitosContraseña.children[1].children[0].style.width = '15px';
        formularioRegistroCorrecto = true;
    } else {
        // Si la contraseña no tiene una mayúscula, se pone el texto en rojo y se cambia la imagen
        requisitosContraseña.children[1].style.color = 'red';
        requisitosContraseña.children[1].children[0].src = 'img/iconos/error.svg';
        requisitosContraseña.children[1].children[0].style.width = '10px';
        formularioRegistroCorrecto = false;
    }

    if(algunNumero.test(inputContraseñaRegistro.value)) {
        // Si la contraseña tiene un número, se pone el texto en verde y se cambia la imagen
        requisitosContraseña.children[2].style.color = 'green';
        requisitosContraseña.children[2].children[0].src = 'img/iconos/tick.svg';
        requisitosContraseña.children[2].children[0].style.width = '15px';
        formularioRegistroCorrecto = true;
    }else{
        // Si la contraseña no tiene un número, se pone el texto en rojo y se cambia la imagen
        requisitosContraseña.children[2].style.color = 'red';
        requisitosContraseña.children[2].children[0].src = 'img/iconos/error.svg';
        requisitosContraseña.children[2].children[0].style.width = '10px';
        formularioRegistroCorrecto = false;
    }
});

});

// Al hacer blur en el input de contraseña, se ocultan los requisitos
inputContraseñaRegistro.addEventListener('blur', function() {
    requisitosContraseña.style.display = 'none';
});

// Al escribir en el input de contraseña, se valida si la contraseña cumple con los requisitos
inputContraseñaRegistro.addEventListener('keyup', function() {
    if(expresionContraseña.test(inputContraseñaRegistro.value)) {
        // Si la contraseña cumple con los requisitos, se pone el borde del input en verde
        inputContraseñaRegistro.style.border = '2px solid green';
        formularioRegistroCorrecto = true;
    } else {
        // Si la contraseña no cumple con los requisitos, se pone el borde del input en rojo
        inputContraseñaRegistro.style.border = '2px solid red';
        formularioRegistroCorrecto = false;
    }
});

// Al hacer click en el botón de registro, se valida si el formulario es correcto
document.getElementById('registro').addEventListener('change', function() {
    if(formularioRegistroCorrecto) {
        // Si el formulario es correcto, se habilita el botón de registro
        document.getElementById('botonRegistro').disabled = false;
    } else {
        // Si el formulario no es correcto, se deshabilita el botón de registro
        document.getElementById('botonRegistro').disabled = true;
    }
});

