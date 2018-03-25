<?php

	class deductions_model extends CI_Model{

  		function __contruct(){
			parent::__construct;
		}

		function update_files($assumed_id, $ded_id) {
  			$this->load->database();
  			$this->db->query('UPDATE deductions_filles SET ded_id = "'.$ded_id.'" WHERE ded_id = "'.$assumed_id.'"');
  		}

  		function getby_fille($ded_id){
	    	$this->load->database();
			$this->db->select('deductions_filles.*, users.fullname as user_name');
			$this->db->join('users', 'deductions_filles.user_id = users.id','left');
			$this->db->where('ded_id', $ded_id);
			$query = $this->db->get('deductions_filles');
			return $query->result_array();
  		}

  		function add($ded_id, $name, $user_id) {
	  		$this->load->database();
	  		$this->db->query('INSERT INTO deductions_filles(ded_id, name, user_id) VALUES("'.$ded_id.'","'.$name.'","'.$user_id.'")');
	  	}

	  	function remove($id) {
	      $this->load->database();
	      $this->db->query('DELETE FROM deductions_filles WHERE id = '.$id);
	    }

		function getall(){
	    	$this->load->database();
			$this->db->select('deductions.*, hotels.name as hotel_name, hotels.logo As logo, users.fullname as name, operators.name as operator_name');
			$this->db->join('hotels', 'deductions.hotel_id = hotels.id','left');
			$this->db->join('users', 'deductions.user_id = users.id','left');
			$this->db->join('operators', 'deductions.operator_id = operators.id','left');
			$query = $this->db->get('deductions');
			return $query->result_array();
  		}

		function create_deductions($data) {
			$this->load->database();
			$this->db->insert('deductions', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function deductions_sign(){
  	 		$this->load->database();
			 $this->db->select('deductions_role.*');
			 $query = $this->db->get('deductions_role');
			 return $query->result_array();  	
		}

		function deductions_do_sign($ded_id){
  	 		$this->load->database();
			$this->db->select('deductions_signature.*');
			$this->db->where('deductions_signature.ded_id', $ded_id);		
			$query = $this->db->get('deductions_signature');
			return $query->num_rows();  	
		}

		function add_signature($ded_id, $role_id, $department_id,  $rank){
	    	$this->load->database();
			$query = $this->db->query('INSERT INTO deductions_signature(ded_id, role_id, department_id,  rank) VALUES("'.$ded_id.'", "'.$role_id.'", "'.$department_id.'", "'.$rank.'")');
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
  		}

  		function getall_operator(){
	    	$this->load->database();
			$query = $this->db->get('operators');
			return $query->result_array();
  		}

  		function get_deductions($ded_id) {
			$this->db->select('deductions.*, hotels.name as hotel_name, hotels.logo As logo, users.fullname as name, operators.name as operator_name');
			$this->db->join('hotels', 'deductions.hotel_id = hotels.id','left');
			$this->db->join('users', 'deductions.user_id = users.id','left');
			$this->db->join('operators', 'deductions.operator_id = operators.id','left');
			$this->db->where('deductions.id', $ded_id);		
			$query = $this->db->get('deductions');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
		}

		function update_state($ded_id, $state) {
			$this->db->update('deductions', array('state_id'=> $state), "id = ".$ded_id);
		}

		function self_sign($ded_id, $user_id){
	    	$this->load->database();
			$query = $this->db->query('UPDATE deductions_signature SET user_id = '.$user_id.' WHERE ded_id = '.$ded_id.' AND role_id = 0');
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function getby_verbal($ded_id){
	    	$this->load->database();
			$this->db->select('deductions_signature.*, roles.role, departments.name as department');
			$this->db->join('roles', 'deductions_signature.role_id = roles.id', 'left');
			$this->db->join('departments', 'deductions_signature.department_id = departments.id', 'left');
			$this->db->where('ded_id', $ded_id);
			$this->db->order_by('rank');
			$query = $this->db->get('deductions_signature');
			return $query->result_array();
  		}

  		function getcomment($ded_id){
			$query = $this->db->query("
				SELECT users.fullname, deductions_comments.*	FROM deductions_comments
				JOIN users on deductions_comments.user_id = users.id
				WHERE deductions_comments.ded_id =".$ded_id);
			return $query->result_array();
  		}

		function update_deductions($data, $ded_id) {
			$this->load->database();
			$this->db->where('deductions.id', $ded_id);		
			$this->db->update('deductions', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function view($user_hotels = FALSE) {
  	  		$this->load->database();
			$this->db->select('deductions.*, hotels.name as hotel_name, hotels.logo As logo, users.fullname as name, operators.name as operator_name');
			$this->db->join('hotels', 'deductions.hotel_id = hotels.id','left');
			$this->db->join('users', 'deductions.user_id = users.id','left');
			$this->db->join('operators', 'deductions.operator_id = operators.id','left');
        	if ($user_hotels) {
          		$this->db->where_in('deductions.hotel_id', $user_hotels);
        	}
        	$this->db->order_by('date', 'DESC');
			$query = $this->db->get('deductions');
			return $query->result_array();
		}

		function get_signature_identity($sign_id){
  			$this->load->database();
			$query = $this->db->query('SELECT deductions.hotel_id, deductions_signature.ded_id FROM deductions_signature JOIN deductions ON deductions_signature.ded_id = deductions.id WHERE deductions_signature.id ='.$sign_id);
  			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  		}

  		function reject($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE deductions_signature SET user_id = '.$uid.', reject = 1 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function sign($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE deductions_signature SET user_id = '.$uid.' WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function unsign($id){
	  		$this->load->database();
			$query = $this->db->query('UPDATE deductions_signature SET user_id = NULL, reject = 0 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
	  	}

	  	function insertcomment($data){
			$this->db->insert('deductions_comments', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

  	}

?>