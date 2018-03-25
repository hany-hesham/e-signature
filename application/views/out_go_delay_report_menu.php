<form action="" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8" enctype="multipart/form-data">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 non-printable">
		<?php if (isset($type) && $type): ?>
			<div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
				<select class="form-control chooosen" name="hotel_id" id="hotel" data-placeholder="Hotels ...">
					<option value="">Select Hotel</option>
					<?php foreach ($hotels as $hotel): ?>
						<option value="<?php echo $hotel['id'] ?>"<?php echo set_select('hotel', $hotel['id']); ?>><?php echo $hotel['name']; ?></option>
					<?php endforeach ?>
				</select>
			</div>
		<?php endif; ?>
		<br>
		<br>
	</div>	
	<div class="noprint form-group">
	    <div class="col-lg-offset-3 col-lg-3 col-md-3 col-md-offset-3 col-sm-3 col-sm-offset-3 col-xs-3 col-xs-offset-3">
	    	<input style="margin: 30px;" name="submit" value="Submit" type="submit" class="btn btn-success" />
	    </div>
	</div>
</form>