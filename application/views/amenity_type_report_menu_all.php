<form action="" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8" enctype="multipart/form-data">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 non-printable">
		<div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
			<label for="from" class="date-lbl col-lg-1 col-md-1 col-sm-1 col-xs-1  control-label">Type:</label>
			<select class="form-control" name="type">
	            <option value="1">Retoure</option> ‎
	            <option value="2">Cancelled</option> 
	            <option value="3">No Show</option>
	            <option value="4">Delivered</option>
            </select>
		</div>
	</div>
	<br>
	<br>
	<br>
	<br>
	<div class="dates form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 non-printable">
		<div class="day-picker form-group col-lg-10 col-md-10 col-sm-10 col-xs-10 non-printable">
			<label for="from" class="date-lbl col-lg-1 col-md-1 col-sm-1 col-xs-1 control-label non-printable">From:</label>
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
				<input type="text" class="form-control date non-printable" name="from" id="from" data-date-format="YYYY-MM-DD" value="<?php echo set_value('from'); ?>" />
			</div>
			<label for="to" class="date-lbl col-xs-offset-0 col-lg-1 col-md-1 col-sm-1 col-xs-1 control-label non-printable">To:</label>
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 non-printable">
				<input type="text" class="form-control date non-printable" name="to" id="to" data-date-format="YYYY-MM-DD" value="<?php echo set_value('to'); ?>" />
			</div>
		</div>
		<script type="text/javascript">
			$(function () {
				$('.date').datepicker({
					autoclose: true,
					format: "yyyy-mm-dd",
					viewMode: "days", 
					minViewMode: "days"
				});
			});
		</script>
	</div>	
	<div class="form-group non-printable">
	    <div class="col-lg-offset-3 col-lg-3 col-md-3 col-md-offset-3 col-sm-3 col-sm-offset-3 col-xs-3 col-xs-offset-3 non-printable">
	    	<input style="margin: 30px;" name="submit" value="Submit" type="submit" class="btn btn-success non-printable" />
	    </div>
	</div>
</form>