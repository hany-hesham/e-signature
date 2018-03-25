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
							<a class="form-actions btn btn-info non-printable" href="/rr_change/edit/<?php echo $rr['id'] ?>" style="float:right;" > Edit </a>
							<?php endif ?>
							    <div class="header-logo"><img src="/assets/uploads/logos/<?php echo $rr['logo']; ?>"/></div>
                  				<h1 class="centered"><?php echo $rr['hotel_name']; ?></h1>
								<h3 class="centered">
	        						Room Change Report No. #<?php echo $rr['id']; ?>
	        					</h3>
	        					<div style="text-align: right;">
	        						<h3 style="margin-right: 30px;"><?php echo $rr['date']; ?></h3>
	        					</div>
	        					<div style="text-align: right;">
	        						<h3 style="margin-right: 50px;"><?php echo $rr['rr']; ?></h3>
	        					</div>
	        				</div>
							<table class="table table-striped table-bordered table-condensed">
								<tr class="item-row">
			                        <td colspan="1" rowspan="2" style=" text-align: center;">Room </td>
			                        <th colspan="2" rowspan="1" style=" text-align: center;">Change <?php echo $rr['rr']?> </td>
			                        <td colspan="1" rowspan="2" style=" text-align: center;">Travel Agent </td>
			                        <td colspan="1" rowspan="2"style=" text-align: center;">Remarks </td>
			                    </tr>
			                    <tr>
			                        <td colspan="1" rowspan="1" style=" text-align: center;">From </td>
			                        <td colspan="1" rowspan="1" style=" text-align: center;">To </td>
			                    </tr>
								</tr>
                    		<?php if ($rr_room) {?>
								<?php foreach ($rr_room as $room):?>
									<tr class="item-row">
										<td class="align-left table-label" style="width: 100px;"><?php echo $room['room']?></td>
										<td class="align-left table-label" style="width: 150px;"><?php echo $room['r_from']?></td>
										<td class="align-left table-label" style="width: 150px;"><?php echo $room['r_to']?></td>
										<td class="align-left table-label" style="width: 150px;"><?php echo $room['rt_name']?></td>
										<td class="align-left table-label" style="width: 450px;"><?php echo $room['remarks']?></td>
									</tr>
								<?php endforeach?>
							<?php }else{ ?>
                <img src="<?php echo base_url(); ?>assets/images/Capture5.png" style="position: absolute; margin-top: 120px; margin-left:120px; ">
                  <?php for ($i=0; $i < 10; $i++) { ?>
                <tr class="item-row">
                  <td class="align-left table-label centered" style="width: 100px;">&nbsp;&nbsp;</td>
                  <td class="align-left table-label centered" style="width: 150px;">&nbsp;&nbsp;</td>
                  <td class="align-left table-label centered" style="width: 150px;">&nbsp;&nbsp;</td>
                  <td class="align-left table-label centered" style="width: 150px;">&nbsp;&nbsp;</td>
                  <td class="align-left table-label centered" style="width: 150px;">&nbsp;&nbsp;</td>
                </tr>
                  <?php } ?>
                <?php } ?>
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
			                  		<div class="data-head relative"><?php echo (strlen($signer['role']) == 0)? "Report Owner" : $signer['role']."&nbsp".$signer['department'] ?>
			                    		<span class="expander-container"><i class='glyphicon glyphicon-envelope'></i></span>
			                    		<div class="expander-wrapper">
			                      			<span class="expander-remover"><i class='glyphicon glyphicon-remove'></i></span>
			                      			<div class="expander">
			                        			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-holder">
			                          				<div class="row">
			                            				<form action="/rr_change/mailto/<?php echo $rr['id']; ?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
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
			                    		<a href="/rr_change/unsign/<?php echo $signe_id; ?>" class="non-printable btn btn-primary unsign">Cancel</a>
			                    		<?php endif ?>
			                  		</div>
			                  		<div class="data-content">
			                  			<span class="name-data-content"><?php echo $signer['sign']['name']; ?></span>
			                  			<br />
			                  			<span class="timestamp-data-content"><?php echo $signer['sign']['timestamp']; ?></span>
			                  		</div>
			                  		<?php elseif (array_key_exists($user_id, $signer['queue']) && $queue_first): ?>
			                  		<?php $queue_first = FALSE; ?>
			                  		<div class="data-content non-printable"><span class="data-label sign-data-content"></span><a href="/rr_change/sign/<?php echo $signe_id; ?>/reject" class="non-printable btn btn-danger">Reject</a><a href="/rr_change/sign/<?php echo $signe_id; ?>" class="non-printable btn btn-success">sign</a></div>
			                  		<?php else: ?>
			                  		<?php $queue_first = FALSE; ?>
			                  		<?php endif ?>
			                	</div>
			                    <?php if (isset($signer['sign']['reject'])){break;}?>
			                	<?php endforeach ?>
			              	</div>
			            		
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher non-printable">
                				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  					<form action="/rr_change/comment/<?php echo $rr['id']?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
                    					<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                     						<textarea class="form-control" name="comment" id="comment"></textarea>
                    					</div>
                    					<input name="dcy_id" value="<?php echo $rr['id']?>" type="hidden" />
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
                    					<?php foreach($get_comment as $comment ){ ?>
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
    							<p class="centered">The Room Change Report has been created by <?php echo $rr['name'];?> at <?php echo $rr['timestamp'];?></p>
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