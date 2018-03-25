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
                  <h1 class="centered">Waiting Chairman Approval Contracts </h1>
                  <br>
                  <br>
                    <table class="table table-striped table-bordered table-condensed" style="margin-left: -70px; width: 950px !important; font-size: 15px;">
                    <tr>
                      <td colspan="1" rowspan="2" class="centered" style = "font-weight: bold;">ID#</td>
                      <td colspan="1" rowspan="2" class="centered" style = "font-weight: bold; width: 100px !important;">Hotel Name</td>
                      <td colspan="1" rowspan="2" class="centered" style = "font-weight: bold; width: 100px !important;">Service</td>
                      <td colspan="1" rowspan="2" class="centered" style = "font-weight: bold; width: 100px !important;">Brand</td>
                      <td colspan="1" rowspan="2" class="centered" style = "font-weight: bold; width: 100px !important;">Contractor Name</td>
                      <td colspan="2" rowspan="1" class="centered" style = "font-weight: bold; width: 200px !important;">Period</td>
                      <td colspan="1" rowspan="2" class="centered" style = "font-weight: bold; width: 50px !important;">Taxes</td>
                      <td colspan="1" rowspan="2" class="centered" style = "font-weight: bold; width: 50px !important;">Monthly Rent</td>
                      <td colspan="1" rowspan="2" class="centered" style = "font-weight: bold; width: 250px !important;">Others</td>
                    </tr>
                    <tr>
                      <td style = "font-weight: bold;">From</td>
                      <td style = "font-weight: bold;">To</td>
                    </tr>
                    <?php foreach ($contracts as $contract) { ?>
                    <tr>
                      <td class="centered"><?php echo $contract['id']?></td>  
                      <td class="centered"><?php echo $contract['hotel_name']?></td>  
                      <td class="centered"><?php echo $contract['service_name']?></td>  
                      <td class="centered"><?php echo $contract['brand']?></td>
                      <td class="centered"><?php echo $contract['name_en']?></td>  
                      <td class="centered"><?php echo $contract['from_date']?></td>
                      <td class="centered"><?php echo $contract['to_date']?></td>
                      <td class="centered"><?php echo $contract['taxes_per']?></td>
                      <td class="centered">
                        <?php if ($contract['hotel_id'] == 44) {
                          echo $contract['rent_mp'].' For Mamlouk Palace '. $contract['rent_gb'].' For Garden Beach ';
                        }else{
                          echo $contract['rent']?> <?php echo $contract['currency'];
                        } ?>
                      </td>
                      <td class="centered"><?php echo $contract['others']?></td>
                    </tr>
                    <?php } ?>
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
