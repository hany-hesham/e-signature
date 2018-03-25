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
	<button onclick="window.print()" class="non-printable form-actions btn btn-success" href="" >Print</button>
    <a class="form-actions btn btn-success non-printable" href="/fo_report" style="float:right;" > Back </a>
		<div class="rest-selector col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<fieldset>
			<legend class="title-table non-printable">Amenity summary</legend>
					<?php $this->load->view('amenity_report_menu_hotel'); ?>
			</fieldset>
		</div>
		<?php if (isset($vip)): ?>	
			<div class="centered">
				<div class="centered header-logo topic" style="display: none; margin-top: -85px;"><img src="/assets/uploads/logos/<?php echo $name['logo']; ?>"/></div>
				<h1 class="centered topic" style="display: none;"> <?php echo $name['name']; ?> </h1>

				<h2 class="centered topic" style="display: none;"> Amenities summary of Treatment <?php echo $treatment; ?></h2>
				<h3 class="centered topic" style="display: none;"> from <?php echo $from; ?> to <?php echo $to; ?></h3>
				<h4 class="centered"> Total of <?php echo $vip_count; ?> Gest Amenities</h4>
			</div>
			<br>
			<br>
			<br>
			<div class="centered">
				<table class="table table-striped table-bordered table-condensed real" style="width:1000px;">
					<tbody>
						<tr>
							<th style="width: 100px;" colspan="1" rowspan="2" class="centered">ID#</th>
							<th style="width: 100px;" colspan="2" rowspan="2" class="centered">Room No.</th>
							<th style="width: 150px;" colspan="1" rowspan="2" class="centered">Date and Time of Delivery</th>
							<th style="width: 150px;" colspan="1" rowspan="2" class="centered">Guest Name</th>
							<th style="width: 200px;" colspan="2" rowspan="1" class="centered">Number Of Pax</th>
							<th style="width: 150px;" colspan="1" rowspan="2" class="centered">Treatment</th>
							<th style="width: 250px;" colspan="1" rowspan="2" class="centered">Reason</th>
							<th style="width: 200px;" colspan="1" rowspan="2" class="centered">Amenities</th>
							<th style="width: 150px;" colspan="1" rowspan="2" class="centered">creator</th>
							<th style="width: 150px;" colspan="1" rowspan="2" class="centered non-printable">View</th>
						</tr>
						<tr>
							<th style="width: 100px;" colspan="1" rowspan="1" class="centered">Adult</th>
							<th style="width: 100px;" colspan="1" rowspan="1" class="centered">Child</th>
						</tr>
						<?php foreach ($vip as $re): ?>
							<tr>
								<td class="centered"><?php echo $re['amen_id'] ?></td>
								<?php if ($re['amenit']):?>
									<td class="centered" colspan="1"><?php echo $re['amenit']['room_old']; ?></td>
									<td class="centered" colspan="1"><span style="color: blue;"><?php echo $re['amenit']['room_new']; ?></span></td>
								<?php else :?>
									<td class="centered" colspan="2"><?php echo $re['room'] ?></td>
								<?php endif ?>
								<?php if ($re['amenitys_edit']):?>
									<td class="centered"><span style="color: blue;"><?php echo $re['amenitys_edit']['date_time'] ?></span></td>
								<?php else :?>
									<td class="centered"><?php echo $re['date_time'] ?></td>
								<?php endif ?>
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
									<td class="centered"><span style="color: blue;"><?php echo $re['room_edit']['child'] ?></span></td>
								<?php else :?>
									<td class="centered"><?php echo $re['child'] ?></td>
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
									<?php if ($re['room_edit']):?>
										<span style="color: blue;"><?php echo ($re['room_edit']['cookies'] == "0")? "":"&nbsp;Cookies,"?></span>	
									<?php else :?>
										<?php echo ($re['cookies'] == "0")? "":"&nbsp;Cookies,"?>
									<?php endif ?>
									<?php if ($re['room_edit']):?>
										<span style="color: blue;"><?php echo ($re['room_edit']['nuts'] == "0")? "":"&nbsp;Nuts,"?></span>	
									<?php else :?>
										<?php echo ($re['nuts'] == "0")? "":"&nbsp;Nuts,"?>
									<?php endif ?>
									<?php if ($re['room_edit']):?>
										<span style="color: blue;"><?php echo ($re['room_edit']['wine'] == "0")? "":"&nbsp;Bottle Of Wine,"?></span>	
									<?php else :?>
										<?php echo ($re['wine'] == "0")? "":"&nbsp;Bottle Of Wine,"?>
									<?php endif ?>
									<?php if ($re['room_edit']):?>
										<span style="color: blue;"><?php echo ($re['room_edit']['fruit'] == "0")? "":"&nbsp;Fruit Basket,"?></span>	
									<?php else :?>
										<?php echo ($re['fruit'] == "0")? "":"&nbsp;Fruit Basket,"?>
									<?php endif ?>
									<?php if ($re['room_edit']):?>
										<span style="color: blue;"><?php echo ($re['room_edit']['beer'] == "0")? "":"&nbsp;Beer,"?></span>	
									<?php else :?>
										<?php echo ($re['beer'] == "0")? "":"&nbsp;Beer,"?>
									<?php endif ?>
									<?php if ($re['room_edit']):?>
										<span style="color: blue;"><?php echo ($re['room_edit']['cake'] == "0")? "":"&nbsp;Birthday Cake,"?></span>	
									<?php else :?>
										<?php echo ($re['cake'] == "0")? "":"&nbsp;Birthday Cake,"?>
									<?php endif ?>
									<?php if ($re['room_edit']):?>
										<span style="color: blue;"><?php echo ($re['room_edit']['anniversary'] == "0")? "":"&nbsp;Anniversary,"?></span>	
									<?php else :?>
										<?php echo ($re['anniversary'] == "0")? "":"&nbsp;Anniversary,"?>
									<?php endif ?>
									<?php if ($re['room_edit']):?>
										<span style="color: blue;"><?php echo ($re['room_edit']['honeymoon'] == "0")? "":"&nbsp;Honeymoon,"?></span>	
									<?php else :?>
										<?php echo ($re['honeymoon'] == "0")? "":"&nbsp;Honeymoon,"?>
									<?php endif ?>
									<?php if ($re['room_edit']):?>
										<span style="color: blue;"><?php echo ($re['room_edit']['juices'] == "0")? "":"&nbsp;Small Can of Juices,"?></span>	
									<?php else :?>
										<?php echo ($re['juices'] == "0")? "":"&nbsp;Small Can of Juices,"?>
									<?php endif ?>
									<?php if ($re['room_edit']):?>
										<span style="color: blue;"><?php echo ($re['room_edit']['dinner'] == "0")? "":"&nbsp;Candel Light Dinner,"?></span>	
									<?php else :?>
										<?php echo ($re['dinner'] == "0")? "":"&nbsp;Candel Light Dinner,"?>
									<?php endif ?>
									<?php if ($re['room_edit']):?>
										<span style="color: blue;"><?php echo ($re['room_edit']['sick'] == "0")? "":"&nbsp;Sick Meal,"?></span>	
									<?php else :?>
										<?php echo ($re['sick'] == "0")? "":"&nbsp;Sick Meal,"?>
									<?php endif ?>
									<?php if ($re['room_edit']):?>
										<span style="color: blue;"><?php echo ($re['room_edit']['alcohol'] == "0")? "":"&nbsp;Without Alcohol,"?></span>	
									<?php else :?>
										<?php echo ($re['alcohol'] == "0")? "":"&nbsp;Without Alcohol,"?>
									<?php endif ?>
									<?php if ($re['room_edit']):?>
										<span style="color: blue;"><?php echo ($re['room_edit']['th'] == "0")? "":"&nbsp;TH Bonus,"?></span>	
									<?php else :?>
										<?php echo ($re['th'] == "0")? "":"&nbsp;TH Bonus,"?>
									<?php endif ?>
									<?php if ($re['room_edit']):?>
										<span style="color: blue;"><?php echo ($re['room_edit']['uk'] == "0")? "":"&nbsp;TC UK arrival,"?></span>	
									<?php else :?>
										<?php echo ($re['uk'] == "0")? "":"&nbsp;TC UK arrival,"?>
									<?php endif ?>
									<?php if ($re['room_edit']):?>
										<span style="color: blue;"><?php echo ($re['room_edit']['chocolate'] == "0")? "":"&nbsp;Chocolate,"?></span>	
									<?php else :?>
										<?php echo ($re['chocolate'] == "0")? "":"&nbsp;Chocolate,"?>
									<?php endif ?>
									<?php if ($re['room_edit']):?>
										<span style="color: blue;"><?php echo ($re['room_edit']['milk'] == "0")? "":"&nbsp;Milk,"?></span>	
									<?php else :?>
										<?php echo ($re['milk'] == "0")? "":"&nbsp;Milk,"?>
									<?php endif ?>
								</td>
								<td class="centered"><?php echo $re['user_name'] ?></td>
								<td class="centered non-printable">
								<a href="<?php echo base_url(); ?>amenity/view/<?php echo $re['amen_id'] ?> " class="btn btn-primary" style="width: 80px;">View</a>
								</td>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
		<?php endif; ?>
	</div>
</body>
</html>