<?php
	class customer extends CI_Controller {
	
		public function index()
		{
			$data['title'] = "Customers";
			$this->load->view('header', $data);
			$this->load->view('customer_view');
		}
		
		
	}
?>