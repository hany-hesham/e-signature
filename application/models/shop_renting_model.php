<?php

	class shop_renting_model extends CI_Model{

  		function __contruct(){
			parent::__construct;
		}

		function view($user_hotels = FALSE, $state = FALSE) {
  	  		$this->load->database();
			$this->db->select('shop_renting.id, shop_renting.user_id, shop_renting.changes, shop_renting.hotel_id, shop_renting.title, shop_renting.date, shop_renting.state_id, shop_renting.timestamp, hotels.name as hotel_name, users.fullname as name, shop_renting_states.name as state');
			$this->db->join('hotels', 'shop_renting.hotel_id = hotels.id','left');
			$this->db->join('users', 'shop_renting.user_id = users.id','left');
			$this->db->join('shop_renting_states', 'shop_renting.state_id = shop_renting_states.id', 'left');
        	if ($user_hotels) {
          		$this->db->where_in('shop_renting.hotel_id', $user_hotels);
        	}
        	if ($state && $state > 0) {
        		if ($state == 8 || $state == 9 ||  $state == 10) {
					$this->db->where('shop_renting.state_final', $state);	
        		}else{
					$this->db->where('shop_renting.state_id', $state);	
				}
			}else{
				$this->db->where('shop_renting.state_id !=', 0);
			}
        	$this->db->order_by('timestamp', 'DESC');
			$query = $this->db->get('shop_renting');
			return $query->result_array();
		}

		function get_by_verbals($shop_id){
	    	$this->load->database();
			$this->db->select('shop_renting_signature.role_id, shop_renting_signature.rank, shop_renting_signature.department_id, shop_renting_signature.user_id, shop_renting_signature.reject, roles.role, departments.name as department, users.fullname as user_name');
			$this->db->join('roles', 'shop_renting_signature.role_id = roles.id', 'left');
			$this->db->join('departments', 'shop_renting_signature.department_id = departments.id', 'left');
			$this->db->join('users', 'shop_renting_signature.user_id = users.id', 'left');
			$this->db->where('shop_id', $shop_id);
        	$this->db->order_by('shop_renting_signature.rank');
			$query = $this->db->get('shop_renting_signature');
			return $query->result_array();
  		}

  		function get_states(){
	    	$this->load->database();
			$this->db->select('shop_renting_states.*');
			$x = array('0' => 2, '1' => 3, '2' => 10);
			$this->db->where_not_in('shop_renting_states.id', $x);
			$query = $this->db->get('shop_renting_states');
			return $query->result_array();
  		}

		function create_shop($data) {
			$this->load->database();
			$this->db->insert('shop_renting', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function update_files($assumed_id, $shop_id) {
  			$this->load->database();
  			$this->db->query('UPDATE shop_renting_filles SET shop_id = "'.$shop_id.'" WHERE shop_id = "'.$assumed_id.'"');
  		}

  		function create_offer($data) {
			$this->load->database();
			$this->db->insert('shop_renting_offers', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function update_choose($shop_id, $choosen_id) {
			$this->db->update('shop_renting', array('choosen_id'=> $choosen_id), "id = ".$shop_id);
  		}

  		function update_message_id($id, $message_id) {
		      $this->load->database();
		      $this->db->where('shop_renting.id', $id);
		      //if(isset($message_id)){
		      $msg_id = $this->db->update('shop_renting', array('message_id' => $message_id));
		      //die(print_r($msg_id));
		      //}else{
		              //die(print_r($message_id));
		      //}
		  }

		function shop_sign(){
  			$this->load->database();
			$this->db->select('shop_renting_role.*');
			$query = $this->db->get('shop_renting_role');
			return $query->result_array();  	
		}

		function shop_do_sign($shop_id){
  	 		$this->load->database();
			$this->db->select('shop_renting_signature.*');
			$this->db->where('shop_renting_signature.shop_id', $shop_id);		
			$query = $this->db->get('shop_renting_signature');
			return $query->num_rows();  	
		}

		function add_signature($shop_id, $role_id, $department_id,  $rank){
	    	$this->load->database();
			$query = $this->db->query('INSERT INTO shop_renting_signature(shop_id, role_id, department_id, rank) VALUES("'.$shop_id.'", "'.$role_id.'", "'.$department_id.'", "'.$rank.'")');
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
  		}

  		function get_currency(){
	    	$this->load->database();
			$this->db->select('currency.*');
			$query = $this->db->get('currency');
			return $query->result_array();
  		}

  		function get_type(){
	    	$this->load->database();
			$this->db->select('shop_renting_types.*');
			$query = $this->db->get('shop_renting_types');
			return $query->result_array();
  		}

  		function get_by_fille($shop_id){
	    	$this->load->database();
			$this->db->select('shop_renting_filles.*, users.fullname as user_name');
			$this->db->join('users', 'shop_renting_filles.user_id = users.id','left');
			$this->db->where('shop_id', $shop_id);
			$query = $this->db->get('shop_renting_filles');
			return $query->result_array();
  		}

  		function add_fille($shop_id, $name, $user_id) {
	  		$this->load->database();
	  		$this->db->query('INSERT INTO shop_renting_filles(shop_id, name, user_id) VALUES("'.$shop_id.'","'.$name.'","'.$user_id.'")');
	  	}

	  	function remove_fille($id) {
	      $this->load->database();
	      $this->db->query('DELETE FROM shop_renting_filles WHERE id = '.$id);
	    }

	    function get_shop($shop_id) {
			$this->db->select('shop_renting.*, hotels.name as hotel_name, hotels.logo As logo, users.fullname as name, shop_renting_offers.name as offer, change_offer.name as offer_change,shop_renting_offers.start_from,shop_renting_offers.start_from,
				shop_renting_offers.rent,shop_renting_states.name as state');
			$this->db->join('hotels', 'shop_renting.hotel_id = hotels.id','left');
			$this->db->join('users', 'shop_renting.user_id = users.id','left');
			$this->db->join('shop_renting_offers', 'shop_renting.choosen_id = shop_renting_offers.id', 'left');
			$this->db->join('shop_renting_offers AS change_offer', 'shop_renting.change_choosen_id = change_offer.id', 'left');
			$this->db->join('shop_renting_states', 'shop_renting.state_id = shop_renting_states.id', 'left');
			$this->db->where('shop_renting.id', $shop_id);		
			$query = $this->db->get('shop_renting');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
		}

		function update_state($shop_id, $state) {
			$this->db->update('shop_renting', array('state_id'=> $state), "id = ".$shop_id);
		}

		function get_change_by_verbal($shop_id){
	    	$this->load->database();
			$this->db->select('shop_renting_change_signature.*, roles.role, departments.name as department, users.fullname as user_name');
			$this->db->join('roles', 'shop_renting_change_signature.role_id = roles.id', 'left');
			$this->db->join('departments', 'shop_renting_change_signature.department_id = departments.id', 'left');
			$this->db->join('users', 'shop_renting_change_signature.user_id = users.id', 'left');
        	$this->db->order_by('rank');
			$this->db->where('shop_id', $shop_id);
			$query = $this->db->get('shop_renting_change_signature');
			return $query->result_array();
  		}

  		function get_by_verbal($shop_id){
	    	$this->load->database();
			$this->db->select('shop_renting_signature.*, roles.role, departments.name as department, users.fullname as user_name');
			$this->db->join('roles', 'shop_renting_signature.role_id = roles.id', 'left');
			$this->db->join('departments', 'shop_renting_signature.department_id = departments.id', 'left');
			$this->db->join('users', 'shop_renting_signature.user_id = users.id', 'left');
        	$this->db->order_by('rank');
			$this->db->where('shop_id', $shop_id);
			$query = $this->db->get('shop_renting_signature');
			return $query->result_array();
  		}

  		function get_all_offers($shop_id) {
			$this->db->select('shop_renting_offers.*, users.fullname as user_name, shop_renting_types.name as type, currency1.name as currency1, currency2.name as currency2, currency3.name as currency3');
			$this->db->join('users', 'shop_renting_offers.user_id = users.id','left');
			$this->db->join('shop_renting_types', 'shop_renting_offers.type_id = shop_renting_types.id','left');
			$this->db->join('currency as currency1', 'shop_renting_offers.currency_id = currency1.id','left');
			$this->db->join('currency as currency2', 'shop_renting_offers.currency1_id = currency2.id','left');
			$this->db->join('currency as currency3', 'shop_renting_offers.currency2_id = currency3.id','left');
        	$this->db->order_by('id');
			$this->db->where('shop_renting_offers.shop_id', $shop_id);
			$query = $this->db->get('shop_renting_offers');
			return ($query->num_rows() > 0 )? $query->result_array() : FALSE;
		}

  		function get_change_offers($shop_id, $change = FALSE) {
			$this->db->select('shop_renting_offers.*, users.fullname as user_name, shop_renting_types.name as type, currency1.name as currency1, currency2.name as currency2, currency3.name as currency3');
			$this->db->join('users', 'shop_renting_offers.user_id = users.id','left');
			$this->db->join('shop_renting_types', 'shop_renting_offers.type_id = shop_renting_types.id','left');
			$this->db->join('currency as currency1', 'shop_renting_offers.currency_id = currency1.id','left');
			$this->db->join('currency as currency2', 'shop_renting_offers.currency1_id = currency2.id','left');
			$this->db->join('currency as currency3', 'shop_renting_offers.currency2_id = currency3.id','left');
        	$this->db->order_by('id');
			$this->db->where('shop_renting_offers.shop_id', $shop_id);
			$this->db->where('shop_renting_offers.type_id !=', 1);
			if ($change) {
				$this->db->where('shop_renting_offers.changed', $change);
			}else{
				$this->db->where('shop_renting_offers.changed', 0);
			}
			$query = $this->db->get('shop_renting_offers');
			return ($query->num_rows() > 0 )? $query->result_array() : FALSE;
		}

		function get_offers($shop_id, $change = FALSE) {
			$this->db->select('shop_renting_offers.*, users.fullname as user_name, shop_renting_types.name as type, currency1.name as currency1, currency2.name as currency2, currency3.name as currency3');
			$this->db->join('users', 'shop_renting_offers.user_id = users.id','left');
			$this->db->join('shop_renting_types', 'shop_renting_offers.type_id = shop_renting_types.id','left');
			$this->db->join('currency as currency1', 'shop_renting_offers.currency_id = currency1.id','left');
			$this->db->join('currency as currency2', 'shop_renting_offers.currency1_id = currency2.id','left');
			$this->db->join('currency as currency3', 'shop_renting_offers.currency2_id = currency3.id','left');
        	$this->db->order_by('id');
			$this->db->where('shop_renting_offers.shop_id', $shop_id);
			if ($change) {
				$this->db->where('shop_renting_offers.changed', $change);
			}else{
				$this->db->where('shop_renting_offers.changed', 0);
			}
			$query = $this->db->get('shop_renting_offers');
			return ($query->num_rows() > 0 )? $query->result_array() : FALSE;
		}

		function get_comment($shop_id){
			$query = $this->db->query("
				SELECT users.fullname, shop_renting_comments.comment, shop_renting_comments.timestamp FROM shop_renting_comments
				JOIN users on shop_renting_comments.user_id = users.id
				WHERE shop_renting_comments.shop_id =".$shop_id
			);
			return $query->result_array();
  		}

  		function update_shop($shop_id, $data) {
			$this->load->database();
			$this->db->where('shop_renting.id', $shop_id);		
			$this->db->update('shop_renting', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

  		function update_offer($id, $shop_id, $data) {
			$this->load->database();
			$this->db->where('shop_renting_offers.shop_id', $shop_id);	
			$this->db->where('shop_renting_offers.id', $id);		
			$this->db->update('shop_renting_offers', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function update_change_choose($shop_id, $choosen_id) {
			$this->db->update('shop_renting', array('change_choosen_id'=> $choosen_id), "id = ".$shop_id);
  		}

		function shop_change_do_sign($shop_id){
  	 		$this->load->database();
			$this->db->select('shop_renting_change_signature.*');
			$this->db->where('shop_renting_change_signature.shop_id', $shop_id);		
			$query = $this->db->get('shop_renting_change_signature');
			return $query->num_rows();  	
		}

		function add_change_signature($shop_id, $role_id, $department_id,  $rank){
	    	$this->load->database();
			$query = $this->db->query('INSERT INTO shop_renting_change_signature(shop_id, role_id, department_id, rank) VALUES("'.$shop_id.'", "'.$role_id.'", "'.$department_id.'", "'.$rank.'")');
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
  		}

		function get_signature_identity($sign_id){
  			$this->load->database();
			$query = $this->db->query('SELECT shop_renting.hotel_id, shop_renting_signature.shop_id FROM shop_renting_signature JOIN shop_renting ON shop_renting_signature.shop_id = shop_renting.id WHERE shop_renting_signature.id ='.$sign_id);
  			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  		}

  		function unsign($id){
	  		$this->load->database();
			$query = $this->db->query('UPDATE shop_renting_signature SET user_id = NULL, reject = 0 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
	  	}

	  	function get_change_signature_identity($sign_id){
  			$this->load->database();
			$query = $this->db->query('SELECT shop_renting.hotel_id, shop_renting_change_signature.shop_id FROM shop_renting_change_signature JOIN shop_renting ON shop_renting_change_signature.shop_id = shop_renting.id WHERE shop_renting_change_signature.id ='.$sign_id);
  			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  		}

  		function unsign_change($id){
	  		$this->load->database();
			$query = $this->db->query('UPDATE shop_renting_change_signature SET user_id = NULL, reject = 0 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
	  	}

	  	function reject($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE shop_renting_signature SET user_id = '.$uid.', reject = 1 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function sign($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE shop_renting_signature SET user_id = '.$uid.' WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function reject_change($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE shop_renting_change_signature SET user_id = '.$uid.', reject = 1 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function sign_change($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE shop_renting_change_signature SET user_id = '.$uid.' WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function insert_comment($data){
			$this->db->insert('shop_renting_comments', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function shop_final_sign(){
  			$this->load->database();
			$this->db->select('shop_renting_final_role.*');
			$query = $this->db->get('shop_renting_final_role');
			return $query->result_array();  	
		}

		function update_final_state($shop_id, $state) {
			$this->db->update('shop_renting', array('state_final'=> $state), "id = ".$shop_id);
		}
	  function getby_role($role_id) {
            $this->load->database();
            $this->db->select('users.id,users.fullname,users.email,users.role_id');
            $this->db->join('roles','users.role_id = roles.id','left');
            $this->db->where_in('users.role_id',array('57','59'));
            $query=$this->db->get('users');
            return $query->result_array();			
	        }	
	 function new_log($data) {
			$this->db->insert('shop_log', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

	function get_log($target_id) {
			$this->db->select('shop_log.*, users.fullname as name');
			$this->db->join('users', 'shop_log.user_id = users.id','left');
			$this->db->where('shop_log.target_id', $target_id);		
			$this->db->where('shop_log.type !=', "Email");		
			$this->db->where('shop_log.type !=', "Comment");		
        	$this->db->order_by('timestamp', 'DESC');
			$query = $this->db->get('shop_log');
			return $query->result_array();
	}

	function update_log($assumed_id, $shop_id) {
  			$this->load->database();
  			$this->db->query('UPDATE shop_log SET target_id = "'.$shop_id.'" WHERE target_id = "'.$assumed_id.'"');
  		}
  	function get_signature_id($sign_id) {
			$this->load->database();
			$this->db->select('shop_renting_signature.shop_id, shop_renting_signature.role_id, shop_renting_signature.department_id, shop_renting_signature.user_id');
			$this->db->where('shop_renting_signature.id', $sign_id);	
			$query = $this->db->get('shop_renting_signature');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
		}	
	function get_shop_adjust($shop_id) {
			$this->db->select('shop_adjustment.*');
			$this->db->where('shop_adjustment.shop_id', $shop_id);		
			$query = $this->db->get('shop_adjustment');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
		}	
       	

	}

?>