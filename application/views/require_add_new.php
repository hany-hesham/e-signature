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
                <h1 class="centered"> Vacant Position Replay </h1>
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
                    <table class="table table-striped table-bordered table-condensed" style="width: 700px;">
                      <thead>
                        <tr>
                          <th colspan="1" style=" text-align: center;">Employee Name</th>
                          <th colspan="1" style=" text-align: center;">Employee Position</th>
                          <th colspan="1" style=" text-align: center;">Hotel Name</th>
                          <th colspan="1" style=" text-align: center;">actoins</th>
                        </tr>
                      </thead>
                      <tbody id="items-container" data-items="1">
                        <tr id="item-1">
                          <td class="centered"> 
                            <input type="text" class="form-control" name="requires[1][name]"  id="item-1-name"/></input>
                          </td>
                          <td class="centered"> 
                            <input type="text" class="form-control" name="requires[1][position]"  id="item-1-position"/></input>
                          </td>
                          <td class="centered"> 
                          <select class="form-control" name="requires[1][hotel_id]" id="item-1-hotel_id">
                              <option data-company="0" value="">Select Hotel..</option>
                              <?php foreach ($hotels as $hotel): ?>
                                <option value="<?php echo $hotel['id'] ?>"<?php echo set_select('hotel_id',$hotel['id'] ); ?>><?php echo $hotel['name'] ?></option>
                              <?php endforeach ?>
                            </select>
                          </td>
                          <td class="centered">
                            <span data-item-id="1" class="form-actions btn btn-danger remove-item" style="width: 100px;">Remove</span>
                          </td>
                        </tr>
                      </tbody>
                      <tfoot>
                        <tr>
                          <td colspan="3"></td>
                          <td class="centered">
                            <span class="form-actions btn btn-primary" id="add-item" style="width: 100px;">Add Employee</span>
                          </td>
                        </tr>
                      </tfoot>
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
      document.items = <?php echo json_encode($this->input->post('requires')); ?>;
    </script>
    <script id="item-template" type="text/x-handlebars-template">
      <tr id="item-{{id}}">
        <td class="centered"> 
          <input type="text" class="form-control" name="requires[{{id}}][name]"  id="item-{{id}}-name"/></input>
        </td>
        <td class="centered"> 
          <input type="text" class="form-control" name="requires[{{id}}][position]"  id="item-{{id}}-position"/></input>
        </td>
        <td class="centered"> 
        <select class="form-control" name="requires[{{id}}][hotel_id]" id="item-{{id}}-hotel_id">
            <option data-company="0" value="">Select Hotel..</option>
            <?php foreach ($hotels as $hotel): ?>
              <option value="<?php echo $hotel['id'] ?>"<?php echo set_select('hotel_id',$hotel['id'] ); ?>><?php echo $hotel['name'] ?></option>
            <?php endforeach ?>
          </select>
        </td>
        <td class="centered">
          <span data-item-id="{{id}}" class="form-actions btn btn-danger remove-item" style="width: 100px;">Remove</span>
        </td>
      </tr>
    </script>
  </body>
</html>
