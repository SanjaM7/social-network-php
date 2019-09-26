<?php

session_start();
require_once realpath(dirname(__FILE__) . "/database/db.php");

/** AutoLoader */

spl_autoload_register("myAutoLoader");
function myAutoLoader($className)
{
    if (strpos($className, "Controller") !== false) {
        $path = "controllers/";
    } elseif (strpos($className, "Service") !== false) {
        $path = "services/";
    } elseif (strpos($className, "Repository") !== false) {
        $path = "repository/";
    } elseif (strpos($className, "Helper") !== false) {
        $path = "helpers/";
    } else {
        $path = "models/";
    }

    $fullPath = $path . $className . ".php";
    require_once $fullPath;
}

$controllerName = 'index';
$controllerAction = 'index';

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

$className = $controllerName . "Controller";
$controller = new $className();

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $controllerAction = 'GET_' . $controllerAction;
} else if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $controllerAction = 'POST_' . $controllerAction;
} else {
    die('Not supported method');
}

call_user_func_array(array($controller, $controllerAction), array());
