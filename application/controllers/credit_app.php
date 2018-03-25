<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  class credit_app extends CI_Controller {

    private $data;

  public function __construct() {
      parent::__construct();
      $this->load->model('credit_app_model');
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
    public function index($state = FALSE) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        if ($state == 12) {
          $states = $this->input->post('states_id');
        }else{
          $states = $state;
        }
        $this->load->model('hotels_model');
        $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
        $hotels = array();
        foreach ($user_hotels as $hotel) {
          $hotels[] = $hotel['id'];
        }  
        $this->data['credits_app'] = $this->credit_app_model->view_index($hotels, $states);
        foreach ($this->data['credits_app'] as $key => $credit) {
          $this->data['credits_app'][$key]['approvals'] = $this->credit_app_model->get_by_verbals($this->data['credits_app'][$key]['id']);
        } 
        if ($this->input->post('submit')) {
          $this->data['var'] = $this->input->post('states_id');
        }
        $this->data['hotels'] = $user_hotels;
        $this->data['state'] = $state;
        $this->data['states'] = $this->credit_app_model->get_states();
        $this->load->view('credit_app_index', $this->data);
      }
    }  
   public function submit() {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        if ($this->input->post('submit')) {
          $this->load->library('form_validation');
          $this->load->library('email');
          $this->form_validation->set_rules('hotel_id','Hotel','trim|required');
          $this->form_validation->set_rules('tel','Contact Person Telephone','trim|required');
          $this->form_validation->set_rules('mail','Contact Person Email','trim|required');
          $this->form_validation->set_rules('comp_name','Company Name','trim|required');
          $this->form_validation->set_rules('comp_tel','Company Telephone','trim|required');
          $this->form_validation->set_rules('bank_name','Bank Name','trim|required');
          $this->form_validation->set_rules('acc_num','Account Number','trim|required');
          $this->form_validation->set_rules('bank_tel','Bank Telephone','trim|required');
          $assumed_id = $this->input->post('assumed_id');              
          if ($this->form_validation->run() == TRUE) {
            $form_data = array(
              'user_id' => $this->data['user_id'],
              'ip' => $this->input->ip_address(),
              'hotel_id' => $this->input->post('hotel_id'),
              'per_name' => $this->input->post('per_name'), 
              'title' => $this->input->post('title'),
              'tel' => $this->input->post('tel'),
              'mail' => $this->input->post('mail'), 
              'comp_name' => $this->input->post('comp_name'),
              'business_nature' => $this->input->post('business_nature'),
              'comp_address' => $this->input->post('comp_address'), 
              'comp_tel' => $this->input->post('comp_tel'),
              'bank_name' => $this->input->post('bank_name'),
              'acc_num' => $this->input->post('acc_num'),
              'bank_address' => $this->input->post('bank_address'),
              'bank_tel' => $this->input->post('bank_tel'), 
              'estimated_amount' => $this->input->post('estimated_amount'),
              'required_deposite' => $this->input->post('required_deposite')
            );
            $credit_app_id = $this->credit_app_model->create_credit_app($form_data);
            if ($credit_app_id) {
              $this->credit_app_model->update_files($assumed_id,$credit_app_id);
            } else {
              die("error");
            }
           foreach ($this->input->post('items') as $Key => $item) {
                $item['credit_app_id'] = $credit_app_id;    
                $item_id = $this->credit_app_model->create_item($item);
                if (!$item_id) {
                  die("ERROR");
                }
              }
            $signatures = $this->credit_app_model->credit_app_sign(1);
            $do_sign = $this->credit_app_model->credit_app_do_sign($credit_app_id);
            if ($do_sign == 0) {
              foreach ($signatures as $credit_app_signature) {
                $this->credit_app_model->add_signature($credit_app_id,$credit_app_signature['role'],$credit_app_signature['department'],$credit_app_signature['rank']);
              }
            }
            $this->credit_app_model->self_sign($credit_app_id, $this->data['user_id']);
            redirect('/credit_app/credit_app_stage/'.$credit_app_id);
          }   
        } 
        try {
          $this->load->helper('form');
          $this->load->model('hotels_model');
          $this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
          if ($this->input->post('submit')) {
            $this->data['assumed_id'] = $this->input->post('assumed_id');
            $this->data['uploads'] = $this->credit_app_model->getby_fille($this->data['assumed_id']);
          } else {
            $this->data['assumed_id'] = strtoupper(str_pad(dechex( mt_rand( 0, 1048575 ) ), 5, '0', STR_PAD_LEFT));
            $this->data['uploads'] = array();
          }
          $this->load->view('credit_app_add_new',$this->data);
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
       }
      } 
     public function edit($credit_app_id) {
       if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        if ($this->input->post('submit')) {
          $this->load->library('form_validation');
          $this->load->library('email');
          $this->form_validation->set_rules('hotel_id','Hotel','trim|required');
          $this->form_validation->set_rules('tel','Contact Person Telephone','trim|required');
          $this->form_validation->set_rules('mail','Contact Person Email','trim|required');
          $this->form_validation->set_rules('comp_name','Company Name','trim|required');
          $this->form_validation->set_rules('comp_tel','Company Telephone','trim|required');
          $this->form_validation->set_rules('bank_name','Bank Name','trim|required');
          $this->form_validation->set_rules('acc_num','Account Number','trim|required');
          $this->form_validation->set_rules('bank_tel','Bank Telephone','trim|required');
          $assumed_id = $this->input->post('assumed_id');              
          if ($this->form_validation->run() == TRUE) {
            $form_data = array(
              'user_id' => $this->data['user_id'],
              'ip' => $this->input->ip_address(),
              'hotel_id' => $this->input->post('hotel_id'),
              'per_name' => $this->input->post('per_name'), 
              'title' => $this->input->post('title'),
              'tel' => $this->input->post('tel'),
              'mail' => $this->input->post('mail'), 
              'comp_name' => $this->input->post('comp_name'),
              'business_nature' => $this->input->post('business_nature'),
              'comp_address' => $this->input->post('comp_address'), 
              'comp_tel' => $this->input->post('comp_tel'),
              'bank_name' => $this->input->post('bank_name'),
              'acc_num' => $this->input->post('acc_num'),
              'bank_address' => $this->input->post('bank_address'),
              'bank_tel' => $this->input->post('bank_tel'), 
              'estimated_amount' => $this->input->post('estimated_amount'),
              'required_deposite' => $this->input->post('required_deposite')
            );
            $this->credit_app_model->update_credit_app($credit_app_id, $form_data);
             foreach ($this->input->post('items') as $Key => $item) {
                $item['credit_app_id'] = $credit_app_id; 
                $this->credit_app_model->update_item($item['id'], $credit_app_id,$item);
              }
            $this->notify_edit($credit_app_id, $this->data['user_id']);
            redirect('/credit_app/view/'.$credit_app_id);
          }   
        }
        try {
          $this->load->helper('form');
          $this->load->model('hotels_model');
          $this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
          $this->data['credit_app'] = $this->credit_app_model->get_credit_app($credit_app_id);
          $this->data['credit_app_hotels'] = $this->credit_app_model->get_credit_app_hotels($credit_app_id);
          $this->data['uploads'] = $this->credit_app_model->getby_fille($credit_app_id);          
          $this->load->view('credit_app_edit',$this->data);
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
      }
    }  
   public function credit_edit($credit_app_id) {
       if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        if ($this->input->post('submit')) {
          $this->load->library('form_validation');
          $this->load->library('email');
          $this->form_validation->set_rules('pre_booking_date','Previous Hotel Bookings ','trim|required');
          $this->form_validation->set_rules('ref','Reference','trim|required');
          $this->form_validation->set_rules('credit_decision','Credit Decision','trim|required');
          $this->form_validation->set_rules('billing_approval','Direct Billing Approval','trim|required');
          $this->form_validation->set_rules('payment_percentage','Percentage of Prepayment','trim|required');
          $assumed_id = $this->input->post('assumed_id');              
          if ($this->form_validation->run() == TRUE) {
            $this->data['credit_app'] = $this->credit_app_model->get_credit_app($credit_app_id);
            if ($this->data['credit_app']['credit_user']==0) {
            
            $form_data = array(
              'credit_user' => $this->data['user_id'],
              'pre_booking_date' => $this->input->post('pre_booking_date'),
              'ref' => $this->input->post('ref'), 
              'credit_decision' => $this->input->post('credit_decision'),
              'billing_approval' => $this->input->post('billing_approval'),
              'payment_percentage' => $this->input->post('payment_percentage'), 
              'others' => $this->input->post('others'),
              'state_id' =>'6'
            );
            $this->data['credit_app'] = $this->credit_app_model->get_credit_app($credit_app_id);
             $signatures = $this->credit_app_model->credit_app_sign(2);
              foreach ($signatures as $credit_app_signature) {
                $this->credit_app_model->add_signature($credit_app_id,$credit_app_signature['role'],$credit_app_signature['department'],$credit_app_signature['rank']);
                 }
                $this->credit_app_model->update_credit_app($credit_app_id, $form_data);
                //$this->notify_edit($credit_app_id, $this->data['user_id']);
                 redirect('/credit_app/credit_app_stage/'.$credit_app_id);
                redirect('/credit_app/view/'.$credit_app_id);
           }elseif ($this->data['credit_app']['credit_user']!=0) {
             $form_data = array(
              'pre_booking_date' => $this->input->post('pre_booking_date'),
              'ref' => $this->input->post('ref'), 
              'credit_decision' => $this->input->post('credit_decision'),
              'billing_approval' => $this->input->post('billing_approval'),
              'payment_percentage' => $this->input->post('payment_percentage'), 
              'others' => $this->input->post('others')
            );
            $this->credit_app_model->update_credit_app($credit_app_id, $form_data);
            $this->notify_edit($credit_app_id, $this->data['user_id']);
            redirect('/credit_app/view/'.$credit_app_id);

           }
          }   
        }
        try {
          $this->load->helper('form');
          $this->data['credit_app'] = $this->credit_app_model->get_credit_app($credit_app_id);      
          $this->load->view('credit_app_credit_part',$this->data);
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
        $this->credit_app_model->add_fille($adjust_id, $file_name, $this->data['user_id']);
        die("{}");
      }
     }

  public function remove($adjust_id, $id) {
      $file_name = $_POST['key'];
      if (!$id) {
        die(json_encode($this->data['error']));
      } else {
        $this->credit_app_model->remove_fille($id);
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
   public function unsign($signature_id) {
      $signature_identity = $this->credit_app_model->get_signature_identity($signature_id);
      $this->credit_app_model->unsign($signature_id);
      $this->credit_app_model->update_state($signature_identity['credit_app_id'], 1);
     redirect('/credit_app/credit_app_stage/'.$signature_identity['credit_app_id']);  
    }

    public function sign($signature_id, $reject = FALSE) {
      $signature_identity = $this->credit_app_model->get_signature_identity($signature_id);
      $signrs = $this->get_signers($signature_identity['credit_app_id'], $signature_identity['hotel_id']);
      if (array_key_exists($this->data['user_id'], $signrs[$signature_id]['queue'])) {
        if ($reject) {
          $this->credit_app_model->reject($signature_id, $this->data['user_id']);
          $this->credit_app_model->update_state($signature_identity['credit_app_id'], 3);
          redirect('/credit_app/credit_app_stage/'.$signature_identity['credit_app_id']);  
        } else {
          $this->credit_app_model->sign($signature_id, $this->data['user_id']);
          if ($signature_identity['rank'] == 2){
            $this->credit_app_model->update_state($signature_identity['credit_app_id'], 5);
         redirect('/credit_app/credit_app_stage/'.$signature_identity['credit_app_id']);  
          }
         redirect('/credit_app/credit_app_stage/'.$signature_identity['credit_app_id']);   
        }
      }
      redirect('/credit_app/view/'.$signature_identity['credit_app_id']);
    }
  
  public function credit_app_stage($credit_app_id) {
      $this->data['credit_app'] = $this->credit_app_model->get_credit_app($credit_app_id);
      if ($this->data['credit_app']['state_id'] == 0) {
        $this->credit_app_model->update_state($credit_app_id, 1);
        redirect('/credit_app/credit_app_stage/'.$credit_app_id);
      }elseif ($this->data['credit_app']['state_id'] == 3){
        $user = $this->users_model->get_user_by_id($this->data['credit_app']['user_id'], TRUE);
        $queue = $this->reject_mail($user->fullname, $user->email, $credit_app_id);
      }elseif ($this->data['credit_app']['state_id'] == 5){
               $this->notify_credit($this->data['credit_app']['hotel_id'],$credit_app_id);
      }elseif ($this->data['credit_app']['state_id'] == 6){
             $this->notify_signers($credit_app_id, $this->data['credit_app']['hotel_id']);
      }elseif ($this->data['credit_app']['state_id'] != 2 && $this->data['credit_app']['state_id'] != 5){
        $queue = $this->notify_signers($credit_app_id, $this->data['credit_app']['hotel_id']);
        if (!$queue) {
          $this->credit_app_model->update_state($credit_app_id, 2);
          $user = $this->users_model->get_user_by_id($this->data['credit_app']['user_id'], TRUE);
          $queue = $this->approvel_mail($user->fullname, $user->email, $credit_app_id);
          redirect('/credit_app/credit_app_stage/'.$credit_app_id);
        }
      }
      redirect('/credit_app/view/'.$credit_app_id);
     } 
   private function reject_mail($name, $email, $credit_app_id) {
      $this->load->library('email');
      $this->load->helper('url');
      $form_url = base_url().'credit_app/view/'.$credit_app_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($email);
      $this->email->subject("Credit Application Form No. #{$credit_app_id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
       Credit Application Form No. #{$credit_app_id} has been rejected, Please use the link below:
        <br/>
        <a href='{$form_url}' target='_blank'>{$form_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
      }    
    private function signatures_mail($role, $department, $name, $mail, $credit_app_id) {
      //die(print_r("expression"));
      $this->load->library('email');
      $this->load->helper('url');
      $form_url = base_url().'credit_app/view/'.$credit_app_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($mail);
      $this->email->subject("Credit Application Form No. #{$credit_app_id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
       Credit Application Form No. #{$credit_app_id} requires your signature, Please use the link below:
        <br/>
        <a href='{$form_url}' target='_blank'>{$form_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
     } 
   private function approvel_mail($name, $email, $credit_app_id) {
      $this->load->library('email');
      $this->load->helper('url');
      $form_url = base_url().'credit_app/view/'.$credit_app_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($email);
      $this->email->subject("Credit Application Form No. #{$credit_app_id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
       Credit Application Form No. #{$credit_app_id} has been approved, Please use the link below:
        <br/>
        <a href='{$form_url}' target='_blank'>{$form_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
      }
    private function notify_signers($credit_app_id,$hotel_id) {
      $notified = FALSE;
      $signers = $this->get_signers($credit_app_id,$hotel_id);
      $this->data['credit_app'] = $this->credit_app_model->get_credit_app($credit_app_id);
      foreach ($signers as $signer) {
        if (isset($signer['queue'])) {
          $notified = TRUE;
          foreach ($signer['queue'] as $uid => $user) {
            $this->signatures_mail($signer['role'], $signer['department'], $user['name'], $user['mail'], $credit_app_id);
          }
          break;
        }
      }
      return $notified;
     }
   private function get_signers($credit_app_id,$hotel_id) {
      $signatures = $this->credit_app_model->get_by_verbal($credit_app_id);
      return $this->roll_signers($signatures, $hotel_id, $credit_app_id);
      }  
   private function roll_signers($signatures, $hotel_id, $credit_app_id) {
      $signers = array();
      $credit_app = $this->credit_app_model->get_credit_app($credit_app_id);
      foreach ($signatures as $signature) {
        $signers[$signature['id']] = array();
        $signers[$signature['id']]['role'] = $signature['role'];
        $signers[$signature['id']]['role_id'] = $signature['role_id'];
        $signers[$signature['id']]['department'] = $signature['department'];
        $signers[$signature['id']]['department_id'] = $signature['department_id'];
        if ($signature['user_id']) {
          if ($signature['rank'] == 1){
            $this->credit_app_model->update_state($credit_app_id, 4);
          }elseif ($signature['rank'] == 2 && $credit_app['credit_user'] ==0){
            $this->credit_app_model->update_state($credit_app_id, 5);
          }elseif ($signature['rank'] == 2 && $credit_app['credit_user'] >=1){
            $this->credit_app_model->update_state($credit_app_id, 6);
          }elseif ($signature['rank'] == 3){
            $this->credit_app_model->update_state($credit_app_id, 7);
          }elseif ($signature['rank'] == 4){
            $this->credit_app_model->update_state($credit_app_id, 8);
          }elseif ($signature['rank'] == 5){
            $this->credit_app_model->update_state($credit_app_id, 2);
          }
          $signers[$signature['id']]['sign'] = array();
          $signers[$signature['id']]['sign']['id'] = $signature['user_id'];
          if ($signature['reject'] == 1) {
            $signers[$signature['id']]['sign']['reject'] = "reject";
            $this->credit_app_model ->update_state($credit_app_id, 3);
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
    public function view($credit_app_id) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{      
        $this->data['credit_app'] = $this->credit_app_model->get_credit_app($credit_app_id);
        $this->data['credit_app_hotels'] = $this->credit_app_model->get_credit_app_hotels($credit_app_id);
        $this->data['uploads'] = $this->credit_app_model->getby_fille($credit_app_id);
        $this->data['comments'] = $this->credit_app_model->get_comment($credit_app_id);
        $this->data['signature_path'] = '/assets/uploads/signatures/';
        $this->data['signers'] = $this->get_signers($this->data['credit_app']['id'], $this->data['credit_app']['hotel_id']);
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
          if ( $this->data['credit_app']['user_id'] == $this->data['user_id'] &&  $this->data['credit_app']['state_id'] != 2) {
            $editor = TRUE;
          }
        }
        $this->data['unsign_enable'] = (($unsign_enable) || $this->data['is_admin'])? TRUE : FALSE;
        $this->data['is_editor'] = ($editor || $this->data['is_admin'])? TRUE : FALSE;
        $this->load->view('credit_app_view', $this->data);
        }
       } 
    public function mail_me($credit_app_id) {
      $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
      $this->load->library('email');
      $this->load->helper('url');
      $form_url = base_url().'credit_app/view/'.$credit_app_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($user->email);
      $this->email->subject("Credit Application Form No. #{$credit_app_id}");
      $this->email->message("Credit Application Form No.#{$credit_app_id}:
        <br/>
        Please use the link below to view The Credit Application Form:
        <a href='{$form_url}' target='_blank'>{$form_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
      redirect('credit_app/view/'.$credit_app_id);
    }

    public function mail($credit_app_id) {
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
          $form_url = base_url().'credit_app/view/'.$credit_app_id;
          $this->email->from('e-signature@sunrise-resorts.com');
          $this->email->to($email);
          $this->email->subject("A message from {$user->fullname}, Credit Application Form No. #{$credit_app_id}");
          $this->email->message("{$user->fullname} sent you a private message regarding Credit Application Form No. #{$credit_app_id}:
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
      redirect('credit_app/view/'.$credit_app_id);
    }     
   public function notify_edit($credit_app_id, $user_id) {
      $credit_app = $this->credit_app_model->get_credit_app($credit_app_id);
      $commenter = $this->users_model->get_user_by_id($user_id, TRUE);
      $comment = $commenter->fullname;
      $signes = $this->credit_app_model->get_by_verbal($credit_app_id);
      $users = array();
      foreach ($signes as $signe){
        if ($signe['user_id']  && $signe['user_id'] != 30) {
          $user = $this->users_model->get_user_by_id($signe['user_id'], TRUE);
          $name = $user->fullname;
          $mail = $user->email;
          $this->load->library('email');
          $this->load->helper('url');
          $form_url = base_url().'credit_app/view/'.$credit_app_id;
          $this->email->from('e-signature@sunrise-resorts.com');
          $this->email->to($mail);
          $this->email->subject("Credit Application Form No. #{$credit_app_id}");
          $this->email->message("Dear {$name},

            <br/>
            <br/>
            {$comment} edited the Credit Application Form No.#{$credit_app_id}, Please use the link below:
            <br/>
            <a href='{$form_url}' target='_blank'>{$form_url}</a>
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
     public function notify_credit($hotel_id,$credit_app_id) {
      $credit_app = $this->credit_app_model->get_credit_app($credit_app_id);
     // $to_users = $this->credit_app_model->getby_role();
      $to_users = $this->users_model->getby_criteria(57, $hotel_id,0);
      $users = array();
      foreach ($to_users as $to_user){
          $user = $this->users_model->get_user_by_id($to_user['id'], TRUE);
          $name = $user->fullname;
          $mail = $user->email;
          $this->load->library('email');
          $this->load->helper('url');
          $form_url = base_url().'credit_app/view/'.$credit_app_id;
          $this->email->from('e-signature@sunrise-resorts.com');
          $this->email->to($mail);
          $this->email->subject("Credit Application Form No. #{$credit_app_id}");
          $this->email->message("Dear {$name},

            <br/>
            <br/>
             Credit Application Form NO.#{$credit_app_id}, Please use the link below to complete the form:
            <br/>
            <a href='{$form_url}' target='_blank'>{$form_url}</a>
            <br/>
          "); 
          $mail_result = $this->email->send();
          redirect('/credit_app/view/'.$credit_app_id);
             
          $data = array(
            'user' => $name,
            'mail' => $mail
          );         
      }
     } 

   public function comment($credit_app_id){
      if ($this->input->post('submit')) {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('comment','Comment','trim|required');
        if ($this->form_validation->run() == TRUE) {
          $comment = $this->input->post('comment'); 
          $comment_data = array(
            'user_id' => $this->data['user_id'],
            'credit_app_id' => $credit_app_id,
            'comment' => $comment
          );
          $this->credit_app_model->insert_comment($comment_data);
          $this->notify_commet($credit_app_id, $this->data['user_id']);
          if ($this->data['role_id'] == 217) {
            $this->chairman_mail($credit_app_id);
          }
        }
        redirect('/credit_app/view/'.$credit_app_id);
      }
     }

     private function chairman_mail($credit_id) {
          $this->load->library('email');
          $this->load->helper('url');
          $credit_url = base_url().'credit_app/view/'.$credit_id;
          $this->email->from('e-signature@sunrise-resorts.com');
          $this->email->to('abeer@sunrise.eg');
          $this->email->subject("Credit Application Form No. #{$credit_id}");
          $this->email->message("Dear Madam Abber,
            <br/>
            <br/>
            Mr Hossam Commented on Credit Application Form No. #{$credit_id}, Please use the link below:
            <br/>
            <a href='{$credit_url}' target='_blank'>{$credit_url}</a>
            <br/>
          "); 
          $mail_result = $this->email->send();
      }
      
    public function notify_commet($credit_app_id, $user_id) {
      $credit_app = $this->credit_app_model->get_credit_app($credit_app_id);
      $commenter = $this->users_model->get_user_by_id($user_id, TRUE);
      $comment = $commenter->fullname;
      $signes = $this->credit_app_model->get_by_verbal($credit_app_id);
      $users = array();
      foreach ($signes as $signe){
        if ($signe['user_id']  && $signe['user_id'] != 30) {
          $user = $this->users_model->get_user_by_id($signe['user_id'], TRUE);
          $name = $user->fullname;
          $mail = $user->email;
          $this->load->library('email');
          $this->load->helper('url');
          $form_url = base_url().'credit_app/view/'.$credit_app_id;
          $this->email->from('e-signature@sunrise-resorts.com');
          $this->email->to($mail);
          $this->email->subject("Credit Application Form No. #{$credit_app_id}");
          $this->email->message("Dear {$name},

            <br/>
            <br/>
            {$comment} made a comment on Credit Application Form No.#{$credit_app_id}, Please use the link below:
            <br/>
            <a href='{$form_url}' target='_blank'>{$form_url}</a>
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

}    