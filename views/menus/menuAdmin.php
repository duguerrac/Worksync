<?php
session_start();
require_once(__DIR__ . '/../../config/DB.php');
require_once(__DIR__ . '/../../models/SolicitudModel.php');
require_once(__DIR__ . '/../../controllers/SolicitudController.php');

$controller = new SolicitudController();
$solicitudes = $controller->mostrarSolicitudes();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu administrador</title>
    <link rel="stylesheet" href="http://localhost/Worksync/assets/css/styleMenu.css">
    <link rel="shortcut icon" href="http://localhost/Worksync/assets/img/LogoWorksync.png">
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
                    <a href="#">USUARIOS</a>
                    <ul class="menu-vertical">
                        <li><a href="http://localhost/Worksync/views/usuarios/AgregarUsuarios.php">Agregar usuario</a></li>
                        <li><a href="http://localhost/Worksync/views/usuarios/ActualizarUsuarios.php">Actualizar usuario</a></li>
                        <li><a href="http://localhost/Worksync/views/usuarios/DesactivarUsuarios.php">Activar/Desactivar usuario</a></li>
                        <li><a href="http://localhost/Worksync/views/usuarios/BuscarUsuarios.php">Buscar usuario</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#">TURNO</a>
                    <ul class="menu-vertical">
                        <li><a href="http://localhost/Worksync/views/turno/CrearTurno.php">Crear turno</a></li>
                        <li><a href="http://localhost/Worksync/views/turno/ModificarTurno.php">Actualizar turno</a></li>
                        <li><a href="http://localhost/Worksync/views/turno/EliminarTurno.php">Eliminar turno</a></li>
                        <li><a href="http://localhost/Worksync/views/turno/BuscarTurno.php">Buscar turno</a></li>

                    </ul>
                </li>
                <li>
                    <a href="#">TAREA</a>
                    <ul class="menu-vertical">
                        <li><a href="http://localhost/Worksync/views/tarea/AsignarTarea.php">Asignar tarea</a></li>
                        <li><a href="http://localhost/Worksync/views/tarea/ModificarTarea.php">Actualizar tarea</a></li>
                        <li><a href="http://localhost/Worksync/views/tarea/DesactivarTarea.php">Eliminar tarea</a></li>
                        <li><a href="http://localhost/Worksync/views/tarea/BuscarTarea.php">Buscar tarea</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#">DETALLES</a>
                    <ul class="menu-vertical">
                        <li><a href="http://localhost/Worksync/views/detalles/verListaEmpleados.php">Ver todos los empleados</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#">EVALUAR</a>
                    <ul class="menu-vertical">
                        <li><a href="http://localhost/Worksync/views/evaluacion/AgregarEvaluacion.php">Agregar evaluación</a></li>
                        <li><a href="http://localhost/Worksync/views/evaluacion/ModificarEvaluacion.php">Actualizar evaluación</a></li>
                        <li><a href="http://localhost/Worksync/views/evaluacion/BuscarEvaluacion.php">Buscar evaluación</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#">SOLICITUDES</a>
                    <ul class="menu-vertical">
                        <li><a href="http://localhost/Worksync/views/solicitudesAdmin/verSolicitudCambioTurno.php">Ver solicitud cambio de turno</a></li>
                        <li><a href="http://localhost/Worksync/views/solicitudesAdmin/verSolicitudCambioTarea.php">Ver solicitud cambio de tarea</a></li>
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
            <h2>Detalle de solicitudes</h2>
            <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>descripcion</th>
                            <th>tipo</th>
                            <th>Documento</th>
                        </tr>
                    </thead>
                <tbody style="max-height: 50px; overflow-y: auto;">
                    <?php if (!empty($solicitudes)): ?>
                        <?php foreach ($solicitudes as $solicitud): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($solicitud->idSolicitudes); ?></td>
                                <td><?php echo htmlspecialchars($solicitud->descripcion); ?></td>
                                <td><?php echo htmlspecialchars($solicitud->tipo); ?></td>
                                <td><?php echo htmlspecialchars($solicitud->documentoUsuario); ?></td>
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