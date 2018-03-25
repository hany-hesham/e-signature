<?php
	class position_role_model extends CI_Model{

	  	function __contruct(){
			parent::__construct;
	  	}

	  	function getall(){
		    $this->load->database();
			$query = $this->db->get('position_role');
			return $query->result_array();
	  	}

		function getby_position($type){
			$this->load->database();
			$this->db->where('pos_type', $type);
			$query = $this->db->get('position_role');
			return $query->result_array();
		}

		function reset_position($type){
			$this->load->database();
			$query = $this->db->query('DELETE FROM position_role WHERE pos_type = "'.$type.'"');
			return TRUE;
		}

		function add_role_position($type, $role, $rank){
			$this->load->database();
		$query = $this->db->query('INSERT INTO position_role(pos_type, role, rank) VALUES("'.$type.'", "'.$role.'", "'.$rank.'")');
			return $this->db->insert_id();
		}

		function add_department_position($type, $department, $id) {
			$this->db->update('position_role', array('department'=> $department), "id = ".$id);
		}

		function getall_replay(){
		    $this->load->database();
			$query = $this->db->get('position_replay_role');
			return $query->result_array();
	  	}

		function getby_position_replay($type){
			$this->load->database();
			$this->db->where('rep_type', $type);
			$query = $this->db->get('position_replay_role');
			return $query->result_array();
		}

		function reset_position_replay($type){
			$this->load->database();
			$query = $this->db->query('DELETE FROM position_replay_role WHERE rep_type = "'.$type.'"');
			return TRUE;
		}

		function add_role_position_replay($type, $role, $rank){
			$this->load->database();
		$query = $this->db->query('INSERT INTO position_replay_role(rep_type, role, rank) VALUES("'.$type.'", "'.$role.'", "'.$rank.'")');
			return $this->db->insert_id();
		}

		function add_department_position_replay($type, $department, $id) {
			$this->db->update('position_replay_role', array('department'=> $department), "id = ".$id);
		}

	}
?>
