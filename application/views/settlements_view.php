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
								<?php if  ($ccrm) :?>
									<a class="form-actions btn btn-info non-printable" href="/settlements/edit/<?php echo $settlements['id'] ?>" style="float:right;" >CCRM Edit </a>
								<?php endif ?>
								<div class="header-logo"><img src="/assets/uploads/logos/<?php echo $settlements['logo']; ?>"/></div>
	                  			<h1 class="centered"><?php echo $settlements['hotel_name']; ?></h3>
		        				<h3 class="centered">
		        					Settlements Authorization Form No. #<?php echo $settlements['id']; ?>
		        				</h3>
		        				<a class="form-actions btn btn-info non-printable" href="/settlements/mail_me/<?php echo $settlements['id'] ?>" style="float:left; margin-left: 20px;" > <img src="/assets/images/letter.png" style="width: 28px; height: 40px; margin: 0px; margin-left: -10px; margin-top: -10px; margin-bottom: -10px;"> Share by Email </a>
								<a data-text="whatsapp" data-link="<?php echo base_url(); ?>settlements/view/<?php echo $settlements['id'] ?>" style="float:left; margin-left: 20px;" class="whatsapp whatsapp_btn whatsapp_btn_small form-actions btn btn-success non-printable"> <img src="/assets/images/original.png" style="width: 70px; height: 50px; margin: -20px; margin-left: -30px; margin-top: -21px;"> Share by Whatsapp</a> 
								<a class="form-actions btn btn-success non-printable" href="/settlements" style="float:right;"> Back </a>
	    					</div>
							<table class="table table-striped table-bordered table-condensed">
								<tr class="item-row">
									<td class="align-left table-label">Date of SAF</td>
									<td class="align-left table-label"><?php echo $settlements['Date']; ?></td>
								</tr>
								<tr class="item-row">
									<td class="align-left table-label">SAF Valid Till</td>
									<td class="align-left table-label"><?php echo $settlements['Date_till']; ?></td>
								</tr>
								<tr class="item-row">
									<td class="align-left table-label">Proposed settlements, £ :</td>
									<td class="align-left table-label">
									   <?php  echo $settlements['Proposed'] ." ".$settlements['currency'] ?><br>	
										<?php  foreach ($comment_proposed as $comment) :?> 
										    <div><?php echo $comment['comment']?></div>
										 <?php endforeach ?>	
									   <?php if ($role_id==47 || $role_id==54 || $user_id==1) :?>
										<div class="data-head relative" style="margin-bottom:20px; ">
			                    		  <span class="expander-container non-printable"><i class='glyphicon glyphicon-pencil'></i></span>
			                    		    <div class="expander-wrapper">
			                      			  <span class="expander-remover"><i class='glyphicon glyphicon-remove '></i></span>
			                      			     <div class="expander">
			                        			    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-holder" style="margin-top: 10px;">
			                          				  <div class="row">
			                            				<form action="/settlements/submit_inline_comment/<?php echo $settlements['id'];?>/1 " method="POST"             id="form-submit"  class="form-div span12" accept-charset="utf-8">
			                              					<textarea class="form-control" name="comment" id="comment"></textarea>
			                              					<input name="submit" value="comment" type="submit" class="inverse-offset btn btn-success" />
			                            				</form>
			                          				</div>
			                        			</div>
			                      			</div>
			                    		</div>
			                  		</div>
			                  		<?php endif ?>
									</td>
								</tr>
								<tr class="item-row">
									<td class="align-left table-label">Customer Name:</td>
									<td class="align-left table-label"><?php echo $settlements['File']; ?></td>
								</tr>
								<tr class="item-row">
									<td class="align-left table-label">Booking Ref:</td>
									<td class="align-left table-label"><?php echo $settlements['Ref']; ?></td>
								</tr>
								<tr class="item-row">
									<td class="align-left table-label">Date of Incident:</td>
									<td class="align-left table-label"><?php echo $settlements['date_incident']; ?></td>
								</tr>
								<tr class="item-row">
									<td class="align-left table-label">Highest Reserve, £:</td>
									<td class="align-left table-label"><?php echo $settlements['Highest_Reserve'] ." ".$settlements['reserve_currency']; ?></td>
								</tr>
								<tr class="item-row">
									<td class="align-left table-label">Type of Claim:</td>
									<td class="align-left table-label"><?php echo $settlements['claim_type']; ?></td>
								</tr>
								<tr class="item-row">
									<td class="align-left table-label">N. of Claimants:</td>
									<td class="align-left table-label"><?php echo $settlements['num_claimants']; ?></td>
								</tr>
								<tr class="item-row">
									<td class="align-left table-label">Nature of Claim:</td>
									<td class="align-left table-label"><?php echo $settlements['nature_claim'] ; ?><br>
										    <?php  foreach ($comment_nature_claim as $comment) :?> 
										       <div><?php echo $comment['comment']?></div>
										    <?php endforeach ?>
										 <?php if ($role_id==47 || $role_id==54 || $user_id==1) :?>
                                    <div class="data-head relative" style="margin-bottom:20px; ">
			                    		  <span class="expander-container non-printable"><i class='glyphicon glyphicon-pencil'></i></span>
			                    		    <div class="expander-wrapper">
			                      			  <span class="expander-remover"><i class='glyphicon glyphicon-remove'></i></span>
			                      			     <div class="expander">
			                        			    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-holder" style="margin-top: 10px;">
			                          				  <div class="row">
			                            				<form action="/settlements/submit_inline_comment/<?php echo $settlements['id']; ?>/2" method="POST"                id="form-submit" class="form-div span12" accept-charset="utf-8">
			                              					<textarea class="form-control" name="comment" id="comment"></textarea>
			                              					<input name="submit" value="comment" type="submit" class="inverse-offset btn btn-success" />
			                            				</form>
			                          				</div>
			                        			</div>
			                      			</div>
			                    		</div>
			                  		</div>
			                  	<?php endif ?>
									</td>
								</tr>
								<tr class="item-row">
									<td class="align-left table-label">Status of Claim:</td>
									<td class="align-left table-label"><?php echo $settlements['claim_status']; ?></td>
								</tr>
								<tr class="item-row">
									<td class="align-left table-label">Closed Amount, £ (if relevant):</td>
									<td class="align-left table-label"><?php echo $settlements['closed_amount']." ". $settlements['closed_amount_currency']; ?></td>
								</tr>
								<tr class="item-row">
									<td class="align-left table-label">Date of Closed Notice (if relevant):</td>
									<td class="align-left table-label"><?php echo $settlements['closed_date_notice']; ?></td>
								</tr>
								<tr class="item-row">
									<td class="align-left table-label">Cristal Score (if relevant):</td>
									<td class="align-left table-label"><?php echo $settlements['cristal_score']; ?></td>
								</tr>
								<tr class="item-row">
									<td class="align-left table-label">N. of Claims of the same nature within 3 months:</td>
									<td class="align-left table-label"><?php echo $settlements['num_similar_claims']; ?><br>
										  <?php  foreach ($comment_similar_claim as $comment) :?> 
										       <div><?php echo $comment['comment']?></div>
										    <?php endforeach ?>
										  <?php if  ($role_id==47 || $role_id==54 || $user_id==1) :?>
                                       <div class="data-head relative" style="margin-bottom:20px; " >
			                    		  <span class="expander-container non-printable"><i class='glyphicon glyphicon-pencil'></i></span>
			                    		    <div class="expander-wrapper">
			                      			  <span class="expander-remover"><i class='glyphicon glyphicon-remove'></i></span>
			                      			     <div class="expander">
			                        			    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-holder" style="margin-top: 10px;">
			                          				  <div class="row">
			                            				<form action="/settlements/submit_inline_comment/<?php echo $settlements['id']; ?>/3" method="POST"                id="form-submit" class="form-div span12" accept-charset="utf-8">
			                              					<textarea class="form-control" name="comment" id="comment"></textarea>
			                              					<input name="submit" value="comment" type="submit" class="inverse-offset btn btn-success" />
			                            				</form>
			                          				</div>
			                        			</div>
			                      			</div>
			                    		</div>
			                  		</div>
			                  	<?php endif ?>
									</td>
								</tr>
								<tr class="item-row">
									<td class="align-left table-label">Rationale for proposed settlements:</td>
									<td class="align-left table-label"><?php echo $settlements['Rationale']; ?></td>
								</tr>
								<tr class="item-row">
									<td class="align-left table-label">Potential Risk if Proposed settlements Declined:</td>
									<td class="align-left table-label"><?php echo $settlements['Risk']; ?></td>
								</tr>
								<tr class="item-row">
									<td class="align-left table-label">Status of SAF*:</td>
									<td class="align-left table-label"><?php echo $settlements['status']; ?>
									<?php if ($role_id==47 || $role_id==54 || $user_id==1) :?>
										 <div class="data-head relative" style="margin-bottom:20px; " >
			                    		  <span class="expander-container non-printable"><i class='glyphicon glyphicon-pencil'></i></span>
			                    		    <div class="expander-wrapper">
			                      			  <span class="expander-remover"><i class='glyphicon glyphicon-remove'></i></span>
			                      			     <div class="expander">
			                        			    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-holder" style="margin-top: 10px;">
			                          				  <div class="row">
			                            				<form action="/settlements/edit_status/<?php echo $settlements['id']; ?>" method="POST"        
			                            				        id="form-submit" class="form-div span12" accept-charset="utf-8">
			                              					 <select class="form-control" name="status" style="height:35px; width: 400px;">
                                                                <option value = "">Status of SAF*</option>
                                                                <?php foreach ($statuss as $status)  :?>
                                                                   <option value = "<?php echo $status['status'] ?>" ><?php echo $status['status'] ?></option>
                                                                <?php endforeach ?>
                                                              </select>
			                              					<input name="submit" value="update" type="submit" class="inverse-offset btn btn-success" />
			                            				</form>
			                          				</div>
			                        			</div>
			                      			</div>
			                    		</div>
			                  		</div>
			                  	<?php endif ?>
									</td>
								</tr>
								<tr class="item-row">
									<td class="align-left table-label">Date of last SAF status:</td>
									<td class="align-left table-label"><?php echo $settlements['last_saf_date']; ?></td>
								</tr>
								<tr class="item-row">
									<td class="align-left table-label">Final settlements reached between SUNRISE and TO**:</td>
									<td class="align-left table-label"><?php echo $settlements['final_settlement']." ".$settlements['final_settlement_currency']; ?><br>
									    <?php echo $settlements['final_settlement_date']; ?>	
									    <?php if  ($role_id==47 || $role_id==54 || $user_id==1) :?>
									     <div class="data-head relative" style="margin-bottom:20px; ">
			                    		  <span class="expander-container non-printable"><i class='glyphicon glyphicon-pencil'></i></span>
			                    		    <div class="expander-wrapper">
			                      			  <span class="expander-remover"><i class='glyphicon glyphicon-remove'></i></span>
			                      			     <div class="expander">
			                        			    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-holder" style="margin-top: 10px;">
			                          				  <div class="row">
			                            				<form action="/settlements/edit_final_settlements/<?php echo $settlements['id']; ?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
			                              					<input type="text" name="final_settlement" class="form-control"  class="form-control" value="<?php echo $settlements['final_settlement']; ?>"/>
			                              					   <br>
			                              				    <select class="form-control" name="final_settlement_currency" >
                                                               <option value="<?php echo $settlements['final_settlement_currency']; ?>"><?php echo $settlements['final_settlement_currency']; ?></option>
                                                                       <option value="£">£</option> ‎
                                                                       <option value="$">$</option> 
                                                                       <option value="EURO">EURO</option>
                                                                       <option value="EGP">EGP</option>
                                                            </select> 
			                              					<br> 
			                              			      <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " 
			                              			      style="margin-top:5px;"> Date </label>
                                                       <div class='input-group date' id='datetimepicker11' style=" width: 240px; margin:10px;">
                                                         <input type="text" name="final_settlement_date" class="form-control"  value="<?php echo $settlements['final_settlement_date']; ?>" /> 
                                                         <span class="input-group-addon"><span class="glyphicon glyphicon-calender"></span></span>
                                                       </div>
			                              					<input name="submit" value="update" type="submit" class="inverse-offset btn btn-success" />
			                            				</form>
			                          				</div>
			                        			</div>
			                      			</div>
			                    		</div>
			                  		</div>
			                  	<?php endif ?>
									</td>
								</tr>
							</table>
							<br>
							<br>
							<br>
							<?php  if (!$purposes['set_id'] & ($sunrise )) :?> 
							<a class="form-actions btn btn-info non-printable" href="/settlements/submit_purposes/<?php echo $settlements['id'] ?>"
							    style="float:right;" > sunrise complete </a>
							<?php endif?>
							<?php if ($purposes['set_id']) :?>			
                        <?php if($role_id !=47) :?>
                        	<?php if($sunrise) :?>
							<a class="form-actions btn btn-info non-printable" href="/settlements/purposes_edit/<?php echo $settlements['id'] ?>"
							    style="float:right; margin-bottom: 5px;" > sunrise edit </a>
							  <?php endif ?>  	
							<table class="table table-striped table-bordered table-condensed">
								<tr class="item-row">
									<td class="align-left table-label">Claim Case Type:</td>
									<td class="align-left table-label"><?php echo $purposes['type']; ?><br>
										   <?php  foreach ($comment_claim_type as $comment) :?> 
										       <div><?php echo $comment['comment']?></div>
										    <?php endforeach ?>
										<?php if  ($role_id==42 || $role_id==54 || $user_id==1) :?>
										<div class="data-head relative" style="margin-bottom:20px; ">
			                    		  <span class="expander-container non-printable"><i class='glyphicon glyphicon-pencil'></i></span>
			                    		    <div class="expander-wrapper">
			                      			  <span class="expander-remover"><i class='glyphicon glyphicon-remove'></i></span>
			                      			     <div class="expander">
			                        			    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-holder" style="margin-top: 10px;">
			                          				  <div class="row">
			                            				<form action="/settlements/submit_inline_comment/<?php echo $settlements['id']; ?>/4" method="POST"             id="form-submit"  class="form-div span12" accept-charset="utf-8">
			                              					<textarea class="form-control" name="comment" id="comment"></textarea>
			                              					<input name="submit" value="comment" type="submit" class="inverse-offset btn btn-success" />
			                            				</form>
			                          				</div>
			                        			</div>
			                      			</div>
			                    		</div>
			                  		</div>
			                  	<?php endif ?>
									</td>
								</tr>
								<tr class="item-row">
									<td class="align-left table-label">Names and Titles of employees in charge of negligence (if relevant):</td>
									<td class="align-left table-label"><?php echo $purposes['charged']; ?></td>
								</tr>
								<tr class="item-row">
									<td class="align-left table-label">Penalty amount, £ (if relevant):</td>
									<td class="align-left table-label"><?php echo $purposes['penalty']." ".$purposes['penalty_currency']; ?></td>
								</tr>
								<tr class="item-row">
									<td class="align-left table-label">Actions to prevent such claims in the future:</td>
									<td class="align-left table-label"><?php echo $purposes['prevent_claim']; ?></td>
								</tr>
								<tr class="item-row">
									<td class="align-left table-label">Insurance Coverage:</td>
									<td class="align-left table-label"><?php echo $purposes['Insurance']; ?><br>
										 <?php  foreach ($comment_Insurance as $comment) :?> 
										       <div><?php echo $comment['comment']?></div>
										    <?php endforeach ?>
									<?php if  ($role_id==42 || $role_id==54 || $user_id==1) :?>
										<div class="data-head relative" style="margin-bottom:20px; ">
			                    		  <span class="expander-container non-printable"><i class='glyphicon glyphicon-pencil'></i></span>
			                    		    <div class="expander-wrapper">
			                      			  <span class="expander-remover"><i class='glyphicon glyphicon-remove'></i></span>
			                      			     <div class="expander">
			                        			    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-holder" style="margin-top: 10px;">
			                          				  <div class="row">
			                            				<form action="/settlements/submit_inline_comment/<?php echo $settlements['id']; ?>/5" method="POST"             id="form-submit"  class="form-div span12" accept-charset="utf-8">
			                              					<textarea class="form-control" name="comment" id="comment"></textarea>
			                              					<input name="submit" value="comment" type="submit" class="inverse-offset btn btn-success" />
			                            				</form>
			                          				</div>
			                        			</div>
			                      			</div>
			                    		</div>
			                  		</div>
			                  	<?php endif?>
									</td>
								</tr>
								<tr class="item-row">
									<td class="align-left table-label">SAF negotiation results, £ (if relevant):</td>
									<td class="align-left table-label"><?php echo $purposes['negotiation']." ".$purposes['negotiation_currency']; ?>
										 <?php  foreach ($comment_negotiation as $comment) :?> 
										       <div><?php echo $comment['comment']?></div>
										    <?php endforeach ?>
									<?php if  ($role_id==42 || $role_id==54 || $user_id==1) :?>
										<div class="data-head relative" style="margin-bottom:20px; ">
			                    		  <span class="expander-container non-printable"><i class='glyphicon glyphicon-pencil'></i></span>
			                    		    <div class="expander-wrapper">
			                      			  <span class="expander-remover"><i class='glyphicon glyphicon-remove'></i></span>
			                      			     <div class="expander">
			                        			    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-holder" style="margin-top: 10px;">
			                          				  <div class="row">
			                            				<form action="/settlements/submit_inline_comment/<?php echo $settlements['id']; ?>/7" method="POST"             id="form-submit"  class="form-div span12" accept-charset="utf-8">
			                              					<textarea class="form-control" name="comment" id="comment"></textarea>
			                              					<input name="submit" value="comment" type="submit" class="inverse-offset btn btn-success" />
			                            				</form>
			                          				</div>
			                        			</div>
			                      			</div>
			                    		</div>
			                  		</div>
			                  	<?php endif?>
									</td>
								</tr>
								<tr class="item-row">
									<td class="align-left table-label">Proposed settlements Rejected by:</td>
									<td class="align-left table-label"><?php echo $purposes['rejected_by']; ?></td>
								</tr>
								<tr class="item-row">
									<td class="align-left table-label">Reason of Rejection:</td>
									<td class="align-left table-label"><?php echo $purposes['reject_reason']; ?></td>
								</tr><tr class="item-row">
									<td class="align-left table-label">Suggestion for settlements, £:</td>
									<td class="align-left table-label"><?php echo $purposes['settlement_suggest']." ". $purposes['settlement_suggest_currency']; ?><br>
										 <?php  foreach ($comment_suggest as $comment) :?> 
										       <div><?php echo $comment['comment']?></div>
										    <?php endforeach ?>
										<?php if  ($role_id==42 || $role_id==54 || $user_id==1) :?>
										<div class="data-head relative" style="margin-bottom:20px; ">
			                    		  <span class="expander-container non-printable"><i class='glyphicon glyphicon-pencil'></i></span>
			                    		    <div class="expander-wrapper">
			                      			  <span class="expander-remover"><i class='glyphicon glyphicon-remove'></i></span>
			                      			     <div class="expander">
			                        			    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-holder" style="margin-top: 10px;">
			                          				  <div class="row">
			                            				<form action="/settlements/submit_inline_comment/<?php echo $settlements['id']; ?>/6" method="POST"             id="form-submit"  class="form-div span12" accept-charset="utf-8">
			                              					<textarea class="form-control" name="comment" id="comment"></textarea>
			                              					<input name="submit" value="comment" type="submit" class="inverse-offset btn btn-success" />
			                            				</form>
			                          				</div>
			                        			</div>
			                      			</div>
			                    		</div>
			                  		</div>
                                    <?php endif ?>
									</td>
								</tr>
							</table>
						<?php endif ?>
						<?php endif ?>		
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher data-indention">
	                      		<label for="offers" class="col-lg-3 col-md-4 col-sm-5 col-xs-5 control-label">Report Files</label>
								<div class="form-group col-lg-9 col-md-8 col-sm-7 col-xs-7">
	                       			<?php foreach($uploads as $upload): ?>
	                       				<a href='/assets/uploads/files/<?php echo $upload['name'] ?>'><?php echo $upload['name'] ?></a><br />
	                        		<?php endforeach ?>			
	                      		</div>	
                      		</div>	
                     		
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher data-indention">
								<div>
									<span class="data-head">Proposed settlements Agreed by:</span>
								</div>
							</div>
						
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher centered">
			                	<?php $queue_first = TRUE; ?>
			                	<?php foreach ($signers as $signe_id => $signer): ?>
			                	<div class="signature-wrapper">
			                  		<div class="data-head relative"><?php echo (strlen($signer['role']) == 0)? "settlements Owner" : $signer['role'] ?>
			                    		<span class="expander-container"><i class='glyphicon glyphicon-envelope'></i></span>
			                    		<div class="expander-wrapper">
			                      			<span class="expander-remover"><i class='glyphicon glyphicon-remove'></i></span>
			                      			<div class="expander">
			                        			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-holder">
			                          				<div class="row">
			                            				<form action="/settlements/<?php if($signer['role_id'] == "1"){ 
									                                echo "share_url";
									                              }else{
									                                echo "mail";
									                              } ?>/<?php echo $settlements['id']; ?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
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
			                    		<a href="/settlements/unsign/<?php echo $signe_id; ?>" class="non-printable btn btn-primary unsign">Cancel</a>
			                    		<?php endif ?>
			                  		</div>
			                  		<div class="data-content">
			                  			<span class="name-data-content"><?php echo $signer['sign']['name']; ?></span>
			                  			<br />
			                  			<span class="timestamp-data-content"><?php echo $signer['sign']['timestamp']; ?></span>
			                  		</div>
			                  		<?php elseif (array_key_exists($user_id, $signer['queue']) && $queue_first && $role_id !=142): ?>
			                  		<?php $queue_first = FALSE; ?>
			                  		<div class="data-content non-printable"><span class="data-label sign-data-content"></span><a href="/settlements/sign/<?php echo $signe_id; ?>/reject" class="non-printable btn btn-danger">Reject</a><a href="/settlements/sign/<?php echo $signe_id; ?>" class="non-printable btn btn-success">sign</a></div>
			                  		<?php else: ?>
			                  		<?php $queue_first = FALSE; ?>
			                  		<?php endif ?>
			                	</div>
			                    <?php if (isset($signer['sign']['reject'])){break;}?>
			                	<?php endforeach ?>

			              	</div>
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher non-printable">
                				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  					<form action="/settlements/comment/<?php echo $settlements['id']?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
                    					<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                     						<textarea class="form-control" name="comment" id="comment"></textarea>
                    					</div>
                    					<input name="set_id" value="<?php echo $settlements['id']?>" type="hidden" />
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
                			<div class="data-content">
    							<p class="centered">The settlements has been created by <?php echo $settlements['name'];?> at <?php echo $settlements['timestamp'];?></p>
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
        <script type="text/javascript">
           $(function () {
        $('#datetimepicker11').datetimepicker({
          format: 'DD/MM/YYYY'
        });
      });
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