<?php
session_start();

// Verificar si el usuario está autenticado
if (isset($_SESSION["username"])) {
    header("Location: dashboard.php");
    exit();
}
$username = $_SESSION["username"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tareas PHP</title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <nav class="navbar">
        <li>
            <img src="img/logo.png" alt="logo" style="height: 40px; width: 40px;">
        </li>
    </nav>
    <div class="login">
        <div class="card-login">
            <h1>Login</h1>
            <form class="formulario" id="loginForm">
                <label for="user">Usuario</label>
                <input type="text" id="username" name="username" required>
                <input class="login-btn" type="submit" value="Iniciar Sesión">
            </form>
        </div>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const username = document.getElementById('username').value; 
            fetch('api/CreateUser.php', {
                method: 'POST',
                body: JSON.stringify({User_Name:username})
                })
                .then(response => response.text())
                .then(data => {
                    alert("Login Successfull" + data); // Muestra el mensaje de respuesta del servidor
                    window.location.href = 'dashboard.php';
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    </script>
</body>
</html>
