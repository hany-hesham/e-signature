<?php

	class amenitys_model extends CI_Model{

  		function __contruct(){
			parent::__construct;
		}

		function view($user_hotels = FALSE) {
  	  		$this->load->database();
			$this->db->select('amenitys.id, amenitys.hotel_id, amenitys.date_time, amenitys.type_id, amenitys.timestamp, amenitys.refiller, amenitys.state_id, hotels.name as hotel_name , amenitys_types.name as type_name');
			$this->db->join('hotels', 'amenitys.hotel_id = hotels.id','left');
			$this->db->join('amenitys_types', 'amenitys.type_id = amenitys_types.id','left');
        	if ($user_hotels) {
          		$this->db->where_in('amenitys.hotel_id', $user_hotels);
        	}
        	$x = array('0' => 1, '1' => 4, '2' => 5, '3' => 6, '4' => 7, '5' => 8);
        	$y = array('0' => 1, '1' => 2);
			$this->db->where_in('amenitys.state_id', $x);	
			$this->db->where('amenitys.refiller !=', 1);		
			$this->db->where_in('amenitys.type_id', $y);		
        	$this->db->order_by('timestamp', 'DESC');
			$query = $this->db->get('amenitys');
			return $query->result_array();
		}

		function getby_verbals($amen_id){
	    	$this->load->database();
			$this->db->select('amenitys_signature.role_id, amenitys_signature.department_id, amenitys_signature.rank, amenitys_signature.user_id, amenitys_signature.reject, roles.role, departments.name as department, users.fullname as user_name');
			$this->db->join('roles', 'amenitys_signature.role_id = roles.id', 'left');
			$this->db->join('departments', 'amenitys_signature.department_id = departments.id', 'left');
			$this->db->join('users', 'amenitys_signature.user_id = users.id', 'left');
			$this->db->where('amen_id', $amen_id);
			$this->db->order_by('rank');
			$query = $this->db->get('amenitys_signature');
			return $query->result_array();
  		}

  		function get_itemss($amen_id) {
			$this->db->select('amenitys_element.id,amenitys_element.room, amenitys_element.amen_id, amenitys_element.treatment_id, amenitys.hotel_id, amenitys_treatments.name as treatment_type');
			$this->db->join('amenitys', 'amenitys_element.amen_id = amenitys.id','left');
			$this->db->join('amenitys_treatments', 'amenitys_element.treatment_id = amenitys_treatments.id','left');
			$this->db->where('amenitys_element.amen_id', $amen_id);
			$query = $this->db->get('amenitys_element');
			return ($query->num_rows() > 0 )? $query->result_array() : FALSE;
		}

		function get_ament($room_id) {
			$this->db->select('amenitys_moved.room_new');
			$this->db->where('amenitys_moved.room_id', $room_id);	
        	$this->db->order_by('timestamp', 'DESC');
        	$this->db->limit('1');
			$query = $this->db->get('amenitys_moved');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
		}

		function get_types(){
	    	$this->load->database();
			$this->db->select('amenitys_types.*');
			$this->db->where('amenitys_types.id !=', 1, 2);		
        	$this->db->order_by('name');
			$query = $this->db->get('amenitys_types');
			return $query->result_array();
  		}

		function view_app($user_hotels = FALSE) {
  	  		$this->load->database();
			$this->db->select('amenitys.id, amenitys.hotel_id, amenitys.date_time, amenitys.type_id, amenitys.timestamp, amenitys.refiller, amenitys.state_id, hotels.name as hotel_name , amenitys_types.name as type_name');
			$this->db->join('hotels', 'amenitys.hotel_id = hotels.id','left');
			$this->db->join('amenitys_types', 'amenitys.type_id = amenitys_types.id','left');
        	if ($user_hotels) {
          		$this->db->where_in('amenitys.hotel_id', $user_hotels);
        	}
			$this->db->where('amenitys.state_id', 2);	
			$this->db->where('amenitys.type_id !=', 6);	
			$this->db->where('amenitys.refiller !=', 1);		
        	$this->db->order_by('timestamp', 'DESC');
			$query = $this->db->get('amenitys');
			return $query->result_array();
		}

		function view_rej($user_hotels = FALSE) {
  	  		$this->load->database();
			$this->db->select('amenitys.id, amenitys.hotel_id, amenitys.date_time, amenitys.type_id, amenitys.timestamp, amenitys.refiller, amenitys.state_id, hotels.name as hotel_name , amenitys_types.name as type_name');
			$this->db->join('hotels', 'amenitys.hotel_id = hotels.id','left');
			$this->db->join('amenitys_types', 'amenitys.type_id = amenitys_types.id','left');
        	if ($user_hotels) {
          		$this->db->where_in('amenitys.hotel_id', $user_hotels);
        	}
			$this->db->where('amenitys.state_id', 3);		
        	$this->db->order_by('timestamp', 'DESC');
			$query = $this->db->get('amenitys');
			return $query->result_array();
		}

		function view_wat($user_hotels = FALSE, $state) {
  	  		$this->load->database();
			$this->db->select('amenitys.id, amenitys.hotel_id, amenitys.date_time, amenitys.type_id, amenitys.timestamp, amenitys.refiller, amenitys.state_id, hotels.name as hotel_name , amenitys_types.name as type_name');
			$this->db->join('hotels', 'amenitys.hotel_id = hotels.id','left');
			$this->db->join('amenitys_types', 'amenitys.type_id = amenitys_types.id','left');
        	if ($user_hotels) {
          		$this->db->where_in('amenitys.hotel_id', $user_hotels);
        	}
			$this->db->where('amenitys.state_id', $state);	
			$y = array('0' => 1, '1' => 2);		
			$this->db->where_in('amenitys.type_id', $y);		
        	$this->db->order_by('timestamp', 'DESC');
			$query = $this->db->get('amenitys');
			return $query->result_array();
		}

		function view_dev($user_hotels = FALSE) {
  	  		$this->load->database();
			$this->db->select('amenitys.id, amenitys.hotel_id, amenitys.date_time, amenitys.type_id, amenitys.timestamp, amenitys.refiller, amenitys.state_id, hotels.name as hotel_name , amenitys_types.name as type_name');
			$this->db->join('hotels', 'amenitys.hotel_id = hotels.id','left');
			$this->db->join('amenitys_types', 'amenitys.type_id = amenitys_types.id','left');
        	if ($user_hotels) {
          		$this->db->where_in('amenitys.hotel_id', $user_hotels);
        	}
			$this->db->where('amenitys.type_id', 6);		
        	$this->db->order_by('timestamp', 'DESC');
			$query = $this->db->get('amenitys');
			return $query->result_array();
		}

		function view_ref($user_hotels = FALSE) {
  	  		$this->load->database();
			$this->db->select('amenitys.id, amenitys.hotel_id, amenitys.date_time, amenitys.type_id, amenitys.timestamp, amenitys.refiller, amenitys.state_id, hotels.name as hotel_name , amenitys_types.name as type_name');
			$this->db->join('hotels', 'amenitys.hotel_id = hotels.id','left');
			$this->db->join('amenitys_types', 'amenitys.type_id = amenitys_types.id','left');
        	if ($user_hotels) {
          		$this->db->where_in('amenitys.hotel_id', $user_hotels);
        	}
			$this->db->where('amenitys.refiller', 1);		
        	$this->db->order_by('timestamp', 'DESC');
			$query = $this->db->get('amenitys');
			return $query->result_array();
		}

		function create_amenity($data) {
			$this->load->database();
			$this->db->insert('amenitys', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function create_room($data) {
			$this->db->insert('amenitys_element', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function update_amenity($amen_id, $data) {
			$this->load->database();
			$this->db->where('amenitys.id', $amen_id);	
			$this->db->update('amenitys', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function update_room($data, $amen_id, $room_id) {
			$this->load->database();
			$this->db->where('amenitys_element.amen_id', $amen_id);	
			$this->db->where('amenitys_element.id', $room_id);		
			$this->db->update('amenitys_element', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function add_other($room_id, $other_id) {
	  		$this->load->database();
	  		$this->db->query('INSERT INTO amenitys_other(room_id,other_id) VALUES("'.$room_id.'","'.$other_id.'")');
  		}

  		function amen_sign(){
  	 		$this->load->database();
			$this->db->select('amenitys_role.*');
			$query = $this->db->get('amenitys_role');
			return $query->result_array();  	
		}

		function amen_do_sign($amen_id){
  	 		$this->load->database();
			$this->db->select('amenitys_signature.*');
			$this->db->where('amenitys_signature.amen_id', $amen_id);		
			$query = $this->db->get('amenitys_signature');
			return $query->num_rows();  	
		}

		function add_signature($amen_id, $role_id, $department_id, $rank){
	    	$this->load->database();
			$query = $this->db->query('INSERT INTO amenitys_signature(amen_id, role_id, department_id, rank) VALUES("'.$amen_id.'", "'.$role_id.'", "'.$department_id.'", "'.$rank.'")');
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
  		}

  		function get_amenity($amen_id) {
			$this->db->select('amenitys.*, hotels.name as hotel_name, hotels.logo As logo, users.fullname as name, amenitys_types.name as type_name');
			$this->db->join('hotels', 'amenitys.hotel_id = hotels.id','left');
			$this->db->join('users', 'amenitys.user_id = users.id','left');
			$this->db->join('amenitys_types', 'amenitys.type_id = amenitys_types.id','left');
			$this->db->where('amenitys.id', $amen_id);		
			$query = $this->db->get('amenitys');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
		}

		function get_items($amen_id) {
			$this->db->select('amenitys_element.*, amenitys.hotel_id, amenitys_treatments.name as treatment_type');
			$this->db->join('amenitys', 'amenitys_element.amen_id = amenitys.id','left');
			$this->db->join('amenitys_treatments', 'amenitys_element.treatment_id = amenitys_treatments.id','left');
			$this->db->where('amenitys_element.amen_id', $amen_id);
			$query = $this->db->get('amenitys_element');
			return ($query->num_rows() > 0 )? $query->result_array() : FALSE;
		}

		function get_others(){
	    	$this->load->database();
			$this->db->select('amenitys_others.*');
        	$this->db->order_by('name');
			$query = $this->db->get('amenitys_others');
			return $query->result_array();
  		}

  		function get_treatments(){
	    	$this->load->database();
			$this->db->select('amenitys_treatments.*');
        	$this->db->order_by('name');
			$query = $this->db->get('amenitys_treatments');
			return $query->result_array();
  		}

  		function getbyroom($rn, $hid){
			if ($hid  == 3){
				$server = "172.50.10.230";
			}elseif ($hid  == 2){
				$server = "172.50.10.231";
			}elseif ($hid  == 1){
				$server = "172.50.10.232";
			}elseif ($hid  == 6){
				$server = "192.168.1.230";
			}elseif ($hid  == 4){
				$server = "196.168.2.18";
			}elseif ($hid  == 8){
				$server = "192.168.236.230";
			}elseif ($hid  == 11){
				$server = "10.15.15.18";
			}elseif ($hid  == 10){
				$server = "192.168.50.18";
			}elseif ($hid  == 12){
				$server = "10.15.15.20";
			}elseif ($hid  == 5){
				$server = "10.20.20.18";
			}elseif ($hid  == 7){
				$server = "192.168.210.230";
			}elseif ($hid  == 42){
				$server = "172.50.200.10";
			}
            $dbuser = "v8live";
            $dbpass = "live";
            $dbs = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = ".$server.")(PORT = 1521)))(CONNECT_DATA=(SID=v8)))";
            $connect = oci_connect ($dbuser, $dbpass, $dbs,'UTF8',OCI_DEFAULT );
            $sql = "SELECT ACT_REP_YRES_INFOS.YDET_ADULTNO, ACT_REP_YRES_INFOS.TOTALKIDS_G1, ACT_V8_REP_YRES_INFOS.GUEST_NAME,ACT_V8_REP_YRES_INFOS.YRMS_SHORTDESC, ACT_V8_REP_YRES_INFOS.YRES_ACTARRTIME, ACT_V8_REP_YRES_INFOS.YRES_EXPDEPTIME, ACT_V8_REP_YRES_INFOS.XCOU_LONGDESC FROM ACT_V8_REP_YRES_INFOS JOIN ACT_REP_YRES_INFOS on ACT_V8_REP_YRES_INFOS.YRES_ID = ACT_REP_YRES_INFOS.YRES_ID  WHERE ACT_V8_REP_YRES_INFOS.CHECKED_IN ='1' AND ACT_V8_REP_YRES_INFOS.CHECKED_OUT = '0' AND ACT_V8_REP_YRES_INFOS.YRMS_SHORTDESC=".$rn;
            $querys = oci_parse($connect,$sql);
            oci_execute($querys);
            // $num_rows = oci_fetch_assoc($querys);
            while (false !== ($row = oci_fetch_assoc($querys))) {
            $output_array[] = array('room' => $row['YRMS_SHORTDESC'], 'arriv' => $row['YRES_ACTARRTIME'], 'depart' => $row['YRES_EXPDEPTIME'], 'nation' => $row['XCOU_LONGDESC'], 'guest_name' => $row['GUEST_NAME'], 'no_pax' => $row['YDET_ADULTNO'], 'no_child' => $row['TOTALKIDS_G1']);
            }
            // die(print_r($output_array));
            oci_free_statement($querys);
            oci_close($connect);
            return $output_array;
    	}

    	function getby_fille($amen_id){
	    	$this->load->database();
			$this->db->select('amenitys_filles.*, users.fullname as user_name');
			$this->db->join('users', 'amenitys_filles.user_id = users.id','left');
			$this->db->where('amen_id', $amen_id);
			$query = $this->db->get('amenitys_filles');
			return $query->result_array();
  		}

  		function add($amen_id, $name, $user_id) {
	  		$this->load->database();
	  		$this->db->query('INSERT INTO amenitys_filles(amen_id, name, user_id) VALUES("'.$amen_id.'","'.$name.'","'.$user_id.'")');
	  	}

	  	function remove($id) {
	      $this->load->database();
	      $this->db->query('DELETE FROM amenitys_filles WHERE id = '.$id);
	    }

	    function update_files($assumed_id, $amen_id) {
  			$this->load->database();
  			$this->db->query('UPDATE amenitys_filles SET amen_id = "'.$amen_id.'" WHERE amen_id = "'.$assumed_id.'"');
  		}

  		function get_refiller_amenity() {
			$this->db->select('amenitys.*');
			$this->db->where('amenitys.refiller', 1);		
			$this->db->where('amenitys.state_id', 0);		
			$query = $this->db->get('amenitys');
			return ($query->num_rows() > 0 )? $query->result_array() : FALSE;
		}

		function update_state($amen_id, $state) {
			$this->db->update('amenitys', array('state_id'=> $state), "id = ".$amen_id);
		}

		function update_final($id, $state) {
    		$this->db->update('amenitys', array('chairman'=> $state), "id = ".$id);
  		}

		function getby_verbal($amen_id){
	    	$this->load->database();
			$this->db->select('amenitys_signature.id, amenitys_signature.role_id, amenitys_signature.department_id, amenitys_signature.rank, amenitys_signature.user_id, amenitys_signature.reject, amenitys_signature.timestamp, roles.role, departments.name as department');
			$this->db->join('roles', 'amenitys_signature.role_id = roles.id', 'left');
			$this->db->join('departments', 'amenitys_signature.department_id = departments.id', 'left');
			$this->db->where('amen_id', $amen_id);
        	$this->db->order_by('rank');
			$query = $this->db->get('amenitys_signature');
			return $query->result_array();
  		}

  		function get_amen($room_id) {
			$this->db->select('amenitys_moved.*, users.fullname as name_new');
			$this->db->join('users', 'amenitys_moved.user_new = users.id','left');
			$this->db->where('amenitys_moved.room_id', $room_id);	
        	$this->db->order_by('timestamp', 'DESC');
        	$this->db->limit('1');
			$query = $this->db->get('amenitys_moved');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
		}

		function get_amens($amen_id) {
			$this->db->select('amenitys_moved.*, users.fullname as name_new');
			$this->db->join('users', 'amenitys_moved.user_new = users.id','left');
			$this->db->where('amenitys_moved.amen_id', $amen_id);
        	$this->db->order_by('timestamp');
			$query = $this->db->get('amenitys_moved');
			return ($query->num_rows() > 0 )? $query->result_array() : FALSE;
		}

  		function get_other($item_id){
	    	$this->load->database();
			$this->db->select('amenitys_other.*, amenitys_others.name as other_name');
			$this->db->join('amenitys_others', 'amenitys_other.other_id = amenitys_others.id', 'left');
			$this->db->where('room_id', $item_id);
        	$this->db->order_by('amenitys_others.name');
			$query = $this->db->get('amenitys_other');
			return $query->result_array();
  		}

  		function create_amenitys($data) {
			$this->load->database();
			$this->db->insert('amenitys_moved', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function GetComment($amen_id){
			$query = $this->db->query("
				SELECT users.fullname, amenitys_comments.comment, amenitys_comments.created FROM amenitys_comments
				JOIN users on amenitys_comments.user_id = users.id
				WHERE amenitys_comments.amen_id =".$amen_id);
			return $query->result_array();
  		}

  		function get_item($id) {
			$this->db->select('amenitys_element.*');
			$this->db->where('amenitys_element.id', $id);
			$query = $this->db->get('amenitys_element');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
		}

		function clear_other($item_id) {
	  		$this->load->database();
	  		$this->db->where('amenitys_other.room_id', $item_id);		
			$this->db->delete('amenitys_other');
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
  		}

  		function get_signature_identity($sign_id){
  			$this->load->database();
			$query = $this->db->query('SELECT amenitys.hotel_id, amenitys_signature.amen_id FROM amenitys_signature JOIN amenitys ON amenitys_signature.amen_id = amenitys.id WHERE amenitys_signature.id ='.$sign_id);
  			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  		}

  		function unsign($id){
	  		$this->load->database();
			$query = $this->db->query('UPDATE amenitys_signature SET user_id = NULL, reject = 0 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
	  	}

	  	function reject($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE amenitys_signature SET user_id = '.$uid.', reject = 1 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

	  	function sign($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE amenitys_signature SET user_id = '.$uid.' WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function InsertComment($data){
			$this->db->insert('amenitys_comments', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function get_treatment($treatment){
	    	$this->load->database();
			$this->db->select('amenitys_treatments.*');
			$this->db->where('amenitys_treatments.id', $treatment);
			$query = $this->db->get('amenitys_treatments');
			return $query->row_array();
  		}

		function get_hotel_items($hid, $from, $to, $treatment = FALSE){
		    $this->load->database();
			$this->db->select('amenitys_element.id, amenitys_element.amen_id, amenitys_element.room, amenitys_element.guest, amenitys_element.pax, amenitys_element.child, amenitys_element.reason, amenitys_element.location, amenitys_element.treatment_id, amenitys.hotel_id, amenitys.user_id, amenitys.timestamp, amenitys.date_time, hotels.name as hotel_name, hotels.logo As logo, users.fullname as user_name, amenitys_treatments.name as treatment_type');
			$this->db->join('amenitys', 'amenitys_element.amen_id = amenitys.id','left');
			$this->db->join('amenitys_treatments', 'amenitys_element.treatment_id = amenitys_treatments.id','left');
			$this->db->join('hotels', 'amenitys.hotel_id = hotels.id','left');
			$this->db->join('users', 'amenitys.user_id = users.id','left');
			$this->db->where('amenitys.hotel_id', $hid);
			if ($treatment) {
				$this->db->where('amenitys_element.treatment_id', $treatment);
			}
			$this->db->where('amenitys.timestamp >=', $from);
	        $this->db->where('amenitys.timestamp <=', $to);
			$this->db->order_by('amenitys.timestamp');
			$query = $this->db->get('amenitys_element');
			return $query->result_array();
	  	}

	  	function get_hotel_reason($hid, $from, $to, $treatment = FALSE, $reason = FALSE){
		    $this->load->database();
			$this->db->select('amenitys_element.id, amenitys_element.amen_id, amenitys_element.room, amenitys_element.guest, amenitys_element.pax, amenitys_element.child, amenitys_element.reason, amenitys_element.location, amenitys_element.treatment_id, amenitys.hotel_id, amenitys.user_id, amenitys.timestamp, amenitys.date_time, hotels.name as hotel_name, hotels.logo As logo, users.fullname as user_name, amenitys_treatments.name as treatment_type');
			$this->db->join('amenitys', 'amenitys_element.amen_id = amenitys.id','left');
			$this->db->join('amenitys_treatments', 'amenitys_element.treatment_id = amenitys_treatments.id','left');
			$this->db->join('hotels', 'amenitys.hotel_id = hotels.id','left');
			$this->db->join('users', 'amenitys.user_id = users.id','left');
			$this->db->where('amenitys.hotel_id', $hid);
			if ($treatment) {
				$this->db->where('amenitys_element.treatment_id', $treatment);
			}
			if ($reason) {
				$this->db->like('amenitys_element.reason', $reason);
			}
			$this->db->where('amenitys.timestamp >=', $from);
	        $this->db->where('amenitys.timestamp <=', $to);
			$this->db->order_by('amenitys.timestamp');
			$query = $this->db->get('amenitys_element');
			return $query->result_array();
	  	}

	  	function get_hotel_items_count($hid, $from, $to, $treatment = FALSE){
		    $this->load->database();
			$this->db->select('amenitys_element.id, amenitys_element.amen_id, amenitys_element.room, amenitys_element.treatment_id, amenitys.hotel_id, amenitys.timestamp');
			$this->db->join('amenitys', 'amenitys_element.amen_id = amenitys.id','left');
			$this->db->where('amenitys.hotel_id', $hid);
			if ($treatment) {
				$this->db->where('amenitys_element.treatment_id', $treatment);
			}
			$this->db->where('amenitys.timestamp >=', $from);
	        $this->db->where('amenitys.timestamp <=', $to);
			$this->db->order_by('amenitys.timestamp');
			$query = $this->db->get('amenitys_element');
			return $query->num_rows();
	  	}

	  	function get_hotel_reason_count($hid, $from, $to, $treatment = FALSE, $reason = FALSE){
		    $this->load->database();
			$this->db->select('amenitys_element.id, amenitys_element.amen_id, amenitys_element.room, amenitys_element.guest, amenitys_element.pax, amenitys_element.child, amenitys_element.reason, amenitys_element.location, amenitys_element.treatment_id, amenitys.hotel_id, amenitys.user_id, amenitys.timestamp, amenitys.date_time, hotels.name as hotel_name, hotels.logo As logo, users.fullname as user_name, amenitys_treatments.name as treatment_type');
			$this->db->join('amenitys', 'amenitys_element.amen_id = amenitys.id','left');
			$this->db->join('amenitys_treatments', 'amenitys_element.treatment_id = amenitys_treatments.id','left');
			$this->db->join('hotels', 'amenitys.hotel_id = hotels.id','left');
			$this->db->join('users', 'amenitys.user_id = users.id','left');
			$this->db->where('amenitys.hotel_id', $hid);
			if ($treatment) {
				$this->db->where('amenitys_element.treatment_id', $treatment);
			}
			if ($reason) {
				$this->db->like('amenitys_element.reason', $reason);
			}
			$this->db->where('amenitys.timestamp >=', $from);
	        $this->db->where('amenitys.timestamp <=', $to);
			$this->db->order_by('amenitys.timestamp');
			$query = $this->db->get('amenitys_element');
			return $query->num_rows();
	  	}

	  	function get_type($type){
	    	$this->load->database();
			$this->db->select('amenitys_types.*');
			$this->db->where('amenitys_types.id', $type);
			$query = $this->db->get('amenitys_types');
			return $query->row_array();
  		}

		function get_hotel_items_type($hid, $from, $to, $type = FALSE){
		    $this->load->database();
			$this->db->select('amenitys_element.id, amenitys_element.amen_id, amenitys_element.room, amenitys_element.guest, amenitys_element.pax, amenitys_element.child, amenitys_element.reason, amenitys_element.location, amenitys_element.treatment_id, amenitys.hotel_id, amenitys.user_id, amenitys.type_id, amenitys.timestamp, amenitys.date_time, hotels.name as hotel_name, hotels.logo As logo, users.fullname as user_name, amenitys_treatments.name as treatment_type, amenitys_types.name as type_name');
			$this->db->join('amenitys', 'amenitys_element.amen_id = amenitys.id','left');
			$this->db->join('amenitys_treatments', 'amenitys_element.treatment_id = amenitys_treatments.id','left');
			$this->db->join('amenitys_types', 'amenitys.type_id = amenitys_types.id','left');
			$this->db->join('hotels', 'amenitys.hotel_id = hotels.id','left');
			$this->db->join('users', 'amenitys.user_id = users.id','left');
			$this->db->where('amenitys.hotel_id', $hid);
			if ($type) {
				$this->db->where('amenitys.type_id', $type);
			}
			$this->db->where('amenitys.timestamp >=', $from);
	        $this->db->where('amenitys.timestamp <=', $to);
			$this->db->order_by('amenitys.timestamp');
			$query = $this->db->get('amenitys_element');
			return $query->result_array();
	  	}

	  	function get_hotel_items_type_count($hid, $from, $to, $type = FALSE){
		    $this->load->database();
			$this->db->select('amenitys_element.id, amenitys_element.amen_id, amenitys_element.room, amenitys.type_id, amenitys.hotel_id, amenitys.timestamp');
			$this->db->join('amenitys', 'amenitys_element.amen_id = amenitys.id','left');
			$this->db->where('amenitys.hotel_id', $hid);
			if ($type) {
				$this->db->where('amenitys.type_id', $type);
			}
			$this->db->where('amenitys.timestamp >=', $from);
	        $this->db->where('amenitys.timestamp <=', $to);
			$this->db->order_by('amenitys.timestamp');
			$query = $this->db->get('amenitys_element');
			return $query->num_rows();
	  	}

	  	function get_hotel_items_refl($hid, $from, $to){
		    $this->load->database();
			$this->db->select('amenitys_element.id, amenitys_element.amen_id, amenitys_element.room, amenitys_element.guest, amenitys_element.pax, amenitys_element.child, amenitys_element.reason, amenitys_element.location, amenitys_element.treatment_id, amenitys.hotel_id, amenitys.user_id, amenitys.refiller, amenitys.timestamp, amenitys.date_time, hotels.name as hotel_name, hotels.logo As logo, users.fullname as user_name, amenitys_treatments.name as treatment_type, amenitys_types.name as type_name');
			$this->db->join('amenitys', 'amenitys_element.amen_id = amenitys.id','left');
			$this->db->join('amenitys_treatments', 'amenitys_element.treatment_id = amenitys_treatments.id','left');
			$this->db->join('amenitys_types', 'amenitys.type_id = amenitys_types.id','left');
			$this->db->join('hotels', 'amenitys.hotel_id = hotels.id','left');
			$this->db->join('users', 'amenitys.user_id = users.id','left');
			$this->db->where('amenitys.hotel_id', $hid);
			$this->db->where('amenitys.refiller', 1);
			$this->db->where('amenitys.timestamp >=', $from);
	        $this->db->where('amenitys.timestamp <=', $to);
			$this->db->order_by('amenitys.timestamp');
			$query = $this->db->get('amenitys_element');
			return $query->result_array();
	  	}

	  	function get_hotel_items_refl_count($hid, $from, $to){
		    $this->load->database();
			$this->db->select('amenitys_element.id, amenitys_element.amen_id, amenitys_element.room, amenitys.refiller, amenitys.hotel_id, amenitys.timestamp');
			$this->db->join('amenitys', 'amenitys_element.amen_id = amenitys.id','left');
			$this->db->where('amenitys.hotel_id', $hid);
			$this->db->where('amenitys.refiller', 1);
			$this->db->where('amenitys.timestamp >=', $from);
	        $this->db->where('amenitys.timestamp <=', $to);
			$this->db->order_by('amenitys.timestamp');
			$query = $this->db->get('amenitys_element');
			return $query->num_rows();
	  	}

	  	function get_all_items($from, $to, $treatment = FALSE){
		    $this->load->database();
			$this->db->select('amenitys_element.id, amenitys_element.amen_id, amenitys_element.room, amenitys_element.guest, amenitys_element.pax, amenitys_element.child, amenitys_element.reason, amenitys_element.location, amenitys_element.treatment_id, amenitys.hotel_id, amenitys.user_id, amenitys.timestamp, amenitys.date_time, hotels.name as hotel_name, hotels.logo As logo, users.fullname as user_name, amenitys_treatments.name as treatment_type');
			$this->db->join('amenitys', 'amenitys_element.amen_id = amenitys.id','left');
			$this->db->join('amenitys_treatments', 'amenitys_element.treatment_id = amenitys_treatments.id','left');
			$this->db->join('hotels', 'amenitys.hotel_id = hotels.id','left');
			$this->db->join('users', 'amenitys.user_id = users.id','left');
			if ($treatment) {
				$this->db->where('amenitys_element.treatment_id', $treatment);
			}
			$this->db->where('amenitys.timestamp >=', $from);
	        $this->db->where('amenitys.timestamp <=', $to);
			$this->db->order_by('amenitys.hotel_id');
			$query = $this->db->get('amenitys_element');
			return $query->result_array();
	  	}

	  	function get_all_items_count($from, $to, $treatment = FALSE){
		    $this->load->database();
			$this->db->select('amenitys_element.id, amenitys_element.amen_id, amenitys_element.room, amenitys_element.treatment_id, amenitys.hotel_id, amenitys.timestamp');
			$this->db->join('amenitys', 'amenitys_element.amen_id = amenitys.id','left');
			if ($treatment) {
				$this->db->where('amenitys_element.treatment_id', $treatment);
			}
			$this->db->where('amenitys.timestamp >=', $from);
	        $this->db->where('amenitys.timestamp <=', $to);
			$this->db->order_by('amenitys.hotel_id');
			$query = $this->db->get('amenitys_element');
			return $query->num_rows();
	  	}

	  	function get_all_items_type($from, $to, $type = FALSE){
		    $this->load->database();
			$this->db->select('amenitys_element.id, amenitys_element.amen_id, amenitys_element.room, amenitys_element.guest, amenitys_element.pax, amenitys_element.child, amenitys_element.reason, amenitys_element.location, amenitys_element.treatment_id, amenitys.hotel_id, amenitys.user_id, amenitys.type_id, amenitys.timestamp, amenitys.date_time, hotels.name as hotel_name, hotels.logo As logo, users.fullname as user_name, amenitys_treatments.name as treatment_type, amenitys_types.name as type_name');
			$this->db->join('amenitys', 'amenitys_element.amen_id = amenitys.id','left');
			$this->db->join('amenitys_treatments', 'amenitys_element.treatment_id = amenitys_treatments.id','left');
			$this->db->join('amenitys_types', 'amenitys.type_id = amenitys_types.id','left');
			$this->db->join('hotels', 'amenitys.hotel_id = hotels.id','left');
			$this->db->join('users', 'amenitys.user_id = users.id','left');
			if ($type) {
				$this->db->where('amenitys.type_id', $type);
			}
			$this->db->where('amenitys.timestamp >=', $from);
	        $this->db->where('amenitys.timestamp <=', $to);
			$this->db->order_by('amenitys.hotel_id');
			$query = $this->db->get('amenitys_element');
			return $query->result_array();
	  	}

	  	function get_all_forms($state){
		    $this->load->database();
			$this->db->select('amenitys.id, amenitys.timestamp, amenitys.hotel_id, hotels.name as hotel_name');
			$this->db->join('hotels', 'amenitys.hotel_id = hotels.id','left');
			$x = array('0' => 1, '1' => 4, '2' => 5, '3' => 6, '4' => 7, '5' => 8);
			if ($state == 1) {
				$this->db->where_in('amenitys.state_id', $x);	
			}else{
				$this->db->where('amenitys.state_id', $state);
			}
			$this->db->order_by('amenitys.hotel_id');
			$query = $this->db->get('amenitys');
			return $query->result_array();
	  	}

	  	function get_all_forms_count($state){
		    $this->load->database();
			$this->db->select('amenitys.id, amenitys.hotel_id, hotels.name as hotel_name');
			$this->db->join('hotels', 'amenitys.hotel_id = hotels.id','left');
			$x = array('0' => 1, '1' => 4, '2' => 5, '3' => 6, '4' => 7, '5' => 8);
			if ($state == 1) {
				$this->db->where_in('amenitys.state_id', $x);	
			}else{
				$this->db->where('amenitys.state_id', $state);
			}
			$this->db->order_by('amenitys.hotel_id');
			$query = $this->db->get('amenitys');
			return $query->num_rows();
	  	}

	  	function get_forms($state, $hotel_id){
		    $this->load->database();
			$this->db->select('amenitys.id, amenitys.timestamp, amenitys.hotel_id, hotels.name as hotel_name');
			$this->db->join('hotels', 'amenitys.hotel_id = hotels.id','left');
			$this->db->where('amenitys.hotel_id', $hotel_id);
			$x = array('0' => 1, '1' => 4, '2' => 5, '3' => 6, '4' => 7, '5' => 8);
			if ($state == 1) {
				$this->db->where_in('amenitys.state_id', $x);	
			}else{
				$this->db->where('amenitys.state_id', $state);
			}
			$this->db->order_by('amenitys.timestamp');
			$query = $this->db->get('amenitys');
			return $query->result_array();
	  	}

	  	function get_forms_count($state, $hotel_id){
		    $this->load->database();
			$this->db->select('amenitys.id, amenitys.hotel_id, hotels.name as hotel_name');
			$this->db->join('hotels', 'amenitys.hotel_id = hotels.id','left');
			$this->db->where('amenitys.hotel_id', $hotel_id);
			$x = array('0' => 1, '1' => 4, '2' => 5, '3' => 6, '4' => 7, '5' => 8);
			if ($state == 1) {
				$this->db->where_in('amenitys.state_id', $x);	
			}else{
				$this->db->where('amenitys.state_id', $state);
			}
			$this->db->order_by('amenitys.timestamp');
			$query = $this->db->get('amenitys');
			return $query->num_rows();
	  	}

	  	function get_all_items_type_count($from, $to, $type = FALSE){
		    $this->load->database();
			$this->db->select('amenitys_element.id, amenitys_element.amen_id, amenitys_element.room, amenitys.type_id, amenitys.hotel_id, amenitys.timestamp');
			$this->db->join('amenitys', 'amenitys_element.amen_id = amenitys.id','left');
			if ($type) {
				$this->db->where('amenitys.type_id', $type);
			}
			$this->db->where('amenitys.timestamp >=', $from);
	        $this->db->where('amenitys.timestamp <=', $to);
			$this->db->order_by('amenitys.hotel_id');
			$query = $this->db->get('amenitys_element');
			return $query->num_rows();
	  	}

	  	function get_all_items_refl($from, $to){
		    $this->load->database();
			$this->db->select('amenitys_element.id, amenitys_element.amen_id, amenitys_element.room, amenitys_element.guest, amenitys_element.pax, amenitys_element.child, amenitys_element.reason, amenitys_element.location, amenitys_element.treatment_id, amenitys.hotel_id, amenitys.user_id, amenitys.refiller, amenitys.timestamp, amenitys.date_time, hotels.name as hotel_name, hotels.logo As logo, users.fullname as user_name, amenitys_treatments.name as treatment_type, amenitys_types.name as type_name');
			$this->db->join('amenitys', 'amenitys_element.amen_id = amenitys.id','left');
			$this->db->join('amenitys_treatments', 'amenitys_element.treatment_id = amenitys_treatments.id','left');
			$this->db->join('amenitys_types', 'amenitys.type_id = amenitys_types.id','left');
			$this->db->join('hotels', 'amenitys.hotel_id = hotels.id','left');
			$this->db->join('users', 'amenitys.user_id = users.id','left');
			$this->db->where('amenitys.refiller', 1);
			$this->db->where('amenitys.timestamp >=', $from);
	        $this->db->where('amenitys.timestamp <=', $to);
			$this->db->order_by('amenitys.hotel_id');
			$query = $this->db->get('amenitys_element');
			return $query->result_array();
	  	}

	  	function get_all_items_refl_count($from, $to){
		    $this->load->database();
			$this->db->select('amenitys_element.id, amenitys_element.amen_id, amenitys_element.room, amenitys.refiller, amenitys.hotel_id, amenitys.timestamp');
			$this->db->join('amenitys', 'amenitys_element.amen_id = amenitys.id','left');
			$this->db->where('amenitys.refiller', 1);
			$this->db->where('amenitys.timestamp >=', $from);
	        $this->db->where('amenitys.timestamp <=', $to);
			$this->db->order_by('amenitys.hotel_id');
			$query = $this->db->get('amenitys_element');
			return $query->num_rows();
	  	}

	}

?>