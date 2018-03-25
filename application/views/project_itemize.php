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
							<legend>Select Project Items</legend>
							<?php if(validation_errors() != false): ?>
								<div class="alert alert-danger">
									<?php echo validation_errors(); ?>
								</div>
							<?php endif ?>
							<form action="" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
								<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<label for="item" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">Items</label>
									<div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
										<select  class="form-control chooosen" name="items[]" id="items[]" multiple="multiple" data-placeholder="Select Items...">
											<?php foreach ($items as $item): ?>
												<option <?php echo ($item['remaining'] == 0)? 'disabled="disabled"' : '' ; ?> value="<?php echo $item['id'] ?>" <?php echo set_select('item',$item['id'] ); ?>><?php echo $item['code'].": ".$item['name']." -- ".$item['remarks']; ?></option>
											<?php endforeach ?>
										</select>
									</div>
								</div>
								<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
								    <div class="col-lg-offset-3 col-lg-10 col-md-10 col-md-offset-3">
								    	<input name="submit" value="Proceed" type="submit" class="btn btn-success" />
								    	<a href="<?= base_url(); ?>requests" class="btn btn-warning">Cancel</a>
								    </div>
								</div>
							</form>
						</fieldset>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
