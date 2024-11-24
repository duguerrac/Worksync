<?php
require_once 'config/DB.php';
require_once 'models/LoginModel.php';
require_once 'controllers/LoginController.php';

$LoginController = new LoginController();

// Manejar la solicitud de login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $LoginController->login();
} elseif (isset($_GET['logout'])) {
    $LoginController->logout();
} else {
    include 'views/login/login.php';
}


?>
