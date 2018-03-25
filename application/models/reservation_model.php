<?php
class reservation_model extends CI_Model{


	 function get_forma_res($user_hotels = FALSE) {

$this->db->select('users.id as userid,users.*,forma_res.*,hotels.name as hotel');
$this->db->from('forma_res');
$this->db->join('users', 'forma_res.user_id = users.id','INNER');
$this->db->join('hotels', 'forma_res.hotel = hotels.id','INNER');
   if ($user_hotels) {
          $this->db->where_in('forma_res.hotel', $user_hotels);
        }
$query = $this->db->get();


 $forma_res = $query->result();
return $forma_res;
}

function GET_all_Users() {

$this->db->select('users.*');
$this->db->from('users');
$this->db->order_by("users.fullname", "ASC");
$query = $this->db->get();
return $query->result_array();

}

   function InsertComment(){
        $user_id=$this->tank_auth->get_user_id();
        $comment=$this->input->post('comment');
        $form_id=$this->input->post('form_id');

        $data=array('forma_id'=>$form_id,'user_id'=>$user_id,'comment'=>$comment);
        $this->db->insert('reservation_comments',$data);
      redirect('/reservation/view/'.$form_id);

  }

	 function GET_Users_Who_Sign() {

$this->db->select('roles.role,signature_res.dt,signature_res.rank,forma_res.id,forma_res.hotel as hotel_id,signature_res.role as role_user,signature_res.dt,signature_res.reject,signature_res.user_id,signature_res.forma_res_id,users.username,users.fullname');
$this->db->from('signature_res');
$this->db->join('roles', 'signature_res.role = roles.id','INNER');
$this->db->join('forma_res', 'forma_res.id = signature_res.forma_res_id','INNER');
$this->db->join('users', 'users.id = signature_res.user_id','LEFT');
$this->db->order_by("signature_res.rank", "ASC");

$query = $this->db->get();


 $GET_Users_Who_Sign = $query->result();
return $GET_Users_Who_Sign ;

}


function rand6($min,$max){
    $num = array();

    for($i=0 ;$i<6;$i++){
    $num[]=mt_rand($min,$max);

    }
return $num;
}




function get_attached_files($forma_id){
	$query = $this->db->query("SELECT name FROM `res_files` WHERE res_id=$forma_id ");

	return $query->result_array();

}


function get_last_id(){
	$query = $this->db->query("SELECT id FROM `forma_res` ORDER BY `forma_res`.`id` DESC LIMIT 1");

	return $query->row();

}

function GET_who_should_next($forma_id,$hotel_id){
	$query = $this->db->query("SELECT users.id,users.email,users.fullname from users
		JOIN employees_hotels ON users.id = employees_hotels.employee_id
		INNER JOIN signature_res ON  signature_res.role=users.role_id WHERE signature_res.reject=0 and signature_res.user_id=0 and signature_res.forma_res_id=$forma_id  AND users.role_id = signature_res.role  AND hotel_id = $hotel_id ORDER BY signature_res.rank asc limit 1");

	return $query->row();

}


  function getby_forma($forma_id){
    $query = $this->db->query("
                  SELECT users.fullname, reservation_comments.comment,reservation_comments.created FROM reservation_comments
                  JOIN users on reservation_comments.user_id = users.id
                  WHERE reservation_comments.forma_id =".$forma_id." ");

    return $query->result_array();
    }

 function Get_role_id($userid,$formaid) {

    $query = $this->db->query('SELECT distinct users.role_id,users.id,signature_res.rank  FROM users
INNER JOIN signature_res ON signature_res.role=users.role_id
      WHERE users.id ="'.$userid.'" and signature_res.forma_res_id ="'.$formaid.'"');


$get_role_user = $query->result_array();

    return $get_role_user;


}

function Get_all_users_signed($form_id){
	$query = $this->db->query("SELECT distinct users.fullname,users.email FROM users
INNER JOIN signature_res ON users.id=signature_res.user_id WHERE signature_res.forma_res_id=$form_id
	");

	return $query->result_array();
	}



 function Get_last_sign($formid) {

    $query = $this->db->query("SELECT rank FROM signature_res WHERE user_id>=1 and forma_res_id=$formid ORDER BY id ASC
LIMIT 1");


$Get_last_sign_user =$query->row();

    return $Get_last_sign_user;


}



  	function getby_user($uid){

		$query = $this->db->query('SELECT hotels.id, hotels.name FROM hotels JOIN employees_hotels ON hotels.id = employees_hotels.hotel_id WHERE employee_id ="'.$uid.'"');

		return $query->result_array();
  	}


  	 	function get_room_type(){
		$query = $this->db->get('room_type');

		return $query->result_array();


  	}

  	 	function get_ompanies(){
		$query = $this->db->get('Agent_Company');

		return $query->result_array();


  	}

 	 	function get_res_type(){
		$query = $this->db->get('res_type');

		return $query->result_array();


  	}

        function get_discount(){
    $query = $this->db->get('discount');

    return $query->result_array();


    }

       function get_board_type(){
    $query = $this->db->get('board_type');

    return $query->result_array();


    }

      function get_forma_content($id){
$this->db->select('forma_res.*,board_type.board_type as board_type,forma_res.company as c_name,hotels.name as hotel_name,hotels.id as hotel_id,users.username,users.email,users.id as userid,res_type.name as res_type,type.name as type');
$this->db->from('forma_res');
$this->db->join('hotels', 'forma_res.hotel = hotels.id','INNER');
$this->db->join('board_type', 'forma_res.board_type_id = board_type.id','INNER');
$this->db->join('res_type', 'res_type.id = forma_res.res_type','INNER');
$this->db->join('type', 'forma_res.type = type.id','INNER');
$this->db->join('users', 'users.id = forma_res.user_id','INNER');
// $this->db->join('Agent_Company', 'forma_res.company = Agent_Company.id','INNER');
$this->db->where('forma_res.id', $id);
$query = $this->db->get();

    return $query->result_array();


    }

    function get_forma_user($id){
$this->db->select('users.email,users.fullname');
$this->db->from('forma_res');
$this->db->join('users', 'users.id = forma_res.user_id','INNER');
$this->db->where('forma_res.id', $id);
$query = $this->db->get();

    return $query->result_array();


    }

  		 	function get_type(){
		$query = $this->db->get('type');

		return $query->result_array();


  	}
  function get_user_hotel($form_id,$role){

    $query = $this->db->query("SELECT users.email,users.username FROM users
      INNER JOIN employees_hotels ON employees_hotels.employee_id=users.id
      INNER JOIN forma_res ON forma_res.id=$form_id

      WHERE users.role_id=$role and employees_hotels.hotel_id IN (forma_res.hotel)");

    return $query->result_array();
    }


function get_email_fullname_signer($form_id,$role_id,$hotel_id){

      $query = $this->db->query("SELECT users.fullname,users.email FROM users
INNER JOIN roles ON roles.id=users.role_id
INNER JOIN forma_res ON forma_res.hotel=$form_id
INNER JOIN employees_hotels ON employees_hotels.employee_id=users.id
where employees_hotels.hotel_id IN($hotel_id) AND roles.id=$role_id");

    return $query->result_array();

}


    function approve ($user_id,$forma_id,$role_id)
{

    $query = $this->db->query("UPDATE signature_res SET user_id=$user_id WHERE forma_res_id=$forma_id AND role=$role_id");



}


    function reject ($user_id,$forma_id,$role_id)
{

    $query = $this->db->query("UPDATE signature_res SET user_id=$user_id,reject=1 WHERE forma_res_id=$forma_id AND role=$role_id ");



}

function update_upload_file ($forma_id,$assumed_id)
{

$query = $this->db->query("UPDATE  res_files SET res_id=$forma_id WHERE res_id=$assumed_id");



}


function insert_to_db()
{


$this->db->insert('forma_res', $_POST);

$forma_id = $this->db->insert_id();



	// Tourism
$query = $this->db->get_where('role_reservation', array('res_type' => $_POST['res_type']));
$user_id = $this->session->userdata('session_id');


if ($query->num_rows() > 0)
{
   foreach ($query->result() as $row)
   {

$data = array(
   'role' => $row->role ,
   'rank' => $row->rank,
   'forma_res_id' => $forma_id,
   'user_id' => 0

      );

$this->db->insert('signature_res', $data);


   }
}


return $forma_id;

}


}
?>
