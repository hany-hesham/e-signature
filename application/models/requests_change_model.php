<?php

class requests_change_model extends CI_Model{
		
    function __contruct(){
			parent::__construct;
		}
	function get_request($id) {
	      	$this->load->database();
	      	$this->db->select('projects_change.id, projects_change.project_id, projects_change.timestamp, projects_change.code, projects_change.name AS project_name, reasons, remarks, projects_change.state_id, projects_change.user_id, projects_change.EUR_EX, projects_change.USD_EX, projects_change.budget_EGP, projects_change.budget_USD, projects_change.budget_EUR, projects_change.budget, projects_change.cost_EGP, projects_change.cost_USD, projects_change.cost_EUR, projects_change.cost, projects_change.start, projects_change.end, projects_change.deleted, projects_change.scope, projects_change.year');
	        $this->db->where('projects_change.project_id', $id);
	        $this->db->where('projects_change.deleted', 0);
	      	$query = $this->db->get('projects_change');
	      	return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
	    }

	function delete_request($id) {
	      	$this->db->update('projects_change', array('deleted'=> 1), "id = ".$id);
	    }

	function create($data) {
			$this->db->insert('projects_change', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}    
	
	}	

?>