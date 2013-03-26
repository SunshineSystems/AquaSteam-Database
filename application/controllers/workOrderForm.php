<?php

	/**
	 * @file workOrderForm.php
	 * @brief Contains the WorkOrderForm class that handles all the functionality of the work order form page.
	 */
	require_once APPPATH.'third_party/dompdf/dompdf_config.inc.php';
	class WorkOrderForm extends CI_Controller {
		/**
		 * Default Constructor
		 */
		public function WorkOrderForm() {
			//Call CI Controller's default constructor
			parent::__construct();
			//Loads the database model functions as "dbm"
			$this->load->model("dbmodel", "dbm", true);
			session_start();
		}
		
		public function index() {
				header("Location: ".$home."mainmenu"); //Goes to main menu, because this page has nothing of use by default.
		}
		
		/**
		 * Gets the information from a work order using it's $id, and passes that information to the workorderform view to be
		 * displayed in the proper fields.
		 * 
		 * @param $id the id of the work order that is to be opened.
		 */
		public function openWorkOrder($id) {
			if(!isset($_SESSION['id'])) {
				$this->load->helper('url'); 
    			$home = base_url();
				header("Location: ".$home."index.php/login");
			}
			else {	
				$data['title'] = "Work Order: $id";
				$data['woID'] = $id;
				
				$results = $this->dbm->getWorkOrderById($id);
				
				//Assigns a value in $data to a field recieved from the database, to be passed to the view.
				foreach($results->result_array() as $row) {
					$data['custID'] = $row['cust_id'];
					
					//Formats date to MM/DD/YYYY, before being output to the table, if it's 0's output no date.
					if($row['wo_date'] == "0000-00-00" || $row['wo_date'] == "1970-01-01" || $row['wo_date'] == "1969-12-31") {
						$data['woDate'] = "";
					}
					else {
						$unix = strtotime($row["wo_date"]);
						$formattedDate = date("m/d/Y", $unix);
						$data['woDate'] = $formattedDate;
					}
					
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
					$data['upholsteryTable'] = $this->getUpholsteryTableForWO($id);
					$data['stainguardTable'] = $this->getStainGuardTableForWO($id);
					$data['otherTable'] = $this->getOtherTableForWO($id);
				}
				
				$this->load->view('header.php', $data);
				$this->load->view('workOrderForm_view.php', $data);
			}
		}

		/**
		 * Loads the page when given a customer to create a work order for, and fills in some default information
		 * based on the customer's information.
		 * 
		 * @param $custID the customer ID to be used to get a customer's information
		 */
		function newForCust($custID) {
			if(!isset($_SESSION['id'])) {
				$this->load->helper('url'); 
    			$home = base_url();
				header("Location: ".$home."index.php/login");
			}
			else {	
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
				
				$data['newForCust'] = TRUE;
				
				$this->load->view('header.php', $data);
				$this->load->view('workOrderForm_view.php', $data);
			}
		}
		
		/**
		 * Recieves the values of all the work order information through post variables, and saves them to their respective tables
		 * in the database. If the workorderID recieved is blank, it saves the information as a new work order, else it just updates
		 * the tables with the information.
		 */
		function saveWorkOrder() {
			$woID = $_POST["woID"];
			
			//Puts all posted work order data from the ajax call, into the $woData array, to be put into the database.
			$woData['cust_id'] = $_POST['custID'];
			$unix = strtotime($_POST['woDate']); //Creates Unix Timestamp based on input date.
			$formattedDate = date("Y-m-d", $unix); //Formats Unix Timestamp to work with SQL DateTime.
			$woData['wo_date'] = $formattedDate;
			if($woData['wo_date'] == "") $woData['wo_date'] = "0000-00-00";
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
								<h4></h4>A New Work Order Has Been Started</div>
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
		/**
		 * Recieves a post variable containing a work order id, and passes it to a database function.
		 * The database function will delete the work order record and all of it's child records from the database
		 * based on the ID that is passed.
		 */
		function deleteWorkOrder() {
			$woID = $_POST["id"];
			
			$this->dbm->deleteWorkOrder($woID);
			
			$feedback = "<div class='alert alert-success'><h4>Success!</h4>
								The Work Order Has Been Deleted</div>";
			echo $feedback;					
		}

		/**
		 * Printable work orders aren't going to happen, because I don't have enough time to do it by the deadline.
		 * It takes a huge amount of time to get it to format properly, and is a giant time sink.
		 * When I work on implementing it for the final system/later it will be done here.
		 * 
		 * @param $id the work order id that will be used to generate a printable report.
		 */
		function printWorkOrder($id) {
			$this->load->helper('url'); 
    		$home = base_url();
	
			$html = "<html>
						<head>
							<link rel='stylesheet' type='text/css' href=".$home."css/printableWO.css>
						</head>
						<body>
							<div id='container'>
								<img src='".$home."images/New Aqua Logo Web.png' alt='Aqua Steam Logo'>
								<h1 id='workOrderHeader'>Work Order</h1>
								<p id='date'>Date: 09/11/2013</p>
								<hr>
							</div>
						</body>
					</html>";
					
			$this->createPDF($html);
			echo $html;
		}
		
		/**
		 * Gets all of the records from the service table that match the $woID, and puts them into an editable table.
		 * Returns the table as a string, to be loaded into the view.
		 * 
		 * @param $woID The work order ID to be used to get the service records.
		 */
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
									<th>Unit Price($)</th>
									<th>Extended Price($)</th>
									<th></th>
								</tr>
							</thead>
							<tbody>";
			
			//Gets each row from service that is tied to the open work order.
			//Puts the content into a table to be displayed. Each cell has classes that will make them editable/savable.				
			$results = $this->dbm->getServiceByWOID($woID);
			foreach($results->result_array() as $row) {
				$serviceTable .= "<tr><td class='editable service serv_type ".$row['serv_id']." text'>".$row['serv_type']."</td>";
				$serviceTable .= "<td class='editable service serv_description ".$row['serv_id']." text'>".$row['serv_description']."</td>";
				$serviceTable .= "<td class='editable service serv_length ".$row['serv_id']." num'>".$row['serv_length']."</td>";
				$serviceTable .= "<td class='editable service serv_width ".$row['serv_id']." num'>".$row['serv_width']."</td>";
				$serviceTable .= "<td>".$row['serv_sq_feet']."</td>";
				$serviceTable .= "<td class='editable service serv_quantity ".$row['serv_id']." num'>".$row['serv_quantity']."</td>";
				$serviceTable .= "<td class='editable service serv_unit_price ".$row['serv_id']." num'>".$row['serv_unit_price']."</td>";
				$serviceTable .= "<td class='service serv_ext_price ".$row['serv_id']."'></td>";
				$serviceTable .= "<td class='serv-delete-row'><button class='btn btn-danger btn-deleterow' onclick='deleteTableRow(".$row['serv_id'].", ".$row['wo_id'].", \"service\", \"serv_id\", \"#carpetTab\")'>Delete</button></td></tr>";
			}
			
			$serviceTable .= "</tbody></table>";
			$serviceTable .= "<div>";
								
							  //Formats the two total price outputs properly, in order to use bootstrap.	
			$serviceTable .= '<div class="totals-div"><label>Total Carpet Sq Ft: </label>
								<div class="input-prepend">
									<span class="add-on">$</span>
								  	<input id="total-service-sqft" class="input-small span2" type="text" value="0.00" readonly>
								</div>
								<label>Total Carpet Price: </label>
								<div class="input-prepend">
									<span class="add-on">$</span>
								  	<input id="total-service-price" class="input-small span2" type="text" value="0.00" readonly>
								</div></div>';
			$serviceTable .= '<button id="newrow-serv-btn" class="btn btn-large btn-success newrow-button pull-right" onclick="addTableRow('.$woID.', \'service\', \'#carpetTab\')">+ New Row</button>';
			$serviceTable .= "</div>";
			return $serviceTable;
		}

		/**
		 * Gets all of the records from the upholstery table that match the $woID, and puts them into an editable table.
		 * Returns the table as a string, to be loaded into the view.
		 * 
		 * @param $woID The work order ID to be used to get the upholstery records.
		 */
		function getUpholsteryTableForWO($woID) {
			$upholsteryTable = "<table id='upholstery-table' class='tablesorter table-striped'>
							<thead>
								<tr>
									<th>Color/Type</th>
									<th>Description</th>
									<th>Length</th>
									<th>Width</th>
									<th>Sq Feet</th>
									<th>Quantity</th>
									<th>Unit Price($)</th>
									<th>Extended Price($)</th>
									<th></th>
								</tr>
							</thead>
							<tbody>";
			
			//Gets each row from upholstery that is tied to the open work order.
			//Puts the content into a table to be displayed. Each cell has classes that will make them editable/savable.				
			$results = $this->dbm->getUpholsteryByWOID($woID);
			foreach($results->result_array() as $row) {
				$upholsteryTable .= "<tr><td class='editable upholstery up_type ".$row['up_id']." text'>".$row['up_type']."</td>";
				$upholsteryTable .= "<td class='editable upholstery up_description ".$row['up_id']." text'>".$row['up_description']."</td>";
				$upholsteryTable .= "<td class='editable upholstery up_length ".$row['up_id']." num'>".$row['up_length']."</td>";
				$upholsteryTable .= "<td class='editable upholstery up_width ".$row['up_id']." num'>".$row['up_width']."</td>";
				$upholsteryTable .= "<td>".$row['up_sq_feet']."</td>";
				$upholsteryTable .= "<td class='editable upholstery up_quantity ".$row['up_id']." num'>".$row['up_quantity']."</td>";
				$upholsteryTable .= "<td class='editable upholstery up_unit_price ".$row['up_id']." num'>".$row['up_unit_price']."</td>";
				$upholsteryTable .= "<td class='upholstery up_ext_price ".$row['up_id']."'></td>";
				$upholsteryTable .= "<td class='up-delete-row'><button class='btn btn-danger btn-deleterow' onclick='deleteTableRow(".$row['up_id'].", ".$row['wo_id'].", \"upholstery\", \"up_id\", \"#upholsteryTab\")'>Delete</button></td></tr>";
			}
			
			$upholsteryTable .= "</tbody></table>";
			$upholsteryTable .= "<div>";
			$upholsteryTable .= '<div class="totals-div"><label>Total Upholstery Sq Ft: </label>
								<div class="input-prepend">
									<span class="add-on">$</span>
								  	<input id="total-upholstery-sqft" class="input-small span2" type="text" value="0.00" readonly>
								</div>
								<label>Total Upholstery Price: </label>
								<div class="input-prepend">
									<span class="add-on">$</span>
								  	<input id="total-upholstery-price" class="input-small span2" type="text" value="0.00" readonly>
								</div></div>';
			$upholsteryTable .= '<button id="newrow-up-btn" class="btn btn-large btn-success newrow-button pull-right" onclick="addTableRow('.$woID.', \'upholstery\', \'#upholsteryTab\')">+ New Row</button>';
			$upholsteryTable .= "</div>";
			return $upholsteryTable;
		}
		
		/**
		 * Gets all of the records from the stain_guard table that match the $woID, and puts them into an editable table.
		 * Returns the table as a string, to be loaded into the view.
		 * 
		 * @param $woID The work order ID to be used to get the stain_guard records.
		 */
		function getStainGuardTableForWO($woID) {
			$stainguardTable = "<table id='stainguard-table' class='tablesorter table-striped'>
							<thead>
								<tr>
									<th>Color/Type</th>
									<th>Description</th>
									<th>Length</th>
									<th>Width</th>
									<th>Sq Feet</th>
									<th>Quantity</th>
									<th>Unit Price($)</th>
									<th>Extended Price($)</th>
									<th></th>
								</tr>
							</thead>
							<tbody>";
			
			//Gets each row from stain_guard that is tied to the open work order.
			//Puts the content into a table to be displayed. Each cell has classes that will make them editable/savable.				
			$results = $this->dbm->getStainGuardByWOID($woID);
			foreach($results->result_array() as $row) {
				$stainguardTable .= "<tr><td class='editable stain_guard sg_type ".$row['sg_id']." text'>".$row['sg_type']."</td>";
				$stainguardTable .= "<td class='editable stain_guard sg_description ".$row['sg_id']." text'>".$row['sg_description']."</td>";
				$stainguardTable .= "<td class='editable stain_guard sg_length ".$row['sg_id']." num'>".$row['sg_length']."</td>";
				$stainguardTable .= "<td class='editable stain_guard sg_width ".$row['sg_id']." num'>".$row['sg_width']."</td>";
				$stainguardTable .= "<td>".$row['sg_sq_feet']."</td>";
				$stainguardTable .= "<td class='editable stain_guard sg_quantity ".$row['sg_id']." num'>".$row['sg_quantity']."</td>";
				$stainguardTable .= "<td class='editable stain_guard sg_unit_price ".$row['sg_id']." num'>".$row['sg_unit_price']."</td>";
				$stainguardTable .= "<td class='stain_guard sg_ext_price ".$row['sg_id']."'></td>";
				$stainguardTable .= "<td class='sg-delete-row'><button class='btn btn-danger btn-deleterow' onclick='deleteTableRow(".$row['sg_id'].", ".$row['wo_id'].", \"stain_guard\", \"sg_id\", \"#stainGuardTab\")'>Delete</button></td></tr>";
			}
			
			$stainguardTable .= "</tbody></table>";
			$stainguardTable .= "<div>";
			$stainguardTable .= '<div class="totals-div"><label>Total Stain Guard Sq Ft: </label>
								<div class="input-prepend">
									<span class="add-on">$</span>
								  	<input id="total-stainguard-sqft" class="input-small span2" type="text" value="0.00" readonly>
								</div>
								<label>Total Stain Guard Price: </label>
								<div class="input-prepend">
									<span class="add-on">$</span>
								  	<input id="total-stainguard-price" class="input-small span2" type="text" value="0.00" readonly>
								</div></div>';
			$stainguardTable .= '<button id="newrow-sg-btn" class="btn btn-large btn-success newrow-button pull-right" onclick="addTableRow('.$woID.', \'stain_guard\', \'#stainGuardTab\')">+ New Row</button>';
			$stainguardTable .= "</div>";
			return $stainguardTable;
		}
		
		/**
		 * Gets all of the records from the other table that match the $woID, and puts them into an editable table.
		 * Returns the table as a string, to be loaded into the view.
		 * 
		 * @param $woID The work order ID to be used to get the other records.
		 */
		function getOtherTableForWO($woID) {
			$otherTable = "<table id='other-table' class='tablesorter table-striped'>
							<thead>
								<tr>
									<th>Color/Type</th>
									<th>Description</th>
									<th>Length</th>
									<th>Width</th>
									<th>Sq Feet</th>
									<th>Quantity</th>
									<th>Unit Price($)</th>
									<th>Extended Price($)</th>
									<th></th>
								</tr>
							</thead>
							<tbody>";
			
			//Gets each row from other that is tied to the open work order.
			//Puts the content into a table to be displayed. Each cell has classes that will make them editable/savable.				
			$results = $this->dbm->getOtherByWOID($woID);
			foreach($results->result_array() as $row) {
				$otherTable .= "<tr><td class='editable other other_type ".$row['other_id']." text'>".$row['other_type']."</td>";
				$otherTable .= "<td class='editable other other_description ".$row['other_id']." text'>".$row['other_description']."</td>";
				$otherTable .= "<td class='editable other other_length ".$row['other_id']." num'>".$row['other_length']."</td>";
				$otherTable .= "<td class='editable other other_width ".$row['other_id']." num'>".$row['other_width']."</td>";
				$otherTable .= "<td>".$row['other_sq_feet']."</td>";
				$otherTable .= "<td class='editable other other_quantity ".$row['other_id']." num'>".$row['other_quantity']."</td>";
				$otherTable .= "<td class='editable other other_unit_price ".$row['other_id']." num'>".$row['other_unit_price']."</td>";
				$otherTable .= "<td class='other other_ext_price ".$row['other_id']."'></td>";
				$otherTable .= "<td class='other-delete-row'><button class='btn btn-danger btn-deleterow' onclick='deleteTableRow(".$row['other_id'].", ".$row['wo_id'].", \"other\", \"other_id\", \"#otherTab\")'>Delete</button></td></tr>";
			}
			
			$otherTable .= "</tbody></table>";
			$otherTable .= "<div>";
			$otherTable .= '<div class="totals-div"><label>Total Other Sq Ft: </label>
								<div class="input-prepend">
									<span class="add-on">$</span>
								  	<input id="total-other-sqft" class="input-small span2" type="text" value="0.00" readonly>
								</div>
								<label>Total Other Price: </label>
								<div class="input-prepend">
									<span class="add-on">$</span>
								  	<input id="total-other-price" class="input-small span2" type="text" value="0.00" readonly>
								</div></div>';
			$otherTable .= '<button id="newrow-other-btn" class="btn btn-large btn-success newrow-button pull-right" onclick="addTableRow('.$woID.', \'other\', \'#otherTab\')">+ New Row</button>';
			$otherTable .= "</div>";
			return $otherTable;
		}
		
		
		/**
		 * update the value in a table record based on the posted values. It recieves an id, table, field, and value
		 * so it knows exaclty what field in what record to change. This happens when a table cell is updated in the view.
		 */
		function updateTabTable() {
			$id = $_POST['id'];
			$field = $_POST['field'];
			$table = $_POST['table'];
			$value = $_POST['value'];

			switch($table) {
				case "service":
					$idName = "serv_id";
					break;
				case "upholstery":
					$idName = "up_id";
					break;
				case "stain_guard":
					$idName = "sg_id";
					break;
				case "other":
					$idName = "other_id";
					break;
			}
			
			$this->dbm->updateDataTableValue($id, $idName, $field, $value, $table);
			echo "Value saved!";
		}
		
		/**
		 * saves a new blank record in the table that matches the post variable 'table', in order to add a new empty row to
		 * one of the editable datatables in the view.
		 */
		function newTableRow() {
			$woID = $_POST['woID'];
			$table = $_POST['table'];
			
			$this->dbm->newRecordByTable($woID, $table);
			
			//Gets the updated table based on which one had the record update.
			switch($table) {
				case "service":
					$updatedTable = $this->getServiceTableForWO($woID);
					break;
				case "upholstery":
					$updatedTable = $this->getUpholsteryTableForWO($woID);
					break;
				case "stain_guard":
					$updatedTable = $this->getStainGuardTableForWO($woID);
					break;
				case "other":
					$updatedTable = $this->getOtherTableForWO($woID);
					break;
			}
			
			//echo's the updated table to the view.
			echo $updatedTable;
		}
		
		/**
		 * Deletes a record from a table that matches the post variable 'table' and the post variable 'id' as it's primary key.
		 * This will result in a row being removed from the editable datatable in the view.
		 */
		function deleteTableRow() {
			$id = $_POST['id'];
			$idName = $_POST['idName'];
			$woID = $_POST['woID'];
			$table = $_POST['table'];
			
			$this->dbm->deleteRecordByTable($id, $idName, $table);
			
			//Gets the updated table based on which one had the record deleted.
			switch($table) {
				case "service":
					$updatedTable = $this->getServiceTableForWO($woID);
					break;
				case "upholstery":
					$updatedTable = $this->getUpholsteryTableForWO($woID);
					break;
				case "stain_guard":
					$updatedTable = $this->getStainGuardTableForWO($woID);
					break;
				case "other":
					$updatedTable = $this->getOtherTableForWO($woID);
					break;
			}
			
			//Echo's the updated table back to the view.
			echo $updatedTable;
		}
		
		//Not currently used. To be used for creating pdf document for work orders.
		function createPDF($html) {
			$dompdf = new DOMPDF();
			$dompdf->load_html($html);
			$dompdf->render();
			$dompdf->stream("testing.pdf", array('Attatchement'=>0));
		}
	}
	
?>