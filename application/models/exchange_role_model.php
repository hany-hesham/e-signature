<?php
class exchange_role_model extends CI_Model{

  	function __contruct(){
		parent::__construct;
		// $this->load->helper('url');
  	}

  	function getall(){
	    $this->load->database();
		$query = $this->db->get('exchange_role');
		return $query->result_array();
  	}

	function getby_ex($type){
		$this->load->database();
		$this->db->where('type', $type);
		$query = $this->db->get('exchange_role');
		return $query->result_array();
	}

	function reset_ex($type){
		$this->load->database();
		$query = $this->db->query('DELETE FROM exchange_role WHERE type = "'.$type.'"');
		return TRUE;
	}

	function add_role_ex($type, $role){
		$this->load->database();
		$query = $this->db->query('INSERT INTO exchange_role(type, role) VALUES("'.$type.'", "'.$role.'")');
		return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
	}

}
?>
