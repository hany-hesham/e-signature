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
				<legend>Edit Project</legend>

			<?php if(validation_errors() != false): ?>
				<div class="alert alert-danger">
					<?php echo validation_errors(); ?>
				</div>
			<?php endif ?>
			<?php if(isset($errors) && $errors != false): ?>
			  <div class="alert alert-danger">
			    <?php echo $errors; ?>
			  </div>
			<?php endif ?>

			<form action="" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">

				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<label for="progress" class="col-lg-3 col-md-4 col-sm-5 col-xs-5  control-label">Project Status</label>
					<div class="col-lg-3 col-md-4 col-sm-5 col-xs-5">
						<select class="form-control" name="progress" id="progress">
								<option value=""> Select Project Progress </option>
							<?php foreach ($progress as $progree): ?>
								<option value="<?php echo $progree['id'] ?>" <?php echo ($progree['id'] == $project['progress_id'])? 'selected="selected"' : '' ?>><?php echo $progree['name']; ?></option>
							<?php endforeach ?>
						</select>
					</div>
				</div>
				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<label for="budget" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label">Exchange Rate</label>
					<label for="budget" class="col-lg-1 col-md-1 col-sm-1 col-xs-1  control-label">USD</label>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<input  type="number" step="any" class="form-control true-calc" name="usd_ex" id="usd_ex" value="<?php echo $project['USD_EX']; ?>" />
					</div>
					<label for="budget" class="col-lg-1 col-md-1 col-sm-1 col-xs-1  control-label">EUR</label>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<input  type="number" step="any" class="form-control true-calc" name="eur_ex" id="eur_ex" value="<?php echo $project['EUR_EX']; ?>" />
					</div>
				</div>
				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<br>
					</div>
				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<label for="true" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label">Actual Cost</label>
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 currency-single">
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 currency-single">
							<input  type="number" step="any" class="form-control true-calc" name="true_egp" id="true_egp" value="<?php echo $project['true_EGP']; ?>"  />
						</div>
						<label for="true" class="col-lg-4 col-md-4 col-sm-4 col-xs-4 for-currency-single control-label">EGP</label>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 currency-single">
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 currency-single">
							<input  type="number" step="any" class="form-control true-calc" name="true_usd" id="true_usd" value="<?php echo $project['true_USD']; ?>"  />
						</div>
						<label for="true" class="col-lg-4 col-md-4 col-sm-4 col-xs-4 for-currency-single control-label">USD</label>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 currency-single">
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 currency-single">
							<input  type="number" step="any" class="form-control true-calc" name="true_eur" id="true_eur" value="<?php echo $project['true_EUR']; ?>"  />
						</div>
						<label for="true" class="col-lg-4 col-md-4 col-sm-4 col-xs-4 for-currency-single control-label">EUR</label>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<br>
						<br>
						<br>
						<br>
					</div>
					<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<label for="true" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label">New End Date</label>
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
							<input type="text" class="form-control datetime" name="new_date" id="new_date" data-date-format="YYYY-MM-DD" value="<?php echo ($project['new_date'] == '0000-00-00')? "":$project['new_date']; ?>" />
						</div>
						<script type="text/javascript">
						$(function () {
								$('.datetime').datetimepicker({
									autoclose: true,
									pickTime: false,

								});

								$("#new_date").on("dp.change",function (e) {
						           $('#new_date').data("DateTimePicker").setMinDate(e.date);
						        });
								
						});
						</script>
					</div>


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"></div>
					<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<label for="true" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label">Total Actual Cost</label>
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
							<input readonly="readonly" type="number" step="any" class="form-control" name="true" id="true" value="<?php echo $project['true']; ?>"  />
						</div>
					</div>
				</div>

				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<label for="status" class="col-lg-4 col-md-4 col-sm-4 col-xs-4  control-label">Remarks</label>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<textarea class="form-control" name="status" id="status"><?php echo $project['progress']; ?></textarea>
					</div>
				</div>

				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<label for="status" class="col-lg-4 col-md-4 col-sm-4 col-xs-4  control-label">Reason</label>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<textarea class="form-control" name="reason" id="status"><?php echo $project['reason']; ?></textarea>
					</div>
				</div>
	
				<div class="form-group">
				    <div class="col-lg-offset-3 col-lg-10 col-md-10 col-md-offset-3">
				    	<input name="submit" value="Submit" type="submit" class="btn btn-success" />
				    	<a href="/projects/view/<?php echo $project['code'] ?>" class="btn btn-warning">Cancel</a>
				    </div>
				</div>

			</form>
			<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<h2>LOG</h2>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<label for="status" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label">Start Date</label>
						<label for="status" class="col-lg-4 col-md-4 col-sm-4 col-xs-4  control-label"><?php echo $project['start']?></label>
					</div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<label for="status" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label">End Date</label>
						<label for="status" class="col-lg-4 col-md-4 col-sm-4 col-xs-4  control-label"><?php echo $project['end']?></label>
					</div>
					<?php foreach($log as $loger ): ?>
                    	<?php $value = json_decode($loger['data']);?>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<label for="status" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label">New Date</label>
							<label for="status" class="col-lg-4 col-md-4 col-sm-4 col-xs-4  control-label"><?php echo $value->new_date;?></label>
						</div>
					<?php endforeach;?>
				</div>
			</fieldset>
		</div>
	</div>
	</div>
</div>
</body>
</html>
