<?php
	class WorkOrderForm extends CI_Controller {
		
		public function WorkOrderForm() {
			//Call CI Controller's default constructor
			parent::__construct();
			//Loads the database model functions as "dbm"
			$this->load->model("dbmodel", "dbm", true);
		}
		
		public function index() {
			$data['title'] = "Work Order Form";
			
			$this->load->view('header.php', $data);
			$this->load->view('workOrderForm_view.php');
		}
	}
	
?>