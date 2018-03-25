<!DOCTYPE html>
<html lang="en">
    <head>
      <?php $this->load->view('header'); ?>
      <style>
        @media print {
          .hany{
            margin-left: -90px !important;
          }
          @page { 
            margin: 0.5cm; 
          }
          body { 
            margin: 1.6cm; 
          }
        }
      </style>
    </head>
    <body>
      <div id="wrapper">
          <?php $this->load->view('menu') ?>
          <div id="page-wrapper">
            <div class="a4wrapper">
                <div class="a4page ">
                  <div>
                      <div class="page-header">
                    <button onclick="window.print()" class="non-printable form-actions btn btn-success" href="">Print</button>
                  <div class="header-logo centered hany"><img src="/assets/uploads/logos/<?php echo $hotel['logo'] ?>" /></div>
                  <h1 class="centered hany"><?php echo $hotel['name'] ?> </h1>
                  <h3 class="centered hany">Waiting Chairman Approval Movment Assets </h3>
                    <br>
                    <br>
                    <table class="table table-striped table-bordered table-condensed" style="margin-left: -100px; width: 1000px !important; font-size: 16px;">
                    <tr>
                      <td class="centered" style = "font-weight: bold; width: 50px;">Form ID#</td>
                      <td class="centered" style = "font-weight: bold; width: 100px;">Item Name</td>
                      <td class="centered" style = "font-weight: bold; width: 50px;">Quantity</td>
                      <td class="centered" style = "font-weight: bold; width: 100px;">From Hotel</td>
                      <td class="centered" style = "font-weight: bold; width: 100px;">To Hotel</td>
                      <td class="centered" style = "font-weight: bold; width: 100px;">Dep. Requested</td>
                      <td class="centered" style = "font-weight: bold; width: 100px;">Issue Date</td>
                      <td class="centered" style = "font-weight: bold; width: 100px;">Delivered Date</td>
                      <td class="centered" style = "font-weight: bold; width: 150px;">Reason For Movement</td>
                      <td class="centered" style = "font-weight: bold; width: 150px;">What Will Happen To Old Item After Movement</td>
                    </tr>
                    <?php foreach ($forms as $form) { ?>
                      <?php foreach ($form['items'] as $item) { ?>
                        <tr>
                          <td class="centered"><?php echo $form['id']?></td>  
                          <td class="centered"><?php echo $item['name']?></td>  
                          <td class="centered"><?php echo $item['quantity']?></td>  
                          <td class="centered"><?php echo $form['from_hotel']?></td>  
                          <td class="centered"><?php echo $form['to_hotel']?></td>
                          <td class="centered"><?php echo $form['department_name']?></td>
                          <td class="centered"><?php echo $form['issue_date']?></td>
                          <td class="centered"><?php echo $form['delivery_date']?></td>
                          <td class="centered"><?php echo $form['movement_reason']?></td>
                          <td class="centered"><?php echo $form['old_reason']?></td>
                        </tr>
                      <?php } ?>
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
