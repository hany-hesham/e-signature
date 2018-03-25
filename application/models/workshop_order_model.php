<?php
class Workshop_order_model extends CI_Model{
	
  	function __contruct(){
		parent::__construct;
	}

     function getorder($order_id) {
  	  	$this->load->database();
  	  	$this->db->select('workshop_orders.id, workshop_orders.state_id, workshop_orders.request_id, workshop_orders.remarks, workshop_orders.delivery_date,workshop_orders.request_id, hotels.name As hotel_name,  workshop_requests.hotel_id ,workshop_requests.timestamp');
		$this->db->join('workshop_requests', 'workshop_requests.id = workshop_orders.request_id', 'left');
		$this->db->join('hotels', 'hotels.id = workshop_requests.hotel_id', 'left');
 	  	$this->db->where('workshop_orders.id', $order_id);
		$query = $this->db->get('workshop_orders');
		return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
	}

/*    function get_order_id($order_id) {
  	  	$this->load->database();
  	  	$this->db->select('workshop_orders.id, workshop_orders.remarks, workshop_orders.delivery_date,workshop_orders.request_id');
 	  	$this->db->where('workshop_orders.id', $order_id);
		$query = $this->db->get('workshop_orders');
		return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
	}
*/

    function view_order($request_id) {
  	  	$this->load->database();
  	  	$this->db->select('workshop_orders.id, workshop_orders.remarks, workshop_orders.state_id, workshop_orders.delivery_date,workshop_orders.request_id, hotels.name As hotel_name, workshop_requests.name, workshop_requests.hotel_id ,workshop_requests.timestamp');
		$this->db->join('workshop_requests', 'workshop_orders.request_id = workshop_requests.id');
		$this->db->join('hotels', 'hotels.id = workshop_requests.hotel_id');
		// $this->db->join('workshop_request_log', 'workshop_request_log.order_id = workshop_orders.id');
 	  	$this->db->where('workshop_orders.request_id', $request_id);
		$query = $this->db->get('workshop_orders');
		return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
	}



	function create($data) {
		$this->db->insert('workshop_orders', $data);

		return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;

	}

	function update_state($order_id, $state) {
		$this->db->update('workshop_orders', array('state_id'=> $state), "id = ".$order_id);
	}

	function update_stage($order_id) {
    $this->db->update('workshop_orders', array('state_id'=> 7), "id = ".$order_id);
  }

	function update_by_id($order_id, $data) {
		$this->db->where('id', $order_id);
		$this->db->update('workshop_orders', $data);
		$data['order_id'] = $order_id;
		$this->db->insert('workshop_request_log', $data);

	}

	function update_remark($order_id, $remark) {
		$this->db->update('workshop_orders', array('remarks'=> $remark), "id = ".$order_id);
	}

	function get_request($id) {
		$this->db->select('request_id');
		$this->db->where('id', $id);
		$query = $this->db->get('workshop_orders');

		$result = $query->result_array();
		return $result[0]['request_id'];
	}

	function get_log($order_id) {
		$this->db->select('created, order_id, delivery_date');
		$this->db->where('order_id', $order_id);
		$query = $this->db->get('workshop_request_log');

		$result = $query->result_array();
		return $result;
	}


	function view_order_log($request_id) {
        $this->load->database();
        $this->db->select('workshop_orders.request_id, workshop_request_log.created, workshop_request_log.delivery_date, workshop_orders.request_id, workshop_orders.id');
		$this->db->join('workshop_orders', 'workshop_request_log.order_id = workshop_orders.id');
		$this->db->join('workshop_requests', 'workshop_orders.request_id = workshop_requests.id');

 	  	$this->db->where_in('workshop_orders.request_id', $request_id);
		$query = $this->db->get('workshop_request_log');

		$result = $query->result_array();
		return $result;
	}



}
?>
