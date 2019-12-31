<?php


namespace Services;


class ViewService
{
  private $content;

  public function render(string $path ,array $content = array()) : void {
    if (!file_exists($path)){
      throw new \Exception("Template doesn't exist!");
    }

    include ($path);
  }

}