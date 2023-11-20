<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["username"])) {
        $_SESSION["username"] = $_POST["username"];
        echo "Sesión establecida correctamente para " . $_SESSION["username"];
    } else {
        http_response_code(400);
        echo "Error: No se proporcionó un nombre de usuario";
    }
} else {
    http_response_code(400);
    echo "Error: Método de solicitud incorrecto";
}
?>
