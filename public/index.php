<?php
session_start();

require_once __DIR__ . '/../app/config/Database.php';

// Controlador y acción por URL
$controller = $_GET['controller'] ?? 'auth';
$action     = $_GET['action'] ?? 'login';

$controllerName = ucfirst($controller) . 'Controller';
$controllerFile = __DIR__ . '/../app/controllers/' . $controllerName . '.php';

if (!file_exists($controllerFile)) {
    die("Controlador no encontrado: $controllerName");
}

require_once $controllerFile;

$controllerInstance = new $controllerName();

if (!method_exists($controllerInstance, $action)) {
    die("Acción no encontrada: $action");
}

$controllerInstance->$action();
