<?php
require_once(__DIR__ . '/../config/DB.php');

class SolicitudModel extends DB {
    private $db;
    public $idTurno;
    public $fecha;
    public $idSolicitudes;
    public $descripcion;
    public $tipo;
    public $documentoUsuario;

    public function __construct() {
        $this->db = parent::crearConexion();
    }

    public function BuscarSolicitudTurno($documento){

        $connection = parent::crearConexion();

        try {

            $solicitudes = $connection->query('SELECT * FROM SOLICITUDES 
                WHERE documentoUsuario = '.$documento . ' AND tipo = "turno"' ) ->fetchAll();

            if (empty($solicitudes)) {
                header("Location: /worksync/views/solicitudesAdmin/verSolicitudCambioTurno.php? mensaje=No tiene solicitudes");
            }
            return $solicitudes;

        } catch(PDOException $e) {

            header("Location: /worksync/views/solicitudesAdmin/verSolicitudCambioTurno.php? mensaje=Algo ha salido mal ");

        } finally {

            parent::cerrarConexion($connection);

        }

    }

    public function BuscarSolicitudTarea($documento){

        $connection = parent::crearConexion();

        try {

            $solicitudes = $connection->query('SELECT * FROM SOLICITUDES 
                WHERE documentoUsuario = '.$documento . ' AND tipo = "tarea"' ) ->fetchAll();

            if (empty($solicitudes)) {
                header("Location: /worksync/views/solicitudesAdmin/verSolicitudCambioTarea.php? mensaje=No tiene solicitudes");
            }
            return $solicitudes;

        } catch(PDOException $e) {
            header("Location: /worksync/views/solicitudesAdmin/verSolicitudCambioTarea.php? mensaje=Algo ha salido mal");
        } finally {

            parent::cerrarConexion($connection);

        }

    }

    public function Agregar()
    {

        $connection = parent::crearConexion();

        try {

            $stm = $connection->prepare(
                "INSERT INTO solicitudes (descripcion, tipo, documentoUsuario)
                VALUES (:descripcion, :tipo, :documentoUsuario)"
            );

            $stm->execute(
                [
                    ':descripcion'=> $this->descripcion,
                    ':tipo'=> $this->tipo,
                    ':documentoUsuario'=>$this->documentoUsuario
                ]
            );

            header("Location: /worksync/views/solicitudesEmpleado/solicitarCambio.php? mensaje=Solicitud enviada exitosamente");
        } catch (PDOException $ex) {

            header("Location: /worksync/views/solicitudesEmpleado/solicitarCambio.php? mensaje=Algo ha salido mal");
        } finally {

            parent::cerrarConexion($connection);
        }
    }

    public function obtenerSolicitudes(){
        session_start();
        $sql = "SELECT * FROM solicitudes";
        $resultado = $this->db->query($sql);
    
        if ($resultado === false) {
            die("Error al ejecutar la consulta: " . $this->db->error);
        }
    
        $solicitudes = array();
        while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)) { // Cambio aquí
            $solicitud = new solicitudModel();
            $solicitud->idSolicitudes = $fila['idSolicitudes'];
            $solicitud->descripcion = $fila['descripcion'];
            $solicitud->tipo = $fila['tipo'];
            $solicitud->documentoUsuario = $fila['documentoUsuario'];
            $solicitudes[] = $solicitud;
        }
    
        $resultado->closeCursor(); // Cerrar el cursor
        return $solicitudes;
    }

    public function obtenerSolicitudesPorUsuario() {
        session_start();
    
        // Verificar si la variable de sesión 'documento' está configurada
        if (isset($_SESSION['documento'])) {
            $documentoUsuario = $_SESSION['documento'];
    
            // Preparar la consulta SQL para obtener las solicitudes del usuario actual
            $sql = "SELECT * FROM turnos WHERE documentoUsuario = :documentoUsuario";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':documentoUsuario', $documentoUsuario, PDO::PARAM_STR);
            $stmt->execute();
    
            // Verificar si se ejecutó correctamente la consulta
            if ($stmt === false) {
                die("Error al ejecutar la consulta: " . $this->db->error);
            }
    
            // Crear un array para almacenar las solicitudes del usuario actual
            $solicitudes = array();
    
            // Iterar sobre los resultados y crear objetos solicitudModel
            while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $solicitud = new SolicitudModel();
                $solicitud->idTurno = $fila['idTurno'];
                $solicitud->fecha = $fila['fecha'];
                $solicitud->descripcion = $fila['descripcion'];
                $solicitudes[] = $solicitud;
            }
    
            // Cerrar el cursor
            $stmt->closeCursor();
    
            return $solicitudes;
        } else {
            echo "No se ha configurado el documento del usuario en la variable de sesión.";
            return array(); // Devolver un array vacío si la variable de sesión 'documento' no está configurada
        }
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    public function setDocumentoUsuario($documentoUsuario) {
        $this->documentoUsuario = $documentoUsuario;
    }

    // Getters (opcional, pero recomendado)
    public function getIdSolicitudes() {
        return $this->idSolicitudes;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function getDocumentoUsuario() {
        return $this->documentoUsuario;
    }
    
}
?>
