<?php

require_once(__DIR__ . '/../models/TareaModel.php');

class TareaController extends TareaModel
{
    private $TareaModel;

    public function __construct() {
        $this->TareaModel = new TareaModel();
    }

    public function AsignarTarea()
    {
        $IDTurno = $_POST['IDTurno'];
        $descripcion = $_POST['Descripcion'];
        $HoraInicio = $_POST['HoraInicio'];
        $HoraLimite = $_POST['HoraLimite'];

        parent::setIDTurno($IDTurno);
        parent::setDescripcion($descripcion);
        parent::setHoraInicio($HoraInicio);
        parent::setHoraLimite($HoraLimite);
        if (parent::ValidarTurno()) {

            parent::Agregar();

        }else{

            header("Location: /worksync/views/tarea/AsignarTarea.php? mensaje=No existe un turno con este id");
        }
    }

    public function LlenarCamposActualizar()
    {
        $idtarea = $_GET['IDTarea'];
        parent::setIdTarea($idtarea);

        $tarea = parent::BuscarTarea();

        if ($tarea == null) {

            header("Location: /worksync/views/tarea/ModificarTarea.php? mensaje=no existe una tarea con este id");

        } else {

            include(__DIR__ . '/../views/tarea/ModificarTarea.php');
        }
    }

    public function LlenarCamposEliminar()
    {
        $idtarea = $_GET['IDTarea'];
        parent::setIdTarea($idtarea);

        $tarea = parent::BuscarTarea();

        if ($tarea == null) {

            header("Location: /worksync/views/tarea/DesactivarTarea.php? mensaje=no existe una tarea con este id");

        } else {

            include(__DIR__ . '/../views/tarea/DesactivarTarea.php');
        }
    }

    public function ActualizarTarea()
    {
        $IDTurno = $_POST['IDTurno'];
        $idtarea = $_POST['IDTarea'];
        $descripcion = $_POST['Descripcion'];
        $HoraInicio = $_POST['HoraInicio'];
        $HoraLimite = $_POST['HoraLimite'];

        parent::setIDTurno($IDTurno);
        parent::setIdTarea($idtarea);
        parent::setDescripcion($descripcion);
        parent::setHoraInicio($HoraInicio);
        parent::setHoraLimite($HoraLimite);
        if (parent::ValidarTurno()) {
         
            parent::Actualizar();
        
        }else{

            header("Location: /worksync/views/tarea/ModificarTarea.php? mensaje=No existe un turno con este id");
        }
    }

    public function EliminarTarea()
    {
        $IDTarea = $_POST['IDTarea'];

        parent::setIdTarea($IDTarea);
        if (parent::BuscarTarea()!=null) {
            
            parent::Eliminar();

        }else{

            header("Location: /worksync/views/tarea/DesactivarTarea.php? mensaje=No existe una tarea con este id");
        }
    }
    public function BuscarTareaTodos()
    {
        $usuario = $_POST['Usuario'];
        $tareas = parent::BuscarTareasEmpleado($usuario);
        include(__DIR__ . '/../views/tarea/BuscarTarea.php');
    }
    public function BuscarTareaFecha()
    {
        session_start();
        $usuario = $_SESSION['documento'];
        $fecha = $_POST['fecha'];

        $this->TareaModel->setUsuario($usuario);
        $this->TareaModel->setFecha($fecha);

        $tareas = $this->TareaModel->BuscarTareasPorFecha();
        if (empty($tareas)) {
            header("Location: /worksync/views/visualizar/visualizarTarea.php? mensaje=No existe una tarea en esta fecha");
        }


        include(__DIR__ . '/../views/visualizar/visualizarTarea.php');
    }

}

$metodo = $_GET['metodo'];
$tarea = new TareaController();

switch ($metodo) {

    case 'asignar':
        $tarea->AsignarTarea();
        break;

    case 'buscar':
        $tarea->LlenarCamposActualizar();
        break;

    case 'modificar':
        $tarea->ActualizarTarea();
        break;

    case 'BuscarEliminar':
        $tarea->LlenarCamposEliminar();
        break;

    case 'eliminar':
        $tarea->EliminarTarea();
        break;
        
    case 'BuscarTarea':
        $tarea->BuscarTareaTodos();
        break;

    case 'BuscarTareaFecha':
        $tarea->BuscarTareaFecha();
        break;

    default:
        break;
}
