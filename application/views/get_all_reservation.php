<!DOCTYPE html>
<html lang="en">
<head>
<?php $this->load->view('header'); ?>
</head>
<body>
  <div id="wrapper">
        <?php $this->load->view('menu'); ?>
        <div id="page-wrapper">

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
          <th class="header">#<i class="fa fa-sort"></i></th>
           <th class="header">Hotel<i class="fa fa-sort"></i></th>
          <th class="header">Date<i class="fa fa-sort"></i></th>
          <th class="header">Guest Name<i class="fa fa-sort"></i></th>
          <th class="header">Arrival<i class="fa fa-sort"></i></th>
          <th class="header">Recived by<i class="fa fa-sort"></i></th>
          <th class="header">Created by<i class="fa fa-sort"></i></th>
          <th class="header">Status<i class="fa fa-sort"></i></th>
         <th class="header">Action<i class="fa fa-sort"></i></th>
        </tr>
      </thead>
      <tbody>

         <?php foreach($forma_res as $forma ): ?>
           <tr>
      <th><?=$forma->id;?></th>
      <th><?=$forma->hotel;?></th>
      <th><?=$forma->date;?></th>
      <th><?=$forma->name;?></th>
      <th><?=$forma->arrival;?></th>
      <th><?=$forma->recived_by;?></th>
      <th><?=$forma->fullname;?></th>
      <th>
 <?php foreach($GET_Users_Who_Sign as $who ){?>

<?php
if ($who->forma_res_id != $forma->id){

}elseif ($who->forma_res_id == $forma->id and $who->reject == 0 and $who->user_id == 0) {
?>
   <div class="signer unsigned"> <?=$who->role;?></div>
   <?php
      }


 elseif ($who->forma_res_id == $forma->id and $who->reject == 1 and $who->user_id >= 1) {
?>
   <div class="signer rejected"> <?=$who->role;?></div>

<?php
      }



 elseif ($who->forma_res_id == $forma->id and $who->reject == 0 and $who->user_id >= 1) {
?>
   <div class="signer accepted"> <?=$who->role;?></div>

<?php
      }






  }

   ?>
    </th>
    <th><a href="/reservation/view/<?=$forma->id;?>" class="btn btn-primary">View</a></th>

   <?php endforeach; ?>
           <tbody>

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