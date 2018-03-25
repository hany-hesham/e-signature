<?php

	class form_log_model extends MY_Model{
		
	  	function __contruct(){
			parent::__construct;
	  	}

	  	function new_log($data) {
			$this->db->insert('eclaim_log', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function get_log($target_id, $target) {
			$this->db->select('eclaim_log.*, users.fullname as name');
			$this->db->join('users', 'eclaim_log.user_id = users.id','left');
			$this->db->where('eclaim_log.target_id', $target_id);		
			$this->db->where('eclaim_log.target', $target);	
        	$this->db->order_by('timestamp', 'DESC');
			$query = $this->db->get('eclaim_log');
			return $query->result_array();
		}

	}

?>