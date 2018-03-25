<!DOCTYPE html>

<html lang="en">

<head>

<?php $this->load->view('header'); ?>

</head>

<body>

<div id="wrapper">

	<?php $this->load->view('menu') ?>

	<div id="page-wrapper">

	<div class="a4wrapper">



	<div class="a4page">

		<div class="page-header">

	        <h1 class="centered">Movement/Disposal of Assets #<?php echo $form_id; ?></h1>

	    </div>

	    <?php if(false): //(isset($message)): ?>

	    	<div class="alert alert-<?php echo $message['type']; ?>">

	        	<strong><?php echo $message['head']; ?></strong>

	        	<p><?php echo (isset($message['body'])) ? $message['body'] : ''; ?></p>

	    	</div>

	    <?php endif ?>

		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">

				<div><span class="data-head">From: Hotel Name:</span><?php echo $form['from_hotel']; ?></div>
                  <?php if($form['from_hotel_id'] ==50){?>
                        <div><span class="data-head">Owning Co:</span><?php echo $from_owning['from_hotel_owning_name']; ?></div>
                  <?php }else{?>
                    	<div><span class="data-head">Owning Co:</span><?php echo $form['from_company']; ?></div>
                  <?php }?>
				<div><span class="data-head">Issue Date:</span><?php echo $form['issue_date']; ?></div>

			</div>

			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">

				<div><span class="data-head">To: Hotel Name:</span><?php echo $form['to_hotel']; ?></div>
				<?php if($form['to_hotel_id'] ==50){?>
                     <div><span class="data-head">Owning Co:</span><?php echo $to_owning['to_hotel_owning_name']; ?></div>
                <?php }else{?>
			    	<div><span class="data-head">Owning Co:</span><?php echo $form['to_company']; ?></div>
                <?php }?>
				<div><span class="data-head">Delivered Date:</span><?php echo $form['delivery_date']; ?></div>

			</div>

		</div>



		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-container">

			<div style="margin-left:15px;"><span class="data-head">Dep. Requested:</span><?php echo $form['department_name']; ?></div>

		</div>



		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-container">

		<table class="table table-bordered table-striped">

		 	<thead>

	        	<tr>

	          		<th>Item Name</th>

	          		<th>Description</th>

	          		<th>Quantity</th>

	          		<th>Delivered</th>

	          	</tr>

			</thead>

			<tbody>

				<?php if(isset($items)): ?>

					<?php foreach ($items as $item): ?>

						<tr>

							<td><?php echo $item['name']; ?></td>

							<td><?php echo $item['description']; ?></td>

							<td><?php echo $item['quantity']; ?></td>

							<td>	<?php if ($item['delivery']==1) {?>

										 <div style="background:#01DF74;"> 

											 	Delivered <span class="pull-right" style="font-size: 12px;"><?php echo $item['fullname']?> </span>

											 </div>	

									<?php }else{?>		 

								<div class="data-head relative" style="padding-bottom:40px !important; ">

			                    	<button class="expander-container form-actions btn btn-danger non-printable" >Delivery</button> 

			                    	<?php }?>

			                    		    <div class="expander-wrapper" style="width:250%;">

			                      			   <span class="expander-remover"><i class='glyphicon glyphicon-remove '></i></span>

			                      			     <div class="expander">

			                        			    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-holder" style="margin-top: 10px;">

			                          				  <div class="row">

			                            				<form action="/forms/delivery/<?php 

			                            				echo $form['id']?>/<?php echo $item['id'];?>" method="POST" id="form-submit"  class="form-div span12" accept-charset="utf-8" name="myForm" onsubmit="return validateForm()">

			                              				  <label for="from-type" class="control-label " style="width:100%px;">Quantity of Delivered items:</label>

			                              					<input type="text" class="form-control" 

			                              					name="reason"  icd="reason" required>

			                              				<input name="submit" value="submit" type="submit" class="inverse-offset btn btn-danger" />

			                            				</form>

			                            				<br>

			                            				<br>

			                          				  	<form action="/forms/delivery/<?php 

			                            				echo $form['id']?>/<?php echo $item['id'];?>/1" method="POST" id="form-submit"  class="form-div span12" accept-charset="utf-8" name="myForm" >

			                            				 <label for="from-type" class="control-label " style="width:100%px;">If All items Delivered:</label>

			                            				 <br>

			                          				  		 <input name="submit" value="Delivered" type="submit" class="inverse-offset btn btn-success" />

			                          				  	</form>	 

			                          				</div>

			                        			</div>

			                      			</div>

			                    		</div>

			                  		</div>

			                  <?php if($item['deliverd_items']) {?>

			                  	<?php foreach ($item['deliverd_items'] as $row) {?>

			                     <?php if($row['reason']) {?>	

									 <div>

									 	<?php echo $row['reason']?> <span class="pull-right" style="font-size: 12px;"><?php echo $row['fname']?> </span>

									 	<?php if($is_admin){?>

	                  					 <a href="<?= base_url('forms/del_delivery/'.$row['id'].'/'.$form['id']); ?>" class="fa fa-trash"></a>

	                  					 <?php }?>

									 </div>

								 <?php }?>

								<?php }?>

							<?php }?>		 	 

						     </td>

						</tr>

					<?php endforeach; ?>

				<?php endif; ?>

			</tbody>

		</table>

		</div>



		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-container">

			<div><span class="data-head">Present Location:</span><div class="inline-text"><?php echo $form['location']; ?></div></div>

		</div>



		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-container">

			<div><span class="data-head">Reason For Movement:</span><div class="inline-text"><?php echo $form['movement_reason']; ?></div></div>

		</div>



		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-container">

			<div><span class="data-head">What Will Happen To Old Item After Movement:</span><div class="inline-text"><?php echo $form['old_reason']; ?></div></div>

		</div>



		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-container">

			<div><span class="data-head">New Location:</span><div class="inline-text"><?php echo $form['destination']; ?></div></div>

		</div>



		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-container">

		<div class="data-head centered">Hotel Requested Approved by:</div>

			<div class="row">

				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">

					<div class="data-head">Dep. Head</div>

					<div class="data-content"><span class="data-label">Name:</span><span class="name-data-content"><?php echo $form['dstn_dpt_head_fullname']; ?></span></div>

					<?php if ($form['dstn_dpt_head_id']): ?>

						<div class="data-content"><span class="data-label sign-data-content">Signature:</span><img src="<?php echo $signature_path.'approved.png'; ?>" alt="<?php echo $form['dstn_dpt_head_fullname']; ?>" class="img-rounded sign-image"></div>

					<?php elseif(isset($user_signs['dstn_dpt_head'])): ?>

						<div class="data-content"><span class="data-label sign-data-content">Signature:</span><a href="/forms/sign/<?php echo $form['id']; ?>/dstn_dpt_head" class="btn btn-success">Sign here</a></div>

					<?php else: ?>

						<div class="data-content"><span class="data-label sign-data-content">Signature:</span></div>

					<?php endif; ?>

				</div>

				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">

					<?php if($form['id'] == 246): ?>

						<div class="data-head">Madar CEO</div>

					<?php else: ?>

						<div class="data-head">Hotel GM</div>

					<?php endif; ?>

					<div class="data-content"><span class="data-label">Name:</span><span class="name-data-content"><?php echo $form['dstn_hotel_gm_fullname']; ?></span></div>

					<?php if($form['id'] == 246): ?>

						<?php if($form['dstn_hotel_gm_id']): ?>

							<div class="data-content"><span class="data-label sign-data-content">Signature:</span><img src="<?php echo $signature_path.'approved.png'; ?>" alt="<?php echo $form['dstn_hotel_gm_fullname']; ?>" class="img-rounded sign-image"></div>

						<?php elseif($user_id == 377): ?>

							<div class="data-content"><span class="data-label sign-data-content">Signature:</span><a href="/forms/sign/<?php echo $form['id']; ?>/dstn_hotel_gm" class="btn btn-success">Sign here</a></div>

						<?php else: ?>

							<div class="data-content"><span class="data-label sign-data-content">Signature:</span></div>

						<?php endif; ?>

					<?php elseif($form['dstn_hotel_gm_id']): ?>

						<div class="data-content"><span class="data-label sign-data-content">Signature:</span><img src="<?php echo $signature_path.'approved.png'; ?>" alt="<?php echo $form['dstn_hotel_gm_fullname']; ?>" class="img-rounded sign-image"></div>

					<?php elseif(isset($user_signs['dstn_hotel_gm'])): ?>

						<div class="data-content"><span class="data-label sign-data-content">Signature:</span><a href="/forms/sign/<?php echo $form['id']; ?>/dstn_hotel_gm" class="btn btn-success">Sign here</a></div>

					<?php else: ?>

						<div class="data-content"><span class="data-label sign-data-content">Signature:</span></div>

					<?php endif; ?>

				</div>

				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">

					<div class="data-head">Hotel FC</div>

					<div class="data-content"><span class="data-label">Name:</span><span class="name-data-content"><?php echo $form['dstn_hotel_fc_fullname']; ?></span></div>

					<?php if ($form['dstn_hotel_fc_id']): ?>

						<div class="data-content"><span class="data-label sign-data-content">Signature:</span><img src="<?php echo $signature_path.'approved.png'; ?>" alt="<?php echo $form['dstn_hotel_fc_fullname']; ?>" class="img-rounded sign-image"></div>

					<?php elseif(isset($user_signs['dstn_hotel_fc'])): ?>

						<div class="data-content"><span class="data-label sign-data-content">Signature:</span><a href="/forms/sign/<?php echo $form['id']; ?>/dstn_hotel_fc" class="btn btn-success">Sign here</a></div>

					<?php else: ?>

						<div class="data-content"><span class="data-label sign-data-content">Signature:</span></div>

					<?php endif; ?>

				</div>

			</div>

		</div>

    
    <?php if(($form['from_hotel_id'] !=50) && ($form['from_hotel_id'] !=52)) {?>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-container">

		<div class="data-head centered">Hotel Movement Approved by:</div>

			<div class="row">

				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">

					<div class="data-head">Dep. Head</div>

					<div class="data-content"><span class="data-label">Name:</span><span class="name-data-content"><?php echo $form['src_dpt_head_fullname']; ?></span></div>

					<?php if ($form['src_dpt_head_id']): ?>

						<div class="data-content"><span class="data-label sign-data-content">Signature:</span><img src="<?php echo $signature_path.'approved.png'; ?>" alt="<?php echo $form['src_dpt_head_fullname']; ?>" class="img-rounded sign-image"></div>

					<?php elseif(isset($user_signs['src_dpt_head'])): ?>

						<div class="data-content"><span class="data-label sign-data-content">Signature:</span><a href="/forms/sign/<?php echo $form['id']; ?>/src_dpt_head" class="btn btn-success">Sign here</a></div>

					<?php else: ?>

						<div class="data-content"><span class="data-label sign-data-content">Signature:</span></div>

					<?php endif; ?>

				</div>

				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">

					<div class="data-head">Hotel GM</div>

					<div class="data-content"><span class="data-label">Name:</span><span class="name-data-content"><?php echo $form['src_hotel_gm_fullname']; ?></span></div>

					<?php if ($form['src_hotel_gm_id']): ?>

						<div class="data-content"><span class="data-label sign-data-content">Signature:</span><img src="<?php echo $signature_path.'approved.png'; ?>" alt="<?php echo $form['src_hotel_gm_fullname']; ?>" class="img-rounded sign-image"></div>

					<?php elseif(isset($user_signs['src_hotel_gm'])): ?>

						<div class="data-content"><span class="data-label sign-data-content">Signature:</span><a href="/forms/sign/<?php echo $form['id']; ?>/src_hotel_gm" class="btn btn-success">Sign here</a></div>

					<?php else: ?>

						<div class="data-content"><span class="data-label sign-data-content">Signature:</span></div>

					<?php endif; ?>

				</div>

				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">

					<div class="data-head">Hotel FC</div>

					<div class="data-content"><span class="data-label">Name:</span><span class="name-data-content"><?php echo $form['src_hotel_fc_fullname']; ?></span></div>

					<?php if ($form['src_hotel_fc_id']): ?>

						<div class="data-content"><span class="data-label sign-data-content">Signature:</span><img src="<?php echo $signature_path.'approved.png'; ?>" alt="<?php echo $form['src_hotel_fc_fullname']; ?>" class="img-rounded sign-image"></div>

					<?php elseif(isset($user_signs['src_hotel_fc'])): ?>

						<div class="data-content"><span class="data-label sign-data-content">Signature:</span><a href="/forms/sign/<?php echo $form['id']; ?>/src_hotel_fc" class="btn btn-success">Sign here</a></div>

					<?php else: ?>

						<div class="data-content"><span class="data-label sign-data-content">Signature:</span></div>

					<?php endif; ?>

				</div>

			</div>

		</div>
<?php }elseif($form['from_hotel_id']==50){?>
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-container">

		<div class="data-head centered">Hotel Movement Approved by:</div>

			<div class="row">

				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">

					<div class="data-head">امين المخزن</div>

					<div class="data-content"><span class="data-label">Name:</span><span class="name-data-content"><?php echo $form['src_amen_m5zn_fullname']; ?></span></div>

					<?php if ($form['src_amen_m5zn_id']): ?>

						<div class="data-content"><span class="data-label sign-data-content">Signature:</span><img src="<?php echo $signature_path.'approved.png'; ?>" alt="<?php echo $form['src_amen_m5zn_fullname']; ?>" class="img-rounded sign-image"></div>

					<?php elseif(isset($user_signs['src_amen_m5zn'])): ?>

						<div class="data-content"><span class="data-label sign-data-content">Signature:</span><a href="/forms/sign/<?php echo $form['id']; ?>/src_amen_m5zn" class="btn btn-success">Sign here</a></div>

					<?php else: ?>

						<div class="data-content"><span class="data-label sign-data-content">Signature:</span></div>

					<?php endif; ?>

				</div>

				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">

					<div class="data-head">CFO</div>

					<div class="data-content"><span class="data-label">Name:</span><span class="name-data-content"><?php echo $form['src_msaol_m5zn_fullname']; ?></span></div>

					<?php if ($form['src_msaol_m5zn_id']): ?>

						<div class="data-content"><span class="data-label sign-data-content">Signature:</span><img src="<?php echo $signature_path.'approved.png'; ?>" alt="<?php echo $form['src_msaol_m5zn_fullname']; ?>" class="img-rounded sign-image"></div>

					<?php elseif(isset($user_signs['src_msaol_m5zn'])): ?>

						<div class="data-content"><span class="data-label sign-data-content">Signature:</span><a href="/forms/sign/<?php echo $form['id']; ?>/src_msaol_m5zn" class="btn btn-success">Sign here</a></div>

					<?php else: ?>

						<div class="data-content"><span class="data-label sign-data-content">Signature:</span></div>

					<?php endif; ?>

				</div>


			</div>

		</div>

<?php }elseif($form['from_hotel_id']==52){?>
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-container">

		<div class="data-head centered">Hotel Movement Approved by:</div>

			<div class="row">

				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">

					<div class="data-head">Project Manager</div>

					<div class="data-content"><span class="data-label">Name:</span><span class="name-data-content"><?php echo $form['src_pro_fullname']; ?></span></div>

					<?php if ($form['src_pro_id']): ?>

						<div class="data-content"><span class="data-label sign-data-content">Signature:</span><img src="<?php echo $signature_path.'approved.png'; ?>" alt="<?php echo $form['src_pro_fullname']; ?>" class="img-rounded sign-image"></div>

					<?php elseif(isset($user_signs['src_pro'])): ?>

						<div class="data-content"><span class="data-label sign-data-content">Signature:</span><a href="/forms/sign/<?php echo $form['id']; ?>/src_pro" class="btn btn-success">Sign here</a></div>

					<?php else: ?>

						<div class="data-content"><span class="data-label sign-data-content">Signature:</span></div>

					<?php endif; ?>

				</div>

				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">

					<div class="data-head">CFO</div>

					<div class="data-content"><span class="data-label">Name:</span><span class="name-data-content"><?php echo $form['src_msaol_m5zn_fullname']; ?></span></div>

					<?php if ($form['src_msaol_m5zn_id']): ?>

						<div class="data-content"><span class="data-label sign-data-content">Signature:</span><img src="<?php echo $signature_path.'approved.png'; ?>" alt="<?php echo $form['src_msaol_m5zn_fullname']; ?>" class="img-rounded sign-image"></div>

					<?php elseif(isset($user_signs['src_msaol_m5zn'])): ?>

						<div class="data-content"><span class="data-label sign-data-content">Signature:</span><a href="/forms/sign/<?php echo $form['id']; ?>/src_msaol_m5zn" class="btn btn-success">Sign here</a></div>

					<?php else: ?>

						<div class="data-content"><span class="data-label sign-data-content">Signature:</span></div>

					<?php endif; ?>

				</div>


			</div>

		</div>

<?php }?>


		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-container">

		<div class="data-head centered">Final Approval</div>

			<div class="row">

				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">

					<div class="data-head">Cluster FC.</div>

					<div class="data-content"><span class="data-label">Name:</span><span class="name-data-content"><?php echo $form['fin_cluster_fc_fullname']; ?></span></div>

					<?php if ($form['fin_cluster_fc_id']): ?>

						<div class="data-content"><span class="data-label sign-data-content">Signature:</span><img src="<?php echo $signature_path.'approved.png'; ?>" alt="<?php echo $form['fin_cluster_fc_fullname']; ?>" class="img-rounded sign-image"></div>

					<?php elseif(isset($user_signs['fin_cluster_fc'])): ?>

						<div class="data-content"><span class="data-label sign-data-content">Signature:</span><a href="/forms/sign/<?php echo $form['id']; ?>/fin_cluster_fc" class="btn btn-success">Sign here</a></div>

					<?php else: ?>

						<div class="data-content"><span class="data-label sign-data-content">Signature:</span></div>

					<?php endif; ?>

				</div>

				<?php if($form['from_hotel_id']==50 || $form['from_hotel_id']==52) {?>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">

					<div class="data-head">RGM</div>

					<div class="data-content"><span class="data-label">Name:</span><span class="name-data-content"><?php echo $form['fin_rgm_fullname']; ?></span></div>

					<?php if ($form['fin_rgm_id']): ?>

						<div class="data-content"><span class="data-label sign-data-content">Signature:</span><img src="<?php echo $signature_path.'approved.png'; ?>" alt="<?php echo $form['fin_rgm_fullname']; ?>" class="img-rounded sign-image"></div>

					<?php elseif(isset($user_signs['fin_rgm'])): ?>

						<div class="data-content"><span class="data-label sign-data-content">Signature:</span><a href="/forms/sign/<?php echo $form['id']; ?>/fin_rgm" class="btn btn-success">Sign here</a></div>

					<?php else: ?>

						<div class="data-content"><span class="data-label sign-data-content">Signature:</span></div>

					<?php endif; ?>

				</div>
				<?php }?>

				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">

					<div class="data-head">R.D.O.F</div>

					<div class="data-content"><span class="data-label">Name:</span><span class="name-data-content"><?php echo $form['fin_rdof_fullname']; ?></span></div>

					<?php if ($form['fin_rdof_id']): ?>

						<div class="data-content"><span class="data-label sign-data-content">Signature:</span><img src="<?php echo $signature_path.'approved.png'; ?>" alt="<?php echo $form['fin_rdof_fullname']; ?>" class="img-rounded sign-image"></div>

					<?php elseif(isset($user_signs['fin_rdof'])): ?>

						<div class="data-content"><span class="data-label sign-data-content">Signature:</span><a href="/forms/sign/<?php echo $form['id']; ?>/fin_rdof/1" class="btn btn-success">Sign here</a></div>

					<?php else: ?>

						<div class="data-content"><span class="data-label sign-data-content">Signature:</span></div>

					<?php endif; ?>

				</div>
				<?php if($form['id']<=290 && $form['id']!=289 && $form['id']!=287) {?>

				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">

					<div class="data-head">Chairman Office Cai</div>

					<div class="data-content"><span class="data-label">Name:</span><span class="name-data-content"><?php echo $form['fin_chrmn_cai_fullname']; ?></span></div>

					<?php if ($form['fin_chrmn_cai_id']): ?>

						<?php if ($form['id'] == 227 || $form['id'] == 24 || $form['id'] == 28 || $form['id'] == 29 || $form['id'] == 66 || $form['id'] == 73 || $form['id'] == 80 || $form['id'] == 102 || $form['id'] == 125 || $form['id'] == 126 || $form['id'] == 140 || $form['id'] == 148 || $form['id'] == 214 || $form['id'] == 98 || $form['id'] == 110 || $form['id'] == 179 || $form['id'] == 183 || $form['id'] == 189 || $form['id'] == 144): ?>

							<div class="data-content"><span class="data-label sign-data-content">Signature:</span><img src="<?php echo $signature_path.'rejected.png'; ?>" alt="<?php echo $form['fin_chrmn_cai_fullname']; ?>" class="img-rounded sign-image"></div>

						<?php else: ?>

							<div class="data-content"><span class="data-label sign-data-content">Signature:</span><img src="<?php echo $signature_path.'approved.png'; ?>" alt="<?php echo $form['fin_chrmn_cai_fullname']; ?>" class="img-rounded sign-image"></div>

						<?php endif; ?>

					<?php elseif(isset($user_signs['fin_chrmn_cai'])): ?>

						<div class="data-content"><span class="data-label sign-data-content">Signature:</span><a href="/forms/sign/<?php echo $form['id']; ?>/fin_chrmn_cai" class="btn btn-success">Sign here</a></div>

					<?php else: ?>

						<div class="data-content"><span class="data-label sign-data-content">Signature:</span></div>

					<?php endif; ?>

				</div>
             <?php }else{?>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">

					<div class="data-head">Chairman</div>

					<div class="data-content"><span class="data-label">Name:</span><span class="name-data-content"><?php echo $form['fin_chairman_fullname']; ?></span></div>

					<?php if ($form['fin_chairman_id']): ?>

						<div class="data-content"><span class="data-label sign-data-content">Signature:</span><img src="<?php echo $signature_path.'9f3a8-mr.-hossam.jpg'; ?>" alt="<?php echo $form['fin_chairman_fullname']; ?>" class="img-rounded sign-image"></div>

					<?php elseif(isset($user_signs['fin_chairman'])): ?>

						<div class="data-content"><span class="data-label sign-data-content">Signature:</span><a href="/forms/sign/<?php echo $form['id']; ?>/fin_chairman/2" class="btn btn-success">Sign here</a></div>

					<?php else: ?>

						<div class="data-content"><span class="data-label sign-data-content">Signature:</span></div>

					<?php endif; ?>

				</div>
			<?php }?>	

			</div>

		</div>

		<?php if ($owning_company || $is_admin) { ?>

			<a href="#" class="btn btn-success non-printable hanyclose hany-fram-start">Show</a>
             <?php if($form['from_hotel_id'] ==5) {?>
			    <a href="#" class="btn btn-success non-printable holidaysclose holidays-fram-start">Show holidays owning</a>
			 <?php }?>
		<?php } ?>

		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher hanyfram" style="display: none;">

			<a href="#" class="btn btn-success non-printable hany-fram-remover hanyclose">Hide</a>

          	<iframe src="/forms/owningcompany/<?php echo $form['id']; ?>" scrolling="no" style="margin-left:-30px; width: 850px; height: 400px; border: none;"></iframe>


			        <script type="text/javascript">

						$('.hanyclose').click( function(e) {

						     e.preventDefault();

						});

						$(".hany-fram-start").on("click", function(){

							$(".hanyfram").show();

							$(".hany-fram-start").hide();

							$(this).parent().find(".hany-fram").toggle("fast");

						});

						$(".hany-fram-remover").on("click", function(){

							$(".hanyfram").hide();

							$(".hany-fram-start").show();

							$(this).parent().hide("fast");

							document.location.reload(true);			

						});

						

					</script>
             </div>
             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher holidaysfram" style="display: none;">

					<a href="#" class="btn btn-success non-printable holidays-fram-remover holidaysclose">Hide</a>

		          	<iframe src="/forms/owningcompany_holidays/<?php echo $form['id']; ?>" scrolling="no" style="margin-left:-30px; width: 850px; height: 400px; border: none;"></iframe>

					  <script type="text/javascript">
						$('.holidaysclose').click( function(e) {

						     e.preventDefault();

						});

						$(".holidays-fram-start").on("click", function(){

							$(".holidaysfram").show();

							$(".holidays-fram-start").hide();

							$(this).parent().find(".holidays-fram").toggle("fast");

						});

						$(".holidays-fram-remover").on("click", function(){

							$(".holidaysfram").hide();

							$(".holidays-fram-start").show();

							$(this).parent().hide("fast");

							document.location.reload(true);			

						});
					</script>
              </div>
		<?php if ($hany || $is_admin || $owning_company) { ?>

			<a href="#" class="btn btn-success non-printable hanyclose1 hany-fram1-start">Show</a>

		<?php } ?>

		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher hanyfram1" style="display: none;">

			<a href="#" class="btn btn-success non-printable hany-fram-remover1 hanyclose1">Hide</a>

          	<iframe src="/forms/financialowning/<?php echo $form['id']; ?>" scrolling="yes" style="margin-left:-30px; width: 850px; height: <?php if ($form['id'] == 262 || $form['id'] == 263 || $form['id'] == 264): ?> 4700px <?php elseif($form['id'] == 265): ?> 3700px  <?php elseif($form['id'] == 269): ?> 2000px <?php elseif($form['id'] == 266 || $form['id'] == 267): ?> 1400px <?php else: ?> 400px <?php endif; ?>; border: none;"></iframe>

        </div>

        <script type="text/javascript">

			$('.hanyclose1').click( function(e) {

			     e.preventDefault();

			});

			$(".hany-fram1-start").on("click", function(){

				$(".hanyfram1").show();

				$(".hany-fram1-start").hide();

				$(this).parent().find(".hany-fram").toggle("fast");

			});

			$(".hany-fram-remover1").on("click", function(){

				$(".hanyfram1").hide();

				$(".hany-fram1-start").show();

				$(this).parent().hide("fast");

				document.location.reload(true);			

			});

			

		</script>

		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-container">

			<div class="data-head centered">Chairman</div>

			<div class="data-head centered">Hossam El Shaer</div>

		</div>



		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-container">

			<div class="col-lg-4 col-md-4 col-sm-5 col-xs-5">

				<div class="data-head">Recieved by</div>

				<div><span class="data-head data-label">Name:</span><?php echo $form['rcv_user_fullname']; ?></div>

				<div><span class="data-head data-label">Position:</span><?php echo $form['rcv_user_role']; ?></div>

				<?php if ($form['rcv_user_id']): ?>

					<div><span class="data-head data-label sign-data-content">Signature:</span><img src="<?php echo $signature_path.'approved.png'; ?>" alt="<?php echo $form['rcv_user_fullname']; ?>" class="img-rounded sign-image"></div>

				<?php elseif(isset($user_signs['rcv_user']) && $form['form_state_id'] == 5): ?>

					<div class="data-content"><span class="data-head data-label sign-data-content">Signature:</span> <a href="/forms/sign/<?php echo $form['id']; ?>/rcv_user" class="btn btn-success">Sign here</a></div>

				<?php else: ?>

					<div class="data-content"><span class="data-head data-label sign-data-content">Signature:</span> </div>

				<?php endif; ?>

				<div><span class="data-head data-label">Date:</span><?php echo ($form['rcv_user_id']) ? $form['rcv_user_date'] : ''; ?></div>

			</div>

		</div>



		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-container">

			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 data-head">Distribution</div>

			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">

				<div class="data-head">1. Hotel Acc.</div>

				<?php if ($form['rcv_hotel_acc_id']): ?>

				<div><?php echo $form['rcv_hotel_acc_fullname']; ?></div>

				<?php elseif(isset($user_signs['rcv_hotel_acc']) && $form['form_state_id'] == 6): ?>

					<div class="data-content"><a href="/forms/sign/<?php echo $form['id']; ?>/rcv_hotel_acc" class="btn btn-success">Confirm</a></div>

				<?php endif; ?>

			</div>

			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">

				<div class="data-head">2. Dep. Head</div>

				<?php if ($form['rcv_dpt_head_id']): ?>

				<div><?php echo $form['rcv_dpt_head_fullname']; ?></div>

				<?php elseif(isset($user_signs['rcv_dpt_head']) && $form['form_state_id'] == 6): ?>

					<div class="data-content"><a href="/forms/sign/<?php echo $form['id']; ?>/rcv_dpt_head" class="btn btn-success">Confirm</a></div>

				<?php endif; ?>

			</div>

			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">

				<div class="data-head">3. Chairman Office Cai</div>

				<?php if ($form['rcv_chrmn_cai_id']): ?>

				<div><?php echo $form['rcv_chrmn_cai_fullname']; ?></div>

				<?php elseif(isset($user_signs['rcv_chrmn_cai']) && $form['form_state_id'] == 6): ?>

					<div class="data-content"><a href="/forms/sign/<?php echo $form['id']; ?>/rcv_chrmn_cai" class="btn btn-success">Confirm</a></div>

				<?php endif; ?>

			</div>

		</div>

		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher non-printable">

	                			<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">

	                  				<form action="/forms/commen_formt/<?php echo $form['id']?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">

	                    				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">

	                     					<textarea class="form-control" name="comment" id="comment"></textarea>

	                    				</div>

	                    				<input name="form_id" value="<?php echo $form['id']?>" type="hidden" />

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

	</div>

	</div>

	</div>

</div>

</body>

</html>

<script type="text/javascript">

	$(".expander-container").on("click", function(){

		$(".expander-wrapper").hide();

		$(this).parent().find(".expander-wrapper").toggle("fast");

	});

	$(".expander-remover").on("click", function(){

	$(this).parent().hide("fast");

	});

</script>