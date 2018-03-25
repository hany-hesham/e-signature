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
                <h1 class="centered">Edit Payment Plan Form No. #<?php echo $transfer['id'] ?></h1>
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
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;">التاريخ</label>
                  <div class='input-group date' id='datetimepicker1' style="width: 250px; height:33px;">
                    <input type='text' class="form-control" name="date" value="<?php echo $transfer['date'] ?>" />
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
                </div>
                <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                  <br>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;">الحساب المحول</label>
                  <input type="text" class="form-control" name="from_acc" value="<?php echo $transfer['from_acc'] ?>" style="width: 250px; height:33px;"/></input>
                </div>
                <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                  <br>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;">الحساب المحول إليه</label>
                  <input type="text" class="form-control" name="to_acc" value="<?php echo $transfer['to_acc'] ?>" style="width: 250px; height:33px;"/></input>
                </div>
                <div class="form-group col-lg-10 col-md-10 col-sm-10 col-xs-10">
                  <br>
                  <table class="table table-striped table-bordered table-condensed" style="width:740px;">
                    <thead>
                      <tr>
                        <th colspan="1" style=" text-align: center;">البيــــــــــــــــــــــــــان</th>
                        <th colspan="1" style=" text-align: center;">الادارة</th>
                        <th colspan="1" style=" text-align: center;">القيمة بالجنية</th>
                        <th colspan="1" style=" text-align: center;">القيمة بالدولار</th>
                        <th colspan="1" style=" text-align: center;">ملاحظات </th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($items as $item): ?>
                        <tr>
                          <td style="display: none;"> 
                            <input type="text" name="items[<?php echo $item['id'] ?>][id]" value="<?php echo $item['id'] ?>"/></input>
                          </td>
                          <td class="centered"> 
                            <input type="text" class="form-control" name="items[<?php echo $item['id'] ?>][name]" value="<?php echo $item['name'] ?>"/></input>
                          </td>
                          <td class="centered"> 
                            <select class="form-control" name="items[<?php echo $item['id'] ?>][department_id]" data-placeholder="الادارة ...">
                              <option data-company="0" value="<?php echo $item['department_id'] ?>"><?php echo $item['department'] ?></option>
                              <?php foreach ($departments as $department): ?>
                                <option value="<?php echo $department['id'] ?>"<?php echo set_select('department_id',$department['id'] ); ?>><?php echo $department['name'] ?></option>
                              <?php endforeach ?>
                            </select>
                          </td>
                          <td class="centered"> 
                            <input type="number" class="form-control" name="items[<?php echo $item['id'] ?>][eg_value]" value="<?php echo $item['eg_value'] ?>" /></input>
                          </td>
                          <td class="centered"> 
                            <input type="number" class="form-control" name="items[<?php echo $item['id'] ?>][usd_value]" value="<?php echo $item['usd_value'] ?>"/></input>
                          </td>
                          <td class="centered"> 
                            <textarea class="form-control" name="items[<?php echo $item['id'] ?>][remarks]"><?php echo $item['remarks'] ?></textarea> 
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                          <td colspan="4"></td>
                          <td class="centered">
                            <a href="<?= base_url(); ?>transfer/submit_edit/<?php echo $transfer['id'] ?>" class="btn btn-warning">إضافة بيان</a>
                          </td>
                        </tr>
                      </tfoot>
                  </table>    
                </div>
                <div class="form-group col-lg-8 col-md-8 col-sm-8 col-xs-8">
                  <br>
                  <input type="hidden" name="tran_id" value="<?php echo $transfer['id']; ?>" />
                  <label for="offers" class="col-lg-3 col-md-4 col-sm-5 col-xs-5 control-label">Report Files</label>
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <input id="offers" name="upload" type="file" class="file" multiple="true" data-show-upload="false" data-show-caption="true">
                  </div>
                  <script>
                    $("#offers").fileinput({
                      uploadUrl: "/transfer/upload/<?php echo $transfer['id']; ?>",
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
                          {url: "/transfer/remove/<?php echo $transfer['id'] ?>/<?php echo $upload['id'] ?>", key: "<?php echo $upload['name']; ?>"},
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
                    <a href="<?= base_url(); ?>transfer/view/<?php echo $transfer['id'] ?>" class="btn btn-warning">Cancel</a>
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
        format: 'DD/MM/YYYY'
      });
    });
  </script>  
  <script type="text/javascript">
    document.items = <?php echo json_encode($this->input->post('items')); ?>;
  </script>   
</html>
