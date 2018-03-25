<?php

	class rr_change_model extends CI_Model{
	
  		function __contruct(){
			parent::__construct;
		}

		function update_files($assumed_id, $rr_id) {
  			$this->load->database();
  			$this->db->query('UPDATE rr_filles SET rr_id = "'.$rr_id.'" WHERE rr_id = "'.$assumed_id.'"');
  		}

  		function getby_fille($rr_id){
	    	$this->load->database();
			$this->db->where('rr_id', $rr_id);
			$query = $this->db->get('rr_filles');
			return $query->result_array();
  		}

  		function add($rr_id, $name) {
	  		$this->load->database();
	  		$this->db->query('INSERT INTO rr_filles(rr_id,name) VALUES("'.$rr_id.'","'.$name.'")');
	  	}

	  	function remove($id) {
	      $this->load->database();
	      $this->db->query('DELETE FROM rr_filles WHERE id = '.$id);
	    }

		function create_rr($data) {
			$this->load->database();
			$this->db->insert('rr_change', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function create_room($data) {
			$this->db->insert('rr_room', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function create_rate($data) {
			$this->db->insert('rr_rate', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function rr_sign ($type){
  			$this->load->database();
			$this->db->select('rr_role.*');
			$this->db->where('type', $type);		
			$query = $this->db->get('rr_role');
			return $query->result_array();  	
		}

		function rr_do_sign($rr_id){
  	 		$this->load->database();
			$this->db->select('rr_signature.*');
			$this->db->where('rr_signature.rr_id', $rr_id);		
			$query = $this->db->get('rr_signature');
			return $query->num_rows();  	
		}

		function add_signature($rr_id, $role_id, $department_id, $rank){
	    	$this->load->database();
			$query = $this->db->query('INSERT INTO rr_signature(rr_id, role_id, department_id, rank) VALUES("'.$rr_id.'", "'.$role_id.'", "'.$department_id.'", "'.$rank.'")');
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
  		}

  		function getall_operator(){
	    	$this->load->database();
			$query = $this->db->get('operators');
			return $query->result_array();
  		}

  		function get_rr($rr_id) {
			$this->db->select('rr_change.*, hotels.name as hotel_name, hotels.logo As logo, users.fullname as name');
			$this->db->join('hotels', 'rr_change.hotel_id = hotels.id','left');
			$this->db->join('users', 'rr_change.user_id = users.id','left');
			$this->db->where('rr_change.id', $rr_id);		
			$query = $this->db->get('rr_change');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
		}

		function get_rr_room($rr_id) {
        	$this->db->select('rr_room.*, operators.name as rt_name');
			$this->db->join('operators', 'rr_room.rt_id = operators.id','left');
			$this->db->where('rr_room.rr_id', $rr_id);
			$query = $this->db->get('rr_room');
			return ($query->num_rows() > 0 )? $query->result_array() : FALSE;
		}


		function get_rr_rate($rr_id) {
			$this->db->select('rr_rate.*, operators.name as rt_name');
			$this->db->join('operators', 'rr_rate.rt_id = operators.id','left');
			$this->db->where('rr_rate.rr_id', $rr_id);
			$query = $this->db->get('rr_rate');
			return ($query->num_rows() > 0 )? $query->result_array() : FALSE;
		}

		function get_comment($rr_id){
			$query = $this->db->query("
				SELECT users.fullname, rr_comments.comment, rr_comments.created FROM rr_comments
				JOIN users on rr_comments.user_id = users.id
				WHERE rr_comments.rr_id =".$rr_id);
			return $query->result_array();
  		}

  		function update_rr($data, $rr_id) {
			$this->load->database();
			$this->db->where('rr_change.id', $rr_id);		
			$this->db->update('rr_change', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function update_room($data, $rr_id, $item_id) {
			$this->load->database();
			$this->db->where('rr_room.rr_id', $rr_id);	
			$this->db->where('rr_room.id', $item_id);		
			$this->db->update('rr_room', $data);
			$query = $this->db->get('rr_room');
			return $query;
		}

		function update_rate($data, $rr_id) {
			$this->load->database();
			$this->db->where('rr_rate.rr_id', $rr_id);		
			$this->db->update('rr_rate', $data);
			return ($this->db->affected_rows() >0)? $this->db->insert_id() : FALSE;
		}

		function insert_comment($data){
			$this->db->insert('rr_comments', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function view_room($user_hotels = FALSE) {
  	  		$this->load->database();
			$this->db->select('users.id as userid,users.*, rr_change.*, hotels.name as hotel_name');
			$this->db->join('users', 'rr_change.user_id = users.id','left');
			$this->db->join('hotels', 'rr_change.hotel_id = hotels.id','left');
        	if ($user_hotels) {
          		$this->db->where_in('rr_change.hotel_id', $user_hotels);
        	}
        	$this->db->order_by('timestamp', 'DESC');
			$query = $this->db->get('rr_change');
			return $query->result_array();
		}

		function view_rate($user_hotels = FALSE) {
  	  		$this->load->database();
			$this->db->select('users.id as userid,users.*, rr_change.*, hotels.name as hotel_name');
			$this->db->join('users', 'rr_change.user_id = users.id','left');
			$this->db->join('hotels', 'rr_change.hotel_id = hotels.id','left');
        	if ($user_hotels) {
          		$this->db->where_in('rr_change.hotel_id', $user_hotels);
        	}
        	$this->db->order_by('timestamp', 'DESC');
			$query = $this->db->get('rr_change');
			return $query->result_array();
		}

		function getby_verbal($rr_id){
	    	$this->load->database();
			$this->db->select('rr_signature.*, roles.role, departments.name as department');
			$this->db->join('roles', 'rr_signature.role_id = roles.id', 'left');
			$this->db->join('departments', 'rr_signature.department_id = departments.id', 'left');
			$this->db->where('rr_id', $rr_id);
			$this->db->order_by('rank');
			$query = $this->db->get('rr_signature');
			return $query->result_array();
  		}

  		function update_state($rr_id, $state) {
			$this->db->update('rr_change', array('state_id'=> $state), "id = ".$rr_id);
		}

		function get_signature_identity($sign_id){
  			$this->load->database();
			$query = $this->db->query('SELECT rr_change.hotel_id, rr_signature.rr_id FROM rr_signature JOIN rr_change ON rr_signature.rr_id = rr_change.id WHERE rr_signature.id ='.$sign_id);
  			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  		}

  		function reject($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE rr_signature SET user_id = '.$uid.', reject = 1 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function sign($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE rr_signature SET user_id = '.$uid.' WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function unsign($id){
	  		$this->load->database();
			$query = $this->db->query('UPDATE rr_signature SET user_id = NULL, reject = 0 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
	  	}

	  	function self_sign($rr_id, $user_id){
	    	$this->load->database();
			$query = $this->db->query('UPDATE rr_signature SET user_id = '.$user_id.' WHERE rr_id = '.$rr_id.' AND role_id = 0');
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

	}