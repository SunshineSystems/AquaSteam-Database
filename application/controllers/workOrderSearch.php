<?php
	class WorkOrderSearch extends CI_Controller {
		
		public function WorkOrderSearch() {
			//Call CI Controller's default constructor
			parent::__construct();
			//Loads the database model functions as "dbm"
			$this->load->model("dbmodel", "dbm", true);
		}
		
		public function index() {
			
			
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
				$i++;
			}
			
			$tags = json_encode($tags);
			
			$data['title'] = "Search Work Orders";
			$this->load->view('header.php', $data);
			$this->load->view('workOrderSearch_view.php');
		}
		
		function updateTags() {
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
				$i++;
			}
			
			$jtags = json_encode($tags);
			echo $jtags;
		}
		
		// Gets the results of the search, based on the string that the user inputs, as well
		// as the type of search specified in the dropdown.
		function showResults() {
			$searchQuery = $_POST['searchQ'];
			$searchType = $_POST['searchType'];
			
			//checks to see what is being searched, and adds other fields if needed.
			if($searchType == "cust_fname") {
				
				// Checks if there's a space in the search query, if true it splits the words
				// In order to search first and last names.
				if ( preg_match('/\s/', $searchQuery) ) {
					$names = explode(" ", $searchQuery);
					$results = $this->dbm->getCustomersByNameSearch($names[0], $names[1]);
				}
				else {
					$field2 = "cust_lname";
					$results = $this->dbm->getCustomersBySearch($searchQuery, $searchType, $field2, false);
				}
				
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
									<th>Company</th>
									<th>First Name</th>
									<th>Lastname</th>
									<th>Address</th>
								</tr>
							</thead>
							<tbody>";
						
			foreach($results->result_array() as $row) {
				$tableData .= "<tr onclick='openCustomer(".$row['cust_id'].")'>";
				$tableData .= '<td>'.$row["cust_company"].'</td>';
				$tableData .= '<td>'.$row["cust_fname"].'</td>';
				$tableData .= '<td>'.$row["cust_lname"].'</td>';
				$tableData .= '<td>'.$row["cust_address"].'</td></tr>';
			}
			
			$tableData .= "</tbody></table>";
			
			echo $tableData;
		}
	}
	
?>