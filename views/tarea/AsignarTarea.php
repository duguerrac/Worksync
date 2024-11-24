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
    <title>Tarea</title>
    <link rel="stylesheet" href="http://localhost/Worksync/assets/css/styleM.css">
    <link rel="shortcut icon" href="http://localhost/Worksync/assets/img/LogoWorksync.png">
</head>

<body>
    <header>
        <div class="titulo">
            <h1>Crear tarea</h1>
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

    <form action="/worksync/controllers/TareaController.php?metodo=asignar" method="POST">
        <main>
            <div class="formulario">
                <div class="input-group">
                    <label for="IDTurno">ID turno: </label>
                    <input type="text" id="IDTurno" name="IDTurno" required>
                </div>
                <div class="input-group">
                    <label for="HoraInicio">Hora de inicio:</label>
                    <input type="time" id="HoraInicio" name="HoraInicio" required>
                </div>
                <div class="input-group">
                    <label for="HoraLimite">Hora limite:</label>
                    <input type="time" id="HoraLimite" name="HoraLimite" required>
                </div>
                <div class="input-group">
                    <label for="Descripcion">Descripcion:</label>
                    <input type="text" id="Descripcion" name="Descripcion" required>
                </div>
            </div>
            <div class="botonera-3bt">
                <button type="submit" class="BtAzul">Asignar</button>
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
            window.location.href = "/worksync/views/menus/menuAdmin.php";
        }
        function borrar() {
            document.getElementById("IDTurno").value = "";
            document.getElementById("HoraInicio").value = "";
            document.getElementById("HoraLimite").value = "";
            document.getElementById("descripcion").value = "";
        }

    </script>
    <?php
    include_once(__DIR__ . '/../layout/footer.php');
    ?>
</body>

</html>