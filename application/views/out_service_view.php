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
            			<div>
              				<div class="page-header">
       							<button onclick="window.print()" class="non-printable form-actions btn btn-success" href="">Print</button>
								<?php if ($is_editor): ?>
									<a class="form-actions btn btn-info non-printable" href="/out_service/edit/<?php echo $out_service['id'] ?>" style="float:right;" > Edit </a>
								<?php endif ?>
								<div class="header-logo"><img src="/assets/uploads/logos/<?php echo $out_service['logo']; ?>"/></div>
		                  		<h1 class="centered"><?php echo $out_service['hotel_name']; ?></h1>
			        			<h3 class="centered" dir="rtl">
			        				نموذج تكهين<span>No. #<?php echo $out_service['id']; ?></span>
			        			</h3>
			        			<h3 class="centered">
			        				Serial Number <?php echo $out_service['serial']; ?>
			        			</h3>
			        			<h3 class="centered">
			        				Department <?php echo $out_service['department']; ?>
			        			</h3>
			        			<a class="form-actions btn btn-info non-printable" href="/out_service/mail_me/<?php echo $out_service['id'] ?>" style="float:left; margin-left: 20px;" > <img src="/assets/images/letter.png" style="width: 28px; height: 40px; margin: 0px; margin-left: -10px; margin-top: -10px; margin-bottom: -10px;"> Share by Email </a>
								<a data-text="whatsapp" data-link="<?php echo base_url(); ?>out_service/view/<?php echo $out_service['id'] ?>" style="float:left; margin-left: 20px;" class="whatsapp whatsapp_btn whatsapp_btn_small form-actions btn btn-success non-printable"> <img src="/assets/images/original.png" style="width: 70px; height: 50px; margin: -20px; margin-left: -30px; margin-top: -21px;"> Share by Whatsapp</a> 
								<a class="form-actions btn btn-success non-printable" href="/out_service" style="float:right;"> Back </a>
			        			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher data-indention">
				        			<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
	                  					<label for="from-hotel" class="control-label " style="width: 160px;"> Date and Time: </label>
	                  					<label for="from-type" class="control-label " style="width:200px;"><?php echo $out_service['date'] ?></label>
	                  				</div>
	                  			</div>
                  				<table class="table table-striped table-bordered table-condensed">
				                    <tr>
				                        <th colspan="1" style=" text-align: center;">#</th>
				                        <th colspan="1" style=" text-align: center;">Numbur of Items</th>
				                        <th colspan="1" style=" text-align: center;">Description</th>
				                        <th colspan="1" style=" text-align: center;">Serial Number</th>
				                        <th colspan="1" style=" text-align: center;">Reason</th>
				                        <th colspan="1" style=" text-align: center;">Attachment</th>
				                    </tr>
									<?php $count = 1; ?>
									<?php foreach ($items as $item): ?>
										<tr class="item-row" style="font-size: 12px;">
											<td class="centered"><?php echo $count; ?></td>
											<td class="centered"><?php echo $item['quantity']; ?></td>
											<td class="centered"><?php echo $item['description']; ?></td>
											<td class="centered"><?php echo $item['serial_number']; ?></td>
											<td class="centered"><?php echo $item['reason']; ?></td>
											<td class="centered">
												<div style="display:none;">
												 	<div id="bio-john<?php echo $item['id']; ?>">
												 		<p>
												   			<img style="width: 500px; height: 500px;" src="/assets/uploads/files/<?php echo $item['fille']; ?>"/>
												 		</p>
												   	</div>
												</div>
												<a href="#" data-featherlight="#bio-john<?php echo $item['id']; ?>">
													<img style="width: 100px; height: 100px;" src="/assets/uploads/files/<?php echo $item['fille']; ?>"/>
												</a>
											
											</td>
										</tr>
										<?php $count++; ?>
									<?php endforeach ?>
								</table>
								<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
	                  				<label for="from-hotel" class="control-label " style="width: 160px;"> Where Does It Go? </label>
	                  				<label for="from-type" class="control-label " style="width:200px;"><?php echo $out_service['reason_name']; ?></label>
	                  			</div>
	                  			<?php if($out_service['reason'] == 4):?>
	                  				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
		                  				<label for="from-hotel" class="control-label " style="width: 160px;"> Sister Hotel Name: </label>
		                  				<label for="from-type" class="control-label " style="width:200px;"><?php echo $out_service['sister_name']; ?></label>
		                  			</div>
	                  			<?php endif;?>
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher data-indention non-printable">
			                      	<label for="offers" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">Report Files</label>
									<div class="form-group col-lg-9 col-md-8 col-sm-7 col-xs-7">
			                       		<?php foreach($uploads as $upload): ?>
			                       			<p><a href='/assets/uploads/files/<?php echo $upload['name'] ?>'><?php echo $upload['name'] ?></a> Uploaded by <?php echo $upload['user_name'] ?></p>
			                        	<?php endforeach ?>			
			                      	</div>	
		                      	</div>
		                    </div>
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher centered">
				                <?php $queue_first = TRUE; ?>
				                <?php foreach ($signers as $signe_id => $signer): ?>
				                	<div class="signature-wrapper">
				                  		<div class="data-head relative"><?php echo (strlen($signer['role']) == 0)? "Upgrade Owner" : ($signer['role_id'] == '7')? $signer['department'] : $signer['role']."&nbsp".$signer['department']; ?>
				                    		<span class="expander-container"><i class='glyphicon glyphicon-envelope'></i></span>
				                    		<div class="expander-wrapper">
				                      			<span class="expander-remover"><i class='glyphicon glyphicon-remove'></i></span>
				                      			<div class="expander">
				                        			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-holder">
				                          				<div class="row">
				                            				<form action="/out_service/mail/<?php echo $out_service['id']; ?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
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
				                    				<a href="/out_service/unsign/<?php echo $signe_id; ?>" class="non-printable btn btn-primary unsign">Cancel</a>
				                    			<?php endif ?>
				                  			</div>
				                  			<div class="data-content">
				                  				<span class="name-data-content"><?php echo $signer['sign']['name']; ?></span>
				                  				<br />
				                  				<span class="timestamp-data-content"><?php echo $signer['sign']['timestamp']; ?></span>
				                  			</div>
				                  		<?php elseif (array_key_exists($user_id, $signer['queue']) && $queue_first): ?>
				                  			<?php $queue_first = FALSE; ?>
				                  			<div class="data-content non-printable"><span class="data-label sign-data-content"></span><a href="/out_service/sign/<?php echo $signe_id; ?>/reject" class="non-printable btn btn-danger">Reject</a><a href="/out_service/sign/<?php echo $signe_id; ?>" class="non-printable btn btn-success">sign</a></div>
				                  		<?php else: ?>
				                  			<?php $queue_first = FALSE; ?>
				                  		<?php endif ?>
				                	</div>
				                    <?php if (isset($signer['sign']['reject'])){break;}?>
				                <?php endforeach ?>
				            </div>
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher non-printable">
	                			<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
	                  				<form action="/out_service/comment/<?php echo $out_service['id']?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
	                    				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
	                     					<textarea class="form-control" name="comment" id="comment"></textarea>
	                    				</div>
	                    				<input name="out_id" value="<?php echo $out_service['id']?>" type="hidden" />
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
		                      					<span class="timestamp-data-content"><?php echo $comment['timestamp'];?></span>
		                    				</div>
	                    				<?php } ?>
	                  				</div>
	                			</div>  
	                		</div>
						</div>
	    			</div>
					<div class="data-content">
	    				<p class="centered">The Retired Items Form has been created by <?php echo $out_service['name'];?> at <?php echo $out_service['timestamp'];?></p>
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
    	<script type="text/javascript">
      		function printDiv(divName) {
        		var printContents = document.getElementById(divName).innerHTML;
        		var originalContents = document.body.innerHTML;
        		document.body.innerHTML = printContents;
        		window.print();
        		document.body.innerHTML = originalContents;
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
	</body>
</html>