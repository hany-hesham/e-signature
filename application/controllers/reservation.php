<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class reservation extends CI_Controller {

private $crud;
	public function __construct() {
		parent::__construct();
		$this->data['demo'] = $this->input->get('demo_user');

		$this->load->database(); // load database

		$this->load->library('Grocery_CRUD');
		$this->load->library('extension_grocery_CRUD');
		$this->crud = new Extension_grocery_CRUD();
        $this->load->helper('url');
		$this->load->library('email');


		$this->load->library('Tank_auth');
		if (!$this->data['demo']) {

			if (!$this->tank_auth->is_logged_in()) {
				$redirect_path = '/'.$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);
				$this->session->set_flashdata('redirect', $redirect_path);
				redirect('/auth/login');
			} else {
				$this->data['user_id'] = $this->tank_auth->get_user_id();
				$this->data['username'] = $this->tank_auth->get_username();
				$this->data['is_admin'] = $this->tank_auth->is_admin();
				$this->data['owning_company'] = $this->tank_auth->is_owning_company();
      			$this->data['department_id'] = $this->tank_auth->get_department();
      			$this->data['role_id'] = $this->tank_auth->get_role();     
      			$this->data['chairman'] = $this->tank_auth->is_chairman();
				$this->data['is_corp'] = $this->tank_auth->is_corp();
				$this->data['is_rater'] = $this->tank_auth->is_rater();
      			$this->data['is_cairo'] = $this->tank_auth->is_cairo();
      			$this->data['is_sky'] = $this->tank_auth->is_sky();
      			$this->data['isnt_UK'] = $this->tank_auth->isnt_UK();
      			$this->data['isnt_sky'] = $this->tank_auth->isnt_sky();
      			$this->data['isnt_Cairo'] = $this->tank_auth->isnt_Cairo();
      			$this->data['is_UK'] = $this->tank_auth->is_UK();
      			$this->data['is_claim'] = $this->tank_auth->is_claim();
      			$this->data['is_fc'] = $this->tank_auth->is_fc();
            	$this->data['is_cluster'] = $this->tank_auth->is_cluster();
			}
			}

		$this->data['menu']['active'] = "reserve";
		$this->load->library('logger');
		$this->data['module'] = "comp_reservation";
		$this->load->library('pushover');
		$this->pushover->set_key($this->data['module']);

     $this->load->model('reservation_model'); // load model



}


	public function index(){
		if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
	      	redirect('/unknown');
		}else{
			$this->load->model('hotels_model');
			$user_hotels = $this->hotels_model->getby_user($this->data['user_id']);

		$hotels = array();
			foreach ($user_hotels as $hotel) {
				$hotels[] = $hotel['id'];
			}
			$this->data['hotels'] = $user_hotels;
			$this->data['users'] = $this->reservation_model->GET_all_Users();

		$this->data['forma_res'] = $this->reservation_model->get_forma_res($hotels);
		$this->data['GET_Users_Who_Sign'] = $this->reservation_model->GET_Users_Who_Sign();



	   $this->load->view('get_all_reservation', $this->data);


		}
	}


	public function Comment(){
		$this->reservation_model->InsertComment();
		$form_id = $this->input->post('form_id');

		$users = $this->reservation_model->Get_all_users_signed($form_id);
		$this->load->model("Notification_keys_model");

		foreach ($users as $user) {

			$this->email->from('e-signature@sunrise-resorts.com');
			$this->email->to($user['email']);

			$this->email->subject(" Reservation New Comment {$form_id} ");
			$this->email->message("Dear ".$user['fullname'].",<br/>
								<br/>
								There's a new comment On Reservation {$form_id} , Please use the link below
								<a href='{$spo_url}' target='_blank'>{$spo_url}</a><br/>

								");

			$mail_result = $this->email->send();
			//get notification keys
			$notification_keys = $this->Notification_keys_model->getby_mail($this->data['module'], $user['email']);
			//send notification
			foreach ($notification_keys as $key) {
			$this->pushover->send(array('title' => " Reservation New Comment {$form_id} ",
							'message' => "Dear ".$user['fullname'].",<br/>
								<br/>
								There's a new comment On Reservation {$form_id} , Please use the link below:<br/>
								<a href='{$spo_url}' target='_blank'>{$spo_url}</a><br/>"),$key['token']);
			}
		}

	}


	private function do_upload($field) {

		$config['upload_path'] = 'assets/uploads/files/';
		$config['allowed_types'] = '*';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload($field))
		{
			$this->data['error'] = array('error' => $this->upload->display_errors());
			return FALSE;
		}
		else
		{
			$file = $this->upload->data();
			return $file['file_name'];

		}
	}

	public function add_files($res_id) {
		$file_name = $this->do_upload("files");
		if (!$file_name) {
			die(json_encode($this->data['error']));
		} else {
			$this->load->model("res_file");
			$this->res_file->add($res_id, $file_name);
			$this->logger->log_event($this->data['user_id'], "Upload", "res_filex", $res_id, json_encode(array("file_name" => $file_name)), "user uploaded a file");//log
			die("{}");
		}
	}

	public function remove_files($res_id, $id) {
		$file_name = $_POST['key'];

		if (!$id) {
			die(json_encode($this->data['error']));
		} else {
			$this->load->model("res_file");
			$this->res_file->remove($id);
			$this->logger->log_event($this->data['user_id'], "Upload-Remove", "reservations", $res_id, json_encode(array("file_id" => $id, "file_name" => $file_name)), "user removed a file");//log

			die("{}");
		}
	}


		public function mailto($code) {
		if ($this->input->post('submit')) {

			$this->load->library('form_validation');

			$this->form_validation->set_rules('message','message is required','trim|required');
			$this->form_validation->set_rules('mail','mail is required','trim|required');

	    	if ($this->form_validation->run() == TRUE) {

	    		$message = $this->input->post('message');
	    		$mail = $this->input->post('mail');


				$user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);

				$this->load->library('email');
				$this->load->helper('url');

				$forma_url = base_url().'reservation/view/'.$code;

				$this->email->from('e-project@sunrise-resorts.com', 'Reservation Comp');
				$this->email->to($mail);

				$this->email->subject("A message from {$user->fullname}, Forma {$code}");
				$this->email->message("{$user->fullname} sent you a private message regarding Reservation Comp {$code} :
					<br/>
									{$message}<br />
									<br />

									Please use the link below to view the Reservation Forma:
									<a href='{$forma_url}'>{$forma_url}</a><br/>

									");

				$mail_result = $this->email->send();

	    		$this->load->model("Notification_keys_model");
				//get notification keys
	    		$notification_keys = $this->Notification_keys_model->getby_mail($this->data['module'], $mail);
				//send notification
				foreach ($notification_keys as $key) {
				$this->pushover->send(array('title' => "A message from {$user->fullname}, Forma {$code}",
								'message' => "{$user->fullname} sent you a private message regarding Reservation Comp {$code} :
									<br/>
									{$message}<br />
									<br />

									Please use the link below to view the Reservation Forma:
									<a href='{$forma_url}'>{$forma_url}</a><br/>"), $key['token']);
				}
			}
		}
		redirect('/reservation/view/'.$code);
	}

	public function mailme($code) {
        $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
        $this->load->library('email');
        $this->load->helper('url');
        $forma_url = base_url().'reservation/view/'.$code;
        $this->email->from('e-signature@sunrise-resorts.com');
        $this->email->to($user->email);
        $this->email->subject("Reservation Comp NO.#{$code}");
        $this->email->message("Reservation Comp NO.#{$code}:<br/>
                  Please use the link below to view the Reservation Comp:
                  <a href='{$forma_url}' target='_blank'>{$forma_url}</a><br/>
                "); 
        $mail_result = $this->email->send();
        redirect('reservation/view/'.$code);
  }




/*public function submit() {
	if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
      	redirect('/unknown');
	}else{

	$this->data['types'] = $this->reservation_model->get_type();
	$this->data['get_last_id'] = $this->reservation_model->get_last_id();



	$this->data['boards'] = $this->reservation_model->get_board_type();
	$this->data['discounts'] = $this->reservation_model->get_discount();

	$this->data['res_type'] = $this->reservation_model->get_res_type();

	$this->data['companies'] = $this->reservation_model->get_ompanies();

	$this->data['room_type'] = $this->reservation_model->get_room_type();
	$this->data['num'] = $this->reservation_model->rand6(1,99999);


	$this->data['hotels'] = $this->reservation_model->getby_user($this->data['user_id']);
	$this->load->view('res_submit', $this->data);// loading form view
}
}*/


public function view($view = NULL) {
	if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
      	redirect('/unknown');
	}else{

	$form_id = $this->uri->segment(3);


	$this->data['comments'] = $this->reservation_model->getby_forma($form_id);

	$this->data['GET_Users_Who_Sign'] = $this->reservation_model->GET_Users_Who_Sign();
	$this->data['get_role_user'] = $this->reservation_model->Get_role_id($this->tank_auth->get_user_id(),$form_id);

	$this->data['get_forma_content'] = $this->reservation_model->get_forma_content($view);

	$this->data['Get_last_sign_user'] = $this->reservation_model->Get_last_sign($view);
	$this->data['get_attached_files'] = $this->reservation_model->get_attached_files($form_id);
	$this->load->view('get_forma_content', $this->data);// loading form view

}
}



	public function approve()

	{
		$user_id = $this->uri->segment(3);
		$forma_id = $this->uri->segment(4);
		$role_id = $this->uri->segment(5);
		$hotel_id = $this->uri->segment(6);
		$res_url = base_url().'reservation/view/'.$forma_id;

		$this->reservation_model->approve($user_id,$forma_id,$role_id);

		$who_should_next = $this->reservation_model->GET_who_should_next($forma_id,$hotel_id);
		$creator = $this->reservation_model->get_forma_user($forma_id);

		if (!isset($who_should_next->email)) {

			$this->email->from('e-signature@sunrise-resorts.com');
			// $this->email->cc('abbas.elshabasy@sunrise-resorts.com');//for now
			$this->email->to($creator[0]['email']);

			$this->email->subject("Comp request #{$forma_id}");
			$this->email->message("Dear {$creator[0]['fullname']},<br/>
								<br/>
								Complementary reservation Forma id {$forma_id} has been signed, Please use the link below to check
								<a href='{$res_url}' target='_blank'>{$res_url}</a><br/>

								");

			$mail_result = $this->email->send();

		} else {



			if ($role_id == 2) {
				$this->email->from('e-signature@sunrise-resorts.com');
				// $this->email->cc('abbas.elshabasy@sunrise-resorts.com');//for now
				$this->email->to($creator[0]['email']);

				$this->email->subject("Comp request #{$forma_id}");
				$this->email->message("Dear {$creator[0]['fullname']},<br/>
									<br/>
									Chairman approved your complementary reservation Forma id {$forma_id} , Please use the link below to check
									<a href='{$res_url}' target='_blank'>{$res_url}</a><br/>

									");

				$mail_result = $this->email->send();
				
			}



			$this->email->from('e-signature@sunrise-resorts.com');
			// $this->email->cc('abbas.elshabasy@sunrise-resorts.com');//for now
			$this->email->to($who_should_next->email);

			$this->email->subject("Comp request #{$forma_id}");
			$this->email->message("Dear {$who_should_next->fullname},<br/>
								<br/>
								WE need your approve on complementary reservation Forma id {$forma_id} , Please use the link below
								<a href='{$res_url}' target='_blank'>{$res_url}</a><br/>

								");

			$mail_result = $this->email->send();
		}

		redirect('/reservation/view/'.$forma_id);


	}



	public function reject()

	{
		$user_id = $this->uri->segment(3);
		$forma_id = $this->uri->segment(4);
		$role_id = $this->uri->segment(5);

		$this->reservation_model->reject($user_id,$forma_id,$role_id);

		$creator = $this->reservation_model->get_forma_user($forma_id);

		$this->email->from('e-signature@sunrise-resorts.com');
		// $this->email->cc('abbas.elshabasy@sunrise-resorts.com');//for now
		$this->email->to($creator[0]['email']);

		$this->email->subject("Comp request #{$forma_id}");
		$this->email->message("Dear {$creator[0]['fullname']},<br/>
							<br/>
							Complementary reservation Forma id {$forma_id} has been rejected! Please use the link below to check
							<a href='{$res_url}' target='_blank'>{$res_url}</a><br/>

							");

		$mail_result = $this->email->send();


		redirect('/reservation/view/'.$forma_id);



	}





	public function insert_into_db() {
		$forma_id = $this->reservation_model->insert_to_db();
		$assumed_id = $this->reservation_model->update_upload_file($forma_id,$this->input->post('assumed_id'));

		$who_should_next = $this->reservation_model->GET_who_should_next($forma_id,$this->input->post('hotel'));

		$res_url = base_url().'reservation/view/'.$forma_id;

		$this->email->from('e-signature@sunrise-resorts.com');
		$this->email->to($who_should_next->email);
		// $this->email->cc('abbas.elshabasy@sunrise-resorts.com');//for now

		$this->email->subject("Comp request #{$forma_id}");
		$this->email->message("Dear {$who_should_next->fullname},<br/>
							<br/>
							WE need your approve on complementary reservation Forma id {$forma_id} , Please use the link below
							<a href='{$res_url}' target='_blank'>{$res_url}</a><br/>

							");

		$mail_result = $this->email->send();

		// exec('scripts/res_noti.sh "'.base_url().'reservation/view/" "'.$forma_id.'"');

		$this->data['get_forma_content'] = $this->reservation_model->get_forma_content($forma_id);
		$forma = $this->data['get_forma_content'][0];
		$message_contect = "<b>Hotel:</b>  {$forma['hotel_name']}
<b>Arrival:</b>  {$forma['arrival']}&nbsp;&nbsp;&nbsp;&nbsp;<b>Departure:</b>  {$forma['departure']}
<b>Adult:</b>  {$forma['adult']}&nbsp;&nbsp;&nbsp;&nbsp;<b>Child:</b>  {$forma['child']}&nbsp;&nbsp;&nbsp;&nbsp;<b>Rooms:</b>  {$forma['rooms']}
<b>Agent/Company:</b>{$forma['c_name']}
<b>Board Type:</b>  {$forma['board_type']}
<b>Rate:</b>  {$forma['rate']}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Discount:</b>  {$forma['discount']}%";

    // die($message_contect);

		$this->load->model("Notification_keys_model");
		//get notification keys
		$notification_keys = $this->Notification_keys_model->getby_user($this->data['module'], $who_should_next->id);
		//send notification
		foreach ($notification_keys as $key) {
		$this->pushover->send(array('title' => "Comp request #{$forma_id}",
						'message' => $message_contect."<br/><br/><a href='{$res_url}'>View form</a>"),$key['token']);
		}

		redirect('/reservation/view/'.$forma_id);

	}



	public function edit() {
		if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
      	redirect('/unknown');
	}else{

		try {

			$this->crud->set_theme('twitter-bootstrap');
			$this->crud->set_table('forma_res');
			$this->crud->fields(array('hotel','recived_by','name','discount','rate','board_type_id','arrival','departure','adult','child','rooms','room_type','company'));

			$this->crud->set_relation('hotel','hotels','name');

			$this->crud->set_relation('board_type_id','board_type','board_type');
			$this->crud->set_relation('company','Agent_Company','name');




			$output = $this->crud->render();
			$this->load->view('get_forma_edit', $output);
		}
		catch( Exception $e) {
			show_error($e->getMessage()." _ ". $e->getTraceAsString());
		}
	}
	}




}
