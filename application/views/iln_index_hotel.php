<!DOCTYPE html>
<html lang="en">
  <head>
    <?php $this->load->view('header'); ?>
  </head>
  <body>
      <div id="wrapper">
      <?php $this->load->view('menu') ?>
      <div id="page-wrapper">
              <div  class="a4wrapper">
          <div class="">
                    <div class="page-header">
                  <button onclick="window.print()" class="non-printable form-actions btn btn-success" href="" >Print</button>
                    <a class="form-actions btn btn-success non-printable" href="/illness/index_month/<?php echo $date; ?>" style="float:right;" > Back To All Hotels For <?php echo $date; ?></a>
              <div class="header-logo"><img src="/assets/uploads/logos/<?php echo $hotel['logo']; ?>"/></div>
                        <h1 class="centered"><?php echo $hotel['name']; ?></h1>
                  <h3 class="centered">
                    Daily Illness Log Form For <?php echo $date; ?>
                  </h3>
                </div>
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-holder">
                    <a href="<?php echo base_url(); ?>illness/submit/" class="btn btn-info non-printable" style="float:right;">New Illness Log Form</a>
                      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-catcher">
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
                      <table class="table table-bordered table-hover table-striped tablesorter" style="margin-left: -80px;">
                              <thead>
                                <tr>
                                  <th class="centered">No#<i class="fa fa-sort"></i></th>
                                  <th class="centered">ID#<i class="fa fa-sort"></i></th>
                                  <th class="centered">Date<i class="fa fa-sort"></i></th>
                                  <th class="centered">Guest Name<i class="fa fa-sort"></i></th>
                                  <th class="centered">Room<i class="fa fa-sort"></i></th>
                                  <th class="centered">Tour Operator<i class="fa fa-sort"></i></th>
                                  <th class="centered">Diagnosis / Symptoms<i class="fa fa-sort"></i></th>
                                  <th class="centered">Hotel Clinic Visit (*Yes / **No)<i class="fa fa-sort"></i></th>
                                  <th class="centered">* If Yes - is MR available (Yes / No)<i class="fa fa-sort"></i></th>
                                  <th class="centered">** If No - To who the symptoms were reported<i class="fa fa-sort"></i></th>
                                  <th class="centered">Comments<i class="fa fa-sort"></i></th>
                                  <th class="centered">Related IR#<i class="fa fa-sort"></i></th>
                                  <th class="centered non-printable">Actoins<i class="fa fa-sort"></i></th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php $count = 1; ?>
                                <?php foreach ($illness as $guest): ?>
                                  <tr class="item-row">
                                    <td class="centered"><?php echo $count; ?></td>
                                    <td class="centered"><?php echo $guest['iln_id']; ?></td>
                                    <td class="centered"><?php echo $guest['dates']; ?></td>
                                    <td class="centered"><?php echo $guest['guest']; ?></td>
                                    <td class="centered"><?php echo $guest['room']; ?></td>
                                    <td class="centered"><?php echo $guest['operator_name']; ?></td>
                                    <td class="centered"><?php echo $guest['symptoms']; ?></td>
                                    <td class="centered"><?php echo $guest['visit']; ?></td>
                                    <td class="centered"><?php echo $guest['avaible']; ?></td>
                                    <td class="centered"><?php echo $guest['reported']; ?></td>
                                    <td class="centered"><?php echo $guest['comments']; ?></td>
                                    <td class="centered">
                                      <a class="form-actions btn btn-success non-printable" href="/form/<?php if($guest['ir_type'] == 1){ echo "view_in_uk";}elseif($guest['ir_type'] == 2){ echo "view_in";} ?>/<?php echo $guest['ir']; ?>" style="float:right;" > No# <?php echo $guest['ir']; ?></a>
                                    </td>
                                    <td class="non-printable">
                                      <a href="<?php echo base_url(); ?>illness/view/<?php echo $guest['iln_id'] ?> " class="btn btn-primary">View</a>
                                    </td>
                                  </tr>
                                  <?php $count++; ?>
                                <?php endforeach ?>
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
                </div>
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
            }
          }
        })
        // initialize the pager plugin
        // ****************************
        .tablesorterPager(pagerOptions)
        .find(".tablesorter-filter-row td:last input").replaceWith('<a href="<?php echo base_url(); ?>illness/" class="reset-filters btn btn-warning non-printable">Reset</a>');
      });
    </script>
  </body>
</html>
