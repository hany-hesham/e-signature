<!DOCTYPE html>
<html lang="en">
<head>
<?php $this->load->view('header'); ?>
</head>
<body>
<div id="wrapper">
  <?php $this->load->view('menu') ?>
  <div id="page-wrapper">
  <div class="container">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <fieldset>
      <legend>Submit a new form</legend>

      <?php if(validation_errors() != false): ?>
        <div class="alert alert-danger">
          <?php echo validation_errors(); ?>
        </div>
      <?php endif ?>

      <form method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
        
        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;"> Hotel</label>
          
            <select class="form-control" name="hotel_id" id="from-hotel " style="width: 30%;">
              <option data-company="0" value="<?php echo $spo_contents['hotel_id']?>"><?php echo $spo_contents['hotel_name']?></option>
              <?php foreach ($hotels as $hotel): ?>
                <option value="<?php echo $hotel['id'] ?>" <?php echo set_select('from-hotel',$hotel['id'] ); ?>><?php echo $hotel['name'] ?></option>
              <?php endforeach ?>
            </select>
        </div>
          <table class="table table-striped table-bordered table-condensed" >
          <thead >
            <tr>
              <th colspan="1" style=" text-align: center;">Season</th>
              <th colspan="2" style=" text-align: center;">Travel period</th>
              <th colspan="2" style=" text-align: center;">Booking Window</th>
              <th colspan="5" style=" text-align: center;">Arrival Date</th>
              <th colspan="1" style=" text-align: center;">To</th>
            </tr>
          </thead>
          <tbody>
            <tr >
                    <td style=" text-align: center;"> <br> <input type="text" name="season" class="form-control"   style="width: 180px; height:35px; " value="<?php echo $spo_contents['season']?>" /></input> </td>
              <td style=" text-align: center;"> From <input type="date" class="form-control" name="Travel_Date" value="<?php echo $spo_contents['Travel_Date']?>" /></input></td>
                          <td style=" text-align: center;">TO    <input type="date" class="form-control" name="Travel_Date2" value="<?php echo $spo_contents['Travel_Date2']?>" /></input> </td>
                          <td style=" text-align: center;"> From <input type="date" class="form-control" name="Booking_Window" value="<?php echo $spo_contents['Booking_Window']?>" /></input></td>
                          <td style=" text-align: center;">TO    <input type="date" class="form-control" name="Booking_Window2" value="<?php echo $spo_contents['Booking_Window2']?>" /></input> </td>
                          <td style=" text-align: center;"> <br> <input type="date" class="form-control" name="arrival_date" value="<?php echo $spo_contents['arrival_date']?>" /></input></td>
                          <td style=" text-align: center;"> <br> <input type="date" class="form-control" name="arrival_date2" value="<?php echo $spo_contents['arrival_date2']?>" /></input> </td>
              <td style=" text-align: center;"> <br> <input type="date" class="form-control" name="arrival_date3" value="<?php echo $spo_contents['arrival_date3']?>" /></input></td>
                          <td style=" text-align: center;"> <br> <input type="date" class="form-control" name="arrival_date4" value="<?php echo $spo_contents['arrival_date4']?>" /></input> </td>
              <td style=" text-align: center;"> <br> <input type="date" class="form-control" name="arrival_date5" value="<?php echo $spo_contents['arrival_date5']?>" /></input></td>
              <td style=" text-align: center;"> <br> <input type="text" class="form-control" name="to" value="<?php echo $spo_contents['to']?>"   style="width: 180px; height:35px; "/></input> </td>
            </tr>
          </tbody>
        </table>
        <table class="table table-striped table-bordered table-condensed">
          <thead>
            <tr>
              <td colspan="2" rowspan="1" class="centered">Period</td>
              <td colspan="2" rowspan="1" class="centered">Occupancy MTD </td>
              <td colspan="1" rowspan="2" class="centered">contracted  <br />Rate </td>
              <!--<td colspan="1" rowspan="2" class="centered" style = "width:10px">SPO </td>-->
              <td colspan="1" rowspan="2" class="centered">Discount <br />Persantage <br /> %</td>
              <td colspan="1" rowspan="2" class="centered" style = "width:10px">Room Nights </td>
              <td colspan="2" rowspan="1" class="centered">Matreialization </td>
              <td colspan="1" rowspan="2" class="centered" style = "width:10px">Currency</td>
            </tr>
            <tr>
              <td>From</td>
              <td>To</td>
              <td>Occ%</td>
              <td>Month</td>
              <td>Occ%</td>
              <td>Month</td>
            </tr>        
          </thead>
          <tbody id="items-container" data-items="1">
            <?php foreach ($get_spo_items as $item) { ?>
              <tr id="item-<?php echo $item['id']?>">
                

                <td hidden><input name="items[<?php echo $item['id']?>][id]" value="<?php echo $item['id']?>"></td>
                


                <td><input type="date" class="form-control" style="width: 180px; height:35px; " name="items[<?php echo $item['id']?>][peroid_from]" value="<?php echo $item['peroid_from']?>" /></td>
                


                <td><input type="date" style="width: 180px; height:35px; " class="form-control" name="items[<?php echo $item['id']?>][peroid_to]" value="<?php echo $item['peroid_to']?>" /></td>
                


                <td><input class="form-control" type="text" name="items[<?php echo $item['id']?>][MTD_OCC]" style="width: 80px; height:35px; " value="<?php echo $item['MTD_OCC']?>" /></td>
                

                <td><input type="month" class="form-control" name="items[<?php echo $item['id']?>][MTD_month]" style="width: 180px; height:35px; " value="<?php echo $item['MTD_month']?>" /></td>
                

                <td><input type="number" class="form-control" name="items[<?php echo $item['id']?>][Contracted_prices]" style="width: 180px; height:35px; " value="<?php echo $item['Contracted_prices'] ?>" /></td>
                

                <!--<td><input type="text" class="form-control" name="items[<?php echo $item['id']?>][spo]" style="width: 180px; height:35px; " value="<?php echo $item['spo'] ?>" /></td>-->
                <td><input type="text" class="form-control" name="items[<?php echo $item['id']?>][Discount_percentage]" style="width: 180px; height:35px; " value="<?php echo $item['Discount_percentage'] ?>"/></input></td> 

                
                <td><input type="number" class="form-control" name="items[<?php echo $item['id']?>][room_nights]" style="width: 180px; height:35px; " value="<?php echo $item['room_nights'] ?>" /></td>
                

                <td><input type="text" class="form-control" name="items[<?php echo $item['id']?>][Materialization_occ]" style="width: 180px; height:35px; " value="<?php echo $item['Materialization_occ']?>" /></td>
                

                <td><input type="month" class="form-control" name="items[<?php echo $item['id']?>][Materialization_month]" style="width: 180px; height:35px; " value="<?php echo $item['Materialization_month']?>" /></td>
                

                <td>
                  <select class="form-control" name="items[<?php echo $item['id']?>][currency]" style="width: 100px; height:35px; ">
                    <option value="<?php echo $item['currency']  ?>"><?php echo $item['currency']  ?></option>
                    <option>$</option>
                    <option>EGP</option>
                    <option>EURO</option>
                  </select>
                </td>
              </tr>
            <?php }?>
          </tbody>
        </table>

        <script type="text/javascript">
        document.items = <?php echo json_encode($this->input->post('items')); ?>;
        </script>
        <table class="table table-striped table-bordered table-condensed" style="width: 80%;" >
          <thead>
            <tr><td colspan="5" style=" text-align: center;">Competition Survey</td></tr>
            <tr><td style=" text-align: center;">Hotel</td>
            <td style=" text-align: center;">Peroid</td>   
            <td style=" text-align: center;">Price</td>
            <td style=" text-align: center;">Peroid</td>
            <td style=" text-align: center;">Price</td>
          </tr>
          </thead>
          <tbody>
            <?php foreach ($competitions as $competition) { ?>
              <tr id="competition-<?php echo $competition['id'];?>">
                <td hidden="">
                  <input class="form-control" name="competitions[<?php echo $competition['id'];?>][id]" value="<?php echo $competition['id'];?>">
                </td>
                <td>
                  <input type="text" class="form-control" style=" margin-top:22px;" name="competitions[<?php echo $competition['id'];?>][hotel]" value="<?php echo $competition['hotel'];?>" />
                </td>
                <td>
                  <input type="date" class="form-control" name="competitions[<?php echo $competition['id'];?>][from]" value="<?php echo $competition['from'];?>" />
                  <input type="date" class="form-control" style=" margin-top:5px;" name="competitions[<?php echo $competition['id'];?>][to]" value="<?php echo $competition['to'];?>"/> 
                </td>
                <td>
                  <input type="number" class="form-control" style=" margin-top:25px;" name="competitions[<?php echo $competition['id'];?>][price]" value="<?php echo $competition['price'];?>" /> 
                </td>
                <td>
                  <input type="date" class="form-control" name="competitions[<?php echo $competition['id'];?>][from2]" value="<?php echo $competition['from2'];?>" />
                  <input type="date" class="form-control" style=" margin-top:5px;" name="competitions[<?php echo $competition['id'];?>][to2]" value="<?php echo $competition['to2'];?>" /> 
                </td>
                <td>
                  <input type="number" class="form-control" style=" margin-top:25px;" name="competitions[<?php echo $competition['id'];?>][price2]" value="<?php echo $competition['price2'];?>"/> 
                </td>
              </tr>
            <?php } ?>
          </tbody >
        </table>
        <script type="text/javascript">
          document.competitions = <?php echo json_encode($this->input->post('competitions')); ?>;
        </script>
        <div class="form-group col-lg-8 col-md-8 col-sm-8 col-xs-8">
                  <br>
                  <input type="hidden" name="spo_id" value="<?php echo $spo_contents['id'] ?>" />
                  <label for="offers" class="col-lg-3 col-md-4 col-sm-5 col-xs-5 control-label">Report Files</label>
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <input id="offers" name="upload" type="file" class="file" multiple="true" data-show-upload="false" data-show-caption="true">
                  </div>
                  <script>
                    $("#offers").fileinput({
                      uploadUrl: "/spo/upload/<?php echo $spo_contents['id'] ?>",
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
                          {url: "/spo/remove/<?php echo $spo_contents['id'] ?>/<?php echo $upload['id'] ?>", key: "<?php echo $upload['name']; ?>"},
                        <?php endforeach; ?>
                      ],
                    });
                  </script>
                </div>
        <div style="    margin-top: 90px;" class="form-group">
            <div class="col-lg-offset-3 col-lg-10 col-md-10 col-md-offset-3">
              <input name="submit" value="Submit" type="submit" class="btn btn-success" />
              <a href="<?= base_url(); ?>spo" class="btn btn-warning">Cancel</a>
            </div>
        </div>

      </form>
      </fieldset>
    </div>
  </div>
  </div>
</div>

</body>
</html>
