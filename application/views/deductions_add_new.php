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
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px;">
              <div class="page-header">
                <h1 class="centered"> Deductions Form </h1>
              </div>
              <?php if(validation_errors() != false): ?>
                <div class="alert alert-danger">
                  <?php echo validation_errors(); ?>
                </div>
              <?php endif ?>            
            </div>
            <div class="container">
              <form action="" method="POST" id="form-submit" enctype="multipart/form-data" class="form-div span12" accept-charset="utf-8">
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label" style="margin-top:5px;"> Hotel Name </label>
                  <select class="form-control" name="hotel_id" id="from-hotel " style="width:240px; height:40px;">
                    <option data-company="0" value="">Select Hotel..</option>
                    <?php foreach ($hotels as $hotel): ?>
                      <option value="<?php echo $hotel['id'] ?>"<?php echo set_select('hotel_id',$hotel['id'] ); ?>><?php echo $hotel['name'] ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label" style="margin-top:5px;"> Guest Name </label>
                  <input type="text" name="guest" class="form-control" style="width:240px; height:40px;"/>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label" style="margin-top:5px;"> Ref. Number </label>
                  <input type="text" name="ref" class="form-control" style="width:240px; height:40px;"/>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label" style="margin-top:5px;"> Date of Travel (Arr.)</label>
                  <div class='input-group date' id='datetimepicker1' style=" width: 240px;">
                    <input type='text' class="form-control" name="date"/>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label" style="margin-top:5px;"> Tour Operator </label>
                  <select class="form-control" name="operator_id" id="from-hotel " style="width:240px; height:40px;">
                    <option data-company="0" value="">Select Operator..</option>
                    <?php foreach ($operators as $operator): ?>
                      <option value="<?php echo $operator['id'] ?>"<?php echo set_select('operator_id',$operator['id'] ); ?>><?php echo $operator['name'] ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label" style="margin-top:5px;"> Subject of Deduction (in short) </label>
                  <select name="subject" class="form-control" style="width:240px; height:40px;">
                    <option value="">Select Subject</option>
                    <option value="Multiple issues">Multiple issues</option>
                    <option value="Accommodation">Accommodation</option>
                    <option value="Cleanliness">Cleanliness</option>
                    <option value="Amenities">Amenities</option>
                    <option value="Facilities">Facilities</option>
                    <option value="Construction">Construction</option>
                    <option value="Room Type">Room Type</option>
                    <option value="Service">Service</option>
                    <option value="Food">Food</option>
                    <option value="Hygiene">Hygiene</option>
                    <option value="Drinks">Drinks</option>
                    <option value="Animations">Animations</option>
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label" style="margin-top:5px;"> Comments </label>
                  <input type="text" name="comment" class="form-control" style="width:240px; height:40px;"/>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label" style="margin-top:5px;"> Date of Recieving Deduction </label>
                  <div class='input-group date' id='datetimepicker2' style=" width: 240px;">
                    <input type='text' class="form-control" name="receiving"/>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label" style="margin-top:5px;"> Date of Reply for Deduction </label>
                  <div class='input-group date' id='datetimepicker3' style=" width: 240px;">
                    <input type='text' class="form-control" name="reply"/>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label" style="margin-top:5px;"> Amount of Deduction </label>
                  <input type="text" name="amount" class="form-control" style="width:240px; height:40px;"/>
                  <br>
                  <select class="form-control" name="curency" style="width:240px; height:40px; margin-left: 185px;">
                    <option value="">Select currency</option>
                    <option value="£">£</option> ‎
                    <option value="$">$</option> 
                    <option value="EURO">EURO</option>
                    <option value="EGP">EGP</option>
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label" style="margin-top:5px;"> Hotel Decision </label>
                  <select class="form-control" name="decision" style="width:240px; height:40px;">
                    <option value="">Select Decision</option>
                    <option value="Rejected">Rejected</option> ‎
                    <option value="Accepted">Accepted</option> 
                    <option value="Partly Accepted">Partly Accepted</option>
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label" style="margin-top:5px;"> If Partly Accepted What is The Hotel Offer (Amount)? </label>
                  <input type="text" name="offer" class="form-control" style="width:240px; height:40px;"/>
                  <br>
                  <select class="form-control" name="curency1" style="width:240px; height:40px; margin-left: 185px;">
                    <option value="">Select currency</option>
                    <option value="£">£</option> ‎
                    <option value="$">$</option> 
                    <option value="EURO">EURO</option>
                    <option value="EGP">EGP</option>
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="control-label " style="margin-top:5px;"> Reason of Hotel Decision (in short) </label>
                  <textarea type="text" name="reason" class="form-control" style=" width: 700px; height:100px;"></textarea>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label" style="margin-top:5px;"> TO decision (amount will be deducted) </label>
                  <input type="text" name="amount1" class="form-control" style="width:240px; height:40px;"/>
                  <br>
                  <select class="form-control" name="curency2" style="width:240px; height:40px; margin-left: 185px;">
                    <option value="">Select currency</option>
                    <option value="£">£</option> ‎
                    <option value="$">$</option> 
                    <option value="EURO">EURO</option>
                    <option value="EGP">EGP</option>
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label" style="margin-top:5px;"> Received in Invoice </label>
                  <select class="form-control" name="recieved" style="width:240px; height:40px;">
                    <option value="">Select</option>
                    <option value="Yes">Yes</option> ‎
                    <option value="No">No</option> 
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label" style="margin-top:5px;"> Date of Invoice</label>
                  <div class='input-group date' id='datetimepicker4' style=" width: 240px;">
                    <input type='text' class="form-control" name="date1"/>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label" style="margin-top:5px;"> Ref. on Invoice </label>
                  <input type="text" name="invoice" class="form-control" style="width:240px; height:40px;"/>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="control-label " style="margin-top:5px;"> Other Notes </label>
                  <textarea type="text" name="other" class="form-control" style=" width: 700px; height:100px;"></textarea>
                </div>
                <div class="form-group col-lg-12 col-md-9 col-sm-12 col-xs-12">
                    <input type="hidden" name="assumed_id" value="<?php echo $assumed_id; ?>" />
                    <label for="offers" class="col-lg-3 col-md-4 col-sm-5 col-xs-5 control-label">Report Files</label>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                      <input id="offers" name="upload" type="file" class="file" multiple="true" data-show-upload="false" data-show-caption="true">
                    </div>
                    <script>
                      $("#offers").fileinput({
                        uploadUrl: "/deductions/make_offer/<?php echo $assumed_id; ?>", // server upload action
                        uploadAsync: true,
                        minFileCount: 1,
                        maxFileCount: 5,
                        overwriteInitial: false,
                        initialPreview: [
                          <?php foreach($uploads as $upload): ?>
                            "<div class='file-preview-text'>" +
                            "<h2><i class='glyphicon glyphicon-file'></i></h2>" +
                            "<a href='/assets/uploads/files/<?php echo $upload['name'] ?>'><?php echo $upload['name'] ?></a>" + "</div>",
                          <?php endforeach ?>
                        ],
                        initialPreviewConfig: [
                          <?php foreach($uploads as $upload): ?>
                            {url: "/deductions/remove_offer/<?php echo $assumed_id; ?>/<?php echo $upload['id']; ?>", key: "<?php echo $upload['name']; ?>"},
                          <?php endforeach; ?>
                        ],
                      });
                    </script>
                  </div>
                <div class="col-lg-offset-3 col-lg-10 col-md-10 col-md-offset-3">
                  <br>
                  <br>
                  <br>
                  <br>
                  <input name="submit" value="Submit" type="submit" class="btn btn-success"/>
                  <a href="<?= base_url(); ?>deductions" class="btn btn-warning">Cancel</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script type="text/javascript">
      $(function(){
        $('#datetimepicker1').datetimepicker({
          viewMode:'days',
          format:'DD/MM/YYYY'
        });
      });
    </script>
    <script type="text/javascript">
      $(function(){
        $('#datetimepicker2').datetimepicker({
          viewMode:'days',
          format:'DD/MM/YYYY'
        });
      });
    </script>
    <script type="text/javascript">
      $(function(){
        $('#datetimepicker3').datetimepicker({
          viewMode:'days',
          format:'DD/MM/YYYY'
        });
      });
    </script>
    <script type="text/javascript">
      $(function(){
        $('#datetimepicker4').datetimepicker({
          viewMode:'days',
          format:'DD/MM/YYYY'
        });
      });
    </script>
  </body>
</html>
