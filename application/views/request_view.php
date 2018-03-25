<!DOCTYPE html>
<html lang="en">
<head>
<?php $this->load->view('header'); ?>
</head>
<body>
<div id="wrapper">
	<?php $this->load->view('menu') ?>
	<div id="page-wrapper">
       	<button onclick="window.print()" class="non-printable form-actions btn btn-success printer" href="" >Print</button><br /><br />
	<div class="a4wrapper">

	<div class="a4page">
		<div class="page-header">
	        <h1 class="centered">Approval request #<?php echo $project_id; ?> unplanned project</h1>
	        <?php if($project['new'] == 1): ?>
	        	<h3 class="centered">New Equipment</h3>
	        <?php endif ?>
	        <?php if($is_editor || $is_admin): ?>
	        	<a class="form-actions btn btn-info non-printable" href="/requests/edit/<?php echo $project_id ?>" >Edit Project </a>
	        <?php endif ?>
	        <?php if($isGM || $is_admin): ?>
	        	<a class="form-actions btn btn-info non-printable" href="/requests/change/<?php echo $project_id ?>" >Change </a>
	        <?php endif ?>
	    </div>
		<div class="align-center page-header non-printable">
			<?php if ($project['state_id'] == 2): ?>
				<a href="/projects/submit/<?php echo $project['project_code']; ?>" class="btn btn-success">
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				Create Project&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
				<br />
				<br />
			<?php endif ?>
		</div>
	    <?php if(false): //(isset($message)): ?>
	    	<div class="alert alert-<?php echo $message['type']; ?>">
	        	<strong><?php echo $message['head']; ?></strong>
	        	<p><?php echo (isset($message['body'])) ? $message['body'] : ''; ?></p>
	    	</div>
	    <?php endif ?>

	    <table class="table table-striped table-bordered table-condensed">
			<tbody>
				<tr class="item-row">
					<td class="align-right table-label" <?php if ($project['change_unplanned'] == 1):?> colspan="2" <?php endif; ?> style="text-align: left;">Hotel:</td><td  colspan= 2><?php echo $project['hotel_name']; ?></td>
				</tr>
				<tr class="item-row">
					<td class="align-right table-label"  <?php if ($project['change_unplanned'] == 1):?> colspan="2" <?php endif; ?> style="text-align: left;">Project Type:</td><td  colspan= 2><?php echo $project['type_name']; ?></td>
				</tr>
				<tr class="item-row">
					<td class="align-right table-label"  <?php if ($project['change_unplanned'] == 1):?> colspan="2" <?php endif; ?> style="text-align: left;">Department:</td><td  colspan= 2><?php echo $project['department_name']; ?></td>
				</tr>
				<?php if ($project['change_unplanned'] == 1):?>
					<tr class="item-row">
						<td class="align-right table-label" colspan="2" style="text-align: center;">Original:</td><td class="align-right table-label" colspan="2" style="color: blue; text-align: center;">Changed To:</td>
					</tr>
				<?php endif; ?>
				<tr class="item-row">
					<td class="align-right table-label" style="text-align: left;">Project Name:</td><td><?php echo $project['project_name']; ?></td>
						<?php if ($project['change_unplanned'] == 1):?>
							<td class="align-right table-label" style="text-align: left;">Project Name:</td><td><?php echo $project_change['project_name']; ?></td>
						<?php endif; ?>
				</tr>
				<tr class="item-row">
				  <td class="align-right table-label" style="text-align: left;">Reasons:</td><td><?php echo $project['reasons']; ?></td>
					<?php if ($project['change_unplanned'] == 1):?>
						<td class="align-right table-label" style="text-align: left;">Reasons:</td><td><?php echo $project_change['reasons']; ?></td>
					<?php endif; ?>
				</tr>
				<tr class="item-row">
					<td class="align-right table-label" style="text-align: left;">Create Date:</td><td><?php echo $project['timestamp']; ?></td>
					<?php if ($project['change_unplanned'] == 1):?>
						<td class="align-right table-label" style="text-align: left;">Create Date:</td><td><?php echo $project_change['timestamp']; ?></td>
					<?php endif; ?>
				</tr>
				<tr class="item-row">
					<td class="align-right table-label" style="text-align: left;">Created By:</td><td><?php echo $project['user_name']; ?></td>
				</tr>
			</tbody>
		</table>
		<br />
		<br />
		<br />
		
		<table class="table table-striped table-bordered table-condensed">
			<tbody>
				<?php if ($project['change_unplanned'] == 1):?>
							<tr class="item-row">
								<td class="align-right table-label" colspan="7" style="text-align: center;">Original:</td>
							</tr>
						<?php endif; ?>
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
	<?php if ($project['change_unplanned'] == 1):?>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher data-indention">
			<table class="table table-striped table-bordered table-condensed">
				<tbody>
					<tr class="item-row">
						<td class="align-right table-label" colspan="7" style="color: blue; text-align: center;">Changed To:</td>
					</tr>
					<tr class="item-row">
						<td id="hidden-cell"></td>
						<td class="align-right table-label">Exchange Rate</td>
						<td class="align-right table-label-small">USD:</td>
						<td><?php echo $project_change['USD_EX']; ?></td>
						<td class="align-right table-label-small">EUR:</td>
						<td><?php echo $project_change['EUR_EX']; ?></td>
					</tr>
					<tr>
						<td class="align-right table-label">Budget Cost</td>
						<td colspan="7"><?php echo number_format($project_change['budget'],2,".",","); ?>&nbsp;&nbsp;&nbsp;LE</td>
					</tr>
					<tr class="item-row">
						<td class="align-right table-label"></td>
						<td class="align-right table-label-small">EGP:</td>
						<td><?php echo number_format($project_change['budget_EGP'],2,".",","); ?></td>
						<td class="align-right table-label-small">USD:</td>
						<td><?php echo number_format($project_change['budget_USD'],2,".",","); ?></td>
						<td class="align-right table-label-small">EUR:</td>
						<td><?php echo number_format($project_change['budget_EUR'],2,".",","); ?></td>
					</tr>
				</tbody>
			</table>
		</div>
		<br />
		<br />
<?php endif; ?>
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
									<form action="/requests/<?php if($approver['role_id'] == "1"){ 
										echo "share_url";
									}else{
										echo "mailto";
									} ?>/<?php echo $project['id']; ?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
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
										<?php if($approver['role_id'] != "1"){ ?>
											<textarea class="form-control" name="message" id="message"></textarea>
										<?php } ?>
										<input name="submit" value="Send" type="submit" class="inverse-offset btn btn-success" />
										<?php endif; ?>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php if (isset($approver['sign'])): ?>
					<div class="data-content"><img src="
						<?php if(isset($approver['sign']['reject'])){ 
				         	echo $signature_path.'rejected.png';
				        }else {
				         	if ($approver['sign']['id'] == 217) {
				          		echo $signature_path.'9f3a8-mr.-hossam.jpg';
				         	}else{
				          		echo $signature_path.'approved.png';
				         	}
				        }?>
						" alt="<?php echo $approver['sign']['name']; ?>" class="img-rounded sign-image">
					<?php if (($approver['sign']['id'] == $user_id && $unsign_enable) || $is_admin): ?>
						<a href="/requests/unsign/<?php echo $approve_id; ?>" class="btn btn-primary unsign">Cancel</a>
					<?php endif ?>
					</div>
					<div class="data-content"><span class="name-data-content"><?php echo $approver['sign']['name']; ?></span>
					<br /><span class="timestamp-data-content"><?php echo $approver['sign']['timestamp']; ?></span></div>
				<?php elseif (array_key_exists($user_id, $approver['queue']) && $project['state_id'] != 11 && $queue_first&&$role_id!=142 && $project['change_unplanned'] != 1): ?>
					<?php $queue_first = FALSE; ?>
				      <?php if ($role_id == 1 && $chairman_after==0 ):?>
							<div class="data-content non-printable"><a href="/requests/approve/<?php echo $approve_id; ?>" class="btn btn-success">Approve</a><span class="sep"></span><a href="/requests/approve/<?php echo $approve_id; ?>/reject" class="btn btn-danger">Reject</a></div>
						<?php elseif ($role_id != 1): ?>
							<div class="data-content non-printable"><a href="/requests/approve/<?php echo $approve_id; ?>" class="btn btn-success">Approve</a><span class="sep"></span><a href="/requests/approve/<?php echo $approve_id; ?>/reject" class="btn btn-danger">Reject</a></div>
						<?php endif?>	
					<?php else: ?>
					<?php $queue_first = FALSE; ?>
				<?php endif ?>
			</div>
		
		<?php endforeach ?>

		
       <?php if ($project['change_unplanned'] == 1):?>
			<table class="table table-striped table-bordered table-condensed">
				<tbody>
					<tr class="item-row">
						<td class="align-right table-label" colspan="7" style="color: blue; text-align: center;">Changed To:</td>
					</tr>
				</tbody>
			</table>
			<br>
			<?php $queue_first = TRUE; ?>
			<?php foreach ($signers_change as $approve_id => $approver): ?>
				<div class="signature-wrapper">
					<div class="data-head relative"><?php echo (strlen($approver['role']) == 0)? "Request Owner" : $approver['role'] ?>
						<span class="expander-container"><i class='glyphicon glyphicon-envelope'></i></span>
						<div class="expander-wrapper">
						<span class="expander-remover"><i class='glyphicon glyphicon-remove'></i></span>
							<div class="expander">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-holder">
									<div class="row">
										<form action="/requests/<?php if($approver['role_id'] == "1"){ 
											echo "share_url";
										}else{
											echo "mailto";
										} ?>/<?php echo $project['id']; ?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
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
											<?php if($approver['role_id'] != "1"){ ?>
												<textarea class="form-control" name="message" id="message"></textarea>
											<?php } ?>
											<input name="submit" value="Send" type="submit" class="inverse-offset btn btn-success" />
											<?php endif; ?>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php if (isset($approver['sign'])): ?>
						<div class="data-content"><img src="
							<?php if(isset($approver['sign']['reject'])){ 
					         	echo $signature_path.'rejected.png';
					        }else {
					         	if ($approver['sign']['id'] == 217) {
					          		echo $signature_path.'9f3a8-mr.-hossam.jpg';
					         	}else{
					          		echo $signature_path.'approved.png';
					         	}
					        }?>
							" alt="<?php echo $approver['sign']['name']; ?>" class="img-rounded sign-image">
						<?php if (($approver['sign']['id'] == $user_id && $unsign_enable) || $is_admin): ?>
							<a href="/requests/unsign/<?php echo $approve_id; ?>" class="btn btn-primary unsign">Cancel</a>
						<?php endif ?>
						</div>
						<div class="data-content"><span class="name-data-content"><?php echo $approver['sign']['name']; ?></span>
						<br /><span class="timestamp-data-content"><?php echo $approver['sign']['timestamp']; ?></span></div>
					<?php elseif (array_key_exists($user_id, $approver['queue']) && $project['state_id'] != 11 && $queue_first&&$role_id!=142): ?>
						<?php $queue_first = FALSE; ?>
					      <?php if ($role_id == 1 && $chairman_after==0 ):?>
								<div class="data-content non-printable"><a href="/requests/approve/<?php echo $approve_id; ?>" class="btn btn-success">Approve</a><span class="sep"></span><a href="/requests/approve/<?php echo $approve_id; ?>/reject" class="btn btn-danger">Reject</a></div>
							<?php elseif ($role_id != 1): ?>
								<div class="data-content non-printable"><a href="/requests/approve/<?php echo $approve_id; ?>" class="btn btn-success">Approve</a><span class="sep"></span><a href="/requests/approve/<?php echo $approve_id; ?>/reject" class="btn btn-danger">Reject</a></div>
							<?php endif?>	
						<?php else: ?>
						<?php $queue_first = FALSE; ?>
					<?php endif ?>
				</div>
			
			<?php endforeach ?>
			<?php endif; ?>
		</div>
	    <br>
		<?php if ($owning_company || $is_admin) { ?>
			<a href="#" class="btn btn-success non-printable hanyclose hany-fram-start" style="margin-left: 200px;">Chairman Office</a>
		<?php } ?>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher hanyfram" style="display: none;">
			<a href="#" class="btn btn-success non-printable hany-fram-remover hanyclose">Hide</a>
          	<iframe src="/project_owning/review/<?php echo $project['id']; ?>/1" scrolling="no" style="margin-left:-30px; width: 850px; height: 900px; border: none;"></iframe>
        </div>
        <script type="text/javascript">
			$('.hanyclose').click( function(e) {
			     e.preventDefault();
			});
			$(".hany-fram-start").on("click", function(){
				$(".hanyfram").show();
				$(".hany-fram-start").hide();
				$(this).parent().find(".hany-fram").toggle("fast");
			});
			$(".hany-fram-remover").on("click", function(){
				$(".hanyfram").hide();
				$(".hany-fram-start").show();
				$(this).parent().hide("fast");
				document.location.reload(true);			
			});
			
		</script>
		<?php if($project['hotel_id'] == 5 || $project['hotel_id'] == 42){ ?>
			<?php if ($owning_company || $is_admin) { ?>
				<a href="#" class="btn btn-success non-printable hanyclose1 hany-fram1-start" style=" margin-left: 50px;">Owning company</a>
			<?php } ?>
		<?php } ?>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher hanyfram1" style="display: none;">
			<a href="#" class="btn btn-success non-printable hany-fram-remover1 hanyclose1">Hide</a>
          	<iframe src="/project_owning/review_other/<?php echo $project['id']; ?>/1" scrolling="no" style="margin-left:-30px; width: 850px; height:450px; border: none;"></iframe>
        </div>
        <script type="text/javascript">
			$('.hanyclose1').click( function(e) {
			     e.preventDefault();
			});
			$(".hany-fram1-start").on("click", function(){
				$(".hanyfram1").show();
				$(".hany-fram1-start").hide();
				$(this).parent().find(".hany-fram").toggle("fast");
			});
			$(".hany-fram-remover1").on("click", function(){
				$(".hanyfram1").hide();
				$(".hany-fram1-start").show();
				$(this).parent().hide("fast");
				document.location.reload(true);			
			});
			
		</script>

		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher non-printable">
			<div class="row">
				<form action="/requests/comment/<?php echo $project['id']; ?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
				<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
					<textarea class="form-control" name="comment" id="comment"></textarea>
				</div>
				<input name="submit" value="Comment" type="submit" class="inverse-offset btn btn-success" />
				</form>
			</div>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-holder">
			<div class="row">
				<div class="data-head centered">General Comments </div>
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
<script type="text/javascript">
		$(".expander-container").on("click", function(){
			$(".expander-wrapper").hide();
			$(this).parent().find(".expander-wrapper").toggle("fast");
		});

		$(".expander-remover").on("click", function(){
			$(this).parent().hide("fast");
		});
		</script>
</html>