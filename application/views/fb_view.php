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
							<?php if ($is_editor): ?>
								<a class="form-actions btn btn-info non-printable" href="/fb_order/edit/<?php echo $fb['id'] ?>" style="float:right;" > Edit </a>
							<?php endif ?>
							<div class="header-logo"><img src="/assets/uploads/logos/<?php echo $fb['logo']; ?>"/></div>
                  			<h1 class="centered"><?php echo $fb['hotel_name']; ?></h1>
							<h3 class="centered">
	        					Food & Beverage Order No. #<?php echo $fb['id']; ?>
	        				</h3>
	        			</div>
	        			<div style="text-align: left;">
	        				<h3 style="margin-right: 30px;"><span style="font-weight: bolder; font-size: 24px;">Creation Date: </span><?php echo $fb['timestamp']; ?></h3>
	        			</div>
						<table class="table-striped table-bordered table-condensed" style="width: 792px !important;">
							<tr class="item-row" style="font-weight: bold;">
								<td class="centered table-label">Room</td>
								<td class="centered table-label">Name</td>
								<td class="centered table-label">Nationality</td>
								<td class="centered table-label">No. Pax</td>
								<td class="centered table-label">Break Box</td>
								<td class="centered table-label">Date and Time</td>
								<td class="centered table-label">Lunch Box</td>
                    			<td class="centered table-label">Royal Lunch</td>
								<td class="centered table-label">Date and Time</td>
								<td class="centered table-label">Late Dinner</td>
								<td class="centered table-label">Date and Time</td>
								<td class="align-left table-label">Cold Cuts</td>
                    			<td class="align-left table-label">Date and Time</td>
							</tr>
							<?php $total1 =0; ?>
							<?php $total2 =0; ?>
							<?php $total3 =0; ?>
							<?php $total4 =0; ?>
							<?php $total5 =0; ?>
							<?php $total6 =0; ?>
							<?php foreach ($items as $item):?>
								<?php $total1 = $total1 + $item['pax']; ?>
								<?php $total2 = $total2 + $item['break']; ?>
								<?php $total3 = $total3 + $item['lunch']; ?>
								<?php $total4 = $total4 + $item['royal']; ?>
								<?php $total5 = $total5 + $item['dinner']; ?>
								<?php $total6 = $total6 + $item['cold']; ?>
								<tr class="item-row">
									<td class="table-label centered"><?php echo $item['room']?></td>
									<td class="table-label centered"><?php echo ($item['guest'])? $item['guest'] : "Expacted Arrival";?></td>
									<td class="table-label centered"><?php echo ($item['nationality'])? $item['nationality'] : "Expacted Arrival";?></td>
									<td class="table-label centered"><?php echo $item['pax']?></td>
									<td class="table-label centered"><?php echo $item['break']?></td>
									<td class="table-label centered"><?php echo $item['date']?></td>
									<td class="table-label centered"><?php echo $item['lunch']?></td>
									<td class="table-label centered"><?php echo $item['royal']?></td>
									<td class="table-label centered"><?php echo $item['date1']?></td>
									<td class="table-label centered"><?php echo $item['dinner']?></td>
									<td class="table-label centered"><?php echo $item['date2']?></td>
									<td class="table-label centered"><?php echo $item['cold']?></td>
									<td class="table-label centered"><?php echo $item['date3']?></td>
								</tr>
							<?php endforeach?>
							<tr style="font-size: 20px;">
								<td class="table-label centered" colspan="3" style="background-color: yellow;"> Total </td>
								<td class="table-label centered" colspan="1" style="background-color: yellow;"><?php echo $total1?></td>
								<td class="table-label centered" colspan="2" style="background-color: yellow;"><?php echo $total2?></td>
								<td class="table-label centered" colspan="1" style="background-color: yellow;"><?php echo $total3?></td>
								<td class="table-label centered" colspan="2" style="background-color: yellow;"><?php echo $total4?></td>
								<td class="table-label centered" colspan="2" style="background-color: yellow;"><?php echo $total5?></td>
								<td class="table-label centered" colspan="2" style="background-color: yellow;"><?php echo $total6?></td>
							</tr>
						</table>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher data-indention">
	                      	<label for="offers" class="col-lg-3 col-md-4 col-sm-5 col-xs-5 control-label">Report Files</label>
							<div class="form-group col-lg-9 col-md-8 col-sm-7 col-xs-7">
	                       		<?php foreach($uploads as $upload): ?>
	                       			<a href='/assets/uploads/files/<?php echo $upload['name'] ?>'><?php echo $upload['name'] ?></a><br />
	                        	<?php endforeach ?>			
	                      	</div>	
                      	</div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher centered">
			                <?php $queue_first = TRUE; ?>
			                <?php foreach ($signers as $signe_id => $signer): ?>
			                	<div class="signature-wrapper">
			                  		<div class="data-head relative"><?php echo (strlen($signer['role']) == 0)? "fb_order Owner" : $signer['department'] ?>
			                    		<span class="expander-container"><i class='glyphicon glyphicon-envelope'></i></span>
			                    		<div class="expander-wrapper">
			                      			<span class="expander-remover"><i class='glyphicon glyphicon-remove'></i></span>
			                      			<div class="expander">
			                        			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-holder">
			                          				<div class="row">
			                            				<form action="/fb_order/mailto/<?php echo $fb['id']; ?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
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
				                    		<a href="/fb_order/unsign/<?php echo $signe_id; ?>" class="non-printable btn btn-primary unsign">Cancel</a>
				                    		<?php endif ?>
				                  		</div>
				                  		<div class="data-content">
				                  			<span class="name-data-content"><?php echo $signer['sign']['name']; ?></span>
				                  			<br />
				                  			<span class="timestamp-data-content"><?php echo $signer['sign']['timestamp']; ?></span>
				                  		</div>
			                  		<?php elseif (array_key_exists($user_id, $signer['queue']) && $queue_first): ?>
				                  		<?php $queue_first = FALSE; ?>
				                  		<div class="data-content non-printable"><span class="data-label sign-data-content"></span><a href="/fb_order/sign/<?php echo $signe_id; ?>/reject" class="non-printable btn btn-danger">Reject</a><a href="/fb_order/sign/<?php echo $signe_id; ?>" class="non-printable btn btn-success">sign</a></div>
			                  		<?php else: ?>
			                  			<?php $queue_first = FALSE; ?>
			                  		<?php endif ?>
			                	</div>
			                    <?php if (isset($signer['sign']['reject'])){break;}?>
			                <?php endforeach ?>
			            </div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher non-printable">
                			<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  				<form action="/fb_order/comment/<?php echo $fb['id']?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
                    				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                     					<textarea class="form-control" name="comment" id="comment"></textarea>
                    				</div>
                    				<input name="fb_id" value="<?php echo $fb['id']?>" type="hidden" />
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
                		</div>
                	</div>
                	<div class="data-content">
    					<p class="centered">The Food & Beverage Order has been created by <?php echo $fb['name'];?> at <?php echo $fb['timestamp'];?></p>
    					<?php if ($fb['ret_id'] == 3):?>
							<p class="centered">TheFood & Beverage Order has been Retoure for <?php echo $fb['reason']; ?></p>
						<?php elseif ($fb['ret_id'] == 4):?>
							<p class="centered">The Food & Beverage Order has been Cancelled for <?php echo $fb['reason']; ?></p>
						<?php elseif ($fb['ret_id'] == 5):?>
							<p class="centered">The Food & Beverage Order has been  Marked as No Show for <?php echo $fb['reason']; ?></p>
						<?php elseif ($fb['ret_id'] == 6):?>
							<p class="centered">The Food & Beverage Order has been Delivered</p>
						<?php endif ?>
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
	</body>
</html>