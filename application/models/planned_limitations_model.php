<?php

	class Planned_limitations_model extends CI_Model{
		
	  	function __contruct(){
			parent::__construct;
	  	}
		
	  	function getall(){
		    $this->load->database();
			$query = $this->db->get('planned_limitations');
			return $query->result_array();
	  	}

	}

?>
