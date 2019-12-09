<?php

// sa autoloadom ide ovako, bez ne treba
use Controller\NoteController;

$session = new SessionService();
$session->init();

$database = new DatabaseService();
$database->connect();

  try {
    switch ($_SERVER['PATH_INFO']) {
      case '/note/edit':
        require_once 'Controller/NoteController.php';
        $controller = new NoteController($database);
        $controller->edit();

      case '/note/delete':
        // sa autoloadom
        $controller = new NoteController($database);
        $controller->edit();


      case '/login':
        // sa autoloadom
        $controller = new UserController($session);
        $controller->login();

    }
  } catch (\Exception $exception) {
    ...
  }

  $session->close();

// pogledaj PHP autoload i namespaces