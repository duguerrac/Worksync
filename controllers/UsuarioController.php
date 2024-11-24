<?php

require_once(__DIR__ . '/../models/UsuarioModel.php');

class UsuarioController extends UsuarioModel
{


    public function CrearUsuario()
    {

        $documento = $_POST['documento'];
        $nombre = $_POST['nombre'];
        $correo = $_POST['correo'];
        $rol = $_POST['rol'];
        $clave = $_POST['clave'];
        $estado = 1;

        parent::setDocumento($documento);
        parent::setNombre($nombre);
        parent::setCorreo($correo);
        parent::setRol($rol);
        parent::setClave($clave);
        parent::setEstado($estado);

        parent::Agregar();
    }

    public function Actualizar()
    {
        $documento = $_POST['documento'];
        $nombre = $_POST['nombre'];
        $correo = $_POST['correo'];
        $rol = $_POST['rol'];
        $clave = $_POST['clave'];
        $estado = 1;

        parent::setDocumento($documento);
        parent::setNombre($nombre);
        parent::setCorreo($correo);
        parent::setRol($rol);
        parent::setClave($clave);
        parent::setEstado($estado);


        parent::Actualizar();
    }

    public function Activar()
    {
        $documento = $_GET['documento'];

        parent::setDocumento($documento);

        parent::activar();
    }


    public function Desactivar()
    {
        $documento = $_GET['documento'];

        parent::setDocumento($documento);

        parent::Desactivar();
    }


    public function BuscarUsuarioAD()
    {
        $documento = $_GET['documento'];
        parent::setDocumento($documento);
        $documento = parent::BuscarUsuario();
        if ($documento == null) {
            header("Location: /worksync/views/usuarios/DesactivarUsuarios.php? mensaje=Este usuario no existe");
        } else {
            include(__DIR__ . '/../views/usuarios/DesactivarUsuarios.php');
        }
    }


    public function LlenarCamposActualizar()
    {
        $documento = $_GET['documento'];
        parent::setDocumento($documento);
        $documento = parent::BuscarUsuario();
        if ($documento == null) {
            header("Location: /worksync/views/usuarios/ActualizarUsuarios.php? mensaje=Este usuario no existe");
        } else {
            include(__DIR__ . '/../views/usuarios/ActualizarUsuarios.php');
        }
    }

   public function BuscarUsuario()
    {
        $documento = $_GET['documento'];
        parent::setDocumento($documento);
        $documento = parent::BuscarUsuario();
        if ($documento == null) {
            header("Location: /worksync/views/usuarios/BuscarUsuarios.php? mensaje=Este usuario no existe");
        } else {
            include(__DIR__ . '/../views/usuarios/BuscarUsuarios.php');
        }
    }

    public function LlenarCamposDesactivar()
    {
        $documento = $_GET['documento'];
        parent::setDocumento($documento);
        $documento = parent::BuscarUsuario();

        include(__DIR__ . '/../views/usuarios/DesactivarUsuarios.php');
    }
}

$metodo = $_GET['metodo'];
$usuario = new UsuarioController();

switch ($metodo) {

    case 'agregar':
        $usuario->CrearUsuario();
        break;

    case 'buscar':
        $usuario->LlenarCamposActualizar();
        break;

    case 'modificar':
        $usuario->Actualizar();
        break;


    case 'BuscarDesactivar':
        $usuario->LlenarCamposDesactivar();
        break;

    case 'Desactivar':
        $usuario->Desactivar();
        break;

    case 'BuscarActivar':
        $usuario->LlenarCamposActualizar();
        break;

    case 'Activar':
        $usuario->Activar();
        break;

    case 'buscarUsuario';
        $usuario->BuscarUsuario();
        break;

    case 'buscarUsuarioAD';
        $usuario->buscarUsuarioAD();
        break; 
    default:
        break;
}
