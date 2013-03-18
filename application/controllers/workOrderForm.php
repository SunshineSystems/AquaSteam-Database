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

		//Loads the page when givin a customer to create a new workorder for, and fills in some default information.
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

		function saveWorkOrder() {
			$woID = $_POST["woID"];
			
			//Puts all posted work order data from the ajax call, into the $woData array, to be put into the database.
			$woData['cust_id'] = $_POST['custID'];
			$woData['wo_date'] = $_POST['woDate'];
			if($woData['wo_date'] == "") $woData['wo_date'] = "0000-00-00 00:00:00";
			$woData['wo_address'] = $_POST['woAddress'];
			$woData['wo_city'] = $_POST['woCity'];
			$woData['wo_prov'] = $_POST['woProv'];
			$woData['wo_pcode'] = $_POST['woPCode'];
			//$woData['wo_notes'] = $_POST['']; Not Yet Implemented.
			$woData['wo_phone'] = $_POST['woPhone'];
			$woData['wo_rx'] = $_POST['woRX'];
			$woData['wo_fan'] = $_POST['woFan'];
			$woData['wo_rake'] = $_POST['woRake'];
			$woData['wo_pad'] = $_POST['woPad'];
			$woData['wo_encapsulate'] = $_POST['woEncap'];
			$woData['wo_form'] = $_POST['woForm'];
			
			//Puts all posted payment data from the ajax call, into the $payData array, to be put into the database.
			$payData['pay_cash'] = $_POST['payCash'];
			$payData['pay_cheque'] = $_POST['payCheque'];
			$payData['pay_discount'] = $_POST['payDiscount'];
			$payData['pay_discount_type'] = $_POST['payDiscountType'];
			$payData['pay_gift'] = $_POST['payGift'];
			$payData['pay_charge'] = $_POST['payCharge'];
			$payData['pay_cc'] = $_POST['payCC'];
			$payData['pay_other'] = $_POST['payOther'];
			if($woID == "") {
				//Inserts new work order, and is returned new work order's id
				$newWorkOrderID = $this->dbm->insertNewWorkOrder($woData);
				
				$payData['wo_id'] = $newWorkOrderID; //Assigns new work order id to be inserted to payment_type table
				$test = $this->dbm->insertNewPayment($payData);
				$feedback = "<div class='alert alert-success'><h4>Success!</h4>
								The New Work Order Has Been Saved</div>";
			}
			else {
				$paymentCheck = $this->dbm->getPaymentByWOID($woID);
				$this->dbm->updateWorkOrder($woID, $woData);	
				
				if(!$paymentCheck->result()) {
					$payData['wo_id'] = $woID; 
					$this->dbm->insertNewPayment($payData);
				}
				
				else {
					$this->dbm->updatePayment($woID, $payData);
				}
				
				$feedback = "<div class='alert alert-success'><h4>Success!</h4>
								The Work Order Has Been Updated</div>";
			}
			echo $feedback;
		}

		function deleteWorkOrder() {
			$woID = $_POST["id"];
			
			$this->dbm->deleteWorkOrder($woID);
		}
	}
	
?>