<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  class position extends CI_Controller {

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
      $this->data['menu']['active'] = "hr";
    }

    public function index() {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{            
        $this->load->model('hotels_model');
        $this->load->model('position_model');
        $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
        $hotels = array();
        foreach ($user_hotels as $hotel) {
          $hotels[] = $hotel['id'];
        }    
        $this->data['position'] = $this->position_model->view($hotels);
        foreach ($this->data['position'] as $key => $pos) {
          $this->data['position'][$key]['requests'] = $this->position_model->get_request($this->data['position'][$key]['id']);
        }
        foreach ($this->data['position'] as $key => $pos) {
          $this->data['position'][$key]['approvals'] = $this->get_signers($this->data['position'][$key]['id'], $this->data['position'][$key]['hotel_id']);
        }
        $this->data['hotels'] = $this->hotels_model->getall();
        $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
        $this->load->view('position_index', $this->data);
      }
    }

    public function submit() {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{      
        if ($this->input->post('submit')) {
          $this->load->library('form_validation');
          $this->load->library('email');
          $this->form_validation->set_rules('hotel_id','Hotel Name','trim|required');
          if ($this->form_validation->run() == TRUE) {
            $this->load->model('position_model');
            $this->load->model('users_model');  
            $form_data = array(
              'user_id' => $this->data['user_id'],
              'role_id' => $this->data['role_id'],
              'department_id' => $this->data['department_id'],              
              'hotel_id' => $this->input->post('hotel_id'),
              'date' => $this->input->post('date')
            );
            $pos_id = $this->position_model->create_pos($form_data);
          	if (!$pos_id) {
              die("ERROR");
            }
            foreach ($this->input->post('requests') as $request) {
              $request['pos_id'] = $pos_id;  
              $req_id = $this->position_model->create_request($request);   
              if (!$req_id) {
                die("ERROR");
              }
            }
            $do_sign = $this->position_model->pos_do_sign($pos_id);
            //die(print_r($do_sign));
            if ($do_sign == 0) {
              $this->position_model->add_signature($pos_id, $form_data['role_id'], $form_data['department_id'], 1);
              $signatures = $this->position_model->pos_sign();
              foreach ($signatures as $pos_signature) {
                $this->position_model->add_signature($pos_id, $pos_signature['role'], $pos_signature['department'], $pos_signature['rank']);
              }
            }
            redirect('/position/position_stage/'.$pos_id);
          }
        }
        try {
          $this->load->helper('form');
          $this->load->model('position_model');
          $this->load->model('hotels_model');
          $this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());
          $this->load->view('position_add_new',$this->data);
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
      }
    }

    public function position_stage($pos_id) {
      $this->load->model('position_model');
      $this->data['position'] = $this->position_model->get_position($pos_id);
      if ($this->data['position']['state_id'] == 0) {
        $this->self_sign($pos_id);
        $this->position_model->update_state($pos_id, 1);
        redirect('/position/position_stage/'.$pos_id);
      } elseif ($this->data['position']['state_id'] == 1){
        $queue = $this->notify_signers($pos_id, $this->data['position']['hotel_id']);
        if (!$queue) {
          $this->position_model->update_state($pos_id, 2);
          $this->notify($pos_id);
          $user = $this->users_model->get_user_by_id($this->data['position']['user_id'], TRUE);
          $queue = $this->approvel_mail($user->fullname, $user->email, $pos_id);
          redirect('/position/position_stage/'.$pos_id);
        }
      }elseif ($this->data['position']['state_id'] == 3){
        $user = $this->users_model->get_user_by_id($this->data['position']['user_id'], TRUE);
        $queue = $this->reject_mail($user->fullname, $user->email, $pos_id);
      }
      redirect('/position/view/'.$pos_id);
    }

    private function self_sign($pos_id) {
      $this->load->model('position_model');
      $this->position_model->self_sign($pos_id, $this->data['user_id'], $this->data['role_id'], $this->data['department_id'] );
    }

    private function notify_signers($pos_id) {
      $notified = FALSE;
      $signers = $this->get_signers($pos_id, $this->data['position']['hotel_id']);
      foreach ($signers as $signer) {
        if (isset($signer['queue'])) {
          $notified = TRUE;
          foreach ($signer['queue'] as $uid => $user) {
            $this->signatures_mail($signer['role'], $signer['department'], $user['name'], $user['mail'], $pos_id);
          }
          break;
        }
      }
      return $notified;
    }

    private function get_signers($pos_id, $hotel_id) {
      $this->load->model('position_model');
      $signatures = $this->position_model->getby_verbal($pos_id);
      return $this->roll_signers($signatures, $hotel_id, $pos_id);
    }

    private function roll_signers($signatures, $hotel_id, $pos_id) {
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
            $this->position_model->update_state($pos_id, 3);
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

    private function signatures_mail($role, $department, $name, $mail, $pos_id) {
      $this->load->library('email');
      $this->load->helper('url');
      $pos_url = base_url().'position/view/'.$pos_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($mail);
      $this->email->subject("Vacant Position Request No. #{$pos_id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
        Vacant Position Request No. #{$pos_id} requires your signature, Please use the link below:
        <br/>
        <a href='{$pos_url}' target='_blank'>{$pos_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
    }

    public function notify($pos_id) {
      $this->load->model('position_model');
      $this->load->model('users_model');
      $this->load->model('hotels_model');
      $this->data['position'] = $this->position_model->get_position($pos_id);
      $signes = $this->position_model->pos_sign($pos_id);
      $users = array();
      foreach ($signes as $signe){
        $hotels = $this->hotels_model->getall();  
        foreach ($hotels as $hotel){
          $users = $this->users_model->getby_criteria($signe['role'], $hotel['id'], $signe['department']);
        }
        foreach($users as $user){
          if ($user['id'] != 30) {
            $name = $user['fullname'];
            $mail = $user['email'];
            $this->load->library('email');
            $this->load->helper('url');
            $pos_url = base_url().'position/view/'.$pos_id;
            $this->email->from('e-signature@sunrise-resorts.com');
            $this->email->to($mail);
            $this->email->subject("Vacant Position Request No. #{$pos_id}");
            $this->email->message("Dear {$name},
              <br/>
              <br/>
              Vacant Position Request No. #{$pos_id} has been created and need your replay, Please use the link below:
              <br/>
              <a href='{$pos_url}' target='_blank'>{$pos_url}</a>
              <br/>
            "); 
            $mail_result = $this->email->send();
          }
        }
      }
      redirect('position/view/'.$pos_id);
    }

    private function approvel_mail($name, $email, $pos_id) {
      $this->load->library('email');
      $this->load->helper('url');
      $pos_url = base_url().'position/view/'.$pos_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($email);
      $this->email->subject("Vacant Position Request No. #{$pos_id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
        Vacant Position Request No. #{$pos_id} has been approved, Please use the link below:
        <br/>
        <a href='{$pos_url}' target='_blank'>{$pos_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
    }

    private function reject_mail($name, $email, $pos_id) {
      $this->load->library('email');
      $this->load->helper('url');
      $pos_url = base_url().'position/view/'.$pos_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($email);
      $this->email->subject("Vacant Position Request No. #{$pos_id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
        Vacant Position Request No. #{$pos_id} has been rejected, Please use the link below:
        <br/>
        <a href='{$pos_url}' target='_blank'>{$pos_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
    }

    public function view($pos_id) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{      
        $this->load->model('position_model');
        $this->load->model('hotels_model');   
        $this->data['position'] = $this->position_model->get_position($pos_id);
        $this->data['requests'] = $this->position_model->get_request($pos_id);
        $this->data['replaies'] = $this->position_model->get_pos_repaly($pos_id);
        if ($this->data['replaies']) {
          foreach ($this->data['replaies'] as $key => $rep) {
            $this->data['replaies'][$key]['requires'] = $this->position_model->get_require($this->data['replaies'][$key]['base_id'], $this->data['replaies'][$key]['pos_id']);
          }
          foreach ($this->data['replaies'] as $key => $rep) {
            $this->data['replaies'][$key]['replay_signers'] = $this->get_replay_signers($this->data['replaies'][$key]['id'], $this->data['replaies'][$key]['hotel_id']);
          }
        }
        $this->data['comments'] = $this->position_model->get_comment($pos_id);
        $this->data['signature_path'] = '/assets/uploads/signatures/';
        $this->data['signers'] = $this->get_signers($this->data['position']['id'], $this->data['position']['hotel_id']);
        $editor = FALSE;
        $unsign_enable = FALSE;
        $first = TRUE;
        $force_edit = FALSE;
        foreach ($this->data['signers'] as $signer) {
          if (isset($signer['queue'])) {
            foreach ($signer['queue'] as $uid => $dummy) {
              if ( $uid == $this->data['user_id'] ) {
                $unsign_enable = TRUE;
              }
            }
          }
        }
        if (isset($this->data['user_id'])) {
          if ( ($this->data['position']['user_id'] == $this->data['user_id']) && ($this->data['position']['state_id']!= 2)) {
            $editor = TRUE;
          }
        }
        $this->data['unsign_enable'] = (($unsign_enable) || $this->data['is_admin'])? TRUE : FALSE;
        $this->data['is_editor'] = (($editor) || $this->data['is_admin'])? TRUE : FALSE;
        $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
        $this->load->view('position_view', $this->data);
      }
    }

    public function mail_to($pos_id) {
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
          $pos_url = base_url().'position/view/'.$pos_id;
          $this->email->from('e-signature@sunrise-resorts.com');
          $this->email->to($email);
          $this->email->subject("A message from {$user->fullname}, Vacant Position Request No. #{$pos_id}");
          $this->email->message("{$user->fullname} sent you a private message regarding Vacant Position Request No. #{$pos_id}:
            <br/>
            {$message}
            <br />
            <br />
            Please use the link below to view the Vacant Position Request:
            <a href='{$pos_url}' target='_blank'>{$pos_url}</a>
            <br/>
          "); 
          $mail_result = $this->email->send();
        }
      }
      redirect('position/view/'.$pos_id);
    }

    public function unsign($signature_id) {
      $this->load->model('position_model');
      $this->load->model('users_model');
      $signature_identity = $this->position_model->get_signature_identity($signature_id);
      $this->position_model->unsign($signature_id);
      $position = $this->position_model->get_position($signature_identity['pos_id']);
      redirect('/position/view/'.$signature_identity['pos_id']);
    }

    public function sign($signature_id, $reject = FALSE) {
      $this->load->model('position_model');
      $signature_identity = $this->position_model->get_signature_identity($signature_id);
      $signrs = $this->get_signers($signature_identity['pos_id'], $signature_identity['hotel_id']);
      $this->data['position'] = $this->position_model->get_position($signature_identity['pos_id']);
      if (array_key_exists($this->data['user_id'], $signrs[$signature_id]['queue'])) {
        if ($reject) {
          $this->position_model->reject($signature_id, $this->data['user_id']);
          redirect('/position/position_stage/'.$this->data['position']['id']);  
        } else {
          $this->position_model->sign($signature_id, $this->data['user_id']);
          redirect('/position/position_stage/'.$signature_identity['pos_id']);  
        }
      }
      redirect('/position/view/'.$signature_identity['pos_id']);
    }

    public function comment($pos_id){
      if ($this->input->post('submit')) {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('comment','Comment','trim|required');
        if ($this->form_validation->run() == TRUE) {
          $comment = $this->input->post('comment'); 
          $this->load->model('position_model');
          $comment_data = array(
            'user_id' => $this->data['user_id'],
            'pos_id' => $pos_id,
            'comment' => $comment
          );
          $this->position_model->insert_comment($comment_data);
        }
        redirect('/position/view/'.$pos_id);
      }
    }

    public function edit($pos_id) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{  
        if ($this->input->post('submit')) {
          $this->load->library('form_validation');
          $this->load->library('email');
          $this->form_validation->set_rules('hotel_id','Hotel Name','trim|required');
          if ($this->form_validation->run() == TRUE) {
            $this->load->model('position_model');
            $this->load->model('users_model');  
            $form_data = array(
              'hotel_id' => $this->input->post('hotel_id'),
              'date' => $this->input->post('date')
            );
            $this->position_model->update_position($form_data, $pos_id);
            foreach ($this->input->post('requests') as $request) {
              $request['pos_id'] = $pos_id;  
              $this->position_model->update_request($request, $pos_id, $request['id']);   
            }
            redirect('/position/view/'.$pos_id);
          }   
        }
        try {
          $this->load->helper('form');
          $this->load->model('position_model');
          $this->load->model('hotels_model');
          $this->data['position'] = $this->position_model->get_position($pos_id);
          $this->data['requests'] = $this->position_model->get_request($pos_id);
          $this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());
          $this->load->view('position_edit',$this->data);
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
      }
    }

    public function replay($pos_id) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{  
        if ($this->input->post('submit')) {
          $this->load->library('form_validation');
          $this->load->library('email');
          if ($this->form_validation->run() == False) {
            $this->load->model('position_model');
            $this->load->model('users_model');
            $form_data = array(
              'user_id' => $this->data['user_id'],
              'pos_id' => $pos_id
            );
            $base_id = $this->position_model->create_base($form_data);
            if (!$base_id) {
              die("ERROR");
            }
            $position = $this->position_model->get_position($pos_id);
            foreach ($this->input->post('replaies') as $replay) {
              $replay['pos_id'] = $pos_id;  
              $replay['base_id'] = $base_id;  
              $replay['user_id'] = $this->data['user_id'];  
              $rep_id = $this->position_model->create_replay($replay);   
              if (!$rep_id) {
                die("ERROR");
              }
              if ($replay['replay'] == 1) {
                $do_sign = $this->position_model->rep_do_sign($rep_id);
                  //die(print_r($do_sign));
                  if ($do_sign == 0) {
                    $this->position_model->add_replay_signature($pos_id, $rep_id, $position['role_id'], $position['department_id'], 1, $replay['hotel_id']);
                    $signatures = $this->position_model->rep_sign();
                    foreach ($signatures as $rep_signature) {
                      $this->position_model->add_replay_signature($pos_id, $rep_id, $rep_signature['role'], $rep_signature['department'], $rep_signature['rank'], $replay['hotel_id']);
                    }
                  }
              }
            }
            redirect('/position/replay_stage/'.$pos_id.'/'.$base_id);
          }
        }
        try {
          $this->load->helper('form');
          $this->load->model('position_model');
          $this->load->model('hotels_model');
          $this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());
          $this->load->view('replay_add_new',$this->data);
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
      }
    }

    public function replay_stage($pos_id, $base_id) {
      $this->load->model('position_model');
      $this->data['replay'] = $this->position_model->get_repaly($base_id);
      foreach ($this->data['replay'] as $replay) {
        if ($replay['state_id'] == 0) {
          foreach ($this->data['replay'] as $replay) {
            if ($replay['replay'] == 1) {
              $this->position_model->update_replay_state($replay['id'], 1);
            }else{
              $this->position_model->update_replay_state($replay['id'], 4);
            }
          }
          redirect('/position/replay_stage/'.$pos_id.'/'.$base_id);
        }elseif ($replay['state_id'] == 1){
          foreach ($this->data['replay'] as $replay) {
            $queue = $this->notify_replay_signers($pos_id, $replay['id'], $replay['hotel_id']);
          }
          if (!$queue) {
            foreach ($this->data['replay'] as $replay) {
              $this->position_model->update_replay_state($replay['id'], 2);
              $user = $this->users_model->get_user_by_id($replay['user_id'], TRUE);
              $queue = $this->replay_approvel_mail($user->fullname, $user->email, $pos_id);
            }
            redirect('/position/replay_stage/'.$pos_id.'/'.$base_id);
          }
        }elseif ($replay['state_id'] == 3){
          foreach ($this->data['replay'] as $replay) {
            $user = $this->users_model->get_user_by_id($replay['user_id'], TRUE);
            $queue = $this->replay_reject_mail($user->fullname, $user->email, $pos_id);
          }
        }
      }
      redirect('/position/employee/'.$pos_id.'/'.$base_id);
    }

    private function notify_replay_signers($pos_id, $rep_id, $hotel_id) {
      $notified = FALSE;
      $signers = $this->get_replay_signers($rep_id, $hotel_id);
      foreach ($signers as $signer) {
        if (isset($signer['queue'])) {
          $notified = TRUE;
          foreach ($signer['queue'] as $uid => $user) {
            $this->replay_signatures_mail($signer['role'], $signer['department'], $user['name'], $user['mail'], $pos_id);
          }
          break;
        }
      }
      return $notified;
    }

    private function get_replay_signers($rep_id, $hotel_id) {
      $this->load->model('position_model');
      $signatures = $this->position_model->getby_verbal_replay($rep_id, $hotel_id);
      return $this->roll_replay_signers($signatures, $hotel_id, $rep_id);
    }

    private function roll_replay_signers($signatures, $hotel_id, $rep_id) {
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
            $this->position_model->update_replay_state($rep_id, 3);
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

    private function replay_signatures_mail($role, $department, $name, $mail, $pos_id) {
      $this->load->library('email');
      $this->load->helper('url');
      $pos_url = base_url().'position/view/'.$pos_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($mail);
      $this->email->subject("Vacant Position Request No. #{$pos_id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
        Vacant Position Request No. #{$pos_id} requires your signature on the Replay from your Hotel, Please use the link below:
        <br/>
        <a href='{$pos_url}' target='_blank'>{$pos_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
    }

    private function replay_approvel_mail($name, $email, $pos_id) {
      $this->load->library('email');
      $this->load->helper('url');
      $pos_url = base_url().'position/view/'.$pos_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($email);
      $this->email->subject("Vacant Position Request No. #{$pos_id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
        Vacant Position Request No. #{$pos_id} Replay has been approved, Please use the link below:
        <br/>
        <a href='{$pos_url}' target='_blank'>{$pos_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
    }

    private function replay_reject_mail($name, $email, $pos_id) {
      $this->load->library('email');
      $this->load->helper('url');
      $pos_url = base_url().'position/view/'.$pos_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($email);
      $this->email->subject("Vacant Position Request No. #{$pos_id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
        Vacant Position Request No. #{$pos_id} Replay has been rejected, Please use the link below:
        <br/>
        <a href='{$pos_url}' target='_blank'>{$pos_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
    }

    public function employee($pos_id, $base_id) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{  
        if ($this->input->post('submit')) {
          $this->load->library('form_validation');
          $this->load->library('email');
          if ($this->form_validation->run() == False) {
            $this->load->model('position_model');
            $this->load->model('users_model'); 
            foreach ($this->input->post('requires') as $require) {
              $require['pos_id'] = $pos_id;  
              $require['base_id'] = $base_id;  
              $rer_id = $this->position_model->create_require($require);   
              if (!$rer_id) {
                die("ERROR");
              }
            }
            redirect('/position/view/'.$pos_id);
          }
        }
        try {
          $this->load->helper('form');
          $this->load->model('position_model');
          $this->load->model('hotels_model');
          $this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());
          $this->load->view('require_add_new',$this->data);
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
      }
    }

    public function mail_to_replay($pos_id) {
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
          $pos_url = base_url().'position/view/'.$pos_id;
          $this->email->from('e-signature@sunrise-resorts.com');
          $this->email->to($email);
          $this->email->subject("A message from {$user->fullname}, Vacant Position Request No. #{$pos_id}");
          $this->email->message("{$user->fullname} sent you a private message regarding the Hotel Replay on Vacant Position Request No. #{$pos_id}:
            <br/>
            {$message}
            <br />
            <br />
            Please use the link below to view the Vacant Position Request:
            <a href='{$pos_url}' target='_blank'>{$pos_url}</a>
            <br/>
          "); 
          $mail_result = $this->email->send();
        }
      }
      redirect('position/view/'.$pos_id);
    }

    public function replay_unsign($signature_id) {
      $this->load->model('position_model');
      $this->load->model('users_model');
      $signature_identity = $this->position_model->get_replay_signature_identity($signature_id);
      $this->position_model->unsign_replay($signature_id);
      $position = $this->position_model->get_position($signature_identity['pos_id']);
      redirect('/position/view/'.$signature_identity['pos_id']);
    }

    public function replay_sign($signature_id, $reject = FALSE) {
      $this->load->model('position_model');
      $signature_identity = $this->position_model->get_replay_signature_identity($signature_id);
      $signrs = $this->get_replay_signers($signature_identity['rep_id'], $signature_identity['hotel_id']);
      $this->data['position'] = $this->position_model->get_position($signature_identity['pos_id']);
      if (array_key_exists($this->data['user_id'], $signrs[$signature_id]['queue'])) {
        if ($reject) {
          $this->position_model->reject_replay($signature_id, $this->data['user_id']);
          redirect('/position/position_stage/'.$this->data['position']['id']);  
        } else {
          $this->position_model->sign_replay($signature_id, $this->data['user_id']);
          redirect('/position/position_stage/'.$signature_identity['pos_id']);  
        }
      }
      redirect('/position/view/'.$signature_identity['pos_id']);
    }

  }

?>