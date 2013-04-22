<?php

	/**
	 * @file workOrderSearch.php
	 * @brief Contains the WorkOrderSearch class that handles all the functionality of the work order search page.
	 */
	class WorkOrderSearch extends CI_Controller {
		
		/**
		 * Default Constructor
		 */
		public function WorkOrderSearch() {
			//Call CI Controller's default constructor
			parent::__construct();
			//Loads the database model functions as "dbm"
			$this->load->model("dbmodel", "dbm", true);
			session_start();
		}
		
		/**
		 * Does session varification, and then loads certain fields of all work orders, to be used in the autocomplete tags.
		 * The workorderSearch view is loaded and has the tags passed to it.
		 */
		public function index() {
			if(!isset($_SESSION['id'])) {
				$this->load->helper('url'); 
    			$home = base_url();
				header("Location: ".$home."index.php/login");
			}
			else {
				$i = 0;
				$tags = array();
				
				//Gets select fields from the database to be used for our auto complete tags.
				$results = $this->dbm->getWorkOrderTags(); 
				foreach($results->result_array() as $row) {
					
					//Replaces spaces with _ characters from first and last names, for the autocomplete.
					//Then will replace _ characters with spaces on the search query.
					//It's not ideal, but it prevents issues with customers from the old database that could have spaces in the
					//first and last names.
					$tags[$i]['cust_fname'] = str_replace(" ", "_", $row['cust_fname']); 
					$tags[$i]['cust_lname'] =str_replace(" ", "_", $row['cust_lname']);
					$tags[$i]['cust_company'] = $row['cust_company'];
					$tags[$i]['wo_city'] = $row['wo_city'];
					$tags[$i]['wo_address'] = $row['wo_address'];
					
					//Formats date to DD/MM/YYYY, before being put into the autocomplete.
					//Not sure we even need autocomplete for dates... It seems pretty pointless, just as long as they know
					//the format to search.
					$unix = strtotime($row["wo_date"]);
					$formattedDate = date("d/m/Y", $unix);
					$tags[$i]['wo_date'] = $formattedDate;
					$i++;
				}
				
				$tags = json_encode($tags);
				
				$data['tags'] = $tags; //this passes $tags to each page that $data is loaded.
				$data['custNum'] = $i; //this passes $custNum to each page that $data is loaded.
				$data['title'] = "Search Work Orders";
				$this->load->view('header.php', $data);
				$this->load->view('workOrderSearch_view.php', $data);
			}
		}
		
		/**
		 * Gets the results of a search, based on the string that the user inputs, as well as the type
		 * of search specified in the dropdown box. It takes these results and outputs them to a table to be 
		 * displayed on the view.
		 * Returns the resulting table as a string.
		 */
		function showResults() {
			$searchQuery = $_POST['searchQ'];
			$searchType = $_POST['searchType'];
			
			// If they're searching by date, need to format the date to match the database
			if($searchType == "wo_date") {
				$unix = strtotime($searchQuery); //Creates Unix Timestamp based on input date.
				$searchQuery = date("Y-m-d", $unix); //Formats Unix Timestamp to work with SQL Date Format.
			}
			
			//checks to see what is being searched, and adds other fields if needed.
			if($searchType == "cust_fname") {
				
				// Checks if there's a space in the search query, if true it splits the words
				// In order to search first and last names.
				if ( preg_match('/\s/', $searchQuery) ) {
					$names = explode(" ", $searchQuery);
					//Replaces the underscores that were entered in the autocomplete array with spaces
					$results = $this->dbm->getWorkOrdersByNameSearch(str_replace("_", " ", $names[0]), str_replace("_", " ", $names[1]));
				}
				else {
					$field2 = "cust_lname";
					$results = $this->dbm->getWorkOrdersBySearch($searchQuery, $searchType, $field2, false);
				}
				
			}
			
			else {
				$results = $this->dbm->getWorkOrdersBySearch($searchQuery, $searchType, false, false);
			}
			
			//if nothing's returned from the database query, return this error message.
			if(!$results->result()) {
				echo "<div class='alert alert-error'><h4>Whoops!</h4>
					  There's nothing in the database matching that search</div>";
				return;
			}
			
			//creates table that will be returned as string, and will be output to workordersearch_view.
			$tableData = "<table id='result-table' class='tablesorter table-striped table-hover'>
							<thead>
								<tr>
									<th>Date (MM/DD/YYYY)</th>
									<th>Customer</th>
									<th>Company</th>
									<th>City</th>
									<th>Address</th>
								</tr>
							</thead>
							<tbody>";
						
			foreach($results->result_array() as $row) {
				
				$tableData .= "<tr onclick='openWorkOrder(".$row['wo_id'].")'>";
				
				//Formats date to MM/DD/YYYY, before being output to the table, if it's 0's output no date.
				if($row['wo_date'] == "0000-00-00" || $row['wo_date'] == "1970-01-01" ||  $row['wo_date'] == "1969-12-31") {
					$tableData .= '<td></td>';
				}
				else {
					$unix = strtotime($row["wo_date"]);
					$formattedDate = date("m/d/Y", $unix);
					$tableData .= '<td>'.$formattedDate.'</td>';
				}
				
				$tableData .= '<td>'.$row["cust_fname"]. ' ' .$row["cust_lname"].'</td>';
				$tableData .= '<td>'.$row["cust_company"].'</td>';
				$tableData .= '<td>'.$row["wo_city"].'</td>';
				$tableData .= '<td>'.$row["wo_address"].'</td></tr>'; //remove '</tr>' when line below is ready
			}
			
			$tableData .= "</tbody></table>";
			
			echo $tableData;
		}
		
		/**
		 * This function recieves a customer id, and gets all workorders that are tied to that customer id.
		 * It outputs the results to a table and returns the table as a string, to be displayed in the view.
		 * 
		 * @param $custID the customer id used to search for work orders.
		 */
		function showAllForCust($custID) {
			if(!isset($_SESSION['id'])) {
				$this->load->helper('url'); 
    			$home = base_url();
				header("Location: ".$home."index.php/login");
			}
			else {	
				$i = 0;
				$tags = array();
				
				//Gets select fields from the database to be used for our auto complete tags.
				$results = $this->dbm->getWorkOrderTags(); 
				foreach($results->result_array() as $row) {
					$tags[$i]['cust_fname'] = $row['cust_fname'];
					$tags[$i]['cust_lname'] = $row['cust_lname'];
					$tags[$i]['cust_company'] = $row['cust_company'];
					$tags[$i]['wo_city'] = $row['wo_city'];
					$tags[$i]['wo_address'] = $row['wo_address'];
					$tags[$i]['wo_date'] = $row['wo_date'];
					$i++;
				}
				$tags = json_encode($tags);
				
				$workOrders = $this->dbm->getWorkOrdersByCustId($custID);
				
				if(!$workOrders->result()) {
					$tableData =  "<div class='alert alert-error'><h4>Whoops!</h4>
						  There Are No Work Orders For This Customer</div>";
				}
				else {
					//creates table that will be returned as string, and will be output to workordersearch_view.
					$tableData = "<table id='result-table' class='tablesorter table-striped table-hover'>
									<thead>
										<tr>
											<th>Date</th>
											<th>Customer</th>
											<th>Company</th>
											<th>City</th>
											<th>Address</th>
										</tr>
									</thead>
									<tbody>";
								
					foreach($workOrders->result_array() as $row) {
						
						$tableData .= "<tr onclick='openWorkOrder(".$row['wo_id'].")'>";
						
						//Formats date to MM/DD/YYYY, before being output to the table, if it's 0's output no date.
						if($row['wo_date'] == "0000-00-00" || $row['wo_date'] == "1970-01-01" ||  $row['wo_date'] == "1969-12-31") {
							$tableData .= '<td></td>';
						}
						else {
							$unix = strtotime($row["wo_date"]);
							$formattedDate = date("m/d/Y", $unix);
							$tableData .= '<td>'.$formattedDate.'</td>';
						}
				
						$tableData .= '<td>'.$row["cust_fname"]. ' ' .$row["cust_lname"].'</td>';
						$tableData .= '<td>'.$row["cust_company"].'</td>';
						$tableData .= '<td>'.$row["wo_city"].'</td>';
						$tableData .= '<td>'.$row["wo_address"].'</td></tr>'; //remove '</tr>' when line below is ready
					}
					
					$tableData .= "</tbody></table>";
				}
				
				$data['tags'] = $tags; //this passes $tags to each page that $data is loaded.
				$data['custNum'] = $i; //this passes $custNum to each page that $data is loaded.
				$data['title'] = "Viewing Work Orders";
				$data['header'] = "Showing Customer Work Orders";
				$data['tableData'] = $tableData;
				
				$this->load->view('header.php', $data);
				$this->load->view('workOrderSearch_view.php', $data);
			}
		}
	}
	
?>