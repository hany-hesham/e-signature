<?php
	class policy_role_model extends CI_Model{

	  	function __contruct(){
			parent::__construct;
	  	}

	  	function getall(){
		    $this->load->database();
			$query = $this->db->get('policy_role');
			return $query->result_array();
	  	}

		function getby_policy($type){
			$this->load->database();
			$this->db->where('policy_type', $type);
			$query = $this->db->get('policy_role');
			return $query->result_array();
		}

		function reset_policy($type){
			$this->load->database();
			$query = $this->db->query('DELETE FROM policy_role WHERE policy_type = "'.$type.'"');
			return TRUE;
		}

		function add_role_policy($type, $role, $rank){
			$this->load->database();
		$query = $this->db->query('INSERT INTO policy_role(policy_type, role, rank) VALUES("'.$type.'", "'.$role.'", "'.$rank.'")');
			return $this->db->insert_id();
		}

		function add_department_policy($type, $department, $id) {
			$this->db->update('policy_role', array('department'=> $department), "id = ".$id);
		}

	}
?>
