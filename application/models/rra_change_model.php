<?php

	class rra_change_model extends CI_Model{
	
  		function __contruct(){
			parent::__construct;
		}

		function update_files($assumed_id, $rra_id) {
  			$this->load->database();
  			$this->db->query('UPDATE rra_filles SET rra_id = "'.$rra_id.'" WHERE rra_id = "'.$assumed_id.'"');
  		}

  		function getby_fille($rra_id){
	    	$this->load->database();
			$this->db->where('rra_id', $rra_id);
			$query = $this->db->get('rra_filles');
			return $query->result_array();
  		}

  		function add($rra_id, $name) {
	  		$this->load->database();
	  		$this->db->query('INSERT INTO rra_filles(rra_id,name) VALUES("'.$rra_id.'","'.$name.'")');
	  	}

	  	function remove($id) {
	      $this->load->database();
	      $this->db->query('DELETE FROM rra_filles WHERE id = '.$id);
	    }

		function create_rr($data) {
			$this->load->database();
			$this->db->insert('rra_change', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function create_room($data) {
			$this->db->insert('rra_room', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function create_rate($data) {
			$this->db->insert('rra_rate', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function rra_sign ($type){
  			$this->load->database();
			$this->db->select('rra_role.*');
			$this->db->where('type', $type);		
			$query = $this->db->get('rra_role');
			return $query->result_array();  	
		}

		function rra_do_sign($rra_id){
  	 		$this->load->database();
			$this->db->select('rra_signature.*');
			$this->db->where('rra_signature.rra_id', $rra_id);		
			$query = $this->db->get('rra_signature');
			return $query->num_rows();  	
		}

		function add_signature($rra_id, $role_id, $department_id, $rank){
	    	$this->load->database();
			$query = $this->db->query('INSERT INTO rra_signature(rra_id, role_id, department_id, rank) VALUES("'.$rra_id.'", "'.$role_id.'", "'.$department_id.'", "'.$rank.'")');
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
  		}

  		function getall_operator(){
	    	$this->load->database();
			$query = $this->db->get('operators');
			return $query->result_array();
  		}

  		function get_rr($rra_id) {
			$this->db->select('rra_change.*, hotels.name as hotel_name, hotels.logo As logo, users.fullname as name');
			$this->db->join('hotels', 'rra_change.hotel_id = hotels.id','left');
			$this->db->join('users', 'rra_change.user_id = users.id','left');
			$this->db->where('rra_change.id', $rra_id);		
			$query = $this->db->get('rra_change');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
		}

		function get_rra($rra_id) {
        	$this->db->select('rra_room.*, operators.name as rt_name');
			$this->db->join('operators', 'rra_room.rt_id = operators.id','left');
			$this->db->where('rra_room.rra_id', $rra_id);
			$query = $this->db->get('rra_room');
			return ($query->num_rows() > 0 )? $query->result_array() : FALSE;
		}

		function get_comment($rra_id){
			$query = $this->db->query("
				SELECT users.fullname, rra_comments.comment, rra_comments.created FROM rra_comments
				JOIN users on rra_comments.user_id = users.id
				WHERE rra_comments.rra_id =".$rra_id);
			return $query->result_array();
  		}

  		function update_rr($data, $rra_id) {
			$this->load->database();
			$this->db->where('rra_change.id', $rra_id);		
			$this->db->update('rra_change', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function update_room($data, $rra_id, $item_id) {
			$this->load->database();
			$this->db->where('rra_room.rra_id', $rra_id);	
			$this->db->where('rra_room.id', $item_id);		
			$this->db->update('rra_room', $data);
			$query = $this->db->get('rra_room');
			return $query;
		}

		function update_rate($data, $rra_id) {
			$this->load->database();
			$this->db->where('rra_rate.rra_id', $rra_id);		
			$this->db->update('rra_rate', $data);
			return ($this->db->affected_rows() >0)? $this->db->insert_id() : FALSE;
		}

		function insert_comment($data){
			$this->db->insert('rra_comments', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function view($user_hotels = FALSE) {
  	  		$this->load->database();
			$this->db->select('rra_change.id ,rra_change.hotel_id, rra_change.date, rra_change.state_id, hotels.name as hotel_name');
			$this->db->join('hotels', 'rra_change.hotel_id = hotels.id','left');
        	if ($user_hotels) {
          		$this->db->where_in('rra_change.hotel_id', $user_hotels);
        	}
			$this->db->where('state_id !=', 0);
        	$this->db->order_by('timestamp', 'DESC');
			$query = $this->db->get('rra_change');
			return $query->result_array();
		}

		function view_app($user_hotels = FALSE) {
  	  		$this->load->database();
			$this->db->select('rra_change.id ,rra_change.hotel_id, rra_change.date, hotels.name as hotel_name');
			$this->db->join('hotels', 'rra_change.hotel_id = hotels.id','left');
        	if ($user_hotels) {
          		$this->db->where_in('rra_change.hotel_id', $user_hotels);
        	}
			$this->db->where('state_id', 2);
        	$this->db->order_by('timestamp', 'DESC');
			$query = $this->db->get('rra_change');
			return $query->result_array();
		}

		function view_rej($user_hotels = FALSE) {
  	  		$this->load->database();
			$this->db->select('rra_change.id ,rra_change.hotel_id, rra_change.date, hotels.name as hotel_name');
			$this->db->join('hotels', 'rra_change.hotel_id = hotels.id','left');
        	if ($user_hotels) {
          		$this->db->where_in('rra_change.hotel_id', $user_hotels);
        	}
			$this->db->where('state_id', 3);
        	$this->db->order_by('timestamp', 'DESC');
			$query = $this->db->get('rra_change');
			return $query->result_array();
		}

		function getby_verbal($rra_id){
	    	$this->load->database();
			$this->db->select('rra_signature.*, roles.role, departments.name as department');
			$this->db->join('roles', 'rra_signature.role_id = roles.id', 'left');
			$this->db->join('departments', 'rra_signature.department_id = departments.id', 'left');
			$this->db->where('rra_id', $rra_id);
			$this->db->order_by('rank');
			$query = $this->db->get('rra_signature');
			return $query->result_array();
  		}

  		function update_state($rra_id, $state) {
			$this->db->update('rra_change', array('state_id'=> $state), "id = ".$rra_id);
		}

		function get_signature_identity($sign_id){
  			$this->load->database();
			$query = $this->db->query('SELECT rra_change.hotel_id, rra_signature.rra_id FROM rra_signature JOIN rra_change ON rra_signature.rra_id = rra_change.id WHERE rra_signature.id ='.$sign_id);
  			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  		}

  		function reject($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE rra_signature SET user_id = '.$uid.', reject = 1 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function sign($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE rra_signature SET user_id = '.$uid.' WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function unsign($id){
	  		$this->load->database();
			$query = $this->db->query('UPDATE rra_signature SET user_id = NULL, reject = 0 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
	  	}

	  	function self_sign($rra_id, $user_id){
	    	$this->load->database();
			$query = $this->db->query('UPDATE rra_signature SET user_id = '.$user_id.' WHERE rra_id = '.$rra_id.' AND role_id = 0');
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

	}