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
      <a href="<?php echo base_url(); ?>quality/" class="btn btn-danger" style="float: right;">Go Back To Quality Forms</a>
      <div class="report-variant">
        <legend>Settlement List</legend>
        <span class="btn btn-default btn-file">Per Hotel: </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/settlement/report_hotel">Settlement Amount</a>
        </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/settlement/report_states">Settlement Status Report</a>
        </span>
        <br />
        <br />
        <span class="btn btn-default btn-file">All Hotels: </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/settlement/report_all">Settlement Amount</a>
        </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/settlement/report_states_all">Settlement Status Report</a>
        </span>
        <br />
        <br />
        <br />
        <legend>In House List</legend>
        <span class="btn btn-default btn-file">Per Hotel: </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/form/report_in_uk">Reason of Report In A Type</a>
        </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/form/report_all">Reason of Report All</a>
        </span>
        <br />
        <br />
        <br />
         <legend>In House summary</legend>
        <span class="btn btn-default btn-file">Per Hotel: </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/form/report_ir_summary">Incident report summary</a>
        </span>
        <br />
        <br />
        <span class="btn btn-default btn-file">All Hotels: </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/form/report_ir_summary/1">Incident report summary</a>
        </span>
        <br />
        <br />
        <br />
        <legend>Illness Log List</legend>
        <span class="btn btn-default btn-file">Per Hotel: </span>
        <br>
        <span class="btn btn-default btn-file">Hotel And Dates: </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/illness/report_custom_hotel">Hotel</a>
        </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/illness/report_custom_date">Period of Time</a>
        </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/illness/report_custom_guest">Guest</a>
        </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/illness/report_custom_to">Tour Operator</a>
        </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/illness/report_custom_symptoms">Diagnosis / Symptoms</a>
        </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/illness/report_custom_visit">Hotel Clinic Visit</a>
        </span>
        <br>
        <span class="btn btn-default btn-file">All Data: </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/illness/report_hotel">Hotel</a>
        </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/illness/report_date">Period of Time</a>
        </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/illness/report_guest">Guest</a>
        </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/illness/report_to">Tour Operator</a>
        </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/illness/report_symptoms">Diagnosis / Symptoms</a>
        </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/illness/report_visit">Hotel Clinic Visit</a>
        </span>
        <br />
        <br />
        <span class="btn btn-default btn-file">All Hotels: </span>
        <br>
        <span class="btn btn-default btn-file">Hotel And Dates: </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/illness/report_custom_date_all">Period of Time</a>
        </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/illness/report_custom_guest_all">Guest</a>
        </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/illness/report_custom_to_all">Tour Operator</a>
        </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/illness/report_custom_symptoms_all">Diagnosis / Symptoms</a>
        </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/illness/report_custom_visit_all">Hotel Clinic Visit</a>
        </span>
        <br>
        <span class="btn btn-default btn-file">All Data: </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/illness/report_date_all">Period of Time</a>
        </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/illness/report_guest_all">Guest</a>
        </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/illness/report_to_all">Tour Operator</a>
        </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/illness/report_symptoms_all">Diagnosis / Symptoms</a>
        </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/illness/report_visit_all">Hotel Clinic Visit</a>
        </span>
        <br />
        <br />
        <br />
      </div>
    </div>
  </div>
</div>
</body>
</html>