<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  class credit extends CI_Controller {

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
        if ($state == 12) {
          $states = $this->input->post('states_id');
        }else{
          $states = $state;
        }
        $this->load->model('hotels_model');
        $this->load->model('credit_model');
        $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
        $hotels = array();
        foreach ($user_hotels as $hotel) {
          $hotels[] = $hotel['id'];
        }  
        $this->data['credits'] = $this->credit_model->view($hotels, $states);
        foreach ($this->data['credits'] as $key => $credit) {
          $this->data['credits'][$key]['approvals'] = $this->credit_model->get_by_verbals($this->data['credits'][$key]['id']);
        } 
        if ($this->input->post('submit')) {
          $this->data['var'] = $this->input->post('states_id');
        }
        $this->data['hotels'] = $user_hotels;
        $this->data['state'] = $state;
        $this->data['states'] = $this->credit_model->get_states();
        $this->load->view('credit_index', $this->data);
      }
    }

    public function submit() {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        if ($this->input->post('submit')) {
          $this->load->library('form_validation');
          $this->load->library('email');
          $this->load->model('credit_model');
          $this->load->model('users_model'); 
          $this->form_validation->set_rules('hotel_id','Hotel Name','trim|required');
          $this->form_validation->set_rules('date','Date','trim|required');
          $assumed_id = $this->input->post('assumed_id'); 
          if ($this->form_validation->run() == TRUE) {
            $data = array(
              'user_id' => $this->data['user_id'],
              'ip' => $this->input->ip_address(),
              'hotel_id' => $this->input->post('hotel_id'),
              'date' => $this->input->post('date'),
              'company' => $this->input->post('company'),
              'address' => $this->input->post('address'),
              'person' => $this->input->post('person'),
              'tele' => $this->input->post('tele'),
              'email' => $this->input->post('email'),
              'period_from' => $this->input->post('period_from'),
              'period_to' => $this->input->post('period_to'),
              'rooms' => $this->input->post('rooms'),
              'contract_type' => $this->input->post('contract_type'),
              'cash' => $this->input->post('cash'),
              'currency' => $this->input->post('currency'),
              'letter' => $this->input->post('letter'),
              'renew_date' => $this->input->post('renew_date'),
              'method' => $this->input->post('method'),
              'limits' => $this->input->post('limits'),
              'currency1' => $this->input->post('currency1'),
              'note' => $this->input->post('note'),
              'terms' => $this->input->post('terms'),
              'ability' => $this->input->post('ability'),
              'remarks' => $this->input->post('remarks'),
              'nb' => $this->input->post('nb')
            );
            $credit_id = $this->credit_model->create_credit($data);
            if ($credit_id) {
              $this->credit_model->update_files($assumed_id,$credit_id);
            } else {
              die("ERROR");
            }
            $signatures = $this->credit_model->credit_sign();
            $do_sign = $this->credit_model->credit_do_sign($credit_id);
            if ($do_sign == 0) {
              foreach ($signatures as $credit_signature) {
                $this->credit_model->add_signature($credit_id, $credit_signature['role'], $credit_signature['department'], $credit_signature['rank']);
              }
            }
            redirect('/credit/credit_stage/'.$credit_id);
          }
        }
        try {
          $this->load->helper('form');
          $this->load->model('credit_model');
          $this->load->model('hotels_model');
          $this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
          if ($this->input->post('submit')) {
            $this->data['assumed_id'] = "0".mt_rand("1048575","10485751048575");
            $this->data['uploads'] = $this->credit_model->get_by_fille($this->data['assumed_id']);
          } else {
            $this->data['assumed_id'] = "0".mt_rand("1048575","10485751048575");
            $this->data['uploads'] = array();
          }
          $this->load->view('credit_add_new',$this->data);
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
      }
    }

    public function upload($credit_id) {
      $file_name = $this->do_upload("upload");
      if (!$file_name) {
        die(json_encode($this->data['error']));
      } else {
        $this->load->model("credit_model");
        $this->credit_model->add_fille($credit_id, $file_name, $this->data['user_id']);
        die("{}");
      }
    }

    public function remove($credit_id, $id) {
      $file_name = $_POST['key'];
      if (!$id) {
        die(json_encode($this->data['error']));
      } else {
        $this->load->model("credit_model");
        $this->credit_model->remove_fille($id);
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

    public function credit_stage($credit_id) {
      $this->load->model('credit_model');
      $this->data['credit'] = $this->credit_model->get_credit($credit_id);
      if ($this->data['credit']['state_id'] == 0) {
        $this->credit_model->update_state($credit_id, 1);
        redirect('/credit/credit_stage/'.$credit_id);
      }elseif ($this->data['credit']['state_id'] == 3){
        $user = $this->users_model->get_user_by_id($this->data['credit']['user_id'], TRUE);
        $queue = $this->reject_mail($user->fullname, $user->email, $credit_id);
      }elseif ($this->data['credit']['state_id'] != 2){
        $queue = $this->notify_signers($credit_id, $this->data['credit']['hotel_id']);
        if (!$queue) {
          $this->credit_model->update_state($credit_id, 2);
          $user = $this->users_model->get_user_by_id($this->data['credit']['user_id'], TRUE);
          $queue = $this->approvel_mail($user->fullname, $user->email, $credit_id);
          redirect('/credit/credit_stage/'.$credit_id);
        }
      }
      redirect('/credit/view/'.$credit_id);
    }

    private function reject_mail($name, $email, $credit_id) {
      $this->load->library('email');
      $this->load->helper('url');
      $credit_url = base_url().'credit/view/'.$credit_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($email);
      $this->email->subject("Credit Authorization Form No. #{$credit_id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
        Credit Authorization Form No. #{$credit_id} has been rejected, Please use the link below:
        <br/>
        <a href='{$credit_url}' target='_blank'>{$credit_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
    }

    private function notify_signers($credit_id, $hotel_id) {
      $notified = FALSE;
      $credit_url = base_url().'credit/view/'.$credit_id;
      $message = "Credit Authorization Form No. {$credit_id}:
        {$credit_url}";
      $signers = $this->get_signers($credit_id, $hotel_id);
      foreach ($signers as $signer) {
        if (isset($signer['queue'])) {
          $notified = TRUE;
          foreach ($signer['queue'] as $uid => $user) {
            $this->onclick($message, $credit_id, $user['channel']);
            $this->signatures_mail($signer['role'], $signer['department'], $user['name'], $user['mail'], $credit_id);
          }
          break;
        }
      }
      return $notified;
    }

    private function get_signers($credit_id, $hotel_id) {
      $this->load->model('credit_model');
      $signatures = $this->credit_model->get_by_verbal($credit_id);
      return $this->roll_signers($signatures, $hotel_id, $credit_id);
    }

    private function roll_signers($signatures, $hotel_id, $credit_id) {
      $signers = array();
      $this->load->model('users_model');
      $this->load->model('credit_model');
      $credit = $this->credit_model->get_credit($credit_id);
      foreach ($signatures as $signature) {
        $signers[$signature['id']] = array();
        $signers[$signature['id']]['role'] = $signature['role'];
        $signers[$signature['id']]['role_id'] = $signature['role_id'];
        $signers[$signature['id']]['department'] = $signature['department'];
        $signers[$signature['id']]['department_id'] = $signature['department_id'];
        if ($signature['user_id']) {
          if ($signature['rank'] == 1){
            $this->credit_model->update_state($credit_id, 4);
          }elseif ($signature['rank'] == 2){
            $this->credit_model->update_state($credit_id, 5);
          }elseif ($signature['rank'] == 3){
            $this->credit_model->update_state($credit_id, 6);
          }elseif ($signature['rank'] == 4){
            $this->credit_model->update_state($credit_id, 7);
          }elseif ($signature['rank'] == 5){
            $this->credit_model->update_state($credit_id, 8);
          }elseif ($signature['rank'] == 6){
            $this->credit_model->update_state($credit_id, 9);
          }elseif ($signature['rank'] == 7){
            $this->credit_model->update_state($credit_id, 2);
          }
          $signers[$signature['id']]['sign'] = array();
          $signers[$signature['id']]['sign']['id'] = $signature['user_id'];
          if ($signature['reject'] == 1) {
            $signers[$signature['id']]['sign']['reject'] = "reject";
            $this->credit_model->update_state($credit_id, 3);
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
          $users = $this->users_model->getby_criteria($signature['role_id'], $hotel_id, $signature['department_id']);
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

    private function signatures_mail($role, $department, $name, $mail, $credit_id) {
      $this->load->library('email');
      $this->load->helper('url');
      $credit_url = base_url().'credit/view/'.$credit_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($mail);
      $this->email->subject("Credit Authorization Form No. #{$credit_id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
        Credit Authorization Form No. #{$credit_id} requires your signature, Please use the link below:
        <br/>
        <a href='{$credit_url}' target='_blank'>{$credit_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
    }

    private function approvel_mail($name, $email, $credit_id) {
      $this->load->library('email');
      $this->load->helper('url');
      $credit_url = base_url().'credit/view/'.$credit_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($email);
      $this->email->subject("Credit Authorization Form No. #{$credit_id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
        Credit Authorization Form No. #{$credit_id} has been approved, Please use the link below:
        <br/>
        <a href='{$credit_url}' target='_blank'>{$credit_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
    }

    public function view($credit_id) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{      
        $this->load->model('credit_model');
        $this->load->model('hotels_model');   
        $this->data['credit'] = $this->credit_model->get_credit($credit_id);
        $this->data['uploads'] = $this->credit_model->get_by_fille($credit_id);
        $this->data['comments'] = $this->credit_model->get_comment($credit_id);
        $this->data['signature_path'] = '/assets/uploads/signatures/';
        $this->data['signers'] = $this->get_signers($this->data['credit']['id'], $this->data['credit']['hotel_id']);
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
          if ( $this->data['credit']['user_id'] == $this->data['user_id'] &&  $this->data['credit']['state_id'] != 2) {
            $editor = TRUE;
          }
        }
        $this->data['unsign_enable'] = (($unsign_enable) || $this->data['is_admin'])? TRUE : FALSE;
        $this->data['is_editor'] = ($editor || $this->data['is_admin'])? TRUE : FALSE;
        $this->load->view('credit_view', $this->data);
      }
    }

    public function edit($credit_id) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        if ($this->input->post('submit')) {
          $this->load->library('form_validation');
          $this->load->library('email');
          $this->load->model('credit_model');
          $this->load->model('users_model'); 
          $this->form_validation->set_rules('hotel_id','Hotel Name','trim|required');
          $this->form_validation->set_rules('date','Date','trim|required');
          if ($this->form_validation->run() == TRUE) {  
            $data = array(
              'hotel_id' => $this->input->post('hotel_id'),
              'date' => $this->input->post('date'),
              'company' => $this->input->post('company'),
              'address' => $this->input->post('address'),
              'person' => $this->input->post('person'),
              'tele' => $this->input->post('tele'),
              'email' => $this->input->post('email'),
              'period_from' => $this->input->post('period_from'),
              'period_to' => $this->input->post('period_to'),
              'rooms' => $this->input->post('rooms'),
              'contract_type' => $this->input->post('contract_type'),
              'cash' => $this->input->post('cash'),
              'currency' => $this->input->post('currency'),
              'letter' => $this->input->post('letter'),
              'renew_date' => $this->input->post('renew_date'),
              'method' => $this->input->post('method'),
              'limits' => $this->input->post('limits'),
              'currency1' => $this->input->post('currency1'),
              'note' => $this->input->post('note'),
              'terms' => $this->input->post('terms'),
              'ability' => $this->input->post('ability'),
              'remarks' => $this->input->post('remarks'),
              'nb' => $this->input->post('nb')
            );
            $this->credit_model->update_credit($credit_id, $data);
            redirect('/credit/view/'.$credit_id);
          }   
        }
        try {
          $this->load->helper('form');
          $this->load->model('credit_model');
          $this->load->model('hotels_model');
          $this->data['credit'] = $this->credit_model->get_credit($credit_id);
          $this->data['uploads'] = $this->credit_model->get_by_fille($credit_id);
          $this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
          $this->load->view('credit_edit',$this->data);
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
      }
    }

    public function mail_me($credit_id) {
      $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
      $this->load->library('email');
      $this->load->helper('url');
      $credit_url = base_url().'credit/view/'.$credit_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($user->email);
      $this->email->subject("Credit Authorization Form No. #{$credit_id}");
      $this->email->message("Credit Authorization Form NO.#{$credit_id}:
        <br/>
        Please use the link below to view The Credit Authorization Form:
        <a href='{$credit_url}' target='_blank'>{$credit_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
      redirect('credit/view/'.$credit_id);
    }

    public function mail($credit_id) {
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
          $credit_url = base_url().'credit/view/'.$credit_id;
          $this->email->from('e-signature@sunrise-resorts.com');
          $this->email->to($email);
          $this->email->subject("A message from {$user->fullname}, Credit Authorization Form No. #{$credit_id}");
          $this->email->message("{$user->fullname} sent you a private message regarding Credit Authorization Form No. #{$credit_id}:
            <br/>
            {$message}
            <br />
            <br />
            Please use the link below to view the Credit Authorization Form:
            <a href='{$credit_url}' target='_blank'>{$credit_url}</a>
            <br/>
          "); 
          $mail_result = $this->email->send();
        }
      }
      redirect('credit/view/'.$credit_id);
    }

    public function share_url($credit_id) {
      if ($this->input->post('submit')) {
        $message = $this->input->post('message');
        $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
        $credit_url = base_url().'credit/view/'.$credit_id;
        $messages = "{$user->fullname} Credit Authorization Form No. {$credit_id}
          {$credit_url}";  
        $this->onclick($messages, $credit_id, $this->config->item('page_to_send'));
      }
      redirect('credit/view/'.$credit_id);
    }

    public function unsign($signature_id) {
      $this->load->model('credit_model');
      $this->load->model('users_model');
      $signature_identity = $this->credit_model->get_signature_identity($signature_id);
      $this->credit_model->unsign($signature_id);
      $this->credit_model->update_state($signature_identity['credit_id'], 1);
      redirect('/credit/credit_stage/'.$signature_identity['credit_id']);  
    }

    public function sign($signature_id, $reject = FALSE) {
      $this->load->model('credit_model');
      $signature_identity = $this->credit_model->get_signature_identity($signature_id);
      $signrs = $this->get_signers($signature_identity['credit_id'], $signature_identity['hotel_id']);
      $this->data['credit'] = $this->credit_model->get_credit($signature_identity['credit_id']);
      $credit_url = base_url().'credit/view/'.$signature_identity['credit_id'];
      $message_id = $this->data['credit']['message_id'];
      $id = $signature_identity['credit_id'];
      $message = "Credit Authorization Form No. {$id}:
          {$credit_url}";
      if (array_key_exists($this->data['user_id'], $signrs[$signature_id]['queue'])) {
        if ($signature_identity['role_id'] == 1) {
          $this->onclick1($message);
          $this->deletonclick($message_id);
        }
        if ($reject) {
          $this->credit_model->reject($signature_id, $this->data['user_id']);
          redirect('/credit/credit_stage/'.$signature_identity['credit_id']);  
        } else {
          $this->credit_model->sign($signature_id, $this->data['user_id']);
          //die(print_r($signature_id));
          redirect('/credit/credit_stage/'.$signature_identity['credit_id']);  
        }
      }
      redirect('/credit/view/'.$signature_identity['credit_id']);
    }

    public function comment($credit_id){
      if ($this->input->post('submit')) {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('comment','Comment','trim|required');
        if ($this->form_validation->run() == TRUE) {
          $comment = $this->input->post('comment'); 
          $this->load->model('credit_model');
          $comment_data = array(
            'user_id' => $this->data['user_id'],
            'credit_id' => $credit_id,
            'comment' => $comment
          );
          $this->credit_model->insert_comment($comment_data);
          if ($this->data['role_id'] == 217) {
            $this->chairman_mail($credit_id);
          }
        }
        redirect('/credit/view/'.$credit_id);
      }
    }

    private function chairman_mail($credit_id) {
          $this->load->library('email');
          $this->load->helper('url');
          $credit_url = base_url().'credit/view/'.$credit_id;
          $this->email->from('e-signature@sunrise-resorts.com');
          $this->email->to('abeer@sunrise.eg');
          $this->email->subject("Credit Authorization Form No. #{$credit_id}");
          $this->email->message("Dear Madam Abber,
            <br/>
            <br/>
            Mr Hossam Commented on Credit Authorization Form No. #{$credit_id}, Please use the link below:
            <br/>
            <a href='{$credit_url}' target='_blank'>{$credit_url}</a>
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
      $this->load->model('credit_model');
      $this->credit_model->update_message_id($id, $channel_result);
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