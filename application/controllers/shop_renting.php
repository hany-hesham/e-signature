<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  class shop_renting extends CI_Controller {

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
        $this->load->model('shop_renting_model');
        $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
        $hotels = array();
        foreach ($user_hotels as $hotel) {
          $hotels[] = $hotel['id'];
        }  
        $this->data['shops'] = $this->shop_renting_model->view($hotels, $states);
        foreach ($this->data['shops'] as $key => $shop) {
          $this->data['shops'][$key]['approvals'] = $this->shop_renting_model->get_by_verbals($this->data['shops'][$key]['id']);
        } 
        if ($this->input->post('submit')) {
          $this->data['var'] = $this->input->post('states_id');
        }
        $this->data['hotels'] = $user_hotels;
        $this->data['state'] = $state;
        $this->data['states'] = $this->shop_renting_model->get_states();
        $this->load->view('shop_renting_index', $this->data);
      }
    }

    public function submit() {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        if ($this->input->post('submit')) {
          $this->load->library('form_validation');
          $this->load->library('email');
          $this->load->model('shop_renting_model');
          $this->load->model('users_model'); 
          $this->form_validation->set_rules('hotel_id','Hotel Name','trim|required');
          $this->form_validation->set_rules('title','Title','trim|required');
          $this->form_validation->set_rules('recommendation','Recommendation','trim|required');
          $this->form_validation->set_rules('reason','Reason','trim|required');
          $assumed_id = $this->input->post('assumed_id');              
          if ($this->form_validation->run() == TRUE) {
            $data = array(
              'user_id' => $this->data['user_id'],
              'ip' => $this->input->ip_address(),
              'hotel_id' => $this->input->post('hotel_id'),
              'title' => $this->input->post('title'),
              'date' => $this->input->post('date'),
              'recommendation' => $this->input->post('recommendation'),
              'reason' => $this->input->post('reason')
            );
            $shop_id = $this->shop_renting_model->create_shop($data);
            if ($shop_id) {
              $this->shop_renting_model->update_files($assumed_id,$shop_id);
            } else {
              die("ERROR");
            }
            $choosen = array();
            foreach ($this->input->post('items') as $Key => $item) {
              $item['shop_id'] = $shop_id;  
              $item['user_id'] = $this->data['user_id'];  
              $item['ip'] = $this->input->ip_address();  
              $file_name = $this->do_upload("items-".$Key."-design");
              $file_name1 = $this->do_upload("items-".$Key."-offer");
              $file_name2 = $this->do_upload("items-".$Key."-cv");
              $file_name3 = $this->do_upload("items-".$Key."-contract");
              $item['design'] = $file_name;  
              $item['offer'] = $file_name1;  
              $item['cv'] = $file_name2;  
              $item['contract'] = $file_name3;  
              $item_id = $this->shop_renting_model->create_offer($item);
              $choose[] =  $item_id;
              if (!$item_id) {
                die("ERROR");
              }
            }
            $x = $this->input->post('choosen_id');
            $this->shop_renting_model->update_choose($shop_id,$choose[$x]);
            $signatures = $this->shop_renting_model->shop_sign();
            $do_sign = $this->shop_renting_model->shop_do_sign($shop_id);
            if ($do_sign == 0) {
              foreach ($signatures as $shop_signature) {
                $this->shop_renting_model->add_signature($shop_id, $shop_signature['role'], $shop_signature['department'], $shop_signature['rank']);
              }
            }
             $ip = $this->input->ip_address();
              $data = array(
              'user_ip' => $ip,
              'data' => $data,
              'items'=> $this->input->post('items')
              );
            $this->new_log($this->data['user_id'], "Submit", "shop_renting", $shop_id, json_encode($data, TRUE), "New Shop Renting Prior Approval");
            redirect('/shop_renting/shop_stage/'.$shop_id);
          }
        }
        try {
          $this->load->helper('form');
          $this->load->model('hotels_model');
          $this->load->model('shop_renting_model');
          $this->data['currencies'] = $this->shop_renting_model->get_currency();          
          $this->data['types'] = $this->shop_renting_model->get_type();          
          $this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
          if ($this->input->post('submit')) {
            $this->data['assumed_id'] = "0".mt_rand("1048575","10485751048575");
            $this->data['uploads'] = $this->shop_renting_model->get_by_fille($this->data['assumed_id']);
          } else {
            $this->data['assumed_id'] = "0".mt_rand("1048575","10485751048575");
            $this->data['uploads'] = array();
          }
          $this->load->view('shop_renting_add_new',$this->data);
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
      }
    }

    public function upload($shop_id) {
      $file_name = $this->do_upload("upload");
      if (!$file_name) {
        die(json_encode($this->data['error']));
      } else {
        $this->load->model("shop_renting_model");
        $this->shop_renting_model->add_fille($shop_id, $file_name, $this->data['user_id']);
        die("{}");
      }
    }

    public function remove($shop_id, $id) {
      $file_name = $_POST['key'];
      if (!$id) {
        die(json_encode($this->data['error']));
      } else {
        $this->load->model("shop_renting_model");
        $this->shop_renting_model->remove_fille($id);
        die("{}");
      }
    }

    private function do_upload($field) {
      $config['upload_path'] = 'assets/uploads/files/';
      $config['allowed_types'] = '*';
      $this->load->library('upload', $config);
      if ( !$this->upload->do_upload($field)) {
        $this->data['error'] = array('error' => $this->upload->display_errors());
        return FALSE;
      } else {
        $file = $this->upload->data();
        return $file['file_name'];
      }
    }

    public function shop_stage($shop_id) {
      $this->load->model('shop_renting_model');
      $this->data['shop'] = $this->shop_renting_model->get_shop($shop_id);
      if ($this->data['shop']['state_id'] == 0) {
        $this->shop_renting_model->update_state($shop_id, 1);
        redirect('/shop_renting/shop_stage/'.$shop_id);
      }elseif ($this->data['shop']['state_id'] == 3){
        $user = $this->users_model->get_user_by_id($this->data['shop']['user_id'], TRUE);
        $this->reject_mail($user->fullname, $user->email, $shop_id);
      }elseif ($this->data['shop']['state_id'] != 2){
        $queue = $this->notify_signers($shop_id, $this->data['shop']['hotel_id']);
        if (!$queue) {
          $this->shop_renting_model->update_state($shop_id, 2);
          //$user = $this->users_model->get_user_by_id($this->data['shop']['user_id'], TRUE);
          //$this->approvel_mail($user->fullname, $user->email, $shop_id);
          $this->notify_after($shop_id);
          redirect('/shop_renting/shop_stage/'.$shop_id);
        }
      }elseif ($this->data['shop']['changes'] == 1) {
        $queue = $this->notify_signers($shop_id, $this->data['shop']['hotel_id']);
      }elseif ($this->data['shop']['state_id'] == 2) {
        $queue = $this->notify_signers($shop_id, $this->data['shop']['hotel_id']);
        if (!$queue) {
          $this->notify_after($shop_id);
        }
      }
      redirect('/shop_renting/view/'.$shop_id);
    }

    private function reject_mail($name, $email, $shop_id) {
      $this->load->library('email');
      $this->load->helper('url');
      $shop_url = base_url().'shop_renting/view/'.$shop_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($email);
      $this->email->subject("Shop Renting Prior Approval Form No. #{$shop_id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
        Shop Renting Prior Approval Form No. #{$shop_id} has been rejected, Please use the link below:
        <br/>
        <a href='{$shop_url}' target='_blank'>{$shop_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
    }

    private function notify_signers($shop_id, $hotel_id) {
      $this->load->model('shop_renting_model');
      $this->data['shop'] = $this->shop_renting_model->get_shop($shop_id);
      $shop_url = base_url().'shop_renting/view/'.$shop_id;
      $message = "Shop Renting Prior Approval Form No. {$shop_id}:
        {$shop_url}";
      $signers = $this->get_signers($shop_id, $hotel_id);
      $notified = FALSE;
      if ($this->data['shop']['changes'] == 1) {
        $signers = $this->get_change_signers($shop_id, $hotel_id);
      }else{
        $signers = $this->get_signers($shop_id, $hotel_id);
      }
      foreach ($signers as $signer) {
        if (isset($signer['queue'])) {
          $notified = TRUE;
          foreach ($signer['queue'] as $uid => $user) {
            $this->onclick($message, $shop_id, $user['channel']);
            $this->signatures_mail($signer['role'], $signer['department'], $user['name'], $user['mail'], $shop_id);
          }
          break;
        }
      }
      return $notified;
    }

    private function get_change_signers($shop_id, $hotel_id) {
      $this->load->model('shop_renting_model');
      $signatures = $this->shop_renting_model->get_change_by_verbal($shop_id);
      return $this->roll_signers($signatures, $hotel_id, $shop_id);
    }

    private function get_signers($shop_id, $hotel_id) {
      $this->load->model('shop_renting_model');
      $signatures = $this->shop_renting_model->get_by_verbal($shop_id);
      return $this->roll_signers($signatures, $hotel_id, $shop_id);
    }

    private function roll_signers($signatures, $hotel_id, $shop_id) {
      $signers = array();
      $this->load->model('users_model');
      $this->load->model('shop_renting_model');
      $shop = $this->shop_renting_model->get_shop($shop_id);
      foreach ($signatures as $signature) {
        $signers[$signature['id']] = array();
        $signers[$signature['id']]['role'] = $signature['role'];
        $signers[$signature['id']]['role_id'] = $signature['role_id'];
        $signers[$signature['id']]['department'] = $signature['department'];
        $signers[$signature['id']]['department_id'] = $signature['department_id'];
        if ($signature['user_id']) {
          if ($signature['rank'] == 1){
            $this->shop_renting_model->update_state($shop_id, 4);
          }elseif ($signature['rank'] == 2){
            $this->shop_renting_model->update_state($shop_id, 5);
          }elseif ($signature['rank'] == 3){
            $this->shop_renting_model->update_state($shop_id, 6);
          }elseif ($signature['rank'] == 4){
            $this->shop_renting_model->update_state($shop_id, 7);
          }elseif ($signature['rank'] == 5){
            $this->shop_renting_model->update_state($shop_id, 2);
          }elseif ($signature['rank'] == 6){
            $this->shop_renting_model->update_final_state($shop_id, 9);
          }elseif ($signature['rank'] == 7){
            $this->shop_renting_model->update_final_state($shop_id, 10);
          }
          $signers[$signature['id']]['sign'] = array();
          $signers[$signature['id']]['sign']['id'] = $signature['user_id'];
          if ($signature['reject'] == 1) {
            $signers[$signature['id']]['sign']['reject'] = "reject";
            $this->shop_renting_model->update_state($shop_id, 3);
          } 
          $user = $this->users_model->get_user_by_id($signature['user_id'], TRUE);
          $signers[$signature['id']]['sign']['name'] = $user->fullname;
          $signers[$signature['id']]['sign']['mail'] = $user->email;
          $signers[$signature['id']]['sign']['channel'] = $user->channel;
          $signers[$signature['id']]['sign']['sign'] = $user->signature;
          $signers[$signature['id']]['sign']['timestamp'] = $signature['timestamp'];
        } else {
            $signers[$signature['id']]['queue'] = array();
            if ($signature['rank'] == 5) {
              $users = array();
              $users[0] = $this->users_model->getby_criteria(1, $hotel_id, $signature['department_id']);
              $users[1] = $this->users_model->getby_criteria(2, $hotel_id, $signature['department_id']);
              $users[2] = $this->users_model->getby_criteria(83, $hotel_id, $signature['department_id']);
              foreach ($users as $user) {
                  foreach ($user as $use) {
                    $signers[$signature['id']]['queue'][$use['id']] = array();
                    $signers[$signature['id']]['queue'][$use['id']]['name'] = $use['fullname'];
                    $signers[$signature['id']]['queue'][$use['id']]['mail'] = $use['email'];
                    $signers[$signature['id']]['queue'][$use['id']]['channel'] = $use['channel'];
                  }
              }
            }
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
              } else {
            $users = $this->users_model->getby_criteria($signature['role_id'], $hotel_id, $signature['department_id']);
              foreach ($users as $use) {
                $signers[$signature['id']]['queue'][$use['id']] = array();
                $signers[$signature['id']]['queue'][$use['id']]['name'] = $use['fullname'];
                $signers[$signature['id']]['queue'][$use['id']]['mail'] = $use['email'];
                $signers[$signature['id']]['queue'][$use['id']]['channel'] = $use['channel'];
              }
          }
        }
      }
        return $signers;
    }
    private function signatures_mail($role, $department, $name, $mail, $shop_id) {
      $this->load->library('email');
      $this->load->helper('url');
      $shop_url = base_url().'shop_renting/view/'.$shop_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($mail);
      $this->email->subject("Shop Renting Prior Approval Form No. #{$shop_id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
        Shop Renting Prior Approval Form No. #{$shop_id} requires your signature, Please use the link below:
        <br/>
        <a href='{$shop_url}' target='_blank'>{$shop_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
    }

    private function approvel_mail($name, $email, $shop_id) {
      $this->load->library('email');
      $this->load->helper('url');
      $shop_url = base_url().'shop_renting/view/'.$shop_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($email);
      $this->email->subject("Shop Renting Prior Approval Form No. #{$shop_id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
        Shop Renting Prior Approval Form No. #{$shop_id} has been approved, Please use the link below:
        <br/>
        <a href='{$shop_url}' target='_blank'>{$shop_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
    }

    public function notify_after($shop_id) {
      $this->load->model('shop_renting_model');
      $this->load->model('users_model');
      $this->data['shop'] = $this->shop_renting_model->get_shop($shop_id);
      $credits = $this->users_model->getby_criteria(57, $this->data['shop']['hotel_id']);
      $laws = $this->users_model->getby_criteria(59, $this->data['shop']['hotel_id']);
      $signes = $this->shop_renting_model->get_by_verbal($shop_id);
      $signature =array();
      $i =0;
      foreach ($signes as $signe){
        $signature[$i] = $signe['user_id'];
        $i++;
      }
      $users = $this->users_model->get_users_by_id($signature, TRUE);
      foreach ($credits as $credit){
        array_push($users, $credit);
      }
      foreach ($laws as $law){
        array_push($users, $law);
      }
      foreach($users as $user){
        if ($user['id'] != 30) {
          $name = $user['fullname'];
          $mail = $user['email'];
          $this->load->library('email');
          $this->load->helper('url');
          $shop_url = base_url().'shop_renting/view/'.$shop_id;
          $this->email->from('e-signature@sunrise-resorts.com');
          $this->email->to($mail);
          $this->email->subject("Shop Renting Prior Approval Form NO.#{$shop_id}");
          $this->email->message("Dear {$name},
            <br/>
            Shop Renting Prior Approval Form No. #{$shop_id} has been Approved, Please use the link below:
            <a href='{$shop_url}' target='_blank'>{$shop_url}</a>
            <br/>
          "); 
          $mail_result = $this->email->send();
        }
      }
    }

    public function view($shop_id) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{      
        $this->load->model('shop_renting_model');
        $this->load->model('hotels_model');   
        $this->data['shop'] = $this->shop_renting_model->get_shop($shop_id);
        $this->data['shop_adjust'] = $this->shop_renting_model->get_shop_adjust($shop_id);
        $this->data['offers'] = $this->shop_renting_model->get_all_offers($shop_id);
        $this->data['uploads'] = $this->shop_renting_model->get_by_fille($shop_id);
        $this->data['comments'] = $this->shop_renting_model->get_comment($shop_id);
         $this->data['log'] = $this->shop_renting_model->get_log($shop_id);
        $this->data['signature_path'] = '/assets/uploads/signatures/';
        $this->data['signers'] = $this->get_signers($this->data['shop']['id'], $this->data['shop']['hotel_id']);
        $this->data['change_signers'] = $this->get_change_signers($this->data['shop']['id'], $this->data['shop']['hotel_id']);
        $credit = FALSE;
        $change = FALSE;
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
          if ( $this->data['shop']['user_id'] == $this->data['user_id'] &&  $this->data['shop']['state_id'] != 2) {
            $editor = TRUE;
          }
        }
        if (isset($this->data['role_id'])) {
          if ( $this->data['role_id'] == 4 &&  $this->data['shop']['state_id'] != 2) {
            $editor = TRUE;
          }
        }
        if (isset($this->data['role_id'])) {
          if ($this->data['role_id'] == 57) {
            if ( $this->data['shop']['changes'] == 0 &&  $this->data['shop']['state_id'] == 2) {
              $change = TRUE;
            }
          }
        }
        if (isset($this->data['role_id'])) {
          if ($this->data['shop']['state_id'] == 2) {
            if ($this->data['role_id'] == 59 || $this->data['role_id'] == 57) {
              $credit = TRUE;
            }
          }
        }
        $this->data['unsign_enable'] = (($unsign_enable) || $this->data['is_admin'])? TRUE : FALSE;
        $this->data['is_editor'] = ($editor || $this->data['is_admin'])? TRUE : FALSE;
        $this->data['is_changes'] = ($change || $this->data['is_admin'])? TRUE : FALSE;
        $this->data['is_credit'] = ($credit || $this->data['is_admin'])? TRUE : FALSE;
        $this->load->view('shop_renting_view', $this->data);
      }
    }

    public function edit($shop_id) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        if ($this->input->post('submit')) {
          $this->load->library('form_validation');
          $this->load->library('email');
          $this->form_validation->set_rules('hotel_id','Hotel Name','trim|required');
          $this->form_validation->set_rules('title','Title','trim|required');
          $this->form_validation->set_rules('recommendation','Recommendation','trim|required');
          $this->form_validation->set_rules('reason','Reason','trim|required');
          if ($this->form_validation->run() == TRUE) {
            $this->load->model('shop_renting_model');
            $this->load->model('users_model');  
            $this->data['shop'] = $this->shop_renting_model->get_shop($shop_id);
            if ($this->data['shop']['changes'] == 1) {
              $data = array(
                'hotel_id' => $this->input->post('hotel_id'),
                'title' => $this->input->post('title'),
                'date' => $this->input->post('date'),
                'recommendation_change' => $this->input->post('recommendation'),
                'reason_change' => $this->input->post('reason'),
                'change_choosen_id' => $this->input->post('choosen_id')
              );
            }else{
              $data = array(
                'hotel_id' => $this->input->post('hotel_id'),
                'title' => $this->input->post('title'),
                'date' => $this->input->post('date'),
                'recommendation' => $this->input->post('recommendation'),
                'reason' => $this->input->post('reason'),
                'choosen_id' => $this->input->post('choosen_id')
              );
            }
            
            $this->shop_renting_model->update_shop($shop_id, $data);
            foreach ($this->input->post('items') as $Key => $item) {
              $item['shop_id'] = $shop_id;  
              $item['user_id'] = $this->data['user_id'];  
              $item['ip'] = $this->input->ip_address();                
              $file_name = $this->do_upload("items-".$Key."-design");
              $file_name1 = $this->do_upload("items-".$Key."-offer");
              $file_name2 = $this->do_upload("items-".$Key."-cv");
              $file_name3 = $this->do_upload("items-".$Key."-contract");
              if ($file_name) {
                $item['design'] = $file_name;  
              }
              if ($file_name1) {
                $item['offer'] = $file_name1;  
              }
              if ($file_name2) {
                $item['cv'] = $file_name2;  
              }  
              if ($file_name3) {
                $item['contract'] = $file_name3;  
              } 
              $this->shop_renting_model->update_offer($item['id'], $shop_id, $item);
            }
             $ip = $this->input->ip_address();
              $data = array(
              'user_ip' => $ip,
              'data' =>$data,
              'item' =>$this->input->post('items')
              );
            $this->new_log($this->data['user_id'], "Edit", "shop_renting", $shop_id, json_encode($data, TRUE), "Edit has been made");
              $this->notification($shop_id, $this->data['user_id']);
            redirect('/shop_renting/view/'.$shop_id);
          }   
        }
        try {
          $this->load->helper('form');
          $this->load->model('shop_renting_model');
          $this->load->model('hotels_model');
          $this->data['shop'] = $this->shop_renting_model->get_shop($shop_id);
          $this->data['offers'] = $this->shop_renting_model->get_offers($shop_id , $this->data['shop']['changes']);
          $this->data['uploads'] = $this->shop_renting_model->get_by_fille($shop_id);
          $this->data['currencies'] = $this->shop_renting_model->get_currency();          
          $this->data['types'] = $this->shop_renting_model->get_type();          
          $this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
          $this->load->view('shop_renting_edit',$this->data);
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
      }
    }

    public function change($shop_id) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        if ($this->input->post('submit')) {
          $this->load->library('form_validation');
          $this->load->library('email');
          $this->form_validation->set_rules('hotel_id','Hotel Name','trim|required');
          $this->form_validation->set_rules('title','Title','trim|required');
          $this->form_validation->set_rules('recommendation','Recommendation','trim|required');
          $this->form_validation->set_rules('reason','Reason','trim|required');
          if ($this->form_validation->run() == TRUE) {
            $this->load->model('shop_renting_model');
            $this->load->model('users_model');  
            $data = array(
              'hotel_id' => $this->input->post('hotel_id'),
              'title' => $this->input->post('title'),
              'date' => $this->input->post('date'),
              'recommendation_change' => $this->input->post('recommendation'),
              'reason_change' => $this->input->post('reason'),
              'changes' => 1
            );
            $this->shop_renting_model->update_shop($shop_id, $data);
            $this->shop_renting_model->update_state($shop_id, 1);
            foreach ($this->input->post('items') as $Key => $item) {
              $item['shop_id'] = $shop_id;  
              $item['user_id'] = $this->data['user_id'];  
              $item['changed'] = 1;  
              $item['ip'] = $this->input->ip_address();                
              $file_name = $this->do_upload("items-".$Key."-design");
              $file_name1 = $this->do_upload("items-".$Key."-offer");
              $file_name2 = $this->do_upload("items-".$Key."-cv");
              $file_name3 = $this->do_upload("items-".$Key."-contract");
              $item['design'] = $file_name;  
              $item['offer'] = $file_name1;  
              $item['cv'] = $file_name2;  
              $item['contract'] = $file_name3;  
              $item_id = $this->shop_renting_model->create_offer($item);
              $choose[] =  $item_id;
              if (!$item_id) {
                die("ERROR");
              }
            }
            $x = $this->input->post('choosen_id');
            $this->shop_renting_model->update_change_choose($shop_id,$choose[$x]);
            $signatures = $this->shop_renting_model->shop_sign();
            $do_sign = $this->shop_renting_model->shop_change_do_sign($shop_id);
            if ($do_sign == 0) {
              foreach ($signatures as $shop_signature) {
                $this->shop_renting_model->add_change_signature($shop_id, $shop_signature['role'], $shop_signature['department'], $shop_signature['rank']);
              }
            }
             $ip = $this->input->ip_address();
              $data = array(
              'user_ip' => $ip,
              'data' => $data,
              'items'=> $this->input->post('items')
              );
            $this->new_log($this->data['user_id'], "Change", "shop_renting", $shop_id, json_encode($data, TRUE), "change has been made");
            $this->notification($shop_id, $this->data['user_id']);
            redirect('/shop_renting/view/'.$shop_id);
          }   
        }
        try {
          $this->load->helper('form');
          $this->load->model('shop_renting_model');
          $this->load->model('hotels_model');
          $this->data['shop'] = $this->shop_renting_model->get_shop($shop_id);
          $this->data['offers'] = $this->shop_renting_model->get_change_offers($shop_id , $this->data['shop']['changes']);
          $this->data['uploads'] = $this->shop_renting_model->get_by_fille($shop_id);
          $this->data['currencies'] = $this->shop_renting_model->get_currency();          
          $this->data['types'] = $this->shop_renting_model->get_type();          
          $this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
          $this->load->view('shop_renting_change',$this->data);
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
      }
    }

    public function edit_upload($shop_id) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{          
        if ($this->input->post('submit')) {
          $this->load->library('form_validation');
          $this->load->library('email');
          if ($this->form_validation->run() == FALSE) {
            foreach ($uploads as $upload) {
              
            }
              $ip = $this->input->ip_address();
              $data = array(
              'file' => $upload['name'],
              'user_ip' => $ip
              );
           $this->new_log($this->data['user_id'], "File", "shop_renting", $shop_id, json_encode($data, TRUE), "New File Has Been Uploaded");
           $this->notification($shop_id, $this->data['user_id']);
            redirect('/shop_renting/view/'.$shop_id);
          }   
        }
        try {
          $this->load->helper('form');
          $this->load->model('shop_renting_model');
          $this->data['shop'] = $this->shop_renting_model->get_shop($shop_id);
          $this->data['uploads'] = $this->shop_renting_model->get_by_fille($shop_id);
          $this->load->view('shop_renting_edit_upload',$this->data);
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
      }
    }

    public function mail_me($shop_id) {
      $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
      $this->load->library('email');
      $this->load->helper('url');
      $shop_url = base_url().'shop_renting/view/'.$shop_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($user->email);
      $this->email->subject("Shop Renting Prior Approval Form No. #{$shop_id}");
      $this->email->message("Shop Renting Prior Approval Form NO.#{$shop_id}:
        <br/>
        Please use the link below to view The Shop Renting Prior Approval Form:
        <a href='{$shop_url}' target='_blank'>{$shop_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
      redirect('shop_renting/view/'.$shop_id);
    }

    public function mail($shop_id) {
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
          $shop_url = base_url().'shop_renting/view/'.$shop_id;
          $this->email->from('e-signature@sunrise-resorts.com');
          $this->email->to($email);
          $this->email->subject("A message from {$user->fullname}, Shop Renting Prior Approval Form No. #{$shop_id}");
          $this->email->message("{$user->fullname} sent you a private message regarding Shop Renting Prior Approval Form No. #{$shop_id}:
            <br/>
            {$message}
            <br />
            <br />
            Please use the link below to view the Shop Renting Prior Approval Form:
            <a href='{$shop_url}' target='_blank'>{$shop_url}</a>
            <br/>
          "); 
          $mail_result = $this->email->send();
        }
      }
      $ip = $this->input->ip_address();
              $data = array(
              'user_ip' => $ip
              );
       $this->new_log($this->data['user_id'], "Mail", "shop_renting", $shop_id, json_encode($data, TRUE), "mail has been sent");
      redirect('shop_renting/view/'.$shop_id);
    }

    public function share_url($shop_id) {
      if ($this->input->post('submit')) {
        $message = $this->input->post('message');
        $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
        $shop_url = base_url().'shop_renting/view/'.$shop_id;
        $messages = "{$user->fullname} Shop Renting Prior Approval Form No. {$shop_id}
          {$shop_url}";  
        $this->onclick($messages, $shop_id, $this->config->item('page_to_send'));
      }
      redirect('shop_renting/view/'.$shop_id);
    }

    public function unsign($signature_id) {
      $this->load->model('shop_renting_model');
      $this->load->model('users_model');
      $signature_identity = $this->shop_renting_model->get_signature_identity($signature_id);
      $this->shop_renting_model->unsign($signature_id);
       $sign_id = $this->shop_renting_model->get_signature_id($signature_id);
      $ip = $this->input->ip_address();
      $data = array(
        'user' => $sign_id['user_id'],
        'role' => $sign_id['role_id'],
        'department' => $sign_id['department_id'],
        'ip' => $ip
      );
      $this->new_log($this->data['user_id'], "Signature", "Shop renting", $sign_id['shop_id'], json_encode($data, TRUE), "The Form Has Been Unsigned");
      $this->shop_renting_model->update_state($signature_identity['shop_id'], 1);
      redirect('/shop_renting/shop_stage/'.$signature_identity['shop_id']);  
    }

    public function unsign_change($signature_id) {
      $this->load->model('shop_renting_model');
      $this->load->model('users_model');
      $signature_identity = $this->shop_renting_model->get_change_signature_identity($signature_id);
      $this->shop_renting_model->unsign_change($signature_id);
      $this->shop_renting_model->update_state($signature_identity['shop_id'], 1);
      redirect('/shop_renting/shop_stage/'.$signature_identity['shop_id']);  
    }

    public function sign($signature_id, $reject = FALSE) {
      $this->load->model('shop_renting_model');
      $signature_identity = $this->shop_renting_model->get_signature_identity($signature_id);
      $this->data['shop'] = $this->shop_renting_model->get_shop($signature_identity['shop_id']);
      $shop_url = base_url().'shop_renting/view/'.$signature_identity['shop_id'];
      $message_id = $this->data['shop']['message_id'];
      $id = $signature_identity['shop_id'];
      $message = "Shop Renting Prior Approval Form No. {$id}:
          {$shop_url}";
      $signrs = $this->get_signers($signature_identity['shop_id'], $signature_identity['hotel_id']);
      if (array_key_exists($this->data['user_id'], $signrs[$signature_id]['queue'])) {
        if ($signature_identity['role_id'] == 1) {
          $this->onclick1($message);
          $this->deletonclick($message_id);
        }
        if ($reject) {
          $this->shop_renting_model->reject($signature_id, $this->data['user_id']);
          $sign_id = $this->shop_renting_model->get_signature_id($signature_id);
          $ip = $this->input->ip_address();
          $data = array(
            'user' => $sign_id['user_id'],
            'role' => $sign_id['role_id'],
            'department' => $sign_id['department_id'],
            'ip' => $ip
          );
          $this->new_log($this->data['user_id'], "Signature", "Shop renting", $sign_id['shop_id'], json_encode($data, TRUE), "The Form Has Been Rejected");
          redirect('/shop_renting/shop_stage/'.$signature_identity['shop_id']);  
        } else {
          $this->shop_renting_model->sign($signature_id, $this->data['user_id']);
           $sign_id = $this->shop_renting_model->get_signature_id($signature_id);
          $ip = $this->input->ip_address();
          $data = array(
            'user' => $sign_id['user_id'],
            'role' => $sign_id['role_id'],
            'department' => $sign_id['department_id'],
            'ip' => $ip
          );
          $this->new_log($this->data['user_id'], "Signature", "Shop renting", $sign_id['shop_id'], json_encode($data, TRUE), "The Form Has Been Signed");
          //die(print_r($signature_id));
          redirect('/shop_renting/shop_stage/'.$signature_identity['shop_id']);  
        }
      }
      redirect('/shop_renting/view/'.$signature_identity['shop_id']);
    }


    public function change_sign($signatur_id, $reject = FALSE) {
      $this->load->model('shop_renting_model');
      $signature_identity_change = $this->shop_renting_model->get_change_signature_identity($signatur_id);
      $this->data['shop'] = $this->shop_renting_model->get_shop($signature_identity_change['shop_id']);
      $shop_url = base_url().'shop_renting/view/'.$signature_identity_change['shop_id'];
      $message_id = $this->data['shop']['message_id'];
      $id = $signature_identity_change['shop_id'];
      $message = "Shop Renting Prior Approval Form No. {$id}:
          {$shop_url}";
      $signrs_change = $this->get_change_signers($signature_identity_change['shop_id'], $signature_identity_change['hotel_id']);
      //die(print_r($signature_identity_change));
      if (array_key_exists($this->data['user_id'], $signrs_change[$signatur_id]['queue'])) {
        if ($signature_identity_change['role_id'] == 1) {
          $this->onclick1($message);
          $this->deletonclick($message_id);
        }
        if ($reject) {
          $this->shop_renting_model->reject_change($signatur_id, $this->data['user_id']);
          redirect('/shop_renting/shop_stage/'.$signature_identity_change['shop_id']);
        } else {
          $this->shop_renting_model->sign_change($signatur_id, $this->data['user_id']);
          //die(print_r($signature_id));
          redirect('/shop_renting/shop_stage/'.$signature_identity_change['shop_id']);  
        }
      }
      redirect('/shop_renting/view/'.$signature_identity_change['shop_id']);
    }

    public function credit_demo($shop_id) {
      $this->load->model('shop_renting_model');
      if ($this->input->post('submit')) {
        $form_data = array(
          'user_demo_id' => $this->data['user_id']
        );
        $file_name = $this->do_upload('credit_demo');
        $form_data['credit_demo'] = $file_name;
        $this->shop_renting_model->update_shop($shop_id, $form_data);
      }
        $ip = $this->input->ip_address();
              $data = array(
              'file' => $file_name, 
              'user_ip' => $ip
              );
       $this->new_log($this->data['user_id'], "File", "shop_renting", $shop_id, json_encode($data, TRUE), "Contract Demo has been uploaded");
       $this->notification($shop_id, $this->data['user_id']);
      redirect('/shop_renting/view/'.$shop_id);
    }

    public function lawyer_final($shop_id) {
      $this->load->model('shop_renting_model');
      if ($this->input->post('submit')) {
        $form_data = array(
          'user_lawyer_id' => $this->data['user_id']
        );
        $file_name = $this->do_upload('lawyer_final');
        $form_data['lawyer_final'] = $file_name;
        $this->shop_renting_model->update_shop($shop_id, $form_data);
      }
       $ip = $this->input->ip_address();
              $data = array(
              'file' => $file_name, 
              'user_ip' => $ip
              );
       $this->new_log($this->data['user_id'], "File", "shop_renting", $shop_id, json_encode($data, TRUE), "Final Contract has been uploaded");
       $this->notification($shop_id, $this->data['user_id']);
      redirect('/shop_renting/shop_stage/'.$shop_id);
    }

    public function credit_final($shop_id) {
      $this->load->model('shop_renting_model');
      if ($this->input->post('submit')) {
        $form_data = array(
          'user_credit_id' => $this->data['user_id'],
          'state_final' => 8
        );
        $file_name = $this->do_upload('credit_final');
        $form_data['credit_final'] = $file_name;
        $this->shop_renting_model->update_shop($shop_id, $form_data);
        $signatures = $this->shop_renting_model->shop_final_sign();
        $do_sign = $this->shop_renting_model->shop_do_sign($shop_id);
        if ($do_sign == 5) {
          foreach ($signatures as $shop_signature) {
            $this->shop_renting_model->add_signature($shop_id, $shop_signature['role'], $shop_signature['department'], $shop_signature['rank']);
          }
        }
      }
       $ip = $this->input->ip_address();
              $data = array(
              'file' => $file_name, 
              'user_ip' => $ip
              );
       $this->new_log($this->data['user_id'], "File", "shop_renting", $shop_id, json_encode($data, TRUE), "Final Signed Contract has been uploaded");
       $this->notification($shop_id, $this->data['user_id']);
      redirect('/shop_renting/view/'.$shop_id);
    }

    public function credit_demo_change($shop_id) {
      $this->load->model('shop_renting_model');
      if ($this->input->post('submit')) {
        $form_data = array(
          'user_demo_change_id' => $this->data['user_id']
        );
        $file_name = $this->do_upload('credit_demo_change');
        $form_data['credit_demo_change'] = $file_name;
        $this->shop_renting_model->update_shop($shop_id, $form_data);
      }
        $ip = $this->input->ip_address();
              $data = array(
              'file' => $file_name, 
              'user_ip' => $ip
              );
       $this->new_log($this->data['user_id'], "File", "shop_renting", $shop_id, json_encode($data, TRUE), "Change of Contract Demo File has been uploaded");
       $this->notification($shop_id, $this->data['user_id']);
      redirect('/shop_renting/view/'.$shop_id);
    }

    public function lawyer_final_change($shop_id) {
      $this->load->model('shop_renting_model');
      if ($this->input->post('submit')) {
        $form_data = array(
          'user_lawyer_change_id' => $this->data['user_id']
        );
        $file_name = $this->do_upload('lawyer_final_change');
        $form_data['lawyer_final_change'] = $file_name;
        $this->shop_renting_model->update_shop($shop_id, $form_data);
      }
       $ip = $this->input->ip_address();
              $data = array(
              'file' => $file_name, 
              'user_ip' => $ip
              );
       $this->new_log($this->data['user_id'], "File", "shop_renting", $shop_id, json_encode($data, TRUE), "Change of Final Contract File has been uploaded");
      $this->notification($shop_id, $this->data['user_id']);
      redirect('/shop_renting/shop_stage/'.$shop_id);
    }

    public function credit_final_change($shop_id) {
      $this->load->model('shop_renting_model');
      if ($this->input->post('submit')) {
        $form_data = array(
          'user_credit_change_id' => $this->data['user_id'],
          'state_final' => 8
        );
        $file_name = $this->do_upload('credit_final_change');
        $form_data['credit_final_change'] = $file_name;
        $this->shop_renting_model->update_shop($shop_id, $form_data);
        $signatures = $this->shop_renting_model->shop_final_sign();
        $do_sign = $this->shop_renting_model->shop_change_do_sign($shop_id);
        if ($do_sign == 5) {
          foreach ($signatures as $shop_signature) {
              $this->shop_renting_model->add_change_signature($shop_id, $shop_signature['role'], $shop_signature['department'], $shop_signature['rank']);
          }
      }
      }
       $ip = $this->input->ip_address();
              $data = array(
              'file' => $file_name, 
              'user_ip' => $ip
              );
       $this->new_log($this->data['user_id'], "Final", "shop_renting", $shop_id, json_encode($data, TRUE), " Final Contract File has been uploaded");
       $this->notification($shop_id, $this->data['user_id']);
      redirect('/shop_renting/view/'.$shop_id);
    }

    public function comment($shop_id){
      if ($this->input->post('submit')) {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('comment','Comment','trim|required');
        if ($this->form_validation->run() == TRUE) {
          $comment = $this->input->post('comment'); 
          $this->load->model('shop_renting_model');
          $comment_data = array(
            'user_id' => $this->data['user_id'],
            'shop_id' => $shop_id,
            'comment' => $comment
          );
          $this->shop_renting_model->insert_comment($comment_data);
          if ($this->data['role_id'] == 217) {
            $this->chairman_mail($shop_id);
          }
           $ip = $this->input->ip_address();
              $data = array(
              'comment' => $comment,
              'user_ip' => $ip
              );
       $this->new_log($this->data['user_id'], "Comment", "shop_renting", $shop_id, json_encode($data, TRUE), "Comment has been made");
           $this->notify_commet($shop_id, $this->data['user_id']);
        }
        redirect('/shop_renting/view/'.$shop_id);
      }
    }

    private function chairman_mail($shop_id) {
          $this->load->library('email');
          $this->load->helper('url');
          $shop_url = base_url().'shop_renting/view/'.$shop_id;
          $this->email->from('e-signature@sunrise-resorts.com');
          $this->email->to('abeer@sunrise.eg');
          $this->email->subject("Shop Renting Prior Approval Form No. #{$shop_id}");
          $this->email->message("Dear Madam Abber,
            <br/>
            <br/>
            Mr Hossam Commented on Shop Renting Prior Approval Form No. #{$shop_id}, Please use the link below:
            <br/>
            <a href='{$shop_url}' target='_blank'>{$shop_url}</a>
            <br/>
          "); 
          $mail_result = $this->email->send();
      }
      
   public function notify_commet($shop_id, $user_id) {
      $this->load->model('shop_renting_model');
      $this->load->model('users_model');
      $shop = $this->shop_renting_model->get_shop($shop_id);
      $commenter = $this->users_model->get_user_by_id($user_id, TRUE);
      $comment = $commenter->fullname;
      $signes = $this->shop_renting_model->get_by_verbal($shop_id);
      $users = array();
      foreach ($signes as $signe){
        if ($signe['user_id']  && $signe['user_id'] != 30) {
          $user = $this->users_model->get_user_by_id($signe['user_id'], TRUE);
          $name = $user->fullname;
          $mail = $user->email;
          $this->load->library('email');
          $this->load->helper('url');
          $shop_url = base_url().'shop_renting/view/'.$shop_id;
          $this->email->from('e-signature@sunrise-resorts.com');
          $this->email->to($mail);
          $this->email->subject("shop_renting No. #{$shop_id}");
          $this->email->message("Dear {$name},

            <br/>
            <br/>
            {$comment} made a comment on shop_renting NO.#{$shop_id}, Please use the link below:
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
   public function notification($shop_id,$user_id) {
      $this->load->model('shop_renting_model');
      $this->load->model('users_model');
      $shop = $this->shop_renting_model->get_shop($shop_id);
      $editor = $this->users_model->get_user_by_id($user_id, TRUE);
      $comment = $editor->fullname;
      $to_users = $this->shop_renting_model->getby_role($shop_id);
     // die(print_r($user_id));
      $users = array();
      foreach ($to_users as $to_user){
        if ($to_user['id']  && $to_user['id']) {
          $user = $this->users_model->get_user_by_id($to_user['id'], TRUE);
          $name = $user->fullname;
          $mail = $user->email;
          $this->load->library('email');
          $this->load->helper('url');
          $shop_url = base_url().'shop_renting/view/'.$shop_id;
          $this->email->from('e-signature@sunrise-resorts.com');
          $this->email->to($mail);
          $this->email->subject("shop_renting No. #{$shop_id}");
          $this->email->message("Dear {$name},

             <br/>
            <br/>
            {$comment} made edit on shop_renting NO.#{$shop_id}, Please use the link below:
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
public function new_log($user_id, $type, $target, $target_id, $data, $action){
      $this->load->model('shop_renting_model');
      $log_data = array(
        'user_id' => $user_id,
        'type' => $type,
        'target' => $target,
        'target_id' => $target_id,
        'data' => $data,
        'action' => $action
      );
      $this->shop_renting_model->new_log($log_data);
    }   
    function onclick($message, $id, $channelss){
      include(APPPATH . 'third_party/RocketChat/autoload.php');
      $client = new RocketChat\Client($this->config->item('send_url'));
      $token = $client->api('user')->login($this->config->item('user_access'),$this->config->item('pass_access'));
      $client->setToken($token);
      $channel_result = $client->api('channel')->sendMessage($channelss,$message);
      $this->load->model('shop_renting_model');
      $this->shop_renting_model->update_message_id($id, $channel_result);
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