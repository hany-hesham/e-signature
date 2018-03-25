<?php

	class out_service_model extends CI_Model{

  		function __contruct(){
			parent::__construct;
		}

		function view($user_hotels = FALSE, $state = FALSE) {
  	  		$this->load->database();
			$this->db->select('out_service.id, out_service.user_id, out_service.hotel_id, out_service.serial, out_service.department_id, out_service.date, out_service.state_id, out_service.timestamp, hotels.name as hotel_name, users.fullname as name, departments.name as department, out_service_states.name as state');
			$this->db->join('hotels', 'out_service.hotel_id = hotels.id','left');
			$this->db->join('users', 'out_service.user_id = users.id','left');
			$this->db->join('departments', 'out_service.department_id = departments.id', 'left');
			$this->db->join('out_service_states', 'out_service.state_id = out_service_states.id', 'left');
        	if ($user_hotels) {
          		$this->db->where_in('out_service.hotel_id', $user_hotels);
        	}
        	if ($state && $state > 0) {
				$this->db->where('out_service.state_id', $state);	
			}else{
				$this->db->where('out_service.state_id !=', 0);
			}
        	$this->db->order_by('timestamp', 'DESC');
			$query = $this->db->get('out_service');
			return $query->result_array();
		}

		function get_by_verbals($out_id){
	    	$this->load->database();
			$this->db->select('out_service_signature.role_id, out_service_signature.rank, out_service_signature.department_id, out_service_signature.user_id, out_service_signature.reject, roles.role, departments.name as department, users.fullname as user_name');
			$this->db->join('roles', 'out_service_signature.role_id = roles.id', 'left');
			$this->db->join('departments', 'out_service_signature.department_id = departments.id', 'left');
			$this->db->join('users', 'out_service_signature.user_id = users.id', 'left');
			$this->db->where('out_id', $out_id);
        	$this->db->order_by('out_service_signature.rank');
			$query = $this->db->get('out_service_signature');
			return $query->result_array();
  		}

  		function get_states(){
	    	$this->load->database();
			$this->db->select('out_service_states.*');
			$x = array('0' => 2, '1' => 3);
			$this->db->where_not_in('out_service_states.id', $x);
			$query = $this->db->get('out_service_states');
			return $query->result_array();
  		}

		function get_out_service_by_serial($code) {
			$this->db->select('out_service.*, hotels.name as hotel_name, hotels.logo As logo, users.fullname as name, departments.name as department, out_service_states.name as state, out_service_reasons.name as reason_name, sister_hotels.name as sister_name');
			$this->db->join('hotels', 'out_service.hotel_id = hotels.id','left');
			$this->db->join('out_service_reasons', 'out_service.reason = out_service_reasons.id','left');
			$this->db->join('hotels as sister_hotels', 'out_service.sister_id = hotels.id','left');
			$this->db->join('users', 'out_service.user_id = users.id','left');
			$this->db->join('departments', 'out_service.department_id = departments.id', 'left');
			$this->db->join('out_service_states', 'out_service.state_id = out_service_states.id', 'left');
			$this->db->where('out_service.serial', $code);		
			$query = $this->db->get('out_service');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
		}

		function create_out_service($data) {
			$this->load->database();
			$this->db->insert('out_service', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function update_files($assumed_id, $out_id) {
  			$this->load->database();
  			$this->db->query('UPDATE out_service_filles SET out_id = "'.$out_id.'" WHERE out_id = "'.$assumed_id.'"');
  		}

  		function create_item($data) {
			$this->load->database();
			$this->db->insert('out_service_items', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function out_sign (){
  			$this->load->database();
			$this->db->select('out_service_role.*');
			$query = $this->db->get('out_service_role');
			return $query->result_array();  	
		}

		function out_do_sign($out_id){
  	 		$this->load->database();
			$this->db->select('out_service_signature.*');
			$this->db->where('out_service_signature.out_id', $out_id);		
			$query = $this->db->get('out_service_signature');
			return $query->num_rows();  	
		}

		function add_signature($out_id, $role_id, $department_id,  $rank){
	    	$this->load->database();
			$query = $this->db->query('INSERT INTO out_service_signature(out_id, role_id, department_id, rank) VALUES("'.$out_id.'", "'.$role_id.'", "'.$department_id.'", "'.$rank.'")');
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
  		}

  		function get_reasons(){
	    	$this->load->database();
			$this->db->select('out_service_reasons.*');
        	$this->db->order_by('name');
			$query = $this->db->get('out_service_reasons');
			return $query->result_array();
  		}

  		function get_by_fille($out_id){
	    	$this->load->database();
			$this->db->select('out_service_filles.*, users.fullname as user_name');
			$this->db->join('users', 'out_service_filles.user_id = users.id','left');
			$this->db->where('out_id', $out_id);
			$query = $this->db->get('out_service_filles');
			return $query->result_array();
  		}

  		function add_fille($out_id, $name, $user_id) {
	  		$this->load->database();
	  		$this->db->query('INSERT INTO out_service_filles(out_id, name, user_id) VALUES("'.$out_id.'","'.$name.'","'.$user_id.'")');
	  	}

	  	function remove_fille($id) {
	      $this->load->database();
	      $this->db->query('DELETE FROM out_service_filles WHERE id = '.$id);
	    }

	    function get_out_service_by_id($out_id) {
			$this->db->select('out_service.*, hotels.name as hotel_name, hotels.logo As logo, users.fullname as name, departments.name as department, out_service_states.name as state, out_service_reasons.name as reason_name, sister_hotels.name as sister_name');
			$this->db->join('hotels', 'out_service.hotel_id = hotels.id','left');
			$this->db->join('out_service_reasons', 'out_service.reason = out_service_reasons.id','left');
			$this->db->join('hotels AS sister_hotels','out_service.sister_id = sister_hotels.id','left');
			$this->db->join('users', 'out_service.user_id = users.id','left');
			$this->db->join('departments', 'out_service.department_id = departments.id', 'left');
			$this->db->join('out_service_states', 'out_service.state_id = out_service_states.id', 'left');
			$this->db->where('out_service.id', $out_id);		
			$query = $this->db->get('out_service');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
		}

		function update_state($out_id, $state) {
			$this->db->update('out_service', array('state_id'=> $state), "id = ".$out_id);
		}

		function get_by_verbal($out_id){
	    	$this->load->database();
			$this->db->select('out_service_signature.*, roles.role, departments.name as department, users.fullname as user_name');
			$this->db->join('roles', 'out_service_signature.role_id = roles.id', 'left');
			$this->db->join('departments', 'out_service_signature.department_id = departments.id', 'left');
			$this->db->join('users', 'out_service_signature.user_id = users.id', 'left');
        	$this->db->order_by('rank');
			$this->db->where('out_id', $out_id);
			$query = $this->db->get('out_service_signature');
			return $query->result_array();
  		}

  		function get_items($out_id) {
			$this->db->select('out_service_items.*, users.fullname as user_name');
			$this->db->join('users', 'out_service_items.user_id = users.id','left');
			$this->db->where('out_service_items.out_id', $out_id);
			$query = $this->db->get('out_service_items');
			return ($query->num_rows() > 0 )? $query->result_array() : FALSE;
		}

		function get_comment($out_id){
			$query = $this->db->query("
				SELECT users.fullname, out_service_comments.comment, out_service_comments.timestamp FROM out_service_comments
				JOIN users on out_service_comments.user_id = users.id
				WHERE out_service_comments.out_id =".$out_id
			);
			return $query->result_array();
  		}

  		function update_out_service($out_id, $data) {
			$this->load->database();
			$this->db->where('out_service.id', $out_id);		
			$this->db->update('out_service', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function update_item($id, $out_id, $data) {
			$this->load->database();
			$this->db->where('out_service_items.out_id', $out_id);	
			$this->db->where('out_service_items.id', $id);		
			$this->db->update('out_service_items', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function get_signature_identity($sign_id){
  			$this->load->database();
			$query = $this->db->query('SELECT out_service.hotel_id, out_service_signature.out_id FROM out_service_signature JOIN out_service ON out_service_signature.out_id = out_service.id WHERE out_service_signature.id ='.$sign_id);
  			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  		}

  		function unsign($id){
	  		$this->load->database();
			$query = $this->db->query('UPDATE out_service_signature SET user_id = NULL, reject = 0 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
	  	}

	  	function reject($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE out_service_signature SET user_id = '.$uid.', reject = 1 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function sign($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE out_service_signature SET user_id = '.$uid.' WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function insert_comment($data){
			$this->db->insert('out_service_comments', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

	}

?>