<?php
	class Project_items_model extends CI_Model{
	
	  	function __contruct(){
			parent::__construct;
		}

		function create($data) {
			$this->db->insert('projects_items', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function get_items_details($project_id) {
			$this->db->select('projects_items.quantity, plan_items.name, plan_items.value');
			$this->db->where('project_id', $project_id);
			$this->db->join('plan_items', 'projects_items.item_id = plan_items.id');
			$query = $this->db->get('projects_items');
			return ($query->num_rows() > 0 )? $query->result_array() : FALSE;
		}

	function get_project_items($project_id) {
		$this->db->where('project_id', $project_id);
		$query = $this->db->get('projects_items');

		return ($query->num_rows() > 0 )? $query->result_array() : FALSE;
	}

	function update($id, $data) {

		// die(print_r($data));

		$this->db->where('id', $id);
		$this->db->update('projects_items', $data);

		return ($this->db->affected_rows() == 1)? TRUE : FALSE;

	}
}
?>
