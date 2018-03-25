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
					<?php $this->load->view('amenitys_report_menu_all'); ?>
				</fieldset>
			</div>
			<?php if (isset($treatment)): ?>	
				<div class="centered">
					<?php if(isset($treatment['name']) && $treatment['name']){ ?>
						<h2 class="centered topic" style="display: none;"> Amenities Report For Treatment <?php echo $treatment['name']; ?></h2>
					<?php } ?>
					<h3 class="centered topic" style="display: none;"> from <?php echo $from; ?> to <?php echo $to; ?></h3>
					<h4 class="centered"> Total of <?php echo $items_count; ?> Rooms</h4>
				</div>
				<br>
				<br>
				<br>
				<div class="centered">
					<?php $total1 =0; ?>
					<?php $total2 =0; ?>
					<?php $total3 =0; ?>
					<?php $total4 =0; ?>
					<?php $total5 =0; ?>
					<?php $total6 =0; ?>
					<?php $total7 =0; ?>
					<?php $total8 =0; ?>
					<?php $total9 =0; ?>
					<?php $total10 =0; ?>
					<?php $total11 =0; ?>
					<?php $total12 =0; ?>
					<?php $total13 =0; ?>
					<?php $total14 =0; ?>
					<?php $total15 =0; ?>
					<?php $total16 =0; ?>
					<?php $total17 =0; ?>
					<?php $total18 =0; ?>
					<?php $total19 =0; ?>
					<?php $total20 =0; ?>
					<?php $total21 =0; ?>
					<?php $total22 =0; ?>
					<?php $total23 =0; ?>
					<?php $total24 =0; ?>
					<?php $total25 =0; ?>
					<?php $total26 =0; ?>
					<?php $total27 =0; ?>
					<?php $total28 =0; ?>
					<?php $total29 =0; ?>
					<?php $total30 =0; ?>
					<?php $total31 =0; ?>
					<?php $total32 =0; ?>
					<?php $total33 =0; ?>
					<?php $total34 =0; ?>
					<?php $total35 =0; ?>
					<?php $total36 =0; ?>
					<?php $total37 =0; ?>
					<?php $total38 =0; ?>
					<?php $total39 =0; ?>
					<?php $total40 =0; ?>
					<?php $total41 =0; ?>
					<?php $total42 =0; ?>
					<?php $total43 =0; ?>
					<?php $total44 =0; ?>
					<?php $total45 =0; ?>
					<?php $total46 =0; ?>
					<?php foreach ($items as $item): ?>
						<?php $total1 = $total1 + $item['pax']; ?>
						<?php $total2 = $total2 + $item['child']; ?>
						<?php $total3 = $total3 + $item['pax'] + $item['child']; ?>
						<?php if($item['treatment_id'] == 1){ ?>
							<?php $total46++; ?>
							<?php $total4 = $total4 + $item['pax']; ?>
							<?php $total5 = $total5 + $item['child']; ?>
							<?php $total6 = $total6 + $item['pax'] + $item['child']; ?>
						<?php }elseif ($item['treatment_id'] == 2) { ?>
							<?php $total7++; ?>
							<?php $total8 = $total8 + $item['pax']; ?>
							<?php $total9 = $total9 + $item['child']; ?>
							<?php $total10 = $total10 + $item['pax'] + $item['child']; ?>
						<?php }elseif ($item['treatment_id'] == 3) { ?>
							<?php $total11++; ?>
							<?php $total12 = $total12 + $item['pax']; ?>
							<?php $total13 = $total13 + $item['child']; ?>
							<?php $total14 = $total14 + $item['pax'] + $item['child']; ?>
						<?php }elseif ($item['treatment_id'] == 4) { ?>
							<?php $total15++; ?>
							<?php $total16 = $total16 + $item['pax']; ?>
							<?php $total17 = $total17 + $item['child']; ?>
							<?php $total18 = $total18 + $item['pax'] + $item['child']; ?>
						<?php }elseif ($item['treatment_id'] == 5) { ?>
							<?php $total19++; ?>
							<?php $total20 = $total20 + $item['pax']; ?>
							<?php $total21 = $total21 + $item['child']; ?>
							<?php $total22 = $total22 + $item['pax'] + $item['child']; ?>
						<?php }elseif ($item['treatment_id'] == "") { ?>
							<?php $total23++; ?>
							<?php $total24 = $total24 + $item['pax']; ?>
							<?php $total25 = $total25 + $item['child']; ?>
							<?php $total26 = $total26 + $item['pax'] + $item['child']; ?>
						<?php } ?>
						<?php foreach ($item['others'] as $other): ?>
							<?php if($other['other_id'] == 1){ ?>
								<?php $total27++; ?>
							<?php } ?>
							<?php if($other['other_id'] == 2){ ?>
								<?php $total28++; ?>
							<?php } ?>
							<?php if($other['other_id'] == 3){ ?>
								<?php $total29++; ?>
							<?php } ?>
							<?php if($other['other_id'] == 4){ ?>
								<?php $total30++; ?>
							<?php } ?>
							<?php if($other['other_id'] == 5){ ?>
								<?php $total31++; ?>
							<?php } ?>
							<?php if($other['other_id'] == 6){ ?>
								<?php $total32++; ?>
							<?php } ?>
							<?php if($other['other_id'] == 7){ ?>
								<?php $total33++; ?>
							<?php } ?>
							<?php if($other['other_id'] == 8){ ?>
								<?php $total34++; ?>
							<?php } ?>
							<?php if($other['other_id'] == 9){ ?>
								<?php $total35++; ?>
							<?php } ?>
							<?php if($other['other_id'] == 10){ ?>
								<?php $total36++; ?>
							<?php } ?>
							<?php if($other['other_id'] == 11){ ?>
								<?php $total37++; ?>
							<?php } ?>
							<?php if($other['other_id'] == 12){ ?>
								<?php $total38++; ?>
							<?php } ?>
							<?php if($other['other_id'] == 13){ ?>
								<?php $total39++; ?>
							<?php } ?>
							<?php if($other['other_id'] == 14){ ?>
								<?php $total40++; ?>
							<?php } ?>
							<?php if($other['other_id'] == 15){ ?>
								<?php $total41++; ?>
							<?php } ?>
							<?php if($other['other_id'] == 16){ ?>
								<?php $total42++; ?>
							<?php } ?>
							<?php if($other['other_id'] == 17){ ?>
								<?php $total43++; ?>
							<?php } ?>
							<?php if($other['other_id'] == 18){ ?>
								<?php $total44++; ?>
							<?php } ?>
							<?php if($other['other_id'] == 19){ ?>
								<?php $total45++; ?>
							<?php } ?>
						<?php endforeach ?>
					<?php endforeach ?>
					<table class="table table-striped table-bordered table-condensed real" style="width:800px; position: relative;">
						<tbody>
							<tr>
								<td colspan="2" style="font-size:18px; font-weight: bolder;">Details</td>
							</tr>
							<?php if ($items_count !=0) { ?>
								<tr>
									<td>Total No. of Guest Amenities (No. of Rooms)</td>
									<td><?php echo $items_count?></td>
								</tr>
							<?php } ?>
							<tr>
								<td colspan="2" style="font-weight: bolder;">No. of Guest Amenities In Details</td>
							</tr>
							<?php if ($total46 !=0) { ?>
								<tr>
									<td>Total No. of Guest Amenities for VIP (1) Treatment</td>
									<td><?php echo $total46?></td>
								</tr>
							<?php } ?>
							<?php if ($total7 !=0) { ?>
								<tr>
									<td>Total No. of Guest Amenities for VIP (2) Treatment</td>
									<td><?php echo $total7?></td>
								</tr>
							<?php } ?>
							<?php if ($total11 !=0) { ?>
								<tr>
									<td>Total No. of Guest Amenities for VIP (3) Treatment</td>
									<td><?php echo $total11?></td>
								</tr>
							<?php } ?>
							<?php if ($total15 !=0) { ?>
								<tr>
									<td>Total No. of Guest Amenities for VIP full Treatment</td>
									<td><?php echo $total15?></td>
								</tr>
							<?php } ?>
							<?php if ($total19 !=0) { ?>
								<tr>
									<td>Total No. of Guest Amenities for Compensation Treatment</td>
									<td><?php echo $total19?></td>
								</tr>
							<?php } ?>
							<?php if ($total23 !=0) { ?>
								<tr>
									<td>Total No. of Guest Amenities for without VIP Treatment</td>
									<td><?php echo $total23?></td>
								</tr>
							<?php } ?>
							<?php if ($total3 !=0) { ?>
								<tr>
									<td>Total No. of Pax</td>
									<td><?php echo $total3?></td>
								</tr>
							<?php } ?>
							<?php if ($total1 !=0) { ?>
								<tr>
									<td>Total No. of Adult Pax</td>
									<td><?php echo $total1?></td>
								</tr>
							<?php } ?>
							<?php if ($total2 !=0) { ?>
								<tr>
									<td>Total No. of Child Pax</td>
									<td><?php echo $total2?></td>
								</tr>
							<?php } ?>
							<tr>
								<td colspan="2" style="font-weight: bolder;">No. of Pax In Details</td>
							</tr>
							<?php if ($total6 !=0) { ?>
								<tr>
									<td>Total No. of Pax for VIP (1) Treatment</td>
									<td><?php echo $total6?></td>
								</tr>
							<?php } ?>
							<?php if ($total4 !=0) { ?>
								<tr>
									<td>Total No. of Adult Pax for VIP (1) Treatment</td>
									<td><?php echo $total4?></td>
								</tr>
							<?php } ?>
							<?php if ($total5 !=0) { ?>
								<tr>
									<td>Total No. of Child Pax for VIP (1) Treatment</td>
									<td><?php echo $total5?></td>
								</tr>
							<?php } ?>
							<?php if ($total10 !=0) { ?>
								<tr>
									<td>Total No. of Pax for VIP (2) Treatment</td>
									<td><?php echo $total10?></td>
								</tr>
							<?php } ?>
							<?php if ($total8 !=0) { ?>
								<tr>
									<td>Total No. of Adult Pax for VIP (2) Treatment</td>
									<td><?php echo $total8?></td>
								</tr>
							<?php } ?>
							<?php if ($total9 !=0) { ?>
								<tr>
									<td>Total No. of Child Pax for VIP (2) Treatment</td>
									<td><?php echo $total9?></td>
								</tr>
							<?php } ?>
							<?php if ($total14 !=0) { ?>
								<tr>
									<td>Total No. of Pax for VIP (3) Treatment</td>
									<td><?php echo $total14?></td>
								</tr>
							<?php } ?>
							<?php if ($total12 !=0) { ?>
								<tr>
									<td>Total No. of Adult Pax for VIP (3) Treatment</td>
									<td><?php echo $total12?></td>
								</tr>
							<?php } ?>
							<?php if ($total13 !=0) { ?>
								<tr>
									<td>Total No. of Child Pax for VIP (3) Treatment</td>
									<td><?php echo $total13?></td>
								</tr>
							<?php } ?>
							<?php if ($total18 !=0) { ?>
								<tr>
									<td>Total No. of Pax for VIP full Treatment</td>
									<td><?php echo $total18?></td>
								</tr>
							<?php } ?>
							<?php if ($total16 !=0) { ?>
								<tr>
									<td>Total No. of Adult Pax for VIP full Treatment</td>
									<td><?php echo $total16?></td>
								</tr>
							<?php } ?>
							<?php if ($total17 !=0) { ?>
								<tr>
									<td>Total No. of Child Pax for VIP full Treatment</td>
									<td><?php echo $total17?></td>
								</tr>
							<?php } ?>
							<?php if ($total22 !=0) { ?>
								<tr>
									<td>Total No. of Pax for Compensation Treatment</td>
									<td><?php echo $total22?></td>
								</tr>
							<?php } ?>
							<?php if ($total20 !=0) { ?>
								<tr>
									<td>Total No. of Adult Pax for Compensation Treatment</td>
									<td><?php echo $total20?></td>
								</tr>
							<?php } ?>
							<?php if ($total21 !=0) { ?>
								<tr>
									<td>Total No. of Child Pax for Compensation Treatment</td>
									<td><?php echo $total21?></td>
								</tr>
							<?php } ?>
							<?php if ($total26 !=0) { ?>
								<tr>
									<td>Total No. of Pax without VIP Treatment</td>
									<td><?php echo $total26?></td>
								</tr>
							<?php } ?>
							<?php if ($total24 !=0) { ?>
								<tr>
									<td>Total No. of Adult Pax without VIP Treatment</td>
									<td><?php echo $total24?></td>
								</tr>
							<?php } ?>
							<?php if ($total25 !=0) { ?>
								<tr>
									<td>Total No. of Child Pax without VIP Treatment</td>
									<td><?php echo $total25?></td>
								</tr>
							<?php } ?>
							<tr>
								<td colspan="2" style="font-weight: bolder;">Amenities In Details</td>
							</tr>
							<?php if ($total27 !=0) { ?>
								<tr>
									<td>Total No. of Cookies</td>
									<td><?php echo $total27?></td>
								</tr>
							<?php } ?>
							<?php if ($total28 !=0) { ?>
								<tr>
									<td>Total No. of Nuts</td>
									<td><?php echo $total28?></td>
								</tr>
							<?php } ?>
							<?php if ($total29 !=0) { ?>
								<tr>
									<td>Total No. of Bottle Of Wine</td>
									<td><?php echo $total29?></td>
								</tr>
							<?php } ?>
							<?php if ($total30 !=0) { ?>
								<tr>
									<td>Total No. of Fruit Basket</td>
									<td><?php echo $total30?></td>
								</tr>
							<?php } ?>
							<?php if ($total31 !=0) { ?>
								<tr>
									<td>Total No. of Beer</td>
									<td><?php echo $total31?></td>
								</tr>
							<?php } ?>
							<?php if ($total32 !=0) { ?>
								<tr>
									<td>Total No. of Birthday Cake</td>
									<td><?php echo $total32?></td>
								</tr>
							<?php } ?>
							<?php if ($total33 !=0) { ?>
								<tr>
									<td>Total No. of Anniversary</td>
									<td><?php echo $total33?></td>
								</tr>
							<?php } ?>
							<?php if ($total34 !=0) { ?>
								<tr>
									<td>Total No. of Honeymoon</td>
									<td><?php echo $total34?></td>
								</tr>
							<?php } ?>
							<?php if ($total35 !=0) { ?>
								<tr>
									<td>Total No. of Small Can of Juices</td>
									<td><?php echo $total35?></td>
								</tr>
							<?php } ?>
							<?php if ($total36 !=0) { ?>
								<tr>
									<td>Total No. of Candel Light Dinner</td>
									<td><?php echo $total36?></td>
								</tr>
							<?php } ?>
							<?php if ($total37 !=0) { ?>
								<tr>
									<td>Total No. of Sick Meal</td>
									<td><?php echo $total37?></td>
								</tr>
							<?php } ?>
							<?php if ($total38 !=0) { ?>
								<tr>
									<td>Total No. of Without Alcohol</td>
									<td><?php echo $total38?></td>
								</tr>
							<?php } ?>
							<?php if ($total39 !=0) { ?>
								<tr>
									<td>Total No. of TH Bonus</td>
									<td><?php echo $total39?></td>
								</tr>
							<?php } ?>
							<?php if ($total40 !=0) { ?>
								<tr>
									<td>Total No. of TC UK arrival</td>
									<td><?php echo $total40?></td>
								</tr>
							<?php } ?>
							<?php if ($total41 !=0) { ?>
								<tr>
									<td>Total No. of Chocolate</td>
									<td><?php echo $total41?></td>
								</tr>
							<?php } ?>
							<?php if ($total42 !=0) { ?>
								<tr>
									<td>Total No. of Milk</td>
									<td><?php echo $total42?></td>
								</tr>
							<?php } ?>	
							<?php if ($total43 !=0) { ?>
								<tr>
									<td>Total No. of Honeymooner cake</td>
									<td><?php echo $total43?></td>
								</tr>
							<?php } ?>	
							<?php if ($total44 !=0) { ?>
								<tr>
									<td>Total No. of Diet Cola</td>
									<td><?php echo $total44?></td>
								</tr>
							<?php } ?>	
							<?php if ($total45 !=0) { ?>
								<tr>
									<td>Total No. of Diet Sprite</td>
									<td><?php echo $total45?></td>
								</tr>
							<?php } ?>					
						</tbody>
					</table>
				</div>
			<?php endif; ?>
		</div>
	</body>
</html>