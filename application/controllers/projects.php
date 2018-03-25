<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Projects extends CI_Controller {
		
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
			}
			$this->data['menu']['active'] = "projects";
			$this->load->library('logger');
			$this->data['module_forms'] = array('0' => 1, '1' => 26);
			$this->load->model('chairman_approval_model');
          	$this->load->model('hotels_model');
          	$user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
          	$hotels = array();
          	foreach ($user_hotels as $hotel) {
            	$hotels[] = $hotel['id'];
          	}
          	array_push($hotels, 0);
          	$status = $this->data['module_forms'];
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
          	}else{
            	$states = $this->chairman_approval_model->get_state($status);
            	foreach ($states as $state) {
             		if ($this->data['role_id'] == 7) {
                		$forma = $this->chairman_approval_model->chairman_approval($state['database'], $this->data['department_id'], $hotels);
              		}else{
                		$forma = $this->chairman_approval_model->chairman_approval($state['database'], $this->data['role_id'], $hotels);
              		}
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
        	$this->data['states'] = $this->chairman_approval_model->get_states();
        	$this->data['counter'] = $counter;
		}

		public function index($state = FALSE) {
			if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
	      		redirect('/unknown');
	    	}else{
				if ($state == 12) {
					$states = array($state);
				} else if ($state == 4) {
					$states = array(4,33);
				} else if ($state == 7) {
					$states = array(7,8,9);
				} else {
					$states = array(4,5,6,7,8,9,12,33);
				}
				$this->load->model('hotels_model');
				$user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
				$hotels = array();
				foreach ($user_hotels as $hotel) {
					$hotels[] = $hotel['id'];
				}
				$this->load->model('projects_model');
				$this->load->model('projects_change_model');
				$this->data['projects'] = $this->projects_model->get_projects($states, $hotels,0);
				foreach ($this->data['projects'] as $key => $project) {
					if ($this->data['projects'][$key]['change_amend'] == 1) {
						$this->data['project_change'] = $this->projects_change_model->get_project($this->data['projects'][$key]['id']);
					}
					$this->data['projects'][$key]['approvals'] = $this->get_signers($this->data['projects'][$key]['id'], $this->data['projects'][$key]['hotel_id'], $this->data['projects'][$key]['change_amend']);
				}
				$this->data['hotels'] = $this->hotels_model->getall();
				$user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
				$this->data['isGM'] = ($user->role_id == 6)? TRUE : FALSE;
				$this->data['isDptHead'] = ($user->role_id == 7)? TRUE : FALSE;
				$this->data['submenu']['active'] = "projects";
				$this->load->view('projects', $this->data);
			}
		}

		public function index_replacement($replaced,$state = FALSE) {
			if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
	      		redirect('/unknown');
	    	}else{
				if ($state == 12) {
					$states = array($state);
				} else if ($state == 4) {
					$states = array(4,33);
				} else if ($state == 7) {
					$states = array(7,8,9);
				} else {
					$states = array(4,5,6,7,8,9,12,33);
				}
				$this->load->model('hotels_model');
				$user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
				$hotels = array();
				foreach ($user_hotels as $hotel) {
					$hotels[] = $hotel['id'];
				}
				$this->load->model('projects_model');
				$this->load->model('projects_change_model');
				$this->data['projects'] = $this->projects_model->get_projects($states, $hotels,$replaced);
				foreach ($this->data['projects'] as $key => $project) {
					if ($this->data['projects'][$key]['change_amend'] == 1) {
						$this->data['project_change'] = $this->projects_change_model->get_project($this->data['projects'][$key]['id']);
					}
					$this->data['projects'][$key]['approvals'] = $this->get_signers($this->data['projects'][$key]['id'], $this->data['projects'][$key]['hotel_id'], $this->data['projects'][$key]['change_amend']);
				}
				$this->data['hotels'] = $this->hotels_model->getall();
				$user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
				$this->data['isGM'] = ($user->role_id == 6)? TRUE : FALSE;
				$this->data['isDptHead'] = ($user->role_id == 7)? TRUE : FALSE;
				$this->data['submenu']['active'] = "projects";
				$this->load->view('projects_replacement', $this->data);
			}
		}


		public function prepare() {
			if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
	      		redirect('/unknown');
	    	}else{
				if ($this->input->post('submit')) {
					$this->load->library('form_validation');
					$this->form_validation->set_rules('hotel','Hotel','trim|required');
					$this->form_validation->set_rules('year','Year','trim|required');
					$this->form_validation->set_rules('department','Department','trim|required');
					if ($this->form_validation->run() == TRUE) {
						$hotel_id = $this->input->post('hotel');
						$year = $this->input->post('year');
						$department_id = $this->input->post('department');
						redirect('/projects/itemize/'.$hotel_id.'/'.$year.'/'.$department_id);
					}
				}
				$this->load->helper('form');
				$this->load->model('hotels_model');
				$this->load->model('departments_model');
				$this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());
				$this->data['departments'] = $this->departments_model->getall();
				$this->load->view('project_prepare',$this->data);
			}
		}	

		public function itemize($hotel_id, $year, $department_id) {
			if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
	      		redirect('/unknown');
	    	}else{
				$this->load->helper('form');
				if ($this->input->post('submit')) {
					$this->load->library('form_validation');
					$this->form_validation->set_rules('items[]','Items','trim|required');
					if ($this->form_validation->run() == TRUE) {
						$items = $this->input->post('items');
						redirect('/projects/planned/'.$hotel_id.'/'.$year.'/'.$department_id.'/'.implode('.', $items));
					}
				}
				$this->data['items'] = $this->get_available_items($hotel_id, $year, $department_id);
				$this->load->view('project_itemize',$this->data);
			}
		}

		private function get_available_items($hotel_id, $year, $department_id) {
			$this->load->model('plans_model');
			$this->load->model('plan_items_model');
			$plan = $this->plans_model->get_hotel_plan($hotel_id, $year, TRUE);
			$items = $this->plan_items_model->get_selective_items($plan['id'], $department_id);
			return $items;
		}

		public function planned($hotel_id, $year, $department_id, $items) {
			if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
	      		redirect('/unknown');
	    	}else{
				if ($this->input->post('submit')) {
					$this->load->library('form_validation');
					$this->form_validation->set_rules('hotel','Hotel','trim|required');
					$this->form_validation->set_rules('department','Department','trim|required');
					$this->form_validation->set_rules('type','Project Type','trim|required');
			    	$this->form_validation->set_rules('name','Project Name','trim|required');
			    	$this->form_validation->set_rules('reason','Reason','trim|required');
					$this->form_validation->set_rules('scope','Scope of project','trim');
					$this->form_validation->set_rules('supplier[]','Suppliers','trim');
					$this->form_validation->set_rules('eur_ex','EUR exchange rate','trim|number');
					$this->form_validation->set_rules('usd_ex','USD exchange rate','trim|number');
					$this->form_validation->set_rules('budget','Budget cost','trim|number|required');
					$this->form_validation->set_rules('budget_egp','Budget cost in EGP','trim|number');
					$this->form_validation->set_rules('budget_usd','Budget cost in USD','trim|number');
					$this->form_validation->set_rules('budget_eur','Budget cost in EUR','trim|number');
					$this->form_validation->set_rules('cost','Final cost','trim|number');
					$this->form_validation->set_rules('cost_egp','Final cost in EGP','trim|number');
					$this->form_validation->set_rules('cost_usd','Final cost in USD','trim|number');
					$this->form_validation->set_rules('cost_eur','Final cost in EUR','trim|number');
					$this->form_validation->set_rules('start-date','Project Start Date','trim|required');
					$this->form_validation->set_rules('end-date','Project End Date','trim|required');
					$this->form_validation->set_rules('year','Project year','trim|required');
			    	$this->form_validation->set_rules('remarks','Remarks','trim');
			    	$assumed_code = $this->input->post('assumed_code');
			    	if ($this->form_validation->run() == TRUE) {
			    		$this->load->model('projects_model');
			    		$project_data = array(
			    			'user_id' => $this->data['user_id'],
			    			'hotel_id' => $this->input->post('hotel'),
			    			'origin_id' => 2,
			    			'type_id' => $this->input->post('type'),
			    			'department_id' => $this->input->post('department'),
			    			'code' => $assumed_code,
			    			'name' => $this->input->post('name'),
			    			'reasons' => $this->input->post('reason'),
			    			'scope' => $this->input->post('scope'),
			    			'EUR_EX' => $this->input->post('eur_ex'),
			    			'USD_EX' => $this->input->post('usd_ex'),
			    			'budget_EGP' => $this->input->post('budget_egp'),
			    			'budget_USD' => $this->input->post('budget_usd'),
			    			'budget_EUR' => $this->input->post('budget_eur'),
			    			'budget' => $this->input->post('budget'),
			    			'cost_EGP' => $this->input->post('cost_egp'),
			    			'cost_USD' => $this->input->post('cost_usd'),
			    			'cost_EUR' => $this->input->post('cost_eur'),
			    			'cost' => $this->input->post('cost'),
			    			'start' => $this->input->post('start-date'),
			    			'end' => $this->input->post('end-date'),
			    			'year' => $this->input->post('year'),
			    			'remarks' => $this->input->post('remarks'),
			    			'state_id' => 3
			    		);
			    		$project_id = $this->projects_model->create($project_data);
			    		if (!isset($project_id)) {
			    			die("ERROR");
			    		}
			    		if($project_id){
			    			if($this->input->post('replaces')){
                                foreach ($this->input->post('replaces') as $replace) {
                                	$replace['user_id'] = $this->data['user_id'];
                                	$replace['project_id'] = $project_id;
                                    $replace_id = $this->projects_model->create_replace($replace);	
                                      if ($replace_id) {
	                                	$this->projects_model->projects_replaced($project_id,1);
	                                }else{
                                           die("ERROR");
	                                }
				    			}
				    		}
				    	}
			    		$this->load->model('offers_model');
			    		$this->offers_model->update_offers($assumed_code, $project_id);
			    		$this->load->model('suppliers_model');
						$this->suppliers_model->clear($project_id, 0);
			    		foreach ($this->input->post('supplier') as $supplier) {
		    				$this->suppliers_model->add($project_id, $supplier, 0);
			    		}
			    		$this->load->model('project_items_model');
			    		$this->load->model('plan_items_model');
			    		foreach ($this->input->post('item') as $item_id => $item) {
			    			$this->project_items_model->create(array( 'project_id' => $project_id, 'item_id' => $item_id, 'quantity' => $item));
			    			$this->plan_items_model->used($item_id, $item);
			    		}
		    			$this->load->model('hotel_planned_signatures_model');
		    			$this->load->model('project_signatures_model');
		    			$hotel_signatures = $this->hotel_planned_signatures_model->getby_hotel($project_data['hotel_id']);
		    			$final_signatures = $this->manipulate_signatures(TRUE, $department_id, $hotel_signatures, $project_data['cost'], FALSE, FALSE);
		    			foreach ($final_signatures as $hotel_signature) {
		    				$this->project_signatures_model->add_project_signature($project_id, $hotel_signature['role_id'], $hotel_signature['rank'], 0);
		    			}
		    			$project_data['suppliers'] = $this->input->post('supplier');
						$this->logger->log_event($this->data['user_id'], "Planned", "projects", $project_id, json_encode($project_data, TRUE), "user created project (planned)");//log
			    		redirect('/projects/project_stage/'.$project_id);
		    		}
				}
				try {
					$this->load->helper('form');
					$this->load->model('plan_items_model');
					$this->load->model('suppliers_model');
					$this->load->model('hotels_model');
					$this->load->model('departments_model');
					$this->load->model('types_model');
					$this->load->model('origins_model');
					$this->data['hotel'] = $this->hotels_model->get_by_id($hotel_id);
					$this->data['department'] = $this->departments_model->get_by_id($department_id);
					$this->data['departments'] = $this->departments_model->getall();
					$this->data['year'] = $year;
					$this->data['suppliers'] = $this->suppliers_model->getall();
					$this->data['items'] = $this->plan_items_model->get_items_by_id(explode('.', $items));
					$this->data['types'] = $this->types_model->getall();
					$this->data['origins'] = $this->origins_model->getall();
					$this->data['selected_origin'] = 2;
					if ($this->input->post('submit')) {
						$this->load->model('offers_model');
						$this->data['assumed_code'] = $this->input->post('assumed_code');
						$this->data['offers'] = $this->offers_model->getby_project($this->data['assumed_code'], 0);
					} else {
						$this->data['assumed_code'] = "NO".strtoupper(str_pad(dechex( mt_rand( 50, 1048579999 ) ), 6, '0', STR_PAD_LEFT));
						$this->data['offers'] = array();
					}
					$this->load->view('project_planned',$this->data);
				}
				catch( Exception $e) {
					show_error($e->getMessage()." _ ". $e->getTraceAsString());
				}
			}
		}

		private function manipulate_signatures($planned, $department_id, $signatures, $budget, $new, $change) {
			if ($change) {
				foreach ($signatures as $key => $sign) {
					if ($sign['role_id'] != 4 &&$sign['role_id'] != 17 && $sign['role_id'] != 3 && $sign['role_id'] != 16 && $sign['role_id'] != 27 && $sign['role_id'] != 1) {
						unset($signatures[$key]);
					}
				}
			}
			if ($department_id != 2) {
				foreach ($signatures as $key => $sign) {
					if ($sign['role_id'] == 18) {
						unset($signatures[$key]);
					}
				}
			}
			if ($new != 1 && $department_id != 6) {
				foreach ($signatures as $key => $sign) {
					if ($sign['role_id'] == 140) {
						unset($signatures[$key]);
					}
				}
			}
			if ($planned) {
				$this->load->model('planned_limitations_model');
				$limitations = $this->planned_limitations_model->getall();
			} else {
				$this->load->model('unplanned_limitations_model');
				$limitations = $this->unplanned_limitations_model->getall();
			}
			if ($department_id != 6) {
				foreach ($limitations as $limit) {
					if ($budget <= $limit['limit']) {
						foreach ($signatures as $key => $sign) {
							if ($sign['role_id'] == $limit['role_id']) {
								unset($signatures[$key]);
							}
						}
					}
				}
			}
			return $signatures;
		}

		public function project_stage($id) {
			$this->load->model('projects_model');
			$this->load->model('projects_owning_model');
			$this->load->model('projects_change_model');
			$project = $this->projects_model->get_project($id);
			if ($project['change_amend'] == 1) {
				$this->data['project'] = $this->projects_change_model->get_project($id);
			}else{
				$this->data['project'] = $project;
			}
			if ($this->data['project']['state_id'] == 33) {
				$this->notify_purchasing($project['code'], $project['hotel_id']);
			} elseif ($this->data['project']['state_id'] == 12) {
				$this->notify_owner($project['code']);
			} elseif ($this->data['project']['state_id'] == 4) {
				$queue = $this->notify_signers($id, $project['code']);
				if (!$queue) {
					if ($project['change_amend'] == 1) {
						$this->projects_change_model->update_state($id, 7);
					}else{
						$this->projects_model->update_stage($id);
					}
					$this->projects_model->update_final($id, 0);
					$this->projects_owning_model->update_final($id, 0);
					$this->notify_owner($project['code'], TRUE);
					$this->logger->log_event($this->data['user_id'], "Stage", "projects", $id, json_encode(array("state" => "Approved")), "project state updated, owner notified");//log
					redirect('/projects/project_stage/'.$id);
				}
			} elseif ($this->data['project']['state_id'] == 3) {
				$this->projects_model->update_state($id, 33);
				$this->logger->log_event($this->data['user_id'], "Stage", "projects", $id, json_encode(array("state" => "Purchasing")), "project state updated, purchasing should be notified");//log
				redirect('/projects/project_stage/'.$id);
			}
			redirect('/projects/view/'.$project['code']);
		}

		private function notify_purchasing($code, $hotel_id) {
			$users = $this->users_model->getby_criteria(19, $hotel_id);
			foreach ($users as $use) {
				$this->purchasing_mail($use['email'], $code);
			}
			return TRUE;
		}

		private function purchasing_mail($mail, $project_code) {
			$this->load->library('email');
			$this->load->helper('url');
			$this->email->from('e-signature@sunrise-resorts.com');
			$this->email->to($mail);
			$this->email->subject("Project {$project_code}");
			$project_url = base_url().'projects/purchasing/'.$project_code;
			$this->email->message("
				project {$project_code} is waiting for offers, please use the link below.
				<br />
				<a href='{$project_url}' target='_blank'>{$project_url}</a>
				<br/>
			");	
			$mail_result = $this->email->send();
		}

		private function notify_owner($code, $approved = FALSE) {
			$user = $this->users_model->get_user_by_id($this->data['project']['user_id'], TRUE);
			$this->owner_mail($user->fullname, $user->email, $code, $approved);
			return TRUE;
		}

		private function owner_mail($name, $mail, $project_code, $approved) {
			$this->load->library('email');
			$this->load->helper('url');
			$this->email->from('e-signature@sunrise-resorts.com');
			$this->email->to($mail);
			$this->email->subject("Project {$project_code}");
			$project_url = base_url().'projects/view/'.$project_code;
			if (!$approved) {
				$this->email->message("
					Dear {$name},
					<br/>
					<br/>
					Your project {$project_code} has been rejected.
					<br />
					<a href='{$project_url}' target='_blank'>{$project_url}</a>
					<br/>
				");	
			} else {
				$this->email->message("
					Dear {$name},
					<br/>
					<br/>
					Your project {$project_code} has been approved.
					<br />
					<a href='{$project_url}' target='_blank'>{$project_url}</a>
					<br/>
				");	
			}
			$mail_result = $this->email->send();
		}

		private function notify_signers($project_id, $code) {
			$this->load->model('projects_model');
			$notified = FALSE;
			$this->load->model('projects_model');
			$this->load->model('projects_change_model');
			$project = $this->projects_model->get_project($project_id);
			if ($project['change_amend'] == 1) {
				$this->data['project'] = $this->projects_change_model->get_project($project_id);
			}else{
				$this->data['project'] = $project;
			}
			$name = $this->data['project']['project_name'];
			$project_url = base_url().'projects/view/'.$code;
			$message = "project {$code} ({$name})
					{$project_url}";	
			$signers = $this->get_signers($project_id, $project['hotel_id'], $project['change_amend']);
			foreach ($signers as $signer) {
				if (isset($signer['queue'])) {
					$notified = TRUE;
					if (count($signer['queue']) == 0) {
						$this->admin_alert($code, $signer['role'], $this->data['project']['hotel_name']);
					} else {
						$this->projects_model->update_final($project_id, $signer['role_id']);
						foreach ($signer['queue'] as $uid => $user) {
							 if ($signer['role_id']!=1) {
								$this->onclick($message, $project_id, $user['channel']);
								$this->signatures_mail($signer['role'], $user['name'], $user['mail'], $code);
							 }
							$this->logger->log_event($this->data['user_id'], "Notify", "projects", $project_id, json_encode(array("to" => $user['mail'])), "Project signature notification sent");
						}
					}
					break;
				}
			}
			return $notified;
		}

		private function get_signers($project_id, $hotel_id, $change_amend) {
			$this->load->model('project_signatures_model');
			$this->load->model('users_model');
			$signers = array();
			$signatures = $this->project_signatures_model->getby_project_verbal($project_id, $change_amend);
			foreach ($signatures as $signature) {
				$signers[$signature['id']] = array();
				$signers[$signature['id']]['role'] = $signature['role'];
				$signers[$signature['id']]['role_id'] = $signature['role_id'];
				if ($signature['user_id']) {
					$signers[$signature['id']]['sign'] = array();
					$signers[$signature['id']]['sign']['id'] = $signature['user_id'];
					if ($signature['reject'] == 1) {
						$signers[$signature['id']]['sign']['reject'] = "reject";
					} 
					$user = $this->users_model->get_user_by_id($signature['user_id'], TRUE);
					$signers[$signature['id']]['sign']['name'] = $user->fullname;
					$signers[$signature['id']]['sign']['mail'] = $user->email;
					$signers[$signature['id']]['sign']['channel'] = $user->channel;
					$signers[$signature['id']]['sign']['sign'] = $user->signature;
					$signers[$signature['id']]['sign']['timestamp'] = $signature['timestamp'];
				} else {
					$signers[$signature['id']]['queue'] = array();
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
		          } else {
					if ($signature['role_id'] == 20) {
						$users = $this->users_model->getby_criteria(7, $hotel_id, 4);
					} else {
						$users = $this->users_model->getby_criteria($signature['role_id'], $hotel_id);
					}
					foreach ($users as $use) {
						$signers[$signature['id']]['queue'][$use['id']] = array();
						$signers[$signature['id']]['queue'][$use['id']]['name'] = $use['fullname'];
						$signers[$signature['id']]['queue'][$use['id']]['mail'] = $use['email'];
						$signers[$signature['id']]['queue'][$use['id']]['channel'] = $use['channel'];
					}
				}
			}
		}
			return $signers;
			//die(print_r($signers));
		}

		function admin_alert($code, $role, $hotel) {
			$this->load->library('email');
			$this->load->helper('url');
			$project_url = base_url().'projects/view/'.$code;
			$this->email->from('e-signature@sunrise-resorts.com');
			$this->email->to('abbas.elshabasy@sunrise-resorts.com');
			$this->email->cc('hany.hisham@sunrise-resorts.com');
			$this->email->subject("Project {$code} missing {$role}");
			$this->email->message("Project {$code} for {$hotel} is pending on {$role} signature, no user is currently assigned
				<br/>
				<a href='{$project_url}' target='_blank'>{$project_url}</a>
				<br/>
			");	
			$mail_result = $this->email->send();
		}

		private function signatures_mail($role, $name, $mail, $code) {
			$this->load->library('email');
			$this->load->helper('url');
			$project_url = base_url().'projects/view/'.$code;
			$this->email->from('e-signature@sunrise-resorts.com');
			$this->email->to($mail);
			$this->email->subject("Project {$code}");
			$this->email->message("Dear {$name},
				<br/>
				<br/>
				Project {$code} requires your signature, Please use the link below:
				<br/>
				<a href='{$project_url}' target='_blank'>{$project_url}</a>
				<br/>
			");	
			$mail_result = $this->email->send();
		}

		public function view($code) {
			if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
	      		redirect('/unknown');
	    	}else{
				$this->load->model('projects_model');
				$this->load->model('suppliers_model');
				$this->load->model('offers_model');
				$this->load->model("project_comments_model");
				$this->load->model("project_items_model");
				$this->load->model("projects_change_model");
				$this->data['project'] = $this->projects_model->get_project(FALSE, $code);
				if($this->data['project']['replaced']==1){
					$this->data['project_replace_items'] = $this->projects_model->get_project_replaced($this->data['project']['id']);
				}
				$this->data['signers'] = $this->get_signers($this->data['project']['id'], $this->data['project']['hotel_id'], 0);
				$this->data['signature_path'] = '/assets/uploads/signatures/';
				$this->data['suppliers'] = $this->suppliers_model->getby_project($this->data['project']['id'], 0);
				$this->data['offers'] = $this->offers_model->getby_project($this->data['project']['id'], 0);
				$this->data['chairman_after']=$this->projects_model->chairman_after_kfahmy($this->data['project']['id']);
				$this->data['comments'] = $this->project_comments_model->getby_project($this->data['project']['id']);
				if ($this->data['project']['origin_id'] == 2) {
					$this->data['items'] = $this->project_items_model->get_items_details($this->data['project']['id']);
				}
				if ($this->data['project']['change_amend'] == 1) {
					$this->data['project_change'] = $this->projects_change_model->get_project($this->data['project']['id']);
					$this->data['signers_change'] = $this->get_signers($this->data['project']['id'], $this->data['project']['hotel_id'], 1);
					$this->data['suppliers_change'] = $this->suppliers_model->getby_project($this->data['project']['id'], 1);
					$this->data['offers_change'] = $this->offers_model->getby_project($this->data['project']['id'], 1);
				}
				$change = FALSE;
				$unsign_enable = FALSE;
				$purchasing_done = FALSE;
				$force_edit = FALSE;
				$first = TRUE;
				if ($this->data['project']['change_amend'] == 1) {
					$project_staged = in_array($this->data['project_change']['state_id'], array(7,8,9,12));
					$project_approved = in_array($this->data['project_change']['state_id'], array(7,8,9));
					$project_rejected = in_array($this->data['project_change']['state_id'], array(12));
					$signers = $this->data['signers_change'];
				}else{
					$project_staged = in_array($this->data['project']['state_id'], array(7,8,9,12));
					$project_approved = in_array($this->data['project']['state_id'], array(7,8,9));
					$project_rejected = in_array($this->data['project']['state_id'], array(12));
					$signers = $this->data['signers'];
				}
				foreach ($signers as $signer) {
					if (isset($signer['sign'])) {
						$unsign_enable = FALSE;
						$force_edit = FALSE;
						if ( $signer['role_id'] == 19 ) {
							$purchasing_done = TRUE;
						}
						if ($signer['role_id'] == 17 ) {
							$change = TRUE;
						}
						if ($signer['sign']['id'] == $this->data['user_id']) {
							if ($first) {
								$force_edit = TRUE;
								$unsign_enable = FALSE;
							} else {
								$force_edit = FALSE;
								$unsign_enable = TRUE;
							}
						}
					}
					$first = FALSE;
				}
				$this->data['project_code'] = $code;
				$this->data['purchasing'] = (($this->data['department_id'] == 28 && !$purchasing_done && !$project_rejected) || $this->data['is_admin'])? TRUE : FALSE;
				$this->data['unsign_enable'] = (($unsign_enable && !$project_approved) || $this->data['is_admin'])? TRUE : FALSE;
				$this->data['is_editor'] = ((!$change) || $this->data['is_admin'])? TRUE : FALSE;
				$this->data['is_change'] = (($change) || $this->data['is_admin'])? TRUE : FALSE;
				$this->load->view('project_view', $this->data);
			}
		}

		public function make_offer($project_id, $change) {
			$file_name = $this->do_upload("offers");
			if (!$file_name) {
				die(json_encode($this->data['error']));
			} else {
				$this->load->model("offers_model");
				$this->offers_model->add($project_id, $file_name, $change);
				$this->logger->log_event($this->data['user_id'], "Offer", "projects", $project_id, json_encode(array("offer_name" => $file_name)), "user uploaded an offer");//log
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
			}else {
				$file = $this->upload->data();
				return $file['file_name'];
			}
		}

		public function purchasing($code = FALSE) {
			if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
	      		redirect('/unknown');
	    	}else{
	    		$this->load->model('projects_model');
				$this->load->model('projects_change_model');
				$project = $this->projects_model->get_project(FALSE, $code);
				if ($this->input->post('submit')) {
					$this->load->library('form_validation');
					$this->form_validation->set_rules('supplier[]','Suppliers','trim|required');
					$this->form_validation->set_rules('cost_egp','Final cost in EGP','trim|number');
					$this->form_validation->set_rules('cost_usd','Final cost in USD','trim|number');
					$this->form_validation->set_rules('cost_eur','Final cost in EUR','trim|number');
		    		if ($this->form_validation->run() == TRUE) {
		    			$project_data = array(
		    				'cost' => $this->input->post('cost'),
		    				'cost_EGP' => $this->input->post('cost_egp'),
		    				'cost_USD' => $this->input->post('cost_usd'),
		    				'cost_EUR' => $this->input->post('cost_eur'),
		    				'state_id' => 4
		    			);
		    			$project_id = $this->projects_model->update_by_code($code, $project_data);
		    			if (!isset($project_id)) {
		    				die("ERROR");
		    			}
		    			$this->load->model('suppliers_model');
		    			$this->suppliers_model->clear($project['id'], $project['change_amend']);
			    		foreach ($this->input->post('supplier') as $supplier) {
			    			$this->suppliers_model->add($project['id'], $supplier, $project['change_amend']);
			    		}
		    			$this->edit_process_signatures($project['id']);
	    				$project_data['suppliers'] = $this->input->post('supplier');
						$this->logger->log_event($this->data['user_id'], "Purchasing_Edit", "projects", $project['id'], json_encode($project_data, TRUE), "Purchasing employee visited this project, State updated to 4, signature updated accordingly");
		    			redirect('/projects/project_stage/'.$project['id']);
		    		}
				}
				try {
					$this->load->helper('form');
					$this->load->model('projects_model');
					$this->load->model('suppliers_model');
					$this->load->model('offers_model');
					$this->data['project'] = $project;
					$this->data['suppliers'] = $this->suppliers_model->getall();
					if ($project['origin_id'] == 2) {
						$this->load->model('project_items_model');
						$this->data['items'] = $this->project_items_model->get_items_details($project['id']);
					}
					$this->data['offers'] = $this->offers_model->getby_project($project['id'], $project['change_amend']);
					$this->data['selected_suppliers'] = $this->suppliers_model->getby_project($project['id'], $project['change_amend']);
					$this->load->view('project_purchasing',$this->data);
				}
				catch( Exception $e) {
					show_error($e->getMessage()." _ ". $e->getTraceAsString());
				}
			}
		}

		private function edit_process_signatures($project_id) {
			$project = $this->projects_model->get_project($project_id);
			if ($project['change_amend'] == 1) {
				$this->data['project'] = $this->projects_change_model->get_project($project_id);
			}else{
				$this->data['project'] = $project;
			}
			$this->load->model('hotel_planned_signatures_model');
		    $hotel_signatures = $this->hotel_planned_signatures_model->getby_hotel($project['hotel_id']);
		    $hisham = 0;
		    foreach ($hotel_signatures as $hotel_signature) {
		    	if ($hotel_signature['role_id'] == 27) {
					$hisham = 1;
				}
		    }
			$budget = $this->data['project']['cost'];
			$signatures = $this->get_signers($project_id, $project['hotel_id'], $project['change_amend']);
			if ($this->data['project']['origin_id'] == 2) {
				$this->load->model('planned_limitations_model');
				$limitations = $this->planned_limitations_model->getall();
			} else {
				$this->load->model('unplanned_limitations_model');
				$limitations = $this->unplanned_limitations_model->getall();
			}
			$this->load->model("project_signatures_model");
			$rank = 100;
			foreach ($limitations as $limit) {
				$exists = 0;
				foreach ($signatures as $sKey => $sign) {
					if ($limit['role_id'] == $sign['role_id']) {
						$exists = $sKey;
						echo "exists";
					}
				}
				if ( $budget <= $limit['limit'] && $exists > 0 ) {
					$this->project_signatures_model->unset_project_signature($exists);
				} elseif ($budget > $limit['limit'] && $exists == 0) {
					if ($limit['role_id'] == 27 && $hisham == 1) {
						$this->project_signatures_model->add_project_signature($project_id, $limit['role_id'], $rank++, $project['change_amend']);
					}elseif ($limit['role_id'] != 27) {
						$this->project_signatures_model->add_project_signature($project_id, $limit['role_id'], $rank++, $project['change_amend']);
					}
				}
			}
			return TRUE;
		}

		public function edit($code) {
			if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
	      		redirect('/unknown');
	    	}else{
	    		$this->load->model('projects_model');
	    		$this->load->model('projects_change_model');
				$project = $this->projects_model->get_project(FALSE, $code);
				if ($this->input->post('submit')) {
					$this->load->library('form_validation');
					if ($project['change_amend'] == 0) {
						$this->form_validation->set_rules('type','Project Type','trim');
					}
			    	$this->form_validation->set_rules('name','Project Name','trim');
			    	$this->form_validation->set_rules('reason','Reason','trim');
			    	$this->form_validation->set_rules('remarks','Remarks','trim');
					$this->form_validation->set_rules('scope','Scope of project','trim');
					$this->form_validation->set_rules('supplier[]','Suppliers','trim');
					$this->form_validation->set_rules('cost_egp','Final cost in EGP','trim|number');
					$this->form_validation->set_rules('cost_usd','Final cost in USD','trim|number');
					$this->form_validation->set_rules('cost_eur','Final cost in EUR','trim|number');
					$this->form_validation->set_rules('start-date','Project Start Date','trim');
					$this->form_validation->set_rules('end-date','Project End Date','trim');
					$this->form_validation->set_rules('year','Project year','trim|required');
			    	$this->form_validation->set_rules('remarks','Remarks','trim');
		    		if ($this->form_validation->run() == TRUE) {
		    			$project_data = array();
						
						if ($project['change_amend'] == 0) {
							$project_data['charge'] = $this->input->post('charge');
							$project_data['life_year'] = $this->input->post('life_year');
							$project_data['life_month'] = $this->input->post('life_month');
							$project_data['type_id'] = $this->input->post('type');
						}elseif ($project['change_amend'] == 1) {
							$project_ids = $this->input->post('id');
						}
						$project_data['reasons'] = $this->input->post('reason');
						$project_data['cost_EGP'] = $this->input->post('cost_egp');
						$project_data['cost_USD'] = $this->input->post('cost_usd');
						$project_data['cost_EUR'] = $this->input->post('cost_eur');
						$project_data['cost'] = $this->input->post('cost');
						$project_data['start'] = $this->input->post('start-date');
						$project_data['end'] = $this->input->post('end-date');
						$project_data['remarks'] = $this->input->post('remarks');
		    			if ($project['change_amend'] == 1) {
		    				$project_id = $this->projects_change_model->update_by_code($project_ids, $project_data);
		    			}else{
		    				$project_id = $this->projects_model->update_by_code($code, $project_data);
		    			}
			    		if (!isset($project_id)) {
			    			die("ERROR");
			    		}
		    			$this->load->model('suppliers_model');
		    			$suppliers = $this->input->post('supplier');
		    			if (!empty($suppliers)) {
			    			$this->suppliers_model->clear($project['id'], $project['change_amend']);
				    		foreach ($suppliers as $supplier) {
				    			$this->suppliers_model->add($project['id'], $supplier, $project['change_amend']);
				    		}
		    			}
		    			$this->edit_process_signatures($project['id']);
	    				$project_data['suppliers'] = $this->input->post('supplier');
						$this->logger->log_event($this->data['user_id'], "Edit", "projects", $project['id'], json_encode($project_data, TRUE), "user edited project, signature modified");
						$this->notify_approved_signers($project['id'], $project['hotel_id'], $code, "Edited", $project['change_amend']);
		    			redirect('/projects/project_stage/'.$project['id']);
		    		}
				}
				try {
					$this->load->helper('form');
					$this->load->model('projects_model');
					$this->load->model('suppliers_model');
					$this->load->model('offers_model');
					$this->load->model('types_model');
					$this->data['types'] = $this->types_model->getall();
					$this->data['project'] = $this->projects_model->get_project(FALSE, $code);
					if ($this->data['project']['change_amend'] == 1) {
						$this->data['project_change'] = $this->projects_change_model->get_project($this->data['project']['id']);
					}
					if($this->data['project']['replaced']==1){
					$this->data['project_replace_items'] = $this->projects_model->get_project_replaced($this->data['project']['id']);
				}
					$this->data['suppliers'] = $this->suppliers_model->getall();
					if ($project['origin_id'] == 2) {
						$this->load->model('project_items_model');
						$this->data['items'] = $this->project_items_model->get_items_details($project['id']);
					}
					$this->data['offers'] = $this->offers_model->getby_project($project['id'], $project['change_amend']);
					$this->data['selected_suppliers'] = $this->suppliers_model->getby_project($project['id'], $project['change_amend']);
					$this->load->view('project_edit',$this->data);
				}
				catch( Exception $e) {
					show_error($e->getMessage()." _ ". $e->getTraceAsString());
				}
			}
		}

		private function notify_approved_signers($project_id, $hotel_id, $code, $action, $change) {
			$notified = FALSE;
			$signers = $this->get_signers($project_id, $hotel_id, $change);
			foreach ($signers as $signer) {
				if (isset($signer['sign'])) {
					$this->approved_signatures_mail($signer['role'], $signer['sign']['name'], $signer['sign']['mail'], $code, $action);
					$this->logger->log_event($this->data['user_id'], "Notify", "projects", $project_id, json_encode(array("to" =>  $signer['sign']['mail'])), "Project signature notification sent");//log
				}
			}
		}

		private function approved_signatures_mail($role, $name, $mail, $code, $action) {
			$this->load->library('email');
			$this->load->helper('url');
			$user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
			$project_url = base_url().'projects/view/'.$code;
			$this->email->from('e-signature@sunrise-resorts.com');
			$this->email->to($mail);
			$this->email->subject("Project {$code}");
			$this->email->message("
				Dear {$name},
				<br/>
				<br/>
				Project {$code} has been {$action} by {$user->fullname}, Please use the link below:
				<br/>
				<a href='{$project_url}' target='_blank'>{$project_url}</a>
				<br/>
			");	
			$mail_result = $this->email->send();
		}

		public function remove_offer($project_id, $id) {
			$file_name = $_POST['key'];
			if (!$id) {
				die(json_encode($this->data['error']));
			} else {
				$this->load->model("offers_model");
				$this->offers_model->remove($id);
				$this->logger->log_event($this->data['user_id'], "Offer-Remove", "projects", $project_id, json_encode(array("offer_id" => $id, "file_name" => $file_name)), "user removed an offer");
				die("{}");
			}
		}

		public function change($code) {
			if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
	      		redirect('/unknown');
	    	}else{
	    		$this->load->model('projects_model');
	    		$this->load->model('projects_change_model');
				$project = $this->projects_model->get_project(FALSE, $code);
				if ($project['change_amend'] == 1) {
					$project_change = $this->projects_change_model->get_project($project['id']);
					$this->projects_change_model->delete_project($project_change['id']);
				}
				if ($this->input->post('submit')) {
					$this->load->library('form_validation');
			    	$this->form_validation->set_rules('name','Project Name','trim|required');
			    	$this->form_validation->set_rules('reason','Reason','trim|required');
					$this->form_validation->set_rules('scope','Scope of project','trim');
					$this->form_validation->set_rules('supplier[]','Suppliers','trim');
					$this->form_validation->set_rules('eur_ex','EUR exchange rate','trim|number');
					$this->form_validation->set_rules('usd_ex','USD exchange rate','trim|number');
					$this->form_validation->set_rules('budget','Budget cost','trim|number|required');
					$this->form_validation->set_rules('budget_egp','Budget cost in EGP','trim|number');
					$this->form_validation->set_rules('budget_usd','Budget cost in USD','trim|number');
					$this->form_validation->set_rules('budget_eur','Budget cost in EUR','trim|number');
					$this->form_validation->set_rules('cost','Final cost','trim|number');
					$this->form_validation->set_rules('cost_egp','Final cost in EGP','trim|number');
					$this->form_validation->set_rules('cost_usd','Final cost in USD','trim|number');
					$this->form_validation->set_rules('cost_eur','Final cost in EUR','trim|number');
					$this->form_validation->set_rules('start-date','Project Start Date','trim|required');
					$this->form_validation->set_rules('end-date','Project End Date','trim|required');
					$this->form_validation->set_rules('year','Project year','trim|required');
			    	$this->form_validation->set_rules('remarks','Remarks','trim');
			    	if ($this->form_validation->run() == TRUE) {
			    		$project_data = array(
			    			'project_id' => $project['id'],
			    			'code' => $code,
			    			'user_id' => $this->data['user_id'],
			    			'name' => $this->input->post('name'),
			    			'reasons' => $this->input->post('reason'),
			    			'scope' => $this->input->post('scope'),
			    			'EUR_EX' => $this->input->post('eur_ex'),
			    			'USD_EX' => $this->input->post('usd_ex'),
			    			'budget_EGP' => $this->input->post('budget_egp'),
			    			'budget_USD' => $this->input->post('budget_usd'),
			    			'budget_EUR' => $this->input->post('budget_eur'),
			    			'budget' => $this->input->post('budget'),
			    			'cost_EGP' => $this->input->post('cost_egp'),
			    			'cost_USD' => $this->input->post('cost_usd'),
			    			'cost_EUR' => $this->input->post('cost_eur'),
			    			'cost' => $this->input->post('cost'),
			    			'start' => $this->input->post('start-date'),
			    			'end' => $this->input->post('end-date'),
			    			'year' => $this->input->post('year'),
			    			'remarks' => $this->input->post('remarks')
			    		);
		    			$this->load->model('projects_change_model');
			    		$project_id = $this->projects_change_model->create($project_data);
			    		if (!isset($project_id)) {
			    			die("ERROR");
			    		}
		    			$this->load->model('suppliers_model');
						$this->suppliers_model->clear($project['id'], 1);
			    		foreach ($this->input->post('supplier') as $supplier) {
		    				$this->suppliers_model->add($project['id'], $supplier, 1);
			    		}
			    		$this->projects_model->update_change($project['id'], 1);
		    			$this->load->model('hotel_planned_signatures_model');
		    			$this->load->model('project_signatures_model');
		    			$hotel_signatures = $this->hotel_planned_signatures_model->getby_hotel($project['hotel_id']);
		    			$final_signatures = $this->manipulate_signatures(TRUE, $project['department_id'], $hotel_signatures, $project_data['cost'], FALSE, TRUE);
		    			$do_sign = $this->project_signatures_model->project_do_sign($project['id'], 1);
            			if ($do_sign != 0) {
            				$this->project_signatures_model->clear_project_change_signature($project['id'], 1);
            			}
			    		foreach ($final_signatures as $hotel_signature) {
			    			$this->project_signatures_model->add_project_signature($project['id'], $hotel_signature['role_id'], $hotel_signature['rank'], 1);
			    		}
	    				$project_data['suppliers'] = $this->input->post('supplier');
						$this->logger->log_event($this->data['user_id'], "Edit", "projects", $project['id'], json_encode($project_data, TRUE), "user edited project, signature modified");
						$this->notify_approved_signers($project['id'], $project['hotel_id'], $code, "Edited", 0);
		    			redirect('/projects/project_stage/'.$project['id']);//CALL FUNCTION
		    		}
				}
				try {
					$this->load->helper('form');
					$this->load->model('projects_model');
					$this->load->model('suppliers_model');
					$this->load->model('offers_model');
					$this->load->model('types_model');
					$this->data['types'] = $this->types_model->getall();
					$this->data['project'] = $this->projects_model->get_project(FALSE, $code);
					if ($this->data['project']['origin_id'] == 2) {
						$this->load->model('project_items_model');
						$this->data['items'] = $this->project_items_model->get_items_details($this->data['project']['id']);
					}
					if($this->data['project']['replaced']==1){
					$this->data['project_replace_items'] = $this->projects_model->get_project_replaced($this->data['project']['id']);
				}
					$this->data['suppliers'] = $this->suppliers_model->getall();
					$this->data['selected_suppliers'] = $this->suppliers_model->getby_project($this->data['project']['id'], 0);
					$this->data['offers'] = $this->offers_model->getby_project($this->data['project']['id'], 0);
					$this->load->view('project_change',$this->data);
				}
				catch( Exception $e) {
					show_error($e->getMessage()." _ ". $e->getTraceAsString());
				}
			}
		}

		public function share_url($code) {
			if ($this->input->post('submit')) {
		    	$message = $this->input->post('message');
				$user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
				$project_url = base_url().'projects/view/'.$code;
				$this->load->model('projects_model');
				$this->load->model('projects_change_model');
				$project = $this->projects_model->get_project(FALSE, $code);
				if ($project['change_amend'] == 1) {
					$this->data['project'] = $this->projects_change_model->get_project(FALSE, $code);
				}else{
					$this->data['project'] = $project;
				}
				$name = $this->data['project']['project_name'];
				if ($this->data['is_admin']) {
					$messages = "project {$code} ({$name})
					{$project_url}";
				}else{
				$messages = "{$user->fullname} project {$code} ({$name})
					{$project_url}";
				}	
				$this->onclick($messages, $project['id'], $this->config->item('page_to_send'));
				$this->deletonclick($project['message_id']);
			}
			redirect('/projects/view/'.$code);
		}

		function onclick($message, $id, $channelss){
			//die(print_r($channel));
			include(APPPATH . 'third_party/RocketChat/autoload.php');
			$client = new RocketChat\Client($this->config->item('send_url'));
			$token = $client->api('user')->login($this->config->item('user_access'),$this->config->item('pass_access'));
			$client->setToken($token);
			$channel_result = $client->api('channel')->sendMessage($channelss, $message);
			$this->load->model('projects_model');
			$this->projects_model->update_request_message_id($id, $channel_result);
		}

		public function mailto($code) {
			if ($this->input->post('submit')) {
				$this->load->library('form_validation');
				$this->form_validation->set_rules('message','message is required','trim|required');
				$this->form_validation->set_rules('mail','mail is required','trim|required');
	    		if ($this->form_validation->run() == TRUE) {
		    		$message = $this->input->post('message');
		    		$mail = $this->input->post('mail');
					$user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
					$this->load->library('email');
					$this->load->helper('url');
					$project_url = base_url().'projects/view/'.$code;
					$this->email->from('e-signature@sunrise-resorts.com');
					$this->email->to($mail);
					$this->email->subject("A message from {$user->fullname}, Project {$code}");
					$this->email->message("{$user->fullname} sent you a private message regarding project {$code}:
						<br/>
						{$message}
						<br />
						<br />
						Please use the link below to view the project:
						<a href='{$project_url}' target='_blank'>{$project_url}</a>
						<br/>
					");	
					$mail_result = $this->email->send();
				}
			}
			redirect('/projects/view/'.$code);
		}

		public function unsign($signature_id) {
			$this->load->model('project_signatures_model');
			$signature_identity = $this->project_signatures_model->get_signature_identity($signature_id);
			$this->load->model('projects_model');
			$this->projects_model->update_final($signature_identity['project_id'], $this->data['role_id']);
			$this->project_signatures_model->unsign($signature_id);
			$this->projects_model->update_state($signature_identity['project_id'], 4);
			$this->logger->log_event($this->data['user_id'], "Undo", "projects", $signature_identity['project_id'], json_encode(array("signature_id" => $signature_id)), "user unsigned project");//log
			$this->logger->log_event($this->data['user_id'], "Stage", "projects", $signature_identity['project_id'], json_encode(array("state_id" => 4)), "project state forced");//log
			$project = $this->projects_model->get_project_code($signature_identity['project_id']);
			redirect('/projects/view/'.$project['code']);
		}

		public function sign($signature_id, $reject = FALSE) {
			$this->load->model('project_signatures_model');
			$this->load->model('projects_change_model');
			$this->load->model('projects_model');
			$signature_identity = $this->project_signatures_model->get_signature_identity($signature_id);
			$brfore_chairman = $this->projects_model->chairman_exception($signature_identity['project_id']);
			$project = $this->projects_model->get_project($signature_identity['project_id']);
			if ($project['change_amend'] == 1) {
				$this->data['project'] = $this->projects_change_model->get_project($project_id);
			}else{
				$this->data['project'] = $project;
			}
			$signrs = $this->get_signers($signature_identity['project_id'], $signature_identity['hotel_id'], $project['change_amend']);
			if (array_key_exists($this->data['user_id'], $signrs[$signature_id]['queue'])) {
				if ($reject) {
					$this->projects_model->update_final($signature_identity['project_id'], 0);
					$this->project_signatures_model->reject($signature_id, $this->data['user_id']);
					$this->projects_model->update_state($signature_identity['project_id'], 12);
					$this->logger->log_event($this->data['user_id'], "Reject", "projects", $signature_identity['project_id'], json_encode(array("signature_id" => $signature_id)), "user rejected project");//log
					$this->logger->log_event($this->data['user_id'], "Stage", "projects", $signature_identity['project_id'], json_encode(array("state_id" => 12)), "project state updated");//log
					$this->notify_approved_signers($signature_identity['project_id'], $this->data['project']['code'], "Rejected", $project['change_amend']);
				} else {
					if ($signature_identity['role_id'] == 28) {
						$this->projects_model->update_state($signature_identity['project_id'], 4);
					}
					$this->project_signatures_model->sign($signature_id, $this->data['user_id']);
					$this->logger->log_event($this->data['user_id'], "Sign", "projects", $signature_identity['project_id'], json_encode(array("signature_id" => $signature_id)), "user signed project");//log
				}
				$name = $this->data['project']['project_name'];
				$code = $this->data['project']['code'];
				$message_id = $project['message_id'];
				$project_url = base_url().'projects/view/'.$code;
				$messages = "project {$code} ({$name})
					{$project_url}";	
				if ($signature_identity['role_id'] == 1) {
					$this->onclick1($messages);
					$this->deletonclick($message_id);
					redirect('/projects/project_stage/'.$signature_identity['project_id']);
				}elseif ($brfore_chairman == 1) {
					//$this->onclick($messages, $code);
					//$this->projects_model->update_message_id($signature_identity['project_id'], $message_ids);
					redirect('/project_owning/create/'.$signature_identity['project_id']);
				} else {
					redirect('/projects/project_stage/'.$signature_identity['project_id']);
				}
			}
			redirect('/projects/view/'.$this->data['project']['code']);
		}

		function onclick1($message){
			include(APPPATH . 'third_party/RocketChat/autoload.php');
			$client = new RocketChat\Client($this->config->item('send_url'));
			$token = $client->api('user')->login($this->config->item('user_access'),$this->config->item('pass_access'));
			$client->setToken($token);
			$channel_result = $client->api('channel')->sendMessage($this->config->item('page_to_send1'),$message);
		}

		function deletonclick($id){
			include(APPPATH . 'third_party/RocketChat/autoload.php');
			$client = new RocketChat\Client($this->config->item('send_url'));
			$token = $client->api('user')->login($this->config->item('user_access'),$this->config->item('pass_access'));
			$client->setToken($token);
			$channel_result = $client->api('channel')->deleteChannel_msg($this->config->item('page_to_send'),$id);
		}

		public function comment($project_id, $code) {
			if ($this->input->post('submit')) {
				$this->load->library('form_validation');
				$this->form_validation->set_rules('comment','Comment is required','trim|required');
	    		if ($this->form_validation->run() == TRUE) {
	    			$comment = $this->input->post('comment');
		    		$this->load->model("project_comments_model");
		    		$comment_data = array(
	    				'user_id' => $this->data['user_id'],
	    				'project_id' => $project_id,
	    				'comment' => $comment
	    			);
					$this->project_comments_model->add($comment_data);
					$user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
					$this->load->model("project_signatures_model");
					$approvers = $this->project_signatures_model->getby_project_signed($project_id);
					$mails = array();
					foreach ($approvers as $approver) {
						$mails[] = $approver['email'];
					}
					$this->comment_alert($user->fullname, $comment, $code, $mails);
					if ($this->data['role_id'] == 217) {
		    			$this->chairman_mail($code);
		    		}
				}
		    }
		    redirect('/projects/view/'.$code);
		}

		private function chairman_mail($code) {
	      	$this->load->library('email');
	      	$this->load->helper('url');
	      	$project_url = base_url().'projects/view/'.$code;
	      	$this->email->from('e-signature@sunrise-resorts.com');
	      	$this->email->to('abeer@sunrise.eg');
	      	$this->email->subject("Project {$code}");
	      	$this->email->message("Dear Madam Abber,
		        <br/>
		        <br/>
		        Mr Hossam Commented on Project {$code}, Please use the link below:
		        <br/>
		        <a href='{$project_url}' target='_blank'>{$project_url}</a>
		        <br/>
      		"); 
      		$mail_result = $this->email->send();
    	}

		private function comment_alert($user_name, $comment, $code, $mails) {
			$this->load->library('email');
			$this->load->helper('url');
			$project_url = base_url().'projects/view/'.$code;
			$this->email->from('e-signature@sunrise-resorts.com');
			$this->email->to($mails);
			$this->email->subject("Project {$code}");
			$this->email->message("{$user_name} added a comment for project {$code}:
				<br/>
				{$comment}
				<br />
				<br />
				Please use the link below to view the project
				<a href='{$project_url}' target='_blank'>{$project_url}</a>
				<br/>
			");	
			$mail_result = $this->email->send();
		}

		public function _remap($method, $params = array()) {
			if(is_numeric($method)) {
				$this->index($method);
			} else {
		    	if (method_exists($this, $method)) {
		        	return call_user_func_array(array($this, $method), $params);
		    	}
		    	show_404();
			}
		}	

		private function get_code($project_id) {
			$code = FALSE;
			while (!$this->projects_model->set_code($project_id, $code)) {
				$code = "ON".strtoupper(str_pad(dechex( mt_rand( 50, 1048579999 ) ), 6, '0', STR_PAD_LEFT));
			}
			return $code;
		}

		public function suppliers($id, $code) {
			$this->load->model('suppliers_model');
			$this->suppliers_model->clear($id, 0);
			foreach ($this->input->post('supplier') as $supplier) {
				$this->suppliers_model->add($id, $supplier, 0);
			}
			redirect('/projects/view/'.$code);
		}

		public function submit($code = FALSE) {
			if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
	      		redirect('/unknown');
	    	}else{
				if ($this->input->post('submit')) {
					$this->load->library('form_validation');
					$this->form_validation->set_rules('scope','Scope of project','trim');
					$this->form_validation->set_rules('supplier[]','Suppliers','trim');
					$this->form_validation->set_rules('new','New Equipment','trim|required');
					$this->form_validation->set_rules('cost','Final cost','trim|number|required');
					$this->form_validation->set_rules('cost_egp','Final cost in EGP','trim|number');
					$this->form_validation->set_rules('cost_usd','Final cost in USD','trim|number');
					$this->form_validation->set_rules('cost_eur','Final cost in EUR','trim|number');
					$this->form_validation->set_rules('start-date','Project Start Date','trim|required');
					$this->form_validation->set_rules('end-date','Project End Date','trim|required');
					$this->form_validation->set_rules('year','Project year','trim|required');
			    	$this->form_validation->set_rules('remarks','Remarks','trim');
		    		if ($this->form_validation->run() == TRUE) {
		    			$this->load->model('projects_model');
		    			$project_data = array(
		    				'user_id' => $this->data['user_id'],
		    				'scope' => $this->input->post('scope'),
		    				'new' => $this->input->post('new'),
		    				'cost' => $this->input->post('cost'),
		    				'cost_EGP' => $this->input->post('cost_egp'),
		    				'cost_USD' => $this->input->post('cost_usd'),
		    				'cost_EUR' => $this->input->post('cost_eur'),
		    				'start' => $this->input->post('start-date'),
		    				'end' => $this->input->post('end-date'),
		    				'year' => $this->input->post('year'),
		    				'remarks' => $this->input->post('remarks'),
		    				'state_id' => 3
		    			);
		    			$project_id = $this->projects_model->update_by_code($code, $project_data);
			    		if (!isset($project_id['id'])) {
			    			die("ERROR");
			    		}
		    			$department_id = $this->input->post('department_id');
		    			$this->load->model('suppliers_model');
		    			$this->suppliers_model->clear($project_id['id'], 0);
			    		foreach ($this->input->post('supplier') as $supplier) {
			    			$this->suppliers_model->add($project_id['id'], $supplier, 0);
			    		}
		    			$this->load->model('hotel_planned_signatures_model');
		    			$this->load->model('project_signatures_model');
		    			$this->load->model('projects_model');
						$this->data['project'] = $this->projects_model->get_request(FALSE, $code);
		    			$hotel_signatures = $this->hotel_planned_signatures_model->getby_hotel($this->input->post('hotel_id'));
	    				$final_signatures = $this->manipulate_signatures(FALSE, $department_id, $hotel_signatures, $project_data['cost'], $this->data['project']['new'], FALSE);
		    			foreach ($final_signatures as $hotel_signature) {
		    				$this->project_signatures_model->add_project_signature($project_id['id'], $hotel_signature['role_id'], $hotel_signature['rank'], 0);
		    			}
	    				$project_data['suppliers'] = $this->input->post('supplier');
						$this->logger->log_event($this->data['user_id'], "Submit", "projects", $project_id['id'], json_encode($project_data, TRUE), "user created project (unplanned)");//log
		    			redirect('/projects/project_stage/'.$project_id['id']);
			    	}
				}
				try {
					$this->load->helper('form');
					$this->load->model('projects_model');
					$this->load->model('suppliers_model');
					$this->load->model('offers_model');
					$this->data['suppliers'] = $this->suppliers_model->getall();
					$this->data['project'] = $this->projects_model->get_request(FALSE, $code);
					$this->data['project']['code'] = $code;
					$this->data['offers'] = $this->offers_model->getby_project($this->data['project']['id'], 0);
					$this->load->view('project_submit',$this->data);
				}
				catch( Exception $e) {
					show_error($e->getMessage()." _ ". $e->getTraceAsString());
				}
			}
		}
	function new_url(){
        $this->load->library('user_agent');
         redirect($this->agent->referrer()."/1");
	 }	

}

?>