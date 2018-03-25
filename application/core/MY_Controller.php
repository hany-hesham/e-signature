<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

    class MY_Controller extends CI_Controller {

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
                $this->data['chairman'] = $this->tank_auth->is_chairman();
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
                $this->load->model('chairman_approval_model');
                $this->load->model('hotels_model');
                $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
                $hotels = array();
                foreach ($user_hotels as $hotel) {
                    $hotels[] = $hotel['id'];
                }
                array_push($hotels, 0);
                $status = $this->input->post('states_id');
                $counter = 0;
                if ($status == 0) {
                    $states = $this->chairman_approval_model->get_states();
                    $forms = array();
                    foreach ($states as $state) {
                        $stat = $this->chairman_approval_model->get_state($state['id']);
                        $forma = $this->chairman_approval_model->chairman_approval($stat['database'], $this->data['role_id'], $hotels);
                        foreach ($forma as $key => $form) {
                            $forma[$key]['state'] = $stat;
                            array_push($forms, $forma[$key]);
                            $counter++;
                        }
                    }
                }else{
                    $stat = $this->chairman_approval_model->get_state($status);
                    $forms = $this->chairman_approval_model->chairman_approval($stat['database'], $this->data['role_id'], $hotels);
                    foreach ($forms as $key => $form) {
                        $forms[$key]['state'] = $stat;
                        $counter++;
                    }
                }
                $this->data['forms'] = $forms;
                if ($status != 0) {
                    $this->data['state'] = $this->chairman_approval_model->get_state($status);
                }
                $this->data['states'] = $this->chairman_approval_model->get_states();
                $this->data['counter'] = $counter;
            }
            $this->load->library('logger');
        }

    }

?>