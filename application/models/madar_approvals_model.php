<?php

class Madar_approvals_model extends MY_Model{
	
  	function __contruct(){
		parent::__construct;
		// $this->load->helper('url');
  	}
	
  	function getall(){
	    $this->load->database();
		
		$query = $this->db->get('madar_approvals');
		return $query->result_array();
  	}

  	function getby_project_verbal($project_id){
	    $this->load->database();
		
		$this->db->select('madar_approvals.id, user_id, role_id, timestamp, rank, roles.role, reject');
		$this->db->join('roles', 'role_id = roles.id', 'left');

		$this->db->where('project_id', $project_id);
		$this->db->order_by('rank');
		$query = $this->db->get('madar_approvals');

		return $query->result_array();
  	}

	function getby_project_approved($project_id){
	    $this->load->database();
		
		$this->db->select('users.email');
		$this->db->join('users', 'user_id = users.id');

		$this->db->where('project_id', $project_id);
		$query = $this->db->get('madar_approvals');

		return $query->result_array();
  	}

  	function getby_project($project_id){
	    $this->load->database();
	
		$this->db->where('project_id', $project_id);
		$this->db->order_by('rank');
		$query = $this->db->get('madar_approvals');

		return $query->result_array();
  	}

  	function project_do_sign($project_id){
  	 	$this->load->database();
		$this->db->select('madar_approvals.*');
		$this->db->where('madar_approvals.project_id', $project_id);		
		$query = $this->db->get('madar_approvals');
		return $query->num_rows();  	
	}

  	function add_project_approval($project_id, $role_id, $rank){
	    $this->load->database();
		$query = $this->db->query('INSERT INTO madar_approvals(project_id, role_id, rank) VALUES("'.$project_id.'", "'.$role_id.'", "'.$rank.'")');

		return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
  	}

/*  	function reset_project($project_id){
	    $this->load->database();
		$query = $this->db->query('DELETE FROM project_approvals WHERE project_id = "'.$project_id.'"');

		return TRUE;
  	}
*/
/*  	function self_approve($project_id, $user_id){
	    $this->load->database();
		$query = $this->db->query('UPDATE project_approvals SET user_id = '.$user_id.' WHERE project_id = '.$project_id.' AND role_id = 0');

		return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  	}
*/
  	function get_approval_identity($id){
  		$this->load->database();
		$query = $this->db->query('SELECT madar_approvals.project_id, madar.hotel_id FROM madar_approvals JOIN madar ON madar_approvals.project_id = madar.id WHERE madar_approvals.id ='.$id);
  		return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  	}

  	function approve($id, $uid){
  		$this->load->database();
		$query = $this->db->query('UPDATE madar_approvals SET user_id = '.$uid.' WHERE id = '.$id);

		return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  	}

  	function disapprove($id, $uid){
  		$this->load->database();
		$query = $this->db->query('UPDATE madar_approvals SET user_id = '.$uid.', reject = 1 WHERE id = '.$id);

		return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  	}

  	function unsign($id){
  		$this->load->database();
		$query = $this->db->query('UPDATE madar_approvals SET user_id = NULL, reject = 0 WHERE id = '.$id);

		return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  	}

}
?>
