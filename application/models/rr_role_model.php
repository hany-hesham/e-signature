<?php
class rr_role_model extends CI_Model{

  	function __contruct(){
		parent::__construct;
		// $this->load->helper('url');
  	}

  	function getall(){
	    $this->load->database();
		$query = $this->db->get('rr_role');
		return $query->result_array();
  	}

	function getby_rr($type){
		$this->load->database();
		$this->db->where('type', $type);
		$query = $this->db->get('rr_role');
		return $query->result_array();
	}

	function reset_rr($type){
		$this->load->database();
		$query = $this->db->query('DELETE FROM rr_role WHERE type = "'.$type.'"');
		return TRUE;
	}

	function add_role_rr($type, $role, $rank){
		$this->load->database();
		$query = $this->db->query('INSERT INTO rr_role(type, role, rank) VALUES("'.$type.'", "'.$role.'", "'.$rank.'")');
			return $this->db->insert_id();
		}

		function add_department_rr($type, $department, $id) {
			$this->db->update('rr_role', array('department'=> $department), "id = ".$id);
		}

}
?>
