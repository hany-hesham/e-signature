<?php

class Company_signatures_model extends MY_Model{
	
  	function __contruct(){
		parent::__construct;
		// $this->load->helper('url');
  	}
	
  	function getall(){
	    $this->load->database();
		
		$query = $this->db->get('company_signatures');
		return $query->result_array();
  	}

  	function getby_company($company_id){
	    $this->load->database();
				
		$this->db->where('company_id', $company_id);
		$this->db->order_by('rank');
		$query = $this->db->get('company_signatures');

		return $query->result_array();
  	}

  	function getby_company_owning($hotel_id){
	    $this->load->database();
				
		$this->db->where('hotel_id', $hotel_id);
		$this->db->order_by('rank');
		$query = $this->db->get('company_owning_signatures');

		return $query->result_array();
  	}

  	function add_company_signature($company_id, $role_id, $rank){
	    $this->load->database();
		$query = $this->db->query('INSERT INTO company_signatures(company_id, role_id, rank) VALUES("'.$company_id.'", "'.$role_id.'", "'.$rank.'")');

		return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
  	}

  	function reset_company($company_id){
	    $this->load->database();
		$query = $this->db->query('DELETE FROM company_signatures WHERE company_id = "'.$company_id.'"');

		return TRUE;
  	}

}
?>
