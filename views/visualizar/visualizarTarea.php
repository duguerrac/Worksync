<script>
function buscarTareas() {
    var fecha = document.getElementById('txtFechaTurno').value;
    var form = document.createElement('form');
    form.method = 'POST';
    form.action = '/worksync/controllers/TareaController.php?metodo=BuscarTareaFecha';

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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarea</title>
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
        <h1>Visualizar tarea</h1>
    </div>
    <div class="busqueda">
        <input type="date" placeholder="Fecha" class="inputFecha" id="txtFechaTurno">
        <button onclick="buscarTareas()" class="btnBuscar">Buscar</button>
        <br>
        <button type="submit" class="btnCerrar" onclick="cerrar()">Cerrar</button>
    </div>
    <br>
    <div class="contenedor">
        <table>
            <thead>
                <tr>
                    <th>Hora de inicio</th>
                    <th>Hora límite</th>
                    <th>Descripción</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($tareas)) : ?>
                    <?php foreach ($tareas as $tarea) : ?>
                        <tr>
                            <td><?php echo $tarea['horaInicio']; ?></td>
                            <td><?php echo $tarea['horaLimite']; ?></td>
                            <td><?php echo $tarea['descripcion']; ?></td>
                        </tr>
                    <?php endforeach; ?>
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
