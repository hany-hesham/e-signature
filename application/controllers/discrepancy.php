<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class discrepancy extends CI_Controller {
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
    $this->data['menu']['active'] = "discrepancy";
  }

  public function submit() {
    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
          redirect('/unknown');
    }else{
      if ($this->input->post('submit')) {
        $this->load->library('form_validation');
        $this->load->library('email');
        $assumed_id = $this->input->post('assumed_id');                        
        if ($this->form_validation->run() == FALSE) {
          $this->load->model('discrepancy_model');
          $this->load->model('users_model');  
          $form_data = array(
            'user_id' => $this->data['user_id'],
            'hotel_id' => $this->input->post('hotel_id'),
            'dcy_type' => $this->input->post('dcy_type'),
            'date' => $this->input->post('date'),
            'time' => $this->input->post('time'),
            'type' => '1'
          );
          $dcy_id = $this->discrepancy_model->create_discrepancy($form_data);
           if ($dcy_id) {
              $this->load->model('discrepancy_model');
              $this->discrepancy_model->update_files($assumed_id,$dcy_id);
            } else {
              die("ERROR");//@TODO failure view
            }
          $resulte =  array();
          foreach ($this->input->post('items') as $item) {
            $item['dcy_id'] = $dcy_id;  
            $item_id = $this->discrepancy_model->create_room($item);   
            $resulte[] = $item['id'];
            if (!$item_id) {
              die("ERROR");
            }
          }
          $signatures = $this->discrepancy_model->dcy_sign($form_data['type']);
          $do_sign = $this->discrepancy_model->dcy_do_sign($dcy_id);
            //die(print_r($do_sign));
            if ($do_sign == 0) {
              foreach ($signatures as $dcy_signature) {
                $this->discrepancy_model->add_signature($dcy_id, $dcy_signature['role'], $dcy_signature['department'] , $dcy_signature['rank']);
              }
            }
       //   $this->discrepancy_model->add_signature($dcy_id, 0, 0);    
          redirect('/discrepancy/discrepancy_stage/'.$dcy_id);
        }   
      } 
      try {
        $this->load->helper('form');
        $this->load->model('discrepancy_model');
        $this->load->model('hotels_model');
        $this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());
        if ($this->input->post('submit')) {
          $this->load->model('discrepancy_model');
          $this->data['assumed_id'] = $this->input->post('assumed_id');
          $this->data['uploads'] = $this->discrepancy_model->getby_fille($this->data['assumed_id']);
        } else {
          $this->data['assumed_id'] = strtoupper(str_pad(dechex( mt_rand( 0, 1048575 ) ), 5, '0', STR_PAD_LEFT));
          $this->data['uploads'] = array();
        }
        $this->load->view('discrepancy_add_new',$this->data);
      }
      catch( Exception $e) {
        show_error($e->getMessage()." _ ". $e->getTraceAsString());
      }
    }
  }

  public function make_offer($dcy_id) {
    $file_name = $this->do_upload("upload");
    if (!$file_name) {
      die(json_encode($this->data['error']));
    } else {
      $this->load->model("discrepancy_model");
      $this->discrepancy_model->add($dcy_id, $file_name);
      // $this->logger->log_event($this->data['user_id'], "Offer", "projects", $dcy_id, json_encode(array("offer_name" => $file_name)), "user uploaded an offer");//log
      die("{}");
    }
  }

  public function remove_offer($dcy_id, $id) {
    $file_name = $_POST['key'];
    if (!$id) {
      die(json_encode($this->data['error']));
    } else {
      $this->load->model("discrepancy_model");
      $this->discrepancy_model->remove($id);
      // $this->logger->log_event($this->data['user_id'], "Offer-Remove", "projects", $dcy_id, json_encode(array("offer_id" => $id, "file_name" => $file_name)), "user removed an offer");//log
      die("{}");
    }
  }

  private function do_upload($field) {
    $config['upload_path'] = 'assets/uploads/files/';
    $config['allowed_types'] = '*';
    $this->load->library('upload', $config);
    if ( ! $this->upload->do_upload($field))
    {
      $this->data['error'] = array('error' => $this->upload->display_errors());
      return FALSE;
    }
    else
    {
      $file = $this->upload->data();
      return $file['file_name'];
    }
  }

  public function no_dcy() {
    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
          redirect('/unknown');
    }else{
      if ($this->input->post('submit')) {
        $this->load->library('form_validation');
        $this->load->library('email');
        $assumed_id = $this->input->post('assumed_id');                        
        if ($this->form_validation->run() == FALSE) {
          $this->load->model('discrepancy_model');
          $this->load->model('users_model');  
          $form_data = array(
            'user_id' => $this->data['user_id'],
            'hotel_id' => $this->input->post('hotel_id'),
            'dcy_type' => $this->input->post('dcy_type'),
            'date' => $this->input->post('date'),
            'time' => $this->input->post('time'),
            'type' => '1'
          );
          $dcy_id = $this->discrepancy_model->create_discrepancy($form_data);
          if ($dcy_id) {
              $this->load->model('discrepancy_model');
              $this->discrepancy_model->update_files($assumed_id,$dcy_id);
            } else {
              die("ERROR");//@TODO failure view
            }
          $signatures = $this->discrepancy_model->dcy_sign($form_data['type']);
          $do_sign = $this->discrepancy_model->dcy_do_sign($dcy_id);
            //die(print_r($do_sign));
            if ($do_sign == 0) {
              foreach ($signatures as $dcy_signature) {
                $this->discrepancy_model->add_signature($dcy_id, $dcy_signature['role'], $dcy_signature['department'], $dcy_signature['rank']);
              }
            }
       //   $this->discrepancy_model->add_signature($fb_id, 0, 0);    
          redirect('/discrepancy/discrepancy_stage/'.$dcy_id);
        }   
      } 
      try {
        $this->load->helper('form');
        $this->load->model('discrepancy_model');
        $this->load->model('hotels_model');
        $this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());
        if ($this->input->post('submit')) {
          $this->load->model('discrepancy_model');
          $this->data['assumed_id'] = $this->input->post('assumed_id');
          $this->data['uploads'] = $this->discrepancy_model->getby_fille($this->data['assumed_id']);
        } else {
          $this->data['assumed_id'] = strtoupper(str_pad(dechex( mt_rand( 0, 1048575 ) ), 5, '0', STR_PAD_LEFT));
          $this->data['uploads'] = array();
        }
        $this->load->view('dcy_no',$this->data);
      }
      catch( Exception $e) {
        show_error($e->getMessage()." _ ". $e->getTraceAsString());
      }
    }
  }

  public function view($dcy_id) {
    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
          redirect('/unknown');
    }else{
      $this->load->model('discrepancy_model');
      $this->load->model('hotels_model');   
      $this->data['hotels'] = $this->hotels_model->getall();
      $this->data['discrepancy'] = $this->discrepancy_model->get_discrepancy($dcy_id);
      $this->data['discrepancy_room'] = $this->discrepancy_model->get_discrepancy_room($dcy_id);
      $this->data['uploads'] = $this->discrepancy_model->getby_fille($dcy_id);
      $this->data['get_comment'] = $this->discrepancy_model->get_comment($dcy_id);
      $this->data['signature_path'] = '/assets/uploads/signatures/';
      $this->data['signers'] = $this->get_signers($this->data['discrepancy']['id'], $this->data['discrepancy']['hotel_id']);
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

        if ( $this->data['discrepancy']['user_id'] == $this->data['user_id'] &&  $this->data['discrepancy']['state_id'] == 1) {
          $editor = TRUE;
        }
      }
      $this->data['unsign_enable'] = (($unsign_enable) || $this->data['is_admin'])? TRUE : FALSE;
      $this->data['is_editor'] = ( (($this->data['unsign_enable'] || $editor)) || ($force_edit) )? TRUE : FALSE;
      $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
      $this->data['file_path'] = '\assets\uploads\files\\';
      $this->data['id'] = $dcy_id;
      $this->load->view('discrepancy_view', $this->data);
    }
  }

  public function edit($dcy_id) {
    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
          redirect('/unknown');
    }else{
      if ($this->input->post('submit')) {
        $this->load->library('form_validation');
        $this->load->library('email');
        if ($this->form_validation->run() == FALSE) {
          $this->load->model('discrepancy_model');
          $this->load->model('users_model');  
          $form_data = array(
            'hotel_id' => $this->input->post('hotel_id'),
            'dcy_type' => $this->input->post('dcy_type'),
            'date' => $this->input->post('date'),
            'time' => $this->input->post('time')
          );
          $this->discrepancy_model->update_discrepancy($form_data, $dcy_id);
          foreach ($this->input->post('items') as $item) {
              $item['dcy_id'] = $dcy_id;
              //die(print_r($item));    
            $this->discrepancy_model->update_room($item, $dcy_id, $item['id']);
            }
          redirect('/discrepancy/view/'.$dcy_id);
        }   
        } 
        try {
        $this->load->helper('form');
        $this->load->model('discrepancy_model');
        $this->load->model('hotels_model');
        $this->data['discrepancy'] = $this->discrepancy_model->get_discrepancy($dcy_id);
        $this->data['discrepancy_room'] = $this->discrepancy_model->get_discrepancy_room($dcy_id);
        $this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());
        $this->data['uploads'] = $this->discrepancy_model->getby_fille($this->data['discrepancy']['id']);
        $this->load->view('discrepancy_edit',$this->data);
      }
      catch( Exception $e) {
        show_error($e->getMessage()." _ ". $e->getTraceAsString());
      }
    }
  }

  public function Comment($dcy_id){
      if ($this->input->post('submit')) {
      $this->load->library('form_validation');
          $this->form_validation->set_rules('comment','Comment','trim|required');
        if ($this->form_validation->run() == TRUE) {
          $comment = $this->input->post('comment'); 
          $this->load->model('discrepancy_model');
          $comment_data = array(
            'user_id' => $this->data['user_id'],
            'dcy_id' => $dcy_id,
            'comment' => $comment
          );
        $this->discrepancy_model->insert_comment($comment_data);
      }
      redirect('/discrepancy/view/'.$dcy_id);
    }
  }

  public function index() {
    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
          redirect('/unknown');
    }else{
      $this->load->model('hotels_model');
      $this->load->model('users_model');
      $this->load->model('discrepancy_model');
      $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
      $hotels = array();
      foreach ($user_hotels as $hotel) {
        $hotels[] = $hotel['id'];
      }    
      $this->data['discrepancy'] = $this->discrepancy_model->view($hotels);
       foreach ($this->data['discrepancy'] as $ke => $discrepancy) {
        $this->data['discrepancy'][$ke]['items'] = $this->discrepancy_model->get_discrepancy_room($this->data['discrepancy'][$ke]['id']);
      }
      foreach ($this->data['discrepancy'] as $key => $dcy) {
        $this->data['discrepancy'][$key]['approvals'] = $this->get_signers($this->data['discrepancy'][$key]['id'], $this->data['discrepancy'][$key]['hotel_id']);
      }
      $this->data['hotels'] = $this->hotels_model->getall();
      $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
      $this->load->view('discrepancy_index', $this->data);
    }
  }

  public function index_app() {
    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
          redirect('/unknown');
    }else{
      $this->load->model('hotels_model');
      $this->load->model('users_model');
      $this->load->model('discrepancy_model');
      $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
      $hotels = array();
      foreach ($user_hotels as $hotel) {
        $hotels[] = $hotel['id'];
      }    
      $this->data['discrepancy'] = $this->discrepancy_model->view($hotels);
       foreach ($this->data['discrepancy'] as $ke => $discrepancy) {
        $this->data['discrepancy'][$ke]['items'] = $this->discrepancy_model->get_discrepancy_room($this->data['discrepancy'][$ke]['id']);
      }
      foreach ($this->data['discrepancy'] as $key => $dcy) {
        $this->data['discrepancy'][$key]['approvals'] = $this->get_signers($this->data['discrepancy'][$key]['id'], $this->data['discrepancy'][$key]['hotel_id']);
      }
      $this->data['hotels'] = $this->hotels_model->getall();
      $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
      $this->load->view('discrepancy_index_app', $this->data);
    }
  }

  public function index_wat() {
    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
          redirect('/unknown');
    }else{
      if ($this->input->post('submit')) {
        $this->data['state'] = $this->input->post('state');
      }
      $this->load->model('hotels_model');
      $this->load->model('users_model');
      $this->load->model('discrepancy_model');
      $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
      $hotels = array();
      foreach ($user_hotels as $hotel) {
        $hotels[] = $hotel['id'];
      }    
      $this->data['discrepancy'] = $this->discrepancy_model->view($hotels);
       foreach ($this->data['discrepancy'] as $ke => $discrepancy) {
        $this->data['discrepancy'][$ke]['items'] = $this->discrepancy_model->get_discrepancy_room($this->data['discrepancy'][$ke]['id']);
      }
      foreach ($this->data['discrepancy'] as $key => $dcy) {
        $this->data['discrepancy'][$key]['approvals'] = $this->get_signers($this->data['discrepancy'][$key]['id'], $this->data['discrepancy'][$key]['hotel_id']);
      }
      $this->data['hotels'] = $this->hotels_model->getall();
      $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
      $this->load->view('discrepancy_index_wat', $this->data);
    }
  }

   public function index_rej() {
    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
          redirect('/unknown');
    }else{
      $this->load->model('hotels_model');
      $this->load->model('users_model');
      $this->load->model('discrepancy_model');
      $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
      $hotels = array();
      foreach ($user_hotels as $hotel) {
        $hotels[] = $hotel['id'];
      }    
      $this->data['discrepancy'] = $this->discrepancy_model->view($hotels);
       foreach ($this->data['discrepancy'] as $ke => $discrepancy) {
        $this->data['discrepancy'][$ke]['items'] = $this->discrepancy_model->get_discrepancy_room($this->data['discrepancy'][$ke]['id']);
      }
      foreach ($this->data['discrepancy'] as $key => $dcy) {
        $this->data['discrepancy'][$key]['approvals'] = $this->get_signers($this->data['discrepancy'][$key]['id'], $this->data['discrepancy'][$key]['hotel_id']);
      }
      $this->data['hotels'] = $this->hotels_model->getall();
      $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
      $this->load->view('discrepancy_index_rej', $this->data);
    }
  }

  private function get_signers($dcy_id, $hotel_id) {
    $this->load->model('discrepancy_model');
    $signatures = $this->discrepancy_model->getby_verbal($dcy_id);
    return $this->roll_signers($signatures, $hotel_id, $dcy_id);
  }

  private function roll_signers($signatures, $hotel_id, $dcy_id) {
    $discrepancy = $this->discrepancy_model->get_discrepancy($dcy_id);
    $signers = array();
    $this->load->model('users_model');
    foreach ($signatures as $signature) {
      $signers[$signature['id']] = array();
      $signers[$signature['id']]['role'] = $signature['role'];
      $signers[$signature['id']]['role_id'] = $signature['role_id'];
      $signers[$signature['id']]['department'] = $signature['department'];
      $signers[$signature['id']]['department_id'] = $signature['department_id'];
      if ($signature['user_id']) {
        if ($signature['rank'] == 1 && $discrepancy['state_id'] == 1){
          $this->discrepancy_model->update_state($dcy_id, 4);
        }elseif ($signature['rank'] == 2 && $discrepancy['state_id'] == 4){
          $this->discrepancy_model->update_state($dcy_id, 5);
        }elseif ($signature['rank'] == 3 && $discrepancy['state_id'] == 5){
          $this->discrepancy_model->update_state($dcy_id, 6);
        }elseif ($signature['rank'] == 4 && $discrepancy['state_id'] == 6){
          $this->discrepancy_model->update_state($dcy_id, 7);
        }elseif ($signature['rank'] == 5 && $discrepancy['state_id'] == 7){
          $this->discrepancy_model->update_state($dcy_id, 2);
        }
        $signers[$signature['id']]['sign'] = array();
        $signers[$signature['id']]['sign']['id'] = $signature['user_id'];
        if ($signature['reject'] == 1) {
          $signers[$signature['id']]['sign']['reject'] = "reject";
          $this->discrepancy_model->update_state($dcy_id, 3);
        } 
        $user = $this->users_model->get_user_by_id($signature['user_id'], TRUE);
        $signers[$signature['id']]['sign']['name'] = $user->fullname;
        $signers[$signature['id']]['sign']['mail'] = $user->email;
        $signers[$signature['id']]['sign']['sign'] = $user->signature;
        $signers[$signature['id']]['sign']['timestamp'] = $signature['timestamp'];
      } else {
        $signers[$signature['id']]['queue'] = array();
        if ($signature['role_id'] == 20) {
          $users = $this->users_model->getby_criteria(7, $hotel_id, 4);
        } else {
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

  public function sign($signature_id, $reject = FALSE) {
    $this->load->model('discrepancy_model');
    $signature_identity = $this->discrepancy_model->get_signature_identity($signature_id);
    $signrs = $this->get_signers($signature_identity['dcy_id'], $signature_identity['hotel_id']);
    $this->data['discrepancy'] = $this->discrepancy_model->get_discrepancy($signature_identity['dcy_id']);
    if (array_key_exists($this->data['user_id'], $signrs[$signature_id]['queue'])) {
      if ($reject) {
        $this->discrepancy_model->reject($signature_id, $this->data['user_id']);
        redirect('/discrepancy/discrepancy_stage/'.$this->data['discrepancy']['id']);  
      } else {
        $this->discrepancy_model->sign($signature_id, $this->data['user_id']);
        redirect('/discrepancy/discrepancy_stage/'.$signature_identity['dcy_id']);  

      }
    }
    redirect('/discrepancy/view/'.$signature_identity['dcy_id']);
  }

  public function unsign($signature_id) {
    $this->load->model('discrepancy_model');
    $this->load->model('users_model');
    $signature_identity = $this->discrepancy_model->get_signature_identity($signature_id);
    $this->discrepancy_model->unsign($signature_id);
    $discrepancy = $this->discrepancy_model->get_discrepancy($signature_identity['dcy_id']);
    redirect('/discrepancy/view/'.$signature_identity['dcy_id']);
  }

  public function discrepancy_stage($dcy_id) {
    $this->load->model('discrepancy_model');
    $this->data['discrepancy'] = $this->discrepancy_model->get_discrepancy($dcy_id);
    if ($this->data['discrepancy']['state_id'] == 0) {
      $this->self_sign($dcy_id);
      $this->discrepancy_model->update_state($dcy_id, 1);
        redirect('/discrepancy/discrepancy_stage/'.$dcy_id);
    }elseif ($this->data['discrepancy']['state_id'] != 0 && $this->data['discrepancy']['state_id'] != 2 && $this->data['discrepancy']['state_id'] != 3){
      $queue = $this->notify_signers($dcy_id, $this->data['discrepancy']['hotel_id']);
    }elseif ($this->data['discrepancy']['state_id'] == 2){
      $user = $this->users_model->get_user_by_id($this->data['settlement']['user_id'], TRUE);
      $queue = $this->approvel_mail($user->fullname, $user->email, $dcy_id);
    }elseif ($this->data['discrepancy']['state_id'] == 3){
      $user = $this->users_model->get_user_by_id($this->data['discrepancy']['user_id'], TRUE);
      $queue = $this->reject_mail($user->fullname, $user->email, $dcy_id);
    }
    redirect('/discrepancy/view/'.$dcy_id);
  }

  private function self_sign($dcy_id) {
    $this->load->model('discrepancy_model');
    $this->discrepancy_model->self_sign($dcy_id, $this->data['user_id']);
  }

  private function notify_signers($dcy_id) {
    $notified = FALSE;
    $signers = $this->get_signers($dcy_id, $this->data['discrepancy']['hotel_id']);
    foreach ($signers as $signer) {
      if (isset($signer['queue'])) {
        $notified = TRUE;
          foreach ($signer['queue'] as $uid => $user) {
            $this->signatures_mail($signer['role'], $user['name'], $user['mail'], $dcy_id);
        }
        break;
      }
    }
    return $notified;
  }

  private function signatures_mail($role, $name, $mail, $dcy_id) {
    $this->load->library('email');
    $this->load->helper('url');
    $dcy_url = base_url().'discrepancy/view/'.$dcy_id;
    $this->email->from('e-signature@sunrise-resorts.com');
    $this->email->to($mail);
    $this->email->subject("Discrepancy Report No. #{$dcy_id}");
    $this->email->message("Dear {$name},<br/>
              <br/>
              Discrepancy Report No. #{$dcy_id} requires your signature, Please use the link below:<br/>
              <a href='{$dcy_url}' target='_blank'>{$dcy_url}</a><br/>
              "); 
    $mail_result = $this->email->send();
  }

  private function reject_mail($name, $email, $dcy_id) {
    $this->load->library('email');
    $this->load->helper('url');
    $dcy_url = base_url().'discrepancy/view/'.$dcy_id;
    $this->email->from('e-signature@sunrise-resorts.com');
    $this->email->to($email);
    $this->email->subject("Discrepancy Report No. #{{$dcy_id}");
    $this->email->message("Dear {$name},<br/>
              <br/>
              Discrepancy Report No. #{{$dcy_id} has been rejected, Please use the link below:<br/>
              <a href='{$dcy_url}' target='_blank'>{$dcy_url}</a><br/>
              "); 
    $mail_result = $this->email->send();
  }

  private function approvel_mail($name, $email, $dcy_id) {
    $this->load->library('email');
    $this->load->helper('url');
    $dcy_url = base_url().'discrepancy/view/'.$dcy_id;
    $this->email->from('e-signature@sunrise-resorts.com');
    $this->email->to($email);
    $this->email->subject("Discrepancy Report No. #{$dcy_id}");
    $this->email->message("Dear {$name},<br/>
              <br/>
              Discrepancy Report No. #{$dcy_id} has been approved, Please use the link below:<br/>
              <a href='{$dcy_url}' target='_blank'>{$dcy_url}</a><br/>
              "); 
    $mail_result = $this->email->send();
  }

  public function mailto($dcy_id) {
    if ($this->input->post('submit')) {
      $this->load->library('form_validation');
      $this->form_validation->set_rules('message','Message is required','trim|required');
      $this->form_validation->set_rules('mail','Mail is required','trim|required');
      if ($this->form_validation->run() == TRUE) {
        $message = $this->input->post('message');
        $email = $this->input->post('mail');
        $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
        $this->load->library('email');
        $this->load->helper('url');
        $dcy_url = base_url().'discrepancy/view/'.$dcy_id;
        $this->email->from('e-signature@sunrise-resorts.com');
        $this->email->to($email);
        $this->email->subject("A message from {$user->fullname}, Discrepancy Report No. #{$dcy_id}");
        $this->email->message("{$user->fullname} sent you a private message regarding Discrepancy Report No. #{$dcy_id}:<br/>
                  {$message}<br />
                  <br />
                  Please use the link below to view the Discrepancy Report:
                  <a href='{$dcy_url}' target='_blank'>{$dcy_url}</a><br/>
                "); 
        $mail_result = $this->email->send();
      }
    }
    redirect('discrepancy/view/'.$dcy_id);
  }
}