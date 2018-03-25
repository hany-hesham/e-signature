<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class spo extends CI_Controller {

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
		$this->data['module_forms'] = array('0' => 2);;
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

	public function index() {
		if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
			redirect('/unknown');
		}else{
			$this->load->model('hotels_model');
			$this->load->model('spo_model');
			$user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
			$hotels = array();
			foreach ($user_hotels as $hotel) {
				$hotels[] = $hotel['id'];
			}
			$this->load->model('spo_item_model');
			$this->load->model('spo_competition_model');
			
			$this->data['spo_contents'] = $this->spo_model->view_spo($hotels);
			foreach ($this->data['spo_contents'] as $key => $spo) {
			$this->data['spo_contents'][$key]['approvals'] = $this->get_spo_signers($this->data['spo_contents'][$key]['id'], $this->data['spo_contents'][$key]['hotel_id']);
			}

			$this->data['hotels'] = $this->hotels_model->getall();
			$user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);

			$this->load->view('spo_list', $this->data);
	    }
	}

	public function index_app() {
		if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
			redirect('/unknown');
		}else{
			$this->load->model('hotels_model');
			$this->load->model('spo_model');
			$user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
			$hotels = array();
			foreach ($user_hotels as $hotel) {
				$hotels[] = $hotel['id'];
			}
			$this->load->model('spo_item_model');
			$this->load->model('spo_competition_model');
			
			$this->data['spo_contents'] = $this->spo_model->view_spo($hotels);
			foreach ($this->data['spo_contents'] as $key => $spo) {
			$this->data['spo_contents'][$key]['approvals'] = $this->get_spo_signers($this->data['spo_contents'][$key]['id'], $this->data['spo_contents'][$key]['hotel_id']);
			}

			$this->data['hotels'] = $this->hotels_model->getall();
			$user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);

			$this->load->view('spo_list_app', $this->data);
		
	    }
	}

	public function index_wat() {
		if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
			redirect('/unknown');
		}else{
			if ($this->input->post('submit')) {
		      $this->data['state'] = $this->input->post('state');
		    }
			$this->load->model('hotels_model');
			$this->load->model('spo_model');
			$user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
			$hotels = array();
			foreach ($user_hotels as $hotel) {
				$hotels[] = $hotel['id'];
			}
			$this->load->model('spo_item_model');
			$this->load->model('spo_competition_model');
			
			$this->data['spo_contents'] = $this->spo_model->view_spo($hotels);
			foreach ($this->data['spo_contents'] as $key => $spo) {
			$this->data['spo_contents'][$key]['approvals'] = $this->get_spo_signers($this->data['spo_contents'][$key]['id'], $this->data['spo_contents'][$key]['hotel_id']);
			}

			$this->data['hotels'] = $this->hotels_model->getall();
			$user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);

			$this->load->view('spo_list_wat', $this->data);
	    }
	}

	public function index_rej() {
		if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
			redirect('/unknown');
		}else{
			$this->load->model('hotels_model');
			$this->load->model('spo_model');
			$user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
			$hotels = array();
			foreach ($user_hotels as $hotel) {
				$hotels[] = $hotel['id'];
			}
			$this->load->model('spo_item_model');
			$this->load->model('spo_competition_model');
			
			$this->data['spo_contents'] = $this->spo_model->view_spo($hotels);
			foreach ($this->data['spo_contents'] as $key => $spo) {
			$this->data['spo_contents'][$key]['approvals'] = $this->get_spo_signers($this->data['spo_contents'][$key]['id'], $this->data['spo_contents'][$key]['hotel_id']);
			}

			$this->data['hotels'] = $this->hotels_model->getall();
			$user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);

			$this->load->view('spo_list_rej', $this->data);
	    }
	}

	public function submit() {
		if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        	redirect('/unknown');
      	}else{
        	if ($this->input->post('submit')) {
          		$this->load->library('form_validation');
          		$this->load->library('email');
          		$this->form_validation->set_rules('hotel_id','Hotel Name','trim|required');
          		$assumed_id = $this->input->post('assumed_id');                        
				if ($this->form_validation->run() == TRUE) {
					$this->load->model('spo_model');
					$this->load->model('spo_item_model');
					$this->load->model('spo_Competition_model');	
	 				$this->load->model('users_model');	
					$form_data = array(
              			'ip' => $this->input->ip_address(),
						'user_id' => $this->data['user_id'],
						'hotel_id' => $this->input->post('hotel_id'),
						'season' => $this->input->post('season'),
						'Travel_Date' => $this->input->post('Travel_Date'),
						'Travel_Date2' => $this->input->post('Travel_Date2'),
						'Booking_Window' => $this->input->post('Booking_Window'),
						'Booking_Window2' => $this->input->post('Booking_Window2'),
						'arrival_date' => $this->input->post('arrival_date'),
						'arrival_date2' => $this->input->post('arrival_date2'),
						'arrival_date3' => $this->input->post('arrival_date3'),
						'arrival_date4' => $this->input->post('arrival_date4'),
						'arrival_date5' => $this->input->post('arrival_date5'),
						'to' => $this->input->post('to')
					);
					//die(print_r($form_data));
					$spo_id = $this->spo_model->create_spo($form_data);
					if ($spo_id) {
              			$this->spo_model->update_files($assumed_id,$spo_id);
            		} else {
              			die("ERROR");
            		}
					$resulte =  array();
					foreach ($this->input->post('items') as $item) {
	    				$item['spo_id'] = $spo_id;
	    				$item['user_id'] = $this->data['user_id'];
	    				$item['ip'] = $this->input->ip_address();
	    				$item['spo'] = ((1 - ($item['Discount_percentage'] / 100)) * $item['Contracted_prices']);
	    				//$item['Discount_percentage'] = number_format(100 - (($item['spo'])/($item['Contracted_prices']) * 100 ), 0 );
	    				$resulte[] = $item['Discount_percentage'];
	    				$item_id = $this->spo_item_model->create_item($item);	   
	    				if (!$item_id) {
		    				die("ERROR");
		    			}
	    			}
	    			foreach ($this->input->post('competition') as $competition) {
	    				$competition['spo_id'] = $spo_id;
	    				$competition['user_id'] = $this->data['user_id'];
	    				$competition['ip'] = $this->input->ip_address();	
						$competition_id = $this->spo_Competition_model->create_competition($competition);	   
	    				if (!$competition_id) {
		    				die("ERROR");
		    			}
	    			}
	    			$hotel_id = $form_data['hotel_id'];
	    			$percentage = max($resulte);
	    			//die(print_r($percentage));
	    			if (( $hotel_id !=3 and $hotel_id !=7 and  $hotel_id !=8 ) and ( $percentage >= 0 and  $percentage <= 15)) {
				    	$spo_type = 1;
				    }elseif (( $hotel_id !=3 and $hotel_id !=7 and  $hotel_id !=8 ) and ( $percentage >= 16 and  $percentage <= 30)) {
			            $spo_type = 2;            
				    }elseif (( $hotel_id !=3 and $hotel_id !=7 and  $hotel_id !=8 ) and $percentage >= 31) {
				        $spo_type = 3;
				    }elseif (( $hotel_id ==3 or $hotel_id ==7 or  $hotel_id ==8 ) and ( $percentage >= 0 and  $percentage <= 15)) {
				        $spo_type = 4;           
			        }elseif (( $hotel_id ==3 or $hotel_id ==7 or  $hotel_id ==8 ) and ( $percentage >= 16 and  $percentage <= 40)) {
			            $spo_type = 5;            
		            }elseif (( $hotel_id ==3 or $hotel_id ==7 or  $hotel_id ==8 ) and $percentage >= 41) {
			            $spo_type = 6;
				    }		
				    $signatures = $this->spo_model->sposign($spo_type);
				    $do_sign = $this->spo_model->spo_do_sign($spo_id);
		            //die(print_r($do_sign));
		            if ($do_sign == 0) {
		   				foreach ($signatures as $spo_signature) {
		   					$this->spo_model->add_spo_signature($spo_id, $spo_signature['role'], $spo_signature['rank']);
		   				}
	   					$this->spo_model->add_spo_signature($spo_id, 0, 0);		
		   			}
	  				redirect('/spo/spo_stage/'.$spo_id);
	  			}	  
	  		}	
		    try {
				$this->load->helper('form');
				$this->load->model('spo_model');
				$this->load->model('spo_item_model');
				$this->load->model('spo_Competition_model');
				$this->load->model('hotels_model');
				$this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());
				if ($this->input->post('submit')) {
            		$this->data['assumed_id'] = $this->input->post('assumed_id');
            		$this->data['uploads'] = $this->spo_model->get_by_fille($this->data['assumed_id']);
          		} else {
            		$this->data['assumed_id'] = strtoupper(str_pad(dechex( mt_rand( 1048575, 10485751048575 ) ), 5, '0', STR_PAD_LEFT));
            		$this->data['uploads'] = array();
          		}
				$this->load->view('spo_add_new',$this->data);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
	    }
	}

	public function upload($spo_id) {
      $file_name = $this->do_upload("upload");
      if (!$file_name) {
        die(json_encode($this->data['error']));
      } else {
        $this->load->model("spo_model");
        $this->spo_model->add_fille($spo_id, $file_name, $this->data['user_id']);
        die("{}");
      }
    }

    public function remove($spo_id, $id) {
      $file_name = $_POST['key'];
      if (!$id) {
        die(json_encode($this->data['error']));
      } else {
        $this->load->model("spo_model");
        $this->spo_model->remove_fille($id);
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


	public function view($spo_id) {
		if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
			redirect('/unknown');
		}else{
			$this->load->model('spo_model');
			$this->load->model('spo_item_model');
			$this->load->model('spo_Competition_model');
			$this->load->model('hotels_model');		
			$this->data['hotels'] = $this->hotels_model->getall();
            $this->data['uploads'] = $this->spo_model->get_by_fille($spo_id);
	 		$this->data['spo_contents'] = $this->spo_model->get_spo_content($spo_id);
			$this->data['get_spo_items'] = $this->spo_item_model->get_spo_items($spo_id);
			$this->data['get_spo_Competition'] = $this->spo_Competition_model->get_spo_Competition($spo_id);
			$this->data['signature_path'] = '/assets/uploads/signatures/';
			$this->data['signers'] = $this->get_spo_signers($this->data['spo_contents']['id'], $this->data['spo_contents']['hotel_id']);
			$this->data['GetComment'] = $this->spo_model->GetComment($spo_id);
			

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
			if (isset($this->data['user_id'])) {

	      if ( $this->data['spo_contents']['user_id'] == $this->data['user_id'] &&  $this->data['spo_contents']['state_id'] == 1) {
	        $editor = TRUE;
	      }
	    }


			$this->data['unsign_enable'] = (($unsign_enable) || $this->data['is_admin'])? TRUE : FALSE;
			$this->data['is_editor'] = ( (($this->data['unsign_enable'] || $editor)) || ($force_edit) )? TRUE : FALSE;
			$user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);

	    	$this->data['id'] = $spo_id;
		 	$this->load->view('spo_view', $this->data);
	    }
	}



	public function edit($spo_id) {
		if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
			redirect('/unknown');
		}else{
			if ($this->input->post('submit')) {
				$this->load->library('form_validation');
				$this->load->library('email');
          		$this->form_validation->set_rules('hotel_id','Hotel Name','trim|required');
				if ($this->form_validation->run() == TRUE) {
					$this->load->model('spo_model');
					$this->load->model('spo_item_model');
					$this->load->model('spo_Competition_model');	
	 				$this->load->model('users_model');	
					$form_data = array(
						'season' => $this->input->post('season'),
						'Travel_Date' => $this->input->post('Travel_Date'),
						'Travel_Date2' => $this->input->post('Travel_Date2'),
						'Booking_Window' => $this->input->post('Booking_Window'),
						'Booking_Window2' => $this->input->post('Booking_Window2'),
						'arrival_date' => $this->input->post('arrival_date'),
						'arrival_date2' => $this->input->post('arrival_date2'),
						'arrival_date3' => $this->input->post('arrival_date3'),
						'arrival_date4' => $this->input->post('arrival_date4'),
						'arrival_date5' => $this->input->post('arrival_date5'),
						'to' => $this->input->post('to'),
						'hotel_id' => $this->input->post('hotel_id')
					);
					
					$this->spo_model->update_spo($form_data, $spo_id);
					$resulte =  array();
					foreach ($this->input->post('items') as $item) {
	    				$item['spo_id'] = $spo_id;	
	    				$item['user_id'] = $this->data['user_id'];
	    				$item['ip'] = $this->input->ip_address();
	    				$item['spo'] = ((1 - ($item['Discount_percentage'] / 100)) * $item['Contracted_prices']);
	    				//$item['Discount_percentage'] = number_format(100 - (($item['spo'])/($item['Contracted_prices']) * 100 ), 0 );
	    				$resulte[] = $item['Discount_percentage'];
	    				//die(print_r($this->input->post('items')));
	    				$this->spo_item_model->update_item($item, $spo_id, $item['id']);
	    			}
	    			foreach ($this->input->post('competitions') as $competition) {
	    				$competition['spo_id'] = $spo_id;
	    				$competition['user_id'] = $this->data['user_id'];
	    				$competition['ip'] = $this->input->ip_address();	
	    				//die(print_r($competition));	   
						$this->spo_Competition_model->update_competition($competition, $spo_id, $competition['id']);
	    			}
		    		$hotel_id = $form_data['hotel_id'];
		    		$percentage = max($resulte);
		    		//die(print_r($percentage));
	    			if (( $hotel_id !=3 and $hotel_id !=7 and  $hotel_id !=8 ) and ( $percentage >= 0 and  $percentage <= 15)) {
				    	$spo_type = 1;
				    }elseif (( $hotel_id !=3 and $hotel_id !=7 and  $hotel_id !=8 ) and ( $percentage >= 16 and  $percentage <= 30)) {
			            $spo_type = 2;            
				    }elseif (( $hotel_id !=3 and $hotel_id !=7 and  $hotel_id !=8 ) and $percentage >= 31) {
				        $spo_type = 3;
				    }elseif (( $hotel_id ==3 or $hotel_id ==7 or  $hotel_id ==8 ) and ( $percentage >= 0 and  $percentage <= 15)) {
				        $spo_type = 4;           
			        }elseif (( $hotel_id ==3 or $hotel_id ==7 or  $hotel_id ==8 ) and ( $percentage >= 16 and  $percentage <= 40)) {
			            $spo_type = 5;            
		            }elseif (( $hotel_id ==3 or $hotel_id ==7 or  $hotel_id ==8 ) and $percentage >= 41) {
			            $spo_type = 6;
				    }		
				    $this->spo_model->spo_reset_sign($spo_id);
	  				$signatures = $this->spo_model->sposign($spo_type);
				    $do_sign = $this->spo_model->spo_do_sign($spo_id);
		            //die(print_r($do_sign));
		            if ($do_sign == 0) {
		   				foreach ($signatures as $spo_signature) {
		   					$this->spo_model->add_spo_signature($spo_id, $spo_signature['role'], $spo_signature['rank']);
		   				}
	   					$this->spo_model->add_spo_signature($spo_id, 0, 0);	
	   					$this->self_sign($spo_id);	
		   			}
	  				redirect('/spo/spo_stage/'.$spo_id);
	  		}	  
	  		}	
		    try {
				$this->load->helper('form');
				$this->load->model('spo_model');
				$this->load->model('spo_item_model');
				$this->load->model('spo_Competition_model');
				$this->load->model('hotels_model');
				$this->data['spo_contents'] = $this->spo_model->get_spo_content($spo_id);
				$this->data['get_spo_items'] = $this->spo_item_model->get_spo_items($spo_id);
				$this->data['competitions'] = $this->spo_Competition_model->get_spo_Competition($spo_id);
				$this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());
				$this->load->view('spo_edit',$this->data);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
	    }
	}

	private function get_spo_signers($spo_id, $hotel_id) {
		$this->load->model('spo_model');

		$signatures = $this->spo_model->getby_spo_verbal($spo_id);

		return $this->roll_signers($signatures, $hotel_id, $spo_id);
	}

	private function roll_signers($signatures, $hotel_id, $spo_id) {
		$this->load->model('spo_model');
		$this->load->model('spo_item_model');
		$spo_contents = $this->spo_model->get_spo_content($spo_id);
		$get_spo_items = $this->spo_item_model->get_spo_items($spo_id);
		$rowcount = $this->spo_model->get_count($spo_id);
		$resulte =  array();
		foreach ($get_spo_items as $item) {
	    	$resulte[] = $item['Discount_percentage'];
		   }
	    $percentage = max($resulte);
		$signers = array();
    $this->load->model('users_model');
    foreach ($signatures as $signature) {
      $signers[$signature['id']] = array();
      $signers[$signature['id']]['role'] = $signature['role'];
      $signers[$signature['id']]['role_id'] = $signature['role_id'];
      if ($signature['user_id']) {
      	if ($rowcount == 4) {
        	if ($signature['rank'] == 1){
            	$this->spo_model->update_state($spo_id, 4);
          	}elseif ($signature['rank'] == 2){
            	$this->spo_model->update_state($spo_id, 5);
          	}
        }
        if ($rowcount == 5) {
        	if ($percentage <= 15){
	        	if ($signature['rank'] == 1){
	            	$this->spo_model->update_state($spo_id, 4);
	          	}elseif ($signature['rank'] == 2){
	            	$this->spo_model->update_state($spo_id, 6);
	            }elseif ($signature['rank'] == 3){
	            	$this->spo_model->update_state($spo_id, 5);
	          	}
	        }elseif($percentage > 15){
	        	if ($signature['rank'] == 1){
	            	$this->spo_model->update_state($spo_id, 4);
	          	}elseif ($signature['rank'] == 2){
	            	$this->spo_model->update_state($spo_id, 5);
	            }elseif ($signature['rank'] == 3){
	            	$this->spo_model->update_state($spo_id, 7);
	          	}
	        }
        }
        if ($rowcount == 8) {
          	if ($signature['rank'] == 1){
            	$this->spo_model->update_state($spo_id, 4);
          	}elseif ($signature['rank'] == 2){
            	$this->spo_model->update_state($spo_id, 5);
          	}elseif ($signature['rank'] == 3){
           		$this->spo_model->update_state($spo_id, 7);
          	}elseif ($signature['rank'] == 4){
            	$this->spo_model->update_state($spo_id, 8);
          	}elseif ($signature['rank'] == 5){
            	$this->spo_model->update_state($spo_id,9);
          	}elseif ($signature['rank'] == 6){
            	$this->spo_model->update_state($spo_id, 10);
          	}
        }
        $signers[$signature['id']]['sign'] = array();
        $signers[$signature['id']]['sign']['id'] = $signature['user_id'];
        if ($signature['reject'] == 1) {
          $signers[$signature['id']]['sign']['reject'] = "reject";
          $this->spo_model->update_state($spo_id, 3);
        } 
        $user = $this->users_model->get_user_by_id($signature['user_id'], TRUE);
        $signers[$signature['id']]['sign']['name'] = $user->fullname;
        $signers[$signature['id']]['sign']['mail'] = $user->email;
        $signers[$signature['id']]['sign']['channel'] = $user->channel;
        $signers[$signature['id']]['sign']['sign'] = $user->signature;
        $signers[$signature['id']]['sign']['timestamp'] = $signature['timestamp'];
      } else {
        $signers[$signature['id']]['queue'] = array();
        if ($signature['role_id'] == 20) {
          	$users = $this->users_model->getby_criteria(7, $hotel_id, 4);
          	foreach ($users as $use) {
	          $signers[$signature['id']]['queue'][$use['id']] = array();
	          $signers[$signature['id']]['queue'][$use['id']]['name'] = $use['fullname'];
	          $signers[$signature['id']]['queue'][$use['id']]['mail'] = $use['email'];
	          $signers[$signature['id']]['queue'][$use['id']]['channel'] = $use['channel'];
	        }
        } elseif ($signature['role_id'] == 1) {
          	$users[0] = $this->users_model->getby_criteria(1, $hotel_id);
          	$users[1] = $this->users_model->getby_criteria(2, $hotel_id);
          	$users[2] = $this->users_model->getby_criteria(83, $hotel_id);
          	$users[3] = $this->users_model->getby_criteria(30, $hotel_id);
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

	public function sign($signature_id, $reject = FALSE) {
		$this->load->model('spo_model');
		$signature_identity = $this->spo_model->get_signature_identity($signature_id);

		// die(print_r($signature_identity));

		$signrs = $this->get_spo_signers($signature_identity['forma_spo_id'], $signature_identity['hotel_id']);
		// die(print_r($signature_identity['spo_id'], $signature_identity['hotel_id']));

		$this->data['spo_contents'] = $this->spo_model->get_spo_content($signature_identity['forma_spo_id']);
		// $this->data['spo_contents']['hotel_id'] = $signature_identity['hotel_id'];
		$spo_url = base_url().'spo/view/'.$signature_identity['forma_spo_id'];
		$message_id = $this->data['spo_contents']['message_id'];
		$id = $signature_identity['forma_spo_id'];
		$message = "SPO form No. {$id}:
				{$spo_url}";
		if (array_key_exists($this->data['user_id'], $signrs[$signature_id]['queue'])) {
			if ($signature_identity['role_id'] == 1) {
				$this->onclick1($message);
				$this->deletonclick($message_id);
			}
			if ($reject) {
				$this->spo_model->update_final($signature_identity['forma_spo_id'], 0);
				$this->spo_model->reject($signature_id, $this->data['user_id']);
				redirect('/spo/spo_stage/'.$this->data['spo_contents']['id']);	
			} else {
				$this->spo_model->sign($signature_id, $this->data['user_id']);
				redirect('/spo/spo_stage/'.$signature_identity['forma_spo_id']);	

			}
		}
		redirect('/spo/view/'.$signature_identity['forma_spo_id']);
	}

	public function unsign($signature_id) {
		$this->load->model('spo_model');
		$signature_identity = $this->spo_model->get_signature_identity($signature_id);
		$this->spo_model->update_final($signature_identity['forma_spo_id'], $this->data['role_id']);
		$this->spo_model->unsign($signature_id);
		$this->spo_model->update_state($signature_identity['forma_spo_id'], 1);
		$spo_contents = $this->spo_model->get_spo_content($signature_identity['forma_spo_id']);
		redirect('/spo/view/'.$signature_identity['forma_spo_id']);
	}


	public function mailto($spo_id) {
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

				$spo_url = base_url().'spo/view/'.$spo_id;
				
				$this->email->from('e-signature@sunrise-resorts.com');
        		$this->email->to($email);

				$this->email->subject("A message from {$user->fullname}, SPO No.{$spo_id}");
				$this->email->message("{$user->fullname} sent you a private message regarding SPO {$spo_id}:<br/>
									{$message}<br />
									<br />

									Please use the link below to view the SPO:
									<a href='{$spo_url}' target='_blank'>{$spo_url}</a><br/>

									");	

				$mail_result = $this->email->send();

			}
		}
		redirect('spo/view/'.$spo_id);
	}

	public function Comment($spo_id){
	   	if ($this->input->post('submit')) {
			$this->load->library('form_validation');
      		$this->form_validation->set_rules('comment','Comment','trim|required');
	    	if ($this->form_validation->run() == TRUE) {
	    		$comment = $this->input->post('comment');	
	    		$this->load->model("spo_model");
	    		$comment_data = array(
	    			'user_id' => $this->data['user_id'],
	    			'spo_id' => $spo_id,
	    			'comment' => $comment
	    		);
				$this->spo_model->InsertComment($comment_data);
				if ($this->data['role_id'] == 217) {
		            $this->chairman_mail($spo_id);
		        }
			}
			redirect('/spo/view/'.$spo_id);
		}
	}

	private function chairman_mail($spo_id) {
          $this->load->library('email');
          $this->load->helper('url');
          $spo_url = base_url().'spo/view/'.$spo_id;
          $this->email->from('e-signature@sunrise-resorts.com');
          $this->email->to('abeer@sunrise.eg');
          $this->email->subject("SPO No. #{$spo_id}");
          $this->email->message("Dear Madam Abber,
            <br/>
            <br/>
            Mr Hossam Commented on SPO No. #{$spo_id}, Please use the link below:
            <br/>
            <a href='{$spo_url}' target='_blank'>{$spo_url}</a>
            <br/>
          "); 
          $mail_result = $this->email->send();
      }
	
	private function spo_signatures_mail($role, $name, $mail, $spo_id) {
		$this->load->library('email');
		$this->load->helper('url');

		$spo_url = base_url().'spo/view/'.$spo_id;
		
		$this->email->from('e-signature@sunrise-resorts.com');
		$this->email->to($mail);

		$this->email->subject("spo {$spo_id}");
		$this->email->message("Dear {$name},<br/>
							<br/>
							spo {$spo_id} requires your signature, Please use the link below:<br/>
							<a href='{$spo_url}' target='_blank'>{$spo_url}</a><br/>

							");	

		$mail_result = $this->email->send();
	}
	private function notify_spo_signers($spo_id) {
		$notified = FALSE;
		$spo_url = base_url().'spo/view/'.$spo_id;
		$message = "SPO form No. {$spo_id}:
				{$spo_url}";
		$signers = $this->get_spo_signers($spo_id, $this->data['spo_contents']['hotel_id']);
		foreach ($signers as $signer) {
			if (isset($signer['queue'])) {
				$this->spo_model->update_final($spo_id, $signer['role_id']);
				$notified = TRUE;
					foreach ($signer['queue'] as $uid => $user) {
						$this->onclick($message, $spo_id, $user['channel']);
						$this->spo_signatures_mail($signer['role'], $user['name'], $user['mail'], $spo_id);

				}
				break;
			}
		}
		return $notified;
	}

	public function spo_stage($spo_id) {

		$this->load->model('spo_model');
		$this->data['spo_contents'] = $this->spo_model->get_spo_content($spo_id);

		if ($this->data['spo_contents']['state_id'] == 0) {
			$this->self_sign($spo_id);
			$this->spo_model->update_state($spo_id, 1);
			redirect('/spo/spo_stage/'.$spo_id);
		}elseif ($this->data['spo_contents']['state_id'] == 3){
      		$user = $this->users_model->get_user_by_id($this->data['spo_contents']['user_id'], TRUE);
      		$this->reject_mail($user->fullname, $user->email, $spo_id);
		} elseif ($this->data['spo_contents']['state_id'] != 2) {
     		$queue = $this->notify_spo_signers($spo_id, $this->data['spo_contents']['hotel_id']);
    		if (!$queue) {
    			$this->spo_model->update_final($spo_id, 0);
    			$this->spo_model->update_state($spo_id, 2);
	      		$user = $this->users_model->get_user_by_id($this->data['spo_contents']['user_id'], TRUE);
	      		$this->approvel_mail($user->fullname, $user->email, $spo_id);
	      		redirect('/spo/spo_stage/'.$spo_id);
	      	}
    	}
		redirect('/spo/view/'.$spo_id);
	}

	private function self_sign($spo_id) {
		$this->load->model('spo_model');
		$this->spo_model->self_sign($spo_id, $this->data['user_id']);
	}

	public function mailme($spo_id) {
        $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
        $this->load->library('email');
        $this->load->helper('url');
        $spo_url = base_url().'spo/view/'.$spo_id;
        $this->email->from('e-signature@sunrise-resorts.com');
        $this->email->to($user->email);
        $this->email->subject("SPO Form NO.#{$spo_id}");
        $this->email->message("SPO Form NO.#{$spo_id}:<br/>
                  Please use the link below to view the SPO Form:
                  <a href='{$spo_url}' target='_blank'>{$spo_url}</a><br/>
                "); 
        $mail_result = $this->email->send();
        redirect('spo/view/'.$spo_id);
  	}

  	private function reject_mail($name, $mail, $spo_id) {
		$this->load->library('email');
		$this->load->helper('url');
		$spo_url = base_url().'spo/view/'.$spo_id;
		$this->email->from('e-signature@sunrise-resorts.com');
		$this->email->to($mail);
		$this->email->subject("spo {$spo_id}");
		$this->email->message("Dear {$name},<br/>
							<br/>
							spo {$spo_id} has been rejected, Please use the link below:<br/>
							<a href='{$spo_url}' target='_blank'>{$spo_url}</a><br/>
							");	
		$mail_result = $this->email->send();
	}

	private function approvel_mail($name, $mail, $spo_id) {
		$this->load->library('email');
		$this->load->helper('url');
		$spo_url = base_url().'spo/view/'.$spo_id;
		$this->email->from('e-signature@sunrise-resorts.com');
		$this->email->to($mail);
		$this->email->subject("spo {$spo_id}");
		$this->email->message("Dear {$name},<br/>
							<br/>
							spo {$spo_id} has been approved, Please use the link below:<br/>
							<a href='{$spo_url}' target='_blank'>{$spo_url}</a><br/>
							");	
		$mail_result = $this->email->send();
	}

	public function chairman() {
		if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
			redirect('/unknown');
		}else{
			$this->load->model('spo_item_model');		
			$this->data['get_spo_items'] = $this->spo_item_model->get_chairman_items();
		 	$this->load->view('spo_chairman', $this->data);
	    }
	}

	public function share_url($spo_id) {
		if ($this->input->post('submit')) {
	    	$message = $this->input->post('message');
			$user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
			$spo_url = base_url().'spo/view/'.$spo_id;
			$messages = "{$user->fullname}  SPO form No. {$spo_id}
				{$spo_url}";	
			$this->onclick($messages, $spo_id, $this->config->item('page_to_send'));
		}
		redirect('/spo/view/'.$spo_id);
	}

		function onclick($message, $id, $channelss){
			include(APPPATH . 'third_party/RocketChat/autoload.php');
			$client = new RocketChat\Client($this->config->item('send_url'));
			$token = $client->api('user')->login($this->config->item('user_access'),$this->config->item('pass_access'));
			$client->setToken($token);
			$channel_result = $client->api('channel')->sendMessage($channelss,$message);
			$this->load->model('spo_model');
			$this->spo_model->update_message_id($id, $channel_result);
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