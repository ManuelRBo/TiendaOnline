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

let inputContraseñaRegistro = document.getElementById('contraseñaRegistro');
let expresionContraseña = /^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{8,16}$/;
let requisitosContraseña = document.getElementsByClassName('requisitos')[0];

inputContraseñaRegistro.addEventListener('focus', function() {
    requisitosContraseña.style.display = 'block';
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