<!DOCTYPE html>
<html lang="en">
	<head>
	<?php $this->load->view('header'); ?>
		<style type="text/css">
			@media print{
				.summary{
					width: 300px !important;
				}
				.real{
					width: 680px !important;
				}
				.hany{
					display: block !important;
				}
			}
			@page{
				margin:20px auto;
			}
		</style>
	</head>
	<body>
		<div id="wrapper">
			<?php $this->load->view('menu') ?>
			<div id="page-wrapper">
				<button onclick="window.print()" class="non-printable form-actions btn btn-success" href="" >Print</button>
    			<a class="form-actions btn btn-success non-printable" href="/fin_report" style="float:right;" > Back </a>
				<div class="container" style="margin-left: -20px !important; margin-right: 20px !important;">
					<div class="rest-selector col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<?php if(validation_errors() != false): ?>
			                <div class="alert alert-danger">
			                  	<?php echo validation_errors(); ?>
			                </div>
			            <?php endif ?>   
						<fieldset class="non-printable">
							<legend class="title-table">Out Going Delivery Report</legend>
							<?php $this->load->view('out_go_delivery_report_menu'); ?>
						</fieldset>
					</div>
					<?php if (isset($out_gos)): ?>	
						<div class="hany" style="float:right; margin-right: -35px !important; margin-left: 20px !important; display: none;">
							<?php if (isset($hotel) && $hotel): ?>	
								<div class="header-logo"><img src="/assets/uploads/logos/<?php echo $hotel['logo']; ?>"/></div>
								<h2 class="centered"><?php echo $hotel['name'];?></h2> 
							<?php endif; ?>
							<h3 class="centered">Out Going Delivery Report</h3>
							<?php if (isset($from_date) && $from_date): ?>	
								<h4 class="centered">From <?php echo $from_date;?> To <?php echo $to_date;?></h4>
							<?php endif; ?>
						</div>
						<br>
						<div style="float: left;">
							<table class="table table-striped table-bordered table-condensed">
								<tr>
									<td style="background-color: green; width: 100px">
										
									</td>
									<td  style="background-color: red; width: 100px">
										
									</td>
								</tr>
								<tr>
									<td>
										Delivered
									</td>
									<td>
										Not Delivered
									</td>
								</tr>
							</table>
						</div>
						<div class="centered">
							<table class="table table-striped table-bordered table-condensed" style="width:1200px; margin-left: -20px !important; margin-right: 40px !important;">
								<tbody>
									<tr>
										<th style="width: 100px;" class="centered">ID#</th>
										<th style="width: 300px;" class="centered">Hotel Name</th>
										<th style="width: 150px;" class="centered">Department</th>
										<th style="width: 150px;" class="centered">Description</th>
										<th style="width: 150px;" class="centered">Address</th>
										<th style="width: 100px;" class="centered">Quantity</th>
										<th style="width: 650px;" class="centered">Remarks</th>
										<th style="width: 300px;" class="centered">Date</th>
										<th style="width: 250px;" class="centered">Date of Return</th>
										<th style="width: 100px;" class="centered">Reason for Changing Date of Return</th>
										<th style="width: 250px;" class="centered">Date of Actual Return</th>
										<th style="width: 150px;" class="centered">Attachment</th>
									</tr>
								</tbody>
								<tbody>
									<?php $total1 =0; ?>
									<?php foreach ($out_gos as $out_go): ?>
										<tr>
											<td class="centered"><?php echo $out_go['id'] ?></td>
											<td class="centered"><?php echo $out_go['hotel_name'] ?></td>
											<td class="centered"><?php echo $out_go['department'] ?></td>
											<td class="centered">
												<?php foreach ($out_go['items'] as $item): ?>
													<hr>
													<div style="
														<?php if($item['delivered'] == 1){
															echo'background-color: green;';
														}else{
															echo'background-color: red;';
														} ?>"
													>
														<?php echo $item['description'] ?>
													</div>
													<br>
												<?php endforeach ?>
											</td>
											<td class="centered"><?php echo $out_go['address'] ?></td>
											<td class="centered">
												<?php foreach ($out_go['items'] as $item): ?>
													<?php $total1 = $total1 + $item['quantity']; ?>
													<hr>
													<div>
													<?php echo $item['quantity'] ?>
													</div>
													<br>
												<?php endforeach ?>
											</td>
											<td class="centered">
												<?php foreach ($out_go['items'] as $item): ?>
													<hr>
													<div>
														<?php echo $item['remarks'] ?>
													</div>
													<br>
												<?php endforeach ?>
											</td>
											<td class="centered"><?php echo $out_go['date'] ?></td>
											<td class="centered">
												<div>
													<?php echo $out_go['re_date'] ?>
												</div>
												<?php foreach ($out_go['dates'] as $row): ?>
													<div>
														<?php echo $row['date'] ?>
													</div>
												<?php endforeach ?>	
											</td>
											<td class="centered">
												<?php foreach ($out_go['dates'] as $row): ?>
													<div>
														<?php echo $row['reason'] ?>
													</div>
												<?php endforeach ?>	
											</td>
											<td class="centered">
												<?php foreach ($out_go['items'] as $item): ?>
													<hr>
													<div style="
														<?php if($item['delivered'] == 1){
															echo'background-color: green;';
														}else{
															echo'background-color: red;';
														} ?>"
													>
														<?php echo $item['del_date'] ?>
													</div>
													<br>
												<?php endforeach ?>
											</td>
											<td class="centered">
												<?php foreach ($out_go['items'] as $item): ?>
													<hr>
													<div>
														<img style="width: 50px; height: 50px;" src="/assets/uploads/files/<?php echo $item['fille']; ?>"/>
													</div>
												<br>
												<?php endforeach ?>
											</td>
										</tr>
									<?php endforeach ?>
								</tbody>
							</table>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</body>
</html>