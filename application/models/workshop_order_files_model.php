<?php

class Workshop_order_files_model extends MY_Model{
	
  	function __contruct(){
		parent::__construct;
		// $this->load->helper('url');
  	}
	
  	function getall(){
	    $this->load->database();
		
		$query = $this->db->get('workshop_order_files');
		return $query->result_array();
  	}

  	function getby_order($order_id){
	    $this->load->database();
		
		$this->db->where('order_id', $order_id);
		$query = $this->db->get('workshop_order_files');
		return $query->result_array();
  	}

  	function add($order_id, $name) {
  		$this->load->database();

  		$this->db->query('INSERT INTO workshop_order_files(order_id,name) VALUES("'.$order_id.'","'.$name.'")');

  	}

    function remove($id) {
      $this->load->database();

      $this->db->query('DELETE FROM workshop_order_files WHERE id = '.$id);

    }

  	function update_files($assumed_code, $order_id) {
  		$this->load->database();

  		$this->db->query('UPDATE workshop_order_files SET order_id = "'.$order_id.'" WHERE order_id = "'.$assumed_code.'"');

  	}

    function viewby_order($request_id){
      $this->load->database();
        $this->db->select('workshop_order_files.id, workshop_order_files.name, workshop_order_files.order_id, workshop_orders.request_id, workshop_orders.id');
        $this->db->join('workshop_orders', 'workshop_order_files.order_id = workshop_orders.id');
        $this->db->join('workshop_requests', 'workshop_orders.request_id = workshop_requests.id');

      $this->db->where_in('workshop_orders.request_id', $request_id);
    $query = $this->db->get('workshop_order_files');
    return $query->result_array();
    }

}
?>
