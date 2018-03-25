<!DOCTYPE html>
<html lang="en">
  <head>
    <?php $this->load->view('header'); ?>
  </head>
  <body>
    <div id="wrapper">
	    <?php $this->load->view('menu') ?>
      <nav class="navbar navbar-inverse" id="forms-subnav">
        <ul class="nav navbar-nav navbar-left navbar-user">
          <li class="<?php echo (isset($submenu['active']) && $submenu['active'] == 'active')? 'active' : '' ?>"><a href="/forms">Active Forms</a></li>
          <li class="<?php echo (isset($submenu['active']) && $submenu['active'] == 'completed')? 'active' : '' ?>"><a href="/forms/confirmed">Completed Forms</a></li>
        </ul>
      </nav>
	    <div id="page-wrapper">
	      <a href="/forms/submit" class="btn btn-info">New Form</a>
      	<br>
      	<br>
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
                <th class="header">No.# <i class="fa fa-sort"></i></th>
                <th class="header">From <i class="fa fa-sort"></i></th>
                <th class="header">To <i class="fa fa-sort"></i></th>
                <th class="header">Department <i class="fa fa-sort"></i></th>
                <th class="header">Issue Date <i class="fa fa-sort"></i></th>
                <th class="header">Approvals <i class="fa fa-sort"></i></th>
                <th class="header">Actions </th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($forms as $form): ?>
          			<tr class="active">
          				<td><?php echo $form['id'] ?></td>
          				<td><?php echo $form['from_hotel'] ?></td>
          				<td><?php echo $form['to_hotel'] ?></td>
                  <td><?php echo $form['department_name'] ?></td>
                  <td><?php echo $form['issue_date'] ?></td>
                  <td>
                    <div class="signer"><?php echo $form['dstn_dpt_head_fullname'] ?></div>
                    <div class="signer"><?php echo $form['dstn_hotel_gm_fullname'] ?></div>
                    <div class="signer"><?php echo $form['dstn_hotel_fc_fullname'] ?></div>
                    <div class="signer"><?php echo $form['src_dpt_head_fullname'] ?></div>
                    <div class="signer"><?php echo $form['src_hotel_gm_fullname'] ?></div>
                    <div class="signer"><?php echo $form['src_hotel_fc_fullname'] ?></div>
                    <div class="signer"><?php echo $form['fin_cluster_fc_fullname'] ?></div>
                    <div class="signer"><?php echo $form['fin_rdof_fullname'] ?></div>
                    <?php if($form['id']!=298 && $form['id']!=300 && $form['id']!=289 && $form['id']!=290 && $form['id']!=297) {?>
                    <div class="signer"><?php echo $form['fin_chrmn_cai_fullname'] ?></div>
                    <?php }else{?>
                      <div class="signer"><?php echo $form['fin_chairman_fullname'] ?></div>
                      <?php }?>
                  </td>
          				<td><a href="<?php echo base_url(); ?>forms/view/<?php echo $form['id'] ?>" class="btn btn-primary">View</a></td>
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
                      },
                      2: {
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