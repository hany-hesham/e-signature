<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  class reservations extends CI_Controller {

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

    public function index($state = FALSE) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        $this->load->model('hotels_model');
        $this->load->model('reservations_model');
        $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
        $hotels = array();
        foreach ($user_hotels as $hotel) {
          $hotels[] = $hotel['id'];
        }  
        if (($this->data['role_id']  == 1) || ($this->data['role_id']  == 33) || ($this->data['is_admin'])) {
          $this->data['reservations'] = $this->reservations_model->view_all($hotels, $state);
        }else{
          $this->data['reservations'] = $this->reservations_model->view($hotels, $state);
        }        
        foreach ($this->data['reservations'] as $key => $out) {
          $this->data['reservations'][$key]['approvals'] = $this->reservations_model->get_by_verbals($this->data['reservations'][$key]['id']);
        } 
        $this->data['hotels'] = $user_hotels;
        $this->load->view('reservations_index', $this->data);
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
          $this->form_validation->set_rules('recived_by','Recived By','trim|required');
          $this->form_validation->set_rules('name','Name','trim|required');
          $this->form_validation->set_rules('discount','Discount','trim|required');
          $this->form_validation->set_rules('rate','Rate','trim|required');
          $this->form_validation->set_rules('board_type_id','Board Type','trim|required');
          $this->form_validation->set_rules('arrival','Arrival','trim|required');
          $this->form_validation->set_rules('departure','Departure','trim|required');
          $this->form_validation->set_rules('adult','Adult','trim|required');
          $this->form_validation->set_rules('no_room','Numbuer Room','trim|required');
          $this->form_validation->set_rules('room_type','Room Type','trim|required');
          $this->form_validation->set_rules('agent','Agent/Company','trim|required');
          $this->form_validation->set_rules('res_type_id','Reservation Type','trim|required');
          $this->form_validation->set_rules('res_source_id','Reservation Source','trim|required');
          $assumed_id = $this->input->post('assumed_id');                        
          if ($this->form_validation->run() == TRUE) {
            $this->load->model('reservations_model');
            $this->load->model('users_model');  
            $data = array(
              'user_id' => $this->data['user_id'],
              'hotel_id' => $this->input->post('hotel_id'),
              'recived_by' => $this->input->post('recived_by'),
              'name' => $this->input->post('name'),
              'discount' => $this->input->post('discount'),
              'rate' => $this->input->post('rate'),
              'currency' => $this->input->post('currency'),
              'board_type_id' => $this->input->post('board_type_id'),
              'arrival' => $this->input->post('arrival'),
              'departure' => $this->input->post('departure'),
              'adult' => $this->input->post('adult'),
              'child' => $this->input->post('child'),
              'no_room' => $this->input->post('no_room'),
              'room_type' => $this->input->post('room_type'),
              'agent' => $this->input->post('agent'),
              'res_type_id' => $this->input->post('res_type_id'),
              'res_source_id' => $this->input->post('res_source_id'),
              'remarks' => $this->input->post('remarks')
            );
            $res_id = $this->reservations_model->create_reservation($data);
            if ($res_id) {
              $this->reservations_model->update_files($assumed_id,$res_id);
            } else {
              die("ERROR");
            }
            $signatures = $this->reservations_model->res_sign($data['res_source_id']);
            $do_sign = $this->reservations_model->res_do_sign($res_id);
            if ($do_sign == 0) {
              foreach ($signatures as $res_signature) {
                $this->reservations_model->add_signature($res_id, $res_signature['role'], $res_signature['department'], $res_signature['rank']);
              }
            }
            redirect('/reservations/res_stage/'.$res_id);
          }
        }
        try {
          $this->load->helper('form');
          $this->load->model('reservations_model');
          $this->load->model('hotels_model');
          $this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
          $this->data['boards'] = $this->reservations_model->get_board_types();
          $this->data['res_sources'] = $this->reservations_model->get_res_sources();
          $this->data['res_types'] = $this->reservations_model->get_res_types();
          if ($this->input->post('submit')) {
            $this->data['assumed_id'] = $this->input->post('assumed_id');
            $this->data['uploads'] = $this->reservations_model->get_by_fille($this->data['assumed_id']);
          } else {
            $this->data['assumed_id'] = strtoupper(str_pad(dechex( mt_rand( 1048575, 10485751048575 ) ), 5, '0', STR_PAD_LEFT));
            $this->data['uploads'] = array();
          }
          $this->load->view('reservations_add_new',$this->data);
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
      }
    }

    public function res_stage($res_id) {
      $this->load->model('reservations_model');
      $this->data['reservation'] = $this->reservations_model->get_reservation($res_id);
      if ($this->data['reservation']['state_id'] == 0) {
        $this->reservations_model->update_state($res_id, 1);
        redirect('/reservations/res_stage/'.$res_id);
      }elseif ($this->data['reservation']['state_id'] == 3){
        $user = $this->users_model->get_user_by_id($this->data['reservation']['user_id'], TRUE);
        $this->reject_mail($user->fullname, $user->email, $res_id);
      }elseif ($this->data['reservation']['state_id'] != 2){
        $queue = $this->notify_signers($res_id, $this->data['reservation']['hotel_id']);
        if (!$queue) {
          $this->reservations_model->update_state($res_id, 2);
          $user = $this->users_model->get_user_by_id($this->data['reservation']['user_id'], TRUE);
          $this->approvel_mail($user->fullname, $user->email, $res_id);
          redirect('/reservations/res_stage/'.$res_id);
        }
      }
      redirect('/reservations/view/'.$res_id);
    }

    private function reject_mail($name, $email, $res_id) {
      $this->load->library('email');
      $this->load->helper('url');
      $res_url = base_url().'reservations/view/'.$res_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($email);
      $this->email->subject("Reservation Form No. #{$res_id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
        Reservation Form No. #{$res_id} has been rejected, Please use the link below:
        <br/>
        <a href='{$res_url}' target='_blank'>{$res_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
    }

    private function notify_signers($res_id, $hotel_id) {
      $notified = FALSE;
      $res_url = base_url().'reservations/view/'.$res_id;
      $message = "Reservation Form No. {$res_id}:
        {$res_url}";
      $signers = $this->get_signers($res_id, $hotel_id);
      foreach ($signers as $signer) {
        if (isset($signer['queue'])) {
          $notified = TRUE;
          foreach ($signer['queue'] as $uid => $user) {
            $this->onclick($message, $res_id, $user['channel']);
            $this->signatures_mail($signer['role'], $signer['department'], $user['name'], $user['mail'], $res_id);
          }
          break;
        }
      }
      return $notified;
    }

    private function get_signers($res_id, $hotel_id) {
      $this->load->model('reservations_model');
      $signatures = $this->reservations_model->get_by_verbal($res_id);
      return $this->roll_signers($signatures, $hotel_id, $res_id);
    }

    private function roll_signers($signatures, $hotel_id, $res_id) {
      $signers = array();
      $this->load->model('users_model');
      $this->load->model('reservations_model');
      $reservation = $this->reservations_model->get_reservation($res_id);
      foreach ($signatures as $signature) {
        $signers[$signature['id']] = array();
        $signers[$signature['id']]['role'] = $signature['role'];
        $signers[$signature['id']]['role_id'] = $signature['role_id'];
        $signers[$signature['id']]['department'] = $signature['department'];
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
          if ($signature['role_id'] == 1) {
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
          } if ($signature['role_id'] == 6 && $hotel_id==5) {
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
              }  else {
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

    private function signatures_mail($role, $department, $name, $mail, $res_id) {
      $this->load->library('email');
      $this->load->helper('url');
      $res_url = base_url().'reservations/view/'.$res_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($mail);
      $this->email->subject("Reservation Form No. #{$res_id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
        Reservation Form No. #{$res_id} requires your signature, Please use the link below:
        <br/>
        <a href='{$res_url}' target='_blank'>{$res_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
    }

    private function approvel_mail($name, $email, $res_id) {
      $this->load->library('email');
      $this->load->helper('url');
      $res_url = base_url().'reservations/view/'.$res_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($email);
      $this->email->subject("Reservation Form No. #{$res_id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
        Reservation Form No. #{$res_id} has been approved, Please use the link below:
        <br/>
        <a href='{$res_url}' target='_blank'>{$res_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
    }

    public function view($res_id) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{      
        $this->load->model('reservations_model');
        $this->load->model('hotels_model');   
        $this->data['reservation'] = $this->reservations_model->get_reservation($res_id);
        $this->data['uploads'] = $this->reservations_model->get_by_fille($res_id);
        $this->data['comments'] = $this->reservations_model->get_comment($res_id);
        $this->data['signature_path'] = '/assets/uploads/signatures/';
        $this->data['signers'] = $this->get_signers($this->data['reservation']['id'], $this->data['reservation']['hotel_id']);
        $editor = FALSE;
        $abeer=FALSE;
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
          if (isset($signer['sign'])) {
            $first = FALSE;
          }
        }
        if (isset($this->data['user_id'])) {
          if ( ($this->data['reservation']['user_id'] == $this->data['user_id'] || $this->data['user_id'] == 178)) {
            $editor = TRUE;
          }
        }
         if(isset($this->data['role_id']) || isset($this->data['user_id'])){
          if (($this->data['role_id'] == 2) || ($this->data['role_id'] ==83 ) ||
            ($this->data['user_id']==219) ) {
            $abeer = TRUE;
          }
        }
        $this->data['unsign_enable'] = (($unsign_enable) || $this->data['is_admin'])? TRUE : FALSE;
         $this->data['abeer'] = ($abeer)? TRUE : FALSE;
        $this->data['is_editor'] = (($editor) || $this->data['is_admin'])? TRUE : FALSE;
        $this->data['first'] = $first;
        //die(print_r($this->data['first']));
        $this->load->view('reservations_view', $this->data);
      }
    }

    public function upload($res_id) {
      $file_name = $this->do_upload("upload");
      if (!$file_name) {
        die(json_encode($this->data['error']));
      } else {
        $this->load->model("reservations_model");
        $this->reservations_model->add_fille($res_id, $file_name, $this->data['user_id']);
        die("{}");
      }
    }

    public function remove($res_id, $id) {
      $file_name = $_POST['key'];
      if (!$id) {
        die(json_encode($this->data['error']));
      } else {
        $this->load->model("reservations_model");
        $this->reservations_model->remove_fille($id);
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

    public function edit($res_id) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        if ($this->input->post('submit')) {
          $this->load->library('form_validation');
          $this->load->library('email');
          $this->form_validation->set_rules('hotel_id','Hotel Name','trim|required');
          $this->form_validation->set_rules('recived_by','Recived By','trim|required');
          $this->form_validation->set_rules('name','Name','trim|required');
          $this->form_validation->set_rules('discount','Discount','trim|required');
          $this->form_validation->set_rules('rate','Rate','trim|required');
          $this->form_validation->set_rules('board_type_id','Board Type','trim|required');
          $this->form_validation->set_rules('arrival','Arrival','trim|required');
          $this->form_validation->set_rules('departure','Departure','trim|required');
          $this->form_validation->set_rules('adult','Adult','trim|required');
          $this->form_validation->set_rules('no_room','Numbuer Room','trim|required');
          $this->form_validation->set_rules('room_type','Room Type','trim|required');
          $this->form_validation->set_rules('agent','Agent/Company','trim|required');
          $this->form_validation->set_rules('res_type_id','Reservation Type','trim|required');
          $this->form_validation->set_rules('res_source_id','Reservation Source','trim|required');
          if ($this->form_validation->run() == TRUE) {
            $this->load->model('reservations_model');
            $this->load->model('users_model');  
            $data = array(
              'hotel_id' => $this->input->post('hotel_id'),
              'recived_by' => $this->input->post('recived_by'),
              'name' => $this->input->post('name'),
              'discount' => $this->input->post('discount'),
              'rate' => $this->input->post('rate'),
              'currency' => $this->input->post('currency'),
              'board_type_id' => $this->input->post('board_type_id'),
              'arrival' => $this->input->post('arrival'),
              'departure' => $this->input->post('departure'),
              'adult' => $this->input->post('adult'),
              'child' => $this->input->post('child'),
              'no_room' => $this->input->post('no_room'),
              'room_type' => $this->input->post('room_type'),
              'agent' => $this->input->post('agent'),
              'res_type_id' => $this->input->post('res_type_id'),
              'res_source_id' => $this->input->post('res_source_id'),
              'remarks' => $this->input->post('remarks')
            );
            $this->reservations_model->update_reservation($res_id, $data);
            redirect('/reservations/view/'.$res_id);
          }   
        }
        try {
          $this->load->helper('form');
          $this->load->model('reservations_model');
          $this->load->model('hotels_model');
          $this->data['reservation'] = $this->reservations_model->get_reservation($res_id);
          $this->data['uploads'] = $this->reservations_model->get_by_fille($res_id);
          $this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
          $this->data['boards'] = $this->reservations_model->get_board_types();
          $this->data['res_sources'] = $this->reservations_model->get_res_sources();
          $this->data['res_types'] = $this->reservations_model->get_res_types();
          $this->load->view('reservations_edit',$this->data);
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
      }
    }

    public function mail_me($res_id) {
      $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
      $this->load->library('email');
      $this->load->helper('url');
      $res_url = base_url().'reservations/view/'.$res_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($user->email);
      $this->email->subject("Reservation Form No. #{$res_id}");
      $this->email->message("Reservation Form NO.#{$res_id}:
        <br/>
        Please use the link below to view The Reservation Form:
        <a href='{$res_url}' target='_blank'>{$res_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
      redirect('reservations/view/'.$res_id);
    }

    public function mail($res_id) {
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
          $res_url = base_url().'reservations/view/'.$res_id;
          $this->email->from('e-signature@sunrise-resorts.com');
          $this->email->to($email);
          $this->email->subject("A message from {$user->fullname}, Reservation Form No. #{$res_id}");
          $this->email->message("{$user->fullname} sent you a private message regarding Reservation Form No. #{$res_id}:
            <br/>
            {$message}
            <br />
            <br />
            Please use the link below to view the Reservation Form:
            <a href='{$res_url}' target='_blank'>{$res_url}</a>
            <br/>
          "); 
          $mail_result = $this->email->send();
        }
      }
      redirect('reservations/view/'.$res_id);
    }

    public function share_url($res_id) {
      if ($this->input->post('submit')) {
        $message = $this->input->post('message');
        $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
        $res_url = base_url().'reservations/view/'.$res_id;
        $messages = "{$user->fullname} Reservation Form No. {$res_id}
          {$res_url}"; 
          $this->load->model('reservations_model');
        $this->data['reservation'] = $this->reservations_model->get_reservation($res_id);
        $this->deletonclick($this->data['reservation']['message_id']);
        $this->onclick($messages, $res_id, $this->config->item('page_to_send'));
      }
      redirect('reservations/view/'.$res_id);
    }

    public function unsign($signature_id) {
      $this->load->model('reservations_model');
      $this->load->model('users_model');
      $signature_identity = $this->reservations_model->get_signature_identity($signature_id);
      $this->reservations_model->update_state($signature_identity['res_id'], 1);
      $this->reservations_model->unsign($signature_id);
      redirect('/reservations/res_stage/'.$signature_identity['res_id']);  
    }

    public function sign($signature_id, $reject = FALSE) {
      $this->load->model('reservations_model');
      $signature_identity = $this->reservations_model->get_signature_identity($signature_id);
      $signrs = $this->get_signers($signature_identity['res_id'], $signature_identity['hotel_id']);
      $this->data['reservations'] = $this->reservations_model->get_reservation($signature_identity['res_id']);
      $res_url = base_url().'reservations/view/'.$signature_identity['res_id'];
      $message_id = $this->data['reservations']['message_id'];
      $id = $signature_identity['res_id'];
      $message = "Reservation Form No. {$id}:
          {$res_url}";
      if (array_key_exists($this->data['user_id'], $signrs[$signature_id]['queue'])) {
        if ($signature_identity['role_id'] == 1) {
          $this->deletonclick($message_id);
          $this->onclick1($message);
        }
        if ($reject) {
          $this->reservations_model->reject($signature_id, $this->data['user_id']);
          $this->reservations_model->update_state($signature_identity['res_id'], 3);
          redirect('/reservations/res_stage/'.$signature_identity['res_id']);  
        } else {
          $this->reservations_model->sign($signature_id, $this->data['user_id']);
          //die(print_r($signature_id));
          redirect('/reservations/res_stage/'.$signature_identity['res_id']);  
        }
      }
      redirect('/reservations/view/'.$signature_identity['res_id']);
    }

    public function comment($res_id){
      if ($this->input->post('submit')) {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('comment','Comment','trim|required');
        if ($this->form_validation->run() == TRUE) {
          $comment = $this->input->post('comment'); 
          $this->load->model('reservations_model');
          $comment_data = array(
            'user_id' => $this->data['user_id'],
            'res_id' => $res_id,
            'comment' => $comment
          );
          $this->reservations_model->insert_comment($comment_data);
          if ($this->data['role_id'] == 217) {
            $this->chairman_mail($res_id);
          }
        }
        redirect('/reservations/view/'.$res_id);
      }
    }

    private function chairman_mail($res_id) {
          $this->load->library('email');
          $this->load->helper('url');
          $res_url = base_url().'reservations/view/'.$res_id;
          $this->email->from('e-signature@sunrise-resorts.com');
          $this->email->to('abeer@sunrise.eg');
          $this->email->subject("Reservation Form No. #{$res_id}");
          $this->email->message("Dear Madam Abber,
            <br/>
            <br/>
            Mr Hossam Commented on Reservation Form No. #{$res_id}, Please use the link below:
            <br/>
            <a href='{$res_url}' target='_blank'>{$res_url}</a>
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
      $this->load->model('reservations_model');
      $this->reservations_model->update_message_id($id, $channel_result);
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