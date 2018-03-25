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
                        <input type="text" disabled class="form-control" name="from_hotel" id="name" value="<?php echo $workshop_requests['from_hotel'] ?>" ></input>
					</div>
                                        
                     <label for="name" class="col-lg-offset-2 col-md-offset-0 col-sm-offset col-xs-offset-0 col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label">Request Number</label>
					<div class="col-lg-3 col-md-4 col-sm-4 col-xs-4">
                        <input type="text" disabled class="form-control" name="id" id="name" value="<?php echo $workshop_requests['id']; ?>" ></input>
					</div>
				</div>


				<table class="table table-striped table-bordered table-condensed">
					<thead>
						<tr>
							<th>#</th>
							<th>Item Description</th>
							<th>Quantity</th>
							<th>Unit</th>
							<th>Price</th>
							<th>Remarks</th>                                                        
							<th>Actoins</th>
						</tr>
					</thead>
					<tbody id="items-container" data-items="1">
						<tr id="item-1">
							<td>
								<span>1</span>
							</td>
							<td>
								<input type="text" class="form-control" name="items[1][description]" id="item-1-description" value="" ></input>
							</td>
							<td>
								<input type="number" class="form-control" name="items[1][quantity]" id="item-1-quantity" value="1" ></input>
							</td>
							<td>
								<input type="text" class="form-control" name="items[1][unit]" id="item-1-unit" value="" ></input>
							</td>
							<td>
								<input type="number" class="form-control" name="items[1][price]" id="item-1-price" value="" ></input>
							</td>
							<td>
								<input type="text" class="form-control" name="items[1][remarks]" id="item-1-remarks" value="" ></input>
							</td>
							<td>
								<span data-item-id="1" class="form-actions btn btn-danger remove-item">Remove</span>
							</td>
						</tr>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="6">
							<td><span class="form-actions btn btn-primary" id="add-item">Add Item</span></td>
						</tr>
					</tfoot>
				</table>


				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<input type="hidden" name="assumed_id" value="<?php echo $assumed_id; ?>" />
					<label for="order[]" class="col-lg-3 col-md-4 col-sm-5 col-xs-5 control-label">Files</label>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<input id="files" name="files" type="file" class="file" multiple="true" data-show-upload="false" data-show-caption="true">
					</div>
					<script>
					$("#files").fileinput({
					    uploadUrl: "/workshop/add_files/<?php echo $assumed_id; ?>", // server upload action
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
				    	<input name="submit" value="Submit" type="submit" class="btn btn-success"></input>
				    	<a href="<?= base_url(); ?>workshop" class="btn btn-warning">Cancel</a>
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
				<input type="text" class="form-control" name="items[{{id}}][description]" id="item-{{id}}-description" value="{{description}}" ></input>
			</td>
			<td>
				<input type="number" class="form-control" name="items[{{id}}][quantity]" id="item-{{id}}-quantity" value="{{quantity}}" ></input>
			</td>
			<td>
				<input type="text" class="form-control" name="items[{{id}}][unit]" id="item-{{id}}-unit" value="{{unit}}" ></input>
			</td>
			<td>
				<input type="number" class="form-control" name="items[{{id}}][price]" id="item-{{id}}-price" value="{{price}}" ></input>
			</td>
			<td>
				<input type="text" class="form-control" name="items[{{id}}][remarks]" id="item-{{id}}-remarks" value="{{remarks}}" ></input>
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
