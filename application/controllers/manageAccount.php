<?php
	require_once(APPPATH."libraries/hasher.php");
	
	class ManageAccount extends CI_Controller {
	
		public function ManageAccount() {
			//Call CI Controller's default constructor
			parent::__construct();
			//Loads the database model functions as "dbm"
			$this->load->model("dbmodel", "dbm", true);
		}
		
		public function index()
		{
			$data['title'] = "Manage Accounts";
			$this->load->view('header', $data);
			$this->load->view('manageAccount_view.php');
		}
		
		function saveAccount() {
			$data = array();
			$id = $_POST['id'];
			$userType = $_POST['type'];
			global $hasher;
			
			//Hashes password for security purposes.
			$hashedPassword = $hasher->HashPassword($_POST['password']);
			
			if($userType == "Admin") {
				$data['user_admin'] = 1;
			}
			else {
				$data['user_admin'] = 0;
			}
			
			$data['user_username'] = $_POST['username'];
			$data['user_password'] = $hashedPassword;
			$data['user_fname'] = $_POST['fname'];
			$data['user_lname'] = $_POST['lname'];
			$data['user_address'] = $_POST['address'];
			$data['user_city'] = $_POST['city'];
			$data['user_prov']= $_POST['prov'];
			$data['user_pcode'] = $_POST['pcode'];
			$data['user_hphone'] = $_POST['hphone'];
			$data['user_cphone'] = $_POST['cphone'];
			$data['user_notes'] = $_POST['notes'];
			
			if(!$id) {
				$echo = "This is a new account!";
				$this->dbm->insertNewAccount($data);
			}
			else {
				$echo = "This is an existing account";
			}
			echo $echo;
		}
	}
?>