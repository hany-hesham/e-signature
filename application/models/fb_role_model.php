<?php
	class fb_role_model extends CI_Model{

	  	function __contruct(){
			parent::__construct;
			// $this->load->helper('url');
	  	}

	  	function getall(){
		    $this->load->database();
			$query = $this->db->get('fb_role');
			return $query->result_array();
	  	}

		function getby_fb($type){
			$this->load->database();
			$this->db->where('fb_type', $type);
			$query = $this->db->get('fb_role');
			return $query->result_array();
		}

		function reset_fb($type){
			$this->load->database();
			$query = $this->db->query('DELETE FROM fb_role WHERE fb_type = "'.$type.'"');
			return TRUE;
		}

		function add_role_fb($type, $role, $rank){
			$this->load->database();
			$query = $this->db->query('INSERT INTO fb_role(fb_type, role, rank) VALUES("'.$type.'", "'.$role.'", "'.$rank.'")');
			return $this->db->insert_id();
		}

		function add_department_fb($type, $department, $id) {
			$this->db->update('fb_role', array('department'=> $department), "id = ".$id);
		}

	}
?>
