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
            <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"]) && $_POST["action"] == "eliminar") {
                    $taskId = $_POST["task_id"];
                    require_once('models/taskmodels.php');
                
                    $eliminatetarea = new task();
                    $eliminatetarea->eliminar_task($taskId);
                }
            ?>
            <?php
            require_once('models/taskmodels.php');
            // Instancia la clase `task`
            $tarea = new task();
            // Obtén las tareas desde la base de datos
            $tareas = $tarea->consultar_task();
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
                     <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <input type="hidden" name="action" value="eliminar">
                        <input type="hidden" name="task_id" value="<?php echo $tarea['cod']; ?>">
                        <button type="submit" class="eliminate-btn">Eliminar</button>
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