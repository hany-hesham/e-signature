<form action="" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8" enctype="multipart/form-data">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 non-printable">
		<div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
			<label for="from" class="date-lbl col-lg-1 col-md-1 col-sm-1 col-xs-1  control-label">Hotel:</label>
			<select class="form-control" name="hotel_id" id="hotel">
				<option value="">Select Hotel</option>
				<?php foreach ($hotels as $hotel): ?>
					<option value="<?php echo $hotel['id'] ?>"<?php echo set_select('hotel', $hotel['id']); ?>><?php echo $hotel['name']; ?></option>
				<?php endforeach ?>
			</select>
		</div>
	</div>
	<div class="noprint form-group non-printable">
	    <div class="col-lg-offset-3 col-lg-3 col-md-3 col-md-offset-3 col-sm-3 col-sm-offset-3 col-xs-3 col-xs-offset-3">
	    	<input style="margin: 30px;" name="submit" value="Submit" type="submit" class="btn btn-success" />
	    </div>
	</div>
</form>