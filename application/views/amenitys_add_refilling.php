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
                <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                  <?php for ($i=1; $i <= $amenity['refiling'] ; $i++) { ?>
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                      <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin-top:5px;"> Date and Time of Delivery </label>
                      <div class='input-group date' id='datetimepicker<?php echo $i?>' style="width: 250px;">
                        <input type='text' class="form-control" name="refls[<?php echo $i?>][date_time]"/>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                      </div>
                    </div>
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                      <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin-top:5px;"> Others Amenities </label>
                      <select class="form-control chooosen" name="refls[<?php echo $i?>][otherss][]" id="otherss" multiple="multiple" data-placeholder="Others Amenities ..." style="width: 500px;">
                        <option></option>
                        <?php foreach ($others as $other): ?>
                          <option value="<?php echo $other['id'] ?>"<?php echo set_select('otherss',$other['id'] ); ?>><?php echo $other['name'] ?></option>
                        <?php endforeach ?>
                      </select>
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
      document.refls = <?php echo json_encode($this->input->post('refls')); ?>;
    </script>  
    <?php for ($i=1; $i <= $amenity['refiling'] ; $i++) { ?>
      <script type="text/javascript">
        $(function () {
          $('#datetimepicker<?php echo $i?>').datetimepicker({
            format: 'YYYY-MM-DD hh:mm a'
          });
        });
      </script> 
    <?php } ?>
    <script type = "text/javascript" >
         function preventBack(){window.history.forward();}
          setTimeout("preventBack()", 0);
          window.onunload=function(){null};
      </script>
  </body>
</html>
