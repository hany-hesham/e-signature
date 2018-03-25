<?php

	class out_go_model extends CI_Model{

  		function __contruct(){
			parent::__construct;
		}

		function view($user_hotels = FALSE) {
  	  		$this->load->database();
			$this->db->select('out_go.*, hotels.name as hotel_name, hotels.logo As logo, departments.name as department');
			$this->db->join('hotels', 'out_go.hotel_id = hotels.id','left');
			$this->db->join('departments', 'out_go.department_id = departments.id','left');
        	if ($user_hotels) {
          		$this->db->where_in('out_go.hotel_id', $user_hotels);
        	}
			$this->db->where('out_go.state_id !=', 0);		
        	$this->db->order_by('timestamp', 'DESC');
			$query = $this->db->get('out_go');
			return $query->result_array();
		}

  		function get_by_verbals($out_id){
	    	$this->load->database();
			$this->db->select('out_go_signature.role_id, out_go_signature.rank,out_go_signature.department_id, out_go_signature.user_id, out_go_signature.reject, roles.role, departments.name as department, users.fullname as user_name');
			$this->db->join('roles', 'out_go_signature.role_id = roles.id', 'left');
			$this->db->join('departments', 'out_go_signature.department_id = departments.id', 'left');
			$this->db->join('users', 'out_go_signature.user_id = users.id', 'left');
			$this->db->where('out_id', $out_id);
        	$this->db->order_by('out_go_signature.rank');
			$query = $this->db->get('out_go_signature');
			return $query->result_array();
  		}

  		function get_del_by_verbals($out_id){
	    	$this->load->database();
			$this->db->select('out_del_go_signature.role_id, out_del_go_signature.rank,out_del_go_signature.department_id, out_del_go_signature.user_id, out_del_go_signature.reject, roles.role, departments.name as department, users.fullname as user_name');
			$this->db->join('roles', 'out_del_go_signature.role_id = roles.id', 'left');
			$this->db->join('departments', 'out_del_go_signature.department_id = departments.id', 'left');
			$this->db->join('users', 'out_del_go_signature.user_id = users.id', 'left');
			$this->db->where('del_id', $out_id);
        	$this->db->order_by('out_del_go_signature.rank');
			$query = $this->db->get('out_del_go_signature');
			return $query->result_array();
  		}

  		function view_app($user_hotels = FALSE) {
  	  		$this->load->database();
			$this->db->select('out_go.*, hotels.name as hotel_name, hotels.logo As logo, departments.name as department');
			$this->db->join('hotels', 'out_go.hotel_id = hotels.id','left');
			$this->db->join('departments', 'out_go.department_id = departments.id','left');
        	if ($user_hotels) {
          		$this->db->where_in('out_go.hotel_id', $user_hotels);
        	}
			$this->db->where('out_go.state_id', 2);		
        	$this->db->order_by('timestamp', 'DESC');
			$query = $this->db->get('out_go');
			return $query->result_array();
		}

		function view_wat($user_hotels = FALSE, $state) {
  	  		$this->load->database();
			$this->db->select('out_go.*, hotels.name as hotel_name, hotels.logo As logo, departments.name as department');
			$this->db->join('hotels', 'out_go.hotel_id = hotels.id','left');
			$this->db->join('departments', 'out_go.department_id = departments.id','left');
        	if ($user_hotels) {
          		$this->db->where_in('out_go.hotel_id', $user_hotels);
        	}
			$this->db->where('out_go.state_id', $state);		
        	$this->db->order_by('timestamp', 'DESC');
			$query = $this->db->get('out_go');
			return $query->result_array();
		}

		function view_rej($user_hotels = FALSE) {
  	  		$this->load->database();
			$this->db->select('out_go.*, hotels.name as hotel_name, hotels.logo As logo, departments.name as department');
			$this->db->join('hotels', 'out_go.hotel_id = hotels.id','left');
			$this->db->join('departments', 'out_go.department_id = departments.id','left');
        	if ($user_hotels) {
          		$this->db->where_in('out_go.hotel_id', $user_hotels);
        	}
			$this->db->where('out_go.state_id', 3);		
        	$this->db->order_by('timestamp', 'DESC');
			$query = $this->db->get('out_go');
			return $query->result_array();
		}

		function create_out_go($data) {
			$this->load->database();
			$this->db->insert('out_go', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function update_files($assumed_id, $out_id) {
  			$this->load->database();
  			$this->db->query('UPDATE out_go_filles SET out_id = "'.$out_id.'" WHERE out_id = "'.$assumed_id.'"');
  		}

  		function create_item($data) {
			$this->load->database();
			$this->db->insert('out_go_items', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function add_reason($out_id, $reason_id) {
	  		$this->load->database();
	  		$this->db->query('INSERT INTO out_go_reason(out_id,reason_id) VALUES("'.$out_id.'","'.$reason_id.'")');
  		}

  		function out_sign (){
  			$this->load->database();
			$this->db->select('out_go_role.*');
			$query = $this->db->get('out_go_role');
			return $query->result_array();  	
		}

		function out_do_sign($out_id){
  	 		$this->load->database();
			$this->db->select('out_go_signature.*');
			$this->db->where('out_go_signature.out_id', $out_id);		
			$query = $this->db->get('out_go_signature');
			return $query->num_rows();  	
		}

		function add_signature($out_id, $role_id, $department_id,  $rank){
	    	$this->load->database();
			$query = $this->db->query('INSERT INTO out_go_signature(out_id, role_id, department_id, rank) VALUES("'.$out_id.'", "'.$role_id.'", "'.$department_id.'", "'.$rank.'")');
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
  		}

  		function get_reasons(){
	    	$this->load->database();
			$this->db->select('out_go_reasons.*');
        	$this->db->order_by('name');
			$query = $this->db->get('out_go_reasons');
			return $query->result_array();
  		}

  		function get_departments(){
	    	$this->load->database();
			$this->db->select('departments.*');
        	$this->db->order_by('name');
			$query = $this->db->get('departments');
			return $query->result_array();
  		}

  		function get_by_fille($out_id){
	    	$this->load->database();
			$this->db->select('out_go_filles.*, users.fullname as user_name');
			$this->db->join('users', 'out_go_filles.user_id = users.id','left');
			$this->db->where('out_id', $out_id);
			$query = $this->db->get('out_go_filles');
			return $query->result_array();
  		}

  		function get_out_go($out_id) {
			$this->db->select('out_go.*, hotels.name as hotel_name, hotels.logo As logo, users.fullname as name, departments.name as department');
			$this->db->join('hotels', 'out_go.hotel_id = hotels.id','left');
			$this->db->join('users', 'out_go.user_id = users.id','left');
			$this->db->join('departments', 'out_go.department_id = departments.id', 'left');
			$this->db->where('out_go.id', $out_id);		
			$query = $this->db->get('out_go');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
		}

		function update_state($out_id, $state) {
			$this->db->update('out_go', array('state_id'=> $state), "id = ".$out_id);
		}

		function get_by_verbal($out_id){
	    	$this->load->database();
			$this->db->select('out_go_signature.*, roles.role, departments.name as department, users.fullname as user_name');
			$this->db->join('roles', 'out_go_signature.role_id = roles.id', 'left');
			$this->db->join('departments', 'out_go_signature.department_id = departments.id', 'left');
			$this->db->join('users', 'out_go_signature.user_id = users.id', 'left');
			$this->db->where('out_id', $out_id);
			$query = $this->db->get('out_go_signature');
			return $query->result_array();
  		}

  		function add_fille($out_id, $name, $user_id) {
	  		$this->load->database();
	  		$this->db->query('INSERT INTO out_go_filles(out_id, name, user_id) VALUES("'.$out_id.'","'.$name.'","'.$user_id.'")');
	  	}

	  	function remove_fille($id) {
	      $this->load->database();
	      $this->db->query('DELETE FROM out_go_filles WHERE id = '.$id);
	    }

	    function get_items($out_id) {
			$this->db->select('out_go_items.*, users.fullname as user_name');
			$this->db->join('users', 'out_go_items.user_id = users.id','left');
			$this->db->where('out_go_items.out_id', $out_id);
			$query = $this->db->get('out_go_items');
			return ($query->num_rows() > 0 )? $query->result_array() : FALSE;
		}

		function get_reason($out_id) {
	    	$this->load->database();
			$this->db->select('out_go_reason.*, out_go_reasons.name as reason_name');
			$this->db->join('out_go_reasons', 'out_go_reason.reason_id = out_go_reasons.id','left');
			$this->db->where('out_go_reason.out_id', $out_id);		
			$query = $this->db->get('out_go_reason');
			return $query->result_array();
		}

  		function get_comment($out_id){
			$query = $this->db->query("
				SELECT users.fullname, out_go_comments.comment, out_go_comments.timestamp FROM out_go_comments
				JOIN users on out_go_comments.user_id = users.id
				WHERE out_go_comments.out_id =".$out_id
			);
			return $query->result_array();
  		}

  		function update_out_go($out_id, $data) {
			$this->load->database();
			$this->db->where('out_go.id', $out_id);		
			$this->db->update('out_go', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function update_item($id, $out_id, $data) {
			$this->load->database();
			$this->db->where('out_go_items.out_id', $out_id);	
			$this->db->where('out_go_items.id', $id);		
			$this->db->update('out_go_items', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function clear_reason($out_id) {
	  		$this->load->database();
	  		$this->db->where('out_go_reason.out_id', $out_id);		
			$this->db->delete('out_go_reason');
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
  		}

  		function get_signature_identity($sign_id){
  			$this->load->database();
			$query = $this->db->query('SELECT out_go.hotel_id, out_go_signature.out_id FROM out_go_signature JOIN out_go ON out_go_signature.out_id = out_go.id WHERE out_go_signature.id ='.$sign_id);
  			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  		}

  		function unsign($id){
	  		$this->load->database();
			$query = $this->db->query('UPDATE out_go_signature SET user_id = NULL, reject = 0 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
	  	}

	  	function reject($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE out_go_signature SET user_id = '.$uid.', reject = 1 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function sign($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE out_go_signature SET user_id = '.$uid.' WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function update_out_with($out_id, $out_with) {
			$this->db->update('out_go', array('out_with'=> $out_with), "id = ".$out_id);
		}

  		function insert_comment($data){
			$this->db->insert('out_go_comments', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function out_del_sign (){
  			$this->load->database();
			$this->db->select('out_del_go_role.*');
			$query = $this->db->get('out_del_go_role');
			return $query->result_array();  	
		}

		function out_del_do_sign($out_id){
  	 		$this->load->database();
			$this->db->select('out_del_go_signature.*');
			$this->db->where('out_del_go_signature.del_id', $out_id);		
			$query = $this->db->get('out_del_go_signature');
			return $query->num_rows();  	
		}

		function add_del_signature($out_id, $role_id, $department_id,  $rank){
	    	$this->load->database();
			$query = $this->db->query('INSERT INTO out_del_go_signature(del_id, role_id, department_id, rank) VALUES("'.$out_id.'", "'.$role_id.'", "'.$department_id.'", "'.$rank.'")');
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
  		}

  		function update_del_state($id, $state) {
			$this->db->update('out_go_items', array('del_state_id'=> $state), "id = ".$id);
		}

		function get_del_by_verbal($out_id){
	    	$this->load->database();
			$this->db->select('out_del_go_signature.*, roles.role, departments.name as department, users.fullname as user_name');
			$this->db->join('roles', 'out_del_go_signature.role_id = roles.id', 'left');
			$this->db->join('departments', 'out_del_go_signature.department_id = departments.id', 'left');
			$this->db->join('users', 'out_del_go_signature.user_id = users.id', 'left');
			$this->db->where('del_id', $out_id);
			$query = $this->db->get('out_del_go_signature');
			return $query->result_array();
  		}

  		function get_del_signature_identity($sign_id){
	    	$this->load->database();
			$this->db->select('out_del_go_signature.del_id');
			$this->db->where('id', $sign_id);
			$query = $this->db->get('out_del_go_signature');
			return $query->row_array();
  		}

  		function unsign_del($id){
	  		$this->load->database();
			$query = $this->db->query('UPDATE out_del_go_signature SET user_id = NULL, reject = 0 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
	  	}

	  	function reject_led($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE out_del_go_signature SET user_id = '.$uid.', reject = 1 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function sign_led($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE out_del_go_signature SET user_id = '.$uid.' WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function getall_items($item, $from_date = FALSE, $to_date = FALSE, $hotel_id = FALSE){
	    	$this->load->database();
			$this->db->select('out_go_items.*, out_go.hotel_id, out_go.department_id, out_go.date, out_go.re_date, out_go.address, hotels.name as hotel_name, departments.name as department');
			$this->db->join('out_go', 'out_go_items.out_id = out_go.id', 'left');
			$this->db->join('hotels', 'out_go.hotel_id = hotels.id','left');
			$this->db->join('departments', 'out_go.department_id = departments.id','left');
			$this->db->like('description', $item);
			if ($hotel_id) {
				$this->db->where('out_go.hotel_id', $hotel_id);
			}
			if ($from_date) {
				$this->db->where('out_go.date >=', $from_date);
			}
			if ($to_date) {
				$this->db->where('out_go.date <=', $to_date);
			}
        	$this->db->where('out_go.state_id', 2);
        	$this->db->order_by('out_go.department_id', 'DESC');
			$query = $this->db->get('out_go_items');
			return $query->result_array();
  		}

  		function getall_items_count($item, $from_date = FALSE, $to_date = FALSE, $hotel_id = FALSE){
	    	$this->load->database();
			$this->db->select('out_go_items.*, out_go.hotel_id, out_go.department_id, out_go.date, out_go.re_date, out_go.address, hotels.name as hotel_name, departments.name as department');
			$this->db->join('out_go', 'out_go_items.out_id = out_go.id', 'left');
			$this->db->join('hotels', 'out_go.hotel_id = hotels.id','left');
			$this->db->join('departments', 'out_go.department_id = departments.id','left');
			$this->db->like('description', $item);
			if ($hotel_id) {
				$this->db->where('out_go.hotel_id', $hotel_id);
			}
			if ($from_date) {
				$this->db->where('out_go.date >=', $from_date);
			}
			if ($to_date) {
				$this->db->where('out_go.date <=', $to_date);
			}
        	$this->db->where('out_go.state_id', 2);
        	$this->db->order_by('out_go.department_id', 'DESC');
			$query = $this->db->get('out_go_items');
			return $query->num_rows();
  		}

  		function getall_item() {
  	  		$this->load->database();
			$this->db->select('out_go_items.*');
			$this->db->group_by('description');
			$query = $this->db->get('out_go_items');
			return $query->result_array();
		}

		function get_item($id) {
			$this->db->select('out_go_items.*, users.fullname as user_name, users_del.fullname as del_name');
			$this->db->join('users', 'out_go_items.user_id = users.id','left');
			$this->db->join('users AS users_del', 'out_go_items.user_del_id = users.id','left');
			$this->db->where('out_go_items.id', $id);
			$query = $this->db->get('out_go_items');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
		}

		function update_del_item($id, $data) {
			$this->load->database();
			$this->db->where('out_go_items.id', $id);		
			$this->db->update('out_go_items', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function getall_out_gos($from_date = FALSE, $to_date = FALSE, $hotel_id = FALSE){
	    	$this->load->database();
			$this->db->select('out_go.*, hotels.name as hotel_name, departments.name as department');
			$this->db->join('hotels', 'out_go.hotel_id = hotels.id','left');
			$this->db->join('departments', 'out_go.department_id = departments.id','left');
			if ($hotel_id) {
				$this->db->where('out_go.hotel_id', $hotel_id);
			}
			if ($from_date) {
				$this->db->where('out_go.date >=', $from_date);
			}
			if ($to_date) {
				$this->db->where('out_go.date <=', $to_date);
			}
        	$this->db->where('out_go.state_id', 2);
        	$this->db->order_by('out_go.department_id', 'DESC');
			$query = $this->db->get('out_go');
			return $query->result_array();
  		}

  		function getall_out_gos_count($from_date = FALSE, $to_date = FALSE, $hotel_id = FALSE){
	    	$this->load->database();
			$this->db->select('out_go.*, hotels.name as hotel_name, departments.name as department');
			$this->db->join('hotels', 'out_go.hotel_id = hotels.id','left');
			$this->db->join('departments', 'out_go.department_id = departments.id','left');
			if ($hotel_id) {
				$this->db->where('out_go.hotel_id', $hotel_id);
			}
			if ($from_date) {
				$this->db->where('out_go.date >=', $from_date);
			}
			if ($to_date) {
				$this->db->where('out_go.date <=', $to_date);
			}
        	$this->db->where('out_go.state_id', 2);
        	$this->db->order_by('out_go.department_id', 'DESC');
			$query = $this->db->get('out_go');
			return $query->num_rows();
  		}

  		function getall_out_gos_delivery($from_date = FALSE, $to_date = FALSE, $hotel_id = FALSE){
	    	$this->load->database();
			$this->db->select('out_go.*, hotels.name as hotel_name, departments.name as department');
			$this->db->join('hotels', 'out_go.hotel_id = hotels.id','left');
			$this->db->join('departments', 'out_go.department_id = departments.id','left');
			if ($hotel_id) {
				$this->db->where('out_go.hotel_id', $hotel_id);
			}
			if ($from_date) {
				$this->db->where('out_go.re_date >=', $from_date);
			}
			if ($to_date) {
				$this->db->where('out_go.re_date <=', $to_date);
			}
        	$this->db->where('out_go.state_id', 2);
        	$this->db->order_by('out_go.department_id', 'DESC');
			$query = $this->db->get('out_go');
			return $query->result_array();
  		}

  		function getall_out_gos_delivery_count($from_date = FALSE, $to_date = FALSE, $hotel_id = FALSE){
	    	$this->load->database();
			$this->db->select('out_go.*, hotels.name as hotel_name, departments.name as department');
			$this->db->join('hotels', 'out_go.hotel_id = hotels.id','left');
			$this->db->join('departments', 'out_go.department_id = departments.id','left');
			if ($hotel_id) {
				$this->db->where('out_go.hotel_id', $hotel_id);
			}
			if ($from_date) {
				$this->db->where('out_go.re_date >=', $from_date);
			}
			if ($to_date) {
				$this->db->where('out_go.re_date <=', $to_date);
			}
        	$this->db->where('out_go.state_id', 2);
        	$this->db->order_by('out_go.department_id', 'DESC');
			$query = $this->db->get('out_go');
			return $query->num_rows();
  		}

  		function getall_out_gos_delay($date, $hotel_id = FALSE){
	    	$this->load->database();
			$this->db->select('out_go_items.*, out_go.hotel_id, out_go.department_id, out_go.re_date, out_go.date, out_go.address, hotels.name as hotel_name, departments.name as department');
			$this->db->join('out_go', 'out_go_items.out_id = out_go.id','left');
			$this->db->join('hotels', 'out_go.hotel_id = hotels.id','left');
			$this->db->join('departments', 'out_go.department_id = departments.id','left');
			if ($hotel_id) {
				$this->db->where('out_go.hotel_id', $hotel_id);
			}
			$this->db->where('out_go.re_date <=', $date);
			$this->db->where('out_go_items.delivered', 0);
        	$this->db->where('out_go.state_id', 2);
        	$this->db->order_by('out_go.department_id', 'DESC');
			$query = $this->db->get('out_go_items');
			return $query->result_array();
  		}

  		function getall_out_gos_delivered($hotel_id = FALSE){
	    	$this->load->database();
			$this->db->select('out_go_items.*, out_go.hotel_id, out_go.department_id, out_go.re_date, out_go.date, out_go.address, hotels.name as hotel_name, departments.name as department');
			$this->db->join('out_go', 'out_go_items.out_id = out_go.id','left');
			$this->db->join('hotels', 'out_go.hotel_id = hotels.id','left');
			$this->db->join('departments', 'out_go.department_id = departments.id','left');
			if ($hotel_id) {
				$this->db->where('out_go.hotel_id', $hotel_id);
			}
			$this->db->where('out_go_items.delivered', 1);
        	$this->db->where('out_go.state_id', 2);
        	$this->db->order_by('out_go.department_id', 'DESC');
			$query = $this->db->get('out_go_items');
			return $query->result_array();
  		}

  		function getall_out_gos_out($hotel_id = FALSE){
	    	$this->load->database();
			$this->db->select('out_go_items.*, out_go.hotel_id, out_go.department_id, out_go.re_date, out_go.date, out_go.address, hotels.name as hotel_name, departments.name as department');
			$this->db->join('out_go', 'out_go_items.out_id = out_go.id','left');
			$this->db->join('hotels', 'out_go.hotel_id = hotels.id','left');
			$this->db->join('departments', 'out_go.department_id = departments.id','left');
			if ($hotel_id) {
				$this->db->where('out_go.hotel_id', $hotel_id);
			}
			$this->db->where('out_go_items.delivered', 0);
        	$this->db->where('out_go.state_id', 2);
        	$this->db->order_by('out_go.department_id', 'DESC');
			$query = $this->db->get('out_go_items');
			return $query->result_array();
  		}
	function update_re_date($data, $out_id) {
			$this->load->database();
			$this->db->where('out_go.id', $out_id);		
			$this->db->update('out_go', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}
	function add_change_date($data) {
			$this->load->database();
			$this->db->insert('out_go_date_change', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}
	 function get_changed_dates($out_id) {
			$this->db->select('out_go_date_change.*, users.fullname as user_name');
			$this->db->join('users', 'out_go_date_change.user_id = users.id','left');
			$this->db->where('out_go_date_change.out_id', $out_id);
			$query = $this->db->get('out_go_date_change');
			return $query->result_array();
		}
	function getall_delivery_change_date($from_date = FALSE, $to_date = FALSE, $hotel_id = FALSE){
	    	$this->load->database();
			$this->db->select('out_go.*, hotels.name as hotel_name, departments.name as department');
			$this->db->join('hotels', 'out_go.hotel_id = hotels.id','left');
			$this->db->join('departments', 'out_go.department_id = departments.id','left');
			if ($hotel_id) {
				$this->db->where('out_go.hotel_id', $hotel_id);
			}
			if ($from_date) {
				$this->db->where('out_go.date >=', $from_date);
			}
			if ($to_date) {
				$this->db->where('out_go.date <=', $to_date);
			}
        	$this->db->where('out_go.state_id', 2);
        	$this->db->where('out_go.change_re_date', 1);
        	$this->db->order_by('out_go.department_id', 'DESC');
			$query = $this->db->get('out_go');
			return $query->result_array();
  		}	
  	function update_change_re_date($out_id, $state) {
			$this->db->update('out_go', array('change_re_date'=> $state), "id = ".$out_id);
		}
		
		

	}

?>