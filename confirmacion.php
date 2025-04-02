<?php
session_start();
include("conexion.php");

// Verificar si hay datos en la sesión
if (!isset($_SESSION['registro_temp'])) {
    header("Location: index.php");
    exit();
}

// Obtener los datos de la sesión
$registro = $_SESSION['registro_temp'];

if (isset($_POST['confirmar'])) {
    if (
        !empty($registro['nombre']) &&
        !empty($registro['apellidos']) &&
        !empty($registro['fecha_nacimiento']) &&
        !empty($registro['curp']) &&
        !empty($registro['telefono']) &&
        !empty($registro['correo']) &&
        !empty($registro['contrasena']) &&
        !empty($registro['estudios'])
    ) {
        $nombre = trim($registro['nombre']);
        $apellidos = trim($registro['apellidos']);
        $fecha_nacimiento = trim($registro['fecha_nacimiento']);
        $curp = trim($registro['curp']);
        $telefono = trim($registro['telefono']);
        $correo = trim($registro['correo']);
        $contrasena = trim($registro['contrasena']);
        $estudios = trim($registro['estudios']);
        $fecha_registro = date("Y-m-d"); // Formato adecuado para MySQL

        // Verificar si el CURP ya existe
        $check_curp = "SELECT curp FROM datos WHERE curp = '$curp'";
        $result = mysqli_query($conex, $check_curp);

        if (mysqli_num_rows($result) > 0) {
            $_SESSION['error'] = "El CURP ya está registrado.";
            header("Location: confirmacion.php");
            exit();
        } else {
            // Insertar el nuevo registro
            $consulta = "INSERT INTO datos (nombre, apellidos, fecha_nacimiento, curp, telefono, correo, contrasena, estudios, fecha_registro)
                         VALUES ('$nombre', '$apellidos', '$fecha_nacimiento', '$curp', '$telefono', '$correo', '$contrasena', '$estudios', '$fecha_registro')";

            if (mysqli_query($conex, $consulta)) {
                $_SESSION['success'] = "Tu registro se ha completado con éxito.";
                unset($_SESSION['registro_temp']); // Limpiar los datos temporales
                header("Location: index.php");
                exit();
            } else {
                $_SESSION['error'] = "Error al registrar. Intenta de nuevo.";
                header("Location: confirmacion.php");
                exit();
            }
        }
    } else {
        $_SESSION['error'] = "Llena todos los campos.";
        header("Location: confirmacion.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar Registro</title>
    <link rel="stylesheet" href="confirmacion.css">
</head>

<body>
    <div class="confirmacion-container">
        <form action="confirmacion.php" method="post">
            <h2>Confirma tus Datos</h2>
            <?php foreach ($registro as $campo => $valor): ?>
                <p><strong><?php echo ucfirst($campo === 'contrasena' ? 'Contraseña' : $campo); ?>:</strong>
                    <?php echo ucfirst(htmlspecialchars($valor)); ?></p>
                <input type="hidden" name="<?php echo htmlspecialchars($campo); ?>"
                    value="<?php echo htmlspecialchars($valor); ?>">
            <?php endforeach; ?>
            <button type="submit" class="btn" name="confirmar">Confirmar y Registrar</button>
        </form>
        <form action="reingresar.php" method="post">
            <button type="submit" class="btn modificar-btn">Reingresar Datos</button>
        </form>
    </div>
</body>

</html>