<!DOCTYPE html>
<html lang="en">
<head>
<?php $this->load->view('header'); ?>
</head>
<body>
<div id="wrapper">
	<?php $this->load->view('menu') ?>
		<?php $this->load->view('madar_subnav'); ?>
	<div id="page-wrapper">
       	<button onclick="window.print()" class="non-printable form-actions btn btn-success printer" href="" >Print</button><br /><br />
	<div class="a4wrapper">

	<div class="a4page">
		<div class="page-header">
			<div class="header-logo"><img src="<?php echo $logo_path.$project['hotel_logo']; ?>"></div>
	        <h1 class="centered">Madar Project #<?php echo $project_id; ?> </h1>
	        	<?php if($is_editor): ?>
	        	<a class="form-actions btn btn-info non-printable" href="/madar/edit/<?php echo $project_id ?>" >Edit Project </a>
	        	<?php endif ?>
	    </div>

	    <table class="table table-striped table-bordered table-condensed">
			<tbody>
				<tr class="item-row">
					<td class="align-right table-label">Hotel:</td><td><?php echo $project['hotel_name']; ?></td>
				</tr>
				<tr class="item-row">
					<td class="align-right table-label">Project Type:</td><td><?php echo $project['type']; ?></td>
				</tr>
				<tr class="item-row">
					<td class="align-right table-label">Project Name:</td><td><?php echo $project['project_name']; ?></td>
				</tr>
				<tr class="item-row">
					<td class="align-right table-label">Reasons:</td><td><?php echo $project['reasons']; ?></td>
				</tr>

			</tbody>
		</table>
		<br />
		<br />
		<br />
		
		<table class="table table-striped table-bordered table-condensed">
			<tbody>
				<tr class="item-row">
					<td id="hidden-cell"></td>
					<td class="align-right table-label">Exchange Rate</td>
					<td class="align-right table-label-small">USD:</td>
					<td><?php echo $project['USD_EX']; ?></td>
					<td class="align-right table-label-small">EUR:</td>
					<td><?php echo $project['EUR_EX']; ?></td>
				</tr>
				<tr>
					<td class="align-right table-label">Budget Cost</td>
					<td colspan="7"><?php echo number_format($project['budget'],2,".",","); ?>&nbsp;&nbsp;&nbsp;LE</td>
				</tr>
				<tr class="item-row">
					<td class="align-right table-label"></td>
					<td class="align-right table-label-small">EGP:</td>
					<td><?php echo number_format($project['budget_EGP'],2,".",","); ?></td>
					<td class="align-right table-label-small">USD:</td>
					<td><?php echo number_format($project['budget_USD'],2,".",","); ?></td>
					<td class="align-right table-label-small">EUR:</td>
					<td><?php echo number_format($project['budget_EUR'],2,".",","); ?></td>
				</tr>
			</tbody>
		</table>
		<br />
		<br />

		<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher">
			<label for="supplier[]" class="col-lg-2 col-md-3 col-sm-5 col-xs-5 control-label">Files:</label>
			<div class="form-group col-lg-9 col-md-8 col-sm-7 col-xs-7">
		    <?php foreach($files as $file): ?>
				<a href='/assets/uploads/files/<?php echo $file['name'] ?>'><?php echo $file['name'] ?></a><br />
			<?php endforeach ?>
			</div>
		</div>
		<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher">
		</div>

		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-holder">
			<div><span class="data-head">Remarks:</span><div class="inline-text"><?php echo $project['remarks']; ?></div></div>
		</div>

		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher">
		<?php $queue_first = TRUE; ?>

		<?php foreach ($approvers as $approve_id => $approver): ?>
			<div class="signature-wrapper">
				<div class="data-head relative"><?php echo (strlen($approver['role']) == 0)? "Request Owner" : $approver['role'] ?>
					<span class="expander-container"><i class='glyphicon glyphicon-envelope'></i></span>
					<div class="expander-wrapper">
					<span class="expander-remover"><i class='glyphicon glyphicon-remove'></i></span>
						<div class="expander">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-holder">
								<div class="row">
									<form action="/madar/mailto/<?php echo $project['id']; ?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
										<?php if (isset($approver['sign'])): ?>
											<?php $i=1; ?>
											<input checked="checked" type="radio" name="mail" value="<?php echo $approver['sign']['mail'] ?>" /><label>To: <?php echo $approver['sign']['name'] ?></label>
										<?php else: ?>
											<?php $i=0; foreach ($approver['queue'] as $id => $approve): ?>
												<input <?php echo (++$i == 1)? 'checked="checked"' : '' ?> type="radio" name="mail" value="<?php echo $approve['mail'] ?>" id="u<?php echo $id ?>" /><label for="u<?php echo $id ?>">To: <?php echo $approve['name'] ?></label><br />
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
				<?php if (isset($approver['sign'])): ?>
					<div class="data-content"><img src="<?php echo isset($approver['sign']['reject'])? $signature_path.'rejected.png' : $signature_path.'approved.png'; ?>" alt="<?php echo $approver['sign']['name']; ?>" class="img-rounded sign-image">
					<?php if (($approver['sign']['id'] == $user_id && $unsign_enable) || $is_admin): ?>
						<a href="/madar/unsign/<?php echo $approve_id; ?>" class="btn btn-primary unsign">Cancel</a>
					<?php endif ?>
					</div>
					<div class="data-content"><span class="name-data-content"><?php echo $approver['sign']['name']; ?></span>
					<br /><span class="timestamp-data-content"><?php echo $approver['sign']['timestamp']; ?></span></div>
				<?php elseif (array_key_exists($user_id, $approver['queue']) && $queue_first): ?>
					<?php $queue_first = FALSE; ?>
					<div class="data-content non-printable"><a href="/madar/approve/<?php echo $approve_id; ?>" class="btn btn-success">Approve</a><span class="sep"></span><a href="/madar/approve/<?php echo $approve_id; ?>/reject" class="btn btn-danger">Reject</a></div>
					<?php else: ?>
					<?php $queue_first = FALSE; ?>
				<?php endif ?>
			</div>
		
		<?php endforeach ?>
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


		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher non-printable">
			<div class="row">
				<form action="/madar/comment/<?php echo $project['id']; ?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
				<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
					<textarea class="form-control" name="comment" id="comment"></textarea>
				</div>
				<input name="submit" value="Comment" type="submit" class="inverse-offset btn btn-success" />
				</form>
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


	</div>
	</div>
	</div>
</div>
</body>
</html>