<?php
include 'autoloader.php';

include 'services.php';
include 'routes.php';

try {
  //iz nekog razloga, ako odem na stranu http://localhost/crud/index.php meni u $_SERVER-u uopste ne postoji promenljiva PATH_INFO
  //a kada na kraj dodam / http://localhost/crud/index.php/ onda postoji i radi sve super
  // a na onom prethodnom mi je bilo http://localhost/crud/index.php i radilo je sve , pa me zanima znas li mozda sta je problem
  $router->execute($_SERVER['PATH_INFO']);
} catch (Exception $e) {
  echo "ERROR => ".$e;
}



