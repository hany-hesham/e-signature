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
              <h1 class="centered">Illness Log</h1>
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
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;"> Hotel Name </label>
                  <select class="form-control" name="hotel_id" id="from-hotel " style="width: 280px; height:34px;">
                    <option data-company="0" value="">Select Hotel..</option>
                    <?php foreach ($hotels as $hotel): ?>
                      <option value="<?php echo $hotel['id'] ?>"<?php echo set_select('hotel_id',$hotel['id'] ); ?>><?php echo $hotel['name'] ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;"> Date </label>
                  <div class='input-group date ' id='datetimepicker1' style=" width: 280px;">
                    <input type="text" name="date" class="form-control" /> 
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calender"></span></span>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <table class="table table-striped table-bordered table-condensed centered" style="margin-left: -260px;">
                    <thead>
                      <tr>
                        <th colspan="1" style=" text-align: center;">Date</th>
                        <th colspan="1" style=" text-align: center;">Guest Name</th>
                        <th colspan="1" style=" text-align: center;">Room</th>
                        <th colspan="1" style=" text-align: center;">Tour Operator</th>
                        <th colspan="1" style=" text-align: center;">Diagnosis / Symptoms</th>
                        <th colspan="1" style=" text-align: center;">Hotel Clinic Visit (*Yes / **No)</th>
                        <th colspan="1" style=" text-align: center;">* If Yes - is MR available (Yes / No)</th>
                        <th colspan="1" style=" text-align: center;">** If No - to who the symptoms were reported (e.g. FO, GSC, TL etc)</th>
                        <th colspan="1" style=" text-align: center;">Comments</th>
                        <th colspan="1" style=" text-align: center;">IR Type</th>
                        <th colspan="1" style=" text-align: center;">Related IR#</th>
                      </tr>
                    </thead>
                    <tbody id="items-container" data-items="1">
                      <tr id="item-1">
                        <td class="centered"> 
                          <input type="date" class="form-control date-picker" data-date-format="dd-mm-yyy" name="guests[1][dates]"  id="item-1-dates" style="width: 160px; height:34px;"/></input>
                        </td>
                        <td class="centered"> 
                          <input type="text" class="form-control" name="guests[1][guest]"  id="item-1-guest" style="width: 150px; height:34px;"/></input>
                        </td>
                        <td class="centered"> 
                          <input type="text" class="form-control" name="guests[1][room]"  id="item-1-room" style="width: 100px; height:34px;"/></input>
                        </td>
                        <td class="centered"> 
                          <select class="form-control" name="guests[1][operator_id]" id="item-1-operator_id" style="width: 190px; height:34px;">
                            <option data-company="0" value="">Select Operator..</option>
                            <?php foreach ($operators as $operator): ?>
                              <option value="<?php echo $operator['id'] ?>" <?php echo set_select('operator_id',$operator['id'] ); ?>><?php echo $operator['name'] ?></option>
                            <?php endforeach ?>
                          </select> 
                        </td>
                        <td class="centered"> 
                          <select class="form-control" name="guests[1][symptoms]" id="item-1-symptoms" style="width: 270px; height:34px;">
                            <option value=""> Select Diagnosis ... </option>
                            <option value="Gastric Illness">Gastric Illness</option>
                            <option value="Injury">Injury (use comment box to describe)</option>
                            <option value="Others)">Others (use comment box to describe)</option>
                          </select>
                        </td>
                        <td class="centered"> 
                          <select class="form-control" name="guests[1][visit]" id="item-1-visit" style="width: 90px; height:34px;">
                            <option value=""> Select ... </option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                          </select>
                        </td>
                        <td class="centered"> 
                          <select class="form-control" name="guests[1][avaible]" id="item-1-avaible" style="width: 90px; height:34px;">
                            <option value=""> Select ... </option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                          </select>
                        </td>
                        <td class="centered"> 
                          <input type="text" class="form-control" name="guests[1][reported]"  id="item-1-reported" style="width: 150px; height:34px;"/></input>
                        </td>
                        <td class="centered"> 
                          <textarea type="text" name="guests[1][comments]"  id="item-1-comments" class="form-control" rows="" style="width: 200px;"></textarea>
                        </td>
                        <td class="centered"> 
                          <select class="form-control" name="guests[1][ir_type]" id="item-1-ir_type" style="width: 220px; height:34px;">
                            <option value=""> Select ... </option>
                            <option value="1">In House Incident Report-UK</option>
                            <option value="2">In House - other nationalities</option>
                          </select>
                        </td>
                        <td class="centered"> 
                          <input type="text" class="form-control" name="guests[1][ir]"  id="item-1-ir" style="width: 150px; height:34px;"/></input>
                        </td>
                      </tr>
                    </tbody>

                  </table>
                </div>
                <div class="form-group col-lg-12 col-md-10 col-sm-12 col-xs-12" style="margin-left: -200px;">
                  <input type="hidden" name="assumed_id" value="<?php echo $assumed_id; ?>" />
                  <label for="offers" class="col-lg-3 col-md-4 col-sm-5 col-xs-5 control-label">Report Files</label>
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <input id="offers" name="upload" type="file" class="file" multiple="true" data-show-upload="false" data-show-caption="true">
                  </div>
                  <script>
                    $("#offers").fileinput({
                      uploadUrl: "/illness/make_offer/<?php echo $assumed_id; ?>",
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
                          {url: "/illness/remove_offer/<?php echo $assumed_id ?>/<?php echo $upload['id'] ?>", key: "<?php echo $upload['name']; ?>"},
                        <?php endforeach; ?>
                      ],
                    });
                  </script>
                </div>
              </div>
              <div class="col-lg-offset-3 col-lg-10 col-md-10 col-md-offset-3">
                <input name="submit" value="Submit" type="submit" class="btn btn-success" />
                <a href="<?= base_url(); ?>illness" class="btn btn-warning">Cancel</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <script type="text/javascript">
      document.items = <?php echo json_encode($this->input->post('guests')); ?>;
    </script>
    <script id="item-template" type="text/x-handlebars-template">
      <tr id="item-{{id}}">
        <td class="centered">
          <input type="date" class="form-control date-picker" data-date-format="dd-mm-yyy" name="guests[{{id}}][dates]" id="item-{{id}}-dates" style="width: 160px; height:34px;"  value="{{dates}}"/>  
        </td>
        <td class="centered"> 
          <input type="text" class="form-control" name="guests[{{id}}][guest]" id="item-{{id}}-guest" style="width: 150px; height:34px;"  value="{{guest}}"/>  
        </td>
        <td class="centered">
          <input type="text" class="form-control" name="guests[{{id}}][room]" id="item-{{id}}-room" style="width: 100px; height:34px;"  value="{{room}}"/>  
        </td>
        <td class="centered">
          <select class="form-control" name="guests[{{id}}][operator_id]" id="item-{{id}}-operator_id" style="width: 190px; height:34px;">
            <option data-company="0" value="">Select Operator..</option>
            <?php foreach ($operators as $operator): ?>
              <option value="<?php echo $operator['id'] ?>" <?php echo set_select('operator_id',$operator['id'] ); ?>><?php echo $operator['name'] ?></option>
            <?php endforeach ?>
          </select>
        </td>
        <td class="centered"> 
          <select class="form-control" name="guests[{{id}}][symptoms]" id="item-{{id}}-symptoms" style="width: 270px; height:34px;">
            <option value=""> Select Diagnosis ... </option>
            <option value="Gastric Illness">Gastric Illness</option>
            <option value="Injury">Injury (use comment box to describe)</option>
            <option value="Others)">Others (use comment box to describe)</option>
          </select>
        </td>
        <td class="centered">
          <select class="form-control" name="guests[{{id}}][visit]" id="item-{{id}}-visit" style="width: 90px; height:34px;">
            <option value=""> Selest ... </option>
            <option value="Yes">Yes</option>
            <option value="No">No</option>
          </select>
        </td>
        <td class="centered">
          <select class="form-control" name="guests[{{id}}][avaible]" id="item-{{id}}-avaible" style="width: 90px; height:34px;">
            <option value=""> Selest ... </option>
            <option value="Yes">Yes</option>
            <option value="No">No</option>
          </select>
        </td>
        <td class="centered">
          <input type="text" class="form-control" name="guests[{{id}}][reported]"  id="item-{{id}}-reported" style="width: 150px; height:34px;" value="{{pax}}"/></input>
        </td>
        <td class="centered">
          <textarea type="text" name="guests[{{id}}][comments]"  id="item-{{id}}-comments" class="form-control" rows="" style="width: 200px;"></textarea>
        </td>
        <td class="centered"> 
          <select class="form-control" name="guests[{{id}}][ir_type]" id="item-{{id}}-ir_type" style="width: 90px; height:34px;">
            <option value=""> Select ... </option>
            <option value="1">In House Incident Report-UK</option>
            <option value="2">In House - other nationalities</option>
          </select>
        </td>
        <td class="centered">
          <input type="text" class="form-control" name="guests[{{id}}][ir]"  id="item-{{id}}-ir" style="width: 150px; height:34px;" value="{{ir}}"/></input>
        </td>
      </tr>
    </script>
    <script type="text/javascript">
        $(function () {
            $('#datetimepicker1').datetimepicker({
                viewMode: 'months',
                minViewMode: "months",
                format: 'MMMM-YYYY'
            });
        });
    </script>
  </body>
</html>
        
      