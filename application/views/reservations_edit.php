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
          <div class="a4page" style="margin-bottom: 10px;">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px;">
              <div class="page-header">
                <h1 class="centered">Edit Reservation Form No. #<?php echo $reservation['id']; ?></h1>
              </div>
              <?php if(validation_errors() != false): ?>
                <div class="alert alert-danger">
                  <?php echo validation_errors(); ?>
                </div>
              <?php endif ?>         
            </div>
            <div class="container">
              <form action="" method="POST" id="form-submit" enctype="multipart/form-data" class="form-div span12" accept-charset="utf-8">
                <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                  <br>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;"> Hotel Name </label>
                  <input type="text" class="form-control" readonly="readonly" value="<?php echo $reservation['hotel_name'] ?>" style="width: 250px; height:33px;"/></input>
                  <select class="form-control" data-placeholder="Hotel ..." name="hotel_id" id="from-hotel " style="width: 250px; height:33px; display: none;">
                    <option data-company="0" value="<?php echo $reservation['hotel_id'] ?>"><?php echo $reservation['hotel_name'] ?></option>
                    <?php foreach ($hotels as $hotel): ?>
                      <option value="<?php echo $hotel['id'] ?>"<?php echo set_select('hotel_id',$hotel['id'] ); ?>><?php echo $hotel['name'] ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                  <br>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;">Recived By</label>
                  <input type="text" class="form-control" name="recived_by" placeholder="Recived By ..." value="<?php echo $reservation['recived_by'] ?>" style="width: 250px; height:33px;"/></input>
                </div>
                <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                  <br>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;">Guest Name</label>
                  <input type="text" class="form-control" name="name" placeholder="Guest Name ..." value="<?php echo $reservation['name'] ?>" style="width: 250px; height:33px;"/></input>
                </div>
                <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                  <br>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;">Discount</label>
                  <input type="number" class="form-control" name="discount" placeholder="%" value="<?php echo $reservation['discount'] ?>" style="width: 250px; height:33px;"/></input>
                </div>
                <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                  <br>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;">Rate After Discount</label>
                  <input type="number" class="form-control" name="rate" placeholder="Rate ..." value="<?php echo $reservation['rate'] ?>" style="width: 250px; height:33px;"/></input>
                </div>
                <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                  <br>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;">Currency</label>
                  <select class="form-control chooosen" name="currency" data-placeholder="Currency ..." style="width: 250px; height:33px;">
                    <option value="<?php echo $reservation['currency'] ?>"><?php echo $reservation['currency'] ?></option>
                    <option value="£">£</option> ‎
                    <option value="$">$</option> 
                    <option value="EURO">EURO</option>
                    <option value="EGP">EGP</option>
                  </select>
                </div>
                <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                  <br>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;"> Board Type </label>
                  <select class="form-control chooosen" data-placeholder="Board Type ..." name="board_type_id" id="from-hotel " style="width: 250px; height:33px;">
                    <option data-company="0" value="<?php echo $reservation['board_type_id'] ?>"><?php echo $reservation['board_type'] ?></option>
                    <?php foreach ($boards as $board): ?>
                      <option value="<?php echo $board['id'] ?>"<?php echo set_select('board_type_id',$board['id'] ); ?>><?php echo $board['board_type'] ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                  <br>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;">Arrival</label>
                  <div class='input-group date' id='datetimepicker1' style="width: 250px; height:33px;">
                    <input type='text' class="form-control" name="arrival" value="<?php echo $reservation['arrival'] ?>"/>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
                </div>
                <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                  <br>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;">Departure</label>
                  <div class='input-group date' id='datetimepicker2' style="width: 250px; height:33px;">
                    <input type='text' class="form-control" name="departure" value="<?php echo $reservation['departure'] ?>"/>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
                </div>
                <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                  <br>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;">Adults</label>
                  <input type="number" class="form-control" name="adult" placeholder="Adults ..." style="width: 250px; height:33px;" value="<?php echo $reservation['adult'] ?>"/></input>
                </div>
                <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                  <br>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;">Children</label>
                  <input type="number" class="form-control" name="child" placeholder="Children ..." style="width: 250px; height:33px;" value="<?php echo $reservation['child'] ?>"/></input>
                </div>
                <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                  <br>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;">No. of Rooms</label>
                  <input type="number" class="form-control" name="no_room" placeholder="Rooms ..." style="width: 250px; height:33px;" value="<?php echo $reservation['no_room'] ?>"/></input>
                </div>
                <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                  <br>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;"> Room Type </label>
                  <input type="text" class="form-control" name="room_type" placeholder="Room Type ..." style="width: 250px; height:33px;" value="<?php echo $reservation['room_type'] ?>"/></input>
                </div>
                <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                  <br>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;"> Agent/Company </label>
                  <input type="text" class="form-control" name="agent" placeholder="Agent/Company ..." style="width: 250px; height:33px;" value="<?php echo $reservation['agent'] ?>"/></input>
                </div>
                <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                  <br>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;"> Reservation Sources </label>
                  <input type="text" class="form-control" readonly="readonly" value="<?php echo $reservation['res_source'] ?>" style="width: 250px; height:33px;"/></input>
                  <select class="form-control" data-placeholder="Reservation Sources ..." name="res_source_id" id="from-hotel " style="width: 250px; height:33px; display: none;">
                    <option data-company="0" value="<?php echo $reservation['res_source_id'] ?>"><?php echo $reservation['res_source'] ?></option>
                    <?php foreach ($res_sources as $source): ?>
                      <option value="<?php echo $source['id'] ?>"<?php echo set_select('res_source_id',$source['id'] ); ?>><?php echo $source['name'] ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                  <br>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;"> Reservation Type </label>
                  <select class="form-control chooosen" data-placeholder="Reservation Type ..." name="res_type_id" id="from-hotel " style="width: 250px; height:33px;">
                    <option data-company="0" value="<?php echo $reservation['res_type_id'] ?>"><?php echo $reservation['res_type'] ?></option>
                    <?php foreach ($res_types as $type): ?>
                      <option value="<?php echo $type['id'] ?>"<?php echo set_select('res_type_id',$type['id'] ); ?>><?php echo $type['name'] ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                  <br>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;">Remarks</label>
                  <textarea class="form-control" name="remarks" style="width: 500px;" rows="3"><?php echo $reservation['remarks'] ?></textarea>
                </div>
                <div class="form-group col-lg-8 col-md-8 col-sm-8 col-xs-8">
                  <br>
                  <input type="hidden" name="res_id" value="<?php echo $reservation['id'] ?>" />
                  <label for="offers" class="col-lg-3 col-md-4 col-sm-5 col-xs-5 control-label">Report Files</label>
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <input id="offers" name="upload" type="file" class="file" multiple="true" data-show-upload="false" data-show-caption="true">
                  </div>
                  <script>
                    $("#offers").fileinput({
                      uploadUrl: "/reservations/upload/<?php echo $reservation['id'] ?>",
                      uploadAsync: true,
                      minFileCount: 1,
                      maxFileCount: 100,
                      overwriteInitial: false,
                      initialPreview: [
                        <?php foreach($uploads as $upload): ?>
                          "<div class='file-preview-text'>" +
                          "<h2><i class='glyphicon glyphicon-file'></i></h2>" +
                          "<a href='/assets/uploads/files/<?php echo $upload['name'] ?>'><?php echo $upload['name'] ?></a>" + "</div>",
                        <?php endforeach ?>
                      ],
                      initialPreviewConfig: [
                        <?php foreach($uploads as $upload): ?>
                          {url: "/reservations/remove/<?php echo $reservation['id'] ?>/<?php echo $upload['id'] ?>", key: "<?php echo $upload['name']; ?>"},
                        <?php endforeach; ?>
                      ],
                    });
                  </script>
                </div>
                <div style="    margin-top: 90px;" class="form-group">
                  <div class="col-lg-offset-3 col-lg-10 col-md-10 col-md-offset-3">
                    <br>
                    <br>
                    <br>
                    <input name="submit" value="Submit" type="submit" class="btn btn-success" />
                    <a href="<?= base_url(); ?>reservations/view/<?php echo $reservation['id'] ?>" class="btn btn-warning">Cancel</a>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
  <script type="text/javascript">
    $(function () {
      $('#datetimepicker1').datetimepicker({
        format: 'YYYY-MM-DD'
      });
    });
  </script>  
  <script type="text/javascript">
    $(function () {
      $('#datetimepicker2').datetimepicker({
        format: 'YYYY-MM-DD'
      });
    });
  </script>  
</html>
