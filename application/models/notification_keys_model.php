<?php

class Notification_keys_model extends MY_Model{
	
  	function __contruct(){
		parent::__construct;
		// $this->load->helper('url');
  	}
	
  	function getall(){
	    $this->load->database();
		
		$query = $this->db->get('notification_keys');
		return $query->result_array();
  	}

  	function getby_module($module_name){
	    $this->load->database();
		
		$query = $this->db->query('SELECT notification_keys.token
									FROM notification_keys
									JOIN modules ON notification_keys.module_id = modules.id
									WHERE modules.name ="'.$module_name.'"
									GROUP BY notification_keys.token');

		return $query->result_array();
  	}

  	function getby_user($module_name, $uid){
	    $this->load->database();
		
		$query = $this->db->query('SELECT notification_keys.token
									FROM notification_keys
									JOIN modules ON notification_keys.module_id = modules.id
									WHERE notification_keys.user_id = "'.$uid.'"
									AND modules.name ="'.$module_name.'"
									GROUP BY notification_keys.token');

		return $query->result_array();
  	}

  	function getby_mail($module_name, $email){
	    $this->load->database();
		
		$query = $this->db->query('SELECT notification_keys.token
									FROM notification_keys
									JOIN modules ON notification_keys.module_id = modules.id
									JOIN users ON notification_keys.user_id = users.id
									WHERE users.email = "'.$email.'"
									AND modules.name ="'.$module_name.'"
									GROUP BY notification_keys.token');

		return $query->result_array();
  	}
}
?>
