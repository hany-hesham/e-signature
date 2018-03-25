<?php

	class policy_request_model extends CI_Model{

  		function __contruct(){
			parent::__construct;
		}

		function view() {
  	  		$this->load->database();
			$this->db->select('policy_requests.*, users.fullname as user_name, policy_types.name as department');
			$this->db->join('users', 'policy_requests.user_id = users.id', 'left');
			$this->db->join('policy_types', 'policy_requests.department_id = policy_types.id', 'left');
        	$this->db->order_by('timestamp', 'DESC');
			$query = $this->db->get('policy_requests');
			return $query->result_array();
		}

		function view_owned($usid) {
  	  		$this->load->database();
			$this->db->select('policy_requests.*, users.fullname as user_name, policy_types.name as department');
			$this->db->join('users', 'policy_requests.user_id = users.id', 'left');
			$this->db->join('policy_types', 'policy_requests.department_id = policy_types.id', 'left');
			$this->db->where('policy_requests.user_id', $usid);		
        	$this->db->order_by('timestamp', 'DESC');
			$query = $this->db->get('policy_requests');
			return $query->result_array();
		}

		function create_request($data) {
			$this->load->database();
			$this->db->insert('policy_requests', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function update_files($assumed_id, $req_id) {
  			$this->load->database();
  			$this->db->query('UPDATE policy_requests_filles SET req_id = "'.$req_id.'" WHERE req_id = "'.$assumed_id.'"');
  		}

  		function get_types(){
	    	$this->load->database();
			$this->db->select('policy_types.*');
        	$this->db->order_by('name');
			$query = $this->db->get('policy_types');
			return $query->result_array();
  		}

  		function get_by_fille($req_id){
	    	$this->load->database();
			$this->db->select('policy_requests_filles.*, users.fullname as user_name');
			$this->db->join('users', 'policy_requests_filles.user_id = users.id','left');
			$this->db->where('req_id', $req_id);
			$query = $this->db->get('policy_requests_filles');
			return $query->result_array();
  		}

  		function getby_role($role_id) {
			$query = $this->db->query('SELECT id, fullname, email FROM users WHERE users.role_id = '.$role_id);
			return $query->result_array();
		}

		function get_request($req_id) {
			$this->db->select('policy_requests.*, users.fullname as name, policy_types.name as department');
			$this->db->join('users', 'policy_requests.user_id = users.id','left');
			$this->db->join('policy_types', 'policy_requests.department_id = policy_types.id', 'left');
			$this->db->where('policy_requests.id', $req_id);		
			$query = $this->db->get('policy_requests');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
		}

		function get_comment($req_id){
			$query = $this->db->query("
				SELECT users.fullname, policy_requests_comments.comment, policy_requests_comments.timestamp FROM policy_requests_comments
				JOIN users on policy_requests_comments.user_id = users.id
				WHERE policy_requests_comments.req_id =".$req_id
			);
			return $query->result_array();
  		}

  		function add_fille($req_id, $name, $user_id) {
	  		$this->load->database();
	  		$this->db->query('INSERT INTO policy_requests_filles(req_id, name, user_id) VALUES("'.$req_id.'","'.$name.'","'.$user_id.'")');
	  	}

	  	function remove_fille($id) {
	      $this->load->database();
	      $this->db->query('DELETE FROM policy_requests_filles WHERE id = '.$id);
	    }

	    function update_request($req_id, $data) {
			$this->load->database();
			$this->db->where('policy_requests.id', $req_id);		
			$this->db->update('policy_requests', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function insert_comment($data){
			$this->db->insert('policy_requests_comments', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

	}

?>