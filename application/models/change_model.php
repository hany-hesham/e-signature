<?php
	class change_model extends CI_Model{

  		function __contruct(){
			parent::__construct;
		}

		function getall(){
	    	$this->load->database();
			$this->db->select('users.id as userid,users.*,chang.*,hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('users', 'chang.user_id = users.id','left');
			$this->db->join('hotels', 'chang.hotel_id = hotels.id','left');
			$query = $this->db->get('chang');
			return $query->result_array();
  		}

		function create_change($data) {
			$this->load->database();
			$this->db->insert('chang', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function update_change($data, $ch_id) {
			$this->load->database();
			$this->db->where('chang.id', $ch_id);		
			$this->db->update('chang', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function ch_do_sign($ch_id){
  	 		$this->load->database();
			$this->db->select('change_signature.*');
			$this->db->where('change_signature.ch_id', $ch_id);		
			$query = $this->db->get('change_signature');
			return $query->num_rows();  	
		}

		function add_signature($ch_id, $role_id, $department_id, $rank){
	    	$this->load->database();
			$query = $this->db->query('INSERT INTO change_signature(ch_id, role_id, department_id, rank) VALUES("'.$ch_id.'", "'.$role_id.'", "'.$department_id.'", "'.$rank.'")');
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
  		}

  		function get_change($ch_id) {
			$this->db->select('chang.*, hotels.name as hotel_name, hotels.logo As logo, users.fullname as name');
			$this->db->join('hotels', 'chang.hotel_id = hotels.id','left');
			$this->db->join('users', 'chang.user_id = users.id','left');
			$this->db->where('chang.id', $ch_id);		
			$query = $this->db->get('chang');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
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
			}else{
				$server = "192.168.1.230";
			}
            $dbuser = "v8live";
            $dbpass = "live";
            $dbs = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = ".$server.")(PORT = 1521)))(CONNECT_DATA=(SID=v8)))";
            $connect = oci_connect ($dbuser, $dbpass, $dbs,'UTF8',OCI_DEFAULT );
            $sql = "SELECT ACT_V8_REP_YRES_INFOS.GUEST_NAME,ACT_V8_REP_YRES_INFOS.YRMS_SHORTDESC FROM ACT_V8_REP_YRES_INFOS WHERE CHECKED_IN ='1' AND CHECKED_OUT = '0' AND YRMS_SHORTDESC=".$rn;
            $querys = oci_parse($connect,$sql);
            oci_execute($querys);
            // $num_rows = oci_fetch_assoc($querys);
            while (false !== ($row = oci_fetch_assoc($querys))) {
            $output_array[] = array('room' => $row['YRMS_SHORTDESC'], 'guest_name' => $row['GUEST_NAME']);
            }
            // die(print_r($output_array));
            oci_free_statement($querys);
            oci_close($connect);
            return $output_array;
    	}

    	function self_sign($ch_id, $user_id){
	    	$this->load->database();
			$query = $this->db->query('UPDATE change_signature SET user_id = '.$user_id.' WHERE ch_id = '.$ch_id.' AND role_id = 0');
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function update_state($ch_id, $state) {
			$this->db->update('chang', array('state_id'=> $state), "id = ".$ch_id);
		}

		function getby_verbal($ch_id){
	    	$this->load->database();
			$this->db->select('change_signature.*, roles.role, departments.name as department');
			$this->db->join('roles', 'change_signature.role_id = roles.id', 'left');
			$this->db->join('departments', 'change_signature.department_id = departments.id', 'left');
			$this->db->where('ch_id', $ch_id);
			$this->db->order_by('rank');
			$query = $this->db->get('change_signature');
			return $query->result_array();
  		}

  		function getcomment($ch_id){
			$query = $this->db->query("
				SELECT users.fullname, change_comments.comment, change_comments.created	FROM change_comments
				JOIN users on change_comments.user_id = users.id
				WHERE change_comments.ch_id =".$ch_id);
			return $query->result_array();
  		}

  		function view($user_hotels = FALSE) {
  	  		$this->load->database();
			$this->db->select('users.id as userid,users.*,chang.*,hotels.name as hotel_name,hotels.logo As logo');
			$this->db->join('users', 'chang.user_id = users.id','left');
			$this->db->join('hotels', 'chang.hotel_id = hotels.id','left');
        	if ($user_hotels) {
          		$this->db->where_in('chang.hotel_id', $user_hotels);
        	}
        	$this->db->order_by('date', 'DESC');
			$query = $this->db->get('chang');
			return $query->result_array();
		}

		function get_signature_identity($sign_id){
  			$this->load->database();
			$query = $this->db->query('SELECT chang.hotel_id, change_signature.ch_id FROM change_signature JOIN chang ON change_signature.ch_id = chang.id WHERE change_signature.id ='.$sign_id);
  			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  		}

  		function reject($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE change_signature SET user_id = '.$uid.', reject = 1 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function sign($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE change_signature SET user_id = '.$uid.' WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  		function unsign($id){
	  		$this->load->database();
			$query = $this->db->query('UPDATE change_signature SET user_id = NULL, reject = 0 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
	  	}

	  	function insertcomment($data){
			$this->db->insert('change_comments', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function disapprove($id, $uid){
	  		$this->load->database();
			$query = $this->db->query('UPDATE change_signature SET user_id = '.$uid.', reject = 1 WHERE id = '.$id);
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

  		function approve($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE change_signature SET user_id = '.$uid.' WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
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

  		function change_sign(){
  	 		$this->load->database();
			 $this->db->select('change_role.*');
			 $query = $this->db->get('change_role');
			 return $query->result_array();  	
		}
  	}