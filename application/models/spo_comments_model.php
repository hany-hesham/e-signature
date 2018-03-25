<?php

class Spo_comments_model extends MY_Model{
	
  	function __contruct(){
		parent::__construct;
		// $this->load->helper('url');
  	}
	
  	function getall(){
	    $this->load->database();
		
		$query = $this->db->get('spo_comments');
		return $query->result_array();
  	}

  	function getby_spo($spo_id){
		$query = $this->db->query("
									SELECT users.fullname, spo_comments.comment FROM spo_comments
									JOIN users on spo_comments.user_id = users.id
									WHERE spo_comments.request_id =".$spo_id);

		return $query->result_array();
  	}

  	function add($data) {
		$this->db->insert('spo_comments', $data);

		return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;

	}
}
?>