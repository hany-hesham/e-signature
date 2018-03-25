<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  class design_request extends CI_Controller {

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
      $this->data['menu']['active'] = "design";
      $this->data['module_forms'] = array('0' => 43);;
      $this->load->model('chairman_approval_model');
      $this->load->model('hotels_model');
      $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
      $hotels = array();
      foreach ($user_hotels as $hotel) {
        $hotels[] = $hotel['id'];
      }
      array_push($hotels, 0);
      $status = $this->data['module_forms'];
      $counter = 0;
      $forms = array();
      if ($status['0'] == 0) {
        $states = $this->chairman_approval_model->get_states();
        foreach ($states as $state) {
          if ($this->data['role_id'] == 7) {
            $forma = $this->chairman_approval_model->chairman_approval($state['database'], $this->data['department_id'], $hotels);
          }else{
            $forma = $this->chairman_approval_model->chairman_approval($state['database'], $this->data['role_id'], $hotels);
          }
          foreach ($forma as $key => $form) {
            if ($state['id'] == 1) {
              if (is_null($forma[$key]['code'])) {
                unset($forma[$key]);
              }else{
                $forma[$key]['state'] = $state;
                array_push($forms, $forma[$key]);
                $counter++;
              }
            }elseif ($state['id'] == 25) {
              if (!is_null($forma[$key]['code'])) {
                unset($forma[$key]);
              }else{
                $forma[$key]['state'] = $state;
                array_push($forms, $forma[$key]);
                $counter++;
              }
            }elseif ($state['id'] == 26) {
              if (is_null($forma[$key]['project_code'])) {
                unset($forma[$key]);
              }else{
                $forma[$key]['state'] = $state;
                array_push($forms, $forma[$key]);
                $counter++;
              }
            }elseif ($state['id'] == 27) {
              if (!is_null($forma[$key]['project_code'])) {
                unset($forma[$key]);
              }else{
                $forma[$key]['state'] = $state;
                array_push($forms, $forma[$key]);
                $counter++;
              }
            }else{
              $forma[$key]['state'] = $state;
              array_push($forms, $forma[$key]);
              $counter++;
            }
          }
        }
      }else{
        $states = $this->chairman_approval_model->get_state($status);
        foreach ($states as $state) {
          if ($this->data['role_id'] == 7) {
            $forma = $this->chairman_approval_model->chairman_approval($state['database'], $this->data['department_id'], $hotels);
          }else{
            $forma = $this->chairman_approval_model->chairman_approval($state['database'], $this->data['role_id'], $hotels);
          }
          foreach ($forma as $key => $form) {
            if ($state['id'] == 1) {
              if (is_null($forma[$key]['code'])) {
                unset($forma[$key]);
              }else{
                $forma[$key]['state'] = $state;
                array_push($forms, $forma[$key]);
                $counter++;
              }
            }elseif ($state['id'] == 25) {
              if (!is_null($forma[$key]['code'])) {
                unset($forma[$key]);
              }else{
                $forma[$key]['state'] = $state;
                array_push($forms, $forma[$key]);
                $counter++;
              }
            }elseif ($state['id'] == 26) {
              if (is_null($forma[$key]['project_code'])) {
                unset($forma[$key]);
              }else{
                $forma[$key]['state'] = $state;
                array_push($forms, $forma[$key]);
                $counter++;
              }
            }elseif ($state['id'] == 27) {
              if (!is_null($forma[$key]['project_code'])) {
                unset($forma[$key]);
              }else{
                $forma[$key]['state'] = $state;
                array_push($forms, $forma[$key]);
                $counter++;
              }
            }else{
              $forma[$key]['state'] = $state;
              array_push($forms, $forma[$key]);
              $counter++;
            }
          }
        }
      }
      $this->data['forms'] = $forms;
      if ($status['0'] != 0) {
        $this->data['state'] = $this->chairman_approval_model->get_state($status);
      }
      $this->data['states'] = $this->chairman_approval_model->get_states();
      $this->data['counter'] = $counter;
    }

    public function index($state = FALSE) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        if ($state == 12) {
          $role = $this->input->post('states_id');
        }else{
          $role = 0;
        }
        $states = $state;
        $this->load->model('hotels_model');
        $this->load->model('design_request_model');
        $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
        $hotels = array();
        foreach ($user_hotels as $hotel) {
          $hotels[] = $hotel['id'];
        }  
        $this->data['designs'] = $this->design_request_model->view($hotels, $states, $role);
        foreach ($this->data['designs'] as $key => $out) {
          $this->data['designs'][$key]['approvals'] = $this->design_request_model->get_by_verbals($this->data['designs'][$key]['id']);
          foreach ($this->data['designs'][$key]['approvals'] as $keys => $out) {
            if ($this->data['designs'][$key]['approvals'][$keys]['rank'] == 1) {
              $this->data['designs'][$key]['approvals'][$keys]['department_id'] =  $this->data['designs'][$key]['department_id'];
              $this->data['designs'][$key]['approvals'][$keys]['department'] =  $this->data['designs'][$key]['department'];
            }
          }
        } 
        if ($this->input->post('submit')) {
          $this->data['var'] = $this->input->post('states_id');
        }
        $this->data['hotels'] = $user_hotels;
        $this->data['state'] = $state;
        $this->data['states'] = $this->design_request_model->get_states();
        $this->load->view('design_request_index', $this->data);
      }
    }

    public function submit() {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        $this->load->model('design_request_model');
        $assumed = strtoupper(str_pad(dechex( mt_rand( 50, 1048579999 ) ), 6, '0', STR_PAD_LEFT));
        $this->data['assumed_id'] = $assumed;
        if ($this->input->post('submit')) { 
          $assumed_id = $this->input->post('assumed_id');
          $design = $this->design_request_model->get_design_by_serial($assumed_id);
          $this->load->library('form_validation');
          $this->load->library('email');
          $this->form_validation->set_rules('hotel_id','Hotel Name','trim|required');
          $this->form_validation->set_rules('date','Date','trim|required');
          $this->form_validation->set_rules('department_id','Department','trim|required');
          $this->form_validation->set_rules('outline','Outline','trim|required');
          if ($this->form_validation->run() == TRUE) {
            $data = array(
              'serial' => $assumed_id,
              'user_id' => $this->data['user_id'],
              'ip' => $this->input->ip_address(),
              'hotel_id' => $this->input->post('hotel_id'),
              'date' => $this->input->post('date'),
              'department_id' => $this->input->post('department_id'),
              'outline' => $this->input->post('outline')
            );
            if ($design) {
              $this->data['errors'] = "Files Didn't Upload Probably";
            }else{
              $design_id = $this->design_request_model->create_design($data);
              if ($design_id) {
                $this->design_request_model->update_files($assumed_id,$design_id);
              } else {
                die("ERROR");
              }
              foreach ($this->input->post('items') as $Key => $item) {
                $item['design_id'] = $design_id;  
                $item['user_id'] = $this->data['user_id'];  
                $item['ip'] = $this->input->ip_address();  
                $file_name = $this->do_upload("items-".$Key."-fille");
                $item['fille'] = $file_name;  
                $item_id = $this->design_request_model->create_item($item);
                if (!$item_id) {
                  die("ERROR");
                }
              }
              $signatures = $this->design_request_model->design_sign();
              $do_sign = $this->design_request_model->design_do_sign($design_id);
              if ($do_sign == 0) {
                foreach ($signatures as $design_signature) {
                  $this->design_request_model->add_signature($design_id, $design_signature['role'], $design_signature['department'], $design_signature['rank']);
                }
              }
              redirect('/design_request/design_stage/'.$design_id);
            }
          }
        }
        try {
          $this->load->helper('form');
          $this->load->model('hotels_model');
          $this->load->model('departments_model');
          $this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
          $this->data['departments'] = $this->departments_model->getall(); 
          if ($this->input->post('submit')) {
            $this->data['uploads'] = $this->design_request_model->get_by_fille($this->data['assumed_id']);
          } else {
            $this->data['uploads'] = array();
          }
          $this->load->view('design_request_add_new',$this->data);
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
      }
    }

    public function upload($design_id) {
      $file_name = $this->do_upload("upload");
      if (!$file_name) {
        die(json_encode($this->data['error']));
      } else {
        $this->load->model("design_request_model");
        $this->design_request_model->add_fille($design_id, $file_name, $this->data['user_id']);
        die("{}");
      }
    }

    public function remove($design_id, $id) {
      $file_name = $_POST['key'];
      if (!$id) {
        die(json_encode($this->data['error']));
      } else {
        $this->load->model("design_request_model");
        $this->design_request_model->remove_fille($id, $this->data['user_id']);
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

    public function design_stage($design_id) {
      $this->load->model('design_request_model');
      $this->data['design'] = $this->design_request_model->get_design_by($design_id, FALSE);
      if ($this->data['design']['state_id'] == 0) {
        $this->design_request_model->update_state($design_id, 1);
        redirect('/design_request/design_stage/'.$design_id);
      }elseif ($this->data['design']['state_id'] == 3){
        $user = $this->users_model->get_user_by_id($this->data['design']['user_id'], TRUE);
        $this->reject_mail($user->fullname, $user->email, $design_id, $this->data['design']['serial']);
      }elseif ($this->data['design']['state_id'] == 4){
        $this->design_request_model->update_state($design_id, 1);
        $this->notify_mail($design_id, $this->data['design']['serial']);
        redirect('/design_request/design_stage/'.$design_id);
      }elseif ($this->data['design']['state_id'] == 5){
        $this->notify_mail($design_id, $this->data['design']['serial']);
      }elseif ($this->data['design']['state_id'] != 2){
        $queue = $this->notify_signers($design_id, $this->data['design']['hotel_id'], $this->data['design']['serial']);
        if (!$queue) {
          $this->design_request_model->update_state($design_id, 2);
          $this->design_request_model->update_final($design_id, 0);
          $user = $this->users_model->get_user_by_id($this->data['design']['user_id'], TRUE);
          $this->approvel_mail($user->fullname, $user->email, $design_id, $this->data['design']['serial']);
          redirect('/design_request/design_stage/'.$design_id);
        }
      }
      redirect('/design_request/view/'.$this->data['design']['serial']);
    }

    private function reject_mail($name, $email, $design_id, $serial) {
      $this->load->library('email');
      $this->load->helper('url');
      $design_url = base_url().'design_request/view/'.$serial;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($email);
      $this->email->subject("Design Request Form No. #{$design_id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
        Design Request Form No. #{$design_id} has been rejected, Please use the link below:
        <br/>
        <a href='{$design_url}' target='_blank'>{$design_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
    }

    private function notify_mail($design_id, $serial) {
      $this->load->model('design_request_model');
      $signes = $this->design_request_model->get_allsignature($design_id);
      $users = array();
      foreach ($signers as $signe){
        $user = $this->users_model->get_user_by_id($signe['user_id'], TRUE);
        $name = $user->fullname;
        $email = $user->email;
        $this->load->library('email');
        $this->load->helper('url');
        $design_url = base_url().'design_request/view/'.$serial;
        $this->email->from('e-signature@sunrise-resorts.com');
        $this->email->to($email);
        $this->email->subject("Design Request Form No. #{$design_id}");
        $this->email->message("Dear {$name},
          <br/>
          <br/>
          Design Request Form No. #{$design_id}, Please use the link below:
          <br/>
          <a href='{$design_url}' target='_blank'>{$design_url}</a>
          <br/>
        "); 
        $mail_result = $this->email->send();
      }
    }

    private function notify_signers($design_id, $hotel_id, $serial) {
      $this->load->model('design_request_model');
      $notified = FALSE;
      $design_url = base_url().'design_request/view/'.$serial;
      $message = "Design Request Form No. {$design_id}:
        {$design_url}";
      $signers = $this->get_signers($design_id, $hotel_id);
      foreach ($signers as $signer) {
        if (isset($signer['queue'])) {
          $this->design_request_model->update_final($design_id, $signer['role_id']);
          $notified = TRUE;
          foreach ($signer['queue'] as $uid => $user) {
            $this->onclick($message, $design_id, $user['channel']);
            $this->signatures_mail($signer['role'], $signer['department'], $user['name'], $user['mail'], $design_id, $serial);
          }
          break;
        }
      }
      return $notified;
    }

    private function get_signers($design_id, $hotel_id) {
      $this->load->model('design_request_model');
      $signatures = $this->design_request_model->get_by_verbal($design_id);
      return $this->roll_signers($signatures, $hotel_id, $design_id);
    }

    private function roll_signers($signatures, $hotel_id, $design_id) {
      $signers = array();
      $this->load->model('users_model');
      $this->load->model('design_request_model');
      $design = $this->design_request_model->get_design_by($design_id, FALSE);
      foreach ($signatures as $signature) {
        $signers[$signature['id']] = array();
        $signers[$signature['id']]['role'] = $signature['role'];
        $signers[$signature['id']]['role_id'] = $signature['role_id'];
        if ($signature['rank'] == 1 ) {
          $signers[$signature['id']]['department'] = $design['department'];
        }else{
          $signers[$signature['id']]['department'] = $signature['department'];
        }
        $signers[$signature['id']]['department_id'] = $signature['department_id'];
        if ($signature['user_id']) {
          $signers[$signature['id']]['sign'] = array();
          $signers[$signature['id']]['sign']['id'] = $signature['user_id'];
          if ($signature['reject'] == 1) {
            $signers[$signature['id']]['sign']['reject'] = "reject";
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
          if ($signature['role_id'] == 1) {
            $users[0] = $this->users_model->getby_criteria(1, $hotel_id);
            $users[1] = $this->users_model->getby_criteria(2, $hotel_id);
            $users[2] = $this->users_model->getby_criteria(83, $hotel_id);
            foreach ($users as $user) {
              foreach ($user as $use) {
                $signers[$signature['id']]['queue'][$use['id']] = array();
                $signers[$signature['id']]['queue'][$use['id']]['name'] = $use['fullname'];
                $signers[$signature['id']]['queue'][$use['id']]['mail'] = $use['email'];
                $signers[$signature['id']]['queue'][$use['id']]['channel'] = $use['channel'];
              }
            }
          } else {
            if ($signature['rank'] == 1 ) {
              $users = $this->users_model->getby_criteria($signature['role_id'], $hotel_id, $design['department_id']);
            }else{
              $users = $this->users_model->getby_criteria($signature['role_id'], $hotel_id, $signature['department_id']);
            }
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

    function onclick($message, $id, $channelss){
      include(APPPATH . 'third_party/RocketChat/autoload.php');
      $client = new RocketChat\Client($this->config->item('send_url'));
      $token = $client->api('user')->login($this->config->item('user_access'),$this->config->item('pass_access'));
      $client->setToken($token);
      $channel_result = $client->api('channel')->sendMessage($channelss,$message);
      $this->load->model('design_request_model');
      $this->design_request_model->update_message_id($id, $channel_result);
    }

    private function signatures_mail($role, $department, $name, $mail, $design_id, $serial) {
      $this->load->library('email');
      $this->load->helper('url');
      $design_url = base_url().'design_request/view/'.$serial;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($mail);
      $this->email->subject("Design Request Form No. #{$design_id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
        Design Request Form No. #{$design_id} requires your signature, Please use the link below:
        <br/>
        <a href='{$design_url}' target='_blank'>{$design_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
    }

    private function approvel_mail($name, $email, $design_id, $serial) {
      $this->load->library('email');
      $this->load->helper('url');
      $design_url = base_url().'design_request/view/'.$serial;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($email);
      $this->email->subject("Design Request Form No. #{$design_id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
        Design Request Form No. #{$design_id} has been approved, Please use the link below:
        <br/>
        <a href='{$design_url}' target='_blank'>{$design_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
    }

    public function view($serial) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{      
        $this->load->model('design_request_model');
        $this->load->model('hotels_model');   
        $this->data['design'] = $this->design_request_model->get_design_by(FALSE, $serial);
        $this->data['items'] = $this->design_request_model->get_items($this->data['design']['id']);
        $this->data['uploads'] = $this->design_request_model->get_by_fille($this->data['design']['id']);
        $this->data['comments'] = $this->design_request_model->get_comment($this->data['design']['id']);
        $this->data['signature_path'] = '/assets/uploads/signatures/';
        $this->data['signers'] = $this->get_signers($this->data['design']['id'], $this->data['design']['hotel_id']);
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
        if ( $this->data['design']['user_id'] == $this->data['user_id'] &&  $this->data['design']['state_id'] != 2) {
          $editor = TRUE;
        }
        $this->data['unsign_enable'] = (($unsign_enable) || $this->data['is_admin'])? TRUE : FALSE;
        $this->data['is_editor'] = (($editor || $force_edit) || $this->data['is_admin'])? TRUE : FALSE;
        $this->load->view('design_request_view', $this->data);
      }
    }

    public function edit($serial, $new = FALSE) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        $this->data['new'] = $new;
        $this->load->model('design_request_model');
        $this->data['design'] = $this->design_request_model->get_design_by(FALSE, $serial);
        $design_id = $this->data['design']['id'];
        if ($this->input->post('submit')) {
          $this->load->library('form_validation');
          $this->load->library('email');
          $this->form_validation->set_rules('hotel_id','Hotel Name','trim|required');
          $this->form_validation->set_rules('date','Date','trim|required');
          $this->form_validation->set_rules('department_id','Department','trim|required');
          $this->form_validation->set_rules('outline','Outline','trim|required');
          if ($this->form_validation->run() == TRUE) {
            $data = array(
              'hotel_id' => $this->input->post('hotel_id'),
              'date' => $this->input->post('date'),
              'department_id' => $this->input->post('department_id'),
              'outline' => $this->input->post('outline'),
              'state_id' => 4
            );
            $this->design_request_model->update_design($design_id, $data);
            if ($new) {
              foreach ($this->input->post('items') as $Key => $item) {
                $item['design_id'] = $design_id;  
                $item['user_id'] = $this->data['user_id'];  
                $item['ip'] = $this->input->ip_address();  
                $file_name = $this->do_upload("items-".$Key."-fille");
                $item['fille'] = $file_name;  
                $item_id = $this->design_request_model->create_item($item);
                if (!$item_id) {
                  die("ERROR");
                }
              }
            }else{
              foreach ($this->input->post('items') as $Key => $item) {
                $item['design_id'] = $design_id;  
                $item['user_id'] = $this->data['user_id'];  
                $item['ip'] = $this->input->ip_address();  
                $file_name = $this->do_upload("items-".$Key."-fille");
                if ($file_name) {
                  $item['fille'] = $file_name;  
                }
                $this->design_request_model->update_item($item['id'], $design_id, $item);
              }
            }
            redirect('/design_request/design_stage/'.$design_id);
          }   
        }
        try {
          $this->load->helper('form');
          $this->load->model('design_request_model');
          $this->load->model('hotels_model');
          $this->load->model('departments_model');
          $this->data['design'] = $this->design_request_model->get_design_by(FALSE, $serial);
          $this->data['items'] = $this->design_request_model->get_items($this->data['design']['id']);
          $this->data['uploads'] = $this->design_request_model->get_by_fille($this->data['design']['id']);
          $this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
          $this->data['departments'] = $this->departments_model->getall(); 
          $this->load->view('design_request_edit',$this->data);
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
      }
    }

    public function delete($id, $serial, $type) {
      $this->load->model("design_request_model");
      if ($type == 1) {
        $this->design_request_model->remove_design($id, $this->data['user_id']);
        redirect('/design_request');
      }elseif ($type == 2) {
        $this->design_request_model->remove_item($id, $this->data['user_id']);
        redirect('/design_request/view/'.$serial);
      }elseif ($type == 3) {
        $this->design_request_model->remove_fille($id, $this->data['user_id']);
        redirect('/design_request/view/'.$serial);
      }elseif ($type == 4) {
        $this->design_request_model->remove_comment($id, $this->data['user_id']);
        redirect('/design_request/view/'.$serial);
      }
    }

    public function mail_me($design_id, $serial) {
      $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
      $this->load->library('email');
      $this->load->helper('url');
      $design_url = base_url().'design_request/view/'.$serial;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($user->email);
      $this->email->subject("Design Request Form No. #{$design_id}");
      $this->email->message("Design Request Form NO. #{$design_id}:
        <br/>
        Please use the link below to view The Design Request Form:
        <a href='{$design_url}' target='_blank'>{$design_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
      redirect('design_request/view/'.$serial);
    }

    public function share_me($design_id, $serial) {
      $this->load->helper('url');
      $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
      $design_url = base_url().'design_request/view/'.$serial;
      $messages = "{$user->fullname}  Design Request Form No. #{$design_id}
          {$design_url}";  
      $this->onclick($messages, $design_id, $user->channel);
      redirect('design_request/view/'.$serial);
    }

    public function share_url($design_id, $serial) {
      if ($this->input->post('submit')) {
        $this->load->helper('url');
        $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
        $design_url = base_url().'design_request/view/'.$serial;
        $messages = "{$user->fullname}  Design Request Form No. #{$design_id}
          {$design_url}";  
        $this->onclick($messages, $design_id, $this->config->item('page_to_send'));
      }
      redirect('design_request/view/'.$serial);
    }

    public function mail($design_id, $serial) {
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
          $design_url = base_url().'design_request/view/'.$serial;
          $this->email->from('e-signature@sunrise-resorts.com');
          $this->email->to($email);
          $this->email->subject("A message from {$user->fullname}, Design Request Form No. #{$design_id}");
          $this->email->message("{$user->fullname} sent you a private message regarding Design Request Form No. #{$design_id}:
            <br/>
            {$message}
            <br />
            <br />
            Please use the link below to view the Design Request Form:
            <a href='{$design_url}' target='_blank'>{$design_url}</a>
            <br/>
          "); 
          $mail_result = $this->email->send();
        }
      }
      redirect('design_request/view/'.$serial);
    }

    public function unsign($signature_id) {
      $this->load->model('design_request_model');
      $this->load->model('users_model');
      $signature_identity = $this->design_request_model->get_signature_identity($signature_id);
      $this->design_request_model->update_state($signature_identity['design_id'], 1);
      $this->design_request_model->unsign($signature_id);
      redirect('/design_request/design_stage/'.$signature_identity['design_id']);  
    }

    public function sign($signature_id, $reject = FALSE) {
      $this->load->model('design_request_model');
      $signature_identity = $this->design_request_model->get_signature_identity($signature_id);
      $signrs = $this->get_signers($signature_identity['design_id'], $signature_identity['hotel_id']);
      $design_url = base_url().'design_request/view/'.$signature_identity['serial'];
      $message_id = $signature_identity['message_id'];
      $id = $signature_identity['design_id'];
      $message = "Design Request Form No. #{$id}
          {$design_url}";  
      if (array_key_exists($this->data['user_id'], $signrs[$signature_id]['queue'])) {
        if ($signature_identity['role_id'] == 1) {
          $this->onclick1($message);
          $this->deletonclick($message_id);
        }
        if ($reject) {
          $this->design_request_model->reject($signature_id, $this->data['user_id']);
          $this->design_request_model->update_state($signature_identity['design_id'], 3);
        } else {
          $this->design_request_model->sign($signature_id, $this->data['user_id']); 
        }
      }
      redirect('/design_request/design_stage/'.$signature_identity['design_id']);
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

    public function finalize($design_id) {
      if ($this->input->post('submit')) {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('final','Target Date','trim|required');
        if ($this->form_validation->run() == TRUE) {
          $final = $this->input->post('final'); 
          $this->load->model("design_request_model");
          $this->design_request_model->edit_target($design_id, $final, $this->data['user_id']);
          $this->design_request_model->update_state($design_id, 5);
        }
        redirect('design_request/design_stage/'.$design_id);
      }
    }

    public function comment($design_id){
      if ($this->input->post('submit')) {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('comment','Comment','trim|required');
        $serial = $this->input->post('serial'); 
        if ($this->form_validation->run() == TRUE) {
          $comment = $this->input->post('comment'); 
          $this->load->model('design_request_model');
          $comment_data = array(
            'user_id' => $this->data['user_id'],
            'design_id' => $design_id,
            'comment' => $comment
          );
          $this->design_request_model->insert_comment($comment_data);
          $this->design_request_model->update_state($design_id, 4);
          if ($this->data['role_id'] == 217) {
            $this->chairman_mail($design_id, $serial);
          }
        }
        redirect('design_request/design_stage/'.$design_id);
      }
    }

    private function chairman_mail($design_id, $design_id) {
          $this->load->library('email');
          $this->load->helper('url');
          $design_url = base_url().'design_request/view/'.$serial;
          $this->email->from('e-signature@sunrise-resorts.com');
          $this->email->to('abeer@sunrise.eg');
          $this->email->subject("Design Request Form No. #{$design_id}");
          $this->email->message("Dear Madam Abber,
            <br/>
            <br/>
            Mr Hossam Commented on Design Request Form No. #{$design_id}, Please use the link below:
            <br/>
            <a href='{$design_url}' target='_blank'>{$design_url}</a>
            <br/>
          "); 
          $mail_result = $this->email->send();
      }

    public function edit_comment($id, $design_id) {
      if ($this->input->post('submit')) {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('comment','Comment','trim|required');
        if ($this->form_validation->run() == TRUE) {
          $comment = $this->input->post('comment'); 
          $this->load->model("design_request_model");
          $this->design_request_model->edit_comment($id, $comment);
          $this->design_request_model->update_state($design_id, 4);
        }
        redirect('design_request/design_stage/'.$design_id);
      }
    }

  }

?>