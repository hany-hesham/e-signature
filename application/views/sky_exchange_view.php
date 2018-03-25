<!DOCTYPE html>
<html lang="en">
	<head>
		<?php $this->load->view('header'); ?>
	</head>
	<body>
		<div id="wrapper" style="margin-left: 50px;">
			<?php $this->load->view('menu') ?>
			<div id="page-wrapper">
       			<button onclick="myFunction();" class="non-printable form-actions btn btn-success" href="" >Print</button>
					<div class="a4wrapper">
						<div class="a4page">
							<div class="page-header">
							<?php if ($is_editor): ?>
								<a class="form-actions btn btn-info non-printable" href="/sky_exchange/edit/<?php echo $exchange['id'] ?>" style="float:right;" > Edit </a>
							<?php endif ?>
							    <div class="header-logo"><img src="/assets/uploads/logos/<?php echo $exchange['logo']; ?>"/></div>
	                  				<h1 class="centered"><?php echo $exchange['hotel_name']; ?></h1>
									<h3 class="centered">
		        						Daily Exchange Rate No. #<?php echo $exchange['id']; ?>
		        					</h3>
	        					</div>
								<a class="form-actions btn btn-info non-printable" href="/sky_exchange/view_rate/<?php echo $exchange['id'] ?>" style="float:left; margin-left: 20px;" > View Bank Rate </a>
								<a class="form-actions btn btn-info non-printable" href="/sky_exchange/mailme/<?php echo $exchange['id'] ?>" style="float:left; margin-left: 20px;" > <img src="/assets/images/letter.png" style="width: 28px; height: 40px; margin: 0px; margin-left: -10px; margin-top: -10px; margin-bottom: -10px;"> Share by Email </a>
								<a data-text="whatsapp" data-link="<?php echo base_url(); ?>sky_exchange/view/<?php echo $exchange['id'] ?>" style="float:left; margin-left: 20px;" class="whatsapp whatsapp_btn whatsapp_btn_small form-actions btn btn-success non-printable"> <img src="/assets/images/original.png" style="width: 70px; height: 50px; margin: -20px; margin-left: -30px; margin-top: -21px;"> Share by Whatsapp</a>
	        					<div style="text-align: right;">
	        						<h3 style="margin-right: 30px;">Date: <?php echo $exchange['date']; ?></h3>
	        						<h3 style="margin-right: 80px;">Currency: <?php echo $exchange['currency']; ?></h3>
	        					</div>
				                  <table class="table table-bordered table-condensed">
				                  <thead>
				                              <tr>
				                                <th colspan="1" rowspan="3" style=" text-align: center;">Bank</th>
				                                <th colspan="3" rowspan="1" style=" text-align: center;">Currency</th>
				                              </tr>
				                              <tr>
				                                <th rowspan="1" style=" text-align: center;"><?php echo $exchange['currency']; ?></th>
				                                <th colspan="1" rowspan="2" style=" text-align: center;">Amount</th>
				                              </tr>
				                              <tr>
				                                <th rowspan="1" style=" text-align: center;">Manual Rate</th>
				                              </tr>
				                  </thead>
				                  <tbody id="items-container" data-items="1" >
				                  <?php foreach($bankss as $banks){?>
				                  <?php if(!empty($banks['amount'])): ?>
				                  	<?if($banks['chek']>0){?>
				                    <tr style="background-color: yellow;">
				                  	<?}elseif($banks['chek']==0){?>
				                    <tr style="background-color: ;">
				                    <?php } ?>
				                      <td> <?php echo $banks['bank_name'];?></td>
				                      <td> <?php echo $banks['rate'];?></td>
				                      <td> <?php echo $banks['amount'];?> </td>
				                    </tr>
				                    <?php endif; ?>
				                  <?php } ?>
				                  </tbody>
				                </table>
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher centered">
				                	<?php $queue_first = TRUE; ?>
				                	<?php foreach ($signers as $signe_id => $signer): ?>
				                	<div class="signature-wrapper">
				                  		<div class="data-head relative"><?php echo (strlen($signer['role']) == 0)? "exchange Owner" : $signer['role']."&nbsp".$signer['department'] ?>
				                    		<span class="expander-container"><i class='glyphicon glyphicon-envelope'></i></span>
				                    		<div class="expander-wrapper">
				                      			<span class="expander-remover"><i class='glyphicon glyphicon-remove'></i></span>
				                      			<div class="expander">
				                        			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-holder">
				                          				<div class="row">
				                            				<form action="/sky_exchange/mailto/<?php echo $exchange['id']; ?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
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
				                  		<div class="data-content"><img src="<?php echo isset($signer['sign']['reject'])? $signature_path.'rejected.png' : ($signer['sign']['name'] == 'Hossam El Shaer')? $signature_path.'9f3a8-mr.-hossam.jpg' : $signature_path.'approved.png'; ?>" alt="<?php echo $signer['sign']['name']; ?>" class="img-rounded sign-image">
				                    		<?php if (($signer['sign']['id'] == $user_id && $unsign_enable) || $is_admin): ?>
				                    		<a href="/sky_exchange/unsign/<?php echo $signe_id; ?>" class="non-printable btn btn-primary unsign">Cancel</a>
				                    		<?php endif ?>
				                  		</div>
				                  		<div class="data-content">
				                  			<span class="name-data-content"><?php echo $signer['sign']['name']; ?></span>
				                  			<br />
				                  			<span class="timestamp-data-content"><?php echo $signer['sign']['timestamp']; ?></span>
				                  		</div>
				                  		<?php elseif (array_key_exists($user_id, $signer['queue']) && $queue_first): ?>
				                  		<?php $queue_first = FALSE; ?>
				                  		<div class="data-content non-printable"><span class="data-label sign-data-content"></span><a href="/sky_exchange/sign/<?php echo $signe_id; ?>/reject" class="non-printable btn btn-danger">Reject</a><a href="/sky_exchange/sign/<?php echo $signe_id; ?>" class="non-printable btn btn-success">sign</a></div>
				                  		<?php else: ?>
				                  		<?php $queue_first = FALSE; ?>
				                  		<?php endif ?>
				                	</div>
				                    <?php if (isset($signer['sign']['reject'])){break;}?>
				                	<?php endforeach ?>
				              	</div>	
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher non-printable">
	                				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
	                  					<form action="/sky_exchange/comment/<?php echo $exchange['id']?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
	                    					<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
	                     						<textarea class="form-control" name="comment" id="comment"></textarea>
	                    					</div>
	                    					<input name="set_id" value="<?php echo $exchange['id']?>" type="hidden" />
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
	                    					<?php foreach($GetComment as $comment ){ ?>
	                    					<div class="data-holder">
	                      						<span class="data-head"><?php echo $comment['fullname']; ?> :- </span><?php echo $comment['comment']; ?>
	                      						<span class="timestamp-data-content"><?php echo $comment['created'];?></span>
	                    					</div>
	                    					<?php } ?>
	                  					</div>
	                				</div>  
	                			<div class="data-content">
	    							<p class="centered">The Daily Exchange Rate has been created by <?php echo $exchange['name'];?> at <?php echo $exchange['timestamp'];?></p>
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
	</body>
</html>