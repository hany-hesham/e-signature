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
          <div class="" style="margin-left: -200px;">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px;">
              <div class="page-header">
                <h1 class="centered">Free Room Upgrading Form</h1>
              </div>
              <?php if(validation_errors() != false): ?>
                <div class="alert alert-danger">
                  <?php echo validation_errors(); ?>
                </div>
              <?php endif ?>
            </div>
            <div class="container">
              <form action="" method="POST" id="form-submit" enctype="multipart/form-data" class="form-div span12" accept-charset="utf-8">
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <label for="from-hotel" class="col-lg-2 col-md-4 col-sm-2 col-xs-2 control-label" style="margin-top:5px;"> Hotel Name </label>
                    <select class="form-control" name="hotel_id" id="from-hotel " style="width: 250px; height:33px;">
                      <option data-company="0" value="">Select Hotel..</option>
                      <?php foreach ($hotels as $hotel): ?>
                        <option value="<?php echo $hotel['id'] ?>"<?php echo set_select('hotel_id',$hotel['id'] ); ?>><?php echo $hotel['name'] ?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <label for="from-hotel" class="col-lg-2 col-md-4 col-sm-2 col-xs-2 control-label" style="margin-top:5px;"> Date </label>
                    <div class='input-group date' id='datetimepicker1' style="width: 250px; height:33px;">
                      <input type='text' class="form-control" name="date"/>
                      <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                  </div>
                  <table class="table table-striped table-bordered table-condensed">
                    <thead>
                      <tr>
                        <th colspan="1" style=" text-align: center;">Room Number</th>
                        <th colspan="1" style=" text-align: center;">Guest Name</th>
                        <th colspan="1" style=" text-align: center;">Travel Agent</th>
                        <th colspan="1" style=" text-align: center;">Arrival Date</th>
                        <th colspan="1" style=" text-align: center;">Departure Date</th>
                        <th colspan="1" style=" text-align: center;">Booked Room Type</th>
                        <th colspan="1" style=" text-align: center;">New Room type</th>
                        <th colspan="1" style=" text-align: center;">Reason</th>
                        <th colspan="1" style=" text-align: center;">Occupancy %</th>
                        <th colspan="1" style=" text-align: center;">Arrival Rooms</th>
                        <th colspan="1" style=" text-align: center;">Departure Rooms</th>
                        <th colspan="1" style=" text-align: center;">Action</th>
                      </tr>
                    </thead>
                    <tbody id="items-container" data-items="1">
                      <tr id="item-1">
                        <td class="centered"> 
                          <input type="text" class="form-control" name="rooms[1][room]"  id="item-1-room" style="width: 80px; height:33px;"/></input>
                        </td>
                        <td class="centered"> 
                          <input type="text" class="form-control" name="rooms[1][guest]"  id="item-1-guest" style="width: 200px; height:33px;"/></input>
                        </td>
                        <td class="centered"> 
                          <select class="form-control" name="rooms[1][operator_id]" id="item-1-operator_id" style="width: 200px; height:33px;">
                            <option data-company="0" value="">Select Operator..</option>
                            <?php foreach ($operators as $operator): ?>
                              <option value="<?php echo $operator['id'] ?>"<?php echo set_select('operator_id',$operator['id'] ); ?>><?php echo $operator['name'] ?></option>
                            <?php endforeach ?>
                          </select>
                        </td>
                        <td class="centered"> 
                          <input type="date" class="form-control" name="rooms[1][arrival]"  id="item-1-arrival" style="width: 200px; height:33px;"/></input>
                        </td>
                        <td class="centered"> 
                          <input type="date" class="form-control" name="rooms[1][departure]"  id="item-1-departure" style="width: 200px; height:33px;"/></input>
                        </td>
                        <td class="centered"> 
                          <select class="form-control" name="rooms[1][booked_type_id]" id="item-1-booked_type_id" style="width: 200px; height:33px;">
                            <option data-company="0" value="">Select Room Type..</option>
                            <?php foreach ($room_types as $room_type): ?>
                              <option value="<?php echo $room_type['id'] ?>"<?php echo set_select('booked_type_id',$room_type['id'] ); ?>><?php echo $room_type['name'] ?></option>
                            <?php endforeach ?>
                          </select>
                        </td>
                        <td class="centered"> 
                          <select class="form-control" name="rooms[1][new_type_id]" id="item-1-new_type_id" style="width: 200px; height:33px;">
                            <option data-company="0" value="">Select Room Type..</option>
                            <?php foreach ($rooms_types as $rooms_type): ?>
                              <option value="<?php echo $rooms_type['id'] ?>"<?php echo set_select('new_type_id',$rooms_type['id'] ); ?>><?php echo $rooms_type['name'] ?></option>
                            <?php endforeach ?>
                          </select>
                        </td>
                        <td class="centered"> 
                          <select class="form-control" name="rooms[1][reason_id]" id="item-1-reason_id" style="width: 200px; height:33px;">
                            <option data-company="0" value="">Select reason..</option>
                            <?php foreach ($reasons as $reason): ?>
                              <option value="<?php echo $reason['id'] ?>"<?php echo set_select('reason_id',$reason['id'] ); ?>><?php echo $reason['name'] ?></option>
                            <?php endforeach ?>
                          </select>
                        </td>
                        <td class="centered"> 
                          <input type="text" class="form-control" name="rooms[1][occupancy]" id="item-1-occupancy" style="width: 80px; height:33px;"/>%</input>
                        </td>
                        <td class="centered"> 
                          <input type="text" class="form-control" name="rooms[1][arrival_room]" id="item-1-arrival_room"  style="width: 80px; height:33px;"/></input>
                        </td>
                        <td class="centered"> 
                          <input type="text" class="form-control" name="rooms[1][departure_room]" id="item-1-departure_room" style="width: 80px; height:33px;"/></input>
                        </td>
                        <td class="centered">
                          <span data-item-id="1" class="form-actions btn btn-danger remove-item" style="width: 100px;">Remove</span>
                        </td>
                      </tr>
                    </tbody>
                    <tfoot>
                      <tr>
                        <td colspan="11"></td>
                        <td class="centered">
                          <span class="form-actions btn btn-primary" id="add-item" style="width: 100px;">Add Room</span>
                        </td>
                      </tr>
                    </tfoot>
                  </table>
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <input type="hidden" name="assumed_id" value="<?php echo $assumed_id; ?>" />
                    <label for="from-hotel" class="col-lg-2 col-md-4 col-sm-2 col-xs-2 control-label" style="margin-top:5px;">Report Files</label>
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                      <input id="upload" name="upload" type="file" class="file" multiple="true" data-show-upload="true" data-show-caption="true">
                    </div>
                    <script>
                      $("#upload").fileinput({
                        uploadUrl: "/upgrad/upload/<?php echo $assumed_id ?>",
                        uploadAsync: true,
                        minFileCount: 1,
                        maxFileCount: 100,
                        overwriteInitial: true,
                        initialPreview: [
                          <?php foreach($uploads as $upload): ?>
                            "<div class='file-preview-text'>" +
                            "<h2><i class='glyphicon glyphicon-file'></i></h2>" +
                            "<a href='/assets/uploads/files/<?php echo $upload['name'] ?>'><?php echo $upload['name'] ?></a>" + "</div>",
                          <?php endforeach ?>
                        ],
                        initialPreviewConfig: [
                          <?php foreach($uploads as $upload): ?>
                            {url: "/upgrad/remove/<?php echo $assumed_id ?>/<?php echo $upload['id'] ?>", key: "<?php echo $upload['name']; ?>"},
                          <?php endforeach; ?>
                        ],
                      });
                    </script>
                  </div>
                </div>
                <div class="col-lg-offset-3 col-lg-10 col-md-10 col-md-offset-3">
                  <input name="submit" value="Submit" type="submit" class="btn btn-success" />
                  <a href="<?= base_url(); ?>upgrad/add" class="btn btn-warning">Cancel</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script type="text/javascript">
      $(function () {
        $('#datetimepicker1').datetimepicker({
          format: 'DD/MM/YYYY'
        });
      });
    </script>
    <script type="text/javascript">
      document.rooms = <?php echo json_encode($this->input->post('rooms')); ?>;
    </script>
     <script id="item-template" type="text/x-handlebars-template">
      <tr id="item-{{id}}">
        <td class="centered">
          <input type="text" class="form-control" name="rooms[{{id}}][room]" id="item-{{id}}-room" style="width: 80px; height:33px;"  value="{{room}}"/>  
        </td>
        <td class="centered"> 
          <input type="text" class="form-control" name="rooms[{{id}}][guest]" id="item-{{id}}-guest" style="width: 200px; height:33px;"  value="{{guest}}"/> 
        </td>
        <td class="centered">
          <select class="form-control" name="rooms[{{id}}][operator_id]" id="item-{{id}}-operator_id" style="width: 200px; height:33px;">
            <option data-company="0" value="">Select Operator..</option>
            <?php foreach ($operators as $operator): ?>
              <option value="<?php echo $operator['id'] ?>"<?php echo set_select('operator_id',$operator['id'] ); ?>><?php echo $operator['name'] ?></option>
            <?php endforeach ?>
          </select> 
        </td>
        <td class="centered">
          <input type="date" class="form-control" name="rooms[{{id}}][arrival]"  id="item-{{id}}-arrival" style="width: 200px; height:33px;" value="{{arrival}}"/></input>
        </td>
        <td class="centered">
          <input type="date" class="form-control" name="rooms[{{id}}][departure]"  id="item-{{id}}-departure" style="width: 200px; height:33px;" value="{{departure}}"/></input>
        </td>
        <td class="centered">
          <select class="form-control" name="rooms[{{id}}][booked_type_id]" id="item-{{id}}-booked_type_id" style="width: 200px; height:33px;">
            <option data-company="0" value="">Select Room Type..</option>
            <?php foreach ($rooms_types as $rooms_type): ?>
              <option value="<?php echo $rooms_type['id'] ?>"<?php echo set_select('booked_type_id',$rooms_type['id'] ); ?>><?php echo $rooms_type['name'] ?></option>
            <?php endforeach ?>
          </select>
        </td>
        <td class="centered">
          <select class="form-control" name="rooms[{{id}}][new_type_id]" id="item-{{id}}-new_type_id" style="width: 200px; height:33px;">
            <option data-company="0" value="">Select Room Type..</option>
            <?php foreach ($rooms_types as $rooms_type): ?>
              <option value="<?php echo $rooms_type['id'] ?>"<?php echo set_select('new_type_id',$rooms_type['id'] ); ?>><?php echo $rooms_type['name'] ?></option>
            <?php endforeach ?>
          </select>
        </td>
        <td class="centered">
          <select class="form-control" name="rooms[{{id}}][reason_id]" id="item-{{id}}-reason_id" style="width: 200px; height:33px;">
            <option data-company="0" value="">Select reason..</option>
            <?php foreach ($reasons as $reason): ?>
              <option value="<?php echo $reason['id'] ?>"<?php echo set_select('reason_id',$reason['id'] ); ?>><?php echo $reason['name'] ?></option>
            <?php endforeach ?>
          </select>
        </td>
        <td class="centered">
          <input type="text" class="form-control" name="rooms[{{id}}][occupancy]" id="item-{{id}}-occupancy" style="width: 80px; height:33px;"  value="{{occupancy}}"/>  
        </td>
        <td class="centered">
          <input type="text" class="form-control" name="rooms[{{id}}][arrival_room]" id="item-{{id}}-arrival_room" style="width: 80px; height:33px;"  value="{{arrival_room}}"/>  
        </td>
        <td class="centered">
          <input type="text" class="form-control" name="rooms[{{id}}][departure_room]" id="item-{{id}}-departure_room" style="width: 80px; height:33px;"  value="{{departure_room}}"/>  
        </td>
        <td class="centered">
          <span data-item-id="{{id}}" class="form-actions btn btn-danger remove-item" style="width: 100px;">Remove</span>
        </td>
      </tr>
    </script>   
  </body>
</html>
