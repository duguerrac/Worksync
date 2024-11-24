<?php
require_once(__DIR__ . '/../models/SolicitudModel.php');

class SolicitudController extends SolicitudModel {
    private $SolicitudModel;

    public function AgregarSolicitud()
    {

        session_start();
        $descripcion = $_POST['descripcion'];
        $tipo = $_POST['tipo'];
        $documentoUsuario=$_SESSION['documento'];

        parent::setDescripcion($descripcion);
        parent::setTipo($tipo);
        parent::setDocumentoUsuario($documentoUsuario);
        parent::Agregar();
    }


    public function __construct() {
        $this->SolicitudModel = new SolicitudModel();
    }

    public function mostrarSolicitudes(){
        return $this->SolicitudModel->obtenerSolicitudes();
    }

    public function mostrarSolicitudesPorUsuario() {
        return $this->SolicitudModel->obtenerSolicitudesPorUsuario();
    }

    public function BuscarSolicitudDeTurno()
    {
        $usuario = $_POST['documento'];
        $solicitudes = parent::BuscarSolicitudTurno($usuario);
        include(__DIR__ . '/../views/solicitudesAdmin/verSolicitudCambioTurno.php');
    }

    public function BuscarSolicitudDeTarea()
    {
        $documento = $_POST['documento'];
        $solicitudes = parent::BuscarSolicitudTarea($documento);
        include(__DIR__ . '/../views/solicitudesAdmin/verSolicitudCambioTarea.php');
    }
}
$metodo = $_GET['metodo'];
$solicitud = new SolicitudController();

switch ($metodo) {
    case 'agregar':
        $solicitud->AgregarSolicitud();
        break;
    case 'buscarParaTurno':
        $solicitud->BuscarSolicitudDeTurno();
        break;
    case 'buscarParaTarea':
        $solicitud->BuscarSolicitudDeTarea();
        break;
    default:
        break;
}
?>
