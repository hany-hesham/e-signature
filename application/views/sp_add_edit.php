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
                          <th colspan="1" style=" text-align: center;">actoins</th>
                        </tr>
                      </thead>
                      <tbody id="items-container" data-items="1">
                        <?php foreach ($items as $item): ?>
                          <tr class="item-row" style="font-size: 12px; font-weight: bold;">
                            <td class="centered"><?php echo $item['booking']; ?></td>
                            <td class="centered"><?php echo $item['operator']; ?></td>
                            <td class="centered"><?php echo $item['guest']; ?></td>
                            <td class="centered"><?php echo $item['arrival']; ?></td>
                            <td class="centered"><?php echo $item['departure']; ?></td>
                            <td class="centered"><?php echo $item['room']; ?></td>
                            <td class="centered"><?php echo $item['pax']; ?></td>
                            <td class="centered"><?php echo $item['rate']; ?>&nbsp;&nbsp;<?php echo $item['currency']; ?></td>
                            <td class="centered"><?php echo $item['publish']; ?>&nbsp;&nbsp;<?php echo $item['currency2']; ?></td>
                            <td class="centered"><?php echo $item['discount']; ?>&nbsp;&nbsp;%</td>
                            <td class="centered"><?php echo $item['room_type']; ?></td>
                            <td class="centered"><?php echo $item['board_name']; ?></td>
                            <td class="centered"><?php echo $item['remarks']; ?></td>
                            <td class="centered"><a href="/assets/uploads/files/<?php echo $item['fille']; ?>"><?php echo $item['fille']; ?></a></td>
                            <td class="centered"></td>
                          </tr>
                        <?php endforeach ?>
                        <tr id="item-1">
                          <td class="centered"> 
                            <input type="text" class="form-control" name="items[1][booking]"  id="item-1-booking" style="width: 150px; height:34px;"/></input>
                          </td>
                          <td class="centered"> 
                            <input type="text" class="form-control" name="items[1][operator]"  id="item-1-operator" style="width: 150px; height:34px;"/></input>
                          </td>
                          <td class="centered"> 
                            <input type="text" class="form-control" name="items[1][guest]"  id="item-1-guest" style="width: 150px; height:34px;"/></input>
                          </td>
                          <td class="centered"> 
                            <input class="form-control date-picker" type="date" data-date-format="dd-mm-yyy" name="items[1][arrival]" id="item-1-arrival" style="width: 160px; height:34px;"/>
                          </td>
                          <td class="centered"> 
                            <input class="form-control date-picker" type="date" data-date-format="dd-mm-yyy" name="items[1][departure]" id="item-1-departure" style="width: 160px; height:34px;"/>
                          </td>
                          <td class="centered"> 
                            <input type="text" class="form-control" name="items[1][room]"  id="item-1-room" style="width: 110px; height:34px;"/></input>
                          </td>
                          <td class="centered"> 
                            <input type="text" class="form-control" name="items[1][pax]"  id="item-1-pax" style="width: 100px; height:34px;"/></input>
                          </td>
                          <td class="centered"> 
                            <input type="text" class="form-control" name="items[1][rate]" id="item-1-rate" style="width: 100px; height:34px;"/>
                            <select class="form-control" name="items[1][currency]" id="item-1-currency">
                              <option value="">Currency</option>
                              <option value="£">£</option> ‎
                              <option value="$">$</option> 
                              <option value="EURO">EURO</option>
                              <option value="EGP">EGP</option>
                            </select>
                          </td>
                          <td class="centered"> 
                            <input type="text" class="form-control" name="items[1][publish]" id="item-1-publish" style="width: 100px; height:34px;"/>
                            <select class="form-control" name="items[1][currency2]" id="item-1-currency2">
                              <option value="">Currency</option>
                              <option value="£">£</option> ‎
                              <option value="$">$</option> 
                              <option value="EURO">EURO</option>
                              <option value="EGP">EGP</option>
                            </select>
                          </td>
                          <td class="centered"> 
                            <input type="text" class="form-control" name="items[1][discount]"  id="item-1-discount" style="width: 100px; height:34px;"/>%</input>
                          </td>
                          <td class="centered"> 
                            <input type="text" class="form-control" name="items[1][room_type]"  id="item-1-room_type" style="width: 100px; height:34px;"/></input>
                          </td>
                          <td class="centered"> 
                            <select class="form-control" name="items[1][board_id]" id="item-1-board_id" style="width: 160px; height:34px;">
                              <option data-company="0" value="">Select Board..</option>
                              <?php foreach ($boards as $board): ?>
                                <option value="<?php echo $board['id'] ?>"<?php echo set_select('board_id',$board['id'] ); ?>><?php echo $board['name'] ?></option>
                              <?php endforeach ?>
                            </select>
                          </td>
                          <td class="centered"> 
                            <textarea type="text" name="items[1][remarks]"  id="item-1-remarks" class="form-control" rows="" style="width: 200px;"></textarea>
                          </td>
                          <td class="centered">
                            <input type="file" class="form-control" name="items-1-fille" id="item-1-fille" value="" style="width: 210px;"/>
                          </td>
                          <td class="centered">
                            <span data-item-id="1" class="form-actions btn btn-danger remove-item" style="width: 100px;">Remove</span>
                          </td>
                        </tr>
                      </tbody>
                      <tfoot>
                        <tr>
                          <td colspan="14"></td>
                          <td class="centered">
                            <span class="form-actions btn btn-primary" id="add-item" style="width: 100px;">Add Room</span>
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
    <script id="item-template" type="text/x-handlebars-template">
      <tr id="item-{{id}}">
        <td class="centered">
          <input type="text" class="form-control" name="items[{{id}}][booking]" id="item-{{id}}-booking" style="width: 150px; height:34px;"  value="{{booking}}"/>  
        </td>
        <td class="centered"> 
          <input type="text" class="form-control" name="items[{{id}}][operator]" id="item-{{id}}-operator" style="width: 150px; height:34px;"  value="{{operator}}"/>  
        </td>
        <td class="centered">
          <input type="text" class="form-control" name="items[{{id}}][guest]" id="item-{{id}}-guest" style="width: 150px; height:34px;"  value="{{guest}}"/>  
        </td>
        <td class="centered">
          <input class="form-control date-picker" type="date" data-date-format="dd-mm-yyy" name="items[{{id}}][arrival]" id="item-{{id}}-arrival" style="width: 160px; height:34px;" value="{{arrival}}"/>
        </td>
        <td class="centered">
          <input class="form-control date-picker" type="date" data-date-format="dd-mm-yyy" name="items[{{id}}][departure]" id="item-{{id}}-departure" style="width: 160px; height:34px;" value="{{departure}}"/>
        </td>
        <td class="centered">
          <input type="text" class="form-control" name="items[{{id}}][room]" id="item-{{id}}-room" style="width: 110px; height:34px;"  value="{{room}}"/>  
        </td>
        <td class="centered">
          <input type="text" class="form-control" name="items[{{id}}][pax]" id="item-{{id}}-pax" style="width: 100px; height:34px;"  value="{{pax}}"/>  
        </td>
        <td class="centered">
          <input type="text" class="form-control" name="items[{{id}}][rate]" id="item-{{id}}-rate" style="width: 100px; height:34px;"  value="{{rate}}"/>
          <select class="form-control" name="items[{{id}}][currency]" id="item-{{id}}-currency">
            <option value="{{currency}}">Currency</option>
            <option value="£">£</option> ‎
            <option value="$">$</option> 
            <option value="EURO">EURO</option>
            <option value="EGP">EGP</option>
          </select>  
        </td>
        <td class="centered">
          <input type="text" class="form-control" name="items[{{id}}][publish]" id="item-{{id}}-publish" style="width: 100px; height:34px;"  value="{{publish}}"/>
          <select class="form-control" name="items[{{id}}][currency2]" id="item-{{id}}-currency2">
            <option value="{{currency2}}">Currency</option>
            <option value="£">£</option> ‎
            <option value="$">$</option> 
            <option value="EURO">EURO</option>
            <option value="EGP">EGP</option>
          </select>  
        </td>
        <td class="centered">
          <input type="text" class="form-control" name="items[{{id}}][discount]" id="item-{{id}}-discount" style="width: 100px; height:34px;"  value="{{discount}}"/>%
        </td>
        <td class="centered">
          <input type="text" class="form-control" name="items[{{id}}][room_type]" id="item-{{id}}-room_type" style="width: 100px; height:34px;"  value="{{room_type}}"/>
        </td>
        <td class="centered">
          <select class="form-control" name="items[{{id}}][board_id]" id="item-{{id}}-board_id" style="width: 160px; height:34px;">
            <option data-company="0" value="">Select Board..</option>
            <?php foreach ($boards as $board): ?>
              <option value="<?php echo $board['id'] ?>"<?php echo set_select('board_id',$board['id'] ); ?>><?php echo $board['name'] ?></option>
            <?php endforeach ?>
          </select> 
        </td>
        <td class="centered">
          <textarea type="text" name="items[{{id}}][remarks]"  id="item-{{id}}-remarks" class="form-control" rows="" style="width: 200px;"></textarea>
        </td>
        <td class="centered">
          <input type="file" class="form-control" name="items-{{id}}-fille" id="item-{{id}}-fille" value="" style="width: 210px;"/>
        </td>
        <td class="centered">
          <span data-item-id="{{id}}" class="form-actions btn btn-danger remove-item" style="width: 100px;">Remove</span>
        </td>
      </tr>
    </script>
  </body>
</html>
        
      