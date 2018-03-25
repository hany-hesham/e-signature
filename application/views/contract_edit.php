<?php 
  function array_assoc_value_exists($arr, $index, $search) {
    foreach ($arr as $key => $value) {
      if ($value[$index] == $search) {
        return TRUE;
      }
    }
    return FALSE;
  }
?>
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
          <div class="a4page" dir="rtl" style="margin-bottom: 20px;">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px;">
              <div class="page-header">
                <h1 class="centered">عقد استغلال أماكن غير مجهزة </h1>
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
                  <table class="table table-striped table-bordered table-condensed" style="width: 730px;">
                    <tr class="centered">
                      <td colspan="2"  style="font-size:20px; width: 50px !important;"> &nbsp; &nbsp; </td>
                      <td colspan="2"  style="font-size:20px; width: 340px !important;"> عقد جديد </td>
                      <td colspan="2"  style="font-size:20px; width: 340px !important;"> عقد قديم </td>
                    </tr>
                    <tr>
                      <td colspan="2" style="font-size:20px;">
                        النشاط
                      </td>
                      <td colspan="4">
                        <select class="form-control chooosen" name="service_id" data-placeholder="اختار نوع النشاط ...">
                          <option value="<?php echo $contract['service_id']; ?>"><?php echo $contract['service_name']; ?></option>
                          <?php foreach ($services as $service): ?>
                            <option value="<?php echo $service['id'] ?>"<?php echo set_select('service_id',$service['id'] ); ?>><?php echo $service['name'] ?></option>
                          <?php endforeach ?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2" style="font-size:20px;">
                        اسم النشاط
                      </td>
                      <td colspan="4">
                        <input type="text" placeholder="اسم النشاط ..." name="brand" class="form-control" value="<?php echo $contract['brand']; ?>"></input>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2" style="font-size:20px;">
                        المدينة
                      </td>
                      <td class="wideField" colspan="4">
                        <div id="locationField">
                          <input id="autocomplete" readonly="readonly" class="form-control" placeholder="المدينة ..." onFocus="geolocate()" type="text" name="city" value="<?php echo $contract['city']; ?>"></input>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2" style="font-size:20px;">
                        الشركة المالكة
                      </td>
                      <td colspan="4">
                        <input type="text" readonly="readonly" class="form-control" value="<?php echo $contract['company_name']; ?>"></input>
                        <select class="form-control" name="company_id" data-placeholder="اختار شركة ..." style="width: 250px; display: none;">
                          <option value="<?php echo $contract['company_id']; ?>"><?php echo $contract['company_name']; ?></option>
                          <?php foreach ($companies as $company): ?>
                            <option value="<?php echo $company['id'] ?>"<?php echo set_select('company_id',$company['id'] ); ?>><?php echo $company['name'] ?></option>
                          <?php endforeach ?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2" style="font-size:20px;">
                        اسم الفندق
                      </td>
                      <td colspan=4>
                        <input type="text" readonly="readonly" class="form-control" value="<?php echo $contract['hotel_name']; ?>"></input>
                        <select class="form-control" name="hotel_id" data-placeholder="اسم الفندق ..."  style="width: 250px; display: none;">
                          <option value="<?php echo $contract['hotel_id']; ?>"><?php echo $contract['hotel_name']; ?></option>
                          <?php foreach ($hotels as $hotel): ?>
                            <option value="<?php echo $hotel['id'] ?>"<?php echo set_select('hotel_id',$hotel['id'] ); ?>><?php echo $hotel['name'] ?></option>
                          <?php endforeach ?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td colspan=2 style="font-size:20px;">
                        المستأجر
                      </td>
                      <td colspan=2>
                        <input type="text" placeholder="اسم المستأجر ..." name="name" class="form-control" value="<?php echo $contract['name']; ?>"></input>
                      </td>
                      <td colspan=2>
                        <input type="text" placeholder="اسم المستأجر ..." name="name_old" class="form-control" value="<?php echo $contract['name_old']; ?>"></input>
                      </td>
                    </tr>
                    <tr>
                      <td colspan=2 style="font-size:20px;">
                        اسم المستأجر بالانجليزية
                      </td>
                      <td colspan=2>
                        <input type="text" placeholder="Contractor Name ..." name="name_en" class="form-control" value="<?php echo $contract['name_en']; ?>"></input>
                      </td>
                      <td colspan=2>
                        <input type="text" placeholder="Contractor Name ..." name="name_en_old" class="form-control" value="<?php echo $contract['name_en_old']; ?>"></input>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2" style="font-size:20px;">
                        عنوان المستأجر
                      </td>
                      <td colspan="2">
                        <input type="text" placeholder="عنوان المستأجر ..." name="address" class="form-control" value="<?php echo $contract['address']; ?>"></input>
                      </td>
                      <td colspan="2">
                        <input type="text" placeholder="عنوان المستأجر ..." name="address_old" class="form-control" value="<?php echo $contract['address_old']; ?>"></input>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2" style="font-size:20px;">
                        رقم البطاقة الضريبة
                      </td>
                      <td colspan="2">
                        <input type="text" class="form-control" placeholder="رقم البطاقة الضريبة ..." name="taxes" id="taxes" value="<?php echo $contract['taxes']; ?>"/>
                      </td>
                      <td colspan="2">
                        <input type="text" class="form-control" placeholder="رقم البطاقة الضريبة ..." name="taxes_old" id="taxes" value="<?php echo $contract['taxes_old']; ?>"/>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2" style="font-size:20px;">
                        رقم البطاقة الشخصية 
                      </td>
                      <td colspan="2">
                        <input type="text" class="form-control" placeholder="رقم البطاقة الشخصية ..." name="idp" id="idp" value="<?php echo $contract['idp']; ?>"/>
                      </td>
                      <td colspan="2">
                        <input type="text" class="form-control" placeholder="رقم البطاقة الشخصية ..." name="idp_old" id="idp" value="<?php echo $contract['idp_old']; ?>"/>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2" style="font-size:20px;">
                        رقم السجل التجاري 
                      </td>
                      <td colspan="2">
                        <input type="text" class="form-control" placeholder="رقم السجل التجاري ..." name="licenss" id="licenss" value="<?php echo $contract['licenss']; ?>"/>
                      </td>
                      <td colspan="2">
                        <input type="text" class="form-control" placeholder="رقم السجل التجاري ..." name="licenss_old" id="licenss" value="<?php echo $contract['licenss_old']; ?>"/>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2" style="font-size:20px;">
                        تاريخ بداية التعاقد 
                      </td>
                      <td colspan="2">
                        <div class='input-group date' id='datetimepicker1' dir="ltr" style="width: 250px;">
                          <input type="text" name="start_date" class="form-control" placeholder="التاريخ ..." dir="rtl" value="<?php echo $contract['start_date']; ?>" /> 
                          <span class="input-group-addon"><span class="glyphicon glyphicon-calender"></span></span>
                        </div>
                      </td>
                      <td colspan="2">
                        <div class='input-group date' id='datetimepicker2' dir="ltr" style="width: 250px;">
                          <input type="text" name="start_date_old" class="form-control" placeholder="التاريخ ..." dir="rtl" value="<?php echo $contract['start_date_old']; ?>"/>
                          <span class="input-group-addon"><span class="glyphicon glyphicon-calender"></span></span>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td rowspan="2" colspan="1" style="font-size:20px;">
                        المدة
                      </td>
                      <td colspan="1" style="font-size:20px;">
                        من 
                      </td>
                      <td colspan="2">
                        <div class='input-group date' id='datetimepicker3' dir="ltr" style="width: 250px;">
                          <input type="text" name="from_date" class="form-control" placeholder="التاريخ ..." dir="rtl" value="<?php echo $contract['from_date']; ?>" /> 
                          <span class="input-group-addon"><span class="glyphicon glyphicon-calender"></span></span>
                        </div>
                      </td>
                      <td colspan="2">
                        <div class='input-group date' id='datetimepicker4' dir="ltr" style="width: 250px;">
                          <input type="text" name="from_date_old" class="form-control" placeholder="التاريخ ..." dir="rtl" value="<?php echo $contract['from_date_old']; ?>"/>
                          <span class="input-group-addon"><span class="glyphicon glyphicon-calender"></span></span>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="1" style="font-size:20px;">
                        إلى
                      </td>
                      <td colspan="2">
                        <div class='input-group date' id='datetimepicker5' dir="ltr" style="width: 250px;">
                          <input type="text" name="to_date" class="form-control" placeholder="التاريخ ..." dir="rtl" value="<?php echo $contract['to_date']; ?>" /> 
                          <span class="input-group-addon"><span class="glyphicon glyphicon-calender"></span></span>
                        </div>
                      </td>
                      <td colspan="2">
                        <div class='input-group date' id='datetimepicker6' dir="ltr" style="width: 250px;">
                          <input type="text" name="to_date_old" class="form-control" placeholder="التاريخ ..." dir="rtl" value="<?php echo $contract['to_date_old']; ?>"/> 
                          <span class="input-group-addon"><span class="glyphicon glyphicon-calender"></span></span>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2" style="font-size:20px;">
                        مقدار الضريبة
                      </td>
                      <td colspan="2">
                        <input type="number" class="form-control" name="taxes_per" placeholder="النسبة ..." value="<?php echo $contract['taxes_per']; ?>" style="width: 250px;"/>%
                      </td>
                      <td colspan="2">
                        <input type="number" class="form-control" name="taxes_per_old" placeholder="النسبة ..." value="<?php echo $contract['taxes_per_old']; ?>" style="width: 250px;"/>%
                      </td>
                    </tr>
                    <?php if ($contract['hotel_id'] != 44) { ?>
                      <tr>
                        <td rowspan="2" colspan="1" style="font-size:20px;">
                          القيمة الإيجارية 
                        </td>
                        <td colspan="1" style="font-size:20px;">
                          القيمة
                        </td>
                        <td colspan="2">
                          <input type="number" class="form-control" name="rent" placeholder="القيمة ..." value="<?php echo $contract['rent']; ?>" style="width: 250px;"/>
                        </td>
                        <td colspan="2">
                        <input type="number" class="form-control" name="rent_old" placeholder="القيمة ..." value="<?php echo $contract['rent_old']; ?>" style="width: 250px;"/>
                      </td>
                      </tr>
                      <tr>
                        <td colspan="1" style="font-size:20px;">
                          العملة
                        </td>
                        <td colspan="2" style="font-size:20px;">
                          <select class="form-control" name="currency" data-placeholder="العملة ..." style="width: 250px;">
                            <option value="<?php echo $contract['currency']; ?>"><?php echo $contract['currency']; ?></option>
                            <option value="£">£</option> ‎
                            <option value="$">$</option> 
                            <option value="EURO">EURO</option>
                            <option value="EGP">EGP</option>
                          </select>
                        </td>
                        <td colspan="2" style="font-size:20px;">
                        <select class="form-control" name="currency_old" data-placeholder="العملة ..." style="width: 250px;">
                          <option value="<?php echo $contract['currency_old']; ?>"><?php echo $contract['currency_old']; ?></option>
                          <option value="£">£</option> ‎
                          <option value="$">$</option> 
                          <option value="EURO">EURO</option>
                          <option value="EGP">EGP</option>
                        </select>
                      </td>
                      </tr>
                    <?php }else{ ?>
                      <tr>
                        <td rowspan="2" colspan="1" style="font-size:20px;">
                          القيمة الإيجارية لفندق Mamlouk Palace
                        </td>
                        <td colspan="1" style="font-size:20px;">
                          القيمة
                        </td>
                        <td colspan="2">
                          <input type="number" class="form-control" name="rent_mp" value="<?php echo $contract['rent_mp']; ?>" placeholder="القيمة ..." style="width: 250px;"/>
                        </td>
                        <td colspan="2">
                        <input type="number" class="form-control" name="rent_mp_old" value="<?php echo $contract['rent_mp_old']; ?>" placeholder="القيمة ..." style="width: 250px;"/>
                      </td>
                      </tr>
                      <tr>
                        <td colspan="1" style="font-size:20px;">
                          العملة
                        </td>
                        <td colspan="2">
                          <select class="form-control" name="currency_mp" data-placeholder="العملة ..." style="width: 250px;">
                            <option value="<?php echo $contract['currency_mp']; ?>"><?php echo $contract['currency_mp']; ?></option>
                            <option value="£">£</option> ‎
                            <option value="$">$</option> 
                            <option value="EURO">EURO</option>
                            <option value="EGP">EGP</option>
                          </select>
                        </td>
                        <td colspan="2">
                          <select class="form-control" name="currency_mp_old" data-placeholder="العملة ..." style="width: 250px;">
                            <option value="<?php echo $contract['currency_mp_old']; ?>"><?php echo $contract['currency_mp_old']; ?></option>
                            <option value="£">£</option> ‎
                            <option value="$">$</option> 
                            <option value="EURO">EURO</option>
                            <option value="EGP">EGP</option>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td rowspan="2" colspan="1" style="font-size:20px;">
                          القيمة الإيجارية لفندق Garden Beach
                        </td>
                        <td colspan="1" style="font-size:20px;">
                          القيمة
                        </td>
                        <td colspan="2">
                          <input type="number" class="form-control" name="rent_gb" value="<?php echo $contract['rent_gb']; ?>" placeholder="القيمة ..." style="width: 250px;"/>
                        </td>
                        <td colspan="2">
                          <input type="number" class="form-control" name="rent_gb_old" value="<?php echo $contract['rent_gb_old']; ?>" placeholder="القيمة ..." style="width: 250px;"/>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="1" style="font-size:20px;">
                          العملة
                        </td>
                        <td colspan="2">
                          <select class="form-control" name="currency_gb" data-placeholder="العملة ..." style="width: 250px;">
                            <option value="<?php echo $contract['currency_gb']; ?>"><?php echo $contract['currency_gb']; ?></option>
                            <option value="£">£</option> ‎
                            <option value="$">$</option> 
                            <option value="EURO">EURO</option>
                            <option value="EGP">EGP</option>
                          </select>
                        </td>
                        <td colspan="2">
                          <select class="form-control" name="currency_gb_old" data-placeholder="العملة ..." style="width: 250px;">
                            <option value="<?php echo $contract['currency_gb_old']; ?>"><?php echo $contract['currency_gb_old']; ?></option>
                            <option value="£">£</option> ‎
                            <option value="$">$</option> 
                            <option value="EURO">EURO</option>
                            <option value="EGP">EGP</option>
                          </select>
                        </td>
                      </tr>
                    <?php } ?>
                    <?php if ($contract['hotel_id'] != 44) { ?>
                      <tr>
                        <td rowspan="2" colspan="1" style="font-size:20px;">
                          القيمة التأمينية
                        </td>
                        <td colspan="1" style="font-size:20px;">
                          القيمة
                        </td>
                        <td colspan="2">
                          <input type="number" class="form-control" name="safty" value="<?php echo $contract['safty']; ?>" placeholder="القيمة ..." style="width: 250px;"/>
                        </td>
                        <td colspan="2">
                        <input type="number" class="form-control" name="safty_old" value="<?php echo $contract['safty_old']; ?>" placeholder="القيمة ..." style="width: 250px;"/>
                      </td>
                      </tr>
                      <tr>
                        <td colspan="1" style="font-size:20px;">
                          العملة
                        </td>
                        <td colspan="2">
                          <select class="form-control" name="currency1" data-placeholder="العملة ..." style="width: 250px;">
                            <option value="<?php echo $contract['currency1']; ?>"><?php echo $contract['currency1']; ?></option>
                            <option value="£">£</option> ‎
                            <option value="$">$</option> 
                            <option value="EURO">EURO</option>
                            <option value="EGP">EGP</option>
                          </select>
                        </td>
                        <td colspan="2">
                        <select class="form-control" name="currency1_old" data-placeholder="العملة ..." style="width: 250px;">
                          <option value="<?php echo $contract['currency1_old']; ?>"><?php echo $contract['currency1_old']; ?></option>
                          <option value="£">£</option> ‎
                          <option value="$">$</option> 
                          <option value="EURO">EURO</option>
                          <option value="EGP">EGP</option>
                        </select>
                      </td>
                      </tr>
                    <?php }else{ ?>
                      <tr>
                        <td rowspan="2" colspan="1" style="font-size:20px;">
                          القيمة التأمينية لفندق Mamlouk Palace
                        </td>
                        <td colspan="1" style="font-size:20px;">
                          القيمة
                        </td>
                        <td colspan="2">
                          <input type="number" class="form-control" name="safty_mp" value="<?php echo $contract['safty_mp']; ?>" placeholder="القيمة ..." style="width: 250px;"/>
                        </td>
                        <td colspan="2">
                        <input type="number" class="form-control" name="safty_mp_old" value="<?php echo $contract['safty_mp_old']; ?>" placeholder="القيمة ..." style="width: 250px;"/>
                      </td>
                      </tr>
                      <tr>
                        <td colspan="1" style="font-size:20px;">
                          العملة
                        </td>
                        <td colspan="2">
                          <select class="form-control" name="currency1_mp" data-placeholder="العملة ..." style="width: 250px;">
                            <option value="<?php echo $contract['currency1_mp']; ?>"><?php echo $contract['currency1_mp']; ?></option>
                            <option value="£">£</option> ‎
                            <option value="$">$</option> 
                            <option value="EURO">EURO</option>
                            <option value="EGP">EGP</option>
                          </select>
                        </td>
                        <td colspan="2">
                          <select class="form-control" name="currency1_mp_old" data-placeholder="العملة ..." style="width: 250px;">
                            <option value="<?php echo $contract['currency1_mp_old']; ?>"><?php echo $contract['currency1_mp_old']; ?></option>
                            <option value="£">£</option> ‎
                            <option value="$">$</option> 
                            <option value="EURO">EURO</option>
                            <option value="EGP">EGP</option>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td rowspan="2" colspan="1" style="font-size:20px;">
                          القيمة التأمينية لفندق Garden Beach
                        </td>
                        <td colspan="1" style="font-size:20px;">
                          القيمة
                        </td>
                        <td colspan="2">
                          <input type="number" class="form-control" name="safty_gb" value="<?php echo $contract['safty_gb']; ?>" placeholder="القيمة ..." style="width: 250px;"/>
                        </td>
                        <td colspan="2">
                          <input type="number" class="form-control" name="safty_gb_old" value="<?php echo $contract['safty_gb_old']; ?>" placeholder="القيمة ..." style="width: 250px;"/>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="1" style="font-size:20px;">
                          العملة
                        </td>
                        <td colspan="2">
                          <select class="form-control" name="currency1_gb" data-placeholder="العملة ..." style="width: 250px;">
                            <option value="<?php echo $contract['currency1_gb']; ?>"><?php echo $contract['currency1_gb']; ?></option>
                            <option value="£">£</option> ‎
                            <option value="$">$</option> 
                            <option value="EURO">EURO</option>
                            <option value="EGP">EGP</option>
                          </select>
                        </td>
                        <td colspan="2">
                          <select class="form-control" name="currency1_gb_old" data-placeholder="العملة ..." style="width: 250px;">
                            <option value="<?php echo $contract['currency1_gb_old']; ?>"><?php echo $contract['currency1_gb_old']; ?></option>
                            <option value="£">£</option> ‎
                            <option value="$">$</option> 
                            <option value="EURO">EURO</option>
                            <option value="EGP">EGP</option>
                          </select>
                        </td>
                      </tr>
                    <?php } ?>
                    <?php if ($contract['hotel_id'] != 44) { ?>
                      <tr>
                        <td rowspan="2" colspan="1" style="font-size:20px;">
                          مبلغ التعويض
                        </td>
                        <td colspan="1" style="font-size:20px;">
                          القيمة 
                        </td>
                        <td colspan="2">
                          <input type="number" class="form-control" name="compensation" value="<?php echo $contract['compensation']; ?>" placeholder="القيمة ..." style="width: 250px;"/>
                        </td>
                        <td colspan="2">
                          <input type="number" class="form-control" name="compensation_old" value="<?php echo $contract['compensation_old']; ?>" placeholder="القيمة ..." style="width: 250px;"/>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="1" style="font-size:20px;">
                          العملة
                        </td>
                        <td colspan="2">
                          <select class="form-control" name="currency2" data-placeholder="العملة ..." style="width: 250px;">
                            <option value="<?php echo $contract['currency2']; ?>"><?php echo $contract['currency2']; ?></option>
                            <option value="£">£</option> ‎
                            <option value="$">$</option> 
                            <option value="EURO">EURO</option>
                            <option value="EGP">EGP</option>
                          </select>
                        </td>
                        <td colspan="2">
                        <select class="form-control" name="currency2_old" data-placeholder="العملة ..." style="width: 250px;">
                          <option value="<?php echo $contract['currency2_old']; ?>"><?php echo $contract['currency2_old']; ?></option>
                          <option value="£">£</option> ‎
                          <option value="$">$</option> 
                          <option value="EURO">EURO</option>
                          <option value="EGP">EGP</option>
                        </select>
                      </td>
                      </tr>
                    <?php }else{ ?>
                      <tr>
                        <td rowspan="2" colspan="1" style="font-size:20px;">
                          مبلغ التعويض لفندق Mamlouk Palace
                        </td>
                        <td colspan="1" style="font-size:20px;">
                          القيمة 
                        </td>
                        <td colspan="2">
                          <input type="number" class="form-control" name="compensation_mp" value="<?php echo $contract['compensation_mp']; ?>" placeholder="القيمة ..." style="width: 250px;"/>
                        </td>
                        <td colspan="2">
                        <input type="number" class="form-control" name="compensation_mp_old" value="<?php echo $contract['compensation_mp_old']; ?>" placeholder="القيمة ..." style="width: 250px;"/>
                      </td>
                      </tr>
                      <tr>
                        <td colspan="1" style="font-size:20px;">
                          العملة
                        </td>
                        <td colspan="2">
                          <select class="form-control" name="currency2_mp" data-placeholder="العملة ..." style="width: 250px;">
                            <option value="<?php echo $contract['currency2_mp']; ?>"><?php echo $contract['currency2_mp']; ?></option>
                            <option value="£">£</option> ‎
                            <option value="$">$</option> 
                            <option value="EURO">EURO</option>
                            <option value="EGP">EGP</option>
                          </select>
                        </td>
                        <td colspan="2">
                          <select class="form-control" name="currency2_mp_old" data-placeholder="العملة ..." style="width: 250px;">
                            <option value="<?php echo $contract['currency2_mp_old']; ?>"><?php echo $contract['currency2_mp_old']; ?></option>
                            <option value="£">£</option> ‎
                            <option value="$">$</option> 
                            <option value="EURO">EURO</option>
                            <option value="EGP">EGP</option>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td rowspan="2" colspan="1" style="font-size:20px;">
                          مبلغ التعويض لفندق Garden Beach
                        </td>
                        <td colspan="1" style="font-size:20px;">
                          القيمة 
                        </td>
                        <td colspan="2">
                          <input type="number" class="form-control" name="compensation_gb" value="<?php echo $contract['compensation_gb']; ?>" placeholder="القيمة ..." style="width: 250px;"/>
                        </td>
                        <td colspan="2">
                        <input type="number" class="form-control" name="compensation_gb_old" value="<?php echo $contract['compensation_gb_old']; ?>" placeholder="القيمة ..." style="width: 250px;"/>
                      </td>
                      </tr>
                      <tr>
                        <td colspan="1" style="font-size:20px;">
                          العملة
                        </td>
                        <td colspan="2">
                          <select class="form-control" name="currency2_gb" data-placeholder="العملة ..." style="width: 250px;">
                            <option value="<?php echo $contract['currency2_gb']; ?>"><?php echo $contract['currency2_gb']; ?></option>
                            <option value="£">£</option> ‎
                            <option value="$">$</option> 
                            <option value="EURO">EURO</option>
                            <option value="EGP">EGP</option>
                          </select>
                        </td>
                        <td colspan="2">
                          <select class="form-control" name="currency2_gb_old" data-placeholder="العملة ..." style="width: 250px;">
                            <option value="<?php echo $contract['currency2_gb_old']; ?>"><?php echo $contract['currency2_gb_old']; ?></option>
                            <option value="£">£</option> ‎
                            <option value="$">$</option> 
                            <option value="EURO">EURO</option>
                            <option value="EGP">EGP</option>
                          </select>
                        </td>
                      </tr>
                    <?php } ?>
                    <tr>
                      <td colspan="2" style="font-size:20px;">
                        أيام العمل
                      </td>
                      <td colspan="4">
                        <select class="form-control chooosen" name="week[]" id="week" multiple="multiple" data-placeholder="اختار أيام العمل...">
                          <?php foreach ($weeks as $week): ?>
                            <option value="<?php echo $week['id'] ?>" <?php echo (array_assoc_value_exists($days, 'week_id', $week['id']))? 'selected="selected"' : set_select('week[]',$week['id'] ); ?>><?php echo $week['name'] ?></option>
                          <?php endforeach ?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2" style="font-size:20px;">
                        مقدار الزيادة السنوية
                      </td>
                      <td colspan="4">
                        <input type="text" class="form-control" name="increase" placeholder="مقدار الزيادة ..." value="<?php echo $contract['increase']; ?>">%</input>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2" style="font-size:20px;">
                        تكاليف الكهرباء 
                      </td>
                      <td colspan="4">
                      <?php if ($contract['elec_choice'] != 3) {?>
                        <select class="form-control" name="elec_choice" id="elec_choice" data-placeholder="الكهرباء ..." style="display: block">
                          <option value="<?php echo $contract['elec_choice'];?>"><?php echo $contract['elec_choice'];?></option>
                          <option value="لا يوجد">لا يوجد</option> ‎
                          <option value="عداد">عداد</option> 
                          <option value="3">مبلغ ثابت شهرى</option> 
                        </select>
                        <div id='electricity' style="display: none">
                          <input type="text" name="electricity" class="form-control" placeholder="مقدار التعاقد ..." value="<?php echo $contract['electricity']; ?>" /> 
                          <select class="form-control" name="currency3" data-placeholder="العمله ..." >
                            <option value="<?php echo $contract['currency3']; ?>"><?php echo $contract['currency3']; ?></option>
                            <option value="£">£</option> ‎
                            <option value="$">$</option> 
                            <option value="EURO">EURO</option>
                            <option value="EGP">EGP</option>
                          </select> 
                        </div>
                      <?php }else{ ?>
                        <div>
                          <select class="form-control" name="elec_choice" id="elec_choice" data-placeholder="الكهرباء ..." style="display: none">
                            <option value="<?php echo $contract['elec_choice'];?>"><?php echo $contract['elec_choice'];?></option>
                            <option value="لا يوجد">لا يوجد</option> ‎
                            <option value="عداد">عداد</option> 
                            <option value="3">مبلغ ثابت شهرى</option> 
                          </select>
                          <input type="text" name="electricity" class="form-control" placeholder="مقدار التعاقد ..." value="<?php echo $contract['electricity']; ?>" /> 
                          <select class="form-control" name="currency3" data-placeholder="العمله ..." >
                            <option value="<?php echo $contract['currency3']; ?>"><?php echo $contract['currency3']; ?></option>
                            <option value="£">£</option> ‎
                            <option value="$">$</option> 
                            <option value="EURO">EURO</option>
                            <option value="EGP">EGP</option>
                          </select> 
                        </div>
                      <?php } ?>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2" style="font-size:20px;">
                        توصيف المكان 
                      </td>
                      <td colspan="4">
                        <input type="text" class="form-control" name="location" placeholder="توصيف المكان ..." value="<?php echo $contract['location']; ?>"></input>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2" style="font-size:20px;">
                        توصيف النشاط  
                      </td>
                      <td colspan="4">
                        <input type="text" class="form-control" name="activity" placeholder="توصيف النشاط ..." value="<?php echo $contract['activity']; ?>"></input>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2" style="font-size:20px;">
                        اى بيانات اخرى يريد الفندق إضافتها  
                      </td>
                      <td colspan="2">
                        <textarea type="text" name="others" class="form-control" rows="3" placeholder="إضافات ..."><?php echo $contract['others']; ?></textarea>
                      </td>
                      <td colspan="2">
                        <textarea type="text" name="others_old" class="form-control" rows="3" placeholder="إضافات ..."><?php echo $contract['others_old']; ?></textarea>
                      </td>
                    </tr>
                  </table>
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12" style="width: 70% !important; margin-left: 32% !important;">
                    <br>
                    <input type="hidden" name="contr_id" value="<?php echo $contract['id']; ?>" />
                    <label for="offers" style="font-size:20px;">ملفات إضافية</label>
                      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <input id="offers" name="upload" type="file" class="file" multiple="true" data-show-upload="true" data-show-caption="true">
                      </div>
                      <script>
                      $("#offers").fileinput({
                          uploadUrl: "/contract/upload/<?php echo $contract['id'] ?>", 
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
                            <?php if ($is_admin): ?>
                              {url: "/contract/remove/<?php echo $contract['id'] ?>/<?php echo $upload['id'] ?>", key: "<?php echo $upload['name']; ?>"},
                            <?php endif ?>
                          <?php endforeach; ?>
                          ],
                      });
                      </script>
                  </div>
                </div>
                <div class="form-group" style="margin-right: 300px;">
                  <input name="submit" value="Submit" type="submit" class="btn btn-success" />
                  <a href="<?= base_url(); ?>contract/view/<?php echo $contract['id']; ?>" class="btn btn-warning">Cancel</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script>
      var placeSearch, autocomplete;
      var componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
        country: 'long_name',
        postal_code: 'short_name'
      };
      function initAutocomplete() {
        autocomplete = new google.maps.places.Autocomplete(
          (document.getElementById('autocomplete')),
        {types: ['geocode']});
        autocomplete.addListener('place_changed', fillInAddress);
      }
      function fillInAddress() {
        var place = autocomplete.getPlace();
        for (var component in componentForm) {
          document.getElementById(component).value = '';
          document.getElementById(component).disabled = false;
        }
        for (var i = 0; i < place.address_components.length; i++) {
          var addressType = place.address_components[i].types[0];
          if (componentForm[addressType]) {
            var val = place.address_components[i][componentForm[addressType]];
            document.getElementById(addressType).value = val;
          }
        }
      }
      function geolocate() {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var geolocation = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
            var circle = new google.maps.Circle({
              center: geolocation,
              radius: position.coords.accuracy
            });
            autocomplete.setBounds(circle.getBounds());
          });
        }
      }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCrVzyM3qt7rBomJojJ6kq2ZHwxAHGV_m4&libraries=places&callback=initAutocomplete" async defer></script>
    <script type="text/javascript">
      var inputs = document.getElementById('electricity');
      var select = document.getElementById('elec_choice');
      select.addEventListener('change', function () {
        if (select.value == '3') {
          inputs.style.display = 'block';
          select.style.display = 'none';
        } else {
          inputs.style.display = 'none';
          select.style.display = 'block';
        }
      });
    </script> 
    <script type="text/javascript">
      $(function(){
        $('#datetimepicker1').datetimepicker({
          viewMode:'days',
          format:'YYYY-MM-DD'
        });
      });
    </script>
    <script type="text/javascript">
      $(function(){
        $('#datetimepicker2').datetimepicker({
          viewMode:'days',
          format:'YYYY-MM-DD'
        });
      });
    </script>
    <script type="text/javascript">
      $(function(){
        $('#datetimepicker3').datetimepicker({
          viewMode:'days',
          format:'YYYY-MM-DD'
        });
      });
    </script>
    <script type="text/javascript">
      $(function(){
        $('#datetimepicker4').datetimepicker({
          viewMode:'days',
          format:'YYYY-MM-DD'
        });
      });
    </script> 
    <script type="text/javascript">
      $(function(){
        $('#datetimepicker5').datetimepicker({
          viewMode:'days',
          format:'YYYY-MM-DD'
        });
      });
    </script> 
    <script type="text/javascript">
      $(function(){
        $('#datetimepicker6').datetimepicker({
          viewMode:'days',
          format:'YYYY-MM-DD'
        });
      });
    </script> 
  </body>
</html>
