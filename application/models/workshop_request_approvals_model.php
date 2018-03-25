<?php

class Workshop_request_approvals_model extends MY_Model{
	
  	function __contruct(){
		parent::__construct;
		// $this->load->helper('url');
  	}
	
  	function getall(){
	    $this->load->database();
		
		$query = $this->db->get('workshop_request_approvals');
		return $query->result_array();
  	}

  	function getby_approvals_verbal($request_id){
	    $this->load->database();
		
		$this->db->select('workshop_request_approvals.id, user_id, role_id, timestamp, rank, roles.role, reject');
		$this->db->join('roles', 'role_id = roles.id', 'left');

		$this->db->where('request_id', $request_id);
		$this->db->order_by('rank');
		$query = $this->db->get('workshop_request_approvals');

		return $query->result_array();
  	}

	function getby_request_approved($request_id){
	    $this->load->database();
		
		$this->db->select('users.email');
		$this->db->join('users', 'user_id = users.id');

		$this->db->where('request_id', $request_id);
		$query = $this->db->get('workshop_request_approvals');

		return $query->result_array();
  	}

  	function getby_request($request_id){
	    $this->load->database();
	
		$this->db->where('request_id', $request_id);
		$this->db->order_by('rank');
		$query = $this->db->get('workshop_request_approvals');

		return $query->result_array();
  	}

  	function add_request_approval($request_id, $role_id, $rank){
	    $this->load->database();
		$query = $this->db->query('INSERT INTO workshop_request_approvals(request_id, role_id, rank) VALUES("'.$request_id.'", "'.$role_id.'", "'.$rank.'")');

		return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
  	}

  	function reset_request($request_id){
	    $this->load->database();
		$query = $this->db->query('DELETE FROM workshop_request_approvals WHERE request_id = "'.$request_id.'"');

		return TRUE;
  	}

  	function self_approve($request_id, $user_id){
	    $this->load->database();
		$query = $this->db->query('UPDATE workshop_request_approvals SET user_id = '.$user_id.' WHERE request_id = '.$request_id.' AND role_id = 0');

		return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  	}

  	function get_approval_identity($id){
  		$this->load->database();
		$query = $this->db->query('SELECT workshop_request_approvals.request_id, workshop_requests.hotel_id FROM workshop_request_approvals JOIN workshop_requests ON workshop_request_approvals.request_id = workshop_requests.id WHERE workshop_request_approvals.id ='.$id);
  		return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  	}

  	function approve($id, $uid){
  		$this->load->database();
		$query = $this->db->query('UPDATE workshop_request_approvals SET user_id = '.$uid.' WHERE id = '.$id);

		return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  	}

  	function disapprove($id, $uid){
  		$this->load->database();
		$query = $this->db->query('UPDATE workshop_request_approvals SET user_id = '.$uid.', reject = 1 WHERE id = '.$id);

		return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  	}

  	function unsign($id){
  		$this->load->database();
		$query = $this->db->query('UPDATE workshop_request_approvals SET user_id = NULL, reject = 0 WHERE id = '.$id);

		return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  	}
  	
  	function sign($id, $uid){
  		$this->load->database();
		$query = $this->db->query('UPDATE workshop_request_approvals SET user_id = '.$uid.' WHERE id = '.$id);

		return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  	}

}
?>
