<?php

	require_once(APPPATH."libraries/hasher.php");

	class changePassword extends CI_Controller {
	
		public function ChangePassword() {
			//Call CI Controller's default constructor
			parent::__construct();
			//Loads the database model functions as "dbm"
			$this->load->model("dbmodel", "dbm", true);
			session_start();
		}
	
		public function index(){
			if(!isset($_SESSION['id'])) {
				header('Location: login');
			}
			else {
				$data['title'] = "Change Password";
				$this->load->view('header', $data);
				$this->load->view('changePassword_view');
			}
		}
		
		function checkCredentials() {
			$oldPassword = $_POST['oldPassword'];
			$newPassword = $_POST['newPassword'];
			$retypeNewPassword = $_POST['retypeNewPassword'];
			$userID = $_SESSION['id'];
			
			//Checks for whitespace in the password, if there is return an error message.
			if(strpos($newPassword, " ")) {
				$error = "<div class='alert alert-error'>
						  <button type='button' class='close' data-dismiss='alert'>&times;</button>
						  <h4>Whoops!</h4>Whitespace/spaces aren't allowed in passwords!</div>";
				echo $error;
				return;
			}
			
			//Checks fthe length of the new password, if it does not meet the requirements return an error message
			if(strlen($newPassword) < 6) {
				$error = "<div class='alert alert-error'>
						  <button type='button' class='close' data-dismiss='alert'>&times;</button>
						  <h4>Whoops!</h4>Passwords must be at least 6  characters</div>";
				echo $error;
				return;
			}
			
			global $hasher; //calls the global variable from hasher.php
			$result = $this->dbm->getUserById($userID); 
			
			foreach($result->result_array() as $row) {
				$storedPass = $row['user_password'];
			}
			
			//Compares the input password to the stored password.
			$passwordCheck = $hasher->CheckPassword($oldPassword, $storedPass);
			if(!$passwordCheck) {
				$error = "<div class='alert alert-error'>
						  <button type='button' class='close' data-dismiss='alert'>&times;</button>
						  <h4>Whoops!</h4>The old password you've entered is incorrect!</div>";
				echo $error;
				return;
			}
			else if($newPassword != $retypeNewPassword){
				$error = "<div class='alert alert-error'>
						  <button type='button' class='close' data-dismiss='alert'>&times;</button>
						  <h4>Whoops!</h4>The new passwords do not match!</div>";
				echo $error;
				return;
			}
			
			$hashedPassword = $hasher->HashPassword($newPassword);
			$this->dbm->updateUserPassword($userID, $hashedPassword);
			echo 1;
		}
	}
?>
	