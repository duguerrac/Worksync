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
            <h1>Agregar evaluación</h1>
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

    <form action="/worksync/controllers/EvaluacionController.php?metodo=asignar" method="POST">
        <main>
            <div class="formulario">
                <div class="input-group">
                    <label for="IDTarea">ID tarea: </label>
                    <input type="text" id="IDTarea" name="IDTarea" required>
                </div>
                <div class="input-group">
                    <label for="descripcion">Descripción:</label>
                    <input type="text" id="descripcion" name="descripcion" required>
                </div>
                <div class="input-group">
                    <label for="calificacion">Calificación:</label>
                    <input type="text" id="calificacion" name="calificacion" required>
                </div>
            </div>
            <div class="botonera-3bt">
                <button type="submit" class="BtAzul">Agregar</button>
                <button type="button" class="BtGris" onclick="borrar()">Borrar</button>
                <button type="button" class="BtRojo" onclick="cerrar()">Cerrar</button>
            </div>
        </main>
    </form>

    <script>
        
        var mensajeExiste = <?php echo isset($_GET['mensaje']) ? 'true' : 'false'; ?>;

        if (mensajeExiste) {
            alert('<?php echo isset($_GET['mensaje']) ? $_GET['mensaje'] : ""; ?>');
        }

        function cerrar() {
            window.location.href = "/Worksync/views/menus/menuAdmin.php";
        }

        function borrar() {
            document.getElementById("IDTarea").value = "";
            document.getElementById("descripcion").value = "";
            document.getElementById("calificacion").value = "";
        }

    </script>
    <?php
    include_once(__DIR__ . '/../layout/footer.php');
    ?>
</body>

</html>