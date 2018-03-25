<?php

	class Spo_competition_model extends CI_Model{
	
  		function __contruct(){
			parent::__construct;
		}

		function create_competition($data) {
			$this->db->insert('competition_survey', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function get_spo_competition($request_id) {
        	$this->load->database();
			$this->db->where('competition_survey.spo_id', $request_id);
			$query = $this->db->get('competition_survey');
			return ($query->num_rows() > 0 )? $query->result_array() : FALSE;
		}

		function update_competition($data, $spo_id, $competition_id) {
			$this->load->database();
			$this->db->where('competition_survey.spo_id', $spo_id);	
			$this->db->where('competition_survey.id', $competition_id);		
			$this->db->update('competition_survey', $data);
			$query = $this->db->get('competition_survey');
			return $query;
		}
		
	}
?>