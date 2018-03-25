<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Forms extends CI_Controller {

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

		$this->data['menu']['active'] = "forms";

	}



	public function chairman() {

		if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {

        	redirect('/unknown');

      	}else{

        	$this->load->model('hotels_model');

        	$this->load->model('forms_model');

        	$this->load->model('items_model');

        	$user_hotels = $this->hotels_model->getby_user($this->data['user_id']);

        	$hotels = array();

        	foreach ($user_hotels as $hotel) {

          		$hotels[] = $hotel['id'];

        	}  

        	$this->data['hotel'] = $this->hotels_model->get_by_id(10);

        	$this->data['forms'] = $this->forms_model->view_wat('', '10');

        	foreach ($this->data['forms'] as $key => $form) {

          		$this->data['forms'][$key]['items'] = $this->items_model->get_form_items($this->data['forms'][$key]['id']);

        	} 

        	$hotels = array();

        	foreach ($this->data['forms'] as $form) {

        		$hotels[] = $form['from_hotel_id'];

        	}

        	$hotel_from = array_count_values($hotels);

        	$hotels1 = array();

        	foreach ($this->data['forms'] as $form) {

        		$hotels1[] = $form['to_hotel_id'];

        	}

        	$hotel_to = array_count_values($hotels1);

        	//die(print_r($hotel_to));

        	$this->data['hotels'] = $user_hotels;

        	$this->load->view('forms_chairman', $this->data);

      	}

    }

	

	public function index() {

		if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {

	      redirect('/unknown');

	    }else{

			$this->load->model('forms_model');

			$this->load->model('hotels_model');

			$this->data['forms'] = $this->forms_model->getall(0);

			$this->data['hotels'] = $this->hotels_model->getall();

			$this->data['submenu']['active'] = "active";



			$this->load->view('forms', $this->data);

		}

	}





	public function confirmed() {

		if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {

	      redirect('/unknown');

	    }else{

			$this->load->model('forms_model');

			$this->load->model('hotels_model');

			$this->data['forms'] = $this->forms_model->getall(5);

			$this->data['hotels'] = $this->hotels_model->getall();

			$this->data['submenu']['active'] = "completed";



			$this->load->view('forms', $this->data);

		}

	}



	// public function filter($state) {



	// 	$this->load->model('forms_model');

	// 	$this->data['forms'] = $this->forms_model->getall($state);

	// 	$this->load->view('forms', $this->data);

	// }



	private function send_mails($form_id, $users) {

		$this->load->library('email');

		$this->load->helper('url');



		$form_url = base_url().'forms/view/'.$form_id;

		

		$this->email->from('e-signature@sunrise-resorts.com');

		$this->email->to($users);



		$this->email->subject("Assets movement form #{$form_id}");

		$this->email->message("Dear Sir,<br/>

							<br/>

							Please Click the link below of Movement assets N: #{$form_id} to view and sign the form:<br/>

							<a href='{$form_url}' target='_blank'>{$form_url}</a><br/>



							");	



		$mail_result = $this->email->send();



		$mail_report = implode(' ', $users);



		$this->data['message']['body'] = "{$mail_report}";

		//$this->data['debug']['mail_result'] = $mail_result;



	}



	private function mailing($form_id, $users) {

		$this->data['message'] = array('type' => "info", 'head' => implode(',', $users));

		$this->get_mailing_list($form_id);

		$final_mail_list_ids = array();

		foreach ($users as $user) {

			foreach ($this->mail_list[$user] as $mail_user_id) {

				$final_mail_list_ids[] = $mail_user_id;

			}

		}



		if (!$final_mail_list_ids) {

			$final_mail_list_ids[] = 83;//user not found email fallback allert!

		}

		$this->load->model('users_model');



		$final_mail_list = $this->users_model->get_emails($final_mail_list_ids);


		$final_mails = array();

		foreach ($final_mail_list as $mail_list) {

			$final_mail[] = $mail_list['email'];

		}



		$this->send_mails($form_id, $final_mail);

		//$this->data['debug']['final_mail'] = $final_mail;

	}



	public function form_state($id) {



		$this->load->model('forms_model');

		$this->data['form'] = $this->forms_model->getform($id);



		if ($this->data['form']['dstn_dpt_head_id']) {



			if ($this->data['form']['dstn_hotel_fc_id']) {



				if ($this->data['form']['dstn_hotel_gm_id']) {



					if ($this->data['form']['src_dpt_head_id']) {



						if ($this->data['form']['src_hotel_fc_id']) {



							if ($this->data['form']['src_hotel_gm_id']) {



								if ($this->data['form']['fin_cluster_fc_id']) {

                           

									if ($this->data['form']['fin_rdof_id']) {



										if ($this->data['form']['fin_chrmn_cai_id']) {



											if ($this->data['form']['rcv_user_id']) {

												$this->forms_model->update_state($id, 7);

												redirect('/forms/view/'.$id);

											}

											$this->forms_model->update_state($id, 5);



											redirect('/forms/view/'.$id);

										}

										$this->mailing($id, array('fin_chrmn_cai'));

										redirect('/forms/view/'.$id);

									}

									$this->mailing($id, array('fin_rdof'));

									redirect('/forms/view/'.$id);

								}

								$this->mailing($id, array('fin_cluster_fc'));

								$this->forms_model->update_state($id, 4);

								redirect('/forms/view/'.$id);

							}

							$this->mailing($id, array('src_hotel_gm'));

							redirect('/forms/view/'.$id);

						}

						$this->mailing($id, array('src_hotel_fc'));

						redirect('/forms/view/'.$id);

					}

					$this->mailing($id, array('src_dpt_head'));

					$this->forms_model->update_state($id, 3);

					redirect('/forms/view/'.$id);

				}

				$this->mailing($id, array('dstn_hotel_gm'));

				redirect('/forms/view/'.$id);

			}

			$this->mailing($id, array('dstn_hotel_fc'));

			$this->forms_model->update_state($id, 2);

			redirect('/forms/view/'.$id);

		} elseif ($this->data['form']['form_state_id'] == 0) {

			$this->mailing($id, array('dstn_dpt_head'));

			$this->forms_model->update_state($id, 1);

			redirect('/forms/view/'.$id);

		}

		redirect('/forms/view/'.$id);

	}

	

	public function view($id) {

		if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {

	      redirect('/unknown');

	    }else{

			$this->load->model('forms_model');

			$this->load->model('items_model');

			$this->data['form'] = $this->forms_model->getform($id);

			$this->data['from_owning'] = $this->forms_model->get_from_owning($id);
			$this->data['to_owning'] = $this->forms_model->get_to_owning($id);
			//die(print_r($this->data['form'])." ".print_r($this->data['to_owning']));
 
			if ($this->data['user_id'] == 253) {

				$this->data['hany'] = TRUE;

			}else{

				$this->data['hany'] = False;

			}

			$this->data['items'] = $this->items_model->get_form_items($id);
// die(print_r($this->data['items']));
			//$this->data['deliverd_items'] = $this->items_model->get_form_item_deliver($id);

			 //$i = 0;

			//die(print_r($this->data['items']));

	        foreach ($this->data['items'] as $key => $item) {

	          $this->data['items'][$key]['deliverd_items'] =   $this->items_model->get_form_item_deliver($this->data['items'][$key]['id']);

	        }

			//die(print_r($this->data['items']));

        	$this->data['comments'] = $this->forms_model->get_comment($id);



			$this->data['signature_path'] = '/assets/uploads/signatures/';



			$this->signers = $this->get_signers($id);



			$this->data['user_signs'] = $this->filter_signers($this->signers, $this->data['user_id']);

			$this->data['form_id'] = $id;



			

			$this->load->view('form_view', $this->data);

		}

	}



	public function owningcompany($id) {

		if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {

	      redirect('/unknown');

	    }else{

			$this->load->model('forms_model');

			$this->load->model('items_model');

			$this->data['form'] = $this->forms_model->get_owning_form($id);

			$this->data['items'] = $this->items_model->get_form_items($id);



			$this->load->model('comments_model');

			$this->data['comments'] = $this->comments_model->get_form_comments($id);



			$this->data['signature_path'] = '/assets/uploads/signatures/';



			// $this->form_state($id);



			$this->signers = $this->get_owning_signers($id);



			$this->data['user_signs'] = $this->filter_signers($this->signers, $this->data['user_id']);



			

			$this->load->view('form_secret', $this->data);

		}

	}

public function owningcompany_holidays($id) {

			$this->load->model('forms_model');

			$this->load->model('items_model');

			$this->data['form'] = $this->forms_model->get_owning_form_holidays($id);

			$this->data['items'] = $this->items_model->get_form_items($id);



			$this->load->model('comments_model');


			$this->data['signature_path'] = '/assets/uploads/signatures/';



			// $this->form_state($id);



			$this->signers = $this->get_owning_signers_holidays($id);


			$this->data['user_signs'] = $this->filter_signers($this->signers, $this->data['user_id']);

			

			$this->load->view('form_holidays', $this->data);


	}



	public function coder($id) {

    	$this->load->model('items_model');

	    $it = $this->items_model->get_items($id);

    	if ($this->input->post('submit')) {

      		$this->load->library('form_validation');

      		if ($this->form_validation->run() == False) {

        		foreach ($this->input->post('items') as $item) {

	      			$this->items_model->update_item($item,  $item['form_id'], $item['id']);

	    		}

      		}

    		redirect('/forms/financialowning/'.$it['form_id']);

    	}

	    //die(print_r($item ));

  	}



	public function financialowning($id) {

		if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {

	      redirect('/unknown');

	    }else{

			$this->load->model('forms_model');

			$this->load->model('items_model');

			$this->data['form'] = $this->forms_model->get_owning_form($id);

			$this->data['items'] = $this->items_model->get_form_items($id);

			foreach ($this->data['items'] as $item) {

				if ($item['code'] != null) {

					$this->data['xd'] = 0;

				}else{

					$this->data['xd'] = 1;

				}

			}

			$this->load->model('comments_model');

			$this->data['comments'] = $this->comments_model->get_form_comments($id);



			$this->data['signature_path'] = '/assets/uploads/signatures/';



			// $this->form_state($id);



			$this->signers = $this->get_hany_signers($id);

			//die(print_r($this->signers));

			$this->data['user_signs'] = $this->filter_signers($this->signers, $this->data['user_id']);



			

			$this->load->view('form_secret2', $this->data);

		}

	}



	private function get_signers($form_id) {

		return array(
///crazy water----------------------
                    'src_amen_m5zn' => $this->forms_model->get_src_amen_m5zn($form_id),
                    'src_msaol_m5zn' => $this->forms_model->get_src_msaol_m5zn($form_id),
                    'src_pro' => $this->forms_model->get_src_pro($form_id),
                    'fin_rgm' => $this->forms_model->get_fin_rgm($form_id),  
//-----------------------
					'src_dpt_head' => $this->forms_model->get_src_dpt_head($form_id),

					'src_hotel_gm' => $this->forms_model->get_src_hotel_gm($form_id),

					'src_hotel_fc' => $this->forms_model->get_src_hotel_fc($form_id),

					'dstn_dpt_head' => $this->forms_model->get_dstn_dpt_head($form_id),

					'dstn_hotel_gm' => $this->forms_model->get_dstn_hotel_gm($form_id),

					'dstn_hotel_fc' => $this->forms_model->get_dstn_hotel_fc($form_id),

					'fin_cluster_fc' => $this->forms_model->get_fin_cluster_fc($form_id),

					'fin_rdof' => $this->forms_model->get_fin_rdof($form_id),

					'fin_chrmn_cai' => $this->forms_model->get_fin_chrmn_cai($form_id),

					'fin_chairman' => $this->forms_model->get_fin_chairman($form_id),

					// 'rcv_hotel_acc' => $this->forms_model->get_rcv_hotel_acc($form_id),

					// 'rcv_dpt_head' => $this->forms_model->get_rcv_dpt_head($form_id),

					// 'rcv_chrmn_cai' => $this->forms_model->get_rcv_chrmn_cai($form_id),

					'rcv_user' => $this->forms_model->get_rcv_user($form_id)



			);

	}



	private function get_owning_signers($form_id) {

		return array(

					'pur_sec_mgr' => $this->forms_model->get_pur_sec_mgr($form_id),

					// 'tech_mgr' => $this->forms_model->get_tech_mgr($form_id),

					'pur_dpt_mgr' => $this->forms_model->get_pur_dpt_mgr($form_id),

					'acc_mgr' => $this->forms_model->get_acc_mgr($form_id),

					'inv_dpt_mgr' => $this->forms_model->get_inv_dpt_mgr($form_id),

					'con_acc_mgr' => $this->forms_model->get_con_acc_mgr($form_id),

					'cpo' => $this->forms_model->get_cpo($form_id),

					'hany' =>$this->forms_model->get_hany(253)

			);

	}

    private function get_owning_signers_holidays($form_id) {

		return array(

					'atef' => $this->forms_model->get_atef($form_id),

					'sayed' => $this->forms_model->get_sayed($form_id),

					'hesham' => $this->forms_model->get_hesham($form_id),					

			);

	}


	private function get_hany_signers($form_id) {

		return array(

					'hany' =>$this->forms_model->get_hany(253)

			);

	}



	private function get_form_users($id) {

		return $this->forms_model->get_users($id);

	}



	private function get_mailing_list($id) {

		$this->load->model('forms_model');



		$signers = $this->get_signers($id);

		$form_users = $this->get_form_users($id);



		$mailing_list = array();



		foreach ($form_users as $pos => $user_id) {

			if ($user_id > 0) {

				$mailing_list[$pos][] = $user_id;

			} elseif (array_key_exists($pos, $signers)) {

				foreach ($signers[$pos] as $value) {

					$mailing_list[$pos][] = $value['id'];

				}

			}

			

		}



		$this->mail_list = $mailing_list;

		//$this->data['debug']['mailing_list'] = $mailing_list;

	}



	private function filter_signers($signers, $user_id) {

		$filtered = array();

		foreach ($signers as $pos => $pos_signers) {

			foreach ($pos_signers as $signer) {

				if ($signer['id'] == $user_id) {

					$filtered[$pos] = $user_id;

				}

			}

		}

		return $filtered;

	}



	public function sign($form_id, $signer,$rdof=False) {

		$this->load->model('forms_model');



		$signers = $this->get_signers($form_id);



		$signs_available = $this->filter_signers($signers, $this->data['user_id']);



		if (array_key_exists($signer, $signs_available)) {
            if($rdof==2){
	           	$message_id = $this->forms_model->get_message_id($form_id);

	           	$form_url = base_url().'forms/view/'.$form_id;
	           	$message = "Assets movement form NO: ({$form_id}):
				{$form_url}";
				$this->deletonclick($message_id['message_id']);
           		$this->onclick1($message);
				$this->forms_model->update_sign($form_id, $signer, $this->data['user_id']);
           }
           $this->forms_model->update_sign($form_id, $signer, $this->data['user_id']);
		}

		redirect('/forms/form_state/'.$form_id);

	}
     
 	function onclick($message, $id, $channelss){
		include(APPPATH . 'third_party/RocketChat/autoload.php');
		$client = new RocketChat\Client($this->config->item('send_url'));
		$token = $client->api('user')->login($this->config->item('user_access'),$this->config->item('pass_access'));
		$client->setToken($token);
		$channel_result = $client->api('channel')->sendMessage($channelss,$message);
		$this->load->model('forms_model');
		$this->forms_model->update_message_id($id, $channel_result);
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


	public function sign_owning($form_id, $signer,$khaled=False) {

		$this->load->model('forms_model');



		$signers = $this->get_owning_signers($form_id);



		$signs_available = $this->filter_signers($signers, $this->data['user_id']);



		if (array_key_exists($signer, $signs_available)) {
			 if($khaled==1){
	           	$user = $this->forms_model->get_fin_chairman($form_id);
	           	$form_url = base_url().'forms/view/'.$form_id;
	       	foreach ($user as $use) {
	            }
	            $message = "Assets movement form NO: ({$form_id}):
					{$form_url}";
	            $this->onclick($message, $form_id, $use['channel']);
	            $this->forms_model->update_sign($form_id, $signer, $this->data['user_id']);
           }

			$this->forms_model->update_sign($form_id, $signer, $this->data['user_id']);

		}

		redirect('/forms/owningcompany/'.$form_id);

	}

		public function sign_owning_holidays($form_id, $signer) {

		$this->load->model('forms_model');

		$signers = $this->get_owning_signers_holidays($form_id);

		$signs_available = $this->filter_signers($signers, $this->data['user_id']);

		if (array_key_exists($signer, $signs_available)) {

			$this->forms_model->update_sign($form_id, $signer, $this->data['user_id']);

		}

		redirect('/forms/owningcompany_holidays/'.$form_id);

	}




	public function sign_financi($form_id, $signer) {

		$this->load->model('forms_model');



		$signers = $this->get_owning_signers($form_id);



		$signs_available = $this->filter_signers($signers, $this->data['user_id']);



		if (array_key_exists($signer, $signs_available)) {

			$this->forms_model->update_sign($form_id, $signer, $this->data['user_id']);

		}

		redirect('/forms/financialowning/'.$form_id);

	}



	public function comment($form_id) {

		if ($this->input->post('submit')) {

			$this->load->library('form_validation');

			$this->form_validation->set_rules('comment','Comment','trim|required');



			if ($this->form_validation->run() == TRUE) {

	    		$this->load->model('comments_model');



	    		$comment_data = array(

	    							'user_id' => $this->data['user_id'],

	    							'form_id' => $form_id,

	    							'comment' => $this->input->post('comment')

	    							);

	    		$comment_id = $this->comments_model->create($comment_data);

	    		if (!$comment_id) {

	    			die("ERROR");//@TODO failure view

	    		}

	    		if ($this->data['role_id'] == 217) {

	    			$this->chairman_mail($form_id);

	    		}

	    	}

		}

		redirect('/forms/owningcompany/'.$form_id);

	}



	private function chairman_mail($form_id) {

      $this->load->library('email');

      $this->load->helper('url');

      $form_url = base_url().'forms/view/'.$form_id;

      $this->email->from('e-signature@sunrise-resorts.com');

      $this->email->to('abeer@sunrise.eg');

      $this->email->subject("Assets movement form No. #{$form_id}");

      $this->email->message("Dear Madam Abber,

        <br/>

        <br/>

        Mr Hossam Commented on Assets movement form No. #{$form_id}, Please use the link below:

        <br/>

        <a href='{$form_url}' target='_blank'>{$form_url}</a>

        <br/>

      "); 

      $mail_result = $this->email->send();

    }

		

	public function submit() {

		if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {

	      redirect('/unknown');

	    }else{

			if ($this->input->post('submit')) {



				$this->load->library('form_validation');



				$this->form_validation->set_rules('from-hotel','From hotel','trim|required');

				$this->form_validation->set_rules('to-hotel','To hotel','trim|required');

		    	$this->form_validation->set_rules('issue-date','Issue date','trim|required');

		    	$this->form_validation->set_rules('delivery-date','Delivery date','trim|required');

		    	$this->form_validation->set_rules('request-department','Request Department','trim|required');

		    	$this->form_validation->set_rules('items','Items','required');

		    	$this->form_validation->set_rules('present-location','Present location','trim|required');

		    	$this->form_validation->set_rules('movement-reason','Movement reason','trim|required');

		    	$this->form_validation->set_rules('old-reason','Old Movement','trim|required');

		    	$this->form_validation->set_rules('new-location','New location','trim|required');



		    	if ($this->form_validation->run() == TRUE) {

		    		$this->load->model('forms_model');

		    		$this->load->model('items_model');



		    		$form_data = array(

		    							'user_id' => $this->data['user_id'],

		    							'from_hotel_id' => $this->input->post('from-hotel'),

		    							'from_hotel_owning' => $this->input->post('from_hotel_owning'),

		    							'to_hotel_id' => $this->input->post('to-hotel'),

		    							'to_hotel_owning' => $this->input->post('to_hotel_owning'),

		    							'issue_date' => $this->input->post('issue-date'),

		    							'delivery_date' => $this->input->post('delivery-date'),

		    							'department_id' => $this->input->post('request-department'),

		    							'location' => $this->input->post('present-location'),

		    							'movement_reason' => $this->input->post('movement-reason'),

		    							'old_reason' => $this->input->post('old-reason'),

		    							'destination' => $this->input->post('new-location'),

		    							'state_id' => 0

		    							);

		    		$form_id = $this->forms_model->create($form_data);

		    		if (!$form_id) {

		    			die("ERROR");//@TODO failure view

		    		}elseif($form_id && $form_data['from_hotel_id']==50){
                       $this->load->model('users_model');
                       $said_atiek=$this->users_model->get_user_by_id(30,1);
                        $this->send_mails($form_id,$said_atiek->email);

		    		}


		    		foreach ($this->input->post('items') as $item) {

		    			$item['form_id'] = $form_id;

		    			$item_id = $this->items_model->create($item);

		    			if (!$form_id) {

			    			die("ERROR");//@TODO failure view

			    		}

		    		}

		    		redirect('/forms/form_state/'.$form_id);

		    	}

			}



			try {



				$this->load->helper('form');

				$this->load->model('hotels_model');

				$this->load->model('companies_model');

				$this->load->model('departments_model');

				$this->load->model('roles_model');


				

				$this->data['hotels'] = $this->hotels_model->getall();

				$this->data['companies'] = $this->companies_model->getall();

				$this->data['departments'] = $this->departments_model->getall();

				$this->data['roles'] = $this->hotels_model->getall();



				$this->load->view('form_submit',$this->data);

			}

			catch( Exception $e) {

				show_error($e->getMessage()." _ ". $e->getTraceAsString());

			}

		}

	}



	public function commen_formt($form_id){

      if ($this->input->post('submit')) {

        $this->load->library('form_validation');

        $this->form_validation->set_rules('comment','Comment','trim|required');

        if ($this->form_validation->run() == TRUE) {

          $comment = $this->input->post('comment'); 

          $this->load->model('forms_model');

          $comment_data = array(

            'user_id' => $this->data['user_id'],

            'form_id' => $form_id,

            'comment' => $comment

          );

          $this->forms_model->insert_comment($comment_data);

          if ($this->data['role_id'] == 217) {

	    	$this->chairman_mail($form_id);

	   	  }

        }

        redirect('/forms/view/'.$form_id);

      }

    }

  public function delivery($form_id,$item_id,$del=""){



    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {

	      redirect('/unknown');

      }else{

        if ($this->input->post('submit')) {

        	$this->load->model('items_model');

            $this->load->model('users_model'); 

            if(!$del){

                $data=array(

                  'user_id'               =>$this->data['user_id'],

                  'form_id'               =>$form_id,

                  'item_id'               =>$item_id,

                  'reason'                =>$this->input->post('reason'),

                  'delivery'              =>'0'

               );

             $this->items_model->add_delivered($data,$form_id,$item_id);

             redirect('/forms/view/'.$form_id);

            }else{ 

             $data=array(

                  'deliver_user_id'               =>$this->data['user_id'],

                  'delivery'               =>'1'

               );

            $this->items_model->update_item($data,$form_id,$item_id);

            redirect('/forms/view/'.$form_id);

         }

        }

      } 

     }

    public function del_delivery($id,$form_id ){

      $this->load->model('items_model');

      $this->db->delete('form_item_deliver', array('id' => $id));

      // $out_go_chdates = $this->out_go_model->get_changed_dates($out_id);

      // if(!$out_go_chdates){

      //   $this->out_go_model->update_change_re_date($out_id,0);

      // }

      redirect('/forms/view/'.$form_id);

    } 

}