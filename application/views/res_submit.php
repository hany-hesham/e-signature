<!DOCTYPE html>
<html lang="en">
<head>
<?php $this->load->view('header'); ?>
</head>
<body>
<div id="wrapper">
	<?php $this->load->view('menu') ?>
	<div id="page-wrapper">
	<div class="container">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<fieldset>
				<legend>Create New Reservation </b></legend>

<form action="<?php echo base_url();?>reservation/insert_into_db" method="post">

<div class="col-md-12 column ui-sortable">



    <table class="table table-striped table-bordered table-condensed">
      <tbody>
        <tr class="item-row">
          <td>Hotel</td>
            <td><select class="form-control" name="hotel" id="from-hotel">
                <option  value="">--</option>
                <?php foreach ($hotels as $hotel): ?>
                <option  value="<?php echo $hotel['id'] ?>"><?php echo $hotel['name'] ?></option>
                <?php endforeach ?>
                </select>
          </td>
          <td> Requested By</td>
              <td>
                <input type="text" class="form-control" name="recived_by" value="" >
              </td>
         </tr>

        <tr class="item-row">
          <td>Guest Name</td>
              <td>
                <input type="text" class="form-control" name="name" value="" >
              </td>
              <td>Discount</td>
              <td>
                <input type="number" step="any" placeholder="%" class="form-control" name="discount" value="" >
              </td>
          </tr>



          <tr class="item-row">
              <td>Board Type</td>
              <td>
                  <select class="form-control" name="board_type_id" id="from-hotel">
                      <option  value="">--</option>
                      <?php foreach ($boards as $board): ?>
                      <option value="<?php echo $board['id'] ?>"><?php echo $board['board_type'] ?></option>
                      <?php endforeach ?>
                  </select>
              </td>
              <td>Rate After Discount</td>
              <td>
              <div class="col-lg-9 col-md-6 col-sm-10 col-xs-10">
                  <input type="number" step="any" class="form-control" name="rate" value="" >
              </div>
              <div class="col-lg-3 col-md-6 col-sm-10 col-xs-10"> 
                  <select class="form-control" name="currency" id="from-hotel">
                      <option  value="">--</option>
                      <option value="EGP">EGP</option>
                      <option value="USD">USD</option>
                      <option value="Euro">Euro</option>
                  </select>
               </div>
              </td>
        </tr>
        <tr class="item-row">
           <td>Arrival</td>
              <td><input type="text" class="form-control datetime" name="arrival" id="issue-date" data-date-format="YYYY-MM-DD" value="" ></td>
            <td>Departure</td>
              <td><input type="text" class="form-control datetime" name="departure" id="issue-date" data-date-format="YYYY-MM-DD" value="" ></td>
        </tr>
      </tbody>
    </table>


    <table class="table table-striped table-bordered table-condensed">
      <tbody>
        <tr class="item-row">
          <td>Adults</td>
          <td>
              <input type="number" class="form-control" name="adult" value="" >
          </td>
          <td> Children</td>
              <td>
                <input type="number" class="form-control" name="child" value="" >
              </td>
         </tr>

        <tr class="item-row">
          <td>N. of Rooms</td>
              <td>
                <input type="number" class="form-control" name="rooms" value="" >
              </td>
          <td>Room Type</td>
              <td>
                <input type="text" class="form-control" name="room_type" >
              </td>
          </tr>

          <tr class="item-row">
              <td>Agent/Company</td>
              <td>
                 <input type="text" class="form-control" name="company" >
              </td>
              <td>Reservation Sources</td>
              <td>
                  <select class="form-control" name="res_type" id="from-hotel">
                      <option  value="">--</option>
                      <?php foreach ($res_type as $type): ?>
                      <option value="<?php echo $type['id'] ?>"><?php echo $type['name'] ?></option>
                      <?php endforeach ?>
                  </select>
              </td>
        </tr>
        <tr class="item-row">
           <td>Reservation Type</td>
              <td>
                 <select class="form-control" name="type" id="from-hotel">
                      <option  value="">--</option>
                      <?php foreach ($types as $type): ?>
                      <option value="<?php echo $type['id'] ?>"><?php echo $type['name'] ?></option>
                      <?php endforeach ?>
                </select>
              </td>
        </tr>
      </tbody>
    </table>

	<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 border"></div>

    <h4>Remarks</h4>
		<textarea class="form-control" name="remarks" placeholder="Remarks"></textarea>
    <br /><br />

	<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 border"></div>

				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<input type="hidden" name="assumed_id" value="<?php echo $num['0']; ?>" />
					<label class="col-lg-3 col-md-4 col-sm-5 col-xs-5 control-label">Files</label>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<input id="files" name="files" type="file" class="file" multiple="true" data-show-upload="false" data-show-caption="true">
					</div>
					<script>
					$("#files").fileinput({
					    uploadUrl: "/reservation/add_files/<?php  echo  $num['0'] ?>", // server upload action
					    uploadAsync: true,
					    minFileCount: 1,
					    maxFileCount: 10,
					    overwriteInitial: false,
					    initialPreview: [

					    ],
					});
					</script>
				</div>

<div class="col-lg-offset-3 col-lg-10 col-md-10 col-md-offset-3">


				    	<input value="<?php echo date("Y-m-d");?>" type="hidden" name="date" class="btn btn-success">
				    	<input value="<?php echo  $this->session->userdata('user_id');?>" type="hidden" name="user_id" class="btn btn-success">
				    	<input value="Submit" type="submit" class="btn btn-success">
				    	<a href="<?php echo base_url();?>reservation" class="btn btn-warning">Cancel</a>
				    </div></form>

			</fieldset>
		</div>
	</div>
	</div>
	<div class="holder">Please Wait...</div>
</div>

	<script type="text/javascript">
					$(function () {
							$('.datetime').datetimepicker({
								autoclose: true,
								pickTime: false,

							});

							$("#issue-date").on("dp.change",function (e) {
					           $('#delivery-date').data("DateTimePicker").setMinDate(e.date);
					        });
					        $("#delivery-date").on("dp.change",function (e) {
					           $('#issue-date').data("DateTimePicker").setMaxDate(e.date);
					        });

					});
					</script>
</body>
</html>
