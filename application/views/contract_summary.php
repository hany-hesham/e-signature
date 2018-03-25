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
          <div class="a4page" style="margin-bottom: 20px;">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px;">
              <div class="page-header">
                <h1 class="centered">Contract Summary</h1>
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
                    <br>
                    <br>
                    <br>
                    <label for="from-hotel" class="control-label " style="margin-top:10px; margin-right: 40px;"> Old Contract </label>
                    <select class="form-control chooosen" name="old_id" data-placeholder="Choose Contract ..." style="width: 250px;">
                      <option></option>
                      <?php foreach ($contracts as $contract): ?>
                        <?php if ($contract['id'] != $id) { ?>
                          <option value="<?php echo $contract['id'] ?>"<?php echo set_select('old_id',$contract['id'] ); ?>><?php echo $contract['hotel_name'] ?>/<?php echo $contract['brand'] ?></option>
                        <?php } ?>
                      <?php endforeach ?>
                    </select>
                  </div>
                </div>
                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                  <br>
                  <br>
                  <br>
                  <input name="submit" value="Submit" type="submit" class="btn btn-success" />
                  <a href="<?= base_url(); ?>contract/view/<?php echo $contract['id']; ?>" class="btn btn-warning">Cancel</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
