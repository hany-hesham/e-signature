<?php

	class reservations_model extends CI_Model{

  		function __contruct(){
			parent::__construct;
		}

		function view_all($user_hotels = FALSE, $state = FALSE) {
  	  		$this->load->database();
			$this->db->select('reservations.id, reservations.user_id, reservations.hotel_id, reservations.name, reservations.arrival, reservations.departure, reservations.recived_by, reservations.state_id, reservations.timestamp, hotels.name as hotel_name, users.fullname as user_name');
			$this->db->join('hotels', 'reservations.hotel_id = hotels.id','left');
			$this->db->join('users', 'reservations.user_id = users.id','left');
        	if ($user_hotels) {
          		$this->db->where_in('reservations.hotel_id', $user_hotels);
        	}
        	if ($state) {
				$this->db->where('reservations.state_id', $state);	
			}else{
				$this->db->where('reservations.state_id !=', 0);
			}
        	$this->db->order_by('timestamp', 'DESC');
			$query = $this->db->get('reservations');
			return $query->result_array();
		}

		function view($user_hotels = FALSE, $state = FALSE) {
  	  		$this->load->database();
			$this->db->select('reservations.id, reservations.user_id, reservations.hotel_id, reservations.name, reservations.arrival, reservations.departure, reservations.recived_by, reservations.state_id, reservations.timestamp, hotels.name as hotel_name, users.fullname as user_name');
			$this->db->join('hotels', 'reservations.hotel_id = hotels.id','left');
			$this->db->join('users', 'reservations.user_id = users.id','left');
        	if ($user_hotels) {
          		$this->db->where_in('reservations.hotel_id', $user_hotels);
        	}
        	if ($state) {
				$this->db->where('reservations.state_id', $state);	
			}else{
				$this->db->where('reservations.state_id !=', 0);
			}
			$this->db->where('reservations.res_source_id !=', 18);	
        	$this->db->order_by('timestamp', 'DESC');
			$query = $this->db->get('reservations');
			return $query->result_array();
		}

		function get_by_verbals($res_id){
	    	$this->load->database();
			$this->db->select('reservations_signature.role_id, reservations_signature.rank, reservations_signature.department_id, reservations_signature.user_id, reservations_signature.reject, roles.role, departments.name as department, users.fullname as user_name');
			$this->db->join('roles', 'reservations_signature.role_id = roles.id', 'left');
			$this->db->join('departments', 'reservations_signature.department_id = departments.id', 'left');
			$this->db->join('users', 'reservations_signature.user_id = users.id', 'left');
			$this->db->where('res_id', $res_id);
        	$this->db->order_by('reservations_signature.rank');
			$query = $this->db->get('reservations_signature');
			return $query->result_array();
  		}

		function create_reservation($data) {
			$this->load->database();
			$this->db->insert('reservations', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function update_files($assumed_id, $res_id) {
  			$this->load->database();
  			$this->db->query('UPDATE reservations_filles SET res_id = "'.$res_id.'" WHERE res_id = "'.$assumed_id.'"');
  		}

  		function res_sign ($type){
  			$this->load->database();
			$this->db->select('reservations_role.*');
			$this->db->where('res_type', $type);
			$query = $this->db->get('reservations_role');
			return $query->result_array();  	
		}

		function res_do_sign($res_id){
  	 		$this->load->database();
			$this->db->select('reservations_signature.*');
			$this->db->where('reservations_signature.res_id', $res_id);	
        	$this->db->order_by('reservations_signature.rank');
			$query = $this->db->get('reservations_signature');
			return $query->num_rows();  	
		}

		function add_signature($res_id, $role_id, $department_id,  $rank){
	    	$this->load->database();
			$query = $this->db->query('INSERT INTO reservations_signature(res_id, role_id, department_id, rank) VALUES("'.$res_id.'", "'.$role_id.'", "'.$department_id.'", "'.$rank.'")');
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
  		}

  		function get_board_types(){
	    	$this->load->database();
			$this->db->select('board_type.*');
        	$this->db->order_by('board_type');
			$query = $this->db->get('board_type');
			return $query->result_array();
  		}

  		function get_res_sources(){
	    	$this->load->database();
			$this->db->select('res_type.*');
        	$this->db->order_by('name');
			$query = $this->db->get('res_type');
			return $query->result_array();
  		}

  		function get_res_types(){
	    	$this->load->database();
			$this->db->select('type.*');
        	$this->db->order_by('name');
			$query = $this->db->get('type');
			return $query->result_array();
  		}

  		function get_by_fille($res_id){
	    	$this->load->database();
			$this->db->select('reservations_filles.*, users.fullname as user_name');
			$this->db->join('users', 'reservations_filles.user_id = users.id','left');
			$this->db->where('res_id', $res_id);
			$query = $this->db->get('reservations_filles');
			return $query->result_array();
  		}

  		function get_reservation($res_id) {
			$this->db->select('reservations.*, hotels.name as hotel_name, hotels.logo As logo, users.fullname as user_name, board_type.board_type as board_type, res_type.name as res_source, type.name as res_type');
			$this->db->join('hotels', 'reservations.hotel_id = hotels.id','left');
			$this->db->join('users', 'reservations.user_id = users.id','left');
			$this->db->join('board_type', 'reservations.board_type_id = board_type.id','left');
			$this->db->join('res_type', 'reservations.res_source_id = res_type.id','left');
			$this->db->join('type', 'reservations.res_type_id = type.id','left');
			$this->db->where('reservations.id', $res_id);		
			$query = $this->db->get('reservations');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
		}

		function update_state($res_id, $state) {
			$this->db->update('reservations', array('state_id'=> $state), "id = ".$res_id);
		}

		function update_message_id($id, $message_id) {
		      $this->load->database();
		      $this->db->where('reservations.id', $id);
		      //if(isset($message_id)){
		      $msg_id = $this->db->update('reservations', array('message_id' => $message_id));
		      //die(print_r($msg_id));
		      //}else{
		              //die(print_r($message_id));
		      //}
		  }

		function get_by_verbal($res_id){
	    	$this->load->database();
			$this->db->select('reservations_signature.*, roles.role, departments.name as department, users.fullname as user_name');
			$this->db->join('roles', 'reservations_signature.role_id = roles.id', 'left');
			$this->db->join('departments', 'reservations_signature.department_id = departments.id', 'left');
			$this->db->join('users', 'reservations_signature.user_id = users.id', 'left');
			$this->db->where('res_id', $res_id);
        	$this->db->order_by('reservations_signature.rank');
			$query = $this->db->get('reservations_signature');
			return $query->result_array();
  		}

  		function get_comment($res_id){
			$query = $this->db->query("
				SELECT users.fullname, reservations_comments.comment, reservations_comments.timestamp FROM reservations_comments
				JOIN users on reservations_comments.user_id = users.id
				WHERE reservations_comments.res_id =".$res_id
			);
			return $query->result_array();
  		}

  		function add_fille($res_id, $name, $user_id) {
	  		$this->load->database();
	  		$this->db->query('INSERT INTO reservations_filles(res_id, name, user_id) VALUES("'.$res_id.'","'.$name.'","'.$user_id.'")');
	  	}

	  	function remove_fille($id) {
	      $this->load->database();
	      $this->db->query('DELETE FROM reservations_filles WHERE id = '.$id);
	    }

	    function update_reservation($res_id, $data) {
			$this->load->database();
			$this->db->where('reservations.id', $res_id);		
			$this->db->update('reservations', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function get_signature_identity($sign_id){
  			$this->load->database();
			$query = $this->db->query('SELECT reservations.hotel_id, reservations_signature.res_id,reservations_signature.role_id FROM reservations_signature JOIN reservations ON reservations_signature.res_id = reservations.id WHERE reservations_signature.id ='.$sign_id);
  			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  		}

  		function unsign($id){
	  		$this->load->database();
			$query = $this->db->query('UPDATE reservations_signature SET user_id = NULL, reject = 0 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
	  	}

	  	function reject($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE reservations_signature SET user_id = '.$uid.', reject = 1 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function sign($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE reservations_signature SET user_id = '.$uid.' WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function insert_comment($data){
			$this->db->insert('reservations_comments', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

	}

?>