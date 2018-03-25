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
							<legend>Submit planned project</legend>
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
											<option value="<?php echo $hotel['id']; ?>" selected="selected"><?php echo $hotel['name'] ?></option>
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
									<label for="year" class="col-lg-3 col-md-4 col-sm-5 col-xs-5  control-label">Project Year</label>
									<div class="col-lg-6 col-md-8 col-sm-8 col-xs-8">
										<input type="text" class="form-control date unique-plan" name="year" id="year" readonly="readonly" value="<?php echo $year; ?>"  />
									</div>
								</div>
								<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<label for="name" class="col-lg-3 col-md-4 col-sm-5 col-xs-5  control-label">Project Name</label>
									<div class="col-lg-6 col-md-8 col-sm-8 col-xs-8">
										<input type="text" class="form-control" name="name" id="name" value="<?php echo set_value('name'); ?>"  />
									</div>
								</div>
								<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<label for="department" class="col-lg-3 col-md-4 col-sm-5 col-xs-5 control-label">department</label>
									<div class="col-lg-6 col-md-8 col-sm-8 col-xs-8">
										<select class="form-control" name="department" id="department" readonly="readonly">
											<option value="<?php echo $department['id']; ?>" selected="selected"><?php echo $department['name'] ?></option>
										</select>
									</div>
								</div>
								<div>
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
													<td>
														<select data-value="<?php echo $item['value']; ?>" class="item-quantity" name="item[<?php echo $item['id'] ?>]">
															<?php for ($i=1; $i <= $item['remaining']; $i++): ?>
																<option <?php echo ($i == $item['remaining'])? 'selected="selected"' : '' ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
															<?php endfor; ?>
														</select>
													</td>
													<td class="item-value" data-value="<?php echo $item['value']; ?>" class="align-right"><?php echo $item['remaining']*$item['value']; ?> EGP</td>
												</tr>
											<?php endforeach ?>
										</tbody>
									</table>
						 <?php  $url = $_SERVER['REQUEST_URI'];
			              $url = explode('/', $url);
			             $lastPart = array_pop($url);?>
			               <?php if($lastPart!=1) :?>
			                   <a href="<?php echo base_url();?>projects/new_url" class="btn btn-success""> Replace Item</a>
			                <?php endif;?>
			                <br>
			                <br>
						    <?php if($lastPart==1) :?>			
	                          <div id="replace">
										<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
											<label for="department" class="col-lg-3 col-md-4 col-sm-5 col-xs-5 control-label">Department</label>
											<div class="col-lg-6 col-md-8 col-sm-8 col-xs-8">
											  <select class="form-control" name="replaces[1][department_id]" id="department" required>
													<option data-company="0" value="">Select Department..</option>
													<?php foreach ($departments as $department): ?>
														<option value="<?php echo $department['id'] ?>" <?php echo set_select('department',$department['id'] ); ?>><?php echo $department['name'] ?></option>
													<?php endforeach ?>
												</select>
											</div>
							 		      </div>
						              <div class="form-group col-lg-10 col-md-10 col-sm-10 col-xs-10">
					                     <br>
					                    <table class="table table-striped table-bordered table-condensed">
					                      <thead>
					                        <tr>
					                          <th colspan="1" style=" text-align: center;">Item</th>
					                          <th colspan="1" style=" text-align: center;">Quantity</th>
					                          <th colspan="1" style=" text-align: center;"> Total Value</th>
					                         <!--  <th colspan="1" style=" text-align: center;">Total Value</th> -->
					                        </tr>
					                      </thead>
					                      <tbody id="replaces-container" data-replace="1">
					                      	<?php $i=0;?>
					                      	<?php foreach ($items as $item): ?>
						                        <tr id="replace-1">
						                          <td class="centered"> 
						                            <input type="text" class="form-control" name="replaces[<?php echo $i?>][name]"  id="replace-1-name"/></input>
						                          </td>
						                          <td id="x" class="centered"> 
						                            <input type="number" class="form-control" name="replaces[<?php echo $i?>][quantity]"  id="replace-1-quantity"/></input>
						                          </td>
						                          <td id="y" class="centered"> 
						                           <input type="number" class="form-control" name="replaces[<?php echo $i?>][value]"  id="replace-1-value" max="<?php echo $item['remaining']*$item['value']; ?>" /></input>
						                          </td>
						                          <td  class="centered"> 
						                         <!--  	<input id="sum" readonly="readonly" type="number" step="any" class="form-control" name="cost" id="cost" value="sum"  /> -->
						                          </td>
						                        </tr>
						                        <?php $i++;?>
						                    <?php endforeach ?>
					                      </tbody>
					                    </table>    
					                  </div>
								</div>
                               </div>
                              <?php endif; ?>
								<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<label for="reason" class="col-lg-4 col-md-4 col-sm-4 col-xs-4  control-label">Reason for this project</label>
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<textarea class="form-control" name="reason" id="reason"></textarea>
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
												<option value="<?php echo $supplier['id'] ?>" <?php echo set_select('supplier[]',$supplier['id'] ); ?>><?php echo $supplier['name'] ?></option>
											<?php endforeach ?>
										</select>
									</div>
								</div>
								<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<input type="hidden" name="assumed_code" value="<?php echo $assumed_code ?>" />
									<label for="offers" class="col-lg-3 col-md-4 col-sm-5 col-xs-5 control-label">Offers</label>
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<input id="offers" name="offers" type="file" class="file" multiple="true" data-show-upload="false" data-show-caption="true">
									</div>
									<script>
										$("#offers").fileinput({
										    uploadUrl: "/projects/make_offer/<?php echo $assumed_code ?>/0",
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
										<input  type="number" step="any" class="form-control cost-calc" name="usd_ex" id="usd_ex" value="<?php echo set_value('usd_ex'); ?>" />
									</div>
									<label for="budget" class="col-lg-1 col-md-1 col-sm-1 col-xs-1  control-label">EUR</label>
									<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
										<input  type="number" step="any" class="form-control cost-calc" name="eur_ex" id="eur_ex" value="<?php echo set_value('eur_ex'); ?>" />
									</div>
								</div>
								<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<label for="budget" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label">Budget Cost</label>
										<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
											<input readonly="readonly" type="number" step="any" class="form-control" name="budget" id="budget" value="<?php echo set_value('budget'); ?>"  />
										</div>
									</div>
								</div>
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
								</div>
								<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<label for="remarks" class="col-lg-4 col-md-4 col-sm-4 col-xs-4  control-label">Remarks</label>
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<textarea class="form-control" name="remarks" id="remarks"><?php echo set_value('remarks'); ?></textarea>
									</div>
								</div>
								<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
								    <div class="col-lg-offset-3 col-lg-10 col-md-10 col-md-offset-3">
								    	<input name="submit" value="Submit" type="submit" class="btn btn-success submitter" />
								    	<a href="/projects ?>" class="btn btn-warning">Cancel</a>
								    </div>
								</div>
							</form>
						</fieldset>
					</div>
				</div>
			</div>
			
		</div>
		<script type="text/javascript">
			$(document).ready(function(){
				calculte_items();
			});
		</script>
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
