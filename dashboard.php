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
    <title>Document</title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="css/dashboard1.css">
</head>
<body>

    <Nav class="navbar">
        <ul class="nav-izq">
            <li><img src="img/logo.png" alt="logo" style="height: 40px; width: 40px;"></li>
            <li><a href="#">Home</a></li>
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

    <div class="body-tittle">
        <h1>Tareas</h1>
    </div>
    <div class="body-list">
        
        <div class="card">
            <div class="tittle-card"><h3>Por hacer</h3></div>
            <button class="btn-crear" id="redireccionarBtn">+ Añadir tarea</button>

            <!-- Tareas Mapping -->
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
            
            foreach ($tareas as $tarea) {
                if ($tarea['Estado'] === 'En Progreso') {
                    $tareasEnProceso[] = $tarea;
                } 
                else if($tarea['Estado'] === 'Por Hacer') {
                    $tareasPorHacer[] = $tarea;
                }
                else if ($tarea['Estado'] === 'Terminada'){
                    $tareasTerminadas[] = $tarea;
                }
            }

            if (!empty($tareasPorHacer)):
            foreach ($tareasPorHacer as $tarea) : ?>
                <div class="task">
                    <div class="box-x">
                    <form id="eliminate">
                        <input hidden id="cod" value="<?php echo $tarea['cod']; ?>">
                        <input type="submit" class="btn-eliminar">X</input>
                    </form>   
                    </div>
                    <div>
                        <!-- <h4>#<?php echo $tarea['cod']; ?></h4> -->
                        <h4>Titulo:<?php echo $tarea['Titulo']; ?><span style="color: gray;"><?php echo $tarea['Etiqueta']; ?></span></h4>
                        <p>Estado:<?php echo $tarea['Estado']; ?></p>
                        <p><?php echo $tarea['Descripcion']; ?></p>
                        <p>Categoria:<?php echo $tarea['Tipo_']; ?></p>
                        <p>por:<?php echo $tarea['Responsable']; ?></p>
                        <p>fecha:<?php echo $tarea['Fecha_Compromiso']; ?></p>
                    </div>
                    <div>
                        <a href="edit_task.php?id=<?php echo $tarea['cod']; ?>" class="btn-editar">Editar</a>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php endif; ?>

        </div>

        <div class="card2">
            <div class="tittle-card2"><h3>En Progreso</h3></div>

            <!-- Tareas Mapping -->
            <?php if (!empty($tareasEnProceso)):?>
            <?php foreach ($tareasEnProceso as $tarea) : ?>
                <div class="task">
                    <div class="box-x">
                    <form id="eliminate">
                        <input hidden id="cod" value="<?php echo $tarea['cod']; ?>">
                        <input type="submit" class="btn-eliminar">X</input>
                    </form>   
                    </div>
                    <div>
                        <!-- <h4>#<?php echo $tarea['cod']; ?></h4> -->
                        <h4>Titulo:<?php echo $tarea['Titulo']; ?><span style="color: gray;"><?php echo $tarea['Etiqueta']; ?></span></h4>
                        <p>Estado:<?php echo $tarea['Estado']; ?></p>
                        <p><?php echo $tarea['Descripcion']; ?></p>
                        <p>Categoria:<?php echo $tarea['Tipo_']; ?></p>
                        <p>por:<?php echo $tarea['Responsable']; ?></p>
                        <p>fecha:<?php echo $tarea['Fecha_Compromiso']; ?></p>
                    </div>
                    <div>
                        <a href="edit_task.php?id=<?php echo $tarea['cod']; ?>" class="btn-editar">Editar</a>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php endif; ?>

        </div>

        <div class="card3">
            <div class="tittle-card3"><h3>Terminada</h3></div>

            <!-- Tareas Mapping -->
            <?php if (!empty($tareasTerminadas)):?>
            <?php foreach ($tareasTerminadas as $tarea) : ?>
                <div class="task">
                    <div class="box-x">
                    <form id="eliminate">
                        <input hidden id="cod" value="<?php echo $tarea['cod']; ?>">
                        <input type="submit" class="btn-eliminar">X</input>
                    </form>    
                    </div>
                    <div>
                        <!-- <h4>#<?php echo $tarea['cod']; ?></h4> -->
                        <h4>Titulo:<?php echo $tarea['Titulo']; ?><span style="color: gray;"><?php echo $tarea['Etiqueta']; ?></span></h4>
                        <p>Estado:<?php echo $tarea['Estado']; ?></p>
                        <p><?php echo $tarea['Descripcion']; ?></p>
                        <p>Categoria:<?php echo $tarea['Tipo_']; ?></p>
                        <p>por:<?php echo $tarea['Responsable']; ?></p>
                        <p>fecha:<?php echo $tarea['Fecha_Compromiso']; ?></p>
                    </div>
                    <div>
                        <a href="edit_task.php?id=<?php echo $tarea['cod']; ?>" class="btn-editar">Editar</a>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php endif; ?>

        </div>

    </div>
    <script src="scripts/redirect.js"></script>

</body>

</html>