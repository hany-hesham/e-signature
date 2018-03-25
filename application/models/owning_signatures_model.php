<?php

class Owning_signatures_model extends MY_Model{
	
  	function __contruct(){
		parent::__construct;
		// $this->load->helper('url');
  	}
	
  	function getall(){
	    $this->load->database();
		
		$query = $this->db->get('owning_signatures');
		return $query->result_array();
  	}

  	function getby_owning_verbal($project_id, $type){
	    $this->load->database();
		
		$this->db->select('owning_signatures.id, user_id, role_id, timestamp, rank, roles.role, reject, dead_line, new_dead, delay_reason');
		$this->db->join('roles', 'role_id = roles.id', 'left');

		$this->db->where('project_id', $project_id);
		$this->db->where('type', $type);
		$this->db->order_by('rank');
		$query = $this->db->get('owning_signatures');

		return $query->result_array();
  	}

  	function getby_owning_company_verbal($project_id, $type){
	    $this->load->database();
		
		$this->db->select('company_owning_signature.id, user_id, role_id, timestamp, rank, roles.role, reject, dead_line, new_dead, delay_reason');
		$this->db->join('roles', 'role_id = roles.id', 'left');
		$this->db->where('project_id', $project_id);
		$this->db->where('type', $type);
			$this->db->order_by('rank');
        	$query = $this->db->get('company_owning_signature');

		return $query->result_array();
  	}

  	function getby_own_marina_verbal($project_id, $type){
	    $this->load->database();
		
		$this->db->select('owning_signatures.id, user_id, role_id, timestamp, rank, roles.role, reject');
		$this->db->join('roles', 'role_id = roles.id', 'left');
		$this->db->where('project_id', $project_id);
		$this->db->where('type', $type);
        	$this->db->limit('1');			
        	$query = $this->db->get('owning_signatures');

		return $query->result_array();
  	}

  	function getby_owning_signed($project_id, $type){
	    $this->load->database();
		
		$this->db->select('users.email');
		$this->db->join('users', 'user_id = users.id');

		$this->db->where('project_id', $project_id);
		$this->db->where('type', $type);
		$query = $this->db->get('owning_signatures');

		return $query->result_array();
  	}

  	function getby_project($project_id, $type){
	    $this->load->database();
	
		$this->db->where('project_id', $project_id);
		$this->db->where('type', $type);
		$this->db->order_by('rank');
		$query = $this->db->get('owning_signatures');

		return $query->result_array();
  	}

  	function clear($project_id, $type){
	    $this->load->database();
		$this->db->where('owning_signatures.project_id', $project_id);
		$this->db->where('owning_signatures.type', $type);
		$this->db->delete('owning_signatures');
		return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
  	}

  	function add_owning_signature($project_id, $role_id, $rank, $dead_line, $type){
	    $this->load->database();
		$query = $this->db->query('INSERT INTO owning_signatures(project_id, role_id, rank, dead_line, type) VALUES("'.$project_id.'", "'.$role_id.'", "'.$rank.'", "'.$dead_line.'", "'.$type.'")');

		return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
  	}

  	function add_company_owning_signature($project_id, $role_id, $rank, $dead_line, $type){
	    $this->load->database();
		$query = $this->db->query('INSERT INTO company_owning_signature(project_id, role_id, rank, dead_line, type) VALUES("'.$project_id.'", "'.$role_id.'", "'.$rank.'", "'.$dead_line.'", "'.$type.'")');

		return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
  	}

  	function get_signature_identity($id){
  		$this->load->database();
		$query = $this->db->query('SELECT owning_signatures.project_id, owning_signatures.role_id, projects.code, projects.hotel_id FROM owning_signatures JOIN projects ON owning_signatures.project_id = projects.id WHERE owning_signatures.id ='.$id);
  		return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  	}

  	function get_signature_other_identity($id){
  		$this->load->database();
		$query = $this->db->query('SELECT company_owning_signature.project_id, company_owning_signature.role_id, projects.code, projects.hotel_id FROM company_owning_signature JOIN projects ON company_owning_signature.project_id = projects.id WHERE company_owning_signature.id ='.$id);
  		return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  	}

  	function sign($id, $uid){
  		$this->load->database();
		$query = $this->db->query('UPDATE owning_signatures SET user_id = '.$uid.' WHERE id = '.$id);

		return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  	}

  	function sign_other($id, $uid){
  		$this->load->database();
		$query = $this->db->query('UPDATE company_owning_signature SET user_id = '.$uid.' WHERE id = '.$id);

		return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  	}

  	function deadline($id, $dead_line){
		$this->db->update('owning_signatures', array('dead_line'=> $dead_line), "id = ".$id);
  	}

  	function deadline_other($id, $dead_line){
		$this->db->update('company_owning_signature', array('dead_line'=> $dead_line), "id = ".$id);
  	}

  	function add_reason($id, $delay_reason){
		$this->db->update('owning_signatures', array('delay_reason'=> $delay_reason), "id = ".$id);
  	}

  	function reject($id, $uid){
  		$this->load->database();
		$query = $this->db->query('UPDATE owning_signatures SET user_id = '.$uid.', reject = 1 WHERE id = '.$id);

		return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  	}

  	function reject_other($id, $uid){
  		$this->load->database();
		$query = $this->db->query('UPDATE company_owning_signature SET user_id = '.$uid.', reject = 1 WHERE id = '.$id);

		return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  	}

  	function unsign($id, $uid){
  		$this->load->database();
		$query = $this->db->query('UPDATE owning_signatures SET user_id = NULL, reject = 0 WHERE id = '.$id.' AND user_id = '.$uid);

		return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  	}

  	function unsign_other($id, $uid){
  		$this->load->database();
		$query = $this->db->query('UPDATE company_owning_signature SET user_id = NULL, reject = 0 WHERE id = '.$id.' AND user_id = '.$uid);

		return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  	}

  	function getby_request(){
  		$this->load->database();
		$this->db->select('owning_raquest_role.*');
		$query = $this->db->get('owning_raquest_role');
		return $query->result_array();  	
	}

}
?>
