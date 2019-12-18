<?php

function my_autoloader($class) {

  $tmp = str_replace('\\', '/', $class);

  if (!file_exists("{$tmp}.class.php") && !file_exists("{$tmp}.class.php")){
    return false;
  }
  include "{$tmp}.class.php";
}

spl_autoload_register('my_autoloader');
