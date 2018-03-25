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
       						<button onclick="myFunction();" class="non-printable form-actions btn btn-success" href="" style="float:left;">Print</button>
							<a class="form-actions btn btn-info non-printable" href="/bd_use/mailme/<?php echo $use['id'] ?>" style="float:left; margin-left: 20px;" > <img src="/assets/images/letter.png" style="width: 28px; height: 40px; margin: 0px; margin-left: -10px; margin-top: -10px; margin-bottom: -10px;"> Share by Email </a>
							<a data-text="whatsapp" data-link="<?php echo base_url(); ?>bd_use/view/<?php echo $use['id'] ?>" style="float:left; margin-left: 20px;" class="whatsapp whatsapp_btn whatsapp_btn_small form-actions btn btn-success non-printable"> <img src="/assets/images/original.png" style="width: 70px; height: 50px; margin: -20px; margin-left: -30px; margin-top: -21px;"> Share by Whatsapp</a> 
							<?php if ($is_editor): ?>
								<a class="form-actions btn btn-info non-printable" href="/bd_use/edit/<?php echo $use['id'] ?>" style="float:right;" > Edit </a>
							<?php endif ?>
       						<a class="form-actions btn btn-success non-printable" href="/bd_use" style="float:right; margin-right: 20px;" > Back </a>
       						<br>
       						<br>
       						<br>
							<div class="header-logo"><img src="/assets/uploads/logos/<?php echo $use['logo']; ?>"/></div>
								<h1 class="centered"><?php echo  $use['hotel_name']; ?></h1>
								<h3 class="centered">
									<?php echo $use['type_name']; ?> Request Form No. #<?php echo $use['id']; ?>
								</h3>  
							</div>
							<div class="col-lg-offset-0 col-lg-12 col-md-12 col-md-offset-0">
					            <table class="table table-striped table-bordered table-condensed centered">
					                <tbody id="items-container" data-items="1">
						                <tr class="item-row">
						                    <td class="align-left table-label">Room</td>
						                    <td class="align-left table-label">No. Pax</td>
						                    <td class="align-left table-label">No. Child</td>
						                    <td class="align-left table-label">Date</td>
						                    <td class="align-left table-label">Type</td>
						                    <td class="align-left table-label">Guest</td>
						                    <td class="align-left table-label">Nationality</td>
						                    <td class="align-left table-label">Arrival Date</td>
						                    <td class="align-left table-label">Departure Date</td>
						                    <td class="align-left table-label">Operator</td>
						                    <td class="align-left table-label">Reason</td>
						                  </tr>
										<?php foreach ($items as $item):?>
						                    <tr id="item-1">
							                    <td class="centered">
													<?php echo $item['room']; ?>
												</td>
												<td class="centered">
													<?php echo $item['pax']; ?>
												</td>
												<td class="centered">
													<?php echo $item['child']; ?>
												</td>
												<td class="centered">
													<?php echo $item['date']; ?>
												</td>
												<td class="centered">
													<?php echo $item['type']; ?>
												</td>
												<td class="centered">
													<?php echo $item['guest']; ?>
												</td>
												<td class="centered">
													<?php echo $item['nationality']; ?>
												</td>
												<td class="centered">
													<?php echo $item['arrival']; ?>
												</td>
												<td class="centered">
													<?php echo $item['departure']; ?>
												</td>
												<td class="centered">
													<?php echo $item['operator_name']; ?>
												</td>
												<td class="centered">
													<?php echo $item['reason']; ?>
												</td>
											</tr>
										<?php endforeach ?>	
									</tbody>
								</table>		
								<div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0  data-indention non-printable">
									<hr style="width: 730px;">
									<label for="offers" class="col-lg-8 col-md-10 col-sm-8 col-xs-8 control-label" style="font-family: Calibri; font-size: 18px; font-weight: bold;">Report Files:</label>
									<div class="form-group col-lg-9 col-md-8 col-sm-7 col-xs-7">
										<?php foreach($uploads as $upload): ?>
											<p> <a href='/assets/uploads/files/<?php echo $upload['name'] ?>'><?php echo $upload['name'] ?></a> Uploaded by <?php echo $upload['user_name'] ?></p>
										<?php endforeach ?>			
									</div>
								</div>
							</div>	
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher centered">
								<?php $queue_first = TRUE; ?>
								<?php foreach ($signers as $signe_id => $signer): ?>
									<div class="signature-wrapper">
										<div class="data-head relative"><?php echo (strlen($signer['role']) == 0)? "use Owner" : ($signer['role_id'] == '7')? $signer['department'] : $signer['role']."&nbsp".$signer['department']; ?>
											<span class="expander-container"><i class='glyphicon glyphicon-envelope'></i></span>
											<div class="expander-wrapper">
												<span class="expander-remover"><i class='glyphicon glyphicon-remove'></i></span>
												<div class="expander">
													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-holder">
														<div class="row">
															<form action="/bd_use/mailto/<?php echo $use['id']; ?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
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
													<a href="/bd_use/unsign/<?php echo $signe_id; ?>" class="non-printable btn btn-primary unsign">Cancel</a>
												<?php endif ?>
											</div>
											<div class="data-content">
												<span class="name-data-content"><?php echo $signer['sign']['name']; ?></span>
												<br />
												<span class="timestamp-data-content"><?php echo $signer['sign']['timestamp']; ?></span>
											</div>
										<?php elseif (array_key_exists($user_id, $signer['queue']) && $queue_first): ?>
											<?php $queue_first = FALSE; ?>
											<div class="data-content non-printable">
												<span class="data-label sign-data-content"></span>
												<a href="/bd_use/sign/<?php echo $signe_id; ?>/reject" class="non-printable btn btn-danger">Reject</a>
												<a href="/bd_use/sign/<?php echo $signe_id; ?>" class="non-printable btn btn-success">sign</a>
											</div>
										<?php else: ?>
											<?php $queue_first = FALSE; ?>
										<?php endif ?>
									</div>
									<?php if (isset($signer['sign']['reject'])){break;}?>
								<?php endforeach ?>
							</div>
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher non-printable">
								<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<form action="/bd_use/comment/<?php echo $use['id']?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
										<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
											<textarea class="form-control" name="comment" id="comment"></textarea>
										</div>
										<input name="set_id" value="<?php echo $use['id']?>" type="hidden" />
										<input name="submit" value="Comment" type="submit" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-actions btn btn-success " />
									</form>
								</div>
							</div>
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-holder">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher">
									<div class="data-head centered"> 
										<h3>Comments</h3> 
									</div>
									<div class="data-holder">
										<?php foreach($comments as $comment ){ ?>
											<div class="data-holder">
												<span class="data-head"><?php echo $comment['fullname']; ?> :- </span><?php echo $comment['comment']; ?>
												<span class="timestamp-data-content"><?php echo $comment['created'];?></span>
											</div>
										<?php } ?>
									</div>  
								</div>
							</div>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-holder">
							<p class="centered">The <?php echo $use['type_name']; ?> Request has been created by <?php echo $use['name'];?> at <?php echo $use['timestamp'];?></p>											
						</div>
					</div>
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
	    	<script>
				function myFunction() {
    				window.print();
				}
			</script>
			<script type="text/javascript">
				$(document).ready(function() {
   	 				$(document).on("click",'.whatsapp',function() {
						if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
        					var text = $(this).attr("data-text");
        					var url = $(this).attr("data-link");
        					var message = encodeURIComponent(text)+" - "+encodeURIComponent(url);
        					var whatsapp_url = "whatsapp://send?text="+message;
        					window.location.href= whatsapp_url;
						} else {
    						alert("Please share this post in your mobile device");
						}
    				});
				});
			</script>
			<script type = "text/javascript" >
			   function preventBack(){window.history.forward();}
			    setTimeout("preventBack()", 0);
			    window.onunload=function(){null};
			</script>
	</body>
</html>