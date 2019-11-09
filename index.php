<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once "AutoLoader.php";
spl_autoload_register("myAutoLoader");


$controllerName = 'index';
$controllerAction = 'view';

if (isset($_GET['path'])) {
    $path = $_GET['path'];
    $pathParts = explode('/', $path);
    if (count($pathParts) > 0) {
        $controllerName = $pathParts[0];
    }

    if (count($pathParts) > 1) {
        $controllerAction = $pathParts[1];
    }
}

if ($controllerName == 'favicon.ico') {
    die();
}

if ($controllerName == 'index') {
    $controllerName = 'account';
}

$className = "SocialNetwork\\Controllers\\" . ucfirst($controllerName) . "Controller";
$controller = new $className();

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $controllerAction = 'get' . ucfirst($controllerAction);
} elseif ($_SERVER["REQUEST_METHOD"] === "POST") {
    $controllerAction = 'post' . ucfirst($controllerAction);
} else {
    die('Not supported method');
}

call_user_func_array(array($controller, $controllerAction), array());
