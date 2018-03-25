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
			<legend>Submit a new form</legend>

			<?php if(validation_errors() != false): ?>
				<div class="alert alert-danger">
					<?php echo validation_errors(); ?>
				</div>
			<?php endif ?>

			<form action="" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">

				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label">From Hotel</label>
					<div class="col-lg-3 col-md-4 col-sm-4 col-xs-4">
						<select class="form-control" name="from-hotel" id="from-hotel">
							<option data-company="0" value="">Select Hotel..</option>
							<?php foreach ($hotels as $hotel): ?>
								<option data-company="<?php echo $hotel['company_id']; ?>" value="<?php echo $hotel['id'] ?>" <?php echo set_select('from-hotel',$hotel['id'] ); ?>><?php echo $hotel['name'] ?></option>
							<?php endforeach ?>
						</select>
					</div>

					<label for="to-hotel" class="col-lg-offset-2 col-md-offset-0 col-sm-offset col-xs-offset-0 col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label">To Hotel</label>
					<div class="col-lg-3 col-md-4 col-sm-4 col-xs-4">
						<select class="form-control" name="to-hotel" id="to-hotel">
							<option data-company="0" value="">Select Hotel..</option>
							<?php foreach ($hotels as $hotel): ?>
								<option data-company="<?php echo $hotel['company_id']; ?>" value="<?php echo $hotel['id']; ?>" <?php echo set_select('to-hotel', $hotel['id']) ?>><?php echo $hotel['name'] ?></option>
							<?php endforeach ?>
						</select>
					</div>
				</div>

			 <?php if($role_id ==111) :?>
				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label">From Hotel</label>
					<div class="col-lg-3 col-md-4 col-sm-4 col-xs-4">
						<select class="form-control" name="from_hotel_owning" id="from-hotel">
							<option data-company="0" value="">Select company..</option>
								<?php foreach ($companies as $company): ?>
								<option value="<?php echo $company['id']; ?>"><?php echo $company['name']; ?></option>
							<?php endforeach; ?>
						</select>
					</div>

					<label for="to-hotel" class="col-lg-offset-2 col-md-offset-0 col-sm-offset col-xs-offset-0 col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label">To Hotel</label>
					<div class="col-lg-3 col-md-4 col-sm-4 col-xs-4">
						<select class="form-control" name="to_hotel_owning" id="to-hotel">
							<option data-company="0" value="">Select company..</option>
								<?php foreach ($companies as $company): ?>
								<option value="<?php echo $company['id']; ?>"><?php echo $company['name']; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
		    <?php elseif($role_id !=111) :?>
				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
				

					<label for="from_company" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label">Owning Co.</label>
					<div class="col-lg-3 col-md-4 col-sm-4 col-xs-4">
						<select disabled="dissabled" class="form-control" name="from-company" id="from-company">
							<option value="">Select Hotel..</option>
							<?php foreach ($companies as $company): ?>
								<option value="<?php echo $company['id']; ?>"><?php echo $company['name']; ?></option>
							<?php endforeach; ?>
						</select>
					</div>

					<label for="to_company" class="col-lg-offset-2 col-md-offset-0 col-sm-offset col-xs-offset-0 col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label">Owning Co.</label>
					<div class="col-lg-3 col-md-4 col-sm-4 col-xs-4">
						<select disabled="dissabled" class="form-control" name="to-company" id="to-company">
							<option value="">Select Hotel..</option>
							<?php foreach ($companies as $company): ?>
								<option value="<?php echo $company['id'] ?>"><?php echo $company['name'] ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
             <?php endif?>
				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<label for="issue-date" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label">Issue Date</label>
					<div class="col-lg-3 col-md-4 col-sm-4 col-xs-4">
						<input type="text" class="form-control datetime" name="issue-date" id="issue-date" data-date-format="YYYY-MM-DD" value="<?php echo set_value('issue-date'); ?>"></input>
					</div>

					<label for="delivery-date" class="col-lg-offset-2 col-md-offset-0 col-sm-offset col-xs-offset-0 col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label">Delivery Date</label>
					<div class="col-lg-3 col-md-4 col-sm-4 col-xs-4">
						<input type="text" class="form-control datetime" name="delivery-date" id="delivery-date" data-date-format="YYYY-MM-DD" value="<?php echo set_value('delivery-date') ?>"></input>
					</div>
					<script type="text/javascript">
					$(function () {
							$('.datetime').datetimepicker({
								autoclose: true,
								pickTime: false,

							});

							$("#issue-date").on("dp.change",function (e) {
					           $('#delivery-date').data("DateTimePicker").setMinDate(e.date);
					        });
					        $("#delivery-date").on("dp.change",function (e) {
					           $('#issue-date').data("DateTimePicker").setMaxDate(e.date);
					        });
							
					});
					</script>
				</div>
				

				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<label for="request-department" class="col-lg-3 col-md-4 col-sm-5 col-xs-5  control-label">Department requested</label>
					<div class="col-lg-3 col-md-4 col-sm-5 col-xs-5">
						<select class="form-control" name="request-department" id="request-department">
							<option value="">Select Department..</option>
							<?php foreach ($departments as $department): ?>
								<option value="<?php echo $department['id'] ?>"<?php echo set_select('request-department', $department['id']); ?>><?php echo $department['name']; ?></option>
							<?php endforeach ?>
						</select>
					</div>
				</div>

				<table class="table table-striped table-bordered table-condensed">
					<thead>
						<tr>
							<th>#</th>
							<th>Item Name</th>
							<th>Description</th>
							<th>quantity</th>
							<th>actoins</th>
						</tr>
					</thead>
					<tbody id="items-container" data-items="1">
						<tr id="item-1">
							<td>
								<span>1</span>
							</td>
							<td>
								<input type="text" class="form-control" name="items[1][name]" id="item-1-name" value="" ></input>
							</td>
							<td>
								<input type="text" class="form-control" name="items[1][description]" id="item-1-description" value="" ></input>
							</td>
							<td>
								<input type="number" class="form-control" name="items[1][quantity]" id="item-1-quantity" value="1" ></input>
							</td>
							<td>
								<span data-item-id="1" class="form-actions btn btn-danger remove-item">Remove</span>
							</td>
						</tr>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="4">
							<td><span class="form-actions btn btn-primary" id="add-item">Add Item</span></td>
						</tr>
					</tfoot>
				</table>
				<script type="text/javascript">
				document.items = <?php echo json_encode($this->input->post('items')); ?>;
				</script>

				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<label for="present-location" class="col-lg-4 col-md-4 col-sm-4 col-xs-4  control-label">Present Location</label>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<input type="text" class="form-control" name="present-location" id="present-location" value="<?php echo set_value('present-location'); ?>" ></input>
					</div>
				</div>

				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<label for="movement-reason" class="col-lg-4 col-md-4 col-sm-4 col-xs-4  control-label">Reason for movement</label>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<textarea class="form-control" name="movement-reason" id="movement-reason"><?php echo set_value('movement-reason'); ?></textarea>
					</div>
				</div>

				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<label for="movement-reason" class="col-lg-6 col-md-6 col-sm-6 col-xs-6  control-label">What Will Happen To Old Item After Movement</label>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<textarea class="form-control" name="old-reason" id="movement-reason"><?php echo set_value('old-reason'); ?></textarea>
					</div>
				</div>

				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<label for="new-location" class="col-lg-4 col-md-4 col-sm-4 col-xs-4  control-label">New Location</label>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<input type="text" class="form-control" name="new-location" id="new-location" value="<?php echo set_value('new-location'); ?>" ></input>
					</div>
				</div>

				
				<div class="form-group">
				    <div class="col-lg-offset-3 col-lg-10 col-md-10 col-md-offset-3">
				    	<input name="submit" value="Submit" type="submit" class="btn btn-success"></input>
				    	<a href="<?= base_url(); ?>forms" class="btn btn-warning">Cancel</a>
				    </div>
				</div>

			</form>
			</fieldset>
		</div>
	</div>
	<script id="item-template" type="text/x-handlebars-template">
		<tr id="item-{{id}}">
			<td>
				<span>{{id}}</span>
			</td>
			<td>
				<input type="text" class="form-control" name="items[{{id}}][name]" id="item-{{id}}-name" value="{{name}}" ></input>
			</td>
			<td>
				<input type="text" class="form-control" name="items[{{id}}][description]" id="item-{{id}}-description" value="{{description}}" ></input>
			</td>
			<td>
				<input type="number" class="form-control" name="items[{{id}}][quantity]" id="item-{{id}}-quantity" value="{{quantity}}" ></input>
			</td>
			<td>
				<span data-item-id="{{id}}" class="form-actions btn btn-danger remove-item">Remove</span>
			</td>
		</tr>
	</script>
	</div>
</div>
</body>
</html>