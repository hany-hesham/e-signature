<!DOCTYPE html>
<html lang="en">
<head>
<?php $this->load->view('header'); ?>
<style type="text/css">
	@media print{
		.real{
			float: left;
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

				<h2 class="centered topic" style="display: none;"> Amenities Detail Report For Hotel <?php echo $name['name']; ?> Treatment <?php echo $treatment; ?></h2>
				<h3 class="centered topic" style="display: none;"> from <?php echo $from; ?> to <?php echo $to; ?></h3>
				<h4 class="centered"> Total of <?php echo $vip_count; ?> Gest Amenities</h4>
			</div>
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
						<?php foreach ($vip as $re): ?>
							<?php if ($re['room_edit']):?>
								<?php $total1 = $total1 + $re['room_edit']['pax']; ?>
							<?php else :?>
								<?php $total1 = $total1 + $re['pax']; ?>
							<?php endif ?>
							<?php if ($re['room_edit']):?>
								<?php $total23 = $total23 + $re['room_edit']['child']; ?>
							<?php else :?>
								<?php $total23 = $total23 + $re['child']; ?>
							<?php endif ?>
							<?php if ($re['room_edit']):?>
								<?php $total24 = $total24 + $re['room_edit']['pax'] + $re['room_edit']['child']; ?>
							<?php else :?>
								<?php $total24 = $total24 + $re['pax'] + $re['child']; ?>
							<?php endif ?>
							<?php if ($re['room_edit']):?>
								<?php if($re['room_edit']['treatment'] == "VIP (1)"){ ?>
									<?php $total37++; ?>
									<?php $total2 = $total2 + $re['room_edit']['pax']; ?>
									<?php $total25 = $total25 + $re['room_edit']['child']; ?>
									<?php $total26 = $total26 + $re['room_edit']['pax'] + $re['room_edit']['child']; ?>
								<?php }elseif ($re['room_edit']['treatment'] == "VIP (2)") { ?>
									<?php $total38++; ?>
									<?php $total3 = $total3 + $re['room_edit']['pax']; ?>
									<?php $total27 = $total27 + $re['room_edit']['child']; ?>
									<?php $total28 = $total28 + $re['room_edit']['pax'] + $re['room_edit']['child']; ?>
								<?php }elseif ($re['room_edit']['treatment'] == "VIP (3)") { ?>
									<?php $total39++; ?>
									<?php $total4 = $total4 + $re['room_edit']['pax']; ?>
									<?php $total29 = $total29 + $re['room_edit']['child']; ?>
									<?php $total30 = $total30 + $re['room_edit']['pax'] + $re['room_edit']['child']; ?>
								<?php }elseif ($re['room_edit']['treatment'] == "VIP full Treatment") { ?>
									<?php $total40++; ?>
									<?php $total5 = $total5 + $re['room_edit']['pax']; ?>
									<?php $total31 = $total31 + $re['room_edit']['child']; ?>
									<?php $total32 = $total32 + $re['room_edit']['pax'] + $re['room_edit']['child']; ?>
								<?php }elseif ($re['room_edit']['treatment'] == "Compensation") { ?>
									<?php $total41++; ?>
									<?php $total6 = $total6 + $re['room_edit']['pax']; ?>
									<?php $total33 = $total33 + $re['room_edit']['child']; ?>
									<?php $total34 = $total34 + $re['room_edit']['pax'] + $re['room_edit']['child']; ?>
								<?php }elseif ($re['room_edit']['treatment'] == "") { ?>
									<?php $total42++; ?>
									<?php $total22 = $total22 + $re['room_edit']['pax']; ?>
									<?php $total35 = $total35 + $re['room_edit']['child']; ?>
									<?php $total36 = $total36 + $re['room_edit']['pax'] + $re['room_edit']['child']; ?>
								<?php } ?>
							<?php else :?>
								<?php if($re['treatment'] == "VIP (1)"){ ?>
									<?php $total37++; ?>
									<?php $total2 = $total2 + $re['pax']; ?>
									<?php $total25 = $total25 + $re['child']; ?>
									<?php $total26 = $total26 + $re['pax'] + $re['child']; ?>
								<?php }elseif ($re['treatment'] == "VIP (2)") { ?>
									<?php $total38++; ?>
									<?php $total3 = $total3 + $re['pax']; ?>
									<?php $total27 = $total27 + $re['child']; ?>
									<?php $total28 = $total28 + $re['pax'] + $re['child']; ?>
								<?php }elseif ($re['treatment'] == "VIP (3)") { ?>
									<?php $total39++; ?>
									<?php $total4 = $total4 + $re['pax']; ?>
									<?php $total29 = $total29 + $re['child']; ?>
									<?php $total30 = $total30 + $re['pax'] + $re['child']; ?>
								<?php }elseif ($re['treatment'] == "VIP full Treatment") { ?>
									<?php $total40++; ?>
									<?php $total5 = $total5 + $re['pax']; ?>
									<?php $total31 = $total31 + $re['child']; ?>
									<?php $total32 = $total32 + $re['pax'] + $re['child']; ?>
								<?php }elseif ($re['treatment'] == "Compensation") { ?>
									<?php $total41++; ?>
									<?php $total6 = $total6 + $re['pax']; ?>
									<?php $total33 = $total33 + $re['child']; ?>
									<?php $total34 = $total34 + $re['pax'] + $re['child']; ?>
								<?php }elseif ($re['treatment'] == "") { ?>
									<?php $total42++; ?>
									<?php $total22 = $total22 + $re['pax']; ?>
									<?php $total35 = $total35 + $re['child']; ?>
									<?php $total36 = $total36 + $re['pax'] + $re['child']; ?>
								<?php } ?>
							<?php endif ?>
							<?php if ($re['room_edit']):?>
								<?php if($re['room_edit']['cookies'] == 1){ ?>
									<?php $total7++; ?>
								<?php } ?>
							<?php else :?>
								<?php if($re['cookies'] == 1){ ?>
									<?php $total7++; ?>
								<?php } ?>
							<?php endif ?>
							<?php if ($re['room_edit']):?>
								<?php if($re['room_edit']['nuts'] == 1){ ?>
									<?php $total8++; ?>
								<?php } ?>
							<?php else :?>
								<?php if($re['nuts'] == 1){ ?>
									<?php $total8++; ?>
								<?php } ?>
							<?php endif ?>
							<?php if ($re['room_edit']):?>
								<?php if($re['room_edit']['wine'] == 1){ ?>
									<?php $total9++; ?>
								<?php } ?>
							<?php else :?>
								<?php if($re['wine'] == 1){ ?>
									<?php $total9++; ?>
								<?php } ?>
							<?php endif ?>
							<?php if ($re['room_edit']):?>
								<?php if($re['room_edit']['fruit'] == 1){ ?>
									<?php $total10++; ?>
								<?php } ?>
							<?php else :?>
								<?php if($re['fruit'] == 1){ ?>
									<?php $total10++; ?>
								<?php } ?>
							<?php endif ?>
							<?php if ($re['room_edit']):?>
								<?php if($re['room_edit']['beer'] == 1){ ?>
									<?php $total11++; ?>
								<?php } ?>
							<?php else :?>
								<?php if($re['beer'] == 1){ ?>
									<?php $total11++; ?>
								<?php } ?>
							<?php endif ?>
							<?php if ($re['room_edit']):?>
								<?php if($re['room_edit']['cake'] == 1){ ?>
									<?php $total12++; ?>
								<?php } ?>
							<?php else :?>
								<?php if($re['cake'] == 1){ ?>
									<?php $total12++; ?>
								<?php } ?>
							<?php endif ?>
							<?php if ($re['room_edit']):?>
								<?php if($re['room_edit']['anniversary'] == 1){ ?>
									<?php $total13++; ?>
								<?php } ?>
							<?php else :?>
								<?php if($re['anniversary'] == 1){ ?>
									<?php $total13++; ?>
								<?php } ?>
							<?php endif ?>
							<?php if ($re['room_edit']):?>
								<?php if($re['room_edit']['honeymoon'] == 1){ ?>
									<?php $total14++; ?>
								<?php } ?>
							<?php else :?>
								<?php if($re['honeymoon'] == 1){ ?>
									<?php $total14++; ?>
								<?php } ?>
							<?php endif ?>
							<?php if ($re['room_edit']):?>
								<?php if($re['room_edit']['juices'] == 1){ ?>
									<?php $total15++; ?>
								<?php } ?>
							<?php else :?>
								<?php if($re['juices'] == 1){ ?>
									<?php $total15++; ?>
								<?php } ?>
							<?php endif ?>
							<?php if ($re['room_edit']):?>
								<?php if($re['room_edit']['dinner'] == 1){ ?>
									<?php $total16++; ?>
								<?php } ?>
							<?php else :?>
								<?php if($re['dinner'] == 1){ ?>
									<?php $total16++; ?>
								<?php } ?>
							<?php endif ?>
							<?php if ($re['room_edit']):?>
								<?php if($re['room_edit']['sick'] == 1){ ?>
									<?php $total17++; ?>
								<?php } ?>
							<?php else :?>
								<?php if($re['sick'] == 1){ ?>
									<?php $total17++; ?>
								<?php } ?>
							<?php endif ?>
							<?php if ($re['room_edit']):?>
								<?php if($re['room_edit']['alcohol'] == 1){ ?>
									<?php $total18++; ?>
								<?php } ?>
							<?php else :?>
								<?php if($re['alcohol'] == 1){ ?>
									<?php $total18++; ?>
								<?php } ?>
							<?php endif ?>
							<?php if ($re['room_edit']):?>
								<?php if($re['room_edit']['th'] == 1){ ?>
									<?php $total19++; ?>
								<?php } ?>
							<?php else :?>
								<?php if($re['th'] == 1){ ?>
									<?php $total19++; ?>
								<?php } ?>
							<?php endif ?>
							<?php if ($re['room_edit']):?>
								<?php if($re['room_edit']['uk'] == 1){ ?>
									<?php $total20++; ?>
								<?php } ?>
							<?php else :?>
								<?php if($re['uk'] == 1){ ?>
									<?php $total20++; ?>
								<?php } ?>
							<?php endif ?>
							<?php if ($re['room_edit']):?>
								<?php if($re['room_edit']['chocolate'] == 1){ ?>
									<?php $total21++; ?>
								<?php } ?>
							<?php else :?>
								<?php if($re['chocolate'] == 1){ ?>
									<?php $total21++; ?>
								<?php } ?>
							<?php endif ?>
							<?php if ($re['room_edit']):?>
								<?php if($re['room_edit']['milk'] == 1){ ?>
									<?php $total43++; ?>
								<?php } ?>
							<?php else :?>
								<?php if($re['milk'] == 1){ ?>
									<?php $total43++; ?>
								<?php } ?>
							<?php endif ?>
						<?php endforeach ?>
				<table class="table table-striped table-bordered table-condensed real" style="width:800px; position: relative;">
					<tbody>
						<tr>
							<td colspan="2" style="font-size:18px; font-weight: bolder;">Details</td>
						</tr>
						<?php if ($vip_count !=0) { ?>
							<tr>
								<td>Total No. of Guest Amenities (No. of Rooms)</td>
								<td><?php echo $vip_count?></td>
							</tr>
						<?php } ?>
						<tr>
							<td colspan="2" style="font-weight: bolder;">No. of Guest Amenities In Details</td>
						</tr>
						<?php if ($total37 !=0) { ?>
							<tr>
								<td>Total No. of Guest Amenities for VIP (1) Treatment</td>
								<td><?php echo $total37?></td>
							</tr>
						<?php } ?>
						<?php if ($total38 !=0) { ?>
							<tr>
								<td>Total No. of Guest Amenities for VIP (2) Treatment</td>
								<td><?php echo $total38?></td>
							</tr>
						<?php } ?>
						<?php if ($total39 !=0) { ?>
							<tr>
								<td>Total No. of Guest Amenities for VIP (3) Treatment</td>
								<td><?php echo $total39?></td>
							</tr>
						<?php } ?>
						<?php if ($total40 !=0) { ?>
							<tr>
								<td>Total No. of Guest Amenities for VIP full Treatment</td>
								<td><?php echo $total40?></td>
							</tr>
						<?php } ?>
						<?php if ($total41 !=0) { ?>
							<tr>
								<td>Total No. of Guest Amenities for Compensation Treatment</td>
								<td><?php echo $total41?></td>
							</tr>
						<?php } ?>
						<?php if ($total42 !=0) { ?>
							<tr>
								<td>Total No. of Guest Amenities for without VIP Treatment</td>
								<td><?php echo $total42?></td>
							</tr>
						<?php } ?>
						<?php if ($total24 !=0) { ?>
							<tr>
								<td>Total No. of Pax</td>
								<td><?php echo $total24?></td>
							</tr>
						<?php } ?>
						<?php if ($total1 !=0) { ?>
							<tr>
								<td>Total No. of Adult Pax</td>
								<td><?php echo $total1?></td>
							</tr>
						<?php } ?>
						<?php if ($total23 !=0) { ?>
							<tr>
								<td>Total No. of Child Pax</td>
								<td><?php echo $total23?></td>
							</tr>
						<?php } ?>
						<tr>
							<td colspan="2" style="font-weight: bolder;">No. of Pax In Details</td>
						</tr>
						<?php if ($total26 !=0) { ?>
							<tr>
								<td>Total No. of Pax for VIP (1) Treatment</td>
								<td><?php echo $total26?></td>
							</tr>
						<?php } ?>
						<?php if ($total2 !=0) { ?>
							<tr>
								<td>Total No. of Adult Pax for VIP (1) Treatment</td>
								<td><?php echo $total2?></td>
							</tr>
						<?php } ?>
						<?php if ($total25 !=0) { ?>
							<tr>
								<td>Total No. of Child Pax for VIP (1) Treatment</td>
								<td><?php echo $total25?></td>
							</tr>
						<?php } ?>
						<?php if ($total28 !=0) { ?>
							<tr>
								<td>Total No. of Pax for VIP (2) Treatment</td>
								<td><?php echo $total28?></td>
							</tr>
						<?php } ?>
						<?php if ($total3 !=0) { ?>
							<tr>
								<td>Total No. of Adult Pax for VIP (2) Treatment</td>
								<td><?php echo $total3?></td>
							</tr>
						<?php } ?>
						<?php if ($total27 !=0) { ?>
							<tr>
								<td>Total No. of Child Pax for VIP (2) Treatment</td>
								<td><?php echo $total27?></td>
							</tr>
						<?php } ?>
						<?php if ($total30 !=0) { ?>
							<tr>
								<td>Total No. of Pax for VIP (3) Treatment</td>
								<td><?php echo $total30?></td>
							</tr>
						<?php } ?>
						<?php if ($total4 !=0) { ?>
							<tr>
								<td>Total No. of Adult Pax for VIP (3) Treatment</td>
								<td><?php echo $total4?></td>
							</tr>
						<?php } ?>
						<?php if ($total29 !=0) { ?>
							<tr>
								<td>Total No. of Child Pax for VIP (3) Treatment</td>
								<td><?php echo $total29?></td>
							</tr>
						<?php } ?>
						<?php if ($total32 !=0) { ?>
							<tr>
								<td>Total No. of Pax for VIP full Treatment</td>
								<td><?php echo $total32?></td>
							</tr>
						<?php } ?>
						<?php if ($total5 !=0) { ?>
							<tr>
								<td>Total No. of Adult Pax for VIP full Treatment</td>
								<td><?php echo $total5?></td>
							</tr>
						<?php } ?>
						<?php if ($total31 !=0) { ?>
							<tr>
								<td>Total No. of Child Pax for VIP full Treatment</td>
								<td><?php echo $total31?></td>
							</tr>
						<?php } ?>
						<?php if ($total34 !=0) { ?>
							<tr>
								<td>Total No. of Pax for Compensation Treatment</td>
								<td><?php echo $total34?></td>
							</tr>
						<?php } ?>
						<?php if ($total6 !=0) { ?>
							<tr>
								<td>Total No. of Adult Pax for Compensation Treatment</td>
								<td><?php echo $total6?></td>
							</tr>
						<?php } ?>
						<?php if ($total33 !=0) { ?>
							<tr>
								<td>Total No. of Child Pax for Compensation Treatment</td>
								<td><?php echo $total33?></td>
							</tr>
						<?php } ?>
						<?php if ($total36 !=0) { ?>
							<tr>
								<td>Total No. of Pax without VIP Treatment</td>
								<td><?php echo $total36?></td>
							</tr>
						<?php } ?>
						<?php if ($total22 !=0) { ?>
							<tr>
								<td>Total No. of Adult Pax without VIP Treatment</td>
								<td><?php echo $total22?></td>
							</tr>
						<?php } ?>
						<?php if ($total35 !=0) { ?>
							<tr>
								<td>Total No. of Child Pax without VIP Treatment</td>
								<td><?php echo $total35?></td>
							</tr>
						<?php } ?>
						<tr>
							<td colspan="2" style="font-weight: bolder;">Amenities In Details</td>
						</tr>
						<?php if ($total7 !=0) { ?>
							<tr>
								<td>Total No. of Cookies</td>
								<td><?php echo $total7?></td>
							</tr>
						<?php } ?>
						<?php if ($total8 !=0) { ?>
							<tr>
								<td>Total No. of Nuts</td>
								<td><?php echo $total8?></td>
							</tr>
						<?php } ?>
						<?php if ($total9 !=0) { ?>
							<tr>
								<td>Total No. of Bottle Of Wine</td>
								<td><?php echo $total9?></td>
							</tr>
						<?php } ?>
						<?php if ($total10 !=0) { ?>
							<tr>
								<td>Total No. of Fruit Basket</td>
								<td><?php echo $total10?></td>
							</tr>
						<?php } ?>
						<?php if ($total11 !=0) { ?>
							<tr>
								<td>Total No. of Beer</td>
								<td><?php echo $total11?></td>
							</tr>
						<?php } ?>
						<?php if ($total12 !=0) { ?>
							<tr>
								<td>Total No. of Birthday Cake</td>
								<td><?php echo $total12?></td>
							</tr>
						<?php } ?>
						<?php if ($total13 !=0) { ?>
							<tr>
								<td>Total No. of Anniversary</td>
								<td><?php echo $total13?></td>
							</tr>
						<?php } ?>
						<?php if ($total14 !=0) { ?>
							<tr>
								<td>Total No. of Honeymoon</td>
								<td><?php echo $total14?></td>
							</tr>
						<?php } ?>
						<?php if ($total15 !=0) { ?>
							<tr>
								<td>Total No. of Small Can of Juices</td>
								<td><?php echo $total15?></td>
							</tr>
						<?php } ?>
						<?php if ($total16 !=0) { ?>
							<tr>
								<td>Total No. of Candel Light Dinner</td>
								<td><?php echo $total16?></td>
							</tr>
						<?php } ?>
						<?php if ($total17 !=0) { ?>
							<tr>
								<td>Total No. of Sick Meal</td>
								<td><?php echo $total17?></td>
							</tr>
						<?php } ?>
						<?php if ($total18 !=0) { ?>
							<tr>
								<td>Total No. of Without Alcohol</td>
								<td><?php echo $total18?></td>
							</tr>
						<?php } ?>
						<?php if ($total19 !=0) { ?>
							<tr>
								<td>Total No. of TH Bonus</td>
								<td><?php echo $total19?></td>
							</tr>
						<?php } ?>
						<?php if ($total20 !=0) { ?>
							<tr>
								<td>Total No. of TC UK arrival</td>
								<td><?php echo $total20?></td>
							</tr>
						<?php } ?>
						<?php if ($total21 !=0) { ?>
							<tr>
								<td>Total No. of Chocolate</td>
								<td><?php echo $total21?></td>
							</tr>
						<?php } ?>
						<?php if ($total43 !=0) { ?>
							<tr>
								<td>Total No. of Milk</td>
								<td><?php echo $total43?></td>
							</tr>
						<?php } ?>					
					</tbody>
				</table>
		<?php endif; ?>
	</div>
</body>
</html>