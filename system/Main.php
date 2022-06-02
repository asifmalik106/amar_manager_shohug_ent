<?php
include 'system/Validation.php';
include 'system/Session.php';
include 'system/sms.php';
/*
 * Base URL
 */
define("BASE_URL", "https://shohug.amar-manager.com/");
function pre_print($str){
  echo "<pre>";
  print_r($str);
  echo "</pre>";
}

function var_print($str){
  echo "<pre>";
  var_dump($str);
  echo "</pre>";
}