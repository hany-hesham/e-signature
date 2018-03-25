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
          <li class="<?php echo (isset($submenu['active']) && $submenu['active'] == 'frontoffice')? 'active' : '' ?>"><a href="/amenitys/index">All</a></li>
          <li class="<?php echo (isset($submenu['active']) && $submenu['active'] == 'frontoffice')? 'active' : '' ?>"><a href="/amenitys/index_app">Approved</a></li>
          <li class="<?php echo (isset($submenu['active']) && $submenu['active'] == 'frontoffice')? 'active' : '' ?>"><a href="/amenitys/index_wat">Waiting Approval</a></li>
          <li class="<?php echo (isset($submenu['active']) && $submenu['active'] == 'frontoffice')? 'active' : '' ?>"><a href="/amenitys/index_rej">Rejected</a></li>
          <li class="<?php echo (isset($submenu['active']) && $submenu['active'] == 'frontoffice')? 'active' : '' ?>"><a href="/amenitys/index_dev">Delivered</a></li>
          <li class="<?php echo (isset($submenu['active']) && $submenu['active'] == 'frontoffice')? 'active' : '' ?>"><a href="/amenitys/index_ref">Refilling</a></li>
        </ul>
      </nav>
      <div id="page-wrapper">
          <a href="<?php echo base_url(); ?>amenitys/add/" class="btn btn-info">New Guest Amenity Request</a>
          <a href="<?php echo base_url(); ?>amenity" class="btn btn-success" style="float:right;">Old Amenity</a>
          <br>
          <br>
          <a class="form-actions btn btn-success non-printable" href="/frontoffice" style="float:right;" > Back </a>
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
                    <th class="header">Creation Date<i class="fa fa-sort"></i></th>
                    <th class="header">Date and Time of Delivery<i class="fa fa-sort"></i></th>
                    <th class="header">Treatment<i class="fa fa-sort"></i></th>
                    <th class="header">Room<i class="fa fa-sort"></i></th>
                    <th class="header">Amenity Change<i class="fa fa-sort"></i></th>
                    <th class="header">Type<i class="fa fa-sort"></i></th>
                    <th class="header">Action<i class="fa fa-sort"></i></th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($amenity as $forma ){?>
                    <tr class="active">
                      <td><?php echo $forma['id'] ?></td>
                      <td><?php echo $forma['hotel_name'] ?></td>
                      <td><?php echo $forma['timestamp'] ?></td>
                      <td><?php echo $forma['date_time'] ?></td>
                      <td>
                        <?php foreach ($forma['items'] as $item):?>
                          <?php echo $item['treatment_type'] ?>,
                        <?php endforeach ?>  
                      </td>
                      <td>
                        <?php foreach ($forma['items'] as $item):?>
                          <?php if ($item['amen']){ ?>
                            <span style="font-weight: bold; color: blue;">
                              <?php echo $item['amen']['room_new'] ?>,
                            </span>
                          <?php }else{ ?>
                            <span style="font-weight: bold;">
                              <?php echo $item['room'] ?>,
                            </span>
                          <?php } ?>
                        <?php endforeach ?>  
                      </td>
                      <td>
                        <a href="#" class="btn btn-success"><?php echo $forma['type_name'] ?></a>
                        <?php if ($forma['state_id'] == 2 && ($forma['type_id'] == 1 || $forma['type_id'] == 2)){ ?>
                          <form action="/amenitys/type/<?php echo $forma['id']; ?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
                            <select class="form-control chooosen" name="type_id" style="height:33px;" data-placeholder="Type ...">
                              <option></option>
                              <?php echo ((isset($department_id) && $department_id == 18) || $is_admin)? '<option value="3">Retoure</option>':'' ;?>
                              <?php echo ((isset($department_id) && $department_id == 18) || $is_admin)? '<option value="4">Cancelled</option>':'' ;?>
                              <?php echo ((isset($department_id) && $department_id == 18) || $is_admin)? '<option value="5">No Show</option>':'' ;?>
                              <?php echo ((isset($department_id) && $department_id == 12) || $is_admin)? '<option value="6">Delivered</option>':'' ;?>
                            </select>
                            <input name="submit" value="Submit" type="submit" class="btn btn-warning" />
                          </form>
                        <?php } ?>
                        
                      </td>
                      <td>
                        <?php if($forma['refiller'] == 1): ?>
                          <h5>Refill</h5>
                        <?php else: ?>  
                          <h5>Amenity</h5>
                        <?php endif; ?>  
                      </td>
                      <td>
                        <a href="<?php echo base_url(); ?>amenitys/view/<?php echo $forma['id'] ?> " class="btn btn-primary" style="width: 80px;">View</a>
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
        .find(".tablesorter-filter-row td:last input").replaceWith('<a href="<?php echo base_url(); ?>amenitys/" class="reset-filters btn btn-warning">Reset</a>');
      });
    </script>
  </body>
</html>
