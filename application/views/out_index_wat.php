<!DOCTYPE html>
<html lang="en">
  <head>
    <?php $this->load->view('header');?>
  </head>
  <body>
    <div id="wrapper">
      <?php $this->load->view('menu'); ?>
      <nav class="navbar navbar-inverse" id="forms-subnav" style="margin-left: 50px;">
        <ul class="nav navbar-nav navbar-left navbar-user">
          <li class="<?php echo (isset($submenu['active']) && $submenu['active'] == 'financial')? 'active' : '' ?>"><a href="/out_go/index">All</a></li>
          <li class="<?php echo (isset($submenu['active']) && $submenu['active'] == 'financial')? 'active' : '' ?>"><a href="/out_go/index_app">Approved</a></li>
          <li class="<?php echo (isset($submenu['active']) && $submenu['active'] == 'financial')? 'active' : '' ?>"><a href="/out_go/index_wat">Waiting Approval</a></li>
          <li class="<?php echo (isset($submenu['active']) && $submenu['active'] == 'financial')? 'active' : '' ?>"><a href="/out_go/index_rej">Rejected</a></li>
        </ul>
      </nav>
      <div id="page-wrapper">
        <a href="<?php echo base_url(); ?>out_go/submit/" class="btn btn-info">New Out Going Form</a>
        <a class="form-actions btn btn-success non-printable" href="/financial" style="float:right;" > Back </a>
        <br>
        <br>
        <div class="rest-selector col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <fieldset>
            <?php $this->load->view('out_waiting_menu'); ?>
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
                <th class="header">Department<i class="fa fa-sort"></i></th>
                <th class="header">Out With<i class="fa fa-sort"></i></th>
                <th class="header">Action<i class="fa fa-sort"></i></th>
                <th class="header">Status<i class="fa fa-sort"></i></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($out_gos as $out_go ){?>
                <tr class="active">
                  <td><?php echo $out_go['id'] ?></td>
                  <td><?php echo $out_go['hotel_name'] ?></td>
                  <td><?php echo $out_go['department'] ?></td>
                  <td><?php echo $out_go['out_with'] ?></td>
                  <td>
                    <a href="<?php echo base_url(); ?>out_go/view/<?php echo $out_go['id'] ?> " class="btn btn-primary" style="width: 80px;">View</a>
                  </td>
                  <td style="width: 200px;">
                    <?php foreach ($out_go['approvals'] as $approval): ?>
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
  </body>
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
      .find(".tablesorter-filter-row td:last input").replaceWith('<a href="<?php echo base_url(); ?>out_go/" class="reset-filters btn btn-warning">Reset</a>');
    });
  </script>
</html>
