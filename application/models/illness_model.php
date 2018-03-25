<?php

	class illness_model extends CI_Model{

  		function __contruct(){
			parent::__construct;
		}

		function view($user_hotels = FALSE) {
  	  		$this->load->database();
			$this->db->select('illness_guest.*, illness.user_id, illness.hotel_id, illness.date, illness.state_id, illness.timestamp, hotels.name as hotel_name, hotels.logo As logo, users.fullname as name');
			$this->db->join('illness', 'illness_guest.iln_id = illness.id','left');
			$this->db->join('hotels', 'illness.hotel_id = hotels.id','left');
			$this->db->join('users', 'illness.user_id = users.id','left');
        	if ($user_hotels) {
          		$this->db->where_in('illness.hotel_id', $user_hotels);
        	}
        	$this->db->order_by('illness.timestamp', 'DESC');
			$query = $this->db->get('illness_guest');
			return $query->result_array();
		}

		function view_month($user_hotels, $date) {
  	  		$this->load->database();
			$this->db->select('illness_guest.*, illness.user_id, illness.hotel_id, illness.date, illness.state_id, illness.timestamp, hotels.name as hotel_name, hotels.code as hotel_code, hotels.logo As logo, users.fullname as name, , operators.name as operator_name');
			$this->db->join('illness', 'illness_guest.iln_id = illness.id','left');
			$this->db->join('hotels', 'illness.hotel_id = hotels.id','left');
			$this->db->join('users', 'illness.user_id = users.id','left');
			$this->db->join('operators', 'illness_guest.operator_id = operators.id', 'left');
        	if ($user_hotels) {
          		$this->db->where_in('illness.hotel_id', $user_hotels);
        	}
			$this->db->where('illness.date', $date);
        	$this->db->order_by('illness.timestamp', 'DESC');
			$query = $this->db->get('illness_guest');
			return $query->result_array();
		}

		function get_hotel($code){
	    	$this->load->database();
			$this->db->select('hotels.*');			
			$this->db->where('code', $code);
			$query = $this->db->get('hotels');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  		}

		function view_hotel($hotel, $date) {
  	  		$this->load->database();
			$this->db->select('illness_guest.*, illness.user_id, illness.hotel_id, illness.date, illness.state_id, illness.timestamp, hotels.name as hotel_name, hotels.code as hotel_code, hotels.logo As logo, users.fullname as name, , operators.name as operator_name');
			$this->db->join('illness', 'illness_guest.iln_id = illness.id','left');
			$this->db->join('hotels', 'illness.hotel_id = hotels.id','left');
			$this->db->join('users', 'illness.user_id = users.id','left');
			$this->db->join('operators', 'illness_guest.operator_id = operators.id', 'left');
          	$this->db->where('illness.hotel_id', $hotel);
			$this->db->where('illness.date', $date);
        	$this->db->order_by('illness.timestamp', 'DESC');
			$query = $this->db->get('illness_guest');
			return $query->result_array();
		}

		function report_hotel($hotel) {
  	  		$this->load->database();
			$this->db->select('illness_guest.*, illness.user_id, illness.hotel_id, illness.date, illness.state_id, illness.timestamp, hotels.name as hotel_name, hotels.code as hotel_code, hotels.logo As logo, users.fullname as name, , operators.name as operator_name');
			$this->db->join('illness', 'illness_guest.iln_id = illness.id','left');
			$this->db->join('hotels', 'illness.hotel_id = hotels.id','left');
			$this->db->join('users', 'illness.user_id = users.id','left');
			$this->db->join('operators', 'illness_guest.operator_id = operators.id', 'left');
          	$this->db->where('illness.hotel_id', $hotel);
        	$this->db->order_by('illness_guest.dates', 'DESC');
			$query = $this->db->get('illness_guest');
			return $query->result_array();
		}

		function report_date($hotel, $from, $to) {
  	  		$this->load->database();
			$this->db->select('illness_guest.*, illness.user_id, illness.hotel_id, illness.date, illness.state_id, illness.timestamp, hotels.name as hotel_name, hotels.code as hotel_code, hotels.logo As logo, users.fullname as name, , operators.name as operator_name');
			$this->db->join('illness', 'illness_guest.iln_id = illness.id','left');
			$this->db->join('hotels', 'illness.hotel_id = hotels.id','left');
			$this->db->join('users', 'illness.user_id = users.id','left');
			$this->db->join('operators', 'illness_guest.operator_id = operators.id', 'left');
          	$this->db->where('illness.hotel_id', $hotel);
          	$this->db->where('illness_guest.dates >=', $from);
	        $this->db->where('illness_guest.dates <=', $to);
        	$this->db->order_by('illness_guest.dates', 'DESC');
			$query = $this->db->get('illness_guest');
			return $query->result_array();
		}

		function report_guest($hotel, $guest) {
  	  		$this->load->database();
			$this->db->select('illness_guest.*, illness.user_id, illness.hotel_id, illness.date, illness.state_id, illness.timestamp, hotels.name as hotel_name, hotels.code as hotel_code, hotels.logo As logo, users.fullname as name, , operators.name as operator_name');
			$this->db->join('illness', 'illness_guest.iln_id = illness.id','left');
			$this->db->join('hotels', 'illness.hotel_id = hotels.id','left');
			$this->db->join('users', 'illness.user_id = users.id','left');
			$this->db->join('operators', 'illness_guest.operator_id = operators.id', 'left');
          	$this->db->where('illness.hotel_id', $hotel);
	        $this->db->like('illness_guest.guest', $guest);
        	$this->db->order_by('illness_guest.dates', 'DESC');
			$query = $this->db->get('illness_guest');
			return $query->result_array();
		}

		function report_to($hotel, $operator_id) {
  	  		$this->load->database();
			$this->db->select('illness_guest.*, illness.user_id, illness.hotel_id, illness.date, illness.state_id, illness.timestamp, hotels.name as hotel_name, hotels.code as hotel_code, hotels.logo As logo, users.fullname as name, , operators.name as operator_name');
			$this->db->join('illness', 'illness_guest.iln_id = illness.id','left');
			$this->db->join('hotels', 'illness.hotel_id = hotels.id','left');
			$this->db->join('users', 'illness.user_id = users.id','left');
			$this->db->join('operators', 'illness_guest.operator_id = operators.id', 'left');
          	$this->db->where('illness.hotel_id', $hotel);
	        $this->db->like('illness_guest.operator_id', $operator_id);
        	$this->db->order_by('illness_guest.dates', 'DESC');
			$query = $this->db->get('illness_guest');
			return $query->result_array();
		}

		function get_operator($operator_id){
	    	$this->load->database();
          	$this->db->where('operators.id', $operator_id);
			$query = $this->db->get('operators');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  		}

  		function report_symptoms($hotel, $symptoms) {
  	  		$this->load->database();
			$this->db->select('illness_guest.*, illness.user_id, illness.hotel_id, illness.date, illness.state_id, illness.timestamp, hotels.name as hotel_name, hotels.code as hotel_code, hotels.logo As logo, users.fullname as name, , operators.name as operator_name');
			$this->db->join('illness', 'illness_guest.iln_id = illness.id','left');
			$this->db->join('hotels', 'illness.hotel_id = hotels.id','left');
			$this->db->join('users', 'illness.user_id = users.id','left');
			$this->db->join('operators', 'illness_guest.operator_id = operators.id', 'left');
          	$this->db->where('illness.hotel_id', $hotel);
	        $this->db->where('illness_guest.symptoms', $symptoms);
        	$this->db->order_by('illness_guest.dates', 'DESC');
			$query = $this->db->get('illness_guest');
			return $query->result_array();
		}

		function report_visit($hotel, $visit) {
  	  		$this->load->database();
			$this->db->select('illness_guest.*, illness.user_id, illness.hotel_id, illness.date, illness.state_id, illness.timestamp, hotels.name as hotel_name, hotels.code as hotel_code, hotels.logo As logo, users.fullname as name, , operators.name as operator_name');
			$this->db->join('illness', 'illness_guest.iln_id = illness.id','left');
			$this->db->join('hotels', 'illness.hotel_id = hotels.id','left');
			$this->db->join('users', 'illness.user_id = users.id','left');
			$this->db->join('operators', 'illness_guest.operator_id = operators.id', 'left');
          	$this->db->where('illness.hotel_id', $hotel);
	        $this->db->where('illness_guest.visit', $visit);
        	$this->db->order_by('illness_guest.dates', 'DESC');
			$query = $this->db->get('illness_guest');
			return $query->result_array();
		}

		function report_date_all($from, $to) {
  	  		$this->load->database();
			$this->db->select('illness_guest.*, illness.user_id, illness.hotel_id, illness.date, illness.state_id, illness.timestamp, hotels.name as hotel_name, hotels.code as hotel_code, hotels.logo As logo, users.fullname as name, , operators.name as operator_name');
			$this->db->join('illness', 'illness_guest.iln_id = illness.id','left');
			$this->db->join('hotels', 'illness.hotel_id = hotels.id','left');
			$this->db->join('users', 'illness.user_id = users.id','left');
			$this->db->join('operators', 'illness_guest.operator_id = operators.id', 'left');
          	$this->db->where('illness_guest.dates >=', $from);
	        $this->db->where('illness_guest.dates <=', $to);
        	$this->db->order_by('illness_guest.dates', 'DESC');
			$query = $this->db->get('illness_guest');
			return $query->result_array();
		}

		function report_guest_all($guest) {
  	  		$this->load->database();
			$this->db->select('illness_guest.*, illness.user_id, illness.hotel_id, illness.date, illness.state_id, illness.timestamp, hotels.name as hotel_name, hotels.code as hotel_code, hotels.logo As logo, users.fullname as name, , operators.name as operator_name');
			$this->db->join('illness', 'illness_guest.iln_id = illness.id','left');
			$this->db->join('hotels', 'illness.hotel_id = hotels.id','left');
			$this->db->join('users', 'illness.user_id = users.id','left');
			$this->db->join('operators', 'illness_guest.operator_id = operators.id', 'left');
	        $this->db->like('illness_guest.guest', $guest);
        	$this->db->order_by('illness_guest.dates', 'DESC');
			$query = $this->db->get('illness_guest');
			return $query->result_array();
		}

		function report_to_all($operator_id) {
  	  		$this->load->database();
			$this->db->select('illness_guest.*, illness.user_id, illness.hotel_id, illness.date, illness.state_id, illness.timestamp, hotels.name as hotel_name, hotels.code as hotel_code, hotels.logo As logo, users.fullname as name, , operators.name as operator_name');
			$this->db->join('illness', 'illness_guest.iln_id = illness.id','left');
			$this->db->join('hotels', 'illness.hotel_id = hotels.id','left');
			$this->db->join('users', 'illness.user_id = users.id','left');
			$this->db->join('operators', 'illness_guest.operator_id = operators.id', 'left');
	        $this->db->like('illness_guest.operator_id', $operator_id);
        	$this->db->order_by('illness_guest.dates', 'DESC');
			$query = $this->db->get('illness_guest');
			return $query->result_array();
		}

  		function report_symptoms_all($symptoms) {
  	  		$this->load->database();
			$this->db->select('illness_guest.*, illness.user_id, illness.hotel_id, illness.date, illness.state_id, illness.timestamp, hotels.name as hotel_name, hotels.code as hotel_code, hotels.logo As logo, users.fullname as name, , operators.name as operator_name');
			$this->db->join('illness', 'illness_guest.iln_id = illness.id','left');
			$this->db->join('hotels', 'illness.hotel_id = hotels.id','left');
			$this->db->join('users', 'illness.user_id = users.id','left');
			$this->db->join('operators', 'illness_guest.operator_id = operators.id', 'left');
	        $this->db->where('illness_guest.symptoms', $symptoms);
        	$this->db->order_by('illness_guest.dates', 'DESC');
			$query = $this->db->get('illness_guest');
			return $query->result_array();
		}

		function report_visit_all($visit) {
  	  		$this->load->database();
			$this->db->select('illness_guest.*, illness.user_id, illness.hotel_id, illness.date, illness.state_id, illness.timestamp, hotels.name as hotel_name, hotels.code as hotel_code, hotels.logo As logo, users.fullname as name, , operators.name as operator_name');
			$this->db->join('illness', 'illness_guest.iln_id = illness.id','left');
			$this->db->join('hotels', 'illness.hotel_id = hotels.id','left');
			$this->db->join('users', 'illness.user_id = users.id','left');
			$this->db->join('operators', 'illness_guest.operator_id = operators.id', 'left');
	        $this->db->where('illness_guest.visit', $visit);
        	$this->db->order_by('illness_guest.dates', 'DESC');
			$query = $this->db->get('illness_guest');
			return $query->result_array();
		}

		function create_iln($data) {
			$this->load->database();
			$this->db->insert('illness', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function update_files($assumed_id, $iln_id) {
  			$this->load->database();
  			$this->db->query('UPDATE illness_filles SET iln_id = "'.$iln_id.'" WHERE iln_id = "'.$assumed_id.'"');
  		}

  		function create_guest($data) {
			$this->db->insert('illness_guest', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function iln_sign (){
  			$this->load->database();
			$this->db->select('illness_role.*');
			$query = $this->db->get('illness_role');
			return $query->result_array();  	
		}

		function add_signature($iln_id, $role_id, $department_id,  $rank){
	    	$this->load->database();
			$query = $this->db->query('INSERT INTO illness_signature(iln_id, role_id, department_id, rank) VALUES("'.$iln_id.'", "'.$role_id.'", "'.$department_id.'", "'.$rank.'")');
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
  		}

  		function getall_operator(){
	    	$this->load->database();
			$query = $this->db->get('operators');
			return $query->result_array();
  		}

  		function getby_fille($iln_id){
	    	$this->load->database();
			$this->db->where('iln_id', $iln_id);
			$query = $this->db->get('illness_filles');
			return $query->result_array();
  		}

  		function add($iln_id, $name, $user_id) {
	  		$this->load->database();
	  		$this->db->query('INSERT INTO illness_filles(iln_id, name, user_id) VALUES("'.$iln_id.'","'.$name.'","'.$user_id.'")');
	  	}

	  	function remove($id) {
	      $this->load->database();
	      $this->db->query('DELETE FROM illness_filles WHERE id = '.$id);
	    }

	    function get_illness($iln_id) {
			$this->db->select('illness.*, hotels.name as hotel_name, hotels.code as hotel_code, hotels.logo As logo, users.fullname as name');
			$this->db->join('hotels', 'illness.hotel_id = hotels.id','left');
			$this->db->join('users', 'illness.user_id = users.id','left');
			$this->db->where('illness.id', $iln_id);		
			$query = $this->db->get('illness');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
		}

		function update_state($iln_id, $state) {
			$this->db->update('illness', array('state_id'=> $state), "id = ".$iln_id);
		}

		function getby_verbal($iln_id){
	    	$this->load->database();
			$this->db->select('illness_signature.*, roles.role, departments.name as department');
			$this->db->join('roles', 'illness_signature.role_id = roles.id', 'left');
			$this->db->join('departments', 'illness_signature.department_id = departments.id', 'left');
			$this->db->where('iln_id', $iln_id);
			$this->db->order_by('rank');
			$query = $this->db->get('illness_signature');
			return $query->result_array();
  		}

  		function get_notifyer(){
	    	$this->load->database();
			$this->db->select('illness_role.*');
			$this->db->order_by('rank');
			$query = $this->db->get('illness_role');
			return $query->result_array();
  		}

  		function get_guest($iln_id) {
			$this->db->select('illness_guest.*, operators.name as operator_name');
			$this->db->join('operators', 'illness_guest.operator_id = operators.id', 'left');
			$this->db->where('illness_guest.iln_id', $iln_id);
			$query = $this->db->get('illness_guest');
			return ($query->num_rows() > 0 )? $query->result_array() : FALSE;
		}

		function get_comment($iln_id){
			$query = $this->db->query("
				SELECT users.fullname, illness_comments.* FROM illness_comments
				JOIN users on illness_comments.user_id = users.id
				WHERE illness_comments.iln_id =".$iln_id);
			return $query->result_array();
  		}

  		function update_iln($data, $iln_id) {
			$this->load->database();
			$this->db->where('illness.id', $iln_id);		
			$this->db->update('illness', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function update_guest($data, $iln_id, $id) {
			$this->load->database();
			$this->db->where('illness_guest.iln_id', $iln_id);	
			$this->db->where('illness_guest.id', $id);		
			$this->db->update('illness_guest', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function get_signature_identity($sign_id){
  			$this->load->database();
			$query = $this->db->query('SELECT illness.hotel_id, illness_signature.iln_id FROM illness_signature JOIN illness ON illness_signature.iln_id = illness.id WHERE illness_signature.id ='.$sign_id);
  			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  		}

  		function unsign($id){
	  		$this->load->database();
			$query = $this->db->query('UPDATE illness_signature SET user_id = NULL, reject = 0 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
	  	}

	  	function reject($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE illness_signature SET user_id = '.$uid.', reject = 1 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function sign($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE illness_signature SET user_id = '.$uid.' WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function insert_comment($data){
			$this->db->insert('illness_comments', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

	}

?>