<?php

class DB {

    private $dsn = 'mysql:dbname=worksync;host=127.0.0.1;port=3308';
    private $usuario = 'root';
    private $contrasegna = '';

    public function crearConexion() {

        try {

            return new PDO($this->dsn, $this->usuario, $this->contrasegna);

        } catch (PDOException $e) {

            echo "Falló la conexión a la base de datos: Código de error: " . $e->getCode() . "<br>";
            echo "Mensaje: " . $e->getMessage();
            die();

        }

    }

    public function cerrarConexion(&$conexion) {

        $conexion = null;

    }

}

?>