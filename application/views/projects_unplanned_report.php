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
	<div class="container">

		<div class="rest-selector col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<fieldset>
			<legend class="title-table">Unplanned Projects less than 30,000 LE</legend>
			<?php if ($no_hotels): ?>
				<?php $this->load->view('report_form_simple'); ?>
			<?php else: ?>
				<?php $this->load->view('report_form'); ?>
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
				</tr>
			<?php endforeach; ?>
				<tr><td colspan="5">Total</td><td colspan="2"><?php echo $total ?></td></tr>
			</tbody>
			</table>

		<?php endif; ?>

	</div>
</div>
</body>
</html>
