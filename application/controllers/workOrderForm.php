<?php

	/**
	 * @file workOrderForm.php
	 * @brief Contains the WorkOrderForm class that handles all the functionality of the work order form page.
	 */
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
					$data['woSpots'] = $row['wo_spots'];
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
					if($row['pay_debit'] == 1) $data['payDebit'] = "checked";
					$data['payDiscount'] = $row['pay_discount'];
					$data['payDiscountType'] = $row['pay_discount_type'];
					$data['payGift'] = $row['pay_gift'];
					$data['payOther'] = $row['pay_other'];
					$data['travDistance'] = $row['travel_distance'];
					$data['travPrice'] = $row['travel_price'];
					$data['payTax'] = $row['pay_tax_rate'];
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
			$woData['wo_spots'] = $_POST['woSpots'];
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
			$payData['pay_debit'] = $_POST['payDebit'];
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
		 * This function is passed values for all of the inputs in a work order form, and compares them to the values
		 * saved in the database for those inputs. If one of the values don't match then we kill the function, returning
		 * a warning that there are unsaved changes to the page... This is a mess.
		 */
		function checkChanges() {
			$woID = $_POST['woID'];
			$results = $this->dbm->getWorkOrderById($woID);
			
			foreach($results->result_array() as $row) {
				if($row['wo_address'] != $_POST['woAddress']) {
					die("unsaved");
				}
				if($row['wo_city'] != $_POST['woCity']) {
					die("unsaved");
				}
				if($row['wo_prov'] != $_POST['woProv']) {
					die("unsaved");
				}
				if($row['wo_pcode'] != $_POST['woPCode']) {
					die("unsaved");
				}
				if($row['wo_phone'] != $_POST['woPhone']) {
					die("unsaved");
				}
				if($row['wo_notes'] != $_POST['woNotes']) {
					die("unsaved");
				}
				if($row['wo_spots'] != $_POST['woSpots']) {
					die("unsaved");
				}
				if($row['pay_gift'] != $_POST['payGift']) {
					die("unsaved");
				}
				if($row['pay_discount_type'] != $_POST['payDiscountType']) {
					die("unsaved");
				}
				if($row['pay_discount'] != $_POST['payDiscount']) {
					die("unsaved");
				}
				if($row['wo_rx'] != $_POST['woRX']) {
					die("unsaved");
				}
				if($row['wo_fan'] != $_POST['woFan']) {
					die("unsaved");
				}
				if($row['wo_rake'] != $_POST['woRake']) {
					die("unsaved");
				}
				if($row['wo_pad'] != $_POST['woPad']) {
					die("unsaved");
				}
				if($row['wo_encapsulate'] != $_POST['woEncap']) {
					die("unsaved");
				}
				if($row['wo_form'] != $_POST['woForm']) {
					die("unsaved");
				}
				if($row['pay_cash'] != $_POST['payCash']) {
					die("unsaved");
				}
				if($row['pay_cheque'] != $_POST['payCheque']) {
					die("unsaved");
				}
				if($row['pay_cc'] != $_POST['payCC']) {
					die("unsaved");
				}
				if($row['pay_charge'] != $_POST['payCharge']) {
					die("unsaved");
				}
				if($row['pay_other'] != $_POST['payOther']) {
					die("unsaved");
				}
				if($row['travel_distance'] != $_POST['travelDistance']) {
					die("unsaved");
				}
				if($row['travel_price'] != $_POST['travelPrice']) {
					die("unsaved");
				}
				if($row['pay_debit'] != $_POST['payDebit']) {
					die("unsaved");
				}
				
				$unix = strtotime($_POST['woDate']); //Creates Unix Timestamp based on input date.
				$formattedDate = date("Y-m-d", $unix); //Formats Unix Timestamp to work with SQL DateTime.
				if($row['wo_date'] != $formattedDate) {
					die("unsaved");
				}
			}
			return "up to date";
		}
		
		/**
		 * Recieves post variables containing a work order id, and a gst value. Saves the gst value to the database
		 * where the work order id == the posted id.
		 */
		function saveNewTax() {
			$woID = $_POST['id'];
			$payData['pay_tax_rate'] = $_POST['newRate'];
			
			$this->dbm->updatePayment($woID, $payData);
		}

		/**
		 * Creates a page layout using html/css inside a string, and passes the string to the TCPDF class, which will
		 * output it to a PDF. TCPDF is very strict with how it can render html to a pdf, so the html code is really ugly.
		 * My condolences to whoever has to work on this in the future.
		 * 
		 * @param $id the work order id that will be used to generate a printable report.
		 */
		function printWorkOrder($id) {
			$this->load->helper('url'); 
    		$home = base_url();
			
			//Gets the information that we will use
			$results = $this->dbm->getWorkOrderById($id);
			$workOrder = $results->row_array();
			
			$results = $this->dbm->getCustomerById($workOrder['cust_id']);
			$customer = $results->row_array();
			
			$results = $this->dbm->getPaymentByWOID($id);
			$payment = $results->row_array();
		
			$results = $this->dbm->getTravelByWOID($id);
			$travel = $results->row_array();
			if(count($travel) == 0 || $travel['travel_distance'] == 0.00 && $travel['travel_price'] == 0.00)
				$travelEntered = false;
			else 
				$travelEntered = true;
			
			$carpet = $this->dbm->getServiceByWOID($id);
			$upholstery = $this->dbm->getUpholsteryByWOID($id);
			$stainguard = $this->dbm->getStainGuardByWOID($id);
			$other = $this->dbm->getOtherByWOID($id);
			
			$subTotal = 0;
			$carpetTotal = 0;
			$travelTotal = 0;
			$gst = 0;
			$adjTotal = 0;
			$finalTotal = 0;
			
			//die(var_dump($payment));
			//Format the work order date properly
			if($workOrder['wo_date'] == "0000-00-00" || $workOrder['wo_date'] == "1970-01-01" || $workOrder['wo_date'] == "1969-12-31") {
				$date = "";
			}
			else {
				$unix = strtotime($workOrder["wo_date"]);
				$formattedDate = date("m/d/Y", $unix);
				$date = $formattedDate;
			}
			
			//Image tags for checkboxes, to be used for equipment/payment options.
			$checked='<img src="'.$home.'images/checked.png"  height="10"/>';
			$unchecked='<img src="'.$home.'images/unchecked.png"  height="10"/>';
			
			$html ='<table style="width: 100%; "><tr><td style="border-bottom: 1px solid black;"></td><td colspan="2" style="text-align: center; border-bottom: 1px solid black;"><h1>Work Order</h1></td>
						<td style="text-align:center; line-height: 3px; border-bottom: 1px solid black;"><b>Date: '.$date.'</b></td></tr>';
			
			$html .= '<tr><td><br></td></tr>'; //The only way TCPDF will seem to space out table cells, css doesn't work.
			$html .= '<tr><td><u>Customer Information:</u></td>
					 	 <td colspan="2" align="center"><u>Cleaning To Be Done At:</u></td><td align="center"><b>ID: </b>'.$id.'</td></tr>';
			
			$html .= '<tr><td><br></td></tr>';
			$html .= '<tr><td width="200px"><b>Company:</b> '.$customer['cust_company'].'</td><td colspan="2"><b>Address:</b> '.$workOrder['wo_address'].'</td></tr>';
			$html .= '<tr><td width="256px"><b>Name:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b> '.$customer['cust_fname'].' '.$customer['cust_lname'].'
						  </td><td colspan="2">'.$workOrder['wo_city'].', '.$workOrder['wo_prov'].'</td></tr>';
			$html .= '<tr><td width="256px"><b>Email:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b> '.$customer['cust_email'].'
						  </td><td colspan="2">'.$workOrder['wo_pcode'].'</td></tr>';
						  
			$html .= '<tr><td width="200px"><b>Address:&nbsp;&nbsp;</b> '.$customer['cust_address'].'
						  </td><td width="150"><b>Phone: &nbsp;&nbsp;&nbsp;</b>'.$workOrder['wo_phone'].'</td>
						  <td width="188"><b>Gift: </b>'.$payment['pay_gift'].'</td></tr>';
			$html .= '<tr><td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							'.$customer['cust_city'].', '.$customer['cust_prov'].'</td></tr>';
			$html .= '<tr><td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							'.$customer['cust_pcode'].'</td></tr>';
			$html .= '<tr><td><br></td></tr>';			  		
			$html .= '<tr><td><b>Home Phone:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b> '.$customer['cust_hphone'].'</td>
						  	  <td rowspan="4" width="320" style="border: 1px solid black;">Equipment: <br>';
			//renders the equipment options with either an image of a checked box or unchecked box, based on the saved values.
			if($workOrder['wo_rx'] == 1)
				$html .= $checked.' RX &nbsp;&nbsp;&nbsp;';
			else 
				$html .= $unchecked.' RX &nbsp;&nbsp;&nbsp;';
			if($workOrder['wo_fan'] == 1)
				$html .= $checked.' Fan &nbsp;&nbsp;&nbsp;';
			else 
				$html .= $unchecked.' Fan &nbsp;&nbsp;&nbsp;';
			if($workOrder['wo_rake'] == 1)
				$html .= $checked.' Rake &nbsp;&nbsp;&nbsp;';
			else 
				$html .= $unchecked.' Rake &nbsp;&nbsp;&nbsp;';
			if($workOrder['wo_pad'] == 1)
				$html .= $checked.' Pad &nbsp;&nbsp;&nbsp;';
			else 
				$html .= $unchecked.' Pad &nbsp;&nbsp;&nbsp;';
			if($workOrder['wo_encapsulate'] == 1)
				$html .= $checked.' Encapsulate<br>';
			else 
				$html .= $unchecked.' Encapsulate<br>';
			if($workOrder['wo_form'] == 1)
				$html .= $checked.' Info Form</td></tr>';
			else 
				$html .= $unchecked.' Info Form</td></tr>';
			
			$html .= '<tr><td><b>Business Phone:</b> '.$customer['cust_bphone'].'</td></tr>';
			$html .= '<tr><td><b>Cell Phone:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b> '.$customer['cust_cphone'].'</td></tr>';
			$html .= '<tr><td><br></td></tr>';
			$html .= '<tr><td><br></td></tr>';
			$html .= "</table>";
			
			//Outputs the work order table data
			$html .='<table style="width: 100%;" align="center"><tr>
							<td style="border-bottom: 1px solid black; width: 12%;"><b>Category</b></td>
							<td style="border-bottom: 1px solid black; width: 18%;"><b>Description</b></td>
							<td style="border-bottom: 1px solid black; width: 12%;"><b>Color / Type</b></td>
							<td style="border-bottom: 1px solid black; width:  8%;"><b>L</b></td>
							<td style="border-bottom: 1px solid black; width:  8%;"><b>W</b></td>
							<td style="border-bottom: 1px solid black; width: 12%;"><b>Sq Feet</b></td>
							<td style="border-bottom: 1px solid black; width:  6%;"><b>Qty</b></td>
							<td style="border-bottom: 1px solid black; width: 12%;"><b>Unit Price</b></td>
							<td style="border-bottom: 1px solid black; width: 12%;"><b>Ext. Price</b></td></tr>';
			
			foreach($carpet->result_array() as $row) {
				$html .= '<tr><td>Carpet<br></td>';
				$html .= '<td>'.$row['serv_description'].'</td>';
				$html .= '<td>'.$row['serv_type'].'</td>';
				$html .= '<td>'.$row['serv_length'].'</td>';
				$html .= '<td>'.$row['serv_width'].'</td>';
				$html .= '<td>'.$row['serv_sq_feet'].'</td>';
				$html .= '<td>'.$row['serv_quantity'].'</td>';
				$html .= '<td> $'.$row['serv_unit_price'].'</td>';
				$html .= '<td> $'.$row['serv_ext_price'].'</td></tr>';
				$carpetTotal += $row['serv_ext_price'];
				$subTotal += $row['serv_ext_price'];
			}
			
			foreach($upholstery->result_array() as $row) {
				$html .= '<tr><td>Upholstery<br></td>';
				$html .= '<td>'.$row['up_description'].'</td>';
				$html .= '<td>'.$row['up_type'].'</td>';
				$html .= '<td>N/A</td>';
				$html .= '<td>N/A</td>';
				$html .= '<td>N/A</td>';
				$html .= '<td>'.$row['up_quantity'].'</td>';
				$html .= '<td> $'.$row['up_unit_price'].'</td>';
				$html .= '<td> $'.$row['up_ext_price'].'</td></tr>';
				$subTotal += $row['up_ext_price'];
			}
			
			foreach($stainguard->result_array() as $row) {
				$html .= '<tr><td>Stain Guard<br></td>';
				$html .= '<td>'.$row['sg_description'].'</td>';
				$html .= '<td>N/A</td>';
				$html .= '<td>'.$row['sg_length'].'</td>';
				$html .= '<td>'.$row['sg_width'].'</td>';
				$html .= '<td>'.$row['sg_sq_feet'].'</td>';
				$html .= '<td>'.$row['sg_quantity'].'</td>';
				$html .= '<td> $'.$row['sg_unit_price'].'</td>';
				$html .= '<td> $'.$row['sg_ext_price'].'</td></tr>';
				$subTotal += $row['sg_ext_price'];
			}
			
			foreach($other->result_array() as $row) {
				$html .= '<tr><td>Other<br></td>';
				$html .= '<td>'.$row['other_description'].'</td>';
				$html .= '<td>'.$row['other_type'].'</td>';
				$html .= '<td>'.$row['other_length'].'</td>';
				$html .= '<td>'.$row['other_width'].'</td>';
				$html .= '<td>'.$row['other_sq_feet'].'</td>';
				$html .= '<td>'.$row['other_quantity'].'</td>';
				$html .= '<td> $'.$row['other_unit_price'].'</td>';
				$html .= '<td> $'.$row['other_ext_price'].'</td></tr>';
				$subTotal += $row['other_ext_price'];
			}
			if($travelEntered) {
				$travelTotal = $travel['travel_distance'] * $travel['travel_price'];
				$subTotal += $travelTotal;
				$travelTotalFormatted = number_format($travelTotal, 2, '.', '');	
				$html .= '<tr><td>Travel<br></td>';
				$html .= '<td colspan="6" align="left">Distance: '.$travel['travel_distance'].'km</td>';
				$html .= '<td>$'.$travel['travel_price'].'</td>';
				$html .= '<td>$'.$travelTotalFormatted.'</td></tr>';
			}
			$html .= '<tr><td><br></td></tr>';
			$html .= '<tr><td><br></td></tr>';
			$html .= '<tr><td><br></td></tr>';
			$html .= '<tr><td><br></td></tr>';
			$html .= '<tr><td><br></td></tr>';
			$html .= '<tr><td><br></td></tr>';
			$html .= '<tr><td><br></td></tr>';
			$html .= '<tr><td><br></td></tr>';
			$html .= "</table>";
			
			//Payment/other information to be displayed at the bottom.
			$html .= '<table><tr><td></td>';
			$html .= '<td border="1" colspan="3"><b> Payment Method: </b>';
			//Checking payment methods to be checked or not.
			if($workOrder['pay_cash'] == 1)
				$html .= $checked.' Cash &nbsp;&nbsp;&nbsp;';
			else 
				$html .= $unchecked.' Cash &nbsp;&nbsp;&nbsp;';
			if($workOrder['pay_cheque'] == 1)
				$html .= $checked.' Cheque &nbsp;&nbsp;&nbsp;';
			else 
				$html .= $unchecked.' Cheque &nbsp;&nbsp;&nbsp;';
			if($workOrder['pay_cc'] == 1)
				$html .= $checked.' Credit Card &nbsp;&nbsp;&nbsp;';
			else 
				$html .= $unchecked.' Credit Card &nbsp;&nbsp;&nbsp;';
			if($workOrder['pay_charge'] == 1)
				$html .= $checked.' Charge <br>';
			else 
				$html .= $unchecked.' Charge <br>';
			if($workOrder['pay_debit'] == 1)
				$html .= '&nbsp;'.$checked.' Debit &nbsp;&nbsp;&nbsp;';
			else 
				$html .= '&nbsp;'.$unchecked.' Debit &nbsp;&nbsp;&nbsp;';
			if($workOrder['pay_other'] != "")
				$html .= $checked.' Other: '.$workOrder['pay_other'];
			else 
				$html .= $unchecked.' Other';		
			$html .= '</td></tr>';
			$html .= '<tr><td><br></td></tr>';
			$html .= '<tr><td><br></td></tr>';
			
			$subTotalFormatted = number_format($subTotal, 2, '.', ',');
			$html .= '<tr><td><b>Notes:</b></td><td></td><td width="30%"></td><td width="20%">Subtotal:';
			$html .= '&nbsp;&nbsp;<u> &nbsp;$'.$subTotalFormatted.'</u></td></tr>';
			
			$html .= '<tr><td></td><td></td><td width="30%"></td><td width="20%">Discount:';
			if($payment['pay_discount_type'] == "$") {
				$discount = "$".$payment['pay_discount'];
				$adjTotal = $subTotal - $payment['pay_discount'];
			}
			else {
				//$discount = $payment['pay_discount']."%";
				$discountVal = $payment['pay_discount'] /100 * $carpetTotal;
				//$discount = "$".$discountVal;
				$discount = "$".number_format($discountVal, 2, '.', ',');
				$adjTotal = $subTotal - $discountVal;
				//$discountVal = $subTotal * discountVal;
			}
			$html .= '&nbsp;&nbsp;<u> &nbsp;'.$discount.'</u></td></tr>';
			
			$adjTotalFormatted = number_format($adjTotal, 2, '.', ',');
			$html .= '<tr><td></td><td></td><td></td><td width="30%">Adj. Total:';
			$html .= '&nbsp;<u> $'.$adjTotalFormatted.'</u></td></tr>';
			
			$taxVal = $payment['pay_tax_rate'] /100 * $adjTotal;
			$finalTotal = $adjTotal + $taxVal;
			
			$taxTotalFormatted = number_format($taxVal, 2, '.', ',');
			$html .= '<tr><td></td><td></td><td></td><td width="30%">GST:';
			$html .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>&nbsp; $'.$taxTotalFormatted.'</u></td></tr>';
			$finalTotalFormatted = number_format($finalTotal, 2, '.', ',');
			$html .= '<tr><td></td><td></td><td></td><td width="30%">Total:';
			$html .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u> $'.$finalTotalFormatted.'</u></td></tr>';
			
			$html .= '</table>';
			//die($html);
			$this->load->library('PDF');
			$pdf = new PDF('P', 'mm', 'A4', true, 'UTF-8', false);
			$pdf->SetHeaderMargin(30);
			$pdf->SetTopMargin(20);
			$pdf->setFooterMargin(20);
			$pdf->SetAutoPageBreak(true, 20);
			$pdf->AddPage();
			$pdf->writeHTML($html, true, false, true, false, '');
			$filename = 'WorkOrder-'.$id;
			$pdf->Output($filename, 'I');
		}
		
		/**
		 * Same idea as the printWorkOrder() function, except it creates a pdf with a little less information displayed
		 * so that it can be given/shown to customers.
		 * 
		 * @param $id the work order id that will be used to generate a printable report.
		 */
		function printCustSummary($id) {
			$this->load->helper('url'); 
    		$home = base_url();
			
			//Gets the information that we will use
			$results = $this->dbm->getWorkOrderById($id);
			$workOrder = $results->row_array();
			
			$results = $this->dbm->getCustomerById($workOrder['cust_id']);
			$customer = $results->row_array();
			
			$results = $this->dbm->getPaymentByWOID($id);
			$payment = $results->row_array();
		
			$results = $this->dbm->getTravelByWOID($id);
			$travel = $results->row_array();
			if(count($travel) == 0 || $travel['travel_distance'] == 0.00 && $travel['travel_price'] == 0.00)
				$travelEntered = false;
			else 
				$travelEntered = true;
			
			$carpet = $this->dbm->getServiceByWOID($id);
			$upholstery = $this->dbm->getUpholsteryByWOID($id);
			$stainguard = $this->dbm->getStainGuardByWOID($id);
			$other = $this->dbm->getOtherByWOID($id);
			
			$subTotal = 0;
			$travelTotal = 0;
			$gst = 0;
			$adjTotal = 0;
			$finalTotal = 0;
			$carpetTotal = 0;
			$sgTotal = 0;
			
			//die(var_dump($payment));
			//Format the work order date properly
			if($workOrder['wo_date'] == "0000-00-00" || $workOrder['wo_date'] == "1970-01-01" || $workOrder['wo_date'] == "1969-12-31") {
				$date = "";
			}
			else {
				$unix = strtotime($workOrder["wo_date"]);
				$formattedDate = date("m/d/Y", $unix);
				$date = $formattedDate;
			}
			
			//Image tags for checkboxes, to be used for equipment/payment options.
			$checked='<img src="'.$home.'images/checked.png"  height="10"/>';
			$unchecked='<img src="'.$home.'images/unchecked.png"  height="10"/>';
			
			$html ='<table style="width: 100%; "><tr><td style="border-bottom: 1px solid black;"></td><td colspan="2" style="text-align: center; border-bottom: 1px solid black;"><h1>Customer Summary</h1></td>
						<td style="text-align:center; line-height: 3px; border-bottom: 1px solid black;"><b>Date: '.$date.'</b></td></tr>';
			
			$html .= '<tr><td><br></td></tr>'; //The only way TCPDF will seem to space out table cells, css doesn't work.
			$html .= '<tr><td><u>Customer Information:</u></td>
					 	 <td colspan="2" align="center"><u>Cleaning To Be Done At:</u></td><td align="center"><b>ID: </b>'.$id.'</td></tr>';
			
			$html .= '<tr><td><br></td></tr>';
			$html .= '<tr><td width="200px"><b>Company:</b> '.$customer['cust_company'].'</td><td colspan="2"><b>Address:</b> '.$workOrder['wo_address'].'</td></tr>';
			$html .= '<tr><td width="256px"><b>Name:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b> '.$customer['cust_fname'].' '.$customer['cust_lname'].'
						  </td><td colspan="2">'.$workOrder['wo_city'].', '.$workOrder['wo_prov'].'</td></tr>';
			$html .= '<tr><td width="256px"><b>Email:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b> '.$customer['cust_email'].'
						  </td><td colspan="2">'.$workOrder['wo_pcode'].'</td></tr>';
						  
			$html .= '<tr><td width="200px"><b>Address:&nbsp;&nbsp;</b> '.$customer['cust_address'].'
						  </td><td width="150"><b>Phone: &nbsp;&nbsp;&nbsp;</b>'.$workOrder['wo_phone'].'</td>
						  <td width="188"><b>Gift: </b>'.$payment['pay_gift'].'</td></tr>';
			$html .= '<tr><td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							'.$customer['cust_city'].', '.$customer['cust_prov'].'</td></tr>';
			$html .= '<tr><td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							'.$customer['cust_pcode'].'</td></tr>';
			$html .= '<tr><td><br></td></tr>';			  		
			$html .= '<tr><td><b>Home Phone:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b> '.$customer['cust_hphone'].'</td>
						  	  <td rowspan="4" width="320"><br></td></tr>';
			
			$html .= '<tr><td><b>Business Phone:</b> '.$customer['cust_bphone'].'</td></tr>';
			$html .= '<tr><td><b>Cell Phone:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b> '.$customer['cust_cphone'].'</td></tr>';
			$html .= '<tr><td><br></td></tr>';
			$html .= '<tr><td><br></td></tr>';
			$html .= "</table>";
			
			//Outputs the work order table data
			$html .='<table style="width: 100%;" align="center"><tr>
							<td style="border-bottom: 1px solid black;"><b>Category</b></td>
							<td style="border-bottom: 1px solid black;"><b>Quantity</b></td>
							<td style="border-bottom: 1px solid black;"><b>Price</b></td></tr>';
			
			foreach($carpet->result_array() as $row) {
				$carpetTotal += $row['serv_ext_price'];	
				$subTotal += $row['serv_ext_price'];
			}

			if($carpet->num_rows > 0) {
				$carpetTotal = number_format($carpetTotal, 2, '.', '');
				$html .= '<tr><td>Carpet</td>';
				$html .= '<td>N/A</td>';
				$html .= '<td>$'.$carpetTotal.'</td></tr>';
			}

			foreach($upholstery->result_array() as $row) {
				$html .= '<tr><td>'.$row['up_description'].'</td>';
				$html .= '<td>'.$row['up_quantity'].'</td>';
				$html .= '<td> $'.$row['up_ext_price'].'</td></tr>';
				$subTotal += $row['up_ext_price'];
			}
			
			foreach($stainguard->result_array() as $row) {
				$sgTotal += $row['sg_ext_price'];	
				$subTotal += $row['sg_ext_price'];
			}
			if($stainguard->num_rows > 0) {
				$sgTotal = number_format($sgTotal, 2, '.', '');
				$html .= '<tr><td>Stain Guard</td>';
				$html .= '<td>N/A</td>';
				$html .= '<td>$'.$sgTotal.'</td></tr>';
			}
			foreach($other->result_array() as $row) {
				$html .= '<tr><td>'.$row['other_description'].'</td>';
				$html .= '<td>'.$row['other_quantity'].'</td>';
				$html .= '<td> $'.$row['other_ext_price'].'</td></tr>';
				$subTotal += $row['other_ext_price'];
			}
			if($travelEntered) {
				$travelTotal = $travel['travel_distance'] * $travel['travel_price'];
				$subTotal += $travelTotal;
				$travelTotalFormatted = number_format($travelTotal, 2, '.', '');	
				$html .= '<tr><td colspan="2">Travel<br></td>';
				$html .= '<td>$'.$travelTotalFormatted.'</td></tr>';
			}
			$html .= '<tr><td><br></td></tr>';
			$html .= '<tr><td><br></td></tr>';
			$html .= '<tr><td><br></td></tr>';
			$html .= '<tr><td><br></td></tr>';
			$html .= '<tr><td><br></td></tr>';
			$html .= '<tr><td><br></td></tr>';
			$html .= '<tr><td><br></td></tr>';
			$html .= '<tr><td><br></td></tr>';
			$html .= "</table>";
			
			//Payment/other information to be displayed at the bottom.
			$html .= '<table><tr><td></td>';
			$html .= '<td border="1" colspan="3"><b> Payment Method: </b>';
			//Checking payment methods to be checked or not.
			if($workOrder['pay_cash'] == 1)
				$html .= $checked.' Cash &nbsp;&nbsp;&nbsp;';
			else 
				$html .= $unchecked.' Cash &nbsp;&nbsp;&nbsp;';
			if($workOrder['pay_cheque'] == 1)
				$html .= $checked.' Cheque &nbsp;&nbsp;&nbsp;';
			else 
				$html .= $unchecked.' Cheque &nbsp;&nbsp;&nbsp;';
			if($workOrder['pay_cc'] == 1)
				$html .= $checked.' Credit Card &nbsp;&nbsp;&nbsp;';
			else 
				$html .= $unchecked.' Credit Card &nbsp;&nbsp;&nbsp;';
			if($workOrder['pay_charge'] == 1)
				$html .= $checked.' Charge <br>';
			else 
				$html .= $unchecked.' Charge <br>';
			if($workOrder['pay_debit'] == 1)
				$html .= '&nbsp;'.$checked.' Debit &nbsp;&nbsp;&nbsp;';
			else 
				$html .= '&nbsp;'.$unchecked.' Debit &nbsp;&nbsp;&nbsp;';
			if($workOrder['pay_other'] != "")
				$html .= $checked.' Other: '.$workOrder['pay_other'];
			else 
				$html .= $unchecked.' Other';		
			$html .= '</td></tr>';
			$html .= '<tr><td><br></td></tr>';
			$html .= '<tr><td><br></td></tr>';
			
			$subTotalFormatted = number_format($subTotal, 2, '.', ',');
			$html .= '<tr><td><b>Notes:</b></td><td></td><td width="30%"></td><td width="20%">Subtotal:';
			$html .= '&nbsp;&nbsp;<u> &nbsp;$'.$subTotalFormatted.'</u></td></tr>';
			
			$html .= '<tr><td></td><td></td><td width="30%"></td><td width="20%">Discount:';
			if($payment['pay_discount_type'] == "$") {
				$discount = "$".$payment['pay_discount'];
				$adjTotal = $subTotal - $payment['pay_discount'];
			}
			else {
				//$discount = $payment['pay_discount']."%";
				$discountVal = $payment['pay_discount'] /100 * $carpetTotal;
				//$discount = "$".$discountVal;
				$discount = "$".number_format($discountVal, 2, '.', ',');
				$adjTotal = $subTotal - $discountVal;
				//$discountVal = $subTotal * discountVal;
			}
			$html .= '&nbsp;&nbsp;<u> &nbsp;'.$discount.'</u></td></tr>';
			
			$adjTotalFormatted = number_format($adjTotal, 2, '.', ',');
			$html .= '<tr><td></td><td></td><td></td><td width="30%">Adj. Total:';
			$html .= '&nbsp;<u> $'.$adjTotalFormatted.'</u></td></tr>';
			
			$taxVal = $payment['pay_tax_rate'] /100 * $adjTotal;
			$finalTotal = $adjTotal + $taxVal;
			
			$taxTotalFormatted = number_format($taxVal, 2, '.', ',');
			$html .= '<tr><td></td><td></td><td></td><td width="30%">GST:';
			$html .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>&nbsp; $'.$taxTotalFormatted.'</u></td></tr>';
			$finalTotalFormatted = number_format($finalTotal, 2, '.', ',');
			$html .= '<tr><td></td><td></td><td></td><td width="30%">Total:';
			$html .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u> $'.$finalTotalFormatted.'</u></td></tr>';
			
			$html .= '</table>';
			//die($html);
			$this->load->library('PDF');
			$pdf = new PDF('P', 'mm', 'A4', true, 'UTF-8', false);
			$pdf->SetHeaderMargin(30);
			$pdf->SetTopMargin(20);
			$pdf->setFooterMargin(20);
			$pdf->SetAutoPageBreak(true, 20);
			$pdf->AddPage();
			$pdf->writeHTML($html, true, false, true, false, '');
			$filename = 'WorkOrder-'.$id;
			$pdf->Output($filename, 'I');
		}
		
		/**
		 * Gets all of the records from the service table that match the $woID, and puts them into an editable table.
		 * Returns the table as a string, to be loaded into the view.
		 * 
		 * @param $woID The work order ID to be used to get the service records.
		 */
		function getServiceTableForWO($woID) {
			$tableStatus = "full";
			
			//Gets each row from service that is tied to the open work order.
			//Puts the content into a table to be displayed. Each cell has classes that will make them editable/savable.				
			$results = $this->dbm->getServiceByWOID($woID);
					
			//If there's no results passed back from the query, set $tableStatus to empty
			if(!$results->result()) {
				$tableStatus = "empty";
			}
				
			$serviceTable = "<table id='service-table' class='tablesorter table-striped ".$tableStatus."'>
							<thead>
								<tr>
									<th>Description</th>
									<th>Color/Type</th>
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
			
			foreach($results->result_array() as $row) {
				$serviceTable .= "<tr><td class='editable service serv_description ".$row['serv_id']." text'>".$row['serv_description']."</td>";
				$serviceTable .= "<td class='editable service serv_type ".$row['serv_id']." text'>".$row['serv_type']."</td>";
				$serviceTable .= "<td class='editable service serv_length ".$row['serv_id']." num'>".$row['serv_length']."</td>";
				$serviceTable .= "<td class='editable service serv_width ".$row['serv_id']." num'>".$row['serv_width']."</td>";
				$serviceTable .= "<td class='uneditable service serv_sq_feet ".$row['serv_id']." num'>".$row['serv_sq_feet']."</td>";
				$serviceTable .= "<td class='editable service serv_quantity ".$row['serv_id']." num'>".$row['serv_quantity']."</td>";
				$serviceTable .= "<td class='editable service serv_unit_price ".$row['serv_id']." num'>".$row['serv_unit_price']."</td>";
				$serviceTable .= "<td class='uneditable service serv_ext_price ".$row['serv_id']." num'></td>";
				$serviceTable .= "<td class='serv-delete-row'><button class='btn btn-danger btn-deleterow' onclick='deleteTableRow(".$row['serv_id'].", ".$row['wo_id'].", \"service\", \"serv_id\", \"#carpetTab\")'>Delete</button></td></tr>";
			}
			
			$serviceTable .= "</tbody></table>";
			$serviceTable .= "<div>";
								
							  //Formats the two total price outputs properly, in order to use bootstrap.	
			$serviceTable .= '<div class="totals-div"><label>Total Carpet Sq Ft: </label>
								  	<input id="total-service-sqft" class="input-small span2" type="text" value="0.00" readonly>
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
			$tableStatus = "full";	
				
			//Gets each row from upholstery that is tied to the open work order.
			//Puts the content into a table to be displayed. Each cell has classes that will make them editable/savable.				
			$results = $this->dbm->getUpholsteryByWOID($woID);	
			
			//If there's no results passed back from the query, set $tableStatus to empty
			if(!$results->result()) {
				$tableStatus = "empty";
			}
				
			$upholsteryTable = "<table id='upholstery-table' class='tablesorter table-striped ".$tableStatus."'>
							<thead>
								<tr>
									<th>Description</th>
									<th>Color/Type</th>
									<th>Quantity</th>
									<th>Unit Price($)</th>
									<th>Extended Price($)</th>
									<th></th>
								</tr>
							</thead>
							<tbody>";
							
			foreach($results->result_array() as $row) {
				$upholsteryTable .= "<tr><td class='editable upholstery up_description ".$row['up_id']." text'>".$row['up_description']."</td>";
				$upholsteryTable .= "<td class='editable upholstery up_type ".$row['up_id']." text'>".$row['up_type']."</td>";
				$upholsteryTable .= "<td class='editable upholstery up_quantity ".$row['up_id']." num'>".$row['up_quantity']."</td>";
				$upholsteryTable .= "<td class='editable upholstery up_unit_price ".$row['up_id']." num'>".$row['up_unit_price']."</td>";
				$upholsteryTable .= "<td class='uneditable upholstery up_ext_price ".$row['up_id']."'></td>";
				$upholsteryTable .= "<td class='up-delete-row'><button class='btn btn-danger btn-deleterow' onclick='deleteTableRow(".$row['up_id'].", ".$row['wo_id'].", \"upholstery\", \"up_id\", \"#upholsteryTab\")'>Delete</button></td></tr>";
			}
			
			$upholsteryTable .= "</tbody></table>";
			$upholsteryTable .= "<div>";
			$upholsteryTable .= '<div class="totals-div">
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
			$tableStatus = "full";
			
			//Gets each row from stain_guard that is tied to the open work order.
			//Puts the content into a table to be displayed. Each cell has classes that will make them editable/savable.				
			$results = $this->dbm->getStainGuardByWOID($woID);
			
			//If there's no results passed back from the query, set $tableStatus to empty
			if(!$results->result()) {
				$tableStatus = "empty";
			}
			
			$stainguardTable = "<table id='stainguard-table' class='tablesorter table-striped ".$tableStatus."'>
							<thead>
								<tr>
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
			
			foreach($results->result_array() as $row) {
				$stainguardTable .= "<tr><td class='editable stain_guard sg_description ".$row['sg_id']." text'>".$row['sg_description']."</td>";
				$stainguardTable .= "<td class='editable stain_guard sg_length ".$row['sg_id']." num'>".$row['sg_length']."</td>";
				$stainguardTable .= "<td class='editable stain_guard sg_width ".$row['sg_id']." num'>".$row['sg_width']."</td>";
				$stainguardTable .= "<td class='uneditable stain_guard sg_sq_feet ".$row['sg_id']."'>".$row['sg_sq_feet']."</td>";
				$stainguardTable .= "<td class='editable stain_guard sg_quantity ".$row['sg_id']." num'>".$row['sg_quantity']."</td>";
				$stainguardTable .= "<td class='editable stain_guard sg_unit_price ".$row['sg_id']." num'>".$row['sg_unit_price']."</td>";
				$stainguardTable .= "<td class='uneditable stain_guard sg_ext_price ".$row['sg_id']."'></td>";
				$stainguardTable .= "<td class='sg-delete-row'><button class='btn btn-danger btn-deleterow' onclick='deleteTableRow(".$row['sg_id'].", ".$row['wo_id'].", \"stain_guard\", \"sg_id\", \"#stainGuardTab\")'>Delete</button></td></tr>";
			}
			
			$stainguardTable .= "</tbody></table>";
			$stainguardTable .= "<div>";
			$stainguardTable .= '<div class="totals-div"><label>Total Stain Guard Sq Ft: </label>
								  	<input id="total-stainguard-sqft" class="input-small span2" type="text" value="0.00" readonly>
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
				$tableStatus = "full";
				
				//Gets each row from other that is tied to the open work order.
				//Puts the content into a table to be displayed. Each cell has classes that will make them editable/savable.
				$results = $this->dbm->getOtherByWOID($woID);
				
				//If there's no results passed back from the query, set $tableStatus to empty
				if(!$results->result()) {
					$tableStatus = "empty";
				}
				
				$otherTable = "<table id='other-table' class='tablesorter table-striped ".$tableStatus."'>
							<thead>
								<tr>
									<th>Description</th>
									<th>Color/Type</th>
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
				
				foreach($results->result_array() as $row) {
					$otherTable .= "<tr><td class='editable other other_description ".$row['other_id']." text'>".$row['other_description']."</td>";	
					$otherTable .= "<td class='editable other other_type ".$row['other_id']." text'>".$row['other_type']."</td>";
					$otherTable .= "<td class='editable other other_length ".$row['other_id']." num'>".$row['other_length']."</td>";
					$otherTable .= "<td class='editable other other_width ".$row['other_id']." num'>".$row['other_width']."</td>";
					$otherTable .= "<td class='uneditable other other_sq_feet ".$row['other_id']."'>".$row['other_sq_feet']."</td>";
					$otherTable .= "<td class='editable other other_quantity ".$row['other_id']." num'>".$row['other_quantity']."</td>";
					$otherTable .= "<td class='editable other other_unit_price ".$row['other_id']." num'>".$row['other_unit_price']."</td>";
					$otherTable .= "<td class='uneditable other other_ext_price ".$row['other_id']."'></td>";
					$otherTable .= "<td class='other-delete-row'><button class='btn btn-danger btn-deleterow' onclick='deleteTableRow(".$row['other_id'].", ".$row['wo_id'].", \"other\", \"other_id\", \"#otherTab\")'>Delete</button></td></tr>";
				}
				
				$otherTable .= "</tbody></table>";
				$otherTable .= "<div>";
				$otherTable .= '<div class="totals-div"><label>Total Other Sq Ft: </label>
									<input id="total-other-sqft" class="input-small span2" type="text" value="0.00" readonly>
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
		
		/**
		 * Is posted two work order id's and copy's all of the table rows from the old work order
		 * to a new one.
		 */
		function copyDataTables() {
			$oldID = $_POST['oldID'];
			$newID = $_POST['newID'];
			
			//Copies values from each service record
			$oldServiceTable = $this->dbm->getServiceByWOID($oldID);
			foreach($oldServiceTable->result_array() as $row) {
				$servData['wo_id'] = $newID;	
				$servData['serv_description'] = $row['serv_description'];
				$servData['serv_unit_price'] = $row['serv_unit_price'];
				$servData['serv_quantity'] = $row['serv_quantity'];
				$servData['serv_length'] = $row['serv_length'];
				$servData['serv_width'] = $row['serv_width'];
				$servData['serv_sq_feet'] = $row['serv_sq_feet'];
				$servData['serv_type'] = $row['serv_type'];
				$servData['serv_ext_price'] = $row['serv_ext_price'];
				$this->dbm->insertNewWOdata('service', $servData);
			}
			
			//Copies values from each upholstery record
			$oldUpholsteryTable = $this->dbm->getUpholsteryByWOID($oldID);
			foreach($oldUpholsteryTable->result_array() as $row) {
				$upData['wo_id'] = $newID;	
				$upData['up_description'] = $row['up_description'];
				$upData['up_unit_price'] = $row['up_unit_price'];
				$upData['up_quantity'] = $row['up_quantity'];
				$upData['up_type'] = $row['up_type'];
				$upData['up_ext_price'] = $row['up_ext_price'];
				$this->dbm->insertNewWOdata('upholstery', $upData);
			}
			
			//Copies values from each stain guard record
			$oldSGTable = $this->dbm->getStainGuardByWOID($oldID);
			foreach($oldSGTable->result_array() as $row) {
				$sgData['wo_id'] = $newID;	
				$sgData['sg_description'] = $row['sg_description'];
				$sgData['sg_unit_price'] = $row['sg_unit_price'];
				$sgData['sg_quantity'] = $row['sg_quantity'];
				$sgData['sg_length'] = $row['sg_length'];
				$sgData['sg_width'] = $row['sg_width'];
				$sgData['sg_sq_feet'] = $row['sg_sq_feet'];
				$sgData['sg_type'] = $row['sg_type'];
				$sgData['sg_ext_price'] = $row['sg_ext_price'];
				$this->dbm->insertNewWOdata('stain_guard', $sgData);
			}
			
			//Copies values from each other record
			$oldOtherTable = $this->dbm->getOtherByWOID($oldID);
			foreach($oldOtherTable->result_array() as $row) {
				$otherData['wo_id'] = $newID;	
				$otherData['other_description'] = $row['other_description'];
				$otherData['other_unit_price'] = $row['other_unit_price'];
				$otherData['other_quantity'] = $row['other_quantity'];
				$otherData['other_length'] = $row['other_length'];
				$otherData['other_width'] = $row['other_width'];
				$otherData['other_sq_feet'] = $row['other_sq_feet'];
				$otherData['other_type'] = $row['other_type'];
				$otherData['other_ext_price'] = $row['other_ext_price'];
				$this->dbm->insertNewWOdata('other', $otherData);
			}
			
		}
	}
	
?>