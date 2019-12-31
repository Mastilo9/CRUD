<?php
include 'autoloader.php';

use Controller\IndexController;
use Controller\NoteController;
use Controller\UserController;
use Services\DatabaseService;
use Services\SessionService;
use Services\ViewService;

$session = new SessionService();
$session->init();

$database = new DatabaseService('localhost', 'root', 'root', 'crud');
try {
  $database->connect();
} catch (Exception $e) {
  echo "ERROR => ". $e;
}

try {
  switch ($_SERVER['PATH_INFO']) {
    case '/notes':
      $controller = new NoteController($database, $session, new ViewService());
      $controller->list();
      break;

    case '/notes/delete':
      $controller = new NoteController($database, $session);
      $controller->delete();
      break;

    case '/notes/edit':
      $controller = new NoteController($database, $session, new ViewService());
      $controller->edit();
      break;

    case '/notes/add':
      $controller = new NoteController($database, $session, new ViewService());
      $controller->add();
      break;

    case '' :
      $controller = new IndexController(new ViewService());
      $controller->home();
      break;

    case '/login':
      $controller = new UserController($database, $session, new ViewService());
      $controller->login();
      break;

    case '/logout':
      $controller = new UserController($database, $session);
      $controller->logout();
      break;

    case '/register':
      $controller = new UserController($database,$session, new ViewService());
      $controller->register();
      break;
  }
} catch (Exception $exception) {
  echo "Error => ". $exception;
}

