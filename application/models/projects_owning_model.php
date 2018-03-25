<?php

  class Projects_owning_model extends CI_Model{
	
  	function __contruct(){
  		parent::__construct;
  	}

    function update_final($id, $state) {
      $this->db->update('project_owning_form', array('chairman'=> $state), "project_id = ".$id);
    }

	function get_project($project_id) {
  	  	$this->load->database();

  	  	$this->db->select('project_owning_form.id, project_owning_form.project_id, projects.code, projects.name AS project_name, companies.name AS company_name, projects.scope, projects.budget, projects.cost, projects.reasons, projects.start, projects.end,
                          hotels.company_id, hotels.name AS hotel_name, hotels.logo As logo, hotels.id AS hotel_id, project_owning_form.date, place, num_of_offers,
                          total_cost, sup_1, sup_2, sup_3, sup_4, sup_5, sup_6, consultant,
                          recommendation, balance, purchasing_notes, financial_notes, project_owning_form.date as timestamp');

  
    $this->db->join('projects', 'project_owning_form.project_id = projects.id');
    $this->db->join('hotels','projects.hotel_id = hotels.id');
    $this->db->join('companies','hotels.company_id = companies.id');
  	// $this->db->join('project_signatures','project_signatures.project_id = projects.id AND role_id = 16', 'left');

    $this->db->where('project_owning_form.project_id', $project_id);
		
    $query = $this->db->get('project_owning_form');

		return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
	}

  function update_hotel($id, $hotel_id) {
    $this->db->update('project_owning_form', array('hotel_id'=> $hotel_id), "project_id = ".$id);
  }


  function get_projects($states, $user_hotels = FALSE) {
        $this->load->database();

        $this->db->select('projects.id, projects.code, projects.name AS project_name, hotels.name AS hotel_name, departments.name AS department_name,
                          projects.hotel_id, projects.state_id, users.fullname AS user_name, projects.cost');

        $this->db->join('hotels','projects.hotel_id = hotels.id');
        $this->db->join('departments','projects.department_id = departments.id');
        $this->db->join('users','projects.user_id = users.id');
        $this->db->join('project_owning_form','project_owning_form.project_id = projects.id');
        $this->db->join('project_signatures AS chairman_signature','chairman_signature.project_id = projects.id AND chairman_signature.role_id = 2', "left");
        if ($user_hotels) {
          $this->db->where_in('projects.hotel_id', $user_hotels);
        }

        $this->db->where_in('projects.state_id', $states);
        $this->db->where('project_owning_form.date IS NOT NULL', NULL, FALSE);
        $this->db->where('projects.deleted', 0);
        //$this->db->where('(chairman_signature.id IS NOT NULL OR projects.hotel_id = 5)');
        //$this->db->or_where('(chairman_signature.id IS NOT NULL OR projects.hotel_id = 42)');
        $this->db->order_by('projects.timestamp', 'DESC');

  
    $query = $this->db->get('projects');

    return $query->result_array();
  }

  function get_owning_company_form($project_id) {
    $this->load->database();
    $this->db->select('project_owning_form.id');
    $this->db->where('project_owning_form.project_id', $project_id);
    $query = $this->db->get('project_owning_form');
    return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  }

  function update($id, $data) {
    $this->db->where('project_id', $id);
    $this->db->update('project_owning_form', $data);

    return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  }

  function create($data) {
    $this->db->insert('project_owning_form', $data);

    return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;

  }

  function get_project_company($project_id) {
    $this->load->database();

    $this->db->select('company_id, department_id, hotel_id');

    $this->db->join('hotels','projects.hotel_id = hotels.id');

    $this->db->where('projects.id', $project_id);

    $query = $this->db->get('projects');

    return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  }

  function get_company($hotel_id) {
    $this->load->database();

    $this->db->select('company_id, companies.name AS company_name');
    $this->db->join('companies','hotels.company_id = companies.id');
    $this->db->where('hotels.id', $hotel_id);

    $query = $this->db->get('hotels');

    return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  }

  function get_project_hotel($project_id) {
    $this->load->database();

    $this->db->select('projects.id, projects.name, projects.code, hotels.id AS hotel_id, hotels.name AS hotel_name');

    $this->db->join('hotels','projects.hotel_id = hotels.id');

    $this->db->where('projects.id', $project_id);

    $query = $this->db->get('projects');

    return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  }


}
?>
