<?php
	class change_role_model extends CI_Model{

	  	function __contruct(){
			parent::__construct;
			// $this->load->helper('url');
	  	}

	  	function getall(){
		    $this->load->database();
			$query = $this->db->get('change_role');
			return $query->result_array();
	  	}

		function getby_ch($type){
			$this->load->database();
			$this->db->where('ch_type', $type);
			$this->db->order_by('rank');
			$query = $this->db->get('change_role');
			return $query->result_array();
		}

		function reset_ch($type){
			$this->load->database();
			$query = $this->db->query('DELETE FROM change_role WHERE ch_type = "'.$type.'"');
			return TRUE;
		}

		function add_role_ch($type, $role, $rank){
			$this->load->database();
			$query = $this->db->query('INSERT INTO change_role(ch_type, role, rank) VALUES("'.$type.'", "'.$role.'", "'.$rank.'")');
			return $this->db->insert_id();
		}

		function add_department_ch($type, $department, $id) {
			$this->db->update('change_role', array('department'=> $department), "id = ".$id);
		}

	}
?>
