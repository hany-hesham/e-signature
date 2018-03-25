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
                <h1 class="centered">Local Market Rates</h1>
              </div>
              <?php if(validation_errors() != false): ?>
                <div class="alert alert-danger">
                  <?php echo validation_errors(); ?>
                </div>
              <?php endif ?>         
            </div>
            <div class="container">
              <form action="" method="POST" id="form-submit" enctype="multipart/form-data" class="form-div span12" accept-charset="utf-8">
                <div class="form-group col-lg-8 col-md-8 col-sm-8 col-xs-8">
                  <br>
                  <table class="table table-striped table-bordered table-condensed"> 
                    <thead>
                      <tr>
                        <th colspan="3" style=" text-align: center;"> Different Periods </th>
                      </tr>
                      <tr>
                        <th colspan="1" style=" text-align: center;">From</th>
                        <th colspan="1" style=" text-align: center;">To</th>
                        <th colspan="1" style=" text-align: center;">actoins</th>
                      </tr>
                    </thead>
                    <tbody id="items-container" data-items="1">
                      <tr id="item-1">
                        <td class="centered"> 
                          <input type="date" class="form-control" name="different[1][from_date]"  id="item-1-from_date"/></input>
                        </td>
                        <td class="centered"> 
                          <input type="date" class="form-control" name="different[1][to_date]"  id="item-1-to_date"/></input>
                        </td>
                        <td class="centered">
                          <span data-item-id="1" class="form-actions btn btn-danger remove-item" style="width: 100px;">Remove</span>
                        </td>
                      </tr>
                    </tbody>
                    <tfoot>
                      <tr>
                        <td colspan="2"></td>
                        <td class="centered">
                          <span class="form-actions btn btn-primary" id="add-item" style="width: 100px;">Add Period</span>
                        </td>
                      </tr>
                    </tfoot>
                  </table>    
                </div>
                <div class="form-group col-lg-8 col-md-8 col-sm-8 col-xs-8">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin-top:5px;"> Hotels Name </label>
                  <select class="form-control chooosen" name="hotel[]" id="hotel" multiple="multiple" data-placeholder="Hotels Name...">
                    <?php foreach ($hotels as $hotel): ?>
                      <option value="<?php echo $hotel['id'] ?>" <?php echo set_select('hotel',$hotel['id'] ); ?>><?php echo $hotel['name'] ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
                <div style="    margin-top: 90px;" class="form-group">
                  <div class="col-lg-offset-3 col-lg-10 col-md-10 col-md-offset-3">
                    <br>
                    <br>
                    <br>
                    <input name="submit" value="Submit" type="submit" class="btn btn-success" />
                    <a href="<?= base_url(); ?>market/" class="btn btn-warning">Cancel</a>
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
    document.different = <?php echo json_encode($this->input->post('different')); ?>;
  </script>
  <script id="item-template" type="text/x-handlebars-template">
    <tr id="item-{{id}}">
      <td class="centered">
        <input type="date" class="form-control" name="different[{{id}}][from_date]" id="item-{{id}}-from_date" value="{{from_date}}"/>  
      </td>
        <td class="centered"> 
          <input type="date" class="form-control" name="different[{{id}}][to_date]" id="item-{{id}}-to_date" value="{{to_date}}"/>  
        </td>
        <td class="centered">
          <span data-item-id="{{id}}" class="form-actions btn btn-danger remove-item" style="width: 100px;">Remove</span>
        </td>
      </tr>
    </script>   
</html>
