<?php
class sp_role_model extends CI_Model{

  	function __contruct(){
		parent::__construct;
		// $this->load->helper('url');
  	}

  	function getall(){
	    $this->load->database();
		$query = $this->db->get('sp_role');
		return $query->result_array();
  	}

	function getby_sp($type){
		$this->load->database();
		$this->db->where('sp_type', $type);
		$query = $this->db->get('sp_role');
		return $query->result_array();
	}

	function reset_sp($type){
		$this->load->database();
		$query = $this->db->query('DELETE FROM sp_role WHERE sp_type = "'.$type.'"');
		return TRUE;
	}

	function add_role_sp($type, $role, $rank){
		$this->load->database();
		$query = $this->db->query('INSERT INTO sp_role(sp_type, role, rank) VALUES("'.$type.'", "'.$role.'", "'.$rank.'")');
		return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
	}

}
?>
