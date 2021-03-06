<?php

	/**
	 * @file customer.php
	 * @brief Contains the customer class that handles all of the customer page functionality
	 */
	 
	 
	class Customer extends CI_Controller {
		
		 
		 /** Default Constructor
		 */
		public function Customer() {
			//Call CI Controller's default constructor
			parent::__construct();
			//Loads the database model functions as "dbm"
			$this->load->model("dbmodel", "dbm", true);
			session_start();
		}
		
		/** This is called when SiteDomain/aquasteam-database/index.php/customer is loaded in the browser.
		 *  It passes select customer values to the view that are to be used as our tags for autocomplete.			
		 */
		public function index()
		{
			if(!isset($_SESSION['id'])) {
				header('Location: login');
			}
			else {
				$i = 0;
				$tags = array();
				
				//Gets all customers from the database, and adds certain fields to an array
				//to be used for our auto complete.
				$custs = $this->dbm->getAllCustomers();
				foreach($custs->result_array() as $row) {
					//Replaces spaces with _ characters from first and last names, for the autocomplete.
					//Then will replace _ characters with spaces on the search query.
					//It's not ideal, but it prevents issues with customers from the old database that could have spaces in the
					//first and last names.
					$tags[$i]['cust_fname'] = str_replace(" ", "_", $row['cust_fname']); 
					$tags[$i]['cust_lname'] =str_replace(" ", "_", $row['cust_lname']);
					$tags[$i]['cust_company'] = $row['cust_company'];
					$tags[$i]['cust_address'] = $row['cust_address'];
					$tags[$i]['cust_city'] = $row['cust_city'];
					$tags[$i]['cust_hphone'] = $row['cust_hphone'];
					$tags[$i]['cust_bphone'] = $row['cust_bphone'];
					$tags[$i]['cust_cphone'] = $row['cust_cphone'];
					$i++;
				}
				
				$tags = json_encode($tags);
				
				$data['title'] = "Customers";
				$data['tags'] = $tags;
				$data['custNum'] = $i;
				$this->load->view('header', $data);
				$this->load->view('customer_view', $data);
			}
		}
		
		
		
		/**  Gets the results of the search, based on the string that the user inputs, as well
		 *  as the type of search specified in the dropdown.
		 */
		function showResults() {
			$this->load->helper('url');
			$home = base_url();
			$searchQuery = $_POST['searchQ'];
			$searchType = $_POST['searchType'];
			
			//checks to see what is being searched, and adds other fields if needed.
			if($searchType == "cust_fname") {
				
				// Checks if there's a space in the search query, if true it splits the words
				// In order to search first and last names.
				if ( preg_match('/\s/', $searchQuery) ) {
					$names = explode(" ", $searchQuery);
					//Replaces the underscores that were entered in the autocomplete array with spaces
					$results = $this->dbm->getCustomersByNameSearch(str_replace("_", " ", $names[0]), str_replace("_", " ", $names[1]));
				}
				else {
					$field2 = "cust_lname";
					$results = $this->dbm->getCustomersBySearch($searchQuery, $searchType, $field2, false);
				}
				
			}
			//If user searches for a phone number, it searches all phone number fields. 
			else if($searchType == "cust_hphone") {
				$field2 = "cust_bphone";
				$field3 = "cust_cphone";
				$results = $this->dbm->getCustomersBySearch($searchQuery, $searchType, $field2, $field3);
			}
			else {
				$results = $this->dbm->getCustomersBySearch($searchQuery, $searchType, false, false);
			}
			if(!$results->result()) {
				echo "<div class='alert alert-error'><h4>Whoops!</h4>
					  There's nothing in the database matching that search</div>";
				return;
			}
			//creates table that will be returned as string, and will be output to customer_view.
			$tableData = "<table id='result-table' class='tablesorter table-striped table-hover'>
							<thead>
								<tr>
									<th>First Name</th>
									<th>Last Name</th>
									<th>Company</th>
									<th>Address</th>
									<th>City</th>
									<th>Home Phone</th>
									<th>Bus. Phone</th>
									<th>Cell Phone</th>
								</tr>
							</thead>
							<tbody>";
						
			foreach($results->result_array() as $row) {
				$tableData .= "<tr onclick='openCustomer(".$row['cust_id'].")'>";
				$tableData .= '<td>'.$row["cust_fname"].'</td>';
				$tableData .= '<td>'.$row["cust_lname"].'</td>';
				$tableData .= '<td>'.$row["cust_company"].'</td>';
				$tableData .= '<td>'.$row["cust_address"].'</td>';
				$tableData .= '<td>'.$row["cust_city"].'</td>';
				$tableData .= '<td>'.$row["cust_hphone"].'</td>';
				$tableData .= '<td>'.$row["cust_bphone"].'</td>';
				$tableData .= '<td>'.$row["cust_cphone"].'</td></tr>';
			}
			
			$tableData .= "</tbody></table>";
			
			echo $tableData;
		}

		/**
		 * Gets all of the data fields associated with the given customer ID.
		 * Returns a json string to be handled by javascript.
		 */
		function getCustInfo() {
			$id = $_POST['id'];
			$output = array();
			$result = $this->dbm->getCustomerById($id);
			
			foreach($result->result_array() as $row) {
				$output['cust_fname'] = $row['cust_fname'];
				$output['cust_lname'] = $row['cust_lname'];
				$output['cust_company'] = $row['cust_company'];
				$output['cust_address'] = $row['cust_address'];
				$output['cust_city'] = $row['cust_city'];
				$output['cust_prov'] = $row['cust_prov'];
				$output['cust_pcode'] = $row['cust_pcode'];
				$output['cust_hphone'] = $row['cust_hphone'];
				$output['cust_bphone'] = $row['cust_bphone'];
				$output['cust_cphone'] = $row['cust_cphone'];
				$output['cust_email'] = $row['cust_email'];
				$output['cust_referral'] = $row['cust_referral'];
				$output['cust_notes'] = $row['cust_notes'];
			}
			
			$output = json_encode($output);
			echo $output;
		}
		
		/**
		 * Takes the values passed from the view, and inserts them into the database,
		 * as either a new customer, or updating an existing customer.
		 */
		function saveCustomer() {
			$data = array();
			$id = $_POST['id']; //The id posted from the ajax call.
			$sanitizedFName = str_replace(" ", "", $_POST['fname']); //removes spaces from first name.
			$sanitizedLName = str_replace(" ", "", $_POST['lname']); //removes spaces from last name.
			
			//Need to remove underscores from first/last name to prevent future errors with our super hacky autocomplete workaround
			//on the search pages. You can find said fix in the index() functions in the customer/workordersearch controllers.
			$sanitizedFName = str_replace("_", "", $sanitizedFName); //removes underscores from first name.
			$sanitizedLName = str_replace("_", "", $sanitizedLName); //removes underscores from last name.
			
			
			$data['cust_fname'] = $sanitizedFName;
			$data['cust_lname'] = $sanitizedLName;
			$data['cust_company'] = $_POST['company'];
			$data['cust_address'] = $_POST['address'];
			$data['cust_city'] = $_POST['city'];
			$data['cust_prov']= $_POST['prov'];
			$data['cust_pcode'] = $_POST['pcode'];
			$data['cust_hphone'] = $_POST['hphone'];
			$data['cust_bphone'] = $_POST['bphone'];
			$data['cust_cphone'] = $_POST['cphone'];
			$data['cust_email'] = $_POST['email'];
			$data['cust_referral'] = $_POST['ref'];
			$data['cust_notes'] = $_POST['notes'];
			
			
			if(!$id) {
				$newCustID = $this->dbm->insertNewCustomer($data); //returns the id of the customer after insertion
				
				$feedback = "<div id='new-cust-alert' class='alert alert-success'><h4>Success!</h4>The New Customer Has Been Saved.<br>
							  Click<button id='new-cust-btn' class='btn btn-success' value=".$newCustID.">
							   Here</button>to view the customer</div>";
			}
			else {
				$this->dbm->updateCustomer($id, $data);
				$feedback = "<div class='alert alert-success'><h4>Success!</h4>
								The Customer Has Been Updated</div>";
			}
			
			echo $feedback;
		}
		
		/**
		 * Gets the customer's id from an ajax call, if for some reason there's no id, it returns an error to be displayed.
		 * else it deletes the customer using the model function, and returns the success message to be displayed.
		 */
		function deleteCustomer() {
			$id = $_POST['id'];
			
			if(!$id) {
				$feedback = "<div class='alert alert-error'><h4>Hmmm...</h4>
								There was an error; no customer was deleted.</div>";
			}
			else {
				$this->dbm->deleteCustomer($id);
				$feedback = "<div class='alert alert-success'><h4>Success!</h4>
								The Customer has been deleted from the database.</div>";
			}
			echo $feedback;
		}
		
		/**
		 * gotoCustomer is called when the "view customer" button is clicked on a work order form, the only difference
		 * from the regular page is that it sets a variable $id to be passed to the view, so that a customer will be
		 * opened immediately when the page loads.
		 */
		public function gotoCustomer($id)
		{
			if(!isset($_SESSION['id'])) {
				$this->load->helper('url'); 
    			$home = base_url();
				header("Location: ".$home."index.php/login");
			}
			else {	
				$i = 0;
				$tags = array();
				
				//Gets all customers from the database, and adds certain fields to an array
				//to be used for our auto complete.
				$custs = $this->dbm->getAllCustomers();
				foreach($custs->result_array() as $row) {
					$tags[$i]['cust_fname'] = $row['cust_fname'];
					$tags[$i]['cust_lname'] = $row['cust_lname'];
					$tags[$i]['cust_company'] = $row['cust_company'];
					$tags[$i]['cust_address'] = $row['cust_address'];
					$tags[$i]['cust_city'] = $row['cust_city'];
					$tags[$i]['cust_hphone'] = $row['cust_hphone'];
					$tags[$i]['cust_bphone'] = $row['cust_bphone'];
					$tags[$i]['cust_cphone'] = $row['cust_cphone'];
					$i++;
				}
				
				$tags = json_encode($tags);
				
				$data['id'] = $id;
				$data['title'] = "Customers";
				$data['tags'] = $tags;
				$data['custNum'] = $i;
				$this->load->view('header', $data);
				$this->load->view('customer_view', $data);
			}
		}
	}
?>