<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  class out_service extends CI_Controller {

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
        $this->load->model('out_service_model');
        $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
        $hotels = array();
        foreach ($user_hotels as $hotel) {
          $hotels[] = $hotel['id'];
        }  
        $this->data['out_services'] = $this->out_service_model->view($hotels, $states);
        foreach ($this->data['out_services'] as $key => $out) {
          $this->data['out_services'][$key]['approvals'] = $this->out_service_model->get_by_verbals($this->data['out_services'][$key]['id']);
          foreach ($this->data['out_services'][$key]['approvals'] as $keys => $out) {
            if ($this->data['out_services'][$key]['approvals'][$keys]['rank'] == 1) {
              $this->data['out_services'][$key]['approvals'][$keys]['department_id'] =  $this->data['out_services'][$key]['department_id'];
              $this->data['out_services'][$key]['approvals'][$keys]['department'] =  $this->data['out_services'][$key]['department'];
            }
          }
        } 
        if ($this->input->post('submit')) {
          $this->data['var'] = $this->input->post('states_id');
        }
        $this->data['hotels'] = $user_hotels;
        $this->data['state'] = $state;
        $this->data['states'] = $this->out_service_model->get_states();
        $this->load->view('out_service_index', $this->data);
      }
    }

    public function submit() {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        $this->load->model('out_service_model');
        $assumed_code = strtoupper(str_pad(dechex( mt_rand( 50, 1048579999 ) ), 6, '0', STR_PAD_LEFT));   
        $out_service = $this->out_service_model->get_out_service_by_serial($assumed_code); 
        if ($out_service) {
          redirect('/out_service/submit/');
        }else{       
          if ($this->input->post('submit')) {
            $this->load->library('form_validation');
            $this->load->library('email');
            $this->load->model('users_model'); 
            $this->form_validation->set_rules('hotel_id','Hotel Name','trim|required');
            $this->form_validation->set_rules('date','Date','trim|required');
            $this->form_validation->set_rules('department_id','Department','trim|required');
            $assumed_id = $this->input->post('assumed_id');              
            if ($this->form_validation->run() == TRUE) {
              $data = array(
                'user_id' => $this->data['user_id'],
                'ip' => $this->input->ip_address(),
                'hotel_id' => $this->input->post('hotel_id'),
                'serial' => $assumed_code,
                'date' => $this->input->post('date'),
                'department_id' => $this->input->post('department_id'),
                'reason' => $this->input->post('reason'),
                'sister_id' => $this->input->post('sister_id')
              );
              $out_id = $this->out_service_model->create_out_service($data);
              if ($out_id) {
                $this->out_service_model->update_files($assumed_id,$out_id);
              } else {
                die("ERROR");
              }
              foreach ($this->input->post('items') as $Key => $item) {
                $item['out_id'] = $out_id;  
                $item['user_id'] = $this->data['user_id'];  
                $item['ip'] = $this->input->ip_address();  
                $file_name = $this->do_upload("items-".$Key."-fille");
                $item['fille'] = $file_name;  
                $item_id = $this->out_service_model->create_item($item);
                if (!$item_id) {
                  die("ERROR");
                }
              }
              $signatures = $this->out_service_model->out_sign();
              $do_sign = $this->out_service_model->out_do_sign($out_id);
              if ($do_sign == 0) {
                foreach ($signatures as $out_signature) {
                  $this->out_service_model->add_signature($out_id, $out_signature['role'], $out_signature['department'], $out_signature['rank']);
                }
              }
              redirect('/out_service/out_stage/'.$out_id);
            }
          }
        }
        try {
          $this->load->helper('form');
          $this->load->model('out_service_model');
          $this->load->model('hotels_model');
          $this->load->model('departments_model');
          $this->data['reasons'] = $this->out_service_model->get_reasons();
          $this->data['departments'] = $this->departments_model->getall();          
          $this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
          if ($this->input->post('submit')) {
            $this->data['assumed_id'] = "0".mt_rand("1048575","10485751048575");
            $this->data['uploads'] = $this->out_service_model->get_by_fille($this->data['assumed_id']);
          } else {
            $this->data['assumed_id'] = "0".mt_rand("1048575","10485751048575");
            $this->data['uploads'] = array();
          }
          $this->load->view('out_service_add_new',$this->data);
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
      }
    }

    public function upload($out_id) {
      $file_name = $this->do_upload("upload");
      if (!$file_name) {
        die(json_encode($this->data['error']));
      } else {
        $this->load->model("out_service_model");
        $this->out_service_model->add_fille($out_id, $file_name, $this->data['user_id']);
        die("{}");
      }
    }

    public function remove($out_id, $id) {
      $file_name = $_POST['key'];
      if (!$id) {
        die(json_encode($this->data['error']));
      } else {
        $this->load->model("out_service_model");
        $this->out_service_model->remove_fille($id);
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

    public function out_stage($out_id) {
      $this->load->model('out_service_model');
      $this->data['out_service'] = $this->out_service_model->get_out_service_by_id($out_id);
      if ($this->data['out_service']['state_id'] == 0) {
        $this->out_service_model->update_state($out_id, 1);
        redirect('/out_service/out_stage/'.$out_id);
      }elseif ($this->data['out_service']['state_id'] == 3){
        $user = $this->users_model->get_user_by_id($this->data['out_service']['user_id'], TRUE);
        $queue = $this->reject_mail($user->fullname, $user->email, $out_id);
      }elseif ($this->data['out_service']['state_id'] != 2){
        $queue = $this->notify_signers($out_id, $this->data['out_service']['hotel_id']);
        if (!$queue) {
          $this->out_service_model->update_state($out_id, 2);
          $user = $this->users_model->get_user_by_id($this->data['out_service']['user_id'], TRUE);
          $queue = $this->approvel_mail($user->fullname, $user->email, $out_id);
          redirect('/out_service/out_stage/'.$out_id);
        }
      }
      redirect('/out_service/view/'.$out_id);
    }

    private function reject_mail($name, $email, $out_id) {
      $this->load->library('email');
      $this->load->helper('url');
      $out_url = base_url().'out_service/view/'.$out_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($email);
      $this->email->subject("Retired Items Form No. #{$out_id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
        Retired Items Form No. #{$out_id} has been rejected, Please use the link below:
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
      $this->load->model('out_service_model');
      $signatures = $this->out_service_model->get_by_verbal($out_id);
      return $this->roll_signers($signatures, $hotel_id, $out_id);
    }

    private function roll_signers($signatures, $hotel_id, $out_id) {
      $signers = array();
      $this->load->model('users_model');
      $this->load->model('out_service_model');
      $out_service = $this->out_service_model->get_out_service_by_id($out_id);
      foreach ($signatures as $signature) {
        $signers[$signature['id']] = array();
        $signers[$signature['id']]['role'] = $signature['role'];
        $signers[$signature['id']]['role_id'] = $signature['role_id'];
        if ($signature['rank'] == 1 ) {
          $signers[$signature['id']]['department'] = $out_service['department'];
        }else{
          $signers[$signature['id']]['department'] = $signature['department'];
        }
        $signers[$signature['id']]['department_id'] = $signature['department_id'];
        if ($signature['user_id']) {
          if ($signature['rank'] == 1){
            $this->out_service_model->update_state($out_id, 4);
          }elseif ($signature['rank'] == 2){
            $this->out_service_model->update_state($out_id, 5);
          }elseif ($signature['rank'] == 3){
            $this->out_service_model->update_state($out_id, 6);
          }elseif ($signature['rank'] == 4){
            $this->out_service_model->update_state($out_id, 7);
          }elseif ($signature['rank'] == 5){
            $this->out_service_model->update_state($out_id, 8);
          }elseif ($signature['rank'] == 6){
            $this->out_service_model->update_state($out_id, 9);
          }elseif ($signature['rank'] == 7){
            $this->out_service_model->update_state($out_id, 2);
          }
          $signers[$signature['id']]['sign'] = array();
          $signers[$signature['id']]['sign']['id'] = $signature['user_id'];
          if ($signature['reject'] == 1) {
            $signers[$signature['id']]['sign']['reject'] = "reject";
            $this->out_service_model->update_state($out_id, 3);
          } 
          $user = $this->users_model->get_user_by_id($signature['user_id'], TRUE);
          $signers[$signature['id']]['sign']['name'] = $user->fullname;
          $signers[$signature['id']]['sign']['mail'] = $user->email;
          $signers[$signature['id']]['sign']['sign'] = $user->signature;
          $signers[$signature['id']]['sign']['timestamp'] = $signature['timestamp'];
        } else {
          $signers[$signature['id']]['queue'] = array();
          if ($signature['rank'] == 1 ) {
            $users = $this->users_model->getby_criteria($signature['role_id'], $hotel_id, $out_service['department_id']);
          }elseif ($signature['role_id'] == 85 && $hotel_id == 5 ) {
            $users = $this->users_model->getby_criteria(25, $hotel_id, $signature['department_id']);
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
      $out_url = base_url().'out_service/view/'.$out_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($mail);
      $this->email->subject("Retired Items Form No. #{$out_id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
        Retired Items Form No. #{$out_id} requires your signature, Please use the link below:
        <br/>
        <a href='{$out_url}' target='_blank'>{$out_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
    }

    private function approvel_mail($name, $email, $out_id) {
      $this->load->library('email');
      $this->load->helper('url');
      $out_url = base_url().'out_service/view/'.$out_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($email);
      $this->email->subject("Retired Items Form No. #{$out_id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
        Retired Items Form No. #{$out_id} has been approved, Please use the link below:
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
        $this->load->model('out_service_model');
        $this->load->model('hotels_model');   
        $this->data['out_service'] = $this->out_service_model->get_out_service_by_id($out_id);
        $this->data['items'] = $this->out_service_model->get_items($out_id);
        $this->data['uploads'] = $this->out_service_model->get_by_fille($out_id);
        $this->data['comments'] = $this->out_service_model->get_comment($out_id);
        $this->data['signature_path'] = '/assets/uploads/signatures/';
        $this->data['signers'] = $this->get_signers($this->data['out_service']['id'], $this->data['out_service']['hotel_id']);
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
          if ( $this->data['out_service']['user_id'] == $this->data['user_id'] &&  $this->data['out_service']['state_id'] != 2) {
            $editor = TRUE;
          }
        }
        $this->data['unsign_enable'] = (($unsign_enable) || $this->data['is_admin'])? TRUE : FALSE;
        $this->data['is_editor'] = ($editor || $this->data['is_admin'])? TRUE : FALSE;
        $this->load->view('out_service_view', $this->data);
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
          $this->form_validation->set_rules('department_id','Department','trim|required');
          if ($this->form_validation->run() == TRUE) {
            $this->load->model('out_service_model');
            $this->load->model('users_model');  
            $form_data = array(
              'hotel_id' => $this->input->post('hotel_id'),
              'date' => $this->input->post('date'),
              'department_id' => $this->input->post('department_id'),
              'reason' => $this->input->post('reason'),
              'sister_id' => $this->input->post('sister_id')
            );
            $this->out_service_model->update_out_service($out_id, $form_data);
            foreach ($this->input->post('items') as $Key => $item) {
              $item['out_id'] = $out_id;  
              $item['user_id'] = $this->data['user_id'];  
              $item['ip'] = $this->input->ip_address();  
              $file_name = $this->do_upload("items-".$Key."-fille");
              if ($file_name) {
                $item['fille'] = $file_name;  
              }
              $this->out_service_model->update_item($item['id'], $out_id, $item);
            }
            redirect('/out_service/view/'.$out_id);
          }   
        }
        try {
          $this->load->helper('form');
          $this->load->model('out_service_model');
          $this->load->model('hotels_model');
          $this->load->model('departments_model');
          $this->data['out_service'] = $this->out_service_model->get_out_service_by_id($out_id);
          $this->data['items'] = $this->out_service_model->get_items($out_id);
          $this->data['uploads'] = $this->out_service_model->get_by_fille($out_id);
          $this->data['reasons'] = $this->out_service_model->get_reasons();
          $this->data['departments'] = $this->departments_model->getall();          
          $this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
          $this->load->view('out_service_edit',$this->data);
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
      $out_url = base_url().'out_service/view/'.$out_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($user->email);
      $this->email->subject("Retired Items Form No. #{$out_id}");
      $this->email->message("Retired Items Form NO.#{$out_id}:
        <br/>
        Please use the link below to view The Retired Items Form:
        <a href='{$out_url}' target='_blank'>{$out_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
      redirect('out_service/view/'.$out_id);
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
          $out_url = base_url().'out_service/view/'.$out_id;
          $this->email->from('e-signature@sunrise-resorts.com');
          $this->email->to($email);
          $this->email->subject("A message from {$user->fullname}, Retired Items Form No. #{$out_id}");
          $this->email->message("{$user->fullname} sent you a private message regarding Retired Items Form No. #{$out_id}:
            <br/>
            {$message}
            <br />
            <br />
            Please use the link below to view the Retired Items Form:
            <a href='{$out_url}' target='_blank'>{$out_url}</a>
            <br/>
          "); 
          $mail_result = $this->email->send();
        }
      }
      redirect('out_service/view/'.$out_id);
    }

    public function unsign($signature_id) {
      $this->load->model('out_service_model');
      $this->load->model('users_model');
      $signature_identity = $this->out_service_model->get_signature_identity($signature_id);
      $this->out_service_model->unsign($signature_id);
      $this->out_service_model->update_state($signature_identity['out_id'], 1);
      redirect('/out_service/out_stage/'.$signature_identity['out_id']);  
    }

    public function sign($signature_id, $reject = FALSE) {
      $this->load->model('out_service_model');
      $signature_identity = $this->out_service_model->get_signature_identity($signature_id);
      $signrs = $this->get_signers($signature_identity['out_id'], $signature_identity['hotel_id']);
      if (array_key_exists($this->data['user_id'], $signrs[$signature_id]['queue'])) {
        if ($reject) {
          $this->out_service_model->reject($signature_id, $this->data['user_id']);
          redirect('/out_service/out_stage/'.$signature_identity['out_id']);  
        } else {
          $this->out_service_model->sign($signature_id, $this->data['user_id']);
          //die(print_r($signature_id));
          redirect('/out_service/out_stage/'.$signature_identity['out_id']);  
        }
      }
      redirect('/out_service/view/'.$signature_identity['out_id']);
    }

    public function comment($out_id){
      if ($this->input->post('submit')) {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('comment','Comment','trim|required');
        if ($this->form_validation->run() == TRUE) {
          $comment = $this->input->post('comment'); 
          $this->load->model('out_service_model');
          $comment_data = array(
            'user_id' => $this->data['user_id'],
            'out_id' => $out_id,
            'comment' => $comment
          );
          $this->out_service_model->insert_comment($comment_data);
        }
        redirect('/out_service/view/'.$out_id);
      }
    }

  }

?>