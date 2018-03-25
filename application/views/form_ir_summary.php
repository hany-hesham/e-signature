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
      <legend class="title-table non-printable">Incident report summary</legend>
          <?php $this->load->view('form_ir_summary_report_menu'); ?>
      </fieldset>
    </div>
    <?php if (isset($cases)): ?>  
      <div class="centered">
        <?php if ($hotel): ?>  
          <div class="centered header-logo topic" style="display: none;"><img src="/assets/uploads/logos/<?php echo $hotel['logo']; ?>"/></div>
          <h1 class="centered topic" style="display: none;"> <?php echo $hotel['name']; ?> </h1>
        <?php endif; ?>
        <h2 class="centered topic" style="display: none;"> <?php echo $type; ?></h2>
          <h2 class="centered topic" style="display: none;">Weekly Food Incident / Accident Summary</h2>
        <h3 class="centered topic" style="display: none;"> from <?php echo $from; ?> to <?php echo $to; ?></h3>
        <h4 class="centered"> Total of <?php echo $cases_count; ?> forms</h4>
      </div>
      <br>
      <br>
      <br>
      <?php if($all != 1) :?>
      <div class="centered">
        <table class="table table-striped table-bordered table-condensed real" style="width:1000px;">
          <tbody>
            <tr>
              <th class="header">#</th>
              <th class="header">Incident Date</th>
              <th class="header">Room No.</th>
              <th class="header">Guest name</th>
              <th class="header">Arrival</th>
              <th class="header">Departure</th>
              <th class="header">Travel Agent</th>
              <th class="header">Subject of the Case, Injury or illness symptoms</th>
              <th class="header">Doctor visited?</th>
              <th class="header">Comments</th>
              <th class="header non-printable">Action</th>
            </tr>
            <?php foreach($cases as $case ){?>
              <tr class="active">
                <td><?php echo $case['id'] ?></td>
                <td><?php echo $case['date'] ?></td>
                <td><?php echo $case['room'] ?></td>
                <td><?php echo $case['guest'] ?></td>
                <td><?php echo $case['arrival'] ?></td>
                <td><?php echo $case['departure'] ?></td>
                <td><?php echo $case['operator_name'] ?></td>
                <td><?php echo $case['accident'] ?></td>
                <td><?php echo $case['visited'] ?></td>
                <td><?php echo $case['comments'] ?></td>
                <td class="non-printable">
                  <a href="<?php echo base_url(); ?>form/<?php echo ($type1 == '1')? 'view_in_uk' : 'view_in' ?>/<?php echo $case['id'] ?> " class="btn btn-primary">View</a>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
  </div>
<?php else : ?>
<div class="centered">
        <table class="table table-striped table-bordered table-condensed real" style="width:1000px;">
          <tbody>
            <tr>
              <th class="header">#</th>
              <th class="header">Hotel Name</th>
              <th class="header">Incident Date</th>
              <th class="header">Room No.</th>
              <th class="header">Guest name</th>
              <th class="header">Arrival</th>
              <th class="header">Departure</th>
              <th class="header">Travel Agent</th>
              <th class="header">Subject of the Case, Injury or illness symptoms</th>
              <th class="header">Doctor visited?</th>
              <th class="header">Comments</th>
              <th class="header non-printable">Action</th>
            </tr>
            <?php foreach($cases as $case ){?>
              <tr class="active">
                <td><?php echo $case['id'] ?></td>
                <td><?php echo $case['hotel_name'] ?></td>
                <td><?php echo $case['date'] ?></td>
                <td><?php echo $case['room'] ?></td>
                <td><?php echo $case['guest'] ?></td>
                <td><?php echo $case['arrival'] ?></td>
                <td><?php echo $case['departure'] ?></td>
                <td><?php echo $case['operator_name'] ?></td>
                <td><?php echo $case['accident'] ?></td>
                <td><?php echo $case['visited'] ?></td>
                <td><?php echo $case['comments'] ?></td>
                <td class="non-printable">
                  <a href="<?php echo base_url(); ?>form/<?php echo ($type1 == '1')? 'view_in_uk' : 'view_in' ?>/<?php echo $case['id'] ?> " class="btn btn-primary">View</a>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
    <?php endif; ?>
  </div>
  <?php endif; ?>
</body>
</html>