<?php
class reservation_creator_model extends CI_Model{


	 function getrooms() {

$this->db->select('users.*,rooms.*,hotels.name as hotel');    
$this->db->from('rooms');
$this->db->join('users', 'rooms.userid = users.id','INNER');
$this->db->join('hotels', 'rooms.hotel = hotels.id','INNER');

$query = $this->db->get();


 $rooms = $query->result();
return $rooms;
}


	 function GET_Users_Who_Sign() {

$this->db->select('rooms.id,signature_res.dt,signature_res.status,users.username');    
$this->db->from('signature_res');
$this->db->join('users', 'signature_res.userid = users.id','INNER');
$this->db->join('rooms', 'rooms.id = signature_res.formaid','INNER');

$query = $this->db->get();


 $GET_Users_Who_Sign = $query->result();
return $GET_Users_Who_Sign ;

}
}
?>
