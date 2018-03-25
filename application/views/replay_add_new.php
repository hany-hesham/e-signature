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
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px;">
              <div class="page-header">
                <h1 class="centered"> Vacant Position Replay </h1>
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
                    <table class="table table-striped table-bordered table-condensed" style="width: 700px;">
                      <thead>
                        <tr>
                          <th colspan="1" style=" text-align: center;">No.</th>
                          <th colspan="1" style=" text-align: center;">Hotel Name</th>
                          <th colspan="1" style=" text-align: center;">Replay</th>
                        </tr>
                      </thead>
                      <tbody id="items-container" data-items="1">
                        <?php $count = 1; ?>
                        <?php foreach ($hotels as $hotel): ?>
                          <tr id="item-1">
                            <td class="centered"><?php echo $count; ?></td>
                            <td class="centered"> 
                              <input style="display: none" type="text" class="form-control" name="replaies[<?php echo $hotel['id'] ?>][hotel_id]" value="<?php echo $hotel['id'] ?>"/></input>
                              <?php echo $hotel['name'] ?>
                            </td>
                            <td class="centered"> 
                              <select class="form-control" name="replaies[<?php echo $hotel['id'] ?>][replay]">
                                <option value=""> Select Availability State ...</option>
                                <option value="1">Available</option>
                                <option value="0">Not Available</option>
                              </select>
                            </td>
                          </tr>
                          <?php $count++; ?>
                        <?php endforeach; ?>
                      </tbody>
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
      document.items = <?php echo json_encode($this->input->post('replaies')); ?>;
    </script>
  </body>
</html>
