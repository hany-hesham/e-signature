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
                <h1 class="centered"> Edit Hiring Position Request No. #<?php echo $position['id']; ?></h1>
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
                    <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label" style="margin-top:5px;"> Hotel Name </label>
                    <select class="form-control" name="hotel_id" id="from-hotel " style="width: 240px; height:34px;">
                      <option data-company="0" value="<?php echo $position['hotel_id'] ?>"><?php echo $position['hotel_name'] ?></option>
                      <?php foreach ($hotels as $hotel): ?>
                        <option value="<?php echo $hotel['id'] ?>"<?php echo set_select('hotel_id',$hotel['id'] ); ?>><?php echo $hotel['name'] ?></option>
                      <?php endforeach ?>
                    </select>
                    </div>
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label" style="margin-top:5px;"> Date </label>
                    <div class='input-group date' id='datetimepicker1' style=" width: 240px;">
                      <input type='text' class="form-control" name="date" value="<?php echo $position['date'] ?>" />
                      <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                  </div>
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <table class="table table-striped table-bordered table-condensed" style="width: 650px;">
                      <thead>
                        <tr>
                          <th rowspan="2" colspan="1" style=" text-align: center;">Requested Positions</th>
                          <th rowspan="1" colspan="3" style=" text-align: center;">Salary Scale</th>
                          <th rowspan="2" colspan="1" style=" text-align: center;">Level</th>
                        </tr>
                        <tr>
                          <th rowspan="1" colspan="1" style=" text-align: center;">Min</th>
                          <th rowspan="1" colspan="1" style=" text-align: center;">Avarge</th>
                          <th rowspan="1" colspan="1" style=" text-align: center;">Max</th>
                        </tr>
                      </thead>
                      <tbody id="items-container" data-items="1">
                        <?php foreach ($requests as $request): ?>
                          <tr id="item-1">
                            <td class="centered" style="display: none">
                              <input class="form-control" name="requests[<?php echo $request['id']?>][id]" value="<?php echo $request['id']?>">
                            </td>
                            <td class="centered"> 
                              <input type="text" class="form-control" name="requests[<?php echo $request['id']?>][position]"  value="<?php echo $request['position']?>" style="width: 200px;"/></input>
                            </td>
                            <td class="centered" style="width: 120px;"> 
                              <input type="text" class="form-control" name="requests[<?php echo $request['id']?>][froms]"  value="<?php echo $request['froms']?>"/></input>
                            </td>
                            <td class="centered" style="width: 120px;"> 
                              <input type="text" class="form-control" name="requests[<?php echo $request['id']?>][avrg]"  value="<?php echo $request['tos']?>"/></input>
                            </td>
                            <td class="centered" style="width: 120px;"> 
                              <input type="text" class="form-control" name="requests[<?php echo $request['id']?>][tos]"  value="<?php echo $request['tos']?>"/></input>
                            </td>
                            <td class="centered" style="width: 80px;"> 
                              <input type="text" class="form-control" name="requests[<?php echo $request['id']?>][level]"  value="<?php echo $request['level']?>"/></input>
                            </td>
                          </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="col-lg-offset-3 col-lg-10 col-md-10 col-md-offset-3">
                  <br>
                  <br>
                  <input name="submit" value="Submit" type="submit" class="btn btn-success"/>
                  <a href="<?= base_url(); ?>position" class="btn btn-warning">Cancel</a>
                  <br>
                  <br>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script type="text/javascript">
      document.items = <?php echo json_encode($this->input->post('requests')); ?>;
    </script>
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
        
      