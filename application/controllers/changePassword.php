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
			$data['title'] = "Change Password";
			$this->load->view('header', $data);
			$this->load->view('changePassword_view');
		}
		
		function checkCredentials() {
			$oldPassword = $_POST['oldPassword'];
			$newPassword = $_POST['newPassword'];
			$retypeNewPassword = $_POST['retypeNewPassword'];
			$userID = $_SESSION['id'];
			
			global $hasher; //calls the global variable from hasher.php
			//die("something");
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
	