<!DOCTYPE html>
<html lang="en">
  	<head>
  		<script type="text/javascript">
           function check()
           {
             $("#checking").show();
           }
       </script>
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
									<a class="form-actions btn btn-info non-printable" href="/credit_app/edit/<?php echo $credit_app['id']?>" style="float:right;" > Sales part</a>
								<?php endif ?>
								<div class="header-logo"><img src="/assets/uploads/logos/<?php echo $credit_app['logo']; ?>"/></div>
		                  		<h1 class="centered"><?php echo $credit_app['hotel_name']; ?></h1>
			        			<h3 class="centered">
			        				Credit Application Form No. #<?php echo $credit_app['id']; ?>
			        			</h3>
			        			<a class="form-actions btn btn-info non-printable" href="/credit_app/mail_me/<?php echo $credit_app['id']?>" style="float:left; margin-left: 20px;" > <img src="/assets/images/letter.png" style="width: 28px; height: 40px; margin: 0px; margin-left: -10px; margin-top: -10px; margin-bottom: -10px;"> Share by Email </a>
								<a data-text="whatsapp" data-link="<?php echo base_url(); ?>/credit_app/mail_me/<?php echo $credit_app['id'] ?>" style="float:left; margin-left: 20px;" class="whatsapp whatsapp_btn whatsapp_btn_small form-actions btn btn-success non-printable"> <img src="/assets/images/original.png" style="width: 70px; height: 50px; margin: -20px; margin-left: -30px; margin-top: -21px;"> Share by Whatsapp</a> 
								<a class="form-actions btn btn-success non-printable" href="/credit_app" style="float:right;"> Back </a>
								<br>
								<br>
	                  		<table class="table table-striped table-bordered table-condensed" style="margin-top: 20px;">
                                  <thead>
                                     <th colspan="4" class="centered">Contact Person</th>
                                  </thead>	
								                  <tr>
                                     <td style = "font-size: 14px; font-weight: bold;">Name</td>  
                                     <td><?php echo $credit_app['per_name'] ?></td>
                                  </tr>
                                  <tr>
                                     <td style = "font-size: 14px; font-weight: bold;">Title</td> 
                                     <td><?php echo $credit_app['title'] ?></td>
                                  </tr>  
                                  <tr>
                                     <td style = "font-size: 14px; font-weight: bold;">Telephone</td> 
                                     <td><?php echo $credit_app['tel'] ?></td>
                                  </tr>  
                                  <tr>
                                     <td style = "font-size: 14px; font-weight: bold;">E-Mail</td> 
                                     <td><?php echo $credit_app['mail'] ?></td>
                                  </tr>  
						            	</table>
						              	<br>
						              	<br>
                            <table class="table table-striped table-bordered table-condensed" style="margin-top: 16px;">
                                  <thead>
                                     <th colspan="2" class="centered">Company Details</th>
                                     <th colspan="2" class="centered">BANK References</th>
                                  </thead>	
							                	  <tr>
                                     <td style = "font-size: 14px; font-weight: bold;">Company Name</td>  
                                     <td><?php echo $credit_app['comp_name'] ?></td>
                                     <td style = "font-size: 14px; font-weight: bold;">Bank Name</td>  
                                     <td><?php echo $credit_app['bank_name'] ?></td>
                                  </tr>
                                  <tr>
                                     <td style = "font-size: 14px; font-weight: bold;">Nature of Business</td> 
                                     <td><?php echo $credit_app['business_nature'] ?></td>
                                      <td style = "font-size: 14px; font-weight: bold;">Account Number</td> 
                                     <td><?php echo $credit_app['acc_num'] ?></td>
                                  </tr>  
                                  <tr>
                                     <td style = "font-size: 14px; font-weight: bold;">Address</td> 
                                     <td><?php echo $credit_app['comp_address'] ?></td>
                                      <td style = "font-size: 14px; font-weight: bold;">Bank Address</td> 
                                     <td><?php echo $credit_app['bank_address'] ?></td>
                                  </tr>  
                                  <tr>
                                     <td style = "font-size: 14px; font-weight: bold;">Company Telephone</td> 
                                     <td><?php echo $credit_app['comp_tel'] ?></td>
                                      <td style = "font-size: 14px; font-weight: bold;">Bank Telephone</td> 
                                     <td><?php echo $credit_app['bank_tel'] ?></td>
                                  </tr>  
							</table>
							<br>
							<br>
							<br>
							<table class="table table-striped table-bordered table-condensed">
                                  <thead>
                                  	<tr>
                                  		<th colspan="4" class="centered">Two other hotels, with which you have credit or credit history</th>
                                  	</tr>
                                  	<tr>
                                  	 <th colspan="2" class="centered">First Hotel</th>
                                     <th colspan="2" class="centered">Second Hotel</th>	
                                     </tr>	
                                  </thead>	
								                <tr>
                                   <?php foreach ($credit_app_hotels as  $item) :?>	
                                     <td style = "font-size: 14px; font-weight: bold;">Hotel</td>  
                                     <td><?php echo $item['hotel'] ?></td>
                                   <?php endforeach ?>
                                  </tr>
                                  <tr>
                                   <?php foreach ($credit_app_hotels as  $item) :?>	
                                     <td style = "font-size: 14px; font-weight: bold;">Address</td>  
                                     <td><?php echo $item['address'] ?></td>
                                   <?php endforeach ?>
                                  </tr>  
                                  <tr>
                                   <?php foreach ($credit_app_hotels as  $item) :?>	
                                     <td style = "font-size: 14px; font-weight: bold;">Contact Name</td>  
                                     <td><?php echo $item['contact_name'] ?></td>
                                   <?php endforeach ?>
                                  </tr>  
                                  <tr>
                                   <?php foreach ($credit_app_hotels as  $item) :?>	
                                     <td style = "font-size: 14px; font-weight: bold;">Amount charged</td>  
                                     <td><?php echo $item['amount_charged'] ?></td>
                                   <?php endforeach ?>
                                  </tr> 
                                  <tr>
                                   <?php foreach ($credit_app_hotels as  $item) :?>	
                                     <td style = "font-size: 14px; font-weight: bold;">Payment Method</td>  
                                     <td><?php echo $item['payment_method'] ?></td>
                                   <?php endforeach ?>
                                  </tr> 
                                  <tr>
                                   <?php foreach ($credit_app_hotels as  $item) :?>	
                                     <td style = "font-size: 14px; font-weight: bold;">Deposit Paid</td>  
                                     <td><?php echo $item['deposite_paid'] ?></td>
                                   <?php endforeach ?>
                                  </tr> 
                                  <tr>
                                   <?php foreach ($credit_app_hotels as  $item) :?>	
                                     <td style = "font-size: 14px; font-weight: bold;">Telephone</td>  
                                     <td><?php echo $item['tel'] ?></td>
                                   <?php endforeach ?>
                                  </tr>  
							                 </table>
							                 <?php if (($credit_app['state_id']>=5 && $role_id==57) ||$is_admin==1): ?>
								                     <a class="form-actions btn btn-info non-printable" href="/credit_app/credit_edit/<?php echo $credit_app['id']?>" style="float:right;margin:10px;" > Credit part</a>
							                 <?php endif ?>
							                 <?php if($credit_app['credit_user']) {?>
							                 <br>
							                 <br>
							                 <br>
							                 <table class="table table-striped table-bordered table-condensed">
								                  <thead>
                                  	<tr>
                                  		<th colspan="4" class="centered">Result of Credit Check</th>
                                  	</tr>
                                  </thead>	
								                   <tr>
                                     <td style = "font-size: 14px; font-weight: bold;">Previous Hotel Bookings at:</td>  
                                     <td><?php echo $credit_app['pre_booking_date'] ?></td>
                                  </tr>
                                  <tr>
                                     <td style = "font-size: 14px; font-weight: bold;">Reference:</td> 
                                     <td><?php echo $credit_app['ref'] ?></td>
                                  </tr>  
                                  <tr>
                                     <td style = "font-size: 14px; font-weight: bold;">Credit Decision:</td> 
                                     <td><?php echo $credit_app['credit_decision'] ?></td>
                                  </tr>  
                                  <tr>
                                     <td style = "font-size: 14px; font-weight: bold;">Direct Billing Approval:</td> 
                                     <td><?php echo $credit_app['billing_approval'] ?></td>
                                  </tr> 
                                   <tr>
                                     <td style = "font-size: 14px; font-weight: bold;">Percentage of Prepayment:</td> 
                                     <td><?php echo $credit_app['payment_percentage'] ?></td>
                                  </tr> 
                                   <tr>
                                     <td style = "font-size: 14px; font-weight: bold;">Others:</td> 
                                     <td><?php echo $credit_app['others'] ?></td>
                                  </tr>  
							</table>
							<?php }?>
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
				                            				<form action="/credit_app/mail/<?php echo $credit_app['id']; ?>" 
				                            					  method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
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
				                    				<a href="/credit_app/unsign/<?php echo $signe_id; ?>" class="non-printable btn btn-primary unsign">Cancel</a>
				                    			<?php endif ?>
				                  			</div>
				                  			<div class="data-content">
				                  				<span class="name-data-content"><?php echo $signer['sign']['name']; ?></span>
				                  				<br />
				                  				<span class="timestamp-data-content"><?php echo $signer['sign']['timestamp']; ?></span>
				                  			</div>
				                  		<?php elseif (array_key_exists($user_id, $signer['queue']) && $queue_first): ?>
				                  			<?php $queue_first = FALSE; ?>
				                  			<div class="data-content non-printable"><span class="data-label sign-data-content"></span><a href="/credit_app/sign/<?php echo $signe_id; ?>/reject" class="non-printable btn btn-danger">Reject</a><a href="/credit_app/sign/<?php echo $signe_id; ?>" class="non-printable btn btn-success">sign</a></div>
				                  		<?php else: ?>
				                  			<?php $queue_first = FALSE; ?>
				                  		<?php endif ?>
				                	</div>
				                    <?php if (isset($signer['sign']['reject'])){break;}?>
				                <?php endforeach ?>
				            </div>
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher non-printable">
	                			<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
	                  				<form action="/credit_app/comment/<?php echo $credit_app['id']?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
	                    				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
	                     					<textarea class="form-control" name="comment" id="comment"></textarea>
	                    				</div>
	                    				<input name="submit" value="Comment" type="submit" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-actions btn btn-success " onClick="check();" />
	                    				 <div id="checking" style="display:none;position: fixed;top: 0;left: 0;width: 100%;height: 100   %;background: #f4f4f4;z-index: 99;">
                                                 <div class="text" style="position: absolute;top: 45%;left: 0;height: 100%;width: 100%;font-size: 18px;text-align: center;">
                                                       <center><img src="<?php echo base_url();?>assets/images/ajax-loader.gif" alt="Loading"></center>
                                                                              Please Wait!<Br><b style="color: red;">few seconds</b>
                                                  </div>
                                          </div>
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
	    				<p class="centered">The Credit Application Form has been created by <?php echo $credit_app['name'];?> at <?php echo $credit_app['timestamp'];?></p>
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