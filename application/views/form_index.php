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
          <li class="<?php echo (isset($submenu['active']) && $submenu['active'] == 'form')? 'active' : '' ?>"><a href="/form">All</a></li>
          <li class="<?php echo (isset($submenu['active']) && $submenu['active'] == 'form')? 'active' : '' ?>"><a href="/form/index_after">After Stay-UK</a></li>
          <li class="<?php echo (isset($submenu['active']) && $submenu['active'] == 'form')? 'active' : '' ?>"><a href="/form/index_in_uk">In House-UK</a></li>
          <li class="<?php echo (isset($submenu['active']) && $submenu['active'] == 'form')? 'active' : '' ?>"><a href="/form/index_in">In House-other nationalities</a></li>
        </ul>
      </nav>
        <div id="page-wrapper1">
        <br>
          <a href="<?php echo base_url(); ?>form/submit_after/" class="btn btn-info">New E-claim After Stay Form</a>
          <a href="http://gsc.sunrise-resorts.com/e-claim/index.php" class="btn btn-info" style="float: right;">Old E-Claim</a>
          <div class="pager1 tablesorter-pager" style="display: block; text-align: center;">
            Page: <select class="form-control gotoPage1 pager-filter" aria-disabled="false"></select>
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
          <br>
        <table class="table1 table-bordered table-hover table-striped tablesorter1">
          <thead>
            <tr>
              <th class="header">#<i class="fa fa-sort"></i></th>
              <th class="header">Hotel<i class="fa fa-sort"></i></th>
              <th class="header">Tour Operator<i class="fa fa-sort"></i></th>
              <th class="header">Name of CNF<i class="fa fa-sort"></i></th>
              <th class="header">Action<i class="fa fa-sort"></i></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($form as $forma ){?>
            <tr class="active">
              <td><?php echo $forma['id'] ?></td>
              <td><?php echo $forma['hotel_name'] ?></td>
              <td><?php echo $forma['operator_name'] ?></td>
              <td><?php echo $forma['cnf'] ?></td>
              <td><a href="<?php echo base_url(); ?>form/view_after/<?php echo $forma['id'] ?> " class="btn btn-primary">View</a></td>
              <?php } ?>
            </tr>
          <tbody>
        </table>
        <br>
        <div class="pager1 tablesorter-pager" style="display: block; text-align: center;">
          Page: <select class="form-control gotoPage1 pager-filter" aria-disabled="false"></select>
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
        <br>
      </div>
      <div id="page-wrapper2">
          <br>
          <a href="<?php echo base_url(); ?>form/submit_in_uk/" class="btn btn-info">New In House Incident Report-UK Form</a>
          <div class="pager2 tablesorter-pager" style="display: block; text-align: center;">
            Page: <select class="form-control gotoPage2 pager-filter" aria-disabled="false"></select>
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
          <br>
        <table class="table2 table-bordered table-hover table-striped tablesorter2">
          <thead>
            <tr>
              <th class="header">#<i class="fa fa-sort"></i></th>
              <th class="header">Hotel<i class="fa fa-sort"></i></th>
              <th class="header">Tour Operator<i class="fa fa-sort"></i></th>
              <th class="header">Guest Name<i class="fa fa-sort"></i></th>
              <th class="header">Action<i class="fa fa-sort"></i></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($form1 as $forma ){?>
            <tr class="active">
              <td><?php echo $forma['id'] ?></td>
              <td><?php echo $forma['hotel_name'] ?></td>
              <td><?php echo $forma['operator_name'] ?></td>
              <td><?php echo $forma['guest'] ?></td>
              <td><a href="<?php echo base_url(); ?>form/view_in_uk/<?php echo $forma['id'] ?> " class="btn btn-primary">View</a></td>
              <?php } ?>
            </tr>
          <tbody>
        </table>
        <br>
        <div class="pager2 tablesorter-pager" style="display: block; text-align: center;">
          Page: <select class="form-control gotoPage2 pager-filter" aria-disabled="false"></select>
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
        <br>
      </div>
      <div id="page-wrapper">
          <br>
          <a href="<?php echo base_url(); ?>form/submit_in/" class="btn btn-info">New In House - other nationalities Incident Report Form</a>
          <div class="pager tablesorter-pager" style="display: block; text-align: center;">
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
          <br>
        <table class="table table-bordered table-hover table-striped tablesorter">
          <thead>
            <tr>
              <th class="header">#<i class="fa fa-sort"></i></th>
              <th class="header">Hotel<i class="fa fa-sort"></i></th>
              <th class="header">Tour Operator<i class="fa fa-sort"></i></th>
              <th class="header">Guest Name<i class="fa fa-sort"></i></th>
              <th class="header">Action<i class="fa fa-sort"></i></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($form2 as $forma ){?>
            <tr class="active">
              <td><?php echo $forma['id'] ?></td>
              <td><?php echo $forma['hotel_name'] ?></td>
              <td><?php echo $forma['operator_name'] ?></td>
              <td><?php echo $forma['guest'] ?></td>
              <td><a href="<?php echo base_url(); ?>form/view_in/<?php echo $forma['id'] ?> " class="btn btn-primary">View</a></td>
              <?php } ?>
            </tr>
          <tbody>
        </table>
        <br>
        <div class="pager tablesorter-pager" style="display: block; text-align: center;">
          Page: <select class="form-control gotoPage pager-filter" aria-disabled="false"></select>
          <i class="fa fa-fast-backward pager-nav first disabled" alt="First" title="First page" tabindex="0" aria-disabled="true"></i>
          <i class="fa fa-backward pager-nav prev disabled" alt="Prev" title="Previous page" tabindex="0" aria-disabled="true"></i>
          <span class=""></span>
          <i class="fa fa-forward pager-nav next" alt="Next" title="Next page" tabindex="0" aria-disabled="false"></i>
          <i class="fa fa-fast-forward pager-nav last" alt="Last" title="Last page" tabindex="0" aria-disabled="false"></i>
          <select class="form-control pagesize pager-filter" aria-disabled="false">
            <option selected="selected" value="10">10</option>
            <option value="30">30</option>
            <option value="50">50</option>
          </select>
        </div>
        <br>
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
        .find(".tablesorter-filter-row td:last input").replaceWith('<a href="<?php echo base_url(); ?>form/" class="reset-filters btn btn-warning">Reset</a>');
      });
    </script>




    <script type="text/javascript">
      $(function(){
        // define pager options
        var pagerOptions = {
          // target the pager markup - see the HTML block below
          container: $(".pager2"),
          // output string - default is '{page}/{totalPages}'; possible variables: {page}, {totalPages}, {startRow}, {endRow} and {totalRows}
          output: '{startRow} - {endRow} / {filteredRows} ({totalRows})',
          // if true, the table will remain the same height no matter how many records are displayed. The space is made up by an empty
          // table row set to a height to compensate; default is false
          fixedHeight: true,
          // remove rows from the table to speed up the sort of large tables.
          // setting this to false, only hides the non-visible rows; needed if you plan to add/remove rows with the pager enabled.
          removeRows: false,
          // go to page selector - select dropdown that sets the current page
          cssGoto: '.gotoPage2'
        };
        // Initialize tablesorter
        // ***********************
        $("table2")
        .tablesorter2({
          theme: 'bootstrap',
          headerTemplate : '{content} {icon}', // new in v2.7. Needed to add the bootstrap icon!
          widthFixed: true,
          widgets: ['filter'],
          widgetOptions: {
            filter_reset : '.reset-filters2',
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
        .tablesorterPager2(pagerOptions)
        .find(".tablesorter2-filter-row td:last input").replaceWith('<a href="<?php echo base_url(); ?>form/" class="reset-filters2 btn btn-warning">Reset</a>');
      });
    </script>




  <script type="text/javascript">
      $(function(){
        // define pager options
        var pagerOptions = {
          // target the pager markup - see the HTML block below
          container: $(".pager1"),
          // output string - default is '{page}/{totalPages}'; possible variables: {page}, {totalPages}, {startRow}, {endRow} and {totalRows}
          output: '{startRow} - {endRow} / {filteredRows} ({totalRows})',
          // if true, the table will remain the same height no matter how many records are displayed. The space is made up by an empty
          // table row set to a height to compensate; default is false
          fixedHeight: true,
          // remove rows from the table to speed up the sort of large tables.
          // setting this to false, only hides the non-visible rows; needed if you plan to add/remove rows with the pager enabled.
          removeRows: false,
          // go to page selector - select dropdown that sets the current page
          cssGoto: '.gotoPage1'
        };
        // Initialize tablesorter
        // ***********************
        $("table1")
        .tablesorter1({
          theme: 'bootstrap',
          headerTemplate : '{content} {icon}', // new in v2.7. Needed to add the bootstrap icon!
          widthFixed: true,
          widgets: ['filter'],
          widgetOptions: {
            filter_reset : '.reset-filters1',
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
        .tablesorterPager1(pagerOptions)
        .find(".tablesorter1-filter-row td:last input").replaceWith('<a href="<?php echo base_url(); ?>form/" class="reset-filters1 btn btn-warning">Reset</a>');
      });
    </script>    
  </body>
</html>
