<!DOCTYPE html>
<?php if($abeer==TRUE && $reservation['res_source_id']==18){
	 redirect('/reservations/index/');
}?>
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
								<?php if ($is_editor && $first): ?>
									<a class="form-actions btn btn-info non-printable" href="/reservations/edit/<?php echo $reservation['id'] ?>" style="float:right;" > Edit </a>
								<?php endif ?>
								<div class="header-logo"><img src="/assets/uploads/logos/<?php echo $reservation['logo']; ?>"/></div>
		                  		<h1 class="centered"><?php echo $reservation['hotel_name']; ?></h1>
			        			<h3 class="centered">
			        				Reservation Form No. #<?php echo $reservation['id']; ?>
			        			</h3>
			        			<a class="form-actions btn btn-info non-printable" href="/reservations/mail_me/<?php echo $reservation['id'] ?>" style="float:left; margin-left: 20px;" > <img src="/assets/images/letter.png" style="width: 28px; height: 40px; margin: 0px; margin-left: -10px; margin-top: -10px; margin-bottom: -10px;"> Share by Email </a>
								<a data-text="whatsapp" data-link="<?php echo base_url(); ?>reservations/view/<?php echo $reservation['id'] ?>" style="float:left; margin-left: 20px;" class="whatsapp whatsapp_btn whatsapp_btn_small form-actions btn btn-success non-printable"> <img src="/assets/images/original.png" style="width: 70px; height: 50px; margin: -20px; margin-left: -30px; margin-top: -21px;"> Share by Whatsapp</a> 
								<a class="form-actions btn btn-success non-printable" href="/reservations" style="float:right;"> Back </a>
			        			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher data-indention">
				        			<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
	                  					<label for="from-hotel" class="control-label " style="width: 160px; font-size:20px; font-weight:bold;"> Date: </label>
	                  					<label for="from-type" class="control-label " style="width:200px;"><?php echo $reservation['timestamp'] ?></label>
	                  				</div>
				        			<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
	                  					<table class="table-striped" style = "font-size:20px; border: 5px solid !important; width: 745px;">
	                  						<tr>
	                  							<td class="" style="font-weight:bold;"> Guest Name: </td>
	                  							<td class="centered"> <?php echo $reservation['name'] ?> </td>
	                  							<td class="" style="font-weight:bold;"> Requested by: </td>
	                  							<td class="centered"> <?php echo $reservation['recived_by'] ?> </td>
	                  						</tr>
	                  						<tr>
	                  							<td class="" style="font-weight:bold;"> Arrival: </td>
	                  							<td class="centered"> <?php echo $reservation['arrival'] ?> </td>
	                  							<td class="" style="font-weight:bold;"> Departure: </td>
	                  							<td class="centered"> <?php echo $reservation['departure'] ?> </td>
	                  						</tr>
		                  					<tr>
	                  							<td class="" style="font-weight:bold;"> Adults: </td>
	                  							<td class="centered"> <?php echo $reservation['adult'] ?> </td>
	                  							<td class="" style="font-weight:bold;"> Children: </td>
	                  							<td class="centered"> <?php echo $reservation['child'] ?> </td>
	                  						</tr>
	                  						<tr>
	                  							<td class="" style="font-weight:bold;"> No. of Rooms: </td>
	                  							<td class="centered"> <?php echo $reservation['no_room'] ?> </td>
	                  							<td class="" style="font-weight:bold;"> Agent/Company: </td>
	                  							<td class="centered"> <?php echo $reservation['agent'] ?> </td>
	                  						</tr>
	                  						<tr>
	                  							<td class="" style="font-weight:bold;"> Discount: </td>
	                  							<td class="centered"> <?php echo $reservation['discount'] ?> </td>
	                  							<td class="" style="font-weight:bold;"> Board Type: </td>
	                  							<td class="centered"> <?php echo $reservation['board_type'] ?> </td>
	                  						</tr>
	                  						<tr>
	                  							<td class="" style="font-weight:bold;"> Reservation Type: </td>
	                  							<td class="centered"> <?php echo $reservation['res_type'] ?> </td>
	                  							<td class="" style="font-weight:bold;"> Reservation Sources: </td>
	                  							<td class="centered"> <?php echo $reservation['res_source'] ?> </td>
	                  						</tr>
	                  						<tr>
	                  							<td class="" style="font-weight:bold;"> Room Type: </td>
	                  							<td class="centered"> <?php echo $reservation['room_type'] ?> </td>
	                  							<td class="" style="font-weight:bold;"> Rate After Discount: </td>
	                  							<td class="centered"> <?php echo $reservation['rate'] ?> <?php echo $reservation['currency'] ?> </td>
	                  						</tr>
	                  					</table>
	                  				</div>
	                  				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
	                  					<label for="from-hotel" class="control-label " style="width: 160px; font-size:20px; font-weight:bold;"> Remarks: </label>
	                  					<label for="from-type" class="control-label " style="width:750px;">
	                  						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	                  						<?php echo $reservation['remarks'] ?>
	                  					</label>
	                  				</div>
	                  			</div>
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher data-indention non-printable">
			                      	<label for="offers" class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label" style="font-size:20px; font-weight:bold;">Report Files:</label>
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
				                            				<form action="/reservations/<?php if($signer['role_id'] == "1"){ 
									                                echo "share_url";
									                              }else{
									                                echo "mail";
									                              } ?>/<?php echo $reservation['id']; ?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
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
			                  			" alt="<?php echo $signer['sign']['name']; ?>" class="img-rounded sign-image">
				                    			<?php if (($signer['sign']['id'] == $user_id && $unsign_enable) || $is_admin): ?>
				                    				<a href="/reservations/unsign/<?php echo $signe_id; ?>" class="non-printable btn btn-primary unsign">Cancel</a>
				                    			<?php endif ?>
				                  			</div>
				                  			<div class="data-content">
				                  				<span class="name-data-content"><?php echo $signer['sign']['name']; ?></span>
				                  				<br />
				                  				<span class="timestamp-data-content"><?php echo $signer['sign']['timestamp']; ?></span>
				                  			</div>
				                  		<?php elseif (array_key_exists($user_id, $signer['queue']) && $queue_first && $role_id !=142): ?>
				                  			<?php $queue_first = FALSE; ?>
				                  			<div class="data-content non-printable"><span class="data-label sign-data-content"></span><a href="/reservations/sign/<?php echo $signe_id; ?>/reject" class="non-printable btn btn-danger">Reject</a><a href="/reservations/sign/<?php echo $signe_id; ?>" class="non-printable btn btn-success">sign</a></div>
				                  		<?php else: ?>
				                  			<?php $queue_first = FALSE; ?>
				                  		<?php endif ?>
				                	</div>
				                    <?php if (isset($signer['sign']['reject'])){break;}?>
				                <?php endforeach ?>
				            </div>
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher non-printable">
	                			<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
	                  				<form action="/reservations/comment/<?php echo $reservation['id']?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
	                    				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
	                     					<textarea class="form-control" name="comment" id="comment"></textarea>
	                    				</div>
	                    				<input name="res_id" value="<?php echo $reservation['id']?>" type="hidden" />
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
	    				<p class="centered">The Reservation Form has been created by <?php echo $reservation['user_name'];?> at <?php echo $reservation['timestamp'];?></p>
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