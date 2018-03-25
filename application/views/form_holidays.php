<!DOCTYPE html>
<html lang="en">
	<head>
		<?php $this->load->view('header'); ?>
	</head>
	<body>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-container">
			<div class="data-head centered"></div>
			<div class="row">			
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 stamper">
					<div class="data-head">Company Financial Controller</div>
					<div class="data-content"><span class="name-data-content"><?php echo $form['sayed_fullname']; ?></span></div>
					<?php if ($form['sayed_id']): ?>
						<div class="data-content"><img src="<?php echo $signature_path.$form['sayed_signature']; ?>" alt="<?php echo $form['sayed_fullname']; ?>" class="img-rounded sign-image"></div>
					<?php elseif(isset($user_signs['sayed'])): ?>
						<div class="data-content"><a href="/forms/sign_owning_holidays/<?php echo $form['id']; ?>/sayed" class="btn btn-success">Sign here</a></div>
					<?php else: ?>
						<div class="data-content"></div>
					<?php endif; ?>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 stamper">
					<div class="data-head">Commercial Relation Manager</div>
					<div class="data-content"><span class="name-data-content"><?php echo $form['atef_fullname']; ?></span></div>
					<?php if ($form['atef_id']): ?>
						<div class="data-content"><img src="<?php echo $signature_path.$form['atef_signature']; ?>" alt="<?php echo $form['atef_fullname']; ?>" class="img-rounded sign-image"></div>
					<?php elseif(isset($user_signs['atef'])): ?>
						<div class="data-content"><a href="/forms/sign_owning_holidays/<?php echo $form['id']; ?>/atef" class="btn btn-success">Sign here</a></div>
					<?php else: ?>
						<div class="data-content"></div>
					<?php endif; ?>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 stamper">
					<div class="data-head">Mr.Hesham/Eng Nadine</div>
					<div class="data-content"><span class="name-data-content"><?php echo $form['hesham_fullname']; ?></span></div>
					<?php if ($form['hesham_id']): ?>
						<div class="data-content"><img src="<?php echo $signature_path.$form['hesham_signature']; ?>" alt="<?php echo $form['hesham_fullname']; ?>" class="img-rounded sign-image"></div>
					<?php elseif(isset($user_signs['hesham'])): ?>
						<div class="data-content"><a href="/forms/sign_owning_holidays/<?php echo $form['id']; ?>/hesham" class="btn btn-success">Sign here</a></div>
					<?php else: ?>
						<div class="data-content"></div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</body>
</html>