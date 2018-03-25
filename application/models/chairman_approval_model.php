<?php

	class chairman_approval_model extends CI_Model{

  		function __contruct(){
			parent::__construct;
		}

		function chairman_approval($database, $state, $hotels = FALSE) {
  	  		$this->load->database();
			$this->db->select($database.'.*');
			if ($hotels) {
				$this->db->where_in($database.'.hotel_id', $hotels);
			}
			$this->db->where($database.'.chairman', $state);	
			$this->db->where($database.'.chairman !=', 0);	
			$query = $this->db->get($database);
			return $query->result_array();
		}

		function get_states() {
  	  		$this->load->database();
			$this->db->select('e-signature.*');
			$query = $this->db->get('e-signature');
			return $query->result_array();
		}

		function get_state($id) {
  	  		$this->load->database();
			$this->db->select('e-signature.*');
			$this->db->where_in('e-signature.id', $id);
			$query = $this->db->get('e-signature');
			return $query->result_array();
		}

	}

?>