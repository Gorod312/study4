<?php
session_start();
use app\service\Request;
use app\service\TwigRender;
require_once dirname(__DIR__) . '/vendor/autoload.php';

/**
 * @var \app\controllers\Controller $controller
 */

$enter = new Request();
$controllerName = $enter->getControllerName() ?: 'main';
$actionName = $enter->getActionName();

$controllerClass = "app\\controllers\\" . ucfirst($controllerName) . "Controller";
if (class_exists($controllerClass)) {
    $controller = new $controllerClass(new TwigRender());
    $controller->runAction($actionName);
}