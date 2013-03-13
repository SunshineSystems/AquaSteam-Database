<?php
	require_once(APPPATH."libraries/hasher.php");
	
	class ManageAccount extends CI_Controller {
	
		public function ManageAccount() {
			//Call CI Controller's default constructor
			parent::__construct();
			//Loads the database model functions as "dbm"
			$this->load->model("dbmodel", "dbm", true);
		}
		
		public function index()
		{
			$results = $this->dbm->getAllUsers();
			$tableData = "<table id='user-table' class='tablesorter table-striped table-hover'>
							<thead>
								<tr>
									<th>Username</th>
									<th>First Name</th>
									<th>Last Name</th>
									<th>Account Type</th>
								</tr>
							</thead>
							<tbody>";
						
			foreach($results->result_array() as $row) {
				if($row['user_admin'] == 1) {
					$type = "Admin";
				}
				else {
					$type = "Employee";
				}
				$tableData .= "<tr onclick='openUser(".$row['user_id'].")'>";
				$tableData .= '<td>'.$row["user_username"].'</td>';
				$tableData .= '<td>'.$row["user_fname"].'</td>';
				$tableData .= '<td>'.$row["user_lname"].'</td>';
				$tableData .= '<td>'.$type.'</td></tr>';
			}
			
			$tableData .= "</tbody></table>";
			
			$data['table'] = $tableData;
			$data['title'] = "Manage Accounts";
			$this->load->view('header', $data);
			$this->load->view('manageAccount_view.php', $data);
		}
		
		function getUserInfo() {
			$id = $_POST['id'];
			$output = array();
			$result = $this->dbm->getUSERById($id);
			
			foreach($result->result_array() as $row) {
				if($row['user_admin'] == 1) {
					$output['user_admin'] = "Admin";
				}
				else {
					$output['user_admin'] = "Employee";
				}
				$output['user_fname'] = $row['user_fname'];
				$output['user_lname'] = $row['user_lname'];
				$output['user_username'] = $row['user_username'];
				$output['user_address'] = $row['user_address'];
				$output['user_city'] = $row['user_city'];
				$output['user_prov'] = $row['user_prov'];
				$output['user_pcode'] = $row['user_pcode'];
				$output['user_hphone'] = $row['user_hphone'];
				$output['user_cphone'] = $row['user_cphone'];
				$output['user_notes'] = $row['user_notes'];
			}
			
			$output = json_encode($output);
			echo $output;
		}
		
		function saveAccount() {
			$data = array();
			$id = $_POST['id'];
			$userType = $_POST['type'];
			global $hasher;
			
			//Hashes password for security purposes.
			$hashedPassword = $hasher->HashPassword($_POST['password']);
			
			if($userType == "Admin") {
				$data['user_admin'] = 1;
			}
			else {
				$data['user_admin'] = 0;
			}
			
			$data['user_username'] = $_POST['username'];
			$data['user_password'] = $hashedPassword;
			$data['user_fname'] = $_POST['fname'];
			$data['user_lname'] = $_POST['lname'];
			$data['user_address'] = $_POST['address'];
			$data['user_city'] = $_POST['city'];
			$data['user_prov']= $_POST['prov'];
			$data['user_pcode'] = $_POST['pcode'];
			$data['user_hphone'] = $_POST['hphone'];
			$data['user_cphone'] = $_POST['cphone'];
			$data['user_notes'] = $_POST['notes'];
			
			if(!$id) {
				$this->dbm->insertNewUser($data);
				$echo = "<div class='alert alert-success'><h4>Success!</h4>
								The New User Has Been Created</div>";
			}
			else {
				$this->dbm->updateUser($id, $data);
				$echo = "<div class='alert alert-success'><h4>Success!</h4>
								The User Has Been Updated</div>";
			}
			echo $echo;
		}

		function deleteAccount() {
			$id = $_POST['id'];
			
			if(!$id) {
				$feedback = "<div class='alert alert-error'><h4>Hmmm...</h4>
								There was an error; no user was deleted.</div>";
			}
			else {
				$this->dbm->deleteUser($id);
				$feedback = "<div class='alert alert-success'><h4>Success!</h4>
								The User has been deleted from the database.</div>";
			}
			echo $feedback;
		}
		
	}
?>