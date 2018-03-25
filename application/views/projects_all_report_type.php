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
	     	<br/>
	     	<br/>
			<div id="page-wrapper">
				<div class="container">
					<div class="rest-selector col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<legend class="title-table">Projects By Type Report</legend>
						<fieldset class="real">
							<?php $this->load->view('report_form_type'); ?>
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
							<h3 class="centered"> All <?php echo $state['name']; ?> Projects </h3>
						<?php else: ?>
							<h3 class="centered"> All Projects </h3>
						<?php endif; ?>
						<?php if (isset($from) && isset($to)): ?>
							<h3 class="centered"> from <?php echo $from; ?> to <?php echo $to; ?></h3>
						<?php endif; ?>
					</div>
					<div class="title-table"></div>
					<div id="page-wrapper-print">
						<table class="table table-striped table-bordered table-condensed centered">
							<tbody>
								<tr style="font-weight: bolder;">
									<td>ID#</td>
									<td>Code#</td>
									<td>Date</td>
									<td>Hotel Name</td>
									<td>Project Name</td>
									<!--<td>Department Name</td>-->
									<td>Approved Budget</td>
									<td>Approved Cost</td>
									<!--<td>Start Date</td>
									<td>End Date</td>-->
									<td width="10%">Reason</td>
									<td>Status</td>
									<!--<td width="10%">Delayed Reason</td>-->
									<td>Actual Cost</td>
									<td>Difference</td>
									<td width="5%">Difference Status</td>
								</tr>
							</tbody>
							<tbody>
								<?php $count = 0; ?>
								<?php foreach ($projects as $project): 
		                    		$datas = explode("-",$project['start']);
		                    		$datas = array_reverse($datas);
		            				$datas = implode("/",$datas);
		                    		$datas1 = explode("-",$project['end']);
		                    		$datas1 = array_reverse($datas1);
		            				$datas1 = implode("/",$datas1);
			                    	$datas2 = explode("-",$project['new_date']);
			                    	$datas2 = array_reverse($datas2);
			            			$datas2 = implode("/",$datas2);
		                    		$datas3 = substr($project['timestamp'], 0, 10);
		                    		$datas3 = explode("-",$datas3);
		                    		$datas3 = array_reverse($datas3);
		            				$datas3 = implode("/",$datas3);
			                    	$datas4 = substr($project['done_date'], 0, 10);
			                    	$datas4 = explode("-",$datas4);
			                    	$datas4 = array_reverse($datas4);
			            			$datas4 = implode("/",$datas4); ?>
									<tr>
										<td><?php echo $project['id'] ?></td>
										<td><?php echo $project['code'] ?></td>
										<td><?php echo $datas3 ?></td>
										<td><?php echo $project['hotel_name'] ?></td>
										<td><?php echo $project['project_name'] ?></td>
										<!--<td><?php echo $project['department_name'] ?></td>-->
										<td><?php echo $project['budget'] ?></td>
										<td><?php echo $project['cost'] ?></td>
										<!--<td><?php echo $datas ?></td>
										<td><?php echo $datas1 ?></td>-->
										<td><?php echo $project['reasons'] ?></td>
										<td>
											<?php if ($project['progress_name'] == 'Done'): ?>
												<div class="lower" style="background-color:#5cb85c;color:#fff"><?php echo $project['progress_name'] ?></div>
												<?php if ($datas2 && $datas2 != '00/00/0000'){ ?>
													<span>
														New Date: <?php echo $datas2;?>
													</span>
												<?php } ?>
												<?php if ($datas4){ ?>
													<span>
														Done Date: <?php echo $datas4;?>
													</span>
												<?php } ?>
											<?php elseif ($project['progress_name'] == 'In-Progress'):?>
												<div class="same" style="background-color:#2400ff;color:#fff"><?php echo $project['progress_name'] ?></div>
												<?php if ($datas2 && $datas2 != '00/00/0000'){ ?>
													<span>
														New Date: <?php echo $datas2;?>
													</span>
												<?php } ?>
											<?php else:?>
												<div class="higher" style="background-color:#ff0000;color:#fff;"><?php echo $project['progress_name'] ?></div>
												<?php if ($datas2 && $datas2 != '00/00/0000'){ ?>
													<span>
														New Date: <?php echo $datas2;?>
													</span>
												<?php } ?>
											<?php endif ?>
										</td>
										<!--<td><?php echo $project['reason'] ?></td>-->
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
							</tbody>
						</table>
						<table class="table table-striped table-bordered table-condensed centered">
							<tr>
								<td width="15%" style="font-weight: bolder;">Total No. Project</td>
								<td width="15%"><?php echo $count ?></td>
							</tr>
							<tr>
								<td width="15%" style="font-weight: bolder;">Budget Total</td>
								<td width="15%"><?php echo $total_budget ?></td>
							</tr>
							<tr>
								<td width="15%" style="font-weight: bolder;">Approved Total</td>
								<td width="15%"><?php echo $total ?></td>
							</tr>
							<tr>
								<td width="15%" style="font-weight: bolder;">Actual Total</td>
								<td width="15%"><?php echo $total_true ?></td>
							</tr>
							<tr>
								<td width="15%" style="font-weight: bolder;">Difference</td>
								<td width="15%"><?php echo ($total - $total_true) ?></td>
							</tr>
						</table>
						<br>
					</div>
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
