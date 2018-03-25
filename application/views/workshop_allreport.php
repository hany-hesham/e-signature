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
	<div class="container">

		<div class="rest-selector col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<fieldset>
			<legend class="title-table">Workshop Requests</legend>
				<?php $this->load->view('workshop_request_simple_report_form'); ?>
			
			</fieldset>
		</div>
		
		</div>
		<?php if (isset($posting)): ?>
			
			<div class="title-table"></div>
			<table class="report-view-large" style="width:100%;">
			<thead>
				<tr>
					<td style="text-align:center;">Items</td>
					<td style="text-align:center;">Hotel</td>
					<td style="text-align:center;">Date</td>
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
					<td style="text-align:center;width: 20%;"><?php echo $request['remarks'] ?></td>
<!-- 					<td style="text-align:center;"><?php echo $request['price'] ?></td> -->
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
