<!DOCTYPE html>
<html lang="en">
<head>
<?php $this->load->view('header'); ?>
<style type="text/css">
	@media print{		
		.topic{
			display: block !important;
		}
	}
</style>
</head>
<body>
<div id="wrapper">
	<?php $this->load->view('menu') ?>
	<div id="page-wrapper">
	<button onclick="window.print()" class="non-printable form-actions btn btn-success" href="" >Print</button>
    <a class="form-actions btn btn-success non-printable" href="/fo_report" style="float:right;" > Back </a>
	<div class="container">
		<div class="rest-selector col-lg-12 col-md-12 col-sm-12 col-xs-12 non-printable">
			<fieldset>
			<legend class="title-table">Amenity summary</legend>
					<?php $this->load->view('amenity_type_report_menu_all'); ?>
			</fieldset>
		</div>
		<?php if (isset($amenity)): ?>	

			<h1 class="centered topic" style="display: none;"> Amenities summary of Type <?php echo $type; ?> </h1>
			<h2 class="centered topic" style="display: none;"> from <?php echo $from; ?> to <?php echo $to; ?></h2>
			<?php $del = 0; ?>
			<?php foreach ($amenity as $amenit): ?>
				<?php foreach ($amenit['items'] as $item): ?>
					<?php $del ++; ?>
				<?php endforeach ?>
			<?php endforeach ?>
			<h3 class="centered"> Total of <?php echo $del; ?> Amenities Marked as <?php echo $type; ?></h3>
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
							<th style="width: 150px;" colspan="1" rowspan="2" class="centered">Marked By</th>
							<th style="width: 150px;" colspan="1" rowspan="2" class="centered">Type</th>
						</tr>
						<tr>
							<th style="width: 100px;" colspan="1" rowspan="1" class="centered">Adult</th>
							<th style="width: 100px;" colspan="1" rowspan="1" class="centered">Child</th>
						</tr>
						<?php foreach ($amenity as $amenit): ?>
							<?php foreach ($amenit['items'] as $item): ?>
								<tr>
									<td class="centered"><?php echo $item['amen_id'] ?></td>
									<?php if ($item['amenitys']):?>
										<td class="centered" colspan="1"><?php echo $item['amenitys']['room_old']; ?></td>
										<td class="centered" colspan="1"><span style="color: blue;"><?php echo $item['amenitys']['room_new']; ?></span></td>
									<?php else :?>
										<td class="centered" colspan="2"><?php echo $item['room'] ?></td>
									<?php endif ?>
									<?php if ($item['amenitys_edit']):?>
										<td class="centered"><span style="color: blue;"><?php echo $item['amenitys_edit']['date_time'] ?></span></td>
									<?php else :?>
										<td class="centered"><?php echo $amenit['date_time'] ?></td>
									<?php endif ?>
									<?php if ($item['room_edit']):?>
										<td class="centered"><span style="color: blue;"><?php echo $item['room_edit']['guest'] ?></span></td>
									<?php else :?>
										<td class="centered"><?php echo $item['guest'] ?></td>
									<?php endif ?>
									<?php if ($item['room_edit']):?>
										<td class="centered"><span style="color: blue;"><?php echo $item['room_edit']['pax'] ?></span></td>
									<?php else :?>
										<td class="centered"><?php echo $item['pax'] ?></td>
									<?php endif ?>
									<?php if ($item['room_edit']):?>
										<td class="centered"><span style="color: blue;"><?php echo $item['room_edit']['child'] ?></span></td>
									<?php else :?>
										<td class="centered"><?php echo $item['child'] ?></td>
									<?php endif ?>
									<?php if ($item['room_edit']):?>
										<td class="centered"><span style="color: blue;"><?php echo $item['room_edit']['treatment'] ?></span></td>
									<?php else :?>
										<td class="centered"><?php echo $item['treatment'] ?></td>
									<?php endif ?>
									<?php if ($item['amenitys_edit']):?>
										<td class="centered"><span style="color: blue;"><?php echo $item['amenitys_edit']['reason'] ?></span></td>
									<?php else :?>
										<td class="centered"><?php echo $amenit['reason'] ?></td>
									<?php endif ?>
									<td class="centered">
										<?php if ($item['room_edit']):?>
											<span style="color: blue;"><?php echo ($item['room_edit']['cookies'] == "0")? "":"&nbsp;Cookies,"?></span>	
										<?php else :?>
											<?php echo ($item['cookies'] == "0")? "":"&nbsp;Cookies,"?>
										<?php endif ?>
										<?php if ($item['room_edit']):?>
											<span style="color: blue;"><?php echo ($item['room_edit']['nuts'] == "0")? "":"&nbsp;Nuts,"?></span>	
										<?php else :?>
											<?php echo ($item['nuts'] == "0")? "":"&nbsp;Nuts,"?>
										<?php endif ?>
										<?php if ($item['room_edit']):?>
											<span style="color: blue;"><?php echo ($item['room_edit']['wine'] == "0")? "":"&nbsp;Bottle Of Wine,"?></span>	
										<?php else :?>
											<?php echo ($item['wine'] == "0")? "":"&nbsp;Bottle Of Wine,"?>
										<?php endif ?>
										<?php if ($item['room_edit']):?>
											<span style="color: blue;"><?php echo ($item['room_edit']['fruit'] == "0")? "":"&nbsp;Fruit Basket,"?></span>	
										<?php else :?>
											<?php echo ($item['fruit'] == "0")? "":"&nbsp;Fruit Basket,"?>
										<?php endif ?>
										<?php if ($item['room_edit']):?>
											<span style="color: blue;"><?php echo ($item['room_edit']['beer'] == "0")? "":"&nbsp;Beer,"?></span>	
										<?php else :?>
											<?php echo ($item['beer'] == "0")? "":"&nbsp;Beer,"?>
										<?php endif ?>
										<?php if ($item['room_edit']):?>
											<span style="color: blue;"><?php echo ($item['room_edit']['cake'] == "0")? "":"&nbsp;Birthday Cake,"?></span>	
										<?php else :?>
											<?php echo ($item['cake'] == "0")? "":"&nbsp;Birthday Cake,"?>
										<?php endif ?>
										<?php if ($item['room_edit']):?>
											<span style="color: blue;"><?php echo ($item['room_edit']['anniversary'] == "0")? "":"&nbsp;Anniversary,"?></span>	
										<?php else :?>
											<?php echo ($item['anniversary'] == "0")? "":"&nbsp;Anniversary,"?>
										<?php endif ?>
										<?php if ($item['room_edit']):?>
											<span style="color: blue;"><?php echo ($item['room_edit']['honeymoon'] == "0")? "":"&nbsp;Honeymoon,"?></span>	
										<?php else :?>
											<?php echo ($item['honeymoon'] == "0")? "":"&nbsp;Honeymoon,"?>
										<?php endif ?>
										<?php if ($item['room_edit']):?>
											<span style="color: blue;"><?php echo ($item['room_edit']['juices'] == "0")? "":"&nbsp;Small Can of Juices,"?></span>	
										<?php else :?>
											<?php echo ($item['juices'] == "0")? "":"&nbsp;Small Can of Juices,"?>
										<?php endif ?>
										<?php if ($item['room_edit']):?>
											<span style="color: blue;"><?php echo ($item['room_edit']['dinner'] == "0")? "":"&nbsp;Candel Light Dinner,"?></span>	
										<?php else :?>
											<?php echo ($item['dinner'] == "0")? "":"&nbsp;Candel Light Dinner,"?>
										<?php endif ?>
										<?php if ($item['room_edit']):?>
											<span style="color: blue;"><?php echo ($item['room_edit']['sick'] == "0")? "":"&nbsp;Sick Meal,"?></span>	
										<?php else :?>
											<?php echo ($item['sick'] == "0")? "":"&nbsp;Sick Meal,"?>
										<?php endif ?>
										<?php if ($item['room_edit']):?>
											<span style="color: blue;"><?php echo ($item['room_edit']['alcohol'] == "0")? "":"&nbsp;Without Alcohol,"?></span>	
										<?php else :?>
											<?php echo ($item['alcohol'] == "0")? "":"&nbsp;Without Alcohol,"?>
										<?php endif ?>
										<?php if ($item['room_edit']):?>
											<span style="color: blue;"><?php echo ($item['room_edit']['th'] == "0")? "":"&nbsp;TH Bonus,"?></span>	
										<?php else :?>
											<?php echo ($item['th'] == "0")? "":"&nbsp;TH Bonus,"?>
										<?php endif ?>
										<?php if ($item['room_edit']):?>
											<span style="color: blue;"><?php echo ($item['room_edit']['uk'] == "0")? "":"&nbsp;TC UK arrival,"?></span>	
										<?php else :?>
											<?php echo ($item['uk'] == "0")? "":"&nbsp;TC UK arrival,"?>
										<?php endif ?>
										<?php if ($item['room_edit']):?>
											<span style="color: blue;"><?php echo ($item['room_edit']['chocolate'] == "0")? "":"&nbsp;Chocolate,"?></span>	
										<?php else :?>
											<?php echo ($item['chocolate'] == "0")? "":"&nbsp;Chocolate,"?>
										<?php endif ?>
										<?php if ($item['room_edit']):?>
											<span style="color: blue;"><?php echo ($item['room_edit']['milk'] == "0")? "":"&nbsp;Milk,"?></span>	
										<?php else :?>
											<?php echo ($item['milk'] == "0")? "":"&nbsp;Milk,"?>
										<?php endif ?>
									</td>
									<td class="centered"><?php echo $amenit['user_name'] ?></td>
									<td class="centered">
										<?php if($amenit['type'] == "1" ){ 
											echo "Retoure"; 
										}elseif($amenit['type'] == "2" ){ 
											echo "Cancelled";
										}elseif($amenit['type'] == "3" ){
											echo "No Show";
										}elseif($amenit['type'] == "4" ){ 
											echo "Delivered";
										}elseif($amenit['type'] == "5" ){
											echo "Expacted Arrival";
										}else{
											echo "In House"; 
										}?>
									</td>
								</tr>
							<?php endforeach ?>
						<?php endforeach ?>
					</tbody>
				</table>
			</div>
		<?php endif; ?>
	</div>
</div>
</body>
</html>