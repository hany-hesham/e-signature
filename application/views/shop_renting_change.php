<!DOCTYPE html>
<html lang="en">
  <head>
    <script type="text/javascript">
    function check()
    {
      $("#checking").show();
    }
</script>
    <?php $this->load->view('header'); ?>
  </head>
  <body>
    <div id="wrapper">
      <?php $this->load->view('menu') ?>
      <div id="page-wrapper">
        <div class="">
          <div class="" style="margin-bottom: 10px;">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px;">
              <div class="page-header">
                <h1 class="centered">Shop Renting Prior Approval</h1>
              </div>
              <?php if(validation_errors() != false): ?>
                <div class="alert alert-danger">
                  <?php echo validation_errors(); ?>
                </div>
              <?php endif ?>         
            </div>
            <div class="container">
              <form action="" method="POST" id="form-submit" enctype="multipart/form-data" class="form-div span12" accept-charset="utf-8">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <br>
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <br>
                    <label for="from-hotel" class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" style="margin-top:5px;">Hotel Name</label>
                    <select class="form-control chooosen" data-placeholder="Hotel ..." name="hotel_id" id="from-hotel " style="width: 250px; height:33px;">
                      <option data-company="0" value="<?php echo $shop['hotel_id'] ?>"><?php echo $shop['hotel_name'] ?></option>
                      <?php foreach ($hotels as $hotel): ?>
                        <option value="<?php echo $hotel['id'] ?>"<?php echo set_select('hotel_id',$hotel['id'] ); ?>><?php echo $hotel['name'] ?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                  <br>
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <br>
                    <label for="from-hotel" class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" style="margin-top:5px;">Contract Title</label>
                    <input type="text" class="form-control" name="title" placeholder="Title ..." value="<?php echo $shop['title'] ?>" style="width: 250px; height:33px;"/></input>
                  </div>
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <br>
                    <table class="table table-striped table-bordered table-condensed">
                      <thead>
                        <tr>
                          <th colspan="1" style=" text-align: center;">#</th>
                          <th colspan="1" style=" text-align: center;">Tenant 1</th>
                          <th colspan="1" style=" text-align: center;">Tenant 2</th>
                          <th colspan="1" style=" text-align: center;">Tenant 3</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr style="display: none;">
                          <td>Contract Type</td>
                          <?php foreach ($offers as $offer): ?>
                            <td>
                              <input type="number" class="form-control" name="items[<?php echo $offer['id'] ?>][type_id]" value="<?php echo $offer['type_id']?>" /></input>
                            </td>
                          <?php endforeach;?>
                        </tr>
                        <tr>
                          <td>Choose</td>
                          <?php $x = 0 ?>
                          <?php foreach ($offers as $offer): ?>
                            <td>
                              <input type="radio" class="form-control" name="choosen_id" value="<?php echo $x ?>"/></input>
                            </td>
                            <?php $x++ ?>
                          <?php endforeach;?>
                        </tr>
                        <tr>
                          <td>Tenant Name</td>
                          <?php foreach ($offers as $offer): ?>
                            <td>
                              <input type="text" class="form-control" name="items[<?php echo $offer['id'] ?>][name]" value="<?php echo $offer['name']?>"/></input>
                            </td>
                          <?php endforeach;?>
                        </tr>
                        <tr>
                          <td>Starting From</td>
                           <?php foreach ($offers as $offer): ?>
                            <td>
                              <div class='input-group date' id='datetimepicker1<?php echo $offer['id'] ?>' style="width: 250px; height:33px;">
                                <input type='text' class="form-control" name="items[<?php echo $offer['id'] ?>][start_from]" value="<?php echo $offer['start_from']?>"/>
                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                              </div>
                            </td>
                          <?php endforeach;?>
                        </tr>
                        <tr>
                          <td>End At</td>
                          <?php foreach ($offers as $offer): ?>
                            <td>
                              <div class='input-group date' id='datetimepicker2<?php echo $offer['id'] ?>' style="width: 250px; height:33px;">
                                <input type='text' class="form-control" name="items[<?php echo $offer['id'] ?>][end_at]" value="<?php echo $offer['end_at']?>"/>
                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                              </div>
                            </td>
                          <?php endforeach;?>
                        </tr>
                        <tr>
                          <td>Monthly Rent</td>
                          <?php foreach ($offers as $offer): ?>
                            <td>
                              <input type="number" class="form-control" name="items[<?php echo $offer['id'] ?>][rent]" value="<?php echo $offer['rent']?>"/></input>
                            </td>
                          <?php endforeach;?>
                        </tr>
                        <tr>
                          <td>Currency</td>
                          <?php foreach ($offers as $offer): ?>
                            <td>
                              <select class="form-control chooosen" name="items[<?php echo $offer['id'] ?>][currency_id]" id="from-hotel " data-placeholder="Currency ..." style="width: 250px; height:33px;">
                                <option data-company="0" value="<?php echo $offer['currency_id']?>"><?php echo $offer['currency1']?></option>
                                <?php foreach ($currencies as $currency): ?>
                                  <option value="<?php echo $currency['id'] ?>"><?php echo $currency['name'] ?></option>
                                <?php endforeach ?>
                              </select>
                            </td>
                          <?php endforeach;?>
                        </tr>
                        <tr>
                          <td>Taxes</td>
                          <?php foreach ($offers as $offer): ?>
                            <td>
                              <input type="number" class="form-control" name="items[<?php echo $offer['id'] ?>][taxes]" value="<?php echo $offer['taxes']?>"/></input>
                            </td>
                          <?php endforeach;?>
                        </tr>
                        <tr>
                          <td>Other Conditions</td>
                          <?php foreach ($offers as $offer): ?>
                            <td>
                              <input type="text" class="form-control" name="items[<?php echo $offer['id'] ?>][other]" value="<?php echo $offer['other']?>"/></input>
                            </td>
                          <?php endforeach;?>
                        </tr>
                        <tr>
                          <td>Advance Rent</td>
                          <?php foreach ($offers as $offer): ?>
                            <td>
                            <input type="number" class="form-control" name="items[<?php echo $offer['id'] ?>][advance]" value="<?php echo $offer['advance']?>"/></input>
                            </td>
                          <?php endforeach;?>
                        </tr>
                        <tr>
                          <td>Currency</td>
                          <?php foreach ($offers as $offer): ?>
                            <td>
                              <select class="form-control chooosen" name="items[<?php echo $offer['id'] ?>][currency1_id]" id="from-hotel " data-placeholder="Currency ..." style="width: 250px; height:33px;">
                                <option data-company="0" value="<?php echo $offer['currency1_id']?>"><?php echo $offer['currency2']?></option>
                                <?php foreach ($currencies as $currency): ?>
                                  <option value="<?php echo $currency['id'] ?>"><?php echo $currency['name'] ?></option>
                                <?php endforeach ?>
                              </select>
                            </td>
                          <?php endforeach;?>
                        </tr>
                        <tr>
                          <td>Deposit</td>
                          <?php foreach ($offers as $offer): ?>
                            <td>
                              <input type="number" class="form-control" name="items[<?php echo $offer['id'] ?>][deposite]" value="<?php echo $offer['deposite']?>"/></input>
                            </td>
                          <?php endforeach;?>
                        </tr>
                        <tr>
                          <td>Currency</td>
                          <?php foreach ($offers as $offer): ?>
                            <td>
                              <select class="form-control chooosen" name="items[<?php echo $offer['id'] ?>][currency2_id]" id="from-hotel " data-placeholder="Currency ..." style="width: 250px; height:33px;">
                                <option data-company="0" value="<?php echo $offer['currency2_id']?>"><?php echo $offer['currency3']?></option>
                                <?php foreach ($currencies as $currency): ?>
                                  <option value="<?php echo $currency['id'] ?>"><?php echo $currency['name'] ?></option>
                                <?php endforeach ?>
                              </select>
                            </td>
                          <?php endforeach;?>
                        </tr>
                        <tr>
                          <td>Location</td>
                          <?php foreach ($offers as $offer): ?>
                            <td>
                              <input type="text" class="form-control" name="items[<?php echo $offer['id'] ?>][location]" value="<?php echo $offer['location']?>"/></input>
                            </td>
                          <?php endforeach;?>
                        </tr>
                        <tr>
                          <td>References</td>
                          <?php foreach ($offers as $offer): ?>
                            <td>
                              <input type="text" class="form-control" name="items[<?php echo $offer['id'] ?>][reference]" value="<?php echo $offer['reference']?>"/></input>
                            </td>
                          <?php endforeach;?>
                        </tr>
                        <tr>
                          <td>Reference By</td>
                          <?php foreach ($offers as $offer): ?>
                            <td>
                              <input type="text" class="form-control" name="items[<?php echo $offer['id'] ?>][by_reference]" value="<?php echo $offer['by_reference']?>"/></input>
                            </td>
                          <?php endforeach;?>
                        </tr>
                        <tr>
                          <td>Who Is Reference</td>
                          <?php foreach ($offers as $offer): ?>
                            <td>
                              <input type="text" class="form-control" name="items[<?php echo $offer['id'] ?>][who_reference]" value="<?php echo $offer['who_reference']?>"/></input>
                            </td>
                          <?php endforeach;?>
                        </tr>
                        <tr>
                          <td>Design Attached</td>
                          <?php foreach ($offers as $offer): ?>
                            <td>
                              <input type="file" class="form-control" name="items-<?php echo $offer['id'] ?>-design" value="<?php echo $offer['design']?>" style="width: 210px;"/>
                            </td>
                          <?php endforeach;?>
                        </tr>
                        <tr>
                          <td>Attached Offer</td>
                          <?php foreach ($offers as $offer): ?>
                            <td>
                              <input type="file" class="form-control" name="items-<?php echo $offer['id'] ?>-offer" value="<?php echo $offer['offer']?>" style="width: 210px;"/>
                            </td>
                          <?php endforeach;?>
                        </tr>
                        <tr>
                          <td>Attached CV</td>
                          <?php foreach ($offers as $offer): ?>
                            <td>
                              <input type="file" class="form-control" name="items-<?php echo $offer['id'] ?>-cv" value="<?php echo $offer['cv']?>" style="width: 210px;"/>
                            </td>
                          <?php endforeach;?>
                        </tr>
                        <tr>
                          <td>Attached Contract </td>
                          <?php foreach ($offers as $offer): ?>
                            <td>
                              <input type="file" class="form-control" name="items-<?php echo $offer['id'] ?>-contract" value="<?php echo $offer['contract']?>" style="width: 210px;"/>
                            </td>
                          <?php endforeach;?>
                        </tr>
                      </tbody>
                    </table>    
                  </div>
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <br>
                    <label for="from-hotel" class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" style="margin-top:5px;">Tenant Recommendation</label>
                    <input type="text" class="form-control" name="recommendation" placeholder="Recommendation ..." value="" style="width: 450px; height:33px;"/></input>
                  </div>
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <br>
                    <label for="from-hotel" class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" style="margin-top:5px;">Reason</label>
                    <textarea type="text" name="reason" class="form-control" rows="3" placeholder="Reason..." style="width: 650px;"></textarea>
                  </div>
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 50px !important;">
                    <br>
                    <input type="hidden" name="shop_id" value="<?php echo $shop['id'] ?>" />
                    <label for="offers" class="col-lg-3 col-md-4 col-sm-5 col-xs-5 control-label">Report Files</label>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                      <input id="offers" name="upload" type="file" class="file" multiple="true" data-show-upload="false" data-show-caption="true">
                    </div>
                    <script>
                      $("#offers").fileinput({
                        uploadUrl: "/shop_renting/upload/<?php echo $shop['id'] ?>",
                        uploadAsync: true,
                        minFileCount: 1,
                        maxFileCount: 100,
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
                            {url: "/shop_renting/remove/<?php echo $shop['id'] ?>/<?php echo $upload['id'] ?>", key: "<?php echo $upload['name']; ?>"},
                          <?php endforeach; ?>
                        ],
                      });
                    </script>
                  </div>
                  <div class="form-group">
                    <div class="col-lg-offset-3 col-lg-10 col-md-10 col-md-offset-3">
                      <input name="submit" value="Submit" type="submit" class="btn btn-success" onClick="check();" />
                       <div id="checking" style="display:none;position: fixed;top: 0;left: 0;width: 100%;height: 100%;background: #f4f4f4;z-index: 99;">
                          <div class="text" style="position: absolute;top: 45%;left: 0;height: 100%;width: 100%;font-size: 18px;text-align: center;">
                              <center><img src="<?php echo base_url();?>assets/images/ajax-loader.gif" alt="Loading"></center>
                               Please Wait!<Br><b style="color: red;">few seconds</b>
                          </div>
                        </div>
                      <a href="<?= base_url(); ?>shop_renting/view/<?php echo $shop['id'] ?>" class="btn btn-warning">Cancel</a>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
  <script type="text/javascript">
    $(function () {
      $('#datetimepicker').datetimepicker({
        format: 'YYYY-MM-DD'
      });
    });
  </script>
  <?php foreach ($offers as $offer): ?>
    <script type="text/javascript">
      $(function () {
        $('#datetimepicker1<?php echo $offer['id'] ?>').datetimepicker({
          format: 'YYYY-MM-DD'
        });
      });
    </script>
    <script type="text/javascript">
      $(function () {
        $('#datetimepicker2<?php echo $offer['id'] ?>').datetimepicker({
          format: 'YYYY-MM-DD'
        });
      });
    </script>
  <?php endforeach; ?>
  <script type="text/javascript">
    document.items = <?php echo json_encode($this->input->post('items')); ?>;
  </script>
  <script type="text/javascript">
    document.body.addEventListener("keydown", function (event) {
      if (event.keyCode === 27) {
        window.location.replace("<?= base_url(); ?>shop_renting/");
      }
    });  
  </script>
</html>
