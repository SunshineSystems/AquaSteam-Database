<?php
	class login extends CI_Controller {
	
		public function index()
		{
			$this->load->view('header');
			$this->load->view('login_view');
		}
	}
?>
	