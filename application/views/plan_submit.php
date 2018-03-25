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
			<legend>Request a new project</legend>
			<div id="message-area" class="alert alert-danger">
			</div>
			<?php if(validation_errors() != false): ?>
				<div class="alert alert-danger">
					<?php echo validation_errors(); ?>
				</div>
			<?php endif ?>

			<form action="" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">

				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<label for="hotel" class="col-lg-3 col-md-4 col-sm-5 col-xs-5 control-label">Hotel</label>
					<div class="col-lg-6 col-md-8 col-sm-8 col-xs-8">
						<select class="form-control unique-plan" name="hotel" id="hotel">
							<option data-company="0" value="">Select Hotel..</option>
							<?php foreach ($hotels as $hotel): ?>
								<option value="<?php echo $hotel['id'] ?>" <?php echo set_select('hotel',$hotel['id'] ); ?>><?php echo $hotel['name'] ?></option>
							<?php endforeach ?>
						</select>
					</div>

				</div>

				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<label for="year" class="col-lg-4 col-md-4 col-sm-4 col-xs-4  control-label">Project Year</label>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<input type="text" class="form-control date unique-plan" name="year" id="year" data-date-format="YYYY-MM" value="<?php echo set_value('year'); ?>"  />
					</div>
					<script type="text/javascript">
					$(function () {
							$('.date').datepicker({
								autoclose: true,
								format: "yyyy",
								viewMode: "years", 
								minViewMode: "years",
								startDate: "1y"

							});
							
					});
					</script>
				</div>
				
				<?php foreach ($devisions as $devKey => $devision): ?>

					<?php if ($devKey != 999): ?>

					<div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12 devision-container"><div class="devision-header-container"><span class="devision-header"><?php echo $devision['name'] ?></span></div>

					<?php endif; ?>
					
					<?php foreach ($devision['departments'] as $department): ?>
						<div><?php echo $department['name'] ?></div>

						<table class="table table-striped table-bordered table-condensed">
							<thead>
								<tr>
									<th>#</th>
									<th>Item</th>
									<th>Quantity</th>
									<th>Estimated Value</th>
									<th>Priority</th>
									<th>Description</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody id="items-container-<?php echo $department['id']; ?>" data-items="0">
							</tbody>
							<tfoot>
								<tr>
									<td colspan="6"></td>
									<td><span class="form-actions btn btn-primary add-item" data-department="<?php echo $department['id']; ?>" >Add Item</span></td>
								</tr>
							</tfoot>
						</table>
					<?php endforeach ?>
					</div>
				<?php endforeach ?>

				<div class="form-group">
				    <div class="col-lg-offset-3 col-lg-10 col-md-10 col-md-offset-3">
				    	<input id="submit" name="submit" value="Save" type="submit" class="btn btn-success submitter" />
				    	<a href="<?= base_url(); ?>plans" class="btn btn-warning">Cancel</a>
				    </div>
				</div>

			</form>
			</fieldset>
		</div>
	</div>
	</div>
	<div class="holder">Please Wait...</div>
</div>
<script id="item-template" type="text/x-handlebars-template">

		<tr id="item-{{department}}-{{id}}">
			<td>
				<span>{{id}}</span>
			</td>
			<td>
				<input type="text" class="form-control" name="items[{{department}}][{{id}}][name]" id="item-{{department}}-{{id}}-name" value="" />
			</td>
			<td>
				<input type="number" class="form-control" name="items[{{department}}][{{id}}][quantity]" id="item-{{department}}-{{id}}-quantity" value="1" />
			</td>
			<td>
				<input type="number" class="form-control" name="items[{{department}}][{{id}}][value]" id="item-{{department}}-{{id}}-value" value="1" />
			</td>
			<td>
				<select class="form-control" name="items[{{department}}][{{id}}][priority_id]" id="item-{{department}}-{{id}}-priority_id">
					<?php foreach ($priorities as $priority): ?>
						<option value="<?php echo $priority['id'] ?>" <?php echo set_select('priority',$priority['id'] ); ?>><?php echo $priority['name'] ?></option>
					<?php endforeach ?>
				</select>
			</td>
			<td>
				<input type="text" class="form-control" name="items[{{department}}][{{id}}][remarks]" id="item-{{department}}-{{id}}-remarks" value="" />
			</td>
			<td>
				<span data-item-id="{{department}}-{{id}}" class="form-actions btn btn-danger remove-item">Remove</span>
			</td>
		</tr>

	</script>
</body>
</html>
