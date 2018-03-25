<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  class settlements extends CI_Controller {
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

    public function index() {
          if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
        $this->load->model('hotels_model');
        $this->load->model('settlements_model');
        $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
        $hotels = array();
        foreach ($user_hotels as $hotel) {
          $hotels[] = $hotel['id'];
        }    
        $this->data['settlements'] = $this->settlements_model->view($hotels);
        foreach ($this->data['settlements'] as $key => $set) {
          $this->data['settlements'][$key]['approvals'] = $this->get_signers($this->data['settlements'][$key]['id'], $this->data['settlements'][$key]['hotel_id']);
        }
        $this->data['hotels'] = $this->hotels_model->getall();
        $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
        $this->load->view('settlements_index', $this->data);
      }else{
        redirect('/unknown');
      }
    }

    public function index_app() {
          if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
        $this->load->model('hotels_model');
        $this->load->model('settlements_model');
        $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
        $hotels = array();
        foreach ($user_hotels as $hotel) {
          $hotels[] = $hotel['id'];
        }    
        $this->data['settlements'] = $this->settlements_model->view($hotels);
        foreach ($this->data['settlements'] as $key => $set) {
          $this->data['settlements'][$key]['approvals'] = $this->get_signers($this->data['settlements'][$key]['id'], $this->data['settlements'][$key]['hotel_id']);
        }
        $this->data['hotels'] = $this->hotels_model->getall();
        $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
        $this->load->view('settlements_index_app', $this->data);
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
        $this->load->model('settlements_model');
        $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
        $hotels = array();
        foreach ($user_hotels as $hotel) {
          $hotels[] = $hotel['id'];
        }    
        $this->data['settlements'] = $this->settlements_model->view($hotels);
        foreach ($this->data['settlements'] as $key => $set) {
          $this->data['settlements'][$key]['approvals'] = $this->get_signers($this->data['settlements'][$key]['id'], $this->data['settlements'][$key]['hotel_id']);
        }
        $this->data['hotels'] = $this->hotels_model->getall();
        $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
        $this->load->view('settlements_index_wat', $this->data);
      }else{
        redirect('/unknown');
      }
    }

    public function index_rej() {
          if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
        $this->load->model('hotels_model');
        $this->load->model('settlements_model');
        $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
        $hotels = array();
        foreach ($user_hotels as $hotel) {
          $hotels[] = $hotel['id'];
        }    
        $this->data['settlements'] = $this->settlements_model->view($hotels);
        foreach ($this->data['settlements'] as $key => $set) {
          $this->data['settlements'][$key]['approvals'] = $this->get_signers($this->data['settlements'][$key]['id'], $this->data['settlements'][$key]['hotel_id']);
        }
        $this->data['hotels'] = $this->hotels_model->getall();
        $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
        $this->load->view('settlements_index_rej', $this->data);
      }else{
        redirect('/unknown');
      }
    }

    public function submit() {
          if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
        if ($this->input->post('submit')) {
          $this->load->library('form_validation');
          $this->load->library('email');
          $assumed_id = $this->input->post('assumed_id');                        
          if ($this->form_validation->run() == FALSE) {
            $this->load->model('settlements_model');
            $this->load->model('users_model');  
            $form_data = array(
              'user_id' => $this->data['user_id'],
              'hotel_id' => $this->input->post('hotel_id'),
              'Date' => $this->input->post('Date'), 
              'Date_till' => $this->input->post('Date_till'),
              'Proposed' => $this->input->post('Proposed'),
              'currency' => $this->input->post('currency'),
              'File' => $this->input->post('File'),
              'Ref' => $this->input->post('Ref'),
              'date_incident' => $this->input->post('date_incident'),
              'Highest_Reserve' => $this->input->post('Highest_Reserve'),
              'reserve_currency' => $this->input->post('reserve_currency'),
              'claim_type' => $this->input->post('claim_type'), 
              'num_claimants' => $this->input->post('num_claimants'),
              'nature_claim' => $this->input->post('nature_claim'), //does not send data
              'claim_status' => $this->input->post('claim_status'),
              'closed_amount' => $this->input->post('closed_amount'),
              'closed_amount_currency' => $this->input->post('closed_amount_currency'),
              'closed_date_notice' => $this->input->post('closed_date_notice'),
              'cristal_score' => $this->input->post('cristal_score'),
              'num_similar_claims' => $this->input->post('num_similar_claims'),
              'Rationale' => $this->input->post('Rationale'),
              'Risk' => $this->input->post('Risk'),
              'status' => $this->input->post('status'),
              'last_saf_date' => $this->input->post('last_saf_date'),
              'final_settlement' => $this->input->post('final_settlement'),
              'final_settlement_currency' => $this->input->post('final_settlement_currency'),
              'final_settlement_date' => $this->input->post('final_settlement_date'),
              'form_type' => '1'
            );
            $set_id = $this->settlements_model->create_settlements($form_data);
            if ($set_id) {
              $this->load->model('settlements_model');
              $this->settlements_model->update_files($assumed_id,$set_id);
            } else {
              die("error");
            }
            $signatures = $this->settlements_model->set_sign($form_data['form_type']);
            $do_sign = $this->settlements_model->set_do_sign($set_id);
            if ($do_sign == 0) {
              foreach ($signatures as $set_signature) {
                $this->settlements_model->add_signature($set_id, $set_signature['role'], $set_signature['rank']);
              }
            }
            //$this->notify_legal($set_id);
            //redirect('/settlements/view/'.$set_id);
            redirect('/settlements/settlements_stage/'.$set_id);
          }   
        } 
        try {
          $this->load->helper('form');
          $this->load->model('settlements_model');
          $this->load->model('hotels_model');
          $this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());
          $this->data['types'] = $this->settlements_model->getall_type();
          $this->data['statuss'] = $this->settlements_model->get_settlements_status_saf();
          if ($this->input->post('submit')) {
            $this->load->model('settlements_model');
            $this->data['assumed_id'] = $this->input->post('assumed_id');
            $this->data['uploads'] = $this->settlements_model->getby_fille($this->data['assumed_id']);
          } else {
            $this->data['assumed_id'] = strtoupper(str_pad(dechex( mt_rand( 0, 1048575 ) ), 5, '0', STR_PAD_LEFT));
            $this->data['uploads'] = array();
          }
          $this->load->view('settlements_add_new',$this->data);
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
      }else{ 
        redirect('/unknown');
      }
    }

    public function settlements_stage($set_id) {
      $this->load->model('settlements_model');
      $this->data['settlements'] = $this->settlements_model->get_settlements($set_id);
      //die(print_r($this->data['settlements']));
      if ($this->data['settlements']['state_id'] == 0) {
        $this->settlements_model->update_state($set_id, 1);
        redirect('/settlements/settlements_stage/'.$set_id);
      }elseif ($this->data['settlements']['state_id'] == 3){
        //$user = $this->users_model->get_user_by_id($this->data['settlements']['user_id'], TRUE);
        //$this->reject_mail($user->fullname, $user->email, $set_id);
        $queue = $this->notify_reject_legal($set_id);
      } elseif ($this->data['settlements']['state_id'] != 2) {
        $queue = $this->notify_signers($set_id, $this->data['settlements']['hotel_id']);
        if (!$queue) {
          //$user1 = $this->users_model->get_user_by_id($this->data['settlements']['user_id'], TRUE);
          //$this->approvel_mail($user1->fullname, $user1->email, $set_id);
          $this->settlements_model->update_state($set_id, 2);
          $queue = $this->notify_approve_legal($set_id);
          redirect('/settlements/settlements_stage/'.$set_id);
        }
      }
      redirect('/settlements/view/'.$set_id);
    }

    private function notify_signers($set_id, $hotel_id) {
      $notified = FALSE;
      $this->load->model('settlements_model');
      $this->data['settlements'] = $this->settlements_model->get_settlements($set_id);
      $set_url = base_url().'settlements/view/'.$set_id;
      $message = "Settlement No. {$set_id}:
        {$set_url}";
      $signers = $this->get_signers($set_id, $hotel_id);
      foreach ($signers as $signer) {
        if (isset($signer['queue'])) {
          $notified = TRUE;
          foreach ($signer['queue'] as $uid => $user) {
            $this->onclick($message, $set_id, $user['channel']);
            $this->signatures_mail($signer['role'], $user['name'], $user['mail'], $set_id);
          }
          break;
        }
      }
      return $notified;
    }

    private function get_signers($set_id, $hotel_id) {
      $this->load->model('settlements_model');
      $signatures = $this->settlements_model->getby_verbal($set_id);
      return $this->roll_signers($signatures, $hotel_id, $set_id);
    }

    private function roll_signers($signatures, $hotel_id, $set_id) {
      $settlements = $this->settlements_model->get_settlements($set_id);
      $rowcount = $this->settlements_model->get_count($set_id);
      $signers = array();
      $this->load->model('users_model');
      foreach ($signatures as $signature) {
        $signers[$signature['id']] = array();
        $signers[$signature['id']]['role'] = $signature['role'];
        $signers[$signature['id']]['role_id'] = $signature['role_id'];
        if ($signature['user_id']) {
          if ($rowcount == 3) {
            if ($signature['rank'] == 1){
              $this->settlements_model->update_state($set_id, 5);
            }elseif ($signature['rank'] == 2){
              $this->settlements_model->update_state($set_id, 4);
            }
          }
          if ($rowcount == 6) {
            if ($signature['rank'] == 1){
              $this->settlements_model->update_state($set_id, 5);
            }elseif ($signature['rank'] == 2){
              $this->settlements_model->update_state($set_id, 6);
            }elseif ($signature['rank'] == 3){
              $this->settlements_model->update_state($set_id, 7);
            }elseif ($signature['rank'] == 4){
              $this->settlements_model->update_state($set_id, 8);
            }elseif ($signature['rank'] == 5){
              $this->settlements_model->update_state($set_id, 4);
            }
          }
          if ($rowcount == 7) {
            if ($signature['rank'] == 1){
              $this->settlements_model->update_state($set_id, 9);
            }elseif ($signature['rank'] == 2){
              $this->settlements_model->update_state($set_id, 5);
            }elseif ($signature['rank'] == 3){
              $this->settlements_model->update_state($set_id, 6);
            }elseif ($signature['rank'] == 4){
              $this->settlements_model->update_state($set_id, 7);
            }elseif ($signature['rank'] == 5){
              $this->settlements_model->update_state($set_id, 8);
            }elseif ($signature['rank'] == 6){
              $this->settlements_model->update_state($set_id, 4);
            }
          }
          $signers[$signature['id']]['sign'] = array();
          $signers[$signature['id']]['sign']['id'] = $signature['user_id'];
          if ($signature['reject'] == 1) {
            $signers[$signature['id']]['sign']['reject'] = "reject";
            $this->settlements_model->update_state($set_id, 3);
          } 
          $user = $this->users_model->get_user_by_id($signature['user_id'], TRUE);
          $signers[$signature['id']]['sign']['name'] = $user->fullname;
          $signers[$signature['id']]['sign']['mail'] = $user->email;
          $signers[$signature['id']]['sign']['channel'] = $user->channel;
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
          if ($hotel_id == 9 && $signature['role_id'] == 4) {
            $users = $this->users_model->getby_criteria(6, 9, 3);
          } else {
            $users = $this->users_model->getby_criteria($signature['role_id'], $hotel_id);
          }
          foreach ($users as $use) {
            $signers[$signature['id']]['queue'][$use['id']] = array();
            $signers[$signature['id']]['queue'][$use['id']]['name'] = $use['fullname'];
            $signers[$signature['id']]['queue'][$use['id']]['mail'] = $use['email'];
            $signers[$signature['id']]['queue'][$use['id']]['channel'] = $use['channel'];
          }
        }
      }
      return $signers;
    }

    private function signatures_mail($role, $name, $mail, $set_id) {
      $this->load->library('email');
      $this->load->helper('url');
      $set_url = base_url().'settlements/view/'.$set_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($mail);
      $this->email->subject("Settlements {$set_id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
        Settlements {$set_id} requires your signature, Please use the link below:
        <br/>
        <a href='{$set_url}' target='_blank'>{$set_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
    }

    private function approvel_mail($name, $email, $set_id) {
      $this->load->library('email');
      $this->load->helper('url');
      $set_url = base_url().'settlements/view/'.$set_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($email);
      $this->email->subject("Settlements Form No. #{$set_id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
        Settlements Form No. #{$set_id} has been approved, Please use the link below:
        <br/>
        <a href='{$set_url}' target='_blank'>{$set_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
    }

    public function notify_approve_legal($set_id) {
      $this->load->model('settlements_model');
      $this->load->model('users_model');
      $this->data['settlements'] = $this->settlements_model->get_settlements($set_id);
      $users = $this->users_model->getby_criteria(54, $this->data['settlements']['hotel_id']);
      foreach($users as $user){
        if ($user['id'] != 30) {
          $name = $user['fullname'];
          $mail = $user['email'];
          $this->load->library('email');
          $this->load->helper('url');
          $set_url = base_url().'settlements/view/'.$set_id;
          $this->email->from('e-signature@sunrise-resorts.com');
          $this->email->to($mail);
          $this->email->subject("Settlements Form No. #{$set_id}");
          $this->email->message("Dear {$name},
            <br/>
            <br/>
            Settlements Form No. #{$set_id} has been Approved, Please use the link below:
            <br/>
            <a href='{$set_url}' target='_blank'>{$set_url}</a>
            <br/>
          "); 
          $mail_result = $this->email->send();
        }
      }
    }

    private function reject_mail($name, $email, $set_id) {
      $this->load->library('email');
      $this->load->helper('url');
      $set_url = base_url().'settlements/view/'.$set_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($email);
      $this->email->subject("Settlements Form No. #{$set_id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
        Settlements Form No. #{$set_id} has been rejected, Please use the link below:
        <br/>
        <a href='{$set_url}' target='_blank'>{$set_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
    }

    public function notify_reject_legal($set_id) {
      $this->load->model('settlements_model');
      $this->load->model('users_model');
      $this->data['settlements'] = $this->settlements_model->get_settlements($set_id);
      $users = $this->users_model->getby_criteria(54, $this->data['settlements']['hotel_id']);
      foreach($users as $user){
        if ($user['id'] != 30) {
          $name = $user['fullname'];
          $mail = $user['email'];
          $this->load->library('email');
          $this->load->helper('url');
          $set_url = base_url().'settlements/view/'.$set_id;
          $this->email->from('e-signature@sunrise-resorts.com');
          $this->email->to($mail);
          $this->email->subject("Settlements Form No. #{$set_id}");
          $this->email->message("Dear {$name},
            <br/>
            <br/>
            Settlements Form No. #{$set_id} has been Rejected, Please use the link below:
            <br/>
            <a href='{$set_url}' target='_blank'>{$set_url}</a>
            <br/>
          "); 
          $mail_result = $this->email->send();
        }
      }
    }

    public function make_offer($set_id) {
      $file_name = $this->do_upload("upload");
      if (!$file_name) {
        die(json_encode($this->data['error']));
      } else {
        $this->load->model("settlements_model");
        $this->settlements_model->add($set_id, $file_name);
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

    public function remove_offer($set_id, $id) {
      $file_name = $_POST['key'];
      if (!$id) {
        die(json_encode($this->data['error']));
      } else {
        $this->load->model("settlements_model");
        $this->settlements_model->remove($id);
        die("{}");
      }
    }

    public function view($set_id) {
          if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
        $this->load->model('settlements_model');
        $this->load->model('hotels_model');   
        $this->data['hotels'] = $this->hotels_model->getall();
        $this->data['settlements'] = $this->settlements_model->get_settlements($set_id);
        $this->data['purposes'] = $this->settlements_model->get_purposes($set_id);
        $this->data['uploads'] = $this->settlements_model->getby_fille($set_id);
        $this->data['GetComment'] = $this->settlements_model->GetComment($set_id);
        $this->data['comment_proposed']=$this->settlements_model->retrieve_inline_comment($set_id,1);
        $this->data['comment_nature_claim']=$this->settlements_model->retrieve_inline_comment($set_id,2);
        $this->data['comment_similar_claim']=$this->settlements_model->retrieve_inline_comment($set_id,3);
        $this->data['comment_claim_type']=$this->settlements_model->retrieve_inline_comment($set_id,4);
        $this->data['comment_Insurance']=$this->settlements_model->retrieve_inline_comment($set_id,5);
        $this->data['comment_suggest']=$this->settlements_model->retrieve_inline_comment($set_id,6);
        $this->data['comment_negotiation']=$this->settlements_model->retrieve_inline_comment($set_id,7);
        $this->data['statuss'] = $this->settlements_model->get_settlements_status_saf();
        $this->data['signature_path'] = '/assets/uploads/signatures/';
        $this->data['signers'] = $this->get_signers($this->data['settlements']['id'], $this->data['settlements']['hotel_id']);
        $editor = FALSE;
        $unsign_enable = FALSE;
        $first = TRUE;
        $force_edit = FALSE;
        $ccrm=FALSE;
        $sunrise=FALSE;
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
          if ( $this->data['settlements']['user_id'] == $this->data['user_id'] &&  $this->data['settlements']['state_id'] == 1) {
            $editor = TRUE;
          }
        }
        if(isset($this->data['role_id'])){
          if (($this->data['role_id'] == 41) || ($this->data['role_id'] ==42 ) || ($this->data['role_id'] ==46 ) || ($this->data['role_id'] ==66 ) || ($this->data['role_id'] ==67 ) || ($this->data['role_id'] == 80)|| ($this->data['role_id'] == 54)) {
            $sunrise = TRUE;
          }
          if (($this->data['role_id'] ==47 ) || ($this->data['role_id'] ==54 )) {
            $ccrm = TRUE;
          }
        }
        $this->data['sunrise'] = (($sunrise) || $this->data['is_admin'])? TRUE : FALSE;
        $this->data['ccrm'] = (($ccrm) || $this->data['is_admin'])? TRUE : FALSE;
        $this->data['unsign_enable'] = (($unsign_enable) || $this->data['is_admin'])? TRUE : FALSE;
        $this->data['is_editor'] = ( (($this->data['unsign_enable'] || $editor)) || ($force_edit) )? TRUE : FALSE;
        $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
        $this->data['file_path'] = '\assets\uploads\files\\';
        $this->data['id'] = $set_id;
        $this->load->view('settlements_view', $this->data);
      }else{
        redirect('/unknown');
      }
    }

    public function edit($set_id) {
          if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
        if ($this->input->post('submit')) {
          $this->load->library('form_validation');
          $this->load->library('email');
          if ($this->form_validation->run() == FALSE) {
            $this->load->model('settlements_model');
            $this->load->model('users_model');  
            $form_data = array(
             'user_id' => $this->data['user_id'],
              'hotel_id' => $this->input->post('hotel_id'),
              'Date' => $this->input->post('Date'), 
              'Date_till' => $this->input->post('Date_till'),
              'Proposed' => $this->input->post('Proposed'),
              'currency' => $this->input->post('currency'),
              'File' => $this->input->post('File'),
              'Ref' => $this->input->post('Ref'),
              'date_incident' => $this->input->post('date_incident'),
              'Highest_Reserve' => $this->input->post('Highest_Reserve'),
              'reserve_currency' => $this->input->post('reserve_currency'),
              'claim_type' => $this->input->post('claim_type'), 
              'num_claimants' => $this->input->post('num_claimants'),
              'nature_claim' => $this->input->post('nature_claim'),
              'claim_status' => $this->input->post('claim_status'),
              'closed_amount' => $this->input->post('closed_amount'),
              'closed_amount_currency' => $this->input->post('closed_amount_currency'),
              'closed_date_notice' => $this->input->post('closed_date_notice'),
              'cristal_score' => $this->input->post('cristal_score'),
              'num_similar_claims' => $this->input->post('num_similar_claims'),
              'Rationale' => $this->input->post('Rationale'),
              'Risk' => $this->input->post('Risk'),
              'status' => $this->input->post('status'),
              'last_saf_date' => $this->input->post('last_saf_date'),
              'final_settlement' => $this->input->post('final_settlement'),
              'final_settlement_currency' => $this->input->post('final_settlement_currency'),
              'final_settlement_date' => $this->input->post('final_settlement_date'),
              'form_type' => '1'
            );
            $this->settlements_model->update_settlements($form_data, $set_id);
            $this->notify_edit_legal($set_id);
            redirect('/settlements/view/'.$set_id);
          }   
        } 
        try {
          $this->load->helper('form');
          $this->load->model('settlements_model');
          $this->load->model('hotels_model');
          $this->data['settlements'] = $this->settlements_model->get_settlements($set_id);
          $this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());
          $this->data['uploads'] = $this->settlements_model->getby_fille($this->data['settlements']['id']);
          $this->data['types'] = $this->settlements_model->getall_type();
          $this->data['statuss'] = $this->settlements_model->get_settlements_status_saf();
          $this->load->view('settlements_edit',$this->data);
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
      }else{
        redirect('/unknown');
      }
    }

    public function notify_edit_legal($set_id) {
      $this->load->model('settlements_model');
      $this->load->model('users_model');
      $this->data['settlements'] = $this->settlements_model->get_settlements($set_id);
      $users = $this->users_model->getby_criteria(54, $this->data['settlements']['hotel_id']);
      foreach($users as $user){
        if ($user['id'] != 30) {
          $name = $user['fullname'];
          $mail = $user['email'];
          $this->load->library('email');
          $this->load->helper('url');
          $set_url = base_url().'settlements/view/'.$set_id;
          $this->email->from('e-signature@sunrise-resorts.com');
          $this->email->to($mail);
          $this->email->subject("Settlements Form No. #{$set_id}");
          $this->email->message("Dear {$name},
            <br/>
            <br/>
            settlements Form No. #{$set_id} has been Edited, Please use the link below:
            <br/>
            <a href='{$set_url}' target='_blank'>{$set_url}</a>
            <br/>
          "); 
          $mail_result = $this->email->send();
        }
      }
    }

    public function mail_me($set_id) {
      $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
      $this->load->library('email');
      $this->load->helper('url');
      $set_url = base_url().'settlements/view/'.$set_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($user->email);
      $this->email->subject("Settlements Form No. #{$set_id}");
      $this->email->message("Settlements Form NO. #{$set_id}:
        <br/>
        Please use the link below to view The Settlements Form:
        <a href='{$res_url}' target='_blank'>{$res_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
      redirect('settlements/view/'.$set_id);
    }

    public function submit_inline_comment($set_id,$type){
      $this->load->model('settlements_model');
      $this->load->model('users_model');  
      $comment = array(
        'set_id' => $set_id,
        'user_id' => $this->data['user_id'],
        'comment' => $this->input->post('comment'),
        'type' => $type
      );
      $this->settlements_model->create_inline_comment($comment);
      redirect('/settlements/view/'.$set_id);
    }

    public function edit_final_settlements($set_id){
      $this->load->model('settlements_model');
      $this->load->model('users_model');  
      $final_settlements = array(
        'final_settlement' => $this->input->post('final_settlement'),
        'final_settlement_date' => $this->input->post('final_settlement_date')
      );
      $this->settlements_model->update_final_settlements($final_settlements, $set_id);
      redirect('/settlements/view/'.$set_id);
    }

    public function edit_status($set_id){
      $this->load->model('settlements_model');
      $this->load->model('users_model');  
      $status = $this->input->post('status');
      //die(print_r($status));
      $this->settlements_model->update_status_saf($status, $set_id);
      redirect('/settlements/view/'.$set_id);
    }

    public function submit_purposes($set_id) {
          if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
          if ($this->input->post('submit')) {
            $this->load->library('form_validation');
            $this->load->library('email');
            $this->load->model('settlements_model');
            $this->data['settlements'] = $this->settlements_model->get_settlements($set_id);
            $this->form_validation->set_rules('type','Case Type','trim|required');
            if ($this->form_validation->run() == TRUE) {
              $this->load->model('settlements_model');
              $this->load->model('users_model');  
              $form_data = array(
                'set_id' => $set_id,
                'type' => $this->input->post('type'), 
                'charged' => $this->input->post('charged'),
                'penalty' => $this->input->post('penalty'),
                'penalty_currency' => $this->input->post('penalty_currency'),
                'prevent_claim' => $this->input->post('prevent_claim'),
                'Insurance' => $this->input->post('Insurance'),
                'negotiation' => $this->input->post('negotiation'),
                'negotiation_currency' => $this->input->post('negotiation_currency'),
                'rejected_by' => $this->input->post('rejected_by'),
                'reject_reason' => $this->input->post('reject_reason'),
                'settlement_suggest' => $this->input->post('settlement_suggest'),
                'settlement_suggest_currency' => $this->input->post('settlement_suggest_currency')
              );
              $pur_id = $this->settlements_model->create_purposes($form_data);
              if (!$pur_id) {
                die("ERROR");
              }
              //redirect('/settlements/settlements_stage/'.$set_id);
              $this->notify_legal($set_id);
              redirect('/settlements/view/'.$set_id);
            }   
          } 
          try {
            $this->load->helper('form');
            $this->load->model('settlements_model');
            $this->load->model('hotels_model');
            $this->data['settlements'] = $this->settlements_model->get_settlements($set_id);
            //$this->data['purposes'] = $this->settlements_model->get_purposes($set_id);
            $this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());
            $this->data['types'] = $this->settlements_model->getall_type();
            $this->load->view('purposes_add_new',$this->data);
          }
          catch( Exception $e) {
            show_error($e->getMessage()." _ ". $e->getTraceAsString());
          }
        }else{
          redirect('/unknown');
        }
      }

      public function notify_legal($set_id) {
        $this->load->model('settlements_model');
        $this->load->model('users_model');
        $this->data['settlements'] = $this->settlements_model->get_settlements($set_id);
        $users = $this->users_model->getby_criteria(54, $this->data['settlements']['hotel_id']);
        foreach($users as $user){
          if ($user['id'] != 30) {
            $name = $user['fullname'];
            $mail = $user['email'];
            $this->load->library('email');
            $this->load->helper('url');
            $set_url = base_url().'settlements/view/'.$set_id;
            $this->email->from('e-signature@sunrise-resorts.com');
            $this->email->to($mail);
            $this->email->subject("Settlements Form No. #{$set_id}");
            $this->email->message("Dear {$name},
              <br/>
              <br/>
              Settlements Form No. #{$set_id} has been created, Please use the link below:
              <br/>
              <a href='{$set_url}' target='_blank'>{$set_url}</a>
              <br/>
            "); 
            $mail_result = $this->email->send();
          }
        }
      }

      public function purposes_edit($set_id) {
            if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
          if ($this->input->post('submit')) {
            $this->load->library('form_validation');
            $this->load->library('email');
            if ($this->form_validation->run() == FALSE) {
              $this->load->model('settlements_model');
              $this->load->model('users_model');  
              $form_data = array(
                'set_id' => $set_id,
                'type' => $this->input->post('type'), 
                'charged' => $this->input->post('charged'),
                'penalty' => $this->input->post('penalty'),
                'penalty_currency' => $this->input->post('penalty_currency'),
                'prevent_claim' => $this->input->post('prevent_claim'),
                'Insurance' => $this->input->post('Insurance'),
                'negotiation' => $this->input->post('negotiation'),
                'negotiation_currency' => $this->input->post('negotiation_currency'),
                'rejected_by' => $this->input->post('rejected_by'),
                'reject_reason' => $this->input->post('reject_reason'),
                'settlement_suggest' => $this->input->post('settlement_suggest'),
                'settlement_suggest_currency' => $this->input->post('settlement_suggest_currency')
              );
              $this->settlements_model->update_purposes($form_data, $set_id);
              $this->notify_edit_legal($set_id);
              redirect('/settlements/view/'.$set_id);
            }   
          } 
          try {
            $this->load->helper('form');
            $this->load->model('settlements_model');
            $this->load->model('hotels_model');
            $this->data['hotels'] = $this->hotels_model->getall();
            $this->data['settlements'] = $this->settlements_model->get_settlements($set_id);
            $this->data['purposes'] = $this->settlements_model->get_purposes($set_id);
            $this->data['uploads'] = $this->settlements_model->getby_fille($this->data['settlements']['id']);
            $this->data['types'] = $this->settlements_model->getall_type();
            $this->load->view('purposes_edit',$this->data);
          }
          catch( Exception $e) {
            show_error($e->getMessage()." _ ". $e->getTraceAsString());
          }
        }else{
          redirect('/unknown');
        }
      }

      public function mailto($set_id) {
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
            $set_url = base_url().'settlements/view/'.$set_id;
            $this->email->from('e-signature@sunrise-resorts.com');
            $this->email->to($email);
            $this->email->subject("A message from {$user->fullname}, Settlements No.{$set_id}");
            $this->email->message("{$user->fullname} sent you a private message regarding Settlements {$set_id}:
              <br/>
              {$message}<br />
              <br />
              Please use the link below to view the Settlements:
              <a href='{$set_url}' target='_blank'>{$set_url}</a><br/>
            "); 
            $mail_result = $this->email->send();
          }
        }
        redirect('settlements/view/'.$set_id);
      }

      public function share_url($set_id) {
        if ($this->input->post('submit')) {
          $message = $this->input->post('message');
          $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
          $set_url = base_url().'settlements/view/'.$set_id;
          $messages = "{$user->fullname}  Settlement No. {$set_id}
            {$set_url}";  
          $this->onclick($messages, $set_id, $this->config->item('page_to_send'));
        }
        redirect('settlements/view/'.$set_id);
      }

      public function unsign($signature_id) {
        $this->load->model('settlements_model');
        $this->load->model('users_model');
        $signature_identity = $this->settlements_model->get_signature_identity($signature_id);
        $this->settlements_model->unsign($signature_id);
        $this->settlements_model->unsign_state($signature_identity['set_id']);
        $settlements = $this->settlements_model->get_settlements($signature_identity['set_id']);
        redirect('/settlements/view/'.$signature_identity['set_id']);
      }

      public function sign($signature_id, $reject = FALSE) {
        $this->load->model('settlements_model');
        $signature_identity = $this->settlements_model->get_signature_identity($signature_id);
        $signrs = $this->get_signers($signature_identity['set_id'], $signature_identity['hotel_id']);
        $this->data['settlements'] = $this->settlements_model->get_settlements($signature_identity['set_id']);
        if (array_key_exists($this->data['user_id'], $signrs[$signature_id]['queue'])) {
          if ($signature_identity['role_id'] == 1) {
            $this->onclick1($message);
            $this->deletonclick($message_id);
          }
          if ($reject) {
            $this->settlements_model->reject_state($signature_identity['set_id']);
            $this->settlements_model->reject($signature_id, $this->data['user_id']);
            redirect('/settlements/settlements_stage/'.$this->data['settlements']['id']);  
          } else {
            $this->settlements_model->sign($signature_id, $this->data['user_id']);
            redirect('/settlements/settlements_stage/'.$signature_identity['set_id']);  
          }
        }
        redirect('/settlements/view/'.$signature_identity['set_id']);
      }

      public function comment($set_id){
        if ($this->input->post('submit')) {
          $this->load->library('form_validation');
          $this->form_validation->set_rules('comment','Comment','trim|required');
          if ($this->form_validation->run() == TRUE) {
            $comment = $this->input->post('comment'); 
            $this->load->model('settlements_model');
            $comment_data = array(
              'user_id' => $this->data['user_id'],
              'set_id' => $set_id,
              'comment' => $comment
            );
            $this->settlements_model->InsertComment($comment_data);
            if ($this->data['role_id'] == 217) {
              $this->chairman_mail($set_id);
            }
          }
          redirect('/settlements/view/'.$set_id);
        }
      }

      private function chairman_mail($set_id) {
          $this->load->library('email');
          $this->load->helper('url');
          $set_url = base_url().'settlements/view/'.$set_id;
          $this->email->from('e-signature@sunrise-resorts.com');
          $this->email->to('abeer@sunrise.eg');
          $this->email->subject("Settlement Form No. #{$set_id}");
          $this->email->message("Dear Madam Abber,
            <br/>
            <br/>
            Mr Hossam Commented on Settlement Form No. #{$set_id}, Please use the link below:
            <br/>
            <a href='{$set_url}' target='_blank'>{$set_url}</a>
            <br/>
          "); 
          $mail_result = $this->email->send();
      }

      function onclick($message, $id, $channelss){
      include(APPPATH . 'third_party/RocketChat/autoload.php');
      $client = new RocketChat\Client($this->config->item('send_url'));
      $token = $client->api('user')->login($this->config->item('user_access'),$this->config->item('pass_access'));
      $client->setToken($token);
      $channel_result = $client->api('channel')->sendMessage($channelss,$message);
      $this->load->model('settlements_model');
      $this->settlements_model->update_message_id($id, $channel_result);
    }

    function onclick1($message){
      include(APPPATH . 'third_party/RocketChat/autoload.php');
      $client = new RocketChat\Client($this->config->item('send_url'));
      $token = $client->api('user')->login($this->config->item('user_access'),$this->config->item('pass_access'));
      $client->setToken($token);
      $channel_result = $client->api('channel')->sendMessage($this->config->item('page_to_send1'),$message);
    }

    function deletonclick($id){
      include(APPPATH . 'third_party/RocketChat/autoload.php');
      $client = new RocketChat\Client($this->config->item('send_url'));
      $token = $client->api('user')->login($this->config->item('user_access'),$this->config->item('pass_access'));
      $client->setToken($token);
      $channel_result = $client->api('channel')->deleteChannel_msg($this->config->item('page_to_send'),$id);
    }

    /*public function purposes_view($set_id) {
          if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
        $this->load->model('settlements_model');
        $this->load->model('hotels_model');   
        $this->data['hotels'] = $this->hotels_model->getall();
        $this->data['settlements'] = $this->settlements_model->get_settlements($set_id);
        $this->data['purposes'] = $this->settlements_model->get_purposes($set_id);
        $this->data['get_purposes_comment'] = $this->settlements_model->get_purposes_comment($set_id);
        $this->data['uploads'] = $this->settlements_model->getby_fille($this->data['settlements']['id']);
        $this->data['signature_path'] = '/assets/uploads/signatures/';
        $this->data['signers1'] = $this->get_purposes_signers($this->data['purposes']['set_id'], $this->data['purposes']['hotel_id']);
        $editor = FALSE;
        $unsign_enable = FALSE;
        $first = TRUE;
        $force_edit = FALSE;
        foreach ($this->data['signers1'] as $signer) {
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

          if ( $this->data['purposes']['user_id'] == $this->data['user_id'] &&  $this->data['purposes']['state_id'] == 1) {
            $editor = TRUE;
          }
        }
        $this->data['unsign_enable'] = (($unsign_enable) || $this->data['is_admin'])? TRUE : FALSE;
        $this->data['is_editor'] = ( (($this->data['unsign_enable'] || $editor)) || ($force_edit) )? TRUE : FALSE;
        $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
        $this->data['file_path'] = '\assets\uploads\files\\';
        $this->data['id'] = $set_id;
        $this->load->view('purposes_view', $this->data);
      }else{
        redirect('/unknown');
      }
    }

    // public function purposes_comment($set_id){
    //     if ($this->input->post('submit')) {
    //     $this->load->library('form_validation');
    //         $this->form_validation->set_rules('comment','Comment','trim|required');
    //       if ($this->form_validation->run() == TRUE) {
    //         $comment = $this->input->post('comment'); 
    //         $this->load->model('settlements_model');
    //         $comment_data = array(
    //           'user_id' => $this->data['user_id'],
    //           'set_id' => $set_id,
    //           'comment' => $comment
    //         );
    //       $this->settlements_model->insert_purposes_comment($comment_data);
    //     }
    //     redirect('/settlements/purposes_view/'.$set_id);
    //   }
    // }

    public function index_close() {
          if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
        $this->load->model('hotels_model');
        $this->load->model('settlements_model');
        $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
        $hotels = array();
        foreach ($user_hotels as $hotel) {
          $hotels[] = $hotel['id'];
        }    
        $this->data['settlements'] = $this->settlements_model->view($hotels);
        foreach ($this->data['settlements'] as $key => $set) {
          $this->data['settlements'][$key]['approvals'] = $this->get_signers($this->data['settlements'][$key]['id'], $this->data['settlements'][$key]['hotel_id']);
        }
        $this->data['hotels'] = $this->hotels_model->getall();
        $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
        $this->load->view('settlements_index_close', $this->data);
      }else{
        redirect('/unknown');
      }
    }

    private function get_purposes_signers($set_id, $hotel_id) {
      $this->load->model('settlements_model');
      $signatures = $this->settlements_model->purposes_getby_verbal($set_id);
      return $this->roll_signers($signatures, $hotel_id, $set_id);
    }

    private function roll_purposes_signers($signatures, $hotel_id, $set_id) {
      $signers1 = array();
      $this->load->model('users_model');
      foreach ($signatures as $signature) {
        $signers1[$signature['id']] = array();
        $signers1[$signature['id']]['role'] = $signature['role'];
        $signers1[$signature['id']]['role_id'] = $signature['role_id'];
        if ($signature['user_id']) {
          $signers1[$signature['id']]['sign'] = array();
          $signers1[$signature['id']]['sign']['id'] = $signature['user_id'];
          if ($signature['reject'] == 1) {
            $signers1[$signature['id']]['sign']['reject'] = "reject";
            $this->settlements_model->update_purposes_state($set_id, 3);
          } 
          $user = $this->users_model->get_user_by_id($signature['user_id'], TRUE);
          $signers1[$signature['id']]['sign']['name'] = $user->fullname;
          $signers1[$signature['id']]['sign']['mail'] = $user->email;
          $signers1[$signature['id']]['sign']['sign'] = $user->signature;
          $signers1[$signature['id']]['sign']['timestamp'] = $signature['timestamp'];
        } else {
          $signers1[$signature['id']]['queue'] = array();
          if ($signature['role_id'] == 20) {
            $users = $this->users_model->getby_criteria(7, $hotel_id, 4);
          } else {
            $users = $this->users_model->getby_criteria($signature['role_id'], $hotel_id);
          }
          foreach ($users as $use) {
            $signers1[$signature['id']]['queue'][$use['id']] = array();
            $signers1[$signature['id']]['queue'][$use['id']]['name'] = $use['fullname'];
            $signers1[$signature['id']]['queue'][$use['id']]['mail'] = $use['email'];
          }
        }
      }
      return $signers1;
    }
     public function purposes_sign($signature_id, $reject = FALSE) {
       $this->load->model('settlements_model');
       $signature_identity = $this->settlements_model->get_purposes_signature_identity($signature_id);
       $signrs = $this->get_purposes_signers($signature_identity['set_id'], $signature_identity['hotel_id']);
       $this->data['settlements'] = $this->settlements_model->get_settlements($signature_identity['set_id']);
       $this->data['purposes'] = $this->settlements_model->get_purposes($signature_identity['set_id']);
       if (array_key_exists($this->data['user_id'], $signrs[$signature_id]['queue'])) {
         if ($reject) {
           $this->settlements_model->reject_purposes($signature_id, $this->data['user_id']);
           redirect('/settlements/purposes_stage/'.$signature_identity['set_id']);  
         } else {
           $this->settlements_model->sign_purposes($signature_id, $this->data['user_id']);
           redirect('/settlements/purposes_stage/'.$signature_identity['set_id']);  

         }
       }
       redirect('/settlements/purposes_view/'.$signature_identity['set_id']);
     }

     public function close($set_id) {
      $this->load->model('settlements_model');
      $this->settlements_model->update_close($set_id, 1);
      redirect('/settlements');
    }

    public function unclose($set_id) {
      $this->load->model('settlements_model');
      $this->settlements_model->update_close($set_id, 0);
      redirect('/settlements');
    }

    public function actual($set_id) {
      $this->load->model('settlements_model');
      if ($this->input->post('submit')) {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('actual','You Need To Enter an Amount','trim|required');
        if ($this->form_validation->run() == TRUE) {
          $actual = $this->input->post('actual');
          $this->settlements_model->update_actual($set_id, $actual);
        }
      }
      redirect('/settlements');
    }

    public function status($set_id) {
      $this->load->model('settlements_model');
      if ($this->input->post('submit')) {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('status','You Need To Enter a Status','trim|required');
        if ($this->form_validation->run() == TRUE) {
          $status = $this->input->post('status');
          $this->settlements_model->update_status($set_id, $status);
        }
      }
      redirect('/settlements');
    }

    public function purposes_unsign($signature_id) {
      $this->load->model('settlements_model');
      $this->load->model('users_model');
      $signature_identity = $this->settlements_model->get_purposes_signature_identity($signature_id);
      $this->settlements_model->purposes_unsign($signature_id);
      $purposes = $this->settlements_model->get_purposes($signature_identity['set_id']);
      redirect('/settlements/purposes_view/'.$signature_identity['set_id']);
    }

    public function purposes_stage($set_id) {
      $this->load->model('settlements_model');
      $this->data['settlements'] = $this->settlements_model->get_settlements($set_id);
      $this->data['purposes'] = $this->settlements_model->get_purposes($set_id);
      if ($this->data['purposes']['state_id'] == 0) {
       // $this->purposes_self_sign($set_id);
        $this->settlements_model->update_purposes_state($set_id, 1);
          redirect('/settlements/purposes_stage/'.$set_id);
      } elseif ($this->data['purposes']['state_id'] == 1) {
        //$queue = $this->notify_purposes_signers($set_id, $this->data['purposes']['hotel_id']);
        if (!$queue) {
          $this->notify($set_id);
          $this->settlements_model->update_purposes_state($set_id, 2);
         // $user = $this->users_model->get_user_by_id($this->data['purposes']['user_id'], TRUE);
          //$this->purposes_approvel_mail($user->fullname, $user->email, $set_id);
          redirect('/settlements/purposes_stage/'.$set_id);
        }
      }elseif ($this->data['purposes']['state_id'] == 3){
        $user = $this->users_model->get_user_by_id($this->data['purposes']['user_id'], TRUE);
        $this->purposes_reject_mail($user->fullname, $user->email, $set_id);
        }
      redirect('/settlements/purposes_view/'.$set_id);
    }
    

    private function self_sign($set_id) {
      $this->load->model('settlements_model');
      $this->settlements_model->self_sign($set_id, $this->data['user_id']);
    }

    private function purposes_self_sign($set_id) {
      $this->load->model('settlements_model');
      $this->settlements_model->purposes_self_sign($set_id, $this->data['user_id']);
    }

    private function notify_purposes_signers($set_id) {
      $notified = FALSE;
      $signers1 = $this->get_purposes_signers($set_id, $this->data['settlements']['hotel_id']);
      foreach ($signers1 as $signer) {
        if (isset($signer['queue'])) {
          $notified = TRUE;
            foreach ($signer['queue'] as $uid => $user) {
              $this->purposes_signatures_mail($signer['role'], $user['name'], $user['mail'], $set_id);
          }
          break;
        }
      }
      return $notified;
    }

    public function notify($set_id) {
      $this->load->model('settlements_model');
      $this->load->model('users_model');
        $this->data['settlements'] = $this->settlements_model->get_settlements($set_id);
        $signes = $this->settlements_model->getby_verbal($set_id);
        $users = array();
        foreach ($signes as $signe){
          $users = $this->users_model->getby_criteria($signe['role_id'], $this->data['settlements']['hotel_id']);
          foreach($users as $user){
            $name = $user['fullname'];
            $mail = $user['email'];
            $this->load->library('email');
              $this->load->helper('url');
              $pur_url = base_url().'settlements/purposes_view/'.$set_id;
              $this->email->from('e-signature@sunrise-resorts.com');
              $this->email->to($mail);
              $this->email->subject("purposes of Report for settlements Form No. #{$set_id}");
              $this->email->message("Dear {$name},<br/>
                        <br/>
                        purposes of Report for settlements Form No. #{$set_id} has been approved, Please use the link below:<br/>
                        <a href='{$pur_url}' target='_blank'>{$pur_url}</a><br/>
                        "); 
              $mail_result = $this->email->send();
          }
      }
      redirect('settlements/purposes_view/'.$set_id);
    }

    private function purposes_signatures_mail($role, $name, $mail, $set_id) {
      $this->load->library('email');
      $this->load->helper('url');
      $pur_url = base_url().'settlements/purposes_view/'.$set_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($mail);
      $this->email->subject("purposes of Report for settlements Form No. #{$set_id}");
      $this->email->message("Dear {$name},<br/>
                <br/>
                purposes of Report for settlements Form No. #{$set_id} requires your signature, Please use the link below:<br/>
                <a href='{$pur_url}' target='_blank'>{$pur_url}</a><br/>
                "); 
      $mail_result = $this->email->send();
    }

    private function purposes_reject_mail($name, $email, $set_id) {
      $this->load->library('email');
      $this->load->helper('url');
      $pur_url = base_url().'settlements/purposes_view/'.$set_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($email);
      $this->email->subject("purposes of Report for settlements Form No. #{$set_id}");
      $this->email->message("Dear {$name},<br/>
                <br/>
                purposes of Report for settlements Form No. #{$set_id} has been rejected, Please use the link below:<br/>
                <a href='{$pur_url}' target='_blank'>{$pur_url}</a><br/>
                "); 
      $mail_result = $this->email->send();
    }

    private function purposes_approvel_mail($name, $email, $set_id) {
      $this->load->library('email');
      $this->load->helper('url');
      $pur_url = base_url().'settlements/purposes_view/'.$set_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($email);
      $this->email->subject("purposes of Report for settlements Form No. #{$set_id}");
      $this->email->message("Dear {$name},<br/>
                <br/>
                purposes of Report for settlements Form No. #{$set_id} has been approved, Please use the link below:<br/>
                <a href='{$pur_url}' target='_blank'>{$pur_url}</a><br/>
                "); 
      $mail_result = $this->email->send();
    }

    // public function  purposes_mailto($set_id) {
    //   if ($this->input->post('submit')) {
    //     $this->load->library('form_validation');
    //     $this->form_validation->set_rules('message','message is required','trim|required');
    //     $this->form_validation->set_rules('mail','mail is required','trim|required');
    //     if ($this->form_validation->run() == TRUE) {
    //       $message = $this->input->post('message');
    //       $email = $this->input->post('mail');
    //       $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
    //       $this->load->library('email');
    //       $this->load->helper('url');
    //       $pur_url = base_url().'settlements/purposes_view/'.$set_id;
    //       $this->email->from('e-signature@sunrise-resorts.com');
    //       $this->email->to($email);
    //       $this->email->subject("A message from {$user->fullname}, purposes of Report for settlements Form No. #{$set_id}");
    //       $this->email->message("{$user->fullname} sent you a private message regarding purposes of Report for settlements Form No. #{$set_id}:<br/>
    //                 {$message}<br />
    //                 <br />
    //                 Please use the link below to view the purposes of Report for settlements Form:
    //                 <a href='{$pur_url}' target='_blank'>{$pur_url}</a><br/>
    //               "); 
    //       $mail_result = $this->email->send();
    //     }
    //   }
    //   redirect('settlements/purposes_view/'.$set_id);
    // }
    
    public function report_all() {
          if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
        $this->load->helper('form');
        if ($this->input->post('submit')) {
          $this->data['state'] = $this->input->post('state');
          $from_date = $this->input->post('from');
          $to_date = $this->input->post('to');
          $from_date .="-01 00:00:00";
          $to_date .= "-31 23:59:59";
          $this->load->model('settlements_model');
          $this->load->model('hotels_model');   
          $this->data['hotels'] = $this->hotels_model->getall();
          $this->data['app'] = $this->settlements_model->getall_approved($from_date, $to_date);
          $this->data['app_count'] = $this->settlements_model->getall_approved_count($from_date, $to_date);
          $count1 =  array();
          foreach ($this->data['app'] as $re) {
            $count1[] = $re['hotel_name'];
          }
          $this->data['count1'] = array_count_values($count1);
          $this->data['app_value'] =  array();
          $i = 0;
          foreach ($this->data['count1'] as $key => $value) {
            $this->data['app_value'][$i] = $this->settlements_model->get_app_value($from_date, $to_date, $key);
            $i++;
          }
          //die(print_r($this->data['app_value']));
          $this->data['wait'] = $this->settlements_model->getall_wait($from_date, $to_date);
          $this->data['wait_count'] = $this->settlements_model->getall_wait_count($from_date, $to_date);
          $count =  array();
          foreach ($this->data['wait'] as $re) {
            $count[] = $re['hotel_name'];
          }
          $this->data['count'] = array_count_values($count);
          $this->data['wait_value'] =  array();
          $i = 0;
          foreach ($this->data['count'] as $key => $value) {
            $this->data['wait_value'][$i] = $this->settlements_model->get_wait_value($from_date, $to_date, $key);
            $i++;
          }
          //die(print_r($this->data['wait_value']));
          $this->data['reje'] = $this->settlements_model->getall_reject($from_date, $to_date);
          $this->data['reje_count'] = $this->settlements_model->getall_reject_count($from_date, $to_date);
          $count2 =  array();
          foreach ($this->data['reje'] as $re) {
            $count2[] = $re['hotel_name'];
          }
          $this->data['count2'] = array_count_values($count2);
          $this->data['reje_value'] =  array();
          $i = 0;
          foreach ($this->data['count2'] as $key => $value) {
            $this->data['reje_value'][$i] = $this->settlements_model->get_reje_value($from_date, $to_date, $key);
            $i++;
          }
          $this->data['char'] = $this->settlements_model->getall_chairman($from_date, $to_date);
          $this->data['char_count'] = $this->settlements_model->getall_chairman_count($from_date, $to_date);
          $count3 =  array();
          foreach ($this->data['char'] as $re) {
            $count3[] = $re['hotel_name'];
          }
          $this->data['count3'] = array_count_values($count3);
          $this->data['char_value'] =  array();
          $i = 0;
          foreach ($this->data['count3'] as $key => $value) {
            $this->data['char_value'][$i] = $this->settlements_model->get_char_value($from_date, $to_date, $key);
            $i++;
          }
          $this->data['close'] = $this->settlements_model->getall_close($from_date, $to_date);
          $this->data['close_count'] = $this->settlements_model->getall_close_count($from_date, $to_date);
          $count4 =  array();
          foreach ($this->data['close'] as $re) {
            $count4[] = $re['hotel_name'];
          }
          $this->data['count4'] = array_count_values($count4);
          $this->data['close_value'] =  array();
          $i = 0;
          foreach ($this->data['count4'] as $key => $value) {
            $this->data['close_value'][$i] = $this->settlements_model->get_close_value($from_date, $to_date, $key);
            $i++;
          }
        }
        $this->load->view('settlements_report', $this->data);
      }else{
        redirect('/unknown');
      }
    }

    public function report_hotel() {
          if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
        $this->load->helper('form');
        $this->load->model('hotels_model');   
        $this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
        if ($this->input->post('submit')) {
          $this->data['state'] = $this->input->post('state');
          $from_date = $this->input->post('from');
          $to_date = $this->input->post('to');
          $from_date .="-01 00:00:00";
          $to_date .= "-31 23:59:59";
          $hotel_id = $this->input->post('hotel_id');
          $this->load->model('settlements_model');
          $this->data['app'] = $this->settlements_model->get_approved($hotel_id, $from_date, $to_date);
          $this->data['app_count'] = $this->settlements_model->get_approved_count($hotel_id, $from_date, $to_date);
          $this->data['wait'] = $this->settlements_model->get_wait($hotel_id, $from_date, $to_date);
          $this->data['wait_count'] = $this->settlements_model->get_wait_count($hotel_id, $from_date, $to_date);
          $this->data['reje'] = $this->settlements_model->get_reject($hotel_id, $from_date, $to_date);
          $this->data['reje_count'] = $this->settlements_model->get_reject_count($hotel_id, $from_date, $to_date);
          $this->data['char'] = $this->settlements_model->get_chairman($hotel_id, $from_date, $to_date);
          $this->data['char_count'] = $this->settlements_model->get_chairman_count($hotel_id, $from_date, $to_date);
          $this->data['close'] = $this->settlements_model->get_close($hotel_id, $from_date, $to_date);
          $this->data['close_count'] = $this->settlements_model->get_close_count($hotel_id, $from_date, $to_date);
        }
        $this->load->view('settlements_report_hotel', $this->data);
      }else{
        redirect('/unknown');
      }
    }

    public function report_states_all() {
          if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
        $this->load->helper('form');
        if ($this->input->post('submit')) {
        	$state = $this->input->post('state');
          $from_date = $this->input->post('from');
          $to_date = $this->input->post('to');
        	if ($state != NULL) {
  			$this->data['state'] = $state;
  		}
          $this->data['from_date'] = $from_date;
          $this->data['to_date'] = $to_date;
          $from_date .="-01 00:00:00";
          $to_date .= "-31 23:59:59";
          $this->load->model('settlements_model');
          $this->load->model('hotels_model');   
          $this->data['forms'] = $this->settlements_model->getall_state($state, $from_date, $to_date);
          $this->data['forms_count'] = $this->settlements_model->getall_state_count($state, $from_date, $to_date);
          $count =  array();
          foreach ($this->data['forms'] as $re) {
            $count[] = $re['hotel_name'];
          }
          $this->data['count'] = array_count_values($count);
          $this->data['form_value'] =  array();
          $i = 0;
          foreach ($this->data['count'] as $key => $value) {
            $this->data['form_value'][$i] = $this->settlements_model->getall_state_value($state, $from_date, $to_date, $key);
            $i++;
          }
        }
        $this->load->view('settlements_state_report', $this->data);
      }else{
        redirect('/unknown');
      }
    }

    public function report_states() {
          if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
        $this->load->helper('form');
        $this->load->model('hotels_model');   
        $this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
        if ($this->input->post('submit')) {
        	$state = $this->input->post('state');
          $from_date = $this->input->post('from');
          $to_date = $this->input->post('to');
          $hotel_id = $this->input->post('hotel_id');
          if ($state != NULL) {
  			$this->data['state'] = $state;
  		}
          $this->data['from_date'] = $from_date;
          $this->data['to_date'] = $to_date;
          if ($hotel_id != NULL) {
  			$this->data['hotel'] = $this->hotels_model->get_by_id($hotel_id);
  		}
          $from_date .="-01 00:00:00";
          $to_date .= "-31 23:59:59";
          $this->load->model('settlements_model');
          $this->data['forms'] = $this->settlements_model->get_state($state, $from_date, $to_date, $hotel_id);
          $this->data['forms_count'] = $this->settlements_model->get_state_count($state, $from_date, $to_date, $hotel_id);
        }
        $this->load->view('settlements_state_report_hotel', $this->data);
      }else{
        redirect('/unknown');
      }
    }

    public function set_reports() {
          if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
          $this->load->view('settlements_report_index.php', $this->data);
      }else{
        redirect('/unknown');
      }
    }*/

  }

?>