<!DOCTYPE html>
<html lang="en">
  <head>
    <?php $this->load->view('header'); ?>
  </head>
  <body>
    <div style="position: relative; float: right; width: 420px;" class="non-printable">
      <p style="text-align: right; font-family: Calibri;">
        السادة الزملاء /
 
        من واقع إيمانا العميق بضرورة التطوير و التعليم و بث روح الفريق و إبراز أهمية دور التدريب و ضرورة المعايشة من أجل بناء طاهي عصري ليكون لديه المعرفة الأساسية لأهمية  دورقسم الإسيتوارد من حيث دوره الهام في الحفاظ علي مباديء الصحة العامة و كذلك سلامة و صحة الغذاء و لذلك نري طبقا لما تم شرحه من قبل في برنامج التدرج المهني الوظيفي الفندقي لصن رايز.
                 
        أنه في حالة الإحتياج لتعيين وظيفة طاهي ثالث يتم النظر أولا إلي القسم الإستيوارد  داخل الفندق  أولا أو في فنادق الشركة  عن طريق التشييك مع مديري موارد البشرية في الفنادق عن طريق عمل برنامج تدريبي لمن أمضي ستة أشهر لحد أدني في قسم الإستيوارد و يكون البرنامج التدريبي الخاص به لمدة ستة أشهر يتم متابعته و تقييمه عن طريق الشيف العمومي شخصيا بمعرفة مدير التعليم و التطوير و مدير الموارد البشرية
                 
        و في حالة تعيينه من خارج الشركة, بعد التأكد بعدم وجود  موظف مؤهل للعمل في الوظيفة في فنادق الشركة  يكون سبق له العمل في نفس الوظيفة قبل تعيينه بستة أشهر علي الأقل خبرة في المطبخ و يكون من خريجي المدارس و المعاهد الفندقية قسم مطبخ.
      </p>
      <p style="text-align: left; font-family: Calibri;">
        It is with our deepest belief of the necessity for promoting Learning and Development concept, and fostering to build a team spirit, highlighting the importance of the training’s role and the utmost importance to promote a modernized chef who possesses the most knowledgeable skills for the important role of the stewarding department, with respect to maintaining the basic principles of health & food safety procedures. Therefore, we have reviewed the above mentioned enlightenment in accordance to the “SUNRISE Career Path Program” awareness.
                 
        Should there be a necessity to hire a third Commis chef, then to refer back to the stewarding department first within the hotel or through sister hotels  by undertaking check references by Human Resources Manager of the hotels undertaking cross trainings for employees who have served minimum six months in the stewarding position, the cross training is to be based on six months, scrutinized and evaluated by the Executive Chef, Learning & Development Manager and the Human Resources Manager.
                 
        In case of hiring from outsourced employees, this is to be implemented after having checked carefully that there is no available qualified employees to practice the position throughout the sister hotels. Possessing qualified experience in the same position is very much essential as to be  six months at least prior hiring into the kitchen department and have been graduated from hospitality & tourism schools or institutions, kitchen department.
      </p>
    </div>
    <div id="wrapper" style="position: relative; float: left;">
      <?php $this->load->view('menu') ?>
      <div id="page-wrapper">
        <div class="a4wrapper">
          <div class="a4page">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px;">
              <div class="page-header">
                <h1 class="centered"> Hiring Position Request </h1>
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
                    <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label" style="margin-top:5px;"> Hotel Name </label>
                    <select class="form-control" name="hotel_id" id="from-hotel " style="width:240px; height:40px;">
                      <option data-company="0" value="">Select Hotel..</option>
                      <?php foreach ($hotels as $hotel): ?>
                        <option value="<?php echo $hotel['id'] ?>"<?php echo set_select('hotel_id',$hotel['id'] ); ?>><?php echo $hotel['name'] ?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label" style="margin-top:5px;"> Date </label>
                    <div class='input-group date' id='datetimepicker1' style=" width: 240px;">
                      <input type='text' class="form-control" name="date"/>
                      <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                  </div>
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <table class="table table-striped table-bordered table-condensed" style="width: 700px;">
                      <thead>
                        <tr>
                          <th rowspan="2" colspan="1" style=" text-align: center;">Requested Positions</th>
                          <th rowspan="1" colspan="3" style=" text-align: center;">Salary Scale</th>
                          <th rowspan="2" colspan="1" style=" text-align: center;">Level</th>
                          <th rowspan="2" colspan="1" style=" text-align: center;">actoins</th>
                        </tr>
                        <tr>
                          <th rowspan="1" colspan="1" style=" text-align: center;">Min</th>
                          <th rowspan="1" colspan="1" style=" text-align: center;">Avarge</th>
                          <th rowspan="1" colspan="1" style=" text-align: center;">Max</th>
                        </tr>
                      </thead>
                      <tbody id="items-container" data-items="1">
                        <tr id="item-1">
                          <td class="centered"> 
                            <input type="text" class="form-control" name="requests[1][position]"  id="item-1-position" style="width: 200px;"/></input>
                          </td>
                          <td class="centered" style="width: 120px;"> 
                            <input type="text" class="form-control" name="requests[1][froms]"  id="item-1-from"/></input>
                          </td>
                          <td class="centered" style="width: 120px;"> 
                            <input type="text" class="form-control" name="requests[1][avrg]"  id="item-1-to"/></input>
                          </td>
                          <td class="centered" style="width: 120px;"> 
                            <input type="text" class="form-control" name="requests[1][tos]"  id="item-1-to"/></input>
                          </td>
                          <td class="centered" style="width: 80px;"> 
                            <input type="text" class="form-control" name="requests[1][level]"  id="item-1-level"/></input>
                          </td>
                          <td class="centered">
                            <span data-item-id="1" class="form-actions btn btn-danger remove-item" style="width: 100px;">Remove</span>
                          </td>
                        </tr>
                      </tbody>
                      <tfoot>
                        <tr>
                          <td colspan="5"></td>
                          <td class="centered">
                            <span class="form-actions btn btn-primary" id="add-item" style="width: 100px;">Add Position</span>
                          </td>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>
                <div class="col-lg-offset-3 col-lg-10 col-md-10 col-md-offset-3">
                  <br>
                  <br>
                  <input name="submit" value="Submit" type="submit" class="btn btn-success"/>
                  <a href="<?= base_url(); ?>position" class="btn btn-warning">Cancel</a>
                  <br>
                  <br>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script type="text/javascript">
      document.items = <?php echo json_encode($this->input->post('requests')); ?>;
    </script>
    <script id="item-template" type="text/x-handlebars-template">
      <tr id="item-{{id}}">
        <td class="centered">
          <input type="text" class="form-control" name="requests[{{id}}][position]"  id="item-{{id}}-position" style="width: 200px;"/></input>
        </td>
        <td class="centered" style="width: 120px;"> 
          <input type="text" class="form-control" name="requests[{{id}}][froms]"  id="item-{{id}}-from"/></input>
        </td>
        <td class="centered" style="width: 120px;"> 
          <input type="text" class="form-control" name="requests[{{id}}][avrg]"  id="item-{{id}}-to"/></input>
        </td>
        <td class="centered" style="width: 120px;"> 
          <input type="text" class="form-control" name="requests[{{id}}][tos]"  id="item-{{id}}-to"/></input>
        </td>
        <td class="centered" style="width: 80px;"> 
          <input type="text" class="form-control" name="requests[{{id}}][level]"  id="item-{{id}}-level"/></input>
        </td>
        <td class="centered">
          <span data-item-id="{{id}}" class="form-actions btn btn-danger remove-item" style="width: 100px;">Remove</span>
        </td>
      </tr>
    </script>
    <script type="text/javascript">
      $(function(){
        $('#datetimepicker1').datetimepicker({
          viewMode:'days',
          format:'DD/MM/YYYY'
        });
      });
    </script>
  </body>
</html>
