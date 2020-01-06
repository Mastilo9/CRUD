<?php

namespace Containers;

class ServiceContainer {

  private $services = array();

  //samo zapamti podatke za servis, da ih posle iskoristis
  public function registerService(string $serviceName, callable $constructor) {
    $this->services[$serviceName] = $constructor;
  }

  //ovde dohvatim servis, ali prvo pozovem onu fju da se odradi pa vratim vec napravljen objekat
  public function getService(string $serviceName) {
    return $this->services[$serviceName]();
  }
}


