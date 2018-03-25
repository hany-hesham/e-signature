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
									<a class="form-actions btn btn-info non-printable" href="/shop_adjust/edit/<?php echo $shop_adjust['id']."/".$shop_adjust['shop_id'] ?>" style="float:right;" > Edit </a>
								<?php endif ?>
								<div class="header-logo"><img src="/assets/uploads/logos/<?php echo $shop_adjust['logo']; ?>"/></div>
		                  		<h1 class="centered"><?php echo $shop_adjust['hotel_name']; ?></h1>
			        			<h3 class="centered">
			        				Rent Adjustment Form No. #<?php echo $shop_adjust['id']; ?>
			        			</h3>
			        			<a class="form-actions btn btn-info non-printable" href="/shop_adjust/mail_me/<?php echo $shop_adjust['id']
			        			  ."/".$shop_adjust['shop_id'] ?>" style="float:left; margin-left: 20px;" > <img src="/assets/images/letter.png" style="width: 28px; height: 40px; margin: 0px; margin-left: -10px; margin-top: -10px; margin-bottom: -10px;"> Share by Email </a>
								<a data-text="whatsapp" data-link="<?php echo base_url(); ?>shop_adjust/view/<?php echo $shop_adjust['id']."/".$shop_adjust['shop_id'] ?>" style="float:left; margin-left: 20px;" class="whatsapp whatsapp_btn whatsapp_btn_small form-actions btn btn-success non-printable"> <img src="/assets/images/original.png" style="width: 70px; height: 50px; margin: -20px; margin-left: -30px; margin-top: -21px;"> Share by Whatsapp</a> 
								<a class="form-actions btn btn-success non-printable" href="/shop_renting/view/<?php echo $shop_adjust['shop_id']?>" style="float:right;"> Back </a>
			        			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher data-indention">
				        		    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
	                  					<label for="from-hotel" class="control-label " style="width: 160px;"> Date: </label>
	                  					<label for="from-type" class="control-label " style="width:200px;"><?php echo $shop_adjust['timestamp'] ?></label>
	                  				</div>
				        			<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
	                  					<label for="from-hotel" class="control-label " style="width: 160px;"> Shop Activity: </label>
	                  					<label for="from-type" class="control-label " style="width:200px;"><?php echo $shop['title'] ?></label>
	                  				</div>
				                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
	                  					<label for="from-hotel" class="control-label " style="width: 160px;"> Hotel: </label>
	                  					<label for="from-type" class="control-label " style="width:400px;"><?php echo $shop_adjust['hotel_name'] ?></label>
	                  				</div>
	                  				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
	                  					<label for="from-hotel" class="control-label " style="width: 160px;"> Contract Starting Date: </label>
	                  					<label for="from-type" class="control-label " style="width:200px;"><?php echo $shop['start_from'] ?></label>
	                  				</div>
	                  				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
	                  					<label for="from-hotel" class="control-label " style="width: 160px;"> Contract Rent: </label>
	                  					<label for="from-type" class="control-label " style="width:200px;"><?php echo $shop['rent'] ?></label>
	                  				</div>
	                  				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
	                  					<label for="from-hotel" class="control-label " style="width: 160px;margin-bottom:10px;"> New Amount of rent: </label>
	                  				<label for="from-type" class="control-label " style="width:500px;">
	                  						<?php echo $shop_adjust['new_rent']." from ".$shop_adjust['from_date']."  till ".$shop_adjust['to_date'] ?></label>
	                  				</div>  
	                  				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
	                  				   <label for="from-hotel" class="control-label " style="width: 200px;margin-bottom:5px;">Effective Date of adjustment:</label>
	                  				   <label for="from-type" class="control-label " style="width:500px;">
	                  						<?php echo $shop_adjust['effective_date'] ?></label>
	                  				</div>    
	                  			</div>
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
				                            				<form action="/shop_adjust/mail/<?php echo $shop_adjust['id']."/".$shop_adjust['shop_id']; ?>" 
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
				                    				<a href="/shop_adjust/unsign/<?php echo $signe_id; ?>" class="non-printable btn btn-primary unsign">Cancel</a>
				                    			<?php endif ?>
				                  			</div>
				                  			<div class="data-content">
				                  				<span class="name-data-content"><?php echo $signer['sign']['name']; ?></span>
				                  				<br />
				                  				<span class="timestamp-data-content"><?php echo $signer['sign']['timestamp']; ?></span>
				                  			</div>
				                  		<?php elseif (array_key_exists($user_id, $signer['queue']) && $queue_first): ?>
				                  			<?php $queue_first = FALSE; ?>
				                  			<div class="data-content non-printable"><span class="data-label sign-data-content"></span><a href="/shop_adjust/sign/<?php echo $signe_id; ?>/reject" class="non-printable btn btn-danger">Reject</a><a href="/shop_adjust/sign/<?php echo $signe_id; ?>" class="non-printable btn btn-success">sign</a></div>
				                  		<?php else: ?>
				                  			<?php $queue_first = FALSE; ?>
				                  		<?php endif ?>
				                	</div>
				                    <?php if (isset($signer['sign']['reject'])){break;}?>
				                <?php endforeach ?>
				            </div>
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher non-printable">
	                			<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
	                  				<form action="/shop_adjust/comment/<?php echo $shop_adjust['id']."/".$shop_adjust['shop_id']?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
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
	    				<p class="centered">The Rent adjustment Form has been created by <?php echo $shop_adjust['name'];?> at <?php echo $shop_adjust['timestamp'];?></p>
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