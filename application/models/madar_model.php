<?php
class Madar_model extends CI_Model{
	
  	function __contruct(){
		parent::__construct;
	}

	function update_state($id, $state) {
		$this->db->update('madar', array('state_id'=> $state), "id = ".$id);
	}

/*  function update_stage($id) {
    $this->db->update('madar', array('state_id'=> 7, 'progress_id'=> 1), "id = ".$id);
  }
*/
	function get_request($id, $code = NULL) {
  	  	$this->load->database();

  	  	$this->db->select('madar.id, madar.name AS project_name, madar.code AS project_code,
                          hotels.name AS hotel_name, hotels.logo AS hotel_logo, reasons, remarks,madar.type,
                           madar.hotel_id, madar.state_id,
                          madar.user_id, madar.EUR_EX, madar.USD_EX,
                          madar.budget_EGP, madar.budget_USD, madar.budget_EUR, madar.budget');

  	  	$this->db->join('hotels','madar.hotel_id = hotels.id');
  	  	
  	  	if(!$id) {
  	  		$this->db->where('madar.code', $code);
  	  	} else {
  	  		$this->db->where('madar.id', $id);
  	  	}
  	  	$this->db->where('madar.deleted', 0);
	
		$query = $this->db->get('madar');

		return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
	}

  function get_project_code($id) {
    $this->load->database();

    $this->db->select('madar.code');
    
    $this->db->where('madar.id', $id);
    
    $query = $this->db->get('madar');

    return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  }

	function get_project($id, $code = NULL) {
  	  	$this->load->database();

  	  	$this->db->select('madar.id, madar.code, madar.name AS project_name,
                          hotels.name AS hotel_name, reasons, remarks,
                          madar.hotel_id,
                          madar.state_id, madar.user_id, madar.EUR_EX, madar.USD_EX,
                          madar.budget_EGP, madar.budget_USD, madar.budget_EUR, madar.budget,
                          madar.cost_EGP, madar.cost_USD, madar.cost_EUR, madar.cost');

  	  	$this->db->join('hotels','madar.hotel_id = hotels.id');
  	  	
  	  	if(!$id) {
  	  		$this->db->where('madar.code', $code);
  	  	} else {
  	  		$this->db->where('madar.id', $id);
  	  	}
  	  	$this->db->where('madar.deleted', 0);
	
		$query = $this->db->get('madar');

		return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
	}

/*  function get_project_progress($code) {
        $this->load->database();

        $this->db->select('madar.id, madar.code, madar.name AS project_name, madar.progress_id, madar.EUR_EX, madar.USD_EX, madar.true_EGP, madar.true_USD, madar.true_EUR, madar.true, madar.progress');
        
        $this->db->where('madar.code', $code);
        $this->db->where('madar.deleted', 0);
  
    $query = $this->db->get('madar');

    return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  }
*/

	function get_requests($user_hotels) {
  	  	$this->load->database();

  	  	$this->db->select('madar.id, madar.name AS project_name, hotels.name AS hotel_name, madar.hotel_id, madar.state_id, users.fullname AS user_name');

  	  	$this->db->join('hotels','madar.hotel_id = hotels.id');
  	  	$this->db->join('users','madar.user_id = users.id');
  	  	
        if ($user_hotels) {
          $this->db->where_in('madar.hotel_id', $user_hotels);
        }

        $this->db->where('madar.deleted', 0);

        $this->db->order_by('timestamp', 'DESC');
	
		$query = $this->db->get('madar');

		return $query->result_array();
	}

	function get_projects($states, $user_hotels = FALSE) {
  	  	$this->load->database();

  	  	$this->db->select('madar.id, madar.code, madar.name AS project_name, hotels.name AS hotel_name, madar.hotel_id, madar.state_id, users.fullname AS user_name, madar.cost');

  	  	$this->db->join('hotels','madar.hotel_id = hotels.id');
  	  	$this->db->join('users','madar.user_id = users.id');
  	  	
        if ($user_hotels) {
          $this->db->where_in('madar.hotel_id', $user_hotels);
        }

  	  	$this->db->where_in('madar.state_id', $states);
  	  	$this->db->where('madar.deleted', 0);

        $this->db->order_by('timestamp', 'DESC');

	
		$query = $this->db->get('madar');

		return $query->result_array();
	}


/*  function get_madar_progress($states, $user_hotels) {
        $this->load->database();

        $this->db->select('madar.id, madar.code, madar.name AS project_name, hotels.name AS hotel_name, departments.name AS department_name, madar.hotel_id, madar.progress_id, project_progress.name AS progress_name, madar.progress, madar.true');

        $this->db->join('hotels','madar.hotel_id = hotels.id');
        $this->db->join('project_progress','madar.progress_id = project_progress.id');
        $this->db->join('departments','madar.department_id = departments.id');
        $this->db->join('users','madar.user_id = users.id');
        
        if ($user_hotels) {
          $this->db->where_in('madar.hotel_id', $user_hotels);
        }

        $this->db->where_in('madar.progress_id', $states);
        $this->db->where('madar.deleted', 0);
  
    $query = $this->db->get('madar');

    return $query->result_array();
  }
*/

	function create($data) {
		$this->db->insert('madar', $data);

		return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;

	}

	function update_by_code($code, $data) {
		$this->db->where('code', $code);
		$this->db->update('madar', $data);


		$this->db->select('id');
		$this->db->where('code', $code);
		$query = $this->db->get('madar');
		return ($query->num_rows() > 0 )? $query->row_array() : FALSE;

	}

  function update($id, $data) {
    $this->db->where('id', $id);
    $this->db->update('madar', $data);

    return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  }

	function set_code($id, $code) {

		if (!$code) return FALSE;
		$check = $this->db->query('SELECT id FROM madar WHERE code ="'.$code.'"');
		if ($check->num_rows() > 0 ) return FALSE;

		$this->db->query('UPDATE madar SET code ="'.$code.'" WHERE id='.$id.' AND code IS NULL');
		return ($this->db->affected_rows() == 1)? TRUE : FALSE;
	}
}
?>
