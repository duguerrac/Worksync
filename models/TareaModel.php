<?php

require_once(__DIR__ . '/../config/DB.php');

class TareaModel extends DB
{
    protected $idTarea;
    protected $horaInicio;
    protected $horaLimite;
    protected $descripcion;
    protected $idTurno;
    protected $fecha;
    protected $usuario;

    public function ValidarTurno(){

        $connection = parent::crearConexion();

        try {

            $turno = $connection->query('SELECT * FROM TURNOS WHERE IDTURNO =' . $this->idTurno)->fetch();

            if($turno){
            
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
    
    public function Agregar()
    {

        $connection = parent::crearConexion();

        try {

            $stm = $connection->prepare(
                "INSERT INTO TAREAS (horaInicio, horaLimite, descripcion, idTurno)
                VALUES (:horaInicio, :horaLimite, :descripcion, :idTurno)"
            );

            $stm->execute(
                [
                    ':horaInicio' => $this->horaInicio,
                    ':horaLimite' => $this->horaLimite,
                    ':descripcion' => $this->descripcion,
                    ':idTurno' => $this->idTurno
                ]
            );

            header("Location: /worksync/views/tarea/AsignarTarea.php? mensaje=Tarea asignada exitosamente");
        } catch (PDOException $e) {

            header("Location: /worksync/views/tarea/AsignarTarea.php? mensaje=Algo ha salido mal");
        } finally {

            parent::cerrarConexion($connection);
        }
    }

    public function BuscarTarea()
    {
        $connection = parent::crearConexion();

        try {

            $tarea = $connection->query('SELECT * FROM tareas WHERE idtarea =' . $this->idTarea)->fetch();

            if ($tarea) {

                return $tarea;
            } else {

                return null;
            }
        } catch (PDOException $e) {

            echo ('Algo ha salido mal');
        } finally {

            parent::cerrarConexion($connection);
        }
    }

    public function Actualizar()
    {

        $connection = parent::crearConexion();

        try {

            $stm = $connection->prepare(
                "UPDATE tareas
                SET idTurno = :idTurno,
                    horaInicio = :horaInicio,
                    horaLimite = :horaLimite,
                    descripcion = :descripcion
                WHERE idTarea = :idTarea"

            );

            $stm->execute(
                [
                    ':idTurno' => $this->idTurno,
                    ':horaInicio' => $this->horaInicio,
                    ':horaLimite' => $this->horaLimite,
                    ':descripcion' => $this->descripcion,
                    ':idTarea' => $this->idTarea
                ]
            );

            header("Location: /worksync/views/tarea/ModificarTarea.php? mensaje=tarea actualizado exitosamente");
        } catch (PDOException $ex) {

            header("Location: /worksync/views/tarea/ModificarTarea.php? mensaje=Algo ha salido mal");
        } finally {

            parent::cerrarConexion($connection);
        }
    }

    public function Eliminar()
    {

        $connection = parent::crearConexion();

        try {

            $stm = $connection->prepare(
                "DELETE FROM tareas
                WHERE idTarea = :idTarea"
            );

            $stm->execute(
                [
                    ':idTarea' => $this->idTarea
                ]
            );

            header("Location: /worksync/views/tarea/DesactivarTarea.php? mensaje=Tarea eliminado exitosamente");
        } catch (PDOException $ex) {

            header("Location: /worksync/views/tarea/DesactivarTarea.php? mensaje=Algo ha salido mal");
        } finally {

            parent::cerrarConexion($connection);
        }
    }

    public function BuscarTareasEmpleado($user){

        $connection = parent::crearConexion();

        try {

            $tareas = $connection->query('SELECT TA.*, T.documentousuario, T.fecha FROM TAREAS TA
                INNER JOIN TURNOS T ON T.IDTURNO = TA.IDTURNO
                WHERE documentoUsuario = '.$user)->fetchAll();

            return $tareas;

        } catch(PDOException $e) {

            echo ('Algo ha salido mal');

        } finally {

            parent::cerrarConexion($connection);

        }

    }

    public function BuscarTareasPorFecha() {
        $connection = parent::crearConexion();
        try {
            $stm = $connection->prepare('SELECT t.horaInicio, t.horaLimite, t.descripcion 
            FROM tareas t
            JOIN turnos tu ON t.idTurno = tu.idTurno
            WHERE tu.documentoUsuario = :usuario AND tu.fecha = :fecha');
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

    public function setIdTarea($idTarea)
    {
        $this->idTarea = $idTarea;
    }

    public function setHoraInicio($horaInicio)
    {
        $this->horaInicio = $horaInicio;
    }

    public function setHoraLimite($horaLimite)
    {
        $this->horaLimite = $horaLimite;
    }

    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    public function setIDTurno($idTurno)
    {
        $this->idTurno = $idTurno;
    }

    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    public function setUsuario($usuario) {
        $this->usuario = $usuario;
    }
    
}
