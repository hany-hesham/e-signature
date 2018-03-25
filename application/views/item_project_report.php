<!DOCTYPE html>
<html lang="en">
	<head>
		<?php $this->load->view('header'); ?>
		<style type="text/css">
			@media print{.noprint{display: none;}}
		</style>
	</head>
	<body>
		<div id="wrapper">
			<?php $this->load->view('menu') ?>
			<div id="page-wrapper">
				<button onclick="window.print()" class="non-printable form-actions btn btn-success" href="" >Print</button>
				<div class="container">
					<div class="rest-selector col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<fieldset>
							<legend class="title-table">Project Items Report</legend>
							<?php if(validation_errors() != false): ?>
				              <div class="alert alert-danger">
				                <?php echo validation_errors(); ?>
				              </div>
				              <?php endif ?>
							<?php $this->load->view('project_report_menu'); ?>
						</fieldset>
					</div>
					<?php if (isset($app)): ?>	
						<div class="centered">
							<table class="table table-striped table-bordered table-condensed centered" style="width:1200px;">
								<thead>
									<tr>
										<th style="width: 240px;" colspan="1" rowspan="2" class="centered">Hotel Name</th>
										<th style="width: 80px;" colspan="1" rowspan="2" class="centered">Project no.</th>
										<th style="width: 240px;" colspan="1" rowspan="2" class="centered">Name</th>
										<th style="width: 240;" colspan="3" rowspan="1" class="centered">Budget</th>
										<th style="width: 80px;" colspan="1" rowspan="2" class="centered">Total Budget</th>
										<th style="width: 240;" colspan="3" rowspan="1" class="centered">Cost</th>
										<th style="width: 80px;" colspan="1" rowspan="2" class="centered">Final Cost</th>
									</tr>
									<tr>
										<th style="width: 80px;" colspan="1" rowspan="1" class="centered">EGP</th>
										<th style="width: 80px;" colspan="1" rowspan="1" class="centered">USD</th>
										<th style="width: 80px;" colspan="1" rowspan="1" class="centered">EUR</th>
										<th style="width: 80px;" colspan="1" rowspan="1" class="centered">EGP</th>
										<th style="width: 80px;" colspan="1" rowspan="1" class="centered">USD</th>
										<th style="width: 80px;" colspan="1" rowspan="1" class="centered">EUR</th>
									</tr>
								</thead>
								<tbody>
										<?php $total1 =0; ?>
										<?php $total2 =0; ?>
										<?php $total3 =0; ?>
										<?php $total4 =0; ?>
										<?php $total5 =0; ?>
										<?php $total6 =0; ?>
										<?php $total7 =0; ?>
										<?php $total8 =0; ?>
										<?php foreach ($app as $project): ?>
										<?php $total1 = $total1 + $project['budget_EGP']; ?>
										<?php $total2 = $total2 + $project['budget_USD']; ?>
										<?php $total3 = $total3 + $project['budget_EUR']; ?>
										<?php $total4 = $total4 + $project['budget']; ?>
										<?php $total5 = $total5 + $project['cost_EGP']; ?>
										<?php $total6 = $total6 + $project['cost_USD']; ?>
										<?php $total7 = $total7 + $project['cost_EUR']; ?>
										<?php $total8 = $total8 + $project['cost']; ?>
										<tr>
											<td class="centered"><?php echo $project['hotel_name'] ?></td>
											<td class="centered"><?php echo $project['code'] ?></td>
											<td class="centered"><?php echo $project['name'] ?></td>
											<td class="centered"><?php echo $project['budget_EGP'] ?></td>
											<td class="centered"><?php echo $project['budget_USD'] ?></td>
											<td class="centered"><?php echo $project['budget_EUR'] ?></td>
											<td class="centered"><?php echo $project['budget'] ?></td>
											<td class="centered"><?php echo $project['cost_EGP'] ?></td>
											<td class="centered"><?php echo $project['cost_USD'] ?></td>
											<td class="centered"><?php echo $project['cost_EUR'] ?></td>
											<td class="centered"><?php echo $project['cost'] ?></td>
										</tr>
										
										<?php endforeach ?>
										<tr>
											<td class="centered" colspan="3"> Total</td>
											<td class="centered"><?php echo $total1 ?></td>
											<td class="centered"><?php echo $total2 ?></td>
											<td class="centered"><?php echo $total3 ?></td>
											<td class="centered"><?php echo $total4 ?></td>
											<td class="centered"><?php echo $total5 ?></td>
											<td class="centered"><?php echo $total6 ?></td>
											<td class="centered"><?php echo $total7 ?></td>
											<td class="centered"><?php echo $total8 ?></td>
										</tr>
								</tbody>
							</table>			
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</body>
</html>
