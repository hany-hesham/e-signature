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
                <h1 class="centered">Rate Change Request</h1>
              </div>
              <?php if(validation_errors() != false): ?>
              <div class="alert alert-danger">
                <?php echo validation_errors(); ?>
              </div>
              <?php endif ?>
              <?php if(!isset($contacts)): ?>
              <div class="alert alert-danger">
                <?php echo "No Data For Such Hotel Room!"; ?>
              </div>
              <?php endif ?>            
              </div>
            <div class="container">
              <form action="" method="POST" id="form-submit" enctype="multipart/form-data" class="form-div span12" accept-charset="utf-8">                 <?php foreach($contacts as $contact):?>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;"> Date</label>
                <div class='input-group date' id='datetimepicker1' style=" width: 250px; margin:10px;">
                    <input type='text' class="form-control" name="date"/>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;"> Guest Name </label>
                  <p>
                    <input type="text" name="guest" class="form-control"   value="<?php echo $contact['guest_name']; ?>" style="width: 250px; height:39px;"/>
                  </p>
                  <table class="table table-striped table-bordered table-condensed" style="width: 350px; margin-bottom: 15px;">
                    <thead >
                      <tr>
                        <th colspan="2" style=" text-align: center;">Room</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr >
                        <td style=" text-align: center;"> From </input></td>
                        <td style=" text-align: center;"> TO </input> </td>
                      </tr>
                      <tr>
                        <td style=" text-align: center;"><input type="text" name="room_old" class="form-control" value="<?php echo $change['room_old']; ?>" style=" height:39px;"></input></td>
                        <td style=" text-align: center;"><input type="text" name="room_new" class="form-control" style=" height:39px;"></input></td>
                      </tr>
                    </tbody>
                  </table>
                  <table class="table table-striped table-bordered table-condensed" style="width: 350px; margin-bottom: 15px;">
                    <thead >
                      <tr>
                        <th colspan="3" style=" text-align: center;">Rate</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr >
                        <td style=" text-align: center;"> From </td>
                        <td style=" text-align: center;"> TO </td>
                        <td style=" text-align: center; width: 100px;"> Currency </td>
                      </tr>
                      <tr>
                        <td style=" text-align: center;"><input type="text" name="rate_from" class="form-control" style=" height:39px;"></input></td>
                        <td style=" text-align: center;"><input type="text" name="rate_to" class="form-control" style=" height:39px;"></input></td>
                        <td style=" text-align: center;">
                          <select class="form-control" name="currency" style="height:35px; ">
                            <option>$</option>
                            <option>EGP</option>
                            <option>EURO</option>
                          </select>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <br>
                  <br>
                  <br>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px; width: 80px;"> Remarks </label>
                  <p>
                    <textarea type="text" name="remarks" class="form-control" style=" width: 650px; height:100px;"/></textarea>
                  </p>        
                <?php endforeach ?>

                </div>
                <div style="    margin-top: 90px;" class="form-group">
                  <div class="col-lg-offset-3 col-lg-10 col-md-10 col-md-offset-3">
                    <br>
                    <br>
                    <br>
                    <br>
                    <input name="submit" value="Submit" type="submit" class="btn btn-success" />
                    <a href="<?= base_url(); ?>change" class="btn btn-warning">Cancel</a>
                  </div>
                </div>
              </form>
            </div>
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
    </div>
  </body>
</html>
