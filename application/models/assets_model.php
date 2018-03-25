<?php

	class assets_model extends CI_Model{


  		function __contruct(){
			parent::__construct;
		}

		function getall(){
			$anotherdb = $this->load->database('anotherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
  			$query = $anotherdb->select('*')->get('R5OBJECTS');
  			var_dump($query);
  		}

  	}

?>


