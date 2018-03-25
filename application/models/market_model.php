<?php

	class market_model extends CI_Model{

  		function __contruct(){
			parent::__construct;
		}

		function view($state = FALSE) {
  	  		$this->load->database();
			$this->db->select('market.*, users.fullname as user_name');
			$this->db->join('users', 'market.user_id = users.id', 'left');
			if ($state) {
				$this->db->where('market.state_id', $state);	
			}else{
				$this->db->where('market.state_id !=', 0);
			}	
        	$this->db->order_by('timestamp', 'DESC');
			$query = $this->db->get('market');
			return $query->result_array();
		}

		function get_by_verbals($market_id){
	    	$this->load->database();
			$this->db->select('market_signature.role_id, market_signature.rank,market_signature.department_id, market_signature.user_id, market_signature.reject, roles.role, departments.name as department, users.fullname as user_name');
			$this->db->join('roles', 'market_signature.role_id = roles.id', 'left');
			$this->db->join('departments', 'market_signature.department_id = departments.id', 'left');
			$this->db->join('users', 'market_signature.user_id = users.id', 'left');
			$this->db->where('market_id', $market_id);
        	$this->db->order_by('market_signature.rank');
			$query = $this->db->get('market_signature');
			return $query->result_array();
  		}

		function get_by_fille($market_id){
	    	$this->load->database();
			$this->db->select('market_filles.*, users.fullname as user_name');
			$this->db->join('users', 'market_filles.user_id = users.id','left');
			$this->db->where('market_id', $market_id);
			$query = $this->db->get('market_filles');
			return $query->result_array();
  		}

		function create_diff_market($data) {
			$this->load->database();
			$this->db->insert('market_defferent', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function create_period($data) {
			$this->load->database();
			$this->db->insert('market_period', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function create_hotel($data) {
	  		$this->load->database();
	  		$this->db->insert('market_hotel', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
  		}

  		function create_market($data) {
			$this->load->database();
			$this->db->insert('market', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function update_condition($market_id, $condition) {
			$this->db->update('market', array('condition'=> $condition), "id = ".$market_id);
		}
		function market_sign (){
  			$this->load->database();
			$this->db->select('market_role.*');
			$query = $this->db->get('market_role');
			return $query->result_array();  	
		}

		function market_do_sign($market_id){
  	 		$this->load->database();
			$this->db->select('market_signature.*');
			$this->db->where('market_signature.market_id', $market_id);		
			$query = $this->db->get('market_signature');
			return $query->num_rows();  	
		}

		function add_signature($market_id, $role_id, $department_id,  $rank){
	    	$this->load->database();
			$query = $this->db->query('INSERT INTO market_signature(market_id, role_id, department_id, rank) VALUES("'.$market_id.'", "'.$role_id.'", "'.$department_id.'", "'.$rank.'")');
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
  		}

  		function get_market($market_id){
	    	$this->load->database();
			$this->db->select('market.*, users.fullname as user_name');
			$this->db->join('users', 'market.user_id = users.id', 'left');
			$this->db->where('market.id', $market_id);
			$query = $this->db->get('market');
			return $query->row_array();
  		}

  		function update_state($market_id, $state) {
			$this->db->update('market', array('state_id'=> $state), "id = ".$market_id);
		}

		function update_message_id($id, $message_id) {
		    $this->load->database();
		    $this->db->where('market.id', $id);
		    //if(isset($message_id)){
		    $msg_id = $this->db->update('market', array('message_id' => $message_id));
		    //die(print_r($msg_id));
		    //}else{
		        //die(print_r($message_id));
		    //}
		}

		function get_by_verbal($market_id){
	    	$this->load->database();
			$this->db->select('market_signature.*, roles.role, departments.name as department, users.fullname as user_name');
			$this->db->join('roles', 'market_signature.role_id = roles.id', 'left');
			$this->db->join('departments', 'market_signature.department_id = departments.id', 'left');
			$this->db->join('users', 'market_signature.user_id = users.id', 'left');
			$this->db->where('market_id', $market_id);
        	$this->db->order_by('rank');
			$query = $this->db->get('market_signature');
			return $query->result_array();
  		}

  		function getby_role($role_id, $department_id = FALSE) {
			if ($department_id) {
				$query = $this->db->query('SELECT id, fullname, email, channel FROM users WHERE users.role_id = '.$role_id.' AND department_id = '.$department_id);
			}else{
				$query = $this->db->query('SELECT id, fullname, email, channel FROM users WHERE users.role_id = '.$role_id);
			}
			return $query->result_array();
		}

  		function get_diff_market($market_id){
	    	$this->load->database();
			$this->db->select('market_defferent.*');
			$this->db->where('market_defferent.market_id', $market_id);
			$query = $this->db->get('market_defferent');
			return $query->result_array();
  		}

  		function get_period($diff_id){
	    	$this->load->database();
			$this->db->select('market_period.*');
			$this->db->where('market_period.diff_id', $diff_id);
			$query = $this->db->get('market_period');
			return $query->result_array();
  		}

  		function get_hotel($diff_id){
	    	$this->load->database();
			$this->db->select('market_hotel.*, hotels.name as hotel_name');
			$this->db->join('hotels', 'market_hotel.hotel_id = hotels.id','left');
			$this->db->where('market_hotel.diff_id', $diff_id);
			$query = $this->db->get('market_hotel');
			return $query->result_array();
  		}

  		function get_comment($market_id){
			$query = $this->db->query("
				SELECT users.fullname, market_comments.comment, market_comments.timestamp FROM market_comments
				JOIN users on market_comments.user_id = users.id
				WHERE market_comments.market_id =".$market_id
			);
			return $query->result_array();
  		}

  		function add_fille($market_id, $name, $user_id) {
	  		$this->load->database();
	  		$this->db->query('INSERT INTO market_filles(market_id, name, user_id) VALUES("'.$market_id.'","'.$name.'","'.$user_id.'")');
	  	}

	  	function remove_fille($id) {
	      $this->load->database();
	      $this->db->query('DELETE FROM market_filles WHERE id = '.$id);
	    }

	    function update_period($id, $diff_id, $data) {
			$this->load->database();
			$this->db->where('market_period.diff_id', $diff_id);	
			$this->db->where('market_period.id', $id);		
			$this->db->update('market_period', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function update_hotel($id, $diff_id, $data) {
			$this->load->database();
			$this->db->where('market_hotel.diff_id', $diff_id);	
			$this->db->where('market_hotel.id', $id);		
			$this->db->update('market_hotel', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function get_signature_identity($sign_id){
  			$this->load->database();
			$query = $this->db->query('SELECT market_signature.market_id FROM market_signature WHERE market_signature.id ='.$sign_id);
  			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  		}

  		function unsign($id){
	  		$this->load->database();
			$query = $this->db->query('UPDATE market_signature SET user_id = NULL, reject = 0 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
	  	}

	  	function reject($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE market_signature SET user_id = '.$uid.', reject = 1 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function sign($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE market_signature SET user_id = '.$uid.' WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function insert_comment($data){
			$this->db->insert('market_comments', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

	}

?>