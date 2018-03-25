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
            <a href="<?php echo base_url(); ?>char_report/submit/" class="btn btn-info">New Chairman Monthly Report</a>
            <br>
            <br>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px;">
                <div class="page-header">
                  <h1 class="centered">Chairman Monthly Report</h1>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px;">
            <?php foreach ($char as $forma ):?>
                <a class="form-actions btn btn-success" href="/char_report/view/<?php echo $forma['id'] ?>" style="margin: 10px;" > <?php echo $forma['date']?> Report </a>
            <?php endforeach; ?>
            </div>
          </div>
          <p>&nbsp &nbsp &nbsp &nbsp &nbsp</p>
        </div>
      </div>
    </div>
  </body>
</html>
