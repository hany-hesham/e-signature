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
        <legend>Out Going List</legend>
        <span class="btn btn-default btn-file">Per Hotel: </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/out_go_report/item_report/1">Item Report</a>
        </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/out_go_report/monthly_report/1">Monthly Report</a>
        </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/out_go_report/delivery_report/1">Delivery Report</a>
        </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/out_go_report/delay_report/1">Delay Report</a>
        </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/out_go_report/out_report/1">Out Items Report</a>
        </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/out_go_report/delivery_change_date/1">Changed Return Date Report</a>
        </span>
        <br />
        <br />
        <?php if(isset($is_admin) && $is_admin): ?>
          <span class="btn btn-default btn-file">All Hotels: </span>
          <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/out_go_report/item_report">Item Report</a>
        </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/out_go_report/monthly_report">Monthly Report</a>
        </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/out_go_report/delivery_report">Delivery Report</a>
        </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/out_go_report/delay_report">Delay Report</a>
        </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/out_go_report/out_report">Out Items Report</a>
        </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/out_go_report/delivery_change_date">Changed Return Date Report</a>
        </span>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
</body>
</html>