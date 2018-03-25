<?php

  class Offers_model extends MY_Model{
	
  	function __contruct(){
  		parent::__construct;
    }

    function getall(){
      $this->load->database();
      $query = $this->db->get('offers');
      return $query->result_array();
    }

    function update_offers($assumed_code, $project_id) {
      $this->load->database();
      $this->db->query('UPDATE offers SET project_id = "'.$project_id.'" WHERE project_id = "'.$assumed_code.'"');
    }

    function getby_project($project_id, $change){
      $this->load->database();
      $this->db->where('project_id', $project_id);
      $this->db->where('projects_change_id', $change);
      $query = $this->db->get('offers');
      return $query->result_array();
    }

    function add($project_id, $name, $change) {
      $this->load->database();
      $this->db->query('INSERT INTO offers(project_id, name, projects_change_id) VALUES("'.$project_id.'","'.$name.'","'.$change.'")');
    }

    function remove($id) {
      $this->load->database();
      $this->db->query('DELETE FROM offers WHERE id = '.$id);
    }

  }

?>
