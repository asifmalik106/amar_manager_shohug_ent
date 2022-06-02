<?php
class Validation{
  
  public static function verify($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
  
  public static function email($email, $required = null){
    $email = self::verify($email);
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    if((!$required AND strlen($email)==0)OR(strlen($email)!=0 AND !(filter_var($email, FILTER_VALIDATE_EMAIL)=== False))){
      return array('data' => $email, 'error'=>NULL);
    }else if((strlen($email)!=0 AND (filter_var($email, FILTER_VALIDATE_EMAIL)=== False))){
      return array('data' => $email, 'error'=>'Invalid E-mail Address! Try Again...');
    }else {
      return array('data' => $email, 'error'=>'E-mail is required!');
    }
  }
  
  public static function name($name, $required = null){
    $name = self::verify($name);
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    if((!$required AND strlen($name)==0)OR(strlen($name)!=0 AND preg_match("/^[a-zA-Z\s]+$/",$name))){
      return array('data' => $name, 'error'=>null);
    }else if((strlen($name)!=0 AND !(preg_match ("/^[a-zA-Z\s]+$/",$name)))){
      return array('data' => $name, 'error'=>'Name can only contain letters');
    }else {
      return array('data' => $name, 'error'=>'Name is Requierd');
    }
  }
  
  public static function phone($phone, $required = null){
    if($required AND strlen($phone)==0){
      return array('data' => $phone, 'error'=>'Phone Number is Requierd');
    }
    else{
      return array('data' => $phone, 'error'=>NULL);
    }
  }
  
  public static function intValue($data, $required = null){
    $data = self::verify($data);
    $data = filter_var($data, FILTER_SANITIZE_NUMBER_INT);
    if((!$required AND strlen($data)==0)OR(strlen($data)!=0 AND !(filter_var($data, FILTER_VALIDATE_INT)=== False))){
      return array('data' => $data, 'error'=>NULL);
    }else if((strlen($data)!=0 AND (filter_var($data, FILTER_VALIDATE_INT)=== False))){
      return array('data' => $data, 'error'=>'Invalid integer value');
    }else {
      return array('data' => $data, 'error'=>'Integer value is required!');
    }
  }
  
  public static function floatValue($data, $required = null){
    $data = self::verify($data);
    $data = filter_var($data, FILTER_SANITIZE_NUMBER_FLOAT);
    if((!$required AND strlen($data)==0)OR(strlen($data)!=0 AND !(filter_var($data, FILTER_VALIDATE_FLOAT)=== False))){
      return array('data' => $data, 'error'=>NULL);
    }else if((strlen($data)!=0 AND (filter_var($data, FILTER_VALIDATE_FLOAT)=== False))){
      return array('data' => $data, 'error'=>'Invalid float value');
    }else {
      return array('data' => $data, 'error'=>'Float value is required!');
    }
  }
  

}