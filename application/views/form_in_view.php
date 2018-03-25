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
            <div class="page-header">
              <button onclick="window.print()" class="non-printable form-actions btn btn-success" href="" >Print</button>
              <?php if ($role_id == 58 || $role_id == 54 || $role_id == 47 || $role_id == 46 || $role_id == 42 || $role_id == 41 || $is_admin): ?>
                <a class="form-actions btn btn-info non-printable" href="/form/edit_in/<?php echo $form['id'] ?>" style="float:right;" > Edit </a>
              <?php endif ?>
              <div class="header-logo"><img src="/assets/uploads/logos/<?php echo $form['logo']; ?>"/></div>
                <h1 class="centered"><?php echo $form['hotel_name']; ?></h1>
                <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "hotel_id") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                <h3 class="centered">
                  In House - other nationalities Incident Report Form No. #<?php echo $form['id']; ?>
                  <a class="form-actions btn btn-danger non-printable" href="/form/index_in" style="float:right;" > Back </a>
                </h3>
              </div>
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 " style="background-color: #5CB1D4">
                <h5 class="text-center" style="color: #FFFFFF;">SUNRISE To Complete</h5>
              </div>
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-type" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width:200px;">Name of Guest</label>
                  <label for="from-type" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width:500px;"><?php echo $form['guest']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "guest") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-type" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width:200px;">Booking Referance</label>
                  <label for="from-type" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width:500px;"><?php echo $form['referance']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "referance") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Room number </label>
                  <label for="from-type" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width:500px;"><?php echo $form['room']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "room") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width: 200px;"> Date of Arrival </label>
                  <label for="from-type" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width:500px;"><?php echo $form['arrival']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "arrival") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width: 200px;"> Date of Departure </label>
                  <label for="from-type" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width:500px;"><?php echo $form['departure']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "departure") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width: 200px;"> Tour Operator</label>
                  <label for="from-type" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width:500px;"><?php echo $form['operator_name']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "operator_id") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width: 200px;"> TL name </label>
                  <label for="from-type" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width:500px;"><?php echo $form['tl']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "tl") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width: 200px;"> Booking ref </label>
                  <label for="from-type" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width:500px;"><?php echo $form['booking']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "booking") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width: 200px;"> Date and Time the case was reported </label>
                  <label for="from-type" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width:500px;"><?php echo $form['reporting']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "reporting") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width: 200px;"> Who the incident was reported to (position, name) </label>
                  <label for="from-type" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width:500px;"><?php echo $form['reported']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "reported") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width: 200px;"> Is this an accident, illness, assault, loss of valuables, quality issues or others or multiple issues? </label>
                  <label for="from-type" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width:500px;"><?php echo $form['accident']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "accident") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;">Illness Log</label>
                  <a class="form-actions btn btn-success non-printable" href="/illness/view/<?php echo $form['iln_id']; ?>" style="" > No# <?php echo $form['iln_id']; ?> </a>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width: 200px;"> Comment </label>
                  <label for="from-type" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width:500px;"><?php echo $form['comment']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "comment") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width: 200px;"> Personal Comment </label>
                  <label for="from-type" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width:500px;"><?php echo $form['comment1']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "comment1") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width: 200px;"> Number of party affected </label>
                  <label for="from-type" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width:500px;"><?php echo $form['affected']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "affected") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width: 200px;"> Names of all party affected </label>
                  <label for="from-type" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width:500px;"><?php echo $form['names']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "names") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width: 200px;"> Date and Time of incident/start of illness </label>
                  <label for="from-type" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width:500px;"><?php echo $form['date']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "date") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width: 200px;"> Illness symptoms reported </label>
                  <label for="from-type" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width:500px;"><?php echo $form['symptoms']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "symptoms") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width: 200px;"> Has the guest/s visited the Dr/hospital </label>
                  <label for="from-type" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width:500px;"><?php echo $form['visited']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "visited") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width: 200px;"> Name of guest/s who received treatment </label>
                  <label for="from-type" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width:500px;"><?php echo $form['treatment']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "treatment") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width: 200px;"> Upload </label>
                  <div class="form-group col-lg-9 col-md-8 col-sm-7 col-xs-7">
                    <?php foreach($uploads as $upload): ?>
                      <p><a href='/assets/uploads/files/<?php echo $upload['name'] ?>'><?php echo $upload['name'] ?></a> Uploaded by <?php echo $upload['user_name'] ?></p>
                    <?php endforeach ?>                 
                  </div>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "File") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> "<span style="color: green;"><?php echo $value->file ?></span>" By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?>.</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>      
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "Files") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> "<span style="color: red;"><?php echo $value->file ?></span>" By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> it was uploaded by "<span style="color: green;"><?php echo $value->user ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>     
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width: 200px;"> What medication/treatment was received </label>
                  <label for="from-type" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width:500px;"><?php echo $form['medication']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "medication") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label" style="margin:5px; width: 200px;"> If hospitalized, detail duration </label>
                  <label for="from-type" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width:500px;"><?php echo $form['duration']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "duration") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width: 200px;"> Location of accident </label>
                  <label for="from-type" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width:500px;"><?php echo $form['location']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "location") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width: 200px;"> Cause of accident as stated by guest </label>
                  <label for="from-type" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width:500px;"><?php echo $form['cause']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "cause") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width: 200px;"> Cause of accident as stated by any witness </label>
                  <label for="from-type" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width:500px;"><?php echo $form['witness']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "witness") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width: 200px;"> Cause of accident as per the hotel investigation </label>
                  <label for="from-type" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width:500px;"><?php echo $form['investigation']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "investigation") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width: 200px;"> Reason of complaints (not accident related) </label>
                  <label for="from-type" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width:500px;"><?php echo $form['not_related']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "not_related") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width: 200px;"> Injury sustained </label>
                  <label for="from-type" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width:500px;"><?php echo $form['injury']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "injury") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width: 200px;"> Is CCTV available </label>
                  <label for="from-type" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width:500px;"><?php echo $form['cctv']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "cctv") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width: 200px;"> Upload </label>
                  <div class="form-group col-lg-9 col-md-8 col-sm-7 col-xs-7">
                    <?php foreach($uploads1 as $upload): ?>
                      <p><a href='/assets/uploads/files/<?php echo $upload['name'] ?>'><?php echo $upload['name'] ?></a> Uploaded by <?php echo $upload['user_name'] ?></p>
                    <?php endforeach ?>                 
                  </div>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "File1") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> "<span style="color: green;"><?php echo $value->file ?></span>" By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?>.</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>      
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "Files1") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> "<span style="color: red;"><?php echo $value->file ?></span>" By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> it was uploaded by "<span style="color: green;"><?php echo $value->user ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>     
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width: 200px;"> Have any photographs been taken of the accident place </label>
                  <label for="from-type" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width:500px;"><?php echo $form['photographs']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "photographs") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width: 200px;"> Upload </label>
                  <div class="form-group col-lg-9 col-md-8 col-sm-7 col-xs-7">
                    <?php foreach($uploads2 as $upload): ?>
                      <p><a href='/assets/uploads/files/<?php echo $upload['name'] ?>'><?php echo $upload['name'] ?></a> Uploaded by <?php echo $upload['user_name'] ?></p>
                    <?php endforeach ?>                 
                  </div>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "File2") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> "<span style="color: green;"><?php echo $value->file ?></span>" By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?>.</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>      
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "Files2") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> "<span style="color: red;"><?php echo $value->file ?></span>" By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> it was uploaded by "<span style="color: green;"><?php echo $value->user ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>     
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width: 200px;"> If yes, please detail date and time photographs taken </label>
                  <label for="from-type" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width:500px;"><?php echo $form['detail']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "detail") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width: 200px;"> Please detail actions taken by the hotel to satisfy the guest </label>
                  <label for="from-type" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width:500px;"><?php echo $form['action']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "action") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width: 200px;"> Please detail actions taken by the hotel to fix and prevent in the future the cause of incident </label>
                  <label for="from-type" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width:500px;"><?php echo $form['prevent']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "prevent") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width: 200px;"> Is Guest Report available? </label>
                  <label for="from-type" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width:500px;"><?php echo $form['report']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "report") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width: 200px;"> Upload </label>
                  <div class="form-group col-lg-9 col-md-8 col-sm-7 col-xs-7">
                    <?php foreach($uploads3 as $upload): ?>
                      <p><a href='/assets/uploads/files/<?php echo $upload['name'] ?>'><?php echo $upload['name'] ?></a> Uploaded by <?php echo $upload['user_name'] ?></p>
                    <?php endforeach ?>                 
                  </div>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "File3") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> "<span style="color: green;"><?php echo $value->file ?></span>" By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?>.</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>      
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "Files3") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> "<span style="color: red;"><?php echo $value->file ?></span>" By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> it was uploaded by "<span style="color: green;"><?php echo $value->user ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>     
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width: 200px;"> Are Witness Reports available? </label>
                  <label for="from-type" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width:500px;"><?php echo $form['reports']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "reports") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width: 200px;"> Upload </label>
                  <div class="form-group col-lg-9 col-md-8 col-sm-7 col-xs-7">
                    <?php foreach($uploads4 as $upload): ?>
                      <p><a href='/assets/uploads/files/<?php echo $upload['name'] ?>'><?php echo $upload['name'] ?></a> Uploaded by <?php echo $upload['user_name'] ?></p>
                    <?php endforeach ?>                 
                  </div>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "File4") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> "<span style="color: green;"><?php echo $value->file ?></span>" By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?>.</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>      
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "Files4") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> "<span style="color: red;"><?php echo $value->file ?></span>" By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> it was uploaded by "<span style="color: green;"><?php echo $value->user ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>     
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width: 200px;"> Had a TO / TL been informed? </label>
                  <label for="from-type" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width:500px;"><?php echo $form['informed']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "informed") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width: 200px;"> TO / TL comments </label>
                  <label for="from-type" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width:500px;"><?php echo $form['comments']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "comments") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
              </div>
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 " style="background-color: #5CB1D4">
                <h5 class="text-center" style="color: #FFFFFF;">Dealing with TO (only for TC AG, BE, NL)</h5>
              </div>
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Had been added by TL to the Matsoft system</label>
                  <label for="from-type" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width:500px;"><?php echo $form['added']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "added") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width: 200px;">Compensation had been given to the guest in house and had been mentioned in the Matsoft system by TL</label>
                  <label for="from-type" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label" style="margin:5px; width:500px;"><?php echo $form['compensation']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "compensation") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;">Value of compensation (in L.E)</label>
                  <label for="from-type" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width:500px;"><?php echo $form['value']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "value") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width: 200px;">Had the compensation been accepted by guest</label>
                  <label for="from-type" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width:500px;"><?php echo $form['accepted']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "accepted") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Confirmed by TL given compensation in house which had been added to Matsoft system</label>
                  <label for="from-type" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width:500px;"><?php echo $form['given']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "given") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;">Follow Up with the guests (date and comments)</label>
                  <label for="from-type" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width:500px;"><?php echo $form['follow']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "follow") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
              </div>
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 " style="background-color: #5CB1D4">
                <h5 class="text-center" style="color: #FFFFFF;">Dealing With Insurance</h5>
              </div>
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Had the insurance been informed (for accidents / illness only) </label>
                  <label for="from-type" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width:500px;"><?php echo $form['insurance']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "insurance") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <?php if ($form['insurance'] == "Yes") { ?>
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;">Date the Insurance been informed by the hotel</label>
                    <label for="from-type" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width:500px;"><?php echo $form['informed1']; ?></label>
                    <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                      <?php foreach ($log as $loger):?>
                        <?php if ($loger['location'] == "informed1") { ?>
                          <?php $value = json_decode($loger['data']);?>
                          <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                          <br>
                        <?php } ?>
                      <?php endforeach;?>
                    </div>
                  </div>
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;">Date the Insurance been responded to the hotel and the comments</label>
                    <label for="from-type" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width:500px;"><?php echo $form['responded']; ?></label>
                    <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                      <?php foreach ($log as $loger):?>
                        <?php if ($loger['location'] == "responded") { ?>
                          <?php $value = json_decode($loger['data']);?>
                          <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                          <br>
                        <?php } ?>
                      <?php endforeach;?>
                    </div>
                  </div>
                <?php } ?>
              </div>
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 " style="background-color: #5CB1D4">
                <h5 class="text-center" style="color: #FFFFFF;">Additional Documents Available</h5>
              </div>
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Are Witness Reports available? </label>
                  <label for="from-type" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width:500px;"><?php echo $form['witness1']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "witness1") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;">Upload</label>
                  <div class="form-group col-lg-9 col-md-8 col-sm-7 col-xs-7">
                    <?php foreach($uploads5 as $upload): ?>
                      <p><a href='/assets/uploads/files/<?php echo $upload['name'] ?>'><?php echo $upload['name'] ?></a> Uploaded by <?php echo $upload['user_name'] ?></p>
                    <?php endforeach ?>                 
                  </div>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "File5") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> "<span style="color: green;"><?php echo $value->file ?></span>" By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?>.</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>      
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "Files5") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> "<span style="color: red;"><?php echo $value->file ?></span>" By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> it was uploaded by "<span style="color: green;"><?php echo $value->user ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>     
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;">Tour Operator Paperwork</label>
                  <label for="from-type" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width:500px;"><?php echo $form['paperwork']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "paperwork") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;">Upload</label>
                  <div class="form-group col-lg-9 col-md-8 col-sm-7 col-xs-7">
                    <?php foreach($uploads6 as $upload): ?>
                      <p><a href='/assets/uploads/files/<?php echo $upload['name'] ?>'><?php echo $upload['name'] ?></a> Uploaded by <?php echo $upload['user_name'] ?></p>
                    <?php endforeach ?>                 
                  </div>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "File6") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> "<span style="color: green;"><?php echo $value->file ?></span>" By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?>.</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>      
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "Files6") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> "<span style="color: red;"><?php echo $value->file ?></span>" By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> it was uploaded by "<span style="color: green;"><?php echo $value->user ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>     
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Cristal Audit </label>
                  <label for="from-type" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width:500px;"><?php echo $form['cristal']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "cristal") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;">Upload</label>
                  <div class="form-group col-lg-9 col-md-8 col-sm-7 col-xs-7">
                    <?php foreach($uploads7 as $upload): ?>
                      <p><a href='/assets/uploads/files/<?php echo $upload['name'] ?>'><?php echo $upload['name'] ?></a> Uploaded by <?php echo $upload['user_name'] ?></p>
                    <?php endforeach ?>                 
                  </div>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "File7") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> "<span style="color: green;"><?php echo $value->file ?></span>" By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?>.</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>      
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "Files7") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> "<span style="color: red;"><?php echo $value->file ?></span>" By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> it was uploaded by "<span style="color: green;"><?php echo $value->user ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>     
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Tour Operator Audit (any audits the TO has completed) </label>
                  <label for="from-type" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width:500px;"><?php echo $form['audits']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "audits") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;">Upload</label>
                  <div class="form-group col-lg-9 col-md-8 col-sm-7 col-xs-7">
                    <?php foreach($uploads8 as $upload): ?>
                      <p><a href='/assets/uploads/files/<?php echo $upload['name'] ?>'><?php echo $upload['name'] ?></a> Uploaded by <?php echo $upload['user_name'] ?></p>
                    <?php endforeach ?>                 
                  </div>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "File8") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> "<span style="color: green;"><?php echo $value->file ?></span>" By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?>.</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>      
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "Files8") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> "<span style="color: red;"><?php echo $value->file ?></span>" By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> it was uploaded by "<span style="color: green;"><?php echo $value->user ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>     
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Cleaning logs available for date/location of the accident </label>
                  <label for="from-type" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width:500px;"><?php echo $form['logs']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "logs") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;">Upload</label>
                  <div class="form-group col-lg-9 col-md-8 col-sm-7 col-xs-7">
                    <?php foreach($uploads9 as $upload): ?>
                      <p><a href='/assets/uploads/files/<?php echo $upload['name'] ?>'><?php echo $upload['name'] ?></a> Uploaded by <?php echo $upload['user_name'] ?></p>
                    <?php endforeach ?>                 
                  </div>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "File9") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> "<span style="color: green;"><?php echo $value->file ?></span>" By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?>.</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>      
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "Files9") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> "<span style="color: red;"><?php echo $value->file ?></span>" By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> it was uploaded by "<span style="color: green;"><?php echo $value->user ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>     
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width: 200px;"> Maintenance Logs for location of the accident</label> 
                  <label for="from-type" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width:500px;"><?php echo $form['maintenance']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "maintenance") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;">Upload</label>
                  <div class="form-group col-lg-9 col-md-8 col-sm-7 col-xs-7">
                    <?php foreach($uploads10 as $upload): ?>
                      <p><a href='/assets/uploads/files/<?php echo $upload['name'] ?>'><?php echo $upload['name'] ?></a> Uploaded by <?php echo $upload['user_name'] ?></p>
                    <?php endforeach ?>                 
                  </div>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "File10") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> "<span style="color: green;"><?php echo $value->file ?></span>" By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?>.</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>      
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "Files10") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> "<span style="color: red;"><?php echo $value->file ?></span>" By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> it was uploaded by "<span style="color: green;"><?php echo $value->user ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>     
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width: 200px;"> Any other documents (e.g. Courtesy calls, GSC, GCF, restaurant questionnaire records)</label> 
                  <label for="from-type" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width:500px;"><?php echo $form['documents']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "documents") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;">Upload</label>
                  <div class="form-group col-lg-9 col-md-8 col-sm-7 col-xs-7">
                    <?php foreach($uploads11 as $upload): ?>
                      <p><a href='/assets/uploads/files/<?php echo $upload['name'] ?>'><?php echo $upload['name'] ?></a> Uploaded by <?php echo $upload['user_name'] ?></p>
                    <?php endforeach ?>                 
                  </div>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "File11") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> "<span style="color: green;"><?php echo $value->file ?></span>" By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?>.</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>      
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "Files11") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> "<span style="color: red;"><?php echo $value->file ?></span>" By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> it was uploaded by "<span style="color: green;"><?php echo $value->user ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>     
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width: 200px;"> Any other documents (e.g. Courtesy calls, GSC, GCF, restaurant questionnaire records)</label> 
                  <label for="from-type" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width:500px;"><?php echo $form['other']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "other") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;">Upload</label>
                  <div class="form-group col-lg-9 col-md-8 col-sm-7 col-xs-7">
                    <?php foreach($uploads12 as $upload): ?>
                      <a href='/assets/uploads/files/<?php echo $upload['name'] ?>'><?php echo $upload['name'] ?></a><br />
                    <?php endforeach ?>                 
                  </div>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "File12") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> "<span style="color: green;"><?php echo $value->file ?></span>" By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?>.</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>      
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "Files12") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> "<span style="color: red;"><?php echo $value->file ?></span>" By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> it was uploaded by "<span style="color: green;"><?php echo $value->user ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>     
                </div>
              </div>
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher non-printable">
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <form action="/form/comment_in/<?php echo $form['id']?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                      <textarea class="form-control" name="comment" id="comment"></textarea>
                    </div>
                    <input name="set_id" value="<?php echo $form['id']?>" type="hidden" />
                    <input name="submit" value="Comment" type="submit" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-actions btn btn-success " />
                  </form>
                </div>
              </div>
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-holder">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher">
                  <div class="data-head centered"> 
                    <h3>Comments</h3> 
                  </div>
                  <div class="data-holder">
                    <?php foreach($getcomment as $comment ){ ?>
                      <div class="data-holder">
                        <span class="data-head"><?php echo $comment['fullname']; ?> :- </span><?php echo $comment['comment']; ?>
                        <span class="timestamp-data-content"><?php echo $comment['created'];?></span>
                      </div>
                    <?php } ?>
                  </div>
                </div>  
              </div>
            </div>
            <div class="data-content">
              <?php if ($form['new_user_id']==0) {?>
                <p class="centered">In House - other nationalities Incident Report Form has been created by <?php echo $form['name'];?> at <?php echo $form['timestamp'];?></p>
              <?php }else {?>
                <p class="centered">In House - other nationalities Incident Report Form has been created by <?php echo $form['name'];?> at <?php echo $form['timestamp'];?></p>
                <p class="centered">And Edited by <?php echo $form_new['name'];?></p>
              <? } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>