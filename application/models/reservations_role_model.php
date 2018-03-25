<?php
class reservations_role_model extends CI_Model{

  	function __contruct(){
		parent::__construct;
		// $this->load->helper('url');
  	}

  	function getall(){
	    $this->load->database();
		$query = $this->db->get('reservations_role');
		return $query->result_array();
  	}

	function getby_res($type){
		$this->load->database();
		$this->db->where('res_type', $type);
		$this->db->order_by('rank');
		$query = $this->db->get('reservations_role');
		return $query->result_array();
	}

	function reset_res($type){
		$this->load->database();
		$query = $this->db->query('DELETE FROM reservations_role WHERE res_type = "'.$type.'"');
		return TRUE;
	}

	function add_role_res($type, $role, $rank){
		$this->load->database();
		$query = $this->db->query('INSERT INTO reservations_role(res_type, role, rank) VALUES("'.$type.'", "'.$role.'", "'.$rank.'")');
		return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
	}

}
?>
