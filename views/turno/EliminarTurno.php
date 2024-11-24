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
    <title>Turno</title>
    <link rel="stylesheet" href="http://localhost/Worksync/assets/css/styleM.css">
    <link rel="shortcut icon" href="http://localhost/Worksync/assets/img/LogoWorksync.png">
</head>

<body>
    <header>
        <div class="titulo">
            <h1>Eliminar turno</h1>
            <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" fill="#000000">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                    <g fill="none" fill-rule="evenodd">
                        <path d="m0 0h32v32h-32z"></path>
                        <path d="m16 0c8.836556 0 16 7.163444 16 16s-7.163444 16-16 16-16-7.163444-16-16 7.163444-16 16-16zm0 2c-7.7319865 0-14 6.2680135-14 14s6.2680135 14 14 14 14-6.2680135 14-14-6.2680135-14-14-14zm3.5355339 9.0502525 1.4142136 1.4142136-8.4852814 8.4852814-1.4142136-1.4142136z" fill="#ffffff" fill-rule="nonzero"></path>
                    </g>
                </g>
            </svg>
        </div>
    </header>

    <?php
    include_once(__DIR__ . '/../layout/aside.php');
    ?>
    <form action="/worksync/controllers/TurnoController.php?metodo=eliminar" method="POST">
        <main>
            <div class="formulario">
                <div class="input-group">
                    <label for="id_turno">ID Turno:</label>
                    <input type="text" id="id_turno" name="id_turno" required <?php if(isset($turno)){ echo 'value="';echo $turno['idTurno'];echo '"'; }?>>
                </div>
                <div class="input-group">
                    <label for="fecha">Fecha: </label>
                    <input type="date" id="fecha" name="fecha"<?php if(isset($turno)){ echo 'value="';echo $turno['fecha'];echo '"'; }?>>
                </div>
                <div class="input-group">
                    <label for="descripcion">Descripcion:</label>
                    <input type="text" id="descripcion" name="descripcion"<?php if(isset($turno)){ echo 'value="';echo $turno['descripcion'];echo '"'; }?>>
                </div>
                <div class="input-group">
                    <label for="Usuario">Usuario:</label>
                    <input type="text" id="Usuario" name="Usuario"<?php if(isset($turno)){ echo 'value="';echo $turno['documentoUsuario'];echo '"'; }?>>
                </div>
            </div>
            <div class="botonera-3bt">
                <button class="BtAzul" type="button" onclick="buscar()">Buscar</button>
                <button class="BtCian" type="submit">Eliminar</button>
                <button class="BtGris" type="button" onclick="borrar()">Borrar</button>
                <button class="BtRojo" type="button" onclick="cerrar()">Cerrar</button>
            </div>
        </main>
    </form>
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
            document.getElementById("id_turno").value = "";
        }

        function buscar() {
            let turno = document.getElementById("id_turno").value;
            window.location.href = "/worksync/controllers/TurnoController.php?metodo=BuscarEliminar&id_turno=" + turno;
        }
    </script>
</body>

</html>