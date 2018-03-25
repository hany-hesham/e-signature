<?php
class Plans_model extends CI_Model{
	
  	function __contruct(){
		parent::__construct;
	}

	function update_state($id, $state) {
		$this->db->update('plans', array('state_id'=> $state), "id = ".$id);
	}

  function update_final($id, $state) {
    $this->db->update('plans', array('chairman'=> $state), "id = ".$id);
  }

  function update_message_id($id, $message_id) {
      $this->load->database();
      $this->db->where('plans.id', $id);
      //if(isset($message_id)){
      $msg_id = $this->db->update('plans', array('message_id' => $message_id));
      //die(print_r($msg_id));
      //}else{
              //die(print_r($message_id));
      //}
  }

	function get_request($id, $code = NULL) {
  	  	$this->load->database();

  	  	$this->db->select('projects.id, projects.name AS project_name, hotels.name AS hotel_name, reasons, remarks, project_types.name AS type_name, project_origins.name AS origin_name, departments.name AS department_name, projects.hotel_id, projects.state_id, projects.user_id');

  	  	$this->db->join('hotels','projects.hotel_id = hotels.id');
  	  	$this->db->join('project_types','projects.type_id = project_types.id');
  	  	$this->db->join('project_origins','projects.origin_id = project_origins.id');
  	  	$this->db->join('departments','projects.department_id = departments.id');
  	  	
  	  	if(!$id) {
  	  		$this->db->where('projects.code', $code);
  	  	} else {
  	  		$this->db->where('projects.id', $id);
  	  	}
  	  	$this->db->where('projects.deleted', 0);
	
		$query = $this->db->get('projects');

		return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
	}

	function get_plan($id) {
  	  	$this->load->database();

  	  	$this->db->select('plans.id, plans.message_id, plans.year, plans.total, plans.state_id, hotels.name AS hotel_name, hotels.logo AS hotel_logo, hotels.code AS hotel_code, plans.hotel_id, plans.user_id, plans.cf_pos, plans.year_pos');

  	  	$this->db->join('hotels','plans.hotel_id = hotels.id');
  	  	
  	  	$this->db->where('plans.id', $id);
  	  	$this->db->where('plans.deleted', 0);
	
		$query = $this->db->get('plans');

		return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
	}

  function get_hotel_plan($hotel_id, $year, $approved = FALSE) {
    $this->load->database();

    $this->db->select('plans.id, plans.state_id');

    $this->db->where('hotel_id', $hotel_id);
    $this->db->where('year', $year);
    
    if ($approved) {
      $this->db->where('state_id', '2');
    }

    $query = $this->db->get('plans');

    return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  }

	function get_plans($state_id, $user_hotels = FALSE) {
  	$this->load->database();

  	$this->db->select('plans.id, plans.year, hotels.name AS hotel_name, plans.hotel_id, plans.state_id, users.fullname AS user_name');

  	$this->db->join('hotels','plans.hotel_id = hotels.id');
  	$this->db->join('users','plans.user_id = users.id');
  	
    if ($user_hotels) {
      $this->db->where_in('plans.hotel_id', $user_hotels);
    }

  	$this->db->where('plans.deleted', 0);
    $this->db->where('plans.state_id', $state_id);

		$query = $this->db->get('plans');

		return $query->result_array();
	}

	function check_plan($hotel_id, $year) {
        $this->load->database();

        $this->db->select('id');
        $this->db->where('hotel_id', $hotel_id);
        $this->db->where('year', $year);
        $this->db->where('plans.deleted', 0);
  
    $query = $this->db->get('plans');

    return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  }

	function create($data) {
		$this->db->insert('plans', $data);

		return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;

	}


  function update($id, $data) {
    $this->db->where('id', $id);
    $this->db->update('plans', $data);

    return ($this->db->affected_rows() == 1)? TRUE : FALSE;

  }

	function update_by_code($code, $data) {
		$this->db->where('code', $code);
		$this->db->update('projects', $data);


		$this->db->select('id');
		$this->db->where('code', $code);
		$query = $this->db->get('projects');
		return ($query->num_rows() > 0 )? $query->row_array() : FALSE;

	}

	function set_code($id, $code) {

		if (!$code) return FALSE;
		$check = $this->db->query('SELECT id FROM projects WHERE code ="'.$code.'"');
		if ($check->num_rows() > 0 ) return FALSE;

		$this->db->query('UPDATE projects SET code ="'.$code.'" WHERE id='.$id.' AND code IS NULL');
		return ($this->db->affected_rows() == 1)? TRUE : FALSE;
	  }

  function get_years() {
      $this->load->database();

      $this->db->select('year');

      $this->db->where('deleted', 0);
      $this->db->group_by('year');

      $query = $this->db->get('plans');

      return $query->result_array();
    }
  function insert_comment($data){
      $this->db->insert('plan_comments', $data);
      return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
    }  
  function get_comment($plan_id){
      $query = $this->db->query("
        SELECT users.fullname, plan_comments.comment, plan_comments.timestamp FROM plan_comments
        JOIN users on plan_comments.user_id = users.id
        WHERE plan_comments.plan_id =".$plan_id
      );
      return $query->result_array();
      }  
   function get_by_verbal($plan_id){
        $this->load->database();
      $this->db->select('plan_signatures.*, roles.role, users.fullname as user_name');
      $this->db->join('roles', 'plan_signatures.role_id = roles.id', 'left');
      $this->db->join('users', 'plan_signatures.user_id = users.id', 'left');
          $this->db->order_by('rank');
      $this->db->where('plan_id', $plan_id);
      $query = $this->db->get('plan_signatures');
      return $query->result_array();
      }    
}
?>
