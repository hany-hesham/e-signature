<?php
class roles_model_res extends CI_Model{

  	function __contruct(){
		parent::__construct;
		// $this->load->helper('url');
  	}

  	function getall(){
	    $this->load->database();

		$query = $this->db->get('role_reservation');
		return $query->result_array();
  	}


		function getby_res($res_id){
			$this->load->database();

		$this->db->where('res_type', $res_id);
		$this->db->order_by('rank');
		$query = $this->db->get('role_reservation');

		return $query->result_array();
		}

		function reset_res($res_type){
			$this->load->database();
		$query = $this->db->query('DELETE FROM role_reservation WHERE res_type = "'.$res_type.'"');

		return TRUE;
		}

		function add_role_res($res_type, $role, $rank){
			$this->load->database();
		$query = $this->db->query('INSERT INTO role_reservation(res_type, role, rank) VALUES("'.$res_type.'", "'.$role.'", "'.$rank.'")');

		return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

}
?>
