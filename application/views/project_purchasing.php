<?php 
	function array_assoc_value_exists($arr, $index, $search) {
		foreach ($arr as $key => $value) {
			if ($value[$index] == $search) {
				return TRUE;
			}
		}
		return FALSE;
	}
?>
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
							<form action="" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
								<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<label for="hotel" class="col-lg-3 col-md-4 col-sm-5 col-xs-5 control-label">Hotel</label>
									<div class="col-lg-6 col-md-8 col-sm-8 col-xs-8">
										<select class="form-control" name="hotel" id="hotel" readonly="readonly">
											<option selected="selected"><?php echo $project['hotel_name'] ?></option>
										</select>
									</div>
								</div>
								<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<label for="type" class="col-lg-3 col-md-4 col-sm-5 col-xs-5  control-label">Project Type</label>
									<div class="col-lg-3 col-md-4 col-sm-5 col-xs-5">
										<select disabled="disabled" class="form-control" name="type" id="type">
											<option><?php echo $project['type_name']; ?></option>
										</select>
									</div>
								</div>
								<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<label for="year" class="col-lg-3 col-md-4 col-sm-5 col-xs-5  control-label">Project Year</label>
									<div class="col-lg-6 col-md-8 col-sm-8 col-xs-8">
										<input type="text" class="form-control date unique-plan" name="year" id="year" readonly="readonly" value="<?php echo $project['year']; ?>"  />
									</div>
								</div>
								<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<label for="name" class="col-lg-3 col-md-4 col-sm-5 col-xs-5  control-label">Project Name</label>
									<div class="col-lg-6 col-md-8 col-sm-8 col-xs-8">
										<input disabled="disabeld" type="text" class="form-control" name="name" id="name" value="<?php echo $project['project_name']; ?>"  />
									</div>
								</div>
								<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<label for="department" class="col-lg-3 col-md-4 col-sm-5 col-xs-5 control-label">department</label>
									<div class="col-lg-6 col-md-8 col-sm-8 col-xs-8">
										<select class="form-control" name="department" id="department" readonly="readonly">
											<option value="" selected="selected"><?php echo $project['department_name']; ?></option>
										</select>
									</div>
								</div>
								<?php if ($project['origin_id'] == 2): ?>
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher data-indention">
										<table class="table table-striped table-bordered table-condensed">
											<thead>
												<tr>
													<th>Item</th>
													<th>Quantity</th>
													<th>Total Value</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($items as $item): ?>
													<tr class="item-row">
														<td><?php echo $item['name'] ?></td>
														<td><?php echo $item['quantity'] ?></td>
														<td class="item-value" data-value="<?php echo $item['value']; ?>" class="align-right"><?php echo $item['quantity']*$item['value']; ?> EGP</td>
													</tr>
												<?php endforeach ?>
											</tbody>
										</table>
									</div>
								<?php endif ?>
								<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<label for="reason" class="col-lg-4 col-md-4 col-sm-4 col-xs-4  control-label">Reason for this project</label>
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<textarea disabled="disabled" class="form-control" name="reason" id="reason"><?php echo $project['reasons']; ?></textarea>
									</div>
								</div>
								<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<label for="scope" class="col-lg-4 col-md-4 col-sm-4 col-xs-4  control-label">Scope of project</label>
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<input disabled="disabled" type="text" class="form-control" name="scope" id="scope" value="<?php echo $project['scope']; ?>" />
									</div>
								</div>
								<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<label for="supplier[]" class="col-lg-3 col-md-4 col-sm-5 col-xs-5 control-label">Suppliers</label>
									<div class="col-lg-6 col-md-8 col-sm-8 col-xs-8">
										<select class="form-control chooosen" name="supplier[]" id="supplier" multiple="multiple" data-placeholder="Select Suppliers...">
											<?php foreach ($suppliers as $supplier): ?>
												<option value="<?php echo $supplier['id'] ?>" <?php echo (array_assoc_value_exists($selected_suppliers, 'id', $supplier['id']))? 'selected="selected"' : set_select('supplier[]',$supplier['id'] ); ?>><?php echo $supplier['name'] ?></option>
											<?php endforeach ?>
										</select>
									</div>
								</div>
								<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<input type="hidden" name="code" value="<?php echo $project['code']; ?>" />
									<label for="offers" class="col-lg-3 col-md-4 col-sm-5 col-xs-5 control-label">Offers</label>
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<input id="offers" name="offers" type="file" class="file" multiple="true" data-show-upload="false" data-show-caption="true">
									</div>
									<script>
										$("#offers").fileinput({
										    uploadUrl: "/projects/make_offer/<?php echo $project['id'] ?>/<?php echo $project['change_amend'] ?>",
										    uploadAsync: true,
										    minFileCount: 1,
										    maxFileCount: 5,
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
										<input  type="number" step="any" class="form-control budget-calc cost-calc" name="usd_ex" id="usd_ex" value="<?php echo $project['USD_EX']; ?>" readonly="readonly" />
									</div>
									<label for="budget" class="col-lg-1 col-md-1 col-sm-1 col-xs-1  control-label">EUR</label>
									<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
										<input  type="number" step="any" class="form-control budget-calc cost-calc" name="eur_ex" id="eur_ex" value="<?php echo $project['EUR_EX']; ?>" readonly="readonly" />
									</div>
								</div>
								<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<label for="budget" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label">Budget Cost</label>
										<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
											<input readonly="readonly" type="number" step="any" class="form-control" name="budget" id="budget" value="<?php echo $project['budget']; ?>"  />
										</div>
									</div>
								</div>
								<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<label for="cost" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label">Final Cost</label>
										<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
											<input readonly="readonly" type="number" step="any" class="form-control" name="cost" id="cost" value="<?php echo $project['cost']; ?>"  />
										</div>
									</div>
									<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"></div>
									<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 currency-single">
										<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 currency-single">
											<input  type="number" step="any" class="form-control cost-calc" name="cost_egp" id="cost_egp" value="<?php echo $project['cost_EGP']; ?>"  />
										</div>
										<label for="cost" class="col-lg-4 col-md-4 col-sm-4 col-xs-4 for-currency-single control-label">EGP</label>
									</div>
									<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 currency-single">
										<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 currency-single">
											<input  type="number" step="any" class="form-control cost-calc" name="cost_usd" id="cost_usd" value="<?php echo $project['cost_USD']; ?>"  />
										</div>
										<label for="cost" class="col-lg-4 col-md-4 col-sm-4 col-xs-4 for-currency-single control-label">USD</label>
									</div>
									<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 currency-single">
										<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 currency-single">
											<input  type="number" step="any" class="form-control cost-calc" name="cost_eur" id="cost_eur" value="<?php echo $project['cost_EUR']; ?>"  />
										</div>
										<label for="cost" class="col-lg-4 col-md-4 col-sm-4 col-xs-4 for-currency-single control-label">EUR</label>
									</div>
								</div>
								<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<label for="start-date" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label">Time Schedule</label>
									<label for="start-date" class="col-lg-1 col-md-1 col-sm-1 col-xs-1  control-label">Start</label>
									<div class="col-lg-3 col-md-4 col-sm-4 col-xs-4">
										<input disabled="disabled" type="text" class="form-control datetime" name="start-date" id="start-date" data-date-format="YYYY-MM-DD" value="<?php echo $project['start']; ?>" />
									</div>
									<label for="end-date" class="col-lg-1 col-md-1 col-sm-1 col-xs-1  control-label">End</label>
									<div class="col-lg-3 col-md-4 col-sm-4 col-xs-4">
										<input disabled="disabled" type="text" class="form-control datetime" name="end-date" id="end-date" data-date-format="YYYY-MM-DD" value="<?php echo $project['end']; ?>" />
									</div>
								</div>
								<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<label for="remarks" class="col-lg-4 col-md-4 col-sm-4 col-xs-4  control-label">Remarks</label>
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<textarea disabled="disabled" class="form-control" name="remarks" id="remarks"><?php echo $project['remarks']; ?></textarea>
									</div>
								</div>
								<div class="form-group">
								    <div class="col-lg-offset-3 col-lg-10 col-md-10 col-md-offset-3">
								    	<input name="submit" value="Submit" type="submit" class="btn btn-success submitter" />
								    	<a href="<?= base_url(); ?>forms" class="btn btn-warning">Cancel</a>
								    </div>
								</div>
							</form>
						</fieldset>
					</div>
				</div>
			</div>
			<div class="holder">Please Wait...</div>
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
	</body>
</html>
