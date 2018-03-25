<!DOCTYPE html>
<html lang="en">
  <head>
    <?php $this->load->view('header'); ?>
  </head>
  <body>
    <div id="wrapper">
      <?php $this->load->view('menu') ?>
      <div id="page-wrapper">
        <div class="">
          <div class="" style="margin-bottom: 10px;">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px;">
              <div class="page-header">
                <h1 class="centered">Shop Renting Prior Approval</h1>
              </div>
              <?php if(validation_errors() != false): ?>
                <div class="alert alert-danger">
                  <?php echo validation_errors(); ?>
                </div>
              <?php endif ?>         
            </div>
            <div class="container">
              <form action="" method="POST" id="form-submit" enctype="multipart/form-data" class="form-div span12" accept-charset="utf-8">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <br>
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <br>
                    <label for="from-hotel" class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" style="margin-top:5px;">Hotel Name</label>
                    <select class="form-control chooosen" data-placeholder="Hotel ..." name="hotel_id" id="from-hotel " style="width: 250px; height:33px;">
                      <option data-company="0" value="">Hotel..</option>
                      <?php foreach ($hotels as $hotel): ?>
                        <option value="<?php echo $hotel['id'] ?>"<?php echo set_select('hotel_id',$hotel['id'] ); ?>><?php echo $hotel['name'] ?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                  <br>
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <br>
                    <label for="from-hotel" class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" style="margin-top:5px;">Contract Title</label>
                    <input type="text" class="form-control" name="title" placeholder="Title ..." value="<?php echo set_value('title'); ?>" style="width: 250px; height:33px;"/></input>
                  </div>
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <br>
                    <table class="table table-striped table-bordered table-condensed">
                      <thead>
                        <tr>
                          <th colspan="1" style=" text-align: center;">#</th>
                          <th colspan="1" style=" text-align: center;">Current Tenant</th>
                          <th colspan="1" style=" text-align: center;">Tenant 1</th>
                          <th colspan="1" style=" text-align: center;">Tenant 2</th>
                          <th colspan="1" style=" text-align: center;">Tenant 3</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr style="display: none;">
                          <td>Contract Type</td>
                          <td>
                            <input type="number" class="form-control" name="items[1][type_id]" value="1" /></input>
                          </td>
                          <td>
                            <input type="number" class="form-control" name="items[2][type_id]" value="2" /></input>
                          </td>
                          <td>
                            <input type="number" class="form-control" name="items[3][type_id]" value="2" /></input>
                          </td>
                          <td>
                            <input type="number" class="form-control" name="items[4][type_id]" value="2" /></input>
                          </td>
                        </tr>
                        <tr>
                          <td>Choose</td>
                          <td>
                            <input type="radio" class="form-control" name="choosen_id" value="0" /></input>
                          </td>
                          <td>
                            <input type="radio" class="form-control" name="choosen_id" value="1" /></input>
                          </td>
                          <td>
                            <input type="radio" class="form-control" name="choosen_id" value="2" /></input>
                          </td>
                          <td>
                            <input type="radio" class="form-control" name="choosen_id" value="3" /></input>
                          </td>
                        </tr>
                        <tr>
                          <td>Tenant Name</td>
                          <td>
                            <input type="text" class="form-control" name="items[1][name]"/></input>
                          </td>
                          <td>
                            <input type="text" class="form-control" name="items[2][name]"/></input>
                          </td>
                          <td>
                            <input type="text" class="form-control" name="items[3][name]"/></input>
                          </td>
                          <td>
                            <input type="text" class="form-control" name="items[4][name]"/></input>
                          </td>
                        </tr>
                        <tr>
                          <td>Starting From</td>
                          <td>
                            <div class='input-group date' id='datetimepicker1' style="width: 250px; height:33px;">
                              <input type='text' class="form-control" name="items[1][start_from]"/>
                              <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                            </div>
                          </td>
                          <td>
                            <div class='input-group date' id='datetimepicker2' style="width: 250px; height:33px;">
                              <input type='text' class="form-control" name="items[2][start_from]"/>
                              <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                            </div>
                          </td>
                          <td>
                            <div class='input-group date' id='datetimepicker3' style="width: 250px; height:33px;">
                              <input type='text' class="form-control" name="items[3][start_from]"/>
                              <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                            </div>
                          </td>
                          <td>
                            <div class='input-group date' id='datetimepicker4' style="width: 250px; height:33px;">
                              <input type='text' class="form-control" name="items[4][start_from]"/>
                              <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td>End At</td>
                          <td>
                            <div class='input-group date' id='datetimepicker5' style="width: 250px; height:33px;">
                              <input type='text' class="form-control" name="items[1][end_at]"/>
                              <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                            </div>
                          </td>
                          <td>
                            <div class='input-group date' id='datetimepicker6' style="width: 250px; height:33px;">
                              <input type='text' class="form-control" name="items[2][end_at]"/>
                              <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                            </div>
                          </td>
                          <td>
                            <div class='input-group date' id='datetimepicker7' style="width: 250px; height:33px;">
                              <input type='text' class="form-control" name="items[3][end_at]"/>
                              <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                            </div>
                          </td>
                          <td>
                            <div class='input-group date' id='datetimepicker8' style="width: 250px; height:33px;">
                              <input type='text' class="form-control" name="items[4][end_at]"/>
                              <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td>Monthly Rent</td>
                          <td>
                            <input type="number" class="form-control" name="items[1][rent]" /></input>
                          </td>
                          <td>
                            <input type="number" class="form-control" name="items[2][rent]" /></input>
                          </td>
                          <td>
                            <input type="number" class="form-control" name="items[3][rent]" /></input>
                          </td>
                          <td>
                            <input type="number" class="form-control" name="items[4][rent]" /></input>
                          </td>
                        </tr>
                        <tr>
                          <td>Currency</td>
                          <td>
                            <select class="form-control chooosen" name="items[1][currency_id]" id="from-hotel " data-placeholder="Currency ..." style="width: 250px; height:33px;">
                              <option data-company="0" value="">Currency ..</option>
                              <?php foreach ($currencies as $currency): ?>
                                <option value="<?php echo $currency['id'] ?>"><?php echo $currency['name'] ?></option>
                              <?php endforeach ?>
                            </select>
                          </td>
                          <td>
                            <select class="form-control chooosen" name="items[2][currency_id]" id="from-hotel " data-placeholder="Currency ..." style="width: 250px; height:33px;">
                              <option data-company="0" value="">Currency ..</option>
                              <?php foreach ($currencies as $currency): ?>
                                <option value="<?php echo $currency['id'] ?>"><?php echo $currency['name'] ?></option>
                              <?php endforeach ?>
                            </select>
                          </td>
                          <td>
                            <select class="form-control chooosen" name="items[3][currency_id]" id="from-hotel " data-placeholder="Currency ..." style="width: 250px; height:33px;">
                              <option data-company="0" value="">Currency ..</option>
                              <?php foreach ($currencies as $currency): ?>
                                <option value="<?php echo $currency['id'] ?>"><?php echo $currency['name'] ?></option>
                              <?php endforeach ?>
                            </select>
                          </td>
                          <td>
                            <select class="form-control chooosen" name="items[4][currency_id]" id="from-hotel " data-placeholder="Currency ..." style="width: 250px; height:33px;">
                              <option data-company="0" value="">Currency ..</option>
                              <?php foreach ($currencies as $currency): ?>
                                <option value="<?php echo $currency['id'] ?>"><?php echo $currency['name'] ?></option>
                              <?php endforeach ?>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td>Taxes</td>
                          <td>
                            <input type="number" class="form-control" name="items[1][taxes]" /></input>
                          </td>
                          <td>
                            <input type="number" class="form-control" name="items[2][taxes]" /></input>
                          </td>
                          <td>
                            <input type="number" class="form-control" name="items[3][taxes]" /></input>
                          </td>
                          <td>
                            <input type="number" class="form-control" name="items[4][taxes]" /></input>
                          </td>
                        </tr>
                        <tr>
                          <td>Other Conditions</td>
                          <td>
                            <input type="text" class="form-control" name="items[1][other]"/></input>
                          </td>
                          <td>
                            <input type="text" class="form-control" name="items[2][other]"/></input>
                          </td>
                          <td>
                            <input type="text" class="form-control" name="items[3][other]"/></input>
                          </td>
                          <td>
                            <input type="text" class="form-control" name="items[4][other]"/></input>
                          </td>
                        </tr>
                        <tr>
                          <td>Advance Rent</td>
                          <td>
                            <input type="number" class="form-control" name="items[1][advance]" /></input>
                          </td>
                          <td>
                            <input type="number" class="form-control" name="items[2][advance]" /></input>
                          </td>
                          <td>
                            <input type="number" class="form-control" name="items[3][advance]" /></input>
                          </td>
                          <td>
                            <input type="number" class="form-control" name="items[4][advance]" /></input>
                          </td>
                        </tr>
                        <tr>
                          <td>Currency</td>
                          <td>
                            <select class="form-control chooosen" name="items[1][currency1_id]" id="from-hotel " data-placeholder="Currency ..." style="width: 250px; height:33px;">
                              <option data-company="0" value="">Currency ..</option>
                              <?php foreach ($currencies as $currency): ?>
                                <option value="<?php echo $currency['id'] ?>"><?php echo $currency['name'] ?></option>
                              <?php endforeach ?>
                            </select>
                          </td>
                          <td>
                            <select class="form-control chooosen" name="items[2][currency1_id]" id="from-hotel " data-placeholder="Currency ..." style="width: 250px; height:33px;">
                              <option data-company="0" value="">Currency ..</option>
                              <?php foreach ($currencies as $currency): ?>
                                <option value="<?php echo $currency['id'] ?>"><?php echo $currency['name'] ?></option>
                              <?php endforeach ?>
                            </select>
                          </td>
                          <td>
                            <select class="form-control chooosen" name="items[3][currency1_id]" id="from-hotel " data-placeholder="Currency ..." style="width: 250px; height:33px;">
                              <option data-company="0" value="">Currency ..</option>
                              <?php foreach ($currencies as $currency): ?>
                                <option value="<?php echo $currency['id'] ?>"><?php echo $currency['name'] ?></option>
                              <?php endforeach ?>
                            </select>
                          </td>
                          <td>
                            <select class="form-control chooosen" name="items[4][currency1_id]" id="from-hotel " data-placeholder="Currency ..." style="width: 250px; height:33px;">
                              <option data-company="0" value="">Currency ..</option>
                              <?php foreach ($currencies as $currency): ?>
                                <option value="<?php echo $currency['id'] ?>"><?php echo $currency['name'] ?></option>
                              <?php endforeach ?>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td>Deposit</td>
                          <td>
                            <input type="number" class="form-control" name="items[1][deposite]" /></input>
                          </td>
                          <td>
                            <input type="number" class="form-control" name="items[2][deposite]" /></input>
                          </td>
                          <td>
                            <input type="number" class="form-control" name="items[3][deposite]" /></input>
                          </td>
                          <td>
                            <input type="number" class="form-control" name="items[4][deposite]" /></input>
                          </td>
                        </tr>
                        <tr>
                          <td>Currency</td>
                          <td>
                            <select class="form-control chooosen" name="items[1][currency2_id]" id="from-hotel " data-placeholder="Currency ..." style="width: 250px; height:33px;">
                              <option data-company="0" value="">Currency ..</option>
                              <?php foreach ($currencies as $currency): ?>
                                <option value="<?php echo $currency['id'] ?>"><?php echo $currency['name'] ?></option>
                              <?php endforeach ?>
                            </select>
                          </td>
                          <td>
                            <select class="form-control chooosen" name="items[2][currency2_id]" id="from-hotel " data-placeholder="Currency ..." style="width: 250px; height:33px;">
                              <option data-company="0" value="">Currency ..</option>
                              <?php foreach ($currencies as $currency): ?>
                                <option value="<?php echo $currency['id'] ?>"><?php echo $currency['name'] ?></option>
                              <?php endforeach ?>
                            </select>
                          </td>
                          <td>
                            <select class="form-control chooosen" name="items[3][currency2_id]" id="from-hotel " data-placeholder="Currency ..." style="width: 250px; height:33px;">
                              <option data-company="0" value="">Currency ..</option>
                              <?php foreach ($currencies as $currency): ?>
                                <option value="<?php echo $currency['id'] ?>"><?php echo $currency['name'] ?></option>
                              <?php endforeach ?>
                            </select>
                          </td>
                          <td>
                            <select class="form-control chooosen" name="items[4][currency2_id]" id="from-hotel " data-placeholder="Currency ..." style="width: 250px; height:33px;">
                              <option data-company="0" value="">Currency ..</option>
                              <?php foreach ($currencies as $currency): ?>
                                <option value="<?php echo $currency['id'] ?>"><?php echo $currency['name'] ?></option>
                              <?php endforeach ?>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td>Location</td>
                          <td>
                            <input type="text" class="form-control" name="items[1][location]"/></input>
                          </td>
                          <td>
                            <input type="text" class="form-control" name="items[2][location]"/></input>
                          </td>
                          <td>
                            <input type="text" class="form-control" name="items[3][location]"/></input>
                          </td>
                          <td>
                            <input type="text" class="form-control" name="items[4][location]"/></input>
                          </td>
                        </tr>
                        <tr>
                          <td>References</td>
                          <td>
                            <input type="text" class="form-control" name="items[1][reference]"/></input>
                          </td>
                          <td>
                            <input type="text" class="form-control" name="items[2][reference]"/></input>
                          </td>
                          <td>
                            <input type="text" class="form-control" name="items[3][reference]"/></input>
                          </td>
                          <td>
                            <input type="text" class="form-control" name="items[4][reference]"/></input>
                          </td>
                        </tr>
                        <tr>
                          <td>Reference By</td>
                          <td>
                            <input type="text" class="form-control" name="items[1][by_reference]"/></input>
                          </td>
                          <td>
                            <input type="text" class="form-control" name="items[2][by_reference]"/></input>
                          </td>
                          <td>
                            <input type="text" class="form-control" name="items[3][by_reference]"/></input>
                          </td>
                          <td>
                            <input type="text" class="form-control" name="items[4][by_reference]"/></input>
                          </td>
                        </tr>
                        <tr>
                          <td>Who Is Reference?</td>
                          <td>
                            <input type="text" class="form-control" name="items[1][who_reference]"/></input>
                          </td>
                          <td>
                            <input type="text" class="form-control" name="items[2][who_reference]"/></input>
                          </td>
                          <td>
                            <input type="text" class="form-control" name="items[3][who_reference]"/></input>
                          </td>
                          <td>
                            <input type="text" class="form-control" name="items[4][who_reference]"/></input>
                          </td>
                        </tr>
                        <tr>
                          <td>Design Attached</td>
                          <td class="centered">
                            <input type="file" class="form-control" name="items-1-design" value="" style="width: 210px;"/>
                          </td>
                          <td class="centered">
                            <input type="file" class="form-control" name="items-2-design" value="" style="width: 210px;"/>
                          </td>
                          <td class="centered">
                            <input type="file" class="form-control" name="items-3-design" value="" style="width: 210px;"/>
                          </td>
                          <td class="centered">
                            <input type="file" class="form-control" name="items-4-design" value="" style="width: 210px;"/>
                          </td>
                        </tr>
                        <tr>
                          <td>Attached Offer</td>
                          <td class="centered">
                            <input type="file" class="form-control" name="items-1-offer" value="" style="width: 210px;"/>
                          </td>
                          <td class="centered">
                            <input type="file" class="form-control" name="items-2-offer" value="" style="width: 210px;"/>
                          </td>
                          <td class="centered">
                            <input type="file" class="form-control" name="items-3-offer" value="" style="width: 210px;"/>
                          </td>
                          <td class="centered">
                            <input type="file" class="form-control" name="items-4-offer" value="" style="width: 210px;"/>
                          </td>
                        </tr>
                        <tr>
                          <td>Attached CV</td>
                          <td class="centered">
                            <input type="file" class="form-control" name="items-1-cv" value="" style="width: 210px;"/>
                          </td>
                          <td class="centered">
                            <input type="file" class="form-control" name="items-2-cv" value="" style="width: 210px;"/>
                          </td>
                          <td class="centered">
                            <input type="file" class="form-control" name="items-3-cv" value="" style="width: 210px;"/>
                          </td>
                          <td class="centered">
                            <input type="file" class="form-control" name="items-4-cv" value="" style="width: 210px;"/>
                          </td>
                        </tr>
                        <tr>
                          <td>Attached Contract </td>
                          <td class="centered">
                            <input type="file" class="form-control" name="items-1-contract" value="" style="width: 210px;"/>
                          </td>
                          <td class="centered">
                            <input type="file" class="form-control" name="items-2-contract" value="" style="width: 210px;"/>
                          </td>
                          <td class="centered">
                            <input type="file" class="form-control" name="items-3-contract" value="" style="width: 210px;"/>
                          </td>
                          <td class="centered">
                            <input type="file" class="form-control" name="items-4-contract" value="" style="width: 210px;"/>
                          </td>
                        </tr>
                      </tbody>
                    </table>    
                  </div>
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <br>
                    <label for="from-hotel" class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" style="margin-top:5px;">Tenant Recommendation</label>
                    <input type="text" class="form-control" name="recommendation" placeholder="Recommendation ..." value="<?php echo set_value('recommendation'); ?>" style="width: 450px; height:33px;"/></input>
                  </div>
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <br>
                    <label for="from-hotel" class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" style="margin-top:5px;">Reason</label>
                    <textarea type="text" name="reason" class="form-control" rows="3" placeholder="Reason..." style="width: 650px;"><?php echo set_value('reason'); ?></textarea>
                  </div>
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 50px !important;">
                    <br>
                    <input type="hidden" name="assumed_id" value="<?php echo $assumed_id; ?>" />
                    <label for="offers" class="col-lg-3 col-md-4 col-sm-5 col-xs-5 control-label">Report Files</label>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                      <input id="offers" name="upload" type="file" class="file" multiple="true" data-show-upload="false" data-show-caption="true">
                    </div>
                    <script>
                      $("#offers").fileinput({
                        uploadUrl: "/shop_renting/upload/<?php echo $assumed_id; ?>",
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
                            {url: "/shop_renting/remove/<?php echo $assumed_id ?>/<?php echo $upload['id'] ?>", key: "<?php echo $upload['name']; ?>"},
                          <?php endforeach; ?>
                        ],
                      });
                    </script>
                  </div>
                  <div class="form-group">
                    <div class="col-lg-offset-3 col-lg-10 col-md-10 col-md-offset-3">
                      <input name="submit" value="Submit" type="submit" class="btn btn-success" />
                      <a href="<?= base_url(); ?>shop_renting/" class="btn btn-warning">Cancel</a>
                    </div>
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
      $('#datetimepicker').datetimepicker({
        format: 'YYYY-MM-DD'
      });
    });
  </script>
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
  <script type="text/javascript">
    $(function () {
      $('#datetimepicker3').datetimepicker({
        format: 'YYYY-MM-DD'
      });
    });
  </script> 
  <script type="text/javascript">
    $(function () {
      $('#datetimepicker4').datetimepicker({
        format: 'YYYY-MM-DD'
      });
    });
  </script> 
  <script type="text/javascript">
    $(function () {
      $('#datetimepicker5').datetimepicker({
        format: 'YYYY-MM-DD'
      });
    });
  </script> 
  <script type="text/javascript">
    $(function () {
      $('#datetimepicker6').datetimepicker({
        format: 'YYYY-MM-DD'
      });
    });
  </script> 
  <script type="text/javascript">
    $(function () {
      $('#datetimepicker7').datetimepicker({
        format: 'YYYY-MM-DD'
      });
    });
  </script> 
  <script type="text/javascript">
    $(function () {
      $('#datetimepicker8').datetimepicker({
        format: 'YYYY-MM-DD'
      });
    });
  </script>  
  <script type="text/javascript">
    document.items = <?php echo json_encode($this->input->post('items')); ?>;
  </script>
  <script type="text/javascript">
    document.body.addEventListener("keydown", function (event) {
      if (event.keyCode === 27) {
        window.location.replace("<?= base_url(); ?>shop_renting/");
      }
    });  
  </script>
</html>
