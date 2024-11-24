<?php
require_once __DIR__ . '/../models/EmpleadoModel.php';

class EmpleadoController {
    private $EmpleadoModel;

    public function __construct() {
        $this->EmpleadoModel = new EmpleadoModel();
    }

    public function mostrarLista() {
        return $this->EmpleadoModel->obtenerEmpleados();
    }
}
?>
