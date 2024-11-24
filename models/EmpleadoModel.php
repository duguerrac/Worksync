<?php
require_once(__DIR__ . '/../config/DB.php');

class EmpleadoModel {
    public $documento;
    public $nombre;
    public $correo;
    public $rol;
    public $clave;
    public $estado;

    private $db;

    public function __construct() {
        $this->db = (new DB())->crearConexion();
    }
    
    public function obtenerEmpleados() {
        $sql = "SELECT * FROM usuarios WHERE rol = 2";
        $resultado = $this->db->query($sql);
    
        if ($resultado === false) {
            die("Error al ejecutar la consulta: " . $this->db->error);
        }
    
        $usuarios = array();
        while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)) { // Cambio aquí
            $usuario = new EmpleadoModel();
            $usuario->documento = $fila['documento'];
            $usuario->nombre = $fila['nombre'];
            $usuario->correo = $fila['correo'];
            $usuarios[] = $usuario;
        }
    
        $resultado->closeCursor(); // Cerrar el cursor
        return $usuarios;
    }
    
}
?>
