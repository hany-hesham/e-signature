<!DOCTYPE html>
<html lang="en">
	<head>
		<?php $this->load->view('header'); ?>
		<style>
      		@media print {
      			#hany{
      				display: block !important;
      			}
      		}
		</style>
	</head>
	<body>
		<div id="wrapper">
			<?php $this->load->view('menu') ?>
			<div id="page-wrapper">
					<div class="a4wrapper">
						<div class="a4page">
							<div class="page-header">
       			<button onclick="myFunction();" class="non-printable form-actions btn btn-success" href="" style="float:left;">Print</button>
							<a class="form-actions btn btn-info non-printable" href="/amenitys/mailme/<?php echo $amenity['id'] ?>" style="float:left; margin-left: 20px;" > <img src="/assets/images/letter.png" style="width: 28px; height: 40px; margin: 0px; margin-left: -10px; margin-top: -10px; margin-bottom: -10px;"> Share by Email </a>
							<a data-text="whatsapp" data-link="<?php echo base_url(); ?>amenitys/view/<?php echo $amenity['id'] ?>" style="float:left; margin-left: 20px;" class="whatsapp whatsapp_btn whatsapp_btn_small form-actions btn btn-success non-printable"> <img src="/assets/images/original.png" style="width: 70px; height: 50px; margin: -20px; margin-left: -30px; margin-top: -21px;"> Share by Whatsapp</a> 
							<?php if ($is_editor): ?>
								<a class="form-actions btn btn-info non-printable" href="/amenitys/edit/<?php echo $amenity['id'] ?>" style="float:right;" > Edit </a>
							<?php endif ?>
       						<a class="form-actions btn btn-success non-printable" href="/amenitys" style="float:right; margin-right: 20px;" > Back </a>
       						<br>
       						<br>
       						<br>
							<div class="header-logo"><img src="/assets/uploads/logos/<?php echo $amenity['logo']; ?>"/></div>
										<h1 class="centered"><?php echo  $amenity['hotel_name']; ?></h1>
								<h3 class="centered">
									Guest Amenity Request Form No. #<?php echo $amenity['id']; ?>
								</h3>  
							</div>
								<div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
									<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<h5 class="centered"> <span style="font-weight: bold;">Amenity Type: </span> <?php echo $amenity['type_name']; ?> </h5>
									<?php if ($amenity['state_id'] == 2 && ($amenity['type_id'] == 1 || $amenity['type_id'] == 2)){ ?>
										<div class="centered">
			                          		<form action="/amenitys/type/<?php echo $amenity['id']; ?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
			                            		<select class="form-control chooosen centered" name="type_id" style="height:33px; width: 200px;" data-placeholder="Type ...">
			                              			<option></option>
					                              	<?php echo ((isset($department_id) && $department_id == 18) || $is_admin)? '<option value="3">Retoure</option>':'' ;?>
					                              	<?php echo ((isset($department_id) && $department_id == 18) || $is_admin)? '<option value="4">Cancelled</option>':'' ;?>
					                              	<?php echo ((isset($department_id) && $department_id == 18) || $is_admin)? '<option value="5">No Show</option>':'' ;?>
					                              	<?php echo ((isset($department_id) && $department_id == 12) || $is_admin)? '<option value="6">Delivered</option>':'' ;?>
			                            		</select>
			                            		<input name="submit" value="Submit" type="submit" class="btn btn-warning" />
			                          		</form>
			                          	</div>
		                        	<?php } ?>
									<hr style="width: 730px;">
								</div>
								<div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
									<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<h5> <span style="font-weight: bold; font-size: 20px;"> Date and Time of Delivery: </span> <?php echo $amenity['date_time']; ?> </h5>
					                </div>
					                <table class="table table-striped table-bordered table-condensed centered" style="margin-left: -60px;">
					                    <tbody id="items-container" data-items="1">
						                    <tr class="item-row" style=" background-color: blue !important; font-family: Calibri;">
						                      <td class="align-left table-label">Long Stay</td>
						                      <td class="align-left table-label">Room</td>
						                      <td class="align-left table-label">Name</td>
						                      <td class="align-left table-label">Nationality</td>
						                      <td class="align-left table-label">Arrival Date</td>
						                      <td class="align-left table-label">Departure Date</td>
						                      <td class="align-left table-label">No. Pax</td>
						                      <td class="align-left table-label">No. Child</td>
						                      <td class="align-left table-label">The Reason</td>
						                      <td class="align-left table-label">VIP Full Treatment</td>
	                    					  <td class="align-left table-label">Others Amenities</td>
						                      <td class="align-left table-label">Location</td>
						                    </tr>
											<?php foreach ($items as $item):?>
						                      	<tr id="item-1">
							                        <td class="centered"> 
							                        	<?php if ($item['longs']):?>
															<h5><span style="font-weight: bolder;">Long Stay </span> </h5>
														<?php else: ?>
															<h5><span style="font-weight: bolder;">No </span> </h5>
														<?php endif ?>
													</td>
							                        <td class="centered">
							                        	<?php if ($item['amenit']):?>
															<a href="<?php echo base_url(); ?>amenitys/move/<?php echo $item['id'] ?> " class="non-printable form-actions btn btn-primary"><span style="color: black;">&nbsp;&nbsp;&nbsp; <?php echo $item['amenit']['room_new']; ?> &nbsp;&nbsp;&nbsp;</span></a>
														<?php else :?>
															<a href="<?php echo base_url(); ?>amenitys/move/<?php echo $item['id'] ?> " class="non-printable form-actions btn btn-primary">&nbsp;&nbsp;&nbsp; <?php echo $item['room']; ?> &nbsp;&nbsp;&nbsp;</a>
														<?php endif ?>
														<div style="display: none;" id="hany">
																<?php if ($item['amenit']):?>
																	<?php echo $item['amenit']['room_new']; ?>
																<?php else :?>
																	<?php echo $item['room']; ?>
																<?php endif ?>
														</div>
							                        </td> 
							                        <td class="centered">
														<?php echo $item['guest']; ?>
													</td>
													<td class="centered">
														<?php echo $item['nationality']; ?>
													</td>
													<td class="centered">
														<?php echo $item['arrival']; ?>
													</td>
													<td class="centered">
														<?php echo $item['departure']; ?>
													</td>
													<td class="centered">
														<?php echo $item['pax']; ?>
													</td>
													<td class="centered">
														<?php echo $item['child']; ?>
													</td>
													<td class="centered">
														<?php echo $item['reason']; ?>
													</td>
													<td class="centered">
														<?php echo $item['treatment_type']; ?>
													</td>
													<td class="centered">
														<?php foreach ($item['others'] as $other): ?>
															<?php echo $other['other_name']; ?>,
		                        						<?php endforeach ?>	
													</td>
													<td class="centered">
														<?php echo $item['location']; ?>
													</td>
												</tr>
											<?php endforeach ?>	
										</tbody>
									</table>		
									<div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0" style="font-family: Calibri;">
										<?php if ($amenity['ref']):?>
											<h3><span style="font-weight: bolder;">Refiling: </span> <?php echo "&nbsp;&nbsp;&nbsp;".$amenity['refiling'];?>&nbsp;&nbsp;&nbsp;Times</h3>
										<?php endif ?>
									</div>
									<div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0" style="font-family: Calibri;">
										<h4> 
											<span style="font-weight: bold;">Creation Date:</span>
											&nbsp;&nbsp;&nbsp; <?php echo $amenity['timestamp']; ?> &nbsp;&nbsp;&nbsp;
										</h4>
									</div>
									<div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0" style="font-family: Calibri;">
										<h4> 
											<span style="font-weight: bold;">Others:</span>
											&nbsp;&nbsp;&nbsp; <?php echo $amenity['others']; ?> &nbsp;&nbsp;&nbsp;
										</h4>
									</div>
									<div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0" style="font-family: Calibri;">
										<h4> 
											<span style="font-weight: bold;">Guest Relations:</span>
											&nbsp;&nbsp;&nbsp; <?php echo $amenity['relations']; ?> &nbsp;&nbsp;&nbsp;
										</h4>
									</div>
									<div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0  data-indention non-printable">
										<hr style="width: 730px;">
										<label for="offers" class="col-lg-8 col-md-10 col-sm-8 col-xs-8 control-label" style="font-family: Calibri; font-size: 18px; font-weight: bold;">Report Files:</label>
										<div class="form-group col-lg-9 col-md-8 col-sm-7 col-xs-7">
											<?php foreach($uploads as $upload): ?>
												<p> <a href='/assets/uploads/files/<?php echo $upload['name'] ?>'><?php echo $upload['name'] ?></a> Uploaded by <?php echo $upload['user_name'] ?></p>
											<?php endforeach ?>			
										</div>
									</div>
								</div>	
							</div>
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher centered">
								<?php $queue_first = TRUE; ?>
								<?php foreach ($signers as $signe_id => $signer): ?>
									<div class="signature-wrapper">
										<div class="data-head relative"><?php echo (strlen($signer['role']) == 0)? "amenity Owner" : ($signer['role_id'] == '7')? $signer['department'] : $signer['role']."&nbsp".$signer['department']; ?>
											<span class="expander-container"><i class='glyphicon glyphicon-envelope'></i></span>
											<div class="expander-wrapper">
												<span class="expander-remover"><i class='glyphicon glyphicon-remove'></i></span>
												<div class="expander">
													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-holder">
														<div class="row">
															<form action="/amenitys/mailto/<?php echo $amenity['id']; ?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
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
													<a href="/amenitys/unsign/<?php echo $signe_id; ?>" class="non-printable btn btn-primary unsign">Cancel</a>
												<?php endif ?>
											</div>
											<div class="data-content">
												<span class="name-data-content"><?php echo $signer['sign']['name']; ?></span>
												<br />
												<span class="timestamp-data-content"><?php echo $signer['sign']['timestamp']; ?></span>
											</div>
										<?php elseif (array_key_exists($user_id, $signer['queue']) && $queue_first): ?>
											<?php $queue_first = FALSE; ?>
											<div class="data-content non-printable">
												<span class="data-label sign-data-content"></span>
												<a href="/amenitys/sign/<?php echo $signe_id; ?>/reject" class="non-printable btn btn-danger">Reject</a>
												<a href="/amenitys/sign/<?php echo $signe_id; ?>" class="non-printable btn btn-success">sign</a>
											</div>
										<?php else: ?>
											<?php $queue_first = FALSE; ?>
										<?php endif ?>
									</div>
									<?php if (isset($signer['sign']['reject'])){break;}?>
								<?php endforeach ?>
							</div>
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher non-printable">
								<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<form action="/amenitys/comment/<?php echo $amenity['id']?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
										<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
											<textarea class="form-control" name="comment" id="comment"></textarea>
										</div>
										<input name="set_id" value="<?php echo $amenity['id']?>" type="hidden" />
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
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-holder">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher">
									<div class="data-head centered"> 
										<h3>Log</h3> 
									</div>
									<div class="data-holder">
										<p class="centered">The Guest Amenity Request has been created by <?php echo $amenity['name'];?> at <?php echo $amenity['timestamp'];?></p>											
										<?php if ($amenitys):?>
											<?php foreach ($amenitys as $amen):?>
												<p class="centered">The Guest has been moved from Room NO#<?php echo $amen['room_old']; ?> To Room No#<?php echo $amen['room_new']; ?> by <?php echo $amen['name_new'];?> at <?php echo $amen['timestamp'];?></p>
											<?php endforeach?>
										<?php endif ?>
										<?php if ($amenity['type_id'] == 3):?>
											<p class="centered">The Guest Amenity Request has been Retoure for <?php echo $amenity['reason']; ?></p>
										<?php elseif ($amenity['type_id'] == 4):?>
											<p class="centered">The Guest Amenity Request has been Cancelled for <?php echo $amenity['reason']; ?></p>
										<?php elseif ($amenity['type_id'] == 5):?>
											<p class="centered">The Guest Amenity Request has been  Marked as No Show for <?php echo $amenity['reason']; ?></p>
										<?php elseif ($amenity['type_id'] == 6):?>
											<p class="centered">The Guest Amenity Request has been Delivered</p>
										<?php endif ?>
									</div>
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
    		</div>
	    	<script>
				function myFunction() {
    				window.print();
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
			<script type = "text/javascript" >
			   function preventBack(){window.history.forward();}
			    setTimeout("preventBack()", 0);
			    window.onunload=function(){null};
			</script>
	</body>
</html>