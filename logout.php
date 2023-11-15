<?php
session_start();
session_unset(); // Deshace todas las variables de sesión
session_destroy(); // Destruye la sesión

// Redirige a la página de inicio o a donde desees después de cerrar sesión
header("Location: index.php"); // Cambia "index.php" por la página a la que quieras redirigir
exit();
?>
