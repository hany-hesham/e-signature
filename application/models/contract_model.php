<?php

	class contract_model extends CI_Model{

  		function __contruct(){
			parent::__construct;
		}

		function view($user_hotels = FALSE) {
  	  		$this->load->database();
			$this->db->select('contract.id, contract.hotel_id, contract.service_id, contract.name, contract.from_date, contract.to_date, contract.state_id, hotels.name as hotel_name, contract_services.name as service_name');
			$this->db->join('hotels', 'contract.hotel_id = hotels.id','left');
			$this->db->join('contract_services', 'contract.service_id = contract_services.id','left');
        	if ($user_hotels) {
          		$this->db->where_in('contract.hotel_id', $user_hotels);
        	}
			$this->db->where('contract.state_id !=', 0);		
        	$this->db->order_by('timestamp', 'DESC');
			$query = $this->db->get('contract');
			return $query->result_array();
		}

		function get_by_verbals($contr_id){
	    	$this->load->database();
			$this->db->select('contract_signature.role_id, contract_signature.rank,contract_signature.department_id, contract_signature.user_id, contract_signature.reject, roles.role, departments.name as department, users.fullname as user_name');
			$this->db->join('roles', 'contract_signature.role_id = roles.id', 'left');
			$this->db->join('departments', 'contract_signature.department_id = departments.id', 'left');
			$this->db->join('users', 'contract_signature.user_id = users.id', 'left');
			$this->db->where('contr_id', $contr_id);
        	$this->db->order_by('contract_signature.rank');
			$query = $this->db->get('contract_signature');
			return $query->result_array();
  		}

  		function get_sum_by_verbals($sum_id){
	    	$this->load->database();
			$this->db->select('contract_summary_signature.role_id, contract_summary_signature.rank, contract_summary_signature.department_id, contract_summary_signature.user_id, contract_summary_signature.reject, roles.role, departments.name as department, users.fullname as user_name');
			$this->db->join('roles', 'contract_summary_signature.role_id = roles.id', 'left');
			$this->db->join('departments', 'contract_summary_signature.department_id = departments.id', 'left');
			$this->db->join('users', 'contract_summary_signature.user_id = users.id', 'left');
			$this->db->where('sum_id', $sum_id);
        	$this->db->order_by('contract_summary_signature.rank');
			$query = $this->db->get('contract_summary_signature');
			return $query->result_array();
  		}

  		function view_app($user_hotels = FALSE) {
  	  		$this->load->database();
			$this->db->select('contract.id, contract.hotel_id, contract.name, contract.from_date, contract.to_date, contract.state_id, hotels.name as hotel_name, contract_services.name as service_name');
			$this->db->join('hotels', 'contract.hotel_id = hotels.id','left');
			$this->db->join('contract_services', 'contract.service_id = contract_services.id','left');
        	if ($user_hotels) {
          		$this->db->where_in('contract.hotel_id', $user_hotels);
        	}
			$this->db->where('contract.state_id', 2);		
        	$this->db->order_by('timestamp', 'DESC');
			$query = $this->db->get('contract');
			return $query->result_array();
		}

		function view_rej($user_hotels = FALSE) {
  	  		$this->load->database();
			$this->db->select('contract.id, contract.hotel_id, contract.name, contract.from_date, contract.to_date, contract.state_id, hotels.name as hotel_name, contract_services.name as service_name');
			$this->db->join('hotels', 'contract.hotel_id = hotels.id','left');
			$this->db->join('contract_services', 'contract.service_id = contract_services.id','left');
        	if ($user_hotels) {
          		$this->db->where_in('contract.hotel_id', $user_hotels);
        	}
			$this->db->where('contract.state_id', 3);		
        	$this->db->order_by('timestamp', 'DESC');
			$query = $this->db->get('contract');
			return $query->result_array();
		}

		function view_wat($user_hotels = FALSE, $state) {
  	  		$this->load->database();
			$this->db->select('contract.id, contract.hotel_id, contract.name, contract.from_date, contract.to_date, contract.state_id, contract.brand, contract.name_en, contract.taxes_per, contract.rent, contract.currency, contract.rent_mp, contract.rent_gb, contract.others, hotels.name as hotel_name, contract_services.name as service_name');
			$this->db->join('hotels', 'contract.hotel_id = hotels.id','left');
			$this->db->join('contract_services', 'contract.service_id = contract_services.id','left');
        	if ($user_hotels) {
          		$this->db->where_in('contract.hotel_id', $user_hotels);
        	}
			$this->db->where('contract.state_id', $state);		
        	$this->db->order_by('timestamp', 'DESC');
			$query = $this->db->get('contract');
			return $query->result_array();
		}

		function get_upload(){
	    	$this->load->database();
			$this->db->select('contract_filles.contr_id');
			$query = $this->db->get('contract_filles');
			return $query->result_array();
  		}

  		function view_not($user_hotels = FALSE, $form_not = FALSE) {
  	  		$this->load->database();
			$this->db->select('contract.id, contract.hotel_id, contract.name, contract.from_date, contract.to_date, contract.state_id, hotels.name as hotel_name, contract_services.name as service_name');
			$this->db->join('hotels', 'contract.hotel_id = hotels.id','left');
			$this->db->join('contract_services', 'contract.service_id = contract_services.id','left');
        	if ($user_hotels) {
          		$this->db->where_in('contract.hotel_id', $user_hotels);
        	}
        	if ($form_not) {
          		$this->db->where_not_in('contract.id', $form_not);
        	}
        	$this->db->order_by('timestamp', 'DESC');
			$query = $this->db->get('contract');
			return $query->result_array();
		}

		function view_in($user_hotels = FALSE, $form_in = FALSE) {
  	  		$this->load->database();
			$this->db->select('contract.id, contract.hotel_id, contract.name, contract.from_date, contract.to_date, contract.state_id, hotels.name as hotel_name, contract_services.name as service_name');
			$this->db->join('hotels', 'contract.hotel_id = hotels.id','left');
			$this->db->join('contract_services', 'contract.service_id = contract_services.id','left');
        	if ($user_hotels) {
          		$this->db->where_in('contract.hotel_id', $user_hotels);
        	}
        	if ($form_in) {
          		$this->db->where_in('contract.id', $form_in);
        	}
        	$this->db->order_by('timestamp', 'DESC');
			$query = $this->db->get('contract');
			return $query->result_array();
		}

		function get_summaries($state){
	    	$this->load->database();
			$this->db->select('contract_summary.new_id');
			$this->db->where('contract_summary.state_id', $state);		
			$query = $this->db->get('contract_summary');
			return $query->result_array();
  		}

		function create_contract($data) {
			$this->load->database();
			$this->db->insert('contract', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function update_files($assumed_id, $contr_id) {
  			$this->load->database();
  			$this->db->query('UPDATE contract_filles SET contr_id = "'.$contr_id.'" WHERE contr_id = "'.$assumed_id.'"');
  		}

  		function add_day($contr_id, $week_id) {
	  		$this->load->database();
	  		$this->db->query('INSERT INTO contract_days(contr_id,week_id) VALUES("'.$contr_id.'","'.$week_id.'")');
  		}

  		function contr_sign (){
  			$this->load->database();
			$this->db->select('contract_role.*');
			$query = $this->db->get('contract_role');
			return $query->result_array();  	
		}

		function contr_do_sign($contr_id){
  	 		$this->load->database();
			$this->db->select('contract_signature.*');
			$this->db->where('contract_signature.contr_id', $contr_id);		
			$query = $this->db->get('contract_signature');
			return $query->num_rows();  	
		}

		function add_signature($contr_id, $role_id, $department_id,  $rank){
	    	$this->load->database();
			$query = $this->db->query('INSERT INTO contract_signature(contr_id, role_id, department_id, rank) VALUES("'.$contr_id.'", "'.$role_id.'", "'.$department_id.'", "'.$rank.'")');
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
  		}

  		function get_fille($id){
		    $this->load->database();
			$this->db->select('contract_filles.*, users.fullname as user_name');
			$this->db->join('users', 'contract_filles.user_id = users.id','left');
			$this->db->where('contract_filles.id', $id);
			$query = $this->db->get('contract_filles');
			return $query->row_array();
	  	}

  		function get_services(){
	    	$this->load->database();
			$this->db->select('contract_services.*');
        	$this->db->order_by('name');
			$query = $this->db->get('contract_services');
			return $query->result_array();
  		}

  		function get_companies(){
	    	$this->load->database();
			$this->db->select('contract_companies.*');
        	$this->db->order_by('name');
			$query = $this->db->get('contract_companies');
			return $query->result_array();
  		}

  		function get_weeks(){
	    	$this->load->database();
			$this->db->select('contract_weeks.*');
        	$this->db->order_by('name');
			$query = $this->db->get('contract_weeks');
			return $query->result_array();
  		}

  		function get_by_fille($contr_id){
	    	$this->load->database();
			$this->db->select('contract_filles.*, users.fullname as user_name');
			$this->db->join('users', 'contract_filles.user_id = users.id','left');
			$this->db->where('contr_id', $contr_id);
			$query = $this->db->get('contract_filles');
			return $query->result_array();
  		}

  		function add_fille($contr_id, $name, $user_id) {
	  		$this->load->database();
	  		$this->db->query('INSERT INTO contract_filles(contr_id, name, user_id) VALUES("'.$contr_id.'","'.$name.'","'.$user_id.'")');
	  	}

	  	function remove_fille($id) {
	      $this->load->database();
	      $this->db->query('DELETE FROM contract_filles WHERE id = '.$id);
	    }

	    function get_contract($contr_id) {
			$this->db->select('contract.*, hotels.name as hotel_name, hotels.logo As logo, users.fullname as user_name, contract_services.name as service_name, contract_companies.name as company_name');
			$this->db->join('hotels', 'contract.hotel_id = hotels.id','left');
			$this->db->join('users', 'contract.user_id = users.id','left');
			$this->db->join('contract_services', 'contract.service_id = contract_services.id', 'left');
			$this->db->join('contract_companies', 'contract.company_id = contract_companies.id', 'left');
			$this->db->where('contract.id', $contr_id);		
			$query = $this->db->get('contract');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
		}

		function update_state($contr_id, $state) {
			$this->db->update('contract', array('state_id'=> $state), "id = ".$contr_id);
		}

		function get_by_verbal($contr_id){
	    	$this->load->database();
			$this->db->select('contract_signature.*, roles.role, departments.name as department, users.fullname as user_name');
			$this->db->join('roles', 'contract_signature.role_id = roles.id', 'left');
			$this->db->join('departments', 'contract_signature.department_id = departments.id', 'left');
			$this->db->join('users', 'contract_signature.user_id = users.id', 'left');
			$this->db->where('contr_id', $contr_id);
        	$this->db->order_by('rank');
			$query = $this->db->get('contract_signature');
			return $query->result_array();
  		}

  		function get_day($contr_id) {
	    	$this->load->database();
			$this->db->select('contract_days.*, contract_weeks.name as day_name');
			$this->db->join('contract_weeks', 'contract_days.week_id = contract_weeks.id','left');
			$this->db->where('contract_days.contr_id', $contr_id);		
			$query = $this->db->get('contract_days');
			return $query->result_array();
		}

  		function get_comment($contr_id){
			$query = $this->db->query("
				SELECT users.fullname, contract_comments.id, contract_comments.comment, contract_comments.created FROM contract_comments
				JOIN users on contract_comments.user_id = users.id
				WHERE contract_comments.contr_id =".$contr_id
			);
			return $query->result_array();
  		}

  		function find_summary($contr_id) {
			$this->db->select('contract_summary.*, hotels.name as hotel_name, hotels.logo As logo, users.fullname as user_name');
			$this->db->join('hotels', 'contract_summary.hotel_id = hotels.id','left');
			$this->db->join('users', 'contract_summary.user_id = users.id','left');
			$this->db->where('contract_summary.new_id', $contr_id);		
			$query = $this->db->get('contract_summary');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
		}

		function get_service_by_id($id){
	    	$this->load->database();
	    	$this->db->select('contract_services.*');
	    	$this->db->where('contract_services.id', $id);
			$query = $this->db->get('contract_services');
			return $query->row_array();
  		}

  		function get_company_by_id($id){
	    	$this->load->database();
	    	$this->db->select('contract_companies.*');
	    	$this->db->where('contract_companies.id', $id);
			$query = $this->db->get('contract_companies');
			return $query->row_array();
  		}

  		function update_contract($data, $contr_id) {
			$this->load->database();
			$this->db->where('contract.id', $contr_id);		
			$this->db->update('contract', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function clear_day($contr_id) {
	  		$this->load->database();
	  		$this->db->where('contract_days.contr_id', $contr_id);		
			$this->db->delete('contract_days');
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
  		}

  		function get_signature_identity($sign_id){
  			$this->load->database();
			$query = $this->db->query('SELECT contract.hotel_id, contract_signature.contr_id FROM contract_signature JOIN contract ON contract_signature.contr_id = contract.id WHERE contract_signature.id ='.$sign_id);
  			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  		}

  		function get_signature_id($sign_id) {
			$this->load->database();
			$this->db->select('contract_signature.contr_id, contract_signature.role_id, contract_signature.department_id, contract_signature.user_id');
			$this->db->where('contract_signature.id', $sign_id);	
			$query = $this->db->get('contract_signature');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
		}

  		function unsign($id){
	  		$this->load->database();
			$query = $this->db->query('UPDATE contract_signature SET user_id = NULL, reject = 0 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
	  	}

  		function reject($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE contract_signature SET user_id = '.$uid.', reject = 1 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function sign($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE contract_signature SET user_id = '.$uid.' WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function insert_comment($data){
			$this->db->insert('contract_comments', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function update_comment_files($assumed_id, $comment_id) {
  			$this->load->database();
  			$this->db->query('UPDATE contract_comment_filles SET comment_id = "'.$comment_id.'" WHERE comment_id = "'.$assumed_id.'"');
  		}

  		function get_by_comment_fille($comment_id){
	    	$this->load->database();
			$this->db->select('contract_comment_filles.*, users.fullname as user_name');
			$this->db->join('users', 'contract_comment_filles.user_id = users.id','left');
			$this->db->where('comment_id', $comment_id);
			$query = $this->db->get('contract_comment_filles');
			return $query->result_array();
  		}

  		function add_comment_fille($comment_id, $name, $user_id) {
	  		$this->load->database();
	  		$this->db->query('INSERT INTO contract_comment_filles(comment_id, name, user_id) VALUES("'.$comment_id.'","'.$name.'","'.$user_id.'")');
	  	}

	  	function remove_comment_fille($id) {
	      $this->load->database();
	      $this->db->query('DELETE FROM contract_comment_filles WHERE id = '.$id);
	    }

		function create_summary($data) {
			$this->load->database();
			$this->db->insert('contract_summary', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function get_contracts($hotel, $service) {
			$this->db->select('contract.*, hotels.name as hotel_name, hotels.logo As logo, users.fullname as user_name, contract_services.name as service_name, contract_companies.name as company_name');
			$this->db->join('hotels', 'contract.hotel_id = hotels.id','left');
			$this->db->join('users', 'contract.user_id = users.id','left');
			$this->db->join('contract_services', 'contract.service_id = contract_services.id', 'left');
			$this->db->join('contract_companies', 'contract.company_id = contract_companies.id', 'left');
			$this->db->where('contract.hotel_id', $hotel);		
			$this->db->where('contract.service_id', $service);	
        	$this->db->order_by('timestamp', 'DESC');
			$query = $this->db->get('contract');
			return $query->result_array();
		}

		function update_summary($data, $sum_id) {
			$this->load->database();
			$this->db->where('contract_summary.id', $sum_id);		
			$this->db->update('contract_summary', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function sum_sign (){
  			$this->load->database();
			$this->db->select('contract_summary_role.*');
			$query = $this->db->get('contract_summary_role');
			return $query->result_array();  	
		}

		function sum_do_sign($sum_id){
  	 		$this->load->database();
			$this->db->select('contract_summary_signature.*');
			$this->db->where('contract_summary_signature.sum_id', $sum_id);		
			$query = $this->db->get('contract_summary_signature');
			return $query->num_rows();  	
		}

		function add_sum_signature($sum_id, $role_id, $department_id,  $rank){
	    	$this->load->database();
			$query = $this->db->query('INSERT INTO contract_summary_signature(sum_id, role_id, department_id, rank) VALUES("'.$sum_id.'", "'.$role_id.'", "'.$department_id.'", "'.$rank.'")');
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
  		}

		function get_summary($sum_id) {
			$this->db->select('contract_summary.*, hotels.name as hotel_name, hotels.logo As logo, users.fullname as user_name');
			$this->db->join('hotels', 'contract_summary.hotel_id = hotels.id','left');
			$this->db->join('users', 'contract_summary.user_id = users.id','left');
			$this->db->where('contract_summary.id', $sum_id);		
			$query = $this->db->get('contract_summary');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
		}

		function get_summary_fille($sum_id){
	    	$this->load->database();
			$this->db->select('contract_summary_filles.*, users.fullname as user_name');
			$this->db->join('users', 'contract_summary_filles.user_id = users.id','left');
			$this->db->where('sum_id', $sum_id);
			$query = $this->db->get('contract_summary_filles');
			return $query->result_array();
  		}

  		function add_summary_fille($sum_id, $name, $user_id) {
	  		$this->load->database();
	  		$this->db->query('INSERT INTO contract_summary_filles(sum_id, name, user_id) VALUES("'.$sum_id.'","'.$name.'","'.$user_id.'")');
	  	}

	  	function remove_summary_fille($id) {
	      $this->load->database();
	      $this->db->query('DELETE FROM contract_summary_filles WHERE id = '.$id);
	    }

	    function update_sum_state($sum_id, $state) {
			$this->db->update('contract_summary', array('state_id'=> $state), "id = ".$sum_id);
		}

		function get_sum_by_verbal($sum_id){
	    	$this->load->database();
			$this->db->select('contract_summary_signature.*, roles.role, departments.name as department, users.fullname as user_name');
			$this->db->join('roles', 'contract_summary_signature.role_id = roles.id', 'left');
			$this->db->join('departments', 'contract_summary_signature.department_id = departments.id', 'left');
			$this->db->join('users', 'contract_summary_signature.user_id = users.id', 'left');
			$this->db->where('sum_id', $sum_id);
        	$this->db->order_by('rank');
			$query = $this->db->get('contract_summary_signature');
			return $query->result_array();
  		}

  		function get_cont_verb($contr_id, $rank){
	    	$this->load->database();
			$this->db->select('contract_signature.*');
			$this->db->where('contr_id', $contr_id);
			$this->db->where('rank', $rank);
			$query = $this->db->get('contract_signature');
			return $query->row_array();
  		}

  		function force_sign_sum($sum_id, $data, $role) {
			$this->load->database();
			$this->db->where('contract_summary_signature.sum_id', $sum_id);		
			$this->db->where('contract_summary_signature.role_id', $role);		
			$this->db->update('contract_summary_signature', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

  		function get_sum_comment($sum_id){
			$query = $this->db->query("
				SELECT users.fullname, contract_summary_comments.comment, contract_summary_comments.created FROM contract_summary_comments
				JOIN users on contract_summary_comments.user_id = users.id
				WHERE contract_summary_comments.sum_id =".$sum_id
			);
			return $query->result_array();
  		}

  		function get_sum_signature_identity($sign_id){
  			$this->load->database();
			$query = $this->db->query('SELECT contract_summary.hotel_id, contract_summary_signature.sum_id FROM contract_summary_signature JOIN contract_summary ON contract_summary_signature.sum_id = contract_summary.id WHERE contract_summary_signature.id ='.$sign_id);
  			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  		}

  		function get_signature_sum_id($sign_id) {
			$this->load->database();
			$this->db->select('contract_summary_signature.sum_id, contract_summary_signature.role_id, contract_summary_signature.department_id, contract_summary_signature.user_id');
			$this->db->where('contract_summary_signature.id', $sign_id);	
			$query = $this->db->get('contract_summary_signature');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
		}

  		function unsign_sum($id){
	  		$this->load->database();
			$query = $this->db->query('UPDATE contract_summary_signature SET user_id = NULL, reject = 0 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
	  	}

  		function reject_sum($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE contract_summary_signature SET user_id = '.$uid.', reject = 1 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function sign_sum($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE contract_summary_signature SET user_id = '.$uid.' WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function insert_sum_comment($data){
			$this->db->insert('contract_summary_comments', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}


	}

?>