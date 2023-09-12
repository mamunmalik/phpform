<?php
// require_once('../app/libraries/Database.php');
// require_once('../app/models/PaymentModel.php');
// require_once('../app/controllers/PaymentController.php');

$controller = new PaymentController();

if (isset($_GET['url'])) {
    $url = explode('/', $_GET['url']);
    $controllerName = ucfirst($url[0]) . 'Controller';
    $actionName = $url[1] ?? 'index';
} else {
    $controllerName = 'PaymentController';
    $actionName = 'index';
}

$controller->$actionName();
