<!DOCTYPE html>
<html lang="en">
<head>
<?php $this->load->view('header'); ?>
<style type="text/css">
	@media print{.noprint{display: none;}}

		@media print{
		.higher{
			background-color:#ff0000 !important;
			color:#fff !important;
			-webkit-print-color-adjust: exact;
		}
		.lower{
			background-color:#5cb85c !important;
			color:#fff !important;
			-webkit-print-color-adjust: exact;
		}
		.same{
			background-color:#2400ff !important;
			color:#fff !important;
			-webkit-print-color-adjust: exact;
		}
		.accepted{
			background-color:#9ae191 !important;
			-webkit-print-color-adjust: exact;
		}
	}
</style>
</head>
<body>
<div id="wrapper">
	<?php $this->load->view('menu') ?>
		     	<button onclick="printContent('page-wrapper')" class="non-printable form-actions btn btn-success print" href="" >Print</button><br /><br />

	<div id="page-wrapper">
	<div class="container">

		<div class="rest-selector col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<fieldset>
			<legend class="title-table">Project Execution Status Report</legend>
			<?php if ($no_hotels): ?>
			<?php $this->load->view('report_form_simple'); ?>
			<?php else: ?>
				<?php $this->load->view('report_form_simple_progress_month'); ?>
			<?php endif ?>		

			</fieldset>
		</div>
		
		</div>
		<?php if (isset($posting)): ?>
			<div class="title-table"></div>
			<table class="report-view-large">
			<thead>
				<tr>
					<td>Code#</td>
					<td>Date</td>
					<td>Hotel</td>
					<td>Department</td>
					<td>Project Name</td>
					<td>Suppliers</td>
					<td>Final Cost</td>
					<td>Start Date</td>
					<td>End Date</td>
					<td width="15%">Approvals</td>
					<td width="15%">Reason</td>

						<td>Actual Cost</td>
						<td>Difference</td>
						<td width="5%">Status</td>

					<td width="5%">Delayed</td>

				</tr>
			</thead>
			<tbody>
			<?php foreach ($projects as $project): ?>
				<tr>
					<td><?php echo $project['code'] ?></td>
					<td><?php echo substr($project['timestamp'], 0, 10) ?></td>
					<td><?php echo $project['hotel_name'] ?></td>
					<td><?php echo $project['department_name'] ?></td>
					<td><?php echo $project['project_name'] ?></td>
					<td><?php foreach ($project['suppliers'] as $supplier) {
						echo $supplier['name']."<br />";
					} ?></td>
					<td><?php echo $project['cost'] ?></td>

					<td><?php echo $project['start'] ?></td>
					<td><?php echo $project['end'] ?></td>
					<td>
		            <?php foreach ($project['approvals'] as $approval): ?>
		              <?php if (isset($approval['sign'])): ?>
		                <div class="signer<?php echo isset($approval['sign']['reject'])? ' rejected' : ' accepted' ?>"><?php echo $approval['sign']['name'] ?></div>
		              <?php elseif(isset($approval['queue'])): ?>
		                <div class="signer unsigned"><?php echo $approval['role'] ?></div>
		              <?php endif ?>
		            <?php endforeach ?>
		          </td>
					<td><?php echo $project['reasons'] ?></td>
					
				<?php if ($project['progress_id'] == '3'): ?>
					<td><?php echo $project['true'] ?></td>
					<td><?php echo ($project['cost'] - $project['true']) ?></td>
					<td style="text-align: center;">
						<?php if ($project['cost'] < $project['true']): ?><div class="higher" style="background-color:#ff0000;color:#fff;"><?php echo 'Higher' ?></div>
						<?php elseif ($project['cost'] > $project['true']): ?><div class="lower" style="background-color:#5cb85c;color:#fff"><?php echo 'Lower' ?></div>
						<?php elseif ($project['cost'] == $project['true']): ?><div class="same" style="background-color:#2400ff;color:#fff"><?php echo 'Same' ?></div>
						<?php endif ?>
					</td>
				<?php endif ?>

					<td>
						<?php if ($project['end'] < time() && $project['progress_id'] == '3' ): ?>
							<div style="background-color:#ff0000;color:#fff"><?php echo 'Delayed' ;?></div>
						<?php endif ?>
					</td>
					

				</tr>
			<?php endforeach; ?>
			</tbody>
			</table>


		<?php endif; ?>

	</div>
</div>
<script>
function printContent(el){
	var restorepage = document.body.innerHTML;
	var printcontent = document.getElementById(el).innerHTML;
	document.body.innerHTML = printcontent;
	window.print();
	document.body.innerHTML = restorepage;
}
</script>

</body>
</html>
