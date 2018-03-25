<nav class="navbar navbar-inverse" id="forms-subnav">
  <ul class="nav navbar-nav navbar-left navbar-user">
    <li class="dropdown <?php echo (isset($submenu['active']) && $submenu['active'] == 'requests')? 'active' : '' ?>">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Unplanned Project Approval <span class="caret"></span></a>
      <ul class="dropdown-menu">
        <li><a href="/requests/1">Waiting Signature</a></li>
        <li><a href="/requests/2">Approved</a></li>
        <li><a href="/requests/11">Rejected</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="/requests"><b>View All</b></a></li>
      </ul>
    </li>
    <?php if ($owning_company || $is_admin): ?>
      <li class="<?php echo (isset($submenu['active']) && $submenu['active'] == 'owning')? 'active' : '' ?>"><a href="/project_owning">Owning Company Form</a></li>
    <?php endif; ?>
  </ul>
</nav>