<?php 

class Dbmodel extends CI_Model {
	
	public function __construct() {
		$this->load->database();
	}
	
	
	function getAllCustomers() {
		$query = $this->db->get("customers");
		return $query;
	}
	
	//This function will be used for grabbing customer information and
	//work order information for the WorkOrderSearch page
	//***Must be completed once database allows a join between the two tables
	//function getAllCustomersandWorkOrders(){
	//	$query = $this->db->query()
	//}
	
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
}

?>