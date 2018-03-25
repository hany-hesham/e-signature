<!DOCTYPE html>
<html lang="en">
  <head>
    <?php $this->load->view('header');?>
  </head>
  <body>
    <?php $this->load->view('menu'); ?>
    <div class="navbar-header" style="position:relative; margin-left: 500px; margin-top: -10px;">
      <div class="navbar navbar-inverse">
        <ul class="nav navbar-nav">
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Frontoffice <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="/amenitys">Guest Amenity</a></li>
              <li><a href="/rra_change">Rate Change</a></li>
              <li><a href="/fb_order">Food & Beverage</a></li>
              <li><a href="/discrepancy">Discrepancy</a></li>
              <li><a href="/late_ch">Late check out</a></li>
              <li><a href="/s_rate">Special rate</a></li>
              <li><a href="/rr_change">Room Change</a></li>
              <li><a href="/upgrad">Free Room Upgrad</a></li>
              <li><a href="/bd_use">Beach/Day Use Request</a></li>
              <li><a href="/fo_report"><span style="color: red;">Reports</span></a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </body>
</html>