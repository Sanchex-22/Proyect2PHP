<?php
     session_start();

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
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="css/edit_task.css">
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

    <div class="edit-card">
        <div class="formulario">
        <h1>Edit Tarea</h1>
        <form action="" method="post">
            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" required class="inputs"><br>

            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" required class="inputs"></textarea><br>

            <label for="estado">Estado:</label>
            <select id="estado" name="estado" required class="inputs">
                <option value="Por Hacer">Por Hacer</option>
                <option value="En Progreso">En Progreso</option>
                <option value="Terminada" >Terminada</option>
            </select><br>

            <label for="tipo">Categoria:</label>
            <select id="tipo" name="tipo" required class="inputs">
                <option value="Escolar">Escolar</option>
                <option value="Del Hogar">Del Hogar</option>
                <option value="Obligatorio" >Obligatorio</option>
                <option value="Rutinario" >Rutinario</option>
                <option value="Temporal" >Temporal</option>
                <option value="Otro" >Otro</option>
            </select><br>

            <label for="fecha_compromiso">Fecha Compromiso:</label>
            <input type="datetime-local" id="fecha_compromiso" name="fecha_compromiso" value="" required class="inputs"><br>

            <input type="submit" value="Guardar Cambios" class="btn-editar">
            <a href="dashboard.php" class="btn-cancelar">Cancelar</a>
        </form> 
        </div>

        <?php
        if (isset($_GET['id'])) {
            $taskId = $_GET['id'];
            

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Conectar a la base de datos (asegúrate de incluir tu archivo de conexión)
                require_once('models/taskmodels.php');
                // Obtener los valores del formulario
                $id = $taskId;
                $titulo = $_POST["titulo"];
                $descripcion = $_POST["descripcion"];
                $estado = $_POST["estado"];
                $fecha_compromiso = $_POST["fecha_compromiso"];
                $tipo_ = $_POST["tipo"];
                $responsable = $username;
                $task1 = new task();
                if($task1->edit_task($id,$titulo,$descripcion,$estado,$fecha_compromiso,$tipo_,$responsable)){
                    header("Location: dashboard.php");
                }
            }
        } else {
            // Si no se proporciona un ID válido, puedes manejar el caso de error aquí
            echo "Error: No se ha proporcionado un ID de tarea válido.";
        }

        ?>
    </div>
</body>
</html>