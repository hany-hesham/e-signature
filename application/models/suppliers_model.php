<?php

	class Suppliers_model extends MY_Model{
	
	  	function __contruct(){
			parent::__construct;
	  	}

	  	function getall(){
		    $this->load->database();
			$query = $this->db->get('suppliers');
			return $query->result_array();
	  	}

	  	function clear($project_id, $projects_change_id) {
	  		$this->load->database();
	  		$this->db->query('DELETE FROM projects_suppliers WHERE project_id = "'.$project_id.'" AND change_amend = "'.$projects_change_id.'"');
	  	}

	  	function add($project_id, $supplier_id, $projects_change_id) {
	  		$this->load->database();
	  		$this->db->query('INSERT INTO projects_suppliers(project_id,supplier_id, change_amend) VALUES("'.$project_id.'","'.$supplier_id.'","'.$projects_change_id.'")');
	  	}

  		function getby_project($project_id, $projects_change_id){
	    	$this->load->database();
			$this->db->where('project_id', $project_id);
			$this->db->where('change_amend', $projects_change_id);
			$this->db->join('suppliers','projects_suppliers.supplier_id = suppliers.id');
			$query = $this->db->get('projects_suppliers');
			return $query->result_array();
	  	}

	}

?>
