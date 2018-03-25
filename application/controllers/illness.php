<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  class illness extends CI_Controller {

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

    public function index() {
          if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
        $this->load->model('users_model');
        $this->load->model('hotels_model');
        $this->load->model('illness_model');  
        $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
        $hotels = array();
        foreach ($user_hotels as $hotel) {
          $hotels[] = $hotel['id'];
        }    
        $this->data['illness'] = $this->illness_model->view($hotels);
        $count =  array();
        foreach ($this->data['illness'] as $re) {
          $count[] = $re['date'] ;
        }
        $this->data['count'] = array_count_values($count);
        $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
        $this->load->view('iln_index', $this->data);
      }else{
        redirect('/unknown');
      }
    }

    public function index_month($date) {
          if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
        $this->load->model('users_model');
        $this->load->model('hotels_model');
        $this->load->model('illness_model');  
        $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
        $hotels = array();
        foreach ($user_hotels as $hotel) {
          $hotels[] = $hotel['id'];
        }     
        $this->data['date'] = $date;
        $this->data['illness'] = $this->illness_model->view_month($hotels, $date);
        $count =  array();
        foreach ($this->data['illness'] as $re) {
          $count[] = $re['hotel_code'] ;
        }
        $this->data['count'] = array_count_values($count);
        $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
        $this->load->view('iln_index_month', $this->data);
      }else{
        redirect('/unknown');
      }
    }

    public function index_hotel($date, $hotel_code) {
          if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
        $this->load->model('users_model');
        $this->load->model('hotels_model');
        $this->load->model('illness_model');  
        $this->data['date'] = $date;
        $this->data['hotel'] = $this->illness_model->get_hotel($hotel_code); 
        $this->data['illness'] = $this->illness_model->view_hotel($this->data['hotel']['id'], $date);        
        $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
        $this->load->view('iln_index_hotel', $this->data);
      }else{
        redirect('/unknown');
      }
    }

    public function submit() {
          if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
        if ($this->input->post('submit')) {
          $this->load->library('form_validation');
          $this->load->library('email');
          $this->form_validation->set_rules('hotel_id','Hotel Name','trim|required');
          $assumed_id = $this->input->post('assumed_id');                        
          if ($this->form_validation->run() == TRUE) {
            $this->load->model('illness_model');
            $this->load->model('users_model');  
            $form_data = array(
              'user_id' => $this->data['user_id'],
              'hotel_id' => $this->input->post('hotel_id'),
              'date' => $this->input->post('date')
            );
            $iln_id = $this->illness_model->create_iln($form_data);
            if ($iln_id) {
              $this->load->model('illness_model');
              $this->illness_model->update_files($assumed_id,$iln_id);
            } else {
              die("ERROR");
            }
            foreach ($this->input->post('guests') as $guest) {
              $guest['iln_id'] = $iln_id;   
              $guest_id = $this->illness_model->create_guest($guest);    
              if (!$guest_id) {
                die("ERROR");
              }
            }       
        	$this->notify($iln_id);
            /*$signatures = $this->illness_model->iln_sign();
            foreach ($signatures as $iln_signature) {
              $this->illness_model->add_signature($iln_id, $iln_signature['role'], $iln_signature['department'], $iln_signature['rank']);
            }*/
            redirect('/illness/view/'.$iln_id);
          }
        }
        try {
          $this->load->helper('form');
          $this->load->model('illness_model');
          $this->load->model('hotels_model');
          $this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());
          $this->data['operators'] = $this->illness_model->getall_operator();
          if ($this->input->post('submit')) {
            $this->load->model('illness_model');
            $this->data['assumed_id'] = $this->input->post('assumed_id');
            $this->data['uploads'] = $this->illness_model->getby_fille($this->data['assumed_id']);
          } else {
            $this->data['assumed_id'] = strtoupper(str_pad(dechex( mt_rand( 0, 1048575 ) ), 5, '0', STR_PAD_LEFT));
            $this->data['uploads'] = array();
          }
          $this->load->view('iln_add_new',$this->data);
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
      }
    }

    public function make_offer($iln_id) {
      $file_name = $this->do_upload("upload");
      if (!$file_name) {
        die(json_encode($this->data['error']));
      } else {
        $this->load->model("illness_model");
        $this->illness_model->add($iln_id, $file_name, $this->data['user_id']);
        die("{}");
      }
    }

    public function remove_offer($iln_id, $id) {
      $file_name = $_POST['key'];
      if (!$id) {
        die(json_encode($this->data['error']));
      } else {
        $this->load->model("illness_model");
        $this->illness_model->remove($id);
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

    public function iln_stage($iln_id) {
      $this->load->model('illness_model');
      $this->data['illness'] = $this->illness_model->get_illness($iln_id);
      if ($this->data['illness']['state_id'] == 0) {
        $this->illness_model->update_state($iln_id, 1);
        redirect('/illness/iln_stage/'.$iln_id);
      } elseif ($this->data['illness']['state_id'] == 1 ){
        $this->notify($iln_id);
        $queue = $this->notify_signers($iln_id, $this->data['illness']['hotel_id']);
        if (!$queue) {
          $this->illness_model->update_state($iln_id, 2);
          $user = $this->users_model->get_user_by_id($this->data['illness']['user_id'], TRUE);
          $queue = $this->approvel_mail($user->fullname, $user->email, $iln_id);
          redirect('/illness/iln_stage/'.$iln_id);
        }
      }elseif ($this->data['illness']['state_id'] == 3){
        $user = $this->users_model->get_user_by_id($this->data['illness']['user_id'], TRUE);
        $queue = $this->reject_mail($user->fullname, $user->email, $iln_id);
      }
      redirect('/illness/view/'.$iln_id);
    }

    public function notify($iln_id) {
      	$this->load->model('illness_model');
	    $this->load->model('users_model');
    	$this->data['illness'] = $this->illness_model->get_illness($iln_id);
      	$signes = $this->illness_model->get_notifyer();
    	$users = array();
    	foreach ($signes as $signe){
      		$users = $this->users_model->getby_criteria($signe['role'], $this->data['illness']['hotel_id'], $signe['department']);
     		foreach($users as $user){
          if ($user['id'] != 30) {
		        $name = $user['fullname'];
		        $mail = $user['email'];
		        //die(print_r($user));
		        $this->load->library('email');
		        $this->load->helper('url');
      	  		$iln_url = base_url().'illness/view/'.$iln_id;
      			$this->email->from('e-signature@sunrise-resorts.com');
      			$this->email->to($mail);
          		$this->email->subject("Illness Log Form NO.#{$iln_id}");
            		$this->email->message("Dear {$name},
              		<br/>
              		<br/>
              		Illness Log Form NO.#{$iln_id} has been Created, Please use the link below:
              		<br/>
              		<a href='{$iln_url}' target='_blank'>{$iln_url}</a>
              		<br/>
            		"); 
          		$mail_result = $this->email->send();
        		}
          }
    	}
  	}

    private function notify_signers($iln_id) {
      $notified = FALSE;
      $signers = $this->get_signers($iln_id, $this->data['sp']['hotel_id']);
      foreach ($signers as $signer) {
        if (isset($signer['queue'])) {
          $notified = TRUE;
          foreach ($signer['queue'] as $uid => $user) {
            $this->signatures_mail($signer['role'], $signer['department'], $user['name'], $user['mail'], $iln_id);
          }
          break;
        }
      }
      return $notified;
    }

    private function get_signers($iln_id, $hotel_id) {
      $this->load->model('illness_model');
      $signatures = $this->illness_model->getby_verbal($iln_id);
      return $this->roll_signers($signatures, $hotel_id, $iln_id);
    }

    private function roll_signers($signatures, $hotel_id, $iln_id) {
      $signers = array();
      $this->load->model('users_model');
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
            $this->illness_model->update_state($iln_id, 3);
          } 
          $user = $this->users_model->get_user_by_id($signature['user_id'], TRUE);
          $signers[$signature['id']]['sign']['name'] = $user->fullname;
          $signers[$signature['id']]['sign']['mail'] = $user->email;
          $signers[$signature['id']]['sign']['sign'] = $user->signature;
          $signers[$signature['id']]['sign']['timestamp'] = $signature['timestamp'];
        } else {
          $signers[$signature['id']]['queue'] = array();
          $users = $this->users_model->getby_criteria($signature['role_id'], $hotel_id);
          foreach ($users as $use) {
            $signers[$signature['id']]['queue'][$use['id']] = array();
            $signers[$signature['id']]['queue'][$use['id']]['name'] = $use['fullname'];
            $signers[$signature['id']]['queue'][$use['id']]['mail'] = $use['email'];
          }
        }
      }
      return $signers;
    }

    private function signatures_mail($role, $department, $name, $mail, $iln_id) {
      $this->load->library('email');
      $this->load->helper('url');
      $iln_url = base_url().'illness/view/'.$iln_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($mail);
      $this->email->subject("Illness Log Form No. #{$iln_id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
        Illness Log Form No. #{$iln_id} requires your signature, Please use the link below:
        <br/>
        <a href='{$iln_url}' target='_blank'>{$iln_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
    }

    private function approvel_mail($name, $email, $iln_id) {
      $this->load->library('email');
      $this->load->helper('url');
      $iln_url = base_url().'illness/view/'.$iln_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($email);
      $this->email->subject("Illness Log Form No. #{$iln_id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
        Illness Log Form No. #{$iln_id} has been approved, Please use the link below:
        <br/>
        <a href='{$iln_url}' target='_blank'>{$iln_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
    }

    private function reject_mail($name, $email, $iln_id) {
      $this->load->library('email');
      $this->load->helper('url');
      $iln_url = base_url().'illness/view/'.$iln_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($email);
      $this->email->subject("Illness Log Form No. #{$iln_id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
        Illness Log Form No. #{$iln_id} has been rejected, Please use the link below:
        <br/>
        <a href='{$iln_url}' target='_blank'>{$iln_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
    }

    public function view($iln_id) {
          if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {     
        $this->load->model('illness_model');
        $this->load->model('hotels_model');   
        $this->data['hotels'] = $this->hotels_model->getall();
        $this->data['illness'] = $this->illness_model->get_illness($iln_id);
        $this->data['guests'] = $this->illness_model->get_guest($iln_id);
        $this->data['uploads'] = $this->illness_model->getby_fille($iln_id);
        $this->data['comments'] = $this->illness_model->get_comment($iln_id);
        $this->data['signature_path'] = '/assets/uploads/signatures/';
        $this->data['signers'] = $this->get_signers($this->data['illness']['id'], $this->data['illness']['hotel_id']);
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
          if ( ($this->data['illness']['user_id'] == $this->data['user_id']) &&  ($this->data['illness']['state_id'] != 2)) {
            $editor = TRUE;
          }
        }
        $this->data['unsign_enable'] = (($unsign_enable) || $this->data['is_admin'])? TRUE : FALSE;
        $this->data['is_editor'] = ( (($this->data['unsign_enable'] || $editor)) || ($force_edit) )? TRUE : FALSE;
        $this->load->view('iln_view', $this->data);
      }else{ 
        redirect('/unknown');
      }
    }

    public function edit($iln_id) {
          if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
        if ($this->input->post('submit')) {
          $this->load->library('form_validation');
          $this->load->library('email');
          $this->form_validation->set_rules('hotel_id','Hotel Name','trim|required');
          if ($this->form_validation->run() == TRUE) {
            $this->load->model('illness_model');
            $this->load->model('users_model');  
            $form_data = array(
              'hotel_id' => $this->input->post('hotel_id'),
              'date' => $this->input->post('date')
            );
            $this->illness_model->update_iln($form_data, $iln_id);
            foreach ($this->input->post('guests') as $guest) {
              $guest['iln_id'] = $iln_id;  
              $this->illness_model->update_guest($guest, $iln_id, $guest['id']);
            }
            $this->notify_edit_legal($iln_id);
            redirect('/illness/view/'.$iln_id);
          }   
        }
        try {
          $this->load->helper('form');
          $this->load->model('illness_model');
          $this->load->model('hotels_model');
          $this->data['illness'] = $this->illness_model->get_illness($iln_id);
          $this->data['guests'] = $this->illness_model->get_guest($iln_id);
          $this->data['operators'] = $this->illness_model->getall_operator();
          $this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());
          $this->data['uploads'] = $this->illness_model->getby_fille($this->data['illness']['id']);
          $this->load->view('iln_edit',$this->data);
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
      }else{ 
        redirect('/unknown');
      }
    }

    public function notify_edit_legal($iln_id) {
        $this->load->model('illness_model');
      $this->load->model('users_model');
      $this->data['illness'] = $this->illness_model->get_illness($iln_id);
      $signes = $this->illness_model->get_notifyer();
      $users = array();
      foreach ($signes as $signe){
        $users = $this->users_model->getby_criteria($signe['role'], $this->data['illness']['hotel_id'], $signe['department']);
        foreach($users as $user){
          if ($user['id'] != 30) {
            $name = $user['fullname'];
            $mail = $user['email'];
            //die(print_r($user));
            $this->load->library('email');
            $this->load->helper('url');
              $iln_url = base_url().'illness/view/'.$iln_id;
            $this->email->from('e-signature@sunrise-resorts.com');
            $this->email->to($mail);
              $this->email->subject("Illness Log Form NO.#{$iln_id}");
                $this->email->message("Dear {$name},
                  <br/>
                  <br/>
                  Illness Log Form NO.#{$iln_id} has been Edited, Please use the link below:
                  <br/>
                  <a href='{$iln_url}' target='_blank'>{$iln_url}</a>
                  <br/>
                "); 
              $mail_result = $this->email->send();
            }
          }
      }
    }

    public function mailto($iln_id) {
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
          $iln_url = base_url().'illness/view/'.$iln_id;
          $this->email->from('e-signature@sunrise-resorts.com');
          $this->email->to($email);
          $this->email->subject("A message from {$user->fullname}, Illness Log Form No. #{$iln_id}");
          $this->email->message("{$user->fullname} sent you a private message regarding Illness Log Form No. #{$iln_id}:
            <br/>
            {$message}
            <br />
            <br />
            Please use the link below to view the Illness Log Form:
            <a href='{$iln_url}' target='_blank'>{$iln_url}</a>
            <br/>
          "); 
          $mail_result = $this->email->send();
        }
      }
      redirect('illness/view/'.$iln_id);
    }

    public function unsign($signature_id) {
      $this->load->model('illness_model');
      $this->load->model('users_model');
      $signature_identity = $this->illness_model->get_signature_identity($signature_id);
      $this->illness_model->unsign($signature_id);
      redirect('/illness/view/'.$signature_identity['iln_id']);
    }

    public function sign($signature_id, $reject = FALSE) {
      $this->load->model('illness_model');
      $signature_identity = $this->illness_model->get_signature_identity($signature_id);
      $signrs = $this->get_signers($signature_identity['iln_id'], $signature_identity['hotel_id']);
      $this->data['illness'] = $this->illness_model->get_illness($signature_identity['iln_id']);
      if (array_key_exists($this->data['user_id'], $signrs[$signature_id]['queue'])) {
        if ($reject) {
          $this->illness_model->reject($signature_id, $this->data['user_id']);
          redirect('/illness/iln_stage/'.$this->data['illness']['id']);  
        } else {
          $this->illness_model->sign($signature_id, $this->data['user_id']);
          redirect('/illness/iln_stage/'.$signature_identity['iln_id']);  
        }
      }
      redirect('/illness/view/'.$signature_identity['iln_id']);
    }

    public function comment($iln_id){
      if ($this->input->post('submit')) {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('comment','Comment','trim|required');
        if ($this->form_validation->run() == TRUE) {
          $comment = $this->input->post('comment'); 
          $this->load->model('illness_model');
          $comment_data = array(
            'user_id' => $this->data['user_id'],
            'iln_id' => $iln_id,
            'comment' => $comment
          );
          $this->illness_model->insert_comment($comment_data);
        }
        redirect('/illness/view/'.$iln_id);
      }
    }

    public function report_custom_hotel() {
          if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
        $this->load->helper('form');
        $this->load->model('hotels_model');   
        $this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
        if ($this->input->post('submit')) {
          $this->load->model('users_model');
          $this->load->model('illness_model');  
          $hotel_id = $this->input->post('hotel_id');  
          $this->data['hotel'] = $this->hotels_model->get_by_id($hotel_id);
          $this->data['illness'] = $this->illness_model->report_hotel($hotel_id);
        }
        $this->load->view('iln_custom_hotel_report', $this->data);
      }else{
        redirect('/unknown');
      }
    }

    public function report_custom_date() {
          if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
        $this->load->helper('form');
        $this->load->model('hotels_model');   
        $this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
        if ($this->input->post('submit')) {
          $this->load->model('users_model');
          $this->load->model('illness_model');  
          $from_date = $this->input->post('from');
          $to_date = $this->input->post('to');
          $hotel_id = $this->input->post('hotel_id');  
          $this->data['from'] = $from_date;
          $this->data['to'] = $to_date;
          $this->data['hotel'] = $this->hotels_model->get_by_id($hotel_id);
          $this->data['illness'] = $this->illness_model->report_date($hotel_id, $from_date, $to_date);
        }
        $this->load->view('iln_custom_date_report', $this->data);
      }else{
        redirect('/unknown');
      }
    }

    public function report_custom_guest() {
          if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
        $this->load->helper('form');
        $this->load->model('hotels_model');   
        $this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
        if ($this->input->post('submit')) {
          $this->load->model('users_model');
          $this->load->model('illness_model');  
          $guest = $this->input->post('guest');
          $hotel_id = $this->input->post('hotel_id');  
          $this->data['guest'] = $guest;
          $this->data['hotel'] = $this->hotels_model->get_by_id($hotel_id);
          $this->data['illness'] = $this->illness_model->report_guest($hotel_id, $guest);
        }
        $this->load->view('iln_custom_guest_report', $this->data);
      }else{
        redirect('/unknown');
      }
    }

    public function report_custom_to() {
          if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
        $this->load->helper('form');
        $this->load->model('hotels_model');  
        $this->load->model('illness_model');  
        $this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
        $this->data['operators'] = $this->illness_model->getall_operator();
        if ($this->input->post('submit')) {
          $this->load->model('users_model');
          $operator_id = $this->input->post('operator_id');
          $hotel_id = $this->input->post('hotel_id');  
          $this->data['operator'] = $this->illness_model->get_operator($operator_id);
          $this->data['hotel'] = $this->hotels_model->get_by_id($hotel_id);
          $this->data['illness'] = $this->illness_model->report_to($hotel_id, $operator_id);
        }
        $this->load->view('iln_custom_to_report', $this->data);
      }else{
        redirect('/unknown');
      }
    }

    public function report_custom_symptoms() {
          if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
        $this->load->helper('form');
        $this->load->model('hotels_model');  
        $this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
        if ($this->input->post('submit')) {
          $this->load->model('users_model');
          $this->load->model('illness_model');
          $symptoms = $this->input->post('symptoms');
          $hotel_id = $this->input->post('hotel_id');  
          $this->data['symptoms'] = $symptoms;
          $this->data['hotel'] = $this->hotels_model->get_by_id($hotel_id);
          $this->data['illness'] = $this->illness_model->report_symptoms($hotel_id, $symptoms);
        }
        $this->load->view('iln_custom_symptoms_report', $this->data);
      }else{
        redirect('/unknown');
      }
    }

    public function report_custom_visit() {
          if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
        $this->load->helper('form');
        $this->load->model('hotels_model');  
        $this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
        if ($this->input->post('submit')) {
          $this->load->model('users_model');
          $this->load->model('illness_model');
          $visit = $this->input->post('visit');
          $hotel_id = $this->input->post('hotel_id');  
          $this->data['visit'] = $visit;
          $this->data['hotel'] = $this->hotels_model->get_by_id($hotel_id);
          $this->data['illness'] = $this->illness_model->report_visit($hotel_id, $visit);
        }
        $this->load->view('iln_custom_visit_report', $this->data);
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
          $this->load->model('users_model');
          $this->load->model('illness_model');  
          $hotel_id = $this->input->post('hotel_id');  
          $this->data['hotel'] = $this->hotels_model->get_by_id($hotel_id);
          $this->data['illness'] = $this->illness_model->report_hotel($hotel_id);
        }
        $this->load->view('iln_hotel_report', $this->data);
      }else{
        redirect('/unknown');
      }
    }

    public function report_date() {
          if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
        $this->load->helper('form');
        $this->load->model('hotels_model');   
        $this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
        if ($this->input->post('submit')) {
          $this->load->model('users_model');
          $this->load->model('illness_model');  
          $from_date = $this->input->post('from');
          $to_date = $this->input->post('to');
          $hotel_id = $this->input->post('hotel_id');  
          $this->data['from'] = $from_date;
          $this->data['to'] = $to_date;
          $this->data['hotel'] = $this->hotels_model->get_by_id($hotel_id);
          $this->data['illness'] = $this->illness_model->report_date($hotel_id, $from_date, $to_date);
        }
        $this->load->view('iln_date_report', $this->data);
      }else{
        redirect('/unknown');
      }
    }

    public function report_guest() {
          if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
        $this->load->helper('form');
        $this->load->model('hotels_model');   
        $this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
        if ($this->input->post('submit')) {
          $this->load->model('users_model');
          $this->load->model('illness_model');  
          $guest = $this->input->post('guest');
          $hotel_id = $this->input->post('hotel_id');  
          $this->data['guest'] = $guest;
          $this->data['hotel'] = $this->hotels_model->get_by_id($hotel_id);
          $this->data['illness'] = $this->illness_model->report_guest($hotel_id, $guest);
        }
        $this->load->view('iln_guest_report', $this->data);
      }else{
        redirect('/unknown');
      }
    }

    public function report_to() {
          if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
        $this->load->helper('form');
        $this->load->model('hotels_model');  
        $this->load->model('illness_model');  
        $this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
        $this->data['operators'] = $this->illness_model->getall_operator();
        if ($this->input->post('submit')) {
          $this->load->model('users_model');
          $operator_id = $this->input->post('operator_id');
          $hotel_id = $this->input->post('hotel_id');  
          $this->data['operator'] = $this->illness_model->get_operator($operator_id);
          $this->data['hotel'] = $this->hotels_model->get_by_id($hotel_id);
          $this->data['illness'] = $this->illness_model->report_to($hotel_id, $operator_id);
        }
        $this->load->view('iln_to_report', $this->data);
      }else{
        redirect('/unknown');
      }
    }

    public function report_symptoms() {
          if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
        $this->load->helper('form');
        $this->load->model('hotels_model');  
        $this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
        if ($this->input->post('submit')) {
          $this->load->model('users_model');
          $this->load->model('illness_model');
          $symptoms = $this->input->post('symptoms');
          $hotel_id = $this->input->post('hotel_id');  
          $this->data['symptoms'] = $symptoms;
          $this->data['hotel'] = $this->hotels_model->get_by_id($hotel_id);
          $this->data['illness'] = $this->illness_model->report_symptoms($hotel_id, $symptoms);
        }
        $this->load->view('iln_symptoms_report', $this->data);
      }else{
        redirect('/unknown');
      }
    }

    public function report_visit() {
          if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
        $this->load->helper('form');
        $this->load->model('hotels_model');  
        $this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
        if ($this->input->post('submit')) {
          $this->load->model('users_model');
          $this->load->model('illness_model');
          $visit = $this->input->post('visit');
          $hotel_id = $this->input->post('hotel_id');  
          $this->data['visit'] = $visit;
          $this->data['hotel'] = $this->hotels_model->get_by_id($hotel_id);
          $this->data['illness'] = $this->illness_model->report_visit($hotel_id, $visit);
        }
        $this->load->view('iln_visit_report', $this->data);
      }else{
        redirect('/unknown');
      }
    }

    public function report_custom_date_all() {
          if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
        $this->load->helper('form');
        $this->load->model('hotels_model');   
        $this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
        if ($this->input->post('submit')) {
          $this->load->model('users_model');
          $this->load->model('illness_model');  
          $from_date = $this->input->post('from');
          $to_date = $this->input->post('to');
          $this->data['from'] = $from_date;
          $this->data['to'] = $to_date;
          $this->data['illness'] = $this->illness_model->report_date_all($from_date, $to_date);
        }
        $this->load->view('iln_custom_date_all_report', $this->data);
      }else{
        redirect('/unknown');
      }
    }

    public function report_custom_guest_all() {
          if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
        $this->load->helper('form');
        $this->load->model('hotels_model');   
        $this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
        if ($this->input->post('submit')) {
          $this->load->model('users_model');
          $this->load->model('illness_model');  
          $guest = $this->input->post('guest');
          $this->data['guest'] = $guest;
          $this->data['illness'] = $this->illness_model->report_guest_all($guest);
        }
        $this->load->view('iln_custom_guest_all_report', $this->data);
      }else{
        redirect('/unknown');
      }
    }

    public function report_custom_to_all() {
          if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
        $this->load->helper('form');
        $this->load->model('hotels_model');  
        $this->load->model('illness_model');  
        $this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
        $this->data['operators'] = $this->illness_model->getall_operator();
        if ($this->input->post('submit')) {
          $this->load->model('users_model');
          $operator_id = $this->input->post('operator_id');
          $this->data['operator'] = $this->illness_model->get_operator($operator_id);
          $this->data['illness'] = $this->illness_model->report_to_all($operator_id);
        }
        $this->load->view('iln_custom_to_all_report', $this->data);
      }else{
        redirect('/unknown');
      }
    }

    public function report_custom_symptoms_all() {
          if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
        $this->load->helper('form');
        $this->load->model('hotels_model');  
        $this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
        if ($this->input->post('submit')) {
          $this->load->model('users_model');
          $this->load->model('illness_model');
          $symptoms = $this->input->post('symptoms');
          $this->data['symptoms'] = $symptoms;
          $this->data['illness'] = $this->illness_model->report_symptoms_all($symptoms);
        }
        $this->load->view('iln_custom_symptoms_all_report', $this->data);
      }else{
        redirect('/unknown');
      }
    }

    public function report_custom_visit_all() {
          if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
        $this->load->helper('form');
        $this->load->model('hotels_model');  
        $this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
        if ($this->input->post('submit')) {
          $this->load->model('users_model');
          $this->load->model('illness_model');
          $visit = $this->input->post('visit');
          $this->data['visit'] = $visit;
          $this->data['illness'] = $this->illness_model->report_visit_all($visit);
        }
        $this->load->view('iln_custom_visit_all_report', $this->data);
      }else{
        redirect('/unknown');
      }
    }

    public function report_date_all() {
          if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
        $this->load->helper('form');
        $this->load->model('hotels_model');   
        $this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
        if ($this->input->post('submit')) {
          $this->load->model('users_model');
          $this->load->model('illness_model');  
          $from_date = $this->input->post('from');
          $to_date = $this->input->post('to');
          $this->data['from'] = $from_date;
          $this->data['to'] = $to_date;
          $this->data['illness'] = $this->illness_model->report_date_all($from_date, $to_date);
        }
        $this->load->view('iln_date_all_report', $this->data);
      }else{
        redirect('/unknown');
      }
    }

    public function report_guest_all() {
          if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
        $this->load->helper('form');
        $this->load->model('hotels_model');   
        $this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
        if ($this->input->post('submit')) {
          $this->load->model('users_model');
          $this->load->model('illness_model');  
          $guest = $this->input->post('guest');
          $this->data['guest'] = $guest;
          $this->data['illness'] = $this->illness_model->report_guest_all($guest);
        }
        $this->load->view('iln_guest_all_report', $this->data);
      }else{
        redirect('/unknown');
      }
    }

    public function report_to_all() {
          if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
        $this->load->helper('form');
        $this->load->model('hotels_model');  
        $this->load->model('illness_model');  
        $this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
        $this->data['operators'] = $this->illness_model->getall_operator();
        if ($this->input->post('submit')) {
          $this->load->model('users_model');
          $operator_id = $this->input->post('operator_id');
          $this->data['operator'] = $this->illness_model->get_operator($operator_id);
          $this->data['illness'] = $this->illness_model->report_to_all($operator_id);
        }
        $this->load->view('iln_to_all_report', $this->data);
      }else{
        redirect('/unknown');
      }
    }

    public function report_symptoms_all() {
          if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
        $this->load->helper('form');
        $this->load->model('hotels_model');  
        $this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
        if ($this->input->post('submit')) {
          $this->load->model('users_model');
          $this->load->model('illness_model');
          $symptoms = $this->input->post('symptoms');
          $this->data['symptoms'] = $symptoms;
          $this->data['illness'] = $this->illness_model->report_symptoms_all($symptoms);
        }
        $this->load->view('iln_symptoms_all_report', $this->data);
      }else{
        redirect('/unknown');
      }
    }

    public function report_visit_all() {
          if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
        $this->load->helper('form');
        $this->load->model('hotels_model');  
        $this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
        if ($this->input->post('submit')) {
          $this->load->model('users_model');
          $this->load->model('illness_model');
          $visit = $this->input->post('visit');
          $this->data['visit'] = $visit;
          $this->data['illness'] = $this->illness_model->report_visit_all($visit);
        }
        $this->load->view('iln_visit_all_report', $this->data);
      }else{
        redirect('/unknown');
      }
    }

  }

?>