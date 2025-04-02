<?php
include("conexion.php");
session_start(); // Iniciar sesión para manejar mensajes de éxito/error

// Manejar el registro de usuarios
if (isset($_POST['register'])) {
    if (
        !empty($_POST['nombre']) &&
        !empty($_POST['apellidos']) &&
        !empty($_POST['fecha_nacimiento']) &&
        !empty($_POST['curp']) &&
        !empty($_POST['telefono']) &&
        !empty($_POST['correo']) &&
        !empty($_POST['contrasena']) &&
        !empty($_POST['estudios'])
    ) {
        $nombre = trim($_POST['nombre']);
        $apellidos = trim($_POST['apellidos']);
        $fecha_nacimiento = trim($_POST['fecha_nacimiento']);
        $curp = trim($_POST['curp']);
        $telefono = trim($_POST['telefono']);
        $correo = trim($_POST['correo']);
        $contrasena = trim($_POST['contrasena']);
        $estudios = trim($_POST['estudios']);

        // Almacenar los datos en la sesión temporalmente
        $_SESSION['registro_temp'] = [
            'nombre' => $nombre,
            'apellidos' => $apellidos,
            'fecha_nacimiento' => $fecha_nacimiento,
            'curp' => $curp,
            'telefono' => $telefono,
            'correo' => $correo,
            'contrasena' => $contrasena,
            'estudios' => $estudios
        ];

        // Redirigir a la página de confirmación
        header("Location: confirmacion.php");
        exit();
    } else {
        $_SESSION['error'] = "Llena todos los campos.";
        header("Location: index.php");
        exit();
    }
}

// Manejar el inicio de sesión
if (isset($_POST['login'])) {
    if (!empty($_POST['correo']) && !empty($_POST['contrasena'])) {
        $correo = trim($_POST['correo']);
        $contrasena = trim($_POST['contrasena']);

        // Consulta SQL para verificar credenciales
        $sql = "SELECT * FROM usuarios WHERE correo='$correo' AND contrasena='$contrasena'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Credenciales correctas
            $_SESSION['correo'] = $correo; // Iniciar sesión
            echo 'success';
        } else {
            // Credenciales incorrectas
            echo 'error';
        }
    } else {
        echo 'error'; // Campos vacíos
    }
}

$conn->close();
?>