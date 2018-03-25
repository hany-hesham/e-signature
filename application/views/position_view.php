<!DOCTYPE html>
<html lang="en">
	<head>
		<?php $this->load->view('header'); ?>
	</head>
	<body>
		<div style="position: relative; float: right; width: 30%; margin-right:20px; margin-top:50px;" class="non-printable">
	     	 <p style="text-align: right; font-family: Calibri;">
		        السادة الزملاء /
		 
		        من واقع إيمانا العميق بضرورة التطوير و التعليم و بث روح الفريق و إبراز أهمية دور التدريب و ضرورة المعايشة من أجل بناء طاهي عصري ليكون لديه المعرفة الأساسية لأهمية  دورقسم الإسيتوارد من حيث دوره الهام في الحفاظ علي مباديء الصحة العامة و كذلك سلامة و صحة الغذاء و لذلك نري طبقا لما تم شرحه من قبل في برنامج التدرج المهني الوظيفي الفندقي لصن رايز.
		                 
		        أنه في حالة الإحتياج لتعيين وظيفة طاهي ثالث يتم النظر أولا إلي القسم الإستيوارد  داخل الفندق  أولا أو في فنادق الشركة  عن طريق التشييك مع مديري موارد البشرية في الفنادق عن طريق عمل برنامج تدريبي لمن أمضي ستة أشهر لحد أدني في قسم الإستيوارد و يكون البرنامج التدريبي الخاص به لمدة ستة أشهر يتم متابعته و تقييمه عن طريق الشيف العمومي شخصيا بمعرفة مدير التعليم و التطوير و مدير الموارد البشرية
		                 
		        و في حالة تعيينه من خارج الشركة, بعد التأكد بعدم وجود  موظف مؤهل للعمل في الوظيفة في فنادق الشركة  يكون سبق له العمل في نفس الوظيفة قبل تعيينه بستة أشهر علي الأقل خبرة في المطبخ و يكون من خريجي المدارس و المعاهد الفندقية قسم مطبخ.
		    </p>
		    <p style="text-align: left; font-family: Calibri;">
		        It is with our deepest belief of the necessity for promoting Learning and Development concept, and fostering to build a team spirit, highlighting the importance of the training’s role and the utmost importance to promote a modernized chef who possesses the most knowledgeable skills for the important role of the stewarding department, with respect to maintaining the basic principles of health & food safety procedures. Therefore, we have reviewed the above mentioned enlightenment in accordance to the “SUNRISE Career Path Program” awareness.
		                 
		        Should there be a necessity to hire a third Commis chef, then to refer back to the stewarding department first within the hotel or through sister hotels  by undertaking check references by Human Resources Manager of the hotels undertaking cross trainings for employees who have served minimum six months in the stewarding position, the cross training is to be based on six months, scrutinized and evaluated by the Executive Chef, Learning & Development Manager and the Human Resources Manager.
		                 
		        In case of hiring from outsourced employees, this is to be implemented after having checked carefully that there is no available qualified employees to practice the position throughout the sister hotels. Possessing qualified experience in the same position is very much essential as to be  six months at least prior hiring into the kitchen department and have been graduated from hospitality & tourism schools or institutions, kitchen department.
	      	</p>
	    </div>
	    <div id="wrapper" style="position: relative; float: left; width: 60% !important;">
			<?php $this->load->view('menu') ?>
			<div id="page-wrapper">
				<div class="a4wrapper">
					<div class="a4page">
						<div class="page-header">
       						<button onclick="window.print()" class="non-printable form-actions btn btn-success" href="" >Print</button>
							<?php if ($is_editor): ?>
								<a class="form-actions btn btn-info non-printable" href="/position/edit/<?php echo $position['id'] ?>" style="float:right;" > Edit </a>
							<?php endif ?>
							<div class="header-logo"><img src="/assets/uploads/logos/<?php echo $position['logo']; ?>"/></div>
	                  		<h1 class="centered"><?php echo $position['hotel_name']; ?></h1>
		        			<h3 class="centered">
		        				Hiring Position Request No. #<?php echo $position['id']; ?>
		        			</h3>
							<?php if ($position['state_id'] == 2): ?>
								<a class="form-actions btn btn-warning non-printable" href="/position/replay/<?php echo $position['id'] ?>" style="float:right;" > Replay </a>
							<?php endif ?>
	    				</div>
                  		<div class="form-group col-lg-12 col-md-10 col-sm-12 col-xs-12">
                  			<span style="font-weight: bolder;">Date: </span> <?php echo $position['date'] ?>
                  		</div>
                  		<div class="form-group col-lg-12 col-md-10 col-sm-12 col-xs-12">
							<table class="table table-striped table-bordered table-condensed" style="width: 750px;">
								<thead>
			                        <tr>
			                          	<th rowspan="2" colspan="1" style=" text-align: center;">No.</th>
			                          	<th rowspan="2" colspan="1" style=" text-align: center;">Requested Positions</th>
			                          	<th rowspan="1" colspan="3" style=" text-align: center;">Salary Scale</th>
			                          	<th rowspan="2" colspan="1" style=" text-align: center;">Level</th>
			                        </tr>
			                        <tr>
			                          	<th rowspan="1" colspan="1" style=" text-align: center;">Min</th>
			                          	<th rowspan="1" colspan="1" style=" text-align: center;">Avarge</th>
			                          	<th rowspan="1" colspan="1" style=" text-align: center;">Max</th>
			                        </tr>
			                    </thead>
								<?php $count = 1; ?>
								<?php foreach ($requests as $request): ?>
									<tr class="item-row" style="font-size: 12px; font-weight: bold;">
										<td class="centered"><?php echo $count; ?></td>
										<td class="centered"><?php echo $request['position']; ?></td>
										<td class="centered"><?php echo $request['froms']; ?></td>
										<td class="centered"><?php echo $request['avrg']; ?></td>
										<td class="centered"><?php echo $request['tos']; ?></td>
										<td class="centered"><?php echo $request['level']; ?></td>
									</tr>
									<?php $count++; ?>
								<?php endforeach ?>
							</table>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher centered">
			                <?php $queue_first = TRUE; ?>
			                <?php foreach ($signers as $signe_id => $signer): ?>
			                	<div class="signature-wrapper">
			                  		<div class="data-head relative"><?php echo (strlen($signer['role']) == 0)? "Request Owner" : $signer['department']?>
			                    		<span class="expander-container"><i class='glyphicon glyphicon-envelope'></i></span>
			                    		<div class="expander-wrapper non-printable">
			                      			<span class="expander-remover non-printable"><i class='glyphicon glyphicon-remove'></i></span>
			                      			<div class="expander non-printable">
			                        			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-holder non-printable">
			                          				<div class="row non-printable">
			                            				<form action="/position/mail_to/<?php echo $position['id']; ?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
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
			                  			<div class="data-content"><img src="<?php echo isset($signer['sign']['reject'])? $signature_path.'rejected.png' : $signature_path.'approved.png'; ?>" alt="<?php echo $signer['sign']['name']; ?>" class="img-rounded sign-image">
			                    			<?php if (($signer['sign']['id'] == $user_id && $unsign_enable) || $is_admin): ?>
			                    				<a href="/position/unsign/<?php echo $signe_id; ?>" class="non-printable btn btn-primary unsign">Cancel</a>
			                    			<?php endif ?>
			                  			</div>
			                  			<div class="data-content">
			                  				<span class="name-data-content"><?php echo $signer['sign']['name']; ?></span>
			                  				<br />
			                  				<span class="timestamp-data-content"><?php echo $signer['sign']['timestamp']; ?></span>
			                  			</div>
			                  		<?php elseif (array_key_exists($user_id, $signer['queue']) && $queue_first): ?>
			                  			<?php $queue_first = FALSE; ?>
			                  			<div class="data-content non-printable"><span class="data-label sign-data-content"></span><a href="/position/sign/<?php echo $signe_id; ?>/reject" class="non-printable btn btn-danger">Reject</a><a href="/position/sign/<?php echo $signe_id; ?>" class="non-printable btn btn-success">sign</a></div>
			                  		<?php else: ?>
			                  			<?php $queue_first = FALSE; ?>
			                  		<?php endif ?>
			                	</div>
			                    <?php if (isset($signer['sign']['reject'])){break;}?>
			                <?php endforeach ?>
			            </div>
			            <?php if ($replaies) { ?>
							<?php foreach ($replaies as $replay): ?>
					            <?php if ($replay['requires']) { ?>
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher">
										<h3 class="centered"><?php echo $replay['hotel_name'] ?></h3>
										<table class="table table-striped table-bordered table-condensed" style="width: 750px;">
											<thead>
						                        <tr>
						                          <th colspan="1" style=" text-align: center;">No.</th>
						                          <th colspan="1" style=" text-align: center;">Employee Name</th>
						                          <th colspan="1" style=" text-align: center;">Employee Position</th>
						                          <th colspan="1" style=" text-align: center;">Hotel Name</th>
						                        </tr>
						                    </thead>
											<?php $count1 = 1; ?>
											<?php foreach ($replay['requires'] as $require): ?>
						                    	<?php if ($require['name'] != null) { ?>
													<tr class="item-row" style="font-size: 12px; font-weight: bold;">
														<td class="centered"><?php echo $count1; ?></td>
														<td class="centered"><?php echo $require['name']; ?></td>
														<td class="centered"><?php echo $require['position']; ?></td>
														<td class="centered"><?php echo $require['hotel_name']; ?></td>
													</tr>
												<?php } ?>
												<?php $count1++; ?>
											<?php endforeach ?>
										</table>
										<br>
										<br>
										<p class="centered" style="margin: 5px;">The employee/s will spend 3 months at our hotel as task force afterwards he will be appraised by the Department Head and the HR Manager for final transfer.</p>
									</div>
									<?php foreach ($replay['requires'] as $require): ?>
					                   <?php if ($require['name'] != null) { ?>
											<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher centered">
												<h3 class="centered"><?php echo $require['name'] ?></h3>
								                <?php $queue_first = TRUE; ?>
								                <?php foreach ($replay['replay_signers'] as $signe_id => $signer): ?>
								                	<div class="signature-wrapper">
								                  		<div class="data-head relative"><?php echo (strlen($signer['role']) == 0)? "Request Owner" : ($signer['department_id'] == 0)? $signer['role'] : $signer['department']; ?>
								                    		<span class="expander-container"><i class='glyphicon glyphicon-envelope'></i></span>
								                    		<div class="expander-wrapper non-printable">
								                      			<span class="expander-remover non-printable"><i class='glyphicon glyphicon-remove'></i></span>
								                      			<div class="expander non-printable">
								                        			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-holder non-printable">
								                          				<div class="row non-printable">
								                            				<form action="/position/mail_to_replay/<?php echo $position['id']; ?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
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
								                  			<div class="data-content"><img src="<?php echo isset($signer['sign']['reject'])? $signature_path.'rejected.png' : $signature_path.'approved.png'; ?>" alt="<?php echo $signer['sign']['name']; ?>" class="img-rounded sign-image">
								                    			<?php if (($signer['sign']['id'] == $user_id && $unsign_enable) || $is_admin): ?>
								                    				<a href="/position/replay_unsign/<?php echo $signe_id; ?>" class="non-printable btn btn-primary unsign">Cancel</a>
								                    			<?php endif ?>
								                  			</div>
								                  			<div class="data-content">
								                  				<span class="name-data-content"><?php echo $signer['sign']['name']; ?></span>
								                  				<br />
								                  				<span class="timestamp-data-content"><?php echo $signer['sign']['timestamp']; ?></span>
								                  			</div>
								                  		<?php elseif (array_key_exists($user_id, $signer['queue']) && $queue_first): ?>
								                  			<?php $queue_first = FALSE; ?>
								                  			<div class="data-content non-printable"><span class="data-label sign-data-content"></span><a href="/position/replay_sign/<?php echo $signe_id; ?>/reject" class="non-printable btn btn-danger">Reject</a><a href="/position/replay_sign/<?php echo $signe_id; ?>" class="non-printable btn btn-success">sign</a></div>
								                  		<?php else: ?>
								                  			<?php $queue_first = FALSE; ?>
								                  		<?php endif ?>
								                	</div>
								                    <?php if (isset($signer['sign']['reject'])){break;}?>
								                <?php endforeach ?>
								            </div>
								        <?php } ?>
									<?php endforeach ?>
								<?php } ?>
							<?php endforeach ?>
						<?php } ?>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher non-printable">
                			<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  				<form action="/position/comment/<?php echo $position['id']?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
                    				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                     					<textarea class="form-control" name="comment" id="comment"></textarea>
                    				</div>
                    				<input name="pos_id" value="<?php echo $position['id']?>" type="hidden" />
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
					</div>
					<div class="data-content">
    					<p class="centered">The Vacant Position Request has been created by <?php echo $position['name'];?> at <?php echo $position['timestamp'];?></p>
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
	</body>
</html>