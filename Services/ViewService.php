<?php


namespace Services;


class ViewService
{
  private $content;

  public function render(string $content, string $path) : void {
    if (!file_exists($path)){
      throw new \Exception("Template doesn't exist!");
    }
    include ($path);
  }

  public function renderContentArray(array $content, string $path) : void {
    if (!file_exists($path)){
      throw new \Exception("Template doesn't exist!");
    }
    include ($path);
  }

}