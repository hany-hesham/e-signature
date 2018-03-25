<?php

	class upgrad_model extends CI_Model{

  		function __contruct(){
			parent::__construct;
		}

		function view($user_hotels = FALSE) {
  	  		$this->load->database();
			$this->db->select('upgrad.id, upgrad.hotel_id, upgrad.timestamp, upgrad.date, hotels.name as hotel_name');
			$this->db->join('hotels', 'upgrad.hotel_id = hotels.id','left');
        	if ($user_hotels) {
          		$this->db->where_in('upgrad.hotel_id', $user_hotels);
        	}
			$this->db->where('upgrad.state_id !=', 0);		
        	$this->db->order_by('timestamp', 'DESC');
			$query = $this->db->get('upgrad');
			return $query->result_array();
		}

		function get_by_verbals($up_id){
	    	$this->load->database();
			$this->db->select('upgrad_signature.role_id, upgrad_signature.department_id, upgrad_signature.user_id, upgrad_signature.reject, upgrad_signature.rank, roles.role, departments.name as department, users.fullname as user_name');
			$this->db->join('roles', 'upgrad_signature.role_id = roles.id', 'left');
			$this->db->join('departments', 'upgrad_signature.department_id = departments.id', 'left');
			$this->db->join('users', 'upgrad_signature.user_id = users.id', 'left');
			$this->db->where('up_id', $up_id);
        	$this->db->order_by('rank');
			$query = $this->db->get('upgrad_signature');
			return $query->result_array();
  		}

  		function get_room($up_id) {
			$this->db->select('upgrad_room.room');
			$this->db->where('upgrad_room.up_id', $up_id);
			$query = $this->db->get('upgrad_room');
			return ($query->num_rows() > 0 )? $query->result_array() : FALSE;
		}

		function view_app($user_hotels = FALSE) {
  	  		$this->load->database();
			$this->db->select('upgrad.id, upgrad.hotel_id, upgrad.timestamp, upgrad.date, hotels.name as hotel_name');
			$this->db->join('hotels', 'upgrad.hotel_id = hotels.id','left');
        	if ($user_hotels) {
          		$this->db->where_in('upgrad.hotel_id', $user_hotels);
        	}
			$this->db->where('upgrad.state_id', 2);		
        	$this->db->order_by('timestamp', 'DESC');
			$query = $this->db->get('upgrad');
			return $query->result_array();
		}

		function view_wat($user_hotels = FALSE) {
  	  		$this->load->database();
			$this->db->select('upgrad.id, upgrad.hotel_id, upgrad.timestamp, upgrad.date, hotels.name as hotel_name');
			$this->db->join('hotels', 'upgrad.hotel_id = hotels.id','left');
        	if ($user_hotels) {
          		$this->db->where_in('upgrad.hotel_id', $user_hotels);
        	}
			$this->db->where('upgrad.state_id', 1);		
        	$this->db->order_by('timestamp', 'DESC');
			$query = $this->db->get('upgrad');
			return $query->result_array();
		}

		function view_rej($user_hotels = FALSE) {
  	  		$this->load->database();
			$this->db->select('upgrad.id, upgrad.hotel_id, upgrad.timestamp, upgrad.date, hotels.name as hotel_name');
			$this->db->join('hotels', 'upgrad.hotel_id = hotels.id','left');
        	if ($user_hotels) {
          		$this->db->where_in('upgrad.hotel_id', $user_hotels);
        	}
			$this->db->where('upgrad.state_id', 3);		
        	$this->db->order_by('timestamp', 'DESC');
			$query = $this->db->get('upgrad');
			return $query->result_array();
		}

		function create_upgrad($data) {
			$this->load->database();
			$this->db->insert('upgrad', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function create_room($data) {
			$this->load->database();
			$this->db->insert('upgrad_room', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function update_room($data, $up_id, $room_id) {
			$this->load->database();
			$this->db->where('upgrad_room.up_id', $up_id);	
			$this->db->where('upgrad_room.id', $room_id);		
			$this->db->update('upgrad_room', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function up_sign(){
  	 		$this->load->database();
			$this->db->select('upgrad_role.*');
			$query = $this->db->get('upgrad_role');
			return $query->result_array();  	
		}

		function up_do_sign($up_id){
  	 		$this->load->database();
			$this->db->select('upgrad_signature.*');
			$this->db->where('upgrad_signature.up_id', $up_id);		
			$query = $this->db->get('upgrad_signature');
			return $query->num_rows();  	
		}

		function add_signature($up_id, $role_id, $department_id, $rank){
	    	$this->load->database();
			$query = $this->db->query('INSERT INTO upgrad_signature(up_id, role_id, department_id, rank) VALUES("'.$up_id.'", "'.$role_id.'", "'.$department_id.'", "'.$rank.'")');
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
  		}

  		function get_upgrad($up_id) {
			$this->db->select('upgrad.*, hotels.name as hotel_name, hotels.logo As logo, users.fullname as name');
			$this->db->join('hotels', 'upgrad.hotel_id = hotels.id','left');
			$this->db->join('users', 'upgrad.user_id = users.id','left');
			$this->db->where('upgrad.id', $up_id);		
			$query = $this->db->get('upgrad');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
		}

		function get_rooms($up_id) {
			$this->db->select('upgrad_room.*, operators.name as operator_name, upgrad_reasons.name as upgrad_reason, room_types.name as booked_type, rooms_types.name as new_type');
			$this->db->join('operators', 'upgrad_room.operator_id = operators.id','left');
			$this->db->join('upgrad_reasons', 'upgrad_room.reason_id = upgrad_reasons.id','left');
			$this->db->join('room_types', 'upgrad_room.booked_type_id = room_types.id','left');
			$this->db->join('rooms_types', 'upgrad_room.new_type_id = rooms_types.id','left');
			$this->db->where('upgrad_room.up_id', $up_id);
			$query = $this->db->get('upgrad_room');
			return ($query->num_rows() > 0 )? $query->result_array() : FALSE;
		}

		function get_by_room($room, $hotel_id){
			if ($hotel_id  == 3){
				$server = "172.50.10.230";
			}elseif ($hotel_id  == 2){
				$server = "172.50.10.231";
			}elseif ($hotel_id  == 1){
				$server = "172.50.10.232";
			}elseif ($hotel_id  == 6){
				$server = "192.168.1.230";
			}elseif ($hotel_id  == 4){
				$server = "196.168.2.18";
			}elseif ($hotel_id  == 8){
				$server = "192.168.236.230";
			}elseif ($hotel_id  == 11){
				$server = "10.15.15.18";
			}elseif ($hotel_id  == 10){
				$server = "192.168.50.18";
			}elseif ($hotel_id  == 12){
				$server = "10.15.15.20";
			}elseif ($hotel_id  == 5){
				$server = "10.20.20.18";
			}elseif ($hotel_id  == 7){
				$server = "192.168.210.230";
			}elseif ($hotel_id  == 42){
				$server = "172.50.200.10";
			}
            $dbuser = "v8live";
            $dbpass = "live";
            $dbs = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = ".$server.")(PORT = 1521)))(CONNECT_DATA=(SID=v8)))";
            $connect = oci_connect ($dbuser, $dbpass, $dbs,'UTF8',OCI_DEFAULT );
            $sql = "SELECT ACT_V8_REP_YRES_INFOS.GUEST_NAME,ACT_V8_REP_YRES_INFOS.YRMS_SHORTDESC, ACT_V8_REP_YRES_INFOS.YRES_ACTARRTIME, ACT_V8_REP_YRES_INFOS.YRES_EXPDEPTIME, ACT_V8_REP_YRES_INFOS.XCOU_LONGDESC FROM ACT_V8_REP_YRES_INFOS WHERE CHECKED_IN ='1' AND CHECKED_OUT = '0' AND YRMS_SHORTDESC=".$room;
            $querys = oci_parse($connect,$sql);
            oci_execute($querys);
            while (false !== ($row = oci_fetch_assoc($querys))) {
            	$output_array[] = array('room' => $row['YRMS_SHORTDESC'], 'arriv' => $row['YRES_ACTARRTIME'], 'depart' => $row['YRES_EXPDEPTIME'], 'nation' => $row['XCOU_LONGDESC'], 'guest' => $row['GUEST_NAME']);
            }
            oci_free_statement($querys);
            oci_close($connect);
            return $output_array;
    	}

    	function getall_operator(){
	    	$this->load->database();
			$this->db->select('operators.*');
        	$this->db->order_by('name');
			$query = $this->db->get('operators');
			return $query->result_array();
  		}

  		function getall_reason(){
	    	$this->load->database();
			$this->db->select('upgrad_reasons.*');
        	$this->db->order_by('name');
			$query = $this->db->get('upgrad_reasons');
			return $query->result_array();
  		}

  		function getall_room_type(){
	    	$this->load->database();
			$this->db->select('room_types.*');
        	$this->db->order_by('name');
			$query = $this->db->get('room_types');
			return $query->result_array();
  		}

  		function getall_rooms_type(){
	    	$this->load->database();
	    	$this->db->select('rooms_types.*');
        	$this->db->order_by('name');
			$query = $this->db->get('rooms_types');
			return $query->result_array();
  		}

    	function get_by_fille($up_id){
	    	$this->load->database();
			$this->db->select('upgrad_filles.*, users.fullname as user_name');
			$this->db->join('users', 'upgrad_filles.user_id = users.id','left');
			$this->db->where('up_id', $up_id);
			$query = $this->db->get('upgrad_filles');
			return $query->result_array();
  		}

  		function update_files($assumed_id, $up_id) {
  			$this->load->database();
  			$this->db->query('UPDATE upgrad_filles SET up_id = "'.$up_id.'" WHERE up_id = "'.$assumed_id.'"');
  		}

  		function update_state($up_id, $state) {
			$this->db->update('upgrad', array('state_id'=> $state), "id = ".$up_id);
		}

		function get_by_verbal($up_id){
	    	$this->load->database();
			$this->db->select('upgrad_signature.*, roles.role, departments.name as department, users.fullname as user_name');
			$this->db->join('roles', 'upgrad_signature.role_id = roles.id', 'left');
			$this->db->join('departments', 'upgrad_signature.department_id = departments.id', 'left');
			$this->db->join('users', 'upgrad_signature.user_id = users.id', 'left');
			$this->db->where('up_id', $up_id);
        	$this->db->order_by('rank');
			$query = $this->db->get('upgrad_signature');
			return $query->result_array();
  		}

  		function add_fille($up_id, $name, $user_id) {
	  		$this->load->database();
	  		$this->db->query('INSERT INTO upgrad_filles(up_id, name, user_id) VALUES("'.$up_id.'","'.$name.'","'.$user_id.'")');
	  	}

	  	function remove_fille($id) {
	      $this->load->database();
	      $this->db->query('DELETE FROM upgrad_filles WHERE id = '.$id);
	    }

	    function get_comment($up_id){
			$query = $this->db->query("
				SELECT users.fullname, upgrad_comments.comment, upgrad_comments.created FROM upgrad_comments
				JOIN users on upgrad_comments.user_id = users.id
				WHERE upgrad_comments.up_id =".$up_id
			);
			return $query->result_array();
  		}

  		function update_upgrad($data, $up_id) {
			$this->load->database();
			$this->db->where('upgrad.id', $up_id);		
			$this->db->update('upgrad', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function get_signature_identity($sign_id){
  			$this->load->database();
			$query = $this->db->query('SELECT upgrad.hotel_id, upgrad_signature.up_id FROM upgrad_signature JOIN upgrad ON upgrad_signature.up_id = upgrad.id WHERE upgrad_signature.id ='.$sign_id);
  			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  		}

  		function unsign($id){
	  		$this->load->database();
			$query = $this->db->query('UPDATE upgrad_signature SET user_id = NULL, reject = 0 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
	  	}

  		function reject($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE upgrad_signature SET user_id = '.$uid.', reject = 1 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function sign($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE upgrad_signature SET user_id = '.$uid.' WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function insert_comment($data){
			$this->db->insert('upgrad_comments', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

	}

?>
