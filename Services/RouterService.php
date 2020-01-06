<?php

namespace Services;

use Controller\ControllerFactory;
use Model\RouteData;

class RouterService {

  private $routes = array();
  private $factoryController;

  private function findObjectByRoute (string $route) :?RouteData {

    foreach ( $this->routes as $routeData ) {
      if ( $route == $routeData->getRoute() ) {
        return $routeData;
      }
    }
    return null;
  }

  //ovaj kontroler je bolje da posaljem u konstruktoru nego da ga kreiram u f-ji pri koriscenju?
  public function __construct(ControllerFactory $factoryController) {
    $this->factoryController = $factoryController;
  }

  //RouteData mi je klasa(model, tip) podataka koje saljem i primam prilikom registrovanja rute,
  //kod ServiceContainer-a nisam koristio neki moj tip podataka, jer u nizu cuvam samo jednu promenljivu prilikom registrovanja
  public function registerRoute(RouteData $data) {
    array_push($this->routes, $data);
  }

  public function execute(string $route) {
    //nalazenje kontrolera iz niza registrovanih kontrolera
    $routeObj = $this->findObjectByRoute($route);

    //kreiranje kontrolera i izvrsavanje akcije
    if($routeObj !== null) {
      $controller = $this->factoryController->createController($routeObj->getController(), $routeObj->getServices());

      $action = $routeObj->getAction();
      $controller->$action();
    }
    //ovde mi pise kao unhandled exception a ja ga handlujem na jedinom mestu gde koristim execute, u index.php-u
    else {
      throw new \Exception("Route is missing!!!");
    }
  }
}
