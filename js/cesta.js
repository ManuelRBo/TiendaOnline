/**
 * @file cesta.js
 * @brief Archivo que contiene las funciones para añadir, eliminar y comprar productos.
 * @details Este archivo contiene las funciones necesarias para añadir, eliminar y comprar productos.
 * @version 1.0
 * @date 21-02-2024
 * @author Manuel Rodrigo Borriño
 */

// Funcion para añadir un producto a la cesta
function agregarProducto(id, cantidad = 1) {
  // Petición fetch para añadir un producto a la cesta
  fetch("http://localhost/Tienda%20Online%20de%20Libros/api/cesta.php", {
    method: "POST",
    body: JSON.stringify({ id: id, cantidad: cantidad }),
    headers: {
      "Content-Type": "application/json",
    },
  })
    .then((response) => response.json())
    .then((data) => {
      // Mensaje de confirmación o error
      const mensajeContainer = document.querySelector(".contenedor-header");
      const mensaje = document.createElement("p");

      if (data.status) {
        // Mensaje de confirmación
        mensaje.textContent = "Libro añadido";
        mensaje.classList.add("mensaje");
        cantidad = data.cantidad;
        document.querySelector(".cantidad").textContent = data.cantidad;
      } else {
        // Mensaje de error
        mensaje.textContent = "Error al añadir el libro";
        mensaje.classList.add("mensaje-error");
        cantidad = data.cantidad;
        document.querySelector(".cantidad").textContent = data.cantidad;
      }

      // Añadir el mensaje al contenedor
      mensajeContainer.appendChild(mensaje);

      // Eliminar el mensaje después de 2 segundos
      setTimeout(() => {
        mensaje.remove();
      }, 2000);
    })
    .catch((error) => {
      console.log(error);
    });
}

// Funcion para eliminar una unidad de un producto de la cesta
function eliminarProducto(id) {
  // Petición fetch para eliminar una unidad de un producto de la cesta
  fetch(
    "http://localhost/Tienda%20Online%20de%20Libros/api/eliminarAnadirProducto.php",
    {
      method: "POST",
      body: JSON.stringify({ id: id, accion: "eliminar" }),
      headers: {
        "Content-Type": "application/json",
      },
    }
  )
    .then((response) => response.json())
    .then((data) => {
      if (data.status) {
        // Si es true, se elimina el producto de la cesta
        if (data.cantidad === null || data.cantidad === 0) {
          // Si la cantidad es null o 0, se elimina una unidad del producto de la cesta
          document.getElementById("producto-" + id).remove();
          document.querySelector(".cantidad").innerHTML =
            document.querySelector(".cantidad").innerHTML - 1;
          document.getElementById("subtotal").innerHTML =
            (
              parseFloat(document.getElementById("subtotal").innerHTML) -
              parseFloat(data.precio)
            ).toFixed(2) + "€";
          document.getElementById("total").innerHTML =
            (
              parseFloat(document.getElementById("total").innerHTML) -
              parseFloat(data.precio)
            ).toFixed(2) + "€";
          if (document.getElementsByClassName("cantidadLibro").length === 0) {
            // Si no hay productos en la cesta, se muestra un mensaje
            document.querySelector(".productos").innerHTML =
              "<p class='vacia'>La cesta está vacía</p>";
          }
        } else {
          // Si la cantidad no es null o 0, se actualiza la cantidad del producto
          document
            .getElementById("producto-" + id)
            .querySelector(".cantidadLibro").innerHTML = data.cantidad;
          document.querySelector(".cantidad").innerHTML =
            parseInt(document.querySelector(".cantidad").innerHTML) - 1;
          document.getElementById("subtotal").innerHTML =
            (
              parseFloat(document.getElementById("subtotal").innerHTML) -
              parseFloat(data.precio)
            ).toFixed(2) + "€";
          document.getElementById("total").innerHTML =
            (
              parseFloat(document.getElementById("total").innerHTML) -
              parseFloat(data.precio)
            ).toFixed(2) + "€";
        }

        if (
          !document
            .getElementById("producto-" + id)
            .querySelector(".cantidad")
            .querySelector(".añadir")
        ) {
          // Si la cantidad del producto es igual al stock, se elimina el botón de añadir
          document
            .getElementById("producto-" + id)
            .querySelector(".cantidad")
            .querySelector(".numeroCantidad").innerHTML +=
            '<p class="añadir" data-libro="' + id + '">+</p>';
        }
      }
    })
    .catch((error) => {
      console.log(error);
    });
}

// Funcion para añadir una unidad de un producto a la cesta
function anadirProducto(id) {
  // Petición fetch para añadir una unidad de un producto a la cesta
  fetch(
    "http://localhost/Tienda%20Online%20de%20Libros/api/eliminarAnadirProducto.php",
    {
      method: "POST",
      body: JSON.stringify({ id: id, accion: "añadir" }),
      headers: {
        "Content-Type": "application/json",
      },
    }
  )
    .then((response) => response.json())
    .then((data) => {
      console.log(data);
      if (data.status) {
        // Si es true, se añade una unidad del producto a la cesta
        document
          .getElementById("producto-" + id)
          .querySelector(".cantidadLibro").innerHTML = data.cantidad;
        document.querySelector(".cantidad").innerHTML =
          parseInt(document.querySelector(".cantidad").innerHTML) + 1;
        document.getElementById("subtotal").innerHTML =
          (
            parseFloat(document.getElementById("subtotal").innerHTML) +
            parseFloat(data.precio)
          ).toFixed(2) + "€";
        document.getElementById("total").innerHTML =
          (
            parseFloat(document.getElementById("total").innerHTML) +
            parseFloat(data.precio)
          ).toFixed(2) + "€";

        if (data.cantidad === data.stock) {
          // Si la cantidad del producto es igual al stock, se elimina el botón de añadir
          document
            .getElementById("producto-" + id)
            .querySelector(".añadir")
            .remove();
        }
      }
    })
    .catch((error) => {
      console.log(error);
    });
}

// Si pulsamos el botón de añañir al carrito, se añade el producto a la cesta
document.addEventListener("click", function (event) {
  if (event.target && event.target.classList.contains("comprar")) {
    let id = event.target.getAttribute("data-libro");
    agregarProducto(id);
  }
});

// Si pulsamos el botón de comprar de la ficha técnica, se añade el producto a la cesta
document.addEventListener("click", function (event) {
  if (event.target && event.target.classList.contains("fechaTecnica-comprar")) {
    let id = event.target.getAttribute("data-libro");
    let cantidad = document.getElementById("cantidad").value;
    agregarProducto(id, cantidad);
  }
});

// Si pulsamos el botón de eliminar de la cesta, se elimina una unidad del producto de la cesta
document.addEventListener("click", function (event) {
  if (event.target && event.target.classList.contains("eliminar")) {
    let id = event.target.getAttribute("data-libro");
    eliminarProducto(id);
  }
});

// Si pulsamos el botón de añadir de la cesta, se añade una unidad del producto a la cesta
document.addEventListener("click", function (event) {
  if (event.target && event.target.classList.contains("añadir")) {
    let id = event.target.getAttribute("data-libro");
    anadirProducto(id);
  }
});

// Si pulsamos el botón comprar de la cesta, se realiza el pedido
document.addEventListener("click", function (event) {
  if (event.target && event.target.id === "pedido") {
    console.log(document.querySelector(".productos").innerHTML);
    if (document.querySelector(".productos").querySelector(".vacia")) {
      // Si la cesta está vacía, se muestra un mensaje de error
      document.querySelector(".contenedor-header").innerHTML +=
        "<p class='mensaje-error'>La cesta está vacía</p>";
      // Eliminar el mensaje después de 2 segundos
      setTimeout(() => {
        document.querySelector(".mensaje-error").remove();
      }, 2000);
    } else {
      // Si la cesta no está vacía, se realiza el pedido
      fetch(
        "http://localhost/Tienda%20Online%20de%20Libros/api/realizarPedido.php",
        {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
        }
      )
        .then((response) => response.json())
        .then((data) => {
          if (data.error) {
            if (data.id === 2) {
              // Si hay un error, se muestra un mensaje de error porque tiene que haber un usuario logueado
              document.querySelector(".totalCompra").innerHTML +=
                "<p class='error'>" + data.mensaje + "</p>";

              // Eliminar el mensaje después de 2 segundos
              setTimeout(() => {
                document.querySelector(".error").remove();
              }, 2000);
            } else if (data.id === 1) {
              // Si hay un error, se muestra un mensaje de error porque se ha producido un error al realizar el pedido
              document.querySelector(".contenedor-header").innerHTML +=
                "<p class='error'>" + data.mensaje + "</p>";

              // Eliminar el mensaje después de 2 segundos
              setTimeout(() => {
                document.querySelector(".error").remove();
              }, 2000);
            }
          } else {
            // Si no hay errores, se muestra un mensaje de confirmación y se vacía la cesta
            document.querySelector(".productos").innerHTML =
              "<p class='vacia'>La cesta está vacía</p>";
            document.querySelector(".cantidad").innerHTML = 0;
            document.getElementById("subtotal").innerHTML = "0.00€";
            document.getElementById("total").innerHTML = "0.00€";
            document.querySelector(".contenedor-header").innerHTML +=
              "<p class='mensaje'>" + data.mensaje + "</p>";

            // Eliminar el mensaje después de 2 segundos
            setTimeout(() => {
              document.querySelector(".mensaje").remove();
            }, 2000);
          }
        })
        .catch((error) => {
          console.log(error);
        });
    }
  }
});
