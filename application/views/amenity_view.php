<!DOCTYPE html>
<html lang="en">
	<head>
		<?php $this->load->view('header'); ?>
		<style>
      		@media print {
      			#print{
      				display: block !important;
      			}
      			#print1{
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
							<button onclick="window.print()" class="non-printable form-actions btn btn-success" href="" >Print</button>
							<?php if ($is_editor): ?>
								<a class="form-actions btn btn-info non-printable" href="/amenity/<?php echo (isset($reason['type']) && $reason['type'] == 5)? "edit_exp" : "edit"?>/<?php echo $amenity['id'] ?>" style="float:right;" > Edit </a>
							<?php endif ?>
							<div class="header-logo"><img src="/assets/uploads/logos/<?php echo ($amenity_edit)? $amenity_edit['logo'] : $amenity['logo']; ?>"/></div>
										<h1 class="centered"><?php echo ($amenity_edit)? $amenity_edit['hotel_name'] : $amenity['hotel_name']; ?></h1>
								<h3 class="centered">
									Guest Amenity Request Form No. #<?php echo $amenity['id']; ?>
								</h3>   					
								<a class="form-actions btn btn-info non-printable" href="/amenity/mailme/<?php echo $amenity['id'] ?>" style="float:left; margin-left: 20px; margin-top: 20px;" > <img src="/assets/images/letter.png" style="width: 28px; height: 40px; margin: 0px; margin-left: -10px; margin-top: -10px; margin-bottom: -10px;"> Share by Email </a>
								<a data-text="whatsapp" data-link="<?php echo base_url(); ?>amenity/view/<?php echo $amenity['id'] ?>" style="float:left; margin-left: 20px; margin-top: 20px;" class="whatsapp whatsapp_btn whatsapp_btn_small form-actions btn btn-success non-printable"> <img src="/assets/images/original.png" style="width: 70px; height: 50px; margin: -20px; margin-left: -30px; margin-top: -21px;"> Share by Whatsapp</a> 
								<a class="form-actions btn btn-success non-printable" href="/amenity" style="float:right; margin-left: 20px; margin-top: 20px;" > Back </a>
							</div>
									<div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
										<hr style="width: 120%">
								<?php if (isset($reason['type'])) { ?>
									<?php if ($reason['type'] == 1) { ?>
										<h5 class="centered"> <span style="font-weight: bold;">Amenity Type: </span> Retoure </h5>
									<?php }elseif ($reason['type'] == 2){ ?>
										<h5 class="centered"> <span style="font-weight: bold;">Amenity Type: </span> Cancelled </h5>
									<?php }elseif ($reason['type'] == 3){ ?>
										<h5 class="centered"> <span style="font-weight: bold;">Amenity Type: </span> No Show </h5>
									<?php }elseif ($reason['type'] == 4){ ?>
										<h5 class="centered"> <span style="font-weight: bold;">Amenity Type: </span> Delivered </h5>
									<?php }elseif ($reason['type'] == 5){ ?>
										<h5 class="centered"> <span style="font-weight: bold;">Amenity Type: </span> Expacted Arrival </h5>
									<?php } ?>
								<?php }else{ ?>
									<h5 class="centered"> <span style="font-weight: bold;">Amenity Type: </span> In House </h5>
								<?php } ?>
										<hr style="width: 730px;">
								  <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
									<div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
										<h3><span style="font-weight: bolder;">Room No#</span> </h3>
										<?php foreach ($items as $item):?>
														<?php if ($item['amenit']):?>
															<a href="<?php echo base_url(); ?>amenity/move/<?php echo $item['id'] ?> " style="float:left; margin-left: 20px; margin-top: 20px;" class="non-printable form-actions btn btn-primary"><span style="color: black;">&nbsp;&nbsp;&nbsp; <?php echo $item['amenit']['room_new']; ?> &nbsp;&nbsp;&nbsp;</span></a>
														<?php else :?>
													<a href="<?php echo base_url(); ?>amenity/move/<?php echo $item['id'] ?> " style="float:left; margin-left: 20px; margin-top: 20px;" class="non-printable form-actions btn btn-primary">&nbsp;&nbsp;&nbsp; <?php echo $item['room']; ?> &nbsp;&nbsp;&nbsp;</a>
														<?php endif ?>
										<?php endforeach?>
										<div style="display: none;" id="print">
											<?php foreach ($items as $item):?>
													<?php if ($item['amenit']):?>
														&nbsp;&nbsp;&nbsp; <?php echo $item['amenit']['room_new']; ?> &nbsp;&nbsp;&nbsp;
													<?php else :?>
														&nbsp;&nbsp;&nbsp; <?php echo $item['room']; ?> &nbsp;&nbsp;&nbsp;
													<?php endif ?>
											<?php endforeach?>
										</div>
									</div>
									<div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
										<br>
										<?php if ($room_edit):?>
												<?php if ($room_edit['long']):?>
										<h4><span style="font-weight: bolder;">Long Stay </span> </h4>
												<?php endif ?>
										<?php else :?>
												<?php if ($room['long']):?>
										<h4><span style="font-weight: bolder;">Long Stay </span> </h4>
												<?php endif ?>
										<?php endif ?>
									</div>

									<div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
										<?php if ($room_edit):?>
												<?php if ($room_edit['ref']):?>
													<h3><span style="font-weight: bolder;">Refiling: </span> </h3>
													<h3 class="non-printable form-actions btn btn-primary"><?php echo "&nbsp;&nbsp;&nbsp;".$room_edit['refiling'];?>&nbsp;&nbsp;&nbsp;Times</h3>
												<?php endif ?>
										<?php else :?>
												<?php if ($room['ref']):?>
													<h3><span style="font-weight: bolder;">Refiling: </span> </h3>
													<h3 class="non-printable form-actions btn btn-primary"><?php echo "&nbsp;&nbsp;&nbsp;".$room['refiling'];?>&nbsp;&nbsp;&nbsp;Times</h3>
												<?php endif ?>
										<?php endif ?>
										<div style="display: none;" id="print1">
											<?php if ($room_edit['ref']):?>
												<?php if ($room_edit['ref']):?>
													<?php echo "&nbsp;&nbsp;&nbsp;".$room_edit['refiling'];?>&nbsp;&nbsp;&nbsp;days
												<?php endif ?>
											<?php else :?>
												<?php if ($room['ref']):?>
													<?php echo "&nbsp;&nbsp;&nbsp;".$room['refiling'];?>&nbsp;&nbsp;&nbsp;days
												<?php endif ?>
											<?php endif ?>
										</div>
									</div>
									  <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0" style="font-family: Calibri;">
										<h4> 
											<span style="font-weight: bold;">Date:</span>
													&nbsp;&nbsp;&nbsp; <?php echo $amenity['timestamp']; ?> &nbsp;&nbsp;&nbsp;
										</h4>
									  </div>
										<div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0" style="width: 800px; font-family: Calibri;">
										<h4> 
											<span style="font-weight: bold;">Guest Name:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
											<?php if (isset($items[1]['guest']) && $items[0]['guest'] == $items[1]['guest']):?>
												<?php if ($room_edit):?>
														&nbsp;&nbsp;&nbsp; <?php echo $room_edit['guest']; ?> &nbsp;&nbsp;&nbsp;
												<?php else: ?>
														&nbsp;&nbsp;&nbsp; <?php echo $room['guest']; ?> &nbsp;&nbsp;&nbsp;
												<?php endif ?>
											<?php else: ?>
												<?php if ($amenity_edit):?>
													<?php foreach ($items_edit as $item):?>
															&nbsp;&nbsp;&nbsp; <?php echo $item['guest']; ?> &nbsp;&nbsp;&nbsp;
													<?php endforeach?>
												<?php else: ?>
													<?php foreach ($items as $item):?>
															&nbsp;&nbsp;&nbsp; <?php echo $item['guest']; ?> &nbsp;&nbsp;&nbsp;
													<?php endforeach?>
												<?php endif ?>
											<?php endif ?>
										</h4>
									  </div>
									  <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0" style="font-family: Calibri;">
										<h4> 
											<span style="font-weight: bold;">Guest Nationality:</span>
											<?php if (isset($items[1]['nationality']) && $items[0]['nationality'] == $items[1]['nationality']):?>
												<?php if ($room_edit):?>
														&nbsp;&nbsp;&nbsp; <?php echo $room_edit['nationality']; ?> &nbsp;&nbsp;&nbsp;
												<?php else: ?>
														&nbsp;&nbsp;&nbsp; <?php echo $room['nationality']; ?> &nbsp;&nbsp;&nbsp;
												<?php endif ?>
											<?php else: ?>
												<?php if ($amenity_edit):?>
													<?php foreach ($items_edit as $item):?>
															&nbsp;&nbsp;&nbsp; <?php echo $item['nationality']; ?> &nbsp;&nbsp;&nbsp;
													<?php endforeach?>
												<?php else: ?>
													<?php foreach ($items as $item):?>
															&nbsp;&nbsp;&nbsp; <?php echo $item['nationality']; ?> &nbsp;&nbsp;&nbsp;
													<?php endforeach?>
												<?php endif ?>
											<?php endif ?>
										</h4>
									  </div>
									  <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0" style="font-family: Calibri;">
										<h4> 
											<span style="font-weight: bold;">Arrival Date:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
											<?php if (isset($items[1]['arrival']) && $items[0]['arrival'] == $items[1]['arrival']):?>
												<?php if ($room_edit):?>
														&nbsp;&nbsp;&nbsp; <?php echo $room_edit['arrival']; ?> &nbsp;&nbsp;&nbsp;
												<?php else: ?>
														&nbsp;&nbsp;&nbsp; <?php echo $room['arrival']; ?> &nbsp;&nbsp;&nbsp;
												<?php endif ?>
											<?php else: ?>
												<?php if ($amenity_edit):?>
													<?php foreach ($items_edit as $item):?>
															&nbsp;&nbsp;&nbsp; <?php echo $item['arrival']; ?> &nbsp;&nbsp;&nbsp;
													<?php endforeach?>
												<?php else: ?>
													<?php foreach ($items as $item):?>
															&nbsp;&nbsp;&nbsp; <?php echo $item['arrival']; ?> &nbsp;&nbsp;&nbsp;
													<?php endforeach?>
												<?php endif ?>
											<?php endif ?>
										</h4>
									  </div>
									  <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0" style="font-family: Calibri;">
										<h4> 
											<span style="font-weight: bold;">Departure Date:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
											<?php if (isset($items[1]['departure']) && $items[0]['departure'] == $items[1]['departure']):?>
												<?php if ($room_edit):?>
														&nbsp;&nbsp;&nbsp; <?php echo $room_edit['departure']; ?> &nbsp;&nbsp;&nbsp;
												<?php else: ?>
														&nbsp;&nbsp;&nbsp; <?php echo $room['departure']; ?> &nbsp;&nbsp;&nbsp;
												<?php endif ?>
											<?php else: ?>
												<?php if ($amenity_edit):?>
													<?php foreach ($items_edit as $item):?>
															&nbsp;&nbsp;&nbsp; <?php echo $item['departure']; ?> &nbsp;&nbsp;&nbsp;
													<?php endforeach?>
												<?php else: ?>
													<?php foreach ($items as $item):?>
															&nbsp;&nbsp;&nbsp; <?php echo $item['departure']; ?> &nbsp;&nbsp;&nbsp;
													<?php endforeach?>
												<?php endif ?>
											<?php endif ?>
										</h4>
									  </div>
									  <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0" style="font-family: Calibri;">
										<h4> 
											<span style="font-weight: bold;">No. of Pax:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
													<?php if ($amenity_edit):?>
														<?php foreach ($items_edit as $item):?>
															&nbsp;&nbsp;&nbsp; Adult <?php echo $item['pax']; ?> Childs <?php echo $item['child']; ?> &nbsp;&nbsp;&nbsp;
														<?php endforeach?>
													<?php else: ?>
														<?php foreach ($items as $item):?>
															&nbsp;&nbsp;&nbsp; Adult <?php echo $item['pax']; ?> Childs <?php echo $item['child']; ?> &nbsp;&nbsp;&nbsp;
														<?php endforeach ?>
													<?php endif ?>
										</h4>
									  </div>
									  <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0" style="font-family: Calibri;">
										<h4> 
											<span style="font-weight: bold;">Date and Time of Delivery:</span>
											<?php if ($amenity_edit):?>
														&nbsp;&nbsp;&nbsp; <?php echo $amenity_edit['date_time']; ?> &nbsp;&nbsp;&nbsp;
													<?php else: ?>
														&nbsp;&nbsp;&nbsp; <?php echo $amenity['date_time']; ?> &nbsp;&nbsp;&nbsp;
													<?php endif ?>
										</h4>
									  </div>
									  <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0" style="font-family: Calibri;">
										<h4> 
											<span style="font-weight: bold;">The Reason:</span>
											<?php if ($amenity_edit):?>
														&nbsp;&nbsp;&nbsp; <?php echo $amenity_edit['reason']; ?> &nbsp;&nbsp;&nbsp;
													<?php else: ?>
														&nbsp;&nbsp;&nbsp; <?php echo $amenity['reason']; ?> &nbsp;&nbsp;&nbsp;
													<?php endif ?>
										</h4>
									  </div>
									  <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0" style="font-family: Calibri;">
										<h4> 
											<span style="font-weight: bold;">VIP Full Treatment:</span>
													<?php if ($room_edit):?>
															&nbsp;&nbsp;&nbsp; <?php echo $room_edit['treatment']; ?> &nbsp;&nbsp;&nbsp;
													<?php else: ?>
															&nbsp;&nbsp;&nbsp; <?php echo $room['treatment']; ?> &nbsp;&nbsp;&nbsp;
													<?php endif ?>
										</h4>
									  </div>
											<div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0" style="font-family: Calibri;">
										<h4> 
											<span style="font-weight: bold;">Others:</span>
											<br>
											<br>
											<?php if ($room_edit):?>
																<?php echo ($room_edit['cookies'] == "0")? "":"&nbsp;Cookies,"?>
															<?php echo ($room_edit['nuts'] == "0")? "":"&nbsp;Nuts,"?>
															<?php echo ($room_edit['wine'] == "0")? "":"&nbsp;Bottle Of Wine,"?>
															<?php echo ($room_edit['fruit'] == "0")? "":"&nbsp;Fruit Basket,"?>
															<?php echo ($room_edit['beer'] == "0")? "":"&nbsp;Beer,"?>
															<?php echo ($room_edit['cake'] == "0")? "":"&nbsp;Birthday Cake,"?>
															<?php echo ($room_edit['anniversary'] == "0")? "":"&nbsp;Anniversary,"?>
															<?php echo ($room_edit['honeymoon'] == "0")? "":"&nbsp;Honeymoon,"?>
															<?php echo ($room_edit['juices'] == "0")? "":"&nbsp;Small Can of Juices,"?>
															<?php echo ($room_edit['dinner'] == "0")? "":"&nbsp;Candel Light Dinner,"?>
															<?php echo ($room_edit['sick'] == "0")? "":"&nbsp;Sick Meal,"?>
															<?php echo ($room_edit['alcohol'] == "0")? "":"&nbsp;Without Alcohol,"?>
															<?php echo ($room_edit['th'] == "0")? "":"&nbsp;TH Bonus,"?>
															<?php echo ($room_edit['uk'] == "0")? "":"&nbsp;TC UK arrival,"?>
															<?php echo ($room_edit['chocolate'] == "0")? "":"&nbsp;Chocolate,"?>
															<?php echo ($room_edit['milk'] == "0")? "":"&nbsp;Milk,"?>
															<br>
															<br>
													<?php else: ?>
															<?php echo ($room['cookies'] == "0")? "":"&nbsp;Cookies,"?>
															<?php echo ($room['nuts'] == "0")? "":"&nbsp;Nuts,"?>
															<?php echo ($room['wine'] == "0")? "":"&nbsp;Bottle Of Wine,"?>
															<?php echo ($room['fruit'] == "0")? "":"&nbsp;Fruit Basket,"?>
															<?php echo ($room['beer'] == "0")? "":"&nbsp;Beer,"?>
															<?php echo ($room['cake'] == "0")? "":"&nbsp;Birthday Cake,"?>
															<?php echo ($room['anniversary'] == "0")? "":"&nbsp;Anniversary,"?>
															<?php echo ($room['honeymoon'] == "0")? "":"&nbsp;Honeymoon,"?>
															<?php echo ($room['juices'] == "0")? "":"&nbsp;Small Can of Juices,"?>
															<?php echo ($room['dinner'] == "0")? "":"&nbsp;Candel Light Dinner,"?>
															<?php echo ($room['sick'] == "0")? "":"&nbsp;Sick Meal,"?>
															<?php echo ($room['alcohol'] == "0")? "":"&nbsp;Without Alcohol,"?>
															<?php echo ($room['th'] == "0")? "":"&nbsp;TH Bonus,"?>
															<?php echo ($room['uk'] == "0")? "":"&nbsp;TC UK arrival,"?>
															<?php echo ($room['chocolate'] == "0")? "":"&nbsp;Chocolate,"?>
															<?php echo ($room['milk'] == "0")? "":"&nbsp;Milk,"?>
															<br>
															<br>
													<?php endif ?>
										</h4>
									  </div>
									  <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0" style="font-family: Calibri;">
										<h4> 
											<span style="font-weight: bold;">Location:</span>
											<?php if ($amenity_edit):?>
														&nbsp;&nbsp;&nbsp; <?php echo $amenity_edit['location']; ?> &nbsp;&nbsp;&nbsp;
													<?php else: ?>
														&nbsp;&nbsp;&nbsp; <?php echo $amenity['location']; ?> &nbsp;&nbsp;&nbsp;
													<?php endif ?>
										</h4>
									  </div>
									  <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0" style="font-family: Calibri;">
										<h4> 
											<span style="font-weight: bold;">Others:</span>
											<?php if ($amenity_edit):?>
														&nbsp;&nbsp;&nbsp; <?php echo $amenity_edit['others']; ?> &nbsp;&nbsp;&nbsp;
													<?php else: ?>
														&nbsp;&nbsp;&nbsp; <?php echo $amenity['others']; ?> &nbsp;&nbsp;&nbsp;
													<?php endif ?>
										</h4>
									  </div>
									  <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0" style="font-family: Calibri;">
										<h4> 
											<span style="font-weight: bold;">Guest Relations:</span>
											<?php if ($amenity_edit):?>
														&nbsp;&nbsp;&nbsp; <?php echo $amenity_edit['relations']; ?> &nbsp;&nbsp;&nbsp;
													<?php else: ?>
														&nbsp;&nbsp;&nbsp; <?php echo $amenity['relations']; ?> &nbsp;&nbsp;&nbsp;
													<?php endif ?>
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
																		<form action="/amenity/mailto/<?php echo $amenity['id']; ?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
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
															<a href="/amenity/unsign/<?php echo $signe_id; ?>" class="non-printable btn btn-primary unsign">Cancel</a>
														<?php endif ?>
														</div>
														<div class="data-content">
															<span class="name-data-content"><?php echo $signer['sign']['name']; ?></span>
															<br />
															<span class="timestamp-data-content"><?php echo $signer['sign']['timestamp']; ?></span>
														</div>
													<?php elseif (array_key_exists($user_id, $signer['queue']) && $queue_first): ?>
														<?php $queue_first = FALSE; ?>
														<div class="data-content non-printable"><span class="data-label sign-data-content"></span><a href="/amenity/sign/<?php echo $signe_id; ?>/reject" class="non-printable btn btn-danger">Reject</a><a href="/amenity/sign/<?php echo $signe_id; ?>" class="non-printable btn btn-success">sign</a></div>
													<?php else: ?>
														<?php $queue_first = FALSE; ?>
													<?php endif ?>
											</div>
											<?php if (isset($signer['sign']['reject'])){break;}?>
										<?php endforeach ?>
									</div>
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher non-printable">
										<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
												<form action="/amenity/comment/<?php echo $amenity['id']?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
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
											<?php if (isset($reason['type'])) { ?>
												<?php if ($reason['type'] == 1) { ?>
													<p class="centered">The Guest Amenity Request has been Retoure by <?php echo $reason['name'];?> at <?php echo $reason['timestamp'];?></p>
												<?php }elseif ($reason['type'] == 2){ ?>
													<p class="centered">The Guest Amenity Request has been Cancelled by <?php echo $reason['name'];?> at <?php echo $reason['timestamp'];?></p>
												<?php }elseif ($reason['type'] == 3){ ?>
													<p class="centered">The Guest Amenity Request has been Marked as No Show by <?php echo $reason['name'];?> at <?php echo $reason['timestamp'];?></p>
												<?php }elseif ($reason['type'] == 4){ ?>
													<p class="centered">The Guest Amenity Request has been Delivered by <?php echo $reason['name'];?> at <?php echo $reason['timestamp'];?></p>
												<?php } ?>
											<?php } ?>
											<?php if ($amenity_edit):?>
												<?php foreach ($amenitys_edit as $amenit_edit):?>
														<p class="centered">The Guest Amenity Request has been Edited by <?php echo $amenit_edit['name'];?> at <?php echo $amenit_edit['timestamp'];?></p>
												<?php endforeach?>
											<?php endif ?>
											<?php foreach ($items as $item):?>
															<?php if ($item['amenit']):?>
														<?php foreach ($amenitys as $amen):?>
															<p class="centered">The Guest Amenity Request has been moved from Room NO#<?php echo ($item['amenit']['room_old']== 0)? $item['room'] : $amen['room_old']; ?> To Room No#<?php echo $amen['room_new']; ?> by <?php echo $amen['name_new'];?> at <?php echo $amen['timestamp'];?></p>
														<?php endforeach?>
															<?php endif ?>
											<?php endforeach?>
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