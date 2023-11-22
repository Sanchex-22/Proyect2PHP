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
    <?php
            if (isset($_GET['id'])) {
            $taskId = $_GET['id'];}
        ?>
    <div class="edit-card">
        <div class="formulario">
        <h1>Edit Tarea</h1>
        <form action="" method="post" id="edit">
        <input type="text" id="cod" name="Responsable" required class="inputs" value="<?php echo $taskId; ?>"><br>
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
            <input type="text" id="responsable" name="Responsable" required class="inputs" value="<?php echo $_SESSION["username"]; ?>"><br>
            <input type="submit" value="Guardar Cambios" class="btn-editar">
            <a href="dashboard.php" class="btn-cancelar">Cancelar</a>
        </form> 
        </div>

        <script>
            document.getElementById('edit').addEventListener('submit', function(event) {
                event.preventDefault();
                const cod = document.getElementById('cod').value;
                const titulo = document.getElementById('titulo').value;
                const descripcion = document.getElementById('descripcion').value;
                const estado = document.getElementById('estado').value;
                const tipo = document.getElementById('tipo').value;
                const responsable = document.getElementById('responsable').value;
                const fecha_compromiso = document.getElementById('fecha_compromiso').value;
                const etiqueta = 'editado';
                const formData = {
                    cod: cod,
                    Titulo: titulo,
                    Descripcion: descripcion,
                    Estado: estado,
                    tipo_: tipo,
                    Responsable: responsable,
                    Fecha_Compromiso: fecha_compromiso,
                    Etiqueta : etiqueta
                };

                fetch('api/edit.php', {
                    method: 'POST',
                    body: JSON.stringify(formData),

                })
                .then(response => response.text())
                .then(data => {
                    alert("Tarea creada exitosamente: " + data);
                    window.location.href = 'dashboard.php';
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });
        </script>
    </div>
</body>
</html>