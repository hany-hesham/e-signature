<?php

class spo_signatures_model extends MY_Model{
	
  	function __contruct(){
		parent::__construct;
		// $this->load->helper('url');
  	}

  	function get_sign($spo_id){
	    $query = $this->db->query("
			SELECT signature_spo.forma_spo_id, signature_spo.role, signature_spo.user_id, signature_spo.reject, users.id as uid , users.fullname as name, roles.id as rid, roles.role as position
			FROM signature_spo
            JOIN roles on signature_spo.role = roles.id
            JOIN users on signature_spo.user_id = users.id
        	WHERE signature_spo.forma_spo_id =". $spo_id);
		return $query->result_array();	
	}

	/*function get_spo_approve($spo_id){
		$query = $this->db->query("
			SELECT 
			")



	}
	*/
  	/*function getall(){
	    $this->load->database();
		
		$query = $this->db->get('signature_spo');
		return $query->result_array();
  	}

  	function getby_request_verbal($spo_id){
	    $this->load->database();
		
		$this->db->select('spo.id, user_id, role_id, dt, rank, roles.role, reject');
		$this->db->join('roles', 'role_id = roles.id', 'left');

		$this->db->where('spo_id', $spo_id);
		$this->db->order_by('rank');
		$query = $this->db->get('signature_spo');

		return $query->result_array();
  	}


  	function get_spo_verbal($spo_id){
  	$query = $this->db->query("
									SELECT signature_spo.user_id, users.id, users.fullname as user, signature_spo.role, roles.role as position, signature_spo.forma_spo_id, signature_spo.reject  
									FROM signature_spo
									JOIN roles on signature_spo.role = roles.role
									JOIN users on signature_spo.user_id = users.id
									WHERE signature_spo.forma_spo_id =".$spo_id);
			return $query->result_array();
  	}

	function get_spo_approved($spo_id){
	    $this->load->database();
		
		$this->db->select('users.email');
		$this->db->join('users', 'user_id = users.id');

		$this->db->where('forma_spo_id', $spo_id);
		$query = $this->db->get('signature_spo');

		return $query->result_array();
  	}

  	function get_spo($spo_id){
	    $this->load->database();
		$this->db->where('forma_spo_id', $spo_id);
		$this->db->order_by('rank');
		$query = $this->db->get('signature_spo');

		return $query->result_array();
  	}

  	function add_spo_signature($spo_id, $role, $rank){
	    $this->load->database();
		$query = $this->db->query('INSERT INTO signature_spo(forma_spo_id, role, rank) VALUES("'.$spo_id.'", "'.$role.'", "'.$rank.'")');

		return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
  	}

  	function reset_spo($forma_spo_id){
	    $this->load->database();
		$query = $this->db->query('DELETE FROM signature_spo WHERE forma_spo_id = "'.$forma_spo_id.'"');

		return TRUE;
  	}

  	function self_approve($forma_spo_id, $user_id){
	    $this->load->database();
		$query = $this->db->query('UPDATE signature_spo SET user_id = '.$user_id.' WHERE forma_spo_id = '.$forma_spo_id.' AND role = 0');

		return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  	}

  	function get_signature_identity($id){



	  	$this->load->database();
		$query = $this->db->query('SELECT signature_spo.forma_spo_id, spo.hotel_id FROM signature_spo JOIN spo ON signature_spo.forma_spo_id = spo.id WHERE signature_spo.id ='.$id);
  		return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  	}

  	function approve($id, $usrid){
  		$this->load->database();
		$query = $this->db->query('UPDATE signature_spo SET user_id = '.$usrid.' WHERE id = '.$id);

		return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  	}

  	function disapprove($id, $usrid){
  		$this->load->database();
		$query = $this->db->query('UPDATE signature_spo SET user_id = '.$usrid.', reject = 1 WHERE id = '.$id);

		return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  	}
  	function sign($id, $usrid){
  		$this->load->database();
		$query = $this->db->query('UPDATE signature_spo SET user_id = '.$usrid.' WHERE id = '.$id);

		return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  	}


  	function reject($id, $usrid){
  		$this->load->database();
		$query = $this->db->query('UPDATE signature_spo SET user_id = '.$usrid.', reject = 1 WHERE id = '.$id);

		return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  	}

  	function unsign($id){
  		$this->load->database();
		$query = $this->db->query('UPDATE signature_spo SET user_id = NULL, reject = 0 WHERE id = '.$id);

		return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  	}
*/
}
?>
