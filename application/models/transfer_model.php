<?php

	class transfer_model extends CI_Model{

  		function __contruct(){
			parent::__construct;
		}

		function view($state = FALSE) {
  	  		$this->load->database();
			$this->db->select('transfer.id, transfer.date, transfer.from_acc, transfer.to_acc, transfer.state_id');
			if ($state) {
				$this->db->where('transfer.state_id', $state);	
			}else{
				$this->db->where('transfer.state_id !=', 0);
			}	
        	$this->db->order_by('timestamp', 'DESC');
			$query = $this->db->get('transfer');
			return $query->result_array();
		}

		function get_by_verbals($tran_id){
	    	$this->load->database();
			$this->db->select('transfer_signature.role_id, transfer_signature.rank,transfer_signature.department_id, transfer_signature.user_id, transfer_signature.reject, roles.role, departments.name as department, users.fullname as user_name');
			$this->db->join('roles', 'transfer_signature.role_id = roles.id', 'left');
			$this->db->join('departments', 'transfer_signature.department_id = departments.id', 'left');
			$this->db->join('users', 'transfer_signature.user_id = users.id', 'left');
			$this->db->where('tran_id', $tran_id);
        	$this->db->order_by('transfer_signature.rank');
			$query = $this->db->get('transfer_signature');
			return $query->result_array();
  		}

		function create_transfer($data) {
			$this->load->database();
			$this->db->insert('transfer', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function update_files($assumed_id, $tran_id) {
  			$this->load->database();
  			$this->db->query('UPDATE transfer_filles SET tran_id = "'.$tran_id.'" WHERE tran_id = "'.$assumed_id.'"');
  		}

  		function create_item($data) {
			$this->load->database();
			$this->db->insert('transfer_items', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function tran_sign (){
  			$this->load->database();
			$this->db->select('transfer_role.*');
			$query = $this->db->get('transfer_role');
			return $query->result_array();  	
		}

		function tran_do_sign($tran_id){
  	 		$this->load->database();
			$this->db->select('transfer_signature.*');
			$this->db->where('transfer_signature.tran_id', $tran_id);		
			$query = $this->db->get('transfer_signature');
			return $query->num_rows();  	
		}

		function add_signature($tran_id, $role_id, $department_id,  $rank){
	    	$this->load->database();
			$query = $this->db->query('INSERT INTO transfer_signature(tran_id, role_id, department_id, rank) VALUES("'.$tran_id.'", "'.$role_id.'", "'.$department_id.'", "'.$rank.'")');
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
  		}

  		function get_departments(){
	    	$this->load->database();
			$this->db->select('transfer_department.*');
        	$this->db->order_by('name');
			$query = $this->db->get('transfer_department');
			return $query->result_array();
  		}

  		function get_by_fille($tran_id){
	    	$this->load->database();
			$this->db->select('transfer_filles.*, users.fullname as user_name');
			$this->db->join('users', 'transfer_filles.user_id = users.id','left');
			$this->db->where('tran_id', $tran_id);
			$query = $this->db->get('transfer_filles');
			return $query->result_array();
  		}

  		function get_transfer($tran_id) {
			$this->db->select('transfer.*, users.fullname as name');
			$this->db->join('users', 'transfer.user_id = users.id','left');
			$this->db->where('transfer.id', $tran_id);		
			$query = $this->db->get('transfer');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
		}

		function update_state($tran_id, $state) {
			$this->db->update('transfer', array('state_id'=> $state), "id = ".$tran_id);
		}

		function get_by_verbal($tran_id){
	    	$this->load->database();
			$this->db->select('transfer_signature.*, roles.role, departments.name as department, users.fullname as user_name');
			$this->db->join('roles', 'transfer_signature.role_id = roles.id', 'left');
			$this->db->join('departments', 'transfer_signature.department_id = departments.id', 'left');
			$this->db->join('users', 'transfer_signature.user_id = users.id', 'left');
			$this->db->where('tran_id', $tran_id);
			$query = $this->db->get('transfer_signature');
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

		function get_items($tran_id) {
			$this->db->select('transfer_items.*, users.fullname as user_name, transfer_department.name as department');
			$this->db->join('users', 'transfer_items.user_id = users.id','left');
			$this->db->join('transfer_department', 'transfer_items.department_id = transfer_department.id','left');
			$this->db->where('transfer_items.tran_id', $tran_id);
			$query = $this->db->get('transfer_items');
			return ($query->num_rows() > 0 )? $query->result_array() : FALSE;
		}

		function get_comment($tran_id){
			$query = $this->db->query("
				SELECT users.fullname, transfer_comments.comment, transfer_comments.timestamp FROM transfer_comments
				JOIN users on transfer_comments.user_id = users.id
				WHERE transfer_comments.tran_id =".$tran_id
			);
			return $query->result_array();
  		}

  		function get_item_department($tran_id) {
			$this->db->select('transfer_items.department_id, transfer_department.name as department');
			$this->db->join('transfer_department', 'transfer_items.department_id = transfer_department.id','left');
			$this->db->where('transfer_items.tran_id', $tran_id);
			$this->db->group_by('transfer_items.department_id');
			$query = $this->db->get('transfer_items');
			return ($query->num_rows() > 0 )? $query->result_array() : FALSE;
		}

  		function getall_department_value($did){
		    $this->load->database();
			$this->db->select('transfer_items.eg_value, transfer_items.usd_value, transfer_department.name as department');
			$this->db->join('transfer_department', 'transfer_items.department_id = transfer_department.id','left');
			$this->db->where('transfer_items.department_id', $did);
			$this->db->order_by('transfer_items.department_id');
			$query = $this->db->get('transfer_items');
			return $query->result_array();
	  	}

  		function add_fille($tran_id, $name, $user_id) {
	  		$this->load->database();
	  		$this->db->query('INSERT INTO transfer_filles(tran_id, name, user_id) VALUES("'.$tran_id.'","'.$name.'","'.$user_id.'")');
	  	}

	  	function remove_fille($id) {
	      $this->load->database();
	      $this->db->query('DELETE FROM transfer_filles WHERE id = '.$id);
	    }

	    function update_transfer($tran_id, $data) {
			$this->load->database();
			$this->db->where('transfer.id', $tran_id);		
			$this->db->update('transfer', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function update_item($id, $tran_id, $data) {
			$this->load->database();
			$this->db->where('transfer_items.tran_id', $tran_id);	
			$this->db->where('transfer_items.id', $id);		
			$this->db->update('transfer_items', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function get_signature_identity($sign_id){
  			$this->load->database();
			$query = $this->db->query('SELECT transfer_signature.tran_id FROM transfer_signature WHERE transfer_signature.id ='.$sign_id);
  			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  		}

  		function unsign($id){
	  		$this->load->database();
			$query = $this->db->query('UPDATE transfer_signature SET user_id = NULL, reject = 0 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
	  	}

	  	function reject($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE transfer_signature SET user_id = '.$uid.', reject = 1 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function sign($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE transfer_signature SET user_id = '.$uid.' WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function insert_comment($data){
			$this->db->insert('transfer_comments', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

	}

?>