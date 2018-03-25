<?php 
	function array_assoc_value_exists($arr, $index, $search) {
		foreach ($arr as $key => $value) {
			if ($value[$index] == $search) {
				return TRUE;
			}
		}
		return FALSE;
	}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php $this->load->view('header'); ?>
	</head>
	<body>
		<form action="" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
			<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<label for="consultant" class="col-lg-3 col-md-4 col-sm-5 col-xs-5 control-label">إعتماد الإستشاري</label>
				<div class="col-lg-6 col-md-8 col-sm-8 col-xs-8">
					<input type="text" class="form-control" name="consultant" id="consultant" value="<?php echo $project['consultant']; ?>"  />
				</div>
			</div>
			<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<label for="recommendation" class="col-lg-3 col-md-4 col-sm-5 col-xs-5 control-label">التوصيه</label>
				<div class="col-lg-6 col-md-8 col-sm-8 col-xs-8">
					<input type="text" class="form-control" name="recommendation" id="recommendation" value="<?php echo $project['recommendation']; ?>"  />
				</div>
			</div>
			<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<label for="balance" class="col-lg-3 col-md-4 col-sm-5 col-xs-5 control-label">ضمن الموازنه المعتمده</label>
				<div class="col-lg-6 col-md-8 col-sm-8 col-xs-8">
					<input type="text" class="form-control" name="balance" id="balance" value="<?php echo $project['balance']; ?>"  />
				</div>
			</div>
			<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<label for="purchasing_notes" class="col-lg-3 col-md-4 col-sm-5 col-xs-5 control-label">ملاحظات المشتريات</label>
				<div class="col-lg-6 col-md-8 col-sm-8 col-xs-8">
					<input type="text" class="form-control" name="purchasing_notes" id="purchasing_notes" value="<?php echo $project['purchasing_notes']; ?>"  />
				</div>
			</div>
			<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<label for="financial_notes" class="col-lg-3 col-md-4 col-sm-5 col-xs-5 control-label">ملاحظات الإداره المالية</label>
				<div class="col-lg-6 col-md-8 col-sm-8 col-xs-8">
					<input type="text" class="form-control" name="financial_notes" id="financial_notes" value="<?php echo $project['financial_notes']; ?>"  />
				</div>
			</div>
			<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
			    <div class="col-lg-offset-3 col-lg-10 col-md-10 col-md-offset-3">
			    	<input name="submit" value="Update" type="submit" class="btn btn-success submitter non-printable" />
			    	<a href="/project_owning" class="btn btn-warning non-printable">Go Back</a>
			    </div>
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher">
				<?php $hany = array(); ?>
				<?php $queue_first = TRUE; ?>
				<?php foreach ($signers as $signe_id => $signer): ?>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
					<div class="signature-wrapper">
						<div class="data-head relative"><?php echo (strlen($signer['role']) == 0)? "Project Owner" : $signer['role'] ?>
							<span class="expander-container"><i class='glyphicon glyphicon-envelope'></i></span>
							<div class="expander-wrapper">
								<span class="expander-remover"><i class='glyphicon glyphicon-remove'></i></span>
								<div class="expander">
									<div class="col-lg-10 col-md-10 col-sm-10 col-xs-10 data-holder">
										<div class="row">
											<form action="/project_owning/mailto/<?php echo $project['id']; ?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
												<?php if (isset($signer['sign'])): ?>
													<?php $i=1; ?>
													<input checked="checked" type="radio" name="mail" value="<?php echo $signer['sign']['mail'] ?>" /><label>To: <?php echo $signer['sign']['name'] ?></label>
												<?php else: ?>
													<?php $i=0; foreach ($signer['queue'] as $id => $approve): ?>
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
						<?php if (isset($signer['sign'])): ?>
							<div class="data-content"><img src="<?php echo isset($signer['sign']['reject'])? $signature_path.'rejected.png' : $signature_path.'approved.png'; ?>" alt="<?php echo $signer['sign']['name']; ?>" class="img-rounded sign-image">
								<?php if ($signer['sign']['id'] == $user_id): ?>
									<a href="/project_owning/unsign/<?php echo $signe_id; ?>" class="btn btn-primary unsign">Cancel</a>
								<?php endif ?>
							</div>
							<div class="data-content"><span class="name-data-content"><?php echo $signer['sign']['name']; ?></span>
							<br /><span class="timestamp-data-content"><?php echo $signer['sign']['timestamp']; ?></span></div>
						<?php elseif (array_key_exists($user_id, $signer['queue']) && $queue_first): ?>
							<?php $queue_first = FALSE; ?>
							<?php $hany['id'] = $signe_id;?>
							<?php $hany['dead_line'] = $signer['dead_line'];?>
							<?php $hany['new_dead'] = $signer['new_dead'];?>
							<?php $hany['delay_reason'] = $signer['delay_reason'];?>
							<div class="data-content non-printable"><span class="data-label sign-data-content"></span><a href="/project_owning/reject/<?php echo $signe_id; ?>" class="btn btn-danger">Reject</a><a href="/project_owning/sign/<?php echo $signe_id; ?>" class="btn btn-success">sign</a></div>
						<?php else: ?>
				            <?php $queue_first = FALSE; ?>
						<?php endif ?>
					</div>
					<form action="/project_owning/delay_reason/<?php echo $project_id; ?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
							<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
								<label for="consultant" class="col-lg-8 col-md-8 col-sm-8 col-xs-8 control-label">Target Date</label>
								<input type="text" class="form-control" readonly="readonly" style="width: 250px; height:33px;" value="<?php echo $signer['dead_line']; ?>" />
							</div>
							<br>
							<br>
							<?php if (!$signer['new_dead']) { ?>
							<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
									<label for="consultant" class="col-lg-8 col-md-8 col-sm-8 col-xs-8 control-label">New Target Date</label>
									<div class='input-group date' id='datetimepicker1' style="width: 250px; height:33px;">
			                          	<input type='text' class="form-control" name="new_dead" value="<?php echo $signer['new_dead']; ?>"/>
			                          	<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
			                      	</div>
								</div>
							<?php } ?>
							<br>
							<br>
							<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
								<label for="consultant" class="col-lg-8 col-md-8 col-sm-8 col-xs-8 control-label">Delay Reasons</label>
								<input type="text" class="form-control" name="signe_id" style="display: none;" value="<?php echo $signe_id; ?>" />
								<textarea class="form-control" name="delay_reason"><?php echo $signer['delay_reason'];?></textarea>
							</div>
							<br>
							<br>
							<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
								<input name="submit" value="Submit" type="submit" style="margin-top: 30px;" class="inverse-offset btn btn-success" />
				<br>
				<br>
							</div>
					</form>
				</div>
				<?php endforeach ?>
				</div>
			</form>
		<div class="holder">Please Wait...</div>
	</body>
	<script type="text/javascript">
      $(function () {
        $('#datetimepicker1').datetimepicker({
          format: 'YYYY-MM-DD'
        });
      });
    </script>  
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
