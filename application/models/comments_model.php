<?php

class Comments_model extends MY_Model{
	
  	function __contruct(){
		parent::__construct;
		// $this->load->helper('url');
  	}
	
  	function getall(){
	    $this->load->database();
		
		$query = $this->db->get('comments');
		return $query->result_array();
  	}

  	function get_form_comments($form_id){
		$query = $this->db->query("
									SELECT users.fullname, comments.comment FROM comments
									JOIN users on comments.user_id = users.id
									WHERE comments.form_id =".$form_id);

		return $query->result_array();
  	}

  	function create($data) {
		$this->db->insert('comments', $data);

		return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;

	}
}
?>