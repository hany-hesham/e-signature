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
		.topic{
			display: block !important;
		}

		.real{
			display: none !important;
		}
		@page { margin: 0; }
  		body { margin: 1.6cm; }
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
			<legend class="title-table">Project Execution Status Report</legend>
			<fieldset class="real">
			<?php $this->load->view('report_form_simple_progress'); ?>	

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
				<?php if (isset($status)): ?>
					<h3 class="centered"> <?php echo $status['name']; ?> Projects </h3>
				<?php else: ?>
					<h3 class="centered"> All Status (In-Progress - Holding - Done - Cancelled - Delayed - Postponed) </h3>
				<?php endif; ?>
				<h3 class="centered"> from <?php echo $from; ?> to <?php echo $to; ?></h3>
			</div>
			<div class="title-table"></div>
			<table class="report-view-large">
			<thead>
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
					<td>Delayed for</td>
					<td width="10%">Delayed Reason</td>
					<td>Actual Cost</td>
					<td>Difference</td>
					<td width="5%">Difference Status</td>
				</tr>
			</thead>
			<tbody>
			<<?php foreach ($projects as $project): ?>
				<?php 
					$date = $project['end'];
					$date .=" 00:00:00";
					$date1 = strtotime($date);
					if ($project['progress_id'] == '3') {
						if ($project['new_date']) {
							$date0 = $project['new_date'];
							$date0 .=" 00:00:00";
						}else{
							$date0 = $project['done_date'];
						}						
						$date2 = strtotime($date0);
					}else{
                    	$date2 = strtotime(date("Y-m-d H:i:s"));
                    }
                    $vall = 0;
                    if ($date1 >= $date2) {
                    $date = $date1 - $date2; 
                    $vall = 1;
                  }else{
                    $date = $date2 - $date1; 
                    $vall = 2;
                  }
                    $years = floor($date / (365*60*60*24));
                    $months = floor(($date - $years * 365*60*60*24) / (30*60*60*24));
                    $days = floor(($date - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                    $hours = floor(($date - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)/ (60*60)); 
                    $minuts  = floor(($date - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60);
                    $seconds = floor(($date - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60 - $minuts*60)); 
                    ?>
                    <?php
                    	$datas = explode("-",$project['start']);
                    	$datass = array_reverse($datas);
            			$datas1 = implode("/",$datass);
                    ?>
                    <?php
                    	$datas2 = explode("-",$project['end']);
                    	$datass1 = array_reverse($datas2);
            			$datas3 = implode("/",$datass1);
                    ?>
                    <?php
                    	$datas4 = explode("-",$project['new_date']);
                    	$datass2 = array_reverse($datas4);
            			$datas5 = implode("/",$datass2);
                    ?>
                    <?php
                    	$dataes = substr($project['timestamp'], 0, 10);
                    	$datas6 = explode("-",$dataes);
                    	$datass3 = array_reverse($datas6);
            			$datas7 = implode("/",$datass3);
                    ?>
                    <?php
                    	$dataes1 = substr($project['done_date'], 0, 10);
                    	$datas8 = explode("-",$dataes1);
                    	$datass4 = array_reverse($datas8);
            			$datas9 = implode("/",$datass4);
                    ?>
				<tr>
					<td><?php echo $project['code'] ?></td>
					<td><?php echo $datas7 ?></td>
					<td><?php echo $project['hotel_name'] ?></td>
					<td><?php echo $project['project_name'] ?></td>
					<td><?php foreach ($project['suppliers'] as $supplier) {
						echo $supplier['name']."<br />";
					} ?></td>
					<td><?php echo $project['cost'] ?></td>

					<td><?php echo $datas1 ?></td>
					<td><?php echo $datas3 ?></td>
					<td><?php echo $project['reasons'] ?></td>
					<td>
						<?php if ($project['progress_name'] == 'Done'): ?><div class="lower" style="background-color:#5cb85c;color:#fff"><?php echo $project['progress_name'] ?></div><span>
							<?php if($datas5){ 
								echo $datas5;
							}else{ 
								echo $datas9;
							}; ?>
						</span>
						<?php elseif ($project['progress_name'] != 'Done'): echo $project['progress_name'] ?>
						<?php endif ?>
					</td>
					<td>
						<?php if ($vall == 2){ 
							if ($years){ 
								echo $years." years <br />";
							}
							if ($months){ 
								echo $months." months <br />";
							}
							if ($days){ 
								echo $days." days <br />";
							}
						}?>
					</td>
					<td><?php echo $project['reason'] ?></td>
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
				</tr>
			<?php endforeach; ?>
			</tbody>
			</table>
			<table class="report-view-large">
				<tr>
					<td width="15%">Final Total</td>
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
