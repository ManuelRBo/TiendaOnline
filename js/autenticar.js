let inputContraseñaIniciarSesion = document.getElementById('contraseñaIniciarSesion');
let ojoContraseñaIniciarSesion = document.getElementById('ojoIniciarSesion');

ojoContraseñaIniciarSesion.addEventListener('click', function() {
    if(inputContraseñaIniciarSesion.type == 'password') {
        inputContraseñaIniciarSesion.type = 'text';
        ojoContraseñaIniciarSesion.src = 'img/iconos/contraseñaON.svg';
    } else {
        inputContraseñaIniciarSesion.type = 'password';
        ojoContraseñaIniciarSesion.src = 'img/iconos/contraseñaOFF.svg';
    }
});

let inputEmail = document.getElementById('emailRegistro');
let expresionEmail = /\w+@\w+\.+[a-z]{2,3}$/;
inputEmail.addEventListener('keyup', function() {
    if(expresionEmail.test(inputEmail.value)) {
        inputEmail.style.border = '2px solid green';
    } else {
        inputEmail.style.border = '2px solid red';
    }
});

let ojoRegistro = document.getElementById('ojoRegistro');
ojoRegistro.addEventListener('click', function() {
    if(inputContraseñaRegistro.type == 'password') {
        inputContraseñaRegistro.type = 'text';
        ojoRegistro.src = 'img/iconos/contraseñaON.svg';
    } else {
        inputContraseñaRegistro.type = 'password';
        ojoRegistro.src = 'img/iconos/contraseñaOFF.svg';
    }
});

let ojoContraseñaConfirmar = document.getElementById('ojoConfirmacion');
let inputContraseñaConfirmar = document.getElementById('contraseñaConfirmacion');
ojoContraseñaConfirmar.addEventListener('click', function() {
    if(inputContraseñaConfirmar.type == 'password') {
        inputContraseñaConfirmar.type = 'text';
        ojoContraseñaConfirmar.src = 'img/iconos/contraseñaON.svg';
    } else {
        inputContraseñaConfirmar.type = 'password';
        ojoContraseñaConfirmar.src = 'img/iconos/contraseñaOFF.svg';
    }
});

inputContraseñaConfirmar.addEventListener('keyup', function() {
    if(inputContraseñaConfirmar.value == inputContraseñaRegistro.value) {
        inputContraseñaConfirmar.style.border = '2px solid green';
    } else {
        inputContraseñaConfirmar.style.border = '2px solid red';
    }
});

let inputContraseñaRegistro = document.getElementById('contraseñaRegistro');
let expresionContraseña = /^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{8,16}$/;
let caracteres8 = /[a-zA-Z0-9]{8,16}/;
let caracteresMayuscula = /[A-Z]/;
let algunNumero = /[0-9]/;
let requisitosContraseña = document.getElementsByClassName('requisitos')[0];

inputContraseñaRegistro.addEventListener('focus', function() {
    requisitosContraseña.style.display = 'block';

    inputContraseñaRegistro.addEventListener('keyup', function() {
    if(caracteres8.test(inputContraseñaRegistro.value)) {
        requisitosContraseña.children[0].style.color = 'green';
        requisitosContraseña.children[0].children[0].src = 'img/iconos/tick.svg';
        requisitosContraseña.children[0].children[0].style.width = '15px';
    } else {
        requisitosContraseña.children[0].style.color = 'red';
        requisitosContraseña.children[0].children[0].src = 'img/iconos/error.svg';
        requisitosContraseña.children[0].children[0].style.width = '10px';
    }

    if(caracteresMayuscula.test(inputContraseñaRegistro.value)) {
        requisitosContraseña.children[1].style.color = 'green';
        requisitosContraseña.children[1].children[0].src = 'img/iconos/tick.svg';
        requisitosContraseña.children[1].children[0].style.width = '15px';
    } else {
        requisitosContraseña.children[1].style.color = 'red';
        requisitosContraseña.children[1].children[0].src = 'img/iconos/error.svg';
        requisitosContraseña.children[1].children[0].style.width = '10px';
    }

    if(algunNumero.test(inputContraseñaRegistro.value)) {
        requisitosContraseña.children[2].style.color = 'green';
        requisitosContraseña.children[2].children[0].src = 'img/iconos/tick.svg';
        requisitosContraseña.children[2].children[0].style.width = '15px';
    }else{
        requisitosContraseña.children[2].style.color = 'red';
        requisitosContraseña.children[2].children[0].src = 'img/iconos/error.svg';
        requisitosContraseña.children[2].children[0].style.width = '10px';
    }
});

});

inputContraseñaRegistro.addEventListener('blur', function() {
    requisitosContraseña.style.display = 'none';
});

inputContraseñaRegistro.addEventListener('keyup', function() {
    if(expresionContraseña.test(inputContraseñaRegistro.value)) {
        inputContraseñaRegistro.style.border = '2px solid green';
    } else {
        inputContraseñaRegistro.style.border = '2px solid red';
    }
});