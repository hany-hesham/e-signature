<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Project_owning extends CI_Controller {

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
			$this->data['module_forms'] = array('0' => 1, '1' => 25, '2' => 26, '3' => 27);;
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

		public function _remap($method, $params = array()){
			if(is_numeric($method)) {
				$this->index($method);
			} else {
			    if (method_exists($this, $method)){
			        return call_user_func_array(array($this, $method), $params);
			    }
		    	show_404();
			}
		}
	
		public function index($state = FALSE) {
			if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
	      	redirect('/unknown');
	    	}else{
				$states = array(4,5,6,7,8,9,12,33);
				$this->load->model('hotels_model');
				$user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
				$hotels = array();
				$this->data['special_owning'] = FALSE;
				foreach ($user_hotels as $hotel) {
					$hotels[] = $hotel['id'];
					if ($hotel['id'] == 5 || $hotel['id'] == 42) {
						$this->data['special_owning'] = TRUE;
					}
				}
				$this->load->model('projects_owning_model');
				$this->data['projects'] = $this->projects_owning_model->get_projects($states, $hotels);
				foreach ($this->data['projects'] as $key => $project) {
					if ($this->data['projects'][$key]['code']) {
						$type = 2;
					}else{
						$type = 1;
					}
					$this->data['projects'][$key]['approvals'] = $this->get_orig_signers($this->data['projects'][$key]['id'], $this->data['projects'][$key]['hotel_id'], $type);
					$this->data['projects'][$key]['signatures'] = $this->get_signers($this->data['projects'][$key]['id'], $this->data['projects'][$key]['hotel_id'], $type);
				}
				$this->data['hotels'] = $this->hotels_model->getall();
				$user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
				$this->data['submenu']['active'] = "owning";
				$this->load->view('projects_owning', $this->data);
			}
		}

		private function manipulate_signatures($department_id, $signatures) {
			if ($department_id != 2) {
				foreach ($signatures as $key => $sign) {
					if ($sign['role_id'] == 22) {
						unset($signatures[$key]);
					}
				}
			}
			return $signatures;
		}

		private function get_signers($project_id, $hotel_id, $type) {
			$this->load->model('owning_signatures_model');
			$this->load->model('users_model');
			$signers = array();
			$signatures = $this->owning_signatures_model->getby_owning_verbal($project_id, $type);
			foreach ($signatures as $signature) {
				$signers[$signature['id']] = array();
				$signers[$signature['id']]['role'] = $signature['role'];
				$signers[$signature['id']]['role_id'] = $signature['role_id'];
				$signers[$signature['id']]['dead_line'] = $signature['dead_line'];
				$signers[$signature['id']]['new_dead'] = $signature['new_dead'];
				$signers[$signature['id']]['delay_reason'] = $signature['delay_reason'];
				if ($signature['user_id']) {
					$signers[$signature['id']]['sign'] = array();
					$signers[$signature['id']]['sign']['id'] = $signature['user_id'];
					if ($signature['reject'] == 1) {
						$signers[$signature['id']]['sign']['reject'] = "reject";
					} 
					$user = $this->users_model->get_user_by_id($signature['user_id'], TRUE);
					$signers[$signature['id']]['sign']['name'] = $user->fullname;
					$signers[$signature['id']]['sign']['mail'] = $user->email;
					$signers[$signature['id']]['sign']['sign'] = $user->signature;
					$signers[$signature['id']]['sign']['timestamp'] = $signature['timestamp'];
				} else {
					$signers[$signature['id']]['queue'] = array();
					if ($signature['role_id'] == 85 && $hotel_id == 5) {
						$users = $this->users_model->getby_criteria(25, $hotel_id);
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
			return $signers;
		}

		private function get_signers_owning($project_id, $hotel_id, $type) {
			$this->load->model('owning_signatures_model');
			$this->load->model('users_model');
			$signers = array();
			$signatures = $this->owning_signatures_model->getby_owning_company_verbal($project_id, $type);
			foreach ($signatures as $signature) {
				$signers[$signature['id']] = array();
				$signers[$signature['id']]['role'] = $signature['role'];
				$signers[$signature['id']]['role_id'] = $signature['role_id'];
				$signers[$signature['id']]['dead_line'] = $signature['dead_line'];
				$signers[$signature['id']]['new_dead'] = $signature['new_dead'];
				$signers[$signature['id']]['delay_reason'] = $signature['delay_reason'];
				if ($signature['user_id']) {
					$signers[$signature['id']]['sign'] = array();
					$signers[$signature['id']]['sign']['id'] = $signature['user_id'];
					if ($signature['reject'] == 1) {
						$signers[$signature['id']]['sign']['reject'] = "reject";
					} 
					$user = $this->users_model->get_user_by_id($signature['user_id'], TRUE);
					$signers[$signature['id']]['sign']['name'] = $user->fullname;
					$signers[$signature['id']]['sign']['mail'] = $user->email;
					$signers[$signature['id']]['sign']['sign'] = $user->signature;
					$signers[$signature['id']]['sign']['timestamp'] = $signature['timestamp'];
				} else {
					$signers[$signature['id']]['queue'] = array();
					if ($signature['role_id'] == 26 && $hotel_id == 5) {
			            $users[0] = $this->users_model->getby_criteria(27, $hotel_id);
			            $users[1] = $this->users_model->getby_criteria(26, $hotel_id);
			            foreach ($users as $user) {
			              foreach ($user as $use) {
			                $signers[$signature['id']]['queue'][$use['id']] = array();
							$signers[$signature['id']]['queue'][$use['id']]['name'] = $use['fullname'];
							$signers[$signature['id']]['queue'][$use['id']]['mail'] = $use['email'];
							$signers[$signature['id']]['queue'][$use['id']]['channel'] = $use['channel'];
			              }
			            }
		        	} else {
						$users = $this->users_model->getby_criteria($signature['role_id'], $hotel_id);
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
		}

		private function get_orig_signers($project_id, $hotel_id) {
			$this->load->model('project_signatures_model');
			$this->load->model('users_model');
			$signers = array();
			$this->load->model('projects_model');
			$project = $this->projects_model->get_project($project_id);
			$signatures = $this->project_signatures_model->getby_project_verbal($project_id, $project['change_amend']);
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
					$signers[$signature['id']]['sign']['sign'] = $user->signature;
					$signers[$signature['id']]['sign']['timestamp'] = $signature['timestamp'];
				} else {
					$signers[$signature['id']]['queue'] = array();
					if ($signature['role_id'] == 85 && $hotel_id == 5) {
						$users = $this->users_model->getby_criteria(25, $hotel_id);
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
			return $signers;
		}

		public function suppliers($id, $code) {
			$this->load->model('suppliers_model');
			$this->suppliers_model->clear($id);
			foreach ($this->input->post('supplier') as $supplier) {
				$this->suppliers_model->add($id, $supplier);
			}
			redirect('/project_owning/review/'.$id);
		}

		private function admin_alert($id, $role, $hotel) {
			$this->load->library('email');
			$this->load->helper('url');
			$this->load->model('projects_model');
			$this->data['project'] = $this->projects_model->get_project_code($id);
			$project_url = base_url().'projects/view/'.$this->data['project']['code'];
			$this->email->from('e-signature@sunrise-resorts.com');
			$this->email->cc('hany.hisham@sunrise-resorts.com');
			$this->email->subject("Project {$id} missing {$role}");
			$this->email->message("Project {$id} for {$hotel} is pending on {$role} signature, no user is currently assigned
				<br/>
				<a href='{$project_url}' target='_blank'>{$project_url}</a>
				<br/>
			");	
			$mail_result = $this->email->send();
		}

		private function chairman_alert($id) {
			$this->load->model('projects_model');
			$this->data['project'] = $this->projects_model->get_project_code($id);
			$this->load->library('email');
			$this->load->helper('url');
			$project_url = base_url().'projects/view/'.$this->data['project']['code'];
			$this->email->from('e-signature@sunrise-resorts.com');
			$this->email->to('chairman@sunrise.eg');
			$this->email->subject("Project {$id} ");
			$this->email->message("Project {$id} owning form updated
				<br/>
				<a href='{$project_url}' target='_blank'>{$project_url}</a>
				<br/>
			");	
			$mail_result = $this->email->send();
		}

		private function chairman_request_alert($id) {
			$this->load->model('projects_model');
			$this->data['project'] = $this->projects_model->get_project_code($id);
			$this->load->library('email');
			$this->load->helper('url');
			$project_url = base_url().'requests/view/'.$this->data['project']['id'];
			$this->email->from('e-signature@sunrise-resorts.com');
			$this->email->to('chairman@sunrise.eg');
			$this->email->subject("Project {$id} ");
			$this->email->message("Project {$id} owning form updated
				<br/>
				<a href='{$project_url}' target='_blank'>{$project_url}</a>
				<br/>
			");	
			$mail_result = $this->email->send();
		}

		private function signatures_mail($role, $name, $mail, $id) {
			$this->load->model('projects_model');
			$this->data['project'] = $this->projects_model->get_project_code($id);
			$this->load->library('email');
			$this->load->helper('url');
			$project_url = base_url().'projects/view/'.$this->data['project']['code'];
			$this->email->from('e-signature@sunrise-resorts.com');
			$this->email->to($mail);
			$this->email->subject("Project {$id}");
			$this->email->message("Dear {$name},
				<br/>
				<br/>
				Project {$id} requires your signature, Please use the link below:
				<br/>
				<a href='{$project_url}' target='_blank'>{$project_url}</a>
				<br/>
			");	
			$mail_result = $this->email->send();
		}

		private function signatures_request_mail($role, $name, $mail, $id) {
			$this->load->model('projects_model');
			$this->data['project'] = $this->projects_model->get_project_code($id);
			$this->load->library('email');
			$this->load->helper('url');
			$project_url = base_url().'requests/view/'.$id;
			$this->email->from('e-signature@sunrise-resorts.com');
			$this->email->to($mail);
			$this->email->subject("Request {$id}");
			$this->email->message("Dear {$name},
				<br/>
				<br/>
				Request {$id} requires your signature, Please use the link below:
				<br/>
				<a href='{$project_url}' target='_blank'>{$project_url}</a>
				<br/>
			");	
			$mail_result = $this->email->send();
		}

		public function notify_signers($project_id) {
			$notified = FALSE;
			$this->load->model('projects_owning_model');
			$this->data['project'] = $this->projects_owning_model->get_project_hotel($project_id);
			if ($this->data['project']['code']) {
				$type = 2;
			}else{
				$type = 1;
			}
			$code = $this->data['project']['code'];
			$id = $this->data['project']['id'];
			$name = $this->data['project']['name'];
			if ($type == 2) {
				$project_url = base_url().'projects/view/'.$code;	
				$message = "Project {$code} ({$name}):
				{$project_url}";
			}elseif ($type == 1) {
				$project_url = base_url().'requests/view/'.$id;	
				$message = "Project request {$id} ({$name}):
				{$project_url}";
			}
			$signers = $this->get_signers($project_id, $this->data['project']['hotel_id'], $type);
			foreach ($signers as $signer) {
				if (isset($signer['queue'])) {
					$notified = TRUE;
					if (count($signer['queue']) == 0) {
						$this->admin_alert($project_id, $signer['role'], $this->data['project']['hotel_name']);
					} else {
						$this->projects_owning_model->update_final($project_id, $signer['role_id']);
						$this->projects_owning_model->update_hotel($project_id, $this->data['project']['hotel_id']);
						foreach ($signer['queue'] as $uid => $user) {
							$this->onclick($message, $id, $user['channel']);
							if ($type == 2) {
								$this->signatures_mail($signer['role'], $user['name'], $user['mail'], $project_id);
							}elseif($type == 1){
								$this->signatures_request_mail($signer['role'], $user['name'], $user['mail'], $project_id);
							}
							$this->logger->log_event($this->data['user_id'], "Notify", "owning_project", $project_id, json_encode(array("to" => $user['mail'])), "Project owning signature notification sent");//log
						}
	          			break;
					}
				}
				
			}
			return $notified;
		}

		public function notify_signers_other($project_id) {
			$notified = FALSE;
			$this->load->model('projects_owning_model');
			$this->data['project'] = $this->projects_owning_model->get_project_hotel($project_id);
			if ($this->data['project']['code']) {
				$type = 2;
			}else{
				$type = 1;
			}
			$code = $this->data['project']['code'];
			$id = $this->data['project']['id'];
			$name = $this->data['project']['name'];
			if ($type == 2) {
				$project_url = base_url().'projects/view/'.$code;	
				$message = "Project {$code} ({$name}):
				{$project_url}";
			}elseif ($type == 1) {
				$project_url = base_url().'requests/view/'.$id;	
				$message = "Project request {$id} ({$name}):
				{$project_url}";
			}
			$signers = $this->get_signers_owning($project_id, $this->data['project']['hotel_id'], $type);
			foreach ($signers as $signer) {
				if (isset($signer['queue'])) {
					$notified = TRUE;
					if (count($signer['queue']) == 0) {
						$this->admin_alert($project_id, $signer['role'], $this->data['project']['hotel_name']);
					} else {
						$this->projects_owning_model->update_final($project_id, $signer['role_id']);
						$this->projects_owning_model->update_hotel($project_id, $this->data['project']['hotel_id']);
						foreach ($signer['queue'] as $uid => $user) {
							$this->onclick($message, $id, $user['channel']);
							if ($type == 2) {
								$this->signatures_mail($signer['role'], $user['name'], $user['mail'], $project_id);
							}elseif($type == 1){
								$this->signatures_request_mail($signer['role'], $user['name'], $user['mail'], $project_id);
							}
							$this->logger->log_event($this->data['user_id'], "Notify", "owning_project", $project_id, json_encode(array("to" => $user['mail'])), "Project owning signature notification sent");//log
						}
	          			break;
					}
				}
			}
			return $notified;
		}

		public function activate($id) {
			$this->load->model('projects_owning_model');
			$this->data['project'] = $this->projects_owning_model->get_project_hotel($id);
			$this->notify_signers($id);
			redirect('/projects/project_stage/'.$id);
		}

		public function create($id) {
			$this->load->model('projects_owning_model');
			$this->load->model('projects_model');
			$this->load->model('company_signatures_model');
			$this->load->model('owning_signatures_model');
			$project_code = $this->projects_model->get_project_code($id);
			$form_data = array(
				'project_id' => $id,
				'project_code' => $project_code['code'],
				'date' => date("Y-m-d H:i:s")
			);
			$project_owning_id = $this->projects_owning_model->get_owning_company_form($id);
			if ($project_owning_id) {
				$form_id = $this->projects_owning_model->update($id , $form_data);
			}else{
				$form_id = $this->projects_owning_model->create($form_data);
			}
			if (!$form_id) {
				$this->logger->log_event($this->data['user_id'], "ERROR", "owning_project", $id, NULL, "owning form not created, project ID included instead");//log
			}
			$project = $this->projects_owning_model->get_project_company($id);
			$company_signatures = $this->company_signatures_model->getby_company($project['company_id']);
			if ($project['hotel_id'] == 5 || $project['hotel_id'] == 42) {
				$company_owning_signatures = $this->company_signatures_model->getby_company_owning($project['hotel_id']);
			}
			$final_signatures = $this->manipulate_signatures($project['department_id'], $company_signatures);
			$this->owning_signatures_model->clear($id, 2);
			$date = date("Y-m-d H:i:s");
			$day = date("D");
			if ($day == "Wed") {
				$i = 4;
			}elseif ($day == "Thu") {
				$i = 4;
			}elseif ($day == "Fri") {
				$i = 3;
			}else{
				$i = 2;
			}
			foreach ($final_signatures as $company_signature) {
				$dead_line = date('Y-m-d', strtotime($date. ' + '.$i.' days'));
				$this->owning_signatures_model->add_owning_signature($id, $company_signature['role_id'], $company_signature['rank'], $dead_line, 2);
			}
			foreach ($company_owning_signatures as $company_owning_signature) {
				$dead_line = date('Y-m-d', strtotime($date. ' + '.$i.' days'));
				$this->owning_signatures_model->add_company_owning_signature($id, $company_owning_signature['role_id'], $company_owning_signature['rank'], $dead_line, 2);
			}
			$this->logger->log_event($this->data['user_id'], "Create", "owning_project", $form_id, json_encode($form_data, TRUE), "owning form created");
			//$this->chairman_alert($id);
			return $this->activate($id);
		}

		public function activate_request($id) {
			$this->load->model('projects_owning_model');
			$this->data['project'] = $this->projects_owning_model->get_project_hotel($id);
			$this->notify_signers($id);
			redirect('/requests/request_stage/'.$id);
		}

		public function create_request($id) {
			$this->load->model('projects_owning_model');
			$this->load->model('company_signatures_model');
			$this->load->model('owning_signatures_model');
			$form_data = array(
				'project_id' => $id,
				'date' => date("Y-m-d H:i:s")
			);
			$project_owning_id = $this->projects_owning_model->get_owning_company_form($id);
			if ($project_owning_id) {
				$form_id = $this->projects_owning_model->update($id , $form_data);
			}else{
				$form_id = $this->projects_owning_model->create($form_data);
			}
			if (!$form_id) {
				$this->logger->log_event($this->data['user_id'], "ERROR", "owning_project", $id, NULL, "owning form not created, project ID included instead");
			}
			$project = $this->projects_owning_model->get_project_company($id);
			$company_signatures = $this->company_signatures_model->getby_company($project['company_id']);
			if ($project['hotel_id'] == 5 || $project['hotel_id'] == 42) {
				$company_owning_signatures = $this->company_signatures_model->getby_company_owning($project['hotel_id']);
			}
			$final_signatures = $this->manipulate_signatures($project['department_id'], $company_signatures);
			$this->owning_signatures_model->clear($id, 1);
			$date = date("Y-m-d H:i:s");
			$day = date("D");
			if ($day == "Wed") {
				$i = 4;
			}elseif ($day == "Thu") {
				$i = 4;
			}elseif ($day == "Fri") {
				$i = 3;
			}else{
				$i = 2;
			}
			foreach ($company_signatures as $company_signature) {
				$dead_line = date('Y-m-d', strtotime($date. ' + '.$i.' days'));
				$this->owning_signatures_model->add_owning_signature($id, $company_signature['role_id'], $company_signature['rank'], $dead_line, 1);
			}
			foreach ($company_owning_signatures as $company_owning_signature) {
				$dead_line = date('Y-m-d', strtotime($date. ' + '.$i.' days'));
				$this->owning_signatures_model->add_company_owning_signature($id, $company_owning_signature['role_id'], $company_owning_signature['rank'], $dead_line, 1);
			}
			$this->logger->log_event($this->data['user_id'], "Create", "owning_request", $form_id, json_encode($form_data, TRUE), "owning form created");
			//$this->chairman_request_alert($id);
			return $this->activate_request($id);
		}
	
	public function review($id, $type) {
		if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
	      redirect('/unknown');
	    }else{

			if ($this->input->post('submit')) {

				$this->load->library('form_validation');

				$this->form_validation->set_rules('place','','trim');
				$this->form_validation->set_rules('num_of_offers','','trim');
				$this->form_validation->set_rules('total_cost','','trim');
				$this->form_validation->set_rules('sup_1','','trim');
				$this->form_validation->set_rules('sup_2','','trim');
				$this->form_validation->set_rules('sup_3','','trim');
				$this->form_validation->set_rules('sup_4','','trim');
				$this->form_validation->set_rules('sup_5','','trim');
				$this->form_validation->set_rules('sup_6','','trim');
				$this->form_validation->set_rules('consultant','','trim');
				$this->form_validation->set_rules('recommendation','','trim');
				$this->form_validation->set_rules('balance','','trim');
				$this->form_validation->set_rules('purchasing_notes','','trim');
				$this->form_validation->set_rules('financial_notes','','trim');

		    	if ($this->form_validation->run() == TRUE) {
					$this->load->model('projects_owning_model');

		    		$project_data = array();

					$project_data['place'] = $this->input->post('place');
					$project_data['num_of_offers'] = $this->input->post('num_of_offers');
					$project_data['total_cost'] = $this->input->post('total_cost');
					$project_data['sup_1'] = $this->input->post('sup_1');
					$project_data['sup_2'] = $this->input->post('sup_2');
					$project_data['sup_3'] = $this->input->post('sup_3');
					$project_data['sup_4'] = $this->input->post('sup_4');
					$project_data['sup_5'] = $this->input->post('sup_5');
					$project_data['sup_6'] = $this->input->post('sup_6');
					$project_data['consultant'] = $this->input->post('consultant');
					$project_data['recommendation'] = $this->input->post('recommendation');
					$project_data['balance'] = $this->input->post('balance');
					$project_data['purchasing_notes'] = $this->input->post('purchasing_notes');
					$project_data['financial_notes'] = $this->input->post('financial_notes');

		    		$project_id = $this->projects_owning_model->update($id, $project_data);

		    		if (!isset($project_id)) {
		    			die("ERROR");//@TODO failure view
		    		}

		    		$this->load->model('suppliers_model');

		    		$suppliers = $this->input->post('supplier');

		    		if (!empty($suppliers)) {
		    			$this->suppliers_model->clear($project_id['id']);
			    		foreach ($suppliers as $supplier) {
			    			$this->suppliers_model->add($project_id['id'], $supplier);
			    		}
		    		}

	    			$project_data['suppliers'] = $this->input->post('supplier');

					$this->logger->log_event($this->data['user_id'], "Review", "owning_project", $id, json_encode($project_data, TRUE), "Owning company form updated");//log

		    	}
			}

			$this->load->model('projects_owning_model');
			$this->load->model('project_comments_model');
			$this->load->model('suppliers_model');


			$this->data['project'] = $this->projects_owning_model->get_project($id);
			$this->data['project_id'] = $id;


			$this->data['signature_path'] = '/assets/uploads/signatures/';
			//if ($this->data['project']['code']) {
			//	$type = 2;
			//}else{
			//	$type = 1;
			//}
			$this->data['signers'] = $this->get_signers($id, $this->data['project']['hotel_id'], $type);

			$this->data['suppliers'] = $this->suppliers_model->getall();

			$this->load->view('project_owning_form', $this->data);
		}
	}

	public function review_other($id, $type) {
		if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
	      redirect('/unknown');
	    }else{
			$this->load->model('projects_owning_model');
			$this->load->model('project_comments_model');
			$this->load->model('suppliers_model');
			$this->data['project'] = $this->projects_owning_model->get_project($id);
			$this->data['project_id'] = $id;
			$this->data['signature_path'] = '/assets/uploads/signatures/';
			$this->data['signers'] = $this->get_signers_owning($id, $this->data['project']['hotel_id'], $type);
			$this->load->view('project_owning_form_2', $this->data);
		}
	}

	public function sign($signature_id) {
		$this->load->model('owning_signatures_model');
		$signature1_id = $signature_id +1;
		$signature_identity1 = $this->owning_signatures_model->get_signature_identity($signature1_id);
		$signature_identity = $this->owning_signatures_model->get_signature_identity($signature_id);
		$this->load->model('projects_model');
		$this->data['project'] = $this->projects_model->get_project_code($signature_identity['project_id']);
		if ($signature_identity['code']) {
				$type = 2;
			}else{
				$type = 1;
			}
		$signrs = $this->get_signers($signature_identity['project_id'], $signature_identity['hotel_id'], $type);
		$code = $this->data['project']['code'];
		$id = $this->data['project']['id'];
		$name = $this->data['project']['name'];
		if ($type == 2) {
			$project_url = base_url().'projects/view/'.$code;	
			$message = "Project {$code} ({$name}):
			{$project_url}";
		}elseif ($type == 1) {
			$project_url = base_url().'requests/view/'.$id;	
			$message = "Project request {$id} ({$name}):
			{$project_url}";
		}
		
		// $this->load->model('projects_model');
		// $this->data['project'] = $this->projects_model->get_owning_code($signature_identity['project_id']);
		$date = date("Y-m-d H:i:s");
		$day = date("D");
		if ($day == "Wed") {
			$i = 4;
		}elseif ($day == "Thu") {
			$i = 4;
		}elseif ($day == "Fri") {
			$i = 3;
		}else{
			$i = 2;
		}
		$dead_line = date('Y-m-d', strtotime($date. ' + '.$i.' days'));
		if ($signature_identity1['project_id'] == $signature_identity['project_id']) {
			$this->owning_signatures_model->deadline($signature1_id , $dead_line);
		}
		//die(print_r($dead_line));
		if (array_key_exists($this->data['user_id'], $signrs[$signature_id]['queue'])) {
			$this->owning_signatures_model->sign($signature_id, $this->data['user_id']);
			//$this->owning_signatures_model->deadline($signature1_id , $dead_line);
			$this->logger->log_event($this->data['user_id'], "Sign", "owning_project", $signature_identity['project_id'], json_encode(array("signature_id" => $signature_id)), "user signed project");//log
		}
		if ($signature_identity['role_id'] == 14) {
			$chairman_info = $this->users_model->get_user_by_id(217,1);
			$this->onclick($message, $signature_identity['project_id'], $this->config->item('page_to_send'));
			if (!$this->data['project']['code']) {
				$this->signatures_request_mail("Chairman", $chairman_info->fullname, 
					$chairman_info->email, 
				    $signature_identity['project_id'] 
				  );
			}else{
			$this->signatures_mail("Chairman", $chairman_info->fullname, $chairman_info->email, 
				$signature_identity['project_id']);
		 }
		}
		if ($this->data['project']['code']) {
					$type = 2;
				}else{
					$type = 1;
				}
		$this->notify_signers($signature_identity['project_id']);
		redirect('/project_owning/review/'.$this->data['project']['id'].'/'.$type);
	}

	public function sign_other($signature_id) {
		$this->load->model('owning_signatures_model');
		$signature1_id = $signature_id +1;
		$signature_identity1 = $this->owning_signatures_model->get_signature_other_identity($signature1_id);
		$signature_identity = $this->owning_signatures_model->get_signature_other_identity($signature_id);
		$this->load->model('projects_model');
		$this->data['project'] = $this->projects_model->get_project_code($signature_identity['project_id']);
		if ($signature_identity['code']) {
				$type = 2;
			}else{
				$type = 1;
			}
		$signrs = $this->get_signers_owning($signature_identity['project_id'], $signature_identity['hotel_id'], $type);
		$code = $this->data['project']['code'];
		$id = $this->data['project']['id'];
		$name = $this->data['project']['name'];
		if ($type == 2) {
			$project_url = base_url().'projects/view/'.$code;	
			$message = "Project {$code} ({$name}):
			{$project_url}";
		}elseif ($type == 1) {
			$project_url = base_url().'requests/view/'.$id;	
			$message = "Project request {$id} ({$name}):
			{$project_url}";
		}
		
		// $this->load->model('projects_model');
		// $this->data['project'] = $this->projects_model->get_owning_code($signature_identity['project_id']);
		$date = date("Y-m-d H:i:s");
		$day = date("D");
		if ($day == "Wed") {
			$i = 4;
		}elseif ($day == "Thu") {
			$i = 4;
		}elseif ($day == "Fri") {
			$i = 3;
		}else{
			$i = 2;
		}
		$dead_line = date('Y-m-d', strtotime($date. ' + '.$i.' days'));
		if ($signature_identity1['project_id'] == $signature_identity['project_id']) {
			$this->owning_signatures_model->deadline_other($signature1_id , $dead_line);
		}
		//die(print_r($dead_line));
		if (array_key_exists($this->data['user_id'], $signrs[$signature_id]['queue'])) {
			$this->owning_signatures_model->sign_other($signature_id, $this->data['user_id']);
			//$this->owning_signatures_model->deadline($signature1_id , $dead_line);
			$this->logger->log_event($this->data['user_id'], "Sign", "owning_project", $signature_identity['project_id'], json_encode(array("signature_id" => $signature_id)), "user signed project");//log
		}
		/*if ($signature_identity['role_id'] == 14) {
			$this->onclick($message, $signature_identity['project_id'], $this->config->item('page_to_send'));
		}*/
		if ($this->data['project']['code']) {
					$type = 2;
				}else{
					$type = 1;
				}
		$this->notify_signers_other($signature_identity['project_id']);
		redirect('/project_owning/review_other/'.$this->data['project']['id'].'/'.$type);
	}

		function onclick($message, $id, $channel){
			include(APPPATH . 'third_party/RocketChat/autoload.php');
			$client = new RocketChat\Client($this->config->item('send_url'));
			$token = $client->api('user')->login($this->config->item('user_access'),$this->config->item('pass_access'));
			$client->setToken($token);
			$channel_result = $client->api('channel')->sendMessage($channel, $message);
			$this->load->model('projects_model');
			$this->projects_model->update_request_message_id($id, $channel_result);
		}

	public function reject($signature_id) {
		$this->load->model('owning_signatures_model');
		$signature_identity = $this->owning_signatures_model->get_signature_identity($signature_id);
		$this->load->model('projects_owning_model');
		$this->projects_owning_model->update_final($signature_identity['project_id'], 0);
		if ($signature_identity['code']) {
				$type = 2;
			}else{
				$type = 1;
			}
		$signrs = $this->get_signers($signature_identity['project_id'], $signature_identity['hotel_id'], $type);

		$this->load->model('projects_model');
		$this->data['project'] = $this->projects_model->get_project_code($signature_identity['project_id']);
		if (array_key_exists($this->data['user_id'], $signrs[$signature_id]['queue'])) {
			$this->owning_signatures_model->reject($signature_id, $this->data['user_id']);
			$this->logger->log_event($this->data['user_id'], "Reject", "owning_project", $signature_identity['project_id'], json_encode(array("signature_id" => $signature_id)), "user rejected project");//log

		}
		if ($signature_identity['role_id'] == 14) {
			$code = $this->data['project']['code'];
			$id = $this->data['project']['id'];
			$name = $this->data['project']['name'];
			if ($type == 2) {
				$project_url = base_url().'projects/view/'.$code;	
				$message = "Project {$code} ({$name}):
				{$project_url}";
			}elseif ($type == 1) {
				$project_url = base_url().'requests/view/'.$id;	
				$message = "Project request {$id} ({$name}):
				{$project_url}";
			}
			$chairman_info = $this->users_model->get_user_by_id(217,1);
			$this->onclick($message, $signature_identity['project_id'], $this->config->item('page_to_send'));
			if ($signature_identity['role_id'] == 14) {
			$chairman_info = $this->users_model->get_user_by_id(217,1);
			$this->onclick($message, $signature_identity['project_id'], $this->config->item('page_to_send'));
			if (!$this->data['project']['code']) {
				$this->signatures_request_mail("Chairman", $chairman_info->fullname, 
					$chairman_info->email, 
				    $signature_identity['project_id'] 
				  );
			}else{
			$this->signatures_mail("Chairman", $chairman_info->fullname, $chairman_info->email, 
				$signature_identity['project_id']);
		  }
		 }
		}
		$this->notify_signers($signature_identity['project_id']);
		redirect('/project_owning/review/'.$this->data['project']['id'].'/'.$type);
	}

	public function reject_other($signature_id) {
		$this->load->model('owning_signatures_model');
		$signature_identity = $this->owning_signatures_model->get_signature_other_identity($signature_id);
		$this->load->model('projects_owning_model');
		$this->projects_owning_model->update_final($signature_identity['project_id'], 0);
		if ($signature_identity['code']) {
				$type = 2;
			}else{
				$type = 1;
			}
		$signrs = $this->get_signers_owning($signature_identity['project_id'], $signature_identity['hotel_id'], $type);

		$this->load->model('projects_model');
		$this->data['project'] = $this->projects_model->get_project_code($signature_identity['project_id']);
		if (array_key_exists($this->data['user_id'], $signrs[$signature_id]['queue'])) {
			$this->owning_signatures_model->reject_other($signature_id, $this->data['user_id']);
			$this->logger->log_event($this->data['user_id'], "Reject", "owning_project", $signature_identity['project_id'], json_encode(array("signature_id" => $signature_id)), "user rejected project");//log

		}
		redirect('/project_owning/review_other/'.$this->data['project']['id'].'/'.$type);
	}

	public function unsign($signature_id) {
		$this->load->model('owning_signatures_model');
		$this->load->model('projects_owning_model');
		$signature_identity = $this->owning_signatures_model->get_signature_identity($signature_id);

		$this->owning_signatures_model->unsign($signature_id, $this->data['user_id']);

		$this->logger->log_event($this->data['user_id'], "Undo", "owning_project", $signature_identity['project_id'], json_encode(array("signature_id" => $signature_id)), "user unsigned project");//log
		$this->load->model('projects_model');
		$this->data['project'] = $this->projects_model->get_project_code($signature_identity['project_id']);
		$this->projects_owning_model->update_final($signature_identity['project_id'], $this->data['role_id']);
		if ($this->data['project']['code']) {
					$type = 2;
				}else{
					$type = 1;
				}
		$this->notify_signers($signature_identity['project_id']);
		redirect('/project_owning/review/'.$this->data['project']['id'].'/'.$type);
	}

	public function unsign_other($signature_id) {
		$this->load->model('owning_signatures_model');
		$this->load->model('projects_owning_model');
		$signature_identity = $this->owning_signatures_model->get_signature_other_identity($signature_id);

		$this->owning_signatures_model->unsign_other($signature_id, $this->data['user_id']);

		$this->logger->log_event($this->data['user_id'], "Undo", "owning_project", $signature_identity['project_id'], json_encode(array("signature_id" => $signature_id)), "user unsigned project");//log
		$this->load->model('projects_model');
		$this->data['project'] = $this->projects_model->get_project_code($signature_identity['project_id']);
		$this->projects_owning_model->update_final($signature_identity['project_id'], $this->data['role_id']);
		if ($this->data['project']['code']) {
					$type = 2;
				}else{
					$type = 1;
				}
		$this->notify_signers_other($signature_identity['project_id']);
		redirect('/project_owning/review_other/'.$this->data['project']['id'].'/'.$type);
	}

	private function comment_alert($user_name, $comment, $code, $mails) {
		$this->load->library('email');
		$this->load->helper('url');

		$project_url = base_url().'projects/view/'.$code;
		
		$this->email->from('e-signature@sunrise-resorts.com');
		$this->email->to($mails);

		$this->email->subject("Project {$code}");
		$this->email->message("{$user_name} added a comment for project {$code}:<br/>
							{$comment}<br />
							<br />

							Please use the link below to view the project
							<a href='{$project_url}' target='_blank'>{$project_url}</a><br/>

							");	

		$mail_result = $this->email->send();

	}

	public function mailto($id) {
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
				$this->load->model('projects_model');
				$this->data['project'] = $this->projects_model->get_project_code($id);
				$project_url = base_url().'projects/view/'.$this->data['project']['code'];
				
				$this->email->from('e-signature@sunrise-resorts.com');
				$this->email->to($mail);

				$this->email->subject("A message from {$user->fullname}, Project #{$id}");
				$this->email->message("{$user->fullname} sent you a private message regarding Project #{$id}:<br/>
									{$message}<br />
									<br />

									Please use the link below to view the project:
									<a href='{$project_url}' target='_blank'>{$project_url}</a><br/>

									");	

				$mail_result = $this->email->send();
			}
		}
		if ($this->data['project']['code']) {
					$type = 2;
				}else{
					$type = 1;
				}
		redirect('/project_owning/review/'.$this->data['project']['id'].'/'.$type);
	}

	public function comment($project_id) {
		if ($this->input->post('submit')) {

			$this->load->library('form_validation');

			$this->form_validation->set_rules('comment','Comment is required','trim|required');

	    	if ($this->form_validation->run() == TRUE) {

	    		$comment = $this->input->post('comment');

	    		$this->load->model("project_comments_model");
	    		$comment_data = array(
	    								'user_id' => $this->data['user_id'],
	    								'project_id' => $project_id,
	    								'comment' => $comment,
	    								'privilege' => 1
	    							);
				$this->project_comments_model->add($comment_data);

				if ($this->data['role_id'] == 217) {
		    		$this->chairman_mail($project_id);
		    	}
				// $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);

				// $this->load->model("owning_signatures_model");
				// $approvers = $this->owning_signatures_model->getby_owning_signed($project_id);

				// $mails = array();

				// foreach ($approvers as $approver) {
				// 	$mails[] = $approver['email'];
				// }

				// $this->comment_alert($user->fullname, $comment, $code, $mails);
			}
	    }
	    $this->load->model('projects_model');
		$this->data['project'] = $this->projects_model->get_project_code($project_id);
	    redirect('/project_owning/review/'.$this->data['project']['id']);
	}

		private function chairman_mail($project_id) {
	      	$this->load->library('email');
	      	$this->load->helper('url');
	      	$project_url = base_url().'/project_owning/review/'.$project_id;
	      	$this->email->from('e-signature@sunrise-resorts.com');
	      	$this->email->to('abeer@sunrise.eg');
	      	$this->email->subject("Project No. #{$project_id} Owning form");
	      	$this->email->message("Dear Madam Abber,
		        <br/>
		        <br/>
		        Mr Hossam Commented on Project No. #{$project_id} Owning form, Please use the link below:
		        <br/>
		        <a href='{$project_url}' target='_blank'>{$project_url}</a>
		        <br/>
      		"); 
      		$mail_result = $this->email->send();
    	}

	public function delay_reason($project_id) {
		$this->load->model('projects_model');
		$this->data['project'] = $this->projects_model->get_project_code($project_id);
		if ($this->data['project']['code']) {
			$type = 2;
		}else{
			$type = 1;
		}
		if ($this->input->post('submit')) {
			$this->load->library('form_validation');
			$this->form_validation->set_rules('delay_reason','Comment is required','trim|required');
	    	if ($this->form_validation->run() == TRUE) {
	    		$signe_id = $this->input->post('signe_id');
	    		$delay_reason = $this->input->post('delay_reason');
	    		$this->load->model("owning_signatures_model");
				$this->owning_signatures_model->add_reason($signe_id, $delay_reason);
			}
	    }
	    redirect('/project_owning/review/'.$project_id.'/'.$type);
	}

}