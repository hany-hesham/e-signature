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
							<legend class="title-table">Out Going Changed Return Date Report</legend>
							<?php $this->load->view('out_go_delivery_change_date_menu'); ?>
						</fieldset>
					</div>
					<?php if (isset($out_gos)): ?>	
						<div class="hany" style="float:right; margin-right: -35px !important; margin-left: 20px !important; display: none;">
							<?php if (isset($hotel) && $hotel): ?>	
								<div class="header-logo"><img src="/assets/uploads/logos/<?php echo $hotel['logo']; ?>"/></div>
								<h2 class="centered"><?php echo $hotel['name'];?></h2> 
							<?php endif; ?>
							<h3 class="centered">Out Going Changed Return Date Report</h3>
							<?php if (isset($from_date) && $from_date): ?>	
								<h4 class="centered">From <?php echo $from_date;?> To <?php echo $to_date;?></h4>
							<?php endif; ?>
						</div>
						<br>
						<div class="centered">
							<table class="table table-striped table-bordered table-condensed" style="width:1200px; margin-left: -20px !important; margin-right: 40px !important;">
								<tbody>
									<tr>
										<th style="width: 100px;" class="centered">ID#</th>
										<th style="width: 300px;" class="centered">Hotel Name</th>
										<th style="width: 150px;" class="centered">Department</th>
										<th style="width: 300px;" class="centered">Date</th>
										<th style="width: 250px;" class="centered">Date of Return</th>
										<th style="width: 250px;" class="centered">Changed Return Date</th>
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
												<?php foreach ($out_go['dates'] as $row): ?>
													<hr>
													<div>
														<?php echo $row['date'] ?>
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