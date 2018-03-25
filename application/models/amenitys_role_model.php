<?php
	class amenitys_role_model extends CI_Model{

	  	function __contruct(){
			parent::__construct;
			// $this->load->helper('url');
	  	}

	  	function getall(){
		    $this->load->database();
			$query = $this->db->get('amenitys_role');
			return $query->result_array();
	  	}

		function getby_amen($type){
			$this->load->database();
			$this->db->where('amen_type', $type);
			$this->db->order_by('rank');
			$query = $this->db->get('amenitys_role');
			return $query->result_array();
		}

		function reset_amen($type){
			$this->load->database();
			$query = $this->db->query('DELETE FROM amenitys_role WHERE amen_type = "'.$type.'"');
			return TRUE;
		}

		function add_role_amen($type, $role, $rank){
			$this->load->database();
			$query = $this->db->query('INSERT INTO amenitys_role(amen_type, role, rank) VALUES("'.$type.'", "'.$role.'", "'.$rank.'")');
			return $this->db->insert_id();
		}

		function add_department_amen($type, $department, $id) {
			$this->db->update('amenitys_role', array('department'=> $department), "id = ".$id);
		}

	}
?>
