<?php
	class adminMainMenu extends CI_Controller {
	
		public function index()
		{
			$data['title'] = "Home";
			$this->load->view('header', $data);
			$this->load->view('adminMainMenu_view');
		}
	}

?>