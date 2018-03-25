<?php
	class gate_role_model extends CI_Model{

	  	function __contruct(){
			parent::__construct;
	  	}

	  	function getall(){
		    $this->load->database();
			$query = $this->db->get('gate_role');
			return $query->result_array();
	  	}

		function getby_gate($type){
			$this->load->database();
			$this->db->where('gate_type', $type);
			$query = $this->db->get('gate_role');
			return $query->result_array();
		}

		function reset_gate($type){
			$this->load->database();
			$query = $this->db->query('DELETE FROM gate_role WHERE gate_type = "'.$type.'"');
			return TRUE;
		}

		function add_role_gate($type, $role, $rank){
			$this->load->database();
		$query = $this->db->query('INSERT INTO gate_role(gate_type, role, rank) VALUES("'.$type.'", "'.$role.'", "'.$rank.'")');
			return $this->db->insert_id();
		}

		function add_department_gate($type, $department, $id) {
			$this->db->update('gate_role', array('department'=> $department), "id = ".$id);
		}

	}
?>
