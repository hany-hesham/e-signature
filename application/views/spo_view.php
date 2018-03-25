<!DOCTYPE html>
<html lang="en">
  <head>
    <?php $this->load->view('header');?>
    <style type="text/css">
      table {
        border-color: #000000  !important;
        border-style: solid   !important;
      }
    </style>
    <style>
      @media print {

        .data-catcher{
          height: 140px !important;
        }

        .header-logo>img{
          width: 80px;
          height: 40px;
        }

        .header-logo>h3{
          font-size:10px;
          font-weight: bold;
        }

        .data-head>h3{
          font-size:10px;
        }

        h1{
          font-size:18px;
          font-weight: bold;
        }

        td{
          font-size: 12px !important;
        }

        .signature-wrapper{
          height: 70px;
          width: 140px;
        }

        .data-head {
          font-size:10px;
        }

        .data-content>img{
          height: 15px;
          width: 30px;
        }

        .timestamp-data-content{
          font-size: 10px;
        }

        .data-content{
          font-size: 10px;
        }

        table {
          height: 100px !important;
        }

        .print_button{
          display: none;
        }
      }
</style>
  </head>
  <body>
    <div id="container">
      <?php $this->load->view('menu'); ?>
        <div id="page-wrapper">
          <div  class="a4wrapper">
            <div>
              <div>
                <button onclick="window.print()" class="non-printable form-actions btn btn-success" href="" >Print</button>
                <div class="page-header">
                <?php if ($is_editor): ?>
              <a class="form-actions btn btn-info non-printable" href="/spo/edit/<?php echo $spo_contents['id'] ?>" style="float:right;" > Edit </a>
              <?php endif ?>
              <a class="form-actions btn btn-info non-printable" href="/spo/mailme/<?php echo $spo_contents['id'] ?>" style="float:left; margin-left: 20px;" > <img src="/assets/images/letter.png" style="width: 28px; height: 40px; margin: 0px; margin-left: -10px; margin-top: -10px; margin-bottom: -10px;"> Share by Email </a>
                <a data-text="whatsapp" data-link="<?php echo base_url(); ?>spo/view/<?php echo $spo_contents['id'] ?>" style="float:left; margin-left: 20px;" class="whatsapp whatsapp_btn whatsapp_btn_small form-actions btn btn-success non-printable"> <img src="/assets/images/original.png" style="width: 70px; height: 50px; margin: -20px; margin-left: -30px; margin-top: -21px;"> Share by Whatsapp</a>
                  <div class="header-logo"><img src="/assets/uploads/logos/<?php echo $spo_contents['logo'] ?>" />
                  <h1 class="centered"><?php echo $spo_contents['hotel_name']?></h1>
                  <h3 class="centered">
                      SPO Request Form No. #<?php echo $spo_contents['id']; ?>
                    </h3>
                  <table class="table-striped" style = "font-size:16px; border: 5px solid bold  !important; border-top: 1px solid bold !important; width: 795px;">
                    <tr>
                      <td style = "font-size: 18px; font-weight: bold;">Date </td>  
                      <td><?php echo $spo_contents['date']?> </td>
                    </tr>
                    <tr>
                      <td style = "font-size: 18px; font-weight: bold;">Season </td> 
                      <td><?php echo $spo_contents['season']?> </td>
                    </tr>
                    <tr>
                      <td style = "font-size: 18px; font-weight: bold;">Travel Period  </td>  
                      <td><?php echo $spo_contents['Travel_Date']?>|<?php echo $spo_contents['Travel_Date2']?> </td>
                    </tr>
                    <tr>
                      <td style = "font-size: 18px; font-weight: bold;">Booking Window </td>  
                      <td><?php echo $spo_contents['Booking_Window']?>|<?php echo $spo_contents['Booking_Window2']?> </td>
                    </tr>
                    <tr>
                      <td style = "font-size: 18px; font-weight: bold;">Arrival Date </td>  
                      <td><?php echo $spo_contents['arrival_date']?>|<?php echo $spo_contents['arrival_date2']?>|<?php echo $spo_contents['arrival_date3']?>|<?php echo $spo_contents['arrival_date4']?>|<?php echo $spo_contents['arrival_date5']?> </td>
                    </tr>
                    <tr>
                      <td style = "font-size: 18px; font-weight: bold;">To </td>  
                      <td><?php echo $spo_contents['to']?> </td>
                    </tr>
                    <tr>
                      <td style = "font-size: 18px; font-weight: bold;">Hotel </td>  
                      <td><?php echo $spo_contents['hotel_name']?> </td>
                    </tr>
                  </table>
                  <br class="demo">
                  <table class="table-striped" style = "font-size:16px; border: 5px solid bold  !important; border-top: 1px solid bold !important; width: 795px;">
                    <tr>
                      <td colspan="2" rowspan="1" class="centered" style = "font-size: 18px; font-weight: bold;">Period</td>
                      <td colspan="2" rowspan="1" class="centered" style = "font-size: 18px; font-weight: bold;" >Occupancy MTD </td>
                      <td colspan="1" rowspan="2" class="centered" style = "font-size: 18px; font-weight: bold;">contracted  <br />Rate </td>
                      <td colspan="1" rowspan="2" class="centered" style = "width:20px font-size: 18px; font-weight: bold;">SPO </td>
                      <td colspan="1" rowspan="2" class="centered" style = "font-size: 18px; font-weight: bold;">Discount <br />Persantage <br /> %</td>
                      <td colspan="1" rowspan="2" class="centered" style = "width:20px font-size: 18px; font-weight: bold;">Room Nights </td>
                      <td colspan="2" rowspan="1" class="centered" style = "font-size: 18px; font-weight: bold;">Matreialization </td>
                      <td colspan="1" rowspan="2" class="centered" style = "width:20px; font-size: 18px; font-weight: bold;">Currency</td>
                    </tr>
                    <tr>
                      <td style = "font-size: 18px; font-weight: bold;">From</td>
                      <td style = "font-size: 18px; font-weight: bold;">To</td>
                      <td style = "font-size: 18px; font-weight: bold;">Occ%</td>
                      <td style = "font-size: 18px; font-weight: bold;">Month</td>
                      <td style = "font-size: 18px; font-weight: bold;">Occ%</td>
                      <td style = "font-size: 18px; font-weight: bold;">Month</td>
                    </tr>
                    <?php foreach ($get_spo_items as $item) { ?>
                    <tr>
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
                  <br class="demo">
                  <table class="table-striped" style = "font-size:16px; border: 5px solid bold  !important; border-top: 1px solid bold !important; width: 795px;">
                    <tr>
                      <td colspan="7" style = "font-size: 18px; font-weight: bold;">Competition Survey</td>
                    </tr>
                    <tr>
                      <td style = "font-size: 18px; font-weight: bold;">Hotel</td>
                      <td colspan="2" style = "font-size: 18px; font-weight: bold;">Peroid</td>   
                      <td style = "font-size: 18px; font-weight: bold;">Price</td>
                      <td colspan="2" style = "font-size: 18px; font-weight: bold;">Peroid</td>
                      <td style = "font-size: 18px; font-weight: bold;">Price</td>
                    </tr>
                    <?php foreach ($get_spo_Competition as $item) { ?>
                    <tr>
                      <td>
                        <span> <?php echo $item['hotel']?> </span> 
                      </td>
                      <td colspan="2">
                        <span><?php echo $item['from']?>  </span> TO <span> <?php echo $item['to']?> </span>
                      </td>
                      <td>
                        <span><?php echo $item['price'].$_SESSTION['currency']?></span> 
                      </td>
                      <td colspan="2">
                        <span><?=$item['from2']?></span> TO <span><?=$item['to2']?></span>
                      </td>
                      <td >
                        <span><?php echo $item['price2'].$_SESSTION['currency']?> </span>
                      </td>
                    </tr>
                    <?php }
                      unset($_SESSTION['currency']); ?>
                  </table>
              </div>
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher data-indention non-printable">
                              <label for="offers" class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label" style="font-size:20px; font-weight:bold;">Report Files:</label>
                  <div class="form-group col-lg-9 col-md-8 col-sm-7 col-xs-7">
                                <?php foreach($uploads as $upload): ?>
                                  <p><a href='/assets/uploads/files/<?php echo $upload['name'] ?>'><?php echo $upload['name'] ?></a> Uploaded by <?php echo $upload['user_name'] ?></p>
                                <?php endforeach ?>     
                              </div>  
                            </div>
                 
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher centered">
                <?php $queue_first = TRUE; ?>
                <?php foreach ($signers as $signe_id => $signer): ?>
                <div class="signature-wrapper">
                  <div class="data-head relative"><?php echo (strlen($signer['role']) == 0)? "Spo Owner" : $signer['role'] ?>
                    <span class="expander-container"><i class='glyphicon glyphicon-envelope'></i></span>
                    <div class="expander-wrapper">
                      <span class="expander-remover"><i class='glyphicon glyphicon-remove'></i></span>
                      <div class="expander">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-holder">
                          <div class="row">
                            <form action="/spo/<?php if($signer['role_id'] == "1"){ 
                                echo "share_url";
                              }else{
                                echo "mailto";
                              } ?>/<?php echo $spo_contents['id']; ?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
                              <?php if (isset($signer['sign'])): ?>
                              <?php $i=1; ?>
                              <input checked="checked" type="radio" name="mail" value="<?php echo $signer['sign']['mail'] ?>" /><label>To: <?php echo $signer['sign']['name'] ?></label>
                              <?php else: ?>
                              <?php $i=0; foreach ($signer['queue'] as $id => $signe): ?>
                              <input <?php echo (++$i == 1)? 'checked="checked"' : '' ?> type="radio" name="mail" value="<?php echo $signe['mail'] ?>" id="u<?php echo $id ?>" /><label for="u<?php echo $id ?>">To: <?php echo $signe['name'] ?></label><br />
                              <?php endforeach ?>
                              <?php endif; ?>
                              <?php if (isset($i) && $i == 0): ?>
                              <span>No users available</span>
                              <?php else: ?>
                              <?php if($signer['role_id'] != "1"){ ?>
                                <textarea class="form-control" name="message" id="message"></textarea>
                              <?php } ?>
                              <input name="submit" value="Send" type="submit" class="inverse-offset btn btn-success" />
                              <?php endif; ?>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php if (isset($signer['sign'])): ?>
                  <div class="data-content"><img src="
                                <?php if(isset($signer['sign']['reject'])){ 
                                  echo $signature_path.'rejected.png';
                                }else {
                                  if ($signer['sign']['id'] == 217) {
                                    echo $signature_path.'9f3a8-mr.-hossam.jpg';
                                  }else{
                                    echo $signature_path.'approved.png';
                                  }
                                }?>
                              " alt="<?php echo $signer['sign']['name']; ?>" class="img-rounded sign-image">
                    <?php if (($signer['sign']['id'] == $user_id && $unsign_enable) || $is_admin): ?>
                    <a href="/spo/unsign/<?php echo $signe_id; ?>" class="non-printable btn btn-primary unsign">Cancel</a>
                    <?php endif ?>
                  </div>
                  <div class="data-content"><span class="name-data-content"><?php echo $signer['sign']['name']; ?></span>
                  <br /><span class="timestamp-data-content"><?php echo $signer['sign']['timestamp']; ?></span></div>
                  <?php elseif (array_key_exists($user_id, $signer['queue']) && $queue_first): ?>
                  <?php $queue_first = FALSE; ?>
                  <div class="data-content non-printable"><span class="data-label sign-data-content"></span><a href="/spo/sign/<?php echo $signe_id; ?>/reject" class="btn btn-danger">Reject</a><a href="/spo/sign/<?php echo $signe_id; ?>" class="btn btn-success">sign</a></div>
                  <?php else: ?>
                  <?php $queue_first = FALSE; ?>
                  <?php endif ?>
                </div>
                <?php if (isset($signer['sign']['reject'])){break;}?>
                <?php endforeach ?>
              </div>
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher non-printable">
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <form action="/spo/comment/<?php echo $spo_contents['id']?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                     <textarea class="form-control" name="comment" id="comment"></textarea>
                    </div>
                    <input name="spo_id" value="<?php echo $spo_contents['id']?>" type="hidden" />
                    <input name="submit" value="Comment" type="submit" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-actions btn btn-success " />
                  </form>
                </div>
              </div>
              <br>
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-holder">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher">
                  <div class="data-head centered"> 
                    <h3>Comments</h3> 
                  </div>
                  <div class="data-holder">
                    <?php foreach($GetComment as $qury ){ ?>
                    <div class="data-holder">
                      <span class="data-head"><?php echo $qury['fullname']; ?> :- </span><?php echo $qury['comment']; ?>
                      <span class="timestamp-data-content"><?php echo $qury['created'];?></span>
                    </div>
                    <?php } ?>
                  </div>
                </div>  
              </div>
            </div>        
          </div>
        </div>
      </div>
      </div>
      </div>
      <script type="text/javascript">
        $(".expander-container").on("click", function(){
          $(".expander-wrapper").hide();
          $(this).parent().find(".expander-wrapper").toggle("fast");
         });
          $(".expander-remover").on("click", function(){
            $(this).parent().hide("fast");
          });
      </script>
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
    <script type="text/javascript">
        $(document).ready(function() {
            $(document).on("click",'.whatsapp',function() {
            if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
                  var text = $(this).attr("data-text");
                  var url = $(this).attr("data-link");
                  var message = encodeURIComponent(text)+" - "+encodeURIComponent(url);
                  var whatsapp_url = "whatsapp://send?text="+message;
                  window.location.href= whatsapp_url;
            } else {
                alert("Please share this post in your mobile device");
            }
            });
        });
      </script>
  </body>
  </body>
</html>
