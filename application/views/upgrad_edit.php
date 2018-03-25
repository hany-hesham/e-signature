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
            </div>
            <div class="container">
              <form action="" method="POST" id="form-submit" enctype="multipart/form-data" class="form-div span12" accept-charset="utf-8">
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <label for="from-hotel" class="col-lg-2 col-md-4 col-sm-2 col-xs-2 control-label" style="margin-top:5px;"> Hotel Name </label>
                    <input readonly="" type="text" class="form-control" value="<?php echo $upgrad['hotel_name']?>" style="width: 250px; height:33px;"/></input>
                  </div>
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <label for="from-hotel" class="col-lg-2 col-md-4 col-sm-2 col-xs-2 control-label" style="margin-top:5px;"> Date </label>
                    <div class='input-group date' id='datetimepicker1' style="width: 250px; height:33px;">
                      <input type='text' class="form-control" name="date" value="<?php echo $upgrad['date']?>"/>
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
                      </tr>
                    </thead>
                    <tbody id="items-container" data-items="1">
                      <?php foreach ($rooms as $room):?>
                        <tr id="item-1">
                          <td class="centered" style="display: none">
                            <input class="form-control" name="rooms[<?php echo $room['id']?>][id]" value="<?php echo $room['id']?>">
                          </td>
                          <td class="centered"> 
                            <input readonly="" type="text" class="form-control" name="rooms[<?php echo $room['id']?>][room]" value="<?php echo $room['room']?>" style="width: 80px; height:33px;"/></input>
                          </td>
                          <td class="centered"> 
                            <input readonly="" type="text" class="form-control" name="rooms[<?php echo $room['id']?>][guest]" value="<?php echo $room['guest']?>" style="width: 200px; height:33px;"/></input>
                          </td>
                          <td class="centered"> 
                            <select class="form-control" name="rooms[<?php echo $room['id']?>][operator_id]" style="width: 200px; height:33px;">
                              <option data-company="0" value="<?php echo $room['operator_id']?>"><?php echo $room['operator_name']?></option>
                              <?php foreach ($operators as $operator): ?>
                                <option value="<?php echo $operator['id'] ?>"<?php echo set_select('operator_id',$operator['id'] ); ?>><?php echo $operator['name'] ?></option>
                              <?php endforeach ?>
                            </select>
                          </td>
                          <td class="centered"> 
                            <input readonly="" type="text" class="form-control" name="rooms[<?php echo $room['id']?>][arrival]" value="<?php echo $room['arrival']?>" style="width: 100px; height:33px;"/></input>
                          </td>
                          <td class="centered"> 
                            <input readonly="" type="text" class="form-control" name="rooms[<?php echo $room['id']?>][departure]" value="<?php echo $room['departure']?>" style="width: 100px; height:33px;"/></input>
                          </td>
                          <td class="centered"> 
                            <select class="form-control" name="rooms[<?php echo $room['id']?>][booked_type_id]" style="width: 200px; height:33px;">
                              <option data-company="0" value="<?php echo $room['booked_type_id']?>"><?php echo $room['booked_type']?></option>
                              <?php foreach ($room_types as $room_type): ?>
                                <option value="<?php echo $room_type['id'] ?>"<?php echo set_select('booked_type_id',$room_type['id'] ); ?>><?php echo $room_type['name'] ?></option>
                              <?php endforeach ?>
                            </select>
                          </td>
                          <td class="centered"> 
                            <select class="form-control" name="rooms[<?php echo $room['id']?>][new_type_id]" style="width: 200px; height:33px;">
                              <option data-company="0" value="<?php echo $room['new_type_id']?>"><?php echo $room['new_type']?></option>
                              <?php foreach ($rooms_types as $rooms_type): ?>
                                <option value="<?php echo $rooms_type['id'] ?>"<?php echo set_select('new_type_id',$rooms_type['id'] ); ?>><?php echo $rooms_type['name'] ?></option>
                              <?php endforeach ?>
                            </select>
                          </td>
                          <td class="centered"> 
                            <select class="form-control" name="rooms[<?php echo $room['id']?>][reason_id]" style="width: 200px; height:33px;">
                                <option data-company="0" value="<?php echo $room['reason_id']?>"><?php echo $room['upgrad_reason']?></option>
                                <?php foreach ($reasons as $reason): ?>
                                  <option value="<?php echo $reason['id'] ?>"<?php echo set_select('reason_id',$reason['id'] ); ?>><?php echo $reason['name'] ?></option>
                                <?php endforeach ?>
                              </select>
                          </td>
                          <td class="centered"> 
                            <input type="text" class="form-control" name="rooms[<?php echo $room['id']?>][occupancy]" value="<?php echo $room['occupancy']?>" style="width: 80px; height:33px;"/>%</input>
                          </td>
                          <td class="centered"> 
                            <input type="text" class="form-control" name="rooms[<?php echo $room['id']?>][arrival_room]" value="<?php echo $room['arrival_room']?>" style="width: 80px; height:33px;"/></input>
                          </td>
                          <td class="centered"> 
                            <input type="text" class="form-control" name="rooms[<?php echo $room['id']?>][departure_room]" value="<?php echo $room['departure_room']?>" style="width: 80px; height:33px;"/></input>
                          </td>
                        </tr>
                      <?php endforeach ?>
                    </tbody>
                  </table>
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <input type="hidden" name="up_id" value="<?php echo $upgrad['id']; ?>" />
                    <label for="from-hotel" class="col-lg-2 col-md-4 col-sm-2 col-xs-2 control-label" style="margin-top:5px;">Report Files</label>
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                      <input id="upload" name="upload" type="file" class="file" multiple="true" data-show-upload="true" data-show-caption="true">
                    </div>
                    <script>
                      $("#upload").fileinput({
                        uploadUrl: "/upgrad/upload/<?php echo $upgrad['id'] ?>",
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
                            {url: "/upgrad/remove/<?php echo $upgrad['id'] ?>/<?php echo $upload['id'] ?>", key: "<?php echo $upload['name']; ?>"},
                          <?php endforeach; ?>
                        ],
                      });
                    </script>
                  </div>
                </div>
                <div class="col-lg-offset-3 col-lg-10 col-md-10 col-md-offset-3">
                  <input name="submit" value="Submit" type="submit" class="btn btn-success" />
                  <a href="<?= base_url(); ?>upgrad/view/<?php echo $upgrad['id']?>" class="btn btn-warning">Cancel</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script type="text/javascript">
      document.rooms = <?php echo json_encode($this->input->post('rooms')); ?>;
    </script>  
    <script type="text/javascript">
      $(function () {
        $('#datetimepicker1').datetimepicker({
          format: 'DD/MM/YYYY'
        });
      });
    </script> 
  </body>
</html>
