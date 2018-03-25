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
                <div class="a4page">
                  <div>
                      <div class="page-header">
                    <button onclick="window.print()" class="non-printable form-actions btn btn-success" href="">Print</button>
                  <div class="header-logo"><img src="/assets/uploads/logos/45081-sr-s.png" /></div>
                  <h1 class="centered">Waiting Approval SPO Forms From Chairman</h1>
                  <br>
                  <br>
                    <table class="table table-striped table-bordered table-condensed" style="margin-left: -70px; width: 950px !important; font-size: 15px;">
                    <tr>
                      <td colspan="1" rowspan="2" class="centered" style = "font-weight: bold;">SPO Form ID#</td>
                      <td colspan="1" rowspan="2" class="centered" style = "font-weight: bold;">Hotel Name</td>
                      <td colspan="2" rowspan="1" class="centered" style = "font-weight: bold;">Period</td>
                      <td colspan="2" rowspan="1" class="centered" style = "font-weight: bold;" >Occupancy MTD </td>
                      <td colspan="1" rowspan="2" class="centered" style = "font-weight: bold;">contracted  <br />Rate </td>
                      <td colspan="1" rowspan="2" class="centered" style = "font-weight: bold;">SPO </td>
                      <td colspan="1" rowspan="2" class="centered" style = "font-weight: bold;">Discount <br />Persantage <br /> %</td>
                      <td colspan="1" rowspan="2" class="centered" style = "font-weight: bold;">Room Nights </td>
                      <td colspan="2" rowspan="1" class="centered" style = "font-weight: bold;">Matreialization </td>
                      <td colspan="1" rowspan="2" class="centered" style = "font-weight: bold;">Currency</td>
                    </tr>
                    <tr>
                      <td style = "font-weight: bold;">From</td>
                      <td style = "font-weight: bold;">To</td>
                      <td style = "font-weight: bold;">Occ%</td>
                      <td style = "font-weight: bold;">Month</td>
                      <td style = "font-weight: bold;">Occ%</td>
                      <td style = "font-weight: bold;">Month</td>
                    </tr>
                    <?php foreach ($get_spo_items as $item) { ?>
                    <tr>
                      <td class="centered"><?php echo $item['spo_id']?></td>  
                      <td class="centered"><?php echo $item['hotel_name']?></td>  
                      <td class="centered"><?php echo $item['peroid_from']?></td>  
                      <td class="centered"><?php echo $item['peroid_to']?></td>
                      <td class="centered"><?php echo $item['MTD_OCC']?></td>  
                      <td class="centered"><?php echo $item['MTD_month']?></td>
                      <td class="centered"><?php echo $item['Contracted_prices']?></td>
                      <td class="centered"><?php echo $item['spo']?></td>
                      <td class="centered"><?php echo $item['Discount_percentage']?></td>
                      <td class="centered"><?php echo $item['room_nights']?></td>
                      <td class="centered"><?php echo $item['Materialization_occ']?></td>  
                      <td class="centered"><?php echo $item['Materialization_month']?></td>
                      <td class="centered"><?php echo $item['currency'] ?></td>
                    </tr>
                    <?php $_SESSTION['currency'] = $item['currency']; } ?>
                  </table>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 centered">
                <div class="signature-wrapper">
                            <div class="data-head relative">
                              Chairman Approval
                            </div>
                            <div class="data-content" style="margin-top: 30px;">
                              <span class="name-data-content"></span>
                              <br />
                              <span class="timestamp-data-content"></span>
                            </div>
                        </div>
              </div>
      </div>
      </div>
      </div>
    </div>
  </div>
    <script type="text/javascript">
      function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
      }
    </script>
  </body>
</html>
