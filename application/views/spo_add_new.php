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
              </fieldset>
			        <form action="" method="POST" id="form-submit" enctype="multipart/form-data" class="form-div span12" accept-charset="utf-8">
				        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
					        <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label " style="margin-top:5px;"> Hotel Name </label>
      						<select class="form-control" name="hotel_id" id="from-hotel " style="width: 30%;">
							      <option data-company="0" value="">Select Hotel..</option>
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
		             		  <td style=" text-align: center;"> <br> <input type="text" name="season" class="form-control"   style="width: 180px; height:35px; " /></input> </td>
							        <td style=" text-align: center;"> From <input type="date" class="form-control" name="Travel_Date" /></input></td>
                      <td style=" text-align: center;">TO    <input type="date" class="form-control" name="Travel_Date2" /></input> </td>
                      <td style=" text-align: center;"> From <input type="date" class="form-control" name="Booking_Window" /></input></td>
                      <td style=" text-align: center;">TO    <input type="date" class="form-control" name="Booking_Window2" /></input> </td>
                      <td style=" text-align: center;"> <br> <input type="date" class="form-control" name="arrival_date" /></input></td>
                      <td style=" text-align: center;"> <br> <input type="date" class="form-control" name="arrival_date2" /></input> </td>
							        <td style=" text-align: center;"> <br> <input type="date" class="form-control" name="arrival_date3" /></input></td>
                      <td style=" text-align: center;"> <br> <input type="date" class="form-control" name="arrival_date4" /></input> </td>
							        <td style=" text-align: center;"> <br> <input type="date" class="form-control" name="arrival_date5" /></input></td>
							        <td style=" text-align: center;"> <br> <input type="text" class="form-control" name="to"   style="width: 180px; height:35px; "/></input> </td>
						        </tr>
					        </tbody>
				        </table>
				        <table class="table table-striped table-bordered table-condensed" style="border: 1px solid black  !important; ">
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
                      <td colspan="1" rowspan="2" class="centered" style = "width:10px">Action</td>
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
						        <tr id="item-1">
        							<td><input type="date" class="form-control" style="width: 180px; height:35px; " name="items[1][peroid_from]" id="item-1-peroid_from" ></input></td>
                      <td><input type="date" style="width: 180px; height:35px; " class="form-control" name="items[1][peroid_to]" id="item-1-peroid_to"></input></td>
                      <td><input class="form-control" type="text" name="items[1][MTD_OCC]" id="item-1-MTD_OCC" style="width: 80px; height:35px; "/></input></td>
                      <td><input type="month" class="form-control" name="items[1][MTD_month]" id="item-1-MTD_month" style="width: 180px; height:35px; "></input></td>
                      <td><input type="number" class="form-control" name="items[1][Contracted_prices]" id="item-1-Contracted_prices" style="width: 180px; height:35px; ""></input></td>
                      <!--<td><input type="text" class="form-control" name="items[1][spo]"  id="item-1-spo" style="width: 180px; height:35px; "/></input></td>-->
                      <td><input type="text" class="form-control" name="items[1][Discount_percentage]"  id="item-1-Discount_percentage" style="width: 180px; height:35px; "/></input></td> 
                      <td><input type="number" class="form-control" name="items[1][room_nights]" id="item-1-room_nights" style="width: 180px; height:35px; "/></input></td>
                      <td><input type="text" class="form-control" name="items[1][Materialization_occ]" id="item-1-Materialization_occ" style="width: 180px; height:35px; "/></input></td>
                      <td><input type="month" class="form-control" name="items[1][Materialization_month]" id="item-1-Materialization_month" style="width: 180px; height:35px; "/></input></td>
                  		<td>
                        <select id="item-1-currency" class="form-control" name="items[1][currency]" style="width: 100px; height:35px; ">
                      		<option>$</option>
                      		<option>EGP</option>
                       		<option>EURO</option>
                    		</select>
                  		</td>
                  		<td>
                    		<span data-item-id="1" class="form-actions btn btn-danger remove-item">Remove</span>
                  		</td>
        						</tr>
        					</tbody>
      					  <tfoot>
        						<tr>
          						<td colspan="10">
          						<td>
          							<span class="form-actions btn btn-primary" id="add-item">Add Item</span>
          						</td>
        						</tr>
      					  </tfoot>
				        </table>
				        <script type="text/javascript">
				          document.items = <?php echo json_encode($this->input->post('items')); ?>;
				        </script>
				        <table class="table table-striped table-bordered table-condensed" style="width: 80%;" >
    				      <tr>
                    <td colspan="5" style=" text-align: center;">Competition Survey</td>
                  </tr>
    				      <tr>
                    <td style=" text-align: center;">Hotel</td>
    					      <td style=" text-align: center;">Peroid</td>   
          					<td style=" text-align: center;">Price</td>
          					<td style=" text-align: center;">Peroid</td>
      					    <td style=" text-align: center;">Price</td>
					        </tr>
					        <?php for ($i=0; $i < 4 ; $i++) {?>
					          <tr>
  						        <td>
  						          <input type="text" class="form-control" id="from-hotel" style=" margin-top:22px;" name="competition[<?=$i?>][hotel]" />
						          </td>
  						        <td><input type="date" class="form-control" name="competition[<?=$i?>][from]" /><input type="date" class="form-control" style=" margin-top:5px;" name="competition[<?=$i?>][to]" /> </td>
          						<td><input type="number" class="form-control" style=" margin-top:25px;" name="competition[<?=$i?>][price]" /> </td>
          						<td><input type="date" class="form-control" name="competition[<?=$i?>][from2]" /><input type="date" class="form-control" style=" margin-top:5px;" name="competition[<?=$i?>][to2]" /> </td>
  						        <td><input type="number" class="form-control" style=" margin-top:25px;" name="competition[<?=$i?>][price2]" /> </td>
					          </tr>
					        <?php } ?>
				        </table>
                <div class="form-group col-lg-8 col-md-8 col-sm-8 col-xs-8">
                  <br>
                  <input type="hidden" name="assumed_id" value="<?php echo $assumed_id; ?>" />
                  <label for="offers" class="col-lg-3 col-md-4 col-sm-5 col-xs-5 control-label">Report Files</label>
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <input id="offers" name="upload" type="file" class="file" multiple="true" data-show-upload="false" data-show-caption="true">
                  </div>
                  <script>
                    $("#offers").fileinput({
                      uploadUrl: "/spo/upload/<?php echo $assumed_id; ?>",
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
                          {url: "/spo/remove/<?php echo $assumed_id ?>/<?php echo $upload['id'] ?>", key: "<?php echo $upload['name']; ?>"},
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
		<script id="item-template" type="text/x-handlebars-template">

  			<tr id="item-{{id}}">
  				<td>
  					<input type="date" class="form-control" style="width: 180px; height:35px; " name="items[{{id}}][peroid_from]" id="item-{{id}}-peroid_from" value="{{peroid_from}}"  />
  				</td>
   				<td>
   					<input type="date" class="form-control" style="width: 180px; height:35px; " name="items[{{id}}][peroid_to]" id="item-{{id}}-peroid_to" value="{{peroid_to}}"  /> 
   				</td>
  				<td>
  					<input type="text" class="form-control" style="width: 80px; height:35px; "" name="items[{{id}}][MTD_OCC]" id="item-{{id}}-MTD_OCC" value="{{MTD_OCC}}"  />
  				</td>
    			<td>
    				<input type="month" class="form-control" style="width: 180px; height:35px; "" name="items[{{id}}][MTD_month]" id="item-{{id}}-Materialization_occ" value="{{Materialization_occ}}"  /> 
    			</td>
  				<td>
  					<input type="number" class="form-control" style="width: 180px; height:35px; "" name="items[{{id}}][Contracted_prices]" id="item-{{id}}-Contracted_prices" value="{{Contracted_prices}}"  /> 
  				</td>
  				<!--<td >
  					<input type="text" class="form-control" style="width: 180px; height:35px; "" name="items[{{id}}][spo]" id="item-{{id}}-spo" value="{{spo}}"/>  
  				</td>-->
 				   <td>	
  					<input style="width: 180px; height:35px; " class="form-control" type="number" name="items[{{id}}][Discount_percentage]" id="item-{{id}}-Discount_percentage" value="{{Discount_percentage}}"  /> 
  				</td> 
  				<td>
  					<input type="number" class="form-control" style="width: 180px; height:35px; " name="items[{{id}}][room_nights]" id="item-{{id}}-room_nights" value="{{room_nights}}"  /> 
  				</td>
  				<td>
  					<input type="text" class="form-control" style="width: 180px; height:35px; " name="items[{{id}}][Materialization_occ]" id="item-{{id}}-Materialization_occ" value="{{Materialization_occ}}" /></input>
  				</td>
    			<td>
    				<input type="month" class="form-control" style="width: 180px; height:35px; " name="items[{{id}}][Materialization_month]"  id="item-{{id}}-Materialization_month" value="{{Materialization_month}}"  /> 
    			</td>
    			<td>
					<select id="item-{{id}}-currency" class="form-control" style="width: 100px; height:35px; " name="items[{{id}}][currency]">
						<option>$</option>
						<option>EGP</option>
						<option>EURO</option>
					</select>
				</td>
  				<td>
    				<span data-item-id="{{id}}" class="form-actions btn btn-danger remove-item">Remove</span>
  				</td>
  			</tr>
		</script>

</body>
</html>
