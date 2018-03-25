<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Madar extends CI_Controller {
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
		$this->data['menu']['active'] = "madars";
		$this->load->library('logger');
	}
	public function index($state = FALSE) {
		if ((isset($this->data['is_admin']) && $this->data['is_admin'])) {


			$this->load->model('hotels_model');

			$user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
			$hotels = array();
			$this->load->model('madar_model');
			$this->data['projects'] = $this->madar_model->get_requests($hotels);
			foreach ($this->data['projects'] as $key => $project) {
				$this->data['projects'][$key]['approvals'] = $this->get_approvers($this->data['projects'][$key]['id'], $this->data['projects'][$key]['hotel_id']);
			}
			$this->data['hotels'] = $this->hotels_model->getall();

			$user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);

			$this->data['submenu']['active'] = "Madar Project";

			$this->load->view('madar', $this->data);
		}else{
	      redirect('/unknown');
	    }
	}

	private function approvals_mail($role, $name, $mail, $project_id) {
		$this->load->library('email');
		$this->load->helper('url');

		$project_url = base_url().'madar/view/'.$project_id;
		
		$this->email->from('e-signature@sunrise-resorts.com');
		$this->email->to($mail);

		$this->email->subject("Madar Project #{$project_id}");
		$this->email->message("Dear {$name},<br/>
							<br/>
							Madar Project #{$project_id} requires your approval, Please use the link below:<br/>
							<a href='{$project_url}' target='_blank'>{$project_url}</a><br/>

							");	

		$mail_result = $this->email->send();
	}


	private function get_approvers($project_id, $hotel_id) {
		$this->load->model('madar_approvals_model');
		$this->load->model('users_model');

		$approvers = array();
		$approvals = $this->madar_approvals_model->getby_project_verbal($project_id);

		foreach ($approvals as $approval) {
			$approvers[$approval['id']] = array();
			$approvers[$approval['id']]['role'] = $approval['role'];

			if ($approval['user_id']) {
				$approvers[$approval['id']]['sign'] = array();
				$approvers[$approval['id']]['sign']['id'] = $approval['user_id'];
				if ($approval['reject'] == 1) {
					$approvers[$approval['id']]['sign']['reject'] = "reject";
				} 
				$user = $this->users_model->get_user_by_id($approval['user_id'], TRUE);

				$approvers[$approval['id']]['sign']['name'] = $user->fullname;
				$approvers[$approval['id']]['sign']['mail'] = $user->email;
				$approvers[$approval['id']]['sign']['sign'] = $user->signature;
				$approvers[$approval['id']]['sign']['timestamp'] = $approval['timestamp'];
			} else {
				$approvers[$approval['id']]['queue'] = array();
				$users = $this->users_model->getby_criteria($approval['role_id'], $hotel_id);
				foreach ($users as $use) {
					$approvers[$approval['id']]['queue'][$use['id']] = array();
					$approvers[$approval['id']]['queue'][$use['id']]['name'] = $use['fullname'];
					$approvers[$approval['id']]['queue'][$use['id']]['mail'] = $use['email'];
				}

			}
		}

		return $approvers;
	}

	private function notify_approvers($project_id) {
		$notified = FALSE;
		$approvers = $this->get_approvers($project_id, $this->data['project']['hotel_id']);
		foreach ($approvers as $approver) {
			if (isset($approver['queue'])) {
				$notified = TRUE;
				foreach ($approver['queue'] as $uid => $user) {
					$this->approvals_mail($approver['role'], $user['name'], $user['mail'], $project_id);
				}
				break;
			}
		}
		return $notified;
	}


	public function request_stage($id) {

		$this->load->model('madar_model');
		$this->data['project'] = $this->madar_model->get_request($id);

		if ($this->data['project']['state_id'] == 1) {
			$queue = $this->notify_approvers($id);
			if (!$queue) {
				$this->madar_model->update_state($id, 2);
				
				redirect('/madar/request_stage/'.$id);
			}

		} elseif ($this->data['project']['state_id'] == 0) {
			$this->madar_model->update_state($id, 1);

			redirect('/madar/request_stage/'.$id);
		} 

		redirect('/madar/view/'.$id);
	}

	private function do_upload($field) {

		$config['upload_path'] = 'assets/uploads/files/';
		$config['allowed_types'] = '*';
		
		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload($field))
		{
			$this->data['error'] = array('error' => $this->upload->display_errors());
			return FALSE;
		}
		else
		{
			$file = $this->upload->data();
			return $file['file_name'];

		}
	}

	public function add_files($project_id) {
		$file_name = $this->do_upload("files");
		if (!$file_name) {
			die(json_encode($this->data['error']));
		} else {
			$this->load->model("madar_files_model");
			$this->madar_files_model->add($project_id, $file_name);
			die("{}");
		}
	}

	public function remove_files($project_id, $id) {
		$file_name = $_POST['key'];

		if (!$id) {
			die(json_encode($this->data['error']));
		} else {
			$this->load->model("madar_files_model");
			$this->files_model->remove($id);

			die("{}");
		}
	}
	
	public function view($id) {
		if ((isset($this->data['is_admin']) && $this->data['is_admin'])) {
			$this->load->model('madar_model');
			$this->load->model("madar_comments_model");
			$this->load->model("madar_files_model");

			$this->data['project'] = $this->madar_model->get_request($id);

			$this->data['signature_path'] = '/assets/uploads/signatures/';

			$this->data['approvers'] = $this->get_approvers($id, $this->data['project']['hotel_id']);


			$editor = FALSE;
			$unsign_enable = FALSE;

			$project_staged = $this->data['project']['state_id'] >= 2;

			$first = TRUE;
			$force_edit = FALSE;

			foreach ($this->data['approvers'] as $signer) {
				if (isset($signer['queue'])) {
					foreach ($signer['queue'] as $uid => $dummy) {
						if ( $uid == $this->data['user_id'] ) {
							$editor = TRUE;
							break;
						}
					}
				} elseif (isset($signer['sign'])) {
					$unsign_enable = FALSE;
					$force_edit = FALSE;

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

		
			$this->data['comments'] = $this->madar_comments_model->getby_project($this->data['project']['id']);

			$this->data['files'] = $this->madar_files_model->getby_project($this->data['project']['id']);
			$this->data['logo_path'] = '/assets/uploads/logos/';
			$this->data['project_id'] = $id;

			$this->data['unsign_enable'] = (($unsign_enable) || $this->data['is_admin'])? TRUE : FALSE;

			$this->data['is_editor'] = ( (($this->data['unsign_enable'] || $editor) && !$project_staged) || ($force_edit && !$project_staged) )? TRUE : FALSE;
			
			$this->load->view('madar_view', $this->data);
		}else{
	      redirect('/unknown');
	    }
	}

	public function unsign($approval_id) {
		$this->load->model('madar_approvals_model');

		$approval_identity = $this->madar_approvals_model->get_approval_identity($approval_id);

		$this->load->model('madar_model');
		$this->madar_approvals_model->unsign($approval_id);
		$this->madar_model->update_state($approval_identity['project_id'], 1);


		redirect('/madar/view/'.$approval_identity['project_id']);
	}

	public function approve($approval_id, $reject = FALSE) {
		$this->load->model('madar_approvals_model');
		$approval_identity = $this->madar_approvals_model->get_approval_identity($approval_id);

		$approvers = $this->get_approvers($approval_identity['project_id'], $approval_identity['hotel_id']);

		if (array_key_exists($this->data['user_id'], $approvers[$approval_id]['queue'])) {
			if ($reject) {
				$this->madar_approvals_model->disapprove($approval_id, $this->data['user_id']);
				$this->load->model('madar_model');
				$this->madar_model->update_state($madar_identity['project_id'], 11);
				
			} else {
				$this->madar_approvals_model->approve($approval_id, $this->data['user_id']);

			}

			redirect('/madar/request_stage/'.$approval_identity['project_id']);
		}
		redirect('/madar/view/'.$approval_identity['project_id']);
	}

	public function edit($id) {
		if ((isset($this->data['is_admin']) && $this->data['is_admin'])) {
			if ($this->input->post('submit')) {

				$this->load->library('form_validation');

				$this->form_validation->set_rules('type','Project Type','trim|required');
		    	$this->form_validation->set_rules('name','Project Name','trim|required');
		    	$this->form_validation->set_rules('reason','Reason','trim|required');
				$this->form_validation->set_rules('eur_ex','EUR exchange rate','trim|number');
				$this->form_validation->set_rules('usd_ex','USD exchange rate','trim|number');
				$this->form_validation->set_rules('budget_egp','Final cost in EGP','trim|number');
				$this->form_validation->set_rules('budget_usd','Final cost in USD','trim|number');
				$this->form_validation->set_rules('budget_eur','Final cost in EUR','trim|number');
				$this->form_validation->set_rules('budget','Final cost','trim|number|required');
		    	$this->form_validation->set_rules('remarks','Remarks','trim');

		    	$assumed_id = $this->input->post('assumed_id');

		    	if ($this->form_validation->run() == TRUE) {
		    		$this->load->model('madar_model');

		    		$project_data = array(
		    							'type' => $this->input->post('type'),
		    							'name' => $this->input->post('name'),
		    							'reasons' => $this->input->post('reason'),
		    							'EUR_EX' => $this->input->post('eur_ex'),
		    							'USD_EX' => $this->input->post('usd_ex'),
		    							'budget_EGP' => $this->input->post('budget_egp'),
		    							'budget_USD' => $this->input->post('budget_usd'),
		    							'budget_EUR' => $this->input->post('budget_eur'),
		    							'budget' => $this->input->post('budget'),
		    							'remarks' => $this->input->post('remarks'),
		    							);

		    		$updated = $this->madar_model->update($id, $project_data);

		    		redirect('/madar/request_stage/'.$id);//CALL FUNCTION
		    	}
			}

			try {

				$this->load->model('madar_model');
				$this->data['project'] = $this->madar_model->get_request($id);
				$this->data['project_id'] = $id;

				$this->load->helper('form');
				$this->load->model('hotels_model');
				
				$this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());

				$this->load->model('madar_files_model');
				$this->data['assumed_id'] = $id;
				$this->data['files'] = $this->madar_files_model->getby_project($this->data['assumed_id']);

				$this->load->view('madar_edit',$this->data);
			}

			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}else{
	      redirect('/unknown');
	    }
	}

	public function submit() {
		if ((isset($this->data['is_admin']) && $this->data['is_admin'])) {

			if ($this->input->post('submit')) {

				$this->load->library('form_validation');

				$this->form_validation->set_rules('hotel','Hotel','trim|required');
				$this->form_validation->set_rules('type','Project Type','trim|required');
		    	$this->form_validation->set_rules('name','Project Name','trim|required');
		    	$this->form_validation->set_rules('reason','Reason','trim|required');
				$this->form_validation->set_rules('eur_ex','EUR exchange rate','trim|number');
				$this->form_validation->set_rules('usd_ex','USD exchange rate','trim|number');
				$this->form_validation->set_rules('budget_egp','Final cost in EGP','trim|number');
				$this->form_validation->set_rules('budget_usd','Final cost in USD','trim|number');
				$this->form_validation->set_rules('budget_eur','Final cost in EUR','trim|number');
				$this->form_validation->set_rules('budget','Final cost','trim|number|required');
		    	$this->form_validation->set_rules('remarks','Remarks','trim');

		    	$assumed_id = $this->input->post('assumed_id');

		    	if ($this->form_validation->run() == TRUE) {
		    		$this->load->model('madar_model');

		    		$project_data = array(
		    							'user_id' => $this->data['user_id'],
		    							'hotel_id' => $this->input->post('hotel'),
		    							'type' => $this->input->post('type'),
		    							'name' => $this->input->post('name'),
		    							'reasons' => $this->input->post('reason'),
		    							'EUR_EX' => $this->input->post('eur_ex'),
		    							'USD_EX' => $this->input->post('usd_ex'),
		    							'budget_EGP' => $this->input->post('budget_egp'),
		    							'budget_USD' => $this->input->post('budget_usd'),
		    							'budget_EUR' => $this->input->post('budget_eur'),
		    							'budget' => $this->input->post('budget'),
		    							'remarks' => $this->input->post('remarks'),
		    							'state_id' => 0
		    							);
		    		$project_id = $this->madar_model->create($project_data);

		    		
		    		if ($project_id) {
		    			$this->load->model('hotel_signatures_model');
		    			$this->load->model('madar_approvals_model');
		    			$hotel_approvals = $this->hotel_signatures_model->getby_hotel($project_data['hotel_id']);
		    			$do_sign = $this->madar_approvals_model->project_do_sign($project_id);
			            //die(print_r($do_sign));
			            if ($do_sign == 0) {
			    			foreach ($hotel_approvals as $hotel_approval) {
			    				$this->madar_approvals_model->add_project_approval($project_id, $hotel_approval['role_id'], $hotel_approval['rank']);
			    			}
			    		}
		    			$this->load->model('madar_files_model');
		    			$this->madar_files_model->update_files($assumed_id, $project_id);

		    		} else {
		    			die("ERROR");//@TODO failure view
		    		}
		    		redirect('/madar_owning/create/'.$project_id);//CALL FUNCTION
		    	}
			}

			try {

				$this->load->helper('form');
				$this->load->model('hotels_model');
				
				$this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());
				if ($this->input->post('submit')) {

					$this->load->model('madar_files_model');
					$this->data['assumed_id'] = $this->input->post('assumed_id');
					$this->data['files'] = $this->madar_files_model->getby_project($this->data['assumed_id']);
				} else {

					$this->data['assumed_id'] = strtoupper(str_pad(dechex( mt_rand( 0, 1048575 ) ), 5, '0', STR_PAD_LEFT));
					$this->data['files'] = array();
				}

				$this->load->view('madar_request',$this->data);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}else{
	      redirect('/unknown');
	    }
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

				$project_url = base_url().'madar/view/'.$id;
				
				$this->email->from('e-signature@sunrise-resorts.com');
				$this->email->to($mail);

				$this->email->subject("A message from {$user->fullname}, Madar Project #{$id}");
				$this->email->message("{$user->fullname} sent you a private message regarding Madar Project #{$id}:<br/>
									{$message}<br />
									<br />

									Please use the link below to view the request:
									<a href='{$project_url}' target='_blank'>{$project_url}</a><br/>

									");	

				$mail_result = $this->email->send();
			}
		}
		redirect('/madar/view/'.$id);
	}

	private function comment_alert($user_name, $comment, $project_id, $mails) {
		$this->load->library('email');
		$this->load->helper('url');

		$project_url = base_url().'requests/view/'.$project_id;
		
		$this->email->from('e-signature@sunrise-resorts.com');
		$this->email->to($mails);

		$this->email->subject("Unplanned Project Approval #{$project_id}");
		$this->email->message("{$user_name} added a comment for Unplanned Project Approval #{$project_id}:<br/>
							{$comment}<br />
							<br />

							Please use the link below to view the request
							<a href='{$project_url}' target='_blank'>{$project_url}</a><br/>

							");	

		$mail_result = $this->email->send();

	}

	public function comment($project_id) {
		if ($this->input->post('submit')) {

			$this->load->library('form_validation');

			$this->form_validation->set_rules('comment','Comment is required','trim|required');

	    	if ($this->form_validation->run() == TRUE) {

	    		$comment = $this->input->post('comment');

	    		$this->load->model("madar_comments_model");
	    		$comment_data = array(
	    								'user_id' => $this->data['user_id'],
	    								'project_id' => $project_id,
	    								'comment' => $comment
	    							);
				$this->madar_comments_model->add($comment_data);

				$user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);

				$this->load->model("madar_approvals_model");
				$approvers = $this->madar_approvals_model->getby_project_approved($project_id);

				$mails = array();

				foreach ($approvers as $approver) {
					$mails[] = $approver['email'];
				}

				$this->comment_alert($user->fullname, $comment, $project_id, $mails);
			}
	    }
	    redirect('/madar/view/'.$project_id);
	}

}