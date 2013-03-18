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
		
		//Loads the page, with an existing Work Order's information
		public function openWorkOrder($id) {
			$data['title'] = "Work Order Form";
			$data['woID'] = $id;
			
			$results = $this->dbm->getWorkOrderById($id);
			//echo $results;
			
			//Assigns a value in $data to a field recieved from the database, to be passed to the view.
			foreach($results->result_array() as $row) {
				$data['custID'] = $row['cust_id'];
				$data['woDate'] = $row['wo_date'];
				$data['woAddress'] = $row['wo_address'];
				$data['woCity'] = $row['wo_city'];
				$data['woProv'] = $row['wo_prov'];
				$data['woPCode'] = $row['wo_pcode'];
				$data['woPhone'] = $row['wo_phone'];
				$data['woNotes'] = $row['wo_notes'];
				if($row['wo_rx'] == 1) $data['woRX'] = "checked";
				if($row['wo_fan'] == 1) $data['woFan'] = "checked";
				if($row['wo_rake'] == 1) $data['woRake'] = "checked";
				if($row['wo_pad'] == 1) $data['woPad'] = "checked";
				if($row['wo_encapsulate'] == 1) $data['woEncapsulate'] = "checked";
				if($row['wo_form'] == 1) $data['woForm'] = "checked";
				$data['custFName'] = $row['cust_fname'];
				$data['custLName'] = $row['cust_lname'];
				$data['custCompany'] = $row['cust_company'];
				if($row['pay_cheque'] == 1) $data['payCheque'] = "checked";
				if($row['pay_cash'] == 1) $data['payCash'] = "checked";
				if($row['pay_charge'] == 1) $data['payCharge'] = "checked";
				if($row['pay_cc'] == 1) $data['payCC'] = "checked";
				$data['payDiscount'] = $row['pay_discount'];
				$data['payDiscountType'] = $row['pay_discount_type'];
				$data['payGift'] = $row['pay_gift'];
				$data['payOther'] = $row['pay_other'];
			}
			
			$this->load->view('header.php', $data);
			$this->load->view('workOrderForm_view.php', $data);
		}

		function newForCust($custID) {
			$data['title'] = "Work Order Form";
			$data['custID'] = $custID;
			
			$results = $this->dbm->getCustomerById($custID);
			
			foreach($results->result_array() as $row) {
				$data['custFName'] = $row['cust_fname'];
				$data['custLName'] = $row['cust_lname'];
				$data['custCompany'] = $row['cust_company'];
				$data['woAddress'] = $row['cust_address'];
				$data['woCity'] = $row['cust_city'];
				$data['woProv'] = $row['cust_prov'];
				$data['woPCode'] = $row['cust_pcode'];
			}
			
			$this->load->view('header.php', $data);
			$this->load->view('workOrderForm_view.php', $data);
		}
	}
	
?>