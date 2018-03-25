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
          <div class="a4page" style="margin-bottom: 10px;">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px;">
              <div class="page-header">
                <?php if (isset($id) && $id): ?>
                  <a class="form-actions btn btn-info non-printable" href="/market/market_stage/<?php echo $id ?>" style="float:right;" > Finish </a>
                <?php endif ?>
                <h1 class="centered">Local Market Rates</h1>
              </div>
              <?php if(validation_errors() != false): ?>
                <div class="alert alert-danger">
                  <?php echo validation_errors(); ?>
                </div>
              <?php endif ?>         
            </div>
            <div class="container">
              <form action="" method="POST" id="form-submit" enctype="multipart/form-data" class="form-div span12" accept-charset="utf-8">
                <div class="form-group col-lg-8 col-md-8 col-sm-8 col-xs-8">
                  <br>
                  <table class="table table-striped table-bordered table-condensed"> 
                    <thead>
                      <tr>
                        <th colspan="1" style=" text-align: center;">From</th>
                        <th colspan="1" style=" text-align: center;">To</th>
                        <th colspan="1" style=" text-align: center;">actoins</th>
                      </tr>
                    </thead>
                    <tbody id="items-container" data-items="1">
                      <tr id="item-1">
                        <td class="centered"> 
                          <input type="date" class="form-control" name="period[1][from_date]"  id="item-1-from_date"/></input>
                        </td>
                        <td class="centered"> 
                          <input type="date" class="form-control" name="period[1][to_date]"  id="item-1-to_date"/></input>
                        </td>
                        <td class="centered">
                          <span data-item-id="1" class="form-actions btn btn-danger remove-item" style="width: 100px;">Remove</span>
                        </td>
                      </tr>
                    </tbody>
                    <tfoot>
                      <tr>
                        <td colspan="2"></td>
                        <td class="centered">
                          <span class="form-actions btn btn-primary" id="add-item" style="width: 100px;">Add Room</span>
                        </td>
                      </tr>
                    </tfoot>
                  </table>    
                </div>
                <div class="form-group col-lg-8 col-md-8 col-sm-8 col-xs-8">
                  <br>
                  <table class="table table-striped table-bordered table-condensed"> 
                    <thead>
                      <tr>
                        <th colspan="1" style=" text-align: center; width: 250px;">Hotel</th>
                        <th colspan="1" style=" text-align: center;">Price</th>
                        <th colspan="1" style=" text-align: center;">Currency</th>
                      </tr>
                    </thead>
                    <tbody id="itemsss-container" data-itemsss="01">
                      <tr id="itemss-01">
                        <td class=""> 
                          SUNRISE Garden Beach
                          <input style="display: none" type="number" class="form-control" name="hotel[1][hotel_id]" value="1" /></input>
                        </td>
                        <td class="centered"> 
                          <input type="number" class="form-control" name="hotel[1][price]"/></input>
                        </td>
                        <td class="centered"> 
                          <select class="form-control chooosen" name="hotel[1][currency]" data-placeholder="Currency ..." style="width: 100px;">
                            <option> Currency ...</option>
                            <option value="£">£</option> ‎
                            <option value="$">$</option> 
                            <option value="EURO">EURO</option>
                            <option value="EGP">EGP</option>
                          </select>
                        </td>
                      </tr>
                      <tr id="itemss-01">
                        <td class=""> 
                          SENTIDO Mamlouk Palace
                          <input style="display: none" type="number" class="form-control" name="hotel[2][hotel_id]" value="2" /></input>
                        </td>
                        <td class="centered"> 
                          <input type="number" class="form-control" name="hotel[2][price]"/></input>
                        </td>
                        <td class="centered"> 
                          <select class="form-control chooosen" name="hotel[2][currency]" data-placeholder="Currency ..." style="width: 100px;">
                            <option> Currency ...</option>
                            <option value="£">£</option> ‎
                            <option value="$">$</option> 
                            <option value="EURO">EURO</option>
                            <option value="EGP">EGP</option>
                          </select>
                        </td>
                      </tr>
                      <tr id="itemss-01">
                        <td class=""> 
                          SUNRISE Crystal Bay
                          <input style="display: none" type="number" class="form-control" name="hotel[3][hotel_id]" value="3" /></input>
                        </td>
                        <td class="centered"> 
                          <input type="number" class="form-control" name="hotel[3][price]"/></input>
                        </td>
                        <td class="centered"> 
                          <select class="form-control chooosen" name="hotel[3][currency]" data-placeholder="Currency ..." style="width: 100px;">
                            <option> Currency ...</option>
                            <option value="£">£</option> ‎
                            <option value="$">$</option> 
                            <option value="EURO">EURO</option>
                            <option value="EGP">EGP</option>
                          </select>
                        </td>
                      </tr>
                      <tr id="itemss-01">
                        <td class=""> 
                          SUNRISE Royal Makadi
                          <input style="display: none" type="number" class="form-control" name="hotel[4][hotel_id]" value="4" /></input>
                        </td>
                        <td class="centered"> 
                          <input type="number" class="form-control" name="hotel[4][price]"/></input>
                        </td>
                        <td class="centered"> 
                          <select class="form-control chooosen" name="hotel[4][currency]" data-placeholder="Currency ..." style="width: 100px;">
                            <option> Currency ...</option>
                            <option value="£">£</option> ‎
                            <option value="$">$</option> 
                            <option value="EURO">EURO</option>
                            <option value="EGP">EGP</option>
                          </select>
                        </td>
                      </tr>
                      <tr id="itemss-01">
                        <td class=""> 
                          SUNRISE Holidays
                          <input style="display: none" type="number" class="form-control" name="hotel[5][hotel_id]" value="5" /></input>
                        </td>
                        <td class="centered"> 
                          <input type="number" class="form-control" name="hotel[5][price]"/></input>
                        </td>
                        <td class="centered"> 
                          <select class="form-control chooosen" name="hotel[5][currency]" data-placeholder="Currency ..." style="width: 100px;">
                            <option> Currency ...</option>
                            <option value="£">£</option> ‎
                            <option value="$">$</option> 
                            <option value="EURO">EURO</option>
                            <option value="EGP">EGP</option>
                          </select>
                        </td>
                      </tr>
                      <tr id="itemss-01">
                        <td class=""> 
                          SUNRISE Diamond Beach
                          <input style="display: none" type="number" class="form-control" name="hotel[6][hotel_id]" value="6" /></input>
                        </td>
                        <td class="centered"> 
                          <input type="number" class="form-control" name="hotel[6][price]"/></input>
                        </td>
                        <td class="centered"> 
                          <select class="form-control chooosen" name="hotel[6][currency]" data-placeholder="Currency ..." style="width: 100px;">
                            <option> Currency ...</option>
                            <option value="£">£</option> ‎
                            <option value="$">$</option> 
                            <option value="EURO">EURO</option>
                            <option value="EGP">EGP</option>
                          </select>
                        </td>
                      </tr>
                      <tr id="itemss-01">
                        <td class=""> 
                          SUNRISE Arabian Beach
                          <input style="display: none" type="number" class="form-control" name="hotel[7][hotel_id]" value="7" /></input>
                        </td>
                        <td class="centered"> 
                          <input type="number" class="form-control" name="hotel[7][price]"/></input>
                        </td>
                        <td class="centered"> 
                          <select class="form-control chooosen" name="hotel[7][currency]" data-placeholder="Currency ..." style="width: 100px;">
                            <option> Currency ...</option>
                            <option value="£">£</option> ‎
                            <option value="$">$</option> 
                            <option value="EURO">EURO</option>
                            <option value="EGP">EGP</option>
                          </select>
                        </td>
                      </tr>
                      <tr id="itemss-01">
                        <td class=""> 
                          SUNRISE Marina Resort Port Ghalib
                          <input style="display: none" type="number" class="form-control" name="hotel[8][hotel_id]" value="42" /></input>
                        </td>
                        <td class="centered"> 
                          <input type="number" class="form-control" name="hotel[8][price]"/></input>
                        </td>
                        <td class="centered"> 
                          <select class="form-control chooosen" name="hotel[8][currency]" data-placeholder="Currency ..." style="width: 100px;">
                            <option> Currency ...</option>
                            <option value="£">£</option> ‎
                            <option value="$">$</option> 
                            <option value="EURO">EURO</option>
                            <option value="EGP">EGP</option>
                          </select>
                        </td>
                      </tr>
                    </tbody>
                  </table>    
                </div>
                <div class="col-lg-offset-0 col-lg-12 col-md-12 col-md-offset-0">
                  <br>
                  <label for="from-hotel" class="col-lg-1 col-md-1 col-sm-1 col-xs-1  control-label " style="margin-top:5px;">Conditions</label>
                  <br>
                  <br>
                  <textarea type="text" class="form-control" name="condition" rows="28" style="width: 750px;"/>
                    <?php if (isset($id) && $id): ?>
                      <?php echo $market['condition']; ?>
                    <?php else: ?>
1.  Above rates are per double standard room per night on All-inclusive Basis.
<br>
2.  Above rates are inclusive all taxes and services charges.
<br>
3.  Above rates are valid for local and residents only In Egyptian pounds.
<br>
4.  Above rates are valid for B2C channels (i.e. Booking, Expedia. Brand web site).
<br>
5.  B2B channels are entitled for 20% discount from the above mentioned rales (i.e. GTA. Hole Beds, Etc.).
<br>
6.  Bright Sky and Blue Sky Local Market business is entitled to 15% commission on the above mentioned rates.
<br>
7.  Local Travel agents are entitled to 10% commission on the above mentioned rates.
<br>
8.  Any Special Condition Local Market Group needs to have further discount for business needs, it has to be approved as per the discount Signature Policy.
<br>
9.  Bed and Breakfast reductions are 450.00 LE Per Person Per night only at Crystal Bay and Arabian Beach.
<br>
10. Half Board reductions are 250.00 LE per Person per night only al Crystal Bay and Arabian Beach.
<br>
11. Single Room Rate Is 25% discount from Double Room Rate.
<br>
12. Triple Room Rate ls 35% supplement on Double Room Rale.
<br>
13. Above rates are valid for travel time from 01/08/2017 till 30/09/2017 last applicable night.
<br>
                    <?php endif ?>
                  </textarea>
                </div>
                <div class="form-group col-lg-8 col-md-8 col-sm-8 col-xs-8">
                  <br>
                  <input type="hidden" name="assumed_id" value="<?php echo $assumed_id; ?>" />
                  <label for="offers" class="col-lg-3 col-md-4 col-sm-5 col-xs-5 control-label">Report Files</label>
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <input id="offers" name="upload" type="file" class="file" multiple="true" data-show-upload="false" data-show-caption="true">
                  </div>
                  <script>
                    $("#offers").fileinput({
                      uploadUrl: "/market/upload/<?php echo $assumed_id; ?>",
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
                          {url: "/market/remove/<?php echo $assumed_id ?>/<?php echo $upload['id'] ?>", key: "<?php echo $upload['name']; ?>"},
                        <?php endforeach; ?>
                      ],
                    });
                  </script>
                </div>
                <div style="    margin-top: 90px;" class="form-group">
                  <div class="col-lg-offset-3 col-lg-10 col-md-10 col-md-offset-3">
                    <br>
                    <br>
                    <br>
                    <input name="submit" value="Submit" type="submit" class="btn btn-success" />
                    <a href="<?= base_url(); ?>market/add" class="btn btn-warning">Cancel</a>
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
    document.period = <?php echo json_encode($this->input->post('period')); ?>;
  </script>
  <script type="text/javascript">
    document.hotel = <?php echo json_encode($this->input->post('hotel')); ?>;
  </script>
  <script id="item-template" type="text/x-handlebars-template">
    <tr id="item-{{id}}">
      <td class="centered">
        <input type="date" class="form-control" name="period[{{id}}][from_date]" id="item-{{id}}-from_date" value="{{from_date}}"/>  
      </td>
        <td class="centered"> 
          <input type="date" class="form-control" name="period[{{id}}][to_date]" id="item-{{id}}-to_date" value="{{to_date}}"/>  
        </td>
        <td class="centered">
          <span data-item-id="{{id}}" class="form-actions btn btn-danger remove-item" style="width: 100px;">Remove</span>
        </td>
      </tr>
    </script>   
</html>