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
                <h1 class="centered">Credit Application Form<span>No. #<?php echo $credit_app['id']; ?></span></h1>
              </div>
              <?php if(validation_errors() != false): ?>
                <div class="alert alert-danger">
                  <?php echo validation_errors(); ?>
                </div>
              <?php endif ?>         
            </div>
            <div class="container">
              <form action="" method="POST" id="form-submit" enctype="multipart/form-data" class="form-div span12" accept-charset="utf-8">
                <br><br><br><br><br><br><br>
                   <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:10px;">Previous Hotel Bookings at:</label>
                  <p>
                    <input type="text" name="pre_booking_date" class="form-control" style=" height:38px; width: 240px;" class="form-control" 
                           value="<?php echo $credit_app['pre_booking_date']?>" />
                  </p>
                  <br>
                    <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;">Reference:</label>
                  <p>
                    <input type="text" name="ref" class="form-control" style=" height:38px; width: 240px;" class="form-control"
                           value="<?php echo $credit_app['ref']?>" />
                  </p>
                    <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;">Credit Decision:</label>
                  <p>
                    <input type="text" name="credit_decision" class="form-control" style=" height:38px; width: 240px;" class="form-control"
                     value="<?php echo $credit_app['credit_decision']?>" />
                  </p>
                    <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;">Direct Billing Approval:</label>
                  <p>
                    <input type="text" name="billing_approval" class="form-control" style=" height:38px; width: 240px;" class="form-control"
                          value="<?php echo $credit_app['billing_approval']?>" />
                  </p>
                   <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;">Percentage of Prepayment:</label>
                  <p>
                    <input type="text" name="payment_percentage" class="form-control" style=" height:38px; width: 240px;" class="form-control"
                           value="<?php echo $credit_app['payment_percentage']?>" />
                  </p>
                  <br>
                    <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;">Others:</label>
                  <p>
                    <input type="text" name="others" class="form-control" style=" height:38px; width: 240px;" class="form-control"
                           value="<?php echo $credit_app['others']?>" />
                  </p>
                 <br>
                <div style="    margin-top: 90px;" class="form-group">
                  <div class="col-lg-offset-3 col-lg-10 col-md-10 col-md-offset-3">
                    <br>
                    <br>
                    <br>
                    <input name="submit" value="Submit" type="submit" class="btn btn-success" />
                    <a href="<?= base_url(); ?>credit_app/view/<?php echo $credit_app['id']; ?>" class="btn btn-warning">Cancel</a>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
