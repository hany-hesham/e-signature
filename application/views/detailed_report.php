<!DOCTYPE html>
<html lang="en">
<head>
<?php $this->load->view('header'); ?>
<style type="text/css">
	@media print{@page {size: landscape}}
	@media print{.noprint{display: none;}}
</style>
</head>
<body>
<div id="wrapper">
	<?php $this->load->view('menu') ?>
	<div id="page-wrapper">
	<div class="container">

		<div class="rest-selector col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<fieldset>
			<legend class="title-table">Plan List <?php echo isset($selected_year)? $selected_year : ""; ?> all hotels details, by department</legend>
			<?php $this->load->view('year_form'); ?>
			</fieldset>
		</div>
		
		</div>
		<?php if (isset($posting)): ?>
			<div class="title-table right w600"><?php echo isset($selected_year)? "Total ".$selected_year." all hotels &nbsp;&nbsp;&nbsp; <span class='red'>".number_format($total,0,".",",")."</span>" : ""; ?><br />
			<?php echo isset($selected_year)? "Total Plan List ".$selected_year." all hotels &nbsp;&nbsp;&nbsp; <span class='red'>".number_format($plan,0,".",",")."</span>" : ""; ?><br />
			<?php echo isset($selected_year)? "Total Major Projects ".$selected_year." all hotels &nbsp;&nbsp;&nbsp; <span class='red'>".number_format($devisions[7]['total'],0,".",",")."</span>" : ""; ?></div>
			<table class="report-view">
			<thead>
				<tr>
					<th></th>
					<?php foreach ($hotels as $hotel): ?>
						<th colspan="2"><?php echo $hotel['code'] ?></th>
					<?php endforeach ?>
					<th class="blue" colspan="2">Total</th>

				</tr>
			</thead>
			<tbody>
			<?php foreach ($devisions as $devision): ?>
				<?php if (sizeof($devision['departments']) > 0): ?>
					
				<tr class="bolder">
					<td><?php echo $devision['name'] ?></td>
					<?php foreach ($hotels as $hotel):?>
						<td class="align-right"><?php echo number_format($devision[$hotel['id']],0,".",","); ?></td>
						<?php $percentage = ($devision[$hotel['id']]/$hotel['total'])*100; ?>
						<td class="align-right"><?php echo round($percentage,3); ?> %</td>
					<?php endforeach ?>
					<td class="blue align-right"><?php echo number_format($devision['total'],0,".",","); ?></td>
					<?php $total_percentage = ($devision['total']/$total)*100; ?>
					<td class="align-right"><?php echo round($total_percentage,3); ?> %</td>
						<?php //die(print_r($total));?>
				</tr>
					<?php foreach ($devision['departments'] as $department): ?>
						<tr>
							<td><?php echo $department['name'] ?></td>
							<?php foreach ($hotels as $hotel): ?>
								<td class="align-right"><?php echo number_format($department[$hotel['id']],0,".",","); ?></td>
								<?php $percentage = ($department[$hotel['id']]/$hotel['total'])*100; ?>
								<td class="align-right"><?php echo round($percentage,3); ?> %</td>
							<?php endforeach ?>
							<td class="blue align-right"><?php echo number_format($department['total'],0,".",","); ?></td>
							<?php $total_percentage = ($department['total']/$total)*100; ?>
							<td class="align-right"><?php echo round($total_percentage,3); ?> %</td>
						</tr>
						<?php //die(print_r($total));?>
					<?php endforeach ?>
						<?php //die();?>
				<?php endif ?>
						<?php //die();?>
			<?php endforeach; ?>
			
			<tr class="blue">
				<td>Total Plan List</td>
				<?php foreach ($hotels as $hotel): ?>
					<td class="align-right"><?php echo number_format($hotel['plan'],0,".",","); ?></td>
					<?php $total_percentage = ($hotel['plan']/$plan)*100; ?>
					<td class="align-right"><?php echo round($total_percentage,3); ?> %</td>
				<?php endforeach ?>
				<td class="blue align-right"><?php echo number_format($plan,0,".",",");; ?></td>
				<?php $total_percentage = ($plan/$total)*100; ?>
				<td class="align-right"><?php echo round($total_percentage,3); ?> %</td>
			</tr>

			<tr class="blue">
				<td>Total</td>
				<?php foreach ($hotels as $hotel): ?>
					<td class="align-right"><?php echo number_format($hotel['total'],0,".",","); ?></td>
					<?php $total_percentage = ($hotel['total']/$total)*100; ?>
					<td class="align-right"><?php echo round($total_percentage,3); ?> %</td>
				<?php endforeach ?>
				<td class="blue align-right" colspan="2"><?php echo number_format($total,0,".",",");; ?></td>
			</tr>
			<tr>
				<td>Status</td>
				<?php foreach ($hotels as $hotel): ?>
					<td colspan="2" class="smallfont <?php echo ($hotel['state'] == 1)? "progress" : "approved" ?>"><?php echo ($hotel['state'] == 1)? "Not Approved" : "Approved" ?></td>
				<?php endforeach ?>
			</tr>
			</tbody>
			</table>

		<?php endif; ?>

	</div>
</div>

</body>
</html>
