<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  	class market extends CI_Controller {

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
	      $this->data['menu']['active'] = "reserve";
	    }

	    public function index() {
      		if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        		redirect('/unknown');
      		}else{
        		$this->load->model('market_model');
        		$this->data['market'] = $this->market_model->view();
        		foreach ($this->data['market'] as $key => $out) {
          			$this->data['market'][$key]['approvals'] = $this->market_model->get_by_verbals($this->data['market'][$key]['id']);
        		} 
        		$this->load->view('market_index', $this->data);
      		}
    	}

    	public function index_app() {
      		if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        		redirect('/unknown');
      		}else{
        		$this->load->model('market_model');
        		$this->data['market'] = $this->market_model->view(2);
        		foreach ($this->data['market'] as $key => $out) {
          			$this->data['market'][$key]['approvals'] = $this->market_model->get_by_verbals($this->data['market'][$key]['id']);
        		} 
        		$this->load->view('market_index', $this->data);
      		}
    	}

    	public function index_wat() {
      		if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        		redirect('/unknown');
      		}else{
        		if ($this->input->post('submit')) {
          			$state = $this->input->post('state');
          			$this->load->model('market_model');
          			$this->data['market'] = $this->market_model->view($state);
          			foreach ($this->data['market'] as $key => $out) {
            			$this->data['market'][$key]['approvals'] = $this->market_model->get_by_verbals($this->data['market'][$key]['id']);
          			} 
          			$this->data['state'] = $state;
        		}
        		$this->load->view('market_index_wat', $this->data);
      		}
    	}

    	public function index_rej() {
      		if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        		redirect('/unknown');
      		}else{
        		$this->load->model('market_model');
        		$this->data['market'] = $this->market_model->view(3);
        		foreach ($this->data['market'] as $key => $out) {
          			$this->data['market'][$key]['approvals'] = $this->market_model->get_by_verbals($this->data['market'][$key]['id']);
        		} 
        		$this->load->view('market_index', $this->data);
    		}
    	}

	    public function submit($id = FALSE) {
	      	if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
	        	redirect('/unknown');
	      	}else{
			     $this->load->model('market_model');
	      		if ($id) {
	      			$this->data['id'] = $id;
	      			$this->data['assumed_id'] = $id;
	          		$this->data['uploads'] = $this->market_model->get_by_fille($id);
	      			$this->data['market'] = $this->market_model->get_market($id);
	      			if ($this->input->post('submit')) {
			          	$this->load->library('form_validation');
			          	$this->load->library('email');
			          	if ($this->form_validation->run() == FALSE) {
			          		$condition = $this->input->post('condition');
			            	$this->market_model->update_condition($id, $condition);
			            	$foram = array(
			              		'market_id' => $id
			            	);
			            	$diff_id = $this->market_model->create_diff_market($foram);
			            	if (!$diff_id) {
			              		die("ERROR");
			            	}
			            	foreach ($this->input->post('period') as $period) {
			            		$period['diff_id'] = $diff_id;
			            		$period_id = $this->market_model->create_period($period);
						        if (!$period_id) {
						          die("ERROR");
						        }
						    }
				        	foreach ($this->input->post('hotel') as $hotel) {
				        		$hotel['diff_id'] = $diff_id;
			                	$this->market_model->create_hotel($hotel);
			            	}
			            	redirect('/market/submit/'.$id);
			        	}
			        }
			    }else{
			    	$this->data['assumed_id'] = mt_rand("1048575","10485751048575");
	          		$assumed_id = $this->input->post('assumed_id');   
	          		$this->data['uploads'] = $this->market_model->get_by_fille($this->data['assumed_id']);                     
			    	if ($this->input->post('submit')) {
			          	$this->load->library('form_validation');
			          	$this->load->library('email');
			          	if ($this->form_validation->run() == FALSE) {
			            	$form = array(
			              		'user_id' => $this->data['user_id'],
			              		'ip' => $this->input->ip_address(),
			              		'condition' => $this->input->post('condition')
			            	);
			            	$market_id = $this->market_model->create_market($form);
			            	if (!$market_id) {
			              		die("ERROR");
			            	}
			            	$foram = array(
			              		'market_id' => $market_id
			            	);
			            	$diff_id = $this->market_model->create_diff_market($foram);
			            	if (!$diff_id) {
			              		die("ERROR");
			            	}
			            	foreach ($this->input->post('period') as $period) {
			            		$period['diff_id'] = $diff_id;
			            		$period_id = $this->market_model->create_period($period);
						        if (!$period_id) {
						          die("ERROR");
						        }
						    }
				        	foreach ($this->input->post('hotel') as $hotel) {
				        		$hotel['diff_id'] = $diff_id;
			                	$this->market_model->create_hotel($hotel);
			            	}
			            	$signatures = $this->market_model->market_sign();
	            			$do_sign = $this->market_model->market_do_sign($market_id);
	            			if ($do_sign == 0) {
	              				foreach ($signatures as $market_signature) {
	                				$this->market_model->add_signature($market_id, $market_signature['role'], $market_signature['department'], $market_signature['rank']);
	              				}
	            			}
			            	redirect('/market/submit/'.$market_id);
			        	}
			        }
			    }
		        try {
		          	$this->load->helper('form');
		          	$this->load->model('market_model');
		          	$this->load->view('market_add_new',$this->data);
		        }
		        catch( Exception $e) {
		          	show_error($e->getMessage()." _ ". $e->getTraceAsString());
		        }
	      	}
	    }

	    public function market_stage($market_id) {
	      	$this->load->model('market_model');
	      	$this->load->model('users_model');
	      	$this->data['market'] = $this->market_model->get_market($market_id);
	      	if ($this->data['market']['state_id'] == 0) {
	        	$this->market_model->update_state($market_id, 1);
	        	redirect('/market/market_stage/'.$market_id);
	      	}elseif ($this->data['market']['state_id'] == 3){
	        	$user = $this->users_model->get_user_by_id($this->data['market']['user_id'], TRUE);
	        	$queue = $this->reject_mail($user->fullname, $user->email, $market_id);
	      	}elseif ($this->data['market']['state_id'] != 2){
	        	$queue = $this->notify_signers($market_id);
	        	if (!$queue) {
	          		$this->market_model->update_state($market_id, 2);
	          		$user = $this->users_model->get_user_by_id($this->data['market']['user_id'], TRUE);
	          		$queue = $this->approvel_mail($user->fullname, $user->email, $market_id);
	          		redirect('/market/market_stage/'.$market_id);
	        	}
	      	}
	      	redirect('/market/view/'.$market_id);
	    }

	    private function reject_mail($name, $email, $market_id) {
	      	$this->load->library('email');
	      	$this->load->helper('url');
	     	$market_url = base_url().'market/view/'.$market_id;
	      	$this->email->from('e-signature@sunrise-resorts.com');
	      	$this->email->to($email);
	      	$this->email->subject("Local Market Form No. #{$market_id}");
	      	$this->email->message("Dear {$name},
		        <br/>
		        <br/>
		        Local Market Form No. #{$market_id} has been rejected, Please use the link below:
		        <br/>
		        <a href='{$market_url}' target='_blank'>{$market_url}</a>
		        <br/>
	      	"); 
	     	$mail_result = $this->email->send();
	    }

	    private function notify_signers($market_id) {
	      	$notified = FALSE;
	      	$market_url = base_url().'market/view/'.$market_id;
		    $message = "Local Market Form No. {$market_id}:
		       	{$market_url}";
	      	$signers = $this->get_signers($market_id);
	      	foreach ($signers as $signer) {
	        	if (isset($signer['queue'])) {
	         		 $notified = TRUE;
	          		foreach ($signer['queue'] as $uid => $user) {
	          			$this->onclick($message, $market_id, $user['channel']);
	            		$this->signatures_mail($signer['role'], $signer['department'], $user['name'], $user['mail'], $market_id);
	          		}
	          		break;
	        	}
	      	}
	      	return $notified;
	    }

	    private function get_signers($market_id) {
	      	$this->load->model('market_model');
	      	$signatures = $this->market_model->get_by_verbal($market_id);
	      	return $this->roll_signers($signatures, $market_id);
	    }

	    private function roll_signers($signatures, $market_id) {
	      	$signers = array();
	      	$this->load->model('users_model');
	      	$this->load->model('market_model');
	      	$market = $this->market_model->get_market($market_id);
	      	foreach ($signatures as $signature) {
	        	$signers[$signature['id']] = array();
	        	$signers[$signature['id']]['role'] = $signature['role'];
	        	$signers[$signature['id']]['role_id'] = $signature['role_id'];
	          	$signers[$signature['id']]['department'] = $signature['department'];
	        	$signers[$signature['id']]['department_id'] = $signature['department_id'];
	        	if ($signature['user_id']) {
	          		if ($signature['rank'] == 1){
	            		$this->market_model->update_state($market_id, 4);
	          		}elseif ($signature['rank'] == 2){
	            		$this->market_model->update_state($market_id, 5);
	          		}elseif ($signature['rank'] == 3){
	            		$this->market_model->update_state($market_id, 6);
	          		}elseif ($signature['rank'] == 4){
	            		$this->market_model->update_state($market_id, 7);
	            	}elseif ($signature['rank'] == 5){
	            		$this->market_model->update_state($market_id, 2);
	          		}
	          		$signers[$signature['id']]['sign'] = array();
	          		$signers[$signature['id']]['sign']['id'] = $signature['user_id'];
	          		if ($signature['reject'] == 1) {
	            		$signers[$signature['id']]['sign']['reject'] = "reject";
	            		$this->market_model->update_state($market_id, 3);
	          		} 
	          		$user = $this->users_model->get_user_by_id($signature['user_id'], TRUE);
	          		$signers[$signature['id']]['sign']['name'] = $user->fullname;
	          		$signers[$signature['id']]['sign']['mail'] = $user->email;
	          		$signers[$signature['id']]['sign']['channel'] = $user->channel;
	          		$signers[$signature['id']]['sign']['sign'] = $user->signature;
	          		$signers[$signature['id']]['sign']['timestamp'] = $signature['timestamp'];
	        	} else {
	          		$signers[$signature['id']]['queue'] = array();
	          		$users = $this->market_model->getby_role($signature['role_id'], $signature['department_id']);
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

	    private function signatures_mail($role, $department, $name, $mail, $market_id) {
	      	$this->load->library('email');
	      	$this->load->helper('url');
	     	$market_url = base_url().'market/view/'.$market_id;
	      	$this->email->from('e-signature@sunrise-resorts.com');
	      	$this->email->to($mail);
	      	$this->email->subject("Local Market Form No. #{$market_id}");
	      	$this->email->message("Dear {$name},
		        <br/>
		        <br/>
		        Local Market Form No. #{$market_id} requires your signature, Please use the link below:
		        <br/>
		        <a href='{$market_url}' target='_blank'>{$market_url}</a>
		        <br/>
	      	"); 
	      	$mail_result = $this->email->send();
	    }

	    private function approvel_mail($name, $email, $market_id) {
	      	$this->load->library('email');
	      	$this->load->helper('url');
	      	$market_url = base_url().'market/view/'.$market_id;
	      	$this->email->from('e-signature@sunrise-resorts.com');
	      	$this->email->to($mail);
	      	$this->email->subject("Local Market Form No. #{$market_id}");
	      	$this->email->message("Dear {$name},
		        <br/>
		        <br/>
		        Local Market Form No. #{$market_id} has been approved, Please use the link below:
		        <br/>
		        <a href='{$market_url}' target='_blank'>{$market_url}</a>
		        <br/>
	      	"); 
	      	$mail_result = $this->email->send();
	    }

	    public function view($market_id) {
	      	if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
	        	redirect('/unknown');
	      	}else{      
	        	$this->load->model('market_model');
	        	$this->data['market'] = $this->market_model->get_market($market_id);
	      		$this->data['differents'] = $this->market_model->get_diff_market($market_id);
	      		foreach ($this->data['differents'] as $key => $different) {
	          		$this->data['differents'][$key]['periods'] = $this->market_model->get_period($this->data['differents'][$key]['id']);
	          		$this->data['differents'][$key]['hotels'] = $this->market_model->get_hotel($this->data['differents'][$key]['id']);
	        	} 
	        	$this->data['uploads'] = $this->market_model->get_by_fille($market_id);
	        	$this->data['comments'] = $this->market_model->get_comment($market_id);
	        	$this->data['signature_path'] = '/assets/uploads/signatures/';
	        	$this->data['signers'] = $this->get_signers($this->data['market']['id']);
	        	$editor = FALSE;
	        	$unsign_enable = FALSE;
	        	$first = TRUE;
	        	$force_edit = FALSE;
	        	foreach ($this->data['signers'] as $signer) {
	          		if (isset($signer['sign'])) {
	            		$unsign_enable = FALSE;
	            		$force_edit = FALSE;
	            		if ($signer['sign']['id'] == $this->data['user_id']) {
	              			if ($first) {
	                			$force_edit = TRUE;
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
	          		if ( $this->data['market']['user_id'] == $this->data['user_id'] &&  $this->data['market']['state_id'] != 2) {
	            		$editor = TRUE;
	          		}
	        	}
	        	$this->data['unsign_enable'] = (($unsign_enable) || $this->data['is_admin'])? TRUE : FALSE;
	        	$this->data['is_editor'] = ($editor || $this->data['is_admin'])? TRUE : FALSE;
	        	$this->load->view('market_view', $this->data);
	      	}
	    }

	    public function upload($market_id) {
	      	$file_name = $this->do_upload("upload");
	      	if (!$file_name) {
	        	die(json_encode($this->data['error']));
	      	} else {
	        	$this->load->model("market_model");
	        	$this->market_model->add_fille($market_id, $file_name, $this->data['user_id']);
	        	die("{}");
	      	}
	    }

	    public function remove($market_id, $id) {
	      	$file_name = $_POST['key'];
	      	if (!$id) {
	        	die(json_encode($this->data['error']));
	      	} else {
	        	$this->load->model("market_model");
	        	$this->market_model->remove_fille($id);
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
	      	} else {
	        	$file = $this->upload->data();
	        	return $file['file_name'];
	      	}
	    }

	    public function edit($market_id) {
	      	if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
	        	redirect('/unknown');
	      	}else{
	        	if ($this->input->post('submit')) {
			        $this->load->library('form_validation');
			        $this->load->library('email');
			        if ($this->form_validation->run() == FALSE) {
	            		$this->load->model('market_model');
	            		$condition = $this->input->post('condition');
			            $this->market_model->update_condition($market_id, $condition);
		            	foreach ($this->input->post('period') as $period) {
		              		$this->market_model->update_period($period['id'], $period['diff_id'], $period);
		            	}
		            	foreach ($this->input->post('hotel') as $hotel) {
		              		$this->market_model->update_hotel($hotel['id'], $hotel['diff_id'], $hotel);
		            	}
	            		redirect('/market/view/'.$market_id);
	          		}   
	        	}
	        	try {
	          		$this->load->helper('form');
	          		$this->load->model('market_model');
	          		$this->data['market'] = $this->market_model->get_market($market_id);
	      			$this->data['differents'] = $this->market_model->get_diff_market($market_id);
	      			foreach ($this->data['differents'] as $key => $different) {
	          			$this->data['differents'][$key]['periods'] = $this->market_model->get_period($this->data['differents'][$key]['id']);
	          			$this->data['differents'][$key]['hotels'] = $this->market_model->get_hotel($this->data['differents'][$key]['id']);
	        		} 
	        		$this->data['uploads'] = $this->market_model->get_by_fille($market_id);
	          		$this->load->view('market_edit',$this->data);
	        	}
	        	catch( Exception $e) {
	          		show_error($e->getMessage()." _ ". $e->getTraceAsString());
	        	}
	      	}
	    }

	    public function mail_me($market_id) {
	      	$user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
	      	$this->load->library('email');
	      	$this->load->helper('url');
	      	$market_url = base_url().'market/view/'.$market_id;
	      	$this->email->from('e-signature@sunrise-resorts.com');
	      	$this->email->to($user->email);
	      	$this->email->subject("Local Market Form No. #{$market_id}");
	      	$this->email->message("Local Market Form NO.#{$market_id}:
	        	<br/>
	        	Please use the link below to view The Local Market Form:
	        	<a href='{$market_url}' target='_blank'>{$market_url}</a>
	        	<br/>
	      	"); 
	      	$mail_result = $this->email->send();
	      	redirect('market/view/'.$market_id);
	    }

	    public function mail($market_id) {
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
		          	$market_url = base_url().'market/view/'.$market_id;
		          	$this->email->from('e-signature@sunrise-resorts.com');
		          	$this->email->to($email);
		          	$this->email->subject("A message from {$user->fullname}, Local Market Form No. #{$market_id}");
		          	$this->email->message("{$user->fullname} sent you a private message regarding Local Market Form No. #{$market_id}:
		            	<br/>
		            	{$message}
		            	<br />
		            	<br />
		            	Please use the link below to view the Local Market Form:
		            	<a href='{$market_url}' target='_blank'>{$market_url}</a>
		            	<br/>
		          	"); 
		          	$mail_result = $this->email->send();
		        }
	      	}
	      	redirect('market/view/'.$market_id);
	    }

	    public function share_url($market_id) {
	      if ($this->input->post('submit')) {
	        $message = $this->input->post('message');
	        $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
	        $market_url = base_url().'market/view/'.$market_id;
	        $messages = "{$user->fullname} Local Market Form No. {$market_id}
	          {$market_url}";  
	        $this->onclick($messages, $market_id, $this->config->item('page_to_send'));
	      }
	      redirect('market/view/'.$market_id);
	    }

	    public function unsign($signature_id) {
	      	$this->load->model('market_model');
	      	$signature_identity = $this->market_model->get_signature_identity($signature_id);
	      	$this->market_model->unsign($signature_id);
	      	redirect('/market/market_stage/'.$signature_identity['market_id']);  
	    }

	    public function sign($signature_id, $reject = FALSE) {
	      	$this->load->model('market_model');
	      	$signature_identity = $this->market_model->get_signature_identity($signature_id);
	      	$signrs = $this->get_signers($signature_identity['market_id']);
	      	$this->data['market'] = $this->market_model->get_market($signature_identity['market_id']);
		    $market_url = base_url().'market/view/'.$signature_identity['market_id'];
		    $message_id = $this->data['market']['message_id'];
		    $id = $signature_identity['market_id'];
		    $message = "Local Market Form No. {$id}:
		        {$market_url}";
	      	if (array_key_exists($this->data['user_id'], $signrs[$signature_id]['queue'])) {
	      		if ($signature_identity['role_id'] == 1) {
		          $this->onclick1($message);
		          $this->deletonclick($message_id);
		        }
	        	if ($reject) {
	          		$this->market_model->reject($signature_id, $this->data['user_id']);
	          		redirect('/market/market_stage/'.$signature_identity['market_id']);  
	        	} else {
	          		$this->market_model->sign($signature_id, $this->data['user_id']);
	          		redirect('/market/market_stage/'.$signature_identity['market_id']);  
	        	}
	      	}
	      	redirect('/market/view/'.$signature_identity['market_id']);
	    }

	    public function comment($market_id){
	      	if ($this->input->post('submit')) {
	        	$this->load->library('form_validation');
	        	$this->form_validation->set_rules('comment','Comment','trim|required');
	        	if ($this->form_validation->run() == TRUE) {
	          		$comment = $this->input->post('comment'); 
	          		$this->load->model('market_model');
	          		$comment_data = array(
	            		'user_id' => $this->data['user_id'],
	            		'market_id' => $market_id,
	            		'comment' => $comment
	          		);
	          		$this->market_model->insert_comment($comment_data);
	          		if ($this->data['role_id'] == 217) {
            			$this->chairman_mail($market_id);
          			}
	        	}
	        	redirect('/market/view/'.$market_id);
	      	}
	    }

	    private function chairman_mail($market_id) {
          $this->load->library('email');
          $this->load->helper('url');
          $market_url = base_url().'market/view/'.$market_id;
          $this->email->from('e-signature@sunrise-resorts.com');
          $this->email->to('abeer@sunrise.eg');
          $this->email->subject("Local Market Form No. #{$market_id}");
          $this->email->message("Dear Madam Abber,
            <br/>
            <br/>
            Mr Hossam Commented on Local Market Form No. #{$market_id}, Please use the link below:
            <br/>
            <a href='{$market_url}' target='_blank'>{$market_url}</a>
            <br/>
          "); 
          $mail_result = $this->email->send();
      }

		function onclick($message, $id, $channelss){
	      include(APPPATH . 'third_party/RocketChat/autoload.php');
	      $client = new RocketChat\Client($this->config->item('send_url'));
	      $token = $client->api('user')->login($this->config->item('user_access'),$this->config->item('pass_access'));
	      $client->setToken($token);
	      $channel_result = $client->api('channel')->sendMessage($channelss,$message);
	      $this->load->model('market_model');
	      $this->market_model->update_message_id($id, $channel_result);
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

?>