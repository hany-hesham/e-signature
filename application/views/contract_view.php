-<!DOCTYPE html>
<html lang="en">
	<head>
		<?php $this->load->view('header'); ?>
		<style>
      @media print {

        .data-catcher{
          height: 140px !important;
        }

        .header-logo>img{
          width: 80px;
          height: 40px;
        }

        .header-logo>h3{
          font-size:10px;
          font-weight: bold;
        }

        .data-head>h3{
          font-size:10px;
        }

        h1{
          font-size:18px;
          font-weight: bold;
        }

        td{
          font-size: 12px !important;
        }

        .signature-wrapper{
          height: 70px;
          width: 140px;
        }

        .data-head {
          font-size:10px;
        }

        .data-content>img{
          height: 15px;
          width: 30px;
        }

        .timestamp-data-content{
          font-size: 10px;
        }

        .data-content{
          font-size: 10px;
        }

        table {
          height: 100px !important;
        }

        .print_button{
          display: none;
        }
      }
</style>
	</head>
	<body>
		<div id="wrapper">
			<?php $this->load->view('menu') ?>
			<div id="page-wrapper">
					<div class="a4wrapper">
						<div class="a4page" dir="rtl" style="margin-bottom: 20px;">
							<div class="page-header" dir="ltr">
       							<button onclick="window.print()" class="non-printable form-actions btn btn-success" href="">Print</button>
								<?php if ($is_editor): ?>
									<a class="form-actions btn btn-info non-printable" href="/contract/edit/<?php echo $contract['id'] ?>" style="float:right;" > Edit </a>
								<?php endif ?>
								<?php if ($is_credit && !$summary): ?>
									<a class="form-actions btn btn-info non-printable" href="/contract/summry/<?php echo $contract['id'] ?>" style="float: right;" > Contract Summary </a>
								<?php endif ?>
								<?php if ($summary): ?>
									<a class="form-actions btn btn-info non-printable" href="/contract/view_summary/<?php echo $summary['id'] ?>" style="float:right;" > View Contract Summary </a>
								<?php endif ?>
								<?php if ($is_lowyer): ?>
									<a class="form-actions btn btn-info non-printable" href="/contract/edit_upload/<?php echo $contract['id'] ?>" style="float:right;" > Upload Contract </a>
								<?php endif ?>
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
							<table class="table table-striped table-bordered table-condensed centered" style="width: 790px !important;">
								<tr class="centered">
			                      	<td colspan="6" style="font-size:26px;" style="width: 790px;">
			                        	عقد استغلال أماكن غير مجهزة لتقديم خدمات <?php echo $contract['service_name']; ?>
			                      	</td>
								</tr>
								<tr class="centered">
			                      <td colspan="2"  style="font-size:26px;"> &nbsp; &nbsp; </td>
			                      <td colspan="2"  style="font-size:26px; width: 350px;"> عقد جديد </td>
			                      <td colspan="2"  style="font-size:26px; width: 350px;"> عقد قديم </td>
			                    </tr>
								<tr>
			                      	<td colspan="2" style="font-size:20px; text-align: right;">
			                        	المدينة
			                      	</td>
									<td colspan="4" style="width: 700px;">
										<?php echo $contract['city']; ?>
									</td>
								</tr>
								<tr>
		                      		<td colspan="2" style="font-size:20px; text-align: right;">
		                        		الشركة المالكة
		                      		</td>
		                      		<td colspan="4" style="width: 700px;">
										<?php echo $contract['company_name']; ?>
		                      		</td>
		                    	</tr>
								<tr>
		                      		<td colspan="2" style="font-size:20px;  text-align: right;">
		                        		اسم الفندق
		                      		</td>
		                      		<td colspan="4" style="width: 700px;">
										<?php echo $contract['hotel_name']; ?>
		                      		</td>
		                    	</tr>
								<tr>
		                      		<td colspan="2" style="font-size:20px;  text-align: right;">
		                        		المستأجر
		                      		</td>
		                      		<td colspan="2" style="width: 350px;">
										<?php echo $contract['name']; ?>
		                      		</td>
		                      		<td colspan="2" style="width: 350px;">
										<?php echo $contract['name_old']; ?>
		                      		</td>
		                    	</tr>
								<tr>
		                      		<td colspan="2" style="font-size:20px;  text-align: right;">
		                        		عنوان المستأجر
		                      		</td>
		                      		<td colspan="2" style="width: 350px;">
										<?php echo $contract['address']; ?>
		                      		</td>
		                      		<td colspan="2" style="width: 350px;">
										<?php echo $contract['address_old']; ?>
		                      		</td>
		                    	</tr>
								<tr>
		                      		<td colspan="2" style="font-size:20px;  text-align: right;">
		                        		رقم البطاقة الضريبة
		                      		</td>
		                      		<td colspan="2" style="width: 350px;">
		                      			<?php echo $contract['taxes'] ?>
		                      		</td>
		                      		<td colspan="2" style="width: 350px;">
		                      			<?php echo $contract['taxes_old'] ?>
		                      		</td>
		                    	</tr>
								<tr>
		                      		<td colspan="2" style="font-size:20px;  text-align: right;">
		                        		رقم البطاقة الشخصية 
		                      		</td>
		                      		<td colspan="2" style="width: 350px;">
		                      			<?php echo $contract['idp'] ?>
		                      		</td>
		                      		<td colspan="2" style="width: 350px;">
		                      			<?php echo $contract['idp_old'] ?>
		                      		</td>
		                    	</tr>
								<tr>
		                      		<td colspan="2" style="font-size:20px;  text-align: right;">
		                        		رقم السجل التجاري
		                      		</td>
		                      		<td colspan="2" style="width: 350px;">
		                      			<?php echo $contract['licenss'] ?>
		                      		</td>
		                      		<td colspan="2" style="width: 350px;">
		                      			<?php echo $contract['licenss_old'] ?>
		                      		</td>
		                    	</tr>
								<tr>
		                      		<td colspan="2" style="font-size:20px;  text-align: right;">
		                        		تاريخ بداية التعاقد
		                      		</td>
		                      		<td colspan="2" style="width: 350px;">
										<?php echo $contract['start_date']; ?>
		                      		</td>
		                      		<td colspan="2" style="width: 350px;">
										<?php echo $contract['start_date_old']; ?>
		                      		</td>
		                    	</tr>
								<tr>
                      				<td rowspan="2" colspan="1" style="font-size:20px;  text-align: right;">
                        				المدة
                      				</td>
                      				<td rowspan="1" colspan="1" style="font-size:20px;  text-align: right;">
                        				من 
                      				</td>
                      				<td colspan="2" style="width: 350px;">
										<?php echo $contract['from_date']; ?>
                     			 	</td>
                     			 	<td colspan="2" style="width: 350px;">
										<?php echo $contract['from_date_old']; ?>
                     			 	</td>
                    			</tr>
                    			<tr>
                      				<td rowspan="1" colspan="1" style="font-size:20px;  text-align: right;">
                        				إلى
                      				</td>
                      				<td colspan="2" style="width: 350px;">
										<?php echo $contract['to_date']; ?>
                      				</td>
                      				<td colspan="2" style="width: 350px;">
										<?php echo $contract['to_date_old']; ?>
                      				</td>
                    			</tr>
                    			<?php if ($contract['hotel_id'] == 44) { ?>
	                    			<tr>
	                      				<td colspan="2" style="font-size:20px;  text-align: right;">
	                        				القيمة الإيجارية لفندق Mamlouk Palace
	                      				</td>
	                      				<td colspan="2" style="width: 350px;">
											<?php echo number_format($contract['rent_mp'],2,".",","); ?> <?php echo $contract['currency_mp']; ?>
	                     			 	</td>
	                     			 	<td colspan="2" style="width: 350px;">
											<?php echo number_format($contract['rent_mp_old'],2,".",","); ?> <?php echo $contract['currency_mp_old']; ?>
	                     			 	</td>
	                    			</tr>
	                    			<tr>
	                      				<td colspan="2" style="font-size:20px;  text-align: right;">
	                        				صافي القيمة الإيجارية بعد ضريبة <?php echo $contract['taxes_per']; ?>% لفندق Mamlouk Palace
	                      				</td>
	                      				<td colspan="2" style="width: 350px;">
	                      					<?php $taxes3 = "1.".$contract['taxes_per'];?>
	                      					<?php $taxes = ($contract['rent_mp']/ $taxes3)*($contract['taxes_per']/100);?>
	                      					<?php $final = $contract['rent_mp']-$taxes;?>
											<?php echo number_format($final,2,".",","); ?> <?php echo $contract['currency_mp']; ?>
	                     			 	</td>
	                     			 	<td colspan="2" style="width: 350px;">
	                      					<?php $taxess3 = "1.".$contract['taxes_per_old'];?>
	                      					<?php $taxess = ($contract['rent_mp_old']/ $taxess3)*($contract['taxes_per_old']/100);?>
	                      					<?php $finals = $contract['rent_mp_old']-$taxess;?>
											<?php echo number_format($finals,2,".",","); ?> <?php echo $contract['currency_mp_old']; ?>
	                     			 	</td>
	                    			</tr>
	                    			<tr>
	                      				<td colspan="2" style="font-size:20px;  text-align: right;">
	                        				القيمة الإيجارية لفندق Garden Beach
	                      				</td>
	                      				<td colspan="2" style="width: 350px;">
											<?php echo number_format($contract['rent_gb'],2,".",","); ?> <?php echo $contract['currency_gb']; ?>
	                     			 	</td>
	                     			 	<td colspan="2" style="width: 350px;">
											<?php echo number_format($contract['rent_gb_old'],2,".",","); ?> <?php echo $contract['currency_gb_old']; ?>
	                     			 	</td>
	                    			</tr>
	                    			<tr>
	                      				<td colspan="2" style="font-size:20px;  text-align: right;">
	                        				صافي القيمة الإيجارية بعد ضريبة <?php echo $contract['taxes_per']; ?>% لفندق Garden Beach
	                      				</td>
	                      				<td colspan="2" style="width: 350px;">
	                      					<?php $taxes4 = "1.".$contract['taxes_per'];?>
	                      					<?php $taxes1 = ($contract['rent_gb']/$taxes4)*($contract['taxes_per']/100);?>
	                      					<?php $final1 = $contract['rent_gb']-$taxes1;?>
											<?php echo number_format($final1,2,".",","); ?> <?php echo $contract['currency_gb']; ?>
	                     			 	</td>
	                     			 	<td colspan="2" style="width: 350px;">
	                      					<?php $taxess4 = "1.".$contract['taxes_per_old'];?>
	                      					<?php $taxess1 = ($contract['rent_gb_old']/$taxess4)*($contract['taxes_per_old']/100);?>
	                      					<?php $finals1 = $contract['rent_gb_old']-$taxess1;?>
											<?php echo number_format($finals1,2,".",","); ?> <?php echo $contract['currency_gb_old']; ?>
	                     			 	</td>
	                    			</tr>
                    			<?php }else{ ?>
                    				<tr>
                      				<td colspan="2" style="font-size:20px;  text-align: right;">
                        				القيمة الإيجارية
                      				</td>
                      				<td colspan="2" style="width: 350px;">
										<?php echo number_format($contract['rent'],2,".",","); ?> <?php echo $contract['currency']; ?>
                     			 	</td>
                     			 	<td colspan="2" style="width: 350px;">
										<?php echo number_format($contract['rent_old'],2,".",","); ?> <?php echo $contract['currency_old']; ?>
                     			 	</td>
                    			</tr>
                    			<tr>
	                      			<td colspan="2" style="font-size:20px;  text-align: right;">
	                        			صافي القيمة الإيجارية بعد ضريبة <?php echo $contract['taxes_per']; ?>%
	                      			</td>
	                      			<td colspan="2" style="width: 350px;">
	                      				<?php $taxes5 = "1.".$contract['taxes_per'];?>
	                      				<?php $taxes2 = ($contract['rent']/$taxes5)*($contract['taxes_per']/100);?>
	                      				<?php $final2 = $contract['rent']-$taxes2;?>
										<?php echo number_format($final2,2,".",","); ?> <?php echo $contract['currency']; ?>
	                     			 </td>
	                     			 <td colspan="2" style="width: 350px;">
	                      				<?php $taxess5 = "1.".$contract['taxes_per_old'];?>
	                      				<?php $taxess2 = ($contract['rent_old']/$taxess5)*($contract['taxes_per_old']/100);?>
	                      				<?php $finals2 = $contract['rent_old']-$taxess2;?>
										<?php echo number_format($finals2,2,".",","); ?> <?php echo $contract['currency_old']; ?>
	                     			 </td>
	                    		</tr>
                    			<?php } ?>
                    			<?php if ($contract['hotel_id'] == 44) { ?>
	                    			<tr>
	                      				<td colspan="2" style="font-size:20px;  text-align: right;">
	                        				القيمة التأمينية لفندق Mamlouk Palace
	                      				</td>
	                      				<td colspan="2" style="width: 350px;">
											<?php echo number_format($contract['safty_mp'],2,".",","); ?> <?php echo $contract['currency1_mp']; ?>
	                     			 	</td>
	                     			 	<td colspan="2" style="width: 350px;">
											<?php echo number_format($contract['safty_mp_old'],2,".",","); ?> <?php echo $contract['currency1_mp_old']; ?>
	                     			 	</td>
	                    			</tr>
	                    			<tr>
	                      				<td colspan="2" style="font-size:20px;  text-align: right;">
	                        				القيمة التأمينية لفندق Garden Beach
	                      				</td>
	                      				<td colspan="2" style="width: 350px;">
											<?php echo number_format($contract['safty_gb'],2,".",","); ?> <?php echo $contract['currency1_gb']; ?>
	                     			 	</td>
	                     			 	<td colspan="2" style="width: 350px;">
											<?php echo number_format($contract['safty_gb_old'],2,".",","); ?> <?php echo $contract['currency1_gb_old']; ?>
	                     			 	</td>
	                    			</tr>
                    			<?php }else{ ?>
                    				<tr>
	                      				<td colspan="2" style="font-size:20px;  text-align: right;">
	                        				القيمة التأمينية
	                      				</td>
	                      				<td colspan="2" style="width: 350px;">
											<?php echo number_format($contract['safty'],2,".",","); ?> <?php echo $contract['currency1']; ?>
	                     			 	</td>
	                     			 	<td colspan="2" style="width: 350px;">
											<?php echo number_format($contract['safty_old'],2,".",","); ?> <?php echo $contract['currency1_old']; ?>
	                     			 	</td>
	                    			</tr>
                    			<?php } ?>
                    			<?php if ($contract['hotel_id'] == 44) { ?>
	                    			<tr>
	                      				<td colspan="2" style="font-size:20px;  text-align: right;">
	                        				مبلغ التعويض لفندق Mamlouk Palace
	                      				</td>
	                      				<td colspan="2" style="width: 350px;">
											<?php echo number_format($contract['compensation_mp'],2,".",","); ?> <?php echo $contract['currency2_mp']; ?>
	                     			 	</td>
	                     			 	<td colspan="2" style="width: 350px;">
											<?php echo number_format($contract['compensation_mp_old'],2,".",","); ?> <?php echo $contract['currency2_mp_old']; ?>
	                     			 	</td>
	                    			</tr>
	                    			<tr>
	                      				<td colspan="2" style="font-size:20px;  text-align: right;">
	                        				مبلغ التعويض لفندق Garden Beach
	                      				</td>
	                      				<td colspan="2" style="width: 350px;">
											<?php echo number_format($contract['compensation_gb'],2,".",","); ?> <?php echo $contract['currency2_gb']; ?>
	                     			 	</td>
	                     			 	<td colspan="2" style="width: 350px;">
											<?php echo number_format($contract['compensation_gb_old'],2,".",","); ?> <?php echo $contract['currency2_gb_old']; ?>
	                     			 	</td>
	                    			</tr>
                    			<?php }else{ ?>
                    				<tr>
	                      				<td colspan="2" style="font-size:20px;  text-align: right;">
	                        				مبلغ التعويض
	                      				</td>
	                      				<td colspan="2" style="width: 350px;">
											<?php echo number_format($contract['compensation'],2,".",","); ?> <?php echo $contract['currency2']; ?>
	                     			 	</td>
	                     			 	<td colspan="2" style="width: 350px;">
											<?php echo number_format($contract['compensation_old'],2,".",","); ?> <?php echo $contract['currency2_old']; ?>
	                     			 	</td>
	                    			</tr>
                    			<?php } ?>
                    			<tr>
                      				<td colspan="2" style="font-size:20px;  text-align: right;">
                        				أيام العمل
                      				</td>
                      				<td colspan="4" style="width: 700px;">
                      					<?php foreach($days as $day): ?>
											<?php echo $day['day_name']; ?>&nbsp;
		                        		<?php endforeach ?>	
                     			 	</td>
                    			</tr>
                    			<tr>
                      				<td colspan="2" style="font-size:20px;  text-align: right;">
                        				مقدار الزيادة السنوية
                      				</td>
                      				<td colspan="4" style="width: 700px;">
										<?php echo $contract['increase']; ?> %
                     			 	</td>
                    			</tr>
                    			<tr>
                      				<td colspan="2" style="font-size:20px;  text-align: right;">
                        				تكاليف الكهرباء 
                      				</td>
                      				<td colspan="4" style="width: 700px;">
                      					<?php if ($contract['elec_choice'] == 3) {?>
											<?php echo $contract['electricity']; ?> <?php echo $contract['currency3']; ?>
										<?php }else{ ?>
											<?php echo $contract['elec_choice']; ?>
                      					<?php } ?>
                     			 	</td>
                    			</tr>
                    			<tr>
                      				<td colspan="2" style="font-size:20px;  text-align: right;">
                        				توصيف المكان
                      				</td>
                      				<td colspan="4" style="width: 700px;">
										<?php echo $contract['location']; ?>
                     			 	</td>
                    			</tr>
                    			<tr>
                      				<td colspan="2" style="font-size:20px;  text-align: right;">
                        				توصيف النشاط 
                      				</td>
                      				<td colspan="4" style="width: 700px;">
										<?php echo $contract['activity']; ?>
                     			 	</td>
                    			</tr>
                    			<tr>
                      				<td colspan="2" style="font-size:20px;  text-align: right;">
                        				اى بيانات اخرى يريد الفندق إضافتها 
                      				</td>
                      				<td colspan="2" style="width: 350px !important;">
										<?php echo $contract['others']; ?>
                     			 	</td>
                     			 	<td colspan="2" style="width: 350px !important;">
										<?php echo $contract['others_old']; ?>
                     			 	</td>
                    			</tr>
							</table>
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher data-indention non-printable">
	                      		<label for="offers" style="font-size:20px;">ملفات إضافية</label>
								<div class="form-group col-lg-9 col-md-12 col-sm-7 col-xs-7">
	                       			<?php foreach($uploads as $upload): ?>
	                       				<a href='/assets/uploads/files/<?php echo $upload['name'] ?>'><?php echo $upload['name'] ?></a> تم الرفع بواسطة <?php echo $upload['user_name'] ?> في <?php echo $upload['timestamp'] ?><br />
	                        		<?php endforeach ?>			
	                      		</div>	
                      		</div>	
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher centered" dir="ltr">
			                	<?php $queue_first = TRUE; ?>
			                	<?php foreach ($signers as $signe_id => $signer): ?>
			                	<div class="signature-wrapper">
			                  		<div class="data-head relative"><?php echo (strlen($signer['role']) == 0)? "Contract Owner" : $signer['role'] ?>
			                    		<span class="expander-container"><i class='glyphicon glyphicon-envelope'></i></span>
			                    		<div class="expander-wrapper">
			                      			<span class="expander-remover"><i class='glyphicon glyphicon-remove'></i></span>
			                      			<div class="expander">
			                        			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-holder">
			                          				<div class="row">
			                            				<form action="/contract/mail/<?php echo $contract['id']; ?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
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
			                              					<textarea class="form-control" name="message" id="message"></textarea>
			                              					<input name="submit" value="Send" type="submit" class="inverse-offset btn btn-success" />
			                              					<?php endif; ?>
			                            				</form>
			                          				</div>
			                        			</div>
			                      			</div>
			                    		</div>
			                  		</div>
			                  		<?php //die(print_r($signer['sign'])); ?>
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
			                    		<a href="/contract/unsign/<?php echo $signe_id; ?>" class="non-printable btn btn-primary unsign">Cancel</a>
			                    		<?php endif ?>
			                  		</div>
			                  		<div class="data-content">
			                  			<span class="name-data-content"><?php echo $signer['sign']['name']; ?></span>
			                  			<br />
			                  			<span class="timestamp-data-content"><?php echo $signer['sign']['timestamp']; ?></span>
			                  		</div>
			                  		<?php elseif (array_key_exists($user_id, $signer['queue']) && $queue_first && $role_id !=142): ?>
			                  		<?php $queue_first = FALSE; ?>
			                  		<div class="data-content non-printable"><span class="data-label sign-data-content"></span><a href="/contract/sign/<?php echo $signe_id; ?>/reject" class="non-printable btn btn-danger">Reject</a><a href="/contract/sign/<?php echo $signe_id; ?>" class="non-printable btn btn-success">sign</a></div>
			                  		<?php else: ?>
			                  		<?php $queue_first = FALSE; ?>
			                  		<?php endif ?>
			                	</div>
			                    <?php if (isset($signer['sign']['reject'])){break;}?>
			                	<?php endforeach ?>

			              	</div>
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher non-printable" >
                				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  					<form action="/contract/comment/<?php echo $contract['id']?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
                    					<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                     						<textarea class="form-control" name="comment" id="comment"></textarea>
                    					</div>
                    					<input name="contr_id" value="<?php echo $contract['id']?>" type="hidden" />
                    					<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    						<br>
                    						<input type="hidden" name="assumed_id" value="<?php echo $assumed_id; ?>" />
                    						<label for="offers" style="font-size:20px;">ملفات إضافية</label>
						                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						                      <input id="offers" name="upload" type="file" class="file" multiple="true" data-show-upload="true" data-show-caption="true">
						                    </div>
                    						<script>
                      							$("#offers").fileinput({
                        							uploadUrl: "/contract/comment_upload/<?php echo $assumed_id; ?>",
							                        uploadAsync: true,
							                        minFileCount: 1,
							                        maxFileCount: 5,
							                        overwriteInitial: false,
                        							initialPreviewConfig: [
                          								<?php foreach($uploads as $upload): ?>
                            								{url: "/contract/comment_remove/<?php echo $assumed_id ?>/<?php echo $upload['id'] ?>", key: "<?php echo $upload['name']; ?>"},
                          								<?php endforeach; ?>
                        							],
                      							});
                    						</script>
                  						</div>
                    					<input name="submit" value="Comment" type="submit" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-actions btn btn-success " />
                  					</form>
                				</div>
              				</div>
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-holder" dir="ltr">
                				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher">
                  					<div class="data-head centered"> 
                    					<h3>Comments</h3> 
                  					</div>
                  					<div class="data-holder">
                    					<?php foreach($comments as $comment ){ ?>
                    					<div class="data-holder">
                      						<span class="data-head"><?php echo $comment['fullname']; ?> :- </span><?php echo $comment['comment']; ?>
                      						<span class="timestamp-data-content"><?php echo $comment['created'];?></span>
                      						<div>
				                       			<?php foreach($comment['filles'] as $filles): ?>
				                       				<a href='/assets/uploads/files/<?php echo $filles['name'] ?>'><?php echo $filles['name'] ?></a> تم الرفع بواسطة <?php echo $filles['user_name'] ?> في <?php echo $filles['timestamp'] ?><br />
				                        		<?php endforeach ?>			
				                      		</div>
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
                    						<?php if(($loger['type'] == "New") || ($loger['type'] == "Signature")){ ?>
		                    					<div class="data-holder">
		                      						<span class="data-head"><?php echo $loger['action'] ?> </span> By <?php echo $loger['name'] ?> 
		                      						<span class="timestamp-data-content"><?php echo $loger['timestamp'] ?></span>
		                    					</div>
	                    					<?php } ?>
	                    					<?php if($loger['type'] == "File"){ ?>
		                    					<div class="data-holder">
		                      						<span class="data-head"><?php echo $loger['action'] ?>:<span style="color: <?php echo ($loger['action'] == "New File Has Been Uploaded")? "blue":"red"; ?>;"><?php echo $value->file ?></span> </span> By <?php echo $loger['name'] ?> 
		                      						<span class="timestamp-data-content"><?php echo $loger['timestamp'] ?></span>
		                    					</div>
	                    					<?php } ?>
	                    					<?php if($loger['type'] == "Update"){ ?>
	                    						<?php if($loger['action'] == "The Working Days Has Been Changed"){ ?>
	                    							<div class="data-holder">
			                      						<span class="data-head"><?php echo $loger['action'] ?></span> By <?php echo $loger['name'] ?> 
			                      						<span class="timestamp-data-content"><?php echo $loger['timestamp'] ?></span>
			                    					</div>
	                    						<?php }else{ ?>
			                    					<div class="data-holder">
			                      						<span class="data-head"><?php echo $loger['action'] ?> From <span style="color: red;"><?php echo ($value->old == "")? "Blank":$value->old ?></span> To <span style="color: blue;"><?php echo $value->new ?></span></span> By <?php echo $loger['name'] ?> 
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
			<script type="text/javascript">
       			$(".expander-container").on("click", function(){
          			$(".expander-wrapper").hide();
          			$(this).parent().find(".expander-wrapper").toggle("fast");
         		});
          		$(".expander-remover").on("click", function(){
            		$(this).parent().hide("fast");
          		});
      		</script>
    	</div>
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