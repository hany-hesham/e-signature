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
                <h1 class="centered">New Credit Application Form</h1>
              </div>
              <?php if(validation_errors() != false): ?>
                <div class="alert alert-danger">
                  <?php echo validation_errors(); ?>
                </div>
              <?php endif ?>         
            </div>
            <div class="container">
              <form action="" method="POST" id="form-submit" enctype="multipart/form-data" class="form-div span12" accept-charset="utf-8">
                <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                  <br>
                  <div >
                    <label for="from-hotel" class="control-label" style="margin-top:5px;margin-left: 15px;"> Hotel Name </label>
                    <select class="form-control chooosen" data-placeholder="Hotel ..." name="hotel_id" id="from-hotel " 
                            style="width: 250px; height:33px;margin-left:50px;">
                      <option data-company="0" value="">Hotel ..</option>
                      <?php foreach ($hotels as $hotel): ?>
                        <option value="<?php echo $hotel['id'] ?>"<?php echo set_select('hotel_id',$hotel['id'] ); ?>><?php echo $hotel['name'] ?></option>
                      <?php endforeach ?>
                    </select>
                  </div>                  
                    <br>
                   <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;">Contact Name</label>
                  <p>
                    <input type="text" name="per_name" class="form-control" style=" height:38px; width: 240px;" class="form-control"/>
                  </p>
                    <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;">Contact title</label>
                  <p>
                    <input type="text" name="title" class="form-control" style=" height:38px; width: 240px;" class="form-control"/>
                  </p>
                    <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;">Contact Telephone</label>
                  <p>
                    <input type="number" name="tel" class="form-control" style=" height:38px; width: 240px;" class="form-control"/>
                  </p>
                    <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;">Contact E-Mail</label>
                  <p>
                    <input type="text" name="mail" class="form-control" style=" height:38px; width: 240px;" class="form-control"/>
                  </p>
                  <br>
                  <br>
                   <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;">Company Name</label>
                  <p>
                    <input type="text" name="comp_name" class="form-control" style=" height:38px; width: 240px;" class="form-control"/>
                  </p>
                    <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;">Nature of Business</label>
                  <p>
                    <input type="text" name="business_nature" class="form-control" style=" height:38px; width: 240px;" class="form-control"/>
                  </p>
                    <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;">Company Address</label>
                  <p>
                    <input type="text" name="comp_address" class="form-control" style=" height:38px; width: 240px;" class="form-control"/>
                  </p>
                    <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;">Company Telephone</label>
                  <p>
                    <input type="number" name="comp_tel" class="form-control" style=" height:38px; width: 240px;" class="form-control"/>
                  </p>
                  <br>
                  <br>
                   <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;">Bank Name</label>
                  <p>
                    <input type="text" name="bank_name" class="form-control" style=" height:38px; width: 240px;" class="form-control"/>
                  </p>
                    <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;">Account Number</label>
                  <p>
                    <input type="text" name="acc_num" class="form-control" style=" height:38px; width: 240px;" class="form-control"/>
                  </p>
                    <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;">Bank Address</label>
                  <p>
                    <input type="text" name="bank_address" class="form-control" style=" height:38px; width: 240px;" class="form-control"/>
                  </p>
                    <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;">Bank Telephone</label>
                  <p>
                    <input type="number" name="bank_tel" class="form-control" style=" height:38px; width: 240px;" class="form-control"/>
                  </p>
                  <br>
                   <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;">Estimated Amount of Business</label>
                  <p>
                    <input type="text" name="estimated_amount" class="form-control" style=" height:38px; width: 240px;" class="form-control"/>
                  </p>
                  <br>
                    <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;">Deposit Required</label>
                  <p>
                    <input type="text" name="required_deposite" class="form-control" style=" height:38px; width: 240px;" class="form-control"/>
                  </p>
                  <br>
                  <label for="from-hotel" class="  control-label " style="margin-top:5px;margin-left: 15px;">
                  Two other hotels, with which you have credit or credit history:</label>
                  <div class="form-group col-lg-10 col-md-10 col-sm-10 col-xs-10">
                    <br>
                    <table class="table table-striped table-bordered table-condensed">
                      <thead>
                        <tr>
                          <th colspan="1" style=" text-align: center;">#</th>
                          <th colspan="1" style=" text-align: center;">Hotel</th>
                          <th colspan="1" style=" text-align: center;">Address</th>
                          <th colspan="1" style=" text-align: center;">Contact Name</th>
                          <th colspan="1" style=" text-align: center;">Amount charged</th>
                          <th colspan="1" style=" text-align: center;">Payment Method</th>
                          <th colspan="1" style=" text-align: center;">Deposit Paid</th>
                          <th colspan="1" style=" text-align: center;">Telephone</th>
                          <th colspan="1" style=" text-align: center;">actoins</th>
                        </tr>
                      </thead>
                      <tbody id="items-container" data-items="1">
                        <tr id="item-1">
                          <td class="centered"> 
                            <span>1</span>
                          </td>
                          <td class="centered"> 
                            <input type="text" class="form-control" name="items[1][hotel]"  id="item-1-hotel"/></input>
                          </td>
                          <td class="centered"> 
                            <input type="text" class="form-control" name="items[1][address]"  id="item-1-address"/></input>
                          </td>
                          <td class="centered"> 
                            <input type="text" class="form-control" name="items[1][contact_name]"  id="item-1-contact_name"/></input>
                          </td>
                          <td class="centered"> 
                            <input class="form-control" name="items[1][amount_charged]"  id="item-1-amount_charged"></input> 
                          </td>
                          <td class="centered"> 
                            <input type="text" class="form-control" name="items[1][payment_method]"  id="item-1-payment_method"/></input>
                          </td>
                          <td class="centered"> 
                            <input type="text" class="form-control" name="items[1][deposite_paid]"  id="item-1-deposite_paid"/></input>
                          </td>
                          <td class="centered"> 
                            <input type="number" class="form-control" name="items[1][tel]"  id="item-1-tel"/></input>
                          </td>
                          <td class="centered">
                            <span data-item-id="1" class="form-actions btn btn-danger remove-item" style="width: 100px;">Remove</span>
                          </td>
                        </tr>
                      </tbody>
                      <tfoot>
                        <tr>
                          <td colspan="8"></td>
                          <td class="centered">
                            <span class="form-actions btn btn-primary" id="add-item" style="width: 100px;">Add Item</span>
                          </td>
                        </tr>
                      </tfoot>
                    </table>    
                  </div>
                  <div class="form-group col-lg-10 col-md-10 col-sm-10 col-xs-10">
                    <br>
                    <input type="hidden" name="assumed_id" value="<?php echo $assumed_id; ?>" />
                    <label for="offers" class="col-lg-3 col-md-4 col-sm-5 col-xs-5 control-label">Report Files</label>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                      <input id="offers" name="upload" type="file" class="file" multiple="true" data-show-upload="false" data-show-caption="true">
                    </div>
                    <script>
                      $("#offers").fileinput({
                        uploadUrl: "/credit_app/upload/<?php echo $assumed_id; ?>",
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
                            {url: "/credit_app/remove/<?php echo $assumed_id ?>/<?php echo $upload['id'] ?>", key: "<?php echo $upload['name']; ?>"},
                          <?php endforeach; ?>
                        ],
                      });
                    </script>
                  </div>
                  <div style="margin-top: 90px;" class="form-group">
                    <div class="col-lg-offset-3 col-lg-10 col-md-10 col-md-offset-3">
                      <input name="submit" value="Submit" type="submit" class="btn btn-success" />
                      <a href="<?= base_url(); ?>credit_app/" class="btn btn-warning">Cancel</a>
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
    document.items = <?php echo json_encode($this->input->post('items')); ?>;
  </script>
  <script id="item-template" type="text/x-handlebars-template">
    <tr id="item-{{id}}">
      <td>
        <span>{{id}}</span>
      </td>
      <td class="centered">
        <input type="text" class="form-control" name="items[{{id}}][hotel]" id="item-{{id}}-hotel" value="{{hotel}}"/>  
      </td>
      <td class="centered"> 
        <input type="text" class="form-control" name="items[{{id}}][address]" id="item-{{id}}-address" value="{{address}}"/>  
      </td>
      <td class="centered"> 
        <input type="text" class="form-control" name="items[{{id}}][contact_name]" id="item-{{id}}-contact_name" value="{{contact_name}}"/>  
      </td>
      <td class="centered"> 
        <input type="text" class="form-control" name="items[{{id}}][amount_charged]" id="item-{{id}}-amount_charged" value="{{amount_charged}}"/>  
      </td>
       <td class="centered"> 
        <input type="text" class="form-control" name="items[{{id}}][payment_method]" id="item-{{id}}-payment_method" value="{{payment_method}}"/>  
      </td>
      <td class="centered"> 
        <input type="text" class="form-control" name="items[{{id}}][deposite_paid]" id="item-{{id}}-deposite_paid" value="{{deposite_paid}}"/>  
      </td>
       <td class="centered"> 
        <input type="number" class="form-control" name="items[{{id}}][tel]" id="item-{{id}}-tel" value="{{tel}}"/>  
      </td>     
      <td class="centered">
        <span data-item-id="{{id}}" class="form-actions btn btn-danger remove-item" style="width: 100px;">Remove</span>
      </td>
    </tr>
  </script> 
  <script type="text/javascript">
      var select = document.getElementById('sister');
      var input = document.getElementById('reasons');
      input.addEventListener('change', function () {
      if (input.value == '4') {
        select.style.display = 'block';
      } else {
        select.style.display = 'none';
      }
    });
  </script> 
 
</html>
