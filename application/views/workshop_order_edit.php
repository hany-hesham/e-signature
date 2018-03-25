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
	        <h1 class="centered">Maintenance Center Order No. #<?php echo $workshop_order['id']; ?>
	    </div>

	    		<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label">From: Hotel Name:</label>
					<div class="col-lg-3 col-md-4 col-sm-4 col-xs-4">
                        <input type="text" disabled class="form-control" name="name" id="name" value="<?php echo $workshop_order['hotel_name']; ?>" ></input>
					</div>
                                        
                     <label for="name" class="col-lg-offset-2 col-md-offset-0 col-sm-offset col-xs-offset-0 col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label">Issue Date:</label>
					<div class="col-lg-3 col-md-4 col-sm-4 col-xs-4">
                        <input type="text" disabled class="form-control" name="name" id="name" value="<?php echo $workshop_order['timestamp']; ?>" ></input>
					</div>

				</div>

				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        
                     <label for="name" class="ol-lg-2 col-md-2 col-sm-2 col-xs-2  control-label">Delivery Date:</label>
					<div class="col-lg-3 col-md-4 col-sm-4 col-xs-4">
                        <input type="text" class="form-control datetime" name="delivery_date" id="delivery_date" data-date-format="YYYY-MM-DD" value="<?php echo $workshop_order['delivery_date']; ?>"></input>
								<script type="text/javascript">
									$(function () {
										$('.datetime').datetimepicker({
											autoclose: true,
											pickTime: false,

											});

											$("#delivery_date").on("dp.change",function (e) {setMinDate(e.date);
					        				});
					        				$('#delivery_date').on("dp.change",function (e) {setMaxDate(e.date);
					        				});
							
					});
					</script>
					</div>

				</div>


		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-container">
		<table class="table table-bordered table-striped">
		 	<thead>
	        	<tr>
	          		<th>Description</th>
	          		<th>Quantity</th>
	          		<th>Unit</th>
	          		<th>Price</th>
	          		<th>Remarks</th>
	          	</tr>
			</thead>
			<tbody>
				<?php if(isset($items)): ?>
					<?php foreach ($items as $item): ?>
						<tr>
							<td><?php echo $item['description']; ?></td>
							<td><?php echo $item['quantity']; ?></td>
							<td><?php echo $item['unit']; ?></td>
							<td><?php echo $item['price']; ?></td>
							<td><?php echo $item['remarks']; ?></td>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>
		</div>
                                
                                		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher">
		<?php $sign_enabled = TRUE; ?>
		<?php foreach ($order_signers as $signe_id => $signer): ?>
			<div class="signature-wrapper">
				<div class="data-head relative"><?php echo (strlen($signer['role']) == 0)? "Order Owner" : $signer['role'] ?>
					<span class="expander-container"><i class='glyphicon glyphicon-envelope'></i></span>
					<div class="expander-wrapper">
					<span class="expander-remover"><i class='glyphicon glyphicon-remove'></i></span>
						<div class="expander">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-holder">
								<div class="row">
									<form action="/workshop_orders/mailto/<?php echo $workshop_order['id']; ?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
										<?php if (isset($signer['sign'])): ?>
										<?php $i=1; ?>
										<input checked="checked" type="radio" name="mail" value="<?php echo $signer['sign']['mail'] ?>" /><label>To: <?php echo $signer['sign']['name'] ?></label>
										<?php else: ?>
											<?php $i=0; foreach ($signer['queue'] as $id => $signe): ?>
												<input <?php echo (++$i == 1)? 'checked="checked"' : '' ?> type="radio" name="mail" value="<?php echo $signe['mail'] ?>" id="u<?php echo $id ?>" /><label for="u<?php echo $id ?>">To: <?php echo $signe['name'] ?></label><br />
											<?php endforeach ?>
										<?php endif; ?>
										<?php if (isset($i) && $i == 0): ?>
											<span>No users available</span>
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
					</div>
					<div class="data-content"><span class="name-data-content"><?php echo $signer['sign']['name']; ?></span>
					<br /><span class="timestamp-data-content"><?php echo $signer['sign']['timestamp']; ?></span></div>
				<?php elseif (array_key_exists($user_id, $signer['queue']) && $workshop_order['state_id'] != 11 && $sign_enabled): ?>
					<div class="data-content non-printable"><span class="data-label sign-data-content"></span><a href="/workshop/order_sign/<?php echo $signe_id; ?>/reject" class="btn btn-danger">Reject</a><a href="/workshop/order_sign/<?php echo $signe_id; ?>" class="btn btn-success">sign</a></div>
				<?php else: ?>
					<?php $sign_enabled = FALSE; ?>
				<?php endif ?>
			</div>
				<?php endforeach ?>

		<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher">
			<label for="files[]" class="col-lg-2 col-md-3 col-sm-5 col-xs-5 control-label">Files:</label>
			<div class="form-group col-lg-9 col-md-8 col-sm-7 col-xs-7">
		    <?php foreach($workshop_order_files as $order): ?>
				<a href='/assets/uploads/files/<?php echo $order['name'] ?>'><?php echo $order['name'] ?></a><br />
			<?php endforeach ?>
			</div>
		</div>



                                
				<div class="form-group">
				    <div class="col-lg-offset-3 col-lg-10 col-md-10 col-md-offset-3">
				    	<input name="submit" value="Update" type="submit" class="btn btn-success submitter" />
				    	<a href="<?= base_url(); ?>workshop" class="btn btn-warning">Cancel</a>
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


