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
					<legend class="title-table non-printable">Amenity Report</legend>
					<?php $this->load->view('amenitys_refl_report_menu_all'); ?>
				</fieldset>
			</div>
			<?php if (isset($from)): ?>	
				<div class="centered">
					<h2 class="centered topic" style="display: none;"> Amenities Report For Refilling</h2>
					<h3 class="centered topic" style="display: none;"> from <?php echo $from; ?> to <?php echo $to; ?></h3>
					<h4 class="centered"> Total of <?php echo $items_count; ?> Rooms</h4>
				</div>
				<br>
				<br>
				<br>
				<div class="centered">
					<table class="table table-striped table-bordered table-condensed real" style="width:2000px;">
						<tbody>
							<tr>
								<th style="width: 100px;" colspan="1" rowspan="2" class="centered">ID#</th>
								<th style="width: 200px;" colspan="1" rowspan="2" class="centered">Hotel</th>
								<th style="width: 200px;" colspan="1" rowspan="2" class="centered">Delivery Date & Time</th>
								<th style="width: 200px;" colspan="2" rowspan="2" class="centered">Room</th>
								<th style="width: 200px;" colspan="1" rowspan="2" class="centered">Guest</th>
								<th style="width: 200px;" colspan="2" rowspan="1" class="centered">No. Of Pax</th>
								<th style="width: 200px;" colspan="1" rowspan="2" class="centered">Treatment</th>
								<th style="width: 200px;" colspan="1" rowspan="2" class="centered">Reason</th>
								<th style="width: 200px;" colspan="1" rowspan="2" class="centered">Location</th>
								<th style="width: 200px;" colspan="1" rowspan="2" class="centered">Amenities</th>
								<th style="width: 200px;" colspan="1" rowspan="2" class="centered">creator</th>
								<th style="width: 100px;" colspan="1" rowspan="2" class="centered non-printable">View</th>
							</tr>
							<tr>
								<th style="width: 100px;" colspan="1" rowspan="1" class="centered">Adult</th>
								<th style="width: 100px;" colspan="1" rowspan="1" class="centered">Child</th>
							</tr>
							<?php foreach ($items as $item): ?>
								<tr>
									<td class="centered"><?php echo $item['id'] ?></td>
									<td class="centered"><?php echo $item['hotel_name'] ?></td>
									<td class="centered"><?php echo $item['date_time'] ?></td>
									<?php if ($item['amenit']):?>
										<td class="centered" colspan="1"><?php echo $item['amenit']['room_old']; ?></td>
										<td class="centered" colspan="1"><span style="color: blue;"><?php echo $item['amenit']['room_new']; ?></span></td>
									<?php else :?>
										<td class="centered" colspan="2"><?php echo $item['room'] ?></td>
									<?php endif ?>
									<td class="centered"><?php echo $item['guest'] ?></td>
									<td class="centered"><?php echo $item['pax'] ?></td>
									<td class="centered"><?php echo $item['child'] ?></td>
									<td class="centered"><?php echo $item['treatment_type'] ?></td>
									<td class="centered"><?php echo $item['reason'] ?></td>
									<td class="centered"><?php echo $item['location'] ?></td>
									<td class="centered">
										<?php foreach ($item['others'] as $other): ?>
											<?php echo $other['other_name']; ?>,
										<?php endforeach ?>
									</td>
									<td class="centered"><?php echo $item['user_name'] ?></td>
									<td class="centered non-printable">
										<a href="<?php echo base_url(); ?>amenitys/view/<?php echo $item['amen_id'] ?> " class="btn btn-primary" style="width: 80px;">View</a>
									</td>
								</tr>
							<?php endforeach ?>
						</tbody>
					</table>
				</div>
			<?php endif; ?>
		</div>
	</body>
</html>