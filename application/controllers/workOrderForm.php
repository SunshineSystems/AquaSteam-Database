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
			
			//Assigns a value in $data to a field recieved from the database, to be passed to the view.
			foreach($results->result_array() as $row) {
				$data['custID'] = $row['cust_id'];
				
				//Formats date to MM/DD/YYYY, before being output to the table.
				$unix = strtotime($row["wo_date"]);
				$formattedDate = date("m/d/Y", $unix);
				$data['woDate'] = $formattedDate;
				
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
				$data['travDistance'] = $row['travel_distance'];
				$data['travPrice'] = $row['travel_price'];
				$data['serviceTable'] = $this->getServiceTableForWO($id);
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
			$unix = strtotime($_POST['woDate']); //Creates Unix Timestamp based on input date.
			$formattedDate = date("Y-m-d H:i:s", $unix); //Formats Unix Timestamp to work with SQL DateTime.
			$woData['wo_date'] = $formattedDate;
			if($woData['wo_date'] == "") $woData['wo_date'] = "0000-00-00 00:00:00";
			$woData['wo_address'] = $_POST['woAddress'];
			$woData['wo_city'] = $_POST['woCity'];
			$woData['wo_prov'] = $_POST['woProv'];
			$woData['wo_pcode'] = $_POST['woPCode'];
			$woData['wo_notes'] = $_POST['woNotes'];
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
			
			//Puts all posted travel data from the ajax call, into the $travData array, to be put into the database.
			$travData['travel_distance'] = $_POST['travelDistance'];
			$travData['travel_price'] = $_POST['travelPrice'];
			
			//Checks to see if there is a value for work order id. If there isn't, it inserts a new workorder with
			//the data in $woData, if there is, it updates the work order that matches the id.
			if($woID == "") {
				//Inserts new work order, and is returned new work order's id
				$newWorkOrderID = $this->dbm->insertNewWorkOrder($woData);
				
				//Assigns new work order id to be inserted to payment_type and travel tables.
				$payData['wo_id'] = $newWorkOrderID; 
				$travData['wo_id'] = $newWorkOrderID;
				
				$this->dbm->insertNewPayment($payData);
				$this->dbm->insertNewTravel($travData);
				$feedback = "<div class='alert alert-success'>
								<button type='button' class='close' data-dismiss='alert'>&times;</button>
								<h4>Success!</h4>The New Work Order Has Been Saved</div>
								<input id='new-woID-val' type='hidden' value='".$newWorkOrderID."'>"; //Sets a hidden input, with the value of the newly saved workorder, to be passed back to the view.
			}
			else {
				$this->dbm->updateWorkOrder($woID, $woData);	
				
				//Checks to see if there's a payment entry tied to the work order being updated.
				//If there's not, then it inserts a new one, otherwise it just updates.
				$paymentCheck = $this->dbm->getPaymentByWOID($woID);
				if(!$paymentCheck->result()) {
					$payData['wo_id'] = $woID; 
					$this->dbm->insertNewPayment($payData);
				}
				
				else {
					$this->dbm->updatePayment($woID, $payData);
				}
				
				//Checks to see if there's a travel entry tied to the work order being updated.
				//If there's not, then it inserts a new one, otherwise it just updates.
				$travelCheck = $this->dbm->getTravelByWOID($woID);
				if(!$travelCheck->result()) {
					$travData['wo_id'] = $woID; 
					$this->dbm->insertNewTravel($travData);
				}
				
				else {
					$this->dbm->updateTravel($woID, $travData);
				}
				
				$feedback = "<div class='alert alert-success'>
								<button type='button' class='close' data-dismiss='alert'>&times;</button>
								<h4>Success!</h4>The Work Order Has Been Updated</div>";
			}
			echo $feedback;
		}

		function deleteWorkOrder() {
			$woID = $_POST["id"];
			
			$this->dbm->deleteWorkOrder($woID);
			
			$feedback = "<div class='alert alert-success'><h4>Success!</h4>
								The Work Order Has Been Deleted</div>";
			echo $feedback;					
		}
		
		function getServiceTableForWO($woID) {
			$serviceTable = "<table id='service-table' class='tablesorter table-striped'>
							<thead>
								<tr>
									<th>Color/Type</th>
									<th>Description</th>
									<th>Length</th>
									<th>Width</th>
									<th>Sq Feet</th>
									<th>Quantity</th>
									<th>Unit Price</th>
									<th>Extended Price</th>
								</tr>
							</thead>
							<tbody>";
			
			//Gets each row from Service that is tied to the open work order.
			//Puts the content into a table to be displayed. Each cell has classes that will make them editable.				
			$results = $this->dbm->getServiceByWOID($woID);
			foreach($results->result_array() as $row) {
				$serviceTable .= "<tr><td class='editable service serv_type ".$row['serv_id']."'>".$row['serv_type']."</td>";
				$serviceTable .= "<td class='editable service serv_description ".$row['serv_id']."'>".$row['serv_description']."</td>";
				$serviceTable .= "<td class='editable service serv_length ".$row['serv_id']."'>".$row['serv_length']."</td>";
				$serviceTable .= "<td class='editable service serv_width ".$row['serv_id']."'>".$row['serv_width']."</td>";
				$serviceTable .= "<td>".$row['serv_sq_feet']."</td>";
				$serviceTable .= "<td class='editable service serv_quantity ".$row['serv_id']."'>".$row['serv_quantity']."</td>";
				$serviceTable .= "<td class='editable service serv_unit_price ".$row['serv_id']."'>".$row['serv_unit_price']."</td>";
				$serviceTable .= "<td></td></tr>";
			}
			
			$serviceTable .= "</tbody></table>";
			return $serviceTable;
		}

		function updateTabTable() {
			$id = $_POST['id'];
			$field = $_POST['field'];
			$table = $_POST['table'];
			$value = $_POST['value'];
			
			if($table == 'service') {
				$this->dbm->updateServiceValue($id, $field, $value);
			}
			else if($table == 'upholstery') {
				//updateUpholsteryValue
			}
			else {
				//updateStainGuardValue
			}
			
			echo "yay it saved!";
		}
	}
	
?>