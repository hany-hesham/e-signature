<!DOCTYPE html>
<html lang="en">
  <head>
    <?php $this->load->view('header');?>
  </head>
  <body>
    <div id="wrapper">
      <?php $this->load->view('menu'); ?>
      <nav class="navbar navbar-inverse" id="forms-subnav" style=" margin-left: 50px;">
        <ul class="nav navbar-nav navbar-left navbar-user" style="width: 370px;">
          <li class="<?php echo (isset($submenu['active']) && $submenu['active'] == 'rating')? 'active' : '' ?>"><a href="/cairo_exchange">All</a></li>
          <li class="<?php echo (isset($submenu['active']) && $submenu['active'] == 'rating')? 'active' : '' ?>"><a href="/cairo_exchange/index_app">Approved</a></li>
          <li class="<?php echo (isset($submenu['active']) && $submenu['active'] == 'rating')? 'active' : '' ?>"><a href="/cairo_exchange/index_wat">Waiting Approval</a></li>
          <li class="<?php echo (isset($submenu['active']) && $submenu['active'] == 'rating')? 'active' : '' ?>"><a href="/cairo_exchange/index_rej">Rejected</a></li>
        </ul>
      </nav>
        <div id="page-wrapper">
          <a href="<?php echo base_url(); ?>cairo_exchange/add/" class="btn btn-info">New Daily Exchange Rate</a>
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
              <th class="header">Date<i class="fa fa-sort"></i></th>
              <th class="header">Bank<i class="fa fa-sort"></i></th>
              <th class="header">Currency<i class="fa fa-sort"></i></th>
              <th class="header">Manual Rate<i class="fa fa-sort"></i></th>
              <th class="header">Amount<i class="fa fa-sort"></i></th>
              <th class="header">Action<i class="fa fa-sort"></i></th>
              <th class="header">Status<i class="fa fa-sort"></i></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($exchange as $forma ){?>
              <?php if ($forma['state_id'] =='3'){?>
            <tr class="active">
              <td><?php echo $forma['id'] ?></td>
              <td><?php echo $forma['hotel_name'] ?></td>
              <td><?php echo $forma['date'] ?></td>
              <td>
                <?php foreach ($forma['bankss'] as $bank): ?>
                  <?php if(!empty($bank['amount'])): ?>
                  <div class="">
                    <?php echo $bank['bank_name'] ?>
                  </div>
                  <?php endif; ?>
                <?php endforeach ?>
              </td>
              <td><?php echo $forma['currency'] ?></td>
              <td>
              <?php foreach ($forma['bankss'] as $bank): ?>
                  <?php if(!empty($bank['amount'])): ?>
                  <div class="">
                    <?php echo $bank['rate'] ?>
                  </div>
                  <?php endif; ?>
                <?php endforeach ?>
              </td>
              <td>
              <?php foreach ($forma['bankss'] as $bank): ?>
                  <?php if(!empty($bank['amount'])): ?>
                  <div class="">
                    <?php echo $bank['amount'] ?>
                  </div>
                  <?php endif; ?>
                <?php endforeach ?>
              </td>
              <td>
                <a href="<?php echo base_url(); ?>cairo_exchange/view/<?php echo $forma['id'] ?> " class="btn btn-primary" style="width: 80px;">View</a>
              </td>
              <td style="width: 200px;">
                <?php foreach ($forma['approvals'] as $approval): ?>
                <?php if (isset($approval['sign'])): ?>
                <div class="signer<?php echo isset($approval['sign']['reject'])? ' rejected' : ' accepted' ?>">
                <?php echo $approval['sign']['name'] ?></div>
                <?php elseif(isset($approval['queue'])): ?>
                <div class="signer unsigned"><?php echo $approval['role']."&nbsp".$approval['department'] ?></div>
                <?php endif ?>
                <?php endforeach ?>
              </td>
              <?php } ?>
              </tr>
                <?php } ?>
          <tbody>
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
      </div>
    </div>
    <script type="text/javascript">
      $(function(){
        // define pager options
        var pagerOptions = {
          // target the pager markup - see the HTML block below
          container: $(".pager"),
          // output string - default is '{page}/{totalPages}'; possible variables: {page}, {totalPages}, {startRow}, {endRow} and {totalRows}
          output: '{startRow} - {endRow} / {filteredRows} ({totalRows})',
          // if true, the table will remain the same height no matter how many records are displayed. The space is made up by an empty
          // table row set to a height to compensate; default is false
          fixedHeight: true,
          // remove rows from the table to speed up the sort of large tables.
          // setting this to false, only hides the non-visible rows; needed if you plan to add/remove rows with the pager enabled.
          removeRows: false,
          // go to page selector - select dropdown that sets the current page
          cssGoto: '.gotoPage'
        };
        // Initialize tablesorter
        // ***********************
        $("table")
        .tablesorter({
          theme: 'bootstrap',
          headerTemplate : '{content} {icon}', // new in v2.7. Needed to add the bootstrap icon!
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
        // initialize the pager plugin
        // ****************************
        .tablesorterPager(pagerOptions)
        .find(".tablesorter-filter-row td:last input").replaceWith('<a href="<?php echo base_url(); ?>cairo_exchange/" class="reset-filters btn btn-warning">Reset</a>');
      });
    </script>
  </body>
</html>