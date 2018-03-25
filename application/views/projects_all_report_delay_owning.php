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
						<?php if($type==1){?>
						<legend class="title-table">Unplanned Project Owning Form Delayed Report</legend>
						<?php }else{?>
						<legend class="title-table">Planned Project Owning Form Delayed Report</legend>
						<?php } ?>
						<fieldset class="real">
							<?php $this->load->view('report_form_owning_delay_hotel'); ?>
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
							<?php if($type==1){ ?>
							<h3 class="centered"> All Unplanned Delay Projects </h3>
							<h3 class="centered"> (<?php echo $state['role']; ?>) </h3>
							<?php }else{?>
							<h3 class="centered"> All Planned Delay Projects </h3>
							<h3 class="centered"> (<?php echo $state['role']; ?>) </h3>
							<?php } ?>
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
									<td rowspan="2">ID#</td>
									<td rowspan="2">Code#</td>
									<td rowspan="2">Date</td>
									<td rowspan="2">Hotel</td>
									<td rowspan="2">Project Name</td>
									<td rowspan="2">Start Date</td>
									<td rowspan="2">End Date</td>
									<td rowspan="2">Reason</td>
									<td colspan="4">Owning Signature Info.</td>
								</tr>
								<tr>
									<td>Signature</td>
									<td>Deadline</td>
									<td>Delay Days</td>
									<td>Form Type</td>
								</tr>
							</tbody>
							<tbody>
								<?php foreach ($projects as $project):
									$datas = explode("-",$project['start']);
		                    		$datas = array_reverse($datas);
		            				$datas = implode("/",$datas);
		                    		$datas1 = explode("-",$project['end']);
		                    		$datas1 = array_reverse($datas1);
		            				$datas1 = implode("/",$datas1);
		                    		$datas3 = substr($project['timestamp'], 0, 10);
		                    		$datas3 = explode("-",$datas3);
		                    		$datas3 = array_reverse($datas3);
		            				$datas3 = implode("/",$datas3);?>
		            				<tr>
										<td><?php echo $project['id'] ?></td>
										<td><?php echo $project['code'] ?></td>
										<td><?php echo $datas3 ?></td>
										<td><?php echo $project['hotel_name'] ?></td>
										<td><?php echo $project['project_name'] ?></td>
										<td><?php echo $datas ?></td>
										<td><?php echo $datas1 ?></td>
										<td class="hany"><?php echo $project['reasons'] ?></td>
										<td style="width: 140px;">
					                        <?php foreach ($project['owning_signatures'] as $approval): ?>
					                          <?php if ($approval['user_id']): ?>
					                            <div class="signer<?php echo ($approval['reject'] == 1)? ' rejected' : ' accepted' ?>">
					                              <?php echo $approval['user_name'] ?>
					                            </div>
					                          <?php else: ?>
					                            <div class="signer unsigned"><?php echo $approval['role']; ?></div>
					                          <?php endif ?>
					                        <?php endforeach ?>
					                    </td>
	                      				<td style="width: 100px;">
	                        				<?php foreach ($project['owning_signatures'] as $approval):
					                        	$datasd = explode("-",$approval['dead_line']);
							                    $datasd = array_reverse($datasd);
							            		$datasd = implode("/",$datasd);?>
	                            				<div class="signer unsigned"><?php echo $datasd; ?></div>
	                        				<?php endforeach ?>
	                      				</td>
	                      				<td style="width: 100px;">
	                        				<?php foreach ($project['owning_signatures'] as $approval): 
					                        	$date = $approval['dead_line'];
					                        	$date .=" 00:00:00";
												$date = strtotime($date);
												$date1 = strtotime(date("Y-m-d H:i:s"));
					                        	if ($date >= $date1) {
							                    	$dates = $date - $date1; 
							                    	$vall = 1;
							                  	}else{
							                    	$dates = $date1 - $date; 
							                    	$vall = 2;
							                  	}
							                    $years = floor($dates / (365*60*60*24));
							                    $months = floor(($dates - $years * 365*60*60*24) / (30*60*60*24));
							                    $days = floor(($dates - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
							                    $hours = floor(($dates - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)/ (60*60)); 
							                    $minuts  = floor(($dates - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60);
							                    $seconds = floor(($dates - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60 - $minuts*60));?>
							                    <div class="signer unsigned"><?php echo $days; ?> Days</div>
			                				<?endforeach ?>
					                    </td>
					                    <td style="width: 100px;">
	                        				<?php foreach ($project['owning_signatures'] as $approval): ?>
	                            				<div class="signer unsigned">
					                            	<?php if($approval['type'] == 2){ ?>
					                            		<?php echo 'Planned'; ?>
					                            	<?php }elseif ($approval['type'] == 1) { ?>
					                            		<?php echo 'UnPlanned'; ?>
					                            	<?php } ?>
	                            				</div>
	                        				<?php endforeach ?>
	                      				</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
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
