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
          <div class="a4page">
            <a href="<?= base_url(); ?>upgrad/submit_exp/" class="form-actions btn btn-info" style="float:left;">Expacted Arrival</a>
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
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <label for="from-hotel" class="col-lg-2 col-md-4 col-sm-2 col-xs-2 control-label" style="margin-top:5px;"> Room Number/s </label>
                    <input type="text" name="room" class="form-control" style="width: 250px; height:33px;"/> 
                  </div>
                </div>
                <div class="col-lg-offset-3 col-lg-10 col-md-10 col-md-offset-3">
                  <input name="submit" value="Submit" type="submit" class="btn btn-success" />
                  <a href="<?= base_url(); ?>upgrad" class="btn btn-warning">Cancel</a>
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
  </body>
</html>
