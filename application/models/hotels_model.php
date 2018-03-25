<?php

class Hotels_model extends MY_Model{
	
  	function __contruct(){
		parent::__construct;
		// $this->load->helper('url');
  	}
	
  	function getall(){
	    $this->load->database();
		
		$query = $this->db->get('hotels');
		return $query->result_array();
  	}

  	function get_by_id($id){
	    $this->load->database();
		
		$this->db->where('id', $id);
		$query = $this->db->get('hotels');
		return $query->row_array();
  	}

  	function get_code($id){
	    $this->load->database();
		$this->db->select("code");
		$this->db->where("id", $id);
		$query = $this->db->get('hotels');
		return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  	}

  	function getby_user($uid){
	    $this->load->database();
		
		$query = $this->db->query('SELECT hotels.id, hotels.name, hotels.company_id FROM hotels JOIN employees_hotels ON hotels.id = employees_hotels.hotel_id WHERE employee_id ="'.$uid.'"');

		return $query->result_array();
  	}
}
?>
