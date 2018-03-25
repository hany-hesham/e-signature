<!DOCTYPE html>
<html lang="en">
	<head>
		<?php $this->load->view('header'); ?>
	</head>
	<body>
		<div id="wrapper">
			<?php $this->load->view('menu') ?>
			<div id="page-wrapper">
       			<button onclick="window.print()" class="non-printable form-actions btn btn-success" href="" >Print</button>
				<div class="a4wrapper">
					<div class="a4page">
						<div class="page-header">
							<?php if ($is_editor): ?>
								<a class="form-actions btn btn-info non-printable" href="/complaint/edit/<?php echo $complaint['id'] ?>" style="float:right;" > Edit </a>
							<?php endif ?>
							<div class="header-logo"><img src="/assets/uploads/logos/<?php echo $complaint['logo']; ?>"/></div>
                  				<h1 class="centered"><?php echo $complaint['hotel_name']; ?></h1>
								<h3 class="centered">
	        						Complaint After Stay Form No. #<?php echo $complaint['id']; ?>
	        					</h3>
	        				</div>
		        			<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
		        				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
	                  				<label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label" style="margin-top:5px;"> Guest Name </label>
	                  				<p> <?php echo $complaint['guest']; ?> </p>
	                			</div>
	                			<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
	                  				<label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label" style="margin-top:5px;"> Ref. Number </label>
	                  				<p> <?php echo $complaint['ref']; ?> </p>
	                			</div>
	                			<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
	                  				<label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label" style="margin-top:5px;"> Date of Travel (Arr.)</label>
	                  				<p> <?php echo $complaint['date']; ?> </p>
	                			</div>
-	                			<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
	                  				<label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label" style="margin-top:5px;"> Tour Operator </label>
	                  				<p> <?php echo $complaint['operator_name']; ?> </p>
	                			</div>
	                			<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
	                  				<label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label" style="margin-top:5px;"> Date of Recieving Complaint </label>
	                  				<p> <?php echo $complaint['receiving']; ?> </p>
	                			</div>
	                			<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
	                  				<label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label" style="margin-top:5px;"> Date of Reply for Complaint </label>
	                  				<p> <?php echo $complaint['reply']; ?> </p>
	                			</div>
	                			<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
	                  				<label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label" style="margin-top:5px;"> Subject of Complaint (in short) </label>
	                  				<p> <?php echo $complaint['subject']; ?> </p>
	                			</div>
	                			<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
	                  				<label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label" style="margin-top:5px;"> Comments </label>
	                  				<p> <?php echo $complaint['comment']; ?> </p>
	                			</div>
	                			<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
	                  				<label for="from-hotel" class="control-label " style="margin-top:5px;"> Hotel Action to Prevent The Same Complaints </label>
	                  				<p> <?php echo $complaint['action']; ?> </p>
	                			</div>
	                			<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
	                  				<label for="from-hotel" class="control-label " style="margin-top:5px;"> Other Notes </label>
	                  				<p> <?php echo $complaint['other']; ?> </p>
	               		 		</div>
	               		 		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher data-indention">
	                      		<label for="offers" class="col-lg-3 col-md-4 col-sm-5 col-xs-5 control-label">Report Files</label>
								<div class="form-group col-lg-9 col-md-8 col-sm-7 col-xs-7">
	                       			<?php foreach($uploads as $upload): ?>
										<p> <a href='/assets/uploads/files/<?php echo $upload['name'] ?>'><?php echo $upload['name'] ?></a> Uploaded by <?php echo $upload['user_name'] ?></p>
	                        		<?php endforeach ?>			
	                      		</div>	
                      		</div>
	               		 	</div>
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher centered" style="display: none;">
					            <?php $queue_first = TRUE; ?>
					            <?php foreach ($signers as $signe_id => $signer): ?>
					             	<div class="signature-wrapper">
					                	<div class="data-head relative"><?php echo (strlen($signer['role']) == 0)? "complaint Owner" : $signer['role']."&nbsp".$signer['department'] ?>
					                    	<span class="expander-container"><i class='glyphicon glyphicon-envelope'></i></span>
					                    	<div class="expander-wrapper">
					                      		<span class="expander-remover"><i class='glyphicon glyphicon-remove'></i></span>
					                      		<div class="expander">
					                        		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-holder">
					                          			<div class="row">
					                            			<form action="/complaint/mailto/<?php echo $complaint['id']; ?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
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
					                    			<a href="/complaint/unsign/<?php echo $signe_id; ?>" class="non-printable btn btn-primary unsign">Cancel</a>
					                    		<?php endif ?>
					                  		</div>
					                  		<div class="data-content">
					                  			<span class="name-data-content"><?php echo $signer['sign']['name']; ?></span>
					                  			<br />
					                  			<span class="timestamp-data-content"><?php echo $signer['sign']['timestamp']; ?></span>
					                  		</div>
					                  	<?php elseif (array_key_exists($user_id, $signer['queue']) && $queue_first): ?>
					                  		<?php $queue_first = FALSE; ?>
					                  		<div class="data-content non-printable"><span class="data-label sign-data-content"></span><a href="/complaint/sign/<?php echo $signe_id; ?>/reject" class="non-printable btn btn-danger">Reject</a><a href="/complaint/sign/<?php echo $signe_id; ?>" class="non-printable btn btn-success">sign</a></div>
					                  	<?php else: ?>
					                  		<?php $queue_first = FALSE; ?>
					                  	<?php endif ?>
					                </div>
					                <?php if (isset($signer['sign']['reject'])){break;}?>
					            <?php endforeach ?>
				            </div>
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher non-printable">
		                		<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
		                  			<form action="/complaint/comment/<?php echo $complaint['id']?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
		                    			<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
		                     				<textarea class="form-control" name="comment" id="comment"></textarea>
		                    			</div>
		                    			<input name="com_id" value="<?php echo $complaint['id']?>" type="hidden" />
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
	                    				<?php foreach($getcomment as $comment ){ ?>
	                    					<div class="data-holder">
	                      						<span class="data-head"><?php echo $comment['fullname']; ?> :- </span><?php echo $comment['comment']; ?>
	                      						<span class="timestamp-data-content"><?php echo $comment['created'];?></span>
	                    					</div>
	                    				<?php } ?>
	                  				</div>
	                			</div>  
	                		</div>
	                		<div class="data-content">
	    						<p class="centered">
	    							The Complaint After Stay Form has been created by <?php echo $complaint['name'];?> at <?php echo $complaint['timestamp'];?>
	    						</p>
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
	</body>
</html>