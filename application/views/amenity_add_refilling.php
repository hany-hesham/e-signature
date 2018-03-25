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
                    <?php for ($i=0; $i < $items[0]['refiling'] ; $i++) { ?>
                      <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                        <br>
                        <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;"> Delivery Date and Time </label>
                        <input type="datetime" class="form-control" name="refls[<?php echo $i?>][date_time]" style="width: 250px; height:33px;" value="2017-01-01 00:00:00">
                        (ex. 2017-01-01 00:00:00)
                      </div>
                      <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                        <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;"> Others </label>
                        <div class="col-lg-offset-0 col-lg-10 col-md-8 col-md-offset-3" style="width: 600px;">
                          <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                            <input type="checkbox" name="refls[<?php echo $i?>][cookies]" value="1">Cookies &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="checkbox" name="refls[<?php echo $i?>][nuts]" value="1">Nuts &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="checkbox" name="refls[<?php echo $i?>][wine]" value="1">Bottle Of Wine
                          </div>
                          <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                            <input type="checkbox" name="refls[<?php echo $i?>][fruit]" value="1">Fruit Basket &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="checkbox" name="refls[<?php echo $i?>][beer]" value="1">Beer &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="checkbox" name="refls[<?php echo $i?>][cake]" value="1">Birthday Cake
                          </div>
                          <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                            <input type="checkbox" name="refls[<?php echo $i?>][anniversary]" value="1">Anniversary &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="checkbox" name="refls[<?php echo $i?>][honeymoon]" value="1">Honeymoon &nbsp;&nbsp;&nbsp;
                            <input type="checkbox" name="refls[<?php echo $i?>][juices]" value="1">Small Can of Juices
                          </div>
                          <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                            <input type="checkbox" name="refls[<?php echo $i?>][dinner]" value="1">Candel Light Dinner &nbsp;&nbsp;&nbsp;
                            <input type="checkbox" name="refls[<?php echo $i?>][sick]" value="1">Sick Meal &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="checkbox" name="refls[<?php echo $i?>][alcohol]" value="1"> Without Alcohol
                          </div>
                          <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                            <input type="checkbox" name="refls[<?php echo $i?>][th]" value="1"> TH Bonus &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="checkbox" name="refls[<?php echo $i?>][uk]" value="1"> TC UK arrival &nbsp;
                            <input type="checkbox" name="refls[<?php echo $i?>][chocolate]" value="1"> Chocolate
                          </div>
                          <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                            <input type="checkbox" name="refls[<?php echo $i?>][milk]" value="1"> Milk
                          </div>
                        </div>
                      </div>
                    <?php } ?>
                  </div>
                <div style="    margin-top: 90px;" class="form-group">
                  <div class="col-lg-offset-3 col-lg-10 col-md-10 col-md-offset-3">
                    <br>
                    <br>
                    <br>
                    <br>
                    <input name="submit" value="Submit" type="submit" class="btn btn-success" />
                    <a href="<?= base_url(); ?>amenity/view/<?php echo $items[0]['amen_id'] ?>" class="btn btn-warning">Cancel</a>
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
  </body>
</html>
