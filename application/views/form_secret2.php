<!DOCTYPE html>
<html lang="en">
	<head>
		<?php $this->load->view('header'); ?>
	</head>
	<body>
		<table class="rtl table table-bordered table-striped">
		 	<thead>
	        	<tr>
	          		<th class="align-right">البضاعة المطلوبة </th>
	          		<th class="align-right">العدد</th>
	          		<th class="align-right">كود</th>
	          	</tr>
			</thead>
			<tbody>
				<?php if(isset($items)): ?>
					<?php foreach ($items as $item): ?>
						<tr>
							<td><?php echo $item['name']; ?></td>
							<td><?php echo $item['quantity']; ?></td>
							<?php if($item['code'] == NULL){ ?>
								<form action="/forms/coder/<?php echo $item['id']; ?>" method="POST" id="form-submit" enctype="multipart/form-data" class="form-div span12" accept-charset="utf-8">
									<td class="centered" style="display: none">
		                              <input class="form-control" name="items[<?php echo $item['id']?>][id]" value="<?php echo $item['id']?>">
		                            </td>
		                            <td class="centered" style="display: none">
		                              <input class="form-control" name="items[<?php echo $item['id']?>][form_id]" value="<?php echo $item['form_id']?>">
		                            </td>
									<td>
										<input ttype="text" class="form-control" name="items[<?php echo $item['id']?>][code]"> 
                    					<input name="submit" value="Submit" type="submit" class="btn btn-success" />
									</td>
								</form>
								<script type="text/javascript">
							      document.items = <?php echo json_encode($this->input->post('items')); ?>;
							    </script>
							<?php }else{?>
								<td><?php echo $item['code']; ?></td>
							<?php }?>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-container">
			<div class="data-head centered"></div>
			<div class="row rtl">
				<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 stamper">
					<div class="data-head">مدير حسابات الشركة المالكة </div>
					<div class="data-content"><span class="name-data-content"><?php echo $form['hany_fullname']; ?></span></div>
					<?php if ($form['hany_id']): ?>
						<div class="data-content"><img src="<?php echo $signature_path.$form['hany_signature']; ?>" alt="<?php echo $form['hany_fullname']; ?>" class="img-rounded sign-image"></div>
					<?php elseif(isset($user_signs['hany']) && ($xd == 0)): ?>
						<div class="data-content"><a href="/forms/sign_financi/<?php echo $form['id']; ?>/hany" class="btn btn-success">Sign here</a></div>
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