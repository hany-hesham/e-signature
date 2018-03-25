<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  class upgrad extends CI_Controller {

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
      $this->data['menu']['active'] = "frontoffice";
    }

    public function index() {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        $this->load->model('hotels_model');
        $this->load->model('upgrad_model');
        $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
        $hotels = array();
        foreach ($user_hotels as $hotel) {
          $hotels[] = $hotel['id'];
        }  
        $this->data['upgrad'] = $this->upgrad_model->view($hotels);
        foreach ($this->data['upgrad'] as $key => $up) {
          $this->data['upgrad'][$key]['approvals'] = $this->upgrad_model->get_by_verbals($this->data['upgrad'][$key]['id']);
          $this->data['upgrad'][$key]['rooms'] = $this->upgrad_model->get_room($this->data['upgrad'][$key]['id']);
        } 
        $this->data['hotels'] = $user_hotels;
        $this->load->view('upgrad_index', $this->data);
      }
    }

    public function index_app() {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        $this->load->model('hotels_model');
        $this->load->model('upgrad_model');
        $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
        $hotels = array();
        foreach ($user_hotels as $hotel) {
          $hotels[] = $hotel['id'];
        }  
        $this->data['upgrad'] = $this->upgrad_model->view_app($hotels);
        foreach ($this->data['upgrad'] as $key => $up) {
          $this->data['upgrad'][$key]['approvals'] = $this->upgrad_model->get_by_verbals($this->data['upgrad'][$key]['id']);
          $this->data['upgrad'][$key]['rooms'] = $this->upgrad_model->get_room($this->data['upgrad'][$key]['id']);
        } 
        $this->data['hotels'] = $user_hotels;
        $this->load->view('upgrad_index', $this->data);
      }
    }

    public function index_wat() {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        $this->load->model('hotels_model');
        $this->load->model('upgrad_model');
        $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
        $hotels = array();
        foreach ($user_hotels as $hotel) {
          $hotels[] = $hotel['id'];
        }  
        $this->data['upgrad'] = $this->upgrad_model->view_wat($hotels);
        foreach ($this->data['upgrad'] as $key => $up) {
          $this->data['upgrad'][$key]['approvals'] = $this->upgrad_model->get_by_verbals($this->data['upgrad'][$key]['id']);
          $this->data['upgrad'][$key]['rooms'] = $this->upgrad_model->get_room($this->data['upgrad'][$key]['id']);
        } 
        $this->data['hotels'] = $user_hotels;
        $this->load->view('upgrad_index', $this->data);
      }
    }

    public function index_rej() {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        $this->load->model('hotels_model');
        $this->load->model('upgrad_model');
        $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
        $hotels = array();
        foreach ($user_hotels as $hotel) {
          $hotels[] = $hotel['id'];
        }  
        $this->data['upgrad'] = $this->upgrad_model->view_rej($hotels);
        foreach ($this->data['upgrad'] as $key => $up) {
          $this->data['upgrad'][$key]['approvals'] = $this->upgrad_model->get_by_verbals($this->data['upgrad'][$key]['id']);
          $this->data['upgrad'][$key]['rooms'] = $this->upgrad_model->get_room($this->data['upgrad'][$key]['id']);
        } 
        $this->data['hotels'] = $user_hotels;
        $this->load->view('upgrad_index', $this->data);
      }
    }

    public function add() {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        if ($this->input->post('submit')) {
          $this->load->library('form_validation');
          $this->load->library('email');
          $this->form_validation->set_rules('hotel_id','Hotel Name','trim|required');
          $this->form_validation->set_rules('room','Room Number/s','trim|required');
          if ($this->form_validation->run() == TRUE) {
            $this->load->model('upgrad_model');
            $this->load->model('users_model');  
            $data = array(
              'user_id' => $this->data['user_id'],
              'hotel_id' => $this->input->post('hotel_id'),
              'date' => $this->input->post('date')
            );
            $up_id = $this->upgrad_model->create_upgrad($data);
            if (!$up_id) {
              die("ERROR");
            }
            $room = $this->input->post('room');
            $rooms = explode(" ",$room);
            foreach ($rooms as $room) {
              $form_data = array(
                'room' => $room,
                'up_id' => $up_id
              );
              $room_id = $this->upgrad_model->create_room($form_data);
              if (!$room_id) {
                  die("ERROR");
              }
            }
            redirect('/upgrad/submit/'.$up_id);
          }
        }
        try {
          $this->load->helper('form');
          $this->load->model('upgrad_model');
          $this->load->model('hotels_model');
          $this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());
          $this->load->view('upgrad_add',$this->data);
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
      }
    }

    public function submit($up_id) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        if ($this->input->post('submit')) {
          $this->load->library('form_validation');
          $this->load->library('email');
          if ($this->form_validation->run() == FALSE) {
            $this->load->model('upgrad_model');
            $this->load->model('users_model'); 
            foreach ($this->input->post('rooms') as $room) {
              $room['up_id'] = $up_id;   
              $this->upgrad_model->update_room($room, $up_id, $room['id']);
            }
            $signatures = $this->upgrad_model->up_sign();
            $do_sign = $this->upgrad_model->up_do_sign($up_id);
            //die(print_r($do_sign));
            if ($do_sign == 0) {
              foreach ($signatures as $up_signature) {
                $this->upgrad_model->add_signature($up_id, $up_signature['role'], $up_signature['department'], $up_signature['rank']);
              }
            }
            redirect('/upgrad/upgrad_stage/'.$up_id);
          }   
        }
        try {
          $this->load->helper('form');
          $this->load->model('upgrad_model');
          $this->load->model('hotels_model');
          $this->data['upgrad'] = $this->upgrad_model->get_upgrad($up_id);
          $this->data['rooms'] = $this->upgrad_model->get_rooms($up_id);
          foreach ($this->data['rooms'] as $key => $rooms) {
            $this->data['rooms'][$key]['contacts'] = $this->upgrad_model->get_by_room($this->data['rooms'][$key]['room'], $this->data['upgrad']['hotel_id']);
          }
          $this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());
          $this->data['operators'] = $this->upgrad_model->getall_operator();
          $this->data['reasons'] = $this->upgrad_model->getall_reason();
          $this->data['room_types'] = $this->upgrad_model->getall_room_type();
          $this->data['rooms_types'] = $this->upgrad_model->getall_rooms_type();
          $this->data['uploads'] = $this->upgrad_model->get_by_fille($up_id);
          $this->load->view('upgrad_add_new',$this->data);
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
      }
    }

    public function submit_exp() {
    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
    }else{
      if ($this->input->post('submit')) {
        $this->load->library('form_validation');
        $this->load->library('email');
        $assumed_id = $this->input->post('assumed_id');  
        $this->form_validation->set_rules('hotel_id','Hotel Name','trim|required');
        if ($this->form_validation->run() == TRUE) {
          $this->load->model('upgrad_model');
          $this->load->model('users_model');  
          $datas = array(
            'user_id' => $this->data['user_id'],
            'hotel_id' => $this->input->post('hotel_id'),
            'date' => $this->input->post('date')
          );
            $up_id = $this->upgrad_model->create_upgrad($datas);       
            if ($up_id) {
            $this->load->model('upgrad_model');
            $this->upgrad_model->update_files($assumed_id,$up_id);
          } else {
            die("ERROR");//@TODO failure view
          }
          foreach ($this->input->post('rooms') as $room) {
            $room['up_id'] = $up_id;
            $room_id = $this->upgrad_model->create_room($room);
            if (!$room_id) {
              die("ERROR");
            }
          }
          $signatures = $this->upgrad_model->up_sign();
          $do_sign = $this->upgrad_model->up_do_sign($up_id);
            //die(print_r($do_sign));
            if ($do_sign == 0) {
              foreach ($signatures as $up_signature) {
                $this->upgrad_model->add_signature($up_id, $up_signature['role'], $up_signature['department'], $up_signature['rank']);
              }
            }
          redirect('/upgrad/upgrad_stage/'.$up_id);
        }   
      }
      try {
        $this->load->helper('form');
        $this->load->model('upgrad_model');
        $this->load->model('hotels_model');
        $this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());
        $this->data['operators'] = $this->upgrad_model->getall_operator();
        $this->data['reasons'] = $this->upgrad_model->getall_reason();
        $this->data['room_types'] = $this->upgrad_model->getall_room_type();
        $this->data['rooms_types'] = $this->upgrad_model->getall_rooms_type();
        if ($this->input->post('submit')) {
          $this->load->model('upgrad_model');
          $this->data['assumed_id'] = $this->input->post('assumed_id');
          $this->data['uploads'] = $this->upgrad_model->getby_fille($this->data['assumed_id']);
        } else {
          $this->data['assumed_id'] = strtoupper(str_pad(dechex( mt_rand( 0, 1048575 ) ), 5, '0', STR_PAD_LEFT));
          $this->data['uploads'] = array();
        }
        $this->load->view('upgrad_add_new_exp',$this->data);
      }
      catch( Exception $e) {
        show_error($e->getMessage()." _ ". $e->getTraceAsString());
      }
    }
  }

    public function upgrad_stage($up_id) {
      $this->load->model('upgrad_model');
      $this->data['upgrad'] = $this->upgrad_model->get_upgrad($up_id);
      if ($this->data['upgrad']['state_id'] == 0) {
        $this->upgrad_model->update_state($up_id, 1);
        redirect('/upgrad/upgrad_stage/'.$up_id);
      } elseif ($this->data['upgrad']['state_id'] == 1 ){
        $queue = $this->notify_signers($up_id, $this->data['upgrad']['hotel_id']);
        if (!$queue) {
          $this->upgrad_model->update_state($up_id, 2);
          $user = $this->users_model->get_user_by_id($this->data['upgrad']['user_id'], TRUE);
          $queue = $this->approvel_mail($user->fullname, $user->email, $up_id);
          redirect('/upgrad/upgrad_stage/'.$up_id);
        }
      }elseif ($this->data['upgrad']['state_id'] == 3){
        $user = $this->users_model->get_user_by_id($this->data['upgrad']['user_id'], TRUE);
        $queue = $this->reject_mail($user->fullname, $user->email, $up_id);
      }
      redirect('/upgrad/view/'.$up_id);
    }

    private function notify_signers($up_id, $hotel_id) {
      $notified = FALSE;
      $signers = $this->get_signers($up_id, $hotel_id);
      foreach ($signers as $signer) {
        if (isset($signer['queue'])) {
          $notified = TRUE;
          foreach ($signer['queue'] as $uid => $user) {
            $this->signatures_mail($signer['role'], $signer['department'], $user['name'], $user['mail'], $up_id);
          }
          break;
        }
      }
      return $notified;
    }

    private function get_signers($up_id, $hotel_id) {
      $this->load->model('upgrad_model');
      $signatures = $this->upgrad_model->get_by_verbal($up_id);
      return $this->roll_signers($signatures, $hotel_id, $up_id);
    }

    private function roll_signers($signatures, $hotel_id, $up_id) {
      $signers = array();
      $this->load->model('users_model');
      $this->load->model('upgrad_model');
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
            $this->upgrad_model->update_state($up_id, 3);
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
          $users = $this->users_model->getby_criteria($signature['role_id'], $hotel_id, $signature['department_id']);
          foreach ($users as $use) {
            $signers[$signature['id']]['queue'][$use['id']] = array();
            $signers[$signature['id']]['queue'][$use['id']]['name'] = $use['fullname'];
            $signers[$signature['id']]['queue'][$use['id']]['mail'] = $use['email'];
          }
        }
      }
      return $signers;
    }

    private function signatures_mail($role, $department, $name, $mail, $up_id) {
      $this->load->library('email');
      $this->load->helper('url');
      $up_url = base_url().'upgrad/view/'.$up_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($mail);
      $this->email->subject("Free Room Upgrading Form No. #{$up_id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
        Free Room Upgrading Form No. #{$up_id} requires your signature, Please use the link below:
        <br/>
        <a href='{$up_url}' target='_blank'>{$up_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
    }

    private function approvel_mail($name, $email, $up_id) {
      $this->load->library('email');
      $this->load->helper('url');
      $up_url = base_url().'upgrad/view/'.$up_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($email);
      $this->email->subject("Free Room Upgrading Form No. #{$up_id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
        Free Room Upgrading Form No. #{$up_id} has been approved, Please use the link below:
        <br/>
        <a href='{$up_url}' target='_blank'>{$up_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
    }

    private function reject_mail($name, $email, $up_id) {
      $this->load->library('email');
      $this->load->helper('url');
      $up_url = base_url().'upgrad/view/'.$up_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($email);
      $this->email->subject("Free Room Upgrading Form No. #{$up_id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
        Free Room Upgrading Form No. #{$up_id} has been rejected, Please use the link below:
        <br/>
        <a href='{$up_url}' target='_blank'>{$up_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
    }

    public function upload($up_id) {
      $file_name = $this->do_upload("upload");
      if (!$file_name) {
        die(json_encode($this->data['error']));
      } else {
        $this->load->model("upgrad_model");
        $this->upgrad_model->add_fille($up_id, $file_name, $this->data['user_id']);
        die("{}");
      }
    }

    public function remove($up_id, $id) {
      $file_name = $_POST['key'];
      if (!$id) {
        die(json_encode($this->data['error']));
      } else {
        $this->load->model("upgrad_model");
        $this->upgrad_model->remove_fille($id);
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

    public function view($up_id) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{      
        $this->load->model('upgrad_model');
        $this->load->model('hotels_model');   
        $this->data['upgrad'] = $this->upgrad_model->get_upgrad($up_id);
        $this->data['rooms'] = $this->upgrad_model->get_rooms($up_id);
        $this->data['uploads'] = $this->upgrad_model->get_by_fille($up_id);
        $this->data['comments'] = $this->upgrad_model->get_comment($up_id);
        $this->data['signature_path'] = '/assets/uploads/signatures/';
        $this->data['signers'] = $this->get_signers($this->data['upgrad']['id'], $this->data['upgrad']['hotel_id']);
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
          if ( $this->data['upgrad']['user_id'] == $this->data['user_id'] &&  $this->data['upgrad']['state_id'] != 2) {
            $editor = TRUE;
          }
        }
        if (isset($this->data['department_id'])) {
          if ($this->data['department_id'] == 18 &&  $this->data['upgrad']['state_id'] != 2) {
            $editor = TRUE;
          }
        }
        $this->data['unsign_enable'] = (($unsign_enable) || $this->data['is_admin'])? TRUE : FALSE;
        $this->data['is_editor'] = (($editor) || $this->data['is_admin'] || $this->data['user_id'] == 396)? TRUE : FALSE;
        $this->load->view('upgrad_view', $this->data);
      }
    }

    public function edit($up_id) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{          
        if ($this->input->post('submit')) {
          $this->load->library('form_validation');
          $this->load->library('email');
          if ($this->form_validation->run() == FALSE) {
            $this->load->model('upgrad_model');
            $this->load->model('users_model');  
            $form_data = array(
              'date' => $this->input->post('date')
            );
            $this->upgrad_model->update_upgrad($form_data, $up_id);
            foreach ($this->input->post('rooms') as $room) {
              $room['up_id'] = $up_id;  
              $this->upgrad_model->update_room($room, $up_id, $room['id']);
            }
            redirect('/upgrad/view/'.$up_id);
          }   
        }
        try {
          $this->load->helper('form');
          $this->load->model('upgrad_model');
          $this->load->model('hotels_model');
          $this->data['upgrad'] = $this->upgrad_model->get_upgrad($up_id);
          $this->data['rooms'] = $this->upgrad_model->get_rooms($up_id);
          $this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());
          $this->data['operators'] = $this->upgrad_model->getall_operator();
          $this->data['reasons'] = $this->upgrad_model->getall_reason();
          $this->data['room_types'] = $this->upgrad_model->getall_room_type();
          $this->data['rooms_types'] = $this->upgrad_model->getall_rooms_type();
          $this->data['uploads'] = $this->upgrad_model->get_by_fille($up_id);
          $this->load->view('upgrad_edit',$this->data);
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
      }
    }

    public function mail_me($up_id) {
      $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
      $this->load->library('email');
      $this->load->helper('url');
      $up_url = base_url().'upgrad/view/'.$up_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($user->email);
      $this->email->subject("Free Room Upgrading Form NO.#{$up_id}");
      $this->email->message("Free Room Upgrading Form NO.#{$up_id}:
        <br/>
        Please use the link below to view The Free Room Upgrading Form:
        <a href='{$up_url}' target='_blank'>{$up_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
      redirect('upgrad/view/'.$up_id);
    }

    public function mail($up_id) {
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
          $up_url = base_url().'upgrad/view/'.$up_id;
          $this->email->from('e-signature@sunrise-resorts.com');
          $this->email->to($email);
          $this->email->subject("A message from {$user->fullname}, Free Room Upgrading Form No. #{$up_id}");
          $this->email->message("{$user->fullname} sent you a private message regarding Free Room Upgrading Form No. #{$up_id}:
            <br/>
            {$message}
            <br />
            <br />
            Please use the link below to view the RDOS Approval Special Rates Form:
            <a href='{$up_url}' target='_blank'>{$up_url}</a>
            <br/>
          "); 
          $mail_result = $this->email->send();
        }
      }
      redirect('upgrad/view/'.$up_id);
    }

    public function unsign($signature_id) {
      $this->load->model('upgrad_model');
      $this->load->model('users_model');
      $signature_identity = $this->upgrad_model->get_signature_identity($signature_id);
      $this->upgrad_model->unsign($signature_id);
      redirect('/upgrad/upgrad_stage/'.$signature_identity['up_id']);  
    }

    public function sign($signature_id, $reject = FALSE) {
      $this->load->model('upgrad_model');
      $signature_identity = $this->upgrad_model->get_signature_identity($signature_id);
      $signrs = $this->get_signers($signature_identity['up_id'], $signature_identity['hotel_id']);
      $this->data['upgrad'] = $this->upgrad_model->get_upgrad($signature_identity['up_id']);
      if (array_key_exists($this->data['user_id'], $signrs[$signature_id]['queue'])) {
        if ($reject) {
          $this->upgrad_model->reject($signature_id, $this->data['user_id']);
          redirect('/upgrad/upgrad_stage/'.$this->data['upgrad']['id']);  
        } else {
          $this->upgrad_model->sign($signature_id, $this->data['user_id']);
          redirect('/upgrad/upgrad_stage/'.$signature_identity['up_id']);  
        }
      }
      redirect('/upgrad/view/'.$signature_identity['up_id']);
    }

    public function comment($up_id){
      if ($this->input->post('submit')) {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('comment','Comment','trim|required');
        if ($this->form_validation->run() == TRUE) {
          $comment = $this->input->post('comment'); 
          $this->load->model('upgrad_model');
          $comment_data = array(
            'user_id' => $this->data['user_id'],
            'up_id' => $up_id,
            'comment' => $comment
          );
          $this->upgrad_model->insert_comment($comment_data);
        }
        redirect('/upgrad/view/'.$up_id);
      }
    }

  }

?>