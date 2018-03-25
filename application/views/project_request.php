<!DOCTYPE html>
<html lang="en">
<head>
<?php $this->load->view('header'); ?>
</head>
<body>
<div id="wrapper">
	<?php $this->load->view('menu'); ?>
	<div id="page-wrapper">
	<div class="container">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<fieldset>
			<legend>Approval request, unplanned project</legend>

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
								<option value="<?php echo $hotel['id']; ?>" <?php echo set_select('hotel',$hotel['id'] ); ?>><?php echo $hotel['name']; ?></option>
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
								<option value="<?php echo $department['id'] ?>" <?php echo set_select('department',$department['id'] ); ?>><?php echo $department['name']; ?></option>
							<?php endforeach ?>
						</select>
					</div>

				</div>

				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<label for="type" class="col-lg-3 col-md-4 col-sm-5 col-xs-5  control-label">Project Type</label>
					<div class="col-lg-3 col-md-4 col-sm-5 col-xs-5">
						<select class="form-control" name="type" id="type">
							<option value="">Select Project type..</option>
							<?php foreach ($types as $type): ?>
								<option value="<?php echo $type['id'] ?>"<?php echo set_select('type', $type['id']); ?>><?php echo $type['name']; ?></option>
							<?php endforeach ?>
						</select>
					</div>
				</div>

				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<label for="name" class="col-lg-4 col-md-4 col-sm-4 col-xs-4  control-label">Is this a new equipment?</label>
					<div class="col-lg-3 col-md-4 col-sm-5 col-xs-5">
						<input type="radio" class="" name="new" id="new" value="1" style="width: 15px; height: 15px;" />Yes &nbsp;&nbsp;
						<input type="radio" class="" name="new" id="old" value="0" style="width: 15px; height: 15px;" />No
					</div>
				</div>

				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<label for="name" class="col-lg-4 col-md-4 col-sm-4 col-xs-4  control-label">Project Name</label>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<input type="text" class="form-control" name="name" id="name" value="<?php echo set_value('name'); ?>" />
					</div>
				</div>

				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<label for="reason" class="col-lg-4 col-md-4 col-sm-4 col-xs-4  control-label">Reason for this project</label>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<textarea class="form-control" name="reason" id="reason"><?php echo set_value('reason'); ?></textarea>
					</div>
				</div>

				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<label for="budget" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label">Exchange Rate</label>
					<label for="budget" class="col-lg-1 col-md-1 col-sm-1 col-xs-1  control-label">USD</label>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<input  type="number" step="any" class="form-control budget-calc" name="usd_ex" id="usd_ex" value="<?php echo set_value('usd_ex'); ?>"  />
					</div>
					<label for="budget" class="col-lg-1 col-md-1 col-sm-1 col-xs-1  control-label">EUR</label>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<input  type="number" step="any" class="form-control budget-calc" name="eur_ex" id="eur_ex" value="<?php echo set_value('eur_ex'); ?>"  />
					</div>
				</div>

				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 border"></div>

				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
				
					<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<label for="budget" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label">Estimated Cost</label>
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
							<input readonly="readonly" type="number" step="any" class="form-control" name="budget" id="budget" value="<?php echo set_value('budget'); ?>"  />
						</div>
					</div>


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"></div>
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 currency-single">
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 currency-single">
							<input  type="number" step="any" class="form-control budget-calc" name="budget_egp" id="budget_egp" value="<?php echo set_value('budget_egp'); ?>"  />
						</div>
						<label for="budget" class="col-lg-4 col-md-4 col-sm-4 col-xs-4 for-currency-single control-label">EGP</label>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 currency-single">
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 currency-single">
							<input  type="number" step="any" class="form-control budget-calc" name="budget_usd" id="budget_usd" value="<?php echo set_value('budget_usd'); ?>"  />
						</div>
						<label for="budget" class="col-lg-4 col-md-4 col-sm-4 col-xs-4 for-currency-single control-label">USD</label>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 currency-single">
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 currency-single">
							<input  type="number" step="any" class="form-control budget-calc" name="budget_eur" id="budget_eur" value="<?php echo set_value('budget_eur'); ?>"  />
						</div>
						<label for="budget" class="col-lg-4 col-md-4 col-sm-4 col-xs-4 for-currency-single control-label">EUR</label>
					</div>
				</div>

				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 border"></div>

				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<input type="hidden" name="assumed_id" value="<?php echo $assumed_id; ?>" />
					<label for="supplier[]" class="col-lg-3 col-md-4 col-sm-5 col-xs-5 control-label">Files</label>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<input id="files" name="files" type="file" class="file" multiple="true" data-show-upload="false" data-show-caption="true">
					</div>
					<script>
					$("#files").fileinput({
					    uploadUrl: "/requests/add_files/<?php echo $assumed_id; ?>", // server upload action
					    uploadAsync: true,
					    minFileCount: 1,
					    maxFileCount: 10,
					    overwriteInitial: false,
					    initialPreview: [
					    <?php foreach($files as $file): ?>
					    	"<div class='file-preview-text'>" +
						    "<h2><i class='glyphicon glyphicon-file'></i></h2>" +
						    "<a href='/assets/uploads/files/<?php echo $file['name']; ?>'><?php echo $file['name']; ?></a>" + "</div>",
					    <?php endforeach; ?>
					    ],
					});
					</script>
				</div>

				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<label for="remarks" class="col-lg-4 col-md-4 col-sm-4 col-xs-4  control-label">Remarks</label>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<textarea class="form-control" name="remarks" id="remarks"><?php echo set_value('remarks'); ?></textarea>
					</div>
				</div>
	
				<div class="form-group">
				    <div class="col-lg-offset-3 col-lg-10 col-md-10 col-md-offset-3">
				    	<input name="submit" value="Request" type="submit" class="btn btn-success submitter" />
				    	<a href="/requests" class="btn btn-warning">Cancel</a>
				    </div>
				</div>

			</form>
			</fieldset>
		</div>
	</div>
	</div>
	<div class="holder">Please Wait...</div>
</div>
</body>
</html>