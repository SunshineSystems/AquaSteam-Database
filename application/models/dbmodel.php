<?php 

class Dbmodel extends CI_Model {
	
	public function __construct() {
		$this->load->database();
	}
	
	//Gets all the information from the username that attempted the login.
	function getUserOnLogin($username) {
		$query = $this->db->query("SELECT * FROM user WHERE user_username = '$username'");
		return $query;
	} 
	
	function insertNewUser($data) {
		$this->db->insert('user', $data);
	}
	
	function updateUser($id, $data) {
		$this->db->where('user_id', $id);
		$this->db->update('user', $data);
	}
	
	function deleteUser($id) {
		$this->db->where('user_id', $id);
		$this->db->delete('user');
	}
	
	function getAllUsers() {
		$query = $this->db->get("user");
		return $query;
	}
	
	function getUserById($id) {
		$query = $this->db->query("SELECT * FROM user WHERE user_id = $id");
		return $query;
	}
	
	function updateUserPassword($id, $password) {
		$this->db->where("user_id", $id);
		$this->db->set("user_password", $password);	
		$this->db->update('user');
	}
	
	function getAllCustomers() {
		$query = $this->db->get("customers");
		return $query;
	}
	
	function getCustomerById($id) {
		$query = $this->db->query("SELECT * FROM customers WHERE cust_id = $id");
		return $query;
	}
	
	//Checks to see how many fields that need to be searched
	//And searches them for the $search value
	function getCustomersBySearch($search, $field1, $field2, $field3) {
				
		if($field3) {
			$this->db->like("$field1", "$search");
			$this->db->or_like("$field2", "$search");
			$this->db->or_like("$field2", "$search");
		}
		else if($field2) {
			$this->db->like("$field1", "$search");
			$this->db->or_like("$field2", "$search");
		}	
		else {
			$this->db->like("$field1", "$search");
		}	

		$query = $this->db->get("customers");
		return $query;
	}
		
	function getCustomersByNameSearch($fname, $lname) {
		$this->db->like('cust_fname', "$fname");
		$this->db->like('cust_lname', "$lname");
		
		$query = $this->db->get("customers");
		return $query;
	}
	
	//Inserts a new customer into the 'customers' table, with the given data, then selects that customer from the
	//database and returns his id.
	function insertNewCustomer($data) {
		$this->db->insert('customers', $data);
		$query = $this->db->query("SELECT cust_id FROM customers ORDER BY cust_id DESC LIMIT 1");
		
		foreach($query->result_array() as $row) {
			$id = $row['cust_id'];
		}
		return $id;
		
	}
	
	//Updates an existing customer in the 'customers' table with the given data.
	function updateCustomer($id, $data) {
		$this->db->where('cust_id', $id);
		$this->db->update('customers', $data);
	}
	
	//Deletes the customer entry that matches the id passed to the function
	function deleteCustomer($id) {
		$this->db->where('cust_id', $id);
		$this->db->delete('customers');
	}
	
	//Changes User Password
	function changePassword($id, $data){
		$this->db->where('username', $id);
		$this->db->update('password', $data);
	}
	
	function getWorkOrderTags() {
		$query  = $this->db->query("SELECT cust_fname, cust_lname, cust_company, wo_city, wo_address, wo_date
										FROM customers, work_order WHERE work_order.cust_id = customers.cust_id");
		return $query;
	}
	
	//Checks to see how many fields that need to be searched
	//And searches them for the $search value
	function getWorkOrdersBySearch($search, $field1, $field2) {
	 	$this->db->select("*");
	 	$this->db->from('work_order');
	 	$this->db->join('customers', 'work_order.cust_id = customers.cust_id');	
	 	if($field2) {
			$this->db->like("$field1", "$search");
			$this->db->or_like("$field2", "$search");
		}	
		else {
			$this->db->like("$field1", "$search");
		}	

		$query  = $this->db->get();
		return $query;
	}
	
	function getWorkOrdersByNameSearch($fname, $lname) {
		$this->db->select("*");
	 	$this->db->from('work_order');
	 	$this->db->join('customers', 'work_order.cust_id = customers.cust_id');	
		
		$this->db->like('cust_fname', "$fname");
		$this->db->like('cust_lname', "$lname");
		
		$query = $this->db->get();
		return $query;
	}
}

?>