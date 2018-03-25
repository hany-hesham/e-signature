<?php
class bd_use_role_model extends CI_Model{

  	function __contruct(){
		parent::__construct;
		// $this->load->helper('url');
  	}

  	function getall(){
	    $this->load->database();
		$query = $this->db->get('bd_use_role');
		return $query->result_array();
  	}

	function getby_bd_use($type){
		$this->load->database();
		$this->db->where('use_type', $type);
		$query = $this->db->get('bd_use_role');
		return $query->result_array();
	}

	function reset_bd_use($type){
		$this->load->database();
		$query = $this->db->query('DELETE FROM bd_use_role WHERE use_type = "'.$type.'"');
		return TRUE;
	}

	function add_role_bd_use($type, $role, $rank){
		$this->load->database();
		$query = $this->db->query('INSERT INTO bd_use_role(use_type, role, rank) VALUES("'.$type.'", "'.$role.'", "'.$rank.'")');
			return $this->db->insert_id();
		}

		function add_department_bd_use($type, $department, $id) {
			$this->db->update('bd_use_role', array('department'=> $department), "id = ".$id);
		}

}
?>
