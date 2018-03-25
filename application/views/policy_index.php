<!DOCTYPE html>
<html lang="en">
  	<head>
    	<?php $this->load->view('header'); ?>
  	</head>
  	<body>
    	<div id="wrapper">
      		<?php $this->load->view('menu') ?>
      		<div id="page-wrapper">
              	<div class="page-header">
					<a class="form-actions btn btn-success non-printable" href="/policy/view/<?php echo $core['id'] ?>" style="float:left;" > view </a>
					<?php if ($is_request): ?>
        				<a href="<?php echo base_url(); ?>policy_request/submit/" class="btn btn-info" style="float:right;">New Signature Policy Change Request</a>
        			<?php endif ?>
					<?php if ($is_admin): ?>
						<a class="form-actions btn btn-info non-printable" href="/policy/submit" style="float:right;" > Add New </a>
						<a class="form-actions btn btn-info non-printable" href="/policy/submit_type" style="float:right;" > Add New Type </a>
						<a class="form-actions btn btn-info non-printable" href="/policy/submit_department" style="float:right;" > Add New Department </a>
					<?php endif ?>
					<br>
					<br>
					<div class="header-logo"><img src="/assets/uploads/logos/SR-Master.png"/></div>
		            <h1 class="centered">Signature Policy (لائحة التوقيعات)</h1>
			        <a class="form-actions btn btn-info non-printable" href="/policy/mail_me/<?php echo $core['id'] ?>" style="float:left; margin-left: 20px;" > <img src="/assets/images/letter.png" style="width: 28px; height: 40px; margin: 0px; margin-left: -10px; margin-top: -10px; margin-bottom: -10px;"> Share by Email </a>
					<a data-text="whatsapp" data-link="<?php echo base_url(); ?>policy/view/<?php echo $core['id'] ?>" style="float:left; margin-left: 20px;" class="whatsapp whatsapp_btn whatsapp_btn_small form-actions btn btn-success non-printable"> <img src="/assets/images/original.png" style="width: 70px; height: 50px; margin: -20px; margin-left: -30px; margin-top: -21px;"> Share by Whatsapp</a> 
        			<a class="form-actions btn btn-success non-printable" href="/policies" style="float:right;" > Back </a>
					<div class="pager tablesorter-pager" style="display: block;">
          				Page: <select class="form-control gotoPage pager-filter" aria-disabled="false"></select>
          				<i class="fa fa-fast-backward pager-nav first disabled" alt="First" title="First page" tabindex="0" aria-disabled="true"></i>
          				<i class="fa fa-backward pager-nav prev disabled" alt="Prev" title="Previous page" tabindex="0" aria-disabled="true"></i>
          				<span class="pagedisplay"></span>
          				<i class="fa fa-forward pager-nav next" alt="Next" title="Next page" tabindex="0" aria-disabled="false"></i>
          				<i class="fa fa-fast-forward pager-nav last" alt="Last" title="Last page" tabindex="0" aria-disabled="false"></i>
          				<select class="form-control pagesize pager-filter" aria-disabled="false">
				            <option selected="selected" value="10">10</option>
				            <option value="30">30</option>
					        <option value="50">50</option>
          				</select>
        			</div>
					<table class="table table-striped table-bordered table-condensed">
                    	<thead>
            				<tr>
		                        <th class="header" style="background-color: black; color: white; width: 250px !important;">Description<i class="fa fa-sort"></i></th>
		                        <th class="header" style="color: gray;">First Signature<i class="fa fa-sort"></i></th>
		                        <th class="header" style="color: gray;">Second Signature<i class="fa fa-sort"></i></th>
		                        <th class="header" style="color: gray;">Third Signature<i class="fa fa-sort"></i></th>
		                        <th class="header" style="color: gray;">Fourth Signature<i class="fa fa-sort"></i></th>
		                        <th class="header" style="color: gray;">Fifth Signature<i class="fa fa-sort"></i></th>
		                        <th class="header" style="color: gray;">Sixth Signature<i class="fa fa-sort"></i></th>
		                        <th class="header" style="color: gray;">Seventh Signature<i class="fa fa-sort"></i></th>
		                        <th class="header" style="color: gray;">Eighth Signature<i class="fa fa-sort"></i></th>
		                        <th class="header" style="color: gray;">Ninth Signature<i class="fa fa-sort"></i></th>
                      		</tr>
                    	</thead>
                    	<tbody>
                      		<?php foreach ($departments as $department): ?>
                        		<tr>
                          			<td colspan="10" class="centered" style="background-color: gray; color: white;">
                            			<?php echo $department['name']?>
                          			</td>
                        		</tr>
                        		<?php foreach ($department['types'] as $type): ?>
                          			<tr>
                            			<td class="" style="background-color: black; color: white; width: 250px !important;"> 
                              				<?php echo $type['name']?>
                            			</td>
                            			<td class="centered"> 
                            				<?php echo $type['policy']['role_first']?>
                            			</td>
                            			<td class="centered"> 
                            				<?php echo $type['policy']['role_second']?>
                            			</td>
                            			<td class="centered"> 
                            				<?php echo $type['policy']['role_third']?>
                            			</td>
                            			<td class="centered"> 
                            				<?php echo $type['policy']['role_fourth']?>
                            			</td>
                            			<td class="centered"> 
                            				<?php echo $type['policy']['role_fifth']?>
                            			</td>
                            			<td class="centered"> 
                            				<?php echo $type['policy']['role_sixth']?>
                            			</td>
                            			<td class="centered"> 
                            				<?php echo $type['policy']['role_seventh']?>
                            			</td>
                            			<td class="centered"> 
                            				<?php echo $type['policy']['role_eighth']?>
                            			</td>
                            			<td class="centered"> 
                            				<?php echo $type['policy']['role_ninth']?>
                            			</td>
                          			</tr>
                        		<?php endforeach ?>
                      		<?php endforeach ?>
                      		<tr>
                      			<td colspan="10">
                      				<p>All rental contracts must be issued according to standard contract forms and reviewed by Legal Affairs and Chairman and approved before signing by concerned</p>
									<p>Above procedures should be followed and applied effective the above date</p>
                      			</td>
                      		</tr>
                    	</tbody>
                  	</table>  
                  	<div class="pager tablesorter-pager" style="display: block;">
          				Page: <select class="form-control gotoPage pager-filter" aria-disabled="false"></select>
          				<i class="fa fa-fast-backward pager-nav first disabled" alt="First" title="First page" tabindex="0" aria-disabled="true"></i>
          				<i class="fa fa-backward pager-nav prev disabled" alt="Prev" title="Previous page" tabindex="0" aria-disabled="true"></i>
				        <span class="pagedisplay"></span>
				        <i class="fa fa-forward pager-nav next" alt="Next" title="Next page" tabindex="0" aria-disabled="false"></i>
				        <i class="fa fa-fast-forward pager-nav last" alt="Last" title="Last page" tabindex="0" aria-disabled="false"></i>
				        <select class="form-control pagesize pager-filter" aria-disabled="false">
					        <option selected="selected" value="10">10</option>
					        <option value="30">30</option>
					        <option value="50">50</option>
          				</select>
        			</div> 
		        </div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher centered">
				    <?php $queue_first = TRUE; ?>
				    <?php foreach ($signers as $signe_id => $signer): ?>
				        <div class="signature-wrapper">
				            <div class="data-head relative">
				            	<?php echo ($signer['role_id'] == '7')? $signer['department'] : $signer['role']."&nbsp".$signer['department']; ?>
				                <span class="expander-container"><i class='glyphicon glyphicon-envelope'></i></span>
				                <div class="expander-wrapper">
				                    <span class="expander-remover"><i class='glyphicon glyphicon-remove'></i></span>
				                   	<div class="expander">
				                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-holder">
				                          	<div class="row">
				                            	<form action="/policy/<?php if($signer['role_id'] == "1"){ 
									                                echo "share_url";
									                              }else{
									                                echo "mail";
									                              } ?>/<?php echo $core['id']; ?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
				                              		<?php if (isset($signer['sign'])): ?>
				                              			<?php $i=1; ?>
				                              			<input checked="checked" type="radio" name="mail" value="<?php echo $signer['sign']['mail'] ?>" />
				                              			<label>To: <?php echo $signer['sign']['name'] ?></label>
				                              		<?php else: ?>
				                              			<?php $i=0; foreach ($signer['queue'] as $id => $signe): ?>
				                              				<input <?php echo (++$i == 1)? 'checked="checked"' : '' ?> type="radio" name="mail" value="<?php echo $signe['mail'] ?>" id="u<?php echo $id ?>" />
				                              				<label for="u<?php echo $id ?>">To: <?php echo $signe['name'] ?></label><br />
				                              			<?php endforeach ?>
				                              		<?php endif; ?>
				                              		<?php if (isset($i) && $i == 0): ?>
				                              			<span>No users available</span>
				                              		<?php else: ?>
				                              			<?php if($signer['role_id'] != "1"){ ?>
						                              					<textarea class="form-control" name="message" id="message"></textarea>
						                              				<?php } ?>
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
				                    	<a href="/policy/unsign/<?php echo $signe_id; ?>" class="non-printable btn btn-primary unsign">Cancel</a>
				                    <?php endif ?>
				                </div>
				                <div class="data-content">
				                  	<span class="name-data-content"><?php echo $signer['sign']['name']; ?></span>
				                  	<br />
				                  	<span class="timestamp-data-content"><?php echo $signer['sign']['timestamp']; ?></span>
				                </div>
				            <?php elseif (array_key_exists($user_id, $signer['queue']) && $queue_first): ?>
				                <?php $queue_first = FALSE; ?>
				                <div class="data-content non-printable">
				                	<span class="data-label sign-data-content"></span>
				                	<a href="/policy/sign/<?php echo $signe_id; ?>/reject" class="non-printable btn btn-danger">Reject</a>
				                	<a href="/policy/sign/<?php echo $signe_id; ?>" class="non-printable btn btn-success">sign</a>
				                </div>
				            <?php else: ?>
				                <?php $queue_first = FALSE; ?>
				            <?php endif ?>
				       	</div>
				        <?php if (isset($signer['sign']['reject'])){break;}?>
				   	<?php endforeach ?>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher non-printable">
	                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
	                  	<form action="/policy/comment/<?php echo $core['id']?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
	                    	<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
	                     		<textarea class="form-control" name="comment" id="comment"></textarea>
	                    	</div>
	                    	<input name="core_id" value="<?php echo $core['id']?>" type="hidden" />
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
				<div class="data-content">
	    			<p class="centered">The Signature Policy has been created by <?php echo $core['name'];?> at <?php echo $core['timestamp'];?></p>
	    		</div>				
	    	</div>
		</div>
	</body>
	<script type="text/javascript">
    	$(function(){
      		var pagerOptions = {
	        	container: $(".pager"),
	        	output: '{startRow} - {endRow} / {filteredRows} ({totalRows})',
	        	fixedHeight: true,
	        	removeRows: false,
	        	cssGoto: '.gotoPage'
	      	};
	      	$("table")
	      	.tablesorter({
		        theme: 'bootstrap',
		        headerTemplate : '{content} {icon}',
		        widthFixed: true,
		        widgets: ['filter'],
		        widgetOptions: {
	          		filter_reset : '.reset-filters',
	          		filter_functions: {}
	        	}
	     	})
	      	.tablesorterPager(pagerOptions)
    	});
  	</script>
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
</html>