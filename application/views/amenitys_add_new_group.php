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
          <div class="">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px;">
              <div class="page-header">
                <h1 class="centered">Guest Amenity Request</h1>
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
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin-top:5px;"> Hotel Name </label>
                  <input readonly="" type="text" name="hotel" class="form-control" value="<?php echo $amenity['hotel_name']; ?>" style="width: 250px;"/> 
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin-top:5px;"> Date and Time of Delivery </label>
                  <div class='input-group date' id='datetimepicker1' style="width: 250px;">
                    <input type='text' class="form-control" name="date_time"/>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
                </div>
                <?php foreach ($items as $item):?>
                  <input style="display: none;" type="text" name="rooms[<?php echo $item['id']?>][id]" value="<?php echo $item['id']?>">
                  <input style="display: none;" type="text" name="rooms[<?php echo $item['id']?>][room]" value="<?php echo $item['room']; ?>"/>
                <?php endforeach ?>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin-top:5px;"> Long Stay </label>
                  <input type="checkbox" name="longs" value="1"><p style="font-size: 10px;"><span style="font-weight: bold;">Note:</span> More than 15 days</p>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin-top:5px;"> Group Name </label>
                  <input type="text" name="guest" class="form-control" value="" style="width: 250px;"/> 
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin-top:5px;"> Group Nationality </label>
                  <input type="text" name="nationality" class="form-control" value="" style="width: 250px;"/> 
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin-top:5px;"> Arrival Date </label>
                  <div class='input-group date' id='datetimepicker2' style="width: 250px;">
                    <input type='text' class="form-control" name="arrival"/>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin-top:5px;"> Departure Date </label>
                  <div class='input-group date' id='datetimepicker3' style="width: 250px;">
                    <input type='text' class="form-control" name="departure"/>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin-top:5px;"> No. Pax </label>
                  <input type="number" name="pax" class="form-control" value="" style="width: 250px;"/> 
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin-top:5px;"> No. Child </label>
                  <input type="number" name="child" class="form-control" value="" style="width: 250px;"/> 
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin-top:5px;"> Reason </label>
                  <textarea type="text" name="reason" placeholder="The Reason ..." class="form-control" row="3"></textarea>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin-top:5px;"> VIP Full Treatment </label>
                  <select class="form-control chooosen" name="treatment_id" data-placeholder="Treatment ...">
                    <option></option>
                    <?php foreach ($treatments as $treatment): ?>
                      <option value="<?php echo $treatment['id'] ?>"<?php echo set_select('treatment_id',$treatment['id'] ); ?>><?php echo $treatment['name'] ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin-top:5px;"> Others Amenities </label>
                  <select class="form-control chooosen" name="other[]" id="otherss" multiple="multiple" data-placeholder="Others Amenities ...">
                    <option></option>
                    <?php foreach ($others as $other): ?>
                      <option value="<?php echo $other['id'] ?>"<?php echo set_select('otherss[]',$other['id'] ); ?>><?php echo $other['name'] ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin-top:5px;"> Location </label>
                  <input type="text" name="location" class="form-control" value="" style="width: 250px;"/> 
                </div>
                <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;">Refiling</label>
                  <input type="checkbox" name="ref" value="1" id="ref"><p style="font-size: 10px;"><span style="font-weight: bold;">Note:</span> Number of times</p>
                  <div id="refiling" style="display: none;">
                    <input type="text" name="refiling" style="width: 250px; height:33px;" />
                  </div>
                </div>
                <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin-top:5px;"> Others </label>
                  <textarea type="text" name="others" class="form-control" row="3"></textarea>
                </div>
                <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin-top:5px;"> Guest Relations </label>
                  <input type="text" name="relations" class="form-control" value=""/> 
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <br>
                  <input type="hidden" name="amen_id" value="<?php echo $amenity['id']; ?>" />
                  <label for="offers" class="col-lg-3 col-md-4 col-sm-5 col-xs-5 control-label">Report Files</label>
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <input id="offers" name="upload" type="file" class="file" multiple="true" data-show-upload="true" data-show-caption="true">
                  </div>
                  <script>
                    $("#offers").fileinput({
                      uploadUrl: "/amenitys/make_offer/<?php echo $amenity['id'] ?>", // server upload action
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
                          {url: "/amenitys/remove_offer/<?php echo $amenity['id'] ?>/<?php echo $upload['id'] ?>", key: "<?php echo $upload['name']; ?>"},
                        <?php endforeach; ?>
                      ],
                    });
                  </script>
                </div>
                <div style="margin-top: 90px;" class="form-group">
                  <div class="col-lg-offset-3 col-lg-10 col-md-10 col-md-offset-3">
                    <br>
                    <br>
                    <br>
                    <br>
                    <input name="submit" value="Submit" type="submit" class="btn btn-success" />
                    <a href="<?= base_url(); ?>amenitys/add_exp" class="btn btn-warning">Cancel</a>
                  </div>
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
      document.other = <?php echo json_encode($this->input->post('other')); ?>;
    </script>
    <script type="text/javascript">
      var checkbox = document.getElementById('ref');
      var input = document.getElementById('refiling');
      checkbox.addEventListener('click', function () {
        if (input.style.display != 'block') {
          input.style.display = 'block';
        } else {
          input.style.display = 'none';
        }
      });
    </script>  
    <script type="text/javascript">
      $(function () {
        $('#datetimepicker1').datetimepicker({
          format: 'YYYY-MM-DD hh:mm a'
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
    <script type="text/javascript">
      $(function () {
        $('#datetimepicker3').datetimepicker({
          format: 'YYYY-MM-DD'
        });
      });
    </script> 
    <script type = "text/javascript" >
      function preventBack(){window.history.forward();}
      setTimeout("preventBack()", 0);
      window.onunload=function(){null};
    </script> 
  </body>
</html>
