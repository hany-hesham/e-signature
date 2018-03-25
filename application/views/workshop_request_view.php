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

			<input class="form-actions btn btn-success printer" type="button" onclick="printDiv('page-wrapper')" value="print" />

	<div id="page-wrapper">

	<div class="a4wrapper">

	<div class="a4page">

		<div class="page-header">

			<div class="header-logo"><img src="<?php echo $logo_path.$workshop_requests['hotel_logo']; ?>"></div>

	        <h1 class="centered">Maintenance Center Request No. #<?php echo $id; ?>

  		

  		<?php if ($isWS || $is_admin): ?>



	        <?php if ($workshop_requests['state_id'] >= 2): ?>

			<?php if (!isset($workshop_order['state_id'])): ?>

		        <a href="<?php echo base_url(); ?>workshop/order_submit/<?php echo $id; ?>" class="btn btn-primary">Order Submit</a>

			<?php endif; ?>

			<?php endif; ?>

		<?php endif; ?>



			<?php if ($workshop_requests['state_id'] == 1 ): ?>

			<?php if ($is_editor): ?>

					&nbsp;&nbsp;

					<span class="form-actions btn btn-info" id="edit" >Edit <i class="fa fa-edit glyphicon glyphicon-edit"></i></span>

				<?php endif ?>

			<?php endif; ?>

	        </h1>

	    </div>

		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">

				<div><span class="data-head">From: Hotel Name:</span><?php echo $workshop_requests['from_hotel']; ?></div>

			</div>

			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">

				<div><span class="data-head">Issue Date:</span><?php echo $workshop_requests['timestamp']; ?></div>

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

	          		<th>Remarks</th>

	          		<th>File</th>

	          		<th class="edit"></th>

	          	</tr>

			</thead>

			<tbody>

				<?php if(!empty($items)): ?>

					<?php $count = 0; ?>

					<?php foreach ($items as $item): ?>

						<tr>

							<td>

							

							<span data-mirror="count" class="orig"><?php echo $count += 1; ?></span>

							<span data-mirror="id" class="orig hidden"><?php echo $item['id'] ?></span></td>

							<td><span data-mirror="description" class="orig"><?php echo $item['description']; ?></span></td>

							<td><span data-mirror="quantity" class="orig"><?php echo $item['quantity']; ?></span></td>

							<td><span data-mirror="unit" class="orig"><?php echo $item['unit']; ?></span></td>

							<td><span data-mirror="remarks" class="orig"><?php echo $item['remarks']; ?></span></td>

							<td><span data-mirror="sample_file" class="orig"><a href="<?php echo $file_path.$item['sample_file']; ?>"><?php echo $item['sample_file']; ?></span></td>

								<td>

								<?php if ($item['done'] == 1): ?>

									<?php if ($workshop_requests['state_id'] >= 5 ): ?>

									<span class="checked"><i class="fa fa-check glyphicon glyphicon-check"></i></span>

									<?php endif; ?>

								<?php elseif($is_editor): ?>

									<div class="edit">

										<a class="form-actions btn btn-danger cancel-btn" href="/workshop/cancelitem/<?php echo $workshop_requests['id']; ?>/<?php echo $item['id'] ?>">delete</a>

										<a class="form-actions btn btn-info cancel-btn edit-btn" href="#edit-<?php echo $workshop_requests['id']; ?>">edit</a>

									</div>

									<?php if ($workshop_requests['state_id'] >= 5 ): ?>

									<div class="non-edit">

										<a class="form-actions btn btn-success cancel-btn approve-btn" href="/workshop/approveitem/<?php echo $workshop_requests['id']; ?>/<?php echo $item['id'] ?>">Done</a>

									</div>

									<?php endif; ?>

									</div>

								<?php endif; ?>

								</td>

						</tr>

					<?php endforeach; ?>

				<?php endif; ?>

			</tbody>

		</table>

		</div>

		<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">

					<label for="remarks" class="col-lg-4 col-md-4 col-sm-4 col-xs-4  control-label">Remarks</label>

					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 real">

						<textarea disabled="" class="form-control" name="remarks" id="remarks"><?php echo $workshop_requests['remarks']; ?></textarea>

					</div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 topic" style="display: none">

						<?php echo $workshop_requests['remarks']; ?>

					</div>

				</div>

		





					<?php if ($is_editor): ?>

					<div class="data-container edit" id="edit-<?php echo $workshop_requests['id']; ?>">

						<form action="/workshop/additem/<?php echo $workshop_requests['id']; ?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8" enctype="multipart/form-data">

							<table class="table table-striped table-bordered table-condensed">

							<thead>

									<tr>

										<th>Quantity</th>

										<th>Unit</th>

										<th>Description</th>

										<th>Remarks</th>

										<th>file</th>

										<th></th>

									</tr>

								</thead>

								<tbody>

									<tr >

									<input type="hidden" class="form-control clearable" name="id" id="id" value="" />

									<input type="hidden" class="form-control" name="request_id" id="request_id" value="<?php echo $workshop_requests['id']; ?>" />

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

											<input type="text" class="form-control" name="remarks" id="remarks" value=""/>

										</td>

										<td>

											<input type="file" class="form-control" name="sample_file" id="sample_file" value=""/>

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

									<textarea class="form-control" name="remark" id="remark"><?php echo $workshop_requests['remarks']; ?></textarea>

								</div>

							</div>

						</form>

					</div>

					<?php endif ?>



























				







		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher">

		<?php $queue_first = TRUE; ?>

		<?php foreach ($signers as $signe_id => $signer): ?>

			<div class="signature-wrapper">

				<div class="data-head relative"><?php echo (strlen($signer['role']) == 0)? "Request Owner" : $signer['role'] ?>

					<span class="expander-container"><i class='glyphicon glyphicon-envelope'></i></span>

					<div class="expander-wrapper">

					<span class="expander-remover"><i class='glyphicon glyphicon-remove'></i></span>

						<div class="expander">

							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-holder">

								<div class="row">

									<form action="/workshop/mailto/<?php echo $workshop_requests['id']; ?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">

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

						<?php if (($signer['sign']['id'] == $user_id && $unsign_enable) || $is_admin): ?>

							<a href="/workshop/unsign/<?php echo $signe_id; ?>" class="btn btn-primary unsign">Cancel</a>

						<?php endif ?>

					</div>

					<div class="data-content"><span class="name-data-content"><?php echo $signer['sign']['name']; ?></span>

					<br /><span class="timestamp-data-content"><?php echo $signer['sign']['timestamp']; ?></span></div>

				<?php elseif (array_key_exists($user_id, $signer['queue']) && $queue_first && $role_id !=142): ?>

					<?php $queue_first = FALSE; ?>

					<div class="data-content non-printable"><span class="data-label sign-data-content"></span><a href="/workshop/sign/<?php echo $signe_id; ?>/reject" class="btn btn-danger">Reject</a><a href="/workshop/sign/<?php echo $signe_id; ?>" class="btn btn-success">sign</a></div>

				<?php else: ?>

					<?php $queue_first = FALSE; ?>

				<?php endif ?>

			</div>

		

		<?php endforeach ?>



</div>





		<?php if ($workshop_order['state_id'] >= 3 ): ?>

		<div class="page-header">

	        <h1 class="centered">Order Expenses Details.</h1>

	    </div>

		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-container">

		<table class="table table-bordered table-striped">

		 	<thead>

	        	<tr>

	          		<th>Description</th>

	          		<th>Quantity</th>

	          		<th>Unit</th>

	          		<th style="color:white;background-color: rgb(128,128,128);text-align:center;font-weight: 900;">Price</th>

	          		<th>Remarks</th>

	          	</tr>

			</thead>

			<tbody>

				<?php if(isset($items)): ?>

					<?php $total_price = 0; ?>

					<?php foreach ($workshop_order_items as $workshop_orders): ?>

						<tr>

							<td><?php echo $workshop_orders['description']; ?></td>

							<td><?php echo $workshop_orders['quantity']; ?></td>

							<td><?php echo $workshop_orders['unit']; ?></td>

							<td style="color:white;background-color: rgb(128,128,128);text-align:center;font-weight: 900;"><?php echo $workshop_orders['price']; ?></td>

							<td><?php echo $workshop_orders['remarks']; ?></td>

						</tr>

						<?php $total_price += $workshop_orders['price']; ?>

					<?php endforeach; ?>

						<tr>					

							<td style="color:white;background-color: rgb(128,128,128);text-align:center;font-weight: 900;" colspan="3">Total Price</td>

							<td style="color:white;background-color: rgb(128,128,128);text-align:center;font-weight: 900;"><?php echo $total_price; ?></td>

							<td style="color:white;background-color: rgb(128,128,128);text-align:center;font-weight: 900;"></td>

						</tr>						



				<?php endif; ?>

			</tbody>

		</table>

		</div>



		

		<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher">

			<label for="files[]" class="col-lg-2 col-md-3 col-sm-5 col-xs-5 control-label">Files:</label>

			<div class="form-group col-lg-9 col-md-8 col-sm-7 col-xs-7">

		    <?php foreach($workshop_order_files as $order): ?>

				<a href='/assets/uploads/files/<?php echo $order['name'] ?>'><?php echo $order['name'] ?></a><br />

			<?php endforeach ?>

			</div>

		</div>





				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">

					<label for="remarks" class="col-lg-4 col-md-4 col-sm-4 col-xs-4  control-label">Remarks</label>

					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 real">

						<textarea disabled="" class="form-control" name="remarks" id="remarks"><?php echo $workshop_order['remarks']; ?></textarea>

					</div>

					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 topic" style="display: none;">

						<?php echo $workshop_order['remarks']; ?>

					</div>

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

									<form action="/workshop/mailto/<?php echo $workshop_order['id']; ?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">

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

				<?php elseif (array_key_exists($user_id, $signer['queue']) && $sign_enabled): ?>

					<div class="data-content non-printable"><span class="data-label sign-data-content"></span><a href="/workshop/order_sign/<?php echo $signe_id; ?>/reject" class="btn btn-danger">Reject</a><a href="/workshop/order_sign/<?php echo $signe_id; ?>" class="btn btn-success">sign</a></div>

				<?php else: ?>

					<?php $sign_enabled = FALSE; ?>

				<?php endif ?>

			</div>

				<?php endforeach ?>





		<div class="page-header">

	        <h1 class="centered">Hotel Approval</h1>

	    </div>





		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher">

		<?php $sign_enabled = TRUE; ?>

		<?php foreach ($approval_signers as $signe_id => $signer): ?>

			<div class="signature-wrapper">

				<div class="data-head relative"><?php echo (strlen($signer['role']) == 0)? "Request Owner" : $signer['role'] ?>

					<span class="expander-container"><i class='glyphicon glyphicon-envelope'></i></span>

					<div class="expander-wrapper">

					<span class="expander-remover"><i class='glyphicon glyphicon-remove'></i></span>

						<div class="expander">

							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-holder">

								<div class="row">

									<form action="/workshop/mailto/<?php echo $workshop_requests['id']; ?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">

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

					<?php if ($workshop_requests['state_id'] < 5 ): ?>

							<a href="/workshop/approvals_unsign/<?php echo $signe_id; ?>" class="btn btn-primary unsign">Cancel</a>

						<?php endif ?>

					</div>

					<div class="data-content"><span class="name-data-content"><?php echo $signer['sign']['name']; ?></span>

					<br /><span class="timestamp-data-content"><?php echo $signer['sign']['timestamp']; ?></span></div>

				<?php elseif (array_key_exists($user_id, $signer['queue']) && $sign_enabled): ?>

					<div class="data-content non-printable"><span class="data-label sign-data-content"></span><a href="/workshop/approvals_sign/<?php echo $signe_id; ?>/reject" class="btn btn-danger">Reject</a><a href="/workshop/approvals_sign/<?php echo $signe_id; ?>" class="btn btn-success">sign</a></div>

				<?php else: ?>

					<?php $sign_enabled = FALSE; ?>

				<?php endif ?>

			</div>

		<?php endforeach ?>

		</div>





  	<?php if ($isWS || $is_admin): ?>

		<div class="page-header">		

	        <h1 class="centered">Delivery Date. <?php echo $workshop_order['delivery_date']; ?>

			<?php if ($workshop_requests['state_id'] == 6 ): ?>

	        <a href="<?php echo base_url(); ?>workshop/order_edit/<?php echo $workshop_order['id']; ?>" class="btn btn-primary">Set Delivry Date</a>

	        <?php endif;?>

			<?php if ($workshop_requests['state_id'] == 7 ): ?>

	        <a href="<?php echo base_url(); ?>workshop/order_edit/<?php echo $workshop_order['id']; ?>" class="btn btn-primary">Update Delivry Date</a>

	        <?php endif;?>

	        </h1>

	    </div>

	<?php endif;?>    

		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher non-printable">

			<div class="row">

				<form action="/workshop/comment/<?php echo $workshop_requests['id']; ?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">

					

				<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">

														<label for="comment">Comment:</label>



					<textarea class="form-control" name="comment" id="comment"></textarea>

				</div>



				<input name="submit" value="Comment" type="submit" class="inverse-offset btn btn-success" />

				</form>

			</div>

		</div>



		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher non-printable">

			<div class="row">

				<form action="/workshop/reciver/<?php echo $workshop_requests['id']; ?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">

			<?php if ($workshop_requests['state_id'] >= 6 ): ?>

				<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">

					<textarea class="form-control" name="message" id="message">This user has recived the items requeted from the workshop</textarea>

				</div>

				<input name="submit" value="Recive" type="submit" class="btn btn-success" />

			<?php endif ;?>

				</form>

			</div>

		</div>

				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-holder">

			<div class="row">

				<div class="data-head centered">Delivery Date </div>

				<div class="data-holder">

					<?php foreach ($workshop_order_log as $order_log): ?>

						<div><span class="data-head">Delivery Date Updated To </span><?php echo $order_log['delivery_date']; ?> on <span class="data-head"><?php echo $order_log['created']; ?> </span></div>

					<?php endforeach; ?>

				</div>

			</div>

		</div>



		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-holder">

			<div class="row">

				<div class="data-head centered">Comments </div>

				<div class="data-holder">

					<?php foreach ($comments as $comment): ?>

						<div><span class="data-head"><?php echo $comment['fullname']; ?> :- </span><?php echo $comment['comment']; ?></div>

					<?php endforeach; ?>

				</div>

			</div>

		</div>

		<?php if ($workshop_requests['state_id'] >= 6 ): ?>

		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-holder">

			<div class="row">

				<div class="data-head centered">Reciver </div>

				<div class="data-holder">

					<?php foreach ($reciver as $recive): ?>

						<div><span class="data-head"><?php echo $recive['fullname']; ?> :- </span><?php echo $recive['message']; ?> on <span class="data-head"><?php echo $recive['created']; ?> </span></div>

					<?php endforeach; ?>

				</div>

			</div>

		</div>

					<?php endif ;?>



<?php endif ?>

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

</div>

<script type="text/javascript">

	function printDiv(divName) {

     var printContents = document.getElementById(divName).innerHTML;

     var originalContents = document.body.innerHTML;



     document.body.innerHTML = printContents;



     window.print();



     document.body.innerHTML = originalContents;

}



</script>

</body>

</html>