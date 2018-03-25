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
              <br>
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px;">
                <div class="page-header">
                  <h1 class="centered">Submit a new Chairman Monthly Report</h1>
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
                      <br>
                      <br>
                      <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:15px;"> Date </label>
                      <div class='input-group date ' id='datetimepicker1' style=" width: 240px;">
                        <input type="text" name="date" class="form-control" /> 
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calender"></span></span>
                      </div>
                    </div>
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12" >
                      <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label" style="margin-top:15px;"> Report Name </label>
                      <input type="text" name="file" class="form-control" style=" width: 240px;"/> 
                    </div>
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12" style="width: 740px;">
                    <input type="hidden" name="assumed_id" value="<?php echo $assumed_id; ?>" />
                    <label for="offers" class="col-lg-3 col-md-4 col-sm-5 col-xs-5 control-label">Report Files</label>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                      <input id="offers" name="upload" type="file" class="file" multiple="true" data-show-upload="false" data-show-caption="true">
                    </div>
                    <script>
                      $("#offers").fileinput({
                        uploadUrl: "/char_report/make_offer/<?php echo $assumed_id; ?>", // server upload action
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
                            {url: "/char_report/remove_offer/<?php echo $assumed_id; ?>/<?php echo $upload['id']; ?>", key: "<?php echo $upload['name']; ?>"},
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
                        <br>
                        <input name="submit" value="Submit" type="submit" class="btn btn-success" />
                        <a href="<?= base_url(); ?>s_rate" class="btn btn-warning">Cancel</a>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
          </div>
          <p>&nbsp &nbsp &nbsp &nbsp &nbsp</p>
        </div>
      </div>
    </div>
    <script type="text/javascript">
        $(function () {
            $('#datetimepicker1').datetimepicker({
                viewMode: 'months',
                minViewMode: "months",
                format: 'MMMM-YYYY'
            });
        });
    </script>
  </body>
</html>
