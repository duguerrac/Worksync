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

// Función para manejar un único alert
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
        usleep(500000); // Pausa breve tras cerrar el alert
        return $alertText;
    } catch (Exception $e) {
        logResult("No se encontró ningún alert: " . $e->getMessage());
        return null;
    }
}

try {
    logResult("Iniciando pruebas de modificación de turnos...");

    // **Caso 1: Modificar un turno válido**
    logResult("Ejecutando Caso 1: Modificar un turno válido.");
    $driver->get('http://localhost/worksync/views/turno/ModificarTurno.php');
    $driver->wait(10)->until(
        WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::name('id_turno'))
    );
    $driver->findElement(WebDriverBy::name('id_turno'))->sendKeys('6'); // ID válido
    $driver->findElement(WebDriverBy::xpath("//button[text()='Buscar']"))->click();
    logResult("Se envió la solicitud para buscar el turno válido.");

    $driver->wait(10)->until(
        WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::name('fecha'))
    );
    logResult("Los campos del turno se llenaron correctamente tras la búsqueda.");

    // Actualizar los campos
    $driver->findElement(WebDriverBy::name('fecha'))->clear();
    $driver->findElement(WebDriverBy::name('fecha'))->sendKeys('2024-12-20');
    $driver->findElement(WebDriverBy::name('descripcion'))->clear();
    $driver->findElement(WebDriverBy::name('descripcion'))->sendKeys('Turno modificado automáticamente');
    $driver->findElement(WebDriverBy::name('Usuario'))->clear();
    $driver->findElement(WebDriverBy::name('Usuario'))->sendKeys('110121');
    $driver->findElement(WebDriverBy::xpath("//button[text()='Actualizar']"))->click();
    logResult("Formulario enviado para actualizar el turno.");

    handleSingleAlert($driver); // Manejar el alert

    // Validar redirección
    $currentURL = $driver->getCurrentURL();
    if (strpos($currentURL, 'ModificarTurno.php') !== false) {
        logResult("Caso 1 pasado: La página se redirigió correctamente.");
    } else {
        logResult("Caso 1 fallido: La página no se redirigió correctamente.");
    }

    // **Caso 2: Buscar un turno inexistente**
    logResult("Ejecutando Caso 2: Buscar un turno inexistente.");
    $driver->get('http://localhost/worksync/views/turno/ModificarTurno.php');
    $driver->findElement(WebDriverBy::name('id_turno'))->sendKeys('999'); // ID inexistente
    $driver->findElement(WebDriverBy::xpath("//button[text()='Buscar']"))->click();
    logResult("Se envió la solicitud para buscar un turno inexistente.");

    $alertText = handleSingleAlert($driver);
    if ($alertText && strpos($alertText, 'no existe') !== false) {
        logResult("Caso 2 pasado: Alert recibido indicando que el turno no existe.");
    } else {
        logResult("Caso 2 fallido: No se recibió el alert esperado.");
    }

    // **Caso 3: Intentar actualizar con datos inválidos**
    logResult("Ejecutando Caso 3: Intentar actualizar con datos inválidos.");
    $driver->get('http://localhost/worksync/views/turno/ModificarTurno.php');
    $driver->findElement(WebDriverBy::name('id_turno'))->sendKeys('6'); // ID válido
    $driver->findElement(WebDriverBy::xpath("//button[text()='Buscar']"))->click();
    logResult("Se envió la solicitud para buscar el turno válido.");

    $driver->wait(10)->until(
        WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::name('fecha'))
    );

    // Vaciar los campos y enviar el formulario
    $driver->findElement(WebDriverBy::name('fecha'))->clear();
    $driver->findElement(WebDriverBy::name('descripcion'))->clear();
    $driver->findElement(WebDriverBy::name('Usuario'))->clear();
    $driver->findElement(WebDriverBy::xpath("//button[text()='Actualizar']"))->click();
    logResult("Formulario enviado con datos inválidos.");

    $alertText = handleSingleAlert($driver);
    if ($alertText && strpos($alertText, 'Todos los campos son obligatorios') !== false) {
        logResult("Caso 3 pasado: Alert recibido indicando campos obligatorios faltantes.");
    } else {
        logResult("Caso 3 fallido: No se recibió el alert esperado.");
    }

    // **Caso 4: Intentar actualizar con un usuario inexistente**
    logResult("Ejecutando Caso 4: Intentar actualizar con un usuario inexistente.");
    $driver->get('http://localhost/worksync/views/turno/ModificarTurno.php');
    $driver->findElement(WebDriverBy::name('id_turno'))->sendKeys('6'); // ID válido
    $driver->findElement(WebDriverBy::xpath("//button[text()='Buscar']"))->click();
    logResult("Se envió la solicitud para buscar el turno válido.");

    $driver->wait(10)->until(
        WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::name('fecha'))
    );

    // Enviar datos con un usuario inexistente
    $driver->findElement(WebDriverBy::name('fecha'))->clear();
    $driver->findElement(WebDriverBy::name('fecha'))->sendKeys('2024-12-25');
    $driver->findElement(WebDriverBy::name('descripcion'))->clear();
    $driver->findElement(WebDriverBy::name('descripcion'))->sendKeys('Intento con usuario inválido');
    $driver->findElement(WebDriverBy::name('Usuario'))->clear();
    $driver->findElement(WebDriverBy::name('Usuario'))->sendKeys('999999');
    $driver->findElement(WebDriverBy::xpath("//button[text()='Actualizar']"))->click();
    logResult("Formulario enviado con un usuario inexistente.");

    $alertText = handleSingleAlert($driver);
    if ($alertText && strpos($alertText, 'No existe un usuario con este documento') !== false) {
        logResult("Caso 4 pasado: Alert recibido indicando que el usuario no existe.");
    } else {
        logResult("Caso 4 fallido: No se recibió el alert esperado.");
    }

} catch (Exception $e) {
    logResult("Error durante la prueba: " . $e->getMessage());
    $driver->takeScreenshot('error-screenshot-modify-turno.png'); // Captura en caso de error
} finally {
    $driver->quit();
    logResult("Pruebas de modificación de turnos finalizadas.");
}
