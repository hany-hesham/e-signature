<?php

class Forms_model extends CI_Model{

	

  	function __contruct(){

		parent::__construct;

	}



	function view_wat($hotel_from = FALSE, $hotel_to = FALSE) {

  	  	$this->load->database();

  	  	$this->db->select('forms.id, forms.from_hotel_id, forms.to_hotel_id, forms.department_id, forms.issue_date, forms.delivery_date, forms.movement_reason, forms.old_reason, from_hotels.name AS from_hotel, to_hotels.name AS to_hotel, departments.name AS department_name');

  	  	$this->db->join('hotels AS from_hotels','forms.from_hotel_id = from_hotels.id');

  	  	$this->db->join('hotels AS to_hotels','forms.to_hotel_id = to_hotels.id');

  	  	$this->db->join('departments','forms.department_id = departments.id');

  	  	if ($hotel_from) {

        	$this->db->where('forms.from_hotel_id', $hotel_from);

        }

        if ($hotel_to) {

        	$this->db->where('forms.to_hotel_id', $hotel_to);

        }

		$this->db->where('forms.fin_rdof_id', 3);		

		$this->db->where('forms.fin_chrmn_cai_id', NULL);		

  	  	$this->db->order_by('id', 'DESC');

		$query = $this->db->get('forms');

		return $query->result_array();

	}



	function insert_comment($data){

		$this->db->insert('forms_comments', $data);

		return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;

	}



	function get_comment($form_id){

		$query = $this->db->query("

			SELECT users.fullname, forms_comments.comment, forms_comments.timestamp FROM forms_comments

			JOIN users on forms_comments.user_id = users.id

			WHERE forms_comments.form_id =".$form_id

		);

		return $query->result_array();

  	}



	function update_state($id, $state) {

		$this->db->update('forms', array('state_id'=> $state), "id = ".$id);

	}



	function update_sign($id, $sign, $user_id) {

		$signature = array( $sign."_id"=> $user_id);

		if ($sign == 'rcv_user') {

			$signature['rcv_user_date'] = date("Y-m-d H:i:s");

		}

		$this->db->update('forms', $signature, "id = ".$id);

	}



	function getall($state) {

  	  	$this->load->database();



  	  	$this->db->select('forms.id,

  	  		from_hotels.name AS from_hotel,

  	  		to_hotels.name AS to_hotel,

  	  		departments.name AS department_name,

  	  		forms.issue_date,

  	  		form_states.state,

  	  		rcv_user_users.fullname AS rcv_user_fullname,

			rcv_hotel_acc_users.fullname AS rcv_hotel_acc_fullname,

			rcv_dpt_head_users.fullname AS rcv_dpt_head_fullname,

			rcv_chrmn_cai_users.fullname AS rcv_chrmn_cai_fullname,

			src_dpt_head_users.fullname AS src_dpt_head_fullname,

			src_hotel_gm_users.fullname AS src_hotel_gm_fullname,

			src_hotel_fc_users.fullname AS src_hotel_fc_fullname,

			dstn_dpt_head_users.fullname AS dstn_dpt_head_fullname,

			dstn_hotel_gm_users.fullname AS dstn_hotel_gm_fullname,

			dstn_hotel_fc_users.fullname AS dstn_hotel_fc_fullname,

			fin_cluster_fc_users.fullname AS fin_cluster_fc_fullname,

			fin_rdof_users.fullname AS fin_rdof_fullname,

			fin_chrmn_cai_users.fullname AS fin_chrmn_cai_fullname,

			fin_chairman_users.fullname AS fin_chairman_fullname,

  	  		');

  	  	$this->db->join('hotels AS from_hotels','forms.from_hotel_id = from_hotels.id');

  	  	$this->db->join('hotels AS to_hotels','forms.to_hotel_id = to_hotels.id');

  	  	$this->db->join('form_states','forms.state_id = form_states.id');

  	  	$this->db->join('departments','forms.department_id = departments.id');



  	  	$this->db->join('users AS rcv_user_users','forms.rcv_user_id = rcv_user_users.id', 'left');

  	  	$this->db->join('users AS rcv_hotel_acc_users','forms.rcv_hotel_acc_id = rcv_hotel_acc_users.id', 'left');

  	  	$this->db->join('users AS rcv_dpt_head_users','forms.rcv_dpt_head_id = rcv_dpt_head_users.id', 'left');

  	  	$this->db->join('users AS rcv_chrmn_cai_users','forms.rcv_chrmn_cai_id = rcv_chrmn_cai_users.id', 'left');



  	  	$this->db->join('users AS src_dpt_head_users','forms.src_dpt_head_id = src_dpt_head_users.id', 'left');

  	  	$this->db->join('users AS src_hotel_gm_users','forms.src_hotel_gm_id = src_hotel_gm_users.id', 'left');

  	  	$this->db->join('users AS src_hotel_fc_users','forms.src_hotel_fc_id = src_hotel_fc_users.id', 'left');



  	  	$this->db->join('users AS dstn_dpt_head_users','forms.dstn_dpt_head_id = dstn_dpt_head_users.id', 'left');

  	  	$this->db->join('users AS dstn_hotel_gm_users','forms.dstn_hotel_gm_id = dstn_hotel_gm_users.id', 'left');

  	  	$this->db->join('users AS dstn_hotel_fc_users','forms.dstn_hotel_fc_id = dstn_hotel_fc_users.id', 'left');



  	  	$this->db->join('users AS fin_cluster_fc_users','forms.fin_cluster_fc_id = fin_cluster_fc_users.id', 'left');

  	  	$this->db->join('users AS fin_rdof_users','forms.fin_rdof_id = fin_rdof_users.id', 'left');

  	  	$this->db->join('users AS fin_chrmn_cai_users','forms.fin_chrmn_cai_id = fin_chrmn_cai_users.id', 'left');

  	    $this->db->join('users AS fin_chairman_users','forms.fin_chairman_id = fin_chairman_users.id', 'left');



  	  	if ($state) {

  	  		$this->db->where('forms.state_id >=', $state);

  	  	} else {

  	  		$this->db->where('forms.state_id <', $state+5);

  	  	}



  	  	$this->db->order_by('id', 'DESC');

	

		$query = $this->db->get('forms');

		return $query->result_array();

	}



	function get_pur_sec_mgr($id) {

		$query = $this->db->query("

									SELECT users.id FROM users



									WHERE users.role_id = 10

									");



		return $query->result_array();

	}





	function get_tech_mgr($id) {

		$query = $this->db->query("

									SELECT users.id FROM users



									WHERE users.role_id = 11

									");



		return $query->result_array();

	}





	function get_pur_dpt_mgr($id) {

		$query = $this->db->query("

									SELECT users.id FROM users



									WHERE users.role_id = 12

									");



		return $query->result_array();

	}





	function get_acc_mgr($id) {

		$query = $this->db->query("

									SELECT users.id FROM users



									WHERE users.role_id = 13

									");



		return $query->result_array();

	}



	function get_hany($id) {

		$query = $this->db->query(' SELECT users.id FROM users WHERE users.id ='.$id);



		return $query->result_array();

	}



	function get_cpo($id) {

		$query = $this->db->query("

									SELECT users.id FROM users



									WHERE users.role_id = 40

									");



		return $query->result_array();

	}





	function get_inv_dpt_mgr($id) {

		$query = $this->db->query("

									SELECT users.id FROM users



									WHERE users.role_id = 14

									");



		return $query->result_array();

	}



	function get_con_acc_mgr($id) {

		$query = $this->db->query("

									SELECT users.id FROM users



									WHERE users.role_id = 15

									");



		return $query->result_array();

	}



	function get_src_dpt_head($id) {

		$query = $this->db->query("

									SELECT users.id FROM forms



									JOIN employees_hotels ON forms.from_hotel_id = employees_hotels.hotel_id



									JOIN users ON employees_hotels.employee_id = users.id



									WHERE forms.id = {$id}

									AND users.role_id = 7

									AND users.department_id = forms.department_id

									");



		return $query->result_array();

	}
	function get_src_amen_m5zn($id) {

		$query = $this->db->query("

									SELECT users.id FROM forms



									JOIN employees_hotels ON forms.from_hotel_id = employees_hotels.hotel_id



									JOIN users ON employees_hotels.employee_id = users.id



									WHERE forms.id = {$id}

									AND users.role_id = 111

									");



		return $query->result_array();

	}

function get_src_msaol_m5zn($id) {

		$query = $this->db->query("

									SELECT users.id FROM forms



									JOIN employees_hotels ON forms.from_hotel_id = employees_hotels.hotel_id



									JOIN users ON employees_hotels.employee_id = users.id



									WHERE forms.id = {$id}

									AND users.role_id = 13

									");



		return $query->result_array();

	}

function get_src_pro($id) {

		$query = $this->db->query("

									SELECT users.id FROM forms



									JOIN employees_hotels ON forms.from_hotel_id = employees_hotels.hotel_id



									JOIN users ON employees_hotels.employee_id = users.id



									WHERE forms.id = {$id}

									AND users.role_id = 140

									");



		return $query->result_array();

	}



		function get_src_hotel_gm($id) {

		$query = $this->db->query("

									SELECT users.id FROM forms



									JOIN employees_hotels ON forms.from_hotel_id = employees_hotels.hotel_id



									JOIN users ON employees_hotels.employee_id = users.id



									WHERE forms.id = {$id}

									AND users.role_id = 6

									");



		return $query->result_array();

	}



		function get_src_hotel_fc($id) {

		$query = $this->db->query("

									SELECT users.id FROM forms



									JOIN employees_hotels ON forms.from_hotel_id = employees_hotels.hotel_id



									JOIN users ON employees_hotels.employee_id = users.id



									WHERE forms.id = {$id}

									AND users.role_id = 5

									");



		return $query->result_array();

	}



		function get_dstn_dpt_head($id) {

		$query = $this->db->query("

									SELECT users.id FROM forms



									JOIN employees_hotels ON forms.to_hotel_id = employees_hotels.hotel_id



									JOIN users ON employees_hotels.employee_id = users.id



									WHERE forms.id = {$id}

									AND users.role_id = 7

									AND users.department_id = forms.department_id

									");



		return $query->result_array();

	}



		function get_dstn_hotel_gm($id) {

		$query = $this->db->query("

									SELECT users.id FROM forms



									JOIN employees_hotels ON forms.to_hotel_id = employees_hotels.hotel_id



									JOIN users ON employees_hotels.employee_id = users.id



									WHERE forms.id = {$id}

									AND users.role_id = 6

									");



		return $query->result_array();

	}



		function get_dstn_hotel_fc($id) {

		$query = $this->db->query("

									SELECT users.id FROM forms



									JOIN employees_hotels ON forms.to_hotel_id = employees_hotels.hotel_id



									JOIN users ON employees_hotels.employee_id = users.id



									WHERE forms.id = {$id}

									AND users.role_id = 5

									");



		return $query->result_array();

	}



	function get_fin_cluster_fc($id) {

		$query = $this->db->query("

									SELECT users.id FROM users

									WHERE users.role_id = 4

									");



		return $query->result_array();

	}
function get_fin_rgm($id) {

		$query = $this->db->query("

									SELECT users.id FROM users

									WHERE users.role_id =17

									");



		return $query->result_array();

	}


	function get_fin_rdof($id) {

		$query = $this->db->query("

									SELECT users.id FROM users

									WHERE users.role_id = 3

									");



		return $query->result_array();

	}



	function get_fin_chrmn_cai($id) {

		$query = $this->db->query("

									SELECT users.id FROM users

									WHERE users.role_id = 2

									");



		return $query->result_array();

	}

	function get_fin_chairman($id) {
		$query = $this->db->query("
									SELECT users.id,users.channel FROM users
									WHERE users.role_id = 1
									");

		return $query->result_array();
	}



	function get_rcv_user($id) {

		$query = $this->db->query("

									SELECT users.id FROM forms



									JOIN employees_hotels ON forms.to_hotel_id = employees_hotels.hotel_id



									JOIN users ON employees_hotels.employee_id = users.id



									WHERE forms.id = {$id}

									AND users.department_id = forms.department_id

									");



		return $query->result_array();

	}



	function get_rcv_hotel_acc($id) {

		$query = $this->db->query("

									SELECT users.id FROM forms



									JOIN employees_hotels ON forms.to_hotel_id = employees_hotels.hotel_id



									JOIN users ON employees_hotels.employee_id = users.id



									WHERE forms.id = {$id}

									AND users.role_id = 8

									");



		return $query->result_array();

	}



	function get_rcv_dpt_head($id) {

		$query = $this->db->query("

									SELECT users.id FROM forms



									JOIN employees_hotels ON forms.to_hotel_id = employees_hotels.hotel_id



									JOIN users ON employees_hotels.employee_id = users.id



									WHERE forms.id = {$id}

									AND users.role_id = 7

									");



		return $query->result_array();

	}



	function get_rcv_chrmn_cai($id) {

		$query = $this->db->query("

									SELECT users.id FROM users

									WHERE users.role_id = 2

									");



		return $query->result_array();

	}

	function get_atef($id) {

		$query = $this->db->query("

									SELECT users.id FROM users



									WHERE users.role_id = 25

									");



		return $query->result_array();

	}

	function get_sayed($id) {

		$query = $this->db->query("

									SELECT users.id FROM users



									WHERE users.role_id = 24

									");



		return $query->result_array();

	}

	function get_hesham($id) {

		$query = $this->db->query("

									SELECT users.id FROM users



									WHERE users.role_id IN (26,27)
									");



		return $query->result_array();

	}


	function get_users($id) {

		$query = $this->db->query("

									SELECT user_id AS user,

									rcv_user_id AS rcv_user, rcv_hotel_acc_id AS rcv_hotel_acc, rcv_dpt_head_id AS rcv_dpt_head, rcv_chrmn_cai_id AS rcv_chrmn_cai,

									src_dpt_head_id AS src_dpt_head, src_hotel_gm_id AS src_hotel_gm, src_hotel_fc_id AS src_hotel_fc,

									dstn_dpt_head_id AS dstn_dpt_head, dstn_hotel_gm_id AS dstn_hotel_gm, dstn_hotel_fc_id AS dstn_hotel_fc,

									fin_cluster_fc_id AS fin_cluster_fc, fin_rdof_id AS fin_rdof, fin_chrmn_cai_id AS fin_chrmn_cai



									FROM forms

									WHERE forms.id = {$id}

									");



		return $query->row_array();

	}





	function get_src_users($id) {

		$query = $this->db->query("

									SELECT src_users.id, src_users.email FROM forms



									JOIN employees_hotels AS from_hotel_users ON forms.from_hotel_id = from_hotel_users.hotel_id



									JOIN users AS src_users ON from_hotel_users.employee_id = src_users.id



									WHERE forms.id = {$id}

									AND src_users.role_id IN(5,6,7)

									AND src_users.department_id IN(1,forms.department_id)

									");



		return $query->result_array();

	}



	function get_dstn_users($id) {

		$query = $this->db->query("

									SELECT dstn_users.id, dstn_users.email FROM forms



									JOIN employees_hotels AS to_hotel_users ON forms.to_hotel_id = to_hotel_users.hotel_id



									JOIN users AS dstn_users ON to_hotel_users.employee_id = dstn_users.id



									WHERE forms.id = {$id}

									AND dstn_users.role_id IN(5,6,7)

									AND dstn_users.department_id IN(1,forms.department_id)

									");



		return $query->result_array();

	}



		function get_fin_users($id) {

		$query = $this->db->query("

									SELECT users.id, users.email FROM users

									WHERE users.role_id IN(2,3,4)

									");



		return $query->result_array();

	}






	function getform($id) {

  	  	$this->load->database();



  	  	$this->db->select('

  	  					forms.id, forms.issue_date, forms.delivery_date,forms.from_hotel_id,forms.to_hotel_id, departments.name AS department_name, forms.location, forms.movement_reason, forms.old_reason, forms.destination,

						from_hotels.name AS from_hotel, to_hotels.name AS to_hotel,


						from_company.name AS from_company, to_company.name AS to_company,



						rcv_user_users.id AS rcv_user_id, rcv_user_users.fullname AS rcv_user_fullname , rcv_user_users.signature AS rcv_user_signature, rcv_user_roles.role AS rcv_user_role, forms.rcv_user_date,

						rcv_hotel_acc_users.id AS rcv_hotel_acc_id, rcv_hotel_acc_users.fullname AS rcv_hotel_acc_fullname, rcv_hotel_acc_users.signature AS rcv_hotel_acc_signature,

						rcv_dpt_head_users.id AS rcv_dpt_head_id, rcv_dpt_head_users.fullname AS rcv_dpt_head_fullname, rcv_dpt_head_users.signature AS rcv_dpt_head_signature,

						rcv_chrmn_cai_users.id AS rcv_chrmn_cai_id, rcv_chrmn_cai_users.fullname AS rcv_chrmn_cai_fullname, rcv_chrmn_cai_users.signature AS rcv_chrmn_cai_signature,

						src_amen_m5zn_users.id AS src_amen_m5zn_id, src_amen_m5zn_users.fullname AS src_amen_m5zn_fullname, src_amen_m5zn_users.signature AS src_amen_m5zn_signature,

						src_msaol_m5zn_users.id AS src_msaol_m5zn_id, src_msaol_m5zn_users.fullname AS src_msaol_m5zn_fullname, src_msaol_m5zn_users.signature AS src_msaol_m5zn_signature,

						src_pro_users.id AS src_pro_id, src_pro_users.fullname AS src_pro_fullname, src_pro_users.signature AS src_pro_signature,


						src_dpt_head_users.id AS src_dpt_head_id, src_dpt_head_users.fullname AS src_dpt_head_fullname, src_dpt_head_users.signature AS src_dpt_head_signature,

						src_hotel_gm_users.id AS src_hotel_gm_id, src_hotel_gm_users.fullname AS src_hotel_gm_fullname, src_hotel_gm_users.signature AS src_hotel_gm_signature,

						src_hotel_fc_users.id AS src_hotel_fc_id, src_hotel_fc_users.fullname AS src_hotel_fc_fullname, src_hotel_fc_users.signature AS src_hotel_fc_signature,

						dstn_dpt_head_users.id AS dstn_dpt_head_id, dstn_dpt_head_users.fullname AS dstn_dpt_head_fullname, dstn_dpt_head_users.signature AS dstn_dpt_head_signature,

						dstn_hotel_gm_users.id AS dstn_hotel_gm_id, dstn_hotel_gm_users.fullname AS dstn_hotel_gm_fullname, dstn_hotel_gm_users.signature AS dstn_hotel_gm_signature,

						dstn_hotel_fc_users.id AS dstn_hotel_fc_id, dstn_hotel_fc_users.fullname AS dstn_hotel_fc_fullname, dstn_hotel_fc_users.signature AS dstn_hotel_fc_signature,

						fin_cluster_fc_users.id AS fin_cluster_fc_id, fin_cluster_fc_users.fullname AS fin_cluster_fc_fullname, fin_cluster_fc_users.signature AS fin_cluster_fc_signature,

						fin_rgm_users.id AS fin_rgm_id, fin_rgm_users.fullname AS fin_rgm_fullname, fin_rgm_users.signature AS fin_rgm_signature,

						fin_rdof_users.id AS fin_rdof_id, fin_rdof_users.fullname AS fin_rdof_fullname, fin_rdof_users.signature AS fin_rdof_signature,

						fin_chrmn_cai_users.id AS fin_chrmn_cai_id, fin_chrmn_cai_users.fullname AS fin_chrmn_cai_fullname, fin_chrmn_cai_users.signature AS fin_chrmn_cai_signature,
						fin_chairman_users.id AS fin_chairman_id, fin_chairman_users.fullname AS fin_chairman_fullname, fin_chairman_users.signature AS fin_chairman_signature,

						form_states.id AS form_state_id, form_states.state AS form_state'

						);



  	  	$this->db->join('hotels AS from_hotels','forms.from_hotel_id = from_hotels.id');

  	  	$this->db->join('hotels AS to_hotels','forms.to_hotel_id = to_hotels.id');
  	  

  	  	$this->db->join('companies AS from_company','from_hotels.company_id = from_company.id');

  	  	$this->db->join('companies AS to_company','to_hotels.company_id = to_company.id');

  	  	$this->db->join('departments','forms.department_id = departments.id');



  	  	$this->db->join('users AS rcv_user_users','forms.rcv_user_id = rcv_user_users.id', 'left');

  	  	$this->db->join('users AS rcv_hotel_acc_users','forms.rcv_hotel_acc_id = rcv_hotel_acc_users.id', 'left');

  	  	$this->db->join('users AS rcv_dpt_head_users','forms.rcv_dpt_head_id = rcv_dpt_head_users.id', 'left');

  	  	$this->db->join('users AS rcv_chrmn_cai_users','forms.rcv_chrmn_cai_id = rcv_chrmn_cai_users.id', 'left');

//crazy water
        $this->db->join('users AS src_amen_m5zn_users','forms.src_amen_m5zn_id = src_amen_m5zn_users.id', 'left');

  	  	$this->db->join('users AS src_msaol_m5zn_users','forms.src_msaol_m5zn_id = src_msaol_m5zn_users.id', 'left');

  	  	$this->db->join('users AS src_pro_users','forms.src_pro_id = src_pro_users.id', 'left');

  	  	  $this->db->join('users AS fin_rgm_users','forms.fin_rgm_id = fin_rgm_users.id', 'left');
///////////////////////

  	  	$this->db->join('users AS src_dpt_head_users','forms.src_dpt_head_id = src_dpt_head_users.id', 'left');

  	  	$this->db->join('users AS src_hotel_gm_users','forms.src_hotel_gm_id = src_hotel_gm_users.id', 'left');

  	  	$this->db->join('users AS src_hotel_fc_users','forms.src_hotel_fc_id = src_hotel_fc_users.id', 'left');



  	  	$this->db->join('users AS dstn_dpt_head_users','forms.dstn_dpt_head_id = dstn_dpt_head_users.id', 'left');

  	  	$this->db->join('users AS dstn_hotel_gm_users','forms.dstn_hotel_gm_id = dstn_hotel_gm_users.id', 'left');

  	  	$this->db->join('users AS dstn_hotel_fc_users','forms.dstn_hotel_fc_id = dstn_hotel_fc_users.id', 'left');





  	  	$this->db->join('users AS fin_cluster_fc_users','forms.fin_cluster_fc_id = fin_cluster_fc_users.id', 'left');

  	  	$this->db->join('users AS fin_rdof_users','forms.fin_rdof_id = fin_rdof_users.id', 'left');

  	  	$this->db->join('users AS fin_chrmn_cai_users','forms.fin_chrmn_cai_id = fin_chrmn_cai_users.id', 'left');

  	  	$this->db->join('users AS fin_chairman_users','forms.fin_chairman_id = fin_chairman_users.id', 'left');


  	  	$this->db->join('roles AS rcv_user_roles', 'rcv_user_users.role_id = rcv_user_roles.id', 'left');



  	  	$this->db->join('form_states','forms.state_id = form_states.id');







  	  	$this->db->where('forms.id', $id);

	

		$query = $this->db->get('forms');



		return ($query->num_rows() > 0 )? $query->row_array() : FALSE;

	}



	function create($data) {

		$this->db->insert('forms', $data);



		return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;



	}
function get_from_owning($id){
		$this->db->where('forms.id',$id);
		$this->db->select('forms.from_hotel_owning,companies.name AS from_hotel_owning_name');
		$this->db->join('companies','forms.from_hotel_owning = companies.id','left');
         $query = $this->db->get('forms');
         return $query->row_array();
	}
function get_to_owning($id){
		$this->db->where('forms.id',$id);
		$this->db->select('forms.to_hotel_owning,companies.name AS to_hotel_owning_name');
	    $this->db->join('companies','forms.to_hotel_owning = companies.id','left');
         $query = $this->db->get('forms');
         return $query->row_array();
	}
	function get_owning_form($id) {
  	  	$this->load->database();

  	  	$this->db->select('
  	  					forms.id, forms.issue_date, forms.delivery_date, departments.name AS department_name, forms.location, forms.movement_reason, forms.destination,
						from_hotels.name AS from_hotel, to_hotels.name AS to_hotel,
						from_company.name AS from_company, to_company.name AS to_company,

						hany_users.id AS hany_id, hany_users.fullname AS hany_fullname, hany_users.signature AS hany_signature,
						pur_sec_mgr_users.id AS pur_sec_mgr_id, pur_sec_mgr_users.fullname AS pur_sec_mgr_fullname, pur_sec_mgr_users.signature AS pur_sec_mgr_signature,
						tech_mgr_users.id AS tech_mgr_id, tech_mgr_users.fullname AS tech_mgr_fullname, tech_mgr_users.signature AS tech_mgr_signature,
						pur_dpt_mgr_users.id AS pur_dpt_mgr_id, pur_dpt_mgr_users.fullname AS pur_dpt_mgr_fullname, pur_dpt_mgr_users.signature AS pur_dpt_mgr_signature,
						acc_mgr_users.id AS acc_mgr_id, acc_mgr_users.fullname AS acc_mgr_fullname, acc_mgr_users.signature AS acc_mgr_signature,
						inv_dpt_mgr_users.id AS inv_dpt_mgr_id, inv_dpt_mgr_users.fullname AS inv_dpt_mgr_fullname, inv_dpt_mgr_users.signature AS inv_dpt_mgr_signature,
						con_acc_mgr_users.id AS con_acc_mgr_id, con_acc_mgr_users.fullname AS con_acc_mgr_fullname, con_acc_mgr_users.signature AS con_acc_mgr_signature,
						cpo_users.id AS cpo_id, cpo_users.fullname AS cpo_fullname, cpo_users.signature AS cpo_signature,

						form_states.id AS form_state_id, form_states.state AS form_state'
						);

  	  	$this->db->join('hotels AS from_hotels','forms.from_hotel_id = from_hotels.id');
  	  	$this->db->join('hotels AS to_hotels','forms.to_hotel_id = to_hotels.id');
  	  	$this->db->join('companies AS from_company','from_hotels.company_id = from_company.id');
  	  	$this->db->join('companies AS to_company','to_hotels.company_id = to_company.id');
  	  	$this->db->join('departments','forms.department_id = departments.id');

  	  	$this->db->join('users AS hany_users','forms.hany_id = hany_users.id', 'left');
  	  	$this->db->join('users AS pur_sec_mgr_users','forms.pur_sec_mgr_id = pur_sec_mgr_users.id', 'left');
  	  	$this->db->join('users AS tech_mgr_users','forms.tech_mgr_id = tech_mgr_users.id', 'left');
  	  	$this->db->join('users AS pur_dpt_mgr_users','forms.pur_dpt_mgr_id = pur_dpt_mgr_users.id', 'left');
  	  	$this->db->join('users AS acc_mgr_users','forms.acc_mgr_id = acc_mgr_users.id', 'left');
  	  	$this->db->join('users AS inv_dpt_mgr_users','forms.inv_dpt_mgr_id = inv_dpt_mgr_users.id', 'left');
  	  	$this->db->join('users AS con_acc_mgr_users','forms.con_acc_mgr_id = con_acc_mgr_users.id', 'left');
  	  	$this->db->join('users AS cpo_users','forms.cpo_id = cpo_users.id', 'left');

  	  	$this->db->join('form_states','forms.state_id = form_states.id');



  	  	$this->db->where('forms.id', $id);
	
		$query = $this->db->get('forms');

		return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
	}

	function get_owning_form_holidays($id) {
  	  	$this->load->database();

  	  	$this->db->select('
  	  					forms.id, forms.issue_date, forms.delivery_date, departments.name AS department_name, forms.location, forms.movement_reason, forms.destination,
						from_hotels.name AS from_hotel, to_hotels.name AS to_hotel,
						from_company.name AS from_company, to_company.name AS to_company,

						atef_users.id AS atef_id, atef_users.fullname AS atef_fullname, atef_users.signature AS atef_signature,

						sayed_users.id AS sayed_id, sayed_users.fullname AS sayed_fullname, sayed_users.signature AS sayed_signature,

						hesham_users.id AS hesham_id, hesham_users.fullname AS hesham_fullname, hesham_users.signature AS hesham_signature,

						nadin_users.id AS nadin_id, nadin_users.fullname AS nadin_fullname, nadin_users.signature AS nadin_signature,

						form_states.id AS form_state_id, form_states.state AS form_state'
						);

  	  	$this->db->join('hotels AS from_hotels','forms.from_hotel_id = from_hotels.id');
  	  	$this->db->join('hotels AS to_hotels','forms.to_hotel_id = to_hotels.id');
  	  	$this->db->join('companies AS from_company','from_hotels.company_id = from_company.id');
  	  	$this->db->join('companies AS to_company','to_hotels.company_id = to_company.id');
  	  	$this->db->join('departments','forms.department_id = departments.id');

  	  	$this->db->join('users AS atef_users','forms.atef_id = atef_users.id', 'left');
  	  	$this->db->join('users AS sayed_users','forms.sayed_id = sayed_users.id', 'left');
  	  	$this->db->join('users AS hesham_users','forms.hesham_id = hesham_users.id', 'left');
  	  	$this->db->join('users AS nadin_users','forms.nadin_id = nadin_users.id', 'left');
  	  	
  	  	$this->db->join('form_states','forms.state_id = form_states.id');



  	  	$this->db->where('forms.id', $id);
	
		$query = $this->db->get('forms');

		return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
	}

  function update_message_id($id, $message_id) {
		    $this->db->where('forms.id', $id);
		    $msg_id = $this->db->update('forms', array('message_id' => $message_id));
		} 

	function get_message_id($form_id){
        $this->db->where('forms.id',$form_id);
        $query = $this->db->get('forms');
        return $query->row_array();
	}	

}

?>

