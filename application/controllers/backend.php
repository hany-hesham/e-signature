<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Backend extends CI_Controller {

		private $crud;

		public function __construct() {
			parent::__construct();
			$this->load->library('Grocery_CRUD');
			$this->load->library('extension_grocery_CRUD');
			$this->crud = new Extension_grocery_CRUD();

			$this->load->library('Tank_auth');
			if (!$this->tank_auth->is_logged_in()) {
				redirect('/auth/login');
			} elseif (!$this->tank_auth->is_admin()) {
				redirect('/forms');
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

		}

		public function forms()
		{
			try {

				$this->crud->set_theme('datatables');
				$this->crud->set_table('forms');

				$this->crud->fields(array('user_id', 'from_hotel_id', 'to_hotel_id', 'issue_date', 'delivery_date', 'department_id', 'location', 'movement_reason', 'old_reason', 'destination', 'rcv_user_date', 'state_id'));

				$this->crud->set_relation('department_id', 'departments', 'name');
				$this->crud->set_relation('from_hotel_id', 'hotels', 'name');
				$this->crud->set_relation('to_hotel_id', 'hotels', 'name');
				$this->crud->set_relation('user_id', 'users', 'username');
				$this->crud->set_relation('state_id', 'form_states', 'state');

				$this->crud->columns('user_id', 'from_hotel_id', 'to_hotel_id', 'issue_date', 'delivery_date', 'department_id', 'location', 'movement_reason', 'old_reason', 'destination', 'rcv_user_date', 'id');

				$this->crud->display_as('id', 'ID#');
				$this->crud->display_as('rcv_user_date', 'Recieved');

				$this->crud->add_action('Edit Form Items', '', '','ui-icon-image',array($this,'form_items'));

				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function form_items($pk, $row) {
			return '/backend/items/'.$pk;
		}

		function items_plans($pk, $row) {
			return '/backend/plan_items/'.$pk;
		}

		public function items($form_id) {
			try {

				$this->crud->set_theme('datatables');
				$this->crud->set_table('items');
				$this->crud->where('form_id', $form_id);
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function plan_items($plan_id) {
			try {

				$this->crud->set_theme('datatables');
				$this->crud->set_table('plan_items');
				$this->crud->where('plan_id', $plan_id);
				$this->crud->set_relation('department_id', 'departments', 'name');
				$this->crud->set_relation('priority_id', 'priorities', 'name');
				$this->crud->set_relation('cancelled', 'plan_item_states', 'name');
				$this->crud->display_as('cancelled', 'state');
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function index() {
			try {

				$this->crud->set_theme('datatables');
				$this->crud->set_table('users');
				$this->crud->set_relation_n_n('id_alias', 'employees_hotels', 'hotels', 'employee_id', 'hotel_id', 'code');
				$this->crud->set_relation('role_id', 'roles', 'role');
				$this->crud->set_relation('department_id', 'departments', 'name');

				$this->crud->fields(array('id_alias', 'username', 'password', 'email', 'channel', 'fullname', 'signature', 'role_id', 'department_id', 'banned', 'admin'));
				$this->crud->display_as('id_alias', 'Hotels');

				$this->crud->display_as('banned', 'deny access');

				$this->crud->columns('id_alias', 'username', 'email', 'fullname', 'role_id', 'department_id', 'banned');

				$this->crud->set_field_upload('signature','assets/uploads/signatures');

				$this->crud->callback_before_insert(array($this,'users_callback'));
				$this->crud->callback_before_update(array($this,'users_callback'));

				$this->crud->callback_after_insert(array($this,'id_alias_fix_callback'));

				$this->crud->change_field_type('password','password');

				$this->crud->callback_edit_field('password',array($this,'edit_password_callback'));

				$this->crud->set_rules('username', 'Username','trim|required|xss_clean|callback_login_check');
				$this->crud->set_rules('email', 'Email','trim|required|xss_clean|callback_login_check');

				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function callback_login_check($login) {
			$this->load->model('users_model');
			$user_exists = $this->users_model->get_user_by_login($login);

			if (is_null($user_exists)) {
				return TRUE;
			} else {
				$this->form_validation->set_message('username_check', 'The user already exists');
				return FALSE;
			}

		}

		function edit_password_callback() {
			return '<input id="field-password" name="password" type="password" value="" maxlength="255">';
		}

		function id_alias_fix_callback() {
			$query = $this->db->query("UPDATE users SET id_alias = id");
		}

		function users_callback($post_array) {
			$password = $post_array['password'];
			if (strlen($password) > 0 ) {
				$this->load->library('phpass-0.1/PasswordHash');
				$hasher = new PasswordHash();
				$post_array['password'] = $hasher->HashPassword($password);
			} else {
				unset($post_array['password']);
			}

			return $post_array;
		}

		public function banks() {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('banks');
				$this->crud->set_subject('Bank');
				$this->crud->columns('id', 'bank');
				$this->crud->display_as('bank','Bank');
				$this->crud->display_as('id', 'ID#');
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function hotels() {
			try {

				$this->crud->set_theme('datatables');
				$this->crud->set_table('hotels');
				$this->crud->set_relation('company_id', 'companies', 'name');

				$this->load->model('roles_model');

				$this->crud->callback_field('deleted',array($this,'approval_callback'));
				$this->crud->callback_field('dummy',array($this,'signature_callback'));
				$this->crud->callback_field('dummy2',array($this,'planned_signature_callback'));
				$this->crud->callback_field('dummy3',array($this,'workshop_request_signature_callback'));

				$this->crud->callback_before_insert(array($this,'process_for_insert'));
				$this->crud->callback_after_insert(array($this,'process_extras_after'));
				$this->crud->callback_before_update(array($this,'process_extras'));

				$this->crud->set_soft_delete();
				// $this->crud->fields('name', 'company_id', 'code');
				$this->crud->columns('name', 'company_id', 'code', 'logo');
				$this->crud->display_as('deleted', 'Plan List Signatures');
				$this->crud->display_as('dummy', 'Approval Request');
				$this->crud->display_as('dummy2', 'Project Signatures');
				$this->crud->display_as('dummy3', 'Workshop Request Signatures');

				$this->crud->set_field_upload('logo','assets/uploads/logos');

				$this->crud->where('hotels.deleted', 0);
				$this->crud->where('dummy', 0);

				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function process_for_insert($post_array) {
			unset($post_array['signatures']);
			unset($post_array['planned_signatures']);
			unset($post_array['workshop_request_signatures']);
			unset($post_array['approvals']);
			return $post_array;
		}

		public function process_extras_after($post_array, $primary_key) {

			$this->load->model('hotel_approvals_model');
			$this->load->model('hotel_signatures_model');
			$this->load->model('hotel_planned_signatures_model');
			$this->load->model('workshop_hotel_signatures_model');

			$this->hotel_signatures_model->reset_hotel($primary_key);
			$this->workshop_hotel_signatures_model->reset_hotel($primary_key);
			$this->hotel_planned_signatures_model->reset_hotel($primary_key);
			$this->hotel_approvals_model->reset_hotel($primary_key);

			foreach ($post_array['signatures'] as $key => $signature) {
				if ($signature != 0) {
					$this->hotel_signatures_model->add_hotel_signature($primary_key, $signature, $key);
				}
			}

			foreach ($post_array['workshop_request_signatures'] as $key => $signature) {
				if ($signature != 0) {
					$this->workshop_hotel_signatures_model->add_hotel_signature($primary_key, $signature, $key);
				}
			}

			foreach ($post_array['planned_signatures'] as $key => $signature) {
				if ($signature != 0) {
					$this->hotel_planned_signatures_model->add_hotel_signature($primary_key, $signature, $key);
				}
			}

			foreach ($post_array['approvals'] as $key => $approval) {
				if ($approval != 0) {
					$this->hotel_approvals_model->add_hotel_approval($primary_key, $approval, $key);
				}
			}
		}


		public function process_extras($post_array, $primary_key) {

			$this->load->model('hotel_approvals_model');
			$this->load->model('hotel_signatures_model');
			$this->load->model('workshop_hotel_signatures_model');
			$this->load->model('hotel_planned_signatures_model');

			$this->hotel_signatures_model->reset_hotel($primary_key);
			$this->workshop_hotel_signatures_model->reset_hotel($primary_key);
			$this->hotel_planned_signatures_model->reset_hotel($primary_key);
			$this->hotel_approvals_model->reset_hotel($primary_key);

			foreach ($post_array['signatures'] as $key => $signature) {
				if ($signature != 0) {
					$this->hotel_signatures_model->add_hotel_signature($primary_key, $signature, $key);
				}
			}

			foreach ($post_array['workshop_request_signatures'] as $key => $signature) {
				if ($signature != 0) {
					$this->workshop_hotel_signatures_model->add_hotel_signature($primary_key, $signature, $key);
				}
			}

			foreach ($post_array['planned_signatures'] as $key => $signature) {
				if ($signature != 0) {
					$this->hotel_planned_signatures_model->add_hotel_signature($primary_key, $signature, $key);
				}
			}

			foreach ($post_array['approvals'] as $key => $approval) {
				if ($approval != 0) {
					$this->hotel_approvals_model->add_hotel_approval($primary_key, $approval, $key);
				}
			}

			unset($post_array['signatures']);
			unset($post_array['planned_signatures']);
			unset($post_array['approvals']);
			return $post_array;
		}

		private function approval_field( $roles, $option = FALSE, $chosen = TRUE) {
			$class = ($chosen)? 'chosen-select' : '';
			$field = '
			<div class="form-input-box sortable-selects" >
				<select name="approvals[]" class="'.$class.' approval-selector" data-placeholder="Select approval">
					<option value=""></option>
					';

			foreach ($roles as $role) {
				$field .= '<option value="'.$role['id'].'" ';
				$field .= ($option && $option == $role['id'])? ' selected="selected" ' : '';
				$field .= '>'.$role['role'].'</option>';
			};


			$field .= '
				</select>
				<span class="icon icon-th-list"></span>
			</div>
			';

			return $field;
		}

		public function approval_callback($var, $primary_key = null)
		{
			$this->load->model('hotel_approvals_model');
			$approvals = $this->hotel_approvals_model->getby_hotel($primary_key);

			$roles = $this->roles_model->getall();

			$global_field = '<div id="hidden-template-2">'.$this->approval_field($roles, FALSE, FALSE).'</div>';
			$global_field .= '<div class="field-approval-global-2 .connected">';
			foreach ($approvals as $approval) {
				$global_field .= $this->approval_field($roles, $approval['role_id']);
			}
			$global_field .= $this->approval_field($roles);
			$global_field .= '</div> <br />';
			$global_field .= '<script type="text/javascript">
							  $(function () {
							  	$(".approval-selector").change(function(){
							  		var zeroValue = false;
							  		$(".field-approval-global-2 .approval-selector").each(function(){
							  			if ($(this).val() == ""){
							  				zeroValue = true;
							  			}
							  		});
									if(!zeroValue) {
										$clone = $("#hidden-template-2").children().first().clone(true);
										$clone.find("select").addClass("chosen-select");
										$clone.appendTo(".field-approval-global-2");

										$(".chosen-select").chosen();
									}
							  	});
							    $(".field-approval-global-2").sortable({
							      connectWith: ".connected"
							    });
							  });
							</script>';

			return $global_field;
		}

		private function signature_field( $roles, $option = FALSE, $chosen = TRUE) {
			$class = ($chosen)? 'chosen-select' : '';
			$field = '
			<div class="form-input-box sortable-selects" >
				<select name="signatures[]" class="'.$class.' signature-selector" data-placeholder="Select Signature">
					<option value=""></option>
					';

			foreach ($roles as $role) {
				$field .= '<option value="'.$role['id'].'" ';
				$field .= ($option && $option == $role['id'])? ' selected="selected" ' : '';
				$field .= '>'.$role['role'].'</option>';
			};


			$field .= '
				</select>
				<span class="icon icon-th-list"></span>
			</div>
			';

			return $field;
		}

		public function signature_callback($var, $primary_key = null)
		{
			$this->load->model('hotel_signatures_model');
			$signatures = $this->hotel_signatures_model->getby_hotel($primary_key);

			$roles = $this->roles_model->getall();

			$global_field = '<div id="hidden-template">'.$this->signature_field($roles, FALSE, FALSE).'</div>';
			$global_field .= '<div class="field-signature-global .connected">';
			foreach ($signatures as $signature) {
				$global_field .= $this->signature_field($roles, $signature['role_id']);
			}
			$global_field .= $this->signature_field($roles);
			$global_field .= '</div> <br />';
			$global_field .= '<script type="text/javascript">
							  $(function () {
							  	$(".signature-selector").change(function(){
							  		var zeroValue = false;
							  		$(".field-signature-global .signature-selector").each(function(){
							  			if ($(this).val() == ""){
							  				zeroValue = true;
							  			}
							  		});
									if(!zeroValue) {
										$clone = $("#hidden-template").children().first().clone(true);
										$clone.find("select").addClass("chosen-select");
										$clone.appendTo(".field-signature-global");

										$(".chosen-select").chosen();
									}
							  	});
							    $(".field-signature-global").sortable({
							      connectWith: ".connected"
							    });
							  });
							</script>';

			return $global_field;
		}


		private function planned_signature_field( $roles, $option = FALSE, $chosen = TRUE) {
			$class = ($chosen)? 'chosen-select' : '';
			$field = '
			<div class="form-input-box sortable-selects" >
				<select name="planned_signatures[]" class="'.$class.' planned-signature-selector" data-placeholder="Select Signature">
					<option value=""></option>
					';

			foreach ($roles as $role) {
				$field .= '<option value="'.$role['id'].'" ';
				$field .= ($option && $option == $role['id'])? ' selected="selected" ' : '';
				$field .= '>'.$role['role'].'</option>';
			};


			$field .= '
				</select>
				<span class="icon icon-th-list"></span>
			</div>
			';

			return $field;
		}

		public function planned_signature_callback($var, $primary_key = null)
		{
			$this->load->model('hotel_planned_signatures_model');
			$signatures = $this->hotel_planned_signatures_model->getby_hotel($primary_key);

			$roles = $this->roles_model->getall();

			$global_field = '<div id="hidden-template-3">'.$this->planned_signature_field($roles, FALSE, FALSE).'</div>';
			$global_field .= '<div class="field-planned-signature-global .connected">';
			foreach ($signatures as $signature) {
				$global_field .= $this->planned_signature_field($roles, $signature['role_id']);
			}
			$global_field .= $this->planned_signature_field($roles);
			$global_field .= '</div> <br />';
			$global_field .= '<script type="text/javascript">
							  $(function () {
							  	$(".planned-signature-selector").change(function(){
							  		var zeroValue = false;
							  		$(".field-planned-signature-global .planned-signature-selector").each(function(){
							  			if ($(this).val() == ""){
							  				zeroValue = true;
							  			}
							  		});
									if(!zeroValue) {
										$clone = $("#hidden-template-3").children().first().clone(true);
										$clone.find("select").addClass("chosen-select");
										$clone.appendTo(".field-planned-signature-global");

										$(".chosen-select").chosen();
									}
							  	});
							    $(".field-planned-signature-global").sortable({
							      connectWith: ".connected"
							    });
							  });
							</script>';

			return $global_field;
		}

		private function workshop_request_signature_field( $roles, $option = FALSE, $chosen = TRUE) {
			$class = ($chosen)? 'chosen-select' : '';
			$field = '
			<div class="form-input-box sortable-selects" >
				<select name="workshop_request_signatures[]" class="'.$class.' workshop-request-signature-selector" data-placeholder="Select Signature">
					<option value=""></option>
					';

			foreach ($roles as $role) {
				$field .= '<option value="'.$role['id'].'" ';
				$field .= ($option && $option == $role['id'])? ' selected="selected" ' : '';
				$field .= '>'.$role['role'].'</option>';
			};


			$field .= '
				</select>
				<span class="icon icon-th-list"></span>
			</div>
			';

			return $field;
		}

		public function workshop_request_signature_callback($var, $primary_key = null)
		{
			$this->load->model('workshop_hotel_signatures_model');
			$signatures = $this->workshop_hotel_signatures_model->getby_hotel($primary_key);

			$roles = $this->roles_model->getall();

			$global_field = '<div id="hidden-template-4">'.$this->workshop_request_signature_field($roles, FALSE, FALSE).'</div>';
			$global_field .= '<div class="field-workshop-request-signature-global .connected">';
			foreach ($signatures as $signature) {
				$global_field .= $this->workshop_request_signature_field($roles, $signature['role_id']);
			}
			$global_field .= $this->workshop_request_signature_field($roles);
			$global_field .= '</div> <br />';
			$global_field .= '<script type="text/javascript">
							  $(function () {
							  	$(".workshop-request-signature-selector").change(function(){
							  		var zeroValue = false;
							  		$(".field-workshop-request-signature-global .workshop-request-signature-selector").each(function(){
							  			if ($(this).val() == ""){
							  				zeroValue = true;
							  			}
							  		});
									if(!zeroValue) {
										$clone = $("#hidden-template-4").children().first().clone(true);
										$clone.find("select").addClass("chosen-select");
										$clone.appendTo(".field-workshop-request-signature-global");

										$(".chosen-select").chosen();
									}
							  	});
							    $(".field-workshop-request-signature-global").sortable({
							      connectWith: ".connected"
							    });
							  });
							</script>';

			return $global_field;
		}
		public function companies() {
			try {

				$this->load->model('roles_model');

				$this->crud->set_theme('datatables');
				$this->crud->set_table('companies');

				$this->crud->display_as('deleted', "Signatures");
				$this->crud->callback_field('deleted',array($this,'company_signature_callback'));

				$this->crud->callback_before_insert(array($this,'process_for_insert_company'));
				$this->crud->callback_after_insert(array($this,'process_extras_after_ccompany'));
				$this->crud->callback_before_update(array($this,'process_extras_company'));

				$this->crud->set_soft_delete();

				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

			private function company_signature_field( $roles, $option = FALSE, $chosen = TRUE) {
			$class = ($chosen)? 'chosen-select' : '';
			$field = '
			<div class="form-input-box sortable-selects" >
				<select name="signatures[]" class="'.$class.' signature-selector" data-placeholder="Select Signature">
					<option value=""></option>
					';

			foreach ($roles as $role) {
				$field .= '<option value="'.$role['id'].'" ';
				$field .= ($option && $option == $role['id'])? ' selected="selected" ' : '';
				$field .= '>'.$role['role'].'</option>';
			};


			$field .= '
				</select>
				<span class="icon icon-th-list"></span>
			</div>
			';

			return $field;
		}

		public function company_signature_callback($var, $primary_key = null)
		{
			$this->load->model('company_signatures_model');
			$signatures = $this->company_signatures_model->getby_company($primary_key);

			$roles = $this->roles_model->getall();

			$global_field = '<div id="hidden-template">'.$this->company_signature_field($roles, FALSE, FALSE).'</div>';
			$global_field .= '<div class="field-signature-global .connected">';
			foreach ($signatures as $signature) {
				$global_field .= $this->company_signature_field($roles, $signature['role_id']);
			}
			$global_field .= $this->company_signature_field($roles);
			$global_field .= '</div> <br />';
			$global_field .= '<script type="text/javascript">
							  $(function () {
							  	$(".signature-selector").change(function(){
							  		var zeroValue = false;
							  		$(".field-signature-global .signature-selector").each(function(){
							  			if ($(this).val() == ""){
							  				zeroValue = true;
							  			}
							  		});
									if(!zeroValue) {
										$clone = $("#hidden-template").children().first().clone(true);
										$clone.find("select").addClass("chosen-select");
										$clone.appendTo(".field-signature-global");

										$(".chosen-select").chosen();
									}
							  	});
							    $(".field-signature-global").sortable({
							      connectWith: ".connected"
							    });
							  });
							</script>';

			return $global_field;
		}


		public function process_for_insert_company($post_array) {
			unset($post_array['signatures']);
			return $post_array;
		}

		public function process_extras_after_ccompany($post_array, $primary_key) {

			$this->load->model('company_signatures_model');

			$this->company_signatures_model->reset_company($primary_key);

			foreach ($post_array['signatures'] as $key => $signature) {
				if ($signature != 0) {
					$this->company_signatures_model->add_company_signature($primary_key, $signature, $key);
				}
			}
		}


		public function process_extras_company($post_array, $primary_key) {

			$this->load->model('company_signatures_model');

			$this->company_signatures_model->reset_company($primary_key);

			foreach ($post_array['signatures'] as $key => $signature) {
				if ($signature != 0) {
					$this->company_signatures_model->add_company_signature($primary_key, $signature, $key);
				}
			}

			unset($post_array['signatures']);
			return $post_array;
		}

		public function roles() {
			try {

				$this->crud->set_theme('datatables');
				$this->crud->set_table('roles');
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function devisions() {
			try {

				$this->crud->set_theme('datatables');
				$this->crud->set_table('devisions');
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function departments() {
			try {

				$this->crud->set_theme('datatables');
				$this->crud->set_table('departments');
				$this->crud->set_relation('devision_id', 'devisions', 'name');
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function planned_limitations() {
			try {

				$this->crud->set_theme('datatables');
				$this->crud->set_table('planned_limitations');
				$this->crud->set_relation('role_id', 'roles', 'role');
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function unplanned_limitations() {
			try {

				$this->crud->set_theme('datatables');
				$this->crud->set_table('unplanned_limitations');
				$this->crud->set_relation('role_id', 'roles', 'role');
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}


		// public function signatures() {
		// 	try {

		// 		$this->crud->set_theme('datatables');
		// 		$this->crud->set_table('company_signatures');

		// 		$output = $this->crud->render();
		// 		$this->load->view('backend', $output);
		// 	}
		// 	catch( Exception $e) {
		// 		show_error($e->getMessage()." _ ". $e->getTraceAsString());
		// 	}
		// }

		public function suppliers() {
			try {

				$this->crud->set_theme('datatables');
				$this->crud->set_table('suppliers');
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function groups() {
			try {

				$this->crud->set_theme('datatables');
				$this->crud->set_table('user_groups');

				$this->crud->set_relation_n_n('id_alias', 'users_groups', 'users', 'group_id', 'user_id', 'fullname');
				$this->crud->display_as('id_alias', 'users');

				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function projects() {
			try {

				$this->crud->set_theme('datatables');
				$this->crud->set_table('projects');
				$this->crud->set_relation('department_id', 'departments', 'name');
				$this->crud->set_relation('hotel_id', 'hotels', 'name');
				$this->crud->set_relation('type_id', 'project_types', 'name');
				$this->crud->set_relation('origin_id', 'project_origins', 'name');
				$this->crud->set_relation('user_id', 'users', 'username');
				$this->crud->set_relation('state_id', 'project_states', 'name');
				$this->crud->set_relation_n_n('supplier', 'projects_suppliers', 'suppliers', 'project_id', 'supplier_id', 'name');

				$this->crud->columns('timestamp', 'hotel_id', 'name', 'code', 'type_id', 'origin_id', 'scope', 'user_id', 'department_id', 'start', 'end', 'state_id', 'id','supplier');

				$this->crud->display_as('id', 'ID#');

				$this->crud->add_action('Edit Project Approvals', '', '','ui-icon-image',array($this,'project_approvals'));
				$this->crud->add_action('Edit Project Signatures', '', '','ui-icon-image',array($this,'project_signatures'));
				$this->crud->add_action('Attachment Files', '', '','ui-icon-image',array($this,'project_attach'));

				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function project_attach($pk, $row) {
				return '/backend/project_attachment/'.$pk;
			}

			public function project_attachment($project_id) {
				try {
					$this->crud->set_theme('datatables');
					$this->crud->set_table('project_files');
					$this->crud->set_subject('File');
					$this->crud->callback_field('project_id',array($this,'fix_project'));
					$this->crud->display_as('project_id', "project Number");
					$this->crud->display_as('name','File');
					$this->crud->set_relation('project_id', 'projects', 'code');
					$this->crud->set_field_upload('name','assets/uploads/files');
					$this->crud->where('project_id', $project_id);
					$this->crud->callback_before_insert(array($this,'project_ass'));
					$output = $this->crud->render();
					$this->load->view('backend', $output);
				}
				catch( Exception $e) {
					show_error($e->getMessage()." _ ". $e->getTraceAsString());
				}
			}

			public function fix_project() {
				return '';
			}

			public function project_ass($post_array) {
				$project_id = $this->uri->segment(3);
				$post_array['project_id'] = $project_id;
				return $post_array;
			}

		public function plans() {
			try {

				$this->crud->set_theme('datatables');
				$this->crud->set_table('plans');

				$this->crud->fields(array('timestamp', 'hotel_id', 'year', 'state_id', 'user_id', 'cf_pos', 'year_pos'));

				$this->crud->set_relation('hotel_id', 'hotels', 'name');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->columns('timestamp', 'hotel_id', 'year', 'id');

				$this->crud->display_as('id', 'ID#');
				$this->crud->display_as('hotel_id', 'Hotel');

				$this->crud->display_as('cf_pos', 'C/F Provision');
				$this->crud->display_as('year_pos', 'Prevision For Budget Year');

				$this->crud->add_action('Edit Approvals', '', '','ui-icon-image',array($this,'plan_signatures'));
				$this->crud->add_action('Edit Items', '', '','ui-icon-image',array($this,'items_plans'));

				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}


		public function project_associates($post_array) {

			$project_id = $this->uri->segment(3);
			$post_array['project_id'] = $project_id;

			return $post_array;
		}

		public function plan_associates($post_array) {

			$plan_id = $this->uri->segment(3);
			$post_array['plan_id'] = $plan_id;

			return $post_array;
		}

		public function fixed_project() {
			return '';
		}

		public function fixed_plan() {
			return '';
		}

		function project_approvals($pk, $row) {
			return '/backend/approvals/'.$pk;
		}

		function plan_signatures($pk, $row) {
			return '/backend/plan_approvals/'.$pk;
		}

		public function approvals($project_id) {
			try {

				$this->crud->set_theme('datatables');
				$this->crud->set_table('project_approvals');

				// $this->crud->fields(array('user_id', 'role_id', 'timestamp', 'rank'));
				$this->crud->callback_field('project_id',array($this,'fixed_project'));
				$this->crud->display_as('project_id', "");

				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->set_relation('role_id', 'roles', 'role');

				$this->crud->set_relation('project_id', 'projects', 'name');

				$this->crud->order_by('rank');

				$this->crud->where('project_id', $project_id);

				$this->crud->callback_before_insert(array($this,'project_associates'));

				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function plan_approvals($plan_id) {
			try {

				$this->crud->set_theme('datatables');
				$this->crud->set_table('plan_signatures');

				// $this->crud->fields(array('user_id', 'role_id', 'timestamp', 'rank'));
				$this->crud->callback_field('plan_id',array($this,'fixed_plan'));
				$this->crud->display_as('plan_id', "");

				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->set_relation('role_id', 'roles', 'role');

				$this->crud->order_by('rank');

				$this->crud->where('plan_id', $plan_id);

				$this->crud->callback_before_insert(array($this,'plan_associates'));

				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function project_signatures($pk, $row) {
			return '/backend/signatures/'.$pk;
		}

		public function signatures($project_id) {
			try {

				$this->crud->set_theme('datatables');
				$this->crud->set_table('project_signatures');

				// $this->crud->fields(array('user_id', 'role_id', 'timestamp', 'rank'));
				$this->crud->callback_field('project_id',array($this,'fixed_project'));
				$this->crud->display_as('project_id', "");

				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->set_relation('role_id', 'roles', 'role');

				$this->crud->set_relation('project_id', 'projects', 'name');

				$this->crud->order_by('rank');

				$this->crud->where('project_id', $project_id);


				$this->crud->callback_before_insert(array($this,'project_associates'));

				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function discount_type() {
			try {

				$this->crud->set_theme('datatables');
				$this->crud->set_table('type');
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function Agent_Company() {
			try {

				$this->crud->set_theme('datatables');
				$this->crud->set_table('Agent_Company');
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}



		public function discount() {
			try {

				$this->crud->set_theme('datatables');
				$this->crud->set_table('discount');
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}



		public function res_type() {
			try {

				$this->load->model('roles_model');

				$this->crud->set_theme('datatables');
				$this->crud->set_table('res_type');

				$this->crud->display_as('dummy', "Signatures");
				$this->crud->callback_field('dummy',array($this,'reservation_signature_callback'));

				$this->crud->callback_before_insert(array($this,'process_for_insert_reservation'));
				$this->crud->callback_after_insert(array($this,'process_extras_after_reservation'));
				$this->crud->callback_before_update(array($this,'process_extras_reservation'));

				$this->crud->set_soft_delete();
				$this->crud->where('res_type.deleted', 0);

				$output = $this->crud->render();
				$this->load->view('backend', $output);

			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}


		private function reservation_signature_field( $roles, $option = FALSE, $chosen = TRUE) {
			$class = ($chosen)? 'chosen-select' : '';
			$field = '
			<div class="form-input-box sortable-selects" >
				<select name="signatures[]" class="'.$class.' signature-selector" data-placeholder="Select Signature">
					<option value=""></option>
					';

			foreach ($roles as $role) {
				$field .= '<option value="'.$role['id'].'" ';
				$field .= ($option && $option == $role['id'])? ' selected="selected" ' : '';
				$field .= '>'.$role['role'].'</option>';
			};


			$field .= '
				</select>
				<span class="icon icon-th-list"></span>
			</div>
			';

			return $field;
		}


		public function reservation_signature_callback($var, $primary_key = null)
		{
			$this->load->model('roles_model_res');
			$signatures = $this->roles_model_res->getby_res($primary_key);

			$roles = $this->roles_model->getall();

			$global_field = '<div id="hidden-template">'.$this->reservation_signature_field($roles, FALSE, FALSE).'</div>';
			$global_field .= '<div class="field-signature-global .connected">';
			foreach ($signatures as $signature) {
				$global_field .= $this->reservation_signature_field($roles, $signature['role']);
			}
			$global_field .= $this->reservation_signature_field($roles);
			$global_field .= '</div> <br />';
			$global_field .= '<script type="text/javascript">
								$(function () {
									$(".signature-selector").change(function(){
										var zeroValue = false;
										$(".field-signature-global .signature-selector").each(function(){
											if ($(this).val() == ""){
												zeroValue = true;
											}
										});
									if(!zeroValue) {
										$clone = $("#hidden-template").children().first().clone(true);
										$clone.find("select").addClass("chosen-select");
										$clone.appendTo(".field-signature-global");

										$(".chosen-select").chosen();
									}
									});
									$(".field-signature-global").sortable({
										connectWith: ".connected"
									});
								});
							</script>';

			return $global_field;
		}

		public function process_for_insert_reservation($post_array) {
			unset($post_array['signatures']);
			return $post_array;
		}




		public function process_extras_after_reservation($post_array, $primary_key) {

			$this->load->model('roles_model_res');

			$this->roles_model_res->reset_res($primary_key);

			foreach ($post_array['signatures'] as $key => $signature) {
				if ($signature != 0) {
					$this->roles_model_res->add_role_res($primary_key, $signature, $key);
				}
			}
		}

		public function process_extras_reservation($post_array, $primary_key) {

			$this->load->model('roles_model_res');

			$this->roles_model_res->reset_res($primary_key);

			foreach ($post_array['signatures'] as $key => $signature) {
				if ($signature != 0) {
					$this->roles_model_res->add_role_res($primary_key, $signature, $key);
				}
			}

			unset($post_array['signatures']);
			return $post_array;
		}

		public function reservation() {
			try {

				$this->crud->set_theme('datatables');
				$this->crud->set_table('forma_res');

				$this->crud->columns('id','hotel', 'name', 'recived_by');

				$this->crud->set_relation('hotel', 'hotels', 'name');
				$this->crud->set_relation('res_type', 'res_type', 'name');
				$this->crud->set_relation('company', 'Agent_Company', 'name');
				$this->crud->set_relation('board_type_id', 'board_type', 'board_type');
				$this->crud->set_relation('type', 'type', 'name');

				$this->crud->set_relation('user_id', 'users', 'fullname');

				$this->crud->display_as('id', 'ID#');

				$this->crud->add_action('Attachment Files', '', '','ui-icon-image',array($this,'reservation_attach'));
				$this->crud->add_action('Reservation Signature', '', '','ui-icon-image',array($this,'reservation_sign'));

				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function reservation_attach($pk, $row) {
			return '/backend/reservation_attachment/'.$pk;
		}

		public function reservation_attachment($res_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('res_files');

				$this->crud->callback_field('res_id',array($this,'fixed_reservation'));
				$this->crud->display_as('res_id', "");

				$this->crud->set_relation('res_id', 'forma_res', 'name');
				$this->crud->set_field_upload('name','assets/uploads/files');
				$this->crud->where('res_id', $res_id);


				$this->crud->callback_before_insert(array($this,'reservation_associates'));

				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function reservation_sign($pk, $row) {
			return '/backend/reservation_signatures/'.$pk;
		}

		public function reservation_signatures($res_id) {
			try {

				$this->crud->set_theme('datatables');
				$this->crud->set_table('signature_res');

				// $this->crud->fields(array('user_id', 'role_id', 'timestamp', 'rank'));
				$this->crud->callback_field('forma_res_id',array($this,'fixed_reservation'));
				$this->crud->display_as('forma_res_id', "");

				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->set_relation('role', 'roles', 'role');

				$this->crud->set_relation('forma_res_id', 'forma_res', 'name');

				$this->crud->order_by('rank');

				$this->crud->where('forma_res_id', $res_id);


				$this->crud->callback_before_insert(array($this,'reservation_signs'));

				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function fixed_reservation() {
			return '';
		}

		public function reservation_associates($post_array) {

			$res_id = $this->uri->segment(3);
			$post_array['res_id'] = $res_id;

			return $post_array;
		}
		public function reservation_signs($post_array) {

			$forma_res_id = $this->uri->segment(3);
			$post_array['forma_res_id'] = $forma_res_id;

			return $post_array;
		}

		public function purpose() {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('purpose');
				$this->crud->set_subject('Purpose Report');
				$this->crud->columns('id', 'hotel_id', 'date', 'type', 'set_id');
				$this->crud->set_relation('hotel_id', 'hotels', 'name');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->set_relation('set_id', 'settlement', 'File');
				$this->crud->display_as('hotel_id','Hotel');
				$this->crud->display_as('date','Date');
				$this->crud->display_as('type','Type');
				$this->crud->display_as('id', 'ID#');
				$this->crud->add_action('Edit Purpose Signatures', '', '','ui-icon-image',array($this,'purpose_signatures'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function purpose_signatures($pk, $row) {
			return '/backend/pur_signatures/'.$pk;
		}

		public function pur_signatures($pur_id) {
			try {

				$this->crud->set_theme('datatables');
				$this->crud->set_table('purpose_signature');

				// $this->crud->fields(array('user_id', 'role_id', 'timestamp', 'rank'));
				$this->crud->callback_field('pur_id',array($this,'fixed_pur'));
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->set_relation('role_id', 'roles', 'role');

				$this->crud->set_relation('set_id', 'settlement', 'File');

				$this->crud->order_by('rank');

				$this->crud->where('pur_id', $pur_id);


				$this->crud->callback_before_insert(array($this,'pur_associates'));

				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function pur_associates($post_array) {

			$pur_id = $this->uri->segment(3);
			$post_array['pur_id'] = $pur_id;

			return $post_array;
		}
		
		public function fixed_pur() {
			return '';
		}

		public function pur_sign() {
			try {
				$this->load->model('roles_model');
				$this->crud->set_theme('datatables');
				$this->crud->set_table('purpose_type');
				$this->crud->set_subject('Purpose Report Signature');
				$this->crud->columns('id', 'dummy');
				$this->crud->display_as('dummy', 'Signatures');
				$this->crud->display_as('id', 'ID#');
				$this->crud->callback_field('dummy',array($this,'pur_signature'));
				$this->crud->callback_before_insert(array($this,'process_for_insert_pur'));
				$this->crud->callback_after_insert(array($this,'process_extras_after_pur'));
				$this->crud->callback_before_update(array($this,'process_extras_pur'));
				$this->crud->set_soft_delete();
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function pur_signature($var, $primary_key = null) {
		  $this->load->model('purpose_role_model');
		  $signatures = $this->purpose_role_model->getby_pur($primary_key);

		  $roles = $this->roles_model->getall();

		  $global_field = '<div id="hidden-template">'.$this->pur_signature_field($roles, FALSE, FALSE).'</div>';
		  $global_field .= '<div class="field-signature-global .connected">';
		  foreach ($signatures as $signature) {
		    $global_field .= $this->pur_signature_field($roles, $signature['role']);
		  }
		  $global_field .= $this->pur_signature_field($roles);
		  $global_field .= '</div> <br />';
		  $global_field .= '<script type="text/javascript">
		            $(function () {
		              $(".signature-selector").change(function(){
		                var zeroValue = false;
		                $(".field-signature-global .signature-selector").each(function(){
		                  if ($(this).val() == ""){
		                    zeroValue = true;
		                  }
		                });
		              if(!zeroValue) {
		                $clone = $("#hidden-template").children().first().clone(true);
		                $clone.find("select").addClass("chosen-select");
		                $clone.appendTo(".field-signature-global");

		                $(".chosen-select").chosen();
		              }
		              });
		              $(".field-signature-global").sortable({
		                connectWith: ".connected"
		              });
		            });
		          </script>';

		  return $global_field;
		}

		private function pur_signature_field( $roles, $option = FALSE, $chosen = TRUE) {
		  $class = ($chosen)? 'chosen-select' : '';
		  $field = '
		  <div class="form-input-box sortable-selects" >
		    <select name="signatures[]" class="'.$class.' signature-selector" data-placeholder="Select Signature">
		      <option value=""></option>
		      ';

		  foreach ($roles as $role) {
		    $field .= '<option value="'.$role['id'].'" ';
		    $field .= ($option && $option == $role['id'])? ' selected="selected" ' : '';
		    $field .= '>'.$role['role'].'</option>';
		  };


		  $field .= '
		    </select>
		    <span class="icon icon-th-list"></span>
		  </div>
		  ';

		  return $field;
		}

		public function process_for_insert_pur($post_array) {
		  unset($post_array['signatures']);
		  return $post_array;
		}

		public function process_extras_after_pur($post_array, $primary_key) {

		  $this->load->model('purpose_role_model');

		  $this->purpose_role_model->reset_pur($primary_key);

		  foreach ($post_array['signatures'] as $key => $signature) {
		    if ($signature != 0) {
		      $this->purpose_role_model->add_role_pur($primary_key, $signature);
		    }
		  }
		}

		public function process_extras_pur($post_array, $primary_key) {

		  $this->load->model('purpose_role_model');

		  $this->purpose_role_model->reset_pur($primary_key);

		  foreach ($post_array['signatures'] as $key => $signature) {
		    if ($signature != 0) {
		      $this->purpose_role_model->add_role_pur($primary_key, $signature);
		    }
		  }

		  unset($post_array['signatures']);
		  return $post_array;
		}

		public function complaint() {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('complaint');
				$this->crud->set_subject('Complaint After Stay');
				$this->crud->columns('id', 'hotel_id', 'guest', 'date', 'ref', 'operator_id');
				$this->crud->set_relation('hotel_id', 'hotels', 'name');
				$this->crud->set_relation('operator_id', 'operators', 'name');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->display_as('guest','Guest Name');
				$this->crud->display_as('date','Date');
				$this->crud->display_as('ref','Ref. Number');
				$this->crud->display_as('hotel_id','Hotel');
				$this->crud->display_as('operator_id','Operator');
				$this->crud->display_as('id', 'ID#');
				$this->crud->add_action('Edit Complaint Signatures', '', '','ui-icon-image',array($this,'com_signatures'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function com_signatures($pk, $row) {
			return '/backend/comp_signatures/'.$pk;
		}

		public function comp_signatures($com_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('complaint_signature');
				$this->crud->callback_field('com_id',array($this,'fixed_com'));
				$this->crud->display_as('com_id', "");
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->set_relation('role_id', 'roles', 'role');
				$this->crud->set_relation('department_id', 'departments', 'name');
				$this->crud->set_relation('com_id', 'complaint', 'ref');
				$this->crud->where('com_id', $com_id);
				$this->crud->callback_before_insert(array($this,'com_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function com_associates($post_array) {
			$com_id = $this->uri->segment(3);
			$post_array['com_id'] = $com_id;
			return $post_array;
		}

		public function fixed_com() {
			return '';
		}

		public function com_sign() {
			try {
				$this->load->model('roles_model');
				$this->crud->set_theme('datatables');
				$this->crud->set_table('complaint_type');
				$this->crud->set_subject('Complaint After Stay Signature');
				$this->crud->columns('id', 'dummy');
				$this->crud->display_as('dummy', 'Signatures');
				$this->crud->display_as('id', 'ID#');
				$this->crud->callback_field('dummy',array($this,'com_signature'));
				$this->crud->callback_before_insert(array($this,'process_for_insert_com'));
				$this->crud->callback_after_insert(array($this,'process_extras_after_com'));
				$this->crud->callback_before_update(array($this,'process_extras_com'));
				$this->crud->set_soft_delete();
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function com_signature($var, $primary_key = null) {
		  $this->load->model('complaint_role_model');
		  $signatures = $this->complaint_role_model->getby_com($primary_key);
		  $roles = $this->roles_model->getall();
		  $global_field = '<div id="hidden-template">'.$this->com_signature_field($roles, FALSE, FALSE).'</div>';
		  $global_field .= '<div class="field-signature-global .connected">';
		  foreach ($signatures as $signature) {
		    $global_field .= $this->com_signature_field($roles, $signature['role']);
		  }
		  $global_field .= $this->com_signature_field($roles);
		  $global_field .= '</div> <br />';
		  $global_field .= '<script type="text/javascript">
		            $(function () {
		              $(".signature-selector").change(function(){
		                var zeroValue = false;
		                $(".field-signature-global .signature-selector").each(function(){
		                  if ($(this).val() == ""){
		                    zeroValue = true;
		                  }
		                });
		              if(!zeroValue) {
		                $clone = $("#hidden-template").children().first().clone(true);
		                $clone.find("select").addClass("chosen-select");
		                $clone.appendTo(".field-signature-global");

		                $(".chosen-select").chosen();
		              }
		              });
		              $(".field-signature-global").sortable({
		                connectWith: ".connected"
		              });
		            });
		          </script>';
		  return $global_field;
		}

		private function com_signature_field( $roles, $option = FALSE, $chosen = TRUE) {
		  $class = ($chosen)? 'chosen-select' : '';
		  $field = '
		  <div class="form-input-box sortable-selects" >
		    <select name="signatures[]" class="'.$class.' signature-selector" data-placeholder="Select Signature">
		      <option value=""></option>
		      ';
		  foreach ($roles as $role) {
		    $field .= '<option value="'.$role['id'].'" ';
		    $field .= ($option && $option == $role['id'])? ' selected="selected" ' : '';
		    $field .= '>'.$role['role'].'</option>';
		  };
		  $field .= '
		    </select>
		    <span class="icon icon-th-list"></span>
		  </div>
		  ';
		  return $field;
		}

		public function process_for_insert_com($post_array) {
		  unset($post_array['signatures']);
		  return $post_array;
		}

		public function process_extras_after_com($post_array, $primary_key) {

		  $this->load->model('complaint_role_model');

		  $this->complaint_role_model->reset_com($primary_key);

		  foreach ($post_array['signatures'] as $key => $signature) {
		    if ($signature != 0) {
		      $this->complaint_role_model->add_role_com($primary_key, $signature);
		    }
		  }
		}

		public function process_extras_com($post_array, $primary_key) {

		  $this->load->model('complaint_role_model');

		  $this->complaint_role_model->reset_com($primary_key);

		  foreach ($post_array['signatures'] as $key => $signature) {
		    if ($signature != 0) {
		      $this->complaint_role_model->add_role_com($primary_key, $signature);
		    }
		  }

		  unset($post_array['signatures']);
		  return $post_array;
		}

		public function deductions() {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('deductions');
				$this->crud->set_subject('Deductions');
				$this->crud->columns('id', 'hotel_id', 'guest', 'date', 'ref', 'operator_id');
				$this->crud->set_relation('hotel_id', 'hotels', 'name');
				$this->crud->set_relation('operator_id', 'operators', 'name');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->display_as('guest','Guest Name');
				$this->crud->display_as('date','Date');
				$this->crud->display_as('ref','Ref. Number');
				$this->crud->display_as('hotel_id','Hotel');
				$this->crud->display_as('operator_id','Operator');
				$this->crud->display_as('id', 'ID#');
				$this->crud->add_action('Edit Deductions Signatures', '', '','ui-icon-image',array($this,'ded_signatures'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function ded_signatures($pk, $row) {
			return '/backend/deds_signatures/'.$pk;
		}

		public function deds_signatures($ded_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('deductions_signature');
				$this->crud->callback_field('ded_id',array($this,'fixed_ded'));
				$this->crud->display_as('ded_id', "");
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->set_relation('role_id', 'roles', 'role');
				$this->crud->set_relation('department_id', 'departments', 'name');
				$this->crud->set_relation('ded_id', 'deductions', 'ref');
				$this->crud->where('ded_id', $ded_id);
				$this->crud->callback_before_insert(array($this,'ded_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function ded_associates($post_array) {
			$ded_id = $this->uri->segment(3);
			$post_array['ded_id'] = $ded_id;
			return $post_array;
		}

		public function fixed_ded() {
			return '';
		}

		public function ded_sign() {
			try {
				$this->load->model('roles_model');
				$this->crud->set_theme('datatables');
				$this->crud->set_table('deductions_type');
				$this->crud->set_subject('Deductions Signature');
				$this->crud->columns('id', 'dummy');
				$this->crud->display_as('dummy', 'Signatures');
				$this->crud->display_as('id', 'ID#');
				$this->crud->callback_field('dummy',array($this,'ded_signature'));
				$this->crud->callback_before_insert(array($this,'process_for_insert_ded'));
				$this->crud->callback_after_insert(array($this,'process_extras_after_ded'));
				$this->crud->callback_before_update(array($this,'process_extras_ded'));
				$this->crud->set_soft_delete();
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function ded_signature($var, $primary_key = null) {
		  $this->load->model('deductions_role_model');
		  $signatures = $this->deductions_role_model->getby_ded($primary_key);
		  $roles = $this->roles_model->getall();
		  $global_field = '<div id="hidden-template">'.$this->ded_signature_field($roles, FALSE, FALSE).'</div>';
		  $global_field .= '<div class="field-signature-global .connected">';
		  foreach ($signatures as $signature) {
		    $global_field .= $this->ded_signature_field($roles, $signature['role']);
		  }
		  $global_field .= $this->ded_signature_field($roles);
		  $global_field .= '</div> <br />';
		  $global_field .= '<script type="text/javascript">
		            $(function () {
		              $(".signature-selector").change(function(){
		                var zeroValue = false;
		                $(".field-signature-global .signature-selector").each(function(){
		                  if ($(this).val() == ""){
		                    zeroValue = true;
		                  }
		                });
		              if(!zeroValue) {
		                $clone = $("#hidden-template").children().first().clone(true);
		                $clone.find("select").addClass("chosen-select");
		                $clone.appendTo(".field-signature-global");

		                $(".chosen-select").chosen();
		              }
		              });
		              $(".field-signature-global").sortable({
		                connectWith: ".connected"
		              });
		            });
		          </script>';
		  return $global_field;
		}

		private function ded_signature_field( $roles, $option = FALSE, $chosen = TRUE) {
		  $class = ($chosen)? 'chosen-select' : '';
		  $field = '
		  <div class="form-input-box sortable-selects" >
		    <select name="signatures[]" class="'.$class.' signature-selector" data-placeholder="Select Signature">
		      <option value=""></option>
		      ';
		  foreach ($roles as $role) {
		    $field .= '<option value="'.$role['id'].'" ';
		    $field .= ($option && $option == $role['id'])? ' selected="selected" ' : '';
		    $field .= '>'.$role['role'].'</option>';
		  };
		  $field .= '
		    </select>
		    <span class="icon icon-th-list"></span>
		  </div>
		  ';
		  return $field;
		}

		public function process_for_insert_ded($post_array) {
		  unset($post_array['signatures']);
		  return $post_array;
		}

		public function process_extras_after_ded($post_array, $primary_key) {

		  $this->load->model('deductions_role_model');

		  $this->deductions_role_model->reset_ded($primary_key);

		  foreach ($post_array['signatures'] as $key => $signature) {
		    if ($signature != 0) {
		      $this->deductions_role_model->add_role_ded($primary_key, $signature);
		    }
		  }
		}

		public function process_extras_ded($post_array, $primary_key) {

		  $this->load->model('deductions_role_model');

		  $this->deductions_role_model->reset_ded($primary_key);

		  foreach ($post_array['signatures'] as $key => $signature) {
		    if ($signature != 0) {
		      $this->deductions_role_model->add_role_ded($primary_key, $signature);
		    }
		  }

		  unset($post_array['signatures']);
		  return $post_array;
		}

		public function exchange() {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('exchange');
				$this->crud->set_subject('Exchange Rate');
				$this->crud->columns('id', 'hotel_id', 'date', 'currency');
				$this->crud->set_relation('hotel_id', 'hotels', 'name');
				$this->crud->display_as('currency','Currency');
				$this->crud->display_as('date','Date');
				$this->crud->display_as('hotel_id','Hotel');
				$this->crud->display_as('id', 'ID#');
				$this->crud->add_action('Edit Exchange', '', '','ui-icon-image',array($this,'bank_rate'));
				$this->crud->add_action('Edit Exchange Signatures', '', '','ui-icon-image',array($this,'exchange_signatures'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function exchange_signatures($pk, $row) {
			return '/backend/ex_signatures/'.$pk;
		}

		public function ex_signatures($ex_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('exchange_signature');
				// $this->crud->fields(array('user_id', 'role_id', 'timestamp', 'rank'));
				$this->crud->callback_field('ex_id',array($this,'fixed_ex'));
				$this->crud->display_as('ex_id', "");
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->set_relation('role_id', 'roles', 'role');
				$this->crud->set_relation('department_id', 'departments', 'name');
				$this->crud->set_relation('ex_id', 'exchange', 'currency');
				$this->crud->where('ex_id', $ex_id);
				$this->crud->callback_before_insert(array($this,'ex_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function ex_associates($post_array) {

			$ex_id = $this->uri->segment(3);
			$post_array['ex_id'] = $ex_id;

			return $post_array;
		}

		public function fixed_ex() {
			return '';
		}

		function bank_rate($pk, $row) {
	              return '/backend/bank_rates/'.$pk;
	       }
	       public function bank_rates($ex_id) {
	              try {
	                      $this->crud->set_theme('datatables');
	                      $this->crud->set_table('bank_rate');
						  $this->crud->set_subject('Exchange Rate');
	                      $this->crud->callback_field('exchange_id',array($this,'fixed_bank'));
	                      $this->crud->set_relation('bankid', 'banks', 'bank');
	                      $this->crud->display_as('exchange_id', "Form ID");
						  $this->crud->display_as('bankid', 'Bank');
						  $this->crud->display_as('amount', 'Amount');
						  $this->crud->display_as('rate', 'Rate');
						  $this->crud->display_as('chek', 'Checked');
	                      $this->crud->set_relation('exchange_id', 'exchange', 'id');
	                      $this->crud->where('exchange_id', $ex_id);
	                      $this->crud->callback_before_insert(array($this,'bank_associates'));
	                      $output = $this->crud->render();
							$this->load->view('backend', $output);
	                    }
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function fixed_bank() {
			return '';
		}

		public function bank_associates($post_array) {

			$ex_id = $this->uri->segment(3);
			$post_array['exchange_id'] = $ex_id;

			return $post_array;
		}

		public function ex_sign() {
			try {
				$this->load->model('roles_model');
				$this->crud->set_theme('datatables');
				$this->crud->set_table('exchange_type');
				$this->crud->set_subject('Exchange Rate Signature');
				$this->crud->columns('id', 'dummy');
				$this->crud->display_as('dummy', 'Signatures');
				$this->crud->display_as('id', 'ID#');
				$this->crud->callback_field('dummy',array($this,'ex_signature'));
				$this->crud->callback_before_insert(array($this,'process_for_insert_ex'));
				$this->crud->callback_after_insert(array($this,'process_extras_after_ex'));
				$this->crud->callback_before_update(array($this,'process_extras_ex'));
				$this->crud->set_soft_delete();
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function ex_signature($var, $primary_key = null) {
		  $this->load->model('exchange_role_model');
		  $signatures = $this->exchange_role_model->getby_ex($primary_key);

		  $roles = $this->roles_model->getall();

		  $global_field = '<div id="hidden-template">'.$this->ex_signature_field($roles, FALSE, FALSE).'</div>';
		  $global_field .= '<div class="field-signature-global .connected">';
		  foreach ($signatures as $signature) {
		    $global_field .= $this->ex_signature_field($roles, $signature['role']);
		  }
		  $global_field .= $this->ex_signature_field($roles);
		  $global_field .= '</div> <br />';
		  $global_field .= '<script type="text/javascript">
		            $(function () {
		              $(".signature-selector").change(function(){
		                var zeroValue = false;
		                $(".field-signature-global .signature-selector").each(function(){
		                  if ($(this).val() == ""){
		                    zeroValue = true;
		                  }
		                });
		              if(!zeroValue) {
		                $clone = $("#hidden-template").children().first().clone(true);
		                $clone.find("select").addClass("chosen-select");
		                $clone.appendTo(".field-signature-global");

		                $(".chosen-select").chosen();
		              }
		              });
		              $(".field-signature-global").sortable({
		                connectWith: ".connected"
		              });
		            });
		          </script>';

		  return $global_field;
		}

		private function ex_signature_field( $roles, $option = FALSE, $chosen = TRUE) {
		  $class = ($chosen)? 'chosen-select' : '';
		  $field = '
		  <div class="form-input-box sortable-selects" >
		    <select name="signatures[]" class="'.$class.' signature-selector" data-placeholder="Select Signature">
		      <option value=""></option>
		      ';

		  foreach ($roles as $role) {
		    $field .= '<option value="'.$role['id'].'" ';
		    $field .= ($option && $option == $role['id'])? ' selected="selected" ' : '';
		    $field .= '>'.$role['role'].'</option>';
		  };


		  $field .= '
		    </select>
		    <span class="icon icon-th-list"></span>
		  </div>
		  ';

		  return $field;
		}

		public function process_for_insert_ex($post_array) {
		  unset($post_array['signatures']);
		  return $post_array;
		}

		public function process_extras_after_ex($post_array, $primary_key) {

		  $this->load->model('exchange_role_model');

		  $this->exchange_role_model->reset_ex($primary_key);

		  foreach ($post_array['signatures'] as $key => $signature) {
		    if ($signature != 0) {
		      $this->exchange_role_model->add_role_ex($primary_key, $signature);
		    }
		  }
		}

		public function process_extras_ex($post_array, $primary_key) {

		  $this->load->model('exchange_role_model');

		  $this->exchange_role_model->reset_ex($primary_key);

		  foreach ($post_array['signatures'] as $key => $signature) {
		    if ($signature != 0) {
		      $this->exchange_role_model->add_role_ex($primary_key, $signature);
		    }
		  }

		  unset($post_array['signatures']);
		  return $post_array;
		}

		public function cairo_exchange() {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('cairo_exchange');
				$this->crud->set_subject('Exchange Rate');
				$this->crud->columns('id', 'hotel_id', 'date', 'currency');
				$this->crud->set_relation('hotel_id', 'hotels', 'name');
				$this->crud->display_as('currency','Currency');
				$this->crud->display_as('date','Date');
				$this->crud->display_as('hotel_id','Hotel');
				$this->crud->display_as('id', 'ID#');
				$this->crud->add_action('Edit Exchange', '', '','ui-icon-image',array($this,'cairo_bank_rate'));
				$this->crud->add_action('Edit Exchange Signatures', '', '','ui-icon-image',array($this,'cairo_exchange_signatures'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function cairo_exchange_signatures($pk, $row) {
			return '/backend/cairo_ex_signatures/'.$pk;
		}

		public function cairo_ex_signatures($ex_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('cairo_exchange_signature');
				// $this->crud->fields(array('user_id', 'role_id', 'timestamp', 'rank'));
				$this->crud->callback_field('ex_id',array($this,'cairo_fixed_ex'));
				$this->crud->display_as('ex_id', "");
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->set_relation('role_id', 'roles', 'role');
				$this->crud->set_relation('department_id', 'departments', 'name');
				$this->crud->set_relation('ex_id', 'cairo_exchange', 'currency');
				$this->crud->where('ex_id', $ex_id);
				$this->crud->callback_before_insert(array($this,'cairo_ex_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function cairo_ex_associates($post_array) {

			$ex_id = $this->uri->segment(3);
			$post_array['ex_id'] = $ex_id;

			return $post_array;
		}

		public function cairo_fixed_ex() {
			return '';
		}

		function cairo_bank_rate($pk, $row) {
	              return '/backend/cairo_bank_rates/'.$pk;
	       }
	       public function cairo_bank_rates($ex_id) {
	              try {

	                      $this->crud->set_theme('datatables');
	                      $this->crud->set_table('cairo_bank_rate');
						  $this->crud->set_subject('Exchange Rate');
	                      $this->crud->callback_field('exchange_id',array($this,'cairo_fixed_bank'));
	                      $this->crud->set_relation('bankid', 'banks', 'bank');
	                      $this->crud->display_as('exchange_id', "Form ID");
						  $this->crud->display_as('bankid', 'Bank');
						  $this->crud->display_as('amount', 'Amount');
						  $this->crud->display_as('rate', 'Rate');
						  $this->crud->display_as('chek', 'Checked');
	                      $this->crud->set_relation('exchange_id', 'cairo_exchange', 'id');
	                      $this->crud->where('exchange_id', $ex_id);
	                      $this->crud->callback_before_insert(array($this,'cairo_bank_associates'));
	                      $output = $this->crud->render();
							$this->load->view('backend', $output);
	                    }
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function cairo_fixed_bank() {
			return '';
		}

		public function cairo_bank_associates($post_array) {

			$ex_id = $this->uri->segment(3);
			$post_array['exchange_id'] = $ex_id;

			return $post_array;
		}

		public function cairo_ex_sign() {
			try {
				$this->load->model('roles_model');
				$this->crud->set_theme('datatables');
				$this->crud->set_table('cairo_exchange_type');
				$this->crud->set_subject('Exchange Rate Signature');
				$this->crud->columns('id', 'dummy');
				$this->crud->display_as('dummy', 'Signatures');
				$this->crud->display_as('id', 'ID#');
				$this->crud->callback_field('dummy',array($this,'cairo_ex_signature'));
				$this->crud->callback_before_insert(array($this,'cairo_process_for_insert_ex'));
				$this->crud->callback_after_insert(array($this,'cairo_process_extras_after_ex'));
				$this->crud->callback_before_update(array($this,'cairo_process_extras_ex'));
				$this->crud->set_soft_delete();
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function cairo_ex_signature($var, $primary_key = null) {
		  $this->load->model('cairo_exchange_role_model');
		  $signatures = $this->cairo_exchange_role_model->getby_ex($primary_key);

		  $roles = $this->roles_model->getall();

		  $global_field = '<div id="hidden-template">'.$this->cairo_ex_signature_field($roles, FALSE, FALSE).'</div>';
		  $global_field .= '<div class="field-signature-global .connected">';
		  foreach ($signatures as $signature) {
		    $global_field .= $this->cairo_ex_signature_field($roles, $signature['role']);
		  }
		  $global_field .= $this->cairo_ex_signature_field($roles);
		  $global_field .= '</div> <br />';
		  $global_field .= '<script type="text/javascript">
		            $(function () {
		              $(".signature-selector").change(function(){
		                var zeroValue = false;
		                $(".field-signature-global .signature-selector").each(function(){
		                  if ($(this).val() == ""){
		                    zeroValue = true;
		                  }
		                });
		              if(!zeroValue) {
		                $clone = $("#hidden-template").children().first().clone(true);
		                $clone.find("select").addClass("chosen-select");
		                $clone.appendTo(".field-signature-global");

		                $(".chosen-select").chosen();
		              }
		              });
		              $(".field-signature-global").sortable({
		                connectWith: ".connected"
		              });
		            });
		          </script>';

		  return $global_field;
		}

		private function cairo_ex_signature_field( $roles, $option = FALSE, $chosen = TRUE) {
		  $class = ($chosen)? 'chosen-select' : '';
		  $field = '
		  <div class="form-input-box sortable-selects" >
		    <select name="signatures[]" class="'.$class.' signature-selector" data-placeholder="Select Signature">
		      <option value=""></option>
		      ';

		  foreach ($roles as $role) {
		    $field .= '<option value="'.$role['id'].'" ';
		    $field .= ($option && $option == $role['id'])? ' selected="selected" ' : '';
		    $field .= '>'.$role['role'].'</option>';
		  };


		  $field .= '
		    </select>
		    <span class="icon icon-th-list"></span>
		  </div>
		  ';

		  return $field;
		}

		public function cairo_process_for_insert_ex($post_array) {
		  unset($post_array['signatures']);
		  return $post_array;
		}

		public function cairo_process_extras_after_ex($post_array, $primary_key) {

		  $this->load->model('cairo_exchange_role_model');

		  $this->cairo_exchange_role_model->reset_ex($primary_key);

		  foreach ($post_array['signatures'] as $key => $signature) {
		    if ($signature != 0) {
		      $this->cairo_exchange_role_model->add_role_ex($primary_key, $signature);
		    }
		  }
		}

		public function cairo_process_extras_ex($post_array, $primary_key) {

		  $this->load->model('cairo_exchange_role_model');

		  $this->cairo_exchange_role_model->reset_ex($primary_key);

		  foreach ($post_array['signatures'] as $key => $signature) {
		    if ($signature != 0) {
		      $this->cairo_exchange_role_model->add_role_ex($primary_key, $signature);
		    }
		  }

		  unset($post_array['signatures']);
		  return $post_array;
		}

		public function sky_exchange() {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('sky_exchange');
				$this->crud->set_subject('Exchange Rate');
				$this->crud->columns('id', 'hotel_id', 'date', 'currency');
				$this->crud->set_relation('hotel_id', 'hotels', 'name');
				$this->crud->display_as('currency','Currency');
				$this->crud->display_as('date','Date');
				$this->crud->display_as('hotel_id','Hotel');
				$this->crud->display_as('id', 'ID#');
				$this->crud->add_action('Edit Exchange', '', '','ui-icon-image',array($this,'sky_bank_rate'));
				$this->crud->add_action('Edit Exchange Signatures', '', '','ui-icon-image',array($this,'sky_exchange_signatures'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function sky_exchange_signatures($pk, $row) {
			return '/backend/sky_ex_signatures/'.$pk;
		}

		public function sky_ex_signatures($ex_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('sky_exchange_signature');
				// $this->crud->fields(array('user_id', 'role_id', 'timestamp', 'rank'));
				$this->crud->callback_field('ex_id',array($this,'sky_fixed_ex'));
				$this->crud->display_as('ex_id', "");
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->set_relation('role_id', 'roles', 'role');
				$this->crud->set_relation('department_id', 'departments', 'name');
				$this->crud->set_relation('ex_id', 'sky_exchange', 'currency');
				$this->crud->where('ex_id', $ex_id);
				$this->crud->callback_before_insert(array($this,'sky_ex_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function sky_ex_associates($post_array) {

			$ex_id = $this->uri->segment(3);
			$post_array['ex_id'] = $ex_id;

			return $post_array;
		}

		public function sky_fixed_ex() {
			return '';
		}

		function sky_bank_rate($pk, $row) {
	              return '/backend/sky_bank_rates/'.$pk;
	       }
	       public function sky_bank_rates($ex_id) {
	              try {

	                      $this->crud->set_theme('datatables');
	                      $this->crud->set_table('sky_bank_rate');
						  $this->crud->set_subject('Exchange Rate');
	                      $this->crud->callback_field('exchange_id',array($this,'sky_fixed_bank'));
	                       $this->crud->set_relation('bankid', 'banks', 'bank');
	                      $this->crud->display_as('exchange_id', "Form ID");
						  $this->crud->display_as('bankid', 'Bank');
						  $this->crud->display_as('amount', 'Amount');
						  $this->crud->display_as('rate', 'Rate');
						  $this->crud->display_as('chek', 'Checked');
	                      $this->crud->set_relation('exchange_id', 'sky_exchange', 'id');
	                      $this->crud->where('exchange_id', $ex_id);
	                      $this->crud->callback_before_insert(array($this,'sky_bank_associates'));
	                      $output = $this->crud->render();
							$this->load->view('backend', $output);
	                    }
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function sky_fixed_bank() {
			return '';
		}

		public function sky_bank_associates($post_array) {

			$ex_id = $this->uri->segment(3);
			$post_array['exchange_id'] = $ex_id;

			return $post_array;
		}

		public function sky_ex_sign() {
			try {
				$this->load->model('roles_model');
				$this->crud->set_theme('datatables');
				$this->crud->set_table('exchange_type');
				$this->crud->set_subject('Exchange Rate Signature');
				$this->crud->columns('id', 'dummy');
				$this->crud->display_as('dummy', 'Signatures');
				$this->crud->display_as('id', 'ID#');
				$this->crud->callback_field('dummy',array($this,'sky_ex_signature'));
				$this->crud->callback_before_insert(array($this,'sky_process_for_insert_ex'));
				$this->crud->callback_after_insert(array($this,'sky_process_extras_after_ex'));
				$this->crud->callback_before_update(array($this,'sky_process_extras_ex'));
				$this->crud->set_soft_delete();
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function sky_ex_signature($var, $primary_key = null) {
		  $this->load->model('sky_exchange_role_model');
		  $signatures = $this->sky_exchange_role_model->getby_ex($primary_key);

		  $roles = $this->roles_model->getall();

		  $global_field = '<div id="hidden-template">'.$this->sky_ex_signature_field($roles, FALSE, FALSE).'</div>';
		  $global_field .= '<div class="field-signature-global .connected">';
		  foreach ($signatures as $signature) {
		    $global_field .= $this->sky_ex_signature_field($roles, $signature['role']);
		  }
		  $global_field .= $this->sky_ex_signature_field($roles);
		  $global_field .= '</div> <br />';
		  $global_field .= '<script type="text/javascript">
		            $(function () {
		              $(".signature-selector").change(function(){
		                var zeroValue = false;
		                $(".field-signature-global .signature-selector").each(function(){
		                  if ($(this).val() == ""){
		                    zeroValue = true;
		                  }
		                });
		              if(!zeroValue) {
		                $clone = $("#hidden-template").children().first().clone(true);
		                $clone.find("select").addClass("chosen-select");
		                $clone.appendTo(".field-signature-global");

		                $(".chosen-select").chosen();
		              }
		              });
		              $(".field-signature-global").sortable({
		                connectWith: ".connected"
		              });
		            });
		          </script>';

		  return $global_field;
		}

		private function sky_ex_signature_field( $roles, $option = FALSE, $chosen = TRUE) {
		  $class = ($chosen)? 'chosen-select' : '';
		  $field = '
		  <div class="form-input-box sortable-selects" >
		    <select name="signatures[]" class="'.$class.' signature-selector" data-placeholder="Select Signature">
		      <option value=""></option>
		      ';

		  foreach ($roles as $role) {
		    $field .= '<option value="'.$role['id'].'" ';
		    $field .= ($option && $option == $role['id'])? ' selected="selected" ' : '';
		    $field .= '>'.$role['role'].'</option>';
		  };


		  $field .= '
		    </select>
		    <span class="icon icon-th-list"></span>
		  </div>
		  ';

		  return $field;
		}

		public function sky_process_for_insert_ex($post_array) {
		  unset($post_array['signatures']);
		  return $post_array;
		}

		public function sky_process_extras_after_ex($post_array, $primary_key) {

		  $this->load->model('sky_exchange_role_model');

		  $this->sky_exchange_role_model->reset_ex($primary_key);

		  foreach ($post_array['signatures'] as $key => $signature) {
		    if ($signature != 0) {
		      $this->sky_exchange_role_model->add_role_ex($primary_key, $signature);
		    }
		  }
		}

		public function sky_process_extras_ex($post_array, $primary_key) {

		  $this->load->model('sky_exchange_role_model');

		  $this->sky_exchange_role_model->reset_ex($primary_key);

		  foreach ($post_array['signatures'] as $key => $signature) {
		    if ($signature != 0) {
		      $this->sky_exchange_role_model->add_role_ex($primary_key, $signature);
		    }
		  }

		  unset($post_array['signatures']);
		  return $post_array;
		}

		public function form_after() {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('form_after');
				$this->crud->set_subject('E-claim After Stay Form');
				$this->crud->columns('id','hotel_id', 'operator_id', 'cnf');
				$this->crud->set_relation('hotel_id', 'hotels', 'name');
				$this->crud->set_relation('operator_id', 'operators', 'name');
				$this->crud->display_as('hotel_id','Hotel');
				$this->crud->display_as('operator_id','Operator');
				$this->crud->display_as('cnf','Name of CNF');
				$this->crud->display_as('id', 'ID#');
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function form_in_uk() {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('form_in_uk');
				$this->crud->set_subject('In House Incident Report-UK Form');
				$this->crud->columns('id','hotel_id', 'operator_id', 'irf');
				$this->crud->set_relation('hotel_id', 'hotels', 'name');
				$this->crud->set_relation('operator_id', 'operators', 'name');
				$this->crud->display_as('hotel_id','Hotel');
				$this->crud->display_as('operator_id','Operator');
				$this->crud->display_as('irf','Name of IRF');
				$this->crud->display_as('id', 'ID#');
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}
		public function form_in() {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('form_in');
				$this->crud->set_subject('In House - other nationalities Incident Report Form');
				$this->crud->columns('id','hotel_id', 'operator_id', 'tl');
				$this->crud->set_relation('hotel_id', 'hotels', 'name');
				$this->crud->set_relation('operator_id', 'operators', 'name');
				$this->crud->display_as('hotel_id','Hotel');
				$this->crud->display_as('operator_id','Operator');
				$this->crud->display_as('tl','TL Name');
				$this->crud->display_as('id', 'ID#');
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function settlement() {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('settlement');
				$this->crud->set_subject('settlement');
				$this->crud->columns('id','Date', 'hotel_id', 'form_type');
				$this->crud->set_relation('hotel_id', 'hotels', 'name');
				$this->crud->set_relation('form_type', 'settlement_type', 'name');
				$this->crud->display_as('form_type','settlement Type');
				$this->crud->display_as('hotel_id','Hotel');
				$this->crud->display_as('id', 'ID#');
				$this->crud->add_action('Edit Settlement Signatures', '', '','ui-icon-image',array($this,'settlement_signatures'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function settlement_signatures($pk, $row) {
			return '/backend/set_signatures/'.$pk;
		}

		public function set_signatures($set_id) {
			try {

				$this->crud->set_theme('datatables');
				$this->crud->set_table('settlement_signature');

				// $this->crud->fields(array('user_id', 'role_id', 'timestamp', 'rank'));
				$this->crud->callback_field('set_id',array($this,'fixed_set'));
				$this->crud->display_as('set_id', "");

				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->set_relation('role_id', 'roles', 'role');

				$this->crud->set_relation('set_id', 'settlement', 'File');

				$this->crud->order_by('rank');

				$this->crud->where('set_id', $set_id);


				$this->crud->callback_before_insert(array($this,'set_associates'));

				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function set_associates($post_array) {

			$set_id = $this->uri->segment(3);
			$post_array['set_id'] = $set_id;

			return $post_array;
		}

		public function fixed_set() {
			return '';
		}

		public function settlement_type() {
			try {
				$this->load->model('roles_model');
				$this->crud->set_theme('datatables');
				$this->crud->set_table('settlement_type');
				$this->crud->set_subject('settlement Type');
				$this->crud->columns('name','dummy');
				$this->crud->display_as('dummy', 'Signatures');
				$this->crud->callback_field('dummy',array($this,'set_signature'));
				$this->crud->callback_before_insert(array($this,'process_for_insert_set'));
				$this->crud->callback_after_insert(array($this,'process_extras_after_set'));
				$this->crud->callback_before_update(array($this,'process_extras_set'));
				$this->crud->set_soft_delete();
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}


		public function set_signature($var, $primary_key = null)
		{
		  $this->load->model('settlement_role_model');
		  $signatures = $this->settlement_role_model->getby_set($primary_key);

		  $roles = $this->roles_model->getall();

		  $global_field = '<div id="hidden-template">'.$this->set_signature_field($roles, FALSE, FALSE).'</div>';
		  $global_field .= '<div class="field-signature-global .connected">';
		  foreach ($signatures as $signature) {
		    $global_field .= $this->set_signature_field($roles, $signature['role']);
		  }
		  $global_field .= $this->set_signature_field($roles);
		  $global_field .= '</div> <br />';
		  $global_field .= '<script type="text/javascript">
		            $(function () {
		              $(".signature-selector").change(function(){
		                var zeroValue = false;
		                $(".field-signature-global .signature-selector").each(function(){
		                  if ($(this).val() == ""){
		                    zeroValue = true;
		                  }
		                });
		              if(!zeroValue) {
		                $clone = $("#hidden-template").children().first().clone(true);
		                $clone.find("select").addClass("chosen-select");
		                $clone.appendTo(".field-signature-global");

		                $(".chosen-select").chosen();
		              }
		              });
		              $(".field-signature-global").sortable({
		                connectWith: ".connected"
		              });
		            });
		          </script>';

		  return $global_field;
		}

		private function set_signature_field( $roles, $option = FALSE, $chosen = TRUE) {
		  $class = ($chosen)? 'chosen-select' : '';
		  $field = '
		  <div class="form-input-box sortable-selects" >
		    <select name="signatures[]" class="'.$class.' signature-selector" data-placeholder="Select Signature">
		      <option value=""></option>
		      ';

		  foreach ($roles as $role) {
		    $field .= '<option value="'.$role['id'].'" ';
		    $field .= ($option && $option == $role['id'])? ' selected="selected" ' : '';
		    $field .= '>'.$role['role'].'</option>';
		  };


		  $field .= '
		    </select>
		    <span class="icon icon-th-list"></span>
		  </div>
		  ';

		  return $field;
		}



		public function process_for_insert_set($post_array) {
		  unset($post_array['signatures']);
		  return $post_array;
		}

		public function process_extras_after_set($post_array, $primary_key) {

		  $this->load->model('settlement_role_model');

		  $this->settlement_role_model->reset_set($primary_key);

		  foreach ($post_array['signatures'] as $key => $signature) {
		    if ($signature != 0) {
		      $this->settlement_role_model->add_role_set($primary_key, $signature, $key);
		    }
		  }
		}

		public function process_extras_set($post_array, $primary_key) {

		  $this->load->model('settlement_role_model');

		  $this->settlement_role_model->reset_set($primary_key);

		  foreach ($post_array['signatures'] as $key => $signature) {
		    if ($signature != 0) {
		      $this->settlement_role_model->add_role_set($primary_key, $signature, $key);
		    }
		  }

		  unset($post_array['signatures']);
		  return $post_array;
		}

			public function workshop() {
			try {

				$this->crud->set_theme('datatables');
				$this->crud->set_table('workshop_requests');

				$this->crud->fields(array('timestamp', 'hotel_id', 'name', 'user_id', 'remarks'));

				$this->crud->set_relation('hotel_id', 'hotels', 'name');
				$this->crud->set_relation('user_id', 'users', 'username');

				$this->crud->columns('id', 'timestamp', 'hotel_id', 'name', 'user_id', 'remarks');

				$this->crud->display_as('id', 'ID#');

				$this->crud->add_action('Edit Request Signatures', '', '','ui-icon-image',array($this,'request_signatures'));
				$this->crud->add_action('Edit Request Approvals', '', '','ui-icon-image',array($this,'request_approvals'));

				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function request_signatures($pk, $row) {
			return '/backend/workshop_signatures/'.$pk;
		}

		function request_approvals($pk, $row) {
			return '/backend/workshop_approvals/'.$pk;
		}

		public function workshop_signatures($request_id) {
			try {

				$this->crud->set_theme('datatables');
				$this->crud->set_table('workshop_request_signatures');

				// $this->crud->fields(array('user_id', 'role_id', 'timestamp', 'rank'));
				$this->crud->callback_field('request_id',array($this,'fixed_workshop'));
				$this->crud->display_as('request_id', "");

				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->set_relation('role_id', 'roles', 'role');

				$this->crud->set_relation('request_id', 'workshop_requests', 'name');

				$this->crud->order_by('rank');

				$this->crud->where('request_id', $request_id);


				$this->crud->callback_before_insert(array($this,'workshop_associates'));

				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}


			public function workshop_approvals($request_id) {
			try {

				$this->crud->set_theme('datatables');
				$this->crud->set_table('workshop_request_approvals');

				// $this->crud->fields(array('user_id', 'role_id', 'timestamp', 'rank'));
				$this->crud->callback_field('request_id',array($this,'fixed_workshop'));
				$this->crud->display_as('request_id', "");

				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->set_relation('role_id', 'roles', 'role');

				$this->crud->set_relation('request_id', 'workshop_requests', 'name');

				$this->crud->order_by('rank');

				$this->crud->where('request_id', $request_id);

				$this->crud->callback_before_insert(array($this,'workshop_associates'));

				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}


		public function fixed_workshop() {
			return '';
		}

		public function workshop_associates($post_array) {

			$request_id = $this->uri->segment(3);
			$post_array['request_id'] = $request_id;

			return $post_array;
		}


			public function madar() {
			try {

				$this->crud->set_theme('datatables');
				$this->crud->set_table('madar');

				$this->crud->fields(array('timestamp', 'name', 'reasons', 'type', 'user_id'));

				$this->crud->set_relation('user_id', 'users', 'username');

				$this->crud->columns( 'id','timestamp', 'name', 'reasons', 'type','user_id');

				$this->crud->display_as('id', 'ID#');

				// $this->crud->add_action('Edit Project Approvals', '', '','ui-icon-image',array($this,'project_approvals'));
				$this->crud->add_action('Edit Signatures', '', '','ui-icon-image',array($this,'madars_signatures'));
				$this->crud->add_action('Edit Owner Signatures', '', '','ui-icon-image',array($this,'madars_owning_signatures'));
				$this->crud->add_action('Edit Owner Form', '', '','ui-icon-image',array($this,'madars_owning_form'));

				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function madar_signatures($project_id) {
			try {

				$this->crud->set_theme('datatables');
				$this->crud->set_table('madar_approvals');

				// $this->crud->fields(array('user_id', 'role_id', 'timestamp', 'rank'));
				$this->crud->callback_field('project_id',array($this,'fixed_madar'));
				$this->crud->display_as('project_id', "");

				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->set_relation('role_id', 'roles', 'role');

				$this->crud->set_relation('project_id', 'madar', 'name');

				$this->crud->order_by('rank');

				$this->crud->where('project_id', $project_id);


				$this->crud->callback_before_insert(array($this,'madar_associates'));

				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function madar_owning_signatures($project_id) {
			try {

				$this->crud->set_theme('datatables');
				$this->crud->set_table('madar_owning_signatures');

				// $this->crud->fields(array('user_id', 'role_id', 'timestamp', 'rank'));
				$this->crud->callback_field('project_id',array($this,'fixed_madar'));
				$this->crud->display_as('project_id', "");

				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->set_relation('role_id', 'roles', 'role');

				$this->crud->set_relation('project_id', 'madar', 'name');

				$this->crud->order_by('rank');

				$this->crud->where('project_id', $project_id);


				$this->crud->callback_before_insert(array($this,'madar_associates'));

				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function madar_owning_form($project_id) {
			try {

				$this->crud->set_theme('datatables');
				$this->crud->set_table('madar_owning_form');

				// $this->crud->fields(array('user_id', 'role_id', 'timestamp', 'rank'));
				$this->crud->callback_field('project_id',array($this,'fixed_madar'));
				$this->crud->display_as('project_id', "");

				// $this->crud->set_relation('user_id', 'users', 'fullname');
				// $this->crud->set_relation('role_id', 'roles', 'role');

				$this->crud->set_relation('project_id', 'madar', 'name');

				// $this->crud->order_by('rank');

				$this->crud->where('project_id', $project_id);


				$this->crud->callback_before_insert(array($this,'madar_associates'));

				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}


		public function fixed_madar() {
			return '';
		}

		public function madar_associates($post_array) {

			$project_id = $this->uri->segment(3);
			$post_array['project_id'] = $project_id;

			return $post_array;
		}
		
		function madars_signatures($pk, $row) {
			return '/backend/madar_signatures/'.$pk;
		}

		function madars_owning_signatures($pk, $row) {
			return '/backend/madar_owning_signatures/'.$pk;
		}

		function madars_owning_form($pk, $row) {
			return '/backend/madar_owning_form/'.$pk;
		}

		public function reservations() {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('reservations');
				$this->crud->set_subject('Reservation');
				$this->crud->columns('id', 'user_id', 'hotel_id', 'recived_by', 'name', 'arrival', 'departure', 'timestamp');
				$this->crud->set_relation('hotel_id', 'hotels', 'name');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->set_relation('board_type_id', 'board_type', 'board_type');
				$this->crud->set_relation('res_source_id', 'res_type', 'name');
				$this->crud->set_relation('res_type_id', 'type', 'name');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('hotel_id','Hotel Name');
				$this->crud->display_as('user_id','Created By');
				$this->crud->display_as('recived_by','Requested by');
				$this->crud->display_as('name','Guest Name');
				$this->crud->display_as('arrival','Arrival');
				$this->crud->display_as('departure','Departure');
				$this->crud->display_as('timestamp','Date');
				$this->crud->display_as('adult','Adults');
				$this->crud->display_as('child','Children');
				$this->crud->display_as('no_room','No. of Rooms');
				$this->crud->display_as('agent','Agent/Company');
				$this->crud->display_as('discount','Discount');
				$this->crud->display_as('board_type_id','Board Type');
				$this->crud->display_as('res_type_id','Reservation Type');
				$this->crud->display_as('res_source_id','Reservation Sources');
				$this->crud->display_as('room_type','Room Type');
				$this->crud->display_as('rate','Rate After Discount');
				$this->crud->display_as('currency','Currency');
				$this->crud->display_as('state_id','State');
				$this->crud->display_as('remarks','Remarks');
				$this->crud->add_action('Edit Reservation Comments', '', '','ui-icon-image',array($this,'res_comments'));
				$this->crud->add_action('Edit Reservation Attachments', '', '','ui-icon-image',array($this,'res_attachments'));
				$this->crud->add_action('Edit Reservation Signatures', '', '','ui-icon-image',array($this,'res_signatures'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function res_associates($post_array) {
			$res_id = $this->uri->segment(3);
			$post_array['res_id'] = $res_id;
			return $post_array;
		}

		public function fixed_res() {
			return '';
		}

		function res_comments($pk, $row) {
			return '/backend/res_comment/'.$pk;
		}

		public function res_comment($res_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('reservations_comments');
				$this->crud->set_subject('Reservation Comment');
				$this->crud->callback_field('res_id',array($this,'fixed_res'));
				$this->crud->set_relation('res_id', 'reservations', 'name');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('res_id', 'Guest Name');
				$this->crud->display_as('user_id','Created By');
				$this->crud->display_as('comment','Comment');
				$this->crud->display_as('timestamp','Creation Date');
				$this->crud->where('res_id', $res_id);
				$this->crud->callback_before_insert(array($this,'res_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function res_attachments($pk, $row) {
			return '/backend/res_attachment/'.$pk;
		}

		public function res_attachment($res_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('reservations_filles');
				$this->crud->set_subject('Reservation Attachment');
				$this->crud->callback_field('res_id',array($this,'fixed_res'));
				$this->crud->set_relation('res_id', 'reservations', 'name');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('res_id', 'Guest Name');
				$this->crud->display_as('user_id','Created By');
				$this->crud->display_as('name','Name');
				$this->crud->display_as('timestamp','Creation Date');
				$this->crud->set_field_upload('name','assets/uploads/files');
				$this->crud->where('res_id', $res_id);
				$this->crud->callback_before_insert(array($this,'res_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function res_signatures($pk, $row) {
			return '/backend/res_signature/'.$pk;
		}

		public function res_signature($res_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('reservations_signature');
				$this->crud->set_subject('Reservation Signature');
				$this->crud->callback_field('res_id',array($this,'fixed_res'));
				$this->crud->set_relation('res_id', 'reservations', 'name');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->set_relation('role_id', 'roles', 'role');
				$this->crud->set_relation('department_id', 'departments', 'name');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('res_id', 'Guest Name');
				$this->crud->display_as('user_id','Created By');
				$this->crud->display_as('role_id','Role');
				$this->crud->display_as('department_id','Department');
				$this->crud->display_as('rank','Rank');
				$this->crud->display_as('reject','Reject');
				$this->crud->display_as('timestamp','Creation Date');
				$this->crud->where('res_id', $res_id);
				$this->crud->callback_before_insert(array($this,'res_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function res_source() {
			try {
				$this->load->model('roles_model');
				$this->crud->set_theme('datatables');
				$this->crud->set_table('res_type');
				$this->crud->set_subject('Reservation Source');
				$this->crud->columns('id', 'name', 'dummy');
				$this->crud->display_as('dummy', 'Signatures');
				$this->crud->display_as('name', 'Name');
				$this->crud->display_as('id', 'ID#');
				$this->crud->callback_field('dummy',array($this,'res_sign'));
				$this->crud->callback_before_insert(array($this,'process_for_insert_res'));
				$this->crud->callback_after_insert(array($this,'process_extras_after_res'));
				$this->crud->callback_before_update(array($this,'process_extras_res'));
				$this->crud->set_soft_delete();
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function res_sign($var, $primary_key = null) {
		  	$this->load->model('reservations_role_model');
		  	$signatures = $this->reservations_role_model->getby_res($primary_key);
		  	$roles = $this->roles_model->getall();
		  	$global_field = '<div id="hidden-template">'.$this->res_signature_field($roles, FALSE, FALSE).'</div>';
		  	$global_field .= '<div class="field-signature-global .connected">';
		  	foreach ($signatures as $signature) {
		    	$global_field .= $this->res_signature_field($roles, $signature['role']);
		  	}
		  	$global_field .= $this->res_signature_field($roles);
		  	$global_field .= '</div> <br />';
		  	$global_field .= '<script type="text/javascript">
		        $(function () {
		            $(".signature-selector").change(function(){
		                var zeroValue = false;
		                $(".field-signature-global .signature-selector").each(function(){
		                  	if ($(this).val() == ""){
		                    	zeroValue = true;
		                  	}
		                });
		              	if(!zeroValue) {
			                $clone = $("#hidden-template").children().first().clone(true);
			                $clone.find("select").addClass("chosen-select");
			                $clone.appendTo(".field-signature-global");
		                	$(".chosen-select").chosen();
		              	}
		            });
		            $(".field-signature-global").sortable({
		                connectWith: ".connected"
		            });
		        });
		    </script>';
		  	return $global_field;
		}

		private function res_signature_field( $roles, $option = FALSE, $chosen = TRUE) {
		  	$class = ($chosen)? 'chosen-select' : '';
		  	$field = '
			  	<div class="form-input-box sortable-selects" >
			    	<select name="signatures[]" class="'.$class.' signature-selector" data-placeholder="Select Signature">
			      		<option value=""></option>
			      		';
			  			foreach ($roles as $role) {
						    $field .= '<option value="'.$role['id'].'" ';
						    $field .= ($option && $option == $role['id'])? ' selected="selected" ' : '';
						    $field .= '>'.$role['role'].'</option>';
			  			};
			  			$field .= '
			    	</select>
			    	<span class="icon icon-th-list"></span>
			  	</div>
			';
		  	return $field;
		}

		public function process_for_insert_res($post_array) {
		  	unset($post_array['signatures']);
		 	return $post_array;
		}

		public function process_extras_after_res($post_array, $primary_key) {
		  	$this->load->model('reservations_role_model');
		  	$this->reservations_role_model->reset_res($primary_key);
		  	foreach ($post_array['signatures'] as $key => $signature) {
		    	if ($signature != 0) {
		      		$this->reservations_role_model->add_role_res($primary_key, $signature);
		    	}
		  	}
		}

		public function process_extras_res($post_array, $primary_key) {
		  	$this->load->model('reservations_role_model');
		  	$this->reservations_role_model->reset_res($primary_key);
		  	$rank = 1;
		  	foreach ($post_array['signatures'] as $key => $signature) {
		    	if ($signature != 0) {
		      		$this->reservations_role_model->add_role_res($primary_key, $signature, $rank);
		      		$rank++;
		    	}
		  	}
		  	unset($post_array['signatures']);
		  	return $post_array;
		}

		public function reservation_type() {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('type');
				$this->crud->set_subject('Reservation Type');
				$this->crud->columns('id', 'name');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('name','Type');
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function board_type() {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('board_type');
				$this->crud->set_subject('Board Type');
				$this->crud->columns('id', 'board_type');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('board_type','Board Type');
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function spo() {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('spo');
				$this->crud->set_subject('SPO');
				$this->crud->columns('id', 'hotel_id', 'date', 'season');
				$this->crud->set_relation('hotel_id', 'hotels', 'name');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->display_as('id', 'ID#');
				$this->crud->display_as('percentage', 'Percentage');
				$this->crud->display_as('season', 'Season');
				$this->crud->display_as('Travel_Date', 'Travel Period From');
				$this->crud->display_as('Travel_Date2', 'Travel Period To');
				$this->crud->display_as('arrival_date', 'Arrival Date');
				$this->crud->display_as('arrival_date2', 'Arrival Date');
				$this->crud->display_as('arrival_date3', 'Arrival Date');
				$this->crud->display_as('arrival_date4', 'Arrival Date');
				$this->crud->display_as('arrival_date5', 'Arrival Date');
				$this->crud->display_as('Booking_Window', 'Booking Window From');
				$this->crud->display_as('Booking_Window', 'Booking Window To');
				$this->crud->display_as('to', 'TO');
				$this->crud->display_as('hotel_id', 'Hotel Name');
				$this->crud->display_as('user_id', 'User Name');
				$this->crud->display_as('state_id', 'State');
				$this->crud->add_action('Edit SPO Items', '', '','ui-icon-image',array($this,'spo_items'));
				$this->crud->add_action('Edit SPO Comments', '', '','ui-icon-image',array($this,'spo_comments'));
				$this->crud->add_action('Edit SPO Signatures', '', '','ui-icon-image',array($this,'spo_signatures'));
				$this->crud->add_action('Edit SPO Competition', '', '','ui-icon-image',array($this,'spo_competitions'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function fixed_spo() {
			return '';
		}

		public function spo_associates($post_array) {
			$spo_id = $this->uri->segment(3);
			$post_array['spo_id'] = $spo_id;
			return $post_array;
		}

		public function sign_spo_associates($post_array) {
			$spo_id = $this->uri->segment(3);
			$post_array['forma_spo_id'] = $spo_id;
			return $post_array;
		}

		function spo_items($pk, $row) {
			return '/backend/spo_item/'.$pk;
		}

		public function spo_item($spo_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('spo_items');
				$this->crud->set_subject('SPO Items');
				$this->crud->callback_field('spo_id',array($this,'fixed_spo'));
				$this->crud->set_relation('spo_id', 'spo', 'season');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('spo_id', "Season");
				$this->crud->display_as('peroid_from', "Period From");
				$this->crud->display_as('peroid_to', "Period To");
				$this->crud->display_as('MTD_OCC', "Occupancy MTD Occ%");
				$this->crud->display_as('MTD_month', "Occupancy MTD Month");
				$this->crud->display_as('Contracted_prices', "contracted Rate");
				$this->crud->display_as('spo', "SPO");
				$this->crud->display_as('Discount_percentage', "Discount Persantage %");
				$this->crud->display_as('room_nights', "Room Nights");
				$this->crud->display_as('Materialization_occ', "Matreialization Occ%");
				$this->crud->display_as('Materialization_month', "Matreialization Month");
				$this->crud->display_as('Empty_seats', "Empty Seats");
				$this->crud->display_as('Expected_occupancy', "Expected Occupancy");
				$this->crud->display_as('currency', "Currency");
				$this->crud->where('spo_id', $spo_id);
				$this->crud->callback_before_insert(array($this,'spo_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function spo_comments($pk, $row) {
			return '/backend/spo_comment/'.$pk;
		}

		public function spo_comment($spo_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('spo_comments');
				$this->crud->set_subject('SPO Comments');
				$this->crud->callback_field('spo_id',array($this,'fixed_spo'));
				$this->crud->set_relation('spo_id', 'spo', 'season');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('spo_id', "Season");
				$this->crud->display_as('user_id','Created By');
				$this->crud->display_as('comment','Comment');
				$this->crud->display_as('created','Creation Date');
				$this->crud->display_as('privilege', "Privilege");
				$this->crud->where('spo_id', $spo_id);
				$this->crud->callback_before_insert(array($this,'spo_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function spo_signatures($pk, $row) {
			return '/backend/spo_signature/'.$pk;
		}

		public function spo_signature($spo_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('signature_spo');
				$this->crud->set_subject('SPO Signature');
				$this->crud->callback_field('forma_spo_id',array($this,'fixed_spo'));
				$this->crud->set_relation('forma_spo_id', 'spo', 'season');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->set_relation('role_id', 'roles', 'role');
				$this->crud->display_as('id', 'ID#');
				$this->crud->display_as('forma_spo_id', "Season");
				$this->crud->display_as('user_id','User Name');
				$this->crud->display_as('role_id','Role');
				$this->crud->display_as('rank','Rank');
				$this->crud->display_as('reject', "Reject");
				$this->crud->display_as('timestamp','Creation Date');
				$this->crud->where('forma_spo_id', $spo_id);
				$this->crud->callback_before_insert(array($this,'sign_spo_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function spo_competitions($pk, $row) {
			return '/backend/spo_competition/'.$pk;
		}

		public function spo_competition($spo_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('competition_survey');
				$this->crud->set_subject('SPO Competition');
				$this->crud->callback_field('spo_id',array($this,'fixed_spo'));
				$this->crud->set_relation('spo_id', 'spo', 'season');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('spo_id', "Season");
				$this->crud->display_as('hotel','Hotel');
				$this->crud->display_as('from','Peroid From');
				$this->crud->display_as('to','Peroid To');
				$this->crud->display_as('price', "Price");
				$this->crud->display_as('from2','Peroid From');
				$this->crud->display_as('to2','Peroid To');
				$this->crud->display_as('price', "Price");
				$this->crud->where('spo_id', $spo_id);
				$this->crud->callback_before_insert(array($this,'spo_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function spo_percentage() {
			try {
				$this->load->model('roles_model');
				$this->crud->set_theme('datatables');
				$this->crud->set_table('spo_percentage');
				$this->crud->set_subject('SPO Percentage');
				$this->crud->columns('id', 'name', 'dummy');
				$this->crud->display_as('dummy', "Signatures");
				$this->crud->display_as('name', 'Name');
				$this->crud->display_as('id', 'ID#');
				$this->crud->callback_field('dummy',array($this,'spo_sign'));
				$this->crud->callback_before_insert(array($this,'process_for_insert_spo'));
				$this->crud->callback_after_insert(array($this,'process_extras_after_spo'));
				$this->crud->callback_before_update(array($this,'process_extras_spo'));
				$this->crud->set_soft_delete();
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function spo_sign($var, $primary_key = null){
		  	$this->load->model('roles_model_spo');
		  	$signatures = $this->roles_model_spo->getby_spo($primary_key);
		  	$roles = $this->roles_model->getall();
		  	$global_field = '<div id="hidden-template">'.$this->spo_signature_field($roles, FALSE, FALSE).'</div>';
		  	$global_field .= '<div class="field-signature-global .connected">';
		  	foreach ($signatures as $signature) {
		    	$global_field .= $this->spo_signature_field($roles, $signature['role']);
		  	}
		  	$global_field .= $this->spo_signature_field($roles);
		  	$global_field .= '</div> <br />';
		  	$global_field .= '<script type="text/javascript">
		        $(function () {
		            $(".signature-selector").change(function(){
		                var zeroValue = false;
		                $(".field-signature-global .signature-selector").each(function(){
		                  	if ($(this).val() == ""){
		                    	zeroValue = true;
		                  	}
		                });
		              	if(!zeroValue) {
		                	$clone = $("#hidden-template").children().first().clone(true);
		                	$clone.find("select").addClass("chosen-select");
		                	$clone.appendTo(".field-signature-global");
		                	$(".chosen-select").chosen();
		              	}
		            });
		            $(".field-signature-global").sortable({
		                connectWith: ".connected"
		            });
		        });
		    </script>';
		  	return $global_field;
		}

		private function spo_signature_field( $roles, $option = FALSE, $chosen = TRUE) {
		  	$class = ($chosen)? 'chosen-select' : '';
		  	$field = '
		  		<div class="form-input-box sortable-selects" >
		    		<select name="signatures[]" class="'.$class.' signature-selector" data-placeholder="Select Signature">
		      			<option value=""></option>
		      			';
		  				foreach ($roles as $role) {
						    $field .= '<option value="'.$role['id'].'" ';
						    $field .= ($option && $option == $role['id'])? ' selected="selected" ' : '';
						    $field .= '>'.$role['role'].'</option>';
		  				};
		  				$field .= '
		    		</select>
		    		<span class="icon icon-th-list"></span>
		  		</div>
		  	';
		  	return $field;
		}

		public function process_for_insert_spo($post_array) {
		  	unset($post_array['signatures']);
		  	return $post_array;
		}

		public function process_extras_after_spo($post_array, $primary_key) {
		  	$this->load->model('roles_model_spo');
		  	$this->roles_model_spo->reset_spo($primary_key);
		  	foreach ($post_array['signatures'] as $key => $signature) {
		    	if ($signature != 0) {
		      		$this->roles_model_spo->add_role_spo($primary_key, $signature, $key);
		    	}
		  	}
		}

		public function process_extras_spo($post_array, $primary_key) {
		  	$this->load->model('roles_model_spo');
		  	$this->roles_model_spo->reset_spo($primary_key);
		  	$rank = 1;
		  	foreach ($post_array['signatures'] as $key => $signature) {
		    	if ($signature != 0) {
		     		$this->roles_model_spo->add_role_spo($primary_key, $signature, $rank);
		      		$rank++;
		    	}
		  	}
		  	unset($post_array['signatures']);
		  	return $post_array;
		}

		public function rate_sp() {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('rate_sp');
				$this->crud->set_subject('Special Rates');
				$this->crud->columns('id', 'hotel_id', 'user_id', 'timestamp');
				$this->crud->set_relation('hotel_id', 'hotels', 'name');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->display_as('user_id','User Name');
				$this->crud->display_as('state_id','State');
				$this->crud->display_as('timestamp','Creation Date');
				$this->crud->display_as('hotel_id','Hotel');
				$this->crud->display_as('id', 'ID#');
				$this->crud->display_as('type', 'Type');
				$this->crud->add_action('Edit Special Rates Rooms', '', '','ui-icon-image',array($this,'sp_items'));
				$this->crud->add_action('Edit Special Rates Comments', '', '','ui-icon-image',array($this,'sp_comments'));
				$this->crud->add_action('Edit Special Rates Signatures', '', '','ui-icon-image',array($this,'sp_signatures'));
				$this->crud->add_action('Edit Special Rates Attachments', '', '','ui-icon-image',array($this,'sp_attachments'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function fixed_sp() {
			return '';
		}

		public function sp_associates($post_array) {
			$sp_id = $this->uri->segment(3);
			$post_array['sp_id'] = $sp_id;
			return $post_array;
		}

		function sp_items($pk, $row) {
	        return '/backend/sp_item/'.$pk;
	    }

	    public function sp_item($sp_id) {
	        try {
	            $this->crud->set_theme('datatables');
	            $this->crud->set_table('sp_item');
				$this->crud->set_subject('Special Rates Rooms');
	            $this->crud->callback_field('sp_id',array($this,'fixed_sp'));
				$this->crud->set_relation('board_id', 'board_types', 'board_type');
	            $this->crud->set_relation('sp_id', 'rate_sp', 'timestamp');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->display_as('id', '#');
	            $this->crud->display_as('sp_id', "Creation Date");
				$this->crud->display_as('user_id','Created By');
				$this->crud->display_as('booking', 'Booking');
				$this->crud->display_as('operator', 'Operator');
				$this->crud->display_as('arrival', 'Arrival Date');
				$this->crud->display_as('departure', 'Departure Date');
				$this->crud->display_as('room', 'Room');
				$this->crud->display_as('rate', 'Rate');
				$this->crud->display_as('pax', 'No. Of Pax');
				$this->crud->display_as('publish', 'Publish');
				$this->crud->display_as('currency', 'Currency');
				$this->crud->display_as('currency2', 'Currency');
				$this->crud->display_as('discount', 'Discount');
				$this->crud->display_as('guest', 'Guest Name');
				$this->crud->display_as('room_type', 'Room Type');
				$this->crud->display_as('board_id', 'Board Type');
				$this->crud->display_as('remarks', 'Remarks');
				$this->crud->display_as('fille','Fille Name');
	            $this->crud->display_as('timestamp', "Timestamp");
				$this->crud->set_field_upload('fille','assets/uploads/files');
	            $this->crud->where('sp_id', $sp_id);
	            $this->crud->callback_before_insert(array($this,'sp_associates'));
	            $output = $this->crud->render();
				$this->load->view('backend', $output);
	        }
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function sp_comments($pk, $row) {
			return '/backend/sp_comment/'.$pk;
		}

		public function sp_comment($sp_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('sp_comments');
				$this->crud->set_subject('Special Rates Comments');
				$this->crud->callback_field('sp_id',array($this,'fixed_sp'));
	            $this->crud->set_relation('sp_id', 'rate_sp', 'timestamp');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->display_as('id', '#');
	            $this->crud->display_as('sp_id', "Creation Date");
				$this->crud->display_as('user_id','Created By');
				$this->crud->display_as('comment','Comment');
				$this->crud->display_as('created','Timestamp');
				$this->crud->where('sp_id', $sp_id);
				$this->crud->callback_before_insert(array($this,'sp_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function sp_signatures($pk, $row) {
			return '/backend/sp_signature/'.$pk;
		}

		public function sp_signature($sp_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('sp_signature');
				$this->crud->callback_field('sp_id',array($this,'fixed_sp'));
				$this->crud->set_relation('sp_id', 'rate_sp', 'timestamp');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->set_relation('role_id', 'roles', 'role');
				$this->crud->set_relation('department_id', 'departments', 'name');
				$this->crud->display_as('id', 'ID#');
	            $this->crud->display_as('sp_id', "Creation Date");
	            $this->crud->display_as('user_id','User Name');
				$this->crud->display_as('role_id','Role');
				$this->crud->display_as('department_id','Department');
				$this->crud->display_as('rank','Rank');
				$this->crud->display_as('reject','Reject');
	            $this->crud->display_as('timestamp', "Timestamp");
				$this->crud->where('sp_id', $sp_id);
				$this->crud->callback_before_insert(array($this,'sp_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function sp_attachments($pk, $row) {
			return '/backend/sp_attachment/'.$pk;
		}

		public function sp_attachment($sp_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('sp_filles');
				$this->crud->set_subject('Special Rates Attachment');
				$this->crud->callback_field('sp_id',array($this,'fixed_sp'));
				$this->crud->set_relation('sp_id', 'rate_sp', 'timestamp');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->display_as('id', '#');
	            $this->crud->display_as('sp_id', "Creation Date");
				$this->crud->display_as('user_id','Created By');
				$this->crud->display_as('name','Name');
				$this->crud->display_as('timestamp','Creation Date');
				$this->crud->set_field_upload('name','assets/uploads/files');
				$this->crud->where('sp_id', $sp_id);
				$this->crud->callback_before_insert(array($this,'sp_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function sp_type() {
			try {
				$this->load->model('roles_model');
				$this->crud->set_theme('datatables');
				$this->crud->set_table('sp_type');
				$this->crud->set_subject('Reservation Special Rates Type');
				$this->crud->columns('id', 'name', 'dummy');
				$this->crud->display_as('dummy', 'Signatures');
				$this->crud->display_as('name', 'Name');
				$this->crud->display_as('id', 'ID#');
				$this->crud->callback_field('dummy',array($this,'sp_sign'));
				$this->crud->callback_before_insert(array($this,'process_for_insert_sp'));
				$this->crud->callback_after_insert(array($this,'process_extras_after_sp'));
				$this->crud->callback_before_update(array($this,'process_extras_sp'));
				$this->crud->set_soft_delete();
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function sp_sign($var, $primary_key = null) {
		  	$this->load->model('sp_role_model');
		  	$signatures = $this->sp_role_model->getby_sp($primary_key);
		  	$roles = $this->roles_model->getall();
		  	$global_field = '<div id="hidden-template">'.$this->sp_signature_field($roles, FALSE, FALSE).'</div>';
		  	$global_field .= '<div class="field-signature-global .connected">';
		  	foreach ($signatures as $signature) {
		    	$global_field .= $this->sp_signature_field($roles, $signature['role']);
		  	}
		  	$global_field .= $this->sp_signature_field($roles);
		  	$global_field .= '</div> <br />';
		  	$global_field .= '<script type="text/javascript">
		        $(function () {
		            $(".signature-selector").change(function(){
		                var zeroValue = false;
		                $(".field-signature-global .signature-selector").each(function(){
		                  	if ($(this).val() == ""){
		                    	zeroValue = true;
		                  	}
		                });
		              	if(!zeroValue) {
			                $clone = $("#hidden-template").children().first().clone(true);
			                $clone.find("select").addClass("chosen-select");
			                $clone.appendTo(".field-signature-global");
		                	$(".chosen-select").chosen();
		              	}
		            });
		            $(".field-signature-global").sortable({
		                connectWith: ".connected"
		            });
		        });
		    </script>';
		  	return $global_field;
		}

		private function sp_signature_field( $roles, $option = FALSE, $chosen = TRUE) {
		  	$class = ($chosen)? 'chosen-select' : '';
		  	$field = '
			  	<div class="form-input-box sortable-selects" >
			    	<select name="signatures[]" class="'.$class.' signature-selector" data-placeholder="Select Signature">
			      		<option value=""></option>
			      		';
			  			foreach ($roles as $role) {
						    $field .= '<option value="'.$role['id'].'" ';
						    $field .= ($option && $option == $role['id'])? ' selected="selected" ' : '';
						    $field .= '>'.$role['role'].'</option>';
			  			};
			  			$field .= '
			    	</select>
			    	<span class="icon icon-th-list"></span>
			  	</div>
			';
		  	return $field;
		}

		public function process_for_insert_sp($post_array) {
		  	unset($post_array['signatures']);
		  	return $post_array;
		}

		public function process_extras_after_sp($post_array, $primary_key) {
		  	$this->load->model('sp_role_model');
		  	$this->sp_role_model->reset_sp($primary_key);
		  	foreach ($post_array['signatures'] as $key => $signature) {
		    	if ($signature != 0) {
		      		$this->sp_role_model->add_role_sp($primary_key, $signature);
		    	}
		  	}
		}

		public function process_extras_sp($post_array, $primary_key) {
		  	$this->load->model('sp_role_model');
		  	$this->sp_role_model->reset_sp($primary_key);
		  	$rank = 1;
		  	foreach ($post_array['signatures'] as $key => $signature) {
		    	if ($signature != 0) {
			      	$this->sp_role_model->add_role_sp($primary_key, $signature, $rank);
			      	$rank++;
		    	}
		  	}
		  	unset($post_array['signatures']);
		  	return $post_array;
		}

		public function board_types() {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('board_types');
				$this->crud->set_subject('Board Type');
				$this->crud->columns('id', 'board_type');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('board_type','Board Type');
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function sp_notification() {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('sp_approval_role');
				$this->crud->set_subject('Reservation Special Rates Notification');
				$this->crud->columns('id', 'user_id', 'role', 'department', 'rank', 'sp_type');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->set_relation('role', 'roles', 'role');
				$this->crud->set_relation('department', 'departments', 'name');
				$this->crud->display_as('id', 'ID#');
				$this->crud->display_as('user_id', 'User Name');
				$this->crud->display_as('role', 'Role');
				$this->crud->display_as('department', 'Department');
				$this->crud->display_as('rank', 'Rank');
				$this->crud->display_as('sp_type', 'Type');
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function market() {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('market');
				$this->crud->set_subject('Local Market');
				$this->crud->columns('id', 'user_id', 'timestamp');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->display_as('id', 'ID#');
				$this->crud->display_as('user_id','User Name');
				$this->crud->display_as('ip','IP Address');
				$this->crud->display_as('condition','Conditions');
				$this->crud->display_as('timestamp','Date');
				$this->crud->display_as('state_id','State');
				$this->crud->add_action('Edit Local Market Attachments', '', '','ui-icon-image',array($this,'market_attachments'));
				$this->crud->add_action('Edit Local Market Signatures', '', '','ui-icon-image',array($this,'market_signatures'));
				$this->crud->add_action('Edit Local Market Comments', '', '','ui-icon-image',array($this,'market_comments'));
				$this->crud->add_action('Edit Local Market Lists', '', '','ui-icon-image',array($this,'market_lists'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function market_associates($post_array) {
			$market_id = $this->uri->segment(3);
			$post_array['market_id'] = $market_id;
			return $post_array;
		}

		public function fixed_market() {
			return '';
		}

		function market_attachments($pk, $row) {
			return '/backend/market_attachment/'.$pk;
		}

		public function market_attachment($market_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('market_filles');
				$this->crud->set_subject('Local Market Attachment');
				$this->crud->callback_field('market_id',array($this,'fixed_market'));
				$this->crud->set_relation('market_id', 'market', 'id');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->display_as('id', 'ID#');
				$this->crud->display_as('market_id', 'Form ID#');
				$this->crud->display_as('user_id','Created By');
				$this->crud->display_as('name','Name');
				$this->crud->display_as('timestamp','Creation Date');
				$this->crud->set_field_upload('name','assets/uploads/files');
				$this->crud->where('market_id', $market_id);
				$this->crud->callback_before_insert(array($this,'market_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function market_signatures($pk, $row) {
			return '/backend/market_signature/'.$pk;
		}

		public function market_signature($market_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('market_signature');
				$this->crud->set_subject('Local Market Signature');
				$this->crud->callback_field('market_id',array($this,'fixed_market'));
				$this->crud->set_relation('market_id', 'market', 'id');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->set_relation('role_id', 'roles', 'role');
				$this->crud->set_relation('department_id', 'departments', 'name');
				$this->crud->display_as('id', 'ID#');
				$this->crud->display_as('market_id', 'Form ID#');
				$this->crud->display_as('user_id','Created By');
				$this->crud->display_as('role_id','Role');
				$this->crud->display_as('department_id','Department');
				$this->crud->display_as('rank','Rank');
				$this->crud->display_as('reject','Reject');
				$this->crud->display_as('timestamp','Creation Date');
				$this->crud->where('market_id', $market_id);
				$this->crud->callback_before_insert(array($this,'market_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function market_comments($pk, $row) {
			return '/backend/market_comment/'.$pk;
		}

		public function market_comment($market_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('market_comments');
				$this->crud->set_subject('Local Market Comment');
				$this->crud->callback_field('market_id',array($this,'fixed_market'));
				$this->crud->set_relation('market_id', 'market', 'id');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->display_as('id', 'ID#');
				$this->crud->display_as('market_id', 'Form ID#');
				$this->crud->display_as('user_id','Created By');
				$this->crud->display_as('comment','Comment');
				$this->crud->display_as('timestamp','Creation Date');
				$this->crud->where('market_id', $market_id);
				$this->crud->callback_before_insert(array($this,'market_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function market_lists($pk, $row) {
			return '/backend/market_list/'.$pk;
		}

		public function market_list($market_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('market_defferent');
				$this->crud->set_subject('Local Market List');
				$this->crud->columns('id', 'market_id');
				$this->crud->callback_field('market_id',array($this,'fixed_market'));
				$this->crud->set_relation('market_id', 'market', 'id');
				$this->crud->display_as('id', 'ID#');
				$this->crud->display_as('market_id', 'Form ID#');
				$this->crud->where('market_id', $market_id);
				$this->crud->callback_before_insert(array($this,'market_associates'));
				$this->crud->add_action('Edit Local Market List Periods', '', '','ui-icon-image',array($this,'market_list_periods'));
				$this->crud->add_action('Edit Local Market List Hotels', '', '','ui-icon-image',array($this,'market_list_hotels'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function market_list_associates($post_array) {
			$diff_id = $this->uri->segment(3);
			$post_array['diff_id'] = $diff_id;
			return $post_array;
		}

		public function fixed_market_list() {
			return '';
		}

		function market_list_periods($pk, $row) {
			return '/backend/market_list_period/'.$pk;
		}

		public function market_list_period($diff_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('market_period');
				$this->crud->set_subject('Local Market List Period');
				$this->crud->callback_field('diff_id',array($this,'fixed_market_list'));
				$this->crud->set_relation('diff_id', 'market_defferent', 'market_id');
				$this->crud->display_as('id', 'ID#');
				$this->crud->display_as('diff_id', 'Form ID#');
				$this->crud->display_as('from_date','From');
				$this->crud->display_as('to_date','To');
				$this->crud->where('diff_id', $diff_id);
				$this->crud->callback_before_insert(array($this,'market_list_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function market_list_hotels($pk, $row) {
			return '/backend/market_list_hotel/'.$pk;
		}

		public function market_list_hotel($diff_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('market_hotel');
				$this->crud->set_subject('Local Market List Hotel');
				$this->crud->callback_field('diff_id',array($this,'fixed_market_list'));
				$this->crud->set_relation('diff_id', 'market_defferent', 'market_id');
				$this->crud->set_relation('hotel_id', 'hotels', 'name');
				$this->crud->display_as('id', 'ID#');
				$this->crud->display_as('diff_id', 'Form ID#');
				$this->crud->display_as('hotel_id','Hotel Name');
				$this->crud->display_as('price','Price');
				$this->crud->display_as('currency','Currency');
				$this->crud->where('diff_id', $diff_id);
				$this->crud->callback_before_insert(array($this,'market_list_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function market_type() {
			try {
				$this->load->model('roles_model');
				$this->crud->set_theme('datatables');
				$this->crud->set_table('market_type');
				$this->crud->set_subject('Local Market Type');
				$this->crud->columns('id', 'name', 'dummy');
				$this->crud->display_as('dummy', 'Signatures');
				$this->crud->display_as('name', 'Name');
				$this->crud->display_as('id', 'ID#');
				$this->crud->callback_field('dummy',array($this,'market_sign'));
				$this->crud->callback_before_insert(array($this,'process_for_insert_market'));
				$this->crud->callback_after_insert(array($this,'process_extras_after_market'));
				$this->crud->callback_before_update(array($this,'process_extras_market'));
				$this->crud->set_soft_delete();
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function market_sign($var, $primary_key = null) {
		  	$this->load->model('market_role_model');
		  	$signatures = $this->market_role_model->getby_market($primary_key);
		  	$roles = $this->roles_model->getall();
		  	$global_field = '<div id="hidden-template">'.$this->market_signature_field($roles, FALSE, FALSE).'</div>';
		  	$global_field .= '<div class="field-signature-global .connected">';
		  	foreach ($signatures as $signature) {
		    	$global_field .= $this->market_signature_field($roles, $signature['role']);
		  	}
		  	$global_field .= $this->market_signature_field($roles);
		  	$global_field .= '</div> <br />';
		  	$global_field .= '<script type="text/javascript">
		        $(function () {
		            $(".signature-selector").change(function(){
		                var zeroValue = false;
		                $(".field-signature-global .signature-selector").each(function(){
		                  	if ($(this).val() == ""){
		                    	zeroValue = true;
		                  	}
		                });
		              	if(!zeroValue) {
			                $clone = $("#hidden-template").children().first().clone(true);
			                $clone.find("select").addClass("chosen-select");
			                $clone.appendTo(".field-signature-global");
		                	$(".chosen-select").chosen();
		              	}
		            });
		            $(".field-signature-global").sortable({
		                connectWith: ".connected"
		            });
		        });
		    </script>';
		  	return $global_field;
		}

		private function market_signature_field( $roles, $option = FALSE, $chosen = TRUE) {
		  	$class = ($chosen)? 'chosen-select' : '';
		  	$field = '
			  	<div class="form-input-box sortable-selects" >
			    	<select name="signatures[]" class="'.$class.' signature-selector" data-placeholder="Select Signature">
			      		<option value=""></option>
			      		';
			  			foreach ($roles as $role) {
						    $field .= '<option value="'.$role['id'].'" ';
						    $field .= ($option && $option == $role['id'])? ' selected="selected" ' : '';
						    $field .= '>'.$role['role'].'</option>';
			  			};
			  			$field .= '
			    	</select>
			    	<span class="icon icon-th-list"></span>
			  	</div>
			';
		  	return $field;
		}

		public function process_for_insert_market($post_array) {
		  	unset($post_array['signatures']);
		 	return $post_array;
		}

		public function process_extras_after_market($post_array, $primary_key) {
		  	$this->load->model('market_role_model');
		  	$this->market_role_model->reset_market($primary_key);
		  	foreach ($post_array['signatures'] as $key => $signature) {
		    	if ($signature != 0) {
		      		$this->market_role_model->add_role_market($primary_key, $signature);
		    	}
		  	}
		}

		public function process_extras_market($post_array, $primary_key) {
		  	$this->load->model('market_role_model');
		  	$this->market_role_model->reset_market($primary_key);
		  	$rank = 1;
		  	foreach ($post_array['signatures'] as $key => $signature) {
		    	if ($signature != 0) {
		      		$this->market_role_model->add_role_market($primary_key, $signature, $rank);
		      		$rank++;
		    	}
		  	}
		  	unset($post_array['signatures']);
		  	return $post_array;
		}

		public function credit() {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('credit');
				$this->crud->set_subject('Credit Authorization');
				$this->crud->columns('id', 'user_id', 'hotel_id', 'company', 'period_from', 'period_to', 'timestamp');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->set_relation('hotel_id', 'hotels', 'name');
				$this->crud->set_relation('state_id', 'credit_states', 'name');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('user_id','User');
				$this->crud->display_as('ip','IP');
				$this->crud->display_as('hotel_id','Hotel');
				$this->crud->display_as('date','Date');
				$this->crud->display_as('company','Company');
				$this->crud->display_as('address','Address');
				$this->crud->display_as('person','Person');
				$this->crud->display_as('tele','Telephone');
				$this->crud->display_as('email','E-Mail');
				$this->crud->display_as('period_from','From');
				$this->crud->display_as('period_to','To');
				$this->crud->display_as('rooms','Rooms');
				$this->crud->display_as('contract_type','Contract Type');
				$this->crud->display_as('cash','Cash');
				$this->crud->display_as('currency','Cash Currency');
				$this->crud->display_as('letter','Letter');
				$this->crud->display_as('renew_date','Renew Date');
				$this->crud->display_as('method','Method');
				$this->crud->display_as('limits','Limits');
				$this->crud->display_as('currency1','Limits Currency');
				$this->crud->display_as('note','Note');
				$this->crud->display_as('terms','Terms');
				$this->crud->display_as('ability','Ability');
				$this->crud->display_as('remarks','Remarks');
				$this->crud->display_as('nb','NB');
				$this->crud->display_as('state_id','State');
				$this->crud->display_as('timestamp','Creation Date');
				$this->crud->add_action('Edit Credit Authorization Comments', '', '','ui-icon-image',array($this,'credit_comments'));
				$this->crud->add_action('Edit Credit Authorization Signatures', '', '','ui-icon-image',array($this,'credit_signatures'));
				$this->crud->add_action('Edit Credit Authorization Attachments', '', '','ui-icon-image',array($this,'credit_attachments'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function credit_associates($post_array) {
			$credit_id = $this->uri->segment(3);
			$post_array['credit_id'] = $credit_id;
			return $post_array;
		}

		public function fixed_credit() {
			return '';
		}

		function credit_comments($pk, $row) {
			return '/backend/credit_comment/'.$pk;
		}

		public function credit_comment($credit_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('credit_comments');
				$this->crud->set_subject('Credit Authorization Comment');
				$this->crud->callback_field('credit_id',array($this,'fixed_credit'));
				$this->crud->set_relation('credit_id', 'credit', 'company');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('credit_id', 'Company');
				$this->crud->display_as('user_id','Commented By');
				$this->crud->display_as('comment','Comment');
				$this->crud->display_as('timestamp','Creation Date');
				$this->crud->where('credit_id', $credit_id);
				$this->crud->callback_before_insert(array($this,'credit_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function credit_signatures($pk, $row) {
			return '/backend/credit_signature/'.$pk;
		}

		public function credit_signature($credit_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('credit_signature');
				$this->crud->set_subject('Credit Authorization Signature');
				$this->crud->callback_field('credit_id',array($this,'fixed_credit'));
				$this->crud->set_relation('credit_id', 'credit', 'company');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->set_relation('role_id', 'roles', 'role');
				$this->crud->set_relation('department_id', 'departments', 'name');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('credit_id', 'Company');
				$this->crud->display_as('user_id','Created By');
				$this->crud->display_as('role_id','Role');
				$this->crud->display_as('department_id','Department');
				$this->crud->display_as('rank','Rank');
				$this->crud->display_as('reject','Reject');
				$this->crud->display_as('timestamp','Creation Date');
				$this->crud->where('credit_id', $credit_id);
				$this->crud->callback_before_insert(array($this,'credit_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function credit_attachments($pk, $row) {
			return '/backend/credit_attachment/'.$pk;
		}

		public function credit_attachment($credit_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('credit_filles');
				$this->crud->set_subject('Credit Authorization Attachment');
				$this->crud->callback_field('credit_id',array($this,'fixed_credit'));
				$this->crud->set_relation('credit_id', 'credit', 'company');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('credit_id', 'Company');
				$this->crud->display_as('user_id','Uploaded By');
				$this->crud->display_as('name','Name');
				$this->crud->display_as('timestamp','Creation Date');
				$this->crud->set_field_upload('name','assets/uploads/files');
				$this->crud->where('credit_id', $credit_id);
				$this->crud->callback_before_insert(array($this,'credit_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function credit_sign() {
			try {
				$this->load->model('roles_model');
				$this->load->model('Departments_model');
				$this->crud->set_theme('datatables');
				$this->crud->set_table('credit_type');
				$this->crud->set_subject('Credit Authorization Signatures');
				$this->crud->columns('id', 'name', 'dummy', 'dummy1');
				$this->crud->display_as('dummy', 'Role Signatures');
				$this->crud->display_as('dummy1', 'Department Signatures');
				$this->crud->display_as('name', 'Name');
				$this->crud->display_as('id', 'ID#');
				$this->crud->callback_field('dummy',array($this,'credit_role_sign'));
				$this->crud->callback_field('dummy1',array($this,'credit_department_sign'));
				$this->crud->callback_before_insert(array($this,'process_for_insert_credit'));
				$this->crud->callback_after_insert(array($this,'process_extras_after_credit'));
				$this->crud->callback_before_update(array($this,'process_extras_credit'));
				$this->crud->set_soft_delete();
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function process_for_insert_credit($post_array) {
		  	unset($post_array['roles']);
		  	unset($post_array['departments']);
		 	return $post_array;
		}

		public function process_extras_after_credit($post_array, $primary_key) {
		  	$this->load->model('credit_role_model');
		  	$this->credit_role_model->reset_credit($primary_key);
		  	$rank = 1;
		  	$resulte =  array();
		  	foreach ($post_array['roles'] as $key => $role) {
		    	if ($role != 0) {
		      		$sign_id = $this->credit_role_model->add_role_credit($primary_key, $role, $rank);
		      		$resulte[] = $sign_id;
		      		$rank++;
		    	}
		  	}
		  	foreach ($post_array['departments'] as $key => $department) {
		    	if ($department != 0) {
		      		$this->credit_role_model->add_department_credit($primary_key, $department, $resulte[$key]);
		    	}
		  	}
		}

		public function process_extras_credit($post_array, $primary_key) {
		  	$this->load->model('credit_role_model');
		  	$this->credit_role_model->reset_credit($primary_key);
		  	$rank = 1;
		  	$resulte =  array();
		  	foreach ($post_array['roles'] as $key => $role) {
		    	if ($role != 0) {
		      		$sign_id = $this->credit_role_model->add_role_credit($primary_key, $role, $rank);
		      		$resulte[] = $sign_id;
		      		$rank++;
		    	}
		  	}
		  	foreach ($post_array['departments'] as $key => $department) {
		    	if ($department != 0) {
		      		$this->credit_role_model->add_department_credit($primary_key, $department, $resulte[$key]);
		    	}
		  	}
		  	unset($post_array['roles']);
		  	unset($post_array['departments']);
		  	return $post_array;
		}

		public function credit_role_sign($var, $primary_key = null) {
		  	$this->load->model('credit_role_model');
		  	$credit_roles = $this->credit_role_model->getby_credit($primary_key);
		  	$all_roles = $this->roles_model->getall();
		  	$global_field = '<div id="role-hidden-template" style="display:none">'.$this->credit_role_signature_field($all_roles, FALSE, FALSE).'</div>';
		  	$global_field .= '<div class="field-role-global .connected">';
		  	foreach ($credit_roles as $credit_role) {
		    	$global_field .= $this->credit_role_signature_field($all_roles, $credit_role['role']);
		  	}
		  	$global_field .= $this->credit_role_signature_field($all_roles);
		  	$global_field .= '</div> <br />';
		  	$global_field .= '<script type="text/javascript">
		        $(function () {
		            $(".role-selector").change(function(){
		                var zeroValue = false;
		                $(".field-role-global .role-selector").each(function(){
		                  	if ($(this).val() == ""){
		                    	zeroValue = true;
		                  	}
		                });
		              	if(!zeroValue) {
			                $clone = $("#role-hidden-template").children().first().clone(true);
			                $clone.find("select").addClass("chosen-select");
			                $clone.appendTo(".field-role-global");
		                	$(".chosen-select").chosen();
		              	}
		            });
		            $(".field-role-global").sortable({
		                connectWith: ".connected"
		            });
		        });
		    </script>';
		  	return $global_field;
		}

		private function credit_role_signature_field( $all_roles, $option = FALSE, $chosen = TRUE) {
		  	$class = ($chosen)? 'chosen-select' : '';
		  	$field = '
			  	<div class="form-input-box sortable-selects" >
			    	<select name="roles[]" class="'.$class.' role-selector" data-placeholder="Select Role">
			      		<option value=""></option>
			      		';
			  			foreach ($all_roles as $role) {
						    $field .= '<option value="'.$role['id'].'" ';
						    $field .= ($option && $option == $role['id'])? ' selected="selected" ' : '';
						    $field .= '>'.$role['role'].'</option>';
			  			};
			  			$field .= '
			    	</select>
			    	<span class="icon icon-th-list"></span>
			  	</div>
			';
		  	return $field;
		}

		public function credit_department_sign($var, $primary_key = null) {
		  	$this->load->model('credit_role_model');
		  	$credit_departments = $this->credit_role_model->getby_credit($primary_key);
		  	$all_departments = $this->Departments_model->getall();
		  	$global_field = '<div class="field-department-global .connected">';
		  	foreach ($credit_departments as $credit_department) {
		    	$global_field .= $this->credit_department_signature_field($all_departments, $credit_department['department']);
		  	}
		  	$global_field .= $this->credit_department_signature_field($all_departments);
		  	$global_field .= '</div> <br />';
		  	return $global_field;
		}

		private function credit_department_signature_field( $all_departments, $option = FALSE, $chosen = TRUE) {
		  	$class = ($chosen)? 'chosen-select' : '';
		  	$field = '
			  	<div class="form-input-box sortable-selects" >
			    	<select name="departments[]" class="'.$class.' department-selector" data-placeholder="Select Department">
			      		<option value=""></option>
			      		';
			  			foreach ($all_departments as $department) {
						    $field .= '<option value="'.$department['id'].'" ';
						    $field .= ($option && $option == $department['id'])? ' selected="selected" ' : '';
						    $field .= '>'.$department['name'].'</option>';
			  			};
			  			$field .= '
			    	</select>
			    	<span class="icon icon-th-list"></span>
			  	</div>
			';
		  	return $field;
		}

		public function credit_states() {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('credit_states');
				$this->crud->set_subject('Credit Authorization State');
				$this->crud->columns('id', 'name');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('name','State');
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}


		public function position() {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('position');
				$this->crud->set_subject('Hiring Position');
				$this->crud->columns('id', 'user_id', 'hotel_id', 'date', 'timestamp');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->set_relation('hotel_id', 'hotels', 'name');
				$this->crud->set_relation('role_id', 'roles', 'role');
				$this->crud->set_relation('department_id', 'departments', 'name');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('user_id','User');
				$this->crud->display_as('hotel_id','Hotel');
				$this->crud->display_as('role_id','Role');
				$this->crud->display_as('department_id','Department');
				$this->crud->display_as('date','Date');
				$this->crud->display_as('state_id','State');
				$this->crud->display_as('timestamp','Creation Date');
				$this->crud->add_action('Edit Hiring Position Comments', '', '','ui-icon-image',array($this,'position_comments'));
				$this->crud->add_action('Edit Hiring Position Signatures', '', '','ui-icon-image',array($this,'position_signatures'));
				$this->crud->add_action('Edit Hiring Position Requests', '', '','ui-icon-image',array($this,'position_requests'));
				$this->crud->add_action('Edit Hiring Position Replaies', '', '','ui-icon-image',array($this,'position_replay_bases'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function position_associates($post_array) {
			$pos_id = $this->uri->segment(3);
			$post_array['pos_id'] = $pos_id;
			return $post_array;
		}

		public function fixed_position() {
			return '';
		}

		function position_comments($pk, $row) {
			return '/backend/position_comment/'.$pk;
		}

		public function position_comment($pos_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('position_comments');
				$this->crud->set_subject('Hiring Position Comment');
				$this->crud->callback_field('pos_id',array($this,'fixed_position'));
				$this->crud->set_relation('pos_id', 'position', 'date');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('pos_id', 'Date');
				$this->crud->display_as('user_id','Commented By');
				$this->crud->display_as('comment','Comment');
				$this->crud->display_as('created','Creation Date');
				$this->crud->where('pos_id', $pos_id);
				$this->crud->callback_before_insert(array($this,'position_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function position_signatures($pk, $row) {
			return '/backend/position_signature/'.$pk;
		}

		public function position_signature($pos_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('position_signature');
				$this->crud->set_subject('Hiring Position Signature');
				$this->crud->callback_field('pos_id',array($this,'fixed_position'));
				$this->crud->set_relation('pos_id', 'position', 'date');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->set_relation('role_id', 'roles', 'role');
				$this->crud->set_relation('department_id', 'departments', 'name');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('pos_id', 'Date');
				$this->crud->display_as('user_id','Created By');
				$this->crud->display_as('role_id','Role');
				$this->crud->display_as('department_id','Department');
				$this->crud->display_as('rank','Rank');
				$this->crud->display_as('reject','Reject');
				$this->crud->display_as('timestamp','Creation Date');
				$this->crud->where('pos_id', $pos_id);
				$this->crud->callback_before_insert(array($this,'position_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function position_requests($pk, $row) {
			return '/backend/position_request/'.$pk;
		}

		public function position_request($pos_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('position_request');
				$this->crud->set_subject('Hiring Position Attachment');
				$this->crud->callback_field('pos_id',array($this,'fixed_position'));
				$this->crud->set_relation('pos_id', 'position', 'date');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('pos_id', 'Date');
				$this->crud->display_as('position','Position');
				$this->crud->display_as('froms','From');
				$this->crud->display_as('avrg','Avarge');
				$this->crud->display_as('tos','To');
				$this->crud->display_as('level','Level');
				$this->crud->where('pos_id', $pos_id);
				$this->crud->callback_before_insert(array($this,'position_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function position_replay_bases($pk, $row) {
			return '/backend/position_replay_base/'.$pk;
		}

		public function position_replay_base($pos_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('position_replay_base');
				$this->crud->set_subject('Hiring Position Replay');
				$this->crud->callback_field('pos_id',array($this,'fixed_position'));
				$this->crud->set_relation('pos_id', 'position', 'date');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('user_id','Created By');
				$this->crud->display_as('pos_id', 'Date');
				$this->crud->display_as('timestamp','Timestamp');
				$this->crud->where('pos_id', $pos_id);
				$this->crud->callback_before_insert(array($this,'position_associates'));
				$this->crud->add_action('Edit Hiring Position Requires', '', '','ui-icon-image',array($this,'position_requires'));
				$this->crud->add_action('Edit Hiring Position Replaies', '', '','ui-icon-image',array($this,'position_replaies'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function position_base_associates($post_array) {
			$base_id = $this->uri->segment(3);
			$post_array['base_id'] = $base_id;
			return $post_array;
		}

		public function fixed_position_base() {
			return '';
		}

		function position_requires($pk, $row) {
			return '/backend/position_require/'.$pk;
		}

		public function position_require($base_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('position_require');
				$this->crud->set_subject('Hiring Position Require');
				$this->crud->callback_field('base_id',array($this,'fixed_position_base'));
				$this->crud->set_relation('base_id', 'position_replay_base', 'timestamp');
				$this->crud->set_relation('pos_id', 'position', 'date');
				$this->crud->set_relation('hotel_id', 'hotels', 'name');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('pos_id', 'Date');
				$this->crud->display_as('base_id', 'Creation Date');
				$this->crud->display_as('name','Name');
				$this->crud->display_as('position','Position');
				$this->crud->display_as('hotel_id','Hotel');
				$this->crud->where('base_id', $base_id);
				$this->crud->callback_before_insert(array($this,'position_base_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function position_replaies($pk, $row) {
			return '/backend/position_replay/'.$pk;
		}

		public function position_replay($base_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('position_replay');
				$this->crud->set_subject('Hiring Position Replay');
				$this->crud->callback_field('base_id',array($this,'fixed_position_base'));
				$this->crud->set_relation('base_id', 'position_replay_base', 'timestamp');
				$this->crud->set_relation('pos_id', 'position', 'date');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->set_relation('hotel_id', 'hotels', 'name');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('user_id','Created By');
				$this->crud->display_as('hotel_id','Hotel');
				$this->crud->display_as('pos_id', 'Date');
				$this->crud->display_as('base_id', 'Creation Date');
				$this->crud->display_as('replay','Replay');
				$this->crud->display_as('state_id','State');
				$this->crud->display_as('timestamp','Timestamp');
				$this->crud->where('base_id', $base_id);
				$this->crud->callback_before_insert(array($this,'position_base_associates'));
				$this->crud->add_action('Edit Hiring Position Replay Signatures', '', '','ui-icon-image',array($this,'position_replay_signatures'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function position_replay_associates($post_array) {
			$rep_id = $this->uri->segment(3);
			$post_array['rep_id'] = $rep_id;
			return $post_array;
		}

		public function fixed_position_replay() {
			return '';
		}

		function position_replay_signatures($pk, $row) {
			return '/backend/position_replay_signature/'.$pk;
		}

		public function position_replay_signature($rep_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('position_replay_signature');
				$this->crud->set_subject('Hiring Position Replay Signature');
				$this->crud->callback_field('rep_id',array($this,'fixed_position_replay'));
				$this->crud->set_relation('rep_id', 'position_replay', 'timestamp');
				$this->crud->set_relation('pos_id', 'position', 'date');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->set_relation('hotel_id', 'hotels', 'name');
				$this->crud->set_relation('role_id', 'roles', 'role');
				$this->crud->set_relation('department_id', 'departments', 'name');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('rep_id', 'Timestamp');
				$this->crud->display_as('pos_id', 'Date');
				$this->crud->display_as('user_id','Created By');
				$this->crud->display_as('hotel_id','Hotel');
				$this->crud->display_as('role_id','Role');
				$this->crud->display_as('department_id','Department');
				$this->crud->display_as('rank','Rank');
				$this->crud->display_as('reject','Reject');
				$this->crud->display_as('timestamp','Creation Date');
				$this->crud->where('rep_id', $rep_id);
				$this->crud->callback_before_insert(array($this,'position_replay_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function position_sign() {
			try {
				$this->load->model('roles_model');
				$this->load->model('Departments_model');
				$this->crud->set_theme('datatables');
				$this->crud->set_table('position_type');
				$this->crud->set_subject('Hiring Position Signatures');
				$this->crud->columns('id', 'name', 'dummy', 'dummy1');
				$this->crud->display_as('dummy', 'Role Signatures');
				$this->crud->display_as('dummy1', 'Department Signatures');
				$this->crud->display_as('name', 'Name');
				$this->crud->display_as('id', 'ID#');
				$this->crud->callback_field('dummy',array($this,'position_role_sign'));
				$this->crud->callback_field('dummy1',array($this,'position_department_sign'));
				$this->crud->callback_before_insert(array($this,'process_for_insert_position'));
				$this->crud->callback_after_insert(array($this,'process_extras_after_position'));
				$this->crud->callback_before_update(array($this,'process_extras_position'));
				$this->crud->set_soft_delete();
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function process_for_insert_position($post_array) {
		  	unset($post_array['roles']);
		  	unset($post_array['departments']);
		 	return $post_array;
		}

		public function process_extras_after_position($post_array, $primary_key) {
		  	$this->load->model('position_role_model');
		  	$this->position_role_model->reset_position($primary_key);
		  	$rank = 1;
		  	$resulte =  array();
		  	foreach ($post_array['roles'] as $key => $role) {
		    	if ($role != 0) {
		      		$sign_id = $this->position_role_model->add_role_position($primary_key, $role, $rank);
		      		$resulte[] = $sign_id;
		      		$rank++;
		    	}
		  	}
		  	foreach ($post_array['departments'] as $key => $department) {
		    	if ($department != 0) {
		      		$this->position_role_model->add_department_position($primary_key, $department, $resulte[$key]);
		    	}
		  	}
		}

		public function process_extras_position($post_array, $primary_key) {
		  	$this->load->model('position_role_model');
		  	$this->position_role_model->reset_position($primary_key);
		  	$rank = 1;
		  	$resulte =  array();
		  	foreach ($post_array['roles'] as $key => $role) {
		    	if ($role != 0) {
		      		$sign_id = $this->position_role_model->add_role_position($primary_key, $role, $rank);
		      		$resulte[] = $sign_id;
		      		$rank++;
		    	}
		  	}
		  	foreach ($post_array['departments'] as $key => $department) {
		    	if ($department != 0) {
		      		$this->position_role_model->add_department_position($primary_key, $department, $resulte[$key]);
		    	}
		  	}
		  	unset($post_array['roles']);
		  	unset($post_array['departments']);
		  	return $post_array;
		}

		public function position_role_sign($var, $primary_key = null) {
		  	$this->load->model('position_role_model');
		  	$position_roles = $this->position_role_model->getby_position($primary_key);
		  	$all_roles = $this->roles_model->getall();
		  	$global_field = '<div id="role-hidden-template" style="display:none">'.$this->position_role_signature_field($all_roles, FALSE, FALSE).'</div>';
		  	$global_field .= '<div class="field-role-global .connected">';
		  	foreach ($position_roles as $position_role) {
		    	$global_field .= $this->position_role_signature_field($all_roles, $position_role['role']);
		  	}
		  	$global_field .= $this->position_role_signature_field($all_roles);
		  	$global_field .= '</div> <br />';
		  	$global_field .= '<script type="text/javascript">
		        $(function () {
		            $(".role-selector").change(function(){
		                var zeroValue = false;
		                $(".field-role-global .role-selector").each(function(){
		                  	if ($(this).val() == ""){
		                    	zeroValue = true;
		                  	}
		                });
		              	if(!zeroValue) {
			                $clone = $("#role-hidden-template").children().first().clone(true);
			                $clone.find("select").addClass("chosen-select");
			                $clone.appendTo(".field-role-global");
		                	$(".chosen-select").chosen();
		              	}
		            });
		            $(".field-role-global").sortable({
		                connectWith: ".connected"
		            });
		        });
		    </script>';
		  	return $global_field;
		}

		private function position_role_signature_field( $all_roles, $option = FALSE, $chosen = TRUE) {
		  	$class = ($chosen)? 'chosen-select' : '';
		  	$field = '
			  	<div class="form-input-box sortable-selects" >
			    	<select name="roles[]" class="'.$class.' role-selector" data-placeholder="Select Role">
			      		<option value=""></option>
			      		';
			  			foreach ($all_roles as $role) {
						    $field .= '<option value="'.$role['id'].'" ';
						    $field .= ($option && $option == $role['id'])? ' selected="selected" ' : '';
						    $field .= '>'.$role['role'].'</option>';
			  			};
			  			$field .= '
			    	</select>
			    	<span class="icon icon-th-list"></span>
			  	</div>
			';
		  	return $field;
		}

		public function position_department_sign($var, $primary_key = null) {
		  	$this->load->model('position_role_model');
		  	$position_departments = $this->position_role_model->getby_position($primary_key);
		  	$all_departments = $this->Departments_model->getall();
		  	$global_field = '<div class="field-department-global .connected">';
		  	foreach ($position_departments as $position_department) {
		    	$global_field .= $this->position_department_signature_field($all_departments, $position_department['department']);
		  	}
		  	$global_field .= $this->position_department_signature_field($all_departments);
		  	$global_field .= '</div> <br />';
		  	return $global_field;
		}

		private function position_department_signature_field( $all_departments, $option = FALSE, $chosen = TRUE) {
		  	$class = ($chosen)? 'chosen-select' : '';
		  	$field = '
			  	<div class="form-input-box sortable-selects" >
			    	<select name="departments[]" class="'.$class.' department-selector" data-placeholder="Select Department">
			      		<option value=""></option>
			      		';
			  			foreach ($all_departments as $department) {
						    $field .= '<option value="'.$department['id'].'" ';
						    $field .= ($option && $option == $department['id'])? ' selected="selected" ' : '';
						    $field .= '>'.$department['name'].'</option>';
			  			};
			  			$field .= '
			    	</select>
			    	<span class="icon icon-th-list"></span>
			  	</div>
			';
		  	return $field;
		}

		public function position_replay_sign() {
			try {
				$this->load->model('roles_model');
				$this->load->model('Departments_model');
				$this->crud->set_theme('datatables');
				$this->crud->set_table('position_replay_type');
				$this->crud->set_subject('Hiring Position Replay Signatures');
				$this->crud->columns('id', 'name', 'dummy', 'dummy1');
				$this->crud->display_as('dummy', 'Role Signatures');
				$this->crud->display_as('dummy1', 'Department Signatures');
				$this->crud->display_as('name', 'Name');
				$this->crud->display_as('id', 'ID#');
				$this->crud->callback_field('dummy',array($this,'position_replay_role_sign'));
				$this->crud->callback_field('dummy1',array($this,'position_replay_department_sign'));
				$this->crud->callback_before_insert(array($this,'process_for_insert_position_replay'));
				$this->crud->callback_after_insert(array($this,'process_extras_after_position_replay'));
				$this->crud->callback_before_update(array($this,'process_extras_position_replay'));
				$this->crud->set_soft_delete();
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function process_for_insert_position_replay($post_array) {
		  	unset($post_array['roles']);
		  	unset($post_array['departments']);
		 	return $post_array;
		}

		public function process_extras_after_position_replay($post_array, $primary_key) {
		  	$this->load->model('position_role_model');
		  	$this->position_role_model->reset_position_replay($primary_key);
		  	$rank = 1;
		  	$resulte =  array();
		  	foreach ($post_array['roles'] as $key => $role) {
		    	if ($role != 0) {
		      		$sign_id = $this->position_role_model->add_role_position_replay($primary_key, $role, $rank);
		      		$resulte[] = $sign_id;
		      		$rank++;
		    	}
		  	}
		  	foreach ($post_array['departments'] as $key => $department) {
		    	if ($department != 0) {
		      		$this->position_role_model->add_department_position_replay($primary_key, $department, $resulte[$key]);
		    	}
		  	}
		}

		public function process_extras_position_replay($post_array, $primary_key) {
		  	$this->load->model('position_role_model');
		  	$this->position_role_model->reset_position_replay($primary_key);
		  	$rank = 1;
		  	$resulte =  array();
		  	foreach ($post_array['roles'] as $key => $role) {
		    	if ($role != 0) {
		      		$sign_id = $this->position_role_model->add_role_position_replay($primary_key, $role, $rank);
		      		$resulte[] = $sign_id;
		      		$rank++;
		    	}
		  	}
		  	foreach ($post_array['departments'] as $key => $department) {
		    	if ($department != 0) {
		      		$this->position_role_model->add_department_position_replay($primary_key, $department, $resulte[$key]);
		    	}
		  	}
		  	unset($post_array['roles']);
		  	unset($post_array['departments']);
		  	return $post_array;
		}

		public function position_replay_role_sign($var, $primary_key = null) {
		  	$this->load->model('position_role_model');
		  	$position_roles = $this->position_role_model->getby_position_replay($primary_key);
		  	$all_roles = $this->roles_model->getall();
		  	$global_field = '<div id="role-hidden-template" style="display:none">'.$this->position_replay_role_signature_field($all_roles, FALSE, FALSE).'</div>';
		  	$global_field .= '<div class="field-role-global .connected">';
		  	foreach ($position_roles as $position_role) {
		    	$global_field .= $this->position_replay_role_signature_field($all_roles, $position_role['role']);
		  	}
		  	$global_field .= $this->position_replay_role_signature_field($all_roles);
		  	$global_field .= '</div> <br />';
		  	$global_field .= '<script type="text/javascript">
		        $(function () {
		            $(".role-selector").change(function(){
		                var zeroValue = false;
		                $(".field-role-global .role-selector").each(function(){
		                  	if ($(this).val() == ""){
		                    	zeroValue = true;
		                  	}
		                });
		              	if(!zeroValue) {
			                $clone = $("#role-hidden-template").children().first().clone(true);
			                $clone.find("select").addClass("chosen-select");
			                $clone.appendTo(".field-role-global");
		                	$(".chosen-select").chosen();
		              	}
		            });
		            $(".field-role-global").sortable({
		                connectWith: ".connected"
		            });
		        });
		    </script>';
		  	return $global_field;
		}

		private function position_replay_role_signature_field( $all_roles, $option = FALSE, $chosen = TRUE) {
		  	$class = ($chosen)? 'chosen-select' : '';
		  	$field = '
			  	<div class="form-input-box sortable-selects" >
			    	<select name="roles[]" class="'.$class.' role-selector" data-placeholder="Select Role">
			      		<option value=""></option>
			      		';
			  			foreach ($all_roles as $role) {
						    $field .= '<option value="'.$role['id'].'" ';
						    $field .= ($option && $option == $role['id'])? ' selected="selected" ' : '';
						    $field .= '>'.$role['role'].'</option>';
			  			};
			  			$field .= '
			    	</select>
			    	<span class="icon icon-th-list"></span>
			  	</div>
			';
		  	return $field;
		}

		public function position_replay_department_sign($var, $primary_key = null) {
		  	$this->load->model('position_role_model');
		  	$position_departments = $this->position_role_model->getby_position_replay($primary_key);
		  	$all_departments = $this->Departments_model->getall();
		  	$global_field = '<div class="field-department-global .connected">';
		  	foreach ($position_departments as $position_department) {
		    	$global_field .= $this->position_replay_department_signature_field($all_departments, $position_department['department']);
		  	}
		  	$global_field .= $this->position_replay_department_signature_field($all_departments);
		  	$global_field .= '</div> <br />';
		  	return $global_field;
		}

		private function position_replay_department_signature_field( $all_departments, $option = FALSE, $chosen = TRUE) {
		  	$class = ($chosen)? 'chosen-select' : '';
		  	$field = '
			  	<div class="form-input-box sortable-selects" >
			    	<select name="departments[]" class="'.$class.' department-selector" data-placeholder="Select Department">
			      		<option value=""></option>
			      		';
			  			foreach ($all_departments as $department) {
						    $field .= '<option value="'.$department['id'].'" ';
						    $field .= ($option && $option == $department['id'])? ' selected="selected" ' : '';
						    $field .= '>'.$department['name'].'</option>';
			  			};
			  			$field .= '
			    	</select>
			    	<span class="icon icon-th-list"></span>
			  	</div>
			';
		  	return $field;
		}

		public function amenitys() {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('amenitys');
				$this->crud->set_subject('Guest Amenity Request');
				$this->crud->columns('id', 'hotel_id', 'timestamp', 'date_time');
				$this->crud->set_relation('hotel_id', 'hotels', 'name');
				$this->crud->set_relation('type_id', 'amenitys_types', 'name');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->set_relation('user_id_reason', 'users', 'fullname');
				$this->crud->display_as('id', 'ID#');
				$this->crud->display_as('user_id','Creator');
				$this->crud->display_as('hotel_id','Hotel Name');
				$this->crud->display_as('date_time','Date and Time of Delivery');
				$this->crud->display_as('ref','Refilling');
				$this->crud->display_as('refiling','Number Of Refilling');
				$this->crud->display_as('others','Others');
				$this->crud->display_as('relations','Guest Relation');
				$this->crud->display_as('refiller','Refiller');
				$this->crud->display_as('type_id','Amenity Type');
				$this->crud->display_as('user_id_reason','Reason User');
				$this->crud->display_as('reason','Reason');
				$this->crud->display_as('state_id','State');
				$this->crud->display_as('timestamp','Timestamp');
				$this->crud->add_action('Edit Amenity Attachments', '', '','ui-icon-image',array($this,'amen_attachments'));
				$this->crud->add_action('Edit Amenity Signatures', '', '','ui-icon-image',array($this,'amen_signatures'));
				$this->crud->add_action('Edit Amenity Comments', '', '','ui-icon-image',array($this,'amen_comments'));
				$this->crud->add_action('Edit Amenity Rooms', '', '','ui-icon-image',array($this,'amen_rooms'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function amen_associates($post_array) {
			$amen_id = $this->uri->segment(3);
			$post_array['amen_id'] = $amen_id;
			return $post_array;
		}

		public function fixed_amen() {
			return '';
		}

		function amen_attachments($pk, $row) {
			return '/backend/amen_attachment/'.$pk;
		}

		public function amen_attachment($amen_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('amenitys_filles');
				$this->crud->set_subject('Amenity Attachment');
				$this->crud->callback_field('amen_id',array($this,'fixed_amen'));
				$this->crud->set_relation('amen_id', 'amenitys', 'date_time');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->display_as('id', 'ID#');
				$this->crud->display_as('amen_id', 'Date and Time of Delivery');
				$this->crud->display_as('user_id','Created By');
				$this->crud->display_as('name','Name');
				$this->crud->display_as('timestamp','Creation Date');
				$this->crud->set_field_upload('name','assets/uploads/files');
				$this->crud->where('amen_id', $amen_id);
				$this->crud->callback_before_insert(array($this,'amen_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function amen_signatures($pk, $row) {
			return '/backend/amen_signature/'.$pk;
		}

		public function amen_signature($amen_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('amenitys_signature');
				$this->crud->set_subject('Amenity Signature');
				$this->crud->callback_field('amen_id',array($this,'fixed_amen'));
				$this->crud->set_relation('amen_id', 'amenitys', 'date_time');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->set_relation('role_id', 'roles', 'role');
				$this->crud->set_relation('department_id', 'departments', 'name');
				$this->crud->display_as('id', 'ID#');
				$this->crud->display_as('amen_id', 'Date and Time of Delivery');
				$this->crud->display_as('user_id','Created By');
				$this->crud->display_as('role_id','Role');
				$this->crud->display_as('department_id','Department');
				$this->crud->display_as('rank','Rank');
				$this->crud->display_as('reject','Reject');
				$this->crud->display_as('timestamp','Creation Date');
				$this->crud->where('amen_id', $amen_id);
				$this->crud->callback_before_insert(array($this,'amen_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function amen_comments($pk, $row) {
			return '/backend/amen_comment/'.$pk;
		}

		public function amen_comment($amen_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('amenitys_comments');
				$this->crud->set_subject('Amenity Comment');
				$this->crud->callback_field('amen_id',array($this,'fixed_amen'));
				$this->crud->set_relation('amen_id', 'amenitys', 'date_time');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->display_as('id', 'ID#');
				$this->crud->display_as('amen_id', 'Date and Time of Delivery');
				$this->crud->display_as('user_id','Created By');
				$this->crud->display_as('comment','Comment');
				$this->crud->display_as('created','Creation Date');
				$this->crud->where('amen_id', $amen_id);
				$this->crud->callback_before_insert(array($this,'amen_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function amen_rooms($pk, $row) {
			return '/backend/amen_room/'.$pk;
		}

		public function amen_room($amen_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('amenitys_element');
				$this->crud->set_subject('Amenity Room');
				$this->crud->callback_field('amen_id',array($this,'fixed_amen'));
				$this->crud->set_relation_n_n('Others', 'amenitys_other', 'amenitys_others', 'room_id', 'other_id', 'name');
				$this->crud->set_relation('amen_id', 'amenitys', 'date_time');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->set_relation('treatment_id', 'amenitys_treatments', 'name');
				$this->crud->display_as('id', 'ID#');
				$this->crud->display_as('user_id','Created By');
				$this->crud->display_as('amen_id', 'Date and Time of Delivery');
				$this->crud->display_as('longs','Long Stay');
				$this->crud->display_as('room','Room');
				$this->crud->display_as('guest','Guest Name');
				$this->crud->display_as('nationality','Guest Nationality');
				$this->crud->display_as('arrival','Arrival Date');
				$this->crud->display_as('departure','Departure Date');
				$this->crud->display_as('pax','No. Of Pax');
				$this->crud->display_as('child','No. Of Childs');
				$this->crud->display_as('reason','Reason');
				$this->crud->display_as('treatment_id','VIP Full Treatment');
				$this->crud->display_as('location','Location');
				$this->crud->display_as('timestamp','Creation Date');
				$this->crud->where('amen_id', $amen_id);
				$this->crud->callback_before_insert(array($this,'amen_associates'));
				$this->crud->add_action('Move Amenity Room', '', '','ui-icon-image',array($this,'amen_moves'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function amen_room_associates($post_array) {
			$room_id = $this->uri->segment(3);
			$post_array['room_id'] = $room_id;
			return $post_array;
		}

		public function fixed_amen_room() {
			return '';
		}

		function amen_moves($pk, $row) {
			return '/backend/amen_move/'.$pk;
		}

		public function amen_move($room_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('amenitys_moved');
				$this->crud->set_subject('Move Room');
				$this->crud->callback_field('room_id',array($this,'fixed_amen_room'));
				$this->crud->set_relation('amen_id', 'amenitys', 'date_time');
				$this->crud->set_relation('room_id', 'amenitys_element', 'guest');
				$this->crud->set_relation('user_new', 'users', 'fullname');
				$this->crud->display_as('id', 'ID#');
				$this->crud->display_as('user_new','Moved By');
				$this->crud->display_as('amen_id', 'Date and Time of Delivery');
				$this->crud->display_as('room_id', 'Guest Name');
				$this->crud->display_as('room_old','Old Room');
				$this->crud->display_as('room_new','New Room');
				$this->crud->display_as('timestamp','Creation Date');
				$this->crud->where('room_id', $room_id);
				$this->crud->callback_before_insert(array($this,'amen_room_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function amenitys_type() {
			try {
				$this->load->model('roles_model');
				$this->load->model('Departments_model');
				$this->crud->set_theme('datatables');
				$this->crud->set_table('amenitys_type');
				$this->crud->set_subject('Amenity Signatures');
				$this->crud->columns('id', 'name', 'dummy', 'dummy1');
				$this->crud->display_as('dummy', 'Role Signatures');
				$this->crud->display_as('dummy1', 'Department Signatures');
				$this->crud->display_as('name', 'Name');
				$this->crud->display_as('id', 'ID#');
				$this->crud->callback_field('dummy',array($this,'amen_role_sign'));
				$this->crud->callback_field('dummy1',array($this,'amen_department_sign'));
				$this->crud->callback_before_insert(array($this,'process_for_insert_amen'));
				$this->crud->callback_after_insert(array($this,'process_extras_after_amen'));
				$this->crud->callback_before_update(array($this,'process_extras_amen'));
				$this->crud->set_soft_delete();
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function process_for_insert_amen($post_array) {
		  	unset($post_array['roles']);
		  	unset($post_array['departments']);
		 	return $post_array;
		}

		public function process_extras_after_amen($post_array, $primary_key) {
		  	$this->load->model('amenitys_role_model');
		  	$this->amenitys_role_model->reset_amen($primary_key);
		  	$rank = 1;
		  	$resulte =  array();
		  	foreach ($post_array['roles'] as $key => $role) {
		    	if ($role != 0) {
		      		$sign_id = $this->amenitys_role_model->add_role_amen($primary_key, $role, $rank);
		      		$resulte[] = $sign_id;
		      		$rank++;
		    	}
		  	}
		  	foreach ($post_array['departments'] as $key => $department) {
		    	if ($department != 0) {
		      		$this->amenitys_role_model->add_department_amen($primary_key, $department, $resulte[$key]);
		    	}
		  	}
		}

		public function process_extras_amen($post_array, $primary_key) {
		  	$this->load->model('amenitys_role_model');
		  	$this->amenitys_role_model->reset_amen($primary_key);
		  	$rank = 1;
		  	$resulte =  array();
		  	foreach ($post_array['roles'] as $key => $role) {
		    	if ($role != 0) {
		      		$sign_id = $this->amenitys_role_model->add_role_amen($primary_key, $role, $rank);
		      		$resulte[] = $sign_id;
		      		$rank++;
		    	}
		  	}
		  	foreach ($post_array['departments'] as $key => $department) {
		    	if ($department != 0) {
		      		$this->amenitys_role_model->add_department_amen($primary_key, $department, $resulte[$key]);
		    	}
		  	}
		  	unset($post_array['roles']);
		  	unset($post_array['departments']);
		  	return $post_array;
		}

		public function amen_role_sign($var, $primary_key = null) {
		  	$this->load->model('amenitys_role_model');
		  	$amen_roles = $this->amenitys_role_model->getby_amen($primary_key);
		  	$all_roles = $this->roles_model->getall();
		  	$global_field = '<div id="role-hidden-template" style="display:none">'.$this->amen_role_signature_field($all_roles, FALSE, FALSE).'</div>';
		  	$global_field .= '<div class="field-role-global .connected">';
		  	foreach ($amen_roles as $amen_role) {
		    	$global_field .= $this->amen_role_signature_field($all_roles, $amen_role['role']);
		  	}
		  	$global_field .= $this->amen_role_signature_field($all_roles);
		  	$global_field .= '</div> <br />';
		  	$global_field .= '<script type="text/javascript">
		        $(function () {
		            $(".role-selector").change(function(){
		                var zeroValue = false;
		                $(".field-role-global .role-selector").each(function(){
		                  	if ($(this).val() == ""){
		                    	zeroValue = true;
		                  	}
		                });
		              	if(!zeroValue) {
			                $clone = $("#role-hidden-template").children().first().clone(true);
			                $clone.find("select").addClass("chosen-select");
			                $clone.appendTo(".field-role-global");
		                	$(".chosen-select").chosen();
		              	}
		            });
		            $(".field-role-global").sortable({
		                connectWith: ".connected"
		            });
		        });
		    </script>';
		  	return $global_field;
		}

		private function amen_role_signature_field( $all_roles, $option = FALSE, $chosen = TRUE) {
		  	$class = ($chosen)? 'chosen-select' : '';
		  	$field = '
			  	<div class="form-input-box sortable-selects" >
			    	<select name="roles[]" class="'.$class.' role-selector" data-placeholder="Select Role">
			      		<option value=""></option>
			      		';
			  			foreach ($all_roles as $role) {
						    $field .= '<option value="'.$role['id'].'" ';
						    $field .= ($option && $option == $role['id'])? ' selected="selected" ' : '';
						    $field .= '>'.$role['role'].'</option>';
			  			};
			  			$field .= '
			    	</select>
			    	<span class="icon icon-th-list"></span>
			  	</div>
			';
		  	return $field;
		}

		public function amen_department_sign($var, $primary_key = null) {
		  	$this->load->model('amenitys_role_model');
		  	$amen_departments = $this->amenitys_role_model->getby_amen($primary_key);
		  	$all_departments = $this->Departments_model->getall();
		  	$global_field = '<div class="field-department-global .connected">';
		  	foreach ($amen_departments as $amen_department) {
		    	$global_field .= $this->amen_department_signature_field($all_departments, $amen_department['department']);
		  	}
		  	$global_field .= $this->amen_department_signature_field($all_departments);
		  	$global_field .= '</div> <br />';
		  	return $global_field;
		}

		private function amen_department_signature_field( $all_departments, $option = FALSE, $chosen = TRUE) {
		  	$class = ($chosen)? 'chosen-select' : '';
		  	$field = '
			  	<div class="form-input-box sortable-selects" >
			    	<select name="departments[]" class="'.$class.' department-selector" data-placeholder="Select Department">
			      		<option value=""></option>
			      		';
			  			foreach ($all_departments as $department) {
						    $field .= '<option value="'.$department['id'].'" ';
						    $field .= ($option && $option == $department['id'])? ' selected="selected" ' : '';
						    $field .= '>'.$department['name'].'</option>';
			  			};
			  			$field .= '
			    	</select>
			    	<span class="icon icon-th-list"></span>
			  	</div>
			';
		  	return $field;
		}

		public function amenitys_others() {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('amenitys_others');
				$this->crud->set_subject('Other Amenities');
				$this->crud->columns('id', 'name');
				$this->crud->display_as('id', 'ID#');
				$this->crud->display_as('name','Name');
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function amenitys_treatments() {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('amenitys_treatments');
				$this->crud->set_subject('VIP Full Treatment');
				$this->crud->columns('id', 'name');
				$this->crud->display_as('id', 'ID#');
				$this->crud->display_as('name','Name');
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function amenitys_types() {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('amenitys_types');
				$this->crud->set_subject('Amenity Type');
				$this->crud->columns('id', 'name');
				$this->crud->display_as('id', 'ID#');
				$this->crud->display_as('name','Name');
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function change() {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('chang');
				$this->crud->set_subject('Rate Change Request');
				$this->crud->columns('id', 'hotel_id', 'date', 'room_old', 'room_new');
				$this->crud->set_relation('hotel_id', 'hotels', 'name');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->display_as('id', 'ID#');
				$this->crud->display_as('user_id','Creator');
				$this->crud->display_as('hotel_id','Hotel Name');
				$this->crud->display_as('date','Date');
				$this->crud->display_as('guest','Guest');
				$this->crud->display_as('room_old','Old Room');
				$this->crud->display_as('room_new','New Room');
				$this->crud->display_as('rate_from','Old Rate');
				$this->crud->display_as('rate_to','New Rate');
				$this->crud->display_as('currency','Currency');
				$this->crud->display_as('remarks','Remarks');
				$this->crud->display_as('state_id','State');
				$this->crud->display_as('timestamp','Timestamp');
				$this->crud->add_action('Edit Rate Change Comments', '', '','ui-icon-image',array($this,'change_comments'));
				$this->crud->add_action('Edit Rate Change Signatures', '', '','ui-icon-image',array($this,'change_signatures'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function change_associates($post_array) {
			$ch_id = $this->uri->segment(3);
			$post_array['ch_id'] = $ch_id;
			return $post_array;
		}

		public function fixed_change() {
			return '';
		}

		function change_comments($pk, $row) {
			return '/backend/change_comment/'.$pk;
		}

		public function change_comment($ch_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('change_comments');
				$this->crud->set_subject('Rate Change Comment');
				$this->crud->callback_field('ch_id',array($this,'fixed_change'));
				$this->crud->set_relation('ch_id', 'chang', 'room_old');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->display_as('id', 'ID#');
				$this->crud->display_as('ch_id', 'Old Room');
				$this->crud->display_as('user_id','Created By');
				$this->crud->display_as('comment','Comment');
				$this->crud->display_as('created','Creation Date');
				$this->crud->where('ch_id', $ch_id);
				$this->crud->callback_before_insert(array($this,'change_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function change_signatures($pk, $row) {
			return '/backend/change_signature/'.$pk;
		}

		public function change_signature($ch_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('change_signature');
				$this->crud->set_subject('Rate Change Signature');
				$this->crud->callback_field('ch_id',array($this,'fixed_change'));
				$this->crud->set_relation('ch_id', 'chang', 'room_old');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->set_relation('role_id', 'roles', 'role');
				$this->crud->set_relation('department_id', 'departments', 'name');
				$this->crud->display_as('id', 'ID#');
				$this->crud->display_as('ch_id', 'Old Room');
				$this->crud->display_as('user_id','Signer');
				$this->crud->display_as('role_id','Role');
				$this->crud->display_as('department_id','Department');
				$this->crud->display_as('rank','Rank');
				$this->crud->display_as('reject','Reject');
				$this->crud->display_as('timestamp','Creation Date');
				$this->crud->where('ch_id', $ch_id);
				$this->crud->callback_before_insert(array($this,'change_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function change_type() {
			try {
				$this->load->model('roles_model');
				$this->load->model('Departments_model');
				$this->crud->set_theme('datatables');
				$this->crud->set_table('change_type');
				$this->crud->set_subject('Rate Change Type');
				$this->crud->columns('id', 'name', 'dummy', 'dummy1');
				$this->crud->display_as('dummy', 'Role Signatures');
				$this->crud->display_as('dummy1', 'Department Signatures');
				$this->crud->display_as('name', 'Name');
				$this->crud->display_as('id', 'ID#');
				$this->crud->callback_field('dummy',array($this,'change_role_sign'));
				$this->crud->callback_field('dummy1',array($this,'change_department_sign'));
				$this->crud->callback_before_insert(array($this,'process_for_insert_change'));
				$this->crud->callback_after_insert(array($this,'process_extras_after_change'));
				$this->crud->callback_before_update(array($this,'process_extras_change'));
				$this->crud->set_soft_delete();
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function process_for_insert_change($post_array) {
		  	unset($post_array['roles']);
		  	unset($post_array['departments']);
		 	return $post_array;
		}

		public function process_extras_after_change($post_array, $primary_key) {
		  	$this->load->model('change_role_model');
		  	$this->change_role_model->reset_ch($primary_key);
		  	$rank = 1;
		  	$resulte =  array();
		  	foreach ($post_array['roles'] as $key => $role) {
		    	if ($role != 0) {
		      		$sign_id = $this->change_role_model->add_role_ch($primary_key, $role, $rank);
		      		$resulte[] = $sign_id;
		      		$rank++;
		    	}
		  	}
		  	foreach ($post_array['departments'] as $key => $department) {
		    	if ($department != 0) {
		      		$this->change_role_model->add_department_ch($primary_key, $department, $resulte[$key]);
		    	}
		  	}
		}

		public function process_extras_change($post_array, $primary_key) {
		  	$this->load->model('change_role_model');
		  	$this->change_role_model->reset_ch($primary_key);
		  	$rank = 1;
		  	$resulte =  array();
		  	foreach ($post_array['roles'] as $key => $role) {
		    	if ($role != 0) {
		      		$sign_id = $this->change_role_model->add_role_ch($primary_key, $role, $rank);
		      		$resulte[] = $sign_id;
		      		$rank++;
		    	}
		  	}
		  	foreach ($post_array['departments'] as $key => $department) {
		    	if ($department != 0) {
		      		$this->change_role_model->add_department_ch($primary_key, $department, $resulte[$key]);
		    	}
		  	}
		  	unset($post_array['roles']);
		  	unset($post_array['departments']);
		  	return $post_array;
		}

		public function change_role_sign($var, $primary_key = null) {
		  	$this->load->model('change_role_model');
		  	$ch_roles = $this->change_role_model->getby_ch($primary_key);
		  	$all_roles = $this->roles_model->getall();
		  	$global_field = '<div id="role-hidden-template" style="display:none">'.$this->change_role_signature_field($all_roles, FALSE, FALSE).'</div>';
		  	$global_field .= '<div class="field-role-global .connected">';
		  	foreach ($ch_roles as $ch_role) {
		    	$global_field .= $this->change_role_signature_field($all_roles, $ch_role['role']);
		  	}
		  	$global_field .= $this->change_role_signature_field($all_roles);
		  	$global_field .= '</div> <br />';
		  	$global_field .= '<script type="text/javascript">
		        $(function () {
		            $(".role-selector").change(function(){
		                var zeroValue = false;
		                $(".field-role-global .role-selector").each(function(){
		                  	if ($(this).val() == ""){
		                    	zeroValue = true;
		                  	}
		                });
		              	if(!zeroValue) {
			                $clone = $("#role-hidden-template").children().first().clone(true);
			                $clone.find("select").addClass("chosen-select");
			                $clone.appendTo(".field-role-global");
		                	$(".chosen-select").chosen();
		              	}
		            });
		            $(".field-role-global").sortable({
		                connectWith: ".connected"
		            });
		        });
		    </script>';
		  	return $global_field;
		}

		private function change_role_signature_field( $all_roles, $option = FALSE, $chosen = TRUE) {
		  	$class = ($chosen)? 'chosen-select' : '';
		  	$field = '
			  	<div class="form-input-box sortable-selects" >
			    	<select name="roles[]" class="'.$class.' role-selector" data-placeholder="Select Role">
			      		<option value=""></option>
			      		';
			  			foreach ($all_roles as $role) {
						    $field .= '<option value="'.$role['id'].'" ';
						    $field .= ($option && $option == $role['id'])? ' selected="selected" ' : '';
						    $field .= '>'.$role['role'].'</option>';
			  			};
			  			$field .= '
			    	</select>
			    	<span class="icon icon-th-list"></span>
			  	</div>
			';
		  	return $field;
		}

		public function change_department_sign($var, $primary_key = null) {
		  	$this->load->model('change_role_model');
		  	$ch_departments = $this->change_role_model->getby_ch($primary_key);
		  	$all_departments = $this->Departments_model->getall();
		  	$global_field = '<div class="field-department-global .connected">';
		  	foreach ($ch_departments as $ch_department) {
		    	$global_field .= $this->change_department_signature_field($all_departments, $ch_department['department']);
		  	}
		  	$global_field .= $this->change_department_signature_field($all_departments);
		  	$global_field .= '</div> <br />';
		  	return $global_field;
		}

		private function change_department_signature_field( $all_departments, $option = FALSE, $chosen = TRUE) {
		  	$class = ($chosen)? 'chosen-select' : '';
		  	$field = '
			  	<div class="form-input-box sortable-selects" >
			    	<select name="departments[]" class="'.$class.' department-selector" data-placeholder="Select Department">
			      		<option value=""></option>
			      		';
			  			foreach ($all_departments as $department) {
						    $field .= '<option value="'.$department['id'].'" ';
						    $field .= ($option && $option == $department['id'])? ' selected="selected" ' : '';
						    $field .= '>'.$department['name'].'</option>';
			  			};
			  			$field .= '
			    	</select>
			    	<span class="icon icon-th-list"></span>
			  	</div>
			';
		  	return $field;
		}

		public function fb_order() {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('fb_order');
				$this->crud->set_subject('Food & Beverage Order');
				$this->crud->columns('id', 'hotel_id', 'date', 'timestamp');
				$this->crud->set_relation('hotel_id', 'hotels', 'name');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->set_relation('ret_id', 'fb_types', 'name');
				$this->crud->display_as('id', 'ID#');
				$this->crud->display_as('user_id','Creator');
				$this->crud->display_as('hotel_id','Hotel Name');
				$this->crud->display_as('date','Date');
				$this->crud->display_as('type','Type');
				$this->crud->display_as('ret_id','Retour');
				$this->crud->display_as('user_id_reason','Reason User');
				$this->crud->display_as('reason','Reason');
				$this->crud->display_as('state_id','State');
				$this->crud->display_as('timestamp','Timestamp');
				$this->crud->add_action('Edit Food & Beverage Orders', '', '','ui-icon-image',array($this,'fb_rooms'));
				$this->crud->add_action('Edit Food & Beverage Comments', '', '','ui-icon-image',array($this,'fb_comments'));
				$this->crud->add_action('Edit Food & Beverage Signatures', '', '','ui-icon-image',array($this,'fb_signatures'));
				$this->crud->add_action('Edit Food & Beverage Attachments', '', '','ui-icon-image',array($this,'fb_attachments'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function fb_associates($post_array) {
			$fb_id = $this->uri->segment(3);
			$post_array['fb_id'] = $fb_id;
			return $post_array;
		}

		public function fixed_fb() {
			return '';
		}

		function fb_rooms($pk, $row) {
			return '/backend/fb_room/'.$pk;
		}

		public function fb_room($fb_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('fb_element');
				$this->crud->set_subject('Food & Beverage Order');
				$this->crud->callback_field('fb_id',array($this,'fixed_fb'));
				$this->crud->set_relation('fb_id', 'fb_order', 'date');
				$this->crud->display_as('id', 'ID#');
				$this->crud->display_as('fb_id', 'Date');
				$this->crud->display_as('room','Room');
				$this->crud->display_as('guest','Guest Name');
				$this->crud->display_as('nationality','Guest Nationality');
				$this->crud->display_as('pax','No. Of Pax');
				$this->crud->display_as('break','Breakfast');
				$this->crud->display_as('date','Breakfast Time');
				$this->crud->display_as('lunch','Lunch');
				$this->crud->display_as('royal','Royal Lunch');
				$this->crud->display_as('date1','Lunch Time');
				$this->crud->display_as('dinner','Late Dinner');
				$this->crud->display_as('date2','Dinner Time');
				$this->crud->display_as('cold','Cold Cuts');
				$this->crud->display_as('date3','Cold Cuts Time');
				$this->crud->where('fb_id', $fb_id);
				$this->crud->callback_before_insert(array($this,'fb_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function fb_comments($pk, $row) {
			return '/backend/fb_comment/'.$pk;
		}

		public function fb_comment($fb_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('fb_comments');
				$this->crud->set_subject('Food & Beverage Comment');
				$this->crud->callback_field('fb_id',array($this,'fixed_fb'));
				$this->crud->set_relation('fb_id', 'fb_order', 'date');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->display_as('id', 'ID#');
				$this->crud->display_as('fb_id', 'Date');
				$this->crud->display_as('user_id','Created By');
				$this->crud->display_as('comment','Comment');
				$this->crud->display_as('created','Creation Date');
				$this->crud->where('fb_id', $fb_id);
				$this->crud->callback_before_insert(array($this,'fb_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function fb_signatures($pk, $row) {
			return '/backend/fb_signature/'.$pk;
		}

		public function fb_signature($fb_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('fb_signature');
				$this->crud->set_subject('Food & Beverage Signature');
				$this->crud->callback_field('fb_id',array($this,'fixed_fb'));
				$this->crud->set_relation('fb_id', 'fb_order', 'date');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->set_relation('role_id', 'roles', 'role');
				$this->crud->set_relation('department_id', 'departments', 'name');
				$this->crud->display_as('id', 'ID#');
				$this->crud->display_as('fb_id', 'Date');
				$this->crud->display_as('user_id','Signer');
				$this->crud->display_as('role_id','Role');
				$this->crud->display_as('department_id','Department');
				$this->crud->display_as('rank','Rank');
				$this->crud->display_as('reject','Reject');
				$this->crud->display_as('timestamp','Creation Date');
				$this->crud->where('fb_id', $fb_id);
				$this->crud->callback_before_insert(array($this,'fb_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function fb_attachments($pk, $row) {
			return '/backend/fb_attachment/'.$pk;
		}

		public function fb_attachment($fb_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('fb_filles');
				$this->crud->set_subject('Food & Beverage Attachment');
				$this->crud->callback_field('fb_id',array($this,'fixed_fb'));
				$this->crud->set_relation('fb_id', 'fb_order', 'date');
				$this->crud->display_as('id', 'ID#');
				$this->crud->display_as('fb_id', 'Date');
				$this->crud->display_as('name','Name');
				$this->crud->set_field_upload('name','assets/uploads/files');
				$this->crud->where('fb_id', $fb_id);
				$this->crud->callback_before_insert(array($this,'fb_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function fb_type() {
			try {
				$this->load->model('roles_model');
				$this->load->model('Departments_model');
				$this->crud->set_theme('datatables');
				$this->crud->set_table('fb_type');
				$this->crud->set_subject('Food & Beverage Signatures');
				$this->crud->columns('id', 'name', 'dummy', 'dummy1');
				$this->crud->display_as('dummy', 'Role Signatures');
				$this->crud->display_as('dummy1', 'Department Signatures');
				$this->crud->display_as('name', 'Name');
				$this->crud->display_as('id', 'ID#');
				$this->crud->callback_field('dummy',array($this,'fb_role_sign'));
				$this->crud->callback_field('dummy1',array($this,'fb_department_sign'));
				$this->crud->callback_before_insert(array($this,'process_for_insert_fb'));
				$this->crud->callback_after_insert(array($this,'process_extras_after_fb'));
				$this->crud->callback_before_update(array($this,'process_extras_fb'));
				$this->crud->set_soft_delete();
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function process_for_insert_fb($post_array) {
		  	unset($post_array['roles']);
		  	unset($post_array['departments']);
		 	return $post_array;
		}

		public function process_extras_after_fb($post_array, $primary_key) {
		  	$this->load->model('fb_role_model');
		  	$this->fb_role_model->reset_fb($primary_key);
		  	$rank = 1;
		  	$resulte =  array();
		  	foreach ($post_array['roles'] as $key => $role) {
		    	if ($role != 0) {
		      		$sign_id = $this->fb_role_model->add_role_fb($primary_key, $role, $rank);
		      		$resulte[] = $sign_id;
		      		$rank++;
		    	}
		  	}
		  	foreach ($post_array['departments'] as $key => $department) {
		    	if ($department != 0) {
		      		$this->fb_role_model->add_department_fb($primary_key, $department, $resulte[$key]);
		    	}
		  	}
		}

		public function process_extras_fb($post_array, $primary_key) {
		  	$this->load->model('fb_role_model');
		  	$this->fb_role_model->reset_fb($primary_key);
		  	$rank = 1;
		  	$resulte =  array();
		  	foreach ($post_array['roles'] as $key => $role) {
		    	if ($role != 0) {
		      		$sign_id = $this->fb_role_model->add_role_fb($primary_key, $role, $rank);
		      		$resulte[] = $sign_id;
		      		$rank++;
		    	}
		  	}
		  	foreach ($post_array['departments'] as $key => $department) {
		    	if ($department != 0) {
		      		$this->fb_role_model->add_department_fb($primary_key, $department, $resulte[$key]);
		    	}
		  	}
		  	unset($post_array['roles']);
		  	unset($post_array['departments']);
		  	return $post_array;
		}

		public function fb_role_sign($var, $primary_key = null) {
		  	$this->load->model('fb_role_model');
		  	$fb_roles = $this->fb_role_model->getby_fb($primary_key);
		  	$all_roles = $this->roles_model->getall();
		  	$global_field = '<div id="role-hidden-template" style="display:none">'.$this->fb_role_signature_field($all_roles, FALSE, FALSE).'</div>';
		  	$global_field .= '<div class="field-role-global .connected">';
		  	foreach ($fb_roles as $fb_role) {
		    	$global_field .= $this->fb_role_signature_field($all_roles, $fb_role['role']);
		  	}
		  	$global_field .= $this->fb_role_signature_field($all_roles);
		  	$global_field .= '</div> <br />';
		  	$global_field .= '<script type="text/javascript">
		        $(function () {
		            $(".role-selector").change(function(){
		                var zeroValue = false;
		                $(".field-role-global .role-selector").each(function(){
		                  	if ($(this).val() == ""){
		                    	zeroValue = true;
		                  	}
		                });
		              	if(!zeroValue) {
			                $clone = $("#role-hidden-template").children().first().clone(true);
			                $clone.find("select").addClass("chosen-select");
			                $clone.appendTo(".field-role-global");
		                	$(".chosen-select").chosen();
		              	}
		            });
		            $(".field-role-global").sortable({
		                connectWith: ".connected"
		            });
		        });
		    </script>';
		  	return $global_field;
		}

		private function fb_role_signature_field( $all_roles, $option = FALSE, $chosen = TRUE) {
		  	$class = ($chosen)? 'chosen-select' : '';
		  	$field = '
			  	<div class="form-input-box sortable-selects" >
			    	<select name="roles[]" class="'.$class.' role-selector" data-placeholder="Select Role">
			      		<option value=""></option>
			      		';
			  			foreach ($all_roles as $role) {
						    $field .= '<option value="'.$role['id'].'" ';
						    $field .= ($option && $option == $role['id'])? ' selected="selected" ' : '';
						    $field .= '>'.$role['role'].'</option>';
			  			};
			  			$field .= '
			    	</select>
			    	<span class="icon icon-th-list"></span>
			  	</div>
			';
		  	return $field;
		}

		public function fb_department_sign($var, $primary_key = null) {
		  	$this->load->model('fb_role_model');
		  	$fb_departments = $this->fb_role_model->getby_fb($primary_key);
		  	$all_departments = $this->Departments_model->getall();
		  	$global_field = '<div class="field-department-global .connected">';
		  	foreach ($fb_departments as $fb_department) {
		    	$global_field .= $this->fb_department_signature_field($all_departments, $fb_department['department']);
		  	}
		  	$global_field .= $this->fb_department_signature_field($all_departments);
		  	$global_field .= '</div> <br />';
		  	return $global_field;
		}

		private function fb_department_signature_field( $all_departments, $option = FALSE, $chosen = TRUE) {
		  	$class = ($chosen)? 'chosen-select' : '';
		  	$field = '
			  	<div class="form-input-box sortable-selects" >
			    	<select name="departments[]" class="'.$class.' department-selector" data-placeholder="Select Department">
			      		<option value=""></option>
			      		';
			  			foreach ($all_departments as $department) {
						    $field .= '<option value="'.$department['id'].'" ';
						    $field .= ($option && $option == $department['id'])? ' selected="selected" ' : '';
						    $field .= '>'.$department['name'].'</option>';
			  			};
			  			$field .= '
			    	</select>
			    	<span class="icon icon-th-list"></span>
			  	</div>
			';
		  	return $field;
		}

		public function fb_types() {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('fb_types');
				$this->crud->set_subject('Food & Beverage Type');
				$this->crud->columns('id', 'name');
				$this->crud->display_as('id', 'ID#');
				$this->crud->display_as('name','Name');
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function discrepancy() {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('discrepancy');
				$this->crud->set_subject('Discrepancy Report');
				$this->crud->columns('id', 'hotel_id', 'date', 'time', 'dcy_type');
				$this->crud->set_relation('hotel_id', 'hotels', 'name');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->display_as('id', 'ID#');
				$this->crud->display_as('hotel_id','Hotel Name');
				$this->crud->display_as('user_id','Created By');
				$this->crud->display_as('dcy_type','Discrepancy Type');
				$this->crud->display_as('date','Date');
				$this->crud->display_as('time','Clock System');
				$this->crud->display_as('type','Type');
				$this->crud->display_as('state_id','State');
				$this->crud->display_as('timestamp','Creation Date');
				$this->crud->add_action('Edit Discrepancy Items', '', '','ui-icon-image',array($this,'dcy_items'));
				$this->crud->add_action('Edit Discrepancy Comments', '', '','ui-icon-image',array($this,'dcy_comments'));
				$this->crud->add_action('Edit Discrepancy Signatures', '', '','ui-icon-image',array($this,'dcy_signatures'));
				$this->crud->add_action('Edit Discrepancy Attachments', '', '','ui-icon-image',array($this,'dcy_attachments'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function dcy_associates($post_array) {
			$dcy_id = $this->uri->segment(3);
			$post_array['dcy_id'] = $dcy_id;
			return $post_array;
		}

		public function fixed_dcy() {
			return '';
		}

		function dcy_items($pk, $row) {
			return '/backend/dcy_item/'.$pk;
		}

		public function dcy_item($dcy_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('discrepancy_room');
				$this->crud->set_subject('Discrepancy Item');
				$this->crud->callback_field('dcy_id',array($this,'fixed_dcy'));
				$this->crud->set_relation('dcy_id', 'discrepancy', 'dcy_type');
				$this->crud->display_as('id', 'ID#');
				$this->crud->display_as('dcy_id', 'Discrepancy Type');
				$this->crud->display_as('room','Room');
				$this->crud->display_as('h_k','H.K');
				$this->crud->display_as('f_o','F.O');
				$this->crud->display_as('re_check','Re-check');
				$this->crud->display_as('remarks','Remarks');
				$this->crud->where('dcy_id', $dcy_id);
				$this->crud->callback_before_insert(array($this,'dcy_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function dcy_comments($pk, $row) {
			return '/backend/dcy_comment/'.$pk;
		}

		public function dcy_comment($dcy_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('discrepancy_comments');
				$this->crud->set_subject('Discrepancy Comment');
				$this->crud->callback_field('dcy_id',array($this,'fixed_dcy'));
				$this->crud->set_relation('dcy_id', 'discrepancy', 'dcy_type');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->display_as('id', 'ID#');
				$this->crud->display_as('dcy_id', 'Discrepancy Type');
				$this->crud->display_as('user_id','Created By');
				$this->crud->display_as('comment','Comment');
				$this->crud->display_as('created','Creation Date');
				$this->crud->where('dcy_id', $dcy_id);
				$this->crud->callback_before_insert(array($this,'dcy_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function dcy_signatures($pk, $row) {
			return '/backend/dcy_signature/'.$pk;
		}

		public function dcy_signature($dcy_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('discrepancy_signature');
				$this->crud->set_subject('Discrepancy Signature');
				$this->crud->callback_field('dcy_id',array($this,'fixed_dcy'));
				$this->crud->set_relation('dcy_id', 'discrepancy', 'dcy_type');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->set_relation('role_id', 'roles', 'role');
				$this->crud->set_relation('department_id', 'departments', 'name');
				$this->crud->display_as('id', 'ID#');
				$this->crud->display_as('dcy_id', 'Discrepancy Type');
				$this->crud->display_as('user_id','Signer');
				$this->crud->display_as('role_id','Role');
				$this->crud->display_as('department_id','Department');
				$this->crud->display_as('rank','Rank');
				$this->crud->display_as('reject','Reject');
				$this->crud->display_as('timestamp','Creation Date');
				$this->crud->where('dcy_id', $dcy_id);
				$this->crud->callback_before_insert(array($this,'dcy_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function dcy_attachments($pk, $row) {
			return '/backend/dcy_attachment/'.$pk;
		}

		public function dcy_attachment($dcy_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('discrepancy_filles');
				$this->crud->set_subject('Discrepancy Attachment');
				$this->crud->callback_field('dcy_id',array($this,'fixed_dcy'));
				$this->crud->set_relation('dcy_id', 'discrepancy', 'dcy_type');
				$this->crud->display_as('id', 'ID#');
				$this->crud->display_as('dcy_id', 'Discrepancy Type');
				$this->crud->display_as('name','Name');
				$this->crud->set_field_upload('name','assets/uploads/files');
				$this->crud->where('dcy_id', $dcy_id);
				$this->crud->callback_before_insert(array($this,'dcy_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function dcy_type() {
			try {
				$this->load->model('roles_model');
				$this->load->model('Departments_model');
				$this->crud->set_theme('datatables');
				$this->crud->set_table('discrepancy_type');
				$this->crud->set_subject('Discrepancy Signatures');
				$this->crud->columns('id', 'name', 'dummy', 'dummy1');
				$this->crud->display_as('dummy', 'Role Signatures');
				$this->crud->display_as('dummy1', 'Department Signatures');
				$this->crud->display_as('name', 'Name');
				$this->crud->display_as('id', 'ID#');
				$this->crud->callback_field('dummy',array($this,'dcy_role_sign'));
				$this->crud->callback_field('dummy1',array($this,'dcy_department_sign'));
				$this->crud->callback_before_insert(array($this,'process_for_insert_dcy'));
				$this->crud->callback_after_insert(array($this,'process_extras_after_dcy'));
				$this->crud->callback_before_update(array($this,'process_extras_dcy'));
				$this->crud->set_soft_delete();
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function process_for_insert_dcy($post_array) {
		  	unset($post_array['roles']);
		  	unset($post_array['departments']);
		 	return $post_array;
		}

		public function process_extras_after_dcy($post_array, $primary_key) {
		  	$this->load->model('discrepancy_role_model');
		  	$this->discrepancy_role_model->reset_dcy($primary_key);
		  	$rank = 1;
		  	$resulte =  array();
		  	foreach ($post_array['roles'] as $key => $role) {
		    	if ($role != 0) {
		      		$sign_id = $this->discrepancy_role_model->add_role_dcy($primary_key, $role, $rank);
		      		$resulte[] = $sign_id;
		      		$rank++;
		    	}
		  	}
		  	foreach ($post_array['departments'] as $key => $department) {
		    	if ($department != 0) {
		      		$this->discrepancy_role_model->add_department_dcy($primary_key, $department, $resulte[$key]);
		    	}
		  	}
		}

		public function process_extras_dcy($post_array, $primary_key) {
		  	$this->load->model('discrepancy_role_model');
		  	$this->discrepancy_role_model->reset_dcy($primary_key);
		  	$rank = 1;
		  	$resulte =  array();
		  	foreach ($post_array['roles'] as $key => $role) {
		    	if ($role != 0) {
		      		$sign_id = $this->discrepancy_role_model->add_role_dcy($primary_key, $role, $rank);
		      		$resulte[] = $sign_id;
		      		$rank++;
		    	}
		  	}
		  	foreach ($post_array['departments'] as $key => $department) {
		    	if ($department != 0) {
		      		$this->discrepancy_role_model->add_department_dcy($primary_key, $department, $resulte[$key]);
		    	}
		  	}
		  	unset($post_array['roles']);
		  	unset($post_array['departments']);
		  	return $post_array;
		}

		public function dcy_role_sign($var, $primary_key = null) {
		  	$this->load->model('discrepancy_role_model');
		  	$dcy_roles = $this->discrepancy_role_model->getby_dcy($primary_key);
		  	$all_roles = $this->roles_model->getall();
		  	$global_field = '<div id="role-hidden-template" style="display:none">'.$this->dcy_role_signature_field($all_roles, FALSE, FALSE).'</div>';
		  	$global_field .= '<div class="field-role-global .connected">';
		  	foreach ($dcy_roles as $dcy_role) {
		    	$global_field .= $this->dcy_role_signature_field($all_roles, $dcy_role['role']);
		  	}
		  	$global_field .= $this->dcy_role_signature_field($all_roles);
		  	$global_field .= '</div> <br />';
		  	$global_field .= '<script type="text/javascript">
		        $(function () {
		            $(".role-selector").change(function(){
		                var zeroValue = false;
		                $(".field-role-global .role-selector").each(function(){
		                  	if ($(this).val() == ""){
		                    	zeroValue = true;
		                  	}
		                });
		              	if(!zeroValue) {
			                $clone = $("#role-hidden-template").children().first().clone(true);
			                $clone.find("select").addClass("chosen-select");
			                $clone.appendTo(".field-role-global");
		                	$(".chosen-select").chosen();
		              	}
		            });
		            $(".field-role-global").sortable({
		                connectWith: ".connected"
		            });
		        });
		    </script>';
		  	return $global_field;
		}

		private function dcy_role_signature_field( $all_roles, $option = FALSE, $chosen = TRUE) {
		  	$class = ($chosen)? 'chosen-select' : '';
		  	$field = '
			  	<div class="form-input-box sortable-selects" >
			    	<select name="roles[]" class="'.$class.' role-selector" data-placeholder="Select Role">
			      		<option value=""></option>
			      		';
			  			foreach ($all_roles as $role) {
						    $field .= '<option value="'.$role['id'].'" ';
						    $field .= ($option && $option == $role['id'])? ' selected="selected" ' : '';
						    $field .= '>'.$role['role'].'</option>';
			  			};
			  			$field .= '
			    	</select>
			    	<span class="icon icon-th-list"></span>
			  	</div>
			';
		  	return $field;
		}

		public function dcy_department_sign($var, $primary_key = null) {
		  	$this->load->model('discrepancy_role_model');
		  	$dcy_departments = $this->discrepancy_role_model->getby_dcy($primary_key);
		  	$all_departments = $this->Departments_model->getall();
		  	$global_field = '<div class="field-department-global .connected">';
		  	foreach ($dcy_departments as $dcy_department) {
		    	$global_field .= $this->dcy_department_signature_field($all_departments, $dcy_department['department']);
		  	}
		  	$global_field .= $this->dcy_department_signature_field($all_departments);
		  	$global_field .= '</div> <br />';
		  	return $global_field;
		}

		private function dcy_department_signature_field( $all_departments, $option = FALSE, $chosen = TRUE) {
		  	$class = ($chosen)? 'chosen-select' : '';
		  	$field = '
			  	<div class="form-input-box sortable-selects" >
			    	<select name="departments[]" class="'.$class.' department-selector" data-placeholder="Select Department">
			      		<option value=""></option>
			      		';
			  			foreach ($all_departments as $department) {
						    $field .= '<option value="'.$department['id'].'" ';
						    $field .= ($option && $option == $department['id'])? ' selected="selected" ' : '';
						    $field .= '>'.$department['name'].'</option>';
			  			};
			  			$field .= '
			    	</select>
			    	<span class="icon icon-th-list"></span>
			  	</div>
			';
		  	return $field;
		}

		public function late_ch() {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('late_ch');
				$this->crud->set_subject('Late check out Report');
				$this->crud->columns('id', 'hotel_id', 'date', 'timestamp');
				$this->crud->set_relation('hotel_id', 'hotels', 'name');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->display_as('id', 'ID#');
				$this->crud->display_as('hotel_id','Hotel Name');
				$this->crud->display_as('user_id','Created By');
				$this->crud->display_as('date','Date');
				$this->crud->display_as('type','Type');
				$this->crud->display_as('state_id','State');
				$this->crud->display_as('timestamp','Creation Date');
				$this->crud->add_action('Edit Late check out Rooms', '', '','ui-icon-image',array($this,'late_rooms'));
				$this->crud->add_action('Edit Late check out Comments', '', '','ui-icon-image',array($this,'late_comments'));
				$this->crud->add_action('Edit Late check out Signatures', '', '','ui-icon-image',array($this,'late_signatures'));
				$this->crud->add_action('Edit Late check out Attachments', '', '','ui-icon-image',array($this,'late_attachments'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function late_associates($post_array) {
			$ch_id = $this->uri->segment(3);
			$post_array['ch_id'] = $ch_id;
			return $post_array;
		}

		public function fixed_late() {
			return '';
		}

		function late_rooms($pk, $row) {
			return '/backend/late_room/'.$pk;
		}

		public function late_room($ch_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('ch_room');
				$this->crud->set_subject('Late check out Room');
				$this->crud->callback_field('ch_id',array($this,'fixed_late'));
				$this->crud->set_relation('ch_id', 'late_ch', 'date');
				$this->crud->display_as('id', 'ID#');
				$this->crud->display_as('ch_id', 'Date');
				$this->crud->display_as('room','Room');
				$this->crud->display_as('out','C.Out time');
				$this->crud->display_as('comp','Company');
				$this->crud->display_as('remarks','Remarks');
				$this->crud->where('ch_id', $ch_id);
				$this->crud->callback_before_insert(array($this,'late_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function late_comments($pk, $row) {
			return '/backend/late_comment/'.$pk;
		}

		public function late_comment($ch_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('ch_comments');
				$this->crud->set_subject('Late check out Comment');
				$this->crud->callback_field('ch_id',array($this,'fixed_late'));
				$this->crud->set_relation('ch_id', 'late_ch', 'date');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->display_as('id', 'ID#');
				$this->crud->display_as('ch_id', 'Date');
				$this->crud->display_as('user_id','Created By');
				$this->crud->display_as('comment','Comment');
				$this->crud->display_as('created','Creation Date');
				$this->crud->where('ch_id', $ch_id);
				$this->crud->callback_before_insert(array($this,'late_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function late_signatures($pk, $row) {
			return '/backend/late_signature/'.$pk;
		}

		public function late_signature($ch_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('ch_signature');
				$this->crud->set_subject('Late check out Signature');
				$this->crud->callback_field('ch_id',array($this,'fixed_late'));
				$this->crud->set_relation('ch_id', 'late_ch', 'date');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->set_relation('role_id', 'roles', 'role');
				$this->crud->set_relation('department_id', 'departments', 'name');
				$this->crud->display_as('id', 'ID#');
				$this->crud->display_as('ch_id', 'Date');
				$this->crud->display_as('user_id','Signer');
				$this->crud->display_as('role_id','Role');
				$this->crud->display_as('department_id','Department');
				$this->crud->display_as('rank','Rank');
				$this->crud->display_as('reject','Reject');
				$this->crud->display_as('timestamp','Creation Date');
				$this->crud->where('ch_id', $ch_id);
				$this->crud->callback_before_insert(array($this,'late_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function late_attachments($pk, $row) {
			return '/backend/late_attachment/'.$pk;
		}

		public function late_attachment($ch_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('ch_filles');
				$this->crud->set_subject('Late check out Attachment');
				$this->crud->callback_field('ch_id',array($this,'fixed_late'));
				$this->crud->set_relation('ch_id', 'late_ch', 'date');
				$this->crud->display_as('id', 'ID#');
				$this->crud->display_as('ch_id', 'Date');
				$this->crud->display_as('name','Name');
				$this->crud->set_field_upload('name','assets/uploads/files');
				$this->crud->where('ch_id', $ch_id);
				$this->crud->callback_before_insert(array($this,'late_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function late_type() {
			try {
				$this->load->model('roles_model');
				$this->load->model('Departments_model');
				$this->crud->set_theme('datatables');
				$this->crud->set_table('ch_type');
				$this->crud->set_subject('Late check out Signatures');
				$this->crud->columns('id', 'name', 'dummy', 'dummy1');
				$this->crud->display_as('dummy', 'Role Signatures');
				$this->crud->display_as('dummy1', 'Department Signatures');
				$this->crud->display_as('name', 'Name');
				$this->crud->display_as('id', 'ID#');
				$this->crud->callback_field('dummy',array($this,'late_role_sign'));
				$this->crud->callback_field('dummy1',array($this,'late_department_sign'));
				$this->crud->callback_before_insert(array($this,'process_for_insert_late'));
				$this->crud->callback_after_insert(array($this,'process_extras_after_late'));
				$this->crud->callback_before_update(array($this,'process_extras_late'));
				$this->crud->set_soft_delete();
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function process_for_insert_late($post_array) {
		  	unset($post_array['roles']);
		  	unset($post_array['departments']);
		 	return $post_array;
		}

		public function process_extras_after_late($post_array, $primary_key) {
		  	$this->load->model('ch_role_model');
		  	$this->ch_role_model->reset_ch($primary_key);
		  	$rank = 1;
		  	$resulte =  array();
		  	foreach ($post_array['roles'] as $key => $role) {
		    	if ($role != 0) {
		      		$sign_id = $this->ch_role_model->add_role_ch($primary_key, $role, $rank);
		      		$resulte[] = $sign_id;
		      		$rank++;
		    	}
		  	}
		  	foreach ($post_array['departments'] as $key => $department) {
		    	if ($department != 0) {
		      		$this->ch_role_model->add_department_ch($primary_key, $department, $resulte[$key]);
		    	}
		  	}
		}

		public function process_extras_late($post_array, $primary_key) {
		  	$this->load->model('ch_role_model');
		  	$this->ch_role_model->reset_ch($primary_key);
		  	$rank = 1;
		  	$resulte =  array();
		  	foreach ($post_array['roles'] as $key => $role) {
		    	if ($role != 0) {
		      		$sign_id = $this->ch_role_model->add_role_ch($primary_key, $role, $rank);
		      		$resulte[] = $sign_id;
		      		$rank++;
		    	}
		  	}
		  	foreach ($post_array['departments'] as $key => $department) {
		    	if ($department != 0) {
		      		$this->ch_role_model->add_department_ch($primary_key, $department, $resulte[$key]);
		    	}
		  	}
		  	unset($post_array['roles']);
		  	unset($post_array['departments']);
		  	return $post_array;
		}

		public function late_role_sign($var, $primary_key = null) {
		  	$this->load->model('ch_role_model');
		  	$late_roles = $this->ch_role_model->getby_ch($primary_key);
		  	$all_roles = $this->roles_model->getall();
		  	$global_field = '<div id="role-hidden-template" style="display:none">'.$this->late_role_signature_field($all_roles, FALSE, FALSE).'</div>';
		  	$global_field .= '<div class="field-role-global .connected">';
		  	foreach ($late_roles as $late_role) {
		    	$global_field .= $this->late_role_signature_field($all_roles, $late_role['role']);
		  	}
		  	$global_field .= $this->late_role_signature_field($all_roles);
		  	$global_field .= '</div> <br />';
		  	$global_field .= '<script type="text/javascript">
		        $(function () {
		            $(".role-selector").change(function(){
		                var zeroValue = false;
		                $(".field-role-global .role-selector").each(function(){
		                  	if ($(this).val() == ""){
		                    	zeroValue = true;
		                  	}
		                });
		              	if(!zeroValue) {
			                $clone = $("#role-hidden-template").children().first().clone(true);
			                $clone.find("select").addClass("chosen-select");
			                $clone.appendTo(".field-role-global");
		                	$(".chosen-select").chosen();
		              	}
		            });
		            $(".field-role-global").sortable({
		                connectWith: ".connected"
		            });
		        });
		    </script>';
		  	return $global_field;
		}

		private function late_role_signature_field( $all_roles, $option = FALSE, $chosen = TRUE) {
		  	$class = ($chosen)? 'chosen-select' : '';
		  	$field = '
			  	<div class="form-input-box sortable-selects" >
			    	<select name="roles[]" class="'.$class.' role-selector" data-placeholder="Select Role">
			      		<option value=""></option>
			      		';
			  			foreach ($all_roles as $role) {
						    $field .= '<option value="'.$role['id'].'" ';
						    $field .= ($option && $option == $role['id'])? ' selected="selected" ' : '';
						    $field .= '>'.$role['role'].'</option>';
			  			};
			  			$field .= '
			    	</select>
			    	<span class="icon icon-th-list"></span>
			  	</div>
			';
		  	return $field;
		}

		public function late_department_sign($var, $primary_key = null) {
		  	$this->load->model('ch_role_model');
		  	$ch_departments = $this->ch_role_model->getby_ch($primary_key);
		  	$all_departments = $this->Departments_model->getall();
		  	$global_field = '<div class="field-department-global .connected">';
		  	foreach ($ch_departments as $ch_department) {
		    	$global_field .= $this->late_department_signature_field($all_departments, $ch_department['department']);
		  	}
		  	$global_field .= $this->late_department_signature_field($all_departments);
		  	$global_field .= '</div> <br />';
		  	return $global_field;
		}

		private function late_department_signature_field( $all_departments, $option = FALSE, $chosen = TRUE) {
		  	$class = ($chosen)? 'chosen-select' : '';
		  	$field = '
			  	<div class="form-input-box sortable-selects" >
			    	<select name="departments[]" class="'.$class.' department-selector" data-placeholder="Select Department">
			      		<option value=""></option>
			      		';
			  			foreach ($all_departments as $department) {
						    $field .= '<option value="'.$department['id'].'" ';
						    $field .= ($option && $option == $department['id'])? ' selected="selected" ' : '';
						    $field .= '>'.$department['name'].'</option>';
			  			};
			  			$field .= '
			    	</select>
			    	<span class="icon icon-th-list"></span>
			  	</div>
			';
		  	return $field;
		}

		public function s_rate() {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('s_rate');
				$this->crud->set_subject('Special rate Report');
				$this->crud->columns('id', 'hotel_id', 'date', 'timestamp');
				$this->crud->set_relation('hotel_id', 'hotels', 'name');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->display_as('id', 'ID#');
				$this->crud->display_as('hotel_id','Hotel Name');
				$this->crud->display_as('user_id','Created By');
				$this->crud->display_as('date','Date');
				$this->crud->display_as('type','Type');
				$this->crud->display_as('state_id','State');
				$this->crud->display_as('timestamp','Creation Date');
				$this->crud->add_action('Edit Special rate Rooms', '', '','ui-icon-image',array($this,'sr_rooms'));
				$this->crud->add_action('Edit Special rate Comments', '', '','ui-icon-image',array($this,'sr_comments'));
				$this->crud->add_action('Edit Special rate Signatures', '', '','ui-icon-image',array($this,'sr_signatures'));
				$this->crud->add_action('Edit Special rate Attachments', '', '','ui-icon-image',array($this,'sr_attachments'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function sr_associates($post_array) {
			$sr_id = $this->uri->segment(3);
			$post_array['sr_id'] = $sr_id;
			return $post_array;
		}

		public function fixed_sr() {
			return '';
		}

		function sr_rooms($pk, $row) {
			return '/backend/sr_room/'.$pk;
		}

		public function sr_room($sr_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('sr_room');
				$this->crud->set_subject('Special rate Room');
				$this->crud->callback_field('sr_id',array($this,'fixed_sr'));
				$this->crud->set_relation('sr_id', 's_rate', 'date');
				$this->crud->display_as('id', 'ID#');
				$this->crud->display_as('sr_id', 'Date');
				$this->crud->display_as('room','Room');
				$this->crud->display_as('type','Room Type');
				$this->crud->display_as('rate','Posted Rate	');
				$this->crud->display_as('agent','Travel Agent');
				$this->crud->display_as('remarks','Remarks');
				$this->crud->where('sr_id', $sr_id);
				$this->crud->callback_before_insert(array($this,'sr_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function sr_comments($pk, $row) {
			return '/backend/sr_comment/'.$pk;
		}

		public function sr_comment($sr_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('sr_comments');
				$this->crud->set_subject('Special rate Comment');
				$this->crud->callback_field('sr_id',array($this,'fixed_sr'));
				$this->crud->set_relation('sr_id', 's_rate', 'date');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->display_as('id', 'ID#');
				$this->crud->display_as('sr_id', 'Date');
				$this->crud->display_as('user_id','Created By');
				$this->crud->display_as('comment','Comment');
				$this->crud->display_as('created','Creation Date');
				$this->crud->where('sr_id', $sr_id);
				$this->crud->callback_before_insert(array($this,'sr_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function sr_signatures($pk, $row) {
			return '/backend/sr_signature/'.$pk;
		}

		public function sr_signature($sr_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('sr_signature');
				$this->crud->set_subject('Special rate Signature');
				$this->crud->callback_field('sr_id',array($this,'fixed_sr'));
				$this->crud->set_relation('sr_id', 's_rate', 'date');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->set_relation('role_id', 'roles', 'role');
				$this->crud->set_relation('department_id', 'departments', 'name');
				$this->crud->display_as('id', 'ID#');
				$this->crud->display_as('sr_id', 'Date');
				$this->crud->display_as('user_id','Signer');
				$this->crud->display_as('role_id','Role');
				$this->crud->display_as('department_id','Department');
				$this->crud->display_as('rank','Rank');
				$this->crud->display_as('reject','Reject');
				$this->crud->display_as('timestamp','Creation Date');
				$this->crud->where('sr_id', $sr_id);
				$this->crud->callback_before_insert(array($this,'sr_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function sr_attachments($pk, $row) {
			return '/backend/sr_attachment/'.$pk;
		}

		public function sr_attachment($sr_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('sr_filles');
				$this->crud->set_subject('Special rate Attachment');
				$this->crud->callback_field('sr_id',array($this,'fixed_sr'));
				$this->crud->set_relation('sr_id', 's_rate', 'date');
				$this->crud->display_as('id', 'ID#');
				$this->crud->display_as('sr_id', 'Date');
				$this->crud->display_as('name','Name');
				$this->crud->set_field_upload('name','assets/uploads/files');
				$this->crud->where('sr_id', $sr_id);
				$this->crud->callback_before_insert(array($this,'sr_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function sr_type() {
			try {
				$this->load->model('roles_model');
				$this->load->model('Departments_model');
				$this->crud->set_theme('datatables');
				$this->crud->set_table('sr_type');
				$this->crud->set_subject('Special rate Signatures');
				$this->crud->columns('id', 'name', 'dummy', 'dummy1');
				$this->crud->display_as('dummy', 'Role Signatures');
				$this->crud->display_as('dummy1', 'Department Signatures');
				$this->crud->display_as('name', 'Name');
				$this->crud->display_as('id', 'ID#');
				$this->crud->callback_field('dummy',array($this,'sr_role_sign'));
				$this->crud->callback_field('dummy1',array($this,'sr_department_sign'));
				$this->crud->callback_before_insert(array($this,'process_for_insert_sr'));
				$this->crud->callback_after_insert(array($this,'process_extras_after_sr'));
				$this->crud->callback_before_update(array($this,'process_extras_sr'));
				$this->crud->set_soft_delete();
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function process_for_insert_sr($post_array) {
		  	unset($post_array['roles']);
		  	unset($post_array['departments']);
		 	return $post_array;
		}

		public function process_extras_after_sr($post_array, $primary_key) {
		  	$this->load->model('sr_role_model');
		  	$this->sr_role_model->reset_sr($primary_key);
		  	$rank = 1;
		  	$resulte =  array();
		  	foreach ($post_array['roles'] as $key => $role) {
		    	if ($role != 0) {
		      		$sign_id = $this->sr_role_model->add_role_sr($primary_key, $role, $rank);
		      		$resulte[] = $sign_id;
		      		$rank++;
		    	}
		  	}
		  	foreach ($post_array['departments'] as $key => $department) {
		    	if ($department != 0) {
		      		$this->sr_role_model->add_department_sr($primary_key, $department, $resulte[$key]);
		    	}
		  	}
		}

		public function process_extras_sr($post_array, $primary_key) {
		  	$this->load->model('sr_role_model');
		  	$this->sr_role_model->reset_sr($primary_key);
		  	$rank = 1;
		  	$resulte =  array();
		  	foreach ($post_array['roles'] as $key => $role) {
		    	if ($role != 0) {
		      		$sign_id = $this->sr_role_model->add_role_sr($primary_key, $role, $rank);
		      		$resulte[] = $sign_id;
		      		$rank++;
		    	}
		  	}
		  	foreach ($post_array['departments'] as $key => $department) {
		    	if ($department != 0) {
		      		$this->sr_role_model->add_department_sr($primary_key, $department, $resulte[$key]);
		    	}
		  	}
		  	unset($post_array['roles']);
		  	unset($post_array['departments']);
		  	return $post_array;
		}

		public function sr_role_sign($var, $primary_key = null) {
		  	$this->load->model('sr_role_model');
		  	$sr_roles = $this->sr_role_model->getby_sr($primary_key);
		  	$all_roles = $this->roles_model->getall();
		  	$global_field = '<div id="role-hidden-template" style="display:none">'.$this->sr_role_signature_field($all_roles, FALSE, FALSE).'</div>';
		  	$global_field .= '<div class="field-role-global .connected">';
		  	foreach ($sr_roles as $sr_role) {
		    	$global_field .= $this->sr_role_signature_field($all_roles, $sr_role['role']);
		  	}
		  	$global_field .= $this->sr_role_signature_field($all_roles);
		  	$global_field .= '</div> <br />';
		  	$global_field .= '<script type="text/javascript">
		        $(function () {
		            $(".role-selector").change(function(){
		                var zeroValue = false;
		                $(".field-role-global .role-selector").each(function(){
		                  	if ($(this).val() == ""){
		                    	zeroValue = true;
		                  	}
		                });
		              	if(!zeroValue) {
			                $clone = $("#role-hidden-template").children().first().clone(true);
			                $clone.find("select").addClass("chosen-select");
			                $clone.appendTo(".field-role-global");
		                	$(".chosen-select").chosen();
		              	}
		            });
		            $(".field-role-global").sortable({
		                connectWith: ".connected"
		            });
		        });
		    </script>';
		  	return $global_field;
		}

		private function sr_role_signature_field( $all_roles, $option = FALSE, $chosen = TRUE) {
		  	$class = ($chosen)? 'chosen-select' : '';
		  	$field = '
			  	<div class="form-input-box sortable-selects" >
			    	<select name="roles[]" class="'.$class.' role-selector" data-placeholder="Select Role">
			      		<option value=""></option>
			      		';
			  			foreach ($all_roles as $role) {
						    $field .= '<option value="'.$role['id'].'" ';
						    $field .= ($option && $option == $role['id'])? ' selected="selected" ' : '';
						    $field .= '>'.$role['role'].'</option>';
			  			};
			  			$field .= '
			    	</select>
			    	<span class="icon icon-th-list"></span>
			  	</div>
			';
		  	return $field;
		}

		public function sr_department_sign($var, $primary_key = null) {
		  	$this->load->model('sr_role_model');
		  	$sr_departments = $this->sr_role_model->getby_sr($primary_key);
		  	$all_departments = $this->Departments_model->getall();
		  	$global_field = '<div class="field-department-global .connected">';
		  	foreach ($sr_departments as $sr_department) {
		    	$global_field .= $this->sr_department_signature_field($all_departments, $sr_department['department']);
		  	}
		  	$global_field .= $this->sr_department_signature_field($all_departments);
		  	$global_field .= '</div> <br />';
		  	return $global_field;
		}

		private function sr_department_signature_field( $all_departments, $option = FALSE, $chosen = TRUE) {
		  	$class = ($chosen)? 'chosen-select' : '';
		  	$field = '
			  	<div class="form-input-box sortable-selects" >
			    	<select name="departments[]" class="'.$class.' department-selector" data-placeholder="Select Department">
			      		<option value=""></option>
			      		';
			  			foreach ($all_departments as $department) {
						    $field .= '<option value="'.$department['id'].'" ';
						    $field .= ($option && $option == $department['id'])? ' selected="selected" ' : '';
						    $field .= '>'.$department['name'].'</option>';
			  			};
			  			$field .= '
			    	</select>
			    	<span class="icon icon-th-list"></span>
			  	</div>
			';
		  	return $field;
		}

		public function rr_change() {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('rr_change');
				$this->crud->set_subject('Room Change Report');
				$this->crud->columns('id', 'hotel_id', 'date', 'rr', 'timestamp');
				$this->crud->set_relation('hotel_id', 'hotels', 'name');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->display_as('id', 'ID#');
				$this->crud->display_as('hotel_id','Hotel Name');
				$this->crud->display_as('user_id','Created By');
				$this->crud->display_as('date','Date');
				$this->crud->display_as('type','Type');
				$this->crud->display_as('rr','Report Type');
				$this->crud->display_as('state_id','State');
				$this->crud->display_as('timestamp','Creation Date');
				$this->crud->add_action('Edit Room Change Rooms', '', '','ui-icon-image',array($this,'rr_rooms'));
				$this->crud->add_action('Edit Room Change Comments', '', '','ui-icon-image',array($this,'rr_comments'));
				$this->crud->add_action('Edit Room Change Signatures', '', '','ui-icon-image',array($this,'rr_signatures'));
				$this->crud->add_action('Edit Room Change Attachments', '', '','ui-icon-image',array($this,'rr_attachments'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function rr_associates($post_array) {
			$rr_id = $this->uri->segment(3);
			$post_array['rr_id'] = $rr_id;
			return $post_array;
		}

		public function fixed_rr() {
			return '';
		}

		function rr_rooms($pk, $row) {
			return '/backend/rr_room/'.$pk;
		}

		public function rr_room($rr_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('rr_room');
				$this->crud->set_subject('Room Change Room');
				$this->crud->callback_field('rr_id',array($this,'fixed_rr'));
				$this->crud->set_relation('rr_id', 'rr_change', 'date');
				$this->crud->set_relation('rt_id', 'operators', 'name');
				$this->crud->display_as('id', 'ID#');
				$this->crud->display_as('rr_id', 'Date');
				$this->crud->display_as('room','Room');
				$this->crud->display_as('r_from','From');
				$this->crud->display_as('r_to','To');
				$this->crud->display_as('rt_id','Travel Agent');
				$this->crud->display_as('remarks','Remarks');
				$this->crud->where('rr_id', $rr_id);
				$this->crud->callback_before_insert(array($this,'rr_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function rr_comments($pk, $row) {
			return '/backend/rr_comment/'.$pk;
		}

		public function rr_comment($rr_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('rr_comments');
				$this->crud->set_subject('Room Change Comment');
				$this->crud->callback_field('rr_id',array($this,'fixed_rr'));
				$this->crud->set_relation('rr_id', 'rr_change', 'date');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->display_as('id', 'ID#');
				$this->crud->display_as('rr_id', 'Date');
				$this->crud->display_as('user_id','Created By');
				$this->crud->display_as('comment','Comment');
				$this->crud->display_as('created','Creation Date');
				$this->crud->where('rr_id', $rr_id);
				$this->crud->callback_before_insert(array($this,'rr_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function rr_signatures($pk, $row) {
			return '/backend/rr_signature/'.$pk;
		}

		public function rr_signature($rr_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('rr_signature');
				$this->crud->set_subject('Room Change Signature');
				$this->crud->callback_field('rr_id',array($this,'fixed_rr'));
				$this->crud->set_relation('rr_id', 'rr_change', 'date');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->set_relation('role_id', 'roles', 'role');
				$this->crud->set_relation('department_id', 'departments', 'name');
				$this->crud->display_as('id', 'ID#');
				$this->crud->display_as('rr_id', 'Date');
				$this->crud->display_as('user_id','Signer');
				$this->crud->display_as('role_id','Role');
				$this->crud->display_as('department_id','Department');
				$this->crud->display_as('rank','Rank');
				$this->crud->display_as('reject','Reject');
				$this->crud->display_as('timestamp','Creation Date');
				$this->crud->where('rr_id', $rr_id);
				$this->crud->callback_before_insert(array($this,'rr_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function rr_attachments($pk, $row) {
			return '/backend/rr_attachment/'.$pk;
		}

		public function rr_attachment($rr_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('rr_filles');
				$this->crud->set_subject('Room Change Attachment');
				$this->crud->callback_field('rr_id',array($this,'fixed_rr'));
				$this->crud->set_relation('rr_id', 'rr_change', 'date');
				$this->crud->display_as('id', 'ID#');
				$this->crud->display_as('rr_id', 'Date');
				$this->crud->display_as('name','Name');
				$this->crud->set_field_upload('name','assets/uploads/files');
				$this->crud->where('rr_id', $rr_id);
				$this->crud->callback_before_insert(array($this,'rr_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function rr_type() {
			try {
				$this->load->model('roles_model');
				$this->load->model('Departments_model');
				$this->crud->set_theme('datatables');
				$this->crud->set_table('rr_type');
				$this->crud->set_subject('Room Change Signatures');
				$this->crud->columns('id', 'name', 'dummy', 'dummy1');
				$this->crud->display_as('dummy', 'Role Signatures');
				$this->crud->display_as('dummy1', 'Department Signatures');
				$this->crud->display_as('name', 'Name');
				$this->crud->display_as('id', 'ID#');
				$this->crud->callback_field('dummy',array($this,'rr_role_sign'));
				$this->crud->callback_field('dummy1',array($this,'rr_department_sign'));
				$this->crud->callback_before_insert(array($this,'process_for_insert_rr'));
				$this->crud->callback_after_insert(array($this,'process_extras_after_rr'));
				$this->crud->callback_before_update(array($this,'process_extras_rr'));
				$this->crud->set_soft_delete();
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function process_for_insert_rr($post_array) {
		  	unset($post_array['roles']);
		  	unset($post_array['departments']);
		 	return $post_array;
		}

		public function process_extras_after_rr($post_array, $primary_key) {
		  	$this->load->model('rr_role_model');
		  	$this->rr_role_model->reset_rr($primary_key);
		  	$rank = 1;
		  	$resulte =  array();
		  	foreach ($post_array['roles'] as $key => $role) {
		    	if ($role != 0) {
		      		$sign_id = $this->rr_role_model->add_role_rr($primary_key, $role, $rank);
		      		$resulte[] = $sign_id;
		      		$rank++;
		    	}
		  	}
		  	foreach ($post_array['departments'] as $key => $department) {
		    	if ($department != 0) {
		      		$this->rr_role_model->add_department_rr($primary_key, $department, $resulte[$key]);
		    	}
		  	}
		}

		public function process_extras_rr($post_array, $primary_key) {
		  	$this->load->model('rr_role_model');
		  	$this->rr_role_model->reset_rr($primary_key);
		  	$rank = 1;
		  	$resulte =  array();
		  	foreach ($post_array['roles'] as $key => $role) {
		    	if ($role != 0) {
		      		$sign_id = $this->rr_role_model->add_role_rr($primary_key, $role, $rank);
		      		$resulte[] = $sign_id;
		      		$rank++;
		    	}
		  	}
		  	foreach ($post_array['departments'] as $key => $department) {
		    	if ($department != 0) {
		      		$this->rr_role_model->add_department_rr($primary_key, $department, $resulte[$key]);
		    	}
		  	}
		  	unset($post_array['roles']);
		  	unset($post_array['departments']);
		  	return $post_array;
		}

		public function rr_role_sign($var, $primary_key = null) {
		  	$this->load->model('rr_role_model');
		  	$rr_roles = $this->rr_role_model->getby_rr($primary_key);
		  	$all_roles = $this->roles_model->getall();
		  	$global_field = '<div id="role-hidden-template" style="display:none">'.$this->rr_role_signature_field($all_roles, FALSE, FALSE).'</div>';
		  	$global_field .= '<div class="field-role-global .connected">';
		  	foreach ($rr_roles as $rr_role) {
		    	$global_field .= $this->rr_role_signature_field($all_roles, $rr_role['role']);
		  	}
		  	$global_field .= $this->rr_role_signature_field($all_roles);
		  	$global_field .= '</div> <br />';
		  	$global_field .= '<script type="text/javascript">
		        $(function () {
		            $(".role-selector").change(function(){
		                var zeroValue = false;
		                $(".field-role-global .role-selector").each(function(){
		                  	if ($(this).val() == ""){
		                    	zeroValue = true;
		                  	}
		                });
		              	if(!zeroValue) {
			                $clone = $("#role-hidden-template").children().first().clone(true);
			                $clone.find("select").addClass("chosen-select");
			                $clone.appendTo(".field-role-global");
		                	$(".chosen-select").chosen();
		              	}
		            });
		            $(".field-role-global").sortable({
		                connectWith: ".connected"
		            });
		        });
		    </script>';
		  	return $global_field;
		}

		private function rr_role_signature_field( $all_roles, $option = FALSE, $chosen = TRUE) {
		  	$class = ($chosen)? 'chosen-select' : '';
		  	$field = '
			  	<div class="form-input-box sortable-selects" >
			    	<select name="roles[]" class="'.$class.' role-selector" data-placeholder="Select Role">
			      		<option value=""></option>
			      		';
			  			foreach ($all_roles as $role) {
						    $field .= '<option value="'.$role['id'].'" ';
						    $field .= ($option && $option == $role['id'])? ' selected="selected" ' : '';
						    $field .= '>'.$role['role'].'</option>';
			  			};
			  			$field .= '
			    	</select>
			    	<span class="icon icon-th-list"></span>
			  	</div>
			';
		  	return $field;
		}

		public function rr_department_sign($var, $primary_key = null) {
		  	$this->load->model('rr_role_model');
		  	$rr_departments = $this->rr_role_model->getby_rr($primary_key);
		  	$all_departments = $this->Departments_model->getall();
		  	$global_field = '<div class="field-department-global .connected">';
		  	foreach ($rr_departments as $rr_department) {
		    	$global_field .= $this->rr_department_signature_field($all_departments, $rr_department['department']);
		  	}
		  	$global_field .= $this->rr_department_signature_field($all_departments);
		  	$global_field .= '</div> <br />';
		  	return $global_field;
		}

		private function rr_department_signature_field( $all_departments, $option = FALSE, $chosen = TRUE) {
		  	$class = ($chosen)? 'chosen-select' : '';
		  	$field = '
			  	<div class="form-input-box sortable-selects" >
			    	<select name="departments[]" class="'.$class.' department-selector" data-placeholder="Select Department">
			      		<option value=""></option>
			      		';
			  			foreach ($all_departments as $department) {
						    $field .= '<option value="'.$department['id'].'" ';
						    $field .= ($option && $option == $department['id'])? ' selected="selected" ' : '';
						    $field .= '>'.$department['name'].'</option>';
			  			};
			  			$field .= '
			    	</select>
			    	<span class="icon icon-th-list"></span>
			  	</div>
			';
		  	return $field;
		}

		public function operators() {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('operators');
				$this->crud->set_subject('Travel Agent');
				$this->crud->columns('id', 'name');
				$this->crud->display_as('name','Travel Agent');
				$this->crud->display_as('id', 'ID#');
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function upgrad() {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('upgrad');
				$this->crud->set_subject('Free Room Upgrading Form');
				$this->crud->columns('id', 'hotel_id', 'date', 'timestamp');
				$this->crud->set_relation('hotel_id', 'hotels', 'name');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->display_as('id', 'ID#');
				$this->crud->display_as('hotel_id','Hotel Name');
				$this->crud->display_as('user_id','Created By');
				$this->crud->display_as('date','Date');
				$this->crud->display_as('state_id','State');
				$this->crud->display_as('timestamp','Creation Date');
				$this->crud->add_action('Edit Free Room Upgrading Rooms', '', '','ui-icon-image',array($this,'upgrad_rooms'));
				$this->crud->add_action('Edit Free Room Upgrading Comments', '', '','ui-icon-image',array($this,'upgrad_comments'));
				$this->crud->add_action('Edit Free Room Upgrading Signatures', '', '','ui-icon-image',array($this,'upgrad_signatures'));
				$this->crud->add_action('Edit Free Room Upgrading Attachments', '', '','ui-icon-image',array($this,'upgrad_attachments'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function upgrad_associates($post_array) {
			$up_id = $this->uri->segment(3);
			$post_array['up_id'] = $up_id;
			return $post_array;
		}

		public function fixed_upgrad() {
			return '';
		}

		function upgrad_rooms($pk, $row) {
			return '/backend/upgrad_room/'.$pk;
		}

		public function upgrad_room($up_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('upgrad_room');
				$this->crud->set_subject('Free Room Upgrading Room');
				$this->crud->callback_field('up_id',array($this,'fixed_upgrad'));
				$this->crud->set_relation('up_id', 'upgrad', 'date');
				$this->crud->set_relation('operator_id', 'operators', 'name');
				$this->crud->set_relation('reason_id', 'upgrad_reasons', 'name');
				$this->crud->set_relation('new_type_id', 'rooms_types', 'name');
				$this->crud->set_relation('booked_type_id', 'room_types', 'name');
				$this->crud->display_as('id', 'ID#');
				$this->crud->display_as('up_id', 'Date');
				$this->crud->display_as('room','Room');
				$this->crud->display_as('guest','Guest Name');
				$this->crud->display_as('operator_id','Travel Agent');
				$this->crud->display_as('arrival','Arrival Date');
				$this->crud->display_as('departure','Departure Date');
				$this->crud->display_as('booked_type_id','Booked Type');
				$this->crud->display_as('new_type_id','New Type');
				$this->crud->display_as('reason','Reason');
				$this->crud->display_as('reason_id','Reason');
				$this->crud->display_as('occupancy','Occupancy');
				$this->crud->display_as('arrival_room','Arrival Room');
				$this->crud->display_as('departure_room','Departure Room');
				$this->crud->where('up_id', $up_id);
				$this->crud->callback_before_insert(array($this,'upgrad_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function upgrad_comments($pk, $row) {
			return '/backend/upgrad_comment/'.$pk;
		}

		public function upgrad_comment($up_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('upgrad_comments');
				$this->crud->set_subject('Free Room Upgrading Comment');
				$this->crud->callback_field('up_id',array($this,'fixed_upgrad'));
				$this->crud->set_relation('up_id', 'upgrad', 'date');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->display_as('id', 'ID#');
				$this->crud->display_as('up_id', 'Date');
				$this->crud->display_as('user_id','Created By');
				$this->crud->display_as('comment','Comment');
				$this->crud->display_as('created','Creation Date');
				$this->crud->where('up_id', $up_id);
				$this->crud->callback_before_insert(array($this,'upgrad_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function upgrad_signatures($pk, $row) {
			return '/backend/upgrad_signature/'.$pk;
		}

		public function upgrad_signature($up_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('upgrad_signature');
				$this->crud->set_subject('Free Room Upgrading Signature');
				$this->crud->callback_field('up_id',array($this,'fixed_upgrad'));
				$this->crud->set_relation('up_id', 'upgrad', 'date');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->set_relation('role_id', 'roles', 'role');
				$this->crud->set_relation('department_id', 'departments', 'name');
				$this->crud->display_as('id', 'ID#');
				$this->crud->display_as('up_id', 'Date');
				$this->crud->display_as('user_id','Signer');
				$this->crud->display_as('role_id','Role');
				$this->crud->display_as('department_id','Department');
				$this->crud->display_as('rank','Rank');
				$this->crud->display_as('reject','Reject');
				$this->crud->display_as('timestamp','Creation Date');
				$this->crud->where('up_id', $up_id);
				$this->crud->callback_before_insert(array($this,'upgrad_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function upgrad_attachments($pk, $row) {
			return '/backend/upgrad_attachment/'.$pk;
		}

		public function upgrad_attachment($up_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('upgrad_filles');
				$this->crud->set_subject('Free Room Upgrading Attachment');
				$this->crud->callback_field('up_id',array($this,'fixed_upgrad'));
				$this->crud->set_relation('up_id', 'upgrad', 'date');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->display_as('id', 'ID#');
				$this->crud->display_as('up_id', 'Date');
				$this->crud->display_as('user_id','Created By');
				$this->crud->display_as('name','Name');
				$this->crud->display_as('timestamp','Creation Date');
				$this->crud->set_field_upload('name','assets/uploads/files');
				$this->crud->where('up_id', $up_id);
				$this->crud->callback_before_insert(array($this,'upgrad_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function upgrad_type() {
			try {
				$this->load->model('roles_model');
				$this->load->model('Departments_model');
				$this->crud->set_theme('datatables');
				$this->crud->set_table('upgrad_type');
				$this->crud->set_subject('Free Room Upgrading Signatures');
				$this->crud->columns('id', 'name', 'dummy', 'dummy1');
				$this->crud->display_as('dummy', 'Role Signatures');
				$this->crud->display_as('dummy1', 'Department Signatures');
				$this->crud->display_as('name', 'Name');
				$this->crud->display_as('id', 'ID#');
				$this->crud->callback_field('dummy',array($this,'upgrad_role_sign'));
				$this->crud->callback_field('dummy1',array($this,'upgrad_department_sign'));
				$this->crud->callback_before_insert(array($this,'process_for_insert_upgrad'));
				$this->crud->callback_after_insert(array($this,'process_extras_after_upgrad'));
				$this->crud->callback_before_update(array($this,'process_extras_upgrad'));
				$this->crud->set_soft_delete();
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function process_for_insert_upgrad($post_array) {
		  	unset($post_array['roles']);
		  	unset($post_array['departments']);
		 	return $post_array;
		}

		public function process_extras_after_upgrad($post_array, $primary_key) {
		  	$this->load->model('upgrad_role_model');
		  	$this->upgrad_role_model->reset_upgrad($primary_key);
		  	$rank = 1;
		  	$resulte =  array();
		  	foreach ($post_array['roles'] as $key => $role) {
		    	if ($role != 0) {
		      		$sign_id = $this->upgrad_role_model->add_role_upgrad($primary_key, $role, $rank);
		      		$resulte[] = $sign_id;
		      		$rank++;
		    	}
		  	}
		  	foreach ($post_array['departments'] as $key => $department) {
		    	if ($department != 0) {
		      		$this->upgrad_role_model->add_department_upgrad($primary_key, $department, $resulte[$key]);
		    	}
		  	}
		}

		public function process_extras_upgrad($post_array, $primary_key) {
		  	$this->load->model('upgrad_role_model');
		  	$this->upgrad_role_model->reset_upgrad($primary_key);
		  	$rank = 1;
		  	$resulte =  array();
		  	foreach ($post_array['roles'] as $key => $role) {
		    	if ($role != 0) {
		      		$sign_id = $this->upgrad_role_model->add_role_upgrad($primary_key, $role, $rank);
		      		$resulte[] = $sign_id;
		      		$rank++;
		    	}
		  	}
		  	foreach ($post_array['departments'] as $key => $department) {
		    	if ($department != 0) {
		      		$this->upgrad_role_model->add_department_upgrad($primary_key, $department, $resulte[$key]);
		    	}
		  	}
		  	unset($post_array['roles']);
		  	unset($post_array['departments']);
		  	return $post_array;
		}

		public function upgrad_role_sign($var, $primary_key = null) {
		  	$this->load->model('upgrad_role_model');
		  	$up_roles = $this->upgrad_role_model->getby_upgrad($primary_key);
		  	$all_roles = $this->roles_model->getall();
		  	$global_field = '<div id="role-hidden-template" style="display:none">'.$this->upgrad_role_signature_field($all_roles, FALSE, FALSE).'</div>';
		  	$global_field .= '<div class="field-role-global .connected">';
		  	foreach ($up_roles as $up_role) {
		    	$global_field .= $this->upgrad_role_signature_field($all_roles, $up_role['role']);
		  	}
		  	$global_field .= $this->upgrad_role_signature_field($all_roles);
		  	$global_field .= '</div> <br />';
		  	$global_field .= '<script type="text/javascript">
		        $(function () {
		            $(".role-selector").change(function(){
		                var zeroValue = false;
		                $(".field-role-global .role-selector").each(function(){
		                  	if ($(this).val() == ""){
		                    	zeroValue = true;
		                  	}
		                });
		              	if(!zeroValue) {
			                $clone = $("#role-hidden-template").children().first().clone(true);
			                $clone.find("select").addClass("chosen-select");
			                $clone.appendTo(".field-role-global");
		                	$(".chosen-select").chosen();
		              	}
		            });
		            $(".field-role-global").sortable({
		                connectWith: ".connected"
		            });
		        });
		    </script>';
		  	return $global_field;
		}

		private function upgrad_role_signature_field( $all_roles, $option = FALSE, $chosen = TRUE) {
		  	$class = ($chosen)? 'chosen-select' : '';
		  	$field = '
			  	<div class="form-input-box sortable-selects" >
			    	<select name="roles[]" class="'.$class.' role-selector" data-placeholder="Select Role">
			      		<option value=""></option>
			      		';
			  			foreach ($all_roles as $role) {
						    $field .= '<option value="'.$role['id'].'" ';
						    $field .= ($option && $option == $role['id'])? ' selected="selected" ' : '';
						    $field .= '>'.$role['role'].'</option>';
			  			};
			  			$field .= '
			    	</select>
			    	<span class="icon icon-th-list"></span>
			  	</div>
			';
		  	return $field;
		}

		public function upgrad_department_sign($var, $primary_key = null) {
		  	$this->load->model('upgrad_role_model');
		  	$up_departments = $this->upgrad_role_model->getby_upgrad($primary_key);
		  	$all_departments = $this->Departments_model->getall();
		  	$global_field = '<div class="field-department-global .connected">';
		  	foreach ($up_departments as $up_department) {
		    	$global_field .= $this->upgrad_department_signature_field($all_departments, $up_department['department']);
		  	}
		  	$global_field .= $this->upgrad_department_signature_field($all_departments);
		  	$global_field .= '</div> <br />';
		  	return $global_field;
		}

		private function upgrad_department_signature_field( $all_departments, $option = FALSE, $chosen = TRUE) {
		  	$class = ($chosen)? 'chosen-select' : '';
		  	$field = '
			  	<div class="form-input-box sortable-selects" >
			    	<select name="departments[]" class="'.$class.' department-selector" data-placeholder="Select Department">
			      		<option value=""></option>
			      		';
			  			foreach ($all_departments as $department) {
						    $field .= '<option value="'.$department['id'].'" ';
						    $field .= ($option && $option == $department['id'])? ' selected="selected" ' : '';
						    $field .= '>'.$department['name'].'</option>';
			  			};
			  			$field .= '
			    	</select>
			    	<span class="icon icon-th-list"></span>
			  	</div>
			';
		  	return $field;
		}

		public function upgrad_reasons() {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('upgrad_reasons');
				$this->crud->set_subject('Reason');
				$this->crud->columns('id', 'name');
				$this->crud->display_as('name','Reason');
				$this->crud->display_as('id', 'ID#');
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function rooms_types() {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('rooms_types');
				$this->crud->set_subject('Type');
				$this->crud->columns('id', 'name');
				$this->crud->display_as('name','Type');
				$this->crud->display_as('id', 'ID#');
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function room_types() {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('room_types');
				$this->crud->set_subject('Type');
				$this->crud->columns('id', 'name');
				$this->crud->display_as('name','Type');
				$this->crud->display_as('id', 'ID#');
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function bd_use() {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('bd_use');
				$this->crud->set_subject('Beach/Day Use Request');
				$this->crud->columns('id', 'hotel_id', 'type_id', 'timestamp');
				$this->crud->set_relation('hotel_id', 'hotels', 'name');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->set_relation('type_id', 'bd_use_types', 'name');
				$this->crud->display_as('id', 'ID#');
				$this->crud->display_as('hotel_id','Hotel Name');
				$this->crud->display_as('user_id','Created By');
				$this->crud->display_as('type_id','Type');
				$this->crud->display_as('state_id','State');
				$this->crud->display_as('timestamp','Creation Date');
				$this->crud->add_action('Edit Beach/Day Use Rooms', '', '','ui-icon-image',array($this,'bd_use_rooms'));
				$this->crud->add_action('Edit Beach/Day Use Comments', '', '','ui-icon-image',array($this,'bd_use_comments'));
				$this->crud->add_action('Edit Beach/Day Use Signatures', '', '','ui-icon-image',array($this,'bd_use_signatures'));
				$this->crud->add_action('Edit Beach/Day Use Attachments', '', '','ui-icon-image',array($this,'bd_use_attachments'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function bd_use_associates($post_array) {
			$use_id = $this->uri->segment(3);
			$post_array['use_id'] = $use_id;
			return $post_array;
		}

		public function fixed_bd_use() {
			return '';
		}

		function bd_use_rooms($pk, $row) {
			return '/backend/bd_use_room/'.$pk;
		}

		public function bd_use_room($use_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('bd_use_element');
				$this->crud->set_subject('Beach/Day Use Room');
				$this->crud->callback_field('use_id',array($this,'fixed_bd_use'));
				$this->crud->set_relation('use_id', 'bd_use', 'timestamp');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->set_relation('operator_id', 'operators', 'name');
				$this->crud->display_as('id', 'ID#');
				$this->crud->display_as('use_id', 'Creation Date');
				$this->crud->display_as('user_id','Created By');
				$this->crud->display_as('room','Room');
				$this->crud->display_as('date','Date');
				$this->crud->display_as('type','Type');
				$this->crud->display_as('pax','No. Pax');
				$this->crud->display_as('child','No. Child');
				$this->crud->display_as('arrival','Arrival Date');
				$this->crud->display_as('departure','Departure Date');
				$this->crud->display_as('guest','Guest Name');
				$this->crud->display_as('nationality','Nationality');
				$this->crud->display_as('operator_id','Travel Agent');
				$this->crud->display_as('reason','Reason');
				$this->crud->display_as('timestamp','Timestamp');
				$this->crud->where('use_id', $use_id);
				$this->crud->callback_before_insert(array($this,'bd_use_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function bd_use_comments($pk, $row) {
			return '/backend/bd_use_comment/'.$pk;
		}

		public function bd_use_comment($use_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('bd_use_comments');
				$this->crud->set_subject('Beach/Day Use Comment');
				$this->crud->callback_field('use_id',array($this,'fixed_bd_use'));
				$this->crud->set_relation('use_id', 'bd_use', 'timestamp');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->display_as('id', 'ID#');
				$this->crud->display_as('use_id', 'Creation Date');
				$this->crud->display_as('user_id','Created By');
				$this->crud->display_as('comment','Comment');
				$this->crud->display_as('created','Timestamp');
				$this->crud->where('use_id', $use_id);
				$this->crud->callback_before_insert(array($this,'bd_use_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function bd_use_signatures($pk, $row) {
			return '/backend/bd_use_signature/'.$pk;
		}

		public function bd_use_signature($use_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('bd_use_signature');
				$this->crud->set_subject('Beach/Day Use Signature');
				$this->crud->callback_field('use_id',array($this,'fixed_bd_use'));
				$this->crud->set_relation('use_id', 'bd_use', 'timestamp');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->set_relation('role_id', 'roles', 'role');
				$this->crud->set_relation('department_id', 'departments', 'name');
				$this->crud->display_as('id', 'ID#');
				$this->crud->display_as('use_id', 'Creation Date');
				$this->crud->display_as('user_id','Signer');
				$this->crud->display_as('role_id','Role');
				$this->crud->display_as('department_id','Department');
				$this->crud->display_as('rank','Rank');
				$this->crud->display_as('reject','Reject');
				$this->crud->display_as('timestamp','Timestamp');
				$this->crud->where('use_id', $use_id);
				$this->crud->callback_before_insert(array($this,'bd_use_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function bd_use_attachments($pk, $row) {
			return '/backend/bd_use_attachment/'.$pk;
		}

		public function bd_use_attachment($use_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('bd_use_filles');
				$this->crud->set_subject('Beach/Day Use Attachment');
				$this->crud->callback_field('use_id',array($this,'fixed_bd_use'));
				$this->crud->set_relation('use_id', 'bd_use', 'timestamp');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->display_as('id', 'ID#');
				$this->crud->display_as('use_id', 'Creation Date');
				$this->crud->display_as('user_id','Created By');
				$this->crud->display_as('name','Name');
				$this->crud->display_as('timestamp','Timestamp');
				$this->crud->set_field_upload('name','assets/uploads/files');
				$this->crud->where('use_id', $use_id);
				$this->crud->callback_before_insert(array($this,'bd_use_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function bd_use_type() {
			try {
				$this->load->model('roles_model');
				$this->load->model('Departments_model');
				$this->crud->set_theme('datatables');
				$this->crud->set_table('bd_use_type');
				$this->crud->set_subject('Beach/Day Use Signatures');
				$this->crud->columns('id', 'name', 'dummy', 'dummy1');
				$this->crud->display_as('dummy', 'Role Signatures');
				$this->crud->display_as('dummy1', 'Department Signatures');
				$this->crud->display_as('name', 'Name');
				$this->crud->display_as('id', 'ID#');
				$this->crud->callback_field('dummy',array($this,'bd_use_role_sign'));
				$this->crud->callback_field('dummy1',array($this,'bd_use_department_sign'));
				$this->crud->callback_before_insert(array($this,'process_for_insert_bd_use'));
				$this->crud->callback_after_insert(array($this,'process_extras_after_bd_use'));
				$this->crud->callback_before_update(array($this,'process_extras_bd_use'));
				$this->crud->set_soft_delete();
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function process_for_insert_bd_use($post_array) {
		  	unset($post_array['roles']);
		  	unset($post_array['departments']);
		 	return $post_array;
		}

		public function process_extras_after_bd_use($post_array, $primary_key) {
		  	$this->load->model('bd_use_role_model');
		  	$this->bd_use_role_model->reset_bd_use($primary_key);
		  	$rank = 1;
		  	$resulte =  array();
		  	foreach ($post_array['roles'] as $key => $role) {
		    	if ($role != 0) {
		      		$sign_id = $this->bd_use_role_model->add_role_bd_use($primary_key, $role, $rank);
		      		$resulte[] = $sign_id;
		      		$rank++;
		    	}
		  	}
		  	foreach ($post_array['departments'] as $key => $department) {
		    	if ($department != 0) {
		      		$this->bd_use_role_model->add_department_bd_use($primary_key, $department, $resulte[$key]);
		    	}
		  	}
		}

		public function process_extras_bd_use($post_array, $primary_key) {
		  	$this->load->model('bd_use_role_model');
		  	$this->bd_use_role_model->reset_bd_use($primary_key);
		  	$rank = 1;
		  	$resulte =  array();
		  	foreach ($post_array['roles'] as $key => $role) {
		    	if ($role != 0) {
		      		$sign_id = $this->bd_use_role_model->add_role_bd_use($primary_key, $role, $rank);
		      		$resulte[] = $sign_id;
		      		$rank++;
		    	}
		  	}
		  	foreach ($post_array['departments'] as $key => $department) {
		    	if ($department != 0) {
		      		$this->bd_use_role_model->add_department_bd_use($primary_key, $department, $resulte[$key]);
		    	}
		  	}
		  	unset($post_array['roles']);
		  	unset($post_array['departments']);
		  	return $post_array;
		}

		public function bd_use_role_sign($var, $primary_key = null) {
		  	$this->load->model('bd_use_role_model');
		  	$use_roles = $this->bd_use_role_model->getby_bd_use($primary_key);
		  	$all_roles = $this->roles_model->getall();
		  	$global_field = '<div id="role-hidden-template" style="display:none">'.$this->bd_use_role_signature_field($all_roles, FALSE, FALSE).'</div>';
		  	$global_field .= '<div class="field-role-global .connected">';
		  	foreach ($use_roles as $use_role) {
		    	$global_field .= $this->bd_use_role_signature_field($all_roles, $use_role['role']);
		  	}
		  	$global_field .= $this->bd_use_role_signature_field($all_roles);
		  	$global_field .= '</div> <br />';
		  	$global_field .= '<script type="text/javascript">
		        $(function () {
		            $(".role-selector").change(function(){
		                var zeroValue = false;
		                $(".field-role-global .role-selector").each(function(){
		                  	if ($(this).val() == ""){
		                    	zeroValue = true;
		                  	}
		                });
		              	if(!zeroValue) {
			                $clone = $("#role-hidden-template").children().first().clone(true);
			                $clone.find("select").addClass("chosen-select");
			                $clone.appendTo(".field-role-global");
		                	$(".chosen-select").chosen();
		              	}
		            });
		            $(".field-role-global").sortable({
		                connectWith: ".connected"
		            });
		        });
		    </script>';
		  	return $global_field;
		}

		private function bd_use_role_signature_field( $all_roles, $option = FALSE, $chosen = TRUE) {
		  	$class = ($chosen)? 'chosen-select' : '';
		  	$field = '
			  	<div class="form-input-box sortable-selects" >
			    	<select name="roles[]" class="'.$class.' role-selector" data-placeholder="Select Role">
			      		<option value=""></option>
			      		';
			  			foreach ($all_roles as $role) {
						    $field .= '<option value="'.$role['id'].'" ';
						    $field .= ($option && $option == $role['id'])? ' selected="selected" ' : '';
						    $field .= '>'.$role['role'].'</option>';
			  			};
			  			$field .= '
			    	</select>
			    	<span class="icon icon-th-list"></span>
			  	</div>
			';
		  	return $field;
		}

		public function bd_use_department_sign($var, $primary_key = null) {
		  	$this->load->model('bd_use_role_model');
		  	$use_departments = $this->bd_use_role_model->getby_bd_use($primary_key);
		  	$all_departments = $this->Departments_model->getall();
		  	$global_field = '<div class="field-department-global .connected">';
		  	foreach ($use_departments as $use_department) {
		    	$global_field .= $this->bd_use_department_signature_field($all_departments, $use_department['department']);
		  	}
		  	$global_field .= $this->bd_use_department_signature_field($all_departments);
		  	$global_field .= '</div> <br />';
		  	return $global_field;
		}

		private function bd_use_department_signature_field( $all_departments, $option = FALSE, $chosen = TRUE) {
		  	$class = ($chosen)? 'chosen-select' : '';
		  	$field = '
			  	<div class="form-input-box sortable-selects" >
			    	<select name="departments[]" class="'.$class.' department-selector" data-placeholder="Select Department">
			      		<option value=""></option>
			      		';
			  			foreach ($all_departments as $department) {
						    $field .= '<option value="'.$department['id'].'" ';
						    $field .= ($option && $option == $department['id'])? ' selected="selected" ' : '';
						    $field .= '>'.$department['name'].'</option>';
			  			};
			  			$field .= '
			    	</select>
			    	<span class="icon icon-th-list"></span>
			  	</div>
			';
		  	return $field;
		}

		public function bd_use_types() {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('bd_use_types');
				$this->crud->set_subject('Type');
				$this->crud->columns('id', 'name');
				$this->crud->display_as('name','Type');
				$this->crud->display_as('id', 'ID#');
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function contract() {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('contract');
				$this->crud->set_subject('Contract');
				$this->crud->columns('id', 'user_id', 'hotel_id', 'company_id', 'service_id', 'brand', 'name', 'timestamp');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->set_relation('hotel_id', 'hotels', 'name');
				$this->crud->set_relation('company_id', 'contract_companies', 'name');
				$this->crud->set_relation('service_id', 'contract_services', 'name');
				$this->crud->set_relation_n_n('demo', 'contract_days', 'contract_weeks', 'contr_id', 'week_id', 'name');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('user_id','User');
				$this->crud->display_as('hotel_id','Hotel');
				$this->crud->display_as('company_id','Company');
				$this->crud->display_as('service_id','Service');
				$this->crud->display_as('brand','Brand');
				$this->crud->display_as('city','City');
				$this->crud->display_as('name','Name');
				$this->crud->display_as('name_old','Old Name');
				$this->crud->display_as('name_en','Name In English');
				$this->crud->display_as('name_en_old','Old Name In English');
				$this->crud->display_as('address','Address');
				$this->crud->display_as('address_old','Old Address');
				$this->crud->display_as('taxes','Taxes Number');
				$this->crud->display_as('taxes_old','Old Taxes Number');
				$this->crud->display_as('idp','ID Number');
				$this->crud->display_as('idp_old','Old ID Number');
				$this->crud->display_as('licenss','Licenss Number');
				$this->crud->display_as('licenss_old','Old Licenss Number');
				$this->crud->display_as('start_date','Start Date');
				$this->crud->display_as('start_date_old','Old Start Date');
				$this->crud->display_as('from_date','From Date');
				$this->crud->display_as('from_date_old','Old From Date');
				$this->crud->display_as('to_date','To Date');
				$this->crud->display_as('to_date_old','Old To Date');
				$this->crud->display_as('taxes_per','Taxes Percentage');
				$this->crud->display_as('taxes_per_old','Old Taxes Percentage');
				$this->crud->display_as('rent','Rent');
				$this->crud->display_as('rent_old','Old Rent');
				$this->crud->display_as('currency','Currency');
				$this->crud->display_as('currency_old','Old Currency');
				$this->crud->display_as('rent_mp','MP Rent');
				$this->crud->display_as('rent_mp_old','OLD MP Rent');
				$this->crud->display_as('currency_mp','MP Currency');
				$this->crud->display_as('currency_mp_old','Old MP Currency');
				$this->crud->display_as('rent_gb','GB Rent');
				$this->crud->display_as('rent_gb_old','OLD GB Rent');
				$this->crud->display_as('currency_gb','GB Currency');
				$this->crud->display_as('currency_gb_old','Old GB Currency');
				$this->crud->display_as('safty','Safty');
				$this->crud->display_as('safty_old','Old Safty');
				$this->crud->display_as('currency1','Safty Currency');
				$this->crud->display_as('currency1_old','Old Safty Currency');
				$this->crud->display_as('safty_mp','MP Safty');
				$this->crud->display_as('safty_mp_old','Old MP Safty');
				$this->crud->display_as('currency1_mp','MP Safty Currency');
				$this->crud->display_as('currency1_mp_old','Old MP Safty Currency');
				$this->crud->display_as('safty_gb','GB Safty');
				$this->crud->display_as('safty_gb_old','Old GB Safty');
				$this->crud->display_as('currency1_gb','GB Safty Currency');
				$this->crud->display_as('currency1_gb_old','Old GB Safty Currency');
				$this->crud->display_as('compensation','Compensation');
				$this->crud->display_as('compensation_old','Old Compensation');
				$this->crud->display_as('currency2','Compensation Currency');
				$this->crud->display_as('currency2_old','Old Compensation Currency');
				$this->crud->display_as('compensation_mp','MP Compensation');
				$this->crud->display_as('compensation_mp_old','Old MP Compensation');
				$this->crud->display_as('currency2_mp','MP Compensation Currency');
				$this->crud->display_as('currency2_mp_old','Old MP Compensation Currency');
				$this->crud->display_as('compensation_gb','GB Compensation');
				$this->crud->display_as('compensation_gb_old','Old GB Compensation');
				$this->crud->display_as('currency2_gb','GB Compensation Currency');
				$this->crud->display_as('currency2_gb_old','Old GB Compensation Currency');
				$this->crud->display_as('increase','Increase');
				$this->crud->display_as('elec_choice','Electricity Choice');
				$this->crud->display_as('electricity','Electricity');
				$this->crud->display_as('currency3','Electricity Currency');
				$this->crud->display_as('location','Location');
				$this->crud->display_as('activity','Activity');
				$this->crud->display_as('others','Others');
				$this->crud->display_as('others_old','Old Others');
				$this->crud->display_as('demo','Working Days');
				$this->crud->display_as('state_id','State');
				$this->crud->display_as('timestamp','Creation Date');
				$this->crud->add_action('Edit Contract Comments', '', '','ui-icon-image',array($this,'contr_comments'));
				$this->crud->add_action('Edit Contract Attachments', '', '','ui-icon-image',array($this,'contr_attachments'));
				$this->crud->add_action('Edit Contract Signatures', '', '','ui-icon-image',array($this,'contr_signatures'));
				$this->crud->add_action('Edit Contract Summary', '', '','ui-icon-image',array($this,'contr_summaries'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function contr_associates($post_array) {
			$contr_id = $this->uri->segment(3);
			$post_array['contr_id'] = $contr_id;
			return $post_array;
		}

		public function fixed_contr() {
			return '';
		}

		function contr_attachments($pk, $row) {
			return '/backend/contr_attachment/'.$pk;
		}

		public function contr_attachment($contr_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('contract_filles');
				$this->crud->set_subject('Contract Attachment');
				$this->crud->callback_field('contr_id',array($this,'fixed_contr'));
				$this->crud->set_relation('contr_id', 'contract', 'brand');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('contr_id', 'Brand');
				$this->crud->display_as('user_id','Created By');
				$this->crud->display_as('name','Name');
				$this->crud->display_as('timestamp','Creation Date');
				$this->crud->set_field_upload('name','assets/uploads/files');
				$this->crud->where('contr_id', $contr_id);
				$this->crud->callback_before_insert(array($this,'contr_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function contr_signatures($pk, $row) {
			return '/backend/contr_signature/'.$pk;
		}

		public function contr_signature($contr_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('contract_signature');
				$this->crud->set_subject('Contract Signature');
				$this->crud->callback_field('contr_id',array($this,'fixed_contr'));
				$this->crud->set_relation('contr_id', 'contract', 'brand');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->set_relation('role_id', 'roles', 'role');
				$this->crud->set_relation('department_id', 'departments', 'name');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('contr_id', 'Brand');
				$this->crud->display_as('user_id','Created By');
				$this->crud->display_as('role_id','Role');
				$this->crud->display_as('department_id','Department');
				$this->crud->display_as('rank','Rank');
				$this->crud->display_as('reject','Reject');
				$this->crud->display_as('timestamp','Creation Date');
				$this->crud->where('contr_id', $contr_id);
				$this->crud->callback_before_insert(array($this,'contr_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function contr_comments($pk, $row) {
			return '/backend/contr_comment/'.$pk;
		}

		public function contr_comment($contr_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('contract_comments');
				$this->crud->set_subject('Contract Comment');
				$this->crud->callback_field('contr_id',array($this,'fixed_contr'));
				$this->crud->set_relation('contr_id', 'contract', 'brand');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('contr_id', 'Brand');
				$this->crud->display_as('user_id','Created By');
				$this->crud->display_as('comment','Comment');
				$this->crud->display_as('created','Creation Date');
				$this->crud->add_action('Edit Contract Comment Attachments', '', '','ui-icon-image',array($this,'contr_comment_attachments'));
				$this->crud->where('contr_id', $contr_id);
				$this->crud->callback_before_insert(array($this,'contr_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function contr_comm_associates($post_array) {
			$comment_id = $this->uri->segment(3);
			$post_array['comment_id'] = $comment_id;
			return $post_array;
		}

		function contr_comment_attachments($pk, $row) {
			return '/backend/contr_comment_attachment/'.$pk;
		}

		public function contr_comment_attachment($comment_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('contract_comment_filles');
				$this->crud->set_subject('Contract Comment Attachment');
				$this->crud->callback_field('comment_id',array($this,'fixed_contr'));
				$this->crud->set_relation('comment_id', 'contract_comments', 'created');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('comment_id', 'Creation Date');
				$this->crud->display_as('user_id','Uploaded By');
				$this->crud->display_as('name','Name');
				$this->crud->display_as('timestamp','Upload Date');
				$this->crud->set_field_upload('name','assets/uploads/files');
				$this->crud->where('comment_id', $comment_id);
				$this->crud->callback_before_insert(array($this,'contr_comm_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function contr_summary_associates($post_array) {
			$new_id = $this->uri->segment(3);
			$post_array['new_id'] = $new_id;
			return $post_array;
		}

		function contr_summaries($pk, $row) {
			return '/backend/contr_summary/'.$pk;
		}

		public function contr_summary($new_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('contract_summary');
				$this->crud->set_subject('Contract Summary');
				$this->crud->callback_field('new_id',array($this,'fixed_contr'));
				$this->crud->set_relation('new_id', 'contract', 'brand');
				$this->crud->set_relation('old_id', 'contract', 'brand');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->set_relation('hotel_id', 'hotels', 'name');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('user_id','Created By');
				$this->crud->display_as('hotel_id','Hotel');
				$this->crud->display_as('old_id','Old Brand');
				$this->crud->display_as('new_id', 'New Brand');
				$this->crud->display_as('advance_old','Old Advance');
				$this->crud->display_as('advance_new', 'New Advance');
				$this->crud->display_as('comment_old','Old Comment');
				$this->crud->display_as('comment_new', 'New Comment');
				$this->crud->display_as('state_id','State');
				$this->crud->display_as('timestamp','Creation Date');
				$this->crud->add_action('Edit Contract Summary Comments', '', '','ui-icon-image',array($this,'contr_summary_comments'));
				$this->crud->add_action('Edit Contract Summary Attachments', '', '','ui-icon-image',array($this,'contr_summary_attachments'));
				$this->crud->add_action('Edit Contract Summary Signatures', '', '','ui-icon-image',array($this,'contr_summary_signatures'));
				$this->crud->where('new_id', $new_id);
				$this->crud->callback_before_insert(array($this,'contr_summary_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function contr_summaries_associates($post_array) {
			$sum_id = $this->uri->segment(3);
			$post_array['sum_id'] = $sum_id;
			return $post_array;
		}

		function contr_summary_comments($pk, $row) {
			return '/backend/contr_summary_comment/'.$pk;
		}

		public function contr_summary_comment($sum_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('contract_summary_comments');
				$this->crud->set_subject('Contract Summary Comment');
				$this->crud->callback_field('sum_id',array($this,'fixed_contr'));
				$this->crud->set_relation('sum_id', 'contract_summary', 'timestamp');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('sum_id', 'Creation Date');
				$this->crud->display_as('user_id','Commented By');
				$this->crud->display_as('comment','Comment');
				$this->crud->display_as('created','Timestamp');
				$this->crud->where('sum_id', $sum_id);
				$this->crud->callback_before_insert(array($this,'contr_summaries_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function contr_summary_attachments($pk, $row) {
			return '/backend/contr_summary_attachment/'.$pk;
		}

		public function contr_summary_attachment($sum_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('contract_summary_filles');
				$this->crud->set_subject('Contract Summary Attachment');
				$this->crud->callback_field('sum_id',array($this,'fixed_contr'));
				$this->crud->set_relation('sum_id', 'contract_summary', 'timestamp');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('sum_id', 'Creation Date');
				$this->crud->display_as('user_id','Commented By');
				$this->crud->display_as('name','Name');
				$this->crud->display_as('timestamp','Upload Date');
				$this->crud->set_field_upload('name','assets/uploads/files');
				$this->crud->where('sum_id', $sum_id);
				$this->crud->callback_before_insert(array($this,'contr_summaries_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function contr_summary_signatures($pk, $row) {
			return '/backend/contr_summary_signature/'.$pk;
		}

		public function contr_summary_signature($sum_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('contract_summary_signature');
				$this->crud->set_subject('Contract Summary Signature');
				$this->crud->callback_field('sum_id',array($this,'fixed_contr'));
				$this->crud->set_relation('sum_id', 'contract_summary', 'timestamp');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->set_relation('role_id', 'roles', 'role');
				$this->crud->set_relation('department_id', 'departments', 'name');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('sum_id', 'Creation Date');
				$this->crud->display_as('user_id','Created By');
				$this->crud->display_as('role_id','Role');
				$this->crud->display_as('department_id','Department');
				$this->crud->display_as('rank','Rank');
				$this->crud->display_as('reject','Reject');
				$this->crud->display_as('timestamp','Creation Date');
				$this->crud->where('sum_id', $sum_id);
				$this->crud->callback_before_insert(array($this,'contr_summaries_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function contract_sign() {
			try {
				$this->load->model('roles_model');
				$this->crud->set_theme('datatables');
				$this->crud->set_table('contract_type');
				$this->crud->set_subject('Contract Signatures');
				$this->crud->columns('id', 'name', 'dummy');
				$this->crud->display_as('dummy', 'Signatures');
				$this->crud->display_as('name', 'Name');
				$this->crud->display_as('id', 'ID#');
				$this->crud->callback_field('dummy',array($this,'contr_sign'));
				$this->crud->callback_before_insert(array($this,'process_for_insert_contr'));
				$this->crud->callback_after_insert(array($this,'process_extras_after_contr'));
				$this->crud->callback_before_update(array($this,'process_extras_contr'));
				$this->crud->set_soft_delete();
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function contr_sign($var, $primary_key = null) {
		  	$this->load->model('contract_role_model');
		  	$signatures = $this->contract_role_model->getby_contr($primary_key);
		  	$roles = $this->roles_model->getall();
		  	$global_field = '<div id="hidden-template">'.$this->contr_signature_field($roles, FALSE, FALSE).'</div>';
		  	$global_field .= '<div class="field-signature-global .connected">';
		  	foreach ($signatures as $signature) {
		    	$global_field .= $this->contr_signature_field($roles, $signature['role']);
		  	}
		  	$global_field .= $this->contr_signature_field($roles);
		  	$global_field .= '</div> <br />';
		  	$global_field .= '<script type="text/javascript">
		        $(function () {
		            $(".signature-selector").change(function(){
		                var zeroValue = false;
		                $(".field-signature-global .signature-selector").each(function(){
		                  	if ($(this).val() == ""){
		                    	zeroValue = true;
		                  	}
		                });
		              	if(!zeroValue) {
			                $clone = $("#hidden-template").children().first().clone(true);
			                $clone.find("select").addClass("chosen-select");
			                $clone.appendTo(".field-signature-global");
		                	$(".chosen-select").chosen();
		              	}
		            });
		            $(".field-signature-global").sortable({
		                connectWith: ".connected"
		            });
		        });
		    </script>';
		  	return $global_field;
		}

		private function contr_signature_field( $roles, $option = FALSE, $chosen = TRUE) {
		  	$class = ($chosen)? 'chosen-select' : '';
		  	$field = '
			  	<div class="form-input-box sortable-selects" >
			    	<select name="signatures[]" class="'.$class.' signature-selector" data-placeholder="Select Signature">
			      		<option value=""></option>
			      		';
			  			foreach ($roles as $role) {
						    $field .= '<option value="'.$role['id'].'" ';
						    $field .= ($option && $option == $role['id'])? ' selected="selected" ' : '';
						    $field .= '>'.$role['role'].'</option>';
			  			};
			  			$field .= '
			    	</select>
			    	<span class="icon icon-th-list"></span>
			  	</div>
			';
		  	return $field;
		}

		public function process_for_insert_contr($post_array) {
		  	unset($post_array['signatures']);
		 	return $post_array;
		}

		public function process_extras_after_contr($post_array, $primary_key) {
		  	$this->load->model('contract_role_model');
		  	$this->contract_role_model->reset_contr($primary_key);
		  	foreach ($post_array['signatures'] as $key => $signature) {
		    	if ($signature != 0) {
		      		$this->contract_role_model->add_role_contr($primary_key, $signature);
		    	}
		  	}
		}

		public function process_extras_contr($post_array, $primary_key) {
		  	$this->load->model('contract_role_model');
		  	$this->contract_role_model->reset_contr($primary_key);
		  	$rank = 1;
		  	foreach ($post_array['signatures'] as $key => $signature) {
		    	if ($signature != 0) {
		      		$this->contract_role_model->add_role_contr($primary_key, $signature, $rank);
		      		$rank++;
		    	}
		  	}
		  	unset($post_array['signatures']);
		  	return $post_array;
		}

		public function contract_summary_sign() {
			try {
				$this->load->model('roles_model');
				$this->crud->set_theme('datatables');
				$this->crud->set_table('contract_summary_type');
				$this->crud->set_subject('Contract Summary Signatures');
				$this->crud->columns('id', 'name', 'dummy');
				$this->crud->display_as('dummy', 'Signatures');
				$this->crud->display_as('name', 'Name');
				$this->crud->display_as('id', 'ID#');
				$this->crud->callback_field('dummy',array($this,'contr_summary_sign'));
				$this->crud->callback_before_insert(array($this,'process_for_insert_contr_summary'));
				$this->crud->callback_after_insert(array($this,'process_extras_after_contr_summary'));
				$this->crud->callback_before_update(array($this,'process_extras_contr_summary'));
				$this->crud->set_soft_delete();
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function contr_summary_sign($var, $primary_key = null) {
		  	$this->load->model('contract_role_model');
		  	$signatures = $this->contract_role_model->getby_contr_summary($primary_key);
		  	$roles = $this->roles_model->getall();
		  	$global_field = '<div id="hidden-template">'.$this->contr_summary_signature_field($roles, FALSE, FALSE).'</div>';
		  	$global_field .= '<div class="field-signature-global .connected">';
		  	foreach ($signatures as $signature) {
		    	$global_field .= $this->contr_summary_signature_field($roles, $signature['role']);
		  	}
		  	$global_field .= $this->contr_summary_signature_field($roles);
		  	$global_field .= '</div> <br />';
		  	$global_field .= '<script type="text/javascript">
		        $(function () {
		            $(".signature-selector").change(function(){
		                var zeroValue = false;
		                $(".field-signature-global .signature-selector").each(function(){
		                  	if ($(this).val() == ""){
		                    	zeroValue = true;
		                  	}
		                });
		              	if(!zeroValue) {
			                $clone = $("#hidden-template").children().first().clone(true);
			                $clone.find("select").addClass("chosen-select");
			                $clone.appendTo(".field-signature-global");
		                	$(".chosen-select").chosen();
		              	}
		            });
		            $(".field-signature-global").sortable({
		                connectWith: ".connected"
		            });
		        });
		    </script>';
		  	return $global_field;
		}

		private function contr_summary_signature_field( $roles, $option = FALSE, $chosen = TRUE) {
		  	$class = ($chosen)? 'chosen-select' : '';
		  	$field = '
			  	<div class="form-input-box sortable-selects" >
			    	<select name="signatures[]" class="'.$class.' signature-selector" data-placeholder="Select Signature">
			      		<option value=""></option>
			      		';
			  			foreach ($roles as $role) {
						    $field .= '<option value="'.$role['id'].'" ';
						    $field .= ($option && $option == $role['id'])? ' selected="selected" ' : '';
						    $field .= '>'.$role['role'].'</option>';
			  			};
			  			$field .= '
			    	</select>
			    	<span class="icon icon-th-list"></span>
			  	</div>
			';
		  	return $field;
		}

		public function process_for_insert_contr_summary($post_array) {
		  	unset($post_array['signatures']);
		 	return $post_array;
		}

		public function process_extras_after_contr_summary($post_array, $primary_key) {
		  	$this->load->model('contract_role_model');
		  	$this->contract_role_model->reset_contr_summary($primary_key);
		  	foreach ($post_array['signatures'] as $key => $signature) {
		    	if ($signature != 0) {
		      		$this->contract_role_model->add_role_contr_summary($primary_key, $signature);
		    	}
		  	}
		}

		public function process_extras_contr_summary($post_array, $primary_key) {
		  	$this->load->model('contract_role_model');
		  	$this->contract_role_model->reset_contr_summary($primary_key);
		  	$rank = 1;
		  	foreach ($post_array['signatures'] as $key => $signature) {
		    	if ($signature != 0) {
		      		$this->contract_role_model->add_role_contr_summary($primary_key, $signature, $rank);
		      		$rank++;
		    	}
		  	}
		  	unset($post_array['signatures']);
		  	return $post_array;
		}

		public function contract_companies() {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('contract_companies');
				$this->crud->set_subject('Contract Companies');
				$this->crud->columns('id', 'name');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('name','Company');
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function contract_services() {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('contract_services');
				$this->crud->set_subject('Contract Services');
				$this->crud->columns('id', 'name');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('name','Service');
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function contract_weeks() {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('contract_weeks');
				$this->crud->set_subject('Contract Weeks');
				$this->crud->columns('id', 'name');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('name','Week');
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function contract_log() {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('contract_log');
				$this->crud->set_subject('Contract Log');
				$this->crud->columns('id', 'user_id', 'type', 'target', 'action');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('user_id','User');
				$this->crud->display_as('type','Type');
				$this->crud->display_as('target','Target');
				$this->crud->display_as('target_id','Target ID');
				$this->crud->display_as('data','Data');
				$this->crud->display_as('action','Action');
				$this->crud->display_as('timestamp','Timestamp');
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function shop_renting() {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('shop_renting');
				$this->crud->set_subject('Shop Renting');
				$this->crud->columns('id', 'user_id', 'hotel_id', '	title', 'date', 'timestamp');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->set_relation('user_demo_id', 'users', 'fullname');
				$this->crud->set_relation('user_lawyer_id', 'users', 'fullname');
				$this->crud->set_relation('user_credit_id', 'users', 'fullname');
				$this->crud->set_relation('user_demo_change_id', 'users', 'fullname');
				$this->crud->set_relation('user_lawyer_change_id', 'users', 'fullname');
				$this->crud->set_relation('user_credit_change_id', 'users', 'fullname');
				$this->crud->set_relation('hotel_id', 'hotels', 'name');
				$this->crud->set_relation('choosen_id', 'shop_renting_offers', 'name');
				$this->crud->set_relation('change_choosen_id', 'shop_renting_offers', 'name');
				$this->crud->set_relation('state_id', 'shop_renting_states', 'name');
				$this->crud->set_relation('state_final', 'shop_renting_states', 'name');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('user_id','User');
				$this->crud->display_as('ip','IP');
				$this->crud->display_as('hotel_id','Hotel');
				$this->crud->display_as('title','Title');
				$this->crud->display_as('date','Date');
				$this->crud->display_as('recommendation','Recommendation');
				$this->crud->display_as('reason','Reason');
				$this->crud->display_as('choosen_id','Choosen Offer');
				$this->crud->display_as('credit_demo','Credit Demo');
				$this->crud->display_as('user_demo_id','Demo Uploded By');
				$this->crud->display_as('lawyer_final','Lawyer Final');
				$this->crud->display_as('user_lawyer_id','Lawyer Uploded By');
				$this->crud->display_as('credit_final','Credit Final');
				$this->crud->display_as('user_credit_id','Final Uploded By');
				$this->crud->display_as('changes','Changes');
				$this->crud->display_as('recommendation_change','Recommendation Change');
				$this->crud->display_as('reason_change','Reason Change');
				$this->crud->display_as('change_choosen_id','Choosen Offer Change');
				$this->crud->display_as('credit_demo_change','Credit Demo Change');
				$this->crud->display_as('user_demo_change_id','Demo Uploded By Change');
				$this->crud->display_as('lawyer_final_change','Lawyer Final Change');
				$this->crud->display_as('user_lawyer_change_id','Lawyer Uploded By Change');
				$this->crud->display_as('credit_final_change','Credit Final Change');
				$this->crud->display_as('user_credit_change_id','Final Uploded By Change');
				$this->crud->display_as('state_id','State');
				$this->crud->display_as('state_final','Final State');
				$this->crud->display_as('timestamp','Creation Date');
				$this->crud->set_field_upload('credit_demo','assets/uploads/files');
				$this->crud->set_field_upload('lawyer_final','assets/uploads/files');
				$this->crud->set_field_upload('credit_final','assets/uploads/files');
				$this->crud->set_field_upload('credit_demo_change','assets/uploads/files');
				$this->crud->set_field_upload('lawyer_final_change','assets/uploads/files');
				$this->crud->set_field_upload('credit_final_change','assets/uploads/files');
				$this->crud->add_action('Edit Shop Renting Comments', '', '','ui-icon-image',array($this,'shop_comments'));
				$this->crud->add_action('Edit Shop Renting Attachments', '', '','ui-icon-image',array($this,'shop_attachments'));
				$this->crud->add_action('Edit Shop Renting Signatures', '', '','ui-icon-image',array($this,'shop_signatures'));
				$this->crud->add_action('Edit Shop Renting Change Signatures', '', '','ui-icon-image',array($this,'shop_change_signatures'));
				$this->crud->add_action('Edit Shop Renting Offers', '', '','ui-icon-image',array($this,'shop_offers'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function shop_associates($post_array) {
			$shop_id = $this->uri->segment(3);
			$post_array['shop_id'] = $shop_id;
			return $post_array;
		}

		public function fixed_shop() {
			return '';
		}

		function shop_comments($pk, $row) {
			return '/backend/shop_comment/'.$pk;
		}

		public function shop_comment($shop_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('shop_renting_comments');
				$this->crud->set_subject('Shop Renting Comment');
				$this->crud->callback_field('shop_id',array($this,'fixed_shop'));
				$this->crud->set_relation('shop_id', 'shop_renting', 'title');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('shop_id', 'Title');
				$this->crud->display_as('user_id','Commented By');
				$this->crud->display_as('comment','Comment');
				$this->crud->display_as('timestamp','Creation Date');
				$this->crud->where('shop_id', $shop_id);
				$this->crud->callback_before_insert(array($this,'shop_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function shop_attachments($pk, $row) {
			return '/backend/shop_attachment/'.$pk;
		}

		public function shop_attachment($shop_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('shop_renting_filles');
				$this->crud->set_subject('Shop Renting Attachment');
				$this->crud->callback_field('shop_id',array($this,'fixed_shop'));
				$this->crud->set_relation('shop_id', 'shop_renting', 'title');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('shop_id', 'Title');
				$this->crud->display_as('user_id','Uploaded By');
				$this->crud->display_as('name','Name');
				$this->crud->display_as('timestamp','Creation Date');
				$this->crud->set_field_upload('name','assets/uploads/files');
				$this->crud->where('shop_id', $shop_id);
				$this->crud->callback_before_insert(array($this,'shop_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function shop_signatures($pk, $row) {
			return '/backend/shop_signature/'.$pk;
		}

		public function shop_signature($shop_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('shop_renting_signature');
				$this->crud->set_subject('Shop Renting Signature');
				$this->crud->callback_field('shop_id',array($this,'fixed_shop'));
				$this->crud->set_relation('shop_id', 'shop_renting', 'title');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->set_relation('role_id', 'roles', 'role');
				$this->crud->set_relation('department_id', 'departments', 'name');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('shop_id', 'Title');
				$this->crud->display_as('user_id','Created By');
				$this->crud->display_as('role_id','Role');
				$this->crud->display_as('department_id','Department');
				$this->crud->display_as('rank','Rank');
				$this->crud->display_as('reject','Reject');
				$this->crud->display_as('timestamp','Creation Date');
				$this->crud->where('shop_id', $shop_id);
				$this->crud->callback_before_insert(array($this,'shop_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function shop_change_signatures($pk, $row) {
			return '/backend/shop_change_signature/'.$pk;
		}

		public function shop_change_signature($shop_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('shop_renting_change_signature');
				$this->crud->set_subject('Shop Renting Change Signature');
				$this->crud->callback_field('shop_id',array($this,'fixed_shop'));
				$this->crud->set_relation('shop_id', 'shop_renting', 'title');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->set_relation('role_id', 'roles', 'role');
				$this->crud->set_relation('department_id', 'departments', 'name');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('shop_id', 'Title');
				$this->crud->display_as('user_id','Created By');
				$this->crud->display_as('role_id','Role');
				$this->crud->display_as('department_id','Department');
				$this->crud->display_as('rank','Rank');
				$this->crud->display_as('reject','Reject');
				$this->crud->display_as('timestamp','Creation Date');
				$this->crud->where('shop_id', $shop_id);
				$this->crud->callback_before_insert(array($this,'shop_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function shop_offers($pk, $row) {
			return '/backend/shop_offer/'.$pk;
		}

		public function shop_offer($shop_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('shop_renting_offers');
				$this->crud->set_subject('Shop Renting Offer');
				$this->crud->callback_field('shop_id',array($this,'fixed_shop'));
				$this->crud->set_relation('shop_id', 'shop_renting', 'title');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->set_relation('currency_id', 'currency', 'name');
				$this->crud->set_relation('currency1_id', 'currency', 'name');
				$this->crud->set_relation('currency2_id', 'currency', 'name');
				$this->crud->set_relation('type_id', 'shop_renting_types', 'name');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('shop_id', 'Title');
				$this->crud->display_as('user_id','Created By');
				$this->crud->display_as('ip','IP');
				$this->crud->display_as('name','Name');
				$this->crud->display_as('start_from', 'Start From');
				$this->crud->display_as('end_at','End At');
				$this->crud->display_as('rent', 'Rent');
				$this->crud->display_as('currency_id','Rent Currency');
				$this->crud->display_as('taxes', 'Taxes');
				$this->crud->display_as('other', 'Other');
				$this->crud->display_as('advance', 'Advance');
				$this->crud->display_as('currency1_id','Advance Currency');
				$this->crud->display_as('deposite', 'Deposite');
				$this->crud->display_as('currency2_id','Deposite Currency');
				$this->crud->display_as('location', 'Location');
				$this->crud->display_as('reference', 'Reference');
				$this->crud->display_as('by_reference', 'Reference By');
				$this->crud->display_as('who_reference', 'Who Reference?');
				$this->crud->display_as('design', 'Design');
				$this->crud->display_as('offer', 'Offer');
				$this->crud->display_as('cv','CV');
				$this->crud->display_as('contract','Contract');
				$this->crud->display_as('type_id','Type');
				$this->crud->display_as('changed','Changed');
				$this->crud->display_as('timestamp','Creation Date');
				$this->crud->set_field_upload('design','assets/uploads/files');
				$this->crud->set_field_upload('offer','assets/uploads/files');
				$this->crud->set_field_upload('cv','assets/uploads/files');
				$this->crud->set_field_upload('contract','assets/uploads/files');
				$this->crud->where('shop_id', $shop_id);
				$this->crud->callback_before_insert(array($this,'shop_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function shop_renting_sign() {
			try {
				$this->load->model('roles_model');
				$this->crud->set_theme('datatables');
				$this->crud->set_table('shop_renting_type');
				$this->crud->set_subject('Shop Renting Signatures');
				$this->crud->columns('id', 'name', 'dummy', 'dummy1');
				$this->crud->display_as('dummy', 'Role Signatures');
				$this->crud->display_as('dummy1', 'Final Role Signatures');
				$this->crud->display_as('name', 'Name');
				$this->crud->display_as('id', 'ID#');
				$this->crud->callback_field('dummy',array($this,'shop_role_sign'));
				$this->crud->callback_field('dummy1',array($this,'shop_final_sign'));
				$this->crud->callback_before_insert(array($this,'process_for_insert_shop'));
				$this->crud->callback_after_insert(array($this,'process_extras_after_shop'));
				$this->crud->callback_before_update(array($this,'process_extras_shop'));
				$this->crud->set_soft_delete();
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function process_for_insert_shop($post_array) {
		  	unset($post_array['roles']);
		  	unset($post_array['finals']);
		 	return $post_array;
		}

		public function process_extras_after_shop($post_array, $primary_key) {
		  	$this->load->model('shop_renting_role_model');
		  	$this->shop_renting_role_model->reset_shop($primary_key);
		  	$this->shop_renting_role_model->reset_final_shop($primary_key);
		  	$rank = 1;
		  	$resulte =  array();
		  	foreach ($post_array['roles'] as $key => $role) {
		    	if ($role != 0) {
		      		$sign_id = $this->shop_renting_role_model->add_role_shop($primary_key, $role, $rank);
		      		$resulte[] = $sign_id;
		      		$rank++;
		    	}
		  	}
		  	foreach ($post_array['finals'] as $key => $final) {
		    	if ($final != 0) {
		      		$sign_id = $this->shop_renting_role_model->add_role_final_shop($primary_key, $final, $rank);
		      		$resulte[] = $sign_id;
		      		$rank++;
		    	}
		  	}
		}

		public function process_extras_shop($post_array, $primary_key) {
		  	$this->load->model('shop_renting_role_model');
		  	$this->shop_renting_role_model->reset_shop($primary_key);
		  	$this->shop_renting_role_model->reset_final_shop($primary_key);
		  	$rank = 1;
		  	$resulte =  array();
		  	foreach ($post_array['roles'] as $key => $role) {
		    	if ($role != 0) {
		      		$sign_id = $this->shop_renting_role_model->add_role_shop($primary_key, $role, $rank);
		      		$resulte[] = $sign_id;
		      		$rank++;
		    	}
		  	}
		  	foreach ($post_array['finals'] as $key => $final) {
		    	if ($final != 0) {
		      		$sign_id = $this->shop_renting_role_model->add_role_final_shop($primary_key, $final, $rank);
		      		$resulte[] = $sign_id;
		      		$rank++;
		    	}
		  	}
		  	unset($post_array['roles']);
		  	unset($post_array['finals']);
		  	return $post_array;
		}

		public function shop_role_sign($var, $primary_key = null) {
		  	$this->load->model('shop_renting_role_model');
		  	$shop_roles = $this->shop_renting_role_model->getby_shop($primary_key);
		  	$all_roles = $this->roles_model->getall();
		  	$global_field = '<div id="role-hidden-template" style="display:none">'.$this->shop_role_signature_field($all_roles, FALSE, FALSE).'</div>';
		  	$global_field .= '<div class="field-role-global .connected">';
		  	foreach ($shop_roles as $shop_role) {
		    	$global_field .= $this->shop_role_signature_field($all_roles, $shop_role['role']);
		  	}
		  	$global_field .= $this->shop_role_signature_field($all_roles);
		  	$global_field .= '</div> <br />';
		  	$global_field .= '<script type="text/javascript">
		        $(function () {
		            $(".role-selector").change(function(){
		                var zeroValue = false;
		                $(".field-role-global .role-selector").each(function(){
		                  	if ($(this).val() == ""){
		                    	zeroValue = true;
		                  	}
		                });
		              	if(!zeroValue) {
			                $clone = $("#role-hidden-template").children().first().clone(true);
			                $clone.find("select").addClass("chosen-select");
			                $clone.appendTo(".field-role-global");
		                	$(".chosen-select").chosen();
		              	}
		            });
		            $(".field-role-global").sortable({
		                connectWith: ".connected"
		            });
		        });
		    </script>';
		  	return $global_field;
		}

		private function shop_role_signature_field( $all_roles, $option = FALSE, $chosen = TRUE) {
		  	$class = ($chosen)? 'chosen-select' : '';
		  	$field = '
			  	<div class="form-input-box sortable-selects" >
			    	<select name="roles[]" class="'.$class.' role-selector" data-placeholder="Select Role">
			      		<option value=""></option>
			      		';
			  			foreach ($all_roles as $role) {
						    $field .= '<option value="'.$role['id'].'" ';
						    $field .= ($option && $option == $role['id'])? ' selected="selected" ' : '';
						    $field .= '>'.$role['role'].'</option>';
			  			};
			  			$field .= '
			    	</select>
			    	<span class="icon icon-th-list"></span>
			  	</div>
			';
		  	return $field;
		}

		public function shop_final_sign($var, $primary_key = null) {
		  	$this->load->model('shop_renting_role_model');
		  	$final_roles = $this->shop_renting_role_model->getby_final_shop($primary_key);
		  	$all_roles = $this->roles_model->getall();
		  	$global_field = '<div class="field-final-global .connected">';
		  	foreach ($final_roles as $final_role) {
		    	$global_field .= $this->shop_final_role_signature_field($all_roles, $final_role['role']);
		  	}
		  	$global_field .= $this->shop_final_role_signature_field($all_roles);
		  	$global_field .= '</div> <br />';
		  	return $global_field;
		}

		private function shop_final_role_signature_field( $all_roles, $option = FALSE, $chosen = TRUE) {
		  	$class = ($chosen)? 'chosen-select' : '';
		  	$field = '
			  	<div class="form-input-box sortable-selects" >
			    	<select name="finals[]" class="'.$class.' final-selector" data-placeholder="Select Role">
			      		<option value=""></option>
			      		';
			  			foreach ($all_roles as $role) {
						    $field .= '<option value="'.$role['id'].'" ';
						    $field .= ($option && $option == $role['id'])? ' selected="selected" ' : '';
						    $field .= '>'.$role['role'].'</option>';
			  			};
			  			$field .= '
			    	</select>
			    	<span class="icon icon-th-list"></span>
			  	</div>
			';
		  	return $field;
		}


		public function shop_renting_states() {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('shop_renting_states');
				$this->crud->set_subject('Shop Renting State');
				$this->crud->columns('id', 'name');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('name','State');
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function shop_renting_types() {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('shop_renting_types');
				$this->crud->set_subject('Shop Renting Offfer Type');
				$this->crud->columns('id', 'name');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('name','Type');
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function currency() {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('currency');
				$this->crud->set_subject('Currency');
				$this->crud->columns('id', 'name');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('name','currency');
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function out_go() {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('out_go');
				$this->crud->set_subject('Out Going');
				$this->crud->columns('id', 'user_id', 'hotel_id', '	department_id', 'out_with', 'timestamp');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->set_relation('hotel_id', 'hotels', 'name');
				$this->crud->set_relation('department_id', 'departments', 'name');
				$this->crud->set_relation_n_n('demo', 'out_go_reason', 'out_go_reasons', 'out_id', 'reason_id', 'name');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('user_id','User');
				$this->crud->display_as('hotel_id','Hotel');
				$this->crud->display_as('department_id','Department');
				$this->crud->display_as('date','Date');
				$this->crud->display_as('re_date','Return Date');
				$this->crud->display_as('address','Address');
				$this->crud->display_as('demo','Reasons');
				$this->crud->display_as('out_with','Out With');
				$this->crud->display_as('state_id','State');
				$this->crud->display_as('timestamp','Creation Date');
				$this->crud->add_action('Edit Out Going Comments', '', '','ui-icon-image',array($this,'out_comments'));
				$this->crud->add_action('Edit Out Going Attachments', '', '','ui-icon-image',array($this,'out_attachments'));
				$this->crud->add_action('Edit Out Going Signatures', '', '','ui-icon-image',array($this,'out_signatures'));
				$this->crud->add_action('Edit Out Going Items', '', '','ui-icon-image',array($this,'out_items'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function out_associates($post_array) {
			$out_id = $this->uri->segment(3);
			$post_array['out_id'] = $out_id;
			return $post_array;
		}

		public function fixed_out() {
			return '';
		}

		function out_comments($pk, $row) {
			return '/backend/out_comment/'.$pk;
		}

		public function out_comment($out_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('out_go_comments');
				$this->crud->set_subject('Out Going Comment');
				$this->crud->callback_field('out_id',array($this,'fixed_out'));
				$this->crud->set_relation('out_id', 'out_go', 'out_with');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('out_id', 'Out With');
				$this->crud->display_as('user_id','Commented By');
				$this->crud->display_as('comment','Comment');
				$this->crud->display_as('timestamp','Creation Date');
				$this->crud->where('out_id', $out_id);
				$this->crud->callback_before_insert(array($this,'out_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function out_attachments($pk, $row) {
			return '/backend/out_attachment/'.$pk;
		}

		public function out_attachment($out_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('out_go_filles');
				$this->crud->set_subject('Out Going Attachment');
				$this->crud->callback_field('out_id',array($this,'fixed_out'));
				$this->crud->set_relation('out_id', 'out_go', 'out_with');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('out_id', 'Out With');
				$this->crud->display_as('user_id','Uploaded By');
				$this->crud->display_as('name','Name');
				$this->crud->display_as('timestamp','Creation Date');
				$this->crud->set_field_upload('name','assets/uploads/files');
				$this->crud->where('out_id', $out_id);
				$this->crud->callback_before_insert(array($this,'out_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function out_signatures($pk, $row) {
			return '/backend/out_signature/'.$pk;
		}

		public function out_signature($out_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('out_go_signature');
				$this->crud->set_subject('Out Going Signature');
				$this->crud->callback_field('out_id',array($this,'fixed_out'));
				$this->crud->set_relation('out_id', 'out_go', 'out_with');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->set_relation('role_id', 'roles', 'role');
				$this->crud->set_relation('department_id', 'departments', 'name');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('out_id', 'Out With');
				$this->crud->display_as('user_id','Created By');
				$this->crud->display_as('role_id','Role');
				$this->crud->display_as('department_id','Department');
				$this->crud->display_as('rank','Rank');
				$this->crud->display_as('reject','Reject');
				$this->crud->display_as('timestamp','Creation Date');
				$this->crud->where('out_id', $out_id);
				$this->crud->callback_before_insert(array($this,'out_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function out_items($pk, $row) {
			return '/backend/out_item/'.$pk;
		}

		public function out_item($out_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('out_go_items');
				$this->crud->set_subject('Out Going Item');
				$this->crud->callback_field('out_id',array($this,'fixed_out'));
				$this->crud->set_relation('out_id', 'out_go', 'out_with');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->set_relation('user_del_id', 'users', 'fullname');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('out_id', 'Out With');
				$this->crud->display_as('user_id','Created By');
				$this->crud->display_as('user_del_id','Deliverd By');
				$this->crud->display_as('quantity','Quantity');
				$this->crud->display_as('description', 'Description');
				$this->crud->display_as('remarks','Remarks');
				$this->crud->display_as('fille','Fille');
				$this->crud->display_as('report','Report');
				$this->crud->display_as('delivered', 'Delivered');
				$this->crud->display_as('del_date', 'Delivery Date');
				$this->crud->display_as('del_state_id', 'Delivery State');
				$this->crud->display_as('timestamp','Timestamp');
				$this->crud->set_field_upload('fille','assets/uploads/files');
				$this->crud->add_action('Edit Out Going Delivery Signatures', '', '','ui-icon-image',array($this,'out_delivery_signatures'));
				$this->crud->where('out_id', $out_id);
				$this->crud->callback_before_insert(array($this,'out_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function out_del_associates($post_array) {
			$del_id = $this->uri->segment(3);
			$post_array['del_id'] = $del_id;
			return $post_array;
		}

		function out_delivery_signatures($pk, $row) {
			return '/backend/out_delivery_signature/'.$pk;
		}

		public function out_delivery_signature($del_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('out_del_go_signature');
				$this->crud->set_subject('Out Going Delivery Signature');
				$this->crud->callback_field('del_id',array($this,'fixed_out'));
				$this->crud->set_relation('del_id', 'out_go_items', 'description');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->set_relation('role_id', 'roles', 'role');
				$this->crud->set_relation('department_id', 'departments', 'name');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('del_id', 'Description');
				$this->crud->display_as('user_id','Created By');
				$this->crud->display_as('role_id','Role');
				$this->crud->display_as('department_id','Department');
				$this->crud->display_as('rank','Rank');
				$this->crud->display_as('reject','Reject');
				$this->crud->display_as('timestamp','Creation Date');
				$this->crud->where('del_id', $del_id);
				$this->crud->callback_before_insert(array($this,'out_del_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function out_go_sign() {
			try {
				$this->load->model('roles_model');
				$this->load->model('Departments_model');
				$this->crud->set_theme('datatables');
				$this->crud->set_table('out_go_type');
				$this->crud->set_subject('Out Going Signatures');
				$this->crud->columns('id', 'name', 'dummy', 'dummy1');
				$this->crud->display_as('dummy', 'Role Signatures');
				$this->crud->display_as('dummy1', 'Department Signatures');
				$this->crud->display_as('name', 'Name');
				$this->crud->display_as('id', 'ID#');
				$this->crud->callback_field('dummy',array($this,'out_go_role_sign'));
				$this->crud->callback_field('dummy1',array($this,'out_go_department_sign'));
				$this->crud->callback_before_insert(array($this,'process_for_insert_out_go'));
				$this->crud->callback_after_insert(array($this,'process_extras_after_out_go'));
				$this->crud->callback_before_update(array($this,'process_extras_out_go'));
				$this->crud->set_soft_delete();
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function process_for_insert_out_go($post_array) {
		  	unset($post_array['roles']);
		  	unset($post_array['departments']);
		 	return $post_array;
		}

		public function process_extras_after_out_go($post_array, $primary_key) {
		  	$this->load->model('out_go_role_model');
		  	$this->out_go_role_model->reset_out_go($primary_key);
		  	$rank = 1;
		  	$resulte =  array();
		  	foreach ($post_array['roles'] as $key => $role) {
		    	if ($role != 0) {
		      		$sign_id = $this->out_go_role_model->add_role_out_go($primary_key, $role, $rank);
		      		$resulte[] = $sign_id;
		      		$rank++;
		    	}
		  	}
		  	foreach ($post_array['departments'] as $key => $department) {
		    	if ($department != 0) {
		      		$this->out_go_role_model->add_department_out_go($primary_key, $department, $resulte[$key]);
		    	}
		  	}
		}

		public function process_extras_out_go($post_array, $primary_key) {
		  	$this->load->model('out_go_role_model');
		  	$this->out_go_role_model->reset_out_go($primary_key);
		  	$rank = 1;
		  	$resulte =  array();
		  	foreach ($post_array['roles'] as $key => $role) {
		    	if ($role != 0) {
		      		$sign_id = $this->out_go_role_model->add_role_out_go($primary_key, $role, $rank);
		      		$resulte[] = $sign_id;
		      		$rank++;
		    	}
		  	}
		  	foreach ($post_array['departments'] as $key => $department) {
		    	if ($department != 0) {
		      		$this->out_go_role_model->add_department_out_go($primary_key, $department, $resulte[$key]);
		    	}
		  	}
		  	unset($post_array['roles']);
		  	unset($post_array['departments']);
		  	return $post_array;
		}

		public function out_go_role_sign($var, $primary_key = null) {
		  	$this->load->model('out_go_role_model');
		  	$out_roles = $this->out_go_role_model->getby_out_go($primary_key);
		  	$all_roles = $this->roles_model->getall();
		  	$global_field = '<div id="role-hidden-template" style="display:none">'.$this->out_go_role_signature_field($all_roles, FALSE, FALSE).'</div>';
		  	$global_field .= '<div class="field-role-global .connected">';
		  	foreach ($out_roles as $out_role) {
		    	$global_field .= $this->out_go_role_signature_field($all_roles, $out_role['role']);
		  	}
		  	$global_field .= $this->out_go_role_signature_field($all_roles);
		  	$global_field .= '</div> <br />';
		  	$global_field .= '<script type="text/javascript">
		        $(function () {
		            $(".role-selector").change(function(){
		                var zeroValue = false;
		                $(".field-role-global .role-selector").each(function(){
		                  	if ($(this).val() == ""){
		                    	zeroValue = true;
		                  	}
		                });
		              	if(!zeroValue) {
			                $clone = $("#role-hidden-template").children().first().clone(true);
			                $clone.find("select").addClass("chosen-select");
			                $clone.appendTo(".field-role-global");
		                	$(".chosen-select").chosen();
		              	}
		            });
		            $(".field-role-global").sortable({
		                connectWith: ".connected"
		            });
		        });
		    </script>';
		  	return $global_field;
		}

		private function out_go_role_signature_field( $all_roles, $option = FALSE, $chosen = TRUE) {
		  	$class = ($chosen)? 'chosen-select' : '';
		  	$field = '
			  	<div class="form-input-box sortable-selects" >
			    	<select name="roles[]" class="'.$class.' role-selector" data-placeholder="Select Role">
			      		<option value=""></option>
			      		';
			  			foreach ($all_roles as $role) {
						    $field .= '<option value="'.$role['id'].'" ';
						    $field .= ($option && $option == $role['id'])? ' selected="selected" ' : '';
						    $field .= '>'.$role['role'].'</option>';
			  			};
			  			$field .= '
			    	</select>
			    	<span class="icon icon-th-list"></span>
			  	</div>
			';
		  	return $field;
		}

		public function out_go_department_sign($var, $primary_key = null) {
		  	$this->load->model('bd_use_role_model');
		  	$out_departments = $this->out_go_role_model->getby_out_go($primary_key);
		  	$all_departments = $this->Departments_model->getall();
		  	$global_field = '<div class="field-department-global .connected">';
		  	foreach ($out_departments as $out_department) {
		    	$global_field .= $this->out_go_department_signature_field($all_departments, $out_department['department']);
		  	}
		  	$global_field .= $this->out_go_department_signature_field($all_departments);
		  	$global_field .= '</div> <br />';
		  	return $global_field;
		}

		private function out_go_department_signature_field( $all_departments, $option = FALSE, $chosen = TRUE) {
		  	$class = ($chosen)? 'chosen-select' : '';
		  	$field = '
			  	<div class="form-input-box sortable-selects" >
			    	<select name="departments[]" class="'.$class.' department-selector" data-placeholder="Select Department">
			      		<option value=""></option>
			      		';
			  			foreach ($all_departments as $department) {
						    $field .= '<option value="'.$department['id'].'" ';
						    $field .= ($option && $option == $department['id'])? ' selected="selected" ' : '';
						    $field .= '>'.$department['name'].'</option>';
			  			};
			  			$field .= '
			    	</select>
			    	<span class="icon icon-th-list"></span>
			  	</div>
			';
		  	return $field;
		}

		public function out_del_sign() {
			try {
				$this->load->model('roles_model');
				$this->load->model('Departments_model');
				$this->crud->set_theme('datatables');
				$this->crud->set_table('out_del_go_type');
				$this->crud->set_subject('Out Going DElivery Signatures');
				$this->crud->columns('id', 'name', 'dummy', 'dummy1');
				$this->crud->display_as('dummy', 'Role Signatures');
				$this->crud->display_as('dummy1', 'Department Signatures');
				$this->crud->display_as('name', 'Name');
				$this->crud->display_as('id', 'ID#');
				$this->crud->callback_field('dummy',array($this,'out_del_role_sign'));
				$this->crud->callback_field('dummy1',array($this,'out_del_department_sign'));
				$this->crud->callback_before_insert(array($this,'process_for_insert_out_del'));
				$this->crud->callback_after_insert(array($this,'process_extras_after_out_del'));
				$this->crud->callback_before_update(array($this,'process_extras_out_del'));
				$this->crud->set_soft_delete();
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function process_for_insert_out_del($post_array) {
		  	unset($post_array['roles']);
		  	unset($post_array['departments']);
		 	return $post_array;
		}

		public function process_extras_after_out_del($post_array, $primary_key) {
		  	$this->load->model('out_go_role_model');
		  	$this->out_go_role_model->reset_out_del($primary_key);
		  	$rank = 1;
		  	$resulte =  array();
		  	foreach ($post_array['roles'] as $key => $role) {
		    	if ($role != 0) {
		      		$sign_id = $this->out_go_role_model->add_role_out_del($primary_key, $role, $rank);
		      		$resulte[] = $sign_id;
		      		$rank++;
		    	}
		  	}
		  	foreach ($post_array['departments'] as $key => $department) {
		    	if ($department != 0) {
		      		$this->out_go_role_model->add_department_out_del($primary_key, $department, $resulte[$key]);
		    	}
		  	}
		}

		public function process_extras_out_del($post_array, $primary_key) {
		  	$this->load->model('out_go_role_model');
		  	$this->out_go_role_model->reset_out_del($primary_key);
		  	$rank = 1;
		  	$resulte =  array();
		  	foreach ($post_array['roles'] as $key => $role) {
		    	if ($role != 0) {
		      		$sign_id = $this->out_go_role_model->add_role_out_del($primary_key, $role, $rank);
		      		$resulte[] = $sign_id;
		      		$rank++;
		    	}
		  	}
		  	foreach ($post_array['departments'] as $key => $department) {
		    	if ($department != 0) {
		      		$this->out_go_role_model->add_department_out_del($primary_key, $department, $resulte[$key]);
		    	}
		  	}
		  	unset($post_array['roles']);
		  	unset($post_array['departments']);
		  	return $post_array;
		}

		public function out_del_role_sign($var, $primary_key = null) {
		  	$this->load->model('out_go_role_model');
		  	$out_roles = $this->out_go_role_model->getby_out_del($primary_key);
		  	$all_roles = $this->roles_model->getall();
		  	$global_field = '<div id="role-hidden-template" style="display:none">'.$this->out_del_role_signature_field($all_roles, FALSE, FALSE).'</div>';
		  	$global_field .= '<div class="field-role-global .connected">';
		  	foreach ($out_roles as $out_role) {
		    	$global_field .= $this->out_del_role_signature_field($all_roles, $out_role['role']);
		  	}
		  	$global_field .= $this->out_del_role_signature_field($all_roles);
		  	$global_field .= '</div> <br />';
		  	$global_field .= '<script type="text/javascript">
		        $(function () {
		            $(".role-selector").change(function(){
		                var zeroValue = false;
		                $(".field-role-global .role-selector").each(function(){
		                  	if ($(this).val() == ""){
		                    	zeroValue = true;
		                  	}
		                });
		              	if(!zeroValue) {
			                $clone = $("#role-hidden-template").children().first().clone(true);
			                $clone.find("select").addClass("chosen-select");
			                $clone.appendTo(".field-role-global");
		                	$(".chosen-select").chosen();
		              	}
		            });
		            $(".field-role-global").sortable({
		                connectWith: ".connected"
		            });
		        });
		    </script>';
		  	return $global_field;
		}

		private function out_del_role_signature_field( $all_roles, $option = FALSE, $chosen = TRUE) {
		  	$class = ($chosen)? 'chosen-select' : '';
		  	$field = '
			  	<div class="form-input-box sortable-selects" >
			    	<select name="roles[]" class="'.$class.' role-selector" data-placeholder="Select Role">
			      		<option value=""></option>
			      		';
			  			foreach ($all_roles as $role) {
						    $field .= '<option value="'.$role['id'].'" ';
						    $field .= ($option && $option == $role['id'])? ' selected="selected" ' : '';
						    $field .= '>'.$role['role'].'</option>';
			  			};
			  			$field .= '
			    	</select>
			    	<span class="icon icon-th-list"></span>
			  	</div>
			';
		  	return $field;
		}

		public function out_del_department_sign($var, $primary_key = null) {
		  	$this->load->model('bd_use_role_model');
		  	$out_departments = $this->out_go_role_model->getby_out_del($primary_key);
		  	$all_departments = $this->Departments_model->getall();
		  	$global_field = '<div class="field-department-global .connected">';
		  	foreach ($out_departments as $out_department) {
		    	$global_field .= $this->out_del_department_signature_field($all_departments, $out_department['department']);
		  	}
		  	$global_field .= $this->out_del_department_signature_field($all_departments);
		  	$global_field .= '</div> <br />';
		  	return $global_field;
		}

		private function out_del_department_signature_field( $all_departments, $option = FALSE, $chosen = TRUE) {
		  	$class = ($chosen)? 'chosen-select' : '';
		  	$field = '
			  	<div class="form-input-box sortable-selects" >
			    	<select name="departments[]" class="'.$class.' department-selector" data-placeholder="Select Department">
			      		<option value=""></option>
			      		';
			  			foreach ($all_departments as $department) {
						    $field .= '<option value="'.$department['id'].'" ';
						    $field .= ($option && $option == $department['id'])? ' selected="selected" ' : '';
						    $field .= '>'.$department['name'].'</option>';
			  			};
			  			$field .= '
			    	</select>
			    	<span class="icon icon-th-list"></span>
			  	</div>
			';
		  	return $field;
		}

		public function out_go_reasons() {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('out_go_reasons');
				$this->crud->set_subject('Out Gonig Reason');
				$this->crud->columns('id', 'name');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('name','Reason');
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function gate() {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('gate');
				$this->crud->set_subject('Gate Pass');
				$this->crud->columns('id', 'user_id', 'hotel_id', '	department_id', 'out_with', 'timestamp');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->set_relation('hotel_id', 'hotels', 'name');
				$this->crud->set_relation('department_id', 'departments', 'name');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('ip','IP');
				$this->crud->display_as('user_id','User');
				$this->crud->display_as('hotel_id','Hotel');
				$this->crud->display_as('date','Date');
				$this->crud->display_as('name','Name');
				$this->crud->display_as('position','Position');
				$this->crud->display_as('department_id','Department');
				$this->crud->display_as('reason','Reason');
				$this->crud->display_as('out_with','Out With');
				$this->crud->display_as('state_id','State');
				$this->crud->display_as('timestamp','Creation Date');
				$this->crud->add_action('Edit Gate Pass Comments', '', '','ui-icon-image',array($this,'gate_comments'));
				$this->crud->add_action('Edit Gate Pass Attachments', '', '','ui-icon-image',array($this,'gate_attachments'));
				$this->crud->add_action('Edit Gate Pass Signatures', '', '','ui-icon-image',array($this,'gate_signatures'));
				$this->crud->add_action('Edit Gate Pass Items', '', '','ui-icon-image',array($this,'gate_items'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function gate_associates($post_array) {
			$gate_id = $this->uri->segment(3);
			$post_array['gate_id'] = $gate_id;
			return $post_array;
		}

		public function fixed_gate() {
			return '';
		}

		function gate_comments($pk, $row) {
			return '/backend/gate_comment/'.$pk;
		}

		public function gate_comment($gate_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('gate_comments');
				$this->crud->set_subject('Gate Pass Comment');
				$this->crud->callback_field('gate_id',array($this,'fixed_gate'));
				$this->crud->set_relation('gate_id', 'gate', 'out_with');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('gate_id', 'Out With');
				$this->crud->display_as('user_id','Commented By');
				$this->crud->display_as('comment','Comment');
				$this->crud->display_as('timestamp','Creation Date');
				$this->crud->where('gate_id', $gate_id);
				$this->crud->callback_before_insert(array($this,'gate_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function gate_attachments($pk, $row) {
			return '/backend/gate_attachment/'.$pk;
		}

		public function gate_attachment($gate_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('gate_filles');
				$this->crud->set_subject('Gate Pass Attachment');
				$this->crud->callback_field('gate_id',array($this,'fixed_gate'));
				$this->crud->set_relation('gate_id', 'gate', 'out_with');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('gate_id', 'Out With');
				$this->crud->display_as('user_id','Uploaded By');
				$this->crud->display_as('name','Name');
				$this->crud->display_as('timestamp','Creation Date');
				$this->crud->set_field_upload('name','assets/uploads/files');
				$this->crud->where('gate_id', $gate_id);
				$this->crud->callback_before_insert(array($this,'gate_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function gate_signatures($pk, $row) {
			return '/backend/gate_signature/'.$pk;
		}

		public function gate_signature($gate_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('gate_signature');
				$this->crud->set_subject('Gate Pass Signature');
				$this->crud->callback_field('gate_id',array($this,'fixed_gate'));
				$this->crud->set_relation('gate_id', 'gate', 'out_with');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->set_relation('role_id', 'roles', 'role');
				$this->crud->set_relation('department_id', 'departments', 'name');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('gate_id', 'Out With');
				$this->crud->display_as('user_id','Created By');
				$this->crud->display_as('role_id','Role');
				$this->crud->display_as('department_id','Department');
				$this->crud->display_as('rank','Rank');
				$this->crud->display_as('reject','Reject');
				$this->crud->display_as('timestamp','Creation Date');
				$this->crud->where('gate_id', $gate_id);
				$this->crud->callback_before_insert(array($this,'gate_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function gate_items($pk, $row) {
			return '/backend/gate_item/'.$pk;
		}

		public function gate_item($gate_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('gate_items');
				$this->crud->set_subject('Gate Pass Item');
				$this->crud->callback_field('gate_id',array($this,'fixed_gate'));
				$this->crud->set_relation('gate_id', 'gate', 'out_with');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('ip', 'IP');
				$this->crud->display_as('gate_id', 'Out With');
				$this->crud->display_as('user_id','Created By');
				$this->crud->display_as('quantity','Quantity');
				$this->crud->display_as('item', 'Item');
				$this->crud->display_as('fille','Fille');
				$this->crud->display_as('timestamp','Timestamp');
				$this->crud->set_field_upload('fille','assets/uploads/files');
				$this->crud->where('gate_id', $gate_id);
				$this->crud->callback_before_insert(array($this,'gate_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function gate_sign() {
			try {
				$this->load->model('roles_model');
				$this->load->model('Departments_model');
				$this->crud->set_theme('datatables');
				$this->crud->set_table('gate_type');
				$this->crud->set_subject('Gate Pass Signatures');
				$this->crud->columns('id', 'name', 'dummy', 'dummy1');
				$this->crud->display_as('dummy', 'Role Signatures');
				$this->crud->display_as('dummy1', 'Department Signatures');
				$this->crud->display_as('name', 'Name');
				$this->crud->display_as('id', 'ID#');
				$this->crud->callback_field('dummy',array($this,'gate_role_sign'));
				$this->crud->callback_field('dummy1',array($this,'gate_department_sign'));
				$this->crud->callback_before_insert(array($this,'process_for_insert_gate'));
				$this->crud->callback_after_insert(array($this,'process_extras_after_gate'));
				$this->crud->callback_before_update(array($this,'process_extras_gate'));
				$this->crud->set_soft_delete();
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function process_for_insert_gate($post_array) {
		  	unset($post_array['roles']);
		  	unset($post_array['departments']);
		 	return $post_array;
		}

		public function process_extras_after_gate($post_array, $primary_key) {
		  	$this->load->model('gate_role_model');
		  	$this->gate_role_model->reset_gate($primary_key);
		  	$rank = 1;
		  	$resulte =  array();
		  	foreach ($post_array['roles'] as $key => $role) {
		    	if ($role != 0) {
		      		$sign_id = $this->gate_role_model->add_role_gate($primary_key, $role, $rank);
		      		$resulte[] = $sign_id;
		      		$rank++;
		    	}
		  	}
		  	foreach ($post_array['departments'] as $key => $department) {
		    	if ($department != 0) {
		      		$this->gate_role_model->add_department_gate($primary_key, $department, $resulte[$key]);
		    	}
		  	}
		}

		public function process_extras_gate($post_array, $primary_key) {
		  	$this->load->model('gate_role_model');
		  	$this->gate_role_model->reset_gate($primary_key);
		  	$rank = 1;
		  	$resulte =  array();
		  	foreach ($post_array['roles'] as $key => $role) {
		    	if ($role != 0) {
		      		$sign_id = $this->gate_role_model->add_role_gate($primary_key, $role, $rank);
		      		$resulte[] = $sign_id;
		      		$rank++;
		    	}
		  	}
		  	foreach ($post_array['departments'] as $key => $department) {
		    	if ($department != 0) {
		      		$this->gate_role_model->add_department_gate($primary_key, $department, $resulte[$key]);
		    	}
		  	}
		  	unset($post_array['roles']);
		  	unset($post_array['departments']);
		  	return $post_array;
		}

		public function gate_role_sign($var, $primary_key = null) {
		  	$this->load->model('gate_role_model');
		  	$gate_roles = $this->gate_role_model->getby_gate($primary_key);
		  	$all_roles = $this->roles_model->getall();
		  	$global_field = '<div id="role-hidden-template" style="display:none">'.$this->gate_role_signature_field($all_roles, FALSE, FALSE).'</div>';
		  	$global_field .= '<div class="field-role-global .connected">';
		  	foreach ($gate_roles as $gate_role) {
		    	$global_field .= $this->gate_role_signature_field($all_roles, $gate_role['role']);
		  	}
		  	$global_field .= $this->gate_role_signature_field($all_roles);
		  	$global_field .= '</div> <br />';
		  	$global_field .= '<script type="text/javascript">
		        $(function () {
		            $(".role-selector").change(function(){
		                var zeroValue = false;
		                $(".field-role-global .role-selector").each(function(){
		                  	if ($(this).val() == ""){
		                    	zeroValue = true;
		                  	}
		                });
		              	if(!zeroValue) {
			                $clone = $("#role-hidden-template").children().first().clone(true);
			                $clone.find("select").addClass("chosen-select");
			                $clone.appendTo(".field-role-global");
		                	$(".chosen-select").chosen();
		              	}
		            });
		            $(".field-role-global").sortable({
		                connectWith: ".connected"
		            });
		        });
		    </script>';
		  	return $global_field;
		}

		private function gate_role_signature_field( $all_roles, $option = FALSE, $chosen = TRUE) {
		  	$class = ($chosen)? 'chosen-select' : '';
		  	$field = '
			  	<div class="form-input-box sortable-selects" >
			    	<select name="roles[]" class="'.$class.' role-selector" data-placeholder="Select Role">
			      		<option value=""></option>
			      		';
			  			foreach ($all_roles as $role) {
						    $field .= '<option value="'.$role['id'].'" ';
						    $field .= ($option && $option == $role['id'])? ' selected="selected" ' : '';
						    $field .= '>'.$role['role'].'</option>';
			  			};
			  			$field .= '
			    	</select>
			    	<span class="icon icon-th-list"></span>
			  	</div>
			';
		  	return $field;
		}

		public function gate_department_sign($var, $primary_key = null) {
		  	$this->load->model('gate_role_model');
		  	$gate_departments = $this->gate_role_model->getby_gate($primary_key);
		  	$all_departments = $this->Departments_model->getall();
		  	$global_field = '<div class="field-department-global .connected">';
		  	foreach ($gate_departments as $gate_department) {
		    	$global_field .= $this->gate_department_signature_field($all_departments, $gate_department['department']);
		  	}
		  	$global_field .= $this->gate_department_signature_field($all_departments);
		  	$global_field .= '</div> <br />';
		  	return $global_field;
		}

		private function gate_department_signature_field( $all_departments, $option = FALSE, $chosen = TRUE) {
		  	$class = ($chosen)? 'chosen-select' : '';
		  	$field = '
			  	<div class="form-input-box sortable-selects" >
			    	<select name="departments[]" class="'.$class.' department-selector" data-placeholder="Select Department">
			      		<option value=""></option>
			      		';
			  			foreach ($all_departments as $department) {
						    $field .= '<option value="'.$department['id'].'" ';
						    $field .= ($option && $option == $department['id'])? ' selected="selected" ' : '';
						    $field .= '>'.$department['name'].'</option>';
			  			};
			  			$field .= '
			    	</select>
			    	<span class="icon icon-th-list"></span>
			  	</div>
			';
		  	return $field;
		}

		public function out_service() {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('out_service');
				$this->crud->set_subject('Retired Items');
				$this->crud->columns('id', 'user_id', 'hotel_id', 'serial', 'department_id', 'out_with', 'timestamp');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->set_relation('hotel_id', 'hotels', 'name');
				$this->crud->set_relation('sister_id', 'hotels', 'name');
				$this->crud->set_relation('reason', 'out_service_reasons', 'name');
				$this->crud->set_relation('department_id', 'departments', 'name');
				$this->crud->set_relation('state_id', 'out_service_states', 'name');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('ip','IP');
				$this->crud->display_as('user_id','User');
				$this->crud->display_as('serial','Serial Number');
				$this->crud->display_as('hotel_id','Hotel');
				$this->crud->display_as('date','Date');
				$this->crud->display_as('department_id','Department');
				$this->crud->display_as('reason','Reason');
				$this->crud->display_as('sister_id','Sister Hotel');
				$this->crud->display_as('state_id','State');
				$this->crud->display_as('timestamp','Creation Date');
				$this->crud->add_action('Edit Retired Items Comments', '', '','ui-icon-image',array($this,'out_service_comments'));
				$this->crud->add_action('Edit Retired Items Attachments', '', '','ui-icon-image',array($this,'out_service_attachments'));
				$this->crud->add_action('Edit Retired Items Signatures', '', '','ui-icon-image',array($this,'out_service_signatures'));
				$this->crud->add_action('Edit Retired Items Items', '', '','ui-icon-image',array($this,'out_service_items'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function out_service_associates($post_array) {
			$out_id = $this->uri->segment(3);
			$post_array['out_id'] = $out_id;
			return $post_array;
		}

		public function fixed_out_service() {
			return '';
		}

		function out_service_comments($pk, $row) {
			return '/backend/out_service_comment/'.$pk;
		}

		public function out_service_comment($out_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('out_service_comments');
				$this->crud->set_subject('Retired Items Comment');
				$this->crud->callback_field('out_id',array($this,'fixed_out_service'));
				$this->crud->set_relation('out_id', 'out_service', 'serial');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('out_id', 'Serial Number');
				$this->crud->display_as('user_id','Commented By');
				$this->crud->display_as('comment','Comment');
				$this->crud->display_as('timestamp','Creation Date');
				$this->crud->where('out_id', $out_id);
				$this->crud->callback_before_insert(array($this,'out_service_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function out_service_attachments($pk, $row) {
			return '/backend/out_service_attachment/'.$pk;
		}

		public function out_service_attachment($out_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('out_service_filles');
				$this->crud->set_subject('Retired Items Attachment');
				$this->crud->callback_field('out_id',array($this,'fixed_out_service'));
				$this->crud->set_relation('out_id', 'out_service', 'serial');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('out_id', 'Serial Number');
				$this->crud->display_as('user_id','Uploaded By');
				$this->crud->display_as('name','Name');
				$this->crud->display_as('timestamp','Creation Date');
				$this->crud->set_field_upload('name','assets/uploads/files');
				$this->crud->where('out_id', $out_id);
				$this->crud->callback_before_insert(array($this,'out_service_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function out_service_signatures($pk, $row) {
			return '/backend/out_service_signature/'.$pk;
		}

		public function out_service_signature($out_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('out_service_signature');
				$this->crud->set_subject('Retired Items Signature');
				$this->crud->callback_field('out_id',array($this,'fixed_out_service'));
				$this->crud->set_relation('out_id', 'out_service', 'serial');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->set_relation('role_id', 'roles', 'role');
				$this->crud->set_relation('department_id', 'departments', 'name');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('out_id', 'Serial Number');
				$this->crud->display_as('user_id','Created By');
				$this->crud->display_as('role_id','Role');
				$this->crud->display_as('department_id','Department');
				$this->crud->display_as('rank','Rank');
				$this->crud->display_as('reject','Reject');
				$this->crud->display_as('timestamp','Creation Date');
				$this->crud->where('out_id', $out_id);
				$this->crud->callback_before_insert(array($this,'out_service_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function out_service_items($pk, $row) {
			return '/backend/out_service_item/'.$pk;
		}

		public function out_service_item($out_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('out_service_items');
				$this->crud->set_subject('Retired Items Item');
				$this->crud->callback_field('out_id',array($this,'fixed_out_service'));
				$this->crud->set_relation('out_id', 'out_service', 'serial');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('ip', 'IP');
				$this->crud->display_as('out_id', 'Serial Number');
				$this->crud->display_as('user_id','Created By');
				$this->crud->display_as('quantity','Quantity');
				$this->crud->display_as('description', 'Description');
				$this->crud->display_as('serial_number', 'Item Serial Number');
				$this->crud->display_as('reason', 'Reason');
				$this->crud->display_as('fille','Fille');
				$this->crud->display_as('timestamp','Timestamp');
				$this->crud->set_field_upload('fille','assets/uploads/files');
				$this->crud->where('out_id', $out_id);
				$this->crud->callback_before_insert(array($this,'out_service_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function out_service_sign() {
			try {
				$this->load->model('roles_model');
				$this->load->model('Departments_model');
				$this->crud->set_theme('datatables');
				$this->crud->set_table('out_service_type');
				$this->crud->set_subject('Retired Items Signatures');
				$this->crud->columns('id', 'name', 'dummy', 'dummy1');
				$this->crud->display_as('dummy', 'Role Signatures');
				$this->crud->display_as('dummy1', 'Department Signatures');
				$this->crud->display_as('name', 'Name');
				$this->crud->display_as('id', 'ID#');
				$this->crud->callback_field('dummy',array($this,'out_service_role_sign'));
				$this->crud->callback_field('dummy1',array($this,'out_service_department_sign'));
				$this->crud->callback_before_insert(array($this,'process_for_insert_out_service'));
				$this->crud->callback_after_insert(array($this,'process_extras_after_out_service'));
				$this->crud->callback_before_update(array($this,'process_extras_out_service'));
				$this->crud->set_soft_delete();
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function process_for_insert_out_service($post_array) {
		  	unset($post_array['roles']);
		  	unset($post_array['departments']);
		 	return $post_array;
		}

		public function process_extras_after_out_service($post_array, $primary_key) {
		  	$this->load->model('out_service_role_model');
		  	$this->out_service_role_model->reset_out_service($primary_key);
		  	$rank = 1;
		  	$resulte =  array();
		  	foreach ($post_array['roles'] as $key => $role) {
		    	if ($role != 0) {
		      		$sign_id = $this->out_service_role_model->add_role_out_service($primary_key, $role, $rank);
		      		$resulte[] = $sign_id;
		      		$rank++;
		    	}
		  	}
		  	foreach ($post_array['departments'] as $key => $department) {
		    	if ($department != 0) {
		      		$this->out_service_role_model->add_department_out_service($primary_key, $department, $resulte[$key]);
		    	}
		  	}
		}

		public function process_extras_out_service($post_array, $primary_key) {
		  	$this->load->model('out_service_role_model');
		  	$this->out_service_role_model->reset_out_service($primary_key);
		  	$rank = 1;
		  	$resulte =  array();
		  	foreach ($post_array['roles'] as $key => $role) {
		    	if ($role != 0) {
		      		$sign_id = $this->out_service_role_model->add_role_out_service($primary_key, $role, $rank);
		      		$resulte[] = $sign_id;
		      		$rank++;
		    	}
		  	}
		  	foreach ($post_array['departments'] as $key => $department) {
		    	if ($department != 0) {
		      		$this->out_service_role_model->add_department_out_service($primary_key, $department, $resulte[$key]);
		    	}
		  	}
		  	unset($post_array['roles']);
		  	unset($post_array['departments']);
		  	return $post_array;
		}

		public function out_service_role_sign($var, $primary_key = null) {
		  	$this->load->model('out_service_role_model');
		  	$out_service_roles = $this->out_service_role_model->getby_out_service($primary_key);
		  	$all_roles = $this->roles_model->getall();
		  	$global_field = '<div id="role-hidden-template" style="display:none">'.$this->out_service_role_signature_field($all_roles, FALSE, FALSE).'</div>';
		  	$global_field .= '<div class="field-role-global .connected">';
		  	foreach ($out_service_roles as $out_service_role) {
		    	$global_field .= $this->out_service_role_signature_field($all_roles, $out_service_role['role']);
		  	}
		  	$global_field .= $this->out_service_role_signature_field($all_roles);
		  	$global_field .= '</div> <br />';
		  	$global_field .= '<script type="text/javascript">
		        $(function () {
		            $(".role-selector").change(function(){
		                var zeroValue = false;
		                $(".field-role-global .role-selector").each(function(){
		                  	if ($(this).val() == ""){
		                    	zeroValue = true;
		                  	}
		                });
		              	if(!zeroValue) {
			                $clone = $("#role-hidden-template").children().first().clone(true);
			                $clone.find("select").addClass("chosen-select");
			                $clone.appendTo(".field-role-global");
		                	$(".chosen-select").chosen();
		              	}
		            });
		            $(".field-role-global").sortable({
		                connectWith: ".connected"
		            });
		        });
		    </script>';
		  	return $global_field;
		}

		private function out_service_role_signature_field( $all_roles, $option = FALSE, $chosen = TRUE) {
		  	$class = ($chosen)? 'chosen-select' : '';
		  	$field = '
			  	<div class="form-input-box sortable-selects" >
			    	<select name="roles[]" class="'.$class.' role-selector" data-placeholder="Select Role">
			      		<option value=""></option>
			      		';
			  			foreach ($all_roles as $role) {
						    $field .= '<option value="'.$role['id'].'" ';
						    $field .= ($option && $option == $role['id'])? ' selected="selected" ' : '';
						    $field .= '>'.$role['role'].'</option>';
			  			};
			  			$field .= '
			    	</select>
			    	<span class="icon icon-th-list"></span>
			  	</div>
			';
		  	return $field;
		}

		public function out_service_department_sign($var, $primary_key = null) {
		  	$this->load->model('out_service_role_model');
		  	$out_service_departments = $this->out_service_role_model->getby_out_service($primary_key);
		  	$all_departments = $this->Departments_model->getall();
		  	$global_field = '<div class="field-department-global .connected">';
		  	foreach ($out_service_departments as $out_service_department) {
		    	$global_field .= $this->out_service_department_signature_field($all_departments, $out_service_department['department']);
		  	}
		  	$global_field .= $this->out_service_department_signature_field($all_departments);
		  	$global_field .= '</div> <br />';
		  	return $global_field;
		}

		private function out_service_department_signature_field( $all_departments, $option = FALSE, $chosen = TRUE) {
		  	$class = ($chosen)? 'chosen-select' : '';
		  	$field = '
			  	<div class="form-input-box sortable-selects" >
			    	<select name="departments[]" class="'.$class.' department-selector" data-placeholder="Select Department">
			      		<option value=""></option>
			      		';
			  			foreach ($all_departments as $department) {
						    $field .= '<option value="'.$department['id'].'" ';
						    $field .= ($option && $option == $department['id'])? ' selected="selected" ' : '';
						    $field .= '>'.$department['name'].'</option>';
			  			};
			  			$field .= '
			    	</select>
			    	<span class="icon icon-th-list"></span>
			  	</div>
			';
		  	return $field;
		}

		public function out_service_reasons() {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('out_service_reasons');
				$this->crud->set_subject('Retired Items Reason');
				$this->crud->columns('id', 'name');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('name','Reason');
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function out_service_states() {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('out_service_states');
				$this->crud->set_subject('Retired Items State');
				$this->crud->columns('id', 'name');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('name','State');
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function policy_core() {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('policy_core');
				$this->crud->set_subject('Signature Policies');
				$this->crud->columns('id', 'user_id', 'timestamp');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('user_id','User');
				$this->crud->display_as('state_id','State');
				$this->crud->display_as('timestamp','Creation Date');
				$this->crud->add_action('Edit Signature Policy Comments', '', '','ui-icon-image',array($this,'policy_comments'));
				$this->crud->add_action('Edit Signature Policy Signatures', '', '','ui-icon-image',array($this,'policy_signatures'));
				$this->crud->add_action('Edit Signature Policy Policies', '', '','ui-icon-image',array($this,'policy_policies'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function policy_associates($post_array) {
			$core_id = $this->uri->segment(3);
			$post_array['core_id'] = $core_id;
			return $post_array;
		}

		public function fixed_policy() {
			return '';
		}

		function policy_comments($pk, $row) {
			return '/backend/policy_comment/'.$pk;
		}

		public function policy_comment($core_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('policy_comments');
				$this->crud->set_subject('Signature Policy Comment');
				$this->crud->callback_field('core_id',array($this,'fixed_policy'));
				$this->crud->set_relation('core_id', 'policy_core', 'timestamp');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('core_id', 'Timestamp');
				$this->crud->display_as('user_id','Commented By');
				$this->crud->display_as('comment','Comment');
				$this->crud->display_as('timestamp','Creation Date');
				$this->crud->where('core_id', $core_id);
				$this->crud->callback_before_insert(array($this,'policy_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function policy_signatures($pk, $row) {
			return '/backend/policy_signature/'.$pk;
		}

		public function policy_signature($core_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('policy_signature');
				$this->crud->set_subject('Signature Policy Signature');
				$this->crud->callback_field('core_id',array($this,'fixed_policy'));
				$this->crud->set_relation('core_id', 'policy_core', 'timestamp');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->set_relation('role_id', 'roles', 'role');
				$this->crud->set_relation('department_id', 'departments', 'name');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('core_id', 'Timestamp');
				$this->crud->display_as('user_id','Created By');
				$this->crud->display_as('role_id','Role');
				$this->crud->display_as('department_id','Department');
				$this->crud->display_as('rank','Rank');
				$this->crud->display_as('reject','Reject');
				$this->crud->display_as('timestamp','Creation Date');
				$this->crud->where('core_id', $core_id);
				$this->crud->callback_before_insert(array($this,'policy_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function policy_policies($pk, $row) {
			return '/backend/policy_policy/'.$pk;
		}

		public function policy_policy($core_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('policy');
				$this->crud->set_subject('Signature Policy Policy');
				$this->crud->callback_field('core_id',array($this,'fixed_policy'));
				$this->crud->set_relation('core_id', 'policy_core', 'timestamp');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->set_relation('first', 'roles', 'role');
				$this->crud->set_relation('second', 'roles', 'role');
				$this->crud->set_relation('third', 'roles', 'role');
				$this->crud->set_relation('fourth', 'roles', 'role');
				$this->crud->set_relation('fifth', 'roles', 'role');
				$this->crud->set_relation('sixth', 'roles', 'role');
				$this->crud->set_relation('seventh', 'roles', 'role');
				$this->crud->set_relation('type_id', 'policy_types', 'name');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('core_id', 'Timestamp');
				$this->crud->display_as('user_id','Created By');
				$this->crud->display_as('type_id','Type');
				$this->crud->display_as('first','First Signature');
				$this->crud->display_as('second', 'Second Signature');
				$this->crud->display_as('third', 'Third Signature');
				$this->crud->display_as('fourth', 'Fourth Signature');
				$this->crud->display_as('fifth','Fifth Signature');
				$this->crud->display_as('sixth','Sixth Signature');
				$this->crud->display_as('seventh','Seventh Signature');
				$this->crud->display_as('timestamp','Creation Date');
				$this->crud->where('core_id', $core_id);
				$this->crud->callback_before_insert(array($this,'policy_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function policy_sign() {
			try {
				$this->load->model('roles_model');
				$this->load->model('Departments_model');
				$this->crud->set_theme('datatables');
				$this->crud->set_table('policy_type');
				$this->crud->set_subject('Signature Policy Signatures');
				$this->crud->columns('id', 'name', 'dummy', 'dummy1');
				$this->crud->display_as('dummy', 'Role Signatures');
				$this->crud->display_as('dummy1', 'Department Signatures');
				$this->crud->display_as('name', 'Name');
				$this->crud->display_as('id', 'ID#');
				$this->crud->callback_field('dummy',array($this,'policy_role_sign'));
				$this->crud->callback_field('dummy1',array($this,'policy_department_sign'));
				$this->crud->callback_before_insert(array($this,'process_for_insert_policy'));
				$this->crud->callback_after_insert(array($this,'process_extras_after_policy'));
				$this->crud->callback_before_update(array($this,'process_extras_policy'));
				$this->crud->set_soft_delete();
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function process_for_insert_policy($post_array) {
		  	unset($post_array['roles']);
		  	unset($post_array['departments']);
		 	return $post_array;
		}

		public function process_extras_after_policy($post_array, $primary_key) {
		  	$this->load->model('policy_role_model');
		  	$this->policy_role_model->reset_policy($primary_key);
		  	$rank = 1;
		  	$resulte =  array();
		  	foreach ($post_array['roles'] as $key => $role) {
		    	if ($role != 0) {
		      		$sign_id = $this->policy_role_model->add_role_policy($primary_key, $role, $rank);
		      		$resulte[] = $sign_id;
		      		$rank++;
		    	}
		  	}
		  	foreach ($post_array['departments'] as $key => $department) {
		    	if ($department != 0) {
		      		$this->policy_role_model->add_department_policy($primary_key, $department, $resulte[$key]);
		    	}
		  	}
		}

		public function process_extras_policy($post_array, $primary_key) {
		  	$this->load->model('policy_role_model');
		  	$this->policy_role_model->reset_policy($primary_key);
		  	$rank = 1;
		  	$resulte =  array();
		  	foreach ($post_array['roles'] as $key => $role) {
		    	if ($role != 0) {
		      		$sign_id = $this->policy_role_model->add_role_policy($primary_key, $role, $rank);
		      		$resulte[] = $sign_id;
		      		$rank++;
		    	}
		  	}
		  	foreach ($post_array['departments'] as $key => $department) {
		    	if ($department != 0) {
		      		$this->policy_role_model->add_department_policy($primary_key, $department, $resulte[$key]);
		    	}
		  	}
		  	unset($post_array['roles']);
		  	unset($post_array['departments']);
		  	return $post_array;
		}

		public function policy_role_sign($var, $primary_key = null) {
		  	$this->load->model('policy_role_model');
		  	$policy_roles = $this->policy_role_model->getby_policy($primary_key);
		  	$all_roles = $this->roles_model->getall();
		  	$global_field = '<div id="role-hidden-template" style="display:none">'.$this->policy_role_signature_field($all_roles, FALSE, FALSE).'</div>';
		  	$global_field .= '<div class="field-role-global .connected">';
		  	foreach ($policy_roles as $policy_role) {
		    	$global_field .= $this->policy_role_signature_field($all_roles, $policy_role['role']);
		  	}
		  	$global_field .= $this->policy_role_signature_field($all_roles);
		  	$global_field .= '</div> <br />';
		  	$global_field .= '<script type="text/javascript">
		        $(function () {
		            $(".role-selector").change(function(){
		                var zeroValue = false;
		                $(".field-role-global .role-selector").each(function(){
		                  	if ($(this).val() == ""){
		                    	zeroValue = true;
		                  	}
		                });
		              	if(!zeroValue) {
			                $clone = $("#role-hidden-template").children().first().clone(true);
			                $clone.find("select").addClass("chosen-select");
			                $clone.appendTo(".field-role-global");
		                	$(".chosen-select").chosen();
		              	}
		            });
		            $(".field-role-global").sortable({
		                connectWith: ".connected"
		            });
		        });
		    </script>';
		  	return $global_field;
		}

		private function policy_role_signature_field( $all_roles, $option = FALSE, $chosen = TRUE) {
		  	$class = ($chosen)? 'chosen-select' : '';
		  	$field = '
			  	<div class="form-input-box sortable-selects" >
			    	<select name="roles[]" class="'.$class.' role-selector" data-placeholder="Select Role">
			      		<option value=""></option>
			      		';
			  			foreach ($all_roles as $role) {
						    $field .= '<option value="'.$role['id'].'" ';
						    $field .= ($option && $option == $role['id'])? ' selected="selected" ' : '';
						    $field .= '>'.$role['role'].'</option>';
			  			};
			  			$field .= '
			    	</select>
			    	<span class="icon icon-th-list"></span>
			  	</div>
			';
		  	return $field;
		}

		public function policy_department_sign($var, $primary_key = null) {
		  	$this->load->model('policy_role_model');
		  	$policy_departments = $this->policy_role_model->getby_policy($primary_key);
		  	$all_departments = $this->Departments_model->getall();
		  	$global_field = '<div class="field-department-global .connected">';
		  	foreach ($policy_departments as $policy_department) {
		    	$global_field .= $this->policy_department_signature_field($all_departments, $policy_department['department']);
		  	}
		  	$global_field .= $this->policy_department_signature_field($all_departments);
		  	$global_field .= '</div> <br />';
		  	return $global_field;
		}

		private function policy_department_signature_field( $all_departments, $option = FALSE, $chosen = TRUE) {
		  	$class = ($chosen)? 'chosen-select' : '';
		  	$field = '
			  	<div class="form-input-box sortable-selects" >
			    	<select name="departments[]" class="'.$class.' department-selector" data-placeholder="Select Department">
			      		<option value=""></option>
			      		';
			  			foreach ($all_departments as $department) {
						    $field .= '<option value="'.$department['id'].'" ';
						    $field .= ($option && $option == $department['id'])? ' selected="selected" ' : '';
						    $field .= '>'.$department['name'].'</option>';
			  			};
			  			$field .= '
			    	</select>
			    	<span class="icon icon-th-list"></span>
			  	</div>
			';
		  	return $field;
		}

		public function policy_department() {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('policy_department');
				$this->crud->set_subject('Signature Policy Department');
				$this->crud->columns('id', 'name');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('name','Department');
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function policy_types() {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('policy_types');
				$this->crud->set_subject('Signature Policy Type');
				$this->crud->columns('id', 'department_id', 'name');
				$this->crud->set_relation('department_id', 'policy_department', 'name');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('department_id','Department');
				$this->crud->display_as('name','Type');
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function policy_requests() {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('policy_requests');
				$this->crud->set_subject('Signature Policy Change Request');
				$this->crud->columns('id', 'department_id', 'change', 'timestamp');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('user_id','Created By');
				$this->crud->display_as('department_id','Department');
				$this->crud->display_as('change','Change');
				$this->crud->display_as('reason','Reason');
				$this->crud->display_as('timestamp','Timestamp');
				$this->crud->add_action('Edit Signature Policy Change Request Comments', '', '','ui-icon-image',array($this,'policy_request_comments'));
				$this->crud->add_action('Edit Signature Policy Change Request Attachments', '', '','ui-icon-image',array($this,'policy_request_attachments'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function policy_request_associates($post_array) {
			$req_id = $this->uri->segment(3);
			$post_array['req_id'] = $req_id;
			return $post_array;
		}

		public function fixed_policy_request() {
			return '';
		}

		function policy_request_comments($pk, $row) {
			return '/backend/policy_request_comment/'.$pk;
		}

		public function policy_request_comment($req_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('policy_requests_comments');
				$this->crud->set_subject('Signature Policy Change Request Comment');
				$this->crud->callback_field('req_id',array($this,'fixed_policy_request'));
				$this->crud->set_relation('req_id', 'policy_requests', 'timestamp');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('req_id', 'Timestamp');
				$this->crud->display_as('user_id','Commented By');
				$this->crud->display_as('comment','Comment');
				$this->crud->display_as('timestamp','Creation Date');
				$this->crud->where('req_id', $req_id);
				$this->crud->callback_before_insert(array($this,'policy_request_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function policy_request_attachments($pk, $row) {
			return '/backend/policy_request_attachment/'.$pk;
		}

		public function policy_request_attachment($req_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('policy_requests_filles');
				$this->crud->set_subject('Signature Policy Change Request Attachment');
				$this->crud->callback_field('req_id',array($this,'fixed_policy_request'));
				$this->crud->set_relation('req_id', 'policy_requests', 'timestamp');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->display_as('id', '#');
				$this->crud->display_as('req_id', 'Timestamp');
				$this->crud->display_as('user_id','Uploaded By');
				$this->crud->display_as('name','Name');
				$this->crud->display_as('timestamp','Creation Date');
				$this->crud->set_field_upload('name','assets/uploads/files');
				$this->crud->where('req_id', $req_id);
				$this->crud->callback_before_insert(array($this,'policy_request_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

	}

?>