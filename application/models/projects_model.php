<?php

  class Projects_model extends CI_Model{
	
  	function __contruct(){
  		parent::__construct;
  	}

    function create($data) {
      $this->db->insert('projects', $data);
      return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
    }

    function get_project($id, $code = NULL) {
      $this->load->database();
      $this->db->select('projects.id, projects.department_id, projects.message_id, projects.change_amend, projects.hotel_id, projects.change_unplanned,projects.timestamp, projects.life_year, projects.life_month, projects.new, projects.charge, projects.code, projects.name AS project_name, projects.origin_id, projects.type_id, hotels.name AS hotel_name, reasons, remarks, project_types.name AS type_name, project_origins.name AS origin_name, departments.name AS department_name, projects.hotel_id, projects.state_id, projects.user_id, users.fullname as user_name, projects.EUR_EX, projects.USD_EX, projects.budget_EGP, projects.budget_USD, projects.budget_EUR, projects.budget, projects.cost_EGP, projects.cost_USD, projects.cost_EUR, projects.cost, projects.start, projects.end, projects.scope, projects.year,projects.replaced');
      $this->db->join('users', 'projects.user_id = users.id', 'left');
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

    function update_stage($id) {
      $this->db->update('projects', array('state_id'=> 7, 'progress_id'=> 1), "id = ".$id);
    }

    function update_final($id, $state) {
      $this->db->update('projects', array('chairman'=> $state), "id = ".$id);
    }

    function update_state($id, $state) {
      $this->db->update('projects', array('state_id'=> $state), "id = ".$id);
    }

    function update_by_code($code, $data) {
      $this->load->database();
      $this->db->where('projects.code', $code);
      $this->db->update('projects', $data);
      $this->db->select('projects.id');
      $this->db->where('projects.code', $code);
      $query = $this->db->get('projects');
      return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
    }

    function get_project_code($id) {
      $this->load->database();
      $this->db->select('projects.code, projects.id, projects.name');
      $this->db->where('projects.id', $id);
      $query = $this->db->get('projects');
      return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
    }

  	function update_change($id, $change) {
      $this->db->update('projects', array('change_amend'=> $change), "id = ".$id);
    }
    function update_change_unplanned($id, $change) {
      $this->db->update('projects', array('change_unplanned'=> $change), "id = ".$id);
    }

    function update_message_id($code, $message_id) {
      $this->load->database();
      $this->db->where('projects.code', $code);
      //if(isset($message_id)){
      $msg_id = $this->db->update('projects', array('message_id' => $message_id));
      //die(print_r($msg_id));
      //}else{
              //die(print_r($message_id));
      //}
    }

    function get_request($id, $code = NULL) {
      $this->load->database();
      $this->db->select('projects.id, projects.message_id, projects.timestamp,projects.new, projects.name AS project_name, projects.code AS project_code,
        hotels.name AS hotel_name, hotels.logo As logo, reasons, remarks,
        project_types.name AS type_name, projects.type_id, project_origins.name AS origin_name,
        departments.name AS department_name, departments.id AS department_id,projects.change_unplanned,
        projects.hotel_id, projects.state_id, projects.user_id, users.fullname as user_name, projects.EUR_EX, projects.USD_EX,
        projects.budget_EGP, projects.budget_USD, projects.budget_EUR, projects.budget');
      $this->db->join('users', 'projects.user_id = users.id', 'left');
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

    function get_projects($states, $user_hotels = FALSE, $replaced = FALSE) {
      $this->load->database();
      $this->db->select('projects.id, projects.code, projects.change_amend, projects.name AS project_name, hotels.name AS hotel_name, departments.name AS department_name, projects.hotel_id, projects.state_id, projects.charge, users.fullname AS user_name, projects.cost, project_origins.name AS origin_name, project_types.name AS type_name');
      $this->db->join('hotels','projects.hotel_id = hotels.id');
      $this->db->join('project_types','projects.type_id = project_types.id');
      $this->db->join('project_origins','projects.origin_id = project_origins.id');
      $this->db->join('departments','projects.department_id = departments.id');
      $this->db->join('users','projects.user_id = users.id');
      if ($user_hotels) {
        $this->db->where_in('projects.hotel_id', $user_hotels);
      }
      $this->db->where_in('projects.state_id', $states);
      $this->db->where('projects.deleted', 0);
        $this->db->where('projects.replaced',$replaced);
      $this->db->order_by('timestamp', 'DESC');
      $query = $this->db->get('projects');
      return $query->result_array();
    }

  function get_project_progress($code) {
        $this->load->database();

        $this->db->select('projects.id, projects.code, projects.new_date, projects.start, projects.end, projects.name AS project_name, projects.progress_id, projects.EUR_EX, projects.USD_EX, projects.true_EGP, projects.true_USD, projects.true_EUR, projects.true, projects.progress, projects.reason');
        
        $this->db->where('projects.code', $code);
        $this->db->where('projects.deleted', 0);
  
    $query = $this->db->get('projects');

    return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  }

  function get_log($target_id, $type) {
      $this->db->select('log.*, users.fullname as name');
      $this->db->join('users', 'log.user_id = users.id','left');
      $this->db->where('log.target_id', $target_id);   
      $this->db->where('log.action', $type);    
      $this->db->order_by('log_time');
      $query = $this->db->get('log');
      return $query->result_array();
    }


	function get_requests($states, $user_hotels) {
  	  	$this->load->database();

  	  	$this->db->select('projects.id,projects.timestamp,projects.change_unplanned, projects.name AS project_name, hotels.name AS hotel_name, departments.name AS department_name, projects.hotel_id, projects.state_id, users.fullname AS user_name');

  	  	$this->db->join('hotels','projects.hotel_id = hotels.id');
  	  	$this->db->join('project_types','projects.type_id = project_types.id');
  	  	$this->db->join('project_origins','projects.origin_id = project_origins.id');
  	  	$this->db->join('departments','projects.department_id = departments.id');
  	  	$this->db->join('users','projects.user_id = users.id');
  	  	
        if ($user_hotels) {
          $this->db->where_in('projects.hotel_id', $user_hotels);
        }

  	  	$this->db->where_in('projects.state_id', $states);
        $this->db->where('projects.deleted', 0);
  	  	$this->db->where('projects.origin_id', 3);

        $this->db->order_by('timestamp', 'DESC');
	
		$query = $this->db->get('projects');

		return $query->result_array();
	}


  function get_projects_progress($states, $user_hotels = FALSE) {
        $this->load->database();

        $this->db->select('projects.id, projects.code, projects.name AS project_name, hotels.name AS hotel_name, departments.name AS department_name, projects.hotel_id, projects.progress_id, project_progress.name AS progress_name, projects.progress, projects.reason, projects.new_date, projects.true,project_origins.name AS origin_name');

        $this->db->join('hotels','projects.hotel_id = hotels.id');
        $this->db->join('project_origins','projects.origin_id = project_origins.id');
        $this->db->join('project_progress','projects.progress_id = project_progress.id');
        $this->db->join('departments','projects.department_id = departments.id');
        $this->db->join('users','projects.user_id = users.id');
        
        if ($user_hotels) {
          $this->db->where_in('projects.hotel_id', $user_hotels);
        }

        $this->db->where_in('projects.progress_id', $states);
        $this->db->where('projects.deleted', 0);
  
    $query = $this->db->get('projects');

    return $query->result_array();
  }

  function update_by_codes($code, $data) {
    $this->load->database();
    $this->db->where('code', $code);
    $this->db->update('projects', $data);
    return ($this->db->affected_rows() == 1)? TRUE : FALSE;

  }

  function update($id, $data) {
    $this->db->where('id', $id);
    $this->db->update('projects', $data);

    return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  }

	function set_code($id, $code) {

		if (!$code) return FALSE;
		$check = $this->db->query('SELECT id FROM projects WHERE code ="'.$code.'"');
		if ($check->num_rows() > 0 ) return FALSE;

		$this->db->query('UPDATE projects SET code ="'.$code.'" WHERE id='.$id.' AND code IS NULL');
		return ($this->db->affected_rows() == 1)? TRUE : FALSE;
	}

  function update_request_message_id($id, $message_id) {
      $this->load->database();
      $this->db->where('projects.id', $id);
      //if(isset($message_id)){
      $msg_id = $this->db->update('projects', array('message_id' => $message_id));
      //die(print_r($msg_id));
      //}else{
              //die(print_r($message_id));
      //}
  }

    function get_all_origin() {
      $this->db->select('project_origins.*');
      $this->db->where('project_origins.id !=', 1);   
      $this->db->order_by('project_origins.name');
      $query = $this->db->get('project_origins');
      return $query->result_array();
    }

    function get_originby_id($id) {
      $this->db->select('project_origins.*');
      $this->db->where('project_origins.id', $id);   
      $query = $this->db->get('project_origins');
      return $query->row_array();
    }

    function get_all_signers() {
      $this->db->select('roles.*');
      $x = array('0' => 85, '1' => 14);
      $this->db->where_in('roles.id', $x);   
      $this->db->order_by('roles.role');
      $query = $this->db->get('roles');
      return $query->result_array();
    }

    function get_signerby_id($id) {
      $this->db->select('roles.*');
      $this->db->where('roles.id', $id);   
      $query = $this->db->get('roles');
      return $query->row_array();
    }
  function chairman_exception_request($id){
        $this->db->where('project_approvals.project_id',$id);
         $this->db->where('project_approvals.role_id !=',1);
         $this->db->where('project_approvals.user_id IS NULL');
         $query = $this->db->select('project_approvals.user_id');
         $query = $this->db->get('project_approvals');
          return  $query->num_rows();  
      }  
  function chairman_exception($id){
        $this->db->where('project_id',$id);
         $this->db->where('role_id !=',1);
         $this->db->where('user_id IS NULL');
         $query = $this->db->select('user_id');
         $query = $this->db->get('project_signatures');
          return  $query->num_rows();  
      }  
  function chairman_after_kfahmy($id){
        $this->db->where('project_id',$id);
         //$this->db->where('role_id =',14);
         $this->db->where('user_id IS NULL');
         $query = $this->db->select('user_id');
         $query = $this->db->get('owning_signatures');
          return  $query->num_rows();  
      }     
  function create_replace($data) {
        $this->db->insert('plan_items_rplacement', $data);
        return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
      }
  function projects_replaced($id) {
       $this->db->update('projects', array('replaced'=> 1), "id = ".$id);
      } 
  function get_project_replaced($id){
      $this->db->where('plan_items_rplacement.project_id',$id);
      $this->db->select('plan_items_rplacement.*,departments.name AS department_name');
      $this->db->join('departments','plan_items_rplacement.department_id = departments.id');
      $query = $this->db->get('plan_items_rplacement');
      return $query->result_array();
    }


}
?>
