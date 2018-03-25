<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  class out_go_report extends CI_Controller {

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

    public function item_report($hotel = FALSE) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        $this->load->helper('form');
        $this->load->model('out_go_model');
        $this->load->model('hotels_model');
        if ($hotel) {
          $this->data['type'] = $hotel;
          if ($this->input->post('submit')) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('item','Item','trim|required');    
            if ($this->form_validation->run() == TRUE) {
              $hotel_id = $this->input->post('hotel_id');
              if ($hotel_id) {
                $this->data['hotel'] = $this->hotels_model->get_by_id($hotel_id);
              }
              $item = $this->input->post('item');
              $this->data['item'] = $item;
              $from_date = $this->input->post('from');
              $to_date = $this->input->post('to');
              if ($from_date && $to_date) {
                $this->data['from_date'] = $from_date;
                $this->data['to_date'] = $to_date;
                $from_date .=" 00:00:00";
                $to_date .= " 23:59:59";
              }
              $this->data['items'] = $this->out_go_model->getall_items($item, $from_date, $to_date, $hotel_id);
              foreach ($this->data['items'] as $key => $out) {
                $this->data['items'][$key]['dates'] =  $this->out_go_model->get_changed_dates($this->data['items'][$key]['out_id']);
              }
              $this->data['items_count'] = $this->out_go_model->getall_items_count($item, $from_date, $to_date, $hotel_id);
            }
          }
        }else{
          if ($this->input->post('submit')) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('item','Item','trim|required');    
            if ($this->form_validation->run() == TRUE) {
              $item = $this->input->post('item');
              $this->data['item'] = $item;
              $from_date = $this->input->post('from');
              $to_date = $this->input->post('to');
              if ($from_date && $to_date) {
                $this->data['from_date'] = $from_date;
                $this->data['to_date'] = $to_date;
                $from_date .=" 00:00:00";
                $to_date .= " 23:59:59";
              }
              $this->data['items'] = $this->out_go_model->getall_items($item, $from_date, $to_date);
              foreach ($this->data['items'] as $key => $out) {
                $this->data['items'][$key]['dates'] =  $this->out_go_model->get_changed_dates($this->data['items'][$key]['out_id']);
              }
              $this->data['items_count'] = $this->out_go_model->getall_items_count($item, $from_date, $to_date);
            }
          }
        }
        $this->load->model('hotels_model');
        $this->load->model('out_go_model');
        $this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
        $this->data['out_gos'] = $this->out_go_model->getall_item();
        $this->load->view('out_go_item_report', $this->data);
      }
    }

    public function monthly_report($hotel = FALSE) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        $this->load->helper('form');
        $this->load->model('out_go_model');
        $this->load->model('hotels_model');
        if ($hotel) {
          $this->data['type'] = $hotel;
          if ($this->input->post('submit')) {
            $this->load->library('form_validation');
            if ($this->form_validation->run() == FALSE) {
              $hotel_id = $this->input->post('hotel_id');
              if ($hotel_id) {
                $this->data['hotel'] = $this->hotels_model->get_by_id($hotel_id);
              }
              $from_date = $this->input->post('from');
              $to_date = $this->input->post('to');
              if ($from_date && $to_date) {
                $this->data['from_date'] = $from_date;
                $this->data['to_date'] = $to_date;
                $from_date .="-01 00:00:00";
                $to_date .= "-31 23:59:59";
              }
              $this->data['out_gos'] = $this->out_go_model->getall_out_gos($from_date, $to_date, $hotel_id);
              foreach ($this->data['out_gos'] as $key => $out) {
                $this->data['out_gos'][$key]['items'] =  $this->out_go_model->get_items($this->data['out_gos'][$key]['id']);
                $this->data['out_gos'][$key]['dates'] =  $this->out_go_model->get_changed_dates($this->data['out_gos'][$key]['id']);

              }
              $this->data['out_gos_count'] = $this->out_go_model->getall_out_gos_count($from_date, $to_date, $hotel_id);
            }
          }
        }else{
          if ($this->input->post('submit')) {
            $this->load->library('form_validation');
            if ($this->form_validation->run() == FALSE) {
              $from_date = $this->input->post('from');
              $to_date = $this->input->post('to');
              if ($from_date && $to_date) {
                $this->data['from_date'] = $from_date;
                $this->data['to_date'] = $to_date;
                $from_date .="-01 00:00:00";
                $to_date .= "-31 23:59:59";
              }
              $this->data['out_gos'] = $this->out_go_model->getall_out_gos($from_date, $to_date);
              foreach ($this->data['out_gos'] as $key => $out) {
                $this->data['out_gos'][$key]['items'] =  $this->out_go_model->get_items($this->data['out_gos'][$key]['id']);
                $this->data['out_gos'][$key]['dates'] =  $this->out_go_model->get_changed_dates($this->data['out_gos'][$key]['id']);
              }
              $this->data['out_gos_count'] = $this->out_go_model->getall_out_gos_count($from_date, $to_date);
            }
          }
        }
        $this->load->model('hotels_model');
        $this->load->model('out_go_model');
        $this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
        $this->load->view('out_go_monthly_report', $this->data);
      }
    }

    public function delivery_report($hotel = FALSE) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        $this->load->helper('form');
        $this->load->model('out_go_model');
        $this->load->model('hotels_model');
        if ($hotel) {
          $this->data['type'] = $hotel;
          if ($this->input->post('submit')) {
            $this->load->library('form_validation');
            if ($this->form_validation->run() == FALSE) {
              $hotel_id = $this->input->post('hotel_id');
              if ($hotel_id) {
                $this->data['hotel'] = $this->hotels_model->get_by_id($hotel_id);
              }
              $from_date = $this->input->post('from');
              $to_date = $this->input->post('to');
              if ($from_date && $to_date) {
                $this->data['from_date'] = $from_date;
                $this->data['to_date'] = $to_date;
              }
              $this->data['out_gos'] = $this->out_go_model->getall_out_gos_delivery($from_date, $to_date, $hotel_id);
              foreach ($this->data['out_gos'] as $key => $out) {
                $this->data['out_gos'][$key]['items'] =  $this->out_go_model->get_items($this->data['out_gos'][$key]['id']);
                $this->data['out_gos'][$key]['dates'] =  $this->out_go_model->get_changed_dates($this->data['out_gos'][$key]['id']);
              }
              $this->data['out_gos_count'] = $this->out_go_model->getall_out_gos_delivery_count($from_date, $to_date, $hotel_id);
            }
          }
        }else{
          if ($this->input->post('submit')) {
            $this->load->library('form_validation');
            if ($this->form_validation->run() == FALSE) {
              $from_date = $this->input->post('from');
              $to_date = $this->input->post('to');
              if ($from_date && $to_date) {
                $this->data['from_date'] = $from_date;
                $this->data['to_date'] = $to_date;
              }
              $this->data['out_gos'] = $this->out_go_model->getall_out_gos_delivery($from_date, $to_date);
              foreach ($this->data['out_gos'] as $key => $out) {
                $this->data['out_gos'][$key]['items'] =  $this->out_go_model->get_items($this->data['out_gos'][$key]['id']);
                $this->data['out_gos'][$key]['dates'] =  $this->out_go_model->get_changed_dates($this->data['out_gos'][$key]['id']);
              }
              $this->data['out_gos_count'] = $this->out_go_model->getall_out_gos_delivery_count($from_date, $to_date);
            }
          }
        }
        $this->load->model('hotels_model');
        $this->load->model('out_go_model');
        $this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
        $this->load->view('out_go_delivery_report', $this->data);
      }
    }

    public function delay_report($hotel = FALSE) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        $this->load->helper('form');
        $this->load->model('out_go_model');
        $this->load->model('hotels_model');
        if ($hotel) {
          $this->data['type'] = $hotel;
          if ($this->input->post('submit')) {
            $this->load->library('form_validation');
            if ($this->form_validation->run() == FALSE) {
              $hotel_id = $this->input->post('hotel_id');
              if ($hotel_id) {
                $this->data['hotel'] = $this->hotels_model->get_by_id($hotel_id);
              }
              $today = date('Y-m-d H:i:s');
              $out_gos = $this->out_go_model->getall_out_gos_delay($today, $hotel_id);
              $out_gos1 = $this->out_go_model->getall_out_gos_delivered($hotel_id);
                  foreach ($out_gos1 as $out_go) {
                    if ($out_go['delivered'] == 1) {
                      if ($out_go['del_date'] > $out_go['re_date']) {
                        array_push($out_gos, $out_go);
                      }
                    }
                  }
              $this->data['out_gos'] = $out_gos;
              $out_gos_count = 0;
              foreach ($this->data['out_gos'] as $key => $out) {
                $this->data['out_gos'][$key]['items'] =  $this->out_go_model->get_items($this->data['out_gos'][$key]['id']);
                $this->data['out_gos'][$key]['dates'] =  $this->out_go_model->get_changed_dates($this->data['out_gos'][$key]['id']);
                $out_gos_count++;
              }
              $this->data['out_gos_count'] = $out_gos_count;
            }
          }
        }else{
          if ($this->input->post('submit')) {
            $this->load->library('form_validation');
            if ($this->form_validation->run() == FALSE) {
              $today = date('Y-m-d H:i:s');
              $out_gos = $this->out_go_model->getall_out_gos_delay($today);
              $out_gos1 = $this->out_go_model->getall_out_gos_delivered();
                  foreach ($out_gos1 as $out_go) {
                    if ($out_go['delivered'] == 1) {
                      if ($out_go['del_date'] > $out_go['re_date']) {
                        array_push($out_gos, $out_go);
                      }
                    }
                  }
              $this->data['out_gos'] = $out_gos;
              $out_gos_count = 0;
              foreach ($this->data['out_gos'] as $key => $out) {
                $this->data['out_gos'][$key]['items'] =  $this->out_go_model->get_items($this->data['out_gos'][$key]['id']);
                $this->data['out_gos'][$key]['dates'] =  $this->out_go_model->get_changed_dates($this->data['out_gos'][$key]['id']);
                $out_gos_count++;
              }
              $this->data['out_gos_count'] = $out_gos_count;
            }
          }
        }
        $this->load->model('hotels_model');
        $this->load->model('out_go_model');
        $this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
        $this->load->view('out_go_delay_report', $this->data);
      }
    }

    public function out_report($hotel = FALSE) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        $this->load->helper('form');
        $this->load->model('out_go_model');
        $this->load->model('hotels_model');
        if ($hotel) {
          $this->data['type'] = $hotel;
          if ($this->input->post('submit')) {
            $this->load->library('form_validation');
            if ($this->form_validation->run() == FALSE) {
              $hotel_id = $this->input->post('hotel_id');
              if ($hotel_id) {
                $this->data['hotel'] = $this->hotels_model->get_by_id($hotel_id);
              }
              $out_gos = $this->out_go_model->getall_out_gos_out($hotel_id);
              $this->data['out_gos'] = $out_gos;
              foreach ($this->data['out_gos'] as $key => $out) {
                $this->data['out_gos'][$key]['dates'] =  $this->out_go_model->get_changed_dates($this->data['out_gos'][$key]['out_id']);
              }
            }
          }
        }else{
          if ($this->input->post('submit')) {
            $this->load->library('form_validation');
            if ($this->form_validation->run() == FALSE) {
              $out_gos = $this->out_go_model->getall_out_gos_out();
              $this->data['out_gos'] = $out_gos;
              foreach ($this->data['out_gos'] as $key => $out) {
                $this->data['out_gos'][$key]['dates'] =  $this->out_go_model->get_changed_dates($this->data['out_gos'][$key]['out_id']);
              }
            }
          }
        }
        $this->load->model('hotels_model');
        $this->load->model('out_go_model');
        $this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
        $this->load->view('out_go_out_report', $this->data);
      }
    }

   public function delivery_change_date($hotel = FALSE) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        $this->load->helper('form');
        $this->load->model('out_go_model');
        $this->load->model('hotels_model');
        if ($hotel) {
          $this->data['type'] = $hotel;
          if ($this->input->post('submit')) {
            $this->load->library('form_validation');
            if ($this->form_validation->run() == FALSE) {
              $hotel_id = $this->input->post('hotel_id');
              if ($hotel_id) {
                $this->data['hotel'] = $this->hotels_model->get_by_id($hotel_id);
              }
              $from_date = $this->input->post('from');
              $to_date = $this->input->post('to');
              if ($from_date && $to_date) {
                $this->data['from_date'] = $from_date;
                $this->data['to_date'] = $to_date;
              }
              $this->data['out_gos'] = $this->out_go_model->getall_delivery_change_date($from_date, $to_date, $hotel_id);
              foreach ($this->data['out_gos'] as $key => $out) {
                $this->data['out_gos'][$key]['dates'] =  $this->out_go_model->get_changed_dates($this->data['out_gos'][$key]['id']);
              }
             // $this->data['out_gos_count'] = $this->out_go_model->getall_out_gos_delivery_count($from_date, $to_date, $hotel_id);
            }
          }
        }else{
          if ($this->input->post('submit')) {
            $this->load->library('form_validation');
            if ($this->form_validation->run() == FALSE) {
              $from_date = $this->input->post('from');
              $to_date = $this->input->post('to');
              if ($from_date && $to_date) {
                $this->data['from_date'] = $from_date;
                $this->data['to_date'] = $to_date;
              }
              $this->data['out_gos'] = $this->out_go_model->getall_delivery_change_date($from_date, $to_date);
              foreach ($this->data['out_gos'] as $key => $out) {
                $this->data['out_gos'][$key]['dates'] =  $this->out_go_model->get_changed_dates($this->data['out_gos'][$key]['id']);
              }
             // $this->data['out_gos_count'] = $this->out_go_model->getall_out_gos_delivery_count($from_date, $to_date);
            }
          }
        }
        $this->load->model('hotels_model');
        $this->load->model('out_go_model');
        $this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
        $this->load->view('out_go_delivery_change_date', $this->data);
      }
    }   


  }

?>