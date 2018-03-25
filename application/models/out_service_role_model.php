<?php
	class out_service_role_model extends CI_Model{

	  	function __contruct(){
			parent::__construct;
	  	}

	  	function getall(){
		    $this->load->database();
			$query = $this->db->get('out_service_role');
			return $query->result_array();
	  	}

		function getby_out_service($type){
			$this->load->database();
			$this->db->where('type', $type);
			$query = $this->db->get('out_service_role');
			return $query->result_array();
		}

		function reset_out_service($type){
			$this->load->database();
			$query = $this->db->query('DELETE FROM out_service_role WHERE type = "'.$type.'"');
			return TRUE;
		}

		function add_role_out_service($type, $role, $rank){
			$this->load->database();
		$query = $this->db->query('INSERT INTO out_service_role(type, role, rank) VALUES("'.$type.'", "'.$role.'", "'.$rank.'")');
			return $this->db->insert_id();
		}

		function add_department_out_service($type, $department, $id) {
			$this->db->update('out_service_role', array('department'=> $department), "id = ".$id);
		}

	}
?>
