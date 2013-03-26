<?php

	/**
	 * @file mainmenu.php
	 * @brief Contains the mainmenu class that handles all the functionality of the main menu pages.
	 */
	 
	class MainMenu extends CI_Controller {
	
		/** Default Constructor
		 */ 
		public function MainMenu() {
			//Call CI Controller's default constructor
			parent::__construct();
			//Loads the database model functions as "dbm"
			$this->load->model("dbmodel", "dbm", true);
			session_start();
		}
		
		/**
		 * All This page does is check to see whether the logged in user is an admin or employee, and loads
		 * their respective menu pages. The only difference between these pages is some account management buttons.
		 */
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