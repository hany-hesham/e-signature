<!DOCTYPE html>
<html lang="en">
	<head>
		<?php $this->load->view('header'); ?>
	</head>
	<body>
    	<div id="wrapper">
			<?php $this->load->view('menu') ?>
			<div id="page-wrapper">
	          	<div  class="a4wrapper">
					<div class="a4page">
                		<div class="page-header">
       						<button onclick="window.print()" class="non-printable form-actions btn btn-success" href="" >Print</button>
            				<a class="form-actions btn btn-success non-printable" href="/illness/index_hotel/<?php echo $illness['date']; ?>/<?php echo $illness['hotel_code']; ?>" style="float:right;" > Go To All <?php echo $illness['hotel_name']; ?> For <?php echo $illness['date']; ?></a>
							<div class="header-logo"><img src="/assets/uploads/logos/<?php echo $illness['logo']; ?>"/></div>
		                  	<h1 class="centered"><?php echo $illness['hotel_name']; ?></h1>
			        		<h3 class="centered">
			        			Illness Log Form No. #<?php echo $illness['id']; ?>
			        		</h3>
			        	</div>
            			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-holder">
							<a class="form-actions btn btn-info non-printable" href="/illness/edit/<?php echo $illness['id'] ?>" style="float:right;" > Edit </a>
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher">
								<table class="table table-striped table-bordered table-condensed">
									<tr>
				                        <th colspan="1" style=" text-align: center;">No#</th>
				                        <th colspan="1" style=" text-align: center;">Date</th>
				                        <th colspan="1" style=" text-align: center;">Guest Name</th>
				                        <th colspan="1" style=" text-align: center;">Room</th>
				                        <th colspan="1" style=" text-align: center;">Tour Operator</th>
				                        <th colspan="1" style=" text-align: center;">Diagnosis / Symptoms</th>
				                        <th colspan="1" style=" text-align: center;">Hotel Clinic Visit (*Yes / **No)</th>
				                        <th colspan="1" style=" text-align: center;">* If Yes - is MR available (Yes / No)</th>
				                        <th colspan="1" style=" text-align: center;">** If No - to who the symptoms were reported (e.g. FO, GSC, TL etc)</th>
				                        <th colspan="1" style=" text-align: center;">Comments</th>
                        				<th colspan="1" style=" text-align: center;">Related IR#</th>
				                    </tr>
									<?php $count = 1; ?>
									<?php foreach ($guests as $guest): ?>
										<tr class="item-row">
											<td class="centered"><?php echo $count; ?></td>
											<td class="centered"><?php echo $guest['dates']; ?></td>
											<td class="centered"><?php echo $guest['guest']; ?></td>
											<td class="centered"><?php echo $guest['room']; ?></td>
											<td class="centered"><?php echo $guest['operator_name']; ?></td>
											<td class="centered"><?php echo $guest['symptoms']; ?></td>
											<td class="centered"><?php echo $guest['visit']; ?></td>
											<td class="centered"><?php echo $guest['avaible']; ?></td>
											<td class="centered"><?php echo $guest['reported']; ?></td>
											<td class="centered"><?php echo $guest['comments']; ?></td>
											<td class="centered">
												<a class="form-actions btn btn-success non-printable" href="/form/<?php if($guest['ir_type'] == 1){ echo "view_in_uk";}elseif($guest['ir_type'] == 2){ echo "view_in";} ?>/<?php echo $guest['ir']; ?>" style="float:right;" > No# <?php echo $guest['ir']; ?></a>
											</td>
										</tr>
										<?php $count++; ?>
									<?php endforeach ?>
								</table>
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher data-indention non-printable">
			                      	<label for="offers" class="col-lg-3 col-md-4 col-sm-5 col-xs-5 control-label">Report Files</label>
									<div class="form-group col-lg-9 col-md-8 col-sm-7 col-xs-7">
			                       		<?php foreach($uploads as $upload): ?>
			                       			<a href='/assets/uploads/files/<?php echo $upload['name'] ?>'><?php echo $upload['name'] ?></a><br />
			                        	<?php endforeach ?>			
			                      	</div>	
		                      	</div>
		                    </div>
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher non-printable">
	                			<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
	                  				<form action="/illness/comment/<?php echo $illness['id']?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
	                    				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
	                     					<textarea class="form-control" name="comment" id="comment"></textarea>
	                    				</div>
	                    				<input name="iln_id" value="<?php echo $illness['id']?>" type="hidden" />
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
	    			</div>
	    			<div class="data-content">
	    				<p class="centered">The Illness Log Form has been created by <?php echo $illness['name'];?> at <?php echo $illness['timestamp'];?></p>
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