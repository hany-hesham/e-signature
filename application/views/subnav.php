<nav class="navbar navbar-inverse" id="forms-subnav">
  <ul class="nav navbar-nav navbar-left navbar-user">
    <li class="dropdown <?php echo (isset($submenu['active']) && $submenu['active'] == 'requests')? 'active' : '' ?>">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Unplanned Projects<span class="caret"></span></a>
      <ul class="dropdown-menu">
        <li><a href="/requests/1">Waiting Signature</a></li>
        <li><a href="/requests/2">Approved</a></li>
        <li><a href="/requests/11">Rejected</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="/requests"><b>View All</b></a></li>
      </ul>
    </li>
    <li class="dropdown <?php echo (isset($submenu['active']) && $submenu['active'] == 'projects')? 'active' : '' ?>">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Projects e-Signature <span class="caret"></span></a>
      <ul class="dropdown-menu">
        <li><a href="/projects/4">Waiting Signature</a></li>
        <li><a href="/projects/7">Approved</a></li>
        <li><a href="/projects/12">Rejected</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="/projects"><b>View All</b></a></li>
      </ul>
    </li>
     <li class="dropdown <?php echo (isset($submenu['active']) && $submenu['active'] == 'projects')? 'active' : '' ?>">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Replacements<span class="caret"></span></a>
      <ul class="dropdown-menu">
        <li><a href="/projects/index_replacement/1/4">Waiting Signature</a></li>
        <li><a href="/projects/index_replacement/1/7">Approved</a></li>
        <li><a href="/projects/index_replacement/1/12">Rejected</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="/projects/index_replacement/1"><b>View All</b></a></li>
      </ul>
    </li>
    <li class="dropdown <?php echo (isset($submenu['active']) && $submenu['active'] == 'progress')? 'active' : '' ?>">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Project Status <span class="caret"></span></a>
      <ul class="dropdown-menu">
        <li><a href="/project_progress/1">In-Progress</a></li>
        <li><a href="/project_progress/2">Holding</a></li>
        <li><a href="/project_progress/3">Done</a></li>
        <li><a href="/project_progress/5">Delayed</a></li>
        <li><a href="/project_progress/6">Postponed</a></li>
        <li><a href="/project_progress/4">Cancelled</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="/project_progress"><b>View All</b></a></li>
      </ul>
    </li>
    <?php if ($owning_company || $is_admin): ?>
      <li class="<?php echo (isset($submenu['active']) && $submenu['active'] == 'owning')? 'active' : '' ?>"><a href="/project_owning">Owning Company Form</a></li>
    <?php endif; ?>
  </ul>
</nav>