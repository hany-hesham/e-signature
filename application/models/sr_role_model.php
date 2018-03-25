<?php
	class sr_role_model extends CI_Model{

	  	function __contruct(){
			parent::__construct;
			// $this->load->helper('url');
	  	}

	  	function getall(){
		    $this->load->database();
			$query = $this->db->get('sr_role');
			return $query->result_array();
	  	}

		function getby_sr($type){
			$this->load->database();
			$this->db->where('type', $type);
			$query = $this->db->get('sr_role');
			return $query->result_array();
		}

		function reset_sr($type){
			$this->load->database();
			$query = $this->db->query('DELETE FROM sr_role WHERE type = "'.$type.'"');
			return TRUE;
		}

		function add_role_sr($type, $role, $rank){
			$this->load->database();
			$query = $this->db->query('INSERT INTO sr_role(type, role, rank) VALUES("'.$type.'", "'.$role.'", "'.$rank.'")');
			return $this->db->insert_id();
		}

		function add_department_sr($type, $department, $id) {
			$this->db->update('sr_role', array('department'=> $department), "id = ".$id);
		}

	}
?>
