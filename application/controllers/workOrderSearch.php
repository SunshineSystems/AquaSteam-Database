<?php
	class WorkOrderSearch extends CI_Controller {
		
		public function WorkOrderSearch() {
			//Call CI Controller's default constructor
			parent::__construct();
			//Loads the database model functions as "dbm"
			$this->load->model("dbmodel", "dbm", true);
		}
		
		public function index() {
			$data['title'] = "Search Work Orders";
			
			$this->load->view('header.php', $data);
			$this->load->view('workOrderSearch_view.php');
		}
	}
	
?>