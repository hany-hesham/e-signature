<?php

class Workshop_request_reciver_model extends MY_Model{
	
  	function __contruct(){
		parent::__construct;
		// $this->load->helper('url');
  	}
	
  	function getall(){
	    $this->load->database();
		
		$query = $this->db->get('workshop_request_reciver');
		return $query->result_array();
  	}

  	function getby_workshop_request($request_id){
		$query = $this->db->query("
									SELECT users.fullname, workshop_request_reciver.message, workshop_request_reciver.created FROM workshop_request_reciver
									JOIN users on workshop_request_reciver.user_id = users.id
									WHERE workshop_request_reciver.request_id =".$request_id);

		return $query->result_array();
  	}

  	function add($data) {
		$this->db->insert('workshop_request_reciver', $data);

		return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;

	}
}
?>