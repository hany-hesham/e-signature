<!DOCTYPE html>
<html lang="en">
	<head>
		<?php $this->load->view('header'); ?>
		<style>
      @media print {

        .data-catcher{
          height: 220px !important;
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
          font-size: 16px !important;
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
						<div class="a4page" style="margin-bottom: 20px;">
							<div class="page-header">
       							<button onclick="window.print()" class="non-printable form-actions btn btn-success" href="">Print</button>
								<a class="form-actions btn btn-info non-printable" href="/contract/view/<?php echo $new['id'] ?>" style="float:right;" > View Contract </a>
							    <div class="header-logo"><img src="/assets/uploads/logos/<?php echo $summary['logo']; ?>"/></div>
                  				<h1 class="centered"><?php echo $summary['hotel_name']; ?></h1>
                  				<h2 class="centered"><?php echo $new['brand']; ?></h2>
								<h3 class="centered">
	        						Contract No. #<?php echo $summary['new_id']; ?>
	        					</h3>
			        			<a class="form-actions btn btn-info non-printable" href="/contract/sum_mail_me/<?php echo $summary['id'] ?>" style="float:left; margin-left: 20px;" > <img src="/assets/images/letter.png" style="width: 28px; height: 40px; margin: 0px; margin-left: -10px; margin-top: -10px; margin-bottom: -10px;"> Share by Email </a>
								<a data-text="whatsapp" data-link="<?php echo base_url(); ?>contract/view_summary/<?php echo $summary['id'] ?>" style="float:left; margin-left: 20px;" class="whatsapp whatsapp_btn whatsapp_btn_small form-actions btn btn-success non-printable"> <img src="/assets/images/original.png" style="width: 70px; height: 50px; margin: -20px; margin-left: -30px; margin-top: -21px;"> Share by Whatsapp</a> 
								<a class="form-actions btn btn-success non-printable" href="/contract" style="float:right;"> Back </a>	    					
							</div>
							<br>
							<table class="table table-striped table-bordered table-condensed" style="width: 780px !important; margin-left: 6px; margin-top: 6px;">
			                    <tr>
			                      <td colspan="1" style="font-size:20px;">
			                        Hotel Name
			                      </td>
			                      <td colspan="4" class="centered">
			                        <?php echo $new['hotel_name']; ?>
			                      </td>
			                    </tr>
			                    <tr>
			                      <td colspan="1" style="font-size:20px;">
			                        Contract Title
			                      </td>
			                      <td colspan="4" class="centered">
			                        <?php echo $new['service_name']; ?>
			                      </td>
			                    </tr>
			                    <tr class="centered">
			                      <td colspan="1"> &nbsp; &nbsp; </td>
			                      <td colspan="2"  style="font-size:20px; width: 350px !important;"> Old Contract Details </td>
			                      <td colspan="2"  style="font-size:20px; width: 350px !important;"> New Contract Details </td>
			                    </tr>
			                    <tr>
			                      <td colspan="1"  style="font-size:20px;"> Contractor Name </td>
			                      <td colspan="2" class="centered" style="width: 350px !important;"> <?php echo $new['name_en_old']; ?> </td>
			                      <td colspan="2" class="centered" style="width: 350px !important;"> <?php echo $new['name_en']; ?> </td>
			                    </tr>
			                    <tr>
			                      <?php 
			                        $old_date1 = strtotime($new['from_date_old']);
			                        $old_date2 = strtotime($new['to_date_old']); 
			                        $old_date = $old_date2 - $old_date1;
			                        $old_years = floor($old_date / (365*60*60*24));
			                        $old_months = floor(($old_date - $old_years * 365*60*60*24) / (30*60*60*24));
			                        $old_days = floor(($old_date - $old_years * 365*60*60*24 - $old_months*30*60*60*24)/ (60*60*24));
			                        if ($old_months >= 12) {
			                        	$old_years++;
			                        	$old_months = $old_months - 12;
			                        }
			                      ?>
			                      <?php 
			                        $new_date1 = strtotime($new['from_date']);
			                        $new_date2 = strtotime($new['to_date']); 
			                        $new_date = $new_date2 - $new_date1;
			                        $new_years = floor($new_date / (365*60*60*24));
			                        $new_months = floor(($new_date - $new_years * 365*60*60*24) / (30*60*60*24));
			                        $new_days = floor(($new_date - $new_years * 365*60*60*24 - $new_months*30*60*60*24)/ (60*60*24));
			                        if ($new_months >= 12) {
			                        	$new_years++;
			                        	$new_months = $new_months - 12;
			                        }
			                      ?>
			                      <td colspan="1"  style="font-size:20px;"> Contract Duration </td>
			                      <td colspan="2" class="centered" style="width: 350px !important;"> 
			                        <?php 
			                          if ($old_years != 0) {
			                            echo $old_years." Years <br>"; 
			                          }
			                          /*if ($old_months != 0) {
			                            echo $old_months." Monthes <br>";
			                          }
			                          if ($old_days != 0) {
			                            echo $old_days." Days <br>";
			                          }*/
			                        ?>
			                      </td>
			                      <td colspan="2" class="centered" style="width: 350px !important;"> 
			                        <?php 
			                          if ($new_years != 0) {
			                            echo $new_years." Years <br>"; 
			                          }
			                          /*if ($new_months != 0) {
			                            echo $new_months." Monthes <br>";
			                          }
			                          if ($new_days != 0) {
			                            echo $new_days." Days <br>";
			                          }*/
			                        ?>
			                      </td>
			                    </tr>
			                    <tr>
			                      <td colspan="1"  style="font-size:20px;"> Starting From </td>
			                      <td colspan="2" class="centered" style="width: 350px !important;"> <?php echo $new['from_date_old']; ?> </td>
			                      <td colspan="2" class="centered" style="width: 350px !important;"> <?php echo $new['from_date']; ?> </td>
			                    </tr>
			                    <tr>
			                      <td colspan="1"  style="font-size:20px;"> Ends At </td>
			                      <td colspan="2" class="centered" style="width: 350px !important;"> <?php echo $new['to_date_old']; ?> </td>
			                      <td colspan="2" class="centered" style="width: 350px !important;"> <?php echo $new['to_date']; ?> </td>
			                    </tr>
                    			<?php if ($new['hotel_id'] == 44) { ?>
				                    <tr>
				                      <td colspan="1"  style="font-size:20px;"> Monthly Rent for Mamlouk Palace</td>
				                      <td colspan="2" class="centered" style="width: 350px !important;"> <?php echo number_format($new['rent_mp_old'],2,".",","); ?> <?php echo $new['currency_mp_old']; ?> </td>
				                      <td colspan="2" class="centered" style="width: 350px !important;"> <?php echo number_format($new['rent_mp'],2,".",","); ?> <?php echo $new['currency_mp']; ?> </td>
				                    </tr>
				                    <tr>
				                      <td colspan="1"  style="font-size:20px;"> Net Rent for Mamlouk Palace after taxes</td>
				                      <td colspan="2" class="centered" style="width: 350px !important;"> 
				                      	<?php $taxess3 = "1.".$new['taxes_per_old'];?>
	                      				<?php $taxess = ($new['rent_mp_old']/ $taxess3)*($new['taxes_per_old']/100);?>
	                      				<?php $finals = $new['rent_mp_old']-$taxess;?>
										<?php echo number_format($finals,2,".",","); ?> <?php echo $new['currency_mp_old']; ?>
				                      </td>
				                      <td colspan="2" class="centered" style="width: 350px !important;">
				                      	<?php $taxes3 = "1.".$new['taxes_per'];?>
	                      				<?php $taxes = ($new['rent_mp']/ $taxes3)*($new['taxes_per']/100);?>
	                      				<?php $final = $new['rent_mp']-$taxes;?>
										<?php echo number_format($final,2,".",","); ?> <?php echo $new['currency_mp']; ?>
				                      </td>
				                    </tr>
				                    <tr>
				                      <td colspan="1"  style="font-size:20px;"> Monthly Rent for Garden Beach</td>
				                      <td colspan="2" class="centered" style="width: 350px !important;"> <?php echo number_format($new['rent_gb_old'],2,".",","); ?> <?php echo $new['currency_gb_old']; ?> </td>
				                      <td colspan="2" class="centered" style="width: 350px !important;"> <?php echo number_format($new['rent_gb'],2,".",","); ?> <?php echo $new['currency_gb']; ?> </td>
				                    </tr>
				                    <tr>
				                      <td colspan="1"  style="font-size:20px;"> Net Rent for Garden Beach after taxes</td>
				                      <td colspan="2" class="centered" style="width: 350px !important;"> 
				                      	<?php $taxess4 = "1.".$new['taxes_per_old'];?>
	                      				<?php $taxess1 = ($new['rent_gb_old']/$taxess4)*($new['taxes_per_old']/100);?>
	                      				<?php $finals1 = $new['rent_gb_old']-$taxess1;?>
										<?php echo number_format($finals1,2,".",","); ?> <?php echo $new['currency_gb_old']; ?>
				                      </td>
				                      <td colspan="2" class="centered" style="width: 350px !important;">
				                      	<?php $taxes4 = "1.".$new['taxes_per'];?>
	                      				<?php $taxes1 = ($new['rent_gb']/$taxes4)*($new['taxes_per']/100);?>
	                      				<?php $final1 = $new['rent_gb']-$taxes1;?>
										<?php echo number_format($final1,2,".",","); ?> <?php echo $new['currency_gb']; ?>
				                      </td>
				                    </tr>
                    			<?php }else{ ?>
                    				<tr>
				                      <td colspan="1"  style="font-size:20px;"> Monthly Rent </td>
				                      <td colspan="2" class="centered" style="width: 350px !important;"> <?php echo number_format($new['rent_old'],2,".",","); ?> <?php echo $new['currency_old']; ?> </td>
				                      <td colspan="2" class="centered" style="width: 350px !important;"> <?php echo number_format($new['rent'],2,".",","); ?> <?php echo $new['currency']; ?> </td>
				                    </tr>
				                    <tr>
				                      <td colspan="1"  style="font-size:20px;"> Net Rent after taxes</td>
				                      <td colspan="2" class="centered" style="width: 350px !important;"> 
				                      	<?php $taxess5 = "1.".$new['taxes_per_old'];?>
	                      				<?php $taxess2 = ($new['rent_old']/$taxess5)*($new['taxes_per_old']/100);?>
	                      				<?php $finals2 = $new['rent_old']-$taxess2;?>
										<?php echo number_format($finals2,2,".",","); ?> <?php echo $new['currency_old']; ?>
				                      </td>
				                      <td colspan="2" class="centered" style="width: 350px !important;">
				                      	<?php $taxes5 = "1.".$new['taxes_per'];?>
	                      				<?php $taxes2 = ($new['rent']/$taxes5)*($new['taxes_per']/100);?>
	                      				<?php $final2 = $new['rent']-$taxes2;?>
										<?php echo number_format($final2,2,".",","); ?> <?php echo $new['currency']; ?>
				                      </td>
				                    </tr>
                    			<?php } ?>
			                    <tr>
			                      <td colspan="1"  style="font-size:20px;"> Other Conditions </td>
			                      <td colspan="2" class="centered" style="width: 350px !important;"> <?php echo $new['others_old']; ?> </td>
			                      <td colspan="2" class="centered" style="width: 350px !important;"> <?php echo $new['others']; ?> </td>
			                    </tr>
			                    <tr>
			                      <td colspan="1"  style="font-size:20px;"> Advance Rent </td>
			                      <td colspan="2" class="centered" style="width: 350px !important;"> <?php echo $summary['advance_old']; ?> </td>
			                      <td colspan="2" class="centered" style="width: 350px !important;"> <?php echo $summary['advance_new']; ?> </td>
			                    </tr>
                    			<?php if ($new['hotel_id'] == 44) { ?>
				                    <tr>
				                      <td colspan="1"  style="font-size:20px;"> Deposit for Mamlouk Palace</td>
				                      <td colspan="2" class="centered" style="width: 350px !important;"> <?php echo number_format($new['safty_mp_old'],2,".",","); ?> <?php echo $new['currency1_mp_old']; ?> </td>
				                      <td colspan="2" class="centered" style="width: 350px !important;"> <?php echo number_format($new['safty_mp'],2,".",","); ?> <?php echo $new['currency1_mp']; ?> </td>
				                    </tr>
				                    <tr>
				                      <td colspan="1"  style="font-size:20px;"> Deposit for Garden Beach</td>
				                      <td colspan="2" class="centered" style="width: 350px !important;"> <?php echo number_format($new['safty_gb_old'],2,".",","); ?> <?php echo $new['currency1_gb_old']; ?> </td>
				                      <td colspan="2" class="centered" style="width: 350px !important;"> <?php echo number_format($new['safty_gb'],2,".",","); ?> <?php echo $new['currency1_gb']; ?> </td>
				                    </tr>
                    			<?php }else{ ?>
                    				<tr>
				                      <td colspan="1"  style="font-size:20px;"> Deposit </td>
				                      <td colspan="2" class="centered" style="width: 350px !important;"> <?php echo number_format($new['safty_old'],2,".",","); ?> <?php echo $new['currency1_old']; ?> </td>
				                      <td colspan="2" class="centered" style="width: 350px !important;"> <?php echo number_format($new['safty'],2,".",","); ?> <?php echo $new['currency1']; ?> </td>
				                    </tr>
                    			<?php } ?>
			                    <tr>
			                      <td colspan="1"  style="font-size:20px;"> Other Comments </td>
			                      <td colspan="2" class="centered" style="width: 350px !important;"> <?php echo $summary['comment_old']; ?> </td>
			                      <td colspan="2" class="centered" style="width: 350px !important;"> <?php echo $summary['comment_new']; ?> </td>
			                    </tr>
			                 </table>
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher data-indention non-printable">
	                      		<label for="offers" class="col-lg-8 col-md-10 col-sm-8 col-xs-8 control-label" style="font-size: 20px; font-weight: bold;">Report Files</label>
								<div class="form-group col-lg-9 col-md-12 col-sm-7 col-xs-7">
	                       			<?php foreach($uploads as $upload): ?>
	                       				<a href='/assets/uploads/files/<?php echo $upload['name'] ?>'><?php echo $upload['name'] ?></a> Uploaded By <?php echo $upload['user_name'] ?> at <?php echo $upload['timestamp'] ?><br />
	                        		<?php endforeach ?>			
	                      		</div>	
                      		</div>	
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher centered">
			                	<?php $queue_first = TRUE; ?>
			                	<?php foreach ($signers as $signe_id => $signer): ?>
			                	<?php if ($signer['role_id'] != 59 && $signer['role_id'] !=57) {?>
			                	<div class="signature-wrapper">
			                  		<div class="data-head relative"><?php echo (strlen($signer['role']) == 0)? "Contract Owner" : $signer['role'] ?>
			                    		<span class="expander-container"><i class='glyphicon glyphicon-envelope'></i></span>
			                    		<div class="expander-wrapper">
			                      			<span class="expander-remover"><i class='glyphicon glyphicon-remove'></i></span>
			                      			<div class="expander">
			                        			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-holder">
			                          				<div class="row">
			                            				<form action="/contract/sum_mail/<?php echo $summary['id']; ?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
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
			                    		<a href="/contract/unsign_sum/<?php echo $signe_id; ?>" class="non-printable btn btn-primary unsign">Cancel</a>
			                    		<?php endif ?>
			                  		</div>
			                  		<div class="data-content">
			                  			<span class="name-data-content"><?php echo $signer['sign']['name']; ?></span>
			                  			<br />
			                  			<span class="timestamp-data-content"><?php echo $signer['sign']['timestamp']; ?></span>
			                  		</div>
			                  		<?php elseif (array_key_exists($user_id, $signer['queue']) && $queue_first): ?>
			                  		<?php $queue_first = FALSE; ?>
			                  		<div class="data-content non-printable"><span class="data-label sign-data-content"></span><a href="/contract/sign_sum/<?php echo $signe_id; ?>/reject" class="non-printable btn btn-danger">Reject</a><a href="/contract/sign_sum/<?php echo $signe_id; ?>" class="non-printable btn btn-success">sign</a></div>
			                  		<?php else: ?>
			                  		<?php $queue_first = FALSE; ?>
			                  		<?php endif ?>
			                	</div>
			                    <?php if (isset($signer['sign']['reject'])){break;}?>
			                    <?}?>
			                	<?php endforeach ?>
			                	<?php foreach ($signers_sum as $signe_id => $signer): ?>
			                	<div class="signature-wrapper">
			                  		<div class="data-head relative"><?php echo (strlen($signer['role']) == 0)? "Contract Owner" : $signer['role'] ?>
			                    		<span class="expander-container"><i class='glyphicon glyphicon-envelope'></i></span>
			                    		<div class="expander-wrapper">
			                      			<span class="expander-remover"><i class='glyphicon glyphicon-remove'></i></span>
			                      			<div class="expander">
			                        			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-holder">
			                          				<div class="row">
			                            				<form action="/contract/sum_mail/<?php echo $summary['id']; ?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
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
			                    		<a href="/contract/unsign_sum/<?php echo $signe_id; ?>" class="non-printable btn btn-primary unsign">Cancel</a>
			                    		<?php endif ?>
			                  		</div>
			                  		<div class="data-content">
			                  			<span class="name-data-content"><?php echo $signer['sign']['name']; ?></span>
			                  			<br />
			                  			<span class="timestamp-data-content"><?php echo $signer['sign']['timestamp']; ?></span>
			                  		</div>
			                  		<?php elseif (array_key_exists($user_id, $signer['queue']) && $queue_first): ?>
			                  		<?php $queue_first = FALSE; ?>
			                  		<div class="data-content non-printable"><span class="data-label sign-data-content"></span><a href="/contract/sign_sum/<?php echo $signe_id; ?>/reject" class="non-printable btn btn-danger">Reject</a><a href="/contract/sign_sum/<?php echo $signe_id; ?>" class="non-printable btn btn-success">sign</a></div>
			                  		<?php else: ?>
			                  		<?php $queue_first = FALSE; ?>
			                  		<?php endif ?>
			                	</div>
			                    <?php if (isset($signer['sign']['reject'])){break;}?>
			                	<?php endforeach ?>

			              	</div>
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher non-printable" >
                				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  					<form action="/contract/comment_sum/<?php echo $summary['id']?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
                    					<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                     						<textarea class="form-control" name="comment" id="comment"></textarea>
                    					</div>
                    					<input name="sum_id" value="<?php echo $summary['id']?>" type="hidden" />
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
                      						<span class="timestamp-data-content"><?php echo $comment['created'];?></span>
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