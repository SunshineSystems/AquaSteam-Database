<?php
	class Customer extends CI_Controller {
		
		public function Customer() {
			//Call CI Controller's default constructor
			parent::__construct();
			//Loads the database model functions as "dbm"
			$this->load->model("dbmodel", "dbm", true);
		}
		
		public function index()
		{
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
			
			$data['title'] = "Customers";
			$data['tags'] = $tags;
			$data['custNum'] = $i;
			$this->load->view('header', $data);
			$this->load->view('customer_view', $data);
		}
		
		function showResults() {
			$searchQuery = $_POST['searchQ'];
			$searchType = $_POST['searchType'];
			
			//checks to see what is being searched, and adds other fields if needed.
			if($searchType == "cust_fname") {
				//Need to check if there's 2 names, if there is we need to split them up into seperate
				//strings, and search fname and lname for them respectively
				//if(stristr($searchQuery))
				$field2 = "cust_lname";
				$results = $this->dbm->getCustomersBySearch($searchQuery, $searchType, $field2, false);
				
			}
			else if($searchType == "cust_hphone") {
				$field2 = "cust_bphone";
				$field3 = "cust_cphone";
				$results = $this->dbm->getCustomersBySearch($searchQuery, $searchType, $field2, $field3);
			}
			else {
				$results = $this->dbm->getCustomersBySearch($searchQuery, $searchType, false, false);
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
		
		function getCustInfo() {
			$id = $_POST['id'];
			$echo = "";
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
		
	}
?>