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
            <div class="header-logo"><img src="/assets/uploads/logos/<?php echo $settlements['logo']; ?>"/></div>
            <h1 class="centered"><?php echo $settlements['hotel_name']; ?></h1>
            <fieldset>
              <legend class="centered">Submit a purposes of Report for settlements Form No. #<?php echo $settlements['id']?> </legend>
              <?php if(validation_errors() != false): ?>
              <div class="alert alert-danger">
                <?php echo validation_errors(); ?>
              </div>
              <?php endif ?>
              <form action="" method="POST" id="form-submit" enctype="multipart/form-data" class="form-div span12" accept-charset="utf-8">
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                   <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;">Claim Case Type</label>
                   <select class="form-control" name="type" style="height:35px; width: 240px; margin-left: 183px;">
                     <option value="<?php echo $purposes['type']; ?>"><?php echo $purposes['type']; ?></option>
                     <option data-company="0" value="Hotel Negligence">Hotel Negligence</option>
                    <option data-company="0" value="Unfortunate claim (UK Law)">Unfortunate claim (UK Law)</option>
                    <option data-company="0" value="Both (unfortunate UK law and hotel negligence)">       Both (unfortunate UK law and hotel negligence)
                    </option>
                  </select>
                  <br>
                   <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="width: 180px;">  Names and Titles of employees in charge of negligence (if relevant)  </label>
                  <input type="text" name="charged" class="form-control" value="<?php echo $purposes['charged']; ?>" style=" width: 240px; margin:20px;" class="form-control"/>
                  <br>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="width: 180px;">Penalty amount, £ (if relevant</label>
                  <input type="text" name="penalty" class="form-control" value="<?php echo $purposes['penalty']; ?>" style=" width: 240px;"/>
                    <select class="form-control" name="penalty_currency" style="height:35px; width: 240px; margin-left: 180px;">
                            <option value="<?php echo $purposes['penalty_currency']; ?>"><?php echo $purposes['penalty_currency']; ?></option> ‎
                            <option value="£">£</option> ‎
                            <option value="$">$</option> 
                            <option value="EURO">EURO</option>
                            <option value="EGP">EGP</option>
                 </select> 
                  <br>
                   <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="width: 180px;">Actions to prevent such claims in the future</label>
                  <input type="text" name="prevent_claim" class="form-control" value="<?php echo $purposes['prevent_claim']; ?>" style=" width: 240px; margin:20px;" class="form-control"/>
                  <br>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="width: 180px;margin-top: 20px;">Insurance Coverage</label>
                  <input type="text" name="Insurance" class="form-control" value="<?php echo $purposes['Insurance']; ?>" style=" width: 240px; margin:20px;" class="form-control"/>
                  <br>
                   <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:15px;"> 
                         SAF negotiation results, £ (if relevant):</label>
                  <input type="text" name="negotiation" class="form-control" value="<?php echo $purposes['negotiation']; ?>"  style=" height:38px; width: 240px;" class="form-control"/>
                    <select class="form-control" name="negotiation_currency" style="height:35px; width: 240px; margin-left: 180px;">
                     <option value="<?php echo $purposes['negotiation_currency']; ?>"><?php echo $purposes['negotiation_currency']; ?></option>
                            <option value="£">£</option> ‎
                            <option value="$">$</option> 
                            <option value="EURO">EURO</option>
                            <option value="EGP">EGP</option>
                 </select> 
                  <br>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="width: 180px;margin-top: 20px;">
                           Proposed settlements Rejected by</label>
                  <input type="text" name="rejected_by" class="form-control" value="<?php echo $purposes['rejected_by']; ?>" style=" width: 240px; margin:20px;" class="form-control"/>
                  <br>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="width: 180px;margin-top: 20px;">
                           Reason of Rejection</label>
                  <input type="text" name="reject_reason" class="form-control" value="<?php echo $purposes['reject_reason']; ?>" style=" width: 240px; margin:20px;" class="form-control"/>
                  <br>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:15px;"> 
                          Suggestion for Settlement, £</label>
                  <input type="text" name="settlement_suggest" class="form-control" value="<?php echo $purposes['settlement_suggest']; ?>"  style=" height:38px; width: 240px;" class="form-control"/>
                    <select class="form-control" name="settlement_suggest_currency" style="height:35px; width: 240px; margin-left: 180px;">
                     <option value="<?php echo $purposes['settlement_suggest_currency']; ?>"><?php echo $purposes['settlement_suggest_currency']; ?></option>
                            <option value="£">£</option> ‎
                            <option value="$">$</option> 
                            <option value="EURO">EURO</option>
                            <option value="EGP">EGP</option>
                 </select> 
                  <br>                
                </div>
                <div style="margin-top: 90px; margin-bottom: 30px;" class="form-group">
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
  </body>
</html>
