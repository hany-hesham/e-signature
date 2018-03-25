<!DOCTYPE html>
<html lang="en">
<head>
<?php $this->load->view('header'); ?>
<style type="text/css">
    @media screen {
        div.divFooter {
            display:block;

        }
    div.doop {
        	display: none;
        }
    }
    @media print {
        div.doop {
            display:block;
        }
    }
</style>
</head>
<body>
<div id="wrapper">
	<?php if (!$demo) {
		$this->load->view('menu');
	} ?>
	<div id="page-wrapper">
	<?php if (!$demo): ?>
       			<button onclick="window.print()" class="non-printable form-actions btn btn-success" href="" >Print</button>
        <?php endif ?>
	<div class="a4wrapper">

	<div class="a4page">
		<div class="page-header">
		<div class="header-logo"><img src="<?php echo $logo_path.$plan['hotel_logo']; ?>"></div>
		<h1 class="centered">Major Requests</h1>
	        <h3 class="centered"><?php echo $plan['hotel_name']; ?> &nbsp;&nbsp;&nbsp;Year: <?php echo $plan['year']; ?></h3>
	       	<div class="header-box header-box-big">
		        <h5 class="righty"><span class="total-head"> Total items: <?php echo $MJ['count']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Total Major Requests: <?php echo number_format($MJ['total'],2,".",","); ?></span></h5>
	        </div>
	        <div class="header-box" style="position:relative; padding:7px;">
		        			<?php if (!$demo): ?>
		       				<a class="form-actions btn btn-info non-printable" href="/plans/summary/<?php echo $plan['id'] ?>" style="float:right;" >View summary </a>
		       				<br>
		       				<br>
							<a class="form-actions btn btn-info non-printable" href="/plans/view/<?php echo $plan['id'] ?>" style="float:right;" >View details </a>
				
		    			    <?php endif ?>
	        			</div>
	    </div>

		<?php foreach ($devisions as $devKey => $devision): ?>
			<?php if ($devKey != 999): ?>
				<div class="devision-container"><div class="devision-header-container"><span class="devision-header"><?php echo $devision['name']; ?></span><span class="devision-count">Items: <?php echo $devision['count'] ?></span><div class="devision-total"><span>Estimated Value:</span><span class="total-value"> <?php echo number_format($devision['total'],2,".",","); ?></span></div></div>	
			<?php endif ?>
			
			<?php foreach ($devision['departments'] as $department): ?>
				<?php $last_item = false; ?>
				<div class="department-container"><div class="department-header-container"><span class="department-header"><?php echo $department['name']; ?></span><span class="department-count">Items: <?php echo $department['count'] ?></span><div class="devision-total"><span>Estimated Value:</span><span class="total-value"> <?php echo number_format($department['total'],2,".",","); ?></span></div></div>
					<?php if (!empty($items[$devision['id']][$department['id']])): ?>
					<table class="table table-striped table-bordered table-condensed table-smallfont">
						<thead>
							<tr>
								<th>#</th>
								<th>Item</th>
								<th>Quantity</th>
								<th>Value (each)</th>
								<th>Estimated Value</th>
								<th>Priority</th>
								<th>Description</th>
								<th class="edit"></th>
							</tr>
						</thead>
						<tbody id="items-container-<?php echo $department['id']; ?>" data-items="0">
						<?php if (isset($items[$devision['id']][$department['id']])): ?>
							
							<?php foreach ($items[$devision['id']][$department['id']] as $item): ?>
								<?php $last_item = $item; ?>
							<tr class="<?php echo ($item['cancelled'] == 1)? 'cancelled' : ''; ?>" id="item-<?php echo $department['id']?>-<?php echo $item['code']; ?>">
								<td>
									<span data-mirror="code" class="orig"><?php echo $item['code'] ?></span>
									<span data-mirror="id" class="orig hidden"><?php echo $item['id'] ?></span>
								</td>
								<td>
									<span data-mirror="name" class="orig"><?php echo $item['name'] ?></span>
								</td>
								<td class="align-center">
									<span data-mirror="quantity" class="orig"><?php echo $item['quantity'] ?></span>
								</td>
								<td class="align-right">
									<span data-mirror="value" class="orig"><?php echo number_format($item['value'],2,".",","); ?></span>
								</td>
								<td class="align-right">
									<?php echo number_format($item['total'],2,".",","); ?>
								</td>
								<td class="align-center">
									<span data-mirror="priority" class="orig"><?php echo $priorities[$item['priority_id']] ?></span>
								</td>
								<td>
									<span data-mirror="remarks" class="orig"><?php echo $item['remarks'] ?></span>
								</td>
								<?php if (!$demo): ?>
								<td>
								<?php if ($item['cancelled'] == 1): ?>
									<span class="red">Cancelled</span>
								<?php elseif ($item['cancelled'] == 2): ?>
									<span class="checked"><i class="fa fa-check glyphicon glyphicon-check"></i></span>
								<?php endif; ?>
								</td>
								<?php endif; ?>
							</tr>
							<?php endforeach ?>
						<?php endif ?>
						</tbody>
					</table>
					<?php endif ?>
				</div>
			<?php endforeach ?>
			</div>
		<?php endforeach ?>
	</div>
	</div>
</div>
<?php if (!$demo): ?>
		<div class="a4wrapper divFooter">
		<footer>
		
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher">
			<div class="doop">
		       				<h5 class="centered">
		        				<span class="total-head"> 
		        					Total items: <?php echo $MJ['count']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
		        					Total Major Requests: <?php echo number_format($MJ['total'],2,".",","); ?>
		           				</span>
		           			</h5>
	        			</div>
			<?php foreach ($signers as $signe_id => $signer): ?>
				<div class="signature-wrapper">
					<div class="data-head relative"><?php echo (strlen($signer['role']) == 0)? "plan Owner" : $signer['role'] ?>
						<span class="expander-container"><i class='glyphicon glyphicon-envelope'></i></span>
						<div class="expander-wrapper">
						<span class="expander-remover"><i class='glyphicon glyphicon-remove'></i></span>
							<div class="expander">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-holder">
									<div class="row">
										<form action="/plans/mailto/<?php echo $plan['id']; ?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
											<?php if (isset($signer['sign'])): ?>
											<input checked="checked" type="radio" name="mail" value="<?php echo $signer['sign']['mail'] ?>" /><label>To: <?php echo $signer['sign']['name'] ?></label>
											<?php else: ?>
												<?php $i=0; foreach ($signer['queue'] as $id => $signe): ?>
													<input <?php echo (++$i == 1)? 'checked="checked"' : '' ?> type="radio" name="mail" value="<?php echo $signe['mail'] ?>" id="u<?php echo $id ?>" /><label for="u<?php echo $id ?>">To: <?php echo $signe['name'] ?></label><br />
												<?php endforeach ?>
											<?php endif; ?>
											<?php if (isset($i) && $i == 0): ?>
												<span>No users availaable</span>
											<?php else: ?>
											<textarea class="form-control" name="message" id="message"></textarea>
											<input name="submit" value="Send" type="submit" class="inverse-offset btn btn-success non-printable" />
											<?php endif; ?>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php if (isset($signer['sign'])): ?>
						<div class="data-content"><img src="<?php echo isset($signer['sign']['reject'])? $signature_path.'rejected.png' : $signature_path.'approved.png'; ?>" alt="<?php echo $signer['sign']['name']; ?>" class="img-rounded sign-image"></div>
						<div class="data-content"><span class="name-data-content"><?php echo $signer['sign']['name']; ?></span></div>
					<?php elseif (array_key_exists($user_id, $signer['queue']) && $sign_enabled): ?>
						<div class="data-content"><span class="data-label sign-data-content"></span><a href="/plans/sign_major/<?php echo $signe_id; ?>" class="btn btn-success non-printable">sign</a></div>
					<?php else: ?>
						<?php $sign_enabled = FALSE; ?>
					<?php endif ?>
				</div>
			
			<?php endforeach ?>
			
			</div>

		</div>
	</footer>
	<?php endif; ?>
</div>
	<div class="holder">Please Wait...</div>
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
    	
</body>
</html>