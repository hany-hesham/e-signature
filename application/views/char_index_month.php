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
            <a href="<?php echo base_url(); ?>char_report/submit/" class="btn btn-info">New Chairman Monthly Report </a>
            <a class="form-actions btn btn-info non-printable" href="/char_report/mailmeall/<?php echo $date ?>" style="float:right; margin-left: 20px;" > <img src="/assets/images/letter.png" style="width: 28px; height: 40px; margin: 0px; margin-left: -10px; margin-top: -10px; margin-bottom: -10px;"> Share by Email </a>
            <a data-text="whatsapp" data-link="<?php echo base_url(); ?>char_report/index_month/<?php echo $date ?>" style="float:right; margin-left: 20px;" class="whatsapp whatsapp_btn whatsapp_btn_small form-actions btn btn-success non-printable"> <img src="/assets/images/original.png" style="width: 70px; height: 50px; margin: -20px; margin-left: -30px; margin-top: -21px;"> Share by Whatsapp</a>
            <br>
            <br>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px;">
                <div class="page-header">
                  <h1 class="centered">Chairman Monthly Report  For <?php echo $date ?></h1>
                  <br>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px;">
              <?php foreach($char as $forma ){?>
                <a class="form-actions btn btn-success" href="/char_report/view/<?php echo $forma['id'] ?>" style="margin: 10px;" > <?php echo $forma['file'] ?> Report </a>
              <?php } ?>
            </div>
          </div>
          <p>&nbsp &nbsp &nbsp &nbsp &nbsp</p>
        </div>
      </div>
    </div>
    <script type="text/javascript">
      $(document).ready(function() {
          $(document).on("click",'.whatsapp',function() {
          if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
                var text = $(this).attr("data-text");
                var url = $(this).attr("data-link");
                var message = encodeURIComponent(text)+" - "+encodeURIComponent(url);
                var whatsapp_url = "whatsapp://send?text="+message;
                window.location.href= whatsapp_url;
          } else {
              alert("Please share this post in your mobile device");
          }
          });
      });
    </script>
  </body>
</html>
