function agregarProducto(id, cantidad = 1){
    fetch("http://localhost/Tienda%20Online%20de%20Libros/api/cesta.php", {
        method: 'POST',
        body: JSON.stringify({id: id, cantidad: cantidad}),
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        const mensajeContainer = document.querySelector(".contenedor-header");
        const mensaje = document.createElement("p");

        if(data.status){
            mensaje.textContent = "Libro añadido";
            mensaje.classList.add("mensaje");
            cantidad = data.cantidad;
            document.querySelector(".cantidad").textContent = data.cantidad;
        } else {
            mensaje.textContent = "Error al añadir el libro";
            mensaje.classList.add("mensaje-error");
            cantidad = data.cantidad;
            document.querySelector(".cantidad").textContent = data.cantidad;
        }

        mensajeContainer.appendChild(mensaje);

        setTimeout(() => {
            mensaje.remove();
        }, 2000);
    })
    .catch(error => {
        console.log(error);
    })
}

function eliminarProducto(id){
    fetch("http://localhost/Tienda%20Online%20de%20Libros/api/eliminarAnadirProducto.php", {
        method: 'POST',
        body: JSON.stringify({id: id, accion: 'eliminar'}),
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
        if(data.status){
            if(data.cantidad === null || data.cantidad === 0){
                document.getElementById("producto-" + id).remove();
                document.querySelector(".cantidad").innerHTML = (document.querySelector(".cantidad").innerHTML) - 1;
                document.getElementById("subtotal").innerHTML = (parseFloat(document.getElementById("subtotal").innerHTML) - parseFloat(data.precio)).toFixed(2) +"€";
                document.getElementById("total").innerHTML = (parseFloat(document.getElementById("total").innerHTML) - parseFloat(data.precio)).toFixed(2) +"€";
                if(document.getElementsByClassName("cantidadLibro").length === 0){
                    document.querySelector(".productos").innerHTML = "<p class='vacia'>La cesta está vacía</p>";
                }
            } else{
                document.getElementById("producto-"+id).querySelector(".cantidadLibro").innerHTML = data.cantidad;
                document.querySelector(".cantidad").innerHTML = parseInt(document.querySelector(".cantidad").innerHTML) - 1;
                document.getElementById("subtotal").innerHTML = (parseFloat(document.getElementById("subtotal").innerHTML) - parseFloat(data.precio)).toFixed(2) +"€";
                document.getElementById("total").innerHTML = (parseFloat(document.getElementById("total").innerHTML) - parseFloat(data.precio)).toFixed(2) +"€";
            } 
            
            if(!document.getElementById("producto-" + id).querySelector(".cantidad").querySelector(".añadir")){
                document.getElementById("producto-" + id).querySelector(".cantidad").querySelector(".numeroCantidad").innerHTML += '<p class="añadir" data-libro="'+ id +'">+</p>';
            }
        }
    })
    .catch(error => {
        console.log(error);
    })
}

function anadirProducto(id){
    fetch("http://localhost/Tienda%20Online%20de%20Libros/api/eliminarAnadirProducto.php", {
        method: 'POST',
        body: JSON.stringify({id: id, accion: 'añadir'}),
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
        if (data.status) {
            document.getElementById("producto-" + id).querySelector(".cantidadLibro").innerHTML = data.cantidad;
            document.querySelector(".cantidad").innerHTML = parseInt(document.querySelector(".cantidad").innerHTML) + 1;
            document.getElementById("subtotal").innerHTML = (parseFloat(document.getElementById("subtotal").innerHTML) + parseFloat(data.precio)).toFixed(2) + "€";
            document.getElementById("total").innerHTML = (parseFloat(document.getElementById("total").innerHTML) + parseFloat(data.precio)).toFixed(2) + "€";

            if(data.cantidad === data.stock){
                document.getElementById("producto-" + id).querySelector(".añadir").remove();
        }
    }
        
    })
    .catch(error => {
        console.log(error);
    })
}



document.addEventListener("click", function(event){
    if (event.target && event.target.classList.contains("comprar")) {
        let id = event.target.getAttribute("data-libro");
        agregarProducto(id);
    }
})

document.addEventListener("click", function(event){
    if (event.target && event.target.classList.contains("fechaTecnica-comprar")) {
        let id = event.target.getAttribute("data-libro");
        let cantidad = document.getElementById("cantidad").value;
        agregarProducto(id, cantidad);
    }
})

document.addEventListener("click", function(event){
    if (event.target && event.target.classList.contains("eliminar")) {
        let id = event.target.getAttribute("data-libro");
        eliminarProducto(id);
    }
})

document.addEventListener("click", function(event){
    if (event.target && event.target.classList.contains("añadir")) {
        let id = event.target.getAttribute("data-libro");
        anadirProducto(id);
    }
})

document.addEventListener("click", function(event){
    if (event.target && event.target.id === "pedido") {
        console.log(document.querySelector(".productos").innerHTML);
        if(document.querySelector(".productos").querySelector(".vacia")){
            document.querySelector(".contenedor-header").innerHTML += "<p class='mensaje-error'>La cesta está vacía</p>";
            setTimeout(() => {
                document.querySelector(".mensaje-error").remove();
            }, 2000);
        }else{
            fetch("http://localhost/Tienda%20Online%20de%20Libros/api/realizarPedido.php", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if(data.error){
                    if(data.id === 2){
                    document.querySelector(".totalCompra").innerHTML += "<p class='error'>"+ data.mensaje +"</p>";
                    setTimeout(() => {
                        document.querySelector(".error").remove();
                    }, 2000);
                }else if(data.id === 1){
                    document.querySelector(".contenedor-header").innerHTML += "<p class='error'>"+ data.mensaje +"</p>";
                    setTimeout(() => {
                        document.querySelector(".error").remove();
                    }, 2000);
                }
                }else{
                    document.querySelector(".productos").innerHTML = "<p class='vacia'>La cesta está vacía</p>";
                    document.querySelector(".cantidad").innerHTML = 0;
                    document.getElementById("subtotal").innerHTML = "0.00€";
                    document.getElementById("total").innerHTML = "0.00€";
                    document.querySelector(".contenedor-header").innerHTML += "<p class='mensaje'>"+ data.mensaje +"</p>";
                    setTimeout(() => {
                        document.querySelector(".mensaje").remove();
                    }, 2000);
                }
            })
            .catch(error => {
                console.log(error);
            })
        } 
    }
})
