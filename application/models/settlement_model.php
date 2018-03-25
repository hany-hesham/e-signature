<?php

	class settlement_model extends CI_Model{
	
  		function __contruct(){
			parent::__construct;
		}

		function getall(){
		    $this->load->database();
			$this->db->select('users.id as userid,users.*,settlement.*,hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('users', 'settlement.user_id = users.id','left');
			$this->db->join('hotels', 'settlement.hotel_id = hotels.id','left');
			$query = $this->db->get('settlement');
			return $query->result_array();
	  	}

	  	function update_files($assumed_id, $set_id) {
	  		$this->load->database();
	  		$this->db->query('UPDATE settlement_filles SET set_id = "'.$set_id.'" WHERE set_id = "'.$assumed_id.'"');
	  		}

	  	function getby_fille($set_id){
		    $this->load->database();
			$this->db->where('set_id', $set_id);
			$query = $this->db->get('settlement_filles');
			return $query->result_array();
	  	}

	  	function add($set_id, $name) {
	  		$this->load->database();
	  		$this->db->query('INSERT INTO settlement_filles(set_id,name) VALUES("'.$set_id.'","'.$name.'")');

	  	}

	  	function remove($id) {
	      $this->load->database();

	      $this->db->query('DELETE FROM settlement_filles WHERE id = '.$id);

	    }

	    function getall_state($state = FALSE, $from, $to){
		    $this->load->database();
			$this->db->select('users.id as userid,users.*,settlement.*,hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('users', 'settlement.user_id = users.id','left');
			$this->db->join('hotels', 'settlement.hotel_id = hotels.id','left');
			if ($state) {
				$this->db->where('settlement.status', $state);
			}
			$this->db->where('settlement.timestamp >=', $from);
	        $this->db->where('settlement.timestamp <=', $to);
			$this->db->order_by('hotel_id');
			$query = $this->db->get('settlement');
			return $query->result_array();
	  	}

	  	function update_message_id($id, $message_id) {
		      $this->load->database();
		      $this->db->where('settlement.id', $id);
		      //if(isset($message_id)){
		      $msg_id = $this->db->update('settlement', array('message_id' => $message_id));
		      //die(print_r($msg_id));
		      //}else{
		              //die(print_r($message_id));
		      //}
		  }

	  	function getall_state_value($state = FALSE, $from, $to, $hnm){
		    $this->load->database();
			$this->db->select('settlement.amount, settlement.actual, hotels.name as hotel_name');
			$this->db->join('users', 'settlement.user_id = users.id','left');
			$this->db->join('hotels', 'settlement.hotel_id = hotels.id','left');
			if ($state) {
				$this->db->where('settlement.status', $state);
			}
			$this->db->where('hotels.name', $hnm);
			$this->db->where('settlement.timestamp >=', $from);
	        $this->db->where('settlement.timestamp <=', $to);
			$this->db->order_by('hotel_id');
			$query = $this->db->get('settlement');
			return $query->result_array();
	  	}

	  	function getall_state_count($state = FALSE, $from, $to){
		    $this->load->database();
			$this->db->select('users.id as userid,users.*,settlement.*,hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('users', 'settlement.user_id = users.id','left');
			$this->db->join('hotels', 'settlement.hotel_id = hotels.id','left');
			if ($state) {
				$this->db->where('settlement.status', $state);
			}
			$this->db->where('settlement.timestamp >=', $from);
	        $this->db->where('settlement.timestamp <=', $to);
			$this->db->order_by('hotel_id');
			$query = $this->db->get('settlement');
			return $query->num_rows();
	  	}

	  	function get_state($state = FALSE, $from, $to, $hid = FALSE){
		    $this->load->database();
			$this->db->select('users.id as userid,users.*,settlement.*,hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('users', 'settlement.user_id = users.id','left');
			$this->db->join('hotels', 'settlement.hotel_id = hotels.id','left');
			if ($hid) {
				$this->db->where('settlement.hotel_id', $hid);
			}
			if ($state) {
				$this->db->where('settlement.status', $state);
			}
			$this->db->where('settlement.timestamp >=', $from);
	        $this->db->where('settlement.timestamp <=', $to);
			$this->db->order_by('hotel_id');
			$query = $this->db->get('settlement');
			return $query->result_array();
	  	}

	  	function get_state_count($state = FALSE, $from, $to, $hid = FALSE){
		    $this->load->database();
			$this->db->select('users.id as userid,users.*,settlement.*,hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('users', 'settlement.user_id = users.id','left');
			$this->db->join('hotels', 'settlement.hotel_id = hotels.id','left');
			if ($hid) {
				$this->db->where('settlement.hotel_id', $hid);
			}
			if ($state) {
				$this->db->where('settlement.status', $state);
			}
			$this->db->where('settlement.timestamp >=', $from);
	        $this->db->where('settlement.timestamp <=', $to);
			$this->db->order_by('hotel_id');
			$query = $this->db->get('settlement');
			return $query->num_rows();
	  	}

	  	function getall_approved($from, $to){
		    $this->load->database();
			$this->db->select('users.id as userid,users.*,settlement.*,hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('users', 'settlement.user_id = users.id','left');
			$this->db->join('hotels', 'settlement.hotel_id = hotels.id','left');
			$this->db->where('settlement.state_id', 2);
			$this->db->where('settlement.timestamp >=', $from);
	        $this->db->where('settlement.timestamp <=', $to);
			$this->db->order_by('hotel_id');
			$query = $this->db->get('settlement');
			return $query->result_array();
	  	}

	  	function get_app_value($from, $to, $hnm){
		    $this->load->database();
			$this->db->select('settlement.amount, settlement.actual, hotels.name as hotel_name');
			$this->db->join('users', 'settlement.user_id = users.id','left');
			$this->db->join('hotels', 'settlement.hotel_id = hotels.id','left');
			$this->db->where('settlement.state_id', 2);
			$this->db->where('hotels.name', $hnm);
			$this->db->where('settlement.timestamp >=', $from);
	        $this->db->where('settlement.timestamp <=', $to);
			$this->db->order_by('hotel_id');
			$query = $this->db->get('settlement');
			return $query->result_array();
	  	}

	  	function getall_approved_count($from, $to){
		    $this->load->database();
			$this->db->select('users.id as userid,users.*,settlement.*,hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('users', 'settlement.user_id = users.id','left');
			$this->db->join('hotels', 'settlement.hotel_id = hotels.id','left');
			$this->db->where('settlement.state_id', 2);
			$this->db->where('settlement.timestamp >=', $from);
	        $this->db->where('settlement.timestamp <=', $to);
			$this->db->order_by('hotel_id');
			$query = $this->db->get('settlement');
			return $query->num_rows();
	  	}

	  	function getall_chairman($from, $to){
		    $this->load->database();
			$this->db->select('users.id as userid,users.*,settlement.*,hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('users', 'settlement.user_id = users.id','left');
			$this->db->join('hotels', 'settlement.hotel_id = hotels.id','left');
			$this->db->where('settlement.state_id', 4);
			$this->db->where('settlement.timestamp >=', $from);
	        $this->db->where('settlement.timestamp <=', $to);
			$this->db->order_by('hotel_id');
			$query = $this->db->get('settlement');
			return $query->result_array();
	  	}

	  	function get_char_value($from, $to, $hnm){
		    $this->load->database();
			$this->db->select('settlement.amount, settlement.actual, hotels.name as hotel_name');
			$this->db->join('users', 'settlement.user_id = users.id','left');
			$this->db->join('hotels', 'settlement.hotel_id = hotels.id','left');
			$this->db->where('settlement.state_id', 4);
			$this->db->where('hotels.name', $hnm);
			$this->db->where('settlement.timestamp >=', $from);
	        $this->db->where('settlement.timestamp <=', $to);
			$this->db->order_by('hotel_id');
			$query = $this->db->get('settlement');
			return $query->result_array();
	  	}

	  	function getall_chairman_count($from, $to){
		    $this->load->database();
			$this->db->select('users.id as userid,users.*,settlement.*,hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('users', 'settlement.user_id = users.id','left');
			$this->db->join('hotels', 'settlement.hotel_id = hotels.id','left');
			$this->db->where('settlement.state_id', 4);
			$this->db->where('settlement.timestamp >=', $from);
	        $this->db->where('settlement.timestamp <=', $to);
			$this->db->order_by('hotel_id');
			$query = $this->db->get('settlement');
			return $query->num_rows();
	  	}

	  	function getall_close($from, $to){
		    $this->load->database();
			$this->db->select('users.id as userid,users.*,settlement.*,hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('users', 'settlement.user_id = users.id','left');
			$this->db->join('hotels', 'settlement.hotel_id = hotels.id','left');
			$this->db->where('settlement.closed', 1);
			$this->db->where('settlement.timestamp >=', $from);
	        $this->db->where('settlement.timestamp <=', $to);
			$this->db->order_by('hotel_id');
			$query = $this->db->get('settlement');
			return $query->result_array();
	  	}

	  	function get_close_value($from, $to, $hnm){
		    $this->load->database();
			$this->db->select('settlement.amount, settlement.actual, hotels.name as hotel_name');
			$this->db->join('users', 'settlement.user_id = users.id','left');
			$this->db->join('hotels', 'settlement.hotel_id = hotels.id','left');
			$this->db->where('settlement.closed', 1);
			$this->db->where('hotels.name', $hnm);
			$this->db->where('settlement.timestamp >=', $from);
	        $this->db->where('settlement.timestamp <=', $to);
			$this->db->order_by('hotel_id');
			$query = $this->db->get('settlement');
			return $query->result_array();
	  	}

	  	function getall_close_count($from, $to){
		    $this->load->database();
			$this->db->select('users.id as userid,users.*,settlement.*,hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('users', 'settlement.user_id = users.id','left');
			$this->db->join('hotels', 'settlement.hotel_id = hotels.id','left');
			$this->db->where('settlement.closed', 1);
			$this->db->where('settlement.timestamp >=', $from);
	        $this->db->where('settlement.timestamp <=', $to);
			$this->db->order_by('hotel_id');
			$query = $this->db->get('settlement');
			return $query->num_rows();
	  	}

	  	function getall_wait($from, $to){
		    $this->load->database();
			$this->db->select('users.id as userid,users.*,settlement.*,hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('users', 'settlement.user_id = users.id','left');
			$this->db->join('hotels', 'settlement.hotel_id = hotels.id','left');
			$this->db->where('settlement.state_id !=', 2, 3, 0);
			$this->db->where('settlement.timestamp >=', $from);
	        $this->db->where('settlement.timestamp <=', $to);
			$this->db->order_by('hotel_id');
			$query = $this->db->get('settlement');
			return $query->result_array();
	  	}

	  	function get_wait_value($from, $to, $hnm){
		    $this->load->database();
			$this->db->select('settlement.amount, settlement.actual, hotels.name as hotel_name');
			$this->db->join('users', 'settlement.user_id = users.id','left');
			$this->db->join('hotels', 'settlement.hotel_id = hotels.id','left');
			$this->db->where('settlement.state_id !=', 2, 3, 0);
			$this->db->where('hotels.name', $hnm);
			$this->db->where('settlement.timestamp >=', $from);
	        $this->db->where('settlement.timestamp <=', $to);
			$this->db->order_by('hotel_id');
			$query = $this->db->get('settlement');
			return $query->result_array();
	  	}

	  	function getall_wait_count($from, $to){
		    $this->load->database();
			$this->db->select('users.id as userid,users.*,settlement.*,hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('users', 'settlement.user_id = users.id','left');
			$this->db->join('hotels', 'settlement.hotel_id = hotels.id','left');
			$this->db->where('settlement.state_id !=', 2, 3, 0);
			$this->db->where('settlement.timestamp >=', $from);
	        $this->db->where('settlement.timestamp <=', $to);
			$this->db->order_by('hotel_id');
			$query = $this->db->get('settlement');
			return $query->num_rows();
	  	}

	  	function getall_reject($from, $to){
		    $this->load->database();
			$this->db->select('users.id as userid,users.*,settlement.*,hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('users', 'settlement.user_id = users.id','left');
			$this->db->join('hotels', 'settlement.hotel_id = hotels.id','left');
			$this->db->where('settlement.state_id =', 3);
			$this->db->where('settlement.timestamp >=', $from);
	        $this->db->where('settlement.timestamp <=', $to);
			$this->db->order_by('hotel_id');
			$query = $this->db->get('settlement');
			return $query->result_array();
	  	}

	  	function get_reje_value($from, $to, $hnm){
		    $this->load->database();
			$this->db->select('settlement.amount, settlement.actual, hotels.name as hotel_name');
			$this->db->join('users', 'settlement.user_id = users.id','left');
			$this->db->join('hotels', 'settlement.hotel_id = hotels.id','left');
			$this->db->where('settlement.state_id =', 3);
			$this->db->where('hotels.name', $hnm);
			$this->db->where('settlement.timestamp >=', $from);
	        $this->db->where('settlement.timestamp <=', $to);
			$this->db->order_by('hotel_id');
			$query = $this->db->get('settlement');
			return $query->result_array();
	  	}

	  	function getall_reject_count($from, $to){
		    $this->load->database();
			$this->db->select('users.id as userid,users.*,settlement.*,hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('users', 'settlement.user_id = users.id','left');
			$this->db->join('hotels', 'settlement.hotel_id = hotels.id','left');
			$this->db->where('settlement.state_id =', 3);
			$this->db->where('settlement.timestamp >=', $from);
	        $this->db->where('settlement.timestamp <=', $to);
			$this->db->order_by('hotel_id');
			$query = $this->db->get('settlement');
			return $query->num_rows();
	  	}

	  	function get_approved($hid, $from, $to){
		    $this->load->database();
			$this->db->select('users.id as userid,users.*,settlement.*,hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('users', 'settlement.user_id = users.id','left');
			$this->db->join('hotels', 'settlement.hotel_id = hotels.id','left');
			$this->db->where('settlement.hotel_id', $hid);		
			$this->db->where('settlement.state_id', 2);
			$this->db->where('settlement.timestamp >=', $from);
	        $this->db->where('settlement.timestamp <=', $to);
			$this->db->order_by('hotel_id');
			$query = $this->db->get('settlement');
			return $query->result_array();
	  	}

	  	function get_approved_count($hid, $from, $to){
		    $this->load->database();
			$this->db->select('users.id as userid,users.*,settlement.*,hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('users', 'settlement.user_id = users.id','left');
			$this->db->join('hotels', 'settlement.hotel_id = hotels.id','left');
			$this->db->where('settlement.hotel_id', $hid);		
			$this->db->where('settlement.state_id', 2);
			$this->db->where('settlement.timestamp >=', $from);
	        $this->db->where('settlement.timestamp <=', $to);
			$this->db->order_by('hotel_id');
			$query = $this->db->get('settlement');
			return $query->num_rows();
	  	}

	  	function get_chairman($hid, $from, $to){
		    $this->load->database();
			$this->db->select('users.id as userid,users.*,settlement.*,hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('users', 'settlement.user_id = users.id','left');
			$this->db->join('hotels', 'settlement.hotel_id = hotels.id','left');
			$this->db->where('settlement.hotel_id', $hid);		
			$this->db->where('settlement.state_id', 4);
			$this->db->where('settlement.timestamp >=', $from);
	        $this->db->where('settlement.timestamp <=', $to);
			$this->db->order_by('hotel_id');
			$query = $this->db->get('settlement');
			return $query->result_array();
	  	}

	  	function get_chairman_count($hid, $from, $to){
		    $this->load->database();
			$this->db->select('users.id as userid,users.*,settlement.*,hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('users', 'settlement.user_id = users.id','left');
			$this->db->join('hotels', 'settlement.hotel_id = hotels.id','left');
			$this->db->where('settlement.hotel_id', $hid);		
			$this->db->where('settlement.state_id', 4);
			$this->db->where('settlement.timestamp >=', $from);
	        $this->db->where('settlement.timestamp <=', $to);
			$this->db->order_by('hotel_id');
			$query = $this->db->get('settlement');
			return $query->num_rows();
	  	}

	  	function get_close($hid, $from, $to){
		    $this->load->database();
			$this->db->select('users.id as userid,users.*,settlement.*,hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('users', 'settlement.user_id = users.id','left');
			$this->db->join('hotels', 'settlement.hotel_id = hotels.id','left');
			$this->db->where('settlement.hotel_id', $hid);		
			$this->db->where('settlement.closed', 1);
			$this->db->where('settlement.timestamp >=', $from);
	        $this->db->where('settlement.timestamp <=', $to);
			$this->db->order_by('hotel_id');
			$query = $this->db->get('settlement');
			return $query->result_array();
	  	}

	  	function get_close_count($hid, $from, $to){
		    $this->load->database();
			$this->db->select('users.id as userid,users.*,settlement.*,hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('users', 'settlement.user_id = users.id','left');
			$this->db->join('hotels', 'settlement.hotel_id = hotels.id','left');
			$this->db->where('settlement.hotel_id', $hid);		
			$this->db->where('settlement.closed', 1);
			$this->db->where('settlement.timestamp >=', $from);
	        $this->db->where('settlement.timestamp <=', $to);
			$this->db->order_by('hotel_id');
			$query = $this->db->get('settlement');
			return $query->num_rows();
	  	}

	  	function get_wait($hid, $from, $to){
		    $this->load->database();
			$this->db->select('users.id as userid,users.*,settlement.*,hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('users', 'settlement.user_id = users.id','left');
			$this->db->join('hotels', 'settlement.hotel_id = hotels.id','left');
			$this->db->where('settlement.hotel_id', $hid);		
			$this->db->where('settlement.state_id !=', 2, 3, 0);
			$this->db->where('settlement.timestamp >=', $from);
	        $this->db->where('settlement.timestamp <=', $to);
			$this->db->order_by('hotel_id');
			$query = $this->db->get('settlement');
			return $query->result_array();
	  	}

	  	function get_wait_count($hid, $from, $to){
		    $this->load->database();
			$this->db->select('users.id as userid,users.*,settlement.*,hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('users', 'settlement.user_id = users.id','left');
			$this->db->join('hotels', 'settlement.hotel_id = hotels.id','left');
			$this->db->where('settlement.hotel_id', $hid);		
			$this->db->where('settlement.state_id !=', 2, 3, 0);
			$this->db->where('settlement.timestamp >=', $from);
	        $this->db->where('settlement.timestamp <=', $to);
			$this->db->order_by('hotel_id');
			$query = $this->db->get('settlement');
			return $query->num_rows();
	  	}

	  	function get_reject($hid, $from, $to){
		    $this->load->database();
			$this->db->select('users.id as userid,users.*,settlement.*,hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('users', 'settlement.user_id = users.id','left');
			$this->db->join('hotels', 'settlement.hotel_id = hotels.id','left');
			$this->db->where('settlement.hotel_id', $hid);		
			$this->db->where('settlement.state_id =', 3);
			$this->db->where('settlement.timestamp >=', $from);
	        $this->db->where('settlement.timestamp <=', $to);
			$this->db->order_by('hotel_id');
			$query = $this->db->get('settlement');
			return $query->result_array();
	  	}

	  	function get_reject_count($hid, $from, $to){
		    $this->load->database();
			$this->db->select('users.id as userid,users.*,settlement.*,hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('users', 'settlement.user_id = users.id','left');
			$this->db->join('hotels', 'settlement.hotel_id = hotels.id','left');
			$this->db->where('settlement.hotel_id', $hid);		
			$this->db->where('settlement.state_id =', 3);
			$this->db->where('settlement.timestamp >=', $from);
	        $this->db->where('settlement.timestamp <=', $to);
			$this->db->order_by('hotel_id');
			$query = $this->db->get('settlement');
			return $query->num_rows();
	  	}

		function create_settlement($data) {
			$this->load->database();
			$this->db->insert('settlement', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function create_purpose($data) {
			$this->load->database();
			$this->db->insert('purpose', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function getall_type(){
	    	$this->load->database();
			$query = $this->db->get('settlement_type');
			return $query->result_array();
  		}

  		function view($user_hotels = FALSE) {
  	  		$this->load->database();
			$this->db->select('users.id as userid,users.*,settlement.*,hotels.name as hotel_name,hotels.logo As logo, settlement_type.name As type, purpose.set_id');
			$this->db->join('users', 'settlement.user_id = users.id','left');
			$this->db->join('purpose', 'settlement.id = purpose.set_id','left');
			$this->db->join('hotels', 'settlement.hotel_id = hotels.id','left');
			$this->db->join('settlement_type', 'settlement.form_type = settlement_type.id','left');
        	if ($user_hotels) {
          		$this->db->where_in('settlement.hotel_id', $user_hotels);
        	}
        	$this->db->order_by('Date', 'DESC');
			$query = $this->db->get('settlement');
			return $query->result_array();
		}

		function get_settlement($set_id) {
			$this->db->select('settlement.*, hotels.name as hotel_name, hotels.logo As logo, users.fullname as name, settlement_type.name As type');
			$this->db->join('settlement_type', 'settlement.form_type = settlement_type.id','left');	
			$this->db->join('hotels', 'settlement.hotel_id = hotels.id','left');
			$this->db->join('users', 'settlement.user_id = users.id','left');
			$this->db->where('settlement.id', $set_id);		
			$query = $this->db->get('settlement');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
		}

		function get_purpose($set_id) {
			$this->db->select('purpose.*, users.fullname as name');
			$this->db->join('users', 'purpose.user_id = users.id','left');
			$this->db->where('purpose.set_id', $set_id);		
			$query = $this->db->get('purpose');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
		}

		function InsertComment($data){
			$this->db->insert('settlement_comments', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function insert_purpose_comment($data){
			$this->db->insert('purpose_comments', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function GetComment($set_id){
			$query = $this->db->query("
				SELECT users.fullname, settlement_comments.comment, settlement_comments.created	FROM settlement_comments
				JOIN users on settlement_comments.user_id = users.id
				WHERE settlement_comments.set_id =".$set_id);
			return $query->result_array();
  		}

  		function get_purpose_comment($set_id){
			$query = $this->db->query("
				SELECT users.fullname, purpose_comments.comment, purpose_comments.created	FROM purpose_comments
				JOIN users on purpose_comments.user_id = users.id
				WHERE purpose_comments.set_id =".$set_id);
			return $query->result_array();
  		}

  		function getby_verbal($set_id){
	    	$this->load->database();
			$this->db->select('settlement_signature.id, settlement_signature.user_id, settlement_signature.role_id, settlement_signature.timestamp, settlement_signature.rank, roles.role, settlement_signature.reject');
			$this->db->join('roles', 'settlement_signature.role_id = roles.id', 'left');
			$this->db->where('set_id', $set_id);
			$this->db->order_by('rank');
			$query = $this->db->get('settlement_signature');
			return $query->result_array();
  		}

  		function get_count($set_id){
	    	$this->load->database();
			$this->db->select('settlement_signature.*');
			$this->db->where('set_id', $set_id);
			$this->db->order_by('rank');
			$query = $this->db->get('settlement_signature');
			return $query->num_rows();

  		}

  		function purpose_getby_verbal($set_id){
	    	$this->load->database();
			$this->db->select('purpose_signature.id, purpose_signature.user_id, purpose_signature.role_id, purpose_signature.timestamp, purpose_signature.rank, roles.role, purpose_signature.reject');
			$this->db->join('roles', 'purpose_signature.role_id = roles.id', 'left');
			$this->db->where('set_id', $set_id);
			$this->db->order_by('rank');
			$query = $this->db->get('purpose_signature');
			return $query->result_array();
  		}

  		function get_signature_identity($sign_id){
  			$this->load->database();
			$query = $this->db->query('SELECT settlement.hotel_id, settlement_signature.set_id FROM settlement_signature JOIN settlement ON settlement_signature.set_id = settlement.id WHERE settlement_signature.id ='.$sign_id);
  			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  		}

  		function get_purpose_signature_identity($sign_id){
  			$this->load->database();
			$query = $this->db->query('SELECT purpose.hotel_id, purpose_signature.set_id FROM purpose_signature JOIN purpose ON purpose_signature.set_id = purpose.set_id WHERE purpose_signature.id ='.$sign_id);
  			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  		}

  		function self_sign($set_id, $user_id){
	    	$this->load->database();
			$query = $this->db->query('UPDATE settlement_signature SET user_id = '.$user_id.' WHERE set_id = '.$set_id.' AND role_id = 0');
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function purpose_self_sign($set_id, $user_id){
	    	$this->load->database();
			$query = $this->db->query('UPDATE purpose_signature SET user_id = '.$user_id.' WHERE set_id = '.$set_id.' AND role_id = 0');
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}


  		function set_sign ($set_type){
  			$this->load->database();
			$this->db->select('settlement_role.*');
			$this->db->where('set_type', $set_type);		
			$query = $this->db->get('settlement_role');
			return $query->result_array();  	
		}

		function pur_sign (){
  			$this->load->database();
			$this->db->select('purpose_role.*');
			$query = $this->db->get('purpose_role');
			return $query->result_array();  	
		}

		function set_do_sign($set_id){
  	 		$this->load->database();
			$this->db->select('settlement_signature.*');
			$this->db->where('settlement_signature.set_id', $set_id);		
			$query = $this->db->get('settlement_signature');
			return $query->num_rows();  	
		}

		function pur_do_sign($pur_id){
  	 		$this->load->database();
			$this->db->select('purpose_signature.*');
			$this->db->where('purpose_signature.pur_id', $pur_id);		
			$query = $this->db->get('purpose_signature');
			return $query->num_rows();  	
		}

		function add_signature($set_id, $role_id, $rank){
	    	$this->load->database();
			$query = $this->db->query('INSERT INTO settlement_signature(set_id, role_id, rank) VALUES("'.$set_id.'", "'.$role_id.'", "'.$rank.'")');
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
  		}

  		function add_pur_signature($pur_id, $set_id, $role_id, $rank){
	    	$this->load->database();
			$query = $this->db->query('INSERT INTO purpose_signature(pur_id, set_id, role_id, rank) VALUES("'.$pur_id.'","'.$set_id.'", "'.$role_id.'", "'.$rank.'")');
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
  		}

  		function update_state($set_id, $state) {
			$this->db->update('settlement', array('state_id'=> $state), "id = ".$set_id);
		}

		function update_close($set_id, $close) {
			$this->db->update('settlement', array('closed'=> $close), "id = ".$set_id);
		}

		function update_actual($set_id, $actual) {
			$this->db->update('settlement', array('actual'=> $actual), "id = ".$set_id);
		}

		function update_status($set_id, $status) {
			$this->db->update('settlement', array('status'=> $status), "id = ".$set_id);
		}

		function update_purpose_state($set_id, $state) {
			$this->db->update('purpose', array('state_id'=> $state), "set_id = ".$set_id);
		}

		function approve($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE settlement_signature SET user_id = '.$uid.' WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function purpose_approve($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE purpose_signature SET user_id = '.$uid.' WHERE set_id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function sign($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE settlement_signature SET user_id = '.$uid.' WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function sign_purpose($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE purpose_signature SET user_id = '.$uid.' WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function reject($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE settlement_signature SET user_id = '.$uid.', reject = 1 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function reject_purpose($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE purpose_signature SET user_id = '.$uid.', reject = 1 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

	  	function unsign($id){
	  		$this->load->database();
			$query = $this->db->query('UPDATE settlement_signature SET user_id = NULL, reject = 0 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
	  	}

	  	function purpose_unsign($id){
	  		$this->load->database();
			$query = $this->db->query('UPDATE purpose_signature SET user_id = NULL, reject = 0 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
	  	}

	  	function disapprove($id, $uid){
	  		$this->load->database();
			$query = $this->db->query('UPDATE settlement_signature SET user_id = '.$uid.', reject = 1 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
	  	}

	  	function purpose_disapprove($id, $uid){
	  		$this->load->database();
			$query = $this->db->query('UPDATE purpose_signature SET user_id = '.$uid.', reject = 1 WHERE set_id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
	  	}

	  	function update_settlement($data, $set_id) {
			$this->load->database();
			$this->db->where('settlement.id', $set_id);		
			$this->db->update('settlement', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function update_purpose($data, $set_id) {
			$this->load->database();
			$this->db->where('purpose.set_id', $set_id);		
			$this->db->update('purpose', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

	  	function get_signer_email ($role_id){
			$query = $this->db->query("
				SELECT email FROM users
				WHERE role_id =".$role_id."
				AND  banned = '0' ");
			return $query->result_array();
		}

		function owner($user_id){
  			$query = $this->db->query("
				SELECT email FROM users
				WHERE id =".$user_id);
			return $query->result_array();
  		}
	}

?>