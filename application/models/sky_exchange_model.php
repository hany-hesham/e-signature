<?php
	class sky_exchange_model extends CI_Model{

  		function __contruct(){
			parent::__construct;
		}

		function create_exchange($data) {
			$this->load->database();
			$this->db->insert('sky_exchange', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function create_bank_rate($data) {
			$this->load->database();
			$this->db->insert('sky_bank_rate', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}


        function get_bank_rate($ex_id) {
        $this->load->database();
		$this->db->select('sky_bank_rate.*,banks.bank as bank_name,');
		$this->db->join('banks', 'sky_bank_rate.bankid = banks.id','left');
		$this->db->where('sky_bank_rate.exchange_id', $ex_id);
		$query = $this->db->get('sky_bank_rate');

		return ($query->num_rows() > 0 )? $query->result_array() : FALSE;
	}

		function update_exchange($data, $ex_id) {
			$this->load->database();
			$this->db->where('exchange.id', $ex_id);		
			$this->db->update('sky_exchange', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function update_bank_rate($data, $ex_id, $id) {
			$this->load->database();
			$this->db->where('sky_bank_rate.exchange_id', $ex_id);	
			$this->db->where('sky_bank_rate.id', $id);
			$query = $this->db->update('sky_bank_rate', $data);
			return $query;
		}

		function update_bank($data, $bank_id) {
			$this->load->database();
			$this->db->where('banks.id', $bank_id);		
			$this->db->update('banks', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function get_exchange($ex_id) {
			$this->db->select('sky_exchange.*, hotels.name as hotel_name, hotels.logo As logo, users.fullname as name');
			$this->db->join('hotels', 'sky_exchange.hotel_id = hotels.id','left');
			$this->db->join('users', 'sky_exchange.user_id = users.id','left');
			$this->db->where('sky_exchange.id', $ex_id);		
			$query = $this->db->get('sky_exchange');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
		}

		function ex_sign(){
  	 		$this->load->database();
			 $this->db->select('sky_exchange_role.*');
			 $query = $this->db->get('sky_exchange_role');
			 return $query->result_array();  	
		}

		function ex_do_sign($ex_id){
  	 		$this->load->database();
			$this->db->select('sky_exchange_signature.*');
			$this->db->where('sky_exchange_signature.ex_id', $ex_id);		
			$query = $this->db->get('sky_exchange_signature');
			return $query->num_rows();  	
		}

		function add_signature($ex_id, $role_id, $department_id,  $rank){
	    	$this->load->database();
			$query = $this->db->query('INSERT INTO sky_exchange_signature(ex_id, role_id, department_id,  rank) VALUES("'.$ex_id.'", "'.$role_id.'", "'.$department_id.'", "'.$rank.'")');
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
  		}

  		function getall_banks(){
	    	$this->load->database();
			$this->db->select('banks.*');
			$query = $this->db->get('banks');
			return $query->result_array();
  		}

  		function getall_raters($ex_id){
	    	$this->load->database();
			$this->db->select('sky_exchange_signature.*');
			$this->db->where('ex_id', $ex_id);
			$query = $this->db->get('sky_exchange_signature');
			return $query->result_array();
  		}

  		function GetComment($ex_id){
			$query = $this->db->query("
				SELECT users.fullname, sky_exchange_comments.comment, sky_exchange_comments.created	FROM sky_exchange_comments
				JOIN users on sky_exchange_comments.user_id = users.id
				WHERE sky_exchange_comments.ex_id =".$ex_id);
			return $query->result_array();
  		}

  		function getby_verbal($ex_id){
	    	$this->load->database();
			$this->db->select('sky_exchange_signature.*, roles.role, departments.name as department');
			$this->db->join('roles', 'sky_exchange_signature.role_id = roles.id', 'left');
			$this->db->join('departments', 'sky_exchange_signature.department_id = departments.id', 'left');
			$this->db->where('ex_id', $ex_id);
			$this->db->order_by('rank');
			$query = $this->db->get('sky_exchange_signature');
			return $query->result_array();
  		}

  		function update_state($ex_id, $state) {
			$this->db->update('sky_exchange', array('state_id'=> $state), "id = ".$ex_id);
		}

		function view($user_hotels = FALSE) {
  	  		$this->load->database();
			$this->db->select('sky_exchange.*, users.id as userid, hotels.name as hotel_name');
			$this->db->join('hotels', 'sky_exchange.hotel_id = hotels.id','left');
			$this->db->join('users', 'sky_exchange.user_id = users.id','left');
        	if ($user_hotels) {
          		$this->db->where_in('sky_exchange.hotel_id', $user_hotels);
        	}
        	$this->db->order_by('timestamp', 'DESC');
			$query = $this->db->get('sky_exchange');
			return $query->result_array();
		}

		function get_signature_identity($sign_id){
  			$this->load->database();
			$query = $this->db->query('SELECT sky_exchange.hotel_id, sky_exchange_signature.ex_id FROM sky_exchange_signature JOIN sky_exchange ON sky_exchange_signature.ex_id = sky_exchange.id WHERE sky_exchange_signature.id ='.$sign_id);
  			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  		}

  		function reject($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE sky_exchange_signature SET user_id = '.$uid.', reject = 1 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function sign($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE sky_exchange_signature SET user_id = '.$uid.' WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function unsign($id){
	  		$this->load->database();
			$query = $this->db->query('UPDATE sky_exchange_signature SET user_id = NULL, reject = 0 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
	  	}

	  	function self_sign($ex_id, $user_id){
	    	$this->load->database();
			$query = $this->db->query('UPDATE sky_exchange_signature SET user_id = '.$user_id.' WHERE ex_id = '.$ex_id.' AND role_id = 0');
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function InsertComment($data){
			$this->db->insert('sky_exchange_comments', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function getall(){
	    	$this->load->database();
			$this->db->select('users.id as userid,users.*,sky_exchange.*,hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('users', 'sky_exchange.user_id = users.id','left');
			$this->db->join('hotels', 'sky_exchange.hotel_id = hotels.id','left');
			$query = $this->db->get('sky_exchange');
			return $query->result_array();
  		}

  		function getby_criteria($hotel_id, $role_id, $department_id){
  			$this->load->database();
			$this->db->select('users.fullname, users.email, employees_hotels.hotel_id');
			$this->db->join('employees_hotels', 'users.id = employees_hotels.employee_id','left');
			$this->db->where('employees_hotels.hotel_id', $hotel_id);
			$this->db->where('users.role_id', $role_id);
			$this->db->where('users.department_id', $department_id);
			$query = $this->db->get('users');
			return $query->result_array();
  		}
		
  		function approve($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE sky_exchange_signature SET user_id = '.$uid.' WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

	  	function disapprove($id, $uid){
	  		$this->load->database();
			$query = $this->db->query('UPDATE sky_exchange_signature SET user_id = '.$uid.', reject = 1 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
	  	}

	  	function get_signer_email ($role_id, $department_id){
			$query = $this->db->query("
				SELECT email FROM users
				WHERE role_id =".$role_id."
				AND  department_id =".$department_id."
				AND  banned = '0' ");
			return $query->result_array();
		}

		function owner($user_id){
  			$query = $this->db->query("
				SELECT email FROM users
				WHERE id =".$user_id);
			return $query->result_array();
  		}
	}