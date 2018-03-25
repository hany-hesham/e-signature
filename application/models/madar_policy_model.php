<?php

	class madar_policy_model extends CI_Model{

  		function __contruct(){
			parent::__construct;
		}

		function create_department($data) {
			$this->load->database();
			$this->db->insert('madar_policy_department', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function create_type($data) {
			$this->load->database();
			$this->db->insert('madar_policy_types', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function create_core($data) {
			$this->load->database();
			$this->db->insert('madar_policy_core', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function create_item($data) {
			$this->load->database();
			$this->db->insert('madar_policy', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function policy_sign(){
  			$this->load->database();
			$this->db->select('madar_policy_role.*');
			$query = $this->db->get('madar_policy_role');
			return $query->result_array();  	
		}

		function policy_do_sign($core_id){
  	 		$this->load->database();
			$this->db->select('madar_policy_signature.*');
			$this->db->where('madar_policy_signature.core_id', $core_id);		
			$query = $this->db->get('madar_policy_signature');
			return $query->num_rows();  	
		}

		function add_signature($core_id, $role_id, $department_id,  $rank){
	    	$this->load->database();
			$query = $this->db->query('INSERT INTO madar_policy_signature(core_id, role_id, department_id, rank) VALUES("'.$core_id.'", "'.$role_id.'", "'.$department_id.'", "'.$rank.'")');
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
  		}

  		function get_roles(){
	    	$this->load->database();
			$this->db->select('roles.*');
        	$this->db->order_by('role');
			$query = $this->db->get('roles');
			return $query->result_array();
  		}

		function get_department(){
	    	$this->load->database();
			$this->db->select('madar_policy_department.*');
        	$this->db->order_by('id');
			$query = $this->db->get('madar_policy_department');
			return $query->result_array();
  		}

  		function get_types($id){
	    	$this->load->database();
			$this->db->select('madar_policy_types.*');
			$this->db->where('department_id', $id);
			$query = $this->db->get('madar_policy_types');
			return $query->result_array();
  		}

  		function get_core($id){
	    	$this->load->database();
			$this->db->select('madar_policy_core.*, users.fullname as name');
			$this->db->join('users', 'madar_policy_core.user_id = users.id', 'left');
			$this->db->where('madar_policy_core.id', $id);
			$query = $this->db->get('madar_policy_core');
			return $query->row_array();
  		}

  		function update_state($core_id, $state) {
			$this->db->update('madar_policy_core', array('state_id'=> $state), "id = ".$core_id);
		}

		function get_by_verbal($core_id){
	    	$this->load->database();
			$this->db->select('madar_policy_signature.*, roles.role, departments.name as department, users.fullname as user_name');
			$this->db->join('roles', 'madar_policy_signature.role_id = roles.id', 'left');
			$this->db->join('departments', 'madar_policy_signature.department_id = departments.id', 'left');
			$this->db->join('users', 'madar_policy_signature.user_id = users.id', 'left');
			$this->db->where('core_id', $core_id);
			$query = $this->db->get('madar_policy_signature');
			return $query->result_array();
  		}

		function getby_role($role_id, $department_id = FALSE) {
			if ($department_id) {
				$query = $this->db->query('SELECT id, fullname, email FROM users WHERE users.role_id = '.$role_id.' AND department_id = '.$department_id);
			}else{
				$query = $this->db->query('SELECT id, fullname, email FROM users WHERE users.role_id = '.$role_id);
			}
			return $query->result_array();
		}

		function get_policy($type_id, $core_id){
	    	$this->load->database();
			$this->db->select('madar_policy.*, users.fullname as user_name, roles_first.role as role_first, roles_second.role as role_second, roles_third.role as role_third, roles_fourth.role as role_fourth, roles_fifth.role as role_fifth, roles_sixth.role as role_sixth, roles_seventh.role as role_seventh');
			$this->db->join('users', 'madar_policy.user_id = users.id', 'left');
			//$this->db->join('madar_policy_types', 'madar_policy.type_id = madar_policy_types.id', 'left');
			//$this->db->join('madar_policy_department', 'madar_policy_types.department_id = madar_policy_department.id', 'left');
			$this->db->join('roles AS roles_first','madar_policy.first = roles_first.id', 'left');
			$this->db->join('roles AS roles_second','madar_policy.second = roles_second.id', 'left');
			$this->db->join('roles AS roles_third','madar_policy.third = roles_third.id', 'left');
			$this->db->join('roles AS roles_fourth','madar_policy.fourth = roles_fourth.id', 'left');
			$this->db->join('roles AS roles_fifth','madar_policy.fifth = roles_fifth.id', 'left');
			$this->db->join('roles AS roles_sixth','madar_policy.sixth = roles_sixth.id', 'left');
			$this->db->join('roles AS roles_seventh','madar_policy.seventh = roles_seventh.id', 'left');
			$this->db->where('core_id', $core_id);
			$this->db->where('type_id', $type_id);
			$query = $this->db->get('madar_policy');
			return $query->row_array();
  		}

  		function get_comment($core_id){
			$query = $this->db->query("
				SELECT users.fullname, madar_policy_comments.comment, madar_policy_comments.timestamp FROM madar_policy_comments
				JOIN users on madar_policy_comments.user_id = users.id
				WHERE madar_policy_comments.core_id =".$core_id
			);
			return $query->result_array();
  		}

  		function get_last_core(){
	    	$this->load->database();
			$this->db->select('madar_policy_core.*, users.fullname as name');
			$this->db->join('users', 'madar_policy_core.user_id = users.id', 'left');
        	$this->db->order_by('timestamp', 'DESC');
        	$this->db->limit('1');
			$query = $this->db->get('madar_policy_core');
			return $query->row_array();
  		}

  		function update_core($core_id, $data) {
			$this->load->database();
			$this->db->where('madar_policy_core.id', $core_id);		
			$this->db->update('madar_policy_core', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function update_item($id, $core_id, $data) {
			$this->load->database();
			$this->db->where('madar_policy.core_id', $core_id);	
			$this->db->where('madar_policy.id', $id);		
			$this->db->update('madar_policy', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function policy_sign_reset($core_id) {
	  		$this->load->database();
	  		$this->db->where('madar_policy_signature.core_id', $core_id);		
			$this->db->delete('madar_policy_signature');
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
  		}

  		function get_signature_identity($sign_id){
  			$this->load->database();
			$query = $this->db->query('SELECT madar_policy_signature.core_id FROM madar_policy_signature WHERE madar_policy_signature.id ='.$sign_id);
  			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  		}

  		function unsign($id){
	  		$this->load->database();
			$query = $this->db->query('UPDATE madar_policy_signature SET user_id = NULL, reject = 0 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
	  	}

	  	function reject($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE madar_policy_signature SET user_id = '.$uid.', reject = 1 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function sign($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE madar_policy_signature SET user_id = '.$uid.' WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function insert_comment($data){
			$this->db->insert('madar_policy_comments', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

	}

?>