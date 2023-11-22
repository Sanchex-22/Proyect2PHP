<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json_data = json_decode(file_get_contents("php://input"), true);
    var_dump($json_data); // Verifica lo que estás recibiendo
    // Resto del código...
} else {
    echo "Solo se permiten solicitudes POST";
}
?>
