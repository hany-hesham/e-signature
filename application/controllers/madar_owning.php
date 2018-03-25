<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Madar_owning extends CI_Controller {
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
      		/*			$this->data['department_id'] = $this->tank_auth->get_department();
			$this->data['chairman'] = $this->tank_auth->is_chairman();
*/
			// if (!$this->data['owning_company'] && !$this->data['is_admin']) {
			// 	redirect('/projects');
			// }
		}
		$this->data['menu']['active'] = "madar";
		$this->load->library('logger');
	}
	
	public function index($state = FALSE) {
    if ((isset($this->data['is_admin']) && $this->data['is_admin'])) {
			$this->load->model('hotels_model');
			$user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
			$hotels = array();

			$this->load->model('madar_owning_model');
			$this->data['projects'] = $this->madar_owning_model->get_projects($hotels);
			foreach ($this->data['projects'] as $key => $project) {
				$this->data['projects'][$key]['approvals'] = $this->get_orig_signers($this->data['projects'][$key]['id'], $this->data['projects'][$key]['hotel_id']);
				$this->data['projects'][$key]['signatures'] = $this->get_signers($this->data['projects'][$key]['id'], $this->data['projects'][$key]['hotel_id']);
			}
			$this->data['hotels'] = $this->hotels_model->getall();

			$user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);

			// $this->data['submenu']['active'] = "owning";

			$this->load->view('madar_owning', $this->data);
		}else{
	      redirect('/unknown');
	    }
	}

/*	private function manipulate_signatures($department_id, $signatures) {
		if ($department_id != 2) {
			foreach ($signatures as $key => $sign) {
				if ($sign['role_id'] == 22) {
					unset($signatures[$key]);
				}
			}
		}
		return $signatures;
	}
*/
	private function get_signers($project_id, $hotel_id) {
		$this->load->model('madar_owning_signatures_model');
		$this->load->model('users_model');

		$signers = array();
		$signatures = $this->madar_owning_signatures_model->getby_owning_verbal($project_id);

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
				if ($signature['role_id'] == 20) {
					$users = $this->users_model->getby_criteria(7, $hotel_id, 4);
				} else {
					$users = $this->users_model->getby_criteria($signature['role_id'], $hotel_id);
				}
				foreach ($users as $use) {
					$signers[$signature['id']]['queue'][$use['id']] = array();
					$signers[$signature['id']]['queue'][$use['id']]['name'] = $use['fullname'];
					$signers[$signature['id']]['queue'][$use['id']]['mail'] = $use['email'];
				}

			}
		}

		return $signers;
	}

	private function get_orig_signers($project_id, $hotel_id) {
		$this->load->model('madar_approvals_model');
		$this->load->model('users_model');

		$signers = array();
		$signatures = $this->madar_approvals_model->getby_project_verbal($project_id);

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
				if ($signature['role_id'] == 20) {
					$users = $this->users_model->getby_criteria(7, $hotel_id, 4);
				} else {
					$users = $this->users_model->getby_criteria($signature['role_id'], $hotel_id);
				}
				foreach ($users as $use) {
					$signers[$signature['id']]['queue'][$use['id']] = array();
					$signers[$signature['id']]['queue'][$use['id']]['name'] = $use['fullname'];
					$signers[$signature['id']]['queue'][$use['id']]['mail'] = $use['email'];
				}

			}
		}

		return $signers;
	}


/*	private function admin_alert($id, $role, $hotel) {
		$this->load->library('email');
		$this->load->helper('url');

		$project_url = base_url().'madar_owning/review/'.$id;
		
		$this->email->from('e-signature@sunrise-resorts.com');
		// $this->email->to('abbas.elshabasy@sunrise-resorts.com');//for now
		// $this->email->cc('marwan.gendy@sunrise-resorts.com');//for now

		$this->email->subject("Project {$id} missing {$role}");
		$this->email->message("Project {$id} for {$hotel} is pending on {$role} signature, no user is currently assigned<br/>
							<a href='{$project_url}' target='_blank'>{$project_url}</a><br/>

							");	

		$mail_result = $this->email->send();
	}*/

	private function signatures_mail($role, $name, $mail, $id) {
		$this->load->library('email');
		$this->load->helper('url');

		$project_url = base_url().'madar_owning/review/'.$id;
		
		$this->email->from('e-signature@sunrise-resorts.com');
		$this->email->to($mail);

		$this->email->subject("Madar Project {$id}");
		$this->email->message("Dear {$name},<br/>
							<br/>
							MADAR Project {$id} requires your signature, Please use the link below:<br/>
							<a href='{$project_url}' target='_blank'>{$project_url}</a><br/>

							");	

		$mail_result = $this->email->send();
	}

	private function notify_signers($project_id) {
		$notified = FALSE;
		$signers = $this->get_signers($project_id, $this->data['project']['hotel_id']);##
		foreach ($signers as $signer) {
			if (isset($signer['queue'])) {
				$notified = TRUE;
				if (count($signer['queue']) == 0) {
					// $this->admin_alert($$project_id, $signer['role'], $this->data['project']['hotel_name']);
				} else {
					foreach ($signer['queue'] as $uid => $user) {
						$this->signatures_mail($signer['role'], $user['name'], $user['mail'], $code);

					}
				}
			}
		}
		return $notified;
	}

/*	public function activate($id) {
		$this->load->model('projects_owning_model');
		$this->data['project'] = $this->projects_owning_model->get_project_hotel($id);
		$this->projects_owning_model->update($id, array('date' => date("Y-m-d H:i:s")));

		$this->notify_signers($id);

		redirect('/madar/project_stage/'.$id);//CALL FUNCTION
	}
*/
	public function create($id) {

		$this->load->model('madar_owning_model');

		$form_data = array(
			'project_id' => $id
			);
		$form_id = $this->madar_owning_model->create($form_data);

		$project = $this->madar_owning_model->get_project_company($id);

		$this->load->model('company_signatures_model');
		$this->load->model('madar_owning_signatures_model');

		$company_signatures = $this->company_signatures_model->getby_company($project['company_id']);
		$do_sign = $this->madar_owning_signatures_model->owning_do_sign($id);
            //die(print_r($do_sign));
            if ($do_sign == 0) {
				foreach ($company_signatures as $company_signature) {
					$this->madar_owning_signatures_model->add_owning_signature($id, $company_signature['role_id'], $company_signature['rank']);
				}
			}
		redirect('/madar/request_stage/'.$id);//CALL FUNCTION
	}
	
	public function review($id) {
		if ((isset($this->data['is_admin']) && $this->data['is_admin'])) {
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
					$this->load->model('madar_owning_model');

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

		    		$project_id = $this->madar_owning_model->update($id, $project_data);

		    		if (!isset($project_id)) {
		    			die("ERROR");//@TODO failure view
		    		}

		    		redirect('/madar_owning/review/'.$id);
		    	}
			}

			$this->load->model('madar_owning_model');
			$this->load->model('madar_comments_model');


			$this->data['project'] = $this->madar_owning_model->get_project($id);
			$this->data['project_id'] = $id;


			$this->data['signature_path'] = '/assets/uploads/signatures/';

			$this->data['signers'] = $this->get_signers($id, $this->data['project']['hotel_id']);

			$this->data['comments'] = $this->madar_comments_model->getby_project($id, 1);

		
				$this->load->view('madar_owning_form', $this->data);
			}else{
	      redirect('/unknown');
	    }
	}

	public function sign($signature_id) {
		$this->load->model('madar_owning_signatures_model');
		$signature_identity = $this->madar_owning_signatures_model->get_signature_identity($signature_id);

		$signrs = $this->get_signers($signature_identity['project_id'], $signature_identity['hotel_id']);

		if (array_key_exists($this->data['user_id'], $signrs[$signature_id]['queue'])) {
			$this->madar_owning_signatures_model->sign($signature_id, $this->data['user_id']);
		}
		redirect('/madar_owning/review/'.$signature_identity['project_id']);
	}

	public function reject($signature_id) {
		$this->load->model('madar_owning_signatures_model');
		$signature_identity = $this->madar_owning_signatures_model->get_signature_identity($signature_id);

		$signrs = $this->get_signers($signature_identity['project_id'], $signature_identity['hotel_id']);

		if (array_key_exists($this->data['user_id'], $signrs[$signature_id]['queue'])) {
			$this->madar_owning_signatures_model->reject($signature_id, $this->data['user_id']);

		}
		redirect('/madar_owning/review/'.$signature_identity['project_id']);
	}

	public function unsign($signature_id) {
		$this->load->model('madar_owning_signatures_model');

		$signature_identity = $this->madar_owning_signatures_model->get_signature_identity($signature_id);

		$this->madar_owning_signatures_model->unsign($signature_id, $this->data['user_id']);

		redirect('/madar_owning/review/'.$signature_identity['project_id']);
	}

	private function comment_alert($user_name, $comment, $project_id, $mails) {
		$this->load->library('email');
		$this->load->helper('url');

		$project_url = base_url().'madar/view/'.$project_id;
		
		$this->email->from('e-signature@sunrise-resorts.com');
		$this->email->to($mails);

		$this->email->subject("MADAR Project {$project_id}");
		$this->email->message("{$user_name} added a comment for mMadar project {$project_id}:<br/>
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

				$project_url = base_url().'madar_owning/review/'.$id;
				
				$this->email->from('e-signature@sunrise-resorts.com');
				$this->email->to($mail);

				$this->email->subject("A message from {$user->fullname}, Madar Project #{$id}");
				$this->email->message("{$user->fullname} sent you a private message regarding Project #{$id}:<br/>
									{$message}<br />
									<br />

									Please use the link below to view the project:
									<a href='{$project_url}' target='_blank'>{$project_url}</a><br/>

									");	

				$mail_result = $this->email->send();
			}
		}
		redirect('/madar_owning/review/'.$id);
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
	    								'comment' => $comment,
	    								'privilege' => 1
	    							);
				$this->madar_comments_model->add($comment_data);
			
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
	    redirect('/madar_owning/review/'.$project_id);
	}

}