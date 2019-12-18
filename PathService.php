<?php
function getRelativeURL(string $file) :string {
  $fullPath = realpath($file);
  $fullPath = str_replace('\\', '/', $fullPath);
  $rootPath = $_SERVER['DOCUMENT_ROOT'];
  return str_replace($rootPath, '', $fullPath);
}
