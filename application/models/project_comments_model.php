<?php

	class Project_comments_model extends MY_Model{
	
	  	function __contruct(){
			parent::__construct;
	  	}

	  	function getby_project($project_id){
			$query = $this->db->query("
				SELECT users.fullname, project_comments.comment, project_comments.created FROM project_comments
				JOIN users on project_comments.user_id = users.id
				WHERE project_comments.project_id =".$project_id);
			return $query->result_array();
	  	}

	  	function add($data) {
			$this->db->insert('project_comments', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}
	
	  	function getall(){
		    $this->load->database();
			$query = $this->db->get('project_comments');
			return $query->result_array();
	  	}

	}

?>