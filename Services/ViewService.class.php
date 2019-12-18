<?php


namespace Services;


class ViewService
{
  private $content;

  public function getContent()
  {
    return $this->content;
  }

  public function setContent($content)
  {
    $this->content = $content;
  }

  function __construct() {
  }

  public function render(string $content, string $path) {
    if (!file_exists($path)){
      return;
    }
    include ($path);
  }

  public function renderContentArray(array $content, string $path) {
    if (!file_exists($path)){
      return;
    }
    include ($path);
  }

}