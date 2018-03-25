<form action="" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8" enctype="multipart/form-data">

	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 non-printable">

			<div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
					<select class="form-control" name="state">
                      <option value=""></option>
                      <option value="Settlement proposed to SUNRISE">Settlement proposed to SUNRISE</option>
                      <option value="Settlement proposed to TO">Settlement proposed to TO</option>
                      <option value="Signed SAF not sent due to general update has been requested">Signed SAF not sent due to general update has been requested</option>
                      <option value="Signed SAF not sent due toTC have admitted liability">Signed SAF not sent due toTC have admitted liability</option>
                      <option value="Signed SAF not sent due to liability due date has passed">Signed SAF not sent due to liability due date has passed</option>
                      <option value="Settlement proposed to TO and accepted, the claim is closed">Settlement proposed to TO and accepted, the claim is closed </option>
                      <option value="Signed SAF not sent due toTC denial of liability">Signed SAF not sent due toTC denial of liability</option>
                      <option value="Signed SAF not sent due to defence issued by CCRM after claim revision">Signed SAF not sent due to defence issued by CCRM after claim revision</option>
                      <option value="Settlement proposed to SUNRISE but not required due to defence issued by CCRM after claim revision">Settlement proposed to SUNRISE but not required due to defence issued by CCRM after claim revision</option>
                      <option value="Signed SAF not sent to TO as Liability date passed">Signed SAF not sent to TO as Liability date passed</option>
                      <option value="Signed SAF not sent to TO as Update from TC is that claim is at settlement negotiation stage">Signed SAF not sent to TO as Update from TC is that claim is at settlement negotiation stage</option>
                      <option value="Signed SAF not sent to TO as update from TO has been requested">Signed SAF not sent to TO as update from TO has been requested</option>
                      <option value="SAF unsigned and Liability date passed">SAF unsigned and Liability date passed</option>
                      <option value="SAF unsigned and Update from TC is that claim is at settlement negotiation stage">SAF unsigned and Update from TC is that claim is at settlement negotiation stage</option>
                      <option value="Case Closed and Settlement Proposal accepted by TO">Case Closed and Settlement Proposal accepted by TO</option>
                      <option value="TO have denied liability">TO have denied liability</option>
                      <option value="Signed SAF not sent to TO as CCRM reviewed further and defended">Signed SAF not sent to TO as CCRM reviewed further and defended</option>
                    </select>
			</div>
	</div>

	<BR/><BR/>
	<div class="dates form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">

		<div class="day-picker form-group col-lg-10 col-md-10 col-sm-10 col-xs-10">
			<label for="from" class="date-lbl col-lg-1 col-md-1 col-sm-1 col-xs-1  control-label">From:</label>
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
				<input type="text" class="form-control date" name="from" id="from" data-date-format="YYYY-MM-DD" value="<?php echo set_value('from'); ?>" />
			</div>

			<label for="to" class="date-lbl col-xs-offset-0 col-lg-1 col-md-1 col-sm-1 col-xs-1  control-label">To:</label>
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
				<input type="text" class="form-control date" name="to" id="to" data-date-format="YYYY-MM-DD" value="<?php echo set_value('to'); ?>" />
			</div>
		</div>
		<script type="text/javascript">
		$(function () {
				$('.date').datepicker({
					autoclose: true,
					format: "yyyy-mm",
					viewMode: "months", 
					minViewMode: "months"

				});
				
		});
		</script>
	</div>	
	
	<div class="noprint form-group">
	    <div class="col-lg-offset-3 col-lg-3 col-md-3 col-md-offset-3 col-sm-3 col-sm-offset-3 col-xs-3 col-xs-offset-3">
	    	<input style="margin: 30px;" name="submit" value="Submit" type="submit" class="btn btn-success" />
	    </div>


	</div>

</form>