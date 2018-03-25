<!DOCTYPE html>
<html lang="en">
  	<head>
    	<?php $this->load->view('header'); ?>
    	<style>
    	    @media print {
	          	@page { 
	            	margin: 0.5cm; 
	          	}
	          	.hanys{
	          		display: block !important;
	          	}
	          	.signature-wrapper{
		          height: 70px;
		          width: 140px;
		        }
		        .data-head {
		          font-size:10px;
		        }
		        .data-content>img{
		          height: 15px;
		          width: 30px;
		        }
		        .timestamp-data-content{
		          font-size: 10px;
		        }
		        .data-content{
		          font-size: 10px;
		        }
		        .data-catcher{
		          height: 250px !important;
		        }
		        .header-logo>img{
		          width: 140px;
		          height: 70px;
		        }
		        .header-logo>h3{
		          font-size:10px;
		          font-weight: bold;
		        }
		        .data-head>h3{
		          font-size:10px;
		        }
		        h1{
		          font-size:20px;
		          font-weight: bold;
		        }
		        h3{
		          font-size:18px;
		          font-weight: bold;
		        }
        	}
      	</style>
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
									<a class="form-actions btn btn-info non-printable" href="/credit/edit/<?php echo $credit['id'] ?>" style="float:right;" > Edit </a>
								<?php endif ?>
								<div class="header-logo"><img src="/assets/uploads/logos/<?php echo $credit['logo']; ?>"/></div>
		                  		<h1 class="centered"><?php echo $credit['hotel_name']; ?></h1>
			        			<h3 class="centered">
			        				Credit Authorization Form No. #<?php echo $credit['id']; ?>
			        			</h3>
			        			<h3 class="centered">
			        				Date: <?php echo $credit['date']; ?>
			        			</h3>
			        			<a class="form-actions btn btn-info non-printable" href="/credit/mail_me/<?php echo $credit['id'] ?>" style="float:left; margin-left: 20px;" > <img src="/assets/images/letter.png" style="width: 28px; height: 40px; margin: 0px; margin-left: -10px; margin-top: -10px; margin-bottom: -10px;"> Share by Email </a>
								<a data-text="whatsapp" data-link="<?php echo base_url(); ?>credit/view/<?php echo $credit['id'] ?>" style="float:left; margin-left: 20px;" class="whatsapp whatsapp_btn whatsapp_btn_small form-actions btn btn-success non-printable"> <img src="/assets/images/original.png" style="width: 70px; height: 50px; margin: -20px; margin-left: -30px; margin-top: -21px;"> Share by Whatsapp</a> 
								<a class="form-actions btn btn-success non-printable" href="/credit" style="float:right;"> Back </a>
	                  			<table class="table table-striped table-bordered table-condensed">
	                  				<tr>
				                        <td colspan="3" style=" text-align: center; font-size: 15px; font-weight: bold;">Company Details</td>
	                  				</tr>
	                  				<tr>
				                        <td colspan="1" class="align-left table-label" style="width: 225px !important; font-size: 12px;">Company Name</td>
				                        <td colspan="2" style=" text-align: center; width: 500px !important; font-size: 12px;" class="align-left table-label"><?php echo $credit['company'] ?></td>
				                    </tr>
				                    <tr>
				                        <td colspan="1" class="align-left table-label" style="width: 225px !important; font-size: 12px;">Address</td>
				                        <td colspan="2" style=" text-align: center; width: 500px !important; font-size: 12px;" class="align-left table-label"><?php echo $credit['address'] ?></td>
				                    </tr>
				                    <tr>
				                        <td colspan="1" class="align-left table-label" style="width: 225px !important; font-size: 12px;">Contact Person</th>
				                        <td colspan="2" style=" text-align: center; width: 500px !important; font-size: 12px;" class="align-left table-label"><?php echo $credit['person'] ?></td>
				                    </tr>
				                    <tr>
				                        <td colspan="1" class="align-left table-label" style="width: 225px !important; font-size: 12px;">Telephone</th>
				                        <td colspan="2" style=" text-align: center; width: 500px !important; font-size: 12px;" class="align-left table-label"><?php echo $credit['tele'] ?></td>
				                    </tr>
				                    <tr>
				                        <td colspan="1" class="align-left table-label" style="width: 225px !important; font-size: 12px;">E-mail</th>
				                        <td colspan="2" style=" text-align: center; width: 500px !important; font-size: 12px;" class="align-left table-label"><?php echo $credit['email'] ?></td>
				                    </tr>
	                  			</table>
	                  			<table class="table table-striped table-bordered table-condensed">
	                  				<tr>
				                        <td colspan="3" style=" text-align: center; font-size: 15px; font-weight: bold;">Contract Details</td>
	                  				</tr>
	                  				<tr>
				                        <td colspan="1" rowspan="2" class="align-left table-label" style="width: 100px !important; font-size: 12px;">Contract period</td>
				                        <td colspan="1" rowspan="1" class="align-left table-label" style="width: 100px !important; font-size: 12px;">From</td>
				                        <td colspan="1" rowspan="1" style=" text-align: center; width: 500px; font-size: 12px;" class="align-left table-label"><?php echo $credit['period_from'] ?></td>
				                    </tr>
				                    <tr>
				                        <td colspan="1" rowspan="1" class="align-left table-label" style="width: 100px !important; font-size: 12px;">To</td>
				                        <td colspan="1" rowspan="1" style=" text-align: center; width: 500px; font-size: 12px;" class="align-left table-label"><?php echo $credit['period_to'] ?></td>
				                    </tr>
				                    <tr>
				                        <td colspan="2" class="align-left table-label" style="width: 200px !important; font-size: 12px;">No of contracted rooms</td>
				                        <td colspan="1" style=" text-align: center; width: 500px !important; font-size: 12px;" class="align-left table-label"><?php echo $credit['rooms'] ?></td>
				                    </tr>
				                    <tr>
				                        <td colspan="2" class="align-left table-label" style="width: 200px !important; font-size: 12px;">Type</th>
				                        <td colspan="1" style=" text-align: center; width: 500px !important; font-size: 12px;" class="align-left table-label"><?php echo $credit['contract_type'] ?></td>
				                    </tr>
	                  			</table>
	                  			<table class="table table-striped table-bordered table-condensed">
	                  				<tr>
				                        <td colspan="3" style=" text-align: center; font-size: 15px; font-weight: bold;">Deposit</td>
	                  				</tr>
	                  				<tr>
				                        <td colspan="1" class="align-left table-label" style="width: 225px !important; font-size: 12px;">Cash Amount</td>
				                        <td colspan="2" style=" text-align: center; width: 500px !important; font-size: 12px;" class="align-left table-label"><?php echo $credit['cash'] ?> <?php echo $credit['currency'] ?></td>
				                    </tr>
				                    <tr>
				                        <td colspan="1" class="align-left table-label" style="width: 225px !important; font-size: 12px;">Letter of Guarantee</td>
				                        <td colspan="2" style=" text-align: center; width: 500px !important; font-size: 12px;" class="align-left table-label"><?php echo $credit['letter'] ?></td>
				                    </tr>
				                    <tr>
				                        <td colspan="1" class="align-left table-label" style="width: 225px !important; font-size: 12px;">Renew Al Date</th>
				                        <td colspan="2" style=" text-align: center; width: 500px !important; font-size: 12px;" class="align-left table-label"><?php echo $credit['renew_date'] ?></td>
				                    </tr>
				                    <tr>
				                        <td colspan="1" class="align-left table-label" style="width: 225px !important; font-size: 12px;">Method of Deposit Deduction</th>
				                        <td colspan="2" style=" text-align: center; width: 500px !important; font-size: 12px;" class="align-left table-label"><?php echo $credit['method'] ?></td>
				                    </tr>
				                    <tr>
				                        <td colspan="1" class="align-left table-label" style="width: 225px !important; font-size: 12px;">E-mail</th>
				                        <td colspan="2" style=" text-align: center; width: 500px !important; font-size: 12px;" class="align-left table-label"><?php echo $credit['email'] ?></td>
				                    </tr>
	                  			</table>
	                  			<table class="table table-striped table-bordered table-condensed">
	                  				<tr>
				                        <td colspan="3" style=" text-align: center; font-size: 15px; font-weight: bold;">Credit Limit</td>
	                  				</tr>
	                  				<tr>
				                        <td colspan="1" class="align-left table-label" style="width: 225px !important; font-size: 12px;">Credit Limit Amount</td>
				                        <td colspan="2" style=" text-align: center; width: 500px !important; font-size: 12px;" class="align-left table-label"><?php echo $credit['limits'] ?> <?php echo $credit['currency1'] ?></td>
				                    </tr>
				                    <tr>
				                        <td colspan="1" class="align-left table-label" style="width: 225px !important; font-size: 12px;">Notes</td>
				                        <td colspan="2" style=" text-align: center; width: 500px !important; font-size: 12px;" class="align-left table-label"><?php echo $credit['note'] ?></td>
				                    </tr>
	                  			</table>
	                  			<table class="table table-striped table-bordered table-condensed">
	                  				<tr>
				                        <td colspan="3" style=" text-align: center; font-size: 15px; font-weight: bold;">Terms of Payment</td>
	                  				</tr>
	                  				<tr>
				                        <td colspan="1" class="align-left table-label" style="width: 225px !important; font-size: 12px;">Terms</td>
				                        <td colspan="2" style=" text-align: center; width: 500px !important; font-size: 12px;" class="align-left table-label"><?php echo $credit['terms'] ?></td>
				                    </tr>
	                  			</table>
	                  			<table class="table table-striped table-bordered table-condensed">
	                  				<tr>
				                        <td colspan="3" style=" text-align: center; font-size: 15px; font-weight: bold;">Market Survey</td>
	                  				</tr>
	                  				<tr>
				                        <td colspan="1" class="align-left table-label" style="width: 225px !important; font-size: 12px;">Credit Ability</td>
				                        <td colspan="2" style=" text-align: center; width: 500px !important; font-size: 12px;" class="align-left table-label"><?php echo $credit['ability'] ?></td>
				                    </tr>
				                    <tr>
				                        <td colspan="1" class="align-left table-label" style="width: 225px !important; font-size: 12px;">Other Remarks</td>
				                        <td colspan="2" style=" text-align: center; width: 500px !important; font-size: 12px;" class="align-left table-label"><?php echo $credit['remarks'] ?></td>
				                    </tr>
	                  			</table>
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
				                            				<form action="/credit/<?php if($signer['role_id'] == "1"){ 
									                                echo "share_url";
									                              }else{
									                                echo "mail";
									                              } ?>/<?php echo $credit['id']; ?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
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
				                  			<div class="data-content"><img src="<?php echo isset($signer['sign']['reject'])? $signature_path.'rejected.png' : $signature_path.'approved.png'; ?>" alt="<?php echo $signer['sign']['name']; ?>" class="img-rounded sign-image">
				                    			<?php if (($signer['sign']['id'] == $user_id && $unsign_enable) || $is_admin): ?>
				                    				<a href="/credit/unsign/<?php echo $signe_id; ?>" class="non-printable btn btn-primary unsign">Cancel</a>
				                    			<?php endif ?>
				                  			</div>
				                  			<div class="data-content">
				                  				<span class="name-data-content"><?php echo $signer['sign']['name']; ?></span>
				                  				<br />
				                  				<span class="timestamp-data-content"><?php echo $signer['sign']['timestamp']; ?></span>
				                  			</div>
				                  		<?php elseif (array_key_exists($user_id, $signer['queue']) && $queue_first && $role_id !=142): ?>
				                  			<?php $queue_first = FALSE; ?>
				                  			<div class="data-content non-printable"><span class="data-label sign-data-content"></span><a href="/credit/sign/<?php echo $signe_id; ?>/reject" class="non-printable btn btn-danger">Reject</a><a href="/credit/sign/<?php echo $signe_id; ?>" class="non-printable btn btn-success">sign</a></div>
				                  		<?php else: ?>
				                  			<?php $queue_first = FALSE; ?>
				                  		<?php endif ?>
				                	</div>
				                    <?php if (isset($signer['sign']['reject'])){break;}?>
				                <?php endforeach ?>
				                <p class="centered">NB: <?php echo $credit['nb'];?></p>
				                <p class="centered">The Credit Authorization Form has been created by <?php echo $credit['name'];?> at <?php echo $credit['timestamp'];?></p>
				            </div>
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher non-printable">
	                			<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
	                  				<form action="/credit/comment/<?php echo $credit['id']?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
	                    				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
	                     					<textarea class="form-control" name="comment" id="comment"></textarea>
	                    				</div>
	                    				<input name="credit_id" value="<?php echo $credit['id']?>" type="hidden" />
	                    				<input name="submit" value="Comment" type="submit" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-actions btn btn-success " />
	                  				</form>
	                			</div>
	              			</div>
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-holder <?php if(!$comments){ ?>non-printable<?php } ?>">
	                			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher">
	                				<br class="hanys" style="display: none;">
	                				<br class="hanys" style="display: none;">
	                				<br class="hanys" style="display: none;">
	                				<br class="hanys" style="display: none;">
	                				<br class="hanys" style="display: none;">
	                				<br class="hanys" style="display: none;">
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