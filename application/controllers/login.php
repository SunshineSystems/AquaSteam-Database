<?php
	class login extends CI_Controller {
	
		public function index()
		{
			$data['title'] = "Log In";
			$this->load->view('header', $data);
			$this->load->view('login_view');
		}
	}
?>
	