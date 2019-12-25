<?php
include 'autoloader.php';

use Controller\NoteController;
use Controller\UserController;
use Services\DatabaseService;
use Services\SessionService;
use Services\ViewService;

//var_dump($_SERVER);

$session = new SessionService();
$session->init();

$database = new DatabaseService('localhost', 'root', 'root', 'crud');
$database->connect();

  try {
    switch ($_SERVER['PATH_INFO']) {
      case '/notes':
        $controller = new NoteController($database, $session);
        $controller->list();
        break;

      case '/notes/delete':
        $controller = new NoteController($database, $session);
        $controller->delete();
        break;

      case '/notes/edit':
        $controller = new NoteController($database, $session);
        $controller->edit();
        break;

      case '/notes/add':
        $controller = new NoteController($database, $session);
        $controller->add();
        break;

      case '' :
        $viewService = new ViewService();
        $viewService->render("", 'Views/HomeRenderer.php');
        break;

      case '/login':
        $controller = new UserController($database, $session);
        $controller->login();
        break;

      case '/logout':
        $controller = new UserController($database, $session);
        $controller->logout();
        break;

      case '/register':
        $controller = new UserController($database,$session);
        $controller->register();
        break;
    }
  } catch (Exception $exception) {
    echo "Error => ". $exception;
  }

//  $session->close();

