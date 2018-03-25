<?php
class  market_role_model extends CI_Model{

  	function __contruct(){
		parent::__construct;
		// $this->load->helper('url');
  	}

  	function getall(){
	    $this->load->database();
		$query = $this->db->get(' market_role');
		return $query->result_array();
  	}

	function getby_market($type){
		$this->load->database();
		$this->db->where('market_type', $type);
		$this->db->order_by('rank');
		$query = $this->db->get('market_role');
		return $query->result_array();
	}

	function reset_market($type){
		$this->load->database();
		$query = $this->db->query('DELETE FROM market_role WHERE market_type = "'.$type.'"');
		return TRUE;
	}

	function add_role_market($type, $role, $rank){
		$this->load->database();
		$query = $this->db->query('INSERT INTO market_role(market_type, role, rank) VALUES("'.$type.'", "'.$role.'", "'.$rank.'")');
		return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
	}

}
?>
