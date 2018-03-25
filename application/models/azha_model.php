<?php

	class azha_model extends CI_Model{

  		function __contruct(){
			parent::__construct;
		}

  		function get_azha($azha_id) {
			$this->db->select('azha.*, users.fullname as user_name');
			$this->db->join('users', 'azha.user_id = users.id','left');
			$this->db->where('azha.id', $azha_id);		
			$query = $this->db->get('azha');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
		}

		function get_building($azha_id) {
			$this->db->select('azha_building.*, azha_buildings.name as building_name');
			$this->db->join('azha_buildings', 'buildings_id.user_id = azha_buildings.id','left');
			$this->db->where('azha_building.azha_id', $azha_id);
			$query = $this->db->get('azha_building');
			return ($query->num_rows() > 0 )? $query->result_array() : FALSE;
		}

		function get_unit($building_id) {
			$this->db->select('azha_unit.*, users.fullname as user_name');
			$this->db->join('users', 'azha_unit.user_id = users.id','left');
			$this->db->where('azha_unit.building_id', $building_id);
			$query = $this->db->get('azha_unit');
			return ($query->num_rows() > 0 )? $query->result_array() : FALSE;
		}

		function create_unit($data) {
			$this->load->database();
			$this->db->insert('azha_unit', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function azha_sign (){
  			$this->load->database();
			$this->db->select('azha_role.*');
			$query = $this->db->get('azha_role');
			return $query->result_array();  	
		}

		function azha_do_sign($azha_id){
  	 		$this->load->database();
			$this->db->select('azha_signature.*');
			$this->db->where('azha_signature.azha_id', $azha_id);	
        	$this->db->order_by('azha_signature.rank');
			$query = $this->db->get('azha_signature');
			return $query->num_rows();  	
		}

		function add_signature($azha_id, $role_id, $department_id,  $rank){
	    	$this->load->database();
			$query = $this->db->query('INSERT INTO azha_signature(azha_id, role_id, department_id, rank) VALUES("'.$azha_id.'", "'.$role_id.'", "'.$department_id.'", "'.$rank.'")');
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
  		}

  		function create_azha($data) {
			$this->load->database();
			$this->db->insert('azha', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function update_files($assumed_id, $azha_id) {
  			$this->load->database();
  			$this->db->query('UPDATE azha_filles SET azha_id = "'.$azha_id.'" WHERE azha_id = "'.$assumed_id.'"');
  		}

  		function add_building($azha_id, $buildings_id) {
	  		$this->load->database();
	  		$this->db->query('INSERT INTO azha_building(azha_id,buildings_id) VALUES("'.$azha_id.'","'.$buildings_id.'")');
  		}

  		function get_buildings(){
	    	$this->load->database();
			$this->db->select('azha_buildings.*');
        	$this->db->order_by('name');
			$query = $this->db->get('azha_buildings');
			return $query->result_array();
  		}

  		function get_by_fille($azha_id){
	    	$this->load->database();
			$this->db->select('azha_filles.*, users.fullname as user_name');
			$this->db->join('users', 'azha_filles.user_id = users.id','left');
			$this->db->where('azha_id', $azha_id);
			$query = $this->db->get('azha_filles');
			return $query->result_array();
  		}

  		function clear_unit($building_id) {
	  		$this->load->database();
	  		$this->db->where('azha_unit.building_id', $building_id);		
			$this->db->delete('azha_unit');
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
  		}

  		function clear_azha($azha_id) {
	  		$this->load->database();
	  		$this->db->where('azha.id', $azha_id);		
			$this->db->delete('azha');
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
  		}

  		function clear_building($azha_id) {
	  		$this->load->database();
	  		$this->db->where('azha_building.azha_id', $azha_id);		
			$this->db->delete('azha_building');
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
  		}

  		function clear_fille($azha_id) {
	  		$this->load->database();
	  		$this->db->where('azha_filles.azha_id', $azha_id);		
			$this->db->delete('azha_filles');
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
  		}

	}

?>