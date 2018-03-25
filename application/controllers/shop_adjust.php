<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  class shop_adjust extends CI_Controller {

    private $data;

  public function __construct() {
      parent::__construct();
      $this->load->model('shop_adjust_model');
      $this->load->model('tank_auth/users_model');  
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
    public function submit($shop_id) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        if ($this->input->post('submit')) {
          $this->load->library('form_validation');
          $this->load->library('email');
          $this->form_validation->set_rules('new_rent','New rent','trim|required');
          $this->form_validation->set_rules('from_date','From date','trim|required');
          $this->form_validation->set_rules('to_date','Till date','trim|required');
          $this->form_validation->set_rules('effective_date','Effective Date of adjustment','trim|required');
          $assumed_id = $this->input->post('assumed_id');              
          if ($this->form_validation->run() == TRUE) {
            $form_data = array(
              'user_id' => $this->data['user_id'],
              'shop_id' => $shop_id,
              'new_rent' => $this->input->post('new_rent'),
              'from_date' => $this->input->post('from_date'), 
              'to_date' => $this->input->post('to_date'),
              'effective_date' => $this->input->post('effective_date'),
            );
            $adjust_id = $this->shop_adjust_model->create_shop_adjust($form_data);
            if ($adjust_id) {
              $this->shop_adjust_model->update_files($assumed_id,$adjust_id);
            } else {
              die("error");
            }
            $signatures = $this->shop_adjust_model->shop_adjust_sign();
            $do_sign = $this->shop_adjust_model->shop_adjust_do_sign($adjust_id);
            if ($do_sign == 0) {
              foreach ($signatures as $adjust_signature) {
                $this->shop_adjust_model->add_signature($adjust_id,$shop_id,$adjust_signature['role'],$adjust_signature['department'],$adjust_signature['rank']);
              }
            }
            redirect('/shop_adjust/adjust_stage/'.$adjust_id."/".$shop_id);
          }   
        } 
        try {
          $this->load->helper('form');
          if ($this->input->post('submit')) {
            $this->data['assumed_id'] = $this->input->post('assumed_id');
            $this->data['uploads'] = $this->shop_adjust_model->getby_fille($this->data['assumed_id']);
          } else {
            $this->data['assumed_id'] = strtoupper(str_pad(dechex( mt_rand( 0, 1048575 ) ), 5, '0', STR_PAD_LEFT));
            $this->data['uploads'] = array();
          }
          $this->load->view('shop_adjust_add_new',$this->data);
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
     }
    }
    public function edit($adjust_id,$shop_id) {
       if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        if ($this->input->post('submit')) {
          $this->load->library('form_validation');
          $this->load->library('email');
          $this->form_validation->set_rules('new_rent','New rent','trim|required');
          $this->form_validation->set_rules('from_date','From date','trim|required');
          $this->form_validation->set_rules('to_date','Till date','trim|required');
          $this->form_validation->set_rules('effective_date','Effective Date of adjustment','trim|required');
          $assumed_id = $this->input->post('assumed_id');              
          if ($this->form_validation->run() == TRUE) {
            $form_data = array(
              'new_rent' => $this->input->post('new_rent'),
              'from_date' => $this->input->post('from_date'), 
              'to_date' => $this->input->post('to_date'),
              'effective_date' => $this->input->post('effective_date'),
            );
            $this->shop_adjust_model->update_shop_adjust($adjust_id, $form_data);
            $this->notify_edit($adjust_id,$shop_id, $this->data['user_id']);
            $this->notification($adjust_id,$shop_id, $this->data['user_id']);
            redirect('/shop_adjust/view/'.$adjust_id."/".$shop_id);
          }   
        }
        try {
          $this->load->helper('form');
          $this->load->model('hotels_model');
          $this->data['shop_adjust'] = $this->shop_adjust_model->get_shop_adjust($adjust_id,$shop_id);
          $this->data['uploads'] = $this->shop_adjust_model->getby_fille($adjust_id);          
          $this->load->view('shop_adjust_edit',$this->data);
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
      }
    }
    
   public function upload($adjust_id) {
      $file_name = $this->do_upload("upload");
      if (!$file_name) {
        die(json_encode($this->data['error']));
      } else {
        $this->shop_adjust_model->add_fille($adjust_id, $file_name, $this->data['user_id']);
        die("{}");
      }
    }

    public function remove($adjust_id, $id) {
      $file_name = $_POST['key'];
      if (!$id) {
        die(json_encode($this->data['error']));
      } else {
        $this->shop_adjust_model->remove_fille($id);
        die("{}");
      }
    }

    private function do_upload($field) {
      $config['upload_path'] = 'assets/uploads/files/';
      $config['allowed_types'] = '*';
      $this->load->library('upload', $config);
      if ( ! $this->upload->do_upload($field)) {
        $this->data['error'] = array('error' => $this->upload->display_errors());
        return FALSE;
      } else {
        $file = $this->upload->data();
        return $file['file_name'];
      }
    }  
   public function adjust_stage($adjust_id,$shop_id) {
      $this->data['shop_adjust'] = $this->shop_adjust_model->get_shop_adjust($adjust_id,$shop_id);
      if ($this->data['shop_adjust']['state_id'] == 0) {
        $this->shop_adjust_model->update_state($adjust_id, 1);
        redirect('/shop_adjust/adjust_stage/'.$adjust_id."/".$shop_id);
      }elseif ($this->data['shop_adjust']['state_id'] == 3){
        $user = $this->users_model->get_user_by_id($this->data['shop_adjust']['user_id'], TRUE);
        $queue = $this->reject_mail($user->fullname, $user->email, $adjust_id,$shop_id);
      }elseif ($this->data['shop_adjust']['state_id'] != 2){
        $queue = $this->notify_signers($adjust_id,$shop_id, $this->data['shop_adjust']['hotel_id']);
        if (!$queue) {
          $this->shop_adjust_model->update_state($adjust_id, 2);
          $user = $this->users_model->get_user_by_id($this->data['shop_adjust']['user_id'], TRUE);
          $queue = $this->approvel_mail($user->fullname, $user->email, $adjust_id,$shop_id);
          redirect('/shop_adjust/adjust_stage/'.$adjust_id."/".$shop_id);
        }
      }
      redirect('/shop_adjust/view/'.$adjust_id."/".$shop_id);
    }  
  private function reject_mail($name, $email, $adjust_id,$shop_id) {
      $this->load->library('email');
      $this->load->helper('url');
      $form_url = base_url().'shop_adjust/view/'.$adjust_id."/".$shop_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($email);
      $this->email->subject("Rent Adjustment Form No. #{$adjust_id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
       Rent Adjustment Form No. #{$adjust_id} has been rejected, Please use the link below:
        <br/>
        <a href='{$form_url}' target='_blank'>{$form_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
    } 
   private function signatures_mail($role, $department, $name, $mail, $adjust_id,$shop_id) {
      $this->load->library('email');
      $this->load->helper('url');
      $form_url = base_url().'shop_adjust/view/'.$adjust_id."/".$shop_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($mail);
      $this->email->subject("Rent Adjustment Form No. #{$adjust_id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
        Rent Adjustment Form No. #{$adjust_id} requires your signature, Please use the link below:
        <br/>
        <a href='{$form_url}' target='_blank'>{$form_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
    } 
 private function approvel_mail($name, $email, $adjust_id,$shop_id) {
      $this->load->library('email');
      $this->load->helper('url');
      $form_url = base_url().'shop_adjust/view/'.$adjust_id."/".$shop_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($email);
      $this->email->subject("Rent Adjustment Form No. #{$adjust_id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
       Rent Adjustment Form No. #{$adjust_id} has been approved, Please use the link below:
        <br/>
        <a href='{$form_url}' target='_blank'>{$form_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
    } 
  
  private function notify_signers($adjust_id,$shop_id,$hotel_id) {
      $notified = FALSE;
      $signers = $this->get_signers($adjust_id,$shop_id,$hotel_id);
      foreach ($signers as $signer) {
        if (isset($signer['queue'])) {
          $notified = TRUE;
          foreach ($signer['queue'] as $uid => $user) {
            $this->signatures_mail($signer['role'], $signer['department'], $user['name'], $user['mail'], $adjust_id,$shop_id);
          }
          break;
        }
      }
      return $notified;
     }
   private function get_signers($adjust_id,$shop_id,$hotel_id) {
      $signatures = $this->shop_adjust_model->get_by_verbal($adjust_id);
      return $this->roll_signers($signatures, $hotel_id, $adjust_id,$shop_id);
     }
   private function roll_signers($signatures, $hotel_id, $adjust_id,$shop_id) {
      $signers = array();
      $shop_adjust = $this->shop_adjust_model->get_shop_adjust($adjust_id,$shop_id);
      foreach ($signatures as $signature) {
        $signers[$signature['id']] = array();
        $signers[$signature['id']]['role'] = $signature['role'];
        $signers[$signature['id']]['role_id'] = $signature['role_id'];
        $signers[$signature['id']]['department'] = $signature['department'];
        $signers[$signature['id']]['department_id'] = $signature['department_id'];
        if ($signature['user_id']) {
          if ($signature['rank'] == 1){
            $this->shop_adjust_model->update_state($adjust_id, 4);
          }elseif ($signature['rank'] == 2){
            $this->shop_adjust_model->update_state($adjust_id, 5);
          }elseif ($signature['rank'] == 3){
            $this->shop_adjust_model->update_state($adjust_id, 6);
          }elseif ($signature['rank'] == 4){
            $this->shop_adjust_model->update_state($adjust_id, 7);
          }elseif ($signature['rank'] == 5){
            $this->shop_adjust_model->update_state($adjust_id, 8);
          }elseif ($signature['rank'] == 6){
            $this->shop_adjust_model->update_state($adjust_id, 2);
          }
          $signers[$signature['id']]['sign'] = array();
          $signers[$signature['id']]['sign']['id'] = $signature['user_id'];
          if ($signature['reject'] == 1) {
            $signers[$signature['id']]['sign']['reject'] = "reject";
            $this->shop_adjust_model->update_state($adjust_id, 3);
          } 
          $user = $this->users_model->get_user_by_id($signature['user_id'], TRUE);
          $signers[$signature['id']]['sign']['name'] = $user->fullname;
          $signers[$signature['id']]['sign']['mail'] = $user->email;
          $signers[$signature['id']]['sign']['sign'] = $user->signature;
          $signers[$signature['id']]['sign']['timestamp'] = $signature['timestamp'];
        } else {
          $signers[$signature['id']]['queue'] = array();
          if ($signature['rank'] == 1 ) {
            $users = $this->users_model->getby_criteria($signature['role_id'], $hotel_id, $signature['department_id']);
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
 public function view($adjust_id,$shop_id) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{     
        $this->load->model('shop_renting_model'); 
        $this->load->model('hotels_model');   
        $this->data['shop_adjust'] = $this->shop_adjust_model->get_shop_adjust($adjust_id,$shop_id);
        $this->data['shop'] = $this->shop_renting_model->get_shop($shop_id);
        $this->data['uploads'] = $this->shop_adjust_model->getby_fille($adjust_id);
        $this->data['comments'] = $this->shop_adjust_model->get_comment($adjust_id);
        $this->data['signature_path'] = '/assets/uploads/signatures/';
        $this->data['signers'] = $this->get_signers($this->data['shop_adjust']['id'],$this->data['shop_adjust']['shop_id'], $this->data['shop_adjust']['hotel_id']);
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
          if ( $this->data['shop_adjust']['user_id'] == $this->data['user_id'] &&  $this->data['shop_adjust']['state_id'] != 2) {
            $editor = TRUE;
          }
        }
        $this->data['unsign_enable'] = (($unsign_enable) || $this->data['is_admin'])? TRUE : FALSE;
        $this->data['is_editor'] = ($editor || $this->data['is_admin'])? TRUE : FALSE;
        $this->load->view('shop_adjust_view', $this->data);
      }
    }
   public function mail_me($adjust_id,$shop_id) {
      $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
      $this->load->library('email');
      $this->load->helper('url');
      $form_url = base_url().'shop_adjust/view/'.$adjust_id."/".$shop_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($user->email);
      $this->email->subject("Rent Adjustment Form No. #{$adjust_id}");
      $this->email->message("Rent Adjustment Form No.#{$adjust_id}:
        <br/>
        Please use the link below to view The Rent Adjustment Form:
        <a href='{$form_url}' target='_blank'>{$form_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
      redirect('shop_adjust/view/'.$adjust_id."/".$shop_id);
    }

    public function mail($adjust_id,$shop_id) {
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
          $form_url = base_url().'shop_adjust/view/'.$adjust_id."/".$shop_id;
          $this->email->from('e-signature@sunrise-resorts.com');
          $this->email->to($email);
          $this->email->subject("A message from {$user->fullname}, Rent Adjustment Form No. #{$adjust_id}");
          $this->email->message("{$user->fullname} sent you a private message regarding Rent Adjustment Form No. #{$adjust_id}:
            <br/>
            {$message}
            <br />
            <br />
            Please use the link below to view the Rent Adjustment Form :
            <a href='{$form_url}' target='_blank'>{$form_url}</a>
            <br/>
          "); 
          $mail_result = $this->email->send();
        }
      }
      redirect('shop_adjust/view/'.$adjust_id."/".$shop_id);
    }
  public function unsign($signature_id) {
      $signature_identity = $this->shop_adjust_model->get_signature_identity($signature_id);
      $this->shop_adjust_model->unsign($signature_id);
      $this->shop_adjust_model->update_state($signature_identity['shop_adjustment_id'], 1);
     redirect('/shop_adjust/adjust_stage/'.$signature_identity['shop_adjustment_id']."/".$signature_identity['shop_id']);  
    }

    public function sign($signature_id, $reject = FALSE) {
      $signature_identity = $this->shop_adjust_model->get_signature_identity($signature_id);
      $signrs = $this->get_signers($signature_identity['shop_adjustment_id'],$signature_identity['shop_id'], $signature_identity['hotel_id']);
      if (array_key_exists($this->data['user_id'], $signrs[$signature_id]['queue'])) {
        if ($reject) {
          $this->shop_adjust_model->reject($signature_id, $this->data['user_id']);
          $this->shop_adjust_model->update_state($signature_identity['shop_adjustment_id'], 3);
          redirect('/shop_adjust/adjust_stage/'.$signature_identity['shop_adjustment_id']."/".$signature_identity['shop_id']);  
        } else {
          $this->shop_adjust_model->sign($signature_id, $this->data['user_id']);
          //die(print_r($signature_id));
         redirect('/shop_adjust/adjust_stage/'.$signature_identity['shop_adjustment_id']."/".$signature_identity['shop_id']);  
        }
      }
      redirect('/shop_adjust/view/'.$signature_identity['shop_adjustment_id']."/".$signature_identity['shop_id']);
    }

    public function comment($adjust_id,$shop_id){
      if ($this->input->post('submit')) {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('comment','Comment','trim|required');
        if ($this->form_validation->run() == TRUE) {
          $comment = $this->input->post('comment'); 
          $comment_data = array(
            'user_id' => $this->data['user_id'],
            'shop_adjustment_id' => $adjust_id,
            'comment' => $comment
          );
          $this->shop_adjust_model->insert_comment($comment_data);
          $this->notify_commet($adjust_id,$shop_id, $this->data['user_id']);
        }
        redirect('/shop_adjust/view/'.$adjust_id."/".$shop_id);
      }
     }
    public function notify_commet($adjust_id,$shop_id, $user_id) {
      $shop_adjust = $this->shop_adjust_model->get_shop_adjust($adjust_id,$shop_id);
      $commenter = $this->users_model->get_user_by_id($user_id, TRUE);
      $comment = $commenter->fullname;
      $signes = $this->shop_adjust_model->get_by_verbal($adjust_id);
      $users = array();
      foreach ($signes as $signe){
        if ($signe['user_id']  && $signe['user_id'] != 30) {
          $user = $this->users_model->get_user_by_id($signe['user_id'], TRUE);
          $name = $user->fullname;
          $mail = $user->email;
          $this->load->library('email');
          $this->load->helper('url');
          $shop_url = base_url().'shop_adjust/view/'.$adjust_id."/".$shop_id;
          $this->email->from('e-signature@sunrise-resorts.com');
          $this->email->to($mail);
          $this->email->subject("Rent Adjustment Form No. #{$adjust_id}");
          $this->email->message("Dear {$name},

            <br/>
            <br/>
            {$comment} made a comment on Rent Adjustment Form No.#{$adjust_id}, Please use the link below:
            <br/>
            <a href='{$shop_url}' target='_blank'>{$shop_url}</a>
            <br/>
          "); 
   // die(print_r( $signes ));
          $mail_result = $this->email->send();
             
          $data = array(
            'commenter' => $commenter->fullname,
            'user' => $name,
            'mail' => $mail
          );
         
        }
      }                                                
     }
  public function notify_edit($adjust_id,$shop_id, $user_id) {
      $shop_adjust = $this->shop_adjust_model->get_shop_adjust($adjust_id,$shop_id);
      $commenter = $this->users_model->get_user_by_id($user_id, TRUE);
      $comment = $commenter->fullname;
      $signes = $this->shop_adjust_model->get_by_verbal($adjust_id);
      $users = array();
      foreach ($signes as $signe){
        if ($signe['user_id']  && $signe['user_id'] != 30) {
          $user = $this->users_model->get_user_by_id($signe['user_id'], TRUE);
          $name = $user->fullname;
          $mail = $user->email;
          $this->load->library('email');
          $this->load->helper('url');
          $shop_url = base_url().'shop_adjust/view/'.$adjust_id."/".$shop_id;
          $this->email->from('e-signature@sunrise-resorts.com');
          $this->email->to($mail);
          $this->email->subject("Rent Adjustment Form No. #{$adjust_id}");
          $this->email->message("Dear {$name},

            <br/>
            <br/>
            {$comment} edited the Rent Adjustment Form No.#{$adjust_id}, Please use the link below:
            <br/>
            <a href='{$shop_url}' target='_blank'>{$shop_url}</a>
            <br/>
          "); 
   // die(print_r( $signes ));
          $mail_result = $this->email->send();
             
          $data = array(
            'commenter' => $commenter->fullname,
            'user' => $name,
            'mail' => $mail
          );
         
        }
      }                                                
    }  
public function notification($adjust_id,$shop_id,$user_id) {
      $shop_adjust = $this->shop_adjust_model->get_shop_adjust($adjust_id,$shop_id);
      $editor = $this->users_model->get_user_by_id($user_id, TRUE);
      $comment = $editor->fullname;
      $to_users = $this->shop_adjust_model->getby_role();
      $users = array();
      foreach ($to_users as $to_user){
        if ($to_user['id']  && $to_user['id']) {
          $user = $this->users_model->get_user_by_id($to_user['id'], TRUE);
          $name = $user->fullname;
          $mail = $user->email;
          $this->load->library('email');
          $this->load->helper('url');
          $shop_url = base_url().'shop_adjust/view/'.$adjust_id."/".$shop_id;
          $this->email->from('e-signature@sunrise-resorts.com');
          $this->email->to($mail);
          $this->email->subject("Rent Adjustment Form No. #{$adjust_id}");
          $this->email->message("Dear {$name},

            <br/>
            <br/>
            {$comment} made edit on Rent Adjustment Form No.#{$adjust_id}, Please use the link below:
            <br/>
            <a href='{$shop_url}' target='_blank'>{$shop_url}</a>
            <br/>
          "); 
   // die(print_r( $signes ));
          $mail_result = $this->email->send();
             
          $data = array(
            'editor' => $editor->fullname,
            'user' => $name,
            'mail' => $mail
          );
         
        }
      }
    } 


  }

?>   