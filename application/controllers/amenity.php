<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class amenity extends CI_Controller {

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
    $this->data['menu']['active'] = "amenity";
  }

  public function reports() {
    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
          redirect('/unknown');
    }else{
      $this->load->view('amenity_report_index', $this->data);
    }
  }

  public function add() {
    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
          redirect('/unknown');
    }else{
      if ($this->input->post('submit')) {
        $this->load->library('form_validation');
        $this->load->library('email');
        $this->form_validation->set_rules('hotel_id','Hotel Name','trim|required');
        if ($this->form_validation->run() == TRUE) {
          $this->load->model('amenity_model');
          $this->load->model('users_model');  
          $datas = array(
            'user_id' => $this->data['user_id'],
            'hotel_id' => $this->input->post('hotel_id')
          );
        
        $amen_id = $this->amenity_model->create_amenity($datas);
        if (!$amen_id) {
            die("ERROR");
        }
        $room = $this->input->post('room');
    $rooms = explode(" ",$room);
    foreach ($rooms as $room) {
      $form_data = array(
              'room' => $room,
              'amen_id' => $amen_id
            );
          $item_id = $this->amenity_model->create_room($form_data);
          if (!$item_id) {
              die("ERROR");
          }
    }
    //die(print_r($datas));
        redirect('/amenity/submit/'.$amen_id);
        return $this->submit($amen_id);
    }
  }
  try {
        $this->load->helper('form');
        $this->load->model('amenity_model');
        $this->load->model('hotels_model');
        $this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());
        $this->load->view('amenity_add',$this->data);
      }
      catch( Exception $e) {
        show_error($e->getMessage()." _ ". $e->getTraceAsString());
      }
    }
}

  public function submit($amen_id) {
    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
  }else{
      if ($this->input->post('submit')) {
        $this->load->library('form_validation');
        $this->load->library('email');
        //$this->form_validation->set_rules('guest','Guest Name','trim|required');
        //$this->form_validation->set_rules('arrival','Arrival Date','trim|required');
        //$this->form_validation->set_rules('departure','Departure Date','trim|required');
        if ($this->form_validation->run() == FALSE) {
          $this->load->model('amenity_model');
          $this->load->model('users_model'); 
          $type = 1;
          foreach ($this->input->post('rooms') as $room) {
            $room['amen_id'] = $amen_id;  
            $room['long'] = $this->input->post('long');  
            $room['long_stay'] = $this->input->post('long_stay');  
            $room['ref'] = $this->input->post('ref');  
            $room['refiling'] = $this->input->post('refiling');  
            $room['treatment'] = $this->input->post('treatment');  
            $room['cookies'] = $this->input->post('cookies');  
            $room['nuts'] = $this->input->post('nuts');  
            $room['wine'] = $this->input->post('wine');  
            $room['fruit'] = $this->input->post('fruit');  
            $room['beer'] = $this->input->post('beer');  
            $room['cake'] = $this->input->post('cake');  
            $room['anniversary'] = $this->input->post('anniversary');  
            $room['honeymoon'] = $this->input->post('honeymoon');  
            $room['juices'] = $this->input->post('juices');  
            $room['dinner'] = $this->input->post('dinner');  
            $room['sick'] = $this->input->post('sick');  
            $room['th'] = $this->input->post('th');  
            $room['uk'] = $this->input->post('uk');  
            $room['alcohol'] = $this->input->post('alcohol');  
            $room['chocolate'] = $this->input->post('chocolate');  
            $room['milk'] = $this->input->post('milk');  
              //die(print_r($room));    
            $this->amenity_model->update_room($room, $amen_id, $room['id']);
            }
            $form_data = array(
              'date_time' => $this->input->post('date_time'),
              'reason' => $this->input->post('reason'),
              'location' => $this->input->post('location'),
              'others' => $this->input->post('others'),
              'relations' => $this->input->post('relations'),
              'type' => $type
            );
            $this->amenity_model->update_root($amen_id, $form_data['date_time'], $form_data['reason'], $form_data['location'], $form_data['others'], $form_data['relations']);
            $signatures = $this->amenity_model->amen_sign($type);
            $do_sign = $this->amenity_model->amen_do_sign($amen_id);
            //die(print_r($do_sign));
            if ($do_sign == 0) {
              foreach ($signatures as $amen_signature) {
                $this->amenity_model->add_signature($amen_id, $amen_signature['role'], $amen_signature['department'], $amen_signature['rank']);
              }
            }
          if ($this->input->post('ref') == 1) {
            redirect('/amenity/refl/'.$amen_id);
          }else{
                redirect('/amenity/amenity_stage/'.$amen_id);
          }
        }   
      }
      try {
        $this->load->helper('form');
        $this->load->model('amenity_model');
        $this->load->model('hotels_model');
        $this->data['amenity'] = $this->amenity_model->get_amenity($amen_id);
        $this->data['items'] = $this->amenity_model->get_items($amen_id);
        foreach ($this->data['items'] as $key => $items) {
          $this->data['items'][$key]['contacts'] = $this->amenity_model->getbyroom($this->data['items'][$key]['room'], $this->data['items'][$key]['hotel_id']);
        }
        //die(print_r($this->data['amenity']['room']));
        $this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());
        $this->data['uploads'] = $this->amenity_model->getby_fille($this->data['amenity']['id']);
        $this->load->view('amenity_add_new',$this->data);
      }
      catch( Exception $e) {
        show_error($e->getMessage()." _ ". $e->getTraceAsString());
      }
    }
  }

  public function make_offer($amen_id) {
    $file_name = $this->do_upload("upload");
    if (!$file_name) {
      die(json_encode($this->data['error']));
    } else {
      $this->load->model("amenity_model");
      $this->amenity_model->add($amen_id, $file_name, $this->data['user_id']);
      // $this->logger->log_event($this->data['user_id'], "Offer", "projects", $amen_id, json_encode(array("offer_name" => $file_name)), "user uploaded an offer");//log
      die("{}");
    }
  }

  public function remove_offer($amen_id, $id) {
    $file_name = $_POST['key'];
    if (!$id) {
      die(json_encode($this->data['error']));
    } else {
      $this->load->model("amenity_model");
      $this->amenity_model->remove($id);
      // $this->logger->log_event($this->data['user_id'], "Offer-Remove", "projects", $amen_id, json_encode(array("offer_id" => $id, "file_name" => $file_name)), "user removed an offer");//log
      die("{}");
    }
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

  public function submit_exp() {
    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
    }else{
      if ($this->input->post('submit')) {
        $this->load->library('form_validation');
        $this->load->library('email');
        $assumed_id = $this->input->post('assumed_id');  
        $this->form_validation->set_rules('pax','NO. Adult','trim|required');
        $this->form_validation->set_rules('child','No. Childs','trim|required');
        if ($this->form_validation->run() == TRUE) {
          $this->load->model('amenity_model');
          $this->load->model('users_model');  
          $type = 1;
          $datas = array(
            'user_id' => $this->data['user_id'],
            'hotel_id' => $this->input->post('hotel_id'),
            'date_time' => $this->input->post('date_time'),
            'reason' => $this->input->post('reason'),
            'location' => $this->input->post('location'),
            'others' => $this->input->post('others'),
            'relations' => $this->input->post('relations'),
            'type' => $type
          );
          $amen_id = $this->amenity_model->create_amenity($datas);
          if ($amen_id) {
            $this->load->model('amenity_model');
            $this->amenity_model->update_files($assumed_id,$amen_id);
          } else {
            die("ERROR");//@TODO failure view
          }
          $room = $this->input->post('room');
          $rooms = explode(" ",$room);
          $pax = $this->input->post('pax');
          $paxs = explode(" ",$pax);
          $child = $this->input->post('child');
          $childs = explode(" ",$child);
          $i = 0;
          foreach ($rooms as $room) {
            $form_data = array(
              'room' => $room, 
              'amen_id' => $amen_id,  
  	          'guest' => $this->input->post('guest'),
  	          'nationality' => $this->input->post('nationality'),
  	          'arrival' => $this->input->post('arrival'),
              'departure' => $this->input->post('departure'),
              'long' => $this->input->post('long'),
              'long_stay' => $this->input->post('long_stay'),
              'ref' => $this->input->post('ref'),
              'refiling' => $this->input->post('refiling'),
              'pax' => $paxs[$i],
              'child' => $childs[$i],
              'treatment' => $this->input->post('treatment'),
              'cookies' => $this->input->post('cookies'),
              'nuts' => $this->input->post('nuts'),
              'wine' => $this->input->post('wine'),
              'fruit' => $this->input->post('fruit'),
              'beer' => $this->input->post('beer'),
              'cake' => $this->input->post('cake'),
              'anniversary' => $this->input->post('anniversary'),
              'honeymoon' => $this->input->post('honeymoon'),
              'juices' => $this->input->post('juices'),
              'dinner' => $this->input->post('dinner'),
              'sick' => $this->input->post('sick'),
              'th' => $this->input->post('th'),
              'uk' => $this->input->post('uk'),
              'alcohol' => $this->input->post('alcohol'),
              'chocolate' => $this->input->post('chocolate'),
              'milk' => $this->input->post('milk')
            );
            $item_id = $this->amenity_model->create_room($form_data);
            if (!$item_id) {
              die("ERROR");
            }
            $i++;
          }
          $data = array(
            'amen_id' => $amen_id,
            'user_id' => $this->data['user_id'],
            'type' => '5'
          ); 
          $this->amenity_model->create_reason($data);
          $signatures = $this->amenity_model->amen_sign($type);
          $do_sign = $this->amenity_model->amen_do_sign($amen_id);
            //die(print_r($do_sign));
            if ($do_sign == 0) {
              foreach ($signatures as $amen_signature) {
                $this->amenity_model->add_signature($amen_id, $amen_signature['role'], $amen_signature['department'], $amen_signature['rank']);
              }
            }
          if ($this->input->post('ref') == 1) {
            redirect('/amenity/refl/'.$amen_id);
          }else{
                redirect('/amenity/amenity_stage/'.$amen_id);
          }
        }   
      }
      try {
        $this->load->helper('form');
        $this->load->model('amenity_model');
        $this->load->model('hotels_model');
        $this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());
        if ($this->input->post('submit')) {
          $this->load->model('amenity_model');
          $this->data['assumed_id'] = $this->input->post('assumed_id');
          $this->data['uploads'] = $this->amenity_model->getby_fille($this->data['assumed_id']);
        } else {
          $this->data['assumed_id'] = strtoupper(str_pad(dechex( mt_rand( 0, 1048575 ) ), 5, '0', STR_PAD_LEFT));
          $this->data['uploads'] = array();
        }
        $this->load->view('amenity_add_new_exp',$this->data);
      }
      catch( Exception $e) {
        show_error($e->getMessage()." _ ". $e->getTraceAsString());
      }
    }
  }

  	public function move($item_id) {
    	if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        	redirect('/unknown');
  		}else{
        	$this->load->model('amenity_model');
        	$this->data['item'] = $this->amenity_model->get_item($item_id);
        	$this->data['amenity'] = $this->amenity_model->get_amenity($this->data['item']['amen_id']);
        //die(print_r($this->data['amenity'] ));
      		if ($this->input->post('submit')) {
        		$this->load->library('form_validation');
        		$this->load->library('email');
        		$this->load->model('amenity_model');
        //die(print_r($item_id));
        //die(print_r($this->data['items']));
          		if ($this->form_validation->run() == FALSE) {
            		$this->load->model('amenity_model');
            		$this->load->model('users_model');  
            		$formad = array(
              			'room_id' => $item_id,
		              	'amen_id' => $this->data['item']['amen_id'],
		              	'user_new' => $this->data['user_id'],
		              	'room_old' => $this->input->post('room_old'),
		              	'room_new' => $this->input->post('room_new')
		            );
            		$this->amenity_model->create_amenitys($formad);
              //die(print_r($this->data['amenity']));
            		if ($this->data['amenity']['state_id']!='1'){
            //die(print_r($this->data['amenity']));
             			$this->notify($this->data['amenity']['id']);
            		}  
            		redirect('/amenity/view/'.$this->data['item']['amen_id']);
          		}
        	} 
      		try {
		        $this->load->helper('form');
		        $this->load->model('amenity_model');
		        $this->load->model('hotels_model');
		        $this->data['item'] = $this->amenity_model->get_item($item_id);
          		$this->data['amenit'] = $this->amenity_model->get_amen($this->data['item']['id']);
        		$this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());
        		$this->load->view('amenity_move',$this->data);
      		}
      		catch( Exception $e) {
        		show_error($e->getMessage()." _ ". $e->getTraceAsString());
      		}
    	}
  	}

  public function view($amen_id) {
    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
          redirect('/unknown');
    }else{
      $this->load->model('amenity_model');
      $this->load->model('hotels_model');   
      $this->data['hotels'] = $this->hotels_model->getall();
      $this->data['amenity'] = $this->amenity_model->get_amenity($amen_id);
      $this->data['room'] = $this->amenity_model->get_room($amen_id);
      $this->data['room_edit'] = $this->amenity_model->get_room_edit($amen_id);
      $this->data['items'] = $this->amenity_model->get_items($amen_id);      
      foreach ($this->data['items'] as $key => $item) {
        $this->data['items'][$key]['amenit'] = $this->amenity_model->get_amen($this->data['items'][$key]['id']);
      } 
      $this->data['amenitys_edit'] = $this->amenity_model->get_amenitys_edit($amen_id);
      //die(print_r($this->data['amenitys_edit']));
      $this->data['amenity_edit'] = $this->amenity_model->get_amenity_edit($amen_id);
      $this->data['items_edit'] = $this->amenity_model->get_item_edit($this->data['amenity_edit']['id']);
      $this->data['items_edits'] = $this->amenity_model->get_items_edit($amen_id);
      $this->data['count'] = $this->amenity_model->get_items_edit_count($amen_id);
      //die(print_r($this->data['amenity_edit']));
      $this->data['amenitys'] = $this->amenity_model->get_amenitys($amen_id);
      //die(print_r($this->data['items']));
      $this->data['uploads'] = $this->amenity_model->getby_fille($amen_id);
      $this->data['GetComment'] = $this->amenity_model->GetComment($amen_id);
      $this->data['reason'] = $this->amenity_model->get_reason($amen_id);
      $this->data['signature_path'] = '/assets/uploads/signatures/';
      $this->data['signers'] = $this->get_signers($this->data['amenity']['id'], $this->data['amenity']['hotel_id']);
      $editor = FALSE;
      $unsign_enable = FALSE;
      $first = TRUE;
      $force_edit = FALSE;
      foreach ($this->data['signers'] as $signer) {
        if (isset($signer['queue'])) {
          foreach ($signer['queue'] as $uid => $dummy) {
            if ( $uid == $this->data['user_id'] ) {
              $editor = FALSE;
              break;
            }
          }
        } elseif (isset($signer['sign'])) {
          $unsign_enable = FALSE;
          $force_edit = FALSE;
          if ($signer['sign']['id'] == $this->data['user_id']) {
            if ($first) {
              $force_edit = FALSE;
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
        if ( $this->data['amenity']['user_id'] == $this->data['user_id']) {
          $editor = TRUE;
        }
      }
      $this->data['unsign_enable'] = (($unsign_enable) || $this->data['is_admin'])? TRUE : FALSE;
      $this->data['is_editor'] = ( ($this->data['is_admin'] || $editor) || ($force_edit) )? TRUE : FALSE;
      $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
      $this->data['id'] = $amen_id;
      $this->load->view('amenity_view', $this->data);
    }
  }

  	public function edit($amen_id) {
    	if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        	redirect('/unknown');
  		}else{
      		if ($this->input->post('submit')) {
        		$this->load->library('form_validation');
        		$this->load->library('email');
        		if ($this->form_validation->run() == FALSE) {
          			$this->load->model('amenity_model');
          			$this->load->model('users_model');  
		          	$form_data = array(
		            	'amen_id' => $amen_id,
		            	'user_id' => $this->data['user_id'],
			            'hotel_id' => $this->input->post('hotel_id'),
			            'date_time' => $this->input->post('date_time'),
			            'reason' => $this->input->post('reason'),
			            'location' => $this->input->post('location'),
			            'others' => $this->input->post('others'),
			            'relations' => $this->input->post('relations')
		          	);
            		$edit_id = $this->amenity_model->create_amenity_edit($form_data);
	        		if (!$edit_id) {
	            		die("ERROR");
	        		}
	        		foreach ($this->input->post('rooms') as $room) {
			    		    $room['amen_id'] = $amen_id;  
			    		    $room['edit_id'] = $edit_id;  
                  $room['long'] = $this->input->post('long');
                  $room['long_stay'] = $this->input->post('long_stay');
                  $room['ref' ] =$this->input->post('ref');
                  $room['refiling'] = $this->input->post('refiling');
                  $room['treatment'] = $this->input->post('treatment');
                  $room['cookies'] = $this->input->post('cookies');
                  $room['nuts'] = $this->input->post('nuts');
                  $room['wine'] = $this->input->post('wine');
                  $room['fruit'] = $this->input->post('fruit');
                  $room['beer'] = $this->input->post('beer');
                  $room['cake'] = $this->input->post('cake');
                  $room['anniversary'] = $this->input->post('anniversary');
                  $room['honeymoon'] = $this->input->post('honeymoon');
                  $room['juices'] = $this->input->post('juices');
                  $room['dinner'] = $this->input->post('dinner');
                  $room['sick'] = $this->input->post('sick');
                  $room['th'] = $this->input->post('th');
                  $room['uk'] = $this->input->post('uk');
                  $room['alcohol'] = $this->input->post('alcohol') ;
                  $room['chocolate'] = $this->input->post('chocolate') ;
                  $room['milk'] = $this->input->post('milk') ;
        				$item_id = $this->amenity_model->create_room_edit($room);
	        			if (!$item_id) {
	            			die("ERROR");
	        			}
					}            
                  $this->notify($amen_id);
           			redirect('/amenity/view/'.$amen_id);
        		}   
      		}
      		try {
        		$this->load->helper('form');
        		$this->load->model('amenity_model');
        		$this->load->model('hotels_model');
        		$this->data['amenity'] = $this->amenity_model->get_amenity($amen_id);
        		$this->data['items'] = $this->amenity_model->get_items($amen_id);
            $this->data['room'] = $this->amenity_model->get_room($amen_id);
        		$this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());
        		$this->data['uploads'] = $this->amenity_model->getby_fille($this->data['amenity']['id']);
        		$this->load->view('amenity_edit',$this->data);
      		}
      		catch( Exception $e) {
        		show_error($e->getMessage()." _ ". $e->getTraceAsString());
      		}
    	}
  	}

  	public function edit_exp($amen_id) {
    	if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        	redirect('/unknown');
  		}else{
      if ($this->input->post('submit')) {
        $this->load->library('form_validation');
        $this->load->library('email');
        if ($this->form_validation->run() == FALSE) {
          $this->load->model('amenity_model');
          $this->load->model('users_model');  
          $form_data = array(
		        'amen_id' => $amen_id,
            'user_id' => $this->data['user_id'],
            'hotel_id' => $this->input->post('hotel_id'),
            'date_time' => $this->input->post('date_time'),
            'reason' => $this->input->post('reason'),
            'location' => $this->input->post('location'),
            'others' => $this->input->post('others'),
            'relations' => $this->input->post('relations')
          );
          $edit_id = $this->amenity_model->create_amenity_edit($form_data);
	        if (!$edit_id) {
	          die("ERROR");
	        }
          			foreach ($this->input->post('rooms') as $room) {
            			$room['amen_id'] = $amen_id;  
			    		    $room['edit_id'] = $edit_id;  
			            $room['guest'] = $this->input->post('guest');  
			            $room['nationality'] = $this->input->post('nationality');  
			            $room['arrival'] = $this->input->post('arrival');  
			            $room['departure'] = $this->input->post('departure');
                  $room['long'] = $this->input->post('long');
                  $room['long_stay'] = $this->input->post('long_stay');
                  $room['ref' ] =$this->input->post('ref');
                  $room['refiling'] = $this->input->post('refiling');
                  $room['treatment'] = $this->input->post('treatment');
                  $room['cookies'] = $this->input->post('cookies');
                  $room['nuts'] = $this->input->post('nuts');
                  $room['wine'] = $this->input->post('wine');
                  $room['fruit'] = $this->input->post('fruit');
                  $room['beer'] = $this->input->post('beer');
                  $room['cake'] = $this->input->post('cake');
                  $room['anniversary'] = $this->input->post('anniversary');
                  $room['honeymoon'] = $this->input->post('honeymoon');
                  $room['juices'] = $this->input->post('juices');
                  $room['dinner'] = $this->input->post('dinner');
                  $room['sick'] = $this->input->post('sick');
                  $room['th'] = $this->input->post('th');
                  $room['uk'] = $this->input->post('uk'); 
                  $room['alcohol'] = $this->input->post('alcohol') ;
                  $room['chocolate'] = $this->input->post('chocolate') ;
                  $room['milk'] = $this->input->post('milk') ;
        				$item_id = $this->amenity_model->create_room_edit($room);
	        			if (!$item_id) {
	            			die("ERROR");
	        			}    
	        		}
                  $this->notify($amen_id);
           			redirect('/amenity/view/'.$amen_id);
        		}   
      		}
      		try {
        		$this->load->helper('form');
       			$this->load->model('amenity_model');
		        $this->load->model('hotels_model');
		        $this->data['amenity'] = $this->amenity_model->get_amenity($amen_id);
		        $this->data['items'] = $this->amenity_model->get_items($amen_id);
            $this->data['room'] = $this->amenity_model->get_room($amen_id);
		        $this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());
		        $this->data['uploads'] = $this->amenity_model->getby_fille($this->data['amenity']['id']);
        		$this->load->view('amenity_edit_exp',$this->data);
      		}
      		catch( Exception $e) {
        		show_error($e->getMessage()." _ ". $e->getTraceAsString());
      		}
    	}
  	}

  private function get_signers($amen_id, $hotel_id) {
    $this->load->model('amenity_model');
    $signatures = $this->amenity_model->getby_verbal($amen_id);
    return $this->roll_signers($signatures, $hotel_id, $amen_id);
  }

  private function roll_signers($signatures, $hotel_id, $amen_id) {
    $signers = array();
    $this->load->model('users_model');
    foreach ($signatures as $signature) {
      $signers[$signature['id']] = array();
      $signers[$signature['id']]['role'] = $signature['role'];
      $signers[$signature['id']]['role_id'] = $signature['role_id'];
      $signers[$signature['id']]['department'] = $signature['department'];
      $signers[$signature['id']]['department_id'] = $signature['department_id'];
      if ($signature['user_id']) {
        $signers[$signature['id']]['sign'] = array();
        $signers[$signature['id']]['sign']['id'] = $signature['user_id'];
        if ($signature['reject'] == 1) {
          $signers[$signature['id']]['sign']['reject'] = "reject";
          $this->amenity_model->update_state($amen_id, 3);
        } 
        $user = $this->users_model->get_user_by_id($signature['user_id'], TRUE);
        $signers[$signature['id']]['sign']['name'] = $user->fullname;
        $signers[$signature['id']]['sign']['mail'] = $user->email;
        $signers[$signature['id']]['sign']['sign'] = $user->signature;
        $signers[$signature['id']]['sign']['timestamp'] = $signature['timestamp'];
      } else {
        $signers[$signature['id']]['queue'] = array();
        if ($signature['rank'] == 1) {
          $users = array();
          $users[0] = $this->users_model->getby_criteria(58, $hotel_id, $signature['department_id']);
          $users[1] = $this->users_model->getby_criteria(46, $hotel_id, $signature['department_id']);
          foreach ($users as $user) {
            foreach ($user as $use) {
              $signers[$signature['id']]['queue'][$use['id']] = array();
              $signers[$signature['id']]['queue'][$use['id']]['name'] = $use['fullname'];
              $signers[$signature['id']]['queue'][$use['id']]['mail'] = $use['email'];
            }
          }
        } else {
          $users = $this->users_model->getby_criteria($signature['role_id'], $hotel_id, $signature['department_id']);
          foreach ($users as $use) {
            $signers[$signature['id']]['queue'][$use['id']] = array();
            $signers[$signature['id']]['queue'][$use['id']]['name'] = $use['fullname'];
            $signers[$signature['id']]['queue'][$use['id']]['mail'] = $use['email'];
          }
        }
      }
    }
    return $signers;
  }

  public function index() {
    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
          redirect('/unknown');
    }else{
      $this->load->model('hotels_model');
      $this->load->model('amenity_model');
      $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
      $hotels = array();
      foreach ($user_hotels as $hotel) {
        $hotels[] = $hotel['id'];
      }  
      $this->data['amenity'] = $this->amenity_model->view($hotels);
      foreach ($this->data['amenity'] as $ke => $amen) {
        $this->data['amenity'][$ke]['approvals'] = $this->amenity_model->getby_verbals($this->data['amenity'][$ke]['id']);
        $this->data['amenity'][$ke]['items'] = $this->amenity_model->get_itemss($this->data['amenity'][$ke]['id']);
        foreach ($this->data['amenity'][$ke]['items'] as $keys => $item) {
          $this->data['amenity'][$ke]['items'][$keys]['amenitys'] = $this->amenity_model->get_amens($this->data['amenity'][$ke]['items'][$keys]['id']);
        } 
      } 
      $this->data['hotels'] = $user_hotels;
      $this->load->view('amenity_index', $this->data);
    }
  }

  public function index_app() {
    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
          redirect('/unknown');
    }else{
      $this->load->model('hotels_model');
      $this->load->model('amenity_model');
      $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
      $hotels = array();
      foreach ($user_hotels as $hotel) {
        $hotels[] = $hotel['id'];
      }  
      $this->data['amenity'] = $this->amenity_model->view_app($hotels);
      foreach ($this->data['amenity'] as $ke => $amen) {
        $this->data['amenity'][$ke]['reason'] = $this->amenity_model->get_reasons($this->data['amenity'][$ke]['id']);
        $this->data['amenity'][$ke]['approvals'] = $this->amenity_model->getby_verbals($this->data['amenity'][$ke]['id']);
        $this->data['amenity'][$ke]['items'] = $this->amenity_model->get_itemss($this->data['amenity'][$ke]['id']);
        foreach ($this->data['amenity'][$ke]['items'] as $keys => $item) {
          $this->data['amenity'][$ke]['items'][$keys]['amenitys'] = $this->amenity_model->get_amens($this->data['amenity'][$ke]['items'][$keys]['id']);
        } 
      } 
      $this->data['hotels'] = $user_hotels;
      $this->load->view('amenity_index_app', $this->data);
    }
  }

  public function index_wat() {
    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
          redirect('/unknown');
    }else{
      /*if ($this->input->post('submit')) {
        $this->data['state'] = $this->input->post('state');
      }*/
      $this->load->model('hotels_model');
      $this->load->model('amenity_model');
      $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
      $hotels = array();
      foreach ($user_hotels as $hotel) {
        $hotels[] = $hotel['id'];
      } 
      $this->data['amenity'] = $this->amenity_model->view_wat($hotels);
      foreach ($this->data['amenity'] as $ke => $amen) {
        $this->data['amenity'][$ke]['approvals'] = $this->amenity_model->getby_verbals($this->data['amenity'][$ke]['id']);
        $this->data['amenity'][$ke]['items'] = $this->amenity_model->get_itemss($this->data['amenity'][$ke]['id']);
        foreach ($this->data['amenity'][$ke]['items'] as $keys => $item) {
          $this->data['amenity'][$ke]['items'][$keys]['amenitys'] = $this->amenity_model->get_amens($this->data['amenity'][$ke]['items'][$keys]['id']);
        } 
      }  
      $this->data['hotels'] = $user_hotels;
      $this->load->view('amenity_index_wat', $this->data);
    }
  }

  public function index_rej() {
    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
          redirect('/unknown');
    }else{
      $this->load->model('hotels_model');
      $this->load->model('amenity_model');
      $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
      $hotels = array();
      foreach ($user_hotels as $hotel) {
        $hotels[] = $hotel['id'];
      }    
      $this->data['amenity'] = $this->amenity_model->view_rej($hotels);
      foreach ($this->data['amenity'] as $ke => $amen) {
        $this->data['amenity'][$ke]['approvals'] = $this->amenity_model->getby_verbals($this->data['amenity'][$ke]['id']);
        $this->data['amenity'][$ke]['items'] = $this->amenity_model->get_itemss($this->data['amenity'][$ke]['id']);
        foreach ($this->data['amenity'][$ke]['items'] as $keys => $item) {
          $this->data['amenity'][$ke]['items'][$keys]['amenitys'] = $this->amenity_model->get_amens($this->data['amenity'][$ke]['items'][$keys]['id']);
        } 
      } 
      $this->data['hotels'] = $user_hotels;
      $this->load->view('amenity_index_rej', $this->data);
    }
  }




  public function sign($signature_id, $reject = FALSE) {
    $this->load->model('amenity_model');
    $signature_identity = $this->amenity_model->get_signature_identity($signature_id);
    $signrs = $this->get_signers($signature_identity['amen_id'], $signature_identity['hotel_id']);
    $this->data['amenity'] = $this->amenity_model->get_amenity($signature_identity['amen_id']);
    if (array_key_exists($this->data['user_id'], $signrs[$signature_id]['queue'])) {
      if ($reject) {
        $this->amenity_model->reject($signature_id, $this->data['user_id']);
        redirect('/amenity/amenity_stage/'.$this->data['amenity']['id']);  
      } else {
        $this->amenity_model->sign($signature_id, $this->data['user_id']);
        redirect('/amenity/amenity_stage/'.$signature_identity['amen_id']);  

      }
    }
    redirect('/amenity/view/'.$signature_identity['amen_id']);
  }

  public function amenity_stage($amen_id) {
    $this->load->model('amenity_model');
    $this->data['amenity'] = $this->amenity_model->get_amenity($amen_id);
    $this->data['items'] = $this->amenity_model->get_items($amen_id);      
    //die(print_r($this->data['amenit']));
    if ($this->data['amenity']['state_id'] == 0) {
      $this->amenity_model->update_state($amen_id, 1);
        redirect('/amenity/amenity_stage/'.$amen_id);
    } elseif ($this->data['amenity']['state_id'] != 0 && $this->data['amenity']['state_id'] != 2 && $this->data['amenity']['state_id'] != 3) {
      $queue = $this->notify_signers($amen_id, $this->data['amenity']['hotel_id']);
      if (!$queue) {
        $this->amenity_model->update_state($amen_id, 2);
        $this->notify_done($amen_id);
      }
      //$user = $this->users_model->get_user_by_id($this->data['amenity']['user_id'], TRUE);
      //$queue = $this->approvel_mail($user->fullname, $user->email, $amen_id);
    }elseif ($this->data['amenity']['state_id'] == 3){
      $user = $this->users_model->get_user_by_id($this->data['amenity']['user_id'], TRUE);
      $queue = $this->reject_mail($user->fullname, $user->email, $amen_id);
    }
      redirect('/amenity/view/'.$amen_id);
  }

  private function notify_signers($amen_id) {
    $notified = FALSE;
    $signers = $this->get_signers($amen_id, $this->data['amenity']['hotel_id']);
    foreach ($signers as $signer) {
      if (isset($signer['queue'])) {
        $notified = TRUE;
          foreach ($signer['queue'] as $uid => $user) {
            $this->signatures_mail($signer['role'], $signer['department'], $user['name'], $user['mail'], $amen_id);
        }
        break;
      }
    }
    return $notified;
  }

  private function signatures_mail($role, $department, $name, $mail, $amen_id) {
    $this->load->library('email');
    $this->load->helper('url');
    $amen_url = base_url().'amenity/view/'.$amen_id;
    $this->email->from('e-signature@sunrise-resorts.com');
    $this->email->to($mail);
    $this->email->subject("Guest Amenity Request {$amen_id}");
    $this->email->message("Dear {$name},<br/>
              <br/>
              Guest Amenity Request {$amen_id} requires your signature, Please use the link below:<br/>
              <a href='{$amen_url}' target='_blank'>{$amen_url}</a><br/>
              "); 
    $mail_result = $this->email->send();
  }

  public function unsign($signature_id) {
    $this->load->model('amenity_model');
    $this->load->model('users_model');
    $signature_identity = $this->amenity_model->get_signature_identity($signature_id);
    $this->amenity_model->unsign($signature_id);
    $amenity = $this->amenity_model->get_amenity($signature_identity['amen_id']);
    redirect('/amenity/view/'.$signature_identity['amen_id']);
  }

  private function reject_mail($name, $email, $amen_id) {
    $this->load->library('email');
    $this->load->helper('url');
    $amen_url = base_url().'amenity/view/'.$amen_id;
    $this->email->from('e-signature@sunrise-resorts.com');
    $this->email->to($email);
    $this->email->subject("Guest Amenity Request {$amen_id}");
    $this->email->message("Dear {$name},<br/>
              <br/>
              Guest Amenity Request {$amen_id} has been rejected, Please use the link below:<br/>
              <a href='{$amen_url}' target='_blank'>{$amen_url}</a><br/>
              "); 
    $mail_result = $this->email->send();
  }

  private function approvel_mail($name, $email, $amen_id) {
    $this->load->library('email');
    $this->load->helper('url');
    $amen_url = base_url().'amenity/view/'.$amen_id;
    $this->email->from('e-signature@sunrise-resorts.com');
    $this->email->to($email);
    $this->email->subject("Guest Amenity Request {$amen_id}");
    $this->email->message("Dear {$name},<br/>
              <br/>
              Guest Amenity Request {$amen_id} has been approved, Please use the link below:<br/>
              <a href='{$amen_url}' target='_blank'>{$amen_url}</a><br/>
              "); 
    $mail_result = $this->email->send();
  }

  public function mailto($amen_id) {
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
        $amen_url = base_url().'amenity/view/'.$amen_id;
        $this->email->from('e-signature@sunrise-resorts.com');
        $this->email->to($email);
        $this->email->subject("A message from {$user->fullname}, Guest Amenity Request No.{$amen_id}");
        $this->email->message("{$user->fullname} sent you a private message regarding Guest Amenity Request {$amen_id}:<br/>
                  {$message}<br />
                  <br />
                  Please use the link below to view the Guest Amenity Request:
                  <a href='{$amen_url}' target='_blank'>{$amen_url}</a><br/>
                "); 
        $mail_result = $this->email->send();
      }
    }
    redirect('amenity/view/'.$amen_id);
  }

   private function self_sign($amen_id) {
    $this->load->model('amenity_model');
    $this->amenity_model->self_sign($amen_id, $this->data['user_id']);
  }

  public function Comment($amen_id){
      if ($this->input->post('submit')) {
      $this->load->library('form_validation');
      $this->form_validation->set_rules('comment','Comment','trim|required');
        if ($this->form_validation->run() == TRUE) {
          $comment = $this->input->post('comment'); 
          $this->load->model('amenity_model');
          $comment_data = array(
            'user_id' => $this->data['user_id'],
            'amen_id' => $amen_id,
            'comment' => $comment
          );
        $this->amenity_model->InsertComment($comment_data);
      }
      redirect('/amenity/view/'.$amen_id);
    }
  }

  public function mailme($amen_id) {
        $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
        $this->load->library('email');
        $this->load->helper('url');
        $amen_url = base_url().'amenity/view/'.$amen_id;
        $this->email->from('e-signature@sunrise-resorts.com');
        $this->email->to($user->email);
        $this->email->subject("Guest Amenity Request NO.#{$amen_id}");
        $this->email->message("Guest Amenity Request NO.#{$amen_id}:<br/>
                  Please use the link below to view the Guest Amenity Request:
                  <a href='{$amen_url}' target='_blank'>{$amen_url}</a><br/>
                "); 
        $mail_result = $this->email->send();
        redirect('amenity/view/'.$amen_id);
  }

  public function notify($amen_id) {
    $this->load->model('amenity_model');
    $this->load->model('users_model');
    $this->data['amenity'] = $this->amenity_model->get_amenity($amen_id);
    $signes = $this->amenity_model->getby_verbal($amen_id);
    $users = array();
    foreach ($signes as $signe){
          //die(print_r($signe['role_id']));
      if ($signe['user_id']) {
        $user = $this->users_model->get_user_by_id($signe['user_id'], TRUE);
          //die(print_r($user));
          $name = $user->fullname;
          $mail = $user->email;
          $this->load->library('email');
          $this->load->helper('url');
          $amen_url = base_url().'amenity/view/'.$amen_id;
          $this->email->from('e-signature@sunrise-resorts.com');
          $this->email->to($mail);
          $this->email->subject("Guest Amenity Request NO.#{$amen_id}");
          $this->email->message("Dear {$name},<br/>
            <br/>
            Guest Amenity Request NO.#{$amen_id} has been Edited, Please use the link below:<br/>
            <a href='{$amen_url}' target='_blank'>{$amen_url}</a><br/>
          "); 
          $mail_result = $this->email->send();
      }
    }
    redirect('amenity/view/'.$amen_id);
  }

  public function notify_done($amen_id) {
    $this->load->model('amenity_model');
    $this->load->model('users_model');
    $this->data['amenity'] = $this->amenity_model->get_amenity($amen_id);
    $signes = $this->amenity_model->getby_verbal($amen_id);
    $users = array();
    foreach ($signes as $signe){
          //die(print_r($signe['role_id']));
      if ($signe['user_id']) {
        $user = $this->users_model->get_user_by_id($signe['user_id'], TRUE);
          //die(print_r($user));
          $name = $user->fullname;
          $mail = $user->email;
          $this->load->library('email');
          $this->load->helper('url');
          $amen_url = base_url().'amenity/view/'.$amen_id;
          $this->email->from('e-signature@sunrise-resorts.com');
          $this->email->to($mail);
          $this->email->subject("Guest Amenity Request NO.#{$amen_id}");
          $this->email->message("Dear {$name},<br/>
            <br/>
            Guest Amenity Request NO.#{$amen_id} has been approved, Please use the link below:<br/>
            <a href='{$amen_url}' target='_blank'>{$amen_url}</a><br/>
          "); 
          $mail_result = $this->email->send();
      }
    }
    redirect('amenity/view/'.$amen_id);
  }

  public function refl($amen_id) {
    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
      redirect('/unknown');
    }else{
      if ($this->input->post('submit')) {
        $this->load->library('form_validation');
        $this->load->model('amenity_model');
        $this->load->library('email');
        $this->data['amenity'] = $this->amenity_model->get_amenity($amen_id);
        $this->data['items'] = $this->amenity_model->get_items($amen_id);  
        if ($this->form_validation->run() == FALSE) {
          $this->load->model('amenity_model');
          $this->load->model('users_model'); 
          foreach ($this->data['items'] as $amen) {
            foreach ($this->input->post('refls') as $refl) {
              $refl['amen_id'] = $amen_id;  
              $refl['room_id'] = $amen['id'];  
              $refl['room'] = $amen['room'];  
              $refl_id = $this->amenity_model->create_refl($refl);
              if (!$refl_id) {
                die("ERROR");
              }
            }
          }
          redirect('/amenity/amenity_stage/'.$amen_id);
        }   
      }
      try {
        $this->load->helper('form');
        $this->load->model('amenity_model');
        $this->data['amenity'] = $this->amenity_model->get_amenity($amen_id);
        $this->data['items'] = $this->amenity_model->get_items($amen_id);          
        $this->load->view('amenity_add_refilling',$this->data);
      }
      catch( Exception $e) {
        show_error($e->getMessage()." _ ". $e->getTraceAsString());
      }
    }
  }
   
  public function retoure($amen_id) {
    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
      redirect('/unknown');
    }else{
      if ($this->input->post('submit')) {
          $this->load->library('form_validation');
          $this->load->library('email');
          $this->form_validation->set_rules('reason','You Need To Enter a Reason','trim|required');
        if ($this->form_validation->run() == TRUE) {
          $this->load->model('amenity_model');
          $this->load->model('users_model'); 
          $data = array(
              'amen_id' => $amen_id,
              'user_id' => $this->data['user_id'],
              'reason' => $this->input->post('reason'),
              'type' => '1'
            ); 
          $this->amenity_model->create_reason($data);
          $this->data['amenity'] = $this->amenity_model->get_amenity($amen_id);
          if ($this->data['amenity']['state_id']!='1'){
            //die(print_r($this->data['amenity']));
            $this->notify($this->data['amenity']['id']);
          }
          redirect('/amenity');
        }   
      }
      try {
        $this->load->helper('form');
        $this->load->model('amenity_model');
        $this->load->view('amenity_add_reason',$this->data);
      }
      catch( Exception $e) {
        show_error($e->getMessage()." _ ". $e->getTraceAsString());
      }
    }
  }

  public function cancel($amen_id) {
    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
      redirect('/unknown');
    }else{
      if ($this->input->post('submit')) {
          $this->load->library('form_validation');
          $this->load->library('email');
          $this->form_validation->set_rules('reason','You Need To Enter a Reason','trim|required');
        if ($this->form_validation->run() == TRUE) {
          $this->load->model('amenity_model');
          $this->load->model('users_model'); 
          $data = array(
              'amen_id' => $amen_id,
              'user_id' => $this->data['user_id'],
              'reason' => $this->input->post('reason'),
              'type' => '2'
            ); 
          $this->amenity_model->create_reason($data);
          $this->data['amenity'] = $this->amenity_model->get_amenity($amen_id);
          if ($this->data['amenity']['state_id']!='1'){
            //die(print_r($this->data['amenity']));
            $this->notify($this->data['amenity']['id']);
          }
          redirect('/amenity');
        }   
      }
      try {
        $this->load->helper('form');
        $this->load->model('amenity_model');
        $this->load->view('amenity_add_reason',$this->data);
      }
      catch( Exception $e) {
        show_error($e->getMessage()." _ ". $e->getTraceAsString());
      }
    }
  }

    public function show($amen_id) {
    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
      redirect('/unknown');
    }else{
      if ($this->input->post('submit')) {
          $this->load->library('form_validation');
          $this->load->library('email');
          $this->form_validation->set_rules('reason','You Need To Enter a Reason','trim|required');
        if ($this->form_validation->run() == TRUE) {
          $this->load->model('amenity_model');
          $this->load->model('users_model'); 
          $data = array(
              'amen_id' => $amen_id,
              'user_id' => $this->data['user_id'],
              'reason' => $this->input->post('reason'),
              'type' => '3'
            ); 
          $this->amenity_model->create_reason($data);
          $this->data['amenity'] = $this->amenity_model->get_amenity($amen_id);
          if ($this->data['amenity']['state_id']!='1'){
            //die(print_r($this->data['amenity']));
            $this->notify($this->data['amenity']['id']);
          }
          redirect('/amenity');
        }   
      }
      try {
        $this->load->helper('form');
        $this->load->model('amenity_model');
        $this->load->view('amenity_add_reason',$this->data);
      }
      catch( Exception $e) {
        show_error($e->getMessage()." _ ". $e->getTraceAsString());
      }
    }
  }

  public function deliver($amen_id) {
    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
      redirect('/unknown');
    }else{
          $this->load->model('amenity_model');
          $this->load->model('users_model'); 
          	$data = array(
              'amen_id' => $amen_id,
              'user_id' => $this->data['user_id'],
              'type' => '4'
            ); 
          $this->amenity_model->create_reason($data);
          $this->data['amenity'] = $this->amenity_model->get_amenity($amen_id);
          if ($this->data['amenity']['state_id']!='1'){
            //die(print_r($this->data['amenity']));
            $this->notify($this->data['amenity']['id']);
          }
          redirect('/amenity');
      try {
        $this->load->helper('form');
        $this->load->model('amenity_model');
      }
      catch( Exception $e) {
        show_error($e->getMessage()." _ ". $e->getTraceAsString());
      }
    }
  }

  public function type($amen_id) {
    $this->load->model('amenity_model');
    if ($this->input->post('submit')) {
      $this->load->library('form_validation');
      $this->form_validation->set_rules('type','You Need To Chose a Type','trim|required');
      if ($this->form_validation->run() == TRUE) {
        $type = $this->input->post('type');
        if ($type == '1') {
          redirect('/amenity/retoure/'.$amen_id);
        }elseif ($type == '2') {
          redirect('/amenity/cancel/'.$amen_id);
        }elseif ($type == '3') {
          redirect('/amenity/show/'.$amen_id);
        }elseif ($type == '4') {
          redirect('/amenity/deliver/'.$amen_id);
        }
      }
    }
  }

  	public function report_all() {
		if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
		      redirect('/unknown');
		}else{      
			$this->load->helper('form');
	      	if ($this->input->post('submit')) {
		        $vip = $this->input->post('vip');
		        $from_date = $this->input->post('from');
		        $to_date = $this->input->post('to');
            $this->data['treatment'] = $vip;
            $this->data['from'] = $from_date;
            $this->data['to'] = $to_date;
		        $from_date .=" 00:00:00";
		        $to_date .= " 23:59:59";
		        $this->load->model('amenity_model');
		        $this->load->model('hotels_model');   
		        $this->data['hotels'] = $this->hotels_model->getall();
            $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
            $hotels = array();
            foreach ($user_hotels as $hotel) {
              $hotels[] = $hotel['id'];
            }  
		        $this->data['vip'] = $this->amenity_model->getall_vip($from_date, $to_date, $vip, $hotels);
		        foreach ($this->data['vip'] as $key => $item) {
			        $this->data['vip'][$key]['amenit'] = $this->amenity_model->get_amen($this->data['vip'][$key]['id']);
	      			$this->data['vip'][$key]['amenitys_edit'] = $this->amenity_model->get_amenity_edit($this->data['vip'][$key]['amen_id']);
			    	$this->data['vip'][$key]['room_edit'] = $this->amenity_model->get_item_edit_refl($this->data['vip'][$key]['amenitys_edit']['id']);
			    }
		        $this->data['vip_count'] = $this->amenity_model->getall_vip_count($from_date, $to_date, $vip, $hotels);
		        $count =  array();
		        foreach ($this->data['vip'] as $re) {
              if ($re['hotel_name']) {
		            $count[] = $re['hotel_name'];
              }
		        }
		        $this->data['count'] = array_count_values($count);
	      	}
	      	$this->load->view('amenity_report', $this->data);
	    }
  	}

  	public function report_hotel() {
	   if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
		      redirect('/unknown');
		}else{
	      	$this->load->helper('form');
	      	$this->load->model('hotels_model');   
	      	$this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
	      	if ($this->input->post('submit')) {
		        $vip = $this->input->post('vip');
		        $from_date = $this->input->post('from');
		        $to_date = $this->input->post('to');
            $this->data['treatment'] = $vip;
            $this->data['from'] = $from_date;
            $this->data['to'] = $to_date;
		        $from_date .=" 00:00:00";
		        $to_date .= " 23:59:59";
		        $hotel_id = $this->input->post('hotel_id');
            $this->data['name'] = $this->hotels_model->get_by_id($hotel_id);
		        $this->load->model('amenity_model');
		        $this->data['vip'] = $this->amenity_model->get_vip($hotel_id, $from_date, $to_date, $vip);
		        foreach ($this->data['vip'] as $key => $item) {
			        $this->data['vip'][$key]['amenit'] = $this->amenity_model->get_amen($this->data['vip'][$key]['id']);
	      			$this->data['vip'][$key]['amenitys_edit'] = $this->amenity_model->get_amenity_edit($this->data['vip'][$key]['amen_id']);
			    	$this->data['vip'][$key]['room_edit'] = $this->amenity_model->get_item_edit_refl($this->data['vip'][$key]['amenitys_edit']['id']);
			    }
		        $this->data['vip_count'] = $this->amenity_model->get_vip_count($hotel_id, $from_date, $to_date, $vip);
	      	}
	      	$this->load->view('amenity_report_hotel', $this->data);
	    }
  	}

    public function refilling_report() {
     if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
          redirect('/unknown');
    }else{
          $this->load->helper('form');
          $this->load->model('hotels_model');   
          $this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
          if ($this->input->post('submit')) {
            $from_date = $this->input->post('from');
            $to_date = $this->input->post('to');
            $this->data['from'] = $from_date;
            $this->data['to'] = $to_date;
            $from_date .=" 00:00:00";
            $to_date .= " 23:59:59";
            $hotel_id = $this->input->post('hotel_id');
            $this->data['name'] = $this->hotels_model->get_by_id($hotel_id);
            $this->load->model('amenity_model');
            $this->data['refl'] = $this->amenity_model->get_refl($hotel_id, $from_date, $to_date);
            foreach ($this->data['refl'] as $key => $item) {
		        $this->data['refl'][$key]['amenit'] = $this->amenity_model->get_amen($this->data['refl'][$key]['room_id']);
      			$this->data['refl'][$key]['amenitys_edit'] = $this->amenity_model->get_amenity_edit($this->data['refl'][$key]['amen_id']);
		    	$this->data['refl'][$key]['room_edit'] = $this->amenity_model->get_item_edit_refl($this->data['refl'][$key]['amenitys_edit']['id']);
		    }
		    //die(print_r($this->data['refl']));
            $this->data['refl_count'] = $this->amenity_model->get_refl_count($hotel_id, $from_date, $to_date);
          }
          $this->load->view('amenity_refl_report', $this->data);
      }
    }

    public function report_detail_all() {
    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
          redirect('/unknown');
    }else{      
      $this->load->helper('form');
          if ($this->input->post('submit')) {
            $vip = $this->input->post('vip');
            $from_date = $this->input->post('from');
            $to_date = $this->input->post('to');
            $this->data['treatment'] = $vip;
            $this->data['from'] = $from_date;
            $this->data['to'] = $to_date;
            $from_date .=" 00:00:00";
            $to_date .= " 23:59:59";
            $this->load->model('amenity_model');
            $this->load->model('hotels_model');   
            $this->data['hotels'] = $this->hotels_model->getall();
            $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
            $hotels = array();
            foreach ($user_hotels as $hotel) {
              $hotels[] = $hotel['id'];
            }  
            $this->data['vip'] = $this->amenity_model->getall_vip($from_date, $to_date, $vip, $hotels);
            foreach ($this->data['vip'] as $key => $item) {
				$this->data['vip'][$key]['amenit'] = $this->amenity_model->get_amen($this->data['vip'][$key]['id']);
	      		$this->data['vip'][$key]['amenitys_edit'] = $this->amenity_model->get_amenity_edit($this->data['vip'][$key]['amen_id']);
			   	$this->data['vip'][$key]['room_edit'] = $this->amenity_model->get_item_edit_refl($this->data['vip'][$key]['amenitys_edit']['id']);
			}
            $this->data['vip_count'] = $this->amenity_model->getall_vip_count($from_date, $to_date, $vip, $hotels);
            $count =  array();
            foreach ($this->data['vip'] as $re) {
              if ($re['hotel_name']) {
                $count[] = $re['hotel_name'];
              }
            }
            $this->data['count'] = array_count_values($count);
          }
          $this->load->view('amenity_detail_report', $this->data);
      }
    }

    public function report_detail_hotel() {
     if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
          redirect('/unknown');
    }else{
          $this->load->helper('form');
          $this->load->model('hotels_model');   
          $this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
          if ($this->input->post('submit')) {
            $vip = $this->input->post('vip');
            $from_date = $this->input->post('from');
            $to_date = $this->input->post('to');
            $this->data['treatment'] = $vip;
            $this->data['from'] = $from_date;
            $this->data['to'] = $to_date;
            $from_date .=" 00:00:00";
            $to_date .= " 23:59:59";
            $hotel_id = $this->input->post('hotel_id');
            $this->data['name'] = $this->hotels_model->get_by_id($hotel_id);
            $this->load->model('amenity_model');
            $this->data['vip'] = $this->amenity_model->get_vip($hotel_id, $from_date, $to_date, $vip);
            foreach ($this->data['vip'] as $key => $item) {
				$this->data['vip'][$key]['amenit'] = $this->amenity_model->get_amen($this->data['vip'][$key]['id']);
	      		$this->data['vip'][$key]['amenitys_edit'] = $this->amenity_model->get_amenity_edit($this->data['vip'][$key]['amen_id']);
			   	$this->data['vip'][$key]['room_edit'] = $this->amenity_model->get_item_edit_refl($this->data['vip'][$key]['amenitys_edit']['id']);
			}
            $this->data['vip_count'] = $this->amenity_model->get_vip_count($hotel_id, $from_date, $to_date, $vip);
          }
          $this->load->view('amenity_detail_report_hotel', $this->data);
      }
    }

    public function report_type() {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
          redirect('/unknown');
      }else{      
          $this->load->helper('form');
          if ($this->input->post('submit')) {
            $type = $this->input->post('type');
            $from_date = $this->input->post('from');
            $to_date = $this->input->post('to');
            if ($type == 1) {
              $this->data['type'] = "Retoure";
            }elseif ($type == 2) {
              $this->data['type'] = "Cancelled";
            }elseif ($type == 3) {
              $this->data['type'] = "No Show";
            }elseif ($type == 4) {
              $this->data['type'] = "Delivered";
            }elseif ($type == 5) {
              $this->data['type'] = "Expacted Arrival";
            }else {
              $this->data['type'] = "In House";
            }
            $this->data['from'] = $from_date;
            $this->data['to'] = $to_date;
            $from_date .=" 00:00:00";
            $to_date .= " 23:59:59";
            $this->load->model('amenity_model');
            $this->load->model('hotels_model');   
            $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
            $hotels = array();
            foreach ($user_hotels as $hotel) {
              $hotels[] = $hotel['id'];
            }  
            $this->data['amenity'] = $this->amenity_model->type_all_report($hotels, $from_date, $to_date, $type);
            foreach ($this->data['amenity'] as $ke => $amen) {
              $this->data['amenity'][$ke]['items'] = $this->amenity_model->get_items($this->data['amenity'][$ke]['id']);
              //die(print_r($this->data['amenity'][$ke]['items']));
              foreach ($this->data['amenity'][$ke]['items'] as $keys => $item) {
                $this->data['amenity'][$ke]['items'][$keys]['amenitys'] = $this->amenity_model->get_amen($this->data['amenity'][$ke]['items'][$keys]['id']);
	      		$this->data['amenity'][$ke]['items'][$keys]['amenitys_edit'] = $this->amenity_model->get_amenity_edit($this->data['amenity'][$ke]['items'][$keys]['amen_id']);
			   	$this->data['amenity'][$ke]['items'][$keys]['room_edit'] = $this->amenity_model->get_item_edit_refl($this->data['amenity'][$ke]['items'][$keys]['amenitys_edit']['id']);
              } 
            } 
          }
          $this->load->view('amenity_type_report', $this->data);
      }
    }

    public function report_type_hotel() {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
          redirect('/unknown');
      }else{      
          $this->load->helper('form');
          $this->load->model('hotels_model');   
          $this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
          if ($this->input->post('submit')) {
            $type = $this->input->post('type');
            $from_date = $this->input->post('from');
            $to_date = $this->input->post('to');
            if ($type == 1) {
              $this->data['type'] = "Retoure";
            }elseif ($type == 2) {
              $this->data['type'] = "Cancelled";
            }elseif ($type == 3) {
              $this->data['type'] = "No Show";
            }elseif ($type == 4) {
              $this->data['type'] = "Delivered";
            }elseif ($type == 5) {
              $this->data['type'] = "Expacted Arrival";
            }else {
              $this->data['type'] = "In House";
            }
            $this->data['from'] = $from_date;
            $this->data['to'] = $to_date;
            $from_date .=" 00:00:00";
            $to_date .= " 23:59:59";
            $hotel_id = $this->input->post('hotel_id');
            $this->data['name'] = $this->hotels_model->get_by_id($hotel_id);
            $this->load->model('amenity_model');
            $this->load->model('hotels_model');   
            $this->data['amenity'] = $this->amenity_model->type_all_report($hotel_id, $from_date, $to_date, $type);
            foreach ($this->data['amenity'] as $ke => $amen) {
              $this->data['amenity'][$ke]['items'] = $this->amenity_model->get_items($this->data['amenity'][$ke]['id']);
              foreach ($this->data['amenity'][$ke]['items'] as $keys => $item) {
                $this->data['amenity'][$ke]['items'][$keys]['amenitys'] = $this->amenity_model->get_amen($this->data['amenity'][$ke]['items'][$keys]['id']);
	      		$this->data['amenity'][$ke]['items'][$keys]['amenitys_edit'] = $this->amenity_model->get_amenity_edit($this->data['amenity'][$ke]['items'][$keys]['amen_id']);
			   	$this->data['amenity'][$ke]['items'][$keys]['room_edit'] = $this->amenity_model->get_item_edit_refl($this->data['amenity'][$ke]['items'][$keys]['amenitys_edit']['id']);
              }  
            } 
          }
          $this->load->view('amenity_type_hotel_report', $this->data);
      }
    }

}