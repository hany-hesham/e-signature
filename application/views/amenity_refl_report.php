<!DOCTYPE html>
<html lang="en">
<head>
<?php $this->load->view('header'); ?>
<style type="text/css">
	@media print{
		.real{
			width: 1000px !important;
		}
		.topic{
			display: block !important;
		}
	}
</style>
</head>
<body>
<div id="wrapper">
	<?php $this->load->view('menu') ?>
	<div id="page-wrapper col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<button onclick="window.print()" class="non-printable form-actions btn btn-success" href="" >Print</button>
    <a class="form-actions btn btn-success non-printable" href="/fo_report" style="float:right;" > Back </a>
	<div class="container">
		<div class="rest-selector col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<fieldset>
			<legend class="title-table non-printable">Amenity Refilling summary</legend>
					<?php $this->load->view('amenity_refl_report_menu_hotel'); ?>
			</fieldset>
		</div>
		<?php if (isset($refl)): ?>	
			<div class="centered">
				<div class="centered header-logo topic" style="display: none;"><img src="/assets/uploads/logos/<?php echo $name['logo']; ?>"/></div>
				<h1 class="centered topic" style="display: none;"> <?php echo $name['name']; ?> </h1>
				<h3 class="centered topic" style="display: none;"> from <?php echo $from; ?> to <?php echo $to; ?></h3>
				<h4 class="centered"> Total of <?php echo $refl_count; ?> Refilling Gest Amenities</h4>
			</div>
			<br>
			<br>
			<div class="centered">
				<table class="table table-striped table-bordered table-condensed real" style="width:1000px;">
					<tr>
						<th style="width: 50px;" class="centered">ID#</th>
						<th style="width: 100px;" class="centered" colspan="2">Room No.</th>
						<th style="width: 150px;" class="centered">Date and Time of Delivery</th>
						<th style="width: 150px;" class="centered">Guest Name</th>
						<th style="width: 70px;" class="centered">Number Of Pax</th>
						<th style="width: 80px;" class="centered">Treatment</th>
						<th style="width: 200px;" class="centered">Reason</th>
						<th style="width: 200px;" class="centered">Amenities</th>
					</tr>
					<tbody>
						<?php foreach ($refl as $re): ?>
							<tr>
								<td class="centered"><?php echo $re['amen_id'] ?></td>
								<?php if ($re['amenit']):?>
									<td class="centered" colspan="1"><?php echo $re['amenit']['room_old']; ?></td>
									<td class="centered" colspan="1"><span style="color: blue;"><?php echo $re['amenit']['room_new']; ?></span></td>
								<?php else :?>
									<td class="centered" colspan="2"><?php echo $re['room'] ?></td>
								<?php endif ?>
								<td class="centered"><?php echo $re['date_time'] ?></td>
								<?php if ($re['room_edit']):?>
									<td class="centered"><span style="color: blue;"><?php echo $re['room_edit']['guest'] ?></span></td>
								<?php else :?>
									<td class="centered"><?php echo $re['guest'] ?></td>
								<?php endif ?>
								<?php if ($re['room_edit']):?>
									<td class="centered"><span style="color: blue;"><?php echo $re['room_edit']['pax'] ?></span></td>
								<?php else :?>
									<td class="centered"><?php echo $re['pax'] ?></td>
								<?php endif ?>
								<?php if ($re['room_edit']):?>
									<td class="centered"><span style="color: blue;"><?php echo $re['room_edit']['treatment'] ?></span></td>
								<?php else :?>
									<td class="centered"><?php echo $re['treatment'] ?></td>
								<?php endif ?>
								<?php if ($re['amenitys_edit']):?>
									<td class="centered"><span style="color: blue;"><?php echo $re['amenitys_edit']['reason'] ?></span></td>
								<?php else :?>
									<td class="centered"><?php echo $re['reason'] ?></td>
								<?php endif ?>
								<td class="centered">
									<?php echo ($re['cookies'] == "0")? "":"&nbsp;Cookies,"?>
									<?php echo ($re['nuts'] == "0")? "":"&nbsp;Nuts,"?>
									<?php echo ($re['wine'] == "0")? "":"&nbsp;Bottle Of Wine,"?>
									<?php echo ($re['fruit'] == "0")? "":"&nbsp;Fruit Basket,"?>
									<?php echo ($re['beer'] == "0")? "":"&nbsp;Beer,"?>
									<?php echo ($re['cake'] == "0")? "":"&nbsp;Birthday Cake,"?>
									<?php echo ($re['anniversary'] == "0")? "":"&nbsp;Anniversary,"?>
									<?php echo ($re['honeymoon'] == "0")? "":"&nbsp;Honeymoon,"?>
									<?php echo ($re['juices'] == "0")? "":"&nbsp;Small Can of Juices,"?>
									<?php echo ($re['dinner'] == "0")? "":"&nbsp;Candel Light Dinner,"?>
									<?php echo ($re['sick'] == "0")? "":"&nbsp;Sick Meal,"?>
									<?php echo ($re['alcohol'] == "0")? "":"&nbsp;Without Alcohol,"?>
									<?php echo ($re['th'] == "0")? "":"&nbsp;TH Bonus,"?>
									<?php echo ($re['uk'] == "0")? "":"&nbsp;TC UK arrival,"?>
									<?php echo ($re['chocolate'] == "0")? "":"&nbsp;Chocolate,"?>
									<?php echo ($re['milk'] == "0")? "":"&nbsp;Milk,"?>
								</td>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			</div>
		<?php endif; ?>
	</div>
</div>
</body>
</html>