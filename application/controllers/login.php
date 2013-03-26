<?php

	/**
	 * @file login.php
	 * @brief Contains the login class that handles all the functionality of the login page.
	 */
	 
	require_once(APPPATH."libraries/hasher.php");
	
	class Login extends CI_Controller {
		
		/** Default Constructor
		 */
		public function Login() {
			//Call CI Controller's default constructor
			parent::__construct();
			//Loads the database model functions as "dbm"
			$this->load->model("dbmodel", "dbm", true);
			session_start();
			if(isset($_SESSION['id'])) {
				session_destroy();
				session_start();
			}
		}
		
		
		public function index()
		{	
			$data['title'] = "Log In";
			$this->load->view('header', $data);
			$this->load->view('login_view');
		}
		
		/**
		 * Checks the username and password that get passed to the function, and makes sure that the user exists, and the password
		 * matches the password that is in the database. If all is well, it sets some session variables and returns 1, for the
		 * javascript to know that the login was successful.
		 */
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
				$id = $row['user_id'];	
				$storedPass = $row['user_password'];
				$type = $row['user_admin'];
				$username = $row['user_username'];
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
			
			$_SESSION['id'] = $id;
			$_SESSION['usertype'] = $type;
			$_SESSION['username'] = $username;
			echo 1;		
		}
	}
?>
	