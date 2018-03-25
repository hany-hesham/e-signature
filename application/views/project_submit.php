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
				<legend>Submit project <b><?php echo $project['code']; ?></b></legend>

			<?php if(validation_errors() != false): ?>
				<div class="alert alert-danger">
					<?php echo validation_errors(); ?>
				</div>
			<?php endif ?>

			<form action="" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">

			<input type="hidden" name="hotel_id" id="hotel_id" value="<?php echo $project['hotel_id']; ?>"  />
			<input type="hidden" name="department_id" id="department_id" value="<?php echo $project['department_id']; ?>"  />

				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<label for="hotel" class="col-lg-3 col-md-4 col-sm-5 col-xs-5 control-label">Hotel</label>
					<div class="col-lg-6 col-md-8 col-sm-8 col-xs-8">
						<select class="form-control" name="hotel" id="hotel" disabled="disables">
							<option value="" selected="selected"><?php echo $project['hotel_name'] ?></option>
						</select>
					</div>

				</div>

				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<label for="type" class="col-lg-3 col-md-4 col-sm-5 col-xs-5  control-label">Project Type</label>
					<div class="col-lg-3 col-md-4 col-sm-5 col-xs-5">
						<select class="form-control" name="origin" id="origin" disabled="disabled">
							<option selected="selected"><?php echo $project['origin_name']; ?></option>
						</select>
					</div>
					<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<label for="name" class="col-lg-4 col-md-4 col-sm-4 col-xs-4  control-label">Is this a new equipment?</label>
					<div class="col-lg-3 col-md-4 col-sm-5 col-xs-5">
						<input type="radio" class="" name="new" id="new" value="1" style="width: 15px; height: 15px;" />Yes &nbsp;&nbsp;
						<input type="radio" class="" name="new" id="old" value="0" style="width: 15px; height: 15px;" />No
					</div>
				</div>
					<div class="col-lg-3 col-md-4 col-sm-5 col-xs-5">
						<select class="form-control" name="type" id="type" disabled="disabled">
							<option selected="selected"><?php echo $project['type_name']; ?></option>
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
								startDate: "+0y"

							});
							
					});
					</script>
				</div>
				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<label for="name" class="col-lg-4 col-md-4 col-sm-4 col-xs-4  control-label">Project Name</label>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<input disabled="disabled" type="text" class="form-control" name="name" id="name" value="<?php echo $project['project_name']; ?>"  />
					</div>
				</div>

				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<label for="department" class="col-lg-4 col-md-4 col-sm-4 col-xs-4  control-label">Department</label>
					<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
						<input disabled="disabled" type="text" class="form-control" name="department" id="department" value="<?php echo $project['department_name']; ?>"  />
					</div>
				</div>

				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<label for="reason" class="col-lg-4 col-md-4 col-sm-4 col-xs-4  control-label">Reason for this project</label>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<textarea disabled="disabled" class="form-control" name="reason" id="reason"><?php echo $project['reasons']; ?></textarea>
					</div>
				</div>

				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<label for="scope" class="col-lg-4 col-md-4 col-sm-4 col-xs-4  control-label">Scope of project</label>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<input type="text" class="form-control" name="scope" id="scope" value="<?php echo set_value('scope'); ?>" />
					</div>
				</div>

				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<label for="supplier[]" class="col-lg-3 col-md-4 col-sm-5 col-xs-5 control-label">Suppliers</label>
					<div class="col-lg-6 col-md-8 col-sm-8 col-xs-8">
						<select class="form-control chooosen" name="supplier[]" id="supplier" multiple="multiple" data-placeholder="Select Suppliers...">
							<?php foreach ($suppliers as $supplier): ?>
								<option value="<?php echo $supplier['id'] ?>" <?php echo set_select('supplier',$supplier['id'] ); ?>><?php echo $supplier['name'] ?></option>
							<?php endforeach ?>
						</select>
					</div>
				</div>

				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<label for="supplier[]" class="col-lg-3 col-md-4 col-sm-5 col-xs-5 control-label">Offers</label>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<input id="offers" name="offers" type="file" class="file" multiple="true" data-show-upload="false" data-show-caption="true">
					</div>
					<script>
					$("#offers").fileinput({
					    uploadUrl: "/projects/make_offer/<?php echo $project['id'] ?>", // server upload action
					    uploadAsync: true,
					    minFileCount: 1,
					    maxFileCount: 10,
					    overwriteInitial: false,
					    initialPreview: [
					    <?php foreach($offers as $offer): ?>
					    	"<div class='file-preview-text'>" +
						    "<h2><i class='glyphicon glyphicon-file'></i></h2>" +
						    "<a href='/assets/uploads/files/<?php echo $offer['name'] ?>'><?php echo $offer['name'] ?></a>" + "</div>",
					    <?php endforeach ?>
					    ],
					});
					</script>
				</div>

				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<label for="budget" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label">Exchange Rate</label>
					<label for="budget" class="col-lg-1 col-md-1 col-sm-1 col-xs-1  control-label">USD</label>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<input  type="number" step="any" class="form-control budget-calc cost-calc" name="usd_ex" id="usd_ex" value="<?php echo $project['USD_EX']; ?>" disabled="disabled" />
					</div>
					<label for="budget" class="col-lg-1 col-md-1 col-sm-1 col-xs-1  control-label">EUR</label>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<input  type="number" step="any" class="form-control budget-calc cost-calc" name="eur_ex" id="eur_ex" value="<?php echo $project['EUR_EX']; ?>" disabled="disabled" />
					</div>
				</div>

				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 border"></div>

				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
				
					<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<label for="budget" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label">Estimated Cost</label>
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
							<input readonly="readonly" type="number" step="any" class="form-control" name="budget" id="budget"  disabled="disabled" value="<?php echo $project['budget']; ?>"  />
						</div>
					</div>
	

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"></div>
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 currency-single">
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 currency-single">
							<input  type="number" step="any" class="form-control budget-calc" name="budget_egp" id="budget_egp"  disabled="disabled" value="<?php echo $project['budget_EGP']; ?>"  />
						</div>
						<label for="budget" class="col-lg-4 col-md-4 col-sm-4 col-xs-4 for-currency-single control-label">EGP</label>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 currency-single">
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 currency-single">
							<input  type="number" step="any" class="form-control budget-calc" name="budget_usd" id="budget_usd"  disabled="disabled" value="<?php echo $project['budget_USD']; ?>"  />
						</div>
						<label for="budget" class="col-lg-4 col-md-4 col-sm-4 col-xs-4 for-currency-single control-label">USD</label>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 currency-single">
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 currency-single">
							<input  type="number" step="any" class="form-control budget-calc" name="budget_eur" id="budget_eur"  disabled="disabled" value="<?php echo $project['budget_EUR']; ?>"  />
						</div>
						<label for="budget" class="col-lg-4 col-md-4 col-sm-4 col-xs-4 for-currency-single control-label">EUR</label>
					</div>
				</div>

				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 border"></div>

				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
				
					<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<label for="cost" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label">Final Cost</label>
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
							<input readonly="readonly" type="number" step="any" class="form-control" name="cost" id="cost" value="<?php echo set_value('cost'); ?>"  />
						</div>
					</div>


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"></div>
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 currency-single">
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 currency-single">
							<input  type="number" step="any" class="form-control cost-calc" name="cost_egp" id="cost_egp" value="<?php echo set_value('cost_egp'); ?>"  />
						</div>
						<label for="cost" class="col-lg-4 col-md-4 col-sm-4 col-xs-4 for-currency-single control-label">EGP</label>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 currency-single">
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 currency-single">
							<input  type="number" step="any" class="form-control cost-calc" name="cost_usd" id="cost_usd" value="<?php echo set_value('cost_usd'); ?>"  />
						</div>
						<label for="cost" class="col-lg-4 col-md-4 col-sm-4 col-xs-4 for-currency-single control-label">USD</label>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 currency-single">
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 currency-single">
							<input  type="number" step="any" class="form-control cost-calc" name="cost_eur" id="cost_eur" value="<?php echo set_value('cost_eur'); ?>"  />
						</div>
						<label for="cost" class="col-lg-4 col-md-4 col-sm-4 col-xs-4 for-currency-single control-label">EUR</label>
					</div>
				</div>

				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 border"></div>

				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<label for="start-date" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label">Time Schedule</label>
					<label for="start-date" class="col-lg-1 col-md-1 col-sm-1 col-xs-1  control-label">Start</label>
					<div class="col-lg-3 col-md-4 col-sm-4 col-xs-4">
						<input type="text" class="form-control datetime" name="start-date" id="start-date" data-date-format="YYYY-MM-DD" value="<?php echo set_value('start-date'); ?>" />
					</div>
					<label for="end-date" class="col-lg-1 col-md-1 col-sm-1 col-xs-1  control-label">End</label>
					<div class="col-lg-3 col-md-4 col-sm-4 col-xs-4">
						<input type="text" class="form-control datetime" name="end-date" id="end-date" data-date-format="YYYY-MM-DD" value="<?php echo set_value('end-date'); ?>" />
					</div>
					<script type="text/javascript">
					$(function () {
							$('.datetime').datetimepicker({
								autoclose: true,
								pickTime: false,

							});

							$("#start-date").on("dp.change",function (e) {
					           $('#end-date').data("DateTimePicker").setMinDate(e.date);
					        });
					        $("#end-date").on("dp.change",function (e) {
					           $('#start-date').data("DateTimePicker").setMaxDate(e.date);
					        });
							
					});
					</script>
				</div>

				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<label for="remarks" class="col-lg-4 col-md-4 col-sm-4 col-xs-4  control-label">Remarks</label>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<textarea class="form-control" name="remarks" id="remarks"><?php echo (set_value('remarks') != null)? set_value('remarks') : $project['remarks']; ?></textarea>
					</div>
				</div>
	
				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
				    <div class="col-lg-offset-3 col-lg-10 col-md-10 col-md-offset-3">
				    	<input name="submit" value="Submit" type="submit" class="btn btn-success submitter" />
				    	<a href="/requests/view/<?php echo $project['id']; ?>" class="btn btn-warning">Cancel</a>
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
