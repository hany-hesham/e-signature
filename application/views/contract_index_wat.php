<!DOCTYPE html>
<html lang="en">
  <head>
    <?php $this->load->view('header');?>
  </head>
  <body>
    <div id="wrapper">
      <?php $this->load->view('menu'); ?>
      <nav class="navbar navbar-inverse" id="forms-subnav" style="margin-left: -60px;">
        <ul class="nav navbar-nav navbar-left navbar-user">
          <li class="<?php echo (isset($submenu['active']) && $submenu['active'] == 'financial')? 'active' : '' ?>"><a href="/contract/index">All</a></li>
          <li class="<?php echo (isset($submenu['active']) && $submenu['active'] == 'financial')? 'active' : '' ?>"><a href="/contract/index_app">Approved</a></li>
          <li class="<?php echo (isset($submenu['active']) && $submenu['active'] == 'financial')? 'active' : '' ?>"><a href="/contract/index_wat">Waiting Approval</a></li>
          <li class="<?php echo (isset($submenu['active']) && $submenu['active'] == 'financial')? 'active' : '' ?>"><a href="/contract/index_rej">Rejected</a></li>
          <li class="<?php echo (isset($submenu['active']) && $submenu['active'] == 'financial')? 'active' : '' ?>"><a href="/contract/index_not_upload">Unattached Contracts</a></li>
          <li class="<?php echo (isset($submenu['active']) && $submenu['active'] == 'financial')? 'active' : '' ?>"><a href="/contract/index_upload">Attached Contracts</a></li>
        </ul>
      </nav>
      <div id="page-wrapper">
        <br>
        <?php if ((isset($role_id) && ($role_id == 57)) || $is_admin){ ?>
          <a href="<?php echo base_url(); ?>contract/submit/" class="btn btn-info">New Contract</a>
        <?php } ?>
        <a class="form-actions btn btn-success non-printable" href="/financial" style="float:right;" > Back </a>
        <br>
        <br>
        <div class="rest-selector col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <fieldset>
            <?php $this->load->view('contract_waiting_menu'); ?>
          </fieldset>
        </div>
        <?php if (isset($state)): ?>
          <div class="pager tablesorter-pager" style="display: block;">
            Page: <select class="form-control gotoPage pager-filter" aria-disabled="false"></select>
            <i class="fa fa-fast-backward pager-nav first disabled" alt="First" title="First page" tabindex="0" aria-disabled="true"></i>
            <i class="fa fa-backward pager-nav prev disabled" alt="Prev" title="Previous page" tabindex="0" aria-disabled="true"></i>
            <span class="pagedisplay"></span>
            <i class="fa fa-forward pager-nav next" alt="Next" title="Next page" tabindex="0" aria-disabled="false"></i>
            <i class="fa fa-fast-forward pager-nav last" alt="Last" title="Last page" tabindex="0" aria-disabled="false"></i>
            <select class="form-control pagesize pager-filter" aria-disabled="false">
              <option selected="selected" value="10">10</option>
              <option value="30">30</option>
              <option value="50">50</option>
            </select>
          </div>
          <table class="table table-bordered table-hover table-striped tablesorter">
            <thead>
              <tr>
                <th class="header">#<i class="fa fa-sort"></i></th>
                <th class="header">Hotel<i class="fa fa-sort"></i></th>
                <th class="header">Service<i class="fa fa-sort"></i></th>
                <th class="header">Contractor Name<i class="fa fa-sort"></i></th>
                <th class="header">Starting From<i class="fa fa-sort"></i></th>
                <th class="header">Ends At<i class="fa fa-sort"></i></th>
                <th class="header">Attachment<i class="fa fa-sort"></i></th>
                <th class="header">Action<i class="fa fa-sort"></i></th>
                <th class="header">Summary Status<i class="fa fa-sort"></i></th>
                <th class="header">Status<i class="fa fa-sort"></i></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($contract as $forma ){?>
                <tr class="active" style="color:
                <?php
                  if (isset($forma['summary']['id']) && $forma['summary']['id']){
                    if ($forma['summary']['approvals'][3]['user_id'] == 217) {
                      echo "blue !important";
                    } 
                  }
                ?>
              ;">
                  <td><?php echo $forma['id'] ?></td>
                  <td><?php echo $forma['hotel_name'] ?></td>
                  <td><?php echo $forma['service_name'] ?></td>
                  <td><?php echo $forma['name'] ?></td>
                  <td><?php echo $forma['from_date'] ?></td>
                  <td><?php echo $forma['to_date'] ?></td>
                  <td><?php if ($forma['upload']): ?><img src="/assets/images/clip.png" style="width: 40px; height: 30px;"><?php endif;?></td>
                  <td style="width: 150px;">
                    <a href="<?php echo base_url(); ?>contract/view/<?php echo $forma['id'] ?> " class="btn btn-primary" style="width: 80px;">View</a>
                    <br>
                    <br>
                    <?php if ($forma['state_id'] == 2 && !isset($forma['summary']['id'])): ?>
                      <a class="form-actions btn btn-warning non-printable" href="/contract/summry/<?php echo $forma['id'] ?>" style="" > Contract Summary </a>
                    <?php endif ?>
                    <?php if (isset($forma['summary']['id'])): ?>
                      <a class="form-actions btn btn-warning non-printable" href="/contract/view_summary/<?php echo $forma['summary']['id'] ?>" style="" > View Contract Summary </a>
                    <?php endif ?>
                  </td>
                  <td style="width: 150px;">
                  <?php if (isset($forma['summary']['id'])): ?>
                      <?php foreach ($forma['approvals'] as $approval): ?>
                        <?php if ($approval['role_id'] != 59 && $approval['role_id'] !=57) {?>
                        <?php if ($approval['user_id']): ?>
                          <div class="signer<?php echo ($approval['reject'] == 1)? ' rejected' : ' accepted' ?>">
                            <?php echo $approval['user_name'] ?>
                          </div>
                        <?php else: ?>
                          <div class="signer unsigned"><?php echo ($approval['role_id'] == '7')? $approval['department']: $approval['role']."&nbsp".$approval['department']; ?></div>
                        <?php endif ?>
                        <?php } ?>
                      <?php endforeach ?>
                      <?php foreach ($forma['summary']['approvals'] as $approval): ?>
                        <?php if ($approval['user_id']): ?>
                          <div class="signer<?php echo ($approval['reject'] == 1)? ' rejected' : ' accepted' ?>">
                            <?php echo $approval['user_name'] ?>
                          </div>
                        <?php else: ?>
                          <div class="signer unsigned"><?php echo ($approval['role_id'] == '7')? $approval['department']: $approval['role']."&nbsp".$approval['department']; ?></div>
                        <?php endif ?>
                      <?php endforeach ?>
                  <?php elseif(!isset($forma['summary']['id'])): ?>
                    <div class="signer rejected">Waiting Aproval</div>
                  <?php endif ?>
                  </td>
                  <td style="width: 150px;">
                    <?php foreach ($forma['approvals'] as $approval): ?>
                      <?php if ($approval['user_id']): ?>
                        <div class="signer<?php echo ($approval['reject'] == 1)? ' rejected' : ' accepted' ?>">
                          <?php echo $approval['user_name'] ?>
                        </div>
                      <?php else: ?>
                        <div class="signer unsigned"><?php echo ($approval['role_id'] == '7')? $approval['department']: $approval['role']."&nbsp".$approval['department']; ?></div>
                      <?php endif ?>
                    <?php endforeach ?>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
          <div class="pager tablesorter-pager" style="display: block;">
            Page: <select class="form-control gotoPage pager-filter" aria-disabled="false"></select>
            <i class="fa fa-fast-backward pager-nav first disabled" alt="First" title="First page" tabindex="0" aria-disabled="true"></i>
            <i class="fa fa-backward pager-nav prev disabled" alt="Prev" title="Previous page" tabindex="0" aria-disabled="true"></i>
            <span class="pagedisplay"></span>
            <i class="fa fa-forward pager-nav next" alt="Next" title="Next page" tabindex="0" aria-disabled="false"></i>
            <i class="fa fa-fast-forward pager-nav last" alt="Last" title="Last page" tabindex="0" aria-disabled="false"></i>
            <select class="form-control pagesize pager-filter" aria-disabled="false">
              <option selected="selected" value="10">10</option>
              <option value="30">30</option>
              <option value="50">50</option>
            </select>
          </div>
      <?php endif; ?>
      </div>
    </div>
    <script type="text/javascript">
      $(function(){
        var pagerOptions = {
          container: $(".pager"),
          output: '{startRow} - {endRow} / {filteredRows} ({totalRows})',
          fixedHeight: true,
          removeRows: false,
          cssGoto: '.gotoPage'
        };
        $("table")
        .tablesorter({
          theme: 'bootstrap',
          headerTemplate : '{content} {icon}',
          widthFixed: true,
          widgets: ['filter'],
          widgetOptions: {
            filter_reset : '.reset-filters',
            filter_functions: {
              1: {
                <?php foreach ($hotels as $hotel) :?>
                  "<?php echo $hotel['name']; ?>":function(e, n, f, i, $r) { return f == e; },
                <?php endforeach; ?>
              },
            }
          }
        })
        .tablesorterPager(pagerOptions)
        .find(".tablesorter-filter-row td:last input").replaceWith('<a href="<?php echo base_url(); ?>contract/" class="reset-filters btn btn-warning">Reset</a>');
      });
    </script>
  </body>
</html>
