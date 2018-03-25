<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class s_rate extends CI_Controller {
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
    $this->data['menu']['active'] = "s_rate";
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
          $this->load->model('s_rate_model');
          $this->load->model('users_model');  
          $form_data = array(
            'user_id' => $this->data['user_id'],
            'hotel_id' => $this->input->post('hotel_id'),
            'date' => $this->input->post('date'),
            'type' => '1'
          );
          $sr_id = $this->s_rate_model->create_sr($form_data);
          if ($sr_id) {
              $this->load->model('s_rate_model');
              $this->s_rate_model->update_files($assumed_id,$sr_id);
            } else {
              die("ERROR");//@TODO failure view
            }
          $resulte =  array();
          foreach ($this->input->post('items') as $item) {
            $item['sr_id'] = $sr_id;  
            $item_id = $this->s_rate_model->create_room($item);   
            $resulte[] = $item['id'];
            if (!$item_id) {
              die("ERROR");
            }
          }
          $signatures = $this->s_rate_model->sr_sign($form_data['type']);
          $do_sign = $this->s_rate_model->sr_do_sign($sr_id);
            //die(print_r($do_sign));
            if ($do_sign == 0) {
              foreach ($signatures as $sr_signature) {
                $this->s_rate_model->add_signature($sr_id, $sr_signature['role'], $sr_signature['department'], $sr_signature['rank']);
              }
            }
       //   $this->s_rate_model->add_signature($sr_id, 0, 0);    
          redirect('/s_rate/sr_stage/'.$sr_id);
        }   
      } 
      try {
        $this->load->helper('form');
        $this->load->model('s_rate_model');
        $this->load->model('hotels_model');
        $this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());
        if ($this->input->post('submit')) {
          $this->load->model('s_rate_model');
          $this->data['assumed_id'] = $this->input->post('assumed_id');
          $this->data['uploads'] = $this->s_rate_model->getby_fille($this->data['assumed_id']);
        } else {
          $this->data['assumed_id'] = strtoupper(str_pad(dechex( mt_rand( 0, 1048575 ) ), 5, '0', STR_PAD_LEFT));
          $this->data['uploads'] = array();
        }
        $this->load->view('sr_add_new',$this->data);
      }
      catch( Exception $e) {
        show_error($e->getMessage()." _ ". $e->getTraceAsString());
      }
    }
  }

  public function make_offer($sr_id) {
    $file_name = $this->do_upload("upload");
    if (!$file_name) {
      die(json_encode($this->data['error']));
    } else {
      $this->load->model("s_rate_model");
      $this->s_rate_model->add($sr_id, $file_name);
      // $this->logger->log_event($this->data['user_id'], "Offer", "projects", $sr_id, json_encode(array("offer_name" => $file_name)), "user uploaded an offer");//log
      die("{}");
    }
  }

  public function remove_offer($sr_id, $id) {
    $file_name = $_POST['key'];
    if (!$id) {
      die(json_encode($this->data['error']));
    } else {
      $this->load->model("s_rate_model");
      $this->s_rate_model->remove($id);
      // $this->logger->log_event($this->data['user_id'], "Offer-Remove", "projects", $sr_id, json_encode(array("offer_id" => $id, "file_name" => $file_name)), "user removed an offer");//log
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

  public function no_sr() {
    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
          redirect('/unknown');
    }else{
      if ($this->input->post('submit')) {
        $this->load->library('form_validation');
        $this->load->library('email');
        $assumed_id = $this->input->post('assumed_id');                        
        if ($this->form_validation->run() == FALSE) {
          $this->load->model('s_rate_model');
          $this->load->model('users_model');  
          $form_data = array(
            'user_id' => $this->data['user_id'],
            'hotel_id' => $this->input->post('hotel_id'),
            'date' => $this->input->post('date'),
            'type' => '1'
          );
          $sr_id = $this->s_rate_model->create_sr($form_data);
          if ($sr_id) {
              $this->load->model('s_rate_model');
              $this->s_rate_model->update_files($assumed_id,$sr_id);
            } else {
              die("ERROR");//@TODO failure view
            }
          $signatures = $this->s_rate_model->sr_sign($form_data['type']);
          $do_sign = $this->s_rate_model->sr_do_sign($sr_id);
            //die(print_r($do_sign));
            if ($do_sign == 0) {
              foreach ($signatures as $sr_signature) {
                $this->s_rate_model->add_signature($sr_id, $sr_signature['role'], $sr_signature['department'], $sr_signature['rank']);
              }
            }
       //   $this->s_rate_model->add_signature($sr_id, 0, 0);    
          redirect('/s_rate/sr_stage/'.$sr_id);
        }   
      } 
      try {
        $this->load->helper('form');
        $this->load->model('s_rate_model');
        $this->load->model('hotels_model');
        $this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());
        if ($this->input->post('submit')) {
          $this->load->model('s_rate_model');
          $this->data['assumed_id'] = $this->input->post('assumed_id');
          $this->data['uploads'] = $this->s_rate_model->getby_fille($this->data['assumed_id']);
        } else {
          $this->data['assumed_id'] = strtoupper(str_pad(dechex( mt_rand( 0, 1048575 ) ), 5, '0', STR_PAD_LEFT));
          $this->data['uploads'] = array();
        }
        $this->load->view('sr_no',$this->data);
      }
      catch( Exception $e) {
        show_error($e->getMessage()." _ ". $e->getTraceAsString());
      }
    }
  }

  public function view($sr_id) {
    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
          redirect('/unknown');
    }else{
      $this->load->model('s_rate_model');
      $this->load->model('hotels_model');   
      $this->data['hotels'] = $this->hotels_model->getall();
      $this->data['sr'] = $this->s_rate_model->get_sr($sr_id);
      $this->data['sr_room'] = $this->s_rate_model->get_sr_room($sr_id);
      $this->data['uploads'] = $this->s_rate_model->getby_fille($sr_id);
      $this->data['get_comment'] = $this->s_rate_model->get_comment($sr_id);
      $this->data['signature_path'] = '/assets/uploads/signatures/';
      $this->data['signers'] = $this->get_signers($this->data['sr']['id'], $this->data['sr']['hotel_id']);
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

        if ( $this->data['sr']['user_id'] == $this->data['user_id'] &&  $this->data['sr']['state_id'] == 1) {
          $editor = TRUE;
        }
      }
      $this->data['unsign_enable'] = (($unsign_enable) || $this->data['is_admin'])? TRUE : FALSE;
      $this->data['is_editor'] = ( (($this->data['unsign_enable'] || $editor)) || ($force_edit) )? TRUE : FALSE;
      $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
      $this->data['file_path'] = '\assets\uploads\files\\';
      $this->data['id'] = $sr_id;
      $this->load->view('sr_view', $this->data);
    }
  }

  public function edit($sr_id) {
    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
          redirect('/unknown');
    }else{
      if ($this->input->post('submit')) {
        $this->load->library('form_validation');
        $this->load->library('email');
        if ($this->form_validation->run() == FALSE) {
          $this->load->model('s_rate_model');
          $this->load->model('users_model');  
          $form_data = array(
            'hotel_id' => $this->input->post('hotel_id'),
            'date' => $this->input->post('date'),
          );
          $this->s_rate_model->update_sr($form_data, $sr_id);
          foreach ($this->input->post('items') as $item) {
            $item['sr_id'] = $sr_id;  
              //die(print_r($item));    
            $this->s_rate_model->update_room($item, $sr_id, $item['id']);
            }
          redirect('/s_rate/view/'.$sr_id);
        }   
        } 
        try {
        $this->load->helper('form');
        $this->load->model('s_rate_model');
        $this->load->model('hotels_model');
        $this->data['sr'] = $this->s_rate_model->get_sr($sr_id);
        $this->data['sr_room'] = $this->s_rate_model->get_sr_room($sr_id);
        $this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());
        $this->data['uploads'] = $this->s_rate_model->getby_fille($this->data['sr']['id']);
        $this->load->view('sr_edit',$this->data);
      }
      catch( Exception $e) {
        show_error($e->getMessage()." _ ". $e->getTraceAsString());
      }
    }
  }

  public function Comment($sr_id){
      if ($this->input->post('submit')) {
      $this->load->library('form_validation');
          $this->form_validation->set_rules('comment','Comment','trim|required');
        if ($this->form_validation->run() == TRUE) {
          $comment = $this->input->post('comment'); 
          $this->load->model('s_rate_model');
          $comment_data = array(
            'user_id' => $this->data['user_id'],
            'sr_id' => $sr_id,
            'comment' => $comment
          );
        $this->s_rate_model->insert_comment($comment_data);
      }
      redirect('/s_rate/view/'.$sr_id);
    }
  }

  public function index() {
    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
          redirect('/unknown');
    }else{
      $this->load->model('hotels_model');
      $this->load->model('users_model');
      $this->load->model('s_rate_model');
      $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
      $hotels = array();
      foreach ($user_hotels as $hotel) {
        $hotels[] = $hotel['id'];
      }    
      $this->data['sr'] = $this->s_rate_model->view($hotels);
      foreach ($this->data['sr'] as $ke => $ch) {
        $this->data['sr'][$ke]['items'] = $this->s_rate_model->get_sr_room($this->data['sr'][$ke]['id']);
      }
      foreach ($this->data['sr'] as $key => $dcy) {
        $this->data['sr'][$key]['approvals'] = $this->get_signers($this->data['sr'][$key]['id'], $this->data['sr'][$key]['hotel_id']);
      }
      $this->data['hotels'] = $this->hotels_model->getall();
      $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
      $this->load->view('sr_index', $this->data);
    }
  }

  public function index_app() {
    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
          redirect('/unknown');
    }else{
      $this->load->model('hotels_model');
      $this->load->model('users_model');
      $this->load->model('s_rate_model');
      $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
      $hotels = array();
      foreach ($user_hotels as $hotel) {
        $hotels[] = $hotel['id'];
      }    
      $this->data['sr'] = $this->s_rate_model->view($hotels);
      foreach ($this->data['sr'] as $ke => $ch) {
        $this->data['sr'][$ke]['items'] = $this->s_rate_model->get_sr_room($this->data['sr'][$ke]['id']);
      }
      foreach ($this->data['sr'] as $key => $dcy) {
        $this->data['sr'][$key]['approvals'] = $this->get_signers($this->data['sr'][$key]['id'], $this->data['sr'][$key]['hotel_id']);
      }
      $this->data['hotels'] = $this->hotels_model->getall();
      $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
      $this->load->view('sr_index_app', $this->data);
    }
  }

  public function index_wat() {
    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
          redirect('/unknown');
    }else{
      if ($this->input->post('submit')) {
        $this->data['state'] = $this->input->post('state');
      }
      $this->load->model('hotels_model');
      $this->load->model('users_model');
      $this->load->model('s_rate_model');
      $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
      $hotels = array();
      foreach ($user_hotels as $hotel) {
        $hotels[] = $hotel['id'];
      }    
      $this->data['sr'] = $this->s_rate_model->view($hotels);
      foreach ($this->data['sr'] as $ke => $ch) {
        $this->data['sr'][$ke]['items'] = $this->s_rate_model->get_sr_room($this->data['sr'][$ke]['id']);
      }
      foreach ($this->data['sr'] as $key => $dcy) {
        $this->data['sr'][$key]['approvals'] = $this->get_signers($this->data['sr'][$key]['id'], $this->data['sr'][$key]['hotel_id']);
      }
      $this->data['hotels'] = $this->hotels_model->getall();
      $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
      $this->load->view('sr_index_wat', $this->data);
    }
  }

  public function index_rej() {
    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
          redirect('/unknown');
    }else{
      $this->load->model('hotels_model');
      $this->load->model('users_model');
      $this->load->model('s_rate_model');
      $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
      $hotels = array();
      foreach ($user_hotels as $hotel) {
        $hotels[] = $hotel['id'];
      }    
      $this->data['sr'] = $this->s_rate_model->view($hotels);
      foreach ($this->data['sr'] as $ke => $ch) {
        $this->data['sr'][$ke]['items'] = $this->s_rate_model->get_sr_room($this->data['sr'][$ke]['id']);
      }
      foreach ($this->data['sr'] as $key => $dcy) {
        $this->data['sr'][$key]['approvals'] = $this->get_signers($this->data['sr'][$key]['id'], $this->data['sr'][$key]['hotel_id']);
      }
      $this->data['hotels'] = $this->hotels_model->getall();
      $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
      $this->load->view('sr_index_rej', $this->data);
    }
  }

  private function get_signers($sr_id, $hotel_id) {
    $this->load->model('s_rate_model');
    $signatures = $this->s_rate_model->getby_verbal($sr_id);
    return $this->roll_signers($signatures, $hotel_id, $sr_id);
  }

  private function roll_signers($signatures, $hotel_id, $sr_id) {
    $sr = $this->s_rate_model->get_sr($sr_id);
    $signers = array();
    $this->load->model('users_model');
    foreach ($signatures as $signature) {
      $signers[$signature['id']] = array();
      $signers[$signature['id']]['role'] = $signature['role'];
      $signers[$signature['id']]['role_id'] = $signature['role_id'];
      $signers[$signature['id']]['department'] = $signature['department'];
      $signers[$signature['id']]['department_id'] = $signature['department_id'];
      if ($signature['user_id']) {
        if ($signature['rank'] == 1 && $sr['state_id'] == 1){
          $this->s_rate_model->update_state($sr_id, 4);
        }elseif ($signature['rank'] == 2 && $sr['state_id'] == 4){
          $this->s_rate_model->update_state($sr_id, 5);
        }elseif ($signature['rank'] == 3 && $sr['state_id'] == 5){
          $this->s_rate_model->update_state($sr_id, 6);
        }elseif ($signature['rank'] == 4 && $sr['state_id'] == 6){
          $this->s_rate_model->update_state($sr_id, 7);
        }elseif ($signature['rank'] == 5 && $sr['state_id'] == 7){
          $this->s_rate_model->update_state($sr_id, 2);
        }
        $signers[$signature['id']]['sign'] = array();
        $signers[$signature['id']]['sign']['id'] = $signature['user_id'];
        if ($signature['reject'] == 1) {
          $signers[$signature['id']]['sign']['reject'] = "reject";
          $this->s_rate_model->update_state($sr_id, 3);
        } 
        $user = $this->users_model->get_user_by_id($signature['user_id'], TRUE);
        $signers[$signature['id']]['sign']['name'] = $user->fullname;
        $signers[$signature['id']]['sign']['mail'] = $user->email;
        $signers[$signature['id']]['sign']['sign'] = $user->signature;
        $signers[$signature['id']]['sign']['timestamp'] = $signature['timestamp'];
      } else {
        $signers[$signature['id']]['queue'] = array();
        if ($signature['role_id'] == 6 && $hotel_id==5) {
                $users[0] = $this->users_model->getby_criteria(142, $hotel_id);
                $users[1] = $this->users_model->getby_criteria(6, $hotel_id);
                foreach ($users as $user) {
                  foreach ($user as $use) {
                    $signers[$signature['id']]['queue'][$use['id']] = array();
                    $signers[$signature['id']]['queue'][$use['id']]['name'] = $use['fullname'];
                    $signers[$signature['id']]['queue'][$use['id']]['mail'] = $use['email'];
                    $signers[$signature['id']]['queue'][$use['id']]['channel'] = $use['channel'];
                  }
                }
              }
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
    $this->load->model('s_rate_model');
    $signature_identity = $this->s_rate_model->get_signature_identity($signature_id);
    $signrs = $this->get_signers($signature_identity['sr_id'], $signature_identity['hotel_id']);
    $this->data['sr'] = $this->s_rate_model->get_sr($signature_identity['sr_id']);
    if (array_key_exists($this->data['user_id'], $signrs[$signature_id]['queue'])) {
      if ($reject) {
        $this->s_rate_model->reject($signature_id, $this->data['user_id']);
        redirect('/s_rate/sr_stage/'.$this->data['sr']['id']);  
      } else {
        $this->s_rate_model->sign($signature_id, $this->data['user_id']);
        redirect('/s_rate/sr_stage/'.$signature_identity['sr_id']);  

      }
    }
    redirect('/s_rate/view/'.$signature_identity['sr_id']);
  }

  public function unsign($signature_id) {
    $this->load->model('s_rate_model');
    $this->load->model('users_model');
    $signature_identity = $this->s_rate_model->get_signature_identity($signature_id);
    $this->s_rate_model->unsign($signature_id);
    $sr = $this->s_rate_model->get_ch($signature_identity['sr_id']);
    redirect('/s_rate/view/'.$signature_identity['sr_id']);
  }

  public function sr_stage($sr_id) {
    $this->load->model('s_rate_model');
    $this->data['sr'] = $this->s_rate_model->get_sr($sr_id);
    if ($this->data['sr']['state_id'] == 0) {
      $this->self_sign($sr_id);
      $this->s_rate_model->update_state($sr_id, 1);
        redirect('/s_rate/sr_stage/'.$sr_id);
    } elseif ($this->data['sr']['state_id'] != 0 && $this->data['sr']['state_id'] != 2 && $this->data['sr']['state_id'] != 3) {
      $queue = $this->notify_signers($sr_id, $this->data['sr']['hotel_id']);
    }elseif ($this->data['sr']['state_id'] == 2){
      $user = $this->users_model->get_user_by_id($this->data['sr']['user_id'], TRUE);
      $queue = $this->approvel_mail($user->fullname, $user->email, $sr_id);
    }elseif ($this->data['sr']['state_id'] == 3){
      $user = $this->users_model->get_user_by_id($this->data['sr']['user_id'], TRUE);
      $queue = $this->reject_mail($user->fullname, $user->email, $sr_id);
    }
    redirect('/s_rate/view/'.$sr_id);
  }

  private function self_sign($sr_id) {
    $this->load->model('s_rate_model');
    $this->s_rate_model->self_sign($sr_id, $this->data['user_id']);
  }

  private function notify_signers($sr_id) {
    $notified = FALSE;
    $signers = $this->get_signers($sr_id, $this->data['sr']['hotel_id']);
    foreach ($signers as $signer) {
      if (isset($signer['queue'])) {
        $notified = TRUE;
          foreach ($signer['queue'] as $uid => $user) {
            $this->signatures_mail($signer['role'], $user['name'], $user['mail'], $sr_id);
        }
        break;
      }
    }
    return $notified;
  }

  private function signatures_mail($role, $name, $mail, $sr_id) {
    $this->load->library('email');
    $this->load->helper('url');
    $sr_url = base_url().'s_rate/view/'.$sr_id;
    $this->email->from('e-signature@sunrise-resorts.com');
    $this->email->to($mail);
    $this->email->subject("Special rate Report No. #{$sr_id}");
    $this->email->message("Dear {$name},<br/>
              <br/>
              Special rate Report No. #{$sr_id} requires your signature, Please use the link below:<br/>
              <a href='{$sr_url}' target='_blank'>{$sr_url}</a><br/>
              "); 
    $mail_result = $this->email->send();
  }

  private function reject_mail($name, $email, $sr_id) {
    $this->load->library('email');
    $this->load->helper('url');
    $sr_url = base_url().'s_rate/view/'.$sr_id;
    $this->email->from('e-signature@sunrise-resorts.com');
    $this->email->to($email);
    $this->email->subject("Special rate Report No. #{{$sr_id}");
    $this->email->message("Dear {$name},<br/>
              <br/>
              Special rate Report No. #{{$sr_id} has been rejected, Please use the link below:<br/>
              <a href='{$sr_url}' target='_blank'>{$sr_url}</a><br/>
              "); 
    $mail_result = $this->email->send();
  }

  private function approvel_mail($name, $email, $sr_id) {
    $this->load->library('email');
    $this->load->helper('url');
    $sr_url = base_url().'s_rate/view/'.$sr_id;
    $this->email->from('e-signature@sunrise-resorts.com');
    $this->email->to($email);
    $this->email->subject("Special rate Report No. #{$sr_id}");
    $this->email->message("Dear {$name},<br/>
              <br/>
              Special rate Report No. #{$sr_id} has been approved, Please use the link below:<br/>
              <a href='{$sr_url}' target='_blank'>{$sr_url}</a><br/>
              "); 
    $mail_result = $this->email->send();
  }

  public function mailto($sr_id) {
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
        $sr_url = base_url().'s_rate/view/'.$sr_id;
        $this->email->from('e-signature@sunrise-resorts.com');
        $this->email->to($email);
        $this->email->subject("A message from {$user->fullname}, Special rate Report No. #{$sr_id}");
        $this->email->message("{$user->fullname} sent you a private message regarding Special rate Report No. #{$sr_id}:<br/>
                  {$message}<br />
                  <br />
                  Please use the link below to view the Special rate Report:
                  <a href='{$sr_url}' target='_blank'>{$sr_url}</a><br/>
                "); 
        $mail_result = $this->email->send();
      }
    }
    redirect('s_rate/view/'.$sr_id);
  }
}