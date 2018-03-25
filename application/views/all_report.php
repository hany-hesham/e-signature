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
	<div class="container">

		<div class="rest-selector col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<fieldset>
			<legend class="title-table">Plan List all hotels summary</legend>
			<?php $this->load->view('year_form_multi'); ?>
			</fieldset>
		</div>
		
		</div>
		<?php if (isset($posting)): ?>
			<div class="title-table"></div>
			<table class="report-view-large" style="width:1000px;">
			<thead>
				<tr>
					<th></th>
					<?php foreach ($totals as $total): ?>
						<th colspan="4" class="align-center"><?php echo $total['year'] ?></th>
					<?php endforeach ?>

				</tr>
				<tr>
					<th style="width: 300px;"></th>
					<?php foreach ($totals as $total): ?>
						<th style="width: 100px;">Total</th>
						<th style="width: 200px;">Approved</th>
						<th style="width: 200px;">Done</th>
						<th style="width: 200px;">In Progress</th>
					<?php endforeach ?>

				</tr>
			</thead>
			<tbody>
			<?php foreach ($hotels as $hotel): ?>
					
				<tr>
					<td><?php echo $hotel['name'] ?></td>
					<?php foreach ($totals as $hKey => $total): ?>
						<td class="align-right <?php echo ($hotel[$total['year']] == 1 || $total[$hotel['code']] == 0)? "progress" : "" ?>"><?php echo number_format(($total[$hotel['code']]+$MJ[$hKey][$hotel['code']]),0,".",","); ?></td>
					<?php endforeach ?>
					<td></td>
					<td></td>
					<td></td>
				</tr>
			<?php endforeach; ?>
				<tr class="blue">
					<td>Total</td>
					<?php foreach ($totals as $tKey => $total): ?>
						<td class="align-right"><?php echo number_format(($total['total']+$MJ[$tKey]['total']),0,".",","); ?></td>
					<?php endforeach ?>
					<td></td>
					<td></td>
					<td></td>
				</tr>
			</tbody>
			</table>

		<?php endif; ?>

	</div>
</div>
</body>
</html>
