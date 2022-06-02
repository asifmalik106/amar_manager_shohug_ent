<?php
include 'system/Controller.php';


/* File: Main Controler
 * Handle all primary requests. It handles Login Requests and authenticate users.
 * Asif Salman Malik
 * Incresome Inc.
 *
 */
class main extends Controller
{
	function __construct()
	{
		parent::__construct();
	}


	/* Main Function.
	 * 	If user is not logged in then show login page.
	 * 	Else redirect to authorized page.
	 */
	public function index($msg = null){
		if(isset($_SESSION['data'])){
			$this->load->redirectIn($_SESSION['data']['rank']);
		}
		else{
			$data = array(
				'title'=> 'Login | আমার Manager',
				'css'=> array('css/bootstrap5.1.3.min.css')
			);
			$data['js'] = array('js/page/login.js'
							);
			if(isset($msg)){
				$data = array_merge($data, array('msg'=>'Wrong Username or Password!'));
			}
			$this->load->view('login',$data);
		}
	}


	/* Login Verify Function.
	 *	Verify an user's login information.
	 *	If user is verified then set session data and redirect to authorized page.
	 * 	Else show login page.	
	 */
	public function loginVerify(){
		$login = Validation::verify($_POST['login']);
		$password = Validation::verify($_POST['password']);
		$_SESSION['temp'] = $login;
		$loginData = '';
		$this->load->model('mainModel');
		$dbModel = new mainModel();
		$result = $dbModel->loginVerify($login, $password);
		if(($result->num_rows)==1){
			$_SESSION['temp'] = '';
			$loginData = $result->fetch_assoc();
			$result = $dbModel->getDBAndTimezome($loginData['businessID']);
			$loginData = array_merge($loginData,$result->fetch_assoc());
			Session::setSession($loginData);
      
      
      $dbModel->setActivity($loginData['name'], "Login");
      
			$this->load->redirectIn();
		}
		else{
			$this->load->redirectIn('main/index/error/');
		}
	}

	
	/* Logout Function
	 *	Destroy all session Data and redirect to login page.
	 */
	public function logout()
	{
		Session::destroySession();
		$this->load->redirectIn();
	}
	
}