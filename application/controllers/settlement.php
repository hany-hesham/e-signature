<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class settlement extends CI_Controller {
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
    $this->data['menu']['active'] = "quality";
  }

  public function submit() {
        if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
      if ($this->input->post('submit')) {
        $this->load->library('form_validation');
        $this->load->library('email');
        $assumed_id = $this->input->post('assumed_id');                        
        if ($this->form_validation->run() == FALSE) {
          $this->load->model('settlement_model');
          $this->load->model('users_model');  
          $form_data = array(
            'user_id' => $this->data['user_id'],
            'hotel_id' => $this->input->post('hotel_id'),
            'Date' => $this->input->post('Date'), 
            'Date_till' => $this->input->post('Date_till'),
            'form_type' => '1',
            'amount' => $this->input->post('amount'),
            'currency' => $this->input->post('currency'),
            'File' => $this->input->post('File'),
            'Ref' => $this->input->post('Ref'),
            'Claim' => $this->input->post('Claim'),
            'Proposed' => $this->input->post('Proposed'),
            'Rationale' => $this->input->post('Rationale'),
            'Risk' => $this->input->post('Risk'),
            'Rejected' => $this->input->post('Rejected'),
            'Reason' => $this->input->post('Reason'),
            'Suggestion' => $this->input->post('Suggestion'),
            'Agreed' => $this->input->post('Agreed')
          );
          $set_id = $this->settlement_model->create_settlement($form_data);
          if ($set_id) {
                          $this->load->model('settlement_model');
                          $this->settlement_model->update_files($assumed_id,$set_id);
                      } else {
                          die("ERROR");//@TODO failure view
                      }
          $signatures = $this->settlement_model->set_sign($form_data['form_type']);
          $do_sign = $this->settlement_model->set_do_sign($set_id);
            //die(print_r($do_sign));
            if ($do_sign == 0) {
              foreach ($signatures as $set_signature) {
                $this->settlement_model->add_signature($set_id, $set_signature['role'], $set_signature['rank']);
              }
            }
          $this->notify_legal($set_id);
          redirect('/settlement/settlement_stage/'.$set_id);
        }   
        } 
        try {
        $this->load->helper('form');
        $this->load->model('settlement_model');
        $this->load->model('hotels_model');
        //$this->data['settlement'] = $this->settlement_model->get_settlement($set_id);
        $this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());
        $this->data['types'] = $this->settlement_model->getall_type();
        if ($this->input->post('submit')) {
          $this->load->model('settlement_model');
          $this->data['assumed_id'] = $this->input->post('assumed_id');
          $this->data['uploads'] = $this->settlement_model->getby_fille($this->data['assumed_id']);
        } else {
          $this->data['assumed_id'] = strtoupper(str_pad(dechex( mt_rand( 0, 1048575 ) ), 5, '0', STR_PAD_LEFT));
          $this->data['uploads'] = array();
        }
        $this->load->view('settlement_add_new',$this->data);
      }
      catch( Exception $e) {
        show_error($e->getMessage()." _ ". $e->getTraceAsString());
      }
    }else{
      redirect('/unknown');
    }
  }

  public function submit_purpose($set_id) {
        if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
      if ($this->input->post('submit')) {
        $this->load->library('form_validation');
        $this->load->library('email');
        $this->load->model('settlement_model');
        $this->data['settlement'] = $this->settlement_model->get_settlement($set_id);
        $this->form_validation->set_rules('type','Case Type','trim|required');
        if ($this->form_validation->run() == TRUE) {
          $this->load->model('settlement_model');
          $this->load->model('users_model');  
          $form_data = array(
            'set_id' => $set_id,
            'user_id' => $this->data['user_id'],
            'hotel_id' => $this->data['settlement']['hotel_id'],
            'date' => $this->input->post('date'), 
            'type' => $this->input->post('type'),
            'set' => $this->input->post('set'),
            'charged' => $this->input->post('charged'),
            'position' => $this->input->post('position'),
            'accident' => $this->input->post('accident'),
            'area' => $this->input->post('area'),
            'reason' => $this->input->post('reason'),
            'amount' => $this->input->post('amount'),
            'penalty' => $this->input->post('penalty')
          );
          $pur_id = $this->settlement_model->create_purpose($form_data);
          if (!$pur_id) {
            die("ERROR");
          }
          $pur_signatures = $this->settlement_model->pur_sign();
          $do_sign = $this->settlement_model->pur_do_sign($pur_id);
            //die(print_r($do_sign));
            if ($do_sign == 0) {
              foreach ($pur_signatures as $pur_signature) {
                $this->settlement_model->add_pur_signature($pur_id, $set_id, $pur_signature['role'], $pur_signature['rank']);
              }
            }
          //$this->settlement_model->add_signature($pur_id, 0, 0);    
          redirect('/settlement/purpose_stage/'.$set_id);
        }   
      } 
      try {
        $this->load->helper('form');
        $this->load->model('settlement_model');
        $this->load->model('hotels_model');
        $this->data['settlement'] = $this->settlement_model->get_settlement($set_id);
        //$this->data['purpose'] = $this->settlement_model->get_purpose($set_id);
        $this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());
        $this->data['types'] = $this->settlement_model->getall_type();
        $this->load->view('purpose_add_new',$this->data);
      }
      catch( Exception $e) {
        show_error($e->getMessage()." _ ". $e->getTraceAsString());
      }
    }else{
      redirect('/unknown');
    }
  }

  public function view($set_id) {
        if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
      $this->load->model('settlement_model');
      $this->load->model('hotels_model');   
      $this->data['hotels'] = $this->hotels_model->getall();
      $this->data['settlement'] = $this->settlement_model->get_settlement($set_id);
      $this->data['uploads'] = $this->settlement_model->getby_fille($set_id);
      $this->data['GetComment'] = $this->settlement_model->GetComment($set_id);
      $this->data['signature_path'] = '/assets/uploads/signatures/';
      $this->data['signers'] = $this->get_signers($this->data['settlement']['id'], $this->data['settlement']['hotel_id']);
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

        if ( $this->data['settlement']['user_id'] == $this->data['user_id'] &&  $this->data['settlement']['state_id'] == 1) {
          $editor = TRUE;
        }
      }
      $this->data['unsign_enable'] = (($unsign_enable) || $this->data['is_admin'])? TRUE : FALSE;
      $this->data['is_editor'] = ( (($this->data['unsign_enable'] || $editor)) || ($force_edit) )? TRUE : FALSE;
      $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
      $this->data['file_path'] = '\assets\uploads\files\\';
      $this->data['id'] = $set_id;
      $this->load->view('settlement_view', $this->data);
    }else{
      redirect('/unknown');
    }
  }

   public function purpose_view($set_id) {
        if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
      $this->load->model('settlement_model');
      $this->load->model('hotels_model');   
      $this->data['hotels'] = $this->hotels_model->getall();
      $this->data['settlement'] = $this->settlement_model->get_settlement($set_id);
      $this->data['purpose'] = $this->settlement_model->get_purpose($set_id);
      $this->data['get_purpose_comment'] = $this->settlement_model->get_purpose_comment($set_id);
      $this->data['uploads'] = $this->settlement_model->getby_fille($this->data['settlement']['id']);
      $this->data['signature_path'] = '/assets/uploads/signatures/';
      $this->data['signers1'] = $this->get_purpose_signers($this->data['purpose']['set_id'], $this->data['purpose']['hotel_id']);
      $editor = FALSE;
      $unsign_enable = FALSE;
      $first = TRUE;
      $force_edit = FALSE;
      foreach ($this->data['signers1'] as $signer) {
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

        if ( $this->data['purpose']['user_id'] == $this->data['user_id'] &&  $this->data['purpose']['state_id'] == 1) {
          $editor = TRUE;
        }
      }
      $this->data['unsign_enable'] = (($unsign_enable) || $this->data['is_admin'])? TRUE : FALSE;
      $this->data['is_editor'] = ( (($this->data['unsign_enable'] || $editor)) || ($force_edit) )? TRUE : FALSE;
      $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
      $this->data['file_path'] = '\assets\uploads\files\\';
      $this->data['id'] = $set_id;
      $this->load->view('purpose_view', $this->data);
    }else{
      redirect('/unknown');
    }
  }

  public function edit($set_id) {
        if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
      if ($this->input->post('submit')) {
        $this->load->library('form_validation');
        $this->load->library('email');
        if ($this->form_validation->run() == FALSE) {
          $this->load->model('settlement_model');
          $this->load->model('users_model');  
          $form_data = array(
            'hotel_id' => $this->input->post('hotel_id'),
            'amount' => $this->input->post('amount'),
            'currency' => $this->input->post('currency'),
            'Date' => $this->input->post('Date'),
            'Date_till' => $this->input->post('Date_till'),
            'File' => $this->input->post('File'),
            'Ref' => $this->input->post('Ref'),
            'Claim' => $this->input->post('Claim'),
            'Proposed' => $this->input->post('Proposed'),
            'Rationale' => $this->input->post('Rationale'),
            'Risk' => $this->input->post('Risk'),
            'Rejected' => $this->input->post('Rejected'),
            'Reason' => $this->input->post('Reason'),
            'Suggestion' => $this->input->post('Suggestion'),
            'Agreed' => $this->input->post('Agreed')
          );
          $this->settlement_model->update_settlement($form_data, $set_id);
          $this->notify_edit_legal($set_id);
          redirect('/settlement/view/'.$set_id);
        }   
        } 
        try {
        $this->load->helper('form');
        $this->load->model('settlement_model');
        $this->load->model('hotels_model');
        $this->data['settlement'] = $this->settlement_model->get_settlement($set_id);
        $this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());
        $this->data['uploads'] = $this->settlement_model->getby_fille($this->data['settlement']['id']);
        $this->data['types'] = $this->settlement_model->getall_type();
        $this->load->view('settlement_edit',$this->data);
      }
      catch( Exception $e) {
        show_error($e->getMessage()." _ ". $e->getTraceAsString());
      }
    }else{
      redirect('/unknown');
    }
  }

  public function purpose_edit($set_id) {
        if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
      if ($this->input->post('submit')) {
        $this->load->library('form_validation');
        $this->load->library('email');
        if ($this->form_validation->run() == FALSE) {
          $this->load->model('settlement_model');
          $this->load->model('users_model');  
          $form_data = array(
            'date' => $this->input->post('date'), 
            'type' => $this->input->post('type'),
            'set' => $this->input->post('set'),
            'charged' => $this->input->post('charged'),
            'position' => $this->input->post('position'),
            'accident' => $this->input->post('accident'),
            'area' => $this->input->post('area'),
            'reason' => $this->input->post('reason'),
            'amount' => $this->input->post('amount'),
            'penalty' => $this->input->post('penalty')
          );
          $this->settlement_model->update_purpose($form_data, $set_id);
          redirect('/settlement/purpose_view/'.$set_id);
        }   
        } 
        try {
        $this->load->helper('form');
        $this->load->model('settlement_model');
        $this->load->model('hotels_model');
        $this->data['hotels'] = $this->hotels_model->getall();
        $this->data['settlement'] = $this->settlement_model->get_settlement($set_id);
        $this->data['purpose'] = $this->settlement_model->get_purpose($set_id);
        $this->data['uploads'] = $this->settlement_model->getby_fille($this->data['settlement']['id']);
        $this->data['types'] = $this->settlement_model->getall_type();
        $this->load->view('purpose_edit',$this->data);
      }
      catch( Exception $e) {
        show_error($e->getMessage()." _ ". $e->getTraceAsString());
      }
    }else{
      redirect('/unknown');
    }
  }

  public function make_offer($set_id) {
    $file_name = $this->do_upload("upload");
    if (!$file_name) {
      die(json_encode($this->data['error']));
    } else {
      $this->load->model("settlement_model");
      $this->settlement_model->add($set_id, $file_name);
      // $this->logger->log_event($this->data['user_id'], "Offer", "projects", $set_id, json_encode(array("offer_name" => $file_name)), "user uploaded an offer");//log

      die("{}");
    }
  }

  public function remove_offer($set_id, $id) {
    $file_name = $_POST['key'];

    if (!$id) {
      die(json_encode($this->data['error']));
    } else {
      $this->load->model("settlement_model");
      $this->settlement_model->remove($id);
      // $this->logger->log_event($this->data['user_id'], "Offer-Remove", "projects", $set_id, json_encode(array("offer_id" => $id, "file_name" => $file_name)), "user removed an offer");//log

      die("{}");
    }
  }

  public function Comment($set_id){
      if ($this->input->post('submit')) {
      $this->load->library('form_validation');
          $this->form_validation->set_rules('comment','Comment','trim|required');
        if ($this->form_validation->run() == TRUE) {
          $comment = $this->input->post('comment'); 
          $this->load->model('settlement_model');
          $comment_data = array(
            'user_id' => $this->data['user_id'],
            'set_id' => $set_id,
            'comment' => $comment
          );
        $this->settlement_model->InsertComment($comment_data);
        if ($this->data['role_id'] == 217) {
            $this->chairman_mail($set_id);
          }
      }
      redirect('/settlement/view/'.$set_id);
    }
  }

  private function chairman_mail($set_id) {
          $this->load->library('email');
          $this->load->helper('url');
          $set_url = base_url().'settlement/view/'.$set_id;
          $this->email->from('e-signature@sunrise-resorts.com');
          $this->email->to('abeer@sunrise.eg');
          $this->email->subject("Settlement Form No. #{$set_id}");
          $this->email->message("Dear Madam Abber,
            <br/>
            <br/>
            Mr Hossam Commented on Settlement Form No. #{$set_id}, Please use the link below:
            <br/>
            <a href='{$set_url}' target='_blank'>{$set_url}</a>
            <br/>
          "); 
          $mail_result = $this->email->send();
      }

  public function purpose_comment($set_id){
      if ($this->input->post('submit')) {
      $this->load->library('form_validation');
          $this->form_validation->set_rules('comment','Comment','trim|required');
        if ($this->form_validation->run() == TRUE) {
          $comment = $this->input->post('comment'); 
          $this->load->model('settlement_model');
          $comment_data = array(
            'user_id' => $this->data['user_id'],
            'set_id' => $set_id,
            'comment' => $comment
          );
        $this->settlement_model->insert_purpose_comment($comment_data);
      }
      redirect('/settlement/purpose_view/'.$set_id);
    }
  }

  public function index() {
        if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
      $this->load->model('hotels_model');
      $this->load->model('settlement_model');
      $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
      $hotels = array();
      foreach ($user_hotels as $hotel) {
        $hotels[] = $hotel['id'];
      }    
      $this->data['settlement'] = $this->settlement_model->view($hotels);
      foreach ($this->data['settlement'] as $key => $set) {
        $this->data['settlement'][$key]['approvals'] = $this->get_signers($this->data['settlement'][$key]['id'], $this->data['settlement'][$key]['hotel_id']);
      }
      $this->data['hotels'] = $this->hotels_model->getall();
      $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
      $this->load->view('settlement_index', $this->data);
    }else{
      redirect('/unknown');
    }
  }

   public function index_app() {
        if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
      $this->load->model('hotels_model');
      $this->load->model('settlement_model');
      $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
      $hotels = array();
      foreach ($user_hotels as $hotel) {
        $hotels[] = $hotel['id'];
      }    
      $this->data['settlement'] = $this->settlement_model->view($hotels);
      foreach ($this->data['settlement'] as $key => $set) {
        $this->data['settlement'][$key]['approvals'] = $this->get_signers($this->data['settlement'][$key]['id'], $this->data['settlement'][$key]['hotel_id']);
      }
      $this->data['hotels'] = $this->hotels_model->getall();
      $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
      $this->load->view('settlement_index_app', $this->data);
    }else{
      redirect('/unknown');
    }
  }

   public function index_wat() {
        if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
    	if ($this->input->post('submit')) {
      $this->data['state'] = $this->input->post('state');
    }
      $this->load->model('hotels_model');
      $this->load->model('settlement_model');
      $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
      $hotels = array();
      foreach ($user_hotels as $hotel) {
        $hotels[] = $hotel['id'];
      }    
      $this->data['settlement'] = $this->settlement_model->view($hotels);
      foreach ($this->data['settlement'] as $key => $set) {
        $this->data['settlement'][$key]['approvals'] = $this->get_signers($this->data['settlement'][$key]['id'], $this->data['settlement'][$key]['hotel_id']);
      }
      $this->data['hotels'] = $this->hotels_model->getall();
      $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
      $this->load->view('settlement_index_wat', $this->data);
    }else{
      redirect('/unknown');
    }
  }

   public function index_rej() {
        if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
      $this->load->model('hotels_model');
      $this->load->model('settlement_model');
      $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
      $hotels = array();
      foreach ($user_hotels as $hotel) {
        $hotels[] = $hotel['id'];
      }    
      $this->data['settlement'] = $this->settlement_model->view($hotels);
      foreach ($this->data['settlement'] as $key => $set) {
        $this->data['settlement'][$key]['approvals'] = $this->get_signers($this->data['settlement'][$key]['id'], $this->data['settlement'][$key]['hotel_id']);
      }
      $this->data['hotels'] = $this->hotels_model->getall();
      $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
      $this->load->view('settlement_index_rej', $this->data);
    }else{
      redirect('/unknown');
    }
  }

  public function index_close() {
        if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
      $this->load->model('hotels_model');
      $this->load->model('settlement_model');
      $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
      $hotels = array();
      foreach ($user_hotels as $hotel) {
        $hotels[] = $hotel['id'];
      }    
      $this->data['settlement'] = $this->settlement_model->view($hotels);
      foreach ($this->data['settlement'] as $key => $set) {
        $this->data['settlement'][$key]['approvals'] = $this->get_signers($this->data['settlement'][$key]['id'], $this->data['settlement'][$key]['hotel_id']);
      }
      $this->data['hotels'] = $this->hotels_model->getall();
      $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
      $this->load->view('settlement_index_close', $this->data);
    }else{
      redirect('/unknown');
    }
  }

  private function get_signers($set_id, $hotel_id) {
    $this->load->model('settlement_model');
    $signatures = $this->settlement_model->getby_verbal($set_id);
    return $this->roll_signers($signatures, $hotel_id, $set_id);
  }

  private function get_purpose_signers($set_id, $hotel_id) {
    $this->load->model('settlement_model');
    $signatures = $this->settlement_model->purpose_getby_verbal($set_id);
    return $this->roll_signers($signatures, $hotel_id, $set_id);
  }

  private function roll_signers($signatures, $hotel_id, $set_id) {
    $settlement = $this->settlement_model->get_settlement($set_id);
    $rowcount = $this->settlement_model->get_count($set_id);
    $signers = array();
    $this->load->model('users_model');
    foreach ($signatures as $signature) {
      $signers[$signature['id']] = array();
      $signers[$signature['id']]['role'] = $signature['role'];
      $signers[$signature['id']]['role_id'] = $signature['role_id'];
      if ($signature['user_id']) {
        if ($rowcount == 3) {
          if ($signature['rank'] == 1 && $settlement['state_id'] == 1){
            $this->settlement_model->update_state($set_id, 5);
          }elseif ($signature['rank'] == 2 && $settlement['state_id'] == 5){
            $this->settlement_model->update_state($set_id, 4);
          }elseif ($signature['rank'] == 3 && $settlement['state_id'] == 4){
            $this->settlement_model->update_state($set_id, 2);
          }
        }
        if ($rowcount == 6) {
          if ($signature['rank'] == 1 && $settlement['state_id'] == 1){
            $this->settlement_model->update_state($set_id, 5);
          }elseif ($signature['rank'] == 2 && $settlement['state_id'] == 5){
            $this->settlement_model->update_state($set_id, 6);
          }elseif ($signature['rank'] == 3 && $settlement['state_id'] == 6){
            $this->settlement_model->update_state($set_id, 7);
          }elseif ($signature['rank'] == 4 && $settlement['state_id'] == 7){
            $this->settlement_model->update_state($set_id, 8);
          }elseif ($signature['rank'] == 5 && $settlement['state_id'] == 8){
            $this->settlement_model->update_state($set_id, 4);
          }elseif ($signature['rank'] == 6 && $settlement['state_id'] == 4){
            $this->settlement_model->update_state($set_id, 2);
          }
        }
        if ($rowcount == 7) {
          if ($signature['rank'] == 1 && $settlement['state_id'] == 1){
            $this->settlement_model->update_state($set_id, 9);
          }elseif ($signature['rank'] == 2 && $settlement['state_id'] == 9){
            $this->settlement_model->update_state($set_id, 5);
          }elseif ($signature['rank'] == 3 && $settlement['state_id'] == 5){
            $this->settlement_model->update_state($set_id, 6);
          }elseif ($signature['rank'] == 4 && $settlement['state_id'] == 6){
            $this->settlement_model->update_state($set_id, 7);
          }elseif ($signature['rank'] == 5 && $settlement['state_id'] == 7){
            $this->settlement_model->update_state($set_id, 8);
          }elseif ($signature['rank'] == 6 && $settlement['state_id'] == 8){
            $this->settlement_model->update_state($set_id, 4);
          }elseif ($signature['rank'] == 7 && $settlement['state_id'] == 4){
            $this->settlement_model->update_state($set_id, 2);
          }
        }
        $signers[$signature['id']]['sign'] = array();
        $signers[$signature['id']]['sign']['id'] = $signature['user_id'];
        if ($signature['reject'] == 1) {
          $signers[$signature['id']]['sign']['reject'] = "reject";
          $this->settlement_model->update_state($set_id, 3);
        } 
        $user = $this->users_model->get_user_by_id($signature['user_id'], TRUE);
        $signers[$signature['id']]['sign']['name'] = $user->fullname;
        $signers[$signature['id']]['sign']['mail'] = $user->email;
        $signers[$signature['id']]['sign']['channel'] = $user->channel;
        $signers[$signature['id']]['sign']['sign'] = $user->signature;
        $signers[$signature['id']]['sign']['timestamp'] = $signature['timestamp'];
      } else {
        $signers[$signature['id']]['queue'] = array();
        if ($hotel_id == 9 && $signature['role_id'] == 4) {
          $users = $this->users_model->getby_criteria(6, 9, 3);
        } else {
          $users = $this->users_model->getby_criteria($signature['role_id'], $hotel_id);
        }
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

/*  private function roll_purpose_signers($signatures, $hotel_id, $set_id) {
    $signers1 = array();
    $this->load->model('users_model');
    foreach ($signatures as $signature) {
      $signers1[$signature['id']] = array();
      $signers1[$signature['id']]['role'] = $signature['role'];
      $signers1[$signature['id']]['role_id'] = $signature['role_id'];
      if ($signature['user_id']) {
        $signers1[$signature['id']]['sign'] = array();
        $signers1[$signature['id']]['sign']['id'] = $signature['user_id'];
        if ($signature['reject'] == 1) {
          $signers1[$signature['id']]['sign']['reject'] = "reject";
          $this->settlement_model->update_purpose_state($set_id, 3);
        } 
        $user = $this->users_model->get_user_by_id($signature['user_id'], TRUE);
        $signers1[$signature['id']]['sign']['name'] = $user->fullname;
        $signers1[$signature['id']]['sign']['mail'] = $user->email;
        $signers1[$signature['id']]['sign']['sign'] = $user->signature;
        $signers1[$signature['id']]['sign']['timestamp'] = $signature['timestamp'];
      } else {
        $signers1[$signature['id']]['queue'] = array();
        if ($signature['role_id'] == 20) {
          $users = $this->users_model->getby_criteria(7, $hotel_id, 4);
        } else {
          $users = $this->users_model->getby_criteria($signature['role_id'], $hotel_id);
        }
        foreach ($users as $use) {
          $signers1[$signature['id']]['queue'][$use['id']] = array();
          $signers1[$signature['id']]['queue'][$use['id']]['name'] = $use['fullname'];
          $signers1[$signature['id']]['queue'][$use['id']]['mail'] = $use['email'];
        }
      }
    }
    return $signers1;
  }*/

  public function sign($signature_id, $reject = FALSE) {
    $this->load->model('settlement_model');
    $signature_identity = $this->settlement_model->get_signature_identity($signature_id);
    $signrs = $this->get_signers($signature_identity['set_id'], $signature_identity['hotel_id']);
    $this->data['settlement'] = $this->settlement_model->get_settlement($signature_identity['set_id']);
    $set_url = base_url().'settlement/view/'.$signature_identity['set_id'];
    $message_id = $this->data['settlement']['message_id'];
    $id = $signature_identity['set_id'];
    $message = "settlement No. {$id}:
      {$set_url}";
    if (array_key_exists($this->data['user_id'], $signrs[$signature_id]['queue'])) {
        if ($signature_identity['role_id'] == 1) {
          $this->onclick1($message);
          $this->deletonclick($message_id);
        }
      if ($reject) {
        $this->settlement_model->reject($signature_id, $this->data['user_id']);
        redirect('/settlement/settlement_stage/'.$this->data['settlement']['id']);  
      } else {
        $this->settlement_model->sign($signature_id, $this->data['user_id']);
        redirect('/settlement/settlement_stage/'.$signature_identity['set_id']);  

      }
    }
    redirect('/settlement/view/'.$signature_identity['set_id']);
  }

  public function purpose_sign($signature_id, $reject = FALSE) {
    $this->load->model('settlement_model');
    $signature_identity = $this->settlement_model->get_purpose_signature_identity($signature_id);
    $signrs = $this->get_purpose_signers($signature_identity['set_id'], $signature_identity['hotel_id']);
    $this->data['settlement'] = $this->settlement_model->get_settlement($signature_identity['set_id']);
    $this->data['purpose'] = $this->settlement_model->get_purpose($signature_identity['set_id']);
    if (array_key_exists($this->data['user_id'], $signrs[$signature_id]['queue'])) {
      if ($reject) {
        $this->settlement_model->reject_purpose($signature_id, $this->data['user_id']);
        redirect('/settlement/purpose_stage/'.$signature_identity['set_id']);  
      } else {
        $this->settlement_model->sign_purpose($signature_id, $this->data['user_id']);
        redirect('/settlement/purpose_stage/'.$signature_identity['set_id']);  

      }
    }
    redirect('/settlement/purpose_view/'.$signature_identity['set_id']);
  }

   public function close($set_id) {
    $this->load->model('settlement_model');
    $this->settlement_model->update_close($set_id, 1);
    redirect('/settlement');
  }

  public function unclose($set_id) {
    $this->load->model('settlement_model');
    $this->settlement_model->update_close($set_id, 0);
    redirect('/settlement');
  }

  public function actual($set_id) {
    $this->load->model('settlement_model');
    if ($this->input->post('submit')) {
      $this->load->library('form_validation');
      $this->form_validation->set_rules('actual','You Need To Enter an Amount','trim|required');
      if ($this->form_validation->run() == TRUE) {
        $actual = $this->input->post('actual');
        $this->settlement_model->update_actual($set_id, $actual);
      }
    }
    redirect('/settlement');
  }

  public function status($set_id) {
    $this->load->model('settlement_model');
    if ($this->input->post('submit')) {
      $this->load->library('form_validation');
      $this->form_validation->set_rules('status','You Need To Enter a Status','trim|required');
      if ($this->form_validation->run() == TRUE) {
        $status = $this->input->post('status');
        $this->settlement_model->update_status($set_id, $status);
      }
    }
    redirect('/settlement');
  }

  public function unsign($signature_id) {
    $this->load->model('settlement_model');
    $this->load->model('users_model');
    $signature_identity = $this->settlement_model->get_signature_identity($signature_id);
    $this->settlement_model->unsign($signature_id);
    $settlement = $this->settlement_model->get_settlement($signature_identity['set_id']);
    redirect('/settlement/view/'.$signature_identity['set_id']);
  }

  public function purpose_unsign($signature_id) {
    $this->load->model('settlement_model');
    $this->load->model('users_model');
    $signature_identity = $this->settlement_model->get_purpose_signature_identity($signature_id);
    $this->settlement_model->purpose_unsign($signature_id);
    $purpose = $this->settlement_model->get_purpose($signature_identity['set_id']);
    redirect('/settlement/purpose_view/'.$signature_identity['set_id']);
  }

  public function settlement_stage($set_id) {
    $this->load->model('settlement_model');
    $this->data['settlement'] = $this->settlement_model->get_settlement($set_id);
    if ($this->data['settlement']['state_id'] == 0) {
      $this->self_sign($set_id);
      $this->settlement_model->update_state($set_id, 1);
        redirect('/settlement/settlement_stage/'.$set_id);
    } elseif ($this->data['settlement']['state_id'] != 0 && $this->data['settlement']['state_id'] != 2 && $this->data['settlement']['state_id'] != 3) {
      $queue = $this->notify_signers($set_id, $this->data['settlement']['hotel_id']);
    }elseif ($this->data['settlement']['state_id'] == 2){
      $user = $this->users_model->get_user_by_id($this->data['settlement']['user_id'], TRUE);
      $queue = $this->approvel_mail($user->fullname, $user->email, $set_id);
    }elseif ($this->data['settlement']['state_id'] == 3){
      $user = $this->users_model->get_user_by_id($this->data['settlement']['user_id'], TRUE);
      $queue = $this->reject_mail($user->fullname, $user->email, $set_id);
    }
    redirect('/settlement/view/'.$set_id);
  }

  public function purpose_stage($set_id) {
    $this->load->model('settlement_model');
    $this->data['settlement'] = $this->settlement_model->get_settlement($set_id);
    $this->data['purpose'] = $this->settlement_model->get_purpose($set_id);
    if ($this->data['purpose']['state_id'] == 0) {
      $this->purpose_self_sign($set_id);
      $this->settlement_model->update_purpose_state($set_id, 1);
        redirect('/settlement/purpose_stage/'.$set_id);
    } elseif ($this->data['purpose']['state_id'] == 1) {
      $queue = $this->notify_purpose_signers($set_id, $this->data['purpose']['hotel_id']);
      if (!$queue) {
        $this->notify($set_id);
        $this->settlement_model->update_purpose_state($set_id, 2);
        $user = $this->users_model->get_user_by_id($this->data['purpose']['user_id'], TRUE);
        $this->purpose_approvel_mail($user->fullname, $user->email, $set_id);
        redirect('/settlement/purpose_stage/'.$set_id);
      }
    }elseif ($this->data['purpose']['state_id'] == 3){
      $user = $this->users_model->get_user_by_id($this->data['purpose']['user_id'], TRUE);
      $this->purpose_reject_mail($user->fullname, $user->email, $set_id);
      }
    redirect('/settlement/purpose_view/'.$set_id);
  }

  private function self_sign($set_id) {
    $this->load->model('settlement_model');
    $this->settlement_model->self_sign($set_id, $this->data['user_id']);
  }

  private function purpose_self_sign($set_id) {
    $this->load->model('settlement_model');
    $this->settlement_model->purpose_self_sign($set_id, $this->data['user_id']);
  }

  private function notify_signers($set_id) {
    $notified = FALSE;
    $set_url = base_url().'settlement/view/'.$set_id;
    $message = "Settlement No. {$set_id}:
      {$set_url}";
    $signers = $this->get_signers($set_id, $this->data['settlement']['hotel_id']);
    foreach ($signers as $signer) {
      if (isset($signer['queue'])) {
        $notified = TRUE;
          foreach ($signer['queue'] as $uid => $user) {
            $this->onclick($message, $set_id, $user['channel']);
            $this->signatures_mail($signer['role'], $user['name'], $user['mail'], $set_id);
        }
        break;
      }
    }
    return $notified;
  }

  private function notify_purpose_signers($set_id) {
    $notified = FALSE;
    $signers1 = $this->get_purpose_signers($set_id, $this->data['settlement']['hotel_id']);
    foreach ($signers1 as $signer) {
      if (isset($signer['queue'])) {
        $notified = TRUE;
          foreach ($signer['queue'] as $uid => $user) {
            $this->purpose_signatures_mail($signer['role'], $user['name'], $user['mail'], $set_id);
        }
        break;
      }
    }
    return $notified;
  }

  public function notify($set_id) {
    $this->load->model('settlement_model');
    $this->load->model('users_model');
      $this->data['settlement'] = $this->settlement_model->get_settlement($set_id);
      $signes = $this->settlement_model->getby_verbal($set_id);
      $users = array();
      foreach ($signes as $signe){
        $users = $this->users_model->getby_criteria($signe['role_id'], $this->data['settlement']['hotel_id']);
        foreach($users as $user){
          if ($user['id'] != 30) {
            $name = $user['fullname'];
            $mail = $user['email'];
            $this->load->library('email');
              $this->load->helper('url');
              $pur_url = base_url().'settlement/purpose_view/'.$set_id;
              $this->email->from('e-signature@sunrise-resorts.com');
              $this->email->to($mail);
              $this->email->subject("Purpose of Report for Settlement Form No. #{$set_id}");
              $this->email->message("Dear {$name},<br/>
                        <br/>
                        Purpose of Report for Settlement Form No. #{$set_id} has been approved, Please use the link below:<br/>
                        <a href='{$pur_url}' target='_blank'>{$pur_url}</a><br/>
                        "); 
              $mail_result = $this->email->send();
          }
        }
    }
    redirect('settlement/purpose_view/'.$set_id);
  }

  public function notify_legal($set_id) {
    $this->load->model('settlement_model');
    $this->load->model('users_model');
    $this->data['settlement'] = $this->settlement_model->get_settlement($set_id);
    $users = $this->users_model->getby_criteria(54, $this->data['settlement']['hotel_id']);
    foreach($users as $user){
      if ($user['id'] != 30) {
        $name = $user['fullname'];
        $mail = $user['email'];
        $this->load->library('email');
        $this->load->helper('url');
        $set_url = base_url().'settlement/view/'.$set_id;
        $this->email->from('e-signature@sunrise-resorts.com');
        $this->email->to($mail);
        $this->email->subject("Settlement Form No. #{$set_id}");
        $this->email->message("Dear {$name},
          <br/>
          <br/>
          Settlement Form No. #{$set_id} has been created, Please use the link below:
          <br/>
          <a href='{$set_url}' target='_blank'>{$set_url}</a>
          <br/>
        "); 
        $mail_result = $this->email->send();
      }
    }
  }

  public function notify_edit_legal($set_id) {
    $this->load->model('settlement_model');
    $this->load->model('users_model');
    $this->data['settlement'] = $this->settlement_model->get_settlement($set_id);
    $users = $this->users_model->getby_criteria(54, $this->data['settlement']['hotel_id']);
    foreach($users as $user){
      if ($user != 30) {
        $name = $user['fullname'];
        $mail = $user['email'];
        $this->load->library('email');
        $this->load->helper('url');
        $set_url = base_url().'settlement/view/'.$set_id;
        $this->email->from('e-signature@sunrise-resorts.com');
        $this->email->to($mail);
        $this->email->subject("Settlement Form No. #{$set_id}");
        $this->email->message("Dear {$name},
          <br/>
          <br/>
          Settlement Form No. #{$set_id} has been Edited, Please use the link below:
          <br/>
          <a href='{$set_url}' target='_blank'>{$set_url}</a>
          <br/>
        "); 
        $mail_result = $this->email->send();
      }
    }
  }

  public function notify_approve_legal($set_id) {
    $this->load->model('settlement_model');
    $this->load->model('users_model');
    $this->data['settlement'] = $this->settlement_model->get_settlement($set_id);
    $user = $this->users_model->getby_criteria(54, $this->data['settlement']['hotel_id']);
    $name = $user['fullname'];
    $mail = $user['email'];
    $this->load->library('email');
    $this->load->helper('url');
    $set_url = base_url().'settlement/view/'.$set_id;
    $this->email->from('e-signature@sunrise-resorts.com');
    $this->email->to($mail);
    $this->email->subject("Settlement Form No. #{$set_id}");
    $this->email->message("Dear {$name},
      <br/>
      <br/>
      Settlement Form No. #{$set_id} has been Approved, Please use the link below:
      <br/>
      <a href='{$set_url}' target='_blank'>{$set_url}</a>
      <br/>
    "); 
    $mail_result = $this->email->send();
  }

  public function notify_reject_legal($set_id) {
    $this->load->model('settlement_model');
    $this->load->model('users_model');
    $this->data['settlement'] = $this->settlement_model->get_settlement($set_id);
    $user = $this->users_model->getby_criteria(54, $this->data['settlement']['hotel_id']);
    $name = $user['fullname'];
    $mail = $user['email'];
    $this->load->library('email');
    $this->load->helper('url');
    $set_url = base_url().'settlement/view/'.$set_id;
    $this->email->from('e-signature@sunrise-resorts.com');
    $this->email->to($mail);
    $this->email->subject("Settlement Form No. #{$set_id}");
    $this->email->message("Dear {$name},
      <br/>
      <br/>
      Settlement Form No. #{$set_id} has been Rejected, Please use the link below:
      <br/>
      <a href='{$set_url}' target='_blank'>{$set_url}</a>
      <br/>
    "); 
    $mail_result = $this->email->send();
  }

  private function signatures_mail($role, $name, $mail, $set_id) {
    $this->load->library('email');
    $this->load->helper('url');
    $set_url = base_url().'settlement/view/'.$set_id;
    $this->email->from('e-signature@sunrise-resorts.com');
    $this->email->to($mail);
    $this->email->subject("settlement {$set_id}");
    $this->email->message("Dear {$name},<br/>
              <br/>
              settlement {$set_id} requires your signature, Please use the link below:<br/>
              <a href='{$set_url}' target='_blank'>{$set_url}</a><br/>
              "); 
    $mail_result = $this->email->send();
  }

  private function purpose_signatures_mail($role, $name, $mail, $set_id) {
    $this->load->library('email');
    $this->load->helper('url');
    $pur_url = base_url().'settlement/purpose_view/'.$set_id;
    $this->email->from('e-signature@sunrise-resorts.com');
    $this->email->to($mail);
    $this->email->subject("Purpose of Report for Settlement Form No. #{$set_id}");
    $this->email->message("Dear {$name},<br/>
              <br/>
              Purpose of Report for Settlement Form No. #{$set_id} requires your signature, Please use the link below:<br/>
              <a href='{$pur_url}' target='_blank'>{$pur_url}</a><br/>
              "); 
    $mail_result = $this->email->send();
  }

  private function reject_mail($name, $email, $set_id) {
    $this->load->library('email');
    $this->load->helper('url');
    $set_url = base_url().'settlement/view/'.$set_id;
    $this->email->from('e-signature@sunrise-resorts.com');
    $this->email->to($email);
    $this->email->subject("Settlement Form No. #{$set_id}");
    $this->email->message("Dear {$name},<br/>
              <br/>
              Settlement Form No. #{$set_id} has been rejected, Please use the link below:<br/>
              <a href='{$set_url}' target='_blank'>{$set_url}</a><br/>
              "); 
    $mail_result = $this->email->send();
  }

  private function purpose_reject_mail($name, $email, $set_id) {
    $this->load->library('email');
    $this->load->helper('url');
    $pur_url = base_url().'settlement/purpose_view/'.$set_id;
    $this->email->from('e-signature@sunrise-resorts.com');
    $this->email->to($email);
    $this->email->subject("Purpose of Report for Settlement Form No. #{$set_id}");
    $this->email->message("Dear {$name},<br/>
              <br/>
              Purpose of Report for Settlement Form No. #{$set_id} has been rejected, Please use the link below:<br/>
              <a href='{$pur_url}' target='_blank'>{$pur_url}</a><br/>
              "); 
    $mail_result = $this->email->send();
  }

  private function approvel_mail($name, $email, $set_id) {
    $this->load->library('email');
    $this->load->helper('url');
    $set_url = base_url().'settlement/view/'.$set_id;
    $this->email->from('e-signature@sunrise-resorts.com');
    $this->email->to($email);
    $this->email->subject("Settlement Form No. #{$set_id}");
    $this->email->message("Dear {$name},<br/>
              <br/>
              Settlement Form No. #{$set_id} has been approved, Please use the link below:<br/>
              <a href='{$set_url}' target='_blank'>{$set_url}</a><br/>
              "); 
    $mail_result = $this->email->send();
  }

  private function purpose_approvel_mail($name, $email, $set_id) {
    $this->load->library('email');
    $this->load->helper('url');
    $pur_url = base_url().'settlement/purpose_view/'.$set_id;
    $this->email->from('e-signature@sunrise-resorts.com');
    $this->email->to($email);
    $this->email->subject("Purpose of Report for Settlement Form No. #{$set_id}");
    $this->email->message("Dear {$name},<br/>
              <br/>
              Purpose of Report for Settlement Form No. #{$set_id} has been approved, Please use the link below:<br/>
              <a href='{$pur_url}' target='_blank'>{$pur_url}</a><br/>
              "); 
    $mail_result = $this->email->send();
  }

  public function mailto($set_id) {
    if ($this->input->post('submit')) {
      $this->load->library('form_validation');
      $this->form_validation->set_rules('message','message is required','trim|required');
      $this->form_validation->set_rules('mail','mail is required','trim|required');
      if ($this->form_validation->run() == TRUE) {
        $message = $this->input->post('message');
        //die(print_r($message));
        $email = $this->input->post('mail');
        //die(print_r($email));
        $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
        //die(print_r($user));
        $this->load->library('email');
        $this->load->helper('url');
        $set_url = base_url().'settlement/view/'.$set_id;
        $this->email->from('e-signature@sunrise-resorts.com');
        $this->email->to($email);
        $this->email->subject("A message from {$user->fullname}, settlement No.{$set_id}");
        $this->email->message("{$user->fullname} sent you a private message regarding settlement {$set_id}:<br/>
                  {$message}<br />
                  <br />
                  Please use the link below to view the settlement:
                  <a href='{$set_url}' target='_blank'>{$set_url}</a><br/>
                "); 
        $mail_result = $this->email->send();
        //die(print_r($mail_result));
      }
    }
    redirect('settlement/view/'.$set_id);
  }

  public function share_url($set_id) {
        if ($this->input->post('submit')) {
          $message = $this->input->post('message');
          $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
          $set_url = base_url().'settlement/view/'.$set_id;
          $messages = "{$user->fullname}  Settlement No. {$set_id}
            {$set_url}";  
          $this->onclick($messages, $set_id, $this->config->item('page_to_send'));
        }
        redirect('settlement/view/'.$set_id);
      }

  public function  purpose_mailto($set_id) {
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
        $pur_url = base_url().'settlement/purpose_view/'.$set_id;
        $this->email->from('e-signature@sunrise-resorts.com');
        $this->email->to($email);
        $this->email->subject("A message from {$user->fullname}, Purpose of Report for Settlement Form No. #{$set_id}");
        $this->email->message("{$user->fullname} sent you a private message regarding Purpose of Report for Settlement Form No. #{$set_id}:<br/>
                  {$message}<br />
                  <br />
                  Please use the link below to view the Purpose of Report for Settlement Form:
                  <a href='{$pur_url}' target='_blank'>{$pur_url}</a><br/>
                "); 
        $mail_result = $this->email->send();
      }
    }
    redirect('settlement/purpose_view/'.$set_id);
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
  
  public function report_all() {
        if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
      $this->load->helper('form');
      if ($this->input->post('submit')) {
        $this->data['state'] = $this->input->post('state');
        $from_date = $this->input->post('from');
        $to_date = $this->input->post('to');
        $from_date .="-01 00:00:00";
        $to_date .= "-31 23:59:59";
        $this->load->model('settlement_model');
        $this->load->model('hotels_model');   
        $this->data['hotels'] = $this->hotels_model->getall();
        $this->data['app'] = $this->settlement_model->getall_approved($from_date, $to_date);
        $this->data['app_count'] = $this->settlement_model->getall_approved_count($from_date, $to_date);
        $count1 =  array();
        foreach ($this->data['app'] as $re) {
          $count1[] = $re['hotel_name'];
        }
        $this->data['count1'] = array_count_values($count1);
        $this->data['app_value'] =  array();
        $i = 0;
        foreach ($this->data['count1'] as $key => $value) {
          $this->data['app_value'][$i] = $this->settlement_model->get_app_value($from_date, $to_date, $key);
          $i++;
        }
        //die(print_r($this->data['app_value']));
        $this->data['wait'] = $this->settlement_model->getall_wait($from_date, $to_date);
        $this->data['wait_count'] = $this->settlement_model->getall_wait_count($from_date, $to_date);
        $count =  array();
        foreach ($this->data['wait'] as $re) {
          $count[] = $re['hotel_name'];
        }
        $this->data['count'] = array_count_values($count);
        $this->data['wait_value'] =  array();
        $i = 0;
        foreach ($this->data['count'] as $key => $value) {
          $this->data['wait_value'][$i] = $this->settlement_model->get_wait_value($from_date, $to_date, $key);
          $i++;
        }
        //die(print_r($this->data['wait_value']));
        $this->data['reje'] = $this->settlement_model->getall_reject($from_date, $to_date);
        $this->data['reje_count'] = $this->settlement_model->getall_reject_count($from_date, $to_date);
        $count2 =  array();
        foreach ($this->data['reje'] as $re) {
          $count2[] = $re['hotel_name'];
        }
        $this->data['count2'] = array_count_values($count2);
        $this->data['reje_value'] =  array();
        $i = 0;
        foreach ($this->data['count2'] as $key => $value) {
          $this->data['reje_value'][$i] = $this->settlement_model->get_reje_value($from_date, $to_date, $key);
          $i++;
        }
        $this->data['char'] = $this->settlement_model->getall_chairman($from_date, $to_date);
        $this->data['char_count'] = $this->settlement_model->getall_chairman_count($from_date, $to_date);
        $count3 =  array();
        foreach ($this->data['char'] as $re) {
          $count3[] = $re['hotel_name'];
        }
        $this->data['count3'] = array_count_values($count3);
        $this->data['char_value'] =  array();
        $i = 0;
        foreach ($this->data['count3'] as $key => $value) {
          $this->data['char_value'][$i] = $this->settlement_model->get_char_value($from_date, $to_date, $key);
          $i++;
        }
        $this->data['close'] = $this->settlement_model->getall_close($from_date, $to_date);
        $this->data['close_count'] = $this->settlement_model->getall_close_count($from_date, $to_date);
        $count4 =  array();
        foreach ($this->data['close'] as $re) {
          $count4[] = $re['hotel_name'];
        }
        $this->data['count4'] = array_count_values($count4);
        $this->data['close_value'] =  array();
        $i = 0;
        foreach ($this->data['count4'] as $key => $value) {
          $this->data['close_value'][$i] = $this->settlement_model->get_close_value($from_date, $to_date, $key);
          $i++;
        }
      }
      $this->load->view('settlement_report', $this->data);
    }else{
      redirect('/unknown');
    }
  }

  public function report_hotel() {
        if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
      $this->load->helper('form');
      $this->load->model('hotels_model');   
      $this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
      if ($this->input->post('submit')) {
        $this->data['state'] = $this->input->post('state');
        $from_date = $this->input->post('from');
        $to_date = $this->input->post('to');
        $from_date .="-01 00:00:00";
        $to_date .= "-31 23:59:59";
        $hotel_id = $this->input->post('hotel_id');
        $this->load->model('settlement_model');
        $this->data['app'] = $this->settlement_model->get_approved($hotel_id, $from_date, $to_date);
        $this->data['app_count'] = $this->settlement_model->get_approved_count($hotel_id, $from_date, $to_date);
        $this->data['wait'] = $this->settlement_model->get_wait($hotel_id, $from_date, $to_date);
        $this->data['wait_count'] = $this->settlement_model->get_wait_count($hotel_id, $from_date, $to_date);
        $this->data['reje'] = $this->settlement_model->get_reject($hotel_id, $from_date, $to_date);
        $this->data['reje_count'] = $this->settlement_model->get_reject_count($hotel_id, $from_date, $to_date);
        $this->data['char'] = $this->settlement_model->get_chairman($hotel_id, $from_date, $to_date);
        $this->data['char_count'] = $this->settlement_model->get_chairman_count($hotel_id, $from_date, $to_date);
        $this->data['close'] = $this->settlement_model->get_close($hotel_id, $from_date, $to_date);
        $this->data['close_count'] = $this->settlement_model->get_close_count($hotel_id, $from_date, $to_date);
      }
      $this->load->view('settlement_report_hotel', $this->data);
    }else{
      redirect('/unknown');
    }
  }

  public function report_states_all() {
        if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
      $this->load->helper('form');
      if ($this->input->post('submit')) {
      	$state = $this->input->post('state');
        $from_date = $this->input->post('from');
        $to_date = $this->input->post('to');
      	if ($state != NULL) {
			$this->data['state'] = $state;
		}
        $this->data['from_date'] = $from_date;
        $this->data['to_date'] = $to_date;
        $from_date .="-01 00:00:00";
        $to_date .= "-31 23:59:59";
        $this->load->model('settlement_model');
        $this->load->model('hotels_model');   
        $this->data['forms'] = $this->settlement_model->getall_state($state, $from_date, $to_date);
        $this->data['forms_count'] = $this->settlement_model->getall_state_count($state, $from_date, $to_date);
        $count =  array();
        foreach ($this->data['forms'] as $re) {
          $count[] = $re['hotel_name'];
        }
        $this->data['count'] = array_count_values($count);
        $this->data['form_value'] =  array();
        $i = 0;
        foreach ($this->data['count'] as $key => $value) {
          $this->data['form_value'][$i] = $this->settlement_model->getall_state_value($state, $from_date, $to_date, $key);
          $i++;
        }
      }
      $this->load->view('settlement_state_report', $this->data);
    }else{
      redirect('/unknown');
    }
  }

  public function report_states() {
        if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
      $this->load->helper('form');
      $this->load->model('hotels_model');   
      $this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
      if ($this->input->post('submit')) {
      	$state = $this->input->post('state');
        $from_date = $this->input->post('from');
        $to_date = $this->input->post('to');
        $hotel_id = $this->input->post('hotel_id');
        if ($state != NULL) {
			$this->data['state'] = $state;
		}
        $this->data['from_date'] = $from_date;
        $this->data['to_date'] = $to_date;
        if ($hotel_id != NULL) {
			$this->data['hotel'] = $this->hotels_model->get_by_id($hotel_id);
		}
        $from_date .="-01 00:00:00";
        $to_date .= "-31 23:59:59";
        $this->load->model('settlement_model');
        $this->data['forms'] = $this->settlement_model->get_state($state, $from_date, $to_date, $hotel_id);
        $this->data['forms_count'] = $this->settlement_model->get_state_count($state, $from_date, $to_date, $hotel_id);
      }
      $this->load->view('settlement_state_report_hotel', $this->data);
    }else{
      redirect('/unknown');
    }
  }

  public function set_reports() {
        if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
        $this->load->view('settlement_report_index.php', $this->data);
    }else{
      redirect('/unknown');
    }
  }

  function onclick($message, $id, $channelss){
      include(APPPATH . 'third_party/RocketChat/autoload.php');
      $client = new RocketChat\Client($this->config->item('send_url'));
      $token = $client->api('user')->login($this->config->item('user_access'),$this->config->item('pass_access'));
      $client->setToken($token);
      $channel_result = $client->api('channel')->sendMessage($channelss,$message);
      $this->load->model('settlement_model');
      $this->settlement_model->update_message_id($id, $channel_result);
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