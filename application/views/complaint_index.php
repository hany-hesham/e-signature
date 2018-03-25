<!DOCTYPE html>
<html lang="en">
  <head>
    <?php $this->load->view('header');?>
  </head>
  <body>
    <div id="wrapper">
      <?php $this->load->view('menu'); ?>
      <div id="page-wrapper">
        <a href="<?php echo base_url(); ?>complaint/submit/" class="btn btn-info">New Complaint After Stay Form</a>
        <a href="<?php echo base_url(); ?>quality/" class="btn btn-danger" style="float: right;">Go Back To Quality Forms</a>
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
              <th class="header">Tour Operator<i class="fa fa-sort"></i></th>
              <th class="header">Ref. Number<i class="fa fa-sort"></i></th>
              <th class="header">Guest Name<i class="fa fa-sort"></i></th>
              <th class="header">Date of Recieving Complaint<i class="fa fa-sort"></i></th>
              <th class="header" style="width: 300px;">Subject of Complaint<i class="fa fa-sort"></i></th>
              <th class="header">Action<i class="fa fa-sort"></i></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($complaint as $forma ){?>
              <?php if ($forma['guest'] != NULL && $forma['state_id'] !='0'){?>
                <tr class="active">
                  <td><?php echo $forma['id'] ?></td>
                  <td><?php echo $forma['hotel_name'] ?></td>
                  <td><?php echo $forma['operator_name'] ?></td>
                  <td><?php echo $forma['ref'] ?></td>
                  <td><?php echo $forma['guest'] ?></td>
                  <td><?php echo $forma['receiving'] ?></td>
                  <td><?php echo $forma['subject'] ?></td>
                  <td>
                    <a href="<?php echo base_url(); ?>complaint/view/<?php echo $forma['id'] ?> " class="btn btn-primary" style="width: 80px;">View</a>
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
