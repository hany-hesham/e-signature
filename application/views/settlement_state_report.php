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
    <a class="form-actions btn btn-success non-printable" href="/qlt_report" style="float:right;" > Back </a>
	<div class="container">

		<div class="rest-selector col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<fieldset>
			<legend class="title-table">Settlement Status</legend>
					<?php $this->load->view('settlement_state_report_menu'); ?>
			</fieldset>
		</div>
		<?php if (isset($forms)): ?>	
		<div class="centered">
			<?php if (isset($hotel)): ?>
				<div class="centered header-logo" ><img src="/assets/uploads/logos/<?php echo $hotel['logo']; ?>"/></div>
				<h1 class="centered"> <?php echo $hotel['name']; ?> </h1>
			<?php else: ?>
				<h1 class="centered"> All Hotels </h1>
			<?php endif; ?>
			<?php if (isset($state)): ?>
				<h3> Total of <?php echo $forms_count; ?> Settlement Forms with <?php echo $state; ?> Status</h3>
			<?php else: ?>
				<h3 class="centered"> Total of <?php echo $forms_count; ?> Settlement Forms </h3>
			<?php endif; ?>
			<h4> From <?php echo $from_date; ?> To <?php echo $to_date; ?> </h4>
			<br>
			<br>
			<table class="table table-striped table-bordered table-condensed" style="width:1200px;">
			<thead>
				<tr>
					<th style="width: 400px;" class="centered">Hotel Name</th>
					<th style="width: 300px;" class="centered">Form no.</th>
					<th style="width: 300px;" class="centered">Date</th>
					<th style="width: 250px;" class="centered">Close Case Amount</th>
					<th style="width: 250px;" class="centered">Waiting Approval Settlement</th>
					<th style="width: 250px;" class="centered">Status</th>
				</tr>
			</thead>
			<tbody>
				<?php $total1 =0; ?>
				<?php $total6 =0; ?>
					<?php foreach ($forms as $re): ?>
				<?php $total1 = $total1 + $re['amount']; ?>
				<?php $total6 = $total6 + $re['actual']; ?>
						<tr>
						<td class="centered"><?php echo $re['hotel_name'] ?></td>
						<td class="centered"><?php echo $re['id'] ?></td>
						<td class="centered"><?php echo $re['Date'] ?></td>
						<td class="centered"><?php echo $re['actual'] ?></td>
						<td class="centered"><?php echo $re['amount'] ?></td>
						<td class="centered"><?php echo $re['status'] ?></td>
					</tr>
					<?php endforeach ?>
					<tr>
						<td colspan="3">Tolat</td>
						<td><?php echo $total6?></td>
						<td><?php echo $total1?></td>
					</tr>
			</tbody>
			</table>			
	</div>
	</div>
		<?php endif; ?>
	</div>
</div>
</body>
</html>
