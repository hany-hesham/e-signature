<?php
	class contract_role_model extends CI_Model{

	  	function __contruct(){
			parent::__construct;
	  	}

	  	function getall(){
		    $this->load->database();
			$query = $this->db->get('contract_role');
			return $query->result_array();
	  	}

		function getby_contr($type){
			$this->load->database();
			$this->db->where('type', $type);
			$query = $this->db->get('contract_role');
			return $query->result_array();
		}

		function reset_contr($type){
			$this->load->database();
			$query = $this->db->query('DELETE FROM contract_role WHERE type = "'.$type.'"');
			return TRUE;
		}

		function add_role_contr($type, $role, $department){
			$this->load->database();
			$query = $this->db->query('INSERT INTO contract_role(type, role, department) VALUES("'.$type.'", "'.$role.'", "'.$department.'")');
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function getall_summary(){
		    $this->load->database();
			$query = $this->db->get('contract_summary_role');
			return $query->result_array();
	  	}

		function getby_contr_summary($type){
			$this->load->database();
			$this->db->where('type', $type);
			$query = $this->db->get('contract_summary_role');
			return $query->result_array();
		}

		function reset_contr_summary($type){
			$this->load->database();
			$query = $this->db->query('DELETE FROM contract_summary_role WHERE type = "'.$type.'"');
			return TRUE;
		}

		function add_role_contr_summary($type, $role, $department){
			$this->load->database();
			$query = $this->db->query('INSERT INTO contract_summary_role(type, role, department) VALUES("'.$type.'", "'.$role.'", "'.$department.'")');
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

	}
?>
