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
          <div class="a4page" style="margin-bottom: 20px;">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px;">
              <?php if(validation_errors() != false): ?>
                <div class="alert alert-danger">
                  <?php echo validation_errors(); ?>
                </div>
              <?php endif ?>
              <div class="page-header">
                <h3>Edit Legal Claims Form</h3>
              </div>
            </div>
            <form action="" method="POST" id="form-submit" enctype="multipart/form-data" class="form-div span12" accept-charset="utf-8">
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 " style="background-color: #5CB1D4">
                <h5 class="text-center" style="color: #FFFFFF;">SUNRISE To Complete</h5>
              </div>
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Hotel Name </label>
                  <select class="form-control" name="hotel_id" id="from-hotel " style="width: 30%;">
                    <option data-company="0" value="<?php echo $form['hotel_id']; ?>"><?php echo $form['hotel_name']; ?></option>
                    <?php foreach ($hotels as $hotel): ?>
                    <option value="<?php echo $hotel['id'] ?>" <?php echo set_select('hotel_id',$hotel['id'] ); ?>><?php echo $hotel['name'] ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-type" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width:200px;">Name of CNF</label>
                  <input type="text" name="cnf" value="<?php echo $form['cnf']; ?>" class="form-control" style=" height:38px; width: 30%;"/>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-type" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width:200px;">Booking Referance</label>
                  <input type="text" name="referance" value="<?php echo $form['referance']; ?>" class="form-control" style=" height:38px; width: 30%;"/>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Date of Arrival </label>
                  <div class='input-group date' id='datetimepicker' style="width: 30%; margin:5px;">
                    <input type="text" name="arrival" class="form-control" value="<?php echo $form['arrival']; ?>" /> 
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calender"></span></span>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width: 200px;"> Date of Departure </label>
                  <div class='input-group date' id='datetimepicker1' style=" width: 30%; margin:5px;">
                    <input type="text" name="departure" class="form-control" value="<?php echo $form['departure']; ?>" /> 
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calender"></span></span>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width: 200px;"> UK contact details for guest - address </label>
                  <input type="text" name="address" class="form-control" value="<?php echo $form['address']; ?>" style=" height:38px; width: 30%; margin: 15px;"/>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width: 200px;"> Personal Comment</label>
                  <textarea type="text" name="comment" class="form-control" style=" width: 600px; height:100px;"/><?php echo $form['comment']; ?></textarea>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width: 200px;"> Postcode </label>
                  <input type="text" name="postcode" class="form-control" value="<?php echo $form['postcode']; ?>" style=" height:38px; width: 30%; margin:5px;"/>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width: 200px;"> Email address </label>
                  <input type="text" name="email" class="form-control" value="<?php echo $form['email']; ?>" style=" height:38px; width: 30%;"/>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width: 200px;"> Tour Operator </label>
                  <select class="form-control" name="operator_id" id="from-hotel " style="width: 30%;">
                    <option data-company="0" value="<?php echo $form['operator_id']; ?>"><?php echo $form['operator_name']; ?></option>
                    <?php foreach ($operators as $operator): ?>
                      <option value="<?php echo $operator['id'] ?>" <?php echo set_select('operator_id',$operator['id'] ); ?>><?php echo $operator['name'] ?></option>
                    <?php endforeach ?>
                  </select>                  
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width: 200px;"> Type </label>
                  <select id="select_get_type" name="type" for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label form-control" style="width: 30%;">
                    <option value="<?php echo $form['type']; ?>"><?php echo $form['type']; ?></option>
                    <option value="Other">Other</option>
                    <option value="Illness">Illness</option>
                    <option value="Accident">Accident</option>
                    <option value="Assault">Assault</option>
                    <option value="Inappropriate Behaviour Of Guests">Inappropriate Behaviour Of Guests </option>
                    <option value="Inappropriate Behaviour Of Staff">Inappropriate Behaviour Of Staff</option>
                  </select>
                </div>
              </div>
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 " style="background-color: #5CB1D4">
                <h5 class="text-center" style="color: #FFFFFF;">SUNRISE To Complete</h5>
              </div>
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Incident Welfare Service Form (WSF) Completed?</label>
                  <select id="select_get_type" name="incident" for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label form-control" style="width: 30%;">
                  <option value="<?php echo $form['incident']; ?>"><?php echo $form['incident']; ?></option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                    <option value="In progress">In progress</option>
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width: 200px;">Comment</label>
                  <textarea type="text" name="comment1" class="form-control" style=" width: 600px; height:100px;"><?php echo $form['comment1']; ?></textarea>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;">In-house record of any complaints from the claimant/s</label>
                  <select id="select_get_type" name="complaints" for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label form-control" style="width: 30%; margin-top: 18px;">
                    <option value="<?php echo $form['complaints']; ?>"><?php echo $form['complaints']; ?></option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                    <option value="In progress">In progress</option>
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width: 200px;">Comment</label>
                  <textarea type="text" name="comment2" class="form-control" style=" width: 600px; height:100px;"><?php echo $form['comment2']; ?></textarea>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Any Record of the Claimant/s visiting hotel doctor?</label>
                  <select id="select_get_type" name="doctor" for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label form-control" style="width: 30%; margin-top: 18px;">
                    <option value="<?php echo $form['doctor']; ?>"><?php echo $form['doctor']; ?></option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                    <option value="In progress">In progress</option>
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;">Comment</label>
                  <textarea type="text" name="comment3" class="form-control" style=" width: 600px; height:100px;"><?php echo $form['comment3']; ?></textarea>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Date First Notice Received </label>
                  <div class='input-group date' id='datetimepicker2' style=" width: 30%; margin-top:18px;">
                    <input type="text" name="first_notice" class="form-control" value="<?php echo $form['first_notice']; ?>" /> 
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calender"></span></span>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;">Value of Reserve £</label>
                  <input type="number" class="form-control" name="reserve"  style=" width: 30%;" value="<?php echo $form['reserve']; ?>" /></input> 
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Is a Solicitor acting on behalf of the claimants?</label>
                  <select id="select_get_type" name="solicitor" for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label form-control" style="width: 30%; margin-top: 7px;">
                    <option value="<?php echo $form['solicitor']; ?>"><?php echo $form['solicitor']; ?></option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                    <option value="In progress">In progress</option>
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;">Name</label>
                  <input type="text" name="solicitor_name" class="form-control" value="<?php echo $form['solicitor_name']; ?>" style=" height:38px; width: 30%;"/>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Copies of Original Letter from Claimant/s and/or Solicitor?</label>
                  <select id="select_get_type" name="letter" for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label form-control" style="width: 30%; margin-top: 18px;">
                    <option value="<?php echo $form['letter']; ?>"><?php echo $form['letter']; ?></option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                    <option value="In progress">In progress</option>
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <input type="hidden" name="fm_id" value="<?php echo $form['id']; ?>" />
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Upload</label> 
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <input id="offers" name="upload" type="file" class="file" multiple="true" data-show-upload="false" data-show-caption="true">
                  </div>
                  <script>
                    $("#offers").fileinput({
                      uploadUrl: "/form/make_offer_after/<?php echo $form['id'] ?>/1",
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
                          {url: "/form/remove_offer_after/<?php echo $form['id'] ?>/<?php echo $upload['id'] ?>", key: "<?php echo $upload['name']; ?>"},
                        <?php endforeach; ?>
                      ],
                    });
                  </script>
                </div>   
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Medical Report</label>
                  <select id="select_get_type" name="medical" for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label form-control" style="width: 30%;">
                  <option value="<?php echo $form['medical']; ?>"><?php echo $form['medical']; ?></option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                    <option value="In progress">In progress</option>
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <input type="hidden" name="fm_id1" value="<?php echo $form['id']; ?>" />
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Upload</label> 
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <input id="offers1" name="upload1" type="file" class="file" multiple="true" data-show-upload="false" data-show-caption="true">
                  </div>
                  <script>
                    $("#offers1").fileinput({
                      uploadUrl: "/form/make_offer_after1/<?php echo $form['id'] ?>/2",
                      uploadAsync: true,
                      minFileCount: 1,
                      maxFileCount: 100,
                      overwriteInitial: false,
                      initialPreview: [
                        <?php foreach($uploads1 as $upload): ?>
                          "<div class='file-preview-text'>" +
                          "<h2><i class='glyphicon glyphicon-file'></i></h2>" +
                          "<a href='/assets/uploads/files/<?php echo $upload['name'] ?>'><?php echo $upload['name'] ?></a>" + "</div>",
                        <?php endforeach ?>
                      ],
                      initialPreviewConfig: [
                        <?php foreach($uploads1 as $upload): ?>
                          {url: "/form/remove_offer_after1/<?php echo $form['id'] ?>/<?php echo $upload['id'] ?>", key: "<?php echo $upload['name']; ?>"},
                        <?php endforeach; ?>
                      ],
                    });
                  </script>
                </div> 
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Photographs</label>
                  <select id="select_get_type" name="photographs" for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label form-control" style="width: 30%;">
                    <option value="<?php echo $form['photographs']; ?>"><?php echo $form['photographs']; ?></option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                    <option value="In progress">In progress</option>
                  </select>
                </div> 
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <input type="hidden" name="fm_id2" value="<?php echo $form['id']; ?>" />
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Upload</label> 
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <input id="offers2" name="upload2" type="file" class="file" multiple="true" data-show-upload="false" data-show-caption="true">
                  </div>
                  <script>
                    $("#offers2").fileinput({
                      uploadUrl: "/form/make_offer_after2/<?php echo $form['id'] ?>/3",
                      uploadAsync: true,
                      minFileCount: 1,
                      maxFileCount: 100,
                      overwriteInitial: false,
                      initialPreview: [
                        <?php foreach($uploads2 as $upload): ?>
                          "<div class='file-preview-text'>" +
                          "<h2><i class='glyphicon glyphicon-file'></i></h2>" +
                          "<a href='/assets/uploads/files/<?php echo $upload['name'] ?>'><?php echo $upload['name'] ?></a>" + "</div>",
                        <?php endforeach ?>
                      ],
                      initialPreviewConfig: [
                        <?php foreach($uploads2 as $upload): ?>
                          {url: "/settlement/remove_offer_after2/<?php echo $form['id'] ?>/<?php echo $upload['id'] ?>", key: "<?php echo $upload['name']; ?>"},
                        <?php endforeach; ?>
                      ],
                    });
                  </script>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Other</label>
                  <select id="select_get_type" name="Other" for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label form-control" style="width: 30%;">
                  <option value="<?php echo $form['Other']; ?>"><?php echo $form['Other']; ?></option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                    <option value="In progress">In progress</option>
                  </select>
                </div> 
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <input type="hidden" name="fm_id3" value="<?php echo $form['id']; ?>" />
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Upload</label> 
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <input id="offers3" name="upload3" type="file" class="file" multiple="true" data-show-upload="false" data-show-caption="true">
                  </div>
                  <script>
                    $("#offers3").fileinput({
                      uploadUrl: "/form/make_offer_after3/<?php echo $form['id'] ?>/4", // server upload action
                      uploadAsync: true,
                      minFileCount: 1,
                      maxFileCount: 100,
                      overwriteInitial: false,
                      initialPreview: [
                        <?php foreach($uploads3 as $upload): ?>
                          "<div class='file-preview-text'>" +
                          "<h2><i class='glyphicon glyphicon-file'></i></h2>" +
                          "<a href='/assets/uploads/files/<?php echo $upload['name'] ?>'><?php echo $upload['name'] ?></a>" + "</div>",
                        <?php endforeach ?>
                      ],
                      initialPreviewConfig: [
                        <?php foreach($uploads3 as $upload): ?>
                          {url: "/form/remove_offer_after3/<?php echo $form['id'] ?>/<?php echo $upload['id'] ?>", key: "<?php echo $upload['name']; ?>"},
                        <?php endforeach; ?>
                      ],
                    });
                  </script>
                </div> 
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Date SUNRISE Responded to the First Notice </label>
                  <div class='input-group date' id='datetimepicker3' style="width: 30%; margin-top: 30px">
                    <input type="text" name="responded" class="form-control" value="<?php echo $form['responded']; ?>" /> 
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calender"></span></span>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Date SUNRISE notified their insurers </label>
                  <div class='input-group date' id='datetimepicker4' style="width: 30%; margin-top: 7px">
                    <input type="text" name="notified" class="form-control" value="<?php echo $form['notified']; ?>" /> 
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calender"></span></span>
                  </div>  
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;">Insurers comments</label>
                  <textarea type="text" name="insurers" class="form-control" style=" width: 600px; height: 100px"><?php echo $form['insurers']; ?></textarea>
                </div>
              </div>
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 " style="background-color: #5CB1D4">
                <h5 class="text-center" style="color: #FFFFFF;">CCRM To Complete</h5>
              </div>
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Date Issued </label>
                  <div class='input-group date' id='datetimepicker5' style=" width: 30%; margin:10px;">
                    <input type="text" name="date_issued" class="form-control" value="<?php echo $form['date_issued']; ?>" /> 
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calender"></span></span>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;">Amount £</label>
                  <input type="number" class="form-control" name="amount" value="<?php echo $form['amount']; ?>"  style="width: 30%; margin-top: 7px"/></input> 
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;">Reason for Settlement</label>
                  <textarea type="text" name="settlement" class="form-control" style=" width: 600px; height: 100px"><?php echo $form['settlement']; ?></textarea>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Tour Operator Decision</label>
                  <select id="select_get_type" name="decision" for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label form-control" style="width: 30%;">
                    <option value="<?php echo $form['decision']; ?>"><?php echo $form['decision']; ?></option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                    <option value="In progress">In progress</option>
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;">Reason for decline</label>
                  <textarea type="text" name="decline" class="form-control" style=" width: 600px; height: 100px; margin:10px;"><?php echo $form['decline']; ?></textarea>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Dates SUNRISE notified their insurers </label>
                  <div class='input-group date' id='datetimepicker6' style="width: 30%; margin:18px;">
                    <input type="text" name="notified1" class="form-control" value="<?php echo $form['notified1']; ?>" /> 
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calender"></span></span>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;">Insurers comments</label>
                  <textarea type="text" name="insurers1" class="form-control" style=" width: 600px; height: 100px; margin:10px;"><?php echo $form['insurers1']; ?></textarea>
                </div>    
              </div>
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 " style="background-color: #5CB1D4">
                <h5 class="text-center" style="color: #FFFFFF;">CCRM To Complete</h5>
              </div>
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Date Issued </label>
                  <div class='input-group date' id='datetimepicker7' style="width: 30%;">
                    <input type="text" name="issued" class="form-control" value="<?php echo $form['issued']; ?>" /> 
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calender"></span></span>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;">Detail</label>
                  <textarea type="text" name="detail" class="form-control" style=" width: 600px; height: 100px; margin:10px;"><?php echo $form['detail']; ?></textarea>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Date Issued </label>
                  <div class='input-group date' id='datetimepicker8' style="width: 30%;">
                    <input type="text" name="issued1" class="form-control" value="<?php echo $form['issued1']; ?>" /> 
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calender"></span></span>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;">Detail</label>
                  <textarea type="text" name="detail1" class="form-control" style=" width: 600px; height: 100px; margin:10px;"><?php echo $form['detail1']; ?></textarea>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Date Issued </label>
                  <div class='input-group date' id='datetimepicker9' style="width: 30%;">
                    <input type="text" name="issued2" class="form-control" value="<?php echo $form['issued2']; ?>" /> 
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calender"></span></span>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;">Detail</label>
                  <textarea type="text" name="detail2" class="form-control" style=" width: 600px; height: 100px; margin:10px;"><?php echo $form['detail2']; ?></textarea>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Date Issued </label>
                  <div class='input-group date' id='datetimepicker10' style="width: 30%;">
                    <input type="text" name="issued3" class="form-control" value="<?php echo $form['issued3']; ?>" /> 
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calender"></span></span>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;">Detail</label>
                  <textarea type="text" name="detail3" class="form-control" style=" width: 600px; height: 100px; margin:10px;"><?php echo $form['detail3']; ?></textarea>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Date Issued </label>
                  <div class='input-group date' id='datetimepicker11' style="width: 30%;">
                    <input type="text" name="issued4" class="form-control" value="<?php echo $form['issued4']; ?>" /> 
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calender"></span></span>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;">Detail</label>
                  <textarea type="text" name="detail4" class="form-control" style=" width: 600px; height: 100px; margin:10px;"><?php echo $form['detail4']; ?></textarea>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <input type="hidden" name="fm_id4" value="<?php echo $form['id']; ?>" />
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width: 200px;"> Upload Any Other Doucuments</label> 
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <input id="offers4" name="upload4" type="file" class="file" multiple="true" data-show-upload="false" data-show-caption="true">
                  </div>
                  <script>
                    $("#offers4").fileinput({
                      uploadUrl: "/form/make_offer_after4/<?php echo $form['id'] ?>/5",
                      uploadAsync: true,
                      minFileCount: 1,
                      maxFileCount: 100,
                      overwriteInitial: false,
                      initialPreview: [
                        <?php foreach($uploads4 as $upload): ?>
                          "<div class='file-preview-text'>" +
                          "<h2><i class='glyphicon glyphicon-file'></i></h2>" +
                          "<a href='/assets/uploads/files/<?php echo $upload['name'] ?>'><?php echo $upload['name'] ?></a>" + "</div>",
                        <?php endforeach ?>
                      ],
                      initialPreviewConfig: [
                        <?php foreach($uploads4 as $upload): ?>
                          {url: "/form/remove_offer_after4/<?php echo $form['id'] ?>/<?php echo $upload['id'] ?>", key: "<?php echo $upload['name']; ?>"},
                        <?php endforeach; ?>
                      ],
                    });
                  </script>
                </div>
              </div>
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 " style="background-color: #5CB1D4">
                <h5 class="text-center" style="color: #FFFFFF;">CCRM To Complete | Reserve Updates</h5>
              </div>
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Date Received </label>
                  <div class='input-group date' id='datetimepicker12' style="width: 30%;">
                    <input type="text" name="received" class="form-control" value="<?php echo $form['received']; ?>" /> 
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calender"></span></span>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;">Amount £</label>
                  <input type="number" class="form-control" name="amount1" value="<?php echo $form['amount1']; ?>"  style="width: 30%; margin-top: 7px;"/></input> 
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;">Text</label>
                  <textarea type="text" name="text" class="form-control" style=" width: 600px; height: 100px; margin:10px;"><?php echo $form['text']; ?></textarea>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Date Received </label>
                  <div class='input-group date' id='datetimepicker13' style="width: 30%;">
                    <input type="text" name="received1" class="form-control" value="<?php echo $form['received1']; ?>" /> 
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calender"></span></span>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;">Amount £</label>
                  <input type="number" class="form-control" name="amount2" value="<?php echo $form['amount2']; ?>"  style="width: 30%; margin-top: 7px;"/></input> 
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;">Text</label>
                  <textarea type="text" name="text1" class="form-control" style=" width: 600px; height: 100px; margin:10px;"><?php echo $form['text1']; ?></textarea>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Date Received </label>
                  <div class='input-group date' id='datetimepicker14' style="width: 30%;">
                    <input type="text" name="received2" class="form-control" value="<?php echo $form['received2']; ?>" /> 
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calender"></span></span>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;">Amount £</label>
                  <input type="number" class="form-control" name="amount3" value="<?php echo $form['amount3']; ?>"  style="width: 30%; margin-top: 7px;"/></input> 
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;">Text</label>
                  <textarea type="text" name="text2" class="form-control" style=" width: 600px; height: 100px; margin:10px;"><?php echo $form['text2']; ?></textarea>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Date Received </label>
                  <div class='input-group date' id='datetimepicker15' style="width: 30%;">
                    <input type="text" name="received3" class="form-control" value="<?php echo $form['received3']; ?>" /> 
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calender"></span></span>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;">Amount £</label>
                  <input type="number" class="form-control" name="amount4" value="<?php echo $form['amount4']; ?>"  style="width: 30%; margin-top: 7px;"/></input> 
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;">Text</label>
                  <textarea type="text" name="text3" class="form-control" style=" width: 600px; height: 100px; margin:10px;"><?php echo $form['text3']; ?></textarea>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Date Received </label>
                  <div class='input-group date' id='datetimepicker16' style="width: 30%;">
                    <input type="text" name="received4" class="form-control" value="<?php echo $form['received4']; ?>" /> 
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calender"></span></span>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;">Amount £</label>
                  <input type="number" class="form-control" name="amount5" value="<?php echo $form['amount5']; ?>"  style=" width: 240px; margin:10px;"/></input> 
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;">Text</label>
                  <textarea type="text" name="text4" class="form-control" style=" width: 600px; height: 100px; margin:10px;"><?php echo $form['text4']; ?></textarea>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Dates SUNRISE notified their insurers </label>
                  <div class='input-group date' id='datetimepicker17' style="width: 30%;">
                    <input type="text" name="notified2" class="form-control" value="<?php echo $form['notified2']; ?>" /> 
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calender"></span></span>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;">Insurers comments</label>
                  <textarea type="text" name="insurers2" class="form-control" style=" width: 600px; height: 100px; margin:10px;"><?php echo $form['insurers2']; ?></textarea>
                </div>
              </div>
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 " style="background-color: #5CB1D4">
                <h5 class="text-center" style="color: #FFFFFF;">CCRM To Complete</h5>
              </div>                
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Date Closed Notice Received </label>
                  <div class='input-group date' id='datetimepicker18' style="width: 30%;">
                    <input type="text" name="closed" class="form-control" value="<?php echo $form['closed']; ?>" /> 
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calender"></span></span>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;">Recovery Amount £</label>
                  <input type="number" class="form-control" name="recovery" value="<?php echo $form['recovery']; ?>"  style="width: 30%; margin-top: 7px;"/></input> 
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;">Detail Supporting Evidence received from Tour Operator</label>
                  <textarea type="text" name="supporting" class="form-control" style=" width: 600px; height: 100px; margin:10px;"><?php echo $form['supporting']; ?></textarea>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Settlement Date </label>
                  <div class='input-group date' id='datetimepicker19' style="width: 30%;">
                    <input type="text" name="settlement_date" class="form-control" value="<?php echo $form['settlement_date']; ?>" /> 
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calender"></span></span>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;">Amount £ Agreed</label>
                  <input type="number" class="form-control" name="agreed" value="<?php echo $form['agreed']; ?>"  style="width: 30%; margin-top: 7px;"/></input> 
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;"> Dates SUNRISE notified their insurers </label>
                  <div class='input-group date' id='datetimepicker20' style="width: 30%;">
                    <input type="text" name="notified3" class="form-control" value="<?php echo $form['notified3']; ?>" /> 
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calender"></span></span>
                  </div>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px;">Insurers comments</label>
                  <textarea type="text" name="insurers3" class="form-control" style=" width: 600px; height: 100px; margin:10px;"><?php echo $form['insurers3']; ?></textarea>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <input type="hidden" name="fm_id5" value="<?php echo $form['id']; ?>" />
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin:5px; width: 200px;"> Upload Any Other Doucuments</label> 
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <input id="offers5" name="upload5" type="file" class="file" multiple="true" data-show-upload="false" data-show-caption="true">
                  </div>
                  <script>
                    $("#offers5").fileinput({
                      uploadUrl: "/form/make_offer_after5/<?php echo $form['id'] ?>/6",
                      uploadAsync: true,
                      minFileCount: 1,
                      maxFileCount: 100,
                      overwriteInitial: false,
                      initialPreview: [
                        <?php foreach($uploads5 as $upload): ?>
                          "<div class='file-preview-text'>" +
                          "<h2><i class='glyphicon glyphicon-file'></i></h2>" +
                          "<a href='/assets/uploads/files/<?php echo $upload['name'] ?>'><?php echo $upload['name'] ?></a>" + "</div>",
                        <?php endforeach ?>
                      ],
                      initialPreviewConfig: [
                        <?php foreach($uploads5 as $upload): ?>
                          {url: "/form/remove_offer_after5/<?php echo $form['id'] ?>/<?php echo $upload['id'] ?>", key: "<?php echo $upload['name']; ?>"},
                        <?php endforeach; ?>
                      ],
                    });
                  </script>
                </div>    
              </div>
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 " style="background-color: #5CB1D4">
                <h5 class="text-center" style="color: #FFFFFF;">Claim Details</h5>
              </div>  
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px; height: 100px;"> Confirmed Gastric</label>
                  <select id="select_get_type" name="confirmed" for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label form-control" style="width: 30%;">
                  <option value="<?php echo $form['confirmed']; ?>"><?php echo $form['confirmed']; ?></option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                    <option value="In progress">In progress</option>
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <textarea type="text" name="confirmed_text" class="form-control" style=" width: 600px; height: 100px; margin:10px;"><?php echo $form['confirmed_text']; ?></textarea>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px; height: 100px;"> Unconfirmed Gastric</label>
                  <select id="select_get_type" name="unconfirmed" for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label form-control" style="width: 30%;">
                  <option value="<?php echo $form['unconfirmed']; ?>"><?php echo $form['unconfirmed']; ?></option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                    <option value="In progress">In progress</option>
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <textarea type="text" name="unconfirmed_text" class="form-control" style=" width: 600px; height: 100px; margin:10px;"><?php echo $form['unconfirmed_text']; ?></textarea>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px; height: 100px;"> Accident</label>
                  <select id="select_get_type" name="accident" for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label form-control" style="width: 30%;">
                  <option value="<?php echo $form['accident']; ?>"><?php echo $form['accident']; ?></option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                    <option value="In progress">In progress</option>
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <textarea type="text" name="accident_text" class="form-control" style=" width: 600px; height: 100px; margin:10px;"><?php echo $form['accident_text']; ?></textarea>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin:5px; width: 200px; height: 100px;"> Other</label>
                  <select id="select_get_type" name="other1" for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label form-control" style="width: 30%;">
                  <option value="<?php echo $form['other1']; ?>"><?php echo $form['other1']; ?></option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                    <option value="In progress">In progress</option>
                  </select>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <textarea type="text" name="other_text" class="form-control" style=" width: 600px; height: 100px; margin:10px;"><?php echo $form['other_text']; ?></textarea>
                </div>
              </div>
              <div style="    margin-top: 90px;" class="form-group">
                <div class="col-lg-offset-3 col-lg-10 col-md-10 col-md-offset-3">
                  <input name="submit" value="Confirm" type="submit" class="btn btn-success" />
                  <a href="<?= base_url(); ?>form/view_after/<?php echo $form['id']; ?>" class="btn btn-warning">Cancel</a>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <script type="text/javascript">
      $(function(){
        $('#datetimepicker').datetimepicker({
          viewMode:'days',
          format:'DD/MM/YYYY'
        });
      });
    </script>
    <script type="text/javascript">
      $(function(){
        $('#datetimepicker1').datetimepicker({
          viewMode:'days',
          format:'DD/MM/YYYY'
        });
      });
    </script>
    <script type="text/javascript">
      $(function(){
        $('#datetimepicker2').datetimepicker({
          viewMode:'days',
          format:'DD/MM/YYYY'
        });
      });
    </script>
    <script type="text/javascript">
      $(function(){
        $('#datetimepicker3').datetimepicker({
          viewMode:'days',
          format:'DD/MM/YYYY'
        });
      });
    </script>
    <script type="text/javascript">
      $(function(){
        $('#datetimepicker4').datetimepicker({
          viewMode:'days',
          format:'DD/MM/YYYY'
        });
      });
    </script>
    <script type="text/javascript">
      $(function(){
        $('#datetimepicker5').datetimepicker({
          viewMode:'days',
          format:'DD/MM/YYYY'
        });
      });
    </script>
    <script type="text/javascript">
      $(function(){
        $('#datetimepicker6').datetimepicker({
          viewMode:'days',
          format:'DD/MM/YYYY'
        });
      });
    </script>
    <script type="text/javascript">
      $(function(){
        $('#datetimepicker7').datetimepicker({
          viewMode:'days',
          format:'DD/MM/YYYY'
        });
      });
    </script>
    <script type="text/javascript">
      $(function(){
        $('#datetimepicker8').datetimepicker({
          viewMode:'days',
          format:'DD/MM/YYYY'
        });
      });
    </script>
    <script type="text/javascript">
      $(function(){
        $('#datetimepicker9').datetimepicker({
          viewMode:'days',
          format:'DD/MM/YYYY'
        });
      });
    </script>
    <script type="text/javascript">
      $(function(){
        $('#datetimepicker10').datetimepicker({
          viewMode:'days',
          format:'DD/MM/YYYY'
        });
      });
    </script>
    <script type="text/javascript">
      $(function(){
        $('#datetimepicker10').datetimepicker({
          viewMode:'days',
          format:'DD/MM/YYYY'
        });
      });
    </script>
    <script type="text/javascript">
      $(function(){
        $('#datetimepicker10').datetimepicker({
          viewMode:'days',
          format:'DD/MM/YYYY'
        });
      });
    </script>
    <script type="text/javascript">
      $(function(){
        $('#datetimepicker11').datetimepicker({
          viewMode:'days',
          format:'DD/MM/YYYY'
        });
      });
    </script>
    <script type="text/javascript">
      $(function(){
        $('#datetimepicker12').datetimepicker({
          viewMode:'days',
          format:'DD/MM/YYYY'
        });
      });
    </script>
    <script type="text/javascript">
      $(function(){
        $('#datetimepicker13').datetimepicker({
          viewMode:'days',
          format:'DD/MM/YYYY'
        });
      });
    </script>
    <script type="text/javascript">
      $(function(){
        $('#datetimepicker14').datetimepicker({
          viewMode:'days',
          format:'DD/MM/YYYY'
        });
      });
    </script>
    <script type="text/javascript">
      $(function(){
        $('#datetimepicker15').datetimepicker({
          viewMode:'days',
          format:'DD/MM/YYYY'
        });
      });
    </script>
    <script type="text/javascript">
      $(function(){
        $('#datetimepicker16').datetimepicker({
          viewMode:'days',
          format:'DD/MM/YYYY'
        });
      });
    </script>
    <script type="text/javascript">
      $(function(){
        $('#datetimepicker17').datetimepicker({
          viewMode:'days',
          format:'DD/MM/YYYY'
        });
      });
    </script>
    <script type="text/javascript">
      $(function(){
        $('#datetimepicker18').datetimepicker({
          viewMode:'days',
          format:'DD/MM/YYYY'
        });
      });
    </script>
    <script type="text/javascript">
      $(function(){
        $('#datetimepicker19').datetimepicker({
          viewMode:'days',
          format:'DD/MM/YYYY'
        });
      });
    </script>
    <script type="text/javascript">
      $(function(){
        $('#datetimepicker20').datetimepicker({
          viewMode:'days',
          format:'DD/MM/YYYY'
        });
      });
    </script>
  </body>
</html>