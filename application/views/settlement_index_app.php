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
          <li class="<?php echo (isset($submenu['active']) && $submenu['active'] == 'quality')? 'active' : '' ?>"><a href="/settlement/index">All</a></li>
          <li class="<?php echo (isset($submenu['active']) && $submenu['active'] == 'quality')? 'active' : '' ?>"><a href="/settlement/index_app">Approved</a></li>
          <li class="<?php echo (isset($submenu['active']) && $submenu['active'] == 'quality')? 'active' : '' ?>"><a href="/settlement/index_wat">Waiting Approval</a></li>
          <li class="<?php echo (isset($submenu['active']) && $submenu['active'] == 'quality')? 'active' : '' ?>"><a href="/settlement/index_rej">Rejected</a></li>
          <li class="<?php echo (isset($submenu['active']) && $submenu['active'] == 'quality')? 'active' : '' ?>"><a href="/settlement/index_close">Closed Cases</a></li>
        </ul>
      </nav>
        <div id="page-wrapper">
          <a href="<?php echo base_url(); ?>settlement/submit/" class="btn btn-info">New Settlement</a>
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
              <th class="header">File Name<i class="fa fa-sort"></i></th>
              <th class="header">Date<i class="fa fa-sort"></i></th>
              <th class="header">Valid Till<i class="fa fa-sort"></i></th>
              <th class="header">Purpose of Report<i class="fa fa-sort"></i></th>
              <th class="header" style="width: 180px;">Remaining Days To Increase The Amount<i class="fa fa-sort"></i></th>
              <th class="header">Recovered Amount<i class="fa fa-sort"></i></th>
              <th class="header">Type<i class="fa fa-sort"></i></th>
              <th class="header">Close Case Amount<i class="fa fa-sort"></i></th>
              <th class="header">Closed Case<i class="fa fa-sort"></i></th>
              <th class="header">Status<i class="fa fa-sort"></i></th>
              <th class="header">Action<i class="fa fa-sort"></i></th>
              <th class="header">Authorized by<i class="fa fa-sort"></i></th>
            </tr>
          </thead>
          <tbody>
          <?php /*$date1 = strtotime($forma['Date_till']);
                    $date2 = strtotime(date("Y-m-d H:i:s"));
                    $date = $date1 - $date2; 
                    $years = floor(-36573901 / (365*60*60*24));
                    $months = floor((-36573901 - $years * 365*60*60*24) / (30*60*60*24));
                    $days = floor((-36573901 - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                    $hours = floor((-36573901 - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)/ (60*60)); 
                    $minuts  = floor((-36573901 - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60);
                    $seconds = floor((-36573901 - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60 - $minuts*60)); 
                    */?>
          <?php //die(print_r($seconds)) ?>
          <?php //die(print_r(14800609201 - 14804266591)) ?>
          <?php //die(print_r(strtotime("11/25/2016 9:02 AM"))); ?>
          <?php //die(print_r(strtotime(date("Y-m-d H:i:s")))); ?>
            <?php foreach($settlement as $forma ){?>
              <?php if ($forma['state_id'] =='2'){?>
            <tr class="active">
              <td><?php echo $forma['id'] ?></td>
              <td><?php echo $forma['hotel_name'] ?></td>
              <td><?php echo $forma['File'] ?></td>
              <td><?php echo $forma['Date'] ?></td>
              <td><?php echo $forma['Date_till'] ?></td>
              <td>
              <?php if (isset($forma['set_id'])):?>
                <a href="<?php echo base_url(); ?>settlement/purpose_view/<?php echo $forma['id'] ?>" class="btn btn-primary" style="width: 120px;">Show Purpose</a>
      <?php elseif(!isset($forma['set_id'])):?>
                <a href="<?php echo base_url(); ?>settlement/submit_purpose/<?php echo $forma['id'] ?>" class="btn btn-primary" style="width: 120px;">Add Purpose</a>
      <?php endif;?>
                <br>
              </td>
            <?php if ($forma['state_id'] !='0' && $forma['state_id'] !='2' && $forma['state_id'] !='3'){?>
              <?php $date1 = strtotime($forma['Date_till']);
                    $date2 = strtotime(date("Y-m-d H:i:s"));
                    $vall = 0;
                    if ($date1 >= $date2) {
                    $date = $date1 - $date2; 
                    $vall = 1;
                  }else{
                    $date = $date2 - $date1; 
                    $vall = 2;
                  }
                    $years = floor($date / (365*60*60*24));
                    $months = floor(($date - $years * 365*60*60*24) / (30*60*60*24));
                    $days = floor(($date - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                    $hours = floor(($date - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)/ (60*60)); 
                    $minuts  = floor(($date - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60);
                    $seconds = floor(($date - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60 - $minuts*60)); 
                    ?>
              <td><?php echo (strtotime($forma['Date_till']) >= strtotime(date("Y-m-d H:i:s")))? "Valid Till <br>":"Not Valid For <br>";
              echo $months." Monthes <br>"; 
              echo $days." Days <br>";
              echo $hours." Hours <br>";?></td>
            <?php }elseif ($forma['state_id'] =='2') {?>
              <td><?php echo "Settled"; ?></td>
            <?php }elseif ($forma['state_id'] =='3') {?>
              <td><?php echo "Rejected"; ?></td>
            <?php } ?>
              <td><?php echo $forma['amount'] ?><?php echo $forma['currency'] ?></td>
              <td><?php echo $forma['type'] ?></td>
              <td>
                <?php if ($forma['actual'] =='0'){?>
                  <form action="/settlement/actual/<?php echo $forma['id']; ?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
                    <input type="text" name="actual" class="form-control" class="form-control"/>
                    <input name="submit" value="Submit" type="submit" class="btn btn-success" />
                  </form>
                <?php }else{
                  echo $forma['actual'];
                }?>
              </td>
              <td><a href="<?php echo base_url();?>settlement/<?php echo ($forma['closed'] == '1')? 'unclose': 'close'?>/<?php echo $forma['id'] ?>" class="btn <?php echo ($forma['closed'] == '1')? 'btn-success' : 'btn-danger' ?>"><?php echo ($forma['closed'] == '1')? 'Closed' : 'Close Case' ?></a></td>
              <td style="font-size: 12px !important;">
                <?php if (!$forma['status']){?>
                  <form action="/settlement/status/<?php echo $forma['id']; ?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
                    <select class="form-control" name="status">
                      <option value=""></option>
                      <option value="Settlement Proposal rejected by TC">Settlement Proposal rejected by TC</option>
                      <option value="Settlement proposed to SUNRISE">Settlement proposed to SUNRISE</option>
                      <option value="Settlement proposed to TO">Settlement proposed to TO</option>
                      <option value="Signed SAF not sent due to general update has been requested">Signed SAF not sent due to general update has been requested</option>
                      <option value="Signed SAF not sent due toTC have admitted liability">Signed SAF not sent due toTC have admitted liability</option>
                      <option value="Signed SAF not sent due to liability due date has passed">Signed SAF not sent due to liability due date has passed</option>
                      <option value="Settlement proposed to TO and accepted, the claim is closed">Settlement proposed to TO and accepted, the claim is closed </option>
                      <option value="Signed SAF not sent due toTC denial of liability">Signed SAF not sent due toTC denial of liability</option>
                      <option value="Signed SAF not sent due to defence issued by CCRM after claim revision">Signed SAF not sent due to defence issued by CCRM after claim revision</option>
                      <option value="Settlement proposed to SUNRISE but not required due to defence issued by CCRM after claim revision">Settlement proposed to SUNRISE but not required due to defence issued by CCRM after claim revision</option>
                      <option value="Signed SAF not sent to TO as Liability date passed">Signed SAF not sent to TO as Liability date passed</option>
                      <option value="Signed SAF not sent to TO as Update from TC is that claim is at settlement negotiation stage">Signed SAF not sent to TO as Update from TC is that claim is at settlement negotiation stage</option>
                      <option value="Signed SAF not sent to TO as update from TO has been requested">Signed SAF not sent to TO as update from TO has been requested</option>
                      <option value="SAF unsigned and Liability date passed">SAF unsigned and Liability date passed</option>
                      <option value="SAF unsigned and Update from TC is that claim is at settlement negotiation stage">SAF unsigned and Update from TC is that claim is at settlement negotiation stage</option>
                      <option value="Case Closed and Settlement Proposal accepted by TO">Case Closed and Settlement Proposal accepted by TO</option>
                      <option value="TO have denied liability">TO have denied liability</option>
                      <option value="Signed SAF not sent to TO as CCRM reviewed further and defended">Signed SAF not sent to TO as CCRM reviewed further and defended</option>
                    </select>
                    <input name="submit" value="Submit" type="submit" class="btn btn-success" />
                  </form>
                <?php }else{ ?>
                  <?php echo $forma['status']; ?>
                  <form action="/settlement/status/<?php echo $forma['id']; ?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
                    <select class="form-control" name="status">
                      <option value="<?php echo $forma['status']; ?>"><?php echo $forma['status']; ?></option>
                      <option value="Settlement Proposal rejected by TC">Settlement Proposal rejected by TC</option>
                      <option value="Settlement proposed to SUNRISE">Settlement proposed to SUNRISE</option>
                      <option value="Settlement proposed to TO">Settlement proposed to TO</option>
                      <option value="Signed SAF not sent due to general update has been requested">Signed SAF not sent due to general update has been requested</option>
                      <option value="Signed SAF not sent due toTC have admitted liability">Signed SAF not sent due toTC have admitted liability</option>
                      <option value="Signed SAF not sent due to liability due date has passed">Signed SAF not sent due to liability due date has passed</option>
                      <option value="Settlement proposed to TO and accepted, the claim is closed">Settlement proposed to TO and accepted, the claim is closed </option>
                      <option value="Signed SAF not sent due toTC denial of liability">Signed SAF not sent due toTC denial of liability</option>
                      <option value="Signed SAF not sent due to defence issued by CCRM after claim revision">Signed SAF not sent due to defence issued by CCRM after claim revision</option>
                      <option value="Settlement proposed to SUNRISE but not required due to defence issued by CCRM after claim revision">Settlement proposed to SUNRISE but not required due to defence issued by CCRM after claim revision</option>
                      <option value="Signed SAF not sent to TO as Liability date passed">Signed SAF not sent to TO as Liability date passed</option>
                      <option value="Signed SAF not sent to TO as Update from TC is that claim is at settlement negotiation stage">Signed SAF not sent to TO as Update from TC is that claim is at settlement negotiation stage</option>
                      <option value="Signed SAF not sent to TO as update from TO has been requested">Signed SAF not sent to TO as update from TO has been requested</option>
                      <option value="SAF unsigned and Liability date passed">SAF unsigned and Liability date passed</option>
                      <option value="SAF unsigned and Update from TC is that claim is at settlement negotiation stage">SAF unsigned and Update from TC is that claim is at settlement negotiation stage</option>
                      <option value="Case Closed and Settlement Proposal accepted by TO">Case Closed and Settlement Proposal accepted by TO</option>
                      <option value="TO have denied liability">TO have denied liability</option>
                      <option value="Signed SAF not sent to TO as CCRM reviewed further and defended">Signed SAF not sent to TO as CCRM reviewed further and defended</option>
                    </select>
                    <input name="submit" value="Submit" type="submit" class="btn btn-success" />
                  </form>
                <?php } ?>
              </td>
              <td><a href="<?php echo base_url(); ?>settlement/view/<?php echo $forma['id'] ?> " class="btn btn-primary">View</a></td>
              <td>
                <?php foreach ($forma['approvals'] as $approval): ?>
                <?php if (isset($approval['sign'])): ?>
                <div class="signer<?php echo isset($approval['sign']['reject'])? ' rejected' : ' accepted' ?>">
                <?php echo $approval['sign']['name'] ?></div>
                <?php elseif(isset($approval['queue'])): ?>
                <div class="signer unsigned"><?php echo $approval['role'] ?></div>
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
        .find(".tablesorter-filter-row td:last input").replaceWith('<a href="<?php echo base_url(); ?>settlement/" class="reset-filters btn btn-warning">Reset</a>');
      });
    </script>
  </body>
</html>
