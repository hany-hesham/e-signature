<!DOCTYPE html>
<html lang="en">
<head>
<?php $this->load->view('header'); ?>
</head>
<body>
<div id="wrapper">
	<?php $this->load->view('menu') ?>

  <?php if($special_owning): ?>
  <?php $this->load->view('subnav_owning') ?>
  <?php else: ?>
  <?php $this->load->view('subnav') ?>
  <?php endif; ?>

	<div id="page-wrapper">
  <?php if ($isGM || $isDptHead): ?>
    <a href="/projects/prepare" class="btn btn-success">New Project (planned)</a><br /><br />
  <?php endif ?>
  <?php if ($is_admin || $user_id==420): ?>
    <a href="/requests/request" class="btn btn-info">Request Unplanned Project Approval</a>
  <?php endif; ?>
    <a href="http://pr.sunrise-resorts.com/" class="btn btn-info" style="float: right;">Old Projects</a>
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
          <th class="header">Name <i class="fa fa-sort"></i></th>
          <th class="header">Hotel <i class="fa fa-sort"></i></th>
          <th class="header">Department <i class="fa fa-sort"></i></th>
          <th class="header">Created by <i class="fa fa-sort"></i></th>
          <th class="header">Approvals <i class="fa fa-sort"></i></th>
          <th class="header">Actions </th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($projects as $project): ?>
  			<tr class="active">
  				<td><?php echo $project['id'] ?></td>
  				<td><?php echo $project['project_name'] ?></td>
  				<td><?php echo $project['hotel_name'] ?></td>
          <td><?php echo $project['department_name'] ?></td>
          <td><?php echo $project['user_name'] ?></td>
          <td>
            <?php foreach ($project['approvals'] as $approval): ?>
              <?php if (isset($approval['sign'])): ?>
                <div class="signer<?php echo isset($approval['sign']['reject'])? ' rejected' : ' accepted' ?>"><?php echo $approval['sign']['name'] ?></div>
              <?php elseif(isset($approval['queue'])): ?>
                <div class="signer unsigned"><?php echo $approval['role'] ?></div>
              <?php endif ?>
            <?php endforeach ?>
          </td>



  				<td><a href="<?php echo base_url(); ?>requests/view/<?php echo $project['id'] ?>" class="btn btn-primary">View</a></td>
          <?php /* if($owning_company): ?>
            <td><a href="<?php echo base_url(); ?>forms/owningcompany/<?php echo $form['id'] ?>" class="btn btn-warning">View</a></td>
          <?php endif; */ ?>
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