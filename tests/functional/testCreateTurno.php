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

// Función para registrar resultados
function logResult($message) {
    global $logFile;
    echo $message . "\n";
    file_put_contents($logFile, $message . PHP_EOL, FILE_APPEND);
}

function handleAlertAfterRedirection($driver) {
    try {

        $driver->wait(10)->until(
            WebDriverExpectedCondition::alertIsPresent()
        );
        $alert = $driver->switchTo()->alert(); // Cambiar al alert
        $alertText = $alert->getText(); // Capturar el texto del alert
        logResult("Se encontró un alert: " . $alertText);
        $alert->accept(); // Cerrar el alert
        logResult("El alert fue cerrado exitosamente.");

        // Pausa adicional para sincronización
        usleep(500000); 
    } catch (Exception $e) {
        logResult("No se encontró ningún alert tras la redirección: " . $e->getMessage());
    }
}

try {
    logResult("Iniciando prueba de creación de turnos...");

    // Navegar al formulario de creación de turnos
    $driver->get('http://localhost/worksync/views/turno/CrearTurno.php');
    logResult("Página de creación de turnos cargada correctamente.");

    // **Caso 1: Crear turno válido**
    $driver->wait(10)->until(
        WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::name('fecha'))
    );
    $driver->findElement(WebDriverBy::name('fecha'))->sendKeys('2024-11-25'); 
    $driver->findElement(WebDriverBy::name('descripcion'))->sendKeys('Turno de prueba'); 
    $driver->findElement(WebDriverBy::name('Usuario'))->sendKeys('110121'); 
    $driver->findElement(WebDriverBy::id('crearTurnoButton'))->click(); 
    logResult("Formulario enviado con datos válidos.");

    handleAlertAfterRedirection($driver);

    // **Caso 2: Crear turno con usuario inexistente**
    $driver->get('http://localhost/worksync/views/turno/CrearTurno.php'); 
    logResult("Página de creación de turnos recargada correctamente para el segundo caso.");
    $driver->findElement(WebDriverBy::name('fecha'))->sendKeys('2024-11-26');
    $driver->findElement(WebDriverBy::name('descripcion'))->sendKeys('Turno no válido');
    $driver->findElement(WebDriverBy::name('Usuario'))->sendKeys('999999');
    $driver->findElement(WebDriverBy::id('crearTurnoButton'))->click();
    logResult("Formulario enviado con usuario inexistente.");


    handleAlertAfterRedirection($driver);

} catch (Exception $e) {
    logResult("Error durante la prueba: " . $e->getMessage());
    $driver->takeScreenshot('error-screenshot-create-turno.png'); 
} finally {
    $driver->quit();
    logResult("Prueba de creación de turnos finalizada.");
}
