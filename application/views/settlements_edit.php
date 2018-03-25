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
              <legend>Edit settlements</legend>
              <?php if(validation_errors() != false): ?>
              <div class="alert alert-danger">
                <?php echo validation_errors(); ?>
              </div>
              <?php endif ?>
              <form action="" method="POST" id="form-submit" enctype="multipart/form-data" class="form-div span12" accept-charset="utf-8">
                <div >
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;"> Hotel Name </label>
                  <select class="form-control" name="hotel_id" id="from-hotel " style="width: 30%;">
                    <option data-company="0" value="<?php echo $settlements['hotel_id']; ?>"><?php echo $settlements['hotel_name']; ?></option>
                    <?php foreach ($hotels as $hotel): ?>
                    <option value="<?php echo $hotel['id'] ?>" <?php echo set_select('hotel_id',$hotel['id'] ); ?>><?php echo $hotel['name'] ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
                <br>
                 <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;"> Date of SAF </label>
                  <div class='input-group date' id='datetimepicker10' style=" width: 240px; margin:10px;">
                    <input type="text" name="Date" class="form-control" value="<?php echo $settlements['Date']; ?>" /> 
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calender"></span></span>
                  </div>
                 <br>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;">SAF Valid Till</label>
                  <div class='input-group date' id='datetimepicker11' style=" width: 240px; margin:10px;">
                    <input type="text" name="Date_till" class="form-control" value="<?php echo $settlements['Date_till']; ?>" /> 
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calender"></span></span>
                  </div>
                  <br>
                <div  style="margin-right: 15px;">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label" style="margin-top:5px;"> Proposed settlements, £</label>
                  <p>
                    <input type="number" name="Proposed" class="form-control" style=" height:38px; width: 240px;" class="form-control" value="<?php echo $settlements['Proposed']; ?>"/>
                  <select class="form-control" name="currency" style="height:35px; width: 240px; margin-left: 148px;">
                            <option value="<?php echo $settlements['currency']; ?>"><?php echo $settlements['currency']; ?></option>
                            <option value="£">£</option> ‎
                            <option value="$">$</option>
                            <option value="EURO">EURO</option>
                            <option value="EGP">EGP</option>
                          </select>
                  </p>
                  </div>
                  <br>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;">Customer Name </label>
                  <p>
                    <input type="text" name="File" class="form-control" style=" height:38px; width: 240px;" class="form-control" value="<?php echo $settlements['File']; ?>"/>
                  </p>
                  <br>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;">Booking Ref.</label>
                  <p>
                    <input type="number" name="Ref" class="form-control" style=" height:38px; width: 240px;" value="<?php echo $settlements['Ref']; ?>"/>
                  </p>
                  <br>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;">Date of Incident </label>
                  <div class='input-group date' id='datetimepicker12' style=" width: 240px; margin:10px;">
                    <input type="text" name="date_incident" class="form-control" value="<?php echo $settlements['date_incident']; ?>" /> 
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calender"></span></span>
                  </div>
                  <br>
                  <div  style="margin-right: 15px;">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label" style="margin-top:5px;">Highest Reserve, £</label>
                  <p>
                    <input type="number" name="Highest_Reserve" class="form-control" style=" height:38px; width: 240px;" class="form-control" value="<?php echo $settlements['Highest_Reserve']; ?>"/>
                  <select class="form-control" name="reserve_currency" style="height:35px; width: 240px; margin-left: 183px;">
                            <option value="<?php echo $settlements['reserve_currency']; ?>"><?php echo $settlements['reserve_currency']; ?></option>
                            <option value="£">£</option> ‎
                            <option value="$">$</option>
                            <option value="EURO">EURO</option>
                            <option value="EGP">EGP</option>
                  </select>
                  </p>
                  </div>
                  <br>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;">Type of Claim</label>
                   <select class="form-control" name="claim_type" style="height:35px; width: 240px; margin-left: 183px;">
                     <option value="<?php echo $settlements['claim_type']; ?>"><?php echo $settlements['claim_type']; ?></option>
                     <option value="Via Solicitors ">Via Solicitors </option>
                     <option value="Direct Claim">Direct Claim</option> ‎
                  </select>
                  <br>
                 <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label" style="margin-top:5px;">N. of Claimants</label>
                  <p>
                    <input type="number" name="num_claimants" class="form-control" style=" height:38px; width: 240px;" class="form-control" value="<?php echo $settlements['num_claimants']; ?>"/>
                  </p> 
                  <br>
                   <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;">nature of Claim</label>
                   <select class="form-control" name="nature_claim" style="height:35px; width: 240px; margin-left: 183px;">
                    <option value="<?php echo $settlements['nature_claim']; ?>"><?php echo $settlements['nature_claim']; ?></option>
                    <option value="Unconfirmed Gastric Illness">Unconfirmed Gastric Illness</option> ‎
                    <option value="Confirmed Gastric Illness">Confirmed Gastric Illness</option> 
                    <option value="Confirmed and Unconfirmed">Confirmed and Unconfirmed</option> 
                    <option value="Accident">Accident</option> 
                    <option value="Assault">Assault</option> 
                    <option value="Bed Bugs">Bed Bugs</option> 
                    <option value="Bed Bugs">Others</option> 
                  </select>
                  <br>
                   <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;">Status of Claim</label>
                   <select class="form-control" name="claim_status" style="height:35px; width: 240px; margin-left: 183px;">
                     <option value="<?php echo $settlements['claim_status']; ?>"><?php echo $settlements['claim_status']; ?></option>
                      <option value="Open">Open</option> ‎
                    <option value="Recovery">Recovery</option> 
                    <option value="Closed">Closed</option>
                  </select>
                  <br>
                   <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label" style="margin-top:5px;">Closed Amount, £ (if relevant)</label>
                  <p>
                    <input type="text" name="closed_amount" class="form-control" style=" height:38px; width: 240px;" class="form-control" value="<?php echo $settlements['closed_amount']; ?>"/>
                      <select class="form-control" name="closed_amount_currency" style="height:35px; width: 240px; margin-left: 148px;">
                            <option value="<?php echo $settlements['closed_amount_currency']; ?>"><?php echo $settlements['closed_amount_currency']; ?></option>
                            <option value="£">£</option> ‎
                            <option value="$">$</option>
                            <option value="EURO">EURO</option>
                            <option value="EGP">EGP</option>
                          </select>
                  </p> 
                  <br>
                   <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;">Date of Closed Notice (if relevant </label>
                  <div class='input-group date' id='datetimepicker13' style=" width: 240px; margin:10px;">
                    <input type="text" name="closed_date_notice" class="form-control" value="<?php echo $settlements['closed_date_notice']; ?>" /> 
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calender"></span></span>
                  </div>
                  <br>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label" style="margin-top:5px;">Cristal Score (if relevant)</label>
                  <p>
                    <input type="text" name="cristal_score" class="form-control" style=" height:38px; width: 240px;" class="form-control"
                           value="<?php echo $settlements['cristal_score']; ?>"/>
                  </p> 
                  <br>
                   <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label" style="margin-top:5px;"> N. of Claims of the same nature within 3 months</label>
                  <p>
                    <input type="text" name="num_similar_claims" class="form-control" style=" height:38px; width: 240px;" class="form-control"
                           value="<?php echo $settlements['num_similar_claims']; ?>"/>
                  </p> 
                  <br>
                  <br>                  
                  <label for="from-hotel" class="control-label " style="margin-top:5px;">Rationale for Proposed settlements  </label>
                  <p>
                    <textarea type="text" name="Rationale" class="form-control" style=" width: 800px; height:100px;" ><?php echo $settlements['Rationale']; ?></textarea>
                  </p>                  
                  <label for="from-hotel" class="control-label " style="margin-top:5px;">  Potential Risk if Proposed settlements Declined</label>
                  <p>
                    <textarea type="text" name="Risk" class="form-control" style=" width: 800px; height:100px;"><?php echo $settlements['Risk']; ?></textarea>
                  </p> 
                  <br>
                  <br>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;">Status of SAF*</label>
                   <select class="form-control" name="status" style="height:35px; width: 400px; margin-left: 183px;">
                    <option value="<?php echo $settlements['status']; ?>"><?php echo $settlements['status']; ?></option>
                       <?php foreach ($statuss as $status)  :?>
                          <option value = "<?php echo $status['status'] ?>" ><?php echo $status['status'] ?></option>
                       <?php endforeach ?>
                  </select>
                  <br> 
                   <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;">Date of last SAF status </label>
                  <div class='input-group date' id='datetimepicker17' style=" width: 240px; margin:10px;">
                    <input type="text" name="last_saf_date" class="form-control" value="<?php echo $settlements['last_saf_date']; ?>" /> 
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calender"></span></span>
                  </div>
                    <p>
                        <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:20px;">
                              Final settlements reached between SUNRISE and TO**</label>
                    <input type="text" name="final_settlement" class="form-control" style=" height:38px; width: 240px;" class="form-control" value="<?php echo $settlements['final_settlement']; ?>"/>
                      <select class="form-control" name="final_settlement_currency" style="height:35px; width: 240px; margin-left: 148px;">
                            <option value="<?php echo $settlements['final_settlement_currency']; ?>"><?php echo $settlements['final_settlement_currency']; ?></option>
                            <option value="£">£</option> ‎
                            <option value="$">$</option>
                            <option value="EURO">EURO</option>
                            <option value="EGP">EGP</option>
                          </select>
                  <div class='input-group date' id='datetimepicker16' style=" width: 240px; margin:10px;">
                    <input type="text" name="final_settlement_date" class="form-control" value="<?php echo $settlements['final_settlement_date']; ?>" /> 
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calender"></span></span>
                  </div>   
                  </p> 
                  <br>
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <input type="hidden" name="set_id" value="<?php echo $settlements['id']; ?>" />
                      <label for="offers" class="col-lg-3 col-md-4 col-sm-5 col-xs-5 control-label">Report Files</label>
                      
                      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <input id="offers" name="upload" type="file" class="file" multiple="true" data-show-upload="false" data-show-caption="true">
                      </div>
                      <script>
                      $("#offers").fileinput({
                          uploadUrl: "/settlements/make_offer/<?php echo $settlements['id'] ?>", // server upload action
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
      $(function(){
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
   <script type="text/javascript">
       $(function () {
        $('#datetimepicker16').datetimepicker({
          format: 'DD/MM/YYYY'
        });
      });
    </script>
     <script type="text/javascript">
       $(function () {
        $('#datetimepicker17').datetimepicker({
          format: 'DD/MM/YYYY'
        });
      });
    </script>
  </body>
</html>
