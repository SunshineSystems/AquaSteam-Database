<?php
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
	}
?>