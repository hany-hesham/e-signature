<?php

	class Project_signatures_model extends MY_Model{
		
	  	function __contruct(){
			parent::__construct;
	  	}

	  	function project_do_sign($project_id, $type){
  	 		$this->load->database();
			$this->db->select('project_signatures.*');
			$this->db->where('project_signatures.project_id', $project_id);	
			$this->db->where('project_signatures.projects_change_id', $type);	
        	$this->db->order_by('project_signatures.rank');
			$query = $this->db->get('project_signatures');
			return $query->num_rows();  	
		}

		function clear_project_change_signature($project_id, $type) {
	  		$this->load->database();
	  		$this->db->where('project_signatures.project_id', $project_id);	
			$this->db->where('project_signatures.projects_change_id', $type);		
			$this->db->delete('project_signatures');
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
  		}

	  	function add_project_signature($project_id, $role_id, $rank, $change){
		    $this->load->database();
			$query = $this->db->query('INSERT INTO project_signatures(project_id, role_id, rank, projects_change_id) VALUES("'.$project_id.'", "'.$role_id.'", "'.$rank.'", "'.$change.'")');
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
	  	}

	  	function getby_project_verbal($project_id, $change){
	    	$this->load->database();
			$this->db->select('project_signatures.id, user_id, role_id, timestamp, rank, roles.role, reject');
			$this->db->join('roles', 'role_id = roles.id', 'left');
			$this->db->where('project_id', $project_id);
			$this->db->where('projects_change_id', $change);
			$this->db->order_by('rank');
			$query = $this->db->get('project_signatures');
			return $query->result_array();
	  	}

	  	function get_signature_identity($id){
	  		$this->load->database();
			$query = $this->db->query('SELECT project_signatures.project_id, project_signatures.role_id, projects.hotel_id FROM project_signatures JOIN projects ON project_signatures.project_id = projects.id WHERE project_signatures.id ='.$id);
	  		return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
	  	}

	  	function unsign($id){
	  		$this->load->database();
			$query = $this->db->query('UPDATE project_signatures SET user_id = NULL, reject = 0 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
	  	}

	  	function reject($id, $uid){
	  		$this->load->database();
			$query = $this->db->query('UPDATE project_signatures SET user_id = '.$uid.', reject = 1 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
	  	}

	  	function sign($id, $uid){
	  		$this->load->database();
			$query = $this->db->query('UPDATE project_signatures SET user_id = '.$uid.' WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function getby_project_signed($project_id){
		    $this->load->database();
			$this->db->select('users.email');
			$this->db->join('users', 'user_id = users.id');
			$this->db->where('project_id', $project_id);
			$query = $this->db->get('project_signatures');
			return $query->result_array();
	  	}
	
  	function getall(){
	    $this->load->database();
		
		$query = $this->db->get('project_signatures');
		return $query->result_array();
  	}


  	function getby_project($project_id){
	    $this->load->database();
	
		$this->db->where('project_id', $project_id);
		$this->db->order_by('rank');
		$query = $this->db->get('project_signatures');

		return $query->result_array();
  	}

  	function reset_project($project_id){
	    $this->load->database();
		$query = $this->db->query('DELETE FROM project_signatures WHERE project_id = "'.$project_id.'"');

		return TRUE;
  	}

  	function unset_project_signature($id) {
  		$this->load->database();
		$query = $this->db->query('DELETE FROM project_signatures WHERE id = '.$id);

		return TRUE;	
  	}

  	function self_sign($project_id, $user_id){
	    $this->load->database();
		$query = $this->db->query('UPDATE project_signatures SET user_id = '.$user_id.' WHERE project_id = '.$project_id.' AND role_id = 0');

		return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  	}

}
?>
