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
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px;">
              <div class="page-header">
                <h1 class="centered">Special Rates</h1>
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
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label" style="margin-top:5px;"> Hotel Name </label>
                    <input type="text" class="form-control" value="<?php echo $sp['hotel_name']?>" readonly="readonly"  style="width: 240px; height:34px;"/></input>
                    <select class="form-control" name="hotel_id" id="from-hotel " style="width: 240px; height:34px; display: none;">
                      <option data-company="0" value="<?php echo $sp['hotel_id'] ?>"><?php echo $sp['hotel_name'] ?></option>
                        <?php foreach ($hotels as $hotel): ?>
                      <option value="<?php echo $hotel['id'] ?>"<?php echo set_select('hotel_id',$hotel['id'] ); ?>><?php echo $hotel['name'] ?></option>
                        <?php endforeach ?>
                    </select>
                    <br>
                    <br>
                  </div>
                  <div style="margin-left: -50px;" >
                    <table class="table table-striped table-bordered table-condensed">
                      <thead>
                        <tr>
                          <th colspan="1" style=" text-align: center;">Booking Received From</th>
                          <th colspan="1" style=" text-align: center;">Travel Agent</th>
                          <th colspan="1" style=" text-align: center;">Guest Name</th>
                          <th colspan="1" style=" text-align: center;">Arrival Date</th>
                          <th colspan="1" style=" text-align: center;">Departure Date</th>
                          <th colspan="1" style=" text-align: center;">Number Of Rooms</th>
                          <th colspan="1" style=" text-align: center;">Number Of Pax</th>
                          <th colspan="1" style=" text-align: center;">Rate</th>
                          <th colspan="1" style=" text-align: center;">Publish Rate</th>
                          <th colspan="1" style=" text-align: center;">Discount</th>
                          <th colspan="1" style=" text-align: center;">Room Type</th>
                          <th colspan="1" style=" text-align: center;">Board</th>
                          <th colspan="1" style=" text-align: center;">Remarks</th>
                          <th colspan="1" style=" text-align: center;">Attachment</th>
                          <th colspan="1" style=" text-align: center;">Action</th>
                        </tr>
                      </thead>
                      <tbody id="items-container" data-items="1">
                        <?php foreach ($items as $item): ?>
                          <tr id="item-1">
                            <td class="centered" style="display: none">
                              <input class="form-control" name="items[<?php echo $item['id']?>][id]" value="<?php echo $item['id']?>">
                            </td>
                            <td class="centered"> 
                              <input type="text" class="form-control" name="items[<?php echo $item['id']?>][booking]" value="<?php echo $item['booking']?>" style="width: 150px; height:34px;"/></input>
                            </td>
                            <td class="centered"> 
                              <input type="text" class="form-control" name="items[<?php echo $item['id']?>][operator]" value="<?php echo $item['operator']?>" style="width: 150px; height:34px;"/></input>
                            </td>
                            <td class="centered"> 
                              <input type="text" class="form-control" name="items[<?php echo $item['id']?>][guest]" value="<?php echo $item['guest']?>" style="width: 150px; height:34px;"/></input>
                            </td>
                            <td class="centered"> 
                              <input class="form-control date-picker" type="date" data-date-format="dd-mm-yyy" name="items[<?php echo $item['id']?>][arrival]" value="<?php echo $item['arrival']?>" style="width: 160px; height:34px;"/>
                            </td>
                            <td class="centered"> 
                              <input class="form-control date-picker" type="date" data-date-format="dd-mm-yyy" name="items[<?php echo $item['id']?>][departure]" value="<?php echo $item['departure']?>" style="width: 160px; height:34px;"/>
                            </td>
                            <td class="centered"> 
                              <input type="text" class="form-control" name="items[<?php echo $item['id']?>][room]" value="<?php echo $item['room']?>"  style="width: 110px; height:34px;"/></input>
                            </td>
                            <td class="centered"> 
                              <input type="text" class="form-control" name="items[<?php echo $item['id']?>][pax]" value="<?php echo $item['pax']?>"  style="width: 100px; height:34px;"/></input>
                            </td>
                            <td class="centered"> 
                              <input type="text" class="form-control" name="items[<?php echo $item['id']?>][rate]" value="<?php echo $item['rate']?>" style="width: 100px; height:34px;"/>
                              <select class="form-control" name="items[<?php echo $item['id']?>][currency]" >
                                <option value="<?php echo $item['currency']?>"><?php echo $item['currency']?></option>
                                <option value="£">£</option> ‎
                                <option value="$">$</option> 
                                <option value="EURO">EURO</option>
                                <option value="EGP">EGP</option>
                              </select>
                            </td>
                            <td class="centered"> 
                              <input type="text" class="form-control" name="items[<?php echo $item['id']?>][publish]" value="<?php echo $item['publish']?>" style="width: 100px; height:34px;"/>
                              <select class="form-control" name="items[<?php echo $item['id']?>][currency2]" >
                                <option value="<?php echo $item['currency2']?>"><?php echo $item['currency2']?></option>
                                <option value="£">£</option> ‎
                                <option value="$">$</option> 
                                <option value="EURO">EURO</option>
                                <option value="EGP">EGP</option>
                              </select>
                            </td>
                            <td class="centered"> 
                              <input type="text" class="form-control" name="items[<?php echo $item['id']?>][discount]" value="<?php echo $item['discount']?>" readonly="readonly" style="width: 100px; height:34px;"/>%</input>
                            </td>
                            <td class="centered"> 
                              <input type="text" class="form-control" name="items[<?php echo $item['id']?>][room_type]" style="width: 100px; height:34px;" value="<?php echo $item['room_type']?>" /></input>
                            </td>
                            <td class="centered"> 
                              <select class="form-control" name="items[<?php echo $item['id']?>][board_id]" style="width: 160px; height:34px;">
                                <option data-company="0" value="<?php echo $item['board_id'] ?>"><?php echo $item['board_name'] ?></option>
                                <?php foreach ($boards as $board): ?>
                                  <option value="<?php echo $board['id'] ?>"<?php echo set_select('board_id',$board['id'] ); ?>><?php echo $board['name'] ?></option>
                                <?php endforeach ?>
                              </select>
                            </td>
                            <td class="centered"> 
                              <textarea type="text" name="items[<?php echo $item['id']?>][remarks]"  class="form-control" rows="" style="width: 200px;"><?php echo $item['remarks']?></textarea>
                            </td>
                            <td class="centered">
                              <input type="file" class="form-control" name="items-<?php echo $item['id']?>-fille" value="" style="width: 210px;"/>
                            </td>
                          <td></td>
                          </tr>
                        <?php endforeach; ?>
                      </tbody>
                      <tfoot>
                        <tr>
                          <td colspan="14"></td>
                          <td class="centered">
                            <a href="<?= base_url(); ?>rate_sp/submit_edit/<?php echo $sp['id'] ?>" class="btn btn-warning">Add Room</a>
                          </td>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                  <div class="form-group col-lg-12 col-md-10 col-sm-12 col-xs-12">
                    <br>
                    <input type="hidden" name="sp_id" value="<?php echo $sp['id']; ?>" />
                    <label for="offers" class="col-lg-3 col-md-4 col-sm-5 col-xs-5 control-label">Report Files</label>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                      <input id="offers" name="upload" type="file" class="file" multiple="true" data-show-upload="false" data-show-caption="true">
                    </div>
                    <script>
                      $("#offers").fileinput({
                        uploadUrl: "/rate_sp/make_offer/<?php echo $sp['id']; ?>",
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
                            {url: "/rate_sp/remove_offer/<?php echo $sp['id'] ?>/<?php echo $upload['id'] ?>", key: "<?php echo $upload['name']; ?>"},
                          <?php endforeach; ?>
                        ],
                      });
                    </script>
                  </div>
                </div>
                <div class="col-lg-offset-3 col-lg-10 col-md-10 col-md-offset-3">
                  <br>
                  <br>
                  <input name="submit" value="Submit" type="submit" class="btn btn-success" />
                  <a href="<?= base_url(); ?>rate_sp/view/<?php echo $sp['id'] ?>" class="btn btn-warning">Cancel</a>
                  <br>
                  <br>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script type="text/javascript">
      document.items = <?php echo json_encode($this->input->post('items')); ?>;
    </script>
  </body>
</html>
        
      