<?php

use Controller\ControllerFactory;
use Model\RouteData;
use Services\RouterService;

$router = new RouterService(new ControllerFactory($container));

$routeData = new RouteData('/notes', \Controller\NoteController::class, 'list', ['database', 'session', 'view']);
$router->registerRoute($routeData);

$routeData = new RouteData('/notes/delete', \Controller\NoteController::class, 'delete', ['database', 'session', 'view']);
$router->registerRoute($routeData);

$routeData = new RouteData('/notes/edit', \Controller\NoteController::class, 'edit', ['database', 'session', 'view']);
$router->registerRoute($routeData);

$routeData = new RouteData('/notes/add', \Controller\NoteController::class, 'add', ['database', 'session', 'view']);
$router->registerRoute($routeData);

$routeData = new RouteData('/', \Controller\IndexController::class, 'home', ['view']);
$router->registerRoute($routeData);

$routeData = new RouteData('/login', \Controller\UserController::class, 'login', ['database', 'session', 'view']);
$router->registerRoute($routeData);

$routeData = new RouteData('/register', \Controller\UserController::class, 'register', ['database', 'session', 'view']);
$router->registerRoute($routeData);

$routeData = new RouteData('/logout', \Controller\UserController::class, 'logout', ['database', 'session', 'view']);
$router->registerRoute($routeData);
