<!DOCTYPE html>
<html lang="en">
  <head>
    <script type="text/javascript">
           function check()
           {
             $("#checking").show();
           }
       </script>
    <?php $this->load->view('header'); ?>
  </head>
  <body>
    <div id="wrapper">
      <?php $this->load->view('menu') ?>
      <div id="page-wrapper">
        <div class="container">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <fieldset>
              <legend>Edit Rent Adjustment</legend>
              <?php if(validation_errors() != false): ?>
              <div class="alert alert-danger">
                <?php echo validation_errors(); ?>
              </div>
              <?php endif ?>
              <form action="" method="POST" id="form-submit" enctype="multipart/form-data" class="form-div span12" accept-charset="utf-8">
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;">New Amount of rent</label>
                  <p>
                    <input type="text" name="new_rent" class="form-control" style="height:38px; width: 240px;" class="form-control" 
                           value="<?php echo $shop_adjust['new_rent']?>" />
                  </p>
                  <label  class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;"> From date </label>
                     <div class='input-group date' id='datetimepicker10' style=" width: 240px; margin:10px;">
                       <input type="text" name="from_date" class="form-control" value="<?php echo $shop_adjust['from_date']?>"/> 
                       <span class="input-group-addon"><span class="glyphicon glyphicon-calender"></span></span>
                     </div>
                    <br> 
                   <label  class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;"> Till date </label>
                     <div class='input-group date' id='datetimepicker11' style=" width: 240px; margin:10px;">
                       <input type="text" name="to_date" class="form-control" value="<?php echo $shop_adjust['to_date']?>" /> 
                       <span class="input-group-addon"><span class="glyphicon glyphicon-calender"></span></span>
                     </div>
                     <br>
                    <label  class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;">Effective Date of adjustment </label>
                     <div class='input-group date' id='datetimepicker12' style=" width: 240px; margin:10px;">
                       <input type="text" name="effective_date" class="form-control" value="<?php echo $shop_adjust['effective_date']?>" /> 
                       <span class="input-group-addon"><span class="glyphicon glyphicon-calender"></span></span>
                     </div>     
                  <br>
                  <br>    
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <input type="hidden" name="shop_adjustment_id" value="<?php echo $shop_adjust['id']; ?>" />
                      <label for="offers" class="col-lg-3 col-md-4 col-sm-5 col-xs-5 control-label">Report Files</label>
                      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <input id="offers" name="upload" type="file" class="file" multiple="true" data-show-upload="false" data-show-caption="true">
                      </div>
                      <script>
                      $("#offers").fileinput({
                          uploadUrl: "/shop_adjust/upload/<?php echo $shop_adjust['id']; ?>", // server upload action
                          uploadAsync: true,
                          minFileCount: 1,
                          maxFileCount: 5,
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
                              {url: "/shop_adjust/remove/<?php echo $shop_adjust['id'] ?>/<?php echo $upload['id'] ?>", key: "<?php echo $upload['name']; ?>"},
                          <?php endforeach; ?>
                          ],
                      });
                      </script>
                  </div> 
                </div>
                <div style="    margin-top: 90px;" class="form-group">
                  <div class="col-lg-offset-3 col-lg-10 col-md-10 col-md-offset-3">
                   <input name="submit" value="Submit" type="submit" class="btn btn-success" onClick="check();" />
                        <div id="checking" style="display:none;position: fixed;top: 0;left: 0;width: 100%;height: 100%;background: #f4f4f4;z-index: 99;">
                          <div class="text" style="position: absolute;top: 45%;left: 0;height: 100%;width: 100%;font-size: 18px;text-align: center;">
                              <center><img src="<?php echo base_url();?>assets/images/ajax-loader.gif" alt="Loading"></center>
                               Please Wait!<Br><b style="color: red;">few seconds</b>
                          </div>
                        </div>
                    <a href="<?= base_url(); ?>shop_adjust" class="btn btn-warning">Cancel</a>
                  </div>
                </div>
              </form>
            </fieldset>
          </div>
        </div>
      </div>
    </div>
    <script type="text/javascript">
     $(function () {
        $('#datetimepicker10').datetimepicker({
          format: 'DD/MM/YYYY'
        });
      });
    </script>
    <script type="text/javascript">
      $(function () {
        $('#datetimepicker11').datetimepicker({
          format: 'DD/MM/YYYY'
        });
      });
    </script>
     <script type="text/javascript">
       $(function () {
        $('#datetimepicker12').datetimepicker({
          format: 'DD/MM/YYYY'
        });
      });
    </script>
  </body>
</html>
