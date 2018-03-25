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
									<a class="form-actions btn btn-info non-printable" href="/design_request/edit/<?php echo $design['serial'] ?>" style="float:right;" > Edit </a>
								<?php endif ?>
								<div class="header-logo"><img src="/assets/uploads/logos/<?php echo $design['logo']; ?>"/></div>
		                  		<h1 class="centered"><?php echo $design['hotel_name']; ?></h1>
			        			<h3 class="centered" dir="rtl">
			        				Design Request Form <span>No. #<?php echo $design['id']; ?></span>
			        				<?php if ($is_admin): ?>
										<a class="form-actions btn btn-danger non-printable" href="/design_request/delete/<?php echo $design['id'] ?>/<?php echo $design['serial'] ?>/1" > Delete </a>
									<?php endif ?>
			        			</h3>
			        			<h3 class="centered">
			        				Department <?php echo $design['department']; ?>
			        			</h3>
			        			<a class="form-actions btn btn-info non-printable" href="/design_request/mail_me/<?php echo $design['id'] ?>/<?php echo $design['serial'] ?>" style="float:left; margin-left: 20px;" > <img src="/assets/images/letter.png" style="width: 28px; height: 40px; margin: 0px; margin-left: -10px; margin-top: -10px; margin-bottom: -10px;"> Share by Email </a>
			        			<a class="form-actions btn btn-info non-printable" href="/design_request/share_me/<?php echo $design['id'] ?>/<?php echo $design['serial'] ?>" style="float:left; margin-left: 20px;" > <img src="/assets/images/letter.png" style="width: 28px; height: 40px; margin: 0px; margin-left: -10px; margin-top: -10px; margin-bottom: -10px;"> Share by RocketChat </a>
								<a data-text="whatsapp" data-link="<?php echo base_url(); ?>design_request/view/<?php echo $design['serial'] ?>" style="float:left; margin-left: 20px;" class="whatsapp whatsapp_btn whatsapp_btn_small form-actions btn btn-success non-printable"> <img src="/assets/images/original.png" style="width: 70px; height: 50px; margin: -20px; margin-left: -30px; margin-top: -21px;"> Share by Whatsapp</a> 
								<a class="form-actions btn btn-success non-printable" href="/design_request" style="float:right;"> Back </a>
			        			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher data-indention">
				        			<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
	                  					<label for="from-hotel" class="control-label " style="width: 160px;"> Date and Time: </label>
	                  					<label for="from-type" class="control-label " style="width:200px;"><?php echo $design['date'] ?></label>
	                  				</div>
	                  			</div>
	                  			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher data-indention">
				        			<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
	                  					<label for="from-hotel" class="control-label " style="width: 160px;"> Outline: </label>
	                  					<label for="from-type" class="control-label " style="width:200px;"><?php echo $design['outline'] ?></label>
	                  				</div>
	                  			</div>
                  				<table class="table table-striped table-bordered table-condensed">
				                    <tr>
				                        <th colspan="1" style=" text-align: center;">#</th>
				                        <?php if ($is_admin): ?>
				                        	<th colspan="1" style=" text-align: center;">Action</th>
				                        <?php endif; ?>
				                        <th colspan="1" style=" text-align: center;">Scope of Work</th>
				                        <th colspan="1" style=" text-align: center;">Attachment</th>
				                    </tr>
									<?php $count = 1; ?>
									<?php foreach ($items as $item): ?>
										<tr class="item-row" style="font-size: 12px;">
											<td class="centered"><?php echo $count; ?></td>
											<?php if ($is_admin): ?>
												<td class="centered">
													<a class="form-actions btn btn-danger non-printable" href="/design_request/delete/<?php echo $item['id'] ?>/<?php echo $design['serial'] ?>/2" > Delete </a>
												</td>
											<?php endif; ?>
											<td class="centered"><?php echo $item['scope']; ?></td>
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
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher data-indention non-printable">
			                      	<label for="offers" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">Report Files</label>
									<div class="form-group col-lg-9 col-md-8 col-sm-7 col-xs-7">
			                       		<?php foreach($uploads as $upload): ?>
			                       			<p><a href='/assets/uploads/files/<?php echo $upload['name'] ?>'><?php echo $upload['name'] ?></a> Uploaded by <?php echo $upload['user_name'] ?>
			                       				<?php if ($is_admin): ?>
				                       				<a class="form-actions btn btn-danger non-printable" href="/design_request/delete/<?php echo $upload['id'] ?>/<?php echo $design['serial'] ?>/3" > Delete </a></p>
				                       			<?php endif; ?>
			                        	<?php endforeach ?>			
			                      	</div>	
		                      	</div>
		                    </div>
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher centered">
				                <?php $queue_first = TRUE; ?>
				                <?php foreach ($signers as $signe_id => $signer): ?>
				                	<div class="signature-wrapper">
				                  		<div class="data-head relative"><?php echo (strlen($signer['role']) == 0)? "Design Owner" : ($signer['role_id'] == '7')? $signer['department'] : $signer['role']."&nbsp".$signer['department']; ?>
				                    		<span class="expander-container"><i class='glyphicon glyphicon-envelope'></i></span>
				                    		<div class="expander-wrapper">
				                      			<span class="expander-remover"><i class='glyphicon glyphicon-remove'></i></span>
				                      			<div class="expander">
				                        			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-holder">
				                          				<div class="row">
				                            				<form action="/design_request/<?php if($signer['role_id'] == "1"){ 
									                                echo "share_url";
									                              }else{
									                                echo "mail";
									                              } ?>/<?php echo $design['id']; ?>/<?php echo $design['serial']; ?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
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
				                              						<?php if($signer['role_id'] != "1"){ ?>
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
				                  		<?php if (isset($signer['sign'])): ?>
				                  			<div class="data-content"><img src="
					                  			<?php if(isset($signer['sign']['reject'])){ 
					                  				echo $signature_path.'rejected.png';
					                  			}else {
					                  				if ($signer['sign']['id'] == 217) {
					                  					echo $signature_path.'9f3a8-mr.-hossam.jpg';
					                  				}else{
					                  					echo $signature_path.'approved.png';
					                  				}
					                  			}?>
				                  			"  alt="<?php echo $signer['sign']['name']; ?>" class="img-rounded sign-image">
				                    			<?php if (($signer['sign']['id'] == $user_id && $unsign_enable) || $is_admin): ?>
				                    				<a href="/design_request/unsign/<?php echo $signe_id; ?>" class="non-printable btn btn-primary unsign">Cancel</a>
				                    			<?php endif ?>
				                  			</div>
				                  			<div class="data-content">
				                  				<span class="name-data-content"><?php echo $signer['sign']['name']; ?></span>
				                  				<br />
				                  				<span class="timestamp-data-content"><?php echo $signer['sign']['timestamp']; ?></span>
				                  			</div>
				                  		<?php elseif (array_key_exists($user_id, $signer['queue']) && $queue_first  && $role_id !=142): ?>
				                  			<?php $queue_first = FALSE; ?>
				                  			<div class="data-content non-printable"><span class="data-label sign-data-content"></span><a href="/design_request/sign/<?php echo $signe_id; ?>/reject" class="non-printable btn btn-danger">Reject</a><a href="/design_request/sign/<?php echo $signe_id; ?>" class="non-printable btn btn-success">sign</a></div>
				                  		<?php else: ?>
				                  			<?php $queue_first = FALSE; ?>
				                  		<?php endif ?>
				                	</div>
				                    <?php if (isset($signer['sign']['reject'])){break;}?>
				                <?php endforeach ?>
				                <?php if ($design['state_id'] == 2):?>
					                <form action="/design_request/finalize/<?php echo $design['id']; ?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
							            <div class="signature-wrapper">
							               	<div class="data-head relative">
							                	Target date 
							               	</div>
							               	<div class="data-content">
							                	<div class='input-group date' id='datetimepicker1' style="width: 200px; height:33px;">
                      								<input type='text' class="form-control" name="final" placeholder="Date ..." value=""/>
                      								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    							</div>
							                  	<input name="submit" value="Submit" type="submit" class="btn btn-success" />
							                </div>
							            </div>
						            </form>
						        <?php endif; ?>
						        <?php if ($design['state_id'] == 5):?>
						           	<div class="signature-wrapper">
							            <div class="data-head relative">
							               	Target date to finalize the requested design 
							            </div>
							            <div class="data-content" style="margin-top: 15px;">
							               	<span class="name-data-content"><?php echo $design['final']; ?></span>
							            </div>
							        </div>
					            <?php endif; ?>
				            </div>
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher non-printable">
	                			<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
	                  				<form action="/design_request/comment/<?php echo $design['id']?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
	                    				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
	                     					<textarea class="form-control" name="comment" id="comment"></textarea>
	                    				</div>
	                    				<input name="serial" value="<?php echo $design['serial']?>" type="hidden" />
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
	                    					<?php if ($is_admin): ?>
	                    						<a href="#" class="btn btn-warning non-printable hanyclose hany-fram-start">Edit</a>
		                    					<a class="form-actions btn btn-danger non-printable" href="/design_request/delete/<?php echo $comment['id'] ?>/<?php echo $design['serial'] ?>/4" > Delete </a>
		                    				<?php endif; ?>
		                    				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher hanyfram" style="display: none;">
												<a href="#" class="btn btn-success non-printable hany-fram-remover hanyclose">Hide</a>
				         						<form action="/design_request/edit_comment/<?php echo $comment['id']; ?>/<?php echo $design['id']; ?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
				         							<textarea class="form-control" name="comment" id="comment"><?php echo $comment['comment']; ?></textarea>
				                              		<input name="submit" value="Submit" type="submit" class="inverse-offset btn btn-success" />
				         						</form>
				       						</div>
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
	    				<p class="centered">The Design Request Form has been created by <?php echo $design['name'];?> at <?php echo $design['timestamp'];?></p>
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
		<script type="text/javascript">
    		$(function () {
      			$('#datetimepicker1').datetimepicker({
        			format: 'YYYY-MM-DD'
      			});
    		});
  		</script>
	</body>
</html>