<?php
class Items_model extends CI_Model{
	
  	function __contruct(){
		parent::__construct;
	}

	function get_form_items($form_id) {
		$this->db->where('form_id', $form_id);
		$this->db->select('items.*,users.fullname');
	    $this->db->join('users','items.deliver_user_id=users.id','left');
		$query = $this->db->get('items');

		return ($query->num_rows() > 0 )? $query->result_array() : FALSE;
	}

	function get_items($id) {
		$this->db->where('id', $id);
		$query = $this->db->get('items');

		return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
	}

	function create($data) {
		$this->db->insert('items', $data);

		return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;

	}

	function update_item($data, $form_id, $id) {
		$this->load->database();
		$this->db->where('items.id', $id);		
		$this->db->where('items.form_id', $form_id);		
		$this->db->update('items', $data);
		return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
	}
  //   function add_delivered($item_id, $state) {
		// 	$this->db->update('items', array('deliver'=> $state), "id = ".$item_id);
		// }
	function add_delivered($data) {
			$this->load->database();
			$this->db->insert('form_item_deliver', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

	function get_form_item_deliver($id) {
		$this->db->where('item_id', $id);
		$this->db->select('form_item_deliver.*,users.fullname As fname');
        $this->db->join('users','form_item_deliver.user_id=users.id','left');
		$query = $this->db->get('form_item_deliver');

		return ($query->num_rows() > 0 )? $query->result_array() : FALSE;
	}			
}
?>
