<?php

namespace Model;

class RouteData {

  private $route;
  private $controller;
  private $action;
  private $services;

  public function __construct(string $route, string $controller, string $action, array $services) {
    $this->route = $route;
    $this->controller = $controller;
    $this->action = $action;
    $this->services = $services;
  }

  public function getRoute(): string {
    return $this->route;
  }

  public function getController(): string {
    return $this->controller;
  }

  public function getAction(): string {
    return $this->action;
  }

  public function getServices(): array {
    return $this->services;
  }

  public function setRoute(string $route): void {
    $this->route = $route;
  }

  public function setController(string $controller): void {
    $this->controller = $controller;
  }

  public function setAction(string $action): void {
    $this->action = $action;
  }

  public function setServices(array $services): void {
    $this->services = $services;
  }
}