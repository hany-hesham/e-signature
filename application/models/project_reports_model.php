<?php
class Project_reports_model extends CI_Model{
	
  	function __contruct(){
		parent::__construct;
	}

	function get_projects_unplanned($states, $from, $to, $hotel_id = NULL) {
  	  	$this->load->database();

  	  	$this->db->select('projects.id, projects.code, projects.timestamp, projects.name AS project_name, departments.name AS department_name, hotels.name AS hotel_name,
          projects.start, projects.end, projects.cost, projects.reasons');

        $this->db->join('departments','projects.department_id = departments.id');
  	  	$this->db->join('hotels','projects.hotel_id = hotels.id');
  	  	
  	  	$this->db->where_in('projects.state_id', $states);
        if (!is_null($hotel_id)) {
          $this->db->where('projects.hotel_id', $hotel_id);
        }
        $this->db->where('projects.timestamp >=', $from);
        $this->db->where('projects.timestamp <=', $to);
        $this->db->where('projects.cost <=', 30000);
        $this->db->where('projects.origin_id', 3);
  	  	$this->db->where('projects.deleted', 0);

        $this->db->order_by('timestamp', 'ASC');
	
		$query = $this->db->get('projects');

		return $query->result_array();
	}

function get_all_projects_report($states, $from, $to, $hotel_id = NULL) {
        $this->load->database();

        $this->db->select('projects.id, projects.code, projects.timestamp, projects.done_date, projects.name AS project_name, departments.name AS department_name, hotels.name AS hotel_name,
          projects.start, projects.end, projects.cost, projects.reasons, projects.progress_id, project_progress.name AS progress_name');

        $this->db->join('departments','projects.department_id = departments.id');
        $this->db->join('hotels','projects.hotel_id = hotels.id');
        $this->db->join('project_progress','projects.progress_id = project_progress.id','left');        
        $this->db->where_in('projects.state_id', $states);
        if (!is_null($hotel_id)) {
          $this->db->where('projects.hotel_id', $hotel_id);
        }
        $this->db->where('projects.timestamp >=', $from);
        $this->db->where('projects.timestamp <=', $to);
        $this->db->where('projects.deleted', 0);

        $this->db->order_by('timestamp', 'ASC');
  
    $query = $this->db->get('projects');

    return $query->result_array();
  }


  function get_projects($hotel_id, $states, $from, $to) {
        $this->load->database();

        $this->db->select('projects.id, projects.code, projects.timestamp, projects.name AS project_name, departments.name AS department_name,
          projects.start, projects.end, projects.cost, projects.reasons, project_origins.name AS origin_name, projects.origin_id');

        $this->db->join('departments','projects.department_id = departments.id');
        $this->db->join('project_origins','projects.origin_id = project_origins.id');
        
        $this->db->where_in('projects.state_id', $states);
        $this->db->where('projects.hotel_id', $hotel_id);
        $this->db->where('projects.timestamp >=', $from);
        $this->db->where('projects.timestamp <=', $to);
        $this->db->where('projects.deleted', 0);

        $this->db->order_by('timestamp', 'ASC');
  
    $query = $this->db->get('projects');

    return $query->result_array();
  }

  function get_projects_approval($role, $from, $to, $hotel_id = FALSE) {
    $this->load->database();
    $this->db->select('project_signatures.project_id, projects.hotel_id, projects.state_id');
    $this->db->join('projects','project_signatures.project_id = projects.id');
    $this->db->where('project_signatures.reject', 0);
    $this->db->where('projects.state_id', 7);
    if ($hotel_id) {
      $this->db->where_in('projects.hotel_id', $hotel_id);
    }
    if ($role != 0) {
      $this->db->where('project_signatures.role_id', $role);
    }
    $this->db->where('project_signatures.timestamp >=', $from);
    $this->db->where('project_signatures.timestamp <=', $to);
    $this->db->group_by('project_id');
    $query = $this->db->get('project_signatures');
    return $query->result_array();
  }

  function get_projects_approved($from, $to, $hotel_id = FALSE) {
    $this->load->database();
    $this->db->select('project_signatures.project_id, project_signatures.timestamp, projects.hotel_id, projects.state_id');
    $this->db->join('projects','project_signatures.project_id = projects.id');
    $this->db->where('project_signatures.reject', 0);
    $this->db->where('projects.state_id', 7);
    if ($hotel_id) {
      $this->db->where_in('projects.hotel_id', $hotel_id);
    }
    $this->db->order_by('project_signatures.timestamp', 'DESC');
    $this->db->group_by('project_signatures.project_id');
    $this->db->where('project_signatures.timestamp >=', $from);
    $this->db->where('project_signatures.timestamp <=', $to);
    $query = $this->db->get('project_signatures');
    return $query->result_array();
  }

function get_projects_progress($states, $from, $to, $hotel_id = FALSE) {
        $this->load->database();

        $this->db->select('projects.id, projects.code, projects.timestamp, projects.name AS project_name, departments.name AS department_name, hotels.name AS hotel_name,
          projects.start, projects.end, projects.cost, projects.reason, projects.reasons,projects.true, projects.progress_id, project_progress.name AS progress_name');

        $this->db->join('departments','projects.department_id = departments.id');
        $this->db->join('hotels','projects.hotel_id = hotels.id');
        $this->db->join('project_progress','projects.progress_id = project_progress.id');

        $this->db->where_in('projects.progress_id', $states);
        if ($hotel_id) {
          $this->db->where('projects.hotel_id', $hotel_id);
        }
        $this->db->where('projects.timestamp >=', $from);
        $this->db->where('projects.timestamp <=', $to);
        $this->db->where('projects.deleted', 0);

        $this->db->order_by('timestamp', 'ASC');
  
    $query = $this->db->get('projects');

    return $query->result_array();
  }


function get_projects_progress_month($states, $from, $to, $hotel_id = FALSE) {
        $this->load->database();

        $this->db->select('projects.id, projects.progress_id, projects.code, projects.reason, projects.new_date, projects.timestamp, projects.done_date, projects.name AS project_name, departments.name AS department_name, hotels.name AS hotel_name,
          projects.start, projects.end, projects.cost, projects.reason, projects.reasons,projects.true, projects.progress_id, project_progress.name AS progress_name');

        $this->db->join('departments','projects.department_id = departments.id');
        $this->db->join('hotels','projects.hotel_id = hotels.id');
        $this->db->join('project_progress','projects.progress_id = project_progress.id');
        
        $this->db->where_in('projects.progress_id', $states);
        if ($hotel_id) {
          $this->db->where('projects.hotel_id', $hotel_id);
        }
        $this->db->where('projects.start >=', $from);
        $this->db->where('projects.start <=', $to);
        $this->db->where('projects.deleted', 0);

        $this->db->order_by('timestamp', 'ASC');
  
    $query = $this->db->get('projects');

    return $query->result_array();
  }

  function get_projects_cost_month($from, $to, $hotel_id = FALSE) {
        $this->load->database();

        $this->db->select('projects.id, projects.progress_id, projects.code, projects.reason, projects.new_date, projects.timestamp, projects.done_date, projects.name AS project_name, departments.name AS department_name, hotels.name AS hotel_name,
          projects.start, projects.end, projects.cost, projects.reasons,projects.true, projects.progress_id, project_progress.name AS progress_name');

        $this->db->join('departments','projects.department_id = departments.id');
        $this->db->join('hotels','projects.hotel_id = hotels.id');
        $this->db->join('project_progress','projects.progress_id = project_progress.id');
        
        if ($hotel_id) {
          $this->db->where('projects.hotel_id', $hotel_id);
        }
        $this->db->where('projects.start >=', $from);
        $this->db->where('projects.start <=', $to);
        $this->db->where('projects.progress_id', 3);
        $this->db->where('projects.deleted', 0);

        $this->db->order_by('timestamp', 'ASC');
  
    $query = $this->db->get('projects');

    return $query->result_array();
  }

  function get_projects_progress_delay($today, $from, $to, $hotel_id = FALSE) {
        $this->load->database();
        $this->db->select('projects.id, projects.progress_id, projects.code, projects.reason, projects.new_date, projects.timestamp, projects.done_date, projects.name AS project_name, departments.name AS department_name, hotels.name AS hotel_name,
          projects.start, projects.end, projects.cost, projects.reasons,projects.true, projects.progress_id, project_progress.name AS progress_name');
        $this->db->join('departments','projects.department_id = departments.id');
        $this->db->join('hotels','projects.hotel_id = hotels.id');
        $this->db->join('project_progress','projects.progress_id = project_progress.id');
        if ($hotel_id) {
          $this->db->where('projects.hotel_id', $hotel_id);
        }
        //$this->db->where('projects.new_date', NULL);
        $this->db->where('projects.end <=', $today);
        $this->db->where('projects.start >=', $from);
        $this->db->where('projects.start <=', $to);
        $this->db->where('projects.progress_id !=', 3);
        $this->db->where('projects.deleted', 0);
        $this->db->order_by('timestamp', 'ASC');
  
    $query = $this->db->get('projects');

    return $query->result_array();
  }

  function get_projects_new_delay($today, $from, $to, $hotel_id = FALSE) {
        $this->load->database();
        $this->db->select('projects.id, projects.progress_id, projects.code, projects.reason, projects.new_date, projects.timestamp, projects.done_date, projects.name AS project_name, departments.name AS department_name, hotels.name AS hotel_name,
          projects.start, projects.end, projects.cost, projects.reasons,projects.true, projects.progress_id, project_progress.name AS progress_name');
        $this->db->join('departments','projects.department_id = departments.id');
        $this->db->join('hotels','projects.hotel_id = hotels.id');
        $this->db->join('project_progress','projects.progress_id = project_progress.id');
        if ($hotel_id) {
          $this->db->where('projects.hotel_id', $hotel_id);
        }
        $this->db->where('projects.new_date !=', '0000-00-00');
        $this->db->where('projects.new_date <=', $today);
        $this->db->where('projects.start >=', $from);
        $this->db->where('projects.start <=', $to);
        $this->db->where('projects.progress_id !=', 3);
        $this->db->where('projects.deleted', 0);
        $this->db->order_by('timestamp', 'ASC');
  
    $query = $this->db->get('projects');

    return $query->result_array();
  }

  function get_projects_in_delay($today, $from, $to, $hotel_id = FALSE) {
        $this->load->database();
        $this->db->select('projects.id, projects.progress_id, projects.code, projects.reason, projects.new_date, projects.timestamp, projects.done_date, projects.name AS project_name, departments.name AS department_name, hotels.name AS hotel_name,
          projects.start, projects.end, projects.cost, projects.reasons,projects.true, projects.progress_id, project_progress.name AS progress_name');
        $this->db->join('departments','projects.department_id = departments.id');
        $this->db->join('hotels','projects.hotel_id = hotels.id');
        $this->db->join('project_progress','projects.progress_id = project_progress.id');
        if ($hotel_id) {
          $this->db->where('projects.hotel_id', $hotel_id);
        }
        $this->db->where('projects.new_date', '0000-00-00');
        $this->db->where('projects.end <=', $today);
        $this->db->where('projects.start >=', $from);
        $this->db->where('projects.start <=', $to);
        $this->db->where('projects.progress_id !=', 3);
        $this->db->where('projects.deleted', 0);
        $this->db->order_by('timestamp', 'ASC');
  
    $query = $this->db->get('projects');

    return $query->result_array();
  }

  function get_projects_done_delay($from, $to, $hotel_id = FALSE) {
        $this->load->database();
        $this->db->select('projects.id, projects.progress_id, projects.code, projects.reason, projects.new_date, projects.timestamp, projects.done_date, projects.name AS project_name, departments.name AS department_name, hotels.name AS hotel_name,
          projects.start, projects.end, projects.cost, projects.reasons,projects.true, projects.progress_id, project_progress.name AS progress_name');
        $this->db->join('departments','projects.department_id = departments.id');
        $this->db->join('hotels','projects.hotel_id = hotels.id');
        $this->db->join('project_progress','projects.progress_id = project_progress.id');
        if ($hotel_id) {
          $this->db->where('projects.hotel_id', $hotel_id);
        }
        //$this->db->where('projects.new_date', '0000-00-00');
        $this->db->where('projects.start >=', $from);
        $this->db->where('projects.start <=', $to);
        $this->db->where('projects.progress_id', 3);
        $this->db->where('projects.deleted', 0);
        $this->db->order_by('timestamp', 'ASC');
  
    $query = $this->db->get('projects');

    return $query->result_array();
  }

  function get_projects_done_new_delay($from, $to, $hotel_id = FALSE) {
        $this->load->database();
        $this->db->select('projects.id, projects.progress_id, projects.code, projects.reason, projects.new_date, projects.timestamp, projects.done_date, projects.name AS project_name, departments.name AS department_name, hotels.name AS hotel_name,
          projects.start, projects.end, projects.cost, projects.reasons,projects.true, projects.progress_id, project_progress.name AS progress_name');
        $this->db->join('departments','projects.department_id = departments.id');
        $this->db->join('hotels','projects.hotel_id = hotels.id');
        $this->db->join('project_progress','projects.progress_id = project_progress.id');
        if ($hotel_id) {
          $this->db->where('projects.hotel_id', $hotel_id);
        }
        $this->db->where('projects.new_date !=', '0000-00-00');
        $this->db->where('projects.start >=', $from);
        $this->db->where('projects.start <=', $to);
        $this->db->where('projects.progress_id', 3);
        $this->db->where('projects.deleted', 0);
        $this->db->order_by('timestamp', 'ASC');
  
    $query = $this->db->get('projects');

    return $query->result_array();
  }

  function get_projects_done($from, $to, $hotel_id = FALSE) {
        $this->load->database();
        $this->db->select('projects.id, projects.progress_id, projects.code, projects.reason, projects.new_date, projects.timestamp, projects.done_date, projects.name AS project_name, departments.name AS department_name, hotels.name AS hotel_name,
          projects.start, projects.end, projects.cost, projects.reasons,projects.true, projects.progress_id, project_progress.name AS progress_name');
        $this->db->join('departments','projects.department_id = departments.id');
        $this->db->join('hotels','projects.hotel_id = hotels.id');
        $this->db->join('project_progress','projects.progress_id = project_progress.id');
        if ($hotel_id) {
          $this->db->where('projects.hotel_id', $hotel_id);
        }
        $this->db->where('projects.start >=', $from);
        $this->db->where('projects.start <=', $to);
        $this->db->where('projects.progress_id', 3);
        $this->db->where('projects.deleted', 0);
        $this->db->order_by('timestamp', 'ASC');
  
    $query = $this->db->get('projects');

    return $query->result_array();
  }

  function get_status($id){
    $this->load->database();
    $this->db->select('project_progress.*');
    $this->db->where('project_progress.id', $id);
    $query = $this->db->get('project_progress');
    return $query->row_array();
    }


  function get_projects_delayed($hotel_id = NULL, $from, $to) {
        $this->load->database();

        $this->db->select('projects.id, projects.progress_id, projects.code, projects.timestamp, projects.done_date, projects.name AS project_name, departments.name AS department_name, hotels.name AS hotel_name,
          projects.start, projects.end, projects.cost, projects.reasons,projects.true, projects.progress_id, project_progress.name AS progress_name');

        $this->db->join('departments','projects.department_id = departments.id');
        $this->db->join('hotels','projects.hotel_id = hotels.id');
        $this->db->join('project_progress','projects.progress_id = project_progress.id');

        if (!is_null($hotel_id)) {
          $this->db->where_in('projects.hotel_id', $hotel_id);
        }
        $this->db->where('projects.end <= CURDATE()');
        $this->db->where('projects.start >=', $from);
        $this->db->where('projects.end <=', $to);
        $this->db->where('projects.progress_id', 1,2,4,5,6);

        $this->db->order_by('timestamp', 'ASC');
  
    $query = $this->db->get('projects');

    return $query->result_array();
  }

  function get_all_projects(){
      $this->load->database();
      $this->db->order_by('name');
      $query = $this->db->get('projects');
      return $query->result_array();
      }

  function getall_projects($project, $from, $to) {
    $this->db->select('projects.*, hotels.name as hotel_name');
    $this->db->like('projects.name', $project);
    $this->db->join('hotels', 'projects.hotel_id = hotels.id');
    $this->db->where('projects.timestamp >=', $from);
    $this->db->where('projects.timestamp <=', $to);
    $this->db->order_by('projects.timestamp');
    $query = $this->db->get('projects');

    return ($query->num_rows() > 0 )? $query->result_array() : FALSE;
  }

  function get_unsigned_owning_delay($today, $from = FALSE, $to = FALSE, $hotel_id = FALSE, $state = FALSE, $type, $approved) {
    $this->load->database();
    $this->db->select('owning_signatures.project_id, owning_signatures.type, owning_signatures.user_id, owning_signatures.timestamp, owning_signatures.dead_line, project_owning_form.date, projects.hotel_id, projects.state_id');
    $this->db->join('project_owning_form','owning_signatures.project_id = project_owning_form.project_id');
    $this->db->join('projects','owning_signatures.project_id = projects.id');
    if ($hotel_id) {
      $this->db->where('projects.hotel_id', $hotel_id);
    }
    if ($state) {
      $this->db->where('owning_signatures.role_id', $state);
    }
    $this->db->where('owning_signatures.type', $type);
    if ($from && $to) {
      $this->db->where('project_owning_form.date >=', $from);
      $this->db->where('project_owning_form.date <=', $to);
    }
    $this->db->where('owning_signatures.dead_line !=', 0);
    $this->db->where('owning_signatures.dead_line <', $today);
    $this->db->where('owning_signatures.user_id', NULL);
    $this->db->where_not_in('projects.state_id', $approved);
    $this->db->order_by('owning_signatures.timestamp', 'ASC');
    $this->db->group_by('owning_signatures.project_id'); 
    $query = $this->db->get('owning_signatures');
    return $query->result_array();
  }

  function get_owning_signature($id, $type, $today, $state = FALSE) {
    $this->load->database();
    $this->db->select('owning_signatures.id, owning_signatures.project_id, owning_signatures.type, owning_signatures.role_id, owning_signatures.user_id, owning_signatures.timestamp, owning_signatures.dead_line, owning_signatures.delay_reason, owning_signatures.reject, project_owning_form.date, roles.role, users.fullname as user_name');
    $this->db->join('roles', 'owning_signatures.role_id = roles.id', 'left');
    $this->db->join('users', 'owning_signatures.user_id = users.id', 'left');
    $this->db->join('project_owning_form','owning_signatures.project_id = project_owning_form.project_id');
    $this->db->where('owning_signatures.project_id', $id);
    $this->db->where('owning_signatures.type', $type);
    if ($state) {
      $this->db->where('owning_signatures.role_id', $state);
    }
    $this->db->where('owning_signatures.dead_line !=', 0);
    $this->db->where('owning_signatures.dead_line <', $today);
    $this->db->where('owning_signatures.user_id', NULL);
    $this->db->order_by('owning_signatures.id', 'ASC');
    $this->db->group_by('owning_signatures.id'); 
    $query = $this->db->get('owning_signatures');
    return $query->result_array();
  }

  function get_signed_owning_delay($from = FALSE, $to = FALSE, $hotel_id = FALSE, $state = FALSE, $type) {
    $this->load->database();
    $this->db->select('owning_signatures.project_id, owning_signatures.type, owning_signatures.user_id, owning_signatures.timestamp, owning_signatures.dead_line, project_owning_form.date, projects.hotel_id, projects.deleted');
    $this->db->join('project_owning_form','owning_signatures.project_id = project_owning_form.project_id');
    $this->db->join('projects','owning_signatures.project_id = projects.id');
    if ($hotel_id) {
      $this->db->where('projects.hotel_id', $hotel_id);
    }
    if ($state) {
      $this->db->where('owning_signatures.type', $state);
    }
    if ($from && $to) {
      $this->db->where('project_owning_form.date >=', $from);
      $this->db->where('project_owning_form.date <=', $to);
    }
    $this->db->where('owning_signatures.dead_line !=', 0);
    $this->db->where('owning_signatures.user_id !=', 0);
    $this->db->where('projects.deleted', 0);
    $this->db->order_by('owning_signatures.timestamp', 'ASC');
    $this->db->group_by('owning_signatures.project_id'); 
    $query = $this->db->get('owning_signatures');
    return $query->result_array();
  }

  function get_all_projects_byid($projects) {
    $this->load->database();
    $this->db->select('projects.id, projects.code, projects.timestamp, projects.name AS project_name, departments.name AS department_name, hotels.name AS hotel_name, projects.start, projects.end, projects.cost, projects.reasons, projects.true');
    $this->db->join('departments','projects.department_id = departments.id');
    $this->db->join('hotels','projects.hotel_id = hotels.id');
    $this->db->where_in('projects.id', $projects); 
    $this->db->order_by('projects.timestamp', 'ASC');
    $query = $this->db->get('projects');
    return $query->result_array();
  }

      function get_projects_bytype($hotel_id = FALSE, $type = FALSE, $from = FALSE, $to = FALSE) {
        $this->load->database();
        $this->db->select('projects.id, projects.progress_id, projects.code, projects.timestamp, projects.done_date, projects.name AS project_name, departments.name AS department_name, hotels.name AS hotel_name,
          projects.start, projects.end, projects.cost, projects.reasons, projects.budget, projects.true,projects.new_date ,projects.reason, projects.origin_id, projects.progress_id, project_progress.name AS progress_name');
        $this->db->join('departments','projects.department_id = departments.id');
        $this->db->join('hotels','projects.hotel_id = hotels.id');
        $this->db->join('project_progress','projects.progress_id = project_progress.id');
        if ($hotel_id) {
          $this->db->where('projects.hotel_id', $hotel_id);
        }
        if ($from) {
          $this->db->where('projects.timestamp >=', $from);
          $this->db->where('projects.timestamp <=', $to);
        }
        if ($type) {
          $this->db->where('projects.origin_id', $type);
        }
        $this->db->where('projects.deleted', 0);
        $this->db->order_by('timestamp', 'ASC');
        $query = $this->db->get('projects');
        return $query->result_array();
      }


}
?>
