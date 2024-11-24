<?php
require_once 'vendor/autoload.php';

use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\WebDriverExpectedCondition;

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Configuración inicial
$host = 'http://localhost:4444/wd/hub'; 
$driver = RemoteWebDriver::create($host, DesiredCapabilities::chrome());
$logFile = 'test-results.log'; 

// Función para guardar resultados en el log
function logResult($message)
{
    global $logFile;
    echo $message . "\n";
    file_put_contents($logFile, $message . PHP_EOL, FILE_APPEND);
}

try {
    logResult("Iniciando prueba de login...");

    // Navegar al sitio de login
    $driver->get('http://localhost/worksync/index.php');
    logResult("Página cargada correctamente.");

    // Esperar que el campo 'documento' esté visible
    $driver->wait(10)->until(
        WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::id('documento'))
    );

    // **Caso 1: Login con credenciales válidas**
    $driver->findElement(WebDriverBy::name('documento'))->sendKeys('110121'); 
    $driver->findElement(WebDriverBy::name('clave'))->sendKeys('password1'); 
    $driver->findElement(WebDriverBy::id('loginButton'))->click();
    logResult("Formulario enviado con credenciales válidas.");

    // Validar redirección
    $url = $driver->getCurrentURL();
    if ($url === 'http://localhost/worksync/views/menus/menuUser.php') {
        logResult("Prueba exitosa: Login correcto con credenciales válidas.");
    } else {
        logResult("Prueba fallida: No se accedió al Dashboard con credenciales válidas.");
    }

    // Volver a la página de login para el siguiente caso
    $driver->navigate()->to('http://localhost/worksync/index.php');

    // **Caso 2: Login con credenciales inválidas**
    $driver->wait(10)->until(
        WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::id('documento'))
    );
    $driver->findElement(WebDriverBy::name('documento'))->sendKeys('usuario_invalido'); 
    $driver->findElement(WebDriverBy::name('clave'))->sendKeys('clave_invalida'); 
    $driver->findElement(WebDriverBy::id('loginButton'))->click();
    logResult("Formulario enviado con credenciales inválidas.");

    // Verificar mensaje de error
    $error = $driver->findElement(WebDriverBy::cssSelector('p'))->getText();
    if (strpos($error, 'Documento o clave incorrecta.') !== false) {
        logResult("Prueba exitosa: Mensaje de error mostrado correctamente para credenciales inválidas.");
    } else {
        logResult("Prueba fallida: Mensaje de error no mostrado para credenciales inválidas.");
    }

} catch (Exception $e) {
    logResult("Error durante la prueba: " . $e->getMessage());
    $driver->takeScreenshot('error-screenshot.png'); 
} finally {
    $driver->quit();
    logResult("Prueba finalizada.");
}
