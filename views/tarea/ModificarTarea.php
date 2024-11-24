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
    <link rel="shortcut icon" href="http://localhost/Worksync/assets//img/LogoWorksync.png">
</head>

<body>
    <header>
        <div class="titulo">
            <h1>Actualizar tarea</h1>
            <svg fill="#000000" viewBox="0 0 24 24" id="update-alt" data-name="Flat Line" xmlns="http://www.w3.org/2000/svg" class="icon flat-line">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                    <path id="primary" d="M5.07,8A8,8,0,0,1,20,12" style="fill: none; stroke: #ffffff; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></path>
                    <path id="primary-2" data-name="primary" d="M18.93,16A8,8,0,0,1,4,12" style="fill: none; stroke: #ffffff; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></path>
                    <polyline id="primary-3" data-name="primary" points="5 3 5 8 10 8" style="fill: none; stroke: #ffffff; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></polyline>
                    <polyline id="primary-4" data-name="primary" points="19 21 19 16 14 16" style="fill: none; stroke: #ffffff; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></polyline>
                </g>
            </svg>
        </div>
    </header>

    <?php 
    include_once(__DIR__ . '/../layout/aside.php');
    ?>

    <form action="/worksync/controllers/TareaController.php?metodo=modificar" method="POST">
        <main>
            <div class="formulario">
                <div class="input-group">
                    <label for="IDTarea">ID Tarea:</label>
                    <input type="text" id="IDTarea" name="IDTarea" required <?php if(isset($tarea)){ echo 'value="';echo $tarea['idTarea'];echo '"'; }?>>
                </div>
                <div class="input-group">
                    <label for="IDTurno">ID Turno:</label>
                    <input type="text" id="IDTurno" name="IDTurno" required <?php if(isset($tarea)){ echo 'value="';echo $tarea['idTurno'];echo '"'; }?>>
                </div>
                <div class="input-group">
                    <label for="HoraInicio">Hora de inicio:</label>
                    <input type="time" id="HoraInicio" name="HoraInicio"<?php if(isset($tarea)){ echo 'value="';echo $tarea['horaInicio'];echo '"'; }?>>
                </div>
                <div class="input-group">
                    <label for="HoraLimite">Hora limite: </label>
                    <input type="time" id="HoraLimite" name="HoraLimite"<?php if(isset($tarea)){ echo 'value="';echo $tarea['horaLimite'];echo '"'; }?>>
                </div>
                <div class="input-group">
                    <label for="Descripcion">Descripcion:</label>
                    <input type="text" id="Descripcion" name="Descripcion"<?php if(isset($tarea)){ echo 'value="';echo $tarea['descripcion'];echo '"'; }?>>
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
            document.getElementById("IDTurno").value = "";
            document.getElementById("IDTarea").value = "";
            document.getElementById("HoraInicio").value = "";
            document.getElementById("HoraLimite").value = "";
            document.getElementById("Descripcion").value = "";
        }

        function buscar() {
            let tarea = document.getElementById("IDTarea").value;
            window.location.href = "/worksync/controllers/TareaController.php?metodo=buscar&IDTarea=" + tarea;
        }

    </script>
    <?php 
    include_once(__DIR__ . '/../layout/footer.php');
    ?>
</body>

</html>