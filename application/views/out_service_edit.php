<?php 
  function array_assoc_value_exists($arr, $index, $search) {
    foreach ($arr as $key => $value) {
      if ($value[$index] == $search) {
        return TRUE;
      }
    }
    return FALSE;
  }
?>
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
                <h1 class="centered">نموذج تكهين<span>No. #<?php echo $out_service['id']; ?></span></h1>
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
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;"> Hotel Name </label>
                  <select class="form-control chooosen" data-placeholder="Hotel ..." name="hotel_id" id="from-hotel " style="width: 250px; height:33px;">
                    <option data-company="0" value="<?php echo $out_service['hotel_id']; ?>"><?php echo $out_service['hotel_name']; ?></option>
                    <?php foreach ($hotels as $hotel): ?>
                      <option value="<?php echo $hotel['id'] ?>"<?php echo set_select('hotel_id',$hotel['id'] ); ?>><?php echo $hotel['name'] ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                  <br>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;">Date and Time</label>
                  <div class='input-group date' id='datetimepicker1' style="width: 250px; height:33px;">
                    <input type='text' class="form-control" name="date" value="<?php echo $out_service['date']; ?>" />
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
                </div>
                <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                  <br>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;"> Department </label>
                  <select class="form-control chooosen" name="department_id" id="from-hotel " data-placeholder="Department ..." style="width: 250px; height:33px;">
                    <option data-company="0" value="<?php echo $out_service['department_id']; ?>"><?php echo $out_service['department']; ?></option>
                    <?php foreach ($departments as $department): ?>
                      <option value="<?php echo $department['id'] ?>"<?php echo set_select('department_id',$department['id'] ); ?>><?php echo $department['name'] ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="form-group col-lg-8 col-md-8 col-sm-8 col-xs-8">
                  <br>
                  <table class="table table-striped table-bordered table-condensed">
                    <thead>
                      <tr>
                        <th colspan="1" style=" text-align: center;">#</th>
                        <th colspan="1" style=" text-align: center;">Numbur of Items</th>
                        <th colspan="1" style=" text-align: center;">Description</th>
                        <th colspan="1" style=" text-align: center;">Serial Number</th>
                        <th colspan="1" style=" text-align: center;">Reason</th>
                        <th colspan="1" style=" text-align: center;">Attachment</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $count = 1; ?>
                      <?php foreach ($items as $item): ?>
                        <tr>
                          <td class="centered"><?php echo $count; ?></td>
                          <td class="centered" style="display: none;"> 
                            <input type="number" class="form-control" name="items[<?php echo $item['id']?>][id]" value="<?php echo $item['id']?>" /></input>
                          </td>
                          <td class="centered"> 
                            <input type="number" class="form-control" name="items[<?php echo $item['id']?>][quantity]" value="<?php echo $item['quantity']?>" /></input>
                          </td>
                          <td class="centered"> 
                            <input type="text" class="form-control" name="items[<?php echo $item['id']?>][description]" value="<?php echo $item['description']?>" /></input>
                          </td>
                          <td class="centered"> 
                            <input type="text" class="form-control" name="items[<?php echo $item['id']?>][serial_number]" value="<?php echo $item['serial_number']?>" /></input>
                          </td>
                          <td class="centered"> 
                            <textarea class="form-control" name="items[<?php echo $item['id']?>][reason]"><?php echo $item['reason']?></textarea> 
                          </td>
                          <td class="centered">
                            <input type="file" class="form-control" name="items-<?php echo $item['id']?>-fille" value="" style="width: 210px;"/>
                          </td>
                        </tr>
                        <?php $count++; ?>
                      <?php endforeach ?>
                    </tbody>
                  </table>    
                </div>
                <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                  <br>
                  <label for="from-hotel" class="col-lg-4 col-md-4 col-sm-4 col-xs-4  control-label " style="margin-top:5px;">Where Does It Go?</label>
                  <select class="form-control" name="reason" id="reasons" style="width: 250px; height:33px;">
                    <option value="<?php echo $out_service['reason'] ?>"><?php echo $out_service['reason_name'] ?></option>
                    <option> Where Dose It Go ...</option>
                    <?php foreach ($reasons as $reason): ?>
                      <option value="<?php echo $reason['id'] ?>" <?php echo set_select('reason',$reason['id'] ); ?>><?php echo $reason['name'] ?></option>
                    <?php endforeach ?>
                  </select>
                  <br>
                  <select class="form-control" name="sister_id" id="sister" style="margin-left: 305px; width: 250px !important; height:33px; display: <?php if ($out_service['reason']!=4):?>none;<?php endif;?>">
                    <option value="<?php echo $out_service['sister_id'] ?>"><?php echo $out_service['sister_name'] ?></option>
                    <option> Hotel Name ...</option>
                    <?php foreach ($hotels as $hotel): ?>
                      <option value="<?php echo $hotel['id'] ?>"<?php echo set_select('sister_id',$hotel['id'] ); ?>><?php echo $hotel['name'] ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="form-group col-lg-8 col-md-8 col-sm-8 col-xs-8">
                  <br>
                  <input type="hidden" name="out_id" value="<?php echo $out_service['id']; ?>" />
                  <label for="offers" class="col-lg-3 col-md-4 col-sm-5 col-xs-5 control-label">Report Files</label>
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <input id="offers" name="upload" type="file" class="file" multiple="true" data-show-upload="false" data-show-caption="true">
                  </div>
                  <script>
                    $("#offers").fileinput({
                      uploadUrl: "/out_service/upload/<?php echo $out_service['id']; ?>",
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
                          {url: "/out_service/remove/<?php echo $out_service['id']; ?>/<?php echo $upload['id'] ?>", key: "<?php echo $upload['name']; ?>"},
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
                    <a href="<?= base_url(); ?>out_service/view/<?php echo $out_service['id']; ?>" class="btn btn-warning">Cancel</a>
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
      var select = document.getElementById('sister');
      var input = document.getElementById('reasons');
      input.addEventListener('change', function () {
      if (input.value == '4') {
        select.style.display = 'block';
      } else {
        select.style.display = 'none';
      }
    });
  </script> 
  <script type="text/javascript">
    $(function () {
      $('#datetimepicker1').datetimepicker({
        format: 'YYYY-MM-DD'
      });
    });
  </script>  
  <script type="text/javascript">
    document.items = <?php echo json_encode($this->input->post('items')); ?>;
  </script>  
</html>
