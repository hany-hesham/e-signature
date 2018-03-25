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
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <fieldset>
              <legend>Submit a new settlements</legend>
              <?php if(validation_errors() != false): ?>
              <div class="alert alert-danger">
                <?php echo validation_errors(); ?>
              </div>
              <?php endif ?>
              <form action="" method="POST" id="form-submit" enctype="multipart/form-data" class="form-div span12" accept-charset="utf-8">
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;"> Hotel Name </label>
                  <select class="form-control" name="hotel_id" id="from-hotel " style="width:240px;">
                    <option data-company="0" value="">Select Hotel..</option>
                    <?php foreach ($hotels as $hotel): ?>
                    <option value="<?php echo $hotel['id'] ?>" <?php echo set_select('hotel_id',$hotel['id'] ); ?>><?php echo $hotel['name'] ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
               
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;"> Date of SAF </label>
                  <div class='input-group date' id='datetimepicker10' style=" width: 240px; margin:10px;">
                    <input type="text" name="Date" class="form-control" /> 
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calender"></span></span>
                  </div>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;"> SAF Valid Till </label>
                  <div class='input-group date' id='datetimepicker11' style=" width: 240px; margin:10px;">
                    <input type="text" name="Date_till" class="form-control" /> 
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calender"></span></span>
                  </div>
                  <br>
                  <div class="form-group">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;">Proposed settlements, £</label>
                  
                    <input type="number" name="Proposed" class="form-control" style=" height:38px; width: 240px;" class="form-control"/>
                   
                    <select class="form-control" name="currency" style="height:35px; width: 240px; margin-left: 148px; position: relative;">
                            <option value="">Select currency</option>
                            <option value="£">£</option> ‎
                            <option value="$">$</option> 
                            <option value="EURO">EURO</option>
                            <option value="EGP">EGP</option>
                          </select>
                  <br>     
                  </div>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;">Customer Name</label>
                  <p>
                    <input type="text" name="File" class="form-control" style=" height:38px; width: 240px;" class="form-control"/>
                  </p>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;">Booking Ref.</label>
                   <p>
                    <input type="text" name="Ref" class="form-control" style=" height:38px; width: 240px;" class="form-control"/>
                  </p>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;"> Date of Incident </label>
                  <div class='input-group date' id='datetimepicker12' style=" width: 240px; margin:10px;">
                    <input type="text" name="date_incident" class="form-control" /> 
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calender"></span></span>
                  </div>
                  <div class="form-group">
                   <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;">Highest Reserve, £</label>
                    <input type="number" name="Highest_Reserve" class="form-control" style=" height:38px; width: 240px;" class="form-control"/>
                    <select class="form-control" name="reserve_currency" style="height:35px; width: 240px; margin-left: 180px;position: relative;">
                            <option value="">Select currency</option>
                            <option value="£">£</option> ‎
                            <option value="$">$</option> 
                            <option value="EURO">EURO</option>
                            <option value="EGP">EGP</option>
                          </select>
                  </div>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;">Type of Claim</label>
                   <select class="form-control" name="claim_type" style="height:35px; width: 240px; margin-left: 180px;position: relative;">
                    <option value="">Type of Claim</option>
                    <option value="Direct Claim">Direct Claim</option> ‎
                    <option value="Via Solicitors ">Via Solicitors </option> 
                  </select>
                  <br>
                   <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;">N. of Claimants</label>
                  <p>
                    <input type="number" name="num_claimants" class="form-control" style=" height:38px; width: 240px;" class="form-control"/>
                  </p>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;">Nature of Claim</label>
                  <select class="form-control" name="nature_claim" style="height:35px; width: 240px; margin-left: 180px;position: relative;">
                    <option value="">Nature of Claim</option>
                    <option value="Unconfirmed Gastric Illness">Unconfirmed Gastric Illness</option> ‎
                    <option value="Confirmed Gastric Illness">Confirmed Gastric Illness</option> 
                    <option value="Confirmed and Unconfirmed">Confirmed and Unconfirmed</option> 
                    <option value="Accident">Accident</option> 
                    <option value="Assault">Assault</option> 
                    <option value="Bed Bugs">Bed Bugs</option> 
                    <option value="Others">Others</option> 
                  </select>
                  <br>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;">Status of Claim</label>  
                  <select class="form-control" name="claim_status" style="height:35px; width: 240px; margin-left: 180px;position: relative;">
                    <option value="">Status of Claim</option>
                    <option value="Open">Open</option> ‎
                    <option value="Recovery">Recovery</option> 
                    <option value="Closed">Closed</option>
                  </select>
                  <br>   
                <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;">Closed Amount, £ (if relevant)</label>
                    <input type="number" name="closed_amount" class="form-control" style=" height:38px; width: 240px;" class="form-control"/>
                  <select class="form-control" name="closed_amount_currency" style="height:35px; width: 240px; margin-left: 180px;position: relative;">
                            <option value="">Select currency</option>
                            <option value="£">£</option> ‎
                            <option value="$">$</option> 
                            <option value="EURO">EURO</option>
                            <option value="EGP">EGP</option>
                 </select> 
                 <br>
                 <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " 
                      style="margin-top:5px;">Date of Closed Notice (if relevant)</label> 
                   <div class='input-group date' id='datetimepicker15' style=" width: 240px; margin-left: :20px;">
                    <input type="text" name="closed_date_notice" class="form-control" /> 
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calender"></span></span>
                  </div> 
                  <br>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;">Cristal Score (if relevant)</label>
                  <p>
                    <input type="text" name="cristal_score" class="form-control" style=" height:38px; width: 240px;" class="form-control"/>
                  </p> 
                  <br>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;">
                       N. of Claims of the same nature within 3 months</label>
                    <input type="number" name="num_similar_claims" class="form-control" style=" height:38px; width: 240px;" class="form-control"/>
                  <br>
                  <br>       
                  <label for="from-hotel" class="control-label " style="margin-top:5px;"> Rationale for Proposed settlements </label>
                  <p>
                    <textarea type="text" name="Rationale" class="form-control" style=" width: 800px; height:100px;"></textarea>
                  </p>                  
                  <label for="from-hotel" class="control-label " style="margin-top:5px;"> Potential Risk if Proposed settlements Declined </label>
                  <p>
                    <textarea type="text" name="Risk" class="form-control" style=" width: 800px; height:100px;"></textarea>
                  </p> 
                   <br> 
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin-top:20px;position: relative;">Status of SAF* </label>
                  <select class="form-control" name="status" style="height:35px; width: 500px;margin-left: 120px;margin-top:20px;">
                    <option value = "">Status of SAF*</option>
                    <?php foreach ($statuss as $status)  :?>
                      <option value = "<?php echo $status['status'] ?>" ><?php echo $status['status'] ?></option>
                    <?php endforeach ?>
                  </select>
                 
                  <br> 
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;">Date of last SAF status</label>
                  <div class='input-group date' id='datetimepicker13' style=" width: 240px; margin-left: :20px;">
                    <input type="text" name="last_saf_date" class="form-control" /> 
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calender"></span></span>
                  </div> 
                  <br>
                  <br>
                 
                  <div class="form-group">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:10px;">
                              Final settlements reached between SUNRISE and TO**</label>
                    <input type="text" name="final_settlement" class="form-control" style=" height:38px; width: 240px;" class="form-control"/>
                      <select class="form-control" name="final_settlement_currency" style="height:35px; width: 240px; margin-left: 180px;position: relative;">
                            <option value="">Select currency</option>
                            <option value="£">£</option> ‎
                            <option value="$">$</option> 
                            <option value="EURO">EURO</option>
                            <option value="EGP">EGP</option>
                 </select> 
                    <div class='input-group date' id='datetimepicker14'  placeholder=" Final settlements Date" style=" width: 240px; margin-left: :20px;">
                    <input type="text" name="final_settlement_date" class="form-control" /> 
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calender"></span></span>
                  </div> 
                  </div>
                 
                  <br>
                  <br>    
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <input type="hidden" name="assumed_id" value="<?php echo $assumed_id; ?>" />
                      <label for="offers" class="col-lg-3 col-md-4 col-sm-5 col-xs-5 control-label">Report Files</label>
                      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <input id="offers" name="upload" type="file" class="file" multiple="true" data-show-upload="false" data-show-caption="true">
                      </div>
                      <script>
                      $("#offers").fileinput({
                          uploadUrl: "/settlements/make_offer/<?php echo $assumed_id; ?>", // server upload action
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
                              {url: "/settlements/remove_offer/<?php echo $settlements['id'] ?>/<?php echo $upload['id'] ?>", key: "<?php echo $upload['name']; ?>"},
                          <?php endforeach; ?>
                          ],
                      });
                      </script>
                  </div>
        <!--          
                  <label for="from-hotel" class="control-label " style="margin-top:5px;"> Proposed settlements Agreed by</label> 
                  <p>
                    <textarea type="text" name="Agreed" class="form-control" style=" width: 800px; height:100px;"></textarea>
                  </p>
         -->           
                </div>
                <div style="    margin-top: 90px;" class="form-group">
                  <div class="col-lg-offset-3 col-lg-10 col-md-10 col-md-offset-3">
                    <input name="submit" value="Submit" type="submit" class="btn btn-success" />
                    <a href="<?= base_url(); ?>settlements" class="btn btn-warning">Cancel</a>
                  </div>
                </div>
              </form>
            </fieldset>
          </div>
        </div>
      </div>
    </div>
    <script type="text/javascript">
     $(function () {
        $('#datetimepicker10').datetimepicker({
          format: 'DD/MM/YYYY'
        });
      });
    </script>
    <script type="text/javascript">
      $(function () {
        $('#datetimepicker11').datetimepicker({
          format: 'DD/MM/YYYY'
        });
      });
    </script>
     <script type="text/javascript">
       $(function () {
        $('#datetimepicker12').datetimepicker({
          format: 'DD/MM/YYYY'
        });
      });
    </script>
     <script type="text/javascript">
     $(function () {
        $('#datetimepicker13').datetimepicker({
          format: 'DD/MM/YYYY'
        });
      });
    </script>
    <script type="text/javascript">
      $(function () {
        $('#datetimepicker14').datetimepicker({
          format: 'DD/MM/YYYY'
        });
      });
    </script>
     <script type="text/javascript">
      $(function () {
        $('#datetimepicker15').datetimepicker({
          format: 'DD/MM/YYYY'
        });
      });
    </script>
  </body>
</html>
