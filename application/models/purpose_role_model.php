<?php
class purpose_role_model extends CI_Model{

  	function __contruct(){
		parent::__construct;
		// $this->load->helper('url');
  	}

  	function getall(){
	    $this->load->database();
		$query = $this->db->get('purpose_role');
		return $query->result_array();
  	}

	function getby_pur($type){
		$this->load->database();
		$this->db->where('type', $type);
		$query = $this->db->get('purpose_role');
		return $query->result_array();
	}

	function reset_pur($type){
		$this->load->database();
		$query = $this->db->query('DELETE FROM purpose_role WHERE type = "'.$type.'"');
		return TRUE;
	}

	function add_role_pur($type, $role){
		$this->load->database();
		$query = $this->db->query('INSERT INTO purpose_role(type, role) VALUES("'.$type.'", "'.$role.'")');
		return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
	}

}
?>
