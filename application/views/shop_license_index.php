<!DOCTYPE html>
<html lang="en">
  <head>
    <?php $this->load->view('header');?>
  </head>
  <body>
    <div id="wrapper">
      <?php $this->load->view('menu'); ?>
      <div id="page-wrapper">
        <a href="<?php echo base_url(); ?>Shop_license/submit/" class="btn btn-info">New Tenants Shop License</a>
        <div class="pager tablesorter-pager" style="display: block;">
          <a class="form-actions btn btn-success non-printable" href="/financial" style="float:right;" > Back </a>
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
              <th class="header">Hotel Name<i class="fa fa-sort"></i></th>
              <th class="header">Created by<i class="fa fa-sort"></i></th>
              <th class="header">Creation Date<i class="fa fa-sort"></i></th>
              <th class="header">Action<i class="fa fa-sort"></i></th>
              <th class="header">Status<i class="fa fa-sort"></i></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($shop_l as $row ){?>
              <tr class="active">
                <td><?php echo $row['id'] ?></td>
                <td><?php echo $row['hotel_name'] ?></td>
                <td><?php echo $row['name'] ?></td>
                <td><?php echo $row['timestamp'] ?></td>
                <td>
                  <a href="<?php echo base_url(); ?>Shop_license/view/<?php echo $row['id'] ?> " class="btn btn-primary" style="width: 80px;">View</a>
                </td>
                <td style="width: 200px;">
                  <?php foreach ($row['approvals'] as $approval): ?>
                    <?php if ($approval['user_id']): ?>
                      <div class="signer<?php echo ($approval['reject'] == 1)? ' rejected' : ' accepted' ?>">
                        <?php echo $approval['user_name'] ?>
                      </div>
                    <?php else: ?>
                      <div class="signer unsigned"><?php echo $approval['role']; ?></div>
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
      .find(".tablesorter-filter-row td:last input").replaceWith('<a href="<?php echo base_url(); ?>out_service/" class="reset-filters btn btn-warning">Reset</a>');
    });
  </script>
  <script type="text/javascript">
    document.body.addEventListener("keydown", function (event) {
      if (event.keyCode === 13) {
        window.location.replace("<?= base_url(); ?>out_service/submit");
      }
    });  
  </script>
</html>
