<?php

	class movement_model extends CI_Model{

  		function __contruct(){
			parent::__construct;
		}

		function create_movement($data) {
			$this->load->database();
			$this->db->insert('movement', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function update_files($assumed_id, $move_id) {
  			$this->load->database();
  			$this->db->query('UPDATE movement_filles SET move_id = "'.$move_id.'" WHERE move_id = "'.$assumed_id.'"');
  		}

  		function create_item($data) {
			$this->load->database();
			$this->db->insert('movement_items', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function movement_sign_hotel (){
  			$this->load->database();
			$this->db->select('movement_hotel_role.*');
			$query = $this->db->get('movement_hotel_role');
			return $query->result_array();  	
		}

		function movement_do_sign_to($move_id){
  	 		$this->load->database();
			$this->db->select('movement_to_hotel_signature.*');
			$this->db->where('movement_to_hotel_signature.move_id', $move_id);		
			$query = $this->db->get('movement_to_hotel_signature');
			return $query->num_rows();  	
		}

		function add_signature_to($move_id, $role_id, $department_id,  $rank){
	    	$this->load->database();
			$query = $this->db->query('INSERT INTO movement_to_hotel_signature(move_id, role_id, department_id, rank) VALUES("'.$move_id.'", "'.$role_id.'", "'.$department_id.'", "'.$rank.'")');
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
  		}


  		function movement_do_sign_from($move_id){
  	 		$this->load->database();
			$this->db->select('movement_from_hotel_signature.*');
			$this->db->where('movement_from_hotel_signature.move_id', $move_id);		
			$query = $this->db->get('movement_from_hotel_signature');
			return $query->num_rows();  	
		}

		function add_signature_from($move_id, $role_id, $department_id,  $rank){
	    	$this->load->database();
			$query = $this->db->query('INSERT INTO movement_from_hotel_signature(move_id, role_id, department_id, rank) VALUES("'.$move_id.'", "'.$role_id.'", "'.$department_id.'", "'.$rank.'")');
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
  		}

  		function movement_sign_final (){
  			$this->load->database();
			$this->db->select('movement_final_role.*');
			$query = $this->db->get('movement_final_role');
			return $query->result_array();  	
		}

  		function movement_do_sign_final($move_id){
  	 		$this->load->database();
			$this->db->select('movement_final_signature.*');
			$this->db->where('movement_final_signature.move_id', $move_id);		
			$query = $this->db->get('movement_final_signature');
			return $query->num_rows();  	
		}

		function add_signature_final($move_id, $role_id, $department_id,  $rank){
	    	$this->load->database();
			$query = $this->db->query('INSERT INTO movement_final_signature(move_id, role_id, department_id, rank) VALUES("'.$move_id.'", "'.$role_id.'", "'.$department_id.'", "'.$rank.'")');
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
  		}

  		function movement_sign_owning (){
  			$this->load->database();
			$this->db->select('movement_owning_role.*');
			$query = $this->db->get('movement_owning_role');
			return $query->result_array();  	
		}

  		function movement_do_sign_owning($move_id){
  	 		$this->load->database();
			$this->db->select('movement_owning_signature.*');
			$this->db->where('movement_owning_signature.move_id', $move_id);		
			$query = $this->db->get('movement_owning_signature');
			return $query->num_rows();  	
		}

		function add_signature_owning($move_id, $role_id, $department_id,  $rank){
	    	$this->load->database();
			$query = $this->db->query('INSERT INTO movement_owning_signature(move_id, role_id, department_id, rank) VALUES("'.$move_id.'", "'.$role_id.'", "'.$department_id.'", "'.$rank.'")');
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
  		}

  		function movement_sign_assets (){
  			$this->load->database();
			$this->db->select('movement_assets_role.*');
			$query = $this->db->get('movement_assets_role');
			return $query->result_array();  	
		}

  		function movement_do_sign_assets($move_id){
  	 		$this->load->database();
			$this->db->select('movement_assets_signature.*');
			$this->db->where('movement_assets_signature.move_id', $move_id);		
			$query = $this->db->get('movement_assets_signature');
			return $query->num_rows();  	
		}

		function add_signature_assets($move_id, $role_id, $department_id,  $rank){
	    	$this->load->database();
			$query = $this->db->query('INSERT INTO movement_assets_signature(move_id, role_id, department_id, rank) VALUES("'.$move_id.'", "'.$role_id.'", "'.$department_id.'", "'.$rank.'")');
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
  		}

  		function get_by_fille($move_id){
	    	$this->load->database();
			$this->db->select('movement_filles.*, users.fullname as user_name');
			$this->db->join('users', 'movement_filles.user_id = users.id','left');
			$this->db->where('move_id', $move_id);
			$query = $this->db->get('movement_filles');
			return $query->result_array();
  		}

  		function add_fille($move_id, $name, $user_id) {
	  		$this->load->database();
	  		$this->db->query('INSERT INTO movement_filles(move_id, name, user_id) VALUES("'.$move_id.'","'.$name.'","'.$user_id.'")');
	  	}

	  	function remove_fille($id) {
	      $this->load->database();
	      $this->db->query('DELETE FROM movement_filles WHERE id = '.$id);
	    }

	    function get_movement($move_id) {
			$this->db->select('movement.*, from_hotels.name AS from_hotel_name, from_hotels.logo As from_logo, to_hotels.name AS to_hotel_name,  to_hotels.logo As to_logo, from_company.name AS from_company, to_company.name AS to_company, departments.name AS department, users.fullname as name');
  	  		$this->db->join('hotels AS from_hotels','movement.from_hotel = from_hotels.id');
  	  		$this->db->join('hotels AS to_hotels','movement.to_hotel = to_hotels.id');
  	  		$this->db->join('companies AS from_company','from_hotels.company_id = from_company.id');
  	  		$this->db->join('companies AS to_company','to_hotels.company_id = to_company.id');
			$this->db->join('users', 'movement.user_id = users.id','left');
			$this->db->join('departments','movement.department_id = departments.id');
			$this->db->where('movement.id', $move_id);		
			$query = $this->db->get('movement');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
		}

		function update_state($move_id, $state) {
			$this->db->update('movement', array('state_id'=> $state), "id = ".$move_id);
		}

		function get_to_by_verbal($move_id){
	    	$this->load->database();
			$this->db->select('movement_to_hotel_signature.*, roles.role, departments.name as department, users.fullname as user_name');
			$this->db->join('roles', 'movement_to_hotel_signature.role_id = roles.id', 'left');
			$this->db->join('departments', 'movement_to_hotel_signature.department_id = departments.id', 'left');
			$this->db->join('users', 'movement_to_hotel_signature.user_id = users.id', 'left');
			$this->db->where('move_id', $move_id);
			$query = $this->db->get('movement_to_hotel_signature');
			return $query->result_array();
  		}

  		function get_from_by_verbal($move_id){
	    	$this->load->database();
			$this->db->select('movement_from_hotel_signature.*, roles.role, departments.name as department, users.fullname as user_name');
			$this->db->join('roles', 'movement_from_hotel_signature.role_id = roles.id', 'left');
			$this->db->join('departments', 'movement_from_hotel_signature.department_id = departments.id', 'left');
			$this->db->join('users', 'movement_from_hotel_signature.user_id = users.id', 'left');
			$this->db->where('move_id', $move_id);
			$query = $this->db->get('movement_from_hotel_signature');
			return $query->result_array();
  		}

  		function get_final_by_verbal($move_id){
	    	$this->load->database();
			$this->db->select('movement_final_signature.*, roles.role, departments.name as department, users.fullname as user_name');
			$this->db->join('roles', 'movement_final_signature.role_id = roles.id', 'left');
			$this->db->join('departments', 'movement_final_signature.department_id = departments.id', 'left');
			$this->db->join('users', 'movement_final_signature.user_id = users.id', 'left');
			$this->db->where('move_id', $move_id);
			$query = $this->db->get('movement_final_signature');
			return $query->result_array();
  		}

  		function get_owning_by_verbal($move_id){
	    	$this->load->database();
			$this->db->select('movement_owning_signature.*, roles.role, departments.name as department, users.fullname as user_name');
			$this->db->join('roles', 'movement_owning_signature.role_id = roles.id', 'left');
			$this->db->join('departments', 'movement_owning_signature.department_id = departments.id', 'left');
			$this->db->join('users', 'movement_owning_signature.user_id = users.id', 'left');
			$this->db->where('move_id', $move_id);
			$query = $this->db->get('movement_owning_signature');
			return $query->result_array();
  		}

  		function get_assets_by_verbal($move_id){
	    	$this->load->database();
			$this->db->select('movement_assets_signature.*, roles.role, departments.name as department, users.fullname as user_name');
			$this->db->join('roles', 'movement_assets_signature.role_id = roles.id', 'left');
			$this->db->join('departments', 'movement_assets_signature.department_id = departments.id', 'left');
			$this->db->join('users', 'movement_assets_signature.user_id = users.id', 'left');
			$this->db->where('move_id', $move_id);
			$query = $this->db->get('movement_assets_signature');
			return $query->result_array();
  		}

  		function get_items($move_id) {
			$this->db->select('movement_items.*, users.fullname as user_name');
			$this->db->join('users', 'movement_items.user_id = users.id','left');
			$this->db->where('movement_items.move_id', $move_id);
			$query = $this->db->get('movement_items');
			return ($query->num_rows() > 0 )? $query->result_array() : FALSE;
		}

		function get_comment($move_id){
			$query = $this->db->query("
				SELECT users.fullname, movement_comments.comment, movement_comments.timestamp FROM movement_comments
				JOIN users on movement_comments.user_id = users.id
				WHERE movement_comments.move_id =".$move_id
			);
			return $query->result_array();
  		}

	}

?>