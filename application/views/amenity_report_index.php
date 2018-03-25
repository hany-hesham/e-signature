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
          <a class="rprt-lnk" href="/amenity/report_hotel">Guest Amenity Report By Hotel</a>
        </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/amenity/report_detail_hotel">Guest Amenity Details Report By Hotel</a>
        </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/amenity/report_type_hotel">Guest Amenity Types Report By Hotel</a>
        </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/amenity/refilling_report">Guest Amenity Refilling Report By Hotel</a>
        </span>
        <br />
        <br />
        <?php if(isset($is_admin) && $is_admin): ?>
          <span class="btn btn-default btn-file">All Hotels: </span>
          <span class="btn btn-default btn-file">
            <a class="rprt-lnk" href="/amenity/report_all">Guest Amenity Report All Hotel</a>
          </span>
          <span class="btn btn-default btn-file">
            <a class="rprt-lnk" href="/amenity/report_detail_all">Guest Amenity Details Report All Hotel</a>
          </span>
          <span class="btn btn-default btn-file">
            <a class="rprt-lnk" href="/amenity/report_type">Guest Amenity Types Report All Hotel</a>
          </span>
        <?php endif; ?>
        <br>
        <br>
        <br>
      </div>
    </div>
  </div>
</div>
</body>
</html>