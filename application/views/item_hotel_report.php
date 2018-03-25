<!DOCTYPE html>
<html lang="en">
	<head>
		<?php $this->load->view('header'); ?>
		<style type="text/css">
			@media print{
				.head{
					display: inline !important;
				}
			}
		</style>
	</head>
	<body>
		<div id="wrapper">
			<?php $this->load->view('menu') ?>
			<div id="page-wrapper">
				<button onclick="window.print()" class="non-printable form-actions btn btn-success" href="" >Print</button>
				<div class="container">
					<div class="rest-selector col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<fieldset class="non-printable">
							<legend class="title-table">Plan Department Hotel Report</legend>
							<?php $this->load->view('department_hotel_report_menu'); ?>
						</fieldset>
					</div>
					 
					<?php if (isset($app)): ?>	
						<div class="centered">
						<fieldset class="head" style="display: none;">
						<br>
						<br>
							<legend class="title-table" >Plan Department Report in Year <?php echo $year ?> for Department <?php echo $department['0']['name'] ?> for Hotel <?php echo $hotel['0']['name'] ?></legend>
						</fieldset>
							<table class="table table-striped table-bordered table-condensed" style="width:1000px;">
								<thead>
									<tr>
										<th style="width: 250px;" class="centered">Hotel Name</th>
										<th style="width: 100px;" class="centered">Plan no.</th>
										<th style="width: 200px;" class="centered">Department</th>
										<th style="width: 250px;" class="centered">Item</th>
										<th style="width: 100px;" class="centered">No. of Items</th>
										<th style="width: 100px;" class="centered">Value</th>
									</tr>
								</thead>
								<tbody>
										<?php $total1 =0; ?>
										<?php $total2 =0; ?>
										<?php foreach ($app as $plan): ?>
										<?php $total1 = $total1 + $plan['quantity']; ?>
										<?php $total2 = $total2 + ($plan['quantity']*$plan['value']); ?>
										<tr>
											<td class="centered"><?php echo $plan['hotel_name'] ?></td>
											<td class="centered"><?php echo $plan['plan_id'] ?></td>
											<td class="centered"><?php echo $plan['department'] ?></td>
											<td class="centered"><?php echo $plan['name'] ?></td>
											<td class="centered"><?php echo $plan['quantity'] ?></td>
											<td class="centered"><?php echo $plan['quantity']*$plan['value'] ?></td>
										</tr>
										<?php endforeach ?>
										<tr>
											<td class="centered" colspan="4">Total</td>
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
