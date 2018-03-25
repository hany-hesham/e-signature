<?php

class Madar_comments_model extends MY_Model{
	
  	function __contruct(){
		parent::__construct;
		// $this->load->helper('url');
  	}
	
  	function getall(){
	    $this->load->database();
		
		$query = $this->db->get('madar_comments');
		return $query->result_array();
  	}

  	function getby_project($project_id, $privilege = 0){
		$query = $this->db->query("
									SELECT users.fullname, madar_comments.comment FROM madar_comments
									JOIN users on madar_comments.user_id = users.id
									WHERE madar_comments.project_id =".$project_id." AND privilege = ".$privilege);

		return $query->result_array();
  	}

  	function add($data) {
		$this->db->insert('madar_comments', $data);

		return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;

	}
}
?>