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
					<?php $this->load->view('amenitys_state_report_menu'); ?>
				</fieldset>
			</div>
			<?php if (isset($forms)): ?>	
				<div class="centered">
					<h4 class="centered"> Total of <?php echo $forms_count; ?> forms for Hotel <?php echo $hotel['name']?></h4>
				</div>
				<br>
				<br>
				<br>
				<div class="centered">						
					<table class="table table-striped table-bordered table-condensed real" style="width:; position: relative;">
						<tbody>
							<tr>
								<td colspan="3" style="font-size:18px; font-weight: bolder;">Details</td>
								<td colspan="1" class="non-printable"></td>
							</tr>
							<?php if ($forms_count !=0) { ?>
								<tr>
									<td>Total No. of Guest Amenities  Forms</td>
									<td colspan="2"><?php echo $forms_count?></td>
									<td colspan="1" class="non-printable"></td>
								</tr>
							<?php } ?>
							<?php foreach ($forms as $form): ?>
								<tr>
									<td><?php echo $form['id']?></td>
									<td>
										<?php foreach ($form['items'] as $item):?>
				                          <?php if ($item['amen']){ ?>
				                            <span style="font-weight: bold; color: blue;">
				                              <?php echo $item['amen']['room_new'] ?>,
				                            </span>
				                          <?php }else{ ?>
				                            <span style="font-weight: bold;">
				                              <?php echo $item['room'] ?>,
				                            </span>
				                          <?php } ?>
				                        <?php endforeach ?>  
									</td>
									<td><?php echo $form['timestamp']?></td>
									<td class="non-printable">
				                        <a href="<?php echo base_url(); ?>amenitys/view/<?php echo $form['id'] ?> " class="btn btn-primary non-printable" style="width: 80px;">View</a>
				                    </td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			<?php endif; ?>
		</div>
	</body>
</html>