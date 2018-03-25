<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class complaint extends CI_Controller {

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
    $this->data['menu']['active'] = "quality";
  }

  public function submit() {
        if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
      if ($this->input->post('submit')) {
        $this->load->library('form_validation');
        $this->load->library('email');
        $assumed_id = $this->input->post('assumed_id');                        
        $this->form_validation->set_rules('hotel_id','Hotel Name','trim|required');
        $this->form_validation->set_rules('guest','Guest Name','trim|required');
        if ($this->form_validation->run() == TRUE) {
          $this->load->model('complaint_model');
          $this->load->model('users_model');  
          $form_data = array(
            'user_id' => $this->data['user_id'],
            'hotel_id' => $this->input->post('hotel_id'),
            'guest' => $this->input->post('guest'),
            'ref' => $this->input->post('ref'),
            'date' => $this->input->post('date'),
            'operator_id' => $this->input->post('operator_id'),
            'receiving' => $this->input->post('receiving'),
            'reply' => $this->input->post('reply'),
            'subject' => $this->input->post('subject'),
            'comment' => $this->input->post('comment'),
            'action' => $this->input->post('action'),
            'other' => $this->input->post('other')
          );
          $com_id = $this->complaint_model->create_complaint($form_data);
          	if ($com_id) {
              $this->load->model('complaint_model');
              $this->complaint_model->update_files($assumed_id,$com_id);
            } else {
              die("ERROR");//@TODO failure view
            }
          $signatures = $this->complaint_model->complaint_sign();
          $do_sign = $this->complaint_model->complaint_do_sign($com_id);
            //die(print_r($do_sign));
            if ($do_sign == 0) {
              foreach ($signatures as $com_signature) {
                $this->complaint_model->add_signature($com_id, $com_signature['role'], $com_signature['department'], $com_signature['rank']);
              }
            }
          redirect('/complaint/complaint_stage/'.$com_id);
        }
      }
      try {
        $this->load->helper('form');
        $this->load->model('complaint_model');
        $this->load->model('hotels_model');
        $this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());
        $this->data['operators'] = $this->complaint_model->getall_operator();
        if ($this->input->post('submit')) {
          $this->load->model('complaint_model');
          $this->data['assumed_id'] = $this->input->post('assumed_id');
          $this->data['uploads'] = $this->complaint_model->getby_fille($this->data['assumed_id']);
        } else {
          $this->data['assumed_id'] = strtoupper(str_pad(dechex( mt_rand( 0, 1048575 ) ), 5, '0', STR_PAD_LEFT));
          $this->data['uploads'] = array();
        }
        $this->load->view('complaint_add_new',$this->data);
      }
      catch( Exception $e) {
        show_error($e->getMessage()." _ ". $e->getTraceAsString());
      }
    }else{
      redirect('/unknown');
    }
  }

  public function make_offer($com_id) {
    $file_name = $this->do_upload("upload");
    if (!$file_name) {
      die(json_encode($this->data['error']));
    } else {
      $this->load->model("complaint_model");
      $this->complaint_model->add($com_id, $file_name, $this->data['user_id']);
      // $this->logger->log_event($this->data['user_id'], "Offer", "projects", $com_id, json_encode(array("offer_name" => $file_name)), "user uploaded an offer");//log
      die("{}");
    }
  }

  public function remove_offer($com_id, $id) {
    $file_name = $_POST['key'];
    if (!$id) {
      die(json_encode($this->data['error']));
    } else {
      $this->load->model("complaint_model");
      $this->complaint_model->remove($id);
      // $this->logger->log_event($this->data['user_id'], "Offer-Remove", "projects", $com_id, json_encode(array("offer_id" => $id, "file_name" => $file_name)), "user removed an offer");//log
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

  public function complaint_stage($com_id) {
    $this->load->model('complaint_model');
    $this->data['complaint'] = $this->complaint_model->get_complaint($com_id);
    if ($this->data['complaint']['state_id'] == 0) {
      $this->self_sign($com_id);
      $this->complaint_model->update_state($com_id, 1);
      redirect('/complaint/complaint_stage/'.$com_id);
    } elseif ($this->data['complaint']['state_id'] == 1 ){
      $this->notify($com_id);
      //$queue = $this->notify_signers($com_id, $this->data['complaint']['hotel_id']);
      //if (!$queue) {
        //$this->complaint_model->update_state($com_id, 2);
        //$user = $this->users_model->get_user_by_id($this->data['complaint']['user_id'], TRUE);
        //$queue = $this->approvel_mail($user->fullname, $user->email, $com_id);
        //redirect('/complaint/complaint_stage/'.$com_id);
      //}
    //}elseif ($this->data['complaint']['state_id'] == 3){
      //$user = $this->users_model->get_user_by_id($this->data['complaint']['user_id'], TRUE);
      //$queue = $this->reject_mail($user->fullname, $user->email, $com_id);
    }
    redirect('/complaint/view/'.$com_id);
  }

  private function self_sign($com_id) {
    $this->load->model('complaint_model');
    $this->complaint_model->self_sign($com_id, $this->data['user_id']);
  }

  private function notify_signers($com_id) {
    $notified = FALSE;
    $signers = $this->get_signers($com_id, $this->data['complaint']['hotel_id']);
    foreach ($signers as $signer) {
      if (isset($signer['queue'])) {
        $notified = TRUE;
        foreach ($signer['queue'] as $uid => $user) {
          $this->signatures_mail($signer['role'], $signer['department'], $user['name'], $user['mail'], $com_id);
        }
        break;
      }
    }
    return $notified;
  }

  private function approvel_mail($name, $email, $com_id) {
    $this->load->library('email');
    $this->load->helper('url');
    $com_url = base_url().'complaint/view/'.$com_id;
    $this->email->from('e-signature@sunrise-resorts.com');
    $this->email->to($email);
    $this->email->subject("Complaint After Stay Form No. #{$com_id}");
    $this->email->message("Dear {$name},<br/>
              <br/>
              Complaint After Stay Form No. #{$com_id} has been approved, Please use the link below:<br/>
              <a href='{$com_url}' target='_blank'>{$com_url}</a><br/>
              "); 
    $mail_result = $this->email->send();
  }

  private function reject_mail($name, $email, $com_id) {
    $this->load->library('email');
    $this->load->helper('url');
    $com_url = base_url().'complaint/view/'.$com_id;
    $this->email->from('e-signature@sunrise-resorts.com');
    $this->email->to($email);
    $this->email->subject("Complaint After Stay Form No. #{$com_id}");
    $this->email->message("Dear {$name},<br/>
              <br/>
             Complaint After Stay Form No. #{$com_id} has been rejected, Please use the link below:<br/>
              <a href='{$com_url}' target='_blank'>{$com_url}</a><br/>
              "); 
    $mail_result = $this->email->send();
  }

  private function get_signers($com_id, $hotel_id) {
    $this->load->model('complaint_model');
    $signatures = $this->complaint_model->getby_verbal($com_id);
    return $this->roll_signers($signatures, $hotel_id, $com_id);
  }

  private function signatures_mail($role, $department, $name, $mail, $com_id) {
    $this->load->library('email');
    $this->load->helper('url');
    $com_url = base_url().'complaint/view/'.$com_id;
    $this->email->from('e-signature@sunrise-resorts.com');
    $this->email->to($mail);
    $this->email->subject("Complaint After Stay Form No. #{$com_id}");
    $this->email->message("Dear {$name},<br/>
              <br/>
              Complaint After Stay Form No. #{$com_id} requires your signature, Please use the link below:<br/>
              <a href='{$com_url}' target='_blank'>{$com_url}</a><br/>
              "); 
    $mail_result = $this->email->send();
  }

  private function roll_signers($signatures, $hotel_id, $com_id) {
    $complaint = $this->complaint_model->get_complaint($com_id);
    $signers = array();
    $this->load->model('users_model');
    foreach ($signatures as $signature) {
      $signers[$signature['id']] = array();
      $signers[$signature['id']]['role'] = $signature['role'];
      $signers[$signature['id']]['role_id'] = $signature['role_id'];
      $signers[$signature['id']]['department'] = $signature['department'];
      $signers[$signature['id']]['department_id'] = $signature['department_id'];
      if ($signature['user_id']) {
        $signers[$signature['id']]['sign'] = array();
        $signers[$signature['id']]['sign']['id'] = $signature['user_id'];
        if ($signature['reject'] == 1) {
          $signers[$signature['id']]['sign']['reject'] = "reject";
          $this->complaint_model->update_state($com_id, 3);
        } 
        $user = $this->users_model->get_user_by_id($signature['user_id'], TRUE);
        $signers[$signature['id']]['sign']['name'] = $user->fullname;
        $signers[$signature['id']]['sign']['mail'] = $user->email;
        $signers[$signature['id']]['sign']['sign'] = $user->signature;
        $signers[$signature['id']]['sign']['timestamp'] = $signature['timestamp'];
      } else {
        $signers[$signature['id']]['queue'] = array();
        $users = $this->users_model->getby_criteria($signature['role_id'], $hotel_id);
        foreach ($users as $use) {
          $signers[$signature['id']]['queue'][$use['id']] = array();
          $signers[$signature['id']]['queue'][$use['id']]['name'] = $use['fullname'];
          $signers[$signature['id']]['queue'][$use['id']]['mail'] = $use['email'];
        }
      }
   }
    return $signers;
  }

  public function view($com_id) {
        if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
      $this->load->model('complaint_model');
      $this->load->model('hotels_model');   
      $this->data['hotels'] = $this->hotels_model->getall();
      $this->data['complaint'] = $this->complaint_model->get_complaint($com_id);
      $this->data['uploads'] = $this->complaint_model->getby_fille($com_id);
      $this->data['getcomment'] = $this->complaint_model->getcomment($com_id);
      $this->data['signature_path'] = '/assets/uploads/signatures/';
      $this->data['signers'] = $this->get_signers($this->data['complaint']['id'], $this->data['complaint']['hotel_id']);
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
        if ( $this->data['complaint']['user_id'] == $this->data['user_id'] &&  $this->data['complaint']['state_id'] == 1) {
          $editor = TRUE;
        }
      }
      $this->data['unsign_enable'] = (($unsign_enable) || $this->data['is_admin'])? TRUE : FALSE;
      $this->data['is_editor'] = ( (($this->data['unsign_enable'] || $editor)) || ($force_edit) )? TRUE : FALSE;
      $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
      $this->data['id'] = $com_id;
      $this->load->view('complaint_view', $this->data);
    }else{
      redirect('/unknown');
    }
  }

  public function edit($com_id) {
        if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
      if ($this->input->post('submit')) {
        $this->load->library('form_validation');
        $this->load->library('email');
        if ($this->form_validation->run() == FALSE) {
          $this->load->model('complaint_model');
          $this->load->model('users_model');  
          $form_data = array(
            'hotel_id' => $this->input->post('hotel_id'),
            'guest' => $this->input->post('guest'),
            'ref' => $this->input->post('ref'),
            'date' => $this->input->post('date'),
            'operator_id' => $this->input->post('operator_id'),
            'receiving' => $this->input->post('receiving'),
            'reply' => $this->input->post('reply'),
            'subject' => $this->input->post('subject'),
            'comment' => $this->input->post('comment'),
            'action' => $this->input->post('action'),
            'other' => $this->input->post('other')
          );
          $this->complaint_model->update_complaint($form_data, $com_id);
          $this->notify_edit($com_id);
          redirect('/complaint/view/'.$com_id);
        }   
      }
      try {
        $this->load->helper('form');
        $this->load->model('complaint_model');
        $this->load->model('hotels_model');
        $this->data['complaint'] = $this->complaint_model->get_complaint($com_id);
        //die(print_r());
        $this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());
        $this->data['operators'] = $this->complaint_model->getall_operator();
        $this->data['uploads'] = $this->complaint_model->getby_fille($this->data['complaint']['id']);
        $this->load->view('complaint_edit',$this->data);
      }
      catch( Exception $e) {
        show_error($e->getMessage()." _ ". $e->getTraceAsString());
      }
    }else{
      redirect('/unknown');
    }
  }

  public function index() {
        if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
      $this->load->model('hotels_model');
      $this->load->model('complaint_model');
      $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
      $hotels = array();
      foreach ($user_hotels as $hotel) {
        $hotels[] = $hotel['id'];
      }    
      $this->data['complaint'] = $this->complaint_model->view($hotels);
      foreach ($this->data['complaint'] as $key => $com) {
        $this->data['complaint'][$key]['approvals'] = $this->get_signers($this->data['complaint'][$key]['id'], $this->data['complaint'][$key]['hotel_id']);
      }
      $this->data['hotels'] = $this->hotels_model->getall();
      $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
      $this->load->view('complaint_index', $this->data);
    }else{
      redirect('/unknown');
    }
  }

  public function index_app() {
        if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
      $this->load->model('hotels_model');
      $this->load->model('complaint_model');
      $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
      $hotels = array();
      foreach ($user_hotels as $hotel) {
        $hotels[] = $hotel['id'];
      }    
      $this->data['complaint'] = $this->complaint_model->view($hotels);
      foreach ($this->data['complaint'] as $key => $com) {
        $this->data['complaint'][$key]['approvals'] = $this->get_signers($this->data['complaint'][$key]['id'], $this->data['complaint'][$key]['hotel_id']);
      }
      $this->data['hotels'] = $this->hotels_model->getall();
      $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
      $this->load->view('complaint_index_app', $this->data);
    }else{
      redirect('/unknown');
    }
  }

  public function index_wat() {
        if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
      if ($this->input->post('submit')) {
      $this->data['state'] = $this->input->post('state');
    }
      $this->load->model('hotels_model');
      $this->load->model('complaint_model');
      $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
      $hotels = array();
      foreach ($user_hotels as $hotel) {
        $hotels[] = $hotel['id'];
      }    
      $this->data['complaint'] = $this->complaint_model->view($hotels);
      foreach ($this->data['complaint'] as $key => $com) {
        $this->data['complaint'][$key]['approvals'] = $this->get_signers($this->data['complaint'][$key]['id'], $this->data['complaint'][$key]['hotel_id']);
      }
      $this->data['hotels'] = $this->hotels_model->getall();
      $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
      $this->load->view('complaint_index_wat', $this->data);
    }else{
      redirect('/unknown');
    }
  }

  public function index_rej() {
        if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
      $this->load->model('hotels_model');
      $this->load->model('complaint_model');
      $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
      $hotels = array();
      foreach ($user_hotels as $hotel) {
        $hotels[] = $hotel['id'];
      }    
      $this->data['complaint'] = $this->complaint_model->view($hotels);
      foreach ($this->data['complaint'] as $key => $com) {
        $this->data['complaint'][$key]['approvals'] = $this->get_signers($this->data['complaint'][$key]['id'], $this->data['complaint'][$key]['hotel_id']);
      }
      $this->data['hotels'] = $this->hotels_model->getall();
      $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
      $this->load->view('complaint_index_rej', $this->data);
    }else{
      redirect('/unknown');
    }
  }

  public function sign($signature_id, $reject = FALSE) {
    $this->load->model('complaint_model');
    $signature_identity = $this->complaint_model->get_signature_identity($signature_id);
    $signrs = $this->get_signers($signature_identity['com_id'], $signature_identity['hotel_id']);
    $this->data['complaint'] = $this->complaint_model->get_complaint($signature_identity['com_id']);
    if (array_key_exists($this->data['user_id'], $signrs[$signature_id]['queue'])) {
      if ($reject) {
        $this->complaint_model->reject($signature_id, $this->data['user_id']);
        redirect('/complaint/complaint_stage/'.$this->data['complaint']['id']);  
      } else {
        $this->complaint_model->sign($signature_id, $this->data['user_id']);
        redirect('/complaint/complaint_stage/'.$signature_identity['com_id']);  

      }
    }
    redirect('/complaint/view/'.$signature_identity['com_id']);
  }

  public function unsign($signature_id) {
    $this->load->model('complaint_model');
    $this->load->model('users_model');
    $signature_identity = $this->complaint_model->get_signature_identity($signature_id);
    $this->complaint_model->unsign($signature_id);
    $complaint = $this->complaint_model->get_complaint($signature_identity['com_id']);
    redirect('/complaint/view/'.$signature_identity['com_id']);
  }

  public function mailto($com_id) {
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
        $com_url = base_url().'complaint/view/'.$com_id;
        $this->email->from('e-signature@sunrise-resorts.com');
        $this->email->to($email);
        $this->email->subject("A message from {$user->fullname}, Complaint After Stay Form No. #{$com_id}");
        $this->email->message("{$user->fullname} sent you a private message regarding Complaint After Stay Form No. #{$com_id}:<br/>
                  {$message}<br />
                  <br />
                  Please use the link below to view the Complaint After Stay Form:
                  <a href='{$com_url}' target='_blank'>{$com_url}</a><br/>
                "); 
        $mail_result = $this->email->send();
      }
    }
    redirect('complaint/view/'.$com_id);
  }

  public function comment($com_id){
    if ($this->input->post('submit')) {
      $this->load->library('form_validation');
      $this->form_validation->set_rules('comment','Comment','trim|required');
        if ($this->form_validation->run() == TRUE) {
          $comment = $this->input->post('comment'); 
          $this->load->model('complaint_model');
          $comment_data = array(
            'user_id' => $this->data['user_id'],
            'com_id' => $com_id,
            'comment' => $comment
          );
          $this->complaint_model->insertcomment($comment_data);
        }
      redirect('/complaint/view/'.$com_id);
    }
  }

  public function notify($com_id) {
    $this->load->model('complaint_model');
    $this->load->model('users_model');
    $this->data['complaint'] = $this->complaint_model->get_complaint($com_id);
    $signes = $this->complaint_model->getby_verbal($com_id);
    $users = array();
    foreach ($signes as $signe){
      if ($signe['user_id'] != 30) {
        $users = $this->users_model->getby_criteria($signe['role_id'], $this->data['complaint']['hotel_id']);
        foreach($users as $user){
          $name = $user['fullname'];
          $mail = $user['email'];
          $this->load->library('email');
          $this->load->helper('url');
          $com_url = base_url().'complaint/view/'.$com_id;
          $this->email->from('e-signature@sunrise-resorts.com');
          $this->email->to($mail);
          $this->email->subject("Complaint Form No. #{$com_id}");
          $this->email->message("Dear {$name},<br/>
            <br/>
            Complaint Form No. #{$com_id} has been created, Please use the link below:<br/>
            <a href='{$com_url}' target='_blank'>{$com_url}</a><br/>
          "); 
          $mail_result = $this->email->send();
        }
      }
    }
    redirect('complaint/view/'.$com_id);
  }

  public function notify_edit($com_id) {
    $this->load->model('complaint_model');
    $this->load->model('users_model');
    $this->data['complaint'] = $this->complaint_model->get_complaint($com_id);
    $signes = $this->complaint_model->getby_verbal($com_id);
    $users = array();
    foreach ($signes as $signe){
      if ($signe['user_id'] != 30) {
        $users = $this->users_model->getby_criteria($signe['role_id'], $this->data['complaint']['hotel_id']);
        foreach($users as $user){
          $name = $user['fullname'];
          $mail = $user['email'];
          $this->load->library('email');
          $this->load->helper('url');
          $com_url = base_url().'complaint/view/'.$com_id;
          $this->email->from('e-signature@sunrise-resorts.com');
          $this->email->to($mail);
          $this->email->subject("Complaint Form No. #{$com_id}");
          $this->email->message("Dear {$name},<br/>
            <br/>
            Complaint Form No. #{$com_id} has been Edited, Please use the link below:<br/>
            <a href='{$com_url}' target='_blank'>{$com_url}</a><br/>
          "); 
          $mail_result = $this->email->send();
        }
      }
    }
  }

}

?>