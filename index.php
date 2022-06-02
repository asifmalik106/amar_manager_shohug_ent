<?php
//ini_set('display_errors', 1);
//echo ini_get('session.gc_maxlifetime');
ob_start();
session_start();
//date_default_timezone_set("Asia/Dhaka");
include 'system/Main.php';
//initialization of default values
$controller = "main";
$method 	= "index";
$param = null;
$requestObject = null;
$errorStatus = false;

//split the controller, method & arguments
if(isset($_GET['url'])){
	$url = rtrim($_GET['url'], '/');
	$url = explode("/", $url);
	if(!empty($url))
		$controller = array_shift($url);
	if(!empty($url))
		$method = array_shift($url);
	if(!empty($url))
		$param = $url;
}

//define the controller file path
$filePath = 'app/controllers/'.$controller.'.php';

//chech if the controller exists or not
if(file_exists($filePath)){

	//if controller exists then include the controller path
	include 'app/controllers/'.$controller.'.php';

	//create the controller object
	$requestObject = new $controller();

	//if requested function does not exists in the object the error will be fired
	if(!method_exists($requestObject,$method)){
		$errorStatus = true;
	}
	//if requested funtion exists then it will check does it have any parameter or not
	else{
		$requestObject->$method($param);
		//$refMethod = new ReflectionMethod($controller, $method);

		//if requested function has parameter & url has argument then function will be called with argument
		/*if(((count($refMethod->getParameters()))==1)&&(!empty($param))){
			$requestObject->$method($url);
		}*/
		/*(function has parameter)XOR(url has argument)
		else if(((count($refMethod->getParameters()))==1)XOR(!empty($param))){
			
			$errorStatus = true;
		}*/
		//if function does not have parameter and url does not have argument
		/*else{
			$requestObject->$method($url);
		}*/
	}
}else{
	$errorStatus = true;
}
if($errorStatus){
	include 'system/404.php';
}