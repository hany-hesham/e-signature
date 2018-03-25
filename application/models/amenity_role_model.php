<?php
class amenity_role_model extends CI_Model{

  	function __contruct(){
		parent::__construct;
		// $this->load->helper('url');
  	}

  	function getall(){
	    $this->load->database();
		$query = $this->db->get('amenity_role');
		return $query->result_array();
  	}

	function getby_amen($type){
		$this->load->database();
		$this->db->where('amen_type', $type);
		$query = $this->db->get('amenity_role');
		return $query->result_array();
	}

	function reset_amen($type){
		$this->load->database();
		$query = $this->db->query('DELETE FROM amenity_role WHERE amen_type = "'.$type.'"');
		return TRUE;
	}

	function add_role_amen($type, $role, $department){
		$this->load->database();
		$query = $this->db->query('INSERT INTO amenity_role(amen_type, role, department) VALUES("'.$type.'", "'.$role.'", "'.$department.'")');
		return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
	}

}
?>
