<?php
	class out_go_role_model extends CI_Model{

	  	function __contruct(){
			parent::__construct;
	  	}

	  	function getall(){
		    $this->load->database();
			$query = $this->db->get('out_go_role');
			return $query->result_array();
	  	}

		function getby_out_go($type){
			$this->load->database();
			$this->db->where('out_type', $type);
			$query = $this->db->get('out_go_role');
			return $query->result_array();
		}

		function reset_out_go($type){
			$this->load->database();
			$query = $this->db->query('DELETE FROM out_go_role WHERE out_type = "'.$type.'"');
			return TRUE;
		}

		function add_role_out_go($type, $role, $rank){
			$this->load->database();
		$query = $this->db->query('INSERT INTO out_go_role(out_type, role, rank) VALUES("'.$type.'", "'.$role.'", "'.$rank.'")');
			return $this->db->insert_id();
		}

		function add_department_out_go($type, $department, $id) {
			$this->db->update('out_go_role', array('department'=> $department), "id = ".$id);
		}

		function getall_out_del(){
		    $this->load->database();
			$query = $this->db->get('out_del_go_role');
			return $query->result_array();
	  	}

		function getby_out_del($type){
			$this->load->database();
			$this->db->where('out_type', $type);
			$query = $this->db->get('out_del_go_role');
			return $query->result_array();
		}

		function reset_out_del($type){
			$this->load->database();
			$query = $this->db->query('DELETE FROM out_del_go_role WHERE out_type = "'.$type.'"');
			return TRUE;
		}

		function add_role_out_del($type, $role, $rank){
			$this->load->database();
		$query = $this->db->query('INSERT INTO out_del_go_role(out_type, role, rank) VALUES("'.$type.'", "'.$role.'", "'.$rank.'")');
			return $this->db->insert_id();
		}

		function add_department_out_del($type, $department, $id) {
			$this->db->update('out_del_go_role', array('department'=> $department), "id = ".$id);
		}

	}
?>
