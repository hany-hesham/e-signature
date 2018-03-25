<!DOCTYPE html>
<html lang="en">
<head>
<?php $this->load->view('header'); ?>
</head>
<body>
<div id="wrapper">
  <?php $this->load->view('menu') ?><br>
            <a style="margin-left: 20px;" href="<?php echo base_url(); ?>workshop/request_submit/" class="btn btn-primary">Add New Request</a>
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
  <div class="table-responsive">
  <a href="#" class="hidden reset-filters btn btn-warning">Reset</a>
    <table class="table table-bordered table-hover table-striped tablesorter">
      <thead>
        <tr>
          <th class="header">No. <i class="fa fa-sort"></i></th>
          <th class="header">Hotel <i class="fa fa-sort"></i></th>
          <th class="header">Approvals <i class="fa fa-sort"></i></th>
          <th class="header">Received By <i class="fa fa-sort"></i></th>
          <th class="header" width="15%;">Items <i class="fa fa-sort"></i></th>
          <th class="header">Actions </th>
          <th class="header">Done </th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($workshop_requests as $request): ?>
        <tr class="active">
          <td><?php echo $request['id'] ?></td>
          <td><?php echo $request['from_hotel'] ?></td>
          <td>
            <?php foreach ($request['approvals'] as $approval): ?>
              <?php if (isset($approval['sign'])): ?>
                <div class="signer<?php echo isset($approval['sign']['reject'])? ' rejected' : ' accepted' ?>"><?php echo $approval['sign']['name'] ?></div>
              <?php elseif(isset($approval['queue'])): ?>
                <div class="signer unsigned"><?php echo $approval['role'] ?></div>
              <?php endif ?>
            <?php endforeach ?>
          </td>

          <td>
          <?php foreach ($request['reciver'] as $recive): ?>
            <div class="signer accepted"><?php echo $recive['fullname']; ?></div>
          <?php endforeach; ?>
          </td>

          <td>
          <?php if(!empty($request['items'])): ?>
            <?php foreach ($request['items'] as $item): ?>
                <div><?php echo $item['description']; ?></div>
            <?php endforeach; ?>
          <?php endif ?>
          </td>


          <td>
            <a href="<?php echo base_url(); ?>workshop/request_view/<?php echo $request['id'] ?>" class="btn btn-primary">Request View</a>
            <?php if (isset($request['order_state'])): ?>
            <a href="<?php echo base_url(); ?>workshop/order_view/<?php echo $request['order_id']; ?>" class="btn btn-primary">Order View</a>
            <?php endif; ?>
          </td>
          <td>
                  <?php if ($request['state_id'] >= 6 ): ?>
                    <?php if ($request['done'] == 0): ?>
                  <div class="non-edit">
                    <a class="btn btn-success approve-btn" href="/workshop/approve/<?php echo $request['id']; ?>">Done</a>
                  </div>
                  <?php endif; ?>
                  <?php endif; ?>

                  <?php if ($request['done'] == 1): ?>
                      <span class="checked"><i class="fa fa-check glyphicon glyphicon-check"></i></span>
                  <?php endif; ?>

          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
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
                }
              }
            }
          })

          // initialize the pager plugin
          // ****************************
          .tablesorterPager(pagerOptions)
          .find(".tablesorter-filter-row td:last input").replaceWith('<a href="#" class="reset-filters btn btn-warning">Reset</a>');
      });
  </script>
  </div>
</div>
</body>
</html>