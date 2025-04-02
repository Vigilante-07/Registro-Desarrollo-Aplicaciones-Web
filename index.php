<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            // Solo permitir letras en los campos de texto
            $('input[name="nombre"], input[name="apellidos"]').on('input', function () {
                this.value = this.value.replace(/[^a-zA-Z\s]/g, '');
            });

            // Solo permitir números y el símbolo "-" en el campo de teléfono
            $('input[name="telefono"]').on('input', function () {
                this.value = this.value.replace(/[^0-9\-]/g, '');
            });

            // Validar el formulario al enviar
            $('form').on('submit', function (event) {
                let valid = true;

                // Validar nombre y apellidos
                $('input[name="nombre"], input[name="apellidos"]').each(function () {
                    if (this.value.match(/[^a-zA-Z\s]/)) {
                        valid = false;
                        $(this).css('border', '2px solid red');
                    } else {
                        $(this).css('border', '');
                    }
                });

                // Validar teléfono
                if ($('input[name="telefono"]').val().match(/[^0-9\-]/)) {
                    valid = false;
                    $('input[name="telefono"]').css('border', '2px solid red');
                } else {
                    $('input[name="telefono"]').css('border', '');
                }

                if (!valid) {
                    event.preventDefault(); // Prevenir el envío del formulario si hay errores
                }
            });
        });
    </script>
</head>

<body>
    <!-- Mostrar mensajes de éxito o error -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="success"><?php echo $_SESSION['success']; ?></div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="error"><?php echo $_SESSION['error']; ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <form action="registrar.php" method="post">
        <h2>DATOS</h2>
        <div class="input-wrapper">
            <input type="text" name="nombre" placeholder="Nombre(s)" required>
            <img class="input-icon" src="images/names.svg" alt="Nombre">
        </div>
        <div class="input-wrapper">
            <input type="text" name="apellidos" placeholder="Apellido(s)" required>
            <img class="input-icon" src="images/names.svg" alt="Apellido">
        </div>
        <div class="input-wrapper">
            <input type="date" name="fecha_nacimiento" placeholder="Escoger fecha de nacimiento" required>
            <img class="input-icon" src="images/date.svg" alt="Fecha de nacimiento">
        </div>
        <div class="input-wrapper">
            <input type="text" name="curp" placeholder="CURP" required>
            <img class="input-icon" src="images/id.svg" alt="CURP">
        </div>
        <div class="input-wrapper">
            <input type="tel" name="telefono" placeholder="Número de celular" required>
            <img class="input-icon" src="images/number.svg" alt="Teléfono">
        </div>
        <div class="input-wrapper">
            <input type="email" name="correo" placeholder="Correo Electrónico" required>
            <img class="input-icon" src="images/mail.svg" alt="Correo">
        </div>
        <div class="input-wrapper">
            <input type="password" name="contrasena" placeholder="Contraseña" required>
            <img class="input-icon" src="images/password.svg" alt="Contraseña">
        </div>
        <div class="input-wrapper">
            <select name="estudios" required>
                <option value="" disabled selected>Nivel de Estudios</option>
                <option value="primaria">Primaria</option>
                <option value="secundaria">Secundaria</option>
                <option value="preparatoria">Preparatoria</option>
                <option value="universidad">Universidad</option>
                <option value="posgrado">Posgrado</option>
            </select>
            <img class="input-icon" src="images/education.svg" alt="Estudios">
        </div>
        <!-- Contenedor para botones -->
        <div class="button-container">
            <input class="btn" type="submit" name="register" value="Enviar">
        </div>
    </form>

    <form action="login.php" method="post">
        <h2>Iniciar Sesión</h2>
        <div class="input-wrapper">
            <input type="email" name="correo" placeholder="Correo Electrónico" required>
            <img class="input-icon" src="images/mail.svg" alt="Correo">
        </div>
        <div class="input-wrapper">
            <input type="password" name="contrasena" placeholder="Contraseña" required>
            <img class="input-icon" src="images/password.svg" alt="Contraseña">
        </div>
        <input class="btn" type="submit" name="login" value="Entrar">
    </form>
</body>

</html>