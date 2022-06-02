<?php
include 'system/Load.php';
include "lang/".$_SESSION['data']['language'].".php";


class Controller
{
	protected $load;
	function __construct(){
		$this->load = new Load();
	}
	
}