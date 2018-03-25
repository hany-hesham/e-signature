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
      <legend>Plan List</legend>
        <span class="btn btn-default btn-file">Per Hotel: </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/plans/item_hotel">Plan Department Report</a>
        </span>
        <br />
        <br />
        <span class="btn btn-default btn-file">All Hotels: </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/plans/item_department">Plan Department Report</a>
        </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/plans/summary_report">Plan List Summary Report</a>
        </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/plans/department_report">Plan List Department Report</a>
        </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/plans/like_all">Plan Items Report</a>
        </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/plans/all_report">All summary</a>
        </span>
        <br />
        <br />
        <br />
        <legend>Projects</legend>
        <span class="btn btn-default btn-file">Per Hotel: </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/project_reports/unplanned_chairman">Unplanned Projects less than 30,000 LE</a>
        </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/project_reports/all_projects">All Projects (Waiting - Approve - Reject)</a>
        </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/project_reports/project_progress_report_month/1">Project Cost Control Report</a>
        </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/project_reports/project_cost_report_month">Project Cost Status Report</a>
        </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/project_reports/all_projects_approval/1">Project Monthly Signed Report</a>
        </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/project_reports/all_projects_approved/1">Project Monthly Approved Report</a>
        </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/project_reports/project_delay_report/1">Delay Project Report</a>
        </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/project_reports/project_owning_delay_report/2/1">Cairo office Delay Approval Planned Projects Report</a>
        </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/project_reports/project_owning_delay_report/1/1">Cairo office Delay Approval UnPlanned Projects Report</a>
        </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/project_reports/all_projects_unplanned/1">Projects By Type Report</a>
        </span>
        <br />
        <br />
        <span class="btn btn-default btn-file">All Hotels: </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/project_reports/unplanned_chairman/1">Unplanned Projects less than 30,000 LE</a>
        </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/project_reports/all_project_chairman/1">Projects Report (Waiting - Approve - Reject)</a>
        </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/project_reports/project_progress_report_month">Project Cost Control Report</a>
        </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/project_reports/project_cost_report">Project Cost Status Report</a>
        </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/project_reports/all_projects_approval">Project Monthly Signed Report</a>
        </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/project_reports/all_projects_approved">Project Monthly Approved Report</a>
        </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/project_reports/project_delay_report">Delay Project Report</a>
        </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/project_reports/project_owning_delay_report/2">Cairo office Delay Approval Planned Projects Report</a>
        </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/project_reports/project_owning_delay_report/1">Cairo office Delay Approval UnPlanned Projects Report</a>
        </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/project_reports/all_projects_unplanned">Projects By Type Report</a>
        </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/project_reports/like_all">All Project Report</a>
        </span>
        <br />
        <br />
        <legend>Workshop Center</legend>
        <span class="btn btn-default btn-file">Per Hotel: </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/workshop_reports/all_requests/">All Workshop Orders</a>
        </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/workshop_reports/all_request_delayed/1">Delay Request Report</a>
        </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/workshop_reports/all_order_delayed/1">Delay Order Report</a>
        </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/workshop_reports/all_delivery_delayed/1">Delay Delivery Report</a>
        </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/workshop_reports/all_delivery_delayed_percent/1">Delay Delivery Percentage Report</a>
        </span>
        <br />
        <br />
        <span class="btn btn-default btn-file">All Hotels: </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/workshop_reports/all_reports/">All Workshop Orders</a>
        </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/workshop_reports/all_request_delayed">Delay Request Report</a>
        </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/workshop_reports/all_order_delayed">Delay Order Report</a>
        </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/workshop_reports/all_delivery_delayed">Delay Delivery Report</a>
        </span>
        <span class="btn btn-default btn-file">
          <a class="rprt-lnk" href="/workshop_reports/all_delivery_delayed_percent">Delay Delivery Percentage Report</a>
        </span>
      </div>
    </div>
  </div>
</div>
</body>
</html>