<!DOCTYPE html>
<html lang="en">
  <head>
    <?php $this->load->view('header'); ?>
  </head>
  <body>
    <div id="wrapper">
      <?php $this->load->view('menu') ?>
      <div id="page-wrapper">
        <div class="">
          <div class="" style="margin-bottom: 10px;">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px;">
              <div class="page-header">
                <h1 class="centered">Signature Policy (لائحة التوقيعات)</h1>
              </div>
              <?php if(validation_errors() != false): ?>
                <div class="alert alert-danger">
                  <?php echo validation_errors(); ?>
                </div>
              <?php endif ?>         
            </div>
            <div class="container">
              <form action="" method="POST" id="form-submit" enctype="multipart/form-data" class="form-div span12" accept-charset="utf-8">
                  <table class="table table-striped table-bordered table-condensed">
                      <tr>
                        <td colspan="1" style=" text-align: center; background-color: black; color: white;">Description</td>
                        <td colspan="1" style=" text-align: center; color: gray;">First Signature</td>
                        <td colspan="1" style=" text-align: center; color: gray;">Second Signature</td>
                        <td colspan="1" style=" text-align: center; color: gray;">Third Signature</td>
                        <td colspan="1" style=" text-align: center; color: gray;">Fourth Signature</td>
                        <td colspan="1" style=" text-align: center; color: gray;">Fifth Signature</td>
                        <td colspan="1" style=" text-align: center; color: gray;">Sixth Signature</td>
                        <td colspan="1" style=" text-align: center; color: gray;">Seventh Signature</td>
                      </tr>
                    <tbody>
                      <?php foreach ($departments as $department): ?>
                        <tr>
                          <td colspan="9" class="centered" style="background-color: gray; color: white;">
                            <?php echo $department['name']?>
                          </td>
                        </tr>
                        <?php foreach ($department['types'] as $type): ?>
                          <tr>
                            <td class="centered" style="display: none;"> 
                              <input type="number" class="form-control" name="items[<?php echo $type['id']?>][type_id]" value="<?php echo $type['id']?>" /></input>
                            </td>
                            <td class="" style="background-color: black; color: white;"> 
                              <?php echo $type['name']?>
                            </td>
                            <td class="centered"> 
                                <select class="form-control chooosen" name="items[<?php echo $type['id']?>][first]" style="width: 160px; height:34px;" data-placeholder="Select Role ...">
                                  <option data-company="0" value="">Select Role ...</option>
                                  <?php foreach ($roles as $role): ?>
                                    <option value="<?php echo $role['id'] ?>"<?php echo set_select('first',$role['id'] ); ?>><?php echo $role['role'] ?></option>
                                  <?php endforeach ?>
                                </select>
                            </td>
                            <td class="centered"> 
                              <select class="form-control chooosen" name="items[<?php echo $type['id']?>][second]" style="width: 160px; height:34px;" data-placeholder="Select Role ...">
                                  <option data-company="0" value="">Select Role ...</option>
                                  <?php foreach ($roles as $role): ?>
                                    <option value="<?php echo $role['id'] ?>"<?php echo set_select('second',$role['id'] ); ?>><?php echo $role['role'] ?></option>
                                  <?php endforeach ?>
                                </select>
                            </td>
                            <td class="centered"> 
                              <select class="form-control chooosen" name="items[<?php echo $type['id']?>][third]" style="width: 160px; height:34px;" data-placeholder="Select Role ...">
                                  <option data-company="0" value="">Select Role ...</option>
                                  <?php foreach ($roles as $role): ?>
                                    <option value="<?php echo $role['id'] ?>"<?php echo set_select('third',$role['id'] ); ?>><?php echo $role['role'] ?></option>
                                  <?php endforeach ?>
                                </select>
                            </td>
                            <td class="centered"> 
                              <select class="form-control chooosen" name="items[<?php echo $type['id']?>][fourth]" style="width: 160px; height:34px;" data-placeholder="Select Role ...">
                                  <option data-company="0" value="">Select Role ...</option>
                                  <?php foreach ($roles as $role): ?>
                                    <option value="<?php echo $role['id'] ?>"<?php echo set_select('fourth',$role['id'] ); ?>><?php echo $role['role'] ?></option>
                                  <?php endforeach ?>
                                </select>
                            </td>
                            <td class="centered"> 
                              <select class="form-control chooosen" name="items[<?php echo $type['id']?>][fifth]" style="width: 160px; height:34px;" data-placeholder="Select Role ...">
                                  <option data-company="0" value="">Select Role ...</option>
                                  <?php foreach ($roles as $role): ?>
                                    <option value="<?php echo $role['id'] ?>"<?php echo set_select('fifth',$role['id'] ); ?>><?php echo $role['role'] ?></option>
                                  <?php endforeach ?>
                                </select>
                            </td>
                            <td class="centered"> 
                              <select class="form-control chooosen" name="items[<?php echo $type['id']?>][sixth]" style="width: 160px; height:34px;" data-placeholder="Select Role ...">
                                  <option data-company="0" value="">Select Role ...</option>
                                  <?php foreach ($roles as $role): ?>
                                    <option value="<?php echo $role['id'] ?>"<?php echo set_select('sixth',$role['id'] ); ?>><?php echo $role['role'] ?></option>
                                  <?php endforeach ?>
                                </select>
                            </td>
                            <td class="centered"> 
                              <select class="form-control chooosen" name="items[<?php echo $type['id']?>][seventh]" style="width: 160px; height:34px;" data-placeholder="Select Role ...">
                                  <option data-company="0" value="">Select Role ...</option>
                                  <?php foreach ($roles as $role): ?>
                                    <option value="<?php echo $role['id'] ?>"<?php echo set_select('seventh',$role['id'] ); ?>><?php echo $role['role'] ?></option>
                                  <?php endforeach ?>
                                </select>
                            </td>
                          </tr>
                        <?php endforeach ?>
                      <?php endforeach ?>
                    </tbody>
                  </table>    
                </div>
                <div style="    margin-top: 90px;" class="form-group">
                  <div class="col-lg-offset-3 col-lg-10 col-md-10 col-md-offset-3">
                    <br>
                    <br>
                    <br>
                    <input name="submit" value="Submit" type="submit" class="btn btn-success" />
                    <a href="<?= base_url(); ?>madar_policy/" class="btn btn-warning">Cancel</a>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body> 
  <script type="text/javascript">
    document.items = <?php echo json_encode($this->input->post('items')); ?>;
  </script>
</html>