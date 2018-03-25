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
                <a class="form-actions btn btn-info non-printable" href="/form/edit_after/<?php echo $form['id'] ?>" style="float:right;" > Edit </a>
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
                  Legal Claims Form No. #<?php echo $form['id']; ?>
                  <a class="form-actions btn btn-danger non-printable" href="/form/index_after" style="float:right;" > Back </a>
                </h3>
              </div>
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 " style="background-color: #5CB1D4">
                <h5 class="text-center" style="color: #FFFFFF;">SUNRISE To Complete</h5>
              </div>
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-type" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width:200px;">Name of CNF</label>
                  <label for="from-type" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width:500px;"><?php echo $form['cnf']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "cnf") { ?>
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
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Date of Arrival </label>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 500px;"><?php echo $form['arrival']; ?></label>
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
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width: 500px;"><?php echo $form['departure']; ?></label>
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
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width: 200px;"> UK contact details for guest - address </label>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width: 500px;"><?php echo $form['address']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "address") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width: 200px;"> Personal Comment</label>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width: 500px;"><?php echo $form['comment']; ?></label>
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
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width: 200px;"> Postcode </label>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width: 500px;"><?php echo $form['postcode']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "postcode") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width: 200px;"> Email address </label>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width: 500px;"><?php echo $form['email']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "email") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width: 200px;"> Tour Operator </label>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width: 500px;"><?php echo $form['operator_name']; ?></label>
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
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width: 200px;"> Type </label>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width: 500px;"><?php echo $form['type']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "type") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
              </div>
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 " style="background-color: #5CB1D4">
                <h5 class="text-center" style="color: #FFFFFF;">SUNRISE To Complete</h5>
              </div>
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Incident Welfare Service Form (WSF) Completed?</label>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 500px;"><?php echo $form['incident']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "incident") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width: 200px;">Comment</label>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width: 500px;"><?php echo $form['comment1']; ?></label>
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
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;">In-house record of any complaints from the claimant/s</label>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 500px;"><?php echo $form['complaints']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "complaints") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width: 200px;">Comment</label>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width: 500px;"><?php echo $form['comment2']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "comment2") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Any Record of the Claimant/s visiting hotel doctor?</label>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 500px;"><?php echo $form['doctor']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "doctor") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;">Comment</label>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 500px;"><?php echo $form['comment3']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "comment3") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Date First Notice Received </label>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 500px;"><?php echo $form['first_notice']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "first_notice") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;">Value of Reserve £</label>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 500px;"><?php echo $form['reserve']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "reserve") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Is a Solicitor acting on behalf of the claimants?</label>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 500px;"><?php echo $form['solicitor']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "solicitor") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;">Name</label>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 500px;"><?php echo $form['solicitor_name']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "solicitor_name") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Copies of Original Letter from Claimant/s and/or Solicitor?</label>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 500px;"><?php echo $form['letter']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "letter") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Upload</label> 
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
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Medical Report</label>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 500px;"><?php echo $form['medical']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "medical") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Upload</label> 
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
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Photographs</label>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 500px;"><?php echo $form['photographs']; ?></label>
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
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Upload</label> 
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
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Other</label>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 500px;"><?php echo $form['Other']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "Other") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Upload</label> 
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
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Date SUNRISE Responded to the First Notice </label>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 500px;"><?php echo $form['responded']; ?></label>
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
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Date SUNRISE notified their insurers </label>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 500px;"><?php echo $form['notified']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "notified") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;">Insurers comments</label>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 500px;"><?php echo $form['insurers']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "insurers") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
              </div>
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 " style="background-color: #5CB1D4">
                <h5 class="text-center" style="color: #FFFFFF;">CCRM To Complete</h5>
              </div>
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Date Issued </label>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 500px;"><?php echo $form['date_issued']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "date_issued") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;">Amount £</label>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 500px;"><?php echo $form['amount']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "amount") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;">Reason for Settlement</label>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 500px;"><?php echo $form['settlement']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "settlement") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Tour Operator Decision</label>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 500px;"><?php echo $form['decision']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "decision") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;">Reason for decline</label>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 500px;"><?php echo $form['decline']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "decline") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Dates SUNRISE notified their insurers </label>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 500px;"><?php echo $form['notified1']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "notified1") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;">Insurers comments</label>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 500px;"><?php echo $form['insurers1']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "insurers1") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
              </div>
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 " style="background-color: #5CB1D4">
                <h5 class="text-center" style="color: #FFFFFF;">CCRM To Complete</h5>
              </div>
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Date Issued </label>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 500px;"><?php echo $form['issued']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "issued") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;">Detail</label>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 500px;"><?php echo $form['detail']; ?></label>
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
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Date Issued </label>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 500px;"><?php echo $form['issued1']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "issued1") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;">Detail</label>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 500px;"><?php echo $form['detail1']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "detail1") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Date Issued </label>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 500px;"><?php echo $form['issued2']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "issued2") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;">Detail</label>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 500px;"><?php echo $form['detail2']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "detail2") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Date Issued </label>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 500px;"><?php echo $form['issued3']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "issued3") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;">Detail</label>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 500px;"><?php echo $form['detail3']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "detail3") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Date Issued </label>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 500px;"><?php echo $form['issued4']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "issued4") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;">Detail</label>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 500px;"><?php echo $form['detail4']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "detail4") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width: 200px;"> Upload Any Other Doucuments</label> 
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
              </div>
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 " style="background-color: #5CB1D4">
                <h5 class="text-center" style="color: #FFFFFF;">CCRM To Complete | Reserve Updates</h5>
              </div>
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Date Received </label>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 500px;"><?php echo $form['received']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "received") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;">Amount £</label>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 500px;"><?php echo $form['amount1']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "amount1") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;">Text</label>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 500px;"><?php echo $form['text']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "text") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Date Received </label>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 500px;"><?php echo $form['received1']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "received1") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;">Amount £</label>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 500px;"><?php echo $form['amount2']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "amount2") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;">Text</label>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 500px;"><?php echo $form['text1']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "text1") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Date Received </label>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 500px;"><?php echo $form['received2']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "received2") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;">Amount £</label>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 500px;"><?php echo $form['amount3']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "amount3") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;">Text</label>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 500px;"><?php echo $form['text2']; ?></label>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Date Received </label>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 500px;"><?php echo $form['received3']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "received3") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;">Amount £</label>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 500px;"><?php echo $form['amount4']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "amount4") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;">Text</label>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 500px;"><?php echo $form['text3']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "text3") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Date Received </label>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 500px;"><?php echo $form['received4']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "received4") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;">Amount £</label>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 500px;"><?php echo $form['amount5']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "amount5") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;">Text</label>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 500px;"><?php echo $form['text4']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "text4") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Dates SUNRISE notified their insurers </label>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 500px;"><?php echo $form['notified2']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "notified2") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;">Insurers comments</label>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 500px;"><?php echo $form['insurers2']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "insurers2") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
              </div>
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 " style="background-color: #5CB1D4">
                <h5 class="text-center" style="color: #FFFFFF;">CCRM To Complete</h5>
              </div>      
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Date Closed Notice Received </label>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 500px;"><?php echo $form['closed']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "closed") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;">Recovery Amount £</label>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 500px;"><?php echo $form['recovery']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "recovery") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;">Detail Supporting Evidence received from Tour Operator</label>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 500px;"><?php echo $form['supporting']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "supporting") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Settlement Date </label>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 500px;"><?php echo $form['settlement_date']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "settlement_date") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;">Amount £ Agreed</label>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 500px;"><?php echo $form['agreed']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "agreed") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Dates SUNRISE notified their insurers </label>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 500px;"><?php echo $form['notified3']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "notified3") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;">Insurers comments</label>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 500px;"><?php echo $form['insurers3']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "insurers3") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Upload Any Other Doucuments</label> 
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
              </div>
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 " style="background-color: #5CB1D4">
                <h5 class="text-center" style="color: #FFFFFF;">Claim Details</h5>
              </div>  
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px; height: 100px;"> Confirmed Gastric</label>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 500px;"><?php echo $form['confirmed']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "confirmed") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 500px;"><?php echo $form['confirmed_text']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "confirmed_text") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px; height: 100px;"> Unconfirmed Gastric</label>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 500px;"><?php echo $form['unconfirmed']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "unconfirmed") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 500px;"><?php echo $form['unconfirmed_text']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "unconfirmed_text") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px; height: 100px;"> Accident</label>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 500px;"><?php echo $form['accident']; ?></label>
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
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 500px;"><?php echo $form['accident_text']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "accident_text") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </label>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px; height: 100px;"> Other</label>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 500px;"><?php echo $form['other1']; ?></label>
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "other1") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 500px;"><?php echo $form['other_text']; ?></label> 
                  <div class="non-printable centered form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php foreach ($log as $loger):?>
                      <?php if ($loger['location'] == "other_text") { ?>
                        <?php $value = json_decode($loger['data']);?>
                        <span style="color: blue; font-size: 12px;"><?php echo $loger['action'] ?> By <?php echo $loger['name'] ?> at <?php echo $loger['timestamp'] ?> from "<span style="color: red;"><?php echo $value->old ?></span>" to "<span style="color:green; "><?php echo $value->new ?></span>".</span>
                        <br>
                      <?php } ?>
                    <?php endforeach;?>
                  </div>                 
                </div>
              </div>
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher non-printable">
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <form action="/form/comment_after/<?php echo $form['id']?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
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
          </div>
          <div class="data-content">
            <?php if ($form['new_user_id']==0) {?>
              <p class="centered">The Legal Claims Form has been created by <?php echo $form['name'];?> at <?php echo $form['timestamp'];?></p>
            <?php }else {?>
              <p class="centered">The Legal Claims Form has been created by <?php echo $form['name'];?> at <?php echo $form['timestamp'];?></p>
              <p class="centered">And Edited by <?php echo $form_new['name'];?></p>
            <? } ?>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>