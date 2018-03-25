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
            <div class="header-logo"><img src="/assets/uploads/logos/<?php echo $settlement['logo']; ?>"/></div>
            <h1 class="centered"><?php echo $settlement['hotel_name']; ?></h1>
            <fieldset>
              <legend class="centered">Submit a Purpose of Report for Settlement Form No. #<?php echo $settlement['id']?> </legend>
              <?php if(validation_errors() != false): ?>
              <div class="alert alert-danger">
                <?php echo validation_errors(); ?>
              </div>
              <?php endif ?>
              <form action="" method="POST" id="form-submit" enctype="multipart/form-data" class="form-div span12" accept-charset="utf-8">
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px; width: 180px;"> Date </label>
                  <div class='input-group date' id='datetimepicker1' style=" width: 240px; ">
                    <input type="text" name="date" class="form-control" value="<?php echo $purpose['date']; ?>" /> 
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calender"></span></span>
                  </div>
                  <label for="from-type" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:30px; width: 180px;"> Case Type </label>
                  <select class="form-control" name="type" id="from-type " style=" width: 240px; margin:20px;">
                    <option data-company="0" value="<?php echo $purpose['type']; ?>"><?php echo ($purpose['type'] == '1')? 'employees negligence' : 'Normal Cases'?></option>
                    <option data-company="0" value="1">employees negligence</option>
                    <option data-company="0" value="2">Normal Cases</option>
                  </select>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="width: 180px;"> Reason of settlement  </label>
                  <textarea type="text" name="set" class="form-control" style="width:700px; height:100px;"><?php echo $purpose['set']; ?></textarea>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style ="margin-top:20px; width: 180px;"> Name of the in charged employee   </label>
                  <input type="text" name="charged" class="form-control" value="<?php echo $purpose['charged']; ?>" style=" width: 240px; margin:20px;" class="form-control"/>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="width: 180px;"> Position of the in charged employee  </label>
                  <input type="text" name="position" class="form-control" value="<?php echo $purpose['position']; ?>" style=" width: 240px; margin:20px;" class="form-control"/>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px; width: 180px;"> Date of accident </label>
                  <div class='input-group date' id='datetimepicker2' style=" width: 240px; ">
                    <input type="text" name="accident" class="form-control" value="<?php echo $purpose['accident']; ?>" /> 
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calender"></span></span>
                  </div>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style ="margin-top:25px; width: 180px;"> Area of the accident </label>
                  <input type="text" name="area" class="form-control" style=" width: 240px; margin:20px;" value="<?php echo $purpose['area']; ?>" class="form-control"/>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style ="width: 180px;"> The reason of the accident </label>
                  <textarea type="text" name="reason" class="form-control" style="width:700px; height:100px;"><?php echo $purpose['reason']; ?></textarea>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style ="margin-top:20px; width: 180px;"> Amount of the settlement </label>
                  <input type="text" name="amount" class="form-control" style=" width: 240px; margin:20px;" value="<?php echo $purpose['amount']; ?>" class="form-control"/>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style ="width: 180px;"> Penalty</label>
                  <input type="text" name="penalty" class="form-control" style=" width: 240px; margin:20px;" value="<?php echo $purpose['penalty']; ?>" class="form-control"/>
                </div>
                <div style="    margin-top: 90px;" class="form-group">
                  <div class="col-lg-offset-3 col-lg-10 col-md-10 col-md-offset-3">
                    <input name="submit" value="Submit" type="submit" class="btn btn-success" />
                    <a href="<?= base_url(); ?>settlement" class="btn btn-warning">Cancel</a>
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
    <script type="text/javascript">
      $(function(){
        $('#datetimepicker2').datetimepicker({
          viewMode:'days',
          format:'DD/MM/YYYY'
        });
      });
    </script>
  </body>
</html>
