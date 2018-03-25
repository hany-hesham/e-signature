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
			<legend class="title-table">Settlement summary</legend>
					<?php $this->load->view('settlement_report_menu_hotel'); ?>
			</fieldset>
		</div>
		<?php if (isset($state)): ?>	
		<div class="centered">
			<?php if ($state == 1) {	 ?>
			<h3> Total of <?php echo $wait_count; ?> Settlement Forms Waiting approval</h3>
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
				</tr>
			</thead>
			<tbody>
				<?php $total1 =0; ?>
				<?php $total6 =0; ?>
					<?php foreach ($wait as $re): ?>
				<?php $total1 = $total1 + $re['amount']; ?>
				<?php $total6 = $total6 + $re['actual']; ?>
						<tr>
						<td class="centered"><?php echo $re['hotel_name'] ?></td>
						<td class="centered"><?php echo $re['id'] ?></td>
						<td class="centered"><?php echo $re['Date'] ?></td>
						<td class="centered"><?php echo $re['actual'] ?></td>
						<td class="centered"><?php echo $re['amount'] ?></td>
					</tr>
					<?php endforeach ?>
					<tr>
						<td colspan="3">Tolat</td>
						<td><?php echo $total6?></td>
						<td><?php echo $total1?></td>
					</tr>
			</tbody>
			</table>
			<?php 	}elseif ($state == 2) { ?>
			<h3> Total of <?php echo $app_count; ?> Settlement Forms Approved</h3>
			<br>
			<br>
			<table class="table table-striped table-bordered table-condensed" style="width:1200px;">
			<thead>
				<tr>
					<th style="width: 400px;" class="centered">Hotel Name</th>
					<th style="width: 300px;" class="centered">Form no.</th>
					<th style="width: 300px;" class="centered">Date</th>
					<th style="width: 250px;" class="centered">Close Case Amount</th>
					<th style="width: 250px;" class="centered">Approved Settlement</th>
				</tr>
			</thead>
			<tbody>
					<?php $total2 =0; ?>
					<?php $total7 =0; ?>
					<?php foreach ($app as $re): ?>
					<?php $total2 = $total2 + $re['amount']; ?>
					<?php $total7 = $total7 + $re['actual']; ?>

					<tr>
						<td class="centered"><?php echo $re['hotel_name'] ?></td>
						<td class="centered"><?php echo $re['id'] ?></td>
						<td class="centered"><?php echo $re['Date'] ?></td>
						<td class="centered"><?php echo $re['actual'] ?></td>
						<td class="centered"><?php echo $re['amount'] ?></td>
					</tr>
					<?php endforeach ?>
					<tr>
						<td colspan="3">Tolat</td>
						<td><?php echo $total7?></td>
						<td><?php echo $total2?></td>
					</tr>
			</tbody>
			</table>
			<?php 	}elseif ($state == 3) { ?>
			<h3> Total of <?php echo $reje_count; ?> Settlement Forms Rejected</h3>
			<br>
			<br>
			<table class="table table-striped table-bordered table-condensed" style="width:1200px;">
			<thead>
				<tr>
					<th style="width: 400px;" class="centered">Hotel Name</th>
					<th style="width: 300px;" class="centered">Form no.</th>
					<th style="width: 300px;" class="centered">Date</th>
					<th style="width: 250px;" class="centered">Close Case Amount</th>
					<th style="width: 250px;" class="centered">Rejected Settlement</th>
				</tr>
			</thead>
			<tbody>
					<?php $total3 =0; ?>
					<?php $total8 =0; ?>
					<?php foreach ($reje as $re): ?>
					<?php $total3 = $total3 + $re['amount']; ?>
					<?php $total8 = $total8 + $re['actual']; ?>
					<tr>
						<td class="centered"><?php echo $re['hotel_name'] ?></td>
						<td class="centered"><?php echo $re['id'] ?></td>
						<td class="centered"><?php echo $re['Date'] ?></td>
						<td class="centered"><?php echo $re['actual'] ?></td>
						<td class="centered"><?php echo $re['amount'] ?></td>
					</tr>
					<?php endforeach ?>
					<tr>
						<td colspan="3">Tolat</td>
						<td><?php echo $total8?></td>
						<td><?php echo $total3?></td>
					</tr>
			</tbody>
			</table>
			<?php }elseif ($state == 4) { ?>
			<h3> Total of <?php echo $char_count; ?> Settlement Forms Waiting approval from Chairman</h3>
			<br>
			<br>
			<table class="table table-striped table-bordered table-condensed" style="width:1200px;">
			<thead>
				<tr>
					<th style="width: 400px;" class="centered">Hotel Name</th>
					<th style="width: 300px;" class="centered">Form no.</th>
					<th style="width: 300px;" class="centered">Date</th>
					<th style="width: 250px;" class="centered">Close Case Amount</th>
					<th style="width: 250px;" class="centered">Waiting Aproval From Chairman Settlement</th>
				</tr>
			</thead>
			<tbody>
					<?php $total4 =0; ?>
					<?php $total9 =0; ?>
					<?php foreach ($char as $re): ?>
					<?php $total4 = $total4 + $re['amount']; ?>
					<?php $total9 = $total9 + $re['actual']; ?>
					<tr>
						<td class="centered"><?php echo $re['hotel_name'] ?></td>
						<td class="centered"><?php echo $re['id'] ?></td>
						<td class="centered"><?php echo $re['Date'] ?></td>
						<td class="centered"><?php echo $re['actual'] ?></td>
						<td class="centered"><?php echo $re['amount'] ?></td>
					</tr>
					<?php endforeach ?>
					<tr>
						<td colspan="3">Tolat</td>
						<td><?php echo $total9?></td>
						<td><?php echo $total4?></td>
					</tr>
			</tbody>
			</table>
			<?php }elseif ($state == 5) { ?>
			<h3> Total of <?php echo $close_count; ?> Settlement Forms Closed Cases</h3>
			<br>
			<br>
			<table class="table table-striped table-bordered table-condensed" style="width:1200px;">
			<thead>
				<tr>
					<th style="width: 400px;" class="centered">Hotel Name</th>
					<th style="width: 300px;" class="centered">Form no.</th>
					<th style="width: 300px;" class="centered">Date</th>
					<th style="width: 250px;" class="centered">Close Case Amount</th>
					<th style="width: 250px;" class="centered">Closed Cases Settlement</th>
				</tr>
			</thead>
			<tbody>
					<?php $total5 =0; ?>
					<?php $total10 =0; ?>
					<?php foreach ($close as $re): ?>
					<?php $total5 = $total5 + $re['amount']; ?>
					<?php $total10 = $total10 + $re['actual']; ?>
					<tr>
						<td class="centered"><?php echo $re['hotel_name'] ?></td>
						<td class="centered"><?php echo $re['id'] ?></td>
						<td class="centered"><?php echo $re['Date'] ?></td>
						<td class="centered"><?php echo $re['actual'] ?></td>
						<td class="centered"><?php echo $re['amount'] ?></td>
					</tr>
					<?php endforeach ?>
					<tr>
						<td colspan="3">Tolat</td>
						<td><?php echo $total10?> </td>
						<td><?php echo $total5?> </td>
					</tr>
			</tbody>
			</table>
			<?php }else{ ?> 
			<h3> Total of <?php echo $wait_count; ?> Settlement Forms Waiting approval</h3>
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
				</tr>
			</thead>
			<tbody>
				<?php $total1 =0; ?>
				<?php $total6 =0; ?>
					<?php foreach ($wait as $re): ?>
				<?php $total1 = $total1 + $re['amount']; ?>
				<?php $total6 = $total6 + $re['actual']; ?>
						<tr>
						<td class="centered"><?php echo $re['hotel_name'] ?></td>
						<td class="centered"><?php echo $re['id'] ?></td>
						<td class="centered"><?php echo $re['Date'] ?></td>
						<td class="centered"><?php echo $re['actual'] ?></td>
						<td class="centered"><?php echo $re['amount'] ?></td>
					</tr>
					<?php endforeach ?>
					<tr>
						<td colspan="3">Tolat</td>
						<td><?php echo $total6?></td>
						<td><?php echo $total1?></td>
					</tr>
			</tbody>
			</table>
			<br>
			<br>
			<h3> Total of <?php echo $app_count; ?> Settlement Forms Approved</h3>
			<br>
			<br>
			<table class="table table-striped table-bordered table-condensed" style="width:1200px;">
			<thead>
				<tr>
					<th style="width: 400px;" class="centered">Hotel Name</th>
					<th style="width: 300px;" class="centered">Form no.</th>
					<th style="width: 300px;" class="centered">Date</th>
					<th style="width: 250px;" class="centered">Close Case Amount</th>
					<th style="width: 250px;" class="centered">Approved Settlement</th>
				</tr>
			</thead>
			<tbody>
					<?php $total2 =0; ?>
					<?php $total7 =0; ?>
					<?php foreach ($app as $re): ?>
					<?php $total2 = $total2 + $re['amount']; ?>
					<?php $total7 = $total7 + $re['actual']; ?>

					<tr>
						<td class="centered"><?php echo $re['hotel_name'] ?></td>
						<td class="centered"><?php echo $re['id'] ?></td>
						<td class="centered"><?php echo $re['Date'] ?></td>
						<td class="centered"><?php echo $re['actual'] ?></td>
						<td class="centered"><?php echo $re['amount'] ?></td>
					</tr>
					<?php endforeach ?>
					<tr>
						<td colspan="3">Tolat</td>
						<td><?php echo $total7?></td>
						<td><?php echo $total2?></td>
					</tr>
			</tbody>
			</table>
			<br>
			<br>
			<h3> Total of <?php echo $reje_count; ?> Settlement Forms Rejected</h3>
			<br>
			<br>
			<table class="table table-striped table-bordered table-condensed" style="width:1200px;">
			<thead>
				<tr>
					<th style="width: 400px;" class="centered">Hotel Name</th>
					<th style="width: 300px;" class="centered">Form no.</th>
					<th style="width: 300px;" class="centered">Date</th>
					<th style="width: 250px;" class="centered">Close Case Amount</th>
					<th style="width: 250px;" class="centered">Rejected Settlement</th>
				</tr>
			</thead>
			<tbody>
					<?php $total3 =0; ?>
					<?php $total8 =0; ?>
					<?php foreach ($reje as $re): ?>
					<?php $total3 = $total3 + $re['amount']; ?>
					<?php $total8 = $total8 + $re['actual']; ?>
					<tr>
						<td class="centered"><?php echo $re['hotel_name'] ?></td>
						<td class="centered"><?php echo $re['id'] ?></td>
						<td class="centered"><?php echo $re['Date'] ?></td>
						<td class="centered"><?php echo $re['actual'] ?></td>
						<td class="centered"><?php echo $re['amount'] ?></td>
					</tr>
					<?php endforeach ?>
					<tr>
						<td colspan="3">Tolat</td>
						<td><?php echo $total8?></td>
						<td><?php echo $total3?></td>
					</tr>
			</tbody>
			</table>
			<br>
			<br>
			<h3> Total of <?php echo $char_count; ?> Settlement Forms Waiting approval from Chairman</h3>
			<br>
			<br>
			<table class="table table-striped table-bordered table-condensed" style="width:1200px;">
			<thead>
				<tr>
					<th style="width: 400px;" class="centered">Hotel Name</th>
					<th style="width: 300px;" class="centered">Form no.</th>
					<th style="width: 300px;" class="centered">Date</th>
					<th style="width: 250px;" class="centered">Close Case Amount</th>
					<th style="width: 250px;" class="centered">Waiting Aproval From Chairman Settlement</th>
				</tr>
			</thead>
			<tbody>
					<?php $total4 =0; ?>
					<?php $total9 =0; ?>
					<?php foreach ($char as $re): ?>
					<?php $total4 = $total4 + $re['amount']; ?>
					<?php $total9 = $total9 + $re['actual']; ?>
					<tr>
						<td class="centered"><?php echo $re['hotel_name'] ?></td>
						<td class="centered"><?php echo $re['id'] ?></td>
						<td class="centered"><?php echo $re['Date'] ?></td>
						<td class="centered"><?php echo $re['actual'] ?></td>
						<td class="centered"><?php echo $re['amount'] ?></td>
					</tr>
					<?php endforeach ?>
					<tr>
						<td colspan="3">Tolat</td>
						<td><?php echo $total9?></td>
						<td><?php echo $total4?></td>
					</tr>
			</tbody>
			</table>
			<br>
			<br>
			<h3> Total of <?php echo $close_count; ?> Settlement Forms Closed Cases</h3>
			<br>
			<br>
			<table class="table table-striped table-bordered table-condensed" style="width:1200px;">
			<thead>
				<tr>
					<th style="width: 400px;" class="centered">Hotel Name</th>
					<th style="width: 300px;" class="centered">Form no.</th>
					<th style="width: 300px;" class="centered">Date</th>
					<th style="width: 250px;" class="centered">Close Case Amount</th>
					<th style="width: 250px;" class="centered">Closed Cases Settlement</th>
				</tr>
			</thead>
			<tbody>
					<?php $total5 =0; ?>
					<?php $total10 =0; ?>
					<?php foreach ($close as $re): ?>
					<?php $total5 = $total5 + $re['amount']; ?>
					<?php $total10 = $total10 + $re['actual']; ?>
					<tr>
						<td class="centered"><?php echo $re['hotel_name'] ?></td>
						<td class="centered"><?php echo $re['id'] ?></td>
						<td class="centered"><?php echo $re['Date'] ?></td>
						<td class="centered"><?php echo $re['actual'] ?></td>
						<td class="centered"><?php echo $re['amount'] ?></td>
					</tr>
					<?php endforeach ?>
					<tr>
						<td colspan="3">Tolat</td>
						<td><?php echo $total10?> </td>
						<td><?php echo $total5?> </td>
					</tr>
			</tbody>
			</table>
			<?php } ?>
	</div>
	</div>
		<?php endif; ?>
	</div>
</div>
</body>
</html>
