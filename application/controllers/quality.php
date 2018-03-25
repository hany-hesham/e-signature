<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class quality extends CI_Controller {

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
      if (isset($this->data['is_claim']) && $this->data['is_claim']) {
        $this->load->view('claim_index', $this->data);
      }else {
        $this->load->view('quality_index', $this->data);
      }
    }else{
      redirect('/unknown');
    }
  }

}