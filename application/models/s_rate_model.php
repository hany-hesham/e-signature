<?php

	class s_rate_model extends CI_Model{
	
  		function __contruct(){
			parent::__construct;
		}

		function update_files($assumed_id, $sr_id) {
  			$this->load->database();
  			$this->db->query('UPDATE sr_filles SET sr_id = "'.$sr_id.'" WHERE sr_id = "'.$assumed_id.'"');
  		}

  		function getby_fille($sr_id){
	    	$this->load->database();
			$this->db->where('sr_id', $sr_id);
			$query = $this->db->get('sr_filles');
			return $query->result_array();
  		}

  		function add($sr_id, $name) {
	  		$this->load->database();
	  		$this->db->query('INSERT INTO sr_filles(sr_id,name) VALUES("'.$sr_id.'","'.$name.'")');
	  	}

	  	function remove($id) {
	      $this->load->database();
	      $this->db->query('DELETE FROM sr_filles WHERE id = '.$id);
	    }

		function create_sr($data) {
			$this->load->database();
			$this->db->insert('s_rate', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function create_room($data) {
			$this->db->insert('sr_room', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function sr_sign ($type){
  			$this->load->database();
			$this->db->select('sr_role.*');
			$this->db->where('type', $type);		
			$query = $this->db->get('sr_role');
			return $query->result_array();  	
		}

		function sr_do_sign($sr_id){
  	 		$this->load->database();
			$this->db->select('sr_signature.*');
			$this->db->where('sr_signature.sr_id', $sr_id);		
			$query = $this->db->get('sr_signature');
			return $query->num_rows();  	
		}

		function add_signature($sr_id, $role_id, $department_id, $rank){
	    	$this->load->database();
			$query = $this->db->query('INSERT INTO sr_signature(sr_id, role_id, department_id, rank) VALUES("'.$sr_id.'", "'.$role_id.'", "'.$department_id.'", "'.$rank.'")');
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
  		}

  		function get_sr($sr_id) {
			$this->db->select('s_rate.*, hotels.name as hotel_name, hotels.logo As logo, users.fullname as name');
			$this->db->join('hotels', 's_rate.hotel_id = hotels.id','left');
			$this->db->join('users', 's_rate.user_id = users.id','left');
			$this->db->where('s_rate.id', $sr_id);		
			$query = $this->db->get('s_rate');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
		}

		function get_sr_room($sr_id) {
        	$this->load->database();
			$this->db->where('sr_room.sr_id', $sr_id);
			$query = $this->db->get('sr_room');
			return ($query->num_rows() > 0 )? $query->result_array() : FALSE;
		}

		function get_comment($sr_id){
			$query = $this->db->query("
				SELECT users.fullname, sr_comments.comment, sr_comments.created FROM sr_comments
				JOIN users on sr_comments.user_id = users.id
				WHERE sr_comments.sr_id =".$sr_id);
			return $query->result_array();
  		}

  		function update_sr($data, $sr_id) {
			$this->load->database();
			$this->db->where('s_rate.id', $sr_id);		
			$this->db->update('s_rate', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function update_room($data, $sr_id, $item_id) {
			$this->load->database();
			$this->db->where('sr_room.sr_id', $sr_id);	
			$this->db->where('sr_room.id', $item_id);		
			$this->db->update('sr_room', $data);
			$query = $this->db->get('sr_room');
			return $query;
		}

		function insert_comment($data){
			$this->db->insert('sr_comments', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function view($user_hotels = FALSE) {
  	  		$this->load->database();
			$this->db->select('users.id as userid,users.*,s_rate.*, hotels.name as hotel_name');
			$this->db->join('users', 's_rate.user_id = users.id','left');
			$this->db->join('hotels', 's_rate.hotel_id = hotels.id','left');
        	if ($user_hotels) {
          		$this->db->where_in('s_rate.hotel_id', $user_hotels);
        	}
        	$this->db->order_by('timestamp', 'DESC');
			$query = $this->db->get('s_rate');
			return $query->result_array();
		}

		function getby_verbal($sr_id){
	    	$this->load->database();
			$this->db->select('sr_signature.*, roles.role, departments.name as department');
			$this->db->join('roles', 'sr_signature.role_id = roles.id', 'left');
			$this->db->join('departments', 'sr_signature.department_id = departments.id', 'left');
			$this->db->where('sr_id', $sr_id);
			$this->db->order_by('rank');
			$query = $this->db->get('sr_signature');
			return $query->result_array();
  		}

  		function update_state($sr_id, $state) {
			$this->db->update('s_rate', array('state_id'=> $state), "id = ".$sr_id);
		}

		function get_signature_identity($sign_id){
  			$this->load->database();
			$query = $this->db->query('SELECT s_rate.hotel_id, sr_signature.sr_id FROM sr_signature JOIN s_rate ON sr_signature.sr_id = s_rate.id WHERE sr_signature.id ='.$sign_id);
  			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  		}

  		function reject($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE sr_signature SET user_id = '.$uid.', reject = 1 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function sign($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE sr_signature SET user_id = '.$uid.' WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function unsign($id){
	  		$this->load->database();
			$query = $this->db->query('UPDATE sr_signature SET user_id = NULL, reject = 0 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
	  	}

	  	function self_sign($sr_id, $user_id){
	    	$this->load->database();
			$query = $this->db->query('UPDATE sr_signature SET user_id = '.$user_id.' WHERE sr_id = '.$sr_id.' AND role_id = 0');
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

	}