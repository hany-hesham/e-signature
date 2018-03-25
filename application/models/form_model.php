<?php

	class form_model extends CI_Model{
	
  		function __contruct(){
			parent::__construct;
		}

		function create_form_after($data) {
			$this->load->database();
			$this->db->insert('form_after', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function update_after_files($assumed_id, $fm_id) {
	  		$this->load->database();
	  		$this->db->query('UPDATE form_filles_after SET fm_id = "'.$fm_id.'" WHERE fm_id = "'.$assumed_id.'"');
  		}

  		function getall_operator(){
	    	$this->load->database();
			$query = $this->db->get('operators');
			return $query->result_array();
  		}

  		function get_operator_by_id($id){
	    	$this->load->database();
			$query = $this->db->get('operators');
			$this->db->where('id', $id);
			return $query->row_array();
  		}

  		function getby_fille_after($fm_id, $type){
		    $this->load->database();
			$this->db->select('form_filles_after.*, users.fullname as user_name');
			$this->db->join('users', 'form_filles_after.user_id = users.id','left');
			$this->db->where('fm_id', $fm_id);
			$this->db->where('type', $type);
			$query = $this->db->get('form_filles_after');
			return $query->result_array();
	  	}

	  	function get_fille_after($id){
		    $this->load->database();
			$this->db->select('form_filles_after.*, users.fullname as user_name');
			$this->db->join('users', 'form_filles_after.user_id = users.id','left');
			$this->db->where('form_filles_after.id', $id);
			$query = $this->db->get('form_filles_after');
			return $query->row_array();
	  	}

		function get_form_after($fm_id) {
			$this->db->select('form_after.*, hotels.name as hotel_name, hotels.logo As logo, users.fullname as name, operators.name as operator_name');
			$this->db->join('hotels', 'form_after.hotel_id = hotels.id','left');
			$this->db->join('operators', 'form_after.operator_id = operators.id','left');
			$this->db->join('users', 'form_after.user_id = users.id','left');
			$this->db->where('form_after.id', $fm_id);		
			$query = $this->db->get('form_after');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
		}

		function after_update_state($fm_id, $state) {
			$this->db->update('form_after', array('state_id'=> $state), "id = ".$fm_id);
		}

		function after_getby_verbal(){
	    	$this->load->database();
			$this->db->select('form_after_role.role');
			$query = $this->db->get('form_after_role');
			return $query->result_array();
  		}

		function get_new_form_after($fm_id) {
			$this->db->select('form_after.*, hotels.name as hotel_name, hotels.logo As logo, users.fullname as name, operators.name as operator_name');
			$this->db->join('hotels', 'form_after.hotel_id = hotels.id','left');
			$this->db->join('operators', 'form_after.operator_id = operators.id','left');
			$this->db->join('users', 'form_after.new_user_id = users.id','left');
			$this->db->where('form_after.id', $fm_id);		
			$query = $this->db->get('form_after');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
		}

		function getcomment_after($fm_id){
			$query = $this->db->query("
				SELECT users.fullname, form_after_comments.comment, form_after_comments.created	FROM form_after_comments
				JOIN users on form_after_comments.user_id = users.id
				WHERE form_after_comments.fm_id =".$fm_id);
			return $query->result_array();
  		}

		function update_form_after($data, $fm_id) {
			$this->load->database();
			$this->db->where('form_after.id', $fm_id);		
			$this->db->update('form_after', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function add_after($fm_id, $name, $user_id, $type) {
	  		$this->load->database();
	  		$this->db->query('INSERT INTO form_filles_after(fm_id,name,user_id,type) VALUES("'.$fm_id.'","'.$name.'","'.$user_id.'","'.$type.'")');
	  	}

	  	function remove_after($id) {
	      	$this->load->database();
	      	$this->db->query('DELETE FROM form_filles_after WHERE id = '.$id);
	    }

		function view_after($user_hotels = FALSE) {
  	  		$this->load->database();
			$this->db->select('form_after.*,hotels.name as hotel_name, operators.name as operator_name');
			$this->db->join('hotels', 'form_after.hotel_id = hotels.id','left');
			$this->db->join('operators', 'form_after.operator_id = operators.id','left');
        	if ($user_hotels) {
          		$this->db->where_in('form_after.hotel_id', $user_hotels);
        	}
        	$this->db->order_by('timestamp', 'DESC');
			$query = $this->db->get('form_after');
			return $query->result_array();
		}

		function insertcomment_after($data){
			$this->db->insert('form_after_comments', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function create_form_in_uk($data) {
			$this->load->database();
			$this->db->insert('form_in_uk', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function update_in_uk_files($assumed_id, $fm_id) {
	  		$this->load->database();
	  		$this->db->query('UPDATE form_filles_in_uk SET fm_id = "'.$fm_id.'" WHERE fm_id = "'.$assumed_id.'"');
  		}

  		function getby_fille_in_uk($fm_id, $type){
		    $this->load->database();
			$this->db->select('form_filles_in_uk.*, users.fullname as user_name');
			$this->db->join('users', 'form_filles_in_uk.user_id = users.id','left');
			$this->db->where('fm_id', $fm_id);
			$this->db->where('type', $type);
			$query = $this->db->get('form_filles_in_uk');
			return $query->result_array();
	  	}

	  	function get_fille_in_uk($id){
		    $this->load->database();
			$this->db->select('form_filles_in_uk.*, users.fullname as user_name');
			$this->db->join('users', 'form_filles_in_uk.user_id = users.id','left');
			$this->db->where('form_filles_in_uk.id', $id);
			$query = $this->db->get('form_filles_in_uk');
			return $query->row_array();
	  	}

		function get_form_in_uk($fm_id) {
			$this->db->select('form_in_uk.*, hotels.name as hotel_name, hotels.logo As logo, users.fullname as name, operators.name as operator_name');
			$this->db->join('hotels', 'form_in_uk.hotel_id = hotels.id','left');
			$this->db->join('operators', 'form_in_uk.operator_id = operators.id','left');
			$this->db->join('users', 'form_in_uk.user_id = users.id','left');
			$this->db->where('form_in_uk.id', $fm_id);		
			$query = $this->db->get('form_in_uk');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
		}

		function in_uk_update_state($fm_id, $state) {
			$this->db->update('form_in_uk', array('state_id'=> $state), "id = ".$fm_id);
		}

		function in_uk_getby_verbal(){
	    	$this->load->database();
			$this->db->select('form_in_uk_role.role');
			$query = $this->db->get('form_in_uk_role');
			return $query->result_array();
  		}

		function get_new_form_in_uk($fm_id) {
			$this->db->select('form_in_uk.*, hotels.name as hotel_name, hotels.logo As logo, users.fullname as name, operators.name as operator_name');
			$this->db->join('hotels', 'form_in_uk.hotel_id = hotels.id','left');
			$this->db->join('operators', 'form_in_uk.operator_id = operators.id','left');
			$this->db->join('users', 'form_in_uk.new_user_id = users.id','left');
			$this->db->where('form_in_uk.id', $fm_id);		
			$query = $this->db->get('form_in_uk');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
		}

		function getcomment_in_uk($fm_id){
			$query = $this->db->query("
				SELECT users.fullname, form_in_uk_comments.comment, form_in_uk_comments.created	FROM form_in_uk_comments
				JOIN users on form_in_uk_comments.user_id = users.id
				WHERE form_in_uk_comments.fm_id =".$fm_id);
			return $query->result_array();
  		}

		function update_form_in_uk($data, $fm_id) {
			$this->load->database();
			$this->db->where('form_in_uk.id', $fm_id);		
			$this->db->update('form_in_uk', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function add_in_uk($fm_id, $name, $user_id, $type) {
	  		$this->load->database();
	  		$this->db->query('INSERT INTO form_filles_in_uk(fm_id,name,user_id,type) VALUES("'.$fm_id.'","'.$name.'","'.$user_id.'","'.$type.'")');
	  	}

	  	function remove_in_uk($id) {
	      	$this->load->database();
	      	$this->db->query('DELETE FROM form_filles_in_uk WHERE id = '.$id);
	    }

		function view_in_uk($user_hotels = FALSE) {
  	  		$this->load->database();
			$this->db->select('form_in_uk.*,hotels.name as hotel_name, operators.name as operator_name');
			$this->db->join('hotels', 'form_in_uk.hotel_id = hotels.id','left');
			$this->db->join('operators', 'form_in_uk.operator_id = operators.id','left');
        	if ($user_hotels) {
          		$this->db->where_in('form_in_uk.hotel_id', $user_hotels);
        	}
        	$this->db->order_by('timestamp', 'DESC');
			$query = $this->db->get('form_in_uk');
			return $query->result_array();
		}

		function insertcomment_in_uk($data){
			$this->db->insert('form_in_uk_comments', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}
		
		function create_form_in($data) {
            $this->load->database();
            $this->db->insert('form_in', $data);
            return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
        }

        function update_in_files($assumed_id, $fm_id) {
            $this->load->database();
            $this->db->query('UPDATE form_filles_in SET fm_id = "'.$fm_id.'" WHERE fm_id = "'.$assumed_id.'"');
        }

        function getby_fille_in($fm_id, $type){
            $this->load->database();
            $this->db->select('form_filles_in.*, users.fullname as user_name');
            $this->db->join('users', 'form_filles_in.user_id = users.id','left');
            $this->db->where('fm_id', $fm_id);
            $this->db->where('type', $type);
            $query = $this->db->get('form_filles_in');
            return $query->result_array();
        }

        function get_fille_in($id){
		    $this->load->database();
			$this->db->select('form_filles_in.*, users.fullname as user_name');
			$this->db->join('users', 'form_filles_in.user_id = users.id','left');
			$this->db->where('form_filles_in.id', $id);
			$query = $this->db->get('form_filles_in');
			return $query->row_array();
	  	}

        function get_form_in($fm_id) {
            $this->db->select('form_in.*, hotels.name as hotel_name, hotels.logo As logo, users.fullname as name, operators.name as operator_name');
            $this->db->join('hotels', 'form_in.hotel_id = hotels.id','left');
            $this->db->join('operators', 'form_in.operator_id = operators.id','left');
            $this->db->join('users', 'form_in.user_id = users.id','left');
            $this->db->where('form_in.id', $fm_id);      
            $query = $this->db->get('form_in');
            return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
        }

        function in_update_state($fm_id, $state) {
            $this->db->update('form_in', array('state_id'=> $state), "id = ".$fm_id);
        }

        function in_getby_verbal(){
            $this->load->database();
            $this->db->select('form_in_role.role');
            $query = $this->db->get('form_in_role');
            return $query->result_array();
        }

        function get_new_form_in($fm_id) {
            $this->db->select('form_in.*, hotels.name as hotel_name, hotels.logo As logo, users.fullname as name, operators.name as operator_name');
            $this->db->join('hotels', 'form_in.hotel_id = hotels.id','left');
            $this->db->join('operators', 'form_in.operator_id = operators.id','left');
            $this->db->join('users', 'form_in.new_user_id = users.id','left');
            $this->db->where('form_in.id', $fm_id);      
            $query = $this->db->get('form_in');
            return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
        }

        function getcomment_in($fm_id){
            $query = $this->db->query("
                SELECT users.fullname, form_in_comments.comment, form_in_comments.created FROM form_in_comments
                JOIN users on form_in_comments.user_id = users.id
                WHERE form_in_comments.fm_id =".$fm_id);
            return $query->result_array();
        }

        function update_form_in($data, $fm_id) {
            $this->load->database();
            $this->db->where('form_in.id', $fm_id);      
            $this->db->update('form_in', $data);
            return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
        }

        function add_in($fm_id, $name, $user_id, $type) {
            $this->load->database();
            $this->db->query('INSERT INTO form_filles_in(fm_id,name,user_id,type) VALUES("'.$fm_id.'","'.$name.'","'.$user_id.'","'.$type.'")');
        }

        function remove_in($id) {
            $this->load->database();
            $this->db->query('DELETE FROM form_filles_in WHERE id = '.$id);
        }

        function view_in($user_hotels = FALSE) {
            $this->load->database();
            $this->db->select('form_in.*,hotels.name as hotel_name, operators.name as operator_name');
            $this->db->join('hotels', 'form_in.hotel_id = hotels.id','left');
            $this->db->join('operators', 'form_in.operator_id = operators.id','left');
            if ($user_hotels) {
                $this->db->where_in('form_in.hotel_id', $user_hotels);
            }
            $this->db->order_by('timestamp', 'DESC');
            $query = $this->db->get('form_in');
            return $query->result_array();
        }

        function insertcomment_in($data){
            $this->db->insert('form_in_comments', $data);
            return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
        }

        function get_case_in_uk_type($hid = FALSE, $from, $to, $answer, $opid = FALSE){
		    $this->load->database();
			$this->db->select('form_in_uk.*,hotels.name as hotel_name, operators.name as operator_name');
			$this->db->join('hotels', 'form_in_uk.hotel_id = hotels.id','left');
			$this->db->join('operators', 'form_in_uk.operator_id = operators.id','left');
			$this->db->where('form_in_uk.accident', $answer);
			if ($hid) {
				$this->db->where('form_in_uk.hotel_id', $hid);
			}
			if ($opid) {
				$this->db->where('form_in_uk.operator_id', $opid);
			}
			$this->db->where('form_in_uk.timestamp >=', $from);
	        $this->db->where('form_in_uk.timestamp <=', $to);
			$this->db->order_by('form_in_uk.timestamp');
			$query = $this->db->get('form_in_uk');
			return $query->result_array();
	  	}

	  	function get_case_in_uk_type_count($hid = FALSE, $from, $to, $answer, $opid = FALSE){
		    $this->load->database();
			$this->db->select('form_in_uk.*,hotels.name as hotel_name, operators.name as operator_name');
			$this->db->join('hotels', 'form_in_uk.hotel_id = hotels.id','left');
			$this->db->join('operators', 'form_in_uk.operator_id = operators.id','left');
			$this->db->where('form_in_uk.accident', $answer);
			if ($hid) {
				$this->db->where('form_in_uk.hotel_id', $hid);
			}
			if ($opid) {
				$this->db->where('form_in_uk.operator_id', $opid);
			}
			$this->db->where('form_in_uk.timestamp >=', $from);
	        $this->db->where('form_in_uk.timestamp <=', $to);
			$this->db->order_by('form_in_uk.timestamp');
			$query = $this->db->get('form_in_uk');
			return $query->num_rows();
	  	}

	  	 function get_case_ir_summary($hid = FALSE, $from, $to, $answer=false, $opid = FALSE){
		    $this->load->database();
			$this->db->select('form_in_uk.*,hotels.name as hotel_name, operators.name as operator_name');
			$this->db->join('hotels', 'form_in_uk.hotel_id = hotels.id','left');
			$this->db->join('operators', 'form_in_uk.operator_id = operators.id','left');
			if($answer){
			$this->db->where('form_in_uk.accident', $answer);
			}
			if ($hid) {
				$this->db->where('form_in_uk.hotel_id', $hid);
			}
			if ($opid) {
				$this->db->where('form_in_uk.operator_id', $opid);
			}
			$this->db->where('form_in_uk.timestamp >=', $from);
	        $this->db->where('form_in_uk.timestamp <=', $to);
			$this->db->order_by('form_in_uk.timestamp');
			$query = $this->db->get('form_in_uk');
			return $query->result_array();
	  	}

	  	 function get_case_ir_summary_count($hid = FALSE, $from, $to, $answer=false, $opid = FALSE){
		    $this->load->database();
			$this->db->select('form_in_uk.*,hotels.name as hotel_name, operators.name as operator_name');
			$this->db->join('hotels', 'form_in_uk.hotel_id = hotels.id','left');
			$this->db->join('operators', 'form_in_uk.operator_id = operators.id','left');
			if($answer){
			$this->db->where('form_in_uk.accident', $answer);
			}
			if ($hid) {
				$this->db->where('form_in_uk.hotel_id', $hid);
			}
			if ($opid) {
				$this->db->where('form_in_uk.operator_id', $opid);
			}
			$this->db->where('form_in_uk.timestamp >=', $from);
	        $this->db->where('form_in_uk.timestamp <=', $to);
			$this->db->order_by('form_in_uk.timestamp');
			$query = $this->db->get('form_in_uk');
			return $query->num_rows();
	  	}

	  	function get_case_in_type($hid = FALSE, $from, $to, $answer, $opid = FALSE){
		    $this->load->database();
			$this->db->select('form_in.*,hotels.name as hotel_name, operators.name as operator_name');
			$this->db->join('hotels', 'form_in.hotel_id = hotels.id','left');
			$this->db->join('operators', 'form_in.operator_id = operators.id','left');
			$this->db->where('form_in.accident', $answer);
			if ($hid) {
				$this->db->where('form_in.hotel_id', $hid);
			}
			if ($opid) {
				$this->db->where('form_in.operator_id', $opid);
			}
			$this->db->where('form_in.timestamp >=', $from);
	        $this->db->where('form_in.timestamp <=', $to);
			$this->db->order_by('form_in.timestamp');
			$query = $this->db->get('form_in');
			return $query->result_array();
	  	}

	  	function get_case_in_type_count($hid = FALSE, $from, $to, $answer, $opid = FALSE){
		    $this->load->database();
			$this->db->select('form_in.*,hotels.name as hotel_name, operators.name as operator_name');
			$this->db->join('hotels', 'form_in.hotel_id = hotels.id','left');
			$this->db->join('operators', 'form_in.operator_id = operators.id','left');
			$this->db->where('form_in.accident', $answer);
			if ($hid) {
				$this->db->where('form_in.hotel_id', $hid);
			}
			if ($opid) {
				$this->db->where('form_in.operator_id', $opid);
			}
			$this->db->where('form_in.timestamp >=', $from);
	        $this->db->where('form_in.timestamp <=', $to);
			$this->db->order_by('form_in.timestamp');
			$query = $this->db->get('form_in');
			return $query->num_rows();
	  	}

	  	function get_illness($type, $id) {
		    $this->load->database();
			$this->db->select('illness_guest.*');
			$this->db->where('illness_guest.ir_type', $type);		
			$this->db->where('illness_guest.ir', $id);		
			$query = $this->db->get('illness_guest');
                //die(print_r($query));
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
		}

		function update_form_in_uk_iln($iln_id, $fm_id) {
            $this->load->database();
            $this->db->query('UPDATE form_in_uk SET iln_id = "'.$iln_id.'" WHERE id = "'.$fm_id.'"');
        }

        function update_form_in_iln($iln_id, $fm_id) {
            $this->load->database();
            $this->db->query('UPDATE form_in SET iln_id = "'.$iln_id.'" WHERE id = "'.$fm_id.'"');
        }

	}

?>
