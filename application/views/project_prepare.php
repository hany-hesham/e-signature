<!DOCTYPE html>
<html lang="en">
	<head>
		<?php $this->load->view('header'); ?>
	</head>
	<body>
		<div id="wrapper">
			<?php $this->load->view('menu') ?>
			<div id="page-wrapper">
				<div class="container">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<fieldset>
							<legend>Create planned project</legend>
							<?php if(validation_errors() != false): ?>
								<div class="alert alert-danger">
									<?php echo validation_errors(); ?>
								</div>
							<?php endif ?>
							<form action="" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
								<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<label for="hotel" class="col-lg-3 col-md-4 col-sm-5 col-xs-5 control-label">Hotel</label>
									<div class="col-lg-6 col-md-8 col-sm-8 col-xs-8">
										<select class="form-control" name="hotel" id="hotel">
											<option data-company="0" value="">Select Hotel..</option>
											<?php foreach ($hotels as $hotel): ?>
												<option value="<?php echo $hotel['id'] ?>" <?php echo set_select('hotel',$hotel['id'] ); ?>><?php echo $hotel['name'] ?></option>
											<?php endforeach ?>
										</select>
									</div>
								</div>
								<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<label for="department" class="col-lg-3 col-md-4 col-sm-5 col-xs-5 control-label">Department</label>
									<div class="col-lg-6 col-md-8 col-sm-8 col-xs-8">
										<select class="form-control" name="department" id="department">
											<option data-company="0" value="">Select Department..</option>
											<?php foreach ($departments as $department): ?>
												<option value="<?php echo $department['id'] ?>" <?php echo set_select('department',$department['id'] ); ?>><?php echo $department['name'] ?></option>
											<?php endforeach ?>
										</select>
									</div>
								</div>
								<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<label for="year" class="col-lg-4 col-md-4 col-sm-4 col-xs-4  control-label">Project Year</label>
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<input type="text" class="form-control date unique-plan" name="year" id="year" data-date-format="YYYY-MM" value="<?php echo set_value('year'); ?>"  />
									</div>
								</div>
								<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
				    				<div class="col-lg-offset-3 col-lg-10 col-md-10 col-md-offset-3">
				    					<input name="submit" value="Proceed" type="submit" class="btn btn-success" />
				    					<a href="<?= base_url(); ?>requests" class="btn btn-warning">Cancel</a>
				    				</div>
								</div>
							</form>
						</fieldset>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript">
			$(function () {
				$('.date').datepicker({
					autoclose: true,
					format: "yyyy",
					viewMode: "years", 
					minViewMode: "years"
					startDate: "+0y"
				});
			});
		</script>
	</body>
</html>
