<?php

require_once(__DIR__ . '/../config/DB.php');

class UsuarioModel extends DB
{

    protected $documento;
    protected $nombre;
    protected $correo;
    protected $rol;
    protected $clave;
    protected $estado;


    public function Agregar()
    {

        $connection = parent::crearConexion();

        try {

            $stm = $connection->prepare(
                "INSERT INTO usuarios (documento, nombre, correo,rol, clave,estado)
                VALUES (:documento, :nombre, :correo, :rol , :clave, 1)"
            );

            $stm->execute(
                [
                    ':documento'=> $this->documento,
                    ':nombre'=> $this->nombre,
                    'correo'=> $this->correo,
                    ':rol'=>$this->rol,
                    'clave'=> $this->clave

                ]
            );

            header("Location: /worksync/views/usuarios/AgregarUsuarios.php? mensaje=Usuario creado exitosamente");
        } catch (PDOException $ex) {

            header("Location: /worksync/views/usuarios/AgregarUsuarios.php? mensaje=Algo ha salido mal");
        } finally {

            parent::cerrarConexion($connection);
        }
    }

    public function BuscarUsuario()
    {
        $connection = parent::crearConexion();

        try {

            $Usuario = $connection->query('SELECT * FROM usuarios WHERE documento =' . $this->documento)->fetch();

            if($Usuario){
            
                return $Usuario;
            
            }else{
                
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
                "UPDATE usuarios
                SET nombre = :nombre,
                    correo = :correo,
                    rol = :rol,
                    clave = :clave
                WHERE documento = :documento"
                
            );

            $stm->execute(
                [
                    ':nombre' => $this->nombre,
                    ':correo' => $this->correo,
                    ':rol' => $this->rol,
                    ':clave' => $this->clave,
                    ':documento' => $this->documento
                ]
            );

            header("Location: /worksync/views/usuarios/ActualizarUsuarios.php? mensaje=Usuario actualizado exitosamente");

        } catch (PDOException $ex) {

            header("Location: /worksync/views/usuarios/ActualizarUsuarios.php? mensaje=Algo ha salido mal");

        } finally {

            parent::cerrarConexion($connection);
        }
    }

    public function Desactivar(){
        
        $connection = parent::crearConexion();

        try {

            $stm = $connection->prepare(
                "UPDATE usuarios
                SET estado = :estado
                WHERE documento = :documento"
                
            );

            $stm->execute(
                [
                    ':estado' => '0',
                    ':documento' => $this->documento
                ]
            );

            header("Location: /worksync/views/usuarios/DesactivarUsuarios.php? mensaje=Usuario desactivado exitosamente");

        } catch (PDOException $ex) {

            header("Location: /worksync/views/usuarios/DesactivarUsuarios.php? mensaje=Algo ha salido mal".$ex->getMessage());

        } finally {

            parent::cerrarConexion($connection);
        }
    }




    public function Activar(){
        
        $connection = parent::crearConexion();

        try {

            $stm = $connection->prepare(
                "UPDATE usuarios
                SET estado = :estado
                WHERE documento = :documento"
                
            );  

            $stm->execute(
                [
                    ':estado' => '1',
                    ':documento' => $this->documento
                ]
            );

            header("Location: /worksync/views/usuarios/DesactivarUsuarios.php? mensaje=Usuario activado exitosamente");

        } catch (PDOException $ex) {

            header("Location: /worksync/views/usuarios/DesactivarUsuarios.php? mensaje=Algo ha salido mal");

        } finally {

            parent::cerrarConexion($connection);
        }
    }





    public function setDocumento($documento)
    {
        $this->documento = $documento;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function setCorreo($correo)
    {
        $this->correo = $correo;
    }

    public function setRol($rol)
    {
        $this->rol = $rol;
    }

    public function setClave($clave)
    {
        $this->clave = $clave;
    }

    public function setEstado($estado)
    {
        $this->estado = $estado;
    }
}


