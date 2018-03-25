<!DOCTYPE html>
<html lang="en">
  <head>
    <?php $this->load->view('header'); ?>
  </head>
  <body style="margin-left: -350px;">
    <div id="wrapper">
      <?php $this->load->view('menu') ?>
      <div id="page-wrapper">
        <div class="a4wrapper">
          <div class="">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px;">
              <div class="page-header">
                <h1 class="centered">Edit Beach/Day Use Request No.# <?php echo $use['id'] ?></h1>
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
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin-top:5px;"> Hotel Name </label>
                  <input readonly="" type="text" name="hotel" class="form-control" value="<?php echo $use['hotel_name']; ?>" style="width: 250px;"/> 
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin-top:5px;"> Use Type </label>
                    <select class="form-control chooosen" name="type_id" id="from-hotel" data-placeholder="Type ..."  style="width: 250px;">
                      <option value="<?php echo $use['type_id'] ?>"><?php echo $use['type_name'] ?></option>
                      <?php foreach ($types as $type): ?>
                        <option value="<?php echo $type['id'] ?>"<?php echo set_select('type_id',$type['id'] ); ?>><?php echo $type['name'] ?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                <table class="table table-striped table-bordered table-condensed centered" style="width: 2100px !important;">
                  <tr class="item-row">
                    <td class="align-left table-label" style="width: 100px !important;">Room</td>
                    <td class="align-left table-label" style="width: 100px !important;">No. Pax</td>
                    <td class="align-left table-label" style="width: 100px !important;">No. Child</td>
                    <td class="align-left table-label" style="width: 200px !important;">Date</td>
                    <td class="align-left table-label" style="width: 200px !important;">Type</td>
                    <td class="align-left table-label" style="width: 200px !important;">Guest</td>
                    <td class="align-left table-label" style="width: 200px !important;">Nationality</td>
                    <td class="align-left table-label" style="width: 200px !important;">Arrival Date</td>
                    <td class="align-left table-label" style="width: 200px !important;">Departure Date</td>
                    <td class="align-left table-label" style="width: 200px !important;">Operator</td>
                    <td class="align-left table-label" style="width: 400px !important;">Reason</td>
                  </tr>
                  <?php foreach ($items as $item):?>
                      <tr class="item-row">
                        <td class="align-left table-label" style="display: none">
                          <input class="form-control" name="rooms[<?php echo $item['id']?>][id]" value="<?php echo $item['id']?>">
                        </td>
                        <td class="align-left table-label">
                          <input readonly="" type="number" name="rooms[<?php echo $item['id']?>][room]" class="form-control" value="<?php echo $item['room']; ?>"/>
                        </td> 
                        <td class="align-left table-label">
                          <input type="number" name="rooms[<?php echo $item['id']?>][pax]" class="form-control" value="<?php echo $item['pax']; ?>" required/>
                        </td>
                        <td class="align-left table-label">
                          <input type="number" name="rooms[<?php echo $item['id']?>][child]" class="form-control" value="<?php echo $item['child']; ?>" required/>
                        </td>
                        <td class="align-left table-label">
                          <div class='input-group date' id="datetimepicker<?php echo $item['id']?>">
                            <input type='text' class="form-control" name="rooms[<?php echo $item['id']?>][date]" value="<?php echo $item['date']; ?>" required/>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                          </div>
                        </td>
                        <td class="align-left table-label">
                          <select class="form-control chooosen" name="rooms[<?php echo $item['id']?>][type]" id="from-hotel" data-placeholder="Type ..." required>
                            <option value="<?php echo $item['type']; ?>"><?php echo $item['type']; ?></option>
                            <option value="Comp">Comp</option>
                            <option value="Payed">Payed</option>
                          </select>
                        </td>
                        <td class="align-left table-label">
                          <input type="text" name="rooms[<?php echo $item['id']?>][guest]" class="form-control" value="<?php echo $item['guest']; ?>" required/>
                        </td>
                        <td class="align-left table-label">
                          <input type="text" name="rooms[<?php echo $item['id']?>][nationality]" class="form-control" value="<?php echo $item['nationality']; ?>" required/> 
                        </td>
                        <td class="align-left table-label">
                          <div class='input-group date' id="datetimepicker<?php echo $item['id']?>">
                            <input type='text' class="form-control" name="rooms[<?php echo $item['id']?>][arrival]" value="<?php echo $item['arrival']; ?>" required/>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                          </div>
                        </td>
                        <td class="align-left table-label">
                          <div class='input-group date' id="datetimepicker<?php echo $item['id']?>">
                            <input type='text' class="form-control" name="rooms[<?php echo $item['id']?>][departure]" value="<?php echo $item['departure']; ?>" required/>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                          </div>
                        </td>
                        <td class="align-left table-label">
                          <select class="form-control chooosen" name="rooms[<?php echo $item['id']?>][operator_id]" id="from-hotel" data-placeholder="Operator ..." required>
                            <option value="<?php echo $item['operator_id'] ?>"><?php echo $item['operator_name'] ?></option>
                            <?php foreach ($operators as $operator): ?>
                              <option value="<?php echo $operator['id'] ?>"<?php echo set_select('operator_id',$operator['id'] ); ?>><?php echo $operator['name'] ?></option>
                            <?php endforeach ?>
                          </select>
                        </td>
                        <td class="align-left table-label">
                          <textarea type="text" name="rooms[<?php echo $item['id']?>][reason]" placeholder="The Reason ..." class="form-control" row="3"><?php echo $item['reason']; ?></textarea>
                        </td>
                      </tr>
                  <?php endforeach ?>
                </table>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <br>
                  <input type="hidden" name="use_id" value="<?php echo $use['id']; ?>" />
                  <label for="offers" class="col-lg-3 col-md-4 col-sm-5 col-xs-5 control-label">Report Files</label>
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <input id="offers" name="upload" type="file" class="file" multiple="true" data-show-upload="false" data-show-caption="true">
                  </div>
                  <script>
                    $("#offers").fileinput({
                      uploadUrl: "/bd_use/make_offer/<?php echo $use['id'] ?>",
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
                          {url: "/bd_use/remove_offer/<?php echo $use['id'] ?>/<?php echo $upload['id'] ?>", key: "<?php echo $upload['name']; ?>"},
                        <?php endforeach; ?>
                      ],
                    });
                  </script>
                </div>
                <div style="    margin-top: 90px;" class="form-group">
                  <div class="col-lg-offset-3 col-lg-10 col-md-10 col-md-offset-3">
                    <input name="submit" value="Submit" type="submit" class="btn btn-success" />
                    <a href="<?= base_url(); ?>bd_use/view/<?php echo $use['id'] ?>" class="btn btn-warning">Cancel</a>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php foreach ($items as $item):?>
      <script type="text/javascript">
        $(function () {
          $('#datetimepicker<?php echo $item['id']?>').datetimepicker({
            format: 'YYYY-MM-DD hh:mm a'
          });
        });
      </script> 
      <script type="text/javascript">
        $(function () {
          $('#datetimepicker1<?php echo $item['id']?>').datetimepicker({
            format: 'YYYY-MM-DD'
          });
        });
      </script> 
      <script type="text/javascript">
        $(function () {
          $('#datetimepicker2<?php echo $item['id']?>').datetimepicker({
            format: 'YYYY-MM-DD'
          });
        });
      </script> 
    <?php endforeach; ?>
    <script type = "text/javascript" >
      function preventBack(){window.history.forward();}
      setTimeout("preventBack()", 0);
      window.onunload=function(){null};
    </script> 
    <script type="text/javascript">
      document.rooms = <?php echo json_encode($this->input->post('rooms')); ?>;
    </script>
  </body>
</html>
