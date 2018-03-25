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
                <h1 class="centered">Assets Movment Form</h1>
              </div>
              <?php if(validation_errors() != false): ?>
                <div class="alert alert-danger">
                  <?php echo validation_errors(); ?>
                </div>
              <?php endif ?>         
            </div>
            <div class="container">
              <form action="" method="POST" id="form-submit" enctype="multipart/form-data" class="form-div span12" accept-charset="utf-8">
                <div class="col-lg-offset-0 col-lg-4 col-md-4 col-sm-4 col-xs-4">
                  <br>
                  <label for="from-hotel" class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" style="margin-top:5px;"> From Hotel </label>
                  <select class="form-control chooosen" data-placeholder="Hotel ..." name="from_hotel" id="from-hotel" style="width: 200px; height:33px;">
                    <option data-company="0" value="">Select Hotel..</option>
                    <?php foreach ($hotels as $hotel): ?>
                      <option data-company="<?php echo $hotel['company_id']; ?>" value="<?php echo $hotel['id'] ?>"<?php echo set_select('from_hotel',$hotel['id'] ); ?>><?php echo $hotel['name'] ?></option>
                    <?php endforeach ?>
                  </select>
                  <br>
                  <br>
                  <label for="from-company" class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" style="margin-top:5px;"> Owning Co. </label>
                  <select readonly="readonly" class="form-control" data-placeholder="Owning Co ..." name="from_company" id="from-company"  style="width: 200px; height:33px;">
                    <option value=""></option>
                    <?php foreach ($companies as $company): ?>
                      <option value="<?php echo $company['id']; ?>"><?php echo $company['name']; ?></option>
                    <?php endforeach; ?>
                  </select>
                  <br>
                  <br>
                  <label for="to-hotel" class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" style="margin-top:5px;"> Issue Date </label>
                  <div class='input-group date' id='datetimepicker1' style="width: 200px; height:33px;">
                    <input type='text' class="form-control" name="issue_date" value="<?php echo set_value('issue_date'); ?>"/>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
                  <br>
                  <br>
                  <label for="from-hotel" class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" style="margin-top:5px;">Department requested</label>
                  <select class="form-control chooosen" data-placeholder="Department ..." name="department_id" id="department" style="width: 200px; height:33px;">
                    <option value="">Select Department..</option>
                    <?php foreach ($departments as $department): ?>
                      <option value="<?php echo $department['id'] ?>"<?php echo set_select('department_id',$department['id'] ); ?>><?php echo $department['name'] ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="col-lg-offset-0 col-lg-4 col-md-4 col-sm-4 col-xs-4">
                  <br>
                  <label for="to-hotel" class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" style="margin-top:5px;"> To Hotel </label>
                  <select class="form-control chooosen" data-placeholder="Hotel ..." name="to_hotel" id="to-hotel" style="width: 200px; height:33px;">
                    <option data-company="0" value="">Select Hotel..</option>
                    <?php foreach ($hotels as $hotel): ?>
                      <option data-company="<?php echo $hotel['company_id']; ?>" value="<?php echo $hotel['id'] ?>"<?php echo set_select('to_hotel',$hotel['id'] ); ?>><?php echo $hotel['name'] ?></option>
                    <?php endforeach ?>
                  </select>
                  <br>
                  <br>
                  <label for="to-company" class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" style="margin-top:5px;"> Owning Co. </label>
                  <select readonly="readonly" class="form-control" data-placeholder="Owning Co ..." name="to_company" id="to-company"  style="width: 200px; height:33px;">
                    <option value=""></option>
                    <?php foreach ($companies as $company): ?>
                      <option value="<?php echo $company['id']; ?>"><?php echo $company['name']; ?></option>
                    <?php endforeach; ?>
                  </select>
                  <br>
                  <br>
                  <label for="to-hotel" class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" style="margin-top:5px;"> Delivery Date </label>
                  <div class='input-group date' id='datetimepicker2' style="width: 200px; height:33px;">
                    <input type='text' class="form-control" name="delivery_date" value="<?php echo set_value('delivery_date'); ?>"/>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
                </div>
                <div class="form-group col-lg-10 col-md-8 col-sm-10 col-xs-10">
                  <br>
                  <table class="table table-striped table-bordered table-condensed" style="width:730px;">
                    <thead>
                      <tr>
                        <th colspan="1" style=" text-align: center;">#</th>
                        <th colspan="1" style=" text-align: center;">Item Name</th>
                        <th colspan="1" style=" text-align: center;">Description</th>
                        <th colspan="1" style=" text-align: center;">Quantity</th>
                        <th colspan="1" style=" text-align: center;">Attachment</th>
                        <th colspan="1" style=" text-align: center;">actoins</th>
                      </tr>
                    </thead>
                    <tbody id="items-container" data-items="1">
                      <tr id="item-1">
                        <td class="centered"> 
                          <span>1</span>
                        </td>
                        <td class="centered"> 
                          <input type="text" class="form-control" name="items[1][name]"  id="item-1-name" style="width: 150px;"/></input>
                        </td>
                        <td class="centered"> 
                          <textarea class="form-control" name="items[1][description]"  id="item-1-description" rows="3"></textarea> 
                        </td>
                        <td class="centered"> 
                          <input type="number" class="form-control" name="items[1][quantity]"  id="item-1-quantity" style="width: 100px;"/></input>
                        </td>
                        <td class="centered">
                          <input type="file" class="form-control" name="items-1-fille" id="item-1-fille" value="" style="width: 150px;"/>
                        </td>
                        <td class="centered">
                          <span data-item-id="1" class="form-actions btn btn-danger remove-item" style="width: 100px;">Remove</span>
                        </td>
                      </tr>
                    </tbody>
                    <tfoot>
                      <tr>
                        <td colspan="5"></td>
                        <td class="centered">
                          <span class="form-actions btn btn-primary" id="add-item" style="width: 100px;">Add Item</span>
                        </td>
                      </tr>
                    </tfoot>
                  </table>    
                </div>
                <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                  <br>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label" style="margin-top:5px;">Present Location</label>
                  <input type="text" class="form-control" name="present_location" style="width: 250px; height:33px;" value="<?php echo set_value('present_location'); ?>"/></input>
                </div>
                <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                  <br>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label" style="margin-top:5px;">New Location</label>
                  <input type="text" class="form-control" name="new_location" style="width: 250px; height:33px;" value="<?php echo set_value('new_location'); ?>"/></input>
                </div>
                <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                  <br>
                  <label for="from-hotel" class="col-lg-8 col-md-8 col-sm-8 col-xs-8 control-label" style="margin-top:5px;">Reason for movement</label>
                  <textarea class="form-control" name="movement_reason" rows="3" style="width: 650px;"><?php echo set_value('movement_reason'); ?></textarea>
                </div>
                <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                  <br>
                  <label for="from-hotel" class="col-lg-8 col-md-8 col-sm-8 col-xs-8 control-label" style="margin-top:5px;">What Will Happen To Old Item After Movement</label>
                  <textarea class="form-control" name="old_reason" rows="3" style="width: 650px;"><?php echo set_value('old_reason'); ?></textarea>
                </div>
                <div class="form-group col-lg-8 col-md-8 col-sm-8 col-xs-8">
                  <br>
                  <input type="hidden" name="assumed_id" value="<?php echo $assumed_id; ?>" />
                  <label for="offers" class="col-lg-3 col-md-4 col-sm-5 col-xs-5 control-label">Report Files</label>
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <input id="offers" name="upload" type="file" class="file" multiple="true" data-show-upload="false" data-show-caption="true">
                  </div>
                  <script>
                    $("#offers").fileinput({
                      uploadUrl: "/movement/upload/<?php echo $assumed_id; ?>",
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
                          {url: "/movement/remove/<?php echo $assumed_id ?>/<?php echo $upload['id'] ?>", key: "<?php echo $upload['name']; ?>"},
                        <?php endforeach; ?>
                      ],
                    });
                  </script>
                </div>
                <div style="    margin-top: 90px;" class="form-group">
                  <div class="col-lg-offset-3 col-lg-10 col-md-10 col-md-offset-3">
                    <br>
                    <br>
                    <br>
                    <input name="submit" value="Submit" type="submit" class="btn btn-success" />
                    <a href="<?= base_url(); ?>movement/" class="btn btn-warning">Cancel</a>
                  </div>
                </div>
              </form>
            </div>
            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
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
    document.items = <?php echo json_encode($this->input->post('items')); ?>;
  </script>
  <script id="item-template" type="text/x-handlebars-template">
    <tr id="item-{{id}}">
      <td>
        <span>{{id}}</span>
      </td>
      <td class="centered">
        <input type="text" class="form-control" name="items[{{id}}][name]" id="item-{{id}}-name" value="{{name}}" style="width: 150px;"/>  
      </td>
      <td class="centered">
        <textarea type="text" name="items[{{id}}][description]"  id="item-{{id}}-description" class="form-control" rows="3"></textarea>
      </td>
      <td class="centered"> 
        <input type="number" class="form-control" name="items[{{id}}][quantity]" id="item-{{id}}-quantity" value="{{quantity}}" style="width: 100px;"/>  
      </td>
      <td class="centered">
        <input type="file" class="form-control" name="items-{{id}}-fille" id="item-{{id}}-fille" value="" style="width: 150px;"/>
      </td>
      <td class="centered">
        <span data-item-id="{{id}}" class="form-actions btn btn-danger remove-item" style="width: 100px;">Remove</span>
      </td>
    </tr>
  </script>   
</html>
