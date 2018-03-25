<?php

	class credit_app_model extends CI_Model{

    function __contruct(){
			parent::__construct;
	    }
  	function create_credit_app($data) {
			$this->load->database();
			$this->db->insert('credit_app', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		} 
	function update_files($assumed_id, $credit_app_id) {
  			$this->load->database();
  			$this->db->query('UPDATE credit_app_filles SET credit_app_id = "'.$credit_app_id.'" WHERE credit_app_id = "'.$assumed_id.'"');
  		}	
  	function credit_app_sign($type){
  			$this->load->database();
			$this->db->select('credit_app_role.*');
			$this->db->where('credit_app_role.type',$type);
			$query = $this->db->get('credit_app_role');
			return $query->result_array();  	
		}
	function credit_app_do_sign($credit_app_id){
  	 		$this->load->database();
			$this->db->select('credit_app_signature.*');
			$this->db->where('credit_app_signature.credit_app_id', $credit_app_id);		
			$query = $this->db->get('credit_app_signature');
			return $query->num_rows();  	
		}	
	function self_sign($credit_app_id, $user_id){
	    $this->load->database();
		$query = $this->db->query('UPDATE credit_app_signature SET user_id = '.$user_id.' WHERE credit_app_id = '.$credit_app_id.' AND role_id = 0');
		return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  	   }
  	function add_signature($credit_app_id,$role_id, $department_id,  $rank){
	    	$this->load->database();
			$query = $this->db->query('INSERT INTO credit_app_signature(credit_app_id,role_id, department_id, rank) 
				VALUES("'.$credit_app_id.'", "'.$role_id.'", "'.$department_id.'", "'.$rank.'")');
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
  		}
  	function getby_fille($credit_app_id){
	    	$this->load->database();
			$this->db->select('credit_app_filles.*, users.fullname as user_name');
			$this->db->join('users', 'credit_app_filles.user_id = users.id','left');
			$this->db->where('credit_app_id', $credit_app_id);
			$query = $this->db->get('credit_app_filles');
			return $query->result_array();
  		}	
  	function create_item($data) {
			$this->load->database();
			$this->db->insert('credit_app_hotels', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}
	function add_fille($credit_app_id, $name, $user_id) {
	  		$this->load->database();
	  		$this->db->query('INSERT INTO credit_app_filles(credit_app_id, name, user_id) VALUES("'.$credit_app_id.'","'.$name.'","'.$user_id.'")');
	  	}
	function remove_fille($id) {
	      $this->load->database();
	      $this->db->query('DELETE FROM credit_app_filles WHERE id = '.$id);
	    } 
	function get_credit_app($credit_app_id) {
			$this->db->select('credit_app.*,credit_app.hotel_id,hotels.name as hotel_name, hotels.logo As logo, users.fullname as name');
			$this->db->join('hotels', 'credit_app.hotel_id = hotels.id','left');
			$this->db->join('users', 'credit_app.user_id = users.id','left');
			$this->db->where('credit_app.id', $credit_app_id);	
			$query = $this->db->get('credit_app');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
		} 
	function update_state($credit_app_id, $state) {
			$this->db->update('credit_app', array('state_id'=> $state), "id = ".$credit_app_id);
		}
	function get_by_verbal($credit_app_id){
	    	$this->load->database();
			$this->db->select('credit_app_signature.*, roles.role, departments.name as department, users.fullname as user_name');
			$this->db->join('roles', 'credit_app_signature.role_id = roles.id', 'left');
			$this->db->join('departments', 'credit_app_signature.department_id = departments.id', 'left');
			$this->db->join('users', 'credit_app_signature.user_id = users.id', 'left');
        	$this->db->order_by('rank');
			$this->db->where('credit_app_signature.credit_app_id', $credit_app_id);
			$query = $this->db->get('credit_app_signature');
			return $query->result_array();
  		}
  	function get_credit_app_hotels($credit_app_id) {
			$this->db->select('credit_app_hotels.*');
			$this->db->where('credit_app_hotels.credit_app_id', $credit_app_id);	
			$query = $this->db->get('credit_app_hotels');
			return $query->result_array();
		}
	function get_comment($credit_app_id){
			$query = $this->db->query("
				SELECT users.fullname, credit_app_comments.comment, credit_app_comments.timestamp FROM credit_app_comments
				JOIN users on credit_app_comments.user_id = users.id
				WHERE credit_app_comments.credit_app_id =".$credit_app_id
			);
			return $query->result_array();
  		}
  	function update_credit_app($credit_app_id, $data) {
			$this->load->database();
			$this->db->where('credit_app.id', $credit_app_id);		
			$this->db->update('credit_app', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}	
	function update_item($id, $credit_app_id, $data) {
			$this->load->database();
			$this->db->where('credit_app_hotels.credit_app_id', $credit_app_id);	
			$this->db->where('credit_app_hotels.id', $id);		
			$this->db->update('credit_app_hotels', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}	
	function getby_role() {
            $this->load->database();
            $this->db->select('users.id,users.fullname,users.email,users.role_id');
            $this->db->join('roles','users.role_id = roles.id','left');
            $this->db->where_in('users.role_id',array('57'));
            $query=$this->db->get('users');
            return $query->result_array();	
	        }		
	function get_signature_identity($sign_id){
  			$this->load->database();
			$query = $this->db->query('SELECT credit_app.hotel_id, credit_app_signature.credit_app_id,credit_app_signature.rank FROM credit_app_signature JOIN credit_app ON credit_app_signature.credit_app_id = credit_app.id WHERE credit_app_signature.id ='.$sign_id);
  			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  		} 
  	function unsign($id){
	  		$this->load->database();
			$query = $this->db->query('UPDATE credit_app_signature SET user_id = NULL, reject = 0 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
	  	}	 
	function reject($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE credit_app_signature SET user_id = '.$uid.', reject = 1 WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}

  	function sign($id, $uid){
  			$this->load->database();
			$query = $this->db->query('UPDATE credit_app_signature SET user_id = '.$uid.' WHERE id = '.$id);
			return ($this->db->affected_rows() == 1)? TRUE : FALSE;
  		}
  	function insert_comment($data){
			$this->db->insert('credit_app_comments', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}	
	function view_index($user_hotels = FALSE, $state = FALSE) {
  	  		$this->load->database();
			$this->db->select('credit_app.id, credit_app.user_id, credit_app.hotel_id, credit_app.state_id, credit_app.comp_name, credit_app.bank_name,credit_app.timestamp, hotels.name as hotel_name, users.fullname as name, credit_app_states.name as state');
			$this->db->join('hotels', 'credit_app.hotel_id = hotels.id','left');
			$this->db->join('users', 'credit_app.user_id = users.id','left');
			$this->db->join('credit_app_states', 'credit_app.state_id = credit_app_states.id', 'left');
        	if ($user_hotels) {
          		$this->db->where_in('credit_app.hotel_id', $user_hotels);
        	}
        	if ($state && $state > 0) {
				$this->db->where('credit_app.state_id', $state);	
			}else{
				$this->db->where('credit_app.state_id !=', 0);
			}
        	$this->db->order_by('timestamp', 'DESC');
			$query = $this->db->get('credit_app');
			return $query->result_array();
		}	
	function get_by_verbals($credit_app_id){
	    	$this->load->database();
			$this->db->select('credit_app_signature.role_id, credit_app_signature.rank, credit_app_signature.department_id, credit_app_signature.user_id, credit_app_signature.reject, roles.role, departments.name as department, users.fullname as user_name');
			$this->db->join('roles', 'credit_app_signature.role_id = roles.id', 'left');
			$this->db->join('departments', 'credit_app_signature.department_id = departments.id', 'left');
			$this->db->join('users', 'credit_app_signature.user_id = users.id', 'left');
			$this->db->where('credit_app_id', $credit_app_id);
        	$this->db->order_by('credit_app_signature.rank');
			$query = $this->db->get('credit_app_signature');
			return $query->result_array();
  		}	
	function get_states(){
	    	$this->load->database();
			$this->db->select('credit_app_states.*');
			$x = array('0' => 2, '1' => 3);
			$this->db->where_not_in('credit_app_states.id', $x);
			$query = $this->db->get('credit_app_states');
			return $query->result_array();
  		}	
  	     	 				    	  					   		
}	   