<?php
class Workshop_order_items_model extends CI_Model{
	
  	function __contruct(){
		parent::__construct;
	}

        function get_order_items($order_id) {
        $this->load->database();
		$this->db->where('workshop_order_items.order_id', $order_id);
		$query = $this->db->get('workshop_order_items');

		return ($query->num_rows() > 0 )? $query->result_array() : FALSE;
	}

        function view_order_items($request_id) {
        $this->load->database();
        $this->db->select('workshop_order_items.id, workshop_order_items.description, workshop_order_items.quantity, workshop_order_items.unit, workshop_order_items.price, workshop_order_items.remarks, workshop_order_items.order_id, workshop_orders.request_id, workshop_orders.id');
		$this->db->join('workshop_orders', 'workshop_order_items.order_id = workshop_orders.id');
		$this->db->join('workshop_requests', 'workshop_orders.request_id = workshop_requests.id');

 	  	$this->db->where_in('workshop_orders.request_id', $request_id);
		$query = $this->db->get('workshop_order_items');

		return ($query->num_rows() > 0 )? $query->result_array() : FALSE;
	}



	function create($data) {
		$this->db->insert('workshop_order_items', $data);

		return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;

	}


	function update_by_id($order_id, $data) {
		$this->db->where('workshop_order_items.order_id', $order_id);
		$this->db->update('workshop_order_items', $data);
	}

	function update($id, $data) {

		$this->db->where('id', $id);
		$this->db->update('workshop_order_items', $data);

		return ($this->db->affected_rows() == 1)? TRUE : FALSE;

	}
	function get_order($id) {
		$this->db->select('order_id');
		$this->db->where('id', $id);
		$query = $this->db->get('workshop_order_items');

		$result = $query->result_array();
		return $result[0]['order_id'];
	}
	
	function delete($id) {

		$this->db->where('id', $id);
		$this->db->delete('workshop_order_items');
		return ($this->db->affected_rows() == 1)? TRUE : FALSE;
	}

}
?>
