<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION["username"])) {
    header("Location: index.php");
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
    <link rel="stylesheet" href="css/report.css">
    <link rel="stylesheet" href="index.css">
</head>
<body>

    <Nav class="navbar">
        <ul class="nav-izq">
            <li><img src="img/logo.png" alt="logo" style="height: 40px; width: 40px;"></li>
            <li><a href="dashboard.php">Home</a></li>
            <li><a href="report.php">Report</a></li>
        </ul>
        <ul class="nav-der">
            <li><?php echo $_SESSION["username"]; ?></li>
            <li>
            <form action="logout.php" method="post">
                <button type="submit" value="Logout" class="btn-logout">Logout</button>
            </form>
            </li>
        </ul>
    </Nav>
    <div class="dashboard">
        <h1>Tareas</h1>
        <button class="create-btn" id="redireccionarBtn">New Task</button>
        <table>
            <tr>
                <th>#</th>
                <th>title</th>
                <th>description</th>
                <th>status</th>
                <th>fecha de compromiso</th>
                <th>Categoria</th>
                <th>Responsable</th>
                <th>etiqueta</th>
                <th>option</th>
            </tr>
            <!--Esto seria lo que hay que mapear-->
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Asegúrate de que el elemento 'eliminate' exista
                    const eliminateForm = document.getElementById('eliminate');

                    if (eliminateForm) {
                        eliminateForm.addEventListener('submit', function(event) {
                            event.preventDefault();
                            const cod = document.getElementById('cod').value;
                            console.log(cod);
                            const formData = {
                                cod: cod,
                            };

                            fetch('api/delete.php', {
                                method: 'POST',
                                body: JSON.stringify(formData),
                            })
                            .then(response => response.text())
                            .then(data => {
                                alert("Tarea eliminada exitosamente: " + data);
                            })
                            .catch(error => {
                                console.error('Error:', error);
                            });
                        });
                    } else {
                        console.error("Elemento 'eliminate' no encontrado");
                    }
                });
            </script>
            <?php
            // URL de la API
            $api_url = "http://localhost/Proyect2_DVII/api/getAll.php";

            // Configurar el contexto de transmisión
            $context = stream_context_create([
                'http' => [
                    'method' => 'GET',
                    // Puedes agregar encabezados u otras configuraciones según sea necesario
                    'header' => 'Content-Type: application/json',
                ],
            ]);

            // Realizar la solicitud GET a la API
            $response = file_get_contents($api_url, false, $context);

            // Verificar si la solicitud fue exitosa
            if ($response === FALSE) {
                // Manejar el error, por ejemplo:
                die('Error al realizar la solicitud GET');
            }

            // Procesar la respuesta (puede ser un JSON en este caso)
            $json_response = json_decode($response, true);
            $tareas = $json_response['tareas'];
            // echo '<pre>';
            // print_r($tareas);
            // echo '</pre>';
            foreach ($tareas as $tarea) : ?>
                
                <tr>
                    <td><?php echo $tarea['cod']; ?></td>
                    <td><?php echo $tarea['Titulo']; ?></td>
                    <td><?php echo $tarea['Descripcion']; ?></td>
                    <td><?php echo $tarea['Estado']; ?></td>
                    <td><?php echo $tarea['Fecha_Compromiso']; ?></td>
                    <td><?php echo $tarea['Tipo_']; ?></td>
                    <td><?php echo $tarea['Responsable']; ?></td>
                    <td><?php echo $tarea['Etiqueta']; ?></td>
                    <td>
                    <!-- btn Editar -->
                    <a href="edit_task.php?id=<?php echo $tarea['cod']; ?>" class="edit-btn">Editar</a>
                    <!-- btn Eliminar -->
                    <form id="eliminate">
                        <input hidden id="cod" value="<?php echo $tarea['cod']; ?>">
                        <input type="submit" class="btn-eliminar">X</input>
                    </form>   
                    </td>
                    

                </tr>
            <?php endforeach; ?>
            <!--Hasta aqui-->
        </table>

    </div>
    <script src="scripts/redirect.js"></script>
    <footer>copyright</footer>
</body>
</html>