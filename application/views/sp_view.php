<!DOCTYPE html>
<html lang="en">
	<head>
		<?php $this->load->view('header'); ?>
		<style type="text/css">
	      	table {
	        	border-color: #000000  !important;
	        	border-style: solid   !important;
	      	}
    	</style>
    	<style>
      		@media print {
		        td{
		          	font-size: 13px !important;
		        }
		        table{
		        	width: 750px !important;
		        	margin-left: 0px !important;
		        }
      		}
		</style>
	</head>
	<body>
    	<div >
			<?php $this->load->view('menu') ?>
			<div>
	          	<div>
	            	<div>
	              		<div>
                			<div >
       							<button onclick="window.print()" class="non-printable form-actions btn btn-success" href="" style="margin-left: 9%;">Print</button>
								<?php if ($is_editor): ?>
									<a class="form-actions btn btn-info non-printable" href="/rate_sp/edit/<?php echo $sp['id'] ?>" style="float:right;" > Edit </a>
								<?php endif ?>
								<div class="header-logo" style="margin-right: -1%;"><img src="/assets/uploads/logos/<?php echo $sp['logo']; ?>"/></div>
		                  		<h1 class="centered" style="margin-right: -1%;"><?php echo $sp['hotel_name']; ?></h1>
		                  		<?php if ($sp['type'] == 1 || $sp['type'] == 4) {?>
		                  			<h3 class="centered" style="margin-right: -1%;">
			        					DOS Approval Special Rates Form No. #<?php echo $sp['id']; ?>
			        				</h3>
		                  		<?php }elseif ($sp['type'] == 2 || $sp['type'] == 5) {?>
		                  			<h3 class="centered" style="margin-right: -1%;">
			        					RDOS & Markting Approval Special Rates Form No. #<?php echo $sp['id']; ?>
			        				</h3>
		                  		<?php }elseif ($sp['type'] == 3 || $sp['type'] == 6) { ?>
		                  			<h3 class="centered" style="margin-right: -1%;">
			        					Board Approval Special Rates Form No. #<?php echo $sp['id']; ?>
			        				</h3>
			        			<?php } ?>
			        			
			        			<br>
			        			<br>
			        			<br>
								<table class="table-striped" style = "width: 2000px; font-size:16px; border: 5px solid bold  !important; border-top: 1px solid bold !important; margin-left: 20%">
									<tr style = "font-size: 18px; font-weight: bold;">
										<td class="centered table-label" style="width:40px;">NO.</td>
										<td class="centered table-label" style="width:150px;">Remarks</td>
										<td class="centered table-label" style="width:150px;">Travel Agent</td>
										<td class="centered table-label" style="width:150px;">Guest Name</td>
										<td class="centered table-label" style="width:130px;">Arrival Date</td>
										<td class="centered table-label" style="width:130px;">Departure Date</td>
										<td class="centered table-label" style="width:120px;">No. Of Rooms</td>
										<td class="centered table-label" style="width:120px;">No. Of Pax</td>
										<td class="centered table-label" style="width:120px;">Rate</td>
										<td class="centered table-label" style="width:120px;">Publish Rate</td>
										<td class="centered table-label" style="width:80px;">Discount</td>
										<td class="centered table-label" style="width:120px;">Room Type</td>
										<td class="centered table-label" style="width:50px;">Board</td>
										<td class="centered table-label" style="width:180px;">Bkg Received From</td>
                          				<th class="centered table-label" style="width:100px;">Attachment</th>
									</tr>
									<?php $count = 1; ?>
									<?php foreach ($items as $item): ?>
										<tr class="item-row" style="font-size: 16px; font-weight: bold;">
											<td class="centered" style="width:40px;"><?php echo $count; ?></td>
											<td class="centered" style="width:150px;"><?php echo $item['remarks']; ?></td>
											<td class="centered" style="width:150px;"><?php echo $item['operator']; ?></td>
											<td class="centered" style="width:150px;"><?php echo $item['guest']; ?></td>
											<td class="centered" style="width:130px;"><?php echo $item['arrival']; ?></td>
											<td class="centered" style="width:130px;"><?php echo $item['departure']; ?></td>
											<td class="centered" style="width:120px;"><?php echo $item['room']; ?></td>
											<td class="centered" style="width:120px;"><?php echo $item['pax']; ?></td>
											<td class="centered" style="width:120px;"><?php echo $item['rate']; ?>&nbsp;&nbsp;<?php echo $item['currency']; ?></td>
											<td class="centered" style="width:120px;"><?php echo $item['publish']; ?>&nbsp;&nbsp;<?php echo $item['currency2']; ?></td>
											<td class="centered" style="width:80px;"><?php echo $item['discount']; ?>&nbsp;&nbsp;%</td>
											<td class="centered" style="width:120px;"><?php echo $item['room_type']; ?></td>
											<td class="centered" style="width:50px;"><?php echo $item['board_name']; ?></td>
											<td class="centered" style="width:180px;"><?php echo $item['booking']; ?></td>
                            				<td class="centered" style="width:100px;"><a href="/assets/uploads/files/<?php echo $item['fille']; ?>"><?php echo $item['fille']; ?></a></td>
										</tr>
										<?php $count++; ?>
									<?php endforeach ?>
								</table>
								<hr>
								<br>
								<br>
								<div class="non-printable" style="margin-left: 20%;">
			                      	<label for="offers" class="col-lg-3 col-md-4 col-sm-5 col-xs-5 control-label">Report Files</label>
									<div class="form-group col-lg-9 col-md-8 col-sm-7 col-xs-7">
			                       		<?php foreach($uploads as $upload): ?>
			                       			<a href='/assets/uploads/files/<?php echo $upload['name'] ?>'><?php echo $upload['name'] ?></a><br />
			                        	<?php endforeach ?>			
			                      	</div>	
		                      	</div>
		                      	<br>
		                      	<br>
		                    </div>
		                    <hr>
		                    <br>
		                    <br>
							<div class="centered" style="margin-left: 4%;">
				                <?php $queue_first = TRUE; ?>
				                <?php foreach ($signers as $signe_id => $signer): ?>
				                	<div class="signature-wrapper">
				                  		<div class="data-head relative"><?php echo (strlen($signer['role']) == 0)? "Settlement Owner" : $signer['role'] ?>
				                    		<span class="expander-container"><i class='glyphicon glyphicon-envelope'></i></span>
				                    		<div class="expander-wrapper">
				                      			<span class="expander-remover"><i class='glyphicon glyphicon-remove'></i></span>
				                      			<div class="expander">
				                        			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-holder">
				                          				<div class="row">
				                            				<form action="/rate_sp/<?php if($signer['role_id'] == "1"){ 
									                                echo "share_url";
									                              }else{
									                                echo "mailto";
									                              } ?>/<?php echo $sp['id']; ?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
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
				                    				<a href="/rate_sp/unsign/<?php echo $signe_id; ?>" class="non-printable btn btn-primary unsign">Cancel</a>
				                    			<?php endif ?>
				                  			</div>
				                  			<div class="data-content">
				                  				<span class="name-data-content"><?php echo $signer['sign']['name']; ?></span>
				                  				<br />
				                  				<span class="timestamp-data-content"><?php echo $signer['sign']['timestamp']; ?></span>
				                  			</div>
				                  		<?php elseif (array_key_exists($user_id, $signer['queue']) && $queue_first): ?>
				                  			<?php $queue_first = FALSE; ?>
				                  			<div class="data-content non-printable"><span class="data-label sign-data-content"></span><a href="/rate_sp/sign/<?php echo $signe_id; ?>/reject" class="non-printable btn btn-danger">Reject</a><a href="/rate_sp/sign/<?php echo $signe_id; ?>" class="non-printable btn btn-success">sign</a></div>
				                  		<?php else: ?>
				                  			<?php $queue_first = FALSE; ?>
				                  		<?php endif ?>
				                	</div>
				                    <?php if (isset($signer['sign']['reject'])){break;}?>
				                <?php endforeach ?>
				            </div>
				            <hr>
				            <br>
				            <br>
							<div class=" non-printable" style="margin-left: 20%;">
	                			<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
	                  				<form action="/rate_sp/comment/<?php echo $sp['id']?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
	                    				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
	                     					<textarea class="form-control" name="comment" id="comment" rows="3" style="width: 80% !important;"></textarea>
	                    				</div>
	                    				<input name="sp_id" value="<?php echo $sp['id']?>" type="hidden" />
	                    				<input name="submit" value="Comment" type="submit" style="width: 80% !important;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-actions btn btn-success " />
	                  				</form>
	                			</div>
	              			</div>
							<div class="" style="margin-left: 3%;">
	                			<div class=" ">
	                				<hr>
	                				<br>
	                				<br>
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
						<div class="data-content" style="margin-left: 3%;">
							<br>
							<br>
							<hr>
							<?php if ($sp['type'] == 1 || $sp['type'] == 4) {?>
	    						<p class="centered">The DOS Approval Special Rates Form has been created by <?php echo $sp['name'];?> at <?php echo $sp['timestamp'];?></p>

		                  		<?php }elseif ($sp['type'] == 2 || $sp['type'] == 5) {?>
	    							<p class="centered">The RDOS & Markting Approval Special Rates Form has been created by <?php echo $sp['name'];?> at <?php echo $sp['timestamp'];?></p>

		                  		<?php }elseif ($sp['type'] == 3 || $sp['type'] == 6) { ?>
	    							<p class="centered">The Board Approval Special Rates Form has been created by <?php echo $sp['name'];?> at <?php echo $sp['timestamp'];?></p>

			        			<?php } ?>
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
	</body>
</html>