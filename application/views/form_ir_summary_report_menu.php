<form action="" method="POST" id="form-submit" class="form-div span12 non-printable" accept-charset="utf-8" enctype="multipart/form-data"><?php if($all != 1) :?>
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
			<label for="from" class="date-lbl col-lg-1 col-md-1 col-sm-1 col-xs-1  control-label">Hotel:</label>
			<select class="form-control chooosen" name="hotel_id" id="hotel" data-placeholder="Select An option Or Blanck for All ...">
              	<option></option>
				<?php foreach ($hotels as $hotel): ?>
					<option value="<?php echo $hotel['id'] ?>"<?php echo set_select('hotel', $hotel['id']); ?>><?php echo $hotel['name']; ?></option>
				<?php endforeach ?>
			</select>
		</div>
	</div>
	<!-- <br>
	<br>
	<br>
	<br>
	<br>
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
			<label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width: 200px;"> Tour Operator: </label>
			<select class="form-control chooosen" name="operator_id" id="hotel" data-placeholder="Select An option Or Blanck for All ...">
              	<option></option>
				<?php foreach ($operators as $operator): ?>
					<option value="<?php echo $operator['id'] ?>"<?php echo set_select('operator_id', $operator['id']); ?>><?php echo $operator['name']; ?></option>
				<?php endforeach ?>
			</select>
		</div>
	</div>
	<br> -->
	<br>
	<br>
	<br>
	<br>
	<?php endif; ?>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
			<label for="from" class="date-lbl col-lg-4 col-md-4 col-sm-4 col-xs-4  control-label">Report Section:</label>
			<select class="form-control chooosen" name="type">
              	<option></option>
	            <option value="1">In House Incident Report-UK</option> ‎
	            <option value="2">In House - other nationalities Incident Report</option> 
            </select>
		</div>
	</div>
	<br>
    <br>
	<br>
	<br>
	<br>
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
			<label for="from" class="date-lbl col-lg-12 col-md-12 col-sm-12 col-xs-12  control-label">Is this an accident, illness, assault, loss of valuables, quality issues or others or multiple issues?</label>
			<select class="form-control chooosen" name="answer">
              	<option></option>
                <option value="Accident">Accident</option>
                <option value="Illness">Illness</option>
                <option value="Assault">Assault</option>
                <option value="Loss of Valuables">Loss of Valuables</option>
                <option value="Quality Issues">Quality Issues</option>
                <option value="Other">Other</option>
                <option value="Multiple Issues">Multiple Issues</option>
                <option value="">All</option>
            </select>
		</div>
	</div>
	<br>
	<br>
	<br>
	<br> 
	<br>
	<br>
	<div class="dates form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="day-picker form-group col-lg-10 col-md-10 col-sm-10 col-xs-10">
			<label for="to" class="date-lbl col-xs-offset-0 col-lg-1 col-md-1 col-sm-1 col-xs-1  control-label">From:</label>
            <div class='input-group date' id='datetimepicker1' style=" width: 30%; margin:5px;">
              <input type="text" name="from" class="form-control"/> 
              <span class="input-group-addon"><span class="glyphicon glyphicon-calender"></span></span>
            </div>
			<label for="to" class="date-lbl col-xs-offset-0 col-lg-1 col-md-1 col-sm-1 col-xs-1  control-label">To:</label>
			<div class='input-group date' id='datetimepicker2' style=" width: 30%; margin:5px;">
              <input type="text" name="to" class="form-control"/> 
              <span class="input-group-addon"><span class="glyphicon glyphicon-calender"></span></span>
            </div>
		</div>
		<script type="text/javascript">
	      $(function(){
	        $('#datetimepicker1').datetimepicker({
	          viewMode:'days',
	          format:'YYYY-MM-DD'
	        });
	      });
	    </script>
	    <script type="text/javascript">
	      $(function(){
	        $('#datetimepicker2').datetimepicker({
	          viewMode:'days',
	          format:'YYYY-MM-DD'
	        });
	      });
	    </script>
	</div>	
	<div class="noprint form-group non-printable">
	    <div class="col-lg-offset-3 col-lg-3 col-md-3 col-md-offset-3 col-sm-3 col-sm-offset-3 col-xs-3 col-xs-offset-3">
	    	<input style="margin: 30px;" name="submit" value="Submit" type="submit" class="btn btn-success" />
	    </div>
	</div>
</form>