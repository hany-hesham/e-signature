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

			<form action="" method="POST" id="form-submit" enctype="multipart/form-data" class="form-div span12" accept-charset="utf-8">

				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label">Hotel</label>
					<div class="col-lg-3 col-md-4 col-sm-4 col-xs-4">
						<select class="form-control" name="from-hotel" id="from-hotel">
							<option data-company="0" value="">Select Hotel..</option>
							<?php foreach ($hotels as $hotel): ?>
								<option value="<?php echo $hotel['id'] ?>" <?php echo set_select('from-hotel',$hotel['id'] ); ?>><?php echo $hotel['name'] ?></option>
							<?php endforeach ?>
						</select>
					</div>
                                        
<!--                     <label for="workshop_name" class="col-lg-offset-2 col-md-offset-0 col-sm-offset col-xs-offset-0 col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label">Work Shop Name</label>
					<div class="col-lg-3 col-md-4 col-sm-4 col-xs-4">
						<input type="text" class="form-control" name="workshop_name" id="workshop_name" value="General" />
					</div>
 -->
				</div>

				<table class="table table-striped table-bordered table-condensed">
					<thead>
						<tr>
							<th>#</th>
							<th>Quantity</th>
							<th>Unit</th>
							<th>Description</th>
							<th>Remarks</th>
							<th>File</th>
							<th>actoins</th>
						</tr>
					</thead>
					<tbody id="items-container" data-items="1">
						<tr id="item-1">
							<td>
								<span>1</span>
							</td>
							<td>
								<input type="number" class="form-control" name="items[1][quantity]" id="item-1-quantity" value="1" />
							</td>
							<td>
								<input type="text" class="form-control" name="items[1][unit]" id="item-1-unit" value="" />
							</td>
							<td>
								<input type="text" class="form-control" name="items[1][description]" id="item-1-description" value=""/>
							</td>
							<td>
								<input type="text" class="form-control" name="items[1][remarks]" id="item-1-remarks" value=""/>
							</td>
							<td>
								<input type="file" class="form-control" name="items-1-sample_file" id="item-1-sample_file" value=""/>
							</td>
							
							<td>
								<span data-item-id="1" class="form-actions btn btn-danger remove-item">Remove</span>
							</td>
						</tr>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="6"></td>
							<td><span class="form-actions btn btn-primary" id="add-item">Add Item</span></td>
						</tr>
					</tfoot>
				</table>
				<script type="text/javascript">
				document.items = <?php echo json_encode($this->input->post('items')); ?>;
				</script>
				
				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<label for="remarks" class="col-lg-4 col-md-4 col-sm-4 col-xs-4  control-label">Remarks</label>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<textarea class="form-control" name="remarks" id="remarks"><?php echo set_value('remarks'); ?></textarea>
					</div>
				</div>


				<div class="form-group">
				    <div class="col-lg-offset-3 col-lg-10 col-md-10 col-md-offset-3">
				    	<input name="submit" value="Submit" type="submit" class="btn btn-success" />
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
				<input type="number" class="form-control" name="items[{{id}}][quantity]" id="item-{{id}}-name" value="{{quantity}}" ></input>
			</td>
			<td>
				<input type="text" class="form-control" name="items[{{id}}][unit]" id="item-{{id}}-unit" value="{{unit}}" ></input>
			</td>
			<td>
				<input type="text" class="form-control" name="items[{{id}}][description]" id="item-{{id}}-description" value="{{description}}" ></input>
			</td>
			<td>
				<input type="text" class="form-control" name="items[{{id}}][remarks]" id="item-{{id}}-remarks" value="{{remarks}}" ></input>
			</td>
			<td>
				<input type="file" class="form-control" name="items-{{id}}-sample_file" id="item-{{id}}-sample_file" value="{{sample_file}}" ></input>
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
