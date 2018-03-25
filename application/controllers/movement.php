<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  class movement extends CI_Controller {

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
      $this->data['menu']['active'] = "movement";
    }

    public function submit() {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        if ($this->input->post('submit')) {
          $this->load->library('form_validation');
          $this->load->library('email');
          $this->form_validation->set_rules('from_hotel','From hotel','trim|required');
          $this->form_validation->set_rules('to_hotel','To hotel','trim|required');
          $this->form_validation->set_rules('issue_date','Issue date','trim|required');
          $this->form_validation->set_rules('delivery_date','Delivery date','trim|required');
          $this->form_validation->set_rules('department_id','Request Department','trim|required');
          $this->form_validation->set_rules('items','Items','required');
          $this->form_validation->set_rules('present_location','Present location','trim|required');
          $this->form_validation->set_rules('movement_reason','Movement reason','trim|required');
          $this->form_validation->set_rules('old_reason','Old Movement','trim|required');
          $this->form_validation->set_rules('new_location','New location','trim|required');
          $assumed_id = $this->input->post('assumed_id');                        
          if ($this->form_validation->run() == TRUE) {
            $this->load->model('movement_model');
            $this->load->model('users_model');  
            $data = array(
              'ip' => $this->input->ip_address(),
              'user_id' => $this->data['user_id'],
              'from_hotel' => $this->input->post('from_hotel'),
              'to_hotel' => $this->input->post('to_hotel'),
              'issue_date' => $this->input->post('issue_date'),
              'delivery_date' => $this->input->post('delivery_date'),
              'department_id' => $this->input->post('department_id'),
              'present_location' => $this->input->post('present_location'),
              'movement_reason' => $this->input->post('movement_reason'),
              'old_reason' => $this->input->post('old_reason'),
              'new_location' => $this->input->post('new_location')
            );
            $move_id = $this->movement_model->create_movement($data);
            if ($move_id) {
              $this->movement_model->update_files($assumed_id,$move_id);
            } else {
              die("ERROR");
            }
            foreach ($this->input->post('items') as $Key => $item) {
              $item['move_id'] = $move_id;  
              $item['user_id'] = $this->data['user_id'];  
              $item['ip'] = $this->input->ip_address();  
              $file_name = $this->do_upload("items-".$Key."-fille");
              $item['fille'] = $file_name;  
              $item_id = $this->movement_model->create_item($item);
              if (!$item_id) {
                die("ERROR");
              }
            }
            $signatures_hotel = $this->movement_model->movement_sign_hotel();
            $do_sign_to = $this->movement_model->movement_do_sign_to($move_id);
            if ($do_sign_to == 0) {
              foreach ($signatures_hotel as $movement_signature) {
                $this->movement_model->add_signature_to($move_id, $movement_signature['role'], $movement_signature['department'], $movement_signature['rank']);
              }
            }
            $do_sign_from = $this->movement_model->movement_do_sign_from($move_id);
            if ($do_sign_from == 0) {
              foreach ($signatures_hotel as $movement_signature) {
                $this->movement_model->add_signature_from($move_id, $movement_signature['role'], $movement_signature['department'], $movement_signature['rank']);
              }
            }
            $signatures_final = $this->movement_model->movement_sign_final();
            $do_sign_final = $this->movement_model->movement_do_sign_final($move_id);
            if ($do_sign_final == 0) {
              foreach ($signatures_final as $movement_signature) {
                $this->movement_model->add_signature_final($move_id, $movement_signature['role'], $movement_signature['department'], $movement_signature['rank']);
              }
            }
            $signatures_owning = $this->movement_model->movement_sign_owning();
            $do_sign_owning = $this->movement_model->movement_do_sign_owning($move_id);
            if ($do_sign_owning == 0) {
              foreach ($signatures_owning as $movement_signature) {
                $this->movement_model->add_signature_owning($move_id, $movement_signature['role'], $movement_signature['department'], $movement_signature['rank']);
              }
            }
            $signatures_assets = $this->movement_model->movement_sign_assets();
            $do_sign_assets = $this->movement_model->movement_do_sign_assets($move_id);
            if ($do_sign_assets == 0) {
              foreach ($signatures_assets as $movement_signature) {
                $this->movement_model->add_signature_assets($move_id, $movement_signature['role'], $movement_signature['department'], $movement_signature['rank']);
              }
            }
            redirect('/movement/movement_stage_to/'.$move_id);
          }
        }
        try {
          $this->load->helper('form');
          $this->load->model('movement_model');
          $this->load->model('hotels_model');
          $this->load->model('companies_model');
          $this->load->model('departments_model');
          $this->load->model('roles_model');
          $this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
          $this->data['companies'] = $this->companies_model->getall();
          $this->data['departments'] = $this->departments_model->getall();          
          if ($this->input->post('submit')) {
            $this->data['assumed_id'] = mt_rand("1048575","10485751048575");
            $this->data['uploads'] = $this->movement_model->get_by_fille($this->data['assumed_id']);
          } else {
            $this->data['assumed_id'] = mt_rand("1048575","10485751048575");
            $this->data['uploads'] = array();
          }
          $this->load->view('movement_add_new',$this->data);
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
      }
    }

    public function upload($move_id) {
      $file_name = $this->do_upload("upload");
      if (!$file_name) {
        die(json_encode($this->data['error']));
      } else {
        $this->load->model("movement_model");
        $this->movement_model->add_fille($move_id, $file_name, $this->data['user_id']);
        die("{}");
      }
    }

    public function remove($move_id, $id) {
      $file_name = $_POST['key'];
      if (!$id) {
        die(json_encode($this->data['error']));
      } else {
        $this->load->model("movement_model");
        $this->movement_model->remove_fille($id);
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

    public function movement_stage_to($move_id) {
      $this->load->model('movement_model');
      $this->data['movement'] = $this->movement_model->get_movement($move_id);
      if ($this->data['movement']['state_id'] == 0) {
        $this->movement_model->update_state($move_id, 1);
        redirect('/movement/movement_stage_to/'.$move_id);
      }elseif ($this->data['movement']['state_id'] == 3){
        $user = $this->users_model->get_user_by_id($this->data['movement']['user_id'], TRUE);
        $queue = $this->reject_mail_to($user->fullname, $user->email, $move_id);
      }elseif ($this->data['movement']['state_id'] != 2){
        $queue = $this->notify_signers_to($move_id, $this->data['movement']['to_hotel']);
        if (!$queue) {
          $this->movement_model->update_state($move_id, 2);
          $user = $this->users_model->get_user_by_id($this->data['movement']['user_id'], TRUE);
          $queue = $this->approvel_mail_to($user->fullname, $user->email, $move_id);
          redirect('/movement/movement_stage_from/'.$move_id);
        }
      }
      redirect('/movement/view/'.$move_id);
    }

    private function reject_mail_to($name, $email, $move_id) {
      $this->load->library('email');
      $this->load->helper('url');
      $move_url = base_url().'movement/view/'.$move_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($email);
      $this->email->subject("Assets Movment Form No. #{$move_id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
        Assets Movment Form No. #{$move_id} has been rejected By The Requsted Hotel, Please use the link below:
        <br/>
        <a href='{$move_url}' target='_blank'>{$move_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
    }

    private function notify_signers_to($move_id, $hotel_id) {
      $notified = FALSE;
      $signers = $this->get_to_signers($move_id, $hotel_id);
      foreach ($signers as $signer) {
        if (isset($signer['queue'])) {
          $notified = TRUE;
          foreach ($signer['queue'] as $uid => $user) {
            $this->signatures_to_mail($signer['role'], $signer['department'], $user['name'], $user['mail'], $move_id);
          }
          break;
        }
      }
      return $notified;
    }

    private function get_to_signers($move_id, $hotel_id) {
      $this->load->model('movement_model');
      $signatures = $this->movement_model->get_to_by_verbal($move_id);
      return $this->roll_to_signers($signatures, $hotel_id, $move_id);
    }

    private function roll_to_signers($signatures, $hotel_id, $move_id) {
      $signers = array();
      $this->load->model('users_model');
      $this->load->model('movement_model');
      $movement = $this->movement_model->get_movement($move_id);
      foreach ($signatures as $signature) {
        $signers[$signature['id']] = array();
        $signers[$signature['id']]['role'] = $signature['role'];
        $signers[$signature['id']]['role_id'] = $signature['role_id'];
        if ($signature['rank'] == 1 ) {
          $signers[$signature['id']]['department'] = $movement['department'];
        }else{
          $signers[$signature['id']]['department'] = $signature['department'];
        }
        $signers[$signature['id']]['department_id'] = $signature['department_id'];
        if ($signature['user_id']) {
          $signers[$signature['id']]['sign'] = array();
          $signers[$signature['id']]['sign']['id'] = $signature['user_id'];
          if ($signature['reject'] == 1) {
            $signers[$signature['id']]['sign']['reject'] = "reject";
            $this->movement_model->update_state($move_id, 3);
          } 
          $user = $this->users_model->get_user_by_id($signature['user_id'], TRUE);
          $signers[$signature['id']]['sign']['name'] = $user->fullname;
          $signers[$signature['id']]['sign']['mail'] = $user->email;
          $signers[$signature['id']]['sign']['sign'] = $user->signature;
          $signers[$signature['id']]['sign']['timestamp'] = $signature['timestamp'];
        } else {
          $signers[$signature['id']]['queue'] = array();
          if ($signature['rank'] == 1 ) {
            $users = $this->users_model->getby_criteria($signature['role_id'], $hotel_id, $movement['department_id']);
          }else{
            $users = $this->users_model->getby_criteria($signature['role_id'], $hotel_id, $signature['department_id']);
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

    private function signatures_to_mail($role, $department, $name, $mail, $move_id) {
      $this->load->library('email');
      $this->load->helper('url');
      $move_url = base_url().'movement/view/'.$move_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($mail);
      $this->email->subject("Assets Movment Form No. #{$move_id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
        Assets Movment Form No. #{$move_id} requires your signature as Requsted Hotel, Please use the link below:
        <br/>
        <a href='{$move_url}' target='_blank'>{$move_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
    }

    private function approvel_mail_to($name, $email, $move_id) {
      $this->load->library('email');
      $this->load->helper('url');
      $move_url = base_url().'movement/view/'.$move_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($email);
      $this->email->subject("Assets Movment Form No. #{$move_id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
        Assets Movment Form No. #{$move_id} has been approved By The Requsted Hotel, Please use the link below:
        <br/>
        <a href='{$move_url}' target='_blank'>{$move_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
    }

    public function movement_stage_from($move_id) {
      $this->load->model('movement_model');
      $this->data['movement'] = $this->movement_model->get_movement($move_id);
      if ($this->data['movement']['state_id'] == 2) {
        $this->movement_model->update_state($move_id, 4);
        redirect('/movement/movement_stage_from/'.$move_id);
      }elseif ($this->data['movement']['state_id'] == 6){
        $user = $this->users_model->get_user_by_id($this->data['movement']['user_id'], TRUE);
        $queue = $this->reject_mail_from($user->fullname, $user->email, $move_id);
      }elseif ($this->data['movement']['state_id'] != 5){
        $queue = $this->notify_signers_from($move_id, $this->data['movement']['from_hotel']);
        if (!$queue) {
          $this->movement_model->update_state($move_id, 5);
          $user = $this->users_model->get_user_by_id($this->data['movement']['user_id'], TRUE);
          $queue = $this->approvel_mail_from($user->fullname, $user->email, $move_id);
          redirect('/movement/movement_stage_final/'.$move_id);
        }
      }
      redirect('/movement/view/'.$move_id);
    }

    private function reject_mail_from($name, $email, $move_id) {
      $this->load->library('email');
      $this->load->helper('url');
      $move_url = base_url().'movement/view/'.$move_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($email);
      $this->email->subject("Assets Movment Form No. #{$move_id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
        Assets Movment Form No. #{$move_id} has been rejected By The Original Hotel, Please use the link below:
        <br/>
        <a href='{$move_url}' target='_blank'>{$move_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
    }

    private function notify_signers_from($move_id, $hotel_id) {
      $notified = FALSE;
      $signers = $this->get_from_signers($move_id, $hotel_id);
      foreach ($signers as $signer) {
        if (isset($signer['queue'])) {
          $notified = TRUE;
          foreach ($signer['queue'] as $uid => $user) {
            $this->signatures_from_mail($signer['role'], $signer['department'], $user['name'], $user['mail'], $move_id);
          }
          break;
        }
      }
      return $notified;
    }

    private function get_from_signers($move_id, $hotel_id) {
      $this->load->model('movement_model');
      $signatures = $this->movement_model->get_from_by_verbal($move_id);
      return $this->roll_from_signers($signatures, $hotel_id, $move_id);
    }

    private function roll_from_signers($signatures, $hotel_id, $move_id) {
      $signers = array();
      $this->load->model('users_model');
      $this->load->model('movement_model');
      $movement = $this->movement_model->get_movement($move_id);
      foreach ($signatures as $signature) {
        $signers[$signature['id']] = array();
        $signers[$signature['id']]['role'] = $signature['role'];
        $signers[$signature['id']]['role_id'] = $signature['role_id'];
        if ($signature['rank'] == 1 ) {
          $signers[$signature['id']]['department'] = $movement['department'];
        }else{
          $signers[$signature['id']]['department'] = $signature['department'];
        }
        $signers[$signature['id']]['department_id'] = $signature['department_id'];
        if ($signature['user_id']) {
          $signers[$signature['id']]['sign'] = array();
          $signers[$signature['id']]['sign']['id'] = $signature['user_id'];
          if ($signature['reject'] == 1) {
            $signers[$signature['id']]['sign']['reject'] = "reject";
            $this->movement_model->update_state($move_id, 6);
          } 
          $user = $this->users_model->get_user_by_id($signature['user_id'], TRUE);
          $signers[$signature['id']]['sign']['name'] = $user->fullname;
          $signers[$signature['id']]['sign']['mail'] = $user->email;
          $signers[$signature['id']]['sign']['sign'] = $user->signature;
          $signers[$signature['id']]['sign']['timestamp'] = $signature['timestamp'];
        } else {
          $signers[$signature['id']]['queue'] = array();
          if ($signature['rank'] == 1 ) {
            $users = $this->users_model->getby_criteria($signature['role_id'], $hotel_id, $movement['department_id']);
          }else{
            $users = $this->users_model->getby_criteria($signature['role_id'], $hotel_id, $signature['department_id']);
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

    private function signatures_from_mail($role, $department, $name, $mail, $move_id) {
      $this->load->library('email');
      $this->load->helper('url');
      $move_url = base_url().'movement/view/'.$move_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($mail);
      $this->email->subject("Assets Movment Form No. #{$move_id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
        Assets Movment Form No. #{$move_id} requires your signature as Original Hotel, Please use the link below:
        <br/>
        <a href='{$move_url}' target='_blank'>{$move_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
    }

    private function approvel_mail_from($name, $email, $move_id) {
      $this->load->library('email');
      $this->load->helper('url');
      $move_url = base_url().'movement/view/'.$move_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($email);
      $this->email->subject("Assets Movment Form No. #{$move_id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
        Assets Movment Form No. #{$move_id} has been approved By The Original Hotel, Please use the link below:
        <br/>
        <a href='{$move_url}' target='_blank'>{$move_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
    }

    public function movement_stage_final($move_id) {
      $this->load->model('movement_model');
      $this->data['movement'] = $this->movement_model->get_movement($move_id);
      if ($this->data['movement']['state_id'] == 5) {
        $this->movement_model->update_state($move_id, 7);
        redirect('/movement/movement_stage_final/'.$move_id);
      }elseif ($this->data['movement']['state_id'] == 9){
        $user = $this->users_model->get_user_by_id($this->data['movement']['user_id'], TRUE);
        $queue = $this->reject_mail_final($user->fullname, $user->email, $move_id);
      }elseif ($this->data['movement']['state_id'] != 8){
        $queue = $this->notify_signers_final($move_id, $this->data['movement']['to_hotel']);
        if (!$queue) {
          $this->movement_model->update_state($move_id, 8);
          $user = $this->users_model->get_user_by_id($this->data['movement']['user_id'], TRUE);
          $queue = $this->approvel_mail_final($user->fullname, $user->email, $move_id);
          redirect('/movement/movement_stage_final/'.$move_id);
        }
      }
      redirect('/movement/view/'.$move_id);
    }

    private function reject_mail_final($name, $email, $move_id) {
      $this->load->library('email');
      $this->load->helper('url');
      $move_url = base_url().'movement/view/'.$move_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($email);
      $this->email->subject("Assets Movment Form No. #{$move_id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
        Assets Movment Form No. #{$move_id} has been rejected By The Board, Please use the link below:
        <br/>
        <a href='{$move_url}' target='_blank'>{$move_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
    }

    private function notify_signers_final($move_id, $hotel_id) {
      $notified = FALSE;
      $signers = $this->get_final_signers($move_id, $hotel_id);
      foreach ($signers as $signer) {
        if (isset($signer['queue'])) {
          $notified = TRUE;
          foreach ($signer['queue'] as $uid => $user) {
            $this->signatures_final_mail($signer['role'], $signer['department'], $user['name'], $user['mail'], $move_id);
          }
          break;
        }
      }
      return $notified;
    }

    private function get_final_signers($move_id, $hotel_id) {
      $this->load->model('movement_model');
      $signatures = $this->movement_model->get_final_by_verbal($move_id);
      return $this->roll_final_signers($signatures, $hotel_id, $move_id);
    }

    private function roll_final_signers($signatures, $hotel_id, $move_id) {
      $signers = array();
      $this->load->model('users_model');
      $this->load->model('movement_model');
      $movement = $this->movement_model->get_movement($move_id);
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
            $this->movement_model->update_state($move_id, 9);
          } 
          $user = $this->users_model->get_user_by_id($signature['user_id'], TRUE);
          $signers[$signature['id']]['sign']['name'] = $user->fullname;
          $signers[$signature['id']]['sign']['mail'] = $user->email;
          $signers[$signature['id']]['sign']['sign'] = $user->signature;
          $signers[$signature['id']]['sign']['timestamp'] = $signature['timestamp'];
        } else {
          $signers[$signature['id']]['queue'] = array();
          $users = $this->users_model->getby_criteria($signature['role_id'], $hotel_id, $signature['department_id']);
          foreach ($users as $use) {
            $signers[$signature['id']]['queue'][$use['id']] = array();
            $signers[$signature['id']]['queue'][$use['id']]['name'] = $use['fullname'];
            $signers[$signature['id']]['queue'][$use['id']]['mail'] = $use['email'];
          }
        }
      }
      return $signers;
    }

    private function signatures_final_mail($role, $department, $name, $mail, $move_id) {
      $this->load->library('email');
      $this->load->helper('url');
      $move_url = base_url().'movement/view/'.$move_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($mail);
      $this->email->subject("Assets Movment Form No. #{$move_id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
        Assets Movment Form No. #{$move_id} requires your signature as Board, Please use the link below:
        <br/>
        <a href='{$move_url}' target='_blank'>{$move_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
    }

    private function approvel_mail_final($name, $email, $move_id) {
      $this->load->library('email');
      $this->load->helper('url');
      $move_url = base_url().'movement/view/'.$move_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($email);
      $this->email->subject("Assets Movment Form No. #{$move_id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
        Assets Movment Form No. #{$move_id} has been approved By The Board, Please use the link below:
        <br/>
        <a href='{$move_url}' target='_blank'>{$move_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
    }

    public function movement_stage_owning($move_id) {
      $this->load->model('movement_model');
      $this->data['movement'] = $this->movement_model->get_movement($move_id);
      if ($this->data['movement']['state_id'] == 8) {
        $this->movement_model->update_state($move_id, 10);
        redirect('/movement/movement_stage_owning/'.$move_id);
      }elseif ($this->data['movement']['state_id'] == 12){
        $user = $this->users_model->get_user_by_id($this->data['movement']['user_id'], TRUE);
        $queue = $this->reject_mail_owning($user->fullname, $user->email, $move_id);
      }elseif ($this->data['movement']['state_id'] != 11){
        $queue = $this->notify_signers_owning($move_id, $this->data['movement']['to_hotel']);
        if (!$queue) {
          $this->movement_model->update_state($move_id, 11);
          $user = $this->users_model->get_user_by_id($this->data['movement']['user_id'], TRUE);
          $queue = $this->approvel_mail_owning($user->fullname, $user->email, $move_id);
          redirect('/movement/movement_stage_owning/'.$move_id);
        }
      }
      redirect('/movement/view/'.$move_id);
    }

    private function reject_mail_owning($name, $email, $move_id) {
      $this->load->library('email');
      $this->load->helper('url');
      $move_url = base_url().'movement/view/'.$move_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($email);
      $this->email->subject("Assets Movment Form No. #{$move_id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
        Assets Movment Form No. #{$move_id} has been rejected By The Owning Company, Please use the link below:
        <br/>
        <a href='{$move_url}' target='_blank'>{$move_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
    }

    private function notify_signers_owning($move_id, $hotel_id) {
      $notified = FALSE;
      $signers = $this->get_owning_signers($move_id, $hotel_id);
      foreach ($signers as $signer) {
        if (isset($signer['queue'])) {
          $notified = TRUE;
          foreach ($signer['queue'] as $uid => $user) {
            $this->signatures_owning_mail($signer['role'], $signer['department'], $user['name'], $user['mail'], $move_id);
          }
          break;
        }
      }
      return $notified;
    }

    private function get_owning_signers($move_id, $hotel_id) {
      $this->load->model('movement_model');
      $signatures = $this->movement_model->get_owning_by_verbal($move_id);
      return $this->roll_owning_signers($signatures, $hotel_id, $move_id);
    }

    private function roll_owning_signers($signatures, $hotel_id, $move_id) {
      $signers = array();
      $this->load->model('users_model');
      $this->load->model('movement_model');
      $movement = $this->movement_model->get_movement($move_id);
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
            $this->movement_model->update_state($move_id, 12);
          } 
          $user = $this->users_model->get_user_by_id($signature['user_id'], TRUE);
          $signers[$signature['id']]['sign']['name'] = $user->fullname;
          $signers[$signature['id']]['sign']['mail'] = $user->email;
          $signers[$signature['id']]['sign']['sign'] = $user->signature;
          $signers[$signature['id']]['sign']['timestamp'] = $signature['timestamp'];
        } else {
          $signers[$signature['id']]['queue'] = array();
          $users = $this->users_model->getby_criteria($signature['role_id'], $hotel_id, $signature['department_id']);
          foreach ($users as $use) {
            $signers[$signature['id']]['queue'][$use['id']] = array();
            $signers[$signature['id']]['queue'][$use['id']]['name'] = $use['fullname'];
            $signers[$signature['id']]['queue'][$use['id']]['mail'] = $use['email'];
          }
        }
      }
      return $signers;
    }

    private function signatures_owning_mail($role, $department, $name, $mail, $move_id) {
      $this->load->library('email');
      $this->load->helper('url');
      $move_url = base_url().'movement/view/'.$move_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($mail);
      $this->email->subject("Assets Movment Form No. #{$move_id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
        Assets Movment Form No. #{$move_id} requires your signature as Owning Company, Please use the link below:
        <br/>
        <a href='{$move_url}' target='_blank'>{$move_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
    }

    private function approvel_mail_owning($name, $email, $move_id) {
      $this->load->library('email');
      $this->load->helper('url');
      $move_url = base_url().'movement/view/'.$move_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($email);
      $this->email->subject("Assets Movment Form No. #{$move_id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
        Assets Movment Form No. #{$move_id} has been approved By The Owning Company, Please use the link below:
        <br/>
        <a href='{$move_url}' target='_blank'>{$move_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
    }

    public function movement_stage_assets($move_id) {
      $this->load->model('movement_model');
      $this->data['movement'] = $this->movement_model->get_movement($move_id);
      if ($this->data['movement']['state_id'] == 11) {
        $this->movement_model->update_state($move_id, 13);
        redirect('/movement/movement_stage_assets/'.$move_id);
      }elseif ($this->data['movement']['state_id'] == 15){
        $user = $this->users_model->get_user_by_id($this->data['movement']['user_id'], TRUE);
        $queue = $this->reject_mail_assets($user->fullname, $user->email, $move_id);
      }elseif ($this->data['movement']['state_id'] != 14){
        $queue = $this->notify_signers_assets($move_id, $this->data['movement']['to_hotel']);
        if (!$queue) {
          $this->movement_model->update_state($move_id, 14);
          $user = $this->users_model->get_user_by_id($this->data['movement']['user_id'], TRUE);
          $queue = $this->approvel_mail_assets($user->fullname, $user->email, $move_id);
          redirect('/movement/movement_stage_assets/'.$move_id);
        }
      }
      redirect('/movement/view/'.$move_id);
    }

    private function reject_mail_assets($name, $email, $move_id) {
      $this->load->library('email');
      $this->load->helper('url');
      $move_url = base_url().'movement/view/'.$move_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($email);
      $this->email->subject("Assets Movment Form No. #{$move_id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
        Assets Movment Form No. #{$move_id} has been rejected By The Owning Company MD, Please use the link below:
        <br/>
        <a href='{$move_url}' target='_blank'>{$move_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
    }

    private function notify_signers_assets($move_id, $hotel_id) {
      $notified = FALSE;
      $signers = $this->get_assets_signers($move_id, $hotel_id);
      foreach ($signers as $signer) {
        if (isset($signer['queue'])) {
          $notified = TRUE;
          foreach ($signer['queue'] as $uid => $user) {
            $this->signatures_final_mail($signer['role'], $signer['department'], $user['name'], $user['mail'], $move_id);
          }
          break;
        }
      }
      return $notified;
    }

    private function get_assets_signers($move_id, $hotel_id) {
      $this->load->model('movement_model');
      $signatures = $this->movement_model->get_assets_by_verbal($move_id);
      return $this->roll_assets_signers($signatures, $hotel_id, $move_id);
    }

    private function roll_assets_signers($signatures, $hotel_id, $move_id) {
      $signers = array();
      $this->load->model('users_model');
      $this->load->model('movement_model');
      $movement = $this->movement_model->get_movement($move_id);
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
            $this->movement_model->update_state($move_id, 15);
          } 
          $user = $this->users_model->get_user_by_id($signature['user_id'], TRUE);
          $signers[$signature['id']]['sign']['name'] = $user->fullname;
          $signers[$signature['id']]['sign']['mail'] = $user->email;
          $signers[$signature['id']]['sign']['sign'] = $user->signature;
          $signers[$signature['id']]['sign']['timestamp'] = $signature['timestamp'];
        } else {
          $signers[$signature['id']]['queue'] = array();
          $users = $this->users_model->getby_criteria($signature['role_id'], $hotel_id, $signature['department_id']);
          foreach ($users as $use) {
            $signers[$signature['id']]['queue'][$use['id']] = array();
            $signers[$signature['id']]['queue'][$use['id']]['name'] = $use['fullname'];
            $signers[$signature['id']]['queue'][$use['id']]['mail'] = $use['email'];
          }
        }
      }
      return $signers;
    }

    private function signatures_assets_mail($role, $department, $name, $mail, $move_id) {
      $this->load->library('email');
      $this->load->helper('url');
      $move_url = base_url().'movement/view/'.$move_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($mail);
      $this->email->subject("Assets Movment Form No. #{$move_id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
        Assets Movment Form No. #{$move_id} requires your signature as Owning Company MD, Please use the link below:
        <br/>
        <a href='{$move_url}' target='_blank'>{$move_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
    }

    private function approvel_mail_assets($name, $email, $move_id) {
      $this->load->library('email');
      $this->load->helper('url');
      $move_url = base_url().'movement/view/'.$move_id;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($email);
      $this->email->subject("Assets Movment Form No. #{$move_id}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
        Assets Movment Form No. #{$move_id} has been approved By The Owning Company MD, Please use the link below:
        <br/>
        <a href='{$move_url}' target='_blank'>{$move_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
    }

    public function view($move_id) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        $this->load->model('movement_model');
        $this->data['movement'] = $this->movement_model->get_movement($move_id);
        $this->data['items'] = $this->movement_model->get_items($move_id);
        $this->data['uploads'] = $this->movement_model->get_by_fille($move_id);
        $this->data['comments'] = $this->movement_model->get_comment($move_id);
        $this->data['signature_path'] = '/assets/uploads/signatures/';
        $this->data['signers_from'] = $this->get_from_signers($this->data['movement']['id'], $this->data['movement']['from_hotel']);
        $this->data['signers_to'] = $this->get_to_signers($this->data['movement']['id'], $this->data['movement']['to_hotel']);
        $this->data['signers_final'] = $this->get_final_signers($this->data['movement']['id'], $this->data['movement']['to_hotel']);
        $editor = FALSE;
        $unsign_from_enable = FALSE;
        $unsign_to_enable = FALSE;
        $unsign_final_enable = FALSE;
        foreach ($this->data['signers_from'] as $signer) {
          if (isset($signer['sign'])) {
            $unsign_from_enable = FALSE;
            if ($signer['sign']['id'] == $this->data['user_id']) {
              $unsign_from_enable = TRUE;
            }
          }
        }
        foreach ($this->data['signers_to'] as $signer) {
          if (isset($signer['sign'])) {
            $unsign_to_enable = FALSE;
            if ($signer['sign']['id'] == $this->data['user_id']) {
              $unsign_to_enable = TRUE;
            }
          }
        }
        foreach ($this->data['signers_final'] as $signer) {
          if (isset($signer['sign'])) {
            $unsign_final_enable = FALSE;
            if ($signer['sign']['id'] == $this->data['user_id']) {
              $unsign_final_enable = TRUE;
            }
          }
        }
        if (isset($this->data['user_id'])) {
          if ( $this->data['movement']['user_id'] == $this->data['user_id'] &&  $this->data['movement']['state_id'] != 14) {
            $editor = TRUE;
          }
        }
        $this->data['unsign_enable_from'] = (($unsign_from_enable) || $this->data['is_admin'])? TRUE : FALSE;
        $this->data['unsign_enable_to'] = (($unsign_to_enable) || $this->data['is_admin'])? TRUE : FALSE;
        $this->data['unsign_enable_final'] = (($unsign_final_enable) || $this->data['is_admin'])? TRUE : FALSE;
        $this->data['is_editor'] = ($editor || $this->data['is_admin'])? TRUE : FALSE;
        $this->load->view('movement_view', $this->data);
      }
    }

  }

?>