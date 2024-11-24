<?php

require_once(__DIR__ . '/../models/TurnoModel.php');

class TurnoController extends TurnoModel{
    private $TurnoModel;

    public function __construct() {
        $this->TurnoModel = new TurnoModel();
    }

    public function BuscarTurnoFecha() {
        session_start();
        $usuario = $_SESSION['documento'];
        $fecha = $_POST['fecha'];

        $this->TurnoModel->setUsuario($usuario);
        $this->TurnoModel->setFecha($fecha);
        $turnos = $this->TurnoModel->BuscarTurnosPorFecha();
        if (empty($turnos)) {
            header("Location: /worksync/views/visualizar/visualizarTurno.php? mensaje=No existe un turno en esta fecha");
        }
        include(__DIR__ . '/../views/visualizar/visualizarturno.php');
    }

    public function CrearTurno() {
        $fecha = $_POST['fecha'];
        $descripcion = $_POST['descripcion'];
        $usuario = $_POST['Usuario'];
        $this->TurnoModel->setFecha($fecha);
        $this->TurnoModel->setDescripcion($descripcion);
        $this->TurnoModel->setUsuario($usuario);
        if ($this->TurnoModel->ValidarUsuario()) {
            $this->TurnoModel->Agregar();
        }else{
            header("Location: /worksync/views/turno/CrearTurno.php?mensaje=No existe un usuario con este documento");
        }

    }

    public function ActualizarTurno() {
        $idTurno = $_POST['id_turno'];
        $fecha = $_POST['fecha'];
        $descripcion = $_POST['descripcion'];
        $usuario = $_POST['Usuario'];

        $this->TurnoModel->setId_turno($idTurno);
        $this->TurnoModel->setFecha($fecha);
        $this->TurnoModel->setDescripcion($descripcion);
        $this->TurnoModel->setUsuario($usuario);
        if ($this->TurnoModel->ValidarUsuario()) {
            $this->TurnoModel->Actualizar();
        }else{
            header("Location: /worksync/views/turno/ModificarTurno.php?mensaje=No existe un usuario con este documento");
        }
    }

    public function EliminarTurno() {
        $idTurno = $_POST['id_turno'];
        $this->TurnoModel->setId_turno($idTurno);
        if ($this->TurnoModel->BuscarTurno() != null) {
            $this->TurnoModel->Eliminar();
        }else{
            header("Location: /worksync/views/turno/EliminarTurno.php?mensaje=No existe un turno con este id");
        }
    }

    public function LlenarCamposActualizar() {
        $idTurno = $_GET['id_turno'];
        $this->TurnoModel->setId_turno($idTurno);
        $turno = $this->TurnoModel->BuscarTurno();
        if ($turno == null) {
            header("Location: /worksync/views/turno/ModificarTurno.php?mensaje=Este turno no existe");
        } else {
            include(__DIR__ . '/../views/turno/ModificarTurno.php');
        }
    }

    public function LlenarCamposEliminar() {
        $idTurno = $_GET['id_turno'];
        $this->TurnoModel->setId_turno($idTurno);
        $turno = $this->TurnoModel->BuscarTurno();
        include(__DIR__ . '/../views/turno/EliminarTurno.php');
    }

    public function BuscarTurnoTodos() {
        $usuario = $_POST['Usuario'];
        $this->TurnoModel->setUsuario($usuario);
        $turnos = $this->TurnoModel->BuscarTurnosEmpleado();
        include(__DIR__ . '/../views/turno/BuscarTurno.php');
    }

    public function mostrarTurnosPorUsuario() {
        parent::obtenerTurnosPorUsuario();
    }
}

$metodo = $_GET['metodo'];
$turno = new TurnoController();

switch ($metodo) {
    case 'agregar':
        $turno->CrearTurno();
        break;
    case 'buscar':
        $turno->LlenarCamposActualizar();
        break;
    case 'modificar':
        $turno->ActualizarTurno();
        break;
    case 'BuscarEliminar':
        $turno->LlenarCamposEliminar();
        break;
    case 'eliminar':
        $turno->EliminarTurno();
        break;
    case 'BuscarTurno':
        $turno->BuscarTurnoTodos();
        break;
    case 'BuscarTurnoFecha':
        $turno->BuscarTurnoFecha();
        break;
    default:
        break;
}
?>
