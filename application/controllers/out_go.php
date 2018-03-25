<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  class out_go extends CI_Controller {

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

    public function index() {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        $this->load->model('hotels_model');
        $this->load->model('out_go_model');
        $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
        $hotels = array();
        foreach ($user_hotels as $hotel) {
          $hotels[] = $hotel['id'];
        }  
        $this->data['out_gos'] = $this->out_go_model->view($hotels);
        foreach ($this->data['out_gos'] as $key => $out) {
          $this->data['out_gos'][$key]['approvals'] = $this->out_go_model->get_by_verbals($this->data['out_gos'][$key]['id']);
          foreach ($this->data['out_gos'][$key]['approvals'] as $keys => $out) {
            if ($this->data['out_gos'][$key]['approvals'][$keys]['rank'] == 1) {
              $this->data['out_gos'][$key]['approvals'][$keys]['department_id'] =  $this->data['out_gos'][$key]['department_id'];
              $this->data['out_gos'][$key]['approvals'][$keys]['department'] =  $this->data['out_gos'][$key]['department'];
            }
          }
        } 
        $this->data['hotels'] = $user_hotels;
        $this->load->view('out_index', $this->data);
      }
    }

    public function index_app() {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        $this->load->model('hotels_model');
        $this->load->model('out_go_model');
        $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
        $hotels = array();
        foreach ($user_hotels as $hotel) {
          $hotels[] = $hotel['id'];
        }  
        $this->data['out_gos'] = $this->out_go_model->view_app($hotels);
        foreach ($this->data['out_gos'] as $key => $out) {
          $this->data['out_gos'][$key]['approvals'] = $this->out_go_model->get_by_verbals($this->data['out_gos'][$key]['id']);
          foreach ($this->data['out_gos'][$key]['approvals'] as $keys => $out) {
            if ($this->data['out_gos'][$key]['approvals'][$keys]['rank'] == 1) {
              $this->data['out_gos'][$key]['approvals'][$keys]['department_id'] =  $this->data['out_gos'][$key]['department_id'];
              $this->data['out_gos'][$key]['approvals'][$keys]['department'] =  $this->data['out_gos'][$key]['department'];
            }
          }
        } 
        $this->data['hotels'] = $user_hotels;
        $this->load->view('out_index', $this->data);
      }
    }

    public function index_wat() {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        if ($this->input->post('submit')) {
          $state = $this->input->post('state');
          $this->load->model('hotels_model');
          $this->load->model('out_go_model');
          $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
          $hotels = array();
          foreach ($user_hotels as $hotel) {
            $hotels[] = $hotel['id'];
          }  
          $this->data['out_gos'] = $this->out_go_model->view_wat($hotels, $state);
          foreach ($this->data['out_gos'] as $key => $out) {
            $this->data['out_gos'][$key]['approvals'] = $this->out_go_model->get_by_verbals($this->data['out_gos'][$key]['id']);
            foreach ($this->data['out_gos'][$key]['approvals'] as $keys => $out) {
              if ($this->data['out_gos'][$key]['approvals'][$keys]['rank'] == 1) {
                $this->data['out_gos'][$key]['approvals'][$keys]['department_id'] =  $this->data['out_gos'][$key]['department_id'];
                $this->data['out_gos'][$key]['approvals'][$keys]['department'] =  $this->data['out_gos'][$key]['department'];
              }
            }
          } 
          $this->data['state'] = $state;
          $this->data['hotels'] = $user_hotels;
        }
        $this->load->view('out_index_wat', $this->data);
      }
    }

    public function index_rej() {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        $this->load->model('hotels_model');
        $this->load->model('out_go_model');
        $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
        $hotels = array();
        foreach ($user_hotels as $hotel) {
          $hotels[] = $hotel['id'];
        }  
        $this->data['out_gos'] = $this->out_go_model->view_rej($hotels);
        foreach ($this->data['out_gos'] as $key => $out) {
          $this->data['out_gos'][$key]['approvals'] = $this->out_go_model->get_by_verbals($this->data['out_gos'][$key]['id']);
          foreach ($this->data['out_gos'][$key]['approvals'] as $keys => $out) {
            if ($this->data['out_gos'][$key]['approvals'][$keys]['rank'] == 1) {
              $this->data['out_gos'][$key]['approvals'][$keys]['department_id'] =  $this->data['out_gos'][$key]['department_id'];
              $this->data['out_gos'][$key]['approvals'][$keys]['department'] =  $this->data['out_gos'][$key]['department'];
            }
          }
        } 
        $this->data['hotels'] = $user_hotels;
        $this->load->view('out_index', $this->data);
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
          $this->form_validation->set_rules('date','Date','trim|required');
          $this->form_validation->set_rules('re_date','Date of Return','trim|required');
          $this->form_validation->set_rules('department_id','Department','trim|required');
          $assumed_id = $this->input->post('assumed_id');                        
          if ($this->form_validation->run() == TRUE) {
            $this->load->model('out_go_model');
            $this->load->model('users_model');  
            $data = array(
              'user_id' => $this->data['user_id'],
              'hotel_id' => $this->input->post('hotel_id'),
              'date' => $this->input->post('date'),
              're_date' => $this->input->post('re_date'),
              'address' => $this->input->post('address'),
              'department_id' => $this->input->post('department_id')
            );
            $out_id = $this->out_go_model->create_out_go($data);
            if ($out_id) {
              $this->out_go_model->update_files($assumed_id,$out_id);
            } else {
              die("ERROR");
            }
            foreach ($this->input->post('items') as $Key => $item) {
              $item['out_id'] = $out_id;  
              $file_name = $this->do_upload("items-".$Key."-fille");
              $item['fille'] = $file_name;  
              $item_id = $this->out_go_model->create_item($item);
              if (!$item_id) {
                die("ERROR");
              }
            }
            foreach ($this->input->post('reason') as $reason) {
              $this->out_go_model->add_reason($out_id, $reason);
            }
            $signatures = $this->out_go_model->out_sign();
            $do_sign = $this->out_go_model->out_do_sign($out_id);
            if ($do_sign == 0) {
              foreach ($signatures as $out_signature) {
                $this->out_go_model->add_signature($out_id, $out_signature['role'], $out_signature['department'], $out_signature['rank']);
              }
            }
            redirect('/out_go/out_stage/'.$out_id);
          }
        }
        try {
          $this->load->helper('form');
          $this->load->model('out_go_model');
          $this->load->model('hotels_model');
          $this->data['reasons'] = $this->out_go_model->get_reasons();
          $this->data['departments'] = $this->out_go_model->get_departments();
          $this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
          if ($this->input->post('submit')) {
            $this->data['assumed_id'] = mt_rand("1048575","10485751048575");
            $this->data['uploads'] = $this->out_go_model->get_by_fille($this->data['assumed_id']);
          } else {
            $this->data['assumed_id'] = mt_rand("1048575","10485751048575");
            $this->data['uploads'] = array();
          }
          $this->load->view('out_add_new',$this->data);
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
      }
    }

    public function out_stage($out_id) {
      $this->load->model('out_go_model');
      $this->data['out_go'] = $this->out_go_model->get_out_go($out_id);
      if ($this->data['out_go']['state_id'] == 0) {
        $this->out_go_model->update_state($out_id, 1);
        redirect('/out_go/out_stage/'.$out_id);
      }elseif ($this->data['out_go']['state_id'] == 3){
        $user = $this->users_model->get_user_by_id($this->data['out_go']['user_id'], TRUE);
        $queue = $this->reject_mail($user->fullname, $user->email, $out_id);
      }elseif ($this->data['out_go']['state_id'] != 2){
        $queue = $this->notify_signers($out_id, $this->data['out_go']['hotel_id']);
        if (!$queue) {
          $this->out_go_model->update_state($out_id, 2);
          $user = $this->users_model->get_user_by_id($this->data['out_go']['user_id'], TRUE);
          $queue = $this->approvel_mail($user->fullname, $user->email, $out_id);
          redirect('/out_go/out_stage/'.$out_id);
        }
      }
      redirect('/out_go/view/'.$out_id);
    }

    private function reject_mail($name, $email, $out_id) {
      $this->load->library('email');
      $this->load->helper('url');
      $out_url = base_url().'out_go/view/'.$out_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($email);
      $this->email->subject("Out Going Form No. #{$out_id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
        Out Going Form No. #{$out_id} has been rejected, Please use the link below:
        <br/>
        <a href='{$out_url}' target='_blank'>{$out_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
    }

    private function notify_signers($out_id, $hotel_id) {
      $notified = FALSE;
      $signers = $this->get_signers($out_id, $hotel_id);
      foreach ($signers as $signer) {
        if (isset($signer['queue'])) {
          $notified = TRUE;
          foreach ($signer['queue'] as $uid => $user) {
            $this->signatures_mail($signer['role'], $signer['department'], $user['name'], $user['mail'], $out_id);
          }
          break;
        }
      }
      return $notified;
    }

    private function get_signers($out_id, $hotel_id) {
      $this->load->model('out_go_model');
      $signatures = $this->out_go_model->get_by_verbal($out_id);
      return $this->roll_signers($signatures, $hotel_id, $out_id);
    }

    private function roll_signers($signatures, $hotel_id, $out_id) {
      $signers = array();
      $this->load->model('users_model');
      $this->load->model('out_go_model');
      $out_go = $this->out_go_model->get_out_go($out_id);
      foreach ($signatures as $signature) {
        $signers[$signature['id']] = array();
        $signers[$signature['id']]['role'] = $signature['role'];
        $signers[$signature['id']]['role_id'] = $signature['role_id'];
        if ($signature['rank'] == 1 ) {
          $signers[$signature['id']]['department'] = $out_go['department'];
        }else{
          $signers[$signature['id']]['department'] = $signature['department'];
        }
        $signers[$signature['id']]['department_id'] = $signature['department_id'];
        if ($signature['user_id']) {
          if ($signature['rank'] == 1){
            $this->out_go_model->update_state($out_id, 4);
          }elseif ($signature['rank'] == 2){
            $this->out_go_model->update_state($out_id, 5);
          }elseif ($signature['rank'] == 3){
            $this->out_go_model->update_state($out_id, 6);
          }elseif ($signature['rank'] == 4){
            $this->out_go_model->update_state($out_id, 2);
          }
          $signers[$signature['id']]['sign'] = array();
          $signers[$signature['id']]['sign']['id'] = $signature['user_id'];
          if ($signature['reject'] == 1) {
            $signers[$signature['id']]['sign']['reject'] = "reject";
            $this->out_go_model->update_state($out_id, 3);
          } 
          $user = $this->users_model->get_user_by_id($signature['user_id'], TRUE);
          $signers[$signature['id']]['sign']['name'] = $user->fullname;
          $signers[$signature['id']]['sign']['mail'] = $user->email;
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
          if ($signature['rank'] == 1 ) {
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

    private function signatures_mail($role, $department, $name, $mail, $out_id) {
      $this->load->library('email');
      $this->load->helper('url');
      $out_url = base_url().'out_go/view/'.$out_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($mail);
      $this->email->subject("Out Going Form No. #{$out_id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
        Out Going Form No. #{$out_id} requires your signature, Please use the link below:
        <br/>
        <a href='{$out_url}' target='_blank'>{$out_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
    }

    private function approvel_mail($name, $email, $out_id) {
      $this->load->library('email');
      $this->load->helper('url');
      $out_url = base_url().'out_go/view/'.$out_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($email);
      $this->email->subject("Out Going Form No. #{$out_id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
        Out Going Form No. #{$out_id} has been approved, Please use the link below:
        <br/>
        <a href='{$out_url}' target='_blank'>{$out_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
    }

    public function view($out_id) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{      
        $this->load->model('out_go_model');
        $this->load->model('hotels_model');   
        $this->data['out_go'] = $this->out_go_model->get_out_go($out_id);
        $this->data['items'] = $this->out_go_model->get_items($out_id);
        $this->data['out_go_chdates'] = $this->out_go_model->get_changed_dates($out_id);
        $this->data['reasons'] = $this->out_go_model->get_reason($out_id);
        $this->data['uploads'] = $this->out_go_model->get_by_fille($out_id);
        $this->data['comments'] = $this->out_go_model->get_comment($out_id);
        $this->data['signature_path'] = '/assets/uploads/signatures/';
        $this->data['signers'] = $this->get_signers($this->data['out_go']['id'], $this->data['out_go']['hotel_id']);
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
          if ( $this->data['out_go']['user_id'] == $this->data['user_id'] &&  $this->data['out_go']['state_id'] != 2) {
            $editor = TRUE;
          }
        }
        $this->data['unsign_enable'] = (($unsign_enable) || $this->data['is_admin'])? TRUE : FALSE;
        $this->data['is_editor'] = ($editor || $this->data['is_admin'])? TRUE : FALSE;
        $this->load->view('out_view', $this->data);
      }
    }

    public function upload($out_id) {
      $file_name = $this->do_upload("upload");
      if (!$file_name) {
        die(json_encode($this->data['error']));
      } else {
        $this->load->model("out_go_model");
        $this->out_go_model->add_fille($out_id, $file_name, $this->data['user_id']);
        die("{}");
      }
    }

    public function remove($out_id, $id) {
      $file_name = $_POST['key'];
      if (!$id) {
        die(json_encode($this->data['error']));
      } else {
        $this->load->model("out_go_model");
        $this->out_go_model->remove_fille($id);
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

    public function edit($out_id) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        if ($this->input->post('submit')) {
          $this->load->library('form_validation');
          $this->load->library('email');
          $this->form_validation->set_rules('hotel_id','Hotel Name','trim|required');
          $this->form_validation->set_rules('date','Date','trim|required');
          $this->form_validation->set_rules('re_date','Date of Return','trim|required');
          $this->form_validation->set_rules('department_id','Department','trim|required');
          if ($this->form_validation->run() == TRUE) {
            $this->load->model('out_go_model');
            $this->load->model('users_model');  
            $form_data = array(
              'hotel_id' => $this->input->post('hotel_id'),
              'date' => $this->input->post('date'),
              're_date' => $this->input->post('re_date'),
              'address' => $this->input->post('address'),
              'department_id' => $this->input->post('department_id')
            );
            $this->out_go_model->update_out_go($out_id, $form_data);
            foreach ($this->input->post('items') as $Key => $item) {
              $item['out_id'] = $out_id;
              $file_name = $this->do_upload("items-".$Key."-fille");
              $item['fille'] = $file_name;  
              $this->out_go_model->update_item($item['id'], $out_id, $item);
            }
            $this->out_go_model->clear_reason($out_id);
            foreach ($this->input->post('reason') as $reason) {
              $this->out_go_model->add_reason($out_id, $reason);
            }
            redirect('/out_go/view/'.$out_id);
          }   
        }
        try {
          $this->load->helper('form');
          $this->load->model('out_go_model');
          $this->load->model('hotels_model');
          $this->data['out_go'] = $this->out_go_model->get_out_go($out_id);
          $this->data['items'] = $this->out_go_model->get_items($out_id);
          $this->data['reason'] = $this->out_go_model->get_reason($out_id);
          $this->data['uploads'] = $this->out_go_model->get_by_fille($out_id);
          $this->data['reasons'] = $this->out_go_model->get_reasons();
          $this->data['departments'] = $this->out_go_model->get_departments();
          $this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
          $this->load->view('out_go_edit',$this->data);
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
      }
    }

    public function mail_me($out_id) {
      $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
      $this->load->library('email');
      $this->load->helper('url');
      $out_url = base_url().'out_go/view/'.$out_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($user->email);
      $this->email->subject("Out Going Form No. #{$out_id}");
      $this->email->message("Out Going Form NO.#{$out_id}:
        <br/>
        Please use the link below to view The Out Going Form:
        <a href='{$out_url}' target='_blank'>{$out_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
      redirect('out_go/view/'.$out_id);
    }

    public function mail($out_id) {
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
          $out_url = base_url().'out_go/view/'.$out_id;
          $this->email->from('e-signature@sunrise-resorts.com');
          $this->email->to($email);
          $this->email->subject("A message from {$user->fullname}, Out Going Form No. #{$out_id}");
          $this->email->message("{$user->fullname} sent you a private message regarding Out Going Form No. #{$out_id}:
            <br/>
            {$message}
            <br />
            <br />
            Please use the link below to view the Out Going Form:
            <a href='{$out_url}' target='_blank'>{$out_url}</a>
            <br/>
          "); 
          $mail_result = $this->email->send();
        }
      }
      redirect('out_go/view/'.$out_id);
    }

    public function unsign($signature_id) {
      $this->load->model('out_go_model');
      $this->load->model('users_model');
      $signature_identity = $this->out_go_model->get_signature_identity($signature_id);
      $this->out_go_model->unsign($signature_id);
      redirect('/out_go/out_stage/'.$signature_identity['out_id']);  
    }

    public function sign($signature_id, $reject = FALSE) {
      $this->load->model('out_go_model');
      $signature_identity = $this->out_go_model->get_signature_identity($signature_id);
      $signrs = $this->get_signers($signature_identity['out_id'], $signature_identity['hotel_id']);
      if (array_key_exists($this->data['user_id'], $signrs[$signature_id]['queue'])) {
        if ($reject) {
          $this->out_go_model->reject($signature_id, $this->data['user_id']);
          redirect('/out_go/out_stage/'.$signature_identity['out_id']);  
        } else {
          $this->out_go_model->sign($signature_id, $this->data['user_id']);
          //die(print_r($signature_id));
          redirect('/out_go/out_stage/'.$signature_identity['out_id']);  
        }
      }
      redirect('/out_go/view/'.$signature_identity['out_id']);
    }

    public function out_with($out_id){
      if ($this->input->post('submit')) {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('out_with','Out With','trim|required');
        if ($this->form_validation->run() == TRUE) {
          $out_with = $this->input->post('out_with'); 
          $this->load->model('out_go_model');
          $this->out_go_model->update_out_with($out_id, $out_with);
        }
        redirect('/out_go/view/'.$out_id);
      }
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
        redirect('/out_go/view/'.$out_id);
      }
    }

  public function edit_re_date($out_id){
     if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        if ($this->input->post('submit')) {
            $this->load->model('out_go_model');
            $this->load->model('users_model');  
             $data=array(
                  'user_id'  =>$this->data['user_id'],
                  'out_id'   =>$out_id,
                  'date'     =>$this->input->post('date'),
                  'reason'   =>$this->input->post('reason')
               );
            $change_date=$this->out_go_model->add_change_date($data);
          if($change_date){
              $datas = array(
              'change_re_date' => '1'
              );
            $this->out_go_model->update_re_date($datas,$out_id);
            }
            redirect('/out_go/view/'.$out_id);
         }
      } 
    }
 public function del_changed_re_date($id,$out_id ){
      $this->load->model('out_go_model');
      $this->db->delete('out_go_date_change', array('id' => $id));
      $out_go_chdates = $this->out_go_model->get_changed_dates($out_id);
      if(!$out_go_chdates){
        $this->out_go_model->update_change_re_date($out_id,0);
      }
      redirect('/out_go/view/'.$out_id);
    }
   

}

?>