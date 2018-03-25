<?php
	class amenity_model extends CI_Model{

  		function __contruct(){
			parent::__construct;
		}

		function amen_do_sign($amen_id){
  	 		$this->load->database();
			$this->db->select('amenity_signature.*');
			$this->db->where('amenity_signature.amen_id', $amen_id);		
			$query = $this->db->get('amenity_signature');
			return $query->num_rows();  	
		}

		function update_files($assumed_id, $amen_id) {
  			$this->load->database();
  			$this->db->query('UPDATE amenity_filles SET amen_id = "'.$amen_id.'" WHERE amen_id = "'.$assumed_id.'"');
  		}

  		function getby_fille($amen_id){
	    	$this->load->database();
			$this->db->select('amenity_filles.*, users.fullname as user_name');
			$this->db->join('users', 'amenity_filles.user_id = users.id','left');
			$this->db->where('amen_id', $amen_id);
			$query = $this->db->get('amenity_filles');
			return $query->result_array();
  		}

  		function add($amen_id, $name, $user_id) {
	  		$this->load->database();
	  		$this->db->query('INSERT INTO amenity_filles(amen_id, name, user_id) VALUES("'.$amen_id.'","'.$name.'","'.$user_id.'")');
	  	}

	  	function remove($id) {
	      $this->load->database();
	      $this->db->query('DELETE FROM amenity_filles WHERE id = '.$id);
	    }

		public function get_guests()
    	{
            $server = "192.168.1.230";
            $dbuser = "v8live";
            $dbpass = "live";
            $dbs = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = ".$server.")(PORT = 1521)))(CONNECT_DATA=(SID=v8)))";
            $connect = oci_connect ($dbuser, $dbpass, $dbs,'UTF8',OCI_DEFAULT );
            $sql = "SELECT ACT_V8_REP_YRES_INFOS.GUEST_NAME,YRMS_SHORTDESC FROM ACT_V8_REP_YRES_INFOS WHERE CHECKED_IN ='1' AND CHECKED_OUT = '0'";
            $querys = oci_parse($connect,$sql);
            oci_execute($querys);
            // $num_rows = oci_fetch_assoc($querys);
            while (false !== ($row = oci_fetch_assoc($querys))) {
            $output_array[] = array('room' => $row['YRMS_SHORTDESC'], 'GUEST_NAME' => $row['GUEST_NAME']);
            }
            // die(print_r($output_array));
            oci_free_statement($querys);
            oci_close($connect);
            return $output_array;
    	}

    	function getbyhotel($hid){
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
			//else{
			//	$server = "192.168.1.230";
			//}
            $dbuser = "v8live";
            $dbpass = "live";
            $dbs = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = ".$server.")(PORT = 1521)))(CONNECT_DATA=(SID=v8)))";
            $connect = oci_connect ($dbuser, $dbpass, $dbs,'UTF8',OCI_DEFAULT );
            $sql = "SELECT ACT_V8_REP_YRES_INFOS.GUEST_NAME,ACT_V8_REP_YRES_INFOS.YRMS_SHORTDESC, ACT_V8_REP_YRES_INFOS.YRES_ACTARRTIME, ACT_V8_REP_YRES_INFOS.YRES_EXPDEPTIME, ACT_V8_REP_YRES_INFOS.XCOU_LONGDESC FROM ACT_V8_REP_YRES_INFOS ";
            $querys = oci_parse($connect,$sql);
            oci_execute($querys);
            // $num_rows = oci_fetch_assoc($querys);
            while (false !== ($row = oci_fetch_assoc($querys))) {
            $output_array[] = array('room' => $row['YRMS_SHORTDESC'], 'arriv' => $row['YRES_ACTARRTIME'], 'depart' => $row['YRES_EXPDEPTIME'], 'nation' => $row['XCOU_LONGDESC'], 'guest_name' => $row['GUEST_NAME']);
            }
            // die(print_r($output_array));
            oci_free_statement($querys);
            oci_close($connect);
            return $output_array;
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
			//else{
			//	$server = "192.168.1.230";
			//}
            $dbuser = "v8live";
            $dbpass = "live";
            $dbs = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = ".$server.")(PORT = 1521)))(CONNECT_DATA=(SID=v8)))";
            $connect = oci_connect ($dbuser, $dbpass, $dbs,'UTF8',OCI_DEFAULT );
            $sql = "SELECT ACT_V8_REP_YRES_INFOS.GUEST_NAME,ACT_V8_REP_YRES_INFOS.YRMS_SHORTDESC, ACT_V8_REP_YRES_INFOS.YRES_ACTARRTIME, ACT_V8_REP_YRES_INFOS.YRES_EXPDEPTIME, ACT_V8_REP_YRES_INFOS.XCOU_LONGDESC FROM ACT_V8_REP_YRES_INFOS WHERE CHECKED_IN ='1' AND CHECKED_OUT = '0' AND YRMS_SHORTDESC=".$rn;
            $querys = oci_parse($connect,$sql);
            oci_execute($querys);
            // $num_rows = oci_fetch_assoc($querys);
            while (false !== ($row = oci_fetch_assoc($querys))) {
            $output_array[] = array('room' => $row['YRMS_SHORTDESC'], 'arriv' => $row['YRES_ACTARRTIME'], 'depart' => $row['YRES_EXPDEPTIME'], 'nation' => $row['XCOU_LONGDESC'], 'guest_name' => $row['GUEST_NAME']);
            }
            // die(print_r($output_array));
            oci_free_statement($querys);
            oci_close($connect);
            return $output_array;
    	}

		function getall(){
	    	$this->load->database();
			$this->db->select('users.id as userid,users.*,amenity.*,hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('users', 'amenity.user_id = users.id','left');
			$this->db->join('hotels', 'amenity.hotel_id = hotels.id','left');
			$query = $this->db->get('amenity');
			return $query->result_array();
  		}

  		function getby_criteria($hotel_id, $role_id, $department_id){
  			$this->load->database();
			$this->db->select('users.fullname, users.email, employees_hotels.hotel_id');
			$this->db->join('employees_hotels', 'users.id = employees_hotels.employee_id','left');
			$this->db->where('employees_hotels.hotel_id', $hotel_id);
			$this->db->where('users.role_id', $role_id);
			$this->db->where('users.department_id', $department_id);
			$query = $this->db->get('users');
			return $query->result_array();
  		}

		function create_amenity($data) {
			$this->load->database();
			$this->db->insert('amenity', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function create_amenity_edit($data) {
			$this->load->database();
			$this->db->insert('amenity_edit', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function create_room($data) {
			$this->db->insert('amenity_element', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function getall_vip($from, $to, $vip = FALSE, $user_hotels = FALSE){
		    $this->load->database();
			$this->db->select('amenity_element.*, amenity.hotel_id, amenity.user_id, amenity.timestamp, amenity.date_time, amenity.reason, hotels.name as hotel_name, hotels.logo As logo, users.fullname as user_name');
			$this->db->join('amenity', 'amenity_element.amen_id = amenity.id','left');
			$this->db->join('hotels', 'amenity.hotel_id = hotels.id','left');
			$this->db->join('users', 'amenity.user_id = users.id','left');
			if ($vip) {
				$this->db->where('amenity_element.treatment', $vip);
			}
			if ($user_hotels) {
          		$this->db->where_in('amenity.hotel_id', $user_hotels);
        	}
			$this->db->where('amenity.timestamp >=', $from);
	        $this->db->where('amenity.timestamp <=', $to);
			$this->db->order_by('amenity.hotel_id');
			$query = $this->db->get('amenity_element');
			return $query->result_array();
	  	}

	  	function getall_vip_count($from, $to, $vip = FALSE, $user_hotels = FALSE){
		    $this->load->database();
			$this->db->select('amenity_element.*, amenity.hotel_id, amenity.user_id, amenity.timestamp, amenity.date_time, amenity.reason, hotels.name as hotel_name, hotels.logo As logo, users.fullname as user_name');
			$this->db->join('amenity', 'amenity_element.amen_id = amenity.id','left');
			$this->db->join('hotels', 'amenity.hotel_id = hotels.id','left');
			$this->db->join('users', 'amenity.user_id = users.id','left');
			if ($vip) {
				$this->db->where('amenity_element.treatment', $vip);
			}
			if ($user_hotels) {
          		$this->db->where_in('amenity.hotel_id', $user_hotels);
        	}
			$this->db->where('amenity.timestamp >=', $from);
	        $this->db->where('amenity.timestamp <=', $to);
			$this->db->order_by('amenity.hotel_id');
			$query = $this->db->get('amenity_element');
			return $query->num_rows();
	  	}

	  	function get_vip($hid, $from, $to, $vip = FALSE){
		    $this->load->database();
			$this->db->select('amenity_element.*, amenity.hotel_id, amenity.user_id, amenity.timestamp, amenity.date_time, amenity.reason, hotels.name as hotel_name, hotels.logo As logo, users.fullname as user_name');
			$this->db->join('amenity', 'amenity_element.amen_id = amenity.id','left');
			$this->db->join('hotels', 'amenity.hotel_id = hotels.id','left');
			$this->db->join('users', 'amenity.user_id = users.id','left');
			$this->db->where('amenity.hotel_id', $hid);
			if ($vip) {
				$this->db->where('amenity_element.treatment', $vip);
			}
			$this->db->where('amenity.timestamp >=', $from);
	        $this->db->where('amenity.timestamp <=', $to);
			$this->db->order_by('amenity.hotel_id');
			$query = $this->db->get('amenity_element');
			return $query->result_array();
	  	}

	  	function get_vip_count($hid, $from, $to, $vip = FALSE){
		    $this->load->database();
			$this->db->select('amenity_element.*, amenity.hotel_id, amenity.user_id, amenity.timestamp, amenity.date_time, amenity.reason, hotels.name as hotel_name, hotels.logo As logo, users.fullname as user_name');
			$this->db->join('amenity', 'amenity_element.amen_id = amenity.id','left');
			$this->db->join('hotels', 'amenity.hotel_id = hotels.id','left');
			$this->db->join('users', 'amenity.user_id = users.id','left');
			$this->db->where('amenity.hotel_id', $hid);
			if ($vip) {
				$this->db->where('amenity_element.treatment', $vip);
			}
			$this->db->where('amenity.timestamp >=', $from);
	        $this->db->where('amenity.timestamp <=', $to);
			$this->db->order_by('amenity.hotel_id');
			$query = $this->db->get('amenity_element');
			return $query->num_rows();
	  	}

	  	function type_all_report($user_hotels = FALSE, $from, $to, $type){
		    $this->load->database();
		    $this->db->select('amenity_reason.*, amenity.hotel_id, amenity.date_time, amenity.reason, hotels.name as hotel_name, hotels.logo As logo, users.fullname as user_name');
			$this->db->join('amenity', 'amenity_reason.amen_id = amenity.id','left');
			$this->db->join('hotels', 'amenity.hotel_id = hotels.id','left');
			$this->db->join('users', 'amenity_reason.user_id = users.id','left');
			if ($user_hotels) {
          		$this->db->where_in('amenity.hotel_id', $user_hotels);
        	}
			$this->db->where('amenity_reason.type', $type);
			$this->db->where('amenity.timestamp >=', $from);
	        $this->db->where('amenity.timestamp <=', $to);	
        	$this->db->order_by('timestamp', 'DESC');
			$query = $this->db->get('amenity_reason');
			return $query->result_array();
	  	}

	  	function type_report($hid, $from, $to, $type){
		    $this->load->database();
		    $this->db->select('amenity_reason.*, amenity.hotel_id, amenity.date_time, amenity.reason, hotels.name as hotel_name, hotels.logo As logo, users.fullname as user_name');
			$this->db->join('amenity', 'amenity_reason.amen_id = amenity.id','left');
			$this->db->join('hotels', 'amenity.hotel_id = hotels.id','left');
			$this->db->join('users', 'amenity_reason.user_id = users.id','left');
			$this->db->where('amenity.hotel_id', $hid);
			$this->db->where('amenity_reason.type', $type);
			$this->db->where('amenity.timestamp >=', $from);
	        $this->db->where('amenity.timestamp <=', $to);	
        	$this->db->order_by('timestamp', 'DESC');
			$query = $this->db->get('amenity_reason');
			return $query->result_array();
	  	}

	  	function get_refl($hid , $from, $to){
		    $this->load->database();
			$this->db->select('amenity_refilling.*, amenity.hotel_id, amenity_element.guest, amenity_element.pax, amenity_element.treatment, amenity.reason, hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('amenity', 'amenity_refilling.amen_id = amenity.id','left');
			$this->db->join('amenity_element', 'amenity_refilling.room_id = amenity_element.id','left');
			$this->db->join('hotels', 'amenity.hotel_id = hotels.id','left');
			$this->db->where('amenity.hotel_id', $hid);
			$this->db->where('amenity_refilling.date_time >=', $from);
	        $this->db->where('amenity_refilling.date_time <=', $to);
			$this->db->order_by('amenity_refilling.date_time');
			$query = $this->db->get('amenity_refilling');
			return $query->result_array();
	  	}

	  	function get_refl_count($hid, $from, $to){
		     $this->load->database();
			$this->db->select('amenity_refilling.*, amenity.hotel_id, amenity_element.guest, amenity_element.pax, amenity_element.treatment, amenity.reason, hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('amenity', 'amenity_refilling.amen_id = amenity.id','left');
			$this->db->join('amenity_element', 'amenity_refilling.room_id = amenity_element.id','left');
			$this->db->join('hotels', 'amenity.hotel_id = hotels.id','left');
			$this->db->where('amenity.hotel_id', $hid);
			$this->db->where('amenity_refilling.date_time >=', $from);
	        $this->db->where('amenity_refilling.date_time <=', $to);
			$this->db->order_by('amenity_refilling.date_time');
			$query = $this->db->get('amenity_refilling');
			return $query->num_rows();
	  	}

		function create_room_edit($data) {
			$this->db->insert('amenity_element_edit', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		/*function update_amenity($data, $amen_id) {
			$this->load->database();
			$this->db->where('amenity.id', $amen_id);		
			$this->db->update('amenity', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}*/

		function update_root($amen_id, $date_time, $reason, $location, $others, $relations) {
			$this->db->update('amenity', array('date_time'=> $date_time, 'reason'=> $reason, 'location'=> $location, 'others'=> $others, 'relations'=> $relations), "id = ".$amen_id);
		}

		function update_room($data, $amen_id, $room_id) {
			$this->load->database();
			$this->db->where('amenity_element.amen_id', $amen_id);	
			$this->db->where('amenity_element.id', $room_id);		
			$this->db->update('amenity_element', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}


		function get_amenity($amen_id) {
			$this->db->select('amenity.*, hotels.name as hotel_name, hotels.logo As logo, users.fullname as name');
			$this->db->join('hotels', 'amenity.hotel_id = hotels.id','left');
			$this->db->join('users', 'amenity.user_id = users.id','left');
			$this->db->where('amenity.id', $amen_id);		
			$query = $this->db->get('amenity');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
		}

		function get_amenitys_edit($amen_id) {
			$this->db->select('amenity_edit.*, hotels.name as hotel_name, hotels.logo As logo, users.fullname as name');
			$this->db->join('hotels', 'amenity_edit.hotel_id = hotels.id','left');
			$this->db->join('users', 'amenity_edit.user_id = users.id','left');
			$this->db->where('amenity_edit.amen_id', $amen_id);		
			$query = $this->db->get('amenity_edit');
			return ($query->num_rows() > 0 )? $query->result_array() : FALSE;
		}

		function get_amenity_edit($amen_id) {
			$this->db->select('amenity_edit.*, hotels.name as hotel_name, hotels.logo As logo, users.fullname as name');
			$this->db->join('hotels', 'amenity_edit.hotel_id = hotels.id','left');
			$this->db->join('users', 'amenity_edit.user_id = users.id','left');
			$this->db->where('amenity_edit.amen_id', $amen_id);	
			$this->db->order_by('timestamp', 'DESC');
        	$this->db->limit('1');	
			$query = $this->db->get('amenity_edit');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
		}

		function get_items($amen_id) {
			$this->db->select('amenity_element.*, amenity.hotel_id');
			$this->db->join('amenity', 'amenity_element.amen_id = amenity.id','left');
			$this->db->where('amenity_element.amen_id', $amen_id);
			$query = $this->db->get('amenity_element');
			return ($query->num_rows() > 0 )? $query->result_array() : FALSE;
		}

		function get_itemss($amen_id) {
			$this->db->select('amenity_element.id, amenity_element.treatment, amenity_element.room');
			$this->db->where('amenity_element.amen_id', $amen_id);
			$query = $this->db->get('amenity_element');
			return ($query->num_rows() > 0 )? $query->result_array() : FALSE;
		}

		function get_room($amen_id) {
			$this->db->select('amenity_element.*, amenity.hotel_id');
			$this->db->join('amenity', 'amenity_element.amen_id = amenity.id','left');
			$this->db->where('amenity_element.amen_id', $amen_id);
			$this->db->order_by('timestamp', 'DESC');
        	$this->db->limit('1');	
			$query = $this->db->get('amenity_element');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
		}

		function get_room_edit($amen_id) {
			$this->db->select('amenity_element_edit.*, amenity.hotel_id');
			$this->db->join('amenity', 'amenity_element_edit.amen_id = amenity.id','left');
			$this->db->where('amenity_element_edit.amen_id', $amen_id);
			$this->db->order_by('timestamp', 'DESC');
        	$this->db->limit('1');	
			$query = $this->db->get('amenity_element_edit');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
		}

		function get_items_edit_count($amen_id) {
			$this->db->select('amenity_element_edit.*, amenity_edit.hotel_id');
			$this->db->join('amenity_edit', 'amenity_element_edit.amen_id = amenity_edit.id','left');
			$this->db->where('amenity_element_edit.amen_id', $amen_id);
			$query = $this->db->get('amenity_element_edit');
			return $query->num_rows();
		}

		function get_items_edit($amen_id) {
			$this->db->select('amenity_element_edit.*, amenity_edit.hotel_id');
			$this->db->join('amenity_edit', 'amenity_element_edit.amen_id = amenity_edit.id','left');
			$this->db->where('amenity_element_edit.amen_id', $amen_id);
			$query = $this->db->get('amenity_element_edit');
			return $query->num_rows();
		}

		function get_item_edit($edit_id) {
			$this->db->select('amenity_element_edit.*, amenity_edit.hotel_id');
			$this->db->join('amenity_edit', 'amenity_element_edit.amen_id = amenity_edit.id','left');
			$this->db->where('amenity_element_edit.edit_id', $edit_id);
			$query = $this->db->get('amenity_element_edit');
			return ($query->num_rows() > 0 )? $query->result_array() : FALSE;
		}

		function get_item_edit_refl($edit_id) {
			$this->db->select('amenity_element_edit.*, amenity_edit.hotel_id');
			$this->db->join('amenity_edit', 'amenity_element_edit.amen_id = amenity_edit.id','left');
			$this->db->where('amenity_element_edit.edit_id', $edit_id);
			$query = $this->db->get('amenity_element_edit');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
		}

		function get_item($id) {
			$this->db->select('amenity_element.*');
			$this->db->where('amenity_element.id', $id);
			$query = $this->db->get('amenity_element');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
		}

		function get_amenitys($amen_id) {
			$this->db->select('amenity_moved.*, users.fullname as name_new');
			$this->db->join('users', 'amenity_moved.user_new = users.id','left');
			$this->db->where('amenity_moved.amen_id', $amen_id);	
			$query = $this->db->get('amenity_moved');
			return ($query->num_rows() > 0 )? $query->result_array() : FALSE;
		}

		function get_amen($room_id) {
			$this->db->select('amenity_moved.*, users.fullname as name_new');
			$this->db->join('users', 'amenity_moved.user_new = users.id','left');
			$this->db->where('amenity_moved.room_id', $room_id);	
        	$this->db->order_by('timestamp', 'DESC');
        	$this->db->limit('1');
			$query = $this->db->get('amenity_moved');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
		}

		function get_amens($room_id) {
			$this->db->select('amenity_moved.room_new');
			$this->db->where('amenity_moved.room_id', $room_id);	
        	$this->db->order_by('timestamp', 'DESC');
        	$this->db->limit('1');
			$query = $this->db->get('amenity_moved');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
		}

		function create_amenitys($data) {
			$this->load->database();
			$this->db->insert('amenity_moved', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function view($user_hotels = FALSE) {
  	  		$this->load->database();
			$this->db->select('amenity.id, amenity.hotel_id, amenity.timestamp, amenity.date_time, hotels.name as hotel_name');
			$this->db->join('hotels', 'amenity.hotel_id = hotels.id','left');
        	if ($user_hotels) {
          		$this->db->where_in('amenity.hotel_id', $user_hotels);
        	}
			$this->db->where('state_id !=', 0);		
        	$this->db->order_by('timestamp', 'DESC');
			$query = $this->db->get('amenity');
			return $query->result_array();
		}

		function view_rej($user_hotels = FALSE) {
  	  		$this->load->database();
			$this->db->select('amenity.id, amenity.hotel_id, amenity.timestamp, amenity.date_time, hotels.name as hotel_name');
			$this->db->join('hotels', 'amenity.hotel_id = hotels.id','left');
        	if ($user_hotels) {
          		$this->db->where_in('amenity.hotel_id', $user_hotels);
        	}
			$this->db->where('state_id', 3);	
        	$this->db->order_by('timestamp', 'DESC');
			$query = $this->db->get('amenity');
			return $query->result_array();
		}

		function view_wat($user_hotels = FALSE) {
  	  		$this->load->database();
			$this->db->select('amenity.id, amenity.hotel_id, amenity.timestamp, amenity.date_time, hotels.name as hotel_name');
			$this->db->join('hotels', 'amenity.hotel_id = hotels.id','left');
        	if ($user_hotels) {
          		$this->db->where_in('amenity.hotel_id', $user_hotels);
        	}
			$this->db->where('state_id !=', 0, 2, 3);	
        	$this->db->order_by('timestamp', 'DESC');
			$query = $this->db->get('amenity');
			return $query->result_array();
		}

		function view_app($user_hotels = FALSE) {
  	  		$this->load->database();
			$this->db->select('amenity.id, amenity.hotel_id, amenity.timestamp, amenity.state_id, amenity.date_time, hotels.name as hotel_name');
			$this->db->join('hotels', 'amenity.hotel_id = hotels.id','left');
        	if ($user_hotels) {
          		$this->db->where_in('amenity.hotel_id', $user_hotels);
        	}
			$this->db->where('state_id', 2);		
        	$this->db->order_by('timestamp', 'DESC');
			$query = $this->db->get('amenity');
			return $query->result_array();
		}

		function getby_verbal($amen_id){
	    	$this->load->database();
			$this->db->select('amenity_signature.id, amenity_signature.role_id, amenity_signature.department_id, amenity_signature.rank, amenity_signature.user_id, amenity_signature.reject, amenity_signature.timestamp, roles.role, departments.name as department');
			$this->db->join('roles', 'amenity_signature.role_id = roles.id', 'left');
			$this->db->join('departments', 'amenity_signature.department_id = departments.id', 'left');
			$this->db->where('amen_id', $amen_id);
        	$this->db->order_by('rank');
			$query = $this->db->get('amenity_signature');
			return $query->result_array();
  		}

  		function getby_verbals($amen_id){
	    	$this->load->database();
			$this->db->select('amenity_signature.role_id, amenity_signature.department_id, amenity_signature.user_id, amenity_signature.reject, roles.role, departments.name as department, users.fullname as user_name');
			$this->db->join('roles', 'amenity_signature.role_id = roles.id', 'left');
			$this->db->join('departments', 'amenity_signature.department_id = departments.id', 'left');
			$this->db->join('users', 'amenity_signature.user_id = users.id', 'left');
			$this->db->where('amen_id', $amen_id);
			$query = $this->db->get('amenity_signature');
			return $query->result_array();
  		}

  		function update_state($amen_id, $state) {
			$this->db->update('amenity', array('state_id'=> $state), "id = ".$amen_id);
		}

		function get_signature_identity($sign_id){
  			$this->load->database();
			$query = $this->db->query('SELECT amenity.hotel_id, amenity_signature.amen_id FROM amenity_signature JOIN amenity ON amenity_signature.amen_id = amenity.id WHERE amenity_signature.id ='.$sign_id);
  			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  		}

  		function amen_sign($type){
  	 		$this->load->database();
			$this->db->select('amenity_role.*');
			$this->db->where('amen_type', $type);		
			$query = $this->db->get('amenity_role');
			return $query->result_array();  	
		}

		function add_signature($amen_id, $role_id, $department_id, $rank){
	    	$this->load->database();
			$query = $this->db->query('INSERT INTO amenity_signature(amen_id, role_id, department_id, rank) VALUES("'.$amen_id.'", "'.$role_id.'", "'.$department_id.'", "'.$rank.'")');
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
  		}

  		function self_sign($amen_id, $user_id){
	    	$this->load->database();
			$query = $this->db->query('UPDATE amenity_signature SET user_id = '.$user_id.' WHERE amen_id = '.$amen_id.' AND role_id = 0');
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function approve($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE amenity_signature SET user_id = '.$uid.' WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function sign($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE amenity_signature SET user_id = '.$uid.' WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function reject($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE amenity_signature SET user_id = '.$uid.', reject = 1 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

	  	function unsign($id){
	  		$this->load->database();
			$query = $this->db->query('UPDATE amenity_signature SET user_id = NULL, reject = 0 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
	  	}

	  	function disapprove($id, $uid){
	  		$this->load->database();
			$query = $this->db->query('UPDATE amenity_signature SET user_id = '.$uid.', reject = 1 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
	  	}

	  	function get_signer_email ($role_id, $department_id){
			$query = $this->db->query("
				SELECT email FROM users
				WHERE role_id =".$role_id."
				AND  department_id =".$department_id."
				AND  banned = '0' ");
			return $query->result_array();
		}

		function owner($user_id){
  			$query = $this->db->query("
				SELECT email FROM users
				WHERE id =".$user_id);
			return $query->result_array();
  		}

  		function InsertComment($data){
			$this->db->insert('amenity_comments', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function GetComment($amen_id){
			$query = $this->db->query("
				SELECT users.fullname, amenity_comments.comment, amenity_comments.created FROM amenity_comments
				JOIN users on amenity_comments.user_id = users.id
				WHERE amenity_comments.amen_id =".$amen_id);
			return $query->result_array();
  		}

  		function create_reason($data) {
			$this->db->insert('amenity_reason', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function get_reason($amen_id) {
			$this->db->select('amenity_reason.*, users.fullname as name');
			$this->db->join('users', 'amenity_reason.user_id = users.id','left');
			$this->db->where('amenity_reason.amen_id', $amen_id);	
        	$this->db->order_by('timestamp', 'DESC');
        	$this->db->limit(1);
			$query = $this->db->get('amenity_reason');
			return $query->row_array();
		}

		function get_reasons($amen_id) {
			$this->db->select('amenity_reason.type');
			$this->db->where('amenity_reason.amen_id', $amen_id);	
        	$this->db->order_by('timestamp', 'DESC');
        	$this->db->limit(1);
			$query = $this->db->get('amenity_reason');
			return $query->row_array();
		}

		function get_count($amen_id){
	    	$this->load->database();
			$this->db->select('amenity_signature.*');
			$this->db->where('amen_id', $amen_id);
			$this->db->order_by('rank');
			$query = $this->db->get('amenity_signature');
			return $query->num_rows();
  		}

  		function create_refl($data) {
			$this->db->insert('amenity_refilling', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

	}