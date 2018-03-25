<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Workshop_reports extends CI_Controller {

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
			$this->data['menu']['active'] = "workshop_report";
		}

		public function _remap($method, $params = array()){
			if(is_numeric($method)) {
				$this->index($method);
			} else {
			    if (method_exists($this, $method)){
			        return call_user_func_array(array($this, $method), $params);
			    }
		    	show_404();
			}
		}

		public function all_requests() {
			$this->load->helper('form');
			$this->load->model('hotels_model');
			$this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
			if ($this->input->post('submit')) {
				$hotel = $this->input->post('hotel');
				$state = $this->input->post('state');
				if ($state == 1) {
					$states = array($state);
				} else if ($state == 0) {
					$states = array($state);
				} else {
					$states = array(1,0);
				}
				$from_date = $this->input->post('from');
				$to_date = $this->input->post('to');
				$from_date .="-01 00:00:00";
				$to_date .= "-31 23:59:59";
				$this->load->model('workshop_reports_model');
				$this->load->model('workshop_request_items_model');
				$workshop_requests = $this->workshop_reports_model->get_requests($states, $hotel, $from_date, $to_date);
				$this->data['workshop_requests'] = $workshop_requests;
				foreach ($this->data['workshop_requests'] as $key => $requests) {
					$this->data['workshop_requests'][$key]['items'] = $this->workshop_request_items_model->get_request_items($this->data['workshop_requests'][$key]['id']);
				}
				$this->data['posting'] = TRUE;
			}
			$this->load->view('workshop_report', $this->data);
		}

		public function all_reports() {
			$this->load->helper('form');
			$this->load->model('hotels_model');
			$this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
			if ($this->input->post('submit')) {
				$state = $this->input->post('state');
				if ($state == 1) {
					$states = array($state);
				} else if ($state == 0) {
					$states = array($state);
				} else {
					$states = array(1,0);
				}
				$from_date = $this->input->post('from');
				$to_date = $this->input->post('to');
				$from_date .="-01 00:00:00";
				$to_date .= "-31 23:59:59";
				$this->load->model('workshop_reports_model');
				$this->load->model('workshop_request_items_model');
				$workshop_requests = $this->workshop_reports_model->get_all_requests($states, $from_date, $to_date);
				$this->data['workshop_requests'] = $workshop_requests;
				foreach ($this->data['workshop_requests'] as $key => $requests) {
					$this->data['workshop_requests'][$key]['items'] = $this->workshop_request_items_model->get_request_items($this->data['workshop_requests'][$key]['id']);
				}
				$this->data['posting'] = TRUE;
			}
			$this->load->view('workshop_allreport', $this->data);
		}

		public function all_request_delayed($no_hotels = NUll) {
			$this->load->helper('form');
			$this->load->model('hotels_model');
			$this->load->model('workshop_reports_model');
			$this->load->model('workshop_request_items_model');
			$this->load->model('Workshop_request_signatures_model');
			$this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
			if ($this->input->post('submit')) {
				$hotel = $this->input->post('hotel');
				$from_date = $this->input->post('from');
				$to_date = $this->input->post('to');
				if ($hotel != NULL) {
					$this->data['hotel'] = $this->hotels_model->get_by_id($hotel);
				}
				if (($from_date != NULL) && ($to_date != NULL)) {
					$this->data['from'] = $from_date;
					$this->data['to'] = $to_date;
					$this->data['from'] .="-01";
					$this->data['to'] .= "-31";
					$from_date .="-01 00:00:00";
					$to_date .= "-31 23:59:59";
				}
				$workshop_requests = $this->workshop_reports_model->get_all($from_date, $to_date, $hotel);
				foreach ($workshop_requests as $key => $workshop_request) {
					$sign = $this->workshop_reports_model->get_sign($workshop_requests[$key]['id']);
					$order = $this->workshop_reports_model->get_order($workshop_requests[$key]['id']);
					if ($sign['user_id']) {
		  				$date = strtotime($sign['timestamp']);
						$date += 86400;
						if ($order) {
							$date1 = strtotime($order['timestamp']);
						}else{
							$date1 = strtotime(date("Y-m-d H:i:s"));
						}
						if ($date1 <= $date) {
							unset($workshop_requests[$key]);
						}
					}else{
						unset($workshop_requests[$key]);
					}
				}
				$this->data['workshop_requests'] = $workshop_requests;
				foreach ($this->data['workshop_requests'] as $key => $requests) {
					$this->data['workshop_requests'][$key]['items'] = $this->workshop_request_items_model->get_request_items($this->data['workshop_requests'][$key]['id']);
				}
				$this->data['posting'] = TRUE;
			}
			$this->data['no_hotels'] = ($no_hotels)? TRUE : FALSE;
			$this->load->view('workshop_alldelay', $this->data);
		}

		public function all_order_delayed($no_hotels = NUll) {
			$this->load->helper('form');
			$this->load->model('hotels_model');
			$this->load->model('workshop_reports_model');
			$this->load->model('workshop_request_items_model');
			$this->load->model('Workshop_request_signatures_model');
			$this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
			if ($this->input->post('submit')) {
				$hotel = $this->input->post('hotel');
				$from_date = $this->input->post('from');
				$to_date = $this->input->post('to');
				if ($hotel != NULL) {
					$this->data['hotel'] = $this->hotels_model->get_by_id($hotel);
				}
				if (($from_date != NULL) && ($to_date != NULL)) {
					$this->data['from'] = $from_date;
					$this->data['to'] = $to_date;
					$this->data['from'] .="-01";
					$this->data['to'] .= "-31";
					$from_date .="-01 00:00:00";
					$to_date .= "-31 23:59:59";
				}
				$workshop_requests = $this->workshop_reports_model->get_all($from_date, $to_date, $hotel);
				foreach ($workshop_requests as $key => $workshop_request) {
					$order = $this->workshop_reports_model->get_order($workshop_requests[$key]['id']);
					if ($order) {
						$sign = $this->workshop_reports_model->get_order_sign($order['id']);
						$date = strtotime($order['timestamp']);
						$date += 86400;
						if ($sign['user_id']) {
							$date1 = strtotime($sign['timestamp']);
						}else{
							$date1 = strtotime(date("Y-m-d H:i:s"));
						}
						if ($date1 <= $date) {
							unset($workshop_requests[$key]);
						}
					}else{
						unset($workshop_requests[$key]);
					}
				}
				$this->data['workshop_requests'] = $workshop_requests;
				foreach ($this->data['workshop_requests'] as $key => $requests) {
					$this->data['workshop_requests'][$key]['items'] = $this->workshop_request_items_model->get_request_items($this->data['workshop_requests'][$key]['id']);
				}
				$this->data['posting'] = TRUE;
			}
			$this->data['no_hotels'] = ($no_hotels)? TRUE : FALSE;
			$this->load->view('workshop_alldelay', $this->data);
		}

		public function all_delivery_delayed($no_hotels = NUll) {
			$this->load->helper('form');
			$this->load->model('hotels_model');
			$this->load->model('workshop_reports_model');
			$this->load->model('workshop_request_items_model');
			$this->load->model('Workshop_request_signatures_model');
			$this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
			if ($this->input->post('submit')) {
				$hotel = $this->input->post('hotel');
				$from_date = $this->input->post('from');
				$to_date = $this->input->post('to');
				if ($hotel != NULL) {
					$this->data['hotel'] = $this->hotels_model->get_by_id($hotel);
				}
				if (($from_date != NULL) && ($to_date != NULL)) {
					$this->data['from'] = $from_date;
					$this->data['to'] = $to_date;
					$this->data['from'] .="-01";
					$this->data['to'] .= "-31";
					$from_date .="-01 00:00:00";
					$to_date .= "-31 23:59:59";
				}
				$workshop_requests = $this->workshop_reports_model->get_all($from_date, $to_date, $hotel);
				foreach ($workshop_requests as $key => $workshop_request) {
					$order = $this->workshop_reports_model->get_order($workshop_requests[$key]['id']);
					if ($order) {
						$recived = $this->workshop_reports_model->get_reciver($workshop_requests[$key]['id']);
						$date = $order['delivery_date'];
						$date .=" 00:00:00";
						$date = strtotime($date);
						$date += 86400;
						if ($recived) {
							$date1 = strtotime($recived['created']);
						}else{
							$date1 = strtotime(date("Y-m-d H:i:s"));
						}
						if ($date1 <= $date) {
							unset($workshop_requests[$key]);
						}
					}else{
						unset($workshop_requests[$key]);
					}
				}
				$this->data['workshop_requests'] = $workshop_requests;
				foreach ($this->data['workshop_requests'] as $key => $requests) {
					$this->data['workshop_requests'][$key]['items'] = $this->workshop_request_items_model->get_request_items($this->data['workshop_requests'][$key]['id']);
				}
				$this->data['posting'] = TRUE;
			}
			$this->data['no_hotels'] = ($no_hotels)? TRUE : FALSE;
			$this->load->view('workshop_alldelay', $this->data);
		}

		public function all_delivery_delayed_percent($no_hotels = NUll) {
			$this->load->helper('form');
			$this->load->model('hotels_model');
			$this->load->model('workshop_reports_model');
			$this->load->model('workshop_request_items_model');
			$this->load->model('Workshop_request_signatures_model');
			$this->data['hotels'] = $this->hotels_model->getby_user($this->data['user_id']);
			if ($this->input->post('submit')) {
				$hotel = $this->input->post('hotel');
				$from_date = $this->input->post('from');
				$to_date = $this->input->post('to');
				if ($hotel != NULL) {
					$this->data['hotel'] = $this->hotels_model->get_by_id($hotel);
				}
				if (($from_date != NULL) && ($to_date != NULL)) {
					$this->data['from'] = $from_date;
					$this->data['to'] = $to_date;
					$this->data['from'] .="-01";
					$this->data['to'] .= "-31";
					$from_date .="-01 00:00:00";
					$to_date .= "-31 23:59:59";
				}
				$workshop_requests = $this->workshop_reports_model->get_all($from_date, $to_date, $hotel);
				foreach ($workshop_requests as $key => $workshop_request) {
					$order = $this->workshop_reports_model->get_order($workshop_requests[$key]['id']);
					if (isset($order) && $order) {
						$recived = $this->workshop_reports_model->get_reciver($workshop_requests[$key]['id']);
						$date = $order['delivery_date'];
						$date .=" 00:00:00";
						$date = strtotime($date);
						if ($recived) {
							$date1 = strtotime($recived['created']);
						}else{
							$date1 = strtotime(date("Y-m-d H:i:s"));
						}
						if ($date1 <= $date) {
							unset($workshop_requests[$key]);
						}else{
							$sign = $this->workshop_reports_model->get_request_hotel_sign($workshop_requests[$key]['id']);
							$date2 = strtotime($sign['timestamp']);
							$dates = $date1 - $date;
							$dates1 = $date - $date2;
		                    $days = floor(($dates)/ (60*60*24));
		                    $days1 = floor(($dates1)/ (60*60*24));
							$workshop_requests[$key]['sign_user_id'] = $sign['user_id'];
							if ($order['delivery_date'] != "0000-00-00" && !is_null($order['delivery_date'])) {
								$workshop_requests[$key]['delivery_date'] = $order['delivery_date'];
								$workshop_requests[$key]['delivery_date'] .=" 00:00:00";
							}else{
								$workshop_requests[$key]['delivery_date'] = $order['delivery_date'];
							}
							$workshop_requests[$key]['sign_timestamp'] = $sign['timestamp'];
							$workshop_requests[$key]['delay_days'] = $days;
							$workshop_requests[$key]['delay_percentage'] = floor(($days/$days1)*100);
						}
					}else{
						unset($workshop_requests[$key]);
					}
				}
				$this->data['workshop_requests'] = $workshop_requests;
				foreach ($this->data['workshop_requests'] as $key => $requests) {
					$this->data['workshop_requests'][$key]['items'] = $this->workshop_request_items_model->get_request_items($this->data['workshop_requests'][$key]['id']);
				}
				$this->data['posting'] = TRUE;
			}
			$this->data['no_hotels'] = ($no_hotels)? TRUE : FALSE;
			$this->load->view('workshop_alldelay_percent', $this->data);
		}

	}

?>