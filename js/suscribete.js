let formulario = document.getElementById('suscribete')

formulario.addEventListener('submit', function(e){
    e.preventDefault()
    let email = new FormData(formulario).get('email')
    let expresion = /\w+@\w+\.[a-z]{2,4}/
    if(expresion.test(email)){
        formulario.reset();
        document.getElementById('mensaje').style.display = 'block'
        document.getElementById('mensaje').innerHTML = 'Gracias por suscribirte'
        document.getElementById('mensaje').style.color = 'green'
        formulario.email.style.border = '1px solid green'
    }else{
        document.getElementById('mensaje').style.display = 'block'
        document.getElementById('mensaje').innerHTML = 'Email no válido'
        document.getElementById('mensaje').style.color = 'red'
        formulario.email.style.border = '1px solid red'
    }

    setTimeout(() =>{
        document.getElementById('mensaje').style.display = 'none'
        document.getElementById('mensaje').innerHTML = ''
        formulario.email.style.border = '1px solid #C37338'
    }, 3000)
})