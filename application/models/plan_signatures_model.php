<?php

class Plan_signatures_model extends MY_Model{
	
  	function __contruct(){
		parent::__construct;
		// $this->load->helper('url');
  	}
	
  	function getall(){
	    $this->load->database();
		
		$query = $this->db->get('plan_signatures');
		return $query->result_array();
  	}

  	function getby_plan_verbal($plan_id){
	    $this->load->database();
		
		$this->db->select('plan_signatures.id, user_id, role_id, timestamp, rank, roles.role, reject');
		$this->db->join('roles', 'role_id = roles.id', 'left');

		$this->db->where('plan_id', $plan_id);
		$this->db->order_by('rank');
		$query = $this->db->get('plan_signatures');

		return $query->result_array();
  	}

  	function getby_plan_major_verbal($plan_id){
	    $this->load->database();
		
		$this->db->select('plan_major_signatures.id, user_id, role_id, timestamp, rank, roles.role, reject');
		$this->db->join('roles', 'role_id = roles.id', 'left');

		$this->db->where('plan_id', $plan_id);
		$this->db->order_by('rank');
		$query = $this->db->get('plan_major_signatures');

		return $query->result_array();
  	}

	function getby_plan_approved($plan_id){
	    $this->load->database();
		
		$this->db->select('users.email');
		$this->db->join('users', 'user_id = users.id');

		$this->db->where('plan_id', $plan_id);
		$query = $this->db->get('plan_signatures');

		return $query->result_array();
  	}

  	function getby_plan($plan_id){
	    $this->load->database();
	
		$this->db->where('plan_id', $plan_id);
		$this->db->order_by('rank');
		$query = $this->db->get('plan_signatures');

		return $query->result_array();
  	}

  	function add_plan_signature($plan_id, $role_id, $rank){
	    $this->load->database();
		$query = $this->db->query('INSERT INTO plan_signatures(plan_id, role_id, rank) VALUES("'.$plan_id.'", "'.$role_id.'", "'.$rank.'")');

		return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
  	}

  	function add_plan_major_signature($plan_id, $role_id, $rank){
	    $this->load->database();
		$query = $this->db->query('INSERT INTO plan_major_signatures(plan_id, role_id, rank) VALUES("'.$plan_id.'", "'.$role_id.'", "'.$rank.'")');

		return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
  	}

  	function reset_plan($plan_id){
	    $this->load->database();
		$query = $this->db->query('DELETE FROM plan_signatures WHERE plan_id = "'.$plan_id.'"');

		return TRUE;
  	}

  	function self_approve($plan_id, $user_id){
	    $this->load->database();
		$query = $this->db->query('UPDATE plan_signatures SET user_id = '.$user_id.' WHERE plan_id = '.$plan_id.' AND role_id = 0');

		return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  	}

  	function get_signature_identity($id){
  		$this->load->database();
		$query = $this->db->query('SELECT plan_signatures.plan_id, plan_signatures.role_id, plans.hotel_id FROM plan_signatures JOIN plans ON plan_signatures.plan_id = plans.id WHERE plan_signatures.id ='.$id);
  		return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  	}

  	function get_major_signature_identity($id){
  		$this->load->database();
		$query = $this->db->query('SELECT plan_major_signatures.plan_id, plan_major_signatures.role_id, plans.hotel_id FROM plan_major_signatures JOIN plans ON plan_major_signatures.plan_id = plans.id WHERE plan_major_signatures.id ='.$id);
  		return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  	}

  	function approve($id, $uid){
  		$this->load->database();
		$query = $this->db->query('UPDATE plan_signatures SET user_id = '.$uid.' WHERE id = '.$id);

		return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  	}

  	function approve_major($id, $uid){
  		$this->load->database();
		$query = $this->db->query('UPDATE plan_major_signatures SET user_id = '.$uid.' WHERE id = '.$id);

		return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  	}

  	function disapprove($id, $uid){
  		$this->load->database();
		$query = $this->db->query('UPDATE plan_signatures SET user_id = '.$uid.', reject = 1 WHERE id = '.$id);

		return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  	}

}
?>
