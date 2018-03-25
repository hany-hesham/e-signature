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
    <a class="form-actions btn btn-success non-printable" href="/qlt_report" style="float:right;" > Back </a>
	<div class="container">

		<div class="rest-selector col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<fieldset>
			<legend class="title-table">Settlement summary</legend>
					<?php $this->load->view('settlement_report_menu_all'); ?>
			</fieldset>
		</div>
		<?php if (isset($state)): ?>	
			<?php if ($state == 1) {	 ?>
				<?php $total10 =0; ?>
				<?php $total20 =0; ?>
				<?php foreach ($wait as $re): ?>
					<?php $total10 = $total10 + $re['amount']; ?>
					<?php $total20 = $total20 + $re['actual']; ?>
				<?php endforeach ?>
			<h2 class="centered">Waiting Approval Settlement Forms</h2>
			<h3 class="centered">Total <?php echo $wait_count; ?> Forms</h3>
			<h4 class="centered">Waiting Approval Settlement Amount <?php echo $total10;?> £</h4> 
			<h5 class="centered">Waiting Approval Settlement Close Case Amount <?php echo $total20;?> £</h5> 
			<br>
			<div class="centered">
			<table class="table table-striped table-bordered table-condensed summary" style="width: 300px; font-size:9px; float: right;">
			<tr>
				<td colspan="4">Summary</td>
			</tr>
			<tr>
				<td>Hotel Name</td>
				<td>No. of Reports</td>
				<td>Total Amount</td>
				<td>Total Close Case Amount</td>
			</tr>
			<?php $i = 0; ?>
			<?php foreach ($count as $key => $value):?>
			<tr>
				<td><?php echo $key; ?></td>
				<td><?php echo $count[$key]; ?></td>
				<?php $amount = 0; ?>
				<?php foreach ($wait_value[$i] as $value):?>
					<?php $amount= $amount + $value['amount']; ?>
				<?php endforeach; ?>
				<td><?php echo $amount; ?> £</td>
				<?php $amount1 = 0; ?>
				<?php foreach ($wait_value[$i] as $value):?>
					<?php $amount1= $amount1 + $value['actual']; ?>
				<?php endforeach; ?>
				<td><?php echo $amount1; ?> £</td>
				<?php $i++; ?>
			</tr>
			<?php endforeach; ?>
			</table>
			</div>
			<div class="centered">
			<table class="table table-striped table-bordered table-condensed real" style="width:1200px;">
			<tbody>
				<tr>
					<th style="width: 400px;" class="centered">Hotel Name</th>
					<th style="width: 300px;" class="centered">Form no.</th>
					<th style="width: 300px;" class="centered">Date</th>
					<th style="width: 250px;" class="centered">Close Case Amount</th>
					<th style="width: 250px;" class="centered">Waiting Approval Settlement</th>
				</tr>
			</tbody>
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
						<td class="centered"><?php echo $re['actual'] ?> <?php echo $re['currency'] ?></td>
						<td class="centered"><?php echo $re['amount'] ?> <?php echo $re['currency'] ?></td>
					</tr>
					<?php endforeach ?>
					<tr>
						<td colspan="3">Tolat</td>
						<td><?php echo $total6?> £</td>
						<td><?php echo $total1?> £</td>
					</tr>
			</tbody>
			</table>
			</div>
			<?php 	}elseif ($state == 2) { ?>
				<?php $total30 =0; ?>
				<?php $total40 =0; ?>
				<?php foreach ($app as $re): ?>
					<?php $total30 = $total30 + $re['amount']; ?>
					<?php $total40 = $total40 + $re['actual']; ?>
				<?php endforeach ?>
			<h2 class="centered">Approved Settlement Forms</h2>
			<h3 class="centered">Total <?php echo $app_count; ?> Forms</h3>
			<h4 class="centered">Approved Settlement Amount <?php echo $total30;?> £</h4> 
			<h5 class="centered">Approved Settlement Close Case Amount <?php echo $total40;?> £</h5> 
			<br>
			<div class="centered">
			<table class="table table-striped table-bordered table-condensed summary" style="width: 300px; font-size:9px; float: right;">
			<tr>
				<td colspan="4">Summary</td>
			</tr>
			<tr>
				<td>Hotel Name</td>
				<td>No. of Reports</td>
				<td>Total Amount</td>
				<td>Total Close Case Amount</td>
			</tr>
			<?php $a = 0; ?>
			<?php foreach ($count1 as $key => $value):?>
			<tr>
				<td><?php echo $key; ?></td>
				<td><?php echo $count1[$key]; ?></td>
				<?php $amount = 0; ?>
				<?php foreach ($app_value[$a] as $value):?>
					<?php $amount= $amount + $value['amount']; ?>
				<?php endforeach; ?>
				<td><?php echo $amount; ?> £</td>
				<?php $amount1 = 0; ?>
				<?php foreach ($app_value[$a] as $value):?>
					<?php $amount1= $amount1 + $value['actual']; ?>
				<?php endforeach; ?>
				<td><?php echo $amount1; ?> £</td>
				<?php $a++; ?>
			</tr>
			<?php endforeach; ?>
			</table>
			</div>
			<div class="centered">
			<table class="table table-striped table-bordered table-condensed real" style="width:1200px;">
			<tbody>
				<tr>
					<th style="width: 400px;" class="centered">Hotel Name</th>
					<th style="width: 300px;" class="centered">Form no.</th>
					<th style="width: 300px;" class="centered">Date</th>
					<th style="width: 250px;" class="centered">Close Case Amount</th>
					<th style="width: 250px;" class="centered">Approved Settlement</th>
				</tr>
			</tbody>
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
						<td class="centered"><?php echo $re['actual'] ?> <?php echo $re['currency'] ?></td>
						<td class="centered"><?php echo $re['amount'] ?> <?php echo $re['currency'] ?></td>
					</tr>
					<?php endforeach ?>
					<tr>
						<td colspan="3">Tolat</td>
						<td><?php echo $total7?> £</td>
						<td><?php echo $total2?> £</td>
					</tr>
			</tbody>
			</table>
			</div>
			<?php 	}elseif ($state == 3) { ?>
				<?php $total50 =0; ?>
				<?php $total60 =0; ?>
				<?php foreach ($reje as $re): ?>
					<?php $total50 = $total50 + $re['amount']; ?>
					<?php $total60 = $total60 + $re['actual']; ?>
				<?php endforeach ?>
			<h2 class="centered">Rejected Settlement Forms</h2>
			<h3 class="centered">Total <?php echo $reje_count; ?> Forms</h3>
			<h4 class="centered">Rejected Settlement Amount <?php echo $total50;?> £</h4> 
			<h5 class="centered">Rejected Settlement Close Case Amount <?php echo $total60;?> £</h5> 
			<br>
			<div class="centered">
			<table class="table table-striped table-bordered table-condensed summary" style="width: 300px; font-size:9px; float: right;">
			<tr>
				<td colspan="4">Summary</td>
			</tr>
			<tr>
				<td>Hotel Name</td>
				<td>No. of Reports</td>
				<td>Total Amount</td>
				<td>Total Close Case Amount</td>
			</tr>
			<?php $a = 0; ?>
			<?php foreach ($count2 as $key => $value):?>
			<tr>
				<td><?php echo $key; ?></td>
				<td><?php echo $count2[$key]; ?></td>
				<?php $amount = 0; ?>
				<?php foreach ($reje_value[$a] as $value):?>
					<?php $amount= $amount + $value['amount']; ?>
				<?php endforeach; ?>
				<td><?php echo $amount; ?> £</td>
				<?php $amount1 = 0; ?>
				<?php foreach ($reje_value[$a] as $value):?>
					<?php $amount1= $amount1 + $value['actual']; ?>
				<?php endforeach; ?>
				<td><?php echo $amount1; ?> £</td>
				<?php $a++; ?>
			</tr>
			<?php endforeach; ?>
			</table>
			</div>
			<div class="centered">
			<table class="table table-striped table-bordered table-condensed real" style="width:1200px;">
			<tbody>
				<tr>
					<th style="width: 400px;" class="centered">Hotel Name</th>
					<th style="width: 300px;" class="centered">Form no.</th>
					<th style="width: 300px;" class="centered">Date</th>
					<th style="width: 250px;" class="centered">Close Case Amount</th>
					<th style="width: 250px;" class="centered">Rejected Settlement</th>
				</tr>
			</tbody>
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
						<td class="centered"><?php echo $re['actual'] ?> <?php echo $re['currency'] ?></td>
						<td class="centered"><?php echo $re['amount'] ?> <?php echo $re['currency'] ?></td>
					</tr>
					<?php endforeach ?>
					<tr>
						<td colspan="3">Tolat</td>
						<td><?php echo $total8?> £</td>
						<td><?php echo $total3?> £</td>
					</tr>
			</tbody>
			</table>
			</div>
			<?php }elseif ($state == 4) { ?>
				<?php $total70 =0; ?>
				<?php $total80 =0; ?>
				<?php foreach ($char as $re): ?>
					<?php $total70 = $total70 + $re['amount']; ?>
					<?php $total80 = $total80 + $re['actual']; ?>
				<?php endforeach ?>
			<h2 class="centered">Waiting approval from Chairman Settlement Forms</h2>
			<h3 class="centered">Total <?php echo $char_count; ?> Forms</h3>
			<h4 class="centered">Waiting approval from Chairman Settlement Amount <?php echo $total70;?> £</h4> 
			<h5 class="centered">Waiting approval from Chairman Settlement Close Case Amount <?php echo $total80;?> £</h5>
			<br>
			<div class="centered">
			<table class="table table-striped table-bordered table-condensed summary" style="width: 300px; font-size:9px; float: right;">
			<tr>
				<td colspan="4">Summary</td>
			</tr>
			<tr>
				<td>Hotel Name</td>
				<td>No. of Reports</td>
				<td>Total Amount</td>
				<td>Total Close Case Amount</td>
			</tr>
			<?php $a = 0; ?>
			<?php foreach ($count3 as $key => $value):?>
			<tr>
				<td><?php echo $key; ?></td>
				<td><?php echo $count3[$key]; ?></td>
				<?php $amount = 0; ?>
				<?php foreach ($char_value[$a] as $value):?>
					<?php $amount= $amount + $value['amount']; ?>
				<?php endforeach; ?>
				<td><?php echo $amount; ?> £</td>
				<?php $amount1 = 0; ?>
				<?php foreach ($char_value[$a] as $value):?>
					<?php $amount1= $amount1 + $value['actual']; ?>
				<?php endforeach; ?>
				<td><?php echo $amount1; ?> £</td>
				<?php $a++; ?>
			</tr>
			<?php endforeach; ?>
			</table>
			</div>
			<div class="centered">
			<table class="table table-striped table-bordered table-condensed real" style="width:1200px;">
			<tbody>
				<tr>
					<th style="width: 400px;" class="centered">Hotel Name</th>
					<th style="width: 300px;" class="centered">Form no.</th>
					<th style="width: 300px;" class="centered">Date</th>
					<th style="width: 250px;" class="centered">Close Case Amount</th>
					<th style="width: 250px;" class="centered">Waiting Aproval From Chairman Settlement</th>
				</tr>
			</tbody>
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
						<td class="centered"><?php echo $re['actual'] ?> <?php echo $re['currency'] ?></td>
						<td class="centered"><?php echo $re['amount'] ?> <?php echo $re['currency'] ?></td>
					</tr>
					<?php endforeach ?>
					<tr>
						<td colspan="3">Tolat</td>
						<td><?php echo $total9?> £</td>
						<td><?php echo $total4?> £</td>
					</tr>
			</tbody>
			</table>
			</div>
			<?php }elseif ($state == 5) { ?>
				<?php $total90 =0; ?>
				<?php $total100 =0; ?>
				<?php foreach ($close as $re): ?>
					<?php $total90 = $total90 + $re['amount']; ?>
					<?php $total100 = $total100 + $re['actual']; ?>
				<?php endforeach ?>
			<h2 class="centered">Closed Cases Settlement Forms</h2>
			<h3 class="centered">Total <?php echo $close_count; ?> Forms</h3>
			<h4 class="centered">Closed Cases Settlement Amount <?php echo $total90;?> £</h4> 
			<h5 class="centered">Closed Cases Settlement Close Case Amount <?php echo $total100;?> £</h5>
			<br>
			<div class="centered">
			<table class="table table-striped table-bordered table-condensed summary" style="width: 300px; font-size:9px; float: right;">
			<tr>
				<td colspan="4">Summary</td>
			</tr>
			<tr>
				<td>Hotel Name</td>
				<td>No. of Reports</td>
				<td>Total Amount</td>
				<td>Total Close Case Amount</td>
			</tr>
			<?php $a = 0; ?>
			<?php foreach ($count4 as $key => $value):?>
			<tr>
				<td><?php echo $key; ?></td>
				<td><?php echo $count4[$key]; ?></td>
				<?php $amount = 0; ?>
				<?php foreach ($close_value[$a] as $value):?>
					<?php $amount= $amount + $value['amount']; ?>
				<?php endforeach; ?>
				<td><?php echo $amount; ?> £</td>
				<?php $amount1 = 0; ?>
				<?php foreach ($close_value[$a] as $value):?>
					<?php $amount1= $amount1 + $value['actual']; ?>
				<?php endforeach; ?>
				<td><?php echo $amount1; ?> £</td>
				<?php $a++; ?>
			</tr>
			<?php endforeach; ?>
			</table>
			</div>
			<div class="centered">
			<table class="table table-striped table-bordered table-condensed real" style="width:1200px;">
			<tbody>
				<tr>
					<th style="width: 400px;" class="centered">Hotel Name</th>
					<th style="width: 300px;" class="centered">Form no.</th>
					<th style="width: 300px;" class="centered">Date</th>
					<th style="width: 250px;" class="centered">Close Case Amount</th>
					<th style="width: 250px;" class="centered">Closed Cases Settlement</th>
				</tr>
			</tbody>
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
						<td class="centered"><?php echo $re['actual'] ?> <?php echo $re['currency'] ?></td>
						<td class="centered"><?php echo $re['amount'] ?> <?php echo $re['currency'] ?></td>
					</tr>
					<?php endforeach ?>
					<tr>
						<td colspan="3">Tolat</td>
						<td><?php echo $total10?> £</td>
						<td><?php echo $total5?> £</td>
					</tr>
			</tbody>
			</table>
			</div>
			<?php }else{ ?> 
				<?php $total110 =0; ?>
				<?php $total120 =0; ?>
				<?php foreach ($wait as $re): ?>
					<?php $total110 = $total110 + $re['amount']; ?>
					<?php $total120 = $total120 + $re['actual']; ?>
				<?php endforeach ?>
			<h2 class="centered">Waiting approval Settlement Forms</h2>
			<h3 class="centered">Total <?php echo $wait_count; ?> Forms</h3>
			<h4 class="centered">Waiting approval Settlement Amount <?php echo $total110;?> £</h4> 
			<h5 class="centered">Waiting approval Settlement Close Case Amount <?php echo $total120;?> £</h5>
			<br>
			<div class="centered">
			<table class="table table-striped table-bordered table-condensed summary" style="width: 300px; font-size:9px; float: right;">
			<tr>
				<td colspan="4">Summary</td>
			</tr>
			<tr>
				<td>Hotel Name</td>
				<td>No. of Reports</td>
				<td>Total Amount</td>
				<td>Total Close Case Amount</td>
			</tr>
			<?php $i = 0; ?>
			<?php foreach ($count as $key => $value):?>
			<tr>
				<td><?php echo $key; ?></td>
				<td><?php echo $count[$key]; ?></td>
				<?php $amount = 0; ?>
				<?php foreach ($wait_value[$i] as $value):?>
					<?php $amount= $amount + $value['amount']; ?>
				<?php endforeach; ?>
				<td><?php echo $amount; ?> £</td>
				<?php $amount1 = 0; ?>
				<?php foreach ($wait_value[$i] as $value):?>
					<?php $amount1= $amount1 + $value['actual']; ?>
				<?php endforeach; ?>
				<td><?php echo $amount1; ?> £</td>
				<?php $i++; ?>
			</tr>
			<?php endforeach; ?>
			</table>
			</div>
			<div class="centered">
			<table class="table table-striped table-bordered table-condensed real" style="width:1200px;">
			<tbody>
				<tr>
					<th style="width: 400px;" class="centered">Hotel Name</th>
					<th style="width: 300px;" class="centered">Form no.</th>
					<th style="width: 300px;" class="centered">Date</th>
					<th style="width: 250px;" class="centered">Close Case Amount</th>
					<th style="width: 250px;" class="centered">Waiting Approval Settlement</th>
				</tr>
			</tbody>
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
						<td class="centered"><?php echo $re['actual'] ?> <?php echo $re['currency'] ?></td>
						<td class="centered"><?php echo $re['amount'] ?> <?php echo $re['currency'] ?></td>
					</tr>
					<?php endforeach ?>
					<tr>
						<td colspan="3">Tolat</td>
						<td><?php echo $total6?> £</td>
						<td><?php echo $total1?> £</td>
					</tr>
			</tbody>
			</table>
			</div>
			<br>
			<br>
				<?php $total130 =0; ?>
				<?php $total140 =0; ?>
				<?php foreach ($app as $re): ?>
					<?php $total130 = $total130 + $re['amount']; ?>
					<?php $total140 = $total140 + $re['actual']; ?>
				<?php endforeach ?>
			<h2 class="centered">Approved Settlement Forms</h2>
			<h3 class="centered">Total <?php echo $app_count; ?> Forms</h3>
			<h4 class="centered">Approved Settlement Amount <?php echo $total130;?> £</h4> 
			<h5 class="centered">Approved Settlement Close Case Amount <?php echo $total140;?> £</h5>
			<br>
			<div class="centered">
			<table class="table table-striped table-bordered table-condensed summary" style="width: 300px; font-size:9px; float: right;">
			<tr>
				<td colspan="4">Summary</td>
			</tr>
			<tr>
				<td>Hotel Name</td>
				<td>No. of Reports</td>
				<td>Total Amount</td>
				<td>Total Close Case Amount</td>
			</tr>
			<?php $a = 0; ?>
			<?php foreach ($count1 as $key => $value):?>
			<tr>
				<td><?php echo $key; ?></td>
				<td><?php echo $count1[$key]; ?></td>
				<?php $amount = 0; ?>
				<?php foreach ($app_value[$a] as $value):?>
					<?php $amount= $amount + $value['amount']; ?>
				<?php endforeach; ?>
				<td><?php echo $amount; ?> £</td>
				<?php $amount1 = 0; ?>
				<?php foreach ($app_value[$a] as $value):?>
					<?php $amount1= $amount1 + $value['actual']; ?>
				<?php endforeach; ?>
				<td><?php echo $amount1; ?> £</td>
				<?php $a++; ?>
			</tr>
			<?php endforeach; ?>
			</table>
			</div>
			<div class="centered">
			<table class="table table-striped table-bordered table-condensed real" style="width:1200px;">
			<tbody>
				<tr>
					<th style="width: 400px;" class="centered">Hotel Name</th>
					<th style="width: 300px;" class="centered">Form no.</th>
					<th style="width: 300px;" class="centered">Date</th>
					<th style="width: 250px;" class="centered">Close Case Amount</th>
					<th style="width: 250px;" class="centered">Approved Settlement</th>
				</tr>
			</tbody>
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
						<td class="centered"><?php echo $re['actual'] ?> <?php echo $re['currency'] ?></td>
						<td class="centered"><?php echo $re['amount'] ?> <?php echo $re['currency'] ?></td>
					</tr>
					<?php endforeach ?>
					<tr>
						<td colspan="3">Tolat</td>
						<td><?php echo $total7?> £</td>
						<td><?php echo $total2?> £</td>
					</tr>
			</tbody>
			</table>
			</div>
			<br>
			<br>
				<?php $total150 =0; ?>
				<?php $total160 =0; ?>
				<?php foreach ($reje as $re): ?>
					<?php $total150 = $total150 + $re['amount']; ?>
					<?php $total160 = $total160 + $re['actual']; ?>
				<?php endforeach ?>
			<h2 class="centered">Rejected Settlement Forms</h2>
			<h3 class="centered">Total <?php echo $reje_count; ?> Forms</h3>
			<h4 class="centered">Rejected Settlement Amount <?php echo $total150;?> £</h4> 
			<h5 class="centered">Rejected Settlement Close Case Amount <?php echo $total160;?> £</h5>
			<br>
			<div class="centered">
			<tr>
				<td colspan="4">Summary</td>
			</tr>
			<tr>
				<td>Hotel Name</td>
				<td>No. of Reports</td>
				<td>Total Amount</td>
				<td>Total Close Case Amount</td>
			</tr>
			<?php $a = 0; ?>
			<?php foreach ($count2 as $key => $value):?>
			<tr>
				<td><?php echo $key; ?></td>
				<td><?php echo $count2[$key]; ?></td>
				<?php $amount = 0; ?>
				<?php foreach ($reje_value[$a] as $value):?>
					<?php $amount= $amount + $value['amount']; ?>
				<?php endforeach; ?>
				<td><?php echo $amount; ?> £</td>
				<?php $amount1 = 0; ?>
				<?php foreach ($reje_value[$a] as $value):?>
					<?php $amount1= $amount1 + $value['actual']; ?>
				<?php endforeach; ?>
				<td><?php echo $amount1; ?> £</td>
				<?php $a++; ?>
			</tr>
			<?php endforeach; ?>
			</table>
			</div>
			<div class="centered">
			<table class="table table-striped table-bordered table-condensed real" style="width:1200px;">
			<tbody>
				<tr>
					<th style="width: 400px;" class="centered">Hotel Name</th>
					<th style="width: 300px;" class="centered">Form no.</th>
					<th style="width: 300px;" class="centered">Date</th>
					<th style="width: 250px;" class="centered">Close Case Amount</th>
					<th style="width: 250px;" class="centered">Rejected Settlement</th>
				</tr>
			</tbody>
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
						<td class="centered"><?php echo $re['actual'] ?> <?php echo $re['currency'] ?></td>
						<td class="centered"><?php echo $re['amount'] ?> <?php echo $re['currency'] ?></td>
					</tr>
					<?php endforeach ?>
					<tr>
						<td colspan="3">Tolat</td>
						<td><?php echo $total8?> £</td>
						<td><?php echo $total3?> £</td>
					</tr>
			</tbody>
			</table>
			</div>
			<br>
			<br>
				<?php $total170 =0; ?>
				<?php $total180 =0; ?>
				<?php foreach ($char as $re): ?>
					<?php $total170 = $total170 + $re['amount']; ?>
					<?php $total180 = $total180 + $re['actual']; ?>
				<?php endforeach ?>
			<h2 class="centered">Waiting approval from Chairman Settlement Forms</h2>
			<h3 class="centered">Total <?php echo $char_count; ?> Forms</h3>
			<h4 class="centered">Waiting approval from Chairman Settlement Amount <?php echo $total170;?> £</h4> 
			<h5 class="centered">Waiting approval from Chairman Settlement Close Case Amount <?php echo $total180;?> £</h5>
			<br>
			<div class="centered">
			<table class="table table-striped table-bordered table-condensed summary" style="width: 300px; font-size:9px; float: right;">
			<tr>
				<td colspan="4">Summary</td>
			</tr>
			<tr>
				<td>Hotel Name</td>
				<td>No. of Reports</td>
				<td>Total Amount</td>
				<td>Total Close Case Amount</td>
			</tr>
			<?php $a = 0; ?>
			<?php foreach ($count3 as $key => $value):?>
			<tr>
				<td><?php echo $key; ?></td>
				<td><?php echo $count3[$key]; ?></td>
				<?php $amount = 0; ?>
				<?php foreach ($char_value[$a] as $value):?>
					<?php $amount= $amount + $value['amount']; ?>
				<?php endforeach; ?>
				<td><?php echo $amount; ?> £</td>
				<?php $amount1 = 0; ?>
				<?php foreach ($char_value[$a] as $value):?>
					<?php $amount1= $amount1 + $value['actual']; ?>
				<?php endforeach; ?>
				<td><?php echo $amount1; ?> £</td>
				<?php $a++; ?>
			</tr>
			<?php endforeach; ?>
			</table>
			</div>
			<div class="centered">
			<table class="table table-striped table-bordered table-condensed real" style="width:1200px;">
			<tbody>
				<tr>
					<th style="width: 400px;" class="centered">Hotel Name</th>
					<th style="width: 300px;" class="centered">Form no.</th>
					<th style="width: 300px;" class="centered">Date</th>
					<th style="width: 250px;" class="centered">Close Case Amount</th>
					<th style="width: 250px;" class="centered">Waiting Aproval From Chairman Settlement</th>
				</tr>
			</tbody>
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
						<td class="centered"><?php echo $re['actual'] ?> <?php echo $re['currency'] ?></td>
						<td class="centered"><?php echo $re['amount'] ?> <?php echo $re['currency'] ?></td>
					</tr>
					<?php endforeach ?>
					<tr>
						<td colspan="3">Tolat</td>
						<td><?php echo $total9?> £</td>
						<td><?php echo $total4?> £</td>
					</tr>
			</tbody>
			</table>
			</div>
			<br>
			<br>
				<?php $total190 =0; ?>
				<?php $total200 =0; ?>
				<?php foreach ($close as $re): ?>
					<?php $total190 = $total190 + $re['amount']; ?>
					<?php $total200 = $total200 + $re['actual']; ?>
				<?php endforeach ?>
			<h2 class="centered">Closed Cases Settlement Forms</h2>
			<h3 class="centered">Total <?php echo $close_count; ?> Forms</h3>
			<h4 class="centered">Closed Cases Settlement Amount <?php echo $total190;?> £</h4> 
			<h5 class="centered">Closed Cases Settlement Close Case Amount <?php echo $total200;?> £</h5>
			<br>
			<div class="centered">
			<table class="table table-striped table-bordered table-condensed summary" style="width: 300px; font-size:9px; float: right;">
			<tr>
				<td colspan="4">Summary</td>
			</tr>
			<tr>
				<td>Hotel Name</td>
				<td>No. of Reports</td>
				<td>Total Amount</td>
				<td>Total Close Case Amount</td>
			</tr>
			<?php $a = 0; ?>
			<?php foreach ($count4 as $key => $value):?>
			<tr>
				<td><?php echo $key; ?></td>
				<td><?php echo $count4[$key]; ?></td>
				<?php $amount = 0; ?>
				<?php foreach ($close_value[$a] as $value):?>
					<?php $amount= $amount + $value['amount']; ?>
				<?php endforeach; ?>
				<td><?php echo $amount; ?> £</td>
				<?php $amount1 = 0; ?>
				<?php foreach ($close_value[$a] as $value):?>
					<?php $amount1= $amount1 + $value['actual']; ?>
				<?php endforeach; ?>
				<td><?php echo $amount1; ?> £</td>
				<?php $a++; ?>
			</tr>
			<?php endforeach; ?>
			</table>
			</div>
			<div class="centered">
			<table class="table table-striped table-bordered table-condensed real" style="width:1200px;">
			<tbody>
				<tr>
					<th style="width: 400px;" class="centered">Hotel Name</th>
					<th style="width: 300px;" class="centered">Form no.</th>
					<th style="width: 300px;" class="centered">Date</th>
					<th style="width: 250px;" class="centered">Close Case Amount</th>
					<th style="width: 250px;" class="centered">Closed Cases Settlement</th>
				</tr>
			</tbody>
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
						<td class="centered"><?php echo $re['actual'] ?> <?php echo $re['currency'] ?></td>
						<td class="centered"><?php echo $re['amount'] ?> <?php echo $re['currency'] ?></td>
					</tr>
					<?php endforeach ?>
					<tr>
						<td colspan="3">Tolat</td>
						<td><?php echo $total10?> £</td>
						<td><?php echo $total5?> £</td>
					</tr>
			</tbody>
			</table>
			</div>
			<?php } ?>
	</div>
		<?php endif; ?>
	</div>
</div>
</body>
</html>