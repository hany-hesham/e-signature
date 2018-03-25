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
                <h1 class="centered">
                  Edit Design Request Form <span>No. #<?php echo $design['id']; ?>
                  <?php if ($is_admin): ?>
                    <a class="form-actions btn btn-danger non-printable" href="/design_request/delete/<?php echo $design['id'] ?>/<?php echo $design['serial'] ?>/1" > Delete </a>
                  <?php endif ?>
                </h1>
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
                    <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;">Date</label>
                    <div class='input-group date' id='datetimepicker1' style="width: 250px; height:33px;">
                      <input type='text' class="form-control" name="date" placeholder="Date ..." value="<?php echo $design['date']; ?>"/>
                      <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                  </div>
                  <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                    <br>
                    <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;"> Hotel Name </label>
                    <select readonly="readonly" class="form-control chooosen" data-placeholder="Hotel ..." name="hotel_id" id="from-hotel " style="width: 250px; height:33px;">
                    <option data-company="0" value="<?php echo $design['hotel_id']; ?>"><?php echo $design['hotel_name']; ?></option>
                      <?php if($is_admin): ?>
                        <?php foreach ($hotels as $hotel): ?>
                          <option value="<?php echo $hotel['id'] ?>"<?php echo set_select('hotel_id',$hotel['id'] ); ?>><?php echo $hotel['name'] ?></option>
                        <?php endforeach ?>
                      <?php endif; ?>
                    </select>
                  </div>
                  <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                    <br>
                    <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;"> Department </label>
                    <select readonly="readonly" class="form-control chooosen" name="department_id" id="from-hotel " data-placeholder="Department ..." style="width: 250px; height:33px;">
                    <option data-company="0" value="<?php echo $design['department_id']; ?>"><?php echo $design['department']; ?></option>
                      <?php if($is_admin): ?>
                        <?php foreach ($departments as $department): ?>
                          <option value="<?php echo $department['id'] ?>"<?php echo set_select('department_id',$department['id'] ); ?>><?php echo $department['name'] ?></option>
                        <?php endforeach ?>
                      <?php endif; ?>
                    </select>
                  </div>
                  <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                    <br>
                    <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;"> Outline </label>
                    <textarea class="form-control" name="outline" placeholder="Outline ..." style="width: 500px;" rows="3"><?php echo $design['outline']; ?></textarea>
                  </div>
                  <div class="form-group col-lg-8 col-md-8 col-sm-8 col-xs-8">
                    <br>
                    <table class="table table-striped table-bordered table-condensed">
                      <thead>
                        <tr>
                          <th colspan="1" style=" text-align: center;">#</th>
                          <th colspan="1" style=" text-align: center;">Scope of Work</th>
                          <th colspan="1" style=" text-align: center;">Attachment</th>
                          <th colspan="1" style=" text-align: center;">actoins</th>
                        </tr>
                      </thead>
                    <tbody id="items-container" data-items="1">
                      <?php $count = 1; ?>
                      <?php if($new):?>
                        <?php $count = 1; ?>
                        <?php foreach ($items as $item): ?>
                          <tr class="item-row" style="font-size: 12px;">
                            <td class="centered"><?php echo $count; ?></td>
                            <?php if ($is_admin): ?>
                              <td class="centered">
                                <a class="form-actions btn btn-danger non-printable" href="/design_request/delete/<?php echo $item['id'] ?>/<?php echo $design['serial'] ?>/2" > Delete </a>
                              </td>
                            <?php endif; ?>
                            <td class="centered"><?php echo $item['scope']; ?></td>
                            <td class="centered">
                              <div style="display:none;">
                                <div id="bio-john">
                                  <p>
                                    <img style="width: 500px; height: 500px;" src="/assets/uploads/files/<?php echo $item['fille']; ?>"/>
                                  </p>
                                </div>
                              </div>
                              <a href="#" data-featherlight="#bio-john">
                                <img style="width: 100px; height: 100px;" src="/assets/uploads/files/<?php echo $item['fille']; ?>"/>
                              </a>
                            </td>
                          </tr>
                          <?php $count++; ?>
                        <?php endforeach ?>
                        <tr id="item-1">
                          <td class="centered"> 
                            <span>1</span>
                          </td>
                          <td class="centered"> 
                            <textarea class="form-control" name="items[1][scope]"  id="item-1-scope"></textarea>
                          </td>
                          <td class="centered">
                              <input type="file" class="form-control" name="items-1-fille" id="item-1-fille" value="" style="width: 210px;"/>
                            </td>
                          <td class="centered">
                            <span data-item-id="1" class="form-actions btn btn-danger remove-item" style="width: 100px;">Remove</span>
                          </td>
                        </tr>
                      <?php else: ?>
                        <?php foreach ($items as $item): ?>
                          <tr>
                            <td class="centered"><?php echo $count; ?></td>
                            <td class="centered" style="display: none;"> 
                              <input type="number" name="items[<?php echo $item['id']?>][id]" value="<?php echo $item['id']?>" /></input>
                            </td>
                            <td class="centered"> 
                              <textarea class="form-control" name="items[<?php echo $item['id']?>][scope]"><?php echo $item['scope']?></textarea> 
                            </td>
                            <td class="centered">
                              <input type="file" class="form-control" name="items-<?php echo $item['id']?>-fille" value="" style="width: 210px;"/>
                            </td>
                            <td class="centered">
                              <?php if($is_admin): ?>
                                <a class="form-actions btn btn-danger non-printable" href="/design_request/delete/<?php echo $item['id'] ?>/<?php echo $design['serial'] ?>/2" > Delete </a>
                              <?php endif; ?>
                            </td>
                          </tr>
                          <?php $count++; ?>
                        <?php endforeach ?>
                      <? endif; ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <td colspan="3"></td>
                        <td class="centered">
                          <?php if($new):?>
                            <span class="form-actions btn btn-primary" id="add-item" style="width: 100px;">Add Item</span>
                          <?php else: ?>
                            <a class="form-actions btn btn-primary non-printable" href="/design_request/edit/<?php echo $design['serial'] ?>/1" > Add Item </a>
                          <? endif; ?>
                        </td>
                      </tr>
                    </tfoot>
                  </table>    
                </div>
                <div class="form-group col-lg-8 col-md-8 col-sm-8 col-xs-8">
                  <br>
                  <input type="hidden" name="design_id" value="<?php echo $design['id']; ?>" />
                  <label for="offers" class="col-lg-3 col-md-4 col-sm-5 col-xs-5 control-label">Report Files</label>
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <input id="offers" name="upload" type="file" class="file" multiple="true" data-show-upload="false" data-show-caption="true">
                  </div>
                  <script>
                    $("#offers").fileinput({
                      uploadUrl: "/design_request/upload/<?php echo $design['id']; ?>",
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
                          {url: "/design_request/remove/<?php echo $design['id']; ?>/<?php echo $upload['id'] ?>", key: "<?php echo $upload['name']; ?>"},
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
                    <a href="<?= base_url(); ?>design_request/view/<?php echo $design['serial']; ?>" class="btn btn-warning">Cancel</a>
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
        <textarea type="text" name="items[{{id}}][scope]"  id="item-{{id}}-scope" class="form-control" rows=""></textarea>
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
