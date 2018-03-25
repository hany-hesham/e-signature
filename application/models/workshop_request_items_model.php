<?php
class Workshop_request_items_model extends CI_Model{
	
  	function __contruct(){
		parent::__construct;
	}


        function get_request_items($request_id) {
        $this->load->database();
		$this->db->where('workshop_request_items.request_id', $request_id);
		$query = $this->db->get('workshop_request_items');

		return ($query->num_rows() > 0 )? $query->result_array() : FALSE;
	}
	function create($data) {
		$this->db->insert('workshop_request_items', $data);

		return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;

	}
		function update_by_id($request_id, $data) {
		$this->db->where('workshop_request_items.request_id', $request_id);
		$this->db->update('workshop_request_items', $data);
	}

	function update($id, $data) {

		$this->db->where('id', $id);
		$this->db->update('workshop_request_items', $data);

		return ($this->db->affected_rows() == 1)? TRUE : FALSE;

	}
	function get_request($id) {
		$this->db->select('request_id');
		$this->db->where('id', $id);
		$query = $this->db->get('workshop_request_items');

		$result = $query->result_array();
		return $result[0]['request_id'];
	}
	
	function delete($id) {

		$this->db->where('id', $id);
		$this->db->delete('workshop_request_items');
		return ($this->db->affected_rows() == 1)? TRUE : FALSE;
	}

}
?>
