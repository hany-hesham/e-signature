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
            			<div>
              				<div class="page-header">
       							<button onclick="window.print()" class="non-printable form-actions btn btn-success" href="">Print</button>
								<?php if ($is_editor): ?>
									<a class="form-actions btn btn-info non-printable" href="/transfer/edit/<?php echo $transfer['id'] ?>" style="float:right;" > Edit </a>
								<?php endif ?>
								<div class="header-logo"><img src="/assets/uploads/logos/6b8f4-logo.png"/></div>
			        			<h2 class="centered">
			        				Payment Plan Form No. #<?php echo $transfer['id']; ?>
			        			</h2>
			        			<a class="form-actions btn btn-info non-printable" href="/transfer/mail_me/<?php echo $transfer['id'] ?>" style="float:left; margin-left: 20px;" > <img src="/assets/images/letter.png" style="width: 28px; height: 40px; margin: 0px; margin-left: -10px; margin-top: -10px; margin-bottom: -10px;"> Share by Email </a>
								<a data-text="whatsapp" data-link="<?php echo base_url(); ?>transfer/view/<?php echo $transfer['id'] ?>" style="float:left; margin-left: 20px;" class="whatsapp whatsapp_btn whatsapp_btn_small form-actions btn btn-success non-printable"> <img src="/assets/images/original.png" style="width: 70px; height: 50px; margin: -20px; margin-left: -30px; margin-top: -21px;"> Share by Whatsapp</a> 
								<a class="form-actions btn btn-success non-printable" href="/transfer" style="float:right;"> Back </a>
			        			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher data-indention">
				        			<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12" dir="rtl">
	                  					<p>السيد / رئيس مجلس الإدارة</p>
	                  					<p>تحية طيبة</p>
	                  					<p>التاريخ <?php echo $transfer['date'] ?></p>
	                  					<p>برجاء أعتماد تحويل إجمالى المبلغ أدناه من حساب رقم <?php echo $transfer['from_acc'] ?> إلى حساب <?php echo $transfer['to_acc'] ?> علماً بأن بيانها كالأتى : -</p>
	                  				</div>
	                  			</div>
			        			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher data-indention">
	                  				<table class="table table-striped table-bordered table-condensed">
					                    <tr>
					                        <th colspan="1" style=" text-align: center;">مسلسل</th>
					                        <th colspan="1" style=" text-align: center;">البيــــــــــــــــــــــــــان</th>
					                        <th colspan="1" style=" text-align: center;">الادارة</th>
					                        <th colspan="1" style=" text-align: center;">القيمة بالجنية</th>
					                        <th colspan="1" style=" text-align: center;">القيمة بالدولار</th>
					                        <th colspan="1" style=" text-align: center;">ملاحظات </th>
					                    </tr>
										<?php $count = 1; ?>
										<?php $eg_counter = 0; ?>
										<?php $usd_counter = 0; ?>
										<?php foreach ($items as $item): ?>
											<tr class="item-row" style="font-size: 12px;">
												<td class="centered"><?php echo $count; ?></td>
												<td class="centered"><?php echo $item['name']; ?></td>
												<td class="centered"><?php echo $item['department']; ?></td>
												<td class="centered"><?php echo $item['eg_value']; ?></td>
												<td class="centered"><?php echo $item['usd_value']; ?></td>
												<td class="centered"><?php echo $item['remarks']; ?></td>
											</tr>
											<?php $eg_counter = $eg_counter + $item['eg_value']; ?>
											<?php $usd_counter = $usd_counter + $item['usd_value']; ?>
											<?php $count++; ?>
										<?php endforeach ?>
										<tr class="item-row" style="font-size: 12px;">
											<td class="centered" colspan="3">المجموع</td>
											<td class="centered"><?php echo $eg_counter; ?></td>
											<td class="centered"><?php echo $usd_counter; ?></td>
											<td class="centered"></td>
										</tr>
									</table>
								</div>
			        			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher data-indention">
									<table class="table table-striped table-bordered table-condensed">
										<tr>
						                    <th colspan="1" style=" text-align: center;">الادارة</th>
						                    <th colspan="2" style=" text-align: center;">القيمة بالجنية/النسبة</th>
						                    <th colspan="2" style=" text-align: center;">القيمة بالدولار/النسبة</th>
						                </tr>
										<?php $i = 0; ?>
										<?php foreach ($item_department as $item_dep) { ?>
											<tr class="item-row" style="font-size: 12px;">
												<td class="centered" colspan="1"><?php echo $item_dep['department']; ?></td>
												<?php $amount = 0; ?>
												<?php foreach ($form_value[$i] as $values):?>
													<?php $amount= $amount + $values['eg_value']; ?>
													<?php $percentage_eg = ($amount/$eg_counter)*100; ?>
												<?php endforeach; ?>
												<td class="centered" colspan="1"><?php echo $amount; ?> EGP</td>
												<td class="centered" colspan="1"><?php echo $percentage_eg; ?> %</td>
												<?php $amount1 = 0; ?>
												<?php foreach ($form_value[$i] as $values):?>
													<?php $amount1= $amount1 + $values['usd_value']; ?>
													<?php $percentage_usd = ($amount1/$usd_counter)*100; ?>
												<?php endforeach; ?>
												<td class="centered" colspan="1"><?php echo $amount1; ?> $</td>
												<td class="centered" colspan="1"><?php echo $percentage_usd; ?> %</td>
												<?php $i++; ?>
											</tr>
										<?php } ?>
										<tr class="item-row" style="font-size: 12px;">
											<td class="centered" colspan="1">المجموع</td>
											<td class="centered" colspan="1"><?php echo $eg_counter; ?> EGP</td>
											<td class="centered" colspan="1">100%</td>
											<td class="centered" colspan="1"><?php echo $usd_counter; ?>  $</td>
											<td class="centered" colspan="1">100%</td>
										</tr>
									</table>
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
				                            				<form action="/transfer/mail/<?php echo $transfer['id']; ?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
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
				                    				<a href="/transfer/unsign/<?php echo $signe_id; ?>" class="non-printable btn btn-primary unsign">Cancel</a>
				                    			<?php endif ?>
				                  			</div>
				                  			<div class="data-content">
				                  				<span class="name-data-content"><?php echo $signer['sign']['name']; ?></span>
				                  				<br />
				                  				<span class="timestamp-data-content"><?php echo $signer['sign']['timestamp']; ?></span>
				                  			</div>
				                  		<?php elseif (array_key_exists($user_id, $signer['queue']) && $queue_first): ?>
				                  			<?php $queue_first = FALSE; ?>
				                  			<div class="data-content non-printable"><span class="data-label sign-data-content"></span><a href="/transfer/sign/<?php echo $signe_id; ?>/reject" class="non-printable btn btn-danger">Reject</a><a href="/transfer/sign/<?php echo $signe_id; ?>" class="non-printable btn btn-success">sign</a></div>
				                  		<?php else: ?>
				                  			<?php $queue_first = FALSE; ?>
				                  		<?php endif ?>
				                	</div>
				                    <?php if (isset($signer['sign']['reject'])){break;}?>
				                <?php endforeach ?>
				            </div>
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher non-printable">
	                			<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
	                  				<form action="/transfer/comment/<?php echo $transfer['id']?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
	                    				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
	                     					<textarea class="form-control" name="comment" id="comment"></textarea>
	                    				</div>
	                    				<input name="tran_id" value="<?php echo $transfer['id']?>" type="hidden" />
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
	    				<p class="centered">The Transfer Form has been created by <?php echo $transfer['name'];?> at <?php echo $transfer['timestamp'];?></p>
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