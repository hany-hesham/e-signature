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
							<a class="form-actions btn btn-info non-printable" href="/settlement/purpose_edit/<?php echo $settlement['id'] ?>" style="float:right;" > Edit </a>
							<?php endif ?>
							    <div class="header-logo"><img src="/assets/uploads/logos/<?php echo $settlement['logo']; ?>"/></div>
                  				<h1 class="centered"><?php echo $settlement['hotel_name']; ?></h1>
	        					<h3 class="centered">
	        						Purpose of Report for Settlement Form No. #<?php echo $settlement['id']?>
	        					</h3>
	    					</div>
                  			<label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px; width: 180px;"> Date </label>
                  			<p><?php echo $purpose['date']; ?></p>
                  			<?php if($purpose['type'] == 1): ?>
                  			<h4 for="" class="col-lg- col-md-5 col-sm-2 col-xs-5  control-label ">In Case Of Employees Negligence</h4>
							<table class="table table-striped table-bordered table-condensed">
								<tr class="item-row">
									<td class="align-left table-label">Reason of settlement:</td>
									<td class="align-left table-label"><?php echo $purpose['set']; ?></td>
								</tr>
								<tr class="item-row">
									<td class="align-left table-label">Name of the in charged employee:</td>
									<td class="align-left table-label"><?php echo $purpose['charged']; ?></td>
								</tr>
								<tr class="item-row">
									<td class="align-left table-label">Position of the in charged employee:</td>
									<td class="align-left table-label"><?php echo $purpose['position']; ?></td>
								</tr>
								<tr class="item-row">
									<td class="align-left table-label">Date of accident:</td>
									<td class="align-left table-label"><?php echo $purpose['accident']; ?></td>
								</tr>
								<tr class="item-row">
									<td class="align-left table-label">Area of the accident:</td>
									<td class="align-left table-label"><?php echo $purpose['area']; ?></td>
								</tr>
								<tr class="item-row">
									<td class="align-left table-label">The reason of the accident :</td>
									<td class="align-left table-label"><?php echo $purpose['reason']; ?></td>
								</tr>
								<tr class="item-row">
									<td class="align-left table-label">mount of the settlement:</td>
									<td class="align-left table-label"><?php echo $purpose['amount']; ?></td>
								</tr>
								<tr class="item-row">
									<td class="align-left table-label">Penalty:</td>
									<td class="align-left table-label"><?php echo $purpose['penalty']; ?></td>
								</tr>
							</table>
							<?php elseif($purpose['type'] == 2):?>
							<h4 for="" class="col-lg-2 col-md-5 col-sm-2 col-xs-5  control-label ">Normal Cases</h4>
							<table class="table table-striped table-bordered table-condensed">
								<tr class="item-row">
									<td class="align-left table-label">Reason of settlement:</td>
									<td class="align-left table-label"><?php echo $purpose['set']; ?></td>
								</tr>
								<tr class="item-row">
									<td class="align-left table-label">Date of accident:</td>
									<td class="align-left table-label"><?php echo $purpose['accident']; ?></td>
								</tr>
								<tr class="item-row">
									<td class="align-left table-label">Area of the accident:</td>
									<td class="align-left table-label"><?php echo $purpose['area']; ?></td>
								</tr>
								<tr class="item-row">
									<td class="align-left table-label">The reason of the accident :</td>
									<td class="align-left table-label"><?php echo $purpose['reason']; ?></td>
								</tr>
								<tr class="item-row">
									<td class="align-left table-label">mount of the settlement:</td>
									<td class="align-left table-label"><?php echo $purpose['amount']; ?></td>
								</tr>
							</table>
							<?php endif;?>
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher centered">
			                	<?php $queue_first = TRUE; ?>
			                	<?php foreach ($signers1 as $signe_id => $signer): ?>
			                	<div class="signature-wrapper">
			                  		<div class="data-head relative"><?php echo (strlen($signer['role']) == 0)? "Settlement Owner" : $signer['role'] ?>
			                    		<span class="expander-container"><i class='glyphicon glyphicon-envelope'></i></span>
			                    		<div class="expander-wrapper">
			                      			<span class="expander-remover"><i class='glyphicon glyphicon-remove'></i></span>
			                      			<div class="expander">
			                        			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-holder">
			                          				<div class="row">
			                            				<form action="/settlement/purpose_mailto/<?php echo $settlement['id']; ?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
			                              					<?php if (isset($signer['sign'])): ?>
			                              					<?php $i=1; ?>
			                              					<input checked="checked" type="radio" name="mail" value="<?php echo $signer['sign']['mail'] ?>" /><label>To: <?php echo $signer['sign']['name'] ?></label>
			                              					<?php else: ?>
			                              					<?php $i=0; foreach ($signer['queue'] as $id => $signe): ?>
			                              					<input <?php echo (++$i == 1)? 'checked="checked"' : '' ?> type="radio" name="mail" value="<?php echo $signe['mail'] ?>" id="u<?php echo $id ?>" /><label for="<?php echo $id ?>">To: <?php echo $signe['name'] ?></label><br />
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
			                    		<a href="/settlement/purpose_unsign/<?php echo $signe_id; ?>" class="non-printable btn btn-primary unsign">Cancel</a>
			                    		<?php endif ?>
			                  		</div>
			                  		<div class="data-content">
			                  			<span class="name-data-content"><?php echo $signer['sign']['name']; ?></span>
			                  			<br />
			                  			<span class="timestamp-data-content"><?php echo $signer['sign']['timestamp']; ?></span>
			                  		</div>
			                  		<?php elseif (array_key_exists($user_id, $signer['queue']) && $queue_first): ?>
			                  		<?php $queue_first = FALSE; ?>
			                  		<div class="data-content non-printable"><span class="data-label sign-data-content"></span><a href="/settlement/purpose_sign/<?php echo $signe_id; ?>/reject" class="non-printable btn btn-danger">Reject</a><a href="/settlement/purpose_sign/<?php echo $signe_id; ?>" class="non-printable btn btn-success">sign</a></div>
			                  		<?php else: ?>
			                  		<?php $queue_first = FALSE; ?>
			                  		<?php endif ?>
			                	</div>
			                    <?php if (isset($signer['sign']['reject'])){break;}?>
			                	<?php endforeach ?>

			              	</div>
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher non-printable">
                				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  					<form action="/settlement/purpose_comment/<?php echo $settlement['id']?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
                    					<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                     						<textarea class="form-control" name="comment" id="comment"></textarea>
                    					</div>
                    					<input name="set_id" value="<?php echo $settlement['id']?>" type="hidden" />
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
                    					<?php foreach($get_purpose_comment as $comment ){ ?>
                    					<div class="data-holder">
                      						<span class="data-head"><?php echo $comment['fullname']; ?> :- </span><?php echo $comment['comment']; ?>
                      						<span class="timestamp-data-content"><?php echo $comment['created'];?></span>
                    					</div>
                    					<?php } ?>
                  					</div>
                				</div>  
                			</div>
                			<div class="data-content">
    							<p class="centered">The Purpose of Report for Settlement Form has been created by <?php echo $purpose['name'];?> at <?php echo $purpose['timestamp'];?></p>
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