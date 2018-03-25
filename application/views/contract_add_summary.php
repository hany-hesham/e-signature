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
          <div class="a4page" style="margin-bottom: 20px;">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px;">
              <div class="page-header">
                <h1 class="centered">Contract Smmary </h1>
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
                  <table class="table table-striped table-bordered table-condensed" style="width: 730px;">
                    <tr>
                      <td colspan="1" style="font-size:20px;">
                        Hotel Name
                      </td>
                      <td colspan="4" class="centered">
                        <?php echo $new['hotel_name']; ?>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="1" style="font-size:20px;">
                        Contract Title
                      </td>
                      <td colspan="4" class="centered">
                        <?php echo $new['brand']; ?>/<?php echo $new['service_name']; ?>
                      </td>
                    </tr>
                    <tr class="centered">
                      <td colspan="1"> &nbsp; &nbsp; </td>
                      <td colspan="2"  style="font-size:20px; width: 900px !important;"> Old Contract Details </td>
                      <td colspan="2"  style="font-size:20px; width: 900px !important;"> New Contract Details </td>
                    </tr>
                    <tr>
                      <td colspan="1"  style="font-size:20px;"> Contractor Name </td>
                      <td colspan="2" class="centered"> <?php echo $new['name_en_old']; ?> </td>
                      <td colspan="2" class="centered"> <?php echo $new['name_en']; ?> </td>
                    </tr>
                    <tr>
                            <?php 
                              $old_date1 = strtotime($new['from_date_old']);
                              $old_date2 = strtotime($new['to_date_old']); 
                              $old_date = $old_date2 - $old_date1;
                              $old_years = floor($old_date / (365*60*60*24));
                              $old_months = floor(($old_date - $old_years * 365*60*60*24) / (30*60*60*24));
                              $old_days = floor(($old_date - $old_years * 365*60*60*24 - $old_months*30*60*60*24)/ (60*60*24));
                              if ($old_months >= 12) {
                                $old_years++;
                                $old_months = $old_months - 12;
                              }
                            ?>
                            <?php 
                              $new_date1 = strtotime($new['from_date']);
                              $new_date2 = strtotime($new['to_date']); 
                              $new_date = $new_date2 - $new_date1;
                              $new_years = floor($new_date / (365*60*60*24));
                              $new_months = floor(($new_date - $new_years * 365*60*60*24) / (30*60*60*24));
                              $new_days = floor(($new_date - $new_years * 365*60*60*24 - $new_months*30*60*60*24)/ (60*60*24));
                              if ($new_months >= 12) {
                                $new_years++;
                                $new_months = $new_months - 12;
                              }
                            ?>
                            <td colspan="1"  style="font-size:20px;"> Contract Duration </td>
                            <td colspan="2" class="centered"> 
                              <?php 
                                if ($old_years != 0) {
                                  echo $old_years." Years <br>"; 
                                }
                                /*if ($old_months != 0) {
                                  echo $old_months." Monthes <br>";
                                }
                                if ($old_days != 0) {
                                  echo $old_days." Days <br>";
                                }*/
                              ?>
                            </td>
                            <td colspan="2" class="centered"> 
                              <?php 
                                if ($new_years != 0) {
                                  echo $new_years." Years <br>"; 
                                }
                                /*if ($new_months != 0) {
                                  echo $new_months." Monthes <br>";
                                }
                                if ($new_days != 0) {
                                  echo $new_days." Days <br>";
                                }*/
                              ?>
                            </td>
                          </tr>
                    <tr>
                      <td colspan="1"  style="font-size:20px;"> Starting From </td>
                      <td colspan="2" class="centered"> <?php echo $new['from_date_old']; ?> </td>
                      <td colspan="2" class="centered"> <?php echo $new['from_date']; ?> </td>
                    </tr>
                    <tr>
                      <td colspan="1"  style="font-size:20px;"> Ends At </td>
                      <td colspan="2" class="centered"> <?php echo $new['to_date_old']; ?> </td>
                      <td colspan="2" class="centered"> <?php echo $new['to_date']; ?> </td>
                    </tr>
                    <?php if ($new['hotel_id'] == 44) { ?>
                      <tr>
                        <td colspan="1"  style="font-size:20px;"> Monthly Rent for Mamlouk Palace</td>
                        <td colspan="2" class="centered"> <?php echo $new['rent_mp_old']; ?> <?php echo $new['currency_mp_old']; ?> </td>
                        <td colspan="2" class="centered"> <?php echo $new['rent_mp']; ?> <?php echo $new['currency_mp']; ?> </td>
                      </tr>
                      <tr>
                        <td colspan="1"  style="font-size:20px;"> Monthly Rent for Garden Beach</td>
                        <td colspan="2" class="centered"> <?php echo $new['rent_gb_old']; ?> <?php echo $new['currency_gb_old']; ?> </td>
                        <td colspan="2" class="centered"> <?php echo $new['rent_gb']; ?> <?php echo $new['currency_gb']; ?> </td>
                      </tr>
                    <?php }else{ ?>
                      <tr>
                        <td colspan="1"  style="font-size:20px;"> Monthly Rent </td>
                        <td colspan="2" class="centered"> <?php echo $new['rent_old']; ?> <?php echo $new['currency_old']; ?> </td>
                        <td colspan="2" class="centered"> <?php echo $new['rent']; ?> <?php echo $new['currency']; ?> </td>
                      </tr>
                    <?php } ?>
                    <tr>
                      <td colspan="1"  style="font-size:20px;"> Other Conditions </td>
                      <td colspan="2" class="centered"> <?php echo $new['others_old']; ?> </td>
                      <td colspan="2" class="centered"> <?php echo $new['others']; ?> </td>
                    </tr>
                    <tr>
                      <td colspan="1"  style="font-size:20px;"> Advance Rent </td>
                      <td colspan="2" class="centered">
                        <select class="form-control chooosen" name="advance_old" data-placeholder="Advance ...">
                          <option></option>
                          <option value="Yes">Yes</option> ‎
                          <option value="No">No</option> 
                        </select>
                      </td>
                      <td colspan="2" class="centered">
                        <select class="form-control chooosen" name="advance_new" data-placeholder="Advance ...">
                          <option></option>
                          <option value="Yes">Yes</option> ‎
                          <option value="No">No</option> 
                        </select>
                      </td>
                    </tr>
                    <?php if ($new['hotel_id'] == 44) { ?>
                      <tr>
                        <td colspan="1"  style="font-size:20px;"> Deposit for Mamlouk Palace</td>
                        <td colspan="2" class="centered"> <?php echo $new['safty_mp_old']; ?> <?php echo $new['currency1_mp_old']; ?> </td>
                        <td colspan="2" class="centered"> <?php echo $new['safty_mp']; ?> <?php echo $new['currency1_mp']; ?> </td>
                      </tr>
                      <tr>
                        <td colspan="1"  style="font-size:20px;"> Deposit for Garden Beach</td>
                        <td colspan="2" class="centered"> <?php echo $new['safty_gb_old']; ?> <?php echo $new['currency1_gb_old']; ?> </td>
                        <td colspan="2" class="centered"> <?php echo $new['safty_gb']; ?> <?php echo $new['currency1_gb']; ?> </td>
                      </tr>
                    <?php }else{ ?>
                      <tr>
                        <td colspan="1"  style="font-size:20px;"> Deposit </td>
                        <td colspan="2" class="centered"> <?php echo $new['safty_old']; ?> <?php echo $new['currency1_old']; ?> </td>
                        <td colspan="2" class="centered"> <?php echo $new['safty']; ?> <?php echo $new['currency1']; ?> </td>
                      </tr>
                    <?php } ?>
                    <tr>
                      <td colspan="1"  style="font-size:20px;"> Other Comments </td>
                      <td colspan="2" class="centered">
                        <textarea type="text" name="comment_old" class="form-control" rows="3" placeholder="Comments ..."></textarea>
                      </td>
                      <td colspan="2" class="centered">
                        <textarea type="text" name="comment_new" class="form-control" rows="3" placeholder="Comments ..."></textarea>
                      </td>
                    </tr>
                  </table>
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12" style="width: 730px !important;">
                    <br>
                    <input type="hidden" name="contr_id" value="<?php echo $new['id']; ?>" />
                    <label for="offers" style="font-size:20px;">Report Files</label>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                      <input id="offers" name="upload" type="file" class="file" multiple="true" data-show-upload="true" data-show-caption="true">
                    </div>
                    <script>
                      $("#offers").fileinput({
                          uploadUrl: "/contract/upload/<?php echo $new['id'] ?>", 
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
                            <?php if ($is_admin): ?>
                              {url: "/contract/remove/<?php echo $new['id'] ?>/<?php echo $upload['id'] ?>", key: "<?php echo $upload['name']; ?>"},
                            <?php endif ?>
                          <?php endforeach; ?>
                          ],
                      });
                      </script>
                  </div>
                </div>
                <div class="form-group" style="margin-right: 300px;">
                  <input name="submit" value="Submit" type="submit" class="btn btn-success" />
                  <a href="<?= base_url(); ?>contract/summry/<?php echo $new['id'] ?>" class="btn btn-warning">Cancel</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
