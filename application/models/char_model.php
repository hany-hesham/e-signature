<?php

	class char_model extends CI_Model{
	
  		function __contruct(){
			parent::__construct;
		}

		function create_char($data) {
			$this->load->database();
			$this->db->insert('char', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function update_files($assumed_id, $char_id) {
  			$this->load->database();
  			$this->db->query('UPDATE char_filles SET char_id = "'.$char_id.'" WHERE char_id = "'.$assumed_id.'"');
  		}

  		function getby_fille($char_id){
	    	$this->load->database();
			$this->db->where('char_id', $char_id);
			$query = $this->db->get('char_filles');
			return $query->result_array();
  		}

  		function add($char_id, $name) {
	  		$this->load->database();
	  		$this->db->query('INSERT INTO char_filles(char_id,name) VALUES("'.$char_id.'","'.$name.'")');
	  	}

	  	function remove($id) {
	      $this->load->database();
	      $this->db->query('DELETE FROM char_filles WHERE id = '.$id);
	    }

  		function get_char($char_id) {
			$this->db->select('char.*, users.fullname as name');
			$this->db->join('users', 'char.user_id = users.id','left');
			$this->db->where('char.id', $char_id);		
			$query = $this->db->get('char');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
		}

  		function get_comment($char_id){
			$query = $this->db->query("
				SELECT users.fullname, char_comments.comment, char_comments.created	FROM char_comments
				JOIN users on char_comments.user_id = users.id
				WHERE char_comments.char_id =".$char_id);
			return $query->result_array();
  		}

  		function update_char($data, $char_id) {
			$this->load->database();
			$this->db->where('char.id', $char_id);		
			$this->db->update('char', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function insert_comment($data){
			$this->db->insert('char_comments', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function view() {
  	  		$this->load->database();
			$this->db->select('char.*');
        	$this->db->order_by('timestamp', 'DESC');
			$query = $this->db->get('char');
			return $query->result_array();
		}

		function get_char_month($date) {
  	  		$this->load->database();
			$this->db->select('char.*');
			$this->db->where('char.date', $date);		
        	$this->db->order_by('timestamp', 'DESC');
			$query = $this->db->get('char');
			return $query->result_array();
		}

		function getby_verbal(){
	    	$this->load->database();
			$this->db->select('char_notify.*');
			$this->db->order_by('rank');
			$query = $this->db->get('char_notify');
			return $query->result_array();
  		}

	}
?>