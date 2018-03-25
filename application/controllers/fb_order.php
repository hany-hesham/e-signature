<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class fb_order extends CI_Controller {

  	private $data;

  	public function __construct() {
    	parent::__construct();
    	$this->load->library('Tank_auth');
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
		    $this->data['chairman'] = $this->tank_auth->is_chairman();
		  }
	    $this->data['menu']['active'] = "fb_order";
	  }

    public function index() {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        $this->load->model('hotels_model');
        $this->load->model('fb_model');
        $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
        $hotels = array();
        foreach ($user_hotels as $hotel) {
          $hotels[] = $hotel['id'];
        }    
        $this->data['fb'] = $this->fb_model->view($hotels);
        foreach ($this->data['fb'] as $key => $fb) {
          $this->data['fb'][$key]['items'] = $this->fb_model->get_itemss($this->data['fb'][$key]['id']);
          $this->data['fb'][$key]['approvals'] = $this->fb_model->getby_verbals($this->data['fb'][$key]['id']);
        }
        $this->data['hotels'] = $this->hotels_model->getall();
        $this->data['types'] = $this->fb_model->getall_types();
        $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
        $this->load->view('fb_index', $this->data);
      }
    }

    public function index_app() {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        $this->load->model('hotels_model');
        $this->load->model('fb_model');
        $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
        $hotels = array();
        foreach ($user_hotels as $hotel) {
          $hotels[] = $hotel['id'];
        }    
        $this->data['fb'] = $this->fb_model->view_app($hotels);
        foreach ($this->data['fb'] as $key => $fb) {
          $this->data['fb'][$key]['items'] = $this->fb_model->get_itemss($this->data['fb'][$key]['id']);
          $this->data['fb'][$key]['approvals'] = $this->fb_model->getby_verbals($this->data['fb'][$key]['id']);
        }
        $this->data['hotels'] = $this->hotels_model->getall();
        $this->data['types'] = $this->fb_model->getall_types();
        $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
        $this->load->view('fb_index', $this->data);
      }
    }

    public function index_rej() {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        $this->load->model('hotels_model');
        $this->load->model('fb_model');
        $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
        $hotels = array();
        foreach ($user_hotels as $hotel) {
          $hotels[] = $hotel['id'];
        }    
        $this->data['fb'] = $this->fb_model->view_rej($hotels);
        foreach ($this->data['fb'] as $key => $fb) {
          $this->data['fb'][$key]['items'] = $this->fb_model->get_itemss($this->data['fb'][$key]['id']);
          $this->data['fb'][$key]['approvals'] = $this->fb_model->getby_verbals($this->data['fb'][$key]['id']);
        }
        $this->data['hotels'] = $this->hotels_model->getall();
        $this->data['types'] = $this->fb_model->getall_types();
        $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
        $this->load->view('fb_index', $this->data);
      }
    }

    public function index_wat() {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        if ($this->input->post('submit')) {
          $state = $this->input->post('state');
          $this->load->model('hotels_model');
          $this->load->model('fb_model');
          $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
          $hotels = array();
          foreach ($user_hotels as $hotel) {
            $hotels[] = $hotel['id'];
          }    
          $this->data['fb'] = $this->fb_model->view_wat($hotels, $state);
          foreach ($this->data['fb'] as $key => $fb) {
            $this->data['fb'][$key]['items'] = $this->fb_model->get_itemss($this->data['fb'][$key]['id']);
            $this->data['fb'][$key]['approvals'] = $this->fb_model->getby_verbals($this->data['fb'][$key]['id']);
          }
          $this->data['state'] = $state;
          $this->data['hotels'] = $user_hotels;
          $this->data['types'] = $this->fb_model->getall_types();
        }
        $this->load->view('fb_index_wat', $this->data);
      }
    }

    public function index_dev() {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        $this->load->model('hotels_model');
        $this->load->model('fb_model');
        $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
        $hotels = array();
        foreach ($user_hotels as $hotel) {
          $hotels[] = $hotel['id'];
        }    
        $this->data['fb'] = $this->fb_model->view_dev($hotels);
        foreach ($this->data['fb'] as $key => $fb) {
          $this->data['fb'][$key]['items'] = $this->fb_model->get_itemss($this->data['fb'][$key]['id']);
          $this->data['fb'][$key]['approvals'] = $this->fb_model->getby_verbals($this->data['fb'][$key]['id']);
        }
        $this->data['hotels'] = $this->hotels_model->getall();
        $this->data['types'] = $this->fb_model->getall_types();
        $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
        $this->load->view('fb_index', $this->data);
      }
    }

    public function type($fb_id) {
      $this->load->model('fb_model');
      if ($this->input->post('submit')) {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('ret_id','You Need To Chose a Type','trim|required');
        if ($this->form_validation->run() == TRUE) {
          $type = $this->input->post('ret_id');
          if ($type == '3') {
            redirect('/fb_order/retoure/'.$fb_id);
          }elseif ($type == '4') {
            redirect('/fb_order/cancel/'.$fb_id);
          }elseif ($type == '5') {
            redirect('/fb_order/show/'.$fb_id);
          }elseif ($type == '6') {
            redirect('/fb_order/deliver/'.$fb_id);
          }else{
            redirect('/fb_order');
          }
        }
      }
    }

    public function retoure($fb_id) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        if ($this->input->post('submit')) {
          $this->load->library('form_validation');
          $this->load->library('email');
          $this->form_validation->set_rules('reason','You Need To Enter a Reason','trim|required');
          if ($this->form_validation->run() == TRUE) {
            $this->load->model('fb_model');
            $this->load->model('users_model'); 
            $data = array(
              'user_id_reason' => $this->data['user_id'],
              'reason' => $this->input->post('reason'),
              'ret_id' => '3'
            ); 
            $this->fb_model->update_order($data, $fb_id);
            $this->data['fb'] = $this->fb_model->get_fb($fb_id);
            redirect('/fb_order');
          }   
        }
        try {
          $this->load->helper('form');
          $this->load->model('fb_model');
          $this->load->view('fb_add_reason',$this->data);
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
      }
    }

    public function cancel($fb_id) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        if ($this->input->post('submit')) {
          $this->load->library('form_validation');
          $this->load->library('email');
          $this->form_validation->set_rules('reason','You Need To Enter a Reason','trim|required');
          if ($this->form_validation->run() == TRUE) {
            $this->load->model('fb_model');
            $this->load->model('users_model'); 
            $data = array(
              'user_id_reason' => $this->data['user_id'],
              'reason' => $this->input->post('reason'),
              'ret_id' => '4'
            ); 
            $this->fb_model->update_order($data, $fb_id);
            $this->data['fb'] = $this->fb_model->get_fb($fb_id);
            redirect('/fb_order');
          }   
        }
        try {
          $this->load->helper('form');
          $this->load->model('fb_model');
          $this->load->view('fb_add_reason',$this->data);
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
      }
    }

    public function show($fb_id) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        if ($this->input->post('submit')) {
          $this->load->library('form_validation');
          $this->load->library('email');
          $this->form_validation->set_rules('reason','You Need To Enter a Reason','trim|required');
          if ($this->form_validation->run() == TRUE) {
            $this->load->model('fb_model');
            $this->load->model('users_model'); 
            $data = array(
              'user_id_reason' => $this->data['user_id'],
              'reason' => $this->input->post('reason'),
              'ret_id' => '5'
            ); 
            $this->fb_model->update_order($data, $fb_id);
            $this->data['fb'] = $this->fb_model->get_fb($fb_id);
            redirect('/fb_order');
          }   
        }
        try {
          $this->load->helper('form');
          $this->load->model('fb_model');
          $this->load->view('fb_add_reason',$this->data);
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
      }
    }

    public function deliver($fb_id) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        $this->load->model('fb_model');
        $this->load->model('users_model'); 
        $data = array(
          'user_id_reason' => $this->data['user_id'],
          'ret_id' => '6'
        ); 
        $this->fb_model->update_order($data, $fb_id);
        $this->data['fb'] = $this->fb_model->get_fb($fb_id);
        redirect('/fb_order');
        try {
          $this->load->helper('form');
          $this->load->model('fb_model');
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
      }
    }

  	public function add() {
    	if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
    	}else{
      	if ($this->input->post('submit')) {
        	$this->load->library('form_validation');
        	$this->load->library('email');
        	$this->form_validation->set_rules('hotel_id','Hotel Name','trim|required');
        	$this->form_validation->set_rules('room','Room Number','trim|required');
       		if ($this->form_validation->run() == TRUE) {
          	$this->load->model('fb_model');
          	$this->load->model('users_model');  
			      $data = array(
				      'user_id' => $this->data['user_id'],
				      'hotel_id' => $this->input->post('hotel_id')
			      );
				    $fb_id = $this->fb_model->create_fb($data);
				    if (!$fb_id) {
				      die("ERROR");
				    }
				    $room = $this->input->post('room');
    			  $rooms = explode(" ",$room);
    			  foreach ($rooms as $room) {
           		$form_data = array(
  				      'room' => $room,
  				      'fb_id' => $fb_id
  				    );
  				    $item_id = $this->fb_model->create_room($form_data);
  				    if (!$item_id) {
  				      die("ERROR");
  				    }
    			  }
        	  redirect('/fb_order/submit/'.$fb_id);
			    }
			  }
  			try {
			    $this->load->helper('form');
			    $this->load->model('fb_model');
			    $this->load->model('hotels_model');
			    $this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());
			    $this->load->view('fb_add',$this->data);
      	}
		    catch( Exception $e) {
		      show_error($e->getMessage()." _ ". $e->getTraceAsString());
		    }
    	}
		}

    public function submit($fb_id) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        if ($this->input->post('submit')) {
          $this->load->library('form_validation');
          $this->load->library('email');
          if ($this->form_validation->run() == FALSE) {
            $this->load->model('fb_model');
            $this->load->model('users_model');  
            foreach ($this->input->post('rooms') as $room) {
              $room['fb_id'] = $fb_id;  
              $this->fb_model->update_fb($room, $fb_id, $room['id']);
            }
            $signatures = $this->fb_model->fb_sign();
            $do_sign = $this->fb_model->fb_do_sign($fb_id);
            //die(print_r($do_sign));
            if ($do_sign == 0) {
              foreach ($signatures as $fb_signature) {
                $this->fb_model->add_signature($fb_id, $fb_signature['role'], $fb_signature['department'], $fb_signature['rank']);
              }   
            }     
            redirect('/fb_order/fb_stage/'.$fb_id);
          }   
        }
        try {
          $this->load->helper('form');
          $this->load->model('fb_model');
          $this->load->model('hotels_model');
          $this->data['fb'] = $this->fb_model->get_fb($fb_id);
          $this->data['items'] = $this->fb_model->get_items($fb_id);
          foreach ($this->data['items'] as $key => $items) {
            $this->data['items'][$key]['contacts'] = $this->fb_model->getbyroom($this->data['items'][$key]['room'], $this->data['items'][$key]['hotel_id']);
          }
          $this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());
          $this->data['uploads'] = $this->fb_model->getby_fille($this->data['fb']['id']);
          $this->load->view('fb_add_new',$this->data);
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
      }
    }

    public function make_offer($fb_id) {
      $file_name = $this->do_upload("upload");
      if (!$file_name) {
        die(json_encode($this->data['error']));
      } else {
        $this->load->model("fb_model");
        $this->fb_model->add($fb_id, $file_name);
        die("{}");
      }
    }

    public function remove_offer($fb_id, $id) {
      $file_name = $_POST['key'];
      if (!$id) {
        die(json_encode($this->data['error']));
      } else {
        $this->load->model("fb_model");
        $this->fb_model->remove($id);
        die("{}");
      }
    }

    private function do_upload($field) {
      $config['upload_path'] = 'assets/uploads/files/';
      $config['allowed_types'] = '*';
      $this->load->library('upload', $config);
      if ( ! $this->upload->do_upload($field)){
        $this->data['error'] = array('error' => $this->upload->display_errors());
        return FALSE;
      }else{
        $file = $this->upload->data();
        return $file['file_name'];
      }
    }

    public function add_exp() {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        if ($this->input->post('submit')) {
          $this->load->library('form_validation');
          $this->load->library('email');
          $this->form_validation->set_rules('hotel_id','Hotel Name','trim|required');
          $this->form_validation->set_rules('room','Room Number','trim|required');
          if ($this->form_validation->run() == TRUE) {
            $this->load->model('fb_model');
            $this->load->model('users_model');  
            $data = array(
              'user_id' => $this->data['user_id'],
              'hotel_id' => $this->input->post('hotel_id')
            );
            $fb_id = $this->fb_model->create_fb($data);
            if (!$fb_id) {
              die("ERROR");
            }
            $room = $this->input->post('room');
            $rooms = explode(" ",$room);
            foreach ($rooms as $room) {
              $form_data = array(
                'room' => $room,
                'fb_id' => $fb_id
              );
              $item_id = $this->fb_model->create_room($form_data);
              if (!$item_id) {
                die("ERROR");
              }
            }
            redirect('/fb_order/submit_exp/'.$fb_id);
          }
        }
        try {
          $this->load->helper('form');
          $this->load->model('fb_model');
          $this->load->model('hotels_model');
          $this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());
          $this->load->view('fb_add_exp',$this->data);
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
      }
    }

    public function submit_exp($fb_id) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        if ($this->input->post('submit')) {
          $this->load->library('form_validation');
          $this->load->library('email');
          if ($this->form_validation->run() == FALSE) {
            $this->load->model('fb_model');
            $this->load->model('users_model');  
            foreach ($this->input->post('rooms') as $room) {
              $room['fb_id'] = $fb_id;  
              $this->fb_model->update_fb($room, $fb_id, $room['id']);
            }
            $signatures = $this->fb_model->fb_sign();
            $do_sign = $this->fb_model->fb_do_sign($fb_id);
            //die(print_r($do_sign));
            if ($do_sign == 0) {
              foreach ($signatures as $fb_signature) {
                $this->fb_model->add_signature($fb_id, $fb_signature['role'], $fb_signature['department'], $fb_signature['rank']);
              }  
            }      
            redirect('/fb_order/fb_stage/'.$fb_id);
          }   
        }
        try {
          $this->load->helper('form');
          $this->load->model('fb_model');
          $this->load->model('hotels_model');
          $this->data['fb'] = $this->fb_model->get_fb($fb_id);
          $this->data['items'] = $this->fb_model->get_items($fb_id);
          $this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());
          $this->data['uploads'] = $this->fb_model->getby_fille($this->data['fb']['id']);
          $this->load->view('fb_add_new_exp',$this->data);
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
      }
    }

    public function fb_stage($fb_id) {
      $this->load->model('fb_model');
      $this->data['fb'] = $this->fb_model->get_fb($fb_id);
      if ($this->data['fb']['state_id'] == 0) {
        $this->fb_model->update_state($fb_id, 1);
        redirect('/fb_order/fb_stage/'.$fb_id);
      } elseif ($this->data['fb']['state_id'] != 0 && $this->data['fb']['state_id'] != 2 && $this->data['fb']['state_id'] != 3) {
        $queue = $this->notify_signers($fb_id, $this->data['fb']['hotel_id']);
        if (!$queue) {
          $this->fb_model->update_state($fb_id, 2);
          $this->notify_done($amen_id);
          redirect('/fb_order/fb_stage/'.$fb_id);
        }
      }elseif ($this->data['fb']['state_id'] == 3){
        $user = $this->users_model->get_user_by_id($this->data['fb']['user_id'], TRUE);
        $queue = $this->reject_mail($user->fullname, $user->email, $fb_id);
      }
      redirect('/fb_order/view/'.$fb_id);
    }

    private function notify_signers($fb_id) {
      $notified = FALSE;
      $signers = $this->get_signers($fb_id, $this->data['fb']['hotel_id']);
      foreach ($signers as $signer) {
        if (isset($signer['queue'])) {
          $notified = TRUE;
          foreach ($signer['queue'] as $uid => $user) {
            $this->signatures_mail($signer['role'], $signer['department'], $user['name'], $user['mail'], $fb_id);
          }
          break;
        }
      }
      return $notified;
    }

    private function get_signers($fb_id, $hotel_id) {
      $this->load->model('fb_model');
      $signatures = $this->fb_model->getby_verbal($fb_id);
      return $this->roll_signers($signatures, $hotel_id, $fb_id);
    }

    private function roll_signers($signatures, $hotel_id, $fb_id) {
      $signers = array();
      $this->load->model('users_model');
      foreach ($signatures as $signature) {
        $signers[$signature['id']] = array();
        $signers[$signature['id']]['role'] = $signature['role'];
        $signers[$signature['id']]['role_id'] = $signature['role_id'];
        $signers[$signature['id']]['department'] = $signature['department'];
        $signers[$signature['id']]['department_id'] = $signature['department_id'];
        if ($signature['user_id']) {
          if ($signature['rank'] == 1){
            $this->fb_model->update_state($fb_id, 4);
          }elseif ($signature['rank'] == 2){
            $this->fb_model->update_state($fb_id, 5);
          }elseif ($signature['rank'] == 3){
            $this->fb_model->update_state($fb_id, 6);
          }elseif ($signature['rank'] == 4){
            $this->fb_model->update_state($fb_id, 2);
          }
          $signers[$signature['id']]['sign'] = array();
          $signers[$signature['id']]['sign']['id'] = $signature['user_id'];
          if ($signature['reject'] == 1) {
            $signers[$signature['id']]['sign']['reject'] = "reject";
            $this->fb_model->update_state($fb_id, 3);
          } 
          $user = $this->users_model->get_user_by_id($signature['user_id'], TRUE);
          $signers[$signature['id']]['sign']['name'] = $user->fullname;
          $signers[$signature['id']]['sign']['mail'] = $user->email;
          $signers[$signature['id']]['sign']['sign'] = $user->signature;
          $signers[$signature['id']]['sign']['timestamp'] = $signature['timestamp'];
        } else {
          $signers[$signature['id']]['queue'] = array();
          if ($hotel_id == 2) {
            $users = array();
            $users[0] = $this->users_model->getby_criteria($signature['role_id'], 1, $signature['department_id']);
            $users[1] = $this->users_model->getby_criteria($signature['role_id'], 2, $signature['department_id']);
            foreach ($users as $user) {
              foreach ($user as $use) {
                $signers[$signature['id']]['queue'][$use['id']] = array();
                $signers[$signature['id']]['queue'][$use['id']]['name'] = $use['fullname'];
                $signers[$signature['id']]['queue'][$use['id']]['mail'] = $use['email'];
              }
            }
          } else {
            $users = $this->users_model->getby_criteria($signature['role_id'], $hotel_id, $signature['department_id']);
            foreach ($users as $use) {
              $signers[$signature['id']]['queue'][$use['id']] = array();
              $signers[$signature['id']]['queue'][$use['id']]['name'] = $use['fullname'];
              $signers[$signature['id']]['queue'][$use['id']]['mail'] = $use['email'];
            }
          }
        }
      }
      return $signers;
    }

    private function signatures_mail($role, $department, $name, $mail, $fb_id) {
      $this->load->library('email');
      $this->load->helper('url');
      $fb_url = base_url().'fb_order/view/'.$fb_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($mail);
      $this->email->subject("Food & Beverage Order NO.#{$fb_id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
        Food & Beverage Order NO.#{$fb_id} requires your signature, Please use the link below:
        <br/>
        <a href='{$fb_url}' target='_blank'>{$fb_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
    }

    public function notify_done($fb_id) {
      $this->load->model('fb_model');
      $this->load->model('users_model');
      $signes = $this->fb_model->getby_verbal($fb_id);
      $users = array();
      foreach ($signes as $signe){
        if ($signe['user_id'] && $signe['user_id'] != 30) {
          $user = $this->users_model->get_user_by_id($signe['user_id'], TRUE);
          $name = $user->fullname;
          $mail = $user->email;
          $this->load->library('email');
          $this->load->helper('url');
          $fb_url = base_url().'fb_order/view/'.$fb_id;
          $this->email->from('e-signature@sunrise-resorts.com');
          $this->email->to($mail);
          $this->email->subject("Food & Beverage Order NO.#{$fb_id}");
          $this->email->message("Dear {$name},
            <br/>
            <br/>
            Food & Beverage Order NO.#{$fb_id} has been approved, Please use the link below:
            <br/>
            <a href='{$fb_url}' target='_blank'>{$fb_url}</a>
            <br/>
          "); 
          $mail_result = $this->email->send();
        }
      }
      redirect('fb_order/view/'.$fb_id);
    }

    private function reject_mail($name, $email, $fb_id) {
      $this->load->library('email');
      $this->load->helper('url');
      $fb_url = base_url().'fb_order/view/'.$fb_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($email);
      $this->email->subject("Food & Beverage Order NO.#{$fb_id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
        Food & Beverage Order NO.#{$fb_id} has been rejected, Please use the link below:
        <br/>
        <a href='{$fb_url}' target='_blank'>{$fb_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
    }

    public function view($fb_id) {
    	if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
    	}else{
		    $this->load->model('fb_model');
		    $this->data['fb'] = $this->fb_model->get_fb($fb_id);
		    $this->data['items'] = $this->fb_model->get_items($fb_id);
		    $this->data['uploads'] = $this->fb_model->getby_fille($fb_id);
		    $this->data['GetComment'] = $this->fb_model->GetComment($fb_id);
		    $this->data['signature_path'] = '/assets/uploads/signatures/';
		    $this->data['signers'] = $this->get_signers($this->data['fb']['id'], $this->data['fb']['hotel_id']);
			  $editor = FALSE;
			  $unsign_enable = FALSE;
			  $first = TRUE;
			  $force_edit = FALSE;
      	foreach ($this->data['signers'] as $signer) {
        	if (isset($signer['queue'])) {
          	foreach ($signer['queue'] as $uid => $dummy) {
            	if ( $uid == $this->data['user_id'] ) {
              		$editor = TRUE;
              		break;
            	}
          	}
        	} elseif (isset($signer['sign'])) {
          	$unsign_enable = FALSE;
          	$force_edit = FALSE;
          	if ($signer['sign']['id'] == $this->data['user_id']) {
            	if ($first) {
              	$force_edit = TRUE;
              	$unsign_enable = TRUE;
            	} else {
              	$force_edit = FALSE;
              	$unsign_enable = TRUE;
            	}
          	}
        	}
        	$first = FALSE;
      	}
      	if (isset($this->data['user_id'])) {
        	if ( $this->data['fb']['user_id'] == $this->data['user_id'] &&  $this->data['fb']['state_id'] == 1) {
          	$editor = TRUE;
        	}
      	}
		    $this->data['unsign_enable'] = (($unsign_enable) || $this->data['is_admin'])? TRUE : FALSE;
		    $this->data['is_editor'] = ( (($this->data['unsign_enable'] || $editor)) || ($force_edit) )? TRUE : FALSE;
		    $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
		    $this->data['id'] = $fb_id;
		    $this->load->view('fb_view', $this->data);
    	}
  	}

  	public function edit($fb_id) {
    	if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
    	}else{
      	if ($this->input->post('submit')) {
        	$this->load->library('form_validation');
        	$this->load->library('email');
        	if ($this->form_validation->run() == FALSE) {
          	$this->load->model('fb_model');
          	$this->load->model('users_model');  
            $this->data['fb'] = $this->fb_model->get_fb($fb_id);
          	foreach ($this->input->post('rooms') as $room) {
            	$room['fb_id'] = $fb_id;  
            	$this->fb_model->update_fb($room, $fb_id, $room['id']);
            }
            if ($this->data['fb']['state_id']!='1'){
              $this->notify($this->data['fb']['id']);
            } 
          	redirect('/fb_order/view/'.$fb_id);
        	}   
      	}
      	try {
			    $this->load->helper('form');
			    $this->load->model('fb_model');
			    $this->data['fb'] = $this->fb_model->get_fb($fb_id);
			    $this->data['items'] = $this->fb_model->get_items($fb_id);
			    $this->data['uploads'] = $this->fb_model->getby_fille($this->data['fb']['id']);
			    $this->load->view('fb_edit',$this->data);
      	}
		    catch( Exception $e) {
		      show_error($e->getMessage()." _ ". $e->getTraceAsString());
		    }
    	}
  	}

    public function notify($fb_id) {
      $this->load->model('fb_model');
      $this->load->model('users_model');
      $this->data['fb'] = $this->fb_model->get_fb($fb_id);
      $signes = $this->fb_model->getby_verbal($fb_id);
      $users = array();
      foreach ($signes as $signe){
        if ($signe['user_id'] && $signe['user_id'] != 30) {
          $user = $this->users_model->get_user_by_id($signe['user_id'], TRUE);
          $name = $user->fullname;
          $mail = $user->email;
          $this->load->library('email');
          $this->load->helper('url');
          $fb_url = base_url().'fb_order/view/'.$fb_id;
          $this->email->from('e-signature@sunrise-resorts.com');
          $this->email->to($mail);
          $this->email->subject("Food & Beverage Order NO.#{$fb_id}");
          $this->email->message("Dear {$name},
            <br/>
            <br/>
            Food & Beverage Order NO.#{$fb_id} has been Edited, Please use the link below:
            <br/>
            <a href='{$fb_url}' target='_blank'>{$fb_url}</a>
            <br/>
          "); 
          $mail_result = $this->email->send();
        }
      }
      redirect('fb_order/view/'.$fb_id);
    }

  	public function mailme($fb_id) {
      $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
      $this->load->library('email');
      $this->load->helper('url');
      $fb_url = base_url().'fb_order/view/'.$fb_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($user->email);
      $this->email->subject("Food & Beverage Order NO.#{$fb_id}");
      $this->email->message("Food & Beverage Order NO.#{$fb_id}:
        <br/>
        Please use the link below to view the Food & Beverage Order:
        <a href='{$fb_url}' target='_blank'>{$fb_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
      redirect('fb_order/view/'.$fb_id);
    }	

    public function mailto($fb_id) {
      if ($this->input->post('submit')) {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('message','message is required','trim|required');
        $this->form_validation->set_rules('mail','mail is required','trim|required');
        if ($this->form_validation->run() == TRUE) {
          $message = $this->input->post('message');
          $email = $this->input->post('mail');
          $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
          $this->load->library('email');
          $this->load->helper('url');
          $fb_url = base_url().'fb_order/view/'.$fb_id;
          $this->email->from('e-signature@sunrise-resorts.com');
          $this->email->to($email);
          $this->email->subject("A message from {$user->fullname}, Food & Beverage Order NO.#{$fb_id}");
          $this->email->message("{$user->fullname} sent you a private message regarding Food & Beverage Order {$fb_id}:
            <br/>
            {$message}
            <br />
            <br />
            Please use the link below to view the Food & Beverage Order:
            <a href='{$fb_url}' target='_blank'>{$fb_url}</a>
            <br/>
          "); 
          $mail_result = $this->email->send();
        }
      }
      redirect('fb_order/view/'.$fb_id);
    }

    public function unsign($signature_id) {
      $this->load->model('fb_model');
      $this->load->model('users_model');
      $signature_identity = $this->fb_model->get_signature_identity($signature_id);
      $this->fb_model->unsign($signature_id);
      $this->fb_model->update_state($signature_identity['fb_id'], 1);
      $fb = $this->fb_model->get_fb($signature_identity['fb_id']);
      $items = $this->fb_model->get_items($signature_identity['fb_id']);
      redirect('/fb_order/view/'.$signature_identity['fb_id']);
    }

    public function sign($signature_id, $reject = FALSE) {
      $this->load->model('fb_model');
      $signature_identity = $this->fb_model->get_signature_identity($signature_id);
      $signrs = $this->get_signers($signature_identity['fb_id'], $signature_identity['hotel_id']);
      $this->data['fb'] = $this->fb_model->get_fb($signature_identity['fb_id']);
      if (array_key_exists($this->data['user_id'], $signrs[$signature_id]['queue'])) {
        if ($reject) {
          $this->fb_model->reject($signature_id, $this->data['user_id']);
          redirect('/fb_order/fb_stage/'.$this->data['fb']['id']);  
        } else {
          $this->fb_model->sign($signature_id, $this->data['user_id']);
          redirect('/fb_order/fb_stage/'.$signature_identity['fb_id']);  
        }
      }
      redirect('/fb_order/view/'.$signature_identity['fb_id']);
    }

    public function Comment($fb_id){
      if ($this->input->post('submit')) {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('comment','Comment','trim|required');
        if ($this->form_validation->run() == TRUE) {
          $comment = $this->input->post('comment'); 
          $this->load->model('fb_model');
          $comment_data = array(
            'user_id' => $this->data['user_id'],
            'fb_id' => $fb_id,
            'comment' => $comment
          );
          $this->fb_model->InsertComment($comment_data);
        }
        redirect('/fb_order/view/'.$fb_id);
      }
    }

  }

?>