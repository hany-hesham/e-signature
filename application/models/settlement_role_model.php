<?php
class settlement_role_model extends CI_Model{

  	function __contruct(){
		parent::__construct;
		// $this->load->helper('url');
  	}

  	function getall(){
	    $this->load->database();
		$query = $this->db->get('settlement_role');
		return $query->result_array();
  	}

	function getby_set($set_type){
		$this->load->database();
		$this->db->where('set_type', $set_type);
		$this->db->order_by('rank');
		$query = $this->db->get('settlement_role');
		return $query->result_array();
	}

	function reset_set($set_type){
		$this->load->database();
		$query = $this->db->query('DELETE FROM settlement_role WHERE set_type = "'.$set_type.'"');
		return TRUE;
	}

	function add_role_set($set_type, $role, $rank){
		$this->load->database();
		$query = $this->db->query('INSERT INTO settlement_role(set_type, role, rank) VALUES("'.$set_type.'", "'.$role.'", "'.$rank.'")');
		return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
	}

}
?>
