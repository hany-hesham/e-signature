<?php 
function array_assoc_value_exists($arr, $index, $search) {
	foreach ($arr as $key => $value) {
		if ($value[$index] == $search) {
			return TRUE;
		}
	}
	return FALSE;
}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php $this->load->view('header'); ?>
</head>
<body>
<div id="wrapper">
	<?php $this->load->view('menu') ?>
		<?php $this->load->view('madar_subnav'); ?>

	<div id="page-wrapper">
	<div class="container">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 rtl">
			<fieldset>
				<legend></legend>

			<form action="" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">

				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 rtl">
					<label for="time" class="col-lg-3 col-md-4 col-sm-5 col-xs-5 control-label rtl">التاريخ</label>
					<div class="col-lg-6 col-md-8 col-sm-8 col-xs-8 rtl">
						<input type="text" class="form-control" name="time" id="time" readonly="readonly" value="<?php echo $project['time']; ?>"  />
					</div>

				</div>

				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 rtl">
					<label for="hotel" class="col-lg-3 col-md-4 col-sm-5 col-xs-5 control-label rtl">اسم الفندق</label>
					<div class="col-lg-6 col-md-8 col-sm-8 col-xs-8 rtl">
						<input type="text" class="form-control" name="hotel" id="hotel" readonly="readonly" value="<?php echo $project['hotel_name']; ?>"  />
					</div>

				</div>

				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 rtl">
					<label for="project" class="col-lg-3 col-md-4 col-sm-5 col-xs-5 control-label rtl">المشروع</label>
					<div class="col-lg-6 col-md-8 col-sm-8 col-xs-8 rtl">
						<input type="text" class="form-control" name="project" id="project" readonly="readonly" value="<?php echo $project['project_name']; ?>"  />
					</div>

				</div>

				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 rtl">
					<label for="place" class="col-lg-3 col-md-4 col-sm-5 col-xs-5 control-label rtl">الموقع</label>
					<div class="col-lg-6 col-md-8 col-sm-8 col-xs-8 rtl">
						<input type="text" class="form-control" name="place" id="place" value="<?php echo $project['place']; ?>"  />
					</div>

				</div>

				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 rtl">
					<label for="num_of_offers" class="col-lg-3 col-md-4 col-sm-5 col-xs-5 control-label rtl">عدد عروض الأسعار</label>
					<div class="col-lg-6 col-md-8 col-sm-8 col-xs-8 rtl">
						<input type="text" class="form-control" name="num_of_offers" id="num_of_offers" value="<?php echo $project['num_of_offers']; ?>"  />
					</div>

				</div>

				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 rtl">
					<label for="total_cost" class="col-lg-3 col-md-4 col-sm-5 col-xs-5 control-label rtl">إجمالي التكلفه</label>
					<div class="col-lg-6 col-md-8 col-sm-8 col-xs-8 rtl">
						<input type="text" class="form-control" name="total_cost" id="total_cost" value="<?php echo $project['total_cost']; ?>"  />
					</div>

				</div>

				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 rtl">
					<label for="sup" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 control-label rtl align-right">ضمن قائمه المقولين و الموردين المعتمده</label>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 rtl">
						<input type="text" class="form-control" name="sup_1" id="sup_1" value="<?php echo $project['sup_1']; ?>"  />
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 rtl">
						<input type="text" class="form-control" name="sup_2" id="sup_2" value="<?php echo $project['sup_2']; ?>"  />
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 rtl">
						<input type="text" class="form-control" name="sup_3" id="sup_3" value="<?php echo $project['sup_3']; ?>"  />
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 rtl">
						<input type="text" class="form-control" name="sup_4" id="sup_4" value="<?php echo $project['sup_4']; ?>"  />
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 rtl">
						<input type="text" class="form-control" name="sup_5" id="sup_5" value="<?php echo $project['sup_5']; ?>"  />
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 rtl">
						<input type="text" class="form-control" name="sup_6" id="sup_6" value="<?php echo $project['sup_6']; ?>"  />
					</div>

				</div>

				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 rtl">
					<label for="consultant" class="col-lg-3 col-md-4 col-sm-5 col-xs-5 control-label rtl">إعتماد الإستشاري</label>
					<div class="col-lg-6 col-md-8 col-sm-8 col-xs-8 rtl">
						<input type="text" class="form-control" name="consultant" id="consultant" value="<?php echo $project['consultant']; ?>"  />
					</div>

				</div>

				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 rtl">
					<label for="recommendation" class="col-lg-3 col-md-4 col-sm-5 col-xs-5 control-label rtl">التوصيه</label>
					<div class="col-lg-6 col-md-8 col-sm-8 col-xs-8 rtl">
						<input type="text" class="form-control" name="recommendation" id="recommendation" value="<?php echo $project['recommendation']; ?>"  />
					</div>

				</div>

				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 rtl">
					<label for="balance" class="col-lg-3 col-md-4 col-sm-5 col-xs-5 control-label rtl">ضمن الموازنه المعتمده</label>
					<div class="col-lg-6 col-md-8 col-sm-8 col-xs-8 rtl">
						<input type="text" class="form-control" name="balance" id="balance" value="<?php echo $project['balance']; ?>"  />
					</div>

				</div>

				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 rtl">
					<label for="purchasing_notes" class="col-lg-3 col-md-4 col-sm-5 col-xs-5 control-label rtl">ملاحظات المشتريات</label>
					<div class="col-lg-6 col-md-8 col-sm-8 col-xs-8 rtl">
						<input type="text" class="form-control" name="purchasing_notes" id="purchasing_notes" value="<?php echo $project['purchasing_notes']; ?>"  />
					</div>

				</div>

				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 rtl">
					<label for="financial_notes" class="col-lg-3 col-md-4 col-sm-5 col-xs-5 control-label rtl">ملاحظات الإداره المالية</label>
					<div class="col-lg-6 col-md-8 col-sm-8 col-xs-8 rtl">
						<input type="text" class="form-control" name="financial_notes" id="financial_notes" value="<?php echo $project['financial_notes']; ?>"  />
					</div>

				</div>

				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
				    <div class="col-lg-offset-3 col-lg-10 col-md-10 col-md-offset-3">
				    	<input name="submit" value="Update" type="submit" class="btn btn-success submitter" />
				    	<a href="/madar_owning" class="btn btn-warning">Go Back</a>
				    </div>
				</div>

				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher">
				<?php foreach ($signers as $signe_id => $signer): ?>
					<div class="signature-wrapper">
						<div class="data-head relative"><?php echo (strlen($signer['role']) == 0)? "Project Owner" : $signer['role'] ?>
							<span class="expander-container"><i class='glyphicon glyphicon-envelope'></i></span>
							<div class="expander-wrapper">
							<span class="expander-remover"><i class='glyphicon glyphicon-remove'></i></span>
								<div class="expander">
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-holder">
										<div class="row">
											<form action="/madar_owning/mailto/<?php echo $project['id']; ?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
												<?php if (isset($signer['sign'])): ?>
													<?php $i=1; ?>
													<input checked="checked" type="radio" name="mail" value="<?php echo $signer['sign']['mail'] ?>" /><label>To: <?php echo $signer['sign']['name'] ?></label>
												<?php else: ?>
													<?php $i=0; foreach ($signer['queue'] as $id => $approve): ?>
														<input <?php echo (++$i == 1)? 'checked="checked"' : '' ?> type="radio" name="mail" value="<?php echo $approve['mail'] ?>" id="u<?php echo $id ?>" /><label for="u<?php echo $id ?>">To: <?php echo $approve['name'] ?></label><br />
													<?php endforeach ?>
												<?php endif; ?>
												<?php if (isset($i) && $i == 0): ?>
													<span>No users availaable</span>
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
							<?php if ($signer['sign']['id'] == $user_id): ?>
								<a href="/madar_owning/unsign/<?php echo $signe_id; ?>" class="btn btn-primary unsign">Cancel</a>
							<?php endif ?>
							</div>
							<div class="data-content"><span class="name-data-content"><?php echo $signer['sign']['name']; ?></span>
							<br /><span class="timestamp-data-content"><?php echo $signer['sign']['timestamp']; ?></span></div>
						<?php elseif (array_key_exists($user_id, $signer['queue'])): ?>
							<div class="data-content non-printable"><span class="data-label sign-data-content"></span><a href="/madar_owning/reject/<?php echo $signe_id; ?>" class="btn btn-danger">Reject</a><a href="/madar_owning/sign/<?php echo $signe_id; ?>" class="btn btn-success">sign</a></div>
						<?php endif ?>
					</div>
				
				<?php endforeach ?>
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

			</form>
			</fieldset>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher non-printable">
				<div class="row">
					<form action="/project_owning/comment/<?php echo $project_id; ?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
					<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
						<textarea class="form-control" name="comment" id="comment"></textarea>
					</div>
					<input name="submit" value="Comment" type="submit" class="inverse-offset btn btn-success" />
					</form>
				</div>
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-holder">
				<div class="row">
					<div class="data-head centered">Comments </div>
					<div class="data-holder">
						<?php foreach ($comments as $comment): ?>
							<div><span class="data-head"><?php echo $comment['fullname']; ?> :- </span><?php echo $comment['comment']; ?></div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>

		</div>
	</div>
	<div class="holder">Please Wait...</div>
</div>
</body>
</html>
