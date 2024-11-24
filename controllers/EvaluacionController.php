<?php
require_once(__DIR__ . '/../models/EvaluacionModel.php');

class EvaluacionController extends EvaluacionModel
{
    public function AgregarEvaluacion()
    {
        $IDTarea = $_POST['IDTarea'];
        $descripcion = $_POST['descripcion'];
        $calificacion = $_POST['calificacion'];

        parent::setIdTarea($IDTarea);
        parent::setDescripcion($descripcion);
        parent::setCalificacion($calificacion);

        if (parent::validarTarea()) {

            parent::agregar();
        } else {

            header("Location: /worksync/views/evaluacion/AgregarEvaluacion.php? mensaje=No existe un turno con este id");
        }
    }

    public function LlenarCamposModificar()
    {
        $IDevaluacion = $_GET['IDEvaluacion'];
        parent::setIdEvaluacion($IDevaluacion);

        $evaluacion = parent::BuscarEvaluacion();

        if ($evaluacion == null) {

            header("Location: /worksync/views/evaluacion/ModificarEvaluacion.php? mensaje=no existe una evaluacion con este id");
        } else {

            include(__DIR__ . '/../views/evaluacion/ModificarEvaluacion.php');
        }
    }

    public function ModificarEvaluacion()
    {

        $IDEvaluacion = $_POST['IDEvaluacion'];
        $IDTarea = $_POST['IDTarea'];
        $descripcion = $_POST['Descripcion'];
        $calificacion = $_POST['Calificacion'];

        parent::setIdEvaluacion($IDEvaluacion);
        parent::setIdTarea($IDTarea);
        parent::setDescripcion($descripcion);
        parent::setCalificacion($calificacion);

        parent::actualizar();
    }

    public function MostrarEvaluaciones()
    {
        $usuario = $_POST['Usuario'];
        $evaluaciones = parent::ConsultarTodos($usuario);
        if (empty($evaluaciones)) {
            header("Location: /worksync/views/evaluacion/BuscarEvaluacion.php? mensaje=No existe una evaluación para este usuario");
        }
        include(__DIR__ . '/../views/evaluacion/BuscarEvaluacion.php');
    }

    public function BuscarDesempenoPorTarea()
    {
        session_start();
        $usuario = $_SESSION['documento'];
        $fecha = $_POST['fecha'];

        
        parent::setUsuario($usuario);
        parent::setFecha($fecha);

        $tareasDesempeno = parent::BuscarDesempenoPorTarea();
        if (empty($tareasDesempeno)) {
            header("Location: /worksync/views/visualizar/visualizarEvaluacion.php? mensaje=No existe una evaluacion en esta fecha");
        }

        include(__DIR__ . '/../views/visualizar/visualizarEvaluacion.php');
    }
}

$metodo = $_GET['metodo'];
$evaluacion = new EvaluacionController;

switch ($metodo) {

    case 'asignar':
        $evaluacion->AgregarEvaluacion();
        break;

    case 'LlenarDatos':
        $evaluacion->LlenarCamposModificar();
        break;

    case 'modificar':
        $evaluacion->ModificarEvaluacion();
        break;

    case 'BuscarEvaluaciones':
        $evaluacion->MostrarEvaluaciones();
        break;
    case 'buscarTareasYDesempeno':
        $evaluacion->BuscarDesempenoPorTarea();
        break;

    default:
        break;
}
