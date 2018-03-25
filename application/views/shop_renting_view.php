<!DOCTYPE html>
<html lang="en">
  	<head>
  		<script type="text/javascript">
           function check()
           {
             $("#checking").show();
           }
       </script>
    	<?php $this->load->view('header'); ?>
    	<style>
    	    @media print {
	          	@page { 
	            	margin: 0.5cm; 
	          	}
	          	.hany{
	          		margin-left: 0px !important;
	          	}
        	}
      	</style>
  	</head>
  	<body>
    	<div id="wrapper">
      		<?php $this->load->view('menu') ?>
      		<div id="page-wrapper">
        		<div class="a4wrapper">
          			<div class="a4page">
            			<div>
              				<div class="page-header">
              					<?php if ($shop['state_final']==10 && !$shop_adjust['id']): ?>
									<a class="form-actions btn btn-info non-printable" href="/shop_adjust/submit/<?php echo $shop['id'] ?>" style="float:right; margin-right: 10px;" >adjustment</a>
								<?php endif ?>
								<?php if ($shop['state_final']==10 && $shop_adjust['id']): ?>
									<a class="form-actions btn btn-info non-printable" href="/shop_adjust/view/<?php echo $shop_adjust['id']."/".$shop['id'] ?>" style="float:right; margin-right: 10px;" >View adjustment</a>
								<?php endif ?>
       							<button onclick="window.print()" class="non-printable form-actions btn btn-success" href="">Print</button>
       							<?php if ($shop['state_final']!=10): ?>
								<?php if ($is_editor): ?>
									<a class="form-actions btn btn-info non-printable" href="/shop_renting/edit/<?php echo $shop['id'] ?>" style="float:right;" > Edit </a>
								<?php endif ?>
								<?php if ($is_changes): ?>
									<a class="form-actions btn btn-info non-printable" href="/shop_renting/change/<?php echo $shop['id'] ?>" style="float:right;" > Change </a>
								<?php endif ?>
								<?php if ($is_credit): ?>
									<a class="form-actions btn btn-info non-printable" href="/shop_renting/edit_upload/<?php echo $shop['id'] ?>" style="float:right; margin-right: 10px;" > Upload </a>
								<?php endif ?>
								<?php endif ?>
								<div class="header-logo"><img src="/assets/uploads/logos/<?php echo $shop['logo']; ?>"/></div>
		                  		<h1 class="centered"><?php echo $shop['hotel_name']; ?></h1>
			        			<h3 class="centered" dir="rtl">
			        				Shop Renting Prior Approval No. #<?php echo $shop['id']; ?>
			        			</h3>
			        			<h3 class="centered" dir="rtl">
			        				<?php echo $shop['title']; ?>
			        			</h3>
			        			<a class="form-actions btn btn-info non-printable" href="/shop_renting/mail_me/<?php echo $shop['id'] ?>" style="float:left; margin-left: 20px;" > <img src="/assets/images/letter.png" style="width: 28px; height: 40px; margin: 0px; margin-left: -10px; margin-top: -10px; margin-bottom: -10px;"> Share by Email </a>
								<a data-text="whatsapp" data-link="<?php echo base_url(); ?>shop_renting/view/<?php echo $shop['id'] ?>" style="float:left; margin-left: 20px;" class="whatsapp whatsapp_btn whatsapp_btn_small form-actions btn btn-success non-printable"> <img src="/assets/images/original.png" style="width: 70px; height: 50px; margin: -20px; margin-left: -30px; margin-top: -21px;"> Share by Whatsapp</a> 
								<a class="form-actions btn btn-success non-printable" href="/shop_renting" style="float:right;"> Back </a>
			        			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher data-indention">
				        			<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
	                  					<label for="from-hotel" class="control-label " style="width: 160px;"> Date: </label>
	                  					<label for="from-type" class="control-label " style="width:200px;"><?php echo $shop['timestamp'] ?></label>
	                  				</div>
	                  			</div>
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher data-indention">
	                  				<table class="table table-striped table-bordered table-condensed hany" style="width: 775px !important;">
					                    <tr>
				                          <th colspan="1" rowspan="2" style=" text-align: center; font-size: 18px; font-weight: bolder; width: 180px !important;">#</th>
				                          <th colspan="1" rowspan="2" style=" text-align: center; font-size: 18px; font-weight: bolder; width: 124px !important;">Current Tenant</th>
				                          <th colspan="1" rowspan="2" style=" text-align: center; font-size: 18px; font-weight: bolder; width: 124px !important;">Tenant 1</th>
				                          <th colspan="1" rowspan="2" style=" text-align: center; font-size: 18px; font-weight: bolder; width: 124px !important;">Tenant 2</th>
				                          <th colspan="1" rowspan="2" style=" text-align: center; font-size: 18px; font-weight: bolder; width: 124px !important;">Tenant 3</th>
				                          <?php if ($shop['changes'] == 1):?>
					                        <th colspan="3" rowspan="1" style="  border: solid; background-color: black; color: #fff; text-align: center; font-size: 18px; font-weight: bolder; width: 180px !important;">Change To</th>
	
					                      <? endif; ?>
					                    </tr>
					                    <tr>
					                    	<?php if ($shop['changes'] == 1):?>
					                          <th colspan="1" rowspan="1" style="  border: solid; background-color: black; color: #fff; text-align: center; font-size: 18px; font-weight: bolder; width: 124px !important;">Tenant 1</th>
					                          <th colspan="1" rowspan="1" style="  border: solid; background-color: black; color: #fff; text-align: center; font-size: 18px; font-weight: bolder; width: 124px !important;">Tenant 2</th>
					                          <th colspan="1" rowspan="1" style="  border: solid; background-color: black; color: #fff; text-align: center; font-size: 18px; font-weight: bolder; width: 124px !important;">Tenant 3</th>	
					                      <? endif; ?>
					                    </tr>
										<tr class="item-row">
											<td style="font-size: 18px; font-weight: bolder;">Tenant Name</td>
											<?php foreach ($offers as $offer): ?>
												<td class="centered" style="<?php if ($offer['changed'] == 1):?>border: solid;<? endif; ?> <?php if($offer['id'] == $shop['choosen_id']):?> background-color: yellow; <?php elseif($offer['id'] == $shop['change_choosen_id']):?> background-color: yellow; <?php endif; ?>"><?php echo $offer['name']; ?></td>
											<?php endforeach;?>
										</tr>
										<tr class="item-row">
											<td style="font-size: 18px; font-weight: bolder;">Starting From</td>
											<?php foreach ($offers as $offer): ?>
												<td class="centered" style="<?php if ($offer['changed'] == 1):?>border: solid;<? endif; ?> <?php if($offer['id'] == $shop['choosen_id']):?> background-color: yellow; <?php elseif($offer['id'] == $shop['change_choosen_id']):?> background-color: yellow; <?php endif; ?>"><?php echo $offer['start_from']; ?></td>
											<?php endforeach;?>
										</tr>
										<tr class="item-row">
											<td style="font-size: 18px; font-weight: bolder;">End At</td>
											<?php foreach ($offers as $offer): ?>
												<td class="centered" style="<?php if ($offer['changed'] == 1):?>border: solid;<? endif; ?> <?php if($offer['id'] == $shop['choosen_id']):?> background-color: yellow; <?php elseif($offer['id'] == $shop['change_choosen_id']):?> background-color: yellow; <?php endif; ?>"><?php echo $offer['end_at']; ?></td>
											<?php endforeach;?>
										</tr>
										<tr class="item-row">
											<td style="font-size: 18px; font-weight: bolder;">Contract Duration</td>
											<?php foreach ($offers as $offer): ?>
												<?php 
					                        		$date1 = strtotime($offer['start_from']);
					                        		$date2 = strtotime($offer['end_at']); 
					                        		$date = $date2 - $date1;
					                        		$years = floor($date / (365*60*60*24));
					                        		$months = floor(($date - $years * 365*60*60*24) / (30*60*60*24));
					                        		$days = floor(($date - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
					                       		 	if ($months >= 12) {
					                        			$years++;
					                        			$months = $months - 12;
					                        		}
					                     		?>
					                     		<td class="centered" style="<?php if ($offer['changed'] == 1):?>border: solid;<? endif; ?> <?php if($offer['id'] == $shop['choosen_id']):?> background-color: yellow; <?php elseif($offer['id'] == $shop['change_choosen_id']):?> background-color: yellow; <?php endif; ?>">
													<?php 
					                          			if ($years != 0) {
					                            			echo $years." Years <br>"; 
					                          			}
								                       	/*if ($months != 0) {
								                           	echo $months." Monthes <br>";
								                       	}
								                       	if ($date != 0) {
								                          	echo $date." Days <br>";
								                       	}*/
					                        		?>
				                        		</td>
											<?php endforeach;?>
										</tr>
										<tr class="item-row">
											<td style="font-size: 18px; font-weight: bolder;">Monthly Rent</td>
											<?php foreach ($offers as $offer): ?>
												<td class="centered" style="<?php if ($offer['changed'] == 1):?>border: solid;<? endif; ?> <?php if($offer['id'] == $shop['choosen_id']):?> background-color: yellow; <?php elseif($offer['id'] == $shop['change_choosen_id']):?> background-color: yellow; <?php endif; ?>"><?php echo number_format($offer['rent'],2,".",","); ?> <?php echo $offer['currency1']; ?></td>
											<?php endforeach;?>
										</tr>
										<tr class="item-row">
											<td style="font-size: 18px; font-weight: bolder;">Net rent after taxes</td>
											<?php foreach ($offers as $offer): ?>
												<?php $taxes = "1.".$offer['taxes'];?>
		                      					<?php $taxes1 = ($offer['rent']/ $taxes)*($offer['taxes']/100);?>
		                      					<?php $final = $offer['rent']-$taxes1;?>
												<td class="centered" style="<?php if ($offer['changed'] == 1):?>border: solid;<? endif; ?> <?php if($offer['id'] == $shop['choosen_id']):?> background-color: yellow; <?php elseif($offer['id'] == $shop['change_choosen_id']):?> background-color: yellow; <?php endif; ?>"><?php echo number_format($final,2,".",","); ?> <?php echo $offer['currency1']; ?></td>
											<?php endforeach;?>
										</tr>
										<tr class="item-row">
											<td style="font-size: 18px; font-weight: bolder;">Other Conditions</td>
											<?php foreach ($offers as $offer): ?>
												<td class="centered" style="<?php if ($offer['changed'] == 1):?>border: solid;<? endif; ?> <?php if($offer['id'] == $shop['choosen_id']):?> background-color: yellow; <?php elseif($offer['id'] == $shop['change_choosen_id']):?> background-color: yellow; <?php endif; ?>"><?php echo $offer['other']; ?></td>
											<?php endforeach;?>
										</tr>
										<tr class="item-row">
											<td style="font-size: 18px; font-weight: bolder;">Advance Rent</td>
											<?php foreach ($offers as $offer): ?>
												<td class="centered" style="<?php if ($offer['changed'] == 1):?>border: solid;<? endif; ?> <?php if($offer['id'] == $shop['choosen_id']):?> background-color: yellow; <?php elseif($offer['id'] == $shop['change_choosen_id']):?> background-color: yellow; <?php endif; ?>"><?php echo number_format($offer['advance'],2,".",","); ?> <?php echo $offer['currency2']; ?></td>
											<?php endforeach;?>
										</tr>
										<tr class="item-row">
											<td style="font-size: 18px; font-weight: bolder;">Deposit</td>
											<?php foreach ($offers as $offer): ?>
												<td class="centered" style="<?php if ($offer['changed'] == 1):?>border: solid;<? endif; ?> <?php if($offer['id'] == $shop['choosen_id']):?> background-color: yellow; <?php elseif($offer['id'] == $shop['change_choosen_id']):?> background-color: yellow; <?php endif; ?>"><?php echo number_format($offer['deposite'],2,".",","); ?> <?php echo $offer['currency3']; ?></td>
											<?php endforeach;?>
										</tr>
										<tr class="item-row">
											<td style="font-size: 18px; font-weight: bolder;">Location</td>
											<?php foreach ($offers as $offer): ?>
												<td class="centered" style="<?php if ($offer['changed'] == 1):?>border: solid;<? endif; ?> <?php if($offer['id'] == $shop['choosen_id']):?> background-color: yellow; <?php elseif($offer['id'] == $shop['change_choosen_id']):?> background-color: yellow; <?php endif; ?>"><?php echo $offer['location']; ?></td>
											<?php endforeach;?>
										</tr>
										<tr class="item-row">
											<td style="font-size: 18px; font-weight: bolder;">References</td>
											<?php foreach ($offers as $offer): ?>
												<td class="centered" style="<?php if ($offer['changed'] == 1):?>border: solid;<? endif; ?> <?php if($offer['id'] == $shop['choosen_id']):?> background-color: yellow; <?php elseif($offer['id'] == $shop['change_choosen_id']):?> background-color: yellow; <?php endif; ?>"><?php echo $offer['reference']; ?></td>
											<?php endforeach;?>
										</tr>
										<tr class="item-row">
											<td style="font-size: 18px; font-weight: bolder;">Reference By</td>
											<?php foreach ($offers as $offer): ?>
												<td class="centered" style="<?php if ($offer['changed'] == 1):?>border: solid;<? endif; ?> <?php if($offer['id'] == $shop['choosen_id']):?> background-color: yellow; <?php elseif($offer['id'] == $shop['change_choosen_id']):?> background-color: yellow; <?php endif; ?>"><?php echo $offer['by_reference']; ?></td>
											<?php endforeach;?>
										</tr>
										<tr class="item-row">
											<td style="font-size: 18px; font-weight: bolder;">Who Is Reference?</td>
											<?php foreach ($offers as $offer): ?>
												<td class="centered" style="<?php if ($offer['changed'] == 1):?>border: solid;<? endif; ?> <?php if($offer['id'] == $shop['choosen_id']):?> background-color: yellow; <?php elseif($offer['id'] == $shop['change_choosen_id']):?> background-color: yellow; <?php endif; ?>"><?php echo $offer['who_reference']; ?></td>
											<?php endforeach;?>
										</tr>
										<tr class="item-row non-printable">
											<td style="font-size: 18px; font-weight: bolder;">Design Attached</td>
											<?php foreach ($offers as $offer): ?>
												<td class="centered" style="<?php if ($offer['changed'] == 1):?>border: solid;<? endif; ?> <?php if($offer['id'] == $shop['choosen_id']):?> background-color: yellow; <?php elseif($offer['id'] == $shop['change_choosen_id']):?> background-color: yellow; <?php endif; ?>"><a href='/assets/uploads/files/<?php echo $offer['design'] ?>'><?php echo $offer['design'] ?></a></td>
											<?php endforeach;?>
										</tr>
										<tr class="item-row non-printable">
											<td style="font-size: 18px; font-weight: bolder;">Attached Offer</td>
											<?php foreach ($offers as $offer): ?>
												<td class="centered" style="<?php if ($offer['changed'] == 1):?>border: solid;<? endif; ?> <?php if($offer['id'] == $shop['choosen_id']):?> background-color: yellow; <?php elseif($offer['id'] == $shop['change_choosen_id']):?> background-color: yellow; <?php endif; ?>"><a href='/assets/uploads/files/<?php echo $offer['offer'] ?>'><?php echo $offer['offer'] ?></a></td>
											<?php endforeach;?>
										</tr>
										<tr class="item-row non-printable">
											<td style="font-size: 18px; font-weight: bolder;">Attached CV</td>
											<?php foreach ($offers as $offer): ?>
												<td class="centered" style="<?php if ($offer['changed'] == 1):?>border: solid;<? endif; ?> <?php if($offer['id'] == $shop['choosen_id']):?> background-color: yellow; <?php elseif($offer['id'] == $shop['change_choosen_id']):?> background-color: yellow; <?php endif; ?>"><a href='/assets/uploads/files/<?php echo $offer['cv'] ?>'><?php echo $offer['cv'] ?></a></td>
											<?php endforeach;?>
										</tr>
										<tr class="item-row non-printable">
											<td style="font-size: 18px; font-weight: bolder;">Attached Contract</td>
											<?php foreach ($offers as $offer): ?>
												<td class="centered" style="<?php if ($offer['changed'] == 1):?>border: solid;<? endif; ?> <?php if($offer['id'] == $shop['choosen_id']):?> background-color: yellow; <?php elseif($offer['id'] == $shop['change_choosen_id']):?> background-color: yellow; <?php endif; ?>"><a href='/assets/uploads/files/<?php echo $offer['contract'] ?>'><?php echo $offer['contract'] ?></a></td>
											<?php endforeach;?>
										</tr>
									</table>
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher data-indention">
					        			<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
		                  					<label for="from-hotel" class="control-label " style="width: 160px;"> Tenant Recommendation: </label>
		                  					<label for="from-type" class="control-label " style="width:300px;"><?php echo $shop['recommendation'] ?></label>
		                  				</div>
		                  			</div>
		                  			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher data-indention">
					        			<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
		                  					<label for="from-hotel" class="control-label " style="width: 160px;"> Reason: </label>
		                  					<label for="from-type" class="control-label " style="width:500px;"><?php echo $shop['reason'] ?></label>
		                  				</div>
		                  			</div>
		                  			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher data-indention">
					        			<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
		                  					<label for="from-hotel" class="control-label " style="width: 160px;"> Choosen Tenant: </label>
		                  					<label for="from-type" class="control-label " style="width:200px;"><?php echo $shop['offer'] ?></label>
		                  				</div>
		                  			</div>
		                  			<?php if ($shop['state_id'] == 2 || $shop['changes'] == 1):?>
		                  				<?php if ($shop['credit_demo']):?>
		                  					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher data-indention">
							        			<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
					                  				<label for="from-hotel" class="control-label " style="width: 160px;"> Contract Demo: </label>
					                  				<a href='/assets/uploads/files/<?php echo $shop['credit_demo'] ?>'><?php echo $shop['credit_demo'] ?></a>
				                  				</div>
				                  			</div>
				                  			<?php if ($shop['lawyer_final']):?>
				                  				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher data-indention">
								        			<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
						                  				<label for="from-hotel" class="control-label " style="width: 160px;"> Final Contract: </label>
						                  				<a href='/assets/uploads/files/<?php echo $shop['lawyer_final'] ?>'><?php echo $shop['lawyer_final'] ?></a>
					                  				</div>
					                  			</div>
					                  			<?php if ($shop['credit_final']):?>
					                  				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher data-indention">
									        			<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
							                  				<label for="from-hotel" class="control-label " style="width: 160px;"> Final Contract: </label>
							                  				<a href='/assets/uploads/files/<?php echo $shop['credit_final'] ?>'><?php echo $shop['credit_final'] ?></a>
						                  				</div>
						                  			</div>
					                  			<?php else: ?>
						                  			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher data-indention">
									        			<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
							                  				<form action="/shop_renting/credit_final/<?php echo $shop['id']; ?>" method="POST" class="form-div span12" enctype="multipart/form-data">
							                  					<label for="from-hotel" class="control-label " style="width: 160px;"> Final Signed Contract: </label>
							                  					<input type="file" class="form-control" name="credit_final" required="required" value="" style="height: 35px; width: 210px; display: inline-block;"/>
					                  							<input name="submit" value="Submit" type="submit" class="btn btn-success" style="height: 35px; display: inline-block; margin-top: -5px;" onClick="check();" />
                                                                     <div id="checking" style="display:none;position: fixed;top: 0;left: 0;width: 100%;height: 100   %;background: #f4f4f4;z-index: 99;">
                                                                          <div class="text" style="position: absolute;top: 45%;left: 0;height: 100%;width: 100%;font-size: 18px;text-align: center;">
                                                                              <center><img src="<?php echo base_url();?>assets/images/ajax-loader.gif" alt="Loading"></center>
                                                                              Please Wait!<Br><b style="color: red;">few seconds</b>
                                                                          </div>
                                                                    </div>
							                  				</form>
						                  				</div>
						                  			</div>
						                  		<?php endif; ?>
				                  			<?php else: ?>
					                  			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher data-indention">
								        			<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
						                  				<form action="/shop_renting/lawyer_final/<?php echo $shop['id']; ?>" method="POST" class="form-div span12" enctype="multipart/form-data">
						                  					<label for="from-hotel" class="control-label " style="width: 160px;"> Final Contract: </label>
						                  					<input type="file" class="form-control" name="lawyer_final" required="required" value="" style="height: 35px; width: 210px; display: inline-block;"/>
					                  						<input name="submit" value="Submit" type="submit" class="btn btn-success" style="height: 35px; display: inline-block; margin-top: -5px;" onClick="check();" />
					                  						 <div id="checking" style="display:none;position: fixed;top: 0;left: 0;width: 100%;height: 100   %;background: #f4f4f4;z-index: 99;">
                                                                     <div class="text" style="position: absolute;top: 45%;left: 0;height: 100%;width: 100%;font-size: 18px;text-align: center;">
                                                                         <center><img src="<?php echo base_url();?>assets/images/ajax-loader.gif" alt="Loading"></center>
                                                                         Please Wait!<Br><b style="color: red;">few seconds</b>
                                                                      </div>
                                                                </div>
						                  				</form>
					                  				</div>
					                  			</div>
				                  			<?php endif; ?>
		                  				<?php else: ?>
				                  			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher data-indention">
							        			<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
					                  				<form action="/shop_renting/credit_demo/<?php echo $shop['id']; ?>" method="POST" class="form-div span12" enctype="multipart/form-data">
					                  					<label class="control-label " style="width: 160px;"> Contract Demo: </label>
					                  					<input type="file" class="form-control" name="credit_demo" required="required" value="" style="height: 35px; width: 210px; display: inline-block;"/>
					                  					<input name="submit" value="Submit" type="submit" class="btn btn-success" style="height: 35px; display: inline-block; margin-top: -5px;" onClick="check();"  />
					                  					   <div id="checking" style="display:none;position: fixed;top: 0;left: 0;width: 100%;height: 100   %;background: #f4f4f4;z-index: 99;">
                                                                <div class="text" style="position: absolute;top: 45%;left: 0;height: 100%;width: 100%;font-size: 18px;text-align: center;">
                                                                         <center><img src="<?php echo base_url();?>assets/images/ajax-loader.gif" alt="Loading"></center>
                                                                         Please Wait!<Br><b style="color: red;">few seconds</b>
                                                                 </div>
                                                            </div>
					                  				</form>
				                  				</div>
				                  			</div>
				                  		<?php endif; ?>
				                  	<?php endif; ?>
		                  			<?php if ($shop['changes'] == 0):?>
			                  			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher data-indention non-printable">
					                      	<label for="offers" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">Report Files</label>
											<div class="form-group col-lg-9 col-md-8 col-sm-7 col-xs-7">
					                       		<?php foreach($uploads as $upload): ?>
					                       			<p><a href='/assets/uploads/files/<?php echo $upload['name'] ?>'><?php echo $upload['name'] ?></a> Uploaded by <?php echo $upload['user_name'] ?></p>
					                        	<?php endforeach ?>			
					                      	</div>	
				                      	</div>
			                      	<?php endif; ?>
			                    </div>
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher centered">
					                <?php $queue_first = TRUE; ?>
					                <?php foreach ($signers as $signe_id => $signer): ?>
					                	<div class="signature-wrapper">
					                  		<div class="data-head relative"><?php echo (strlen($signer['role']) == 0)? "Upgrade Owner" : ($signer['role_id'] == '7')? $signer['department'] : $signer['role']."&nbsp".$signer['department']; ?>
					                    		<span class="expander-container"><i class='glyphicon glyphicon-envelope'></i></span>
				                    		<div class="expander-wrapper">
					                      			<span class="expander-remover"><i class='glyphicon glyphicon-remove'></i></span>
					                      			<div class="expander">
					                        			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-holder">
					                          				<div class="row">
					                            				<form action="/shop_renting/<?php if($signer['role_id'] == "1"){ 
									                                echo "share_url";
									                              }else{
									                                echo "mail";
									                              } ?>/<?php echo $shop['id']; ?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
					                              					<?php if (isset($signer['sign'])): ?>
					                              						<?php $i=1; ?>
					                              						<input checked="checked" type="radio" name="mail" value="<?php echo $signer['sign']['mail'] ?>" /><label>To: <?php echo $signer['sign']['name'] ?></label>
					                              					<?php else: ?>
					                              						<?php $i=0; foreach ($signer['queue'] as $id => $signe): ?>
					                              							<input <?php echo (++$i == 1)? 'checked="checked"' : '' ?> type="radio" name="mail" value="<?php echo $signe['mail'] ?>" id="u<?php echo $id ?>" /><label for="u<?php echo $id ?>">To: <?php echo $signe['name'] ?></label><br />
					                              						<?php endforeach ?>
					                              					<?php endif; ?>
					                              					<?php if (isset($i) && $i == 0): ?>
					                              						<span>No users available</span>
					                              					<?php else: ?>
					                              						<?php if($signer['role_id'] != "1"){ ?>
							                              					<textarea class="form-control" name="message" id="message"></textarea>
							                              				<?php } ?>
					                              						<input name="submit" value="Send" type="submit" class="inverse-offset btn btn-success" />
					                              					<?php endif; ?>
					                            				</form>
					                          				</div>
					                        			</div>
					                      			</div>
					                    		</div>
					                  		</div>
					                  		<?php if (isset($signer['sign'])): ?>
					                  			<div class="data-content">
							                  		<img src="
								                  		<?php if(isset($signer['sign']['reject'])){ 
								                  			echo $signature_path.'rejected.png';
								                  		}else {
								                  			if ($signer['sign']['id'] == 217) {
								                  				echo $signature_path.'9f3a8-mr.-hossam.jpg';
								                  			}else{
								                  				echo $signature_path.'approved.png';
								                  			}
								                  		}?>
							                  		" alt="<?php echo $signer['sign']['name']; ?>" class="img-rounded sign-image">
							                    	<?php if (($signer['sign']['id'] == $user_id && $unsign_enable) || $is_admin): ?>
					                    			<a href="/shop_renting/unsign/<?php echo $signe_id; ?>" class="non-printable btn btn-primary unsign">Cancel</a>
							                    	<?php endif ?>
							                  	</div>
					                  			<div class="data-content">
					                  				<span class="name-data-content"><?php echo $signer['sign']['name']; ?></span>
					                  				<br />
					                  				<span class="timestamp-data-content"><?php echo $signer['sign']['timestamp']; ?></span>
					                  			</div>
					                  		<?php elseif (array_key_exists($user_id, $signer['queue']) && $queue_first && $role_id !=142): ?>
					                  			<?php $queue_first = FALSE; ?>
					                  			<div class="data-content non-printable"><span class="data-label sign-data-content"></span><a href="/shop_renting/sign/<?php echo $signe_id; ?>/reject" class="non-printable btn btn-danger">Reject</a><a href="/shop_renting/sign/<?php echo $signe_id; ?>" class="non-printable btn btn-success">sign</a></div>
					                  		<?php else: ?>
					                  			<?php $queue_first = FALSE; ?>
					                  		<?php endif ?>
					                	</div>
					                    <?php if (isset($signer['sign']['reject'])){break;}?>
					                <?php endforeach ?>
					                <?php if ($shop['changes'] == 0):?>
					                	<p class="centered">The Shop Renting Prior Approval Form has been created by <?php echo $shop['name'];?> at <?php echo $shop['timestamp'];?></p>
					                <?php endif; ?>
					            </div>
					            <?php if ($shop['changes'] == 1):?>
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher data-indention">
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher data-indention">
					        			<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
		                  					<label for="from-hotel" class="control-label " style="width: 160px;"> Tenant Recommendation: </label>
		                  					<label for="from-type" class="control-label " style="width:300px;"><?php echo $shop['recommendation_change'] ?></label>
		                  				</div>
		                  			</div>
		                  			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher data-indention">
					        			<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
		                  					<label for="from-hotel" class="control-label " style="width: 160px;"> Reason: </label>
		                  					<label for="from-type" class="control-label " style="width:500px;"><?php echo $shop['reason_change'] ?></label>
		                  				</div>
		                  			</div>
		                  			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher data-indention">
					        			<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
		                  					<label for="from-hotel" class="control-label " style="width: 160px;"> Choosen Tenant: </label>
		                  					<label for="from-type" class="control-label " style="width:200px;"><?php echo $shop['offer_change'] ?></label>
		                  				</div>
		                  			</div>
		                  			<?php if($shop['state_id'] == 2):?>
		                  			<?php if ($shop['credit_demo_change']):?>
		                  					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher data-indention">
							        			<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
					                  				<label for="from-hotel" class="control-label " style="width: 160px;"> Contract Change Demo: </label>
					                  				<a href='/assets/uploads/files/<?php echo $shop['credit_demo_change'] ?>'><?php echo $shop['credit_demo_change'] ?></a>
				                  				</div>
				                  			</div>
				                  			<?php if ($shop['lawyer_final_change']):?>
				                  				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher data-indention">
								        			<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
						                  				<label for="from-hotel" class="control-label " style="width: 160px;"> Final Change Contract: </label>
						                  				<a href='/assets/uploads/files/<?php echo $shop['lawyer_final_change'] ?>'><?php echo $shop['lawyer_final_change'] ?></a>
					                  				</div>
					                  			</div>
					                  			<?php if ($shop['credit_final_change']):?>
					                  				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher data-indention">
									        			<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
							                  				<label for="from-hotel" class="control-label " style="width: 160px;"> Final Change Contract: </label>
							                  				<a href='/assets/uploads/files/<?php echo $shop['credit_final_change'] ?>'><?php echo $shop['credit_final_change'] ?></a>
						                  				</div>
						                  			</div>
					                  			<?php else: ?>
						                  			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher data-indention">
									        			<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
							                  				<form action="/shop_renting/credit_final_change/<?php echo $shop['id']; ?>" method="POST" class="form-div span12" enctype="multipart/form-data">
							                  					<label for="from-hotel" class="control-label " style="width: 160px;"> Final Change Signed Contract: </label>
							                  					<input type="file" class="form-control" name="credit_final_change" required="required" value="" style="height: 35px; width: 210px; display: inline-block;"/>
					                  							<input name="submit" value="Submit" type="submit" class="btn btn-success" style="height: 35px; display: inline-block; margin-top: -5px;" />
							                  				</form>
						                  				</div>
						                  			</div>
						                  		<?php endif; ?>
				                  			<?php else: ?>
					                  			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher data-indention">
								        			<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
						                  				<form action="/shop_renting/lawyer_final_change/<?php echo $shop['id']; ?>" method="POST" class="form-div span12" enctype="multipart/form-data">
						                  					<label for="from-hotel" class="control-label " style="width: 160px;"> Final Change Contract: </label>
						                  					<input type="file" class="form-control" name="lawyer_final_change" required="required" value="" style="height: 35px; width: 210px; display: inline-block;"/>
					                  						<input name="submit" value="Submit" type="submit" class="btn btn-success" style="height: 35px; display: inline-block; margin-top: -5px;" />
						                  				</form>
					                  				</div>
					                  			</div>
				                  			<?php endif; ?>
		                  				<?php else: ?>
				                  			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher data-indention">
							        			<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
					                  				<form action="/shop_renting/credit_demo_change/<?php echo $shop['id']; ?>" method="POST" class="form-div span12" enctype="multipart/form-data">
					                  					<label class="control-label " style="width: 160px;"> Contract Change Demo: </label>
					                  					<input type="file" class="form-control" name="credit_demo_change" required="required" value="" style="height: 35px; width: 210px; display: inline-block;"/>
					                  					<input name="submit" value="Submit" type="submit" class="btn btn-success" style="height: 35px; display: inline-block; margin-top: -5px;" />
					                  				</form>
				                  				</div>
				                  			</div>
				                  		<?php endif; ?>
				                  		<?php endif; ?>
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher data-indention non-printable">
				                      	<label for="offers" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">Report Files</label>
										<div class="form-group col-lg-9 col-md-8 col-sm-7 col-xs-7">
				                       		<?php foreach($uploads as $upload): ?>
				                       			<p><a href='/assets/uploads/files/<?php echo $upload['name'] ?>'><?php echo $upload['name'] ?></a> Uploaded by <?php echo $upload['user_name'] ?></p>
				                        	<?php endforeach ?>			
				                      	</div>	
			                      	</div>
									</div>
						            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher centered">
						                <?php $change_queue_first = TRUE; ?>
						                <?php foreach ($change_signers as $change_signe_id => $signer): ?>
						                	<div class="signature-wrapper">
						                  		<div class="data-head relative"><?php echo (strlen($signer['role']) == 0)? "Upgrade Owner" : ($signer['role_id'] == '7')? $signer['department'] : $signer['role']."&nbsp".$signer['department']; ?>
						                    		<span class="expander-container"><i class='glyphicon glyphicon-envelope'></i></span>
						                    		<div class="expander-wrapper">
						                      			<span class="expander-remover"><i class='glyphicon glyphicon-remove'></i></span>
						                      			<div class="expander">
						                        			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-holder">
						                          				<div class="row">
						                            				<form action="/shop_renting/<?php if($signer['role_id'] == "1"){ 
									                                echo "share_url";
									                              }else{
									                                echo "mail";
									                              } ?>/<?php echo $shop['id']; ?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
						                              					<?php if (isset($signer['sign'])): ?>
						                              						<?php $i=1; ?>
						                              						<input checked="checked" type="radio" name="mail" value="<?php echo $signer['sign']['mail'] ?>" /><label>To: <?php echo $signer['sign']['name'] ?></label>
						                              					<?php else: ?>
						                              						<?php $i=0; foreach ($signer['queue'] as $id => $signe): ?>
						                              							<input <?php echo (++$i == 1)? 'checked="checked"' : '' ?> type="radio" name="mail" value="<?php echo $signe['mail'] ?>" id="u<?php echo $id ?>" /><label for="u<?php echo $id ?>">To: <?php echo $signe['name'] ?></label><br />
						                              						<?php endforeach ?>
						                              					<?php endif; ?>
						                              					<?php if (isset($i) && $i == 0): ?>
						                              						<span>No users available</span>
						                              					<?php else: ?>
						                              						<?php if($signer['role_id'] != "1"){ ?>
								                              					<textarea class="form-control" name="message" id="message"></textarea>
								                              				<?php } ?>
						                              						<input name="submit" value="Send" type="submit" class="inverse-offset btn btn-success" />
						                              					<?php endif; ?>
						                            				</form>
						                          				</div>
						                        			</div>
						                      			</div>
						                    		</div>
						                  		</div>
						                  		<?php if (isset($signer['sign'])): ?>
						                  			<div class="data-content">
							                  			<img src="
								                  			<?php if(isset($signer['sign']['reject'])){ 
								                  				echo $signature_path.'rejected.png';
								                  			}else {
								                  				if ($signer['sign']['id'] == 217) {
								                  					echo $signature_path.'9f3a8-mr.-hossam.jpg';
								                  				}else{
								                  					echo $signature_path.'approved.png';
								                  				}
								                  			}?>
							                  			" alt="<?php echo $signer['sign']['name']; ?>" class="img-rounded sign-image">
							                    		<?php if (($signer['sign']['id'] == $user_id && $unsign_enable) || $is_admin): ?>
						                    				<a href="/shop_renting/unsign_change/<?php echo $change_signe_id; ?>" class="non-printable btn btn-primary unsign">Cancel</a>
							                    		<?php endif ?>
							                  		</div>
						                  			<div class="data-content">
						                  				<span class="name-data-content"><?php echo $signer['sign']['name']; ?></span>
						                  				<br />
						                  				<span class="timestamp-data-content"><?php echo $signer['sign']['timestamp']; ?></span>
						                  			</div>
						                  		<?php elseif (array_key_exists($user_id, $signer['queue']) && $change_queue_first): ?>
						                  			<?php $change_queue_first = FALSE; ?>
						                  			<div class="data-content non-printable"><span class="data-label sign-data-content"></span><a href="/shop_renting/change_sign/<?php echo $change_signe_id; ?>/reject" class="non-printable btn btn-danger">Reject</a><a href="/shop_renting/change_sign/<?php echo $change_signe_id; ?>" class="non-printable btn btn-success">sign</a></div>
						                  		<?php else: ?>
						                  			<?php $change_queue_first = FALSE; ?>
						                  		<?php endif ?>
						                	</div>
						                    <?php if (isset($signer['sign']['reject'])){break;}?>
						                <?php endforeach ?>
						                <p class="centered">The Shop Renting Prior Approval Form has been created by <?php echo $shop['name'];?> at <?php echo $shop['timestamp'];?></p>
						                <?php $hany = array();?>
						                <?php if($shop['changes'] == 1):?>
							                <?php foreach ($offers as $offer): ?>
						                		<?php if($offer['changed'] == 1):?>
								                	<?php $hany['timestamp'] = $offer['timestamp'];?>
								                	<?php $hany['user_name'] = $offer['user_name'];?>
						                		<?php endif;?>
							                <?php endforeach;?>
						                	<p class="centered">The Shop Renting Prior Approval Change Form has been created by <?php echo $hany['user_name'];?> at <?php echo $hany['timestamp'];?></p>
						                <?php endif;?>
						            </div>
						        <?php endif; ?>
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher non-printable">
	                			<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
	                  				<form action="/shop_renting/comment/<?php echo $shop['id']?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
	                    				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
	                     					<textarea class="form-control" name="comment" id="comment"></textarea>
	                    				</div>
	                    				<input name="shop_id" value="<?php echo $shop['id']?>" type="hidden" />
	                    				<input name="submit" value="Comment" type="submit" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-actions btn btn-success " />
	                  				</form>
	                			</div>
	              			</div>
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-holder">
	                			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher">
	                  				<div class="data-head centered"> 
	                    				<h3>Comments</h3> 
	                  				</div>
	                  				<div class="data-holder">
	                    				<?php foreach($comments as $comment ){ ?>
		                    				<div class="data-holder">
		                      					<span class="data-head"><?php echo $comment['fullname']; ?> :- </span><?php echo $comment['comment']; ?>
		                      					<span class="timestamp-data-content"><?php echo $comment['timestamp'];?></span>
		                    				</div>
	                    				<?php } ?>
	                  				</div>
	                			</div>  
	                		</div>
	                		 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-holder non-printable" dir="ltr">
                				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher">
                  					<div class="data-head centered"> 
                    					<h3>Log</h3> 
						</div>
                  					<div class="data-holder">
                    					<?php foreach($log as $loger ){ ?>
                    						<?php $value = json_decode($loger['data']);?>
                    						<?php if($loger['type'] == "Signature"){ ?>
		                    					<div class="data-holder">
		                      						<span class="data-head"><?php echo $loger['action'] ?> </span> By <?php echo $loger['name'] ?> 
		                      						<span class="timestamp-data-content"><?php echo $loger['timestamp'] ?></span>
	    			</div>		
	                    					<?php } ?>
	                    					<?php if($loger['type'] == "File"){ ?>
		                    					<div class="data-holder">
		                      						<span class="data-head"><?php echo $loger['action'] ?>:<span style="color: <?php echo ($loger['action'] == " File Has Been Uploaded")? "blue":"red"; ?>;"><?php  if($value->file !=null){echo $value->file;}  ?></span> </span> By <?php echo $loger['name'] ?>
		                      						<span class="timestamp-data-content"><?php echo $loger['timestamp'] ?></span>
	    		</div>
	                    					<?php } ?>
	                    					<?php if($loger['type'] == "Change"){ ?>
		                    					<div class="data-holder">
		                      					<span class="data-head"><?php echo $loger['action'] ?></span> By <?php echo $loger['name'] ?> 
			                      				<span class="timestamp-data-content"><?php echo $loger['timestamp'] ?></span>
	    		</div>
	                    					<?php } ?>
	                    					<?php if($loger['type'] == "Edit"){ ?>
	                    						<?php if($loger['action'] == "The Working Days Has Been Changed"){ ?>
	                    							<div class="data-holder">
			                      						<span class="data-head"><?php echo $loger['action'] ?></span> By <?php echo $loger['name'] ?> 
			                      						<span class="timestamp-data-content"><?php echo $loger['timestamp'] ?></span>
			</div>
	                    						<?php }else{ ?>
			                    					<div class="data-holder">
			                      						<span class="data-head"><?php echo $loger['action'] ?></span></span> By <?php echo $loger['name'] ?> 
			                      						<span class="timestamp-data-content"><?php echo $loger['timestamp'] ?></span>
		</div>
	                    						<?php } ?>
	                    					<?php } ?>
	                    				<?php } ?>
                  					</div>
                				</div>  
                			</div>
						</div>
	    			</div>		
	    		</div>
			</div>
		</div>
		<script type="text/javascript">
       		$(".expander-container").on("click", function(){
          		$(".expander-wrapper").hide();
          		$(this).parent().find(".expander-wrapper").toggle("fast");
         	});
          	$(".expander-remover").on("click", function(){
            	$(this).parent().hide("fast");
          	});
      	</script>
    	<script type="text/javascript">
      		function printDiv(divName) {
        		var printContents = document.getElementById(divName).innerHTML;
        		var originalContents = document.body.innerHTML;
        		document.body.innerHTML = printContents;
        		window.print();
        		document.body.innerHTML = originalContents;
      		}
    	</script>
    	<script type="text/javascript">
			$(document).ready(function() {
				$(document).on("click",'.whatsapp',function() {
					if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
						var text = $(this).attr("data-text");
						var url = $(this).attr("data-link");
						var message = encodeURIComponent(text)+" - "+encodeURIComponent(url);
						var whatsapp_url = "whatsapp://send?text="+message;
						window.location.href= whatsapp_url;
					} else {
						alert("Please share this post in your mobile device");
					}
				});
			});
		</script>
	</body>
</html>