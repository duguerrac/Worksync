<?php
session_start();
require_once(__DIR__ . '/../../config/DB.php');
require_once(__DIR__ . '/../../models/SolicitudModel.php');
require_once(__DIR__ . '/../../controllers/SolicitudController.php');

$controller = new SolicitudController();
$solicitudes = $controller->mostrarSolicitudesPorUsuario();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://localhost/Worksync/assets/css/styleMenu.css">
    <link rel="shortcut icon" href="http://localhost/Worksync/assets/img/LogoWorksync.png">
    <title>Menu empleado</title>
</head>

<body>
    
    <header class="header">
        <div class="titulo">
            <h1>WorkSync</h1>
            <p id="nombreUsuario"><?php  echo isset($_SESSION['nombre']) ? $_SESSION['nombre'] : 'Empleado'; ?></p>
        </div>
        
        <img src="http://localhost/Worksync/assets/img/LogoWorksync.png" alt="Worksync" class="logo">
        <input type="checkbox" id="toggle">
        <label for="toggle"><img class="menu" src="http://localhost/Worksync/assets/img/menu.svg" alt="menu"></label>
        <nav class="navegation">


            <ul class="menu-horizontal">
                <li>
                    <a href="#">VISUALIZAR</a>
                    <ul class="menu-vertical">
                        <li><a href="http://localhost/Worksync/views/visualizar/visualizarTurno.php">Visualizar turno</a></li>
                        <li><a href="http://localhost/Worksync/views/visualizar/visualizarTarea.php">Visualizar tarea</a></li>
                        <li><a href="http://localhost/Worksync/views/visualizar/visualizarEvaluacion.php">Visualizar evaluación</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#">SOLICITUDES</a>
                    <ul class="menu-vertical">
                        <li><a href="http://localhost/Worksync/views/solicitudesEmpleado/solicitarCambio.php">Solicitar un cambio</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        
        <div class="logout">
            <a href="../../index.php?logout" class="btn-logout">Cerrar Sesión</a>
        </div>
    </header>
    <div class="lateral">
    <div class="cuadro">
            <h2>Mis turnos</h2>
            <table>
                    <thead>
                        <tr>
                            <th>ID turno</th>
                            <th>Fecha</th>
                            <th>Descripción</th>
                        </tr>
                    </thead>
                <tbody style="max-height: 50px; overflow-y: auto;">
                    <?php if (!empty($solicitudes)): ?>
                        <?php foreach ($solicitudes as $solicitud): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($solicitud->idTurno); ?></td>
                                <td><?php echo htmlspecialchars($solicitud->fecha); ?></td>
                                <td><?php echo htmlspecialchars($solicitud->descripcion); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4">No hay solicitudes para mostrar</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <img src="http://localhost/Worksync/assets/img/LogoWorksync.png" alt="Worksync" class="logo1">
</body>

</html>