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
    <title>Usuario</title>
    <link rel="stylesheet" href="http://localhost/Worksync/assets/css/styleM.css">
    <link rel="shortcut icon" href="http://localhost/Worksync/assets/img/LogoWorksync.png">
</head>

<body>
    <header>
        <div class="titulo">
            <h1>Agregar usuario</h1>
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#000000">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                    <circle cx="12" cy="12" r="10" stroke="#000000" stroke-width="1.5"></circle>
                    <path d="M15 12L12 12M12 12L9 12M12 12L12 9M12 12L12 15" stroke="#000000" stroke-width="1.5" stroke-linecap="round"></path>
                </g>
            </svg>
        </div>
    </header>

    <?php
    include_once(__DIR__ . '/../layout/aside.php');
    ?>
    <form action="/worksync/controllers/UsuarioController.php?metodo=agregar" method="POST">
        <main>
            <div class="formulario">
                <div class="input-group">
                    <label for="documento">Documento: </label>
                    <input type="text" id="documento" name="documento" required>
                </div>
                <div class="input-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" required>
                </div>
                <div class="input-group">
                    <label for="Correo">Correo:</label>
                    <input type="text" id="correo" name="correo" required>
                </div>
                <div class="input-group">
                    <label for="Rol">Rol:</label>
                    <select id="rol" name="rol" required>
                        <option value="1">Administrador</option>
                        <option value="2">Empleado</option>
                    </select>
                </div>
                <div class="input-group">
                    <label for="Clave">Clave:</label>
                    <input type="text" id="clave" name="clave" required>
                </div>
            </div>
            <div class="botonera-3bt">
                <button type="submit" class="BtAzul">Crear</button>
                <button type="button" class="BtGris" onclick="borrar()">Borrar</button>
                <button type="button" class="BtRojo" onclick="cerrar()">Cerrar</button>
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
            document.getElementById("documento").value = "";
            document.getElementById("nombre").value = "";
            document.getElementById("correo").value = "";
            document.getElementById("rol").value = "";
            document.getElementById("clave").value = "";
        }

    </script>
</body>

</html>