<?php

	class complaint_role_model extends CI_Model{

	  	function __contruct(){
			parent::__construct;
			// $this->load->helper('url');
	  	}

	  	function getall(){
		    $this->load->database();
			$query = $this->db->get('complaint_role');
			return $query->result_array();
	  	}

		function getby_com($type){
			$this->load->database();
			$this->db->where('type', $type);
			$query = $this->db->get('complaint_role');
			return $query->result_array();
		}

		function reset_com($type){
			$this->load->database();
			$query = $this->db->query('DELETE FROM complaint_role WHERE type = "'.$type.'"');
			return TRUE;
		}

		function add_role_com($type, $role, $department=FALSE){
			$this->load->database();
			$query = $this->db->query('INSERT INTO complaint_role(type, role, department) VALUES("'.$type.'", "'.$role.'", "'.$department.'")');
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

	}

?>
