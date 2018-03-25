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
                    <option data-company="0" value="<?php echo $illness['hotel_id']; ?>"><?php echo $illness['hotel_name']; ?></option>
                    <?php foreach ($hotels as $hotel): ?>
                      <option value="<?php echo $hotel['id'] ?>"<?php echo set_select('hotel_id',$hotel['id'] ); ?>><?php echo $hotel['name'] ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;"> Date </label>
                  <div class='input-group date ' id='datetimepicker1' style=" width: 280px;">
                    <input type="text" name="date" class="form-control" value="<?php echo $illness['date']; ?>" /> 
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calender"></span></span>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <table class="table table-striped table-bordered table-condensed">
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
                      <?php foreach ($guests as $guest ) { ?>
                        <tr id="item-1">
                          <td class="centered" style="display: none">
                            <input type="text" class="form-control" name="guests[<?php echo $guest['id']?>][id]" value="<?php echo $guest['id']?>">
                          </td>
                          <td class="centered"> 
                            <input type="date" class="form-control date-picker" data-date-format="dd-mm-yyy" name="guests[<?php echo $guest['id']; ?>][dates]" style="width: 160px; height:34px;" value="<?php echo $guest['dates']; ?>" /></input>
                          </td>
                          <td class="centered"> 
                            <input type="text" class="form-control" name="guests[<?php echo $guest['id']; ?>][guest]"  style="width: 150px; height:34px;" value="<?php echo $guest['guest']; ?>" /></input>
                          </td>
                          <td class="centered"> 
                            <input type="text" class="form-control" name="guests[<?php echo $guest['id']; ?>][room]"  style="width: 100px; height:34px;" value="<?php echo $guest['room']; ?>" /></input>
                          </td>
                          <td class="centered"> 
                            <select class="form-control" name="guests[<?php echo $guest['id']; ?>][operator_id]" style="width: 190px; height:34px;">
                              <option data-company="0" value="<?php echo $guest['operator_id']; ?>"><?php echo $guest['operator_name']; ?></option>
                              <?php foreach ($operators as $operator): ?>
                                <option value="<?php echo $operator['id'] ?>" <?php echo set_select('operator_id',$operator['id'] ); ?>><?php echo $operator['name'] ?></option>
                              <?php endforeach ?>
                            </select> 
                          </td>
                          <td class="centered"> 
                          <select class="form-control" name="guests[<?php echo $guest['id']; ?>][symptoms]" style="width: 270px; height:34px;">
                              <option value="<?php echo $guest['symptoms']; ?>"> <?php echo $guest['symptoms']; ?> </option>
                              <option value="Gastric Illness">Gastric Illness</option>
                              <option value="Injury">Injury (use comment box to describe)</option>
                              <option value="Others)">Others (use comment box to describe)</option>
                            </select>
                          </td>
                          <td class="centered"> 
                            <select class="form-control" name="guests[<?php echo $guest['id']; ?>][visit]" style="width: 90px; height:34px;">
                              <option value="<?php echo $guest['visit']; ?>"> <?php echo $guest['visit']; ?> </option>
                              <option value="Yes">Yes</option>
                              <option value="No">No</option>
                            </select>
                          </td>
                          <td class="centered"> 
                            <select class="form-control" name="guests[<?php echo $guest['id']; ?>][avaible]" style="width: 90px; height:34px;">
                              <option value="<?php echo $guest['avaible']; ?>"> <?php echo $guest['avaible']; ?> </option>
                              <option value="Yes">Yes</option>
                              <option value="No">No</option>
                            </select>
                          </td>
                          <td class="centered"> 
                            <input type="text" class="form-control" name="guests[<?php echo $guest['id']; ?>][reported]"  style="width: 150px; height:34px;" value="<?php echo $guest['reported']; ?>" /></input>
                          </td>
                          <td class="centered"> 
                            <textarea type="text" name="guests[<?php echo $guest['id']; ?>][comments]" class="form-control" rows="" style="width: 200px;"><?php echo $guest['comments']; ?></textarea>
                          </td>
                          <td class="centered">
                            <select class="form-control" name="guests[<?php echo $guest['id']; ?>][ir_type]" style="width: 220px; height:34px;">
                            <option value="<?php echo $guest['ir_type']; ?>"> <?php if($guest['ir_type'] == 1){ echo "In House Incident Report-UK";}elseif($guest['ir_type'] == 2){ echo "In House - other nationalities";} ?> </option>
                            <option value="1">In House Incident Report-UK</option>
                            <option value="2">In House - other nationalities</option>
                          </select>
                          </td>
                          <td class="centered"> 
                            <input type="text" class="form-control" name="guests[<?php echo $guest['id']; ?>][ir]"  style="width: 150px; height:34px;" value="<?php echo $guest['ir']; ?>" /></input>
                          </td>
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
                <div class="form-group col-lg-12 col-md-10 col-sm-12 col-xs-12">
                  <input type="hidden" name="iln_id" value="<?php echo $illness['id']; ?>" />
                  <label for="offers" class="col-lg-3 col-md-4 col-sm-5 col-xs-5 control-label">Report Files</label>
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <input id="offers" name="upload" type="file" class="file" multiple="true" data-show-upload="false" data-show-caption="true">
                  </div>
                  <script>
                    $("#offers").fileinput({
                      uploadUrl: "/illness/make_offer/<?php echo $illness['id']; ?>",
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
                          {url: "/illness/remove_offer/<?php echo $illness['id'] ?>/<?php echo $upload['id'] ?>", key: "<?php echo $upload['name']; ?>"},
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
        
      