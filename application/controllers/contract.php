<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  class contract extends CI_Controller {

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
      $this->data['menu']['active'] = "financial";
    }

    public function chairman() {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        $this->load->model('hotels_model');
        $this->load->model('contract_model');
        $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
        $hotels = array();
        foreach ($user_hotels as $hotel) {
          $hotels[] = $hotel['id'];
        }  
        $this->data['contracts'] = $this->contract_model->view_wat($hotels, 13);
        $this->data['hotels'] = $user_hotels;
        $this->load->view('contract_chairman', $this->data);
      }
    }

    public function index() {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        $this->load->model('hotels_model');
        $this->load->model('contract_model');
        $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
        $hotels = array();
        foreach ($user_hotels as $hotel) {
          $hotels[] = $hotel['id'];
        }  
        $this->data['contract'] = $this->contract_model->view($hotels);
        foreach ($this->data['contract'] as $key => $up) {
          $this->data['contract'][$key]['approvals'] = $this->contract_model->get_by_verbals($this->data['contract'][$key]['id']);
          $this->data['contract'][$key]['upload'] = $this->contract_model->get_by_fille($this->data['contract'][$key]['id']);
          $this->data['contract'][$key]['summary'] = $this->contract_model->find_summary($this->data['contract'][$key]['id']);
          $this->data['contract'][$key]['summary']['approvals'] = $this->contract_model->get_sum_by_verbals($this->data['contract'][$key]['summary']['id']);
          //die(print_r($this->data['contract'][$key]['summary']));
        } 
        $this->data['hotels'] = $user_hotels;
        $this->load->view('contract_index', $this->data);
      }
    }

    public function index_app() {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        $this->load->model('hotels_model');
        $this->load->model('contract_model');
        $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
        $hotels = array();
        foreach ($user_hotels as $hotel) {
          $hotels[] = $hotel['id'];
        }  
        $this->data['contract'] = $this->contract_model->view_app($hotels);
        foreach ($this->data['contract'] as $key => $up) {
          $this->data['contract'][$key]['approvals'] = $this->contract_model->get_by_verbals($this->data['contract'][$key]['id']);
          $this->data['contract'][$key]['upload'] = $this->contract_model->get_by_fille($this->data['contract'][$key]['id']);
          $this->data['contract'][$key]['summary'] = $this->contract_model->find_summary($this->data['contract'][$key]['id']);
          $this->data['contract'][$key]['summary']['approvals'] = $this->contract_model->get_sum_by_verbals($this->data['contract'][$key]['summary']['id']);
          //die(print_r($this->data['contract'][$key]['summary']));
        } 
        $this->data['hotels'] = $user_hotels;
        $this->load->view('contract_index', $this->data);
      }
    }

    public function index_rej() {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        $this->load->model('hotels_model');
        $this->load->model('contract_model');
        $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
        $hotels = array();
        foreach ($user_hotels as $hotel) {
          $hotels[] = $hotel['id'];
        }  
        $this->data['contract'] = $this->contract_model->view_rej($hotels);
        foreach ($this->data['contract'] as $key => $up) {
          $this->data['contract'][$key]['approvals'] = $this->contract_model->get_by_verbals($this->data['contract'][$key]['id']);
          $this->data['contract'][$key]['upload'] = $this->contract_model->get_by_fille($this->data['contract'][$key]['id']);
          $this->data['contract'][$key]['summary'] = $this->contract_model->find_summary($this->data['contract'][$key]['id']);
          $this->data['contract'][$key]['summary']['approvals'] = $this->contract_model->get_sum_by_verbals($this->data['contract'][$key]['summary']['id']);
          //die(print_r($this->data['contract'][$key]['summary']));
        } 
        $this->data['hotels'] = $user_hotels;
        $this->load->view('contract_index', $this->data);
      }
    }

    public function index_wat() {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        if ($this->input->post('submit')) {
          $state = $this->input->post('state');
          $this->load->model('hotels_model');
          $this->load->model('contract_model');
          $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
          $hotels = array();
          foreach ($user_hotels as $hotel) {
            $hotels[] = $hotel['id'];
          }  
          $this->data['contract'] = $this->contract_model->view_wat($hotels, $state);
          foreach ($this->data['contract'] as $key => $up) {
            $this->data['contract'][$key]['approvals'] = $this->contract_model->get_by_verbals($this->data['contract'][$key]['id']);
          $this->data['contract'][$key]['upload'] = $this->contract_model->get_by_fille($this->data['contract'][$key]['id']);
            $this->data['contract'][$key]['summary'] = $this->contract_model->find_summary($this->data['contract'][$key]['id']);
            $this->data['contract'][$key]['summary']['approvals'] = $this->contract_model->get_sum_by_verbals($this->data['contract'][$key]['summary']['id']);
            //die(print_r($this->data['contract'][$key]['summary']));
          } 
          $this->data['state'] = $state;
          $this->data['hotels'] = $user_hotels;
        }
        $this->load->view('contract_index_wat', $this->data);
      }
    }

    public function index_not_upload() {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        $this->load->model('hotels_model');
        $this->load->model('contract_model');
        $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
        $hotels = array();
        foreach ($user_hotels as $hotel) {
          $hotels[] = $hotel['id'];
        }  
        $upload = $this->contract_model->get_upload();
        $uploaded =  array();
        foreach ($upload as $up) {
          $uploaded[] = $up['contr_id'];
        }
        $uploadedes = array_count_values($uploaded); 
        $uplo = array();
        foreach ($uploadedes as $key => $value) {
          $uplo[] = $key;
        }
        $this->data['contract'] = $this->contract_model->view_not($hotels, $uplo);
        //die(print_r($this->data['contract']));
        foreach ($this->data['contract'] as $key => $up) {
          $this->data['contract'][$key]['approvals'] = $this->contract_model->get_by_verbals($this->data['contract'][$key]['id']);
          $this->data['contract'][$key]['upload'] = $this->contract_model->get_by_fille($this->data['contract'][$key]['id']);
          $this->data['contract'][$key]['summary'] = $this->contract_model->find_summary($this->data['contract'][$key]['id']);
          $this->data['contract'][$key]['summary']['approvals'] = $this->contract_model->get_sum_by_verbals($this->data['contract'][$key]['summary']['id']);
          //die(print_r($this->data['contract'][$key]['summary']));
        } 
        $this->data['hotels'] = $user_hotels;
        $this->load->view('contract_index', $this->data);
      }
    }

    public function index_upload() {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        $this->load->model('hotels_model');
        $this->load->model('contract_model');
        $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
        $hotels = array();
        foreach ($user_hotels as $hotel) {
          $hotels[] = $hotel['id'];
        }  
        $upload = $this->contract_model->get_upload();
        $uploaded =  array();
        foreach ($upload as $up) {
          $uploaded[] = $up['contr_id'];
        }
        $uploadedes = array_count_values($uploaded); 
        $uplo = array();
        foreach ($uploadedes as $key => $value) {
          $uplo[] = $key;
        }
        $this->data['contract'] = $this->contract_model->view_in($hotels, $uplo);
        //die(print_r($this->data['contract']));
        foreach ($this->data['contract'] as $key => $up) {
          $this->data['contract'][$key]['approvals'] = $this->contract_model->get_by_verbals($this->data['contract'][$key]['id']);
          $this->data['contract'][$key]['upload'] = $this->contract_model->get_by_fille($this->data['contract'][$key]['id']);
          $this->data['contract'][$key]['summary'] = $this->contract_model->find_summary($this->data['contract'][$key]['id']);
          $this->data['contract'][$key]['summary']['approvals'] = $this->contract_model->get_sum_by_verbals($this->data['contract'][$key]['summary']['id']);
          //die(print_r($this->data['contract'][$key]['summary']));
        } 
        $this->data['hotels'] = $user_hotels;
        $this->load->view('contract_index', $this->data);
      }
    }

    public function submit() {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        if ($this->input->post('submit')) {
          $this->load->library('form_validation');
          $this->load->library('email');
          $this->form_validation->set_rules('hotel_id','اسم الفندق','trim|required');
          $this->form_validation->set_rules('company_id','اسم الشركة','trim|required');
          $this->form_validation->set_rules('service_id','نوع الخدمة','trim|required');
          $assumed_id = $this->input->post('assumed_id');                        
          if ($this->form_validation->run() == TRUE) {
            $this->load->model('contract_model');
            $this->load->model('users_model');  
            $form_data = array(
              'user_id' => $this->data['user_id'],
              'service_id' => $this->input->post('service_id'),
              'brand' => $this->input->post('brand'),
              'city' => $this->input->post('city'),
              'hotel_id' => $this->input->post('hotel_id'),
              'company_id' => $this->input->post('company_id'),
              'name' => $this->input->post('name'),
              'name_old' => $this->input->post('name_old'),
              'name_en' => $this->input->post('name_en'),
              'name_en_old' => $this->input->post('name_en_old'),
              'address' => $this->input->post('address'),
              'address_old' => $this->input->post('address_old'),
              'taxes' => $this->input->post('taxes'),
              'taxes_old' => $this->input->post('taxes_old'),
              'idp' => $this->input->post('idp'),
              'idp_old' => $this->input->post('idp_old'),
              'licenss' => $this->input->post('licenss'),
              'licenss_old' => $this->input->post('licenss_old'),
              'start_date' => $this->input->post('start_date'),
              'start_date_old' => $this->input->post('start_date_old'),
              'from_date' => $this->input->post('from_date'),
              'from_date_old' => $this->input->post('from_date_old'),
              'to_date' => $this->input->post('to_date'),
              'to_date_old' => $this->input->post('to_date_old'),
              'taxes_per' => $this->input->post('taxes_per'),
              'taxes_per_old' => $this->input->post('taxes_per_old'),
              'rent' => $this->input->post('rent'),
              'rent_old' => $this->input->post('rent_old'),
              'currency' => $this->input->post('currency'),
              'currency_old' => $this->input->post('currency_old'),
              'rent_mp' => $this->input->post('rent_mp'),
              'rent_mp_old' => $this->input->post('rent_mp_old'),
              'currency_mp' => $this->input->post('currency_mp'),
              'currency_mp_old' => $this->input->post('currency_mp_old'),
              'rent_gb' => $this->input->post('rent_gb'),
              'rent_gb_old' => $this->input->post('rent_gb_old'),
              'currency_gb' => $this->input->post('currency_gb'),
              'currency_gb_old' => $this->input->post('currency_gb_old'),
              'safty' => $this->input->post('safty'),
              'safty_old' => $this->input->post('safty_old'),
              'currency1' => $this->input->post('currency1'),
              'currency1_old' => $this->input->post('currency1_old'),
              'safty_mp' => $this->input->post('safty_mp'),
              'safty_mp_old' => $this->input->post('safty_mp_old'),
              'currency1_mp' => $this->input->post('currency1_mp'),
              'currency1_mp_old' => $this->input->post('currency1_mp_old'),
              'safty_gb' => $this->input->post('safty_gb'),
              'safty_gb_old' => $this->input->post('safty_gb_old'),
              'currency1_gb' => $this->input->post('currency1_gb'),
              'currency1_gb_old' => $this->input->post('currency1_gb_old'),
              'compensation' => $this->input->post('compensation'),
              'compensation_old' => $this->input->post('compensation_old'),
              'currency2' => $this->input->post('currency2'),
              'currency2_old' => $this->input->post('currency2_old'),
              'compensation_mp' => $this->input->post('compensation_mp'),
              'compensation_mp_old' => $this->input->post('compensation_mp_old'),
              'currency2_mp' => $this->input->post('currency2_mp'),
              'currency2_mp_old' => $this->input->post('currency2_mp_old'),
              'compensation_gb' => $this->input->post('compensation_gb'),
              'compensation_gb_old' => $this->input->post('compensation_gb_old'),
              'currency2_gb' => $this->input->post('currency2_gb'),
              'currency2_gb_old' => $this->input->post('currency2_gb_old'),
              'increase' => $this->input->post('increase'),
              'elec_choice' => $this->input->post('elec_choice'),
              'electricity' => $this->input->post('electricity'),
              'currency3' => $this->input->post('currency3'),
              'location' => $this->input->post('location'),
              'activity' => $this->input->post('activity'),
              'others' => $this->input->post('others'),
              'others_old' => $this->input->post('others_old')
            );
            $contr_id = $this->contract_model->create_contract($form_data);
            if ($contr_id) {
              $this->load->model('contract_model');
              $this->load->model('contract_log_model');
              $this->contract_model->update_files($assumed_id,$contr_id);
              $this->contract_log_model->update_log($assumed_id,$contr_id);
              $ip = $this->input->ip_address();
              $form_data['weeks'] = $this->input->post('week');
              $form_data['user_ip'] = $ip;
              //die(print_r($form_data));
              $this->new_log($this->data['user_id'], "New", "Contract", $contr_id, json_encode($form_data, TRUE), "New Contract Has Been Created");
            } else {
              die("ERROR");
            }
            foreach ($this->input->post('week') as $week) {
              $this->contract_model->add_day($contr_id, $week);
            }
            $signatures = $this->contract_model->contr_sign();
            $do_sign = $this->contract_model->contr_do_sign($contr_id);
            //die(print_r($do_sign));
            if ($do_sign == 0) {
              foreach ($signatures as $contr_signature) {
                $this->contract_model->add_signature($contr_id, $contr_signature['role'], $contr_signature['department'], $contr_signature['rank']);
              }
            }
            redirect('/contract/contract_stage/'.$contr_id);
          }
        }
        try {
          $this->load->helper('form');
          $this->load->model('contract_model');
          $this->load->model('hotels_model');
          $this->data['services'] = $this->contract_model->get_services();
          $this->data['companies'] = $this->contract_model->get_companies();
          $this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());
          $this->data['weeks'] = $this->contract_model->get_weeks();
          if ($this->input->post('submit')) {
            $this->load->model('contract_model');
            $this->data['assumed_id'] = mt_rand("1048575","10485751048575");
            $this->data['uploads'] = $this->contract_model->get_by_fille($this->data['assumed_id']);
          } else {
            $this->data['assumed_id'] = mt_rand("1048575","10485751048575");
            $this->data['uploads'] = array();
          }
          $this->load->view('contract_add_new',$this->data);
     
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
      }
    }

    public function new_log($user_id, $type, $target, $target_id, $data, $action){
      $this->load->model('contract_log_model');
      $log_data = array(
        'user_id' => $user_id,
        'type' => $type,
        'target' => $target,
        'target_id' => $target_id,
        'data' => $data,
        'action' => $action
      );
      $this->contract_log_model->new_log($log_data);
    }

    public function notify($contr_id) {
      $this->load->model('contract_model');
      $this->load->model('users_model');
      $this->data['contract'] = $this->contract_model->get_contract($contr_id);
      $users = array();
      $users = $this->users_model->getby_criteria(59, $this->data['contract']['hotel_id']);
      foreach($users as $user){
        $name = $user['fullname'];
        $mail = $user['email'];
        $this->load->library('email');
        $this->load->helper('url');
        $contr_url = base_url().'contract/view/'.$contr_id;
        $this->email->from('e-signature@sunrise-resorts.com');
        $this->email->to($mail);
        $this->email->subject("Contract NO.#{$contr_id}");
        $this->email->message("Dear {$name},
          <br/>
          <br/>
          Contract NO.#{$contr_id} has been Created, Please use the link below:
          <br/>
          <a href='{$contr_url}' target='_blank'>{$contr_url}</a>
          <br/>
        "); 
        $mail_result = $this->email->send();
      }
    }

    public function upload($contr_id) {
      $file_name = $this->do_upload("upload");
      if (!$file_name) {
        die(json_encode($this->data['error']));
      } else {
        $this->load->model("contract_model");
        $this->contract_model->add_fille($contr_id, $file_name, $this->data['user_id']);
        $ip = $this->input->ip_address();
        $data = array(
          'file' => $file_name,
          'user_ip' => $ip
        );
        $this->new_log($this->data['user_id'], "File", "Contract", $contr_id, json_encode($data, TRUE), "New File Has Been Uploaded");
        die("{}");
      }
    }

    public function remove($contr_id, $id) {
      $file_name = $_POST['key'];
      if (!$id) {
        die(json_encode($this->data['error']));
      } else {
        $this->load->model("contract_model");
        $fille = $this->contract_model->get_fille($id);
        $ip = $this->input->ip_address();
        $data = array(
          'file' => $fille['name'],
          'user' => $fille['user_name'],
          'user_ip' => $ip
        );
        $this->new_log($this->data['user_id'], "File", "Contract", $contr_id, json_encode($data, TRUE), "File Has Been Deleted");
        $this->contract_model->remove_fille($id);
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

    public function contract_stage($contr_id) {
      $this->load->model('contract_model');
      $this->data['contract'] = $this->contract_model->get_contract($contr_id);
      if ($this->data['contract']['state_id'] == 0) {
        $this->contract_model->update_state($contr_id, 1);
        redirect('/contract/contract_stage/'.$contr_id);
      } elseif ($this->data['contract']['state_id'] != 0 && $this->data['contract']['state_id'] != 2 && $this->data['contract']['state_id'] != 3) {
        $queue = $this->notify_signers($contr_id, $this->data['contract']['hotel_id']);
        if (!$queue) {
          $this->contract_model->update_state($contr_id, 2);
          redirect('/contract/contract_stage/'.$contr_id);
        }
      }elseif ($this->data['contract']['state_id'] == 2){
        //$this->notify($contr_id);
        $user = $this->users_model->get_user_by_id($this->data['contract']['user_id'], TRUE);
        $queue = $this->approvel_mail($user->fullname, $user->email, $contr_id);
      }elseif ($this->data['contract']['state_id'] == 3){
        $user = $this->users_model->get_user_by_id($this->data['contract']['user_id'], TRUE);
        $queue = $this->reject_mail($user->fullname, $user->email, $contr_id);
      }
      redirect('/contract/view/'.$contr_id);
    }

    private function notify_signers($contr_id, $hotel_id) {
      $notified = FALSE;
      $signers = $this->get_signers($contr_id, $hotel_id);
      foreach ($signers as $signer) {
        if (isset($signer['queue'])) {
          $notified = TRUE;
          foreach ($signer['queue'] as $uid => $user) {
            $this->signatures_mail($signer['role'], $signer['department'], $user['name'], $user['mail'], $contr_id);
          }
          break;
        }
      }
      return $notified;
    }

    private function get_signers($contr_id, $hotel_id) {
      $this->load->model('contract_model');
      $signatures = $this->contract_model->get_by_verbal($contr_id);
      return $this->roll_signers($signatures, $hotel_id, $contr_id);
    }

    private function roll_signers($signatures, $hotel_id, $contr_id) {
      $signers = array();
      $this->load->model('users_model');
      $this->load->model('contract_model');
      $contract = $this->contract_model->get_contract($contr_id);
      foreach ($signatures as $signature) {
        $signers[$signature['id']] = array();
        $signers[$signature['id']]['role'] = $signature['role'];
        $signers[$signature['id']]['role_id'] = $signature['role_id'];
        $signers[$signature['id']]['department'] = $signature['department'];
        $signers[$signature['id']]['department_id'] = $signature['department_id'];
        if ($signature['user_id']) {
          if ($contract['state_id'] != 10 && $contract['state_id'] != 11 && $contract['state_id'] != 12 && $contract['state_id'] != 13){
	          if ($signature['rank'] == 1){
	            $this->contract_model->update_state($contr_id, 4);
	          }elseif ($signature['rank'] == 2){
	            $this->contract_model->update_state($contr_id, 5);
	          }elseif ($signature['rank'] == 3){
	            $this->contract_model->update_state($contr_id, 6);
	          }elseif ($signature['rank'] == 4){
	            $this->contract_model->update_state($contr_id, 7);
	          }elseif ($signature['rank'] == 5){
	            $this->contract_model->update_state($contr_id, 8);
	          }elseif ($signature['rank'] == 6){
	            $this->contract_model->update_state($contr_id, 9);
	          }elseif ($signature['rank'] == 7){
	            $this->contract_model->update_state($contr_id, 2);
	          }
	        }
          $signers[$signature['id']]['sign'] = array();
          $signers[$signature['id']]['sign']['id'] = $signature['user_id'];
          if ($signature['reject'] == 1) {
            $signers[$signature['id']]['sign']['reject'] = "reject";
            $this->contract_model->update_state($contr_id, 3);
          } 
          $user = $this->users_model->get_user_by_id($signature['user_id'], TRUE);
          $signers[$signature['id']]['sign']['name'] = $user->fullname;
          $signers[$signature['id']]['sign']['mail'] = $user->email;
          $signers[$signature['id']]['sign']['sign'] = $user->signature;
          $signers[$signature['id']]['sign']['timestamp'] = $signature['timestamp'];
        } else {
          $signers[$signature['id']]['queue'] = array();
          if ($signature['role_id'] == 57 && $signature['rank'] != 7) {
            $users = $this->users_model->getby_criteria($signature['role_id'], $hotel_id, $signature['department_id']);
            foreach ($users as $use) {
              if ($use['id']== 316 || $use['id']== 317) {
                $signers[$signature['id']]['queue'][$use['id']] = array();
                $signers[$signature['id']]['queue'][$use['id']]['name'] = $use['fullname'];
                $signers[$signature['id']]['queue'][$use['id']]['mail'] = $use['email'];
              }
            }
          }elseif ($signature['role_id'] == 57 && $signature['rank'] == 7) {
            $users = $this->users_model->getby_criteria($signature['role_id'], $hotel_id, $signature['department_id']);
            foreach ($users as $use) {
              if ($use['id']== 316 || $use['id']== 317 || $use['id'] == $contract['user_id']) {
                $signers[$signature['id']]['queue'][$use['id']] = array();
                $signers[$signature['id']]['queue'][$use['id']]['name'] = $use['fullname'];
                $signers[$signature['id']]['queue'][$use['id']]['mail'] = $use['email'];
              }
            }
          }
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
              }else{
            $users = $this->users_model->getby_criteria($signature['role_id'], $hotel_id, $signature['department_id']);
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

    private function signatures_mail($role, $department, $name, $mail, $contr_id) {
      $this->load->model('contract_model');
      $this->load->model('users_model');
      $contract = $this->contract_model->get_contract($contr_id);
      $user = $this->users_model->get_user_by_id($contract['user_id'], TRUE);
      $this->load->library('email');
      $this->load->helper('url');
      $contr_url = base_url().'contract/view/'.$contr_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($mail);
      $this->email->subject("Contract No. #{$contr_id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
        Contract No. #{$contr_id} requires your signature, Please use the link below:
        <br/>
        <a href='{$contr_url}' target='_blank'>{$contr_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
      $data = array(
        'role' => $role,
        'department' => $department,
        'name' => $name,
        'mail' => $mail
      );
      $this->new_log(0, "Email", "Contract", $contr_id, json_encode($data, TRUE), "Signature Email Has Been Sent");
    }

    private function approvel_mail($name, $email, $contr_id) {
      $this->load->model('contract_model');
      $contract = $this->contract_model->get_contract($contr_id);
      $this->load->library('email');
      $this->load->helper('url');
      $contr_url = base_url().'contract/view/'.$contr_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($email);
      $this->email->subject("Contract No. #{$contr_id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
        Contract No. #{$contr_id} has been approved, Please use the link below:
        <br/>
        <a href='{$contr_url}' target='_blank'>{$contr_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
      $data = array(
        'name' => $name,
        'mail' => $email
      );
      $this->new_log(0, "Email", "Contract", $contr_id, json_encode($data, TRUE), "Approvel Email Has Been Sent");
    }

    private function reject_mail($name, $email, $contr_id) {
      $this->load->model('contract_model');
      $contract = $this->contract_model->get_contract($contr_id);
      $this->load->library('email');
      $this->load->helper('url');
      $contr_url = base_url().'contract/view/'.$contr_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($email);
      $this->email->subject("Contract No. #{$contr_id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
        Contract No. #{$contr_id} has been rejected, Please use the link below:
        <br/>
        <a href='{$contr_url}' target='_blank'>{$contr_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
      $data = array(
        'name' => $name,
        'mail' => $email
      );
      $this->new_log(0, "Email", "Contract", $contr_id, json_encode($data, TRUE), "Rejection Email Has Been Sent");
    }

    public function view($contr_id) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{      
        $this->load->model('contract_model');
        $this->load->model('hotels_model');   
        $this->load->model('contract_log_model');   
        $this->data['contract'] = $this->contract_model->get_contract($contr_id);
        $this->data['uploads'] = $this->contract_model->get_by_fille($contr_id);
        $this->data['days'] = $this->contract_model->get_day($contr_id);
        $this->data['comments'] = $this->contract_model->get_comment($contr_id);
        foreach ($this->data['comments'] as $key => $com) {
          $this->data['comments'][$key]['filles'] = $this->contract_model->get_by_comment_fille($this->data['comments'][$key]['id']);
          //die(print_r($this->data['contract'][$key]['summary']));
        } 
        $this->data['summary'] = $this->contract_model->find_summary($contr_id);
        $this->data['log'] = $this->contract_log_model->get_log($contr_id);
        $this->data['assumed_id'] = mt_rand("1048575","10485751048575");
        $this->data['signature_path'] = '/assets/uploads/signatures/';
        $this->data['signers'] = $this->get_signers($this->data['contract']['id'], $this->data['contract']['hotel_id']);
        $editor = FALSE;
        $unsign_enable = FALSE;
        $first = TRUE;
        $force_edit = FALSE;
        $low = FALSE;
        $credit = FALSE;
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
          if ( $this->data['contract']['user_id'] == $this->data['user_id'] &&  $this->data['contract']['state_id'] != 2 &&  $this->data['contract']['state_id'] < 10) {
            $editor = TRUE;
          }
        }
        if (isset($this->data['role_id'])) {
          if ($this->data['role_id'] == 59) {
            $low = TRUE;
          }elseif ($this->data['role_id'] == 55) {
            $low = TRUE;
          }
        }
        if (isset($this->data['role_id'])) {
          if ($this->data['role_id'] == 57 &&  $this->data['contract']['state_id'] == 2) {
            $credit = TRUE;
          }
        }
        $this->data['unsign_enable'] = (($unsign_enable) || $this->data['is_admin'])? TRUE : FALSE;
        $this->data['is_editor'] = ($editor || $this->data['is_admin'])? TRUE : FALSE;
        $this->data['is_lowyer'] = ($low || $this->data['is_admin'])? TRUE : FALSE;
        $this->data['is_credit'] = ($credit || $this->data['is_admin'])? TRUE : FALSE;
        $this->data['id'] = $contr_id;
        $this->load->view('contract_view', $this->data);
      }
    }

    public function edit($contr_id) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{          
        if ($this->input->post('submit')) {
          $this->load->library('form_validation');
          $this->load->library('email');
          if ($this->form_validation->run() == FALSE) {
            $this->load->model('contract_model');
            $this->load->model('hotels_model');
            $this->load->model('users_model');  
            $form_data = array(
              'service_id' => $this->input->post('service_id'),
              'brand' => $this->input->post('brand'),
              'city' => $this->input->post('city'),
              'hotel_id' => $this->input->post('hotel_id'),
              'company_id' => $this->input->post('company_id'),
              'name' => $this->input->post('name'),
              'name_old' => $this->input->post('name_old'),
              'name_en' => $this->input->post('name_en'),
              'name_en_old' => $this->input->post('name_en_old'),
              'address' => $this->input->post('address'),
              'address_old' => $this->input->post('address_old'),
              'taxes' => $this->input->post('taxes'),
              'taxes_old' => $this->input->post('taxes_old'),
              'idp' => $this->input->post('idp'),
              'idp_old' => $this->input->post('idp_old'),
              'licenss' => $this->input->post('licenss'),
              'licenss_old' => $this->input->post('licenss_old'),
              'start_date' => $this->input->post('start_date'),
              'start_date_old' => $this->input->post('start_date_old'),
              'from_date' => $this->input->post('from_date'),
              'from_date_old' => $this->input->post('from_date_old'),
              'to_date' => $this->input->post('to_date'),
              'to_date_old' => $this->input->post('to_date_old'),
              'taxes_per' => $this->input->post('taxes_per'),
              'taxes_per_old' => $this->input->post('taxes_per_old'),
              'rent' => $this->input->post('rent'),
              'rent_old' => $this->input->post('rent_old'),
              'currency' => $this->input->post('currency'),
              'currency_old' => $this->input->post('currency_old'),
              'rent_mp' => $this->input->post('rent_mp'),
              'rent_mp_old' => $this->input->post('rent_mp_old'),
              'currency_mp' => $this->input->post('currency_mp'),
              'currency_mp_old' => $this->input->post('currency_mp_old'),
              'rent_gb' => $this->input->post('rent_gb'),
              'rent_gb_old' => $this->input->post('rent_gb_old'),
              'currency_gb' => $this->input->post('currency_gb'),
              'currency_gb_old' => $this->input->post('currency_gb_old'),
              'safty' => $this->input->post('safty'),
              'safty_old' => $this->input->post('safty_old'),
              'currency1' => $this->input->post('currency1'),
              'currency1_old' => $this->input->post('currency1_old'),
              'safty_mp' => $this->input->post('safty_mp'),
              'safty_mp_old' => $this->input->post('safty_mp_old'),
              'currency1_mp' => $this->input->post('currency1_mp'),
              'currency1_mp_old' => $this->input->post('currency1_mp_old'),
              'safty_gb' => $this->input->post('safty_gb'),
              'safty_gb_old' => $this->input->post('safty_gb_old'),
              'currency1_gb' => $this->input->post('currency1_gb'),
              'currency1_gb_old' => $this->input->post('currency1_gb_old'),
              'compensation' => $this->input->post('compensation'),
              'compensation_old' => $this->input->post('compensation_old'),
              'currency2' => $this->input->post('currency2'),
              'currency2_old' => $this->input->post('currency2_old'),
              'compensation_mp' => $this->input->post('compensation_mp'),
              'compensation_mp_old' => $this->input->post('compensation_mp_old'),
              'currency2_mp' => $this->input->post('currency2_mp'),
              'currency2_mp_old' => $this->input->post('currency2_mp_old'),
              'compensation_gb' => $this->input->post('compensation_gb'),
              'compensation_gb_old' => $this->input->post('compensation_gb_old'),
              'currency2_gb' => $this->input->post('currency2_gb'),
              'currency2_gb_old' => $this->input->post('currency2_gb_old'),
              'increase' => $this->input->post('increase'),
              'elec_choice' => $this->input->post('elec_choice'),
              'electricity' => $this->input->post('electricity'),
              'currency3' => $this->input->post('currency3'),
              'location' => $this->input->post('location'),
              'activity' => $this->input->post('activity'),
              'others' => $this->input->post('others'),
              'others_old' => $this->input->post('others_old')
            );
            $this->data['contract'] = $this->contract_model->get_contract($contr_id);
            $this->data['days'] = $this->contract_model->get_day($contr_id);
            $hotel = $this->hotels_model->get_by_id($form_data['hotel_id']);   
            $service = $this->contract_model->get_service_by_id($form_data['service_id']);   
            //die(print_r($service));                     
            $company = $this->contract_model->get_company_by_id($form_data['company_id']);  
            $ip = $this->input->ip_address();
            if ($this->data['contract']['service_id'] != $form_data['service_id']) {
              $data = array(
                'old' => $this->data['contract']['service_name'],
                'new' => $service['name'],
                'ip' => $ip
              );
              $this->new_log($this->data['user_id'], "Update", "Contract", $contr_id, json_encode($data, TRUE), "The Service Has Been Changed");
            }
            if ($this->data['contract']['brand'] != $form_data['brand']) {
              $data = array(
                'old' => $this->data['contract']['brand'],
                'new' => $form_data['brand'],
                'ip' => $ip
              );
              $this->new_log($this->data['user_id'], "Update", "Contract", $contr_id, json_encode($data, TRUE), "The Brand Has Been Changed");
            }
            if ($this->data['contract']['city'] != $form_data['city']) {
              $data = array(
                'old' => $this->data['contract']['city'],
                'new' => $form_data['city'],
                'ip' => $ip
              );
              $this->new_log($this->data['user_id'], "Update", "Contract", $contr_id, json_encode($data, TRUE), "The City Has Been Changed");
            }                                           
            if ($this->data['contract']['hotel_id'] != $form_data['hotel_id']) {
              $data = array(
                'old' => $this->data['contract']['hotel_name'],
                'new' => $hotel['name'],
                'ip' => $ip
              );
              $this->new_log($this->data['user_id'], "Update", "Contract", $contr_id, json_encode($data, TRUE), "The Hotel Has Been Changed");
            }
            if ($this->data['contract']['company_id'] != $form_data['company_id']) {
              $data = array(
                'old' => $this->data['contract']['company_name'],
                'new' => $hotel['name'],
                'ip' => $ip
              );
              $this->new_log($this->data['user_id'], "Update", "Contract", $contr_id, json_encode($data, TRUE), "The Company Has Been Changed");
            }
            if ($this->data['contract']['name'] != $form_data['name']) {
              $data = array(
                'old' => $this->data['contract']['name'],
                'new' => $form_data['name'],
                'ip' => $ip
              );
              $this->new_log($this->data['user_id'], "Update", "Contract", $contr_id, json_encode($data, TRUE), "The Name Has Been Changed");
            }
            if ($this->data['contract']['name_old'] != $form_data['name_old']) {
              $data = array(
                'old' => $this->data['contract']['name_old'],
                'new' => $form_data['name_old'],
                'ip' => $ip
              );
              $this->new_log($this->data['user_id'], "Update", "Contract", $contr_id, json_encode($data, TRUE), "The Old Name Has Been Changed");
            }
            if ($this->data['contract']['name_en'] != $form_data['name_en']) {
              $data = array(
                'old' => $this->data['contract']['name_en'],
                'new' => $form_data['name_en'],
                'ip' => $ip
              );
              $this->new_log($this->data['user_id'], "Update", "Contract", $contr_id, json_encode($data, TRUE), "The English Name Has Been Changed");
            }
            if ($this->data['contract']['name_en_old'] != $form_data['name_en_old']) {
              $data = array(
                'old' => $this->data['contract']['name_en_old'],
                'new' => $form_data['name_en_old'],
                'ip' => $ip
              );
              $this->new_log($this->data['user_id'], "Update", "Contract", $contr_id, json_encode($data, TRUE), "The Old English Name Has Been Changed");
            }
            if ($this->data['contract']['address'] != $form_data['address']) {
              $data = array(
                'old' => $this->data['contract']['address'],
                'new' => $form_data['address'],
                'ip' => $ip
              );
              $this->new_log($this->data['user_id'], "Update", "Contract", $contr_id, json_encode($data, TRUE), "The Address Has Been Changed");
            }
            if ($this->data['contract']['address_old'] != $form_data['address_old']) {
              $data = array(
                'old' => $this->data['contract']['address_old'],
                'new' => $form_data['address_old'],
                'ip' => $ip
              );
              $this->new_log($this->data['user_id'], "Update", "Contract", $contr_id, json_encode($data, TRUE), "The Old Address Has Been Changed");
            }
            if ($this->data['contract']['taxes'] != $form_data['taxes']) {
              $data = array(
                'old' => $this->data['contract']['taxes'],
                'new' => $form_data['taxes'],
                'ip' => $ip
              );
              $this->new_log($this->data['user_id'], "Update", "Contract", $contr_id, json_encode($data, TRUE), "The Taxes ID Has Been Changed");
            }
            if ($this->data['contract']['taxes_old'] != $form_data['taxes_old']) {
              $data = array(
                'old' => $this->data['contract']['taxes_old'],
                'new' => $form_data['taxes_old'],
                'ip' => $ip
              );
              $this->new_log($this->data['user_id'], "Update", "Contract", $contr_id, json_encode($data, TRUE), "The Old Taxes ID Has Been Changed");
            }
            if ($this->data['contract']['idp'] != $form_data['idp']) {
              $data = array(
                'old' => $this->data['contract']['idp'],
                'new' => $form_data['idp'],
                'ip' => $ip
              );
              $this->new_log($this->data['user_id'], "Update", "Contract", $contr_id, json_encode($data, TRUE), "The ID Has Been Changed");
            }
            if ($this->data['contract']['idp_old'] != $form_data['idp_old']) {
              $data = array(
                'old' => $this->data['contract']['idp_old'],
                'new' => $form_data['idp_old'],
                'ip' => $ip
              );
              $this->new_log($this->data['user_id'], "Update", "Contract", $contr_id, json_encode($data, TRUE), "The Old ID Has Been Changed");
            }
            if ($this->data['contract']['licenss'] != $form_data['licenss']) {
              $data = array(
                'old' => $this->data['contract']['licenss'],
                'new' => $form_data['licenss'],
                'ip' => $ip
              );
              $this->new_log($this->data['user_id'], "Update", "Contract", $contr_id, json_encode($data, TRUE), "The Licenss ID Has Been Changed");
            }
            if ($this->data['contract']['licenss_old'] != $form_data['licenss_old']) {
              $data = array(
                'old' => $this->data['contract']['licenss_old'],
                'new' => $form_data['licenss_old'],
                'ip' => $ip
              );
              $this->new_log($this->data['user_id'], "Update", "Contract", $contr_id, json_encode($data, TRUE), "The Old Licenss ID Has Been Changed");
            }
            if ($this->data['contract']['start_date'] != $form_data['start_date']) {
              $data = array(
                'old' => $this->data['contract']['start_date'],
                'new' => $form_data['start_date'],
                'ip' => $ip
              );
              $this->new_log($this->data['user_id'], "Update", "Contract", $contr_id, json_encode($data, TRUE), "The Start Date Has Been Changed");
            }
            if ($this->data['contract']['start_date_old'] != $form_data['start_date_old']) {
              $data = array(
                'old' => $this->data['contract']['start_date_old'],
                'new' => $form_data['start_date_old'],
                'ip' => $ip
              );
              $this->new_log($this->data['user_id'], "Update", "Contract", $contr_id, json_encode($data, TRUE), "The Old Start Date Has Been Changed");
            }
            if ($this->data['contract']['from_date'] != $form_data['from_date']) {
              $data = array(
                'old' => $this->data['contract']['from_date'],
                'new' => $form_data['from_date'],
                'ip' => $ip
              );
              $this->new_log($this->data['user_id'], "Update", "Contract", $contr_id, json_encode($data, TRUE), "The From Date Has Been Changed");
            }
            if ($this->data['contract']['from_date_old'] != $form_data['from_date_old']) {
              $data = array(
                'old' => $this->data['contract']['from_date_old'],
                'new' => $form_data['from_date_old'],
                'ip' => $ip
              );
              $this->new_log($this->data['user_id'], "Update", "Contract", $contr_id, json_encode($data, TRUE), "The Old From Date Has Been Changed");
            }
            if ($this->data['contract']['to_date'] != $form_data['to_date']) {
              $data = array(
                'old' => $this->data['contract']['to_date'],
                'new' => $form_data['to_date'],
                'ip' => $ip
              );
              $this->new_log($this->data['user_id'], "Update", "Contract", $contr_id, json_encode($data, TRUE), "The To Date Has Been Changed");
            }
            if ($this->data['contract']['to_date_old'] != $form_data['to_date_old']) {
              $data = array(
                'old' => $this->data['contract']['to_date_old'],
                'new' => $form_data['to_date_old'],
                'ip' => $ip
              );
              $this->new_log($this->data['user_id'], "Update", "Contract", $contr_id, json_encode($data, TRUE), "The Old To Date Has Been Changed");
            }
            if ($this->data['contract']['taxes_per'] != $form_data['taxes_per']) {
              $data = array(
                'old' => $this->data['contract']['taxes_per'],
                'new' => $form_data['taxes_per'],
                'ip' => $ip
              );
              $this->new_log($this->data['user_id'], "Update", "Contract", $contr_id, json_encode($data, TRUE), "The Taxes Percentage Has Been Changed");
            }
            if ($this->data['contract']['taxes_per_old'] != $form_data['taxes_per_old']) {
              $data = array(
                'old' => $this->data['contract']['taxes_per_old'],
                'new' => $form_data['taxes_per_old'],
                'ip' => $ip
              );
              $this->new_log($this->data['user_id'], "Update", "Contract", $contr_id, json_encode($data, TRUE), "The Old Taxes Percentage Has Been Changed");
            }
            if ($this->data['contract']['rent'] != $form_data['rent']) {
              $data = array(
                'old' => $this->data['contract']['rent'],
                'new' => $form_data['rent'],
                'ip' => $ip
              );
              $this->new_log($this->data['user_id'], "Update", "Contract", $contr_id, json_encode($data, TRUE), "The Rent Has Been Changed");
            }
            if ($this->data['contract']['rent_old'] != $form_data['rent_old']) {
              $data = array(
                'old' => $this->data['contract']['rent_old'],
                'new' => $form_data['rent_old'],
                'ip' => $ip
              );
              $this->new_log($this->data['user_id'], "Update", "Contract", $contr_id, json_encode($data, TRUE), "The Old Rent Has Been Changed");
            }
            if ($this->data['contract']['currency'] != $form_data['currency']) {
              $data = array(
                'old' => $this->data['contract']['currency'],
                'new' => $form_data['currency'],
                'ip' => $ip
              );
              $this->new_log($this->data['user_id'], "Update", "Contract", $contr_id, json_encode($data, TRUE), "The Currency Has Been Changed");
            }
            if ($this->data['contract']['currency_old'] != $form_data['currency_old']) {
              $data = array(
                'old' => $this->data['contract']['currency_old'],
                'new' => $form_data['currency_old'],
                'ip' => $ip
              );
              $this->new_log($this->data['user_id'], "Update", "Contract", $contr_id, json_encode($data, TRUE), "The Old Currency Has Been Changed");
            }
            if ($this->data['contract']['rent_mp'] != $form_data['rent_mp']) {
              $data = array(
                'old' => $this->data['contract']['rent_mp'],
                'new' => $form_data['rent_mp'],
                'ip' => $ip
              );
              $this->new_log($this->data['user_id'], "Update", "Contract", $contr_id, json_encode($data, TRUE), "The MP Rent Has Been Changed");
            }
            if ($this->data['contract']['rent_mp_old'] != $form_data['rent_mp_old']) {
              $data = array(
                'old' => $this->data['contract']['rent_mp_old'],
                'new' => $form_data['rent_mp_old'],
                'ip' => $ip
              );
              $this->new_log($this->data['user_id'], "Update", "Contract", $contr_id, json_encode($data, TRUE), "The Old MP Rent Has Been Changed");
            }
            if ($this->data['contract']['currency_mp'] != $form_data['currency_mp']) {
              $data = array(
                'old' => $this->data['contract']['currency_mp'],
                'new' => $form_data['currency_mp'],
                'ip' => $ip
              );
              $this->new_log($this->data['user_id'], "Update", "Contract", $contr_id, json_encode($data, TRUE), "The MP Currency Has Been Changed");
            }
            if ($this->data['contract']['currency_mp_old'] != $form_data['currency_mp_old']) {
              $data = array(
                'old' => $this->data['contract']['currency_mp_old'],
                'new' => $form_data['currency_mp_old'],
                'ip' => $ip
              );
              $this->new_log($this->data['user_id'], "Update", "Contract", $contr_id, json_encode($data, TRUE), "The Old MP Currency Has Been Changed");
            }
            if ($this->data['contract']['rent_gb'] != $form_data['rent_gb']) {
              $data = array(
                'old' => $this->data['contract']['rent_gb'],
                'new' => $form_data['rent_gb'],
                'ip' => $ip
              );
              $this->new_log($this->data['user_id'], "Update", "Contract", $contr_id, json_encode($data, TRUE), "The GB Rent Has Been Changed");
            }
            if ($this->data['contract']['rent_gb_old'] != $form_data['rent_gb_old']) {
              $data = array(
                'old' => $this->data['contract']['rent_gb_old'],
                'new' => $form_data['rent_gb_old'],
                'ip' => $ip
              );
              $this->new_log($this->data['user_id'], "Update", "Contract", $contr_id, json_encode($data, TRUE), "The Old GB Rent Has Been Changed");
            }
            if ($this->data['contract']['currency_gb'] != $form_data['currency_gb']) {
              $data = array(
                'old' => $this->data['contract']['currency_gb'],
                'new' => $form_data['currency_gb'],
                'ip' => $ip
              );
              $this->new_log($this->data['user_id'], "Update", "Contract", $contr_id, json_encode($data, TRUE), "The GB Currency Has Been Changed");
            }
            if ($this->data['contract']['currency_gb_old'] != $form_data['currency_gb_old']) {
              $data = array(
                'old' => $this->data['contract']['currency_gb_old'],
                'new' => $form_data['currency_gb_old'],
                'ip' => $ip
              );
              $this->new_log($this->data['user_id'], "Update", "Contract", $contr_id, json_encode($data, TRUE), "The Old GB Currency Has Been Changed");
            }
            if ($this->data['contract']['safty'] != $form_data['safty']) {
              $data = array(
                'old' => $this->data['contract']['safty'],
                'new' => $form_data['safty'],
                'ip' => $ip
              );
              $this->new_log($this->data['user_id'], "Update", "Contract", $contr_id, json_encode($data, TRUE), "The Safty Has Been Changed");
            }
            if ($this->data['contract']['safty_old'] != $form_data['safty_old']) {
              $data = array(
                'old' => $this->data['contract']['safty_old'],
                'new' => $form_data['safty_old'],
                'ip' => $ip
              );
              $this->new_log($this->data['user_id'], "Update", "Contract", $contr_id, json_encode($data, TRUE), "The Old Safty Has Been Changed");
            }
            if ($this->data['contract']['currency1'] != $form_data['currency1']) {
              $data = array(
                'old' => $this->data['contract']['currency1'],
                'new' => $form_data['currency1'],
                'ip' => $ip
              );
              $this->new_log($this->data['user_id'], "Update", "Contract", $contr_id, json_encode($data, TRUE), "The Safty Currency Has Been Changed");
            }
            if ($this->data['contract']['currency1_old'] != $form_data['currency1_old']) {
              $data = array(
                'old' => $this->data['contract']['currency1_old'],
                'new' => $form_data['currency1_old'],
                'ip' => $ip
              );
              $this->new_log($this->data['user_id'], "Update", "Contract", $contr_id, json_encode($data, TRUE), "The Old Safty Currency Has Been Changed");
            }
            if ($this->data['contract']['safty_mp'] != $form_data['safty_mp']) {
              $data = array(
                'old' => $this->data['contract']['safty_mp'],
                'new' => $form_data['safty_mp'],
                'ip' => $ip
              );
              $this->new_log($this->data['user_id'], "Update", "Contract", $contr_id, json_encode($data, TRUE), "The MP Safty Has Been Changed");
            }
            if ($this->data['contract']['safty_mp_old'] != $form_data['safty_mp_old']) {
              $data = array(
                'old' => $this->data['contract']['safty_mp_old'],
                'new' => $form_data['safty_mp_old'],
                'ip' => $ip
              );
              $this->new_log($this->data['user_id'], "Update", "Contract", $contr_id, json_encode($data, TRUE), "The Old MP Safty Has Been Changed");
            }
            if ($this->data['contract']['currency1_mp'] != $form_data['currency1_mp']) {
              $data = array(
                'old' => $this->data['contract']['currency1_mp'],
                'new' => $form_data['currency1_mp'],
                'ip' => $ip
              );
              $this->new_log($this->data['user_id'], "Update", "Contract", $contr_id, json_encode($data, TRUE), "The MP Safty Currency Has Been Changed");
            }
            if ($this->data['contract']['currency1_mp_old'] != $form_data['currency1_mp_old']) {
              $data = array(
                'old' => $this->data['contract']['currency1_mp_old'],
                'new' => $form_data['currency1_mp_old'],
                'ip' => $ip
              );
              $this->new_log($this->data['user_id'], "Update", "Contract", $contr_id, json_encode($data, TRUE), "The Old MP Safty Currency Has Been Changed");
            }
            if ($this->data['contract']['safty_gb'] != $form_data['safty_gb']) {
              $data = array(
                'old' => $this->data['contract']['safty_gb'],
                'new' => $form_data['safty_gb'],
                'ip' => $ip
              );
              $this->new_log($this->data['user_id'], "Update", "Contract", $contr_id, json_encode($data, TRUE), "The GB Safty Has Been Changed");
            }
            if ($this->data['contract']['safty_gb_old'] != $form_data['safty_gb_old']) {
              $data = array(
                'old' => $this->data['contract']['safty_gb_old'],
                'new' => $form_data['safty_gb_old'],
                'ip' => $ip
              );
              $this->new_log($this->data['user_id'], "Update", "Contract", $contr_id, json_encode($data, TRUE), "The Old GB Safty Has Been Changed");
            }
            if ($this->data['contract']['currency1_gb'] != $form_data['currency1_gb']) {
              $data = array(
                'old' => $this->data['contract']['currency1_gb'],
                'new' => $form_data['currency1_gb'],
                'ip' => $ip
              );
              $this->new_log($this->data['user_id'], "Update", "Contract", $contr_id, json_encode($data, TRUE), "The GB Safty Currency Has Been Changed");
            }
            if ($this->data['contract']['currency1_gb_old'] != $form_data['currency1_gb_old']) {
              $data = array(
                'old' => $this->data['contract']['currency1_gb_old'],
                'new' => $form_data['currency1_gb_old'],
                'ip' => $ip
              );
              $this->new_log($this->data['user_id'], "Update", "Contract", $contr_id, json_encode($data, TRUE), "The Old GB Safty Currency Has Been Changed");
            }
            if ($this->data['contract']['compensation'] != $form_data['compensation']) {
              $data = array(
                'old' => $this->data['contract']['compensation'],
                'new' => $form_data['compensation'],
                'ip' => $ip
              );
              $this->new_log($this->data['user_id'], "Update", "Contract", $contr_id, json_encode($data, TRUE), "The Compensation Has Been Changed");
            }
            if ($this->data['contract']['compensation_old'] != $form_data['compensation_old']) {
              $data = array(
                'old' => $this->data['contract']['compensation_old'],
                'new' => $form_data['compensation_old'],
                'ip' => $ip
              );
              $this->new_log($this->data['user_id'], "Update", "Contract", $contr_id, json_encode($data, TRUE), "The Old Compensation Has Been Changed");
            }
            if ($this->data['contract']['currency2'] != $form_data['currency2']) {
              $data = array(
                'old' => $this->data['contract']['currency2'],
                'new' => $form_data['currency2'],
                'ip' => $ip
              );
              $this->new_log($this->data['user_id'], "Update", "Contract", $contr_id, json_encode($data, TRUE), "The Compensation Currency Has Been Changed");
            }
            if ($this->data['contract']['currency2_old'] != $form_data['currency2_old']) {
              $data = array(
                'old' => $this->data['contract']['currency2_old'],
                'new' => $form_data['currency2_old'],
                'ip' => $ip
              );
              $this->new_log($this->data['user_id'], "Update", "Contract", $contr_id, json_encode($data, TRUE), "The Old Compensation Currency Has Been Changed");
            }
            if ($this->data['contract']['compensation_mp'] != $form_data['compensation_mp']) {
              $data = array(
                'old' => $this->data['contract']['compensation_mp'],
                'new' => $form_data['compensation_mp'],
                'ip' => $ip
              );
              $this->new_log($this->data['user_id'], "Update", "Contract", $contr_id, json_encode($data, TRUE), "The MP Compensation Has Been Changed");
            }
            if ($this->data['contract']['compensation_mp_old'] != $form_data['compensation_mp_old']) {
              $data = array(
                'old' => $this->data['contract']['compensation_mp_old'],
                'new' => $form_data['compensation_mp_old'],
                'ip' => $ip
              );
              $this->new_log($this->data['user_id'], "Update", "Contract", $contr_id, json_encode($data, TRUE), "The Old MP Compensation Has Been Changed");
            }
            if ($this->data['contract']['currency2_mp'] != $form_data['currency2_mp']) {
              $data = array(
                'old' => $this->data['contract']['currency2_mp'],
                'new' => $form_data['currency2_mp'],
                'ip' => $ip
              );
              $this->new_log($this->data['user_id'], "Update", "Contract", $contr_id, json_encode($data, TRUE), "The MP Compensation Currency Has Been Changed");
            }
            if ($this->data['contract']['currency2_mp_old'] != $form_data['currency2_mp_old']) {
              $data = array(
                'old' => $this->data['contract']['currency2_mp_old'],
                'new' => $form_data['currency2_mp_old'],
                'ip' => $ip
              );
              $this->new_log($this->data['user_id'], "Update", "Contract", $contr_id, json_encode($data, TRUE), "The Old MP Compensation Currency Has Been Changed");
            }
            if ($this->data['contract']['compensation_gb'] != $form_data['compensation_gb']) {
              $data = array(
                'old' => $this->data['contract']['compensation_gb'],
                'new' => $form_data['compensation_gb'],
                'ip' => $ip
              );
              $this->new_log($this->data['user_id'], "Update", "Contract", $contr_id, json_encode($data, TRUE), "The GB Compensation Has Been Changed");
            }
            if ($this->data['contract']['compensation_gb_old'] != $form_data['compensation_gb_old']) {
              $data = array(
                'old' => $this->data['contract']['compensation_gb_old'],
                'new' => $form_data['compensation_gb_old'],
                'ip' => $ip
              );
              $this->new_log($this->data['user_id'], "Update", "Contract", $contr_id, json_encode($data, TRUE), "The Old GB Compensation Has Been Changed");
            }
            if ($this->data['contract']['currency2_gb'] != $form_data['currency2_gb']) {
              $data = array(
                'old' => $this->data['contract']['currency2_gb'],
                'new' => $form_data['currency2_gb'],
                'ip' => $ip
              );
              $this->new_log($this->data['user_id'], "Update", "Contract", $contr_id, json_encode($data, TRUE), "The GB Compensation Currency Has Been Changed");
            }
            if ($this->data['contract']['currency2_gb_old'] != $form_data['currency2_gb_old']) {
              $data = array(
                'old' => $this->data['contract']['currency2_gb_old'],
                'new' => $form_data['currency2_gb_old'],
                'ip' => $ip
              );
              $this->new_log($this->data['user_id'], "Update", "Contract", $contr_id, json_encode($data, TRUE), "The Old GB Compensation Currency Has Been Changed");
            }
            if ($this->data['contract']['increase'] != $form_data['increase']) {
              $data = array(
                'old' => $this->data['contract']['increase'],
                'new' => $form_data['increase'],
                'ip' => $ip
              );
              $this->new_log($this->data['user_id'], "Update", "Contract", $contr_id, json_encode($data, TRUE), "The Increase Percentage Has Been Changed");
            }
            if ($this->data['contract']['elec_choice'] != $form_data['elec_choice']) {
              $data = array(
                'old' => $this->data['contract']['elec_choice'],
                'new' => $form_data['elec_choice'],
                'ip' => $ip
              );
              $this->new_log($this->data['user_id'], "Update", "Contract", $contr_id, json_encode($data, TRUE), "The Electricity Choice Has Been Changed");
            }
            if ($this->data['contract']['electricity'] != $form_data['electricity']) {
              $data = array(
                'old' => $this->data['contract']['electricity'],
                'new' => $form_data['electricity'],
                'ip' => $ip
              );
              $this->new_log($this->data['user_id'], "Update", "Contract", $contr_id, json_encode($data, TRUE), "The Electricity Has Been Changed");
            }
            if ($this->data['contract']['currency3'] != $form_data['currency3']) {
              $data = array(
                'old' => $this->data['contract']['currency3'],
                'new' => $form_data['currency3'],
                'ip' => $ip
              );
              $this->new_log($this->data['user_id'], "Update", "Contract", $contr_id, json_encode($data, TRUE), "The Electricity Currency Has Been Changed");
            }
            if ($this->data['contract']['location'] != $form_data['location']) {
              $data = array(
                'old' => $this->data['contract']['location'],
                'new' => $form_data['location'],
                'ip' => $ip
              );
              $this->new_log($this->data['user_id'], "Update", "Contract", $contr_id, json_encode($data, TRUE), "The Location Has Been Changed");
            }
            if ($this->data['contract']['activity'] != $form_data['activity']) {
              $data = array(
                'old' => $this->data['contract']['activity'],
                'new' => $form_data['activity'],
                'ip' => $ip
              );
              $this->new_log($this->data['user_id'], "Update", "Contract", $contr_id, json_encode($data, TRUE), "The Activity Has Been Changed");
            }
            if ($this->data['contract']['others'] != $form_data['others']) {
              $data = array(
                'old' => $this->data['contract']['others'],
                'new' => $form_data['others'],
                'ip' => $ip
              );
              $this->new_log($this->data['user_id'], "Update", "Contract", $contr_id, json_encode($data, TRUE), "The Others Has Been Changed");
            }
            if ($this->data['contract']['others_old'] != $form_data['others_old']) {
              $data = array(
                'old' => $this->data['contract']['others_old'],
                'new' => $form_data['others_old'],
                'ip' => $ip
              );
              $this->new_log($this->data['user_id'], "Update", "Contract", $contr_id, json_encode($data, TRUE), "The Old Others Has Been Changed");
            }
            if ($this->data['days'] != $this->input->post('week')) {
              $data = array(
                'old' => $this->data['days'],
                'new' => $this->input->post('week'),
                'ip' => $ip
              );
              $this->new_log($this->data['user_id'], "Update", "Contract", $contr_id, json_encode($data, TRUE), "The Working Days Has Been Changed");
            }
            $this->contract_model->update_contract($form_data, $contr_id);
            $this->contract_model->clear_day($contr_id);
            foreach ($this->input->post('week') as $week) {
              $this->contract_model->add_day($contr_id, $week);
            }
            $this->notify_edit($contr_id, $this->data['user_id']);
            redirect('/contract/view/'.$contr_id);
          }   
        }
        try {
          $this->load->helper('form');
          $this->load->model('contract_model');
          $this->load->model('hotels_model');
          $this->data['contract'] = $this->contract_model->get_contract($contr_id);
          $this->data['uploads'] = $this->contract_model->get_by_fille($contr_id);
          $this->data['days'] = $this->contract_model->get_day($contr_id);  
          $this->data['services'] = $this->contract_model->get_services();
          $this->data['companies'] = $this->contract_model->get_companies();
          $this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());
          $this->data['weeks'] = $this->contract_model->get_weeks();
          $this->load->view('contract_edit',$this->data);
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
      }
    }

    public function notify_edit($contr_id, $user_id) {
      $this->load->model('contract_model');
      $this->load->model('users_model');
      $contract = $this->contract_model->get_contract($contr_id);
      $editor = $this->users_model->get_user_by_id($user_id, TRUE);
      $edit = $editor->fullname;
      $signes = $this->contract_model->get_by_verbal($contr_id);
      $users = array();
      foreach ($signes as $signe){
        if ($signe['user_id'] && $signe['user_id'] != 30) {
          $user = $this->users_model->get_user_by_id($signe['user_id'], TRUE);
          $name = $user->fullname;
          $mail = $user->email;
          $this->load->library('email');
          $this->load->helper('url');
          $contr_url = base_url().'contract/view/'.$contr_id;
          $this->email->from('e-signature@sunrise-resorts.com');
          $this->email->to($mail);
          $this->email->subject("Contract No. #{$contr_id}");
          $this->email->message("Dear {$name},
            <br/>
            <br/>
            {$edit} has made an edit on Contract NO.#{$contr_id}, Please use the link below:
            <br/>
            <a href='{$contr_url}' target='_blank'>{$contr_url}</a>
            <br/>
          "); 
          $mail_result = $this->email->send();
          $data = array(
            'Editor' => $user,
            'name' => $name,
            'mail' => $mail
          );
          $this->new_log(0, "Email", "Contract", $contr_id, json_encode($data, TRUE), "Edit Email Has Been Sent");
        }
      }
    }

    public function edit_upload($contr_id) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{          
        if ($this->input->post('submit')) {
          $this->load->library('form_validation');
          $this->load->library('email');
          if ($this->form_validation->run() == FALSE) {
            redirect('/contract/view/'.$contr_id);
          }   
        }
        try {
          $this->load->helper('form');
          $this->load->model('contract_model');
          $this->load->model('hotels_model');
          $this->data['contract'] = $this->contract_model->get_contract($contr_id);
          $this->data['uploads'] = $this->contract_model->get_by_fille($contr_id);
          $this->load->view('contract_edit_upload',$this->data);
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
      }
    }

    public function mail_me($contr_id) {
      $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
      $this->load->library('email');
      $this->load->helper('url');
      $contr_url = base_url().'contract/view/'.$contr_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($user->email);
      $this->email->subject("Contract NO.#{$contr_id}");
      $this->email->message("Contract NO.#{$contr_id}:
        <br/>
        Please use the link below to view The Contract:
        <a href='{$contr_url}' target='_blank'>{$contr_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
      $data = array(
        'user' => $this->data['user_id']
      );
      $this->new_log($this->data['user_id'], "Email", "Contract", $contr_id, json_encode($data, TRUE), "Email Me Has Been Sent");
      redirect('contract/view/'.$contr_id);
    }

    public function mail($contr_id) {
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
          $contr_url = base_url().'contract/view/'.$contr_id;
          $this->email->from('e-signature@sunrise-resorts.com');
          $this->email->to($email);
          $this->email->subject("A message from {$user->fullname}, Contract No. #{$contr_id}");
          $this->email->message("{$user->fullname} sent you a private message regarding Contract No. #{$contr_id}:
            <br/>
            {$message}
            <br />
            <br />
            Please use the link below to view the Contract:
            <a href='{$contr_url}' target='_blank'>{$contr_url}</a>
            <br/>
          "); 
          $mail_result = $this->email->send();
          $data = array(
            'sender' => $user->fullname,
            'message' => $message,
            'email' => $email
          );
          $this->new_log($this->data['user_id'], "Email", "Contract", $contr_id, json_encode($data, TRUE), "Email To Has Been Sent");
        }
      }
      redirect('contract/view/'.$contr_id);
    }

    public function unsign($signature_id) {
      $this->load->model('contract_model');
      $this->load->model('users_model');
      $signature_identity = $this->contract_model->get_signature_identity($signature_id);
      $this->contract_model->unsign($signature_id);
      $sign_id = $this->contract_model->get_signature_id($signature_id);
      $ip = $this->input->ip_address();
      $data = array(
        'user' => $sign_id['user_id'],
        'role' => $sign_id['role_id'],
        'department' => $sign_id['department_id'],
        'ip' => $ip
      );
      $this->new_log($this->data['user_id'], "Signature", "Contract", $sign_id['contr_id'], json_encode($data, TRUE), "The Form Has Been Unsigned");
      redirect('/contract/contract_stage/'.$signature_identity['contr_id']);  
    }

    public function sign($signature_id, $reject = FALSE) {
      $this->load->model('contract_model');
      $signature_identity = $this->contract_model->get_signature_identity($signature_id);
      $signrs = $this->get_signers($signature_identity['contr_id'], $signature_identity['hotel_id']);
      $this->data['contract'] = $this->contract_model->get_contract($signature_identity['contr_id']);
      if (array_key_exists($this->data['user_id'], $signrs[$signature_id]['queue'])) {
        if ($reject) {
          $this->contract_model->reject($signature_id, $this->data['user_id']);
          $sign_id = $this->contract_model->get_signature_id($signature_id);
          $ip = $this->input->ip_address();
          $data = array(
            'user' => $sign_id['user_id'],
            'role' => $sign_id['role_id'],
            'department' => $sign_id['department_id'],
            'ip' => $ip
          );
          $this->new_log($this->data['user_id'], "Signature", "Contract", $sign_id['contr_id'], json_encode($data, TRUE), "The Form Has Been Rejected");
          redirect('/contract/contract_stage/'.$this->data['contract']['id']);  
        } else {
          $this->contract_model->sign($signature_id, $this->data['user_id']);
          //die(print_r($signature_id));
          $sign_id = $this->contract_model->get_signature_id($signature_id);
          $ip = $this->input->ip_address();
          $data = array(
            'user' => $sign_id['user_id'],
            'role' => $sign_id['role_id'],
            'department' => $sign_id['department_id'],
            'ip' => $ip
          );
          $this->new_log($this->data['user_id'], "Signature", "Contract", $sign_id['contr_id'], json_encode($data, TRUE), "The Form Has Been Signed");
          redirect('/contract/contract_stage/'.$signature_identity['contr_id']);  
        }
      }
      redirect('/contract/view/'.$signature_identity['contr_id']);
    }

    public function comment($contr_id){
      if ($this->input->post('submit')) {
        $this->load->library('form_validation');
        $assumed_id = $this->input->post('assumed_id');   
        $this->form_validation->set_rules('comment','Comment','trim|required');
        if ($this->form_validation->run() == TRUE) {
          $comment = $this->input->post('comment'); 
          $this->load->model('contract_model');
          $comment_data = array(
            'user_id' => $this->data['user_id'],
            'contr_id' => $contr_id,
            'comment' => $comment
          );
          $comment_id = $this->contract_model->insert_comment($comment_data);
          if ($comment_id) {
            $this->contract_model->update_comment_files($assumed_id,$comment_id);
          } else {
            die("ERROR");
          }
          $this->notify_commet($contr_id, $this->data['user_id']);
          if ($this->data['role_id'] == 217) {
            $this->chairman_mail($contr_id);
          }
          $ip = $this->input->ip_address();
          $comment_data['user_ip'] = $ip;
          $this->new_log($this->data['user_id'], "Comment", "Contract", $contr_id, json_encode($comment_data, TRUE), "The Contract Has Been Commented");
        }
        redirect('/contract/view/'.$contr_id);
      }
    }

    private function chairman_mail($contr_id) {
          $this->load->library('email');
          $this->load->helper('url');
          $contr_url = base_url().'contract/view/'.$contr_id;
          $this->email->from('e-signature@sunrise-resorts.com');
          $this->email->to('abeer@sunrise.eg');
          $this->email->subject("Contract No. #{$contr_id}");
          $this->email->message("Dear Madam Abber,
            <br/>
            <br/>
            Mr Hossam Commented on Contract No. #{$contr_id}, Please use the link below:
            <br/>
            <a href='{$contr_url}' target='_blank'>{$contr_url}</a>
            <br/>
          "); 
          $mail_result = $this->email->send();
      }

    public function comment_upload($comment_id) {
      $file_name = $this->do_upload("upload");
      if (!$file_name) {
        die(json_encode($this->data['error']));
      } else {
        $this->load->model("contract_model");
        $this->contract_model->add_comment_fille($comment_id, $file_name, $this->data['user_id']);
        die("{}");
      }
    }

    public function comment_remove($comment_id, $id) {
      $file_name = $_POST['key'];
      if (!$id) {
        die(json_encode($this->data['error']));
      } else {
        $this->load->model("contract_model");
        $this->contract_model->remove_comment_fille($id);
        die("{}");
      }
    }

    public function notify_commet($contr_id, $user_id) {
      $this->load->model('contract_model');
      $this->load->model('users_model');
      $contract = $this->contract_model->get_contract($contr_id);
      $commenter = $this->users_model->get_user_by_id($user_id, TRUE);
      $comment = $commenter->fullname;
      $signes = $this->contract_model->get_by_verbal($contr_id);
      $users = array();
      foreach ($signes as $signe){
        if ($signe['user_id']  && $signe['user_id'] != 30) {
          $user = $this->users_model->get_user_by_id($signe['user_id'], TRUE);
          $name = $user->fullname;
          $mail = $user->email;
          $this->load->library('email');
          $this->load->helper('url');
          $contr_url = base_url().'contract/view/'.$contr_id;
          $this->email->from('e-signature@sunrise-resorts.com');
          $this->email->to($mail);
          $this->email->subject("Contract No. #{$contr_id}");
          $this->email->message("Dear {$name},
            <br/>
            <br/>
            {$comment} has made a comment on Contract NO.#{$contr_id}, Please use the link below:
            <br/>
            <a href='{$contr_url}' target='_blank'>{$contr_url}</a>
            <br/>
          "); 
          $mail_result = $this->email->send();
          $data = array(
            'commenter' => $commenter->fullname,
            'user' => $name,
            'mail' => $mail
          );
          $this->new_log($user_id, "Email", "Contract", $contr_id, json_encode($data, TRUE), "Email Contract Comment Has Been Sent");
        }
      }
    }

    /*public function summry($contr_id) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        if ($this->input->post('submit')) {
          $this->load->library('form_validation');
          $this->load->library('email');
          $this->load->model('contract_model');
          $this->data['contract'] = $this->contract_model->get_contract($contr_id);
          $this->form_validation->set_rules('old_id','Old Contract','trim|required');
          if ($this->form_validation->run() == TRUE) {
            $this->load->model('contract_model');
            $this->load->model('users_model');  
            $form_data = array(
              'user_id' => $this->data['user_id'],
              'hotel_id' => $this->data['contract']['hotel_id'],
              'old_id' => $this->input->post('old_id'),
              'new_id' => $contr_id
            );
            $sum_id = $this->contract_model->create_summary($form_data);
            if (!$sum_id) {
              die("ERROR");
            }
            redirect('/contract/view_old/'.$sum_id);
          }
        }
        try {
          $this->load->helper('form');
          $this->load->model('contract_model');
          $this->load->model('hotels_model');
          $this->data['contract'] = $this->contract_model->get_contract($contr_id);
          $this->data['contracts'] = $this->contract_model->get_contracts($this->data['contract']['hotel_id'], $this->data['contract']['service_id']);
          $this->data['id'] = $contr_id;
          $this->load->view('contract_summary',$this->data);
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
      }
    }

    public function view_old($sum_id) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{      
        $this->load->model('contract_model');
        $this->data['summary'] = $this->contract_model->get_summary($sum_id);
        $this->data['contract'] = $this->contract_model->get_contract($this->data['summary']['old_id']);
        $this->data['uploads'] = $this->contract_model->get_by_fille($this->data['summary']['old_id']);
        $this->data['days'] = $this->contract_model->get_day($this->data['summary']['old_id']);
        $this->load->view('contract_view_old', $this->data);
      }
    }*/


    public function summry($contr_id) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        if ($this->input->post('submit')) {
          $this->load->library('form_validation');
          $this->load->model('contract_model');
          $this->load->library('email');
          $this->data['new'] = $this->contract_model->get_contract($contr_id);
          if ($this->form_validation->run() == FALSE) {
            $this->load->model('contract_model');
            $this->load->model('users_model');  
            $form_data = array(
              'user_id' => $this->data['user_id'],
              'hotel_id' => $this->data['new']['hotel_id'],
              'new_id' => $contr_id,
              'advance_old' => $this->input->post('advance_old'),
              'advance_new' => $this->input->post('advance_new'),
              'comment_old' => $this->input->post('comment_old'),
              'comment_new' => $this->input->post('comment_new')
            );
            $sum_id = $this->contract_model->create_summary($form_data);
            $ip = $this->input->ip_address();
            $form_data['user_ip'] = $ip;
            $this->new_log($this->data['user_id'], "New", "Contract", $contr_id, json_encode($form_data, TRUE), "New Contract Summary Has Been Created");
            if (!$sum_id) {
              die("ERROR");
            }
            $this->contract_model->update_state($contr_id, 0);
            $signatures = $this->contract_model->sum_sign();
            $do_sign = $this->contract_model->sum_do_sign($sum_id);
            //die(print_r($do_sign));
            if ($do_sign == 0) {
              foreach ($signatures as $sum_signature) {
                $this->contract_model->add_sum_signature($sum_id, $sum_signature['role'], $sum_signature['department'], $sum_signature['rank']);
              }
            }
            redirect('/contract/summary_stage/'.$sum_id);
          }
        }
        try {
          $this->load->helper('form');
          $this->load->model('contract_model');
          $this->load->model('hotels_model');
          $this->data['new'] = $this->contract_model->get_contract($contr_id);
          $this->data['uploads'] = $this->contract_model->get_by_fille($contr_id);
          $this->load->view('contract_add_summary',$this->data);
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
      }
    }

    public function upload_summary($sum_id) {
      $file_name = $this->do_upload("upload");
      if (!$file_name) {
        die(json_encode($this->data['error']));
      } else {
        $this->load->model("contract_model");
        $this->contract_model->add_summary_fille($sum_id, $file_name, $this->data['user_id']);
        die("{}");
      }
    }

    public function remove_summary($sum_id, $id) {
      $file_name = $_POST['key'];
      if (!$id) {
        die(json_encode($this->data['error']));
      } else {
        $this->load->model("contract_model");
        $this->contract_model->remove_summary_fille($id);
        die("{}");
      }
    }

    public function summary_stage($sum_id) {
      $this->load->model('contract_model');
      $this->data['summary'] = $this->contract_model->get_summary($sum_id);
      $this->data['contract'] = $this->contract_model->get_contract($this->data['summary']['new_id']);
      if ($this->data['summary']['state_id'] == 0) {
        $this->contract_model->update_state($this->data['contract']['id'], 10);
        $this->contract_model->update_sum_state($sum_id, 1);
        redirect('/contract/summary_stage/'.$sum_id);
      } elseif ($this->data['contract']['state_id'] != 0 && $this->data['contract']['state_id'] != 3) {
        $queue = $this->notify_sum_signers($sum_id, $this->data['summary']['hotel_id']);
        if (!$queue) {
          $this->contract_model->update_state($this->data['contract']['id'], 2);
        //}
      //}elseif ($this->data['contract']['state_id'] == 2){
          $user = $this->users_model->get_user_by_id($this->data['summary']['user_id'], TRUE);
          $queue = $this->approvel_summary_mail($user->fullname, $user->email, $sum_id);
          redirect('/contract/view_summary/'.$sum_id);
        }
      }elseif ($this->data['contract']['state_id'] == 3){
        $user = $this->users_model->get_user_by_id($this->data['summary']['user_id'], TRUE);
        $queue = $this->reject_summary_mail($user->fullname, $user->email, $sum_id);
      }
      redirect('/contract/view_summary/'.$sum_id);
    }

    private function notify_sum_signers($sum_id, $hotel_id) {
      $notified = FALSE;
      $signers = $this->get_sum_signers($sum_id, $hotel_id);
      foreach ($signers as $signer) {
        if (isset($signer['queue'])) {
          $notified = TRUE;
          foreach ($signer['queue'] as $uid => $user) {
            $this->signatures_sum_mail($signer['role'], $signer['department'], $user['name'], $user['mail'], $sum_id);
          }
          break;
        }
      }
      return $notified;
    }

    private function get_sum_signers($sum_id, $hotel_id) {
      $this->load->model('contract_model');
      $signatures = $this->contract_model->get_sum_by_verbal($sum_id);
      //die(print_r($signatures));
      return $this->roll_sum_signers($signatures, $hotel_id, $sum_id);
    }

    private function roll_sum_signers($signatures, $hotel_id, $sum_id) {
      $signers = array();
      $this->load->model('users_model');
      $this->load->model('contract_model');
      $this->data['summary'] = $this->contract_model->get_summary($sum_id);
      $this->data['contract'] = $this->contract_model->get_contract($this->data['summary']['new_id']);
      foreach ($signatures as $signature) {
        $signers[$signature['id']] = array();
        $signers[$signature['id']]['role'] = $signature['role'];
        $signers[$signature['id']]['role_id'] = $signature['role_id'];
        $signers[$signature['id']]['department'] = $signature['department'];
        $signers[$signature['id']]['department_id'] = $signature['department_id'];
        if ($signature['user_id']) {
          if ($signature['rank'] == 1){
            $this->contract_model->update_state($this->data['summary']['new_id'], 11);
          }elseif ($signature['rank'] == 2){
            $this->contract_model->update_state($this->data['summary']['new_id'], 12);
          }elseif ($signature['rank'] == 3){
            $this->contract_model->update_state($this->data['summary']['new_id'], 13);
          }elseif ($signature['rank'] == 4){
            $this->contract_model->update_state($this->data['summary']['new_id'], 2);
          }
          $signers[$signature['id']]['sign'] = array();
          $signers[$signature['id']]['sign']['id'] = $signature['user_id'];
          if ($signature['reject'] == 1) {
            $signers[$signature['id']]['sign']['reject'] = "reject";
            $this->contract_model->update_state($this->data['summary']['new_id'], 3);
          } 
          $user = $this->users_model->get_user_by_id($signature['user_id'], TRUE);
          $signers[$signature['id']]['sign']['name'] = $user->fullname;
          $signers[$signature['id']]['sign']['mail'] = $user->email;
          $signers[$signature['id']]['sign']['sign'] = $user->signature;
          $signers[$signature['id']]['sign']['timestamp'] = $signature['timestamp'];
        } else {
          $signers[$signature['id']]['queue'] = array();
          if ($signature['rank'] == 4) {
            $users = array();
            $users[0] = $this->users_model->getby_criteria(1, $hotel_id, $signature['department_id']);
            $users[1] = $this->users_model->getby_criteria(2, $hotel_id, $signature['department_id']);
            $users[2] = $this->users_model->getby_criteria(83, $hotel_id, $signature['department_id']);
            foreach ($users as $user) {
              foreach ($user as $use) {
                $signers[$signature['id']]['queue'][$use['id']] = array();
                $signers[$signature['id']]['queue'][$use['id']]['name'] = $use['fullname'];
                $signers[$signature['id']]['queue'][$use['id']]['mail'] = $use['email'];
              }
            }
          } else {
            $users = $this->users_model->getby_criteria($signature['role_id'], $hotel_id, $signature['department_id']);
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

    private function signatures_sum_mail($role, $department, $name, $mail, $sum_id) {
      $this->load->library('email');
      $this->load->helper('url');
      $this->load->model('contract_model');
      $this->data['summary'] = $this->contract_model->get_summary($sum_id);
      $id = $this->data['summary']['new_id'];
      $contr_url = base_url().'contract/view_summary/'.$sum_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($mail);
      $this->email->subject("Contract No. #{$id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
        Contract No. #{$id} requires your signature, Please use the link below:
        <br/>
        <a href='{$contr_url}' target='_blank'>{$contr_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
      $data = array(
        'role' => $role,
        'department' => $department,
        'name' => $name,
        'mail' => $mail
      );
      $this->new_log(0, "Email", "Contract", $this->data['summary']['new_id'], json_encode($data, TRUE), "Signature Summary Email Has Been Sent");
    }

    private function approvel_summary_mail($name, $email, $sum_id) {
      $this->load->library('email');
      $this->load->helper('url');
      $this->load->model('contract_model');
      $contract = $this->contract_model->get_contract($contr_id);
      $this->data['summary'] = $this->contract_model->get_summary($sum_id);
      $id = $this->data['summary']['new_id'];
      $contr_url = base_url().'contract/view_summary/'.$sum_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($email);
      $this->email->subject("Contract No. #{$id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
        Contract No. #{$id} has been approved, Please use the link below:
        <br/>
        <a href='{$contr_url}' target='_blank'>{$contr_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
      $data = array(
        'name' => $name,
        'mail' => $email
      );
      $this->new_log(0, "Email", "Contract", $this->data['summary']['new_id'], json_encode($data, TRUE), "Approval Summary Email Has Been Sent");
    }

    private function reject_summary_mail($name, $email, $sum_id) {
      $this->load->library('email');
      $this->load->helper('url');
      $this->load->model('contract_model');
      $this->data['summary'] = $this->contract_model->get_summary($sum_id);
      $id = $this->data['summary']['new_id'];
      $contr_url = base_url().'contract/view_summary/'.$sum_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($email);
      $this->email->subject("Contract No. #{$id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
        Contract No. #{$id} has been rejected, Please use the link below:
        <br/>
        <a href='{$contr_url}' target='_blank'>{$contr_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
      $data = array(
        'name' => $name,
        'mail' => $email
      );
      $this->new_log(0, "Email", "Contract", $this->data['summary']['new_id'], json_encode($data, TRUE), "Rejection Summary Email Has Been Sent");
    }

    public function view_summary($sum_id) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{      
        $this->load->model('contract_model');
        $this->load->model('contract_log_model');
        $this->load->model('hotels_model');   
        $this->data['summary'] = $this->contract_model->get_summary($sum_id);
        $this->data['new'] = $this->contract_model->get_contract($this->data['summary']['new_id']);
        $this->data['log'] = $this->contract_log_model->get_log($this->data['summary']['new_id']);
        $this->data['uploads'] = $this->contract_model->get_by_fille($this->data['summary']['new_id']);
        $this->data['comments'] = $this->contract_model->get_sum_comment($sum_id);
        $this->data['signature_path'] = '/assets/uploads/signatures/';
        $this->data['signers'] = $this->get_signers($this->data['new']['id'], $this->data['new']['hotel_id']);
        $this->data['signers_sum'] = $this->get_sum_signers($this->data['summary']['id'], $this->data['summary']['hotel_id']);
        $editor = FALSE;
        $unsign_enable = FALSE;
        $first = TRUE;
        $force_edit = FALSE;
        foreach ($this->data['signers_sum'] as $signer) {
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
          if ( $this->data['summary']['user_id'] == $this->data['user_id'] &&  $this->data['summary']['state_id'] != 2) {
            $editor = TRUE;
          }
        }
        $this->data['unsign_enable'] = (($unsign_enable) || $this->data['is_admin'])? TRUE : FALSE;
        $this->data['is_editor'] = ($editor)? TRUE : FALSE;
        $this->data['id'] = $sum_id;
        $this->load->view('contract_summary_view', $this->data);
      }
    }

    public function sum_mail_me($sum_id) {
      $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
      $this->load->library('email');
      $this->load->helper('url');
      $this->load->model('contract_model');
      $this->data['summary'] = $this->contract_model->get_summary($sum_id);
      $id = $this->data['summary']['new_id'];
      $contr_url = base_url().'contract/view_summary/'.$sum_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($user->email);
      $this->email->subject("Contract NO.#{$id}");
      $this->email->message("Contract NO.#{$id}:
        <br/>
        Please use the link below to view The Contract:
        <a href='{$contr_url}' target='_blank'>{$contr_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
      $data = array(
        'user' => $this->data['user_id']
      );
      $this->new_log($this->data['user_id'], "Email", "Contract", $this->data['summary']['new_id'], json_encode($data, TRUE), "Email Summary Me Has Been Sent");
      redirect('contract/view_summary/'.$sum_id);
    }

    public function sum_mail($sum_id) {
      if ($this->input->post('submit')) {
        $this->load->library('form_validation');
        $this->load->model('contract_model');
        $this->data['summary'] = $this->contract_model->get_summary($sum_id);
        $id = $this->data['summary']['new_id'];
        $this->form_validation->set_rules('message','message is required','trim|required');
        $this->form_validation->set_rules('mail','mail is required','trim|required');
        if ($this->form_validation->run() == TRUE) {
          $message = $this->input->post('message');
          $email = $this->input->post('mail');
          $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
          $this->load->library('email');
          $this->load->helper('url');
          $contr_url = base_url().'contract/view_summary/'.$sum_id;
          $this->email->from('e-signature@sunrise-resorts.com');
          $this->email->to($email);
          $this->email->subject("A message from {$user->fullname}, Contract No. #{$id}");
          $this->email->message("{$user->fullname} sent you a private message regarding Contract No. #{$id}:
            <br/>
            {$message}
            <br />
            <br />
            Please use the link below to view the Contract:
            <a href='{$contr_url}' target='_blank'>{$contr_url}</a>
            <br/>
          "); 
          $mail_result = $this->email->send();
          $data = array(
            'sender' => $user->fullname,
            'message' => $message,
            'email' => $email
          );
          $this->new_log($this->data['user_id'], "Email", "Contract", $this->data['summary']['new_id'], json_encode($data, TRUE), "Email Summary To Has Been Sent");
        }
      }
      redirect('contract/view_summary/'.$sum_id);
    }

    public function unsign_sum($signature_id) {
      $this->load->model('contract_model');
      $this->load->model('users_model');
      $signature_identity = $this->contract_model->get_sum_signature_identity($signature_id);
      //die(print_r($signature_identity ));
      $this->contract_model->unsign_sum($signature_id);
      $sign_id = $this->contract_model->get_signature_sum_id($signature_id);
      $this->data['summary'] = $this->contract_model->get_summary($sign_id['sum_id']);
      $ip = $this->input->ip_address();
      $data = array(
        'user' => $sign_id['user_id'],
        'role' => $sign_id['role_id'],
        'department' => $sign_id['department_id'],
        'ip' => $ip
      );
      $this->new_log($this->data['user_id'], "Signature", "Contract", $this->data['summary']['new_id'], json_encode($data, TRUE), "The Summary Has Been Unsigned");
      redirect('/contract/summary_stage/'.$sign_id['sum_id']);  
    }

    public function sign_sum($signature_id, $reject = FALSE) {
      $this->load->model('contract_model');
      $signature_identity = $this->contract_model->get_sum_signature_identity($signature_id);
      $signrs = $this->get_sum_signers($signature_identity['sum_id'], $signature_identity['hotel_id']);
      $this->data['summary'] = $this->contract_model->get_summary($signature_identity['sum_id']);
      if (array_key_exists($this->data['user_id'], $signrs[$signature_id]['queue'])) {
        if ($reject) {
          $this->contract_model->reject_sum($signature_id, $this->data['user_id']);
          $sign_id = $this->contract_model->get_signature_sum_id($signature_id);
          $this->data['summary'] = $this->contract_model->get_summary($sign_id['sum_id']);
          $ip = $this->input->ip_address();
          $data = array(
            'user' => $sign_id['user_id'],
            'role' => $sign_id['role_id'],
            'department' => $sign_id['department_id'],
            'ip' => $ip
          );
          $this->new_log($this->data['user_id'], "Signature", "Contract", $this->data['summary']['new_id'], json_encode($data, TRUE), "The Summary Has Been Rejected");
          redirect('/contract/summary_stage/'.$signature_identity['sum_id']);  
        } else {
          $this->contract_model->sign_sum($signature_id, $this->data['user_id']);
          $sign_id = $this->contract_model->get_signature_sum_id($signature_id);
          $this->data['summary'] = $this->contract_model->get_summary($sign_id['sum_id']);
          $ip = $this->input->ip_address();
          $data = array(
            'user' => $sign_id['user_id'],
            'role' => $sign_id['role_id'],
            'department' => $sign_id['department_id'],
            'ip' => $ip
          );
          $this->new_log($this->data['user_id'], "Signature", "Contract", $this->data['summary']['new_id'], json_encode($data, TRUE), "The Summary Has Been Signed");
          redirect('/contract/summary_stage/'.$signature_identity['sum_id']);  
        }
      }
      redirect('/contract/view_summary/'.$signature_identity['sum_id']);
    }

    public function comment_sum($sum_id){
      if ($this->input->post('submit')) {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('comment','Comment','trim|required');
        if ($this->form_validation->run() == TRUE) {
          $comment = $this->input->post('comment'); 
          $this->load->model('contract_model');
          $comment_data = array(
            'user_id' => $this->data['user_id'],
            'sum_id' => $sum_id,
            'comment' => $comment
          );
          $this->contract_model->insert_sum_comment($comment_data);
          $this->notify_sum_commet($sum_id, $this->data['user_id']);
          if ($this->data['role_id'] == 217) {
            $this->chairman_sum_mail($sum_id);
          }
          $this->data['summary'] = $this->contract_model->get_summary($sum_id);
          $ip = $this->input->ip_address();
          $comment_data['user_ip'] = $ip;
          $this->new_log($this->data['user_id'], "Comment", "Contract", $this->data['summary']['new_id'], json_encode($comment_data, TRUE), "The Summary Has Been Commented");
        }
        redirect('/contract/view_summary/'.$sum_id);
      }
    }

    private function chairman_sum_mail($sum_id) {
          $this->load->library('email');
          $this->load->helper('url');
          $sum_url = base_url().'contract/view_summary/'.$sum_id;
          $this->email->from('e-signature@sunrise-resorts.com');
          $this->email->to('abeer@sunrise.eg');
          $this->email->subject("Contract Summary No. #{$sum_id}");
          $this->email->message("Dear Madam Abber,
            <br/>
            <br/>
            Mr Hossam Commented on Contract Summary No. #{$sum_id}, Please use the link below:
            <br/>
            <a href='{$sum_url}' target='_blank'>{$sum_url}</a>
            <br/>
          "); 
          $mail_result = $this->email->send();
      }

    public function notify_sum_commet($sum_id, $user_id) {
      $this->load->model('contract_model');
      $this->load->model('users_model');
      $contract = $this->contract_model->get_contract($contr_id);
      $this->data['summary'] = $this->contract_model->get_summary($sum_id);
      $id = $this->data['summary']['new_id'];
      $commenter = $this->users_model->get_user_by_id($user_id, TRUE);
      $comment = $commenter->fullname;
      $signes = $this->contract_model->get_by_verbal($this->data['summary']['new_id']);
      $signes_sum = $this->contract_model->get_sum_by_verbal($sum_id);
      $signers = array();
      foreach ($signes as $sign) {
        array_push($signers, $sign);
      }
      foreach ($signes_sum as $sign) {
        array_push($signers, $sign);
      }
      //die(print_r($signers));
      $users = array();
      foreach ($signers as $signe){
        if ($signe['user_id']  && $signe['user_id'] != 30) {
          $user = $this->users_model->get_user_by_id($signe['user_id'], TRUE);
          $name = $user->fullname;
          $mail = $user->email;
          $this->load->library('email');
          $this->load->helper('url');
          $sum_url = base_url().'contract/view_summary/'.$sum_id;
          $this->email->from('e-signature@sunrise-resorts.com');
          $this->email->to($mail);
          $this->email->subject("Contract No. #{$id}");
          $this->email->message("Dear {$name},
            <br/>
            <br/>
            {$comment} has made a comment on Contract NO.#{$id}, Please use the link below:
            <br/>
            <a href='{$sum_url}' target='_blank'>{$sum_url}</a>
            <br/>
          "); 
          $mail_result = $this->email->send();
          $data = array(
            'commenter' => $comment,
            'user' => $name,
            'mail' => $mail
          );
          //die(print_r($data));
          $this->new_log($user_id, "Email", "Contract", $this->data['summary']['new_id'], json_encode($data, TRUE), "Email Summary Comment Has Been Sent");
        }
      }
    }

  }

?>