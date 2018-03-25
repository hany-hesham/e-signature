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
              <legend>Submit a new Settlement</legend>
              <?php if(validation_errors() != false): ?>
              <div class="alert alert-danger">
                <?php echo validation_errors(); ?>
              </div>
              <?php endif ?>
              <form action="" method="POST" id="form-submit" enctype="multipart/form-data" class="form-div span12" accept-charset="utf-8">
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;"> Hotel Name </label>
                  <select class="form-control" name="hotel_id" id="from-hotel " style="width: 30%;">
                    <option data-company="0" value="">Select Hotel..</option>
                    <?php foreach ($hotels as $hotel): ?>
                    <option value="<?php echo $hotel['id'] ?>" <?php echo set_select('hotel_id',$hotel['id'] ); ?>><?php echo $hotel['name'] ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;"> Recovered Amount </label>
                  <p>
                    <input type="text" name="amount" class="form-control" style=" height:38px; width: 240px;" class="form-control"/>
                    <br>
                    <select class="form-control" name="currency" style="height:35px; width: 240px; margin-left: 148px;">
                            <option value="">Select currency</option>
                            <option value="£">£</option> ‎
                            <option value="$">$</option> 
                            <option value="EURO">EURO</option>
                            <option value="EGP">EGP</option>
                          </select>
                  </p>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;"> Date </label>
                  <div class='input-group date' id='datetimepicker10' style=" width: 240px; margin:10px;">
                    <input type="text" name="Date" class="form-control" /> 
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calender"></span></span>
                  </div>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;"> Valid Till </label>
                  <div class='input-group date' id='datetimepicker11' style=" width: 240px; margin:10px;">
                    <input type="text" name="Date_till" class="form-control" /> 
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calender"></span></span>
                  </div>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;"> File Name </label>
                  <p>
                    <input type="text" name="File" class="form-control" style=" height:38px; width: 240px;" class="form-control"/>
                  </p>
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;"> Booking Ref</label>
                  <p>
                    <input type="text" name="Ref" class="form-control" style=" height:38px; width: 240px;"/>
                  </p>
                  <label for="from-hotel" class="control-label " style="margin-top:5px;"> Nature of Claim </label>
                  <p>
                    <textarea type="text" name="Claim" class="form-control" style=" width: 800px; height:100px;"></textarea>
                  </p>
                  <label for="from-hotel" class="ontrol-label " style="margin-top:5px;"> Proposed settlement </label>
                  <p>
                    <textarea type="text" name="Proposed" class="form-control" style=" width: 800px; height:100px;"></textarea>
                  </p>                  
                  <label for="from-hotel" class="control-label " style="margin-top:5px;"> Rationale for Proposed settlement </label>
                  <p>
                    <textarea type="text" name="Rationale" class="form-control" style=" width: 800px; height:100px;"></textarea>
                  </p>                  
                  <label for="from-hotel" class="control-label " style="margin-top:5px;"> Potential Risk if Proposed settlement Declined </label>
                  <p>
                    <textarea type="text" name="Risk" class="form-control" style=" width: 800px; height:100px;"></textarea>
                  </p>                  
                  <label for="from-hotel" class="control-label " style="margin-top:5px;"> Proposed settlement Rejected by</label>
                  <p>
                    <textarea type="text" name="Rejected" class="form-control" style=" width: 800px; height:100px;"></textarea>
                  </p>
                  <label for="from-hotel" class="control-label " style="margin-top:5px;"> Reason of Rejection</label>
                  <p>
                    <textarea type="text" name="Reason" class="form-control" style=" width: 800px; height:100px;"></textarea>
                  </p>                  
                  <label for="from-hotel" class="control-label " style="margin-top:5px;"> Suggestion for settlement (Please detail here any offer you would wish to make)</label>
                  <p>
                    <textarea type="text" name="Suggestion" class="form-control" style=" width: 800px; height:100px;"></textarea>
                  </p> 
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <input type="hidden" name="assumed_id" value="<?php echo $assumed_id; ?>" />
                      <label for="offers" class="col-lg-3 col-md-4 col-sm-5 col-xs-5 control-label">Report Files</label>
                      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <input id="offers" name="upload" type="file" class="file" multiple="true" data-show-upload="false" data-show-caption="true">
                      </div>
                      <script>
                      $("#offers").fileinput({
                          uploadUrl: "/settlement/make_offer/<?php echo $assumed_id; ?>", // server upload action
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
                              {url: "/settlement/remove_offer/<?php echo $settlement['id'] ?>/<?php echo $upload['id'] ?>", key: "<?php echo $upload['name']; ?>"},
                          <?php endforeach; ?>
                          ],
                      });
                      </script>
                  </div>
                  <label for="from-hotel" class="control-label " style="margin-top:5px;"> Proposed settlement Agreed by</label> 
                  <p>
                    <textarea type="text" name="Agreed" class="form-control" style=" width: 800px; height:100px;"></textarea>
                  </p>  
                </div>
                <div style="    margin-top: 90px;" class="form-group">
                  <div class="col-lg-offset-3 col-lg-10 col-md-10 col-md-offset-3">
                    <input name="submit" value="Submit" type="submit" class="btn btn-success" />
                    <a href="<?= base_url(); ?>settlement" class="btn btn-warning">Cancel</a>
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
        $('#datetimepicker10').datetimepicker();
      });
    </script>
    <script type="text/javascript">
      $(function(){
        $('#datetimepicker11').datetimepicker();
      });
    </script>
  </body>
</html>
