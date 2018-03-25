<!DOCTYPE html>
<html lang="en">
<head>
<?php $this->load->view('header'); ?>
	<style type="text/css">
		@media print{
			.noprint{
				display: none;
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
	<div id="page-wrapper">
	<button onclick="window.print()" class="non-printable form-actions btn btn-success" href="" >Print</button>
	<div class="container">
		<div class="rest-selector col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<fieldset>
			<legend class="title-table">Workshop Delay Requests</legend>
				<?php $this->load->view('workshop_delay_report_form'); ?>
			</fieldset>
		</div>
		</div>
		<?php if (isset($posting)): ?>
			<div class="centered topic" style="display: none;">
				<?php if (isset($hotel)): ?>
					<div class="centered header-logo" ><img src="/assets/uploads/logos/<?php echo $hotel['logo']; ?>"/></div>
					<h1 class="centered"> <?php echo $hotel['name']; ?> </h1>
				<?php else: ?>
					<h1 class="centered"> All Hotels </h1>
				<?php endif; ?>
				<?php if (isset($from) && isset($to)): ?>
					<h3 class="centered">From <?php echo $from; ?> To <?php echo $to; ?></h3>
				<?php else: ?>
					<h3 class="centered"> All Forms </h3>
				<?php endif; ?>
			</div>
			<div class="title-table"></div>
			<table class="report-view-large" style="width:100%;">
			<thead>
				<tr>
					<td style="text-align:center;">Items</td>
					<td style="text-align:center;">Hotel</td>
					<td style="text-align:center;">Date</td>
					<td style="text-align:center;">Delay</td>
					<td style="text-align:center;">Delay Percentage</td>
					<td style="text-align:center;width: 20%;">Remarks</td>
<!-- 					<td style="text-align:center;">Cost</td> -->
					<td style="text-align:center;" class="non-printable">View</td>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($workshop_requests as $request): ?>
				<tr>
		          <td>
		          <?php if(!empty($request['items'])): ?>
		            <?php foreach ($request['items'] as $item): ?>
		                <div><?php echo $item['unit']; ?></div>
		            <?php endforeach; ?>
		            <?php endif ?>
		          </td>					
		          <td style="text-align:center;"><?php echo $request['from_hotel'] ?></td>
					<td style="text-align:center;"><?php echo substr($request['timestamp'], 0, 10) ?></td>
					<td style="text-align:center;">
						<?php if(is_null($request['sign_user_id'])){ 
							echo "Form Not Completed";
						}elseif(is_null($request['delivery_date'])){ 
							echo "The Delivery Date Not Set Yet";
						}elseif($request['delivery_date'] == "0000-00-00"){ 
							echo "Delivery Date Not Inserted";
						}elseif(strtotime($request['delivery_date']) < strtotime($request['sign_timestamp'])){ 
							echo "Form Signed After The Delivery Date";
						}else{
							echo $request['delay_days'];
						}?>
					</td>
					<td style="text-align:center;">
						<?php if(is_null($request['sign_user_id'])){ 
							echo "Form Not Completed";
						}elseif(is_null($request['delivery_date'])){ 
							echo "The Delivery Date Not Set Yet";
						}elseif($request['delivery_date'] == "0000-00-00"){ 
							echo "Delivery Date Not Inserted";
						}elseif(strtotime($request['delivery_date']) < strtotime($request['sign_timestamp'])){ 
							echo "Form Signed After The Delivery Date";
						}else{						
							echo $request['delay_percentage']."%";
						}?>
					</td>
					<td style="text-align:center;width: 20%;"><?php echo $request['remarks'] ?></td>
					<!--<td style="text-align:center;"><?php echo $request['price'] ?></td> -->
			        <td style="text-align:center;" class="non-printable">
			          <a href="<?php echo base_url(); ?>workshop/request_view/<?php echo $request['id'] ?>" class="btn btn-primary">Request View</a>
			        </td>

				</tr>
			<?php endforeach; ?>
			</tbody>
			</table>

		<?php endif; ?>

	</div>
</div>
</body>
</html>
