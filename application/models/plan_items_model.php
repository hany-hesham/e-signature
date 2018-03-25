<?php
class Plan_items_model extends CI_Model{
	
  	function __contruct(){
		parent::__construct;
	}

	function get_plan_items($plan_id) {
		$this->db->select('plan_items.id, plan_items.name, plan_items.quantity, plan_items.value, plan_items.remarks, plan_items.code, plan_items.department_id, plan_items.priority_id, plan_items.cancelled, departments.devision_id');
		$this->db->join('departments', 'plan_items.department_id = departments.id');
		$this->db->where('plan_id', $plan_id);
		$this->db->order_by('plan_items.priority_id');
		$query = $this->db->get('plan_items');

		return ($query->num_rows() > 0 )? $query->result_array() : FALSE;
	}

	function getall_items(){
	    	$this->load->database();
			$query = $this->db->get('plan_items');
			return $query->result_array();
  		}

	function get_items($item, $year) {
		$this->db->select('plan_items.*, plans.hotel_id, plans.year, hotels.name as hotel_name');
		$this->db->like('plan_items.name', $item);
		$this->db->join('plans', 'plan_items.plan_id = plans.id');
		$this->db->join('hotels', 'plans.hotel_id = hotels.id');
		//$this->db->where('plan_items.name', $item);
		$this->db->where('plans.year', $year);
		$this->db->order_by('plan_items.priority_id');
		$query = $this->db->get('plan_items');

		return ($query->num_rows() > 0 )? $query->result_array() : FALSE;
	}

	function get_hotel_items($department, $year, $hotel) {
		$this->db->select('plan_items.*, plans.hotel_id, plans.year, hotels.name as hotel_name, departments.name as department');
		$this->db->join('plans', 'plan_items.plan_id = plans.id');
		$this->db->join('hotels', 'plans.hotel_id = hotels.id');
		$this->db->join('departments', 'plan_items.department_id = departments.id');
		$this->db->where('plan_items.department_id', $department);
		$this->db->where('plans.hotel_id', $hotel);
		$this->db->where('plans.year', $year);
		$this->db->order_by('plans.hotel_id');
		$query = $this->db->get('plan_items');

		return ($query->num_rows() > 0 )? $query->result_array() : FALSE;
	}

	function get_department_items($department, $year) {
		$this->db->select('plan_items.*, plans.hotel_id, plans.year, hotels.name as hotel_name, departments.name as department');
		$this->db->join('plans', 'plan_items.plan_id = plans.id');
		$this->db->join('hotels', 'plans.hotel_id = hotels.id');
		$this->db->join('departments', 'plan_items.department_id = departments.id');
		$this->db->where('plan_items.department_id', $department);
		$this->db->where('plans.year', $year);
		$this->db->order_by('plans.hotel_id');
		$query = $this->db->get('plan_items');

		return ($query->num_rows() > 0 )? $query->result_array() : FALSE;
	}

	function getall_departments(){
		$this->load->database();
		$query = $this->db->get('departments');
		return $query->result_array();
	}

	function get_department($department){
		$this->load->database();
		$this->db->select('departments.*');
		$this->db->where('departments.id', $department);
		$query = $this->db->get('departments');
		return $query->result_array();
	}
	function get_hotel($hotel){
		$this->load->database();
		$this->db->select('hotels.*');
		$this->db->where('hotels.id', $hotel);
		$query = $this->db->get('hotels');
		return $query->result_array();
	}

	function get_selective_items($plan_id, $department_id) {
		
		$this->db->select('id, name, remarks, code, quantity - used AS remaining');
		
		$this->db->where('plan_id', $plan_id);
		$this->db->where('department_id', $department_id);
		$this->db->where('cancelled !=', '1');
		$query = $this->db->get('plan_items');

		return ($query->num_rows() > 0 )? $query->result_array() : FALSE;
	}

	function get_items_by_id($items) {
		
		$this->db->select('id, name, value, remarks, code, quantity - used AS remaining');
		
		$this->db->where_in('id', $items);
		$query = $this->db->get('plan_items');

		return ($query->num_rows() > 0 )? $query->result_array() : FALSE;
	}

	function create($data) {
		$this->db->insert('plan_items', $data);

		return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;

	}

	function update($id, $data) {

		// die(print_r($data));

		$this->db->where('id', $id);
		$this->db->update('plan_items', $data);

		return ($this->db->affected_rows() == 1)? TRUE : FALSE;

	}

	function used($id, $use) {
		$this->db->query('UPDATE plan_items SET used = used+"'.$use.'" WHERE id = "'.$id.'"');
		return ($this->db->affected_rows() == 1)? TRUE : FALSE;
	}

	function get_code($id) {
		$this->db->select('code');
		$this->db->where('id', $id);
		$query = $this->db->get('plan_items');

		$result = $query->result_array();
		return $result[0]['code'];
	}

	function get_department_count($plan_id, $department_id) {
		$this->db->select('code');
		$this->db->where('plan_id', $plan_id);
		$this->db->where('department_id', $department_id);
		$this->db->order_by('id DESC');
		$query = $this->db->get('plan_items');

		$result = $query->result_array();
		return ($query->num_rows() > 0 )? $result[0]['code'] : FALSE;
	}

	function delete($id) {

		$this->db->where('id', $id);
		$this->db->delete('plan_items');
		return ($this->db->affected_rows() == 1)? TRUE : FALSE;
	}

}
?>
