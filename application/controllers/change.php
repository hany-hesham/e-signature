<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class change extends CI_Controller {

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
    $this->data['menu']['active'] = "change";
  }

  public function add() {
    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
          redirect('/unknown');
    }else{
      if ($this->input->post('submit')) {
        $this->load->library('form_validation');
        $this->load->library('email');
        $this->form_validation->set_rules('room_old','Room','trim|required');
        $this->form_validation->set_rules('hotel_id','Hotel Name','trim|required');
        if ($this->form_validation->run() == TRUE) {
          $this->load->model('change_model');
          $this->load->model('users_model');  
          $datas = array(
            'user_id' => $this->data['user_id'],
            'hotel_id' => $this->input->post('hotel_id'),
            'room_old' => $this->input->post('room_old')
          );
        $ch_id = $this->change_model->create_change($datas);
        if (!$ch_id) {
            die("ERROR");
        }
        redirect('/change/submit/'.$ch_id);
        return $this->submit($ch_id);
    }
  }
  try {
        $this->load->helper('form');
        $this->load->model('change_model');
        $this->load->model('hotels_model');
        $this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());
        $this->load->view('change_add',$this->data);
      }
      catch( Exception $e) {
        show_error($e->getMessage()." _ ". $e->getTraceAsString());
      }
    }
}

  public function submit($ch_id) {
    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
          redirect('/unknown');
    }else{
      if ($this->input->post('submit')) {
        $this->load->library('form_validation');
        $this->load->library('email');
        $this->form_validation->set_rules('guest','Guest Name','trim|required');
        if ($this->form_validation->run() == TRUE) {
          $this->load->model('change_model');
          $this->load->model('users_model');  
          $form_data = array(
            'date' => $this->input->post('date'),
            'guest' => $this->input->post('guest'),
            'room_new' => $this->input->post('room_new'),
            'rate_from' => $this->input->post('rate_from'),
            'rate_to' => $this->input->post('rate_to'),
            'currency' => $this->input->post('currency'),
            'remarks' => $this->input->post('remarks')
          );
          $this->change_model->update_change($form_data, $ch_id);
          $this->data['change'] = $this->change_model->get_change($ch_id);
          $signatures = $this->change_model->change_sign();
          $do_sign = $this->change_model->ch_do_sign($ch_id);
            //die(print_r($do_sign));
            if ($do_sign == 0) {
              foreach ($signatures as $ch_signature) {
                $this->change_model->add_signature($ch_id, $ch_signature['role'], $ch_signature['department'], $ch_signature['rank']);
              }
            }
          redirect('/change/change_stage/'.$ch_id);
        }   
      }
      try {
        $this->load->helper('form');
        $this->load->model('change_model');
        $this->load->model('hotels_model');
        $this->data['change'] = $this->change_model->get_change($ch_id);
        $this->data['contacts'] = $this->change_model->getbyroom($this->data['change']['room_old'], $this->data['change']['hotel_id']);
        //die(print_r($this->data['change']['hotel_id']));
        $this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());
        $this->load->view('change_add_new',$this->data);
      }
      catch( Exception $e) {
        show_error($e->getMessage()." _ ". $e->getTraceAsString());
      }
    }
  }

  public function change_stage($ch_id) {
    $this->load->model('change_model');
    $this->data['change'] = $this->change_model->get_change($ch_id);
    if ($this->data['change']['state_id'] == 0) {
      $this->self_sign($ch_id);
      $this->change_model->update_state($ch_id, 1);
        redirect('/change/change_stage/'.$ch_id);
    } elseif ($this->data['change']['state_id'] != 0 && $this->data['change']['state_id'] != 2 && $this->data['change']['state_id'] != 3) {
      $queue = $this->notify_signers($ch_id, $this->data['change']['hotel_id']);
    }elseif ($this->data['change']['state_id'] == 2){
      $user = $this->users_model->get_user_by_id($this->data['change']['user_id'], TRUE);
      $queue = $this->approvel_mail($user->fullname, $user->email, $ch_id);
    }elseif ($this->data['change']['state_id'] == 3){
      $user = $this->users_model->get_user_by_id($this->data['change']['user_id'], TRUE);
      $queue = $this->reject_mail($user->fullname, $user->email, $ch_id);
    }
    redirect('/change/view/'.$ch_id);
  }

  private function self_sign($ch_id) {
    $this->load->model('change_model');
    $this->change_model->self_sign($ch_id, $this->data['user_id']);
  }

  private function notify_signers($ch_id) {
    $notified = FALSE;
    $signers = $this->get_signers($ch_id, $this->data['change']['hotel_id']);
    foreach ($signers as $signer) {
      if (isset($signer['queue'])) {
        $notified = TRUE;
          foreach ($signer['queue'] as $uid => $user) {
            $this->signatures_mail($signer['role'], $signer['department'], $user['name'], $user['mail'], $ch_id);
        }
                break;
      }
    }
    return $notified;
  }

  private function approvel_mail($name, $email, $ch_id) {
    $this->load->library('email');
    $this->load->helper('url');
    $ch_url = base_url().'change/view/'.$ch_id;
    $this->email->from('e-signature@sunrise-resorts.com');
    $this->email->to($email);
    $this->email->subject("Rate Change Request No. #{$ch_id}");
    $this->email->message("Dear {$name},<br/>
              <br/>
              Rate Change Request No. #{$ch_id} has been approved, Please use the link below:<br/>
              <a href='{$ch_url}' target='_blank'>{$ch_url}</a><br/>
              "); 
    $mail_result = $this->email->send();
  }

  private function reject_mail($name, $email, $ch_id) {
    $this->load->library('email');
    $this->load->helper('url');
    $ch_url = base_url().'change/view/'.$ch_id;
    $this->email->from('e-signature@sunrise-resorts.com');
    $this->email->to($email);
    $this->email->subject("Rate Change Request No. #{$ch_id}");
    $this->email->message("Dear {$name},<br/>
              <br/>
              Rate Change Request No. #{$ch_id} has been rejected, Please use the link below:<br/>
              <a href='{$ch_url}' target='_blank'>{$ch_url}</a><br/>
              "); 
    $mail_result = $this->email->send();
  }

  private function get_signers($ch_id, $hotel_id) {
    $this->load->model('change_model');
    $signatures = $this->change_model->getby_verbal($ch_id);
    return $this->roll_signers($signatures, $hotel_id, $ch_id);
  }

  private function signatures_mail($role, $department, $name, $mail, $ch_id) {
    $this->load->library('email');
    $this->load->helper('url');
    $ch_url = base_url().'change/view/'.$ch_id;
    $this->email->from('e-signature@sunrise-resorts.com');
    $this->email->to($mail);
    $this->email->subject("Rate Change Request No. #{$ch_id}");
    $this->email->message("Dear {$name},<br/>
              <br/>
              Rate Change Request No. #{$ch_id} requires your signature, Please use the link below:<br/>
              <a href='{$ch_url}' target='_blank'>{$ch_url}</a><br/>
              "); 
    $mail_result = $this->email->send();
  }

  private function roll_signers($signatures, $hotel_id, $ch_id) {
    $change = $this->change_model->get_change($ch_id);
    $signers = array();
    $this->load->model('users_model');
    foreach ($signatures as $signature) {
      $signers[$signature['id']] = array();
      $signers[$signature['id']]['role'] = $signature['role'];
      $signers[$signature['id']]['role_id'] = $signature['role_id'];
      $signers[$signature['id']]['department'] = $signature['department'];
      $signers[$signature['id']]['department_id'] = $signature['department_id'];

      if ($signature['user_id']) {
        if ($signature['rank'] == 1 && $change['state_id'] == 1){
          $this->change_model->update_state($ch_id, 4);
        }elseif ($signature['rank'] == 2 && $change['state_id'] == 4){
          $this->change_model->update_state($ch_id, 5);
        }elseif ($signature['rank'] == 3 && $change['state_id'] == 5){
          $this->change_model->update_state($ch_id, 6);
        }elseif ($signature['rank'] == 4 && $change['state_id'] == 6){
          $this->change_model->update_state($ch_id, 7);
        }elseif ($signature['rank'] == 5 && $change['state_id'] == 7){
          $this->change_model->update_state($ch_id, 2);
        }
        $signers[$signature['id']]['sign'] = array();
        $signers[$signature['id']]['sign']['id'] = $signature['user_id'];
        if ($signature['reject'] == 1) {
          $signers[$signature['id']]['sign']['reject'] = "reject";
          $this->change_model->update_state($ch_id, 3);
        } 
        $user = $this->users_model->get_user_by_id($signature['user_id'], TRUE);
        $signers[$signature['id']]['sign']['name'] = $user->fullname;
        $signers[$signature['id']]['sign']['mail'] = $user->email;
        $signers[$signature['id']]['sign']['sign'] = $user->signature;
        $signers[$signature['id']]['sign']['timestamp'] = $signature['timestamp'];
      } else {
        $signers[$signature['id']]['queue'] = array();
        $users = $this->users_model->getby_criteria($signature['role_id'], $hotel_id, $signature['department_id']);
        foreach ($users as $use) {
          $signers[$signature['id']]['queue'][$use['id']] = array();
          $signers[$signature['id']]['queue'][$use['id']]['name'] = $use['fullname'];
          $signers[$signature['id']]['queue'][$use['id']]['mail'] = $use['email'];
        }
      }
   }
    return $signers;
  }

  public function view($ch_id) {
    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
          redirect('/unknown');
    }else{
      $this->load->model('change_model');
      $this->load->model('hotels_model');   
      $this->data['hotels'] = $this->hotels_model->getall();
      $this->data['change'] = $this->change_model->get_change($ch_id);
      $this->data['getcomment'] = $this->change_model->getcomment($ch_id);
      $this->data['signature_path'] = '/assets/uploads/signatures/';
      $this->data['signers'] = $this->get_signers($this->data['change']['id'], $this->data['change']['hotel_id']);
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

        if ( $this->data['change']['user_id'] == $this->data['user_id'] &&  $this->data['change']['state_id'] == 1) {
          $editor = TRUE;
        }
      }
      $this->data['unsign_enable'] = (($unsign_enable) || $this->data['is_admin'])? TRUE : FALSE;
      $this->data['is_editor'] = ( (($this->data['unsign_enable'] || $editor)) || ($force_edit) )? TRUE : FALSE;
      $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
      $this->data['id'] = $ch_id;
      $this->load->view('change_view', $this->data);
    }
  }

  public function edit($ch_id) {
    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
          redirect('/unknown');
    }else{
      if ($this->input->post('submit')) {
        $this->load->library('form_validation');
        $this->load->library('email');
        if ($this->form_validation->run() == FALSE) {
          $this->load->model('change_model');
          $this->load->model('users_model');  
          $form_data = array(
            'date' => $this->input->post('date'),
            'room_new' => $this->input->post('room_new'),
            'rate_from' => $this->input->post('rate_from'),
            'rate_to' => $this->input->post('rate_to'),
            'currency' => $this->input->post('currency'),
            'remarks' => $this->input->post('remarks')
          );
          $this->change_model->update_change($form_data, $ch_id);
          redirect('/change/view/'.$ch_id);
        }   
      }
      try {
        $this->load->helper('form');
        $this->load->model('change_model');
        $this->load->model('hotels_model');
        $this->data['change'] = $this->change_model->get_change($ch_id);
        //die(print_r($this->data['change']['hotel_id']));
        $this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());
        $this->load->view('change_edit',$this->data);
      }
      catch( Exception $e) {
        show_error($e->getMessage()." _ ". $e->getTraceAsString());
      }
    }
  }

  public function index() {
    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
          redirect('/unknown');
    }else{
      $this->load->model('hotels_model');
      $this->load->model('change_model');
      $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
      $hotels = array();
      foreach ($user_hotels as $hotel) {
        $hotels[] = $hotel['id'];
      }    
      $this->data['change'] = $this->change_model->view($hotels);
      foreach ($this->data['change'] as $key => $ch) {
        $this->data['change'][$key]['approvals'] = $this->get_signers($this->data['change'][$key]['id'], $this->data['change'][$key]['hotel_id']);
      }
      $this->data['hotels'] = $this->hotels_model->getall();
      $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
      $this->load->view('change_index', $this->data);
    }
  }

  public function index_app() {
    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
          redirect('/unknown');
    }else{
      $this->load->model('hotels_model');
      $this->load->model('change_model');
      $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
      $hotels = array();
      foreach ($user_hotels as $hotel) {
        $hotels[] = $hotel['id'];
      }    
      $this->data['change'] = $this->change_model->view($hotels);
      foreach ($this->data['change'] as $key => $ch) {
        $this->data['change'][$key]['approvals'] = $this->get_signers($this->data['change'][$key]['id'], $this->data['change'][$key]['hotel_id']);
      }
      $this->data['hotels'] = $this->hotels_model->getall();
      $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
      $this->load->view('change_index_app', $this->data);
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
      $this->load->model('change_model');
      $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
      $hotels = array();
      foreach ($user_hotels as $hotel) {
        $hotels[] = $hotel['id'];
      }    
      $this->data['change'] = $this->change_model->view($hotels);
      foreach ($this->data['change'] as $key => $ch) {
        $this->data['change'][$key]['approvals'] = $this->get_signers($this->data['change'][$key]['id'], $this->data['change'][$key]['hotel_id']);
      }
      $this->data['hotels'] = $this->hotels_model->getall();
      $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
      $this->load->view('change_index_wat', $this->data);
    }
  }

  public function index_rej() {
    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
          redirect('/unknown');
    }else{
      $this->load->model('hotels_model');
      $this->load->model('change_model');
      $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
      $hotels = array();
      foreach ($user_hotels as $hotel) {
        $hotels[] = $hotel['id'];
      }    
      $this->data['change'] = $this->change_model->view($hotels);
      foreach ($this->data['change'] as $key => $ch) {
        $this->data['change'][$key]['approvals'] = $this->get_signers($this->data['change'][$key]['id'], $this->data['change'][$key]['hotel_id']);
      }
      $this->data['hotels'] = $this->hotels_model->getall();
      $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
      $this->load->view('change_index_rej', $this->data);
    }
  }

  public function sign($signature_id, $reject = FALSE) {
    $this->load->model('change_model');
    $signature_identity = $this->change_model->get_signature_identity($signature_id);
    $signrs = $this->get_signers($signature_identity['ch_id'], $signature_identity['hotel_id']);
    $this->data['change'] = $this->change_model->get_change($signature_identity['ch_id']);
    if (array_key_exists($this->data['user_id'], $signrs[$signature_id]['queue'])) {
      if ($reject) {
        $this->change_model->reject($signature_id, $this->data['user_id']);
        redirect('/change/change_stage/'.$this->data['change']['id']);  
      } else {
        $this->change_model->sign($signature_id, $this->data['user_id']);
        redirect('/change/change_stage/'.$signature_identity['ch_id']);  

      }
    }
    redirect('/change/view/'.$signature_identity['ch_id']);
  }

  public function unsign($signature_id) {
    $this->load->model('change_model');
    $this->load->model('users_model');
    $signature_identity = $this->change_model->get_signature_identity($signature_id);
    $this->change_model->unsign($signature_id);
    $change = $this->change_model->get_change($signature_identity['ch_id']);
    redirect('/change/view/'.$signature_identity['ch_id']);
  }

  public function mailto($ch_id) {
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
        $ch_url = base_url().'change/view/'.$ch_id;
        $this->email->from('e-signature@sunrise-resorts.com');
        $this->email->to($email);
        $this->email->subject("A message from {$user->fullname}, Rate Change Request No. #{$ch_id}");
        $this->email->message("{$user->fullname} sent you a private message regarding Rate Change Request No. #{$ch_id}:<br/>
                  {$message}<br />
                  <br />
                  Please use the link below to view the Rate Change Request:
                  <a href='{$ch_url}' target='_blank'>{$ch_url}</a><br/>
                "); 
        $mail_result = $this->email->send();
      }
    }
    redirect('change/view/'.$ch_id);
  }

  public function comment($ch_id){
      if ($this->input->post('submit')) {
      $this->load->library('form_validation');
      $this->form_validation->set_rules('comment','Comment','trim|required');
        if ($this->form_validation->run() == TRUE) {
          $comment = $this->input->post('comment'); 
          $this->load->model('change_model');
          $comment_data = array(
            'user_id' => $this->data['user_id'],
            'ch_id' => $ch_id,
            'comment' => $comment
          );
        $this->change_model->insertcomment($comment_data);
      }
      redirect('/change/view/'.$ch_id);
    }
  }

}