<?php

	class discrepancy_model extends CI_Model{
	
  		function __contruct(){
			parent::__construct;
		}

		function update_files($assumed_id, $dcy_id) {
  			$this->load->database();
  			$this->db->query('UPDATE discrepancy_filles SET dcy_id = "'.$dcy_id.'" WHERE dcy_id = "'.$assumed_id.'"');
  		}

  		function getby_fille($dcy_id){
	    	$this->load->database();
			$this->db->where('dcy_id', $dcy_id);
			$query = $this->db->get('discrepancy_filles');
			return $query->result_array();
  		}

  		function add($dcy_id, $name) {
	  		$this->load->database();
	  		$this->db->query('INSERT INTO discrepancy_filles(dcy_id,name) VALUES("'.$dcy_id.'","'.$name.'")');
	  	}

	  	function remove($id) {
	      $this->load->database();
	      $this->db->query('DELETE FROM discrepancy_filles WHERE id = '.$id);
	    }

		function create_discrepancy($data) {
			$this->load->database();
			$this->db->insert('discrepancy', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function create_room($data) {
			$this->db->insert('discrepancy_room', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function dcy_sign ($type){
  			$this->load->database();
			$this->db->select('discrepancy_role.*');
			$this->db->where('type', $type);		
			$query = $this->db->get('discrepancy_role');
			return $query->result_array();  	
		}

		function dcy_do_sign($dcy_id){
  	 		$this->load->database();
			$this->db->select('discrepancy_signature.*');
			$this->db->where('discrepancy_signature.dcy_id', $dcy_id);		
			$query = $this->db->get('discrepancy_signature');
			return $query->num_rows();  	
		}

		function add_signature($dcy_id, $role_id, $department_id, $rank){
	    	$this->load->database();
			$query = $this->db->query('INSERT INTO discrepancy_signature(dcy_id, role_id, department_id, rank) VALUES("'.$dcy_id.'", "'.$role_id.'", "'.$department_id.'", "'.$rank.'")');
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
  		}

  		function get_discrepancy($dcy_id) {
			$this->db->select('discrepancy.*, hotels.name as hotel_name, hotels.logo As logo, users.fullname as name');
			$this->db->join('hotels', 'discrepancy.hotel_id = hotels.id','left');
			$this->db->join('users', 'discrepancy.user_id = users.id','left');
			$this->db->where('discrepancy.id', $dcy_id);		
			$query = $this->db->get('discrepancy');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
		}

		function get_discrepancy_room($dcy_id) {
        	$this->load->database();
			$this->db->where('discrepancy_room.dcy_id', $dcy_id);
			$query = $this->db->get('discrepancy_room');
			return ($query->num_rows() > 0 )? $query->result_array() : FALSE;
		}

		function get_comment($dcy_id){
			$query = $this->db->query("
				SELECT users.fullname, discrepancy_comments.comment, discrepancy_comments.created FROM discrepancy_comments
				JOIN users on discrepancy_comments.user_id = users.id
				WHERE discrepancy_comments.dcy_id =".$dcy_id);
			return $query->result_array();
  		}

  		function update_discrepancy($data, $dcy_id) {
			$this->load->database();
			$this->db->where('discrepancy.id', $dcy_id);		
			$this->db->update('discrepancy', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function update_room($data, $dcy_id, $item_id) {
			$this->load->database();
			$this->db->where('discrepancy_room.dcy_id', $dcy_id);	
			$this->db->where('discrepancy_room.id', $item_id);		
			$this->db->update('discrepancy_room', $data);
			$query = $this->db->get('discrepancy_room');
			return $query;
		}

		function insert_comment($data){
			$this->db->insert('discrepancy_comments', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function view($user_hotels = FALSE) {
  	  		$this->load->database();
			$this->db->select('users.id as userid,users.*,discrepancy.*, hotels.name as hotel_name');
			$this->db->join('users', 'discrepancy.user_id = users.id','left');
			$this->db->join('hotels', 'discrepancy.hotel_id = hotels.id','left');
        	if ($user_hotels) {
          		$this->db->where_in('discrepancy.hotel_id', $user_hotels);
        	}
        	$this->db->order_by('timestamp', 'DESC');
			$query = $this->db->get('discrepancy');
			return $query->result_array();
		}

		function getby_verbal($dcy_id){
	    	$this->load->database();
			$this->db->select('discrepancy_signature.*, roles.role, departments.name as department');
			$this->db->join('roles', 'discrepancy_signature.role_id = roles.id', 'left');
			$this->db->join('departments', 'discrepancy_signature.department_id = departments.id', 'left');
			$this->db->where('dcy_id', $dcy_id);
			$this->db->order_by('rank');
			$query = $this->db->get('discrepancy_signature');
			return $query->result_array();
  		}

  		function update_state($dcy_id, $state) {
			$this->db->update('discrepancy', array('state_id'=> $state), "id = ".$dcy_id);
		}

		function get_signature_identity($sign_id){
  			$this->load->database();
			$query = $this->db->query('SELECT discrepancy.hotel_id, discrepancy_signature.dcy_id FROM discrepancy_signature JOIN discrepancy ON discrepancy_signature.dcy_id = discrepancy.id WHERE discrepancy_signature.id ='.$sign_id);
  			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  		}

  		function reject($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE discrepancy_signature SET user_id = '.$uid.', reject = 1 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function sign($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE discrepancy_signature SET user_id = '.$uid.' WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function unsign($id){
	  		$this->load->database();
			$query = $this->db->query('UPDATE discrepancy_signature SET user_id = NULL, reject = 0 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
	  	}

	  	function self_sign($dcy_id, $user_id){
	    	$this->load->database();
			$query = $this->db->query('UPDATE discrepancy_signature SET user_id = '.$user_id.' WHERE dcy_id = '.$dcy_id.' AND role_id = 0');
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

	}