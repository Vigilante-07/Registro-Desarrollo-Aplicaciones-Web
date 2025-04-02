<?php
session_start();
include("conexion.php");

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['correo'])) {
    header("Location: index.php");
    exit();
}

// Consulta para obtener los datos de los usuarios
$sql = "SELECT nombre, apellidos, fecha_nacimiento, curp, telefono, correo, estudios FROM datos";
$result = $conex->query($sql);

// Consulta para obtener los datos del usuario que ha iniciado sesión
$correo = $_SESSION['correo'];
$sql_user = "SELECT nombre, apellidos, fecha_nacimiento, curp, telefono, correo, estudios FROM datos WHERE correo = ?";
$stmt_user = $conex->prepare($sql_user);
$stmt_user->bind_param("s", $correo);
$stmt_user->execute();
$result_user = $stmt_user->get_result();
$user = $result_user->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Usuarios</title>
    <link rel="stylesheet" href="panel.css">
</head>

<body>
    <div class="container">
        <h1>Panel de Usuarios</h1>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Fecha de Nacimiento</th>
                    <th>CURP</th>
                    <th>Teléfono</th>
                    <th>Correo Electrónico</th>
                    <th>Estudios</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['nombre']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['apellidos']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['fecha_nacimiento']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['curp']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['telefono']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['correo']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['estudios']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No h  ay usuarios registrados.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <h2>Modificar Datos</h2>
        <form id="modificar-form" method="post" action="modificar.php">
            <div class="input-wrapper">
                <input type="text" name="nombre" value="<?php echo htmlspecialchars($user['nombre']); ?>" required>
                <img class="input-icon" src="images/names.svg" alt="Nombre">
            </div>
            <div class="input-wrapper">
                <input type="text" name="apellidos" value="<?php echo htmlspecialchars($user['apellidos']); ?>"
                    required>
                <img class="input-icon" src="images/names.svg" alt="Apellido">
            </div>
            <div class="input-wrapper">
                <input type="date" name="fecha_nacimiento"
                    value="<?php echo htmlspecialchars($user['fecha_nacimiento']); ?>" required>
            </div>
            <div class="input-wrapper">
                <input type="text" name="curp" value="<?php echo htmlspecialchars($user['curp']); ?>" required>
                <img class="input-icon" src="images/id.svg" alt="CURP">
            </div>
            <div class="input-wrapper">
                <input type="tel" name="telefono" value="<?php echo htmlspecialchars($user['telefono']); ?>" required>
                <img class="input-icon" src="images/number.svg" alt="Teléfono">
            </div>
            <div class="input-wrapper">
                <input type="email" name="correo" value="<?php echo htmlspecialchars($user['correo']); ?>" required>
                <img class="input-icon" src="images/mail.svg" alt="Correo">
            </div>
            <div class="input-wrapper">
                <input type="password" id="contrasena" name="contrasena" placeholder="Nueva Contraseña">
                <img class="input-icon" src="images/password.svg" alt="Contraseña">
            </div>
            <div class="button-container">
                <input class="btn" type="submit" name="modificar" value="Modificar">
            </div>
        </form>
        <div class="button-container">
            <form method="post" action="logout.php">
                <button class="logout-btn" type="submit">Logout</button>
            </form>
        </div>
    </div>
</body>

</html>

<?php
$conex->close();
?>