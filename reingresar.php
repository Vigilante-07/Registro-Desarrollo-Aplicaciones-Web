<?php
session_start();
unset($_SESSION['registro_temp']); // Limpiar los datos temporales
header("Location: index.php");
exit();
?>