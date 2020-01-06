<?php

namespace Controller;



use Containers\ServiceContainer;

class ControllerFactory
{
  private $serviceContainer;

  private function getServices(array $servicesNames) : array {
    $services = array();

    foreach ($servicesNames as $service) {
      $services[$service] = $this->serviceContainer->getService($service);
    }
    return $services;
  }

  public function __construct(ServiceContainer $serviceContainer) {
    $this->serviceContainer = $serviceContainer;
  }

  //kreira se novi kontroler, promenio sam da mi svaki kontroler prima niz servisa od kojih zavisi, lakse mi je bilo ovde
  //da implementiram, pa sam promenio u konstruktorima
  public function createController(string $controller, array $services)  {
    return new $controller($this->getServices($services));
  }

}