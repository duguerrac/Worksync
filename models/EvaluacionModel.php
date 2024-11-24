<?php
require_once(__DIR__ . '/../config/DB.php');

class EvaluacionModel extends DB {
    private $idEvaluacion;
    private $descripcion;
    private $calificacion;
    private $idTarea;
    private $fecha;
    private $usuario;

    public function BuscarDesempenoPorTarea()
    {
        $connection = parent::crearConexion();
        try {
            $stm = $connection->prepare('SELECT t.descripcion AS tarea, e.descripcion AS evaluacion, e.calificacion 
                                        FROM tareas t 
                                        JOIN evaluacion e ON t.idTarea = e.idTarea
                                        JOIN turnos tn ON t.idTurno = tn.idTurno
                                        WHERE tn.fecha = :fecha AND tn.documentoUsuario = :usuario');
            $stm->execute([
                ':fecha' => $this->fecha,
                ':usuario' => $this->usuario
            ]);
            return $stm->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo 'Algo ha salido mal: ' . $e->getMessage();
        } finally {
            parent::cerrarConexion($connection);
        }
    }

    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }

    public function agregar(){

        $connection = parent::crearConexion();

        try {

            $stm = $connection->prepare(
                "INSERT INTO evaluacion (descripcion, calificacion, idtarea)
                VALUES ( :descripcion, :calificacion, :idtarea)"
            );

            $stm->execute(
                [
                    ':descripcion' => $this->descripcion,
                    ':calificacion' => $this->calificacion,
                    ':idtarea' => $this->idTarea
                ]
            );

            header("Location: /worksync/views/evaluacion/AgregarEvaluacion.php? mensaje=Evaluacion realizada exitosamente");

        } catch (PDOException $e) {

            header("Location: /worksync/views/evaluacion/AgregarEvaluacion.php? mensaje=Algo ha salido mal");

        } finally {

            parent::cerrarConexion($connection);
        }
    }

    public function BuscarEvaluacion()
    {
        $connection = parent::crearConexion();

        try {

            $evaluacion = $connection->query('SELECT * FROM evaluacion WHERE idevaluacion =' . $this->idEvaluacion)->fetch();

            if ($evaluacion) {

                return $evaluacion;
            } else {

                return null;
            }
        } catch (PDOException $e) {

            echo ('Algo ha salido mal');
        } finally {

            parent::cerrarConexion($connection);
        }
    }

    public function Actualizar(){

        $connection = parent::crearConexion();

        try {

            $stm = $connection->prepare(
                "UPDATE evaluacion
                SET idTarea = :idTarea,
                    descripcion = :descripcion,
                    calificacion = :calificacion
                WHERE idEvaluacion = :idEvaluacion"

            );

            $stm->execute(
                [
                    ':idTarea' => $this->idTarea,
                    ':descripcion' => $this->descripcion,
                    ':calificacion' => $this->calificacion,
                    ':idEvaluacion' => $this->idEvaluacion
                ]
            );

            header("Location: /worksync/views/Evaluacion/ModificarEvaluacion.php? mensaje=evaluacion actualizada exitosamente");
        } catch (PDOException $ex) {

            header("Location: /worksync/views/Evaluacion/ModificarEvaluacion.php? mensaje=Algo ha salido mal");
        } finally {

            parent::cerrarConexion($connection);
        }
    }

    public function ValidarTarea(){
        $connection = parent::crearConexion();

        try {

            $tarea = $connection->query('SELECT * FROM tareas WHERE IDTAREA =' . $this->idTarea)->fetch();

            if($tarea){
            
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

    public function ConsultarTodos($usuario){

        $connection = parent::crearConexion();

        try {

            $tareas = $connection->query('SELECT T.IDTAREA,T.DESCRIPCION AS descripcion_tarea, E.* FROM EVALUACION E
                INNER JOIN TAREAS T ON T.IDTAREA = E.IDEVALUACION
                INNER JOIN TURNOS TU ON TU.IDTURNO = T.IDTURNO
                WHERE documentoUsuario = '.$usuario)->fetchAll();

            return $tareas;


        } catch(PDOException $e) {

            echo ('Algo ha salido mal');

        } finally {

            parent::cerrarConexion($connection);

        }
    }


    public function setIdEvaluacion($idEvaluacion) {
        $this->idEvaluacion = $idEvaluacion;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function setCalificacion($calificacion) {
        $this->calificacion = $calificacion;
    }

    public function setIdTarea($idTarea) {
        $this->idTarea = $idTarea;
    }
}
?>