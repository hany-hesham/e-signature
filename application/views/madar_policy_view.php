<!DOCTYPE html>
<html lang="en">
  	<head>
    	<?php $this->load->view('header'); ?>
    	<style type="text/css">
			@media print{
				@page { 
					margin: 0 !important; 
					size: A3 landscape !important;
					scale:65 !important;
				}
  				body { 
  					margin: 1.6cm; 
  				}
  				td{
  					font-size: 12px !important; 
  				}
  				h1{
  					font-size: 10px !important; 
  				}
  				.hany{
  					background-color: gray !important; 
  					color: white !important;
  				}
  				.hisham{
  					text-align: right !important; 
  					background-color: white !important; 
  					color: black !important; 
  					width: 250px !important;
  				}
  				.hanys{
  					color: gray !important;
  				}
			}
		</style>
  	</head>
  	<body>
  		<?php $date = ""; ?>
  		<?php foreach ($signers as $signer): ?>
		    <?php if (isset($signer['sign']) && $signer['sign']['id'] == 217): ?>
		    	(<?php $date = $signer['sign']['timestamp']; ?>)
		    <?php endif; ?>
		<?php endforeach ?>
  		<?php
            $dates = explode(" ",$date);
            $datess = explode("-",$dates['0']);
            $datesss = array_reverse($datess);
      		$datessss = implode("/",$datesss);
        ?>
    	<div id="wrapper">
      		<?php $this->load->view('menu') ?>
      		<div id="page-wrapper">
              	<div class="page-header" style="margin-top: 80px;">
       				<button onclick="window.print()" class="non-printable form-actions btn btn-success" href="">Print</button>
					<?php if ($is_admin || $madar_admin): ?>
						<a class="form-actions btn btn-info non-printable" href="/madar_policy/edit/<?php echo $core['id'] ?>" style="float:right;" > Edit </a>
					<?php endif ?>
					<div class="header-logo"><img src="/assets/uploads/logos/37972-logo.png"/></div>
		            <h1 class="centered">
		            	Signature Policy (لائحة التوقيعات) No. <?php echo $core['id'] ?> (<?php echo $datessss; ?>)
		            </h1>
			        <a class="form-actions btn btn-info non-printable" href="/madar_policy/mail_me/<?php echo $core['id'] ?>" style="float:left; margin-left: 20px;" > <img src="/assets/images/letter.png" style="width: 28px; height: 40px; margin: 0px; margin-left: -10px; margin-top: -10px; margin-bottom: -10px;"> Share by Email </a>
					<a data-text="whatsapp" data-link="<?php echo base_url(); ?>madar_policy/view/<?php echo $core['id'] ?>" style="float:left; margin-left: 20px;" class="whatsapp whatsapp_btn whatsapp_btn_small form-actions btn btn-success non-printable"> <img src="/assets/images/original.png" style="width: 70px; height: 50px; margin: -20px; margin-left: -30px; margin-top: -21px;"> Share by Whatsapp</a> 
					<a class="form-actions btn btn-success non-printable" href="/madar_policy" style="float:right;"> Back </a>
					<table class="table table-striped table-bordered table-condensed" dir="rtl">
                      	<tr>
		                    <td class="hisham" colspan="1" style=" text-align: center; background-color: black; color: white; width: 250px !important;">Description</td>
		                    <td class="hanys" colspan="1" style=" text-align: center; color: gray;">First Signature</td>
		                    <td class="hanys" colspan="1" style=" text-align: center; color: gray;">Second Signature</td>
		                    <td class="hanys" colspan="1" style=" text-align: center; color: gray;">Third Signature</td>
		                    <td class="hanys" colspan="1" style=" text-align: center; color: gray;">Fourth Signature</td>
		                    <td class="hanys" colspan="1" style=" text-align: center; color: gray;">Fifth Signature</td>
		                    <td class="hanys" colspan="1" style=" text-align: center; color: gray;">Sixth Signature</td>
		                    <td class="hanys" colspan="1" style=" text-align: center; color: gray;">Seventh Signature</td>
                      	</tr>
                    	<tbody>
                      		<?php foreach ($departments as $department): ?>
                        		<tr>
                          			<td colspan="9" class="centered hany" style="background-color: gray; color: white;">
                            			<?php echo $department['name']?>
                          			</td>
                        		</tr>
                        		<?php foreach ($department['types'] as $type): ?>
                          			<tr>
                            			<td class="hisham" style="background-color: black; color: white; width: 250px !important;"> 
                              				<?php echo $type['name']?>
                            			</td>
                            			<td class="centered" style=" width: 150px !important;"> 
                            				<div class="signer unsigned"><?php echo $type['policy']['role_first']?></div>
                            			</td>
                            			<td class="centered" style=" width: 150px !important;"> 
                            				<div class="signer unsigned"><?php echo $type['policy']['role_second']?></div>
                            			</td>
                            			<td class="centered" style=" width: 150px !important;"> 
                            				<div class="signer unsigned"><?php echo $type['policy']['role_third']?></div>
                            			</td>
                            			<td class="centered" style=" width: 150px !important;"> 
                            				<div class="signer unsigned"><?php echo $type['policy']['role_fourth']?></div>
                            			</td>
                            			<td class="centered" style=" width: 150px !important;"> 
                            				<div class="signer unsigned"><?php echo $type['policy']['role_fifth']?></div>
                            			</td>
                            			<td class="centered" style=" width: 150px !important;"> 
                            				<div class="signer unsigned"><?php echo $type['policy']['role_sixth']?></div>
                            			</td>
                            			<td class="centered" style=" width: 150px !important;"> 
                            				<div class="signer unsigned"><?php echo $type['policy']['role_seventh']?></div>
                            			</td>
                          			</tr>
                        		<?php endforeach ?>
                      		<?php endforeach ?>
                    	</tbody>
                  	</table>  

		        </div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher centered">
				    <?php $queue_first = TRUE; ?>
				    <?php foreach ($signers as $signe_id => $signer): ?>
				        <div class="signature-wrapper">
				            <div class="data-head relative">
				            	<?php echo ($signer['role_id'] == '7')? $signer['department'] : $signer['role']."&nbsp".$signer['department']; ?>
				                <span class="expander-container"><i class='glyphicon glyphicon-envelope'></i></span>
				                <div class="expander-wrapper">
				                    <span class="expander-remover"><i class='glyphicon glyphicon-remove'></i></span>
				                   	<div class="expander">
				                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-holder">
				                          	<div class="row">
				                            	<form action="/madar_policy/mail/<?php echo $core['id']; ?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
				                              		<?php if (isset($signer['sign'])): ?>
				                              			<?php $i=1; ?>
				                              			<input checked="checked" type="radio" name="mail" value="<?php echo $signer['sign']['mail'] ?>" />
				                              			<label>To: <?php echo $signer['sign']['name'] ?></label>
				                              		<?php else: ?>
				                              			<?php $i=0; foreach ($signer['queue'] as $id => $signe): ?>
				                              				<input <?php echo (++$i == 1)? 'checked="checked"' : '' ?> type="radio" name="mail" value="<?php echo $signe['mail'] ?>" id="u<?php echo $id ?>" />
				                              				<label for="u<?php echo $id ?>">To: <?php echo $signe['name'] ?></label><br />
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
				                <div class="data-content">
				                	<img src="
				                  			<?php if(isset($signer['sign']['reject'])){ 
				                  				echo $signature_path.'rejected.png';
				                  			}else {
				                  				if ($signer['sign']['id'] == 217) {
				                  					echo $signature_path.'9f3a8-mr.-hossam.jpg';
				                  				}else{
				                  					echo $signature_path.'approved.png';
				                  				}
				                  			}?>
			                  			" alt="<?php echo $signer['sign']['name']; ?>" class="img-rounded sign-image">
				                    <?php if (($signer['sign']['id'] == $user_id && $unsign_enable) || $is_admin): ?>
				                    	<a href="/madar_policy/unsign/<?php echo $signe_id; ?>" class="non-printable btn btn-primary unsign">Cancel</a>
				                    <?php endif ?>
				                </div>
				                <div class="data-content">
				                  	<span class="name-data-content"><?php echo $signer['sign']['name']; ?></span>
				                  	<br />
				                  	<span class="timestamp-data-content"><?php echo $signer['sign']['timestamp']; ?></span>
				                </div>
				            <?php elseif ($signer['rank'] < 8 && array_key_exists($user_id, $signer['queue'])): ?>
				                <?php $queue_first = FALSE; ?>
				                <div class="data-content non-printable">
				                	<span class="data-label sign-data-content"></span>
				                	<a href="/madar_policy/sign/<?php echo $signe_id; ?>/reject" class="non-printable btn btn-danger">Reject</a>
				                	<a href="/madar_policy/sign/<?php echo $signe_id; ?>" class="non-printable btn btn-success">sign</a>
				                </div>
				            <?php elseif ($signer['rank'] >= 8 && array_key_exists($user_id, $signer['queue']) && $queue_first): ?>
				                <?php $queue_first = FALSE; ?>
				                <div class="data-content non-printable">
				                	<span class="data-label sign-data-content"></span>
				                	<a href="/madar_policy/sign/<?php echo $signe_id; ?>/reject" class="non-printable btn btn-danger">Reject</a>
				                	<a href="/madar_policy/sign/<?php echo $signe_id; ?>" class="non-printable btn btn-success">sign</a>
				                </div>
				            <?php else: ?>
				                <?php $queue_first = FALSE; ?>
				            <?php endif ?>
				       	</div>
				   	<?php endforeach ?>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher non-printable">
	                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
	                  	<form action="/madar_policy/comment/<?php echo $core['id']?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
	                    	<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
	                     		<textarea class="form-control" name="comment" id="comment"></textarea>
	                    	</div>
	                    	<input name="core_id" value="<?php echo $core['id']?>" type="hidden" />
	                    	<input name="submit" value="Comment" type="submit" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-actions btn btn-success " />
	                  	</form>
	                </div>
	            </div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-holder non-printable">
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
				<div class="data-content non-printable">
	    			<p class="centered">The Signature Policy has been created by <?php echo $core['name'];?> at <?php echo $core['timestamp'];?></p>
	    		</div>				
	    	</div>
		</div>
	</body>
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
</html>