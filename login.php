<?php
include("conexion.php");
session_start(); // Iniciar sesión para manejar mensajes de éxito/error

// Manejar el inicio de sesión
if (isset($_POST['login'])) {
    if (!empty($_POST['correo']) && !empty($_POST['contrasena'])) {
        $correo = trim($_POST['correo']);
        $contrasena = trim($_POST['contrasena']);

        // Consulta SQL para verificar credenciales
        $sql = "SELECT * FROM datos WHERE correo='$correo' AND contrasena='$contrasena'";
        $result = $conex->query($sql);

        if ($result->num_rows > 0) {
            // Credenciales correctas
            $_SESSION['correo'] = $correo; // Iniciar sesión
            header("Location: panel.php");
            exit();
        } else {
            // Credenciales incorrectas
            $_SESSION['error'] = "Correo o contraseña incorrectos.";
            header("Location: index.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "Llena todos los campos.";
        header("Location: index.php");
        exit();
    }
}
$conex->close();
?>