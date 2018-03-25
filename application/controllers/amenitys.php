<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  class amenitys extends CI_Controller {

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
      $this->data['menu']['active'] = "frontoffice";
      $this->data['module_forms'] = array('0' => 3);;
      $this->load->model('chairman_approval_model');
        //if ($this->input->post('submit')) {
          $this->load->model('hotels_model');
          $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
          $hotels = array();
          foreach ($user_hotels as $hotel) {
            $hotels[] = $hotel['id'];
          }
          array_push($hotels, 0);
          $status = $this->data['module_forms'];
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
    }

    public function index() {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        $this->load->model('hotels_model');
        $this->load->model('amenitys_model');
        $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
        $hotels = array();
        foreach ($user_hotels as $hotel) {
          $hotels[] = $hotel['id'];
        }  
        $this->data['amenity'] = $this->amenitys_model->view($hotels);
        foreach ($this->data['amenity'] as $key => $amenity) {
          $this->data['amenity'][$key]['approvals'] = $this->amenitys_model->getby_verbals($this->data['amenity'][$key]['id']);
          $this->data['amenity'][$key]['items'] = $this->amenitys_model->get_itemss($this->data['amenity'][$key]['id']);
          foreach ($this->data['amenity'][$key]['items'] as $keys => $items) {
            $this->data['amenity'][$key]['items'][$keys]['amen'] = $this->amenitys_model->get_ament($this->data['amenity'][$key]['items'][$keys]['id']);
          } 
        } 
        //die(print_r($this->data['amenity']));
        $this->data['hotels'] = $user_hotels;
        $this->data['types'] = $this->amenitys_model->get_types();
        $this->load->view('amenitys_index', $this->data);
      }
    }

    public function index_app() {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        $this->load->model('hotels_model');
        $this->load->model('amenitys_model');
        $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
        $hotels = array();
        foreach ($user_hotels as $hotel) {
          $hotels[] = $hotel['id'];
        }  
        $this->data['amenity'] = $this->amenitys_model->view_app($hotels);
        foreach ($this->data['amenity'] as $key => $amenity) {
          $this->data['amenity'][$key]['approvals'] = $this->amenitys_model->getby_verbals($this->data['amenity'][$key]['id']);
          $this->data['amenity'][$key]['items'] = $this->amenitys_model->get_itemss($this->data['amenity'][$key]['id']);
          foreach ($this->data['amenity'][$key]['items'] as $keys => $items) {
            $this->data['amenity'][$key]['items'][$keys]['amen'] = $this->amenitys_model->get_ament($this->data['amenity'][$key]['items'][$keys]['id']);
          } 
        } 
        //die(print_r($this->data['amenity']));
        $this->data['hotels'] = $user_hotels;
        $this->data['types'] = $this->amenitys_model->get_types();
        $this->load->view('amenitys_index', $this->data);
      }
    }

    public function index_rej() {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        $this->load->model('hotels_model');
        $this->load->model('amenitys_model');
        $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
        $hotels = array();
        foreach ($user_hotels as $hotel) {
          $hotels[] = $hotel['id'];
        }  
        $this->data['amenity'] = $this->amenitys_model->view_rej($hotels);
        foreach ($this->data['amenity'] as $key => $amenity) {
          $this->data['amenity'][$key]['approvals'] = $this->amenitys_model->getby_verbals($this->data['amenity'][$key]['id']);
          $this->data['amenity'][$key]['items'] = $this->amenitys_model->get_itemss($this->data['amenity'][$key]['id']);
          foreach ($this->data['amenity'][$key]['items'] as $keys => $items) {
            $this->data['amenity'][$key]['items'][$keys]['amen'] = $this->amenitys_model->get_ament($this->data['amenity'][$key]['items'][$keys]['id']);
          } 
        } 
        //die(print_r($this->data['amenity']));
        $this->data['hotels'] = $user_hotels;
        $this->data['types'] = $this->amenitys_model->get_types();
        $this->load->view('amenitys_index', $this->data);
      }
    }

    public function index_wat() {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        if ($this->input->post('submit')) {
          $state = $this->input->post('state');
          $this->load->model('hotels_model');
          $this->load->model('amenitys_model');
          $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
          $hotels = array();
          foreach ($user_hotels as $hotel) {
            $hotels[] = $hotel['id'];
          }  
          $this->data['amenity'] = $this->amenitys_model->view_wat($hotels, $state);
          foreach ($this->data['amenity'] as $key => $amenity) {
            $this->data['amenity'][$key]['approvals'] = $this->amenitys_model->getby_verbals($this->data['amenity'][$key]['id']);
            $this->data['amenity'][$key]['items'] = $this->amenitys_model->get_itemss($this->data['amenity'][$key]['id']);
            foreach ($this->data['amenity'][$key]['items'] as $keys => $items) {
              $this->data['amenity'][$key]['items'][$keys]['amen'] = $this->amenitys_model->get_ament($this->data['amenity'][$key]['items'][$keys]['id']);
            } 
          } 
          //die(print_r($this->data['amenity']));
          $this->data['state'] = $state;
          $this->data['hotels'] = $user_hotels;
          $this->data['types'] = $this->amenitys_model->get_types();
        }
        $this->load->view('amenitys_index_wat', $this->data);
      }
    }

    public function index_dev() {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        $this->load->model('hotels_model');
        $this->load->model('amenitys_model');
        $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
        $hotels = array();
        foreach ($user_hotels as $hotel) {
          $hotels[] = $hotel['id'];
        }  
        $this->data['amenity'] = $this->amenitys_model->view_dev($hotels);
        foreach ($this->data['amenity'] as $key => $amenity) {
          $this->data['amenity'][$key]['approvals'] = $this->amenitys_model->getby_verbals($this->data['amenity'][$key]['id']);
          $this->data['amenity'][$key]['items'] = $this->amenitys_model->get_itemss($this->data['amenity'][$key]['id']);
          foreach ($this->data['amenity'][$key]['items'] as $keys => $items) {
            $this->data['amenity'][$key]['items'][$keys]['amen'] = $this->amenitys_model->get_ament($this->data['amenity'][$key]['items'][$keys]['id']);
          } 
        } 
        //die(print_r($this->data['amenity']));
        $this->data['hotels'] = $user_hotels;
        $this->data['types'] = $this->amenitys_model->get_types();
        $this->load->view('amenitys_index', $this->data);
      }
    }

    public function index_ref() {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        $this->load->model('hotels_model');
        $this->load->model('amenitys_model');
        $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
        $hotels = array();
        foreach ($user_hotels as $hotel) {
          $hotels[] = $hotel['id'];
        }  
        $this->data['amenity'] = $this->amenitys_model->view_ref($hotels);
        foreach ($this->data['amenity'] as $key => $amenity) {
          $this->data['amenity'][$key]['approvals'] = $this->amenitys_model->getby_verbals($this->data['amenity'][$key]['id']);
          $this->data['amenity'][$key]['items'] = $this->amenitys_model->get_itemss($this->data['amenity'][$key]['id']);
          foreach ($this->data['amenity'][$key]['items'] as $keys => $items) {
            $this->data['amenity'][$key]['items'][$keys]['amen'] = $this->amenitys_model->get_ament($this->data['amenity'][$key]['items'][$keys]['id']);
          } 
        } 
        //die(print_r($this->data['amenity']));
        $this->data['hotels'] = $user_hotels;
        $this->data['types'] = $this->amenitys_model->get_types();
        $this->load->view('amenitys_index_ref', $this->data);
      }
    }

    public function type($amen_id) {
      $this->load->model('amenitys_model');
      if ($this->input->post('submit')) {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('type_id','You Need To Chose a Type','trim|required');
        if ($this->form_validation->run() == TRUE) {
          $type = $this->input->post('type_id');
          if ($type == '3') {
            redirect('/amenitys/retoure/'.$amen_id);
          }elseif ($type == '4') {
            redirect('/amenitys/cancel/'.$amen_id);
          }elseif ($type == '5') {
            redirect('/amenitys/show/'.$amen_id);
          }elseif ($type == '6') {
            redirect('/amenitys/deliver/'.$amen_id);
          }
        }
      }
    }

    public function retoure($amen_id) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        if ($this->input->post('submit')) {
          $this->load->library('form_validation');
          $this->load->library('email');
          $this->form_validation->set_rules('reason','You Need To Enter a Reason','trim|required');
          if ($this->form_validation->run() == TRUE) {
            $this->load->model('amenitys_model');
            $this->load->model('users_model'); 
            $data = array(
              'user_id_reason' => $this->data['user_id'],
              'reason' => $this->input->post('reason'),
              'type_id' => '3'
            ); 
            $this->amenitys_model->update_amenity($amen_id, $data);
            $this->data['amenity'] = $this->amenitys_model->get_amenity($amen_id);
            if ($this->data['amenity']['state_id']!='1'){
              $this->notify($this->data['amenity']['id']);
            }
            redirect('/amenitys');
          }   
        }
        try {
          $this->load->helper('form');
          $this->load->model('amenitys_model');
          $this->load->view('amenitys_add_reason',$this->data);
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
      }
    }

    public function cancel($amen_id) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        if ($this->input->post('submit')) {
          $this->load->library('form_validation');
          $this->load->library('email');
          $this->form_validation->set_rules('reason','You Need To Enter a Reason','trim|required');
          if ($this->form_validation->run() == TRUE) {
            $this->load->model('amenitys_model');
            $this->load->model('users_model'); 
            $data = array(
              'user_id_reason' => $this->data['user_id'],
              'reason' => $this->input->post('reason'),
              'type_id' => '4'
            ); 
            $this->amenitys_model->update_amenity($amen_id, $data);
            $this->data['amenity'] = $this->amenitys_model->get_amenity($amen_id);
            if ($this->data['amenity']['state_id']!='1'){
              $this->notify($this->data['amenity']['id']);
            }
            redirect('/amenitys');
          }   
        }
        try {
          $this->load->helper('form');
          $this->load->model('amenitys_model');
          $this->load->view('amenitys_add_reason',$this->data);
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
      }
    }

    public function show($amen_id) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        if ($this->input->post('submit')) {
          $this->load->library('form_validation');
          $this->load->library('email');
          $this->form_validation->set_rules('reason','You Need To Enter a Reason','trim|required');
          if ($this->form_validation->run() == TRUE) {
            $this->load->model('amenitys_model');
            $this->load->model('users_model'); 
            $data = array(
              'user_id_reason' => $this->data['user_id'],
              'reason' => $this->input->post('reason'),
              'type_id' => '5'
            ); 
            $this->amenitys_model->update_amenity($amen_id, $data);
            $this->data['amenity'] = $this->amenitys_model->get_amenity($amen_id);
            if ($this->data['amenity']['state_id']!='1'){
              $this->notify($this->data['amenity']['id']);
            }
            redirect('/amenitys');
          }   
        }
        try {
          $this->load->helper('form');
          $this->load->model('amenitys_model');
          $this->load->view('amenitys_add_reason',$this->data);
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
      }
    }

    public function deliver($amen_id) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        $this->load->model('amenitys_model');
        $this->load->model('users_model'); 
        $data = array(
          'user_id_reason' => $this->data['user_id'],
          'type_id' => '6'
        ); 
        $this->amenitys_model->update_amenity($amen_id, $data);
        $this->data['amenity'] = $this->amenitys_model->get_amenity($amen_id);
        if ($this->data['amenity']['state_id']!='1'){
          $this->notify($this->data['amenity']['id']);
        }
        redirect('/amenitys');
        try {
          $this->load->helper('form');
          $this->load->model('amenitys_model');
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
      }
    }

    public function add() {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        if ($this->input->post('submit')) {
          $this->load->library('form_validation');
          $this->load->library('email');
          $this->form_validation->set_rules('hotel_id','Hotel Name','trim|required');
          $this->form_validation->set_rules('room','Room Number','trim|required');
          if ($this->form_validation->run() == TRUE) {
            $this->load->model('amenitys_model');
            $this->load->model('users_model');  
            $datas = array(
              'user_id' => $this->data['user_id'],
              'hotel_id' => $this->input->post('hotel_id')
            );
            $amen_id = $this->amenitys_model->create_amenity($datas);
            if (!$amen_id) {
              die("ERROR");
            }
            $room = $this->input->post('room');
            $rooms = explode(" ",$room);
            foreach ($rooms as $room) {
              $form_data = array(
                'room' => $room,
                'amen_id' => $amen_id
              );
              $item_id = $this->amenitys_model->create_room($form_data);
              if (!$item_id) {
                die("ERROR");
              }
            }
            redirect('/amenitys/submit/'.$amen_id);
          }
        }
        try {
          $this->load->helper('form');
          $this->load->model('amenitys_model');
          $this->load->model('hotels_model');
          $this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());
          $this->load->view('amenitys_add',$this->data);
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
      }
    }

    public function submit($amen_id) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        if ($this->input->post('submit')) {
          $this->load->library('form_validation');
          $this->load->library('email');
          if ($this->form_validation->run() == FALSE) {
            $this->load->model('amenitys_model');
            $this->load->model('users_model'); 
            $form_data = array(
              'date_time' => $this->input->post('date_time'),
              'ref' => $this->input->post('ref'),
              'refiling' => $this->input->post('refiling'),
              'others' => $this->input->post('others'),
              'relations' => $this->input->post('relations'),
              'type_id' => 1
            );
            $this->amenitys_model->update_amenity($amen_id, $form_data);
            foreach ($this->input->post('rooms') as $room) {
              $room['amen_id'] = $amen_id;  
              $room['user_id'] = $this->data['user_id'];
              $this->amenitys_model->update_room($room, $amen_id, $room['id']);
            }
            foreach ($this->input->post('other') as $others) {
              foreach ($others['otherss'] as $otherss) {
                $this->amenitys_model->add_other($others['id'], $otherss);
              }
            }
            $signatures = $this->amenitys_model->amen_sign();
            $do_sign = $this->amenitys_model->amen_do_sign($amen_id);
            //die(print_r($do_sign));
            if ($do_sign == 0) {
              foreach ($signatures as $amen_signature) {
                $this->amenitys_model->add_signature($amen_id, $amen_signature['role'], $amen_signature['department'], $amen_signature['rank']);
              }
            }
            if ($this->input->post('ref') == 1) {
              redirect('/amenitys/refl/'.$amen_id);
            }else{
              redirect('/amenitys/amenity_stage/'.$amen_id);
            }
          }   
        }
        try {
          $this->load->helper('form');
          $this->load->model('amenitys_model');
          $this->load->model('hotels_model');
          $this->data['amenity'] = $this->amenitys_model->get_amenity($amen_id);
          $this->data['items'] = $this->amenitys_model->get_items($amen_id);
          $this->data['others'] = $this->amenitys_model->get_others();
          $this->data['treatments'] = $this->amenitys_model->get_treatments();
          foreach ($this->data['items'] as $key => $items) {
            $this->data['items'][$key]['contacts'] = $this->amenitys_model->getbyroom($this->data['items'][$key]['room'], $this->data['amenity']['hotel_id']);
          }
          $this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());
          $this->data['uploads'] = $this->amenitys_model->getby_fille($this->data['amenity']['id']);
          $this->load->view('amenitys_add_new',$this->data);
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
      }
    }

    public function make_offer($amen_id) {
      $file_name = $this->do_upload("upload");
      if (!$file_name) {
        die(json_encode($this->data['error']));
      } else {
        $this->load->model("amenitys_model");
        $this->amenitys_model->add($amen_id, $file_name, $this->data['user_id']);
        die("{}");
      }
    }

    public function remove_offer($amen_id, $id) {
      $file_name = $_POST['key'];
      if (!$id) {
        die(json_encode($this->data['error']));
      } else {
        $this->load->model("amenitys_model");
        $this->amenitys_model->remove($id);
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
      }else{
        $file = $this->upload->data();
        return $file['file_name'];
      }
    }

    public function add_exp() {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        if ($this->input->post('submit')) {
          $this->load->library('form_validation');
          $this->load->library('email');
          $this->form_validation->set_rules('hotel_id','Hotel Name','trim|required');
          $this->form_validation->set_rules('room','Room Number','trim|required');
          if ($this->form_validation->run() == TRUE) {
            $this->load->model('amenitys_model');
            $this->load->model('users_model');  
            $datas = array(
              'user_id' => $this->data['user_id'],
              'hotel_id' => $this->input->post('hotel_id')
            );
            $amen_id = $this->amenitys_model->create_amenity($datas);
            if (!$amen_id) {
              die("ERROR");
            }
            $room = $this->input->post('room');
            $rooms = explode(" ",$room);
            foreach ($rooms as $room) {
              $form_data = array(
                'room' => $room,
                'amen_id' => $amen_id
              );
              $item_id = $this->amenitys_model->create_room($form_data);
              if (!$item_id) {
                die("ERROR");
              }
            }
            redirect('/amenitys/submit_exp/'.$amen_id);
          }
        }
        try {
          $this->load->helper('form');
          $this->load->model('amenitys_model');
          $this->load->model('hotels_model');
          $this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());
          $this->load->view('amenitys_add_exp',$this->data);
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
      }
    }

    public function submit_exp($amen_id) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        if ($this->input->post('submit')) {
          $this->load->library('form_validation');
          $this->load->library('email');
          if ($this->form_validation->run() == FALSE) {
            $this->load->model('amenitys_model');
            $this->load->model('users_model'); 
            $form_data = array(
              'date_time' => $this->input->post('date_time'),
              'ref' => $this->input->post('ref'),
              'refiling' => $this->input->post('refiling'),
              'others' => $this->input->post('others'),
              'relations' => $this->input->post('relations'),
              'type_id' => 2
            );
            $this->amenitys_model->update_amenity($amen_id, $form_data);
            foreach ($this->input->post('rooms') as $room) {
              $room['amen_id'] = $amen_id;  
              $room['user_id'] = $this->data['user_id'];
              $this->amenitys_model->update_room($room, $amen_id, $room['id']);
            }
            foreach ($this->input->post('other') as $others) {
              foreach ($others['otherss'] as $otherss) {
                $this->amenitys_model->add_other($others['id'], $otherss);
              }
            }
            $signatures = $this->amenitys_model->amen_sign();
            $do_sign = $this->amenitys_model->amen_do_sign($amen_id);
            //die(print_r($do_sign));
            if ($do_sign == 0) {
              foreach ($signatures as $amen_signature) {
                $this->amenitys_model->add_signature($amen_id, $amen_signature['role'], $amen_signature['department'], $amen_signature['rank']);
              }
            }
            if ($this->input->post('ref') == 1) {
              redirect('/amenitys/refl/'.$amen_id);
            }else{
              redirect('/amenitys/amenity_stage/'.$amen_id);
            }
          }   
        }
        try {
          $this->load->helper('form');
          $this->load->model('amenitys_model');
          $this->load->model('hotels_model');
          $this->data['amenity'] = $this->amenitys_model->get_amenity($amen_id);
          $this->data['items'] = $this->amenitys_model->get_items($amen_id);
          $this->data['others'] = $this->amenitys_model->get_others();
          $this->data['treatments'] = $this->amenitys_model->get_treatments();
          $this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());
          $this->data['uploads'] = $this->amenitys_model->getby_fille($this->data['amenity']['id']);
          $this->load->view('amenitys_add_new_exp',$this->data);
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
      }
    }

    public function submit_group($amen_id) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        if ($this->input->post('submit')) {
          $this->load->library('form_validation');
          $this->load->library('email');
          if ($this->form_validation->run() == FALSE) {
            $this->load->model('amenitys_model');
            $this->load->model('users_model'); 
            $form_data = array(
              'date_time' => $this->input->post('date_time'),
              'ref' => $this->input->post('ref'),
              'refiling' => $this->input->post('refiling'),
              'others' => $this->input->post('others'),
              'relations' => $this->input->post('relations'),
              'type_id' => 2
            );
            $this->amenitys_model->update_amenity($amen_id, $form_data);
            foreach ($this->input->post('rooms') as $room) {
              $room['amen_id'] = $amen_id;  
              $room['user_id'] = $this->data['user_id'];
              $room['longs'] = $this->input->post('longs');
              $room['guest'] = $this->input->post('guest');
              $room['nationality'] = $this->input->post('nationality');
              $room['arrival'] = $this->input->post('arrival');
              $room['departure'] = $this->input->post('departure');
              $room['pax'] = $this->input->post('pax');
              $room['child'] = $this->input->post('child');
              $room['reason'] = $this->input->post('reason');
              $room['treatment_id'] = $this->input->post('treatment_id');
              $room['location'] = $this->input->post('location');
              $this->amenitys_model->update_room($room, $amen_id, $room['id']);
            }
            foreach ($this->input->post('rooms') as $room) {
            	foreach ($this->input->post('other') as $others) {
                	$this->amenitys_model->add_other($room['id'], $others);
              	}
            }
            $signatures = $this->amenitys_model->amen_sign();
            $do_sign = $this->amenitys_model->amen_do_sign($amen_id);
            //die(print_r($do_sign));
            if ($do_sign == 0) {
              foreach ($signatures as $amen_signature) {
                $this->amenitys_model->add_signature($amen_id, $amen_signature['role'], $amen_signature['department'], $amen_signature['rank']);
              }
            }
            if ($this->input->post('ref') == 1) {
              redirect('/amenitys/refl/'.$amen_id);
            }else{
              redirect('/amenitys/amenity_stage/'.$amen_id);
            }
          }   
        }
        try {
          $this->load->helper('form');
          $this->load->model('amenitys_model');
          $this->load->model('hotels_model');
          $this->data['amenity'] = $this->amenitys_model->get_amenity($amen_id);
          $this->data['items'] = $this->amenitys_model->get_items($amen_id);
          $this->data['others'] = $this->amenitys_model->get_others();
          $this->data['treatments'] = $this->amenitys_model->get_treatments();
          $this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());
          $this->data['uploads'] = $this->amenitys_model->getby_fille($this->data['amenity']['id']);
          $this->load->view('amenitys_add_new_group',$this->data);
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
      }
    }

    public function refl($amen_id) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        if ($this->input->post('submit')) {
          $this->load->library('form_validation');
          $this->load->model('amenitys_model');
          $this->load->library('email');
          $this->data['amenity'] = $this->amenitys_model->get_amenity($amen_id);
          $this->data['items'] = $this->amenitys_model->get_items($amen_id);  
          if ($this->form_validation->run() == FALSE) {
            $this->load->model('amenitys_model');
            $this->load->model('users_model'); 
            foreach ($this->input->post('refls') as $refls) {
              $datas = array(
                'user_id' => $this->data['amenity']['user_id'],
                'hotel_id' => $this->data['amenity']['hotel_id'],
                'date_time' => $refls['date_time'],
                'ref' => $this->data['amenity']['ref'],
                'refiling' => $this->data['amenity']['refiling'],
                'others' => $this->data['amenity']['others'],
                'relations' => $this->data['amenity']['relations'],
                'type_id' => 1,
                'refiller' => 1
              );
              $refls_id = $this->amenitys_model->create_amenity($datas);
              if (!$refls_id) {
                die("ERROR");
              }
              //die(print_r($refls_id));
              $refl = array();
              $items = array();
              foreach ($this->data['items'] as $amen) {
                $refl['amen_id'] = $refls_id;  
                $refl['user_id'] = $amen['user_id'];   
                $refl['longs'] = $amen['longs'];   
                $refl['room'] = $amen['room'];   
                $refl['guest'] = $amen['guest'];   
                $refl['nationality'] = $amen['nationality']; 
                $refl['arrival'] = $amen['arrival'];  
                $refl['departure'] = $amen['departure'];  
                $refl['pax'] = $amen['pax'];  
                $refl['child'] = $amen['child'];  
                $refl['treatment_id'] = $amen['treatment_id'];  
                $refl['location'] = $amen['location'];  
                $refl['reason'] = $amen['reason'];  
                $refl_id = $this->amenitys_model->create_room($refl);
                if (!$refl_id) {
                  die("ERROR");
                }
                $items[] = $refl_id;
              }
              foreach ($items as $item) {
                foreach ($refls['otherss'] as $other) {
                  $this->amenitys_model->add_other($item, $other);
                }
              }
            }
            redirect('/amenitys/amenity_stage/'.$amen_id);
          }   
        }
        try {
          $this->load->helper('form');
          $this->load->model('amenitys_model');
          $this->data['amenity'] = $this->amenitys_model->get_amenity($amen_id);
          $this->data['items'] = $this->amenitys_model->get_items($amen_id);   
          $this->data['others'] = $this->amenitys_model->get_others();
          $this->load->view('amenitys_add_refilling',$this->data);
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
      }
    }

    /*public function refiller() {
      $this->load->model('amenitys_model');
      $amenitys = $this->amenitys_model->get_refiller_amenity();
      $date1 = 0;
      $date2 = 0;
      if ($amenitys) {
        foreach ($amenitys as $amenity) {
          $date1 = date("Y-m-d");
          $date2 = date("Y-m-d H:i:s", (strtotime(date("Y-m-d")) + 86400));
          if ($date1 <= $amenity['date_time'] && $amenity['date_time'] < $date2 ) {
            $this->amenitys_model->update_state($amenity['id'], 1);
            $this->notify_signers($amenity['id'], $amenity['hotel_id']);
          }
        }
      }
    }*/

    public function amenity_stage($amen_id) {
      $this->load->model('amenitys_model');
      $this->data['amenity'] = $this->amenitys_model->get_amenity($amen_id);
      $this->data['items'] = $this->amenitys_model->get_items($amen_id);      
      if ($this->data['amenity']['state_id'] == 0) {
        $this->amenitys_model->update_state($amen_id, 1);
        redirect('/amenitys/amenity_stage/'.$amen_id);
      }elseif ($this->data['amenity']['state_id'] != 0 && $this->data['amenity']['state_id'] != 2 && $this->data['amenity']['state_id'] != 3) {
        $queue = $this->notify_signers($amen_id, $this->data['amenity']['hotel_id']);
        if (!$queue) {
          $this->amenitys_model->update_final($amen_id, 0);
          $this->amenitys_model->update_state($amen_id, 2);
          $this->notify_done($amen_id);
        }
      }elseif ($this->data['amenity']['state_id'] == 3){
        $user = $this->users_model->get_user_by_id($this->data['amenity']['user_id'], TRUE);
        $queue = $this->reject_mail($user->fullname, $user->email, $amen_id);
      }
      redirect('/amenitys/view/'.$amen_id);
    }

    private function notify_signers($amen_id) {
      $notified = FALSE;
      $this->load->model('amenitys_model');
      $this->data['amenity'] = $this->amenitys_model->get_amenity($amen_id);
      $signers = $this->get_signers($amen_id, $this->data['amenity']['hotel_id']);
      foreach ($signers as $signer) {
        if (isset($signer['queue'])) {
          $notified = TRUE;
          if ($signer['role_id'] == 7) {
            $this->amenitys_model->update_final($amen_id, $signer['department_id']);
          }else{
            $this->amenitys_model->update_final($amen_id, $signer['role_id']);
          }
          foreach ($signer['queue'] as $uid => $user) {
            $this->signatures_mail($signer['role'], $signer['department'], $user['name'], $user['mail'], $amen_id);
          }
          break;
        }
      }
      return $notified;
    }

    private function get_signers($amen_id, $hotel_id) {
      $this->load->model('amenitys_model');
      $signatures = $this->amenitys_model->getby_verbal($amen_id);
      return $this->roll_signers($signatures, $hotel_id, $amen_id);
    }

    private function roll_signers($signatures, $hotel_id, $amen_id) {
      $signers = array();
      $this->load->model('users_model');
      $this->load->model('amenitys_model');
      foreach ($signatures as $signature) {
        $signers[$signature['id']] = array();
        $signers[$signature['id']]['role'] = $signature['role'];
        $signers[$signature['id']]['role_id'] = $signature['role_id'];
        $signers[$signature['id']]['department'] = $signature['department'];
        $signers[$signature['id']]['department_id'] = $signature['department_id'];
        if ($signature['user_id']) {
          if ($signature['rank'] == 1){
            $this->amenitys_model->update_state($amen_id, 4);
          }elseif ($signature['rank'] == 2){
            $this->amenitys_model->update_state($amen_id, 5);
          }elseif ($signature['rank'] == 3){
            $this->amenitys_model->update_state($amen_id, 6);
          }elseif ($signature['rank'] == 4){
            $this->amenitys_model->update_state($amen_id, 7);
          }elseif ($signature['rank'] == 5){
            $this->amenitys_model->update_state($amen_id, 8);
          }elseif ($signature['rank'] == 6){
            $this->amenitys_model->update_state($amen_id, 2);
          }
          $signers[$signature['id']]['sign'] = array();
          $signers[$signature['id']]['sign']['id'] = $signature['user_id'];
          if ($signature['reject'] == 1) {
            $signers[$signature['id']]['sign']['reject'] = "reject";
            $this->amenitys_model->update_state($amen_id, 3);
          } 
          $user = $this->users_model->get_user_by_id($signature['user_id'], TRUE);
          $signers[$signature['id']]['sign']['name'] = $user->fullname;
          $signers[$signature['id']]['sign']['mail'] = $user->email;
          $signers[$signature['id']]['sign']['sign'] = $user->signature;
          $signers[$signature['id']]['sign']['timestamp'] = $signature['timestamp'];
        }else {
          $signers[$signature['id']]['queue'] = array();
          if ($signature['rank'] == 1) {
            $users = array();
            $users[0] = $this->users_model->getby_criteria(58, $hotel_id, $signature['department_id']);
            $users[1] = $this->users_model->getby_criteria(46, $hotel_id, $signature['department_id']);
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

    private function signatures_mail($role, $department, $name, $mail, $amen_id) {
      $this->load->library('email');
      $this->load->helper('url');
      $amen_url = base_url().'amenitys/view/'.$amen_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($mail);
      $this->email->subject("Guest Amenity Request {$amen_id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
        Guest Amenity Request {$amen_id} requires your signature, Please use the link below:
        <br/>
        <a href='{$amen_url}' target='_blank'>{$amen_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
    }

    public function notify_done($amen_id) {
      $this->load->model('amenitys_model');
      $this->load->model('users_model');
      $signes = $this->amenitys_model->getby_verbal($amen_id);
      $users = array();
      foreach ($signes as $signe){
        if ($signe['user_id'] && $signe['user_id'] != 30) {
          $user = $this->users_model->get_user_by_id($signe['user_id'], TRUE);
          $name = $user->fullname;
          $mail = $user->email;
          $this->load->library('email');
          $this->load->helper('url');
          $amen_url = base_url().'amenitys/view/'.$amen_id;
          $this->email->from('e-signature@sunrise-resorts.com');
          $this->email->to($mail);
          $this->email->subject("Guest Amenity Request NO.#{$amen_id}");
          $this->email->message("Dear {$name},
            <br/>
            <br/>
            Guest Amenity Request NO.#{$amen_id} has been approved, Please use the link below:
            <br/>
            <a href='{$amen_url}' target='_blank'>{$amen_url}</a>
            <br/>
          "); 
          $mail_result = $this->email->send();
        }
      }
      redirect('amenitys/view/'.$amen_id);
    }

    private function reject_mail($name, $email, $amen_id) {
      $this->load->library('email');
      $this->load->helper('url');
      $amen_url = base_url().'amenitys/view/'.$amen_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($email);
      $this->email->subject("Guest Amenity Request {$amen_id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
        Guest Amenity Request {$amen_id} has been rejected, Please use the link below:
        <br/>
        <a href='{$amen_url}' target='_blank'>{$amen_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
    }

    public function view($amen_id) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        $this->load->model('amenitys_model');
        $this->data['amenity'] = $this->amenitys_model->get_amenity($amen_id);
        $this->data['items'] = $this->amenitys_model->get_items($amen_id);      
        foreach ($this->data['items'] as $key => $item) {
          $this->data['items'][$key]['amenit'] = $this->amenitys_model->get_amen($this->data['items'][$key]['id']);
          $this->data['items'][$key]['others'] = $this->amenitys_model->get_other($this->data['items'][$key]['id']);
        } 
        $this->data['amenitys'] = $this->amenitys_model->get_amens($amen_id);    
        //die(print_r($this->data['amenitys']));
        $this->data['uploads'] = $this->amenitys_model->getby_fille($amen_id);
        $this->data['GetComment'] = $this->amenitys_model->GetComment($amen_id);
        $this->data['signature_path'] = '/assets/uploads/signatures/';
        $this->data['signers'] = $this->get_signers($this->data['amenity']['id'], $this->data['amenity']['hotel_id']);
        $editor = FALSE;
        $unsign_enable = FALSE;
        $first = TRUE;
        $force_edit = FALSE;
        foreach ($this->data['signers'] as $signer) {
          if (isset($signer['queue'])) {
            foreach ($signer['queue'] as $uid => $dummy) {
              if ( $uid == $this->data['user_id'] ) {
                $editor = FALSE;
                break;
              }
            }
          } elseif (isset($signer['sign'])) {
            $unsign_enable = FALSE;
            $force_edit = FALSE;
            if ($signer['sign']['id'] == $this->data['user_id']) {
              if ($first) {
                $force_edit = FALSE;
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
          if ( $this->data['amenity']['user_id'] == $this->data['user_id']) {
            $editor = TRUE;
          }
        }
        $this->data['unsign_enable'] = (($unsign_enable) || $this->data['is_admin'])? TRUE : FALSE;
        $this->data['is_editor'] = ( ($this->data['is_admin'] || $editor) || ($force_edit) )? TRUE : FALSE;
        $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
        $this->data['id'] = $amen_id;
        $this->load->view('amenitys_view', $this->data);
      }
    }

    public function edit($amen_id) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        if ($this->input->post('submit')) {
          $this->load->library('form_validation');
          $this->load->library('email');
          if ($this->form_validation->run() == FALSE) {
            $this->load->model('amenitys_model');
            $this->load->model('users_model'); 
            $this->data['amenity'] = $this->amenitys_model->get_amenity($amen_id);
            $form_data = array(
              'date_time' => $this->input->post('date_time'),
              'others' => $this->input->post('others'),
              'relations' => $this->input->post('relations'),
            );
            $this->amenitys_model->update_amenity($amen_id, $form_data);
            foreach ($this->input->post('rooms') as $room) {
              $room['amen_id'] = $amen_id;  
              $room['user_id'] = $this->data['user_id'];
              $this->amenitys_model->update_room($room, $amen_id, $room['id']);
            }
            foreach ($this->input->post('othersss') as $others) {
              $this->amenitys_model->clear_other($others['id']);
              foreach ($others['otherss'] as $otherss) {
                $this->amenitys_model->add_other($others['id'], $otherss);
              }
            }
            if ($this->data['amenity']['state_id']!='1'){
              $this->notify($this->data['amenity']['id']);
            } 
            redirect('/amenitys/view/'.$amen_id);
          }   
        }
        try {
          $this->load->helper('form');
          $this->load->model('amenitys_model');
          $this->load->model('hotels_model');
          $this->data['amenity'] = $this->amenitys_model->get_amenity($amen_id);
          $this->data['items'] = $this->amenitys_model->get_items($amen_id);
          foreach ($this->data['items'] as $key => $item) {
            $this->data['items'][$key]['amenit'] = $this->amenitys_model->get_amen($this->data['items'][$key]['id']);
            $this->data['items'][$key]['others'] = $this->amenitys_model->get_other($this->data['items'][$key]['id']);
          } 
          $this->data['others'] = $this->amenitys_model->get_others();
          $this->data['treatments'] = $this->amenitys_model->get_treatments();
          $this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());
          $this->data['uploads'] = $this->amenitys_model->getby_fille($this->data['amenity']['id']);
          $this->load->view('amenitys_edit',$this->data);
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
      }
    }

    public function notify($amen_id) {
      $this->load->model('amenitys_model');
      $this->load->model('users_model');
      $this->data['amenity'] = $this->amenitys_model->get_amenity($amen_id);
      $signes = $this->amenitys_model->getby_verbal($amen_id);
      $users = array();
      foreach ($signes as $signe){
        if ($signe['user_id'] && $signe['user_id'] != 30) {
          $user = $this->users_model->get_user_by_id($signe['user_id'], TRUE);
          $name = $user->fullname;
          $mail = $user->email;
          $this->load->library('email');
          $this->load->helper('url');
          $amen_url = base_url().'amenitys/view/'.$amen_id;
          $this->email->from('e-signature@sunrise-resorts.com');
          $this->email->to($mail);
          $this->email->subject("Guest Amenity Request NO.#{$amen_id}");
          $this->email->message("Dear {$name},
            <br/>
            <br/>
            Guest Amenity Request NO.#{$amen_id} has been Edited, Please use the link below:
            <br/>
            <a href='{$amen_url}' target='_blank'>{$amen_url}</a>
            <br/>
          "); 
          $mail_result = $this->email->send();
        }
      }
      redirect('amenitys/view/'.$amen_id);
    }

    public function mailme($amen_id) {
      $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
      $this->load->library('email');
      $this->load->helper('url');
      $amen_url = base_url().'amenitys/view/'.$amen_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($user->email);
      $this->email->subject("Guest Amenity Request NO.#{$amen_id}");
      $this->email->message("Guest Amenity Request NO.#{$amen_id}:
        <br/>
        Please use the link below to view the Guest Amenity Request:
        <a href='{$amen_url}' target='_blank'>{$amen_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
      redirect('amenitys/view/'.$amen_id);
    }

    public function move($item_id) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        $this->load->model('amenitys_model');
        $this->data['item'] = $this->amenitys_model->get_item($item_id);
        $this->data['amenity'] = $this->amenitys_model->get_amenity($this->data['item']['amen_id']);
        if ($this->input->post('submit')) {
          $this->load->library('form_validation');
          $this->load->library('email');
          $this->load->model('amenitys_model');
          if ($this->form_validation->run() == FALSE) {
            $this->load->model('amenitys_model');
            $this->load->model('users_model');  
            $formad = array(
              'room_id' => $item_id,
              'amen_id' => $this->data['item']['amen_id'],
              'user_new' => $this->data['user_id'],
              'room_old' => $this->input->post('room_old'),
              'room_new' => $this->input->post('room_new')
            );
            $this->amenitys_model->create_amenitys($formad);
            if ($this->data['amenity']['state_id']!='1'){
              $this->notify($this->data['amenity']['id']);
            }  
            redirect('/amenitys/view/'.$this->data['item']['amen_id']);
          }
        } 
        try {
          $this->load->helper('form');
          $this->load->model('amenitys_model');
          $this->load->model('hotels_model');
          $this->data['item'] = $this->amenitys_model->get_item($item_id);
          $this->data['amenit'] = $this->amenitys_model->get_amen($this->data['item']['id']);
          $this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());
          $this->load->view('amenitys_move',$this->data);
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
      }
    }

    public function mailto($amen_id) {
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
          $amen_url = base_url().'amenitys/view/'.$amen_id;
          $this->email->from('e-signature@sunrise-resorts.com');
          $this->email->to($email);
          $this->email->subject("A message from {$user->fullname}, Guest Amenity Request No.{$amen_id}");
          $this->email->message("{$user->fullname} sent you a private message regarding Guest Amenity Request {$amen_id}:
            <br/>
            {$message}
            <br />
            <br />
            Please use the link below to view the Guest Amenity Request:
            <a href='{$amen_url}' target='_blank'>{$amen_url}</a>
            <br/>
          "); 
          $mail_result = $this->email->send();
        }
      }
      redirect('amenitys/view/'.$amen_id);
    }

    public function unsign($signature_id) {
      $this->load->model('amenitys_model');
      $this->load->model('users_model');
      $signature_identity = $this->amenitys_model->get_signature_identity($signature_id);
      $this->amenitys_model->unsign($signature_id);
      if ($this->data['role_id']) {
        $this->amenitys_model->update_final($signature_identity['amen_id'], $this->data['department_id']);
      }else{
        $this->amenitys_model->update_final($signature_identity['amen_id'], $this->data['role_id']);
      }
      $this->amenitys_model->update_state($signature_identity['amen_id'], 1);
      $amenity = $this->amenitys_model->get_amenity($signature_identity['amen_id']);
      redirect('/amenitys/view/'.$signature_identity['amen_id']);
    }

    public function sign($signature_id, $reject = FALSE) {
      $this->load->model('amenitys_model');
      $signature_identity = $this->amenitys_model->get_signature_identity($signature_id);
      $signrs = $this->get_signers($signature_identity['amen_id'], $signature_identity['hotel_id']);
      $this->data['amenity'] = $this->amenitys_model->get_amenity($signature_identity['amen_id']);
      if (array_key_exists($this->data['user_id'], $signrs[$signature_id]['queue'])) {
        if ($reject) {
          $this->amenitys_model->update_final($signature_identity['amen_id'], 0);
          $this->amenitys_model->reject($signature_id, $this->data['user_id']);
          redirect('/amenitys/amenity_stage/'.$this->data['amenity']['id']);  
        }else {
          $this->amenitys_model->sign($signature_id, $this->data['user_id']);
          redirect('/amenitys/amenity_stage/'.$signature_identity['amen_id']);  
        }
      }
      redirect('/amenitys/view/'.$signature_identity['amen_id']);
    }

    public function Comment($amen_id){
      if ($this->input->post('submit')) {
      $this->load->library('form_validation');
      $this->form_validation->set_rules('comment','Comment','trim|required');
        if ($this->form_validation->run() == TRUE) {
          $comment = $this->input->post('comment'); 
          $this->load->model('amenitys_model');
          $comment_data = array(
            'user_id' => $this->data['user_id'],
            'amen_id' => $amen_id,
            'comment' => $comment
          );
          $this->amenitys_model->InsertComment($comment_data);
        }
        redirect('/amenitys/view/'.$amen_id);
      }
    }

    public function report_hotel() {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        $this->load->helper('form');
        $this->load->model('hotels_model');   
        $this->load->model('amenitys_model');
        $this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
        $this->data['treatments'] = $this->amenitys_model->get_treatments();
        if ($this->input->post('submit')) {
          $hotel_id = $this->input->post('hotel_id');
          $treatment = $this->input->post('treatment');
          $from_date = $this->input->post('from');
          $to_date = $this->input->post('to');
          $this->data['from'] = $from_date;
          $this->data['to'] = $to_date;
          $from_date .=" 00:00:00";
          $to_date .= " 23:59:59";
          $this->data['treatment'] = $this->amenitys_model->get_treatment($treatment);
          $this->data['hotel'] = $this->hotels_model->get_by_id($hotel_id);
          $this->data['items'] = $this->amenitys_model->get_hotel_items($hotel_id, $from_date, $to_date, $treatment);
          //die(print_r($this->data['items']));
          foreach ($this->data['items'] as $key => $item) {
            $this->data['items'][$key]['amenit'] = $this->amenitys_model->get_amen($this->data['items'][$key]['id']);
            $this->data['items'][$key]['others'] = $this->amenitys_model->get_other($this->data['items'][$key]['id']);
          }
          $this->data['items_count'] = $this->amenitys_model->get_hotel_items_count($hotel_id, $from_date, $to_date, $treatment);
        }
        $this->load->view('amenitys_report_hotel', $this->data);
      }
    }

    public function report_hotel_reason() {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        $this->load->helper('form');
        $this->load->model('hotels_model');   
        $this->load->model('amenitys_model');
        $this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
        $this->data['treatments'] = $this->amenitys_model->get_treatments();
        if ($this->input->post('submit')) {
          $hotel_id = $this->input->post('hotel_id');
          $reason = $this->input->post('reason');
          $treatment = $this->input->post('treatment');
          $from_date = $this->input->post('from');
          $to_date = $this->input->post('to');
          $this->data['from'] = $from_date;
          $this->data['to'] = $to_date;
          $this->data['reason'] = $reason;
          $from_date .=" 00:00:00";
          $to_date .= " 23:59:59";
          $this->data['treatment'] = $this->amenitys_model->get_treatment($treatment);
          $this->data['hotel'] = $this->hotels_model->get_by_id($hotel_id);
          $this->data['items'] = $this->amenitys_model->get_hotel_reason($hotel_id, $from_date, $to_date, $treatment, $reason);
          //die(print_r($this->data['items']));
          foreach ($this->data['items'] as $key => $item) {
            $this->data['items'][$key]['amenit'] = $this->amenitys_model->get_amen($this->data['items'][$key]['id']);
            $this->data['items'][$key]['others'] = $this->amenitys_model->get_other($this->data['items'][$key]['id']);
          }
          $this->data['items_count'] = $this->amenitys_model->get_hotel_reason_count($hotel_id, $from_date, $to_date, $treatment, $reason);
        }
        $this->load->view('amenitys_report_hotel_reason', $this->data);
      }
    }

    public function report_detail_hotel() {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        $this->load->helper('form');
        $this->load->model('hotels_model');   
        $this->load->model('amenitys_model');
        $this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
        $this->data['treatments'] = $this->amenitys_model->get_treatments();
        if ($this->input->post('submit')) {
          $hotel_id = $this->input->post('hotel_id');
          $treatment = $this->input->post('treatment');
          $from_date = $this->input->post('from');
          $to_date = $this->input->post('to');
          $this->data['from'] = $from_date;
          $this->data['to'] = $to_date;
          $from_date .=" 00:00:00";
          $to_date .= " 23:59:59";
          $this->data['treatment'] = $this->amenitys_model->get_treatment($treatment);
          $this->data['hotel'] = $this->hotels_model->get_by_id($hotel_id);
          $this->data['items'] = $this->amenitys_model->get_hotel_items($hotel_id, $from_date, $to_date, $treatment);
          foreach ($this->data['items'] as $key => $item) {
            $this->data['items'][$key]['amenit'] = $this->amenitys_model->get_amen($this->data['items'][$key]['id']);
            $this->data['items'][$key]['others'] = $this->amenitys_model->get_other($this->data['items'][$key]['id']);
          }
          $this->data['items_count'] = $this->amenitys_model->get_hotel_items_count($hotel_id, $from_date, $to_date, $treatment);
        }
        $this->load->view('amenitys_detail_report_hotel', $this->data);
      }
    }

    public function report_type_hotel() {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{      
          $this->load->helper('form');
        $this->load->model('hotels_model');   
        $this->load->model('amenitys_model');
        $this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
        $this->data['types'] = $this->amenitys_model->get_types();
        if ($this->input->post('submit')) {
          $hotel_id = $this->input->post('hotel_id');
          $type = $this->input->post('type');
          $from_date = $this->input->post('from');
          $to_date = $this->input->post('to');
          $this->data['from'] = $from_date;
          $this->data['to'] = $to_date;
          $from_date .=" 00:00:00";
          $to_date .= " 23:59:59";
          $this->data['type'] = $this->amenitys_model->get_type($type);
          $this->data['hotel'] = $this->hotels_model->get_by_id($hotel_id);
          $this->data['items'] = $this->amenitys_model->get_hotel_items_type($hotel_id, $from_date, $to_date, $type);
          //die(print_r($this->data['items']));
          foreach ($this->data['items'] as $key => $item) {
            $this->data['items'][$key]['amenit'] = $this->amenitys_model->get_amen($this->data['items'][$key]['id']);
            $this->data['items'][$key]['others'] = $this->amenitys_model->get_other($this->data['items'][$key]['id']);
          }
          $this->data['items_count'] = $this->amenitys_model->get_hotel_items_type_count($hotel_id, $from_date, $to_date, $type);
        }
          $this->load->view('amenitys_type_report_hotel', $this->data);
      }
    }

    public function report_refl_hotel() {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{      
          $this->load->helper('form');
        $this->load->model('hotels_model');   
        $this->load->model('amenitys_model');
        $this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
        if ($this->input->post('submit')) {
          $hotel_id = $this->input->post('hotel_id');
          $from_date = $this->input->post('from');
          $to_date = $this->input->post('to');
          $this->data['from'] = $from_date;
          $this->data['to'] = $to_date;
          $from_date .=" 00:00:00";
          $to_date .= " 23:59:59";
          $this->data['hotel'] = $this->hotels_model->get_by_id($hotel_id);
          $this->data['items'] = $this->amenitys_model->get_hotel_items_refl($hotel_id, $from_date, $to_date);
          foreach ($this->data['items'] as $key => $item) {
            $this->data['items'][$key]['amenit'] = $this->amenitys_model->get_amen($this->data['items'][$key]['id']);
            $this->data['items'][$key]['others'] = $this->amenitys_model->get_other($this->data['items'][$key]['id']);
          }
          $this->data['items_count'] = $this->amenitys_model->get_hotel_items_refl_count($hotel_id, $from_date, $to_date);
        }
          $this->load->view('amenitys_refl_report_hotel', $this->data);
      }
    }

    public function report_all() {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        $this->load->helper('form');
        $this->load->model('hotels_model');   
        $this->load->model('amenitys_model');
        $this->data['treatments'] = $this->amenitys_model->get_treatments();
        if ($this->input->post('submit')) {
          $treatment = $this->input->post('treatment');
          $from_date = $this->input->post('from');
          $to_date = $this->input->post('to');
          $this->data['from'] = $from_date;
          $this->data['to'] = $to_date;
          $from_date .=" 00:00:00";
          $to_date .= " 23:59:59";
          $this->data['treatment'] = $this->amenitys_model->get_treatment($treatment);
          //die(print_r($this->data['treatment']));
          $this->data['items'] = $this->amenitys_model->get_all_items($from_date, $to_date, $treatment);
          foreach ($this->data['items'] as $key => $item) {
            $this->data['items'][$key]['amenit'] = $this->amenitys_model->get_amen($this->data['items'][$key]['id']);
            $this->data['items'][$key]['others'] = $this->amenitys_model->get_other($this->data['items'][$key]['id']);
          }
          $this->data['items_count'] = $this->amenitys_model->get_all_items_count($from_date, $to_date, $treatment);
        }
        $this->load->view('amenitys_report_all', $this->data);
      }
    }

    public function report_detail_all() {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        $this->load->helper('form');
        $this->load->model('hotels_model');   
        $this->load->model('amenitys_model');
        $this->data['treatments'] = $this->amenitys_model->get_treatments();
        if ($this->input->post('submit')) {
          $treatment = $this->input->post('treatment');
          $from_date = $this->input->post('from');
          $to_date = $this->input->post('to');
          $this->data['from'] = $from_date;
          $this->data['to'] = $to_date;
          $from_date .=" 00:00:00";
          $to_date .= " 23:59:59";
          $this->data['treatment'] = $this->amenitys_model->get_treatment($treatment);
          $this->data['items'] = $this->amenitys_model->get_all_items($from_date, $to_date, $treatment);
          foreach ($this->data['items'] as $key => $item) {
            $this->data['items'][$key]['amenit'] = $this->amenitys_model->get_amen($this->data['items'][$key]['id']);
            $this->data['items'][$key]['others'] = $this->amenitys_model->get_other($this->data['items'][$key]['id']);
          }
          $this->data['items_count'] = $this->amenitys_model->get_all_items_count($from_date, $to_date, $treatment);
        }
        $this->load->view('amenitys_detail_report_all', $this->data);
      }
    }

    public function report_state_hotel() {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        $this->load->helper('form');
        $this->load->model('hotels_model');   
        $this->load->model('amenitys_model');
        $this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
        if ($this->input->post('submit')) {
          $state = $this->input->post('state');
          $hotel_id = $this->input->post('hotel_id');
          $this->data['hotel'] = $this->hotels_model->get_by_id($hotel_id);
          $this->data['forms'] = $this->amenitys_model->get_forms($state, $hotel_id);
          foreach ($this->data['forms'] as $key => $amenity) {
            $this->data['forms'][$key]['items'] = $this->amenitys_model->get_itemss($this->data['forms'][$key]['id']);
            foreach ($this->data['forms'][$key]['items'] as $keys => $items) {
              $this->data['forms'][$key]['items'][$keys]['amen'] = $this->amenitys_model->get_ament($this->data['forms'][$key]['items'][$keys]['id']);
            } 
          } 
          $this->data['forms_count'] = $this->amenitys_model->get_forms_count($state, $hotel_id);
        }
        $this->load->view('amenitys_state_report_hotel', $this->data);
      }
    }

    public function report_state_all() {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        $this->load->helper('form');
        $this->load->model('hotels_model');   
        $this->load->model('amenitys_model');
        if ($this->input->post('submit')) {
          $state = $this->input->post('state');
          $this->data['forms'] = $this->amenitys_model->get_all_forms($state);
          foreach ($this->data['forms'] as $key => $amenity) {
            $this->data['forms'][$key]['items'] = $this->amenitys_model->get_itemss($this->data['forms'][$key]['id']);
            foreach ($this->data['forms'][$key]['items'] as $keys => $items) {
              $this->data['forms'][$key]['items'][$keys]['amen'] = $this->amenitys_model->get_ament($this->data['forms'][$key]['items'][$keys]['id']);
            } 
          } 
          $this->data['forms_count'] = $this->amenitys_model->get_all_forms_count($state);
          $count =  array();
          foreach ($this->data['forms'] as $form) {
            $count[] = $form['hotel_name'];
          }
          $this->data['count'] = array_count_values($count);
        }
        $this->load->view('amenitys_state_report_all', $this->data);
      }
    }

    public function report_type_all() {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{      
          $this->load->helper('form');
        $this->load->model('hotels_model');   
        $this->load->model('amenitys_model');
        $this->data['types'] = $this->amenitys_model->get_types();
        if ($this->input->post('submit')) {
          $type = $this->input->post('type');
          $from_date = $this->input->post('from');
          $to_date = $this->input->post('to');
          $this->data['from'] = $from_date;
          $this->data['to'] = $to_date;
          $from_date .=" 00:00:00";
          $to_date .= " 23:59:59";
          $this->data['type'] = $this->amenitys_model->get_type($type);
          $this->data['items'] = $this->amenitys_model->get_all_items_type($from_date, $to_date, $type);
          foreach ($this->data['items'] as $key => $item) {
            $this->data['items'][$key]['amenit'] = $this->amenitys_model->get_amen($this->data['items'][$key]['id']);
            $this->data['items'][$key]['others'] = $this->amenitys_model->get_other($this->data['items'][$key]['id']);
          }
          $this->data['items_count'] = $this->amenitys_model->get_all_items_type_count($from_date, $to_date, $type);
        }
          $this->load->view('amenitys_type_report_all', $this->data);
      }
    }

    public function report_refl_all() {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{      
          $this->load->helper('form');
        $this->load->model('hotels_model');   
        $this->load->model('amenitys_model');
        if ($this->input->post('submit')) {
          $from_date = $this->input->post('from');
          $to_date = $this->input->post('to');
          $this->data['from'] = $from_date;
          $this->data['to'] = $to_date;
          $from_date .=" 00:00:00";
          $to_date .= " 23:59:59";
          $this->data['items'] = $this->amenitys_model->get_all_items_refl($from_date, $to_date);
          foreach ($this->data['items'] as $key => $item) {
            $this->data['items'][$key]['amenit'] = $this->amenitys_model->get_amen($this->data['items'][$key]['id']);
            $this->data['items'][$key]['others'] = $this->amenitys_model->get_other($this->data['items'][$key]['id']);
          }
          $this->data['items_count'] = $this->amenitys_model->get_all_items_refl_count($from_date, $to_date);
        }
          $this->load->view('amenitys_refl_report_all', $this->data);
      }
    }

  }

?>