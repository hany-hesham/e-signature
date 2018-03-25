<?php
class Departments_model extends CI_Model{
	
  	function __contruct(){
		parent::__construct;
		// $this->load->helper('url');
  	}
	
  	function getall(){
	    $this->load->database();
		
		$query = $this->db->get('departments');
		return $query->result_array();
  	}

  	function get_code($id){
	    $this->load->database();
		$this->db->select("code");
		$this->db->where("id", $id);
		$query = $this->db->get('departments');
		return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  	}


  	function get_by_id($id){
	    $this->load->database();
		$this->db->where("id", $id);
		$query = $this->db->get('departments');
		return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  	}

  	function getby_devision($devision_id){
	    $this->load->database();
		$this->db->where('devision_id', $devision_id);
		$this->db->where('dummy', 0);
		$this->db->order_by('rank');
		$query = $this->db->get('departments');

		return $query->result_array();
  	}
}
?>
