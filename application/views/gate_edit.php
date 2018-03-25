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
                <h1 class="centered">Edit Gate Pass Form</h1>
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
                  <br>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin-top:5px;"> Hotel Name </label>
                  <select class="form-control chooosen" data-placeholder="Hotel ..." name="hotel_id" id="from-hotel " style="width: 250px; height:33px;">
                    <option data-company="0" value="<?php echo $gate['hotel_id']; ?>"><?php echo $gate['hotel_name']; ?></option>
                    <?php foreach ($hotels as $hotel): ?>
                      <option value="<?php echo $hotel['id'] ?>"<?php echo set_select('hotel_id',$hotel['id'] ); ?>><?php echo $hotel['name'] ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                  <br>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;">Date and Time</label>
                  <div class='input-group date' id='datetimepicker1' style="width: 250px; height:33px;">
                    <input type='text' class="form-control" name="date" value="<?php echo $gate['date']; ?>" />
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
                </div>
                <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                  <p style="margin-top: 30px;">
                    This is to Authorize the holder of this Gate Pass to leave the Hotel with the following items:
                  </p>
                </div>
                <div class="form-group col-lg-8 col-md-8 col-sm-8 col-xs-8">
                  <br>
                  <table class="table table-striped table-bordered table-condensed">
                    <thead>
                      <tr>
                        <th colspan="1" style=" text-align: center;">Numbur of Items</th>
                        <th colspan="1" style=" text-align: center;">Item</th>
                        <th colspan="1" style=" text-align: center;">Attachment</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($items as $item): ?>
                        <tr>
                          <td class="centered" style="display: none;"> 
                            <input type="number" class="form-control" name="items[<?php echo $item['id']?>][id]" value="<?php echo $item['id']?>" /></input>
                          </td>
                          <td class="centered"> 
                            <input type="number" class="form-control" name="items[<?php echo $item['id']?>][quantity]" value="<?php echo $item['quantity']?>" /></input>
                          </td>
                          <td class="centered"> 
                            <input type="text" class="form-control" name="items[<?php echo $item['id']?>][item]" value="<?php echo $item['item']?>" /></input>
                          </td>
                          <td class="centered">
                            <input type="file" class="form-control" name="items-<?php echo $item['id']?>-fille" value="" style="width: 210px;"/>
                          </td>
                        </tr>
                      <?php endforeach ?>
                    </tbody>
                  </table>    
                </div>
                <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                  <br>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;">Name</label>
                  <input type="text" class="form-control" name="name" value="<?php echo $gate['name']; ?>" style="width: 250px; height:33px;"/></input>
                </div>
                <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                  <br>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;">Position</label>
                  <input type="text" class="form-control" name="position" value="<?php echo $gate['position']; ?>" style="width: 250px; height:33px;"/></input>
                </div>
                <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                  <br>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;"> Department </label>
                  <select class="form-control chooosen" name="department_id" id="from-hotel " data-placeholder="Department ..." style="width: 250px; height:33px;">
                    <option data-company="0" value="<?php echo $gate['department_id']; ?>"><?php echo $gate['department']; ?></option>
                    <?php foreach ($departments as $department): ?>
                      <option value="<?php echo $department['id'] ?>"<?php echo set_select('department_id',$department['id'] ); ?>><?php echo $department['name'] ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                  <br>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;">Reasons</label>
                  <textarea class="form-control" name="reason" style="width: 500px;" rows="3"><?php echo $gate['reason'] ?></textarea>
                </div>
                <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                  <br>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;">Out With</label>
                  <input type="text" class="form-control" name="out_with" value="<?php echo $gate['out_with']; ?>" style="width: 250px; height:33px;"/></input>
                </div>
                <div class="form-group col-lg-8 col-md-8 col-sm-8 col-xs-8">
                  <br>
                  <input type="hidden" name="gate_id" value="<?php echo $gate['id']; ?>" />
                  <label for="offers" class="col-lg-3 col-md-4 col-sm-5 col-xs-5 control-label">Report Files</label>
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <input id="offers" name="upload" type="file" class="file" multiple="true" data-show-upload="false" data-show-caption="true">
                  </div>
                  <script>
                    $("#offers").fileinput({
                      uploadUrl: "/gate/upload/<?php echo $gate['id']; ?>",
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
                          {url: "/gate/remove/<?php echo $gate['id']; ?>/<?php echo $upload['id'] ?>", key: "<?php echo $upload['name']; ?>"},
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
                    <a href="<?= base_url(); ?>gate/view/<?php echo $gate['id']; ?>" class="btn btn-warning">Cancel</a>
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
    $(function () {
      $('#datetimepicker1').datetimepicker({
        format: 'YYYY-MM-DD hh:mm:ss'
      });
    });
  </script>  
  <script type="text/javascript">
    document.items = <?php echo json_encode($this->input->post('items')); ?>;
  </script>
</html>
