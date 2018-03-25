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
       						<button onclick="window.print()" class="non-printable form-actions btn btn-success" href="" >Print</button>
							<?php if ($is_editor): ?>
								<a class="form-actions btn btn-info non-printable" href="/char_report/edit/<?php echo $char['id'] ?>" style="float:right;" > Edit </a>
							<?php endif ?>
							<h1 class="centered">
		        				Chairman Monthly Report <?php echo $char['file']; ?>
		        			</h1>
		        			<br>
		        			<a class="form-actions btn btn-info non-printable" href="/char_report/mailme/<?php echo $char['id'] ?>" style="float:left; margin-left: 20px;" > <img src="/assets/images/letter.png" style="width: 28px; height: 40px; margin: 0px; margin-left: -10px; margin-top: -10px; margin-bottom: -10px;"> Share by Email </a>
		        			<?php foreach($uploads as $upload): ?>
		        			<a data-text="whatsapp" data-link="<?php echo base_url(); ?><?php echo $file_path ?><?php echo $upload['name'] ?>" style="float:left; margin-left: 20px;" class="whatsapp whatsapp_btn whatsapp_btn_small form-actions btn btn-success non-printable"> <img src="/assets/images/original.png" style="width: 70px; height: 50px; margin: -20px; margin-left: -30px; margin-top: -21px;"> Share by Whatsapp</a>
		                    <?php endforeach ?>	
		        		</div>
                  		<div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                  			<div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
			        			<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
			        				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
			        					<br>
			        					<br>
			        					<br>
				        				<h5> <span style="font-weight: bold;">Report for : </span> <?php echo $char['date']; ?></h5>
				        			</div>
				        		</div>
				        		<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
			        				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
			        					<br>
				        				<h5> <span style="font-weight: bold;">Report Name: </span> <?php echo $char['file']; ?></h5>
				        			</div>
				        		</div>
                  				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12  data-indention ">
		                      		<label for="offers" class="col-lg-3 col-md-4 col-sm-5 col-xs-5 control-label">Report Files</label>
									<div class="form-group col-lg-9 col-md-8 col-sm-7 col-xs-7">
		                       			<?php foreach($uploads as $upload): ?>
		                       				<a href='/assets/uploads/files/<?php echo $upload['name'] ?>'><?php echo $upload['name'] ?></a><br />
		                        		<?php endforeach ?>	
		                        		<br>
						        		<br>
						        		<br>
						        		<br>
						        		<br>		
		                      		</div>	
	                      		</div>	
			        		</div>
		        		</div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher non-printable">
                			<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  				<form action="/char_report/comment/<?php echo $char['id']?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
                    				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    					<br>
                    					<br>
                     					<textarea class="form-control" name="comment" id="comment"></textarea>
                    				</div>
                    				<input name="char_id" value="<?php echo $char['id']?>" type="hidden" />
                    				<input name="submit" value="comment" type="submit" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-actions btn btn-success " />
                  				</form>
                			</div>
              			</div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-holder">
                			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher">
                  				<div class="data-head centered"> 
                    				<h3>Comments</h3> 
                  				</div>
                  				<div class="data-holder">
                    				<?php foreach($get_comment as $comment ){ ?>
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
    					<p class="centered">The Chairman Monthly Report has been created by <?php echo $char['name'];?> at <?php echo $char['timestamp'];?></p>
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