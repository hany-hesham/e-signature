<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class cairo_exchange extends CI_Controller {

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
    $this->data['menu']['active'] = "cairo_exchange";
  }

  public function add() {
    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['is_rater']) && $this->data['is_rater'])) {
      if ($this->input->post('submit')) {
        $this->load->library('form_validation');
        $this->load->library('email');
        $this->form_validation->set_rules('currency','Currency','trim|required');
        if ($this->form_validation->run() == TRUE) {
          $this->load->model('cairo_exchange_model');
          $this->load->model('users_model');  
          $datas = array(
            'user_id' => $this->data['user_id'],
            'hotel_id' => $this->input->post('hotel_id'),
            'date' => $this->input->post('date'),
            'currency' => $this->input->post('currency')
          );
          $ex_id = $this->cairo_exchange_model->create_exchange($datas);
          if (!$ex_id) {
              die("ERROR");
          }
          redirect('/cairo_exchange/submit/'.$ex_id);
          return $this->submit($ex_id);
        }
      }
      try {
        $this->load->helper('form');
        $this->load->model('cairo_exchange_model');
        $this->load->model('hotels_model');
        $this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());
        $this->load->view('cairo_exchange_add',$this->data);
      }
      catch( Exception $e) {
        show_error($e->getMessage()." _ ". $e->getTraceAsString());
      }
    }else{
        redirect('/unknown');
    }
  }

  public function submit($ex_id) {
     if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['is_rater']) && $this->data['is_rater'])) {
      if ($this->input->post('submit')) {
        $this->load->library('form_validation');
        $this->load->library('email');
        $this->form_validation->set_rules('bank_id','trim|required');
        if ($this->form_validation->run() == TRUE) {
          $this->load->model('cairo_exchange_model');
          $this->load->model('users_model');  
   
             foreach ($this->input->post('banks') as $bank) {
              $bank['exchange_id'] = $ex_id;
              
              $rate_id = $this->cairo_exchange_model->create_bank_rate($bank);

              if (!$rate_id) {
                die("ERROR");//@TODO failure view
              }

            }

            // die (print_r($this->input->post('banks')));
          
          // $this->cairo_exchange_model->update_bank($data);
          $this->data['exchange'] = $this->cairo_exchange_model->get_exchange($ex_id);
          $signatures = $this->cairo_exchange_model->ex_sign();
          $do_sign = $this->cairo_exchange_model->ex_do_sign($ex_id);
            //die(print_r($do_sign));
            if ($do_sign == 0) {
              foreach ($signatures as $ex_signature) {
                $this->cairo_exchange_model->add_signature($ex_id, $ex_signature['role'], $ex_signature['department'], $ex_signature['rank']);
              }
            }
          redirect('/cairo_exchange/exchange_stage/'.$ex_id);
        }   
      }
      try {
        $this->load->helper('form');
        $this->load->model('cairo_exchange_model');
        $this->load->model('hotels_model');
        $this->data['exchange'] = $this->cairo_exchange_model->get_exchange($ex_id);
        $this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());
        $this->data['banks'] = $this->cairo_exchange_model->getall_banks();
        $this->load->view('cairo_exchange_add_new',$this->data);
      }
      catch( Exception $e) {
        show_error($e->getMessage()." _ ". $e->getTraceAsString());
      }
    }else{
        redirect('/unknown');
    }
  }

  public function view($ex_id) {
    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['is_rater']) && $this->data['is_rater'])) {
      $this->load->model('cairo_exchange_model');
      $this->load->model('hotels_model');   
      $this->data['hotels'] = $this->hotels_model->getall();
      $this->data['exchange'] = $this->cairo_exchange_model->get_exchange($ex_id);
      $this->data['bankss'] = $this->cairo_exchange_model->get_bank_rate($ex_id);
      $this->data['GetComment'] = $this->cairo_exchange_model->GetComment($ex_id);
      $this->data['signature_path'] = '/assets/uploads/signatures/';
      $this->data['banks'] = $this->cairo_exchange_model->getall_banks();
      $this->data['signers'] = $this->get_signers($this->data['exchange']['id'], $this->data['exchange']['hotel_id']);
      $bankss = $this->cairo_exchange_model->get_bank_rate($ex_id);
      //die(print_r($this->data['exchange']['id']));
      $editor = FALSE;
      $unsign_enable = FALSE;
      $first = TRUE;
      $force_edit = FALSE;
      foreach ($this->data['signers'] as $signer) {
        if (isset($signer['queue'])) {
          foreach ($signer['queue'] as $uid => $dummy) {
            if ( $uid == ($this->data['user_id']||'1') &&  $this->data['exchange']['state_id'] == 1) {
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

        if ( $this->data['exchange']['user_id'] == $this->data['user_id'] &&  $this->data['exchange']['state_id'] == 0) {
          $editor = TRUE;
        }
      }
      $this->data['unsign_enable'] = (($unsign_enable) || $this->data['is_admin'])? TRUE : FALSE;
      $this->data['is_editor'] = ( (($this->data['unsign_enable'] || $editor)) || ($force_edit) )? TRUE : FALSE;
      $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
      $this->load->view('cairo_exchange_view', $this->data);
    }else{
        redirect('/unknown');
    }
  }

  public function view_rate($ex_id) {
    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['is_rater']) && $this->data['is_rater'])) {
      $this->load->model('cairo_exchange_model');
      $this->load->model('hotels_model');   
      $this->data['hotels'] = $this->hotels_model->getall();
      $this->data['exchange'] = $this->cairo_exchange_model->get_exchange($ex_id);
      $this->data['bankss'] = $this->cairo_exchange_model->get_bank_rate($ex_id);
      $this->data['GetComment'] = $this->cairo_exchange_model->GetComment($ex_id);
      $this->data['signature_path'] = '/assets/uploads/signatures/';
      $this->data['banks'] = $this->cairo_exchange_model->getall_banks();
      $this->data['signers'] = $this->get_signers($this->data['exchange']['id'], $this->data['exchange']['hotel_id']);
      $bankss = $this->cairo_exchange_model->get_bank_rate($ex_id);
      //die(print_r($this->data['exchange']['id']));
      $editor = FALSE;
      $unsign_enable = FALSE;
      $first = TRUE;
      $force_edit = FALSE;
      foreach ($this->data['signers'] as $signer) {
        if (isset($signer['queue'])) {
          foreach ($signer['queue'] as $uid => $dummy) {
            if ( $uid == ($this->data['user_id']||'1') &&  $this->data['exchange']['state_id'] == 1) {
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

        if ( $this->data['exchange']['user_id'] == $this->data['user_id'] &&  $this->data['exchange']['state_id'] == 0) {
          $editor = TRUE;
        }
      }
      $this->data['unsign_enable'] = (($unsign_enable) || $this->data['is_admin'])? TRUE : FALSE;
      $this->data['is_editor'] = ( (($this->data['unsign_enable'] || $editor)) || ($force_edit) )? TRUE : FALSE;
      $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
      $this->load->view('cairo_exchange_view_rate', $this->data);
    }else{
        redirect('/unknown');
    }
  }

  public function edit($ex_id) {
    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['is_rater']) && $this->data['is_rater'])) {
      if ($this->input->post('submit')) {
        $this->load->library('form_validation');
        $this->load->library('email');
        if ($this->form_validation->run() == FALSE) {
          $this->load->model('cairo_exchange_model');
          $this->load->model('users_model');  
          foreach ($this->input->post('bankss') as $banks) {
            $banks['exchange_id'] = $ex_id;
            $this->cairo_exchange_model->update_bank_rate($banks, $ex_id, $banks['id']);
          }
          redirect('/cairo_exchange/view/'.$ex_id);
      }
    }
      try {
        $this->load->helper('form');
        $this->load->model('cairo_exchange_model');
        $this->load->model('hotels_model');
        $this->data['id'] = $ex_id;
        $this->data['exchange'] = $this->cairo_exchange_model->get_exchange($ex_id);
        $this->data['bankss'] = $this->cairo_exchange_model->get_bank_rate($ex_id);
        $this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());
        $this->data['banks'] = $this->cairo_exchange_model->getall_banks();
        $this->load->view('cairo_exchange_edit',$this->data);
      }
      catch( Exception $e) {
        show_error($e->getMessage()." _ ". $e->getTraceAsString());
      }
    }else{
        redirect('/unknown');
    }
  }

  private function get_signers($ex_id, $hotel_id) {
    $this->load->model('cairo_exchange_model');
    $signatures = $this->cairo_exchange_model->getby_verbal($ex_id);
    return $this->roll_signers($signatures, $hotel_id, $ex_id);
  }

  private function roll_signers($signatures, $hotel_id, $ex_id) {
    $exchange= $this->cairo_exchange_model->get_exchange($ex_id);
    $signers = array();
    $this->load->model('users_model');
    foreach ($signatures as $signature) {
      $signers[$signature['id']] = array();
      $signers[$signature['id']]['role'] = $signature['role'];
      $signers[$signature['id']]['role_id'] = $signature['role_id'];
      $signers[$signature['id']]['department'] = $signature['department'];
      $signers[$signature['id']]['department_id'] = $signature['department_id'];
      if ($signature['user_id']) {
        if ($signature['rank'] == 1 && $exchange['state_id'] == 1){
          $this->cairo_exchange_model->update_state($ex_id, 4);
        }elseif ($signature['rank'] == 2 && $exchange['state_id'] == 4){
          $this->cairo_exchange_model->update_state($ex_id, 2);
        }
        $signers[$signature['id']]['sign'] = array();
        $signers[$signature['id']]['sign']['id'] = $signature['user_id'];
        if ($signature['reject'] == 1) {
          $signers[$signature['id']]['sign']['reject'] = "reject";
          $this->cairo_exchange_model->update_state($ex_id, 3);
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

  public function index() {
    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['is_rater']) && $this->data['is_rater'])) {
      $this->load->model('hotels_model');
      $this->load->model('cairo_exchange_model');
      $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
      $hotels = array();
      foreach ($user_hotels as $hotel) {
        $hotels[] = $hotel['id'];
      }    
      $this->data['exchange'] = $this->cairo_exchange_model->view($hotels);
      foreach ($this->data['exchange'] as $bnk => $ex) {
        $this->data['exchange'][$bnk]['bankss'] = $this->cairo_exchange_model->get_bank_rate($this->data['exchange'][$bnk]['id']);
      }
      foreach ($this->data['exchange'] as $key => $ex) {
        $this->data['exchange'][$key]['approvals'] = $this->get_signers($this->data['exchange'][$key]['id'], $this->data['exchange'][$key]['hotel_id']);
        //die(print_r($this->data['exchange'][$key]['exchange_id']));
      }
      $this->data['hotels'] = $this->hotels_model->getall();
      $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
      $this->load->view('cairo_exchange_index', $this->data);
    }else{
        redirect('/unknown');
    }
  }

  public function index_app() {
    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['is_rater']) && $this->data['is_rater'])) {
      $this->load->model('hotels_model');
      $this->load->model('cairo_exchange_model');
      $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
      $hotels = array();
      foreach ($user_hotels as $hotel) {
        $hotels[] = $hotel['id'];
      }    
      $this->data['exchange'] = $this->cairo_exchange_model->view($hotels);
      foreach ($this->data['exchange'] as $bnk => $ex) {
        $this->data['exchange'][$bnk]['bankss'] = $this->cairo_exchange_model->get_bank_rate($this->data['exchange'][$bnk]['id']);
      }
      foreach ($this->data['exchange'] as $key => $ex) {
        $this->data['exchange'][$key]['approvals'] = $this->get_signers($this->data['exchange'][$key]['id'], $this->data['exchange'][$key]['hotel_id']);
        //die(print_r($this->data['exchange'][$key]['exchange_id']));
      }
      $this->data['hotels'] = $this->hotels_model->getall();
      $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
      $this->load->view('cairo_exchange_index_app', $this->data);
    }else{
        redirect('/unknown');
    }
  }

  public function index_wat() {
    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['is_rater']) && $this->data['is_rater'])) {
      if ($this->input->post('submit')) {
      $this->data['state'] = $this->input->post('state');
    }
      $this->load->model('hotels_model');
      $this->load->model('cairo_exchange_model');
      $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
      $hotels = array();
      foreach ($user_hotels as $hotel) {
        $hotels[] = $hotel['id'];
      }    
      $this->data['exchange'] = $this->cairo_exchange_model->view($hotels);
      foreach ($this->data['exchange'] as $bnk => $ex) {
        $this->data['exchange'][$bnk]['bankss'] = $this->cairo_exchange_model->get_bank_rate($this->data['exchange'][$bnk]['id']);
      }
      foreach ($this->data['exchange'] as $key => $ex) {
        $this->data['exchange'][$key]['approvals'] = $this->get_signers($this->data['exchange'][$key]['id'], $this->data['exchange'][$key]['hotel_id']);
        //die(print_r($this->data['exchange'][$key]['exchange_id']));
      }
      $this->data['hotels'] = $this->hotels_model->getall();
      $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
      $this->load->view('cairo_exchange_index_wat', $this->data);
    }else{
        redirect('/unknown');
    }
  }

  public function index_rej() {
    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['is_rater']) && $this->data['is_rater'])) {
      $this->load->model('hotels_model');
      $this->load->model('cairo_exchange_model');
      $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
      $hotels = array();
      foreach ($user_hotels as $hotel) {
        $hotels[] = $hotel['id'];
      }    
      $this->data['exchange'] = $this->cairo_exchange_model->view($hotels);
      foreach ($this->data['exchange'] as $bnk => $ex) {
        $this->data['exchange'][$bnk]['bankss'] = $this->cairo_exchange_model->get_bank_rate($this->data['exchange'][$bnk]['id']);
      }
      foreach ($this->data['exchange'] as $key => $ex) {
        $this->data['exchange'][$key]['approvals'] = $this->get_signers($this->data['exchange'][$key]['id'], $this->data['exchange'][$key]['hotel_id']);
        //die(print_r($this->data['exchange'][$key]['exchange_id']));
      }
      $this->data['hotels'] = $this->hotels_model->getall();
      $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
      $this->load->view('cairo_exchange_index_rej', $this->data);
    }else{
        redirect('/unknown');
    }
  }

  public function sign($signature_id, $reject = FALSE) {
    $this->load->model('cairo_exchange_model');
    $signature_identity = $this->cairo_exchange_model->get_signature_identity($signature_id);
    $signrs = $this->get_signers($signature_identity['ex_id'], $signature_identity['hotel_id']);
    $this->data['exchange'] = $this->cairo_exchange_model->get_exchange($signature_identity['ex_id']);
    if (array_key_exists($this->data['user_id'], $signrs[$signature_id]['queue'])) {
      if ($reject) {
        $this->cairo_exchange_model->reject($signature_id, $this->data['user_id']);
        redirect('/cairo_exchange/exchange_stage/'.$this->data['exchange']['id']);  
      } else {
        $this->cairo_exchange_model->sign($signature_id, $this->data['user_id']);
        redirect('/cairo_exchange/exchange_stage/'.$signature_identity['ex_id']);  

      }
    }
    redirect('/cairo_exchange/view/'.$signature_identity['ex_id']);
  }

  public function exchange_stage($ex_id) {
    $this->load->model('cairo_exchange_model');
    $this->data['exchange'] = $this->cairo_exchange_model->get_exchange($ex_id);
    if ($this->data['exchange']['state_id'] == 0) {
      $this->self_sign($ex_id);
      $this->cairo_exchange_model->update_state($ex_id, 1);
        redirect('/cairo_exchange/exchange_stage/'.$ex_id);
    } elseif ($this->data['exchange']['state_id'] != 0 && $this->data['exchange']['state_id'] != 2 && $this->data['exchange']['state_id'] != 3) {
      $queue = $this->notify_signers($ex_id, $this->data['exchange']['hotel_id']);
    }elseif ($this->data['exchange']['state_id'] == 2){
      $user = $this->users_model->get_user_by_id($this->data['exchange']['user_id'], TRUE);
      $queue = $this->approvel_mail($user->fullname, $user->email, $ex_id);
      $raters = $this->cairo_exchange_model->getall_raters($ex_id);
      foreach ($raters as $rater) {
        $use = $this->users_model->get_user_by_id($rater['user_id'], TRUE);
        $queues = $this->approvel_mail($use->fullname, $use->email, $ex_id);
      }
    }elseif ($this->data['exchange']['state_id'] == 3){
      $user = $this->users_model->get_user_by_id($this->data['exchange']['user_id'], TRUE);
      $queue = $this->reject_mail($user->fullname, $user->email, $ex_id);
    }
    redirect('/cairo_exchange/view/'.$ex_id);
  }

  private function notify_signers($ex_id) {
    $notified = FALSE;
    $signers = $this->get_signers($ex_id, $this->data['exchange']['hotel_id']);
    foreach ($signers as $signer) {
      if (isset($signer['queue'])) {
        $notified = TRUE;
          foreach ($signer['queue'] as $uid => $user) {
            $this->signatures_mail($signer['role'], $signer['department'], $user['name'], $user['mail'], $ex_id);
        }
        break;
      }
    }
    return $notified;
  }

  private function signatures_mail($role, $department, $name, $mail, $ex_id) {
    $this->load->library('email');
    $this->load->helper('url');
    $ex_url = base_url().'cairo_exchange/view/'.$ex_id;
    $this->email->from('e-signature@sunrise-resorts.com');
    $this->email->to($mail);
    $this->email->subject("Daily Exchange Rate NO.#{$ex_id}");
    $this->email->message("Dear {$name},<br/>
              <br/>
              Daily Exchange Rate NO.#{$ex_id} requires your signature, Please use the link below:<br/>
              <a href='{$ex_url}' target='_blank'>{$ex_url}</a><br/>
              "); 
    $mail_result = $this->email->send();
  }

  public function unsign($signature_id) {
    $this->load->model('cairo_exchange_model');
    $this->load->model('users_model');
    $signature_identity = $this->cairo_exchange_model->get_signature_identity($signature_id);
    $this->cairo_exchange_model->unsign($signature_id);
    $exchange = $this->cairo_exchange_model->get_exchange($signature_identity['ex_id']);
    redirect('/cairo_exchange/view/'.$signature_identity['ex_id']);
  }

  private function reject_mail($name, $email, $ex_id) {
    $this->load->library('email');
    $this->load->helper('url');
    $ex_url = base_url().'cairo_exchange/view/'.$ex_id;
    $this->email->from('e-signature@sunrise-resorts.com');
    $this->email->to($email);
    $this->email->subject("Daily Exchange Rate NO.#{$ex_id}");
    $this->email->message("Dear {$name},<br/>
              <br/>
              Daily Exchange Rate NO.#{$ex_id} has been rejected, Please use the link below:<br/>
              <a href='{$ex_url}' target='_blank'>{$ex_url}</a><br/>
              "); 
    $mail_result = $this->email->send();
  }

  private function approvel_mail($name, $email, $ex_id) {
    $this->load->library('email');
    $this->load->helper('url');
    $ex_url = base_url().'cairo_exchange/view/'.$ex_id;
    $this->email->from('e-signature@sunrise-resorts.com');
    $this->email->to($email);
    $this->email->subject("Daily Exchange Rate NO.#{$ex_id}");
    $this->email->message("Dear {$name},<br/>
              <br/>
              Daily Exchange Rate NO.#{$ex_id} has been approved, Please use the link below:<br/>
              <a href='{$ex_url}' target='_blank'>{$ex_url}</a><br/>
              "); 
    $mail_result = $this->email->send();
  }

  public function mailto($ex_id) {
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
        $ex_url = base_url().'cairo_exchange/view/'.$ex_id;
        $this->email->from('e-signature@sunrise-resorts.com');
        $this->email->to($email);
        $this->email->subject("A message from {$user->fullname}, Daily Exchange Rate NO.#{$ex_id}");
        $this->email->message("{$user->fullname} sent you a private message regarding Daily Exchange Rate NO.#{$ex_id}:<br/>
                  {$message}<br />
                  <br />
                  Please use the link below to view the Daily Exchange Rate:
                  <a href='{$ex_url}' target='_blank'>{$ex_url}</a><br/>
                "); 
        $mail_result = $this->email->send();
      }
    }
    redirect('cairo_exchange/view/'.$ex_id);
  }

  public function mailme($ex_id) {
        $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
        $this->load->library('email');
        $this->load->helper('url');
        $ex_url = base_url().'cairo_exchange/view/'.$ex_id;
        $this->email->from('e-signature@sunrise-resorts.com');
        $this->email->to($user->email);
        $this->email->subject("Daily Exchange Rate NO.#{$ex_id}");
        $this->email->message("Daily Exchange Rate NO.#{$ex_id}:<br/>
                  Please use the link below to view the Daily Exchange Rate:
                  <a href='{$ex_url}' target='_blank'>{$ex_url}</a><br/>
                "); 
        $mail_result = $this->email->send();
        redirect('cairo_exchange/view/'.$ex_id);
  }

   private function self_sign($ex_id) {
    $this->load->model('cairo_exchange_model');
    $this->cairo_exchange_model->self_sign($ex_id, $this->data['user_id']);
  }

  public function Comment($ex_id){
      if ($this->input->post('submit')) {
      $this->load->library('form_validation');
      $this->form_validation->set_rules('comment','Comment','trim|required');
        if ($this->form_validation->run() == TRUE) {
          $comment = $this->input->post('comment'); 
          $this->load->model('cairo_exchange_model');
          $comment_data = array(
            'user_id' => $this->data['user_id'],
            'ex_id' => $ex_id,
            'comment' => $comment
          );
        $this->cairo_exchange_model->InsertComment($comment_data);
        if ($this->data['role_id'] == 217) {
            $this->chairman_mail($ex_id);
          }
      }
      redirect('/cairo_exchange/view/'.$ex_id);
    }
  }

  private function chairman_mail($ex_id) {
          $this->load->library('email');
          $this->load->helper('url');
          $ex_url = base_url().'cairo_exchange/view/'.$ex_id;
          $this->email->from('e-signature@sunrise-resorts.com');
          $this->email->to('abeer@sunrise.eg');
          $this->email->subject("Daily Exchange Rate Form No. #{$ex_id}");
          $this->email->message("Dear Madam Abber,
            <br/>
            <br/>
            Mr Hossam Commented on Daily Exchange Rate Form No. #{$ex_id}, Please use the link below:
            <br/>
            <a href='{$ex_url}' target='_blank'>{$ex_url}</a>
            <br/>
          "); 
          $mail_result = $this->email->send();
      }

}