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
            <h1>Activar/Desactivar usuario</h1>
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
    <form action="/worksync/controllers/UsuarioController.php?metodo=modificar" method="POST">
        <main>
            <div class="formulario">
                <div class="input-group">
                    <label for="documento">Documento:</label>
                    <input type="text" id="documento" name="documento"  required <?php if(isset($documento)){ echo 'value="';echo $documento['documento'];echo '"'; }?>>
                </div>
                <div class="input-group">
                    <label for="nombre">Nombre: </label>
                    <input type="text" id="nombre" name="nombre"  <?php if(isset($documento)){ echo 'value="';echo $documento['nombre'];echo '"'; }?>>
                </div>
                <div class="input-group">
                    <label for="correo">Correo:</label>
                    <input type="text" id="correo" name="correo"  <?php if(isset($documento)){ echo 'value="';echo $documento['correo'];echo '"'; }?>>
                </div>
                <div class="input-group">
                <label for="rol">Rol:</label>
                    <select id="rol" name="rol">
                        <option value="1" <?php if(isset($documento)){ if($documento['rol']==1){echo 'selected';}}?>>Administrador</option>
                        <option value="2" <?php if(isset($documento)){ if($documento['rol']==2){echo 'selected';}}?>>Empleado</option>
                    </select>
                </div>
                <div class="input-group">
                    <label for="clave">Clave:</label>
                    <input type="text" id="clave" name="clave"<?php if(isset($documento)){ echo 'value="';echo $documento['clave'];echo '"'; }?>>
                </div>
                <div class="input-group">
                    <label for="Estado">Estado:</label>
                    <select id="estado" name="estado">
                        <option value="1" <?php if(isset($documento)){ if($documento['estado']==0){echo 'selected';}}?>>Inactivo</option>
                        <option value="2" <?php if(isset($documento)){ if($documento['estado']==1){echo 'selected';}}?>>Activo</option>
                    </select>
                </div>
            </div>
            <div class="botonera-3bt">
                <button class="BtAzul" type="button"  onclick="buscar()">Buscar</button>
                <button class="BtCian" type="button"  onclick="Desactivar()">Desactivar</button>
                <button class="BtVerde" type="button"  onclick="Activar()">Activar</button>
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
            document.getElementById("documento").readOnly = false;
            document.getElementById("documento").value = "";
            document.getElementById("nombre").value = "";
            document.getElementById("correo").value = "";
            document.getElementById("rol").value = "";
            document.getElementById("clave").value = "";
            
            document.getElementById("estado").value = "";
        
        }

        function Desactivar() {
            let usuario = document.getElementById("documento").value;
            document.getElementById("documento").readOnly = true; 
            window.location.href = "/worksync/controllers/UsuarioController.php?metodo=Desactivar&documento=" + usuario;            
        }  


        function Activar() {
            let usuario = document.getElementById("documento").value;
            document.getElementById("documento").readOnly = true;
            window.location.href = "/worksync/controllers/UsuarioController.php?metodo=Activar&documento=" + usuario;            
        }       

        function buscar() {
            let usuario = document.getElementById("documento").value;
            document.getElementById("documento").readOnly = true;
            window.location.href = "/worksync/controllers/UsuarioController.php?metodo=buscarUsuarioAD&documento=" + usuario;            
        }

    </script>
</body>

</html>