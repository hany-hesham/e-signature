<?php
class Devisions_model extends CI_Model{
	
  	function __contruct(){
		parent::__construct;
		// $this->load->helper('url');
  	}
	
  	function getall(){
	    $this->load->database();
		
		$this->db->order_by('rank');
		$query = $this->db->get('devisions');
		return $query->result_array();
  	}

  	function get_by_id($id){
	    $this->load->database();
		
		$this->db->where('id', $id);
		$query = $this->db->get('devisions');
		return $query->result_array();
  	}
}
?>
