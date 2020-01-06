<?php

use Containers\ServiceContainer;
use Services\DatabaseService;
use Services\SessionService;
use Services\ViewService;

$container = new ServiceContainer();

$container->registerService(
  'database',
  function () {
    $database = new DatabaseService('localhost', 'root', 'root', 'crud');
    try {
      $database->connect();
    } catch (Exception $e) {
      echo "ERROR => ". $e;
    }
    return $database;
  }
);

$container->registerService(
  'session',
  function () {
    $session = new SessionService();
    $session->init();
    return $session;
  }
);

$container->registerService(
  'view',
  function () {
    return new ViewService();
  }
);
