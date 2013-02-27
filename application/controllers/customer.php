<?php
	class customer extends CI_Controller {
	
		public function index()
		{
			$this->load->view('header');
			$this->load->view('customer_view');
		}
	}
?>