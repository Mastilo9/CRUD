<?php


namespace Controller;


use Services\ViewService;

class IndexController
{
  private $view;

  public function __construct(ViewService $view){
    $this->view = $view;
  }

  public function home() : void {
    try {
      $this->view->render('Views/HomeRenderer.php');
    } catch (\Exception $e) {
      echo "Error => ". $e;
    }
  }

}