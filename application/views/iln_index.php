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
            <a href="<?php echo base_url(); ?>illness/submit/" class="btn btn-info">New Illness Log Form</a>
            <a class="form-actions btn btn-success non-printable" href="/quality" style="float:right;" > Back To Quality</a>
            <br>
            <br>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px;">
                <div class="page-header">
                  <h1 class="centered">Daily Illness Log Forms</h1>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px;">
            <?php foreach ($count as $key => $date) : ?>
                <a class="form-actions btn btn-success" href="/illness/index_month/<?php echo $key ?>" style="margin: 10px;" > <?php echo $key?> Illness Log </a>
            <?php endforeach; ?>
            </div>
          </div>
          <p>&nbsp &nbsp &nbsp &nbsp &nbsp</p>
        </div>
      </div>
    </div>
  </body>
</html>
