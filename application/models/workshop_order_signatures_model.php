<?php

class Workshop_order_signatures_model extends MY_Model{
	
  	function __contruct(){
		parent::__construct;
		// $this->load->helper('url');
  	}
	
  	function getall(){
	    $this->load->database();
		
		$query = $this->db->get('workshop_order_signatures');
		return $query->result_array();
  	}

  	function getby_order_verbal($order_id){
	    $this->load->database();
		
		$this->db->select('workshop_order_signatures.id, user_id, role_id, timestamp, rank, roles.role, reject');
		$this->db->join('roles', 'role_id = roles.id', 'left');

		$this->db->where('order_id', $order_id);
		$this->db->order_by('rank');
		$query = $this->db->get('workshop_order_signatures');

		return $query->result_array();
  	}

	function getby_order_approved($order_id){
	    $this->load->database();
		
		$this->db->select('users.email');
		$this->db->join('users', 'user_id = users.id');

		$this->db->where('order_id', $order_id);
		$query = $this->db->get('workshop_order_signatures');

		return $query->result_array();
  	}

  	function getby_order($order_id){
	    $this->load->database();
	
		$this->db->where('order_id', $order_id);
		$this->db->order_by('rank');
		$query = $this->db->get('workshop_order_signatures');

		return $query->result_array();
  	}

  	function add_order_signature($order_id, $role_id, $rank){
	    $this->load->database();
		$query = $this->db->query('INSERT INTO workshop_order_signatures(order_id, role_id, rank) VALUES("'.$order_id.'", "'.$role_id.'", "'.$rank.'")');

		return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
  	}

  	function reset_order($order_id){
	    $this->load->database();
		$query = $this->db->query('DELETE FROM workshop_order_signatures WHERE order_id = "'.$order_id.'"');

		return TRUE;
  	}

  	function self_approve($order_id, $user_id){
	    $this->load->database();
		$query = $this->db->query('UPDATE workshop_order_signatures SET user_id = '.$user_id.' WHERE order_id = '.$order_id.' AND role_id = 0');

		return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  	}

  	function get_signature_identity($id){

  		$this->load->database();
  		$this->db->select('workshop_order_signatures.order_id, workshop_order_signatures.id, workshop_orders.id, workshop_requests.id, workshop_requests.hotel_id');
		$this->db->join('workshop_orders', 'workshop_orders.id = workshop_order_signatures.order_id', 'left');
		$this->db->join('workshop_requests','workshop_orders.request_id = workshop_requests.id', 'left');
		$this->db->where('workshop_order_signatures.id', $id);

		$query = $this->db->get('workshop_order_signatures');

  		return ($query->num_rows() > 0 )? $query->row_array() : FALSE;


/*  		$this->load->database();
		$query = $this->db->query('SELECT workshop_order_signatures.order_id, workshop_requests.hotel_id FROM workshop_order_signatures JOIN workshop_requests ON workshop_order_signatures.order_id = workshop_requests.id WHERE workshop_order_signatures.id ='.$id);
  		return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
*/  	}

  	function approve($id, $uid){
  		$this->load->database();
		$query = $this->db->query('UPDATE workshop_order_signatures SET user_id = '.$uid.' WHERE id = '.$id);

		return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  	}

  	function disapprove($id, $uid){
  		$this->load->database();
		$query = $this->db->query('UPDATE workshop_order_signatures SET user_id = '.$uid.', reject = 1 WHERE id = '.$id);

		return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  	}
  	function sign($id, $uid){
  		$this->load->database();
		$query = $this->db->query('UPDATE workshop_order_signatures SET user_id = '.$uid.' WHERE id = '.$id);

		return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  	}


  	function reject($id, $uid){
  		$this->load->database();
		$query = $this->db->query('UPDATE workshop_order_signatures SET user_id = '.$uid.', reject = 1 WHERE id = '.$id);

		return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  	}

  	function unsign($id){
  		$this->load->database();
		$query = $this->db->query('UPDATE workshop_order_signatures SET user_id = NULL, reject = 0 WHERE id = '.$id);

		return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  	}

}
?>
