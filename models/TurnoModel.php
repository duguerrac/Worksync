<?php

require_once(__DIR__ . '/../config/DB.php');

class TurnoModel extends DB {
    protected $fecha;
    protected $usuario;
    protected $id_turno;
    protected $descripcion;
    protected $db;

    public function obtenerTurnosPorUsuario() {
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
            $turno = array();
    
            // Iterar sobre los resultados y crear objetos solicitudModel
            while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $turno = new TurnoModel();
                $turno->id_turno = $fila['idTurno'];
                $turno->fecha = $fila['fecha'];
                $turno->descripcion = $fila['descripcion'];
                $turnos[] = $turno;
            }
    
            // Cerrar el cursor
            $stmt->closeCursor();
    
            return $turnos;
        } else {
            echo "No se ha configurado el documento del usuario en la variable de sesión.";
            return array(); // Devolver un array vacío si la variable de sesión 'documento' no está configurada
        }
    }

    public function ValidarUsuario(){

        $connection = parent::crearConexion();

        try {

            $usuario = $connection->query('SELECT * FROM USUARIOS WHERE DOCUMENTO =' . $this->usuario)->fetch();

            if($usuario){
            
                return true;
            
            }else{
                
                return false;

            }

        } catch (PDOException $e) {

            echo ('Algo ha salido mal');

        } finally {

            parent::cerrarConexion($connection);
        }
    }

    public function BuscarTurnosPorFecha() {
        $connection = parent::crearConexion();
        try {
            $stm = $connection->prepare('SELECT * FROM turnos WHERE documentoUsuario = :usuario AND fecha = :fecha');
            $stm->execute([
                ':usuario' => $this->usuario,
                ':fecha' => $this->fecha
            ]);
            return $stm->fetchAll();
        } catch (PDOException $e) {
            echo 'Algo ha salido mal: ' . $e->getMessage();
        } finally {
            parent::cerrarConexion($connection);
        }
    }

    public function Agregar() {
        $connection = parent::crearConexion();
        try {
            $stm = $connection->prepare(
                "INSERT INTO TURNOS (fecha, descripcion, documentoUsuario)
                VALUES (:fecha, :descripcion, :usuario)"
            );
            $stm->execute([
                ':fecha' => $this->fecha,
                ':descripcion' => $this->descripcion,
                ':usuario' => $this->usuario
            ]);
            header("Location: /worksync/views/turno/CrearTurno.php?mensaje=Turno creado exitosamente");
        } catch (PDOException $ex) {
            header("Location: /worksync/views/turno/CrearTurno.php?mensaje=Algo ha salido mal");
        } finally {
            parent::cerrarConexion($connection);
        }
    }

    public function BuscarTurno() {
        $connection = parent::crearConexion();
        try {
            $turno = $connection->query('SELECT * FROM TURNOS WHERE IDTURNO = ' . $this->id_turno)->fetch();
            return $turno ?: null;
        } catch (PDOException $e) {
            echo 'Algo ha salido mal';
        } finally {
            parent::cerrarConexion($connection);
        }
    }

    public function BuscarTurnosEmpleado() {
        $connection = parent::crearConexion();
        try {

            $turnos = $connection->query('SELECT * FROM turnos WHERE documentoUsuario = ' . $this->usuario)->fetchAll();
            
            if (empty($turnos)){
                header("Location: /worksync/views/turno/BuscarTurno.php? mensaje=No tiene turnos");
            }

            return $turnos;
            
        } catch (PDOException $e) {
            echo 'Algo ha salido mal';
        } finally {
            parent::cerrarConexion($connection);
        }
    }


    public function Actualizar() {
        $connection = parent::crearConexion();
        try {
            $stm = $connection->prepare(
                "UPDATE TURNOS
                SET fecha = :fecha,
                    descripcion = :descripcion,
                    documentoUsuario = :usuario
                WHERE idTurno = :idTurno"
            );
            $stm->execute([
                ':fecha' => $this->fecha,
                ':descripcion' => $this->descripcion,
                ':usuario' => $this->usuario,
                ':idTurno' => $this->id_turno
            ]);
            header("Location: /worksync/views/turno/ModificarTurno.php?mensaje=Turno actualizado exitosamente");
        } catch (PDOException $ex) {
            header("Location: /worksync/views/turno/ModificarTurno.php?mensaje=Algo ha salido mal");
        } finally {
            parent::cerrarConexion($connection);
        }
    }

    public function Eliminar() {
        $connection = parent::crearConexion();
        try {
            $stm = $connection->prepare("DELETE FROM TURNOS WHERE idTurno = :idTurno");
            $stm->execute([':idTurno' => $this->id_turno]);
            header("Location: /worksync/views/turno/EliminarTurno.php?mensaje=Turno eliminado exitosamente");
        } catch (PDOException $ex) {
            header("Location: /worksync/views/turno/EliminarTurno.php?mensaje=Algo ha salido mal");
        } finally {
            parent::cerrarConexion($connection);
        }
    }

    public function setId_turno($id_turno) {
        $this->id_turno = $id_turno;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    public function setUsuario($usuario) {
        $this->usuario = $usuario;
    }
}
?>