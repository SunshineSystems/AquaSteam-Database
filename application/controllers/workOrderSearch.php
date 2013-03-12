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
			
			//Gets select fields from the database to be used for our auto complete tags.
			$results = $this->dbm->getWorkOrderTags(); 
			foreach($results->result_array() as $row) {
				$tags[$i]['cust_fname'] = $row['cust_fname'];
				$tags[$i]['cust_lname'] = $row['cust_lname'];
				$tags[$i]['cust_company'] = $row['cust_company'];
				$tags[$i]['wo_city'] = $row['wo_city'];
				$tags[$i]['wo_address'] = $row['wo_address'];
				$tags[$i]['cwo_date'] = $row['wo_date'];
				$i++;
			}
			
			$tags = json_encode($tags);
			
			$data['tags'] = $tags; //this passes $tags to each page that $data is loaded.
			$data['custNum'] = $i; //this passes $custNum to each page that $data is loaded.
			$data['title'] = "Search Work Orders";
			$this->load->view('header.php', $data);
			$this->load->view('workOrderSearch_view.php', $data);
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
					$results = $this->dbm->getWorkOrdersByNameSearch($names[0], $names[1]);
				}
				else {
					$field2 = "cust_lname";
					$results = $this->dbm->getWorkOrdersBySearch($searchQuery, $searchType, $field2, false);
				}
				
			}
			
			else {
				$results = $this->dbm->getWorkOrdersBySearch($searchQuery, $searchType, false, false);
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
									<th>Date</th>
									<th>Customer</th>
									<th>Company</th>
									<th>City</th>
									<th>Address</th>
								</tr>
							</thead>
							<tbody>";
						
			foreach($results->result_array() as $row) {
				
				$tableData .= "<tr onclick='openWorkOrder(".$row['wo_id'].")'>";
				$tableData .= '<td>'.$row["wo_date"].'</td>';
				$tableData .= '<td>'.$row["cust_fname"]. ' ' .$row["cust_lname"].'</td>';
				$tableData .= '<td>'.$row["cust_company"].'</td>';
				$tableData .= '<td>'.$row["wo_city"].'</td>';
				$tableData .= '<td>'.$row["wo_address"].'</td></tr>'; //remove '</tr>' when line below is ready
			}
			
			$tableData .= "</tbody></table>";
			
			echo $tableData;
		}
	}
	
?>