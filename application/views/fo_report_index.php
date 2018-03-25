<!DOCTYPE html>
<html lang="en">
<head>
<?php $this->load->view('header'); ?>
</head>
<body>
<div id="wrapper">
  <?php $this->load->view('menu') ?>
  <div id="page-wrapper">
    <div class="container">
      <div class="report-variant">
        <legend>Amenity List</legend>
        <span class="btn btn-default btn-file">Per Hotel: </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/amenitys/report_hotel">Guest Amenity Report By Hotel</a>
        </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/amenitys/report_detail_hotel">Guest Amenity Details Report By Hotel</a>
        </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/amenitys/report_type_hotel">Guest Amenity Types Report By Hotel</a>
        </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/amenitys/report_refl_hotel">Guest Amenity Refilling Report By Hotel</a>
        </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/amenitys/report_hotel_reason">Guest Amenity Reason Report By Hotel</a>
        </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/amenitys/report_state_hotel">Guest Amenity State Report By Hotel</a>
        </span>
        <br />
        <br />
        <?php if(isset($is_admin) && $is_admin): ?>
          <span class="btn btn-default btn-file">All Hotels: </span>
          <span class="btn btn-default btn-file">
            <a class="rprt-lnk" href="/amenitys/report_all">Guest Amenity Report All Hotels</a>
          </span>
          <span class="btn btn-default btn-file">
            <a class="rprt-lnk" href="/amenitys/report_detail_all">Guest Amenity Details Report All Hotels</a>
          </span>
          <span class="btn btn-default btn-file">
            <a class="rprt-lnk" href="/amenitys/report_type_all">Guest Amenity Types Report All Hotels</a>
          </span>
          <span class="btn btn-default btn-file">
            <a class="rprt-lnk" href="/amenitys/report_refl_all">Guest Amenity Refilling Report All Hotels</a>
          </span>
          <span class="btn btn-default btn-file">
            <a class="rprt-lnk" href="/amenitys/report_state_all">Guest Amenity State Report All Hotels</a>
          </span>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
</body>
</html>