<?php
class Session{
  public static function setSession($info){
    $_SESSION['data'] =  $info;
  }
  
  public static function getSession(){
    return $_SESSION;
  }
  
  public static function destroySession(){
    $_SESSION = null;
    session_destroy();
  }
  
}