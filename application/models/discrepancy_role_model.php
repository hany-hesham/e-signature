<?php
	class discrepancy_role_model extends CI_Model{

	  	function __contruct(){
			parent::__construct;
			// $this->load->helper('url');
	  	}

	  	function getall(){
		    $this->load->database();
			$query = $this->db->get('discrepancy_role');
			return $query->result_array();
	  	}

		function getby_dcy($type){
			$this->load->database();
			$this->db->where('type', $type);
			$query = $this->db->get('discrepancy_role');
			return $query->result_array();
		}

		function reset_dcy($type){
			$this->load->database();
			$query = $this->db->query('DELETE FROM discrepancy_role WHERE type = "'.$type.'"');
			return TRUE;
		}

		function add_role_dcy($type, $role, $rank){
			$this->load->database();
			$query = $this->db->query('INSERT INTO discrepancy_role(type, role, rank) VALUES("'.$type.'", "'.$role.'", "'.$rank.'")');
			return $this->db->insert_id();
		}

		function add_department_dcy($type, $department, $id) {
			$this->db->update('discrepancy_role', array('department'=> $department), "id = ".$id);
		}

	}
?>
