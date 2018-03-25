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
			<form action="" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">

		<div class="page-header">
	        <h1 class="centered">Maintenance Center Request No. #<?php echo $workshop_requests['id']; ?>
	    </div>

	    		<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label">From: Hotel Name:</label>
					<div class="col-lg-3 col-md-4 col-sm-4 col-xs-4">
                        <input type="text" disabled class="form-control" name="name" id="name" value="<?php echo $workshop_requests['from_hotel']; ?>" ></input>
					</div>
                                        
                     <label for="name" class="col-lg-offset-2 col-md-offset-0 col-sm-offset col-xs-offset-0 col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label">Issue Date:</label>
					<div class="col-lg-3 col-md-4 col-sm-4 col-xs-4">
                        <input type="text" disabled class="form-control" name="name" id="name" value="<?php echo $workshop_requests['timestamp']; ?>" ></input>
					</div>

				</div>

				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label">Name:</label>
					<div class="col-lg-3 col-md-4 col-sm-4 col-xs-4">
                        <input type="text" disabled class="form-control" name="name" id="name" value="<?php echo $workshop_requests['name']; ?>" ></input>
					</div>
                                        
				</div>

				<table class="table table-striped table-bordered table-condensed">
					<thead>
						<tr>
							<th>#</th>
							<th>Quantity</th>
							<th>Unit Name</th>
							<th>Description</th>
							<th>Remarks</th>
							<th>File</th>
							<th>actoins</th>
						</tr>
					</thead>
					<tbody id="items-container" data-items="1">
					<?php if(!empty($items)): ?>
					<?php foreach ($items as $item): ?>
						<tr id="item-1">
							<td>
								<span>1</span>
							</td>
							<td>
								<input type="number" class="form-control" name="items[1][quantity]" id="item-1-quantity" value="<?php echo $item['quantity']; ?>" />
							</td>
							<td>
								<input type="text" class="form-control" name="items[1][unit]" id="item-1-unit" value="<?php echo $item['unit']; ?>" />
							</td>
							<td>
								<input type="text" class="form-control" name="items[1][description]" id="item-1-description" value="<?php echo $item['description']; ?>"/>
							</td>
							<td>
								<input type="text" class="form-control" name="items[1][remarks]" id="item-1-remarks" value="<?php echo $item['remarks']; ?>"/>
							</td>
							<td>
								<input type="file" class="form-control" name="items[1][sample_file]" id="item-1-sample_file" value=""/>
							</td>
							
							<td>
								<span data-item-id="1" class="form-actions btn btn-danger remove-item">Remove</span>
							</td>
						</tr>
						<?php endforeach; ?>
				<?php endif; ?>
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
                                
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher">
		<?php $sign_enabled = TRUE; ?>
		<?php foreach ($signers as $signe_id => $signer): ?>
			<div class="signature-wrapper">
				<div class="data-head relative"><?php echo (strlen($signer['role']) == 0)? "Request Owner" : $signer['role'] ?>
					<span class="expander-container"><i class='glyphicon glyphicon-envelope'></i></span>
					<div class="expander-wrapper">
					<span class="expander-remover"><i class='glyphicon glyphicon-remove'></i></span>
						<div class="expander">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-holder">
								<div class="row">
									<form action="/workshop_requests/mailto/<?php echo $workshop_requests['id']; ?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
										<?php if (isset($signer['sign'])): ?>
										<?php $i=1; ?>
										<input checked="checked" type="radio" name="mail" value="<?php echo $signer['sign']['mail'] ?>" /><label>To: <?php echo $signer['sign']['name'] ?></label>
										<?php else: ?>
											<?php $i=0; foreach ($signer['queue'] as $id => $signe): ?>
												<input <?php echo (++$i == 1)? 'checked="checked"' : '' ?> type="radio" name="mail" value="<?php echo $signe['mail'] ?>" id="u<?php echo $id ?>" /><label for="u<?php echo $id ?>">To: <?php echo $signe['name'] ?></label><br />
											<?php endforeach ?>
										<?php endif; ?>
										<?php if (isset($i) && $i == 0): ?>
											<span>No users availaable</span>
										<?php else: ?>
										<textarea class="form-control" name="message" id="message"></textarea>
										<input name="submit" value="Send" type="submit" class="inverse-offset btn btn-success" />
										<?php endif; ?>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php if (isset($signer['sign'])): ?>
					<div class="data-content"><img src="<?php echo isset($signer['sign']['reject'])? $signature_path.'rejected.png' : $signature_path.'approved.png'; ?>" alt="<?php echo $signer['sign']['name']; ?>" class="img-rounded sign-image">
						<?php if ($workshop_requests['state_id'] <= 2 ): ?>
							<a href="/workshop/unsign/<?php echo $signe_id; ?>" class="btn btn-primary unsign">Cancel</a>
						<?php endif ?>
					</div>
					<div class="data-content"><span class="name-data-content"><?php echo $signer['sign']['name']; ?></span>
					<br /><span class="timestamp-data-content"><?php echo $signer['sign']['timestamp']; ?></span></div>
				<?php elseif (array_key_exists($user_id, $signer['queue']) && $workshop_requests['state_id'] != 3 && $sign_enabled): ?>
					<div class="data-content non-printable"><span class="data-label sign-data-content"></span><a href="/workshop/sign/<?php echo $signe_id; ?>/reject" class="btn btn-danger">Reject</a><a href="/workshop/sign/<?php echo $signe_id; ?>" class="btn btn-success">sign</a></div>
				<?php else: ?>
					<?php $sign_enabled = FALSE; ?>
				<?php endif ?>
			</div>
		
		<?php endforeach ?>

                                
				<div class="form-group">
				    <div class="col-lg-offset-3 col-lg-10 col-md-10 col-md-offset-3">
				    	<input name="submit" value="Update" type="submit" class="btn btn-success submitter" />
				    	<a href="<?= base_url(); ?>workshop" class="btn btn-warning">Cancel</a>
				    </div>
				</div>

			</form>
			</fieldset>
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
				<input type="file" class="form-control" name="items[{{id}}][sample_file]" id="item-{{id}}-sample_file" value="{{sample_file}}" ></input>
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
