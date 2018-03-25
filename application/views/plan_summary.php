<!DOCTYPE html>
<html lang="en">
<head>
	<?php $this->load->view('header'); ?>
	<style type="text/css">
    @media screen {
        div.divFooter {
            display:block;

        }
        div.doop {
        	display: none;
        }
    }
     @media print {
        div.doop {
            display:block;
        }
    }
    
</style>

</head>
<body>
	<div id="wrapper">
		<?php if (!$demo) {
			$this->load->view('menu');
		} ?>
		<div id="page-wrapper">
			<?php if (!$demo): ?>
	       		<button onclick="window.print()" class="non-printable form-actions btn btn-success" href="" >Print</button>
	        <?php endif ?>
			<div class="a4wrapper">
				<div class="a4page">
					<div class="page-header">
						<div class="header-logo"><img src="<?php echo $logo_path.$plan['hotel_logo']; ?>"></div>
						<h1 class="centered">Replacement &amp; Projects Plan</h1>
	        			<h3 class="centered"><?php echo $plan['hotel_name']; ?> &nbsp;&nbsp;&nbsp;Year: <?php echo $plan['year']; ?></h3>
	        			<div class="header-box header-box-big">
		       				<h5 class="">
		       					<span class="total-head"> 
		       						Total items: <?php echo $totals['count']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
		       						Estimated Total Plan List: <?php echo number_format($totals['total'],2,".",","); ?>
		       					</span>
		       				</h5>
		       				<h5 class="">
		        				<span class="total-head"> 
		        					Total items: <?php echo $MJ['count']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
		        					Total Major Requests: <?php echo number_format($MJ['total'],2,".",","); ?>
		           				</span>
		           			</h5>
	        			</div>
	        			<div class="header-box" style="position:relative; padding:7px;">
					   		<?php if (!$demo): ?>
					   			<a class="form-actions btn btn-info non-printable" href="/plans/view/<?php echo $plan['id'] ?>" style="float:right;" >View details </a>
							<?php endif ?>
				        </div>
	    			</div>
				    <?php if(false): //(isset($message)): ?>
				    	<div class="alert alert-<?php echo $message['type']; ?>">
				        	<strong><?php echo $message['head']; ?></strong>
				        	<p><?php echo (isset($message['body'])) ? $message['body'] : ''; ?></p>
				    	</div>
				    <?php endif ?>
					<?php foreach ($devisions as $devKey => $devision): ?>
						<?php if ($devision['count'] != 0): ?>
							<?php if ($devKey != 999): ?>
								<div class="devision-container">
									<div class="devision-header-container">
										<span class="devision-header"><?php echo $devision['name']; ?></span>
										<span class="devision-count">Items: <?php echo $devision['count'] ?></span>
										<div class="devision-total">
											<span>Estimated Value:</span>
											<span class="total-value"> <?php echo number_format($devision['total'],2,".",","); ?></span>
										</div>
									</div>
									<?php foreach ($devision['departments'] as $department): ?>
										<?php if ($department['total'] != 0): ?>
											<div class="department-container">
												<div class="department-header-container">
													<span class="department-header"><?php echo $department['name']; ?></span>
													<span class="department-count">Items: <?php echo $department['count'] ?></span>
													<div class="department-total">
														<span>Estimated Value:</span>
														<span class="total-value"> <?php echo number_format($department['total'],2,".",","); ?></span>
													</div>
												</div>
											</div>
										<?php endif ?>
									<?php endforeach ?>
								</div>
							<?php endif ?>
						<?php endif ?>
					<?php endforeach ?>

				<?php if (isset($plan['balance'])): ?>
		<div class=" col-lg-offset-2 col-md-offset-2 col-sm-offset-2 col-xs-offset-2 col-lg-8 col-md-8 col-sm-8 col-xs-8 f-wrapper">

				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<label for="year" class="col-lg-6 col-md-6 col-sm-6 col-xs-6  control-label">C/F Provision :</label>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
						<?php echo number_format($plan['cf_pos'],2,".",","); ?>
					</div>
				</div>

				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<label for="year" class="col-lg-6 col-md-6 col-sm-6 col-xs-6  control-label">Prevision For Budget Year :</label>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
						<?php echo number_format($plan['year_pos'],2,".",","); ?>
					</div>
				</div>

				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<label for="year" class="col-lg-6 col-md-6 col-sm-6 col-xs-6  control-label">Estimated Total :</label>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
						<?php echo number_format($totals['total'],2,".",","); ?>
					</div>
				</div>

				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<label for="year" class="col-lg-6 col-md-6 col-sm-6 col-xs-6 total-head control-label">Balance At End Of Plan Year :</label>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 total-head">
						<b><?php echo number_format($plan['balance'],2,".",","); ?></b>
					</div>
				</div>

		</div>
		<?php elseif($fc_edit): ?>
		<div class=" col-lg-offset-1 col-md-offset-1 col-sm-offset-1 col-xs-offset-1 col-lg-10 col-md-10 col-sm-10 col-xs-10 f-wrapper">
			<form action="/plans/budget/<?php echo $plan['id'] ?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">

				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<label for="year" class="col-lg-4 col-md-4 col-sm-4 col-xs-4  control-label">C/F Position</label>
					<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
						<input type="number" class="form-control unique-plan" name="cf_pos" id="cf_pos" value=""  />
					</div>
				</div>

				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<label for="year" class="col-lg-4 col-md-4 col-sm-4 col-xs-4  control-label">Prevision For Budget Year</label>
					<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
						<input type="number" class="form-control unique-plan" name="year_pos" id="year_pos" value=""  />
					</div>
				</div>

				<input name="submit" value="Submit" type="submit" class="btn btn-success non-printable" />
			</form>
		</div>
		<?php endif ?>
		
			<div class="holder">Please Wait...</div>
			
<?php if (!$demo): ?>
		<div class="a4wrapper divFooter">
		<footer>

			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher">
			<div class="doop">
		       				<h5 class="centered">
		       					<span class="total-head"> 
		       						Total items: <?php echo $totals['count']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
		       						Estimated Total Plan List: <?php echo number_format($totals['total'],2,".",","); ?>
		       					</span>
		       				</h5>
		       				<h5 class="centered">
		        				<span class="total-head"> 
		        					Total items: <?php echo $MJ['count']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
		        					Total Major Requests: <?php echo number_format($MJ['total'],2,".",","); ?>
		           				</span>
		           			</h5>
	        			</div>

			<?php foreach ($signers as $signe_id => $signer): ?>
				<div class="signature-wrapper">
					<div class="data-head relative"><?php echo (strlen($signer['role']) == 0)? "plan Owner" : $signer['role'] ?>
						<span class="expander-container"><i class='glyphicon glyphicon-envelope'></i></span>
						<div class="expander-wrapper">
						<span class="expander-remover"><i class='glyphicon glyphicon-remove'></i></span>
							<div class="expander">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-holder">
									<div class="row">
										<form action="/plans/<?php if($signer['role_id'] == "1"){ 
										echo "share_url";
									}else{
										echo "mailto";
									} ?>/<?php echo $plan['id']; ?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
											<?php if (isset($signer['sign'])): ?>
											<input checked="checked" type="radio" name="mail" value="<?php echo $signer['sign']['mail'] ?>" /><label>To: <?php echo $signer['sign']['name'] ?></label>
											<?php else: ?>
												<?php $i=0; foreach ($signer['queue'] as $id => $signe): ?>
													<input <?php echo (++$i == 1)? 'checked="checked"' : '' ?> type="radio" name="mail" value="<?php echo $signe['mail'] ?>" id="u<?php echo $id ?>" /><label for="u<?php echo $id ?>">To: <?php echo $signe['name'] ?></label><br />
												<?php endforeach ?>
											<?php endif; ?>
											<?php if (isset($i) && $i == 0): ?>
												<span>No users availaable</span>
											<?php else: ?>
											<?php if($signer['role_id'] != "1"){ ?>
												<textarea class="form-control" name="message" id="message"></textarea>
											<?php } ?>
											<input name="submit" value="Send" type="submit" class="inverse-offset btn btn-success non-printable" />
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
						" alt="<?php echo $signer['sign']['name']; ?>" class="img-rounded sign-image"></div>
						<div class="data-content"><span class="name-data-content"><?php echo $signer['sign']['name']; ?></span></div>
					<?php elseif (array_key_exists($user_id, $signer['queue']) && $sign_enabled && $role_id !=142): ?>
						<div class="data-content"><span class="data-label sign-data-content"></span><a href="/plans/sign/<?php echo $signe_id; ?>" class="btn btn-success non-printable">sign</a></div>
					<?php else: ?>
						<?php $sign_enabled = FALSE; ?>
					<?php endif ?>
				</div>
			
			<?php endforeach ?>
			
			</div>

		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher non-printable">
	                			<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
	                  				<form action="/plans/general_comment/<?php echo $plan['id']?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
	                    				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
	                     					<textarea class="form-control" name="comment" id="comment"></textarea>
	                    				</div>
	                    				<!-- <input name="plan_id" value="<?php echo $plan['id']?>" type="hidden" /> -->
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
	                    				<?php foreach($general_comments as $comment ){ ?>
		                    				<div class="data-holder">
		                      					<span class="data-head"><?php echo $comment['fullname']; ?> :- </span><?php echo $comment['comment']; ?>
		                      					<span class="timestamp-data-content"><?php echo $comment['timestamp'];?></span>
		                    				</div>
	                    				<?php } ?>
	                  				</div>
	                			</div>  
	                		</div>
		</div>
	</footer>
	<?php endif; ?>
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