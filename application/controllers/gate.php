<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  class gate extends CI_Controller {

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
        $this->load->model('hotels_model');
        $this->load->model('gate_model');
        $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
        $hotels = array();
        foreach ($user_hotels as $hotel) {
          $hotels[] = $hotel['id'];
        }  
        $this->data['gates'] = $this->gate_model->view($hotels, $state);
        foreach ($this->data['gates'] as $key => $out) {
          $this->data['gates'][$key]['approvals'] = $this->gate_model->get_by_verbals($this->data['gates'][$key]['id']);
          foreach ($this->data['gates'][$key]['approvals'] as $keys => $out) {
            if ($this->data['gates'][$key]['approvals'][$keys]['rank'] == 1) {
              $this->data['gates'][$key]['approvals'][$keys]['department_id'] =  $this->data['gates'][$key]['department_id'];
              $this->data['gates'][$key]['approvals'][$keys]['department'] =  $this->data['gates'][$key]['department'];
            }
          }
        } 
        $this->data['hotels'] = $user_hotels;
        $this->load->view('gate_index', $this->data);
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
          $this->form_validation->set_rules('name','Name','trim|required');
          $this->form_validation->set_rules('position','Position','trim|required');
          $this->form_validation->set_rules('department_id','Department','trim|required');
          $assumed_id = $this->input->post('assumed_id');                        
          if ($this->form_validation->run() == TRUE) {
            $this->load->model('gate_model');
            $this->load->model('users_model');  
            $data = array(
              'ip' => $this->input->ip_address(),
              'user_id' => $this->data['user_id'],
              'hotel_id' => $this->input->post('hotel_id'),
              'date' => $this->input->post('date'),
              'name' => $this->input->post('name'),
              'position' => $this->input->post('position'),
              'department_id' => $this->input->post('department_id'),
              'reason' => $this->input->post('reason'),
              'out_with' => $this->input->post('out_with')
            );
            $gate_id = $this->gate_model->create_gate($data);
            if ($gate_id) {
              $this->gate_model->update_files($assumed_id,$gate_id);
            } else {
              die("ERROR");
            }
            foreach ($this->input->post('items') as $Key => $item) {
              $item['gate_id'] = $gate_id;  
              $item['ip'] = $this->input->ip_address();  
              $item['user_id'] = $this->data['user_id'];  
              $file_name = $this->do_upload("items-".$Key."-fille");
              $item['fille'] = $file_name;  
              $item_id = $this->gate_model->create_item($item);
              if (!$item_id) {
                die("ERROR");
              }
            }
            $signatures = $this->gate_model->gate_sign();
            $do_sign = $this->gate_model->gate_do_sign($gate_id);
            if ($do_sign == 0) {
              foreach ($signatures as $gate_signature) {
                $this->gate_model->add_signature($gate_id, $gate_signature['role'], $gate_signature['department'], $gate_signature['rank']);
              }
            }
            redirect('/gate/gate_stage/'.$gate_id);
          }
        }
        try {
          $this->load->helper('form');
          $this->load->model('gate_model');
          $this->load->model('hotels_model');
          $this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
          $this->data['departments'] = $this->gate_model->get_departments();
          $this->data['assumed_id'] = mt_rand("1048575","10485751048575");
          if ($this->input->post('submit')) {
            $this->data['uploads'] = $this->gate_model->get_by_fille($this->data['assumed_id']);
          } else {
            $this->data['uploads'] = array();
          }
          $this->load->view('gate_add_new',$this->data);
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
      }
    }

    public function gate_stage($gate_id) {
      $this->load->model('gate_model');
      $this->data['gate'] = $this->gate_model->get_gate($gate_id);
      if ($this->data['gate']['state_id'] == 0) {
        $this->gate_model->update_state($gate_id, 1);
        redirect('/gate/gate_stage/'.$gate_id);
      }elseif ($this->data['gate']['state_id'] == 3){
        $user = $this->users_model->get_user_by_id($this->data['gate']['user_id'], TRUE);
        $queue = $this->reject_mail($user->fullname, $user->email, $gate_id);
      }elseif ($this->data['gate']['state_id'] != 2){
        $queue = $this->notify_signers($gate_id, $this->data['gate']['hotel_id']);
        if (!$queue) {
          $this->gate_model->update_state($gate_id, 2);
          $user = $this->users_model->get_user_by_id($this->data['gate']['user_id'], TRUE);
          $queue = $this->approvel_mail($user->fullname, $user->email, $gate_id);
          redirect('/gate/gate_stage/'.$gate_id);
        }
      }
      redirect('/gate/view/'.$gate_id);
    }

    private function reject_mail($name, $email, $gate_id) {
      $this->load->library('email');
      $this->load->helper('url');
      $gate_url = base_url().'gate/view/'.$gate_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($email);
      $this->email->subject("Gate Pass Form No. #{$gate_id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
        Gate Pass Form No. #{$gate_id} has been rejected, Please use the link below:
        <br/>
        <a href='{$gate_url}' target='_blank'>{$gate_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
    }

    private function notify_signers($gate_id, $hotel_id) {
      $notified = FALSE;
      $signers = $this->get_signers($gate_id, $hotel_id);
      foreach ($signers as $signer) {
        if (isset($signer['queue'])) {
          $notified = TRUE;
          foreach ($signer['queue'] as $uid => $user) {
            $this->signatures_mail($signer['role'], $signer['department'], $user['name'], $user['mail'], $gate_id);
          }
          break;
        }
      }
      return $notified;
    }

    private function get_signers($gate_id, $hotel_id) {
      $this->load->model('gate_model');
      $signatures = $this->gate_model->get_by_verbal($gate_id);
      return $this->roll_signers($signatures, $hotel_id, $gate_id);
    }

    private function roll_signers($signatures, $hotel_id, $gate_id) {
      $signers = array();
      $this->load->model('users_model');
      $this->load->model('gate_model');
      $gate = $this->gate_model->get_gate($gate_id);
      foreach ($signatures as $signature) {
        $signers[$signature['id']] = array();
        $signers[$signature['id']]['role'] = $signature['role'];
        $signers[$signature['id']]['role_id'] = $signature['role_id'];
        if ($signature['rank'] == 1 ) {
          $signers[$signature['id']]['department'] = $gate['department'];
          $signers[$signature['id']]['department_id'] = $gate['department_id'];
        }else{
          $signers[$signature['id']]['department'] = $signature['department'];
          $signers[$signature['id']]['department_id'] = $signature['department_id'];
        }
        if ($signature['user_id']) {
          if ($signature['rank'] == 1){
            $this->gate_model->update_state($gate_id, 4);
          }elseif ($signature['rank'] == 2){
            $this->gate_model->update_state($gate_id, 5);
          }elseif ($signature['rank'] == 3){
            $this->gate_model->update_state($gate_id, 2);
          }
          $signers[$signature['id']]['sign'] = array();
          $signers[$signature['id']]['sign']['id'] = $signature['user_id'];
          if ($signature['reject'] == 1) {
            $signers[$signature['id']]['sign']['reject'] = "reject";
            $this->gate_model->update_state($gate_id, 3);
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
            $users = $this->users_model->getby_criteria($signature['role_id'], $hotel_id, $gate['department_id']);
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

    private function signatures_mail($role, $department, $name, $mail, $gate_id) {
      $this->load->library('email');
      $this->load->helper('url');
      $gate_url = base_url().'gate/view/'.$gate_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($mail);
      $this->email->subject("Gate Pass Form No. #{$gate_id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
        Gate Pass Form No. #{$gate_id} requires your signature, Please use the link below:
        <br/>
        <a href='{$gate_url}' target='_blank'>{$gate_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
    }

    private function approvel_mail($name, $email, $gate_id) {
      $this->load->library('email');
      $this->load->helper('url');
      $gate_url = base_url().'gate/view/'.$gate_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($email);
      $this->email->subject("Gate Pass Form No. #{$gate_id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
        Gate Pass Form No. #{$gate_id} has been approved, Please use the link below:
        <br/>
        <a href='{$gate_url}' target='_blank'>{$gate_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
    }

    public function view($gate_id) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{      
        $this->load->model('gate_model');
        $this->data['gate'] = $this->gate_model->get_gate($gate_id);
        $this->data['items'] = $this->gate_model->get_items($gate_id);
        $this->data['uploads'] = $this->gate_model->get_by_fille($gate_id);
        $this->data['comments'] = $this->gate_model->get_comment($gate_id);
        $this->data['signature_path'] = '/assets/uploads/signatures/';
        $this->data['signers'] = $this->get_signers($this->data['gate']['id'], $this->data['gate']['hotel_id']);
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
          if ( $this->data['gate']['user_id'] == $this->data['user_id'] &&  $this->data['gate']['state_id'] != 2) {
            $editor = TRUE;
          }
        }
        $this->data['unsign_enable'] = (($unsign_enable) || $this->data['is_admin'])? TRUE : FALSE;
        $this->data['is_editor'] = ($editor || $this->data['is_admin'])? TRUE : FALSE;
        $this->load->view('gate_view', $this->data);
      }
    }

    public function upload($gate_id) {
      $file_name = $this->do_upload("upload");
      if (!$file_name) {
        die(json_encode($this->data['error']));
      } else {
        $this->load->model("gate_model");
        $this->gate_model->add_fille($gate_id, $file_name, $this->data['user_id']);
        die("{}");
      }
    }

    public function remove($gate_id, $id) {
      $file_name = $_POST['key'];
      if (!$id) {
        die(json_encode($this->data['error']));
      } else {
        $this->load->model("gate_model");
        $this->gate_model->remove_fille($id);
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

    public function edit($gate_id) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        if ($this->input->post('submit')) {
          $this->load->library('form_validation');
          $this->load->library('email');
          $this->form_validation->set_rules('hotel_id','Hotel Name','trim|required');
          $this->form_validation->set_rules('name','Name','trim|required');
          $this->form_validation->set_rules('position','Position','trim|required');
          $this->form_validation->set_rules('department_id','Department','trim|required');
          if ($this->form_validation->run() == TRUE) {
            $this->load->model('gate_model');
            $this->load->model('users_model');  
            $form_data = array(
              'hotel_id' => $this->input->post('hotel_id'),
              'date' => $this->input->post('date'),
              'name' => $this->input->post('name'),
              'position' => $this->input->post('position'),
              'department_id' => $this->input->post('department_id'),
              'reason' => $this->input->post('reason'),
              'out_with' => $this->input->post('out_with')
            );
            $this->gate_model->update_gate($gate_id, $form_data);
            foreach ($this->input->post('items') as $Key => $item) {
              $item['gate_id'] = $gate_id;
              $item['ip'] = $this->input->ip_address();  
              $item['user_id'] = $this->data['user_id'];  
              $file_name = $this->do_upload("items-".$Key."-fille");
              $item['fille'] = $file_name;  
              $this->gate_model->update_item($item['id'], $gate_id, $item);
            }
            redirect('/gate/view/'.$gate_id);
          }   
        }
        try {
          $this->load->helper('form');
          $this->load->model('gate_model');
          $this->load->model('hotels_model');
          $this->data['gate'] = $this->gate_model->get_gate($gate_id);
          $this->data['items'] = $this->gate_model->get_items($gate_id);
          $this->data['uploads'] = $this->gate_model->get_by_fille($gate_id);
          $this->data['departments'] = $this->gate_model->get_departments();
          $this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
          $this->load->view('gate_edit',$this->data);
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
      }
    }

    public function mail_me($gate_id) {
      $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
      $this->load->library('email');
      $this->load->helper('url');
      $gate_url = base_url().'gate/view/'.$gate_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($user->email);
      $this->email->subject("Gate Pass Form No. #{$gate_id}");
      $this->email->message("Gate Pass Form NO.#{$gate_id}:
        <br/>
        Please use the link below to view The Gate Pass Form:
        <a href='{$gate_url}' target='_blank'>{$gate_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
      redirect('gate/view/'.$gate_id);
    }

    public function mail($gate_id) {
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
          $gate_url = base_url().'gate/view/'.$gate_id;
          $this->email->from('e-signature@sunrise-resorts.com');
          $this->email->to($email);
          $this->email->subject("A message from {$user->fullname}, Gate Pass Form No. #{$gate_id}");
          $this->email->message("{$user->fullname} sent you a private message regarding Gate Pass Form No. #{$gate_id}:
            <br/>
            {$message}
            <br />
            <br />
            Please use the link below to view the Gate Pass Form:
            <a href='{$gate_url}' target='_blank'>{$gate_url}</a>
            <br/>
          "); 
          $mail_result = $this->email->send();
        }
      }
      redirect('gate/view/'.$gate_id);
    }

    public function unsign($signature_id) {
      $this->load->model('gate_model');
      $this->load->model('users_model');
      $signature_identity = $this->gate_model->get_signature_identity($signature_id);
      $this->gate_model->unsign($signature_id);
      redirect('/gate/gate_stage/'.$signature_identity['gate_id']);  
    }

    public function sign($signature_id, $reject = FALSE) {
      $this->load->model('gate_model');
      $signature_identity = $this->gate_model->get_signature_identity($signature_id);
      $signrs = $this->get_signers($signature_identity['gate_id'], $signature_identity['hotel_id']);
      if (array_key_exists($this->data['user_id'], $signrs[$signature_id]['queue'])) {
        if ($reject) {
          $this->gate_model->reject($signature_id, $this->data['user_id']);
          redirect('/gate/gate_stage/'.$signature_identity['gate_id']);  
        } else {
          $this->gate_model->sign($signature_id, $this->data['user_id']);
          //die(print_r($signature_id));
          redirect('/gate/gate_stage/'.$signature_identity['gate_id']);  
        }
      }
      redirect('/gate/view/'.$signature_identity['gate_id']);
    }

    public function comment($gate_id){
      if ($this->input->post('submit')) {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('comment','Comment','trim|required');
        if ($this->form_validation->run() == TRUE) {
          $comment = $this->input->post('comment'); 
          $this->load->model('gate_model');
          $comment_data = array(
            'user_id' => $this->data['user_id'],
            'gate_id' => $gate_id,
            'comment' => $comment
          );
          $this->gate_model->insert_comment($comment_data);
        }
        redirect('/gate/view/'.$gate_id);
      }
    }

  }

?>