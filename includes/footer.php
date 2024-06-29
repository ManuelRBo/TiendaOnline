<footer>
    <div class="contenedor-footer">
        <div class="suscribete">
            <h3>Suscribete</h3>
            <p>Introduce tu email para recibir las novedades de los ultimo libros</p>
            <form id="suscribete">
                <input type="email" placeholder="Correo electrónico" name="email">
                <input type="submit" value="Enviar">
                <p id="mensaje"></p>
            </form>
            <script src="./js/suscribete.js"></script>
        </div>
        <div class="logo-contacto-redes">
            <div class="logo-footer">
                <img src="./img/logo/logo-b&n.svg" alt="Logo de la tienda" width="90px">
                <a href="#">Politica de Privacidad</a>
                <a href="#">Politica de Cookies</a>
                <p>Copyright &#169; 2024</p>
            </div>
            <div class="contacto">
                <h4>Contacto</h4>
                <div class="telefono">
                    <img src="./img/iconos/whatsapp.svg" alt="Icono de whatsapp" width="30px">
                    <p>+34 678323675</p>
                </div>
                <div class="email">
                    <img src="./img/iconos/email.svg" alt="Icono de email" width="30px">
                    <p>help@books.com</p>
                </div>
            </div>
            <div class="navegacion">
                <a href="<?php echo isset($_SESSION['usuario']) ? "#" : "autenticar.php"?>">Iniciar Sesion</a>
                <a href="cesta.html">Carrito</a>
            </div>
            <div class="redes">
                <a href="#">
                    <img src="./img/iconos/x.svg" alt="Icono de X" width="35px">
                </a>
                <a href="#">
                    <img src="./img/iconos/facebook.svg" alt="Icono de Facebook" width="35px">
                </a>
                <a href="#">
                    <img src="./img/iconos/whatsapp.svg" alt="Icono de Whatsapp" width="35px">
                </a>
                <a href="#">
                    <img src="./img/iconos/instagram.svg" alt="Icono de instagram" width="35px">
                </a>
            </div>
        </div>
    </div>
</footer>
<script src="./js/cesta.js"></script>