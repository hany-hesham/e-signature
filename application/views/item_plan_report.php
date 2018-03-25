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
							<legend class="title-table">Plan itemes Report</legend>
							<?php $this->load->view('plan_report_menu'); ?>
						</fieldset>
					</div>
					<?php if (isset($app)): ?>	
						<div class="centered">
							<table class="table table-striped table-bordered table-condensed" style="width:1200px;">
								<thead>
									<tr>
										<th style="width: 300px;" class="centered">Hotel Name</th>
										<th style="width: 200px;" class="centered">Plan no.</th>
										<th style="width: 300px;" class="centered">Name</th>
										<th style="width: 200px;" class="centered">Quantity</th>
										<th style="width: 200px;" class="centered">Value</th>
									</tr>
								</thead>
								<tbody>
										<?php $total1 =0; ?>
										<?php $total2 =0; ?>
										<?php foreach ($app as $plan): ?>
										<?php $total1 = $total1 + $plan['quantity']; ?>
										<?php $total2 = $total2 + $plan['value']; ?>
										<tr>
											<td class="centered"><?php echo $plan['hotel_name'] ?></td>
											<td class="centered"><?php echo $plan['plan_id'] ?></td>
											<td class="centered"><?php echo $plan['name'] ?></td>
											<td class="centered"><?php echo $plan['quantity'] ?></td>
											<td class="centered"><?php echo $plan['value'] ?></td>
										</tr>
										
										<?php endforeach ?>
										<tr>
											<td class="centered" colspan="3"> Total</td>
											<td class="centered"><?php echo $total1 ?></td>
											<td class="centered"><?php echo $total2 ?></td>
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
