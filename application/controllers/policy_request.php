<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  class policy_request extends CI_Controller {

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
      $this->data['menu']['active'] = "policies";
    }

    public function index() {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        $this->load->model('policy_request_model');
        if ($this->data['role_id'] == 1 || $this->data['role_id'] == 2 || $this->data['is_admin']) {
          $this->data['policy_requests'] = $this->policy_request_model->view();
        }else{
          $this->data['policy_requests'] = $this->policy_request_model->view_owned($this->data['user_id']);
        }
        $request = FALSE;
        if ($this->data['role_id'] == 1 || $this->data['role_id'] == 2 || $this->data['role_id'] == 3 || $this->data['role_id'] == 16 || $this->data['role_id'] == 17 || $this->data['role_id'] == 56) {
          $request = TRUE;
        }
        $this->data['is_request'] = ($request || $this->data['is_admin'])? TRUE : FALSE;
        $this->load->view('policy_request_index', $this->data);
      }
    }

    public function submit() {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        if ($this->input->post('submit')) {
          $this->load->library('form_validation');
          $this->load->library('email');
          $this->form_validation->set_rules('change','Change','trim|required');
          $this->form_validation->set_rules('reason','Reason','trim|required');
          $assumed_id = $this->input->post('assumed_id');                        
          if ($this->form_validation->run() == TRUE) {
            $this->load->model('policy_request_model');
            $data = array(
              'user_id' => $this->data['user_id'],
              'department_id' => $this->input->post('department_id'),
              'change' => $this->input->post('change'),
              'reason' => $this->input->post('reason')
            );
            $req_id = $this->policy_request_model->create_request($data);
            if ($req_id) {
              $this->policy_request_model->update_files($assumed_id,$req_id);
            } else {
              die("ERROR");
            }
            $this->notify($req_id);
            redirect('/policy_request/view/'.$req_id);
          }
        }
        try {
          $this->load->helper('form');
          $this->load->model('policy_request_model');
          $this->data['types'] = $this->policy_request_model->get_types();
          if ($this->input->post('submit')) {
            $this->data['assumed_id'] = mt_rand("1048575","10485751048575");
            $this->data['uploads'] = $this->policy_request_model->get_by_fille($this->data['assumed_id']);
          } else {
            $this->data['assumed_id'] = mt_rand("1048575","10485751048575");
            $this->data['uploads'] = array();
          }
          $this->load->view('policy_request_add_new',$this->data);
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
      }
    }

    public function notify($req_id) {
      $this->load->model('policy_request_model');
      $users = $this->policy_request_model->getby_role(2);
      foreach($users as $user){
        $name = $user['fullname'];
        $mail = $user['email'];
        $this->load->library('email');
        $this->load->helper('url');
        $req_url = base_url().'policy_request/view/'.$req_id;
        $this->email->from('e-signature@sunrise-resorts.com');
        $this->email->to($mail);
        $this->email->subject("Policy Change Request NO.#{$req_id}");
        $this->email->message("Dear {$name},
          <br/>
          <br/>
          Policy Change Request NO.#{$req_id} has been Created, Please use the link below:
          <br/>
          <a href='{$req_url}' target='_blank'>{$req_url}</a>
          <br/>
        "); 
        $mail_result = $this->email->send();
      }
    }

    public function view($req_id) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{      
        $this->load->model('policy_request_model');
        $this->load->model('hotels_model');   
        $this->data['request'] = $this->policy_request_model->get_request($req_id);
        $this->data['uploads'] = $this->policy_request_model->get_by_fille($req_id);
        $this->data['comments'] = $this->policy_request_model->get_comment($req_id);
        $editor = FALSE;
        if (isset($this->data['user_id'])) {
          if ( $this->data['request']['user_id'] == $this->data['user_id'] ) {
            $editor = TRUE;
          }
        }
        $this->data['is_editor'] = ($editor || $this->data['is_admin'])? TRUE : FALSE;
        $this->load->view('policy_request_view', $this->data);
      }
    }

    public function upload($req_id) {
      $file_name = $this->do_upload("upload");
      if (!$file_name) {
        die(json_encode($this->data['error']));
      } else {
        $this->load->model("policy_request_model");
        $this->policy_request_model->add_fille($req_id, $file_name, $this->data['user_id']);
        die("{}");
      }
    }

    public function remove($req_id, $id) {
      $file_name = $_POST['key'];
      if (!$id) {
        die(json_encode($this->data['error']));
      } else {
        $this->load->model("policy_request_model");
        $this->policy_request_model->remove_fille($id);
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

    public function edit($req_id) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        if ($this->input->post('submit')) {
          $this->load->library('form_validation');
          $this->load->library('email');
          $this->form_validation->set_rules('change','Change','trim|required');
          $this->form_validation->set_rules('reason','Reason','trim|required');
          if ($this->form_validation->run() == TRUE) {
            $this->load->model('policy_request_model');
            $data = array(
              'user_id' => $this->data['user_id'],
              'department_id' => $this->input->post('department_id'),
              'change' => $this->input->post('change'),
              'reason' => $this->input->post('reason')
            );
            $this->policy_request_model->update_request($req_id, $data);
            redirect('/policy_request/view/'.$req_id);
          }   
        }
        try {
          $this->load->helper('form');
          $this->load->model('policy_request_model');
          $this->data['types'] = $this->policy_request_model->get_types();
          $this->data['request'] = $this->policy_request_model->get_request($req_id);
          $this->data['uploads'] = $this->policy_request_model->get_by_fille($req_id);
          $this->load->view('policy_request_edit',$this->data);
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
      }
    }

    public function comment($req_id){
      if ($this->input->post('submit')) {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('comment','Comment','trim|required');
        if ($this->form_validation->run() == TRUE) {
          $comment = $this->input->post('comment'); 
          $this->load->model('policy_request_model');
          $comment_data = array(
            'user_id' => $this->data['user_id'],
            'req_id' => $req_id,
            'comment' => $comment
          );
          $this->policy_request_model->insert_comment($comment_data);
        }
        redirect('/policy_request/view/'.$req_id);
      }
    }
  
  }

?>