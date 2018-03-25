<?php

class res_file extends MY_Model{

  	function __contruct(){
		parent::__construct;
		// $this->load->helper('url');
  	}

  	function getall(){
	    $this->load->database();

		$query = $this->db->get('res_files');
		return $query->result_array();
  	}

  	function getby_res($res_id){
	    $this->load->database();

		$this->db->where('res_id', $res_id);
		$query = $this->db->get('res_files');
		return $query->result_array();
  	}

  	function add($res_id, $name) {
  		$this->load->database();

  		$this->db->query('INSERT INTO res_files(res_id,name) VALUES("'.$res_id.'","'.$name.'")');

  	}

    function remove($id) {
      $this->load->database();

      $this->db->query('DELETE FROM res_files WHERE id = '.$id);

    }

  	function update_files($assumed_code, $res_id) {
  		$this->load->database();

  		$this->db->query('UPDATE res_files SET res_id = "'.$res_id.'" WHERE res_id = "'.$assumed_code.'"');

  	}
}
?>
