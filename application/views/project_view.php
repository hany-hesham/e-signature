<!DOCTYPE html>
<html lang="en">
	<head>
		<?php $this->load->view('header'); ?>
		<style type="text/css">
			.hany{
				-moz-box-shadow: 1px 2px 3px rgba(0,0,0,.5);
				-webkit-box-shadow: 1px 2px 3px rgba(0,0,0,.5);
				box-shadow: 0px -2px 2px rgba(34,34,34,0.6);
				border-radius: 5px;	
			}
		   	@media print {
			    @page { 
					margin: 0.5cm; 
				}
		    }
		</style>
	</head>
	<body>
	<div id="wrapper">
		<?php $this->load->view('menu') ?>
		<div id="page-wrapper">
       		<button onclick="window.print()" class="non-printable form-actions btn btn-success printer" href="" >Print</button><br /><br />
		<div class="a4wrapper">
			<div class="a4page">
				<div class="page-header">
	        		<h1 class="centered">Project #<?php echo $project_code; ?> ( <?php echo $project['origin_name']; ?> )  No. #<?php echo $project['id'];?></h1>
			        <?php if($project['new'] == 1): ?>
			        	<h3 class="centered">New Equipment</h3>
			        <?php endif ?>
			        <?php if($project['charge']): ?>
					    <h3 class="centered">Charge TO <?php echo $project['charge']?></h3>
					    <h3 class="centered">Life Time: <?php echo $project['life_year']?> Years & <?php echo $project['life_month']?> Months</h3>
			        <?php endif ?>
			        <?php if ($purchasing): ?>
			        	<a class="form-actions btn btn-info non-printable" href="/projects/purchasing/<?php echo $project['code'] ?>" >Purchasing Edit Project </a>
			        <?php endif ?>
			        <?php if($is_editor): ?>
			        	<a class="form-actions btn btn-info non-printable" href="/projects/edit/<?php echo $project['code'] ?>" >Edit Project </a>
			        <?php endif ?>
			        <?php if($is_change): ?>
			        	<a class="form-actions btn btn-info non-printable" href="/projects/change/<?php echo $project['code'] ?>" >Change Project </a>
			        <?php endif ?>
	    		</div>
				<table class="table table-striped table-bordered table-condensed">
					<tbody>
						<tr class="item-row" >
							<td class="align-right table-label" <?php if ($project['change_amend'] == 1):?> colspan="2" <?php endif; ?> style="text-align: left;">Hotel:</td><td  colspan= 2><?php echo $project['hotel_name']; ?></td>
						</tr>
						<tr class="item-row">
							<td class="align-right table-label"  <?php if ($project['change_amend'] == 1):?> colspan="2" <?php endif; ?> style="text-align: left;">Project Type:</td><td  colspan= 2><?php echo $project['type_name']; ?></td>
						</tr>
						<tr class="item-row">
							<td class="align-right table-label"  <?php if ($project['change_amend'] == 1):?> colspan="2" <?php endif; ?> style="text-align: left;">Department:</td><td  colspan= 2><?php echo $project['department_name']; ?></td>
						</tr>
						<?php if ($project['change_amend'] == 1):?>
						<tr class="item-row">
							<td class="align-right table-label" colspan="2" style="text-align: center;">Original:</td><td class="align-right table-label" colspan="2" style="color: blue; text-align: center;">Changed To:</td>
						</tr>
						<?php endif; ?>
						<tr class="item-row">
							<td class="align-right table-label" style="text-align: left;">Project Name:</td><td><?php echo $project['project_name']; ?></td>
							<?php if ($project['change_amend'] == 1):?>
								<td class="align-right table-label" style="text-align: left;">Project Name:</td><td><?php echo $project_change['project_name']; ?></td>
							<?php endif; ?>
						</tr>
						<tr class="item-row">
							<td class="align-right table-label" style="text-align: left;">Project Year:</td><td><?php echo $project['year']; ?></td>
							<?php if ($project['change_amend'] == 1):?>
								<td class="align-right table-label" style="text-align: left;">Project Year:</td><td><?php echo $project_change['year']; ?></td>
							<?php endif; ?>
						</tr>
						<tr class="item-row">
							<td class="align-right table-label" style="text-align: left;">Reasons:</td><td><?php echo $project['reasons']; ?></td>
							<?php if ($project['change_amend'] == 1):?>
								<td class="align-right table-label" style="text-align: left;">Reasons:</td><td><?php echo $project_change['reasons']; ?></td>
							<?php endif; ?>
						</tr>
						<tr class="item-row">
							<td class="align-right table-label" style="text-align: left;">Scope:</td><td><?php echo $project['scope']; ?></td>
							<?php if ($project['change_amend'] == 1):?>
								<td class="align-right table-label" style="text-align: left;">Scope:</td><td><?php echo $project_change['scope']; ?></td>
							<?php endif; ?>
						</tr>
						<tr class="item-row">
							<td class="align-right table-label" style="text-align: left;">Create Date:</td><td><?php echo $project['timestamp']; ?></td>
							<?php if ($project['change_amend'] == 1):?>
								<td class="align-right table-label" style="text-align: left;">Create Date:</td><td><?php echo $project_change['timestamp']; ?></td>
							<?php endif; ?>
						</tr>
						<tr class="item-row">
							<td class="align-right table-label" style="text-align: left;">Created By:</td><td><?php echo $project['user_name']; ?></td>
						</tr>
					</tbody>
				</table>
				<?php if ($project['origin_id'] == 2): ?>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher data-indention">
						<table class="table table-striped table-bordered table-condensed">
							<thead>
								<tr>
									<th>Item</th>
									<th>Quantity</th>
									<th>Total Value</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($items as $item): ?>
									<tr class="item-row">
										<td><?php echo $item['name'] ?></td>
										<td><?php echo $item['quantity'] ?></td>
										<td class="item-value" data-value="<?php echo $item['value']; ?>" class="align-right"><?php echo $item['quantity']*$item['value']; ?> EGP</td>
									</tr>
								<?php endforeach ?>
							</tbody>
						</table>
					</div>
				<?php endif ?>
				<?php if ($project['origin_id'] == 2 && $project['replaced']==1): ?>
					<p style="text-align: center;color: red; font-size: 16px;">Replaced With:</p>
						<table class="table table-striped table-bordered table-condensed">
							<thead>
								<tr>
									<th>Item</th>
									<th>Quantity</th>
									<th>Total Value</th>
									<th>Department</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($project_replace_items as $item): ?>
									<tr class="item-row">
										<td><?php echo $item['name'] ?></td>
										<td><?php echo $item['quantity'] ?></td>
										<td class="item-value" data-value="<?php echo $item['value']; ?>" class="align-right"><?php echo $item['value']; ?> EGP</td>
										<td><?php echo $item['department_name'] ?></td>
									</tr>
								<?php endforeach ?>
							</tbody>
						</table>
				<?php endif ?>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher data-indention">
					<div>
						<span class="data-head">Suppliers:</span>
						<table class="table table-striped table-bordered table-condensed">
							<tbody>
								<?php if ($project['change_amend'] == 1):?>
									<tr class="item-row">
										<td class="align-right table-label" colspan="2" style="text-align: center;">Original:</td>
									</tr>
								<?php endif; ?>
								<?php foreach ($suppliers as $supplier): ?>
									<tr class="item-row"><td><?php echo $supplier['name']; ?></td></tr>
								<?php endforeach ?>
								<?php if ($project['change_amend'] == 1):?>
									<tr class="item-row">
										<td class="align-right table-label" colspan="2" style="color: blue; text-align: center;">Changed To:</td>
									</tr>
									<?php foreach ($suppliers_change as $supplier): ?>
										<tr class="item-row"><td><?php echo $supplier['name']; ?></td></tr>
									<?php endforeach ?>
								<?php endif; ?>
							</tbody>
						</table>
					</div>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher data-indention">
					<div>
						<span class="data-head">Offers:</span>
						<table class="table table-striped table-bordered table-condensed">
							<tbody>
								<?php if ($project['change_amend'] == 1):?>
									<tr class="item-row">
										<td class="align-right table-label" colspan="2" style="text-align: center;">Original:</td>
									</tr>
								<?php endif; ?>
							    <?php foreach($offers as $offer): ?>
									<tr class="item-row"><td><a href='/assets/uploads/files/<?php echo $offer['name'] ?>'><?php echo $offer['name'] ?></a></td></tr>
								<?php endforeach; ?>
								<?php if ($project['change_amend'] == 1):?>
									<tr class="item-row">
										<td class="align-right table-label" colspan="2" style="color: blue; text-align: center;">Changed To:</td>
									</tr>
									<?php foreach($offers_change as $offer): ?>
										<tr class="item-row"><td><a href='/assets/uploads/files/<?php echo $offer['name'] ?>'><?php echo $offer['name'] ?></a></td></tr>
									<?php endforeach; ?>
								<?php endif; ?>
							</tbody>
						</table>
					</div>
				</div>
				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher"></div>
				<table class="table table-striped table-bordered table-condensed">
					<tbody>
						<?php if ($project['change_amend'] == 1):?>
							<tr class="item-row">
								<td class="align-right table-label" colspan="7" style="text-align: center;">Original:</td>
							</tr>
						<?php endif; ?>
						<tr class="item-row">
							<td id="hidden-cell"></td>
							<td class="align-right table-label">Exchange Rate</td>
							<td class="align-right table-label-small">USD:</td>
							<td><?php echo $project['USD_EX']; ?></td>
							<td class="align-right table-label-small">EUR:</td>
							<td><?php echo $project['EUR_EX']; ?></td>
						</tr>
						<tr>
							<td class="align-right table-label">Budget Cost</td>
							<td colspan="7"><?php echo number_format($project['budget'],2,".",","); ?>&nbsp;&nbsp;&nbsp;LE</td>
						</tr>
						<tr class="item-row">
							<td id="hidden-cell"></td>
							<td class="align-right table-label-small">EGP:</td>
							<td><?php echo number_format($project['budget_EGP'],2,".",","); ?></td>
							<td class="align-right table-label-small">USD:</td>
							<td><?php echo number_format($project['budget_USD'],2,".",","); ?></td>
							<td class="align-right table-label-small">EUR:</td>
							<td><?php echo number_format($project['budget_EUR'],2,".",","); ?></td>
						</tr>
						<tr>
							<td class="align-right table-label">Final Cost</td>
							<td colspan="7"><?php echo number_format($project['cost'],2,".",","); ?>&nbsp;&nbsp;&nbsp;LE</td>
						</tr>
						<tr class="item-row">
							<td id="hidden-cell"></td>
							<td class="align-right table-label-small">EGP:</td>
							<td><?php echo number_format($project['cost_EGP'],2,".",","); ?></td>
							<td class="align-right table-label-small">USD:</td>
							<td><?php echo number_format($project['cost_USD'],2,".",","); ?></td>
							<td class="align-right table-label-small">EUR:</td>
							<td><?php echo number_format($project['cost_EUR'],2,".",","); ?></td>
						</tr>
					</tbody>
				</table>
				<?php if ($project['change_amend'] == 1):?>
					<table class="table table-striped table-bordered table-condensed">
						<tbody>
							<tr class="item-row">
								<td class="align-right table-label" colspan="7" style="color: blue; text-align: center;">Changed To:</td>
							</tr>
							<tr class="item-row">
								<td id="hidden-cell"></td>
								<td class="align-right table-label">Exchange Rate</td>
								<td class="align-right table-label-small">USD:</td>
								<td><?php echo $project_change['USD_EX']; ?></td>
								<td class="align-right table-label-small">EUR:</td>
								<td><?php echo $project_change['EUR_EX']; ?></td>
							</tr>
							<tr>
								<td class="align-right table-label">Budget Cost</td>
								<td colspan="7"><?php echo number_format($project_change['budget'],2,".",","); ?>&nbsp;&nbsp;&nbsp;LE</td>
							</tr>
							<tr class="item-row">
								<td id="hidden-cell"></td>
								<td class="align-right table-label-small">EGP:</td>
								<td><?php echo number_format($project_change['budget_EGP'],2,".",","); ?></td>
								<td class="align-right table-label-small">USD:</td>
								<td><?php echo number_format($project_change['budget_USD'],2,".",","); ?></td>
								<td class="align-right table-label-small">EUR:</td>
								<td><?php echo number_format($project_change['budget_EUR'],2,".",","); ?></td>
							</tr>
							<tr>
								<td class="align-right table-label">Final Cost</td>
								<td colspan="7"><?php echo number_format($project_change['cost'],2,".",","); ?>&nbsp;&nbsp;&nbsp;LE</td>
							</tr>
							<tr class="item-row">
								<td id="hidden-cell"></td>
								<td class="align-right table-label-small">EGP:</td>
								<td><?php echo number_format($project_change['cost_EGP'],2,".",","); ?></td>
								<td class="align-right table-label-small">USD:</td>
								<td><?php echo number_format($project_change['cost_USD'],2,".",","); ?></td>
								<td class="align-right table-label-small">EUR:</td>
								<td><?php echo number_format($project_change['cost_EUR'],2,".",","); ?></td>
							</tr>
						</tbody>
					</table>
				<?php endif;?>
				<br />
				<br />
				<br />
				<table class="table table-striped table-bordered table-condensed">
					<tbody>
						<tr>
							<td colspan="4">Time Schedule:</td>
						</tr>
						<?php if ($project['change_amend'] == 1):?>
							<tr class="item-row">
								<td class="align-right table-label" colspan="7" style="text-align: center;">Original:</td>
							</tr>
						<?php endif; ?>
						<tr class="item-row">
							<td>Start</td>
							<td><?php echo $project['start'] ?></td>
							<td>End</td>
							<td><?php echo $project['end'] ?></td>
						</tr>
						<?php if ($project['change_amend'] == 1):?>
							<tr class="item-row">
								<td class="align-right table-label" colspan="7" style="color: blue; text-align: center;">Changed To:</td>
							</tr>
							<tr class="item-row">
								<td>Start</td>
								<td><?php echo $project_change['start'] ?></td>
								<td>End</td>
								<td><?php echo $project_change['end'] ?></td>
							</tr>
						<?php endif; ?>
					</tbody>
				</table>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher data-indention">
					<table class="table table-striped table-bordered table-condensed">
						<tbody>
							<?php if ($project['change_amend'] == 1):?>
								<tr class="item-row">
									<td class="align-right table-label" colspan="7" style="text-align: center;">Original:</td>
								</tr>
							<?php endif; ?>
							<tr class="item-row">
								<td>Remarks:</td><td><?php echo $project['remarks']; ?></td>
							</tr>
							<?php if ($project['change_amend'] == 1):?>
								<tr class="item-row">
									<td class="align-right table-label" colspan="7" style="color: blue; text-align: center;">Changed To:</td>
								</tr>
								<tr class="item-row">
									<td>Remarks:</td><td><?php echo $project_change['remarks']; ?></td>
								</tr>
							<?php endif; ?>
						</tbody>
					</table>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher">
					<?php if ($project['change_amend'] == 1):?>
					<table class="table table-striped table-bordered table-condensed">
							<tbody>
								<tr class="item-row">
									<td class="align-right table-label" colspan="7" style="text-align: center;">Original:</td>
								</tr>
							</tbody>
						</table>
						<br>
					<?php endif; ?>
					<?php $sign_enabled = TRUE; ?>
					<?php foreach ($signers as $signe_id => $signer): ?>
						<div class="signature-wrapper">
							<div class="data-head relative">
								<?php echo (strlen($signer['role']) == 0)? "Project Owner" : $signer['role'] ?>
								<span class="expander-container"><i class='glyphicon glyphicon-envelope'></i></span>
								<div class="expander-wrapper">
									<span class="expander-remover"><i class='glyphicon glyphicon-remove'></i></span>
									<div class="expander">
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-holder">
											<div class="row">
												<form action="/projects/<?php if($signer['role_id'] == "1"){ 
													echo "share_url";
												}else{
													echo "mailto";
												} ?>/<?php echo $project['code']; ?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
													<?php if (isset($signer['sign'])): ?>
														<?php $i=1; ?>
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
														<input name="submit" value="Send" type="submit" class="inverse-offset btn btn-success" />
													<?php endif; ?>
												</form>
											</div>
										</div>
									</div>
								</div>
							</div>
							<?php if (isset($signer['sign'])): ?>
								<div class="data-content">
									<img src="
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
										<a href="/projects/unsign/<?php echo $signe_id; ?>" class="btn btn-primary unsign non-printable">Cancel</a>
									<?php endif ?>
								</div>
								<div class="data-content"><span class="name-data-content"><?php echo $signer['sign']['name']; ?></span>
								<br /><span class="timestamp-data-content"><?php echo $signer['sign']['timestamp']; ?></span></div>
							<?php elseif (array_key_exists($user_id, $signer['queue']) && $project['state_id'] != 11 && $sign_enabled && $project['change_amend'] != 1 && $role_id !=142): ?>
								    <?php if ($role_id == 1 && $chairman_after==0 ):?>
										<div class="data-content non-printable" id="tab2"><span class="data-label sign-data-content"></span><a href="/projects/sign/<?php echo $signe_id; ?>/reject" class="btn btn-danger non-printable">Reject</a> 
									<?php elseif ($role_id != 1): ?>
										<div class="data-content non-printable" id="tab2"><span class="data-label sign-data-content"></span><a href="/projects/sign/<?php echo $signe_id; ?>/reject" class="btn btn-danger non-printable">Reject</a> 
										
									<?php endif ?>	
								<?php if ($role_id != 4):?>
									<?php if ($role_id == 1 && $chairman_after==0 ):?>
										<a href="/projects/sign/<?php echo $signe_id; ?>" class="btn btn-success non-printable">sign</a>
										<?php elseif ($role_id != 1): ?>
										<a href="/projects/sign/<?php echo $signe_id; ?>" class="btn btn-success non-printable">sign</a>
									<?php endif ?>	
								<?php elseif ($role_id == 4 && !is_numeric($project['charge'])):?>	
									<a href="/projects/sign/<?php echo $signe_id; ?>" class="btn btn-success non-printable">sign</a>
								<?php endif;?></div>
							<?php else: ?>
								<?php $sign_enabled = FALSE; ?>
							<?php endif ?>
						</div>
					<?php endforeach ?>
					<?php if ($project['change_amend'] == 1):?>
						<table class="table table-striped table-bordered table-condensed">
							<tbody>
								<tr class="item-row">
									<td class="align-right table-label" colspan="7" style="color: blue; text-align: center;">Changed To:</td>
								</tr>
							</tbody>
						</table>
						<br>
						<?php $sign_enabled1 = TRUE; ?>
						<?php foreach ($signers_change as $signe_id => $signer): ?>
							<div class="signature-wrapper">
								<div class="data-head relative">
									<?php echo (strlen($signer['role']) == 0)? "Project Owner" : $signer['role'] ?>
									<span class="expander-container"><i class='glyphicon glyphicon-envelope'></i></span>
									<div class="expander-wrapper">
										<span class="expander-remover"><i class='glyphicon glyphicon-remove'></i></span>
										<div class="expander">
											<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-holder">
												<div class="row">
													<form action="/projects/<?php if($signer['role_id'] == "1"){ 
														echo "share_url";
													}else{
														echo "mailto";
													} ?>/<?php echo $project['code']; ?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
														<?php if (isset($signer['sign'])): ?>
															<?php $i=1; ?>
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
															<input name="submit" value="Send" type="submit" class="inverse-offset btn btn-success" />
														<?php endif; ?>
													</form>
												</div>
											</div>
										</div>
									</div>
								</div>
								<?php if (isset($signer['sign'])): ?>
									<div class="data-content">
										<img src="
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
											<a href="/projects/unsign/<?php echo $signe_id; ?>" class="btn btn-primary unsign non-printable">Cancel</a>
										<?php endif ?>
									</div>
									<div class="data-content"><span class="name-data-content"><?php echo $signer['sign']['name']; ?></span>
									<br /><span class="timestamp-data-content"><?php echo $signer['sign']['timestamp']; ?></span></div>
								<?php elseif (array_key_exists($user_id, $signer['queue']) && $project['state_id'] != 11 && $sign_enabled1): ?>
									<div class="data-content non-printable" id="tab2"><span class="data-label sign-data-content"></span><a href="/projects/sign/<?php echo $signe_id; ?>/reject" class="btn btn-danger non-printable">Reject</a> 
										<a href="/projects/sign/<?php echo $signe_id; ?>" class="btn btn-success non-printable">sign</a></div>
								<?php else: ?>
									<?php $sign_enabled1 = FALSE; ?>
								<?php endif ?>
							</div>
						<?php endforeach ?>
					<?php endif; ?>
					<br>
					<?php if ($owning_company || $is_admin) { ?>
						<a href="#" class="btn btn-success non-printable hanyclose hany-fram-start" style="margin-left: 200px;">Chairman Office</a>
					<?php } ?>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher hanyfram" style="display: none;">
						<a href="#" class="btn btn-success non-printable hany-fram-remover hanyclose">Hide</a>
				         	<iframe src="/project_owning/review/<?php echo $project['id']; ?>/2" scrolling="no" style="margin-left:-30px; width: 850px; height: 900px; border: none;"></iframe>
				       </div>
					<?php if($project['hotel_id'] == 5 || $project['hotel_id'] == 42){ ?>
						<?php if ($owning_company || $is_admin) { ?>
							<a href="#" class="btn btn-success non-printable hanyclose1 hany-fram1-start" style=" margin-left: 50px;">Owning company</a>
						<?php } ?>
					<?php } ?>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher hanyfram1" style="display: none;">
						<a href="#" class="btn btn-success non-printable hany-fram-remover1 hanyclose1">Hide</a>
				          <iframe src="/project_owning/review_other/<?php echo $project['id']; ?>/2" scrolling="no" style="margin-left:-30px; width: 850px; height:450px; border: none;"></iframe>
				     </div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher non-printable">
						<div class="row">
							<form action="/projects/comment/<?php echo $project['id']; ?>/<?php echo $project['code']; ?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
								<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
									<textarea class="form-control" name="comment" id="comment"></textarea>
								</div>
								<input name="submit" value="Comment" type="submit" class="inverse-offset btn btn-success" />
							</form>
						</div>
					</div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-holder">
						<div class="row">
							<div class="data-head centered">General Comments </div>
							<div class="data-holder">
								<?php foreach ($comments as $comment): ?>
									<div class="data-holder">
					                   	<span class="data-head"><?php echo $comment['fullname']; ?> :- </span><?php echo $comment['comment']; ?>
					                   	<span class="timestamp-data-content"><?php echo $comment['created'];?></span>
					                </div>
								<?php endforeach; ?>
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
			$('.closeLink').click( function(e) {
			     e.preventDefault();
			});
			$(".charge-container").on("click", function(){
				$(".charge-wrapper").show();
				$(this).parent().find(".charge-wrapper").toggle("fast");
			});
			$(".charge-remover").on("click", function(){
				$(".charge-wrapper").hide();
				$(this).parent().hide("fast");
				document.location.reload(true);			
			});
		</script>
		<script type="text/javascript">
			$('.hanyclose').click( function(e) {
			     e.preventDefault();
			});
			$(".hany-fram-start").on("click", function(){
				$(".hanyfram").show();
				$(".hany-fram-start").hide();
				$(this).parent().find(".hany-fram").toggle("fast");
			});
			$(".hany-fram-remover").on("click", function(){
				$(".hanyfram").hide();
				$(".hany-fram-start").show();
				$(this).parent().hide("fast");
				document.location.reload(true);			
			});
		</script>
		<script type="text/javascript">
			$('.hanyclose1').click( function(e) {
			     e.preventDefault();
			});
			$(".hany-fram1-start").on("click", function(){
				$(".hanyfram1").show();
				$(".hany-fram1-start").hide();
				$(this).parent().find(".hany-fram").toggle("fast");
			});
			$(".hany-fram-remover1").on("click", function(){
				$(".hanyfram1").hide();
				$(".hany-fram1-start").show();
				$(this).parent().hide("fast");
				document.location.reload(true);			
			});
		</script>
	</body>
</html>