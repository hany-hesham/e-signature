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
                <h1 class="centered">Edit Signature Policy (لائحة التوقيعات) NO. <?php echo $core['id'] ?></h1>
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
                        <td colspan="1" style=" text-align: center; color: gray;">Eighth Signature</td>
                        <td colspan="1" style=" text-align: center; color: gray;">Ninth Signature</td>
                      </tr>
                    <tbody>
                      <?php foreach ($departments as $department): ?>
                        <tr>
                          <td colspan="10" class="centered" style="background-color: gray; color: white;">
                            <?php echo $department['name']?>
                          </td>
                        </tr>
                        <?php foreach ($department['types'] as $type): ?>
                          <tr>
                            <td class="centered" style="display: none;"> 
                              <input type="number" class="form-control" name="items[<?php echo $type['id']?>][id]" value="<?php echo $type['policy']['id']?>" /></input>
                            </td>
                            <td class="centered" style="display: none;"> 
                              <input type="number" class="form-control" name="items[<?php echo $type['id']?>][type_id]" value="<?php echo $type['policy']['type_id']?>" /></input>
                            </td>
                            <td class="" style="background-color: black; color: white;"> 
                              <?php echo $type['name']?>
                            </td>
                            <td class="centered"> 
                                <select class="form-control chooosen" name="items[<?php echo $type['id']?>][first]" style="width: 160px; height:34px;" data-placeholder="Select Role ...">
                                  <option data-company="0" value="<?php echo $type['policy']['first']?>"><?php echo $type['policy']['role_first']?></option>
                                  <option data-company="0" value="">Select Role ...</option>
                                  <?php foreach ($roles as $role): ?>
                                    <option value="<?php echo $role['id'] ?>"<?php echo set_select('first',$role['id'] ); ?>><?php echo $role['role'] ?></option>
                                  <?php endforeach ?>
                                </select>
                            </td>
                            <td class="centered"> 
                              <select class="form-control chooosen" name="items[<?php echo $type['id']?>][second]" style="width: 160px; height:34px;" data-placeholder="Select Role ...">
                                  <option data-company="0" value="<?php echo $type['policy']['second']?>"><?php echo $type['policy']['role_second']?></option>
                                  <option data-company="0" value="">Select Role ...</option>
                                  <?php foreach ($roles as $role): ?>
                                    <option value="<?php echo $role['id'] ?>"<?php echo set_select('second',$role['id'] ); ?>><?php echo $role['role'] ?></option>
                                  <?php endforeach ?>
                                </select>
                            </td>
                            <td class="centered"> 
                              <select class="form-control chooosen" name="items[<?php echo $type['id']?>][third]" style="width: 160px; height:34px;" data-placeholder="Select Role ...">
                                  <option data-company="0" value="<?php echo $type['policy']['third']?>"><?php echo $type['policy']['role_third']?></option>
                                  <option data-company="0" value="">Select Role ...</option>
                                  <?php foreach ($roles as $role): ?>
                                    <option value="<?php echo $role['id'] ?>"<?php echo set_select('third',$role['id'] ); ?>><?php echo $role['role'] ?></option>
                                  <?php endforeach ?>
                                </select>
                            </td>
                            <td class="centered"> 
                              <select class="form-control chooosen" name="items[<?php echo $type['id']?>][fourth]" style="width: 160px; height:34px;" data-placeholder="Select Role ...">
                                  <option data-company="0" value="<?php echo $type['policy']['fourth']?>"><?php echo $type['policy']['role_fourth']?></option>
                                  <option data-company="0" value="">Select Role ...</option>
                                  <?php foreach ($roles as $role): ?>
                                    <option value="<?php echo $role['id'] ?>"<?php echo set_select('fourth',$role['id'] ); ?>><?php echo $role['role'] ?></option>
                                  <?php endforeach ?>
                                </select>
                            </td>
                            <td class="centered"> 
                              <select class="form-control chooosen" name="items[<?php echo $type['id']?>][fifth]" style="width: 160px; height:34px;" data-placeholder="Select Role ...">
                                  <option data-company="0" value="<?php echo $type['policy']['fifth']?>"><?php echo $type['policy']['role_fifth']?></option>
                                  <option data-company="0" value="">Select Role ...</option>
                                  <?php foreach ($roles as $role): ?>
                                    <option value="<?php echo $role['id'] ?>"<?php echo set_select('fifth',$role['id'] ); ?>><?php echo $role['role'] ?></option>
                                  <?php endforeach ?>
                                </select>
                            </td>
                            <td class="centered"> 
                              <select class="form-control chooosen" name="items[<?php echo $type['id']?>][sixth]" style="width: 160px; height:34px;" data-placeholder="Select Role ...">
                                  <option data-company="0" value="<?php echo $type['policy']['sixth']?>"><?php echo $type['policy']['role_sixth']?></option>
                                  <option data-company="0" value="">Select Role ...</option>
                                  <?php foreach ($roles as $role): ?>
                                    <option value="<?php echo $role['id'] ?>"<?php echo set_select('sixth',$role['id'] ); ?>><?php echo $role['role'] ?></option>
                                  <?php endforeach ?>
                                </select>
                            </td>
                            <td class="centered"> 
                              <select class="form-control chooosen" name="items[<?php echo $type['id']?>][seventh]" style="width: 160px; height:34px;" data-placeholder="Select Role ...">
                                  <option data-company="0" value="<?php echo $type['policy']['seventh']?>"><?php echo $type['policy']['role_seventh']?></option>
                                  <option data-company="0" value="">Select Role ...</option>
                                  <?php foreach ($roles as $role): ?>
                                    <option value="<?php echo $role['id'] ?>"<?php echo set_select('seventh',$role['id'] ); ?>><?php echo $role['role'] ?></option>
                                  <?php endforeach ?>
                                </select>
                            </td>
                            <td class="centered"> 
                              <select class="form-control chooosen" name="items[<?php echo $type['id']?>][eighth]" style="width: 160px; height:34px;" data-placeholder="Select Role ...">
                                  <option data-company="0" value="<?php echo $type['policy']['eighth']?>"><?php echo $type['policy']['role_eighth']?></option>
                                  <option data-company="0" value="">Select Role ...</option>
                                  <?php foreach ($roles as $role): ?>
                                    <option value="<?php echo $role['id'] ?>"<?php echo set_select('eighth',$role['id'] ); ?>><?php echo $role['role'] ?></option>
                                  <?php endforeach ?>
                                </select>
                            </td>
                            <td class="centered"> 
                              <select class="form-control chooosen" name="items[<?php echo $type['id']?>][ninth]" style="width: 160px; height:34px;" data-placeholder="Select Role ...">
                                  <option data-company="0" value="<?php echo $type['policy']['ninth']?>"><?php echo $type['policy']['role_ninth']?></option>
                                  <option data-company="0" value="">Select Role ...</option>
                                  <?php foreach ($roles as $role): ?>
                                    <option value="<?php echo $role['id'] ?>"<?php echo set_select('ninth',$role['id'] ); ?>><?php echo $role['role'] ?></option>
                                  <?php endforeach ?>
                                </select>
                            </td>
                          </tr>
                        <?php endforeach ?>
                      <?php endforeach ?>
                      <tr>
                        <td colspan="10">
                          All rental contracts must be issued according to standard contract forms and reviewed by Legal Affairs and chairman and approved before signing by concerned
                          (9 Donation more than Le 1000- Needs Chainnan approval
                          Above procedures should be followed and applied effective the above date,
                        </td>
                      </tr>
                    </tbody>
                  </table>    
                </div>
                <div style="    margin-top: 90px;" class="form-group">
                  <div class="col-lg-offset-3 col-lg-10 col-md-10 col-md-offset-3">
                    <br>
                    <br>
                    <br>
                    <input name="submit" value="Submit" type="submit" class="btn btn-success" />
                    <a href="<?= base_url(); ?>policy/view/<?php echo $core['id'] ?>" class="btn btn-warning">Cancel</a>
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