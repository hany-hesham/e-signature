<?php

class Workshop_request_comments_model extends MY_Model{
	
  	function __contruct(){
		parent::__construct;
		// $this->load->helper('url');
  	}
	
  	function getall(){
	    $this->load->database();
		
		$query = $this->db->get('workshop_request_comments');
		return $query->result_array();
  	}

  	function getby_workshop_request($request_id){
		$query = $this->db->query("
									SELECT users.fullname, workshop_request_comments.comment, workshop_request_comments.delivery_date AS delivery_date FROM workshop_request_comments
									JOIN users on workshop_request_comments.user_id = users.id
									WHERE workshop_request_comments.request_id =".$request_id);

		return $query->result_array();
  	}

/*  	function getby_workshop_delivery_date_request($request_id){
		$query = $this->db->query("
									SELECT workshop_request_comments.delivery_date,workshop_request_comments.id FROM workshop_request_comments
									WHERE workshop_request_comments.request_id = $request_id ORDER BY id ASC LIMIT 0,1");
		return $query->row_array();
  	}
*/
  	function add($data) {
		$this->db->insert('workshop_request_comments', $data);

		return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;

	}
}
?>