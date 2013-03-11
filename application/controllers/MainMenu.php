<?php
	class MainMenu extends CI_Controller {
	
		public function MainMenu() {
			//Call CI Controller's default constructor
			parent::__construct();
			//Loads the database model functions as "dbm"
			$this->load->model("dbmodel", "dbm", true);
			session_start();
		}
		
		public function index()
		{
			
			if(!isset($_SESSION['id'])) {
				header('Location: login');
			}
			else {
				$data['title'] = "Home";
				$this->load->view('header', $data);
				if($_SESSION['usertype'] == 1) {
					$this->load->view('adminMainMenu_view');
				}
				else {
					$this->load->view('empMainMenu_view');
				}
			}
		}
	}

?>