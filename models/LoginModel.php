<?php

require_once(__DIR__ . '/../config/DB.php');

class LoginModel extends DB {
    private $documento;
    private $nombre;
    private $correo;
    private $rol;
    private $clave;
    private $estado;
    private $db;

        
public function __construct() {
    $this->db = (new DB())->crearConexion();
}
        
public function login($documento, $clave) {
    $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE documento = :documento AND clave = :clave");
    $stmt->bindParam(':documento', $documento);
    $stmt->bindParam(':clave', $clave);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
}
?>
