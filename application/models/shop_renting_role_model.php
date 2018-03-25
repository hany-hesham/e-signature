<?php

	class shop_renting_role_model extends CI_Model{

	  	function __contruct(){
			parent::__construct;
			// $this->load->helper('url');
	  	}

	  	function getall(){
		    $this->load->database();
			$query = $this->db->get('shop_renting_role');
			return $query->result_array();
	  	}

	  	function getall_final(){
		    $this->load->database();
			$query = $this->db->get('shop_renting_final_role');
			return $query->result_array();
	  	}

		function getby_shop($type){
			$this->load->database();
			$this->db->where('type', $type);
			$query = $this->db->get('shop_renting_role');
			return $query->result_array();
		}

		function getby_final_shop($type){
			$this->load->database();
			$this->db->where('type', $type);
			$query = $this->db->get('shop_renting_final_role');
			return $query->result_array();
		}

		function reset_shop($type){
			$this->load->database();
			$query = $this->db->query('DELETE FROM shop_renting_role WHERE type = "'.$type.'"');
			return TRUE;
		}

		function reset_final_shop($type){
			$this->load->database();
			$query = $this->db->query('DELETE FROM shop_renting_final_role WHERE type = "'.$type.'"');
			return TRUE;
		}

		function add_role_shop($type, $role, $rank){
			$this->load->database();
			$query = $this->db->query('INSERT INTO shop_renting_role(type, role, rank) VALUES("'.$type.'", "'.$role.'", "'.$rank.'")');
			return $this->db->insert_id();
		}

		function add_role_final_shop($type, $role, $rank){
			$this->load->database();
			$query = $this->db->query('INSERT INTO shop_renting_final_role(type, role, rank) VALUES("'.$type.'", "'.$role.'", "'.$rank.'")');
			return $this->db->insert_id();
		}

	}

?>
