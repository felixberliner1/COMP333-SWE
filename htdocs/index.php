<?php
require __DIR__ . "/inc/bootstrap.php";

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

if (!isset($uri[2]) || !isset($uri[3])) {
    header("HTTP/1.1 404 Not Found");
    exit();
}

$controllerName = ucfirst($uri[2]) . 'Controller';
$controllerFile = PROJECT_ROOT_PATH . "/Controller/Api/" . $controllerName . ".php";

if (!file_exists($controllerFile)) {
    header("HTTP/1.1 404 Not Found");
    exit();
}

require $controllerFile;
$controller = new $controllerName();
$strMethodName = $uri[3] . 'Action';
$controller->{$strMethodName}();