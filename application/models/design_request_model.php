<?php

	class design_request_model extends CI_Model{

  		function __contruct(){
			parent::__construct;
		}

		function view($user_hotels = FALSE, $state = FALSE, $role = FALSE) {
  	  		$this->load->database();
			$this->db->select('design_request.id, design_request.user_id, design_request.hotel_id, design_request.serial, design_request.department_id, design_request.date, design_request.chairman, design_request.state_id, design_request.timestamp, hotels.name as hotel_name, users.fullname as name, departments.name as department, design_states.name as state');
			$this->db->join('hotels', 'design_request.hotel_id = hotels.id','left');
			$this->db->join('users', 'design_request.user_id = users.id','left');
			$this->db->join('departments', 'design_request.department_id = departments.id', 'left');
			$this->db->join('design_states', 'design_request.state_id = design_states.id', 'left');
        	if ($user_hotels) {
          		$this->db->where_in('design_request.hotel_id', $user_hotels);
        	}
        	if ($state == 12) {
        		if ($role != 0) {
        			$this->db->where('design_request.chairman', $role);
        		}else{
					$this->db->where('design_request.state_id', 1);	
        		}
			}elseif ($state && $state > 0) {
				$this->db->where('design_request.state_id', $state);	
			}else{
				$this->db->where('design_request.state_id !=', 0);
			}
			$this->db->where('design_request.deleted !=', 1);
        	$this->db->order_by('timestamp', 'DESC');
			$query = $this->db->get('design_request');
			return $query->result_array();
		}

		function get_by_verbals($design_id){
	    	$this->load->database();
			$this->db->select('design_signature.role_id, design_signature.rank, design_signature.department_id, design_signature.user_id, design_signature.reject, roles.role, departments.name as department, users.fullname as user_name');
			$this->db->join('roles', 'design_signature.role_id = roles.id', 'left');
			$this->db->join('departments', 'design_signature.department_id = departments.id', 'left');
			$this->db->join('users', 'design_signature.user_id = users.id', 'left');
			$this->db->where('design_id', $design_id);
        	$this->db->order_by('design_signature.rank');
			$query = $this->db->get('design_signature');
			return $query->result_array();
  		}

  		function get_states(){
	    	$this->load->database();
			$this->db->select('design_role.role, design_role.department, design_role.rank, roles.role as role_name, departments.name as department_name');
			$this->db->join('roles', 'design_role.role = roles.id', 'left');
			$this->db->join('departments', 'design_role.department = departments.id', 'left');        	
			$this->db->order_by('design_role.rank');
			$query = $this->db->get('design_role');
			return $query->result_array();
  		}

		function get_design_by_serial($serial) {
			$this->db->select('design_request.id, design_request.serial');		
			$this->db->where('design_request.serial', $serial);
			$this->db->where('design_request.deleted !=', 1);		
			$query = $this->db->get('design_request');
			return ($query->num_rows() > 0 )? $query->result_array() : FALSE;
		}

		function create_design($data) {
			$this->load->database();
			$this->db->insert('design_request', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function update_files($assumed_id, $design_id) {
  			$this->load->database();
  			$this->db->query('UPDATE design_filles SET design_id = "'.$design_id.'" WHERE design_id = "'.$assumed_id.'"');
  		}

  		function create_item($data) {
			$this->load->database();
			$this->db->insert('design_items', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function design_sign (){
  			$this->load->database();
			$this->db->select('design_role.*');
			$query = $this->db->get('design_role');
			return $query->result_array();  	
		}

		function design_do_sign($design_id){
  	 		$this->load->database();
			$this->db->select('design_signature.*');
			$this->db->where('design_signature.design_id', $design_id);		
			$query = $this->db->get('design_signature');
			return $query->num_rows();  	
		}

		function add_signature($design_id, $role_id, $department_id,  $rank){
	    	$this->load->database();
			$query = $this->db->query('INSERT INTO design_signature(design_id, role_id, department_id, rank) VALUES("'.$design_id.'", "'.$role_id.'", "'.$department_id.'", "'.$rank.'")');
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
  		}

  		function get_by_fille($design_id){
	    	$this->load->database();
			$this->db->select('design_filles.*, users.fullname as user_name');
			$this->db->join('users', 'design_filles.user_id = users.id','left');
			$this->db->where('design_filles.design_id', $design_id);
			$this->db->where('design_filles.deleted !=', 1);		
			$query = $this->db->get('design_filles');
			return $query->result_array();
  		}

  		function add_fille($design_id, $name, $user_id) {
	  		$this->load->database();
	  		$this->db->query('INSERT INTO design_filles(design_id, name, user_id) VALUES("'.$design_id.'","'.$name.'","'.$user_id.'")');
	  	}

	    function remove_fille($id, $user_id) {
			$this->db->update('design_filles', array('user_delete'=> $user_id, 'deleted'=> 1), "id = ".$id);
		}

		function get_design_by($id = FALSE, $code= FALSE) {
			$this->db->select('design_request.*, hotels.name as hotel_name, hotels.logo As logo, users.fullname as name, departments.name as department, design_states.name as state');
			$this->db->join('hotels', 'design_request.hotel_id = hotels.id','left');
			$this->db->join('users', 'design_request.user_id = users.id','left');
			$this->db->join('departments', 'design_request.department_id = departments.id', 'left');
			$this->db->join('design_states', 'design_request.state_id = design_states.id', 'left');
			if ($id) {
				$this->db->where('design_request.id', $id);
			}
			if ($code) {		
				$this->db->where('design_request.serial', $code);
			}	
			$this->db->where('design_request.deleted !=', 1);		
			$query = $this->db->get('design_request');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
		}

		function update_state($design_id, $state) {
			$this->db->update('design_request', array('state_id'=> $state), "id = ".$design_id);
		}

		function get_allsignature($design_id){
	    	$this->load->database();
			$this->db->select('design_signature.user_id, design_signature.role_id, design_signature.department_id');
			$this->db->where('design_id', $design_id);
			$this->db->where('user_id !=', 0);
			$query = $this->db->get('design_signature');
			return $query->result_array();
  		}

		function update_final($design_id, $state) {
		    $this->db->update('design_request', array('chairman'=> $state), "id = ".$design_id);
		}

		function get_by_verbal($design_id){
	    	$this->load->database();
			$this->db->select('design_signature.*, roles.role, departments.name as department, users.fullname as user_name');
			$this->db->join('roles', 'design_signature.role_id = roles.id', 'left');
			$this->db->join('departments', 'design_signature.department_id = departments.id', 'left');
			$this->db->join('users', 'design_signature.user_id = users.id', 'left');
        	$this->db->order_by('rank');
			$this->db->where('design_id', $design_id);
			$query = $this->db->get('design_signature');
			return $query->result_array();
  		}

  		function update_message_id($id, $message_id) {
		    $this->load->database();
		    $this->db->where('design_request.id', $id);
		    $msg_id = $this->db->update('design_request', array('message_id' => $message_id));
		}

  		function get_items($design_id) {
			$this->db->select('design_items.*, users.fullname as user_name');
			$this->db->join('users', 'design_items.user_id = users.id','left');
			$this->db->where('design_items.design_id', $design_id);
			$this->db->where('design_items.deleted !=', 1);
			$query = $this->db->get('design_items');
			return $query->result_array();
		}

		function get_comment($design_id) {
			$this->db->select('design_comments.id, design_comments.comment, design_comments.timestamp, users.fullname');
			$this->db->join('users', 'design_comments.user_id = users.id','left');
			$this->db->where('design_comments.design_id', $design_id);
			$this->db->where('design_comments.deleted !=', 1);
			$query = $this->db->get('design_comments');
			return $query->result_array();
		}

  		function update_design($design_id, $data) {
			$this->load->database();
			$this->db->where('design_request.id', $design_id);		
			$this->db->update('design_request', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function update_item($id, $design_id, $data) {
			$this->load->database();
			$this->db->where('design_items.design_id', $design_id);	
			$this->db->where('design_items.id', $id);		
			$this->db->update('design_items', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

  		function remove_design($id, $user_id) {
			$this->db->update('design_request', array('user_delete'=> $user_id, 'deleted'=> 1), "id = ".$id);
		}

		function remove_item($id, $user_id) {
			$this->db->update('design_items', array('user_delete'=> $user_id, 'deleted'=> 1), "id = ".$id);
		}

		function get_signature_identity($sign_id){
  			$this->load->database();
			$query = $this->db->query('SELECT design_request.serial, design_request.message_id, design_request.hotel_id, design_signature.design_id FROM design_signature JOIN design_request ON design_signature.design_id = design_request.id WHERE design_signature.id ='.$sign_id);
  			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  		}

  		function unsign($id){
	  		$this->load->database();
			$query = $this->db->query('UPDATE design_signature SET user_id = NULL, reject = 0 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
	  	}

	  	function reject($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE design_signature SET user_id = '.$uid.', reject = 1 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function sign($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE design_signature SET user_id = '.$uid.' WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function edit_target($design_id, $final, $user_id) {
			$this->db->update('design_request', array('final'=> $final, 'final_user'=> $user_id), "id = ".$design_id);
		}

  		function insert_comment($data){
			$this->db->insert('design_comments', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function remove_comment($id, $user_id) {
			$this->db->update('design_comments', array('user_delete'=> $user_id, 'deleted'=> 1), "id = ".$id);
		}

		function edit_comment($id, $comment) {
			$this->db->update('design_comments', array('comment'=> $comment), "id = ".$id);
		}

	}

?>