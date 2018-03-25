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
		<div id="wrapper">
			<?php $this->load->view('menu') ?>
			<div id="page-wrapper">
					<div class="a4wrapper">
						<div class="a4page">
							<div class="page-header">
       							<button onclick="window.print()" class="non-printable form-actions btn btn-success" href="" >Print</button>
       							<br>
							    <div class="header-logo"><img src="/assets/uploads/logos/<?php echo $project['logo']; ?>"/></div>
							    <br>
                  				<h1 class="centered"><?php echo $project['hotel_name']; ?></h1>
                  				<br>
	        					<h3 class="centered">
	        						Approval request No. #<?php echo $project['id'];?> unplanned project
	        					</h3>
	        					<br>
	    					</div>
	    					<?php if(false): //(isset($message)): ?>
						    	<div class="alert alert-<?php echo $message['type']; ?>">
						        	<strong><?php echo $message['head']; ?></strong>
						        	<p><?php echo (isset($message['body'])) ? $message['body'] : ''; ?></p>
						    	</div>
	    					<?php endif ?>
	    					<br>
							<table class="table table-striped table-bordered table-condensed">
								<tbody>
									<tr class="item-row">
										<td class="align-left table-label"><span style="font-size: 18px; font-weight: bolder;"> From: </span></td><td><span style="font-size: 16px;"><?php echo $project['hotel_name']; ?></span></td>
									</tr>
									<tr class="item-row">
										<td class="align-left table-label"><span style="font-size: 18px; font-weight: bolder;"> Project Name: </span></td><td><span style="font-size: 16px;"><?php echo $project['project_name']; ?></span></td>
									</tr>
									<tr class="item-row">
										<td class="align-left table-label"><span style="font-size: 18px; font-weight: bolder;"> Reason for this project: </span></td><td><span style="font-size: 16px;"><?php echo $project['reasons']; ?></span></td>
									</tr>
									<tr class="item-row">
										<td class="align-left table-label"><span style="font-size: 18px; font-weight: bolder;"> Owning Company: </span></td><td><span style="font-size: 16px;"><?php echo $project_company['company_name']; ?></span></td>
									</tr>
									<tr class="item-row">
										<td class="align-left table-label"><span style="font-size: 18px; font-weight: bolder;"> Estimated Financial Cost: </span></td><td><span style="font-size: 16px;"><?php echo $project['budget']; ?></span></td>
									</tr>
								</tbody>
							</table>
							<br>
							<br>
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher centered">
							<?php foreach ($signers as $signe_id => $signer): ?>
								<div class="signature-wrapper">
									<div class="data-head relative"><?php echo (strlen($signer['role']) == 0)? "Project Owner" : $signer['role'] ?>
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
										<a href="/requests/unsign_owning/<?php echo $signe_id; ?>" class="btn btn-primary unsign">Cancel</a>
									<?php endif ?>
										</div>
										<div class="data-content"><span class="name-data-content"><?php echo $signer['sign']['name']; ?></span>
										<br /><span class="timestamp-data-content"><?php echo $signer['sign']['timestamp']; ?></span></div>
									<?php elseif (array_key_exists($user_id, $signer['queue'])): ?>
										<div class="data-content non-printable"><span class="data-label sign-data-content"></span><a href="/requests/reject/<?php echo $signe_id; ?>" class="btn btn-danger">Reject</a><a href="/requests/sign/<?php echo $signe_id; ?>" class="btn btn-success">sign</a></div>
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
                				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<form action="/project_owning/comment/<?php echo $project_id; ?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
							<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                     						<textarea class="form-control" name="comment" id="comment"></textarea>
                    					</div>
									<input name="submit" value="Comment" type="submit" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-actions btn btn-success " />
									</form>

                				</div>
              				</div>
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-holder">
                				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher">
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
