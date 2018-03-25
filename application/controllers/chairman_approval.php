<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  class chairman_approval extends CI_Controller {

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
      $this->data['menu']['active'] = "notification";
    }

    public function index() {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        $this->load->model('chairman_approval_model');
        //if ($this->input->post('submit')) {
          $this->load->model('hotels_model');
          $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
          $hotels = array();
          foreach ($user_hotels as $hotel) {
            $hotels[] = $hotel['id'];
          }
          array_push($hotels, 0);
          $status = $this->input->post('status');
          //die(print_r($status));
          $counter = 0;
          $forms = array();
          if ($status['0'] == 0) {
            $states = $this->chairman_approval_model->get_states();
            foreach ($states as $state) {
              if ($this->data['role_id'] == 7) {
                $forma = $this->chairman_approval_model->chairman_approval($state['database'], $this->data['department_id'], $hotels);
              }else{
                $forma = $this->chairman_approval_model->chairman_approval($state['database'], $this->data['role_id'], $hotels);
              }
              //die(print_r($forma));
              foreach ($forma as $key => $form) {
                if ($state['id'] == 1) {
                  if (is_null($forma[$key]['code'])) {
                    unset($forma[$key]);
                  }else{
                    $forma[$key]['state'] = $state;
                    array_push($forms, $forma[$key]);
                    $counter++;
                  }
                }elseif ($state['id'] == 25) {
                  if (!is_null($forma[$key]['code'])) {
                    unset($forma[$key]);
                  }else{
                    $forma[$key]['state'] = $state;
                    array_push($forms, $forma[$key]);
                    $counter++;
                  }
                }elseif ($state['id'] == 26) {
                  if (is_null($forma[$key]['project_code'])) {
                    unset($forma[$key]);
                  }else{
                    $forma[$key]['state'] = $state;
                    array_push($forms, $forma[$key]);
                    $counter++;
                  }
                }elseif ($state['id'] == 27) {
                  if (!is_null($forma[$key]['project_code'])) {
                    unset($forma[$key]);
                  }else{
                    $forma[$key]['state'] = $state;
                    array_push($forms, $forma[$key]);
                    $counter++;
                  }
                }else{
                  $forma[$key]['state'] = $state;
                  array_push($forms, $forma[$key]);
                  $counter++;
                }
              }
            }
            //die(print_r($forms));
          }else{
            $states = $this->chairman_approval_model->get_state($status);
            foreach ($states as $state) {
              if ($this->data['role_id'] == 7) {
                $forma = $this->chairman_approval_model->chairman_approval($state['database'], $this->data['department_id'], $hotels);
              }else{
                $forma = $this->chairman_approval_model->chairman_approval($state['database'], $this->data['role_id'], $hotels);
              }
              //die(print_r($forma));
              foreach ($forma as $key => $form) {
                if ($state['id'] == 1) {
                  if (is_null($forma[$key]['code'])) {
                    unset($forma[$key]);
                  }else{
                    $forma[$key]['state'] = $state;
                    array_push($forms, $forma[$key]);
                    $counter++;
                  }
                }elseif ($state['id'] == 25) {
                  if (!is_null($forma[$key]['code'])) {
                    unset($forma[$key]);
                  }else{
                    $forma[$key]['state'] = $state;
                    array_push($forms, $forma[$key]);
                    $counter++;
                  }
                }elseif ($state['id'] == 26) {
                  if (is_null($forma[$key]['project_code'])) {
                    unset($forma[$key]);
                  }else{
                    $forma[$key]['state'] = $state;
                    array_push($forms, $forma[$key]);
                    $counter++;
                  }
                }elseif ($state['id'] == 27) {
                  if (!is_null($forma[$key]['project_code'])) {
                    unset($forma[$key]);
                  }else{
                    $forma[$key]['state'] = $state;
                    array_push($forms, $forma[$key]);
                    $counter++;
                  }
                }else{
                  $forma[$key]['state'] = $state;
                  array_push($forms, $forma[$key]);
                  $counter++;
                }
              }
            }
          }
          $this->data['forms'] = $forms;
          if ($status['0'] != 0) {
            $this->data['state'] = $this->chairman_approval_model->get_state($status);
          }
        //}
        $this->data['states'] = $this->chairman_approval_model->get_states();
        $this->data['counter'] = $counter;
        $this->load->view('chairman_approval_index', $this->data);
      }
    }

  }

?>