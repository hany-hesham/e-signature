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
        <div class="">
          <div class="" style="margin-bottom: 10px;">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px;">
              <div class="page-header">
                <h1 class="centered">Shop Renting Prior Approval</h1>
              </div>
              <?php if(validation_errors() != false): ?>
                <div class="alert alert-danger">
                  <?php echo validation_errors(); ?>
                </div>
              <?php endif ?>         
            </div>
            <div class="container">
              <form action="" method="POST" id="form-submit" enctype="multipart/form-data" class="form-div span12" accept-charset="utf-8">
               <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <br>
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 50px !important;">
                    <br>
                    <input type="hidden" name="shop_id" value="<?php echo $shop['id'] ?>" />
                    <label for="offers" class="col-lg-3 col-md-4 col-sm-5 col-xs-5 control-label">Report Files</label>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                      <input id="offers" name="upload" type="file" class="file" multiple="true" data-show-upload="false" data-show-caption="true">
                    </div>
                    <script>
                      $("#offers").fileinput({
                        uploadUrl: "/shop_renting/upload/<?php echo $shop['id'] ?>",
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
                            {url: "/shop_renting/remove/<?php echo $shop['id'] ?>/<?php echo $upload['id'] ?>", key: "<?php echo $upload['name']; ?>"},
                          <?php endforeach; ?>
                        ],
                      });
                    </script>
                  </div>
                  <div class="form-group">
                    <div class="col-lg-offset-3 col-lg-10 col-md-10 col-md-offset-3">
                      <input name="submit" value="Submit" type="submit" class="btn btn-success" onClick="check();" />
                      <div id="checking" style="display:none;position: fixed;top: 0;left: 0;width: 100%;height: 100%;background: #f4f4f4;z-index: 99;">
                      <div class="text" style="position: absolute;top: 45%;left: 0;height: 100%;width: 100%;font-size: 18px;text-align: center;">
                      <center><img src="<?php echo base_url();?>assets/images/ajax-loader.gif" alt="Loading"></center>
                       Please Wait!<Br><b style="color: red;">few seconds</b>
                      </div>
                      </div>

                      <a href="<?= base_url(); ?>shop_renting/view/<?php echo $shop['id'] ?>" class="btn btn-warning">Cancel</a>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
