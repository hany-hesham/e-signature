<?php

	class bd_use_model extends CI_Model{

  		function __contruct(){
			parent::__construct;
		}

		function use_do_sign($use_id){
  	 		$this->load->database();
			$this->db->select('bd_use_signature.*');
			$this->db->where('bd_use_signature.use_id', $use_id);		
			$query = $this->db->get('bd_use_signature');
			return $query->num_rows();  	
		}

		function view($user_hotels = FALSE) {
  	  		$this->load->database();
			$this->db->select('bd_use.id, bd_use.hotel_id, bd_use.type_id, bd_use.timestamp, bd_use.state_id, hotels.name as hotel_name , bd_use_types.name as type_name');
			$this->db->join('hotels', 'bd_use.hotel_id = hotels.id','left');
			$this->db->join('bd_use_types', 'bd_use.type_id = bd_use_types.id','left');
        	if ($user_hotels) {
          		$this->db->where_in('bd_use.hotel_id', $user_hotels);
        	}
			$this->db->where('bd_use.state_id !=', 0);		
        	$this->db->order_by('timestamp', 'DESC');
			$query = $this->db->get('bd_use');
			return $query->result_array();
		}

		function getby_verbals($use_id){
	    	$this->load->database();
			$this->db->select('bd_use_signature.role_id, bd_use_signature.department_id, bd_use_signature.rank, bd_use_signature.user_id, bd_use_signature.reject, roles.role, departments.name as department, users.fullname as user_name');
			$this->db->join('roles', 'bd_use_signature.role_id = roles.id', 'left');
			$this->db->join('departments', 'bd_use_signature.department_id = departments.id', 'left');
			$this->db->join('users', 'bd_use_signature.user_id = users.id', 'left');
			$this->db->where('use_id', $use_id);
			$this->db->order_by('rank');
			$query = $this->db->get('bd_use_signature');
			return $query->result_array();
  		}

  		function get_itemss($use_id) {
			$this->db->select('bd_use_element.id,bd_use_element.guest, bd_use_element.use_id, bd_use_element.room, bd_use_element.date, bd_use.hotel_id');
			$this->db->join('bd_use', 'bd_use_element.use_id = bd_use.id','left');
			$this->db->where('bd_use_element.use_id', $use_id);
			$query = $this->db->get('bd_use_element');
			return ($query->num_rows() > 0 )? $query->result_array() : FALSE;
		}

		

		function view_app($user_hotels = FALSE) {
  	  		$this->load->database();
			$this->db->select('bd_use.id, bd_use.hotel_id, bd_use.type_id, bd_use.timestamp, bd_use.state_id, hotels.name as hotel_name , bd_use_types.name as type_name');
			$this->db->join('hotels', 'bd_use.hotel_id = hotels.id','left');
			$this->db->join('bd_use_types', 'bd_use.type_id = bd_use_types.id','left');
        	if ($user_hotels) {
          		$this->db->where_in('bd_use.hotel_id', $user_hotels);
        	}
			$this->db->where('bd_use.state_id', 2);		
        	$this->db->order_by('timestamp', 'DESC');
			$query = $this->db->get('bd_use');
			return $query->result_array();
		}

		function view_rej($user_hotels = FALSE) {
  	  		$this->load->database();
			$this->db->select('bd_use.id, bd_use.hotel_id, bd_use.type_id, bd_use.timestamp, bd_use.state_id, hotels.name as hotel_name , bd_use_types.name as type_name');
			$this->db->join('hotels', 'bd_use.hotel_id = hotels.id','left');
			$this->db->join('bd_use_types', 'bd_use.type_id = bd_use_types.id','left');
        	if ($user_hotels) {
          		$this->db->where_in('bd_use.hotel_id', $user_hotels);
        	}
			$this->db->where('bd_use.state_id', 3);		
        	$this->db->order_by('timestamp', 'DESC');
			$query = $this->db->get('bd_use');
			return $query->result_array();
		}

		function view_wat($user_hotels = FALSE, $state) {
  	  		$this->load->database();
			$this->db->select('bd_use.id, bd_use.hotel_id, bd_use.type_id, bd_use.timestamp, bd_use.state_id, hotels.name as hotel_name , bd_use_types.name as type_name');
			$this->db->join('hotels', 'bd_use.hotel_id = hotels.id','left');
			$this->db->join('bd_use_types', 'bd_use.type_id = bd_use_types.id','left');
        	if ($user_hotels) {
          		$this->db->where_in('bd_use.hotel_id', $user_hotels);
        	}
			$this->db->where('bd_use.state_id', $state);		
        	$this->db->order_by('timestamp', 'DESC');
			$query = $this->db->get('bd_use');
			return $query->result_array();
		}

		function create_use($data) {
			$this->load->database();
			$this->db->insert('bd_use', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function create_room($data) {
			$this->db->insert('bd_use_element', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function get_types(){
	    	$this->load->database();
			$this->db->select('bd_use_types.*');
        	$this->db->order_by('name');
			$query = $this->db->get('bd_use_types');
			return $query->result_array();
  		}

		function update_room($data, $use_id, $room_id) {
			$this->load->database();
			$this->db->where('bd_use_element.use_id', $use_id);	
			$this->db->where('bd_use_element.id', $room_id);		
			$this->db->update('bd_use_element', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

  		function use_sign(){
  	 		$this->load->database();
			$this->db->select('bd_use_role.*');
			$query = $this->db->get('bd_use_role');
			return $query->result_array();  	
		}

		function add_signature($use_id, $role_id, $department_id, $rank){
	    	$this->load->database();
			$query = $this->db->query('INSERT INTO bd_use_signature(use_id, role_id, department_id, rank) VALUES("'.$use_id.'", "'.$role_id.'", "'.$department_id.'", "'.$rank.'")');
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
  		}

  		function get_use($use_id) {
			$this->db->select('bd_use.*, hotels.name as hotel_name, hotels.logo As logo, users.fullname as name, bd_use_types.name as type_name');
			$this->db->join('hotels', 'bd_use.hotel_id = hotels.id','left');
			$this->db->join('users', 'bd_use.user_id = users.id','left');
			$this->db->join('bd_use_types', 'bd_use.type_id = bd_use_types.id','left');
			$this->db->where('bd_use.id', $use_id);		
			$query = $this->db->get('bd_use');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
		}

		function get_items($use_id) {
			$this->db->select('bd_use_element.*, bd_use.hotel_id, operators.name as operator_name');
			$this->db->join('bd_use', 'bd_use_element.use_id = bd_use.id','left');
			$this->db->join('operators', 'bd_use_element.operator_id = operators.id','left');
			$this->db->where('bd_use_element.use_id', $use_id);
			$query = $this->db->get('bd_use_element');
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

  		function get_operators(){
	    	$this->load->database();
			$this->db->select('operators.*');
        	$this->db->order_by('name');
			$query = $this->db->get('operators');
			return $query->result_array();
  		}

    	function getby_fille($use_id){
	    	$this->load->database();
			$this->db->select('bd_use_filles.*, users.fullname as user_name');
			$this->db->join('users', 'bd_use_filles.user_id = users.id','left');
			$this->db->where('use_id', $use_id);
			$query = $this->db->get('bd_use_filles');
			return $query->result_array();
  		}

  		function add($use_id, $name, $user_id) {
	  		$this->load->database();
	  		$this->db->query('INSERT INTO bd_use_filles(use_id, name, user_id) VALUES("'.$use_id.'","'.$name.'","'.$user_id.'")');
	  	}

	  	function remove($id) {
	      $this->load->database();
	      $this->db->query('DELETE FROM bd_use_filles WHERE id = '.$id);
	    }

		function update_state($use_id, $state) {
			$this->db->update('bd_use', array('state_id'=> $state), "id = ".$use_id);
		}

		function getby_verbal($use_id){
	    	$this->load->database();
			$this->db->select('bd_use_signature.id, bd_use_signature.role_id, bd_use_signature.department_id, bd_use_signature.rank, bd_use_signature.user_id, bd_use_signature.reject, bd_use_signature.timestamp, roles.role, departments.name as department');
			$this->db->join('roles', 'bd_use_signature.role_id = roles.id', 'left');
			$this->db->join('departments', 'bd_use_signature.department_id = departments.id', 'left');
			$this->db->where('use_id', $use_id);
        	$this->db->order_by('rank');
			$query = $this->db->get('bd_use_signature');
			return $query->result_array();
  		}

		function get_comment($use_id){
			$query = $this->db->query("
				SELECT users.fullname, bd_use_comments.comment, bd_use_comments.created FROM bd_use_comments
				JOIN users on bd_use_comments.user_id = users.id
				WHERE bd_use_comments.use_id =".$use_id);
			return $query->result_array();
  		}

  		function update_use($use_id, $data) {
			$this->load->database();
			$this->db->where('bd_use.id', $use_id);	
			$this->db->update('bd_use', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

  		function get_signature_identity($sign_id){
  			$this->load->database();
			$query = $this->db->query('SELECT bd_use.hotel_id, bd_use_signature.use_id FROM bd_use_signature JOIN bd_use ON bd_use_signature.use_id = bd_use.id WHERE bd_use_signature.id ='.$sign_id);
  			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  		}

  		function unsign($id){
	  		$this->load->database();
			$query = $this->db->query('UPDATE bd_use_signature SET user_id = NULL, reject = 0 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
	  	}

	  	function reject($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE bd_use_signature SET user_id = '.$uid.', reject = 1 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

	  	function sign($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE bd_use_signature SET user_id = '.$uid.' WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function insert_comment($data){
			$this->db->insert('bd_use_comments', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

	}

?>