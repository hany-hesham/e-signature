<!DOCTYPE html>
<html lang="en">
  <head>
    <?php $this->load->view('header'); ?>
<style type="text/css">
#iframee{
    width:420px;
    height:720px;
    border:0px solid #000; 
    overflow:hidden;
}
#iframee iframe {
    width:420px;
    height:1320px;
    margin-top:-500px;   
    border:0 solid;
 }
 #iframee1{
    width:420px;
    height:720px;
    border:0px solid #000; 
    overflow:hidden;
}
#iframee1 iframe {
    width:420px;
    height:1320px;
    margin-top:-500px;   
    border:0 solid;
 }
 #iframee2{
    width:420px;
    height:720px;
    border:0px solid #000; 
    overflow:hidden;
}
#iframee2 iframe {
    width:420px;
    height:1320px;
    margin-top:-500px;   
    border:0 solid;
 }
</style>
  </head>
  <body>
    <div id="wrapper">
      <?php $this->load->view('menu') ?>
      <div id="page-wrapper centered">
        <div class="a4wrapper" style="margin-left: 150px;">
          <div class="a4page" >
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px;">
              <div class="page-header">
                <h1 class="centered"> Daily Exchange Rate </h1>
              </div>
              <?php if(validation_errors() != false): ?>
                <div class="alert alert-danger">
                  <?php echo validation_errors(); ?>
                </div>
              <?php endif ?>         
            </div>
            <div class="container">
              <form action="" method="POST" id="form-submit" enctype="multipart/form-data" class="form-div span12" accept-charset="utf-8">           
                <div class="col-md-8">
                  <table class="table table-striped table-bordered table-condensed">
                  <thead>
                              <tr>
                                <th colspan="2" rowspan="3" style=" text-align: center;">ID#</th>
                                <th colspan="1" rowspan="3" style=" text-align: center;">Bank</th>
                                <th colspan="3" rowspan="1" style=" text-align: center;">Currency</th>
                              </tr>
                              <tr>
                                <th rowspan="1" style=" text-align: center;"><?php echo $exchange['currency']; ?></th>
                                <th colspan="1" rowspan="2" style=" text-align: center;">Amount</th>
                              </tr>
                              <tr>
                                <th rowspan="1" style=" text-align: center;">Manual Rate</th>
                              </tr>
                  </thead>
                  <tbody id="items-container" data-items="1">
                  <?php foreach($banks as $bank){?>
                    <tr id="bank-<?php echo $bank['id'];?>">
                          <td style="text-align:center; width: 60px; text-align: center;"><input type="radio" class="form-control" name="banks[<?php echo $bank['id'];?>][chek]" id="bank-[<?php echo $bank['id'];?>]-chek" value="<?php echo $bank['id'];?>"><?php echo $bank['id'];?></td>
                          <td style="text-align:center; width: 60px; text-align: center;"><input type="radio" checked class="form-control" name="banks[<?php echo $bank['id'];?>][bankid]" id="bank-[<?php echo $bank['id'];?>]-bankid" value="<?php echo $bank['id'];?>"><?php echo $bank['id'];?></td>
                      <td>
                        <?php echo $bank['bank'];?>
                      </td>
                      <td>
                        <input type="text" class="form-control" name="banks[<?php echo $bank['id'];?>][rate]" id="bank[<?php echo $bank['id'];?>]-rate" value="" />
                      </td>
                      <td>
                        <input type="text" class="form-control" name="banks[<?php echo $bank['id'];?>][amount]" id="bank-[<?php echo $bank['id'];?>]-amount" value=""/>
                      </td>
                    </tr>
                  <?php } ?>
                  </tbody>
                </table>
                </div>
                <?php if ($exchange['currency']=="$") {?>
                  <div class="col-md-1">
                    <div id="iframee" style="height: 2300px;">
                      <iframe src="https://eldolar.live/USD" scrolling="yes" style="height: 2300px;"></iframe>
                    </div>
                  </div>             
                <?php  }elseif ($exchange['currency']=="EURO"){?>
                  <div class="col-md-1">
                    <div id="iframee1" style="height: 2300px;">
                      <iframe src="https://eldolar.live/EUR" scrolling="yes" style="height: 2300px;"></iframe>
                    </div>
                  </div> 
                <?php  }elseif ($exchange['currency']=="£"){?>
                  <div class="col-md-1">
                    <div id="iframee2" style="height: 2300px;">
                      <iframe src="https://eldolar.live/GBP" scrolling="yes" style="height: 2300px;"></iframe>
                    </div>
                  </div> 
                <?php }?>
                <div style="    margin-top: 90px;" class="form-group">
                  <div class="col-lg-offset-3 col-lg-10 col-md-10 col-md-offset-3">
                    <br>
                    <br>
                    <input name="submit" value="Submit" type="submit" class="btn btn-success" />
                    <a href="<?= base_url(); ?>exchange" class="btn btn-warning">Cancel</a>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script type="text/javascript">
      $(function () {
          $('#datetimepicker1').datetimepicker();
      });
    </script>
  </body>
</html>
