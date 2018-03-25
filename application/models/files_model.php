<?php

class Files_model extends MY_Model{
	
  	function __contruct(){
		parent::__construct;
		// $this->load->helper('url');
  	}
	
  	function getall(){
	    $this->load->database();
		
		$query = $this->db->get('project_files');
		return $query->result_array();
  	}

  	function getby_project($project_id){
	    $this->load->database();
		
		$this->db->where('project_id', $project_id);
		$query = $this->db->get('project_files');
		return $query->result_array();
  	}

  	function add($project_id, $name) {
  		$this->load->database();

  		$this->db->query('INSERT INTO project_files(project_id,name) VALUES("'.$project_id.'","'.$name.'")');

  	}

    function remove($id) {
      $this->load->database();

      $this->db->query('DELETE FROM project_files WHERE id = '.$id);

    }

  	function update_files($assumed_code, $project_id) {
  		$this->load->database();

  		$this->db->query('UPDATE project_files SET project_id = "'.$project_id.'" WHERE project_id = "'.$assumed_code.'"');

  	}
}
?>
