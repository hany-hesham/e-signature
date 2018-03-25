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
								<?php if ($project['change_amend'] == 1):?>
									<input type="text" name="id" style="display: none;" value="<?php echo $project_change['id']; ?>"  />
								<?php endif; ?>
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
										<select class="form-control" name="type" id="type">
											<?php if ($project['change_amend'] == 0): ?>
												<?php foreach ($types as $type): ?>
													<option value="<?php echo $type['id'] ?>" <?php echo ($type['id'] == $project['type_id'])? 'selected="selected"' : '' ?>><?php echo $type['name']; ?></option>
												<?php endforeach ?>
											<?php elseif ($project['change_amend'] == 1): ?>
												<option selected="selected"><?php echo $project['type_name'] ?></option>
											<?php endif; ?>
										</select>
									</div>
								</div>
								<?php if ($project['change_amend'] == 0): ?>
									<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<label for="name" class="col-lg-4 col-md-4 col-sm-4 col-xs-4  control-label">Is this a new equipment?</label>
										<div class="col-lg-3 col-md-4 col-sm-5 col-xs-5">
											<input type="radio" class="" name="new" id="new" value="1" <?php echo ($project['new'] == 1)? "checked": ""; ?> style="width: 15px; height: 15px;" />Yes &nbsp;&nbsp;
											<input type="radio" class="" name="new" id="old" value="0" <?php echo ($project['new'] == 0)? "checked": ""; ?> style="width: 15px; height: 15px;" />No
										</div>
									</div>
								<?php endif; ?>
								<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<label for="year" class="col-lg-3 col-md-4 col-sm-5 col-xs-5  control-label">Project Year</label>
									<div class="col-lg-6 col-md-8 col-sm-8 col-xs-8">
										<input type="text" class="form-control date unique-plan" name="year" id="year" readonly="readonly" value="<?php echo $project['year']; ?>"  />
									</div>
								</div>
								<?php if ($role_id == 4 && $project['change_amend'] == 0): ?>
									<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<label class="col-lg-4 col-md-4 col-sm-4 col-xs-4  control-label">Charge To:</label>
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
											<select class="form-control chooosen" data-placeholder="Charge ..." name="charge" style="width: 200px; height:33px;">
							                    <option value="<?php if($project['charge']): ?> <?php echo $project['charge']; ?> <?php endif;?>"><?php if($project['charge']): ?> <?php echo $project['charge']; ?> <?php endif;?></option>
							                    <option value="Operation">Operation</option>
							                    <option value="Assets">Assets</option>
							                </select>
										</div>
									</div>
									<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<label class="col-lg-4 col-md-4 col-sm-4 col-xs-4  control-label">Project Life Time:</label>
										<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
											<label class="col-lg-4 col-md-4 col-sm-4 col-xs-4  control-label">Years:</label>
											<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
												<select class="form-control chooosen" data-placeholder="Years ..." name="life_year" style="width: 200px; height:33px;">
									                   <option value="<?php if($project['life_year']): ?> <?php echo $project['life_year']; ?> <?php endif;?>"><?php if($project['life_year']): ?> <?php echo $project['life_year']; ?> <?php endif;?></option>
									                   <option value="1">1</option>
									                   <option value="2">2</option>
									                   <option value="3">3</option>
									                   <option value="4">4</option>
									                   <option value="5">5</option>
									                   <option value="6">6</option>
									                   <option value="7">7</option>
									                   <option value="8">8</option>
									                   <option value="9">9</option>
									               </select>
											</div>
										</div>
										<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
											<label class="col-lg-4 col-md-4 col-sm-4 col-xs-4  control-label">Monthes:</label>
											<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
												<select class="form-control chooosen" data-placeholder="Monthes ..." name="life_month" style="width: 200px; height:33px;">
								                    <option value="<?php if($project['life_month']): ?> <?php echo $project['life_month']; ?> <?php endif;?>"><?php if($project['life_month']): ?> <?php echo $project['life_month']; ?> <?php endif;?></option>
								                    <option value="1">1</option>
								                    <option value="2">2</option>
								                    <option value="3">3</option>
								                    <option value="4">4</option>
								                    <option value="5">5</option>
								                    <option value="6">6</option>
								                    <option value="7">7</option>
								                    <option value="8">8</option>
								                    <option value="9">9</option>
								                    <option value="10">10</option>
								                    <option value="11">11</option>
								                </select>
											</div>
										</div>
									</div>
								<?php endif; ?>
								<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<label for="name" class="col-lg-3 col-md-4 col-sm-5 col-xs-5  control-label">Project Name</label>
									<div class="col-lg-6 col-md-8 col-sm-8 col-xs-8">
										<input type="text" class="form-control" name="name" id="name" value="<?php echo ($project['change_amend'] == 0)? $project['project_name'] : $project_change['project_name']; ?>"  />
									</div>
								</div>
								<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<label for="department" class="col-lg-3 col-md-4 col-sm-5 col-xs-5 control-label">Department</label>
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

                                <?php if ($project['origin_id'] == 2  && $project['replaced']==1): ?>
                                	<p style="text-align: center;color: red; font-size: 16px;">Replaced With:</p>
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
												<?php foreach ($project_replace_items as $item): ?>
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
										<textarea class="form-control" name="reason" id="reason"><?php echo ($project['change_amend'] == 0)? $project['reasons']: $project_change['reasons']; ?></textarea>
									</div>
								</div>
								<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<label for="scope" class="col-lg-4 col-md-4 col-sm-4 col-xs-4  control-label">Scope of project</label>
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<input type="text" class="form-control" name="scope" id="scope" value="<?php echo ($project['change_amend'] == 0)? $project['scope']: $project_change['scope']; ?>" />
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
					    					initialPreviewConfig: [
											    <?php foreach($offers as $offer): ?>
											        {url: "/projects/remove_offer/<?php echo $project['id'] ?>/<?php echo $offer['id'] ?>", key: "<?php echo $offer['name']; ?>"},
											    <?php endforeach; ?>
										    ],
										});
									</script>
								</div>
								<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<label for="budget" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label">Exchange Rate</label>
									<label for="budget" class="col-lg-1 col-md-1 col-sm-1 col-xs-1  control-label">USD</label>
									<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
										<input  type="number" step="any" class="form-control budget-calc cost-calc" name="usd_ex" id="usd_ex" value="<?php echo ($project['change_amend'] == 0)? $project['USD_EX']: $project_change['USD_EX']; ?>" readonly="readonly" />
									</div>
									<label for="budget" class="col-lg-1 col-md-1 col-sm-1 col-xs-1  control-label">EUR</label>
									<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
										<input  type="number" step="any" class="form-control budget-calc cost-calc" name="eur_ex" id="eur_ex" value="<?php echo ($project['change_amend'] == 0)? $project['EUR_EX']: $project_change['EUR_EX']; ?>" readonly="readonly" />
									</div>
								</div>
								<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<label for="budget" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label">Budget Cost</label>
										<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
											<input readonly="readonly" type="number" step="any" class="form-control" name="budget" id="budget" value="<?php echo ($project['change_amend'] == 0)? $project['budget']: $project_change['budget']; ?>"  />
										</div>
									</div>
								</div>
								<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<label for="cost" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label">Final Cost</label>
										<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
											<input readonly="readonly" type="number" step="any" class="form-control" name="cost" id="cost" value="<?php echo ($project['change_amend'] == 0)? $project['cost']: $project_change['cost']; ?>"  />
										</div>
									</div>
									<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"></div>
									<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 currency-single">
										<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 currency-single">
											<input  type="number" step="any" class="form-control cost-calc" name="cost_egp" id="cost_egp" value="<?php echo ($project['change_amend'] == 0)? $project['cost_EGP']: $project_change['cost_EGP']; ?>"  />
										</div>
										<label for="cost" class="col-lg-4 col-md-4 col-sm-4 col-xs-4 for-currency-single control-label">EGP</label>
									</div>
									<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 currency-single">
										<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 currency-single">
											<input  type="number" step="any" class="form-control cost-calc" name="cost_usd" id="cost_usd" value="<?php echo ($project['change_amend'] == 0)? $project['cost_USD']: $project_change['cost_USD']; ?>"  />
										</div>
										<label for="cost" class="col-lg-4 col-md-4 col-sm-4 col-xs-4 for-currency-single control-label">USD</label>
									</div>
									<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 currency-single">
										<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 currency-single">
											<input  type="number" step="any" class="form-control cost-calc" name="cost_eur" id="cost_eur" value="<?php echo ($project['change_amend'] == 0)? $project['cost_EUR']: $project_change['cost_EUR']; ?>"  />
										</div>
										<label for="cost" class="col-lg-4 col-md-4 col-sm-4 col-xs-4 for-currency-single control-label">EUR</label>
									</div>
								</div>
								<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<label for="start-date" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label">Time Schedule</label>
									<label for="start-date" class="col-lg-1 col-md-1 col-sm-1 col-xs-1  control-label">Start</label>
									<div class="col-lg-3 col-md-4 col-sm-4 col-xs-4">
										<input type="text" class="form-control datetime" name="start-date" id="start-date" data-date-format="YYYY-MM-DD" value="<?php echo ($project['change_amend'] == 0)? $project['start']: $project_change['start']; ?>" />
									</div>
									<label for="end-date" class="col-lg-1 col-md-1 col-sm-1 col-xs-1  control-label">End</label>
									<div class="col-lg-3 col-md-4 col-sm-4 col-xs-4">
										<input type="text" class="form-control datetime" name="end-date" id="end-date" data-date-format="YYYY-MM-DD" value="<?php echo ($project['change_amend'] == 0)? $project['end']: $project_change['end']; ?>" />
									</div>
								</div>
								<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<label for="remarks" class="col-lg-4 col-md-4 col-sm-4 col-xs-4  control-label">Remarks</label>
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<textarea class="form-control" name="remarks" id="remarks"><?php echo ($project['change_amend'] == 0)? $project['remarks']: $project_change['remarks']; ?></textarea>
									</div>
								</div>
								<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
								    <div class="col-lg-offset-3 col-lg-10 col-md-10 col-md-offset-3">
								    	<input name="submit" value="Save" type="submit" class="btn btn-success submitter" />
								    	<a href="/projects/view/<?php echo $project['code'] ?>" class="btn btn-warning">Cancel</a>
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
