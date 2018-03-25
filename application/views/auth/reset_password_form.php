<!DOCTYPE html>
<html lang="en">
<head>
<?php $this->load->view('header'); ?>
</head>
<body>
<?php $this->load->view('menu') ?>

<?php
$new_password = array(
	'name'	=> 'new_password',
	'id'	=> 'new_password',
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size'	=> 30,
	'class' => 'form-control'
);
$confirm_new_password = array(
	'name'	=> 'confirm_new_password',
	'id'	=> 'confirm_new_password',
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size' 	=> 30,
	'class' => 'form-control'
);
?>
<?php echo form_open($this->uri->uri_string()); ?>
<div class="container">
	<div class="col-lg-6 col-md-8 col-sm-10">
		<div><?php echo form_label('New Password', $new_password['id']); ?></div>
		<div><?php echo form_password($new_password); ?></div>
		<div style="color: red;"><?php echo form_error($new_password['name']); ?><?php echo isset($errors[$new_password['name']])?$errors[$new_password['name']]:''; ?></div>
	</div>
	<div class="col-lg-6 col-md-8 col-sm-10">
		<div><?php echo form_label('Confirm New Password', $confirm_new_password['id']); ?></div>
		<div><?php echo form_password($confirm_new_password); ?></div>
		<div style="color: red;"><?php echo form_error($confirm_new_password['name']); ?><?php echo isset($errors[$confirm_new_password['name']])?$errors[$confirm_new_password['name']]:''; ?></div>
	</div>
</table>
<input class="col-lg-offset-4 col-md-offset-5 col-sm-offset-6 btn btn-primary" type="submit" name="change" value="Change Password">
<?php echo form_close(); ?>