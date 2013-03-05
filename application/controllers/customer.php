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
			
			//testing purposes
			$searchType = "cust_fname";
			
			$tableData = "<table id='result-table' class='tablesorter table-striped table-hover'>
							<thead>
								<tr>
									<th>First Name</th>
									<th>Last Name</th>
									<th>Company</th>
									<th>Address</th>
									<th>City</th>
								</tr>
							</thead>
							<tbody>";
							
			$results = $this->dbm->getCustomersBySearch($searchQuery, $searchType);
			foreach($results->result_array() as $row) {
				$tableData .= "<a><tr onclick='openCustomer(".$row['cust_id'].")'>";
				$tableData .= '<td>'.$row["cust_fname"].'</td>';
				$tableData .= '<td>'.$row["cust_lname"].'</td>';
				$tableData .= '<td>'.$row["cust_company"].'</td>';
				$tableData .= '<td>'.$row["cust_address"].'</td>';
				$tableData .= '<td>'.$row["cust_city"].'</td></tr></a>';
			}
			
			$tableData .= "</tbody></table>";
			
			echo $tableData;
		}
		
	}
?>