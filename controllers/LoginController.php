<?php

require_once(__DIR__ . '/../models/LoginModel.php');

class LoginController {

    private $LoginModel;

    public function __construct() {
        $this->LoginModel = new LoginModel();
    }

    public function login() {
        session_start();
    
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $documento = $_POST['documento'];
            $clave = $_POST['clave'];
    
            $usuario = $this->LoginModel->login($documento, $clave);
    
            if ($usuario) {
                if ($usuario['estado'] == 0) {
                    $error = "Usuario desactivado.";
                    include 'views/login/login.php';
                } else {
                    $_SESSION['documento'] = $usuario['documento'];
                    $_SESSION['nombre'] = $usuario['nombre'];
                    $_SESSION['rol'] = $usuario['rol'];
    
                    if ($usuario['rol'] == 1) {
                        header('Location: views/menus/menuAdmin.php');
                    } else if ($usuario['rol'] == 2) {
                        header('Location: views/menus/menuUser.php');
                    }
                    exit();
                }
            } else {
                $error = "Documento o clave incorrecta.";
                include 'views/login/login.php';
            }
        } else {
            include 'views/login/login.php';
        }
    }
    

    public function logout() {
        session_start();
        session_destroy();
        header('Location: index.php');
    }
}
?>

