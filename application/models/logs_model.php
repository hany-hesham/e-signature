<?php

class Logs_model extends MY_Model{
	
  	function __contruct(){
		parent::__construct;
		// $this->load->helper('url');
  	}
	
  	function getall(){
	    $this->load->database();
		
		$query = $this->db->get('log');
		return $query->result_array();
  	}

  	function create($data) {
		$this->db->insert('log', $data);

		return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;

	}
}
?>