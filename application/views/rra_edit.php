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
              <legend>Submit a new Rate Change Report</legend>
              <?php if(validation_errors() != false): ?>
              <div class="alert alert-danger">
                <?php echo validation_errors(); ?>
              </div>
              <?php endif ?>
              <form action="" method="POST" id="form-submit" enctype="multipart/form-data" class="form-div span12" accept-charset="utf-8">
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;"> Hotel Name </label>
                  <select class="form-control" name="hotel_id" id="from-hotel " style="width: 30%;" style="height:35px; width: 240px; ">
                    <option data-company="0" value="<?php echo $rr['hotel_id']; ?>"><?php echo $rr['hotel_name']; ?></option>
                    <?php foreach ($hotels as $hotel): ?>
                    <option value="<?php echo $hotel['id'] ?>" <?php echo set_select('hotel_id',$hotel['id'] ); ?>><?php echo $hotel['name'] ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:15px;"> Date </label>
                  <div class='input-group date' id='datetimepicker1' style=" width: 240px; margin:10px;">
                    <input type="text" name="date" class="form-control" value="<?php echo $rr['date']; ?>" /> 
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calender"></span></span>
                  </div>
                    <table class="table table-striped table-bordered table-condensed" style="width: 1200px;">
                    <thead>
                          <tr class="item-row">
                              <td colspan="2" rowspan="1" style=" text-align: center;">Room </td>
                              <td colspan="2" rowspan="1" style=" text-align: center;">Rate </td>
                              <td colspan="1" rowspan="2" style=" text-align: center;">Currency </td>
                              <td colspan="1" rowspan="2" style=" text-align: center;">Travel Agent </td>
                              <td colspan="1" rowspan="2" style=" text-align: center;">Remarks </td>
                          </tr>
                          <tr>
                              <td colspan="1" rowspan="1" style=" text-align: center;">From </td>
                              <td colspan="1" rowspan="1" style=" text-align: center;">To </td>
                              <td colspan="1" rowspan="1" style=" text-align: center;">From </td>
                              <td colspan="1" rowspan="1" style=" text-align: center;">To </td>
                          </tr>
                    </thead>
                    <tbody id="items-container" data-items="1">
                    <?php if ($rra_room) {?>
                      <?php foreach ($rra_room as $room):?>
                         <tr id="item-<?php echo $room['id']?>">
                          <td hidden="">
                            <input class="form-control" name="items[<?php echo $room['id']?>][id]" value="<?php echo $room['id']?>">
                          </td>
                          <td class="centered" style="width: 200px;"> 
                            <input type="text" class="form-control" name="items[<?php echo $room['id']?>][room_old]" style="width: 200px; height:35px;" value="<?php echo $room['room_old']?>" /></input>
                          </td>
                          <td class="centered" style="width: 200px;"> 
                            <input type="text" class="form-control" name="items[<?php echo $room['id']?>][room_new]" style="width: 200px; height:35px;" value="<?php echo $room['room_new']?>" /></input>
                          </td>
                          <td class="centered" style="width: 200px;"> 
                            <input type="text" class="form-control" name="items[<?php echo $room['id']?>][rate_from]" style="width: 200px; height:35px;" value="<?php echo $room['rate_from']?>" /></input>
                           </td>
                           <td class="centered" style="width: 200px;"> 
                            <input type="text" class="form-control" name="items[<?php echo $room['id']?>][rate_to]" style="width: 200px; height:35px;" value="<?php echo $room['rate_to']?>" /></input>
                           </td>
                          <td style=" text-align: center;">
                            <select class="form-control" name="items[<?php echo $room['id']?>][currency]" style="height:35px; ">
                            <option value="<?php echo $room['currency']; ?>"><?php echo $room['currency']; ?></option>
                              <option>$</option>
                              <option>EGP</option>
                              <option>EURO</option>
                            </select>
                          </td>
                          <td class="centered" style="width: 200px;"> 
                            <select class="form-control" name="items[<?php echo $room['id']?>][rt_id]" style="width: 200px; height:35px;">
                              <option data-company="0" value="<?php echo $room['rt_id']?>"><?php echo $room['rt_name']?></option>
                              <?php foreach ($operators as $operator): ?>
                                <option value="<?php echo $operator['id'] ?>" <?php echo set_select('operator_id',$operator['id'] ); ?>><?php echo $operator['name'] ?></option>
                              <?php endforeach ?>
                            </select> 
                          </td>
                          <td class="centered" style="width: 200px;"> 
                            <textarea type="text" class="form-control" name="items[<?php echo $room['id']?>][remarks]" style="width: 200px; height:35px;" /><?php echo $room['remarks']?></textarea>
                          </td>
                        </tr>
                      <?php endforeach?>
                      <?php }else{ ?>
                <img src="/assets/images/Capture5.png" style="position: absolute; margin-top: 150px; margin-left:300px; ">
                  <?php for ($i=0; $i < 10; $i++) { ?>
                <tr class="item-row">
                  <td class="align-left table-label centered" style="width: 100px;">&nbsp;&nbsp;</td>
                  <td class="align-left table-label centered" style="width: 150px;">&nbsp;&nbsp;</td>
                  <td class="align-left table-label centered" style="width: 150px;">&nbsp;&nbsp;</td>
                  <td class="align-left table-label centered" style="width: 150px;">&nbsp;&nbsp;</td>
                  <td class="align-left table-label centered" style="width: 150px;">&nbsp;&nbsp;</td>
                </tr>
                  <?php } ?>
                <?php } ?>
                    </tbody>
                  </table>
                  <script type="text/javascript">
                    document.items = <?php echo json_encode($this->input->post('items')); ?>;
                  </script>
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <input type="hidden" name="dcy_id" value="<?php echo $rr['id']; ?>" />
                      <label for="offers" class="col-lg-3 col-md-4 col-sm-5 col-xs-5 control-label">Report Files</label>
                      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <input id="offers" name="upload" type="file" class="file" multiple="true" data-show-upload="false" data-show-caption="true">
                      </div>
                      <script>
                      $("#offers").fileinput({
                          uploadUrl: "/rra_change/make_offer/<?php echo $rr['id'] ?>", // server upload action
                          uploadAsync: true,
                          minFileCount: 1,
                          maxFileCount: 5,
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
                              {url: "/rra_change/remove_offer/<?php echo $rr['id'] ?>/<?php echo $upload['id'] ?>", key: "<?php echo $upload['name']; ?>"},
                          <?php endforeach; ?>
                          ],
                      });
                      </script>
                  </div> 
                </div>
                <div style="    margin-top: 90px;" class="form-group">
                  <div class="col-lg-offset-3 col-lg-10 col-md-10 col-md-offset-3">
                    <input name="submit" value="Submit" type="submit" class="btn btn-success" />
                    <a href="<?= base_url(); ?>rra_change" class="btn btn-warning">Cancel</a>
                  </div>
                </div>
              </form>
            </fieldset>
          </div>
        </div>
      </div>
    </div>
    <script type="text/javascript">
      $(function(){
        $('#datetimepicker1').datetimepicker({
          viewMode:'days',
          format:'DD/MM/YYYY'
        });
      });
    </script>
  </body>
</html>
