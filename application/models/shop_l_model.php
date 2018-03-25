<?php

class shop_l_model extends CI_Model{

  	function __contruct(){
			parent::__construct;
		}

	function create_shop_license($data) {
			$this->db->insert('shop_license', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		   }
	function create_item($data) {
			$this->db->insert('shop_license_items', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}  
	function update_files($assumed_id, $shop_lid) {
  			$this->load->database();
  			$this->db->query('UPDATE shop_license_filles SET shop_lid = "'.$shop_lid.'" WHERE shop_lid = "'.$assumed_id.'"');
  		} 
    function shop_license_sign (){
			$this->db->select('shop_license_role.*');
			$query = $this->db->get('shop_license_role');
			return $query->result_array();  	
		}
    function shop_license_do_sign($shop_lid){
			$this->db->select('shop_license_signature.*');
			$this->db->where('shop_license_signature.shop_lid', $shop_lid);		
			$query = $this->db->get('shop_license_signature');
			return $query->num_rows();  	
		}
	function add_signature($shop_lid, $role_id, $department_id,  $rank){
	    	$this->load->database();
			$query = $this->db->query('INSERT INTO shop_license_signature(shop_lid, role_id, department_id, rank) VALUES("'.$shop_lid.'", "'.$role_id.'", "'.$department_id.'", "'.$rank.'")');
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
  		}	
  	function get_by_fille($shop_lid){
			$this->db->select('shop_license_filles.*, users.fullname as user_name');
			$this->db->join('users', 'shop_license_filles.user_id = users.id','left');
			$this->db->where('shop_lid', $shop_lid);
			$query = $this->db->get('shop_license_filles');
			return $query->result_array();
  		}	
  	function add_fille($shop_lid, $name, $user_id) {
	  		$this->load->database();
	  		$this->db->query('INSERT INTO shop_license_filles(shop_lid, name, user_id) VALUES("'.$shop_lid.'","'.$name.'","'.$user_id.'")');
	  	}

	function remove_fille($id) {
	      $this->load->database();
	      $this->db->query('DELETE FROM shop_license_filles WHERE id = '.$id);
	    }	

	function get_shop_license_by_id($shop_lid) {
			$this->db->select('shop_license.*, hotels.name as hotel_name, hotels.logo As logo, users.fullname as name');
			$this->db->join('hotels', 'shop_license.hotel_id = hotels.id','left');
			$this->db->join('users', 'shop_license.user_id = users.id','left');
			$this->db->where('shop_license.id', $shop_lid);		
			$query = $this->db->get('shop_license');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
		}
	function update_state($shop_lid, $state) {
			$this->db->update('shop_license', array('state_id'=> $state), "id = ".$shop_lid);
		}	

	function get_items($shop_lid) {
			$this->db->select('shop_license_items.*, users.fullname as user_name');
			$this->db->join('users', 'shop_license_items.user_id = users.id','left');
			$this->db->where('shop_license_items.shop_lid', $shop_lid);
			$query = $this->db->get('shop_license_items');
			return ($query->num_rows() > 0 )? $query->result_array() : FALSE;
		}
	function get_comment($shop_lid){
			$query = $this->db->query("
				SELECT users.fullname, shop_license_comments.comment, shop_license_comments.timestamp FROM shop_license_comments
				JOIN users on shop_license_comments.user_id = users.id
				WHERE shop_license_comments.shop_lid =".$shop_lid
			);
			return $query->result_array();
  		}
  	function get_by_verbal($shop_lid){
			$this->db->select('shop_license_signature.*, roles.role, departments.name as department, users.fullname as user_name');
			$this->db->join('roles', 'shop_license_signature.role_id = roles.id', 'left');
			$this->db->join('departments', 'shop_license_signature.department_id = departments.id', 'left');
			$this->db->join('users', 'shop_license_signature.user_id = users.id', 'left');
        	$this->db->order_by('rank');
			$this->db->where('shop_lid', $shop_lid);
			$query = $this->db->get('shop_license_signature');
			return $query->result_array();
  		}	
  	function get_signature_identity($sign_id){
  			$this->load->database();
			$query = $this->db->query('SELECT shop_license.hotel_id, shop_license_signature.shop_lid FROM shop_license_signature JOIN shop_license ON shop_license_signature.shop_lid = shop_license.id WHERE shop_license_signature.id ='.$sign_id);
  			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  		}
  	function unsign($id){
			$query = $this->db->query('UPDATE shop_license_signature SET user_id = NULL, reject = 0 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
	  	}

	function reject($id, $uid){
			$query = $this->db->query('UPDATE shop_license_signature SET user_id = '.$uid.', reject = 1 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  	function sign($id, $uid){
			$query = $this->db->query('UPDATE shop_license_signature SET user_id = '.$uid.' WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

	function update_shop_license($shop_lid, $data) {
			$this->db->where('shop_license.id', $shop_lid);		
			$this->db->update('shop_license', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

	function update_item($id, $shop_lid, $data) {
			$this->db->where('shop_license_items.shop_lid', $shop_lid);	
			$this->db->where('shop_license_items.id', $id);		
			$this->db->update('shop_license_items', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}	
	function insert_comment($data){
			$this->db->insert('shop_license_comments', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}	
	
	function view($user_hotels = FALSE, $state = FALSE) {
  	  		$this->load->database();
			$this->db->select('shop_license.id, shop_license.user_id, shop_license.hotel_id,shop_license.state_id, shop_license.timestamp, hotels.name as hotel_name, users.fullname as name');
			$this->db->join('hotels', 'shop_license.hotel_id = hotels.id','left');
			$this->db->join('users', 'shop_license.user_id = users.id','left');
        	if ($user_hotels) {
          		$this->db->where_in('shop_license.hotel_id', $user_hotels);
        	}
        	if ($state && $state > 0) {
				$this->db->where('shop_license.state_id', $state);	
			}else{
				$this->db->where('shop_license.state_id !=', 0);
			}
        	$this->db->order_by('timestamp', 'DESC');
			$query = $this->db->get('shop_license');
			return $query->result_array();
		}	

	function get_by_verbals($shop_lid){
			$this->db->select('shop_license_signature.role_id, shop_license_signature.rank, shop_license_signature.department_id, shop_license_signature.user_id, shop_license_signature.reject, roles.role, users.fullname as user_name');
			$this->db->join('roles', 'shop_license_signature.role_id = roles.id', 'left');
			$this->db->join('users', 'shop_license_signature.user_id = users.id', 'left');
			$this->db->where('shop_lid', $shop_lid);
        	$this->db->order_by('shop_license_signature.rank');
			$query = $this->db->get('shop_license_signature');
			return $query->result_array();
  		}			
    

	}