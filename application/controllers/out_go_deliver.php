<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  class out_go_deliver extends CI_Controller {

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
      $this->data['menu']['active'] = "financial";
    }

    public function submit($id, $out_id) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        if ($this->input->post('submit')) {
          $this->load->library('form_validation');
          $this->load->library('email');
          $this->form_validation->set_rules('report','Report','trim|required');
          if ($this->form_validation->run() == TRUE) {
            $this->load->model('out_go_model');
            $data = array(
              'user_del_id' => $this->data['user_id'],
              'del_date' => date('Y-m-d'),
              'report' => $this->input->post('report'),
              'delivered' => 1
            );
            $this->out_go_model->update_item($id, $out_id, $data);
            $signatures = $this->out_go_model->out_del_sign();
            $do_sign = $this->out_go_model->out_del_do_sign($id);
            if ($do_sign == 0) {
              foreach ($signatures as $out_signature) {
                $this->out_go_model->add_del_signature($id, $out_signature['role'], $out_signature['department'], $out_signature['rank']);
              }
            }
            redirect('/out_go_deliver/out_stage/'.$id);
          }
        }
        try {
          $this->load->helper('form');
          $this->load->model('out_go_model');
          $this->data['item'] = $this->out_go_model->get_item($id);
          $this->data['out_go'] = $this->out_go_model->get_out_go($out_id);
          $this->data['uploads'] = $this->out_go_model->get_by_fille($out_id);
          $this->load->view('out_del_add_new',$this->data);
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
      }
    }

    public function out_stage($id) {
      $this->load->model('out_go_model');
      $this->data['item'] = $this->out_go_model->get_item($id);
      $this->data['out_go'] = $this->out_go_model->get_out_go($this->data['item']['out_id']);
      if ($this->data['item']['del_state_id'] == 0) {
        $this->out_go_model->update_del_state($id, 1);
        redirect('/out_go_deliver/out_stage/'.$id);
      }elseif ($this->data['item']['del_state_id'] == 3){
        $user = $this->users_model->get_user_by_id($this->data['item']['user_del_id'], TRUE);
        $queue = $this->reject_mail($user->fullname, $user->email, $id);
      }elseif ($this->data['item']['del_state_id'] != 2){
        $queue = $this->notify_signers($id, $this->data['out_go']['hotel_id']);
        if (!$queue) {
          $this->out_go_model->update_del_state($id, 2);
          $user = $this->users_model->get_user_by_id($this->data['item']['user_del_id'], TRUE);
          $queue = $this->approvel_mail($user->fullname, $user->email, $id);
          redirect('/out_go_deliver/out_stage/'.$id);
        }
      }
      redirect('/out_go_deliver/view/'.$id);
    }

    private function reject_mail($name, $email, $id) {
      $this->load->library('email');
      $this->load->helper('url');
      $out_url = base_url().'out_go_deliver/view/'.$id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($email);
      $this->email->subject("Out Going Delivery Report No. #{$id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
        Out Going Delivery Report No. #{$id} has been rejected, Please use the link below:
        <br/>
        <a href='{$out_url}' target='_blank'>{$out_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
    }

    private function notify_signers($id, $hotel_id) {
      $notified = FALSE;
      $signers = $this->get_signers($id, $hotel_id);
      foreach ($signers as $signer) {
        if (isset($signer['queue'])) {
          $notified = TRUE;
          foreach ($signer['queue'] as $uid => $user) {
            $this->signatures_mail($signer['role'], $signer['department'], $user['name'], $user['mail'], $id);
          }
          break;
        }
      }
      return $notified;
    }

    private function get_signers($id, $hotel_id) {
      $this->load->model('out_go_model');
      $signatures = $this->out_go_model->get_del_by_verbal($id);
      return $this->roll_signers($signatures, $hotel_id, $id);
    }

    private function roll_signers($signatures, $hotel_id, $id) {
      $signers = array();
      $this->load->model('users_model');
      $this->load->model('out_go_model');
      $item = $this->out_go_model->get_item($id);
      $out_go = $this->out_go_model->get_out_go($item['out_id']);
      foreach ($signatures as $signature) {
        $signers[$signature['id']] = array();
        $signers[$signature['id']]['role'] = $signature['role'];
        $signers[$signature['id']]['role_id'] = $signature['role_id'];
        if ($signature['rank'] == 3 ) {
          $signers[$signature['id']]['department'] = $out_go['department'];
        $signers[$signature['id']]['department_id'] = $out_go['department_id'];
        }else{
          $signers[$signature['id']]['department'] = $signature['department'];
        $signers[$signature['id']]['department_id'] = $signature['department_id'];
        }
        if ($signature['user_id']) {
          $signers[$signature['id']]['sign'] = array();
          $signers[$signature['id']]['sign']['id'] = $signature['user_id'];
          if ($signature['reject'] == 1) {
            $signers[$signature['id']]['sign']['reject'] = "reject";
            $this->out_go_model->update_del_state($id, 3);
          } 
          $user = $this->users_model->get_user_by_id($signature['user_id'], TRUE);
          $signers[$signature['id']]['sign']['name'] = $user->fullname;
          $signers[$signature['id']]['sign']['mail'] = $user->email;
          $signers[$signature['id']]['sign']['sign'] = $user->signature;
          $signers[$signature['id']]['sign']['timestamp'] = $signature['timestamp'];
        } else {
          $signers[$signature['id']]['queue'] = array();
          if ($signature['rank'] == 3 ) {
            $users = $this->users_model->getby_criteria($signature['role_id'], $hotel_id, $out_go['department_id']);
          }else{
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

    private function signatures_mail($role, $department, $name, $mail, $id) {
      $this->load->library('email');
      $this->load->helper('url');
      $out_url = base_url().'out_go_deliver/view/'.$id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($mail);
      $this->email->subject("Out Going Delivery Report No. #{$id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
        Out Going Delivery Report No. #{$id} requires your signature, Please use the link below:
        <br/>
        <a href='{$out_url}' target='_blank'>{$out_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
    }

    private function approvel_mail($name, $email, $id) {
      $this->load->library('email');
      $this->load->helper('url');
      $out_url = base_url().'out_go_deliver/view/'.$id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($email);
      $this->email->subject("Out Going Delivery Report No. #{$id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
        Out Going Delivery Report No. #{$id} has been approved, Please use the link below:
        <br/>
        <a href='{$out_url}' target='_blank'>{$out_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
    }

    public function view($id) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{      
        $this->load->model('out_go_model');
        $this->load->model('hotels_model');   
        $this->data['item'] = $this->out_go_model->get_item($id);
        $this->data['out_go'] = $this->out_go_model->get_out_go($this->data['item']['out_id']);
        $this->data['uploads'] = $this->out_go_model->get_by_fille($this->data['item']['out_id']);
        $this->data['comments'] = $this->out_go_model->get_comment($this->data['item']['out_id']);
        $this->data['signature_path'] = '/assets/uploads/signatures/';
        $this->data['signers'] = $this->get_signers($this->data['item']['id'], $this->data['out_go']['hotel_id']);
        $editor = FALSE;
        $unsign_enable = FALSE;
        $first = TRUE;
        $force_edit = FALSE;
        foreach ($this->data['signers'] as $signer) {
          if (isset($signer['sign'])) {
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
          if ( $this->data['item']['user_del_id'] == $this->data['user_id'] &&  $this->data['item']['del_state_id'] != 2) {
            $editor = TRUE;
          }
        }
        $this->data['unsign_enable'] = (($unsign_enable) || $this->data['is_admin'])? TRUE : FALSE;
        $this->data['is_editor'] = ($editor || $this->data['is_admin'])? TRUE : FALSE;
        $this->load->view('out_del_view', $this->data);
      }
    }

    public function edit($id) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        if ($this->input->post('submit')) {
          $this->load->library('form_validation');
          $this->load->library('email');
          $this->form_validation->set_rules('report','Report','trim|required');
          if ($this->form_validation->run() == TRUE) {
            $this->load->model('out_go_model');
            $data = array(
              'report' => $this->input->post('report'),
              'delivered' => 1
            );
            $this->out_go_model->update_del_item($id, $data);
            redirect('/out_go_deliver/view/'.$id);
          }   
        }
        try {
          $this->load->helper('form');
          $this->load->model('out_go_model');
          $this->data['item'] = $this->out_go_model->get_item($id);
          $this->data['out_go'] = $this->out_go_model->get_out_go($this->data['item']['out_id']);
          $this->data['uploads'] = $this->out_go_model->get_by_fille($this->data['item']['out_id']);
          $this->load->view('out_del_go_edit',$this->data);
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
      }
    }

    public function mail_me($id) {
      $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
      $this->load->library('email');
      $this->load->helper('url');
      $out_url = base_url().'out_go_deliver/view/'.$id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($user->email);
      $this->email->subject("Out Going Delivery Report No. #{$id}");
      $this->email->message("Out Going Delivery Report NO.#{$id}:
        <br/>
        Please use the link below to view The Out Going Delivery Report:
        <a href='{$out_url}' target='_blank'>{$out_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
      redirect('out_go_deliver/view/'.$id);
    }

    public function mail($id) {
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
          $out_url = base_url().'out_go_deliver/view/'.$id;
          $this->email->from('e-signature@sunrise-resorts.com');
          $this->email->to($email);
          $this->email->subject("A message from {$user->fullname}, Out Going Delivery Report No. #{$id}");
          $this->email->message("{$user->fullname} sent you a private message regarding Out Going Delivery Report No. #{$id}:
            <br/>
            {$message}
            <br />
            <br />
            Please use the link below to view the Out Going Delivery Report:
            <a href='{$out_url}' target='_blank'>{$out_url}</a>
            <br/>
          "); 
          $mail_result = $this->email->send();
        }
      }
      redirect('out_go_deliver/view/'.$id);
    }

    public function unsign($signature_id) {
      $this->load->model('out_go_model');
      $this->load->model('users_model');
      $signature_identity = $this->out_go_model->get_del_signature_identity($signature_id);
      $this->out_go_model->unsign_del($signature_id);
      redirect('/out_go_deliver/out_stage/'.$signature_identity['del_id']);  
    }

    public function sign($signature_id, $reject = FALSE) {
      $this->load->model('out_go_model');
      $signature_identity = $this->out_go_model->get_del_signature_identity($signature_id);
      if ($reject) {
        $this->out_go_model->reject_led($signature_id, $this->data['user_id']);
        redirect('/out_go_deliver/out_stage/'.$signature_identity['del_id']);  
      } else {
        $this->out_go_model->sign_led($signature_id, $this->data['user_id']);
        redirect('/out_go_deliver/out_stage/'.$signature_identity['del_id']);  
      }
      redirect('/out_go_deliver/view/'.$signature_identity['del_id']);
    }

    public function comment($out_id){
      if ($this->input->post('submit')) {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('comment','Comment','trim|required');
        if ($this->form_validation->run() == TRUE) {
          $comment = $this->input->post('comment'); 
          $this->load->model('out_go_model');
          $comment_data = array(
            'user_id' => $this->data['user_id'],
            'out_id' => $out_id,
            'comment' => $comment
          );
          $this->out_go_model->insert_comment($comment_data);
        }
        redirect('/out_go_deliver/view/'.$out_id);
      }
    }

  }

?>