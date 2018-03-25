<?php

	class contract_log_model extends MY_Model{
		
	  	function __contruct(){
			parent::__construct;
	  	}

	  	function new_log($data) {
			$this->db->insert('contract_log', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function get_log($target_id) {
			$this->db->select('contract_log.*, users.fullname as name');
			$this->db->join('users', 'contract_log.user_id = users.id','left');
			$this->db->where('contract_log.target_id', $target_id);		
			$this->db->where('contract_log.type !=', "Email");		
			$this->db->where('contract_log.type !=', "Comment");		
        	$this->db->order_by('timestamp', 'DESC');
			$query = $this->db->get('contract_log');
			return $query->result_array();
		}

		function update_log($assumed_id, $contr_id) {
  			$this->load->database();
  			$this->db->query('UPDATE contract_log SET target_id = "'.$contr_id.'" WHERE target_id = "'.$assumed_id.'"');
  		}

	}

?>