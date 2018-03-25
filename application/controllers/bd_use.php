<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  class bd_use extends CI_Controller {

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
        $this->load->model('bd_use_model');
        $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
        $hotels = array();
        foreach ($user_hotels as $hotel) {
          $hotels[] = $hotel['id'];
        }  
        $this->data['use'] = $this->bd_use_model->view($hotels);
        foreach ($this->data['use'] as $key => $use) {
          $this->data['use'][$key]['approvals'] = $this->bd_use_model->getby_verbals($this->data['use'][$key]['id']);
          $this->data['use'][$key]['items'] = $this->bd_use_model->get_itemss($this->data['use'][$key]['id']);
        } 
        $this->data['hotels'] = $user_hotels;
        $this->load->view('bd_use_index', $this->data);
      }
    }

    public function index_app() {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        $this->load->model('hotels_model');
        $this->load->model('bd_use_model');
        $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
        $hotels = array();
        foreach ($user_hotels as $hotel) {
          $hotels[] = $hotel['id'];
        }  
        $this->data['use'] = $this->bd_use_model->view_app($hotels);
        foreach ($this->data['use'] as $key => $use) {
          $this->data['use'][$key]['approvals'] = $this->bd_use_model->getby_verbals($this->data['use'][$key]['id']);
          $this->data['use'][$key]['items'] = $this->bd_use_model->get_itemss($this->data['use'][$key]['id']);
        } 
        $this->data['hotels'] = $user_hotels;
        $this->load->view('bd_use_index', $this->data);
      }
    }

    public function index_rej() {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        $this->load->model('hotels_model');
        $this->load->model('bd_use_model');
        $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
        $hotels = array();
        foreach ($user_hotels as $hotel) {
          $hotels[] = $hotel['id'];
        }  
        $this->data['use'] = $this->bd_use_model->view_rej($hotels);
        foreach ($this->data['use'] as $key => $use) {
          $this->data['use'][$key]['approvals'] = $this->bd_use_model->getby_verbals($this->data['use'][$key]['id']);
          $this->data['use'][$key]['items'] = $this->bd_use_model->get_itemss($this->data['use'][$key]['id']);
        } 
        $this->data['hotels'] = $user_hotels;
        $this->load->view('bd_use_index', $this->data);
      }
    }

    public function index_wat() {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        if ($this->input->post('submit')) {
          $state = $this->input->post('state');
          $this->load->model('hotels_model');
          $this->load->model('bd_use_model');
          $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
          $hotels = array();
          foreach ($user_hotels as $hotel) {
            $hotels[] = $hotel['id'];
          }  
          $this->data['use'] = $this->bd_use_model->view_wat($hotels, $state);
          foreach ($this->data['use'] as $key => $use) {
            $this->data['use'][$key]['approvals'] = $this->bd_use_model->getby_verbals($this->data['use'][$key]['id']);
            $this->data['use'][$key]['items'] = $this->bd_use_model->get_itemss($this->data['use'][$key]['id']);
          } 
          $this->data['state'] = $state;
        }
        $this->data['hotels'] = $user_hotels;
        $this->load->view('bd_use_index_wat', $this->data);
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
          $this->form_validation->set_rules('room','Room Number','trim|required');
          if ($this->form_validation->run() == TRUE) {
            $this->load->model('bd_use_model');
            $this->load->model('users_model');  
            $datas = array(
              'user_id' => $this->data['user_id'],
              'hotel_id' => $this->input->post('hotel_id'),
              'type_id' => $this->input->post('type_id')
            );
            $use_id = $this->bd_use_model->create_use($datas);
            if (!$use_id) {
              die("ERROR");
            }
            $room = $this->input->post('room');
            $rooms = explode(" ",$room);
            foreach ($rooms as $room) {
              $form_data = array(
                'room' => $room,
                'use_id' => $use_id
              );
              $item_id = $this->bd_use_model->create_room($form_data);
              if (!$item_id) {
                die("ERROR");
              }
            }
            redirect('/bd_use/submit/'.$use_id);
          }
        }
        try {
          $this->load->helper('form');
          $this->load->model('bd_use_model');
          $this->load->model('hotels_model');
          $this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());
          $this->data['types'] = $this->bd_use_model->get_types();
          $this->load->view('bd_use_add',$this->data);
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
      }
    }

    public function submit($use_id) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        if ($this->input->post('submit')) {
          $this->load->library('form_validation');
          $this->load->library('email');
          if ($this->form_validation->run() == FALSE) {
            $this->load->model('bd_use_model');
            $this->load->model('users_model'); 
            foreach ($this->input->post('rooms') as $room) {
              $room['use_id'] = $use_id;  
              $room['user_id'] = $this->data['user_id'];
              $this->bd_use_model->update_room($room, $use_id, $room['id']);
            }
            $signatures = $this->bd_use_model->use_sign();
            $do_sign = $this->bd_use_model->use_do_sign($use_id);
            //die(print_r($do_sign));
            if ($do_sign == 0) {
              foreach ($signatures as $use_signature) {
                $this->bd_use_model->add_signature($use_id, $use_signature['role'], $use_signature['department'], $use_signature['rank']);
              }
            }
            redirect('/bd_use/use_stage/'.$use_id);
          }   
        }
        try {
          $this->load->helper('form');
          $this->load->model('bd_use_model');
          $this->load->model('hotels_model');
          $this->data['use'] = $this->bd_use_model->get_use($use_id);
          $this->data['items'] = $this->bd_use_model->get_items($use_id);
          foreach ($this->data['items'] as $key => $items) {
            $this->data['items'][$key]['contacts'] = $this->bd_use_model->getbyroom($this->data['items'][$key]['room'], $this->data['use']['hotel_id']);
          }
          $this->data['operators'] = $this->bd_use_model->get_operators();
          $this->data['uploads'] = $this->bd_use_model->getby_fille($use_id);
          $this->load->view('bd_use_add_new',$this->data);
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
      }
    }

    public function make_offer($use_id) {
      $file_name = $this->do_upload("upload");
      if (!$file_name) {
        die(json_encode($this->data['error']));
      } else {
        $this->load->model("bd_use_model");
        $this->bd_use_model->add($use_id, $file_name, $this->data['user_id']);
        die("{}");
      }
    }

    public function remove_offer($use_id, $id) {
      $file_name = $_POST['key'];
      if (!$id) {
        die(json_encode($this->data['error']));
      } else {
        $this->load->model("bd_use_model");
        $this->bd_use_model->remove($id);
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

    public function add_exp() {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        if ($this->input->post('submit')) {
          $this->load->library('form_validation');
          $this->load->library('email');
          $this->form_validation->set_rules('hotel_id','Hotel Name','trim|required');
          $this->form_validation->set_rules('room','Room Number','trim|required');
          if ($this->form_validation->run() == TRUE) {
            $this->load->model('bd_use_model');
            $this->load->model('users_model');  
            $datas = array(
              'user_id' => $this->data['user_id'],
              'hotel_id' => $this->input->post('hotel_id'),
              'type_id' => $this->input->post('type_id')
            );
            $use_id = $this->bd_use_model->create_use($datas);
            if (!$use_id) {
              die("ERROR");
            }
            $room = $this->input->post('room');
            $rooms = explode(" ",$room);
            foreach ($rooms as $room) {
              $form_data = array(
                'room' => $room,
                'use_id' => $use_id
              );
              $item_id = $this->bd_use_model->create_room($form_data);
              if (!$item_id) {
                die("ERROR");
              }
            }
            redirect('/bd_use/submit_exp/'.$use_id);
          }
        }
        try {
          $this->load->helper('form');
          $this->load->model('bd_use_model');
          $this->load->model('hotels_model');
          $this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());
          $this->data['types'] = $this->bd_use_model->get_types();
          $this->load->view('bd_use_add_exp',$this->data);
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
      }
    }

    public function submit_exp($use_id) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        if ($this->input->post('submit')) {
          $this->load->library('form_validation');
          $this->load->library('email');
          if ($this->form_validation->run() == FALSE) {
            $this->load->model('bd_use_model');
            $this->load->model('users_model'); 
            foreach ($this->input->post('rooms') as $room) {
              $room['use_id'] = $use_id;  
              $room['user_id'] = $this->data['user_id'];
              $this->bd_use_model->update_room($room, $use_id, $room['id']);
            }
            $signatures = $this->bd_use_model->use_sign();
            $do_sign = $this->bd_use_model->use_do_sign($use_id);
            //die(print_r($do_sign));
            if ($do_sign == 0) {
              foreach ($signatures as $use_signature) {
                $this->bd_use_model->add_signature($use_id, $use_signature['role'], $use_signature['department'], $use_signature['rank']);
              }
            }
            redirect('/bd_use/use_stage/'.$use_id);
          }   
        }
        try {
          $this->load->helper('form');
          $this->load->model('bd_use_model');
          $this->load->model('hotels_model');
          $this->data['use'] = $this->bd_use_model->get_use($use_id);
          $this->data['items'] = $this->bd_use_model->get_items($use_id);
          $this->data['operators'] = $this->bd_use_model->get_operators();
          $this->data['uploads'] = $this->bd_use_model->getby_fille($use_id);
          $this->load->view('bd_use_add_new_exp',$this->data);
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
      }
    }

    public function use_stage($use_id) {
      $this->load->model('bd_use_model');
      $this->data['use'] = $this->bd_use_model->get_use($use_id);
      $this->data['items'] = $this->bd_use_model->get_items($use_id);      
      if ($this->data['use']['state_id'] == 0) {
        $this->bd_use_model->update_state($use_id, 1);
        redirect('/bd_use/use_stage/'.$use_id);
      }elseif ($this->data['use']['state_id'] != 0 && $this->data['use']['state_id'] != 2 && $this->data['use']['state_id'] != 3) {
        $queue = $this->notify_signers($use_id, $this->data['use']['hotel_id']);
        if (!$queue) {
          $this->bd_use_model->update_state($use_id, 2);
          $this->notify_done($use_id);
        }
      }elseif ($this->data['use']['state_id'] == 3){
        $user = $this->users_model->get_user_by_id($this->data['use']['user_id'], TRUE);
        $queue = $this->reject_mail($user->fullname, $user->email, $use_id);
      }
      redirect('/bd_use/view/'.$use_id);
    }

    private function notify_signers($use_id) {
      $notified = FALSE;
      $this->load->model('bd_use_model');
      $this->data['use'] = $this->bd_use_model->get_use($use_id);
      $signers = $this->get_signers($use_id, $this->data['use']['hotel_id']);
      foreach ($signers as $signer) {
        if (isset($signer['queue'])) {
          $notified = TRUE;
          foreach ($signer['queue'] as $uid => $user) {
            $this->signatures_mail($signer['role'], $signer['department'], $user['name'], $user['mail'], $use_id);
          }
          break;
        }
      }
      return $notified;
    }

    private function get_signers($use_id, $hotel_id) {
      $this->load->model('bd_use_model');
      $signatures = $this->bd_use_model->getby_verbal($use_id);
      return $this->roll_signers($signatures, $hotel_id, $use_id);
    }

    private function roll_signers($signatures, $hotel_id, $use_id) {
      $signers = array();
      $this->load->model('users_model');
      $this->load->model('bd_use_model');
      foreach ($signatures as $signature) {
        $signers[$signature['id']] = array();
        $signers[$signature['id']]['role'] = $signature['role'];
        $signers[$signature['id']]['role_id'] = $signature['role_id'];
        $signers[$signature['id']]['department'] = $signature['department'];
        $signers[$signature['id']]['department_id'] = $signature['department_id'];
        if ($signature['user_id']) {
          if ($signature['rank'] == 1){
            $this->bd_use_model->update_state($use_id, 4);
          }elseif ($signature['rank'] == 2){
            $this->bd_use_model->update_state($use_id, 5);
          }elseif ($signature['rank'] == 3){
            $this->bd_use_model->update_state($use_id, 6);
          }elseif ($signature['rank'] == 4){
            $this->bd_use_model->update_state($use_id, 2);
          }
          $signers[$signature['id']]['sign'] = array();
          $signers[$signature['id']]['sign']['id'] = $signature['user_id'];
          if ($signature['reject'] == 1) {
            $signers[$signature['id']]['sign']['reject'] = "reject";
            $this->bd_use_model->update_state($use_id, 3);
          } 
          $user = $this->users_model->get_user_by_id($signature['user_id'], TRUE);
          $signers[$signature['id']]['sign']['name'] = $user->fullname;
          $signers[$signature['id']]['sign']['mail'] = $user->email;
          $signers[$signature['id']]['sign']['sign'] = $user->signature;
          $signers[$signature['id']]['sign']['timestamp'] = $signature['timestamp'];
        }else {
          $signers[$signature['id']]['queue'] = array();
          $users = array();
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

    private function signatures_mail($role, $department, $name, $mail, $use_id) {
      $this->load->library('email');
      $this->load->helper('url');
      $use_url = base_url().'bd_use/view/'.$use_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($mail);
      $this->email->subject("Beach/Day Use Request {$use_id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
        Beach/Day Use Request No.#{$use_id} requires your signature, Please use the link below:
        <br/>
        <a href='{$use_url}' target='_blank'>{$use_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
    }

    public function notify_done($use_id) {
      $this->load->model('bd_use_model');
      $this->load->model('users_model');
      $signes = $this->bd_use_model->getby_verbal($use_id);
      $users = array();
      foreach ($signes as $signe){
        if ($signe['user_id'] && $signe['user_id'] != 30) {
          $user = $this->users_model->get_user_by_id($signe['user_id'], TRUE);
          $name = $user->fullname;
          $mail = $user->email;
          $this->load->library('email');
          $this->load->helper('url');
          $use_url = base_url().'bd_use/view/'.$use_id;
          $this->email->from('e-signature@sunrise-resorts.com');
          $this->email->to($mail);
          $this->email->subject("Beach/Day use Request NO.#{$use_id}");
          $this->email->message("Dear {$name},
            <br/>
            <br/>
            Beach/Day use Request NO.#{$use_id} has been approved, Please use the link below:
            <br/>
            <a href='{$use_url}' target='_blank'>{$use_url}</a>
            <br/>
          "); 
          $mail_result = $this->email->send();
        }
      }
      redirect('bd_use/view/'.$use_id);
    }

    private function reject_mail($name, $email, $use_id) {
      $this->load->library('email');
      $this->load->helper('url');
      $use_url = base_url().'bd_use/view/'.$use_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($email);
      $this->email->subject("Beach/Day use Request {$use_id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
        Beach/Day use Request {$use_id} has been rejected, Please use the link below:
        <br/>
        <a href='{$use_url}' target='_blank'>{$use_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
    }

    public function view($use_id) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        $this->load->model('bd_use_model');
        $this->data['use'] = $this->bd_use_model->get_use($use_id);
        $this->data['items'] = $this->bd_use_model->get_items($use_id);      
        $this->data['uploads'] = $this->bd_use_model->getby_fille($use_id);
        $this->data['comments'] = $this->bd_use_model->get_comment($use_id);
        $this->data['signature_path'] = '/assets/uploads/signatures/';
        $this->data['signers'] = $this->get_signers($this->data['use']['id'], $this->data['use']['hotel_id']);
        $editor = FALSE;
        $unsign_enable = FALSE;
        $first = TRUE;
        $force_edit = FALSE;
        foreach ($this->data['signers'] as $signer) {
          if (isset($signer['queue'])) {
            foreach ($signer['queue'] as $uid => $dummy) {
              if ( $uid == $this->data['user_id'] ) {
                $editor = FALSE;
                break;
              }
            }
          } elseif (isset($signer['sign'])) {
            $unsign_enable = FALSE;
            $force_edit = FALSE;
            if ($signer['sign']['id'] == $this->data['user_id']) {
              if ($first) {
                $force_edit = FALSE;
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
          if ( $this->data['use']['user_id'] == $this->data['user_id']) {
            $editor = TRUE;
          }
        }
        $this->data['unsign_enable'] = (($unsign_enable) || $this->data['is_admin'])? TRUE : FALSE;
        $this->data['is_editor'] = ( ($this->data['is_admin'] || $editor) || ($force_edit) )? TRUE : FALSE;
        $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
        $this->data['id'] = $use_id;
        $this->load->view('bd_use_view', $this->data);
      }
    }

    public function edit($use_id) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        if ($this->input->post('submit')) {
          $this->load->library('form_validation');
          $this->load->library('email');
          if ($this->form_validation->run() == FALSE) {
            $this->load->model('bd_use_model');
            $this->load->model('users_model'); 
            $this->data['use'] = $this->bd_use_model->get_use($use_id);
            $form_data = array(
              'type_id' => $this->input->post('type_id')
            );
            $this->bd_use_model->update_use($use_id, $form_data);
            foreach ($this->input->post('rooms') as $room) {
              $room['use_id'] = $use_id;  
              $room['user_id'] = $this->data['user_id'];
              $this->bd_use_model->update_room($room, $use_id, $room['id']);
            }
            if ($this->data['use']['state_id']!='1'){
              $this->notify($use_id);
            } 
            redirect('/bd_use/view/'.$use_id);
          }   
        }
        try {
          $this->load->helper('form');
          $this->load->model('bd_use_model');
          $this->load->model('hotels_model');
          $this->data['use'] = $this->bd_use_model->get_use($use_id);
          $this->data['items'] = $this->bd_use_model->get_items($use_id);      
          $this->data['uploads'] = $this->bd_use_model->getby_fille($use_id);
          $this->data['operators'] = $this->bd_use_model->get_operators();
          $this->data['types'] = $this->bd_use_model->get_types();
          $this->load->view('bd_use_edit',$this->data);
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
      }
    }

    public function notify($use_id) {
      $this->load->model('bd_use_model');
      $this->load->model('users_model');
      $this->data['use'] = $this->bd_use_model->get_use($use_id);
      $signes = $this->bd_use_model->getby_verbal($use_id);
      $users = array();
      foreach ($signes as $signe){
        if ($signe['user_id'] && $signe['user_id'] != 30) {
          $user = $this->users_model->get_user_by_id($signe['user_id'], TRUE);
          $name = $user->fullname;
          $mail = $user->email;
          $this->load->library('email');
          $this->load->helper('url');
          $use_url = base_url().'bd_use/view/'.$use_id;
          $this->email->from('e-signature@sunrise-resorts.com');
          $this->email->to($mail);
          $this->email->subject("Beach/Day Use Request NO.#{$use_id}");
          $this->email->message("Dear {$name},
            <br/>
            <br/>
            Beach/Day Use Request NO.#{$use_id} has been Edited, Please use the link below:
            <br/>
            <a href='{$use_url}' target='_blank'>{$use_url}</a>
            <br/>
          "); 
          $mail_result = $this->email->send();
        }
      }
      redirect('bd_use/view/'.$use_id);
    }

    public function mailme($use_id) {
      $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
      $this->load->library('email');
      $this->load->helper('url');
      $use_url = base_url().'bd_use/view/'.$use_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($user->email);
      $this->email->subject("Beach/Day Use Request NO.#{$use_id}");
      $this->email->message("Beach/Day Use Request NO.#{$use_id}:
        <br/>
        Please use the link below to view the Beach/Day Use Request:
        <a href='{$use_url}' target='_blank'>{$use_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
      redirect('bd_use/view/'.$use_id);
    }

    public function mailto($use_id) {
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
          $use_url = base_url().'bd_use/view/'.$use_id;
          $this->email->from('e-signature@sunrise-resorts.com');
          $this->email->to($email);
          $this->email->subject("A message from {$user->fullname}, Beach/Day Use Request No.{$use_id}");
          $this->email->message("{$user->fullname} sent you a private message regarding Beach/Day Use Request {$use_id}:
            <br/>
            {$message}
            <br />
            <br />
            Please use the link below to view the Beach/Day Use Request:
            <a href='{$use_url}' target='_blank'>{$use_url}</a>
            <br/>
          "); 
          $mail_result = $this->email->send();
        }
      }
      redirect('bd_use/view/'.$use_id);
    }

    public function unsign($signature_id) {
      $this->load->model('bd_use_model');
      $this->load->model('users_model');
      $signature_identity = $this->bd_use_model->get_signature_identity($signature_id);
      $this->bd_use_model->unsign($signature_id);
      $use = $this->bd_use_model->get_use($signature_identity['use_id']);
      redirect('/bd_use/view/'.$signature_identity['use_id']);
    }

    public function sign($signature_id, $reject = FALSE) {
      $this->load->model('bd_use_model');
      $signature_identity = $this->bd_use_model->get_signature_identity($signature_id);
      $signrs = $this->get_signers($signature_identity['use_id'], $signature_identity['hotel_id']);
      $this->data['use'] = $this->bd_use_model->get_use($signature_identity['use_id']);
      if (array_key_exists($this->data['user_id'], $signrs[$signature_id]['queue'])) {
        if ($reject) {
          $this->bd_use_model->reject($signature_id, $this->data['user_id']);
          redirect('/bd_use/use_stage/'.$this->data['use']['id']);  
        }else {
          $this->bd_use_model->sign($signature_id, $this->data['user_id']);
          redirect('/bd_use/use_stage/'.$signature_identity['use_id']);  
        }
      }
      redirect('/bd_use/view/'.$signature_identity['use_id']);
    }

    public function comment($use_id){
      if ($this->input->post('submit')) {
      $this->load->library('form_validation');
      $this->form_validation->set_rules('comment','Comment','trim|required');
        if ($this->form_validation->run() == TRUE) {
          $comment = $this->input->post('comment'); 
          $this->load->model('bd_use_model');
          $comment_data = array(
            'user_id' => $this->data['user_id'],
            'use_id' => $use_id,
            'comment' => $comment
          );
          $this->bd_use_model->insert_comment($comment_data);
        }
        redirect('/bd_use/view/'.$use_id);
      }
    }

  }

?>