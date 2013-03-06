<?php 

class Dbmodel extends CI_Model {
	
	public function __construct() {
		$this->load->database();
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
}

?>