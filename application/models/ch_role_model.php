<?php
	class ch_role_model extends CI_Model{

	  	function __contruct(){
			parent::__construct;
			// $this->load->helper('url');
	  	}

	  	function getall(){
		    $this->load->database();
			$query = $this->db->get('ch_role');
			return $query->result_array();
	  	}

		function getby_ch($type){
			$this->load->database();
			$this->db->where('type', $type);
			$query = $this->db->get('ch_role');
			return $query->result_array();
		}

		function reset_ch($type){
			$this->load->database();
			$query = $this->db->query('DELETE FROM ch_role WHERE type = "'.$type.'"');
			return TRUE;
		}

		function add_role_ch($type, $role, $rank){
			$this->load->database();
			$query = $this->db->query('INSERT INTO ch_role(type, role, rank) VALUES("'.$type.'", "'.$role.'", "'.$rank.'")');
			return $this->db->insert_id();
		}

		function add_department_ch($type, $department, $id) {
			$this->db->update('ch_role', array('department'=> $department), "id = ".$id);
		}

	}
?>
