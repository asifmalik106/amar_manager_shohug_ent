<?php
/**
* 
*/
class Load
{
	function __construct(){

	}

	function view($view, $data=null){
		include 'system/Header.php';
		include "app/views/".$view.".php";
		include 'system/Footer.php';
	}

	function redirectIn($url = null){
		header("Location: ".BASE_URL.$url);
	}

	function redirectOut($url){
		header("Location: ".$url);
	}

	function controller($con){
		include "app/controllers/".$con.".php";
	}
	
	function model($mod){
		if(!class_exists($mod)){
			include_once "app/models/".$mod.".php";
		}
	}

}