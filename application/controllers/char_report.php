<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class char_report extends CI_Controller {
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
    $this->data['menu']['active'] = "char_report";
  }

  public function submit() {
    if ((isset($this->data['user_id'])) && (($this->data['user_id'] == 1) || ($this->data['user_id'] == 217) || ($this->data['user_id'] == 2) || ($this->data['user_id'] ==55) || ($this->data['user_id'] == 250))) {
      if ($this->input->post('submit')) {
        $this->load->library('form_validation');
        $this->load->library('email');
        $assumed_id = $this->input->post('assumed_id');                        
        if ($this->form_validation->run() == FALSE) {
          $this->load->model('char_model');
          $this->load->model('users_model');  
          $form_data = array(
            'user_id' => $this->data['user_id'],
            'date' => $this->input->post('date'),
            'file' => $this->input->post('file'),
          );
          $char_id = $this->char_model->create_char($form_data);
          if ($char_id) {
            $this->load->model('char_model');
            $this->char_model->update_files($assumed_id,$char_id);
          } else {
            die("ERROR");//@TODO failure view
          }
          $this->notify($char_id);
          redirect('/char_report/view/'.$char_id);
        }   
      } 
      try {
        $this->load->helper('form');
        $this->load->model('char_model');
        if ($this->input->post('submit')) {
          $this->load->model('char_model');
          $this->data['assumed_id'] = $this->input->post('assumed_id');
          $this->data['uploads'] = $this->char_model->getby_fille($this->data['assumed_id']);
        } else {
          $this->data['assumed_id'] = strtoupper(str_pad(dechex( mt_rand( 0, 1048575 ) ), 5, '0', STR_PAD_LEFT));
          $this->data['uploads'] = array();
        }
        $this->load->view('char_add_new',$this->data);
      }
      catch( Exception $e) {
        show_error($e->getMessage()." _ ". $e->getTraceAsString());
      }
    }else{
      redirect('/unknown');
    }
  }

  public function make_offer($char_id) {
    $file_name = $this->do_upload("upload");
    if (!$file_name) {
      die(json_encode($this->data['error']));
    } else {
      $this->load->model("char_model");
      $this->char_model->add($char_id, $file_name);
      die("{}");
    }
  }

  public function remove_offer($char_id, $id) {
    $file_name = $_POST['key'];
    if (!$id) {
      die(json_encode($this->data['error']));
    } else {
      $this->load->model("char_model");
      $this->char_model->remove($id);
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
    }
    else{
      $file = $this->upload->data();
      return $file['file_name'];
    }
  }

  public function view($char_id) {
    if ((isset($this->data['user_id'])) && (($this->data['user_id'] == 1) || ($this->data['user_id'] == 217) || ($this->data['user_id'] == 2) || ($this->data['user_id'] ==55) || ($this->data['user_id'] == 250))) {
      $this->load->model('char_model');
      $this->data['char'] = $this->char_model->get_char($char_id);
      $this->data['uploads'] = $this->char_model->getby_fille($char_id);
      $this->data['get_comment'] = $this->char_model->get_comment($char_id);
      $editor = FALSE;
      if (isset($this->data['user_id'])) {
        if ( $this->data['char']['user_id'] == $this->data['user_id']) {
          $editor = TRUE;
        }
      }
      $this->data['is_editor'] = ($editor)? TRUE : FALSE;
      $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
      $this->data['file_path'] = '/assets/uploads/files/';
      $this->data['id'] = $char_id;
      $this->load->view('char_view', $this->data);
    }else{
      redirect('/unknown');
    }
  }

  public function edit($char_id) {
    if ((isset($this->data['user_id'])) && (($this->data['user_id'] == 1) || ($this->data['user_id'] == 217) || ($this->data['user_id'] == 2) || ($this->data['user_id'] ==55) || ($this->data['user_id'] == 250))) {
      if ($this->input->post('submit')) {
        $this->load->library('form_validation');
        $this->load->library('email');
        if ($this->form_validation->run() == FALSE) {
          $this->load->model('char_model');
          $this->load->model('users_model');  
          $form_data = array(
            'user_id' => $this->data['user_id'],
            'date' => $this->input->post('date'),
            'file' => $this->input->post('file'),
          );
          $this->char_model->update_char($form_data, $char_id);
          redirect('/char_report/view/'.$char_id);
        }   
      } 
      try {
        $this->load->helper('form');
        $this->load->model('char_model');
        $this->load->model('hotels_model');
        $this->data['char'] = $this->char_model->get_char($char_id);
        $this->data['uploads'] = $this->char_model->getby_fille($this->data['char']['id']);
        $this->load->view('char_edit',$this->data);
      }
      catch( Exception $e) {
        show_error($e->getMessage()." _ ". $e->getTraceAsString());
      }
    }else{
      redirect('/unknown');
    }
  }

  public function comment($char_id){
    if ($this->input->post('submit')) {
      $this->load->library('form_validation');
      $this->form_validation->set_rules('comment','Comment','trim|required');
      if ($this->form_validation->run() == TRUE) {
        $comment = $this->input->post('comment'); 
        $this->load->model('char_model');
        $comment_data = array(
          'user_id' => $this->data['user_id'],
          'char_id' => $char_id,
          'comment' => $comment
        );
        $this->char_model->insert_comment($comment_data);
        if ($this->data['role_id'] == 217) {
            $this->chairman_mail($char_id);
          }
      }
      redirect('/char_report/view/'.$char_id);
    }
  }

  private function chairman_mail($char_id) {
          $this->load->library('email');
          $this->load->helper('url');
          $char_url = base_url().'char_report/view/'.$char_id;
          $this->email->from('e-signature@sunrise-resorts.com');
          $this->email->to('abeer@sunrise.eg');
          $this->email->subject("Chairman Monthly Report No. #{$char_id}");
          $this->email->message("Dear Madam Abber,
            <br/>
            <br/>
            Mr Hossam Commented on Chairman Monthly Report No. #{$char_id}, Please use the link below:
            <br/>
            <a href='{$char_url}' target='_blank'>{$char_url}</a>
            <br/>
          "); 
          die(print_r($char_id));
          $mail_result = $this->email->send();
      }

  public function index() {
    if ((isset($this->data['user_id'])) && (($this->data['user_id'] == 1) || ($this->data['user_id'] == 217) || ($this->data['user_id'] == 2) || ($this->data['user_id'] ==55) || ($this->data['user_id'] == 250))) {
      $this->load->model('users_model');
      $this->load->model('char_model');  
      $this->data['char'] = $this->char_model->view();
      $count =  array();
        foreach ($this->data['char'] as $re) {
          $count[] = $re['date'] ;
        }
        $this->data['count'] = array_count_values($count);
      $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
      $this->load->view('char_index', $this->data);
    }else{
      redirect('/unknown');
    }
  }

  public function index_month($date) {
    if ((isset($this->data['user_id'])) && (($this->data['user_id'] == 1) || ($this->data['user_id'] == 217) || ($this->data['user_id'] == 2) || ($this->data['user_id'] ==55) || ($this->data['user_id'] == 250))) {
      $this->load->model('users_model');
      $this->load->model('char_model');  
      $this->data['date'] = $date;
      $this->data['char'] = $this->char_model->get_char_month($date);
      $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
      $this->load->view('char_index_month', $this->data);
    }else{
      redirect('/unknown');
    }
  }

  public function notify($char_id) {
    $this->load->model('char_model');
    $this->load->model('users_model');
    $char = $this->char_model->get_char($char_id);
    $month =  $char['date'];
    $notify = $this->char_model->getby_verbal();
      //die(print_r($notify));
    $users =  array();
    foreach ($notify as $notified){
      //die(print_r($notified['user_id']));
      $users  = $this->users_model->get_user_by_id($notified['user_id'], TRUE);
      //die(print_r($users));
      //die(print_r($users ->fullname));
        $name = $users ->fullname;
        $mail = $users->email;
        $this->load->library('email');
        $this->load->helper('url');
        $char_url = base_url().'char_report/view/'.$char_id; 
        $this->email->from('e-signature@sunrise-resorts.com');
        $this->email->to($mail);
        $this->email->subject("Chairman Monthly Report for {$month}");
        $this->email->message("Dear {$name},<br/>
          <br/>
          Chairman Monthly Report for {$month} has been Uploaded, Please use the link below:<br/>
          <a href='{$char_url}' target='_blank'>{$char_url}</a><br/>
        "); 
          $mail_result = $this->email->send();
    }
    redirect('char_report/view/'.$char_id);
  }

  public function mailme($char_id) {
    $this->load->model('char_model');
    $this->load->model('users_model');
    $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
    $char = $this->char_model->get_char($char_id);
    //die(print_r($file));
    $month =  $char['date'];
    $this->load->library('email');
    $this->load->helper('url');
        $char_url = base_url().'char_report/view/'.$char_id; 
    $this->email->from('e-signature@sunrise-resorts.com');
    $this->email->to($user->email);
    $this->email->subject("Chairman Monthly Report for {$month}");
    $this->email->message("Chairman Monthly Report for {$month}:<br/>
      Please use the link below to view the Chairman Monthly Report:
      <a href='{$char_url}' target='_blank'>{$char_url}</a><br/>
    "); 
    $mail_result = $this->email->send();
    redirect('char_report/view/'.$char_id);
  }

  public function mailmeall($date) {
    $this->load->model('char_model');
    $this->load->model('users_model');
    $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
    $this->load->library('email');
    $this->load->helper('url');
    $char_url = base_url().'char_report/index_month/'.$date; 
    $this->email->from('e-signature@sunrise-resorts.com');
    $this->email->to($user->email);
    $this->email->subject("Chairman Monthly Report for {$date}");
    $this->email->message("Chairman Monthly Report Month for {$date}:<br/>
      Please use the link below to view the Chairman Monthly Report:
      <a href='{$char_url}' target='_blank'>{$char_url}</a><br/>
    "); 
    $mail_result = $this->email->send();
    redirect('char_report/index_month/'.$date);
  }

}