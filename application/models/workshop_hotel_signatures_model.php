<?php

class Workshop_hotel_signatures_model extends MY_Model{
	
  	function __contruct(){
		parent::__construct;
		// $this->load->helper('url');
  	}
	
  	function getall(){
	    $this->load->database();
		
		$query = $this->db->get('workshop_hotel_signatures');
		return $query->result_array();
  	}

  	function getby_hotel($hotel_id){
	    $this->load->database();
				
		$this->db->where('hotel_id', $hotel_id);
		$this->db->order_by('rank');
		$query = $this->db->get('workshop_hotel_signatures');

		return $query->result_array();
  	}

  	function add_hotel_signature($hotel_id, $role_id, $rank){
	    $this->load->database();
		$query = $this->db->query('INSERT INTO workshop_hotel_signatures(hotel_id, role_id, rank) VALUES("'.$hotel_id.'", "'.$role_id.'", "'.$rank.'")');

		return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
  	}

  	function reset_hotel($hotel_id){
	    $this->load->database();
		$query = $this->db->query('DELETE FROM workshop_hotel_signatures WHERE hotel_id = "'.$hotel_id.'"');

		return TRUE;
  	}

}
?>
