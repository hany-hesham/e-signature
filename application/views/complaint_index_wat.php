<!DOCTYPE html>
<html lang="en">
  <head>
    <?php $this->load->view('header');?>
  </head>
  <body>
    <div id="wrapper">
      <?php $this->load->view('menu'); ?>
      <nav class="navbar navbar-inverse" id="forms-subnav">
        <ul class="nav navbar-nav navbar-left navbar-user">
          <li class="<?php echo (isset($submenu['active']) && $submenu['active'] == 'quality')? 'active' : '' ?>"><a href="/complaint/index">All</a></li>
          <li class="<?php echo (isset($submenu['active']) && $submenu['active'] == 'quality')? 'active' : '' ?>"><a href="/complaint/index_app">Approved</a></li>
          <li class="<?php echo (isset($submenu['active']) && $submenu['active'] == 'quality')? 'active' : '' ?>"><a href="/complaint/index_wat">Waiting Approval</a></li>
          <li class="<?php echo (isset($submenu['active']) && $submenu['active'] == 'quality')? 'active' : '' ?>"><a href="/complaint/index_rej">Rejected</a></li>
        </ul>
      </nav>
      <div id="page-wrapper">
        <a href="<?php echo base_url(); ?>complaint/submit/" class="btn btn-info">New Complaint After Stay Form</a>
        <a href="<?php echo base_url(); ?>quality/" class="btn btn-danger" style="float: right;">Go Back To Quality Forms</a>
        <br>
          <br>
          <div class="rest-selector col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <fieldset>
              <?php $this->load->view('complaint_waiting_menu'); ?>
            </fieldset>
          </div>
          <?php if (isset($state)): ?> 
            <?php if ($state == 0) {   ?>
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
              <th class="header">Guest Name<i class="fa fa-sort"></i></th>
              <th class="header">Ref. Number<i class="fa fa-sort"></i></th>
              <th class="header">Date of Travel (Arr.)<i class="fa fa-sort"></i></th>
              <th class="header">Action<i class="fa fa-sort"></i></th>
              <th class="header">Status<i class="fa fa-sort"></i></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($complaint as $forma ){?>
              <?php if ($forma['guest'] != NULL && $forma['state_id'] !='0' && $forma['state_id'] !='2' && $forma['state_id'] !='3' ){?>
                <tr class="active">
                  <td><?php echo $forma['id'] ?></td>
                  <td><?php echo $forma['hotel_name'] ?></td>
                  <td><?php echo $forma['guest'] ?></td>
                  <td><?php echo $forma['ref'] ?></td>
                  <td><?php echo $forma['date'] ?></td>
                  <td>
                    <a href="<?php echo base_url(); ?>complaint/view/<?php echo $forma['id'] ?> " class="btn btn-primary" style="width: 80px;">View</a>
                  </td>
                  <td style="width: 200px;">
                    <?php foreach ($forma['approvals'] as $approval): ?>
                      <?php if (isset($approval['sign'])): ?>
                        <div class="signer<?php echo isset($approval['sign']['reject'])? ' rejected' : ' accepted' ?>">
                          <?php echo $approval['sign']['name'] ?>
                        </div>
                      <?php elseif(isset($approval['queue'])): ?>
                        <div class="signer unsigned"><?php echo $approval['role']."&nbsp".$approval['department'] ?></div>
                      <?php endif ?>
                    <?php endforeach ?>
                  </td>
                </tr>
              <?php } ?>
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
      <?php }elseif ($state == 1) {   ?>
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
              <th class="header">Guest Name<i class="fa fa-sort"></i></th>
              <th class="header">Ref. Number<i class="fa fa-sort"></i></th>
              <th class="header">Date of Travel (Arr.)<i class="fa fa-sort"></i></th>
              <th class="header">Action<i class="fa fa-sort"></i></th>
              <th class="header">Status<i class="fa fa-sort"></i></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($complaint as $forma ){?>
              <?php if ($forma['guest'] != NULL && $forma['state_id'] =='1'){?>
                <tr class="active">
                  <td><?php echo $forma['id'] ?></td>
                  <td><?php echo $forma['hotel_name'] ?></td>
                  <td><?php echo $forma['guest'] ?></td>
                  <td><?php echo $forma['ref'] ?></td>
                  <td><?php echo $forma['date'] ?></td>
                  <td>
                    <a href="<?php echo base_url(); ?>complaint/view/<?php echo $forma['id'] ?> " class="btn btn-primary" style="width: 80px;">View</a>
                  </td>
                  <td style="width: 200px;">
                    <?php foreach ($forma['approvals'] as $approval): ?>
                      <?php if (isset($approval['sign'])): ?>
                        <div class="signer<?php echo isset($approval['sign']['reject'])? ' rejected' : ' accepted' ?>">
                          <?php echo $approval['sign']['name'] ?>
                        </div>
                      <?php elseif(isset($approval['queue'])): ?>
                        <div class="signer unsigned"><?php echo $approval['role']."&nbsp".$approval['department'] ?></div>
                      <?php endif ?>
                    <?php endforeach ?>
                  </td>
                </tr>
              <?php } ?>
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
      <?php }elseif ($state == 2) {   ?>
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
              <th class="header">Guest Name<i class="fa fa-sort"></i></th>
              <th class="header">Ref. Number<i class="fa fa-sort"></i></th>
              <th class="header">Date of Travel (Arr.)<i class="fa fa-sort"></i></th>
              <th class="header">Action<i class="fa fa-sort"></i></th>
              <th class="header">Status<i class="fa fa-sort"></i></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($complaint as $forma ){?>
              <?php if ($forma['guest'] != NULL && $forma['state_id'] =='4'){?>
                <tr class="active">
                  <td><?php echo $forma['id'] ?></td>
                  <td><?php echo $forma['hotel_name'] ?></td>
                  <td><?php echo $forma['guest'] ?></td>
                  <td><?php echo $forma['ref'] ?></td>
                  <td><?php echo $forma['date'] ?></td>
                  <td>
                    <a href="<?php echo base_url(); ?>complaint/view/<?php echo $forma['id'] ?> " class="btn btn-primary" style="width: 80px;">View</a>
                  </td>
                  <td style="width: 200px;">
                    <?php foreach ($forma['approvals'] as $approval): ?>
                      <?php if (isset($approval['sign'])): ?>
                        <div class="signer<?php echo isset($approval['sign']['reject'])? ' rejected' : ' accepted' ?>">
                          <?php echo $approval['sign']['name'] ?>
                        </div>
                      <?php elseif(isset($approval['queue'])): ?>
                        <div class="signer unsigned"><?php echo $approval['role']."&nbsp".$approval['department'] ?></div>
                      <?php endif ?>
                    <?php endforeach ?>
                  </td>
                </tr>
              <?php } ?>
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
      <?php }elseif ($state == 3) {   ?>
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
              <th class="header">Guest Name<i class="fa fa-sort"></i></th>
              <th class="header">Ref. Number<i class="fa fa-sort"></i></th>
              <th class="header">Date of Travel (Arr.)<i class="fa fa-sort"></i></th>
              <th class="header">Action<i class="fa fa-sort"></i></th>
              <th class="header">Status<i class="fa fa-sort"></i></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($complaint as $forma ){?>
              <?php if ($forma['guest'] != NULL && $forma['state_id'] =='5'){?>
                <tr class="active">
                  <td><?php echo $forma['id'] ?></td>
                  <td><?php echo $forma['hotel_name'] ?></td>
                  <td><?php echo $forma['guest'] ?></td>
                  <td><?php echo $forma['ref'] ?></td>
                  <td><?php echo $forma['date'] ?></td>
                  <td>
                    <a href="<?php echo base_url(); ?>complaint/view/<?php echo $forma['id'] ?> " class="btn btn-primary" style="width: 80px;">View</a>
                  </td>
                  <td style="width: 200px;">
                    <?php foreach ($forma['approvals'] as $approval): ?>
                      <?php if (isset($approval['sign'])): ?>
                        <div class="signer<?php echo isset($approval['sign']['reject'])? ' rejected' : ' accepted' ?>">
                          <?php echo $approval['sign']['name'] ?>
                        </div>
                      <?php elseif(isset($approval['queue'])): ?>
                        <div class="signer unsigned"><?php echo $approval['role']."&nbsp".$approval['department'] ?></div>
                      <?php endif ?>
                    <?php endforeach ?>
                  </td>
                </tr>
              <?php } ?>
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
        <?php } ?>
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
        .find(".tablesorter-filter-row td:last input").replaceWith('<a href="<?php echo base_url(); ?>complaint/" class="reset-filters btn btn-warning">Reset</a>');
      });
    </script>
  </body>
</html>
