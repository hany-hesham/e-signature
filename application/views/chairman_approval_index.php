<!DOCTYPE html>
<html lang="en">
  <head>
    <?php $this->load->view('header');?>
  </head>
  <body>
    <div id="wrapper">
      <?php $this->load->view('menu'); ?>
      <div id="page-wrapper">
        <div class="pager tablesorter-pager" style="display: block;">
          <fieldset class="non-printable">
            <?php $this->load->view('waiting_all_menu'); ?>
          </fieldset>
        </div>
        <?php if(isset($forms)): ?>
            <h1 class="centered"> Total Of <?php echo $counter;?> Forms Need Your Signature</h1>
          <table class="table table-bordered table-hover table-striped tablesorter">
            <thead>
              <tr>
                <th class="header">Section<i class="fa fa-sort"></i></th>
                <th class="header">Link<i class="fa fa-sort"></i></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($forms as $form ){?>
                <tr class="active">
                  <td><?php echo $form['state']['name'] ?></td>
                  <td>
                    <a href="<?php echo base_url(); ?><?php echo $form['state']['link'] ?><?php echo $form[$form['state']['variable']] ?> " class="btn btn-primary" style="width: 80px;">View</a>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        <?php endif; ?>
      </div>
    </div>
  </body>
</html>
