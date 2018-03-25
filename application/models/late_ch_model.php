<?php

	class late_ch_model extends CI_Model{
	
  		function __contruct(){
			parent::__construct;
		}

		function update_files($assumed_id, $ch_id) {
  			$this->load->database();
  			$this->db->query('UPDATE ch_filles SET ch_id = "'.$ch_id.'" WHERE ch_id = "'.$assumed_id.'"');
  		}

  		function getby_fille($ch_id){
	    	$this->load->database();
			$this->db->where('ch_id', $ch_id);
			$query = $this->db->get('ch_filles');
			return $query->result_array();
  		}

  		function add($ch_id, $name) {
	  		$this->load->database();
	  		$this->db->query('INSERT INTO ch_filles(ch_id,name) VALUES("'.$ch_id.'","'.$name.'")');
	  	}

	  	function remove($id) {
	      $this->load->database();
	      $this->db->query('DELETE FROM ch_filles WHERE id = '.$id);
	    }

		function create_ch($data) {
			$this->load->database();
			$this->db->insert('late_ch', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function create_room($data) {
			$this->db->insert('ch_room', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function ch_sign ($type){
  			$this->load->database();
			$this->db->select('ch_role.*');
			$this->db->where('type', $type);		
			$query = $this->db->get('ch_role');
			return $query->result_array();  	
		}

		function ch_do_sign($ch_id){
  	 		$this->load->database();
			$this->db->select('ch_signature.*');
			$this->db->where('ch_signature.ch_id', $ch_id);		
			$query = $this->db->get('ch_signature');
			return $query->num_rows();  	
		}

		function add_signature($ch_id, $role_id, $department_id, $rank){
	    	$this->load->database();
			$query = $this->db->query('INSERT INTO ch_signature(ch_id, role_id, department_id, rank) VALUES("'.$ch_id.'", "'.$role_id.'", "'.$department_id.'", "'.$rank.'")');
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
  		}

  		function get_ch($ch_id) {
			$this->db->select('late_ch.*, hotels.name as hotel_name, hotels.logo As logo, users.fullname as name');
			$this->db->join('hotels', 'late_ch.hotel_id = hotels.id','left');
			$this->db->join('users', 'late_ch.user_id = users.id','left');
			$this->db->where('late_ch.id', $ch_id);		
			$query = $this->db->get('late_ch');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
		}

		function get_ch_room($ch_id) {
        	$this->load->database();
			$this->db->where('ch_room.ch_id', $ch_id);
			$query = $this->db->get('ch_room');
			return ($query->num_rows() > 0 )? $query->result_array() : FALSE;
		}

		function get_comment($ch_id){
			$query = $this->db->query("
				SELECT users.fullname, ch_comments.comment, ch_comments.created FROM ch_comments
				JOIN users on ch_comments.user_id = users.id
				WHERE ch_comments.ch_id =".$ch_id);
			return $query->result_array();
  		}

  		function update_ch($data, $ch_id) {
			$this->load->database();
			$this->db->where('late_ch.id', $ch_id);		
			$this->db->update('late_ch', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function update_room($data, $ch_id, $item_id) {
			$this->load->database();
			$this->db->where('ch_room.ch_id', $ch_id);	
			$this->db->where('ch_room.id', $item_id);		
			$this->db->update('ch_room', $data);
			$query = $this->db->get('ch_room');
			return $query;
		}

		function insert_comment($data){
			$this->db->insert('ch_comments', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function view($user_hotels = FALSE) {
  	  		$this->load->database();
			$this->db->select('users.id as userid,users.*,late_ch.*, hotels.name as hotel_name');
			$this->db->join('users', 'late_ch.user_id = users.id','left');
			$this->db->join('hotels', 'late_ch.hotel_id = hotels.id','left');
        	if ($user_hotels) {
          		$this->db->where_in('late_ch.hotel_id', $user_hotels);
        	}
        	$this->db->order_by('timestamp', 'DESC');
			$query = $this->db->get('late_ch');
			return $query->result_array();
		}

		function getby_verbal($ch_id){
	    	$this->load->database();
			$this->db->select('ch_signature.*, roles.role, departments.name as department');
			$this->db->join('roles', 'ch_signature.role_id = roles.id', 'left');
			$this->db->join('departments', 'ch_signature.department_id = departments.id', 'left');
			$this->db->where('ch_id', $ch_id);
			$this->db->order_by('rank');
			$query = $this->db->get('ch_signature');
			return $query->result_array();
  		}

  		function update_state($ch_id, $state) {
			$this->db->update('late_ch', array('state_id'=> $state), "id = ".$ch_id);
		}

		function get_signature_identity($sign_id){
  			$this->load->database();
			$query = $this->db->query('SELECT late_ch.hotel_id, ch_signature.ch_id FROM ch_signature JOIN late_ch ON ch_signature.ch_id = late_ch.id WHERE ch_signature.id ='.$sign_id);
  			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  		}

  		function reject($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE ch_signature SET user_id = '.$uid.', reject = 1 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function sign($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE ch_signature SET user_id = '.$uid.' WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function unsign($id){
	  		$this->load->database();
			$query = $this->db->query('UPDATE ch_signature SET user_id = NULL, reject = 0 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
	  	}

	  	function self_sign($ch_id, $user_id){
	    	$this->load->database();
			$query = $this->db->query('UPDATE ch_signature SET user_id = '.$user_id.' WHERE ch_id = '.$ch_id.' AND role_id = 0');
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

	}