<script>
function mostrarAlerta() {
    alert("Botón en funcionamiento.");
}
</script>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluación</title>
    <link rel="stylesheet" href="http://localhost/Worksync/assets/css/styleM.css">
    <link rel="shortcut icon" href="http://localhost/Worksync/assets/img/LogoWorksync.png">
</head>
<body><header>
        <div class="titulo">
            <h1>Buscar evaluación</h1>
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                    <circle cx="12" cy="12" r="10" stroke="#ffffff" stroke-width="1.5"></circle>
                    <path d="M15 12L12 12M12 12L9 12M12 12L12 9M12 12L12 15" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round"></path>
                </g>
            </svg>
        </div>
    </header>
   <?php 
    include_once(__DIR__ . '/../layout/aside.php');
    ?>

    <form action="/worksync/controllers/EvaluacionController.php?metodo=BuscarEvaluaciones" method="POST">
        <main>
            <div class="formulario">
                <div class="input-group">
                    <label for="Usuario">Documento empleado:</label>
                    <input type="text" id="Usuario" name="Usuario" required>
                </div>
            </div>
            <div class="botonera">
                <button type="submit" class="BtCian">Buscar</button>
                
                <br>
                <button type="submit" class="BtRojo" onclick="cerrar()">Cerrar</button>
            </div>
        </main>
    </form>

    <div class="contenedor">
        <table>
            <thead>
                <tr>
                    <th>ID tarea</th>
                    <th>Descripción tarea</th>
                    <th>ID evaluación</th>
                    <th>Descripción evaluación</th>
                    <th>Calificación</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($evaluaciones)) : ?>
                    <?php foreach ($evaluaciones as $evaluacion) : ?>
                        <tr>
                            <td><?php echo $evaluacion['idTarea']; ?></td>
                            <td><?php echo $evaluacion['descripcion_tarea']; ?></td>
                            <td><?php echo $evaluacion['idEvaluacion']; ?></td>
                            <td><?php echo $evaluacion['descripcion']; ?></td>
                            <td><?php echo $evaluacion['calificacion']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php
    include_once(__DIR__ . '/../layout/footer.php');
    ?>

    <script>
        var mensajeExiste = <?php echo isset($_GET['mensaje']) ? 'true' : 'false'; ?>;

        if (mensajeExiste) {
            alert('<?php echo isset($_GET['mensaje']) ? $_GET['mensaje'] : ""; ?>');
        }

        function cerrar() {
            window.location.href = "/worksync/views/menus/menuAdmin.php";
        }
        function borrar() {
            document.getElementById("fecha").value = "";
            document.getElementById("Usuario").value = "";
            document.getElementById("descripcion").value = "";
        }
    </script>
</body>
</html>