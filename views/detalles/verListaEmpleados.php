<?php
require_once(__DIR__ . '/../../config/DB.php');
require_once(__DIR__ . '/../../models/EmpleadoModel.php');
require_once(__DIR__ . '/../../controllers/EmpleadoController.php');

$controller = new EmpleadoController();
$empleados = $controller->mostrarLista();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empleados</title>
    <link rel="stylesheet" href="http://localhost/Worksync/assets/css/styleSa.css">
    <link rel="shortcut icon" href="http://localhost/Worksync/assets/img/LogoWorksync.png">
</head>

<body>
<header>
    <div class="titulo">
        <h1>Lista de empleados</h1>
        <img src="http://localhost/Worksync/assets/img/lista.png" alt="Worksync">
    </div>
</header>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/Worksync/views/layout/aside.php'); ?>
<main>
    <div class="lista">
        <h2>Maestro detalle de empleados</h2>
    </div>
    <table style="border-collapse: collapse; width: 50%; border: 3px solid #000; text-align: left; margin-left: 500px;">
        <thead>
            <tr>
                <th>Documento</th>
                <th>Nombre</th>
                <th>Correo</th>
            </tr>
        </thead>
        <tbody style="max-height: 50px; overflow-y: auto;">
            <?php if (!empty($empleados)): ?>
                <?php foreach ($empleados as $empleado): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($empleado->documento); ?></td>
                        <td><?php echo htmlspecialchars($empleado->nombre); ?></td>
                        <td><?php echo htmlspecialchars($empleado->correo); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">No hay empleados para mostrar</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</main>
        <script>
        function cerrar() {
            window.location.href = "/worksync/views/menus/menuAdmin.php";
        }
        </script>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/Worksync/views/layout/footer.php'); ?>
</body>
</html>
