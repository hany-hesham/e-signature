<?php
class Madar_owning_model extends CI_Model{
	
  	function __contruct(){
		parent::__construct;
	}

	function get_project($project_id) {
  	  	$this->load->database();

  	  	$this->db->select('madar_owning_form.id, madar.name AS project_name, companies.name AS company_name, madar.scope, madar.timestamp AS time, madar.budget,
                          hotels.company_id, hotels.name AS hotel_name, hotels.id AS hotel_id, madar_owning_form.date, place, num_of_offers,
                          total_cost, sup_1, sup_2, sup_3, sup_4, sup_5, sup_6, consultant,
                          recommendation, balance, purchasing_notes, financial_notes');

  
    $this->db->join('madar', 'madar_owning_form.project_id = madar.id');
    $this->db->join('hotels','madar.hotel_id = hotels.id');
    $this->db->join('companies','hotels.company_id = companies.id');

    $this->db->where('madar_owning_form.project_id', $project_id);
		
    $query = $this->db->get('madar_owning_form');

		return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
	}


  function get_projects($user_hotels = FALSE) {
        $this->load->database();

        $this->db->select('madar.id, madar.name AS project_name, hotels.name AS hotel_name,
                          madar.hotel_id, users.fullname AS user_name, madar.budget');

        $this->db->join('hotels','madar.hotel_id = hotels.id');
        $this->db->join('users','madar.user_id = users.id');
        $this->db->join('madar_owning_form','madar_owning_form.project_id = madar.id');
        // $this->db->join('project_signatures AS chairman_signature','chairman_signature.project_id = madar.id AND chairman_signature.role_id = 2', "left");
        
        if ($user_hotels) {
          $this->db->where_in('madar.hotel_id', $user_hotels);
        }

        // $this->db->where_in('madar.state_id', $states);
        // $this->db->where('madar_owning_form.date IS NOT NULL', NULL, FALSE);
        $this->db->where('madar.deleted', 0);
        // $this->db->where('(chairman_signature.id IS NOT NULL OR madar.hotel_id = 5)');

        $this->db->order_by('madar.timestamp', 'DESC');

  
    $query = $this->db->get('madar');

    return $query->result_array();
  }

  function update($id, $data) {
    $this->db->where('project_id', $id);
    $this->db->update('madar_owning_form', $data);

    return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  }

  function create($data) {
    $this->db->insert('madar_owning_form', $data);

    return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;

  }

  function get_project_company($project_id) {
    $this->load->database();

    $this->db->select('company_id');

    $this->db->join('hotels','madar.hotel_id = hotels.id');

    $this->db->where('madar.id', $project_id);

    $query = $this->db->get('madar');

    return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  }

  function get_project_hotel($project_id) {
    $this->load->database();

    $this->db->select('hotels.id AS hotel_id, hotels.name AS hotel_name');

    $this->db->join('hotels','madar.hotel_id = hotels.id');

    $this->db->where('madar.id', $project_id);

    $query = $this->db->get('madar');

    return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  }


}
?>
