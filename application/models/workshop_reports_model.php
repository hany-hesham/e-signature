<?php
class Workshop_reports_model extends CI_Model{
	
  	function __contruct(){
		parent::__construct;
	}

  function get_requests($states, $hotel_id, $from, $to) {
        $this->load->database();

        $this->db->select('workshop_requests.id,workshop_requests.timestamp,workshop_requests.done, workshop_requests.name, workshop_requests.hotel_id, workshop_requests.state_id, workshop_requests.remarks');

        // $this->db->join('workshop_orders AS orders','workshop_requests.id = orders.request_id');

        // $this->db->join('project_origins','projects.origin_id = project_origins.id');
        
        $this->db->where_in('workshop_requests.done', $states);
        $this->db->where('workshop_requests.hotel_id', $hotel_id);
        $this->db->where('workshop_requests.timestamp >=', $from);
        $this->db->where('workshop_requests.timestamp <=', $to);

        $this->db->order_by('timestamp', 'ASC');
  
    $query = $this->db->get('workshop_requests');

    return $query->result_array();
  }

  function get_all_requests($states, $from, $to) {
        $this->load->database();

        $this->db->select('workshop_requests.id,workshop_requests.remarks,workshop_requests.timestamp, workshop_requests.name,workshop_requests.done, workshop_requests.hotel_id, workshop_requests.state_id, from_hotels.name AS from_hotel');

        $this->db->join('hotels AS from_hotels','workshop_requests.hotel_id = from_hotels.id');
        // $this->db->join('workshop_orders AS orders','orders.request_id = workshop_requests.id', 'LEFT');

        
        $this->db->where_in('workshop_requests.done', $states);
        $this->db->where('workshop_requests.timestamp >=', $from);
        $this->db->where('workshop_requests.timestamp <=', $to);
        // $this->db->where('projects.deleted', 0);

        $this->db->order_by('timestamp', 'ASC');
  
    $query = $this->db->get('workshop_requests');

    return $query->result_array();
  }

    function get_all($from = FALSE, $to = FALSE, $hotel_id = FALSE) {
        $this->load->database();
        $this->db->select('workshop_requests.*, from_hotels.name AS from_hotel');
        $this->db->join('hotels AS from_hotels','workshop_requests.hotel_id = from_hotels.id');
        if ($hotel_id) {
            $this->db->where('workshop_requests.hotel_id', $hotel_id);
        }
        if ($from) {
            $this->db->where('workshop_requests.timestamp >=', $from);
        }
        if ($to) {
            $this->db->where('workshop_requests.timestamp <=', $to);
        }
        $this->db->order_by('workshop_requests.timestamp', 'ASC');
        $query = $this->db->get('workshop_requests');
        return $query->result_array();
    }

    function get_sign($id) {
        $this->load->database();
        $this->db->select('workshop_request_signatures.*');
        $this->db->where('workshop_request_signatures.request_id', $id);
        $this->db->order_by('workshop_request_signatures.rank', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('workshop_request_signatures');
        return $query->row_array();
    }

    function get_order($id) {
        $this->load->database();
        $this->db->select('workshop_orders.*');
        $this->db->where('workshop_orders.request_id', $id);
        $this->db->order_by('workshop_orders.timestamp', 'ASC');
        $this->db->limit(1);
        $query = $this->db->get('workshop_orders');
        return $query->row_array();
    }

    function get_order_sign($id) {
        $this->load->database();
        $this->db->select('workshop_order_signatures.*');
        $this->db->where('workshop_order_signatures.order_id', $id);
        $this->db->order_by('workshop_order_signatures.rank', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('workshop_order_signatures');
        return $query->row_array();
    }

    function get_request_hotel_sign($id) {
        $this->load->database();
        $this->db->select('workshop_request_approvals.*');
        $this->db->where('workshop_request_approvals.request_id', $id);
        $this->db->order_by('workshop_request_approvals.rank', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('workshop_request_approvals');
        return $query->row_array();
    }

    function get_reciver($id) {
        $this->load->database();
        $this->db->select('workshop_request_reciver.*');
        $this->db->where('workshop_request_reciver.request_id', $id);
        $this->db->order_by('workshop_request_reciver.created', 'ASC');
        $this->db->limit(1);
        $query = $this->db->get('workshop_request_reciver');
        return $query->row_array();
    }
}
?>
