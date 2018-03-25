<?php

	class shop_adjust_model extends CI_Model{

  	function __contruct(){
			parent::__construct;
	   }
	function create_shop_adjust($data) {
			$this->load->database();
			$this->db->insert('shop_adjustment', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}   
	function update_files($assumed_id, $adjust_id) {
  			$this->load->database();
  			$this->db->query('UPDATE shop_adjustment_filles SET shop_adjustment_id = "'.$adjust_id.'" WHERE shop_adjustment_id = "'.$assumed_id.'"');
  		}	
  	function shop_adjust_sign(){
  			$this->load->database();
			$this->db->select('shop_adjustment_role.*');
			$query = $this->db->get('shop_adjustment_role');
			return $query->result_array();  	
		}
	function shop_adjust_do_sign($adjust_id){
  	 		$this->load->database();
			$this->db->select('shop_adjustment_signature.*');
			$this->db->where('shop_adjustment_signature.shop_adjustment_id', $adjust_id);		
			$query = $this->db->get('shop_adjustment_signature');
			return $query->num_rows();  	
		}
	function add_signature($adjust_id,$shop_id, $role_id, $department_id,  $rank){
	    	$this->load->database();
			$query = $this->db->query('INSERT INTO shop_adjustment_signature(shop_adjustment_id,shop_id, role_id, department_id, rank) 
				VALUES("'.$adjust_id.'","'.$shop_id.'", "'.$role_id.'", "'.$department_id.'", "'.$rank.'")');
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
  		}	
  	function getby_fille($adjust_id){
	    	$this->load->database();
			$this->db->select('shop_adjustment_filles.*, users.fullname as user_name');
			$this->db->join('users', 'shop_adjustment_filles.user_id = users.id','left');
			$this->db->where('shop_adjustment_id', $adjust_id);
			$query = $this->db->get('shop_adjustment_filles');
			return $query->result_array();
  		}	
  	function add_fille($adjust_id, $name, $user_id) {
	  		$this->load->database();
	  		$this->db->query('INSERT INTO shop_adjustment_filles(shop_adjustment_id, name, user_id) VALUES("'.$adjust_id.'","'.$name.'","'.$user_id.'")');
	  	}
	function remove_fille($id) {
	      $this->load->database();
	      $this->db->query('DELETE FROM shop_adjustment_filles WHERE id = '.$id);
	    }  		
	function get_shop_adjust($adjust_id,$shop_id) {
			$this->db->select('shop_adjustment.*,shop_renting.hotel_id,hotels.name as hotel_name, hotels.logo As logo, users.fullname as name');
			$this->db->join('shop_renting', 'shop_adjustment.shop_id = shop_renting.id','left');
			$this->db->join('hotels', 'shop_renting.hotel_id = hotels.id','left');
			$this->db->join('users', 'shop_adjustment.user_id = users.id','left');
			$this->db->where('shop_adjustment.id', $adjust_id);
			$this->db->where('shop_renting.id', $shop_id);		
			$query = $this->db->get('shop_adjustment');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
		}
	function update_state($adjust_id, $state) {
			$this->db->update('shop_adjustment', array('state_id'=> $state), "id = ".$adjust_id);
		}
	function get_by_verbal($adjust_id){
	    	$this->load->database();
			$this->db->select('shop_adjustment_signature.*, roles.role, departments.name as department, users.fullname as user_name');
			$this->db->join('roles', 'shop_adjustment_signature.role_id = roles.id', 'left');
			$this->db->join('departments', 'shop_adjustment_signature.department_id = departments.id', 'left');
			$this->db->join('users', 'shop_adjustment_signature.user_id = users.id', 'left');
        	$this->db->order_by('rank');
			$this->db->where('shop_adjustment_id', $adjust_id);
			$query = $this->db->get('shop_adjustment_signature');
			return $query->result_array();
  		}	
  	function get_comment($adjust_id){
			$query = $this->db->query("
				SELECT users.fullname, shop_adjustment_comments.comment, shop_adjustment_comments.timestamp FROM shop_adjustment_comments
				JOIN users on shop_adjustment_comments.user_id = users.id
				WHERE shop_adjustment_comments.shop_adjustment_id =".$adjust_id
			);
			return $query->result_array();
  		}
    function get_signature_identity($sign_id){
  			$this->load->database();
			$query = $this->db->query('SELECT shop_renting.hotel_id, shop_adjustment_signature.shop_id,shop_adjustment_signature.shop_adjustment_id FROM shop_adjustment_signature JOIN shop_renting ON shop_adjustment_signature.shop_id = shop_renting.id WHERE shop_adjustment_signature.id ='.$sign_id);
  			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  		}

  	function unsign($id){
	  		$this->load->database();
			$query = $this->db->query('UPDATE shop_adjustment_signature SET user_id = NULL, reject = 0 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
	  	}				
    function reject($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE shop_adjustment_signature SET user_id = '.$uid.', reject = 1 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  	function sign($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE shop_adjustment_signature SET user_id = '.$uid.' WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}
  	function update_shop_adjust($adjust_id, $data) {
			$this->load->database();
			$this->db->where('shop_adjustment.id', $adjust_id);		
			$this->db->update('shop_adjustment', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}
	function insert_comment($data){
			$this->db->insert('shop_adjustment_comments', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}
	 function getby_role() {
            $this->load->database();
            $this->db->select('users.id,users.fullname,users.email,users.role_id');
            $this->db->join('roles','users.role_id = roles.id','left');
            $this->db->where_in('users.role_id',array('57','59'));
            $query=$this->db->get('users');
            return $query->result_array();			
	        }		
	

}  		