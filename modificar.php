<?php
session_start();
include("conexion.php");

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['correo'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $curp = $_POST['curp'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    // Actualizar los datos del usuario
    $sql_update = "UPDATE datos SET nombre = ?, apellidos = ?, fecha_nacimiento = ?, curp = ?, telefono = ?, correo = ?";

    // Si se proporciona una nueva contraseña, actualizarla también
    if (!empty($contrasena)) {
        $sql_update .= ", contrasena = ?";
    }

    $sql_update .= " WHERE correo = ?";
    $stmt_update = $conex->prepare($sql_update);

    if (!empty($contrasena)) {
        $stmt_update->bind_param("ssssssss", $nombre, $apellidos, $fecha_nacimiento, $curp, $telefono, $correo, $contrasena, $_SESSION['correo']);
    } else {
        $stmt_update->bind_param("sssssss", $nombre, $apellidos, $fecha_nacimiento, $curp, $telefono, $correo, $_SESSION['correo']);
    }

    if ($stmt_update->execute()) {
        echo "Datos actualizados correctamente.";
    } else {
        echo "Error al actualizar los datos: " . $stmt_update->error;
    }

    $stmt_update->close();
    $conex->close();

    // Recargar la página
    header("Location: panel.php");
    exit();
}
?>