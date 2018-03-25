<?php
	class credit_role_model extends CI_Model{

	  	function __contruct(){
			parent::__construct;
	  	}

	  	function getall(){
		    $this->load->database();
			$query = $this->db->get('credit_role');
			return $query->result_array();
	  	}

		function getby_credit($type){
			$this->load->database();
			$this->db->where('type', $type);
			$query = $this->db->get('credit_role');
			return $query->result_array();
		}

		function reset_credit($type){
			$this->load->database();
			$query = $this->db->query('DELETE FROM credit_role WHERE type = "'.$type.'"');
			return TRUE;
		}

		function add_role_credit($type, $role, $rank){
			$this->load->database();
		$query = $this->db->query('INSERT INTO credit_role(type, role, rank) VALUES("'.$type.'", "'.$role.'", "'.$rank.'")');
			return $this->db->insert_id();
		}

		function add_department_credit($type, $department, $id) {
			$this->db->update('credit_role', array('department'=> $department), "id = ".$id);
		}

	}
?>
