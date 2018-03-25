<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class rr_change extends CI_Controller {
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
    $this->data['menu']['active'] = "rr_change";
  }

  public function submit() {
    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
          redirect('/unknown');
    }else{
      if ($this->input->post('submit')) {
        $this->load->library('form_validation');
        $this->load->library('email');
        $assumed_id = $this->input->post('assumed_id');                        
        if ($this->form_validation->run() == FALSE) {
          $this->load->model('rr_change_model');
          $this->load->model('users_model');  
          $form_data = array(
            'user_id' => $this->data['user_id'],
            'hotel_id' => $this->input->post('hotel_id'),
            'date' => $this->input->post('date'),
            'rr' => $this->input->post('rr'),
            'type' => '1'
          );
          $rr_id = $this->rr_change_model->create_rr($form_data);
          if ($rr_id) {
              $this->load->model('rr_change_model');
              $this->rr_change_model->update_files($assumed_id,$rr_id);
            } else {
              die("ERROR");//@TODO failure view
            }
            $resulte =  array();
            foreach ($this->input->post('items') as $item) {
              $item['rr_id'] = $rr_id;  
              $item_id = $this->rr_change_model->create_room($item);   
              $resulte[] = $item['id'];
              if (!$item_id) {
                die("ERROR");
              }
            }
          $signatures = $this->rr_change_model->rr_sign($form_data['type']);
          $do_sign = $this->rr_change_model->rr_do_sign($rr_id);
            //die(print_r($do_sign));
            if ($do_sign == 0) {
              foreach ($signatures as $rr_signature) {
                $this->rr_change_model->add_signature($rr_id, $rr_signature['role'], $rr_signature['department'], $rr_signature['rank']);
              }
            }
       //   $this->rr_change_model->add_signature($rr_id, 0, 0);    
          redirect('/rr_change/rr_stage/'.$rr_id);
        }   
      } 
      try {
        $this->load->helper('form');
        $this->load->model('rr_change_model');
        $this->load->model('hotels_model');
        $this->data['operators'] = $this->rr_change_model->getall_operator();
        $this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());
        if ($this->input->post('submit')) {
          $this->load->model('rr_change_model');
          $this->data['assumed_id'] = $this->input->post('assumed_id');
          $this->data['uploads'] = $this->rr_change_model->getby_fille($this->data['assumed_id']);
        } else {
          $this->data['assumed_id'] = strtoupper(str_pad(dechex( mt_rand( 0, 1048575 ) ), 5, '0', STR_PAD_LEFT));
          $this->data['uploads'] = array();
        }
        $this->load->view('rr_add_new',$this->data);
      }
      catch( Exception $e) {
        show_error($e->getMessage()." _ ". $e->getTraceAsString());
      }
    }
  }

  public function make_offer($rr_id) {
    $file_name = $this->do_upload("upload");
    if (!$file_name) {
      die(json_encode($this->data['error']));
    } else {
      $this->load->model("rr_change_model");
      $this->rr_change_model->add($rr_id, $file_name);
      // $this->logger->log_event($this->data['user_id'], "Offer", "projects", $rr_id, json_encode(array("offer_name" => $file_name)), "user uploaded an offer");//log
      die("{}");
    }
  }

  public function remove_offer($rr_id, $id) {
    $file_name = $_POST['key'];
    if (!$id) {
      die(json_encode($this->data['error']));
    } else {
      $this->load->model("rr_change_model");
      $this->rr_change_model->remove($id);
      // $this->logger->log_event($this->data['user_id'], "Offer-Remove", "projects", $rr_id, json_encode(array("offer_id" => $id, "file_name" => $file_name)), "user removed an offer");//log
      die("{}");
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

  public function no_rr() {
    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
          redirect('/unknown');
    }else{
      if ($this->input->post('submit')) {
        $this->load->library('form_validation');
        $this->load->library('email');
        $assumed_id = $this->input->post('assumed_id');                        
        if ($this->form_validation->run() == FALSE) {
          $this->load->model('rr_change_model');
          $this->load->model('users_model');  
          $form_data = array(
            'user_id' => $this->data['user_id'],
            'hotel_id' => $this->input->post('hotel_id'),
            'date' => $this->input->post('date'),
            'rr' => $this->input->post('rr'),
            'type' => '1'
          );
          $rr_id = $this->rr_change_model->create_rr($form_data);
          if ($rr_id) {
              $this->load->model('rr_change_model');
              $this->rr_change_model->update_files($assumed_id,$rr_id);
            } else {
              die("ERROR");//@TODO failure view
            }
            $resulte =  array();
            foreach ($this->input->post('items') as $item) {
              $item['rr_id'] = $rr_id;  
              $item_id = $this->rr_change_model->create_room($item);   
              $resulte[] = $item['id'];
              if (!$item_id) {
                die("ERROR");
              }
            }
          $signatures = $this->rr_change_model->rr_sign($form_data['type']);
          $do_sign = $this->rr_change_model->rr_do_sign($rr_id);
            //die(print_r($do_sign));
            if ($do_sign == 0) {
              foreach ($signatures as $rr_signature) {
                $this->rr_change_model->add_signature($rr_id, $rr_signature['role'], $rr_signature['department'], $rr_signature['rank']);
              }
            }
       //   $this->rr_change_model->add_signature($rr_id, 0, 0);    
          redirect('/rr_change/rr_stage/'.$rr_id);
        }   
      } 
      try {
        $this->load->helper('form');
        $this->load->model('rr_change_model');
        $this->load->model('hotels_model');
        $this->data['operators'] = $this->rr_change_model->getall_operator();
        $this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());
        if ($this->input->post('submit')) {
          $this->load->model('rr_change_model');
          $this->data['assumed_id'] = $this->input->post('assumed_id');
          $this->data['uploads'] = $this->rr_change_model->getby_fille($this->data['assumed_id']);
        } else {
          $this->data['assumed_id'] = strtoupper(str_pad(dechex( mt_rand( 0, 1048575 ) ), 5, '0', STR_PAD_LEFT));
          $this->data['uploads'] = array();
        }
        $this->load->view('rr_no',$this->data);
      }
      catch( Exception $e) {
        show_error($e->getMessage()." _ ". $e->getTraceAsString());
      }
    }
  }

  public function view($rr_id) {
    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
          redirect('/unknown');
    }else{
      $this->load->model('rr_change_model');
      $this->load->model('hotels_model');   
      $this->data['hotels'] = $this->hotels_model->getall();
      $this->data['rr'] = $this->rr_change_model->get_rr($rr_id);
      $this->data['rr_room'] = $this->rr_change_model->get_rr_room($rr_id);
      $this->data['uploads'] = $this->rr_change_model->getby_fille($rr_id);
      $this->data['get_comment'] = $this->rr_change_model->get_comment($rr_id);
      $this->data['signature_path'] = '/assets/uploads/signatures/';
      $this->data['signers'] = $this->get_signers($this->data['rr']['id'], $this->data['rr']['hotel_id']);
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

        if ( $this->data['rr']['user_id'] == $this->data['user_id'] &&  $this->data['rr']['state_id'] == 1) {
          $editor = TRUE;
        }
      }
      $this->data['unsign_enable'] = (($unsign_enable) || $this->data['is_admin'])? TRUE : FALSE;
      $this->data['is_editor'] = ( (($this->data['unsign_enable'] || $editor)) || ($force_edit) )? TRUE : FALSE;
      $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
      $this->data['file_path'] = '\assets\uploads\files\\';
      $this->data['id'] = $rr_id;
      $this->load->view('rr_view', $this->data);
    }
  }

  public function edit($rr_id) {
    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
          redirect('/unknown');
    }else{
      if ($this->input->post('submit')) {
        $this->load->library('form_validation');
        $this->load->library('email');
        if ($this->form_validation->run() == FALSE) {
          $this->load->model('rr_change_model');
          $this->load->model('users_model');  
          $form_data = array(
            'hotel_id' => $this->input->post('hotel_id'),
            'date' => $this->input->post('date'),
            'rr' => $this->input->post('rr'),
          );
          $this->rr_change_model->update_rr($form_data, $rr_id);
           foreach ($this->input->post('items') as $item) {
            $item['rr_id'] = $rr_id;  
              //die(print_r($item));    
            $this->rr_change_model->update_room($item, $rr_id, $item['id']);
            }
          redirect('/rr_change/view/'.$rr_id);
        }   
        } 
        try {
        $this->load->helper('form');
        $this->load->model('rr_change_model');
        $this->load->model('hotels_model');
        $this->data['rr'] = $this->rr_change_model->get_rr($rr_id);
        $this->data['rr_room'] = $this->rr_change_model->get_rr_room($rr_id);
        $this->data['operators'] = $this->rr_change_model->getall_operator();
        $this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());
        $this->data['uploads'] = $this->rr_change_model->getby_fille($this->data['rr']['id']);
        $this->load->view('rr_edit',$this->data);
      }
      catch( Exception $e) {
        show_error($e->getMessage()." _ ". $e->getTraceAsString());
      }
    }
  }

  public function Comment($rr_id){
      if ($this->input->post('submit')) {
      $this->load->library('form_validation');
          $this->form_validation->set_rules('comment','Comment','trim|required');
        if ($this->form_validation->run() == TRUE) {
          $comment = $this->input->post('comment'); 
          $this->load->model('rr_change_model');
          $comment_data = array(
            'user_id' => $this->data['user_id'],
            'rr_id' => $rr_id,
            'comment' => $comment
          );
        $this->rr_change_model->insert_comment($comment_data);
      }
      redirect('/rr_change/view/'.$rr_id);
    }
  }

  public function index() {
    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
          redirect('/unknown');
    }else{
      $this->load->model('hotels_model');
      $this->load->model('users_model');
      $this->load->model('rr_change_model');
      $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
      $hotels = array();
      foreach ($user_hotels as $hotel) {
        $hotels[] = $hotel['id'];
      }    
      $this->data['rr'] = $this->rr_change_model->view_room($hotels);
      foreach ($this->data['rr'] as $ke => $rr) {
        $this->data['rr'][$ke]['items'] = $this->rr_change_model->get_rr_room($this->data['rr'][$ke]['id']);
      }
      foreach ($this->data['rr'] as $key => $dcy) {
        $this->data['rr'][$key]['approvals'] = $this->get_signers($this->data['rr'][$key]['id'], $this->data['rr'][$key]['hotel_id']);
      }
      $this->data['hotels'] = $this->hotels_model->getall();
      $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
      $this->load->view('rr_index', $this->data);
    }
  }

  public function index_room() {
    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
          redirect('/unknown');
    }else{
      $this->load->model('hotels_model');
      $this->load->model('users_model');
      $this->load->model('rr_change_model');
      $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
      $hotels = array();
      foreach ($user_hotels as $hotel) {
        $hotels[] = $hotel['id'];
      }    
      $this->data['rr'] = $this->rr_change_model->view_room($hotels);
      foreach ($this->data['rr'] as $ke => $rr) {
        $this->data['rr'][$ke]['items'] = $this->rr_change_model->get_rr_room($this->data['rr'][$ke]['id']);
      }
      foreach ($this->data['rr'] as $key => $dcy) {
        $this->data['rr'][$key]['approvals'] = $this->get_signers($this->data['rr'][$key]['id'], $this->data['rr'][$key]['hotel_id']);
      }
      $this->data['hotels'] = $this->hotels_model->getall();
      $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
      $this->load->view('rr_index_room', $this->data);
    }
  }

  public function index_room_app() {
    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
          redirect('/unknown');
    }else{
      $this->load->model('hotels_model');
      $this->load->model('users_model');
      $this->load->model('rr_change_model');
      $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
      $hotels = array();
      foreach ($user_hotels as $hotel) {
        $hotels[] = $hotel['id'];
      }    
      $this->data['rr'] = $this->rr_change_model->view_room($hotels);
      foreach ($this->data['rr'] as $ke => $rr) {
        $this->data['rr'][$ke]['items'] = $this->rr_change_model->get_rr_room($this->data['rr'][$ke]['id']);
      }
      foreach ($this->data['rr'] as $key => $dcy) {
        $this->data['rr'][$key]['approvals'] = $this->get_signers($this->data['rr'][$key]['id'], $this->data['rr'][$key]['hotel_id']);
      }
      $this->data['hotels'] = $this->hotels_model->getall();
      $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
      $this->load->view('rr_index_room_app', $this->data);
    }
  }

  public function index_room_wat() {
    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
          redirect('/unknown');
    }else{
      if ($this->input->post('submit')) {
        $this->data['state'] = $this->input->post('state');
      }
      $this->load->model('hotels_model');
      $this->load->model('users_model');
      $this->load->model('rr_change_model');
      $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
      $hotels = array();
      foreach ($user_hotels as $hotel) {
        $hotels[] = $hotel['id'];
      }    
      $this->data['rr'] = $this->rr_change_model->view_room($hotels);
      foreach ($this->data['rr'] as $ke => $rr) {
        $this->data['rr'][$ke]['items'] = $this->rr_change_model->get_rr_room($this->data['rr'][$ke]['id']);
      }
      foreach ($this->data['rr'] as $key => $dcy) {
        $this->data['rr'][$key]['approvals'] = $this->get_signers($this->data['rr'][$key]['id'], $this->data['rr'][$key]['hotel_id']);
      }
      $this->data['hotels'] = $this->hotels_model->getall();
      $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
      $this->load->view('rr_index_room_wat', $this->data);
    }
  }

  public function index_room_rej() {
    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
          redirect('/unknown');
    }else{
      $this->load->model('hotels_model');
      $this->load->model('users_model');
      $this->load->model('rr_change_model');
      $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
      $hotels = array();
      foreach ($user_hotels as $hotel) {
        $hotels[] = $hotel['id'];
      }    
      $this->data['rr'] = $this->rr_change_model->view_room($hotels);
      foreach ($this->data['rr'] as $ke => $rr) {
        $this->data['rr'][$ke]['items'] = $this->rr_change_model->get_rr_room($this->data['rr'][$ke]['id']);
      }
      foreach ($this->data['rr'] as $key => $dcy) {
        $this->data['rr'][$key]['approvals'] = $this->get_signers($this->data['rr'][$key]['id'], $this->data['rr'][$key]['hotel_id']);
      }
      $this->data['hotels'] = $this->hotels_model->getall();
      $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
      $this->load->view('rr_index_room_rej', $this->data);
    }
  }

  public function index_rate() {
    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
          redirect('/unknown');
    }else{
      $this->load->model('hotels_model');
      $this->load->model('users_model');
      $this->load->model('rr_change_model');
      $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
      $hotels = array();
      foreach ($user_hotels as $hotel) {
        $hotels[] = $hotel['id'];
      }    
      $this->data['rr'] = $this->rr_change_model->view_room($hotels);
      foreach ($this->data['rr'] as $ke => $rr) {
        $this->data['rr'][$ke]['items'] = $this->rr_change_model->get_rr_room($this->data['rr'][$ke]['id']);
      }
      foreach ($this->data['rr'] as $key => $dcy) {
        $this->data['rr'][$key]['approvals'] = $this->get_signers($this->data['rr'][$key]['id'], $this->data['rr'][$key]['hotel_id']);
      }
      $this->data['hotels'] = $this->hotels_model->getall();
      $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
      $this->load->view('rr_index_rate', $this->data);
    }
  }

  public function index_rate_app() {
    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
          redirect('/unknown');
    }else{
      $this->load->model('hotels_model');
      $this->load->model('users_model');
      $this->load->model('rr_change_model');
      $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
      $hotels = array();
      foreach ($user_hotels as $hotel) {
        $hotels[] = $hotel['id'];
      }    
      $this->data['rr'] = $this->rr_change_model->view_room($hotels);
      foreach ($this->data['rr'] as $ke => $rr) {
        $this->data['rr'][$ke]['items'] = $this->rr_change_model->get_rr_room($this->data['rr'][$ke]['id']);
      }
      foreach ($this->data['rr'] as $key => $dcy) {
        $this->data['rr'][$key]['approvals'] = $this->get_signers($this->data['rr'][$key]['id'], $this->data['rr'][$key]['hotel_id']);
      }
      $this->data['hotels'] = $this->hotels_model->getall();
      $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
      $this->load->view('rr_index_rate_app', $this->data);
    }
  }

  public function index_rate_wat() {
    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
          redirect('/unknown');
    }else{
      if ($this->input->post('submit')) {
        $this->data['state'] = $this->input->post('state');
      }
      $this->load->model('hotels_model');
      $this->load->model('users_model');
      $this->load->model('rr_change_model');
      $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
      $hotels = array();
      foreach ($user_hotels as $hotel) {
        $hotels[] = $hotel['id'];
      }    
      $this->data['rr'] = $this->rr_change_model->view_room($hotels);
      foreach ($this->data['rr'] as $ke => $rr) {
        $this->data['rr'][$ke]['items'] = $this->rr_change_model->get_rr_room($this->data['rr'][$ke]['id']);
      }
      foreach ($this->data['rr'] as $key => $dcy) {
        $this->data['rr'][$key]['approvals'] = $this->get_signers($this->data['rr'][$key]['id'], $this->data['rr'][$key]['hotel_id']);
      }
      $this->data['hotels'] = $this->hotels_model->getall();
      $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
      $this->load->view('rr_index_rate_wat', $this->data);
    }
  }

  public function index_rate_rej() {
    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
          redirect('/unknown');
    }else{
      $this->load->model('hotels_model');
      $this->load->model('users_model');
      $this->load->model('rr_change_model');
      $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
      $hotels = array();
      foreach ($user_hotels as $hotel) {
        $hotels[] = $hotel['id'];
      }    
      $this->data['rr'] = $this->rr_change_model->view_room($hotels);
      foreach ($this->data['rr'] as $ke => $rr) {
        $this->data['rr'][$ke]['items'] = $this->rr_change_model->get_rr_room($this->data['rr'][$ke]['id']);
      }
      foreach ($this->data['rr'] as $key => $dcy) {
        $this->data['rr'][$key]['approvals'] = $this->get_signers($this->data['rr'][$key]['id'], $this->data['rr'][$key]['hotel_id']);
      }
      $this->data['hotels'] = $this->hotels_model->getall();
      $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
      $this->load->view('rr_index_rate_rej', $this->data);
    }
  }

  private function get_signers($rr_id, $hotel_id) {
    $this->load->model('rr_change_model');
    $signatures = $this->rr_change_model->getby_verbal($rr_id);
    return $this->roll_signers($signatures, $hotel_id, $rr_id);
  }

  private function roll_signers($signatures, $hotel_id, $rr_id) {
    $rr = $this->rr_change_model->get_rr($rr_id);
    $signers = array();
    $this->load->model('users_model');
    foreach ($signatures as $signature) {
      $signers[$signature['id']] = array();
      $signers[$signature['id']]['role'] = $signature['role'];
      $signers[$signature['id']]['role_id'] = $signature['role_id'];
      $signers[$signature['id']]['department'] = $signature['department'];
      $signers[$signature['id']]['department_id'] = $signature['department_id'];
      if ($signature['user_id']) {
        if ($signature['rank'] == 1 && $rr['state_id'] == 1){
          $this->rr_change_model->update_state($rr_id, 4);
        }elseif ($signature['rank'] == 2 && $rr['state_id'] == 4){
          $this->rr_change_model->update_state($rr_id, 5);
        }elseif ($signature['rank'] == 3 && $rr['state_id'] == 5){
          $this->rr_change_model->update_state($rr_id, 6);
        }elseif ($signature['rank'] == 4 && $rr['state_id'] == 6){
          $this->rr_change_model->update_state($rr_id, 7);
        }elseif ($signature['rank'] == 5 && $rr['state_id'] == 7){
          $this->rr_change_model->update_state($rr_id, 2);
        }
        $signers[$signature['id']]['sign'] = array();
        $signers[$signature['id']]['sign']['id'] = $signature['user_id'];
        if ($signature['reject'] == 1) {
          $signers[$signature['id']]['sign']['reject'] = "reject";
          $this->rr_change_model->update_state($rr_id, 3);
        } 
        $user = $this->users_model->get_user_by_id($signature['user_id'], TRUE);
        $signers[$signature['id']]['sign']['name'] = $user->fullname;
        $signers[$signature['id']]['sign']['mail'] = $user->email;
        $signers[$signature['id']]['sign']['sign'] = $user->signature;
        $signers[$signature['id']]['sign']['timestamp'] = $signature['timestamp'];
      } else {
        $signers[$signature['id']]['queue'] = array();
        if ($signature['role_id'] == 20) {
          $users = $this->users_model->getby_criteria(7, $hotel_id, 4);
        } else {
          $users = $this->users_model->getby_criteria($signature['role_id'], $hotel_id, $signature['department_id']);
        }
        foreach ($users as $use) {
          $signers[$signature['id']]['queue'][$use['id']] = array();
          $signers[$signature['id']]['queue'][$use['id']]['name'] = $use['fullname'];
          $signers[$signature['id']]['queue'][$use['id']]['mail'] = $use['email'];
        }
      }
    }
    return $signers;
  }

  public function sign($signature_id, $reject = FALSE) {
    $this->load->model('rr_change_model');
    $signature_identity = $this->rr_change_model->get_signature_identity($signature_id);
    $signrs = $this->get_signers($signature_identity['rr_id'], $signature_identity['hotel_id']);
    $this->data['rr'] = $this->rr_change_model->get_rr($signature_identity['rr_id']);
    if (array_key_exists($this->data['user_id'], $signrs[$signature_id]['queue'])) {
      if ($reject) {
        $this->rr_change_model->reject($signature_id, $this->data['user_id']);
        redirect('/rr_change/rr_stage/'.$this->data['rr']['id']);  
      } else {
        $this->rr_change_model->sign($signature_id, $this->data['user_id']);
        redirect('/rr_change/rr_stage/'.$signature_identity['rr_id']);  

      }
    }
    redirect('/rr_change/view/'.$signature_identity['rr_id']);
  }

  public function unsign($signature_id) {
    $this->load->model('rr_change_model');
    $this->load->model('users_model');
    $signature_identity = $this->rr_change_model->get_signature_identity($signature_id);
    $this->rr_change_model->unsign($signature_id);
    $rr = $this->rr_change_model->get_rr($signature_identity['rr_id']);
    redirect('/rr_change/view/'.$signature_identity['rr_id']);
  }

  public function rr_stage($rr_id) {
    $this->load->model('rr_change_model');
    $this->data['rr'] = $this->rr_change_model->get_rr($rr_id);
    if ($this->data['rr']['state_id'] == 0) {
      $this->self_sign($rr_id);
      $this->rr_change_model->update_state($rr_id, 1);
        redirect('/rr_change/rr_stage/'.$rr_id);
    } elseif ($this->data['rr']['state_id'] != 0 && $this->data['rr']['state_id'] != 2 && $this->data['rr']['state_id'] != 3) {
      $queue = $this->notify_signers($rr_id, $this->data['rr']['hotel_id']);
    }elseif ($this->data['rr']['state_id'] == 2){
      $user = $this->users_model->get_user_by_id($this->data['rr']['user_id'], TRUE);
      $queue = $this->approvel_mail($user->fullname, $user->email, $rr_id);
    }elseif ($this->data['rr']['state_id'] == 3){
      $user = $this->users_model->get_user_by_id($this->data['rr']['user_id'], TRUE);
      $queue = $this->reject_mail($user->fullname, $user->email, $rr_id);
    }
    redirect('/rr_change/view/'.$rr_id);
  }

  private function self_sign($rr_id) {
    $this->load->model('rr_change_model');
    $this->rr_change_model->self_sign($rr_id, $this->data['user_id']);
  }

  private function notify_signers($rr_id) {
    $notified = FALSE;
    $signers = $this->get_signers($rr_id, $this->data['rr']['hotel_id']);
    foreach ($signers as $signer) {
      if (isset($signer['queue'])) {
        $notified = TRUE;
          foreach ($signer['queue'] as $uid => $user) {
            $this->signatures_mail($signer['role'], $user['name'], $user['mail'], $rr_id);
        }
        break;
      }
    }
    return $notified;
  }

  private function signatures_mail($role, $name, $mail, $rr_id) {
    $this->load->library('email');
    $this->load->helper('url');
    $rr_url = base_url().'rr_change/view/'.$rr_id;
    $this->email->from('e-signature@sunrise-resorts.com');
    $this->email->to($mail);
    $this->email->subject("Room Change Report No. #{$rr_id}");
    $this->email->message("Dear {$name},<br/>
              <br/>
              Room Change Report No. #{$rr_id} requires your signature, Please use the link below:<br/>
              <a href='{$rr_url}' target='_blank'>{$rr_url}</a><br/>
              "); 
    $mail_result = $this->email->send();
  }

  private function reject_mail($name, $email, $rr_id) {
    $this->load->library('email');
    $this->load->helper('url');
    $rr_url = base_url().'rr_change/view/'.$rr_id;
    $this->email->from('e-signature@sunrise-resorts.com');
    $this->email->to($email);
    $this->email->subject("Room Change Report No. #{{$rr_id}");
    $this->email->message("Dear {$name},<br/>
              <br/>
              Room Change Report No. #{{$rr_id} has been rejected, Please use the link below:<br/>
              <a href='{$rr_url}' target='_blank'>{$rr_url}</a><br/>
              "); 
    $mail_result = $this->email->send();
  }

  private function approvel_mail($name, $email, $rr_id) {
    $this->load->library('email');
    $this->load->helper('url');
    $rr_url = base_url().'rr_change/view/'.$rr_id;
    $this->email->from('e-signature@sunrise-resorts.com');
    $this->email->to($email);
    $this->email->subject("Room Change Report No. #{$rr_id}");
    $this->email->message("Dear {$name},<br/>
              <br/>
              Room Change Report No. #{$rr_id} has been approved, Please use the link below:<br/>
              <a href='{$rr_url}' target='_blank'>{$rr_url}</a><br/>
              "); 
    $mail_result = $this->email->send();
  }

  public function mailto($rr_id) {
    if ($this->input->post('submit')) {
      $this->load->library('form_validation');
      $this->form_validation->set_rules('message','Message is required','trim|required');
      $this->form_validation->set_rules('mail','Mail is required','trim|required');
      if ($this->form_validation->run() == TRUE) {
        $message = $this->input->post('message');
        $email = $this->input->post('mail');
        $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
        $this->load->library('email');
        $this->load->helper('url');
        $rr_url = base_url().'rr_change/view/'.$rr_id;
        $this->email->from('e-signature@sunrise-resorts.com');
        $this->email->to($email);
        $this->email->subject("A message from {$user->fullname}, Room Change Report No. #{$rr_id}");
        $this->email->message("{$user->fullname} sent you a private message regarding Room Change Report No. #{$rr_id}:<br/>
                  {$message}<br />
                  <br />
                  Please use the link below to view the Room Change Report:
                  <a href='{$rr_url}' target='_blank'>{$rr_url}</a><br/>
                "); 
        $mail_result = $this->email->send();
      }
    }
    redirect('rr_change/view/'.$rr_id);
  }
}