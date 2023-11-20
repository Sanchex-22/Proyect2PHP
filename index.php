<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tareas PHP</title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="css/login.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
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
            <form class="formulario" action="" method="post">
                <label for="user">Usuario</label>
                <input type="text" id="username" name="username" required>
                <input class="login-btn" type="submit" value="Iniciar Sesión">
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.formulario').submit(function(event) {
                event.preventDefault();
                
                const username = $('#username').val();
                
                $.ajax({
                    type: 'POST',
                    url: 'api/createUser.php',
                    data: JSON.stringify({ User_Name: username }),
                    contentType: 'application/json',
                    success: function(data) {
                        alert('Usuario logueado ' + data);

                        // Llama a una función PHP para establecer la sesión
                        $.post('set_session.php', { User_Name: username }, function(response) {
                            console.log(response);
                        });

                        // Redirige al usuario a la página de dashboard
                        window.location.href = 'dashboard.php';
                    },
                    error: function(error) {
                        console.error('Error en la solicitud:', error);
                        alert('Ocurrió un error al procesar la solicitud. Por favor, inténtalo de nuevo.');
                    }
                });
            });
        });
    </script>
</body>
</html>
