<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  class rate_sp extends CI_Controller {

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
      $this->data['menu']['active'] = "reserve";
    }

    public function index() {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{      
        $this->load->model('hotels_model');
        $this->load->model('rate_sp_model');
        $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
        $hotels = array();
        foreach ($user_hotels as $hotel) {
          $hotels[] = $hotel['id'];
        }    
        $this->data['sp'] = $this->rate_sp_model->view($hotels);
        foreach ($this->data['sp'] as $key => $sp) {
          $this->data['sp'][$key]['items'] = $this->rate_sp_model->get_itemss($this->data['sp'][$key]['id']);
        }
        foreach ($this->data['sp'] as $key => $sp) {
          $this->data['sp'][$key]['approvals'] = $this->rate_sp_model->get_by_verbals($this->data['sp'][$key]['id']);
        }
        $this->data['hotels'] = $this->hotels_model->getall();
        $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
        $this->load->view('sp_index', $this->data);
      }
    }

    public function index_app() {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{      
        $this->load->model('hotels_model');
        $this->load->model('rate_sp_model');
        $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
        $hotels = array();
        foreach ($user_hotels as $hotel) {
          $hotels[] = $hotel['id'];
        }    
        $this->data['sp'] = $this->rate_sp_model->view($hotels, 2);
         foreach ($this->data['sp'] as $key => $sp) {
          $this->data['sp'][$key]['items'] = $this->rate_sp_model->get_itemss($this->data['sp'][$key]['id']);
        }
        foreach ($this->data['sp'] as $key => $sp) {
          $this->data['sp'][$key]['approvals'] = $this->rate_sp_model->get_by_verbals($this->data['sp'][$key]['id']);
        }
        $this->data['hotels'] = $this->hotels_model->getall();
        $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
        $this->load->view('sp_index', $this->data);
      }
    }

    public function index_wat() {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{     
        if ($this->input->post('submit')) {
          $this->data['state'] = $this->input->post('state');
          $this->load->model('hotels_model');
          $this->load->model('rate_sp_model');
          $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
          $hotels = array();
          foreach ($user_hotels as $hotel) {
            $hotels[] = $hotel['id'];
          }    
          $this->data['sp'] = $this->rate_sp_model->view($hotels, $this->data['state']);
          foreach ($this->data['sp'] as $key => $sp) {
          $this->data['sp'][$key]['items'] = $this->rate_sp_model->get_itemss($this->data['sp'][$key]['id']);
        }
        foreach ($this->data['sp'] as $key => $sp) {
          $this->data['sp'][$key]['approvals'] = $this->rate_sp_model->get_by_verbals($this->data['sp'][$key]['id']);
        }
          $this->data['hotels'] = $user_hotels;
          $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
        }
        $this->load->view('sp_index_wat', $this->data);
      }
    }

    public function index_rej() {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{      
        $this->load->model('hotels_model');
        $this->load->model('rate_sp_model');
        $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
        $hotels = array();
        foreach ($user_hotels as $hotel) {
          $hotels[] = $hotel['id'];
        }    
        $this->data['sp'] = $this->rate_sp_model->view($hotels, 3);
        foreach ($this->data['sp'] as $key => $sp) {
          $this->data['sp'][$key]['items'] = $this->rate_sp_model->get_itemss($this->data['sp'][$key]['id']);
        }
        foreach ($this->data['sp'] as $key => $sp) {
          $this->data['sp'][$key]['approvals'] = $this->rate_sp_model->get_by_verbals($this->data['sp'][$key]['id']);
        }
        $this->data['hotels'] = $this->hotels_model->getall();
        $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
        $this->load->view('sp_index', $this->data);
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
          $assumed_id = $this->input->post('assumed_id');                        
          if ($this->form_validation->run() == TRUE) {
            $this->load->model('rate_sp_model');
            $this->load->model('users_model');  
            $form_data = array(
              'user_id' => $this->data['user_id'],
              'hotel_id' => $this->input->post('hotel_id')
            );
            $sp_id = $this->rate_sp_model->create_rate($form_data);
            if ($sp_id) {
              $this->load->model('rate_sp_model');
              $this->rate_sp_model->update_files($assumed_id,$sp_id);
            } else {
              die("ERROR");//@TODO failure view
            }
            $resulte =  array();
            foreach ($this->input->post('items') as $Key => $item) {
              $item['sp_id'] = $sp_id;  
              $item['user_id'] = $this->data['user_id']; 
              $file_name = $this->do_upload("items-".$Key."-fille");
              $item['fille'] = $file_name; 
              $resulte[] = $item['discount'];
              $item_id = $this->rate_sp_model->create_item($item);    
              if (!$item_id) {
                die("ERROR");
              }
            }
            $hotel_id = $form_data['hotel_id'];
            $percentage = max($resulte);
            if (( $hotel_id !=7 &&  $this-> $hotel_id !=8 ) && ( $percentage >= 0 &&  $percentage <= 15)) {
              $sp_type = 1;
            }elseif (( $hotel_id !=7 &&  $this-> $hotel_id !=8 ) && ( $percentage >= 16 &&  $percentage <= 30)) {
              $sp_type = 2;            
            }elseif (( $hotel_id !=7 &&  $this-> $hotel_id !=8 ) && ($percentage >= 31)) {
              $sp_type = 3;
            }elseif (( $hotel_id ==7 ||  $this-> $hotel_id ==8 ) && ( $percentage >= 0 &&  $percentage <= 15)) {
              $sp_type = 4;           
            }elseif (( $hotel_id ==7 ||  $this-> $hotel_id ==8 ) && ( $percentage >= 16 &&  $percentage <= 40)) {
              $sp_type = 5;            
            }elseif (( $hotel_id ==7 ||  $this-> $hotel_id ==8 ) && ($percentage >= 41)) {
              $sp_type = 6;
            }   
            $this->rate_sp_model->update_type($sp_type,$sp_id);
            $this->notify_before($sp_id);
            $signatures = $this->rate_sp_model->sp_sign($sp_type);
            $do_sign = $this->rate_sp_model->sp_do_sign($sp_id);
            //die(print_r($do_sign));
            if ($do_sign == 0) {
              foreach ($signatures as $sp_signature) {
                $this->rate_sp_model->add_signature($sp_id, $sp_signature['role'], $sp_signature['department'], $sp_signature['rank']);
              }
            }
            redirect('/rate_sp/sp_stage/'.$sp_id);
          }
        }
        try {
          $this->load->helper('form');
          $this->load->model('rate_sp_model');
          $this->load->model('hotels_model');
          $this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());
          $this->data['boards'] = $this->rate_sp_model->getall_board();
          if ($this->input->post('submit')) {
            $this->load->model('rate_sp_model');
            $this->data['assumed_id'] = $this->input->post('assumed_id');
            $this->data['uploads'] = $this->rate_sp_model->getby_fille($this->data['assumed_id']);
          } else {
            $this->data['assumed_id'] = strtoupper(str_pad(dechex( mt_rand( 0, 1048575 ) ), 5, '0', STR_PAD_LEFT));
            $this->data['uploads'] = array();
          }
          $this->load->view('sp_add_new',$this->data);
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
      }
    }

    public function make_offer($sp_id) {
      $file_name = $this->do_upload("upload");
      if (!$file_name) {
        die(json_encode($this->data['error']));
      } else {
        $this->load->model("rate_sp_model");
        $this->rate_sp_model->add($sp_id, $file_name, $this->data['user_id']);
        die("{}");
      }
    }

    public function remove_offer($sp_id, $id) {
      $file_name = $_POST['key'];
      if (!$id) {
        die(json_encode($this->data['error']));
      } else {
        $this->load->model("rate_sp_model");
        $this->rate_sp_model->remove($id);
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

    public function sp_stage($sp_id) {
      $this->load->model('rate_sp_model');
      $this->data['sp'] = $this->rate_sp_model->get_sp($sp_id);
      if ($this->data['sp']['state_id'] == 0) {
        $this->rate_sp_model->update_state($sp_id, 1);
        redirect('/rate_sp/sp_stage/'.$sp_id);
      } elseif ($this->data['sp']['state_id'] != 0 && $this->data['sp']['state_id'] != 2 && $this->data['sp']['state_id'] != 3) {
        $queue = $this->notify_signers($sp_id, $this->data['sp']['hotel_id']);
        if (!$queue) {
          $this->rate_sp_model->update_state($sp_id, 2);
          $this->notify_after($sp_id);
          $user = $this->users_model->get_user_by_id($this->data['sp']['user_id'], TRUE);
          $this->approvel_mail($user->fullname, $user->email, $sp_id);
          redirect('/rate_sp/sp_stage/'.$sp_id);
        }
      }elseif ($this->data['sp']['state_id'] == 3){
        $user = $this->users_model->get_user_by_id($this->data['sp']['user_id'], TRUE);
        $queue = $this->reject_mail($user->fullname, $user->email, $sp_id);
      }
      redirect('/rate_sp/view/'.$sp_id);
    }

    private function notify_signers($sp_id) {
      $notified = FALSE;
      $sp_url = base_url().'rate_sp/view/'.$sp_id;
      $message = "Special Rates Form No. {$sp_id}:
          {$sp_url}";
      $signers = $this->get_signers($sp_id, $this->data['sp']['hotel_id']);
      foreach ($signers as $signer) {
        if (isset($signer['queue'])) {
          $notified = TRUE;
          foreach ($signer['queue'] as $uid => $user) {
            $this->onclick($message, $sp_id, $user['channel']);
            $this->signatures_mail($signer['role'], $signer['department'], $user['name'], $user['mail'], $sp_id);
          }
          break;
        }
      }
      return $notified;
    }

    private function approvel_mail($name, $email, $sp_id) {
      $this->load->model('rate_sp_model');
      $sp = $this->rate_sp_model->get_sp($sp_id);
      if ($sp['type'] == 1 || $sp['type'] == 4) {
        $this->load->library('email');
        $this->load->helper('url');
        $sp_url = base_url().'rate_sp/view/'.$sp_id;
        $this->email->from('e-signature@sunrise-resorts.com');
        $this->email->to($email);
        $this->email->subject("DOS Approval Special Rates Form No. #{$sp_id}");
        $this->email->message("Dear {$name},
          <br/>
          <br/>
          DOS Approval Special Rates Form No. #{$sp_id} has been Approved, Please use the link below:
          <br/>
          <a href='{$sp_url}' target='_blank'>{$sp_url}</a>
          <br/>
        "); 
      }elseif($sp['type'] == 2 || $sp['type'] == 5){
        $this->load->library('email');
        $this->load->helper('url');
        $sp_url = base_url().'rate_sp/view/'.$sp_id;
        $this->email->from('e-signature@sunrise-resorts.com');
        $this->email->to($email);
        $this->email->subject("RDOS & Markting Approval Special Rates Form No. #{$sp_id}");
        $this->email->message("Dear {$name},
          <br/>
          <br/>
          RDOS & Markting Approval Special Rates Form No. #{$sp_id} has been Approved, Please use the link below:
          <br/>
          <a href='{$sp_url}' target='_blank'>{$sp_url}</a>
          <br/>
        "); 
      }elseif($sp['type'] == 3 || $sp['type'] == 6){
        $this->load->library('email');
        $this->load->helper('url');
        $sp_url = base_url().'rate_sp/view/'.$sp_id;
        $this->email->from('e-signature@sunrise-resorts.com');
        $this->email->to($email);
        $this->email->subject("Board Approval Special Rates Form No. #{$sp_id}");
        $this->email->message("Dear {$name},
          <br/>
          <br/>
          Board Approval Special Rates Form No. #{$sp_id} has been Approved, Please use the link below:
          <br/>
          <a href='{$sp_url}' target='_blank'>{$sp_url}</a>
          <br/>
        ");
      }
      $mail_result = $this->email->send();
    }

    private function reject_mail($name, $email, $sp_id) {
      $this->load->model('rate_sp_model');
      $sp = $this->rate_sp_model->get_sp($sp_id);
      if ($sp['type'] == 1 || $sp['type'] == 4) {
        $this->load->library('email');
        $this->load->helper('url');
        $sp_url = base_url().'rate_sp/view/'.$sp_id;
        $this->email->from('e-signature@sunrise-resorts.com');
        $this->email->to($email);
        $this->email->subject("DOS Approval Special Rates Form No. #{$sp_id}");
        $this->email->message("Dear {$name},
          <br/>
          <br/>
          DOS Approval Special Rates Form No. #{$sp_id} has been Rejected, Please use the link below:
          <br/>
          <a href='{$sp_url}' target='_blank'>{$sp_url}</a>
          <br/>
        "); 
      }elseif($sp['type'] == 2 || $sp['type'] == 5){
        $this->load->library('email');
        $this->load->helper('url');
        $sp_url = base_url().'rate_sp/view/'.$sp_id;
        $this->email->from('e-signature@sunrise-resorts.com');
        $this->email->to($email);
        $this->email->subject("RDOS & Markting Approval Special Rates Form No. #{$sp_id}");
        $this->email->message("Dear {$name},
          <br/>
          <br/>
          RDOS & Markting Approval Special Rates Form No. #{$sp_id} has been Rejected, Please use the link below:
          <br/>
          <a href='{$sp_url}' target='_blank'>{$sp_url}</a>
          <br/>
        "); 
      }elseif($sp['type'] == 3 || $sp['type'] == 6){
        $this->load->library('email');
        $this->load->helper('url');
        $sp_url = base_url().'rate_sp/view/'.$sp_id;
        $this->email->from('e-signature@sunrise-resorts.com');
        $this->email->to($email);
        $this->email->subject("Board Approval Special Rates Form No. #{$sp_id}");
        $this->email->message("Dear {$name},
          <br/>
          <br/>
          Board Approval Special Rates Form No. #{$sp_id} has been Rejected, Please use the link below:
          <br/>
          <a href='{$sp_url}' target='_blank'>{$sp_url}</a>
          <br/>
        ");
      }
      $mail_result = $this->email->send();
    }

    private function get_signers($sp_id, $hotel_id) {
      $this->load->model('rate_sp_model');
      $signatures = $this->rate_sp_model->getby_verbal($sp_id);
      return $this->roll_signers($signatures, $hotel_id, $sp_id);
    }

    private function signatures_mail($role, $department, $name, $mail, $sp_id) {
      $this->load->model('rate_sp_model');
      $sp = $this->rate_sp_model->get_sp($sp_id);
      if ($sp['type'] == 1 || $sp['type'] == 4) {
        $this->load->library('email');
        $this->load->helper('url');
        $sp_url = base_url().'rate_sp/view/'.$sp_id;
        $this->email->from('e-signature@sunrise-resorts.com');
        $this->email->to($mail);
        $this->email->subject("DOS Approval Special Rates Form No. #{$sp_id}");
        $this->email->message("Dear {$name},
          <br/>
          <br/>
          DOS Approval Special Rates Form No. #{$sp_id} requires your signature, Please use the link below:
          <br/>
          <a href='{$sp_url}' target='_blank'>{$sp_url}</a>
          <br/>
        "); 
      }elseif($sp['type'] == 2 || $sp['type'] == 5){
        $this->load->library('email');
        $this->load->helper('url');
        $sp_url = base_url().'rate_sp/view/'.$sp_id;
        $this->email->from('e-signature@sunrise-resorts.com');
        $this->email->to($mail);
        $this->email->subject("RDOS & Markting Approval Special Rates Form No. #{$sp_id}");
        $this->email->message("Dear {$name},
          <br/>
          <br/>
          RDOS & Markting Approval Special Rates Form No. #{$sp_id} requires your signature, Please use the link below:
          <br/>
          <a href='{$sp_url}' target='_blank'>{$sp_url}</a>
          <br/>
        "); 
      }elseif($sp['type'] == 3 || $sp['type'] == 6){
        $this->load->library('email');
        $this->load->helper('url');
        $sp_url = base_url().'rate_sp/view/'.$sp_id;
        $this->email->from('e-signature@sunrise-resorts.com');
        $this->email->to($mail);
        $this->email->subject("Board Approval Special Rates Form No. #{$sp_id}");
        $this->email->message("Dear {$name},
          <br/>
          <br/>
          Board Approval Special Rates Form No. #{$sp_id} requires your signature, Please use the link below:
          <br/>
          <a href='{$sp_url}' target='_blank'>{$sp_url}</a>
          <br/>
        ");
      }
      $mail_result = $this->email->send();
    }

    private function roll_signers($signatures, $hotel_id, $sp_id) {
      $sp = $this->rate_sp_model->get_sp($sp_id);
      $rowcount = $this->rate_sp_model->get_count($sp_id);
      $signers = array();
      $this->load->model('users_model');
      foreach ($signatures as $signature) {
        $signers[$signature['id']] = array();
        $signers[$signature['id']]['role'] = $signature['role'];
        $signers[$signature['id']]['role_id'] = $signature['role_id'];
        $signers[$signature['id']]['department'] = $signature['department'];
        $signers[$signature['id']]['department_id'] = $signature['department_id'];
        if ($signature['user_id']) {
          if ($rowcount == 3) {
            if ($signature['rank'] == 1){
              $this->rate_sp_model->update_state($sp_id, 4);
            }elseif ($signature['rank'] == 2){
              $this->rate_sp_model->update_state($sp_id, 5);
            }elseif ($signature['rank'] == 3){
              $this->rate_sp_model->update_state($sp_id, 2);
            }
          }elseif($rowcount == 4) {
            if ($signature['rank'] == 1){
              $this->rate_sp_model->update_state($sp_id, 4);
            }elseif ($signature['rank'] == 2){
              $this->rate_sp_model->update_state($sp_id, 5);
            }elseif ($signature['rank'] == 3){
              $this->rate_sp_model->update_state($sp_id, 6);
            }elseif ($signature['rank'] == 4){
              $this->rate_sp_model->update_state($sp_id, 2);
            }
          }elseif($rowcount == 7) {
            if ($signature['rank'] == 1){
              $this->rate_sp_model->update_state($sp_id, 4);
            }elseif ($signature['rank'] == 2){
              $this->rate_sp_model->update_state($sp_id, 5);
            }elseif ($signature['rank'] == 3){
              $this->rate_sp_model->update_state($sp_id, 6);
            }elseif ($signature['rank'] == 4){
              $this->rate_sp_model->update_state($sp_id, 7);
            }elseif ($signature['rank'] == 5){
              $this->rate_sp_model->update_state($sp_id, 8);
            }elseif ($signature['rank'] == 6){
              $this->rate_sp_model->update_state($sp_id, 9);
            }elseif ($signature['rank'] == 7){
              $this->rate_sp_model->update_state($sp_id, 2);
            }
          }
          $signers[$signature['id']]['sign'] = array();
          $signers[$signature['id']]['sign']['id'] = $signature['user_id'];
          if ($signature['reject'] == 1) {
            $signers[$signature['id']]['sign']['reject'] = "reject";
            $this->rate_sp_model->update_state($sp_id, 3);
          } 
          $user = $this->users_model->get_user_by_id($signature['user_id'], TRUE);
          $signers[$signature['id']]['sign']['name'] = $user->fullname;
          $signers[$signature['id']]['sign']['mail'] = $user->email;
          $signers[$signature['id']]['sign']['channel'] = $user->channel;
          $signers[$signature['id']]['sign']['sign'] = $user->signature;
          $signers[$signature['id']]['sign']['timestamp'] = $signature['timestamp'];
        } else {
          $signers[$signature['id']]['queue'] = array();
          $users = $this->users_model->getby_criteria($signature['role_id'], $hotel_id);
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

    public function view($sp_id) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{      
        $this->load->model('rate_sp_model');
        $this->load->model('hotels_model');   
        $this->data['hotels'] = $this->hotels_model->getall();
        $this->data['sp'] = $this->rate_sp_model->get_sp($sp_id);
        $this->data['items'] = $this->rate_sp_model->get_items($sp_id);
        $this->data['uploads'] = $this->rate_sp_model->getby_fille($sp_id);
        $this->data['comments'] = $this->rate_sp_model->get_comment($sp_id);
        $this->data['signature_path'] = '/assets/uploads/signatures/';
        $this->data['signers'] = $this->get_signers($this->data['sp']['id'], $this->data['sp']['hotel_id']);
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
          if ( $this->data['sp']['user_id'] == $this->data['user_id'] &&  $this->data['sp']['state_id'] != 2) {
            $editor = TRUE;
          }
        }
        $this->data['unsign_enable'] = (($unsign_enable) || $this->data['is_admin'])? TRUE : FALSE;
        $this->data['is_editor'] = ( (($this->data['unsign_enable'] || $editor)) || ($force_edit) )? TRUE : FALSE;
        $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
        $this->data['id'] = $sp_id;
        $this->load->view('sp_view', $this->data);
      }
    }

    public function edit($sp_id) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{          
        if ($this->input->post('submit')) {
          $this->load->library('form_validation');
          $this->load->library('email');
          if ($this->form_validation->run() == FALSE) {
            $this->load->model('rate_sp_model');
            $this->load->model('users_model');  
            $form_data = array(
              'hotel_id' => $this->input->post('hotel_id')
            );
            $this->rate_sp_model->update_sp($form_data, $sp_id);
            foreach ($this->input->post('items') as $item) {
              $item['sp_id'] = $sp_id;  
              $file_name = $this->do_upload("items-".$item['id']."-fille");
              $item['fille'] = $file_name; 
              $this->rate_sp_model->update_item($item, $sp_id, $item['id']);
            }
            redirect('/rate_sp/view/'.$sp_id);
          }   
        }
        try {
          $this->load->helper('form');
          $this->load->model('rate_sp_model');
          $this->load->model('hotels_model');
          $this->data['sp'] = $this->rate_sp_model->get_sp($sp_id);
          $this->data['items'] = $this->rate_sp_model->get_items($sp_id);
          $this->data['boards'] = $this->rate_sp_model->getall_board();
          $this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());
          $this->data['uploads'] = $this->rate_sp_model->getby_fille($this->data['sp']['id']);
          $this->load->view('sp_edit',$this->data);
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
      }
    }

    public function submit_edit($sp_id) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        $this->load->model('rate_sp_model');
        $this->data['sp'] = $this->rate_sp_model->get_sp($sp_id);
        $this->data['items'] = $this->rate_sp_model->get_items($sp_id);
        if ($this->input->post('submit')) {
          $this->load->library('form_validation');
          $this->load->library('email');
          if ($this->form_validation->run() == FALSE) {
            $this->load->model('users_model');  
            $resulte =  array();
            foreach ($this->input->post('items') as $item) {
              $item['sp_id'] = $sp_id;  
              $item['user_id'] = $this->data['user_id'];  
              $resulte[] = $item['discount'];
            }
            $hotel_id = $this->data['sp']['hotel_id'];
            $percentage = max($resulte);
            if (( $hotel_id !=7 &&  $this-> $hotel_id !=8 ) && ( $percentage >= 0 &&  $percentage <= 15)) {
              $sp_type = 1;
            }elseif (( $hotel_id !=7 &&  $this-> $hotel_id !=8 ) && ( $percentage >= 16 &&  $percentage <= 30)) {
              $sp_type = 2;            
            }elseif (( $hotel_id !=7 &&  $this-> $hotel_id !=8 ) && ($percentage >= 31)) {
              $sp_type = 3;
            }elseif (( $hotel_id ==7 ||  $this-> $hotel_id ==8 ) && ( $percentage >= 0 &&  $percentage <= 15)) {
              $sp_type = 4;           
            }elseif (( $hotel_id ==7 ||  $this-> $hotel_id ==8 ) && ( $percentage >= 16 &&  $percentage <= 40)) {
              $sp_type = 5;            
            }elseif (( $hotel_id ==7 ||  $this-> $hotel_id ==8 ) && ($percentage >= 41)) {
              $sp_type = 6;
            }   
            //die(print_r($this->data['sp']['type']));
            if($sp_type <= $this->data['sp']['type']){
              foreach ($this->input->post('items') as $Key => $item) {
                $item['sp_id'] = $sp_id;  
                $file_name = $this->do_upload("items-".$Key."-fille");
                $item['fille'] = $file_name; 
                $item['user_id'] = $this->data['user_id'];  
                $item_id = $this->rate_sp_model->create_item($item);    
                if (!$item_id) {
                  die("ERROR");
                }
              }
              redirect('/rate_sp/view/'.$sp_id);
            }else{
              redirect('/rate_sp/submit_edit/'.$sp_id);
            }
          }
        }
        try {
          $this->load->helper('form');
          $this->load->model('rate_sp_model');
          $this->load->model('hotels_model');
          $this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());
          $this->data['boards'] = $this->rate_sp_model->getall_board();
          $this->data['uploads'] = $this->rate_sp_model->getby_fille($this->data['sp']['id']);
          $this->load->view('sp_add_edit',$this->data);
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
      }
    }

    public function mailto($sp_id) {
      $this->load->model('rate_sp_model');
      $sp = $this->rate_sp_model->get_sp($sp_id);
      if ($this->input->post('submit')) {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('message','message is required','trim|required');
        $this->form_validation->set_rules('mail','mail is required','trim|required');
        if ($this->form_validation->run() == TRUE) {
          $message = $this->input->post('message');
          $email = $this->input->post('mail');
          $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
          if ($sp['type'] == 1 || $sp['type'] == 4) {
            $this->load->library('email');
            $this->load->helper('url');
            $sp_url = base_url().'rate_sp/view/'.$sp_id;
            $this->email->from('e-signature@sunrise-resorts.com');
            $this->email->to($email);
            $this->email->subject("A message from {$user->fullname}, DOS Approval Special Rates Form No. #{$sp_id}");
            $this->email->message("{$user->fullname} sent you a private message regarding DOS Approval Special Rates Form No. #{$sp_id}:
              <br/>
              {$message}
              <br />
              <br />
              Please use the link below to view the DOS Approval Special Rates Form:
              <a href='{$sp_url}' target='_blank'>{$sp_url}</a>
              <br/>
            "); 
          }elseif($sp['type'] == 2 || $sp['type'] == 5){
            $this->load->library('email');
            $this->load->helper('url');
            $sp_url = base_url().'rate_sp/view/'.$sp_id;
            $this->email->from('e-signature@sunrise-resorts.com');
            $this->email->to($email);
            $this->email->subject("A message from {$user->fullname}, RDOS & Markting Approval Special Rates Form No. #{$sp_id}");
            $this->email->message("{$user->fullname} sent you a private message regarding RDOS & Markting Approval Special Rates Form No. #{$sp_id}:
              <br/>
              {$message}
              <br />
              <br />
              Please use the link below to view the RDOS & Markting Approval Special Rates Form:
              <a href='{$sp_url}' target='_blank'>{$sp_url}</a>
              <br/>
            "); 
          }elseif($sp['type'] == 3 || $sp['type'] == 6){
            $this->load->library('email');
            $this->load->helper('url');
            $sp_url = base_url().'rate_sp/view/'.$sp_id;
            $this->email->from('e-signature@sunrise-resorts.com');
            $this->email->to($email);
            $this->email->subject("A message from {$user->fullname}, Board Approval Special Rates Form No. #{$sp_id}");
            $this->email->message("{$user->fullname} sent you a private message regarding Board Approval Special Rates Form No. #{$sp_id}:
              <br/>
              {$message}
              <br />
              <br />
              Please use the link below to view the Board Approval Special Rates Form:
              <a href='{$sp_url}' target='_blank'>{$sp_url}</a>
              <br/>
            "); 
          }
          $mail_result = $this->email->send();
        }
      }
      redirect('rate_sp/view/'.$sp_id);
    }

    public function share_url($sp_id) {
      if ($this->input->post('submit')) {
        $message = $this->input->post('message');
        $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
        $sp_url = base_url().'rate_sp/view/'.$sp_id;
        $messages = "{$user->fullname} Board Approval Special Rates Form No. {$sp_id}
          {$sp_url}";  
        $this->onclick($messages, $sp_id, $this->config->item('page_to_send'));
      }
      redirect('rate_sp/view/'.$sp_id);
    }

    public function unsign($signature_id) {
      $this->load->model('rate_sp_model');
      $this->load->model('users_model');
      $signature_identity = $this->rate_sp_model->get_signature_identity($signature_id);
      $this->rate_sp_model->unsign($signature_id);
      $sp = $this->rate_sp_model->get_sp($signature_identity['sp_id']);
      redirect('/rate_sp/view/'.$signature_identity['sp_id']);
    }

    public function sign($signature_id, $reject = FALSE) {
      $this->load->model('rate_sp_model');
      $signature_identity = $this->rate_sp_model->get_signature_identity($signature_id);
      $signrs = $this->get_signers($signature_identity['sp_id'], $signature_identity['hotel_id']);
      $this->data['sp'] = $this->rate_sp_model->get_sp($signature_identity['sp_id']);
      $sp_url = base_url().'rate_sp/view/'.$signature_identity['sp_id'];
      $message_id = $this->data['sp']['message_id'];
      $id = $signature_identity['sp_id'];
      $message = "Board Approval Special Rates Form No. {$id}:
        {$sp_url}";
      if (array_key_exists($this->data['user_id'], $signrs[$signature_id]['queue'])) {
        if ($signature_identity['role_id'] == 1) {
          $this->onclick1($message);
          $this->deletonclick($message_id);
        }
        if ($reject) {
          $this->rate_sp_model->reject($signature_id, $this->data['user_id']);
          redirect('/rate_sp/sp_stage/'.$this->data['sp']['id']);  
        } else {
          $this->rate_sp_model->sign($signature_id, $this->data['user_id']);
          redirect('/rate_sp/sp_stage/'.$signature_identity['sp_id']);  
        }
      }
      redirect('/rate_sp/view/'.$signature_identity['sp_id']);
    }

    public function comment($sp_id){
      if ($this->input->post('submit')) {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('comment','Comment','trim|required');
        if ($this->form_validation->run() == TRUE) {
          $comment = $this->input->post('comment'); 
          $this->load->model('rate_sp_model');
          $comment_data = array(
            'user_id' => $this->data['user_id'],
            'sp_id' => $sp_id,
            'comment' => $comment
          );
          $this->rate_sp_model->insert_comment($comment_data);
          if ($this->data['role_id'] == 217) {
            $this->chairman_mail($sp_id);
          }
        }
        redirect('/rate_sp/view/'.$sp_id);
      }
    }

    private function chairman_mail($sp_id) {
          $this->load->library('email');
          $this->load->helper('url');
          $sp_url = base_url().'rate_sp/view/'.$sp_id;
          $this->email->from('e-signature@sunrise-resorts.com');
          $this->email->to('abeer@sunrise.eg');
          $this->email->subject("Special Rates Form No. #{$sp_id}");
          $this->email->message("Dear Madam Abber,
            <br/>
            <br/>
            Mr Hossam Commented on Special Rates Form No. #{$sp_id}, Please use the link below:
            <br/>
            <a href='{$sp_url}' target='_blank'>{$sp_url}</a>
            <br/>
          "); 
          $mail_result = $this->email->send();
      }

    public function notify_before($sp_id) {
      $this->load->model('rate_sp_model');
      $this->load->model('users_model');
      $this->data['sp'] = $this->rate_sp_model->get_sp($sp_id);
      $signes = $this->rate_sp_model->sp_approval_sign(1);
      $users = array();
      //die(print_r($signes));
      foreach ($signes as $signe){
        $users = $this->users_model->getby_criteria($signe['role'], $this->data['sp']['hotel_id'], $signe['department']);
        foreach($users as $user){
          if ($signe['user_id'] == $user['id']) {
            if ($user['id'] != 30) {
              $name = $user['fullname'];
              $mail = $user['email'];
              $this->load->library('email');
              $this->load->helper('url');
              $sp_url = base_url().'rate_sp/view/'.$sp_id;
              $this->email->from('e-signature@sunrise-resorts.com');
              $this->email->to($mail);
              $this->email->subject("Special Rates Form NO.#{$sp_id}");
              $this->email->message("Special Rates Form NO.#{$sp_id}:
                <br/>
                Special Rates Form No. #{$sp_id} has been Created, Please use the link below:
                <a href='{$sp_url}' target='_blank'>{$sp_url}</a>
                <br/>
              "); 
              $mail_result = $this->email->send();
            }
          }
        }
      }
      //die(print_r($signe['user_id']. $user['id']));
    }

    public function notify_after($sp_id) {
      $this->load->model('rate_sp_model');
      $this->load->model('users_model');
      $this->data['sp'] = $this->rate_sp_model->get_sp($sp_id);
      $signes = $this->rate_sp_model->sp_approval_sign(2);
      $users = array();
      foreach ($signes as $signe){
        $users = $this->users_model->getby_criteria($signe['role'], $this->data['sp']['hotel_id'], $signe['department']);
        foreach($users as $user){
          if ($user['id'] != 30) {
            $name = $user['fullname'];
            $mail = $user['email'];
            $this->load->library('email');
            $this->load->helper('url');
            $sp_url = base_url().'rate_sp/view/'.$sp_id;
            $this->email->from('e-signature@sunrise-resorts.com');
            $this->email->to($mail);
            $this->email->subject("Special Rates Form NO.#{$sp_id}");
            $this->email->message("Special Rates Form NO.#{$sp_id}:
              <br/>
              Special Rates Form No. #{$sp_id} has been Approved, Please use the link below:
              <a href='{$sp_url}' target='_blank'>{$sp_url}</a>
              <br/>
            "); 
            $mail_result = $this->email->send();
          }
        }
      }
      //die(print_r($mail_result));
    }

    function onclick($message, $id, $channelss){
        include(APPPATH . 'third_party/RocketChat/autoload.php');
        $client = new RocketChat\Client($this->config->item('send_url'));
        $token = $client->api('user')->login($this->config->item('user_access'),$this->config->item('pass_access'));
        $client->setToken($token);
        $channel_result = $client->api('channel')->sendMessage($channelss,$message);
        $this->load->model('rate_sp_model');
        $this->rate_sp_model->update_message_id($id, $channel_result);
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

  }

?>