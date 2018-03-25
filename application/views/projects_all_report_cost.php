<!DOCTYPE html>
<html lang="en">
	<head>
		<?php $this->load->view('header'); ?>
		<style type="text/css">
			@media print{
				.noprint{
					display: none;
				}
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
				.topic{
					display: block !important;
				}

				.real{
					display: none !important;
				}
				@page { 
					margin: 0; 
				}
  				body { 
  					margin: 1.6cm; 
  				}
			}
		</style>
	</head>
	<body>
		<div id="wrapper">
			<?php $this->load->view('menu') ?>
	     	<button onclick="printContent('page-wrapper')" class="non-printable form-actions btn btn-success print" href="" >Print</button>
	     	<br />
	     	<br />
			<div id="page-wrapper">
				<div class="container">
					<div class="rest-selector col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<legend class="title-table">Project Cost Status Report</legend>
						<fieldset class="real">
							<?php $this->load->view('report_form_cost'); ?>
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
						<?php if (isset($state)): ?>
							<?php if ($state == '1'): ?>
								<h3 class="centered"> Projects Higher Than Approved Cost </h3>
							<?php elseif ($state == '2'): ?>
								<h3 class="centered"> Projects Lower Than Approved Cost </h3>
							<?php elseif ($state == '3'): ?>
								<h3 class="centered"> Projects The Same Approved Cost </h3>				
							<?php else: ?>
								<h3 class="centered"> For All Approved Projects </h3>
							<?php endif; ?>
						<?php endif; ?>
						<h3 class="centered"> from <?php echo $from; ?> to <?php echo $to; ?></h3>
					</div>
					<div class="title-table"></div>
					<div id="page-wrapper-print">
						<table class="report-view-large">
							<tbody>
								<tr>
									<td>Code#</td>
									<td>Date</td>
									<td>Hotel</td>
									<td>Project Name</td>
									<td>Suppliers</td>
									<td>Approved Cost</td>
									<td>Start Date</td>
									<td>End Date</td>
									<td width="10%">Reason</td>
									<td>Status</td>
									<td>Done Date</td>
									<td>Actual Cost</td>
									<td>Difference</td>
									<td width="5%">Difference Status</td>
								</tr>
							</tbody>
							<tbody>
								<?php if ($state == '1'): ?>
									<?php foreach ($projects as $project): ?>
										<?php if ($project['difference'] < 0): ?>
											<?php $total += $project['cost'];?>
											<?php $total_true += $project['true'];?>
											<tr>
												<td><?php echo $project['code'] ?></td>
												<td><?php echo substr($project['timestamp'], 0, 10) ?></td>
												<td><?php echo $project['hotel_name'] ?></td>
												<td><?php echo $project['project_name'] ?></td>
												<td>
													<?php foreach ($project['suppliers'] as $supplier) {
														echo $supplier['name']."<br />";
													} ?>
												</td>
												<td><?php echo $project['cost'] ?></td>
												<td><?php echo $project['start'] ?></td>
												<td><?php echo $project['end'] ?></td>
												<td><?php echo $project['reasons'] ?></td>
												<td>
													<?php if ($project['progress_name'] == 'Done'): ?>
														<div class="lower" style="background-color:#5cb85c;color:#fff"><?php echo $project['progress_name'] ?></div><span><?php echo $project['done_date'] ?></span>
													<?php elseif ($project['progress_name'] != 'Done'):
														 echo $project['progress_name'] ?>
													<?php endif ?>
												</td>
												<td><?php echo $project['new_date'] ?></td>
												<td><?php echo $project['true'] ?></td>
												<td><?php echo ($project['cost'] - $project['true']) ?></td>
												<td style="text-align: center;">
													<?php if ($project['cost'] < $project['true']): ?>
														<div class="higher" style="background-color:#ff0000;color:#fff;"><?php echo 'Higher' ?></div>
													<?php elseif ($project['cost'] > $project['true']): ?>
														<div class="lower" style="background-color:#5cb85c;color:#fff"><?php echo 'Lower' ?></div>
													<?php elseif ($project['cost'] == $project['true']): ?>
														<div class="same" style="background-color:#2400ff;color:#fff"><?php echo 'Same' ?></div>
													<?php endif ?>
												</td>
											</tr>
										<?php endif ?>
									<?php endforeach; ?>
								<?php elseif ($state == '2'): ?>
									<?php foreach ($projects as $project): ?>
										<?php if ($project['difference'] > 0): ?>
											<?php $total += $project['cost'];?>
											<?php $total_true += $project['true'];?>
											<tr>
												<td><?php echo $project['code'] ?></td>
												<td><?php echo substr($project['timestamp'], 0, 10) ?></td>
												<td><?php echo $project['hotel_name'] ?></td>
												<td><?php echo $project['project_name'] ?></td>
												<td>
													<?php foreach ($project['suppliers'] as $supplier) {
														echo $supplier['name']."<br />";
													} ?>
												</td>
												<td><?php echo $project['cost'] ?></td>
												<td><?php echo $project['start'] ?></td>
												<td><?php echo $project['end'] ?></td>
												<td><?php echo $project['reasons'] ?></td>
												<td>
													<?php if ($project['progress_name'] == 'Done'): ?>
														<div class="lower" style="background-color:#5cb85c;color:#fff"><?php echo $project['progress_name'] ?></div><span><?php echo $project['done_date'] ?></span>
													<?php elseif ($project['progress_name'] != 'Done'):
														 echo $project['progress_name'] ?>
													<?php endif ?>
												</td>
												<td><?php echo $project['new_date'] ?></td>
												<td><?php echo $project['true'] ?></td>
												<td><?php echo ($project['cost'] - $project['true']) ?></td>
												<td style="text-align: center;">
													<?php if ($project['cost'] < $project['true']): ?>
														<div class="higher" style="background-color:#ff0000;color:#fff;"><?php echo 'Higher' ?></div>
													<?php elseif ($project['cost'] > $project['true']): ?>
														<div class="lower" style="background-color:#5cb85c;color:#fff"><?php echo 'Lower' ?></div>
													<?php elseif ($project['cost'] == $project['true']): ?>
														<div class="same" style="background-color:#2400ff;color:#fff"><?php echo 'Same' ?></div>
													<?php endif ?>
												</td>
											</tr>
										<?php endif ?>
									<?php endforeach; ?>
								<?php elseif ($state == '3'): ?>
									<?php foreach ($projects as $project): ?>
										<?php if ($project['difference'] == 0): ?>
											<?php $total += $project['cost'];?>
											<?php $total_true += $project['true'];?>
											<tr>
												<td><?php echo $project['code'] ?></td>
												<td><?php echo substr($project['timestamp'], 0, 10) ?></td>
												<td><?php echo $project['hotel_name'] ?></td>
												<td><?php echo $project['project_name'] ?></td>
												<td>
													<?php foreach ($project['suppliers'] as $supplier) {
														echo $supplier['name']."<br />";
													} ?>
												</td>
												<td><?php echo $project['cost'] ?></td>
												<td><?php echo $project['start'] ?></td>
												<td><?php echo $project['end'] ?></td>
												<td><?php echo $project['reasons'] ?></td>
												<td>
													<?php if ($project['progress_name'] == 'Done'): ?>
														<div class="lower" style="background-color:#5cb85c;color:#fff"><?php echo $project['progress_name'] ?></div><span><?php echo $project['done_date'] ?></span>
													<?php elseif ($project['progress_name'] != 'Done'):
														 echo $project['progress_name'] ?>
													<?php endif ?>
												</td>
												<td><?php echo $project['new_date'] ?></td>
												<td><?php echo $project['true'] ?></td>
												<td><?php echo ($project['cost'] - $project['true']) ?></td>
												<td style="text-align: center;">
													<?php if ($project['cost'] < $project['true']): ?>
														<div class="higher" style="background-color:#ff0000;color:#fff;"><?php echo 'Higher' ?></div>
													<?php elseif ($project['cost'] > $project['true']): ?>
														<div class="lower" style="background-color:#5cb85c;color:#fff"><?php echo 'Lower' ?></div>
													<?php elseif ($project['cost'] == $project['true']): ?>
														<div class="same" style="background-color:#2400ff;color:#fff"><?php echo 'Same' ?></div>
													<?php endif ?>
												</td>
											</tr>
										<?php endif ?>
									<?php endforeach; ?>
								<?php else: ?>
									<?php foreach ($projects as $project): ?>
										<?php $total += $project['cost'];?>
										<?php $total_true += $project['true'];?>
										<tr>
											<td><?php echo $project['code'] ?></td>
											<td><?php echo substr($project['timestamp'], 0, 10) ?></td>
											<td><?php echo $project['hotel_name'] ?></td>
											<td><?php echo $project['project_name'] ?></td>
											<td>
												<?php foreach ($project['suppliers'] as $supplier) {
													echo $supplier['name']."<br />";
												} ?>
											</td>
											<td><?php echo $project['cost'] ?></td>
											<td><?php echo $project['start'] ?></td>
											<td><?php echo $project['end'] ?></td>
											<td><?php echo $project['reasons'] ?></td>
											<td>
												<?php if ($project['progress_name'] == 'Done'): ?>
													<div class="lower" style="background-color:#5cb85c;color:#fff"><?php echo $project['progress_name'] ?></div><span><?php echo $project['done_date'] ?></span>
												<?php elseif ($project['progress_name'] != 'Done'):
													 echo $project['progress_name'] ?>
												<?php endif ?>
											</td>
											<td><?php echo $project['new_date'] ?></td>
											<td><?php echo $project['true'] ?></td>
											<td><?php echo ($project['cost'] - $project['true']) ?></td>
											<td style="text-align: center;">
												<?php if ($project['cost'] < $project['true']): ?>
													<div class="higher" style="background-color:#ff0000;color:#fff;"><?php echo 'Higher' ?></div>
												<?php elseif ($project['cost'] > $project['true']): ?>
													<div class="lower" style="background-color:#5cb85c;color:#fff"><?php echo 'Lower' ?></div>
												<?php elseif ($project['cost'] == $project['true']): ?>
													<div class="same" style="background-color:#2400ff;color:#fff"><?php echo 'Same' ?></div>
												<?php endif ?>
											</td>
										</tr>
									<?php endforeach; ?>
								<?php endif; ?>
							</tbody>
						</table>
						<table class="report-view-large">
							<tr>
								<td width="15%">Approved Total</td>
								<td width="15%"><?php echo $total ?></td>
							</tr>
							<tr>
								<td width="15%">Actual Total</td>
								<td width="15%"><?php echo $total_true ?></td>
							</tr>
							<tr>
								<td width="15%">Difference</td>
								<td width="15%"><?php echo ($total - $total_true) ?></td>
							</tr>
						</table>
						<br>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</body>
	<script>
		function printContent(el){
			var restorepage = document.body.innerHTML;
			var printcontent = document.getElementById(el).innerHTML;
			document.body.innerHTML = printcontent;
			window.print();
			document.body.innerHTML = restorepage;
		}
	</script>
</html>
