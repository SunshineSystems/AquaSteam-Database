<?php 

class Dbmodel extends CI_Model {
	
	public function __construct() {
		$this->load->database();
	}
	
	
	function getAllCustomers() {
		$query = $this->db->get("customers");
		return $query;
	}
	
	function getCustomersBySearch($search, $field) {
		$query = $this->db->query("SELECT * FROM customers WHERE '$field' LIKE '%$search%'");
		
		return $query;
	}
}

?>