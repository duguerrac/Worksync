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
$logFile = 'test-delete-turno.log';

// Función para registrar resultados
function logResult($message) {
    global $logFile;
    echo $message . "\n";
    file_put_contents($logFile, $message . PHP_EOL, FILE_APPEND);
}


function handleSingleAlert($driver) {
    try {
        $driver->wait(5)->until(
            WebDriverExpectedCondition::alertIsPresent()
        );
        $alert = $driver->switchTo()->alert();
        $alertText = $alert->getText();
        logResult("Se encontró un alert: " . $alertText);
        $alert->accept(); // Cerrar el alert
        logResult("El alert fue cerrado exitosamente.");
        usleep(500000); 
        return $alertText;
    } catch (Exception $e) {
        logResult("No se encontró ningún alert: " . $e->getMessage());
        return null;
    }
}

try {
    logResult("Iniciando pruebas de eliminación de turnos...");

    // **Caso 1: Eliminar un turno válido**
    logResult("Ejecutando Caso 1: Eliminar un turno válido.");
    $driver->get('http://localhost/worksync/views/turno/EliminarTurno.php');
    $driver->wait(10)->until(
        WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::name('id_turno'))
    );
    $driver->findElement(WebDriverBy::name('id_turno'))->sendKeys('8');
    $driver->findElement(WebDriverBy::xpath("//button[text()='Eliminar']"))->click();
    logResult("Se envió la solicitud para eliminar el turno válido.");

    $alertText = handleSingleAlert($driver);
    if ($alertText && strpos($alertText, 'Turno eliminado exitosamente') !== false) {
        logResult("Caso 1 pasado: Alert recibido indicando que el turno fue eliminado.");
    } else {
        logResult("Caso 1 fallido: No se recibió el alert esperado.");
    }

    // **Caso 2: Intentar eliminar un turno inexistente**
    logResult("Ejecutando Caso 2: Intentar eliminar un turno inexistente.");
    $driver->get('http://localhost/worksync/views/turno/EliminarTurno.php'); 
    $driver->findElement(WebDriverBy::name('id_turno'))->sendKeys('999'); 
    $driver->findElement(WebDriverBy::xpath("//button[text()='Eliminar']"))->click(); 
    logResult("Se envió la solicitud para eliminar un turno inexistente.");

    $alertText = handleSingleAlert($driver);
    if ($alertText && strpos($alertText, 'No existe un turno con este ID') !== false) {
        logResult("Caso 2 pasado: Alert recibido indicando que el turno no existe.");
    } else {
        logResult("Caso 2 fallido: No se recibió el alert esperado.");
    }

} catch (Exception $e) {
    logResult("Error durante la prueba: " . $e->getMessage());
    $driver->takeScreenshot('error-screenshot-delete-turno.png'); 
} finally {
    $driver->quit();
    logResult("Pruebas de eliminación de turnos finalizadas.");
}
