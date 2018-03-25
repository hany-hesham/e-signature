<!DOCTYPE html>
<html lang="en">
<head>
<?php $this->load->view('header'); ?>
<style type="text/css">
  @media print{
    .real{
      width: 1000px !important;
    }
    .topic{
      display: block !important;
    }
  }
</style>
</head>
<body>
<div id="wrapper">
  <?php $this->load->view('menu') ?>
  <button onclick="window.print()" class="non-printable form-actions btn btn-success" href="" >Print</button>
    <a class="form-actions btn btn-success non-printable" href="/qlt_report" style="float:right;" > Back </a>
    <div class="rest-selector col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <fieldset>
      <legend class="title-table non-printable">Reason of Report</legend>
          <?php $this->load->view('form_type_all_report_menu'); ?>
      </fieldset>
    </div>
    <?php if (isset($cases_uk) || isset($cases_other)): ?>  
      <div class="centered">
        <?php if ($hotel): ?>  
          <div class="centered header-logo topic" style="display: none;"><img src="/assets/uploads/logos/<?php echo $hotel['logo']; ?>"/></div>
          <h1 class="centered topic" style="display: none;"> <?php echo $hotel['name']; ?> </h1>
        <?php endif; ?>
        <h2 class="centered topic" style="display: none;"> Incident Report Where The Reason is <?php echo $answer; ?></h2>
        <h3 class="centered topic" style="display: none;"> from <?php echo $from; ?> to <?php echo $to; ?></h3>
        <h4 class="centered"> Total of <?php echo $cases_uk_count; ?> In House Incident Report-UK forms</h4>
        <h4 class="centered"> Total of <?php echo $cases_other_count; ?> In House - other nationalities Incident Report forms</h4>
      </div>
      <br>
      <br>
      <br>
      <div class="centered">
        <h4 class="centered"> In House Incident Report-UK forms</h4>
        <table class="table table-striped table-bordered table-condensed real" style="width:1000px;">
          <tbody>
            <tr>
              <th class="header">#</th>
              <th class="header">Hotel</th>
              <th class="header">Tour Operator</th>
              <th class="header">Guest Name</th>
              <th class="header">Arrival Date</th>
              <th class="header">Departure Date</th>
              <th class="header">Date of the accident</th>
              <th class="header">Location of the accident</th>
              <th class="header non-printable">Action</th>
            </tr>
            <?php foreach($cases_uk as $case ){?>
              <tr class="active">
                <td><?php echo $case['id'] ?></td>
                <td><?php echo $case['hotel_name'] ?></td>
                <td><?php echo $case['operator_name'] ?></td>
                <td><?php echo $case['guest'] ?></td>
                <td><?php echo $case['arrival'] ?></td>
                <td><?php echo $case['departure'] ?></td>
                <td><?php echo $case['date'] ?></td>
                <td><?php echo $case['location'] ?></td>
                <td class="non-printable">
                  <a href="<?php echo base_url(); ?>form/view_in_uk/<?php echo $case['id'] ?> " class="btn btn-primary">View</a>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
      <div class="centered">
        <h4 class="centered"> In House - other nationalities Incident Report forms</h4>
        <table class="table table-striped table-bordered table-condensed real" style="width:1000px;">
          <tbody>
            <tr>
              <th class="header">#</th>
              <th class="header">Hotel</th>
              <th class="header">Tour Operator</th>
              <th class="header">Guest Name</th>
              <th class="header">Arrival Date</th>
              <th class="header">Departure Date</th>
              <th class="header">Date of the accident</th>
              <th class="header">Location of the accident</th>
              <th class="header non-printable">Action</th>
            </tr>
            <?php foreach($cases_other as $case ){?>
              <tr class="active">
                <td><?php echo $case['id'] ?></td>
                <td><?php echo $case['hotel_name'] ?></td>
                <td><?php echo $case['operator_name'] ?></td>
                <td><?php echo $case['guest'] ?></td>
                <td><?php echo $case['arrival'] ?></td>
                <td><?php echo $case['departure'] ?></td>
                <td><?php echo $case['date'] ?></td>
                <td><?php echo $case['location'] ?></td>
                <td class="non-printable">
                  <a href="<?php echo base_url(); ?>form/view_in/<?php echo $case['id'] ?> " class="btn btn-primary">View</a>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
    <?php endif; ?>
  </div>
</body>
</html>