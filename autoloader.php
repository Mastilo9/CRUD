<?php

function my_autoloader($class) {

  $tmp = str_replace('\\', '/', $class);

  if (!file_exists("{$tmp}.php") && !file_exists("{$tmp}.php")){
    return false;
  }
  include "{$tmp}.php";
}

spl_autoload_register('my_autoloader');
