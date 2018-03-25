<?php

	class complaint_model extends CI_Model{

  		function __contruct(){
			parent::__construct;
		}

		function update_files($assumed_id, $com_id) {
  			$this->load->database();
  			$this->db->query('UPDATE complaint_filles SET com_id = "'.$com_id.'" WHERE com_id = "'.$assumed_id.'"');
  		}

  		function getby_fille($com_id){
	    	$this->load->database();
			$this->db->select('complaint_filles.*, users.fullname as user_name');
			$this->db->join('users', 'complaint_filles.user_id = users.id','left');
			$this->db->where('com_id', $com_id);
			$query = $this->db->get('complaint_filles');
			return $query->result_array();
  		}

  		function add($com_id, $name, $user_id) {
	  		$this->load->database();
	  		$this->db->query('INSERT INTO complaint_filles(com_id, name, user_id) VALUES("'.$com_id.'","'.$name.'","'.$user_id.'")');
	  	}

	  	function remove($id) {
	      $this->load->database();
	      $this->db->query('DELETE FROM complaint_filles WHERE id = '.$id);
	    }

		function getall(){
	    	$this->load->database();
			$this->db->select('complaint.*, hotels.name as hotel_name, hotels.logo As logo, users.fullname as name, operators.name as operator_name');
			$this->db->join('hotels', 'complaint.hotel_id = hotels.id','left');
			$this->db->join('users', 'complaint.user_id = users.id','left');
			$this->db->join('operators', 'complaint.operator_id = operators.id','left');
			$query = $this->db->get('complaint');
			return $query->result_array();
  		}

		function create_complaint($data) {
			$this->load->database();
			$this->db->insert('complaint', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function complaint_sign(){
  	 		$this->load->database();
			 $this->db->select('complaint_role.*');
			 $query = $this->db->get('complaint_role');
			 return $query->result_array();  	
		}

		function complaint_do_sign($com_id){
  	 		$this->load->database();
			$this->db->select('complaint_signature.*');
			$this->db->where('complaint_signature.com_id', $com_id);		
			$query = $this->db->get('complaint_signature');
			return $query->num_rows();  	
		}

		function add_signature($com_id, $role_id, $department_id,  $rank){
	    	$this->load->database();
			$query = $this->db->query('INSERT INTO complaint_signature(com_id, role_id, department_id, rank) VALUES("'.$com_id.'", "'.$role_id.'", "'.$department_id.'", "'.$rank.'")');
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
  		}

  		function getall_operator(){
	    	$this->load->database();
			$query = $this->db->get('operators');
			return $query->result_array();
  		}

  		function get_complaint($com_id) {
			$this->db->select('complaint.*, hotels.name as hotel_name, hotels.logo As logo, users.fullname as name, operators.name as operator_name');
			$this->db->join('hotels', 'complaint.hotel_id = hotels.id','left');
			$this->db->join('users', 'complaint.user_id = users.id','left');
			$this->db->join('operators', 'complaint.operator_id = operators.id','left');
			$this->db->where('complaint.id', $com_id);		
			$query = $this->db->get('complaint');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
		}

		function update_state($com_id, $state) {
			$this->db->update('complaint', array('state_id'=> $state), "id = ".$com_id);
		}

		function self_sign($com_id, $user_id){
	    	$this->load->database();
			$query = $this->db->query('UPDATE complaint_signature SET user_id = '.$user_id.' WHERE com_id = '.$com_id.' AND role_id = 0');
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function getby_verbal($com_id){
	    	$this->load->database();
			$this->db->select('complaint_signature.*, roles.role, departments.name as department');
			$this->db->join('roles', 'complaint_signature.role_id = roles.id', 'left');
			$this->db->join('departments', 'complaint_signature.department_id = departments.id', 'left');
			$this->db->where('com_id', $com_id);
			$this->db->order_by('rank');
			$query = $this->db->get('complaint_signature');
			return $query->result_array();
  		}

  		function getcomment($com_id){
			$query = $this->db->query("
				SELECT users.fullname, complaint_comments.*	FROM complaint_comments
				JOIN users on complaint_comments.user_id = users.id
				WHERE complaint_comments.com_id =".$com_id);
			return $query->result_array();
  		}

		function update_complaint($data, $com_id) {
			$this->load->database();
			$this->db->where('complaint.id', $com_id);		
			$this->db->update('complaint', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function view($user_hotels = FALSE) {
  	  		$this->load->database();
			$this->db->select('complaint.*, hotels.name as hotel_name, hotels.logo As logo, users.fullname as name, operators.name as operator_name');
			$this->db->join('hotels', 'complaint.hotel_id = hotels.id','left');
			$this->db->join('users', 'complaint.user_id = users.id','left');
			$this->db->join('operators', 'complaint.operator_id = operators.id','left');
        	if ($user_hotels) {
          		$this->db->where_in('complaint.hotel_id', $user_hotels);
        	}
        	$this->db->order_by('date', 'DESC');
			$query = $this->db->get('complaint');
			return $query->result_array();
		}

		function get_signature_identity($sign_id){
  			$this->load->database();
			$query = $this->db->query('SELECT complaint.hotel_id, complaint_signature.com_id FROM complaint_signature JOIN complaint ON complaint_signature.com_id = complaint.id WHERE complaint_signature.id ='.$sign_id);
  			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  		}

  		function reject($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE complaint_signature SET user_id = '.$uid.', reject = 1 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function sign($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE complaint_signature SET user_id = '.$uid.' WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function unsign($id){
	  		$this->load->database();
			$query = $this->db->query('UPDATE complaint_signature SET user_id = NULL, reject = 0 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
	  	}

	  	function insertcomment($data){
			$this->db->insert('complaint_comments', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

  	}

?>