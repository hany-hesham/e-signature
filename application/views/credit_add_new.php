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
                <h1 class="centered">Credit Authorization Form</h1>
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
                  <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                    <br>
                    <label for="from-hotel" class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" style="margin-top:5px;"> Hotel Name </label>
                    <select class="form-control chooosen" data-placeholder="Hotel ..." name="hotel_id" id="from-hotel " style="width: 250px; height:33px;">
                      <option data-company="0" value="">Hotel ..</option>
                      <?php foreach ($hotels as $hotel): ?>
                        <option value="<?php echo $hotel['id'] ?>"<?php echo set_select('hotel_id',$hotel['id'] ); ?>><?php echo $hotel['name'] ?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                  <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                    <br>
                    <label for="from-hotel" class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" style="margin-top:5px;">Date</label>
                    <div class='input-group date' id='datetimepicker1' style="width: 250px; height:33px;">
                      <input type='text' class="form-control" name="date" value="<?php echo set_value('date'); ?>"/>
                      <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                  </div>
                  <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                    <br>
                    <h3>Company Details</h3>
                    <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                      <br>
                      <label for="from-hotel" class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" style="margin-top:5px;"> Company Name</label>
                      <input type="text" class="form-control" name="company" placeholder="Company ..." value="<?php echo set_value('company'); ?>" style="width: 250px; height:33px;"/></input>
                    </div>
                    <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                      <br>
                      <label for="from-hotel" class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" style="margin-top:5px;"> Address</label>
                      <input type="text" class="form-control" name="address" placeholder="Address ..." value="<?php echo set_value('address'); ?>" style="width: 250px; height:33px;"/></input>
                    </div>
                    <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                      <br>
                      <label for="from-hotel" class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" style="margin-top:5px;">Contact Person</label>
                      <input type="text" class="form-control" name="person" placeholder="Contact ..." value="<?php echo set_value('person'); ?>" style="width: 250px; height:33px;"/></input>
                    </div>
                    <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                      <br>
                      <label for="from-hotel" class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" style="margin-top:5px;">Telephone</label>
                      <input type="number" class="form-control" name="tele" placeholder="Telephone ..." value="<?php echo set_value('tele'); ?>" style="width: 250px; height:33px;"/></input>
                    </div>
                    <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                      <br>
                      <label for="from-hotel" class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" style="margin-top:5px;">E-mail</label>
                      <input type="text" class="form-control" name="email" placeholder="E-mail ..." value="<?php echo set_value('email'); ?>" style="width: 250px; height:33px;"/></input>
                    </div>
                  </div>
                  <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                    <br>
                    <h3>Contract Details</h3>
                    <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                      <h4>Contract period</h4>
                      <br>
                      <label for="from-hotel" class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" style="margin-top:5px;">From</label>
                      <div class='input-group date' id='datetimepicker2' style="width: 250px; height:33px;">
                        <input type='text' class="form-control" name="period_from" value="<?php echo set_value('period_from'); ?>"/>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                      </div>
                      <br>
                      <label for="from-hotel" class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" style="margin-top:5px;">To</label>
                      <div class='input-group date' id='datetimepicker3' style="width: 250px; height:33px;">
                        <input type='text' class="form-control" name="period_to" value="<?php echo set_value('period_to'); ?>"/>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                      </div>
                    </div>
                    <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                      <br>
                      <label for="from-hotel" class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" style="margin-top:5px;">No of contracted Rooms</label>
                      <input type="number" class="form-control" name="rooms" placeholder="Rooms ..." value="<?php echo set_value('rooms'); ?>" style="width: 250px; height:33px;"/></input>
                    </div>
                    <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                      <br>
                      <label for="from-hotel" class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" style="margin-top:5px;">Type</label>
                      <input type="text" class="form-control" name="contract_type" placeholder="Type ..." value="<?php echo set_value('contract_type'); ?>" style="width: 250px; height:33px;"/></input>
                    </div>
                  </div>
                  <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                    <br>
                    <h3>Deposit</h3>
                    <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                      <br>
                      <label for="from-hotel" class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" style="margin-top:5px;">Cash Amount</label>
                      <input type="number" class="form-control" name="cash" placeholder="Amount ..." value="<?php echo set_value('cash'); ?>" style="width: 250px; height:33px;"/></input>
                    </div>
                    <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                      <br>
                      <label for="from-hotel" class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" style="margin-top:5px;"> Currency</label>
                      <select class="orm-control chooosen" name="currency" data-placeholder="Currency ..." style="width: 250px;">
                        <option>Currency ..</option>
                        <option value="£" <?php echo set_select('currency', "£"); ?>>£</option> ‎
                        <option value="$" <?php echo set_select('currency', "$"); ?>>$</option> 
                        <option value="EURO" <?php echo set_select('currency', "EURO"); ?>>EURO</option>
                        <option value="EGP" <?php echo set_select('currency', "EGP"); ?>>EGP</option>
                      </select>
                    </div>
                    <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                      <br>
                      <label for="from-hotel" class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" style="margin-top:5px;">Letter of Guarantee</label>
                      <input type="text" class="form-control" name="letter" placeholder="Guarantee ..." value="<?php echo set_value('letter'); ?>" style="width: 250px; height:33px;"/></input>
                    </div>
                    <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                      <br>
                      <label for="from-hotel" class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" style="margin-top:5px;">Renew Al Date</label>
                      <div class='input-group date' id='datetimepicker4' style="width: 250px; height:33px;">
                        <input type='text' class="form-control" name="renew_date" value="<?php echo set_value('renew_date'); ?>"/>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                      </div>
                    </div>
                    <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                      <br>
                      <label for="from-hotel" class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" style="margin-top:5px;">Method of Deposit Deduction</label>
                      <input type="text" class="form-control" name="method" placeholder="Deposit Deduction ..." value="<?php echo set_value('method'); ?>" style="width: 250px; height:33px;"/></input>
                    </div>
                  </div>
                  <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                    <br>
                    <h3>Credit Limit</h3>
                    <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                      <br>
                      <label for="from-hotel" class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" style="margin-top:5px;">Credit Limit Amount</label>
                      <input type="number" class="form-control" name="limits" placeholder="Amount ..." value="<?php echo set_value('limits'); ?>" style="width: 250px; height:33px;"/></input>
                    </div>
                    <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                      <br>
                      <label for="from-hotel" class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" style="margin-top:5px;"> Currency</label>
                      <select class="orm-control chooosen" name="currency1" data-placeholder="Currency ..." style="width: 250px;">
                        <option>Currency ..</option>
                        <option value="£" <?php echo set_select('currency1', "£"); ?>>£</option> ‎
                        <option value="$" <?php echo set_select('currency1', "$"); ?>>$</option> 
                        <option value="EURO" <?php echo set_select('currency1', "EURO"); ?>>EURO</option>
                        <option value="EGP" <?php echo set_select('currency1', "EGP"); ?>>EGP</option>
                      </select>
                    </div>
                    <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                      <br>
                      <label for="from-hotel" class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" style="margin-top:5px;">Notes</label>
                      <textarea type="text" name="note" class="form-control" rows="3" placeholder="Notes..." style="width: 350px;"><?php echo set_value('note'); ?></textarea>
                    </div>
                  </div>
                  <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                    <br>
                    <h3>Terms of Payment</h3>
                    <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                      <br>
                      <label for="from-hotel" class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" style="margin-top:5px;">Terms</label>
                      <textarea type="text" name="terms" class="form-control" rows="3" placeholder="Terms..." style="width: 350px;"><?php echo set_value('terms'); ?></textarea>
                    </div>
                  </div>
                  <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                    <br>
                    <h3>Market Survey</h3>
                    <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                      <br>
                      <label for="from-hotel" class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" style="margin-top:5px;">Credit Ability</label>
                      <input type="text" class="form-control" name="ability" placeholder="Ability ..." value="<?php echo set_value('ability'); ?>" style="width: 250px; height:33px;"/></input>
                    </div>
                    <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                      <br>
                      <label for="from-hotel" class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" style="margin-top:5px;">Other Remarks</label>
                      <textarea type="text" name="remarks" class="form-control" rows="3" placeholder="Remarks..." style="width: 350px;"><?php echo set_value('remarks'); ?></textarea>
                    </div>
                  </div>
                  <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                    <br>
                    <h3>NB</h3>
                    <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                      <br>
                      <label for="from-hotel" class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" style="margin-top:5px;">NB</label>
                      <textarea type="text" name="nb" class="form-control" rows="3" placeholder="NB..." style="width: 350px;"><?php echo set_value('nb'); ?></textarea>
                    </div>
                  </div>
                  <div class="form-group col-lg-10 col-md-10 col-sm-10 col-xs-10">
                    <br>
                    <input type="hidden" name="assumed_id" value="<?php echo $assumed_id; ?>" />
                    <label for="offers" class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label">Report Files</label>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                      <input id="offers" name="upload" type="file" class="file" multiple="true" data-show-upload="false" data-show-caption="true">
                    </div>
                    <script>
                      $("#offers").fileinput({
                        uploadUrl: "/credit/upload/<?php echo $assumed_id; ?>",
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
                            {url: "/credit/remove/<?php echo $assumed_id ?>/<?php echo $upload['id'] ?>", key: "<?php echo $upload['name']; ?>"},
                          <?php endforeach; ?>
                        ],
                      });
                    </script>
                  </div>
                  <div style="margin-top: 90px;" class="form-group">
                    <div class="col-lg-offset-3 col-lg-10 col-md-10 col-md-offset-3">
                      <input name="submit" value="Submit" type="submit" class="btn btn-success" />
                      <a href="<?= base_url(); ?>credit/" class="btn btn-warning">Cancel</a>
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
    document.body.addEventListener("keydown", function (event) {
      if (event.keyCode === 27) {
        window.location.replace("<?= base_url(); ?>credit/");
      }
    });  
  </script> 
</html>
