<?php
	
	require_once(APPPATH."libraries/hasher.php");
	
	class Login extends CI_Controller {
	
		public function Login() {
			//Call CI Controller's default constructor
			parent::__construct();
			//Loads the database model functions as "dbm"
			$this->load->model("dbmodel", "dbm", true);
		}
		
		public function index()
		{
			$data['title'] = "Log In";
			$this->load->view('header', $data);
			$this->load->view('login_view');
		}
		
		function checkCredentials() {
			$username = $_POST['username'];
			$password = $_POST['password'];
			global $hasher; //calls the global variable from hasher.php
			
			$result = $this->dbm->getUserOnLogin($username);
			$user = $result->result_array();
			
			//Checks if username is valid
			if(empty($user)) {
				$error = "<div class='alert alert-error'>
						  <button type='button' class='close' data-dismiss='alert'>&times;</button>
						  <h4>Whoops!</h4>No user with that username exists!</div>";
				echo $error;
				return;
			}
			
			foreach($result->result_array() as $row) {
				$storedPass = $row['user_password'];
			}
			
			//Compares the input password to the stored password.
			$passwordCheck = $hasher->CheckPassword($password, $storedPass);
			if(!$passwordCheck) {
				$error = "<div class='alert alert-error'>
						  <button type='button' class='close' data-dismiss='alert'>&times;</button>
						  <h4>Whoops!</h4>The password you've entered is incorrect!</div>";
				echo $error;
				return;
			}
			echo 'success';		
		}
	}
?>
	