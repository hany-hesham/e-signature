<?php
class upgrad_role_model extends CI_Model{

  	function __contruct(){
		parent::__construct;
		// $this->load->helper('url');
  	}

  	function getall(){
	    $this->load->database();
		$query = $this->db->get('upgrad_role');
		return $query->result_array();
  	}

	function getby_upgrad($type){
		$this->load->database();
		$this->db->where('up_type', $type);
		$query = $this->db->get('upgrad_role');
		return $query->result_array();
	}

	function reset_upgrad($type){
		$this->load->database();
		$query = $this->db->query('DELETE FROM upgrad_role WHERE up_type = "'.$type.'"');
		return TRUE;
	}

	function add_role_upgrad($type, $role, $rank){
		$this->load->database();
		$query = $this->db->query('INSERT INTO upgrad_role(up_type, role, rank) VALUES("'.$type.'", "'.$role.'", "'.$rank.'")');
			return $this->db->insert_id();
		}

		function add_department_upgrad($type, $department, $id) {
			$this->db->update('upgrad_role', array('department'=> $department), "id = ".$id);
		}

}
?>
