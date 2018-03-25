<!DOCTYPE html>
<html lang="en">
<head>
	<?php $this->load->view('header'); ?>
	<style type="text/css">
		@media print{
			.topic{
				display: block !important;
			}
			.real{
				display: none !important;
			}
		}
	</style>
</head>
<body>
<div id="wrapper">
	<?php $this->load->view('menu') ?>
	<div id="page-wrapper">
		<div class="a4wrapper">

	<div class="a4page">
		<div class="page-header">
	        <h1 class="centered">Maintenance Center Order No. #<?php echo $id; ?>
	        <span class="form-actions btn btn-info" id="edit" >Edit <i class="fa fa-edit glyphicon glyphicon-edit"></i></span>
	        	</h1>
	    </div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
				<div><span class="data-head">From: Hotel Name:</span><?php echo $workshop_order['hotel_name']; ?></div>
			</div>
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
					<div><span class="data-head">Issue Date:</span><?php echo $workshop_order['timestamp']; ?></div>
			</div>
		</div>
		

		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-container">
		<table class="table table-bordered table-striped">
		 	<thead>
	        	<tr>
	        		<th>#</th>
	          		<th>Description</th>
	          		<th>Quantity</th>
	          		<th>Unit</th>
	          		<th style="color:white;background-color: rgb(128,128,128);text-align:center;font-weight: 900;">Price</th>
	          		<th>Remarks</th>
	          		<th class="edit"></th>
	          	</tr>
			</thead>
			<tbody>
				<?php if(isset($items)): ?>
					<?php $count = 0; ?>
					<?php $total_price = 0; ?>
					<?php foreach ($items as $item): ?>
						<tr>
							<td>
								<span data-mirror="count" class="orig"><?php echo $count += 1; ?></span>
								<span data-mirror="id" class="orig hidden"><?php echo $item['id'] ?></span>
							</td>
							<td><span data-mirror="description" class="orig"><?php echo $item['description']; ?></span></td>
							<td><span data-mirror="quantity" class="orig"><?php echo $item['quantity']; ?></span></td>
							<td><span data-mirror="unit" class="orig"><?php echo $item['unit']; ?></span></td>
							<td style="color:white;background-color: rgb(128,128,128);text-align:center;font-weight: 900;"><span data-mirror="price" class="orig"><?php echo $item['price']; ?></td>
							<td><span data-mirror="remarks" class="orig"><?php echo $item['remarks']; ?></td>
							<td>
									<div class="edit">
										<a class="form-actions btn btn-danger cancel-btn" href="/workshop/order_cancelitem/<?php echo $workshop_order['id']; ?>/<?php echo $item['id'] ?>">delete</a>
										<a class="form-actions btn btn-info cancel-btn edit-btn" href="#edit-<?php echo $workshop_order['id']; ?>">edit</a>
									</div>
							</td>

						</tr>
						<?php $total_price += $item['price']; ?>
					<?php endforeach; ?>
						<tr>					
							<td style="color:white;background-color: rgb(128,128,128);text-align:center;font-weight: 900;" colspan="4">Total Price</td>
							<td style="color:white;background-color: rgb(128,128,128);text-align:center;font-weight: 900;"><?php echo $total_price; ?></td>
							<td style="color:white;background-color: rgb(128,128,128);text-align:center;font-weight: 900;"></td>
						</tr>						

				<?php endif; ?>
			</tbody>
		</table>
		</div>
		<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<label for="remarks" class="col-lg-4 col-md-4 col-sm-4 col-xs-4  control-label">Remarks</label>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 real">
						<textarea disabled="" class="form-control" name="remark" id="remark"><?php echo $workshop_order['remarks']; ?></textarea>
					</div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 topic" style="display: none;">
						<?php echo $workshop_order['remarks']; ?>
					</div>
				</div>


					<div class="data-container edit" id="edit-<?php echo $workshop_order['id']; ?>">
						<form action="/workshop/order_additem/<?php echo $workshop_order['id']; ?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
							<table class="table table-striped table-bordered table-condensed">
							<thead>
									<tr>
										<th>Quantity</th>
										<th>Unit</th>
										<th>Description</th>
										<th>Price</th>
										<th>Remarks</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									<tr >
									<input type="hidden" class="form-control clearable" name="id" id="id" value="" />
									<input type="hidden" class="form-control" name="order_id" id="order_id" value="<?php echo $workshop_order['id']; ?>" />
										<td>
											<input type="number" class="form-control" name="quantity" id="quantity" value="1" />
										</td>
										<td>
											<input type="text" class="form-control" name="unit" id="unit" value="" />
										</td>
										<td>
											<input type="text" class="form-control" name="description" id="description" value=""/>
										</td>
										<td>
											<input type="text" class="form-control" name="price" id="price" value=""/>
										</td>
										<td>
											<input type="text" class="form-control" name="remarks" id="remarks" value=""/>
										</td>
										<td>
											<input name="submit" value="Save" type="submit" class="btn btn-success" />
										</td>
									</tr>
								</tbody>
							</table>
							<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<br>
								<label for="remarks" class="col-lg-4 col-md-4 col-sm-4 col-xs-4  control-label">Remarks</label>
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<textarea class="form-control" name="remark" id="remark"><?php echo $workshop_order['remarks']; ?></textarea>
								</div>
							</div>
						</form>
					</div>

				

		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher">
		<?php $queue_first = TRUE; ?>
		<?php foreach ($orders_signers as $signe_id => $order_signer): ?>
			<div class="signature-wrapper">
				<div class="data-head relative">
					<?php echo (strlen($order_signer['role']) == 0)? "Request Owner" : $order_signer['role'] ?>
					<span class="expander-container"><i class='glyphicon glyphicon-envelope'></i></span>
					<div class="expander-wrapper">
					<span class="expander-remover"><i class='glyphicon glyphicon-remove'></i></span>
						<div class="expander">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-holder">
								<div class="row">
									<form action="/workshop/order_mailto/<?php echo $workshop_order['id']; ?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
										<?php if (isset($order_signer['sign'])): ?>
										<?php $i=1; ?>
										<input checked="checked" type="radio" name="mail" value="<?php echo $order_signer['sign']['mail'] ?>" /><label>To: <?php echo $order_signer['sign']['name'] ?></label>
										<?php else: ?>
											<?php $i=0; foreach ($order_signer['queue'] as $id => $signe): ?>
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
				<?php if (isset($order_signer['sign'])): ?>
					<div class="data-content">
						<img src="<?php echo isset($order_signer['sign']['reject'])? $signature_path.'rejected.png' : $signature_path.'approved.png'; ?>" alt="<?php echo $order_signer['sign']['name']; ?>" class="img-rounded sign-image">
						<?php if (($order_signer['sign']['id'] == $user_id && $unsign_enable) || $is_admin): ?>
							<a href="/workshop/order_unsign/<?php echo $signe_id; ?>" class="btn btn-primary unsign">Cancel</a>
						<?php endif ?>
					</div>
					<div class="data-content">
						<span class="name-data-content"><?php echo $order_signer['sign']['name']; ?></span><br />
						<span class="timestamp-data-content"><?php echo $order_signer['sign']['timestamp']; ?></span>
					</div>
				<?php elseif (array_key_exists($user_id, $order_signer['queue']) && $queue_first): ?>
					<?php $queue_first = FALSE; ?>
					<div class="data-content non-printable">
							<a href="/workshop/order_sign/<?php echo $signe_id; ?>/reject" class="btn btn-danger">Reject</a>
							<a href="/workshop/order_sign/<?php echo $signe_id; ?>" class="btn btn-success">sign</a>
					</div>
				<?php else: ?>
					<?php $queue_first = FALSE; ?>
				<?php endif ?>
			</div>
		
		<?php endforeach ?>

</div>


		<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher">
			<label for="files[]" class="col-lg-2 col-md-3 col-sm-5 col-xs-5 control-label">Files:</label>
			<div class="form-group col-lg-9 col-md-8 col-sm-7 col-xs-7">
		    <?php foreach($workshop_order_files as $order): ?>
				<a href='/assets/uploads/files/<?php echo $order['name'] ?>'><?php echo $order['name'] ?></a><br />
			<?php endforeach ?>
			</div>
		</div>


		<script type="text/javascript">
		$(".expander-container").on("click", function(){
			$(".expander-wrapper").hide();
			$(this).parent().find(".expander-wrapper").toggle("fast");
		});

		$(".expander-remover").on("click", function(){
			$(this).parent().hide("fast");
		});
		</script>

	</div>
	</div>
	</div>
</div>
</body>
</html>