<?php
class roles_model_spo extends CI_Model{

  	function __contruct(){
		parent::__construct;
		// $this->load->helper('url');
  	}

  	function getall(){
	    $this->load->database();
		$query = $this->db->get('role_spo');
		return $query->result_array();
  	}

	function getby_spo($spo_type){
		$this->load->database();
		$this->db->where('spo_type', $spo_type);
		$this->db->order_by('rank');
		$query = $this->db->get('role_spo');
		return $query->result_array();
	}

	function reset_spo($spo_type){
		$this->load->database();
		$query = $this->db->query('DELETE FROM  role_spo WHERE spo_type = "'.$spo_type.'"');
		return TRUE;
	}

	function add_role_spo($spo_type, $role, $rank){
		$this->load->database();
		$query = $this->db->query('INSERT INTO role_spo(spo_type, role, rank) VALUES("'.$spo_type.'", "'.$role.'", "'.$rank.'")');
		return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
	}

}
?>
