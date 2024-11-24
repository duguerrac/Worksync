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

<body>
    <header>
        <div class="titulo">
            <h1>Actualizar evaluación</h1>
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

    <form action="/worksync/controllers/EvaluacionController.php?metodo=modificar" method="POST">
    <main>
            <div class="formulario">
                <div class="input-group">
                    <label for="IDEvaluacion">ID Evaluacion:</label>
                    <input type="text" id="IDEvaluacion" name="IDEvaluacion" required <?php if(isset($evaluacion)){ echo 'value="';echo $evaluacion['idEvaluacion'];echo '"'; }?>>
                </div>
                <div class="input-group">
                    <label for="IDTarea">ID Tarea:</label>
                    <input type="text" id="IDTarea" name="IDTarea" required readonly <?php if(isset($evaluacion)){ echo 'value="';echo $evaluacion['idTarea'];echo '"'; }?>>
                </div>
                <div class="input-group">
                    <label for="Descripcion">Descripcion:</label>
                    <input type="text" id="Descripcion" name="Descripcion"<?php if(isset($evaluacion)){ echo 'value="';echo $evaluacion['descripcion'];echo '"'; }?>>
                </div>
                <div class="input-group">
                    <label for="Calificacion">Calificacion: </label>
                    <input type="text" id="Calificacion" name="Calificacion"<?php if(isset($evaluacion)){ echo 'value="';echo $evaluacion['calificacion'];echo '"'; }?>>
                </div>
            </div>
            <div class="botonera-3bt">
                <button class="BtAzul" type="button"  onclick="buscar()">Buscar</button>
                <button class="BtCian" type="submit">Actualizar</button>
                <button class="BtGris" type="button" onclick="borrar()">Borrar</button>
                <button class="BtRojo" type="button" onclick="cerrar()">Cerrar</button>
            </div>
        </main>
    </form>

    <script>
        var mensajeExiste = <?php echo isset($_GET['mensaje']) ? 'true' : 'false'; ?>;

        if (mensajeExiste) {
            alert('<?php echo isset($_GET['mensaje']) ? $_GET['mensaje'] : ""; ?>');
        }

        function cerrar() {
            window.location.href = "/worksync/views/menus/menuAdmin.php";
        }

        function borrar() {
            document.getElementById("IDEvaluacion").value = "";
            document.getElementById("IDTarea").value = "";
            document.getElementById("Descripcion").value = "";
            document.getElementById("Calificacion").value = "";
        }

        function buscar() {
            let evaluacion = document.getElementById("IDEvaluacion").value;
            window.location.href = "/worksync/controllers/EvaluacionController.php?metodo=LlenarDatos&IDEvaluacion=" + evaluacion;
        }
    </script>
    <?php
    include_once(__DIR__ . '/../layout/footer.php');
    ?>
</body>

</html>