<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

    class form extends CI_Controller {
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

        public function submit_after() {
    		    if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
                if ($this->input->post('submit')) {
                    $this->load->library('form_validation');
                    $this->load->library('email');
                    $assumed_id = $this->input->post('assumed_id');    
                    $this->form_validation->set_rules('hotel_id','Hotel Name','trim|required');
                    if ($this->form_validation->run() == TRUE) {
                        $this->load->model('form_model');
                        $this->load->model('users_model');  
                        $form_data = array(
                            'user_id' => $this->data['user_id'],
                            'hotel_id' => $this->input->post('hotel_id'),
                            'cnf' => $this->input->post('cnf'),
                            'referance' => $this->input->post('referance'),
                            'arrival' => $this->input->post('arrival'),
                            'departure' => $this->input->post('departure'),
                            'address' => $this->input->post('address'),
                            'comment' => $this->input->post('comment'),
                            'postcode' => $this->input->post('postcode'),
                            'email' => $this->input->post('email'),
                            'operator_id' => $this->input->post('operator_id'),
                            'type' => $this->input->post('type'),
                            'incident' => $this->input->post('incident'),
                            'comment1' => $this->input->post('comment1'),
                            'complaints' => $this->input->post('complaints'),
                            'comment2' => $this->input->post('comment2'),
                            'doctor' => $this->input->post('doctor'),
                            'comment3' => $this->input->post('comment3'),
                            'first_notice ' => $this->input->post('first_notice'),
                            'reserve' => $this->input->post('reserve'),
                            'solicitor' => $this->input->post('solicitor'),
                            'solicitor_name' => $this->input->post('solicitor_name'),
                            'letter' => $this->input->post('letter'),
                            'medical' => $this->input->post('medical'),
                            'photographs' => $this->input->post('photographs'),
                            'Other' => $this->input->post('Other'),
                            'responded' => $this->input->post('responded'),
                            'notified' => $this->input->post('notified'),
                            'insurers' => $this->input->post('insurers'),
                            'date_issued' => $this->input->post('date_issued'),
                            'amount' => $this->input->post('amount'),
                            'settlement' => $this->input->post('settlement'),
                            'decision' => $this->input->post('decision'),
                            'decline' => $this->input->post('decline'),
                            'notified1' => $this->input->post('notified1'),
                            'insurers1' => $this->input->post('insurers1'),
                            'issued' => $this->input->post('issued'),
                            'detail' => $this->input->post('detail'),
                            'issued1' => $this->input->post('issued1'),
                            'detail1' => $this->input->post('detail1'),
                            'issued2' => $this->input->post('issued2'),
                            'detail2' => $this->input->post('detail2'),
                            'issued3' => $this->input->post('issued3'),
                            'detail3' => $this->input->post('detail3'),
                            'issued4' => $this->input->post('issued4'),
                            'detail4' => $this->input->post('detail4'),
                            'received' => $this->input->post('received'),
                            'amount1' => $this->input->post('amount1'),
                            'text' => $this->input->post('text'),
                            'received1' => $this->input->post('received1'),
                            'amount2' => $this->input->post('amount2'),
                            'text1' => $this->input->post('text1'),
                            'received2' => $this->input->post('received2'),
                            'amount3' => $this->input->post('amount3'),
                            'text2' => $this->input->post('text2'),
                            'received3' => $this->input->post('received3'),
                            'amount4' => $this->input->post('amount4'),
                            'text3' => $this->input->post('text3'),
                            'received4' => $this->input->post('received4'),
                            'amount5' => $this->input->post('amount5'),
                            'text4' => $this->input->post('text4'),
                            'notified2' => $this->input->post('notified2'),
                            'insurers2' => $this->input->post('insurers2'),
                            'closed' => $this->input->post('closed'),
                            'recovery' => $this->input->post('recovery'),
                            'supporting ' => $this->input->post('supporting'),
                            'settlement_date' => $this->input->post('settlement_date'),
                            'agreed' => $this->input->post('agreed'),
                            'notified3' => $this->input->post('notified3'),
                            'insurers3' => $this->input->post('insurers3'),
                            'confirmed' => $this->input->post('confirmed'),
                            'confirmed_text' => $this->input->post('confirmed_text'),
                            'unconfirmed' => $this->input->post('unconfirmed'),
                            'unconfirmed_text' => $this->input->post('unconfirmed_text'),
                            'accident' => $this->input->post('accident'),
                            'accident_text' => $this->input->post('accident_text'),
                            'other1' => $this->input->post('other1'),
                            'other_text' => $this->input->post('other_text')
                        );
                        $fm_id = $this->form_model->create_form_after($form_data);
                        if ($fm_id) {
                            $this->load->model('form_model');
                            $this->form_model->update_after_files($assumed_id,$fm_id);
                            $this->new_log($this->data['user_id'], "New", "Legal Claims", $fm_id, json_encode($form_data, TRUE), "User Created New Legal Claim");
                        } else {
                            die("ERROR");
                        }
                        redirect('/form/after_stage/'.$fm_id);
                    }
                }   
                try {
                    $this->load->helper('form');
                    $this->load->model('form_model');
                    $this->load->model('hotels_model');
                    $this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
                    $this->data['operators'] = $this->form_model->getall_operator();
                    if ($this->input->post('submit')) {
	                    $this->load->model('form_model');
                        $this->data['assumed_id'] = mt_rand("1048575","10485751048575");
	                    $this->data['uploads'] = $this->form_model->getby_fille_after($this->data['assumed_id'], 1);
	                    $this->data['uploads1'] = $this->form_model->getby_fille_after($this->data['assumed_id'], 2);
	                    $this->data['uploads2'] = $this->form_model->getby_fille_after($this->data['assumed_id'], 3);
	                    $this->data['uploads3'] = $this->form_model->getby_fille_after($this->data['assumed_id'], 4);
	                    $this->data['uploads4'] = $this->form_model->getby_fille_after($this->data['assumed_id'], 5);
	                    $this->data['uploads5'] = $this->form_model->getby_fille_after($this->data['assumed_id'], 6);
	                } else {
                        $this->data['assumed_id'] = mt_rand("1048575","10485751048575");
	                    $this->data['uploads'] = array();
	                    $this->data['uploads1'] = array();
	                    $this->data['uploads2'] = array();
	                    $this->data['uploads3'] = array();
	                    $this->data['uploads4'] = array();
	                    $this->data['uploads5'] = array();
	                }
                    $this->load->view('form_after_add_new',$this->data);
                }catch( Exception $e) {
                    show_error($e->getMessage()." _ ". $e->getTraceAsString());
                }
            }else{
                redirect('/unknown');
            }
        }

        public function new_log($user_id, $location, $target, $target_id, $data, $action){
            $this->load->model('form_log_model');
            $log_data = array(
                'user_id' => $user_id,
                'location' => $location,
                'target' => $target,
                'target_id' => $target_id,
                'data' => $data,
                'action' => $action
            );
            $this->form_log_model->new_log($log_data);
        }

        public function after_stage($fm_id) {
            $this->load->model('form_model');
            $this->data['form'] = $this->form_model->get_form_after($fm_id);
            if ($this->data['form']['state_id'] == 0) {
              	$this->form_model->after_update_state($fm_id, 1);
              	redirect('/form/after_stage/'.$fm_id);
            } elseif ($this->data['form']['state_id'] == 1) {
                $this->notify_after($fm_id);
            }elseif ($this->data['form']['state_id'] == 3){
                $this->notify_edit_after($fm_id);
            }
        }
        
        public function notify_after($fm_id) {
            $this->load->model('form_model');
            $this->load->model('users_model');
            $this->data['form'] = $this->form_model->get_form_after($fm_id);
            $signes = $this->form_model->after_getby_verbal();
            $users = array();
            foreach ($signes as $signe){
                if ($signe['user_id'] != 30) {
    	            $users = $this->users_model->getby_criteria($signe['role'], $this->data['form']['hotel_id']);
    	            foreach($users as $user){
                      	$name = $user['fullname'];
                      	$mail = $user['email'];
                      	$this->load->library('email');
                        $this->load->helper('url');
                        $fm_url = base_url().'form/view_after/'.$fm_id;
                        $this->email->from('e-signature@sunrise-resorts.com');
                        $this->email->to($mail);
                        $this->email->subject("Legal Claims Form No. #{$fm_id}");
                        $this->email->message("Dear {$name},
                        	<br/>
                            <br/>
                            Legal Claims Form No. #{$fm_id} has been created, Please use the link below:
                            <br/>
                            <a href='{$fm_url}' target='_blank'>{$fm_url}</a>
                            <br/>
                        "); 
                        $mail_result = $this->email->send();
                    }
                }
            }
            redirect('form/view_after/'.$fm_id);
        }

        public function notify_edit_after($fm_id) {
            $this->load->model('form_model');
            $this->load->model('users_model');
            $this->data['form'] = $this->form_model->get_form_after($fm_id);
            $signes = $this->form_model->after_getby_verbal();
            $users = array();
            foreach ($signes as $signe){
                if ($signe['user_id'] != 30) {
                    $users = $this->users_model->getby_criteria($signe['role'], $this->data['form']['hotel_id']);
                    foreach($users as $user){
                        if ($user['id'] != 30) {
                          	$name = $user['fullname'];
                          	$mail = $user['email'];
                          	$this->load->library('email');
                            $this->load->helper('url');
                            $fm_url = base_url().'form/view_after/'.$fm_id;
                            $this->email->from('e-signature@sunrise-resorts.com');
                            $this->email->to($mail);
                            $this->email->subject("Legal Claims Form No. #{$fm_id}");
                            $this->email->message("Dear {$name},
                            	<br/>
                                <br/>
                                Legal Claims Form No. #{$fm_id} has been Edited, Please use the link below:
                                <br/>
                                <a href='{$fm_url}' target='_blank'>{$fm_url}</a>
                                <br/>
                            "); 
                            $mail_result = $this->email->send();
                        }
                    }
                }
            }
            redirect('form/view_after/'.$fm_id);
        }

        public function view_after($fm_id) {
    		    if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
                $this->load->model('form_model');
                $this->load->model('form_log_model');
                $this->data['form'] = $this->form_model->get_form_after($fm_id);
                $this->data['form_new'] = $this->form_model->get_new_form_after($fm_id);
                $this->data['log'] = $this->form_log_model->get_log($fm_id, "Legal Claims");
                //die(print_r($this->data['log']));
                $this->data['getcomment'] = $this->form_model->getcomment_after($fm_id);
                $this->data['uploads'] = $this->form_model->getby_fille_after($fm_id, 1);
                $this->data['uploads1'] = $this->form_model->getby_fille_after($fm_id, 2);
                $this->data['uploads2'] = $this->form_model->getby_fille_after($fm_id, 3);
                $this->data['uploads3'] = $this->form_model->getby_fille_after($fm_id, 4);
                $this->data['uploads4'] = $this->form_model->getby_fille_after($fm_id, 5);
                $this->data['uploads5'] = $this->form_model->getby_fille_after($fm_id, 6);
                $this->load->view('form_after_view', $this->data);
            }else{
              redirect('/unknown');
            }
        }

        public function edit_after($fm_id) {
    		    if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
                if ($this->input->post('submit')) {
                    $this->load->library('form_validation');
                    $this->load->library('email');
                    $this->form_validation->set_rules('hotel_id','Hotel Name','trim|required');
                    if ($this->form_validation->run() == TRUE) {
                        $this->load->model('form_model');
                        $this->load->model('users_model');  
                        $this->load->model('hotels_model');  
                        $form_data = array(
                            'new_user_id' => $this->data['user_id'],
                            'hotel_id' => $this->input->post('hotel_id'),
                            'cnf' => $this->input->post('cnf'),
                            'referance' => $this->input->post('referance'),
                            'arrival' => $this->input->post('arrival'),
                            'departure' => $this->input->post('departure'),
                            'address' => $this->input->post('address'),
                            'comment' => $this->input->post('comment'),
                            'postcode' => $this->input->post('postcode'),
                            'email' => $this->input->post('email'),
                            'operator_id' => $this->input->post('operator_id'),
                            'type' => $this->input->post('type'),
                            'incident' => $this->input->post('incident'),
                            'comment1' => $this->input->post('comment1'),
                            'complaints' => $this->input->post('complaints'),
                            'comment2' => $this->input->post('comment2'),
                            'doctor' => $this->input->post('doctor'),
                            'comment3' => $this->input->post('comment3'),
                            'first_notice ' => $this->input->post('first_notice'),
                            'reserve' => $this->input->post('reserve'),
                            'solicitor' => $this->input->post('solicitor'),
                            'solicitor_name' => $this->input->post('solicitor_name'),
                            'letter' => $this->input->post('letter'),
                            'medical' => $this->input->post('medical'),
                            'photographs' => $this->input->post('photographs'),
                            'Other' => $this->input->post('Other'),
                            'responded' => $this->input->post('responded'),
                            'notified' => $this->input->post('notified'),
                            'insurers' => $this->input->post('insurers'),
                            'date_issued' => $this->input->post('date_issued'),
                            'amount' => $this->input->post('amount'),
                            'settlement' => $this->input->post('settlement'),
                            'decision' => $this->input->post('decision'),
                            'decline' => $this->input->post('decline'),
                            'notified1' => $this->input->post('notified1'),
                            'insurers1' => $this->input->post('insurers1'),
                            'issued' => $this->input->post('issued'),
                            'detail' => $this->input->post('detail'),
                            'issued1' => $this->input->post('issued1'),
                            'detail1' => $this->input->post('detail1'),
                            'issued2' => $this->input->post('issued2'),
                            'detail2' => $this->input->post('detail2'),
                            'issued3' => $this->input->post('issued3'),
                            'detail3' => $this->input->post('detail3'),
                            'issued4' => $this->input->post('issued4'),
                            'detail4' => $this->input->post('detail4'),
                            'received' => $this->input->post('received'),
                            'amount1' => $this->input->post('amount1'),
                            'text' => $this->input->post('text'),
                            'received1' => $this->input->post('received1'),
                            'amount2' => $this->input->post('amount2'),
                            'text1' => $this->input->post('text1'),
                            'received2' => $this->input->post('received2'),
                            'amount3' => $this->input->post('amount3'),
                            'text2' => $this->input->post('text2'),
                            'received3' => $this->input->post('received3'),
                            'amount4' => $this->input->post('amount4'),
                            'text3' => $this->input->post('text3'),
                            'received4' => $this->input->post('received4'),
                            'amount5' => $this->input->post('amount5'),
                            'text4' => $this->input->post('text4'),
                            'notified2' => $this->input->post('notified2'),
                            'insurers2' => $this->input->post('insurers2'),
                            'closed' => $this->input->post('closed'),
                            'recovery' => $this->input->post('recovery'),
                            'supporting ' => $this->input->post('supporting'),
                            'settlement_date' => $this->input->post('settlement_date'),
                            'agreed' => $this->input->post('agreed'),
                            'notified3' => $this->input->post('notified3'),
                            'insurers3' => $this->input->post('insurers3'),
                            'confirmed' => $this->input->post('confirmed'),
                            'confirmed_text' => $this->input->post('confirmed_text'),
                            'unconfirmed' => $this->input->post('unconfirmed'),
                            'unconfirmed_text' => $this->input->post('unconfirmed_text'),
                            'accident' => $this->input->post('accident'),
                            'accident_text' => $this->input->post('accident_text'),
                            'other1' => $this->input->post('other1'),
                            'other_text' => $this->input->post('other_text')
                        );
                        $this->data['form'] = $this->form_model->get_form_after($fm_id);
                        $hotel = $this->hotels_model->get_by_id($form_data['hotel_id']);   
                        $operator = $this->form_model->get_operator_by_id($form_data['operator_id']);                        
                        if ($this->data['form']['hotel_id'] != $form_data['hotel_id']) {
                            $data = array(
                                'old' => $this->data['form']['hotel_name'],
                                'new' => $hotel['name']
                            );
                            $this->new_log($this->data['user_id'], "hotel_id", "Legal Claims", $fm_id, json_encode($data, TRUE), "Hotel Has Been Changed");
                        }
                        if ($this->data['form']['cnf'] != $form_data['cnf']) {
                            $data = array(
                                'old' => $this->data['form']['cnf'],
                                'new' => $form_data['cnf']
                            );
                            $this->new_log($this->data['user_id'], "cnf", "Legal Claims", $fm_id, json_encode($data, TRUE), "Name of CNF Has Been Changed");
                        }
                        if ($this->data['form']['referance'] != $form_data['referance']) {
                            $data = array(
                                'old' => $this->data['form']['referance'],
                                'new' => $form_data['referance']
                            );
                            $this->new_log($this->data['user_id'], "referance", "Legal Claims", $fm_id, json_encode($data, TRUE), "Booking Referance Has Been Changed");
                        }
                        if ($this->data['form']['arrival'] != $form_data['arrival']) {
                            $data = array(
                                'old' => $this->data['form']['arrival'],
                                'new' => $form_data['arrival']
                            );
                            $this->new_log($this->data['user_id'], "arrival", "Legal Claims", $fm_id, json_encode($data, TRUE), "Arrival Date Has Been Changed");
                        }
                        if ($this->data['form']['departure'] != $form_data['departure']) {
                            $data = array(
                                'old' => $this->data['form']['departure'],
                                'new' => $form_data['departure']
                            );
                            $this->new_log($this->data['user_id'], "departure", "Legal Claims", $fm_id, json_encode($data, TRUE), "Departure Date Has Been Changed");
                        }
                        if ($this->data['form']['address'] != $form_data['address']) {
                            $data = array(
                                'old' => $this->data['form']['address'],
                                'new' => $form_data['address']
                            );
                            $this->new_log($this->data['user_id'], "address", "Legal Claims", $fm_id, json_encode($data, TRUE), "Address Has Been Changed");
                        }
                        if ($this->data['form']['comment'] != $form_data['comment']) {
                            $data = array(
                                'old' => $this->data['form']['comment'],
                                'new' => $form_data['comment']
                            );
                            $this->new_log($this->data['user_id'], "comment", "Legal Claims", $fm_id, json_encode($data, TRUE), "Comment Has Been Changed");
                        }
                        if ($this->data['form']['postcode'] != $form_data['postcode']) {
                            $data = array(
                                'old' => $this->data['form']['postcode'],
                                'new' => $form_data['postcode']
                            );
                            $this->new_log($this->data['user_id'], "postcode", "Legal Claims", $fm_id, json_encode($data, TRUE), "Postcode Has Been Changed");
                        }
                        if ($this->data['form']['email'] != $form_data['email']) {
                            $data = array(
                                'old' => $this->data['form']['email'],
                                'new' => $form_data['email']
                            );
                            $this->new_log($this->data['user_id'], "email", "Legal Claims", $fm_id, json_encode($data, TRUE), "Email Has Been Changed");
                        }
                        if ($this->data['form']['operator_id'] != $form_data['operator_id']) {
                            $data = array(
                                'old' => $this->data['form']['operator_name'],
                                'new' => $operator['name']
                            );
                            $this->new_log($this->data['user_id'], "operator_id", "Legal Claims", $fm_id, json_encode($data, TRUE), "Operator Has Been Changed");
                        }
                        if ($this->data['form']['type'] != $form_data['type']) {
                            $data = array(
                                'old' => $this->data['form']['type'],
                                'new' => $form_data['type']
                            );
                            $this->new_log($this->data['user_id'], "type", "Legal Claims", $fm_id, json_encode($data, TRUE), "Type Has Been Changed");
                        }
                        if ($this->data['form']['incident'] != $form_data['incident']) {
                            $data = array(
                                'old' => $this->data['form']['incident'],
                                'new' => $form_data['incident']
                            );
                            $this->new_log($this->data['user_id'], "incident", "Legal Claims", $fm_id, json_encode($data, TRUE), "Incident Has Been Changed");
                        }
                        if ($this->data['form']['comment1'] != $form_data['comment1']) {
                            $data = array(
                                'old' => $this->data['form']['comment1'],
                                'new' => $form_data['comment1']
                            );
                            $this->new_log($this->data['user_id'], "comment1", "Legal Claims", $fm_id, json_encode($data, TRUE), "Comment Has Been Changed");
                        }
                        if ($this->data['form']['complaints'] != $form_data['complaints']) {
                            $data = array(
                                'old' => $this->data['form']['complaints'],
                                'new' => $form_data['complaints']
                            );
                            $this->new_log($this->data['user_id'], "complaints", "Legal Claims", $fm_id, json_encode($data, TRUE), "Complaints Has Been Changed");
                        }
                        if ($this->data['form']['comment2'] != $form_data['comment2']) {
                            $data = array(
                                'old' => $this->data['form']['comment2'],
                                'new' => $form_data['comment2']
                            );
                            $this->new_log($this->data['user_id'], "comment2", "Legal Claims", $fm_id, json_encode($data, TRUE), "Comment Has Been Changed");
                        }
                        if ($this->data['form']['doctor'] != $form_data['doctor']) {
                            $data = array(
                                'old' => $this->data['form']['doctor'],
                                'new' => $form_data['doctor']
                            );
                            $this->new_log($this->data['user_id'], "doctor", "Legal Claims", $fm_id, json_encode($data, TRUE), "Doctor Has Been Changed");
                        }
                        if ($this->data['form']['comment3'] != $form_data['comment3']) {
                            $data = array(
                                'old' => $this->data['form']['comment3'],
                                'new' => $form_data['comment3']
                            );
                            $this->new_log($this->data['user_id'], "comment3", "Legal Claims", $fm_id, json_encode($data, TRUE), "Comment Has Been Changed");
                        }
                        if ($this->data['form']['first_notice'] != $form_data['first_notice']) {
                            $data = array(
                                'old' => $this->data['form']['first_notice'],
                                'new' => $form_data['first_notice']
                            );
                            $this->new_log($this->data['user_id'], "first_notice", "Legal Claims", $fm_id, json_encode($data, TRUE), "First Notice Has Been Changed");
                        }
                        if ($this->data['form']['reserve'] != $form_data['reserve']) {
                            $data = array(
                                'old' => $this->data['form']['reserve'],
                                'new' => $form_data['reserve']
                            );
                            $this->new_log($this->data['user_id'], "reserve", "Legal Claims", $fm_id, json_encode($data, TRUE), "Reserve Has Been Changed");
                        }
                        if ($this->data['form']['solicitor'] != $form_data['solicitor']) {
                            $data = array(
                                'old' => $this->data['form']['solicitor'],
                                'new' => $form_data['solicitor']
                            );
                            $this->new_log($this->data['user_id'], "solicitor", "Legal Claims", $fm_id, json_encode($data, TRUE), "Solicitor Has Been Changed");
                        }
                        if ($this->data['form']['solicitor_name'] != $form_data['solicitor_name']) {
                            $data = array(
                                'old' => $this->data['form']['solicitor_name'],
                                'new' => $form_data['solicitor_name']
                            );
                            $this->new_log($this->data['user_id'], "solicitor_name", "Legal Claims", $fm_id, json_encode($data, TRUE), "Solicitor Name Has Been Changed");
                        }
                        if ($this->data['form']['letter'] != $form_data['letter']) {
                            $data = array(
                                'old' => $this->data['form']['letter'],
                                'new' => $form_data['letter']
                            );
                            $this->new_log($this->data['user_id'], "letter", "Legal Claims", $fm_id, json_encode($data, TRUE), "Letter Has Been Changed");
                        }
                        if ($this->data['form']['medical'] != $form_data['medical']) {
                            $data = array(
                                'old' => $this->data['form']['medical'],
                                'new' => $form_data['medical']
                            );
                            $this->new_log($this->data['user_id'], "medical", "Legal Claims", $fm_id, json_encode($data, TRUE), "Medical Has Been Changed");
                        }
                        if ($this->data['form']['photographs'] != $form_data['photographs']) {
                            $data = array(
                                'old' => $this->data['form']['photographs'],
                                'new' => $form_data['photographs']
                            );
                            $this->new_log($this->data['user_id'], "photographs", "Legal Claims", $fm_id, json_encode($data, TRUE), "Photographs Has Been Changed");
                        }
                        if ($this->data['form']['Other'] != $form_data['Other']) {
                            $data = array(
                                'old' => $this->data['form']['Other'],
                                'new' => $form_data['Other']
                            );
                            $this->new_log($this->data['user_id'], "Other", "Legal Claims", $fm_id, json_encode($data, TRUE), "Other Has Been Changed");
                        }
                        if ($this->data['form']['responded'] != $form_data['responded']) {
                            $data = array(
                                'old' => $this->data['form']['responded'],
                                'new' => $form_data['responded']
                            );
                            $this->new_log($this->data['user_id'], "responded", "Legal Claims", $fm_id, json_encode($data, TRUE), "Responded Has Been Changed");
                        }
                        if ($this->data['form']['notified'] != $form_data['notified']) {
                            $data = array(
                                'old' => $this->data['form']['notified'],
                                'new' => $form_data['notified']
                            );
                            $this->new_log($this->data['user_id'], "notified", "Legal Claims", $fm_id, json_encode($data, TRUE), "Notified Has Been Changed");
                        }
                        if ($this->data['form']['insurers'] != $form_data['insurers']) {
                            $data = array(
                                'old' => $this->data['form']['insurers'],
                                'new' => $form_data['insurers']
                            );
                            $this->new_log($this->data['user_id'], "insurers", "Legal Claims", $fm_id, json_encode($data, TRUE), "Insurers Has Been Changed");
                        }
                        if ($this->data['form']['date_issued'] != $form_data['date_issued']) {
                            $data = array(
                                'old' => $this->data['form']['date_issued'],
                                'new' => $form_data['date_issued']
                            );
                            $this->new_log($this->data['user_id'], "date_issued", "Legal Claims", $fm_id, json_encode($data, TRUE), "Date Issued Has Been Changed");
                        }
                        if ($this->data['form']['amount'] != $form_data['amount']) {
                            $data = array(
                                'old' => $this->data['form']['amount'],
                                'new' => $form_data['amount']
                            );
                            $this->new_log($this->data['user_id'], "amount", "Legal Claims", $fm_id, json_encode($data, TRUE), "Amount Has Been Changed");
                        }
                        if ($this->data['form']['settlement'] != $form_data['settlement']) {
                            $data = array(
                                'old' => $this->data['form']['settlement'],
                                'new' => $form_data['settlement']
                            );
                            $this->new_log($this->data['user_id'], "settlement", "Legal Claims", $fm_id, json_encode($data, TRUE), "Settlement Has Been Changed");
                        }
                        if ($this->data['form']['decision'] != $form_data['decision']) {
                            $data = array(
                                'old' => $this->data['form']['decision'],
                                'new' => $form_data['decision']
                            );
                            $this->new_log($this->data['user_id'], "decision", "Legal Claims", $fm_id, json_encode($data, TRUE), "Decision Has Been Changed");
                        }
                        if ($this->data['form']['decline'] != $form_data['decline']) {
                            $data = array(
                                'old' => $this->data['form']['decline'],
                                'new' => $form_data['decline']
                            );
                            $this->new_log($this->data['user_id'], "decline", "Legal Claims", $fm_id, json_encode($data, TRUE), "Decline Has Been Changed");
                        }
                        if ($this->data['form']['notified1'] != $form_data['notified1']) {
                            $data = array(
                                'old' => $this->data['form']['notified1'],
                                'new' => $form_data['notified1']
                            );
                            $this->new_log($this->data['user_id'], "notified1", "Legal Claims", $fm_id, json_encode($data, TRUE), "Notified Has Been Changed");
                        }
                        if ($this->data['form']['insurers1'] != $form_data['insurers1']) {
                            $data = array(
                                'old' => $this->data['form']['insurers1'],
                                'new' => $form_data['insurers1']
                            );
                            $this->new_log($this->data['user_id'], "insurers1", "Legal Claims", $fm_id, json_encode($data, TRUE), "Insurers Has Been Changed");
                        }
                        if ($this->data['form']['issued'] != $form_data['issued']) {
                            $data = array(
                                'old' => $this->data['form']['issued'],
                                'new' => $form_data['issued']
                            );
                            $this->new_log($this->data['user_id'], "issued", "Legal Claims", $fm_id, json_encode($data, TRUE), "Issued Has Been Changed");
                        }
                        if ($this->data['form']['detail'] != $form_data['detail']) {
                            $data = array(
                                'old' => $this->data['form']['detail'],
                                'new' => $form_data['detail']
                            );
                            $this->new_log($this->data['user_id'], "detail", "Legal Claims", $fm_id, json_encode($data, TRUE), "Detail Has Been Changed");
                        }
                        if ($this->data['form']['issued1'] != $form_data['issued1']) {
                            $data = array(
                                'old' => $this->data['form']['issued1'],
                                'new' => $form_data['issued1']
                            );
                            $this->new_log($this->data['user_id'], "issued1", "Legal Claims", $fm_id, json_encode($data, TRUE), "Issued Has Been Changed");
                        }
                        if ($this->data['form']['detail1'] != $form_data['detail1']) {
                            $data = array(
                                'old' => $this->data['form']['detail1'],
                                'new' => $form_data['detail1']
                            );
                            $this->new_log($this->data['user_id'], "detail1", "Legal Claims", $fm_id, json_encode($data, TRUE), "Detail Has Been Changed");
                        }
                        if ($this->data['form']['issued2'] != $form_data['issued2']) {
                            $data = array(
                                'old' => $this->data['form']['issued2'],
                                'new' => $form_data['issued2']
                            );
                            $this->new_log($this->data['user_id'], "issued2", "Legal Claims", $fm_id, json_encode($data, TRUE), "Issued Has Been Changed");
                        }
                        if ($this->data['form']['detail2'] != $form_data['detail2']) {
                            $data = array(
                                'old' => $this->data['form']['detail2'],
                                'new' => $form_data['detail2']
                            );
                            $this->new_log($this->data['user_id'], "detail2", "Legal Claims", $fm_id, json_encode($data, TRUE), "Detail Has Been Changed");
                        }
                        if ($this->data['form']['issued3'] != $form_data['issued3']) {
                            $data = array(
                                'old' => $this->data['form']['issued3'],
                                'new' => $form_data['issued3']
                            );
                            $this->new_log($this->data['user_id'], "issued3", "Legal Claims", $fm_id, json_encode($data, TRUE), "Issued Has Been Changed");
                        }
                        if ($this->data['form']['detail3'] != $form_data['detail3']) {
                            $data = array(
                                'old' => $this->data['form']['detail3'],
                                'new' => $form_data['detail3']
                            );
                            $this->new_log($this->data['user_id'], "detail3", "Legal Claims", $fm_id, json_encode($data, TRUE), "Detail Has Been Changed");
                        }
                        if ($this->data['form']['issued4'] != $form_data['issued4']) {
                            $data = array(
                                'old' => $this->data['form']['issued4'],
                                'new' => $form_data['issued4']
                            );
                            $this->new_log($this->data['user_id'], "issued4", "Legal Claims", $fm_id, json_encode($data, TRUE), "Issued Has Been Changed");
                        }
                        if ($this->data['form']['detail4'] != $form_data['detail4']) {
                            $data = array(
                                'old' => $this->data['form']['detail4'],
                                'new' => $form_data['detail4']
                            );
                            $this->new_log($this->data['user_id'], "detail4", "Legal Claims", $fm_id, json_encode($data, TRUE), "Detail Has Been Changed");
                        }
                        if ($this->data['form']['received'] != $form_data['received']) {
                            $data = array(
                                'old' => $this->data['form']['received'],
                                'new' => $form_data['received']
                            );
                            $this->new_log($this->data['user_id'], "received", "Legal Claims", $fm_id, json_encode($data, TRUE), "Received Has Been Changed");
                        }
                        if ($this->data['form']['amount1'] != $form_data['amount1']) {
                            $data = array(
                                'old' => $this->data['form']['amount1'],
                                'new' => $form_data['amount1']
                            );
                            $this->new_log($this->data['user_id'], "amount1", "Legal Claims", $fm_id, json_encode($data, TRUE), "Amount Has Been Changed");
                        }
                        if ($this->data['form']['text'] != $form_data['text']) {
                            $data = array(
                                'old' => $this->data['form']['text'],
                                'new' => $form_data['text']
                            );
                            $this->new_log($this->data['user_id'], "text", "Legal Claims", $fm_id, json_encode($data, TRUE), "Text Has Been Changed");
                        }
                        if ($this->data['form']['received1'] != $form_data['received1']) {
                            $data = array(
                                'old' => $this->data['form']['received1'],
                                'new' => $form_data['received1']
                            );
                            $this->new_log($this->data['user_id'], "received1", "Legal Claims", $fm_id, json_encode($data, TRUE), "Received Has Been Changed");
                        }
                        if ($this->data['form']['amount2'] != $form_data['amount2']) {
                            $data = array(
                                'old' => $this->data['form']['amount2'],
                                'new' => $form_data['amount2']
                            );
                            $this->new_log($this->data['user_id'], "amount2", "Legal Claims", $fm_id, json_encode($data, TRUE), "Amount Has Been Changed");
                        }
                        if ($this->data['form']['text1'] != $form_data['text1']) {
                            $data = array(
                                'old' => $this->data['form']['text1'],
                                'new' => $form_data['text1']
                            );
                            $this->new_log($this->data['user_id'], "text1", "Legal Claims", $fm_id, json_encode($data, TRUE), "Text Has Been Changed");
                        }
                        if ($this->data['form']['received2'] != $form_data['received2']) {
                            $data = array(
                                'old' => $this->data['form']['received2'],
                                'new' => $form_data['received2']
                            );
                            $this->new_log($this->data['user_id'], "received2", "Legal Claims", $fm_id, json_encode($data, TRUE), "Received Has Been Changed");
                        }
                        if ($this->data['form']['amount3'] != $form_data['amount3']) {
                            $data = array(
                                'old' => $this->data['form']['amount3'],
                                'new' => $form_data['amount3']
                            );
                            $this->new_log($this->data['user_id'], "amount3", "Legal Claims", $fm_id, json_encode($data, TRUE), "Amount Has Been Changed");
                        }
                        if ($this->data['form']['text2'] != $form_data['text2']) {
                            $data = array(
                                'old' => $this->data['form']['text2'],
                                'new' => $form_data['text2']
                            );
                            $this->new_log($this->data['user_id'], "text2", "Legal Claims", $fm_id, json_encode($data, TRUE), "Text Has Been Changed");
                        }
                        if ($this->data['form']['received3'] != $form_data['received3']) {
                            $data = array(
                                'old' => $this->data['form']['received3'],
                                'new' => $form_data['received3']
                            );
                            $this->new_log($this->data['user_id'], "received3", "Legal Claims", $fm_id, json_encode($data, TRUE), "Received Has Been Changed");
                        }
                        if ($this->data['form']['amount4'] != $form_data['amount4']) {
                            $data = array(
                                'old' => $this->data['form']['amount4'],
                                'new' => $form_data['amount4']
                            );
                            $this->new_log($this->data['user_id'], "amount4", "Legal Claims", $fm_id, json_encode($data, TRUE), "Amount Has Been Changed");
                        }
                        if ($this->data['form']['text3'] != $form_data['text3']) {
                            $data = array(
                                'old' => $this->data['form']['text3'],
                                'new' => $form_data['text3']
                            );
                            $this->new_log($this->data['user_id'], "text3", "Legal Claims", $fm_id, json_encode($data, TRUE), "Text Has Been Changed");
                        }
                        if ($this->data['form']['received4'] != $form_data['received4']) {
                            $data = array(
                                'old' => $this->data['form']['received4'],
                                'new' => $form_data['received4']
                            );
                            $this->new_log($this->data['user_id'], "received4", "Legal Claims", $fm_id, json_encode($data, TRUE), "Received Has Been Changed");
                        }
                        if ($this->data['form']['amount5'] != $form_data['amount5']) {
                            $data = array(
                                'old' => $this->data['form']['amount5'],
                                'new' => $form_data['amount5']
                            );
                            $this->new_log($this->data['user_id'], "amount5", "Legal Claims", $fm_id, json_encode($data, TRUE), "Amount Has Been Changed");
                        }
                        if ($this->data['form']['text4'] != $form_data['text4']) {
                            $data = array(
                                'old' => $this->data['form']['text4'],
                                'new' => $form_data['text4']
                            );
                            $this->new_log($this->data['user_id'], "text4", "Legal Claims", $fm_id, json_encode($data, TRUE), "Text Has Been Changed");
                        }
                        if ($this->data['form']['notified2'] != $form_data['notified2']) {
                            $data = array(
                                'old' => $this->data['form']['notified2'],
                                'new' => $form_data['notified2']
                            );
                            $this->new_log($this->data['user_id'], "notified2", "Legal Claims", $fm_id, json_encode($data, TRUE), "Notified Has Been Changed");
                        }
                        if ($this->data['form']['insurers2'] != $form_data['insurers2']) {
                            $data = array(
                                'old' => $this->data['form']['insurers2'],
                                'new' => $form_data['insurers2']
                            );
                            $this->new_log($this->data['user_id'], "insurers2", "Legal Claims", $fm_id, json_encode($data, TRUE), "Insurers Has Been Changed");
                        }
                        if ($this->data['form']['closed'] != $form_data['closed']) {
                            $data = array(
                                'old' => $this->data['form']['closed'],
                                'new' => $form_data['closed']
                            );
                            $this->new_log($this->data['user_id'], "closed", "Legal Claims", $fm_id, json_encode($data, TRUE), "Closed Has Been Changed");
                        }
                        if ($this->data['form']['recovery'] != $form_data['recovery']) {
                            $data = array(
                                'old' => $this->data['form']['recovery'],
                                'new' => $form_data['recovery']
                            );
                            $this->new_log($this->data['user_id'], "recovery", "Legal Claims", $fm_id, json_encode($data, TRUE), "Recovery Has Been Changed");
                        }
                        if ($this->data['form']['supporting'] != $form_data['supporting']) {
                            $data = array(
                                'old' => $this->data['form']['supporting'],
                                'new' => $form_data['supporting']
                            );
                            $this->new_log($this->data['user_id'], "supporting", "Legal Claims", $fm_id, json_encode($data, TRUE), "Supporting Has Been Changed");
                        }
                        if ($this->data['form']['settlement_date'] != $form_data['settlement_date']) {
                            $data = array(
                                'old' => $this->data['form']['settlement_date'],
                                'new' => $form_data['settlement_date']
                            );
                            $this->new_log($this->data['user_id'], "settlement_date", "Legal Claims", $fm_id, json_encode($data, TRUE), "Settlement Date Has Been Changed");
                        }
                        if ($this->data['form']['agreed'] != $form_data['agreed']) {
                            $data = array(
                                'old' => $this->data['form']['agreed'],
                                'new' => $form_data['agreed']
                            );
                            $this->new_log($this->data['user_id'], "agreed", "Legal Claims", $fm_id, json_encode($data, TRUE), "Agreed Has Been Changed");
                        }
                        if ($this->data['form']['notified3'] != $form_data['notified3']) {
                            $data = array(
                                'old' => $this->data['form']['notified3'],
                                'new' => $form_data['notified3']
                            );
                            $this->new_log($this->data['user_id'], "notified3", "Legal Claims", $fm_id, json_encode($data, TRUE), "Notified Has Been Changed");
                        }
                        if ($this->data['form']['insurers3'] != $form_data['insurers3']) {
                            $data = array(
                                'old' => $this->data['form']['insurers3'],
                                'new' => $form_data['insurers3']
                            );
                            $this->new_log($this->data['user_id'], "insurers3", "Legal Claims", $fm_id, json_encode($data, TRUE), "Insurers Has Been Changed");
                        }
                        if ($this->data['form']['confirmed'] != $form_data['confirmed']) {
                            $data = array(
                                'old' => $this->data['form']['confirmed'],
                                'new' => $form_data['confirmed']
                            );
                            $this->new_log($this->data['user_id'], "confirmed", "Legal Claims", $fm_id, json_encode($data, TRUE), "Confirmed Has Been Changed");
                        }
                        if ($this->data['form']['confirmed_text'] != $form_data['confirmed_text']) {
                            $data = array(
                                'old' => $this->data['form']['confirmed_text'],
                                'new' => $form_data['confirmed_text']
                            );
                            $this->new_log($this->data['user_id'], "confirmed_text", "Legal Claims", $fm_id, json_encode($data, TRUE), "Confirmed Text Has Been Changed");
                        }
                        if ($this->data['form']['unconfirmed'] != $form_data['unconfirmed']) {
                            $data = array(
                                'old' => $this->data['form']['unconfirmed'],
                                'new' => $form_data['unconfirmed']
                            );
                            $this->new_log($this->data['user_id'], "unconfirmed", "Legal Claims", $fm_id, json_encode($data, TRUE), "Unconfirmed Has Been Changed");
                        }
                        if ($this->data['form']['unconfirmed_text'] != $form_data['unconfirmed_text']) {
                            $data = array(
                                'old' => $this->data['form']['unconfirmed_text'],
                                'new' => $form_data['unconfirmed_text']
                            );
                            $this->new_log($this->data['user_id'], "unconfirmed_text", "Legal Claims", $fm_id, json_encode($data, TRUE), "Unconfirmed Text Has Been Changed");
                        }
                        if ($this->data['form']['accident'] != $form_data['accident']) {
                            $data = array(
                                'old' => $this->data['form']['accident'],
                                'new' => $form_data['accident']
                            );
                            $this->new_log($this->data['user_id'], "accident", "Legal Claims", $fm_id, json_encode($data, TRUE), "Accident Has Been Changed");
                        }
                        if ($this->data['form']['accident_text'] != $form_data['accident_text']) {
                            $data = array(
                                'old' => $this->data['form']['accident_text'],
                                'new' => $form_data['accident_text']
                            );
                            $this->new_log($this->data['user_id'], "accident_text", "Legal Claims", $fm_id, json_encode($data, TRUE), "Accident Text Has Been Changed");
                        }
                        if ($this->data['form']['other1'] != $form_data['other1']) {
                            $data = array(
                                'old' => $this->data['form']['other1'],
                                'new' => $form_data['other1']
                            );
                            $this->new_log($this->data['user_id'], "other1", "Legal Claims", $fm_id, json_encode($data, TRUE), "Other Has Been Changed");
                        }
                        if ($this->data['form']['other_text'] != $form_data['other_text']) {
                            $data = array(
                                'old' => $this->data['form']['other_text'],
                                'new' => $form_data['other_text']
                            );
                            $this->new_log($this->data['user_id'], "other_text", "Legal Claims", $fm_id, json_encode($data, TRUE), "Other Text Has Been Changed");
                        }
                        $this->form_model->update_form_after($form_data, $fm_id);
                        $this->form_model->after_update_state($fm_id, 3);
                        redirect('/form/after_stage/'.$fm_id);
                    }
                }   
                try {
                    $this->load->helper('form');
                    $this->load->model('form_model');
                    $this->load->model('hotels_model');
                    $this->data['form'] = $this->form_model->get_form_after($fm_id);
                    $this->data['uploads'] = $this->form_model->getby_fille_after($fm_id, 1);
                    $this->data['uploads1'] = $this->form_model->getby_fille_after($fm_id, 2);
                    $this->data['uploads2'] = $this->form_model->getby_fille_after($fm_id, 3);
                    $this->data['uploads3'] = $this->form_model->getby_fille_after($fm_id, 4);
                    $this->data['uploads4'] = $this->form_model->getby_fille_after($fm_id, 5);
                    $this->data['uploads5'] = $this->form_model->getby_fille_after($fm_id, 6);
                    $this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
                    $this->data['operators'] = $this->form_model->getall_operator();
                    $this->load->view('form_after_edit',$this->data);
                }catch( Exception $e) {
                    show_error($e->getMessage()." _ ". $e->getTraceAsString());
                }
            }else{
                redirect('/unknown');
            }
        }

        public function make_offer_after($fm_id, $type) {
    		$file_name = $this->do_upload("upload");
    		if (!$file_name) {
      			die(json_encode($this->data['error']));
    		} else {
     			$this->load->model("form_model");
      			$this->form_model->add_after($fm_id, $file_name, $this->data['user_id'], $type);
                $data = array(
                    'file' => $file_name
                );
                $this->new_log($this->data['user_id'], "File", "Legal Claims", $fm_id, json_encode($data, TRUE), "New File Has Been Uploaded");
      			die("{}");
    		}
  		}

  		public function make_offer_after1($fm_id, $type) {
    		$file_name = $this->do_upload("upload1");
    		if (!$file_name) {
      			die(json_encode($this->data['error']));
    		} else {
     			$this->load->model("form_model");
      			$this->form_model->add_after($fm_id, $file_name, $this->data['user_id'], $type);
                $data = array(
                    'file' => $file_name
                );
                $this->new_log($this->data['user_id'], "File1", "Legal Claims", $fm_id, json_encode($data, TRUE), "New File Has Been Uploaded");
      			die("{}");
    		}
  		}

  		public function make_offer_after2($fm_id, $type) {
    		$file_name = $this->do_upload("upload2");
    		if (!$file_name) {
      			die(json_encode($this->data['error']));
    		} else {
     			$this->load->model("form_model");
      			$this->form_model->add_after($fm_id, $file_name, $this->data['user_id'], $type);
                $data = array(
                    'file' => $file_name
                );
                $this->new_log($this->data['user_id'], "File2", "Legal Claims", $fm_id, json_encode($data, TRUE), "New File Has Been Uploaded");
      			die("{}");
    		}
  		}

  		public function make_offer_after3($fm_id, $type) {
    		$file_name = $this->do_upload("upload3");
    		if (!$file_name) {
      			die(json_encode($this->data['error']));
    		} else {
     			$this->load->model("form_model");
      			$this->form_model->add_after($fm_id, $file_name, $this->data['user_id'], $type);
                $data = array(
                    'file' => $file_name
                );
                $this->new_log($this->data['user_id'], "File3", "Legal Claims", $fm_id, json_encode($data, TRUE), "New File Has Been Uploaded");
      			die("{}");
    		}
  		}

  		public function make_offer_after4($fm_id, $type) {
    		$file_name = $this->do_upload("upload4");
    		if (!$file_name) {
      			die(json_encode($this->data['error']));
    		} else {
     			$this->load->model("form_model");
      			$this->form_model->add_after($fm_id, $file_name, $this->data['user_id'], $type);
                $data = array(
                    'file' => $file_name
                );
                $this->new_log($this->data['user_id'], "File4", "Legal Claims", $fm_id, json_encode($data, TRUE), "New File Has Been Uploaded");
      			die("{}");
    		}
  		}

  		public function make_offer_after5($fm_id, $type) {
    		$file_name = $this->do_upload("upload5");
    		if (!$file_name) {
      			die(json_encode($this->data['error']));
    		} else {
     			$this->load->model("form_model");
      			$this->form_model->add_after($fm_id, $file_name, $this->data['user_id'], $type);
                $data = array(
                    'file' => $file_name
                );
                $this->new_log($this->data['user_id'], "File5", "Legal Claims", $fm_id, json_encode($data, TRUE), "New File Has Been Uploaded");
      			die("{}");
    		}
  		}

  		public function remove_offer_after($fm_id, $id) {
    		$file_name = $_POST['key'];
    		if (!$id) {
      			die(json_encode($this->data['error']));
    		} else {
      			$this->load->model("form_model");
                $fille = $this->form_model->get_fille_after($id);
                $data = array(
                    'file' => $fille['name'],
                    'user' => $fille['user_name']
                );
                $this->new_log($this->data['user_id'], "Files", "Legal Claims", $fm_id, json_encode($data, TRUE), "File Has Been Deleted");
      			$this->form_model->remove_after($id);
      			die("{}");
    		}
  		}

        public function remove_offer_after1($fm_id, $id) {
            $file_name = $_POST['key'];
            if (!$id) {
                die(json_encode($this->data['error']));
            } else {
                $this->load->model("form_model");
                $fille = $this->form_model->get_fille_after($id);
                $data = array(
                    'file' => $fille['name'],
                    'user' => $fille['user_name']
                );
                $this->new_log($this->data['user_id'], "Files1", "Legal Claims", $fm_id, json_encode($data, TRUE), "File Has Been Deleted");
                $this->form_model->remove_after($id);
                die("{}");
            }
        }

        public function remove_offer_after2($fm_id, $id) {
            $file_name = $_POST['key'];
            if (!$id) {
                die(json_encode($this->data['error']));
            } else {
                $this->load->model("form_model");
                $fille = $this->form_model->get_fille_after($id);
                $data = array(
                    'file' => $fille['name'],
                    'user' => $fille['user_name']
                );
                $this->new_log($this->data['user_id'], "Files2", "Legal Claims", $fm_id, json_encode($data, TRUE), "File Has Been Deleted");
                $this->form_model->remove_after($id);
                die("{}");
            }
        }

        public function remove_offer_after3($fm_id, $id) {
            $file_name = $_POST['key'];
            if (!$id) {
                die(json_encode($this->data['error']));
            } else {
                $this->load->model("form_model");
                $fille = $this->form_model->get_fille_after($id);
                $data = array(
                    'file' => $fille['name'],
                    'user' => $fille['user_name']
                );
                $this->new_log($this->data['user_id'], "Files3", "Legal Claims", $fm_id, json_encode($data, TRUE), "File Has Been Deleted");
                $this->form_model->remove_after($id);
                die("{}");
            }
        }

        public function remove_offer_after4($fm_id, $id) {
            $file_name = $_POST['key'];
            if (!$id) {
                die(json_encode($this->data['error']));
            } else {
                $this->load->model("form_model");
                $fille = $this->form_model->get_fille_after($id);
                $data = array(
                    'file' => $fille['name'],
                    'user' => $fille['user_name']
                );
                $this->new_log($this->data['user_id'], "Files4", "Legal Claims", $fm_id, json_encode($data, TRUE), "File Has Been Deleted");
                $this->form_model->remove_after($id);
                die("{}");
            }
        }

        public function remove_offer_after5($fm_id, $id) {
            $file_name = $_POST['key'];
            if (!$id) {
                die(json_encode($this->data['error']));
            } else {
                $this->load->model("form_model");
                $fille = $this->form_model->get_fille_after($id);
                $data = array(
                    'file' => $fille['name'],
                    'user' => $fille['user_name']
                );
                $this->new_log($this->data['user_id'], "Files5", "Legal Claims", $fm_id, json_encode($data, TRUE), "File Has Been Deleted");
                $this->form_model->remove_after($id);
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

        public function index_after() {
    		    if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
                $this->load->model('hotels_model');
                $this->load->model('form_model');
                $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
                $hotels = array();
                foreach ($user_hotels as $hotel) {
                  	$hotels[] = $hotel['id'];
                }    
                $this->data['form'] = $this->form_model->view_after($hotels);
                $this->data['hotels'] = $user_hotels;
                $this->data['operators'] = $this->form_model->getall_operator();
                $this->load->view('form_after_index', $this->data);
            }else{
             	redirect('/unknown');
            }
        }

        public function comment_after($fm_id){
            if ($this->input->post('submit')) {
              	$this->load->library('form_validation');
              	$this->form_validation->set_rules('comment','Comment','trim|required');
                if ($this->form_validation->run() == TRUE) {
                  	$comment = $this->input->post('comment'); 
                  	$this->load->model('form_model');
                  	$comment_data = array(
	                    'user_id' => $this->data['user_id'],
	                    'fm_id' => $fm_id,
	                    'comment' => $comment
                  	);
                	$this->form_model->insertcomment_after($comment_data);
              	}
              	redirect('/form/view_after/'.$fm_id);
            }
        }


         public function submit_in_uk() {
                if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
                if ($this->input->post('submit')) {
                    $this->load->library('form_validation');
                    $this->load->library('email');
                    $assumed_id1 = $this->input->post('assumed_id1');    
                    $this->form_validation->set_rules('hotel_id','Hotel Name','trim|required');
                    if ($this->form_validation->run() == TRUE) {
                        $this->load->model('form_model');
                        $this->load->model('users_model');  
                        $form_data = array(
                            'user_id' => $this->data['user_id'],
                            'hotel_id' => $this->input->post('hotel_id'),
                            'irf' => $this->input->post('irf'),
                            'guest' => $this->input->post('guest'),
                            'referance' => $this->input->post('referance'),
                            'room' => $this->input->post('room'),
                            'address' => $this->input->post('address'),
                            'comment' => $this->input->post('comment'),
                            'postcode' => $this->input->post('postcode'),
                            'email' => $this->input->post('email'),
                            'arrival' => $this->input->post('arrival'),
                            'departure' => $this->input->post('departure'),                      
                            'operator_id' => $this->input->post('operator_id'),
                            'type' => $this->input->post('type'),
                            'address1' => $this->input->post('address1'),
                            'telephone' => $this->input->post('telephone'),
                            'email1' => $this->input->post('email1'),
                            'reporting' => $this->input->post('reporting'),
                            'reported' => $this->input->post('reported'),
                            'accident' => $this->input->post('accident'),
                            'comment1 ' => $this->input->post('comment1'),
                            'affected' => $this->input->post('affected'),
                            'names' => $this->input->post('names'),
                            'date' => $this->input->post('date'),
                            'symptoms' => $this->input->post('symptoms'),
                            'visited' => $this->input->post('visited'),
                            'treatment' => $this->input->post('treatment'),
                            'medication' => $this->input->post('medication'),
                            'duration' => $this->input->post('duration'),
                            'location' => $this->input->post('location'),
                            'cause' => $this->input->post('cause'),
                            'witness' => $this->input->post('witness'),
                            'investigation' => $this->input->post('investigation'),
                            'not_related' => $this->input->post('not_related'),
                            'injury' => $this->input->post('injury'),
                            'cctv' => $this->input->post('cctv'),
                            'photographs' => $this->input->post('photographs'),
                            'detail' => $this->input->post('detail'),
                            'action' => $this->input->post('action'),
                            'prevent' => $this->input->post('prevent'),
                            'report' => $this->input->post('report'),
                            'reports' => $this->input->post('reports'),
                            'indemnity' => $this->input->post('indemnity'),
                            'informed' => $this->input->post('informed'),
                            'comments' => $this->input->post('comments'),
                            'added' => $this->input->post('added'),
                            'compensation' => $this->input->post('compensation'),
                            'value' => $this->input->post('value'),
                            'accepted' => $this->input->post('accepted'),
                            'given' => $this->input->post('given'),
                            'follow' => $this->input->post('follow'),
                            'insurance' => $this->input->post('insurance'),
                            'informed1' => $this->input->post('informed1'),
                            'responded' => $this->input->post('responded'),
                            'witness1' => $this->input->post('witness1'),
                            'paperwork' => $this->input->post('paperwork'),
                            'cristal' => $this->input->post('cristal'),
                            'audits' => $this->input->post('audits'),
                            'logs' => $this->input->post('logs'),
                            'maintenance' => $this->input->post('maintenance'),
                            'documents' => $this->input->post('documents'),
                            'other' => $this->input->post('other')
                        );
                        $fm_id = $this->form_model->create_form_in_uk($form_data);
                        if ($fm_id) {
                            $this->load->model('form_model');
                            $this->form_model->update_in_uk_files($assumed_id1,$fm_id);
                            $this->new_log($this->data['user_id'], "New", "In House UK", $fm_id, json_encode($form_data, TRUE), "User Created New In House UK");
                        } else {
                            die("ERROR");
                        }
                        redirect('/form/in_uk_stage/'.$fm_id);
                    }
                }   
                try {
                    $this->load->helper('form');
                    $this->load->model('form_model');
                    $this->load->model('hotels_model');
                    $this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
                    $this->data['operators'] = $this->form_model->getall_operator();
                    if ($this->input->post('submit')) {
                        $this->load->model('form_model');
                        $this->data['assumed_id1'] = mt_rand("1048575","10485751048575");
                        $this->data['uploads'] = $this->form_model->getby_fille_in_uk($this->data['assumed_id1'], 1);
                        $this->data['uploads1'] = $this->form_model->getby_fille_in_uk($this->data['assumed_id1'], 2);
                        $this->data['uploads2'] = $this->form_model->getby_fille_in_uk($this->data['assumed_id1'], 3);
                        $this->data['uploads3'] = $this->form_model->getby_fille_in_uk($this->data['assumed_id1'], 4);
                        $this->data['uploads4'] = $this->form_model->getby_fille_in_uk($this->data['assumed_id1'], 5);
                        $this->data['uploads5'] = $this->form_model->getby_fille_in_uk($this->data['assumed_id1'], 6);
                        $this->data['uploads6'] = $this->form_model->getby_fille_in_uk($this->data['assumed_id1'], 7);
                        $this->data['uploads7'] = $this->form_model->getby_fille_in_uk($this->data['assumed_id1'], 8);
                        $this->data['uploads8'] = $this->form_model->getby_fille_in_uk($this->data['assumed_id1'], 9);
                        $this->data['uploads9'] = $this->form_model->getby_fille_in_uk($this->data['assumed_id1'], 10);
                        $this->data['uploads10'] = $this->form_model->getby_fille_in_uk($this->data['assumed_id1'], 11);
                        $this->data['uploads11'] = $this->form_model->getby_fille_in_uk($this->data['assumed_id1'], 12);
                        $this->data['uploads12'] = $this->form_model->getby_fille_in_uk($this->data['assumed_id1'], 13);
                        $this->data['uploads13'] = $this->form_model->getby_fille_in_uk($this->data['assumed_id1'], 14);
                    } else {
                        $this->data['assumed_id1'] = mt_rand("1048575","10485751048575");
                        $this->data['uploads'] = array();
                        $this->data['uploads1'] = array();
                        $this->data['uploads2'] = array();
                        $this->data['uploads3'] = array();
                        $this->data['uploads4'] = array();
                        $this->data['uploads5'] = array();
                        $this->data['uploads6'] = array();
                        $this->data['uploads7'] = array();
                        $this->data['uploads8'] = array();
                        $this->data['uploads9'] = array();
                        $this->data['uploads10'] = array();
                        $this->data['uploads11'] = array();
                        $this->data['uploads12'] = array();
                        $this->data['uploads13'] = array();
                    }
                    $this->load->view('form_in_uk_add_new',$this->data);
                }catch( Exception $e) {
                    show_error($e->getMessage()." _ ". $e->getTraceAsString());
                }
            }else{
                redirect('/unknown');
            }
        }

        public function in_uk_stage($fm_id) {
            $this->load->model('form_model');
            $this->data['form'] = $this->form_model->get_form_in_uk($fm_id);
            if ($this->data['form']['state_id'] == 0) {
                $this->form_model->in_uk_update_state($fm_id, 1);
                redirect('/form/in_uk_stage/'.$fm_id);
            } elseif ($this->data['form']['state_id'] == 1) {
                $this->notify_in_uk($fm_id);
            }elseif ($this->data['form']['state_id'] == 3){
                $this->notify_edit_in_uk($fm_id);
            }
        }
        
        public function notify_in_uk($fm_id) {
            $this->load->model('form_model');
            $this->load->model('users_model');
            $this->data['form'] = $this->form_model->get_form_in_uk($fm_id);
            $signes = $this->form_model->in_uk_getby_verbal();
            $users = array();
            foreach ($signes as $signe){
                if ($signe['user_id'] != 30) {
                    $users = $this->users_model->getby_criteria($signe['role'], $this->data['form']['hotel_id']);
                    foreach($users as $user){
                        $name = $user['fullname'];
                        $mail = $user['email'];
                        $this->load->library('email');
                        $this->load->helper('url');
                        $fm_url = base_url().'form/view_in_uk/'.$fm_id;
                        $this->email->from('e-signature@sunrise-resorts.com');
                        $this->email->to($mail);
                        $this->email->subject("In House Incident Report-UK Form No. #{$fm_id}");
                        $this->email->message("Dear {$name},
                            <br/>
                            <br/>
                            In House Incident Report-UK Form No. #{$fm_id} has been created, Please use the link below:
                            <br/>
                            <a href='{$fm_url}' target='_blank'>{$fm_url}</a>
                            <br/>
                        "); 
                        $mail_result = $this->email->send();
                    }
                }
            }
            redirect('form/view_in_uk/'.$fm_id);
        }

        public function notify_edit_in_uk($fm_id) {
            $this->load->model('form_model');
            $this->load->model('users_model');
            $this->data['form'] = $this->form_model->get_form_in_uk($fm_id);
            $signes = $this->form_model->in_uk_getby_verbal();
            $users = array();
            foreach ($signes as $signe){
                $users = $this->users_model->getby_criteria($signe['role'], $this->data['form']['hotel_id']);
                foreach($users as $user){
                    if ($user['id'] != 30) {
                    $name = $user['fullname'];
                    $mail = $user['email'];
                    $this->load->library('email');
                    $this->load->helper('url');
                    $fm_url = base_url().'form/view_in_uk/'.$fm_id;
                    $this->email->from('e-signature@sunrise-resorts.com');
                    $this->email->to($mail);
                    $this->email->subject("In House Incident Report-UK Form No. #{$fm_id}");
                    $this->email->message("Dear {$name},
                        <br/>
                        <br/>
                        In House Incident Report-UK Form No. #{$fm_id} has been Edited, Please use the link below:
                        <br/>
                        <a href='{$fm_url}' target='_blank'>{$fm_url}</a>
                        <br/>
                    "); 
                    $mail_result = $this->email->send();
                    }
                }
            }
            redirect('form/view_in_uk/'.$fm_id);
        }

        public function view_in_uk($fm_id) {
                if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
                $this->load->model('form_model');
                $this->load->model('form_log_model');
                $illness = $this->form_model->get_illness("1", $fm_id);
                //die(print_r($illness));
                $this->form_model->update_form_in_uk_iln($illness['iln_id'], $fm_id);
                $this->data['form'] = $this->form_model->get_form_in_uk($fm_id);
                $this->data['form_new'] = $this->form_model->get_new_form_in_uk($fm_id);
                $this->data['log'] = $this->form_log_model->get_log($fm_id, "In House UK");
                $this->data['getcomment'] = $this->form_model->getcomment_in_uk($fm_id);
                $this->data['uploads'] = $this->form_model->getby_fille_in_uk($fm_id, 1);
                $this->data['uploads1'] = $this->form_model->getby_fille_in_uk($fm_id, 2);
                $this->data['uploads2'] = $this->form_model->getby_fille_in_uk($fm_id, 3);
                $this->data['uploads3'] = $this->form_model->getby_fille_in_uk($fm_id, 4);
                $this->data['uploads4'] = $this->form_model->getby_fille_in_uk($fm_id, 5);
                $this->data['uploads5'] = $this->form_model->getby_fille_in_uk($fm_id, 6);
                $this->data['uploads6'] = $this->form_model->getby_fille_in_uk($fm_id, 7);
                $this->data['uploads7'] = $this->form_model->getby_fille_in_uk($fm_id, 8);
                $this->data['uploads8'] = $this->form_model->getby_fille_in_uk($fm_id, 9);
                $this->data['uploads9'] = $this->form_model->getby_fille_in_uk($fm_id, 10);
                $this->data['uploads10'] = $this->form_model->getby_fille_in_uk($fm_id, 11);
                $this->data['uploads11'] = $this->form_model->getby_fille_in_uk($fm_id, 12);
                $this->data['uploads12'] = $this->form_model->getby_fille_in_uk($fm_id, 13);
                $this->data['uploads13'] = $this->form_model->getby_fille_in_uk($fm_id, 14);
                $this->load->view('form_in_uk_view', $this->data);
            }else{
              redirect('/unknown');
            }
        }

        public function edit_in_uk($fm_id) {
                if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
                if ($this->input->post('submit')) {
                    $this->load->library('form_validation');
                    $this->load->library('email');
                    $this->form_validation->set_rules('hotel_id','Hotel Name','trim|required');
                    if ($this->form_validation->run() == TRUE) {
                        $this->load->model('form_model');
                        $this->load->model('users_model'); 
                        $this->load->model('hotels_model');                           
                        $form_data = array(
                            'new_user_id' => $this->data['user_id'],
                            'hotel_id' => $this->input->post('hotel_id'),
                            'irf' => $this->input->post('irf'),
                            'guest' => $this->input->post('guest'),
                            'referance' => $this->input->post('referance'),
                            'room' => $this->input->post('room'),
                            'address' => $this->input->post('address'),
                            'comment' => $this->input->post('comment'),
                            'postcode' => $this->input->post('postcode'),
                            'email' => $this->input->post('email'),
                            'arrival' => $this->input->post('arrival'),
                            'departure' => $this->input->post('departure'),                      
                            'operator_id' => $this->input->post('operator_id'),
                            'type' => $this->input->post('type'),
                            'address1' => $this->input->post('address1'),
                            'telephone' => $this->input->post('telephone'),
                            'email1' => $this->input->post('email1'),
                            'reporting' => $this->input->post('reporting'),
                            'reported' => $this->input->post('reported'),
                            'accident' => $this->input->post('accident'),
                            'comment1 ' => $this->input->post('comment1'),
                            'affected' => $this->input->post('affected'),
                            'names' => $this->input->post('names'),
                            'date' => $this->input->post('date'),
                            'symptoms' => $this->input->post('symptoms'),
                            'visited' => $this->input->post('visited'),
                            'treatment' => $this->input->post('treatment'),
                            'medication' => $this->input->post('medication'),
                            'duration' => $this->input->post('duration'),
                            'location' => $this->input->post('location'),
                            'cause' => $this->input->post('cause'),
                            'witness' => $this->input->post('witness'),
                            'investigation' => $this->input->post('investigation'),
                            'not_related' => $this->input->post('not_related'),
                            'injury' => $this->input->post('injury'),
                            'cctv' => $this->input->post('cctv'),
                            'photographs' => $this->input->post('photographs'),
                            'detail' => $this->input->post('detail'),
                            'action' => $this->input->post('action'),
                            'prevent' => $this->input->post('prevent'),
                            'report' => $this->input->post('report'),
                            'reports' => $this->input->post('reports'),
                            'indemnity' => $this->input->post('indemnity'),
                            'informed' => $this->input->post('informed'),
                            'comments' => $this->input->post('comments'),
                            'added' => $this->input->post('added'),
                            'compensation' => $this->input->post('compensation'),
                            'value' => $this->input->post('value'),
                            'accepted' => $this->input->post('accepted'),
                            'given' => $this->input->post('given'),
                            'follow' => $this->input->post('follow'),
                            'insurance' => $this->input->post('insurance'),
                            'informed1' => $this->input->post('informed1'),
                            'responded' => $this->input->post('responded'),
                            'witness1' => $this->input->post('witness1'),
                            'paperwork' => $this->input->post('paperwork'),
                            'cristal' => $this->input->post('cristal'),
                            'audits' => $this->input->post('audits'),
                            'logs' => $this->input->post('logs'),
                            'maintenance' => $this->input->post('maintenance'),
                            'documents' => $this->input->post('documents'),
                            'other' => $this->input->post('other')
                        );
                        $this->data['form'] = $this->form_model->get_form_in_uk($fm_id);
                        $hotel = $this->hotels_model->get_by_id($form_data['hotel_id']); 
                        $operator = $this->form_model->get_operator_by_id($form_data['operator_id']);                        
                        if ($this->data['form']['hotel_id'] != $form_data['hotel_id']) {
                            $data = array(
                                'old' => $this->data['form']['hotel_name'],
                                'new' => $hotel['name']
                            );
                            $this->new_log($this->data['user_id'], "hotel_id", "In House UK", $fm_id, json_encode($data, TRUE), "Hotel Has Been Changed");
                        }
                        if ($this->data['form']['irf'] != $form_data['irf']) {
                            $data = array(
                                'old' => $this->data['form']['irf'],
                                'new' => $form_data['irf']
                            );
                            $this->new_log($this->data['user_id'], "irf", "In House UK", $fm_id, json_encode($data, TRUE), "Name of IRF Has Been Changed");
                        }
                        if ($this->data['form']['guest'] != $form_data['guest']) {
                            $data = array(
                                'old' => $this->data['form']['guest'],
                                'new' => $form_data['guest']
                            );
                            $this->new_log($this->data['user_id'], "guest", "In House UK", $fm_id, json_encode($data, TRUE), "Guest Name Has Been Changed");
                        }
                        if ($this->data['form']['referance'] != $form_data['referance']) {
                            $data = array(
                                'old' => $this->data['form']['referance'],
                                'new' => $form_data['referance']
                            );
                            $this->new_log($this->data['user_id'], "referance", "In House UK", $fm_id, json_encode($data, TRUE), "Booking Referance Has Been Changed");
                        }
                        if ($this->data['form']['room'] != $form_data['room']) {
                            $data = array(
                                'old' => $this->data['form']['room'],
                                'new' => $form_data['room']
                            );
                            $this->new_log($this->data['user_id'], "room", "In House UK", $fm_id, json_encode($data, TRUE), "Room No. Has Been Changed");
                        }
                        if ($this->data['form']['address'] != $form_data['address']) {
                            $data = array(
                                'old' => $this->data['form']['address'],
                                'new' => $form_data['address']
                            );
                            $this->new_log($this->data['user_id'], "address", "In House UK", $fm_id, json_encode($data, TRUE), "Address Has Been Changed");
                        }
                        if ($this->data['form']['comment'] != $form_data['comment']) {
                            $data = array(
                                'old' => $this->data['form']['comment'],
                                'new' => $form_data['comment']
                            );
                            $this->new_log($this->data['user_id'], "comment", "In House UK", $fm_id, json_encode($data, TRUE), "Comment Has Been Changed");
                        }
                        if ($this->data['form']['postcode'] != $form_data['postcode']) {
                            $data = array(
                                'old' => $this->data['form']['postcode'],
                                'new' => $form_data['postcode']
                            );
                            $this->new_log($this->data['user_id'], "postcode", "In House UK", $fm_id, json_encode($data, TRUE), "Postcode Has Been Changed");
                        }
                        if ($this->data['form']['email'] != $form_data['email']) {
                            $data = array(
                                'old' => $this->data['form']['email'],
                                'new' => $form_data['email']
                            );
                            $this->new_log($this->data['user_id'], "email", "In House UK", $fm_id, json_encode($data, TRUE), "Email Has Been Changed");
                        }
                        if ($this->data['form']['arrival'] != $form_data['arrival']) {
                            $data = array(
                                'old' => $this->data['form']['arrival'],
                                'new' => $form_data['arrival']
                            );
                            $this->new_log($this->data['user_id'], "arrival", "In House UK", $fm_id, json_encode($data, TRUE), "Arrival Date Has Been Changed");
                        }
                        if ($this->data['form']['departure'] != $form_data['departure']) {
                            $data = array(
                                'old' => $this->data['form']['departure'],
                                'new' => $form_data['departure']
                            );
                            $this->new_log($this->data['user_id'], "departure", "In House UK", $fm_id, json_encode($data, TRUE), "Departure Date Has Been Changed");
                        }
                        if ($this->data['form']['operator_id'] != $form_data['operator_id']) {
                            $data = array(
                                'old' => $this->data['form']['operator_name'],
                                'new' => $operator['name']
                            );
                            $this->new_log($this->data['user_id'], "operator_id", "In House UK", $fm_id, json_encode($data, TRUE), "Operator Has Been Changed");
                        }
                        if ($this->data['form']['type'] != $form_data['type']) {
                            $data = array(
                                'old' => $this->data['form']['type'],
                                'new' => $form_data['type']
                            );
                            $this->new_log($this->data['user_id'], "type", "In House UK", $fm_id, json_encode($data, TRUE), "Type Has Been Changed");
                        }
                        if ($this->data['form']['address1'] != $form_data['address1']) {
                            $data = array(
                                'old' => $this->data['form']['address1'],
                                'new' => $form_data['address1']
                            );
                            $this->new_log($this->data['user_id'], "address1", "In House UK", $fm_id, json_encode($data, TRUE), "Address Has Been Changed");
                        }
                        if ($this->data['form']['telephone'] != $form_data['telephone']) {
                            $data = array(
                                'old' => $this->data['form']['telephone'],
                                'new' => $form_data['telephone']
                            );
                            $this->new_log($this->data['user_id'], "telephone", "In House UK", $fm_id, json_encode($data, TRUE), "Telephone Has Been Changed");
                        }
                        if ($this->data['form']['email1'] != $form_data['email1']) {
                            $data = array(
                                'old' => $this->data['form']['email1'],
                                'new' => $form_data['email1']
                            );
                            $this->new_log($this->data['user_id'], "email1", "In House UK", $fm_id, json_encode($data, TRUE), "Email Has Been Changed");
                        }
                        if ($this->data['form']['reporting'] != $form_data['reporting']) {
                            $data = array(
                                'old' => $this->data['form']['reporting'],
                                'new' => $form_data['reporting']
                            );
                            $this->new_log($this->data['user_id'], "reporting", "In House UK", $fm_id, json_encode($data, TRUE), "Reporting Has Been Changed");
                        }
                        if ($this->data['form']['reported'] != $form_data['reported']) {
                            $data = array(
                                'old' => $this->data['form']['reported'],
                                'new' => $form_data['reported']
                            );
                            $this->new_log($this->data['user_id'], "reported", "In House UK", $fm_id, json_encode($data, TRUE), "Reported Has Been Changed");
                        }
                        if ($this->data['form']['accident'] != $form_data['accident']) {
                            $data = array(
                                'old' => $this->data['form']['accident'],
                                'new' => $form_data['accident']
                            );
                            $this->new_log($this->data['user_id'], "accident", "In House UK", $fm_id, json_encode($data, TRUE), "Accident Has Been Changed");
                        }
                        if ($this->data['form']['comment1'] != $form_data['comment1']) {
                            $data = array(
                                'old' => $this->data['form']['comment1'],
                                'new' => $form_data['comment1']
                            );
                            $this->new_log($this->data['user_id'], "comment1", "In House UK", $fm_id, json_encode($data, TRUE), "Comment Has Been Changed");
                        }
                        if ($this->data['form']['affected'] != $form_data['affected']) {
                            $data = array(
                                'old' => $this->data['form']['affected'],
                                'new' => $form_data['affected']
                            );
                            $this->new_log($this->data['user_id'], "affected", "In House UK", $fm_id, json_encode($data, TRUE), "Affected Has Been Changed");
                        }
                        if ($this->data['form']['names'] != $form_data['names']) {
                            $data = array(
                                'old' => $this->data['form']['names'],
                                'new' => $form_data['names']
                            );
                            $this->new_log($this->data['user_id'], "names", "In House UK", $fm_id, json_encode($data, TRUE), "Names Has Been Changed");
                        }
                        if ($this->data['form']['date'] != $form_data['date']) {
                            $data = array(
                                'old' => $this->data['form']['date'],
                                'new' => $form_data['date']
                            );
                            $this->new_log($this->data['user_id'], "date", "In House UK", $fm_id, json_encode($data, TRUE), "Date Has Been Changed");
                        }
                        if ($this->data['form']['symptoms'] != $form_data['symptoms']) {
                            $data = array(
                                'old' => $this->data['form']['symptoms'],
                                'new' => $form_data['symptoms']
                            );
                            $this->new_log($this->data['user_id'], "symptoms", "In House UK", $fm_id, json_encode($data, TRUE), "Symptoms Has Been Changed");
                        }
                        if ($this->data['form']['visited'] != $form_data['visited']) {
                            $data = array(
                                'old' => $this->data['form']['visited'],
                                'new' => $form_data['visited']
                            );
                            $this->new_log($this->data['user_id'], "visited", "In House UK", $fm_id, json_encode($data, TRUE), "Visited Has Been Changed");
                        }
                        if ($this->data['form']['treatment'] != $form_data['treatment']) {
                            $data = array(
                                'old' => $this->data['form']['treatment'],
                                'new' => $form_data['treatment']
                            );
                            $this->new_log($this->data['user_id'], "treatment", "In House UK", $fm_id, json_encode($data, TRUE), "Treatment Has Been Changed");
                        }
                        if ($this->data['form']['medication'] != $form_data['medication']) {
                            $data = array(
                                'old' => $this->data['form']['medication'],
                                'new' => $form_data['medication']
                            );
                            $this->new_log($this->data['user_id'], "medication", "In House UK", $fm_id, json_encode($data, TRUE), "Medication Has Been Changed");
                        }
                        if ($this->data['form']['duration'] != $form_data['duration']) {
                            $data = array(
                                'old' => $this->data['form']['duration'],
                                'new' => $form_data['duration']
                            );
                            $this->new_log($this->data['user_id'], "duration", "In House UK", $fm_id, json_encode($data, TRUE), "Duration Has Been Changed");
                        }
                        if ($this->data['form']['location'] != $form_data['location']) {
                            $data = array(
                                'old' => $this->data['form']['location'],
                                'new' => $form_data['location']
                            );
                            $this->new_log($this->data['user_id'], "location", "In House UK", $fm_id, json_encode($data, TRUE), "Location Has Been Changed");
                        }
                        if ($this->data['form']['cause'] != $form_data['cause']) {
                            $data = array(
                                'old' => $this->data['form']['cause'],
                                'new' => $form_data['cause']
                            );
                            $this->new_log($this->data['user_id'], "cause", "In House UK", $fm_id, json_encode($data, TRUE), "Cause Has Been Changed");
                        }
                        if ($this->data['form']['witness'] != $form_data['witness']) {
                            $data = array(
                                'old' => $this->data['form']['witness'],
                                'new' => $form_data['witness']
                            );
                            $this->new_log($this->data['user_id'], "witness", "In House UK", $fm_id, json_encode($data, TRUE), "Witness Has Been Changed");
                        }
                        if ($this->data['form']['investigation'] != $form_data['investigation']) {
                            $data = array(
                                'old' => $this->data['form']['investigation'],
                                'new' => $form_data['investigation']
                            );
                            $this->new_log($this->data['user_id'], "investigation", "In House UK", $fm_id, json_encode($data, TRUE), "Investigation Has Been Changed");
                        }
                        if ($this->data['form']['not_related'] != $form_data['not_related']) {
                            $data = array(
                                'old' => $this->data['form']['not_related'],
                                'new' => $form_data['not_related']
                            );
                            $this->new_log($this->data['user_id'], "not_related", "In House UK", $fm_id, json_encode($data, TRUE), "Related Has Been Changed");
                        }
                        if ($this->data['form']['injury'] != $form_data['injury']) {
                            $data = array(
                                'old' => $this->data['form']['injury'],
                                'new' => $form_data['injury']
                            );
                            $this->new_log($this->data['user_id'], "injury", "In House UK", $fm_id, json_encode($data, TRUE), "Injury Has Been Changed");
                        }
                        if ($this->data['form']['cctv'] != $form_data['cctv']) {
                            $data = array(
                                'old' => $this->data['form']['cctv'],
                                'new' => $form_data['cctv']
                            );
                            $this->new_log($this->data['user_id'], "cctv", "In House UK", $fm_id, json_encode($data, TRUE), "CCTV Has Been Changed");
                        }
                        if ($this->data['form']['photographs'] != $form_data['photographs']) {
                            $data = array(
                                'old' => $this->data['form']['photographs'],
                                'new' => $form_data['photographs']
                            );
                            $this->new_log($this->data['user_id'], "photographs", "In House UK", $fm_id, json_encode($data, TRUE), "Photographs Has Been Changed");
                        }
                        if ($this->data['form']['detail'] != $form_data['detail']) {
                            $data = array(
                                'old' => $this->data['form']['detail'],
                                'new' => $form_data['detail']
                            );
                            $this->new_log($this->data['user_id'], "detail", "In House UK", $fm_id, json_encode($data, TRUE), "Detail Has Been Changed");
                        }
                        if ($this->data['form']['action'] != $form_data['action']) {
                            $data = array(
                                'old' => $this->data['form']['action'],
                                'new' => $form_data['action']
                            );
                            $this->new_log($this->data['user_id'], "action", "In House UK", $fm_id, json_encode($data, TRUE), "Action Has Been Changed");
                        }
                        if ($this->data['form']['prevent'] != $form_data['prevent']) {
                            $data = array(
                                'old' => $this->data['form']['prevent'],
                                'new' => $form_data['prevent']
                            );
                            $this->new_log($this->data['user_id'], "prevent", "In House UK", $fm_id, json_encode($data, TRUE), "Prevent Has Been Changed");
                        }
                        if ($this->data['form']['report'] != $form_data['report']) {
                            $data = array(
                                'old' => $this->data['form']['report'],
                                'new' => $form_data['report']
                            );
                            $this->new_log($this->data['user_id'], "report", "In House UK", $fm_id, json_encode($data, TRUE), "Report Has Been Changed");
                        }
                        if ($this->data['form']['reports'] != $form_data['reports']) {
                            $data = array(
                                'old' => $this->data['form']['reports'],
                                'new' => $form_data['reports']
                            );
                            $this->new_log($this->data['user_id'], "reports", "In House UK", $fm_id, json_encode($data, TRUE), "Reports Has Been Changed");
                        }
                        if ($this->data['form']['indemnity'] != $form_data['indemnity']) {
                            $data = array(
                                'old' => $this->data['form']['indemnity'],
                                'new' => $form_data['indemnity']
                            );
                            $this->new_log($this->data['user_id'], "indemnity", "In House UK", $fm_id, json_encode($data, TRUE), "Indemnity Has Been Changed");
                        }
                        if ($this->data['form']['informed'] != $form_data['informed']) {
                            $data = array(
                                'old' => $this->data['form']['informed'],
                                'new' => $form_data['informed']
                            );
                            $this->new_log($this->data['user_id'], "informed", "In House UK", $fm_id, json_encode($data, TRUE), "Informed Has Been Changed");
                        }
                        if ($this->data['form']['comments'] != $form_data['comments']) {
                            $data = array(
                                'old' => $this->data['form']['comments'],
                                'new' => $form_data['comments']
                            );
                            $this->new_log($this->data['user_id'], "comments", "In House UK", $fm_id, json_encode($data, TRUE), "Comments Has Been Changed");
                        }
                        if ($this->data['form']['added'] != $form_data['added']) {
                            $data = array(
                                'old' => $this->data['form']['added'],
                                'new' => $form_data['added']
                            );
                            $this->new_log($this->data['user_id'], "added", "In House UK", $fm_id, json_encode($data, TRUE), "Added Has Been Changed");
                        }
                        if ($this->data['form']['compensation'] != $form_data['compensation']) {
                            $data = array(
                                'old' => $this->data['form']['compensation'],
                                'new' => $form_data['compensation']
                            );
                            $this->new_log($this->data['user_id'], "compensation", "In House UK", $fm_id, json_encode($data, TRUE), "Compensation Has Been Changed");
                        }
                        if ($this->data['form']['value'] != $form_data['value']) {
                            $data = array(
                                'old' => $this->data['form']['value'],
                                'new' => $form_data['value']
                            );
                            $this->new_log($this->data['user_id'], "value", "In House UK", $fm_id, json_encode($data, TRUE), "Value Has Been Changed");
                        }
                        if ($this->data['form']['text'] != $form_data['text']) {
                            $data = array(
                                'old' => $this->data['form']['text'],
                                'new' => $form_data['text']
                            );
                            $this->new_log($this->data['user_id'], "text", "In House UK", $fm_id, json_encode($data, TRUE), "Text Has Been Changed");
                        }
                        if ($this->data['form']['accepted'] != $form_data['accepted']) {
                            $data = array(
                                'old' => $this->data['form']['accepted'],
                                'new' => $form_data['accepted']
                            );
                            $this->new_log($this->data['user_id'], "accepted", "In House UK", $fm_id, json_encode($data, TRUE), "Accepted Has Been Changed");
                        }
                        if ($this->data['form']['given'] != $form_data['given']) {
                            $data = array(
                                'old' => $this->data['form']['given'],
                                'new' => $form_data['given']
                            );
                            $this->new_log($this->data['user_id'], "given", "In House UK", $fm_id, json_encode($data, TRUE), "Given Has Been Changed");
                        }
                        if ($this->data['form']['follow'] != $form_data['follow']) {
                            $data = array(
                                'old' => $this->data['form']['follow'],
                                'new' => $form_data['follow']
                            );
                            $this->new_log($this->data['user_id'], "follow", "In House UK", $fm_id, json_encode($data, TRUE), "Follow Has Been Changed");
                        }
                        if ($this->data['form']['insurance'] != $form_data['insurance']) {
                            $data = array(
                                'old' => $this->data['form']['insurance'],
                                'new' => $form_data['insurance']
                            );
                            $this->new_log($this->data['user_id'], "insurance", "In House UK", $fm_id, json_encode($data, TRUE), "Insurance Has Been Changed");
                        }
                        if ($this->data['form']['informed1'] != $form_data['informed1']) {
                            $data = array(
                                'old' => $this->data['form']['informed1'],
                                'new' => $form_data['informed1']
                            );
                            $this->new_log($this->data['user_id'], "informed1", "In House UK", $fm_id, json_encode($data, TRUE), "Informed Has Been Changed");
                        }
                        if ($this->data['form']['responded'] != $form_data['responded']) {
                            $data = array(
                                'old' => $this->data['form']['responded'],
                                'new' => $form_data['responded']
                            );
                            $this->new_log($this->data['user_id'], "responded", "In House UK", $fm_id, json_encode($data, TRUE), "Responded Has Been Changed");
                        }
                        if ($this->data['form']['witness1'] != $form_data['witness1']) {
                            $data = array(
                                'old' => $this->data['form']['witness1'],
                                'new' => $form_data['witness1']
                            );
                            $this->new_log($this->data['user_id'], "witness1", "In House UK", $fm_id, json_encode($data, TRUE), "Witness Has Been Changed");
                        }
                        if ($this->data['form']['paperwork'] != $form_data['paperwork']) {
                            $data = array(
                                'old' => $this->data['form']['paperwork'],
                                'new' => $form_data['paperwork']
                            );
                            $this->new_log($this->data['user_id'], "paperwork", "In House UK", $fm_id, json_encode($data, TRUE), "Paperwork Has Been Changed");
                        }
                        if ($this->data['form']['cristal'] != $form_data['cristal']) {
                            $data = array(
                                'old' => $this->data['form']['cristal'],
                                'new' => $form_data['cristal']
                            );
                            $this->new_log($this->data['user_id'], "cristal", "In House UK", $fm_id, json_encode($data, TRUE), "Cristal Has Been Changed");
                        }
                        if ($this->data['form']['audits'] != $form_data['audits']) {
                            $data = array(
                                'old' => $this->data['form']['audits'],
                                'new' => $form_data['audits']
                            );
                            $this->new_log($this->data['user_id'], "audits", "In House UK", $fm_id, json_encode($data, TRUE), "Audits Has Been Changed");
                        }
                        if ($this->data['form']['logs'] != $form_data['logs']) {
                            $data = array(
                                'old' => $this->data['form']['logs'],
                                'new' => $form_data['logs']
                            );
                            $this->new_log($this->data['user_id'], "logs", "In House UK", $fm_id, json_encode($data, TRUE), "Logs Has Been Changed");
                        }
                        if ($this->data['form']['maintenance'] != $form_data['maintenance']) {
                            $data = array(
                                'old' => $this->data['form']['maintenance'],
                                'new' => $form_data['maintenance']
                            );
                            $this->new_log($this->data['user_id'], "maintenance", "In House UK", $fm_id, json_encode($data, TRUE), "Maintenance Has Been Changed");
                        }
                        if ($this->data['form']['documents'] != $form_data['documents']) {
                            $data = array(
                                'old' => $this->data['form']['documents'],
                                'new' => $form_data['documents']
                            );
                            $this->new_log($this->data['user_id'], "documents", "In House UK", $fm_id, json_encode($data, TRUE), "Documents Has Been Changed");
                        }
                        if ($this->data['form']['other'] != $form_data['other']) {
                            $data = array(
                                'old' => $this->data['form']['other'],
                                'new' => $form_data['other']
                            );
                            $this->new_log($this->data['user_id'], "other", "In House UK", $fm_id, json_encode($data, TRUE), "Other Has Been Changed");
                        }
                        $this->form_model->update_form_in_uk($form_data, $fm_id);
                        $this->form_model->in_uk_update_state($fm_id, 3);
                        redirect('/form/in_uk_stage/'.$fm_id);
                    }
                }   
                try {
                    $this->load->helper('form');
                    $this->load->model('form_model');
                    $this->load->model('hotels_model');
                    $this->data['form'] = $this->form_model->get_form_in_uk($fm_id);
                    $this->data['uploads'] = $this->form_model->getby_fille_in_uk($fm_id, 1);
                    $this->data['uploads1'] = $this->form_model->getby_fille_in_uk($fm_id, 2);
                    $this->data['uploads2'] = $this->form_model->getby_fille_in_uk($fm_id, 3);
                    $this->data['uploads3'] = $this->form_model->getby_fille_in_uk($fm_id, 4);
                    $this->data['uploads4'] = $this->form_model->getby_fille_in_uk($fm_id, 5);
                    $this->data['uploads5'] = $this->form_model->getby_fille_in_uk($fm_id, 6);
                    $this->data['uploads6'] = $this->form_model->getby_fille_in_uk($fm_id, 7);
                    $this->data['uploads7'] = $this->form_model->getby_fille_in_uk($fm_id, 8);
                    $this->data['uploads8'] = $this->form_model->getby_fille_in_uk($fm_id, 9);
                    $this->data['uploads9'] = $this->form_model->getby_fille_in_uk($fm_id, 10);
                    $this->data['uploads10'] = $this->form_model->getby_fille_in_uk($fm_id, 11);
                    $this->data['uploads11'] = $this->form_model->getby_fille_in_uk($fm_id, 12);
                    $this->data['uploads12'] = $this->form_model->getby_fille_in_uk($fm_id, 13);
                    $this->data['uploads13'] = $this->form_model->getby_fille_in_uk($fm_id, 14);
                    $this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
                    $this->data['operators'] = $this->form_model->getall_operator();
                    $this->load->view('form_in_uk_edit',$this->data);
                }catch( Exception $e) {
                    show_error($e->getMessage()." _ ". $e->getTraceAsString());
                }
            }else{
                redirect('/unknown');
            }
        }

        public function make_offer_in_uk($fm_id, $type) {
            $file_name = $this->do_upload("upload");
            if (!$file_name) {
                die(json_encode($this->data['error']));
            } else {
                $this->load->model("form_model");
                $this->form_model->add_in_uk($fm_id, $file_name, $this->data['user_id'], $type);
                $data = array(
                    'file' => $file_name
                );
                $this->new_log($this->data['user_id'], "File", "In House UK", $fm_id, json_encode($data, TRUE), "New File Has Been Uploaded");
                die("{}");
            }
        }

        public function make_offer_in_uk1($fm_id, $type) {
            $file_name = $this->do_upload("upload1");
            if (!$file_name) {
                die(json_encode($this->data['error']));
            } else {
                $this->load->model("form_model");
                $this->form_model->add_in_uk($fm_id, $file_name, $this->data['user_id'], $type);
                $data = array(
                    'file' => $file_name
                );
                $this->new_log($this->data['user_id'], "File1", "In House UK", $fm_id, json_encode($data, TRUE), "New File Has Been Uploaded");
                die("{}");
            }
        }

        public function make_offer_in_uk2($fm_id, $type) {
            $file_name = $this->do_upload("upload2");
            if (!$file_name) {
                die(json_encode($this->data['error']));
            } else {
                $this->load->model("form_model");
                $this->form_model->add_in_uk($fm_id, $file_name, $this->data['user_id'], $type);
                $data = array(
                    'file' => $file_name
                );
                $this->new_log($this->data['user_id'], "File2", "In House UK", $fm_id, json_encode($data, TRUE), "New File Has Been Uploaded");
                die("{}");
            }
        }

        public function make_offer_in_uk3($fm_id, $type) {
            $file_name = $this->do_upload("upload3");
            if (!$file_name) {
                die(json_encode($this->data['error']));
            } else {
                $this->load->model("form_model");
                $this->form_model->add_in_uk($fm_id, $file_name, $this->data['user_id'], $type);
                $data = array(
                    'file' => $file_name
                );
                $this->new_log($this->data['user_id'], "File3", "In House UK", $fm_id, json_encode($data, TRUE), "New File Has Been Uploaded");
                die("{}");
            }
        }

        public function make_offer_in_uk4($fm_id, $type) {
            $file_name = $this->do_upload("upload4");
            if (!$file_name) {
                die(json_encode($this->data['error']));
            } else {
                $this->load->model("form_model");
                $this->form_model->add_in_uk($fm_id, $file_name, $this->data['user_id'], $type);
                $data = array(
                    'file' => $file_name
                );
                $this->new_log($this->data['user_id'], "File4", "In House UK", $fm_id, json_encode($data, TRUE), "New File Has Been Uploaded");
                die("{}");
            }
        }

        public function make_offer_in_uk5($fm_id, $type) {
            $file_name = $this->do_upload("upload5");
            if (!$file_name) {
                die(json_encode($this->data['error']));
            } else {
                $this->load->model("form_model");
                $this->form_model->add_in_uk($fm_id, $file_name, $this->data['user_id'], $type);
                $data = array(
                    'file' => $file_name
                );
                $this->new_log($this->data['user_id'], "File5", "In House UK", $fm_id, json_encode($data, TRUE), "New File Has Been Uploaded");
                die("{}");
            }
        }

        public function make_offer_in_uk6($fm_id, $type) {
            $file_name = $this->do_upload("upload6");
            if (!$file_name) {
                die(json_encode($this->data['error']));
            } else {
                $this->load->model("form_model");
                $this->form_model->add_in_uk($fm_id, $file_name, $this->data['user_id'], $type);
                $data = array(
                    'file' => $file_name
                );
                $this->new_log($this->data['user_id'], "File6", "In House UK", $fm_id, json_encode($data, TRUE), "New File Has Been Uploaded");
                die("{}");
            }
        }

        public function make_offer_in_uk7($fm_id, $type) {
            $file_name = $this->do_upload("upload7");
            if (!$file_name) {
                die(json_encode($this->data['error']));
            } else {
                $this->load->model("form_model");
                $this->form_model->add_in_uk($fm_id, $file_name, $this->data['user_id'], $type);
                $data = array(
                    'file' => $file_name
                );
                $this->new_log($this->data['user_id'], "File7", "In House UK", $fm_id, json_encode($data, TRUE), "New File Has Been Uploaded");
                die("{}");
            }
        }

        public function make_offer_in_uk8($fm_id, $type) {
            $file_name = $this->do_upload("upload8");
            if (!$file_name) {
                die(json_encode($this->data['error']));
            } else {
                $this->load->model("form_model");
                $this->form_model->add_in_uk($fm_id, $file_name, $this->data['user_id'], $type);
                $data = array(
                    'file' => $file_name
                );
                $this->new_log($this->data['user_id'], "File8", "In House UK", $fm_id, json_encode($data, TRUE), "New File Has Been Uploaded");
                die("{}");
            }
        }

        public function make_offer_in_uk9($fm_id, $type) {
            $file_name = $this->do_upload("upload9");
            if (!$file_name) {
                die(json_encode($this->data['error']));
            } else {
                $this->load->model("form_model");
                $this->form_model->add_in_uk($fm_id, $file_name, $this->data['user_id'], $type);
                $data = array(
                    'file' => $file_name
                );
                $this->new_log($this->data['user_id'], "File9", "In House UK", $fm_id, json_encode($data, TRUE), "New File Has Been Uploaded");
                die("{}");
            }
        }

        public function make_offer_in_uk10($fm_id, $type) {
            $file_name = $this->do_upload("upload10");
            if (!$file_name) {
                die(json_encode($this->data['error']));
            } else {
                $this->load->model("form_model");
                $this->form_model->add_in_uk($fm_id, $file_name, $this->data['user_id'], $type);
                $data = array(
                    'file' => $file_name
                );
                $this->new_log($this->data['user_id'], "File10", "In House UK", $fm_id, json_encode($data, TRUE), "New File Has Been Uploaded");
                die("{}");
            }
        }

        public function make_offer_in_uk11($fm_id, $type) {
            $file_name = $this->do_upload("upload11");
            if (!$file_name) {
                die(json_encode($this->data['error']));
            } else {
                $this->load->model("form_model");
                $this->form_model->add_in_uk($fm_id, $file_name, $this->data['user_id'], $type);
                $data = array(
                    'file' => $file_name
                );
                $this->new_log($this->data['user_id'], "File11", "In House UK", $fm_id, json_encode($data, TRUE), "New File Has Been Uploaded");
                die("{}");
            }
        }

        public function make_offer_in_uk12($fm_id, $type) {
            $file_name = $this->do_upload("upload12");
            if (!$file_name) {
                die(json_encode($this->data['error']));
            } else {
                $this->load->model("form_model");
                $this->form_model->add_in_uk($fm_id, $file_name, $this->data['user_id'], $type);
                $data = array(
                    'file' => $file_name
                );
                $this->new_log($this->data['user_id'], "File12", "In House UK", $fm_id, json_encode($data, TRUE), "New File Has Been Uploaded");
                die("{}");
            }
        }

        public function make_offer_in_uk13($fm_id, $type) {
            $file_name = $this->do_upload("upload13");
            if (!$file_name) {
                die(json_encode($this->data['error']));
            } else {
                $this->load->model("form_model");
                $this->form_model->add_in_uk($fm_id, $file_name, $this->data['user_id'], $type);
                $data = array(
                    'file' => $file_name
                );
                $this->new_log($this->data['user_id'], "File13", "In House UK", $fm_id, json_encode($data, TRUE), "New File Has Been Uploaded");
                die("{}");
            }
        }

        public function remove_offer_in_uk($fm_id, $id) {
            $file_name = $_POST['key'];
            if (!$id) {
                die(json_encode($this->data['error']));
            } else {
                $this->load->model("form_model");
                $fille = $this->form_model->get_fille_in_uk($id);
                $data = array(
                    'file' => $fille['name'],
                    'user' => $fille['user_name']
                );
                $this->new_log($this->data['user_id'], "Files", "In House UK", $fm_id, json_encode($data, TRUE), "File Has Been Deleted");
                $this->form_model->remove_in_uk($id);
                die("{}");
            }
        }

        public function remove_offer_in_uk1($fm_id, $id) {
            $file_name = $_POST['key'];
            if (!$id) {
                die(json_encode($this->data['error']));
            } else {
                $this->load->model("form_model");
                $this->load->model("form_model");
                $fille = $this->form_model->get_fille_in_uk($id);
                $data = array(
                    'file' => $fille['name'],
                    'user' => $fille['user_name']
                );
                $this->new_log($this->data['user_id'], "Files1", "In House UK", $fm_id, json_encode($data, TRUE), "File Has Been Deleted");
                $this->form_model->remove_in_uk($id);
                die("{}");
            }
        }

        public function remove_offer_in_uk2($fm_id, $id) {
            $file_name = $_POST['key'];
            if (!$id) {
                die(json_encode($this->data['error']));
            } else {
                $this->load->model("form_model");
                $this->load->model("form_model");
                $fille = $this->form_model->get_fille_in_uk($id);
                $data = array(
                    'file' => $fille['name'],
                    'user' => $fille['user_name']
                );
                $this->new_log($this->data['user_id'], "Files2", "In House UK", $fm_id, json_encode($data, TRUE), "File Has Been Deleted");
                $this->form_model->remove_in_uk($id);
                die("{}");
            }
        }

        public function remove_offer_in_uk3($fm_id, $id) {
            $file_name = $_POST['key'];
            if (!$id) {
                die(json_encode($this->data['error']));
            } else {
                $this->load->model("form_model");
                $this->load->model("form_model");
                $fille = $this->form_model->get_fille_in_uk($id);
                $data = array(
                    'file' => $fille['name'],
                    'user' => $fille['user_name']
                );
                $this->new_log($this->data['user_id'], "Files3", "In House UK", $fm_id, json_encode($data, TRUE), "File Has Been Deleted");
                $this->form_model->remove_in_uk($id);
                die("{}");
            }
        }

        public function remove_offer_in_uk4($fm_id, $id) {
            $file_name = $_POST['key'];
            if (!$id) {
                die(json_encode($this->data['error']));
            } else {
                $this->load->model("form_model");
                $this->load->model("form_model");
                $fille = $this->form_model->get_fille_in_uk($id);
                $data = array(
                    'file' => $fille['name'],
                    'user' => $fille['user_name']
                );
                $this->new_log($this->data['user_id'], "Files4", "In House UK", $fm_id, json_encode($data, TRUE), "File Has Been Deleted");
                $this->form_model->remove_in_uk($id);
                die("{}");
            }
        }

        public function remove_offer_in_uk5($fm_id, $id) {
            $file_name = $_POST['key'];
            if (!$id) {
                die(json_encode($this->data['error']));
            } else {
                $this->load->model("form_model");
                $this->load->model("form_model");
                $fille = $this->form_model->get_fille_in_uk($id);
                $data = array(
                    'file' => $fille['name'],
                    'user' => $fille['user_name']
                );
                $this->new_log($this->data['user_id'], "Files5", "In House UK", $fm_id, json_encode($data, TRUE), "File Has Been Deleted");
                $this->form_model->remove_in_uk($id);
                die("{}");
            }
        }

        public function remove_offer_in_uk6($fm_id, $id) {
            $file_name = $_POST['key'];
            if (!$id) {
                die(json_encode($this->data['error']));
            } else {
                $this->load->model("form_model");
                $this->load->model("form_model");
                $fille = $this->form_model->get_fille_in_uk($id);
                $data = array(
                    'file' => $fille['name'],
                    'user' => $fille['user_name']
                );
                $this->new_log($this->data['user_id'], "Files6", "In House UK", $fm_id, json_encode($data, TRUE), "File Has Been Deleted");
                $this->form_model->remove_in_uk($id);
                die("{}");
            }
        }

        public function remove_offer_in_uk7($fm_id, $id) {
            $file_name = $_POST['key'];
            if (!$id) {
                die(json_encode($this->data['error']));
            } else {
                $this->load->model("form_model");
                $this->load->model("form_model");
                $fille = $this->form_model->get_fille_in_uk($id);
                $data = array(
                    'file' => $fille['name'],
                    'user' => $fille['user_name']
                );
                $this->new_log($this->data['user_id'], "Files7", "In House UK", $fm_id, json_encode($data, TRUE), "File Has Been Deleted");
                $this->form_model->remove_in_uk($id);
                die("{}");
            }
        }

        public function remove_offer_in_uk8($fm_id, $id) {
            $file_name = $_POST['key'];
            if (!$id) {
                die(json_encode($this->data['error']));
            } else {
                $this->load->model("form_model");
                $this->load->model("form_model");
                $fille = $this->form_model->get_fille_in_uk($id);
                $data = array(
                    'file' => $fille['name'],
                    'user' => $fille['user_name']
                );
                $this->new_log($this->data['user_id'], "Files8", "In House UK", $fm_id, json_encode($data, TRUE), "File Has Been Deleted");
                $this->form_model->remove_in_uk($id);
                die("{}");
            }
        }

        public function remove_offer_in_uk9($fm_id, $id) {
            $file_name = $_POST['key'];
            if (!$id) {
                die(json_encode($this->data['error']));
            } else {
                $this->load->model("form_model");
                $this->load->model("form_model");
                $fille = $this->form_model->get_fille_in_uk($id);
                $data = array(
                    'file' => $fille['name'],
                    'user' => $fille['user_name']
                );
                $this->new_log($this->data['user_id'], "Files9", "In House UK", $fm_id, json_encode($data, TRUE), "File Has Been Deleted");
                $this->form_model->remove_in_uk($id);
                die("{}");
            }
        }

        public function remove_offer_in_uk10($fm_id, $id) {
            $file_name = $_POST['key'];
            if (!$id) {
                die(json_encode($this->data['error']));
            } else {
                $this->load->model("form_model");
                $this->load->model("form_model");
                $fille = $this->form_model->get_fille_in_uk($id);
                $data = array(
                    'file' => $fille['name'],
                    'user' => $fille['user_name']
                );
                $this->new_log($this->data['user_id'], "Files10", "In House UK", $fm_id, json_encode($data, TRUE), "File Has Been Deleted");
                $this->form_model->remove_in_uk($id);
                die("{}");
            }
        }

        public function remove_offer_in_uk11($fm_id, $id) {
            $file_name = $_POST['key'];
            if (!$id) {
                die(json_encode($this->data['error']));
            } else {
                $this->load->model("form_model");
                $this->load->model("form_model");
                $fille = $this->form_model->get_fille_in_uk($id);
                $data = array(
                    'file' => $fille['name'],
                    'user' => $fille['user_name']
                );
                $this->new_log($this->data['user_id'], "Files11", "In House UK", $fm_id, json_encode($data, TRUE), "File Has Been Deleted");
                $this->form_model->remove_in_uk($id);
                die("{}");
            }
        }

        public function remove_offer_in_uk12($fm_id, $id) {
            $file_name = $_POST['key'];
            if (!$id) {
                die(json_encode($this->data['error']));
            } else {
                $this->load->model("form_model");
                $this->load->model("form_model");
                $fille = $this->form_model->get_fille_in_uk($id);
                $data = array(
                    'file' => $fille['name'],
                    'user' => $fille['user_name']
                );
                $this->new_log($this->data['user_id'], "Files12", "In House UK", $fm_id, json_encode($data, TRUE), "File Has Been Deleted");
                $this->form_model->remove_in_uk($id);
                die("{}");
            }
        }

        public function remove_offer_in_uk13($fm_id, $id) {
            $file_name = $_POST['key'];
            if (!$id) {
                die(json_encode($this->data['error']));
            } else {
                $this->load->model("form_model");
                $this->load->model("form_model");
                $fille = $this->form_model->get_fille_in_uk($id);
                $data = array(
                    'file' => $fille['name'],
                    'user' => $fille['user_name']
                );
                $this->new_log($this->data['user_id'], "Files13", "In House UK", $fm_id, json_encode($data, TRUE), "File Has Been Deleted");
                $this->form_model->remove_in_uk($id);
                die("{}");
            }
        }

        public function index_in_uk() {
                if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
                $this->load->model('hotels_model');
                $this->load->model('form_model');
                $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
                $hotels = array();
                foreach ($user_hotels as $hotel) {
                    $hotels[] = $hotel['id'];
                }    
                $this->data['form'] = $this->form_model->view_in_uk($hotels);
                $this->data['hotels'] = $user_hotels;
                $this->data['operators'] = $this->form_model->getall_operator();
                $this->load->view('form_in_uk_index', $this->data);
            }else{
                redirect('/unknown');
            }
        }

        public function comment_in_uk($fm_id){
            if ($this->input->post('submit')) {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('comment','Comment','trim|required');
                if ($this->form_validation->run() == TRUE) {
                    $comment = $this->input->post('comment'); 
                    $this->load->model('form_model');
                    $comment_data = array(
                        'user_id' => $this->data['user_id'],
                        'fm_id' => $fm_id,
                        'comment' => $comment
                    );
                    $this->form_model->insertcomment_in_uk($comment_data);
                }
                redirect('/form/view_in_uk/'.$fm_id);
            }
        }
		
		public function submit_in() {
    		    if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
                if ($this->input->post('submit')) {
                    $this->load->library('form_validation');
                    $this->load->library('email');
                    $assumed_id2 = $this->input->post('assumed_id2');    
                    $this->form_validation->set_rules('hotel_id','Hotel Name','trim|required');
                    if ($this->form_validation->run() == TRUE) {
                        $this->load->model('form_model');
                        $this->load->model('users_model');  
                        $form_data = array(
                            'user_id' => $this->data['user_id'],
                            'hotel_id' => $this->input->post('hotel_id'),
                            'guest' => $this->input->post('guest'),
                            'referance' => $this->input->post('referance'),
                            'room' => $this->input->post('room'),
                            'arrival' => $this->input->post('arrival'),
                            'departure' => $this->input->post('departure'), 
                            'operator_id' => $this->input->post('operator_id'),
                            'tl' => $this->input->post('tl'),
                            'booking' => $this->input->post('booking'),
                            'reporting' => $this->input->post('reporting'),
                            'reported' => $this->input->post('reported'),
                            'accident' => $this->input->post('accident'),
                            'comment' => $this->input->post('comment'),
                            'comment1' => $this->input->post('comment1'),
                            'affected' => $this->input->post('affected'),
                            'names' => $this->input->post('names'),
                            'date' => $this->input->post('date'),
                            'symptoms' => $this->input->post('symptoms'),
                            'visited' => $this->input->post('visited'),
                            'treatment' => $this->input->post('treatment'),
                            'medication' => $this->input->post('medication'),
                            'duration' => $this->input->post('duration'),
                            'location' => $this->input->post('location'),
                            'cause' => $this->input->post('cause'),
                            'witness' => $this->input->post('witness'),
                            'investigation' => $this->input->post('investigation'),
                            'not_related' => $this->input->post('not_related'),
                            'injury' => $this->input->post('injury'),
                            'cctv' => $this->input->post('cctv'),
                            'photographs' => $this->input->post('photographs'),
                            'detail' => $this->input->post('detail'),
                            'action' => $this->input->post('action'),
                            'prevent' => $this->input->post('prevent'),
                            'report' => $this->input->post('report'),
                            'reports' => $this->input->post('reports'),
                            'informed' => $this->input->post('informed'),
                            'comments' => $this->input->post('comments'),
                            'added' => $this->input->post('added'),
                            'compensation' => $this->input->post('compensation'),
                            'value' => $this->input->post('value'),
                            'accepted' => $this->input->post('accepted'),
                            'given' => $this->input->post('given'),
                            'follow' => $this->input->post('follow'),
                            'insurance' => $this->input->post('insurance'),
                            'informed1' => $this->input->post('informed1'),
                            'responded' => $this->input->post('responded'),
                            'witness1' => $this->input->post('witness1'),
                            'paperwork' => $this->input->post('paperwork'),
                            'cristal' => $this->input->post('cristal'),
                            'audits' => $this->input->post('audits'),
                            'logs' => $this->input->post('logs'),
                            'maintenance' => $this->input->post('maintenance'),
                            'documents' => $this->input->post('documents'),
                            'other' => $this->input->post('other')
                        );
                        $fm_id = $this->form_model->create_form_in($form_data);
                        if ($fm_id) {
                            $this->load->model('form_model');
                            $this->form_model->update_in_files($assumed_id2,$fm_id);
                            $this->new_log($this->data['user_id'], "New", "In House Other", $fm_id, json_encode($form_data, TRUE), "User Created New In House Other");
                        } else {
                            die("ERROR");
                        }
                        redirect('/form/in_stage/'.$fm_id);
                    }
                }   
                try {
                    $this->load->helper('form');
                    $this->load->model('form_model');
                    $this->load->model('hotels_model');
                    $this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
                    $this->data['operators'] = $this->form_model->getall_operator();
                    if ($this->input->post('submit')) {
	                    $this->load->model('form_model');
                        $this->data['assumed_id2'] = mt_rand("1048575","10485751048575");
	                    $this->data['uploads'] = $this->form_model->getby_fille_in($this->data['assumed_id2'], 1);
	                    $this->data['uploads1'] = $this->form_model->getby_fille_in($this->data['assumed_id2'], 2);
	                    $this->data['uploads2'] = $this->form_model->getby_fille_in($this->data['assumed_id2'], 3);
	                    $this->data['uploads3'] = $this->form_model->getby_fille_in($this->data['assumed_id2'], 4);
	                    $this->data['uploads4'] = $this->form_model->getby_fille_in($this->data['assumed_id2'], 5);
                        $this->data['uploads5'] = $this->form_model->getby_fille_in($this->data['assumed_id2'], 6);
                        $this->data['uploads6'] = $this->form_model->getby_fille_in($this->data['assumed_id2'], 7);
                        $this->data['uploads7'] = $this->form_model->getby_fille_in($this->data['assumed_id2'], 8);
                        $this->data['uploads8'] = $this->form_model->getby_fille_in($this->data['assumed_id2'], 9);
                        $this->data['uploads9'] = $this->form_model->getby_fille_in($this->data['assumed_id2'], 10);
                        $this->data['uploads10'] = $this->form_model->getby_fille_in($this->data['assumed_id2'], 11);
                        $this->data['uploads11'] = $this->form_model->getby_fille_in($this->data['assumed_id2'], 12);
                        $this->data['uploads12'] = $this->form_model->getby_fille_in($this->data['assumed_id2'], 13);
	                } else {
                        $this->data['assumed_id2'] = mt_rand("1048575","10485751048575");
	                    $this->data['uploads'] = array();
	                    $this->data['uploads1'] = array();
	                    $this->data['uploads2'] = array();
	                    $this->data['uploads3'] = array();
	                    $this->data['uploads4'] = array();
                        $this->data['uploads5'] = array();
                        $this->data['uploads6'] = array();
                        $this->data['uploads7'] = array();
                        $this->data['uploads8'] = array();
                        $this->data['uploads9'] = array();
                        $this->data['uploads10'] = array();
                        $this->data['uploads11'] = array();
                        $this->data['uploads12'] = array();
	                }
                    $this->load->view('form_in_add_new',$this->data);
                }catch( Exception $e) {
                    show_error($e->getMessage()." _ ". $e->getTraceAsString());
                }
            }else{
                redirect('/unknown');
            }
        }

        public function in_stage($fm_id) {
            $this->load->model('form_model');
            $this->data['form'] = $this->form_model->get_form_in($fm_id);
            if ($this->data['form']['state_id'] == 0) {
              	$this->form_model->in_update_state($fm_id, 1);
              	redirect('/form/in_stage/'.$fm_id);
            } elseif ($this->data['form']['state_id'] == 1) {
                $this->notify_in($fm_id);
            }elseif ($this->data['form']['state_id'] == 3){
                $this->notify_edit_in($fm_id);
            }
        }
        
        public function notify_in($fm_id) {
            $this->load->model('form_model');
            $this->load->model('users_model');
            $this->data['form'] = $this->form_model->get_form_in($fm_id);
            $signes = $this->form_model->in_getby_verbal();
            $users = array();
            foreach ($signes as $signe){
                if ($signe['user_id'] != 30) {
    	            $users = $this->users_model->getby_criteria($signe['role'], $this->data['form']['hotel_id']);
    	            foreach($users as $user){
                      	$name = $user['fullname'];
                      	$mail = $user['email'];
                      	$this->load->library('email');
                        $this->load->helper('url');
                        $fm_url = base_url().'form/view_in/'.$fm_id;
                        $this->email->from('e-signature@sunrise-resorts.com');
                        $this->email->to($mail);
                        $this->email->subject("In House - other nationalities Incident Report Form No. #{$fm_id}");
                        $this->email->message("Dear {$name},
                        	<br/>
                            <br/>
                            In House - other nationalities Incident Report Form No. #{$fm_id} has been created, Please use the link below:
                            <br/>
                            <a href='{$fm_url}' target='_blank'>{$fm_url}</a>
                            <br/>
                        "); 
                        $mail_result = $this->email->send();
                    }
                }
            }
            redirect('form/view_in/'.$fm_id);
        }

        public function notify_edit_in($fm_id) {
            $this->load->model('form_model');
            $this->load->model('users_model');
            $this->data['form'] = $this->form_model->get_form_in($fm_id);
            $signes = $this->form_model->in_getby_verbal();
            $users = array();
            foreach ($signes as $signe){
                $users = $this->users_model->getby_criteria($signe['role'], $this->data['form']['hotel_id']);
                foreach($users as $user){
                    if ($user['id'] != 30) {
                  	$name = $user['fullname'];
                  	$mail = $user['email'];
                  	$this->load->library('email');
                    $this->load->helper('url');
                    $fm_url = base_url().'form/view_in/'.$fm_id;
                    $this->email->from('e-signature@sunrise-resorts.com');
                    $this->email->to($mail);
                    $this->email->subject("In House - other nationalities Incident Report Form No. #{$fm_id}");
                    $this->email->message("Dear {$name},
                    	<br/>
                        <br/>
                        In House - other nationalities Incident Report Form No. #{$fm_id} has been Edited, Please use the link below:
                        <br/>
                        <a href='{$fm_url}' target='_blank'>{$fm_url}</a>
                        <br/>
                    "); 
                    $mail_result = $this->email->send();
                    }
                }
            }
            redirect('form/view_in/'.$fm_id);
        }

        public function view_in($fm_id) {
    		    if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
                $this->load->model('form_model');
                $this->load->model('form_log_model');
                $illness = $this->form_model->get_illness("2", $fm_id);
                //die(print_r($illness));
                $this->form_model->update_form_in_iln($illness['iln_id'], $fm_id);
                $this->data['form'] = $this->form_model->get_form_in($fm_id);
                $this->data['form_new'] = $this->form_model->get_new_form_in($fm_id);
                $this->data['log'] = $this->form_log_model->get_log($fm_id, "In House Other");
                $this->data['getcomment'] = $this->form_model->getcomment_in($fm_id);
                $this->data['uploads'] = $this->form_model->getby_fille_in($fm_id, 1);
                $this->data['uploads1'] = $this->form_model->getby_fille_in($fm_id, 2);
                $this->data['uploads2'] = $this->form_model->getby_fille_in($fm_id, 3);
                $this->data['uploads3'] = $this->form_model->getby_fille_in($fm_id, 4);
                $this->data['uploads4'] = $this->form_model->getby_fille_in($fm_id, 5);
                $this->data['uploads5'] = $this->form_model->getby_fille_in($fm_id, 6);
                $this->data['uploads6'] = $this->form_model->getby_fille_in($fm_id, 7);
                $this->data['uploads7'] = $this->form_model->getby_fille_in($fm_id, 8);
                $this->data['uploads8'] = $this->form_model->getby_fille_in($fm_id, 9);
                $this->data['uploads9'] = $this->form_model->getby_fille_in($fm_id, 10);
                $this->data['uploads10'] = $this->form_model->getby_fille_in($fm_id, 11);
                $this->data['uploads11'] = $this->form_model->getby_fille_in($fm_id, 12);
                $this->data['uploads12'] = $this->form_model->getby_fille_in($fm_id, 13);
                $this->load->view('form_in_view', $this->data);
            }else{
              redirect('/unknown');
            }
        }

        public function edit_in($fm_id) {
    		    if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
                if ($this->input->post('submit')) {
                    $this->load->library('form_validation');
                    $this->load->library('email');
                    $this->form_validation->set_rules('hotel_id','Hotel Name','trim|required');
                    if ($this->form_validation->run() == TRUE) {
                        $this->load->model('form_model');
                        $this->load->model('users_model'); 
                        $this->load->model('hotels_model'); 
                        $form_data = array(
                            'user_id' => $this->data['user_id'],
                            'hotel_id' => $this->input->post('hotel_id'),
                            'guest' => $this->input->post('guest'),
                            'referance' => $this->input->post('referance'),
                            'room' => $this->input->post('room'),
                            'arrival' => $this->input->post('arrival'),
                            'departure' => $this->input->post('departure'), 
                            'operator_id' => $this->input->post('operator_id'),
                            'tl' => $this->input->post('tl'),
                            'booking' => $this->input->post('booking'),
                            'reporting' => $this->input->post('reporting'),
                            'reported' => $this->input->post('reported'),
                            'accident' => $this->input->post('accident'),
                            'comment' => $this->input->post('comment'),
                            'comment1' => $this->input->post('comment1'),
                            'affected' => $this->input->post('affected'),
                            'names' => $this->input->post('names'),
                            'date' => $this->input->post('date'),
                            'symptoms' => $this->input->post('symptoms'),
                            'visited' => $this->input->post('visited'),
                            'treatment' => $this->input->post('treatment'),
                            'medication' => $this->input->post('medication'),
                            'duration' => $this->input->post('duration'),
                            'location' => $this->input->post('location'),
                            'cause' => $this->input->post('cause'),
                            'witness' => $this->input->post('witness'),
                            'investigation' => $this->input->post('investigation'),
                            'not_related' => $this->input->post('not_related'),
                            'injury' => $this->input->post('injury'),
                            'cctv' => $this->input->post('cctv'),
                            'photographs' => $this->input->post('photographs'),
                            'detail' => $this->input->post('detail'),
                            'action' => $this->input->post('action'),
                            'prevent' => $this->input->post('prevent'),
                            'report' => $this->input->post('report'),
                            'reports' => $this->input->post('reports'),
                            'informed' => $this->input->post('informed'),
                            'comments' => $this->input->post('comments'),
                            'added' => $this->input->post('added'),
                            'compensation' => $this->input->post('compensation'),
                            'value' => $this->input->post('value'),
                            'accepted' => $this->input->post('accepted'),
                            'given' => $this->input->post('given'),
                            'follow' => $this->input->post('follow'),
                            'insurance' => $this->input->post('insurance'),
                            'informed1' => $this->input->post('informed1'),
                            'responded' => $this->input->post('responded'),
                            'witness1' => $this->input->post('witness1'),
                            'paperwork' => $this->input->post('paperwork'),
                            'cristal' => $this->input->post('cristal'),
                            'audits' => $this->input->post('audits'),
                            'logs' => $this->input->post('logs'),
                            'maintenance' => $this->input->post('maintenance'),
                            'documents' => $this->input->post('documents'),
                            'other' => $this->input->post('other')
                        );
                        $this->data['form'] = $this->form_model->get_form_in($fm_id);
                        $hotel = $this->hotels_model->get_by_id($form_data['hotel_id']);                        
                        $operator = $this->form_model->get_operator_by_id($form_data['operator_id']);                        
                        if ($this->data['form']['hotel_id'] != $form_data['hotel_id']) {
                            $data = array(
                                'old' => $this->data['form']['hotel_name'],
                                'new' => $hotel['name']
                            );
                            $this->new_log($this->data['user_id'], "hotel_id", "In House Other", $fm_id, json_encode($data, TRUE), "Hotel Has Been Changed");
                        }
                        if ($this->data['form']['guest'] != $form_data['guest']) {
                            $data = array(
                                'old' => $this->data['form']['guest'],
                                'new' => $form_data['guest']
                            );
                            $this->new_log($this->data['user_id'], "guest", "In House Other", $fm_id, json_encode($data, TRUE), "Guest Name Has Been Changed");
                        }
                        if ($this->data['form']['referance'] != $form_data['referance']) {
                            $data = array(
                                'old' => $this->data['form']['referance'],
                                'new' => $form_data['referance']
                            );
                            $this->new_log($this->data['user_id'], "referance", "In House Other", $fm_id, json_encode($data, TRUE), "Booking Referance Has Been Changed");
                        }
                        if ($this->data['form']['room'] != $form_data['room']) {
                            $data = array(
                                'old' => $this->data['form']['room'],
                                'new' => $form_data['room']
                            );
                            $this->new_log($this->data['user_id'], "room", "In House Other", $fm_id, json_encode($data, TRUE), "Room No. Has Been Changed");
                        }
                        if ($this->data['form']['arrival'] != $form_data['arrival']) {
                            $data = array(
                                'old' => $this->data['form']['arrival'],
                                'new' => $form_data['arrival']
                            );
                            $this->new_log($this->data['user_id'], "arrival", "In House Other", $fm_id, json_encode($data, TRUE), "Arrival Date Has Been Changed");
                        }
                        if ($this->data['form']['departure'] != $form_data['departure']) {
                            $data = array(
                                'old' => $this->data['form']['departure'],
                                'new' => $form_data['departure']
                            );
                            $this->new_log($this->data['user_id'], "departure", "In House Other", $fm_id, json_encode($data, TRUE), "Departure Date Has Been Changed");
                        }
                        if ($this->data['form']['operator_id'] != $form_data['operator_id']) {
                            $data = array(
                                'old' => $this->data['form']['operator_name'],
                                'new' => $operator['name']
                            );
                            $this->new_log($this->data['user_id'], "operator_id", "In House Other", $fm_id, json_encode($data, TRUE), "Operator Has Been Changed");
                        }
                        if ($this->data['form']['tl'] != $form_data['tl']) {
                            $data = array(
                                'old' => $this->data['form']['tl'],
                                'new' => $form_data['tl']
                            );
                            $this->new_log($this->data['user_id'], "tl", "In House Other", $fm_id, json_encode($data, TRUE), "Name of TL Has Been Changed");
                        }
                        if ($this->data['form']['booking'] != $form_data['booking']) {
                            $data = array(
                                'old' => $this->data['form']['booking'],
                                'new' => $form_data['booking']
                            );
                            $this->new_log($this->data['user_id'], "booking", "In House Other", $fm_id, json_encode($data, TRUE), "Booking Has Been Changed");
                        }
                        if ($this->data['form']['reporting'] != $form_data['reporting']) {
                            $data = array(
                                'old' => $this->data['form']['reporting'],
                                'new' => $form_data['reporting']
                            );
                            $this->new_log($this->data['user_id'], "reporting", "In House Other", $fm_id, json_encode($data, TRUE), "Reporting Has Been Changed");
                        }
                        if ($this->data['form']['reported'] != $form_data['reported']) {
                            $data = array(
                                'old' => $this->data['form']['reported'],
                                'new' => $form_data['reported']
                            );
                            $this->new_log($this->data['user_id'], "reported", "In House Other", $fm_id, json_encode($data, TRUE), "Reported Has Been Changed");
                        }
                        if ($this->data['form']['accident'] != $form_data['accident']) {
                            $data = array(
                                'old' => $this->data['form']['accident'],
                                'new' => $form_data['accident']
                            );
                            $this->new_log($this->data['user_id'], "accident", "In House Other", $fm_id, json_encode($data, TRUE), "Accident Has Been Changed");
                        }
                        if ($this->data['form']['comment'] != $form_data['comment']) {
                            $data = array(
                                'old' => $this->data['form']['comment'],
                                'new' => $form_data['comment']
                            );
                            $this->new_log($this->data['user_id'], "comment", "In House Other", $fm_id, json_encode($data, TRUE), "Comment Has Been Changed");
                        }
                        if ($this->data['form']['comment1'] != $form_data['comment1']) {
                            $data = array(
                                'old' => $this->data['form']['comment1'],
                                'new' => $form_data['comment1']
                            );
                            $this->new_log($this->data['user_id'], "comment1", "In House Other", $fm_id, json_encode($data, TRUE), "Comment Has Been Changed");
                        }
                        if ($this->data['form']['affected'] != $form_data['affected']) {
                            $data = array(
                                'old' => $this->data['form']['affected'],
                                'new' => $form_data['affected']
                            );
                            $this->new_log($this->data['user_id'], "affected", "In House Other", $fm_id, json_encode($data, TRUE), "Affected Has Been Changed");
                        }
                        if ($this->data['form']['names'] != $form_data['names']) {
                            $data = array(
                                'old' => $this->data['form']['names'],
                                'new' => $form_data['names']
                            );
                            $this->new_log($this->data['user_id'], "names", "In House Other", $fm_id, json_encode($data, TRUE), "Names Has Been Changed");
                        }
                        
                        if ($this->data['form']['date'] != $form_data['date']) {
                            $data = array(
                                'old' => $this->data['form']['date'],
                                'new' => $form_data['date']
                            );
                            $this->new_log($this->data['user_id'], "date", "In House Other", $fm_id, json_encode($data, TRUE), "Date Has Been Changed");
                        }
                        if ($this->data['form']['symptoms'] != $form_data['symptoms']) {
                            $data = array(
                                'old' => $this->data['form']['symptoms'],
                                'new' => $form_data['symptoms']
                            );
                            $this->new_log($this->data['user_id'], "symptoms", "In House Other", $fm_id, json_encode($data, TRUE), "Symptoms Has Been Changed");
                        }
                        if ($this->data['form']['visited'] != $form_data['visited']) {
                            $data = array(
                                'old' => $this->data['form']['visited'],
                                'new' => $form_data['visited']
                            );
                            $this->new_log($this->data['user_id'], "visited", "In House Other", $fm_id, json_encode($data, TRUE), "Visited Has Been Changed");
                        }
                        if ($this->data['form']['treatment'] != $form_data['treatment']) {
                            $data = array(
                                'old' => $this->data['form']['treatment'],
                                'new' => $form_data['treatment']
                            );
                            $this->new_log($this->data['user_id'], "treatment", "In House Other", $fm_id, json_encode($data, TRUE), "Treatment Has Been Changed");
                        }
                        if ($this->data['form']['medication'] != $form_data['medication']) {
                            $data = array(
                                'old' => $this->data['form']['medication'],
                                'new' => $form_data['medication']
                            );
                            $this->new_log($this->data['user_id'], "medication", "In House Other", $fm_id, json_encode($data, TRUE), "Medication Has Been Changed");
                        }
                        if ($this->data['form']['duration'] != $form_data['duration']) {
                            $data = array(
                                'old' => $this->data['form']['duration'],
                                'new' => $form_data['duration']
                            );
                            $this->new_log($this->data['user_id'], "duration", "In House Other", $fm_id, json_encode($data, TRUE), "Duration Has Been Changed");
                        }
                        if ($this->data['form']['accident'] != $form_data['accident']) {
                            $data = array(
                                'old' => $this->data['form']['accident'],
                                'new' => $form_data['accident']
                            );
                            $this->new_log($this->data['user_id'], "accident", "In House UK", $fm_id, json_encode($data, TRUE), "Accident Has Been Changed");
                        }
                        if ($this->data['form']['location'] != $form_data['location']) {
                            $data = array(
                                'old' => $this->data['form']['location'],
                                'new' => $form_data['location']
                            );
                            $this->new_log($this->data['user_id'], "location", "In House Other", $fm_id, json_encode($data, TRUE), "Location Has Been Changed");
                        }
                        if ($this->data['form']['cause'] != $form_data['cause']) {
                            $data = array(
                                'old' => $this->data['form']['cause'],
                                'new' => $form_data['cause']
                            );
                            $this->new_log($this->data['user_id'], "cause", "In House Other", $fm_id, json_encode($data, TRUE), "Cause Has Been Changed");
                        }
                        if ($this->data['form']['witness'] != $form_data['witness']) {
                            $data = array(
                                'old' => $this->data['form']['witness'],
                                'new' => $form_data['witness']
                            );
                            $this->new_log($this->data['user_id'], "witness", "In House Other", $fm_id, json_encode($data, TRUE), "Witness Has Been Changed");
                        }
                        if ($this->data['form']['investigation'] != $form_data['investigation']) {
                            $data = array(
                                'old' => $this->data['form']['investigation'],
                                'new' => $form_data['investigation']
                            );
                            $this->new_log($this->data['user_id'], "investigation", "In House Other", $fm_id, json_encode($data, TRUE), "Investigation Has Been Changed");
                        }
                        if ($this->data['form']['not_related'] != $form_data['not_related']) {
                            $data = array(
                                'old' => $this->data['form']['not_related'],
                                'new' => $form_data['not_related']
                            );
                            $this->new_log($this->data['user_id'], "not_related", "In House Other", $fm_id, json_encode($data, TRUE), "Related Has Been Changed");
                        }
                        if ($this->data['form']['injury'] != $form_data['injury']) {
                            $data = array(
                                'old' => $this->data['form']['injury'],
                                'new' => $form_data['injury']
                            );
                            $this->new_log($this->data['user_id'], "injury", "In House Other", $fm_id, json_encode($data, TRUE), "Injury Has Been Changed");
                        }
                        if ($this->data['form']['cctv'] != $form_data['cctv']) {
                            $data = array(
                                'old' => $this->data['form']['cctv'],
                                'new' => $form_data['cctv']
                            );
                            $this->new_log($this->data['user_id'], "cctv", "In House Other", $fm_id, json_encode($data, TRUE), "CCTV Has Been Changed");
                        }
                        if ($this->data['form']['photographs'] != $form_data['photographs']) {
                            $data = array(
                                'old' => $this->data['form']['photographs'],
                                'new' => $form_data['photographs']
                            );
                            $this->new_log($this->data['user_id'], "photographs", "In House Other", $fm_id, json_encode($data, TRUE), "Photographs Has Been Changed");
                        }
                        if ($this->data['form']['detail'] != $form_data['detail']) {
                            $data = array(
                                'old' => $this->data['form']['detail'],
                                'new' => $form_data['detail']
                            );
                            $this->new_log($this->data['user_id'], "detail", "In House Other", $fm_id, json_encode($data, TRUE), "Detail Has Been Changed");
                        }
                        if ($this->data['form']['action'] != $form_data['action']) {
                            $data = array(
                                'old' => $this->data['form']['action'],
                                'new' => $form_data['action']
                            );
                            $this->new_log($this->data['user_id'], "action", "In House Other", $fm_id, json_encode($data, TRUE), "Action Has Been Changed");
                        }
                        if ($this->data['form']['prevent'] != $form_data['prevent']) {
                            $data = array(
                                'old' => $this->data['form']['prevent'],
                                'new' => $form_data['prevent']
                            );
                            $this->new_log($this->data['user_id'], "prevent", "In House Other", $fm_id, json_encode($data, TRUE), "Prevent Has Been Changed");
                        }
                        if ($this->data['form']['report'] != $form_data['report']) {
                            $data = array(
                                'old' => $this->data['form']['report'],
                                'new' => $form_data['report']
                            );
                            $this->new_log($this->data['user_id'], "report", "In House Other", $fm_id, json_encode($data, TRUE), "Report Has Been Changed");
                        }
                        if ($this->data['form']['reports'] != $form_data['reports']) {
                            $data = array(
                                'old' => $this->data['form']['reports'],
                                'new' => $form_data['reports']
                            );
                            $this->new_log($this->data['user_id'], "reports", "In House Other", $fm_id, json_encode($data, TRUE), "Reports Has Been Changed");
                        }
                        if ($this->data['form']['informed'] != $form_data['informed']) {
                            $data = array(
                                'old' => $this->data['form']['informed'],
                                'new' => $form_data['informed']
                            );
                            $this->new_log($this->data['user_id'], "informed", "In House Other", $fm_id, json_encode($data, TRUE), "Informed Has Been Changed");
                        }
                        if ($this->data['form']['comments'] != $form_data['comments']) {
                            $data = array(
                                'old' => $this->data['form']['comments'],
                                'new' => $form_data['comments']
                            );
                            $this->new_log($this->data['user_id'], "comments", "In House Other", $fm_id, json_encode($data, TRUE), "Comments Has Been Changed");
                        }
                        if ($this->data['form']['added'] != $form_data['added']) {
                            $data = array(
                                'old' => $this->data['form']['added'],
                                'new' => $form_data['added']
                            );
                            $this->new_log($this->data['user_id'], "added", "In House Other", $fm_id, json_encode($data, TRUE), "Added Has Been Changed");
                        }
                        if ($this->data['form']['compensation'] != $form_data['compensation']) {
                            $data = array(
                                'old' => $this->data['form']['compensation'],
                                'new' => $form_data['compensation']
                            );
                            $this->new_log($this->data['user_id'], "compensation", "In House Other", $fm_id, json_encode($data, TRUE), "Compensation Has Been Changed");
                        }
                        if ($this->data['form']['value'] != $form_data['value']) {
                            $data = array(
                                'old' => $this->data['form']['value'],
                                'new' => $form_data['value']
                            );
                            $this->new_log($this->data['user_id'], "value", "In House Other", $fm_id, json_encode($data, TRUE), "Value Has Been Changed");
                        }
                        if ($this->data['form']['accepted'] != $form_data['accepted']) {
                            $data = array(
                                'old' => $this->data['form']['accepted'],
                                'new' => $form_data['accepted']
                            );
                            $this->new_log($this->data['user_id'], "accepted", "In House Other", $fm_id, json_encode($data, TRUE), "accepted Has Been Changed");
                        }
                        if ($this->data['form']['given'] != $form_data['given']) {
                            $data = array(
                                'old' => $this->data['form']['given'],
                                'new' => $form_data['given']
                            );
                            $this->new_log($this->data['user_id'], "given", "In House Other", $fm_id, json_encode($data, TRUE), "Given Has Been Changed");
                        }
						if ($this->data['form']['follow'] != $form_data['follow']) {
                            $data = array(
                                'old' => $this->data['form']['follow'],
                                'new' => $form_data['follow']
                            );
                            $this->new_log($this->data['user_id'], "follow", "In House UK", $fm_id, json_encode($data, TRUE), "Follow Has Been Changed");
                        }
                        if ($this->data['form']['insurance'] != $form_data['insurance']) {
                            $data = array(
                                'old' => $this->data['form']['insurance'],
                                'new' => $form_data['insurance']
                            );
                            $this->new_log($this->data['user_id'], "insurance", "In House Other", $fm_id, json_encode($data, TRUE), "Insurance Has Been Changed");
                        }
                        if ($this->data['form']['informed1'] != $form_data['informed1']) {
                            $data = array(
                                'old' => $this->data['form']['informed1'],
                                'new' => $form_data['informed1']
                            );
                            $this->new_log($this->data['user_id'], "informed1", "In House Other", $fm_id, json_encode($data, TRUE), "Informed Has Been Changed");
                        }
                        if ($this->data['form']['responded'] != $form_data['responded']) {
                            $data = array(
                                'old' => $this->data['form']['responded'],
                                'new' => $form_data['responded']
                            );
                            $this->new_log($this->data['user_id'], "responded", "In House Other", $fm_id, json_encode($data, TRUE), "Responded Has Been Changed");
                        }
                        if ($this->data['form']['witness1'] != $form_data['witness1']) {
                            $data = array(
                                'old' => $this->data['form']['witness1'],
                                'new' => $form_data['witness1']
                            );
                            $this->new_log($this->data['user_id'], "witness1", "In House Other", $fm_id, json_encode($data, TRUE), "Witness Has Been Changed");
                        }
                        if ($this->data['form']['paperwork'] != $form_data['paperwork']) {
                            $data = array(
                                'old' => $this->data['form']['paperwork'],
                                'new' => $form_data['paperwork']
                            );
                            $this->new_log($this->data['user_id'], "paperwork", "In House Other", $fm_id, json_encode($data, TRUE), "Paperwork Has Been Changed");
                        }
                        if ($this->data['form']['cristal'] != $form_data['cristal']) {
                            $data = array(
                                'old' => $this->data['form']['cristal'],
                                'new' => $form_data['cristal']
                            );
                            $this->new_log($this->data['user_id'], "cristal", "In House Other", $fm_id, json_encode($data, TRUE), "Cristal Has Been Changed");
                        }
                        if ($this->data['form']['audits'] != $form_data['audits']) {
                            $data = array(
                                'old' => $this->data['form']['audits'],
                                'new' => $form_data['audits']
                            );
                            $this->new_log($this->data['user_id'], "audits", "In House Other", $fm_id, json_encode($data, TRUE), "Audits Has Been Changed");
                        }
                        if ($this->data['form']['logs'] != $form_data['logs']) {
                            $data = array(
                                'old' => $this->data['form']['logs'],
                                'new' => $form_data['logs']
                            );
                            $this->new_log($this->data['user_id'], "logs", "In House Other", $fm_id, json_encode($data, TRUE), "Logs Has Been Changed");
                        }
                        if ($this->data['form']['maintenance'] != $form_data['maintenance']) {
                            $data = array(
                                'old' => $this->data['form']['maintenance'],
                                'new' => $form_data['maintenance']
                            );
                            $this->new_log($this->data['user_id'], "maintenance", "In House Other", $fm_id, json_encode($data, TRUE), "Maintenance Has Been Changed");
                        }
                        if ($this->data['form']['documents'] != $form_data['documents']) {
                            $data = array(
                                'old' => $this->data['form']['documents'],
                                'new' => $form_data['documents']
                            );
                            $this->new_log($this->data['user_id'], "documents", "In House Other", $fm_id, json_encode($data, TRUE), "Documents Has Been Changed");
                        }
                        if ($this->data['form']['other'] != $form_data['other']) {
                            $data = array(
                                'old' => $this->data['form']['other'],
                                'new' => $form_data['other']
                            );
                            $this->new_log($this->data['user_id'], "other", "In House Other", $fm_id, json_encode($data, TRUE), "Other Has Been Changed");
                        }
                        $this->form_model->update_form_in($form_data, $fm_id);
                        $this->form_model->in_update_state($fm_id, 3);
                        redirect('/form/in_stage/'.$fm_id);
                    }
                }   
                try {
                    $this->load->helper('form');
                    $this->load->model('form_model');
                    $this->load->model('hotels_model');
                    $this->data['form'] = $this->form_model->get_form_in($fm_id);
                    $this->data['uploads'] = $this->form_model->getby_fille_in($fm_id, 1);
                    $this->data['uploads1'] = $this->form_model->getby_fille_in($fm_id, 2);
                    $this->data['uploads2'] = $this->form_model->getby_fille_in($fm_id, 3);
                    $this->data['uploads3'] = $this->form_model->getby_fille_in($fm_id, 4);
                    $this->data['uploads4'] = $this->form_model->getby_fille_in($fm_id, 5);
                    $this->data['uploads5'] = $this->form_model->getby_fille_in($fm_id, 6);
                    $this->data['uploads6'] = $this->form_model->getby_fille_in($fm_id, 7);
                    $this->data['uploads7'] = $this->form_model->getby_fille_in($fm_id, 8);
                    $this->data['uploads8'] = $this->form_model->getby_fille_in($fm_id, 9);
                    $this->data['uploads9'] = $this->form_model->getby_fille_in($fm_id, 10);
                    $this->data['uploads10'] = $this->form_model->getby_fille_in($fm_id, 11);
                    $this->data['uploads11'] = $this->form_model->getby_fille_in($fm_id, 12);
                    $this->data['uploads12'] = $this->form_model->getby_fille_in($fm_id, 13);
                    $this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
                    $this->data['operators'] = $this->form_model->getall_operator();
                    $this->load->view('form_in_edit',$this->data);
                }catch( Exception $e) {
                    show_error($e->getMessage()." _ ". $e->getTraceAsString());
                }
            }else{
                redirect('/unknown');
            }
        }

        public function make_offer_in($fm_id, $type) {
    		$file_name = $this->do_upload("upload");
    		if (!$file_name) {
      			die(json_encode($this->data['error']));
    		} else {
     			$this->load->model("form_model");
      			$this->form_model->add_in($fm_id, $file_name, $this->data['user_id'], $type);
                $data = array(
                    'file' => $file_name
                );
                $this->new_log($this->data['user_id'], "File", "In House Other", $fm_id, json_encode($data, TRUE), "New File Has Been Uploaded");
      			die("{}");
    		}
  		}

  		public function make_offer_in1($fm_id, $type) {
    		$file_name = $this->do_upload("upload1");
    		if (!$file_name) {
      			die(json_encode($this->data['error']));
    		} else {
     			$this->load->model("form_model");
      			$this->form_model->add_in($fm_id, $file_name, $this->data['user_id'], $type);
                $data = array(
                    'file' => $file_name
                );
                $this->new_log($this->data['user_id'], "File1", "In House Other", $fm_id, json_encode($data, TRUE), "New File Has Been Uploaded");
      			die("{}");
    		}
  		}

  		public function make_offer_in2($fm_id, $type) {
    		$file_name = $this->do_upload("upload2");
    		if (!$file_name) {
      			die(json_encode($this->data['error']));
    		} else {
     			$this->load->model("form_model");
      			$this->form_model->add_in($fm_id, $file_name, $this->data['user_id'], $type);
                $data = array(
                    'file' => $file_name
                );
                $this->new_log($this->data['user_id'], "File2", "In House Other", $fm_id, json_encode($data, TRUE), "New File Has Been Uploaded");
      			die("{}");
    		}
  		}

  		public function make_offer_in3($fm_id, $type) {
    		$file_name = $this->do_upload("upload3");
    		if (!$file_name) {
      			die(json_encode($this->data['error']));
    		} else {
     			$this->load->model("form_model");
      			$this->form_model->add_in($fm_id, $file_name, $this->data['user_id'], $type);
                $data = array(
                    'file' => $file_name
                );
                $this->new_log($this->data['user_id'], "File3", "In House Other", $fm_id, json_encode($data, TRUE), "New File Has Been Uploaded");
      			die("{}");
    		}
  		}

  		public function make_offer_in4($fm_id, $type) {
    		$file_name = $this->do_upload("upload4");
    		if (!$file_name) {
      			die(json_encode($this->data['error']));
    		} else {
     			$this->load->model("form_model");
      			$this->form_model->add_in($fm_id, $file_name, $this->data['user_id'], $type);
                $data = array(
                    'file' => $file_name
                );
                $this->new_log($this->data['user_id'], "File4", "In House Other", $fm_id, json_encode($data, TRUE), "New File Has Been Uploaded");
      			die("{}");
    		}
  		}

  		public function make_offer_in5($fm_id, $type) {
    		$file_name = $this->do_upload("upload5");
    		if (!$file_name) {
      			die(json_encode($this->data['error']));
    		} else {
     			$this->load->model("form_model");
      			$this->form_model->add_in($fm_id, $file_name, $this->data['user_id'], $type);
                $data = array(
                    'file' => $file_name
                );
                $this->new_log($this->data['user_id'], "File5", "In House Other", $fm_id, json_encode($data, TRUE), "New File Has Been Uploaded");
      			die("{}");
    		}
  		}

        public function make_offer_in6($fm_id, $type) {
            $file_name = $this->do_upload("upload6");
            if (!$file_name) {
                die(json_encode($this->data['error']));
            } else {
                $this->load->model("form_model");
                $this->form_model->add_in($fm_id, $file_name, $this->data['user_id'], $type);
                $data = array(
                    'file' => $file_name
                );
                $this->new_log($this->data['user_id'], "File6", "In House Other", $fm_id, json_encode($data, TRUE), "New File Has Been Uploaded");
                die("{}");
            }
        }

        public function make_offer_in7($fm_id, $type) {
            $file_name = $this->do_upload("upload7");
            if (!$file_name) {
                die(json_encode($this->data['error']));
            } else {
                $this->load->model("form_model");
                $this->form_model->add_in($fm_id, $file_name, $this->data['user_id'], $type);
                $data = array(
                    'file' => $file_name
                );
                $this->new_log($this->data['user_id'], "File7", "In House Other", $fm_id, json_encode($data, TRUE), "New File Has Been Uploaded");
                die("{}");
            }
        }

        public function make_offer_in8($fm_id, $type) {
            $file_name = $this->do_upload("upload8");
            if (!$file_name) {
                die(json_encode($this->data['error']));
            } else {
                $this->load->model("form_model");
                $this->form_model->add_in($fm_id, $file_name, $this->data['user_id'], $type);
                $data = array(
                    'file' => $file_name
                );
                $this->new_log($this->data['user_id'], "File8", "In House Other", $fm_id, json_encode($data, TRUE), "New File Has Been Uploaded");
                die("{}");
            }
        }

        public function make_offer_in9($fm_id, $type) {
            $file_name = $this->do_upload("upload9");
            if (!$file_name) {
                die(json_encode($this->data['error']));
            } else {
                $this->load->model("form_model");
                $this->form_model->add_in($fm_id, $file_name, $this->data['user_id'], $type);
                $data = array(
                    'file' => $file_name
                );
                $this->new_log($this->data['user_id'], "File9", "In House Other", $fm_id, json_encode($data, TRUE), "New File Has Been Uploaded");
                die("{}");
            }
        }

        public function make_offer_in10($fm_id, $type) {
            $file_name = $this->do_upload("upload10");
            if (!$file_name) {
                die(json_encode($this->data['error']));
            } else {
                $this->load->model("form_model");
                $this->form_model->add_in($fm_id, $file_name, $this->data['user_id'], $type);
                $data = array(
                    'file' => $file_name
                );
                $this->new_log($this->data['user_id'], "File10", "In House Other", $fm_id, json_encode($data, TRUE), "New File Has Been Uploaded");
                die("{}");
            }
        }

        public function make_offer_in11($fm_id, $type) {
            $file_name = $this->do_upload("upload11");
            if (!$file_name) {
                die(json_encode($this->data['error']));
            } else {
                $this->load->model("form_model");
                $this->form_model->add_in($fm_id, $file_name, $this->data['user_id'], $type);
                $data = array(
                    'file' => $file_name
                );
                $this->new_log($this->data['user_id'], "File11", "In House Other", $fm_id, json_encode($data, TRUE), "New File Has Been Uploaded");
                die("{}");
            }
        }

        public function make_offer_in12($fm_id, $type) {
            $file_name = $this->do_upload("upload12");
            if (!$file_name) {
                die(json_encode($this->data['error']));
            } else {
                $this->load->model("form_model");
                $this->form_model->add_in($fm_id, $file_name, $this->data['user_id'], $type);
                $data = array(
                    'file' => $file_name
                );
                $this->new_log($this->data['user_id'], "File12", "In House Other", $fm_id, json_encode($data, TRUE), "New File Has Been Uploaded");
                die("{}");
            }
        }

  		public function remove_offer_in($fm_id, $id) {
            $file_name = $_POST['key'];
            if (!$id) {
                die(json_encode($this->data['error']));
            } else {
                $this->load->model("form_model");
                $fille = $this->form_model->get_fille_in($id);
                $data = array(
                    'file' => $fille['name'],
                    'user' => $fille['user_name']
                );
                $this->new_log($this->data['user_id'], "Files", "In House Other", $fm_id, json_encode($data, TRUE), "File Has Been Deleted");
                $this->form_model->remove_in($id);
                die("{}");
            }
        }

        public function remove_offer_in1($fm_id, $id) {
            $file_name = $_POST['key'];
            if (!$id) {
                die(json_encode($this->data['error']));
            } else {
                $this->load->model("form_model");
                $fille = $this->form_model->get_fille_in($id);
                $data = array(
                    'file' => $fille['name'],
                    'user' => $fille['user_name']
                );
                $this->new_log($this->data['user_id'], "Files1", "In House Other", $fm_id, json_encode($data, TRUE), "File Has Been Deleted");
                $this->form_model->remove_in($id);
                die("{}");
            }
        }

        public function remove_offer_in2($fm_id, $id) {
            $file_name = $_POST['key'];
            if (!$id) {
                die(json_encode($this->data['error']));
            } else {
                $this->load->model("form_model");
                $fille = $this->form_model->get_fille_in($id);
                $data = array(
                    'file' => $fille['name'],
                    'user' => $fille['user_name']
                );
                $this->new_log($this->data['user_id'], "Files2", "In House Other", $fm_id, json_encode($data, TRUE), "File Has Been Deleted");
                $this->form_model->remove_in($id);
                die("{}");
            }
        }

        public function remove_offer_in3($fm_id, $id) {
            $file_name = $_POST['key'];
            if (!$id) {
                die(json_encode($this->data['error']));
            } else {
                $this->load->model("form_model");
                $fille = $this->form_model->get_fille_in($id);
                $data = array(
                    'file' => $fille['name'],
                    'user' => $fille['user_name']
                );
                $this->new_log($this->data['user_id'], "Files3", "In House Other", $fm_id, json_encode($data, TRUE), "File Has Been Deleted");
                $this->form_model->remove_in($id);
                die("{}");
            }
        }

        public function remove_offer_in4($fm_id, $id) {
            $file_name = $_POST['key'];
            if (!$id) {
                die(json_encode($this->data['error']));
            } else {
                $this->load->model("form_model");
                $fille = $this->form_model->get_fille_in($id);
                $data = array(
                    'file' => $fille['name'],
                    'user' => $fille['user_name']
                );
                $this->new_log($this->data['user_id'], "Files4", "In House Other", $fm_id, json_encode($data, TRUE), "File Has Been Deleted");
                $this->form_model->remove_in($id);
                die("{}");
            }
        }

        public function remove_offer_in5($fm_id, $id) {
            $file_name = $_POST['key'];
            if (!$id) {
                die(json_encode($this->data['error']));
            } else {
                $this->load->model("form_model");
                $fille = $this->form_model->get_fille_in($id);
                $data = array(
                    'file' => $fille['name'],
                    'user' => $fille['user_name']
                );
                $this->new_log($this->data['user_id'], "Files5", "In House Other", $fm_id, json_encode($data, TRUE), "File Has Been Deleted");
                $this->form_model->remove_in($id);
                die("{}");
            }
        }

        public function remove_offer_in6($fm_id, $id) {
            $file_name = $_POST['key'];
            if (!$id) {
                die(json_encode($this->data['error']));
            } else {
                $this->load->model("form_model");
                $fille = $this->form_model->get_fille_in($id);
                $data = array(
                    'file' => $fille['name'],
                    'user' => $fille['user_name']
                );
                $this->new_log($this->data['user_id'], "Files6", "In House Other", $fm_id, json_encode($data, TRUE), "File Has Been Deleted");
                $this->form_model->remove_in($id);
                die("{}");
            }
        }

        public function remove_offer_in7($fm_id, $id) {
            $file_name = $_POST['key'];
            if (!$id) {
                die(json_encode($this->data['error']));
            } else {
                $this->load->model("form_model");
                $fille = $this->form_model->get_fille_in($id);
                $data = array(
                    'file' => $fille['name'],
                    'user' => $fille['user_name']
                );
                $this->new_log($this->data['user_id'], "Files7", "In House Other", $fm_id, json_encode($data, TRUE), "File Has Been Deleted");
                $this->form_model->remove_in($id);
                die("{}");
            }
        }

        public function remove_offer_in8($fm_id, $id) {
            $file_name = $_POST['key'];
            if (!$id) {
                die(json_encode($this->data['error']));
            } else {
                $this->load->model("form_model");
                $fille = $this->form_model->get_fille_in($id);
                $data = array(
                    'file' => $fille['name'],
                    'user' => $fille['user_name']
                );
                $this->new_log($this->data['user_id'], "Files8", "In House Other", $fm_id, json_encode($data, TRUE), "File Has Been Deleted");
                $this->form_model->remove_in($id);
                die("{}");
            }
        }

        public function remove_offer_in9($fm_id, $id) {
            $file_name = $_POST['key'];
            if (!$id) {
                die(json_encode($this->data['error']));
            } else {
                $this->load->model("form_model");
                $fille = $this->form_model->get_fille_in($id);
                $data = array(
                    'file' => $fille['name'],
                    'user' => $fille['user_name']
                );
                $this->new_log($this->data['user_id'], "Files9", "In House Other", $fm_id, json_encode($data, TRUE), "File Has Been Deleted");
                $this->form_model->remove_in($id);
                die("{}");
            }
        }

        public function remove_offer_in10($fm_id, $id) {
            $file_name = $_POST['key'];
            if (!$id) {
                die(json_encode($this->data['error']));
            } else {
                $this->load->model("form_model");
                $fille = $this->form_model->get_fille_in($id);
                $data = array(
                    'file' => $fille['name'],
                    'user' => $fille['user_name']
                );
                $this->new_log($this->data['user_id'], "Files10", "In House Other", $fm_id, json_encode($data, TRUE), "File Has Been Deleted");
                $this->form_model->remove_in($id);
                die("{}");
            }
        }

        public function remove_offer_in11($fm_id, $id) {
            $file_name = $_POST['key'];
            if (!$id) {
                die(json_encode($this->data['error']));
            } else {
                $this->load->model("form_model");
                $fille = $this->form_model->get_fille_in($id);
                $data = array(
                    'file' => $fille['name'],
                    'user' => $fille['user_name']
                );
                $this->new_log($this->data['user_id'], "Files11", "In House Other", $fm_id, json_encode($data, TRUE), "File Has Been Deleted");
                $this->form_model->remove_in($id);
                die("{}");
            }
        }

        public function remove_offer_in12($fm_id, $id) {
            $file_name = $_POST['key'];
            if (!$id) {
                die(json_encode($this->data['error']));
            } else {
                $this->load->model("form_model");
                $fille = $this->form_model->get_fille_in($id);
                $data = array(
                    'file' => $fille['name'],
                    'user' => $fille['user_name']
                );
                $this->new_log($this->data['user_id'], "Files12", "In House Other", $fm_id, json_encode($data, TRUE), "File Has Been Deleted");
                $this->form_model->remove_in($id);
                die("{}");
            }
        }

        public function index_in() {
    		    if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
                $this->load->model('hotels_model');
                $this->load->model('form_model');
                $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
                $hotels = array();
                foreach ($user_hotels as $hotel) {
                  	$hotels[] = $hotel['id'];
                }    
                $this->data['form'] = $this->form_model->view_in($hotels);
                $this->data['hotels'] = $user_hotels;
                $this->data['operators'] = $this->form_model->getall_operator();
                $this->load->view('form_in_index', $this->data);
            }else{
             	redirect('/unknown');
            }
        }

        public function comment_in($fm_id){
            if ($this->input->post('submit')) {
              	$this->load->library('form_validation');
              	$this->form_validation->set_rules('comment','Comment','trim|required');
                if ($this->form_validation->run() == TRUE) {
                  	$comment = $this->input->post('comment'); 
                  	$this->load->model('form_model');
                  	$comment_data = array(
	                    'user_id' => $this->data['user_id'],
	                    'fm_id' => $fm_id,
	                    'comment' => $comment
                  	);
                	$this->form_model->insertcomment_in($comment_data);
              	}
              	redirect('/form/view_in/'.$fm_id);
            }
        }

        public function report_in_uk(){
                if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
                $this->load->helper('form');
                $this->load->model('hotels_model');  
                $this->load->model('form_model');
                $this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
                $this->data['operators'] = $this->form_model->getall_operator();
                if ($this->input->post('submit')) {
                    $this->load->library('form_validation');
                    $this->form_validation->set_rules('type','Report Section is Required','trim|required');
                    $hotel_id = $this->input->post('hotel_id');
                    $operator_id = $this->input->post('operator_id');
                    $type = $this->input->post('type');
                    $from_date = $this->input->post('from');
                    $to_date = $this->input->post('to');
                    $answer = $this->input->post('answer');
                    $this->data['from'] = $from_date;
                    $this->data['to'] = $to_date;
                    $this->data['answer'] = $answer;
                    $this->data['type1'] = $type;
                    $this->data['hotel'] = $this->hotels_model->get_by_id($hotel_id);
                    $from_date .=" 00:00:00";
                    $to_date .=" 23:59:59";
                    //die(print_r($type));
                    if ($type == 1) {
                        $this->data['cases'] = $this->form_model->get_case_in_uk_type($hotel_id, $from_date, $to_date, $answer, $operator_id);
                        $this->data['cases_count'] = $this->form_model->get_case_in_uk_type_count($hotel_id, $from_date, $to_date, $answer, $operator_id);
                        $this->data['type'] = "In House Incident Report-UK";
                    }elseif ($type == 2) {
                        $this->data['cases'] = $this->form_model->get_case_in_type($hotel_id, $from_date, $to_date, $answer, $operator_id);
                        $this->data['cases_count'] = $this->form_model->get_case_in_type_count($hotel_id, $from_date, $to_date, $answer, $operator_id);
                        $this->data['type'] = "In House - other nationalities Incident Report";
                    }
                }
                $this->load->view('form_type_report_hotel', $this->data);
            }else{
                redirect('/unknown');
            }
        }

        public function report_all(){
                if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
                $this->load->helper('form');
                $this->load->model('hotels_model');  
                $this->load->model('form_model');
                $this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
                $this->data['operators'] = $this->form_model->getall_operator();
                if ($this->input->post('submit')) {
                    $hotel_id = $this->input->post('hotel_id');
                    $operator_id = $this->input->post('operator_id');
                    $from_date = $this->input->post('from');
                    $to_date = $this->input->post('to');
                    $answer = $this->input->post('answer');
                    $this->data['from'] = $from_date;
                    $this->data['to'] = $to_date;
                    $this->data['answer'] = $answer;
                    $from_date .=" 00:00:00";
                    $to_date .=" 23:59:59";
                    //die(print_r($to_date));
                    $this->data['hotel'] = $this->hotels_model->get_by_id($hotel_id);
                    //die(print_r($type));
                    $this->data['cases_uk'] = $this->form_model->get_case_in_uk_type($hotel_id, $from_date, $to_date, $answer, $operator_id);
                    $this->data['cases_uk_count'] = $this->form_model->get_case_in_uk_type_count($hotel_id, $from_date, $to_date, $answer, $operator_id);
                    $this->data['cases_other'] = $this->form_model->get_case_in_type($hotel_id, $from_date, $to_date, $answer, $operator_id);
                    $this->data['cases_other_count'] = $this->form_model->get_case_in_type_count($hotel_id, $from_date, $to_date, $answer, $operator_id);
                }
                $this->load->view('form_type_all_report_hotel', $this->data);
            }else{
                redirect('/unknown');
            }
        }
        public function report_ir_summary($all=""){
                if ((isset($this->data['is_UK']) && $this->data['is_UK']) || (isset($this->data['is_corp']) && $this->data['is_corp']) || (isset($this->data['is_rater']) && $this->data['is_rater']) || (isset($this->data['is_cluster']) && $this->data['is_cluster'])|| (isset($this->data['is_admin']) && $this->data['is_admin']) || (isset($this->data['role_id']) && ($this->data['role_id'] == 56)) || (isset($this->data['department_id']) && ($this->data['department_id'] == 2))) {
                $this->load->helper('form');
                $this->load->model('hotels_model');  
                $this->load->model('form_model');
                $this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
                $this->data['operators'] = $this->form_model->getall_operator();
                $this->data['all'] = $all;
                if ($this->input->post('submit')) {
                    $this->load->library('form_validation');
                    $this->form_validation->set_rules('type','Report Section is Required','trim|required');
                    $hotel_id = $this->input->post('hotel_id');
                    //$operator_id = $this->input->post('operator_id');
                    $type = $this->input->post('type');
                    $from_date = $this->input->post('from');
                    $to_date = $this->input->post('to');
                    $answer = $this->input->post('answer');
                    $this->data['from'] = $from_date;
                    $this->data['to'] = $to_date;
                    $this->data['answer'] = $answer;
                    $this->data['type1'] = $type;
                    $this->data['hotel'] = $this->hotels_model->get_by_id($hotel_id);
                    $from_date .=" 00:00:00";
                    $to_date .=" 23:59:59";
                    //die(print_r($type));
                    if ($type == 1) {
                        $this->data['cases'] = $this->form_model->get_case_ir_summary($hotel_id, $from_date, $to_date, $answer);

                        $this->data['cases_count'] = $this->form_model->get_case_ir_summary_count($hotel_id, $from_date, $to_date, $answer);
                        $this->data['type'] = "In House Incident Report-UK";
                    }elseif ($type == 2) {
                        $this->data['cases'] = $this->form_model->get_case_in_type($hotel_id, $from_date, $to_date, $answer);

                        $this->data['cases_count'] = $this->form_model->get_case_ir_summary_count($hotel_id, $from_date, $to_date, $answer);
                        $this->data['type'] = "In House - other nationalities Incident Report";
                    }
                }
                $this->load->view('form_ir_summary', $this->data);
            }else{
                redirect('/unknown');
            }
        }
  

    }

?>
