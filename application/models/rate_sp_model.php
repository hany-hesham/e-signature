<?php

	class rate_sp_model extends CI_Model{

  		function __contruct(){
			parent::__construct;
		}

		function view($user_hotels = FALSE, $state = FALSE) {
  	  		$this->load->database();
			$this->db->select('rate_sp.id, rate_sp.hotel_id, rate_sp.state_id, hotels.name as hotel_name, hotels.logo As logo, users.fullname as name');
			$this->db->join('hotels', 'rate_sp.hotel_id = hotels.id','left');
			$this->db->join('users', 'rate_sp.user_id = users.id','left');
        	if ($user_hotels) {
          		$this->db->where_in('rate_sp.hotel_id', $user_hotels);
        	}
        	$x = array('0' => 0, '1' => 2, '2' => 3);
        	if ($state) {
				$this->db->where('rate_sp.state_id', $state);	
			}else{
				$this->db->where_not_in('rate_sp.state_id', $x);	
			}	
        	$this->db->order_by('timestamp', 'DESC');
			$query = $this->db->get('rate_sp');
			return $query->result_array();
		}

		function view_state($user_hotels = FALSE, $state) {
  	  		$this->load->database();
			$this->db->select('rate_sp.id, rate_sp.hotel_id, rate_sp.state_id, hotels.name as hotel_name, hotels.logo As logo, users.fullname as name');
			$this->db->join('hotels', 'rate_sp.hotel_id = hotels.id','left');
			$this->db->join('users', 'rate_sp.user_id = users.id','left');
        	if ($user_hotels) {
          		$this->db->where_in('rate_sp.hotel_id', $user_hotels);
        	}
			$this->db->where('rate_sp.state_id', $state);		
        	$this->db->order_by('timestamp', 'DESC');
			$query = $this->db->get('rate_sp');
			return $query->result_array();
		}

		function get_by_verbals($sp_id){
	    	$this->load->database();
			$this->db->select('sp_signature.role_id, sp_signature.rank, sp_signature.department_id, sp_signature.user_id, sp_signature.reject, roles.role, departments.name as department, users.fullname as user_name');
			$this->db->join('roles', 'sp_signature.role_id = roles.id', 'left');
			$this->db->join('departments', 'sp_signature.department_id = departments.id', 'left');
			$this->db->join('users', 'sp_signature.user_id = users.id', 'left');
			$this->db->where('sp_id', $sp_id);
        	$this->db->order_by('sp_signature.rank');
			$query = $this->db->get('sp_signature');
			return $query->result_array();
  		}

		function get_itemss($sp_id) {
			$this->db->select('sp_item.guest, sp_item.booking, sp_item.room, sp_item.discount, sp_item.arrival');
			$this->db->where('sp_item.sp_id', $sp_id);
			$this->db->order_by('timestamp');
			$query = $this->db->get('sp_item');
			return ($query->num_rows() > 0 )? $query->result_array() : FALSE;
		}

		function getall_board(){
	    	$this->load->database();
			$this->db->select('board_types.board_type as name, board_types.id');
			$query = $this->db->get('board_types');
			return $query->result_array();
  		}

		function get_count($sp_id){
	    	$this->load->database();
			$this->db->select('sp_signature.*');
			$this->db->where('sp_id', $sp_id);
			$this->db->order_by('rank');
			$query = $this->db->get('sp_signature');
			return $query->num_rows();
  		}

		function create_rate($data) {
			$this->load->database();
			$this->db->insert('rate_sp', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function update_files($assumed_id, $sp_id) {
  			$this->load->database();
  			$this->db->query('UPDATE sp_filles SET sp_id = "'.$sp_id.'" WHERE sp_id = "'.$assumed_id.'"');
  		}

  		function update_type($type, $sp_id) {
  			$this->load->database();
  			$this->db->query('UPDATE rate_sp SET type = "'.$type.'" WHERE id = "'.$sp_id.'"');
  		}

  		function create_item($data) {
			$this->db->insert('sp_item', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function sp_sign ($sp_type){
  			$this->load->database();
			$this->db->select('sp_role.*');
			$this->db->where('sp_type', $sp_type);		
			$query = $this->db->get('sp_role');
			return $query->result_array();  	
		}

		function sp_do_sign($sp_id){
  	 		$this->load->database();
			$this->db->select('sp_signature.*');
			$this->db->where('sp_signature.sp_id', $sp_id);		
			$query = $this->db->get('sp_signature');
			return $query->num_rows();  	
		}

		function add_signature($sp_id, $role_id, $department_id,  $rank){
	    	$this->load->database();
			$query = $this->db->query('INSERT INTO sp_signature(sp_id, role_id, department_id, rank) VALUES("'.$sp_id.'", "'.$role_id.'", "'.$department_id.'", "'.$rank.'")');
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
  		}

  		function getby_fille($sp_id){
	    	$this->load->database();
			$this->db->where('sp_id', $sp_id);
			$query = $this->db->get('sp_filles');
			return $query->result_array();
  		}

  		function add($sp_id, $name, $user_id) {
	  		$this->load->database();
	  		$this->db->query('INSERT INTO sp_filles(sp_id,name, user_id) VALUES("'.$sp_id.'","'.$name.'","'.$user_id.'")');
	  	}

	  	function remove($id) {
	      $this->load->database();
	      $this->db->query('DELETE FROM sp_filles WHERE id = '.$id);
	    }

	    function get_sp($sp_id) {
			$this->db->select('rate_sp.*, hotels.name as hotel_name, hotels.logo As logo, users.fullname as name');
			$this->db->join('hotels', 'rate_sp.hotel_id = hotels.id','left');
			$this->db->join('users', 'rate_sp.user_id = users.id','left');
			$this->db->where('rate_sp.id', $sp_id);		
			$query = $this->db->get('rate_sp');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
		}

		function update_state($sp_id, $state) {
			$this->db->update('rate_sp', array('state_id'=> $state), "id = ".$sp_id);
		}

		function update_message_id($id, $message_id) {
		    $this->load->database();
		    $this->db->where('rate_sp.id', $id);
		    //if(isset($message_id)){
		    $msg_id = $this->db->update('rate_sp', array('message_id' => $message_id));
		    //die(print_r($msg_id));
		    //}else{
		        //die(print_r($message_id));
		    //}
		}

		function getby_verbal($sp_id){
	    	$this->load->database();
			$this->db->select('sp_signature.*, roles.role, departments.name as department');
			$this->db->join('roles', 'sp_signature.role_id = roles.id', 'left');
			$this->db->join('departments', 'sp_signature.department_id = departments.id', 'left');
			$this->db->where('sp_id', $sp_id);
			$this->db->order_by('rank');
			$query = $this->db->get('sp_signature');
			return $query->result_array();
  		}

  		function get_items($sp_id) {
			$this->db->select('sp_item.*, board_types.board_type as board_name');
			$this->db->join('board_types', 'sp_item.board_id = board_types.id', 'left');
			$this->db->where('sp_item.sp_id', $sp_id);
			$this->db->order_by('timestamp');
			$query = $this->db->get('sp_item');
			return ($query->num_rows() > 0 )? $query->result_array() : FALSE;
		}

  		function get_comment($sp_id){
			$query = $this->db->query("
				SELECT users.fullname, sp_comments.* FROM sp_comments
				JOIN users on sp_comments.user_id = users.id
				WHERE sp_comments.sp_id =".$sp_id);
			return $query->result_array();
  		}

  		function update_sp($data, $sp_id) {
			$this->load->database();
			$this->db->where('rate_sp.id', $sp_id);		
			$this->db->update('rate_sp', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function update_item($data, $sp_id, $id) {
			$this->load->database();
			$this->db->where('sp_item.sp_id', $sp_id);	
			$this->db->where('sp_item.id', $id);		
			$this->db->update('sp_item', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

  		function get_signature_identity($sign_id){
  			$this->load->database();
			$query = $this->db->query('SELECT rate_sp.hotel_id, sp_signature.sp_id FROM sp_signature JOIN rate_sp ON sp_signature.sp_id = rate_sp.id WHERE sp_signature.id ='.$sign_id);
  			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  		}

  		function unsign($id){
	  		$this->load->database();
			$query = $this->db->query('UPDATE sp_signature SET user_id = NULL, reject = 0 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
	  	}

  		function reject($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE sp_signature SET user_id = '.$uid.', reject = 1 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function sign($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE sp_signature SET user_id = '.$uid.' WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function insert_comment($data){
			$this->db->insert('sp_comments', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function sp_approval_sign ($sp_type){
  			$this->load->database();
			$this->db->select('sp_approval_role.*');
			$this->db->where('sp_type', $sp_type);		
			$query = $this->db->get('sp_approval_role');
			return $query->result_array();  	
		}

	}

?>