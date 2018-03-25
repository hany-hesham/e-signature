<?php

	class gate_model extends CI_Model{

  		function __contruct(){
			parent::__construct;
		}

		function view($user_hotels = FALSE, $state = FALSE) {
  	  		$this->load->database();
			$this->db->select('gate.id, gate.date, gate.hotel_id, gate.name, gate.department_id, gate.position, hotels.name as hotel_name, departments.name as department');
			$this->db->join('hotels', 'gate.hotel_id = hotels.id','left');
			$this->db->join('departments', 'gate.department_id = departments.id','left');
        	if ($user_hotels) {
          		$this->db->where_in('gate.hotel_id', $user_hotels);
        	}
        	if ($state) {
				$this->db->where('gate.state_id', $state);	
			}else{
				$this->db->where('gate.state_id !=', 0);
			}
        	$this->db->order_by('timestamp', 'DESC');
			$query = $this->db->get('gate');
			return $query->result_array();
		}

		function get_by_verbals($gate_id){
	    	$this->load->database();
			$this->db->select('gate_signature.role_id, gate_signature.rank, gate_signature.department_id, gate_signature.user_id, gate_signature.reject, roles.role, departments.name as department, users.fullname as user_name');
			$this->db->join('roles', 'gate_signature.role_id = roles.id', 'left');
			$this->db->join('departments', 'gate_signature.department_id = departments.id', 'left');
			$this->db->join('users', 'gate_signature.user_id = users.id', 'left');
			$this->db->where('gate_id', $gate_id);
        	$this->db->order_by('gate_signature.rank');
			$query = $this->db->get('gate_signature');
			return $query->result_array();
  		}

		function create_gate($data) {
			$this->load->database();
			$this->db->insert('gate', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function update_files($assumed_id, $gate_id) {
  			$this->load->database();
  			$this->db->query('UPDATE gate_filles SET gate_id = "'.$gate_id.'" WHERE gate_id = "'.$assumed_id.'"');
  		}

  		function create_item($data) {
			$this->load->database();
			$this->db->insert('gate_items', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function gate_sign (){
  			$this->load->database();
			$this->db->select('gate_role.*');
			$query = $this->db->get('gate_role');
			return $query->result_array();  	
		}

		function gate_do_sign($gate_id){
  	 		$this->load->database();
			$this->db->select('gate_signature.*');
			$this->db->where('gate_signature.gate_id', $gate_id);	
        	$this->db->order_by('gate_signature.rank');
			$query = $this->db->get('gate_signature');
			return $query->num_rows();  	
		}

		function add_signature($gate_id, $role_id, $department_id,  $rank){
	    	$this->load->database();
			$query = $this->db->query('INSERT INTO gate_signature(gate_id, role_id, department_id, rank) VALUES("'.$gate_id.'", "'.$role_id.'", "'.$department_id.'", "'.$rank.'")');
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
  		}

  		function get_departments(){
	    	$this->load->database();
			$this->db->select('departments.*');
        	$this->db->order_by('name');
			$query = $this->db->get('departments');
			return $query->result_array();
  		}

  		function get_by_fille($gate_id){
	    	$this->load->database();
			$this->db->select('gate_filles.*, users.fullname as user_name');
			$this->db->join('users', 'gate_filles.user_id = users.id','left');
			$this->db->where('gate_id', $gate_id);
			$query = $this->db->get('gate_filles');
			return $query->result_array();
  		}

  		function get_gate($gate_id) {
			$this->db->select('gate.*, hotels.name as hotel_name, hotels.logo As logo, users.fullname as user_name, departments.name as department');
			$this->db->join('hotels', 'gate.hotel_id = hotels.id','left');
			$this->db->join('users', 'gate.user_id = users.id','left');
			$this->db->join('departments', 'gate.department_id = departments.id', 'left');
			$this->db->where('gate.id', $gate_id);		
			$query = $this->db->get('gate');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
		}

		function update_state($gate_id, $state) {
			$this->db->update('gate', array('state_id'=> $state), "id = ".$gate_id);
		}

		function get_by_verbal($gate_id){
	    	$this->load->database();
			$this->db->select('gate_signature.*, roles.role, departments.name as department, users.fullname as user_name');
			$this->db->join('roles', 'gate_signature.role_id = roles.id', 'left');
			$this->db->join('departments', 'gate_signature.department_id = departments.id', 'left');
			$this->db->join('users', 'gate_signature.user_id = users.id', 'left');
			$this->db->where('gate_id', $gate_id);
        	$this->db->order_by('gate_signature.rank');
			$query = $this->db->get('gate_signature');
			return $query->result_array();
  		}

  		function get_items($gate_id) {
			$this->db->select('gate_items.*, users.fullname as user_name');
			$this->db->join('users', 'gate_items.user_id = users.id','left');
			$this->db->where('gate_items.gate_id', $gate_id);
			$query = $this->db->get('gate_items');
			return ($query->num_rows() > 0 )? $query->result_array() : FALSE;
		}

		function get_comment($gate_id){
			$query = $this->db->query("
				SELECT users.fullname, gate_comments.comment, gate_comments.timestamp FROM gate_comments
				JOIN users on gate_comments.user_id = users.id
				WHERE gate_comments.gate_id =".$gate_id
			);
			return $query->result_array();
  		}

  		function add_fille($gate_id, $name, $user_id) {
	  		$this->load->database();
	  		$this->db->query('INSERT INTO gate_filles(gate_id, name, user_id) VALUES("'.$gate_id.'","'.$name.'","'.$user_id.'")');
	  	}

	  	function remove_fille($id) {
	      $this->load->database();
	      $this->db->query('DELETE FROM gate_filles WHERE id = '.$id);
	    }

	    function update_gate($gate_id, $data) {
			$this->load->database();
			$this->db->where('gate.id', $gate_id);		
			$this->db->update('gate', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function update_item($id, $gate_id, $data) {
			$this->load->database();
			$this->db->where('gate_items.gate_id', $gate_id);	
			$this->db->where('gate_items.id', $id);		
			$this->db->update('gate_items', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function get_signature_identity($sign_id){
  			$this->load->database();
			$query = $this->db->query('SELECT gate.hotel_id, gate_signature.gate_id FROM gate_signature JOIN gate ON gate_signature.gate_id = gate.id WHERE gate_signature.id ='.$sign_id);
  			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  		}

  		function unsign($id){
	  		$this->load->database();
			$query = $this->db->query('UPDATE gate_signature SET user_id = NULL, reject = 0 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
	  	}

	  	function reject($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE gate_signature SET user_id = '.$uid.', reject = 1 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function sign($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE gate_signature SET user_id = '.$uid.' WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function insert_comment($data){
			$this->db->insert('gate_comments', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

	}

?>