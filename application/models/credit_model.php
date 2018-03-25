<?php

	class credit_model extends CI_Model{

  		function __contruct(){
			parent::__construct;
		}

		function view($user_hotels = FALSE, $state = FALSE) {
  	  		$this->load->database();
			$this->db->select('credit.id, credit.user_id, credit.hotel_id, credit.company, credit.date, credit.state_id, credit.timestamp, hotels.name as hotel_name, users.fullname as name, credit_states.name as state');
			$this->db->join('hotels', 'credit.hotel_id = hotels.id','left');
			$this->db->join('users', 'credit.user_id = users.id','left');
			$this->db->join('credit_states', 'credit.state_id = credit_states.id', 'left');
        	if ($user_hotels) {
          		$this->db->where_in('credit.hotel_id', $user_hotels);
        	}
        	if ($state && $state > 0) {
				$this->db->where('credit.state_id', $state);	
			}else{
				$this->db->where('credit.state_id !=', 0);
			}
        	$this->db->order_by('timestamp', 'DESC');
			$query = $this->db->get('credit');
			return $query->result_array();
		}

		function get_by_verbals($credit_id){
	    	$this->load->database();
			$this->db->select('credit_signature.role_id, credit_signature.rank, credit_signature.department_id, credit_signature.user_id, credit_signature.reject, roles.role, departments.name as department, users.fullname as user_name');
			$this->db->join('roles', 'credit_signature.role_id = roles.id', 'left');
			$this->db->join('departments', 'credit_signature.department_id = departments.id', 'left');
			$this->db->join('users', 'credit_signature.user_id = users.id', 'left');
			$this->db->where('credit_id', $credit_id);
        	$this->db->order_by('credit_signature.rank');
			$query = $this->db->get('credit_signature');
			return $query->result_array();
  		}

  		function get_states(){
	    	$this->load->database();
			$this->db->select('credit_states.*');
			$x = array('0' => 2, '1' => 3);
			$this->db->where_not_in('credit_states.id', $x);
			$query = $this->db->get('credit_states');
			return $query->result_array();
  		}

		function create_credit($data) {
			$this->load->database();
			$this->db->insert('credit', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function update_files($assumed_id, $credit_id) {
  			$this->load->database();
  			$this->db->query('UPDATE credit_filles SET credit_id = "'.$credit_id.'" WHERE credit_id = "'.$assumed_id.'"');
  		}

  		function credit_sign (){
  			$this->load->database();
			$this->db->select('credit_role.*');
			$query = $this->db->get('credit_role');
			return $query->result_array();  	
		}

		function credit_do_sign($credit_id){
  	 		$this->load->database();
			$this->db->select('credit_signature.*');
			$this->db->where('credit_signature.credit_id', $credit_id);		
			$query = $this->db->get('credit_signature');
			return $query->num_rows();  	
		}

		function add_signature($credit_id, $role_id, $department_id,  $rank){
	    	$this->load->database();
			$query = $this->db->query('INSERT INTO credit_signature(credit_id, role_id, department_id, rank) VALUES("'.$credit_id.'", "'.$role_id.'", "'.$department_id.'", "'.$rank.'")');
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
  		}

  		function get_by_fille($credit_id){
	    	$this->load->database();
			$this->db->select('credit_filles.*, users.fullname as user_name');
			$this->db->join('users', 'credit_filles.user_id = users.id','left');
			$this->db->where('credit_id', $credit_id);
			$query = $this->db->get('credit_filles');
			return $query->result_array();
  		}

  		function add_fille($credit_id, $name, $user_id) {
	  		$this->load->database();
	  		$this->db->query('INSERT INTO credit_filles(credit_id, name, user_id) VALUES("'.$credit_id.'","'.$name.'","'.$user_id.'")');
	  	}

	  	function remove_fille($id) {
	      $this->load->database();
	      $this->db->query('DELETE FROM credit_filles WHERE id = '.$id);
	    }

	    function get_credit($credit_id) {
			$this->db->select('credit.*, hotels.name as hotel_name, hotels.logo As logo, users.fullname as name, credit_states.name as state');
			$this->db->join('hotels', 'credit.hotel_id = hotels.id','left');
			$this->db->join('users', 'credit.user_id = users.id','left');
			$this->db->join('credit_states', 'credit.state_id = credit_states.id', 'left');
			$this->db->where('credit.id', $credit_id);		
			$query = $this->db->get('credit');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
		}

		function update_state($credit_id, $state) {
			$this->db->update('credit', array('state_id'=> $state), "id = ".$credit_id);
		}

		function update_message_id($id, $message_id) {
		    $this->load->database();
		    $this->db->where('credit.id', $id);
		    //if(isset($message_id)){
		    $msg_id = $this->db->update('credit', array('message_id' => $message_id));
		    //die(print_r($msg_id));
		    //}else{
		        //die(print_r($message_id));
		    //}
		}

		function get_by_verbal($credit_id){
	    	$this->load->database();
			$this->db->select('credit_signature.*, roles.role, departments.name as department, users.fullname as user_name');
			$this->db->join('roles', 'credit_signature.role_id = roles.id', 'left');
			$this->db->join('departments', 'credit_signature.department_id = departments.id', 'left');
			$this->db->join('users', 'credit_signature.user_id = users.id', 'left');
			$this->db->where('credit_id', $credit_id);
			$query = $this->db->get('credit_signature');
			return $query->result_array();
  		}

		function get_comment($credit_id){
			$query = $this->db->query("
				SELECT users.fullname, credit_comments.comment, credit_comments.timestamp FROM credit_comments
				JOIN users on credit_comments.user_id = users.id
				WHERE credit_comments.credit_id =".$credit_id
			);
			return $query->result_array();
  		}

  		function update_credit($credit_id, $data) {
			$this->load->database();
			$this->db->where('credit.id', $credit_id);		
			$this->db->update('credit', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function get_signature_identity($sign_id){
  			$this->load->database();
			$query = $this->db->query('SELECT credit.hotel_id, credit_signature.credit_id FROM credit_signature JOIN credit ON credit_signature.credit_id = credit.id WHERE credit_signature.id ='.$sign_id);
  			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  		}

  		function unsign($id){
	  		$this->load->database();
			$query = $this->db->query('UPDATE credit_signature SET user_id = NULL, reject = 0 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
	  	}

	  	function reject($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE credit_signature SET user_id = '.$uid.', reject = 1 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function sign($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE credit_signature SET user_id = '.$uid.' WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function insert_comment($data){
			$this->db->insert('credit_comments', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

	}

?>