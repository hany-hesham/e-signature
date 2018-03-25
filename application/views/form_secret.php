<!DOCTYPE html>
<html lang="en">
	<head>
		<?php $this->load->view('header'); ?>
	</head>
	<body>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-container">
			<div class="data-head centered"></div>
			<div class="row rtl">
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 stamper">
					<div class="data-head">مدير ادارة الاستثمار </div>
					<div class="data-content"><span class="name-data-content"><?php echo $form['inv_dpt_mgr_fullname']; ?></span></div>
					<?php if ($form['inv_dpt_mgr_id']): ?>
						<div class="data-content"><img src="<?php echo $signature_path.$form['inv_dpt_mgr_signature']; ?>" alt="<?php echo $form['inv_dpt_mgr_fullname']; ?>" class="img-rounded sign-image"></div>
					<?php elseif(isset($user_signs['inv_dpt_mgr'])): ?>
						<div class="data-content"><a href="/forms/sign_owning/<?php echo $form['id']; ?>/inv_dpt_mgr/1" class="btn btn-success">Sign here</a></div>
					<?php else: ?>
						<div class="data-content"></div>
					<?php endif; ?>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 stamper">
					<div class="data-head">مدير حسابات </div>
					<div class="data-content"><span class="name-data-content"><?php echo $form['acc_mgr_fullname']; ?></span></div>
					<?php if ($form['acc_mgr_id']): ?>
						<div class="data-content"><img src="<?php echo $signature_path.$form['acc_mgr_signature']; ?>" alt="<?php echo $form['acc_mgr_fullname']; ?>" class="img-rounded sign-image"></div>
					<?php elseif(isset($user_signs['acc_mgr'])): ?>
						<div class="data-content"><a href="/forms/sign_owning/<?php echo $form['id']; ?>/acc_mgr" class="btn btn-success">Sign here</a></div>
					<?php else: ?>
						<div class="data-content"></div>
					<?php endif; ?>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 stamper">
					<div class="data-head">مدير ادارة المشتريات </div>
					<div class="data-content"><span class="name-data-content"><?php echo $form['pur_dpt_mgr_fullname']; ?></span></div>
					<?php if ($form['pur_dpt_mgr_id']): ?>
						<div class="data-content"><img src="<?php echo $signature_path.$form['pur_dpt_mgr_signature']; ?>" alt="<?php echo $form['pur_dpt_mgr_fullname']; ?>" class="img-rounded sign-image"></div>
					<?php elseif(isset($user_signs['pur_dpt_mgr'])): ?>
						<div class="data-content"><a href="/forms/sign_owning/<?php echo $form['id']; ?>/pur_dpt_mgr" class="btn btn-success">Sign here</a></div>
					<?php else: ?>
						<div class="data-content"></div>
					<?php endif; ?>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 stamper">
					<div class="data-head">رئيس قسم المشتريات </div>
					<div class="data-content"><span class="name-data-content"><?php echo $form['pur_sec_mgr_fullname']; ?></span></div>
					<?php if ($form['pur_sec_mgr_id']): ?>
						<div class="data-content"><img src="<?php echo $signature_path.$form['pur_sec_mgr_signature']; ?>" alt="<?php echo $form['pur_sec_mgr_fullname']; ?>" class="img-rounded sign-image"></div>
					<?php elseif(isset($user_signs['pur_sec_mgr'])): ?>
						<div class="data-content"><a href="/forms/sign_owning/<?php echo $form['id']; ?>/pur_sec_mgr" class="btn btn-success">Sign here</a></div>
					<?php else: ?>
						<div class="data-content"></div>
					<?php endif; ?>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 stamper">
					<div class="data-head">مدير المالي للقطاع</div>
					<div class="data-content"><span class="name-data-content"><?php echo $form['con_acc_mgr_fullname']; ?></span></div>
					<?php if ($form['con_acc_mgr_id']): ?>
						<div class="data-content"><img src="<?php echo $signature_path.$form['con_acc_mgr_signature']; ?>" alt="<?php echo $form['con_acc_mgr_fullname']; ?>" class="img-rounded sign-image"></div>
					<?php elseif(isset($user_signs['con_acc_mgr'])): ?>
						<div class="data-content"><a href="/forms/sign_owning/<?php echo $form['id']; ?>/con_acc_mgr" class="btn btn-success">Sign here</a></div>
					<?php else: ?>
						<div class="data-content"></div>
					<?php endif; ?>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 stamper">
					<div class="data-head">العضو المنتدب </div>
					<div class="data-content"><span class="name-data-content"><?php echo $form['cpo_fullname']; ?></span></div>
					<?php if ($form['cpo_id']): ?>
						<div class="data-content"><img src="<?php echo $signature_path.$form['cpo_signature']; ?>" alt="<?php echo $form['cpo_fullname']; ?>" class="img-rounded sign-image"></div>
					<?php elseif(isset($user_signs['cpo'])): ?>
						<div class="data-content"><a href="/forms/sign_owning/<?php echo $form['id']; ?>/cpo" class="btn btn-success">Sign here</a></div>
					<?php else: ?>
						<div class="data-content"></div>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-container">
			<div class="row">
				<div class="data-head centered">تعليقات </div>
				<div class="data-container">
					<?php foreach ($comments as $comment): ?>
						<div><span class="data-head"><?php echo $comment['fullname']; ?> :- </span><?php echo $comment['comment']; ?></div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</body>
</html>