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
                <a href="<?= base_url(); ?>amenitys/submit_group/<?php echo $amenity['id']; ?>" class="form-actions btn btn-info" style="float:left;">Group Expacted Arrival</a>
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
                <table class="table table-striped table-bordered table-condensed centered" style="width: 1700px;">
                  <tr class="item-row">
                    <td class="align-left table-label" style="width: 70px;">Long Stay</td>
                    <td class="align-left table-label" style="width: 70px;">Room</td>
                    <td class="align-left table-label" style="width: 200px;">Name</td>
                    <td class="align-left table-label" style="width: 120px;">Nationality</td>
                    <td class="align-left table-label" style="width: 120px;">Arrival Date</td>
                    <td class="align-left table-label" style="width: 120px;">Departure Date</td>
                    <td class="align-left table-label" style="width: 100px;">No. Pax</td>
                    <td class="align-left table-label" style="width: 100px;">No. Child</td>
                    <td class="align-left table-label" style="width: 250px;">The Reason</td>
                    <td class="align-left table-label" style="width: 200px;">VIP Full Treatment</td>
                    <td class="align-left table-label" style="width: 200px;">Others Amenities</td>
                    <td class="align-left table-label" style="width: 150px;">Location</td>
                  </tr>
                  <?php foreach ($items as $item):?>
                    <tr class="item-row">
                       <td class="align-left table-label" style="display: none">
                        <input class="form-control" name="rooms[<?php echo $item['id']?>][id]" value="<?php echo $item['id']?>">
                      </td>
                      <td>
                        <input type="checkbox" name="rooms[<?php echo $item['id']?>][longs]" value="1"><p style="font-size: 10px;"><span style="font-weight: bold;">Note:</span> More than 15 days</p>
                      </td> 
                      <td class="align-left table-label">
                        <input readonly="" type="text" name="rooms[<?php echo $item['id']?>][room]" class="form-control" value="<?php echo $item['room']; ?>"/>
                      </td> 
                      <td class="align-left table-label">
                        <input type="text" name="rooms[<?php echo $item['id']?>][guest]" class="form-control" value=""/>
                      </td>
                      <td class="align-left table-label">
                        <input type="text" name="rooms[<?php echo $item['id']?>][nationality]" class="form-control" value=""/> 
                      </td>
                      <td class="align-left table-label">
                        <input type="text" name="rooms[<?php echo $item['id']?>][arrival]" class="form-control" value=""/> 
                      </td>
                      <td class="align-left table-label">
                        <input type="text" name="rooms[<?php echo $item['id']?>][departure]" class="form-control" value=""/> 
                      </td>
                      <td class="align-left table-label">
                        <input type="number" name="rooms[<?php echo $item['id']?>][pax]" placeholder="No. Pax ..." class="form-control" value=""/> 
                      </td>
                      <td class="align-left table-label">
                        <input type="number" name="rooms[<?php echo $item['id']?>][child]" placeholder="No. Child ..." class="form-control" value=""/> 
                      </td>
                      <td class="align-left table-label">
                        <textarea type="text" name="rooms[<?php echo $item['id']?>][reason]" placeholder="The Reason ..." class="form-control" row="3"></textarea>
                      </td>
                      <td class="align-left table-label">
                        <select class="form-control chooosen" name="rooms[<?php echo $item['id']?>][treatment_id]" data-placeholder="Treatment ...">
                          <option></option>
                          <?php foreach ($treatments as $treatment): ?>
                            <option value="<?php echo $treatment['id'] ?>"<?php echo set_select('treatment_id',$treatment['id'] ); ?>><?php echo $treatment['name'] ?></option>
                          <?php endforeach ?>
                        </select>
                      </td>
                      <td class="align-left table-label" style="display: none">
                        <input class="form-control" name="other[<?php echo $item['id']?>][id]" value="<?php echo $item['id']?>">
                      </td>
                      <td class="align-left table-label">
                        <select class="form-control chooosen" name="other[<?php echo $item['id']?>][otherss][]" id="otherss" multiple="multiple" data-placeholder="Others Amenities ...">
                          <option></option>
                          <?php foreach ($others as $other): ?>
                            <option value="<?php echo $other['id'] ?>"<?php echo set_select('otherss[]',$other['id'] ); ?>><?php echo $other['name'] ?></option>
                          <?php endforeach ?>
                        </select>
                      </td>
                      <td class="align-left table-label">
                        <input type="text" name="rooms[<?php echo $item['id']?>][location]" placeholder="Location ..." class="form-control" value=""/> 
                      </td>
                    </tr>
                  <?php endforeach ?>
                </table>
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
                <div style="    margin-top: 90px;" class="form-group">
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
      $(function () {
        $('#datetimepicker1').datetimepicker({
          format: 'YYYY-MM-DD hh:mm a'
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
