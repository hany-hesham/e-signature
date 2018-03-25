<!DOCTYPE html>
<html lang="en">
<head>
<?php $this->load->view('header'); ?>
</head>
<body>
<?php $this->load->view('menu') ?>

<?php
$login = array(
	'name'	=> 'login',
	'id'	=> 'login',
	'value' => set_value('login'),
	'maxlength'	=> 80,
	'size'	=> 30,
	'class' => 'form-control'
);
if ($this->config->item('use_username', 'tank_auth')) {
	$login_label = 'Email or login';
} else {
	$login_label = 'Email';
}
?>
<?php echo form_open($this->uri->uri_string()); ?>
<div class="container">
	<div class="form-group col-lg-6 col-md-8 col-sm-10">
		<div><?php echo form_label($login_label, $login['id']); ?></div>
		<div><?php echo form_input($login); ?></div>
		<div style="color: red;"><?php echo form_error($login['name']); ?><?php echo isset($errors[$login['name']])?$errors[$login['name']]:''; ?></div>
	</div>
</div>
<input class="col-lg-offset-4 col-md-offset-5 col-sm-offset-6 btn btn-primary" type="submit" name="reset" value="Get a new password">
<?php echo form_close(); ?>