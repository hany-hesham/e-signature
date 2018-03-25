<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  class Shop_license extends CI_Controller {

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
      $this->data['menu']['active'] = "financial";
      $this->load->model('users_model');
      $this->load->model('shop_l_model'); 
      $this->load->library('email');
     }

  public function index() {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{   
        $this->load->model('hotels_model');
        $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
        $hotels = array();
        foreach ($user_hotels as $hotel) {
          $hotels[] = $hotel['id'];
        }  
        $this->data['shop_l'] = $this->shop_l_model->view($hotels);
        foreach ($this->data['shop_l'] as $key => $row) {
          $this->data['shop_l'][$key]['approvals'] = $this->shop_l_model->get_by_verbals($this->data['shop_l'][$key]['id']);
          foreach ($this->data['shop_l'][$key]['approvals'] as $keys => $row) {
          }
        } 
        if ($this->input->post('submit')) {
          $this->data['var'] = $this->input->post('states_id');
        }
        $this->data['hotels'] = $user_hotels;
        $this->load->view('shop_license_index', $this->data);
      }
    }
   

   public function submit() {
          if ($this->input->post('submit')) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('hotel_id','Hotel Name','trim|required');
            $assumed_id = $this->input->post('assumed_id');              
            if ($this->form_validation->run() == TRUE) {
              $data = array(
                'user_id' => $this->data['user_id'],
                'ip' => $this->input->ip_address(),
                'hotel_id' => $this->input->post('hotel_id')
              );
              $shop_lid = $this->shop_l_model->create_shop_license($data);
              if ($shop_lid) {
                $this->shop_l_model->update_files($this->data['assumed_id'],$shop_lid);
              } else {
                die("ERROR");
              }
              foreach ($this->input->post('items') as $Key => $item) {
                $item['shop_lid'] = $shop_lid;  
                $item['user_id'] = $this->data['user_id'];  
                $item['ip'] = $this->input->ip_address(); 
                $file_name = $this->do_upload("items-".$Key."-fille");
                $item['fille'] = $file_name; 
                //die(print_r($item));
                $item_id = $this->shop_l_model->create_item($item);
                if (!$item_id) {
                  die("ERROR items");
                }
              }
              $signatures = $this->shop_l_model->shop_license_sign();
              $do_sign = $this->shop_l_model->shop_license_do_sign($shop_lid);
              if ($do_sign == 0) {
                foreach ($signatures as $shop_license_signature) {
                  $this->shop_l_model->add_signature($shop_lid, $shop_license_signature['role'], $shop_license_signature['department'], $shop_license_signature['rank']);
                }
              }
              redirect('/Shop_license/shop_license_stage/'.$shop_lid);
            }
          }
        try {
          $this->load->helper('form');
          $this->load->model('hotels_model');          
          $this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
          if ($this->input->post('submit')) {
            $this->data['assumed_id'] = strtoupper(str_pad(dechex( mt_rand( 0, 1048575 ) ), 5, '0', STR_PAD_LEFT));
            $this->data['uploads'] = $this->shop_l_model->get_by_fille($this->data['assumed_id']);
          } else {
            $this->data['assumed_id'] = strtoupper(str_pad(dechex( mt_rand( 0, 1048575 ) ), 5, '0', STR_PAD_LEFT));
            $this->data['uploads'] = array();
          }
          $this->load->view('shop_license_add_new',$this->data);
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
      }

    public function upload($shop_lid) {
      $file_name = $this->do_upload("upload");
      if (!$file_name) {
        die(json_encode($this->data['error']));
      } else {
        $this->shop_l_model->add_fille($shop_lid, $file_name, $this->data['user_id']);
        die("{}");
      }
    }

    public function remove($shop_lid, $id) {
      $file_name = $_POST['key'];
      if (!$id) {
        die(json_encode($this->data['error']));
      } else {
        $this->load->model("shop_l_model");
        $this->shop_l_model->remove_fille($id);
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

    public function shop_license_stage($shop_lid) {
      $this->data['shop_license'] = $this->shop_l_model->get_shop_license_by_id($shop_lid);
      if ($this->data['shop_license']['state_id'] == 0) {
        $this->shop_l_model->update_state($shop_lid, 1);
        redirect('/Shop_license/shop_license_stage/'.$shop_lid);
      }elseif ($this->data['shop_license']['state_id'] == 3){
        $user = $this->users_model->get_user_by($this->data['shop_license']['user_id']);
        $queue = $this->reject_mail($user->fullname, $user->email, $shop_lid);
      }elseif ($this->data['shop_license']['state_id'] != 2){
        $queue = $this->notify_signers($shop_lid, $this->data['shop_license']['hotel_id']);
        if (!$queue) {
          $this->shop_l_model->update_state($shop_lid, 2);
          $user = $this->users_model->get_user_by_id($this->data['shop_license']['user_id'],1);
          //$queue = $this->approvel_mail($user->fullname, $user->email, $shop_lid);
         redirect('/Shop_license/shop_license_stage/'.$shop_lid);
        }
      }
     redirect('/Shop_license/view/'.$shop_lid);
    } 

 public function view($shop_lid) {
        $this->load->model('hotels_model');   
        $this->data['shop_l'] = $this->shop_l_model->get_shop_license_by_id($shop_lid);
        $this->data['items'] = $this->shop_l_model->get_items($shop_lid);
        $this->data['uploads'] = $this->shop_l_model->get_by_fille($shop_lid);
        $this->data['comments'] = $this->shop_l_model->get_comment($shop_lid);
        $this->data['signature_path'] = '/assets/uploads/signatures/';
        $this->data['signers'] = $this->get_signers($this->data['shop_l']['id'], $this->data['shop_l']['hotel_id']);
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
          if ( $this->data['shop_l']['user_id'] == $this->data['user_id'] &&  $this->data['shop_l']['state_id'] != 2) {
            $editor = TRUE;
          }
        }
        $this->data['unsign_enable'] = ($unsign_enable )? TRUE : FALSE;
        $this->data['is_editor'] = ($editor || $this->data['is_admin'])? TRUE : FALSE;
        $this->load->view('shop_license_view', $this->data);
    }
  private function get_signers($shop_lid, $hotel_id) {
      $signatures = $this->shop_l_model->get_by_verbal($shop_lid);
      return $this->roll_signers($signatures, $hotel_id, $shop_lid);
    }

  private function roll_signers($signatures, $hotel_id, $shop_lid) {
      $signers = array();
      $this->load->model('users_model');
      $shop_license = $this->shop_l_model->get_shop_license_by_id($shop_lid);
      foreach ($signatures as $signature) {
        $signers[$signature['id']] = array();
        $signers[$signature['id']]['role'] = $signature['role'];
        $signers[$signature['id']]['role_id'] = $signature['role_id'];
        // if ($signature['rank'] == 1 ) {
        //   $signers[$signature['id']]['department'] = $out_service['department'];
        // }else{
           $signers[$signature['id']]['department'] = $signature['department'];
        // }
        $signers[$signature['id']]['department_id'] = $signature['department_id'];
        if ($signature['user_id']) {
          if ($signature['rank'] == 1){
            $this->shop_l_model->update_state($shop_lid, 4);
          }
          // }elseif ($signature['rank'] == 2){
          //   $this->shop_l_model->update_state($out_id, 5);
          // }elseif ($signature['rank'] == 3){
          //   $this->shop_l_model->update_state($out_id, 6);
          // }elseif ($signature['rank'] == 4){
          //   $this->shop_l_model->update_state($out_id, 7);
          // }elseif ($signature['rank'] == 5){
          //   $this->shop_l_model->update_state($out_id, 8);
          // }elseif ($signature['rank'] == 6){
          //   $this->shop_l_model->update_state($out_id, 9);
          // }elseif ($signature['rank'] == 7){
          //   $this->shop_l_model->update_state($out_id, 2);
          // }
          $signers[$signature['id']]['sign'] = array();
          $signers[$signature['id']]['sign']['id'] = $signature['user_id'];
          if ($signature['reject'] == 1) {
            $signers[$signature['id']]['sign']['reject'] = "reject";
            $this->shop_l_model->update_state($shop_lid, 3);
          } 
          $user = $this->users_model->get_user_by_id($signature['user_id'], TRUE);
          $signers[$signature['id']]['sign']['name'] = $user->fullname;
          $signers[$signature['id']]['sign']['mail'] = $user->email;
          $signers[$signature['id']]['sign']['sign'] = $user->signature;
          $signers[$signature['id']]['sign']['timestamp'] = $signature['timestamp'];
        } else {
          $signers[$signature['id']]['queue'] = array();
          // if ($signature['rank'] == 1 ) {
          //   $users = $this->users_model->getby_criteria($signature['role_id'], $hotel_id, $out_service['department_id']);
          // }elseif ($signature['role_id'] == 85 && $hotel_id == 5 ) {
          //   $users = $this->users_model->getby_criteria(25, $hotel_id, $signature['department_id']);
          // }else{
            $users = $this->users_model->getby_criteria($signature['role_id'], $hotel_id, $signature['department_id']);
        //  }
          foreach ($users as $use) {
            $signers[$signature['id']]['queue'][$use['id']] = array();
            $signers[$signature['id']]['queue'][$use['id']]['name'] = $use['fullname'];
            $signers[$signature['id']]['queue'][$use['id']]['mail'] = $use['email'];
          }
        }
      }
      return $signers;
    }
  private function notify_signers($shop_lid, $hotel_id) {
      $notified = FALSE;
      $signers = $this->get_signers($shop_lid, $hotel_id);
      foreach ($signers as $signer) {
        if (isset($signer['queue'])) {
          $notified = TRUE;
          foreach ($signer['queue'] as $uid => $user) {
            $this->signatures_mail($signer['role'], $signer['department'], $user['name'], $user['mail'], $shop_lid);
          }
          break;
        }
      }
      return $notified;
    } 
 private function signatures_mail($role, $department, $name, $mail, $shop_lid) {
      $this->load->library('email');
      $this->load->helper('url');
      $shop_l_url = base_url().'Shop_license/view/'.$shop_lid;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($mail);
      $this->email->subject("Tenants Shop License Form No. #{$shop_lid}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
       Tenants Shop License Form No. #{$shop_lid} requires your signature, Please use the link below:
        <br/>
        <a href='{$shop_l_url}' target='_blank'>{$shop_l_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
    } 
  public function mail_me($shop_lid) {
      $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
      $this->load->library('email');
      $this->load->helper('url');
      $out_url = base_url().'Shop_license/view/'.$shop_lid;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($user->email);
      $this->email->subject("Tenants Shop License Form No. #{$shop_lid}");
      $this->email->message("Tenants Shop License Form No. #{$shop_lid}:
        <br/>
        Please use the link below to view The Tenants Shop License Form:
         <br/>
        <a href='{$out_url}' target='_blank'>{$out_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
      redirect('Shop_license/view/'.$shop_lid);
    } 
  public function mail($shop_lid) {
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
          $out_url = base_url().'Shop_license/view/'.$shop_lid;
          $this->email->from('e-signature@sunrise-resorts.com');
          $this->email->to($email);
          $this->email->subject("A message from {$user->fullname}, ");
          $this->email->message("{$user->fullname} sent you a private message:
            <br/>
            {$message}
            <br />
            <br />
            Please use the link below to view the Tenants Shop License Form:
            <br />
            <br />
            <a href='{$out_url}' target='_blank'>{$out_url}</a>
            <br/>
          "); 
          $mail_result = $this->email->send();
        }
      }
      redirect('Shop_license/view/'.$shop_lid);
    } 

  private function approvel_mail($name, $email, $shop_lid) {
      $this->load->library('email');
      $this->load->helper('url');
      $out_url = base_url().'Shop_license/view/'.$shop_lid;
      $this->email->from('e-signature@sunrise-resorts.com');
      $this->email->to($email);
      $this->email->subject("Tenants Shop License Form No. #{$shop_lid}");
      $this->email->message("Dear {$name},
        <br/>
        <br/>
       Tenants Shop License Form No. #{$shop_lid} has been approved, Please use the link below:
        <br/>
        <a href='{$out_url}' target='_blank'>{$out_url}</a>
        <br/>
      "); 
      $mail_result = $this->email->send();
    } 

 public function unsign($signature_id) {
      $this->load->model('users_model');
      $signature_identity = $this->shop_l_model->get_signature_identity($signature_id);
      $this->shop_l_model->unsign($signature_id);
      $this->shop_l_model->update_state($signature_identity['shop_lid'], 1);
      redirect('/Shop_license/shop_license_stage/'.$signature_identity['shop_lid']);  
    }

  public function sign($signature_id, $reject = FALSE) {

      $signature_identity = $this->shop_l_model->get_signature_identity($signature_id);
      $signrs = $this->get_signers($signature_identity['shop_lid'], $signature_identity['hotel_id']);
      if (array_key_exists($this->data['user_id'], $signrs[$signature_id]['queue'])) {
        if ($reject) {
          $this->shop_l_model->reject($signature_id, $this->data['user_id']);
          redirect('/Shop_license/shop_license_stage/'.$signature_identity['shop_lid']);  
        } else {
          $this->shop_l_model->sign($signature_id, $this->data['user_id']);
          //die(print_r($signature_id));
          redirect('/Shop_license/shop_license_stage/'.$signature_identity['shop_lid']);  
        }
      }
      redirect('/Shop_license/view/'.$signature_identity['shop_lid']);
    }

  public function edit($shop_lid) {
      if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
      }else{
        if ($this->input->post('submit')) {
          $this->load->library('form_validation');
          $this->load->library('email');
          $this->form_validation->set_rules('hotel_id','Hotel Name','trim|required');
          if ($this->form_validation->run() == TRUE) {
            $this->load->model('users_model');  
            $form_data = array(
              'hotel_id' => $this->input->post('hotel_id')
            );
            $this->shop_l_model->update_shop_license($shop_lid, $form_data);
            foreach ($this->input->post('items') as $Key => $item) {
              $item['shop_lid'] = $shop_lid;  
              $item['user_id'] = $this->data['user_id'];  
              $item['ip'] = $this->input->ip_address();
              $file_name = $this->do_upload("items-".$Key."-fille");
              if ($file_name) {
                $item['fille'] = $file_name;  
              }
              $this->shop_l_model->update_item($item['id'], $shop_lid, $item);
            }
            redirect('/Shop_license/view/'.$shop_lid);
          }   
        }
        try {
          $this->load->helper('form');
          $this->load->model('hotels_model');
          $this->data['shop_l'] = $this->shop_l_model->get_shop_license_by_id($shop_lid);
          $this->data['items'] = $this->shop_l_model->get_items($shop_lid);
          $this->data['uploads'] = $this->shop_l_model->get_by_fille($shop_lid);          
          $this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
          $this->load->view('shop_license_edit',$this->data);
        }
        catch( Exception $e) {
          show_error($e->getMessage()." _ ". $e->getTraceAsString());
        }
      }
    }

  public function comment($shop_lid){
      if ($this->input->post('submit')) {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('comment','Comment','trim|required');
        if ($this->form_validation->run() == TRUE) {
          $comment = $this->input->post('comment');
          $comment_data = array(
            'user_id' => $this->data['user_id'],
            'shop_lid' => $shop_lid,
            'comment' => $comment
          );
          $this->shop_l_model->insert_comment($comment_data);
        }
        redirect('/Shop_license/view/'.$shop_lid);
      }
    } 
 



}