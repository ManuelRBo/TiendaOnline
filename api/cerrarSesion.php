<?php
session_start();

// Destruir la sesión
session_destroy();

// Redirigir al usuario a la última URL visitada
header('Location: ' . $_SESSION['ultima_url']);