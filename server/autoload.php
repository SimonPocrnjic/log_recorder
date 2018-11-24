<?php 


function __autoload ($class) {
  $parts = explode('\\', $class);
  $filename = "classes/".end($parts).".php";
  require_once($filename);
}