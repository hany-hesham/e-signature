<?php

class Workshop_order_signatures_template_model extends MY_Model{
	
  	function __contruct(){
		parent::__construct;
		// $this->load->helper('url');
  	}
	
  	function getall(){
	    $this->load->database();
		
		$query = $this->db->get('workshop_order_signatures_template');
		return $query->result_array();
  	}

  	function add_signature($role_id, $rank){
	    $this->load->database();
		$query = $this->db->query('INSERT INTO workshop_order_signatures_template(role_id, rank) VALUES("'.$role_id.'", "'.$rank.'")');

		return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
  	}

  	function reset(){
	    $this->load->database();
		$query = $this->db->query('DELETE FROM workshop_order_signatures_template WHERE 1');

		return TRUE;
  	}

}
?>
