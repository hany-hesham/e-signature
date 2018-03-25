<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  class azha extends CI_Controller {

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

    public function submit($id = FALSE) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        $this->load->model('azha_model');
        if ($id) {
          $this->data['id'] = $id;
          $this->data['assumed_id'] = $id;
          $this->data['azha'] = $this->azha_model->get_azha($id);
          $this->data['buildings'] = $this->azha_model->get_building($id);
          foreach ($this->data['buildings'] as $key => $building) {
            $this->data['buildings'][$key]['units'] = $this->azha_model->get_unit($this->data['buildings'][$key]['id']);
          }
          if ($this->input->post('submit')) {
            $this->load->library('form_validation');
            $this->load->library('email');
            $assumed_id = $this->input->post('assumed_id');                        
            if ($this->form_validation->run() == TRUE) {
              foreach ($this->input->post('units') as $unit) {
                $unit['user_id'] = $this->data['user_id'];
                $unit['ip'] = $this->input->ip_address();
                $unit_id = $this->azha_model->create_unit($unit);
                if (!$unit_id) {
                  die("ERROR");
                }
              }
              $signatures = $this->azha_model->azha_sign();
              $do_sign = $this->azha_model->azha_do_sign($id);
              if ($do_sign == 0) {
                foreach ($signatures as $azha_signature) {
                  $this->azha_model->add_signature($id, $azha_signature['role'], $azha_signature['department'], $azha_signature['rank']);
                }
              }
              redirect('/azha/azha_stage/'.$id);
            }
          }
        }else{
          if ($this->input->post('submit')) {
            $this->load->library('form_validation');
            $this->load->library('email');
            $assumed_id = $this->input->post('assumed_id');                        
            if ($this->form_validation->run() == TRUE) {
              $data = array(
                'ip' => $this->input->ip_address(),
                'user_id' => $this->data['user_id']
              );
              $azha_id = $this->azha_model->create_azha($data);
              if ($azha_id) {
                $this->azha_model->update_files($assumed_id,$azha_id);
              } else {
                die("ERROR");
              }
              foreach ($this->input->post('buildings') as $building) {
                $this->azha_model->add_building($azha_id, $building);
              }
              redirect('/gate/submit/'.$azha_id);
            }
          }
        }
        try {
          $this->load->helper('form');
          $this->data['buildings'] = $this->azha_model->get_buildings();
          $this->data['assumed_id'] = mt_rand("1048575","10485751048575");
          if ($this->input->post('submit')) {
            $this->data['uploads'] = $this->azha_model->get_by_fille($this->data['assumed_id']);
          } else {
            $this->data['uploads'] = array();
          }
          $this->load->view('azha_add_new',$this->data);
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
      }
    }

    public function cancel() {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        $this->load->model('azha_model');
        $assumed_id = $this->input->post('assumed_id');   
        $this->data['azha'] = $this->azha_model->get_azha($assumed_id);
        $this->data['buildings'] = $this->azha_model->get_building($assumed_id);
        foreach ($this->data['buildings'] as $key => $building) {
          $this->azha_model->clear_unit($this->data['buildings'][$key]['id']);
        }                     
        $this->azha_model->clear_azha($assumed_id);
        $this->azha_model->clear_building($assumed_id);
        $this->azha_model->clear_fille($assumed_id);
      }
    }

  }

?>