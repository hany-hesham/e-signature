<?php

	class settlements_model extends CI_Model{
	
  		function __contruct(){
			parent::__construct;
		}

		function getall(){
		    $this->load->database();
			$this->db->select('users.id as userid,users.*,settlements.*,hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('users', 'settlements.user_id = users.id','left');
			$this->db->join('hotels', 'settlements.hotel_id = hotels.id','left');
			$query = $this->db->get('settlements');
			return $query->result_array();
	  	}

	  	function update_files($assumed_id, $set_id) {
	  		$this->load->database();
	  		$this->db->query('UPDATE settlements_filles SET set_id = "'.$set_id.'" WHERE set_id = "'.$assumed_id.'"');
	  		}

	  	function getby_fille($set_id){
		    $this->load->database();
			$this->db->where('set_id', $set_id);
			$query = $this->db->get('settlements_filles');
			return $query->result_array();
	  	}

	  	function add($set_id, $name) {
	  		$this->load->database();
	  		$this->db->query('INSERT INTO settlements_filles(set_id,name) VALUES("'.$set_id.'","'.$name.'")');

	  	}

	  	function remove($id) {
	      $this->load->database();

	      $this->db->query('DELETE FROM settlements_filles WHERE id = '.$id);

	    }

	    function getall_state($state = FALSE, $from, $to){
		    $this->load->database();
			$this->db->select('users.id as userid,users.*,settlements.*,hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('users', 'settlements.user_id = users.id','left');
			$this->db->join('hotels', 'settlements.hotel_id = hotels.id','left');
			if ($state) {
				$this->db->where('settlements.status', $state);
			}
			$this->db->where('settlements.timestamp >=', $from);
	        $this->db->where('settlements.timestamp <=', $to);
			$this->db->order_by('hotel_id');
			$query = $this->db->get('settlements');
			return $query->result_array();
	  	}

	  	function getall_state_value($state = FALSE, $from, $to, $hnm){
		    $this->load->database();
			$this->db->select('settlements.amount, settlements.actual, hotels.name as hotel_name');
			$this->db->join('users', 'settlements.user_id = users.id','left');
			$this->db->join('hotels', 'settlements.hotel_id = hotels.id','left');
			if ($state) {
				$this->db->where('settlements.status', $state);
			}
			$this->db->where('hotels.name', $hnm);
			$this->db->where('settlements.timestamp >=', $from);
	        $this->db->where('settlements.timestamp <=', $to);
			$this->db->order_by('hotel_id');
			$query = $this->db->get('settlements');
			return $query->result_array();
	  	}

	  	function update_message_id($id, $message_id) {
		      $this->load->database();
		      $this->db->where('settlements.id', $id);
		      //if(isset($message_id)){
		      $msg_id = $this->db->update('settlements', array('message_id' => $message_id));
		      //die(print_r($msg_id));
		      //}else{
		              //die(print_r($message_id));
		      //}
		  }

	  	function getall_state_count($state = FALSE, $from, $to){
		    $this->load->database();
			$this->db->select('users.id as userid,users.*,settlements.*,hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('users', 'settlements.user_id = users.id','left');
			$this->db->join('hotels', 'settlements.hotel_id = hotels.id','left');
			if ($state) {
				$this->db->where('settlements.status', $state);
			}
			$this->db->where('settlements.timestamp >=', $from);
	        $this->db->where('settlements.timestamp <=', $to);
			$this->db->order_by('hotel_id');
			$query = $this->db->get('settlements');
			return $query->num_rows();
	  	}

	  	function get_state($state = FALSE, $from, $to, $hid = FALSE){
		    $this->load->database();
			$this->db->select('users.id as userid,users.*,settlements.*,hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('users', 'settlements.user_id = users.id','left');
			$this->db->join('hotels', 'settlements.hotel_id = hotels.id','left');
			if ($hid) {
				$this->db->where('settlements.hotel_id', $hid);
			}
			if ($state) {
				$this->db->where('settlements.status', $state);
			}
			$this->db->where('settlements.timestamp >=', $from);
	        $this->db->where('settlements.timestamp <=', $to);
			$this->db->order_by('hotel_id');
			$query = $this->db->get('settlements');
			return $query->result_array();
	  	}

	  	function get_state_count($state = FALSE, $from, $to, $hid = FALSE){
		    $this->load->database();
			$this->db->select('users.id as userid,users.*,settlements.*,hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('users', 'settlements.user_id = users.id','left');
			$this->db->join('hotels', 'settlements.hotel_id = hotels.id','left');
			if ($hid) {
				$this->db->where('settlements.hotel_id', $hid);
			}
			if ($state) {
				$this->db->where('settlements.status', $state);
			}
			$this->db->where('settlements.timestamp >=', $from);
	        $this->db->where('settlements.timestamp <=', $to);
			$this->db->order_by('hotel_id');
			$query = $this->db->get('settlements');
			return $query->num_rows();
	  	}

	  	function getall_approved($from, $to){
		    $this->load->database();
			$this->db->select('users.id as userid,users.*,settlements.*,hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('users', 'settlements.user_id = users.id','left');
			$this->db->join('hotels', 'settlements.hotel_id = hotels.id','left');
			$this->db->where('settlements.state_id', 2);
			$this->db->where('settlements.timestamp >=', $from);
	        $this->db->where('settlements.timestamp <=', $to);
			$this->db->order_by('hotel_id');
			$query = $this->db->get('settlements');
			return $query->result_array();
	  	}

	  	function get_app_value($from, $to, $hnm){
		    $this->load->database();
			$this->db->select('settlements.amount, settlements.actual, hotels.name as hotel_name');
			$this->db->join('users', 'settlements.user_id = users.id','left');
			$this->db->join('hotels', 'settlements.hotel_id = hotels.id','left');
			$this->db->where('settlements.state_id', 2);
			$this->db->where('hotels.name', $hnm);
			$this->db->where('settlements.timestamp >=', $from);
	        $this->db->where('settlements.timestamp <=', $to);
			$this->db->order_by('hotel_id');
			$query = $this->db->get('settlements');
			return $query->result_array();
	  	}

	  	function getall_approved_count($from, $to){
		    $this->load->database();
			$this->db->select('users.id as userid,users.*,settlements.*,hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('users', 'settlements.user_id = users.id','left');
			$this->db->join('hotels', 'settlements.hotel_id = hotels.id','left');
			$this->db->where('settlements.state_id', 2);
			$this->db->where('settlements.timestamp >=', $from);
	        $this->db->where('settlements.timestamp <=', $to);
			$this->db->order_by('hotel_id');
			$query = $this->db->get('settlements');
			return $query->num_rows();
	  	}

	  	function getall_chairman($from, $to){
		    $this->load->database();
			$this->db->select('users.id as userid,users.*,settlements.*,hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('users', 'settlements.user_id = users.id','left');
			$this->db->join('hotels', 'settlements.hotel_id = hotels.id','left');
			$this->db->where('settlements.state_id', 4);
			$this->db->where('settlements.timestamp >=', $from);
	        $this->db->where('settlements.timestamp <=', $to);
			$this->db->order_by('hotel_id');
			$query = $this->db->get('settlements');
			return $query->result_array();
	  	}

	  	function get_char_value($from, $to, $hnm){
		    $this->load->database();
			$this->db->select('settlements.amount, settlements.actual, hotels.name as hotel_name');
			$this->db->join('users', 'settlements.user_id = users.id','left');
			$this->db->join('hotels', 'settlements.hotel_id = hotels.id','left');
			$this->db->where('settlements.state_id', 4);
			$this->db->where('hotels.name', $hnm);
			$this->db->where('settlements.timestamp >=', $from);
	        $this->db->where('settlements.timestamp <=', $to);
			$this->db->order_by('hotel_id');
			$query = $this->db->get('settlements');
			return $query->result_array();
	  	}

	  	function getall_chairman_count($from, $to){
		    $this->load->database();
			$this->db->select('users.id as userid,users.*,settlements.*,hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('users', 'settlements.user_id = users.id','left');
			$this->db->join('hotels', 'settlements.hotel_id = hotels.id','left');
			$this->db->where('settlements.state_id', 4);
			$this->db->where('settlements.timestamp >=', $from);
	        $this->db->where('settlements.timestamp <=', $to);
			$this->db->order_by('hotel_id');
			$query = $this->db->get('settlements');
			return $query->num_rows();
	  	}

	  	function getall_close($from, $to){
		    $this->load->database();
			$this->db->select('users.id as userid,users.*,settlements.*,hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('users', 'settlements.user_id = users.id','left');
			$this->db->join('hotels', 'settlements.hotel_id = hotels.id','left');
			$this->db->where('settlements.closed', 1);
			$this->db->where('settlements.timestamp >=', $from);
	        $this->db->where('settlements.timestamp <=', $to);
			$this->db->order_by('hotel_id');
			$query = $this->db->get('settlements');
			return $query->result_array();
	  	}

	  	function get_close_value($from, $to, $hnm){
		    $this->load->database();
			$this->db->select('settlements.amount, settlements.actual, hotels.name as hotel_name');
			$this->db->join('users', 'settlements.user_id = users.id','left');
			$this->db->join('hotels', 'settlements.hotel_id = hotels.id','left');
			$this->db->where('settlements.closed', 1);
			$this->db->where('hotels.name', $hnm);
			$this->db->where('settlements.timestamp >=', $from);
	        $this->db->where('settlements.timestamp <=', $to);
			$this->db->order_by('hotel_id');
			$query = $this->db->get('settlements');
			return $query->result_array();
	  	}

	  	function getall_close_count($from, $to){
		    $this->load->database();
			$this->db->select('users.id as userid,users.*,settlements.*,hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('users', 'settlements.user_id = users.id','left');
			$this->db->join('hotels', 'settlements.hotel_id = hotels.id','left');
			$this->db->where('settlements.closed', 1);
			$this->db->where('settlements.timestamp >=', $from);
	        $this->db->where('settlements.timestamp <=', $to);
			$this->db->order_by('hotel_id');
			$query = $this->db->get('settlements');
			return $query->num_rows();
	  	}

	  	function getall_wait($from, $to){
		    $this->load->database();
			$this->db->select('users.id as userid,users.*,settlements.*,hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('users', 'settlements.user_id = users.id','left');
			$this->db->join('hotels', 'settlements.hotel_id = hotels.id','left');
			$this->db->where('settlements.state_id !=', 2, 3, 0);
			$this->db->where('settlements.timestamp >=', $from);
	        $this->db->where('settlements.timestamp <=', $to);
			$this->db->order_by('hotel_id');
			$query = $this->db->get('settlements');
			return $query->result_array();
	  	}

	  	function get_wait_value($from, $to, $hnm){
		    $this->load->database();
			$this->db->select('settlements.amount, settlements.actual, hotels.name as hotel_name');
			$this->db->join('users', 'settlements.user_id = users.id','left');
			$this->db->join('hotels', 'settlements.hotel_id = hotels.id','left');
			$this->db->where('settlements.state_id !=', 2, 3, 0);
			$this->db->where('hotels.name', $hnm);
			$this->db->where('settlements.timestamp >=', $from);
	        $this->db->where('settlements.timestamp <=', $to);
			$this->db->order_by('hotel_id');
			$query = $this->db->get('settlements');
			return $query->result_array();
	  	}

	  	function getall_wait_count($from, $to){
		    $this->load->database();
			$this->db->select('users.id as userid,users.*,settlements.*,hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('users', 'settlements.user_id = users.id','left');
			$this->db->join('hotels', 'settlements.hotel_id = hotels.id','left');
			$this->db->where('settlements.state_id !=', 2, 3, 0);
			$this->db->where('settlements.timestamp >=', $from);
	        $this->db->where('settlements.timestamp <=', $to);
			$this->db->order_by('hotel_id');
			$query = $this->db->get('settlements');
			return $query->num_rows();
	  	}

	  	function getall_reject($from, $to){
		    $this->load->database();
			$this->db->select('users.id as userid,users.*,settlements.*,hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('users', 'settlements.user_id = users.id','left');
			$this->db->join('hotels', 'settlements.hotel_id = hotels.id','left');
			$this->db->where('settlements.state_id =', 3);
			$this->db->where('settlements.timestamp >=', $from);
	        $this->db->where('settlements.timestamp <=', $to);
			$this->db->order_by('hotel_id');
			$query = $this->db->get('settlements');
			return $query->result_array();
	  	}

	  	function get_reje_value($from, $to, $hnm){
		    $this->load->database();
			$this->db->select('settlements.amount, settlements.actual, hotels.name as hotel_name');
			$this->db->join('users', 'settlements.user_id = users.id','left');
			$this->db->join('hotels', 'settlements.hotel_id = hotels.id','left');
			$this->db->where('settlements.state_id =', 3);
			$this->db->where('hotels.name', $hnm);
			$this->db->where('settlements.timestamp >=', $from);
	        $this->db->where('settlements.timestamp <=', $to);
			$this->db->order_by('hotel_id');
			$query = $this->db->get('settlements');
			return $query->result_array();
	  	}

	  	function getall_reject_count($from, $to){
		    $this->load->database();
			$this->db->select('users.id as userid,users.*,settlements.*,hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('users', 'settlements.user_id = users.id','left');
			$this->db->join('hotels', 'settlements.hotel_id = hotels.id','left');
			$this->db->where('settlements.state_id =', 3);
			$this->db->where('settlements.timestamp >=', $from);
	        $this->db->where('settlements.timestamp <=', $to);
			$this->db->order_by('hotel_id');
			$query = $this->db->get('settlements');
			return $query->num_rows();
	  	}

	  	function get_approved($hid, $from, $to){
		    $this->load->database();
			$this->db->select('users.id as userid,users.*,settlements.*,hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('users', 'settlements.user_id = users.id','left');
			$this->db->join('hotels', 'settlements.hotel_id = hotels.id','left');
			$this->db->where('settlements.hotel_id', $hid);		
			$this->db->where('settlements.state_id', 2);
			$this->db->where('settlements.timestamp >=', $from);
	        $this->db->where('settlements.timestamp <=', $to);
			$this->db->order_by('hotel_id');
			$query = $this->db->get('settlements');
			return $query->result_array();
	  	}

	  	function get_approved_count($hid, $from, $to){
		    $this->load->database();
			$this->db->select('users.id as userid,users.*,settlements.*,hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('users', 'settlements.user_id = users.id','left');
			$this->db->join('hotels', 'settlements.hotel_id = hotels.id','left');
			$this->db->where('settlements.hotel_id', $hid);		
			$this->db->where('settlements.state_id', 2);
			$this->db->where('settlements.timestamp >=', $from);
	        $this->db->where('settlements.timestamp <=', $to);
			$this->db->order_by('hotel_id');
			$query = $this->db->get('settlements');
			return $query->num_rows();
	  	}

	  	function get_chairman($hid, $from, $to){
		    $this->load->database();
			$this->db->select('users.id as userid,users.*,settlements.*,hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('users', 'settlements.user_id = users.id','left');
			$this->db->join('hotels', 'settlements.hotel_id = hotels.id','left');
			$this->db->where('settlements.hotel_id', $hid);		
			$this->db->where('settlements.state_id', 4);
			$this->db->where('settlements.timestamp >=', $from);
	        $this->db->where('settlements.timestamp <=', $to);
			$this->db->order_by('hotel_id');
			$query = $this->db->get('settlements');
			return $query->result_array();
	  	}

	  	function get_chairman_count($hid, $from, $to){
		    $this->load->database();
			$this->db->select('users.id as userid,users.*,settlements.*,hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('users', 'settlements.user_id = users.id','left');
			$this->db->join('hotels', 'settlements.hotel_id = hotels.id','left');
			$this->db->where('settlements.hotel_id', $hid);		
			$this->db->where('settlements.state_id', 4);
			$this->db->where('settlements.timestamp >=', $from);
	        $this->db->where('settlements.timestamp <=', $to);
			$this->db->order_by('hotel_id');
			$query = $this->db->get('settlements');
			return $query->num_rows();
	  	}

	  	function get_close($hid, $from, $to){
		    $this->load->database();
			$this->db->select('users.id as userid,users.*,settlements.*,hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('users', 'settlements.user_id = users.id','left');
			$this->db->join('hotels', 'settlements.hotel_id = hotels.id','left');
			$this->db->where('settlements.hotel_id', $hid);		
			$this->db->where('settlements.closed', 1);
			$this->db->where('settlements.timestamp >=', $from);
	        $this->db->where('settlements.timestamp <=', $to);
			$this->db->order_by('hotel_id');
			$query = $this->db->get('settlements');
			return $query->result_array();
	  	}

	  	function get_close_count($hid, $from, $to){
		    $this->load->database();
			$this->db->select('users.id as userid,users.*,settlements.*,hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('users', 'settlements.user_id = users.id','left');
			$this->db->join('hotels', 'settlements.hotel_id = hotels.id','left');
			$this->db->where('settlements.hotel_id', $hid);		
			$this->db->where('settlements.closed', 1);
			$this->db->where('settlements.timestamp >=', $from);
	        $this->db->where('settlements.timestamp <=', $to);
			$this->db->order_by('hotel_id');
			$query = $this->db->get('settlements');
			return $query->num_rows();
	  	}

	  	function get_wait($hid, $from, $to){
		    $this->load->database();
			$this->db->select('users.id as userid,users.*,settlements.*,hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('users', 'settlements.user_id = users.id','left');
			$this->db->join('hotels', 'settlements.hotel_id = hotels.id','left');
			$this->db->where('settlements.hotel_id', $hid);		
			$this->db->where('settlements.state_id !=', 2, 3, 0);
			$this->db->where('settlements.timestamp >=', $from);
	        $this->db->where('settlements.timestamp <=', $to);
			$this->db->order_by('hotel_id');
			$query = $this->db->get('settlements');
			return $query->result_array();
	  	}

	  	function get_wait_count($hid, $from, $to){
		    $this->load->database();
			$this->db->select('users.id as userid,users.*,settlements.*,hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('users', 'settlements.user_id = users.id','left');
			$this->db->join('hotels', 'settlements.hotel_id = hotels.id','left');
			$this->db->where('settlements.hotel_id', $hid);		
			$this->db->where('settlements.state_id !=', 2, 3, 0);
			$this->db->where('settlements.timestamp >=', $from);
	        $this->db->where('settlements.timestamp <=', $to);
			$this->db->order_by('hotel_id');
			$query = $this->db->get('settlements');
			return $query->num_rows();
	  	}

	  	function get_reject($hid, $from, $to){
		    $this->load->database();
			$this->db->select('users.id as userid,users.*,settlements.*,hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('users', 'settlements.user_id = users.id','left');
			$this->db->join('hotels', 'settlements.hotel_id = hotels.id','left');
			$this->db->where('settlements.hotel_id', $hid);		
			$this->db->where('settlements.state_id =', 3);
			$this->db->where('settlements.timestamp >=', $from);
	        $this->db->where('settlements.timestamp <=', $to);
			$this->db->order_by('hotel_id');
			$query = $this->db->get('settlements');
			return $query->result_array();
	  	}

	  	function get_reject_count($hid, $from, $to){
		    $this->load->database();
			$this->db->select('users.id as userid,users.*,settlements.*,hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('users', 'settlements.user_id = users.id','left');
			$this->db->join('hotels', 'settlements.hotel_id = hotels.id','left');
			$this->db->where('settlements.hotel_id', $hid);		
			$this->db->where('settlements.state_id =', 3);
			$this->db->where('settlements.timestamp >=', $from);
	        $this->db->where('settlements.timestamp <=', $to);
			$this->db->order_by('hotel_id');
			$query = $this->db->get('settlements');
			return $query->num_rows();
	  	}

		function create_settlements($data) {
			$this->load->database();
			$this->db->insert('settlements', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function create_purposes($data) {
			$this->load->database();
			$this->db->insert('purposes', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function getall_type(){
	    	$this->load->database();
			$query = $this->db->get('settlements_type');
			return $query->result_array();
  		}

  		function view($user_hotels = FALSE) {
  	  		$this->load->database();
			$this->db->select('users.id as userid,users.*,settlements.*,hotels.name as hotel_name,hotels.logo As logo, settlements_type.name As type, purposes.set_id');
			$this->db->join('users', 'settlements.user_id = users.id','left');
			$this->db->join('purposes', 'settlements.id = purposes.set_id','left');
			$this->db->join('hotels', 'settlements.hotel_id = hotels.id','left');
			$this->db->join('settlements_type', 'settlements.form_type = settlements_type.id','left');
        	if ($user_hotels) {
          		$this->db->where_in('settlements.hotel_id', $user_hotels);
        	}
        	$this->db->order_by('Date', 'DESC');
			$query = $this->db->get('settlements');
			return $query->result_array();
		}

		function get_settlements($set_id) {
			$this->db->select('settlements.*, hotels.name as hotel_name, hotels.logo As logo, users.fullname as name, settlements_type.name As type');
			$this->db->join('settlements_type', 'settlements.form_type = settlements_type.id','left');	
			$this->db->join('hotels', 'settlements.hotel_id = hotels.id','left');
			$this->db->join('users', 'settlements.user_id = users.id','left');
			$this->db->where('settlements.id', $set_id);		
			$query = $this->db->get('settlements');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
		}

		function get_purposes($set_id) {
			$this->db->select('purposes.*');
			$this->db->where('purposes.set_id', $set_id);		
			$query = $this->db->get('purposes');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
		}

		function InsertComment($data){
			$this->db->insert('settlements_comments', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function insert_purposes_comment($data){
			$this->db->insert('purposes_comments', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function GetComment($set_id){
			$query = $this->db->query("
				SELECT users.fullname, settlements_comments.comment, settlements_comments.created	FROM settlements_comments
				JOIN users on settlements_comments.user_id = users.id
				WHERE settlements_comments.set_id =".$set_id);
			return $query->result_array();
  		}

  		function get_purposes_comment($set_id){
			$query = $this->db->query("
				SELECT users.fullname, purposes_comments.comment, purposes_comments.created	FROM purposes_comments
				JOIN users on purposes_comments.user_id = users.id
				WHERE purposes_comments.set_id =".$set_id);
			return $query->result_array();
  		}

  		function getby_verbal($set_id){
	    	$this->load->database();
			$this->db->select('settlements_signature.id, settlements_signature.user_id, settlements_signature.role_id, settlements_signature.timestamp, settlements_signature.rank, roles.role, settlements_signature.reject');
			$this->db->join('roles', 'settlements_signature.role_id = roles.id', 'left');
			$this->db->where('set_id', $set_id);
			$this->db->order_by('rank');
			$query = $this->db->get('settlements_signature');
			return $query->result_array();
  		}

  		function get_count($set_id){
	    	$this->load->database();
			$this->db->select('settlements_signature.*');
			$this->db->where('set_id', $set_id);
			$this->db->order_by('rank');
			$query = $this->db->get('settlements_signature');
			return $query->num_rows();

  		}

  		function purposes_getby_verbal($set_id){
	    	$this->load->database();
			$this->db->select('purposes_signature.id, purposes_signature.user_id, purposes_signature.role_id, purposes_signature.timestamp, purposes_signature.rank, roles.role, purposes_signature.reject');
			$this->db->join('roles', 'purposes_signature.role_id = roles.id', 'left');
			$this->db->where('set_id', $set_id);
			$this->db->order_by('rank');
			$query = $this->db->get('purposes_signature');
			return $query->result_array();
  		}

  		function get_signature_identity($sign_id){
  			$this->load->database();
			$query = $this->db->query('SELECT settlements.hotel_id, settlements_signature.set_id FROM settlements_signature JOIN settlements ON settlements_signature.set_id = settlements.id WHERE settlements_signature.id ='.$sign_id);
  			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  		}

  		function get_purposes_signature_identity($sign_id){
  			$this->load->database();
			$query = $this->db->query('SELECT purposes.hotel_id, purposes_signature.set_id FROM purposes_signature JOIN purposes ON purposes_signature.set_id = purposes.set_id WHERE purposes_signature.id ='.$sign_id);
  			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  		}

  		function self_sign($set_id, $user_id){
	    	$this->load->database();
			$query = $this->db->query('UPDATE settlements_signature SET user_id = '.$user_id.' WHERE set_id = '.$set_id.' AND role_id = 0');
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function purposes_self_sign($set_id, $user_id){
	    	$this->load->database();
			$query = $this->db->query('UPDATE purposes_signature SET user_id = '.$user_id.' WHERE set_id = '.$set_id.' AND role_id = 0');
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}


  		function set_sign ($set_type){
  			$this->load->database();
			$this->db->select('settlements_role.*');
			$this->db->where('set_type', $set_type);		
			$query = $this->db->get('settlements_role');
			return $query->result_array();  	
		}

		function pur_sign (){
  			$this->load->database();
			$this->db->select('purposes_role.*');
			$query = $this->db->get('purposes_role');
			return $query->result_array();  	
		}

		function set_do_sign($set_id){
  	 		$this->load->database();
			$this->db->select('settlements_signature.*');
			$this->db->where('settlements_signature.set_id', $set_id);		
			$query = $this->db->get('settlements_signature');
			return $query->num_rows();  	
		}

		function pur_do_sign($pur_id){
  	 		$this->load->database();
			$this->db->select('purposes_signature.*');
			$this->db->where('purposes_signature.pur_id', $pur_id);		
			$query = $this->db->get('purposes_signature');
			return $query->num_rows();  	
		}

		function add_signature($set_id, $role_id, $rank){
	    	$this->load->database();
			$query = $this->db->query('INSERT INTO settlements_signature(set_id, role_id, rank) VALUES("'.$set_id.'", "'.$role_id.'", "'.$rank.'")');
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
  		}

  		function add_pur_signature($pur_id, $set_id, $role_id, $rank){
	    	$this->load->database();
			$query = $this->db->query('INSERT INTO purposes_signature(pur_id, set_id, role_id, rank) VALUES("'.$pur_id.'","'.$set_id.'", "'.$role_id.'", "'.$rank.'")');
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
  		}

  		function update_state($set_id, $state) {
			$this->db->update('settlements', array('state_id'=> $state), "id = ".$set_id);
		}
	    function unsign_state($set_id) {
			$this->db->query('UPDATE settlements SET state_id = "1" WHERE id = "'.$set_id.'"');
		}
		function reject_state($set_id) {
			$this->db->query('UPDATE settlements SET state_id = "3" WHERE id = "'.$set_id.'"');
		}
		function sign_state($set_id) {
			$this->db->query('UPDATE settlements SET state_id = "2" WHERE id = "'.$set_id.'"');
		}	

		function update_close($set_id, $close) {
			$this->db->update('settlements', array('closed'=> $close), "id = ".$set_id);
		}

		function update_actual($set_id, $actual) {
			$this->db->update('settlements', array('actual'=> $actual), "id = ".$set_id);
		}

		function update_status($set_id, $status) {
			$this->db->update('settlements', array('status'=> $status), "id = ".$set_id);
		}

		function update_purposes_state($set_id, $state) {
			$this->db->update('purposes', array('state_id'=> $state), "set_id = ".$set_id);
		}

		function approve($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE settlements_signature SET user_id = '.$uid.' WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function purposes_approve($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE purposes_signature SET user_id = '.$uid.' WHERE set_id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function sign($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE settlements_signature SET user_id = '.$uid.' WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function sign_purposes($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE purposes_signature SET user_id = '.$uid.' WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function reject($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE settlements_signature SET user_id = '.$uid.', reject = 1 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function reject_purposes($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE purposes_signature SET user_id = '.$uid.', reject = 1 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

	  	function unsign($id){
	  		$this->load->database();
			$query = $this->db->query('UPDATE settlements_signature SET user_id = NULL, reject = 0 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
	  	}

	  	function purposes_unsign($id){
	  		$this->load->database();
			$query = $this->db->query('UPDATE purposes_signature SET user_id = NULL, reject = 0 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
	  	}

	  	function disapprove($id, $uid){
	  		$this->load->database();
			$query = $this->db->query('UPDATE settlements_signature SET user_id = '.$uid.', reject = 1 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
	  	}

	  	function purposes_disapprove($id, $uid){
	  		$this->load->database();
			$query = $this->db->query('UPDATE purposes_signature SET user_id = '.$uid.', reject = 1 WHERE set_id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
	  	}

	  	function update_settlements($data, $set_id) {
			$this->load->database();
			$this->db->where('settlements.id', $set_id);		
			$this->db->update('settlements', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function update_purposes($data, $set_id) {
			$this->load->database();
			$this->db->where('purposes.set_id', $set_id);		
			$this->db->update('purposes', $data);
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

	  	function create_inline_comment($comment) {
			$this->load->database();
			$this->db->insert('settlements_inline_comments', $comment);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
	  		}
	  	function retrieve_inline_comment($set_id,$type){
	  		$this->load->database();
	  		$this->db->select('settlements_inline_comments.comment');
	  		$this->db->where('settlements_inline_comments.set_id',$set_id);
	  		$this->db->where('settlements_inline_comments.type',$type);
	  		$query= $this->db->get('settlements_inline_comments');
            return $query->result_array();
	  	}	

	  	function update_final_settlements($final_settlements, $set_id) {
			$this->load->database();
			$this->db->where('settlements.id', $set_id);		
			$this->db->update('settlements', $final_settlements);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function update_status_saf($status, $set_id) {
			$this->load->database();
			$this->db->where('settlements.id', $set_id);		
	  		$this->db->query('UPDATE settlements SET settlements.status = "'.$status.'" WHERE settlements.id = "'.$set_id.'"');
	  		}
        function get_settlements_status_saf(){
        	$this->load->database();
        	$this->db->select('settlements_status_saf.*');
        	$query = $this->db->get('settlements_status_saf');
        	return $query->result_array();
        }

        //   function get_status(){
        // 	$this->load->database();
        // 	$this->db->select('settlements_status_saf.status');
        // 	//$this->db->where('settlements_status_saf.id',$status_id);
        // 	$query = $this->db->get('settlements_status_saf');
        // 	return $query->result_array();
        // }
		
	}

?>