-<!DOCTYPE html>
<html lang="en">
	<head>
		<?php $this->load->view('header'); ?>
	</head>
	<body>
		<div id="wrapper">
			<?php $this->load->view('menu') ?>
			<div id="page-wrapper">
					<div class="a4wrapper">
						<div class="a4page" dir="rtl" style="margin-bottom: 20px;">
							<div class="page-header" dir="ltr">
       							<button onclick="window.print()" class="non-printable form-actions btn btn-success" href="">Print</button>
							    <div class="header-logo"><img src="/assets/uploads/logos/<?php echo $contract['logo']; ?>"/></div>
                  				<h1 class="centered"><?php echo $contract['hotel_name']; ?></h1>
                  				<h2 class="centered"><?php echo $contract['brand']; ?></h2>
								<h3 class="centered">
	        						Contract No. #<?php echo $contract['id']; ?>
	        					</h3>
			        			<a class="form-actions btn btn-info non-printable" href="/contract/mail_me/<?php echo $contract['id'] ?>" style="float:left; margin-left: 20px;" > <img src="/assets/images/letter.png" style="width: 28px; height: 40px; margin: 0px; margin-left: -10px; margin-top: -10px; margin-bottom: -10px;"> Share by Email </a>
								<a data-text="whatsapp" data-link="<?php echo base_url(); ?>contract/view/<?php echo $contract['id'] ?>" style="float:left; margin-left: 20px;" class="whatsapp whatsapp_btn whatsapp_btn_small form-actions btn btn-success non-printable"> <img src="/assets/images/original.png" style="width: 70px; height: 50px; margin: -20px; margin-left: -30px; margin-top: -21px;"> Share by Whatsapp</a> 
								<a class="form-actions btn btn-success non-printable" href="/contract" style="float:right;"> Back </a>	    					
							</div>
							<br>
							<table class="table table-striped table-bordered table-condensed">
								<tr class="centered">
			                      	<td colspan="4" style="font-size:26px;">
			                        	عقد استغلال أماكن غير مجهزة لتقديم خدمات <?php echo $contract['service_name']; ?>
			                      	</td>
								</tr>
								<tr>
			                      	<td colspan="2" style="font-size:20px;">
			                        	المدينة
			                      	</td>
									<td colspan="2">
										<?php echo $contract['city']; ?>
									</td>
								</tr>
								<tr>
		                      		<td colspan="2" style="font-size:20px;">
		                        		الشركة المالكة
		                      		</td>
		                      		<td colspan="2">
										<?php echo $contract['company_name']; ?>
		                      		</td>
		                    	</tr>
								<tr>
		                      		<td colspan="2" style="font-size:20px;">
		                        		اسم الفندق
		                      		</td>
		                      		<td colspan="2">
										<?php echo $contract['hotel_name']; ?>
		                      		</td>
		                    	</tr>
								<tr>
		                      		<td colspan="2" style="font-size:20px;">
		                        		المستأجر
		                      		</td>
		                      		<td colspan="2">
										<?php echo $contract['name']; ?>
		                      		</td>
		                    	</tr>
								<tr>
		                      		<td colspan="2" style="font-size:20px;">
		                        		عنوان المستأجر
		                      		</td>
		                      		<td colspan="2">
										<?php echo $contract['address']; ?>
		                      		</td>
		                    	</tr>
								<tr>
		                      		<td colspan="2" style="font-size:20px;">
		                        		رقم البطاقة الضريبة
		                      		</td>
		                      		<td colspan="2">
		                      			<?php echo $contract['taxes'] ?>
		                      		</td>
		                    	</tr>
								<tr>
		                      		<td colspan="2" style="font-size:20px;">
		                        		رقم البطاقة الشخصية 
		                      		</td>
		                      		<td colspan="2">
		                      			<?php echo $contract['idp'] ?>
		                      		</td>
		                    	</tr>
								<tr>
		                      		<td colspan="2" style="font-size:20px;">
		                        		رقم السجل التجاري
		                      		</td>
		                      		<td colspan="2">
		                      			<?php echo $contract['licenss'] ?>
		                      		</td>
		                    	</tr>
								<tr>
		                      		<td colspan="2" style="font-size:20px;">
		                        		تاريخ بداية التعاقد
		                      		</td>
		                      		<td colspan="2">
										<?php echo $contract['start_date']; ?>
		                      		</td>
		                    	</tr>
								<tr>
                      				<td rowspan="2" colspan="1" style="font-size:20px;">
                        				المدة
                      				</td>
                      				<td colspan="1" style="font-size:20px;">
                        				من 
                      				</td>
                      				<td colspan="2">
										<?php echo $contract['from_date']; ?>
                     			 	</td>
                    			</tr>
                    			<tr>
                      				<td colspan="1" style="font-size:20px;">
                        				إلى
                      				</td>
                      				<td colspan="2">
										<?php echo $contract['to_date']; ?>
                      				</td>
                    			</tr>
                    			<?php if ($contract['hotel_id'] == 44) { ?>
	                    			<tr>
	                      				<td colspan="2" style="font-size:20px;">
	                        				القيمة الإيجارية لفندق Mamlouk Palace
	                      				</td>
	                      				<td colspan="2">
											<?php echo number_format($contract['rent_mp'],2,".",","); ?> <?php echo $contract['currency_mp']; ?>
	                     			 	</td>
	                    			</tr>
	                    			<tr>
	                      				<td colspan="2" style="font-size:20px;">
	                        				صافي القيمة الإيجارية بعد ضريبة <?php echo $contract['taxes_per']; ?>% لفندق Mamlouk Palace
	                      				</td>
	                      				<td colspan="2">
	                      					<?php $taxes3 = "1.".$contract['taxes_per'];?>
	                      					<?php $taxes = ($contract['rent_mp']/ $taxes3)*($contract['taxes_per']/100);?>
	                      					<?php $final = $contract['rent_mp']-$taxes;?>
											<?php echo number_format($final,2,".",","); ?> <?php echo $contract['currency_mp']; ?>
	                     			 	</td>
	                    			</tr>
	                    			<tr>
	                      				<td colspan="2" style="font-size:20px;">
	                        				القيمة الإيجارية لفندق Garden Beach
	                      				</td>
	                      				<td colspan="2">
											<?php echo number_format($contract['rent_gb'],2,".",","); ?> <?php echo $contract['currency_gb']; ?>
	                     			 	</td>
	                    			</tr>
	                    			<tr>
	                      				<td colspan="2" style="font-size:20px;">
	                        				صافي القيمة الإيجارية بعد ضريبة <?php echo $contract['taxes_per']; ?>% لفندق Garden Beach
	                      				</td>
	                      				<td colspan="2">
	                      					<?php $taxes4 = "1.".$contract['taxes_per'];?>
	                      					<?php $taxes1 = ($contract['rent_gb']/$taxes4)*($contract['taxes_per']/100);?>
	                      					<?php $final1 = $contract['rent_gb']-$taxes1;?>
											<?php echo number_format($final1,2,".",","); ?> <?php echo $contract['currency_gb']; ?>
	                     			 	</td>
	                    			</tr>
                    			<?php }else{ ?>
                    				<tr>
                      				<td colspan="2" style="font-size:20px;">
                        				القيمة الإيجارية
                      				</td>
                      				<td colspan="2">
										<?php echo number_format($contract['rent'],2,".",","); ?> <?php echo $contract['currency']; ?>
                     			 	</td>
                    			</tr>
                    			<tr>
	                      			<td colspan="2" style="font-size:20px;">
	                        			صافي القيمة الإيجارية بعد ضريبة <?php echo $contract['taxes_per']; ?>%
	                      			</td>
	                      			<td colspan="2">
	                      				<?php $taxes5 = "1.".$contract['taxes_per'];?>
	                      				<?php $taxes2 = ($contract['rent']/$taxes5)*($contract['taxes_per']/100);?>
	                      				<?php $final2 = $contract['rent']-$taxes2;?>
										<?php echo number_format($final2,2,".",","); ?> <?php echo $contract['currency']; ?>
	                     			 </td>
	                    		</tr>
                    			<?php } ?>
                    			<?php if ($contract['hotel_id'] == 44) { ?>
	                    			<tr>
	                      				<td colspan="2" style="font-size:20px;">
	                        				القيمة التأمينية لفندق Mamlouk Palace
	                      				</td>
	                      				<td colspan="2">
											<?php echo number_format($contract['safty_mp'],2,".",","); ?> <?php echo $contract['currency1_mp']; ?>
	                     			 	</td>
	                    			</tr>
	                    			<tr>
	                      				<td colspan="2" style="font-size:20px;">
	                        				القيمة التأمينية لفندق Garden Beach
	                      				</td>
	                      				<td colspan="2">
											<?php echo number_format($contract['safty_gb'],2,".",","); ?> <?php echo $contract['currency1_gb']; ?>
	                     			 	</td>
	                    			</tr>
                    			<?php }else{ ?>
                    				<tr>
	                      				<td colspan="2" style="font-size:20px;">
	                        				القيمة التأمينية
	                      				</td>
	                      				<td colspan="2">
											<?php echo number_format($contract['safty'],2,".",","); ?> <?php echo $contract['currency1']; ?>
	                     			 	</td>
	                    			</tr>
                    			<?php } ?>
                    			<?php if ($contract['hotel_id'] == 44) { ?>
	                    			<tr>
	                      				<td colspan="2" style="font-size:20px;">
	                        				مبلغ التعويض لفندق Mamlouk Palace
	                      				</td>
	                      				<td colspan="2">
											<?php echo number_format($contract['compensation_mp'],2,".",","); ?> <?php echo $contract['currency2_mp']; ?>
	                     			 	</td>
	                    			</tr>
	                    			<tr>
	                      				<td colspan="2" style="font-size:20px;">
	                        				مبلغ التعويض لفندق Garden Beach
	                      				</td>
	                      				<td colspan="2">
											<?php echo number_format($contract['compensation_gb'],2,".",","); ?> <?php echo $contract['currency2_gb']; ?>
	                     			 	</td>
	                    			</tr>
                    			<?php }else{ ?>
                    				<tr>
	                      				<td colspan="2" style="font-size:20px;">
	                        				مبلغ التعويض
	                      				</td>
	                      				<td colspan="2">
											<?php echo number_format($contract['compensation'],2,".",","); ?> <?php echo $contract['currency2']; ?>
	                     			 	</td>
	                    			</tr>
                    			<?php } ?>
                    			<tr>
                      				<td colspan="2" style="font-size:20px;">
                        				أيام العمل
                      				</td>
                      				<td colspan="2">
                      					<?php foreach($days as $day): ?>
											<?php echo $day['day_name']; ?>&nbsp;
		                        		<?php endforeach ?>	
                     			 	</td>
                    			</tr>
                    			<tr>
                      				<td colspan="2" style="font-size:20px;">
                        				مقدار الزيادة السنوية
                      				</td>
                      				<td colspan="2">
										<?php echo $contract['increase']; ?> %
                     			 	</td>
                    			</tr>
                    			<tr>
                      				<td colspan="2" style="font-size:20px;">
                        				تكاليف الكهرباء 
                      				</td>
                      				<td colspan="2">
                      					<?php if ($contract['elec_choice'] == 3) {?>
											<?php echo $contract['electricity']; ?> <?php echo $contract['currency3']; ?>
										<?php }else{ ?>
											<?php echo $contract['elec_choice']; ?>
                      					<?php } ?>
                     			 	</td>
                    			</tr>
                    			<tr>
                      				<td colspan="2" style="font-size:20px;">
                        				توصيف المكان
                      				</td>
                      				<td colspan="2">
										<?php echo $contract['location']; ?>
                     			 	</td>
                    			</tr>
                    			<tr>
                      				<td colspan="2" style="font-size:20px;">
                        				توصيف النشاط 
                      				</td>
                      				<td colspan="2">
										<?php echo $contract['activity']; ?>
                     			 	</td>
                    			</tr>
                    			<tr>
                      				<td colspan="2" style="font-size:20px;">
                        				اى بيانات اخرى يريد الفندق إضافتها 
                      				</td>
                      				<td colspan="2">
										<?php echo $contract['others']; ?>
                     			 	</td>
                    			</tr>
							</table>
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher data-indention non-printable">
	                      		<label for="offers" style="font-size:20px;">ملفات إضافية</label>
								<div class="form-group col-lg-9 col-md-8 col-sm-7 col-xs-7">
	                       			<?php foreach($uploads as $upload): ?>
	                       				<a href='/assets/uploads/files/<?php echo $upload['name'] ?>'><?php echo $upload['name'] ?></a><br />
	                        		<?php endforeach ?>			
	                      		</div>	
                      		</div>	
                  			<a href="<?= base_url(); ?>contract/submit_summry/<?php echo $summary['id']; ?>" class="btn btn-success non-printable">submit</a>
                  			<a href="<?= base_url(); ?>contract/summry/<?php echo $summary['new_id']; ?>" class="btn btn-warning non-printable">Cancel</a>
						</div>
                		<div class="data-content">
    						<p class="centered">The Contract has been created by <?php echo $contract['user_name'];?> at <?php echo $contract['timestamp'];?></p>
    					</div>
					</div>
				</div>
			</div>
	</body>
</html>