<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Requests extends CI_Controller {

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

		$this->data['menu']['active'] = "projects";

		$this->load->library('logger');

		$this->data['module_forms'] = array('0' => 25, '1' => 27);;

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



	private function manipulate_approvals($department_id, $approvals, $budget, $new) {

		if ($department_id != 2) {

			foreach ($approvals as $key => $sign) {

				if ($sign['role_id'] == 18) {

					unset($approvals[$key]);

				}

			}

		}

		if ($new != 1 && $department_id != 6) {

			foreach ($approvals as $key => $sign) {

				if ($sign['role_id'] == 140) {

					unset($approvals[$key]);

				}

			}

		}

		$this->load->model('unplanned_limitations_model');

		$limitations = $this->unplanned_limitations_model->getall();

		if ($department_id != 6) {

			foreach ($limitations as $limit) {

				if ($budget <= $limit['limit']) {

					foreach ($approvals as $key => $sign) {

						if ($sign['role_id'] == $limit['role_id']) {

							unset($approvals[$key]);

						}

					}

				}

			}

		}

		return $approvals;

	}

	public function _remap($method, $params = array())

	{

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

	

	public function index($state = FALSE) {

		if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {

	      redirect('/unknown');

	    }else{



			if ($state == 1 || $state == 11) {

				$states = array($state);

			} else if ($state == 2) {

				$states = array(2,3,4,5,6,7,8,9,33);

			} else {

				$states = array(1,2,3,4,5,6,7,8,9,10,11,12,33);

			}



			$this->load->model('hotels_model');



			$user_hotels = $this->hotels_model->getby_user($this->data['user_id']);

			$hotels = array();

			$this->data['special_owning'] = FALSE;

			foreach ($user_hotels as $hotel) {

				$hotels[] = $hotel['id'];

				if ($hotel['id'] == 5) {

					$this->data['special_owning'] = TRUE;

				}

			}



			$this->load->model('projects_model');

			$this->data['projects'] = $this->projects_model->get_requests($states, $hotels);

			foreach ($this->data['projects'] as $key => $project) {
				if($project['change_unplanned'] !=1){

				$this->data['projects'][$key]['approvals'] = $this->get_approvers($this->data['projects'][$key]['id'], $this->data['projects'][$key]['hotel_id'],0);
			}else{
				$this->data['projects'][$key]['approvals'] = $this->get_approvers($this->data['projects'][$key]['id'], $this->data['projects'][$key]['hotel_id'],1);
			}

			}

			$this->data['hotels'] = $this->hotels_model->getall();



			$user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);

			$this->data['isGM'] = ($user->role_id == 6)? TRUE : FALSE;

			$this->data['isDptHead'] = ($user->role_id == 7)? TRUE : FALSE;



			$this->data['submenu']['active'] = "requests";



			$this->load->view('requests', $this->data);

		}

	}



	private function approvals_mail($role, $name, $mail, $project_id) {

		$this->load->library('email');

		$this->load->helper('url');



		$project_url = base_url().'requests/view/'.$project_id;

		

		$this->email->from('e-signature@sunrise-resorts.com');

		$this->email->to($mail);



		$this->email->subject("Unplanned Project Approval{$project_id}");

		$this->email->message("Dear {$name},<br/>

							<br/>

							Unplanned Project Approval #{$project_id} requires your approval, Please use the link below:<br/>

							<a href='{$project_url}' target='_blank'>{$project_url}</a><br/>



							");	



		$mail_result = $this->email->send();

		$this->logger->log_event($this->data['user_id'], "Notify", "projects", $project_id, json_encode(array("to"=>$mail)), "user requested approval");//log



	}



	private function owner_mail($name, $mail, $project_code, $project_id) {

		$this->load->library('email');

		$this->load->helper('url');

		

		$this->email->from('e-signature@sunrise-resorts.com');

		$this->email->to($mail);



		$this->email->subject("Unplanned Project Approval #{$project_id}");



		if (is_null($project_code)) {

			$project_url = base_url().'requests/view/'.$project_id;

			$this->email->message("Dear {$name},<br/>

								<br/>

								Your Unplanned Project Approval #{$project_id} has been Rejected.<br />You cannot create this project./>

								<a href='{$project_url}' target='_blank'>{$project_url}</a><br/>



								");	

		} else {

			$project_url = base_url().'projects/submit/'.$project_code;

			$this->email->message("Dear {$name},<br/>

								<br/>

								Your Unplanned Project Approval #{$project_id} has been approved.<br />Project code {$project_code}, Please use the link below to create the project:<br/>

								<a href='{$project_url}' target='_blank'>{$project_url}</a><br/>



								");	

		}



		$mail_result = $this->email->send();

		$this->logger->log_event($this->data['user_id'], "Notify", "projects", $project_id, json_encode(array("to" => $mail, "code" => $project_code)), "code exists => approved. else disapproved");//log



	}





	private function self_approve($project_id) {

		$this->load->model('project_approvals_model');

		$this->project_approvals_model->self_approve($project_id, $this->data['user_id']);

		$this->logger->log_event($this->data['user_id'], "Approve", "projects", $project_id, NULL, "user self approved");//log



	}



	private function get_approvers($project_id, $hotel_id,$change_unplanned) {

		$this->load->model('project_approvals_model');

		$this->load->model('users_model');



		$approvers = array();

		$approvals = $this->project_approvals_model->getby_project_verbal($project_id,$change_unplanned);

		foreach ($approvals as $approval) {

			$approvers[$approval['id']] = array();

			$approvers[$approval['id']]['role'] = $approval['role'];

			$approvers[$approval['id']]['role_id'] = $approval['role_id'];



			if ($approval['user_id']) {

				$approvers[$approval['id']]['sign'] = array();

				$approvers[$approval['id']]['sign']['id'] = $approval['user_id'];

				if ($approval['reject'] == 1) {

					$approvers[$approval['id']]['sign']['reject'] = "reject";

				} 

				$user = $this->users_model->get_user_by_id($approval['user_id'], TRUE);



				$approvers[$approval['id']]['sign']['name'] = $user->fullname;

				$approvers[$approval['id']]['sign']['mail'] = $user->email;

				$approvers[$approval['id']]['sign']['channel'] = $user->channel;

				$approvers[$approval['id']]['sign']['sign'] = $user->signature;

				$approvers[$approval['id']]['sign']['timestamp'] = $approval['timestamp'];

			} else {

				$approvers[$approval['id']]['queue'] = array();
				 if ($approval['role_id'] == 6 && $hotel_id==5) {
	            $users[0] = $this->users_model->getby_criteria(142, $hotel_id);
	            $users[1] = $this->users_model->getby_criteria(6, $hotel_id);
	            foreach ($users as $user) {
	              foreach ($user as $use) {
	               $approvers[$approval['id']]['queue'][$use['id']] = array();
	               $approvers[$approval['id']]['queue'][$use['id']]['name'] = $use['fullname'];
	               $approvers[$approval['id']]['queue'][$use['id']]['mail'] = $use['email'];
	               $approvers[$approval['id']]['queue'][$use['id']]['channel'] = $use['channel'];
	              }
	            }
	          }
	           else {

				$users = $this->users_model->getby_criteria($approval['role_id'], $hotel_id);

				foreach ($users as $use) {

					$approvers[$approval['id']]['queue'][$use['id']] = array();

					$approvers[$approval['id']]['queue'][$use['id']]['name'] = $use['fullname'];

					$approvers[$approval['id']]['queue'][$use['id']]['mail'] = $use['email'];

					$approvers[$approval['id']]['queue'][$use['id']]['channel'] = $use['channel'];

				}



			}

		}

      }

		return $approvers;

	}



	private function notify_approvers($project_id) {

		$notified = FALSE;
        $this->data['project'] = $this->projects_model->get_request($project_id, FALSE);
		$approvers = $this->get_approvers($project_id, $this->data['project']['hotel_id'],$this->data['project']['change_unplanned']);

		$this->load->model('projects_model');

		$project_url = base_url().'requests/view/'.$project_id;


		$name = $this->data['project']['project_name'];

		$project_id = $project_id;

		$message = "project request {$project_id} ({$name})

				{$project_url}";	

		foreach ($approvers as $approver) {

			if (isset($approver['queue'])) {

				$notified = TRUE;

				$this->projects_model->update_final($project_id, $approver['role_id']);

				foreach ($approver['queue'] as $uid => $user) {

                 if ($approver['role_id']!=1) {

					$this->onclick($message, $project_id, $user['channel']);

					$this->approvals_mail($approver['role'], $user['name'], $user['mail'], $project_id

			     	);

                  }

				}

				break;

			}

		}

		return $notified;

	}



	private function notify_owner($id, $code = NULL) {

		$user = $this->users_model->get_user_by_id($this->data['project']['user_id'], TRUE);

		$this->owner_mail($user->fullname, $user->email, $code, $id);

		return TRUE;

	}



	private function get_code($project_id) {

		$code = FALSE;

		while (!$this->projects_model->set_code($project_id, $code)) {

			$code = "UN".strtoupper(str_pad(dechex( mt_rand( 50, 1048579999 ) ), 6, '0', STR_PAD_LEFT));

		}

		return $code;

	}



	public function request_stage($id) {



		$this->load->model('projects_model');

		$this->load->model('projects_owning_model');

		$this->data['project'] = $this->projects_model->get_request($id);



		if ($this->data['project']['state_id'] == 11) {

			$this->notify_owner($id);



		} elseif ($this->data['project']['state_id'] == 1) {

			$queue = $this->notify_approvers($id);

			if (!$queue) {

				$this->projects_model->update_final($id, 0);

				$this->projects_owning_model->update_final($id, 0);

				$code = $this->get_code($id);

				$this->notify_owner($id, $code);

				$this->projects_model->update_state($id, 2);

				

				$this->logger->log_event($this->data['user_id'], "Stage", "projects", $id, json_encode(array("state" => 2)), "project state updated");//log



				redirect('/requests/request_stage/'.$id);

			}



		} elseif ($this->data['project']['state_id'] == 0) {

			//$this->self_approve($id);

			$this->projects_model->update_state($id, 1);

			$this->logger->log_event($this->data['user_id'], "Stage", "projects", $id, json_encode(array("state" => 1)), "project state updated");//log



			redirect('/requests/request_stage/'.$id);

		} 



		redirect('/requests/view/'.$id);

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

			$this->load->model("files_model");

			$this->files_model->add($project_id, $file_name);

			$this->logger->log_event($this->data['user_id'], "Upload", "projects", $project_id, json_encode(array("file_name" => $file_name)), "user uploaded a file");//log

			die("{}");

		}

	}



	public function remove_files($project_id, $id) {

		$file_name = $_POST['key'];



		if (!$id) {

			die(json_encode($this->data['error']));

		} else {

			$this->load->model("files_model");

			$this->files_model->remove($id);

			$this->logger->log_event($this->data['user_id'], "Upload-Remove", "projects", $project_id, json_encode(array("file_id" => $id, "file_name" => $file_name)), "user removed a file");//log



			die("{}");

		}

	}

	

	public function view($id) {

		if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {

	      redirect('/unknown');

	    }else{

			$this->load->model('projects_model');

			$this->load->model("project_comments_model");

			$this->load->model("files_model");



			$this->data['project'] = $this->projects_model->get_request($id);

            $this->data['chairman_after']=$this->projects_model->chairman_after_kfahmy($this->data['project']['id']);

			$this->data['signature_path'] = '/assets/uploads/signatures/';

			if ($this->data['project']['change_unplanned'] == 1) {
				$this->load->model('requests_change_model');
					$this->data['project_change'] = $this->requests_change_model->get_request($this->data['project']['id']);
					$this->data['signers_change'] = $this->get_approvers($this->data['project']['id'], $this->data['project']['hotel_id'], 1);
                   }


			$this->data['approvers'] = $this->get_approvers($id, $this->data['project']['hotel_id'], 0);





			$editor = FALSE;

			$unsign_enable = FALSE;



			$project_staged = $this->data['project']['state_id'] >= 2;

			$project_rejected = in_array($this->data['project']['state_id'], array(11));



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



		

			$this->data['comments'] = $this->project_comments_model->getby_project($this->data['project']['id']);



			$this->data['files'] = $this->files_model->getby_project($this->data['project']['id']);



			$this->data['project_id'] = $id;



			$this->data['unsign_enable'] = (($unsign_enable) || $this->data['is_admin'])? TRUE : FALSE;



			$this->data['is_editor'] = ( (($this->data['unsign_enable'] || $editor) && !$project_staged) || ($force_edit && !$project_staged) )? TRUE : FALSE;



			$this->data['isGM'] = ($this->data['role_id'] == 6)? TRUE : FALSE;

			$this->data['isDptHead'] = ($this->data['role_id'] == 7)? TRUE : FALSE;

			

			$this->load->view('request_view', $this->data);

		}

	}



	public function reject($signature_id) {

		$this->load->model('owning_signatures_model');

		$this->load->model('projects_model');

		$signature_identity = $this->owning_signatures_model->get_signature_identity($signature_id);



		$signrs = $this->get_signers($signature_identity['project_id'], $signature_identity['hotel_id']);

		$this->projects_model->update_final($signature_identity['project_id'], 0);

		// $this->load->model('projects_model');

		// $this->data['project'] = $this->projects_model->get_owning_code($signature_identity['project_id']);



		if (array_key_exists($this->data['user_id'], $signrs[$signature_id]['queue'])) {

			$this->owning_signatures_model->reject($signature_id, $this->data['user_id']);

			$this->logger->log_event($this->data['user_id'], "Reject", "owning_project", $signature_identity['project_id'], json_encode(array("signature_id" => $signature_id)), "user rejected project");//log



		}

		redirect('/requests/review/'.$signature_identity['project_id']);

	}



	public function sign($signature_id) {

		$this->load->model('owning_signatures_model');

		$signature_identity = $this->owning_signatures_model->get_signature_identity($signature_id);



		$signrs = $this->get_signers($signature_identity['project_id'], $signature_identity['hotel_id']);

		// $this->load->model('projects_model');

		// $this->data['project'] = $this->projects_model->get_owning_code($signature_identity['project_id']);
               
		if (array_key_exists($this->data['user_id'], $signrs[$signature_id]['queue'])) {

			$this->owning_signatures_model->sign($signature_id, $this->data['user_id']);

			$this->logger->log_event($this->data['user_id'], "Sign", "owning_project", $signature_identity['project_id'], json_encode(array("signature_id" => $signature_id)), "user signed project");//log

		}

		redirect('/requests/review/'.$signature_identity['project_id']);

	}



	public function unsign_owning($signature_id) {

		$this->load->model('owning_signatures_model');



		$signature_identity = $this->owning_signatures_model->get_signature_identity($signature_id);



		$this->owning_signatures_model->unsign($signature_id, $this->data['user_id']);



		$this->logger->log_event($this->data['user_id'], "Undo", "owning_project", $signature_identity['project_id'], json_encode(array("signature_id" => $signature_id)), "user unsigned project");//log



		redirect('/requests/review/'.$signature_identity['project_id']);

	}



	public function unsign($approval_id) {

		$this->load->model('project_approvals_model');



		$approval_identity = $this->project_approvals_model->get_approval_identity($approval_id);



		$this->load->model('projects_model');

		$this->projects_model->update_final($approval_identity['project_id'], $this->data['role_id']);

		$this->project_approvals_model->unsign($approval_id);

		$this->projects_model->update_state($approval_identity['project_id'], 1);



		$this->logger->log_event($this->data['user_id'], "Undo", "projects", $approval_identity['project_id'], json_encode(array("approval_id" => $approval_id)), "user unsigned project");//log

		$this->logger->log_event($this->data['user_id'], "Stage", "projects", $approval_identity['project_id'], json_encode(array("state_id" => 1)), "project state forced");//log



		redirect('/requests/view/'.$approval_identity['project_id']);

	}



	public function approve($approval_id, $reject = FALSE) {

		$this->load->model('project_approvals_model');

		$this->load->model('projects_model');

		$approval_identity = $this->project_approvals_model->get_approval_identity($approval_id);

        $project  = $this->projects_model->get_request($approval_identity['project_id']);

		$approvers = $this->get_approvers($approval_identity['project_id'], $approval_identity['hotel_id'],$project['change_unplanned']);
		$project_url = base_url().'requests/view/'.$approval_identity['project_id'];

		$this->data['project'] = $this->projects_model->get_request($approval_identity['project_id'], FALSE);

		$message_id = $this->data['project']['message_id'];

		$name = $this->data['project']['project_name'];

		$project_id = $approval_identity['project_id'];

		$messages = "project request {$project_id} ({$name})

				{$project_url}";	

		if (array_key_exists($this->data['user_id'], $approvers[$approval_id]['queue'])) {

			if ($reject) {

				$this->project_approvals_model->disapprove($approval_id, $this->data['user_id']);

				$this->projects_model->update_state($approval_identity['project_id'], 11);

				

				$this->logger->log_event($this->data['user_id'], "Disapprove", "projects", $approval_identity['project_id'], json_encode(array("approval_id" => $approval_id)), "user rejected approval");//log

				$this->logger->log_event($this->data['user_id'], "Stage", "projects", $approval_identity['project_id'], json_encode(array("state" => 11)), "project state updated");//log

				if ($approval_identity['role_id'] == 1) {

					$this->onclick1($messages);

					$this->deletonclick($message_id);

					redirect('/requests/request_stage/'.$approval_identity['project_id']);

				}

			} else {

				 $brfore_chairman = $this->projects_model->chairman_exception_request($approval_identity['project_id']);

				$this->project_approvals_model->approve($approval_id, $this->data['user_id']);

				$this->logger->log_event($this->data['user_id'], "Approve", "projects", $approval_identity['project_id'], json_encode(array("approval_id" => $approval_id)), "user signed approval");//log

				if ($approval_identity['role_id'] == 1) {

					$this->onclick1($messages);

					$this->deletonclick($message_id);

					redirect('/requests/request_stage/'.$approval_identity['project_id']);

				}elseif ($brfore_chairman == 1) {

					//$this->onclick($messages, $project_id);

					redirect('/project_owning/create_request/'.$approval_identity['project_id']);

				} else {

					redirect('/requests/request_stage/'.$approval_identity['project_id']);

				}



			}

			redirect('/requests/request_stage/'.$approval_identity['project_id']);

		}

		redirect('/requests/view/'.$approval_identity['project_id']);

	}



	public function edit($id) {

		if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {

	      redirect('/unknown');

	    }else{

			if ($this->input->post('submit')) {



				$this->load->library('form_validation');



				$this->form_validation->set_rules('type','Project Type','trim|required');

				$this->form_validation->set_rules('new','New Equipment','trim|required');

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

		    		$this->load->model('projects_model');



		    		$project_data = array(

		    							'type_id' => $this->input->post('type'),

		    							'new' => $this->input->post('new'),

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



		    		$updated = $this->projects_model->update($id, $project_data);



					$this->logger->log_event($this->data['user_id'], "Request_Edit", "projects", $id, json_encode($project_data), "user edited project approval request");//log



		    		redirect('/requests/view/'.$id);//CALL FUNCTION

		    	}

			}



			try {



				$this->load->model('projects_model');

				$this->data['project'] = $this->projects_model->get_request($id);

				$this->data['project_id'] = $id;



				$this->load->helper('form');

				$this->load->model('hotels_model');

				$this->load->model('departments_model');

				$this->load->model('types_model');

				$this->load->model('origins_model');

				

				$this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());

				$this->data['departments'] = $this->departments_model->getall();

				$this->data['types'] = $this->types_model->getall();

				$this->data['origins'] = $this->origins_model->getall();



				$this->load->model('files_model');

				$this->data['assumed_id'] = $id;

				$this->data['files'] = $this->files_model->getby_project($this->data['assumed_id']);



				$this->load->view('request_edit',$this->data);

			}



			catch( Exception $e) {

				show_error($e->getMessage()." _ ". $e->getTraceAsString());

			}

		}

	}

	public function change($id) {
				if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {

	      redirect('/unknown');

	    }else{
	    	    $this->load->model('projects_model');
	    		$this->load->model('requests_change_model');
				
                if ($this->input->post('submit')) {
					$requset = $this->projects_model->get_project($id);
									if ($requset['change_unplanned'] == 1) {
										$requset_change = $this->requests_change_model->get_request($requset['id']);
										$this->requests_change_model->delete_request($requset_change['id']);
									}

				$this->load->library('form_validation');



				$this->form_validation->set_rules('type','Project Type','trim|required');

				$this->form_validation->set_rules('new','New Equipment','trim|required');

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

		    		$this->load->model('projects_model');



		    		$project_data = array(

					    			    'project_id' => $requset['id'],
						    			'code' => '',
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



		    		$this->load->model('requests_change_model');
		    		$this->load->model('project_approvals_model');
		    		$this->load->model('hotel_planned_signatures_model');
			    		$requset_id = $this->requests_change_model->create($project_data);
			    		if (!isset($requset_id)) {
			    			die("ERROR");
			    		}
			    	$this->projects_model->update_change_unplanned($requset['id'], 1);	
                    $this->projects_model->update_state($id, 1);
	                $hotel_signatures = $this->hotel_planned_signatures_model->getby_hotel($requset['hotel_id']);
		    		$final_signatures = $this->manipulate_signatures(FALSE, $requset['department_id'], $hotel_signatures, $project_data['budget_EGP'], FALSE, TRUE);
		    			$do_sign = $this->project_approvals_model->project_do_sign($requset['id'], 1);
            			if ($do_sign != 0) {
            				$this->project_approvals_model->clear_request_change_signature($requset['id'], 1);
            			}
			    		foreach ($final_signatures as $hotel_signature) {
			    			$this->project_approvals_model->add_project_approval_change($requset['id'], $hotel_signature['role_id'], $hotel_signature['rank'], 1);
			    		}

					$this->logger->log_event($this->data['user_id'], "Request_change", "projects", $id, json_encode($project_data), "user changed project approval request");//log

                    $this->notify_approvers($requset['id']);
		    		redirect('/requests/view/'.$id);//CALL FUNCTION

		    	}

			}



			try {



				$this->load->model('projects_model');

				$this->data['project_origin'] = $this->projects_model->get_request($id);
				if ($this->data['project_origin']['change_unplanned'] != 1) {
					$this->data['project'] = $this->projects_model->get_request($id);
				}else{

	                $this->data['project'] = $this->requests_change_model->get_request($this->data['project_origin']['id']);
				}

				$this->data['project_id'] = $id;



				$this->load->helper('form');

				$this->load->model('hotels_model');

				$this->load->model('departments_model');

				$this->load->model('types_model');

				$this->load->model('origins_model');

				

				$this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());

				$this->data['departments'] = $this->departments_model->getall();

				$this->data['types'] = $this->types_model->getall();

				$this->data['origins'] = $this->origins_model->getall();



				$this->load->model('files_model');

				$this->data['assumed_id'] = $id;

				$this->data['files'] = $this->files_model->getby_project($this->data['assumed_id']);



				$this->load->view('request_change',$this->data);

			}



			catch( Exception $e) {

				show_error($e->getMessage()." _ ". $e->getTraceAsString());

			}

		}

	}
//$this->manipulate_signatures(FALSE, $requset['department_id'], $hotel_signatures, $project_data['cost'], FALSE, TRUE);
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


	public function request() {

		if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {

	      redirect('/unknown');

	    }else{

			if ($this->input->post('submit')) {



				$this->load->library('form_validation');



				$this->form_validation->set_rules('hotel','Hotel','trim|required');

				$this->form_validation->set_rules('type','Project Type','trim|required');

				$this->form_validation->set_rules('new','New Equipment','trim|required');

		    	$this->form_validation->set_rules('name','Project Name','trim|required');

		    	$this->form_validation->set_rules('reason','Reason','trim|required');

		    	$this->form_validation->set_rules('department','Department','trim|required');

				$this->form_validation->set_rules('eur_ex','EUR exchange rate','trim|number');

				$this->form_validation->set_rules('usd_ex','USD exchange rate','trim|number');

				$this->form_validation->set_rules('budget_egp','Final cost in EGP','trim|number');

				$this->form_validation->set_rules('budget_usd','Final cost in USD','trim|number');

				$this->form_validation->set_rules('budget_eur','Final cost in EUR','trim|number');

				$this->form_validation->set_rules('budget','Final cost','trim|number|required');

		    	$this->form_validation->set_rules('remarks','Remarks','trim');



		    	$assumed_id = $this->input->post('assumed_id');



		    	if ($this->form_validation->run() == TRUE) {

		    		$this->load->model('projects_model');



		    		$project_data = array(

		    							'user_id' => $this->data['user_id'],

		    							'department_id' => $this->input->post('department'),

		    							'hotel_id' => $this->input->post('hotel'),

		    							'type_id' => $this->input->post('type'),

		    							'origin_id' => 3,

		    							'new' => $this->input->post('new'),

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

		    		$project_id = $this->projects_model->create($project_data);



		    		

		    		if ($project_id) {

		   //  		if ($project_data['hotel_id'] == 5) {
					// 	$secretary_ho = $this->users_model->get_user_by_id(447,1);
					// 	// die(print_r($secretary_ho->email));
					// 	$this->approvals_mail($secretary_ho->role, "sir",$secretary_ho->email,$project['code']);
					// }



		    			$this->load->model('hotel_signatures_model');

		    			$this->load->model('project_approvals_model');

		    			$hotel_approvals = $this->hotel_signatures_model->getby_hotel($project_data['hotel_id']);

		    			//die(print_r($hotel_approvals));

		    			$final_approvals = $this->manipulate_approvals($project_data['department_id'], $hotel_approvals, $project_data['budget_EGP'], $project_data['new']);

		    			

		    			//$this->project_approvals_model->add_project_approval($project_id, 0, 0);

		    			foreach ($final_approvals as $hotel_approval) {

		    				$this->project_approvals_model->add_project_approval($project_id, $hotel_approval['role_id'], $hotel_approval['rank']);

		    			}





					$this->load->model('projects_owning_model');

					$this->load->model('company_signatures_model');

					$this->load->model('owning_signatures_model');

					if ($project_data['hotel_id']==42) {

						$project = $this->projects_owning_model->get_company($project_data['hotel_id']);

						$company_signatures = $this->company_signatures_model->getby_company($project['company_id']);

						//die(print_r($company_signatures));

						foreach ($company_signatures as $company_signature) {

							$this->owning_signatures_model->add_owning_signature($project_id, $company_signature['role_id'], $company_signature['rank']);

						}

					}



		    			$this->load->model('files_model');

		    			$this->files_model->update_files($assumed_id, $project_id);

						$this->logger->log_event($this->data['user_id'], "Request", "projects", $project_id, json_encode($project_data), "user created project approval request");//log



		    		} else {

		    			die("ERROR");//@TODO failure view

		    		}





		    		redirect('/requests/request_stage/'.$project_id);//CALL FUNCTION

		    	}

			}



			try {



				$this->load->helper('form');

				$this->load->model('hotels_model');

				$this->load->model('departments_model');

				$this->load->model('types_model');

				$this->load->model('origins_model');

				

				$this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());

				$this->data['departments'] = $this->departments_model->getall();

				$this->data['types'] = $this->types_model->getall();

				$this->data['origins'] = $this->origins_model->getall();



				if ($this->input->post('submit')) {



					$this->load->model('files_model');

					$this->data['assumed_id'] = $this->input->post('assumed_id');

					$this->data['files'] = $this->files_model->getby_project($this->data['assumed_id']);

				} else {



					$this->data['assumed_id'] = "UN".strtoupper(str_pad(dechex( mt_rand( 50, 1048579999 ) ), 6, '0', STR_PAD_LEFT));

					$this->data['files'] = array();

				}



				$this->load->view('project_request',$this->data);

			}

			catch( Exception $e) {

				show_error($e->getMessage()." _ ". $e->getTraceAsString());

			}

		}

	}



	public function review($id) {

		if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {

	      redirect('/unknown');

	    }else{



			$this->load->model('projects_owning_model');

			$this->load->model('project_comments_model');

			$this->load->model('projects_model');

			$this->data['project'] = $this->projects_model->get_request($id);

			$this->data['project_company'] = $this->projects_owning_model->get_company($this->data['project']['hotel_id']);

			$this->data['project_id'] = $id;



			$this->data['signature_path'] = '/assets/uploads/signatures/';



			$this->data['signers'] = $this->get_signers($id, $this->data['project']['hotel_id']);



			$this->data['comments'] = $this->project_comments_model->getby_project($id, 1);



			$this->load->view('project_owning_form_3', $this->data);

		}

	}



	private function get_signers($project_id, $hotel_id) {

		$this->load->model('owning_signatures_model');

		$this->load->model('users_model');



		$signers = array();

		$signatures = $this->owning_signatures_model->getby_own_marina_verbal($project_id);



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



				$project_url = base_url().'requests/view/'.$id;

				

				$this->email->from('e-signature@sunrise-resorts.com');

				$this->email->to($mail);



				$this->email->subject("A message from {$user->fullname}, Unplanned Project Approval #{$id}");

				$this->email->message("{$user->fullname} sent you a private message regarding Unplanned Project Approval #{$id}:<br/>

									{$message}<br />

									<br />



									Please use the link below to view the request:

									<a href='{$project_url}' target='_blank'>{$project_url}</a><br/>



									");	



				$mail_result = $this->email->send();

			}

		}

		redirect('/requests/view/'.$id);

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



	    		$this->load->model("project_comments_model");

	    		$comment_data = array(

	    								'user_id' => $this->data['user_id'],

	    								'project_id' => $project_id,

	    								'comment' => $comment

	    							);

				$this->project_comments_model->add($comment_data);



				$user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);



				$this->load->model("project_approvals_model");

				$approvers = $this->project_approvals_model->getby_project_approved($project_id);



				$mails = array();



				foreach ($approvers as $approver) {

					$mails[] = $approver['email'];

				}



				$this->comment_alert($user->fullname, $comment, $project_id, $mails);

				if ($this->data['role_id'] == 217) {

		    		$this->chairman_mail($project_id);

		    	}

			}

	    }

	    redirect('/requests/view/'.$project_id);

	}



		private function chairman_mail($project_id) {

	      	$this->load->library('email');

	      	$this->load->helper('url');

	      	$project_url = base_url().'/requests/view/'.$project_id;

	      	$this->email->from('e-signature@sunrise-resorts.com');

	      	$this->email->to('abeer@sunrise.eg');

	      	$this->email->subject("Project Requese No. #{$project_id}");

	      	$this->email->message("Dear Madam Abber,

		        <br/>

		        <br/>

		        Mr Hossam Commented on Project Requese No. #{$project_id}, Please use the link below:

		        <br/>

		        <a href='{$project_url}' target='_blank'>{$project_url}</a>

		        <br/>

      		"); 

      		$mail_result = $this->email->send();

    	}



	public function share_url($project_id) {

		if ($this->input->post('submit')) {

	    	$message = $this->input->post('message');

			$user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);

			$project_url = base_url().'requests/view/'.$project_id;

			$this->load->model('projects_model');

			$this->data['project'] = $this->projects_model->get_request($project_id, FALSE);

			$name = $this->data['project']['project_name'];

			$messages = "{$user->fullname}  project request {$project_id} ({$name})

				{$project_url}";	

			$this->onclick($messages, $project_id, $this->config->item('page_to_send'));

		}

		redirect('/requests/view/'.$project_id);

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


}