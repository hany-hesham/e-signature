<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  class transfer extends CI_Controller {

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
      $this->data['menu']['active'] = "madars";
    }

    public function index() {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        $this->load->model('transfer_model');
        $this->data['transfer'] = $this->transfer_model->view();
        foreach ($this->data['transfer'] as $key => $out) {
          $this->data['transfer'][$key]['approvals'] = $this->transfer_model->get_by_verbals($this->data['transfer'][$key]['id']);
        } 
        $this->load->view('transfer_index', $this->data);
      }
    }

    public function index_app() {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        $this->load->model('transfer_model');
        $this->data['transfer'] = $this->transfer_model->view(2);
        foreach ($this->data['transfer'] as $key => $out) {
          $this->data['transfer'][$key]['approvals'] = $this->transfer_model->get_by_verbals($this->data['transfer'][$key]['id']);
        } 
        $this->load->view('transfer_index', $this->data);
      }
    }

    public function index_wat() {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        if ($this->input->post('submit')) {
          $state = $this->input->post('state');
          $this->load->model('transfer_model');
          $this->data['transfer'] = $this->transfer_model->view($state);
          foreach ($this->data['transfer'] as $key => $out) {
            $this->data['transfer'][$key]['approvals'] = $this->transfer_model->get_by_verbals($this->data['transfer'][$key]['id']);
          } 
          $this->data['state'] = $state;
        }
        $this->load->view('transfer_index_wat', $this->data);
      }
    }

    public function index_rej() {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        $this->load->model('transfer_model');
        $this->data['transfer'] = $this->transfer_model->view(3);
        foreach ($this->data['transfer'] as $key => $out) {
          $this->data['transfer'][$key]['approvals'] = $this->transfer_model->get_by_verbals($this->data['transfer'][$key]['id']);
        } 
        $this->load->view('transfer_index', $this->data);
      }
    }

    public function submit() {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        if ($this->input->post('submit')) {
          $this->load->library('form_validation');
          $this->load->library('email');
          $this->form_validation->set_rules('from_acc','الحساب المحول','trim|required');
          $this->form_validation->set_rules('to_acc','الحساب المحول إليه','trim|required');
          $this->form_validation->set_rules('date','التاريخ','trim|required');
          $assumed_id = $this->input->post('assumed_id');                        
          if ($this->form_validation->run() == TRUE) {
            $this->load->model('transfer_model');
            $data = array(
              'user_id' => $this->data['user_id'],
              'date' => $this->input->post('date'),
              'from_acc' => $this->input->post('from_acc'),
              'to_acc' => $this->input->post('to_acc')
            );
            $tran_id = $this->transfer_model->create_transfer($data);
            if ($tran_id) {
              $this->transfer_model->update_files($assumed_id,$tran_id);
            } else {
              die("ERROR");
            }
            foreach ($this->input->post('items') as $item) {
              $item['user_id'] = $this->data['user_id'];   
              $item['tran_id'] = $tran_id;   
              $item_id = $this->transfer_model->create_item($item);
              if (!$item_id) {
                die("ERROR");
              }
            }
            $signatures = $this->transfer_model->tran_sign();
            $do_sign = $this->transfer_model->tran_do_sign($tran_id);
            if ($do_sign == 0) {
              foreach ($signatures as $tran_signature) {
                $this->transfer_model->add_signature($tran_id, $tran_signature['role'], $tran_signature['department'], $tran_signature['rank']);
              }
            }
            redirect('/transfer/tran_stage/'.$tran_id);
          }
        }
        try {
          $this->load->helper('form');
          $this->load->model('transfer_model');
          $this->data['departments'] = $this->transfer_model->get_departments();
          if ($this->input->post('submit')) {
            $this->data['assumed_id'] = mt_rand("1048575","10485751048575");
            $this->data['uploads'] = $this->transfer_model->get_by_fille($this->data['assumed_id']);
          } else {
            $this->data['assumed_id'] = mt_rand("1048575","10485751048575");
            $this->data['uploads'] = array();
          }
          $this->load->view('transfer_add_new',$this->data);
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
      }
    }

    public function tran_stage($tran_id) {
      $this->load->model('transfer_model');
      $this->load->model('users_model'); 
      $this->data['transfer'] = $this->transfer_model->get_transfer($tran_id);
      if ($this->data['transfer']['state_id'] == 0) {
        $this->transfer_model->update_state($tran_id, 1);
        redirect('/transfer/tran_stage/'.$tran_id);
      }elseif ($this->data['transfer']['state_id'] == 3){
        $user = $this->users_model->get_user_by_id($this->data['transfer']['user_id'], TRUE);
        $queue = $this->reject_mail($user->fullname, $user->email, $tran_id);
      }elseif ($this->data['transfer']['state_id'] != 2){
        $queue = $this->notify_signers($tran_id);
        if (!$queue) {
          $this->transfer_model->update_state($tran_id, 2);
          $user = $this->users_model->get_user_by_id($this->data['transfer']['user_id'], TRUE);
          $queue = $this->approvel_mail($user->fullname, $user->email, $tran_id);
          redirect('/transfer/tran_stage/'.$tran_id);
        }
      }
      redirect('/transfer/view/'.$tran_id);
    }

    private function reject_mail($name, $email, $tran_id) {
      $this->load->library('email');
      $this->load->helper('url');
      $tran_url = base_url().'transfer/view/'.$tran_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($email);
      $this->email->subject("Payment Plan Form No. #{$tran_id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
        Payment Plan Form No. #{$tran_id} has been rejected, Please use the link below:
        <br/>
        <a href='{$tran_url}' target='_blank'>{$tran_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
    }

    private function notify_signers($tran_id) {
      $notified = FALSE;
      $signers = $this->get_signers($tran_id);
      foreach ($signers as $signer) {
        if (isset($signer['queue'])) {
          $notified = TRUE;
          foreach ($signer['queue'] as $uid => $user) {
            $this->signatures_mail($signer['role'], $signer['department'], $user['name'], $user['mail'], $tran_id);
          }
          break;
        }
      }
      return $notified;
    }

    private function get_signers($tran_id) {
      $this->load->model('transfer_model');
      $signatures = $this->transfer_model->get_by_verbal($tran_id);
      return $this->roll_signers($signatures, $tran_id);
    }

    private function roll_signers($signatures, $tran_id) {
      $signers = array();
      $this->load->model('users_model');
      $this->load->model('transfer_model');
      $transfer = $this->transfer_model->get_transfer($tran_id);
      foreach ($signatures as $signature) {
        $signers[$signature['id']] = array();
        $signers[$signature['id']]['role'] = $signature['role'];
        $signers[$signature['id']]['role_id'] = $signature['role_id'];
        $signers[$signature['id']]['department'] = $signature['department'];
        $signers[$signature['id']]['department_id'] = $signature['department_id'];
        if ($signature['user_id']) {
          if ($signature['rank'] == 1){
            $this->transfer_model->update_state($tran_id, 4);
          }elseif ($signature['rank'] == 2){
            $this->transfer_model->update_state($tran_id, 5);
          }elseif ($signature['rank'] == 3){
            $this->transfer_model->update_state($tran_id, 2);
          }
          $signers[$signature['id']]['sign'] = array();
          $signers[$signature['id']]['sign']['id'] = $signature['user_id'];
          if ($signature['reject'] == 1) {
            $signers[$signature['id']]['sign']['reject'] = "reject";
            $this->transfer_model->update_state($tran_id, 3);
          } 
          $user = $this->users_model->get_user_by_id($signature['user_id'], TRUE);
          $signers[$signature['id']]['sign']['name'] = $user->fullname;
          $signers[$signature['id']]['sign']['mail'] = $user->email;
          $signers[$signature['id']]['sign']['sign'] = $user->signature;
          $signers[$signature['id']]['sign']['timestamp'] = $signature['timestamp'];
        } else {
          $signers[$signature['id']]['queue'] = array();
          if ($signature['role_id'] == 1) {
            $users[0] = $this->transfer_model->getby_role(1);
            $users[1] = $this->transfer_model->getby_role(2);
            $users[2] = $this->transfer_model->getby_role(83);
            foreach ($users as $user) {
              foreach ($user as $use) {
                $signers[$signature['id']]['queue'][$use['id']] = array();
                $signers[$signature['id']]['queue'][$use['id']]['name'] = $use['fullname'];
                $signers[$signature['id']]['queue'][$use['id']]['mail'] = $use['email'];
              }
            }
          } else {
            $users = $this->transfer_model->getby_role($signature['role_id'], $signature['department_id']);
            foreach ($users as $use) {
              $signers[$signature['id']]['queue'][$use['id']] = array();
              $signers[$signature['id']]['queue'][$use['id']]['name'] = $use['fullname'];
              $signers[$signature['id']]['queue'][$use['id']]['mail'] = $use['email'];
            }
          }
        }
      }
      return $signers;
    }

    private function signatures_mail($role, $department, $name, $mail, $tran_id) {
      $this->load->library('email');
      $this->load->helper('url');
      $tran_url = base_url().'transfer/view/'.$tran_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($mail);
      $this->email->subject("Payment Plan Form No. #{$tran_id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
        Payment Plan Form No. #{$tran_id} requires your signature, Please use the link below:
        <br/>
        <a href='{$tran_url}' target='_blank'>{$tran_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
    }

    private function approvel_mail($name, $email, $tran_id) {
      $this->load->library('email');
      $this->load->helper('url');
      $tran_url = base_url().'transfer/view/'.$tran_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($email);
      $this->email->subject("Payment Plan Form No. #{$tran_id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
        Payment Plan Form No. #{$tran_id} has been approved, Please use the link below:
        <br/>
        <a href='{$tran_url}' target='_blank'>{$tran_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
    }

    public function view($tran_id) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{      
        $this->load->model('transfer_model');
        $this->data['transfer'] = $this->transfer_model->get_transfer($tran_id);
        $this->data['items'] = $this->transfer_model->get_items($tran_id);
        $this->data['departments'] = $this->transfer_model->get_departments();
        $this->data['uploads'] = $this->transfer_model->get_by_fille($tran_id);
        $this->data['comments'] = $this->transfer_model->get_comment($tran_id);
        $this->data['signature_path'] = '/assets/uploads/signatures/';
        $this->data['signers'] = $this->get_signers($tran_id);
        $this->data['item_department'] = $this->transfer_model->get_item_department($tran_id);
        //$count =  array();
        //foreach ($this->data['items'] as $item) {
        //  $count[] = $item['department_id'];
        //}
        //$this->data['count'] = array_count_values($count);
        $this->data['form_value'] =  array();
        $i = 0;
        foreach ($this->data['item_department'] as $item_department) {
          $this->data['form_value'][$i] = $this->transfer_model->getall_department_value($item_department['department_id']);
          $i++;
        }
        //die(print_r($this->data['item_department']));
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
          if ( $this->data['transfer']['user_id'] == $this->data['user_id'] &&  $this->data['transfer']['state_id'] != 2) {
            $editor = TRUE;
          }
        }
        $this->data['unsign_enable'] = ($unsign_enable || $this->data['is_admin'])? TRUE : FALSE;
        $this->data['is_editor'] = ($editor || $this->data['is_admin'])? TRUE : FALSE;
        $this->load->view('transfer_view', $this->data);
      }
    }

    public function upload($tran_id) {
      $file_name = $this->do_upload("upload");
      if (!$file_name) {
        die(json_encode($this->data['error']));
      } else {
        $this->load->model("transfer_model");
        $this->transfer_model->add_fille($tran_id, $file_name, $this->data['user_id']);
        die("{}");
      }
    }

    public function remove($tran_id, $id) {
      $file_name = $_POST['key'];
      if (!$id) {
        die(json_encode($this->data['error']));
      } else {
        $this->load->model("transfer_model");
        $this->transfer_model->remove_fille($id);
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

    public function edit($tran_id) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        if ($this->input->post('submit')) {
          $this->load->library('form_validation');
          $this->load->library('email');
          $this->form_validation->set_rules('from_acc','الحساب المحول','trim|required');
          $this->form_validation->set_rules('to_acc','الحساب المحول إليه','trim|required');
          $this->form_validation->set_rules('date','التاريخ','trim|required');
          if ($this->form_validation->run() == TRUE) {
            $this->load->model('transfer_model');
            $data = array(
              'date' => $this->input->post('date'),
              'from_acc' => $this->input->post('from_acc'),
              'to_acc' => $this->input->post('to_acc')
            );
            $this->transfer_model->update_transfer($tran_id, $data);
            foreach ($this->input->post('items') as $item) {
              $item['user_id'] = $this->data['user_id'];   
              $item['tran_id'] = $tran_id;   
              $this->transfer_model->update_item($item['id'], $tran_id, $item);
            }
            redirect('/transfer/view/'.$tran_id);
          }   
        }
        try {
          $this->load->helper('form');
          $this->load->model('transfer_model');
          $this->data['transfer'] = $this->transfer_model->get_transfer($tran_id);
          $this->data['items'] = $this->transfer_model->get_items($tran_id);
          $this->data['departments'] = $this->transfer_model->get_departments();
          $this->data['uploads'] = $this->transfer_model->get_by_fille($tran_id);
          $this->load->view('transfer_edit',$this->data);
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
      }
    }

    public function submit_edit($tran_id) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        $this->load->model('transfer_model');
        $this->data['transfer'] = $this->transfer_model->get_transfer($tran_id);
        $this->data['items'] = $this->transfer_model->get_items($tran_id);
        if ($this->input->post('submit')) {
          $this->load->library('form_validation');
          $this->load->library('email');
          if ($this->form_validation->run() == FALSE) {
            $this->load->model('users_model');  
            //die(print_r($this->data['sp']['type']));
            foreach ($this->input->post('items') as $item) {
              $item['user_id'] = $this->data['user_id'];   
              $item['tran_id'] = $tran_id;   
              $item_id = $this->transfer_model->create_item($item);
              if (!$item_id) {
                die("ERROR");
              }
            }
              redirect('/transfer/view/'.$tran_id);
          }
        }
        try {
          $this->load->helper('form');
          $this->load->model('transfer_model');
          $this->data['departments'] = $this->transfer_model->get_departments();
          $this->data['uploads'] = $this->transfer_model->get_by_fille($tran_id);
          $this->load->view('transfer_add_edit',$this->data);
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
      }
    }

    public function mail_me($tran_id) {
      $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
      $this->load->library('email');
      $this->load->helper('url');
      $tran_url = base_url().'transfer/view/'.$tran_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($user->email);
      $this->email->subject("Payment Plan Form No. #{$tran_id}");
      $this->email->message("Payment Plan Form NO.#{$tran_id}:
        <br/>
        Please use the link below to view The Payment Plan Form:
        <a href='{$tran_url}' target='_blank'>{$tran_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
      redirect('transfer/view/'.$tran_id);
    }

    public function mail($tran_id) {
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
          $tran_url = base_url().'transfer/view/'.$tran_id;
          $this->email->from('e-signature@sunrise-resorts.com');
          $this->email->to($email);
          $this->email->subject("A message from {$user->fullname}, Payment Plan Form No. #{$tran_id}");
          $this->email->message("{$user->fullname} sent you a private message regarding Payment Plan Form No. #{$tran_id}:
            <br/>
            {$message}
            <br />
            <br />
            Please use the link below to view the Payment Plan Form:
            <a href='{$tran_url}' target='_blank'>{$tran_url}</a>
            <br/>
          "); 
          $mail_result = $this->email->send();
        }
      }
      redirect('transfer/view/'.$tran_id);
    }

    public function unsign($signature_id) {
      $this->load->model('transfer_model');
      $this->load->model('users_model');
      $signature_identity = $this->transfer_model->get_signature_identity($signature_id);
      $this->transfer_model->unsign($signature_id);
      redirect('/transfer/tran_stage/'.$signature_identity['tran_id']);  
    }

    public function sign($signature_id, $reject = FALSE) {
      $this->load->model('transfer_model');
      $signature_identity = $this->transfer_model->get_signature_identity($signature_id);
      $signrs = $this->get_signers($signature_identity['tran_id']);
      if (array_key_exists($this->data['user_id'], $signrs[$signature_id]['queue'])) {
        if ($reject) {
          $this->transfer_model->reject($signature_id, $this->data['user_id']);
          redirect('/transfer/tran_stage/'.$signature_identity['tran_id']);  
        } else {
          $this->transfer_model->sign($signature_id, $this->data['user_id']);
          //die(print_r($signature_id));
          redirect('/transfer/tran_stage/'.$signature_identity['tran_id']);  
        }
      }
      redirect('/transfer/view/'.$signature_identity['tran_id']);
    }

    public function comment($tran_id){
      if ($this->input->post('submit')) {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('comment','Comment','trim|required');
        if ($this->form_validation->run() == TRUE) {
          $comment = $this->input->post('comment'); 
          $this->load->model('transfer_model');
          $comment_data = array(
            'user_id' => $this->data['user_id'],
            'tran_id' => $tran_id,
            'comment' => $comment
          );
          $this->transfer_model->insert_comment($comment_data);
          if ($this->data['role_id'] == 217) {
            $this->chairman_mail($tran_id);
          }
        }
        redirect('/transfer/view/'.$tran_id);
      }
    }

    private function chairman_mail($tran_id) {
          $this->load->library('email');
          $this->load->helper('url');
          $tran_url = base_url().'transfer/view/'.$tran_id;
          $this->email->from('e-signature@sunrise-resorts.com');
          $this->email->to('abeer@sunrise.eg');
          $this->email->subject("Payment Plan Form No. #{$tran_id}");
          $this->email->message("Dear Madam Abber,
            <br/>
            <br/>
            Mr Hossam Commented on Payment Plan Form No. #{$tran_id}, Please use the link below:
            <br/>
            <a href='{$tran_url}' target='_blank'>{$tran_url}</a>
            <br/>
          "); 
          $mail_result = $this->email->send();
      }

  }

?>