<?php

	class position_model extends CI_Model{

  		function __contruct(){
			parent::__construct;
		}

		function view($user_hotels = FALSE) {
  	  		$this->load->database();
			$this->db->select('position.*, hotels.name as hotel_name, hotels.logo As logo, users.fullname as name');
			$this->db->join('hotels', 'position.hotel_id = hotels.id','left');
			$this->db->join('users', 'position.user_id = users.id','left');
        	if ($user_hotels) {
          		$this->db->where_in('position.hotel_id', $user_hotels);
        	}
        	$this->db->order_by('timestamp', 'DESC');
			$query = $this->db->get('position');
			return $query->result_array();
		}

		function create_pos($data) {
			$this->load->database();
			$this->db->insert('position', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function create_request($data) {
			$this->load->database();
			$this->db->insert('position_request', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function pos_do_sign($pos_id){
  	 		$this->load->database();
			$this->db->select('position_signature.*');
			$this->db->where('position_signature.pos_id', $pos_id);		
			$query = $this->db->get('position_signature');
			return $query->num_rows();  	
		}

		function add_signature($pos_id, $role_id, $department_id,  $rank){
	    	$this->load->database();
			$query = $this->db->query('INSERT INTO position_signature(pos_id, role_id, department_id, rank) VALUES("'.$pos_id.'", "'.$role_id.'", "'.$department_id.'", "'.$rank.'")');
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
  		}

		function pos_sign(){
  	 		$this->load->database();
			 $this->db->select('position_role.*');
			 $query = $this->db->get('position_role');
			 return $query->result_array();  	
		}

		function get_position($pos_id) {
			$this->db->select('position.*, hotels.name as hotel_name, hotels.logo As logo, users.fullname as name');
			$this->db->join('hotels', 'position.hotel_id = hotels.id','left');
			$this->db->join('users', 'position.user_id = users.id','left');
			$this->db->where('position.id', $pos_id);		
			$query = $this->db->get('position');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
		}

		function self_sign($pos_id, $user_id, $role_id, $department_id){
	    	$this->load->database();
			$query = $this->db->query('UPDATE position_signature SET user_id = '.$user_id.' WHERE pos_id = '.$pos_id.' AND role_id = '.$role_id.' AND department_id ='.$department_id.'');
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function update_state($pos_id, $state) {
			$this->db->update('position', array('state_id'=> $state), "id = ".$pos_id);
		}

		function getby_verbal($pos_id){
	    	$this->load->database();
			$this->db->select('position_signature.*, roles.role, departments.name as department');
			$this->db->join('roles', 'position_signature.role_id = roles.id', 'left');
			$this->db->join('departments', 'position_signature.department_id = departments.id', 'left');
			$this->db->where('pos_id', $pos_id);
			$this->db->order_by('rank');
			$query = $this->db->get('position_signature');
			return $query->result_array();
  		}

  		function get_request($pos_id) {
			$this->db->select('position_request.*');
			$this->db->where('position_request.pos_id', $pos_id);
			$query = $this->db->get('position_request');
			return ($query->num_rows() > 0 )? $query->result_array() : FALSE;
		}

  		function get_comment($pos_id){
			$query = $this->db->query("
				SELECT users.fullname, position_comments.*	FROM position_comments
				JOIN users on position_comments.user_id = users.id
				WHERE position_comments.pos_id =".$pos_id);
			return $query->result_array();
  		}

  		function get_signature_identity($sign_id){
  			$this->load->database();
			$query = $this->db->query('SELECT position.hotel_id, position_signature.pos_id FROM position_signature JOIN position ON position_signature.pos_id = position.id WHERE position_signature.id ='.$sign_id);
  			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  		}

  		function unsign($id){
	  		$this->load->database();
			$query = $this->db->query('UPDATE position_signature SET user_id = NULL, reject = 0 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
	  	}

	  	function reject($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE position_signature SET user_id = '.$uid.', reject = 1 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function sign($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE position_signature SET user_id = '.$uid.' WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function insert_comment($data){
			$this->db->insert('position_comments', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function update_position($data, $pos_id) {
			$this->load->database();
			$this->db->where('position.id', $pos_id);		
			$this->db->update('position', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function update_request($data, $pos_id, $id) {
			$this->load->database();
			$this->db->where('position_request.pos_id', $pos_id);	
			$this->db->where('position_request.id', $id);		
			$this->db->update('position_request', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function create_base($data) {
			$this->load->database();
			$this->db->insert('position_replay_base', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function create_replay($data) {
			$this->load->database();
			$this->db->insert('position_replay', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function rep_do_sign($rep_id){
  	 		$this->load->database();
			$this->db->select('position_replay_signature.*');
			$this->db->where('position_replay_signature.rep_id', $rep_id);		
			$query = $this->db->get('position_replay_signature');
			return $query->num_rows();  	
		}

		function add_replay_signature($pos_id, $rep_id, $role_id, $department_id,  $rank, $hotel_id){
	    	$this->load->database();
			$query = $this->db->query('INSERT INTO position_replay_signature(pos_id, rep_id, role_id, department_id, rank, hotel_id) VALUES("'.$pos_id.'", "'.$rep_id.'", "'.$role_id.'", "'.$department_id.'", "'.$rank.'", "'.$hotel_id.'")');
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
  		}

		function rep_sign(){
  	 		$this->load->database();
			 $this->db->select('position_replay_role.*');
			 $query = $this->db->get('position_replay_role');
			 return $query->result_array();  	
		}

		function get_repaly($base_id) {
			$this->db->select('position_replay.*');
			$this->db->where('position_replay.base_id', $base_id);
			$query = $this->db->get('position_replay');
			return ($query->num_rows() > 0 )? $query->result_array() : FALSE;
		}

		function update_replay_state($rep_id, $state) {
			$this->db->update('position_replay', array('state_id'=> $state), "id = ".$rep_id);
		}

		function getby_verbal_replay($rep_id, $hotel_id){
	    	$this->load->database();
			$this->db->select('position_replay_signature.*, roles.role, departments.name as department');
			$this->db->join('roles', 'position_replay_signature.role_id = roles.id', 'left');
			$this->db->join('departments', 'position_replay_signature.department_id = departments.id', 'left');
			$this->db->where('rep_id', $rep_id);
			$this->db->where('hotel_id', $hotel_id);
			$this->db->order_by('rank');
			$query = $this->db->get('position_replay_signature');
			return $query->result_array();
  		}

  		function create_require($data) {
			$this->load->database();
			$this->db->insert('position_require', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function get_pos_repaly($pos_id) {
			$this->db->select('position_replay.*, hotels.name as hotel_name');
			$this->db->join('hotels', 'position_replay.hotel_id = hotels.id','left');
			$this->db->where('position_replay.pos_id', $pos_id);
			$this->db->where('position_replay.replay', 1);
			$query = $this->db->get('position_replay');
			return ($query->num_rows() > 0 )? $query->result_array() : FALSE;
		}

		function get_require($base_id, $pos_id) {
			$this->db->select('position_require.*, hotels.name as hotel_name');
			$this->db->join('hotels', 'position_require.hotel_id = hotels.id','left');
			$this->db->where('position_require.pos_id', $pos_id);
			$this->db->where('position_require.base_id', $base_id);
			$query = $this->db->get('position_require');
			return ($query->num_rows() > 0 )? $query->result_array() : FALSE;
		}

		function get_replay_signature_identity($sign_id){
  			$this->load->database();
			$query = $this->db->query('SELECT position_replay.hotel_id, position_replay_signature.pos_id, position_replay_signature.rep_id FROM position_replay_signature JOIN position_replay ON position_replay_signature.rep_id = position_replay.id WHERE position_replay_signature.id ='.$sign_id);
  			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  		}

  		function unsign_replay($id){
	  		$this->load->database();
			$query = $this->db->query('UPDATE position_replay_signature SET user_id = NULL, reject = 0 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
	  	}

	  	function reject_replay($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE position_replay_signature SET user_id = '.$uid.', reject = 1 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function sign_replay($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE position_replay_signature SET user_id = '.$uid.' WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}
		
  	}
?>