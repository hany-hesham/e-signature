<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Workshop extends CI_Controller {

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
 
           $this->data['role_id'] = $this->tank_auth->get_role();
      	}

		$this->data['menu']['active'] = "workshop";

	}

	



	public function index() {

		if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {

	      redirect('/unknown');

	    }else{

			$this->load->model('hotels_model');

			$this->load->model("workshop_request_reciver_model");

			$user_hotels = $this->hotels_model->getby_user($this->data['user_id']);

			$hotels = array();

			foreach ($user_hotels as $hotel) {

				$hotels[] = $hotel['id'];

			}

			$this->load->model('workshop_requests_model');

			$this->load->model('workshop_request_items_model');



			$this->data['workshop_requests'] = $this->workshop_requests_model->view_requests($hotels);

			// $this->data['items'] = $this->workshop_request_items_model->get_request_items($request_id);



			foreach ($this->data['workshop_requests'] as $key => $requests) {

				$this->data['workshop_requests'][$key]['approvals'] = $this->get_request_signers($this->data['workshop_requests'][$key]['id'], $this->data['workshop_requests'][$key]['hotel_id']);

				$this->data['workshop_requests'][$key]['reciver'] = $this->workshop_request_reciver_model->getby_workshop_request($this->data['workshop_requests'][$key]['id']);

				$this->data['workshop_requests'][$key]['items'] = $this->workshop_request_items_model->get_request_items($this->data['workshop_requests'][$key]['id']);



			}

			$this->data['hotels'] = $this->hotels_model->getall();

			$user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);

			$this->data['isWS'] = ($user->role_id == 35)? TRUE : FALSE;

			$this->load->view('workshop', $this->data);

		}

	}





	public function mailto($request_id) {

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



				$request_url = base_url().'workshop/request_view/'.$request_id;

				

				$this->email->from('e-signature@sunrise-resorts.com');

				$this->email->to($mail);



				$this->email->subject("A message from {$user->fullname}, Request No.{$request_id}");

				$this->email->message("{$user->fullname} sent you a private message regarding workshop request {$request_id}:<br/>

									{$message}<br />

									<br />



									Please use the link below to view the workshop request:

									<a href='{$request_url}' target='_blank'>{$request_url}</a><br/>



									");	



				$mail_result = $this->email->send();



			}

		}

		redirect('workshop/request_view/'.$request_id);

	}





	public function order_mailto($order_id) {

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



				$order_url = base_url().'workshop/order_view/'.$order_id;

				

				$this->email->from('e-signature@sunrise-resorts.com');

				$this->email->to($mail);



				$this->email->subject("A message from {$user->fullname}, Order No.{$order_id}");

				$this->email->message("{$user->fullname} sent you a private message regarding workshop order {$order_id}:<br/>

									{$message}<br />

									<br />



									Please use the link below to view the workshop order:

									<a href='{$order_url}' target='_blank'>{$order_url}</a><br/>



									");	



				$mail_result = $this->email->send();



			}

		}

		redirect('workshop/order_view/'.$order_id);

	}





	private function request_signatures_mail($role, $name, $mail, $request_id) {

		$this->load->library('email');

		$this->load->helper('url');



		$request_url = base_url().'workshop/request_view/'.$request_id;

		

		$this->email->from('e-signature@sunrise-resorts.com');

		$this->email->to($mail);



		$this->email->subject("WorkShop Request {$request_id}");

		$this->email->message("Dear {$name},<br/>

							<br/>

							Request {$request_id} requires your signature, Please use the link below:<br/>

							<a href='{$request_url}' target='_blank'>{$request_url}</a><br/>



							");	



		$mail_result = $this->email->send();

	}



	private function approval_signatures_mail($role, $name, $mail, $request_id) {

		$this->load->library('email');

		$this->load->helper('url');



		$request_url = base_url().'workshop/request_view/'.$request_id;

		

		$this->email->from('e-signature@sunrise-resorts.com');

		$this->email->to($mail);



		$this->email->subject("WorkShop Request Approval {$request_id}");

		$this->email->message("Dear {$name},<br/>

							<br/>

							Request {$request_id} requires your signature, Please use the link below:<br/>

							<a href='{$request_url}' target='_blank'>{$request_url}</a><br/>



							");	



		$mail_result = $this->email->send();

	}



	private function approval_signatures_mail_date_updated($role, $name, $mail, $request_id) {

		$this->load->library('email');

		$this->load->helper('url');



		$request_url = base_url().'workshop/request_view/'.$request_id;

		

		$this->email->from('e-signature@sunrise-resorts.com');

		$this->email->to($mail);



		$this->email->subject("WorkShop Delivery Date Updated #{$request_id}");

		$this->email->message("Dear {$name},<br/>

							<br/>

							Workshop chif engineer update delivry date in request No. #{$request_id} you can check it from this link<br/>

							<a href='{$request_url}' target='_blank'>{$request_url}</a><br/>



							");	



		$mail_result = $this->email->send();

	}



	private function engineer_mail($mail, $request_id) {

		$this->load->library('email');

		$this->load->helper('url');

		

		$this->email->from('e-signature@sunrise-resorts.com');

		$this->email->to($mail);



		$this->email->subject("Request {$request_id}");

		$order_url = base_url().'workshop/order_submit/'.$request_id;



		$this->email->message("

								You can create a workshop order as per this request No.{$request_id} has been approved.<br />

								<a href='{$order_url}' target='_blank'>{$order_url}</a><br/>



								");	

		$mail_result = $this->email->send();



	}



	private function chif_engineer_mail($mail, $request_id) {

		$this->load->library('email');

		$this->load->helper('url');

		

		$this->email->from('e-signature@sunrise-resorts.com');

		$this->email->to($mail);



		$this->email->subject("Order Approved{$request_id}");

		$request_url = base_url().'workshop/request_view/'.$request_id;



		$this->email->message("

								Your order has been approved. You can check it from here <br />

								<a href='{$request_url}' target='_blank'>{$request_url}</a><br/>



								");	

		$mail_result = $this->email->send();



	}



	private function order_signatures_mail($role, $name, $mail, $order_id) {

		$this->load->library('email');

		$this->load->helper('url');



		$order_url = base_url().'workshop/order_view/'.$order_id;

		

		$this->email->from('e-signature@sunrise-resorts.com');

		$this->email->to($mail);



		$this->email->subject("WorkShop order {$order_id}");

		$this->email->message("Dear {$name},<br/>

							<br/>

							Order {$order_id} requires your signature, Please use the link below:<br/>

							<a href='{$order_url}' target='_blank'>{$order_url}</a><br/>



							");	



		$mail_result = $this->email->send();

	}



/* Notifi Chif engineer when request approved*/

	private function notify_engineer($request_id, $hotel_id) {

		$users = $this->users_model->getby_criteria(34, $hotel_id, 30);

		foreach ($users as $use) {

			$this->engineer_mail($use['email'], $request_id);

		}



		return TRUE;

	}



/* Notifi Chif engineer when order approved*/

	private function notify_chif_engineer($request_id, $hotel_id) {

		$users = $this->users_model->getby_criteria(34, $hotel_id, 30);

		foreach ($users as $use) {

			$this->chif_engineer_mail($use['email'], $request_id);

		}



		return TRUE;

	}



/* Notifi Hotel Request when request created*/

	private function notify_request_signers($request_id) {

		$notified = FALSE;

		$signers = $this->get_request_signers($request_id, $this->data['workshop_requests']['hotel_id']);

		foreach ($signers as $signer) {

			if (isset($signer['queue'])) {

				$notified = TRUE;

					foreach ($signer['queue'] as $uid => $user) {

						$this->request_signatures_mail($signer['role'], $user['name'], $user['mail'], $request_id);



				}

				break;

			}

		}

		return $notified;

	}



/* Notifi Hotel approval when request approved and order approved*/

	private function notify_approval_signers($request_id) {

		$notified = FALSE;

		$signers = $this->get_approval_signers($request_id, $this->data['workshop_requests']['hotel_id']);

		foreach ($signers as $signer) {

			if (isset($signer['queue'])) {

				$notified = TRUE;

					foreach ($signer['queue'] as $uid => $user) {

						$this->approval_signatures_mail($signer['role'], $user['name'], $user['mail'], $request_id);



				}

				break;

			}

		}

		return $notified;

	}



/* Notifi Hotel approval when request approved and order approved and delivry date updated */

	private function notify_approval_signers_date_updated($request_id) {

		$notified = FALSE;

		$signers = $this->get_approval_signers($request_id, $this->data['workshop_requests']['hotel_id']);

		foreach ($signers as $signer) {

			if (isset($signer['queue'])) {

				$notified = TRUE;

					foreach ($signer['queue'] as $uid => $user) {

						$this->approval_signatures_mail_date_updated($signer['role'], $user['name'], $user['mail'], $request_id);



				}

				break;

			}

		}

		return $notified;

	}





/* Notifi Workshop when order created*/

	private function notify_order_signers($order_id) {

		$notified = FALSE;

		$signers = $this->get_order_signers($order_id, $this->data['workshop_order']['hotel_id']);

		foreach ($signers as $signer) {

			if (isset($signer['queue'])) {

				$notified = TRUE;

					foreach ($signer['queue'] as $uid => $user) {

						$this->order_signatures_mail($signer['role'], $user['name'], $user['mail'], $order_id);



				}

				break;

			}

		}

		return $notified;

	}

        



	public function request_stage($request_id) {



		$this->load->model('workshop_requests_model');

		$this->data['workshop_requests'] = $this->workshop_requests_model->getrequest($request_id);



		if ($this->data['workshop_requests']['state_id'] == 0) {

			$this->self_sign($request_id);

			$this->workshop_requests_model->update_state($request_id, 1);

				redirect('/workshop/request_stage/'.$request_id);



		} elseif ($this->data['workshop_requests']['state_id'] == 1) {

			$queue = $this->notify_request_signers($request_id, $this->data['workshop_requests']['hotel_id']);

			if (!$queue) {

				$this->workshop_requests_model->update_state($request_id, 2);

				redirect('/workshop/request_stage/'.$request_id);

			}

		} elseif ($this->data['workshop_requests']['state_id'] == 2) {

				$this->notify_engineer($request_id, TRUE);

				// redirect('/workshop/request_stage/'.$request_id);



		} elseif ($this->data['workshop_requests']['state_id'] == 3) {

			$this->notify_approval_signers($request_id, $this->data['workshop_requests']['hotel_id']);

				$this->workshop_requests_model->update_state($request_id, 4);

				redirect('/workshop/request_stage/'.$request_id);



		} elseif ($this->data['workshop_requests']['state_id'] == 4) {

			$queue = $this->notify_approval_signers($request_id, $this->data['workshop_requests']['hotel_id']);

			if (!$queue) {

				$this->workshop_requests_model->update_state($request_id, 5);

				redirect('/workshop/request_stage/'.$request_id);

			}

		} elseif ($this->data['workshop_requests']['state_id'] == 5) {

				$this->notify_chif_engineer($request_id, TRUE);

				$this->workshop_requests_model->update_state($request_id, 6);

				// redirect('/workshop/request_stage/'.$request_id);



		} elseif ($this->data['workshop_requests']['state_id'] == 6) {

				$this->notify_approval_signers_date_updated($request_id, $this->data['workshop_requests']['hotel_id']);

				$this->workshop_requests_model->update_state($request_id, 7);



				// redirect('/workshop/request_stage/'.$request_id);



		} elseif ($this->data['workshop_requests']['state_id'] == 7) {

				$this->notify_approval_signers_date_updated($request_id, $this->data['workshop_requests']['hotel_id']);

				$this->workshop_requests_model->update_state($request_id, 8);



				// redirect('/workshop/request_stage/'.$request_id);



		} elseif ($this->data['workshop_requests']['state_id'] == 8) {

				// redirect('/workshop/request_stage/'.$request_id);



		} 



		redirect('/workshop/request_view/'.$request_id);

	}



	public function order_stage($order_id) {



		$this->load->model('workshop_order_model');

		$this->load->model('workshop_requests_model');

		$this->data['workshop_order'] = $this->workshop_order_model->getorder($order_id);



		if ($this->data['workshop_order']['state_id'] == 0) {

			$this->workshop_order_model->update_state($order_id, 1);

				redirect('/workshop/order_stage/'.$order_id);

		

		} elseif ($this->data['workshop_order']['state_id'] == 1) {

			$queue = $this->notify_order_signers($order_id, $this->data['workshop_order']['hotel_id']);

			if (!$queue) {

				$this->workshop_order_model->update_state($order_id, 2);

				redirect('/workshop/order_stage/'.$order_id);

			}

		

		} elseif ($this->data['workshop_order']['state_id'] == 2) {

				$this->workshop_order_model->update_state($order_id, 3);

				$requests_id = $this->workshop_order_model->get_request($order_id);

				$this->workshop_requests_model->update_state($requests_id, 3);

				redirect('/workshop/request_stage/'.$requests_id);

		

		} elseif ($this->data['workshop_order']['state_id'] == 3) {



				$requests_id = $this->workshop_order_model->get_request($order_id);

				$this->workshop_requests_model->update_state($requests_id, 6);

				$this->workshop_order_model->update_state($order_id, 4);



				redirect('/workshop/request_stage/'.$requests_id);

		

		} elseif ($this->data['workshop_order']['state_id'] == 4) {



				$requests_id = $this->workshop_order_model->get_request($order_id);

				$this->workshop_requests_model->update_state($requests_id, 7);



				redirect('/workshop/request_stage/'.$requests_id);

		

		} 

		redirect('/workshop/order_view/'.$order_id);

	}



	private function get_order_signers($order_id, $hotel_id) {

		$this->load->model('workshop_order_signatures_model');



		$signatures = $this->workshop_order_signatures_model->getby_order_verbal($order_id);



		return $this->roll_signers($signatures, $hotel_id);

	}



	private function get_request_signers($request_id, $hotel_id) {

		$this->load->model('workshop_request_signatures_model');



		$signatures = $this->workshop_request_signatures_model->getby_request_verbal($request_id);



		return $this->roll_signers($signatures, $hotel_id);

	}

		

	private function get_approval_signers($request_id, $hotel_id) {

		$this->load->model('workshop_request_approvals_model');



		$signatures = $this->workshop_request_approvals_model->getby_approvals_verbal($request_id);



		return $this->roll_signers($signatures, $hotel_id);

	}





	public function sign($signature_id, $reject = FALSE) {

		$this->load->model('workshop_request_signatures_model');

		$signature_identity = $this->workshop_request_signatures_model->get_signature_identity($signature_id);



		$signrs = $this->get_request_signers($signature_identity['request_id'], $signature_identity['hotel_id']);



		$this->load->model('workshop_requests_model');

		$this->data['workshop_requests'] = $this->workshop_requests_model->getrequest($signature_identity['request_id']);

		$this->data['workshop_requests']['hotel_id'] = $signature_identity['hotel_id'];

		// die(print_r($this->data['workshop_requests']['id']));



		if (array_key_exists($this->data['user_id'], $signrs[$signature_id]['queue'])) {

			if ($reject) {

				$this->workshop_request_signatures_model->reject($signature_id, $this->data['user_id']);

				redirect('/workshop/request_stage/'.$this->data['workshop_requests']['id']);	

			} else {

				$this->workshop_request_signatures_model->sign($signature_id, $this->data['user_id']);

				redirect('/workshop/request_stage/'.$this->data['workshop_requests']['id']);	



			}

		}

		redirect('/workshop/request_view/'.$this->data['workshop_requests']['id']);

	}



	public function approvals_sign($signature_id, $reject = FALSE) {

		$this->load->model('workshop_request_approvals_model');

		$signature_identity = $this->workshop_request_approvals_model->get_approval_identity($signature_id);



		$approval_signrs = $this->get_approval_signers($signature_identity['request_id'], $signature_identity['hotel_id']);



		$this->load->model('workshop_requests_model');

		$this->data['workshop_requests'] = $this->workshop_requests_model->getrequest($signature_identity['request_id']);

		$this->data['workshop_requests']['hotel_id'] = $signature_identity['hotel_id'];



		if (array_key_exists($this->data['user_id'], $approval_signrs[$signature_id]['queue'])) {

			if ($reject) {

				$this->workshop_request_approvals_model->disapprove($signature_id, $this->data['user_id']);

				redirect('/workshop/request_stage/'.$this->data['workshop_requests']['id']);	

			} else {

				$this->workshop_request_approvals_model->sign($signature_id, $this->data['user_id']);

				redirect('/workshop/request_stage/'.$this->data['workshop_requests']['id']);	



			}

		}

		redirect('/workshop/request_view/'.$this->data['workshop_requests']['id']);

	}



	public function order_sign($signature_id, $reject = FALSE) {

		$this->load->model('workshop_order_signatures_model');

		$this->load->model('workshop_order_model');

		$signature_identity = $this->workshop_order_signatures_model->get_signature_identity($signature_id);

		$this->data['workshop_orders'] = $this->workshop_order_model->getorder($signature_identity['order_id']);

		$this->data['workshop_orders']['hotel_id'] = $signature_identity['hotel_id'];

		$orders_signrs = $this->get_order_signers($signature_identity['order_id'], $signature_identity['hotel_id']);



		

		// die(print_r($this->data['workshop_orders']['hotel_id']));





		if (array_key_exists($this->data['user_id'], $orders_signrs[$signature_id]['queue'])) {

			if ($reject) {

				$this->workshop_order_signatures_model->reject($signature_id, $this->data['user_id']);

				redirect('/workshop/order_stage/'.$this->data['workshop_orders']['id']);	



			} else {

				$this->workshop_order_signatures_model->sign($signature_id, $this->data['user_id']);

				redirect('/workshop/order_stage/'.$this->data['workshop_orders']['id']);	



			}

		}

		redirect('/workshop/order_view/'.$this->data['workshop_order']['id']);

	}



	private function roll_signers($signatures, $hotel_id) {

		$signers = array();

		$this->load->model('users_model');



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
              }

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





	public function unsign($signature_id) {

		$this->load->model('workshop_request_signatures_model');



		$signature_identity = $this->workshop_request_signatures_model->get_signature_identity($signature_id);



		$this->load->model('workshop_requests_model');

		$this->workshop_request_signatures_model->unsign($signature_id);



		$workshop_requests = $this->workshop_requests_model->getrequest($signature_identity['request_id']);

		redirect('/workshop/request_view/'.$workshop_requests['id']);

	}



	public function approvals_unsign($signature_id) {

		$this->load->model('workshop_request_approvals_model');



		$signature_identity = $this->workshop_request_approvals_model->get_approval_identity($signature_id);



		$this->load->model('workshop_requests_model');

		$this->workshop_request_approvals_model->unsign($signature_id);



		$workshop_requests = $this->workshop_requests_model->getrequest($signature_identity['request_id']);

		redirect('/workshop/request_view/'.$workshop_requests['id']);

	}



	public function order_unsign($signature_id) {

		$this->load->model('workshop_order_signatures_model');



		$signature_identity = $this->workshop_order_signatures_model->get_signature_identity($signature_id);



		$this->load->model('workshop_order_model');

		$this->workshop_order_signatures_model->unsign($signature_id);



		$workshop_order = $this->workshop_order_model->getorder($signature_identity['order_id']);

		redirect('/workshop/order_view/'.$workshop_order['id']);

	}



	private function self_sign($request_id) {

		$this->load->model('workshop_request_signatures_model');

		$this->workshop_request_signatures_model->self_sign($request_id, $this->data['user_id']);

	}







	private function manipulate_signatures($signatures) {

			foreach ($signatures as $key => $sign) {

				if ($sign['role_id'] == 4) {

					unset($signatures[$key]);

				}

			}

		

			// die (print_r($signatures));

		return $signatures;

	}











	public function request_submit() {

		if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {

	      redirect('/unknown');

	    }else{

			if ($this->input->post('submit')) {



				$this->load->library('form_validation');



				$this->form_validation->set_rules('from-hotel','From hotel','trim|required');

				// $this->form_validation->set_rules('workshop_name','Workshop Name','trim|required');

	            $this->form_validation->set_rules('items','Items','required');



		    	if ($this->form_validation->run() == TRUE) {

		    		$this->load->model('workshop_requests_model');

		    		$this->load->model('workshop_request_items_model');



		    		$request_data = array(

		    							'user_id' => $this->data['user_id'],

		    							'hotel_id' => $this->input->post('from-hotel'),

		    							// 'name' => $this->input->post('workshop_name'),

		    							'remarks' => $this->input->post('remarks'),

		    							'state_id' => 0

		    							);

	                $request_id = $this->workshop_requests_model->create($request_data);

		    		if (!$request_id) {



	                                die("ERROR");//@TODO failure view

		    		}



		    		foreach ($this->input->post('items') as $iKey => $item) {

		    			$item['request_id'] = $request_id;

		    			

		    			$file_name = $this->do_upload("items-".$iKey."-sample_file");

		    			$item['sample_file'] = $file_name;



		    			$item_id = $this->workshop_request_items_model->create($item);



		    			if (!$item_id) {

			    			die("ERROR");//@TODO failure view

			    		}



		    		}



		    		$this->load->model('workshop_hotel_signatures_model');

	    			$this->load->model('workshop_request_signatures_model');

	    			$this->load->model('workshop_request_approvals_model');

	    			$hotel_signatures = $this->workshop_hotel_signatures_model->getby_hotel($this->input->post('from-hotel'));

	    			$final_signatures = $this->manipulate_signatures($hotel_signatures);



	    			foreach ($hotel_signatures as $request_approvals_signature) {

	    				$this->workshop_request_approvals_model->add_request_approval($request_id, $request_approvals_signature['role_id'], $request_approvals_signature['rank']);

	    			}

	    			$this->workshop_request_signatures_model->add_request_signature($request_id, 0, 0);

	    			foreach ($final_signatures as $request_signature) {

	    				$this->workshop_request_signatures_model->add_request_signature($request_id, $request_signature['role_id'], $request_signature['rank']);

	    			}



		    		redirect('/workshop/request_stage/'.$request_id);

		    	}

			}



			try {



				$this->load->helper('form');

				$this->load->model('workshop_requests_model');

				$this->load->model('hotels_model');



				$this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());



				$this->load->view('workshop_request_submit',$this->data);

			}

			catch( Exception $e) {

				show_error($e->getMessage()." _ ". $e->getTraceAsString());

			}

		}

	}



        

    public function order_submit($request_id) {

    	if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {

	      redirect('/unknown');

	    }else{

			if ($this->input->post('submit')) {



				$this->load->library('form_validation');

	                        

	            $this->form_validation->set_rules('items','Items','required');

	                        $assumed_id = $this->input->post('assumed_id');                        

	                        

		    	if ($this->form_validation->run() == TRUE) {

		    		$this->load->model('workshop_order_model');

		    		$this->load->model('workshop_order_items_model');



		    		$order_data = array(

		    							'remarks' => $this->input->post('remarks'),

		    							'state_id' => 0 ,

		    							'request_id' => $request_id

		    							);

	                $order_id = $this->workshop_order_model->create($order_data);

		    		if ($order_id) {

	                            $this->load->model('workshop_order_files_model');

	                            $this->workshop_order_files_model->update_files($assumed_id,$order_id);

	                } else {

		    		die("ERROR");//@TODO failure view

		    		}





		    		foreach ($this->input->post('items') as $item) {

		    			$item['order_id'] = $order_id;

		    			

		    			$item_id = $this->workshop_order_items_model->create($item);

		    			if (!$item_id) {

			    			die("ERROR");//@TODO failure view

			    		}

		    		}

		    			    			 // die (print_r($this->input->post('items')));



		    		$this->load->model('workshop_order_signatures_template_model');

	    			$this->load->model('workshop_order_signatures_model');

	    			$template_signatures = $this->workshop_order_signatures_template_model->getall();



	    			foreach ($template_signatures as $order_signature) {

	    				$this->workshop_order_signatures_model->add_order_signature($order_id, $order_signature['role_id'], $order_signature['rank']);

	    			}

		    		redirect('/workshop/order_stage/'.$order_id);

		    	}

			}



			try {



				$this->load->helper('form');

				$this->load->model('workshop_order_model');

				$this->load->model('workshop_requests_model');

				$this->load->model('hotels_model');

				

				$this->data['hotels'] = $this->hotels_model->getall();

				$this->data['workshop_requests'] = $this->workshop_requests_model->getrequest($request_id);

	                        

	            if ($this->input->post('submit')) {



					$this->load->model('workshop_order_files_model');

					$this->data['assumed_id'] = $this->input->post('assumed_id');

					$this->data['files'] = $this->workshop_order_files_model->getby_order($this->data['assumed_id']);

				} else {



					$this->data['assumed_id'] = strtoupper(str_pad(dechex( mt_rand( 0, 1048575 ) ), 5, '0', STR_PAD_LEFT));

					$this->data['files'] = array();

				}

	                        

				$this->load->view('workshop_order_submit',$this->data);

			}

			catch( Exception $e) {

				show_error($e->getMessage()." _ ". $e->getTraceAsString());

			}

		}

	}





	public function order_edit($order_id) {

		if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {

	      redirect('/unknown');

	    }else{

			if ($this->input->post('submit')) {

		    		$this->load->model('workshop_order_model');



		    		$order_data = array();



					$order_data['delivery_date'] = $this->input->post('delivery_date');



		    		$orders_id = $this->workshop_order_model->update_by_id($order_id, $order_data);



		    		if (!isset($order_id)) {

		    			die("ERROR");//@TODO failure view

		    		}



		    		redirect('/workshop/order_stage/'.$order_id);

			}



			try {



				$this->load->helper('form');

				$this->load->model('workshop_order_model');

				$this->load->model('workshop_order_items_model');

				$this->load->model('workshop_order_files_model');

				$this->load->model('hotels_model');

				$this->data['hotels'] = $this->hotels_model->getall();

	            $this->data['workshop_order'] = $this->workshop_order_model->getorder($order_id);

	            $this->data['items'] = $this->workshop_order_items_model->get_order_items($order_id);

				$this->data['workshop_order_files'] = $this->workshop_order_files_model->getby_order($this->data['workshop_order']['id']);

				$this->data['signature_path'] = '/assets/uploads/signatures/';

				$this->data['order_signers'] = $this->get_order_signers($this->data['workshop_order']['id'], $this->data['workshop_order']['hotel_id']);



	       

				$this->load->view('workshop_order_edit',$this->data);

			}

			catch( Exception $e) {

				show_error($e->getMessage()." _ ". $e->getTraceAsString());

			}

		}

	}







	public function request_view($request_id) {

		if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {

	      redirect('/unknown');

	    }else{

			$this->load->model('workshop_order_model');

			$this->load->model('workshop_order_items_model');

			$this->load->model('workshop_requests_model');

			$this->load->model('workshop_request_items_model');

			$this->load->model('workshop_order_files_model');

			$this->load->model("workshop_request_comments_model");

			$this->load->model("workshop_request_reciver_model");

			$this->load->model('hotels_model');			

			$this->data['hotels'] = $this->hotels_model->getall();

			$this->data['workshop_requests'] = $this->workshop_requests_model->getrequest($request_id);

	        $this->data['workshop_order'] = $this->workshop_order_model->view_order($request_id);

	        $this->data['workshop_order_log'] = $this->workshop_order_model->view_order_log($request_id);



	        $this->data['items'] = $this->workshop_request_items_model->get_request_items($request_id);

			$this->data['logo_path'] = '/assets/uploads/logos/';

			$this->data['file_path'] = '/assets/uploads/files/';

			$this->data['signature_path'] = '/assets/uploads/signatures/';

			$this->data['signers'] = $this->get_request_signers($this->data['workshop_requests']['id'], $this->data['workshop_requests']['hotel_id']);

			$this->data['approval_signers'] = $this->get_approval_signers($this->data['workshop_requests']['id'], $this->data['workshop_requests']['hotel_id']);

			$this->data['order_signers'] = $this->get_order_signers($this->data['workshop_order']['id'], $this->data['workshop_order']['hotel_id']);



	        $this->data['workshop_order_items'] = $this->workshop_order_items_model->view_order_items($request_id);

			$this->data['workshop_order_files'] = $this->workshop_order_files_model->viewby_order($this->data['workshop_order']['request_id']);

					

			$this->data['comments'] = $this->workshop_request_comments_model->getby_workshop_request($this->data['workshop_requests']['id']);

			$this->data['reciver'] = $this->workshop_request_reciver_model->getby_workshop_request($this->data['workshop_requests']['id']);



			$editor = FALSE;

			$unsign_enable = FALSE;



			$first = TRUE;

			$force_edit = FALSE;



			foreach ($this->data['signers'] as $signer) {

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





			$this->data['unsign_enable'] = (($unsign_enable) || $this->data['is_admin'])? TRUE : FALSE;

			$this->data['is_editor'] = ( (($this->data['unsign_enable'] || $editor)) || ($force_edit) )? TRUE : FALSE;



			$user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);

			$this->data['isWS'] = ($user->role_id == 35)? TRUE : FALSE;



	        $this->data['id'] = $request_id;

	        $this->load->view('workshop_request_view', $this->data);

	    }



    }

	public function order_view($order_id) {

		if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {

	      redirect('/unknown');

	    }else{

				$this->load->model('workshop_order_model');

				$this->load->model('workshop_order_items_model');

				$this->load->model('workshop_order_files_model');

				$this->load->model('hotels_model');

				$this->data['hotels'] = $this->hotels_model->getall();

	            $this->data['workshop_order'] = $this->workshop_order_model->getorder($order_id);

	            // $this->data['workshop_order_log'] = $this->workshop_order_model->get_log($order_id);

	            $this->data['items'] = $this->workshop_order_items_model->get_order_items($order_id);

				$this->data['workshop_order_files'] = $this->workshop_order_files_model->getby_order($this->data['workshop_order']['id']);

				$this->data['signature_path'] = '/assets/uploads/signatures/';

				$this->data['orders_signers'] = $this->get_order_signers($this->data['workshop_order']['id'], $this->data['workshop_order']['hotel_id']);





			$editor = FALSE;

			$unsign_enable = FALSE;



			$first = TRUE;

			$force_edit = FALSE;



			foreach ($this->data['orders_signers'] as $order_signer) {

				if (isset($order_signer['queue'])) {

					foreach ($order_signer['queue'] as $uid => $dummy) {

						if ( $uid == $this->data['user_id'] ) {

							$editor = TRUE;

							break;

						}

					}

				} elseif (isset($order_signer['sign'])) {

					$unsign_enable = FALSE;

					$force_edit = FALSE;





					if ($order_signer['sign']['id'] == $this->data['user_id']) {



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



			$this->data['unsign_enable'] = (($unsign_enable) || $this->data['is_admin'])? TRUE : FALSE;

			$this->data['is_editor'] = ( (($this->data['unsign_enable'] || $editor)) || ($force_edit) )? TRUE : FALSE;



		    $this->data['id'] = $order_id;

	        $this->load->view('workshop_order_view', $this->data);

	    }



    }







        private function do_upload($field) {

        	print_r($_FILES);

        	// die($field);



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



    public function add_files($order_id) {

		$file_name = $this->do_upload("files");

		if (!$file_name) {

			die(json_encode($this->data['error']));

		} else {

			$this->load->model("workshop_order_files_model");

			$this->workshop_order_files_model->add($order_id, $file_name);

			die("{}");

		}

	}



























	public function cancelitem($request_id, $item_id) {

		$this->load->model('workshop_request_items_model');

		$this->workshop_request_items_model->delete($item_id);



		redirect('/workshop/request_view/'.$request_id);

	}



	public function approveitem($request_id, $item_id, $item_code) {

		$this->load->model('workshop_request_items_model');

			$item_data = array('done' => 1);

		$this->workshop_request_items_model->update($item_id, $item_data);



		// $this->notify_members($plan_id, $item_code, "cancelled");



		redirect('/workshop/request_view/'.$request_id);

	}



	public function approve($id) {

		$this->load->model('workshop_requests_model');

		$this->workshop_requests_model->update($id);



		// $this->notify_members($plan_id, $item_code, "cancelled");



		redirect('/workshop/');

	}





	public function additem($request_id) {

		if ($this->input->post('submit')) {



			$this->load->library('form_validation');



			$this->form_validation->set_rules('quantity','quantity','trim|required');

			$this->form_validation->set_rules('unit','unit','trim|required|number');

			$this->form_validation->set_rules('description','description','trim|required');

			$this->form_validation->set_rules('remarks','Remarks','trim');

			$this->form_validation->set_rules('sample_file','Sample_File','trim');



			$data = array(

						'request_id' => $this->input->post('request_id'),

						'quantity' => $this->input->post('quantity'),

						'unit' => $this->input->post('unit'),

						'description' => $this->input->post('description'),

						'remarks' => $this->input->post('remarks'),

						'sample_file' => $this->input->post('sample_file')

						);

			$remarks = $this->input->post('remark');

			$this->load->model('Workshop_requests_model');

			$this->Workshop_requests_model->update_remark($request_id, $remarks);

			if ($this->form_validation->run() == TRUE) {



				if ($item_id = $this->input->post('id')) {

					$item_code = $this->update_item($item_id, $data);

				

				} else {

					$item_code = $this->add_item($data, $request_id);

				}

			}



		}

		redirect('/workshop/request_view/'.$data['request_id']);

	}



	private function update_item($item_id, $data) {

		$this->load->model('workshop_request_items_model');

		$this->workshop_request_items_model->update($item_id, $data);

		$request_id = $this->workshop_request_items_model->get_request($item_id);



		return $request_id;

	}



	private function add_item($data, $request_id) {

		$this->load->model('workshop_request_items_model');

		$data['request_id'] = $request_id;

		$this->workshop_request_items_model->create($data);



		return $request_id;

	}





























	public function order_cancelitem($order_id, $item_id) {

		$this->load->model('workshop_order_items_model');

		$this->workshop_order_items_model->delete($item_id);



		redirect('/workshop/order_view/'.$order_id);

	}



	public function order_additem($order_id) {

		if ($this->input->post('submit')) {



			$this->load->library('form_validation');



			$this->form_validation->set_rules('quantity','quantity','trim|required');

			$this->form_validation->set_rules('unit','unit','trim|required|number');

			$this->form_validation->set_rules('description','description','trim|required');

			$this->form_validation->set_rules('price','price','trim|required');

			$this->form_validation->set_rules('remarks','Remarks','trim');



			$data = array(

						'order_id' => $this->input->post('order_id'),

						'quantity' => $this->input->post('quantity'),

						'unit' => $this->input->post('unit'),

						'description' => $this->input->post('description'),

						'price' => $this->input->post('price'),

						'remarks' => $this->input->post('remarks'),

						);

			$remarks = $this->input->post('remark');

		$this->load->model('workshop_order_model');

			$this->workshop_order_model->update_remark($order_id, $remarks);

			if ($this->form_validation->run() == TRUE) {



				if ($item_id = $this->input->post('id')) {

					$item_code = $this->order_update_item($item_id, $data);

				

				} else {

					$item_code = $this->order_add_item($data, $order_id);

				}

			}



		}

		redirect('/workshop/order_view/'.$data['order_id']);

	}



	private function order_update_item($item_id, $data) {

		$this->load->model('workshop_order_items_model');

		$this->workshop_order_items_model->update($item_id, $data);

		$order_id = $this->workshop_order_items_model->get_order($item_id);



		return $order_id;

	}



	private function order_add_item($data, $order_id) {

		$this->load->model('workshop_order_items_model');

		$data['order_id'] = $order_id;

		$this->workshop_order_items_model->create($data);



		return $order_id;

	}















	private function comment_alert($user_name, $comment, $request_id, $mails) {

		$this->load->library('email');

		$this->load->helper('url');



		$workshop_request_url = base_url().'workshop/request_view/'.$request_id;

		

		$this->email->from('e-signature@sunrise-resorts.com');

		$this->email->to($mails);



		$this->email->subject("Workshop Request {$request_id}");

		$this->email->message("{$user_name} added a comment for workshop request {$request_id}:<br/>

							{$comment}<br />

							<br />



							Please use the link below to view the workshop request

							<a href='{$workshop_request_url}' target='_blank'>{$workshop_request_url}</a><br/>



							");	



		$mail_result = $this->email->send();



	}







		public function comment($request_id) {

		if ($this->input->post('submit')) {



			$this->load->library('form_validation');



			$this->form_validation->set_rules('comment');



	    	if ($this->form_validation->run() == TRUE) {



	    		$comment = $this->input->post('comment');



	    		$this->load->model("workshop_request_comments_model");

	    		$comment_data = array(

	    								'user_id' => $this->data['user_id'],

	    								'request_id' => $request_id,

	    								'comment' => $comment

	    							);

				$this->workshop_request_comments_model->add($comment_data);

			

				$user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);



				$this->load->model("workshop_request_signatures_model");

				$approvers = $this->workshop_request_signatures_model->getby_request_approved($request_id);



				$mails = array();



				foreach ($approvers as $approver) {

					$mails[] = $approver['email'];

				}



				$this->comment_alert($user->fullname, $comment, $request_id, $mails);

			}

	    }

	    redirect('/workshop/request_view/'.$request_id);

	}







		public function reciver($request_id) {

		if ($this->input->post('submit')) {



			$this->load->library('form_validation');



			$this->form_validation->set_rules('reciver');



	    	if ($this->form_validation->run() == TRUE) {



	    		$message = $this->input->post('message');



	    		$this->load->model("workshop_request_reciver_model");

	    		$comment_data = array(

	    								'user_id' => $this->data['user_id'],

	    								'request_id' => $request_id,

	    								'message' => $message

	    							);

				$this->workshop_request_reciver_model->add($comment_data);

			

				$user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);



/*				$this->load->model("workshop_request_signatures_model");

				$approvers = $this->workshop_request_signatures_model->getby_request_approved($request_id);



				$mails = array();



				foreach ($approvers as $approver) {

					$mails[] = $approver['email'];

				}



				$this->comment_alert($user->fullname, $comment, $request_id, $mails);

*/			}

	    }

	    redirect('/workshop/request_view/'.$request_id);

	}



}