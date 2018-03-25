<?php
	class fb_model extends CI_Model{

  		function __contruct(){
			parent::__construct;
		}

		function view($user_hotels = FALSE) {
  	  		$this->load->database();
  	  		$this->db->select('fb_order.id, fb_order.hotel_id, fb_order.ret_id, fb_order.timestamp, fb_order.state_id, hotels.name as hotel_name , fb_types.name as ret_name');
			$this->db->join('hotels', 'fb_order.hotel_id = hotels.id','left');
			$this->db->join('fb_types', 'fb_order.ret_id = fb_types.id','left');
        	if ($user_hotels) {
          		$this->db->where_in('fb_order.hotel_id', $user_hotels);
        	}
			$this->db->where('fb_order.state_id !=', 0);		
			$this->db->where('fb_order.ret_id !=', 6);	
        	$this->db->order_by('timestamp', 'DESC');
			$query = $this->db->get('fb_order');
			return $query->result_array();
		}

		function getby_verbals($fb_id){
	    	$this->load->database();
			$this->db->select('fb_signature.role_id, fb_signature.department_id, fb_signature.user_id, fb_signature.reject, roles.role, departments.name as department, users.fullname as user_name');
			$this->db->select('fb_signature.*, roles.role, departments.name as department');
			$this->db->join('roles', 'fb_signature.role_id = roles.id', 'left');
			$this->db->join('departments', 'fb_signature.department_id = departments.id', 'left');
			$this->db->join('users', 'fb_signature.user_id = users.id', 'left');
			$this->db->where('fb_id', $fb_id);
			$this->db->order_by('rank');
			$query = $this->db->get('fb_signature');
			return $query->result_array();
  		}

  		function get_itemss($fb_id) {
			$this->db->select('fb_element.id,fb_element.room, fb_element.fb_id, fb_element.pax, fb_element.guest, fb_order.hotel_id');
			$this->db->join('fb_order', 'fb_element.fb_id = fb_order.id','left');
			$this->db->where('fb_element.fb_id', $fb_id);
			$query = $this->db->get('fb_element');
			return ($query->num_rows() > 0 )? $query->result_array() : FALSE;
		}

		function getall_types(){
	    	$this->load->database();
			$this->db->select('fb_types.*');
        	$this->db->order_by('name');
			$query = $this->db->get('fb_types');
			return $query->result_array();
  		}

  		function view_app($user_hotels = FALSE) {
  	  		$this->load->database();
  	  		$this->db->select('fb_order.id, fb_order.hotel_id, fb_order.ret_id, fb_order.timestamp, fb_order.state_id, hotels.name as hotel_name , fb_types.name as ret_name');
			$this->db->join('hotels', 'fb_order.hotel_id = hotels.id','left');
			$this->db->join('fb_types', 'fb_order.ret_id = fb_types.id','left');
        	if ($user_hotels) {
          		$this->db->where_in('fb_order.hotel_id', $user_hotels);
        	}
			$this->db->where('fb_order.state_id', 2);		
        	$this->db->order_by('timestamp', 'DESC');
			$query = $this->db->get('fb_order');
			return $query->result_array();
		}

		function view_rej($user_hotels = FALSE) {
  	  		$this->load->database();
  	  		$this->db->select('fb_order.id, fb_order.hotel_id, fb_order.ret_id, fb_order.timestamp, fb_order.state_id, hotels.name as hotel_name , fb_types.name as ret_name');
			$this->db->join('hotels', 'fb_order.hotel_id = hotels.id','left');
			$this->db->join('fb_types', 'fb_order.ret_id = fb_types.id','left');
        	if ($user_hotels) {
          		$this->db->where_in('fb_order.hotel_id', $user_hotels);
        	}
			$this->db->where('fb_order.state_id', 3);		
        	$this->db->order_by('timestamp', 'DESC');
			$query = $this->db->get('fb_order');
			return $query->result_array();
		}

		function view_wat($user_hotels = FALSE, $state) {
  	  		$this->load->database();
  	  		$this->db->select('fb_order.id, fb_order.hotel_id, fb_order.ret_id, fb_order.timestamp, fb_order.state_id, hotels.name as hotel_name , fb_types.name as ret_name');
			$this->db->join('hotels', 'fb_order.hotel_id = hotels.id','left');
			$this->db->join('fb_types', 'fb_order.ret_id = fb_types.id','left');
        	if ($user_hotels) {
          		$this->db->where_in('fb_order.hotel_id', $user_hotels);
        	}
			$this->db->where('fb_order.state_id', $state);		
        	$this->db->order_by('timestamp', 'DESC');
			$query = $this->db->get('fb_order');
			return $query->result_array();
		}

		function view_dev($user_hotels = FALSE) {
  	  		$this->load->database();
  	  		$this->db->select('fb_order.id, fb_order.hotel_id, fb_order.ret_id, fb_order.timestamp, fb_order.state_id, hotels.name as hotel_name , fb_types.name as ret_name');
			$this->db->join('hotels', 'fb_order.hotel_id = hotels.id','left');
			$this->db->join('fb_types', 'fb_order.ret_id = fb_types.id','left');
        	if ($user_hotels) {
          		$this->db->where_in('fb_order.hotel_id', $user_hotels);
        	}
			$this->db->where('fb_order.ret_id', 6);	
        	$this->db->order_by('timestamp', 'DESC');
			$query = $this->db->get('fb_order');
			return $query->result_array();
		}

		function create_fb($data) {
			$this->load->database();
			$this->db->insert('fb_order', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function create_room($data) {
			$this->db->insert('fb_element', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function update_order($data, $fb_id) {
			$this->load->database();
			$this->db->where('fb_order.id', $fb_id);		
			$this->db->update('fb_order', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function update_fb($data, $fb_id, $room_id) {
			$this->load->database();
			$this->db->where('fb_element.fb_id', $fb_id);	
			$this->db->where('fb_element.id', $room_id);		
			$this->db->update('fb_element', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function fb_sign(){
  	 		$this->load->database();
			$this->db->select('fb_role.*');
			$query = $this->db->get('fb_role');
			return $query->result_array();  	
		}

		function fb_do_sign($fb_id){
  	 		$this->load->database();
			$this->db->select('fb_signature.*');
			$this->db->where('fb_signature.fb_id', $fb_id);		
			$query = $this->db->get('fb_signature');
			return $query->num_rows();  	
		}

		function add_signature($fb_id, $role_id, $department_id, $rank){
	    	$this->load->database();
			$query = $this->db->query('INSERT INTO fb_signature(fb_id, role_id, department_id, rank) VALUES("'.$fb_id.'", "'.$role_id.'", "'.$department_id.'", "'.$rank.'")');
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
  		}

  		function get_fb($fb_id) {
			$this->db->select('fb_order.*, hotels.name as hotel_name, hotels.logo As logo, users.fullname as name');
			$this->db->join('hotels', 'fb_order.hotel_id = hotels.id','left');
			$this->db->join('users', 'fb_order.user_id = users.id','left');
			$this->db->where('fb_order.id', $fb_id);		
			$query = $this->db->get('fb_order');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
		}

		function get_items($fb_id) {
			$this->db->select('fb_element.*, fb_order.hotel_id');
			$this->db->join('fb_order', 'fb_element.fb_id = fb_order.id','left');
			$this->db->where('fb_element.fb_id', $fb_id);
			$query = $this->db->get('fb_element');
			return ($query->num_rows() > 0 )? $query->result_array() : FALSE;
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

    	function getby_fille($fb_id){
	    	$this->load->database();
			$this->db->where('fb_id', $fb_id);
			$query = $this->db->get('fb_filles');
			return $query->result_array();
  		}
  		
  		function add($fb_id, $name) {
	  		$this->load->database();
	  		$this->db->query('INSERT INTO fb_filles(fb_id,name) VALUES("'.$fb_id.'","'.$name.'")');
	  	}

	  	function remove($id) {
	      $this->load->database();
	      $this->db->query('DELETE FROM fb_filles WHERE id = '.$id);
	    }

		function update_files($assumed_id, $fb_id) {
  			$this->load->database();
  			$this->db->query('UPDATE fb_filles SET fb_id = "'.$fb_id.'" WHERE fb_id = "'.$assumed_id.'"');
  		}

		function update_state($fb_id, $state) {
			$this->db->update('fb_order', array('state_id'=> $state), "id = ".$fb_id);
		}

		function getby_verbal($fb_id){
	    	$this->load->database();
			$this->db->select('fb_signature.*, roles.role, departments.name as department');
			$this->db->join('roles', 'fb_signature.role_id = roles.id', 'left');
			$this->db->join('departments', 'fb_signature.department_id = departments.id', 'left');
			$this->db->where('fb_id', $fb_id);
			$this->db->order_by('rank');
			$query = $this->db->get('fb_signature');
			return $query->result_array();
  		}

    	function GetComment($fb_id){
			$query = $this->db->query("
				SELECT users.fullname, fb_comments.comment, fb_comments.created	FROM fb_comments
				JOIN users on fb_comments.user_id = users.id
				WHERE fb_comments.fb_id =".$fb_id);
			return $query->result_array();
  		}

  		
    	
		function getall(){
	    	$this->load->database();
			$this->db->select('users.id as userid,users.*,fb_order.*, fb_element.*, hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('fb_order', 'fb_element.fb_id = fb_order.id','left');
			$this->db->join('users', 'fb_order.user_id = users.id','left');
			$this->db->join('hotels', 'fb_order.hotel_id = hotels.id','left');
			$query = $this->db->get('fb_element');
			return $query->result_array();
  		}

  		function get_signature_identity($sign_id){
  			$this->load->database();
			$query = $this->db->query('SELECT fb_order.hotel_id, fb_signature.fb_id FROM fb_signature JOIN fb_order ON fb_signature.fb_id = fb_order.id WHERE fb_signature.id ='.$sign_id);
  			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  		}

  		function unsign($id){
	  		$this->load->database();
			$query = $this->db->query('UPDATE fb_signature SET user_id = NULL, reject = 0 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
	  	}

	  	function reject($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE fb_signature SET user_id = '.$uid.', reject = 1 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

	  	function sign($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE fb_signature SET user_id = '.$uid.' WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function InsertComment($data){
			$this->db->insert('fb_comments', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}
		
	}

?>