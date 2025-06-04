<?php
require_once '../app/controllers/TaskController.php';

$controller = new TaskController();

$action = $_GET['action'] ?? 'index';

if (method_exists($controller, $action)) {
    $controller->$action();
} else {
    echo "Action not found.";
}
