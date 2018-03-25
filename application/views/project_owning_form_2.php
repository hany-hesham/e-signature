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
		<br>
		<br>
		<br>
		<br>
		<br>
		<table class="table table-striped table-bordered table-condensed">
				<tr class="item-row">
					<td class="align-left table-label">
						<span style="font-size: 18px; font-weight: bolder;"> Owning Company: </span>
					</td>
					<td>
						<span style="font-size: 16px;"><?php echo $project['company_name']; ?></span>
					</td>
				</tr>
		</table>
		<br>
		<br>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher centered">
			<?php $sign_enabled = TRUE; ?>
			<?php foreach ($signers as $signe_id => $signer): ?>
				<div class="signature-wrapper">
					<div class="data-head relative"><?php echo ($signer['role_id'] == 26)? "Mr. Hesham/Eng Nadine" : $signer['role'] ?>
						<span class="expander-container"><i class='glyphicon glyphicon-envelope'></i></span>
						<div class="expander-wrapper">
							<span class="expander-remover"><i class='glyphicon glyphicon-remove'></i></span>
							<div class="expander">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-holder">
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
								<a href="/project_owning/unsign_other/<?php echo $signe_id; ?>" class="btn btn-primary unsign">Cancel</a>
							<?php endif ?>
						</div>
						<div class="data-content"><span class="name-data-content"><?php echo $signer['sign']['name']; ?></span>
							<br /><span class="timestamp-data-content"><?php echo $signer['sign']['timestamp']; ?></span></div>
									<?php elseif (array_key_exists($user_id, $signer['queue'])&& $sign_enabled): ?>
										<div class="data-content non-printable"><span class="data-label sign-data-content"></span><a href="/project_owning/reject_other/<?php echo $signe_id; ?>" class="btn btn-danger">Reject</a><a href="/project_owning/sign_other/<?php echo $signe_id; ?>" class="btn btn-success">sign</a></div>
									<?php else: ?>
								<?php $sign_enabled = FALSE; ?>
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
							
						</div>
</html>
