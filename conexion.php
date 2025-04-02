<?php
$conex = mysqli_connect("localhost", "root", "", "registro");

// Verificar conexión
if (!$conex) {
    die("Conexión fallida: " . mysqli_connect_error());
}
?>