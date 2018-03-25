<?php
class Workshop_requests_model extends CI_Model{
	
  	function __contruct(){
		parent::__construct;
	}

	function view_requests($user_hotels = FALSE) {
  	  	$this->load->database();

  	  	$this->db->select('workshop_requests.id, workshop_requests.name,workshop_requests.done, from_hotels.name AS from_hotel, workshop_requests.hotel_id, workshop_requests.state_id, users.fullname AS user_name, orders.id As order_id, orders.state_id As order_state');

  		$this->db->join('hotels AS from_hotels','workshop_requests.hotel_id = from_hotels.id');
  		$this->db->join('workshop_orders AS orders','workshop_requests.id = orders.request_id', 'left');
  	  	$this->db->join('users','workshop_requests.user_id = users.id');
  	  	
        if ($user_hotels) {
          $this->db->where_in('workshop_requests.hotel_id', $user_hotels);
        }

        $this->db->order_by('workshop_requests.timestamp', 'DESC');

	
		$query = $this->db->get('workshop_requests');

		return $query->result_array();
	}
        
	function update_state($request_id, $state) {
		$this->db->update('workshop_requests', array('state_id'=> $state), "id = ".$request_id);
	}

	function update_stage($request_id) {
    $this->db->update('workshop_requests', array('state_id'=> 7), "id = ".$request_id);
  }

  function update_remark($request_id, $remark) {
		$this->db->update('workshop_requests', array('remarks'=> $remark), "id = ".$request_id);
	}


	function getrequest($request_id) {
  	$this->load->database();
  	$this->db->select('workshop_requests.id,workshop_requests.done, workshop_requests.user_id, workshop_requests.remarks, workshop_requests.state_id, workshop_requests.hotel_id, workshop_requests.timestamp, workshop_requests.name, from_hotels.name AS from_hotel, from_hotels.logo AS hotel_logo');

  	$this->db->join('hotels AS from_hotels','workshop_requests.hotel_id = from_hotels.id');
 	  $this->db->where('workshop_requests.id', $request_id);
		$query = $this->db->get('workshop_requests');
		return ($query->num_rows() > 0 )? $query->row_array() : FALSE;


	}
	function create($data) {
		$this->db->insert('workshop_requests', $data);

		return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;

	}

	function update($id) {

		$this->db->where('id', $id);
		$this->db->update('workshop_requests', array('done'=> 1));

		return ($this->db->affected_rows() == 1)? TRUE : FALSE;

	}

}
?>
