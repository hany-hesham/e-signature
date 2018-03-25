<!DOCTYPE html>
<html lang="en">
  <head>
    <?php $this->load->view('header'); ?>
  </head>
  <body>
    <div id="wrapper">
      <?php $this->load->view('menu') ?>
      <div id="page-wrapper">
        <div class="a2wrapper">
          <div class="a2page" style="margin-bottom: 10px;">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px;">
              <div class="page-header">
                <h1 class="centered">Tenants Shop License</h1>
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
                  <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                    <br>
                    <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;">Hotel </label>
                    <select class="form-control chooosen" data-placeholder="Hotel ..." name="hotel_id" id="from-hotel " style="width: 250px; height:33px;">
                      <option data-company="0" value="">Select Hotel..</option>
                      <?php foreach ($hotels as $hotel): ?>
                        <option value="<?php echo $hotel['id'] ?>"<?php echo set_select('hotel_id',$hotel['id'] ); ?>><?php echo $hotel['name'] ?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                  <br>
                  <br>
                  <br>
                  <div>
                    <br>
                    <table class="table table-striped table-bordered table-condensed">
                      <thead>
                        <tr>
                          <th colspan="1" style=" text-align: center;">#</th>
                          <th colspan="1" style=" text-align: center;">Shop name</th>
                          <th colspan="1" style=" text-align: center;">Activity</th>
                          <th colspan="1" style=" text-align: center;">Tenants</th>
                          <th colspan="1" style=" text-align: center;">Start of contract</th>
                          <th colspan="1" style=" text-align: center;">End of contract</th>
                          <th colspan="1" style=" text-align: center;">License Yes/No</th>
                          <th colspan="1" style=" text-align: center;">License due to date</th>
                          <th colspan="1" style=" text-align: center;">Target date to finalize license</th>
                          <th colspan="1" style=" text-align: center;">Attachment</th>
                        </tr>
                      </thead>
                      <tbody id="items-container" data-items="1">
                        <tr id="item-1">
                          <td class="centered"> 
                            <span>1</span>
                          </td>
                          <td class="centered"> 
                            <input type="text" class="form-control" name="items[1][name]"  id="item-1-name"  style="width:100px;"/></input>
                          </td>
                          <td class="centered"> 
                            <input type="text" class="form-control" name="items[1][activity]"  id="item-1-activity"  style="width:100px;"/></input>
                          </td>
                          <td class="centered"> 
                            <input type="text" class="form-control" name="items[1][tenants]"  id="item-1-tenants"  style="width:100px;"/></input>
                          </td>
                          <td class="centered"> 
                             <input type="date" class="form-control" name="items[1][start]"  id="item-1-start"/></input> 
                          </td>
                          <td class="centered"> 
                             <input type="date" class="form-control" name="items[1][end]"  id="item-1-end"/></input> 
                          </td>
                          <td class="centered"> 
                             <select class="form-control chooosen" name="items[1][license]" id="from-license " style="width:100px; height:33px;">
                                  <option data-company="0" value="">Yes or No..</option>
                                  <option value="Yes">Yes</option>
                                  <option value="Not Requested">Not Requested</option>
                              </select>
                          </td>
                          <td class="centered"> 
                             <input type="date" class="form-control" name="items[1][due_date]"  id="item-1-due_date"/></input> 
                          </td>
                          <td class="centered"> 
                             <input type="text" class="form-control" name="items[1][target]"  id="item-1-target"  style="width:100px;"/></input> 
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
                          <td colspan="6"></td>
                          <td class="centered">
                            <span class="form-actions btn btn-primary" id="add-item" style="width: 100px;">Add Shop</span>
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
                        uploadUrl: "/Shop_license/upload/<?php echo $assumed_id; ?>",
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
                            {url: "/Shop_license/remove/<?php echo $assumed_id ?>/<?php echo $upload['id'] ?>", key: "<?php echo $upload['name']; ?>"},
                          <?php endforeach; ?>
                        ],
                      });
                    </script>
                  </div>
                  <div style="margin-top: 90px;" class="form-group">
                    <div class="col-lg-offset-3 col-lg-10 col-md-10 col-md-offset-3">
                      <input name="submit" value="Submit" type="submit" class="btn btn-success" />
                      <a href="<?= base_url(); ?>Shop_license/" class="btn btn-warning">Cancel</a>
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
      $('#datetimepicker1').datetimepicker({
        format: 'YYYY-MM-DD'
      });
    });
  </script>  
  <script type="text/javascript">
    document.items = <?php echo json_encode($this->input->post('items')); ?>;
  </script>
  <script id="item-template" type="text/x-handlebars-template">
    <tr id="item-{{id}}">
        <td>
          <span>{{id}}</span>
        </td>
        <td class="centered"> 
          <input type="text" class="form-control" name="items[{{id}}][name]"  id="item-1-name"/></input>
        </td>
        <td class="centered"> 
          <input type="text" class="form-control" name="items[{{id}}][activity]"  id="item-1-activity"/></input>
        </td>
        <td class="centered"> 
          <input type="text" class="form-control" name="items[{{id}}][tenants]"  id="item-1-tenants"/></input>
        </td>
        <td class="centered"> 
           <input type="date" class="form-control" name="items[{{id}}][start]"  id="item-1-start"/></input> 
        </td>
        <td class="centered"> 
           <input type="date" class="form-control" name="items[{{id}}][end]"  id="item-1-end"/></input> 
        </td>
        <td class="centered"> 
           <select class="form-control chooosen" name="items[{{id}}][license]" id="from-license " style="width:100px; height:33px;">
                <option data-company="0" value="">Yes or No..</option>
                <option value="Yes">Yes</option>
                <option value="Not Requested">Not Requested</option>
            </select>
        </td>
        <td class="centered"> 
           <input type="date" class="form-control" name="items[{{id}}][due_date]"  id="item-1-due_date"/></input> 
        </td>
        <td class="centered"> 
           <input type="text" class="form-control" name="items[{{id}}][target]"  id="item-1-target"/></input> 
        </td>
        <td class="centered">
           <input type="file" class="form-control" name="items-{{id}}-fille" id="item-{{id}}-fille" value="" style="width: 210px;"/>
        </td>
        <td class="centered">
          <span data-item-id="{{id}}" class="form-actions btn btn-danger remove-item" style="width: 100px;">Remove</span>
        </td>
    </tr>
  </script> 
</html>
 