<script>
function buscarTareasYDesempeno() {
    var fecha = document.getElementById('txtFechaDesempeno').value;
    var form = document.createElement('form');
    form.method = 'POST';
    form.action = '/worksync/controllers/EvaluacionController.php?metodo=buscarTareasYDesempeno';

    var input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'fecha';
    input.value = fecha;

    form.appendChild(input);
    document.body.appendChild(form);
    form.submit();
}
</script>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluación</title>
    <link rel="stylesheet" href="http://localhost/Worksync/assets/css/styleJulio.css">
    <link rel="shortcut icon" href="http://localhost/Worksync/assets/img/LogoWorksync.png">
</head>
<body>
    <?php 
        include_once(__DIR__ . '/../layout/header.php');
        include_once(__DIR__ . '/../layout/aside.php');
    ?>

    <main>
        <div class="title">
            <h1>Visualizar evaluación</h1>
        </div>
        <div class="busqueda">
            <input type="date" placeholder="Fecha" class="inputFecha" id="txtFechaDesempeno">
            <button onclick="buscarTareasYDesempeno()" class="btnBuscar">Buscar</button>
            
        <br>
        <button type="submit" class="btnCerrar" onclick="cerrar()">Cerrar</button>
        </div>
        <br>
        <div class="contenedor">
            <table>
                <thead>
                    <tr>
                        <th>Tarea</th>
                        <th>Evaluación</th>
                        <th>Calificación</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($tareasDesempeno)) :
                        foreach ($tareasDesempeno as $tareaDesempeno) : ?>
                            <tr>
                                <td><?php echo $tareaDesempeno['tarea']; ?></td>
                                <td><?php echo $tareaDesempeno['evaluacion']; ?></td>
                                <td><?php echo $tareaDesempeno['calificacion']; ?></td>
                            </tr>
                        <?php endforeach;
                    else : ?>
                        <tr>
                            <td colspan="3">No se encontraron tareas para la fecha seleccionada.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
    <script>
         var mensajeExiste = <?php echo isset($_GET['mensaje']) ? 'true' : 'false'; ?>;

if (mensajeExiste) {
    alert('<?php echo isset($_GET['mensaje']) ? $_GET['mensaje'] : ""; ?>');
}
        function cerrar() {
            window.location.href = "/worksync/views/menus/menuUser.php";
        }
        </script>
    <?php 
        include_once(__DIR__ . '/../layout/footer.php');
    ?>
</body>
</html>