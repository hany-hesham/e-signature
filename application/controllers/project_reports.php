<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Project_reports extends CI_Controller {

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
			$this->data['menu']['active'] = "reports";
		}

		public function _remap($method, $params = array()) {
			if(is_numeric($method)) {
				$this->index($method);
			} else {
			    if (method_exists($this, $method))
			    {
			        return call_user_func_array(array($this, $method), $params);
			    }
			    show_404();
			}
		}

		private function get_signers($project_id) {
			$this->load->model('Projects_model');
			$this->load->model('project_signatures_model');
			$this->load->model('users_model');
			$signers = array();
			$project = $this->Projects_model->get_project($project_id);
			$signatures = $this->project_signatures_model->getby_project_verbal($project_id, $project['change_amend']);
			foreach ($signatures as $signature) {
				$signers[$signature['id']] = array();
				$signers[$signature['id']]['role'] = $signature['role'];
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
				}
			}
			return $signers;
		}

		public function unplanned_chairman($no_hotels = NUll) {
			$this->load->helper('form');
			$this->load->model('hotels_model');
			$this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
			if ($this->input->post('submit')) {
				$state = $this->input->post('state');
				$hotel = ($no_hotels) ? NULL : $this->input->post('hotel');
				if ($state == 12) {
					$states = array($state);
				} else if ($state == 4) {
					$states = array(4,33);
				} else if ($state == 7) {
					$states = array(7,8,9);
				} else {
					$states = array(4,5,6,7,8,9,12,33);
				}
				$from_date = $this->input->post('from');
				$to_date = $this->input->post('to');
				$from_date .="-01 00:00:00";
				$to_date .= "-31 23:59:59";
				$this->load->model('project_reports_model');
				$this->load->model('suppliers_model');
				$projects = $this->project_reports_model->get_projects_unplanned($states, $from_date, $to_date, $hotel);
				$this->data['total'] = 0;
				foreach ($projects as $key => $project) {
					$this->data['total'] += $project['cost'];
					$projects[$key]['suppliers'] = $this->suppliers_model->getby_project($project['id']);
					$projects[$key]['approvals'] = $this->get_signers($project['id']);
				}
				$this->data['projects'] = $projects;
				$this->data['posting'] = TRUE;
			}
			$this->data['no_hotels'] = ($no_hotels)? TRUE : FALSE;
			$this->load->view('projects_unplanned_report', $this->data);
		}


		public function all_project_chairman($no_hotels = NUll) {
			$this->load->helper('form');
			$this->load->model('hotels_model');
			$this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
			if ($this->input->post('submit')) {
				$state = $this->input->post('state');
				$hotel = ($no_hotels) ? NULL : $this->input->post('hotel');
				if ($state == 12) {
					$states = array($state);
				} else if ($state == 4) {
					$states = array(4,33);
				} else if ($state == 99) {
					$states = array(4);
				} else if ($state == 7) {
					$states = array(7,8,9);
				} else {
					$states = array(4,5,6,7,8,9,12,33);
				}
				$from_date = $this->input->post('from');
				$to_date = $this->input->post('to');
				$from_date .="-01 00:00:00";
				$to_date .= "-31 23:59:59";
				$this->load->model('project_reports_model');
				$this->load->model('suppliers_model');
				$projects = $this->project_reports_model->get_all_projects_report($states, $from_date, $to_date, $hotel);
				$this->data['total'] = 0;
				foreach ($projects as $key => $project) {
					$this->data['total'] += $project['cost'];
					$projects[$key]['suppliers'] = $this->suppliers_model->getby_project($project['id']);
					$projects[$key]['approvals'] = $this->get_signers($project['id']);
				}
				$this->data['projects'] = $projects;
				$this->data['posting'] = TRUE;
			}
			$this->data['no_hotels'] = ($no_hotels)? TRUE : FALSE;
			$this->load->view('projects_all_report', $this->data);
		}


		public function projects_all_report_progress($no_hotels = NUll) {
			$this->load->helper('form');
			$this->load->model('hotels_model');
			$this->load->model('project_reports_model');
			$this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
			if ($this->input->post('submit')) {
				$state = $this->input->post('state');
				if ($state == 1) {
					$states = array($state);
					$status = 1;
				} else if ($state == 2) {
					$states = array(2);
					$status = 2;
				} else if ($state == 3) {
					$states = array(3);
					$status = 3;
				} else if ($state == 4) {
					$states = array(4);
					$status = 4;
				} else if ($state == 5) {
					$states = 5;
					$status = 5;
				} else if ($state == 6) {
					$states = array(6);
					$status = 6;
				} else {
					$states = array(1,2,3,4,5,6);
					$status = 0;
				}
				$from_date = $this->input->post('from');
				$to_date = $this->input->post('to');
				if ($status != 0) {
					$this->data['status'] = $this->project_reports_model->get_status($status);
				}
				$this->data['from'] = $from_date;
				$this->data['to'] = $to_date;
				$this->data['from'] .="-01";
				$this->data['to'] .= "-31";
				$from_date .="-01 00:00:00";
				$to_date .= "-31 23:59:59";
				$this->load->model('project_reports_model');
				$this->load->model('suppliers_model');
				if ($states != 5) {
					$projects = $this->project_reports_model->get_projects_progress_month($states, $from_date, $to_date);
				}else {
					$today = date('Y-m-d H:i:s');
					$projects = $this->project_reports_model->get_projects_progress_delay($today, $from_date, $to_date);
					$projects1 = $this->project_reports_model->get_projects_done($from_date, $to_date);
					foreach ($projects1 as $project) {
						if ($project['new_date']) {
							if ($project['new_date'] > $project['end']) {
								array_push($projects, $project);
							}
						}else{
							if ($project['done_date'] > $project['end']) {
								array_push($projects, $project);
							}
						}
					}
				}
				$this->data['total'] = 0;
				$this->data['total_true'] = 0;
				foreach ($projects as $key => $project) {
					$this->data['total'] += $project['cost'];
					$projects[$key]['suppliers'] = $this->suppliers_model->getby_project($project['id']);
					$projects[$key]['approvals'] = $this->get_signers($project['id']);
				}
				foreach ($projects as $key => $project) {
					$this->data['total_true'] += $project['true'];
					$projects[$key]['suppliers'] = $this->suppliers_model->getby_project($project['id']);
					$projects[$key]['approvals'] = $this->get_signers($project['id']);
				}
				$this->data['projects'] = $projects;
				$this->data['posting'] = TRUE;
			}
			$this->data['no_hotels'] = ($no_hotels)? TRUE : FALSE;
			$this->load->view('projects_all_report_progress', $this->data);
		}

		public function project_cost_report() {
			$this->load->helper('form');
			$this->load->model('hotels_model');
			$this->load->model('project_reports_model');
			$this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
			if ($this->input->post('submit')) {
				$state = $this->input->post('state');
				$from_date = $this->input->post('from');
				$to_date = $this->input->post('to');
				$this->data['state'] = $state;
				$this->data['from'] = $from_date;
				$this->data['to'] = $to_date;
				$this->data['from'] .="-01";
				$this->data['to'] .= "-31";
				$from_date .="-01 00:00:00";
				$to_date .= "-31 23:59:59";
				$this->load->model('project_reports_model');
				$this->load->model('suppliers_model');
				$projects = $this->project_reports_model->get_projects_cost_month($from_date, $to_date);
				$this->data['total'] = 0;
				$this->data['total_true'] = 0;
				foreach ($projects as $key => $project) {
					$projects[$key]['difference'] = $project['cost'] - $project['true'];
					$projects[$key]['suppliers'] = $this->suppliers_model->getby_project($project['id']);
					$projects[$key]['approvals'] = $this->get_signers($project['id']);
				}
				$this->data['difference'] = $this->data['total'] - $this->data['total_true'];
				$this->data['projects'] = $projects;
				$this->data['posting'] = TRUE;
			}
			$this->load->view('projects_all_report_cost', $this->data);
		}

		public function project_cost_report_month() {
			$this->load->helper('form');
			$this->load->model('hotels_model');
			$this->load->model('project_reports_model');
			$this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
			if ($this->input->post('submit')) {
				$state = $this->input->post('state');
				$hotel = $this->input->post('hotel');
				$from_date = $this->input->post('from');
				$to_date = $this->input->post('to');
				$this->data['state'] = $state;
				$this->data['from'] = $from_date;
				$this->data['to'] = $to_date;
				$this->data['from'] .="-01";
				$this->data['to'] .= "-31";
				$from_date .="-01 00:00:00";
				$to_date .= "-31 23:59:59";
				$this->load->model('project_reports_model');
				$this->load->model('suppliers_model');
				if ($hotel != NULL) {
					$this->data['hotel'] = $this->hotels_model->get_by_id($hotel);
				}
				$projects = $this->project_reports_model->get_projects_cost_month($from_date, $to_date, $hotel);
				$this->data['total'] = 0;
				$this->data['total_true'] = 0;
				foreach ($projects as $key => $project) {
					$projects[$key]['difference'] = $project['cost'] - $project['true'];
					$projects[$key]['suppliers'] = $this->suppliers_model->getby_project($project['id']);
					$projects[$key]['approvals'] = $this->get_signers($project['id']);
				}
				$this->data['projects'] = $projects;
				$this->data['posting'] = TRUE;
			}
			$this->load->view('projects_all_report_cost_month', $this->data);
		}

		public function project_progress_report_month($no_hotels = NUll) {
			$this->load->helper('form');
			$this->load->model('hotels_model');
			$this->load->model('project_reports_model');
			$this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
			if ($this->input->post('submit')) {
				$state = $this->input->post('state');
				$hotel = $this->input->post('hotel');
				if ($state == 1) {
					$states = array($state);
					$status = 1;
				} else if ($state == 2) {
					$states = array(2);
					$status = 2;
				} else if ($state == 3) {
					$states = array(3);
					$status = 3;
				} else if ($state == 4) {
					$states = array(4);
					$status = 4;
				} else if ($state == 5) {
					$states = 5;
					$status = 5;
				} else if ($state == 6) {
					$states = array(6);
					$status = 6;
				} else {
					$states = array(1,2,3,4,5,6);
					$status = 0;
				}
				$from_date = $this->input->post('from');
				$to_date = $this->input->post('to');
				if ($hotel != NULL) {
					$this->data['hotel'] = $this->hotels_model->get_by_id($hotel);
				}
				if ($status != 0) {
					$this->data['status'] = $this->project_reports_model->get_status($status);
				}
				$this->data['from'] = $from_date;
				$this->data['to'] = $to_date;
				$this->data['from'] .="-01";
				$this->data['to'] .= "-31";
				$from_date .="-01 00:00:00";
				$to_date .= "-31 23:59:59";
				$this->load->model('project_reports_model');
				$this->load->model('suppliers_model');
				if ($states != 5) {
					$projects = $this->project_reports_model->get_projects_progress_month($states, $from_date, $to_date, $hotel);
				}else {
					$today = date('Y-m-d H:i:s');
					$projects = $this->project_reports_model->get_projects_progress_delay($today, $from_date, $to_date, $hotel);
					$projects1 = $this->project_reports_model->get_projects_done($from_date, $to_date, $hotel);
					foreach ($projects1 as $project) {
						if ($project['new_date']) {
							if ($project['new_date'] > $project['end']) {
								array_push($projects, $project);
							}
						}else{
							if ($project['done_date'] > $project['end']) {
								array_push($projects, $project);
							}
						}
					}
				}
				$this->data['total'] = 0;
				$this->data['total_true'] = 0;
				foreach ($projects as $key => $project) {
					$this->data['total'] += $project['cost'];
					$projects[$key]['suppliers'] = $this->suppliers_model->getby_project($project['id']);
					$projects[$key]['approvals'] = $this->get_signers($project['id']);
				}
				foreach ($projects as $key => $project) {
					$this->data['total_true'] += $project['true'];
					$projects[$key]['suppliers'] = $this->suppliers_model->getby_project($project['id']);
					$projects[$key]['approvals'] = $this->get_signers($project['id']);
				}
				$this->data['projects'] = $projects;
				$this->data['posting'] = TRUE;
			}
			$this->data['no_hotels'] = ($no_hotels)? TRUE : FALSE;
			$this->load->view('projects_all_report_progress_month', $this->data);
		}

		public function project_delay_report($no_hotels = NUll) {
			$this->load->helper('form');
			$this->load->model('hotels_model');
			$this->load->model('project_reports_model');
			$this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
			if ($this->input->post('submit')) {
				$state = $this->input->post('state');
				$hotel = $this->input->post('hotel');
				$from_date = $this->input->post('from');
				$to_date = $this->input->post('to');
				if ($hotel != NULL) {
					$this->data['hotel'] = $this->hotels_model->get_by_id($hotel);
				}
				$this->data['states'] = $state;
				$this->data['from'] = $from_date;
				$this->data['to'] = $to_date;
				$this->data['from'] .="-01";
				$this->data['to'] .= "-31";
				$from_date .="-01 00:00:00";
				$to_date .= "-31 23:59:59";
				$this->load->model('project_reports_model');
				$this->load->model('suppliers_model');
				$today = date('Y-m-d H:i:s');
				if ($state == 0) {
					$projects = $this->project_reports_model->get_projects_progress_delay($today, $from_date, $to_date, $hotel);
					/*$projects1 = $this->project_reports_model->get_projects_new_delay($today, $from_date, $to_date, $hotel);
					foreach ($projects1 as $project) {
						array_push($projects, $project);
					}
					$projects2 = $this->project_reports_model->get_projects_in_delay($today, $from_date, $to_date, $hotel);
					foreach ($projects2 as $project) {
						array_push($projects, $project);
					}*/
					$projects3 = $this->project_reports_model->get_projects_done_delay($from_date, $to_date, $hotel);
					foreach ($projects3 as $project) {
						$end_date = $project['end'];
						$end_date .= " 23:59:59";
						if ($project['done_date'] > $end_date) {
							array_push($projects, $project);
						}
					}
					/*$projects4 = $this->project_reports_model->get_projects_done_new_delay($from_date, $to_date, $hotel);
					foreach ($projects4 as $project) {
						$end_date = $project['new_date'];
						$end_date .= " 23:59:59";
						if ($project['done_date'] > $end_date) {
							array_push($projects, $project);
						}
					}*/
				}elseif ($state == 1) {
					$projects = $this->project_reports_model->get_projects_progress_delay($today, $from_date, $to_date, $hotel);
					/*$projects1 = $this->project_reports_model->get_projects_new_delay($today, $from_date, $to_date, $hotel);
					foreach ($projects1 as $project) {
						array_push($projects, $project);
					}
					$projects2 = $this->project_reports_model->get_projects_in_delay($today, $from_date, $to_date, $hotel);
					foreach ($projects2 as $project) {
						array_push($projects, $project);
					}*/
				}elseif ($state == 2) {
					$projects = array();
					$projects3 = $this->project_reports_model->get_projects_done_delay($from_date, $to_date, $hotel);
					foreach ($projects3 as $project) {
						$end_date = $project['end'];
						$end_date .= " 23:59:59";
						if ($project['done_date'] > $end_date) {
							array_push($projects, $project);
						}
					}
					/*$projects4 = $this->project_reports_model->get_projects_done_new_delay($from_date, $to_date, $hotel);
					foreach ($projects4 as $project) {
						$end_date = $project['new_date'];
						$end_date .= " 23:59:59";
						if ($project['done_date'] > $end_date) {
							array_push($projects, $project);
						}
					}*/
				}
				$this->data['total'] = 0;
				$this->data['total_true'] = 0;
				foreach ($projects as $key => $project) {
					$this->data['total'] += $project['cost'];
					$projects[$key]['suppliers'] = $this->suppliers_model->getby_project($project['id']);
					$projects[$key]['approvals'] = $this->get_signers($project['id']);
				}
				foreach ($projects as $key => $project) {
					$this->data['total_true'] += $project['true'];
					$projects[$key]['suppliers'] = $this->suppliers_model->getby_project($project['id']);
					$projects[$key]['approvals'] = $this->get_signers($project['id']);
				}
				$this->data['projects'] = $projects;
				$this->data['posting'] = TRUE;
			}
			$this->data['no_hotels'] = ($no_hotels)? TRUE : FALSE;
			$this->load->view('projects_all_report_delay', $this->data);
		}

		/*public function project_delay_report($no_hotels = NUll) {
			if ($this->data['owning_company'] || ($this->data['chairman'] || $this->data['is_admin'])) {
				$this->load->helper('form');
				$this->load->model('hotels_model');
				$this->load->model('project_reports_model');
				$this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
				if ($this->input->post('submit')) {
					$states = $this->input->post('state');
					$hotel = $this->input->post('hotel');
					//die(print_r($hotel));
					$from_date = $this->input->post('from');
					$to_date = $this->input->post('to');
					if ($hotel != NULL) {
						$this->data['hotel'] = $this->hotels_model->get_by_id($hotel);
					}
					$this->data['states'] = $states;
					$this->data['from'] = $from_date;
					$this->data['to'] = $to_date;
					$this->data['from'] .="-01";
					$this->data['to'] .= "-31";
					$from_date .="-01 00:00:00";
					$to_date .= "-31 23:59:59";
					$this->load->model('project_reports_model');
					$this->load->model('suppliers_model');
					if ($states == 1 || $states == 0) {
						$today = date('Y-m-d H:i:s');
						$projects = $this->project_reports_model->get_projects_progress_delay($today, $from_date, $to_date, $hotel);
						$projects1 = $this->project_reports_model->get_projects_done($from_date, $to_date, $hotel);
						foreach ($projects1 as $project) {
							if ($project['new_date']) {
								if ($project['new_date'] > $project['end']) {
									array_push($projects, $project);
								}
							}else{
								if ($project['done_date'] > $project['end']) {
									array_push($projects, $project);
								}
							}
						}
					}elseif ($states == 2) {
						$today = date('Y-m-d H:i:s');
						$projects = $this->project_reports_model->get_projects_progress_delay($today, $from_date, $to_date, $hotel);
					}elseif ($states == 3) {
						$today = date('Y-m-d H:i:s');
						$projects = array();
						$projects1 = $this->project_reports_model->get_projects_done($from_date, $to_date, $hotel);
						foreach ($projects1 as $project) {
							if ($project['new_date']) {
								if ($project['new_date'] > $project['end']) {
									array_push($projects, $project);
								}
							}else{
								if ($project['done_date'] > $project['end']) {
									array_push($projects, $project);
								}
							}
						}
					}
					$this->data['total'] = 0;
					$this->data['total_true'] = 0;
					foreach ($projects as $key => $project) {
						$this->data['total'] += $project['cost'];
						$projects[$key]['suppliers'] = $this->suppliers_model->getby_project($project['id']);
						$projects[$key]['approvals'] = $this->get_signers($project['id']);
					}
					foreach ($projects as $key => $project) {
						$this->data['total_true'] += $project['true'];
						$projects[$key]['suppliers'] = $this->suppliers_model->getby_project($project['id']);
						$projects[$key]['approvals'] = $this->get_signers($project['id']);
					}
					$this->data['projects'] = $projects;
					$this->data['posting'] = TRUE;
				}
				$this->data['no_hotels'] = ($no_hotels)? TRUE : FALSE;
				$this->load->view('projects_all_report_delay', $this->data);
			}else{
		      redirect('/unknown');
		    }
		}*/

		public function all_projects() {
			$this->load->helper('form');
			$this->load->model('hotels_model');
			$this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
			if ($this->input->post('submit')) {
				$state = $this->input->post('state');
				$hotel = $this->input->post('hotel');
				if ($state == 12) {
					$states = array($state);
				} else if ($state == 4) {
					$states = array(4,33);
				} else if ($state == 7) {
					$states = array(7,8,9);
				} else {
					$states = array(4,5,6,7,8,9,12,33);
				}
				$from_date = $this->input->post('from');
				$to_date = $this->input->post('to');
				$from_date .="-01 00:00:00";
				$to_date .= "-31 23:59:59";
				$this->load->model('project_reports_model');
				$this->load->model('suppliers_model');
				$projects = $this->project_reports_model->get_projects($hotel, $states, $from_date, $to_date);
				$this->data['total'] = 0;
				foreach ($projects as $key => $project) {
					$this->data['total'] += $project['cost'];
					$projects[$key]['suppliers'] = $this->suppliers_model->getby_project($project['id']);
					$projects[$key]['approvals'] = $this->get_signers($project['id']);
				}
				$this->data['projects'] = $projects;
				$this->data['posting'] = TRUE;
			}
			$this->load->view('projects_report', $this->data);
		}

		public function all_projects_progress($no_hotels = NUll) {
			$this->load->helper('form');
			$this->load->model('hotels_model');
			$this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
			if ($this->input->post('submit')) {
				$state = $this->input->post('state');
				$hotel = $this->input->post('hotel');
				if ($state == 1) {
					$states = array($state);
				} else if ($state == 2) {
					$states = array(2);
				} else if ($state == 3) {
					$states = array(3);
				} else if ($state == 4) {
					$states = array(4);
				} else if ($state == 5) {
					$states = array(5);
				} else if ($state == 6) {
					$states = array(6);
				} else {
					$states = array(1,2,3,4,5,6);
				}
				$from_date = $this->input->post('from');
				$to_date = $this->input->post('to');
				$from_date .="-01 00:00:00";
				$to_date .= "-31 23:59:59";
				$this->load->model('project_reports_model');
				$this->load->model('suppliers_model');
				$projects = $this->project_reports_model->get_projects($hotel, $states, $from_date, $to_date);
				$this->data['total'] = 0;
				foreach ($projects as $key => $project) {
					$this->data['total'] += $project['cost'];
					$projects[$key]['suppliers'] = $this->suppliers_model->getby_project($project['id']);
					$projects[$key]['approvals'] = $this->get_signers($project['id']);
				}
				$this->data['projects'] = $projects;
				$this->data['posting'] = TRUE;
			}
			$this->data['no_hotels'] = ($no_hotels)? TRUE : FALSE;
			$this->load->view('projects_report_progress', $this->data);
		}

		public function all_projects_approval($no_hotels = FALSE) {
			$this->load->helper('form');
			$this->load->model('hotels_model');
			$this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
			if ($this->input->post('submit')) {
				$role = $this->input->post('role');
				$hotel = $this->input->post('hotel');
				$from_date = $this->input->post('from');
				$to_date = $this->input->post('to');
				$from_date .="-01 00:00:00";
				$to_date .= "-31 23:59:59";
				$this->load->model('project_reports_model');
				$this->load->model('suppliers_model');
				$this->load->model('Projects_model');
				$project_ids = $this->project_reports_model->get_projects_approval($role, $from_date, $to_date, $hotel);
				$projects = array();
				foreach ($project_ids as $project_id) {
					$proj = $this->Projects_model->get_project($project_id['project_id']);
					array_push($projects, $proj);
				}
				$this->data['total'] = 0;
				foreach ($projects as $key => $project) {
					$this->data['total'] += $project['cost'];
					$projects[$key]['suppliers'] = $this->suppliers_model->getby_project($project['id']);
					$projects[$key]['approvals'] = $this->get_signers($project['id']);
				}
				$this->data['projects'] = $projects;
				$this->data['posting'] = TRUE;
			}
			$this->data['no_role'] = TRUE;
			$this->data['no_hotels'] = ($no_hotels)? TRUE : FALSE;
			$this->load->view('projects_approval_report', $this->data);
		}

		public function all_projects_approved($no_hotels = FALSE) {
			$this->load->helper('form');
			$this->load->model('hotels_model');
			$this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
			if ($this->input->post('submit')) {
				$hotel = $this->input->post('hotel');
				$from_date = $this->input->post('from');
				$to_date = $this->input->post('to');
				$from_date .="-01 00:00:00";
				$to_date .= "-31 23:59:59";
				$this->load->model('project_reports_model');
				$this->load->model('suppliers_model');
				$this->load->model('Projects_model');
				$project_ids = $this->project_reports_model->get_projects_approved($from_date, $to_date, $hotel);
				$projects = array();
				foreach ($project_ids as $project_id) {
					$proj = $this->Projects_model->get_project($project_id['project_id']);
					array_push($projects, $proj);
				}
				$this->data['total'] = 0;
				foreach ($projects as $key => $project) {
					$this->data['total'] += $project['cost'];
					$projects[$key]['suppliers'] = $this->suppliers_model->getby_project($project['id']);
					$projects[$key]['approvals'] = $this->get_signers($project['id']);
				}
				$this->data['projects'] = $projects;
				$this->data['posting'] = TRUE;
			}
			$this->data['no_role'] = FALSE;
			$this->data['no_hotels'] = ($no_hotels)? TRUE : FALSE;
			$this->load->view('projects_approval_report', $this->data);
		}


		public function all_projects_delayed($no_hotels = NUll) {
			$this->load->helper('form');
			$this->load->model('hotels_model');
			$this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
			if ($this->input->post('submit')) {
				$hotel = ($no_hotels) ? NULL : $this->input->post('hotel');
				$from_date = $this->input->post('from');
				$to_date = $this->input->post('to');
				$from_date .="-01 00:00:00";
				$to_date .= "-31 23:59:59";
				$this->load->model('project_reports_model');
				$this->load->model('suppliers_model');
				$projects = $this->project_reports_model->get_projects_delayed($hotel, $from_date, $to_date);
				$this->data['total'] = 0;
				foreach ($projects as $key => $project) {
					$this->data['total'] += $project['cost'];
					$projects[$key]['suppliers'] = $this->suppliers_model->getby_project($project['id']);
					$projects[$key]['approvals'] = $this->get_signers($project['id']);
				}
				$this->data['projects'] = $projects;
				$this->data['posting'] = TRUE;
			}
			$this->data['no_hotels'] = ($no_hotels)? TRUE : FALSE;
			$this->load->view('projects_all_report_delayed', $this->data);
		}

		public function like_all() {
	    	$this->load->helper('form');
		    if ($this->input->post('submit')) {
	      	$this->load->library('form_validation');
	      	$this->form_validation->set_rules('from','From','trim|required');
	      	$this->form_validation->set_rules('to','To','trim|required');
		      	if ($this->form_validation->run() == TRUE) {
					$this->data['posting'] = TRUE;
			      	$from_date = $this->input->post('from');
					$to_date = $this->input->post('to');
					$from_date .="-01 00:00:00";
					$to_date .= "-31 23:59:59";
			      	$project = $this->input->post('project');
					$this->load->model('Project_reports_model');
			    	$this->load->model('hotels_model');   
			    	$this->data['hotels'] = $this->hotels_model->getall();
			    	$this->data['app'] = $this->Project_reports_model->getall_projects($project, $from_date, $to_date);
			  	}
		 	}
			$this->load->model('Project_reports_model');
			$this->data['project'] = $this->Project_reports_model->get_all_projects();
	    	$this->load->view('item_project_report', $this->data);
    	}

    	public function project_owning_delay_report($type, $no_hotels = NUll) {
			$this->load->helper('form');
			$this->load->model('hotels_model');
			$this->load->model('projects_model');
			$this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
			$this->data['states'] = $this->projects_model->get_all_signers();
			$this->data['type']=$type;
			if ($this->input->post('submit')) {
				$hotel = ($no_hotels) ? $this->input->post('hotel'): NULL;
				$state = $this->input->post('state');
				$from_date = $this->input->post('from');
				$to_date = $this->input->post('to');
				if ($hotel != NULL) {
					$this->data['hotel'] = $this->hotels_model->get_by_id($hotel);
				}
				if ($state != NULL) {
					$this->data['state'] = $this->projects_model->get_signerby_id($state);
				}
				if (($from_date != NULL) && ($to_date != NULL)) {
					$this->data['from'] = $from_date;
					$this->data['to'] = $to_date;
					$this->data['from'] .="-01";
					$this->data['to'] .= '-'.date("t", strtotime($to_date));
					$from_date .="-01 00:00:00";
					$to_date .= "-30 23:59:59";
				}
				$this->load->model('project_reports_model');
				$this->load->model('suppliers_model');
				$today = date('Y-m-d');
				$approved = array();
				if ($type == 2) {
					$approved = array('0' => 7, '1' => 8, '2' => 9, '3' => 12);
				}elseif ($type == 1) {
					$approved = array('0' => 2, '1' => 3, '2' => 33, '3' => 4, '4' => 7, '5' => 8, '6' => 9, '7' => 12);
				}
				$projects1 = $this->project_reports_model->get_unsigned_owning_delay($today, $from_date, $to_date, $hotel, $state, $type, $approved);
				/*
				$projects2 = $this->project_reports_model->get_signed_owning_delay($from_date, $to_date, $hotel, $state, $type);
				foreach ($projects2 as $project) {
					$deadline = $project['dead_line'];
					$deadline .=" 00:00:00";
					$timestamp = $project['timestamp'];
					if ($timestamp > $deadline) {
						array_push($projects1, $project);
					}
				}
				*/
				$projects3 = array();
				foreach ($projects1 as $project4) {
					$projects3[] = $project4['project_id'];
				}
				if ($projects3) {
					$projects = $this->project_reports_model->get_all_projects_byid($projects3);
					$this->data['total'] = 0;
					$this->data['total_true'] = 0;
					foreach ($projects as $key => $project) {
						/*if ($projects[$key]['code']) {
							$type = 2;
						}else{
							$type = 1;
						}*/
						$projects[$key]['owning_signatures'] = $this->project_reports_model->get_owning_signature($projects[$key]['id'], $type, $today, $state);
						$projects[$key]['approvals'] = $this->get_signers($projects[$key]['id']);
					}
					$this->data['projects'] = $projects;
				}else{
					$this->data['projects'] = array();
				}
				$this->data['posting'] = TRUE;
			}
			$this->data['no_hotels'] = ($no_hotels)? TRUE : FALSE;
			$this->load->view('projects_all_report_delay_owning', $this->data);
		}

		public function all_projects_unplanned($no_hotels = NUll) {
			$this->load->helper('form');
			$this->load->model('hotels_model');
			$this->load->model('projects_model');
			$this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
			$this->data['states'] = $this->projects_model->get_all_origin();
			if ($this->input->post('submit')) {
				$hotel = ($no_hotels) ? $this->input->post('hotel'): NULL;
				$state = $this->input->post('state');
				$from_date = $this->input->post('from');
				$to_date = $this->input->post('to');
				if ($hotel != NULL) {
					$this->data['hotel'] = $this->hotels_model->get_by_id($hotel);
				}
				if ($state != NULL) {
					$this->data['state'] = $this->projects_model->get_originby_id($state);
				}
				if (($from_date != NULL) && ($to_date != NULL)) {
					$this->data['from'] = $from_date;
					$this->data['to'] = $to_date;
					$this->data['from'] .="-01";
					$this->data['to'] .= "-31";
					$from_date .="-01 00:00:00";
					$to_date .= "-31 23:59:59";
				}
				$this->load->model('project_reports_model');
				$projects = $this->project_reports_model->get_projects_bytype($hotel, $state, $from_date, $to_date);
				$this->data['total'] = 0;
				$this->data['total_budget'] = 0;
				$this->data['total_true'] = 0;
				foreach ($projects as $key => $project) {
					$this->data['total'] += $project['cost'];
					$this->data['total_budget'] += $project['budget'];
					$this->data['total_true'] += $project['true'];
				}
				$this->data['projects'] = $projects;
				$this->data['posting'] = TRUE;
			}
			$this->data['no_hotels'] = ($no_hotels)? TRUE : FALSE;
			$this->load->view('projects_all_report_type', $this->data);
		}

	}

?>